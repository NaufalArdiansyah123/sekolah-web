<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log, Schema};
use App\Models\{Student, User};
use App\Helpers\ClassHelper;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class FixedStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder yang diperbaiki untuk membuat siswa DAN user accounts dengan benar
     */
    public function run(): void
    {
        Log::info('Starting FixedStudentSeeder...');
        $this->command->info('🎓 Starting Fixed Student Seeder with User Accounts...');
        
        // Validasi prasyarat
        if (!$this->validatePrerequisites()) {
            return;
        }
        
        // Data siswa sample
        $studentsData = [
            // Kelas 10 TKJ
            ['name' => 'Ahmad Rizki Pratama', 'gender' => 'male', 'class' => '10 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Siti Nurhaliza', 'gender' => 'female', 'class' => '10 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Budi Santoso', 'gender' => 'male', 'class' => '10 TKJ 1', 'religion' => 'Kristen'],
            ['name' => 'Dewi Sartika', 'gender' => 'female', 'class' => '10 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Eko Prasetyo', 'gender' => 'male', 'class' => '10 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Fitri Handayani', 'gender' => 'female', 'class' => '10 TKJ 2', 'religion' => 'Islam'],
            ['name' => 'Galih Permana', 'gender' => 'male', 'class' => '10 TKJ 2', 'religion' => 'Islam'],
            ['name' => 'Hani Rahmawati', 'gender' => 'female', 'class' => '10 TKJ 2', 'religion' => 'Islam'],
            ['name' => 'Indra Gunawan', 'gender' => 'male', 'class' => '10 TKJ 2', 'religion' => 'Hindu'],
            ['name' => 'Joko Widodo', 'gender' => 'male', 'class' => '10 TKJ 2', 'religion' => 'Islam'],
            
            // Kelas 10 RPL
            ['name' => 'Kartika Sari', 'gender' => 'female', 'class' => '10 RPL 1', 'religion' => 'Islam'],
            ['name' => 'Lukman Hakim', 'gender' => 'male', 'class' => '10 RPL 1', 'religion' => 'Islam'],
            ['name' => 'Maya Sari', 'gender' => 'female', 'class' => '10 RPL 1', 'religion' => 'Kristen'],
            ['name' => 'Nanda Pratama', 'gender' => 'male', 'class' => '10 RPL 1', 'religion' => 'Islam'],
            ['name' => 'Olivia Rodrigo', 'gender' => 'female', 'class' => '10 RPL 1', 'religion' => 'Katolik'],
            ['name' => 'Putra Mahendra', 'gender' => 'male', 'class' => '10 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Qori Amelia', 'gender' => 'female', 'class' => '10 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Reza Fahlevi', 'gender' => 'male', 'class' => '10 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Sari Dewi', 'gender' => 'female', 'class' => '10 RPL 2', 'religion' => 'Hindu'],
            ['name' => 'Taufik Hidayat', 'gender' => 'male', 'class' => '10 RPL 2', 'religion' => 'Islam'],
        ];
        
        $currentYear = date('Y');
        $createdStudents = 0;
        $createdUsers = 0;
        $errors = 0;
        
        // Check if students already exist
        $existingStudentsCount = Student::count();
        if ($existingStudentsCount > 0) {
            $this->command->warn("⚠️  Students already exist ({$existingStudentsCount} records).");
            if (!$this->command->confirm('Do you want to create user accounts for existing students?', true)) {
                $this->command->info("✅ FixedStudentSeeder completed (skipped)!");
                return;
            }
            
            // Create users for existing students
            return $this->createUsersForExistingStudents();
        }
        
        DB::beginTransaction();
        
        try {
            // Get student role
            $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
            
            foreach ($studentsData as $index => $studentData) {
                try {
                    // Generate data
                    $generatedData = $this->generateStudentData($studentData, $index, $currentYear);
                    
                    // Create student
                    $student = Student::create($generatedData['student']);
                    $createdStudents++;
                    
                    // Create user account
                    $user = User::create($generatedData['user']);
                    $createdUsers++;
                    
                    // Assign student role
                    if ($studentRole) {
                        $user->assignRole($studentRole);
                    }
                    
                    // Update student with user_id
                    $student->update(['user_id' => $user->id]);
                    
                    Log::info("Created student and user", [
                        'student_name' => $student->name,
                        'student_nis' => $student->nis,
                        'user_email' => $user->email,
                        'user_id' => $user->id
                    ]);
                    
                } catch (\Exception $e) {
                    $errors++;
                    Log::error("Error creating student/user {$index}: " . $e->getMessage());
                    $this->command->error("❌ Error creating {$studentData['name']}: " . $e->getMessage());
                    continue;
                }
            }
            
            DB::commit();
            
            // Summary
            $this->command->info('');
            $this->command->info("✅ FixedStudentSeeder completed successfully!");
            $this->command->info("📊 Created {$createdStudents} students");
            $this->command->info("👤 Created {$createdUsers} user accounts");
            if ($errors > 0) {
                $this->command->warn("⚠️  {$errors} errors occurred");
            }
            $this->command->info("🔑 All passwords set to: 'password'");
            $this->command->info("📧 Email format: firstname.lastname@student.smk.sch.id");
            
            Log::info("FixedStudentSeeder completed", [
                'students_created' => $createdStudents,
                'users_created' => $createdUsers,
                'errors' => $errors
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $this->command->error("❌ FixedStudentSeeder failed: " . $e->getMessage());
            Log::error("FixedStudentSeeder failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Validasi prasyarat
     */
    private function validatePrerequisites(): bool
    {
        $this->command->info('🔍 Validating prerequisites...');
        
        // Check student role
        $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
        if (!$studentRole) {
            $this->command->error('❌ Student role not found. Please run RoleSeeder first.');
            return false;
        }
        
        $this->command->info('✅ Student role exists');
        
        // Check ClassHelper
        if (!class_exists('App\\Helpers\\ClassHelper')) {
            $this->command->warn('⚠️  ClassHelper not found. Will use simple grade parsing.');
        }
        
        return true;
    }
    
    /**
     * Generate data untuk student dan user
     */
    private function generateStudentData(array $studentData, int $index, int $currentYear): array
    {
        // Parse class untuk grade
        $grade = 10; // default
        if (class_exists('App\\Helpers\\ClassHelper')) {
            try {
                $classInfo = ClassHelper::parseClass($studentData['class']);
                $grade = $classInfo['grade'];
            } catch (\Exception $e) {
                // Use simple parsing
                preg_match('/(\d+)/', $studentData['class'], $matches);
                $grade = isset($matches[1]) ? (int)$matches[1] : 10;
            }
        } else {
            // Simple parsing
            preg_match('/(\d+)/', $studentData['class'], $matches);
            $grade = isset($matches[1]) ? (int)$matches[1] : 10;
        }
        
        // Generate NIS
        $sequenceNumber = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
        $nis = $currentYear . str_pad($grade, 2, '0', STR_PAD_LEFT) . $sequenceNumber;
        
        // Ensure unique NIS
        $attempts = 0;
        while (Student::where('nis', $nis)->exists() && $attempts < 100) {
            $sequenceNumber = str_pad(($index + 1) + $attempts + 1000, 3, '0', STR_PAD_LEFT);
            $nis = $currentYear . str_pad($grade, 2, '0', STR_PAD_LEFT) . $sequenceNumber;
            $attempts++;
        }
        
        // Generate NISN
        do {
            $nisn = '00' . rand(10000000, 99999999);
        } while (Student::where('nisn', $nisn)->exists());
        
        // Generate birth date
        $birthYear = $currentYear - (15 + ($grade - 10));
        $birthDate = Carbon::create($birthYear, rand(1, 12), rand(1, 28));
        
        // Generate email
        $emailName = strtolower(str_replace(' ', '.', $studentData['name']));
        $emailName = preg_replace('/[^a-z0-9.]/', '', $emailName);
        $email = $emailName . '@student.smk.sch.id';
        
        // Ensure unique email
        $emailAttempts = 1;
        while (Student::where('email', $email)->exists() || User::where('email', $email)->exists()) {
            $email = $emailName . $emailAttempts . '@student.smk.sch.id';
            $emailAttempts++;
        }
        
        // Generate other data
        $phone = '08' . rand(1000000000, 9999999999);
        $parentName = 'Bapak/Ibu ' . explode(' ', $studentData['name'])[0];
        $parentPhone = '08' . rand(1000000000, 9999999999);
        $address = 'Jl. Pendidikan No. ' . rand(1, 100) . ', Jakarta';
        $birthPlace = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang'][array_rand(['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang'])];
        
        // Student data
        $studentData = [
            'name' => $studentData['name'],
            'nis' => $nis,
            'nisn' => $nisn,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'class' => $studentData['class'],
            'birth_date' => $birthDate,
            'birth_place' => $birthPlace,
            'gender' => $studentData['gender'],
            'religion' => $studentData['religion'],
            'parent_name' => $parentName,
            'parent_phone' => $parentPhone,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // User data dengan field mapping yang benar
        $userData = [
            'name' => $studentData['name'],
            'email' => $email,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Add optional fields if they exist in users table
        $optionalFields = [
            'phone' => $phone,
            'address' => $address,
            'birth_date' => $birthDate,
            'birth_place' => $birthPlace,
            'gender' => $studentData['gender'],
            'nis' => $nis,
            'religion' => $studentData['religion'],
            'class' => $studentData['class'],
            'parent_name' => $parentName,
            'parent_phone' => $parentPhone,
            'enrollment_date' => now(),
        ];
        
        foreach ($optionalFields as $field => $value) {
            if (Schema::hasColumn('users', $field)) {
                $userData[$field] = $value;
            }
        }
        
        return [
            'student' => $studentData,
            'user' => $userData
        ];
    }
    
    /**
     * Buat user accounts untuk siswa yang sudah ada
     */
    private function createUsersForExistingStudents(): void
    {
        $this->command->info('🔄 Creating user accounts for existing students...');
        
        $students = Student::whereNull('user_id')->where('status', 'active')->get();
        
        if ($students->isEmpty()) {
            $this->command->info('✅ All students already have user accounts!');
            return;
        }
        
        $created = 0;
        $errors = 0;
        $studentRole = Role::where('name', 'student')->first();
        
        DB::beginTransaction();
        
        try {
            foreach ($students as $student) {
                try {
                    // Prepare user data
                    $userData = [
                        'name' => $student->name,
                        'email' => $student->email ?: $this->generateEmail($student->name),
                        'password' => Hash::make($student->nis ?: 'password'),
                        'email_verified_at' => now(),
                        'status' => 'active',
                    ];
                    
                    // Add optional fields
                    $optionalFields = [
                        'phone' => $student->phone,
                        'address' => $student->address,
                        'birth_date' => $student->birth_date,
                        'birth_place' => $student->birth_place,
                        'gender' => $student->gender,
                        'nis' => $student->nis,
                        'religion' => $student->religion,
                        'class' => $student->class,
                        'parent_name' => $student->parent_name,
                        'parent_phone' => $student->parent_phone,
                        'enrollment_date' => now(),
                    ];
                    
                    foreach ($optionalFields as $field => $value) {
                        if (Schema::hasColumn('users', $field) && $value) {
                            $userData[$field] = $value;
                        }
                    }
                    
                    // Create user
                    $user = User::create($userData);
                    
                    // Assign role
                    if ($studentRole) {
                        $user->assignRole($studentRole);
                    }
                    
                    // Update student
                    $student->update(['user_id' => $user->id]);
                    
                    $created++;
                    $this->command->info("✅ {$student->name} → {$user->email}");
                    
                } catch (\Exception $e) {
                    $errors++;
                    $this->command->error("❌ {$student->name}: " . $e->getMessage());
                }
            }
            
            DB::commit();
            
            $this->command->info('');
            $this->command->info("✅ Created {$created} user accounts for existing students");
            if ($errors > 0) {
                $this->command->warn("⚠️  {$errors} errors occurred");
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    
    /**
     * Generate email untuk student
     */
    private function generateEmail(string $name): string
    {
        $cleanName = strtolower(str_replace(' ', '.', $name));
        $cleanName = preg_replace('/[^a-z0-9.]/', '', $cleanName);
        $email = $cleanName . '@student.smk.sch.id';
        
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $cleanName . $counter . '@student.smk.sch.id';
            $counter++;
        }
        
        return $email;
    }
}