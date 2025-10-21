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
        // Asumsi relasi user->teacher tersedia; jika tidak, cari via email/foreign key sesuai skema Anda
        $teacher = method_exists($user, 'teacher') ? $user->teacher : Teacher::where('user_id', $user->id)->first();

        if (!$teacher) {
            return view('teacher.qr.display', [
                'teacher' => (object)['id' => $user->id, 'name' => $user->name, 'nip' => null, 'position' => null],
                'qrAttendance' => null,
                'todayAttendance' => null,
                'recentAttendance' => collect(),
            ]);
        }

        $qrAttendance = QrTeacherAttendance::where('teacher_id', $teacher->id)->where('is_active', true)->first();

        $todayAttendance = TeacherAttendanceLog::where('teacher_id', $teacher->id)
            ->whereDate('attendance_date', today())
            ->orderByDesc('scan_time')
            ->first();

        $recentAttendance = TeacherAttendanceLog::where('teacher_id', $teacher->id)
            ->orderByDesc('attendance_date')
            ->orderByDesc('scan_time')
            ->limit(10)
            ->get();

        return view('teacher.qr.display', compact('teacher', 'qrAttendance', 'todayAttendance', 'recentAttendance'));
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
        $path = storage_path('app/' . ltrim($qrAttendance->qr_image_path, '/'));
        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File QR Code tidak ditemukan.');
        }
        return response()->download($path, 'QR-Teacher-' . preg_replace('/\s+/', '-', $teacher->name) . '.png');
    }
}
