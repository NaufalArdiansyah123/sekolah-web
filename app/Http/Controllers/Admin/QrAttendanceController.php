<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\QrAttendance;
use App\Models\AttendanceLog;
use App\Services\QrCodeService;
use App\Services\CsvExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class QrAttendanceController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Display QR attendance management
     */
    public function index(Request $request)
    {
        $query = Student::with(['qrAttendance', 'class', 'attendanceLogs' => function($q) {
            $q->whereDate('attendance_date', today());
        }]);

        // Filter by class
        if ($request->filled('class')) {
            $query->where('class_id', $request->class);
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $students = $query->paginate(20);
        
        // Get available classes
        $classes = \App\Models\Classes::where('is_active', true)
            ->orderBy('level')
            ->orderBy('program')
            ->orderBy('name')
            ->get();
        
        // Statistics
        $stats = [
            'total_students' => Student::count(),
            'students_with_qr' => QrAttendance::count(),
            'today_attendance' => AttendanceLog::whereDate('attendance_date', today())->count(),
            'present_today' => AttendanceLog::whereDate('attendance_date', today())
                                          ->where('status', 'hadir')
                                          ->count(),
        ];

        return view('admin.qr-attendance.index', compact('students', 'classes', 'stats'));
    }

    /**
     * Generate QR code for student
     */
    public function generateQr(Student $student)
    {
        try {
            $qrAttendance = $this->qrCodeService->generateQrCodeForStudent($student);
            
            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dibuat untuk ' . $student->name,
                'qr_image_url' => $qrAttendance->qr_image_url,
                'qr_code' => $qrAttendance->qr_code,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Regenerate QR code for student
     */
    public function regenerateQr(Student $student)
    {
        try {
            $qrAttendance = $this->qrCodeService->regenerateQrCodeForStudent($student);
            
            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dibuat ulang untuk ' . $student->name,
                'qr_image_url' => $qrAttendance->qr_image_url,
                'qr_code' => $qrAttendance->qr_code,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat ulang QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate QR codes for multiple students
     */
    public function generateBulkQr(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        try {
            DB::beginTransaction();
            
            $results = $this->qrCodeService->generateQrCodesForMultipleStudents($request->student_ids);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dibuat untuk ' . count($results) . ' siswa',
                'generated_count' => count($results),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * View attendance logs
     */
    public function attendanceLogs(Request $request)
    {
        
        $query = AttendanceLog::with(['student.class'])
                             ->orderBy('scan_time', 'desc');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        } else {
            $query->whereDate('attendance_date', today());
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by class
        if ($request->filled('class')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('class_id', $request->class);
            });
        }

        $logs = $query->paginate(20);
        
        // Get available classes and statuses
        $classes = \App\Models\Classes::where('is_active', true)
            ->orderBy('level')
            ->orderBy('program')
            ->orderBy('name')
            ->get();
        $statuses = ['hadir', 'terlambat', 'izin', 'sakit', 'alpha'];

        return view('admin.qr-attendance.logs', compact('logs', 'classes', 'statuses'));
    }
    
    /**
     * Export attendance logs to Excel
     */
    public function exportLogs(Request $request)
    {
        try {
            Log::info('Export logs request started', $request->all());
            // Get filters
            $filters = [
                'date' => $request->get('date', today()->format('Y-m-d')),
                'status' => $request->get('status'),
                'class' => $request->get('class')
            ];
            
            // Build query with same filters as attendanceLogs method
            $query = AttendanceLog::with(['student.class'])
                                 ->orderBy('scan_time', 'desc');

            // Apply filters
            if ($filters['date']) {
                $query->whereDate('attendance_date', $filters['date']);
            }

            if ($filters['status']) {
                $query->where('status', $filters['status']);
            }

            if ($filters['class']) {
                $query->whereHas('student', function($q) use ($filters) {
                    $q->where('class_id', $filters['class']);
                });
            }

            $logs = $query->get();
            
            Log::info('Export logs query executed', ['count' => $logs->count()]);
            
            // Generate filename
            $filename = 'log-absensi-qr';
            if ($filters['date']) {
                $filename .= '-' . $filters['date'];
            }
            if ($filters['class']) {
                $filename .= '-kelas-' . str_replace(' ', '-', strtolower($filters['class']));
            }
            if ($filters['status']) {
                $filename .= '-' . $filters['status'];
            }
            $filename .= '.csv';
            
            Log::info('Starting CSV download', ['filename' => $filename]);
            
            // Use CSV service for better compatibility and maintainability
            $headers = CsvExportService::getAttendanceLogsHeaders();
            $data = CsvExportService::formatAttendanceLogsForCsv($logs);
            
            return CsvExportService::generateCsvResponse($data, $headers, $filename);
            
        } catch (\Exception $e) {
            Log::error('Export logs failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Attendance statistics
     */
    public function statistics(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        
        // Monthly statistics
        $monthlyStats = AttendanceLog::byMonth($month, $year)
                                   ->select('status', DB::raw('count(*) as count'))
                                   ->groupBy('status')
                                   ->pluck('count', 'status')
                                   ->toArray();

        // Daily statistics for the month
        $dailyStats = AttendanceLog::byMonth($month, $year)
                                 ->select(
                                     DB::raw('DATE(attendance_date) as date'),
                                     'status',
                                     DB::raw('count(*) as count')
                                 )
                                 ->groupBy('date', 'status')
                                 ->get()
                                 ->groupBy('date');

        // Class statistics
        $classStats = AttendanceLog::byMonth($month, $year)
                                 ->join('students', 'attendance_logs.student_id', '=', 'students.id')
                                 ->join('classes', 'students.class_id', '=', 'classes.id')
                                 ->select('classes.name as class_name', 'attendance_logs.status', DB::raw('count(*) as count'))
                                 ->groupBy('classes.name', 'attendance_logs.status')
                                 ->get()
                                 ->groupBy('class_name');

        return view('admin.qr-attendance.statistics', compact(
            'monthlyStats', 
            'dailyStats', 
            'classStats', 
            'month', 
            'year'
        ));
    }

    /**
     * View QR code for student
     */
    public function viewQr(Student $student)
    {
        try {
            $qrAttendance = $student->qrAttendance;
            
            if (!$qrAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code belum dibuat untuk siswa ini.',
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'qr_image_url' => $qrAttendance->qr_image_url,
                'qr_code' => $qrAttendance->qr_code,
                'student' => [
                    'name' => $student->name,
                    'nis' => $student->nis,
                    'class' => $student->class ? $student->class->name : 'Kelas tidak ditemukan',
                ],
                'download_url' => route('admin.qr-attendance.download', $student),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download QR code
     */
    public function downloadQr(Student $student)
    {
        $qrAttendance = $student->qrAttendance;
        
        if (!$qrAttendance || !$qrAttendance->qr_image_path) {
            return redirect()->back()->with('error', 'QR Code tidak ditemukan untuk siswa ini.');
        }

        $filePath = storage_path('app/public/' . $qrAttendance->qr_image_path);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File QR Code tidak ditemukan.');
        }

        $fileName = 'QR_' . $student->name . '_' . $student->nis . '.png';
        
        return response()->download($filePath, $fileName);
    }
}