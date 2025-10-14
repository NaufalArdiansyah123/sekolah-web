<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\QrTeacherAttendance;
use App\Models\TeacherAttendanceLog;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QrTeacherController extends Controller
{
    /**
     * Display QR teacher management
     */
    public function index(Request $request)
    {
        $query = Teacher::with(['qrTeacherAttendance', 'teacherAttendanceLogs' => function($q) {
            $q->whereDate('attendance_date', today());
        }]);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $teachers = $query->paginate(20);
        
        // Statistics
        $stats = [
            'total_teachers' => Teacher::count(),
            'teachers_with_qr' => QrTeacherAttendance::count(),
            'today_attendance' => TeacherAttendanceLog::whereDate('attendance_date', today())->count(),
            'present_today' => TeacherAttendanceLog::whereDate('attendance_date', today())
                                                  ->where('status', 'hadir')
                                                  ->count(),
        ];

        return view('admin.qr-teacher.index', compact('teachers', 'stats'));
    }

    /**
     * Generate QR code for teacher
     */
    public function generateQr(Teacher $teacher)
    {
        try {
            DB::beginTransaction();

            // Deactivate existing QR codes
            QrTeacherAttendance::where('teacher_id', $teacher->id)
                              ->update(['is_active' => false]);

            // Generate new QR code
            $qrCode = QrTeacherAttendance::generateQrCode($teacher->id);
            
            // Create QR image
            $qrImage = QrCode::format('png')
                            ->size(300)
                            ->margin(2)
                            ->generate($qrCode);

            // Save QR image
            $fileName = 'qr_teacher_' . $teacher->id . '_' . time() . '.png';
            $filePath = 'qr-codes/teachers/' . $fileName;
            Storage::disk('public')->put($filePath, $qrImage);

            // Save to database
            $qrAttendance = QrTeacherAttendance::create([
                'teacher_id' => $teacher->id,
                'qr_code' => $qrCode,
                'qr_image_path' => $filePath,
                'is_active' => true,
            ]);

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dibuat untuk ' . $teacher->name,
                'qr_image_url' => $qrAttendance->qr_image_url,
                'qr_code' => $qrAttendance->qr_code,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to generate QR for teacher: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Regenerate QR code for teacher
     */
    public function regenerateQr(Teacher $teacher)
    {
        try {
            DB::beginTransaction();

            // Delete old QR image if exists
            $oldQr = $teacher->qrTeacherAttendance;
            if ($oldQr && $oldQr->qr_image_path) {
                Storage::disk('public')->delete($oldQr->qr_image_path);
                $oldQr->delete();
            }

            // Generate new QR code
            $qrCode = QrTeacherAttendance::generateQrCode($teacher->id);
            
            // Create QR image
            $qrImage = QrCode::format('png')
                            ->size(300)
                            ->margin(2)
                            ->generate($qrCode);

            // Save QR image
            $fileName = 'qr_teacher_' . $teacher->id . '_' . time() . '.png';
            $filePath = 'qr-codes/teachers/' . $fileName;
            Storage::disk('public')->put($filePath, $qrImage);

            // Save to database
            $qrAttendance = QrTeacherAttendance::create([
                'teacher_id' => $teacher->id,
                'qr_code' => $qrCode,
                'qr_image_path' => $filePath,
                'is_active' => true,
            ]);

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dibuat ulang untuk ' . $teacher->name,
                'qr_image_url' => $qrAttendance->qr_image_url,
                'qr_code' => $qrAttendance->qr_code,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to regenerate QR for teacher: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat ulang QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate QR codes for multiple teachers
     */
    public function generateBulkQr(Request $request)
    {
        $request->validate([
            'teacher_ids' => 'required|array',
            'teacher_ids.*' => 'exists:teachers,id',
        ]);

        try {
            DB::beginTransaction();
            
            $successCount = 0;
            $errors = [];

            foreach ($request->teacher_ids as $teacherId) {
                try {
                    $teacher = Teacher::find($teacherId);
                    
                    // Deactivate existing QR codes
                    QrTeacherAttendance::where('teacher_id', $teacher->id)
                                      ->update(['is_active' => false]);

                    // Generate new QR code
                    $qrCode = QrTeacherAttendance::generateQrCode($teacher->id);
                    
                    // Create QR image
                    $qrImage = QrCode::format('png')
                                    ->size(300)
                                    ->margin(2)
                                    ->generate($qrCode);

                    // Save QR image
                    $fileName = 'qr_teacher_' . $teacher->id . '_' . time() . '.png';
                    $filePath = 'qr-codes/teachers/' . $fileName;
                    Storage::disk('public')->put($filePath, $qrImage);

                    // Save to database
                    QrTeacherAttendance::create([
                        'teacher_id' => $teacher->id,
                        'qr_code' => $qrCode,
                        'qr_image_path' => $filePath,
                        'is_active' => true,
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Gagal membuat QR untuk {$teacher->name}: " . $e->getMessage();
                }
            }
            
            DB::commit();
            
            $message = "QR Code berhasil dibuat untuk {$successCount} guru";
            if (!empty($errors)) {
                $message .= ". Errors: " . implode(', ', $errors);
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'generated_count' => $successCount,
                'errors' => $errors,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * View QR code for teacher
     */
    public function viewQr(Teacher $teacher)
    {
        try {
            $qrAttendance = $teacher->qrTeacherAttendance;
            
            if (!$qrAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code belum dibuat untuk guru ini.',
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'qr_image_url' => $qrAttendance->qr_image_url,
                'qr_code' => $qrAttendance->qr_code,
                'teacher' => [
                    'name' => $teacher->name,
                    'nip' => $teacher->nip,
                    'position' => $teacher->position,
                ],
                'download_url' => route('admin.qr-teacher.download', $teacher),
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
    public function downloadQr(Teacher $teacher)
    {
        $qrAttendance = $teacher->qrTeacherAttendance;
        
        if (!$qrAttendance || !$qrAttendance->qr_image_path) {
            return redirect()->back()->with('error', 'QR Code tidak ditemukan untuk guru ini.');
        }

        $filePath = storage_path('app/public/' . $qrAttendance->qr_image_path);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File QR Code tidak ditemukan.');
        }

        $fileName = 'QR_Teacher_' . $teacher->name . '_' . $teacher->nip . '.png';
        
        return response()->download($filePath, $fileName);
    }

    /**
     * View teacher attendance logs
     */
    public function attendanceLogs(Request $request)
    {
        $query = TeacherAttendanceLog::with(['teacher'])
                                   ->orderBy('scan_time', 'desc');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->date);
        } else {
            $query->whereDate('attendance_date', today());
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by teacher
        if ($request->filled('teacher')) {
            $query->where('teacher_id', $request->teacher);
        }

        $logs = $query->paginate(20);
        
        // Get available teachers and statuses
        $teachers = Teacher::active()->orderBy('name')->get();
        $statuses = ['hadir', 'terlambat', 'izin', 'sakit', 'alpha'];

        return view('admin.qr-teacher.logs', compact('logs', 'teachers', 'statuses'));
    }

    /**
     * Delete QR code for teacher
     */
    public function deleteQr(Teacher $teacher)
    {
        try {
            $qrAttendance = $teacher->qrTeacherAttendance;
            
            if (!$qrAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak ditemukan untuk guru ini.',
                ], 404);
            }

            // Delete QR image file
            if ($qrAttendance->qr_image_path) {
                Storage::disk('public')->delete($qrAttendance->qr_image_path);
            }

            // Delete QR record
            $qrAttendance->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'QR Code berhasil dihapus untuk ' . $teacher->name,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus QR Code: ' . $e->getMessage(),
            ], 500);
        }
    }
}