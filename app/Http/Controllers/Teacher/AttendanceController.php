<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\AttendanceLog;
use App\Models\QrAttendance;
use App\Models\Classes;
use App\Exports\AttendanceExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    public function index(Request $request)
    {
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        $selectedClass = $request->get('class');

        // Get available classes from classes table
        $classes = Classes::where('is_active', true)
                         ->pluck('name')
                         ->sort()
                         ->values();

        // Set default class if not provided
        if (!$selectedClass && $classes->isNotEmpty()) {
            $selectedClass = $classes->first();
        }

        // Get students by class with their attendance data for the selected date
        $students = Student::active()
                          ->whereHas('class', function($q) use ($selectedClass) {
                              $q->where('name', $selectedClass);
                          })
                          ->with([
                              'class',
                              'attendanceLogs' => function($query) use ($selectedDate) {
                                  $query->whereDate('attendance_date', $selectedDate);
                              }
                          ])
                          ->orderBy('name')
                          ->get();

        // Handle export requests
        if ($request->has('export')) {
            return $this->exportAttendance($request);
        }
        
        // Get attendance data for selected date and class from attendance_logs table
        $attendanceData = $this->getAttendanceByDate($selectedDate, $selectedClass);
        
        // Calculate statistics based on actual attendance logs
        $statistics = $this->calculateStatistics($attendanceData, $students->count());
        
        return view('teacher.attendance.index', compact(
            'students', 
            'attendanceData', 
            'statistics', 
            'selectedDate', 
            'selectedClass', 
            'classes'
        ));
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha,present,absent,sick,permission',
            'notes' => 'nullable|string|max:500',
            'scan_time' => 'nullable|string'
        ]);

        // Map old status to new status for backward compatibility
        $statusMapping = [
            'present' => 'hadir',
            'absent' => 'alpha',
            'sick' => 'sakit',
            'permission' => 'izin'
        ];

        $status = $statusMapping[$request->status] ?? $request->status;

        $student = Student::findOrFail($request->student_id);
        
        // Parse time if provided
        $scanTime = null;
        if ($request->scan_time) {
            $scanTime = Carbon::parse($request->date . ' ' . $request->scan_time);
        } else {
            $scanTime = now();
        }
        
        // Create or update attendance log
        $attendanceLog = AttendanceLog::updateOrCreate([
            'student_id' => $request->student_id,
            'attendance_date' => $request->date,
        ], [
            'status' => $status,
            'notes' => $request->notes,
            'scan_time' => $scanTime,
            'location' => 'Manual Entry by Teacher',
            'qr_code' => $student->qrAttendance->qr_code ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dicatat',
            'data' => [
                'student_name' => $student->name,
                'status' => $attendanceLog->status_text,
                'notes' => $attendanceLog->notes,
                'scan_time' => $attendanceLog->scan_time ? $attendanceLog->scan_time->format('H:i') : null,
                'date' => Carbon::parse($request->date)->format('d/m/Y')
            ]
        ]);
    }

    public function bulkMarkAttendance(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class' => 'required|string',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha,present,absent,sick,permission',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id'
        ]);

        // Map old status to new status for backward compatibility
        $statusMapping = [
            'present' => 'hadir',
            'absent' => 'alpha',
            'sick' => 'sakit',
            'permission' => 'izin'
        ];

        $status = $statusMapping[$request->status] ?? $request->status;

        $successCount = 0;
        $errors = [];

        DB::transaction(function () use ($request, $status, &$successCount, &$errors) {
            foreach ($request->student_ids as $studentId) {
                try {
                    $student = Student::findOrFail($studentId);
                    
                    AttendanceLog::updateOrCreate([
                        'student_id' => $studentId,
                        'attendance_date' => $request->date,
                    ], [
                        'status' => $status,
                        'scan_time' => now(),
                        'location' => 'Bulk Entry by Teacher',
                        'qr_code' => $student->qrAttendance->qr_code ?? null,
                        'notes' => 'Bulk attendance marking'
                    ]);
                    
                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Error for student ID {$studentId}: " . $e->getMessage();
                }
            }
        });

        return response()->json([
            'success' => empty($errors),
            'message' => "Berhasil mencatat absensi untuk {$successCount} siswa",
            'errors' => $errors,
            'success_count' => $successCount
        ]);
    }

    public function getAttendanceByDate($date, $class)
    {
        if (!$class) {
            return collect();
        }

        // Get students in the class
        $studentIds = Student::active()
                            ->whereHas('class', function($q) use ($class) {
                                $q->where('name', $class);
                            })
                            ->pluck('id');

        // Get attendance logs for the date and students
        $attendanceLogs = AttendanceLog::whereIn('student_id', $studentIds)
                                     ->whereDate('attendance_date', $date)
                                     ->with('student')
                                     ->get()
                                     ->keyBy('student_id');

        return $attendanceLogs;
    }

    public function calculateStatistics($attendanceData, $totalStudents)
    {
        if ($totalStudents === 0) {
            return [
                'total' => 0,
                'hadir' => 0,
                'terlambat' => 0,
                'izin' => 0,
                'sakit' => 0,
                'alpha' => 0,
                'present' => 0,
                'absent' => 0,
                'sick' => 0,
                'permission' => 0,
                'not_marked' => 0,
                'present_percentage' => 0,
                'absent_percentage' => 0
            ];
        }

        $hadir = $attendanceData->where('status', 'hadir')->count();
        $terlambat = $attendanceData->where('status', 'terlambat')->count();
        $izin = $attendanceData->where('status', 'izin')->count();
        $sakit = $attendanceData->where('status', 'sakit')->count();
        $alpha = $attendanceData->where('status', 'alpha')->count();
        $marked = $attendanceData->count();
        $notMarked = $totalStudents - $marked;

        $presentCount = $hadir + $terlambat; // Consider late as present
        $absentCount = $izin + $sakit + $alpha;

        return [
            'total' => $totalStudents,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpha' => $alpha,
            // For backward compatibility with view
            'present' => $presentCount,
            'absent' => $alpha,
            'sick' => $sakit,
            'permission' => $izin,
            'not_marked' => $notMarked,
            'present_percentage' => $totalStudents > 0 ? round(($presentCount / $totalStudents) * 100, 1) : 0,
            'absent_percentage' => $totalStudents > 0 ? round(($absentCount / $totalStudents) * 100, 1) : 0
        ];
    }

    public function attendanceHistory(Request $request)
    {
        $studentId = $request->get('student_id');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        if (!$studentId) {
            return response()->json(['error' => 'Student ID is required'], 400);
        }

        $history = AttendanceLog::where('student_id', $studentId)
                               ->whereBetween('attendance_date', [$startDate, $endDate])
                               ->orderBy('attendance_date', 'desc')
                               ->get()
                               ->map(function ($log) {
                                   return [
                                       'date' => $log->attendance_date->format('Y-m-d'),
                                       'status' => $log->status,
                                       'status_text' => $log->status_text,
                                       'scan_time' => $log->scan_time ? $log->scan_time->format('H:i') : null,
                                       'notes' => $log->notes,
                                       'location' => $log->location
                                   ];
                               });

        return response()->json($history);
    }

    public function exportAttendance(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $class = $request->get('class');
        $format = $request->get('format', 'excel');

        if (!$class) {
            return response()->json(['error' => 'Class is required'], 400);
        }

        // Get attendance data
        $attendanceData = AttendanceLog::with(['student'])
                                      ->whereDate('attendance_date', $date)
                                      ->whereHas('student.class', function($query) use ($class) {
                                          $query->where('name', $class);
                                      })
                                      ->orderBy('attendance_date')
                                      ->get();

        // If no attendance data, get students and create empty records
        if ($attendanceData->isEmpty()) {
            $students = Student::active()
                             ->whereHas('class', function($q) use ($class) {
                                 $q->where('name', $class);
                             })
                             ->with('class')
                             ->get();
            $attendanceData = $students->map(function($student) use ($date) {
                return (object) [
                    'student' => $student,
                    'attendance_date' => Carbon::parse($date),
                    'status' => 'belum_dicatat',
                    'scan_time' => null,
                    'location' => '-',
                    'qr_code' => '-',
                    'notes' => 'Belum dicatat'
                ];
            });
        }

        $filters = [
            'date' => $date,
            'class' => $class,
            'format' => $format
        ];

        // Generate filename
        $filename = 'absensi-kelas-' . str_replace(' ', '-', strtolower($class)) . '-' . $date . '.xlsx';

        return Excel::download(new AttendanceExport($attendanceData, $filters), $filename);
    }

    public function monthlyReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $class = $request->get('class');

        if (!$class) {
            $classes = Classes::where('is_active', true)->pluck('name')->sort();
            $class = $classes->first();
        }

        // Parse month and year
        $monthYear = Carbon::createFromFormat('Y-m', $month);
        $startDate = $monthYear->copy()->startOfMonth();
        $endDate = $monthYear->copy()->endOfMonth();

        // Get students in the class
        $students = Student::active()
                          ->whereHas('class', function($q) use ($class) {
                              $q->where('name', $class);
                          })
                          ->with(['class', 'attendanceLogs' => function ($query) use ($startDate, $endDate) {
                              $query->whereBetween('attendance_date', [$startDate, $endDate]);
                          }])
                          ->orderBy('name')
                          ->get();

        $monthlyData = $students->map(function ($student) use ($startDate, $endDate) {
            $logs = $student->attendanceLogs;
            
            $totalDays = $this->getSchoolDaysInPeriod($startDate, $endDate);
            $hadirCount = $logs->whereIn('status', ['hadir', 'terlambat'])->count();
            $terlambatCount = $logs->where('status', 'terlambat')->count();
            $izinCount = $logs->where('status', 'izin')->count();
            $sakitCount = $logs->where('status', 'sakit')->count();
            $alphaCount = $logs->where('status', 'alpha')->count();
            $attendedDays = $logs->count();
            $notMarkedDays = $totalDays - $attendedDays;

            return (object)[
                'student' => $student,
                'total_days' => $totalDays,
                'attended_days' => $attendedDays,
                'hadir_days' => $logs->where('status', 'hadir')->count(),
                'present_days' => $hadirCount, // For backward compatibility
                'terlambat_days' => $terlambatCount,
                'izin_days' => $izinCount,
                'sakit_days' => $sakitCount,
                'alpha_days' => $alphaCount,
                'not_marked_days' => $notMarkedDays,
                'attendance_percentage' => $totalDays > 0 ? round(($hadirCount / $totalDays) * 100, 1) : 0
            ];
        });

        $classes = Classes::where('is_active', true)->pluck('name')->sort();

        return view('teacher.attendance.monthly-report', compact('monthlyData', 'month', 'class', 'classes'));
    }

    public function attendanceStatistics(Request $request)
    {
        $class = $request->get('class');
        $period = $request->get('period', 'month'); // week, month, semester

        if (!$class) {
            return response()->json(['error' => 'Class is required'], 400);
        }

        // Calculate date range based on period
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'semester':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now();
                break;
            default: // month
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now();
        }

        // Get students in class
        $students = Student::active()
                          ->whereHas('class', function($q) use ($class) {
                              $q->where('name', $class);
                          })
                          ->with('class')
                          ->get();
        $totalStudents = $students->count();

        if ($totalStudents === 0) {
            return response()->json(['error' => 'No students found in this class'], 404);
        }

        // Get attendance logs for the period
        $attendanceLogs = AttendanceLog::whereIn('student_id', $students->pluck('id'))
                                     ->whereBetween('attendance_date', [$startDate, $endDate])
                                     ->get();

        // Calculate statistics
        $totalDays = $this->getSchoolDaysInPeriod($startDate, $endDate);
        $totalPossibleAttendance = $totalStudents * $totalDays;
        
        $presentCount = $attendanceLogs->whereIn('status', ['hadir', 'terlambat'])->count();
        $classAverage = $totalPossibleAttendance > 0 ? round(($presentCount / $totalPossibleAttendance) * 100, 1) : 0;

        // Calculate individual student percentages
        $studentPercentages = $students->map(function ($student) use ($attendanceLogs, $totalDays) {
            $studentLogs = $attendanceLogs->where('student_id', $student->id);
            $presentDays = $studentLogs->whereIn('status', ['hadir', 'terlambat'])->count();
            return $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0;
        });

        $bestAttendance = $studentPercentages->max() ?? 0;
        $lowestAttendance = $studentPercentages->min() ?? 0;
        $perfectAttendance = $studentPercentages->filter(function ($percentage) {
            return $percentage >= 100;
        })->count();
        $concerningAttendance = $studentPercentages->filter(function ($percentage) {
            return $percentage < 75;
        })->count();

        // Daily averages (for current week)
        $dailyAverages = [];
        $weekStart = Carbon::now()->startOfWeek();
        for ($i = 0; $i < 5; $i++) { // Monday to Friday
            $day = $weekStart->copy()->addDays($i);
            $dayName = $day->format('l');
            $dayLogs = $attendanceLogs->where('attendance_date', $day->format('Y-m-d'));
            $dayPresent = $dayLogs->whereIn('status', ['hadir', 'terlambat'])->count();
            $dailyAverages[$dayName] = $totalStudents > 0 ? round(($dayPresent / $totalStudents) * 100, 1) : 0;
        }

        $statistics = [
            'class_average' => $classAverage,
            'best_attendance' => $bestAttendance,
            'lowest_attendance' => $lowestAttendance,
            'total_students' => $totalStudents,
            'perfect_attendance' => $perfectAttendance,
            'concerning_attendance' => $concerningAttendance,
            'period' => $period,
            'date_range' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d')
            ],
            'daily_averages' => $dailyAverages,
            'total_school_days' => $totalDays
        ];

        return response()->json($statistics);
    }

    /**
     * Calculate school days in a period (excluding weekends)
     */
    private function getSchoolDaysInPeriod($startDate, $endDate)
    {
        $schoolDays = 0;
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            if ($currentDate->isWeekday()) {
                $schoolDays++;
            }
            $currentDate->addDay();
        }

        return $schoolDays;
    }

    /**
     * Get attendance summary for a student
     */
    public function getStudentAttendanceSummary(Request $request)
    {
        $studentId = $request->get('student_id');
        $period = $request->get('period', 'month');

        if (!$studentId) {
            return response()->json(['error' => 'Student ID is required'], 400);
        }

        $student = Student::findOrFail($studentId);

        // Calculate date range
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'semester':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now();
        }

        $logs = AttendanceLog::where('student_id', $studentId)
                           ->whereBetween('attendance_date', [$startDate, $endDate])
                           ->get();

        $totalDays = $this->getSchoolDaysInPeriod($startDate, $endDate);
        $attendedDays = $logs->count();
        $presentDays = $logs->whereIn('status', ['hadir', 'terlambat'])->count();

        $summary = [
            'student' => [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'class' => $student->class ? $student->class->name : 'No Class'
            ],
            'period' => $period,
            'date_range' => [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d')
            ],
            'total_school_days' => $totalDays,
            'attended_days' => $attendedDays,
            'present_days' => $presentDays,
            'hadir' => $logs->where('status', 'hadir')->count(),
            'terlambat' => $logs->where('status', 'terlambat')->count(),
            'izin' => $logs->where('status', 'izin')->count(),
            'sakit' => $logs->where('status', 'sakit')->count(),
            'alpha' => $logs->where('status', 'alpha')->count(),
            'not_marked' => $totalDays - $attendedDays,
            'attendance_percentage' => $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 0
        ];

        return response()->json($summary);
    }

    /**
     * Update attendance notes
     */
    public function updateAttendanceNotes(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:500'
        ]);

        $student = Student::findOrFail($request->student_id);
        
        // Find or create attendance log
        $attendanceLog = AttendanceLog::updateOrCreate([
            'student_id' => $request->student_id,
            'attendance_date' => $request->date,
        ], [
            'notes' => $request->notes,
            'location' => 'Manual Entry by Teacher',
            'qr_code' => $student->qrAttendance->qr_code ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notes updated successfully',
            'data' => [
                'student_name' => $student->name,
                'notes' => $attendanceLog->notes,
                'date' => Carbon::parse($request->date)->format('d/m/Y')
            ]
        ]);
    }

    /**
     * Update attendance time
     */
    public function updateAttendanceTime(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'time' => 'nullable|string'
        ]);

        $student = Student::findOrFail($request->student_id);
        
        // Parse time if provided
        $scanTime = null;
        if ($request->time) {
            $scanTime = Carbon::parse($request->date . ' ' . $request->time);
        }
        
        // Find or create attendance log
        $attendanceLog = AttendanceLog::updateOrCreate([
            'student_id' => $request->student_id,
            'attendance_date' => $request->date,
        ], [
            'scan_time' => $scanTime,
            'location' => 'Manual Entry by Teacher',
            'qr_code' => $student->qrAttendance->qr_code ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Time updated successfully',
            'data' => [
                'student_name' => $student->name,
                'scan_time' => $attendanceLog->scan_time ? $attendanceLog->scan_time->format('H:i') : null,
                'date' => Carbon::parse($request->date)->format('d/m/Y')
            ]
        ]);
    }
}