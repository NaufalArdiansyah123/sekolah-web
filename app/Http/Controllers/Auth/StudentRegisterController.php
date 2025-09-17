<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class StudentRegisterController extends Controller
{
    /**
     * Show the student registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.student-register');
    }

    /**
     * Handle a student registration request.
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        // Don't auto-login, redirect to confirmation page
        return redirect()->route('student.registration.pending')
            ->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu konfirmasi dari admin. Anda akan dapat login setelah akun dikonfirmasi.');
    }

    /**
     * Show registration pending confirmation page
     */
    public function showPendingPage()
    {
        return view('auth.registration-pending');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nis' => ['required', 'string', 'max:20', 'unique:users,nis'],
            'phone' => ['nullable', 'string', 'max:15'],
            'birth_date' => ['required', 'date'],
            'birth_place' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:male,female'],
            'religion' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:500'],
            'class' => ['required', 'string', 'max:10'],
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_phone' => ['required', 'string', 'max:15'],
            'parent_email' => ['nullable', 'email', 'max:255'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'phone.max' => 'Nomor telepon maksimal 15 karakter.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'religion.required' => 'Agama wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'class.required' => 'Kelas wajib dipilih.',
            'parent_name.required' => 'Nama orang tua wajib diisi.',
            'parent_phone.required' => 'Nomor telepon orang tua wajib diisi.',
            'parent_email.email' => 'Format email orang tua tidak valid.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nis' => $data['nis'],
            'phone' => $data['phone'] ?? null,
            'birth_date' => $data['birth_date'],
            'birth_place' => $data['birth_place'],
            'gender' => $data['gender'],
            'religion' => $data['religion'],
            'address' => $data['address'],
            'class' => $data['class'],
            'parent_name' => $data['parent_name'],
            'parent_phone' => $data['parent_phone'],
            'parent_email' => $data['parent_email'] ?? null,
            'status' => 'pending', // Status pending untuk review admin
            'enrollment_date' => now(),
        ]);

        // Assign student role
        $studentRole = Role::where('name', 'student')->first();
        if ($studentRole) {
            $user->assignRole($studentRole);
        }

        return $user;
    }

    /**
     * Check NIS availability
     */
    public function checkNis(Request $request)
    {
        $nis = $request->get('nis');
        $exists = User::where('nis', $nis)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'NIS sudah terdaftar' : 'NIS tersedia'
        ]);
    }

    /**
     * Check email availability
     */
    public function checkEmail(Request $request)
    {
        $email = $request->get('email');
        $exists = User::where('email', $email)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Email sudah terdaftar' : 'Email tersedia'
        ]);
    }
}