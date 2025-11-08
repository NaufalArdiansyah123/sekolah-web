<?php

namespace App\Http\Controllers\GuruPiket;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\QrTeacherAttendance;
use App\Models\TeacherAttendanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QrScannerController extends Controller
{
    /**
     * Display QR scanner page
     */
    public function index()
    {
        // Get today's attendance statistics
        $stats = [
            'total_teachers' => Teacher::active()->count(),
            'present_today' => TeacherAttendanceLog::today()->where('status', 'hadir')->count(),
            'late_today' => TeacherAttendanceLog::today()->where('status', 'terlambat')->count(),
            'absent_today' => TeacherAttendanceLog::today()->whereIn('status', ['izin', 'sakit', 'alpha'])->count(),
            'checked_out_today' => TeacherAttendanceLog::today()->whereNotNull('check_out_time')->count(),
        ];

        // Get recent scans (last 10)
        $recentScans = TeacherAttendanceLog::with('teacher')
            ->today()
            ->orderBy('scan_time', 'desc')
            ->limit(10)
            ->get();

        return view('guru-piket.qr-scanner.index', compact('stats', 'recentScans'));
    }

    /**
     * Display QR scanner check-out page
     */
    public function checkOut()
    {
        // Get today's attendance statistics
        $stats = [
            'total_teachers' => Teacher::active()->count(),
            'present_today' => TeacherAttendanceLog::today()->where('status', 'hadir')->count(),
            'late_today' => TeacherAttendanceLog::today()->where('status', 'terlambat')->count(),
            'absent_today' => TeacherAttendanceLog::today()->whereIn('status', ['izin', 'sakit', 'alpha'])->count(),
            'checked_out_today' => TeacherAttendanceLog::today()->whereNotNull('check_out_time')->count(),
        ];

        // Get recent scans (last 10)
        $recentScans = TeacherAttendanceLog::with('teacher')
            ->today()
            ->orderBy('scan_time', 'desc')
            ->limit(10)
            ->get();

        return view('guru-piket.qr-scanner.check-out', compact('stats', 'recentScans'));
    }

    /**
     * Process QR code scan
     */
    public function scan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'location' => 'nullable|string',
        ]);

        // Log the scanned QR code for debugging
        \Log::info('QR Code scanned by Guru Piket: ' . $request->qr_code);

        try {
            DB::beginTransaction();

            $teacherId = null;

            // Check if QR code is JSON format (new format)
            try {
                $parsedData = json_decode($request->qr_code, true);
                if (is_array($parsedData) && isset($parsedData['type']) && $parsedData['type'] === 'teacher' && isset($parsedData['id'])) {
                    $teacherId = $parsedData['id'];
                    \Log::info('Parsed JSON QR code for check-in', ['teacher_id' => $teacherId, 'data' => $parsedData]);
                }
            } catch (\Exception $e) {
                // Not JSON, continue with old format validation
            }

            // If not JSON, validate old QR_TEACHER_ format
            if (!$teacherId) {
                if (!str_starts_with($request->qr_code, 'QR_TEACHER_')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Format QR Code tidak valid. QR Code harus berupa JSON dengan type "teacher" atau dimulai dengan "QR_TEACHER_".',
                        'type' => 'error'
                    ], 400);
                }

                // Find QR code in teacher attendance system
                $qrAttendance = QrTeacherAttendance::where('qr_code', $request->qr_code)
                    ->where('is_active', true)
                    ->first();

                if (!$qrAttendance) {
                    // Check if QR code exists but is inactive
                    $inactiveQr = QrTeacherAttendance::where('qr_code', $request->qr_code)->first();
                    if ($inactiveQr) {
                        return response()->json([
                            'success' => false,
                            'message' => 'QR Code tidak aktif. Silakan hubungi administrator.',
                            'type' => 'error'
                        ], 403);
                    }

                    return response()->json([
                        'success' => false,
                        'message' => 'QR Code tidak terdaftar dalam sistem. Pastikan QR Code guru sudah dibuat.',
                        'type' => 'error'
                    ], 404);
                }

                $teacherId = $qrAttendance->teacher_id;
            }

            $teacher = Teacher::find($teacherId);

            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guru tidak ditemukan.',
                    'type' => 'error'
                ], 404);
            }

            // Check if teacher already scanned today
            $existingLog = TeacherAttendanceLog::where('teacher_id', $teacher->id)
                ->whereDate('attendance_date', today())
                ->first();

            if ($existingLog) {
                return response()->json([
                    'success' => false,
                    'message' => "Guru {$teacher->name} sudah melakukan absensi hari ini pada {$existingLog->formatted_scan_time}.",
                    'type' => 'warning',
                    'teacher' => [
                        'name' => $teacher->name,
                        'nip' => $teacher->nip,
                        'position' => $teacher->position,
                        'existing_status' => $existingLog->status_label,
                        'scan_time' => $existingLog->formatted_scan_time,
                    ]
                ]);
            }

            // Determine attendance status based on time
            $now = Carbon::now();
            $attendanceTime = $now->format('H:i:s');
            $lateThreshold = Carbon::createFromTime(7, 30, 0); // 07:30 AM

            $status = 'hadir';
            if ($now->gt($lateThreshold)) {
                $status = 'terlambat';
            }

            // Create attendance log
            $attendanceLog = TeacherAttendanceLog::create([
                'teacher_id' => $teacher->id,
                'qr_code' => $request->qr_code,
                'status' => $status,
                'attendance_date' => today(),
                'scan_time' => $attendanceTime,
                'location' => $request->location ?? 'Sekolah',
                'scanned_by' => Auth::user()->name ?? 'Guru Piket',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Absensi berhasil untuk guru {$teacher->name}",
                'type' => 'success',
                'teacher' => [
                    'name' => $teacher->name,
                    'nip' => $teacher->nip,
                    'position' => $teacher->position,
                    'status' => $attendanceLog->status_label,
                    'scan_time' => $attendanceLog->formatted_scan_time,
                    'status_class' => $attendanceLog->status_badge_class,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses absensi: ' . $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    /**
     * Get attendance history for today
     */
    public function todayAttendance()
    {
        $attendances = TeacherAttendanceLog::with('teacher')
            ->today()
            ->orderBy('scan_time', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'attendances' => $attendances->map(function ($log) {
                return [
                    'id' => $log->id,
                    'teacher_name' => $log->teacher->name,
                    'teacher_nip' => $log->teacher->nip,
                    'teacher_position' => $log->teacher->position,
                    'status' => $log->status_label,
                    'status_class' => $log->status_badge_class,
                    'scan_time' => $log->formatted_scan_time,
                    'check_out_time' => $log->formatted_check_out_time,
                    'scanned_by' => $log->scanned_by,
                ];
            })
        ]);
    }

    /**
     * Manual attendance entry
     */
    public function manualEntry(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $teacher = Teacher::find($request->teacher_id);

            // Check if teacher already has attendance today
            $existingLog = TeacherAttendanceLog::where('teacher_id', $teacher->id)
                ->whereDate('attendance_date', today())
                ->first();

            if ($existingLog) {
                return response()->json([
                    'success' => false,
                    'message' => "Guru {$teacher->name} sudah memiliki catatan absensi hari ini.",
                    'type' => 'warning'
                ]);
            }

            // Create manual attendance log
            $attendanceLog = TeacherAttendanceLog::create([
                'teacher_id' => $teacher->id,
                'qr_code' => 'MANUAL_ENTRY',
                'status' => $request->status,
                'attendance_date' => today(),
                'scan_time' => now()->format('H:i:s'),
                'location' => 'Manual Entry',
                'scanned_by' => Auth::user()->name ?? 'Guru Piket',
                'notes' => $request->notes,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Absensi manual berhasil dicatat untuk guru {$teacher->name}",
                'type' => 'success',
                'teacher' => [
                    'name' => $teacher->name,
                    'nip' => $teacher->nip,
                    'position' => $teacher->position,
                    'status' => $attendanceLog->status_label,
                    'scan_time' => $attendanceLog->formatted_scan_time,
                    'status_class' => $attendanceLog->status_badge_class,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencatat absensi manual: ' . $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    /**
     * Get teachers for manual entry
     */
    public function getTeachers(Request $request)
    {
        $mode = $request->get('mode', 'check-in');

        if ($mode === 'manual') {
            // For manual entry, show all active teachers
            $teachers = Teacher::active()
                ->orderBy('name')
                ->get(['id', 'name', 'nip', 'position']);
        } elseif ($mode === 'check-in') {
            // Get teachers who haven't checked in today
            $teachersWithAttendance = TeacherAttendanceLog::whereDate('attendance_date', today())
                ->pluck('teacher_id')
                ->toArray();

            $teachers = Teacher::active()
                ->whereNotIn('id', $teachersWithAttendance)
                ->orderBy('name')
                ->get(['id', 'name', 'nip', 'position']);
        } else {
            // Get teachers who have checked in today but haven't checked out
            $teachersWithCheckOut = TeacherAttendanceLog::whereDate('attendance_date', today())
                ->whereNotNull('check_out_time')
                ->pluck('teacher_id')
                ->toArray();

            $teachers = Teacher::active()
                ->whereNotIn('id', $teachersWithCheckOut)
                ->whereHas('teacherAttendanceLogs', function ($query) {
                    $query->whereDate('attendance_date', today());
                })
                ->orderBy('name')
                ->get(['id', 'name', 'nip', 'position']);
        }

        return response()->json([
            'success' => true,
            'teachers' => $teachers
        ]);
    }

    /**
     * Process QR code scan for check-out
     */
    public function scanCheckOut(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        // Log the scanned QR code for debugging
        \Log::info('QR Code scanned for check-out by Guru Piket: ' . $request->qr_code);

        try {
            DB::beginTransaction();

            $teacherId = null;

            // Check if QR code is JSON format (new format)
            try {
                $parsedData = json_decode($request->qr_code, true);
                if (is_array($parsedData) && isset($parsedData['type']) && $parsedData['type'] === 'teacher' && isset($parsedData['id'])) {
                    $teacherId = $parsedData['id'];
                    \Log::info('Parsed JSON QR code for check-out', ['teacher_id' => $teacherId, 'data' => $parsedData]);
                }
            } catch (\Exception $e) {
                // Not JSON, continue with old format validation
            }

            // If not JSON, validate old QR_TEACHER_ format
            if (!$teacherId) {
                if (!str_starts_with($request->qr_code, 'QR_TEACHER_')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Format QR Code tidak valid. QR Code harus berupa JSON dengan type "teacher" atau dimulai dengan "QR_TEACHER_".',
                        'type' => 'error'
                    ], 400);
                }

                // Find QR code in teacher attendance system
                $qrAttendance = QrTeacherAttendance::where('qr_code', $request->qr_code)
                    ->where('is_active', true)
                    ->first();

                if (!$qrAttendance) {
                    // Check if QR code exists but is inactive
                    $inactiveQr = QrTeacherAttendance::where('qr_code', $request->qr_code)->first();
                    if ($inactiveQr) {
                        return response()->json([
                            'success' => false,
                            'message' => 'QR Code tidak aktif. Silakan hubungi administrator.',
                            'type' => 'error'
                        ], 403);
                    }

                    return response()->json([
                        'success' => false,
                        'message' => 'QR Code tidak terdaftar dalam sistem. Pastikan QR Code guru sudah dibuat.',
                        'type' => 'error'
                    ], 404);
                }

                $teacherId = $qrAttendance->teacher_id;
            }

            $teacher = Teacher::find($teacherId);

            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guru tidak ditemukan.',
                    'type' => 'error'
                ], 404);
            }

            // Check if teacher has checked in today but not checked out
            $existingLog = TeacherAttendanceLog::where('teacher_id', $teacher->id)
                ->whereDate('attendance_date', today())
                ->whereNull('check_out_time')
                ->first();

            if (!$existingLog) {
                return response()->json([
                    'success' => false,
                    'message' => "Guru {$teacher->name} belum melakukan absensi masuk hari ini atau sudah check-out.",
                    'type' => 'warning',
                    'teacher' => [
                        'name' => $teacher->name,
                        'nip' => $teacher->nip,
                        'position' => $teacher->position,
                    ]
                ]);
            }

            // Update check-out time
            $checkOutTime = Carbon::now()->format('H:i:s');
            $existingLog->update([
                'check_out_time' => $checkOutTime,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Check-out berhasil untuk guru {$teacher->name}",
                'type' => 'success',
                'teacher' => [
                    'name' => $teacher->name,
                    'nip' => $teacher->nip,
                    'position' => $teacher->position,
                    'check_in_time' => $existingLog->formatted_scan_time,
                    'check_out_time' => Carbon::parse($checkOutTime)->format('H:i:s'),
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses check-out: ' . $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    /**
     * Manual check-out entry
     */
    public function manualCheckOut(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $teacher = Teacher::find($request->teacher_id);

            // Check if teacher has checked in today but not checked out
            $existingLog = TeacherAttendanceLog::where('teacher_id', $teacher->id)
                ->whereDate('attendance_date', today())
                ->whereNull('check_out_time')
                ->first();

            if (!$existingLog) {
                return response()->json([
                    'success' => false,
                    'message' => "Guru {$teacher->name} belum melakukan absensi masuk hari ini atau sudah check-out.",
                    'type' => 'warning'
                ]);
            }

            // Update check-out time
            $existingLog->update([
                'check_out_time' => now()->format('H:i:s'),
                'notes' => $request->notes,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Check-out manual berhasil dicatat untuk guru {$teacher->name}",
                'type' => 'success',
                'teacher' => [
                    'name' => $teacher->name,
                    'nip' => $teacher->nip,
                    'position' => $teacher->position,
                    'check_in_time' => $existingLog->formatted_scan_time,
                    'check_out_time' => $existingLog->formatted_check_out_time,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencatat check-out manual: ' . $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

    /**
     * Get updated statistics
     */
    public function getStats()
    {
        $stats = [
            'total_teachers' => Teacher::active()->count(),
            'present_today' => TeacherAttendanceLog::today()->where('status', 'hadir')->count(),
            'late_today' => TeacherAttendanceLog::today()->where('status', 'terlambat')->count(),
            'absent_today' => TeacherAttendanceLog::today()->whereIn('status', ['izin', 'sakit', 'alpha'])->count(),
            'checked_out_today' => TeacherAttendanceLog::today()->whereNotNull('check_out_time')->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Update attendance status
     */
    public function updateStatus(Request $request, TeacherAttendanceLog $log)
    {
        $request->validate([
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            $log->update([
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status absensi berhasil diperbarui',
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }
}