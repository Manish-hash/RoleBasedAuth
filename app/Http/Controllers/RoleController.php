<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{


    
    public function index(){
        $roles = Role::get();
        return view('role-permission.role.index',[
            'roles'=> $roles
        ]);
    }

    public function create(){
        return view('role-permission.role.create');
    }
    
    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role created successfully');
    }
    public function edit($id){
        $role = Role::findOrFail($id);
        
        return view('role-permission.role.edit',compact('role'));
    }

    public function update(Request $request, Role $role){
        $request->validate([
            'name'=>'required|string|unique:roles,name,'. $role->id
        ]); 
        $role->update([
            'name' => $request->name
        ]);
        return redirect('roles')->with('status', 'Role updated successfully');
    }

    public function destroy($id){
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect('roles')->with('status', 'Role Deleted successfully');
    }

    public function addPermissionToRole($id){
        $permissions = Permission::get();
        $role = Role::findOrFail($id);
        $rolePermissions = DB::table('role_has_permissions')
                                ->where('role_has_permissions.role_id', $role->id)
                                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                ->all();
        return view('role-permission.role.add-permissions',compact('role','permissions','rolePermissions'));
    }

    public function givePermissionToRole(Request $request, $id){
        $request->validate([
            'permission' => 'required'
        ]);
        $role= Role::findOrFail($id);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with('status','Permission assigned to role');
    }
}
