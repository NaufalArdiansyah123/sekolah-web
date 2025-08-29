<?php
// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Posts management
            'posts.create', 'posts.read', 'posts.update', 'posts.delete',

            // User management
            'users.create', 'users.read', 'users.update', 'users.delete',

            // Academic management
            'academic.view', 'academic.manage', 
            'grades.manage', 'attendance.manage',

            // System administration
            'system.admin', 'system.settings',

            // Teacher specific
            'materials.manage', 'assignments.manage', 'exams.manage',

            // Student specific
            'assignments.submit', 'exams.take', 'materials.access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // --- Roles ---

        // Super Admin
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'posts.create', 'posts.read', 'posts.update', 'posts.delete',
            'users.create', 'users.read', 'users.update',
            'academic.manage', 'system.settings'
        ]);

        // Teacher
        $teacher = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $teacher->givePermissionTo([
            'posts.create', 'posts.read', 'posts.update',
            'materials.manage', 'assignments.manage', 'exams.manage',
            'grades.manage', 'attendance.manage'
        ]);

        // Student
        $student = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $student->givePermissionTo([
            'posts.read', 'assignments.submit', 'exams.take', 'materials.access'
        ]);

        // Parent
        $parent = Role::firstOrCreate(['name' => 'parent', 'guard_name' => 'web']);
        $parent->givePermissionTo([
            'posts.read', 'academic.view'
        ]);

        // --- Create default super admin user ---
        $user = User::firstOrCreate(
            ['email' => 'admin@sekolah.com'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('password'),
                'status' => 'active'
            ]
        );

        $user->assignRole('super_admin');
    }
}
