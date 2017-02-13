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
    
    public function schools()
    {
        $tenant = $this->getTenant();
        return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'schools'));
    }
    
    public function contact()
    {
        $tenant = $this->getTenant();
        return view('welcome.index', array('name'=>$tenant->name, 'tid'=>$tenant->id, 'theme'=>$this->theme, 'link'=>'contact'));
    }
}
