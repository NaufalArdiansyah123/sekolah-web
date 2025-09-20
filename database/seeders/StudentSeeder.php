<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash, Log};
use App\Models\{Student, User};
use App\Helpers\ClassHelper;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Starting StudentSeeder...');
        
        // Data siswa sample
        $studentsData = [
            // Kelas 10 TKJ
            ['name' => 'Ahmad Rizki Pratama', 'gender' => 'male', 'class' => '10 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Siti Nurhaliza', 'gender' => 'female', 'class' => '10 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Budi Santoso', 'gender' => 'male', 'class' => '10 TKJ 1', 'religion' => 'Kristen'],
            ['name' => 'Dewi Sartika', 'gender' => 'female', 'class' => '10 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Eko Prasetyo', 'gender' => 'male', 'class' => '10 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Fitri Handayani', 'gender' => 'female', 'class' => '10 TKJ 2', 'religion' => 'Islam'],
            ['name' => 'Galih Permana', 'gender' => 'male', 'class' => '10 TKJ 2', 'religion' => 'Islam'],
            ['name' => 'Hani Rahmawati', 'gender' => 'female', 'class' => '10 TKJ 2', 'religion' => 'Islam'],
            ['name' => 'Indra Gunawan', 'gender' => 'male', 'class' => '10 TKJ 2', 'religion' => 'Hindu'],
            ['name' => 'Joko Widodo', 'gender' => 'male', 'class' => '10 TKJ 2', 'religion' => 'Islam'],
            
            // Kelas 10 RPL
            ['name' => 'Kartika Sari', 'gender' => 'female', 'class' => '10 RPL 1', 'religion' => 'Islam'],
            ['name' => 'Lukman Hakim', 'gender' => 'male', 'class' => '10 RPL 1', 'religion' => 'Islam'],
            ['name' => 'Maya Sari', 'gender' => 'female', 'class' => '10 RPL 1', 'religion' => 'Kristen'],
            ['name' => 'Nanda Pratama', 'gender' => 'male', 'class' => '10 RPL 1', 'religion' => 'Islam'],
            ['name' => 'Olivia Rodrigo', 'gender' => 'female', 'class' => '10 RPL 1', 'religion' => 'Katolik'],
            ['name' => 'Putra Mahendra', 'gender' => 'male', 'class' => '10 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Qori Amelia', 'gender' => 'female', 'class' => '10 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Reza Fahlevi', 'gender' => 'male', 'class' => '10 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Sari Dewi', 'gender' => 'female', 'class' => '10 RPL 2', 'religion' => 'Hindu'],
            ['name' => 'Taufik Hidayat', 'gender' => 'male', 'class' => '10 RPL 2', 'religion' => 'Islam'],
            
            // Kelas 10 DKV
            ['name' => 'Umi Kalsum', 'gender' => 'female', 'class' => '10 DKV 1', 'religion' => 'Islam'],
            ['name' => 'Vino Bastian', 'gender' => 'male', 'class' => '10 DKV 1', 'religion' => 'Kristen'],
            ['name' => 'Wulan Guritno', 'gender' => 'female', 'class' => '10 DKV 1', 'religion' => 'Islam'],
            ['name' => 'Xavier Nugraha', 'gender' => 'male', 'class' => '10 DKV 1', 'religion' => 'Katolik'],
            ['name' => 'Yuni Shara', 'gender' => 'female', 'class' => '10 DKV 1', 'religion' => 'Islam'],
            
            // Kelas 11 TKJ
            ['name' => 'Zaki Rahman', 'gender' => 'male', 'class' => '11 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Anisa Rahma', 'gender' => 'female', 'class' => '11 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Bayu Skak', 'gender' => 'male', 'class' => '11 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Citra Kirana', 'gender' => 'female', 'class' => '11 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Dimas Anggara', 'gender' => 'male', 'class' => '11 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Elly Sugigi', 'gender' => 'female', 'class' => '11 TKJ 2', 'religion' => 'Kristen'],
            ['name' => 'Fajar Nugros', 'gender' => 'male', 'class' => '11 TKJ 2', 'religion' => 'Islam'],
            ['name' => 'Gita Gutawa', 'gender' => 'female', 'class' => '11 TKJ 2', 'religion' => 'Islam'],
            ['name' => 'Hendra Wijaya', 'gender' => 'male', 'class' => '11 TKJ 2', 'religion' => 'Buddha'],
            ['name' => 'Ira Wibowo', 'gender' => 'female', 'class' => '11 TKJ 2', 'religion' => 'Islam'],
            
            // Kelas 11 RPL
            ['name' => 'Jefri Nichol', 'gender' => 'male', 'class' => '11 RPL 1', 'religion' => 'Kristen'],
            ['name' => 'Kirana Larasati', 'gender' => 'female', 'class' => '11 RPL 1', 'religion' => 'Islam'],
            ['name' => 'Lucky Hakim', 'gender' => 'male', 'class' => '11 RPL 1', 'religion' => 'Islam'],
            ['name' => 'Maudy Ayunda', 'gender' => 'female', 'class' => '11 RPL 1', 'religion' => 'Islam'],
            ['name' => 'Nicholas Saputra', 'gender' => 'male', 'class' => '11 RPL 1', 'religion' => 'Kristen'],
            ['name' => 'Olla Ramlan', 'gender' => 'female', 'class' => '11 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Pandji Pragiwaksono', 'gender' => 'male', 'class' => '11 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Queenita Siregar', 'gender' => 'female', 'class' => '11 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Raditya Dika', 'gender' => 'male', 'class' => '11 RPL 2', 'religion' => 'Islam'],
            ['name' => 'Sandra Dewi', 'gender' => 'female', 'class' => '11 RPL 2', 'religion' => 'Kristen'],
            
            // Kelas 12 TKJ
            ['name' => 'Tarra Budiman', 'gender' => 'male', 'class' => '12 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Ussy Sulistiawaty', 'gender' => 'female', 'class' => '12 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Vidi Aldiano', 'gender' => 'male', 'class' => '12 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Wika Salim', 'gender' => 'female', 'class' => '12 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Yuki Kato', 'gender' => 'female', 'class' => '12 TKJ 1', 'religion' => 'Islam'],
            ['name' => 'Zaskia Gotik', 'gender' => 'female', 'class' => '12 TKJ 2', 'religion' => 'Islam'],
        ];
        
        $currentYear = date('Y');
        $createdStudents = 0;
        $createdUsers = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($studentsData as $index => $studentData) {
                // Generate NIS berdasarkan kelas dan urutan
                $classInfo = ClassHelper::parseClass($studentData['class']);
                $grade = $classInfo['grade'];
                $sequenceNumber = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
                $nis = $currentYear . str_pad($grade, 2, '0', STR_PAD_LEFT) . $sequenceNumber;
                
                // Generate NISN (10 digit random)
                $nisn = '00' . rand(10000000, 99999999);
                
                // Generate birth date (15-18 tahun yang lalu)
                $birthYear = $currentYear - (15 + ($grade - 10)); // Kelas 10 = 15 tahun, 11 = 16 tahun, 12 = 17 tahun
                $birthDate = Carbon::create($birthYear, rand(1, 12), rand(1, 28));
                
                // Generate email
                $emailName = strtolower(str_replace(' ', '.', $studentData['name']));
                $email = $emailName . '@student.smk.sch.id';
                
                // Generate phone
                $phone = '08' . rand(1000000000, 9999999999);
                
                // Generate parent data
                $parentNames = [
                    'Bapak ' . explode(' ', $studentData['name'])[0] . ' Senior',
                    'Ibu ' . explode(' ', $studentData['name'])[0] . ' Wati',
                    'Bapak ' . explode(' ', $studentData['name'])[0] . ' Utomo',
                    'Ibu ' . explode(' ', $studentData['name'])[0] . ' Sari',
                ];
                $parentName = $parentNames[array_rand($parentNames)];
                $parentPhone = '08' . rand(1000000000, 9999999999);
                
                // Generate address
                $addresses = [
                    'Jl. Merdeka No. ' . rand(1, 100) . ', Jakarta',
                    'Jl. Sudirman No. ' . rand(1, 100) . ', Bandung',
                    'Jl. Diponegoro No. ' . rand(1, 100) . ', Surabaya',
                    'Jl. Ahmad Yani No. ' . rand(1, 100) . ', Yogyakarta',
                    'Jl. Gatot Subroto No. ' . rand(1, 100) . ', Semarang',
                ];
                $address = $addresses[array_rand($addresses)];
                
                // Generate birth place
                $birthPlaces = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar', 'Palembang'];
                $birthPlace = $birthPlaces[array_rand($birthPlaces)];
                
                // Create student
                $student = Student::create([
                    'name' => $studentData['name'],
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'class' => $studentData['class'],
                    'birth_date' => $birthDate,
                    'birth_place' => $birthPlace,
                    'gender' => $studentData['gender'],
                    'religion' => $studentData['religion'],
                    'parent_name' => $parentName,
                    'parent_phone' => $parentPhone,
                    'status' => 'active',
                    'user_id' => 1, // Admin user
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $createdStudents++;
                
                // Create user account for student
                $user = User::create([
                    'name' => $studentData['name'],
                    'email' => $email,
                    'password' => Hash::make('password'), // Password: "password"
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Assign student role using Spatie Permission
                try {
                    $studentRole = Role::where('name', 'student')->where('guard_name', 'web')->first();
                    if ($studentRole) {
                        $user->assignRole($studentRole);
                        Log::info("Assigned student role to user {$user->id}");
                    } else {
                        Log::warning("Student role not found for user {$user->id}");
                    }
                } catch (\Exception $e) {
                    Log::warning("Could not assign role to user {$user->id}: " . $e->getMessage());
                }
                
                $createdUsers++;
                
                Log::info("Created student: {$student->name} (NIS: {$nis}) with user account");
            }
            
            DB::commit();
            
            $this->command->info("✅ StudentSeeder completed successfully!");
            $this->command->info("📊 Created {$createdStudents} students");
            $this->command->info("👤 Created {$createdUsers} user accounts");
            $this->command->info("🔑 All passwords set to: 'password'");
            $this->command->info("📧 Email format: firstname.lastname@student.smk.sch.id");
            
            Log::info("StudentSeeder completed", [
                'students_created' => $createdStudents,
                'users_created' => $createdUsers
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            $this->command->error("❌ StudentSeeder failed: " . $e->getMessage());
            Log::error("StudentSeeder failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}