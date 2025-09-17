<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\{Extracurricular, Achievement, Teacher, Student};
use App\Services\NotificationService;


// TeacherController.php
class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();
        
        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('nip', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('subject', 'LIKE', '%' . $request->search . '%');
            });
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan mata pelajaran
        if ($request->filled('subject')) {
            $query->where('subject', 'LIKE', '%' . $request->subject . '%');
        }
        
        $teachers = $query->latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        try {
            // Check if teachers table and nip column exist
            $nipValidation = 'nullable|string|max:50';
            $emailValidation = 'required|email|max:255';
            
            try {
                // Test if we can query the teachers table with nip column
                if (\Schema::hasTable('teachers') && \Schema::hasColumn('teachers', 'nip')) {
                    $nipValidation = 'nullable|string|unique:teachers,nip|max:50';
                }
                if (\Schema::hasTable('teachers') && \Schema::hasColumn('teachers', 'email')) {
                    $emailValidation = 'required|email|unique:teachers,email|max:255';
                }
            } catch (\Exception $e) {
                \Log::warning('Table structure check failed, using basic validation', ['error' => $e->getMessage()]);
            }
            
            // Validasi input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'nip' => $nipValidation,
                'email' => $emailValidation,
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'subject' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'education' => 'nullable|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
                'status' => 'required|in:active,inactive'
            ]);

            // Log untuk debugging
            \Log::info('Teacher creation attempt', [
                'user_id' => auth()->id(),
                'data' => $request->except(['photo', '_token'])
            ]);

            // Pastikan user terautentikasi
            if (!auth()->check()) {
                return redirect()->route('login')
                    ->with('error', 'Anda harus login terlebih dahulu.');
            }

            // Siapkan data
            $data = $request->except(['photo', '_token']);
            $data['user_id'] = auth()->id();

            // Handle upload foto
            if ($request->hasFile('photo')) {
                try {
                    // Pastikan direktori ada
                    $storagePath = storage_path('app/public/teachers');
                    if (!file_exists($storagePath)) {
                        mkdir($storagePath, 0755, true);
                    }

                    $data['photo'] = $request->file('photo')->store('teachers', 'public');
                    \Log::info('Photo uploaded successfully', ['path' => $data['photo']]);
                } catch (\Exception $e) {
                    \Log::error('Photo upload failed', ['error' => $e->getMessage()]);
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
                }
            }

            // Simpan data guru
            $teacher = Teacher::create($data);
            
            \Log::info('Teacher created successfully', ['teacher_id' => $teacher->id]);

            // Send notification
            NotificationService::teacherAction('create', $teacher);

            return redirect()->route('admin.teachers.index')
                            ->with('success', 'Data guru berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Teacher validation failed', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Data tidak valid. Silakan periksa kembali.');
        } catch (\Exception $e) {
            \Log::error('Teacher creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        // Check if teachers table and columns exist for validation
        $nipValidation = 'nullable|max:50';
        $emailValidation = 'required|email|max:255';
        
        try {
            if (Schema::hasTable('teachers') && Schema::hasColumn('teachers', 'nip')) {
                $nipValidation = 'nullable|unique:teachers,nip,' . $teacher->id;
            }
            if (Schema::hasTable('teachers') && Schema::hasColumn('teachers', 'email')) {
                $emailValidation = 'required|email|unique:teachers,email,' . $teacher->id;
            }
        } catch (\Exception $e) {
            \Log::warning('Table structure check failed in update, using basic validation', ['error' => $e->getMessage()]);
        }
        
        $request->validate([
            'name' => 'required|max:255',
            'nip' => $nipValidation,
            'email' => $emailValidation,
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'subject' => 'required|max:255',
            'position' => 'required|max:255',
            'education' => 'nullable|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($data);

        // Send notification
        NotificationService::teacherAction('update', $teacher);

        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(Teacher $teacher)
    {
        // Send notification before deletion
        NotificationService::teacherAction('delete', $teacher);

        if ($teacher->photo && \Storage::disk('public')->exists($teacher->photo)) {
            \Storage::disk('public')->delete($teacher->photo);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Data guru berhasil dihapus!');
    }
}