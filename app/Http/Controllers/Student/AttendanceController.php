<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\QrAttendance;
use App\Models\Student;
use App\Models\SecurityViolation;
use App\Models\PklRegistration;
use App\Services\QrCodeService;
use App\Services\PklQrCodeService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $qrCodeService;
    protected $pklQrCodeService;

    public function __construct(QrCodeService $qrCodeService, PklQrCodeService $pklQrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
        $this->pklQrCodeService = $pklQrCodeService;
    }

    /**
     * Get student data with multiple fallback methods
     */
    private function getStudentData()
    {
        $user = auth()->user();

        \Log::info('Getting student data for user:', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_roles' => $user->roles->pluck('name')->toArray()
        ]);

        // Method 1: Try direct relation
        $student = $user->student;
        if ($student) {
            // Load class relationship
            $student->load('class');
            \Log::info('Student found via direct relation:', [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'student_nis' => $student->nis,
                'student_class_id' => $student->class_id,
                'student_class_name' => $student->class ? $student->class->name : null
            ]);
            return $student;
        }

        // Method 2: Try query by user_id
        $student = Student::with('class')->where('user_id', $user->id)->first();
        if ($student) {
            \Log::info('Student found via user_id query:', [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'student_nis' => $student->nis,
                'student_class_id' => $student->class_id,
                'student_class_name' => $student->class ? $student->class->name : null
            ]);
            return $student;
        }

        // Method 3: Try by email if user has email
        if ($user->email) {
            $student = Student::with('class')->where('email', $user->email)->first();
            if ($student) {
                \Log::info('Student found via email match:', [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'student_nis' => $student->nis,
                    'student_class_id' => $student->class_id,
                    'student_class_name' => $student->class ? $student->class->name : null
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
            $student = Student::with('class')->where('nis', $user->nis)->first();
            if ($student) {
                \Log::info('Student found via NIS match:', [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'student_nis' => $student->nis,
                    'student_class_id' => $student->class_id,
                    'student_class_name' => $student->class ? $student->class->name : null
                ]);

                // Update user_id if missing
                if (!$student->user_id) {
                    $student->update(['user_id' => $user->id]);
                    \Log::info('Updated student user_id:', ['student_id' => $student->id]);
                }

                return $student;
            }
        }

        \Log::error('No student data found for user:', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_nis' => $user->nis ?? 'not_set',
            'methods_tried' => ['direct_relation', 'user_id_query', 'email_match', 'nis_match']
        ]);

        return null;
    }

    /**
     * Show attendance QR code display page (no scanner)
     */
    public function index()
    {
        try {
            $student = $this->getStudentData();

            if (!$student) {
                \Log::error('Student data not found for attendance page', [
                    'user_id' => auth()->id(),
                    'user_email' => auth()->user()->email
                ]);

                return view('student.attendance.error', [
                    'error_type' => 'student_not_found',
                    'error_message' => 'Data siswa tidak ditemukan. Silakan hubungi administrator.',
                    'debug_info' => [
                        'user_id' => auth()->id(),
                        'user_email' => auth()->user()->email,
                        'user_roles' => auth()->user()->roles->pluck('name')->toArray()
                    ]
                ]);
            }

            // Get today's attendance
            $todayAttendance = $student->attendanceLogs()
                ->whereDate('attendance_date', today())
                ->first();

            // Get recent attendance (last 10 days)
            $recentAttendance = $student->attendanceLogs()
                ->where('attendance_date', '>=', now()->subDays(10))
                ->orderBy('attendance_date', 'desc')
                ->take(10)
                ->get();

            // Get monthly statistics
            $monthlyStats = $student->attendanceLogs()
                ->whereMonth('attendance_date', now()->month)
                ->whereYear('attendance_date', now()->year)
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            \Log::info('Attendance page loaded successfully', [
                'student_id' => $student->id,
                'today_attendance' => $todayAttendance ? true : false,
                'recent_count' => $recentAttendance->count(),
                'monthly_stats' => $monthlyStats
            ]);

            // Get student's QR code
            $qrAttendance = $student->qrAttendance;

            // Get student's approved PKL registration with QR code
            $pklRegistration = $student->user->pklRegistrations()
                ->where('status', 'approved')
                ->whereNotNull('qr_code')
                ->with('tempatPkl')
                ->first();

            // Return view with cache busting headers
            return response()
                ->view('student.attendance.qr-display', compact(
                    'student',
                    'todayAttendance',
                    'recentAttendance',
                    'monthlyStats',
                    'qrAttendance',
                    'pklRegistration'
                ))
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');

        } catch (\Exception $e) {
            \Log::error('Error loading attendance page:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            return view('student.attendance.error', [
                'error_type' => 'system_error',
                'error_message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.',
                'debug_info' => [
                    'error' => $e->getMessage(),
                    'user_id' => auth()->id()
                ]
            ]);
        }
    }

    /**
     * QR scanning is now handled by teachers only
     * This method is deprecated and will return an error
     */
    public function scanQr(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'QR scanning sekarang hanya dapat dilakukan oleh guru. Silakan tunjukkan QR Code Anda kepada guru untuk diabsen.',
            'redirect_message' => 'Sistem absensi telah diperbarui. Guru yang akan melakukan scan QR Code siswa.'
        ], 403);
    }

    /**
     * Get student's QR code for download
     */
    public function getMyQrCode()
    {
        try {
            $student = $this->getStudentData();

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
                    'class' => $student->class ? $student->class->name : 'Kelas tidak ditemukan',
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error getting student QR code:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil QR Code.',
            ], 500);
        }
    }

    /**
     * Download student's QR code
     */
    public function downloadMyQrCode()
    {
        try {
            $student = $this->getStudentData();

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

        } catch (\Exception $e) {
            \Log::error('Error downloading QR code:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendownload QR Code.');
        }
    }

    /**
     * Process QR code from uploaded file
     */
    public function processQrFile(Request $request)
    {
        \Log::info('QR File Upload Request:', [
            'user_id' => auth()->id(),
            'has_file' => $request->hasFile('qr_file'),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'timestamp' => now()
        ]);

        $request->validate([
            'qr_file' => 'required|file|image|mimes:png,jpg,jpeg|max:5120', // 5MB max
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ], [
            'qr_file.required' => 'File QR Code harus dipilih.',
            'qr_file.file' => 'File yang dipilih tidak valid.',
            'qr_file.image' => 'File harus berupa gambar.',
            'qr_file.mimes' => 'File harus berformat PNG, JPG, atau JPEG.',
            'qr_file.max' => 'Ukuran file maksimal 5MB.',
            'latitude.required' => 'Lokasi (latitude) diperlukan.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'latitude.between' => 'Latitude tidak valid.',
            'longitude.required' => 'Lokasi (longitude) diperlukan.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'longitude.between' => 'Longitude tidak valid.',
        ]);

        try {
            $file = $request->file('qr_file');

            // Check if file is valid
            if (!$file || !$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak valid atau rusak.',
                ], 400);
            }

            \Log::info('QR File processing attempted:', [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);

            // Store file temporarily
            $tempPath = $file->store('temp/qr_uploads', 'local');
            $fullPath = storage_path('app/' . $tempPath);

            \Log::info('File stored temporarily:', [
                'temp_path' => $tempPath,
                'full_path' => $fullPath
            ]);

            // Try to extract QR code using basic image processing
            // This is a fallback method - the main processing should be done client-side with jsQR

            // For server-side processing, we would need a QR code library like:
            // - zxing-php
            // - endroid/qr-code (for generation, not reading)
            // - khanamiryan/qrcode-detector-decoder

            // Since we don't have these libraries installed, we'll provide a helpful response
            // that guides the user to use the client-side processing or manual input

            // Clean up temporary file
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Pemrosesan QR Code di server memerlukan library tambahan. Silakan pastikan JavaScript aktif di browser Anda untuk pemrosesan otomatis, atau gunakan fitur Input Manual.',
                'suggestions' => [
                    'Pastikan JavaScript aktif di browser Anda',
                    'Gunakan browser modern (Chrome, Firefox, Safari, Edge)',
                    'Atau gunakan fitur "Input Manual" untuk memasukkan kode QR secara manual',
                    'Pastikan gambar QR Code jelas dan tidak buram'
                ],
                'fallback' => true
            ], 422);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi file gagal.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('QR File processing error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses file. Silakan coba lagi atau gunakan input manual.',
                'debug' => [
                    'error_type' => get_class($e),
                    'error_message' => $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Get attendance history
     */
    public function history(Request $request)
    {
        try {
            $student = $this->getStudentData();

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
                ->map(function ($log) {
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

        } catch (\Exception $e) {
            \Log::error('Error getting attendance history:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil riwayat absensi.',
            ], 500);
        }
    }


}
