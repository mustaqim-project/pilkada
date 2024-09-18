<?php

namespace App\Http\Controllers;

use Detection\MobileDetect;
use App\Http\Requests\AdminRoleUserStoreRequest;
use App\Http\Requests\AdminRoleUserUpdateRequest;
use App\Mail\RoleUserCreateMail;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class RoleUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:role_permission read')->only('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $detect = new MobileDetect;
        $admins = User::all();

        if ($detect->isMobile() || $detect->isTablet()) {
            return view('mobile.role-user.index', compact('admins'));
        } else {
            return view('desktop.role-user.index', compact('admins'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $detect = new MobileDetect;
        $roles = Role::all();

        if ($detect->isMobile() || $detect->isTablet()) {
            return view('mobile.role-user.create', compact('roles'));
        } else {
            return view('desktop.role-user.create', compact('roles'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRoleUserStoreRequest $request): RedirectResponse
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = 1;
            $user->save();

            // Assign the role to user
            $user->assignRole($request->role);

            // Send mail to the user
            Mail::to($request->email)->send(new RoleUserCreateMail($request->email, $request->password));

            // Use session flash message instead of toast
            return redirect()->route('role-users.index')->with('success', 'Created Successfully!');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $detect = new MobileDetect;
        $user = User::findOrFail($id);
        $roles = Role::all();

        if ($detect->isMobile() || $detect->isTablet()) {
            return view('mobile.role-user.edit', compact('user', 'roles'));
        } else {
            return view('desktop.role-user.edit', compact('user', 'roles'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRoleUserUpdateRequest $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->has('password') && !empty($request->password)) {
            $request->validate([
                'password' => ['confirmed', 'min:6'],
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Assign the role to user
        $user->syncRoles($request->role);

        // Use session flash message instead of toast
        return redirect()->route('role-users.index')->with('success', 'Update Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        if ($user->getRoleNames()->first() === 'Admin') {
            return redirect()->route('role-users.index')->with('error', 'Can\'t Delete the Super User');
        }

        $user->delete();

        return redirect()->route('role-users.index')->with('success', 'Deleted Successfully');
    }
}
