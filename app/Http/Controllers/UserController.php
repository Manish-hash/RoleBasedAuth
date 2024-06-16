<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(){

        $users = User::get();
        return view('role-permission.user.index',compact('users'));
    }

    public function create(){
        $roles =Role::pluck('name','name')->all();
        return view('role-permission.user.create',compact('roles'));
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email',
            'password'=>'required|string|min:8|max:20',
            'roles'=>'required',
        ]);

        $user = User::create([
                    'name' => $request->name,
                    'email'=> $request->email,
                    'password'=> Hash::make($request->password),
        ]);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status','Users created successfully with Roles'); 
}

public function edit(User $user){
    $roles =Role::pluck('name','name')->all();
    $userRoles = $user->roles->pluck('name','name')->all();
    return view('role-permission.user.edit',compact('user','roles','userRoles'));
}

public function update(Request $request, User $user){
    $request->validate([
        'name'=>'required|string|max:255',
        'password'=>'nullable|string|min:8|max:20',
        'roles'=>'required',
    ]);


    $data = [
                    'name' => $request->name,
                    'email'=> $request->email,
                    'password'=> Hash::make($request->password),
    ];

    if(!empty($request->password)){
        $data += [
            'password'=> Hash::make($request->password), 
        ];
    }
    $user->update($data);
    $user->syncRoles($request->roles);

    return redirect('/users')->with('status','Users Updated successfully with Roles'); 
}

public function delete($userId){
    $user = User::findOrFail($userId);
    $user->delete();

    return redirect('/users')->with('status','Users deleted successfully  along with Roles'); 

}
}
