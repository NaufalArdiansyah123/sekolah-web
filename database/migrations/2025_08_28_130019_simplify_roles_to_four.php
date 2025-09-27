<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create new superadmin role if it doesn't exist
        $superadmin = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ]);

        // Migrate users from old super admin roles to new superadmin role
        $oldSuperAdminRoles = ['super_admin', 'superadministrator'];
        
        foreach ($oldSuperAdminRoles as $oldRole) {
            $role = Role::where('name', $oldRole)->where('guard_name', 'web')->first();
            if ($role) {
                // Get all users with this role
                $users = User::role($oldRole)->get();
                
                foreach ($users as $user) {
                    // Remove old role and assign new superadmin role
                    $user->removeRole($oldRole);
                    $user->assignRole('superadmin');
                }
                
                // Delete the old role
                $role->delete();
            }
        }

        // Remove parent role and its assignments
        $parentRole = Role::where('name', 'parent')->where('guard_name', 'web')->first();
        if ($parentRole) {
            // Remove role from all users
            $parentUsers = User::role('parent')->get();
            foreach ($parentUsers as $user) {
                $user->removeRole('parent');
                // Optionally assign them to student role or leave without role
                // $user->assignRole('student');
            }
            
            // Delete the parent role
            $parentRole->delete();
        }

        // Give all permissions to superadmin role
        if ($superadmin) {
            $superadmin->givePermissionTo(\Spatie\Permission\Models\Permission::all());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate old roles
        $oldRoles = [
            ['name' => 'super_admin', 'guard_name' => 'web'],
            ['name' => 'superadministrator', 'guard_name' => 'web'],
            ['name' => 'parent', 'guard_name' => 'web'],
        ];

        foreach ($oldRoles as $roleData) {
            Role::firstOrCreate($roleData);
        }

        // Migrate users back from superadmin to super_admin
        $superadminUsers = User::role('superadmin')->get();
        foreach ($superadminUsers as $user) {
            $user->removeRole('superadmin');
            $user->assignRole('super_admin');
        }

        // Delete superadmin role
        $superadminRole = Role::where('name', 'superadmin')->where('guard_name', 'web')->first();
        if ($superadminRole) {
            $superadminRole->delete();
        }
    }
};