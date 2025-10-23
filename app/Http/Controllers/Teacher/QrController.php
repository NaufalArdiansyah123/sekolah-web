<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\QrTeacherAttendance;
use App\Models\TeacherAttendanceLog;

class QrController extends Controller
{
    public function my()
    {
        $user = Auth::user();
        
        // Debug logging
        \Log::info('Teacher QR Display Debug:', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_roles' => $user->roles->pluck('name')->toArray(),
        ]);
        
        // Asumsi relasi user->teacher tersedia; jika tidak, cari via email/foreign key sesuai skema Anda
        $teacher = method_exists($user, 'teacher') ? $user->teacher : Teacher::where('user_id', $user->id)->first();

        \Log::info('Teacher found:', [
            'teacher_found' => $teacher ? true : false,
            'teacher_id' => $teacher ? $teacher->id : null,
            'teacher_name' => $teacher ? $teacher->name : null,
        ]);

        if (!$teacher) {
            \Log::warning('No teacher found for user', ['user_id' => $user->id]);
            return view('teacher.qr.display', [
                'teacher' => (object)['id' => $user->id, 'name' => $user->name, 'nip' => null, 'position' => null],
                'qrAttendance' => null,
                'todayAttendance' => null,
                'recentAttendance' => collect(),
                'monthlyStats' => ['hadir' => 0, 'terlambat' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0],
            ]);
        }

        $qrAttendance = QrTeacherAttendance::where('teacher_id', $teacher->id)->where('is_active', true)->first();
        
        \Log::info('QR Attendance found:', [
            'qr_attendance_found' => $qrAttendance ? true : false,
            'qr_attendance_id' => $qrAttendance ? $qrAttendance->id : null,
            'qr_image_path' => $qrAttendance ? $qrAttendance->qr_image_path : null,
            'qr_image_url' => $qrAttendance ? $qrAttendance->qr_image_url : null,
        ]);

        $todayAttendance = TeacherAttendanceLog::where('teacher_id', $teacher->id)
            ->whereDate('attendance_date', today())
            ->orderByDesc('scan_time')
            ->first();

        $recentAttendance = TeacherAttendanceLog::where('teacher_id', $teacher->id)
            ->orderByDesc('attendance_date')
            ->orderByDesc('scan_time')
            ->limit(10)
            ->get();

        // Calculate monthly stats
        $monthlyStats = [
            'hadir' => TeacherAttendanceLog::where('teacher_id', $teacher->id)
                ->whereMonth('attendance_date', now()->month)
                ->whereYear('attendance_date', now()->year)
                ->where('status', 'hadir')->count(),
            'terlambat' => TeacherAttendanceLog::where('teacher_id', $teacher->id)
                ->whereMonth('attendance_date', now()->month)
                ->whereYear('attendance_date', now()->year)
                ->where('status', 'terlambat')->count(),
            'izin' => TeacherAttendanceLog::where('teacher_id', $teacher->id)
                ->whereMonth('attendance_date', now()->month)
                ->whereYear('attendance_date', now()->year)
                ->where('status', 'izin')->count(),
            'sakit' => TeacherAttendanceLog::where('teacher_id', $teacher->id)
                ->whereMonth('attendance_date', now()->month)
                ->whereYear('attendance_date', now()->year)
                ->where('status', 'sakit')->count(),
            'alpha' => TeacherAttendanceLog::where('teacher_id', $teacher->id)
                ->whereMonth('attendance_date', now()->month)
                ->whereYear('attendance_date', now()->year)
                ->where('status', 'alpha')->count(),
        ];

        return view('teacher.qr.display', compact('teacher', 'qrAttendance', 'todayAttendance', 'recentAttendance', 'monthlyStats'));
    }

    public function download()
    {
        $user = Auth::user();
        $teacher = method_exists($user, 'teacher') ? $user->teacher : Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            abort(404);
        }
        $qrAttendance = QrTeacherAttendance::where('teacher_id', $teacher->id)->where('is_active', true)->first();
        if (!$qrAttendance || !$qrAttendance->qr_image_path) {
            return redirect()->back()->with('error', 'QR Code tidak tersedia untuk diunduh.');
        }
        
        // Correct path - files are stored in app/public/
        $path = storage_path('app/public/' . $qrAttendance->qr_image_path);
        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File QR Code tidak ditemukan.');
        }
        
        // Get file extension from path
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = 'QR-Teacher-' . preg_replace('/\s+/', '-', $teacher->name) . '.' . $extension;
        
        return response()->download($path, $filename);
    }
}
