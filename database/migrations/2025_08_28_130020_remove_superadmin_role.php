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
        // Migrate users from superadmin role to admin role
        $superadminRole = Role::where('name', 'superadmin')->where('guard_name', 'web')->first();
        $adminRole = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        
        if ($superadminRole && $adminRole) {
            // Get all users with superadmin role
            $superadminUsers = User::role('superadmin')->get();
            
            foreach ($superadminUsers as $user) {
                // Remove superadmin role and assign admin role
                $user->removeRole('superadmin');
                $user->assignRole('admin');
            }
            
            // Delete the superadmin role
            $superadminRole->delete();
        }

        // Also clean up any remaining old super admin roles
        $oldSuperAdminRoles = ['super_admin', 'superadministrator'];
        
        foreach ($oldSuperAdminRoles as $oldRole) {
            $role = Role::where('name', $oldRole)->where('guard_name', 'web')->first();
            if ($role) {
                // Get all users with this role
                $users = User::role($oldRole)->get();
                
                foreach ($users as $user) {
                    // Remove old role and assign admin role
                    $user->removeRole($oldRole);
                    $user->assignRole('admin');
                }
                
                // Delete the old role
                $role->delete();
            }
        }

        // Ensure admin role has all permissions
        if ($adminRole) {
            $adminRole->givePermissionTo(\Spatie\Permission\Models\Permission::all());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate superadmin role
        $superadminRole = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ]);

        // Give all permissions to superadmin
        $superadminRole->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        // Note: We don't migrate users back automatically in down() 
        // as it could be destructive. Manual intervention required.
    }
};