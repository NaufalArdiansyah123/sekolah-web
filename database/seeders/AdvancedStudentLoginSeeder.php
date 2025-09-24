<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log, Schema};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;
use Exception;

class AdvancedStudentLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder advanced untuk membuat akun login siswa dengan berbagai opsi kustomisasi
     * dan validasi yang lengkap. Mengambil data dari tabel students.
     */
    public function run(): void
    {
        Log::info('Starting AdvancedStudentLoginSeeder...');
        $this->command->info('🚀 Advanced Student Login Account Creator');
        $this->command->info('=====================================');
        
        // Konfigurasi
        $config = $this->getConfiguration();
        
        // Validasi
        if (!$this->validateSystem()) {
            return;
        }
        
        $stats = [
            'processed' => 0,
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => 0
        ];
        
        DB::beginTransaction();
        
        try {
            // Ambil data siswa berdasarkan filter
            $students = $this->getStudentsToProcess($config);
            
            if ($students->isEmpty()) {
                $this->command->warn('⚠️  No students found matching criteria.');
                return;
            }
            
            $this->command->info("📊 Processing {$students->count()} students...");
            
            if (!$this->command->confirm('Continue creating login accounts?', true)) {
                $this->command->info('Operation cancelled.');
                return;
            }
            
            // Get role
            $studentRole = Role::where('name', 'student')->first();
            
            // Process students
            $progressBar = $this->command->getOutput()->createProgressBar($students->count());
            $progressBar->start();
            
            foreach ($students as $student) {
                $progressBar->advance();
                $stats['processed']++;
                
                try {
                    $result = $this->processStudentLogin($student, $studentRole, $config);
                    $stats[$result]++;
                    
                } catch (Exception $e) {
                    $stats['errors']++;
                    Log::error("Error processing student {$student->id}: " . $e->getMessage());
                }
            }
            
            $progressBar->finish();
            $this->command->newLine(2);
            
            DB::commit();
            
            // Results
            $this->displayResults($stats, $config);
            
        } catch (Exception $e) {
            DB::rollback();
            $this->command->error("❌ Seeder failed: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Dapatkan konfigurasi dari user
     */
    private function getConfiguration(): array
    {
        $this->command->info('⚙️  Configuration:');
        
        return [
            'password_type' => $this->command->choice(
                'Choose password type:',
                ['nis' => 'Use NIS as password', 'custom' => 'Custom password', 'random' => 'Random password'],
                'nis'
            ),
            'custom_password' => $this->command->ask('Custom password (if selected)', 'password'),
            'email_domain' => $this->command->ask('Email domain', '@student.smk.sch.id'),
            'update_existing' => $this->command->confirm('Update existing accounts?', false),
            'only_active' => $this->command->confirm('Only process active students?', true),
            'verify_emails' => $this->command->confirm('Mark emails as verified?', true),
            'force_email_update' => $this->command->confirm('Update student email in database?', true),
        ];
    }
    
    /**
     * Validasi sistem
     */
    private function validateSystem(): bool
    {
        // Cek tabel students
        if (!Schema::hasTable('students') || Student::count() === 0) {
            $this->command->error('❌ No students found. Run StudentSeeder first.');
            return false;
        }
        
        // Cek role
        if (!Role::where('name', 'student')->exists()) {
            $this->command->error('❌ Student role not found. Run RoleSeeder first.');
            return false;
        }
        
        $this->command->info('✅ System validation passed');
        return true;
    }
    
    /**
     * Dapatkan siswa yang akan diproses
     */
    private function getStudentsToProcess(array $config)
    {
        $query = Student::query();
        
        if ($config['only_active']) {
            $query->where('status', 'active');
        }
        
        if (!$config['update_existing']) {
            $query->whereNull('user_id');
        }
        
        return $query->get();
    }
    
    /**
     * Process student login account
     */
    private function processStudentLogin(Student $student, Role $studentRole, array $config): string
    {
        // Cek existing user
        $existingUser = $this->findExistingUser($student);
        
        if ($existingUser && !$config['update_existing']) {
            return 'skipped';
        }
        
        if ($existingUser && $config['update_existing']) {
            $this->updateExistingUser($existingUser, $student, $config);
            return 'updated';
        }
        
        // Create new user
        $this->createNewUser($student, $studentRole, $config);
        return 'created';
    }
    
    /**
     * Cari existing user
     */
    private function findExistingUser(Student $student): ?User
    {
        if ($student->user_id) {
            return User::find($student->user_id);
        }
        
        if ($student->email) {
            return User::where('email', $student->email)->first();
        }
        
        if ($student->nis && Schema::hasColumn('users', 'nis')) {
            return User::where('nis', $student->nis)->first();
        }
        
        return null;
    }
    
    /**
     * Update existing user
     */
    private function updateExistingUser(User $user, Student $student, array $config): void
    {
        $updateData = [
            'name' => $student->name,
            'password' => Hash::make($this->generatePassword($student, $config)),
        ];
        
        // Update fields yang ada
        $fields = ['phone', 'address', 'birth_date', 'gender', 'nis', 'class'];
        foreach ($fields as $field) {
            if (Schema::hasColumn('users', $field) && $student->$field) {
                $updateData[$field] = $student->$field;
            }
        }
        
        $user->update($updateData);
        $student->update(['user_id' => $user->id]);
    }
    
    /**
     * Create new user
     */
    private function createNewUser(Student $student, Role $studentRole, array $config): void
    {
        $email = $this->generateEmail($student, $config);
        
        $userData = [
            'name' => $student->name,
            'email' => $email,
            'password' => Hash::make($this->generatePassword($student, $config)),
            'status' => 'active',
        ];
        
        if ($config['verify_emails'] && Schema::hasColumn('users', 'email_verified_at')) {
            $userData['email_verified_at'] = now();
        }
        
        // Add student data
        $studentFields = [
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
        ];
        
        foreach ($studentFields as $field => $value) {
            if (Schema::hasColumn('users', $field) && $value) {
                $userData[$field] = $value;
            }
        }
        
        $user = User::create($userData);
        $user->assignRole($studentRole);
        
        // Update student
        $studentUpdate = ['user_id' => $user->id];
        if ($config['force_email_update']) {
            $studentUpdate['email'] = $email;
        }
        $student->update($studentUpdate);
    }
    
    /**
     * Generate email
     */
    private function generateEmail(Student $student, array $config): string
    {
        if ($student->email) {
            return $student->email;
        }
        
        $name = strtolower(trim($student->name));
        $name = str_replace(' ', '.', $name);
        $name = preg_replace('/[^a-z0-9.]/', '', $name);
        $name = trim($name, '.');
        
        if (strlen($name) > 25) {
            $name = substr($name, 0, 25);
        }
        
        $email = $name . $config['email_domain'];
        
        // Handle duplicates
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $name . $counter . $config['email_domain'];
            $counter++;
        }
        
        return $email;
    }
    
    /**
     * Generate password
     */
    private function generatePassword(Student $student, array $config): string
    {
        switch ($config['password_type']) {
            case 'nis':
                return $student->nis ?: 'password';
            case 'custom':
                return $config['custom_password'];
            case 'random':
                return \Illuminate\Support\Str::random(8);
            default:
                return 'password';
        }
    }
    
    /**
     * Display results
     */
    private function displayResults(array $stats, array $config): void
    {
        $this->command->info('✅ Advanced Student Login Seeder completed!');
        $this->command->info('');
        
        $this->command->info('📊 Results:');
        $this->command->info("   📝 Students processed: {$stats['processed']}");
        $this->command->info("   ✨ Accounts created: {$stats['created']}");
        $this->command->info("   🔄 Accounts updated: {$stats['updated']}");
        $this->command->info("   ⏭️  Accounts skipped: {$stats['skipped']}");
        $this->command->info("   ❌ Errors: {$stats['errors']}");
        $this->command->info('');
        
        if ($stats['created'] > 0 || $stats['updated'] > 0) {
            $this->command->info('🔑 Login Configuration:');
            $this->command->info("   📧 Email domain: {$config['email_domain']}");
            $this->command->info("   🔒 Password type: {$config['password_type']}");
            
            if ($config['password_type'] === 'nis') {
                $this->command->info('   💡 Password = NIS siswa');
            } elseif ($config['password_type'] === 'custom') {
                $this->command->info("   💡 Password = {$config['custom_password']}");
            } else {
                $this->command->info('   💡 Password = Random 8 characters');
            }
            
            $this->command->info('');
            $this->command->info('🎯 Next Steps:');
            $this->command->info('   1. Test login functionality');
            $this->command->info('   2. Distribute credentials to students');
            $this->command->info('   3. Set up password change policy');
            $this->command->info('   4. Configure password reset mechanism');
        }
        
        if ($stats['errors'] > 0) {
            $this->command->warn("⚠️  {$stats['errors']} errors occurred. Check logs for details.");
        }
    }
}