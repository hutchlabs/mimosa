<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Gradlead\Plan;
use App\Gradlead\Contract;


class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('tenant');
    }
    
    public function index()
    {
        $items = Plan::all();
        return $this->json_response($items);
    }
    
    public function contracts()
    {
        $items = Contract::all();
        return $this->json_response($items);
    }
    
    public function storeContract(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
           'organization_id' => 'required|exists:organizations,id',
           'plan_id' => 'required|exists:plans,id',
          ]
        );

        $p = Plan::find($request->plan_id);
            
        $c = new Contract();
        $c->organization_id = $request->organization_id;
        $c->plan_id = $p->id;
        $c->remaining_posts = $p->num_posts - 1;
        $c->remaining_notifications = $p->num_notifications;
        $c->start_date = date('Y-m-d');
        $c->end_date = date('Y-m-d',strtotime($c->start_date." +".$p->duration." days"));
        $c->modified_by = $user->id;
        $c->save();
        
        Contract::createInvoice($c);

        return $this->json_response($c);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
           'name' => 'required|max:255',
           'description' => 'required',
           'cost' => 'required|numeric',
           'num_posts' => 'required|numeric',
           'num_notifications'=> 'required|numeric',
           'feature_job' => 'required|boolean',
           'feature_company' => 'required|boolean',
           'duration' => 'required|numeric',
           'start_date' => 'required|date',
           'end_date' =>'required|date'
          ]
        );

        // 1. Create Plan
        $i = new Plan();
        $i->name = $request->name;
        $i->description = $request->description;
        $i->num_posts = $request->num_posts;
        $i->num_notifications = $request->num_notifications;
        $i->feature_job = $request->feature_job;
        $i->feature_company = $request->feature_company;
        $i->duration = $request->duration;
        $i->start_date = date('Y-m-d', strtotime($request->start_date));
        $i->end_date = date('Y-m-d',strtotime($request->end_date));
        $i->modified_by = $user->id;
        $i->save();
        
        return $this->json_response($i);
    }

    public function update(Request $request, $itemId)
    {
       $user = $request->user();

        $this->validate($request, [
           'id' => 'required|exists:plans,id',
           'name' => 'required|max:255',
           'description' => 'required',
           'num_posts' => 'required|numeric',
           'num_notifications'=> 'required|numeric',
           'feature_job' => 'required|boolean',
           'feature_company' => 'required|boolean',
           'duration' => 'required|numeric',
           'start_date' => 'required|date',
           'end_date' =>'required|date'
          ]
        );

        // 1. Create Plan
        $i = Plan::find($request->id);
        $i->name = $request->name;
        $i->description = $request->description;
        $i->num_posts = $request->num_posts;
        $i->num_notifications = $request->num_notifications;
        $i->feature_job = $request->feature_job;
        $i->feature_company = $request->feature_company;
        $i->duration = $request->duration;
        $i->start_date = date('Y-m-d', strtotime($request->start_date));
        $i->end_date = date('Y-m-d',strtotime($request->end_date));
        $i->modified_by = $user->id;
        $i->save();
        
        return $this->json_response($i);
    }

    public function destroy(Request $request, $itemId)
    {
        $i = Plan::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find Plan'], true);
        } else {
            $i->contracts()->detach();
            $i->delete();
            return $this->ok();
        }
    }
    
    public function destroyContract(Request $request, $itemId)
    {
        $i = Contract::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find Contract'], true);
        } else {
            $i->remaining_posts = 0;
            $i->remaining_notifications = 0;
            $i->end_date = date('Y-m-d');
            $i->save();
            return $this->ok();
        }
    }
}
