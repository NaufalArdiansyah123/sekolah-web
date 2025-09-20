<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentRegistration;
use Carbon\Carbon;

class StudentRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder creates sample student registrations for testing
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        
        // Sample student registrations with different statuses
        $registrations = [
            // Pending registrations
            [
                'name' => 'Andi Setiawan',
                'email' => 'andi.setiawan.new@gmail.com',
                'nis' => '2024051',
                'nisn' => '0123456850',
                'class' => 'X-1',
                'gender' => 'male',
                'birth_place' => 'Jakarta',
                'birth_date' => '2008-03-15',
                'address' => 'Jl. Kebon Jeruk No. 123, Jakarta Barat',
                'phone' => '081234567950',
                'parent_name' => 'Setiawan Budi',
                'parent_phone' => '081234567951',
                'status' => 'pending',
                'rejection_reason' => null,
            ],
            [
                'name' => 'Sari Wulandari',
                'email' => 'sari.wulan@gmail.com',
                'nis' => '2024052',
                'nisn' => '0123456851',
                'class' => 'X-2',
                'gender' => 'female',
                'birth_place' => 'Bandung',
                'birth_date' => '2008-05-22',
                'address' => 'Jl. Cihampelas No. 456, Bandung',
                'phone' => '081234567952',
                'parent_name' => 'Wulan Sari',
                'parent_phone' => '081234567953',
                'status' => 'pending',
                'rejection_reason' => null,
            ],
            [
                'name' => 'Budi Hartono',
                'email' => 'budi.hartono@gmail.com',
                'nis' => '2024053',
                'nisn' => '0123456852',
                'class' => 'X-1',
                'gender' => 'male',
                'birth_place' => 'Surabaya',
                'birth_date' => '2008-01-10',
                'address' => 'Jl. Gubeng No. 789, Surabaya',
                'phone' => '081234567954',
                'parent_name' => 'Hartono Wijaya',
                'parent_phone' => '081234567955',
                'status' => 'pending',
                'rejection_reason' => null,
            ],
            
            // Approved registrations
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@gmail.com',
                'nis' => '2024054',
                'nisn' => '0123456853',
                'class' => 'X-2',
                'gender' => 'female',
                'birth_place' => 'Yogyakarta',
                'birth_date' => '2008-07-18',
                'address' => 'Jl. Malioboro No. 321, Yogyakarta',
                'phone' => '081234567956',
                'parent_name' => 'Lestari Indah',
                'parent_phone' => '081234567957',
                'status' => 'approved',
                'rejection_reason' => null,
            ],
            [
                'name' => 'Reza Pratama',
                'email' => 'reza.pratama@gmail.com',
                'nis' => '2024055',
                'nisn' => '0123456854',
                'class' => 'X-1',
                'gender' => 'male',
                'birth_place' => 'Medan',
                'birth_date' => '2008-09-25',
                'address' => 'Jl. Gatot Subroto No. 654, Medan',
                'phone' => '081234567958',
                'parent_name' => 'Pratama Jaya',
                'parent_phone' => '081234567959',
                'status' => 'approved',
                'rejection_reason' => null,
            ],
            
            // Rejected registrations
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari.reject@gmail.com',
                'nis' => '2024056',
                'nisn' => '0123456855',
                'class' => 'X-2',
                'gender' => 'female',
                'birth_place' => 'Semarang',
                'birth_date' => '2008-02-14',
                'address' => 'Jl. Diponegoro No. 987, Semarang',
                'phone' => '081234567960',
                'parent_name' => 'Sari Maya',
                'parent_phone' => '081234567961',
                'status' => 'rejected',
                'rejection_reason' => 'data',
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi.wijaya.reject@gmail.com',
                'nis' => '2024057',
                'nisn' => '0123456856',
                'class' => 'X-1',
                'gender' => 'male',
                'birth_place' => 'Palembang',
                'birth_date' => '2008-04-30',
                'address' => 'Jl. Ahmad Yani No. 147, Palembang',
                'phone' => '081234567962',
                'parent_name' => 'Wijaya Kusuma',
                'parent_phone' => '081234567963',
                'status' => 'rejected',
                'rejection_reason' => 'verifikasi',
            ],
            [
                'name' => 'Lina Marlina',
                'email' => 'lina.marlina.reject@gmail.com',
                'nis' => '2024058',
                'nisn' => '0123456857',
                'class' => 'X-2',
                'gender' => 'female',
                'birth_place' => 'Makassar',
                'birth_date' => '2008-06-12',
                'address' => 'Jl. Hasanuddin No. 258, Makassar',
                'phone' => '081234567964',
                'parent_name' => 'Marlina Sari',
                'parent_phone' => '081234567965',
                'status' => 'rejected',
                'rejection_reason' => 'sistem',
            ],
        ];
        
        foreach ($registrations as $registration) {
            StudentRegistration::create([
                'name' => $registration['name'],
                'email' => $registration['email'],
                'nis' => $registration['nis'],
                'nisn' => $registration['nisn'],
                'class' => $registration['class'],
                'gender' => $registration['gender'],
                'birth_place' => $registration['birth_place'],
                'birth_date' => Carbon::parse($registration['birth_date']),
                'address' => $registration['address'],
                'phone' => $registration['phone'],
                'parent_name' => $registration['parent_name'],
                'parent_phone' => $registration['parent_phone'],
                'status' => $registration['status'],
                'rejection_reason' => $registration['rejection_reason'],
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);
            
            $this->command->info("Created student registration: {$registration['name']} ({$registration['status']})");
        }
        
        // Create additional random registrations
        for ($i = 1; $i <= 15; $i++) {
            $genderCode = $faker->randomElement(['L', 'P']);
            $gender = $genderCode === 'L' ? 'male' : 'female';
            $firstName = $genderCode === 'L' ? $faker->firstNameMale : $faker->firstNameFemale;
            $lastName = $faker->lastName;
            $fullName = $firstName . ' ' . $lastName;
            $status = $faker->randomElement(['pending', 'pending', 'pending', 'approved', 'rejected']);
            $rejectionReason = $status === 'rejected' ? $faker->randomElement(['data', 'verifikasi', 'sistem']) : null;
            
            StudentRegistration::create([
                'name' => $fullName,
                'email' => strtolower(str_replace(' ', '.', $fullName)) . $i . '@gmail.com',
                'nis' => '2024' . str_pad(59 + $i, 3, '0', STR_PAD_LEFT),
                'nisn' => '01234' . str_pad(56858 + $i, 5, '0', STR_PAD_LEFT),
                'class' => $faker->randomElement(['X-1', 'X-2', 'X-3', 'X-4']),
                'gender' => $gender,
                'birth_place' => $faker->city,
                'birth_date' => $faker->dateTimeBetween('2008-01-01', '2008-12-31'),
                'address' => $faker->address,
                'phone' => '08' . $faker->numerify('##########'),
                'parent_name' => $faker->name,
                'parent_phone' => '08' . $faker->numerify('##########'),
                'status' => $status,
                'rejection_reason' => $rejectionReason,
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()->subDays(rand(0, 10)),
            ]);
        }
        
        $this->command->info('Student registration seeder completed successfully!');
        $this->command->info('Total registrations created: ' . (count($registrations) + 15));
        $this->command->info('Status distribution: Pending, Approved, Rejected');
    }
}