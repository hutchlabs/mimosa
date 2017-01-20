<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Gradlead\Job;
use App\Gradlead\Organization;

class SearchController extends Controller
{
    public function findJobs()
    {
        $items = Job::all();
        return $this->json_response($items);
    }

    public function findCandidates()
    {
        $items = User::Candidates();
        return $this->json_response($items);
    }

    public function findEmployers()
    {
        $items = Organization::Employers();
        return $this->json_response($items);
    }
}
