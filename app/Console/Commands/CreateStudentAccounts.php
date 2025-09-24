<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{DB, Hash, Log};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;

class CreateStudentAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:create-accounts 
                            {--force : Force create accounts even if they exist}
                            {--update : Update existing user accounts with student data}
                            {--dry-run : Show what would be done without actually doing it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user accounts for students based on existing student data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎓 Student Account Creator');
        $this->info('============================');
        
        $force = $this->option('force');
        $update = $this->option('update');
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
        }
        
        // Check prerequisites
        if (!$this->checkPrerequisites()) {
            return 1;
        }
        
        // Get students data
        $students = $this->getStudentsToProcess($force);
        
        if ($students->isEmpty()) {
            $this->info('✅ All students already have user accounts!');
            return 0;
        }
        
        $this->info("📊 Found {$students->count()} students to process");
        
        if (!$dryRun && !$this->confirm('Continue with account creation?')) {
            $this->info('Operation cancelled.');
            return 0;
        }
        
        // Process students
        return $this->processStudents($students, $force, $update, $dryRun);
    }
    
    /**
     * Check if all prerequisites are met
     */
    private function checkPrerequisites(): bool
    {
        $this->info('🔍 Checking prerequisites...');
        
        // Check if students table has data
        $studentCount = Student::count();
        if ($studentCount === 0) {
            $this->error('❌ No students found in database.');
            $this->info('💡 Run: php artisan db:seed --class=StudentSeeder');
            return false;
        }
        
        $this->info("✅ Found {$studentCount} students in database");
        
        // Check if student role exists
        $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
        if (!$studentRole) {
            $this->error('❌ Student role not found.');
            $this->info('💡 Run: php artisan db:seed --class=RoleSeeder');
            return false;
        }
        
        $this->info('✅ Student role exists');
        
        return true;
    }
    
    /**
     * Get students that need user accounts
     */
    private function getStudentsToProcess(bool $force)
    {
        if ($force) {
            return Student::where('status', 'active')->get();
        }
        
        return Student::where('status', 'active')
            ->where(function($query) {
                $query->whereNull('user_id')
                      ->orWhereDoesntHave('user');
            })
            ->get();
    }
    
    /**
     * Process students and create accounts
     */
    private function processStudents($students, bool $force, bool $update, bool $dryRun): int
    {
        $created = 0;
        $updated = 0;
        $skipped = 0;
        $errors = 0;
        
        $studentRole = Role::where('name', 'student')->first();
        
        if (!$dryRun) {
            DB::beginTransaction();
        }
        
        try {
            $progressBar = $this->output->createProgressBar($students->count());
            $progressBar->start();
            
            foreach ($students as $student) {
                $progressBar->advance();
                
                try {
                    $result = $this->processStudent($student, $studentRole, $force, $update, $dryRun);
                    
                    switch ($result) {
                        case 'created':
                            $created++;
                            break;
                        case 'updated':
                            $updated++;
                            break;
                        case 'skipped':
                            $skipped++;
                            break;
                    }
                    
                } catch (\Exception $e) {
                    $errors++;
                    Log::error("Error processing student {$student->id}: " . $e->getMessage());
                }
            }
            
            $progressBar->finish();
            $this->newLine(2);
            
            if (!$dryRun) {
                DB::commit();
            }
            
            // Display results
            $this->displayResults($students->count(), $created, $updated, $skipped, $errors, $dryRun);
            
            return 0;
            
        } catch (\Exception $e) {
            if (!$dryRun) {
                DB::rollback();
            }
            
            $this->error("❌ Operation failed: {$e->getMessage()}");
            return 1;
        }
    }
    
    /**
     * Process individual student
     */
    private function processStudent(Student $student, Role $studentRole, bool $force, bool $update, bool $dryRun): string
    {
        // Check if user already exists
        $existingUser = $this->findExistingUser($student);
        
        if ($existingUser) {
            if ($update && !$dryRun) {
                $this->updateExistingUser($existingUser, $student, $studentRole);
                return 'updated';
            } else {
                return 'skipped';
            }
        }
        
        // Create new user
        if (!$dryRun) {
            $this->createNewUser($student, $studentRole);
        }
        
        return 'created';
    }
    
    /**
     * Find existing user for student
     */
    private function findExistingUser(Student $student): ?User
    {
        if ($student->email) {
            $user = User::where('email', $student->email)->first();
            if ($user) return $user;
        }
        
        if ($student->nis) {
            $user = User::where('nis', $student->nis)->first();
            if ($user) return $user;
        }
        
        if ($student->user_id) {
            $user = User::find($student->user_id);
            if ($user) return $user;
        }
        
        return null;
    }
    
    /**
     * Update existing user with student data
     */
    private function updateExistingUser(User $user, Student $student, Role $studentRole): void
    {
        $user->update([
            'name' => $student->name,
            'phone' => $student->phone ?? $user->phone,
            'address' => $student->address ?? $user->address,
            'birth_date' => $student->birth_date ?? $user->birth_date,
            'birth_place' => $student->birth_place ?? $user->birth_place,
            'gender' => $student->gender ?? $user->gender,
            'nis' => $student->nis,
            'class' => $student->class,
            'parent_name' => $student->parent_name ?? $user->parent_name,
            'parent_phone' => $student->parent_phone ?? $user->parent_phone,
        ]);
        
        $student->update(['user_id' => $user->id]);
        
        if (!$user->hasRole('student')) {
            $user->assignRole($studentRole);
        }
    }
    
    /**
     * Create new user for student
     */
    private function createNewUser(Student $student, Role $studentRole): User
    {
        // Generate email if not exists
        if (!$student->email) {
            $email = $this->generateUniqueEmail($student->name);
            $student->update(['email' => $email]);
        }
        
        // Siapkan data user
        $userData = [
            'name' => $student->name,
            'email' => $student->email,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'status' => 'active',
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
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', $field) && $value !== null) {
                $userData[$field] = $value;
            }
        }
        
        $user = User::create($userData);
        
        $user->assignRole($studentRole);
        $student->update(['user_id' => $user->id]);
        
        return $user;
    }
    
    /**
     * Generate unique email for student
     */
    private function generateUniqueEmail(string $name): string
    {
        $cleanName = strtolower(str_replace(' ', '.', $name));
        $cleanName = preg_replace('/[^a-z0-9.]/', '', $cleanName);
        $baseEmail = $cleanName . '@student.smk.sch.id';
        
        $email = $baseEmail;
        $counter = 1;
        
        while (User::where('email', $email)->exists()) {
            $email = $cleanName . $counter . '@student.smk.sch.id';
            $counter++;
        }
        
        return $email;
    }
    
    /**
     * Display operation results
     */
    private function displayResults(int $total, int $created, int $updated, int $skipped, int $errors, bool $dryRun): void
    {
        $this->info($dryRun ? '🔍 DRY RUN RESULTS:' : '✅ Operation completed!');
        $this->info('');
        $this->info('📊 Summary:');
        $this->info("   📝 Total processed: {$total}");
        $this->info("   ✨ Accounts created: {$created}");
        $this->info("   🔄 Accounts updated: {$updated}");
        $this->info("   ⏭️  Accounts skipped: {$skipped}");
        $this->info("   ❌ Errors: {$errors}");
        
        if (!$dryRun && $created > 0) {
            $this->info('');
            $this->info('🔑 Login Information:');
            $this->info('   📧 Email format: firstname.lastname@student.smk.sch.id');
            $this->info('   🔒 Default password: password');
            $this->info('');
            $this->info('💡 Next steps:');
            $this->info('   - Students can login with their email and password');
            $this->info('   - Recommend students change password after first login');
        }
        
        if ($errors > 0) {
            $this->warn("⚠️  {$errors} errors occurred. Check logs for details.");
        }
    }
}