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
     * Process QR code scan
     */
    public function scan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Find QR code in teacher attendance system
            $qrAttendance = QrTeacherAttendance::where('qr_code', $request->qr_code)
                                             ->where('is_active', true)
                                             ->first();

            if (!$qrAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau tidak ditemukan untuk guru.',
                    'type' => 'error'
                ], 404);
            }

            $teacher = $qrAttendance->teacher;

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
            'attendances' => $attendances->map(function($log) {
                return [
                    'id' => $log->id,
                    'teacher_name' => $log->teacher->name,
                    'teacher_nip' => $log->teacher->nip,
                    'teacher_position' => $log->teacher->position,
                    'status' => $log->status_label,
                    'status_class' => $log->status_badge_class,
                    'scan_time' => $log->formatted_scan_time,
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
    public function getTeachers()
    {
        $teachers = Teacher::active()
                          ->whereDoesntHave('teacherAttendanceLogs', function($query) {
                              $query->whereDate('attendance_date', today());
                          })
                          ->orderBy('name')
                          ->get(['id', 'name', 'nip', 'position']);

        return response()->json([
            'success' => true,
            'teachers' => $teachers
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