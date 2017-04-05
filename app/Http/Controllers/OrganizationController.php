<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Events\UserCreated;
use App\Gradlead\Organization;
use App\Gradlead\Permission;
use Illuminate\Support\Facades\Hash;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>'featured']);
        $this->middleware('tenant');
    }

    public function index()
    {
        $orgs = Organization::orderBy('name')->get();        
        return $this->json_response($orgs);
    }

    public function featured()
    {
        $orgs = Organization::featured();        
        return $this->json_response($orgs);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                   'name' => 'required|max:255',
                                   'type' => 'required|in:employer,gradlead,school',
                                   'email' => 'required|email|unique:users,email',
                                   'first' => 'required|max:255',
                                   'last' => 'required|max:255',
                                  ]
                                );

        $o = Organization::whereRaw('name=? and type=?',array($request->name, $request->subdomain))->first();

        if(!$o) {
            $o = new Organization();
            $o->name = $request->name;
            $o->type = $request->type;
            list($sub) = explode(' ', strtolower(trim($request->name)), 1);
            $o->subdomain = (in_array($request->type, array('employer','gradlead'))) ? 'localhost' : $sub;
            $o->modified_by = $user->id;
            $o->save();
        
            // Add Admin User
            $u = new User();
            $u->first = $request->first;
            $u->last = $request->last;  
            $u->email = $request->email;
            $u->password = Hash::make(substr(md5($request->last.$request->first),3,6));
            $u->uuid = md5($request->first.time());
            $u->organization_id = $o->id;
            $u->role_id = 2; // Administrator
            $u->type = $request->type;
            $u->modified_by = $user->id;
            $u->save();
                 
            // Add permission record
            $acl = new Permission();
            $acl->organization_id = $o->id;
            if ($request->type=='employer') {  $acl->preselect = 1; }
            if ($request->type=='school') {  $acl->events = 1; }
            $acl->modified_by = $user->id;
            $acl->save();
            
            // Add affiliation if user is school
            if ($request->type=='employer' && $user->organization->type=='school') {
                $this->recruiters()->attach($this->id, ['employer_id'=>$o->id, 
                                                        'modified_by' => $user->id, 
                                                        'approved'=>1]);
            }
                
            event(new UserCreated($u));

            return $this->json_response($o);
        
        } else {
            return $this->json_response(['name' => ['Organization already exists.']], true, 422);
        }
    }
    
    public function addAffiliate(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                   'org_id' => 'required|exists:organizations,id',
                                   'affiliate_id' => 'required|exists:organizations,id',
                                   'type' => 'required|in:recruiter,school',
                                  ]
                                );

        if ($request->type=='school') {
            $this->schools()->attach($request->org_id, ['organization_id'=>$request->affiliate_id, 
                                                        'modified_by' => $user->id, 
                                                        'approved'=>0]);
        } else {
           $this->recruiters()->attach($request->org_id, ['employer_id'=>$request->affiliate_id, 
                                                          'modified_by' => $user->id, 
                                                          'approved'=>1]);
        }

        $o = Organization::find($request->org_id);
        
        return $this->json_response($o);
    }
    
    public function updateAffiliateApproval(Request $request, $affiliationId)
    {
        $user = $request->user();        
        $resp = Organization::updateApprovalStatus($affiliationId, $user->id);
        return ($resp) ? $this->ok() : $this->json_response(['Could not find affiliation'],true,422);
    }

    public function update(Request $request, $orgId)
    {
        $user = $request->user();

        $o = Organization::findOrFail($orgId);

        $this->validate($request, [
                                   'name' => 'required|max:255',
                                   'type' => 'required|in:employer,gradlead,school',
                                  ]
                                );

        // update org
        $o->name = $request->name;
        $o->type = $request->type;
        list($sub) = explode(' ', strtolower(trim($request->name)), 1);
        $o->subdomain = (in_array($request->type, array('employer','gradlead'))) ? 'localhost' : $sub;
        $o->modified_by = $user->id;
        $o->save();

        return $this->json_response($o);
    }

    public function destroy(Request $request, $orgId)
    {
        $user = $request->user();
        
        $i = Organization::find($orgId);
        if (is_null($i)) {
            $this->json_report(['Cannot find organization'], true);
        } else {
            if ($user->organization->type=='school') {
                $i->removeAffiliationFrom($user->organization->id);    
            } else {
                $i->cleanUp();
                $i->delete();
            }
            return $this->ok();
        }
    }
}
