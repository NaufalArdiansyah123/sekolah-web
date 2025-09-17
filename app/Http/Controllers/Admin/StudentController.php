<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage, Log, Cache};
use App\Models\{Extracurricular, Achievement, Teacher, Student, User, ExtracurricularRegistration};
use App\Services\NotificationService;

// StudentController.php
class StudentController extends Controller
{
    public function index()
    {
        // Get filter parameters
        $grade = request('grade');
        $status = request('status');
        $search = request('search');
        
        // Build query
        $query = Student::query();
        
        // Apply filters
        if ($grade) {
            $query->where('class', 'like', $grade . '%');
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
        
        // Calculate statistics
        $stats = [
            'total' => Student::count(),
            'grade_10' => Student::where('class', 'like', '10%')->count(),
            'grade_11' => Student::where('class', 'like', '11%')->count(),
            'grade_12' => Student::where('class', 'like', '12%')->count(),
            'active' => Student::where('status', 'active')->count(),
            'inactive' => Student::where('status', 'inactive')->count(),
            'graduated' => Student::where('status', 'graduated')->count(),
        ];
        
        return view('admin.students.index', compact('students', 'stats'));
    }

    public function create()
    {
        // Define class options for the form
        $classOptions = [
            '10' => ['10 IPA 1', '10 IPA 2', '10 IPS 1', '10 IPS 2'],
            '11' => ['11 IPA 1', '11 IPA 2', '11 IPS 1', '11 IPS 2'],
            '12' => ['12 IPA 1', '12 IPA 2', '12 IPS 1', '12 IPS 2']
        ];
        
        return view('admin.students.create', compact('classOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'nis' => 'required|unique:students,nis',
            'nisn' => 'nullable|unique:students,nisn',
            'email' => 'nullable|email|unique:students,email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'class' => 'required|max:50',
            'birth_date' => 'required|date',
            'birth_place' => 'required|max:255',
            'gender' => 'required|in:male,female',
            'parent_name' => 'required|max:255',
            'parent_phone' => 'nullable|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|in:active,inactive,graduated'
        ]);

        $data = $request->except('photo');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student = Student::create($data);

        // Send notification
        NotificationService::studentAction('create', $student);

        return redirect()->route('admin.students.index')
                        ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|max:255',
            'nis' => 'required|unique:students,nis,' . $student->id,
            'nisn' => 'nullable|unique:students,nisn,' . $student->id,
            'email' => 'nullable|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'class' => 'required|max:50',
            'birth_date' => 'required|date',
            'birth_place' => 'required|max:255',
            'gender' => 'required|in:male,female',
            'parent_name' => 'required|max:255',
            'parent_phone' => 'nullable|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|in:active,inactive,graduated'
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($data);

        // Send notification
        NotificationService::studentAction('update', $student);

        return redirect()->route('admin.students.index')
                        ->with('success', 'Data siswa berhasil diperbarui!');
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
}