<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log};
use App\Models\User;
use Spatie\Permission\Models\Role;

class OriginalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Starting OriginalUserSeeder...');
        
        // Original user accounts from the old system
        $originalUsers = [
            [
                'name' => 'Administrator',
                'email' => 'admin@sman99.sch.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
                'role_name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teacher Demo',
                'email' => 'teacher@sman99.sch.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
                'role_name' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student Demo',
                'email' => 'student@sman99.sch.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
                'role_name' => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Additional admin accounts for compatibility
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@sman99.sch.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
                'role_name' => 'superadministrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        DB::beginTransaction();
        
        try {
            foreach ($originalUsers as $userData) {
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
                            $this->command->info("✅ Created original user: {$user->name} ({$user->email}) with role '{$roleName}'");
                            Log::info("Created original user: {$user->email} with role '{$roleName}' (ID: {$role->id})");
                        } catch (\Exception $e) {
                            $this->command->warn("⚠️  Created user but failed to assign role: {$e->getMessage()}");
                            Log::warning("Failed to assign role to user {$user->id}: " . $e->getMessage());
                        }
                    } else {
                        $this->command->warn("⚠️  Role '{$roleName}' not found for user {$user->email}");
                        Log::warning("Role '{$roleName}' not found for user {$user->email}");
                    }
                } else {
                    // Update password and ensure role is assigned
                    $existingUser->update([
                        'password' => Hash::make('password'),
                        'status' => 'active',
                        'email_verified_at' => now(),
                    ]);
                    
                    // Also assign role if not already assigned
                    $roleName = $userData['role_name'];
                    $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();
                    
                    if ($role && !$existingUser->hasRole($roleName)) {
                        $existingUser->assignRole($role);
                        $this->command->info("⚠️  User already exists, updated and assigned role '{$roleName}': {$existingUser->email}");
                    } else {
                        $this->command->info("⚠️  User already exists, updated: {$existingUser->email}");
                    }
                    
                    Log::info("Updated existing original user: {$existingUser->email}");
                }
            }
            
            DB::commit();
            
            $this->command->info("👤 OriginalUserSeeder completed successfully!");
            $this->command->info("🔑 All passwords set to: 'password'");
            $this->command->info("📧 Original Login Credentials:");
            $this->command->info("   - admin@sman99.sch.id / password (Administrator)");
            $this->command->info("   - teacher@sman99.sch.id / password (Teacher Demo)");
            $this->command->info("   - student@sman99.sch.id / password (Student Demo)");
            $this->command->info("   - superadmin@sman99.sch.id / password (Super Administrator)");
            
            Log::info("OriginalUserSeeder completed successfully");
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $this->command->error("❌ OriginalUserSeeder failed: " . $e->getMessage());
            Log::error("OriginalUserSeeder failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}