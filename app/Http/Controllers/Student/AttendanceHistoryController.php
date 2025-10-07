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
     * Get student data with multiple fallback methods - same as AttendanceController
     */
    private function getStudentData()
    {
        $user = auth()->user();
        
        \Log::info('Getting student data for attendance history:', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_roles' => $user->roles->pluck('name')->toArray()
        ]);

        // Method 1: Try direct relation
        $student = $user->student;
        if ($student) {
            \Log::info('Student found via direct relation:', [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'student_nis' => $student->nis
            ]);
            return $student;
        }

        // Method 2: Try query by user_id
        $student = Student::where('user_id', $user->id)->first();
        if ($student) {
            \Log::info('Student found via user_id query:', [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'student_nis' => $student->nis
            ]);
            return $student;
        }

        // Method 3: Try by email if user has email
        if ($user->email) {
            $student = Student::where('email', $user->email)->first();
            if ($student) {
                \Log::info('Student found via email match:', [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'student_nis' => $student->nis
                ]);
                
                // Update user_id if missing
                if (!$student->user_id) {
                    $student->update(['user_id' => $user->id]);
                    \Log::info('Updated student user_id:', ['student_id' => $student->id]);
                }
                
                return $student;
            }
        }

        // Method 4: Try by NIS if user has NIS field
        if (isset($user->nis) && $user->nis) {
            $student = Student::where('nis', $user->nis)->first();
            if ($student) {
                \Log::info('Student found via NIS match:', [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'student_nis' => $student->nis
                ]);
                
                // Update user_id if missing
                if (!$student->user_id) {
                    $student->update(['user_id' => $user->id]);
                    \Log::info('Updated student user_id:', ['student_id' => $student->id]);
                }
                
                return $student;
            }
        }

        \Log::error('No student data found for attendance history:', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_nis' => $user->nis ?? 'not_set',
            'methods_tried' => ['direct_relation', 'user_id_query', 'email_match', 'nis_match']
        ]);

        return null;
    }

    /**
     * Show attendance history page - menggunakan data dari AttendanceLog yang sama dengan admin
     */
    public function index(Request $request)
    {
        try {
            $student = $this->getStudentData();
            
            if (!$student) {
                \Log::error('Student data not found for attendance history page', [
                    'user_id' => auth()->id(),
                    'user_email' => auth()->user()->email
                ]);
                
                return view('student.attendance.error', [
                    'error_type' => 'student_not_found',
                    'error_message' => 'Data siswa tidak ditemukan. Silakan hubungi administrator.',
                    'debug_info' => [
                        'user_id' => auth()->id(),
                        'user_email' => auth()->user()->email,
                        'user_roles' => auth()->user()->roles->pluck('name')->toArray(),
                        'page' => 'attendance_history'
                    ]
                ]);
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

            \Log::info('Attendance history page loaded successfully', [
                'student_id' => $student->id,
                'month' => $month,
                'year' => $year,
                'records_count' => $attendanceRecords->count(),
                'attendance_percentage' => $attendancePercentage
            ]);

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

        } catch (\Exception $e) {
            \Log::error('Error loading attendance history page:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            return view('student.attendance.error', [
                'error_type' => 'system_error',
                'error_message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.',
                'debug_info' => [
                    'error' => $e->getMessage(),
                    'user_id' => auth()->id(),
                    'page' => 'attendance_history'
                ]
            ]);
        }
    }

    /**
     * Get real-time attendance data via AJAX - menggunakan data dari AttendanceLog yang sama dengan admin
     */
    public function getRealTimeData(Request $request)
    {
        try {
            $student = $this->getStudentData();
            
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

        } catch (\Exception $e) {
            \Log::error('Error getting real-time attendance data:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat mengambil data real-time.'
            ], 500);
        }
    }

    /**
     * Export attendance data - menggunakan data dari AttendanceLog yang sama dengan admin
     */
    public function export(Request $request)
    {
        try {
            $student = $this->getStudentData();
            
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

        } catch (\Exception $e) {
            \Log::error('Error exporting attendance data:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengekspor data absensi.');
        }
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