<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Log};
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Starting RoleSeeder...');
        
        // Original roles from the existing system + new superadministrator
        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'display_name' => 'Administrator',
                'description' => 'Administrator dengan akses ke fitur manajemen sekolah',
            ],
            [
                'name' => 'teacher',
                'guard_name' => 'web',
                'display_name' => 'Teacher',
                'description' => 'Guru dengan akses ke fitur pembelajaran dan penilaian',
            ],
            [
                'name' => 'student',
                'guard_name' => 'web',
                'display_name' => 'Student',
                'description' => 'Siswa dengan akses ke fitur pembelajaran dan absensi',
            ],
            [
                'name' => 'superadministrator',
                'guard_name' => 'web',
                'display_name' => 'Super Administrator',
                'description' => 'Super Administrator dengan akses penuh ke semua fitur sistem',
            ],
        ];
        
        try {
            foreach ($roles as $roleData) {
                // Check if role already exists
                $existingRole = Role::where('name', $roleData['name'])->where('guard_name', $roleData['guard_name'])->first();
                
                if (!$existingRole) {
                    // Create role using Spatie Permission model
                    $role = Role::create([
                        'name' => $roleData['name'],
                        'guard_name' => $roleData['guard_name'],
                    ]);
                    
                    $this->command->info("✅ Created role: {$roleData['display_name']} (ID: {$role->id})");
                    Log::info("Created role: {$roleData['name']} with ID: {$role->id}");
                } else {
                    $this->command->info("⚠️  Role already exists: {$roleData['display_name']} (ID: {$existingRole->id})");
                    Log::info("Role already exists: {$roleData['name']} with ID: {$existingRole->id}");
                }
            }
            
            $this->command->info("🎭 RoleSeeder completed successfully!");
            $this->command->info("📋 Available roles:");
            $this->command->info("   1. admin (Administrator) - Original");
            $this->command->info("   2. teacher (Teacher) - Original");
            $this->command->info("   3. student (Student) - Original");
            $this->command->info("   4. superadministrator (Super Administrator) - New");
            
            Log::info("RoleSeeder completed successfully");
            
        } catch (\Exception $e) {
            $this->command->error("❌ RoleSeeder failed: " . $e->getMessage());
            Log::error("RoleSeeder failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}