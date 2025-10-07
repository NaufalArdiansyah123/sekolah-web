<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class StudentRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates student users with complete registration data
     * including class, parent information, and various statuses for testing
     */
    public function run(): void
    {
        $this->command->info('🧹 Creating student registration test data...');
        
        // Ensure student role exists
        $studentRole = Role::firstOrCreate([
            'name' => 'student',
            'guard_name' => 'web'
        ]);
        
        // Get admin user for approval
        $adminUser = User::whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->first();
        
        if (!$adminUser) {
            $this->command->error('❌ Admin user not found. Please run AdminUserSeeder first.');
            return;
        }
        
        // Sample student registration data
        $studentsData = [
            // Pending registrations
            [
                'name' => 'Ahmad Rizki Pratama',
                'email' => 'ahmad.rizki@student.test',
                'nis' => '2024101001',
                'class' => 'X TKJ 1',
                'parent_name' => 'Budi Pratama',
                'parent_phone' => '081234567890',
                'parent_email' => 'budi.pratama@gmail.com',
                'status' => 'pending',
                'birth_date' => '2008-05-15',
                'birth_place' => 'Jakarta',
                'gender' => 'male',
                'religion' => 'Islam',
                'phone' => '085678901234',
                'address' => 'Jl. Merdeka No. 123, Jakarta Pusat'
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@student.test',
                'nis' => '2024101002',
                'class' => 'X TKJ 1',
                'parent_name' => 'Hasan Nurdin',
                'parent_phone' => '081234567891',
                'parent_email' => 'hasan.nurdin@gmail.com',
                'status' => 'pending',
                'birth_date' => '2008-03-20',
                'birth_place' => 'Bandung',
                'gender' => 'female',
                'religion' => 'Islam',
                'phone' => '085678901235',
                'address' => 'Jl. Sudirman No. 456, Bandung'
            ],
            [
                'name' => 'Dedi Setiawan',
                'email' => 'dedi.setiawan@student.test',
                'nis' => '2024111001',
                'class' => 'XI RPL 1',
                'parent_name' => 'Eko Setiawan',
                'parent_phone' => '081234567892',
                'parent_email' => 'eko.setiawan@gmail.com',
                'status' => 'pending',
                'birth_date' => '2007-08-10',
                'birth_place' => 'Surabaya',
                'gender' => 'male',
                'religion' => 'Kristen',
                'phone' => '085678901236',
                'address' => 'Jl. Diponegoro No. 789, Surabaya'
            ],
            
            // Active/Approved registrations
            [
                'name' => 'Maya Sari Dewi',
                'email' => 'maya.sari@student.test',
                'nis' => '2024111002',
                'class' => 'XI RPL 1',
                'parent_name' => 'Agus Dewi',
                'parent_phone' => '081234567893',
                'parent_email' => 'agus.dewi@gmail.com',
                'status' => 'active',
                'birth_date' => '2007-12-05',
                'birth_place' => 'Yogyakarta',
                'gender' => 'female',
                'religion' => 'Islam',
                'phone' => '085678901237',
                'address' => 'Jl. Malioboro No. 321, Yogyakarta',
                'approved_at' => now(),
                'approved_by' => $adminUser->id
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar.nugroho@student.test',
                'nis' => '2024121001',
                'class' => 'XII DKV 1',
                'parent_name' => 'Bambang Nugroho',
                'parent_phone' => '081234567894',
                'parent_email' => 'bambang.nugroho@gmail.com',
                'status' => 'active',
                'birth_date' => '2006-09-18',
                'birth_place' => 'Semarang',
                'gender' => 'male',
                'religion' => 'Islam',
                'phone' => '085678901238',
                'address' => 'Jl. Pemuda No. 654, Semarang',
                'approved_at' => now(),
                'approved_by' => $adminUser->id
            ],
            
            // Rejected registrations
            [
                'name' => 'Kartika Sari',
                'email' => 'kartika.sari@student.test',
                'nis' => '2024101003',
                'class' => 'X TKJ 2',
                'parent_name' => 'Wawan Sari',
                'parent_phone' => '081234567895',
                'parent_email' => 'wawan.sari@gmail.com',
                'status' => 'rejected',
                'birth_date' => '2008-01-25',
                'birth_place' => 'Medan',
                'gender' => 'female',
                'religion' => 'Katolik',
                'phone' => '085678901239',
                'address' => 'Jl. Gatot Subroto No. 987, Medan',
                'rejected_at' => now(),
                'rejected_by' => $adminUser->id,
                'rejection_reason' => 'Data yang dimasukkan tidak dapat diverifikasi dengan database sekolah. Silakan hubungi bagian administrasi untuk verifikasi data.'
            ],
            
            // More pending registrations for testing bulk actions
            [
                'name' => 'Galih Permana',
                'email' => 'galih.permana@student.test',
                'nis' => '2024121002',
                'class' => 'XII DKV 1',
                'parent_name' => 'Indra Permana',
                'parent_phone' => '081234567896',
                'parent_email' => 'indra.permana@gmail.com',
                'status' => 'pending',
                'birth_date' => '2006-11-30',
                'birth_place' => 'Makassar',
                'gender' => 'male',
                'religion' => 'Islam',
                'phone' => '085678901240',
                'address' => 'Jl. Ahmad Yani No. 147, Makassar'
            ],
            [
                'name' => 'Hani Rahmawati',
                'email' => 'hani.rahmawati@student.test',
                'nis' => '2024111003',
                'class' => 'XI RPL 2',
                'parent_name' => 'Joko Rahmawati',
                'parent_phone' => '081234567897',
                'parent_email' => 'joko.rahmawati@gmail.com',
                'status' => 'pending',
                'birth_date' => '2007-04-12',
                'birth_place' => 'Palembang',
                'gender' => 'female',
                'religion' => 'Islam',
                'phone' => '085678901241',
                'address' => 'Jl. Sudirman No. 258, Palembang'
            ],
            [
                'name' => 'Lukman Hakim',
                'email' => 'lukman.hakim@student.test',
                'nis' => '2024101004',
                'class' => 'X TKJ 2',
                'parent_name' => 'Muhammad Hakim',
                'parent_phone' => '081234567898',
                'parent_email' => 'muhammad.hakim@gmail.com',
                'status' => 'pending',
                'birth_date' => '2008-07-08',
                'birth_place' => 'Balikpapan',
                'gender' => 'male',
                'religion' => 'Islam',
                'phone' => '085678901242',
                'address' => 'Jl. Jenderal Sudirman No. 369, Balikpapan'
            ],
            [
                'name' => 'Olivia Rodrigo',
                'email' => 'olivia.rodrigo@student.test',
                'nis' => '2024121003',
                'class' => 'XII DKV 2',
                'parent_name' => 'Robert Rodrigo',
                'parent_phone' => '081234567899',
                'parent_email' => 'robert.rodrigo@gmail.com',
                'status' => 'pending',
                'birth_date' => '2006-02-14',
                'birth_place' => 'Denpasar',
                'gender' => 'female',
                'religion' => 'Kristen',
                'phone' => '085678901243',
                'address' => 'Jl. Gajah Mada No. 741, Denpasar'
            ]
        ];
        
        $created = 0;
        $skipped = 0;
        
        foreach ($studentsData as $studentData) {
            // Check if user already exists
            if (User::where('email', $studentData['email'])->exists()) {
                $this->command->warn("   ⚠️  User {$studentData['email']} already exists, skipping...");
                $skipped++;
                continue;
            }
            
            // Create user with complete student registration data
            $user = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'phone' => $studentData['phone'],
                'address' => $studentData['address'],
                'birth_date' => $studentData['birth_date'],
                'birth_place' => $studentData['birth_place'],
                'gender' => $studentData['gender'],
                'religion' => $studentData['religion'],
                'nis' => $studentData['nis'],
                'class' => $studentData['class'],
                'parent_name' => $studentData['parent_name'],
                'parent_phone' => $studentData['parent_phone'],
                'parent_email' => $studentData['parent_email'],
                'status' => $studentData['status'],
                'approved_at' => $studentData['approved_at'] ?? null,
                'approved_by' => $studentData['approved_by'] ?? null,
                'rejected_at' => $studentData['rejected_at'] ?? null,
                'rejected_by' => $studentData['rejected_by'] ?? null,
                'rejection_reason' => $studentData['rejection_reason'] ?? null,
                'enrollment_date' => $studentData['status'] === 'active' ? now() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Assign student role
            $user->assignRole($studentRole);
            
            $this->command->info("   ✅ Created: {$user->name} ({$user->email}) - Status: {$user->status}");
            $created++;
        }
        
        $this->command->info('');
        $this->command->info("📊 SUMMARY:");
        $this->command->info("   ✅ Created: {$created} student registrations");
        $this->command->info("   ⚠️  Skipped: {$skipped} existing users");
        $this->command->info("   🔑 Default password: 'password'");
        $this->command->info('');
        
        // Display statistics
        $totalStudents = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->count();
        
        $pendingCount = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->where('status', 'pending')->count();
        
        $activeCount = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->where('status', 'active')->count();
        
        $rejectedCount = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->where('status', 'rejected')->count();
        
        $this->command->info("📈 CURRENT STATISTICS:");
        $this->command->info("   👥 Total student users: {$totalStudents}");
        $this->command->info("   ⏳ Pending: {$pendingCount}");
        $this->command->info("   ✅ Active: {$activeCount}");
        $this->command->info("   ❌ Rejected: {$rejectedCount}");
        $this->command->info('');
        $this->command->info('🎯 You can now test the student registration management features!');
    }
}