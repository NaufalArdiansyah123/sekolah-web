<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log, Schema};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;
use Exception;

class PerfectStudentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder yang sempurna untuk membuat akun user berdasarkan data siswa
     * dengan validasi lengkap dan error handling yang robust.
     */
    public function run(): void
    {
        Log::info('Starting PerfectStudentAccountSeeder...');
        $this->command->info('🎓 Starting Perfect Student Account Creation...');
        
        // Validasi prasyarat
        if (!$this->validatePrerequisites()) {
            return;
        }
        
        $createdAccounts = 0;
        $skippedAccounts = 0;
        $updatedLinks = 0;
        $errorAccounts = 0;
        
        DB::beginTransaction();
        
        try {
            // Ambil semua data siswa yang aktif
            $students = Student::where('status', 'active')->get();
            
            if ($students->isEmpty()) {
                $this->command->warn('⚠️  No active students found in database.');
                $this->command->info('💡 Please run StudentSeeder first to create student data.');
                DB::rollback();
                return;
            }
            
            $this->command->info("📊 Found {$students->count()} active students");
            $this->command->info('🔄 Processing student accounts...');
            
            // Get student role
            $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
            
            // Progress bar
            $progressBar = $this->command->getOutput()->createProgressBar($students->count());
            $progressBar->start();
            
            foreach ($students as $student) {
                $progressBar->advance();
                
                try {
                    $result = $this->processStudent($student, $studentRole);
                    
                    switch ($result) {
                        case 'created':
                            $createdAccounts++;
                            break;
                        case 'linked':
                            $updatedLinks++;
                            break;
                        case 'skipped':
                            $skippedAccounts++;
                            break;
                        case 'error':
                            $errorAccounts++;
                            break;
                    }
                    
                } catch (Exception $e) {
                    $errorAccounts++;
                    Log::error("Error processing student {$student->id}: " . $e->getMessage(), [
                        'student' => $student->toArray(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    continue;
                }
            }
            
            $progressBar->finish();
            $this->command->newLine(2);
            
            DB::commit();
            
            // Display summary
            $this->displaySummary($students->count(), $createdAccounts, $updatedLinks, $skippedAccounts, $errorAccounts);
            
            Log::info("PerfectStudentAccountSeeder completed", [
                'total_students' => $students->count(),
                'created_accounts' => $createdAccounts,
                'updated_links' => $updatedLinks,
                'skipped_accounts' => $skippedAccounts,
                'error_accounts' => $errorAccounts
            ]);
            
        } catch (Exception $e) {
            DB::rollback();
            
            $this->command->error("❌ PerfectStudentAccountSeeder failed: " . $e->getMessage());
            Log::error("PerfectStudentAccountSeeder failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Validasi prasyarat sebelum menjalankan seeder
     */
    private function validatePrerequisites(): bool
    {
        $this->command->info('🔍 Validating prerequisites...');
        
        // Cek apakah tabel students ada dan punya data
        if (!Schema::hasTable('students')) {
            $this->command->error('❌ Students table not found. Please run migrations first.');
            return false;
        }
        
        $studentCount = Student::count();
        if ($studentCount === 0) {
            $this->command->error('❌ No students found in database.');
            $this->command->info('💡 Please run StudentSeeder first to create student data.');
            return false;
        }
        
        $this->command->info("✅ Found {$studentCount} students in database");
        
        // Cek apakah role student ada
        $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
        if (!$studentRole) {
            $this->command->error('❌ Student role not found. Please run RoleSeeder first.');
            return false;
        }
        
        $this->command->info('✅ Student role exists');
        
        // Cek struktur tabel users
        $requiredColumns = ['name', 'email', 'password', 'nis', 'religion', 'class', 'birth_place'];
        foreach ($requiredColumns as $column) {
            if (!Schema::hasColumn('users', $column)) {
                $this->command->warn("⚠️  Column '{$column}' not found in users table. Some data might not be saved.");
            }
        }
        
        return true;
    }
    
    /**
     * Process individual student
     */
    private function processStudent(Student $student, Role $studentRole): string
    {
        // Cek apakah siswa sudah punya user account
        $existingUser = $this->findExistingUser($student);
        
        if ($existingUser) {
            // User sudah ada, pastikan link ke student
            if ($student->user_id !== $existingUser->id) {
                $student->update(['user_id' => $existingUser->id]);
                
                // Pastikan user punya role student
                if (!$existingUser->hasRole('student')) {
                    $existingUser->assignRole($studentRole);
                }
                
                return 'linked';
            } else {
                return 'skipped';
            }
        }
        
        // Buat user account baru
        $email = $this->generateOrGetEmail($student);
        if (!$email) {
            return 'error';
        }
        
        // Cek apakah email sudah digunakan
        if (User::where('email', $email)->exists()) {
            Log::warning("Email {$email} already exists for student {$student->id}");
            return 'error';
        }
        
        // Buat user baru
        $userData = $this->prepareUserData($student, $email);
        $user = User::create($userData);
        
        // Assign student role
        $user->assignRole($studentRole);
        
        // Update student record dengan user_id
        $student->update(['user_id' => $user->id]);
        
        Log::info("Created user account for student", [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'student_nis' => $student->nis,
            'user_id' => $user->id,
            'email' => $email
        ]);
        
        return 'created';
    }
    
    /**
     * Cari user yang sudah ada berdasarkan berbagai kriteria
     */
    private function findExistingUser(Student $student): ?User
    {
        // Cari berdasarkan email
        if ($student->email) {
            $user = User::where('email', $student->email)->first();
            if ($user) return $user;
        }
        
        // Cari berdasarkan NIS
        if ($student->nis) {
            $user = User::where('nis', $student->nis)->first();
            if ($user) return $user;
        }
        
        // Cari berdasarkan user_id yang sudah ada
        if ($student->user_id) {
            $user = User::find($student->user_id);
            if ($user) return $user;
        }
        
        // Cari berdasarkan nama dan tanggal lahir (untuk menghindari duplikasi)
        $user = User::where('name', $student->name)
                   ->where('birth_date', $student->birth_date)
                   ->first();
        if ($user) return $user;
        
        return null;
    }
    
    /**
     * Generate atau ambil email untuk student
     */
    private function generateOrGetEmail(Student $student): ?string
    {
        // Jika sudah ada email, gunakan itu
        if ($student->email) {
            return $student->email;
        }
        
        // Generate email baru
        $email = $this->generateUniqueEmail($student->name);
        
        // Update email di student record
        $student->update(['email' => $email]);
        
        return $email;
    }
    
    /**
     * Generate email unik berdasarkan nama
     */
    private function generateUniqueEmail(string $name): string
    {
        // Bersihkan nama
        $cleanName = $this->cleanNameForEmail($name);
        $baseEmail = $cleanName . '@student.smk.sch.id';
        
        // Cek apakah email sudah ada
        $email = $baseEmail;
        $counter = 1;
        
        while (User::where('email', $email)->exists() || Student::where('email', $email)->exists()) {
            $email = $cleanName . $counter . '@student.smk.sch.id';
            $counter++;
            
            // Prevent infinite loop
            if ($counter > 999) {
                $email = $cleanName . time() . '@student.smk.sch.id';
                break;
            }
        }
        
        return $email;
    }
    
    /**
     * Bersihkan nama untuk email
     */
    private function cleanNameForEmail(string $name): string
    {
        // Convert ke lowercase
        $name = strtolower($name);
        
        // Replace spasi dengan titik
        $name = str_replace(' ', '.', $name);
        
        // Remove karakter khusus kecuali titik
        $name = preg_replace('/[^a-z0-9.]/', '', $name);
        
        // Remove multiple dots
        $name = preg_replace('/\.+/', '.', $name);
        
        // Remove leading/trailing dots
        $name = trim($name, '.');
        
        // Limit length
        if (strlen($name) > 30) {
            $name = substr($name, 0, 30);
        }
        
        // Jika kosong, gunakan default
        if (empty($name)) {
            $name = 'student' . time();
        }
        
        return $name;
    }
    
    /**
     * Siapkan data user untuk dibuat
     */
    private function prepareUserData(Student $student, string $email): array
    {
        $userData = [
            'name' => $student->name,
            'email' => $email,
            'password' => Hash::make('password'), // Default password
            'email_verified_at' => now(),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Tambahkan field opsional jika ada di tabel users
        $optionalFields = [
            'phone' => $student->phone,
            'address' => $student->address,
            'birth_date' => $student->birth_date,
            'birth_place' => $student->birth_place,
            'gender' => $student->gender,
            'nis' => $student->nis,
            'religion' => $student->religion ?? 'Islam',
            'class' => $student->class,
            'parent_name' => $student->parent_name,
            'parent_phone' => $student->parent_phone,
            'enrollment_date' => now(),
        ];
        
        foreach ($optionalFields as $field => $value) {
            if (Schema::hasColumn('users', $field) && $value !== null) {
                $userData[$field] = $value;
            }
        }
        
        return $userData;
    }
    
    /**
     * Tampilkan summary hasil seeding
     */
    private function displaySummary(int $total, int $created, int $linked, int $skipped, int $errors): void
    {
        $this->command->info('✅ PerfectStudentAccountSeeder completed successfully!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info("   📝 Total students processed: {$total}");
        $this->command->info("   ✨ New accounts created: {$created}");
        $this->command->info("   🔗 Accounts linked: {$linked}");
        $this->command->info("   ⏭️  Accounts skipped: {$skipped}");
        $this->command->info("   ❌ Errors encountered: {$errors}");
        $this->command->info('');
        
        if ($created > 0) {
            $this->command->info('🔑 Login Information:');
            $this->command->info('   📧 Email format: firstname.lastname@student.smk.sch.id');
            $this->command->info('   🔒 Default password: password');
            $this->command->info('');
            $this->command->info('💡 Usage Examples:');
            $this->command->info('   - ahmad.rizki.pratama@student.smk.sch.id');
            $this->command->info('   - siti.nurhaliza@student.smk.sch.id');
            $this->command->info('   - budi.santoso@student.smk.sch.id');
            $this->command->info('');
            $this->command->info('🎯 Next Steps:');
            $this->command->info('   1. Students can login with their generated email');
            $this->command->info('   2. Recommend students change their password after first login');
            $this->command->info('   3. Verify email addresses are correct for important communications');
        }
        
        if ($errors > 0) {
            $this->command->warn('');
            $this->command->warn("⚠️  {$errors} errors occurred. Check logs for details.");
            $this->command->info('   - Check storage/logs/laravel.log for detailed error information');
            $this->command->info('   - Common issues: duplicate emails, missing required fields');
        }
        
        // Statistik tambahan
        $totalUsers = User::count();
        $studentUsers = User::role('student')->count();
        $studentsWithAccounts = Student::whereNotNull('user_id')->count();
        
        $this->command->info('');
        $this->command->info('📈 Database Statistics:');
        $this->command->info("   👥 Total users in system: {$totalUsers}");
        $this->command->info("   🎓 Users with student role: {$studentUsers}");
        $this->command->info("   🔗 Students with user accounts: {$studentsWithAccounts}");
    }
}