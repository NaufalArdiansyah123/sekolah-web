<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PklRegistration;
use App\Models\PklAttendanceLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PklHistoryController extends Controller
{
    /**
     * Show PKL attendance history page
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->user();

            // Check if student has approved PKL registration
            $pklRegistration = PklRegistration::where('student_id', $user->id)
                ->where('status', 'approved')
                ->whereNotNull('qr_code')
                ->with('tempatPkl')
                ->first();

            if (!$pklRegistration) {
                return view('student.qr-scanner.history', [
                    'error' => 'Anda belum memiliki registrasi PKL yang disetujui atau QR Code belum dibuat.',
                    'attendanceLogs' => collect(),
                    'pklRegistration' => null
                ]);
            }

            // Check if student is in class 11 (PKL requirement)
            $student = $this->getStudentData();
            if (!$student || !$student->class || $student->class->level != '11') {
                return view('student.qr-scanner.history', [
                    'error' => 'Riwayat PKL hanya untuk siswa kelas 11.',
                    'attendanceLogs' => collect(),
                    'pklRegistration' => null
                ]);
            }

            // Get attendance logs with pagination using Eloquent
            $attendanceLogs = PklAttendanceLog::with(['pklRegistration.tempatPkl'])
                ->where('student_id', $user->id)
                ->orderBy('scan_date', 'desc')
                ->orderBy('scan_time', 'desc')
                ->paginate(15);

            return view('student.qr-scanner.history', compact('attendanceLogs', 'pklRegistration'));

        } catch (\Exception $e) {
            \Log::error('Error loading PKL attendance history page:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return view('student.qr-scanner.history', [
                'error' => 'Terjadi kesalahan saat memuat riwayat absensi PKL.',
                'attendanceLogs' => collect(),
                'pklRegistration' => null
            ]);
        }
    }

    /**
     * Get PKL attendance history (API endpoint for AJAX)
     */
    public function getHistory(Request $request)
    {
        try {
            $user = auth()->user();

            $month = $request->get('month', date('m'));
            $year = $request->get('year', date('Y'));

            $attendanceHistory = PklAttendanceLog::with(['pklRegistration.tempatPkl'])
                ->where('student_id', $user->id)
                ->whereMonth('scan_date', $month)
                ->whereYear('scan_date', $year)
                ->orderBy('scan_date', 'desc')
                ->get()
                ->map(function ($log) {
                    return [
                        'date' => $log->scan_date->format('d/m/Y'),
                        'day' => $log->scan_date->format('l'),
                        'scan_time' => $log->scan_time->format('H:i:s'),
                        'location' => $log->location ?: 'Tidak diketahui',
                        'tempat_pkl' => $log->pklRegistration->tempatPkl ? $log->pklRegistration->tempatPkl->nama_tempat : 'Tidak diketahui',
                        'period' => $log->pklRegistration->tanggal_mulai->format('d/m/Y') . ' - ' . $log->pklRegistration->tanggal_selesai->format('d/m/Y'),
                    ];
                });

            return response()->json([
                'success' => true,
                'attendance_history' => $attendanceHistory,
                'month' => $month,
                'year' => $year,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error getting PKL attendance history:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil riwayat absensi PKL.',
            ], 500);
        }
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
        $student = \App\Models\Student::with('class')->where('user_id', $user->id)->first();
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
            $student = \App\Models\Student::with('class')->where('email', $user->email)->first();
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
            $student = \App\Models\Student::with('class')->where('nis', $user->nis)->first();
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
}
