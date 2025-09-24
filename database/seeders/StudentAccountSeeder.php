<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log, Schema};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;
use Exception;

class StudentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini akan membuat akun user untuk siswa yang sudah ada di database
     * berdasarkan data di tabel students dengan validasi lengkap dan error handling yang robust.
     */
    public function run(): void
    {
        Log::info('Starting StudentAccountSeeder...');
        $this->command->info('🎓 Starting Student Account Creation...');
        
        // Validasi prasyarat
        if (!$this->validatePrerequisites()) {
            return;
        }
        
        $stats = [
            'created' => 0,
            'linked' => 0,
            'skipped' => 0,
            'errors' => 0
        ];
        
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
            
            // Progress bar untuk monitoring
            $progressBar = $this->command->getOutput()->createProgressBar($students->count());
            $progressBar->start();
            
            foreach ($students as $student) {
                $progressBar->advance();
                
                try {
                    $result = $this->processStudent($student, $studentRole);
                    $stats[$result]++;
                    
                } catch (Exception $e) {
                    $stats['errors']++;
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
            
            // Display comprehensive summary
            $this->displaySummary($students->count(), $stats);
            
            Log::info("StudentAccountSeeder completed successfully", [
                'total_students' => $students->count(),
                'created_accounts' => $stats['created'],
                'linked_accounts' => $stats['linked'],
                'skipped_accounts' => $stats['skipped'],
                'error_accounts' => $stats['errors']
            ]);
            
        } catch (Exception $e) {
            DB::rollback();
            
            $this->command->error("❌ StudentAccountSeeder failed: " . $e->getMessage());
            Log::error("StudentAccountSeeder failed", [
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
        
        // Cek struktur tabel users untuk field yang diperlukan
        $requiredFields = ['name', 'email', 'password'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            if (!Schema::hasColumn('users', $field)) {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            $this->command->error('❌ Missing required fields in users table: ' . implode(', ', $missingFields));
            return false;
        }
        
        // Cek field opsional dan beri peringatan jika tidak ada
        $optionalFields = ['nis', 'religion', 'class', 'birth_place', 'parent_name'];
        $missingOptional = [];
        
        foreach ($optionalFields as $field) {
            if (!Schema::hasColumn('users', $field)) {
                $missingOptional[] = $field;
            }
        }
        
        if (!empty($missingOptional)) {
            $this->command->warn('⚠️  Optional fields not found in users table: ' . implode(', ', $missingOptional));
            $this->command->info('💡 These fields will be skipped during user creation.');
        }
        
        $this->command->info('✅ Prerequisites validation completed');
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
                // Pastikan user punya role student
                if (!$existingUser->hasRole('student')) {
                    $existingUser->assignRole($studentRole);
                }
                return 'skipped';
            }
        }
        
        // Buat user account baru
        $email = $this->generateOrGetEmail($student);
        if (!$email) {
            throw new Exception("Cannot generate email for student {$student->id}");
        }
        
        // Cek apakah email sudah digunakan
        if (User::where('email', $email)->exists()) {
            throw new Exception("Email {$email} already exists for student {$student->id}");
        }
        
        // Buat user baru dengan field yang tersedia
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
        
        // Cari berdasarkan NIS (jika kolom ada)
        if ($student->nis && Schema::hasColumn('users', 'nis')) {
            $user = User::where('nis', $student->nis)->first();
            if ($user) return $user;
        }
        
        // Cari berdasarkan user_id yang sudah ada
        if ($student->user_id) {
            $user = User::find($student->user_id);
            if ($user) return $user;
        }
        
        // Cari berdasarkan nama dan tanggal lahir (untuk menghindari duplikasi)
        if ($student->birth_date) {
            $user = User::where('name', $student->name)
                       ->where('birth_date', $student->birth_date)
                       ->first();
            if ($user) return $user;
        }
        
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
        // Bersihkan nama untuk email
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
        $name = strtolower(trim($name));
        
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
     * Siapkan data user untuk dibuat berdasarkan field yang tersedia
     */
    private function prepareUserData(Student $student, string $email): array
    {
        // Data wajib
        $userData = [
            'name' => $student->name,
            'email' => $email,
            'password' => Hash::make('password'), // Default password
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Tambahkan email_verified_at jika kolom ada
        if (Schema::hasColumn('users', 'email_verified_at')) {
            $userData['email_verified_at'] = now();
        }
        
        // Tambahkan status jika kolom ada
        if (Schema::hasColumn('users', 'status')) {
            $userData['status'] = 'active';
        }
        
        // Mapping field student ke user (hanya jika kolom ada di tabel users)
        $fieldMapping = [
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
            'parent_email' => null, // Bisa diisi jika ada
            'enrollment_date' => now(),
            'student_id' => $student->nis, // Gunakan NIS sebagai student_id
        ];
        
        // Tambahkan field yang ada di database dan tidak null
        foreach ($fieldMapping as $field => $value) {
            if (Schema::hasColumn('users', $field) && $value !== null) {
                $userData[$field] = $value;
            }
        }
        
        return $userData;
    }
    
    /**
     * Tampilkan summary hasil seeding yang komprehensif
     */
    private function displaySummary(int $total, array $stats): void
    {
        $this->command->info('✅ StudentAccountSeeder completed successfully!');
        $this->command->info('');
        $this->command->info('📊 Detailed Summary:');
        $this->command->info("   📝 Total students processed: {$total}");
        $this->command->info("   ✨ New accounts created: {$stats['created']}");
        $this->command->info("   🔗 Existing accounts linked: {$stats['linked']}");
        $this->command->info("   ⏭️  Accounts skipped: {$stats['skipped']}");
        $this->command->info("   ❌ Errors encountered: {$stats['errors']}");
        $this->command->info('');
        
        if ($stats['created'] > 0) {
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
            $this->command->info('   4. Consider implementing email verification for security');
        }
        
        if ($stats['errors'] > 0) {
            $this->command->warn('');
            $this->command->warn("⚠️  {$stats['errors']} errors occurred during processing.");
            $this->command->info('   - Check storage/logs/laravel.log for detailed error information');
            $this->command->info('   - Common issues: duplicate emails, missing required fields, database constraints');
            $this->command->info('   - You can re-run this seeder to process failed records');
        }
        
        // Database statistics
        $totalUsers = User::count();
        $studentUsers = User::role('student')->count();
        $studentsWithAccounts = Student::whereNotNull('user_id')->count();
        $studentsWithoutAccounts = Student::whereNull('user_id')->count();
        
        $this->command->info('');
        $this->command->info('📈 Database Statistics:');
        $this->command->info("   👥 Total users in system: {$totalUsers}");
        $this->command->info("   🎓 Users with student role: {$studentUsers}");
        $this->command->info("   🔗 Students with user accounts: {$studentsWithAccounts}");
        $this->command->info("   ❓ Students without accounts: {$studentsWithoutAccounts}");
        
        // Performance metrics
        $this->command->info('');
        $this->command->info('⚡ Performance Metrics:');
        $this->command->info("   📊 Success rate: " . round(($total - $stats['errors']) / $total * 100, 2) . "%");
        $this->command->info("   🎯 Account creation rate: " . round($stats['created'] / $total * 100, 2) . "%");
        
        // Recommendations
        if ($studentsWithoutAccounts > 0) {
            $this->command->warn('');
            $this->command->warn("⚠️  {$studentsWithoutAccounts} students still don't have user accounts.");
            $this->command->info('💡 Recommendations:');
            $this->command->info('   - Re-run this seeder to process remaining students');
            $this->command->info('   - Check logs for specific error details');
            $this->command->info('   - Verify student data integrity');
        }
        
        if ($stats['created'] > 0) {
            $this->command->info('');
            $this->command->info('🔐 Security Recommendations:');
            $this->command->info('   - Implement password change requirement on first login');
            $this->command->info('   - Enable email verification for new accounts');
            $this->command->info('   - Consider implementing two-factor authentication');
            $this->command->info('   - Regular password policy enforcement');
        }
    }
}