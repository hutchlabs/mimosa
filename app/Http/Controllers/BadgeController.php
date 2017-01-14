<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gradlead\Badge;

class BadgeController extends Controller
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

    public function index()
    {
        $badges = Badge::all();        
        return response()->json($badges);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                   'name' => 'required|max:255|unique:badges,name',
                                   'description' => 'required|max:255',
                                   'filename' => 'required|max:255',
                                   'filepath' => 'required|max:255',
                                  ]
                                );

        // Add badge
        $b = new Badge();
        $b->name = $request->name;
        $b->description = $request->description;
        $b->filename = $request->filename;
        $b->filepath = $request->filepath;
        $b->modified_by = $user->id;
        $b->save();

        return $b;
    }

    public function update(Request $request, $badgeId)
    {
        $user = $request->user();

        $b = Badge::findOrFail($badgeId);

        $this->validate($request, [
                                   'name' => 'required|max:255|unique:badges,name,'.$b->id,
                                   'description' => 'required|max:255',
                                   'filename' => 'required|max:255',
                                   'filepath' => 'required|max:255',
                                  ]
                                );

        // update badge
        $b->name = $request->name;
        $b->description = $request->description;
        $b->filename = $request->filename;
        $b->filepath = $request->filepath;
        $b->modified_by = $user->id;
        $b->save();

        return $b;
    }


    public function destroy(Request $request, $badgeId)
    {
        $b = Badge::findOrFail($badgeId);
        $b->removeAchievements();
        $b->delete();
    }

    // TODO: Handle file uploads
}
