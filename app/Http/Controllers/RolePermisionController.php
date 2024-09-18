<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Detection\MobileDetect;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:role_permission read')->only('index');
    }

    /**
     * Display a listing of the roles.
     */
    public function index(): View
    {
        $detect = new MobileDetect;
        $roles = Role::all();

        if ($detect->isMobile() || $detect->isTablet()) {
            return view('mobile.role.index', compact('roles'));
        } else {
            return view('desktop.role.index', compact('roles'));
        }
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $detect = new MobileDetect;
        $permissions = Permission::all()->groupBy('group_name');

        if ($detect->isMobile() || $detect->isTablet()) {
            return view('mobile.role.create', compact('permissions'));
        } else {
            return view('desktop.role.create', compact('permissions'));
        }
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'max:50', 'unique:roles,name'],
            'permissions' => ['nullable', 'array']
        ]);

        // Create the role
        $role = Role::create(['guard_name' => 'web', 'name' => $request->role]);

        // Assign permissions to the role
        $role->syncPermissions($request->permissions);

        // Use session flash message instead of toast
        return redirect()->route('role.index')->with('success', 'Created Successfully');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(string $id): View
    {
        $detect = new MobileDetect;
        $permissions = Permission::all()->groupBy('group_name');
        $role = Role::findOrFail($id);
        $rolesPermissions = $role->permissions->pluck('name')->toArray();

        if ($detect->isMobile() || $detect->isTablet()) {
            return view('mobile.role.edit', compact('permissions', 'role', 'rolesPermissions'));
        } else {
            return view('desktop.role.edit', compact('permissions', 'role', 'rolesPermissions'));
        }
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'max:50', 'unique:roles,name,' . $id],
            'permissions' => ['nullable', 'array']
        ]);

        // Update the role
        $role = Role::findOrFail($id);
        $role->update(['guard_name' => 'web', 'name' => $request->role]);

        // Assign permissions to the role
        $role->syncPermissions($request->permissions);

        // Use session flash message instead of toast
        return redirect()->route('role.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'Admin') {
            // Use session flash message instead of JSON response
            return redirect()->route('role.index')->with('error', 'Can\'t Delete the Super Admin');
        }

        $role->delete();

        // Use session flash message instead of JSON response
        return redirect()->route('role.index')->with('success', 'Deleted Successfully');
    }
}
