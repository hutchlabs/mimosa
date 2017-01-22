<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Gradlead\Achievement;
use App\Gradlead\Address;
use App\Gradlead\Alert;
use App\Gradlead\Badge;
use App\Gradlead\Bookmark;
use App\Gradlead\Profile;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function addAddress(Request $request) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['user_id' => 'required|exists:users,id',
                         'country' => 'required:max:255',
                         'region' =>  'required:max:255',
                         'city' =>    'required:max:255']);
        
        $i = new Address();
        $i->user_id = $request->user_id;
        $i->country = $request->country;
        $i->region = $request->region;
        $i->city = $request->city;
        $i->area = $request->area;
        $i->street = $request->street;
        $i->modified_by = $user->id;
        $i->save();
                
        return $this->ok();
    }
    
    public function updateAddress(Request $request, $addressId) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['id'=> 'required|exists:users_address,id',
                         'user_id' => 'required|exists:users,id',
                         'country' => 'required:max:255',
                         'region' =>  'required:max:255',
                         'city' =>    'required:max:255']);
        
        $i = Address::find($request->id);
        $i->user_id = $request->user_id;
        $i->country = $request->country;
        $i->region = $request->region;
        $i->city = $request->city;
        $i->area = $request->area;
        $i->street = $request->street;
        $i->modified_by = $user->id;
        $i->save();
                
        return $this->ok();
    }
    
    public function destroyAddress(Request $request, $addressId) 
    {
        $i = Address::find($addressId);
        if ($i) {
            $i->delete();
            return $this->ok();
        } else {
            return $this->json_response(['Cannot find address'], true);
        }
    }
    
    
    public function alert(Request $request) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['user_id' => 'required|exists:users,id',
                         'name' => 'required:max:255',
                         'frequency' => 'required']);
        
        $i = new Alert();
        $i->user_id = $request->user_id;
        $i->name = $request->name;
        $i->location = $request->location;
        $i->category = $request->category;
        $i->job_type = $request->job_type;
        $i->language = $request->language;
        $i->frequency = $request->frequency;
        $i->modified_by = $user->id;
        $i->save();
        
        $i->createSchedule();
        
        return $this->ok();
    }
    
    public function updateAlert(Request $request, $alertId) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['id'=>'required|exists:users_alerts,id',
                         'user_id' => 'required|exists:users,id',
                         'name' => 'required:max:255',
                         'frequency' => 'required']);
        
        $i = Alert::find($request->id);
        $i->user_id = $request->user_id;
        $i->name = $request->name;
        $i->location = $request->location;
        $i->category = $request->category;
        $i->job_type = $request->job_type;
        $i->language = $request->language;
        $i->frequency = $request->frequency;
        $i->modified_by = $user->id;
        $i->save();
        
        $i->createSchedule();
        
        return $this->ok();
    }
    
    public function unalert(Request $request, $alertId) 
    {
        $i = Alert::find($alertId);
        if ($i) {
            $i->delete();
            return $this->ok();
        } else {
            return $this->json_response(['Cannot find alert'], true);
        }
    }
    
    public function merit(Request $request) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['user_id' => 'required|exists:users,id',
                         'badge_id' => 'required|exists:badges,id']);

        $a = new Achievement();
        $a->user_id = $request->user_id;
        $a->badge_id = $request->badge_id;
        $a->modified_by = $user->id;
        $a->save();
        
        return $this->ok();
    }
    
    public function demerit(Request $request, $achievementId) 
    {
        $a = Achievement::find($achievementId);
        if ($a) {
            $a->delete();
            return $this->ok();
        } else {
            return $this->json_response(['Cannot find achievement'], true);
        }
    }
    
    public function bookmark(Request $request) 
    {
        $user = $request->user();
        
        $this->validate($request, 
                        ['user_id' => 'required|exists:users,id',
                         'url' => 'required|max:255']);
        
        $i = new Bookmark();
        $i->user_id = $request->user_id;
        $i->url = $request->url;
        $i->modified_by = $user->id;
        $i->save();
              
        return $this->ok();
    }
    
    public function unbookmark(Request $request, $bookmarkId) 
    {
        $i = Bookmark::find($bookmarkId);
        if ($i) {
            $i->delete();
            return $this->ok();
        } else {
            return $this->json_response(['Cannot find bookmark'], true);
        }
    }
    
    
    //--------------------
    
    public function index()
    {
        $users = User::all();        
        return $this->json_response($users);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, ['email' => 'required|email|unique:users,email',
                                   'name' => 'required|max:255',
                                   'password'=> 'required|min:6',
                                   'role_id' => 'required|exists:roles,id',
                                   'organization_id' => 'required|exists:organizations,id',
                                   'type' => 'required|in:employer,gradlead,graduate,school,student',
                                  ]
                                );

        // Add user
        $u = new User();
        $u->name = $request->name;
        $u->email = $request->email;
        $u->password = Hash::make($request->password);
        $u->organization_id = $request->organization_id;
        $u->role_id = $request->role_id;
        $u->type = $request->type;
        $u->modified_by = $user->id;
        $u->save();

        if ($u->isStudent()) {
            $p = new Profile();
            $p->user_id = $u->id;
            $p->uuid = uniqid();
            $p->modified_by = 1;
            $p->save();
        }

        $u = User::find($u->id); // add profile

        return $this->json_response($u);
    }

    public function update(Request $request, $userId)
    {
        $user = $request->user();
        $u = User::findOrFail($userId);

        $this->validate($request, [
                                   'email' => 'required|email|unique:users,email,'.$u->id,
                                   'name' => 'required|max:255',
                                   'password'=> 'min:6',
                                   'current_password'=> 'min:6',
                                   'role_id' => 'required|exists:roles,id',
                                   'organization_id' => 'required|exists:organizations,id',
                                   'type' => 'required|in:employer,gradlead,graduate,school,student',
                                  ]
                                );

        if ($request->password<>'') {
            if (! Hash::check($request->current_password, $u->password)) {
                return $this->json_response(
                    ['current_password' => ['The current password you provided is incorrect.']], true, 422);
            } else {
                $u->password = Hash::make($request->password);
            }
        }

        // update user
        $u->name = $request->name;
        $u->email = $request->email;
        $u->organization_id = $request->organization_id;
        $u->role_id = $request->role_id;
        $u->type = $request->type;
        $u->modified_by = $user->id;
        $u->save();
        
        return $this->json_response($u);
    }


    public function destroy(Request $request, $userId)
    {
        $i = User::find($userId);
        if (is_null($i)) {
            $this->json_report(['Cannot find user'], true);
        } else {
            $i->cleanUp();
            $i->delete();
            return $this->ok();
        }
    }
}
