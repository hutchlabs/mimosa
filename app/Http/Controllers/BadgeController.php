<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return redirect()->action('HomeController@index');
    }

    public function update(Request $request)
    {
        $user = $request->user();


        $this->validate($request, [
           'id' => 'required|exists:badges,id',
           'name' => 'required|max:255|unique:badges,name,'.$request->id,
           'description' => 'required|max:255',
           'image' => 'present',
          ]
        );

        $b = Badge::findOrFail($request->id);

        // update badge
        if ($request->image <> '') {
            $fileInfo = $this->handleFileUpload($request, 'image', 'files/badges/');
            if (is_array($fileInfo)) {
                $this->removeImageFile($b->path);
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
        
        return redirect()->action('HomeController@index');


        //return $this->json_response($b);
    }

    public function destroy(Request $request, $badgeId)
    {
        // TODO: Remove file from disk
        $b = Badge::findOrFail($badgeId);
        $b->removeAchievements();
        $this->removeImageFile($b->file_path);
        $b->delete();
        return $this->ok();
    }
}
