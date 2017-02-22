<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Gradlead\Degree;
use App\Gradlead\Industry;
use App\Gradlead\JobType;
use App\Gradlead\Language;
use App\Gradlead\Major;
use App\Gradlead\Permission;
use App\Gradlead\Skill;
use App\Gradlead\University;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Degrees
    public function degrees()
    {
        $items = Degree::all();
        return $this->json_response($items);
    }
    
    public function storeDegree(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [ 'name' => 'required|max:255' ]);
        $i = new Degree();
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }
    
    public function updateDegree(Request $request, $itemId)
    {
        $user = $request->user();
        $this->validate($request, ['name' => 'required|max:255']);
        $i = Degree::find($itemId);
        if (is_null($i)) {
            return $this->json_response(['Cannot find item to update'], true);    
        }
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }

    public function destroyDegree(Request $request, $itemId)
    {
        $i = Degree::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find item'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
    

    // Industries
    public function industries()
    {
        $items = Industry::all();
        return $this->json_response($items);
    }
    
    public function storeIndustry(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [ 'name' => 'required|max:255' ]);
        $i = new Industry();
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }
    
    public function updateIndustry(Request $request, $itemId)
    {
        $user = $request->user();
        $this->validate($request, ['name' => 'required|max:255']);
        $i = Industry::find($itemId);
        if (is_null($i)) {
            return $this->json_response(['Cannot find item to update'], true);    
        }
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }

    public function destroyIndustry(Request $request, $itemId)
    {
        $i = Industry::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find item'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
    
    
    // Job Types
    public function jobTypes()
    {
        $items = JobType::all();
        return $this->json_response($items);
    }
    
    public function storeJobType(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [ 'name' => 'required|max:255' ]);
        $i = new JobType();
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }
    
    public function updateJobType(Request $request, $itemId)
    {
        $user = $request->user();
        $this->validate($request, ['name' => 'required|max:255']);
        $i = JobType::find($itemId);
        if (is_null($i)) {
            return $this->json_response(['Cannot find item to update'], true);    
        }
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }

    public function destroyJobType(Request $request, $itemId)
    {
        $i = JobType::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find item'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
    
    // Languages
    public function languages()
    {
        $items = Language::all();
        return $this->json_response($items);
    }
    
    public function storeLanguage(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [ 'name' => 'required|max:255' ]);
        $i = new Language();
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }
    
    public function updateLanguage(Request $request, $itemId)
    {
        $user = $request->user();
        $this->validate($request, ['name' => 'required|max:255']);
        $i = Language::find($itemId);
        if (is_null($i)) {
            return $this->json_response(['Cannot find item to update'], true);    
        }
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }

    public function destroyLanguage(Request $request, $itemId)
    {
        $i = Language::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find item'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
    
    // Majors
    public function majors()
    {
        $items = Major::all();
        return $this->json_response($items);
    }
    
    public function storeMajor(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [ 'name' => 'required|max:255','category'=>'required|max:255' ]);
        $i = new Major();
        $i->name = $request->name;
        $i->category = $request->category;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }
    
    public function updateMajor(Request $request, $itemId)
    {
        $user = $request->user();
        $this->validate($request, [ 'name' => 'required|max:255','category'=>'required|max:255' ]);
        $i = Major::find($itemId);
        if (is_null($i)) {
            return $this->json_response(['Cannot find item to update'], true);    
        }
        $i->name = $request->name;
        $i->category = $request->category;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }

    public function destroyMajor(Request $request, $itemId)
    {
        $i = Major::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find item'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
    
    // Permissions
    public function permissions()
    {
        $items = Permission::all();
        return $this->json_response($items);
    }
    
    public function storePermission(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [ 
            'organization_id' => 'required|exists:organizations,id', 
            'preselect' => 'required', 
            'screening' => 'required', 
            'tracking' => 'required', 
            'badges' => 'required', 
            'events' => 'required', 
        ]);

        $i = new Permission();
        $i->organization_id = $request->organization_id;
        $i->preselect = $request->preselect;
        $i->screening = $request->screening;
        $i->tracking = $request->tracking;
        $i->badges = $request->badges;
        $i->events = $request->events;
        $i->modified_by = $user->id;
        $i->save();

        return $this->json_response($i);
    }
    
    public function updatePermission(Request $request, $itemId)
    {
        $user = $request->user();

        $this->validate($request, [ 
            'organization_id' => 'required|exists:organizations,id', 
            'preselect' => 'required', 
            'screening' => 'required', 
            'tracking' => 'required', 
            'badges' => 'required', 
            'events' => 'required', 
        ]);

        $i = Permission::find($itemId);

        if (is_null($i)) {
            return $this->json_response(['Cannot find item to update'], true);    
        }

        $i->organization_id = $request->organization_id;
        $i->preselect = $request->preselect;
        $i->screening = $request->screening;
        $i->tracking = $request->tracking;
        $i->badges = $request->badges;
        $i->events = $request->events;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }


    
    // Skills
    public function skills()
    {
        $items = Skill::all();
        return $this->json_response($items);
    }
    
    public function storeSkill(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [ 'name' => 'required|max:255' ]);
        $i = new Skill();
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }
    
    public function updateSkill(Request $request, $itemId)
    {
        $user = $request->user();
        $this->validate($request, ['name' => 'required|max:255']);
        $i = Skill::find($itemId);
        if (is_null($i)) {
            return $this->json_response(['Cannot find item to update'], true);    
        }
        $i->name = $request->name;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }

    public function destroySkill(Request $request, $itemId)
    {
        $i = Skill::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find item'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
    
    // University
    public function universities()
    {
        $items = University::where('country','GH')->get();
        return $this->json_response($items);
    }
    
    public function storeUniversity(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [ 'name' => 'required|max:255','country'=>'required|max:255' ]);
        $i = new University();
        $i->name = $request->name;
        $i->country = $request->country;
        $i->website = (isset($request->website))? $request->website : null;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }
    
    public function updateUniversity(Request $request, $itemId)
    {
        $user = $request->user();
        $this->validate($request, [ 'name' => 'required|max:255','country'=>'required|max:255' ]);
        $i = University::find($itemId);
        if (is_null($i)) {
            return $this->json_response(['Cannot find item to update'], true);    
        }
        $i->name = $request->name;
        $i->country = $request->country;
        $i->website = (isset($request->website))? $request->website : null;
        $i->modified_by = $user->id;
        $i->save();
        return $this->json_response($i);
    }

    public function destroyUniversity(Request $request, $itemId)
    {
        $i = University::find($itemId);
        if (is_null($i)) {
            $this->json_report(['Cannot find item'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    } 
}
