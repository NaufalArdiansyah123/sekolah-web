<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class StudentRegistrationController extends Controller
{
    /**
     * Display a listing of student registrations.
     */
    public function index(Request $request)
    {
        $query = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
                  
                // Only search NIS and class if columns exist
                if (Schema::hasColumn('users', 'nis')) {
                    $q->orWhere('nis', 'like', "%{$search}%");
                }
                if (Schema::hasColumn('users', 'class')) {
                    $q->orWhere('class', 'like', "%{$search}%");
                }
            });
        }

        // Sort by created_at desc by default
        $query->orderBy('created_at', 'desc');

        $registrations = $query->paginate(15);

        // Statistics
        $stats = [
            'total' => User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->count(),
            'pending' => User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->where('status', 'pending')->count(),
            'approved' => User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->where('status', 'active')->count(),
            'rejected' => User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->where('status', 'rejected')->count(),
        ];

        return view('admin.student-registrations.index', compact('registrations', 'stats'));
    }

    /**
     * Display the specified student registration.
     */
    public function show($id)
    {
        $registration = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->findOrFail($id);

        return view('admin.student-registrations.show', compact('registration'));
    }

    /**
     * Approve a student registration.
     */
    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $student = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->findOrFail($id);

            if ($student->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran ini sudah diproses sebelumnya.'
                ]);
            }

            // Prepare update data
            $updateData = [
                'status' => 'active'
            ];

            // Add approval fields if columns exist
            if (Schema::hasColumn('users', 'approved_at')) {
                $updateData['approved_at'] = now();
            }
            if (Schema::hasColumn('users', 'approved_by')) {
                $updateData['approved_by'] = auth()->id();
            }

            // Update status to active
            $student->update($updateData);

            // Create notification safely
            $this->createNotificationSafely(
                'approve',
                $student,
                'Pendaftaran siswa disetujui',
                "Pendaftaran siswa {$student->name} telah disetujui dan dapat login ke sistem."
            );

            DB::commit();

            Log::info("Student registration approved", [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'approved_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran siswa berhasil disetujui. Siswa sekarang dapat login ke sistem.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error approving student registration', [
                'student_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyetujui pendaftaran: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Reject a student registration.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $student = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->findOrFail($id);

            if ($student->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran ini sudah diproses sebelumnya.'
                ]);
            }

            // Prepare update data
            $updateData = [
                'status' => 'rejected'
            ];

            // Add rejection fields if columns exist
            if (Schema::hasColumn('users', 'rejection_reason')) {
                $updateData['rejection_reason'] = $request->rejection_reason;
            }
            if (Schema::hasColumn('users', 'rejected_at')) {
                $updateData['rejected_at'] = now();
            }
            if (Schema::hasColumn('users', 'rejected_by')) {
                $updateData['rejected_by'] = auth()->id();
            }

            // Update status to rejected
            $student->update($updateData);

            // Create notification safely
            $this->createNotificationSafely(
                'reject',
                $student,
                'Pendaftaran siswa ditolak',
                "Pendaftaran siswa {$student->name} ditolak. Alasan: {$request->rejection_reason}"
            );

            DB::commit();

            Log::info("Student registration rejected", [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'rejected_by' => auth()->id(),
                'reason' => $request->rejection_reason
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran siswa berhasil ditolak.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error rejecting student registration', [
                'student_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak pendaftaran: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Bulk action for multiple registrations.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
            'rejection_reason' => 'required_if:action,reject|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $students = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->whereIn('id', $request->ids)->get();

            $processed = 0;
            $skipped = 0;

            foreach ($students as $student) {
                if ($student->status !== 'pending') {
                    $skipped++;
                    continue;
                }

                try {
                    switch ($request->action) {
                        case 'approve':
                            $updateData = ['status' => 'active'];
                            if (Schema::hasColumn('users', 'approved_at')) {
                                $updateData['approved_at'] = now();
                            }
                            if (Schema::hasColumn('users', 'approved_by')) {
                                $updateData['approved_by'] = auth()->id();
                            }
                            $student->update($updateData);

                            $this->createNotificationSafely(
                                'approve',
                                $student,
                                'Pendaftaran siswa disetujui',
                                "Pendaftaran siswa {$student->name} telah disetujui."
                            );
                            break;

                        case 'reject':
                            $updateData = ['status' => 'rejected'];
                            if (Schema::hasColumn('users', 'rejection_reason')) {
                                $updateData['rejection_reason'] = $request->rejection_reason;
                            }
                            if (Schema::hasColumn('users', 'rejected_at')) {
                                $updateData['rejected_at'] = now();
                            }
                            if (Schema::hasColumn('users', 'rejected_by')) {
                                $updateData['rejected_by'] = auth()->id();
                            }
                            $student->update($updateData);

                            $this->createNotificationSafely(
                                'reject',
                                $student,
                                'Pendaftaran siswa ditolak',
                                "Pendaftaran siswa {$student->name} ditolak."
                            );
                            break;

                        case 'delete':
                            $student->delete();
                            break;
                    }

                    $processed++;
                } catch (\Exception $e) {
                    Log::error("Error processing student {$student->id} in bulk action", [
                        'error' => $e->getMessage()
                    ]);
                    $skipped++;
                }
            }

            DB::commit();

            $message = "Berhasil memproses {$processed} pendaftaran.";
            if ($skipped > 0) {
                $message .= " {$skipped} pendaftaran dilewati karena sudah diproses sebelumnya atau terjadi error.";
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in bulk action', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pendaftaran: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Export student registrations.
     */
    public function export(Request $request)
    {
        try {
            $query = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            });

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $registrations = $query->orderBy('created_at', 'desc')->get();

            $filename = 'student_registrations_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function() use ($registrations) {
                $file = fopen('php://output', 'w');
                
                // CSV Headers
                $csvHeaders = [
                    'ID',
                    'Nama',
                    'Email',
                    'Status',
                    'Tanggal Daftar'
                ];

                // Add optional columns if they exist
                if (Schema::hasColumn('users', 'nis')) {
                    $csvHeaders[] = 'NIS';
                }
                if (Schema::hasColumn('users', 'class')) {
                    $csvHeaders[] = 'Kelas';
                }
                if (Schema::hasColumn('users', 'phone')) {
                    $csvHeaders[] = 'No. Telepon';
                }

                fputcsv($file, $csvHeaders);

                // CSV Data
                foreach ($registrations as $registration) {
                    $csvData = [
                        $registration->id,
                        $registration->name,
                        $registration->email,
                        ucfirst($registration->status),
                        $registration->created_at->format('Y-m-d H:i:s')
                    ];

                    // Add optional data if columns exist
                    if (Schema::hasColumn('users', 'nis')) {
                        $csvData[] = $registration->nis ?? '';
                    }
                    if (Schema::hasColumn('users', 'class')) {
                        $csvData[] = $registration->class ?? '';
                    }
                    if (Schema::hasColumn('users', 'phone')) {
                        $csvData[] = $registration->phone ?? '';
                    }

                    fputcsv($file, $csvData);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Error exporting student registrations', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Create notification safely without causing errors
     */
    private function createNotificationSafely($action, $student, $title, $message)
    {
        try {
            // Check if NotificationService exists and has the method
            if (class_exists('App\Services\NotificationService')) {
                $notificationService = new \App\Services\NotificationService();
                if (method_exists($notificationService, 'createStudentNotification')) {
                    \App\Services\NotificationService::createStudentNotification(
                        $action,
                        $student,
                        $title,
                        $message
                    );
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the main operation
            Log::warning('Failed to create notification', [
                'error' => $e->getMessage(),
                'student_id' => $student->id,
                'action' => $action
            ]);
        }
    }
}