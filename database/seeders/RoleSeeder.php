<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = [
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator', 
            'teacher' => 'Teacher',
            'student' => 'Student'
        ];

        foreach ($roles as $name => $displayName) {
            Role::firstOrCreate(['name' => $name], [
                'guard_name' => 'web'
            ]);
        }

        // Create permissions (optional)
        $permissions = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'posts.view',
            'posts.create',
            'posts.edit',
            'posts.delete',
            'media.view',
            'media.create',
            'media.edit',
            'media.delete',
            'academic.view',
            'academic.create',
            'academic.edit',
            'academic.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission], [
                'guard_name' => 'web'
            ]);
        }

        // Assign permissions to roles
        $superAdmin = Role::where('name', 'super_admin')->first();
        $admin = Role::where('name', 'admin')->first();
        $teacher = Role::where('name', 'teacher')->first();
        $student = Role::where('name', 'student')->first();

        // Super Admin gets all permissions
        if ($superAdmin) {
            $superAdmin->givePermissionTo(Permission::all());
        }

        // Admin gets most permissions except user management
        if ($admin) {
            $admin->givePermissionTo([
                'posts.view', 'posts.create', 'posts.edit', 'posts.delete',
                'media.view', 'media.create', 'media.edit', 'media.delete',
                'academic.view', 'academic.create', 'academic.edit', 'academic.delete',
            ]);
        }

        // Teacher gets limited permissions
        if ($teacher) {
            $teacher->givePermissionTo([
                'posts.view', 'posts.create', 'posts.edit',
                'academic.view', 'academic.create', 'academic.edit',
            ]);
        }

        // Student gets view permissions only
        if ($student) {
            $student->givePermissionTo([
                'posts.view',
                'academic.view',
            ]);
        }
    }
}