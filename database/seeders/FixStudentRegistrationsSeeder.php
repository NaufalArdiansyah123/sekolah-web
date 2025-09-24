<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Log};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;

class FixStudentRegistrationsSeeder extends Seeder
{
    /**
     * Fix student registrations data inconsistency.
     */
    public function run(): void
    {
        $this->command->info('🔧 Starting Student Registrations Fix...');
        Log::info('Starting Student Registrations Fix');
        
        DB::beginTransaction();
        
        try {
            // Get current data counts
            $studentsCount = Student::count();
            $studentUsersCount = User::whereHas('roles', function($query) {
                $query->where('name', 'student');
            })->count();
            
            $this->command->info("📊 Current Data:");
            $this->command->info("   - Students in students table: {$studentsCount}");
            $this->command->info("   - Users with student role: {$studentUsersCount}");
            
            // Find orphaned students (students without valid user accounts)
            $orphanedStudents = Student::whereDoesntHave('user')->get();
            $this->command->info("🔍 Found {$orphanedStudents->count()} orphaned students (no user account)");
            
            // Find orphaned users (users with student role but no student record)
            $orphanedUsers = User::whereHas('roles', function($query) {
                $query->where('name', 'student');
            })->whereDoesntHave('student')->get();
            $this->command->info("🔍 Found {$orphanedUsers->count()} orphaned users (no student record)");
            
            // Find students with invalid user_id references
            $invalidStudents = Student::whereNotNull('user_id')
                ->whereDoesntHave('user')
                ->get();
            $this->command->info("🔍 Found {$invalidStudents->count()} students with invalid user_id references");
            
            $this->command->info('🧹 Starting cleanup...');
            
            // Step 1: Remove orphaned students (except demo student)
            $preservedEmails = ['student@sman99.sch.id'];
            $orphanedToDelete = $orphanedStudents->whereNotIn('email', $preservedEmails);
            
            foreach ($orphanedToDelete as $student) {
                $this->command->info("   - Removing orphaned student: {$student->name} (NIS: {$student->nis})");
                $student->delete();
            }
            
            // Step 2: Remove orphaned users (except demo user)
            $orphanedUsersToDelete = $orphanedUsers->where('email', '!=', 'student@sman99.sch.id');
            
            foreach ($orphanedUsersToDelete as $user) {
                $this->command->info("   - Removing orphaned user: {$user->name} ({$user->email})");
                $user->delete();
            }
            
            // Step 3: Fix students with invalid user_id references
            foreach ($invalidStudents as $student) {
                if (!in_array($student->email, $preservedEmails)) {
                    $this->command->info("   - Removing student with invalid user_id: {$student->name} (NIS: {$student->nis})");
                    $student->delete();
                } else {
                    // For preserved students, try to find or create matching user
                    $user = User::where('email', $student->email)->first();
                    if ($user) {
                        $student->update(['user_id' => $user->id]);
                        $this->command->info("   - Fixed user_id for preserved student: {$student->name}");
                    }
                }
            }
            
            // Step 4: Ensure demo student has proper setup
            $demoUser = User::where('email', 'student@sman99.sch.id')->first();
            if ($demoUser) {
                $demoStudent = Student::where('email', 'student@sman99.sch.id')->first();
                if ($demoStudent && $demoStudent->user_id !== $demoUser->id) {
                    $demoStudent->update(['user_id' => $demoUser->id]);
                    $this->command->info("   - Fixed demo student user_id reference");
                }
                
                // Ensure demo user has student role
                $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
                if ($studentRole && !$demoUser->hasRole('student')) {
                    $demoUser->assignRole($studentRole);
                    $this->command->info("   - Assigned student role to demo user");
                }
            }
            
            DB::commit();
            
            // Show final counts
            $finalStudentsCount = Student::count();
            $finalStudentUsersCount = User::whereHas('roles', function($query) {
                $query->where('name', 'student');
            })->count();
            
            // Check for remaining inconsistencies
            $remainingOrphanedStudents = Student::whereDoesntHave('user')->count();
            $remainingOrphanedUsers = User::whereHas('roles', function($query) {
                $query->where('name', 'student');
            })->whereDoesntHave('student')->count();
            
            $this->command->info('📊 Final Data:');
            $this->command->info("   - Students: {$finalStudentsCount}");
            $this->command->info("   - Student Users: {$finalStudentUsersCount}");
            $this->command->info("   - Orphaned Students: {$remainingOrphanedStudents}");
            $this->command->info("   - Orphaned Users: {$remainingOrphanedUsers}");
            
            if ($remainingOrphanedStudents === 0 && $remainingOrphanedUsers === 0) {
                $this->command->info('✅ All data inconsistencies fixed!');
            } else {
                $this->command->warn('⚠️  Some inconsistencies remain. Manual review may be needed.');
            }
            
            $this->command->info('🎉 Student registrations fix completed!');
            $this->command->info('💡 The /admin/student-registrations page should now show correct data.');
            
            Log::info('Student registrations fix completed successfully', [
                'students_removed' => $studentsCount - $finalStudentsCount,
                'users_removed' => $studentUsersCount - $finalStudentUsersCount,
                'final_students' => $finalStudentsCount,
                'final_users' => $finalStudentUsersCount,
                'remaining_orphaned_students' => $remainingOrphanedStudents,
                'remaining_orphaned_users' => $remainingOrphanedUsers
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $this->command->error('❌ Student registrations fix failed: ' . $e->getMessage());
            Log::error('Student registrations fix failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}