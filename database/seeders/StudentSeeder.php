<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log};
use App\Models\{Student, User, Classes, AcademicYear};
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini akan membuat:
     * - Kelas-kelas aktif untuk tahun ajaran saat ini
     * - 10 siswa per kelas
     * - Akun user untuk setiap siswa (langsung approved)
     */
    public function run(): void
    {
        Log::info('Starting StudentSeeder...');
        
        $this->command->info('🧹 Cleaning existing student data...');
        $this->cleanupExistingData();
        
        $this->command->info('📚 Creating academic year and classes...');
        $academicYear = $this->createAcademicYear();
        $classes = $this->createClasses($academicYear);
        
        $this->command->info('👨‍🎓 Creating students...');
        $this->createStudents($classes);
        
        $this->command->info('✅ StudentSeeder completed successfully!');
        $this->displaySummary();
        
        Log::info('StudentSeeder completed successfully');
    }
    
    /**
     * Clean up existing student data
     */
    private function cleanupExistingData()
    {
        // Delete existing students and their users
        $existingStudents = Student::with('user')->get();
        foreach ($existingStudents as $student) {
            if ($student->user) {
                $student->user->delete(); // This will also delete the student due to cascade
            } else {
                $student->delete();
            }
        }
        
        $this->command->info('   ✅ Cleaned existing student data');
    }
    
    /**
     * Create or get academic year
     */
    private function createAcademicYear()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        
        $academicYear = AcademicYear::firstOrCreate(
            ['name' => $currentYear . '/' . $nextYear],
            [
                'start_date' => $currentYear . '-07-01',
                'end_date' => $nextYear . '-06-30',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        
        $this->command->info("   ✅ Academic year: {$academicYear->name}");
        return $academicYear;
    }
    
    /**
     * Create active classes for current academic year
     */
    private function createClasses($academicYear)
    {
        $classesData = [
            // Kelas 10
            ['name' => '10 TKJ 1', 'level' => '10', 'program' => null],
            ['name' => '10 TKJ 2', 'level' => '10', 'program' => null],
            ['name' => '10 RPL 1', 'level' => '10', 'program' => null],
            ['name' => '10 RPL 2', 'level' => '10', 'program' => null],
            ['name' => '10 DKV 1', 'level' => '10', 'program' => null],
            
            // Kelas 11
            ['name' => '11 TKJ 1', 'level' => '11', 'program' => null],
            ['name' => '11 TKJ 2', 'level' => '11', 'program' => null],
            ['name' => '11 RPL 1', 'level' => '11', 'program' => null],
            ['name' => '11 RPL 2', 'level' => '11', 'program' => null],
            ['name' => '11 DKV 1', 'level' => '11', 'program' => null],
            
            // Kelas 12
            ['name' => '12 TKJ 1', 'level' => '12', 'program' => null],
            ['name' => '12 TKJ 2', 'level' => '12', 'program' => null],
            ['name' => '12 RPL 1', 'level' => '12', 'program' => null],
            ['name' => '12 RPL 2', 'level' => '12', 'program' => null],
            ['name' => '12 DKV 1', 'level' => '12', 'program' => null],
        ];
        
        $classes = [];
        foreach ($classesData as $classData) {
            $code = strtoupper(str_replace(' ', '', $classData['name']));
            
            $class = Classes::firstOrCreate(
                ['name' => $classData['name']],
                [
                    'code' => $code,
                    'level' => $classData['level'],
                    'program' => $classData['program'],
                    'capacity' => 30,
                    'academic_year_id' => $academicYear->id,
                    'description' => 'Kelas aktif tahun ajaran ' . $academicYear->name,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            
            $classes[] = $class;
            $this->command->info("   ✅ Class: {$class->name}");
        }
        
        return $classes;
    }
    
    /**
     * Create students for each class
     */
    private function createStudents($classes)
    {
        // Ensure student role exists
        $studentRole = Role::firstOrCreate([
            'name' => 'student',
            'guard_name' => 'web'
        ]);
        
        // Get or create admin user for approval
        $adminUser = User::first(); // Get first user (usually admin)
        if (!$adminUser) {
            // Create admin user if none exists
            $adminUser = User::create([
                'name' => 'System Admin',
                'email' => 'admin@system.local',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Assign admin role if exists
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $adminUser->assignRole($adminRole);
            }
        }
        
        $totalStudents = 0;
        $totalUsers = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($classes as $class) {
                $this->command->info("   📝 Creating students for {$class->name}...");
                
                for ($i = 1; $i <= 10; $i++) {
                    $studentData = $this->generateStudentData($class, $i);
                    
                    // Create user account first
                    $user = User::create([
                        'name' => $studentData['name'],
                        'email' => $studentData['email'],
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'status' => 'active', // Status aktif
                        'approved_at' => now(), // Langsung approved
                        'approved_by' => $adminUser->id, // Approved by admin
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    // Assign student role
                    $user->assignRole($studentRole);
                    $totalUsers++;
                    
                    // Create student record
                    $student = Student::create([
                        'name' => $studentData['name'],
                        'nis' => $studentData['nis'],
                        'nisn' => $studentData['nisn'],
                        'email' => $studentData['email'],
                        'phone' => $studentData['phone'],
                        'address' => $studentData['address'],
                        'class_id' => $class->id,
                        'birth_date' => $studentData['birth_date'],
                        'birth_place' => $studentData['birth_place'],
                        'gender' => $studentData['gender'],
                        'religion' => $studentData['religion'],
                        'parent_name' => $studentData['parent_name'],
                        'parent_phone' => $studentData['parent_phone'],
                        'status' => 'active',
                        'user_id' => $user->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    $totalStudents++;
                }
                
                $this->command->info("      ✅ Created 10 students for {$class->name}");
            }
            
            DB::commit();
            
            $this->command->info("✅ Total created: {$totalStudents} students, {$totalUsers} user accounts");
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $this->command->error("❌ StudentSeeder failed: " . $e->getMessage());
            Log::error("StudentSeeder failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Generate student data
     */
    private function generateStudentData($class, $studentNumber)
    {
        $currentYear = date('Y');
        
        // Generate names (Indonesian names)
        $maleNames = [
            'Ahmad Rizki', 'Budi Santoso', 'Dedi Setiawan', 'Eko Prasetyo', 'Fajar Nugroho',
            'Galih Permana', 'Hendra Wijaya', 'Indra Gunawan', 'Joko Widodo', 'Lukman Hakim',
            'Muhammad Iqbal', 'Nanda Pratama', 'Oki Setiawan', 'Putra Mahendra', 'Reza Fahlevi',
            'Sandi Pratama', 'Taufik Hidayat', 'Umar Bakri', 'Vino Bastian', 'Wahyu Hidayat',
            'Xavier Nugraha', 'Yudi Setiawan', 'Zaki Rahman', 'Arif Rahman', 'Bayu Skak'
        ];
        
        $femaleNames = [
            'Siti Nurhaliza', 'Dewi Sartika', 'Fitri Handayani', 'Hani Rahmawati', 'Kartika Sari',
            'Maya Sari', 'Olivia Rodrigo', 'Qori Amelia', 'Sari Dewi', 'Umi Kalsum',
            'Wulan Guritno', 'Yuni Shara', 'Anisa Rahma', 'Citra Kirana', 'Elly Sugigi',
            'Gita Gutawa', 'Ira Wibowo', 'Kirana Larasati', 'Maudy Ayunda', 'Olla Ramlan',
            'Queenita Siregar', 'Sandra Dewi', 'Ussy Sulistiawaty', 'Wika Salim', 'Yuki Kato'
        ];
        
        $gender = rand(0, 1) ? 'male' : 'female';
        $names = $gender === 'male' ? $maleNames : $femaleNames;
        $name = $names[array_rand($names)] . ' ' . chr(65 + $studentNumber - 1); // Add letter suffix
        
        // Generate unique NIS
        $classLevel = $class->level;
        $nis = $currentYear . $classLevel . str_pad($class->id, 2, '0', STR_PAD_LEFT) . str_pad($studentNumber, 2, '0', STR_PAD_LEFT);
        
        // Generate unique NISN
        do {
            $nisn = '00' . rand(10000000, 99999999);
        } while (Student::where('nisn', $nisn)->exists());
        
        // Generate unique email with class and student number
        $emailName = strtolower(str_replace(' ', '.', $name));
        $classCode = strtolower(str_replace(' ', '', $class->name)); // e.g., "10tkj1"
        $email = $emailName . '.' . $classCode . '@student.smk.sch.id';
        
        // Ensure email uniqueness by checking database
        $counter = 1;
        $originalEmail = $email;
        while (User::where('email', $email)->exists() || Student::where('email', $email)->exists()) {
            $email = str_replace('@student.smk.sch.id', $counter . '@student.smk.sch.id', $originalEmail);
            $counter++;
        }
        
        // Generate birth date (appropriate for class level)
        $age = 15 + (int)$classLevel - 10; // Kelas 10 = 15 tahun, 11 = 16 tahun, 12 = 17 tahun
        $birthYear = $currentYear - $age;
        $birthDate = Carbon::create($birthYear, rand(1, 12), rand(1, 28));
        
        // Generate other data
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];
        $birthPlaces = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar'];
        $addresses = [
            'Jl. Merdeka No. ' . rand(1, 100) . ', Jakarta',
            'Jl. Sudirman No. ' . rand(1, 100) . ', Bandung',
            'Jl. Diponegoro No. ' . rand(1, 100) . ', Surabaya',
            'Jl. Ahmad Yani No. ' . rand(1, 100) . ', Yogyakarta',
            'Jl. Gatot Subroto No. ' . rand(1, 100) . ', Semarang',
        ];
        
        return [
            'name' => $name,
            'nis' => $nis,
            'nisn' => $nisn,
            'email' => $email,
            'phone' => '08' . rand(1000000000, 9999999999),
            'address' => $addresses[array_rand($addresses)],
            'birth_date' => $birthDate,
            'birth_place' => $birthPlaces[array_rand($birthPlaces)],
            'gender' => $gender,
            'religion' => $religions[array_rand($religions)],
            'parent_name' => 'Orang Tua ' . explode(' ', $name)[0],
            'parent_phone' => '08' . rand(1000000000, 9999999999),
        ];
    }
    
    /**
     * Display summary
     */
    private function displaySummary()
    {
        $totalClasses = Classes::count();
        $totalStudents = Student::count();
        $totalUsers = User::role('student')->count();
        
        $this->command->info('');
        $adminUser = User::first();
        
        $this->command->info('\n📊 SUMMARY:');
        $this->command->info("   📚 Classes created: {$totalClasses}");
        $this->command->info("   👨‍🎓 Students created: {$totalStudents}");
        $this->command->info("   👤 User accounts created: {$totalUsers}");
        $this->command->info('   🔑 Default password: "password"');
        $this->command->info('   📧 Email format: firstname.lastname.classname@student.smk.sch.id');
        $this->command->info("   ✅ All accounts are pre-approved by: {$adminUser->name} (ID: {$adminUser->id})");
        $this->command->info('');
        $this->command->info('📋 CLASSES WITH STUDENTS:');
        
        $classes = Classes::withCount('students')->get();
        foreach ($classes as $class) {
            $this->command->info("   - {$class->name}: {$class->students_count} students");
        }
    }
}