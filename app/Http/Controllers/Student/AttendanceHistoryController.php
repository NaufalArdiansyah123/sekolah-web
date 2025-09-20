<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceHistoryController extends Controller
{
    /**
     * Show attendance history page - menggunakan data dari AttendanceLog yang sama dengan admin
     */
    public function index(Request $request)
    {
        $student = auth()->user()->student ?? Student::where('user_id', auth()->id())->first();
        
        if (!$student) {
            return redirect()->route('student.dashboard')
                           ->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get filter parameters
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        $status = $request->get('status', 'all');

        // Build query - menggunakan AttendanceLog yang sama dengan admin
        $query = AttendanceLog::where('student_id', $student->id)
                             ->whereMonth('attendance_date', $month)
                             ->whereYear('attendance_date', $year);

        // Apply status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Get attendance records with pagination
        $attendanceRecords = $query->orderBy('attendance_date', 'desc')
                                  ->orderBy('scan_time', 'desc')
                                  ->paginate(15);

        // Get monthly statistics
        $monthlyStats = AttendanceLog::where('student_id', $student->id)
                                   ->whereMonth('attendance_date', $month)
                                   ->whereYear('attendance_date', $year)
                                   ->selectRaw('status, count(*) as count')
                                   ->groupBy('status')
                                   ->pluck('count', 'status')
                                   ->toArray();

        // Get today's attendance
        $todayAttendance = AttendanceLog::where('student_id', $student->id)
                                      ->whereDate('attendance_date', today())
                                      ->first();

        // Get this week's attendance
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        
        $weeklyAttendance = AttendanceLog::where('student_id', $student->id)
                                       ->whereBetween('attendance_date', [$weekStart, $weekEnd])
                                       ->orderBy('attendance_date', 'desc')
                                       ->get();

        // Calculate attendance percentage for current month
        $totalDaysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        $currentDay = Carbon::now()->day;
        $workingDays = min($totalDaysInMonth, $currentDay); // Only count days that have passed
        
        $presentDays = ($monthlyStats['hadir'] ?? 0) + ($monthlyStats['terlambat'] ?? 0);
        $attendancePercentage = $workingDays > 0 ? ($presentDays / $workingDays) * 100 : 0;

        // Return view with cache busting headers
        return response()
            ->view('student.attendance.history', compact(
                'student',
                'attendanceRecords',
                'monthlyStats',
                'todayAttendance',
                'weeklyAttendance',
                'attendancePercentage',
                'month',
                'year',
                'status'
            ))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Get real-time attendance data via AJAX - menggunakan data dari AttendanceLog yang sama dengan admin
     */
    public function getRealTimeData(Request $request)
    {
        $student = auth()->user()->student ?? Student::where('user_id', auth()->id())->first();
        
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // Get latest attendance records - menggunakan AttendanceLog yang sama dengan admin
        $latestRecords = AttendanceLog::where('student_id', $student->id)
                                    ->whereMonth('attendance_date', $month)
                                    ->whereYear('attendance_date', $year)
                                    ->orderBy('attendance_date', 'desc')
                                    ->orderBy('scan_time', 'desc')
                                    ->limit(10)
                                    ->get()
                                    ->map(function($log) {
                                        return [
                                            'id' => $log->id,
                                            'date' => $log->attendance_date->format('d/m/Y'),
                                            'day' => $log->attendance_date->format('l'),
                                            'day_indo' => $this->getDayInIndonesian($log->attendance_date->format('l')),
                                            'status' => $log->status,
                                            'status_text' => $log->status_text,
                                            'status_badge' => $log->status_badge,
                                            'scan_time' => $log->scan_time->format('H:i:s'),
                                            'location' => $log->location,
                                            'created_at' => $log->created_at->diffForHumans(),
                                        ];
                                    });

        // Get today's attendance
        $todayAttendance = AttendanceLog::where('student_id', $student->id)
                                      ->whereDate('attendance_date', today())
                                      ->first();

        // Get monthly statistics
        $monthlyStats = AttendanceLog::where('student_id', $student->id)
                                   ->whereMonth('attendance_date', $month)
                                   ->whereYear('attendance_date', $year)
                                   ->selectRaw('status, count(*) as count')
                                   ->groupBy('status')
                                   ->pluck('count', 'status')
                                   ->toArray();

        // Calculate attendance percentage
        $totalDaysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        $currentDay = Carbon::now()->day;
        $workingDays = min($totalDaysInMonth, $currentDay);
        
        $presentDays = ($monthlyStats['hadir'] ?? 0) + ($monthlyStats['terlambat'] ?? 0);
        $attendancePercentage = $workingDays > 0 ? ($presentDays / $workingDays) * 100 : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'latest_records' => $latestRecords,
                'today_attendance' => $todayAttendance ? [
                    'status' => $todayAttendance->status,
                    'status_text' => $todayAttendance->status_text,
                    'status_badge' => $todayAttendance->status_badge,
                    'scan_time' => $todayAttendance->scan_time->format('H:i:s'),
                    'location' => $todayAttendance->location,
                ] : null,
                'monthly_stats' => $monthlyStats,
                'attendance_percentage' => round($attendancePercentage, 1),
                'working_days' => $workingDays,
                'present_days' => $presentDays,
                'last_updated' => now()->format('d/m/Y H:i:s')
            ]
        ]);
    }

    /**
     * Export attendance data - menggunakan data dari AttendanceLog yang sama dengan admin
     */
    public function export(Request $request)
    {
        $student = auth()->user()->student ?? Student::where('user_id', auth()->id())->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // Menggunakan AttendanceLog yang sama dengan admin
        $attendanceRecords = AttendanceLog::where('student_id', $student->id)
                                        ->whereMonth('attendance_date', $month)
                                        ->whereYear('attendance_date', $year)
                                        ->orderBy('attendance_date', 'desc')
                                        ->get();

        $monthName = Carbon::createFromDate($year, $month, 1)->format('F Y');
        $filename = 'Absensi_' . $student->name . '_' . $monthName . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($attendanceRecords, $student, $monthName) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, ['Data Absensi - ' . $student->name]);
            fputcsv($file, ['Periode: ' . $monthName]);
            fputcsv($file, ['NIS: ' . $student->nis]);
            fputcsv($file, ['Kelas: ' . $student->class]);
            fputcsv($file, []);
            
            // Column headers
            fputcsv($file, [
                'Tanggal',
                'Hari',
                'Status',
                'Waktu Scan',
                'Lokasi',
                'Keterangan'
            ]);
            
            // Data rows
            foreach ($attendanceRecords as $record) {
                fputcsv($file, [
                    $record->attendance_date->format('d/m/Y'),
                    $this->getDayInIndonesian($record->attendance_date->format('l')),
                    $record->status_text,
                    $record->scan_time->format('H:i:s'),
                    $record->location ?? '-',
                    $record->notes ?? '-'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get day name in Indonesian
     */
    private function getDayInIndonesian($dayName): string
    {
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        return $days[$dayName] ?? $dayName;
    }
}