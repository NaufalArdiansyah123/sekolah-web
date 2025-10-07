<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log};
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Starting AdminUserSeeder...');
        
        $adminUsers = [
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@smk.sch.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_name' => 'superadministrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Administrator',
                'email' => 'admin@smk.sch.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guru Demo',
                'email' => 'guru@smk.sch.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_name' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        DB::beginTransaction();
        
        try {
            foreach ($adminUsers as $userData) {
                // Check if user already exists
                $existingUser = User::where('email', $userData['email'])->first();
                
                if (!$existingUser) {
                    $roleName = $userData['role_name'];
                    unset($userData['role_name']); // Remove role_name from user data
                    
                    $user = User::create($userData);
                    
                    // Find role by name
                    $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();
                    
                    if ($role) {
                        // Assign role using Spatie Permission
                        try {
                            $user->assignRole($role);
                            $this->command->info("✅ Created user: {$user->name} ({$user->email}) with role '{$roleName}' (ID: {$role->id})");
                            Log::info("Created admin user: {$user->email} with role '{$roleName}' (ID: {$role->id})");
                        } catch (\Exception $e) {
                            $this->command->warn("⚠️  Created user but failed to assign role: {$e->getMessage()}");
                            Log::warning("Failed to assign role to user {$user->id}: " . $e->getMessage());
                        }
                    } else {
                        $this->command->warn("⚠️  Role '{$roleName}' not found for user {$user->email}");
                        Log::warning("Role '{$roleName}' not found for user {$user->email}");
                    }
                } else {
                    // Update password to 'password' if user exists
                    $existingUser->update([
                        'password' => Hash::make('password')
                    ]);
                    
                    // Also assign role if not already assigned
                    $roleName = $userData['role_name'];
                    $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();
                    
                    if ($role && !$existingUser->hasRole($roleName)) {
                        $existingUser->assignRole($role);
                        $this->command->info("⚠️  User already exists, updated password and assigned role '{$roleName}': {$existingUser->email}");
                    } else {
                        $this->command->info("⚠️  User already exists, updated password: {$existingUser->email}");
                    }
                    
                    Log::info("Updated existing user: {$existingUser->email}");
                }
            }
            
            DB::commit();
            
            $this->command->info("👤 AdminUserSeeder completed successfully!");
            $this->command->info("🔑 All admin passwords set to: 'password'");
            $this->command->info("📧 Admin emails:");
            $this->command->info("   - superadmin@smk.sch.id (Super Administrator)");
            $this->command->info("   - admin@smk.sch.id (Administrator)");
            $this->command->info("   - guru@smk.sch.id (Teacher Demo)");
            
            Log::info("AdminUserSeeder completed successfully");
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $this->command->error("❌ AdminUserSeeder failed: " . $e->getMessage());
            Log::error("AdminUserSeeder failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}