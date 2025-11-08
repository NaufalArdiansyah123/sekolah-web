<?php

namespace App\Http\Controllers\GuruPiket;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\AttendanceLog;
use App\Models\QrAttendance;
use App\Models\Classes;
use App\Models\SecurityViolation;
use App\Models\AttendanceSubmission;
use App\Models\User;
use App\Exports\AttendanceExport;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->middleware('auth');
        $this->middleware('role:guru_piket');
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Get submission detail
     */
    public function getSubmissionDetail($id)
    {
        $submission = AttendanceSubmission::where('guru_piket_id', auth()->id())
            ->with(['class', 'guruPiket', 'confirmer', 'teacher'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'submission' => $submission
        ]);
    }

    /**
     * Show submissions page for guru piket - now showing students grouped by class
     */
    public function submissions(Request $request)
    {
        $selectedClass = $request->get('class');
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));

        // Get all active classes for filter
        $classes = Classes::active()->orderBy('level')->orderBy('name')->get();

        // Get students with their classes and attendance data
        $query = Student::with([
            'class',
            'attendanceLogs' => function ($q) use ($date) {
                $q->whereDate('attendance_date', $date);
            }
        ])->active();

        if ($selectedClass && $selectedClass !== 'all') {
            $query->where('class_id', $selectedClass);
        }

        $students = $query->get();

        // Group students by class
        $studentsByClass = $students->groupBy(function ($student) {
            return $student->class ? $student->class->name : 'Tidak ada kelas';
        })->sortKeys();

        // Calculate statistics
        $totalStudents = $students->count();
        $presentToday = $students->filter(function ($student) use ($date) {
            $attendance = $student->attendanceLogs->first();
            return $attendance && in_array($attendance->status, ['hadir', 'izin']);
        })->count();

        $lateToday = $students->filter(function ($student) use ($date) {
            $attendance = $student->attendanceLogs->first();
            return $attendance && $attendance->status === 'terlambat';
        })->count();

        $absentToday = $students->filter(function ($student) use ($date) {
            $attendance = $student->attendanceLogs->first();
            return !$attendance || in_array($attendance->status, ['alpha', 'sakit']);
        })->count();

        $statistics = [
            'total_students' => $totalStudents,
            'present_today' => $presentToday,
            'late_today' => $lateToday,
            'absent_today' => $absentToday,
        ];

        return view('guru-piket.attendance.submissions', compact('studentsByClass', 'classes', 'selectedClass', 'date', 'statistics'));
    }

    /**
     * Show PKL attendance submissions page
     */
    public function submissionsPkl(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $dateFrom = $request->get('date_from', \Carbon\Carbon::today()->format('Y-m-d'));
        $dateTo = $request->get('date_to');

        // Get all approved PKL registrations with their students and today's attendance
        $query = \App\Models\PklRegistration::with([
            'student',
            'tempatPkl',
            'pklAttendanceLogs' => function ($q) use ($dateFrom, $dateTo) {
                if ($dateFrom) {
                    $q->whereDate('scan_date', '>=', $dateFrom);
                }
                if ($dateTo) {
                    $q->whereDate('scan_date', '<=', $dateTo);
                } else if ($dateFrom) {
                    // If only dateFrom is set, show only that specific date
                    $q->whereDate('scan_date', $dateFrom);
                }
                $q->orderBy('scan_date', 'desc')->orderBy('scan_time', 'desc');
            }
        ])->where('status', 'approved');

        // Apply search filters
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })->orWhereHas('tempatPkl', function ($subQ) use ($search) {
                    $subQ->where('nama_tempat', 'like', '%' . $search . '%');
                });
            });
        }

        // Order by latest registration
        $pklRegistrations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('guru-piket.attendance.submissions-pkl', compact(
            'pklRegistrations',
            'search',
            'status',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Confirm or reject submission
     */
    public function confirmSubmission(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:confirm,reject',
            'notes' => 'nullable|string|max:500'
        ]);

        $submission = AttendanceSubmission::where('guru_piket_id', auth()->id())
            ->findOrFail($id);

        if ($submission->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Submission sudah diproses sebelumnya'
            ], 400);
        }

        DB::transaction(function () use ($submission, $request) {
            if ($request->action === 'confirm') {
                $submission->update([
                    'status' => AttendanceSubmission::STATUS_CONFIRMED,
                    'confirmed_by' => auth()->id(),
                    'confirmed_at' => now(),
                    'confirmation_notes' => $request->notes
                ]);
            } else {
                $submission->update([
                    'status' => AttendanceSubmission::STATUS_REJECTED,
                    'confirmed_by' => auth()->id(),
                    'confirmed_at' => now(),
                    'confirmation_notes' => $request->notes
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Submission berhasil ' . ($request->action === 'confirm' ? 'dikonfirmasi' : 'ditolak'),
            'submission' => $submission->fresh()
        ]);
    }

    /**
     * Update student attendance
     */
    public function updateStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
            'time' => 'nullable|string',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:500',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120' // 5MB max
        ]);

        $student = Student::findOrFail($request->student_id);

        // Parse time if provided
        $scanTime = null;
        if ($request->time) {
            $scanTime = Carbon::parse($request->date . ' ' . $request->time);
        }

        // Handle document upload for sakit/izin status
        $documentPath = null;
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $extension = $document->getClientOriginalExtension();

            // Create filename with "surat" prefix for clarity
            $documentType = 'surat_' . $request->status; // becomes "surat_sakit" or "surat_izin"
            $fileName = $student->nis . '_' . $student->name . '_' . $documentType . '_' . time() . '.' . $extension;
            // Replace spaces and special characters with underscores for safe filename
            $fileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $fileName);

            // Store in public/storage/surat-izin-sakit directory
            $documentPath = $document->storeAs('surat-izin-sakit', $fileName, 'public');
        }

        // Update or create attendance log
        $attendanceLog = AttendanceLog::updateOrCreate([
            'student_id' => $request->student_id,
            'attendance_date' => $request->date,
        ], [
            'teacher_id' => null, // Guru piket doesn't have teacher relation
            'status' => $request->status,
            'notes' => $request->notes,
            'scan_time' => $scanTime,
            'location' => 'Updated by Guru Piket',
            'qr_code' => $student->qrAttendance->qr_code ?? null,
            'document_path' => $documentPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data absensi siswa berhasil diperbarui',
            'data' => [
                'student_name' => $student->name,
                'status' => $attendanceLog->status_text,
                'scan_time' => $attendanceLog->scan_time ? $attendanceLog->scan_time->format('H:i') : null,
                'notes' => $attendanceLog->notes
            ]
        ]);
    }

    /**
     * Bulk update attendance status for multiple students
     */
    public function bulkUpdateAttendance(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
            'notes' => 'nullable|string|max:500'
        ]);

        $studentIds = $request->student_ids;
        $date = $request->date;
        $status = $request->status;
        $notes = $request->notes;

        $updatedCount = 0;
        $errors = [];

        DB::transaction(function () use ($studentIds, $date, $status, $notes, &$updatedCount, &$errors) {
            foreach ($studentIds as $studentId) {
                try {
                    $student = Student::findOrFail($studentId);

                    // Update or create attendance log
                    $attendanceLog = AttendanceLog::updateOrCreate([
                        'student_id' => $studentId,
                        'attendance_date' => $date,
                    ], [
                        'teacher_id' => null, // Guru piket doesn't have teacher relation
                        'status' => $status,
                        'notes' => $notes,
                        'scan_time' => now(),
                        'location' => 'Bulk Update by Guru Piket',
                        'qr_code' => $student->qrAttendance->qr_code ?? null,
                    ]);

                    $updatedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Error updating student ID {$studentId}: " . $e->getMessage();
                }
            }
        });

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => 'Some updates failed',
                'updated_count' => $updatedCount,
                'errors' => $errors
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully updated attendance for {$updatedCount} students",
            'updated_count' => $updatedCount,
            'data' => [
                'date' => $date,
                'status' => $status,
                'notes' => $notes
            ]
        ]);
    }

    /**
     * Export attendance data to Excel
     */
    public function export(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $classId = $request->get('class');

        // Get attendance data based on filters
        $query = AttendanceLog::with(['student.class'])
            ->whereDate('attendance_date', $date);

        if ($classId && $classId !== 'all') {
            $query->whereHas('student', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        $attendanceData = $query->orderBy('scan_time')->get();

        $filters = [
            'date' => $date,
            'class' => $classId
        ];

        return Excel::download(new AttendanceExport($attendanceData, $filters), 'attendance_' . $date . '.xlsx');
    }

    /**
     * View document in browser
     */
    public function viewDocument($logId)
    {
        $log = AttendanceLog::findOrFail($logId);

        if (!$log->document_path) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        $path = storage_path('app/public/' . $log->document_path);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file($path);
    }

    /**
     * Download document
     */
    public function downloadDocument($logId)
    {
        $log = AttendanceLog::findOrFail($logId);

        if (!$log->document_path) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        return response()->download(storage_path('app/public/' . $log->document_path));
    }

    /**
     * Update PKL attendance status
     */
    public function updatePklAttendance(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,sakit,izin,alpha',
            'check_out_time' => 'nullable|date_format:H:i',
            'log_activity' => 'nullable|string|max:1000',
            'sick_note' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' // Max 5MB
        ]);

        try {
            $log = \App\Models\PklAttendanceLog::findOrFail($id);

            $updateData = [
                'status' => $request->status
            ];

            // Update check_out_time jika ada
            if ($request->check_out_time) {
                $checkOutTime = \Carbon\Carbon::createFromFormat('H:i', $request->check_out_time);
                $updateData['check_out_time'] = $checkOutTime;
            }

            // Update log_activity jika ada
            if ($request->log_activity) {
                $updateData['log_activity'] = $request->log_activity;
            }

            // Handle sick note upload jika status sakit
            if ($request->status === 'sakit' && $request->hasFile('sick_note')) {
                $file = $request->file('sick_note');
                $fileName = 'sick-note-' . $log->id . '-' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pkl-sick-notes', $fileName, 'public');
                $updateData['sick_note_path'] = $path;
            }

            $log->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Attendance berhasil diperbarui',
                'status' => $request->status,
                'status_text' => $log->getStatusTextAttribute()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update PKL attendance: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui attendance: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get PKL attendance details for modal (for AJAX request in submission detail page)
     */
    public function showPklDetail($id)
    {
        try {
            $log = \App\Models\PklAttendanceLog::with([
                'student.student.class',
                'pklRegistration.tempatPkl'
            ])->findOrFail($id);

            $user = $log->student; // This is User model
            $student = $user->student; // This is Student model
            $pkl = $log->pklRegistration->tempatPkl;

            return response()->json([
                'student' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'nis' => $student ? $student->nis : 'N/A',
                    'email' => $user->email,
                    'class' => $student && $student->class ? $student->class->name : 'N/A',
                    'major' => $student ? ($student->major ?? 'N/A') : 'N/A',
                    'phone' => $user->phone ?? 'N/A',
                ],
                'pkl' => [
                    'company_name' => $pkl->nama_tempat ?? 'N/A',
                    'start_date' => $log->pklRegistration->tanggal_mulai ?
                        \Carbon\Carbon::parse($log->pklRegistration->tanggal_mulai)->format('d/m/Y') : 'N/A',
                    'end_date' => $log->pklRegistration->tanggal_selesai ?
                        \Carbon\Carbon::parse($log->pklRegistration->tanggal_selesai)->format('d/m/Y') : 'N/A',
                    'address' => $pkl->alamat ?? 'N/A',
                ],
                'log' => [
                    'scan_date' => $log->scan_date ? $log->scan_date->format('d/m/Y') : '-',
                    'scan_time' => $log->scan_time ? $log->scan_time->format('H:i:s') : '-',
                    'check_out_time' => $log->check_out_time ? $log->check_out_time->format('H:i:s') : '-',
                    'status' => $log->status,
                    'status_text' => $log->getStatusTextAttribute(),
                    'log_activity' => $log->log_activity ?? null,
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in showPklDetail: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get PKL attendance details for modal (old method for backward compatibility)
     */
    public function getPklAttendanceDetails($id)
    {
        $log = \App\Models\PklAttendanceLog::with([
            'student',
            'pklRegistration.tempatPkl'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $log->id,
                'student_name' => $log->student->name,
                'student_nis' => $log->student->nis,
                'student_email' => $log->student->email,
                'company_name' => $log->pklRegistration->tempatPkl->nama_tempat ?? 'N/A',
                'company_city' => $log->pklRegistration->tempatPkl->kota ?? '',
                'company_address' => $log->pklRegistration->tempatPkl->alamat ?? '',
                'scan_date' => $log->scan_date ? $log->scan_date->format('d/m/Y') : '-',
                'scan_time' => $log->scan_time ? $log->scan_time->format('H:i:s') : '-',
                'location' => $log->location ?: 'Tidak diketahui',
                'ip_address' => $log->ip_address ?: 'Tidak diketahui',
                'user_agent' => $log->user_agent ?: 'Tidak diketahui',
                'status' => $log->status,
                'status_text' => $log->getStatusTextAttribute(),
                'qr_code' => $log->qr_code,
                'created_at' => $log->created_at->format('d/m/Y H:i:s'),
                'updated_at' => $log->updated_at->format('d/m/Y H:i:s'),
            ]
        ]);
    }

    /**
     * Show PKL attendance log details (for edit modal form)
     */
    public function show($id)
    {
        try {
            $log = \App\Models\PklAttendanceLog::with(['student'])->findOrFail($id);

            return response()->json([
                'id' => $log->id,
                'student_name' => $log->student->name,
                'status' => $log->status,
                'status_text' => $log->getStatusTextAttribute(),
                'scan_date' => $log->scan_date ? $log->scan_date->format('d/m/Y') : '-',
                'scan_time' => $log->scan_time ? $log->scan_time->format('H:i:s') : '-',
                'check_out_time' => $log->check_out_time ? $log->check_out_time->format('H:i:s') : '',
                'log_activity' => $log->log_activity ?? '',
                'sick_note_path' => $log->sick_note_path ?? '',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load attendance record'
            ], 404);
        }
    }

    /**
     * Get PKL registration data (for creating new attendance)
     */
    public function getRegistrationData($registrationId)
    {
        try {
            $registration = \App\Models\PklRegistration::with(['student', 'tempatPkl'])
                ->findOrFail($registrationId);

            return response()->json([
                'success' => true,
                'student_name' => $registration->student->name,
                'company_name' => $registration->tempatPkl->nama_tempat ?? 'N/A',
                'student_id' => $registration->student_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get registration data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load registration data'
            ], 404);
        }
    }

    /**
     * Create new PKL attendance log
     */
    public function createPklAttendance($registrationId, Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,sakit,izin,alpha',
            'scan_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'log_activity' => 'nullable|string|max:1000',
            'sick_note' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' // Max 5MB
        ]);

        try {
            $registration = \App\Models\PklRegistration::with(['student'])
                ->findOrFail($registrationId);

            // Check if attendance already exists for today
            $today = now()->format('Y-m-d');
            $existingLog = \App\Models\PklAttendanceLog::where('pkl_registration_id', $registrationId)
                ->whereDate('scan_date', $today)
                ->first();

            if ($existingLog) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance for today already exists'
                ], 400);
            }

            // Create new attendance log
            $qrCode = 'GP-' . strtoupper(uniqid()) . '-' . $registration->student_id;

            $createData = [
                'pkl_registration_id' => $registrationId,
                'student_id' => $registration->student_id,
                'qr_code' => $qrCode,
                'scan_date' => now(),
                'status' => $request->status,
                'ip_address' => $request->ip(),
                'location' => 'Created by Guru Piket',
            ];

            // Set scan_time if provided, otherwise use current time
            if ($request->scan_time) {
                $scanTime = \Carbon\Carbon::createFromFormat('H:i', $request->scan_time);
                $createData['scan_time'] = $scanTime;
            } else {
                $createData['scan_time'] = now();
            }

            // Set check_out_time if provided
            if ($request->check_out_time) {
                $checkOutTime = \Carbon\Carbon::createFromFormat('H:i', $request->check_out_time);
                $createData['check_out_time'] = $checkOutTime;
            }

            // Set log_activity if provided
            if ($request->log_activity) {
                $createData['log_activity'] = $request->log_activity;
            }

            // Handle sick note upload jika status sakit
            if ($request->status === 'sakit' && $request->hasFile('sick_note')) {
                $file = $request->file('sick_note');
                $fileName = 'sick-note-' . uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pkl-sick-notes', $fileName, 'public');
                $createData['sick_note_path'] = $path;
            }

            $log = \App\Models\PklAttendanceLog::create($createData);

            return response()->json([
                'success' => true,
                'message' => 'Attendance created successfully',
                'log' => $log
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create PKL attendance: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create attendance: ' . $e->getMessage()
            ], 500);
        }
    }
}
