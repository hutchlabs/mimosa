<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Gradlead\Badge;

class BadgeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $badges = Badge::all();
        return $this->json_response($badges);
    }

    public function badgeImage(Request $request, $badgeId) 
    {
        $b = Badge::findOrFail($badgeId);
        return $this->display_image($b->file_path);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
           'name' => 'required|max:255|unique:badges,name',
           'description' => 'required|max:255',
           'image' => 'required|image',
          ]
        );

        $fileInfo = $this->handleFileUpload($request, 'image', 'files/badges/');

        if (is_array($fileInfo)) {
            $b = new Badge();
            $b->name = $request->name;
            $b->description = $request->description;
            $b->file_name = $fileInfo['name'];
            $b->file_path = $fileInfo['path'];
            $b->file_url = $fileInfo['url'];
            $b->modified_by = $user->id;
            $b->save();
        } else {
            return $this->json_response(['image'=>$fileInfo], true, 422);
        }

        return $this->json_response($b);
    }

    public function update(Request $request, $badgeId)
    {
        $user = $request->user();

        $b = Badge::findOrFail($badgeId);

        $this->validate($request, [
           'name' => 'required|max:255|unique:badges,name,'.$b->id,
           'description' => 'required|max:255',
           'image' => 'present|image',
          ]
        );

        // update badge
        if ($request->file('image') <> '') {
            $fileInfo = $this->handleFileUpload($request, 'image', 'files/badges/');
            if (is_array($fileInfo)) {
                $b->file_name = $fileInfo['name'];
                $b->file_path = $fileInfo['path'];
                $b->file_url = $fileInfo['url'];
            } else {
                return $this->json_response(['image'=>$fileInfo], true, 422);
            }
        } 

        $b->name = $request->name;
        $b->description = $request->description;
        $b->modified_by = $user->id;
        $b->save();

        return $this->json_response($b);
    }

    public function destroy(Request $request, $badgeId)
    {
        $b = Badge::findOrFail($badgeId);
        $b->removeAchievements();
        $b->delete();
        return $this->ok();
    }
}
