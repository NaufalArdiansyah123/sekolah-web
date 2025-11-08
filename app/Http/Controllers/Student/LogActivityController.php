<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PklRegistration;
use App\Models\PklAttendanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogActivityController extends Controller
{
    /**
     * Show log activity page
     */
    public function index()
    {
        try {
            $user = auth()->user();

            // Get approved PKL registration
            $pklRegistration = PklRegistration::where('student_id', $user->id)
                ->where('status', 'approved')
                ->with('tempatPkl')
                ->first();

            if (!$pklRegistration) {
                return view('student.qr-scanner.log-activity', [
                    'error' => 'Anda belum memiliki registrasi PKL yang disetujui.',
                    'pklRegistration' => null,
                    'logs' => collect()
                ]);
            }

            // Get attendance logs with activity
            $logs = PklAttendanceLog::where('pkl_registration_id', $pklRegistration->id)
                ->orderBy('scan_date', 'desc')
                ->orderBy('scan_time', 'desc')
                ->paginate(15);

            return view('student.qr-scanner.log-activity', compact('pklRegistration', 'logs'));

        } catch (\Exception $e) {
            Log::error('Error loading log activity:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return view('student.qr-scanner.log-activity', [
                'error' => 'Terjadi kesalahan saat memuat data.',
                'pklRegistration' => null,
                'logs' => collect()
            ]);
        }
    }

    /**
     * Update log activity
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'log_activity' => 'required|string|min:10|max:2000',
            ], [
                'log_activity.required' => 'Log aktivitas harus diisi.',
                'log_activity.min' => 'Log aktivitas minimal 10 karakter.',
                'log_activity.max' => 'Log aktivitas maksimal 2000 karakter.',
            ]);

            $user = auth()->user();

            // Get the attendance log
            $attendanceLog = PklAttendanceLog::where('id', $id)
                ->where('student_id', $user->id)
                ->firstOrFail();

            // Update log activity
            $attendanceLog->update([
                'log_activity' => $validated['log_activity']
            ]);

            Log::info('Log activity updated:', [
                'attendance_log_id' => $id,
                'student_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Log aktivitas berhasil disimpan!',
                'data' => [
                    'log_activity' => $attendanceLog->log_activity,
                    'updated_at' => $attendanceLog->updated_at->format('d/m/Y H:i')
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data absensi tidak ditemukan.',
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error updating log activity:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan log aktivitas.',
            ], 500);
        }
    }
}
