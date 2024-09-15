<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:role_permission read')->only('index');
        $this->middleware('can:role_permission create')->only(['storeRole', 'storePermission']);
        $this->middleware('can:role_permission update')->only('assignPermissionToRole');
        $this->middleware('can:role_permission delete')->only('destroy');
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('role_permission.index', compact('roles', 'permissions'));
    }


    // Store a new Role
    public function storeRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,name',
        ]);

        Role::create(['name' => $request->role_name]);
        return redirect()->back()->with('success', 'Role berhasil ditambahkan!');
    }

    // Store a new Permission
    public function storePermission(Request $request)
    {
        $request->validate([
            'permission_name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->permission_name]);
        return redirect()->back()->with('success', 'Permission berhasil ditambahkan!');
    }

    // Assign Permissions to Role
    public function assignPermissionToRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id' // Validate that each permission ID exists
        ]);

        $role = Role::findById($request->role_id);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('success', 'Permission berhasil ditambahkan ke Role!');
    }
}
