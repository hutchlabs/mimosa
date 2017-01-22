<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Gradlead\Organization;
use App\Gradlead\Permission;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>'featured']);
    }

    public function index()
    {
        $orgs = Organization::all();        
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
                                   'subdomain' => 'required|max:255',
                                   'name' => 'required|max:255',
                                   'type' => 'required|in:employer,gradlead,school',
                                  ]
                                );

        if ($request->type=='school') {
            $o = Organization::where('subdomain',$request->subdomin)->first();
            if ($o) {
                return $this->json_response(['subdomain' => ['The subdomain already exists for another organization.']], true, 422);
            } 
        }

        $o = Organization::whereRaw('name=? and type=?',array($request->name, $request->subdomain))->first();

        if(!$o) {
            $o = new Organization();
            $o->name = $request->name;
            $o->type = $request->type;
            $o->subdomain = (in_array($request->type, array('employer','gradlead'))) ? 'localhost' : $request->subdomain; 
            $o->modified_by = $user->id;
            $o->save();
        
            // Add permission record
            $acl = new Plugin();
            $acl->organization_id = $o->id;
            $acl->save();
            
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
                                   'subdomain' => 'required|max:255',
                                   'name' => 'required|max:255',
                                   'type' => 'required|in:employer,gradlead,school',
                                  ]
                                );

        if ($request->type=='school') {
            $t = Organization::where('subdomain',$request->subdomin)->first();
            if ($t && ($o->id != $t->id)) {
                $this->json_response(
                    ['subdomain' => ['The subdomain already exists for another organization.']],true,422);
            } 
        }

        // update org
        $o->name = $request->name;
        $o->type = $request->type;
        $o->subdomain = (in_array($request->type, array('employer','gradlead'))) ? 'localhost' : $request->subdomain; 
        $o->modified_by = $user->id;
        $o->save();

        return $this->json_response($o);
    }

    public function destroy(Request $request, $orgId)
    {
        $i = Organization::find($orgId);
        if (is_null($i)) {
            $this->json_report(['Cannot find organization'], true);
        } else {
            $i->cleanUp();
            $i->delete();
            return $this->ok();
        }
    }
}
