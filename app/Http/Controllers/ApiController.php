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
                
        if ( ($user=$this->signin($user, $request->password, $request->email))!==false)  {
            $response = array('data'=>$user, 'errors'=>null);
            return response()->json($response);
        }

        return $this->json_response(['email'=>['Invalid credentials']], true, 401);
    }
    
    private function signin($user, $rpass, $email)
    {
        if (!is_null($user)) {
            $user->makeVisible('password');
            $pass = Hash::check($rpass,$user->password);
            if ($pass) {
                \Landlord::addTenant('organization_id',$user->organization_id);
                 $pass = Auth::attempt(['email' => $email, 
                                        'password' => $rpass,
                                        'organization_id'=>$user->organization_id]);
                $user->makeHidden('password');
                return $user;
            } 
        }
        return false;
    }

    
    public function registeruser(Request $request)
    {
        
        $validator = Validator::make($request->all(), ['email' => 'required|email|unique:users,email',
                                   'first' => 'required|max:255',
                                   'last' => 'required|max:255',
                                   'password'=> 'required|min:6',
                                   'type' => 'required|in:employer,gradlead,graduate,school,student',
                                  ]
        );
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            $resp = [];
            if ($errors->has('email')) { $resp['email'] = [$errors->get('email')[0]]; }
            if ($errors->has('first')) { $resp['first'] =[$errors->get('first')[0]]; }
            if ($errors->has('last')) { $resp['last'] =[$errors->get('last')[0]]; }
            if ($errors->has('password')) { $resp['password'] = [$errors->get('password')[0]]; }
            if ($errors->has('type')) { $resp['type'] = [$errors->get('type')[0]]; }
            return $this->json_response($resp, true, 422);
        }

        // Add user
        $u = new User();
        $u->first = $request->first;
        $u->last = $request->last;
        $u->email = $request->email;
        $u->uuid = md5(time());
        $u->password = bcrypt($request->password);
        $u->type = $request->type;
        $u->organization_id = 1;
        $u->role_id = 4; // Member
        $u->modified_by = 1; // Super Admin
        $u->save();
        
        $p = new Profile();
        $p->user_id = $u->id;
        $p->modified_by = 1;
        $p->save();
        
        $u = User::find($u->id); // add profile

        if ($this->signin($u, $request->password, $u->email)) {
                return $this->json_response($u);
        } else {
            return $this->json_response(['first'=>['Registered user but could not automatically sign in']], true, 401);
        }
    }
}
