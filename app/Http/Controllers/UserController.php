<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserController extends Controller
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
        $users = User::all();        
        return response()->json($users);
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

        $u = User::where('email',$request->email)->first();

        if(!$u) {
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

            return $u;

        } else {
            return response()->json(['email' => ['User with this email already exists.']], 422);
        }
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
                return response()->json(
                    ['current_password' => ['The current password you provided is incorrect.']], 422);
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

        return $u;
    }


    public function destroy(Request $request, $userId)
    {
        $user = $request->user();
        $u = User::findOrFail($userId);
        $u->delete();
    }
}
