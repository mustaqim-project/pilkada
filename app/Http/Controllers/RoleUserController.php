<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRoleUserStoreRequest;
use App\Http\Requests\AdminRoleUserUpdateRequest;
use App\Mail\RoleUserCreateMail;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function index() : View
    {
        $admins = User::all();
        return view('desktop.role-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $roles = Role::all();
        return view('desktop.role-user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRoleUserStoreRequest $request) : RedirectResponse
    {

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = 1;
            $user->save();

            /** assign the role to user */
            $user->assignRole($request->role);

            /** send mail to the user */
            Mail::to($request->email)->send(new RoleUserCreateMail($request->email, $request->password));

            toast(__('Created Successfully!'), 'success');

            return redirect()->route('role-users.index');

        } catch (\Throwable $th) {
            throw $th;
        }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : View
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('desktop.role-user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRoleUserUpdateRequest $request, string $id)
    {

        if($request->has('password') && !empty($request->password)){
            $request->validate([
                'password' => ['confirmed', 'min:6']
            ]);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->has('password') && !empty($request->password)){
            $user->password = bcrypt($request->password);
        }

        $user->save();


        /** assign the role to user */
        $user->syncRoles($request->role);

        toast(__('Update Successfully!'), 'success');

        return redirect()->route('role-users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if($user->getRoleNames()->first() === 'Admin'){
            return response(['status' => 'error', 'message' => __('Can\'t Delete the Super User')]);
        }
        $user->delete();

        return response(['status' => 'success', 'message' => __('Deleted Successfully')]);

    }
}
