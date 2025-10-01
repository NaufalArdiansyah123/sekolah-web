<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Extracurricular, Achievement, Teacher, Student, ExtracurricularRegistration};

// ExtracurricularController.php
class ExtracurricularController extends Controller
{
    public function index()
    {
        $extracurriculars = Extracurricular::withCount([
            'registrations', 
            'pendingRegistrations', 
            'approvedRegistrations',
            'rejectedRegistrations'
        ])
            ->latest()
            ->paginate(10);
            
        // Statistics for dashboard
        $pendingRegistrations = ExtracurricularRegistration::where('status', 'pending')->count();
        $totalMembers = ExtracurricularRegistration::where('status', 'approved')->count();
        $activeExtracurriculars = Extracurricular::where('status', 'active')->count();
        
        return view('admin.extracurriculars.index', compact(
            'extracurriculars', 
            'pendingRegistrations', 
            'totalMembers', 
            'activeExtracurriculars'
        ));
    }

    public function create()
    {
        return view('admin.extracurriculars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'coach' => 'required|max:255',
            'schedule' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('extracurriculars', 'public');
        }

        Extracurricular::create($data);

        return redirect()->route('admin.extracurriculars.index')
                        ->with('success', 'Ekstrakurikuler berhasil ditambahkan!');
    }

    public function show(Extracurricular $extracurricular)
    {
        // Load the extracurricular with all its registrations
        $extracurricular->load([
            'registrations' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);
        
        // Add sample data if no registrations exist (for demo purposes)
        if ($extracurricular->registrations->count() === 0 && config('app.env') !== 'production') {
            $this->createSampleRegistrations($extracurricular);
            // Reload the registrations
            $extracurricular->load([
                'registrations' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ]);
        }
        
        $extracurricular->loadCount([
            'registrations',
            'pendingRegistrations',
            'approvedRegistrations',
            'rejectedRegistrations'
        ]);
        
        // Get registrations by status
        $pendingRegistrations = $extracurricular->registrations()
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        $approvedRegistrations = $extracurricular->registrations()
            ->where('status', 'approved')
            ->latest()
            ->get();
            
        $rejectedRegistrations = $extracurricular->registrations()
            ->where('status', 'rejected')
            ->latest()
            ->get();
            
        return view('admin.extracurriculars.show', compact(
            'extracurricular', 
            'pendingRegistrations', 
            'approvedRegistrations', 
            'rejectedRegistrations'
        ));
    }
    
    private function createSampleRegistrations(Extracurricular $extracurricular)
    {
        $sampleStudents = [
            [
                'student_name' => 'Ahmad Rizki Pratama',
                'student_class' => 'XII',
                'student_major' => 'TKJ 1',
                'student_nis' => '2021001',
                'email' => 'ahmad.rizki@student.smk.sch.id',
                'phone' => '081234567890',
                'parent_name' => 'Budi Pratama',
                'parent_phone' => '081234567891',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'reason' => 'Saya ingin mengembangkan kemampuan di bidang teknologi dan jaringan komputer.',
                'experience' => 'Pernah mengikuti kursus komputer dasar dan memiliki sertifikat Microsoft Office.',
                'status' => 'approved'
            ],
            [
                'student_name' => 'Siti Nurhaliza',
                'student_class' => 'XI',
                'student_major' => 'RPL 2',
                'student_nis' => '2022002',
                'email' => 'siti.nurhaliza@student.smk.sch.id',
                'phone' => '081234567892',
                'parent_name' => 'Hasan Nurdin',
                'parent_phone' => '081234567893',
                'address' => 'Jl. Sudirman No. 456, Jakarta',
                'reason' => 'Ingin belajar programming dan mengembangkan aplikasi mobile.',
                'experience' => 'Sudah belajar HTML dan CSS secara otodidak.',
                'status' => 'approved'
            ],
            [
                'student_name' => 'Budi Santoso',
                'student_class' => 'X',
                'student_major' => 'DKV 1',
                'student_nis' => '2023003',
                'email' => 'budi.santoso@student.smk.sch.id',
                'phone' => '081234567894',
                'parent_name' => 'Santoso Wijaya',
                'parent_phone' => '081234567895',
                'address' => 'Jl. Gatot Subroto No. 789, Jakarta',
                'reason' => 'Saya tertarik dengan desain grafis dan ingin mengasah kreativitas.',
                'experience' => 'Pernah membuat poster untuk acara sekolah.',
                'status' => 'approved'
            ],
            [
                'student_name' => 'Dewi Lestari',
                'student_class' => 'XII',
                'student_major' => 'TKJ 2',
                'student_nis' => '2021004',
                'email' => 'dewi.lestari@student.smk.sch.id',
                'phone' => '081234567896',
                'parent_name' => 'Lestari Indah',
                'parent_phone' => '081234567897',
                'address' => 'Jl. Thamrin No. 321, Jakarta',
                'reason' => 'Ingin memperdalam ilmu jaringan komputer dan keamanan siber.',
                'experience' => 'Mengikuti workshop cybersecurity di sekolah.',
                'status' => 'pending'
            ]
        ];
        
        foreach ($sampleStudents as $student) {
            ExtracurricularRegistration::create([
                'extracurricular_id' => $extracurricular->id,
                'student_name' => $student['student_name'],
                'student_class' => $student['student_class'],
                'student_major' => $student['student_major'],
                'student_nis' => $student['student_nis'],
                'email' => $student['email'],
                'phone' => $student['phone'],
                'parent_name' => $student['parent_name'],
                'parent_phone' => $student['parent_phone'],
                'address' => $student['address'],
                'reason' => $student['reason'],
                'experience' => $student['experience'],
                'status' => $student['status'],
                'registered_at' => now(),
                'approved_at' => $student['status'] === 'approved' ? now() : null,
                'approved_by' => $student['status'] === 'approved' ? auth()->id() : null,
            ]);
        }
    }

    public function edit(Extracurricular $extracurricular)
    {
        $extracurricular->loadCount([
            'registrations',
            'pendingRegistrations',
            'approvedRegistrations',
            'rejectedRegistrations'
        ]);
        
        return view('admin.extracurriculars.edit', compact('extracurricular'));
    }

    public function update(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'coach' => 'required|max:255',
            'schedule' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('extracurriculars', 'public');
        }

        $extracurricular->update($data);

        return redirect()->route('admin.extracurriculars.index')
                        ->with('success', 'Ekstrakurikuler berhasil diperbarui!');
    }

    public function destroy(Extracurricular $extracurricular)
    {
        if ($extracurricular->image && \Storage::disk('public')->exists($extracurricular->image)) {
            \Storage::disk('public')->delete($extracurricular->image);
        }

        $extracurricular->delete();

        return redirect()->route('admin.extracurriculars.index')
                        ->with('success', 'Ekstrakurikuler berhasil dihapus!');
    }

    public function registrations(Extracurricular $extracurricular)
    {
        $registrations = ExtracurricularRegistration::with(['extracurricular', 'approvedBy'])
            ->where('extracurricular_id', $extracurricular->id)
            ->latest()
            ->paginate(15);

        return view('admin.extracurriculars.registrations', compact('extracurricular', 'registrations'));
    }

    public function allRegistrations(Request $request)
    {
        $query = ExtracurricularRegistration::with(['extracurricular', 'approvedBy']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by extracurricular
        if ($request->filled('extracurricular_id')) {
            $query->where('extracurricular_id', $request->extracurricular_id);
        }

        // Filter by class
        if ($request->filled('student_class')) {
            $query->where('student_class', 'like', '%' . $request->student_class . '%');
        }

        // Filter by major
        if ($request->filled('student_major')) {
            $query->where('student_major', 'like', '%' . $request->student_major . '%');
        }

        // Search by name or NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_name', 'like', '%' . $search . '%')
                  ->orWhere('student_nis', 'like', '%' . $search . '%');
            });
        }

        $registrations = $query->latest()->paginate(20);
        $extracurriculars = Extracurricular::active()->get();
        
        // Statistics
        $totalRegistrations = ExtracurricularRegistration::count();
        $pendingRegistrations = ExtracurricularRegistration::where('status', 'pending')->count();
        $approvedRegistrations = ExtracurricularRegistration::where('status', 'approved')->count();
        $rejectedRegistrations = ExtracurricularRegistration::where('status', 'rejected')->count();

        return view('admin.extracurriculars.all-registrations', compact(
            'registrations', 
            'extracurriculars',
            'totalRegistrations',
            'pendingRegistrations', 
            'approvedRegistrations',
            'rejectedRegistrations'
        ));
    }

    public function approveRegistration(ExtracurricularRegistration $registration)
    {
        try {
            $registration->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            // Check if request is AJAX
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pendaftaran berhasil disetujui!'
                ]);
            }

            return redirect()->back()->with('success', 'Pendaftaran berhasil disetujui!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyetujui pendaftaran: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menyetujui pendaftaran: ' . $e->getMessage());
        }
    }

    public function rejectRegistration(Request $request, ExtracurricularRegistration $registration)
    {
        try {
            $request->validate([
                'notes' => 'nullable|string|max:500'
            ]);

            $registration->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'notes' => $request->notes,
            ]);

            // Check if request is AJAX
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pendaftaran berhasil ditolak!'
                ]);
            }

            return redirect()->back()->with('success', 'Pendaftaran berhasil ditolak!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menolak pendaftaran: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menolak pendaftaran: ' . $e->getMessage());
        }
    }

    public function showRegistrationDetail(ExtracurricularRegistration $registration)
    {
        try {
            $registration->load(['extracurricular', 'approvedBy']);
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'registration' => [
                        'id' => $registration->id,
                        'student_name' => $registration->student_name,
                        'student_nis' => $registration->student_nis,
                        'student_class' => $registration->student_class,
                        'student_major' => $registration->student_major,
                        'email' => $registration->email,
                        'phone' => $registration->phone,
                        'reason' => $registration->reason,
                        'experience' => $registration->experience,
                        'status' => $registration->status,
                        'notes' => $registration->notes,
                        'registered_at' => $registration->created_at->format('d M Y H:i'),
                        'approved_at' => $registration->approved_at ? $registration->approved_at->format('d M Y H:i') : null,
                        'approved_by' => $registration->approvedBy ? $registration->approvedBy->name : null,
                        'extracurricular' => [
                            'id' => $registration->extracurricular->id,
                            'name' => $registration->extracurricular->name,
                            'description' => $registration->extracurricular->description,
                            'coach' => $registration->extracurricular->coach,
                            'schedule' => $registration->extracurricular->schedule,
                        ]
                    ]
                ]);
            }
            
            return view('admin.extracurriculars.partials.registration-detail', compact('registration'));
        } catch (\Exception $e) {
            \Log::error('Error loading registration detail: ' . $e->getMessage());
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load registration detail: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to load registration detail.');
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'registrations' => 'required|array',
            'registrations.*' => 'exists:extracurricular_registrations,id',
            'notes' => 'nullable|string|max:500'
        ]);

        $registrations = ExtracurricularRegistration::whereIn('id', $request->registrations);

        switch ($request->action) {
            case 'approve':
                $registrations->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                    'approved_by' => auth()->id(),
                ]);
                $message = 'Pendaftaran terpilih berhasil disetujui!';
                break;

            case 'reject':
                $registrations->update([
                    'status' => 'rejected',
                    'approved_by' => auth()->id(),
                    'notes' => $request->notes,
                ]);
                $message = 'Pendaftaran terpilih berhasil ditolak!';
                break;

            case 'delete':
                $registrations->delete();
                $message = 'Pendaftaran terpilih berhasil dihapus!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    // AJAX Methods for integrated system
    public function pendingRegistrations()
    {
        $registrations = ExtracurricularRegistration::with(['extracurricular'])
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        return view('admin.extracurriculars.partials.pending-registrations', compact('registrations'));
    }
    
    public function getRegistrations(Extracurricular $extracurricular)
    {
        $registrations = $extracurricular->registrations()
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        return view('admin.extracurriculars.partials.registrations', compact('registrations', 'extracurricular'));
    }
    
    public function getMembers(Extracurricular $extracurricular)
    {
        $members = $extracurricular->registrations()
            ->where('status', 'approved')
            ->latest()
            ->get();
            
        return view('admin.extracurriculars.partials.members', compact('members', 'extracurricular'));
    }
    
    public function showMembers(Extracurricular $extracurricular)
    {
        try {
            $members = $extracurricular->registrations()
                ->where('status', 'approved')
                ->latest()
                ->get();
                
            return view('admin.extracurriculars.partials.members-simple', compact('members', 'extracurricular'));
        } catch (\Exception $e) {
            \Log::error('Error loading members: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load members: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    
    public function showRegistrations(Extracurricular $extracurricular)
    {
        $registrations = $extracurricular->registrations()
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        return view('admin.extracurriculars.partials.registrations', compact('registrations', 'extracurricular'));
    }
    
    public function getRegistrationDetail(ExtracurricularRegistration $registration)
    {
        try {
            $registration->load(['extracurricular', 'approvedBy']);
            return view('admin.extracurriculars.partials.registration-detail', compact('registration'));
        } catch (\Exception $e) {
            \Log::error('Error getting registration detail: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load registration detail: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function removeFromExtracurricular(ExtracurricularRegistration $registration)
    {
        try {
            $registration->update([
                'status' => 'removed',
                'approved_by' => auth()->id(),
                'notes' => 'Dikeluarkan dari ekstrakurikuler oleh admin'
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Siswa berhasil dikeluarkan dari ekstrakurikuler!'
                ]);
            }

            return redirect()->back()->with('success', 'Siswa berhasil dikeluarkan dari ekstrakurikuler!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengeluarkan siswa: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal mengeluarkan siswa: ' . $e->getMessage());
        }
    }
    
    // API Methods for AJAX calls
    public function getMembersJson(Extracurricular $extracurricular)
    {
        try {
            $members = $extracurricular->registrations()
                ->where('status', 'approved')
                ->latest()
                ->get()
                ->map(function ($registration) {
                    return [
                        'id' => $registration->id,
                        'name' => $registration->student_name,
                        'student_nis' => $registration->student_nis,
                        'class' => $registration->student_class . ' ' . $registration->student_major,
                        'status' => $registration->status,
                        'joined_at' => $registration->approved_at ? $registration->approved_at->format('Y-m-d') : $registration->created_at->format('Y-m-d'),
                        'email' => $registration->email,
                        'phone' => $registration->phone
                    ];
                });
                
            return response()->json([
                'success' => true,
                'members' => $members
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading members: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load members: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getRegistrationsJson(Extracurricular $extracurricular)
    {
        try {
            $registrations = $extracurricular->registrations()
                ->where('status', 'pending')
                ->latest()
                ->get()
                ->map(function ($registration) {
                    return [
                        'id' => $registration->id,
                        'student_name' => $registration->student_name,
                        'student_nis' => $registration->student_nis,
                        'student_class' => $registration->student_class . ' ' . $registration->student_major,
                        'email' => $registration->email,
                        'phone' => $registration->phone,
                        'status' => $registration->status,
                        'created_at' => $registration->created_at->format('Y-m-d'),
                        'reason' => $registration->reason,
                        'experience' => $registration->experience
                    ];
                });
                
            return response()->json([
                'success' => true,
                'registrations' => $registrations
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading registrations: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load registrations: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function updateMemberStatus(ExtracurricularRegistration $registration, Request $request)
    {
        try {
            $request->validate([
                'status' => 'required|in:approved,rejected,removed'
            ]);
            
            $registration->update([
                'status' => $request->status,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'notes' => $request->reason
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Status anggota berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function updateRegistrationStatus(ExtracurricularRegistration $registration, Request $request)
    {
        try {
            $request->validate([
                'status' => 'required|in:approved,rejected'
            ]);
            
            $registration->update([
                'status' => $request->status,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'notes' => $request->reason
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Status pendaftaran berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getAllPendingRegistrations()
    {
        try {
            $registrations = ExtracurricularRegistration::with(['extracurricular'])
                ->where('status', 'pending')
                ->latest()
                ->get()
                ->map(function ($registration) {
                    return [
                        'id' => $registration->id,
                        'student_name' => $registration->student_name,
                        'student_nis' => $registration->student_nis,
                        'student_class' => $registration->student_class . ' ' . $registration->student_major,
                        'email' => $registration->email,
                        'phone' => $registration->phone,
                        'status' => $registration->status,
                        'created_at' => $registration->created_at->format('Y-m-d'),
                        'reason' => $registration->reason,
                        'experience' => $registration->experience,
                        'extracurricular_name' => $registration->extracurricular ? $registration->extracurricular->name : 'N/A'
                    ];
                });
                
            return response()->json([
                'success' => true,
                'registrations' => $registrations
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading all pending registrations: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load pending registrations: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // New method for dedicated pending registrations page
    public function pendingRegistrationsPage(Request $request)
    {
        try {
            $query = ExtracurricularRegistration::with(['extracurricular', 'approvedBy']);
            
            // Filter by status (default to pending)
            $status = $request->get('status', 'pending');
            if ($status !== 'all') {
                $query->where('status', $status);
            }
            
            // Filter by extracurricular
            if ($request->filled('extracurricular_id')) {
                $query->where('extracurricular_id', $request->extracurricular_id);
            }
            
            // Filter by class
            if ($request->filled('student_class')) {
                $query->where('student_class', 'like', '%' . $request->student_class . '%');
            }
            
            // Search by name or NIS
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('student_name', 'like', '%' . $search . '%')
                      ->orWhere('student_nis', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
            
            $registrations = $query->latest()->paginate(20);
            $extracurriculars = Extracurricular::active()->get();
            
            // Statistics
            $totalRegistrations = ExtracurricularRegistration::count();
            $pendingRegistrations = ExtracurricularRegistration::where('status', 'pending')->count();
            $approvedRegistrations = ExtracurricularRegistration::where('status', 'approved')->count();
            $rejectedRegistrations = ExtracurricularRegistration::where('status', 'rejected')->count();
            
            // Recent activity
            $recentActivity = ExtracurricularRegistration::with(['extracurricular', 'approvedBy'])
                ->whereIn('status', ['approved', 'rejected'])
                ->latest()
                ->limit(10)
                ->get();
            
            return view('admin.extracurriculars.pending-registrations', compact(
                'registrations',
                'extracurriculars', 
                'totalRegistrations',
                'pendingRegistrations',
                'approvedRegistrations',
                'rejectedRegistrations',
                'recentActivity',
                'status'
            ));
        } catch (\Exception $e) {
            \Log::error('Error loading pending registrations page: ' . $e->getMessage());
            return redirect()->route('admin.extracurriculars.index')
                ->with('error', 'Failed to load pending registrations: ' . $e->getMessage());
        }
    }
    
    // Bulk approve registrations
    public function bulkApproveRegistrations(Request $request)
    {
        try {
            $request->validate([
                'registration_ids' => 'required|array',
                'registration_ids.*' => 'exists:extracurricular_registrations,id'
            ]);
            
            $count = ExtracurricularRegistration::whereIn('id', $request->registration_ids)
                ->where('status', 'pending')
                ->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                    'approved_by' => auth()->id(),
                ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Successfully approved {$count} registrations!",
                    'count' => $count
                ]);
            }
            
            return redirect()->back()->with('success', "Successfully approved {$count} registrations!");
        } catch (\Exception $e) {
            \Log::error('Error in bulk approve: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to approve registrations: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to approve registrations: ' . $e->getMessage());
        }
    }
    
    // Bulk reject registrations
    public function bulkRejectRegistrations(Request $request)
    {
        try {
            $request->validate([
                'registration_ids' => 'required|array',
                'registration_ids.*' => 'exists:extracurricular_registrations,id',
                'notes' => 'nullable|string|max:500'
            ]);
            
            $count = ExtracurricularRegistration::whereIn('id', $request->registration_ids)
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'approved_by' => auth()->id(),
                    'notes' => $request->notes,
                ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Successfully rejected {$count} registrations!",
                    'count' => $count
                ]);
            }
            
            return redirect()->back()->with('success', "Successfully rejected {$count} registrations!");
        } catch (\Exception $e) {
            \Log::error('Error in bulk reject: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to reject registrations: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to reject registrations: ' . $e->getMessage());
        }
    }
}