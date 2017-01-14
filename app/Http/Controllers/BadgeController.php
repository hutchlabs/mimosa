<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function badgeImage(Request $request, $badgeId) 
    {
        $b = Badge::findOrFail($badgeId);

        if ($b) {
            $contents = Storage::get($b->file_path);
            // send the right headers
            header("Content-Type: image/png");
            header("Content-Length: " . Storage::size($b->file_path));

            // dump the picture and stop the script
            echo $contents;
        }
        exit;
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
                                   'name' => 'required|max:255|unique:badges,name',
                                   'description' => 'required|max:255',
                                   'uploaded_file' => 'required',
                                  ]
                                );

        $fileInfo = $this->handleFileUpload($request);

        if (is_array($fileInfo)) {
            // Add badge
            $b = new Badge();
            $b->name = $request->name;
            $b->description = $request->description;
            $b->file_name = $fileInfo['name'];
            $b->file_path = $fileInfo['path'];
            $b->file_url = $fileInfo['url'];
            $b->modified_by = $user->id;
            $b->save();
        } else {
            return response()->json(['uploaded_file' => [$fileInfo]], 422);
        }

        return $b;
    }

    public function update(Request $request, $badgeId)
    {
        $user = $request->user();

        $b = Badge::findOrFail($badgeId);

        $this->validate($request, [
                                   'name' => 'required|max:255|unique:badges,name,'.$b->id,
                                   'description' => 'required|max:255',
                                   'uploaded_file' => 'present',
                                  ]
                                );

        // update badge
        if ($request->uploaded_file <> '') {
            $fileInfo = $this->handleFileUpload($request);
            if (is_array($fileInfo)) {
                $b->file_name = $fileInfo['name'];
                $b->file_path = $fileInfo['path'];
                $b->file_url = $fileInfo['url'];
            } else {
                return response()->json(['uploaded_file' => [$fileInfo]], 422);
            }
        } 

        $b->name = $request->name;
        $b->description = $request->description;
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

    private function handleFileUpload(Request $request, $fileSizeLimit=20)
    {
        $ONE_MEGA_BYTE = 1048576;

        list($type, $data) = explode(';', $request->uploaded_file);
        $ext = str_replace('data:image/','',$type);
        $name = md5($data.time()).'.'.$ext;;
        $path = 'files/badges/'.$name;

        $file = Storage::put($path, $request->uploaded_file);
        $size = Storage::size($path);
        $url = Storage::url($path);

        if ($size > ($fileSizeLimit * $ONE_MEGA_BYTE)) {
            Storage::delete($path);
            return "File size exceeds {$fileSizeLimit}MB";
        }
        
        return array('name'=>$name, 'path'=>$path, 'url'=>$url,'size'=>$size);
    }
}
