<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdditionalStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder creates additional students using faker data
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID'); // Indonesian locale
        
        // SMK Classes available (completing 15 classes total)
        // StudentSeeder handles: 10 TKJ 1, 10 TKJ 2, 10 RPL 1, 10 RPL 2, 10 DKV 1, 11 TKJ 1, 11 TKJ 2, 11 RPL 1, 11 RPL 2, 11 DKV 1, 12 TKJ 1, 12 TKJ 2, 12 RPL 1, 12 RPL 2, 12 DKV 1 (15 classes with 2 students each)
        // AdditionalStudentSeeder will add more students to existing classes
        $classes = ['10 TKJ 1', '10 TKJ 2', '10 RPL 1', '10 RPL 2', '10 DKV 1', '11 TKJ 1', '11 TKJ 2', '11 RPL 1', '11 RPL 2', '11 DKV 1', '12 TKJ 1', '12 TKJ 2', '12 RPL 1', '12 RPL 2', '12 DKV 1'];
        
        // Religions available in Indonesia
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        
        // Generate additional students
        $studentsPerClass = 25; // 25 students per class
        $totalStudents = count($classes) * $studentsPerClass;
        
        $this->command->info("Creating {$totalStudents} additional students...");
        
        $studentCounter = 1;
        
        foreach ($classes as $class) {
            $this->command->info("Creating students for class: {$class}");
            
            // Determine year based on class
            $year = match(substr($class, 0, 1)) {
                'X' => '2024',
                'XI' => '2023', 
                'XII' => '2022',
                default => '2024'
            };
            
            for ($i = 1; $i <= $studentsPerClass; $i++) {
                $gender = $faker->randomElement(['L', 'P']);
                $firstName = $gender === 'L' ? $faker->firstNameMale : $faker->firstNameFemale;
                $lastName = $faker->lastName;
                $fullName = $firstName . ' ' . $lastName;
                
                // Generate unique NIS and NISN
                $nisNumber = str_pad($studentCounter + 100, 3, '0', STR_PAD_LEFT);
                $nis = $year . $nisNumber;
                $nisn = '01234' . str_pad($studentCounter + 56818, 5, '0', STR_PAD_LEFT);
                
                // Generate email
                $emailName = strtolower(str_replace(' ', '.', $fullName));
                $email = $emailName . '@student.sch.id';
                
                // Generate birth date based on class
                $birthYear = match(substr($class, 0, 1)) {
                    'X' => 2008,
                    'XI' => 2007,
                    'XII' => 2006,
                    default => 2008
                };
                
                $birthDate = $faker->dateTimeBetween(
                    $birthYear . '-01-01', 
                    $birthYear . '-12-31'
                )->format('Y-m-d');
                
                // Create user
                $user = User::create([
                    'name' => $fullName,
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password123'),
                    'remember_token' => Str::random(10),
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Assign role student
                $user->assignRole('student');
                
                // Create student data
                Student::create([
                    'user_id' => $user->id,
                    'name' => $fullName,
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'email' => $email,
                    'class' => $class,
                    'gender' => $gender === 'L' ? 'male' : 'female',
                    'birth_place' => $faker->city,
                    'birth_date' => Carbon::parse($birthDate),
                    'address' => $faker->address,
                    'phone' => '08' . $faker->numerify('##########'),
                    'parent_name' => $faker->name,
                    'parent_phone' => '08' . $faker->numerify('##########'),
                    'religion' => $faker->randomElement($religions),
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $studentCounter++;
                
                if ($i % 5 == 0) {
                    $this->command->info("  Created {$i}/{$studentsPerClass} students for {$class}");
                }
            }
        }
        
        $this->command->info('Additional student seeder completed successfully!');
        $this->command->info("Total additional students created: {$totalStudents}");
        $this->command->info('SMK Classes: ' . implode(', ', $classes));
        $this->command->info('Students per class: ' . $studentsPerClass);
        $this->command->info('Complete SMK 15-class system:');
        $this->command->info('- StudentSeeder: 15 SMK classes (TKJ 1, TKJ 2, RPL 1, RPL 2, DKV 1 for grades 10, 11, 12) with 2 students each = 30 students');
        $this->command->info('- AdditionalStudentSeeder: Same 15 SMK classes with 25 additional students each = 375 students');
        $this->command->info('- Total: 15 SMK classes with 405 students (30 + 375)');
        $this->command->info('- Majors: TKJ (Teknik Komputer Jaringan), RPL (Rekayasa Perangkat Lunak), DKV (Desain Komunikasi Visual)');
        $this->command->info('Default password for all students: password123');
    }
}