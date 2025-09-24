<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Student;

class FixStudentUserRelations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:student-user-relations {--dry-run : Show what would be fixed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix inconsistent data between users and students tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('🔍 DRY RUN MODE - No changes will be made');
        } else {
            $this->info('🔧 FIXING MODE - Changes will be applied');
        }
        
        $this->line('');
        
        // 1. Find students without user_id but with matching email
        $this->info('1. Finding students without user_id but with matching email...');
        $studentsWithoutUserId = Student::whereNull('user_id')
                                       ->whereNotNull('email')
                                       ->get();
        
        $fixedByEmail = 0;
        foreach ($studentsWithoutUserId as $student) {
            $user = User::where('email', $student->email)->first();
            if ($user) {
                $this->line("   📧 Student '{$student->name}' (ID: {$student->id}) matches User '{$user->email}' (ID: {$user->id})");
                
                if (!$dryRun) {
                    $student->update(['user_id' => $user->id]);
                    
                    // Ensure user has student role
                    if (!$user->hasRole('student')) {
                        $user->assignRole('student');
                        $this->line("   ✅ Assigned 'student' role to user {$user->email}");
                    }
                }
                $fixedByEmail++;
            }
        }
        
        $this->info("   Found {$fixedByEmail} students that can be linked by email");
        $this->line('');
        
        // 2. Find students without user_id but with matching NIS
        $this->info('2. Finding students without user_id but with matching NIS...');
        $studentsWithoutUserIdByNis = Student::whereNull('user_id')
                                            ->whereNotNull('nis')
                                            ->get();
        
        $fixedByNis = 0;
        foreach ($studentsWithoutUserIdByNis as $student) {
            // Skip if already fixed by email
            if ($student->user_id) continue;
            
            $user = User::where('nis', $student->nis)->first();
            if ($user) {
                $this->line("   🆔 Student '{$student->name}' (NIS: {$student->nis}) matches User '{$user->email}' (ID: {$user->id})");
                
                if (!$dryRun) {
                    $student->update(['user_id' => $user->id]);
                    
                    // Ensure user has student role
                    if (!$user->hasRole('student')) {
                        $user->assignRole('student');
                        $this->line("   ✅ Assigned 'student' role to user {$user->email}");
                    }
                }
                $fixedByNis++;
            }
        }
        
        $this->info("   Found {$fixedByNis} students that can be linked by NIS");
        $this->line('');
        
        // 3. Find users with student role but no student record
        $this->info('3. Finding users with student role but no student record...');
        $studentUsers = User::role('student')->get();
        $usersWithoutStudent = 0;
        
        foreach ($studentUsers as $user) {
            $student = $user->student;
            if (!$student) {
                $this->line("   👤 User '{$user->email}' (ID: {$user->id}) has student role but no student record");
                
                // Try to find student by email
                $studentByEmail = Student::where('email', $user->email)->first();
                if ($studentByEmail && !$studentByEmail->user_id) {
                    $this->line("      📧 Found matching student by email: '{$studentByEmail->name}' (ID: {$studentByEmail->id})");
                    if (!$dryRun) {
                        $studentByEmail->update(['user_id' => $user->id]);
                        $this->line("      ✅ Linked student to user");
                    }
                } else {
                    // Try to find student by NIS if user has NIS
                    if (isset($user->nis) && $user->nis) {
                        $studentByNis = Student::where('nis', $user->nis)->first();
                        if ($studentByNis && !$studentByNis->user_id) {
                            $this->line("      🆔 Found matching student by NIS: '{$studentByNis->name}' (ID: {$studentByNis->id})");
                            if (!$dryRun) {
                                $studentByNis->update(['user_id' => $user->id]);
                                $this->line("      ✅ Linked student to user");
                            }
                        } else {
                            $this->line("      ❌ No matching student found");
                        }
                    } else {
                        $this->line("      ❌ No matching student found");
                    }
                }
                $usersWithoutStudent++;
            }
        }
        
        $this->info("   Found {$usersWithoutStudent} users with student role but no student record");
        $this->line('');
        
        // 4. Find duplicate user_id in students table
        $this->info('4. Finding duplicate user_id in students table...');
        $duplicateUserIds = Student::whereNotNull('user_id')
                                  ->groupBy('user_id')
                                  ->havingRaw('COUNT(*) > 1')
                                  ->pluck('user_id');
        
        foreach ($duplicateUserIds as $userId) {
            $students = Student::where('user_id', $userId)->get();
            $this->line("   ⚠️  User ID {$userId} is linked to multiple students:");
            foreach ($students as $student) {
                $this->line("      - Student '{$student->name}' (ID: {$student->id}, NIS: {$student->nis})");
            }
            
            if (!$dryRun) {
                // Keep the first student, remove user_id from others
                $firstStudent = $students->first();
                $otherStudents = $students->skip(1);
                
                foreach ($otherStudents as $student) {
                    $student->update(['user_id' => null]);
                    $this->line("      ✅ Removed user_id from student '{$student->name}' (ID: {$student->id})");
                }
            }
        }
        
        $this->info("   Found {$duplicateUserIds->count()} duplicate user_id entries");
        $this->line('');
        
        // 5. Summary
        $this->info('📊 SUMMARY:');
        $this->line("   - Students fixed by email: {$fixedByEmail}");
        $this->line("   - Students fixed by NIS: {$fixedByNis}");
        $this->line("   - Users without student record: {$usersWithoutStudent}");
        $this->line("   - Duplicate user_id entries: {$duplicateUserIds->count()}");
        
        if ($dryRun) {
            $this->line('');
            $this->warn('🔍 This was a dry run. No changes were made.');
            $this->info('Run without --dry-run to apply the fixes.');
        } else {
            $this->line('');
            $this->info('✅ Fixes have been applied!');
            $this->info('You may want to run this command again to verify all issues are resolved.');
        }
        
        return 0;
    }
}