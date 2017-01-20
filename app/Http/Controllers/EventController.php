<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Gradlead\Event;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
           'organization_id' => 'required|exists:organizations,id',
           'name' => 'required|max:255',
           'description' => 'required|max:255',
           'start_date' => 'present',
           'end_date' =>'present'
          ]
        );

        $i = new Event();
        $i->organization_id = $request->organization_id;
        $i->name = $request->name;
        $i->description = $request->description;
        $i->start_date = $request->start_date;
        $i->end_date = $request->end_date;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function update(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'start_date' => 'present',
            'end_date' =>'present'
          ]
        );
        
        $i = Event::find($itemId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find event to update'], true);    
        }
        
        $i->organization_id = $request->organization_id;
        $i->name = $request->name;
        $i->description = $request->description;
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
