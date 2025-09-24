<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Student;
use App\Models\QrAttendance;
use App\Models\AttendanceLog;

class DebugStudentAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:student-attendance {--user-id= : Specific user ID to debug} {--email= : Specific user email to debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug student attendance issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 DEBUGGING STUDENT ATTENDANCE ISSUES');
        $this->line('');

        $userId = $this->option('user-id');
        $email = $this->option('email');

        if ($userId || $email) {
            $this->debugSpecificUser($userId, $email);
        } else {
            $this->debugOverall();
        }

        return 0;
    }

    private function debugSpecificUser($userId = null, $email = null)
    {
        $this->info('🎯 DEBUGGING SPECIFIC USER');
        
        // Find user
        $user = null;
        if ($userId) {
            $user = User::find($userId);
            $this->line("Looking for user ID: {$userId}");
        } elseif ($email) {
            $user = User::where('email', $email)->first();
            $this->line("Looking for user email: {$email}");
        }

        if (!$user) {
            $this->error('❌ User not found!');
            return;
        }

        $this->info("✅ User found: {$user->name} ({$user->email})");
        $this->line("   - ID: {$user->id}");
        $this->line("   - Roles: " . $user->roles->pluck('name')->join(', '));
        $this->line("   - Status: {$user->status}");
        $this->line("   - NIS: " . ($user->nis ?? 'not set'));
        $this->line('');

        // Check student relation
        $this->info('🔗 CHECKING STUDENT RELATION');
        $student = $user->student;
        if ($student) {
            $this->info("✅ Direct relation found: {$student->name}");
            $this->line("   - Student ID: {$student->id}");
            $this->line("   - NIS: {$student->nis}");
            $this->line("   - Class: {$student->class}");
            $this->line("   - Status: {$student->status}");
            $this->line("   - User ID: " . ($student->user_id ?? 'NULL'));
        } else {
            $this->warn('⚠️  No direct relation found');
            
            // Try alternative methods
            $this->line('🔍 Trying alternative methods...');
            
            // Method 1: Query by user_id
            $studentByUserId = Student::where('user_id', $user->id)->first();
            if ($studentByUserId) {
                $this->info("✅ Found by user_id query: {$studentByUserId->name}");
                $student = $studentByUserId;
            } else {
                $this->line("   ❌ Not found by user_id query");
            }
            
            // Method 2: Query by email
            if ($user->email) {
                $studentByEmail = Student::where('email', $user->email)->first();
                if ($studentByEmail) {
                    $this->info("✅ Found by email query: {$studentByEmail->name}");
                    if (!$student) $student = $studentByEmail;
                    
                    if (!$studentByEmail->user_id) {
                        $this->warn("   ⚠️  Student has no user_id set");
                    }
                } else {
                    $this->line("   ❌ Not found by email query");
                }
            }
            
            // Method 3: Query by NIS
            if ($user->nis) {
                $studentByNis = Student::where('nis', $user->nis)->first();
                if ($studentByNis) {
                    $this->info("✅ Found by NIS query: {$studentByNis->name}");
                    if (!$student) $student = $studentByNis;
                    
                    if (!$studentByNis->user_id) {
                        $this->warn("   ⚠️  Student has no user_id set");
                    }
                } else {
                    $this->line("   ❌ Not found by NIS query");
                }
            }
        }

        if (!$student) {
            $this->error('❌ No student record found for this user!');
            $this->line('');
            $this->info('💡 RECOMMENDATIONS:');
            $this->line('1. Create a student record for this user');
            $this->line('2. Or link existing student record to this user');
            $this->line('3. Run: php artisan fix:student-user-relations');
            return;
        }

        $this->line('');

        // Check QR attendance
        $this->info('📱 CHECKING QR ATTENDANCE');
        $qrAttendance = $student->qrAttendance;
        if ($qrAttendance) {
            $this->info("✅ QR Code found: {$qrAttendance->qr_code}");
            $this->line("   - QR ID: {$qrAttendance->id}");
            $this->line("   - Image path: " . ($qrAttendance->qr_image_path ?? 'not set'));
            $this->line("   - Created: {$qrAttendance->created_at}");
            
            // Check if image file exists
            if ($qrAttendance->qr_image_path) {
                $imagePath = storage_path('app/public/' . $qrAttendance->qr_image_path);
                if (file_exists($imagePath)) {
                    $this->info("   ✅ Image file exists");
                } else {
                    $this->warn("   ⚠️  Image file missing: {$imagePath}");
                }
            }
        } else {
            $this->warn('⚠️  No QR Code found for this student');
            $this->line('💡 Generate QR Code from admin panel or run:');
            $this->line("   php artisan qr:generate-student {$student->id}");
        }

        $this->line('');

        // Check attendance logs
        $this->info('📋 CHECKING ATTENDANCE LOGS');
        $attendanceLogs = $student->attendanceLogs()->orderBy('attendance_date', 'desc')->take(5)->get();
        if ($attendanceLogs->count() > 0) {
            $this->info("✅ Found {$attendanceLogs->count()} recent attendance logs:");
            foreach ($attendanceLogs as $log) {
                $this->line("   - {$log->attendance_date->format('Y-m-d')}: {$log->status} at {$log->scan_time->format('H:i:s')}");
            }
        } else {
            $this->warn('⚠️  No attendance logs found');
        }

        $this->line('');

        // Test authentication simulation
        $this->info('🔐 TESTING AUTHENTICATION SIMULATION');
        try {
            // Simulate login
            auth()->login($user);
            $this->info("✅ User logged in successfully");
            
            // Test student retrieval methods
            $testStudent1 = auth()->user()->student;
            $testStudent2 = Student::where('user_id', auth()->id())->first();
            
            $this->line("   - Direct relation: " . ($testStudent1 ? $testStudent1->name : 'not found'));
            $this->line("   - Query method: " . ($testStudent2 ? $testStudent2->name : 'not found'));
            
            auth()->logout();
            $this->info("✅ User logged out");
            
        } catch (\Exception $e) {
            $this->error("❌ Authentication test failed: " . $e->getMessage());
        }

        $this->line('');
        $this->info('🎯 DIAGNOSIS COMPLETE');
    }

    private function debugOverall()
    {
        $this->info('📊 OVERALL SYSTEM ANALYSIS');
        $this->line('');

        // 1. Users with student role
        $this->info('1. USERS WITH STUDENT ROLE:');
        $studentUsers = User::role('student')->get();
        $this->line("   Total: {$studentUsers->count()}");
        
        $usersWithStudent = 0;
        $usersWithoutStudent = 0;
        
        foreach ($studentUsers as $user) {
            if ($user->student) {
                $usersWithStudent++;
            } else {
                $usersWithoutStudent++;
                $this->line("   ❌ User '{$user->email}' has no student record");
            }
        }
        
        $this->line("   ✅ With student record: {$usersWithStudent}");
        $this->line("   ❌ Without student record: {$usersWithoutStudent}");
        $this->line('');

        // 2. Students table analysis
        $this->info('2. STUDENTS TABLE ANALYSIS:');
        $totalStudents = Student::count();
        $studentsWithUserId = Student::whereNotNull('user_id')->count();
        $studentsWithoutUserId = Student::whereNull('user_id')->count();
        
        $this->line("   Total students: {$totalStudents}");
        $this->line("   ✅ With user_id: {$studentsWithUserId}");
        $this->line("   ❌ Without user_id: {$studentsWithoutUserId}");
        
        // Check for orphaned user_ids
        $orphanedUserIds = Student::whereNotNull('user_id')
                                 ->whereNotExists(function($query) {
                                     $query->select(\DB::raw(1))
                                           ->from('users')
                                           ->whereRaw('users.id = students.user_id');
                                 })
                                 ->count();
        
        if ($orphanedUserIds > 0) {
            $this->line("   ⚠️  Orphaned user_ids: {$orphanedUserIds}");
        }
        
        $this->line('');

        // 3. QR Attendance analysis
        $this->info('3. QR ATTENDANCE ANALYSIS:');
        $totalQrCodes = QrAttendance::count();
        $studentsWithQr = Student::whereHas('qrAttendance')->count();
        $studentsWithoutQr = Student::whereDoesntHave('qrAttendance')->count();
        
        $this->line("   Total QR codes: {$totalQrCodes}");
        $this->line("   ✅ Students with QR: {$studentsWithQr}");
        $this->line("   ❌ Students without QR: {$studentsWithoutQr}");
        
        // Check for missing QR image files
        $qrWithMissingImages = QrAttendance::whereNotNull('qr_image_path')
                                          ->get()
                                          ->filter(function($qr) {
                                              $imagePath = storage_path('app/public/' . $qr->qr_image_path);
                                              return !file_exists($imagePath);
                                          })
                                          ->count();
        
        if ($qrWithMissingImages > 0) {
            $this->line("   ⚠️  QR codes with missing image files: {$qrWithMissingImages}");
        }
        
        $this->line('');

        // 4. Attendance logs analysis
        $this->info('4. ATTENDANCE LOGS ANALYSIS:');
        $totalLogs = AttendanceLog::count();
        $logsToday = AttendanceLog::whereDate('attendance_date', today())->count();
        $logsThisMonth = AttendanceLog::whereMonth('attendance_date', now()->month)
                                    ->whereYear('attendance_date', now()->year)
                                    ->count();
        
        $this->line("   Total logs: {$totalLogs}");
        $this->line("   Today: {$logsToday}");
        $this->line("   This month: {$logsThisMonth}");
        $this->line('');

        // 5. Common issues
        $this->info('5. COMMON ISSUES DETECTED:');
        $issues = [];
        
        if ($usersWithoutStudent > 0) {
            $issues[] = "Users with student role but no student record: {$usersWithoutStudent}";
        }
        
        if ($studentsWithoutUserId > 0) {
            $issues[] = "Students without user_id: {$studentsWithoutUserId}";
        }
        
        if ($orphanedUserIds > 0) {
            $issues[] = "Students with invalid user_id: {$orphanedUserIds}";
        }
        
        if ($studentsWithoutQr > 0) {
            $issues[] = "Students without QR codes: {$studentsWithoutQr}";
        }
        
        if ($qrWithMissingImages > 0) {
            $issues[] = "QR codes with missing image files: {$qrWithMissingImages}";
        }
        
        if (empty($issues)) {
            $this->info("   ✅ No major issues detected!");
        } else {
            foreach ($issues as $issue) {
                $this->line("   ⚠️  {$issue}");
            }
        }
        
        $this->line('');
        
        // 6. Recommendations
        $this->info('💡 RECOMMENDATIONS:');
        if (!empty($issues)) {
            $this->line('1. Run: php artisan fix:student-user-relations --dry-run');
            $this->line('2. Review the proposed fixes');
            $this->line('3. Run: php artisan fix:student-user-relations (without --dry-run)');
            $this->line('4. Generate missing QR codes from admin panel');
            $this->line('5. Re-run this debug command to verify fixes');
        } else {
            $this->line('✅ System appears to be working correctly!');
            $this->line('If users still report issues, debug specific users with:');
            $this->line('php artisan debug:student-attendance --email=user@example.com');
        }
    }
}