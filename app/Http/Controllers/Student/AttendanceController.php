<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }

    /**
     * Display attendance dashboard
     */
    public function index(Request $request)
    {
        $studentId = Auth::id();
        $currentMonth = $request->get('month', now()->format('Y-m'));
        $monthStart = Carbon::parse($currentMonth . '-01')->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        // Get attendance records for current month
        $attendances = Attendance::with(['session'])
            ->where('student_id', $studentId)
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->orderBy('date', 'desc')
            ->get();

        // Get statistics
        $stats = [
            'total_days' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'sick' => $attendances->where('status', 'sick')->count(),
            'permission' => $attendances->where('status', 'permission')->count(),
        ];

        $stats['attendance_rate'] = $stats['total_days'] > 0 
            ? round(($stats['present'] + $stats['late']) / $stats['total_days'] * 100, 1) 
            : 0;

        // Get active sessions (for check-in)
        $activeSessions = AttendanceSession::where('status', 'active')
            ->where('date', now()->toDateString())
            ->where('start_time', '<=', now()->toTimeString())
            ->where('end_time', '>=', now()->toTimeString())
            ->get();

        return view('student.attendance.index', [
            'pageTitle' => 'Absensi',
            'breadcrumb' => [
                ['title' => 'Absensi']
            ],
            'attendances' => $attendances,
            'stats' => $stats,
            'activeSessions' => $activeSessions,
            'currentMonth' => $currentMonth
        ]);
    }

    /**
     * Check in to attendance session
     */
    public function checkIn(Request $request, $sessionId)
    {
        $session = AttendanceSession::findOrFail($sessionId);
        $studentId = Auth::id();

        // Check if session is active
        if ($session->status !== 'active') {
            return redirect()->back()->with('error', 'Sesi absensi tidak aktif!');
        }

        // Check if today
        if ($session->date !== now()->toDateString()) {
            return redirect()->back()->with('error', 'Sesi absensi bukan untuk hari ini!');
        }

        // Check if already checked in
        $existingAttendance = Attendance::where('session_id', $sessionId)
            ->where('student_id', $studentId)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi untuk sesi ini!');
        }

        // Determine status based on time
        $now = now();
        $sessionStart = Carbon::parse($session->date . ' ' . $session->start_time);
        $sessionEnd = Carbon::parse($session->date . ' ' . $session->end_time);
        $lateThreshold = $sessionStart->copy()->addMinutes(15); // 15 minutes late threshold

        $status = 'present';
        if ($now->gt($lateThreshold)) {
            $status = 'late';
        }

        // Create attendance record
        Attendance::create([
            'session_id' => $sessionId,
            'student_id' => $studentId,
            'date' => $session->date,
            'status' => $status,
            'check_in_time' => $now->toTimeString(),
            'notes' => $request->notes
        ]);

        $message = $status === 'late' 
            ? 'Absensi berhasil! Anda terlambat.' 
            : 'Absensi berhasil!';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Submit excuse/permission
     */
    public function submitExcuse(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string|max:500',
            'type' => 'required|in:sick,permission',
            'attachment' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png'
        ]);

        $studentId = Auth::id();
        $date = $request->date;

        // Check if already has attendance for this date
        $existingAttendance = Attendance::where('student_id', $studentId)
            ->where('date', $date)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'Anda sudah memiliki catatan absensi untuk tanggal ini!');
        }

        $attendance = new Attendance();
        $attendance->student_id = $studentId;
        $attendance->date = $date;
        $attendance->status = $request->type;
        $attendance->notes = $request->reason;

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('attendance/excuses', $filename, 'public');
            $attendance->attachment = $path;
        }

        $attendance->save();

        return redirect()->back()->with('success', 'Pengajuan izin berhasil dikirim!');
    }

    /**
     * Show attendance history
     */
    public function history(Request $request)
    {
        $studentId = Auth::id();
        $year = $request->get('year', now()->year);

        $attendances = Attendance::with(['session'])
            ->where('student_id', $studentId)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->paginate(20);

        // Monthly statistics
        $monthlyStats = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthAttendances = Attendance::where('student_id', $studentId)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();

            $monthlyStats[$month] = [
                'total' => $monthAttendances->count(),
                'present' => $monthAttendances->where('status', 'present')->count(),
                'late' => $monthAttendances->where('status', 'late')->count(),
                'absent' => $monthAttendances->where('status', 'absent')->count(),
                'sick' => $monthAttendances->where('status', 'sick')->count(),
                'permission' => $monthAttendances->where('status', 'permission')->count(),
            ];
        }

        return view('student.attendance.history', [
            'pageTitle' => 'Riwayat Absensi',
            'breadcrumb' => [
                ['title' => 'Absensi', 'url' => route('student.attendance.index')],
                ['title' => 'Riwayat']
            ],
            'attendances' => $attendances,
            'monthlyStats' => $monthlyStats,
            'currentYear' => $year
        ]);
    }
}