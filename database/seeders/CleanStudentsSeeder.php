<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Log};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;

class CleanStudentsSeeder extends Seeder
{
    /**
     * Clean existing student data and prepare for fresh seeding.
     */
    public function run(): void
    {
        $this->command->info('🧹 Starting Student Data Cleanup...');
        Log::info('Starting Student Data Cleanup');
        
        DB::beginTransaction();
        
        try {
            // Get count before cleanup
            $studentsCount = Student::count();
            $studentUsersCount = User::whereHas('roles', function($query) {
                $query->where('name', 'student');
            })->count();
            
            $this->command->info("📊 Current Data:");
            $this->command->info("   - Students: {$studentsCount}");
            $this->command->info("   - Student Users: {$studentUsersCount}");
            
            if ($studentsCount > 0 || $studentUsersCount > 0) {
                $this->command->info('🗑️  Cleaning existing student data...');
                
                // Get student role
                $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
                
                if ($studentRole) {
                    // Get all users with student role (except the original demo student)
                    $studentUsers = User::whereHas('roles', function($query) {
                        $query->where('name', 'student');
                    })->where('email', '!=', 'student@sman99.sch.id')->get();
                    
                    $this->command->info("🔍 Found {$studentUsers->count()} student users to clean (excluding demo account)");
                    
                    // Remove student users (except demo)
                    foreach ($studentUsers as $user) {
                        $this->command->info("   - Removing user: {$user->email}");
                        $user->delete();
                    }
                }
                
                // Remove all students (except those linked to preserved users)
                $preservedEmails = ['student@sman99.sch.id'];
                $studentsToDelete = Student::whereNotIn('email', $preservedEmails)->get();
                
                $this->command->info("🔍 Found {$studentsToDelete->count()} students to clean");
                
                foreach ($studentsToDelete as $student) {
                    $this->command->info("   - Removing student: {$student->name} (NIS: {$student->nis})");
                    $student->delete();
                }
                
                $this->command->info('✅ Student data cleanup completed!');
            } else {
                $this->command->info('ℹ️  No student data to clean.');
            }
            
            DB::commit();
            
            // Show final counts
            $finalStudentsCount = Student::count();
            $finalStudentUsersCount = User::whereHas('roles', function($query) {
                $query->where('name', 'student');
            })->count();
            
            $this->command->info('📊 Final Data:');
            $this->command->info("   - Students: {$finalStudentsCount}");
            $this->command->info("   - Student Users: {$finalStudentUsersCount}");
            $this->command->info('🎉 Cleanup completed successfully!');
            $this->command->info('💡 You can now run StudentSeeder safely.');
            
            Log::info('Student data cleanup completed successfully', [
                'students_removed' => $studentsCount - $finalStudentsCount,
                'users_removed' => $studentUsersCount - $finalStudentUsersCount,
                'final_students' => $finalStudentsCount,
                'final_users' => $finalStudentUsersCount
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $this->command->error('❌ Student cleanup failed: ' . $e->getMessage());
            Log::error('Student cleanup failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}