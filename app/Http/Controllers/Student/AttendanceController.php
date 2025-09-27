<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\QrAttendance;
use App\Models\Student;
use App\Models\SecurityViolation;
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
     * Show attendance scanner page
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

            \Log::info('Attendance page loaded successfully', [
                'student_id' => $student->id,
                'today_attendance' => $todayAttendance ? true : false,
                'recent_count' => $recentAttendance->count(),
                'monthly_stats' => $monthlyStats
            ]);

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
            // Get student data
            $currentStudent = $this->getStudentData();
            
            if (!$currentStudent) {
                \Log::error('Student not found during QR scan', [
                    'user_id' => auth()->id(),
                    'qr_code' => $request->qr_code
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Data siswa tidak ditemukan. Silakan login ulang atau hubungi administrator.',
                    'debug' => [
                        'error_type' => 'student_not_found',
                        'user_id' => auth()->id()
                    ]
                ], 400);
            }

            // Validate QR code
            $qrAttendance = $this->qrCodeService->validateQrCode($request->qr_code);
            
            \Log::info('QR Validation Result:', [
                'qr_attendance_found' => $qrAttendance ? true : false,
                'qr_attendance_id' => $qrAttendance ? $qrAttendance->id : null,
                'student_id' => $qrAttendance ? $qrAttendance->student_id : null,
                'current_student_id' => $currentStudent->id
            ]);
            
            if (!$qrAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau tidak ditemukan. Pastikan Anda menggunakan QR Code yang benar.',
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

            // Check if the QR code belongs to the current student
            if ($student->id !== $currentStudent->id) {
                $violationTime = now();
                
                // Log security violation
                \Log::warning('QR Code mismatch - Attempted to use another student QR code', [
                    'qr_student_id' => $student->id,
                    'qr_student_name' => $student->name,
                    'qr_student_nis' => $student->nis,
                    'current_student_id' => $currentStudent->id,
                    'current_student_name' => $currentStudent->name,
                    'current_student_nis' => $currentStudent->nis,
                    'qr_code' => $request->qr_code,
                    'timestamp' => $violationTime,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
                
                // Create security violation record
                $violation = SecurityViolation::create([
                    'violator_student_id' => $currentStudent->id,
                    'qr_owner_student_id' => $student->id,
                    'qr_code' => $request->qr_code,
                    'violation_type' => 'wrong_qr_owner',
                    'violation_time' => $violationTime,
                    'violation_date' => $violationTime->toDateString(),
                    'location' => $request->location,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'violation_details' => [
                        'qr_owner' => [
                            'id' => $student->id,
                            'name' => $student->name,
                            'nis' => $student->nis,
                            'class' => $student->class ? $student->class->name : 'Kelas tidak ditemukan'
                        ],
                        'violator' => [
                            'id' => $currentStudent->id,
                            'name' => $currentStudent->name,
                            'nis' => $currentStudent->nis,
                            'class' => $currentStudent->class ? $currentStudent->class->name : 'Kelas tidak ditemukan'
                        ],
                        'attempt_details' => [
                            'scan_time' => $violationTime->format('H:i:s'),
                            'scan_date' => $violationTime->format('Y-m-d'),
                            'location' => $request->location,
                            'ip_address' => $request->ip(),
                            'user_agent' => $request->userAgent()
                        ]
                    ],
                    'severity' => 'medium',
                    'status' => 'pending'
                ]);
                
                \Log::info('Security violation recorded', [
                    'violation_id' => $violation->id,
                    'violator_student_id' => $currentStudent->id,
                    'qr_owner_student_id' => $student->id
                ]);
                
                // Create a warning attendance log entry for admin visibility
                $warningLog = AttendanceLog::create([
                    'student_id' => $currentStudent->id,
                    'qr_code' => $request->qr_code,
                    'status' => 'alpha', // Mark as alpha due to violation
                    'scan_time' => $violationTime,
                    'attendance_date' => $violationTime->toDateString(),
                    'location' => $request->location,
                    'notes' => "PERINGATAN: Siswa mencoba menggunakan QR Code milik {$student->name} (NIS: {$student->nis}). Violation ID: {$violation->id}"
                ]);
                
                \Log::info('Warning attendance log created', [
                    'attendance_log_id' => $warningLog->id,
                    'violation_id' => $violation->id
                ]);
                
                return response()->json([
                    'success' => false,
                    'error_type' => 'wrong_qr_owner_warning',
                    'message' => '⚠️ PERINGATAN: QR Code Salah!',
                    'detailed_message' => 'QR Code yang Anda scan adalah milik siswa lain. Pelanggaran ini telah dicatat dan akan direview oleh admin.',
                    'warning_data' => [
                        'qr_owner' => [
                            'name' => $student->name,
                            'nis' => $student->nis,
                            'class' => $student->class ? $student->class->name : 'Kelas tidak ditemukan'
                        ],
                        'current_user' => [
                            'name' => $currentStudent->name,
                            'nis' => $currentStudent->nis,
                            'class' => $currentStudent->class ? $currentStudent->class->name : 'Kelas tidak ditemukan'
                        ],
                        'violation_id' => $violation->id,
                        'violation_time' => $violationTime->format('H:i:s')
                    ],
                    'instructions' => [
                        'Gunakan QR Code Anda sendiri untuk absensi',
                        'Jika tidak memiliki QR Code, hubungi guru atau admin',
                        'Download QR Code Anda melalui tombol "QR Code Saya"',
                        'Pelanggaran berulang dapat mengakibatkan sanksi'
                    ],
                    'admin_notice' => 'Pelanggaran ini telah dicatat dan akan muncul di sistem admin untuk ditindaklanjuti.'
                ], 200); // Changed to 200 to show as warning, not error
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
                    'class' => $student->class ? $student->class->name : 'Kelas tidak ditemukan',
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
                'qr_code' => $request->qr_code,
                'user_id' => auth()->id()
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
            'timestamp' => now()
        ]);

        $request->validate([
            'qr_file' => 'required|file|image|mimes:png,jpg,jpeg|max:5120', // 5MB max
        ], [
            'qr_file.required' => 'File QR Code harus dipilih.',
            'qr_file.file' => 'File yang dipilih tidak valid.',
            'qr_file.image' => 'File harus berupa gambar.',
            'qr_file.mimes' => 'File harus berformat PNG, JPG, atau JPEG.',
            'qr_file.max' => 'Ukuran file maksimal 5MB.',
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