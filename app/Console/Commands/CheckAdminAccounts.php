<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CheckAdminAccounts extends Command
{
    protected $signature = 'admin:check';
    protected $description = 'Check and create admin accounts if needed';

    public function handle()
    {
        $this->info('=== CHECKING ROLE SYSTEM AND ADMIN ACCOUNTS ===');
        $this->newLine();

        try {
            // 1. Check if permission tables exist
            $this->info('1. Checking permission system...');
            
            try {
                $rolesCount = Role::count();
                $permissionsCount = Permission::count();
                $usersCount = User::count();
                
                $this->info('✓ Permission system is working');
                $this->line("  - Roles: {$rolesCount}");
                $this->line("  - Permissions: {$permissionsCount}");
                $this->line("  - Users: {$usersCount}");
                $this->newLine();
            } catch (\Exception $e) {
                $this->error('❌ Permission system not working: ' . $e->getMessage());
                $this->error('Run: php artisan migrate');
                return 1;
            }
            
            // 2. Check existing roles
            $this->info('2. Checking existing roles...');
            $roles = Role::all();
            
            if ($roles->isEmpty()) {
                $this->error('❌ No roles found. Creating default roles...');
                $this->createDefaultRoles();
            } else {
                $this->info('✓ Found existing roles:');
                foreach ($roles as $role) {
                    $permCount = $role->permissions->count();
                    $this->line("  - {$role->name} ({$permCount} permissions)");
                }
            }
            
            $this->newLine();
            $this->info('3. Checking existing users...');
            $users = User::with('roles')->get();
            
            if ($users->isEmpty()) {
                $this->error('❌ No users found. Creating admin accounts...');
                $this->createAdminAccounts();
            } else {
                $this->info('✓ Found existing users:');
                foreach ($users as $user) {
                    $roleName = $user->roles->first()->name ?? 'No Role';
                    $this->line("  - {$user->name} ({$user->email}) - Role: {$roleName}");
                    
                    // Fix users without roles
                    if (!$user->roles->count()) {
                        $this->warn("  ⚠️  User {$user->email} has no role. Assigning Admin role...");
                        $user->assignRole('Admin');
                        $this->info("  ✓ Assigned Admin role to {$user->email}");
                    }
                }
                
                // Check if there's at least one admin
                $adminUsers = User::role('admin')->get();
                if ($adminUsers->isEmpty()) {
                    $this->newLine();
                    $this->error('❌ No admin users found. Creating admin account...');
                    $this->createAdminAccounts();
                } else {
                    $this->newLine();
                    $this->info('✓ Admin users available:');
                    foreach ($adminUsers as $admin) {
                        $roleName = $admin->roles->first()->name ?? 'No Role';
                        $this->line("  - {$admin->name} ({$admin->email}) - Role: {$roleName}");
                    }
                }
            }
            
            $this->newLine();
            $this->info('=== LOGIN CREDENTIALS ===');
            $this->line('You can login with any of these accounts:');
            $this->newLine();
            
            $adminUsers = User::role('admin')->get();
            foreach ($adminUsers as $admin) {
                $roleName = $admin->roles->first()->name ?? 'No Role';
                $this->line("Email: {$admin->email}");
                $this->line("Password: password");
                $this->line("Role: {$roleName}");
                $this->line("---");
            }
            
            $this->newLine();
            $this->info('🎉 SYSTEM CHECK COMPLETED!');
            $this->newLine();
            $this->line('To access admin panel:');
            $this->line('1. Go to: http://localhost/sekolah-web/login');
            $this->line('2. Use any admin credentials above');
            $this->line('3. You\'ll be redirected to admin dashboard');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ ERROR: ' . $e->getMessage());
            return 1;
        }
    }

    private function createDefaultRoles()
    {
        // Create permissions first
        $permissions = [
            'posts.read', 'posts.create', 'posts.update', 'posts.delete',
            'academic.manage', 'students.manage', 'teachers.manage',
            'achievements.manage', 'extracurriculars.manage',
            'media.manage', 'downloads.manage', 'gallery.manage',
            'users.manage', 'roles.manage', 'settings.manage'
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        $this->info('✓ Created permissions');
        
        // Create roles
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo(Permission::all());
        
        $teacher = Role::create(['name' => 'teacher', 'guard_name' => 'web']);
        $teacher->givePermissionTo(['posts.read', 'students.manage', 'achievements.manage']);
        
        $this->info('✓ Created default roles');
    }

    private function createAdminAccounts()
    {
        // Ensure roles exist - use existing role names
        // Create Admin user
        $adminUser = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $adminUser->assignRole('admin');
        $this->info('✓ Created Admin: admin@admin.com');
        
        // Create Regular Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin2@admin.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
        $this->info('✓ Created Admin: admin2@admin.com');
        
        // Create another admin with simple credentials
        $simpleAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('admin123'),
            'phone' => '081234567892',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $simpleAdmin->assignRole('admin');
        $this->info('✓ Created Simple Admin: admin@sekolah.com (password: admin123)');
    }
}