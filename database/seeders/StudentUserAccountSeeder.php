<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log, Schema};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Exception;

class StudentUserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini akan membuat akun user untuk semua siswa yang ada di database
     * dengan berbagai opsi kustomisasi dan validasi yang lebih lengkap.
     * Seeder ini memiliki mode interaktif untuk kustomisasi.
     */
    public function run(): void
    {
        Log::info('Starting StudentUserAccountSeeder...');
        $this->command->info('🎓 Starting Advanced Student User Account Creation...');
        
        // Validasi prasyarat
        if (!$this->validatePrerequisites()) {
            return;
        }
        
        // Konfigurasi interaktif
        $config = $this->getConfiguration();
        
        $stats = [
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'linked' => 0,
            'errors' => 0
        ];
        
        DB::beginTransaction();
        
        try {
            // Ambil data siswa berdasarkan filter
            $students = $this->getStudentsToProcess($config);
            
            if ($students->isEmpty()) {
                $this->command->warn('⚠️  No students found matching criteria.');
                $this->command->info('💡 Please check your filters or run StudentSeeder first.');
                DB::rollback();
                return;
            }
            
            $this->command->info("📊 Found {$students->count()} students to process");
            
            // Konfirmasi sebelum melanjutkan
            if (!$this->command->confirm('Continue with account creation?', true)) {
                $this->command->info('Operation cancelled by user.');
                DB::rollback();
                return;
            }
            
            // Get student role
            $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
            
            // Progress bar dengan estimasi waktu
            $progressBar = $this->command->getOutput()->createProgressBar($students->count());
            $progressBar->setFormat('verbose');
            $progressBar->start();
            
            $startTime = microtime(true);
            
            foreach ($students as $index => $student) {
                $progressBar->advance();
                
                try {
                    $result = $this->processStudent($student, $studentRole, $config);
                    $stats[$result]++;
                    
                    // Update progress bar message
                    if ($index % 10 == 0) {
                        $elapsed = microtime(true) - $startTime;
                        $rate = ($index + 1) / $elapsed;
                        $remaining = ($students->count() - $index - 1) / $rate;
                        $progressBar->setMessage(sprintf('Rate: %.1f/sec, ETA: %ds', $rate, $remaining));
                    }
                    
                } catch (Exception $e) {
                    $stats['errors']++;
                    Log::error("Error processing student {$student->id}: " . $e->getMessage(), [
                        'student' => $student->toArray(),
                        'config' => $config,
                        'trace' => $e->getTraceAsString()
                    ]);
                    continue;
                }
            }
            
            $progressBar->finish();
            $this->command->newLine(2);
            
            DB::commit();
            
            // Display comprehensive summary
            $this->displaySummary($students->count(), $stats, $config, microtime(true) - $startTime);
            
            Log::info("StudentUserAccountSeeder completed successfully", [
                'total_students' => $students->count(),
                'stats' => $stats,
                'config' => $config,
                'execution_time' => microtime(true) - $startTime
            ]);
            
        } catch (Exception $e) {
            DB::rollback();
            
            $this->command->error("❌ StudentUserAccountSeeder failed: " . $e->getMessage());
            Log::error("StudentUserAccountSeeder failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'config' => $config ?? []
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
        
        $studentCount = Student::count();
        if ($studentCount === 0) {
            $this->command->error('❌ No students found in database.');
            $this->command->info('💡 Please run StudentSeeder first to create student data.');
            return false;
        }
        
        // Cek role student
        $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
        if (!$studentRole) {
            $this->command->error('❌ Student role not found. Please run RoleSeeder first.');
            return false;
        }
        
        // Cek struktur tabel users
        $this->validateUserTableStructure();
        
        $this->command->info("✅ Prerequisites validated ({$studentCount} students, role exists)");
        return true;
    }
    
    /**
     * Validasi struktur tabel users
     */
    private function validateUserTableStructure(): void
    {
        $requiredFields = ['name', 'email', 'password'];
        $missingRequired = [];
        
        foreach ($requiredFields as $field) {
            if (!Schema::hasColumn('users', $field)) {
                $missingRequired[] = $field;
            }
        }
        
        if (!empty($missingRequired)) {
            $this->command->error('❌ Missing required fields in users table: ' . implode(', ', $missingRequired));
            throw new Exception('Required fields missing in users table');
        }
        
        // Cek field opsional
        $optionalFields = ['nis', 'religion', 'class', 'birth_place', 'parent_name', 'enrollment_date'];
        $availableOptional = [];
        
        foreach ($optionalFields as $field) {
            if (Schema::hasColumn('users', $field)) {
                $availableOptional[] = $field;
            }
        }
        
        $this->command->info('📋 Available optional fields: ' . implode(', ', $availableOptional));
    }
    
    /**
     * Dapatkan konfigurasi dari user
     */
    private function getConfiguration(): array
    {
        $this->command->info('⚙️  Configuration Setup:');
        
        $config = [
            'default_password' => 'password',
            'email_domain' => '@student.smk.sch.id',
            'force_update' => $this->command->confirm('Update existing user accounts with student data?', false),
            'create_missing_emails' => $this->command->confirm('Create email addresses for students without email?', true),
            'only_active_students' => $this->command->confirm('Process only active students?', true),
            'skip_existing_accounts' => $this->command->confirm('Skip students who already have user accounts?', false),
            'verify_emails' => $this->command->confirm('Mark emails as verified?', true),
            'send_notifications' => $this->command->confirm('Log detailed notifications?', true)
        ];
        
        // Advanced options
        if ($this->command->confirm('Configure advanced options?', false)) {
            $config['custom_password'] = $this->command->ask('Custom default password (leave empty for "password")', 'password');
            $config['custom_domain'] = $this->command->ask('Custom email domain (leave empty for @student.smk.sch.id)', '@student.smk.sch.id');
            $config['batch_size'] = (int) $this->command->ask('Batch processing size (0 for no batching)', 0);
        }
        
        return $config;
    }
    
    /**
     * Dapatkan siswa yang akan diproses berdasarkan konfigurasi
     */
    private function getStudentsToProcess(array $config)
    {
        $query = Student::query();
        
        // Filter berdasarkan status
        if ($config['only_active_students']) {
            $query->where('status', 'active');
        }
        
        // Filter berdasarkan existing accounts
        if ($config['skip_existing_accounts']) {
            $query->where(function($q) {
                $q->whereNull('user_id')
                  ->orWhereDoesntHave('user');
            });
        }
        
        return $query->get();
    }
    
    /**
     * Process individual student
     */
    private function processStudent(Student $student, Role $studentRole, array $config): string
    {
        // Cari user yang sudah ada
        $existingUser = $this->findExistingUser($student);
        
        if ($existingUser) {
            if ($config['force_update']) {
                $this->updateExistingUser($existingUser, $student, $studentRole, $config);
                return 'updated';
            } else {
                // Pastikan link dan role
                $this->ensureUserLink($existingUser, $student, $studentRole);
                return $config['skip_existing_accounts'] ? 'skipped' : 'linked';
            }
        }
        
        // Buat user baru
        $user = $this->createNewUser($student, $studentRole, $config);
        return $user ? 'created' : 'errors';
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
     * Update user yang sudah ada dengan data student
     */
    private function updateExistingUser(User $user, Student $student, Role $studentRole, array $config): void
    {
        $updateData = [
            'name' => $student->name,
            'updated_at' => now(),
        ];
        
        // Update field yang tersedia
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
        ];
        
        foreach ($fieldMapping as $field => $value) {
            if (Schema::hasColumn('users', $field) && $value !== null) {
                $updateData[$field] = $value;
            }
        }
        
        $user->update($updateData);
        
        // Update link dan role
        $this->ensureUserLink($user, $student, $studentRole);
        
        if ($config['send_notifications']) {
            Log::info("Updated existing user for student", [
                'student_id' => $student->id,
                'user_id' => $user->id,
                'email' => $user->email,
                'updated_fields' => array_keys($updateData)
            ]);
        }
    }
    
    /**
     * Pastikan user terhubung dengan student dan punya role yang benar
     */
    private function ensureUserLink(User $user, Student $student, Role $studentRole): void
    {
        // Update link jika perlu
        if ($student->user_id !== $user->id) {
            $student->update(['user_id' => $user->id]);
        }
        
        // Pastikan punya role student
        if (!$user->hasRole('student')) {
            $user->assignRole($studentRole);
        }
    }
    
    /**
     * Buat user baru untuk student
     */
    private function createNewUser(Student $student, Role $studentRole, array $config): ?User
    {
        // Generate atau ambil email
        $email = $this->getOrGenerateEmail($student, $config);
        if (!$email) {
            Log::warning("Cannot create user for student {$student->id}: no email");
            return null;
        }
        
        // Cek duplikasi email
        if (User::where('email', $email)->exists()) {
            Log::warning("Email {$email} already exists for student {$student->id}");
            return null;
        }
        
        // Siapkan data user
        $userData = $this->prepareUserData($student, $email, $config);
        
        // Buat user
        $user = User::create($userData);
        
        // Assign role dan link
        $user->assignRole($studentRole);
        $student->update(['user_id' => $user->id]);
        
        if ($config['send_notifications']) {
            Log::info("Created new user for student", [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'student_nis' => $student->nis,
                'user_id' => $user->id,
                'email' => $email
            ]);
        }
        
        return $user;
    }
    
    /**
     * Dapatkan atau generate email untuk student
     */
    private function getOrGenerateEmail(Student $student, array $config): ?string
    {
        // Jika sudah ada email, gunakan itu
        if ($student->email) {
            return $student->email;
        }
        
        // Generate email jika diizinkan
        if (!$config['create_missing_emails']) {
            return null;
        }
        
        $email = $this->generateUniqueEmail($student->name, $config['email_domain']);
        
        // Update email di student record
        $student->update(['email' => $email]);
        
        return $email;
    }
    
    /**
     * Generate email unik berdasarkan nama
     */
    private function generateUniqueEmail(string $name, string $domain): string
    {
        $cleanName = $this->cleanNameForEmail($name);
        $baseEmail = $cleanName . $domain;
        
        $email = $baseEmail;
        $counter = 1;
        
        while (User::where('email', $email)->exists() || Student::where('email', $email)->exists()) {
            $email = $cleanName . $counter . $domain;
            $counter++;
            
            // Prevent infinite loop
            if ($counter > 999) {
                $email = $cleanName . Str::random(3) . $domain;
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
        
        // Fallback jika kosong
        if (empty($name)) {
            $name = 'student' . time();
        }
        
        return $name;
    }
    
    /**
     * Siapkan data user berdasarkan konfigurasi
     */
    private function prepareUserData(Student $student, string $email, array $config): array
    {
        $userData = [
            'name' => $student->name,
            'email' => $email,
            'password' => Hash::make($config['default_password']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Email verification
        if ($config['verify_emails'] && Schema::hasColumn('users', 'email_verified_at')) {
            $userData['email_verified_at'] = now();
        }
        
        // Status
        if (Schema::hasColumn('users', 'status')) {
            $userData['status'] = 'active';
        }
        
        // Map student fields to user fields
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
            'parent_email' => null,
            'enrollment_date' => now(),
            'student_id' => $student->nis,
        ];
        
        // Tambahkan field yang ada di database
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
    private function displaySummary(int $total, array $stats, array $config, float $executionTime): void
    {
        $this->command->info('✅ StudentUserAccountSeeder completed successfully!');
        $this->command->info('');
        
        // Execution info
        $this->command->info('⏱️  Execution Information:');
        $this->command->info(sprintf('   🕐 Total time: %.2f seconds', $executionTime));
        $this->command->info(sprintf('   📊 Processing rate: %.1f students/second', $total / $executionTime));
        $this->command->info('');
        
        // Statistics
        $this->command->info('📊 Processing Summary:');
        $this->command->info("   📝 Total students processed: {$total}");
        $this->command->info("   ✨ New accounts created: {$stats['created']}");
        $this->command->info("   🔄 Existing accounts updated: {$stats['updated']}");
        $this->command->info("   🔗 Accounts linked: {$stats['linked']}");
        $this->command->info("   ⏭️  Accounts skipped: {$stats['skipped']}");
        $this->command->info("   ❌ Errors encountered: {$stats['errors']}");
        $this->command->info('');
        
        // Success rate
        $successRate = round(($total - $stats['errors']) / $total * 100, 2);
        $this->command->info("🎯 Success Rate: {$successRate}%");
        $this->command->info('');
        
        // Configuration used
        $this->command->info('⚙️  Configuration Used:');
        $this->command->info("   🔒 Default password: {$config['default_password']}");
        $this->command->info("   📧 Email domain: {$config['email_domain']}");
        $this->command->info("   🔄 Force update: " . ($config['force_update'] ? 'Yes' : 'No'));
        $this->command->info("   📨 Create missing emails: " . ($config['create_missing_emails'] ? 'Yes' : 'No'));
        $this->command->info("   👥 Only active students: " . ($config['only_active_students'] ? 'Yes' : 'No'));
        $this->command->info('');
        
        if ($stats['created'] > 0) {
            $this->command->info('🔑 Login Information:');
            $this->command->info("   📧 Email format: [name]{$config['email_domain']}");
            $this->command->info("   🔒 Default password: {$config['default_password']}");
            $this->command->info('');
            $this->command->info('💡 Usage Examples:');
            $this->command->info('   - ahmad.rizki.pratama@student.smk.sch.id');
            $this->command->info('   - siti.nurhaliza@student.smk.sch.id');
            $this->command->info('   - budi.santoso@student.smk.sch.id');
            $this->command->info('');
        }
        
        // Database statistics
        $totalUsers = User::count();
        $studentUsers = User::role('student')->count();
        $studentsWithAccounts = Student::whereNotNull('user_id')->count();
        
        $this->command->info('📈 Database Statistics:');
        $this->command->info("   👥 Total users: {$totalUsers}");
        $this->command->info("   🎓 Student users: {$studentUsers}");
        $this->command->info("   🔗 Students with accounts: {$studentsWithAccounts}");
        $this->command->info('');
        
        // Next steps
        $this->command->info('🎯 Next Steps:');
        $this->command->info('   1. Students can login with their generated email');
        $this->command->info('   2. Recommend students change their password after first login');
        $this->command->info('   3. Verify email addresses are correct for communications');
        $this->command->info('   4. Consider implementing email verification workflow');
        $this->command->info('   5. Set up password policy enforcement');
        
        if ($stats['errors'] > 0) {
            $this->command->warn('');
            $this->command->warn("⚠️  {$stats['errors']} errors occurred during processing.");
            $this->command->info('   - Check storage/logs/laravel.log for detailed error information');
            $this->command->info('   - Common issues: duplicate emails, missing fields, database constraints');
            $this->command->info('   - You can re-run this seeder to process failed records');
        }
        
        // Performance recommendations
        if ($executionTime > 60) {
            $this->command->info('');
            $this->command->info('🚀 Performance Recommendations:');
            $this->command->info('   - Consider using batch processing for large datasets');
            $this->command->info('   - Optimize database indexes for better performance');
            $this->command->info('   - Use queue jobs for very large operations');
        }
    }
}