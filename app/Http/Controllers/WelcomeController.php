<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Gradlead\Theme;

class WelcomeController extends Controller
{
    private $theme = null;
    
    public function __construct()
    {
        $tid = (Auth::check()) ? Auth::user()->organization_id : $this->getTenant()->id;
        $items = Theme::withoutGlobalScope('organization_id')->find($tid);
        if (!$items) {
            $items = Theme::withoutGlobalScope('organization_id')->find(1);
        }
        $this->theme = $items;
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenant = $this->getTenant();
        return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'home'));
    }
   
    public function jobs(Request $request)
    {
        $tenant = $this->getTenant();
        $jobs = [];
        $q = '';
        $loc = '';
               
        if (isset($request->q) && ($request->q<>'' || $request->loc<>'')) {
            $jobs = \App\Gradlead\Job::search(null, $request->q, $request->loc);
            $q = $request->q;
            $loc = $request->loc;
            $jobs = json_decode(json_encode($jobs['all']), FALSE);
        } else {
            $jobs = \App\Gradlead\Job::Active();
        }
        
        return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'jobs', 'jobs'=>$jobs, 'q'=>$q,'loc'=>$loc));
    }
    
    public function employers(Request $request)
    {
        $tenant = $this->getTenant();
        $orgs = [];
        $q = '';
        $loc = '';
        
        if (isset($request->q) && ($request->q<>'' || $request->loc<>'')) {
            $orgs = \App\Gradlead\Organization::search($request->q, $request->loc);
            $orgs = $orgs['all'];
            $q = $request->q;
            $loc = $request->loc;
        } else {
            $orgs = \App\Gradlead\Organization::employers();
        }
        return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'employers','orgs'=>$orgs ,'q'=>$q,'loc'=>$loc));
    }
        
    public function partners()
    {
        $tenant = $this->getTenant();
        return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'partners'));
    }
    
    public function contact()
    {
        $tenant = $this->getTenant();
        return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'contact'));
    }
    
    public function publicProfile($id)
    {
        $p = \App\Gradlead\Profile::getPublicProfile($id);
        
        if ($p) {
            $tenant = $this->getTenant();
            return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'profile','profile'=>$p));
        }
        
        abort(404);
    }
    
    public function publicOrg($id)
    {
        $i = \App\Gradlead\Organization::find($id);
        
        if ($i) {
            $tenant = $this->getTenant();
            return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'employers-profile','profile'=>$i));
        }
        
        abort(404);
    }
    
    public function publicJob($id)
    {
        $i = \App\Gradlead\Job::find($id);
        
        if ($i) {
            $tenant = $this->getTenant();
            return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'jobs-profile','job'=>$i));
        }
        
        abort(404);
    }
}
