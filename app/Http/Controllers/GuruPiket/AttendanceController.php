<?php

namespace App\Http\Controllers\GuruPiket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\AttendanceSubmission;
use App\Models\User;
use App\Models\Student;
use App\Models\AttendanceLog;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:guru_piket');
    }

    /**
     * Show QR Scanner page
     */
    public function qrScanner()
    {
        $pageTitle = 'QR Scanner Absensi';
        $breadcrumb = 'QR Scanner';

        $todayAttendance = [
            'total_scanned' => AttendanceLog::whereDate('attendance_date', today())->count(),
            'hadir' => AttendanceLog::whereDate('attendance_date', today())->where('status', 'hadir')->count(),
            'terlambat' => AttendanceLog::whereDate('attendance_date', today())->where('status', 'terlambat')->count(),
            'alpha' => AttendanceLog::whereDate('attendance_date', today())->where('status', 'alpha')->count()
        ];

        return view('guru-piket.attendance.qr-scanner', compact(
            'pageTitle',
            'breadcrumb',
            'todayAttendance'
        ));
    }

    /**
     * Get pending submissions
     */
    public function getPendingSubmissions(Request $request)
    {
        $date = $request->get('date');
        $status = $request->get('status', 'pending');
        
        $query = AttendanceSubmission::with(['teacher', 'class'])
                                   ->orderBy('submitted_at', 'desc');
        
        if ($date) {
            $query->whereDate('submission_date', $date);
        }
        
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        $submissions = $query->paginate(10);
        
        return response()->json([
            'success' => true,
            'submissions' => $submissions->items(),
            'pagination' => [
                'current_page' => $submissions->currentPage(),
                'last_page' => $submissions->lastPage(),
                'per_page' => $submissions->perPage(),
                'total' => $submissions->total()
            ]
        ]);
    }
    
    /**
     * Get submission detail
     */
    public function getSubmissionDetail($id)
    {
        try {
            \Log::info('Getting submission detail for ID: ' . $id);
            
            $submission = AttendanceSubmission::with(['teacher', 'class', 'confirmer'])
                                            ->findOrFail($id);
            
            \Log::info('Submission found:', [
                'id' => $submission->id,
                'status' => $submission->status,
                'attendance_data_count' => count($submission->attendance_data ?? [])
            ]);
            
            return response()->json([
                'success' => true,
                'submission' => $submission
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Submission not found:', ['id' => $id]);
            
            return response()->json([
                'success' => false,
                'message' => 'Submission tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            \Log::error('Error getting submission detail:', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update individual student attendance
     */
    public function updateStudent(Request $request, $submissionId)
    {
        \Log::info('Update student request:', [
            'submission_id' => $submissionId,
            'student_id' => $request->get('student_id'),
            'status' => $request->get('status')
        ]);
        
        try {
            $request->validate([
                'student_id' => 'required',
                'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
                'time' => 'nullable|string',
                'notes' => 'nullable|string|max:500',
                'attachment' => 'nullable|image|max:2048'
            ]);
            
            DB::beginTransaction();
            
            $submission = AttendanceSubmission::findOrFail($submissionId);
            
            if ($submission->status !== AttendanceSubmission::STATUS_PENDING) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya submission pending yang dapat diubah'
                ], 400);
            }
            
            $studentId = $request->get('student_id');
            $status = $request->get('status');
            $time = $request->get('time');
            $notes = $request->get('notes');
            
            // Handle file upload
            $attachmentPath = null;
            if ($request->hasFile('attachment') && in_array($status, ['sakit', 'izin'])) {
                try {
                    $file = $request->file('attachment');
                    $fileName = 'surat_' . $studentId . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $attachmentPath = $file->storeAs('attendance/attachments', $fileName, 'public');
                    \Log::info('File uploaded:', ['path' => $attachmentPath]);
                } catch (\Exception $e) {
                    \Log::error('File upload error:', ['error' => $e->getMessage()]);
                }
            }
            
            // Update attendance data
            $attendanceData = $submission->attendance_data ?? [];
            $studentFound = false;
            
            foreach ($attendanceData as $index => $student) {
                $currentStudentId = $student['student_id'] ?? $student['id'] ?? null;
                
                if ($currentStudentId == $studentId) {
                    // Delete old attachment if exists
                    if (isset($student['attachment']) && $attachmentPath) {
                        $oldPath = str_replace('/storage/', '', $student['attachment']);
                        if (Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    }
                    
                    $attendanceData[$index]['status'] = $status;
                    $attendanceData[$index]['scan_time'] = $time;
                    $attendanceData[$index]['notes'] = $notes;
                    
                    if ($attachmentPath) {
                        $attendanceData[$index]['attachment'] = '/storage/' . $attachmentPath;
                    }
                    
                    $studentFound = true;
                    break;
                }
            }
            
            if (!$studentFound) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak ditemukan dalam submission'
                ], 404);
            }
            
            // Recalculate statistics
            $presentCount = 0;
            $lateCount = 0;
            $absentCount = 0;
            
            foreach ($attendanceData as $student) {
                switch ($student['status']) {
                    case 'hadir':
                        $presentCount++;
                        break;
                    case 'terlambat':
                        $presentCount++;
                        $lateCount++;
                        break;
                    case 'alpha':
                    case 'izin':
                    case 'sakit':
                        $absentCount++;
                        break;
                }
            }
            
            // Update submission
            $submission->update([
                'attendance_data' => $attendanceData,
                'present_count' => $presentCount,
                'late_count' => $lateCount,
                'absent_count' => $absentCount,
                'attendance_percentage' => $submission->total_students > 0 
                    ? round(($presentCount / $submission->total_students) * 100, 1) 
                    : 0
            ]);
            
            DB::commit();
            
            \Log::info('Student attendance updated successfully:', [
                'submission_id' => $submissionId,
                'student_id' => $studentId,
                'new_status' => $status
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diperbarui',
                'student' => [
                    'student_id' => $studentId,
                    'status' => $status,
                    'time' => $time,
                    'notes' => $notes,
                    'attachment' => $attachmentPath ? '/storage/' . $attachmentPath : null
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', \Illuminate\Support\Arr::flatten($e->errors()))
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            \Log::error('Error updating student attendance:', [
                'submission_id' => $submissionId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Confirm attendance submission
     */
    public function confirmSubmission(Request $request, $id)
    {
        \Log::info('Confirm submission request:', [
            'submission_id' => $id,
            'action' => $request->get('action')
        ]);
        
        try {
            $request->validate([
                'action' => 'required|in:confirm,reject',
                'notes' => 'nullable|string|max:500'
            ]);
            
            DB::beginTransaction();
            
            $submission = AttendanceSubmission::findOrFail($id);
            
            if ($submission->status !== AttendanceSubmission::STATUS_PENDING) {
                return response()->json([
                    'success' => false,
                    'message' => 'Submission sudah diproses sebelumnya'
                ], 400);
            }
            
            $action = $request->get('action');
            $notes = $request->get('notes', '');
            
            if ($action === 'confirm') {
                // Create attendance logs
                $this->processConfirmedSubmission($submission);
                
                $updateData = [
                    'status' => AttendanceSubmission::STATUS_CONFIRMED,
                    'confirmed_at' => now(),
                    'confirmed_by' => auth()->id(),
                    'guru_piket_id' => auth()->id()
                ];
                
                if ($notes) {
                    $existingNotes = $submission->notes ?? '';
                    $updateData['notes'] = $existingNotes . ($existingNotes ? "\n\n" : '') . 'Konfirmasi: ' . $notes;
                }
                
                $submission->update($updateData);

                // Create admin notification
                $this->createAdminNotification($submission, 'confirm', $notes);
                
                $message = 'Absensi berhasil dikonfirmasi dan data telah disimpan';
            } else {
                $updateData = [
                    'status' => AttendanceSubmission::STATUS_REJECTED,
                    'confirmed_at' => now(),
                    'confirmed_by' => auth()->id(),
                    'guru_piket_id' => auth()->id()
                ];
                
                if ($notes) {
                    $existingNotes = $submission->notes ?? '';
                    $updateData['notes'] = $existingNotes . ($existingNotes ? "\n\n" : '') . 'Penolakan: ' . $notes;
                }
                
                $submission->update($updateData);

                // Create admin notification
                $this->createAdminNotification($submission, 'reject', $notes);
                
                $message = 'Absensi ditolak';
            }
            
            $submission = $submission->fresh();
            
            DB::commit();
            
            \Log::info('Submission confirmation completed:', [
                'submission_id' => $id,
                'new_status' => $submission->status,
                'action' => $action
            ]);
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'submission' => [
                    'id' => $submission->id,
                    'status' => $submission->status_text ?? $submission->status,
                    'confirmed_at' => $submission->confirmed_at ? $submission->confirmed_at->format('d/m/Y H:i') : null,
                    'confirmed_by' => auth()->user()->name
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', \Illuminate\Support\Arr::flatten($e->errors()))
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            \Log::error('Error confirming submission:', [
                'submission_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Process confirmed submission by creating attendance logs
     */
    private function processConfirmedSubmission($submission)
    {
        \Log::info('Processing confirmed submission:', [
            'submission_id' => $submission->id,
            'attendance_data_count' => count($submission->attendance_data ?? [])
        ]);

        $attendanceData = $submission->attendance_data;

        if (!is_array($attendanceData) || empty($attendanceData)) {
            \Log::warning('No attendance data found for submission: ' . $submission->id);
            return;
        }

        $successCount = 0;
        $errorCount = 0;

        foreach ($attendanceData as $index => $studentData) {
            try {
                // Get student_id
                $studentId = $studentData['student_id'] ?? $studentData['id'] ?? null;
                
                if (!$studentId || !isset($studentData['status'])) {
                    \Log::warning('Invalid student data at index ' . $index, $studentData);
                    $errorCount++;
                    continue;
                }

                // Prepare scan time
                $scanTime = now();
                if (isset($studentData['scan_time']) && $studentData['scan_time']) {
                    try {
                        $scanTime = Carbon::parse($submission->submission_date . ' ' . $studentData['scan_time']);
                    } catch (\Exception $e) {
                        \Log::warning('Invalid scan time format:', [
                            'submission_id' => $submission->id,
                            'student_index' => $index,
                            'scan_time' => $studentData['scan_time']
                        ]);
                    }
                }

                // Create or update attendance log
                $attendanceLog = AttendanceLog::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'attendance_date' => $submission->submission_date,
                    ],
                    [
                        'status' => $studentData['status'],
                        'scan_time' => $scanTime,
                        'location' => 'Confirmed by Guru Piket from Teacher Submission',
                        'notes' => $studentData['notes'] ?? 'Confirmed from teacher: ' . ($submission->teacher->name ?? 'Unknown'),
                        'qr_code' => null,
                        'confirmed_by' => auth()->id(),
                        'confirmed_at' => now(),
                    ]
                );

                \Log::info('Attendance log created/updated:', [
                    'log_id' => $attendanceLog->id,
                    'student_id' => $studentId,
                    'status' => $studentData['status']
                ]);

                $successCount++;

            } catch (\Exception $e) {
                \Log::error('Error creating attendance log:', [
                    'submission_id' => $submission->id,
                    'student_index' => $index,
                    'error' => $e->getMessage()
                ]);
                $errorCount++;
            }
        }

        \Log::info('Attendance logs processing completed:', [
            'submission_id' => $submission->id,
            'success_count' => $successCount,
            'error_count' => $errorCount
        ]);

        if ($errorCount > 0 && $successCount === 0) {
            throw new \Exception("Failed to process all attendance logs");
        }
    }
    
    /**
     * Create admin notification
     */
    private function createAdminNotification($submission, $action, $notes = '')
    {
        try {
            $isConfirm = $action === 'confirm';
            
            $notificationData = [
                'type' => 'attendance',
                'action' => $action,
                'title' => $isConfirm ? 'Absensi Kelas Dikonfirmasi' : 'Absensi Kelas Ditolak',
                'message' => sprintf(
                    'Absensi %s tanggal %s %s oleh %s.',
                    $submission->class->name ?? 'Kelas',
                    Carbon::parse($submission->submission_date)->format('d/m/Y'),
                    $isConfirm ? 'dikonfirmasi' : 'ditolak',
                    auth()->user()->name ?? 'Guru Piket'
                ),
                'user_id' => auth()->id(),
                'target_id' => $submission->id,
                'target_type' => get_class($submission),
                'data' => [
                    'submission_id' => $submission->id,
                    'class' => $submission->class->name ?? null,
                    'teacher' => $submission->teacher->name ?? null,
                    'date' => $submission->submission_date ? Carbon::parse($submission->submission_date)->format('Y-m-d') : null,
                    'present' => $submission->present_count,
                    'late' => $submission->late_count,
                    'absent' => $submission->absent_count,
                ],
                'is_read' => false,
            ];
            
            if ($isConfirm) {
                $notificationData['data']['percentage'] = $submission->attendance_percentage ?? null;
                $notificationData['data']['link'] = null;
                if (\Illuminate\Support\Facades\Route::has('admin.qr-attendance.logs')) {
                    $notificationData['data']['link'] = route('admin.qr-attendance.logs', [
                        'date' => Carbon::parse($submission->submission_date)->format('Y-m-d')
                    ]);
                }
            } else {
                $notificationData['data']['notes'] = $notes;
            }
            
            \App\Models\AdminNotification::create($notificationData);
            
        } catch (\Throwable $e) {
            \Log::warning('Failed to create AdminNotification', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Show submissions management page
     */
    public function submissions(Request $request)
    {
        try {
            $pageTitle = 'Konfirmasi Absensi Guru';
            $breadcrumb = 'Konfirmasi Absensi';
            
            $date = $request->get('date', Carbon::today()->format('Y-m-d'));
            $status = $request->get('status', 'all');
            
            $query = AttendanceSubmission::with(['teacher', 'class', 'confirmer'])
                                       ->orderBy('submitted_at', 'desc');
            
            if ($date) {
                $query->whereDate('submission_date', $date);
            }
            
            if ($status && $status !== 'all') {
                $query->where('status', $status);
            }
            
            $submissions = $query->paginate(20);
            
            $pendingCount = AttendanceSubmission::where('status', AttendanceSubmission::STATUS_PENDING)->count();
            
            $todaySubmissions = AttendanceSubmission::with(['teacher', 'class'])
                                                  ->whereDate('submission_date', Carbon::today())
                                                  ->orderBy('submitted_at', 'desc')
                                                  ->limit(5)
                                                  ->get();
            
            $statistics = [
                'pending' => AttendanceSubmission::where('status', AttendanceSubmission::STATUS_PENDING)->count(),
                'confirmed_today' => AttendanceSubmission::where('status', AttendanceSubmission::STATUS_CONFIRMED)
                                                       ->whereDate('confirmed_at', Carbon::today())
                                                       ->count(),
                'total_today' => AttendanceSubmission::whereDate('submission_date', Carbon::today())->count(),
                'teachers_submitted' => AttendanceSubmission::whereDate('submission_date', Carbon::today())
                                                          ->distinct('teacher_id')
                                                          ->count()
            ];
            
            return view('guru-piket.attendance.submissions', compact(
                'pageTitle',
                'breadcrumb',
                'submissions',
                'pendingCount',
                'todaySubmissions',
                'statistics',
                'date',
                'status'
            ));
            
        } catch (\Exception $e) {
            \Log::error('Error loading submissions page:', [
                'error' => $e->getMessage()
            ]);
            
            return view('guru-piket.attendance.submissions', [
                'pageTitle' => 'Konfirmasi Absensi Guru',
                'breadcrumb' => 'Konfirmasi Absensi',
                'submissions' => collect([]),
                'pendingCount' => 0,
                'todaySubmissions' => collect([]),
                'statistics' => [
                    'pending' => 0,
                    'confirmed_today' => 0,
                    'total_today' => 0,
                    'teachers_submitted' => 0
                ],
                'date' => Carbon::today()->format('Y-m-d'),
                'status' => 'all',
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}