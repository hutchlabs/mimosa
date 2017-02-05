<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenant = $this->getTenant();
        return view('welcome.index', array('name'=>$tenant->name));
    }
}
