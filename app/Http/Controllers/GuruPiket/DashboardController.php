<?php

namespace App\Http\Controllers\GuruPiket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\AttendanceLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get today's date
            $today = Carbon::today();
            
            // Get attendance statistics for today
            $todayAttendance = $this->getTodayAttendanceStats();
            
            // Get weekly attendance trend
            $weeklyTrend = $this->getWeeklyAttendanceTrend();
            
            // Get recent attendance activities
            $recentActivities = $this->getRecentAttendanceActivities();
            
            // Get class attendance summary
            $classAttendanceSummary = $this->getClassAttendanceSummary();
            
            // Get teacher attendance summary
            $teacherAttendanceSummary = $this->getTeacherAttendanceSummary();
            
            // Get total counts
            $totalCounts = [
                'total_students' => Student::count(),
                'total_teachers' => Teacher::count(),
                'total_classes' => DB::table('classes')->count(),
                'active_sessions' => 1, // Assuming one session per day
            ];
            
            return view('guru-piket.dashboard', [
                'pageTitle' => 'Dashboard Guru Piket',
                'breadcrumb' => [],
                'todayAttendance' => $todayAttendance,
                'weeklyTrend' => $weeklyTrend,
                'recentActivities' => $recentActivities,
                'classAttendanceSummary' => $classAttendanceSummary,
                'teacherAttendanceSummary' => $teacherAttendanceSummary,
                'totalCounts' => $totalCounts,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Guru Piket Dashboard Error: ' . $e->getMessage());
            
            // Fallback data
            return view('guru-piket.dashboard', [
                'pageTitle' => 'Dashboard Guru Piket',
                'breadcrumb' => [],
                'todayAttendance' => [
                    'hadir' => 0,
                    'terlambat' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alpha' => 0,
                    'total_scanned' => 0,
                ],
                'weeklyTrend' => [],
                'recentActivities' => [],
                'classAttendanceSummary' => [],
                'teacherAttendanceSummary' => [],
                'totalCounts' => [
                    'total_students' => 0,
                    'total_teachers' => 0,
                    'total_classes' => 0,
                    'active_sessions' => 0,
                ],
            ]);
        }
    }
    
    /**
     * Get today's attendance statistics
     */
    private function getTodayAttendanceStats()
    {
        $today = Carbon::today();
        
        $stats = AttendanceLog::whereDate('attendance_date', $today)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        return [
            'hadir' => $stats['hadir'] ?? 0,
            'terlambat' => $stats['terlambat'] ?? 0,
            'izin' => $stats['izin'] ?? 0,
            'sakit' => $stats['sakit'] ?? 0,
            'alpha' => $stats['alpha'] ?? 0,
            'total_scanned' => array_sum($stats),
        ];
    }
    
    /**
     * Get weekly attendance trend
     */
    private function getWeeklyAttendanceTrend()
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        
        $trend = [];
        for ($date = $weekStart->copy(); $date->lte($weekEnd); $date->addDay()) {
            $dayStats = AttendanceLog::whereDate('attendance_date', $date)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
                
            $trend[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('l'),
                'day_short' => $date->format('D'),
                'hadir' => $dayStats['hadir'] ?? 0,
                'terlambat' => $dayStats['terlambat'] ?? 0,
                'izin' => $dayStats['izin'] ?? 0,
                'sakit' => $dayStats['sakit'] ?? 0,
                'alpha' => $dayStats['alpha'] ?? 0,
                'total' => array_sum($dayStats),
            ];
        }
        
        return $trend;
    }
    
    /**
     * Get recent attendance activities
     */
    private function getRecentAttendanceActivities()
    {
        return AttendanceLog::with(['student.user', 'student.class'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'student_name' => $log->student->user->name ?? 'Unknown',
                    'student_nis' => $log->student->nis ?? 'N/A',
                    'class_name' => $log->student->class->name ?? 'No Class',
                    'status' => $log->status,
                    'scan_time' => $log->scan_time ? Carbon::parse($log->scan_time)->format('H:i') : 'N/A',
                    'attendance_date' => Carbon::parse($log->attendance_date)->format('d/m/Y'),
                    'scanned_by' => $log->scanned_by ?? 'System',
                    'created_at' => $log->created_at->diffForHumans(),
                ];
            });
    }
    
    /**
     * Get class attendance summary
     */
    private function getClassAttendanceSummary()
    {
        $today = Carbon::today();
        
        return DB::table('classes')
            ->leftJoin('students', 'classes.id', '=', 'students.class_id')
            ->leftJoin('attendance_logs', function($join) use ($today) {
                $join->on('students.id', '=', 'attendance_logs.student_id')
                     ->whereDate('attendance_logs.attendance_date', $today);
            })
            ->select(
                'classes.id',
                'classes.name as class_name',
                DB::raw('COUNT(DISTINCT students.id) as total_students'),
                DB::raw('COUNT(DISTINCT attendance_logs.id) as total_present'),
                DB::raw('COUNT(DISTINCT students.id) - COUNT(DISTINCT attendance_logs.id) as total_absent')
            )
            ->groupBy('classes.id', 'classes.name')
            ->orderBy('classes.name')
            ->get()
            ->map(function ($class) {
                $attendanceRate = $class->total_students > 0 
                    ? round(($class->total_present / $class->total_students) * 100, 1)
                    : 0;
                    
                return [
                    'class_name' => $class->class_name,
                    'total_students' => $class->total_students,
                    'total_present' => $class->total_present,
                    'total_absent' => $class->total_absent,
                    'attendance_rate' => $attendanceRate,
                ];
            });
    }
    
    /**
     * Get teacher attendance summary
     */
    private function getTeacherAttendanceSummary()
    {
        // For now, return placeholder data
        // This can be expanded when teacher attendance system is implemented
        return [
            'total_teachers' => Teacher::count(),
            'present_today' => Teacher::count(), // Placeholder
            'absent_today' => 0, // Placeholder
            'attendance_rate' => 100, // Placeholder
        ];
    }
}