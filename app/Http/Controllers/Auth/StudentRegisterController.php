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
use App\Models\Setting;

class StudentRegisterController extends Controller
{
    /**
     * Show the student account registration form (Tampilkan form pendaftaran akun siswa).
     */
    public function showRegistrationForm()
    {
        // Check if registration is allowed
        $allowRegistration = Setting::get('allow_registration', '1');
        
        if ($allowRegistration !== '1') {
            return view('auth.registration-closed')
                ->with('message', 'Pendaftaran akun siswa saat ini sedang ditutup. Silakan hubungi administrator sekolah untuk informasi lebih lanjut.');
        }
        
        return view('auth.student-register');
    }
    
    /**
     * Check if student exists in database and return data
     */
    public function checkStudentData(Request $request)
    {
        // Check if registration is allowed
        $allowRegistration = Setting::get('allow_registration', '1');
        
        if ($allowRegistration !== '1') {
            return response()->json([
                'exists' => false,
                'message' => 'Pendaftaran akun siswa saat ini sedang ditutup'
            ], 403);
        }
        
        try {
            $nis = $request->get('nis');
            
            if (!$nis) {
                return response()->json([
                    'exists' => false,
                    'message' => 'NIS tidak boleh kosong'
                ]);
            }
            
            // Validate NIS format
            if (!preg_match('/^[0-9]{8,20}$/', $nis)) {
                return response()->json([
                    'exists' => false,
                    'message' => 'Format NIS tidak valid. NIS harus berupa angka 8-20 digit.'
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
                        'name' => $student->name ?? '',
                        'nis' => $student->nis ?? '',
                        'email' => $student->email ?? '',
                        'phone' => $student->phone ?? '',
                        'address' => $student->address ?? '',
                        'class' => $student->class ?? '',
                        'birth_date' => $student->birth_date ? $student->birth_date->format('Y-m-d') : '',
                        'birth_place' => $student->birth_place ?? '',
                        'gender' => $student->gender ?? '',
                        'religion' => $student->religion ?? '',
                        'parent_name' => $student->parent_name ?? '',
                        'parent_phone' => $student->parent_phone ?? '',
                    ]
                ]);
            }
            
            return response()->json([
                'exists' => false,
                'message' => 'Data siswa tidak ditemukan. Silakan isi form secara manual.'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error checking student data: ' . $e->getMessage());
            return response()->json([
                'exists' => false,
                'message' => 'Terjadi kesalahan saat memeriksa data siswa. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Handle a student account registration request (Tangani permintaan pendaftaran akun siswa).
     */
    public function register(Request $request)
    {
        // Check if registration is allowed
        $allowRegistration = Setting::get('allow_registration', '1');
        
        if ($allowRegistration !== '1') {
            return redirect()->route('home')
                ->with('error', 'Pendaftaran akun siswa saat ini sedang ditutup.');
        }
        
        try {
            // Validate the request
            $this->validator($request->all())->validate();

            // Create the user
            $user = $this->create($request->all());

            // Fire the registered event
            event(new Registered($user));

            // Check if user was auto-approved (student exists in database)
            $student = Student::where('nis', $request->nis)->first();
            
            if ($student) {
                // Auto-approved, redirect to login
                return redirect()->route('login')
                    ->with('success', 'Pendaftaran akun siswa berhasil! Akun Anda telah diaktifkan karena data ditemukan dalam database siswa. Silakan login.');
            } else {
                // Needs manual approval
                return redirect()->route('student.registration.pending')
                    ->with('success', 'Pendaftaran akun siswa berhasil! Akun Anda sedang menunggu konfirmasi dari admin. Anda akan dapat login setelah akun dikonfirmasi.');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors will be handled by Laravel automatically
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Student registration error: ' . $e->getMessage(), [
                'nis' => $request->nis,
                'email' => $request->email,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Terjadi kesalahan saat mendaftarkan akun siswa. Silakan coba lagi atau hubungi administrator.');
        }
    }

    /**
     * Show account registration pending confirmation page
     */
    public function showPendingPage()
    {
        return view('auth.registration-pending');
    }

    /**
     * Get a validator for an incoming account registration request.
     */
    protected function validator(array $data)
    {
        try {
            $validClasses = ClassHelper::getNewStudentClasses();
            
            $rules = [
                'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
                'nis' => ['required', 'string', 'max:20', 'unique:users,nis', 'regex:/^[0-9]{8,20}$/'],
                'phone' => ['nullable', 'string', 'max:15', 'regex:/^[0-9+\-\s]+$/'],
                'birth_date' => ['required', 'date', 'before:today'],
                'birth_place' => ['required', 'string', 'max:100'],
                'gender' => ['required', 'in:male,female'],
                'religion' => ['required', 'string', 'max:50'],
                'address' => ['required', 'string', 'max:500'],
                'class' => ['required', 'string', 'in:' . implode(',', $validClasses)],
                'parent_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'parent_phone' => ['required', 'string', 'max:15', 'regex:/^[0-9+\-\s]+$/'],
                'parent_email' => ['nullable', 'email', 'max:255'],
            ];
            
            // Check if student exists in database
            $student = Student::where('nis', $data['nis'] ?? '')->first();
            if ($student) {
                // If student exists, validate that NIS exists in students table
                $rules['nis'] = ['required', 'string', 'max:20', 'unique:users,nis', 'exists:students,nis', 'regex:/^[0-9]{8,20}$/'];
                // Allow any valid class for existing students
                $allValidClasses = ClassHelper::getAllClasses();
                $rules['class'] = ['required', 'string', 'in:' . implode(',', $allValidClasses)];
            }
            
            return Validator::make($data, $rules, [
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
                'nis.required' => 'NIS wajib diisi.',
                'nis.unique' => 'NIS sudah terdaftar.',
                'nis.exists' => 'NIS tidak ditemukan dalam database siswa.',
                'nis.regex' => 'NIS harus berupa angka 8-20 digit.',
                'phone.max' => 'Nomor telepon maksimal 15 karakter.',
                'phone.regex' => 'Format nomor telepon tidak valid.',
                'birth_date.required' => 'Tanggal lahir wajib diisi.',
                'birth_date.date' => 'Format tanggal lahir tidak valid.',
                'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
                'birth_place.required' => 'Tempat lahir wajib diisi.',
                'gender.required' => 'Jenis kelamin wajib dipilih.',
                'gender.in' => 'Jenis kelamin tidak valid.',
                'religion.required' => 'Agama wajib diisi.',
                'address.required' => 'Alamat wajib diisi.',
                'class.required' => 'Kelas wajib dipilih.',
                'class.in' => 'Kelas yang dipilih tidak valid. Hanya kelas 10 yang tersedia untuk pendaftaran akun.',
                'parent_name.required' => 'Nama orang tua wajib diisi.',
                'parent_name.regex' => 'Nama orang tua hanya boleh berisi huruf dan spasi.',
                'parent_phone.required' => 'Nomor telepon orang tua wajib diisi.',
                'parent_phone.regex' => 'Format nomor telepon orang tua tidak valid.',
                'parent_email.email' => 'Format email orang tua tidak valid.',
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Validation error in StudentRegisterController: ' . $e->getMessage());
            throw new \Exception('Terjadi kesalahan dalam validasi data.');
        }
    }
        

    /**
     * Create a new user instance after a valid account registration.
     */
    protected function create(array $data)
    {
        return \DB::transaction(function () use ($data) {
            try {
                // Check if student exists in students table
                $student = Student::where('nis', $data['nis'])->first();
                
                // Create user account
                $user = User::create([
                    'name' => trim($data['name']),
                    'email' => strtolower(trim($data['email'])),
                    'password' => Hash::make($data['password']),
                    'nis' => $data['nis'],
                    'phone' => $data['phone'] ?? null,
                    'birth_date' => $data['birth_date'],
                    'birth_place' => trim($data['birth_place']),
                    'gender' => $data['gender'],
                    'religion' => trim($data['religion']),
                    'address' => trim($data['address']),
                    'class' => $data['class'],
                    'parent_name' => trim($data['parent_name']),
                    'parent_phone' => $data['parent_phone'],
                    'parent_email' => $data['parent_email'] ? strtolower(trim($data['parent_email'])) : null,
                    'status' => $student ? 'active' : 'pending', // Auto-approve if student exists in database
                    'enrollment_date' => now(),
                    'approved_at' => $student ? now() : null,
                ]);

                // Assign student role
                $studentRole = Role::where('name', 'student')->first();
                if ($studentRole) {
                    $user->assignRole($studentRole);
                } else {
                    \Log::warning('Student role not found when creating user account', ['user_id' => $user->id]);
                }
                
                // Link user to student record if exists
                if ($student) {
                    $student->update(['user_id' => $user->id]);
                    \Log::info('User linked to existing student record', [
                        'user_id' => $user->id,
                        'student_id' => $student->id,
                        'nis' => $data['nis']
                    ]);
                } else {
                    \Log::info('New user created without existing student record', [
                        'user_id' => $user->id,
                        'nis' => $data['nis']
                    ]);
                }

                return $user;
                
            } catch (\Exception $e) {
                \Log::error('Error creating user account: ' . $e->getMessage(), [
                    'nis' => $data['nis'] ?? 'unknown',
                    'email' => $data['email'] ?? 'unknown',
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
        });
    }

    /**
     * Check NIS availability and student data
     */
    public function checkNis(Request $request)
    {
        // Check if registration is allowed
        $allowRegistration = Setting::get('allow_registration', '1');
        
        if ($allowRegistration !== '1') {
            return response()->json([
                'available' => false,
                'message' => 'Pendaftaran akun siswa saat ini sedang ditutup'
            ], 403);
        }
        
        try {
            $nis = $request->get('nis');
            
            if (!$nis) {
                return response()->json([
                    'available' => false,
                    'message' => 'NIS tidak boleh kosong'
                ]);
            }
            
            // Validate NIS format
            if (!preg_match('/^[0-9]{8,20}$/', $nis)) {
                return response()->json([
                    'available' => false,
                    'message' => 'Format NIS tidak valid. NIS harus berupa angka 8-20 digit.'
                ]);
            }
            
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
            
        } catch (\Exception $e) {
            \Log::error('Error checking NIS availability: ' . $e->getMessage());
            return response()->json([
                'available' => false,
                'message' => 'Terjadi kesalahan saat memeriksa NIS. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Check email availability
     */
    public function checkEmail(Request $request)
    {
        // Check if registration is allowed
        $allowRegistration = Setting::get('allow_registration', '1');
        
        if ($allowRegistration !== '1') {
            return response()->json([
                'available' => false,
                'message' => 'Pendaftaran akun siswa saat ini sedang ditutup'
            ], 403);
        }
        
        try {
            $email = $request->get('email');
            
            if (!$email) {
                return response()->json([
                    'available' => false,
                    'message' => 'Email tidak boleh kosong'
                ]);
            }
            
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'available' => false,
                    'message' => 'Format email tidak valid'
                ]);
            }
            
            $exists = User::where('email', strtolower(trim($email)))->exists();
            
            return response()->json([
                'available' => !$exists,
                'message' => $exists ? 'Email sudah terdaftar' : 'Email tersedia'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error checking email availability: ' . $e->getMessage());
            return response()->json([
                'available' => false,
                'message' => 'Terjadi kesalahan saat memeriksa email. Silakan coba lagi.'
            ], 500);
        }
    }
}