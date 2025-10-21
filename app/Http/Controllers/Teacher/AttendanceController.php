<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\AttendanceLog;
use App\Models\QrAttendance;
use App\Models\Classes;
use App\Models\SecurityViolation;
use App\Models\AttendanceSubmission;


use App\Models\User;
use App\Exports\AttendanceExport;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
        $this->qrCodeService = $qrCodeService;
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

    /**
     * Show QR Scanner page for teachers
     */
    public function qrScanner()
    {
        try {
            // Get available classes from Classes model
            $classes = Classes::where('is_active', true)
                             ->pluck('name')
                             ->sort()
                             ->values();

            // Get today's attendance statistics
            $todayStats = $this->getTodayAttendanceStats();
            
            // Get recent scans for today
            $recentScans = $this->getRecentScansToday();

            return view('teacher.attendance.qr-scanner', compact('classes', 'todayStats', 'recentScans'));

        } catch (\Exception $e) {
            \Log::error('Error loading QR scanner page:', [
                'error' => $e->getMessage(),
                'teacher_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('teacher.attendance.error', [
                'error_type' => 'system_error',
                'error_message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.',
                'debug_info' => [
                    'error' => $e->getMessage(),
                    'teacher_id' => auth()->id(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ]);
        }
    }

    /**
     * Process QR code scan by teacher
     */
    public function scanQr(Request $request)
    {
        \Log::info('Teacher QR Scan Request:', [
            'qr_code' => $request->qr_code,
            'location' => $request->location,
            'teacher_id' => auth()->id(),
            'timestamp' => now()
        ]);

        $request->validate([
            'qr_code' => 'required|string',
            'location' => 'nullable|string|max:255',
        ]);

        try {
            // Validate QR code
            $qrAttendance = $this->qrCodeService->validateQrCode($request->qr_code);
            
            \Log::info('Teacher QR Validation Result:', [
                'qr_attendance_found' => $qrAttendance ? true : false,
                'qr_attendance_id' => $qrAttendance ? $qrAttendance->id : null,
                'student_id' => $qrAttendance ? $qrAttendance->student_id : null
            ]);
            
            if (!$qrAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau tidak ditemukan. Pastikan QR Code siswa yang benar.',
                    'debug' => [
                        'qr_code' => $request->qr_code,
                        'validation_result' => 'not_found'
                    ]
                ], 400);
            }

            $student = $qrAttendance->student;
            
            if (!$student) {
                \Log::error('Student not found for QR attendance', [
                    'qr_attendance_id' => $qrAttendance->id,
                    'student_id' => $qrAttendance->student_id
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Data siswa untuk QR Code ini tidak ditemukan.',
                ], 400);
            }
            
            $scanTime = now();
            $attendanceDate = $scanTime->toDateString();

            // Check if already scanned today
            $existingAttendance = AttendanceLog::where('student_id', $student->id)
                                             ->whereDate('attendance_date', $attendanceDate)
                                             ->first();

            \Log::info('Teacher Scan - Existing Attendance Check:', [
                'student_id' => $student->id,
                'attendance_date' => $attendanceDate,
                'existing_found' => $existingAttendance ? true : false
            ]);

            if ($existingAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa ' . $student->name . ' sudah melakukan absensi hari ini pada ' . 
                               $existingAttendance->scan_time->format('H:i:s'),
                    'existing_attendance' => [
                        'student_name' => $student->name,
                        'nis' => $student->nis,
                        'class' => $student->class ? $student->class->name : 'Kelas tidak ditemukan',
                        'status' => $existingAttendance->status_text,
                        'scan_time' => $existingAttendance->scan_time->format('H:i:s'),
                        'badge_color' => $existingAttendance->status_badge,
                    ]
                ], 400);
            }

            // Determine status based on scan time
            $status = AttendanceLog::determineStatus($scanTime);
            
            \Log::info('Teacher Scan - Attendance Status Determined:', [
                'scan_time' => $scanTime,
                'status' => $status
            ]);

            // Create attendance log
            $attendanceLog = AttendanceLog::create([
                'student_id' => $student->id,
                'qr_code' => $request->qr_code,
                'status' => $status,
                'scan_time' => $scanTime,
                'attendance_date' => $attendanceDate,
                'location' => $request->location ?? 'Scanned by Teacher',
                'notes' => 'Scanned by teacher: ' . auth()->user()->name
            ]);
            
            \Log::info('Teacher Scan - Attendance Log Created:', [
                'attendance_log_id' => $attendanceLog->id,
                'student_id' => $student->id,
                'status' => $status,
                'teacher_id' => auth()->id()
            ]);
            
            // Convert status badge to CSS classes
            $badgeColor = match($status) {
                'hadir' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                'alpha' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
            };

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dicatat oleh guru!',
                'attendance' => [
                    'student_name' => $student->name,
                    'nis' => $student->nis,
                    'class' => $student->class ? $student->class->name : 'Kelas tidak ditemukan',
                    'status' => $attendanceLog->status_text,
                    'scan_time' => $attendanceLog->scan_time->format('H:i:s'),
                    'attendance_date' => $attendanceLog->attendance_date->format('d/m/Y'),
                    'badge_color' => $badgeColor,
                    'scanned_by' => 'Guru: ' . auth()->user()->name
                ],
                'debug' => [
                    'attendance_log_id' => $attendanceLog->id,
                    'raw_status' => $status,
                    'scan_time_raw' => $scanTime->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Teacher QR Scan Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'qr_code' => $request->qr_code,
                'teacher_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'debug' => [
                    'error_type' => get_class($e),
                    'error_line' => $e->getLine(),
                    'error_file' => $e->getFile()
                ]
            ], 500);
        }
    }

    /**
     * Get today's attendance statistics
     */
    private function getTodayAttendanceStats()
    {
        try {
            $today = Carbon::today();
            
            $stats = AttendanceLog::whereDate('attendance_date', $today)
                                 ->selectRaw('status, count(*) as count')
                                 ->groupBy('status')
                                 ->pluck('count', 'status')
                                 ->toArray();

            $totalScanned = array_sum($stats);
            $presentCount = ($stats['hadir'] ?? 0) + ($stats['terlambat'] ?? 0);

            return [
                'total_scanned' => $totalScanned,
                'hadir' => $stats['hadir'] ?? 0,
                'terlambat' => $stats['terlambat'] ?? 0,
                'izin' => $stats['izin'] ?? 0,
                'sakit' => $stats['sakit'] ?? 0,
                'alpha' => $stats['alpha'] ?? 0,
                'present_count' => $presentCount,
                'present_percentage' => $totalScanned > 0 ? round(($presentCount / $totalScanned) * 100, 1) : 0
            ];
        } catch (\Exception $e) {
            \Log::warning('Failed to get today attendance stats: ' . $e->getMessage());
            return [
                'total_scanned' => 0,
                'hadir' => 0,
                'terlambat' => 0,
                'izin' => 0,
                'sakit' => 0,
                'alpha' => 0,
                'present_count' => 0,
                'present_percentage' => 0
            ];
        }
    }
    
    /**
     * Get recent scans for today
     */
    private function getRecentScansToday()
    {
        try {
            $today = Carbon::today();
            
            $recentScans = AttendanceLog::with(['student.user', 'student.class'])
                                      ->whereDate('attendance_date', $today)
                                      ->orderBy('created_at', 'desc')
                                      ->limit(10)
                                      ->get()
                                      ->map(function ($log) {
                                          // Convert status badge to CSS classes
                                          $badgeColor = match($log->status) {
                                              'hadir' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                              'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                              'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                              'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                              'alpha' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                              default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
                                          };
                                          
                                          return [
                                              'student_name' => $log->student->user->name ?? 'Unknown',
                                              'nis' => $log->student->nis ?? 'N/A',
                                              'class' => $log->student->class->name ?? 'Kelas tidak ditemukan',
                                              'status' => $log->status_text,
                                              'scan_time' => $log->scan_time ? $log->scan_time->format('H:i') : 'N/A',
                                              'attendance_date' => $log->attendance_date->format('d/m/Y'),
                                              'badge_color' => $badgeColor,
                                              'scanned_by' => 'Guru'
                                          ];
                                      });
            
            return $recentScans;
        } catch (\Exception $e) {
            \Log::warning('Failed to get recent scans: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Submit attendance to guru piket for confirmation
     */
    public function submitToGuruPiket(Request $request)
    {
        \Log::info('Submit to Guru Piket Request:', [
            'request_data' => $request->all(),
            'teacher_id' => auth()->id(),
            'timestamp' => now()
        ]);

        $request->validate([
            'date' => 'required|date',
            'class_name' => 'required|string',
            'subject' => 'required|string|max:100',
            'session_time' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            // Validate AttendanceSubmission constants
            if (!defined('App\Models\AttendanceSubmission::STATUS_PENDING')) {
                \Log::error('AttendanceSubmission STATUS_PENDING constant not found');
                return response()->json([
                    'success' => false,
                    'message' => 'Konfigurasi sistem tidak lengkap. Hubungi administrator.'
                ], 500);
            }
            
            DB::beginTransaction();

            // Get class information
            \Log::info('Looking for class:', ['class_name' => $request->class_name]);
            
            $class = Classes::where('name', $request->class_name)->first();
            
            \Log::info('Class lookup result:', [
                'class_found' => $class ? true : false,
                'class_id' => $class ? $class->id : null,
                'class_name' => $class ? $class->name : null
            ]);
            
            if (!$class) {
                \Log::warning('Class not found:', [
                    'requested_class' => $request->class_name,
                    'available_classes' => Classes::pluck('name')->toArray()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Kelas "' . $request->class_name . '" tidak ditemukan. Kelas yang tersedia: ' . Classes::pluck('name')->implode(', ')
                ], 400);
            }
            
            // Get students in the class
            \Log::info('Getting students for class:', ['class_id' => $class->id]);
            
            $students = Student::active()
                              ->where('class_id', $class->id)
                              ->get();
            
            $totalStudents = $students->count();
            
            \Log::info('Students found:', [
                'total_students' => $totalStudents,
                'student_ids' => $students->pluck('id')->toArray()
            ]);
            
            // Get attendance data for the date and class
            $attendanceData = AttendanceLog::whereIn('student_id', $students->pluck('id'))
                                         ->whereDate('attendance_date', $request->date)
                                         ->with('student')
                                         ->get();
            
            // Calculate statistics
            $presentCount = $attendanceData->whereIn('status', ['hadir', 'terlambat'])->count();
            $lateCount = $attendanceData->where('status', 'terlambat')->count();
            $absentCount = $totalStudents - $attendanceData->count();
            
            // Prepare detailed attendance data
            $detailedData = $students->map(function ($student) use ($attendanceData) {
                $attendance = $attendanceData->where('student_id', $student->id)->first();
                
                return [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'nis' => $student->nis,
                    'status' => $attendance ? $attendance->status : 'alpha',
                    'scan_time' => $attendance && $attendance->scan_time ? $attendance->scan_time->format('H:i') : null,
                    'notes' => $attendance ? $attendance->notes : null
                ];
            });
            
            // Find available guru piket (for now, get first guru piket)
            \Log::info('Looking for guru piket users...');
            
            $guruPiket = User::whereHas('roles', function($query) {
                $query->where('name', 'guru_piket');
            })->first();
            
            \Log::info('Guru piket lookup result:', [
                'guru_piket_found' => $guruPiket ? true : false,
                'guru_piket_id' => $guruPiket ? $guruPiket->id : null,
                'guru_piket_name' => $guruPiket ? $guruPiket->name : null
            ]);
            
            if (!$guruPiket) {
                \Log::warning('No guru piket found');
                
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada guru piket yang tersedia untuk menerima submission'
                ], 400);
            }
            
            // Check if submission already exists for this date, class, and teacher
            $existingSubmission = AttendanceSubmission::where('teacher_id', auth()->id())
                                                    ->where('class_id', $class->id)
                                                    ->where('submission_date', $request->date)
                                                    ->where('subject', $request->subject)
                                                    ->first();
            
            if ($existingSubmission) {
                return response()->json([
                    'success' => false,
                    'message' => 'Absensi untuk kelas ini pada tanggal tersebut sudah pernah dikirim'
                ], 400);
            }
            
            // Create attendance submission
            $submissionData = [
                'teacher_id' => auth()->id(),
                'guru_piket_id' => $guruPiket->id,
                'submission_date' => $request->date,
                'class_id' => $class->id,
                'subject' => $request->subject,
                'session_time' => $request->session_time,
                'total_students' => $totalStudents,
                'present_count' => $presentCount,
                'late_count' => $lateCount,
                'absent_count' => $absentCount,
                'attendance_data' => $detailedData->toArray(),
                'notes' => $request->notes,
                'status' => AttendanceSubmission::STATUS_PENDING,
                'submitted_at' => now()
            ];
            
            \Log::info('Creating attendance submission:', $submissionData);
            
            $submission = AttendanceSubmission::create($submissionData);
            
            \Log::info('Attendance submission created:', [
                'submission_id' => $submission->id,
                'submission_status' => $submission->status
            ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dikirim ke guru piket untuk konfirmasi',
                'submission' => [
                    'id' => $submission->id,
                    'class_name' => $class->name,
                    'subject' => $submission->subject,
                    'date' => Carbon::parse($submission->submission_date)->format('d/m/Y'),
                    'total_students' => $submission->total_students,
                    'present_count' => $submission->present_count,
                    'attendance_percentage' => $submission->attendance_percentage,
                    'guru_piket' => $guruPiket->name,
                    'status' => $submission->status_text
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            \Log::error('Error submitting attendance to guru piket:', [
                'error' => $e->getMessage(),
                'teacher_id' => auth()->id(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim absensi: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get teacher's attendance submissions
     */
    public function getSubmissions(Request $request)
    {
        $status = $request->get('status');
        $date = $request->get('date');
        
        $query = AttendanceSubmission::where('teacher_id', auth()->id())
                                   ->with(['class', 'guruPiket', 'confirmer'])
                                   ->orderBy('created_at', 'desc');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($date) {
            $query->whereDate('submission_date', $date);
        }
        
        $submissions = $query->paginate(10);
        
        return response()->json([
            'success' => true,
            'submissions' => $submissions->items(),
            'pagination' => [
                'current_page' => $submissions->currentPage(),
                'last_page' => $submissions->lastPage(),
                'per_page' => $submissions->perPage(),
                'total' => $submissions->total()
            ]
        ]);
    }
    
    /**
     * Get submission detail
     */
    public function getSubmissionDetail($id)
    {
        $submission = AttendanceSubmission::where('teacher_id', auth()->id())
                                        ->with(['class', 'guruPiket', 'confirmer'])
                                        ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'submission' => $submission
        ]);
    }
}