<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Permissions
        Permission::create(['name' => 'cakada create']);
        Permission::create(['name' => 'cakada read']);
        Permission::create(['name' => 'cakada update']);
        Permission::create(['name' => 'cakada delete']);
        Permission::create(['name' => 'kanvasing create']);
        Permission::create(['name' => 'kanvasing read']);
        Permission::create(['name' => 'kanvasing update']);
        Permission::create(['name' => 'kanvasing delete']);

        // Roles
        $adminRole = Role::create(['name' => 'admin']);
        $timsesRole = Role::create(['name' => 'timses']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        $timsesRole->givePermissionTo(['kanvasing create', 'kanvasing read']);
        $userRole->givePermissionTo(['cakada read']);

        // Create users
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $timses = User::create([
            'name' => 'Timses',
            'email' => 'timses@example.com',
            'password' => Hash::make('password'),
        ]);
        $timses->assignRole('timses');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');
    }
}
