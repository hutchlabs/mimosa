<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Gradlead\Test;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenant = Test::first();        
        return view('welcome', array('name'=>$tenant->organization->name));
    }
}
