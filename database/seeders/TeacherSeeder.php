<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if teachers already exist
        $existingCount = Teacher::count();
        if ($existingCount > 0) {
            $this->command->info("Found {$existingCount} existing teachers. Clearing existing data to create fresh seed data.");
            Teacher::truncate();
            $this->command->info('Existing teachers cleared.');
        }

        $positions = [
            'Kepala Sekolah',
            'Wakil Kepala Sekolah',
            'Guru Kelas',
            'Guru Mata Pelajaran',
            'Guru BK',
            'Staff Administrasi',
            'Staff Perpustakaan',
            'Staff TU'
        ];

        $subjects = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Sejarah',
            'Geografi',
            'Ekonomi',
            'Sosiologi',
            'PKn',
            'Seni Budaya',
            'Pendidikan Jasmani',
            'Teknologi Informasi',
            'Bahasa Jawa',
            'Agama Islam',
            'Agama Kristen',
            'Agama Katolik',
            'Agama Hindu',
            'Agama Buddha'
        ];

        $educations = [
            'S1 Pendidikan Matematika, Universitas Negeri Semarang',
            'S1 Pendidikan Bahasa Indonesia, Universitas Diponegoro',
            'S1 Pendidikan Bahasa Inggris, Universitas Negeri Yogyakarta',
            'S1 Pendidikan Fisika, Institut Teknologi Bandung',
            'S1 Pendidikan Kimia, Universitas Gadjah Mada',
            'S1 Pendidikan Biologi, Universitas Brawijaya',
            'S1 Pendidikan Sejarah, Universitas Indonesia',
            'S1 Pendidikan Geografi, Universitas Negeri Malang',
            'S1 Pendidikan Ekonomi, Universitas Sebelas Maret',
            'S1 Pendidikan Sosiologi, Universitas Airlangga',
            'S1 Pendidikan Pancasila dan Kewarganegaraan, UPI',
            'S1 Pendidikan Seni Rupa, Institut Seni Budaya Indonesia',
            'S1 Pendidikan Jasmani, Universitas Negeri Jakarta',
            'S1 Teknik Informatika, Institut Teknologi Sepuluh Nopember',
            'S1 Sastra Jawa, Universitas Gadjah Mada',
            'S1 Pendidikan Agama Islam, UIN Sunan Kalijaga',
            'S1 Teologi, Universitas Kristen Duta Wacana',
            'S1 Administrasi Publik, Universitas Brawijaya',
            'S1 Ilmu Perpustakaan, Universitas Indonesia'
        ];

        $firstNames = [
            'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Gunawan', 'Hani', 'Indra', 'Joko',
            'Kartika', 'Lestari', 'Maya', 'Nur', 'Oki', 'Putri', 'Qori', 'Rina', 'Sari', 'Tono',
            'Umar', 'Vina', 'Wati', 'Xenia', 'Yudi', 'Zara', 'Agus', 'Bayu', 'Candra', 'Dian',
            'Erna', 'Fajar', 'Gita', 'Hendra', 'Ika', 'Jihan', 'Kiki', 'Lina', 'Mira', 'Nanda',
            'Oki', 'Prita', 'Qonita', 'Reza', 'Sinta', 'Tari', 'Ulfa', 'Vera', 'Winda', 'Yanti'
        ];

        $lastNames = [
            'Pratama', 'Sari', 'Wijaya', 'Putri', 'Santoso', 'Lestari', 'Kurniawan', 'Dewi',
            'Setiawan', 'Maharani', 'Nugroho', 'Anggraini', 'Wibowo', 'Safitri', 'Hidayat',
            'Rahayu', 'Susanto', 'Permata', 'Gunawan', 'Indah', 'Purnomo', 'Cahyani', 'Riyadi',
            'Melati', 'Hartono', 'Kusuma', 'Wardani', 'Saputra', 'Handayani', 'Utomo'
        ];

        $teachers = [];
        
        // Since we cleared the table, start with empty arrays
        $usedEmails = []; // Track used emails to prevent duplicates
        $usedNips = []; // Track used NIPs to prevent duplicates

        for ($i = 0; $i < 50; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = $firstName . ' ' . $lastName;
            
            // Generate unique email with counter to ensure uniqueness
            $baseEmail = strtolower(str_replace(' ', '.', $name));
            $email = $baseEmail . '@sman99.sch.id';
            
            // If email already exists, add a number suffix
            $emailCounter = 1;
            while (in_array($email, $usedEmails)) {
                $email = $baseEmail . $emailCounter . '@sman99.sch.id';
                $emailCounter++;
            }
            $usedEmails[] = $email;
            
            // Generate unique NIP with better uniqueness
            do {
                $nip = '19' . rand(70, 99) . sprintf('%02d', rand(1, 12)) . sprintf('%02d', rand(1, 28)) . ' ' . rand(100000, 999999) . ' ' . rand(1, 2) . ' ' . sprintf('%03d', rand(1, 999));
            } while (in_array($nip, $usedNips));
            $usedNips[] = $nip;
            
            // Generate random subjects (1-3 subjects per teacher)
            $teacherSubjects = [];
            $numSubjects = rand(1, 3);
            $selectedSubjects = array_rand($subjects, $numSubjects);
            
            if ($numSubjects == 1) {
                $teacherSubjects[] = $subjects[$selectedSubjects];
            } else {
                foreach ($selectedSubjects as $subjectIndex) {
                    $teacherSubjects[] = $subjects[$subjectIndex];
                }
            }
            
            $position = $positions[array_rand($positions)];
            
            // Adjust subjects based on position
            if ($position === 'Kepala Sekolah' || $position === 'Wakil Kepala Sekolah') {
                $teacherSubjects = ['Manajemen Pendidikan'];
            } elseif ($position === 'Staff Administrasi' || $position === 'Staff TU') {
                $teacherSubjects = ['Administrasi'];
            } elseif ($position === 'Staff Perpustakaan') {
                $teacherSubjects = ['Perpustakaan'];
            } elseif ($position === 'Guru BK') {
                $teacherSubjects = ['Bimbingan Konseling'];
            }

            $teachers[] = [
                'name' => $name,
                'nip' => $nip,
                'email' => $email,
                'phone' => '08' . rand(10, 99) . rand(1000, 9999) . rand(1000, 9999),
                'address' => 'Jl. ' . $lastNames[array_rand($lastNames)] . ' No. ' . rand(1, 100) . ', Semarang',
                'subject' => implode(', ', $teacherSubjects),
                'position' => $position,
                'education' => $educations[array_rand($educations)],
                'photo' => null, // We'll use initials placeholder
                'status' => rand(1, 10) > 1 ? 'active' : 'inactive', // 90% active, 10% inactive
                'user_id' => 1, // Assuming admin user ID is 1
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert all teachers at once using bulk insert
        try {
            DB::table('teachers')->insert($teachers);
            $insertedCount = count($teachers);
            $this->command->info("{$insertedCount} new teachers created successfully!");
        } catch (\Exception $e) {
            $this->command->error('Error inserting teachers: ' . $e->getMessage());
            // Fallback to individual inserts if bulk insert fails
            $insertedCount = 0;
            foreach ($teachers as $teacher) {
                try {
                    DB::table('teachers')->insert($teacher);
                    $insertedCount++;
                } catch (\Exception $e) {
                    $this->command->warn('Skipped teacher: ' . $teacher['name'] . ' (' . $e->getMessage() . ')');
                    continue;
                }
            }
            $this->command->info("{$insertedCount} teachers created successfully after fallback!");
        }

        $totalTeachers = Teacher::count();
        $this->command->info("Total teachers in database: {$totalTeachers}");
    }
}