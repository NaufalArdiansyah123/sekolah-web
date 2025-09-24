<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log, Schema};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;
use Exception;

class StudentLoginAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder khusus untuk membuat akun login siswa berdasarkan data yang sudah ada
     * di database students. Seeder ini akan membuat user account yang bisa digunakan
     * siswa untuk login ke sistem.
     */
    public function run(): void
    {
        Log::info('Starting StudentLoginAccountSeeder...');
        $this->command->info('🔐 Creating Student Login Accounts from Student Database...');
        
        // Validasi prasyarat
        if (!$this->validatePrerequisites()) {
            return;
        }
        
        $stats = [
            'total_students' => 0,
            'accounts_created' => 0,
            'accounts_updated' => 0,
            'accounts_skipped' => 0,
            'errors' => 0
        ];
        
        DB::beginTransaction();
        
        try {
            // Ambil semua data siswa dari database
            $students = Student::where('status', 'active')->get();
            $stats['total_students'] = $students->count();
            
            if ($students->isEmpty()) {
                $this->command->warn('⚠️  No active students found in database.');
                $this->command->info('💡 Please ensure student data exists in the students table.');
                DB::rollback();
                return;
            }
            
            $this->command->info("📊 Found {$students->count()} active students in database");
            $this->command->info('🔄 Creating login accounts...');
            
            // Get student role
            $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
            
            // Progress bar
            $progressBar = $this->command->getOutput()->createProgressBar($students->count());
            $progressBar->start();
            
            foreach ($students as $student) {
                $progressBar->advance();
                
                try {
                    $result = $this->createStudentLoginAccount($student, $studentRole);
                    $stats[$result]++;
                    
                } catch (Exception $e) {
                    $stats['errors']++;
                    Log::error("Error creating login account for student {$student->id}: " . $e->getMessage(), [
                        'student_data' => $student->toArray(),
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }
            
            $progressBar->finish();
            $this->command->newLine(2);
            
            DB::commit();
            
            // Display results
            $this->displayResults($stats);
            
            Log::info("StudentLoginAccountSeeder completed", $stats);
            
        } catch (Exception $e) {
            DB::rollback();
            
            $this->command->error("❌ StudentLoginAccountSeeder failed: " . $e->getMessage());
            Log::error("StudentLoginAccountSeeder failed", [
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
        
        // Cek tabel students
        if (!Schema::hasTable('students')) {
            $this->command->error('❌ Students table not found. Please run migrations first.');
            return false;
        }
        
        // Cek data students
        $studentCount = Student::count();
        if ($studentCount === 0) {
            $this->command->error('❌ No students found in database.');
            $this->command->info('💡 Please run StudentSeeder first to populate student data.');
            return false;
        }
        
        $this->command->info("✅ Found {$studentCount} students in database");
        
        // Cek tabel users
        if (!Schema::hasTable('users')) {
            $this->command->error('❌ Users table not found. Please run migrations first.');
            return false;
        }
        
        // Cek role student
        $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
        if (!$studentRole) {
            $this->command->error('❌ Student role not found. Please run RoleSeeder first.');
            return false;
        }
        
        $this->command->info('✅ Student role exists');
        
        // Cek field yang diperlukan di tabel users
        $requiredFields = ['name', 'email', 'password'];
        foreach ($requiredFields as $field) {
            if (!Schema::hasColumn('users', $field)) {
                $this->command->error("❌ Required field '{$field}' not found in users table.");
                return false;
            }
        }
        
        $this->command->info('✅ All required fields exist in users table');
        return true;
    }
    
    /**
     * Buat akun login untuk siswa berdasarkan data student
     */
    private function createStudentLoginAccount(Student $student, Role $studentRole): string
    {
        // Cek apakah siswa sudah punya akun login
        $existingUser = $this->findExistingLoginAccount($student);
        
        if ($existingUser) {
            // Update link jika perlu
            if ($student->user_id !== $existingUser->id) {
                $student->update(['user_id' => $existingUser->id]);
                
                // Pastikan punya role student
                if (!$existingUser->hasRole('student')) {
                    $existingUser->assignRole($studentRole);
                }
                
                return 'accounts_updated';
            }
            
            return 'accounts_skipped';
        }
        
        // Buat akun login baru
        $loginData = $this->prepareLoginAccountData($student);
        
        // Validasi email unik
        if (User::where('email', $loginData['email'])->exists()) {
            // Generate email alternatif
            $loginData['email'] = $this->generateAlternativeEmail($student);
            
            // Update email di student record
            $student->update(['email' => $loginData['email']]);
        }
        
        // Buat user account
        $user = User::create($loginData);
        
        // Assign role student
        $user->assignRole($studentRole);
        
        // Link user dengan student
        $student->update(['user_id' => $user->id]);
        
        Log::info("Created login account for student", [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'student_nis' => $student->nis,
            'user_id' => $user->id,
            'login_email' => $loginData['email']
        ]);
        
        return 'accounts_created';
    }
    
    /**
     * Cari akun login yang sudah ada untuk siswa
     */
    private function findExistingLoginAccount(Student $student): ?User
    {
        // Cari berdasarkan user_id yang sudah ada
        if ($student->user_id) {
            $user = User::find($student->user_id);
            if ($user) return $user;
        }
        
        // Cari berdasarkan email
        if ($student->email) {
            $user = User::where('email', $student->email)->first();
            if ($user) return $user;
        }
        
        // Cari berdasarkan NIS (jika field ada di users table)
        if ($student->nis && Schema::hasColumn('users', 'nis')) {
            $user = User::where('nis', $student->nis)->first();
            if ($user) return $user;
        }
        
        // Cari berdasarkan nama dan tanggal lahir untuk menghindari duplikasi
        if ($student->birth_date) {
            $user = User::where('name', $student->name)
                       ->where('birth_date', $student->birth_date)
                       ->first();
            if ($user) return $user;
        }
        
        return null;
    }
    
    /**
     * Siapkan data untuk akun login berdasarkan data student
     */
    private function prepareLoginAccountData(Student $student): array
    {
        // Data dasar yang wajib
        $loginData = [
            'name' => $student->name,
            'email' => $this->generateLoginEmail($student),
            'password' => Hash::make($this->generateDefaultPassword($student)),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Tambahkan email verification jika field ada
        if (Schema::hasColumn('users', 'email_verified_at')) {
            $loginData['email_verified_at'] = now();
        }
        
        // Tambahkan status jika field ada
        if (Schema::hasColumn('users', 'status')) {
            $loginData['status'] = 'active';
        }
        
        // Map data student ke user account
        $studentDataMapping = [
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
        
        // Tambahkan field yang ada di tabel users
        foreach ($studentDataMapping as $field => $value) {
            if (Schema::hasColumn('users', $field) && $value !== null) {
                $loginData[$field] = $value;
            }
        }
        
        return $loginData;
    }
    
    /**
     * Generate email login berdasarkan data student
     */
    private function generateLoginEmail(Student $student): string
    {
        // Jika student sudah punya email, gunakan itu
        if ($student->email) {
            return $student->email;
        }
        
        // Generate email berdasarkan nama
        $cleanName = $this->cleanNameForEmail($student->name);
        return $cleanName . '@student.smk.sch.id';
    }
    
    /**
     * Generate email alternatif jika email utama sudah digunakan
     */
    private function generateAlternativeEmail(Student $student): string
    {
        $cleanName = $this->cleanNameForEmail($student->name);
        $baseEmail = $cleanName . '@student.smk.sch.id';
        
        $counter = 1;
        $email = $baseEmail;
        
        while (User::where('email', $email)->exists()) {
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
        // Convert ke lowercase dan trim
        $name = strtolower(trim($name));
        
        // Replace spasi dengan titik
        $name = str_replace(' ', '.', $name);
        
        // Remove karakter khusus kecuali titik
        $name = preg_replace('/[^a-z0-9.]/', '', $name);
        
        // Remove multiple dots
        $name = preg_replace('/\.+/', '.', $name);
        
        // Remove leading/trailing dots
        $name = trim($name, '.');
        
        // Limit length untuk email
        if (strlen($name) > 30) {
            $name = substr($name, 0, 30);
        }
        
        // Fallback jika nama kosong
        if (empty($name)) {
            $name = 'student' . time();
        }
        
        return $name;
    }
    
    /**
     * Generate password default berdasarkan data student
     */
    private function generateDefaultPassword(Student $student): string
    {
        // Bisa menggunakan NIS sebagai password default
        if ($student->nis) {
            return $student->nis;
        }
        
        // Atau gunakan password default
        return 'password';
    }
    
    /**
     * Tampilkan hasil seeding
     */
    private function displayResults(array $stats): void
    {
        $this->command->info('✅ StudentLoginAccountSeeder completed successfully!');
        $this->command->info('');
        
        // Statistics
        $this->command->info('📊 Results Summary:');
        $this->command->info("   📝 Total students processed: {$stats['total_students']}");
        $this->command->info("   ✨ Login accounts created: {$stats['accounts_created']}");
        $this->command->info("   🔄 Accounts updated/linked: {$stats['accounts_updated']}");
        $this->command->info("   ⏭️  Accounts skipped: {$stats['accounts_skipped']}");
        $this->command->info("   ❌ Errors encountered: {$stats['errors']}");
        $this->command->info('');
        
        // Success rate
        $successRate = $stats['total_students'] > 0 
            ? round(($stats['total_students'] - $stats['errors']) / $stats['total_students'] * 100, 2)
            : 0;
        $this->command->info("🎯 Success Rate: {$successRate}%");
        $this->command->info('');
        
        if ($stats['accounts_created'] > 0) {
            $this->command->info('🔑 Login Information:');
            $this->command->info('   📧 Email format: firstname.lastname@student.smk.sch.id');
            $this->command->info('   🔒 Default password: NIS siswa atau "password"');
            $this->command->info('');
            
            $this->command->info('💡 Login Examples:');
            $this->command->info('   Email: ahmad.rizki.pratama@student.smk.sch.id');
            $this->command->info('   Password: [NIS siswa] atau "password"');
            $this->command->info('');
            
            $this->command->info('🎯 Next Steps:');
            $this->command->info('   1. Students can now login to the system');
            $this->command->info('   2. Distribute login credentials to students');
            $this->command->info('   3. Recommend password change after first login');
            $this->command->info('   4. Test login functionality');
            $this->command->info('   5. Set up password reset mechanism if needed');
        }
        
        // Database statistics
        $totalUsers = User::count();
        $studentUsers = User::role('student')->count();
        $studentsWithAccounts = Student::whereNotNull('user_id')->count();
        $studentsWithoutAccounts = Student::whereNull('user_id')->count();
        
        $this->command->info('📈 Database Statistics:');
        $this->command->info("   👥 Total users in system: {$totalUsers}");
        $this->command->info("   🎓 Users with student role: {$studentUsers}");
        $this->command->info("   🔗 Students with login accounts: {$studentsWithAccounts}");
        $this->command->info("   ❓ Students without accounts: {$studentsWithoutAccounts}");
        $this->command->info('');
        
        if ($stats['errors'] > 0) {
            $this->command->warn("⚠️  {$stats['errors']} errors occurred during processing.");
            $this->command->info('   - Check storage/logs/laravel.log for detailed error information');
            $this->command->info('   - Common issues: duplicate emails, missing data, database constraints');
            $this->command->info('   - Re-run this seeder to process failed records');
            $this->command->info('');
        }
        
        if ($studentsWithoutAccounts > 0) {
            $this->command->warn("⚠️  {$studentsWithoutAccounts} students still don't have login accounts.");
            $this->command->info('💡 Recommendations:');
            $this->command->info('   - Check student data completeness');
            $this->command->info('   - Verify required fields are filled');
            $this->command->info('   - Re-run seeder to process remaining students');
        }
        
        // Security recommendations
        $this->command->info('🔐 Security Recommendations:');
        $this->command->info('   - Implement password change requirement on first login');
        $this->command->info('   - Set up email verification for new accounts');
        $this->command->info('   - Configure password policy (length, complexity)');
        $this->command->info('   - Enable account lockout after failed attempts');
        $this->command->info('   - Set up password reset functionality');
        $this->command->info('   - Consider two-factor authentication for enhanced security');
    }
}