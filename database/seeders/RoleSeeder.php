<?php
// database/seeders/RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;        // TAMBAHKAN BARIS INI
use Spatie\Permission\Models\Permission;  // TAMBAHKAN BARIS INI


class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin Role
        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);
        $superAdmin->permissions()->attach(Permission::all());

        // Create Admin Role
        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);
        $adminPermissions = Permission::whereIn('name', [
            'posts.read', 'posts.create', 'posts.update',
            'academic.manage', 'students.manage', 'teachers.manage',
            'achievements.manage', 'extracurriculars.manage',
            'media.manage', 'downloads.manage', 'gallery.manage'
        ])->get();
        $admin->permissions()->attach($adminPermissions);

        // Create Editor Role
        $editor = Role::firstOrCreate([
            'name' => 'Editor',
            'guard_name' => 'web',
        ]);
        $editorPermissions = Permission::whereIn('name', [
            'posts.read', 'posts.create', 'posts.update',
            'media.manage', 'downloads.manage', 'gallery.manage'
        ])->get();
        $editor->permissions()->attach($editorPermissions);

        // Create Teacher Role
        $teacher = Role::firstOrCreate([
            'name' => 'Teacher',
            'guard_name' => 'web',
        ]);
        $teacherPermissions = Permission::whereIn('name', [
            'posts.read', 'students.manage', 'achievements.manage'
        ])->get();
        $teacher->permissions()->attach($teacherPermissions);
    }
}