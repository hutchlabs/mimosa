<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gradlead\Organization;

class OrganizationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orgs = Organization::all();        
        return response()->json($orgs);
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
                return response()->json(
                    ['subdomain' => ['The subdomain already exists for another organization.']], 422);
            } 
        }

        $o = Organization::whereRaw('name=? and type=?',array($request->name, $request->subdomain))->first();

        if(!$o) {
            // Add org
            $o = new Organization();
            $o->name = $request->name;
            $o->type = $request->type;
            $o->subdomain = (in_array($request->type, array('employer','gradlead'))) ? 'localhost' : $request->subdomain; 
            $o->modified_by = $user->id;
            $o->save();

            return $o;

        } else {
            return response()->json(['name' => ['Organization already exists.']], 422);
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
                                                        'editor'=>$editor]);
        } else {
           $this->recruiters()->attach($request->org_id, ['employer_id'=>$request->affiliate_id, 
                                                          'modified_by' => $user->id, 
                                                          'editor'=>$editor]);
        }

        return Organization::find($request->org_id);
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
                return response()->json(
                    ['subdomain' => ['The subdomain already exists for another organization.']], 422);
            } 
        }

        // update org
        $o->name = $request->name;
        $o->type = $request->type;
        $o->subdomain = (in_array($request->type, array('employer','gradlead'))) ? 'localhost' : $request->subdomain; 
        $o->modified_by = $user->id;
        $o->save();

        return $o;
    }


    public function destroy(Request $request, $orgId)
    {
        $o = Organization::findOrFail($orgId);
        $o->delete();
    }
}
