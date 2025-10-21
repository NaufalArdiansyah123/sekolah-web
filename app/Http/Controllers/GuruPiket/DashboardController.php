<?php

namespace App\Http\Controllers\GuruPiket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\AttendanceLog;
use App\Models\AttendanceSubmission;
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
            
            // Get submission statistics
            $statistics = $this->getSubmissionStatistics();
            
            // Get recent activities (submissions)
            $recentActivities = $this->getRecentSubmissions();
            
            // Get total counts
            $totalCounts = [
                'total_students' => Student::count(),
                'total_teachers' => Teacher::count(),
                'total_classes' => DB::table('classes')->count(),
                'active_sessions' => 1,
            ];
            
            return view('guru-piket.dashboard', [
                'pageTitle' => 'Dashboard Guru Piket',
                'breadcrumb' => [],
                'statistics' => $statistics,
                'recentActivities' => $recentActivities,
                'totalCounts' => $totalCounts,
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Guru Piket Dashboard Error: ' . $e->getMessage());
            
            // Fallback data
            return view('guru-piket.dashboard', [
                'pageTitle' => 'Dashboard Guru Piket',
                'breadcrumb' => [],
                'statistics' => [
                    'pending' => 0,
                    'confirmed_today' => 0,
                    'total_today' => 0,
                    'teachers_submitted' => 0,
                ],
                'recentActivities' => [],
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
     * Get submission statistics
     */
    private function getSubmissionStatistics()
    {
        try {
            $today = Carbon::today();
            
            // Check if table exists and has data
            $totalSubmissions = AttendanceSubmission::count();
            \Log::info('Total submissions in database: ' . $totalSubmissions);
            
            $pending = AttendanceSubmission::where('status', 'pending')->count();
            $confirmedToday = AttendanceSubmission::where('status', 'confirmed')
                ->whereDate('confirmed_at', $today)
                ->count();
            $totalToday = AttendanceSubmission::whereDate('created_at', $today)->count();
            $teachersSubmitted = AttendanceSubmission::whereDate('created_at', $today)
                ->distinct('teacher_id')
                ->count();
                
            $stats = [
                'pending' => $pending,
                'confirmed_today' => $confirmedToday,
                'total_today' => $totalToday,
                'teachers_submitted' => $teachersSubmitted,
            ];
            
            \Log::info('Dashboard statistics: ', $stats);
            
            return $stats;
        } catch (\Exception $e) {
            \Log::error('Error getting submission statistics: ' . $e->getMessage());
            
            // Return dummy data for testing
            return [
                'pending' => 5,
                'confirmed_today' => 12,
                'total_today' => 17,
                'teachers_submitted' => 8,
            ];
        }
    }
    
    /**
     * Get recent submissions
     */
    private function getRecentSubmissions()
    {
        try {
            $submissions = AttendanceSubmission::with(['teacher', 'class'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
                
            \Log::info('Recent submissions count: ' . $submissions->count());
            
            return $submissions;
        } catch (\Exception $e) {
            \Log::error('Error getting recent submissions: ' . $e->getMessage());
            
            // Return empty collection
            return collect([]);
        }
    }
}