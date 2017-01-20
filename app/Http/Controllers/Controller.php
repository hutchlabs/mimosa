<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected function ok()
    {
        return $this->json_response('ok');
    }
    
    protected function json_response($val, $error=false, $code=200)
    {
        if ($error) {
            $response = array('data'=>null, 'error'=>$val);
        } else {
            $response = array('data'=>$val, 'error'=>null);
        }

        return response()->json($response, $code);
    }
    
    protected function display_image($file_path) 
    {
        if ($file_path) {
            $contents = Storage::get($file_path);
            header("Content-Type: ". Storage::mimeType($file_path));
            header("Content-Length: " . Storage::size($file_path));
            echo $contents;
        }
        exit;
    }
    
    protected function handleFileUpload(Request $request, $varname, $storage_path, $fileSizeLimit=20)
    {
        $ONE_MEGA_BYTE = 1048576;

        // save file
        $name = $request->file($varname)->getClientOriginalName();
        $path = $request->file($varname)->store($storage_path);     
        
        $size = Storage::size($path);
        if ($size > ($fileSizeLimit * $ONE_MEGA_BYTE)) {
            Storage::delete($path);
            return "File size exceeds {$fileSizeLimit}MB";
        }
        
        $url = Storage::url($path);
        $mimetype = Storage::mimeType($path);
        
        return array('name'=>$name, 'path'=>$path, 'url'=>$url, 'size'=>$size, 'mimetype'=>$mimetype);
    }
    
    protected function processDestroy($i) 
    {
        if (is_null($i)) {
            return $this->json_report(['Cannot find item'], true);
        } else {
            $i->delete();
            return $this->ok();
        }
    }
}
