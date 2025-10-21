<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttendanceSubmission;
use App\Models\User;
use App\Models\Classes;
use Carbon\Carbon;

class AttendanceSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some teachers and classes
        $teachers = User::where('role', 'teacher')->take(5)->get();
        $guruPikets = User::where('role', 'guru_piket')->take(2)->get();
        $classes = Classes::take(3)->get();

        if ($teachers->isEmpty()) {
            // Create dummy teachers if none exist
            $teachers = collect([
                User::create([
                    'name' => 'Dr. Rahman, M.Pd',
                    'email' => 'rahman@school.com',
                    'password' => bcrypt('password'),
                    'role' => 'teacher',
                    'email_verified_at' => now()
                ]),
                User::create([
                    'name' => 'Sari Andini, S.Pd',
                    'email' => 'sari@school.com',
                    'password' => bcrypt('password'),
                    'role' => 'teacher',
                    'email_verified_at' => now()
                ]),
                User::create([
                    'name' => 'Budi Prasetyo, S.Si',
                    'email' => 'budi@school.com',
                    'password' => bcrypt('password'),
                    'role' => 'teacher',
                    'email_verified_at' => now()
                ])
            ]);
        }

        if ($guruPikets->isEmpty()) {
            // Create dummy guru piket if none exist
            $guruPikets = collect([
                User::create([
                    'name' => 'Guru Piket 1',
                    'email' => 'piket1@school.com',
                    'password' => bcrypt('password'),
                    'role' => 'guru_piket',
                    'email_verified_at' => now()
                ])
            ]);
        }

        if ($classes->isEmpty()) {
            // Create dummy classes if none exist
            $classes = collect([
                Classes::create([
                    'name' => 'XII IPA 1',
                    'grade' => '12',
                    'major' => 'IPA',
                    'academic_year' => '2024/2025'
                ]),
                Classes::create([
                    'name' => 'XII IPA 2',
                    'grade' => '12',
                    'major' => 'IPA',
                    'academic_year' => '2024/2025'
                ]),
                Classes::create([
                    'name' => 'XII IPS 1',
                    'grade' => '12',
                    'major' => 'IPS',
                    'academic_year' => '2024/2025'
                ])
            ]);
        }

        $subjects = ['Matematika', 'Bahasa Indonesia', 'Fisika', 'Kimia', 'Biologi', 'Sejarah', 'Geografi'];
        $sessionTimes = ['07:00-08:30', '08:30-10:00', '10:15-11:45', '12:30-14:00', '14:00-15:30'];
        $statuses = ['pending', 'confirmed', 'rejected'];

        // Create submissions for the last 7 days
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::today()->subDays($i);
            
            // Create 3-5 submissions per day
            $submissionsPerDay = rand(3, 5);
            
            for ($j = 0; $j < $submissionsPerDay; $j++) {
                $teacher = $teachers->random();
                $class = $classes->random();
                $subject = $subjects[array_rand($subjects)];
                $sessionTime = $sessionTimes[array_rand($sessionTimes)];
                $status = $statuses[array_rand($statuses)];
                
                // Generate attendance data for 30-35 students
                $totalStudents = rand(30, 35);
                $attendanceData = [];
                
                for ($k = 1; $k <= $totalStudents; $k++) {
                    $studentStatus = ['hadir', 'terlambat', 'izin', 'sakit', 'alpha'][array_rand(['hadir', 'terlambat', 'izin', 'sakit', 'alpha'])];
                    
                    // Most students should be present
                    if (rand(1, 100) <= 85) {
                        $studentStatus = rand(1, 100) <= 90 ? 'hadir' : 'terlambat';
                    }
                    
                    $attendanceData[] = [
                        'student_id' => $k,
                        'student_name' => 'Siswa ' . $k,
                        'nis' => '2024' . str_pad($k, 3, '0', STR_PAD_LEFT),
                        'status' => $studentStatus,
                        'scan_time' => $studentStatus === 'hadir' || $studentStatus === 'terlambat' ? 
                            sprintf('%02d:%02d', rand(7, 8), rand(0, 59)) : null,
                        'notes' => $studentStatus === 'izin' || $studentStatus === 'sakit' ? 
                            'Keterangan ' . $studentStatus : null
                    ];
                }
                
                // Calculate statistics
                $presentCount = count(array_filter($attendanceData, fn($s) => in_array($s['status'], ['hadir', 'terlambat'])));
                $lateCount = count(array_filter($attendanceData, fn($s) => $s['status'] === 'terlambat'));
                $absentCount = $totalStudents - $presentCount;
                
                $submission = AttendanceSubmission::create([
                    'teacher_id' => $teacher->id,
                    'guru_piket_id' => $status === 'confirmed' ? $guruPikets->first()->id : null,
                    'submission_date' => $date,
                    'class_id' => $class->id,
                    'subject' => $subject,
                    'session_time' => $sessionTime,
                    'total_students' => $totalStudents,
                    'present_count' => $presentCount,
                    'late_count' => $lateCount,
                    'absent_count' => $absentCount,
                    'attendance_data' => $attendanceData,
                    'notes' => 'Submission absensi untuk ' . $subject . ' kelas ' . $class->name,
                    'status' => $status,
                    'submitted_at' => $date->copy()->addHours(rand(7, 15))->addMinutes(rand(0, 59)),
                    'confirmed_at' => $status === 'confirmed' ? $date->copy()->addHours(rand(16, 20)) : null,
                    'confirmed_by' => $status === 'confirmed' ? $guruPikets->first()->id : null
                ]);
                
                echo "Created submission: {$teacher->name} - {$class->name} - {$subject} - {$date->format('Y-m-d')} - {$status}\n";
            }
        }
        
        echo "\n✅ AttendanceSubmission seeder completed!\n";
        echo "📊 Total submissions created: " . AttendanceSubmission::count() . "\n";
        echo "⏳ Pending: " . AttendanceSubmission::where('status', 'pending')->count() . "\n";
        echo "✅ Confirmed: " . AttendanceSubmission::where('status', 'confirmed')->count() . "\n";
        echo "❌ Rejected: " . AttendanceSubmission::where('status', 'rejected')->count() . "\n";
    }
}