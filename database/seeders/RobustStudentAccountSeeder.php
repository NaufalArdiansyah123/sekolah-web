<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log, Schema};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;
use Exception;

class RobustStudentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder yang robust dengan validasi field database dan error handling lengkap.
     * Seeder ini akan memeriksa struktur database dan hanya mengisi field yang ada.
     */
    public function run(): void
    {
        $this->command->info('🎓 Starting Robust Student Account Creation...');
        $this->command->info('🔍 Analyzing database structure...');
        
        // Analisis struktur database
        $userColumns = $this->getUserTableColumns();
        $this->command->info("📋 Found " . count($userColumns) . " columns in users table");
        
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
            // Ambil siswa yang perlu diproses
            $students = $this->getStudentsToProcess();
            
            if ($students->isEmpty()) {
                $this->command->info('✅ All active students already have user accounts!');
                return;
            }
            
            $this->command->info("📊 Processing {$students->count()} students...");
            
            $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
            
            // Progress bar
            $progressBar = $this->command->getOutput()->createProgressBar($students->count());
            $progressBar->start();
            
            foreach ($students as $student) {
                $progressBar->advance();
                
                try {
                    $result = $this->processStudent($student, $studentRole, $userColumns);
                    $stats[$result]++;
                    
                } catch (Exception $e) {
                    $stats['errors']++;
                    Log::error("Error processing student {$student->id}: " . $e->getMessage());
                }
            }
            
            $progressBar->finish();
            $this->command->newLine(2);
            
            DB::commit();
            
            $this->displayResults($students->count(), $stats, $userColumns);
            
        } catch (Exception $e) {
            DB::rollback();
            $this->command->error("❌ Seeder failed: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Dapatkan kolom yang ada di tabel users
     */
    private function getUserTableColumns(): array
    {
        $columns = Schema::getColumnListing('users');
        
        // Daftar kolom yang mungkin ada untuk data student
        $possibleColumns = [
            'name', 'email', 'password', 'email_verified_at', 'phone', 'address',
            'birth_date', 'birth_place', 'gender', 'nis', 'religion', 'class',
            'parent_name', 'parent_phone', 'parent_email', 'enrollment_date',
            'student_id', 'status', 'avatar', 'bio'
        ];
        
        // Return hanya kolom yang ada di database
        return array_intersect($possibleColumns, $columns);
    }
    
    /**
     * Validasi prasyarat
     */
    private function validatePrerequisites(): bool
    {
        // Cek tabel students
        if (!Schema::hasTable('students')) {
            $this->command->error('❌ Students table not found');
            return false;
        }
        
        $studentCount = Student::count();
        if ($studentCount === 0) {
            $this->command->error('❌ No students found in database');
            return false;
        }
        
        // Cek role student
        $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
        if (!$studentRole) {
            $this->command->error('❌ Student role not found. Run RoleSeeder first.');
            return false;
        }
        
        $this->command->info("✅ Prerequisites validated ({$studentCount} students, role exists)");
        return true;
    }
    
    /**
     * Dapatkan siswa yang perlu diproses
     */
    private function getStudentsToProcess()
    {
        return Student::where('status', 'active')
            ->where(function($query) {
                $query->whereNull('user_id')
                      ->orWhereDoesntHave('user');
            })
            ->get();
    }
    
    /**
     * Process individual student
     */
    private function processStudent(Student $student, Role $studentRole, array $userColumns): string
    {
        // Cek apakah sudah ada user
        $existingUser = $this->findExistingUser($student);
        
        if ($existingUser) {
            // Link existing user
            if ($student->user_id !== $existingUser->id) {
                $student->update(['user_id' => $existingUser->id]);
                
                if (!$existingUser->hasRole('student')) {
                    $existingUser->assignRole($studentRole);
                }
                
                return 'linked';
            }
            
            return 'skipped';
        }
        
        // Buat user baru
        $email = $this->ensureStudentHasEmail($student);
        if (!$email) {
            throw new Exception("Cannot generate email for student {$student->id}");
        }
        
        // Cek duplikasi email
        if (User::where('email', $email)->exists()) {
            throw new Exception("Email {$email} already exists");
        }
        
        // Buat user dengan field yang ada
        $userData = $this->prepareUserData($student, $email, $userColumns);
        $user = User::create($userData);
        
        // Assign role dan link
        $user->assignRole($studentRole);
        $student->update(['user_id' => $user->id]);
        
        Log::info("Created user for student", [
            'student_id' => $student->id,
            'user_id' => $user->id,
            'email' => $email
        ]);
        
        return 'created';
    }
    
    /**
     * Cari user yang sudah ada
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
        
        // Cari berdasarkan user_id
        if ($student->user_id) {
            $user = User::find($student->user_id);
            if ($user) return $user;
        }
        
        return null;
    }
    
    /**
     * Pastikan student punya email
     */
    private function ensureStudentHasEmail(Student $student): ?string
    {
        if ($student->email) {
            return $student->email;
        }
        
        // Generate email
        $email = $this->generateUniqueEmail($student->name);
        $student->update(['email' => $email]);
        
        return $email;
    }
    
    /**
     * Generate email unik
     */
    private function generateUniqueEmail(string $name): string
    {
        // Clean name
        $cleanName = strtolower(trim($name));
        $cleanName = str_replace(' ', '.', $cleanName);
        $cleanName = preg_replace('/[^a-z0-9.]/', '', $cleanName);
        $cleanName = preg_replace('/\.+/', '.', $cleanName);
        $cleanName = trim($cleanName, '.');
        
        if (empty($cleanName)) {
            $cleanName = 'student' . time();
        }
        
        // Limit length
        if (strlen($cleanName) > 30) {
            $cleanName = substr($cleanName, 0, 30);
        }
        
        $baseEmail = $cleanName . '@student.smk.sch.id';
        $email = $baseEmail;
        $counter = 1;
        
        while (User::where('email', $email)->exists() || Student::where('email', $email)->exists()) {
            $email = $cleanName . $counter . '@student.smk.sch.id';
            $counter++;
            
            if ($counter > 999) {
                $email = $cleanName . time() . '@student.smk.sch.id';
                break;
            }
        }
        
        return $email;
    }
    
    /**
     * Siapkan data user berdasarkan kolom yang ada
     */
    private function prepareUserData(Student $student, string $email, array $userColumns): array
    {
        // Data wajib
        $userData = [
            'name' => $student->name,
            'email' => $email,
            'password' => Hash::make('password'),
        ];
        
        // Tambahkan email_verified_at jika kolom ada
        if (in_array('email_verified_at', $userColumns)) {
            $userData['email_verified_at'] = now();
        }
        
        // Tambahkan status jika kolom ada
        if (in_array('status', $userColumns)) {
            $userData['status'] = 'active';
        }
        
        // Mapping field student ke user
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
            'enrollment_date' => now(),
        ];
        
        // Tambahkan field yang ada di database dan tidak null
        foreach ($fieldMapping as $field => $value) {
            if (in_array($field, $userColumns) && $value !== null) {
                $userData[$field] = $value;
            }
        }
        
        return $userData;
    }
    
    /**
     * Tampilkan hasil
     */
    private function displayResults(int $total, array $stats, array $userColumns): void
    {
        $this->command->info('✅ Robust Student Account Seeder completed!');
        $this->command->info('');
        $this->command->info('📊 Results Summary:');
        $this->command->info("   📝 Total processed: {$total}");
        $this->command->info("   ✨ Accounts created: {$stats['created']}");
        $this->command->info("   🔗 Accounts linked: {$stats['linked']}");
        $this->command->info("   ⏭️  Accounts skipped: {$stats['skipped']}");
        $this->command->info("   ❌ Errors: {$stats['errors']}");
        $this->command->info('');
        
        if ($stats['created'] > 0) {
            $this->command->info('🔑 Login Information:');
            $this->command->info('   📧 Email format: firstname.lastname@student.smk.sch.id');
            $this->command->info('   🔒 Default password: password');
            $this->command->info('');
        }
        
        // Database info
        $this->command->info('🗃️  Database Structure:');
        $this->command->info("   📋 User table columns used: " . count($userColumns));
        $this->command->info("   🔧 Available fields: " . implode(', ', array_slice($userColumns, 0, 10)) . (count($userColumns) > 10 ? '...' : ''));
        
        if ($stats['errors'] > 0) {
            $this->command->warn('');
            $this->command->warn("⚠️  {$stats['errors']} errors occurred. Check logs for details.");
        }
        
        // Final stats
        $totalUsers = User::count();
        $studentUsers = User::role('student')->count();
        
        $this->command->info('');
        $this->command->info('📈 Final Statistics:');
        $this->command->info("   👥 Total users: {$totalUsers}");
        $this->command->info("   🎓 Student users: {$studentUsers}");
    }
}