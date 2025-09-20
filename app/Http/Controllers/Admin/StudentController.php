<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage, Log, Cache, Hash};
use App\Models\{Extracurricular, Achievement, Teacher, Student, User, ExtracurricularRegistration};
use App\Services\{NotificationService, QrCodeService};
use App\Helpers\ClassHelper;
use Spatie\Permission\Models\Role;

// StudentController.php
class StudentController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }
    public function index()
    {
        // Get filter parameters
        $grade = request('grade');
        $major = request('major');
        $class = request('class');
        $status = request('status');
        $search = request('search');
        
        // Build query
        $query = Student::query();
        
        // Apply filters
        if ($grade) {
            $query->where('class', 'like', $grade . '%');
        }
        
        if ($major) {
            $query->where('class', 'like', '%' . $major . '%');
        }
        
        if ($class) {
            $query->where('class', $class);
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%')
                  ->orWhere('class', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('parent_name', 'like', '%' . $search . '%');
            });
        }
        
        // Get paginated results
        $students = $query->latest()->paginate(10);
        
        // Get all unique classes for filter dropdown
        $allClasses = Student::select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class')
            ->toArray();
        
        // Calculate statistics
        $stats = [
            'total' => Student::count(),
            'grade_10' => Student::where('class', 'like', '10%')->count(),
            'grade_11' => Student::where('class', 'like', '11%')->count(),
            'grade_12' => Student::where('class', 'like', '12%')->count(),
            'tkj' => Student::where('class', 'like', '%TKJ%')->count(),
            'rpl' => Student::where('class', 'like', '%RPL%')->count(),
            'dkv' => Student::where('class', 'like', '%DKV%')->count(),
            'active' => Student::where('status', 'active')->count(),
            'inactive' => Student::where('status', 'inactive')->count(),
            'graduated' => Student::where('status', 'graduated')->count(),
        ];
        
        return view('admin.students.index', compact('students', 'stats', 'allClasses'));
    }

    public function create()
    {
        // Get class options using ClassHelper
        $allClasses = ClassHelper::getAllClasses();
        $classOptions = [];
        
        // Group classes by grade
        foreach ($allClasses as $class) {
            $parsed = ClassHelper::parseClass($class);
            $grade = $parsed['grade'];
            
            if (!isset($classOptions[$grade])) {
                $classOptions[$grade] = [];
            }
            
            $classOptions[$grade][] = $class;
        }
        
        // Sort by grade
        ksort($classOptions);
        
        return view('admin.students.create', compact('classOptions'));
    }

    public function store(Request $request)
    {
        $validClasses = ClassHelper::getAllClasses();
        
        // Validation rules
        $rules = [
            'name' => 'required|max:255',
            'nis' => 'required|unique:students,nis|regex:/^[0-9]+$/|min:6|max:20',
            'nisn' => 'nullable|unique:students,nisn|regex:/^[0-9]+$/|min:10|max:10',
            'email' => 'nullable|email|unique:students,email|unique:users,email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'class' => 'required|in:' . implode(',', $validClasses),
            'birth_date' => 'required|date',
            'birth_place' => 'required|max:255',
            'gender' => 'required|in:male,female',
            'religion' => 'required|in:' . implode(',', array_keys(config('school.student.religions', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']))),
            'parent_name' => 'required|max:255',
            'parent_phone' => 'nullable|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|in:active,inactive,graduated'
        ];
        
        // Add validation for user account creation
        if ($request->has('create_user_account') && $request->create_user_account) {
            $rules['email'] = 'required|email|unique:students,email|unique:users,email';
            $rules['password'] = 'required|min:8|confirmed';
        }
        
        $request->validate($rules, [
            'class.in' => 'Kelas yang dipilih tidak valid.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan oleh siswa lain.',
            'nis.regex' => 'NIS hanya boleh berisi angka.',
            'nis.min' => 'NIS minimal 6 digit.',
            'nis.max' => 'NIS maksimal 20 digit.',
            'nisn.unique' => 'NISN sudah digunakan oleh siswa lain.',
            'nisn.regex' => 'NISN hanya boleh berisi angka.',
            'nisn.min' => 'NISN harus 10 digit.',
            'nisn.max' => 'NISN harus 10 digit.',
            'religion.required' => 'Agama wajib dipilih.',
            'religion.in' => 'Agama yang dipilih tidak valid.',
        ]);

        $data = $request->except('photo');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        DB::beginTransaction();
        
        try {
            $student = Student::create($data);
            
            $successMessages = ['Data siswa berhasil ditambahkan!'];
            
            // Create user account if requested
            if ($request->has('create_user_account') && $request->create_user_account) {
                try {
                    $user = User::create([
                        'name' => $student->name,
                        'email' => $student->email,
                        'password' => Hash::make($request->password),
                        'email_verified_at' => now(),
                        'status' => 'active',
                    ]);
                    
                    // Assign student role
                    $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
                    if ($studentRole) {
                        $user->assignRole($studentRole);
                    }
                    
                    Log::info('User account created for new student', [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'created_by' => auth()->user()->name ?? 'System'
                    ]);
                    
                    $successMessages[] = 'Akun pengguna berhasil dibuat!';
                } catch (\Exception $e) {
                    Log::error('Failed to create user account for new student', [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    $successMessages[] = 'Akun pengguna gagal dibuat. Silakan buat manual di halaman manajemen user.';
                }
            }
            
            // Auto-generate QR Code for attendance if requested
            if ($request->has('auto_generate_qr') && $request->auto_generate_qr) {
                try {
                    $qrAttendance = $this->qrCodeService->generateQrCodeForStudent($student);
                    
                    Log::info('QR Code auto-generated for new student', [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'student_nis' => $student->nis,
                        'qr_attendance_id' => $qrAttendance->id,
                        'created_by' => auth()->user()->name ?? 'System'
                    ]);
                    
                    $successMessages[] = 'QR Code absensi berhasil dibuat!';
                } catch (\Exception $e) {
                    Log::error('Failed to auto-generate QR Code for new student', [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    $successMessages[] = 'QR Code absensi gagal dibuat. Silakan buat manual di halaman QR Attendance.';
                }
            }
            
            DB::commit();
            
            $successMessage = implode(' ', $successMessages);
        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Failed to create student', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal menyimpan data siswa: ' . $e->getMessage());
        }

        // Send notification
        NotificationService::studentAction('create', $student);

        return redirect()->route('admin.students.index')
                        ->with('success', $successMessage);
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        // Get class options using ClassHelper
        $allClasses = ClassHelper::getAllClasses();
        $classOptions = [];
        
        // Group classes by grade
        foreach ($allClasses as $class) {
            $parsed = ClassHelper::parseClass($class);
            $grade = $parsed['grade'];
            
            if (!isset($classOptions[$grade])) {
                $classOptions[$grade] = [];
            }
            
            $classOptions[$grade][] = $class;
        }
        
        // Sort by grade
        ksort($classOptions);
        
        return view('admin.students.edit', compact('student', 'classOptions'));
    }

    public function update(Request $request, Student $student)
    {
        $validClasses = ClassHelper::getAllClasses();
        
        // Validation rules
        $rules = [
            'name' => 'required|max:255',
            'nis' => 'required|unique:students,nis,' . $student->id . '|regex:/^[0-9]+$/|min:6|max:20',
            'nisn' => 'nullable|unique:students,nisn,' . $student->id . '|regex:/^[0-9]+$/|min:10|max:10',
            'email' => 'nullable|email|unique:students,email,' . $student->id . '|unique:users,email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'class' => 'required|in:' . implode(',', $validClasses),
            'birth_date' => 'required|date',
            'birth_place' => 'required|max:255',
            'gender' => 'required|in:male,female',
            'religion' => 'required|in:' . implode(',', array_keys(config('school.student.religions', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']))),
            'parent_name' => 'required|max:255',
            'parent_phone' => 'nullable|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|in:active,inactive,graduated'
        ];
        
        // Add validation for user account creation
        if ($request->has('create_user_account') && $request->create_user_account) {
            // Check if user already exists for this student
            $existingUser = User::where('email', $student->email)->first();
            if (!$existingUser) {
                $rules['email'] = 'required|email|unique:students,email,' . $student->id . '|unique:users,email';
                $rules['password'] = 'required|min:8|confirmed';
            }
        }
        
        $request->validate($rules, [
            'class.in' => 'Kelas yang dipilih tidak valid.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan oleh siswa lain.',
            'nis.regex' => 'NIS hanya boleh berisi angka.',
            'nis.min' => 'NIS minimal 6 digit.',
            'nis.max' => 'NIS maksimal 20 digit.',
            'nisn.unique' => 'NISN sudah digunakan oleh siswa lain.',
            'nisn.regex' => 'NISN hanya boleh berisi angka.',
            'nisn.min' => 'NISN harus 10 digit.',
            'nisn.max' => 'NISN harus 10 digit.',
            'religion.required' => 'Agama wajib dipilih.',
            'religion.in' => 'Agama yang dipilih tidak valid.',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        DB::beginTransaction();
        
        try {
            $student->update($data);
            
            $successMessages = ['Data siswa berhasil diperbarui!'];
            
            // Create user account if requested and doesn't exist
            if ($request->has('create_user_account') && $request->create_user_account) {
                $existingUser = User::where('email', $student->email)->first();
                
                if (!$existingUser) {
                    try {
                        $user = User::create([
                            'name' => $student->name,
                            'email' => $student->email,
                            'password' => Hash::make($request->password),
                            'email_verified_at' => now(),
                            'status' => 'active',
                        ]);
                        
                        // Assign student role
                        $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
                        if ($studentRole) {
                            $user->assignRole($studentRole);
                        }
                        
                        Log::info('User account created for updated student', [
                            'student_id' => $student->id,
                            'student_name' => $student->name,
                            'user_id' => $user->id,
                            'user_email' => $user->email,
                            'updated_by' => auth()->user()->name ?? 'System'
                        ]);
                        
                        $successMessages[] = 'Akun pengguna berhasil dibuat!';
                    } catch (\Exception $e) {
                        Log::error('Failed to create user account for updated student', [
                            'student_id' => $student->id,
                            'student_name' => $student->name,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        
                        $successMessages[] = 'Akun pengguna gagal dibuat. Silakan buat manual di halaman manajemen user.';
                    }
                } else {
                    $successMessages[] = 'Akun pengguna sudah ada untuk email ini.';
                }
            }
            
            // Auto-generate QR Code for attendance if requested and not exists
            if ($request->has('auto_generate_qr') && $request->auto_generate_qr && !$student->qrAttendance) {
                try {
                    $qrAttendance = $this->qrCodeService->generateQrCodeForStudent($student);
                    
                    Log::info('QR Code auto-generated for updated student', [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'student_nis' => $student->nis,
                        'qr_attendance_id' => $qrAttendance->id,
                        'updated_by' => auth()->user()->name ?? 'System'
                    ]);
                    
                    $successMessages[] = 'QR Code absensi berhasil dibuat!';
                } catch (\Exception $e) {
                    Log::error('Failed to auto-generate QR Code for updated student', [
                        'student_id' => $student->id,
                        'student_name' => $student->name,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    $successMessages[] = 'QR Code absensi gagal dibuat. Silakan buat manual di halaman QR Attendance.';
                }
            }
            
            DB::commit();
            
            $successMessage = implode(' ', $successMessages);
        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Failed to update student', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage());
        }

        // Send notification
        NotificationService::studentAction('update', $student);

        return redirect()->route('admin.students.index')
                        ->with('success', $successMessage);
    }

    public function destroy(Student $student)
    {
        try {
            DB::beginTransaction();
            
            // Send notification before deletion
            NotificationService::studentAction('delete', $student);
            
            // Hapus semua data terkait siswa
            $this->deleteStudentCompletely($student);
            
            DB::commit();
            
            return redirect()->route('admin.students.index')
                            ->with('success', 'Data siswa dan semua data terkaitnya berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.students.index')
                            ->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $studentIds = json_decode($request->input('student_ids'), true);
        
        if (empty($studentIds)) {
            return redirect()->back()->with('error', 'Tidak ada siswa yang dipilih.');
        }
        
        $students = Student::whereIn('id', $studentIds);
        
        switch ($action) {
            case 'activate':
                $students->update(['status' => 'active']);
                $message = count($studentIds) . ' siswa berhasil diaktifkan.';
                break;
                
            case 'deactivate':
                $students->update(['status' => 'inactive']);
                $message = count($studentIds) . ' siswa berhasil dinonaktifkan.';
                break;
                
            case 'graduate':
                $students->update(['status' => 'graduated']);
                $message = count($studentIds) . ' siswa berhasil diluluskan.';
                break;
                
            case 'delete':
                try {
                    DB::beginTransaction();
                    
                    // Hapus semua data terkait untuk setiap siswa
                    $studentsToDelete = Student::whereIn('id', $studentIds)->get();
                    foreach ($studentsToDelete as $student) {
                        $this->deleteStudentCompletely($student);
                    }
                    
                    DB::commit();
                    $message = count($studentIds) . ' siswa dan semua data terkaitnya berhasil dihapus.';
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
                }
                break;
                
            default:
                return redirect()->back()->with('error', 'Aksi tidak valid.');
        }
        
        // Send bulk notification
        NotificationService::bulkAction('student', $action, count($studentIds));
        
        return redirect()->route('admin.students.index')->with('success', $message);
    }



    /**
     * Hapus siswa beserta semua data terkaitnya secara menyeluruh
     */
    private function deleteStudentCompletely(Student $student)
    {
        // Log aktivitas penghapusan
        Log::info('Menghapus siswa dan semua data terkait', [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'student_nis' => $student->nis,
            'deleted_by' => auth()->user()->name ?? 'System'
        ]);

        // 1. Hapus foto siswa dari storage
        try {
            if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
                Log::info('Foto siswa dihapus', ['photo_path' => $student->photo]);
            }
        } catch (\Exception $e) {
            Log::warning('Gagal menghapus foto siswa', ['error' => $e->getMessage()]);
        }

        // 2. Hapus achievements siswa (dengan fallback raw SQL)
        try {
            // Cek apakah tabel achievements ada dan memiliki kolom student_id
            $tableExists = DB::select("SHOW TABLES LIKE 'achievements'");
            if (!empty($tableExists)) {
                $columns = DB::select("SHOW COLUMNS FROM achievements LIKE 'student_id'");
                if (!empty($columns)) {
                    // Gunakan Eloquent jika relasi ada
                    $achievementsCount = $student->achievements()->count();
                    if ($achievementsCount > 0) {
                        $student->achievements()->delete();
                        Log::info('Achievements siswa dihapus via Eloquent', ['count' => $achievementsCount]);
                    }
                } else {
                    // Fallback: hapus berdasarkan cara lain jika kolom student_id tidak ada
                    Log::warning('Kolom student_id tidak ditemukan di tabel achievements');
                }
            }
        } catch (\Exception $e) {
            Log::warning('Gagal menghapus achievements via Eloquent, mencoba raw SQL', ['error' => $e->getMessage()]);
            try {
                // Fallback dengan raw SQL
                $deletedCount = DB::table('achievements')->where('student_id', $student->id)->delete();
                Log::info('Achievements siswa dihapus via raw SQL', ['count' => $deletedCount]);
            } catch (\Exception $e2) {
                Log::warning('Gagal menghapus achievements via raw SQL', ['error' => $e2->getMessage()]);
            }
        }

        // 3. Hapus relasi extracurricular (many-to-many)
        try {
            $extracurricularsCount = $student->extracurriculars()->count();
            if ($extracurricularsCount > 0) {
                $student->extracurriculars()->detach();
                Log::info('Relasi extracurricular siswa dihapus', ['count' => $extracurricularsCount]);
            }
        } catch (\Exception $e) {
            Log::warning('Gagal menghapus relasi extracurricular via Eloquent', ['error' => $e->getMessage()]);
            try {
                // Fallback dengan raw SQL
                $deletedCount = DB::table('student_extracurriculars')->where('student_id', $student->id)->delete();
                Log::info('Relasi extracurricular dihapus via raw SQL', ['count' => $deletedCount]);
            } catch (\Exception $e2) {
                Log::warning('Gagal menghapus relasi extracurricular via raw SQL', ['error' => $e2->getMessage()]);
            }
        }

        // 4. Hapus registrasi extracurricular berdasarkan NIS
        try {
            $registrationsCount = ExtracurricularRegistration::where('student_nis', $student->nis)->count();
            if ($registrationsCount > 0) {
                ExtracurricularRegistration::where('student_nis', $student->nis)->delete();
                Log::info('Registrasi extracurricular siswa dihapus', ['count' => $registrationsCount]);
            }
        } catch (\Exception $e) {
            Log::warning('Gagal menghapus registrasi extracurricular', ['error' => $e->getMessage()]);
        }

        // 5. Hapus user account jika ada (berdasarkan email)
        try {
            if ($student->email) {
                $user = User::where('email', $student->email)->first();
                if ($user) {
                    // Hapus semua role dan permission user
                    try {
                        $user->roles()->detach();
                    } catch (\Exception $e) {
                        Log::warning('Gagal detach roles', ['error' => $e->getMessage()]);
                    }
                    
                    try {
                        $user->permissions()->detach();
                    } catch (\Exception $e) {
                        Log::warning('Gagal detach permissions', ['error' => $e->getMessage()]);
                    }
                    
                    $user->delete();
                    Log::info('User account siswa dihapus', ['user_id' => $user->id, 'email' => $user->email]);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Gagal menghapus user account', ['error' => $e->getMessage()]);
        }

        // 6. Hapus data dari tabel lain yang mungkin terkait (dengan pengecekan tabel)
        $tablesToClean = [
            'student_extracurriculars' => 'student_id',
            'student_achievements' => 'student_id',
            'extracurricular_registrations' => 'student_nis'
        ];
        
        foreach ($tablesToClean as $table => $column) {
            try {
                $tableExists = DB::select("SHOW TABLES LIKE '{$table}'");
                if (!empty($tableExists)) {
                    $value = ($column === 'student_nis') ? $student->nis : $student->id;
                    $deletedCount = DB::table($table)->where($column, $value)->delete();
                    if ($deletedCount > 0) {
                        Log::info("Data dihapus dari tabel {$table}", ['count' => $deletedCount]);
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Gagal menghapus data dari tabel {$table}", ['error' => $e->getMessage()]);
            }
        }
        
        // 7. Hapus data siswa dari tabel utama (ini harus berhasil)
        try {
            $studentId = $student->id;
            $studentName = $student->name;
            $student->delete();
            Log::info('Data siswa utama dihapus', ['student_id' => $studentId]);
        } catch (\Exception $e) {
            Log::error('GAGAL menghapus data siswa utama', ['error' => $e->getMessage()]);
            throw $e; // Re-throw karena ini critical
        }
        
        // 8. Bersihkan cache jika ada
        try {
            Cache::forget('students_count');
            Cache::forget('students_stats');
            Cache::tags(['students'])->flush();
        } catch (\Exception $e) {
            Log::warning('Gagal membersihkan cache', ['error' => $e->getMessage()]);
        }
        
        Log::info('Penghapusan siswa selesai', ['student_name' => $studentName ?? 'Unknown']);
    }

    /**
     * Check if NIS is available (AJAX)
     */
    public function checkNis(Request $request)
    {
        $nis = $request->get('nis');
        $studentId = $request->get('student_id'); // For edit mode
        
        if (!$nis) {
            return response()->json([
                'available' => false,
                'message' => 'NIS tidak boleh kosong.'
            ]);
        }
        
        // Validate NIS format
        if (!preg_match('/^[0-9]+$/', $nis)) {
            return response()->json([
                'available' => false,
                'message' => 'NIS hanya boleh berisi angka.'
            ]);
        }
        
        if (strlen($nis) < 6) {
            return response()->json([
                'available' => false,
                'message' => 'NIS minimal 6 digit.'
            ]);
        }
        
        if (strlen($nis) > 20) {
            return response()->json([
                'available' => false,
                'message' => 'NIS maksimal 20 digit.'
            ]);
        }
        
        // Check if NIS exists
        $query = Student::where('nis', $nis);
        
        // Exclude current student when editing
        if ($studentId) {
            $query->where('id', '!=', $studentId);
        }
        
        $exists = $query->exists();
        
        if ($exists) {
            return response()->json([
                'available' => false,
                'message' => 'NIS sudah digunakan oleh siswa lain.'
            ]);
        }
        
        return response()->json([
            'available' => true,
            'message' => 'NIS tersedia.'
        ]);
    }
    
    /**
     * Check if NISN is available (AJAX)
     */
    public function checkNisn(Request $request)
    {
        $nisn = $request->get('nisn');
        $studentId = $request->get('student_id'); // For edit mode
        
        if (!$nisn) {
            return response()->json([
                'available' => true,
                'message' => 'NISN boleh kosong.'
            ]);
        }
        
        // Validate NISN format
        if (!preg_match('/^[0-9]+$/', $nisn)) {
            return response()->json([
                'available' => false,
                'message' => 'NISN hanya boleh berisi angka.'
            ]);
        }
        
        if (strlen($nisn) !== 10) {
            return response()->json([
                'available' => false,
                'message' => 'NISN harus 10 digit.'
            ]);
        }
        
        // Check if NISN exists
        $query = Student::where('nisn', $nisn);
        
        // Exclude current student when editing
        if ($studentId) {
            $query->where('id', '!=', $studentId);
        }
        
        $exists = $query->exists();
        
        if ($exists) {
            return response()->json([
                'available' => false,
                'message' => 'NISN sudah digunakan oleh siswa lain.'
            ]);
        }
        
        return response()->json([
            'available' => true,
            'message' => 'NISN tersedia.'
        ]);
    }

    /**
     * Hapus foto profil siswa
     */
    public function deletePhoto(Student $student)
    {
        try {
            // Cek apakah siswa memiliki foto
            if (!$student->photo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak memiliki foto profil.'
                ], 400);
            }

            // Hapus file foto dari storage
            if (Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
                Log::info('Foto profil siswa dihapus', [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'photo_path' => $student->photo,
                    'deleted_by' => auth()->user()->name ?? 'System'
                ]);
            }

            // Update database - set photo field to null
            $student->update(['photo' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal menghapus foto profil siswa', [
                'student_id' => $student->id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto profil: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Generate unique NIS suggestion
     */
    public function generateNis(Request $request)
    {
        $class = $request->get('class');
        $currentYear = date('Y');
        
        // Parse class to get grade
        if ($class) {
            $parsed = ClassHelper::parseClass($class);
            $grade = $parsed['grade'];
        } else {
            $grade = 10; // Default to grade 10
        }
        
        // Generate NIS pattern: YYYY + Grade + Sequential number
        $baseNis = $currentYear . str_pad($grade, 2, '0', STR_PAD_LEFT);
        
        // Find the next available number
        $lastStudent = Student::where('nis', 'like', $baseNis . '%')
            ->orderBy('nis', 'desc')
            ->first();
        
        if ($lastStudent) {
            $lastNumber = (int) substr($lastStudent->nis, strlen($baseNis));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        $suggestedNis = $baseNis . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        
        // Make sure it's unique
        while (Student::where('nis', $suggestedNis)->exists()) {
            $nextNumber++;
            $suggestedNis = $baseNis . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }
        
        return response()->json([
            'suggested_nis' => $suggestedNis,
            'pattern' => 'Format: Tahun(4) + Kelas(2) + Urutan(3)',
            'example' => $currentYear . '10001 untuk siswa kelas 10 pertama'
        ]);
    }
}