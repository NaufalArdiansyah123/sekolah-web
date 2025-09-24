<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;

class SimpleStudentLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder sederhana untuk membuat akun login siswa dari data students.
     * Fokus pada kemudahan penggunaan dan kecepatan eksekusi.
     */
    public function run(): void
    {
        $this->command->info('🔐 Creating Simple Student Login Accounts...');
        
        // Ambil siswa yang belum punya akun login
        $studentsWithoutLogin = Student::whereNull('user_id')
            ->where('status', 'active')
            ->get();
            
        if ($studentsWithoutLogin->isEmpty()) {
            $this->command->info('✅ All active students already have login accounts!');
            return;
        }
        
        $this->command->info("📊 Creating login accounts for {$studentsWithoutLogin->count()} students...");
        
        // Pastikan role student ada
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        
        $created = 0;
        $errors = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($studentsWithoutLogin as $student) {
                try {
                    // Generate email login
                    $email = $this->generateStudentEmail($student);
                    
                    // Buat akun login
                    $user = User::create([
                        'name' => $student->name,
                        'email' => $email,
                        'password' => Hash::make($student->nis ?? 'password'), // Password = NIS atau 'password'
                        'email_verified_at' => now(),
                        'nis' => $student->nis,
                        'class' => $student->class,
                        'phone' => $student->phone,
                        'address' => $student->address,
                        'birth_date' => $student->birth_date,
                        'gender' => $student->gender,
                        'status' => 'active',
                    ]);
                    
                    // Assign role student
                    $user->assignRole($studentRole);
                    
                    // Link dengan student
                    $student->update([
                        'user_id' => $user->id,
                        'email' => $email // Update email di student juga
                    ]);
                    
                    $created++;
                    $this->command->info("✅ {$student->name} → {$email}");
                    
                } catch (\Exception $e) {
                    $errors++;
                    $this->command->error("❌ Failed: {$student->name} - {$e->getMessage()}");
                    Log::error("Failed to create login for student {$student->id}", [
                        'error' => $e->getMessage(),
                        'student' => $student->name
                    ]);
                }
            }
            
            DB::commit();
            
            // Summary
            $this->command->info('');
            $this->command->info('✅ Simple Student Login Seeder completed!');
            $this->command->info("📊 Created: {$created} login accounts");
            if ($errors > 0) {
                $this->command->warn("⚠️  Errors: {$errors} failed");
            }
            $this->command->info('');
            $this->command->info('🔑 Login Details:');
            $this->command->info('   📧 Email: firstname.lastname@student.smk.sch.id');
            $this->command->info('   🔒 Password: NIS siswa (atau "password" jika NIS kosong)');
            $this->command->info('');
            $this->command->info('💡 Example:');
            $this->command->info('   Email: ahmad.rizki@student.smk.sch.id');
            $this->command->info('   Password: 2024001 (NIS siswa)');
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error("❌ Seeder failed: {$e->getMessage()}");
            throw $e;
        }
    }
    
    /**
     * Generate email untuk student
     */
    private function generateStudentEmail(Student $student): string
    {
        // Jika sudah ada email, gunakan itu
        if ($student->email) {
            return $student->email;
        }
        
        // Generate dari nama
        $name = strtolower($student->name);
        $name = str_replace(' ', '.', $name);
        $name = preg_replace('/[^a-z0-9.]/', '', $name);
        $name = trim($name, '.');
        
        // Limit length
        if (strlen($name) > 25) {
            $name = substr($name, 0, 25);
        }
        
        $email = $name . '@student.smk.sch.id';
        
        // Cek duplikasi
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $name . $counter . '@student.smk.sch.id';
            $counter++;
        }
        
        return $email;
    }
}