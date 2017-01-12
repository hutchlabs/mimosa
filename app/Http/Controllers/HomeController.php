<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Gradlead\Test;

class HomeController extends Controller
{

    public function show()
    {
        $tenant = Test::first();        
        return view('welcome', array('name'=>$tenant->organization->name));
    }
}
