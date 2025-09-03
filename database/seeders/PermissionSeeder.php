<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Posts permissions
            ['name' => 'posts.read', 'guard_name' => 'web'],
            ['name' => 'posts.create', 'guard_name' => 'web'],
            ['name' => 'posts.update', 'guard_name' => 'web'],
            ['name' => 'posts.delete', 'guard_name' => 'web'],
            
            // Academic permissions
            ['name' => 'academic.manage', 'guard_name' => 'web'],
            ['name' => 'students.manage', 'guard_name' => 'web'],
            ['name' => 'teachers.manage', 'guard_name' => 'web'],
            ['name' => 'achievements.manage', 'guard_name' => 'web'],
            ['name' => 'extracurriculars.manage', 'guard_name' => 'web'],
            
            // System permissions
            ['name' => 'system.admin', 'guard_name' => 'web'],
            ['name' => 'users.manage', 'guard_name' => 'web'],
            ['name' => 'roles.manage', 'guard_name' => 'web'],
            ['name' => 'settings.manage', 'guard_name' => 'web'],
            
            // Media permissions
            ['name' => 'media.manage', 'guard_name' => 'web'],
            ['name' => 'downloads.manage', 'guard_name' => 'web'],
            ['name' => 'gallery.manage', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission); // Ganti create() dengan firstOrCreate()
        }
    }
}