<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log, Schema};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;

class CreateStudentAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder sederhana untuk membuat akun user berdasarkan data siswa yang sudah ada.
     * Cocok untuk penggunaan cepat dan mudah.
     */
    public function run(): void
    {
        $this->command->info('🎓 Creating Student User Accounts...');
        
        // Ambil semua siswa yang belum punya user account
        $studentsWithoutAccounts = Student::whereNull('user_id')
            ->orWhereDoesntHave('user')
            ->where('status', 'active')
            ->get();
            
        if ($studentsWithoutAccounts->isEmpty()) {
            $this->command->info('✅ All active students already have user accounts!');
            return;
        }
        
        $this->command->info("📊 Found {$studentsWithoutAccounts->count()} students without user accounts");
        
        // Pastikan role student ada
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        
        $created = 0;
        $errors = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($studentsWithoutAccounts as $student) {
                try {
                    // Generate email jika belum ada
                    if (!$student->email) {
                        $emailName = strtolower(str_replace(' ', '.', $student->name));
                        // Remove special characters
                        $emailName = preg_replace('/[^a-z0-9.]/', '', $emailName);
                        $email = $emailName . '@student.smk.sch.id';
                        
                        // Pastikan email unik
                        $counter = 1;
                        while (User::where('email', $email)->exists()) {
                            $email = $emailName . $counter . '@student.smk.sch.id';
                            $counter++;
                        }
                        
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
                        if (Schema::hasColumn('users', $field) && $value !== null) {
                            $userData[$field] = $value;
                        }
                    }
                    
                    // Buat user account
                    $user = User::create($userData);
                    
                    // Assign role
                    $user->assignRole($studentRole);
                    
                    // Link ke student
                    $student->update(['user_id' => $user->id]);
                    
                    $created++;
                    $this->command->info("✅ Created account for: {$student->name} ({$student->email})");
                    
                } catch (\Exception $e) {
                    $errors++;
                    $this->command->error("❌ Failed to create account for: {$student->name} - {$e->getMessage()}");
                    Log::error("Failed to create account for student {$student->id}", [
                        'error' => $e->getMessage(),
                        'student' => $student->toArray()
                    ]);
                }
            }
            
            DB::commit();
            
            $this->command->info('');
            $this->command->info('✅ Student account creation completed!');
            $this->command->info("📊 Created: {$created} accounts");
            if ($errors > 0) {
                $this->command->warn("⚠️  Errors: {$errors} accounts failed");
            }
            $this->command->info('🔑 Default password: "password"');
            $this->command->info('📧 Email format: firstname.lastname@student.smk.sch.id');
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error("❌ Seeder failed: {$e->getMessage()}");
            throw $e;
        }
    }
}