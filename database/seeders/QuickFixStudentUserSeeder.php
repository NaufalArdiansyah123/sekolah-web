<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log};
use App\Models\{Student, User};
use Spatie\Permission\Models\Role;

class QuickFixStudentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder cepat untuk memperbaiki masalah user siswa yang tidak muncul
     */
    public function run(): void
    {
        $this->command->info('🚀 Quick Fix: Creating Student User Accounts...');
        
        // Cek apakah ada siswa tanpa user account
        $studentsWithoutUsers = Student::whereNull('user_id')->where('status', 'active')->get();
        
        if ($studentsWithoutUsers->isEmpty()) {
            $this->command->info('✅ All students already have user accounts!');
            
            // Show current status
            $totalStudents = Student::where('status', 'active')->count();
            $studentsWithUsers = Student::whereNotNull('user_id')->count();
            $this->command->info("📊 Status: {$studentsWithUsers}/{$totalStudents} students have user accounts");
            
            return;
        }
        
        $this->command->info("🔧 Found {$studentsWithoutUsers->count()} students without user accounts");
        $this->command->info('Creating user accounts...');
        
        // Pastikan role student ada
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        
        $created = 0;
        $errors = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($studentsWithoutUsers as $student) {
                try {
                    // Generate email jika belum ada
                    $email = $student->email;
                    if (!$email) {
                        $name = strtolower(str_replace(' ', '.', $student->name));
                        $name = preg_replace('/[^a-z0-9.]/', '', $name);
                        $email = $name . '@student.smk.sch.id';
                        
                        // Cek duplikasi
                        $counter = 1;
                        while (User::where('email', $email)->exists()) {
                            $email = $name . $counter . '@student.smk.sch.id';
                            $counter++;
                        }
                        
                        // Update email di student
                        $student->update(['email' => $email]);
                    }
                    
                    // Buat user dengan data minimal yang pasti ada
                    $user = User::create([
                        'name' => $student->name,
                        'email' => $email,
                        'password' => Hash::make($student->nis ?: 'password'),
                        'email_verified_at' => now(),
                        'status' => 'active',
                    ]);
                    
                    // Assign role
                    $user->assignRole($studentRole);
                    
                    // Update student dengan user_id
                    $student->update(['user_id' => $user->id]);
                    
                    $created++;
                    $this->command->info("✅ {$student->name} → {$email}");
                    
                } catch (\Exception $e) {
                    $errors++;
                    $this->command->error("❌ {$student->name}: " . $e->getMessage());
                    Log::error("QuickFix failed for student {$student->id}: " . $e->getMessage());
                }
            }
            
            DB::commit();
            
            // Summary
            $this->command->info('');
            $this->command->info('✅ Quick Fix completed!');
            $this->command->info("📊 Created: {$created} user accounts");
            if ($errors > 0) {
                $this->command->warn("⚠️  Errors: {$errors}");
            }
            
            // Final status
            $totalStudents = Student::where('status', 'active')->count();
            $studentsWithUsers = Student::whereNotNull('user_id')->count();
            $this->command->info("📈 Final status: {$studentsWithUsers}/{$totalStudents} students have user accounts");
            
            $this->command->info('');
            $this->command->info('🔑 Login Info:');
            $this->command->info('   Email: [student.name]@student.smk.sch.id');
            $this->command->info('   Password: [NIS] atau "password"');
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error("❌ Quick fix failed: " . $e->getMessage());
            throw $e;
        }
    }
}