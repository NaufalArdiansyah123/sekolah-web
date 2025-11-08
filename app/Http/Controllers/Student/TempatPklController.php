<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\TempatPkl;
use App\Models\PklRegistration;
use Illuminate\Http\Request;

class TempatPklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if student is in class 11
        $student = auth()->user()->student;
        if (!$student || !$student->class || $student->class->level != '11') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk siswa kelas 11.');
        }

        // Check if student already has a PKL registration
        $existingRegistration = PklRegistration::where('student_id', auth()->id())->first();

        // If reset parameter is present and registration is rejected, allow reapplication
        if ($request->has('reset') && $request->reset == 'true' && $existingRegistration && $existingRegistration->isRejected()) {
            // Delete the rejected registration to allow reapplication
            $existingRegistration->delete();
            $existingRegistration = null;
        }

        if ($existingRegistration && !$existingRegistration->isRejected()) {
            // Student has active registration (pending or approved), show status page
            return view('student.tempat-pkl.index', compact('existingRegistration'));
        }

        // Student hasn't registered, show available tempat PKL
        $query = TempatPkl::query();

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tempat', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('pembimbing_lapangan', 'like', "%{$search}%");
            });
        }

        $tempatPkls = $query->orderBy('nama_tempat')->paginate(12);

        return view('student.tempat-pkl.index', compact('tempatPkls'));
    }

    /**
     * Display the specified resource.
     */
    public function show(TempatPkl $tempatPkl)
    {
        // Check if student is in class 11
        $student = auth()->user()->student;
        if (!$student || !$student->class || $student->class->level != '11') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk siswa kelas 11.');
        }

        // Load approved registrations with student details
        $tempatPkl->load([
            'approvedRegistrations' => function ($query) {
                $query->with('student');
            }
        ]);

        return view('student.tempat-pkl.show', compact('tempatPkl'));
    }

    /**
     * Store a newly created PKL registration.
     */
    public function store(Request $request)
    {
        // Check if student is in class 11
        $student = auth()->user()->student;
        if (!$student || !$student->class || $student->class->level != '11') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk siswa kelas 11.');
        }

        $request->validate([
            'tempat_pkl_id' => 'required|exists:tempat_pkls,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'alasan' => 'required|string|min:50|max:1000',
            'surat_pengantar' => 'required|file|mimes:pdf|max:2048',
            'catatan' => 'nullable|string|max:500',
        ]);

        $tempatPkl = TempatPkl::findOrFail($request->tempat_pkl_id);

        // Check if student already registered for this tempat PKL
        $existingRegistration = PklRegistration::where('student_id', auth()->id())
            ->where('tempat_pkl_id', $tempatPkl->id)
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'Anda sudah mendaftar untuk tempat PKL ini.');
        }

        // Check if kuota is available
        if ($tempatPkl->kuota_tersedia <= 0) {
            return back()->with('error', 'Kuota untuk tempat PKL ini sudah penuh.');
        }

        // Handle file upload
        $suratPengantarPath = null;
        if ($request->hasFile('surat_pengantar')) {
            $suratPengantarPath = $request->file('surat_pengantar')->store('surat-pengantar', 'public');
        }

        PklRegistration::create([
            'student_id' => auth()->id(),
            'tempat_pkl_id' => $tempatPkl->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'surat_pengantar' => $suratPengantarPath,
            'catatan' => $request->catatan,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran PKL berhasil diajukan. Silakan tunggu konfirmasi dari admin.');
    }
}
