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

    public function showRegistration(ExtracurricularRegistration $registration)
    {
        $registration->load(['extracurricular', 'approvedBy']);
        return view('admin.extracurriculars.show-registration', compact('registration'));
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
    
    public function showRegistrationDetail(ExtracurricularRegistration $registration)
    {
        $registration->load(['extracurricular', 'approvedBy']);
        return view('admin.extracurriculars.partials.registration-detail', compact('registration'));
    }
    
    public function getRegistrationDetail(ExtracurricularRegistration $registration)
    {
        $registration->load(['extracurricular', 'approvedBy']);
        return view('admin.extracurriculars.partials.registration-detail', compact('registration'));
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
}