<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Helpers\ClassHelper;
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
     * Check if student exists in database and return data
     */
    public function checkStudentData(Request $request)
    {
        $nis = $request->get('nis');
        
        if (!$nis) {
            return response()->json([
                'exists' => false,
                'message' => 'NIS tidak boleh kosong'
            ]);
        }
        
        // Check if student exists in students table
        $student = Student::where('nis', $nis)->first();
        
        if ($student) {
            // Check if user account already exists
            $existingUser = User::where('nis', $nis)->first();
            
            if ($existingUser) {
                return response()->json([
                    'exists' => true,
                    'hasAccount' => true,
                    'message' => 'Siswa sudah memiliki akun. Silakan login.',
                    'data' => null
                ]);
            }
            
            return response()->json([
                'exists' => true,
                'hasAccount' => false,
                'message' => 'Data siswa ditemukan. Form akan diisi otomatis.',
                'data' => [
                    'name' => $student->name,
                    'nis' => $student->nis,
                    'email' => $student->email,
                    'phone' => $student->phone,
                    'address' => $student->address,
                    'class' => $student->class,
                    'birth_date' => $student->birth_date ? $student->birth_date->format('Y-m-d') : '',
                    'birth_place' => $student->birth_place,
                    'gender' => $student->gender,
                    'religion' => $student->religion,
                    'parent_name' => $student->parent_name,
                    'parent_phone' => $student->parent_phone,
                ]
            ]);
        }
        
        return response()->json([
            'exists' => false,
            'message' => 'Data siswa tidak ditemukan. Silakan isi form secara manual.'
        ]);
    }

    /**
     * Handle a student registration request.
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        // Check if user was auto-approved (student exists in database)
        $student = Student::where('nis', $request->nis)->first();
        
        if ($student) {
            // Auto-approved, redirect to login
            return redirect()->route('login')
                ->with('success', 'Pendaftaran berhasil! Akun Anda telah diaktifkan karena data ditemukan dalam database siswa. Silakan login.');
        } else {
            // Needs manual approval
            return redirect()->route('student.registration.pending')
                ->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu konfirmasi dari admin. Anda akan dapat login setelah akun dikonfirmasi.');
        }
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
        $validClasses = ClassHelper::getNewStudentClasses();
        
        $rules = [
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
            'class' => ['required', 'string', 'in:' . implode(',', $validClasses)],
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_phone' => ['required', 'string', 'max:15'],
            'parent_email' => ['nullable', 'email', 'max:255'],
        ];
        
        // Check if student exists in database
        $student = Student::where('nis', $data['nis'] ?? '')->first();
        if ($student) {
            // If student exists, validate that NIS exists in students table
            $rules['nis'] = ['required', 'string', 'max:20', 'unique:users,nis', 'exists:students,nis'];
            // Allow any valid class for existing students
            $allValidClasses = ClassHelper::getAllClasses();
            $rules['class'] = ['required', 'string', 'in:' . implode(',', $allValidClasses)];
        }
        
        return Validator::make($data, $rules, [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nis.exists' => 'NIS tidak ditemukan dalam database siswa.',
            'phone.max' => 'Nomor telepon maksimal 15 karakter.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'religion.required' => 'Agama wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'class.required' => 'Kelas wajib dipilih.',
            'class.in' => 'Kelas yang dipilih tidak valid. Hanya kelas 10 yang tersedia untuk pendaftaran.',
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
        // Check if student exists in students table
        $student = Student::where('nis', $data['nis'])->first();
        
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
            'status' => $student ? 'active' : 'pending', // Auto-approve if student exists in database
            'enrollment_date' => now(),
            'approved_at' => $student ? now() : null,
        ]);

        // Assign student role
        $studentRole = Role::where('name', 'student')->first();
        if ($studentRole) {
            $user->assignRole($studentRole);
        }
        
        // Link user to student record if exists
        if ($student) {
            $student->update(['user_id' => $user->id]);
        }

        return $user;
    }

    /**
     * Check NIS availability and student data
     */
    public function checkNis(Request $request)
    {
        $nis = $request->get('nis');
        
        // Check if user account already exists
        $userExists = User::where('nis', $nis)->exists();
        if ($userExists) {
            return response()->json([
                'available' => false,
                'message' => 'NIS sudah terdaftar sebagai akun'
            ]);
        }
        
        // Check if student exists in students table
        $student = Student::where('nis', $nis)->first();
        if ($student) {
            return response()->json([
                'available' => true,
                'inDatabase' => true,
                'message' => 'NIS ditemukan dalam database siswa'
            ]);
        }
        
        return response()->json([
            'available' => true,
            'inDatabase' => false,
            'message' => 'NIS tersedia (tidak ditemukan dalam database siswa)'
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