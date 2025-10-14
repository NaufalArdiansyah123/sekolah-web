<?php

namespace App\Http\Controllers\GuruPiket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AttendanceSubmission;
use App\Models\User;
use App\Models\Student;
use App\Models\AttendanceLog;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     */
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

        // Get today's attendance statistics
        $todayAttendance = [
            'total_scanned' => 156,
            'hadir' => 142,
            'terlambat' => 14,
            'alpha' => 0
        ];

        return view('guru-piket.attendance.qr-scanner', compact(
            'pageTitle',
            'breadcrumb',
            'todayAttendance'
        ));
    }

    /**
     * Show students attendance page
     */
    public function students(Request $request)
    {
        $pageTitle = 'Absensi Siswa';
        $breadcrumb = 'Absensi Siswa';

        // Get filter parameters
        $date = $request->get('date', date('Y-m-d'));
        $class = $request->get('class');
        $status = $request->get('status');
        $search = $request->get('search');

        // Mock data for students attendance
        $students = collect([
            [
                'id' => 1,
                'name' => 'Ahmad Fauzi',
                'nis' => '2021001',
                'class' => 'XII IPA 1',
                'status' => 'hadir',
                'time' => '07:15',
                'note' => 'Scan QR Code'
            ],
            [
                'id' => 2,
                'name' => 'Siti Nurhaliza',
                'nis' => '2021002',
                'class' => 'XII IPA 2',
                'status' => 'terlambat',
                'time' => '07:25',
                'note' => 'Scan QR Code'
            ],
            [
                'id' => 3,
                'name' => 'Budi Santoso',
                'nis' => '2021003',
                'class' => 'XII IPS 1',
                'status' => 'izin',
                'time' => '-',
                'note' => 'Keperluan keluarga'
            ],
            [
                'id' => 4,
                'name' => 'Dewi Permata',
                'nis' => '2021004',
                'class' => 'XII IPS 2',
                'status' => 'alpha',
                'time' => '-',
                'note' => 'Tidak ada keterangan'
            ]
        ]);

        // Apply filters
        if ($class) {
            $students = $students->where('class', $class);
        }
        if ($status) {
            $students = $students->where('status', $status);
        }
        if ($search) {
            $students = $students->filter(function ($student) use ($search) {
                return stripos($student['name'], $search) !== false || 
                       stripos($student['nis'], $search) !== false;
            });
        }

        // Statistics
        $statistics = [
            'total_students' => 450,
            'hadir' => 398,
            'terlambat' => 28,
            'izin_sakit' => 15,
            'alpha' => 9
        ];

        return view('guru-piket.attendance.students', compact(
            'pageTitle',
            'breadcrumb',
            'students',
            'statistics',
            'date',
            'class',
            'status',
            'search'
        ));
    }

    /**
     * Show teachers attendance page
     */
    public function teachers()
    {
        $pageTitle = 'Absensi Guru';
        $breadcrumb = 'Absensi Guru';

        // Mock data for teachers
        $teachers = collect([
            [
                'id' => 1,
                'name' => 'Dr. Rahman, M.Pd',
                'subject' => 'Matematika',
                'status' => 'hadir',
                'time_in' => '06:45',
                'teaching_hours' => 6,
                'schedule' => [
                    ['class' => 'XII IPA 1', 'subject' => 'Matematika', 'time' => '07:00-08:30'],
                    ['class' => 'XII IPA 2', 'subject' => 'Matematika', 'time' => '08:30-10:00']
                ]
            ],
            [
                'id' => 2,
                'name' => 'Sari Andini, S.Pd',
                'subject' => 'Bahasa Indonesia',
                'status' => 'terlambat',
                'time_in' => '07:15',
                'teaching_hours' => 5,
                'schedule' => [
                    ['class' => 'XII IPS 1', 'subject' => 'Bahasa Indonesia', 'time' => '08:30-10:00'],
                    ['class' => 'XII IPS 2', 'subject' => 'Bahasa Indonesia', 'time' => '10:15-11:45']
                ]
            ],
            [
                'id' => 3,
                'name' => 'Budi Prasetyo, S.Si',
                'subject' => 'Fisika',
                'status' => 'izin',
                'time_in' => null,
                'teaching_hours' => 4,
                'note' => 'Sakit',
                'schedule' => [
                    ['class' => 'XII IPA 1', 'subject' => 'Fisika (Diganti)', 'time' => '10:15-11:45'],
                    ['class' => 'XII IPA 2', 'subject' => 'Fisika (Diganti)', 'time' => '13:00-14:30']
                ]
            ]
        ]);

        // Statistics
        $statistics = [
            'total_teachers' => 45,
            'hadir' => 42,
            'terlambat' => 1,
            'izin' => 2,
            'alpha' => 0
        ];

        return view('guru-piket.attendance.teachers', compact(
            'pageTitle',
            'breadcrumb',
            'teachers',
            'statistics'
        ));
    }

    /**
     * Store attendance data
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'note' => 'nullable|string|max:255'
        ]);

        // Here you would typically save to database
        // For now, we'll just return success response

        return response()->json([
            'success' => true,
            'message' => 'Data absensi berhasil disimpan'
        ]);
    }

    /**
     * Update attendance data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
            'time' => 'nullable|string',
            'note' => 'nullable|string|max:255'
        ]);

        // Here you would typically update database record
        // For now, we'll just return success response

        return response()->json([
            'success' => true,
            'message' => 'Data absensi berhasil diperbarui'
        ]);
    }

    /**
     * Delete attendance record
     */
    public function destroy($id)
    {
        // Here you would typically delete from database
        // For now, we'll just return success response

        return response()->json([
            'success' => true,
            'message' => 'Data absensi berhasil dihapus'
        ]);
    }

    /**
     * Process QR code scan
     */
    public function processQrScan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrCode = $request->qr_code;

        // Here you would typically:
        // 1. Decode QR code to get student ID
        // 2. Validate student exists
        // 3. Check if already scanned today
        // 4. Determine status (hadir/terlambat based on time)
        // 5. Save attendance record

        // Mock response
        $mockStudents = [
            'STD001' => ['name' => 'Ahmad Fauzi', 'nis' => '2021001', 'class' => 'XII IPA 1'],
            'STD002' => ['name' => 'Siti Nurhaliza', 'nis' => '2021002', 'class' => 'XII IPA 2'],
            'STD003' => ['name' => 'Budi Santoso', 'nis' => '2021003', 'class' => 'XII IPS 1']
        ];

        if (isset($mockStudents[$qrCode])) {
            $student = $mockStudents[$qrCode];
            $currentTime = now()->format('H:i');
            $status = $currentTime <= '07:00' ? 'hadir' : 'terlambat';

            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dipindai',
                'data' => [
                    'student' => $student,
                    'status' => $status,
                    'time' => $currentTime
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'QR Code tidak valid'
        ], 400);
    }

    /**
     * Export attendance data
     */
    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:pdf,excel,csv',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'class' => 'nullable|string',
            'type' => 'required|in:students,teachers'
        ]);

        // Here you would typically:
        // 1. Query attendance data based on filters
        // 2. Generate file in requested format
        // 3. Return download response

        // For now, return success response
        return response()->json([
            'success' => true,
            'message' => 'Export berhasil diproses',
            'download_url' => '#'
        ]);
    }
    
    /**
     * Get pending attendance submissions from teachers
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
        
        if ($status) {
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
     * Get submission detail for review
     */
    public function getSubmissionDetail($id)
    {
        $submission = AttendanceSubmission::with(['teacher', 'class', 'confirmer'])
                                        ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'submission' => $submission
        ]);
    }
    
    /**
     * Confirm attendance submission
     */
    public function confirmSubmission(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:confirm,reject',
            'notes' => 'nullable|string|max:500'
        ]);
        
        try {
            DB::beginTransaction();
            
            $submission = AttendanceSubmission::findOrFail($id);
            
            if ($submission->status !== AttendanceSubmission::STATUS_PENDING) {
                return response()->json([
                    'success' => false,
                    'message' => 'Submission sudah diproses sebelumnya'
                ], 400);
            }
            
            if ($request->action === 'confirm') {
                // Confirm the submission and create/update attendance logs
                $this->processConfirmedSubmission($submission);
                
                $submission->update([
                    'status' => AttendanceSubmission::STATUS_CONFIRMED,
                    'confirmed_at' => now(),
                    'confirmed_by' => auth()->id(),
                    'notes' => $submission->notes . ($request->notes ? '\n\nKonfirmasi: ' . $request->notes : '')
                ]);
                
                $message = 'Absensi berhasil dikonfirmasi dan data telah disimpan';
            } else {
                // Reject the submission
                $submission->update([
                    'status' => AttendanceSubmission::STATUS_REJECTED,
                    'confirmed_at' => now(),
                    'confirmed_by' => auth()->id(),
                    'notes' => $submission->notes . ($request->notes ? '\n\nPenolakan: ' . $request->notes : '')
                ]);
                
                $message = 'Absensi ditolak';
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'submission' => [
                    'id' => $submission->id,
                    'status' => $submission->status_text,
                    'confirmed_at' => $submission->confirmed_at->format('d/m/Y H:i'),
                    'confirmed_by' => auth()->user()->name
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            \Log::error('Error confirming attendance submission:', [
                'error' => $e->getMessage(),
                'submission_id' => $id,
                'guru_piket_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses konfirmasi: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Process confirmed submission by creating attendance logs
     */
    private function processConfirmedSubmission($submission)
    {
        $attendanceData = $submission->attendance_data;
        
        foreach ($attendanceData as $studentData) {
            // Create or update attendance log
            AttendanceLog::updateOrCreate([
                'student_id' => $studentData['student_id'],
                'attendance_date' => $submission->submission_date,
            ], [
                'status' => $studentData['status'],
                'scan_time' => $studentData['scan_time'] ? 
                    Carbon::parse($submission->submission_date . ' ' . $studentData['scan_time']) : 
                    now(),
                'location' => 'Confirmed by Guru Piket from Teacher Submission',
                'notes' => $studentData['notes'] ?? 'Confirmed from teacher: ' . $submission->teacher->name,
                'qr_code' => null // Since this is manual confirmation
            ]);
        }
    }
    
    /**
     * Show submissions management page
     */
    public function submissions()
    {
        $pageTitle = 'Konfirmasi Absensi Guru';
        $breadcrumb = 'Konfirmasi Absensi';
        
        // Get pending submissions count
        $pendingCount = AttendanceSubmission::where('status', AttendanceSubmission::STATUS_PENDING)->count();
        
        // Get today's submissions
        $todaySubmissions = AttendanceSubmission::with(['teacher', 'class'])
                                              ->whereDate('submission_date', Carbon::today())
                                              ->orderBy('submitted_at', 'desc')
                                              ->limit(5)
                                              ->get();
        
        // Get statistics
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
            'pendingCount',
            'todaySubmissions',
            'statistics'
        ));
    }
}