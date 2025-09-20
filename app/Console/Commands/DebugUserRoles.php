<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DebugUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:user-roles {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug user roles and fix role assignment issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('=== USER ROLE DEBUGGING TOOL ===');
        $this->newLine();
        
        // Show all available roles
        $this->info('Available Roles:');
        $roles = Role::all();
        foreach ($roles as $role) {
            $this->line("  - {$role->name} (ID: {$role->id})");
        }
        $this->newLine();
        
        if ($email) {
            $this->debugSpecificUser($email);
        } else {
            $this->showAllUsersWithRoles();
        }
        
        // Offer to fix issues
        if ($this->confirm('Do you want to fix any role assignment issues?')) {
            $this->fixRoleIssues();
        }
    }
    
    private function debugSpecificUser($email)
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return;
        }
        
        $this->info("User Details:");
        $this->line("  ID: {$user->id}");
        $this->line("  Name: {$user->name}");
        $this->line("  Email: {$user->email}");
        $this->line("  Status: {$user->status}");
        $this->line("  Email Verified: " . ($user->email_verified_at ? 'Yes' : 'No'));
        $this->newLine();
        
        $this->info("User Roles:");
        $userRoles = $user->roles;
        if ($userRoles->count() > 0) {
            foreach ($userRoles as $role) {
                $this->line("  - {$role->name} (ID: {$role->id})");
            }
        } else {
            $this->warn("  No roles assigned!");
        }
        $this->newLine();
        
        $this->info("Role Checks:");
        $this->line("  hasRole('super_admin'): " . ($user->hasRole('super_admin') ? 'true' : 'false'));
        $this->line("  hasRole('admin'): " . ($user->hasRole('admin') ? 'true' : 'false'));
        $this->line("  hasRole('teacher'): " . ($user->hasRole('teacher') ? 'true' : 'false'));
        $this->line("  hasRole('student'): " . ($user->hasRole('student') ? 'true' : 'false'));
        $this->newLine();
        
        // Check for multiple roles
        if ($userRoles->count() > 1) {
            $this->warn("WARNING: User has multiple roles! This might cause redirect issues.");
            $this->line("Roles: " . $userRoles->pluck('name')->implode(', '));
        }
    }
    
    private function showAllUsersWithRoles()
    {
        $this->info('All Users with Roles:');
        $users = User::with('roles')->get();
        
        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->implode(', ');
            $status = $user->email_verified_at ? 'Active' : 'Inactive';
            $this->line("  {$user->email} - Roles: [{$roles}] - Status: {$status}");
        }
        $this->newLine();
        
        // Show users with multiple roles
        $usersWithMultipleRoles = User::with('roles')
            ->get()
            ->filter(function ($user) {
                return $user->roles->count() > 1;
            });
            
        if ($usersWithMultipleRoles->count() > 0) {
            $this->warn('Users with Multiple Roles (potential issue):');
            foreach ($usersWithMultipleRoles as $user) {
                $roles = $user->roles->pluck('name')->implode(', ');
                $this->line("  {$user->email} - Roles: [{$roles}]");
            }
            $this->newLine();
        }
        
        // Show users without roles
        $usersWithoutRoles = User::doesntHave('roles')->get();
        if ($usersWithoutRoles->count() > 0) {
            $this->warn('Users without Roles:');
            foreach ($usersWithoutRoles as $user) {
                $this->line("  {$user->email}");
            }
            $this->newLine();
        }
    }
    
    private function fixRoleIssues()
    {
        $this->info('Role Issue Fixing Options:');
        $this->line('1. Remove duplicate roles from users');
        $this->line('2. Assign role to user without roles');
        $this->line('3. Change user role');
        $this->line('4. Clear all roles and reassign');
        
        $choice = $this->choice('What would you like to do?', [
            'Remove duplicate roles',
            'Assign role to user',
            'Change user role',
            'Clear and reassign roles',
            'Cancel'
        ], 4);
        
        switch ($choice) {
            case 'Remove duplicate roles':
                $this->removeDuplicateRoles();
                break;
            case 'Assign role to user':
                $this->assignRoleToUser();
                break;
            case 'Change user role':
                $this->changeUserRole();
                break;
            case 'Clear and reassign roles':
                $this->clearAndReassignRoles();
                break;
            default:
                $this->info('Operation cancelled.');
        }
    }
    
    private function removeDuplicateRoles()
    {
        $usersWithMultipleRoles = User::with('roles')
            ->get()
            ->filter(function ($user) {
                return $user->roles->count() > 1;
            });
            
        if ($usersWithMultipleRoles->count() === 0) {
            $this->info('No users with multiple roles found.');
            return;
        }
        
        foreach ($usersWithMultipleRoles as $user) {
            $roles = $user->roles->pluck('name')->toArray();
            $this->warn("User {$user->email} has roles: " . implode(', ', $roles));
            
            $keepRole = $this->choice("Which role should we keep for {$user->email}?", $roles);
            
            // Remove all roles and assign only the selected one
            $user->syncRoles([$keepRole]);
            $this->info("✓ User {$user->email} now has only role: {$keepRole}");
        }
    }
    
    private function assignRoleToUser()
    {
        $email = $this->ask('Enter user email');
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User not found!");
            return;
        }
        
        $roles = Role::all()->pluck('name')->toArray();
        $selectedRole = $this->choice('Select role to assign', $roles);
        
        $user->assignRole($selectedRole);
        $this->info("✓ Role {$selectedRole} assigned to {$user->email}");
    }
    
    private function changeUserRole()
    {
        $email = $this->ask('Enter user email');
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User not found!");
            return;
        }
        
        $currentRoles = $user->roles->pluck('name')->toArray();
        $this->info("Current roles: " . implode(', ', $currentRoles));
        
        $roles = Role::all()->pluck('name')->toArray();
        $newRole = $this->choice('Select new role', $roles);
        
        $user->syncRoles([$newRole]);
        $this->info("✓ User {$user->email} role changed to: {$newRole}");
    }
    
    private function clearAndReassignRoles()
    {
        if (!$this->confirm('This will clear ALL user roles and reassign them. Are you sure?')) {
            return;
        }
        
        $users = User::with('roles')->get();
        
        foreach ($users as $user) {
            $this->line("Processing user: {$user->email}");
            
            $roles = Role::all()->pluck('name')->toArray();
            $selectedRole = $this->choice("Select role for {$user->email}", array_merge($roles, ['Skip']));
            
            if ($selectedRole !== 'Skip') {
                $user->syncRoles([$selectedRole]);
                $this->info("✓ Assigned role {$selectedRole} to {$user->email}");
            }
        }
    }
}