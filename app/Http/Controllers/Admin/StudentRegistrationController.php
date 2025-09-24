<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudentRegistrationController extends Controller
{
    /**
     * Display a listing of student account registrations.
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
     * Display the specified student account registration.
     */
    public function show($id)
    {
        $registration = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->findOrFail($id);

        return view('admin.student-registrations.show', compact('registration'));
    }

    /**
     * Approve a student account registration.
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
                    'message' => 'Pendaftaran akun ini sudah diproses sebelumnya.'
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
                'Pendaftaran akun siswa disetujui',
                "Pendaftaran akun siswa {$student->name} telah disetujui dan dapat login ke sistem."
            );

            DB::commit();

            Log::info("Student registration approved", [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'approved_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran akun siswa berhasil disetujui. Siswa sekarang dapat login ke sistem.'
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
     * Reject a student account registration.
     */
    public function reject(Request $request, $id)
    {
        // Log the incoming request for debugging
        Log::info('Student rejection request received', [
            'student_id' => $id,
            'request_data' => $request->all(),
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email ?? 'unknown'
        ]);
        
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'rejection_reason' => 'required|string|min:10|max:500'
            ], [
                'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
                'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
                'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter.'
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed for student rejection', [
                    'student_id' => $id,
                    'errors' => $validator->errors()->toArray()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid: ' . $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Find student
            $student = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->find($id);

            if (!$student) {
                Log::error('Student not found for rejection', [
                    'student_id' => $id
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran akun siswa tidak ditemukan.'
                ], 404);
            }

            Log::info('Student found for rejection', [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'current_status' => $student->status
            ]);

            if ($student->status !== 'pending') {
                Log::warning('Student status is not pending', [
                    'student_id' => $student->id,
                    'current_status' => $student->status
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran akun ini sudah diproses sebelumnya. Status saat ini: ' . ucfirst($student->status)
                ], 400);
            }

            // Check which columns exist
            $hasRejectionReason = Schema::hasColumn('users', 'rejection_reason');
            $hasRejectedAt = Schema::hasColumn('users', 'rejected_at');
            $hasRejectedBy = Schema::hasColumn('users', 'rejected_by');
            
            Log::info('Column availability check', [
                'rejection_reason' => $hasRejectionReason,
                'rejected_at' => $hasRejectedAt,
                'rejected_by' => $hasRejectedBy
            ]);

            // Prepare update data
            $updateData = [
                'status' => 'rejected'
            ];

            // Add rejection fields if columns exist
            if ($hasRejectionReason) {
                $updateData['rejection_reason'] = $request->rejection_reason;
            } else {
                Log::warning('Column rejection_reason does not exist in users table');
            }
            
            if ($hasRejectedAt) {
                $updateData['rejected_at'] = now();
            } else {
                Log::warning('Column rejected_at does not exist in users table');
            }
            
            if ($hasRejectedBy) {
                $updateData['rejected_by'] = auth()->id();
            } else {
                Log::warning('Column rejected_by does not exist in users table');
            }

            // Log the update data for debugging
            Log::info('Updating student with data:', $updateData);

            // Update status to rejected
            $updateResult = $student->update($updateData);
            
            Log::info('Update result', [
                'success' => $updateResult,
                'student_id' => $student->id
            ]);

            // Verify the update
            $student->refresh();
            Log::info('Student after update:', [
                'id' => $student->id,
                'status' => $student->status,
                'rejection_reason' => $hasRejectionReason ? ($student->rejection_reason ?? 'N/A') : 'Column not available'
            ]);

            // Create notification safely
            $this->createNotificationSafely(
                'reject',
                $student,
                'Pendaftaran akun siswa ditolak',
                "Pendaftaran akun siswa {$student->name} ditolak. Alasan: {$request->rejection_reason}"
            );

            DB::commit();

            Log::info("Student registration rejected successfully", [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'rejected_by' => auth()->id(),
                'reason' => $request->rejection_reason
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran akun siswa berhasil ditolak.',
                'data' => [
                    'student_id' => $student->id,
                    'status' => $student->status
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            Log::error('Student not found for rejection', [
                'student_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran akun siswa tidak ditemukan.'
            ], 404);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            Log::error('Database error during rejection', [
                'student_id' => $id,
                'error' => $e->getMessage(),
                'sql' => $e->getSql() ?? 'N/A',
                'bindings' => $e->getBindings() ?? []
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan database: ' . $e->getMessage()
            ], 500);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Unexpected error during student registration rejection', [
                'student_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan tidak terduga: ' . $e->getMessage()
            ], 500);
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
            'rejection_reason' => 'required_if:action,reject|string|min:10|max:500'
        ], [
            'action.required' => 'Aksi harus dipilih.',
            'action.in' => 'Aksi tidak valid.',
            'ids.required' => 'Pilih minimal satu pendaftaran.',
            'ids.array' => 'Format data tidak valid.',
            'ids.*.exists' => 'Pendaftaran tidak ditemukan.',
            'rejection_reason.required_if' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter.'
        ]);

        try {
            DB::beginTransaction();

            $students = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->whereIn('id', $request->ids)->get();

            if ($students->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada pendaftaran yang ditemukan.'
                ], 404);
            }

            $processed = 0;
            $skipped = 0;
            $errors = [];

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
                                "Pendaftaran siswa {$student->name} telah disetujui dan dapat login ke sistem."
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
                                "Pendaftaran siswa {$student->name} ditolak. Alasan: {$request->rejection_reason}"
                            );
                            break;

                        case 'delete':
                            $student->delete();
                            break;
                    }

                    $processed++;
                    
                    Log::info("Bulk action {$request->action} processed for student", [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'action' => $request->action,
                        'processed_by' => auth()->id()
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error("Error processing student {$student->id} in bulk action", [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'action' => $request->action,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    $errors[] = "Error processing {$student->name}: {$e->getMessage()}";
                    $skipped++;
                }
            }

            DB::commit();

            $message = "Berhasil memproses {$processed} pendaftaran.";
            if ($skipped > 0) {
                $message .= " {$skipped} pendaftaran dilewati karena sudah diproses sebelumnya atau terjadi error.";
            }
            
            $responseData = [
                'success' => true,
                'message' => $message,
                'processed' => $processed,
                'skipped' => $skipped
            ];
            
            if (!empty($errors)) {
                $responseData['errors'] = $errors;
            }

            return response()->json($responseData);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . $e->validator->errors()->first(),
                'errors' => $e->validator->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in bulk action', [
                'action' => $request->action,
                'ids' => $request->ids,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Bulk reject with reason
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
            'rejection_reason' => 'required|string|min:10|max:500'
        ], [
            'ids.required' => 'Pilih minimal satu pendaftaran.',
            'ids.array' => 'Format data tidak valid.',
            'ids.*.exists' => 'Pendaftaran tidak ditemukan.',
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter.'
        ]);

        try {
            DB::beginTransaction();

            $students = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->whereIn('id', $request->ids)
              ->where('status', 'pending')
              ->get();

            if ($students->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada pendaftaran yang dapat ditolak. Pastikan pendaftaran masih dalam status pending.'
                ], 404);
            }

            $processed = 0;
            $errors = [];

            foreach ($students as $student) {
                try {
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
                        "Pendaftaran siswa {$student->name} ditolak. Alasan: {$request->rejection_reason}"
                    );

                    $processed++;
                    
                    Log::info("Bulk rejection processed for student", [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'reason' => $request->rejection_reason,
                        'processed_by' => auth()->id()
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error("Error rejecting student {$student->id} in bulk action", [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'error' => $e->getMessage()
                    ]);
                    $errors[] = "Error rejecting {$student->name}: {$e->getMessage()}";
                }
            }

            DB::commit();

            $message = "Berhasil menolak {$processed} pendaftaran.";
            
            $responseData = [
                'success' => true,
                'message' => $message,
                'processed' => $processed
            ];
            
            if (!empty($errors)) {
                $responseData['errors'] = $errors;
            }

            return response()->json($responseData);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in bulk rejection', [
                'ids' => $request->ids,
                'reason' => $request->rejection_reason,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak pendaftaran: ' . $e->getMessage()
            ], 500);
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