<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TeacherAttendanceLog;
use Illuminate\Support\Facades\Response;

class QrTeacherLogsController extends Controller
{
    public function index(Request $request)
    {
        $query = TeacherAttendanceLog::with('teacher')
            ->when($request->filled('date'), function($q) use ($request) {
                $q->whereDate('attendance_date', $request->date);
            }, function($q) {
                $q->whereDate('attendance_date', today());
            })
            ->when($request->filled('status'), function($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('teacher'), function($q) use ($request) {
                $q->where('teacher_id', $request->teacher);
            })
            ->orderByDesc('attendance_date')
            ->orderByDesc('scan_time');

        $logs = $query->paginate(20);

        $teachers = Teacher::orderBy('name')->get(['id','name','nip']);
        $statuses = ['hadir','terlambat','izin','sakit','alpha'];

        // Calculate stats for today
        $stats = [
            'total' => Teacher::active()->count(),
            'hadir' => TeacherAttendanceLog::whereDate('attendance_date', today())->where('status', 'hadir')->count(),
            'izin' => TeacherAttendanceLog::whereDate('attendance_date', today())->where('status', 'izin')->count(),
            'sakit' => TeacherAttendanceLog::whereDate('attendance_date', today())->where('status', 'sakit')->count(),
            'alpha' => TeacherAttendanceLog::whereDate('attendance_date', today())->where('status', 'alpha')->count(),
        ];

        return view('admin.qr-teacher.logs', compact('logs','teachers','statuses','stats'));
    }

    public function export(Request $request)
    {
        $logs = TeacherAttendanceLog::with('teacher')
            ->when($request->filled('date'), fn($q) => $q->whereDate('attendance_date', $request->date))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('teacher'), fn($q) => $q->where('teacher_id', $request->teacher))
            ->orderByDesc('attendance_date')->orderByDesc('scan_time')
            ->limit(5000)
            ->get();

        $rows = [];
        $rows[] = ['Guru','NIP','Status','Waktu Scan','Waktu Check Out','Tanggal','Lokasi','Discan Oleh','Catatan'];
        foreach ($logs as $log) {
            $rows[] = [
                $log->teacher->name ?? '-',
                $log->teacher->nip ?? '-',
                $log->status ?? '-',
                $log->scan_time ?? '-',
                $log->check_out_time ? $log->check_out_time->format('H:i:s') : '-',
                optional($log->attendance_date)->format('Y-m-d') ?? '-',
                $log->location ?? '-',
                $log->scanned_by ?? '-',
                $log->notes ?? '-',
            ];
        }

        $csv = '';
        foreach ($rows as $row) {
            $csv .= implode(',', array_map(function($v){
                $v = (string)$v;
                if (str_contains($v, ',') || str_contains($v, '"')) {
                    $v = '"'.str_replace('"','""',$v).'"';
                }
                return $v;
            }, $row))."\r\n";
        }

        $filename = 'teacher-attendance-logs-'.now()->format('Ymd_His').'.csv';
        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ]);
    }
}
