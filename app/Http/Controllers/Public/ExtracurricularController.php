<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Extracurricular;
use App\Models\ExtracurricularRegistration;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $extracurriculars = Extracurricular::active()
            ->with(['registrations'])
            ->withCount(['registrations', 'pendingRegistrations', 'approvedRegistrations'])
            ->paginate(12);

        $categories = [
            'Olahraga' => ['Sepak Bola', 'Basket', 'Voli', 'Badminton', 'Tenis Meja', 'Atletik'],
            'Seni' => ['Musik', 'Tari', 'Teater', 'Seni Rupa', 'Fotografi', 'Sinematografi'],
            'Akademik' => ['Olimpiade Matematika', 'Olimpiade Fisika', 'Olimpiade Kimia', 'Olimpiade Biologi', 'Debat', 'Jurnalistik'],
            'Teknologi' => ['Robotika', 'Programming', 'Multimedia', 'Web Design'],
            'Sosial' => ['PMR', 'Pramuka', 'Rohis', 'Pecinta Alam', 'Volunteer']
        ];

        return view('public.extracurriculars.index', compact('extracurriculars', 'categories'));
    }

    public function show(Extracurricular $extracurricular)
    {
        $extracurricular->loadCount([
            'registrations as registration_count',
            'pendingRegistrations as pending_count',
            'approvedRegistrations as approved_count'
        ]);
        
        $extracurricular->load(['registrations' => function($query) {
            $query->latest()->take(5);
        }]);

        $relatedExtracurriculars = Extracurricular::active()
            ->where('id', '!=', $extracurricular->id)
            ->take(3)
            ->get();

        return view('public.extracurriculars.show', compact('extracurricular', 'relatedExtracurriculars'));
    }

    public function register(Extracurricular $extracurricular)
    {
        if ($extracurricular->status !== 'active') {
            return redirect()->route('public.extracurriculars.index')
                ->with('error', 'Ekstrakurikuler ini sedang tidak menerima pendaftaran.');
        }

        return view('public.extracurriculars.register', compact('extracurricular'));
    }

    public function storeRegistration(Request $request, Extracurricular $extracurricular)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'student_class' => 'required|string|max:50',
            'student_major' => 'required|string|max:100',
            'student_nis' => 'required|string|max:20|unique:extracurricular_registrations,student_nis',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'reason' => 'required|string',
            'experience' => 'nullable|string',
        ], [
            'student_name.required' => 'Nama siswa wajib diisi.',
            'student_class.required' => 'Kelas wajib diisi.',
            'student_major.required' => 'Jurusan wajib diisi.',
            'student_nis.required' => 'NIS wajib diisi.',
            'student_nis.unique' => 'NIS sudah terdaftar untuk ekstrakurikuler lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'parent_name.required' => 'Nama orang tua wajib diisi.',
            'parent_phone.required' => 'Nomor telepon orang tua wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'reason.required' => 'Alasan bergabung wajib diisi.',
        ]);

        // Check if student already registered for this extracurricular
        $existingRegistration = ExtracurricularRegistration::where('extracurricular_id', $extracurricular->id)
            ->where('student_nis', $request->student_nis)
            ->first();

        if ($existingRegistration) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Anda sudah terdaftar untuk ekstrakurikuler ini.');
        }

        $registration = ExtracurricularRegistration::create([
            'extracurricular_id' => $extracurricular->id,
            'student_name' => $request->student_name,
            'student_class' => $request->student_class,
            'student_major' => $request->student_major,
            'student_nis' => $request->student_nis,
            'email' => $request->email,
            'phone' => $request->phone,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'address' => $request->address,
            'reason' => $request->reason,
            'experience' => $request->experience,
            'status' => 'pending',
            'registered_at' => now(),
        ]);

        return redirect()->route('public.extracurriculars.show', $extracurricular)
            ->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu konfirmasi dari admin.');
    }

    public function checkRegistration(Request $request)
    {
        $request->validate([
            'student_nis' => 'required|string',
        ]);

        $registrations = ExtracurricularRegistration::with('extracurricular')
            ->where('student_nis', $request->student_nis)
            ->latest()
            ->get();

        return view('public.extracurriculars.check', compact('registrations'));
    }
}