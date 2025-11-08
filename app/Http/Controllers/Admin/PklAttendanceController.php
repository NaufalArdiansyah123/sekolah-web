<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PklAttendanceLog;
use App\Models\PklRegistration;
use App\Exports\PklAttendanceExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PklAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display PKL attendance logs
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $tempatPkl = $request->get('tempat_pkl');
        $status = $request->get('status');

        // Get PKL attendance logs with relationships
        $query = PklAttendanceLog::with([
            'student',
            'pklRegistration.tempatPkl'
        ]);

        // Apply filters
        if ($search) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })->orWhereHas('pklRegistration.tempatPkl', function ($q) use ($search) {
                $q->where('nama_tempat', 'like', '%' . $search . '%');
            });
        }

        if ($tempatPkl) {
            $query->whereHas('pklRegistration', function ($q) use ($tempatPkl) {
                $q->where('tempat_pkl_id', $tempatPkl);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($dateFrom) {
            $query->whereDate('scan_date', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('scan_date', '<=', $dateTo);
        }

        // Order by latest first
        $pklAttendanceLogs = $query->orderBy('scan_date', 'desc')
            ->orderBy('scan_time', 'desc')
            ->paginate(15);

        // Get tempat PKL for filter dropdown
        $tempatPkls = \App\Models\TempatPkl::orderBy('nama_tempat')->get();

        // Status options for filter
        $statusOptions = [
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha'
        ];

        return view('admin.absensi-pkl.index', compact(
            'pklAttendanceLogs',
            'search',
            'dateFrom',
            'dateTo',
            'tempatPkl',
            'status',
            'tempatPkls',
            'statusOptions'
        ));
    }

    /**
     * Display PKL Attendance Submissions (NEW PAGE)
     */
    public function submissionsPkl(Request $request)
    {
        $search = $request->get('search', '');
        $dateFrom = $request->get('date_from', Carbon::now()->format('Y-m-d'));
        $dateTo = $request->get('date_to', Carbon::now()->format('Y-m-d'));
        $perPage = 15;

        $query = PklRegistration::with([
            'student',
            'tempatPkl',
            'pklAttendanceLogs' => function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('scan_date', [$dateFrom, $dateTo])
                    ->orderBy('scan_date', 'desc');
            }
        ])->where('status', 'approved');  // Filter hanya data yang approved

        // Search filter
        if ($search) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
                ->orWhereHas('tempatPkl', function ($q) use ($search) {
                    $q->where('nama_tempat', 'like', "%$search%");
                });
        }

        $pklRegistrations = $query->paginate($perPage);

        return view('admin.absensi-pkl.submissions', [
            'pklRegistrations' => $pklRegistrations,
            'search' => $search,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    /**
     * Show the form for editing the specified PKL attendance log.
     */
    public function show($id)
    {
        $log = PklAttendanceLog::with(['student', 'pklRegistration.tempatPkl'])->findOrFail($id);

        return response()->json([
            'id' => $log->id,
            'student_name' => $log->student->name ?? '-',
            'status' => $log->status,
            'status_text' => $log->getStatusTextAttribute(),
            'scan_time' => $log->scan_time ? Carbon::parse($log->scan_time)->format('H:i') : null,
            'check_out_time' => $log->check_out_time ? Carbon::parse($log->check_out_time)->format('H:i') : null,
            'log_activity' => $log->log_activity,
            'sick_note_path' => $log->sick_note_path,
        ]);
    }

    /**
     * Update the specified PKL attendance log in storage.
     */
    public function update(Request $request, $id)
    {
        $log = PklAttendanceLog::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:hadir,sakit,izin,alpha',
            'check_out_time' => 'nullable|date_format:H:i',
            'log_activity' => 'nullable|string|max:1000',
            'sick_note' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Update status
        $log->status = $validated['status'];

        // Update check_out_time if provided
        if ($request->filled('check_out_time')) {
            $log->check_out_time = $validated['check_out_time'];
        }

        // Update log activity if provided
        if ($request->filled('log_activity')) {
            $log->log_activity = $validated['log_activity'];
        }

        // Handle sick note upload
        if ($request->hasFile('sick_note') && $validated['status'] === 'sakit') {
            $file = $request->file('sick_note');
            $filename = 'pkl-sick-notes/' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public', $filename);
            $log->sick_note_path = '/storage/' . $filename;
        }

        $log->save();

        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully',
            'data' => $log
        ]);
    }

    /**
     * Get registration data for creating new attendance
     */
    public function getRegistrationData($registrationId)
    {
        $registration = PklRegistration::with(['student', 'tempatPkl'])->find($registrationId);

        if (!$registration) {
            return response()->json(['error' => 'Registration not found'], 404);
        }

        return response()->json([
            'registration_id' => $registration->id,
            'student_id' => $registration->student->id,
            'student_name' => $registration->student->name,
            'student_email' => $registration->student->email,
            'company_name' => $registration->tempatPkl->nama_tempat ?? '-',
            'company_location' => $registration->tempatPkl->kota ?? '-',
        ]);
    }

    /**
     * Create new PKL attendance record
     */
    public function createAttendance(Request $request, $registrationId)
    {
        $registration = PklRegistration::with('student')->find($registrationId);

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'Registration not found'], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:hadir,sakit,izin,alpha',
            'scan_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'log_activity' => 'nullable|string|max:1000',
            'sick_note' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $log = new PklAttendanceLog();
        $log->pkl_registration_id = $registrationId;
        $log->user_id = $registration->student_id;
        $log->scan_date = Carbon::now();
        $log->scan_time = $validated['scan_time'] ? Carbon::createFromFormat('H:i', $validated['scan_time']) : Carbon::now();
        $log->check_out_time = $validated['check_out_time'] ? Carbon::createFromFormat('H:i', $validated['check_out_time']) : null;
        $log->status = $validated['status'];
        $log->log_activity = $validated['log_activity'] ?? null;
        $log->ip_address = $request->ip();
        $log->created_by = auth()->user()->name . ' (Admin)';

        // Handle sick note upload
        if ($request->hasFile('sick_note') && $validated['status'] === 'sakit') {
            $file = $request->file('sick_note');
            $filename = 'pkl-sick-notes/' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public', $filename);
            $log->sick_note_path = '/storage/' . $filename;
        }

        $log->save();

        return response()->json([
            'success' => true,
            'message' => 'Attendance record created successfully',
            'data' => $log
        ]);
    }

    /**
     * Show attendance detail
     */
    public function showDetail($id)
    {
        $log = PklAttendanceLog::with([
            'student',
            'pklRegistration.tempatPkl'
        ])->find($id);

        if (!$log) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $student = $log->student;
        $registration = $log->pklRegistration;

        return response()->json([
            'student' => [
                'name' => $student->name,
                'nis' => $student->student->nis ?? 'N/A',
                'email' => $student->email,
                'class' => $student->student->class->nama_kelas ?? 'N/A',
                'major' => $student->student->major ?? 'N/A',
                'phone' => $student->student->no_telepon ?? 'N/A',
            ],
            'pkl' => [
                'company_name' => $registration->tempatPkl->nama_tempat ?? '-',
                'start_date' => $registration->tanggal_mulai ? Carbon::parse($registration->tanggal_mulai)->format('d/m/Y') : 'N/A',
                'end_date' => $registration->tanggal_selesai ? Carbon::parse($registration->tanggal_selesai)->format('d/m/Y') : 'N/A',
                'address' => $registration->tempatPkl->alamat ?? '-',
            ],
            'log' => [
                'id' => $log->id,
                'scan_date' => $log->scan_date ? Carbon::parse($log->scan_date)->format('d/m/Y') : 'N/A',
                'scan_time' => $log->scan_time ? Carbon::parse($log->scan_time)->format('H:i') : 'N/A',
                'check_out_time' => $log->check_out_time ? Carbon::parse($log->check_out_time)->format('H:i') : '-',
                'status' => $log->status,
                'status_text' => $log->getStatusTextAttribute(),
                'log_activity' => $log->log_activity,
                'ip_address' => $log->ip_address,
            ]
        ]);
    }

    /**
     * Export PKL Attendance to Excel
     */
    public function export(Request $request)
    {
        $search = $request->get('search', '');
        $dateFrom = $request->get('date_from', Carbon::now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', Carbon::now()->format('Y-m-d'));

        $filename = 'PKL_Attendance_' . date('d-m-Y_H-i-s') . '.xlsx';

        return Excel::download(
            new PklAttendanceExport($search, $dateFrom, $dateTo),
            $filename
        );
    }
}
