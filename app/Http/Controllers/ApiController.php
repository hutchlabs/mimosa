<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hash;

use App\User;
use App\Gradlead\Profile;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function __construct()
    {
    }
    
    public function authuser(Request $request)
    {
        $user = (Auth::guest()) ? null : Auth::user();
        return response()->json($user);   
    }

    public function logout(Request $request) 
    {
        Auth::logout(); 
        return response()->json('Ok');
    }
    
    public function authenticate(Request $request)
    {
        if (Auth::check()) { Auth::logout(); }

        $validator = Validator::make($request->all(), 
                  ['email' => 'required|email|exists:users,email',
                    'password'=> 'required|min:3',
                  ]
        );
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            $resp = [];
            if ($errors->has('email')) { $resp['email'] = [$errors->get('email')[0]]; }
            if ($errors->has('password')) { $resp['password'] = [$errors->get('password')[0]]; }
            return $this->json_response($resp, true, 422);
        }
        
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        
        //DB::enableQueryLog();      
        //$dd = DB::getQueryLog();
        //return $this->json_response(['email'=>[$dd],'pass'=>$pass], true, 401);
        
        $user = User::withoutGlobalScope('organization_id')->where('email',$request->email)->first();
        $user->makeVisible('password');
                
        if (!is_null($user)) {
            $pass = Hash::check($request->password,$user->password);
            if ($pass) {
                \Landlord::addTenant('organization_id',$user->organization_id);
                 $pass = Auth::attempt(['email' => $request->email, 
                                        'password' => $request->password,
                                        'organization_id'=>$user->organization_id]);
                $user->makeHidden('password');
                $response = array('data'=>$user, 'errors'=>null);
                return response()->json($response);
            } 
        }

        return $this->json_response(['email'=>['Invalid credentials']], true, 401);
    }

    
    public function registeruser(Request $request)
    {
        
        $validator = Validator::make($request->all(), ['email' => 'required|email|unique:users,email',
                                   'name' => 'required|max:255',
                                   'password'=> 'required|min:6',
                                   'type' => 'required|in:employer,gradlead,graduate,school,student',
                                  ]
        );
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            $resp = [];
            if ($errors->has('email')) { $resp['email'] = [$errors->get('email')[0]]; }
            if ($errors->has('name')) { $resp['name'] =[$errors->get('name')[0]]; }
            if ($errors->has('password')) { $resp['password'] = [$errors->get('password')[0]]; }
            if ($errors->has('type')) { $resp['type'] = [$errors->get('type')[0]]; }

            return $this->json_response($resp, true, 422);
        }

        // Add user
        $u = new User();
        $u->name = $request->name;
        $u->email = $request->email;
        $u->password = bcrypt($request->password);
        $u->type = $request->type;
        $u->organization_id = $request->organization_id;
        $u->role_id = 4; // Member
        $u->modified_by = 1; // Super Admin
        $u->save();
        
        $p = new Profile();
        $p->user_id = $u->id;
        $p->uuid = uniqid();
        $p->modified_by = 1;
        $p->save();
        
        $u = User::find($u->id); // add profile

        return $this->json_response($u);
    }
}
