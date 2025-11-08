<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PklRegistration;
use App\Models\PklAttendanceLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PklAttendanceController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();
        $today = Carbon::today();

        $pklRegistration = PklRegistration::where('student_id', $studentId)
            ->where('status', 'approved')
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();

        if (!$pklRegistration) {
            return view('student.qr-scanner.pulang', ['error' => 'Anda tidak memiliki jadwal PKL yang aktif saat ini.']);
        }

        return view('student.qr-scanner.pulang', compact('pklRegistration'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('PKL Attendance Store - Request received', [
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            $validator = Validator::make($request->all(), [
                'qr_code' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::warning('PKL Attendance Store - Validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);
                return response()->json([
                    'error' => $validator->errors()->first()
                ], 422);
            }

            $qrCodeData = $request->qr_code;
            $studentId = Auth::id();
            $today = Carbon::today();

            Log::info('PKL Attendance Store - Searching for attendance log', [
                'student_id' => $studentId,
                'date' => $today->toDateString()
            ]);

            // Find the attendance log for today that has a scan_in time but no scan_out time
            $attendanceLog = PklAttendanceLog::where('student_id', $studentId)
                ->whereDate('scan_time', $today)
                ->whereNull('check_out_time')
                ->first();

            // Check if already scanned out today (double scan prevention)
            if (!$attendanceLog) {
                $alreadyScannedOut = PklAttendanceLog::where('student_id', $studentId)
                    ->whereDate('scan_time', $today)
                    ->whereNotNull('check_out_time')
                    ->exists();

                if ($alreadyScannedOut) {
                    Log::warning('PKL Attendance Store - Double scan attempt', [
                        'student_id' => $studentId,
                        'date' => $today->toDateString()
                    ]);
                    return response()->json([
                        'error' => 'Anda sudah melakukan absensi pulang hari ini. Scan pulang hanya dapat dilakukan sekali per hari.'
                    ], 400);
                }

                Log::warning('PKL Attendance Store - No check-in record found', [
                    'student_id' => $studentId,
                    'date' => $today->toDateString()
                ]);
                return response()->json(['error' => 'Tidak ada data absensi masuk untuk hari ini.'], 404);
            }

            // Check if log activity is filled
            if (empty($attendanceLog->log_activity) || trim($attendanceLog->log_activity) === '') {
                Log::warning('PKL Attendance Store - Log activity not filled', [
                    'attendance_log_id' => $attendanceLog->id,
                    'student_id' => $studentId
                ]);
                return response()->json([
                    'error' => 'Anda harus mengisi Log Aktivitas terlebih dahulu sebelum absen pulang.',
                    'redirect' => route('student.qr-scanner.log-activity')
                ], 400);
            }

            Log::info('PKL Attendance Store - Updating check-out time', [
                'attendance_log_id' => $attendanceLog->id
            ]);

            // Update the scan_out time
            $attendanceLog->check_out_time = Carbon::now();
            $attendanceLog->save();

            Log::info('PKL Attendance Store - Success', [
                'attendance_log_id' => $attendanceLog->id,
                'check_out_time' => $attendanceLog->check_out_time
            ]);

            return response()->json([
                'success' => 'Absensi pulang berhasil dicatat.',
                'data' => [
                    'check_out_time' => $attendanceLog->check_out_time->format('H:i:s')
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('PKL Attendance Store - Exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}