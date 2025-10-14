<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create guru piket role
        $role = Role::create([
            'name' => 'guru_piket',
            'guard_name' => 'web',
        ]);

        // Create permissions for guru piket
        $permissions = [
            // Attendance management
            'manage_student_attendance',
            'manage_teacher_attendance',
            'view_attendance_reports',
            'export_attendance_data',
            
            // Dashboard access
            'access_guru_piket_dashboard',
            
            // QR Scanner access
            'use_qr_scanner',
            
            // Basic profile management
            'manage_own_profile',
        ];

        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
            
            $role->givePermissionTo($perm);
        }

        // Also give some basic permissions that teachers have
        $teacherPermissions = [
            'view_students',
            'view_teachers',
        ];

        foreach ($teacherPermissions as $permission) {
            $perm = Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
            
            $role->givePermissionTo($perm);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove permissions
        $permissions = [
            'manage_student_attendance',
            'manage_teacher_attendance',
            'view_attendance_reports',
            'export_attendance_data',
            'access_guru_piket_dashboard',
            'use_qr_scanner',
            'manage_own_profile',
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }

        // Remove role
        Role::where('name', 'guru_piket')->delete();
    }
};