<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gradlead\Event;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('tenant');
    }

    public function index()
    {
        $items = Event::all();
        return $this->json_response($items);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
           //'organization_id' => 'required|exists:organizations,id',
           'name' => 'required|max:255',
           'description' => 'required|max:255',
           'start_date' => 'required|date',
           'end_date' =>'required|date'
          ]
        );

        $i = new Event();
        //$i->organization_id = $request->organization_id;
        $i->name = $request->name;
        $i->description = $request->description;
        $i->start_date = date('Y-m=d', strtotime($request->start_date));
        $i->end_date = date('Y-m-d', strtotime($request->end_date));
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function update(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            //'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' =>'required|date',
          ]
        );
        
        $i = Event::find($itemId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find event to update'], true);    
        }
        
       // $i->organization_id = $request->organization_id;
        $i->name = $request->name;
        $i->description = $request->description;
        $i->start_date = date('Y-m=d', strtotime($request->start_date));
        $i->end_date = date('Y-m-d', strtotime($request->end_date));
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function destroy(Request $request, $itemId)
    {
        $i = Event::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find Event'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
}
