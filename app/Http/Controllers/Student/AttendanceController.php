<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\QrAttendance;
use App\Models\Student;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Show attendance scanner page
     */
    public function index()
    {
        $student = auth()->user()->student ?? Student::where('user_id', auth()->id())->first();
        
        if (!$student) {
            return redirect()->route('student.dashboard')
                           ->with('error', 'Data siswa tidak ditemukan.');
        }

        // Get today's attendance
        $todayAttendance = $student->attendanceLogs()
                                 ->whereDate('attendance_date', today())
                                 ->first();

        // Get recent attendance (last 7 days)
        $recentAttendance = $student->attendanceLogs()
                                  ->where('attendance_date', '>=', now()->subDays(7))
                                  ->orderBy('attendance_date', 'desc')
                                  ->get();

        // Get monthly statistics
        $monthlyStats = $student->attendanceLogs()
                              ->whereMonth('attendance_date', now()->month)
                              ->whereYear('attendance_date', now()->year)
                              ->selectRaw('status, count(*) as count')
                              ->groupBy('status')
                              ->pluck('count', 'status')
                              ->toArray();

        // Return view with cache busting headers
        return response()
            ->view('student.attendance.index', compact(
                'student', 
                'todayAttendance', 
                'recentAttendance', 
                'monthlyStats'
            ))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Process QR code scan
     */
    public function scanQr(Request $request)
    {
        // Log untuk debugging
        \Log::info('QR Scan Request:', [
            'qr_code' => $request->qr_code,
            'location' => $request->location,
            'user_id' => auth()->id(),
            'timestamp' => now()
        ]);

        $request->validate([
            'qr_code' => 'required|string',
            'location' => 'nullable|string|max:255',
        ]);

        try {
            // Validate QR code
            $qrAttendance = $this->qrCodeService->validateQrCode($request->qr_code);
            
            \Log::info('QR Validation Result:', [
                'qr_attendance_found' => $qrAttendance ? true : false,
                'qr_attendance_id' => $qrAttendance ? $qrAttendance->id : null,
                'student_id' => $qrAttendance ? $qrAttendance->student_id : null
            ]);
            
            if (!$qrAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau tidak ditemukan.',
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
                    'message' => 'Data siswa tidak ditemukan.',
                ], 400);
            }
            
            $scanTime = now();
            $attendanceDate = $scanTime->toDateString();

            // Check if already scanned today
            $existingAttendance = AttendanceLog::where('student_id', $student->id)
                                             ->whereDate('attendance_date', $attendanceDate)
                                             ->first();

            \Log::info('Existing Attendance Check:', [
                'student_id' => $student->id,
                'attendance_date' => $attendanceDate,
                'existing_found' => $existingAttendance ? true : false
            ]);

            if ($existingAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absensi hari ini pada ' . 
                               $existingAttendance->scan_time->format('H:i:s'),
                    'existing_attendance' => [
                        'status' => $existingAttendance->status_text,
                        'scan_time' => $existingAttendance->scan_time->format('H:i:s'),
                        'badge_color' => $existingAttendance->status_badge,
                    ]
                ], 400);
            }

            // Determine status based on scan time
            $status = AttendanceLog::determineStatus($scanTime);
            
            \Log::info('Attendance Status Determined:', [
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
                'location' => $request->location,
            ]);
            
            \Log::info('Attendance Log Created:', [
                'attendance_log_id' => $attendanceLog->id,
                'student_id' => $student->id,
                'status' => $status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dicatat!',
                'attendance' => [
                    'student_name' => $student->name,
                    'nis' => $student->nis,
                    'class' => $student->class,
                    'status' => $attendanceLog->status_text,
                    'scan_time' => $attendanceLog->scan_time->format('H:i:s'),
                    'attendance_date' => $attendanceLog->attendance_date->format('d/m/Y'),
                    'badge_color' => $attendanceLog->status_badge,
                ],
                'debug' => [
                    'attendance_log_id' => $attendanceLog->id,
                    'raw_status' => $status,
                    'scan_time_raw' => $scanTime->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('QR Scan Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'qr_code' => $request->qr_code
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'debug' => [
                    'error_type' => get_class($e),
                    'error_line' => $e->getLine(),
                    'error_file' => $e->getFile()
                ]
            ], 500);
        }
    }

    /**
     * Get student's QR code for download
     */
    public function getMyQrCode()
    {
        $student = auth()->user()->student ?? Student::where('user_id', auth()->id())->first();
        
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        $qrAttendance = $student->qrAttendance;
        
        if (!$qrAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code belum dibuat. Silakan hubungi admin.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'qr_code' => $qrAttendance->qr_code,
            'qr_image_url' => $qrAttendance->qr_image_url,
            'student' => [
                'name' => $student->name,
                'nis' => $student->nis,
                'class' => $student->class,
            ]
        ]);
    }

    /**
     * Download student's QR code
     */
    public function downloadMyQrCode()
    {
        $student = auth()->user()->student ?? Student::where('user_id', auth()->id())->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $qrAttendance = $student->qrAttendance;
        
        if (!$qrAttendance || !$qrAttendance->qr_image_path) {
            return redirect()->back()->with('error', 'QR Code belum dibuat. Silakan hubungi admin.');
        }

        $filePath = storage_path('app/public/' . $qrAttendance->qr_image_path);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File QR Code tidak ditemukan.');
        }

        $fileName = 'QR_Absensi_' . $student->name . '_' . $student->nis . '.png';
        
        return response()->download($filePath, $fileName);
    }

    /**
     * Get attendance history
     */
    public function history(Request $request)
    {
        $student = auth()->user()->student ?? Student::where('user_id', auth()->id())->first();
        
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.',
            ], 404);
        }

        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $attendanceHistory = $student->attendanceLogs()
                                   ->whereMonth('attendance_date', $month)
                                   ->whereYear('attendance_date', $year)
                                   ->orderBy('attendance_date', 'desc')
                                   ->get()
                                   ->map(function($log) {
                                       return [
                                           'date' => $log->attendance_date->format('d/m/Y'),
                                           'day' => $log->attendance_date->format('l'),
                                           'status' => $log->status_text,
                                           'scan_time' => $log->scan_time->format('H:i:s'),
                                           'badge_color' => $log->status_badge,
                                           'location' => $log->location,
                                       ];
                                   });

        return response()->json([
            'success' => true,
            'attendance_history' => $attendanceHistory,
            'month' => $month,
            'year' => $year,
        ]);
    }
}