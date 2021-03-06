<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('tenant');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        switch(Auth::user()->type) {
            case 'employer': $view = 'dashboards.employer'; break;
            case 'gradlead': $view = 'dashboards.gradlead'; break;
            case 'school': $view = 'dashboards.school'; break;
            case 'student':
            case 'graduate': $view = 'dashboards.student'; break;
            default: $view = 'welcome.index';
        }
            
        return view($view, array('name'=>Auth::user()->organization->name));
    }
}
