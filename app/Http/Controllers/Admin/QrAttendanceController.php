<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\QrAttendance;
use App\Models\AttendanceLog;
use App\Services\QrCodeService;
use App\Services\CsvExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class QrAttendanceController extends Controller
{
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

    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Display QR attendance management
     */
    public function index(Request $request)
    {
        $query = Student::with([
            'qrAttendance',
            'class',
            'attendanceLogs' => function ($q) {
                $q->whereDate('attendance_date', today());
            }
        ]);

        // Filter by class
        if ($request->filled('class')) {
            $query->where('class_id', $request->class);
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $students = $query->paginate(20);

        // Get available classes
        $classes = \App\Models\Classes::where('is_active', true)
            ->orderBy('level')
            ->orderBy('program')
            ->orderBy('name')
            ->get();

        // Statistics
        $stats = [
            'total_students' => Student::count(),
            'students_with_qr' => QrAttendance::count(),
            'today_attendance' => AttendanceLog::whereDate('attendance_date', today())->count(),
            'present_today' => AttendanceLog::whereDate('attendance_date', today())
                ->where('status', 'hadir')
                ->count(),
        ];

        return view('admin.qr-attendance.index', compact('students', 'classes', 'stats'));
    }

    /**
     * Show consolidated attendance logs confirmed by Guru Piket
     */
    public function allAttendance(Request $request)
    {
        $start = $request->get('start', date('Y-m-01'));
        $end = $request->get('end', date('Y-m-d'));
        $status = $request->get('status');
        $classId = $request->get('class');
        $search = $request->get('search');

        $query = AttendanceLog::with(['student.class'])
            ->whereBetween('attendance_date', [$start, $end])
            ->orderBy('attendance_date', 'desc')
            ->orderBy('scan_time', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        if ($classId) {
            $query->whereHas('student', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        if ($search) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(25);

        // Classes for filter
        $classes = \App\Models\Classes::where('is_active', true)
            ->orderBy('level')
            ->orderBy('program')
            ->orderBy('name')
            ->get();

        // Summary counters
        $summary = [
            'total' => $logs->total(),
            'hadir' => AttendanceLog::whereBetween('attendance_date', [$start, $end])
                ->where('status', 'hadir')
                ->count(),
            'terlambat' => AttendanceLog::whereBetween('attendance_date', [$start, $end])
                ->where('status', 'terlambat')
                ->count(),
            'izin' => AttendanceLog::whereBetween('attendance_date', [$start, $end])
                ->where('status', 'izin')
                ->count(),
            'sakit' => AttendanceLog::whereBetween('attendance_date', [$start, $end])
                ->where('status', 'sakit')
                ->count(),
            'alpha' => AttendanceLog::whereBetween('attendance_date', [$start, $end])
                ->where('status', 'alpha')
                ->count(),
        ];

        return view('admin.qr-attendance.all-attendance', compact('logs', 'classes', 'summary'));
    }

    /**
     * Generate QR code for student
     */
    public function generateQr(Student $student)
    {
        try {
            $qrAttendance = $this->qrCodeService->generateQrCodeForStudent($student);

            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dibuat untuk ' . $student->name,
                'qr_image_url' => $qrAttendance->qr_image_url,
                'qr_code' => $qrAttendance->qr_code,
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating QR code', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Regenerate QR code for student
     */
    public function regenerateQr(Student $student)
    {
        try {
            $qrAttendance = $this->qrCodeService->regenerateQrCodeForStudent($student);

            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dibuat ulang untuk ' . $student->name,
                'qr_image_url' => $qrAttendance->qr_image_url,
                'qr_code' => $qrAttendance->qr_code,
            ]);
        } catch (\Exception $e) {
            Log::error('Error regenerating QR code', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat ulang QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate QR codes for multiple students
     */
    public function generateBulkQr(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        try {
            DB::beginTransaction();

            $results = $this->qrCodeService->generateQrCodesForMultipleStudents($request->student_ids);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dibuat untuk ' . count($results) . ' siswa',
                'generated_count' => count($results),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error generating bulk QR codes', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * View attendance logs grouped by class - CONFIRMED AND UNCONFIRMED
     */
    public function attendanceLogs(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $classId = $request->get('class_id');

        // Handle CSV export request
        if ($request->get('export') === 'csv') {
            return $this->exportConfirmedLogs($request);
        }

        // Get all classes with their students and ALL attendance data (confirmed and unconfirmed)
        $classes = \App\Models\Classes::where('is_active', true)
            ->with([
                'students' => function ($query) use ($date) {
                    $query->with([
                        'attendanceLogs' => function ($q) use ($date) {
                            $q->whereDate('attendance_date', $date);
                        }
                    ])
                        ->orderBy('name');
                }
            ])
            ->orderBy('level')
            ->orderBy('program')
            ->orderBy('name')
            ->get();

        // Filter classes by class_id
        if ($classId) {
            $classes = $classes->filter(function ($class) use ($classId) {
                return $class->id == $classId;
            });
        }

        // Process attendance data - BOTH CONFIRMED AND UNCONFIRMED STUDENTS
        $attendanceByClass = $classes->map(function ($class) use ($date) {
            $confirmedStudents = collect();
            $unconfirmedStudents = collect();

            $class->students->each(function ($student) use (&$confirmedStudents, &$unconfirmedStudents) {
                $attendanceLog = $student->attendanceLogs->first();

                if (!$attendanceLog) {
                    return;
                }

                $studentData = (object) [
                    'id' => $student->id,
                    'name' => $student->name,
                    'nis' => $student->nis,
                    'nisn' => $student->nisn,
                    'photo_url' => $student->photo_url,
                    'status' => $attendanceLog->status,
                    'scan_time' => $attendanceLog->scan_time,
                    'confirmed_by' => $attendanceLog->confirmed_by,
                    'confirmed_at' => $attendanceLog->confirmed_at,
                    'notes' => $attendanceLog->notes,
                    'document_path' => $attendanceLog->document_path,
                    'confirmedBy' => $attendanceLog->confirmedBy,
                    'log_id' => $attendanceLog->id,
                ];

                if ($attendanceLog->confirmed_by) {
                    $confirmedStudents->push($studentData);
                } else {
                    $unconfirmedStudents->push($studentData);
                }
            });

            return [
                'class' => $class,
                'confirmed_students' => $confirmedStudents,
                'unconfirmed_students' => $unconfirmedStudents,
                'confirmed_count' => $confirmedStudents->count(),
                'unconfirmed_count' => $unconfirmedStudents->count(),
                'total_count' => $confirmedStudents->count() + $unconfirmedStudents->count(),
            ];
        })->filter(function ($classData) {
            // Include classes with any attendance data (confirmed or unconfirmed)
            return $classData['total_count'] > 0;
        });

        // Calculate totals
        $totalPresent = $attendanceByClass->sum(function ($classData) {
            return $classData['confirmed_students']->where('status', 'hadir')->count() +
                $classData['unconfirmed_students']->where('status', 'hadir')->count();
        });

        $totalConfirmed = $attendanceByClass->sum(function ($classData) {
            return $classData['confirmed_count'];
        });

        $totalUnconfirmed = $attendanceByClass->sum(function ($classData) {
            return $classData['unconfirmed_count'];
        });

        // Get available classes for filter
        $filterClasses = \App\Models\Classes::where('is_active', true)
            ->orderBy('level')
            ->orderBy('program')
            ->orderBy('name')
            ->get();

        return view('admin.qr-attendance.logs', compact(
            'attendanceByClass',
            'totalPresent',
            'totalConfirmed',
            'totalUnconfirmed',
            'filterClasses',
            'date',
            'classId'
        ));
    }

    /**
     * Export attendance logs to CSV
     */
    public function exportLogs(Request $request)
    {
        try {
            Log::info('Export logs request started', $request->all());

            $filters = [
                'date' => $request->get('date', today()->format('Y-m-d')),
                'status' => $request->get('status'),
                'class' => $request->get('class')
            ];

            $query = AttendanceLog::with(['student.class'])
                ->orderBy('scan_time', 'desc');

            if ($filters['date']) {
                $query->whereDate('attendance_date', $filters['date']);
            }

            if ($filters['status']) {
                $query->where('status', $filters['status']);
            }

            if ($filters['class']) {
                $query->whereHas('student', function ($q) use ($filters) {
                    $q->where('class_id', $filters['class']);
                });
            }

            $logs = $query->get();

            Log::info('Export logs query executed', ['count' => $logs->count()]);

            // Generate filename
            $filename = 'log-absensi-qr-' . date('Y-m-d-His') . '.csv';

            // Generate CSV
            return $this->generateCsvResponse($logs, $filename);

        } catch (\Exception $e) {
            Log::error('Export logs failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Export confirmed attendance logs to CSV
     */
    public function exportConfirmedLogs(Request $request)
    {
        try {
            Log::info('Export confirmed logs request started', $request->all());

            $filters = [
                'date' => $request->get('date', date('Y-m-d')),
                'search' => $request->get('search')
            ];

            $query = AttendanceLog::with(['student.class', 'confirmedBy'])
                ->whereNotNull('confirmed_by')
                ->orderBy('attendance_date', 'desc')
                ->orderBy('scan_time', 'desc');

            if ($filters['date']) {
                $query->whereDate('attendance_date', $filters['date']);
            }

            if ($filters['search']) {
                $query->whereHas('student.class', function ($q) use ($filters) {
                    $q->where('name', 'like', "%{$filters['search']}%");
                });
            }

            $logs = $query->get();

            Log::info('Export confirmed logs query executed', ['count' => $logs->count()]);

            $filename = 'log-absensi-qr-dikonfirmasi-' . date('Y-m-d-His') . '.csv';

            return $this->generateCsvResponse($logs, $filename, true);

        } catch (\Exception $e) {
            Log::error('Export confirmed logs failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Generate CSV response
     */
    private function generateCsvResponse($logs, $filename, $includeConfirmer = false)
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($logs, $includeConfirmer) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            $headerRow = ['No', 'Tanggal', 'NIS', 'Nama', 'Kelas', 'Status', 'Waktu Scan', 'Catatan'];
            if ($includeConfirmer) {
                $headerRow[] = 'Dikonfirmasi Oleh';
                $headerRow[] = 'Waktu Konfirmasi';
            }
            fputcsv($file, $headerRow);

            // Data
            foreach ($logs as $index => $log) {
                $row = [
                    $index + 1,
                    Carbon::parse($log->attendance_date)->format('d/m/Y'),
                    $log->student->nis ?? '-',
                    $log->student->name ?? '-',
                    $log->student->class->name ?? '-',
                    ucfirst($log->status),
                    $log->scan_time ? Carbon::parse($log->scan_time)->format('H:i') : '-',
                    $log->notes ?? '-'
                ];

                if ($includeConfirmer) {
                    $row[] = $log->confirmedBy->name ?? '-';
                    $row[] = $log->confirmed_at ? Carbon::parse($log->confirmed_at)->format('d/m/Y H:i') : '-';
                }

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Attendance statistics
     */
    public function statistics(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Monthly statistics
        $monthlyStats = AttendanceLog::whereBetween('attendance_date', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Daily statistics
        $dailyStats = AttendanceLog::whereBetween('attendance_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(attendance_date) as date'),
                'status',
                DB::raw('count(*) as count')
            )
            ->groupBy('date', 'status')
            ->get()
            ->groupBy('date');

        // Class statistics
        $classStats = AttendanceLog::whereBetween('attendance_date', [$startDate, $endDate])
            ->join('students', 'attendance_logs.student_id', '=', 'students.id')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->select('classes.name as class_name', 'attendance_logs.status', DB::raw('count(*) as count'))
            ->groupBy('classes.name', 'attendance_logs.status')
            ->get()
            ->groupBy('class_name');

        return view('admin.qr-attendance.statistics', compact(
            'monthlyStats',
            'dailyStats',
            'classStats',
            'month',
            'year'
        ));
    }

    /**
     * View QR code for student
     */
    public function viewQr(Student $student)
    {
        try {
            $qrAttendance = $student->qrAttendance;

            if (!$qrAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code belum dibuat untuk siswa ini.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'qr_image_url' => $qrAttendance->qr_image_url,
                'qr_code' => $qrAttendance->qr_code,
                'student' => [
                    'name' => $student->name,
                    'nis' => $student->nis,
                    'class' => $student->class ? $student->class->name : 'Kelas tidak ditemukan',
                ],
                'download_url' => route('admin.qr-attendance.download', $student),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download QR code
     */
    public function downloadQr(Student $student)
    {
        $qrAttendance = $student->qrAttendance;

        if (!$qrAttendance || !$qrAttendance->qr_image_path) {
            return redirect()->back()->with('error', 'QR Code tidak ditemukan untuk siswa ini.');
        }

        $filePath = storage_path('app/public/' . $qrAttendance->qr_image_path);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File QR Code tidak ditemukan.');
        }

        $fileName = 'QR_' . $student->name . '_' . $student->nis . '.png';

        return response()->download($filePath, $fileName);
    }

    /**
     * Confirm individual attendance log
     */
    public function confirmAttendanceLog(Request $request, $logId)
    {
        try {
            $request->validate([
                'notes' => 'nullable|string|max:500'
            ]);

            $log = AttendanceLog::findOrFail($logId);

            // Check if already confirmed
            if ($log->confirmed_by) {
                return response()->json([
                    'success' => false,
                    'message' => 'Log absensi ini sudah dikonfirmasi sebelumnya'
                ], 400);
            }

            // Update the log
            $log->update([
                'confirmed_by' => auth()->id(),
                'confirmed_at' => now(),
                'notes' => $request->notes ? ($log->notes ? $log->notes . "\n\n" . $request->notes : $request->notes) : $log->notes
            ]);

            // Create notification
            $this->createConfirmationNotification($log, 'individual');

            Log::info('Attendance log confirmed', [
                'log_id' => $log->id,
                'student_id' => $log->student_id,
                'confirmed_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Log absensi berhasil dikonfirmasi',
                'log' => [
                    'id' => $log->id,
                    'confirmed_by' => auth()->user()->name,
                    'confirmed_at' => $log->confirmed_at->format('d/m/Y H:i')
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error confirming attendance log', [
                'log_id' => $logId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk confirm attendance logs
     */
    public function bulkConfirmAttendanceLogs(Request $request)
    {
        try {
            $request->validate([
                'log_ids' => 'required|array',
                'log_ids.*' => 'exists:attendance_logs,id',
                'notes' => 'nullable|string|max:500'
            ]);

            $logIds = $request->log_ids;
            $notes = $request->notes;

            DB::beginTransaction();

            $logs = AttendanceLog::whereIn('id', $logIds)
                ->whereNull('confirmed_by')
                ->get();

            if ($logs->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada log absensi yang dapat dikonfirmasi'
                ], 400);
            }

            $confirmedCount = 0;
            foreach ($logs as $log) {
                $log->update([
                    'confirmed_by' => auth()->id(),
                    'confirmed_at' => now(),
                    'notes' => $notes ? ($log->notes ? $log->notes . "\n\n" . $notes : $notes) : $log->notes
                ]);
                $confirmedCount++;
            }

            // Create notification for bulk confirmation
            $this->createBulkConfirmationNotification($logs, $notes);

            DB::commit();

            Log::info('Bulk attendance logs confirmed', [
                'count' => $confirmedCount,
                'confirmed_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => "{$confirmedCount} log absensi berhasil dikonfirmasi",
                'confirmed_count' => $confirmedCount
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error bulk confirming attendance logs', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create notification for individual confirmation
     */
    private function createConfirmationNotification($log, $type = 'individual')
    {
        try {
            $notificationData = [
                'type' => 'attendance_confirmation',
                'action' => 'confirm',
                'title' => 'Log Absensi Dikonfirmasi',
                'message' => sprintf(
                    'Log absensi %s tanggal %s telah dikonfirmasi oleh %s.',
                    $log->student->name ?? 'Siswa',
                    Carbon::parse($log->attendance_date)->format('d/m/Y'),
                    auth()->user()->name ?? 'Admin'
                ),
                'user_id' => auth()->id(),
                'target_id' => $log->id,
                'target_type' => get_class($log),
                'data' => [
                    'log_id' => $log->id,
                    'student' => $log->student->name ?? null,
                    'class' => $log->student->class->name ?? null,
                    'date' => $log->attendance_date,
                    'status' => $log->status,
                    'confirmed_by' => auth()->user()->name,
                    'confirmed_at' => now()->format('Y-m-d H:i:s'),
                ],
                'is_read' => false,
            ];

            \App\Models\AdminNotification::create($notificationData);

        } catch (\Throwable $e) {
            Log::warning('Failed to create confirmation notification', [
                'log_id' => $log->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Create notification for bulk confirmation
     */
    private function createBulkConfirmationNotification($logs, $notes = '')
    {
        try {
            $notificationData = [
                'type' => 'attendance_confirmation',
                'action' => 'bulk_confirm',
                'title' => 'Log Absensi Massal Dikonfirmasi',
                'message' => sprintf(
                    '%d log absensi telah dikonfirmasi secara massal oleh %s.',
                    $logs->count(),
                    auth()->user()->name ?? 'Admin'
                ),
                'user_id' => auth()->id(),
                'target_id' => null,
                'target_type' => 'bulk',
                'data' => [
                    'count' => $logs->count(),
                    'date' => $logs->first()->attendance_date ?? null,
                    'confirmed_by' => auth()->user()->name,
                    'confirmed_at' => now()->format('Y-m-d H:i:s'),
                    'notes' => $notes,
                    'logs' => $logs->map(function ($log) {
                        return [
                            'id' => $log->id,
                            'student' => $log->student->name ?? null,
                            'status' => $log->status
                        ];
                    })->toArray()
                ],
                'is_read' => false,
            ];

            \App\Models\AdminNotification::create($notificationData);

        } catch (\Throwable $e) {
            Log::warning('Failed to create bulk confirmation notification', [
                'count' => $logs->count(),
                'error' => $e->getMessage()
            ]);
        }
    }
}
