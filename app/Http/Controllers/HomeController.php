<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Gradlead\Test;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenant = Test::first();        
        return view('home', array('name'=>$tenant->organization->name));
    }
}
