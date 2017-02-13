<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gradlead\Theme;

class ThemeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['defaultTheme','editable']]);
    }

    public function index()
    {
        $items = Theme::all();
        return $this->json_response($items);
    }
    
    public function defaultTheme()
    {
        $items = Theme::withoutGlobalScope('organization_id')->find($this->getTenant()->id);
        if (!$items) {
            $items = Theme::withoutGlobalScope('organization_id')->find(1);
        }
        return $this->json_response($items);
    }

    public function editable(Request $request) 
    {
        $this->validate($request, [
           'name' => 'required|max:255',
           'value' => 'required|max:255',
           'pk' => 'required|numeric',
          ]
        );
        
        return $this->json_response('Ok');            
    }                               
                                   
    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
           'home_header' => 'required|max:255',
           'schools_header' => 'required|max:255',
           'contact_header' => 'required|max:255',
           'home_first_title' => 'required|max:255',
           'home_second_title' => 'required|max:255',
           'home_third_title' => 'required|max:255',
           'home_first' => 'required|max:255',
           'home_second' => 'required|max:255',
           'home_third' => 'required|max:255',
           'schools_first_title' => 'required|max:255',
           'schools_second_title' => 'required|max:255',
           'schools_third_title' => 'required|max:255',
           'schools_first' => 'required|max:255',
           'schools_second' => 'required|max:255',
           'schools_third' => 'required|max:255',
           'contact_first_title' => 'required|max:255',
           'contact_second_title' => 'required|max:255',
           'contact_third_title' => 'required|max:255',
           'contact_first' => 'required|max:255',
           'contact_second' => 'required|max:255',
           'contact_third' => 'required|max:255',
           'home_hero' => 'max:255',
           'schools_hero' => 'max:255',
           'contact_hero' => 'max:255',
          ]
        );

        $i = new Theme();
        $i->home_header = $request->home_header;
        $i->schools_header = $request->schools_header;
        $i->contact_header = $request->contact_header;

        $i->home_first_title = $request->home_first_title;
        $i->home_second_title = $request->home_second_title;
        $i->home_third_title = $request->home_third_title;
        $i->home_first = $request->home_first;
        $i->home_second = $request->home_second;
        $i->home_third = $request->home_third;
        
        $i->schools_first_title = $request->schools_first_title;
        $i->schools_second_title = $request->schools_second_title;
        $i->schools_third_title = $request->schools_third_title;
        $i->schools_first = $request->schools_first;
        $i->schools_second = $request->schools_second;
        $i->schools_third = $request->schools_third;
        
        $i->contact_first_title = $request->contact_first_title;
        $i->contact_second_title = $request->contact_second_title;
        $i->contact_third_title = $request->contact_third_title;
        $i->contact_first = $request->contact_first;
        $i->contact_second = $request->contact_second;
        $i->contact_third = $request->contact_third;
       
        $i->home_hero = $request->home_hero;
        $i->schools_hero = $request->schools_hero;
        $i->contact_hero = $request->contact_hero;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }

    public function update(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [
           'home_header' => 'required|max:255',
           'schools_header' => 'required|max:255',
           'contact_header' => 'required|max:255',
           'home_first_title' => 'required|max:255',
           'home_second_title' => 'required|max:255',
           'home_third_title' => 'required|max:255',
           'home_first' => 'required|max:255',
           'home_second' => 'required|max:255',
           'home_third' => 'required|max:255',
           'schools_first_title' => 'required|max:255',
           'schools_second_title' => 'required|max:255',
           'schools_third_title' => 'required|max:255',
           'schools_first' => 'required|max:255',
           'schools_second' => 'required|max:255',
           'schools_third' => 'required|max:255',
           'contact_first_title' => 'required|max:255',
           'contact_second_title' => 'required|max:255',
           'contact_third_title' => 'required|max:255',
           'contact_first' => 'required|max:255',
           'contact_second' => 'required|max:255',
           'contact_third' => 'required|max:255',
           'home_hero' => 'max:255',
           'schools_hero' => 'max:255',
           'contact_hero' => 'max:255',
          ]
        );
        
        $i = Theme::find($itemId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find theme to update'], true);    
        }
        
         $i->home_header = $request->home_header;
        $i->schools_header = $request->schools_header;
        $i->contact_header = $request->contact_header;

        $i->home_first_title = $request->home_first_title;
        $i->home_second_title = $request->home_second_title;
        $i->home_third_title = $request->home_third_title;
        $i->home_first = $request->home_first;
        $i->home_second = $request->home_second;
        $i->home_third = $request->home_third;
        
        $i->schools_first_title = $request->schools_first_title;
        $i->schools_second_title = $request->schools_second_title;
        $i->schools_third_title = $request->schools_third_title;
        $i->schools_first = $request->schools_first;
        $i->schools_second = $request->schools_second;
        $i->schools_third = $request->schools_third;
        
        $i->contact_first_title = $request->contact_first_title;
        $i->contact_second_title = $request->contact_second_title;
        $i->contact_third_title = $request->contact_third_title;
        $i->contact_first = $request->contact_first;
        $i->contact_second = $request->contact_second;
        $i->contact_third = $request->contact_third;
       
        $i->home_hero = $request->home_hero;
        $i->schools_hero = $request->schools_hero;
        $i->contact_hero = $request->contact_hero;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
}
