<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Schema, Log};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;

class DiagnosticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder untuk mendiagnosis masalah mengapa user siswa tidak muncul di database
     */
    public function run(): void
    {
        $this->command->info('🔍 Running Diagnostic Check for Student Users...');
        $this->command->info('================================================');
        
        // 1. Check database tables
        $this->checkTables();
        
        // 2. Check existing data
        $this->checkExistingData();
        
        // 3. Check table structure
        $this->checkTableStructure();
        
        // 4. Check roles
        $this->checkRoles();
        
        // 5. Check relationships
        $this->checkRelationships();
        
        // 6. Check logs
        $this->checkLogs();
        
        // 7. Provide recommendations
        $this->provideRecommendations();
    }
    
    /**
     * Check if required tables exist
     */
    private function checkTables(): void
    {
        $this->command->info('📋 1. Checking Database Tables:');
        
        $tables = ['users', 'students', 'roles', 'model_has_roles'];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $this->command->info("   ✅ Table '{$table}' exists");
            } else {
                $this->command->error("   ❌ Table '{$table}' NOT found");
            }
        }
        $this->command->info('');
    }
    
    /**
     * Check existing data counts
     */
    private function checkExistingData(): void
    {
        $this->command->info('📊 2. Checking Existing Data:');
        
        try {
            $studentCount = Student::count();
            $userCount = User::count();
            $roleCount = Role::count();
            
            $this->command->info("   📝 Students in database: {$studentCount}");
            $this->command->info("   👤 Users in database: {$userCount}");
            $this->command->info("   🎭 Roles in database: {$roleCount}");
            
            // Check students with user_id
            $studentsWithUsers = Student::whereNotNull('user_id')->count();
            $this->command->info("   🔗 Students with user_id: {$studentsWithUsers}");
            
            // Check users with student role
            if (Role::where('name', 'student')->exists()) {
                $studentUsers = User::role('student')->count();
                $this->command->info("   🎓 Users with student role: {$studentUsers}");
            } else {
                $this->command->warn("   ⚠️  Student role not found");
            }
            
        } catch (\Exception $e) {
            $this->command->error("   ❌ Error checking data: " . $e->getMessage());
        }
        
        $this->command->info('');
    }
    
    /**
     * Check table structure
     */
    private function checkTableStructure(): void
    {
        $this->command->info('🏗️  3. Checking Table Structure:');
        
        // Check users table columns
        $this->command->info('   Users table columns:');
        $userColumns = Schema::getColumnListing('users');
        $requiredUserFields = ['name', 'email', 'password', 'nis', 'class', 'religion', 'birth_place'];
        
        foreach ($requiredUserFields as $field) {
            if (in_array($field, $userColumns)) {
                $this->command->info("     ✅ {$field}");
            } else {
                $this->command->warn("     ⚠️  {$field} (missing)");
            }
        }
        
        // Check students table columns
        $this->command->info('   Students table columns:');
        $studentColumns = Schema::getColumnListing('students');
        $requiredStudentFields = ['name', 'nis', 'email', 'class', 'user_id'];
        
        foreach ($requiredStudentFields as $field) {
            if (in_array($field, $studentColumns)) {
                $this->command->info("     ✅ {$field}");
            } else {
                $this->command->error("     ❌ {$field} (missing)");
            }
        }
        
        $this->command->info('');
    }
    
    /**
     * Check roles
     */
    private function checkRoles(): void
    {
        $this->command->info('🎭 4. Checking Roles:');
        
        try {
            $roles = Role::all();
            if ($roles->isEmpty()) {
                $this->command->error("   ❌ No roles found in database");
                $this->command->info("   💡 Run: php artisan db:seed --class=RoleSeeder");
            } else {
                foreach ($roles as $role) {
                    $this->command->info("   ✅ Role: {$role->name} (guard: {$role->guard_name})");
                }
            }
            
            // Check specifically for student role
            $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
            if ($studentRole) {
                $this->command->info("   ✅ Student role exists (ID: {$studentRole->id})");
            } else {
                $this->command->error("   ❌ Student role not found");
            }
            
        } catch (\Exception $e) {
            $this->command->error("   ❌ Error checking roles: " . $e->getMessage());
        }
        
        $this->command->info('');
    }
    
    /**
     * Check relationships
     */
    private function checkRelationships(): void
    {
        $this->command->info('🔗 5. Checking Relationships:');
        
        try {
            // Check students without users
            $studentsWithoutUsers = Student::whereNull('user_id')->count();
            $this->command->info("   📝 Students without user_id: {$studentsWithoutUsers}");
            
            // Check users without students
            $usersWithoutStudents = User::whereDoesntHave('student')->count();
            $this->command->info("   👤 Users without student relationship: {$usersWithoutStudents}");
            
            // Check broken relationships
            $brokenRelationships = Student::whereNotNull('user_id')
                ->whereDoesntHave('user')
                ->count();
            $this->command->info("   💔 Broken student->user relationships: {$brokenRelationships}");
            
            // Sample data check
            $sampleStudent = Student::first();
            if ($sampleStudent) {
                $this->command->info("   📋 Sample student data:");
                $this->command->info("     - Name: {$sampleStudent->name}");
                $this->command->info("     - NIS: {$sampleStudent->nis}");
                $this->command->info("     - Email: {$sampleStudent->email}");
                $this->command->info("     - User ID: " . ($sampleStudent->user_id ?? 'NULL'));
                
                if ($sampleStudent->user_id) {
                    $user = User::find($sampleStudent->user_id);
                    if ($user) {
                        $this->command->info("     - User exists: ✅ {$user->email}");
                    } else {
                        $this->command->error("     - User exists: ❌ (ID {$sampleStudent->user_id} not found)");
                    }
                }
            }
            
        } catch (\Exception $e) {
            $this->command->error("   ❌ Error checking relationships: " . $e->getMessage());
        }
        
        $this->command->info('');
    }
    
    /**
     * Check logs for errors
     */
    private function checkLogs(): void
    {
        $this->command->info('📋 6. Checking Recent Logs:');
        
        $logFile = storage_path('logs/laravel.log');
        if (file_exists($logFile)) {
            $this->command->info("   ✅ Log file exists: {$logFile}");
            
            // Read last 50 lines
            $lines = file($logFile);
            $recentLines = array_slice($lines, -50);
            
            $errorCount = 0;
            $studentRelatedErrors = 0;
            
            foreach ($recentLines as $line) {
                if (strpos($line, 'ERROR') !== false) {
                    $errorCount++;
                    if (strpos(strtolower($line), 'student') !== false) {
                        $studentRelatedErrors++;
                    }
                }
            }
            
            $this->command->info("   📊 Recent errors in log: {$errorCount}");
            $this->command->info("   🎓 Student-related errors: {$studentRelatedErrors}");
            
            if ($studentRelatedErrors > 0) {
                $this->command->warn("   ⚠️  Found student-related errors in logs");
                $this->command->info("   💡 Check: tail -f storage/logs/laravel.log");
            }
        } else {
            $this->command->warn("   ⚠️  Log file not found");
        }
        
        $this->command->info('');
    }
    
    /**
     * Provide recommendations
     */
    private function provideRecommendations(): void
    {
        $this->command->info('💡 7. Recommendations:');
        
        $studentCount = Student::count();
        $userCount = User::count();
        $studentsWithUsers = Student::whereNotNull('user_id')->count();
        $studentRole = Role::where('name', 'student')->exists();
        
        if ($studentCount === 0) {
            $this->command->error("   ❌ No students found");
            $this->command->info("   🔧 Solution: php artisan db:seed --class=StudentSeeder");
        } elseif ($studentsWithUsers === 0) {
            $this->command->error("   ❌ Students exist but no user accounts created");
            $this->command->info("   🔧 Solution: Run one of these seeders:");
            $this->command->info("      - php artisan db:seed --class=SimpleStudentLoginSeeder");
            $this->command->info("      - php artisan db:seed --class=StudentLoginAccountSeeder");
            $this->command->info("      - php artisan db:seed --class=StudentAccountSeeder");
        } elseif (!$studentRole) {
            $this->command->error("   ❌ Student role missing");
            $this->command->info("   🔧 Solution: php artisan db:seed --class=RoleSeeder");
        } else {
            $this->command->info("   ✅ System appears to be working correctly");
            $this->command->info("   📊 Students: {$studentCount}, Users: {$userCount}, Linked: {$studentsWithUsers}");
        }
        
        $this->command->info('');
        $this->command->info('🔧 Quick Fix Commands:');
        $this->command->info('   1. Reset and recreate everything:');
        $this->command->info('      php artisan migrate:fresh --seed');
        $this->command->info('');
        $this->command->info('   2. Just create user accounts for existing students:');
        $this->command->info('      php artisan db:seed --class=SimpleStudentLoginSeeder');
        $this->command->info('');
        $this->command->info('   3. Check specific issues:');
        $this->command->info('      php artisan tinker');
        $this->command->info('      >>> Student::count()');
        $this->command->info('      >>> User::count()');
        $this->command->info('      >>> Student::whereNotNull(\"user_id\")->count()');
    }
}