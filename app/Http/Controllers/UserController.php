<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function adminDashboard(){
        return view("adminLTE");
    }
    public function userManagmentView(){
        $admins = User::role('admin')->get();
        return view("users",["admins"=>$admins]);
    }
    public function userView($id){
        $user = User::find($id);
        return view("viewUser",["user"=>$user]);
    }
    public function userEdit($id){
        $user = User::find($id);
        return view("EditUser",["user"=>$user]);
    }
 public function userUpdate(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        "first_name" => "nullable|string|max:255",
        "last_name"  => "nullable|string|max:255",
        "username"   => [
            "nullable",
            "string",
            "max:255",
            Rule::unique('users')->ignore($user->id), 
        ],
        "email" => [
            "nullable",
            Rule::unique('users')->ignore($user->id),
        ],
        "password" => "nullable|string|min:6", 
    ]);

    $data = $request->only(['first_name', 'last_name', 'username', 'email']);

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return to_route("users")->with("message", "User updated successfully");
}

    public function userDelete($id){
        $user=User::find($id);
        $user->delete();
        return to_route("users")->with("message", "User deleted successfully");
    }

    public function createUserView(){
        return view("CreateUser");
    }

    public function createUser(Request $request){
    $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|string|min:6',
        ]);

    $user = User::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'username'   => $request->username,
        'email'      => $request->email,
        'password'   => Hash::make($request->password),
    ]);

    $user->assignRole('admin');

    return redirect()->route('users')->with('message', 'Admin created successfully');            
    }



}
