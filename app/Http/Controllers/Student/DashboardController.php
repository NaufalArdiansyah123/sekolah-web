<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceSession;
use App\Models\Attendance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get current student info for debugging
            $student = \App\Models\Student::where('user_id', auth()->id())->with('class')->first();
            
            // Get statistics for student dashboard with error handling
            $stats = [
                'attendance_percentage' => $this->getAttendancePercentage(),
                'total_attendance_sessions' => $this->getAttendanceStats('total'),
                'total_notifications' => 0, // Placeholder for notifications
                'profile_completion' => 85, // Placeholder for profile completion
            ];
            
            // Debug info for troubleshooting
            $debugInfo = [
                'user_id' => auth()->id(),
                'student_found' => $student ? true : false,
                'student_class_id' => $student ? $student->class_id : null,
                'student_class_name' => $student && $student->class ? $student->class->name : null,
            ];

            // No longer needed - materials, assignments, and quizzes removed

        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            
            // Fallback data
            $stats = [
                'attendance_percentage' => 0,
                'total_attendance_sessions' => 0,
                'total_notifications' => 0,
                'profile_completion' => 85,
            ];
            $debugInfo = [
                'user_id' => auth()->id(),
                'student_found' => false,
                'student_class_id' => null,
                'student_class_name' => null,
                'error' => $e->getMessage()
            ];
        }

        return view('student.dashboard', [
            'pageTitle' => 'Dashboard Siswa',
            'breadcrumb' => [],
            'stats' => $stats,
            'debugInfo' => $debugInfo,
            'student' => $student
        ]);
    }





    /**
     * Get attendance statistics
     */
    private function getAttendanceStats($type = 'total')
    {
        try {
            $userId = auth()->id();
            
            switch ($type) {
                case 'total':
                    return AttendanceSession::count();
                    
                case 'present':
                    return Attendance::where('student_id', $userId)
                        ->where('status', 'present')
                        ->count();
                        
                case 'absent':
                    return Attendance::where('student_id', $userId)
                        ->where('status', 'absent')
                        ->count();
                        
                default:
                    return 0;
            }
        } catch (\Exception $e) {
            Log::warning("Failed to get attendance stats ({$type}): " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get attendance percentage
     */
    private function getAttendancePercentage()
    {
        try {
            $userId = auth()->id();
            
            $totalSessions = AttendanceSession::count();
            if ($totalSessions == 0) {
                return 0;
            }
            
            $presentCount = Attendance::where('student_id', $userId)
                ->where('status', 'present')
                ->count();
                
            return round(($presentCount / $totalSessions) * 100, 1);
        } catch (\Exception $e) {
            Log::warning("Failed to get attendance percentage: " . $e->getMessage());
            return 0;
        }
    }


}