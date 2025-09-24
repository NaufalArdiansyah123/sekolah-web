<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing teacher data to prevent duplicates
        $this->command->info('Clearing existing teacher data...');
        
        // Get all existing teachers and their users
        $existingTeachers = Teacher::all();
        foreach ($existingTeachers as $teacher) {
            if ($teacher->user) {
                $teacher->user->delete(); // This will also delete the teacher due to cascade
            }
        }
        
        // Ensure teacher role exists
        $teacherRole = Role::firstOrCreate([
            'name' => 'teacher',
            'guard_name' => 'web'
        ]);

        // Data guru dengan mata pelajaran dan posisi yang realistis
        $teachers = [
            // Kepala Sekolah dan Wakil
            [
                'name' => 'Dr. Ahmad Suryanto, M.Pd',
                'nip' => '196501011990031001',
                'subject' => 'Matematika',
                'position' => 'Kepala Sekolah',
                'education' => 'S3 Pendidikan Matematika',
                'phone' => '081234567001',
                'address' => 'Jl. Pendidikan No. 1, Balong',
            ],
            [
                'name' => 'Dra. Siti Nurhalimah, M.Pd',
                'nip' => '196803151991032002',
                'subject' => 'Bahasa Indonesia',
                'position' => 'Wakil Kepala Sekolah Kurikulum',
                'education' => 'S2 Pendidikan Bahasa Indonesia',
                'phone' => '081234567002',
                'address' => 'Jl. Mawar No. 15, Balong',
            ],
            [
                'name' => 'Drs. Bambang Wijaya, M.Pd',
                'nip' => '196705201992031003',
                'subject' => 'Fisika',
                'position' => 'Wakil Kepala Sekolah Kesiswaan',
                'education' => 'S2 Pendidikan Fisika',
                'phone' => '081234567003',
                'address' => 'Jl. Melati No. 8, Balong',
            ],
            [
                'name' => 'Dra. Rina Sari Dewi, M.Pd',
                'nip' => '197002101993032004',
                'subject' => 'Kimia',
                'position' => 'Wakil Kepala Sekolah Sarana Prasarana',
                'education' => 'S2 Pendidikan Kimia',
                'phone' => '081234567004',
                'address' => 'Jl. Anggrek No. 12, Balong',
            ],

            // Guru Matematika
            [
                'name' => 'Drs. Hendra Kusuma, M.Pd',
                'nip' => '196812151994031005',
                'subject' => 'Matematika',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Matematika',
                'phone' => '081234567005',
                'address' => 'Jl. Dahlia No. 20, Balong',
            ],
            [
                'name' => 'Sri Wahyuni, S.Pd, M.Pd',
                'nip' => '197506081998032001',
                'subject' => 'Matematika',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Matematika',
                'phone' => '081234567006',
                'address' => 'Jl. Kenanga No. 5, Balong',
            ],
            [
                'name' => 'Agus Prasetyo, S.Pd',
                'nip' => '198203152006041001',
                'subject' => 'Matematika',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Matematika',
                'phone' => '081234567007',
                'address' => 'Jl. Cempaka No. 18, Balong',
            ],

            // Guru Bahasa Indonesia
            [
                'name' => 'Dra. Endang Susilowati',
                'nip' => '196909121995032001',
                'subject' => 'Bahasa Indonesia',
                'position' => 'Guru Senior',
                'education' => 'S1 Pendidikan Bahasa Indonesia',
                'phone' => '081234567008',
                'address' => 'Jl. Flamboyan No. 7, Balong',
            ],
            [
                'name' => 'Ratna Sari, S.Pd, M.Pd',
                'nip' => '197804202003032001',
                'subject' => 'Bahasa Indonesia',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Bahasa Indonesia',
                'phone' => '081234567009',
                'address' => 'Jl. Bougenville No. 14, Balong',
            ],
            [
                'name' => 'Dedi Setiawan, S.Pd',
                'nip' => '198505102009041001',
                'subject' => 'Bahasa Indonesia',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Bahasa Indonesia',
                'phone' => '081234567010',
                'address' => 'Jl. Kamboja No. 22, Balong',
            ],

            // Guru Bahasa Inggris
            [
                'name' => 'Dra. Maria Ulfa, M.Pd',
                'nip' => '197101151996032001',
                'subject' => 'Bahasa Inggris',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Bahasa Inggris',
                'phone' => '081234567011',
                'address' => 'Jl. Teratai No. 9, Balong',
            ],
            [
                'name' => 'Andi Setiawan, S.Pd, M.Pd',
                'nip' => '198001252005041001',
                'subject' => 'Bahasa Inggris',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Bahasa Inggris',
                'phone' => '081234567012',
                'address' => 'Jl. Seroja No. 16, Balong',
            ],
            [
                'name' => 'Fitri Handayani, S.Pd',
                'nip' => '198707152012032001',
                'subject' => 'Bahasa Inggris',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Bahasa Inggris',
                'phone' => '081234567013',
                'address' => 'Jl. Tulip No. 11, Balong',
            ],

            // Guru Fisika
            [
                'name' => 'Drs. Sutrisno, M.Si',
                'nip' => '196606101991031001',
                'subject' => 'Fisika',
                'position' => 'Guru Senior',
                'education' => 'S2 Fisika',
                'phone' => '081234567014',
                'address' => 'Jl. Sakura No. 25, Balong',
            ],
            [
                'name' => 'Yuni Astuti, S.Pd, M.Pd',
                'nip' => '197912082004032001',
                'subject' => 'Fisika',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Fisika',
                'phone' => '081234567015',
                'address' => 'Jl. Azalea No. 3, Balong',
            ],
            [
                'name' => 'Rudi Hartono, S.Pd',
                'nip' => '198408172008041001',
                'subject' => 'Fisika',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Fisika',
                'phone' => '081234567016',
                'address' => 'Jl. Gardenia No. 19, Balong',
            ],

            // Guru Kimia
            [
                'name' => 'Dr. Indra Gunawan, M.Si',
                'nip' => '196804251993031001',
                'subject' => 'Kimia',
                'position' => 'Guru Senior',
                'education' => 'S3 Kimia',
                'phone' => '081234567017',
                'address' => 'Jl. Lavender No. 6, Balong',
            ],
            [
                'name' => 'Sari Rahayu, S.Pd, M.Pd',
                'nip' => '198106152006032001',
                'subject' => 'Kimia',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Kimia',
                'phone' => '081234567018',
                'address' => 'Jl. Lily No. 13, Balong',
            ],
            [
                'name' => 'Budi Santoso, S.Pd',
                'nip' => '198903102014041001',
                'subject' => 'Kimia',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Kimia',
                'phone' => '081234567019',
                'address' => 'Jl. Iris No. 21, Balong',
            ],

            // Guru Biologi
            [
                'name' => 'Dra. Lestari Wulandari, M.Pd',
                'nip' => '197203201997032001',
                'subject' => 'Biologi',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Biologi',
                'phone' => '081234567020',
                'address' => 'Jl. Peony No. 10, Balong',
            ],
            [
                'name' => 'Eko Prasetyo, S.Pd, M.Pd',
                'nip' => '198204182007041001',
                'subject' => 'Biologi',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Biologi',
                'phone' => '081234567021',
                'address' => 'Jl. Carnation No. 17, Balong',
            ],
            [
                'name' => 'Dewi Sartika, S.Pd',
                'nip' => '199001052015032001',
                'subject' => 'Biologi',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Biologi',
                'phone' => '081234567022',
                'address' => 'Jl. Sunflower No. 4, Balong',
            ],

            // Guru Sejarah
            [
                'name' => 'Drs. Sugiarto, M.Pd',
                'nip' => '196511301990031001',
                'subject' => 'Sejarah',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Sejarah',
                'phone' => '081234567023',
                'address' => 'Jl. Violet No. 23, Balong',
            ],
            [
                'name' => 'Nurul Hidayah, S.Pd, M.Pd',
                'nip' => '197708122002032001',
                'subject' => 'Sejarah',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Sejarah',
                'phone' => '081234567024',
                'address' => 'Jl. Jasmine No. 8, Balong',
            ],

            // Guru Geografi
            [
                'name' => 'Dra. Kartini Sari, M.Pd',
                'nip' => '197405161999032001',
                'subject' => 'Geografi',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Geografi',
                'phone' => '081234567025',
                'address' => 'Jl. Magnolia No. 15, Balong',
            ],
            [
                'name' => 'Wahyu Hidayat, S.Pd',
                'nip' => '198606202011041001',
                'subject' => 'Geografi',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Geografi',
                'phone' => '081234567026',
                'address' => 'Jl. Orchid No. 12, Balong',
            ],

            // Guru Ekonomi
            [
                'name' => 'Drs. Hadi Purnomo, M.Pd',
                'nip' => '196807141994031001',
                'subject' => 'Ekonomi',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Ekonomi',
                'phone' => '081234567027',
                'address' => 'Jl. Poppy No. 18, Balong',
            ],
            [
                'name' => 'Lia Permata, S.Pd, M.Pd',
                'nip' => '198309252008032001',
                'subject' => 'Ekonomi',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Ekonomi',
                'phone' => '081234567028',
                'address' => 'Jl. Daffodil No. 7, Balong',
            ],

            // Guru Sosiologi
            [
                'name' => 'Dra. Retno Wulandari',
                'nip' => '197006081995032001',
                'subject' => 'Sosiologi',
                'position' => 'Guru Senior',
                'education' => 'S1 Pendidikan Sosiologi',
                'phone' => '081234567029',
                'address' => 'Jl. Zinnia No. 20, Balong',
            ],
            [
                'name' => 'Arif Rahman, S.Pd',
                'nip' => '198812152013041001',
                'subject' => 'Sosiologi',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Sosiologi',
                'phone' => '081234567030',
                'address' => 'Jl. Cosmos No. 14, Balong',
            ],

            // Guru PKn
            [
                'name' => 'Drs. Joko Susilo, M.Pd',
                'nip' => '196912201996031001',
                'subject' => 'PKn',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Kewarganegaraan',
                'phone' => '081234567031',
                'address' => 'Jl. Begonia No. 9, Balong',
            ],
            [
                'name' => 'Sinta Dewi, S.Pd',
                'nip' => '199105102016032001',
                'subject' => 'PKn',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Kewarganegaraan',
                'phone' => '081234567032',
                'address' => 'Jl. Hibiscus No. 16, Balong',
            ],

            // Guru Agama Islam
            [
                'name' => 'Drs. H. Abdullah Malik, M.Pd.I',
                'nip' => '196503121991031001',
                'subject' => 'Pendidikan Agama Islam',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Agama Islam',
                'phone' => '081234567033',
                'address' => 'Jl. Masjid No. 1, Balong',
            ],
            [
                'name' => 'Hj. Fatimah Zahra, S.Pd.I, M.Pd.I',
                'nip' => '197611182001032001',
                'subject' => 'Pendidikan Agama Islam',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Agama Islam',
                'phone' => '081234567034',
                'address' => 'Jl. Pondok No. 5, Balong',
            ],

            // Guru Agama Kristen
            [
                'name' => 'Drs. Petrus Simanungkalit, M.Th',
                'nip' => '197002152000031001',
                'subject' => 'Pendidikan Agama Kristen',
                'position' => 'Guru',
                'education' => 'S2 Teologi',
                'phone' => '081234567035',
                'address' => 'Jl. Gereja No. 3, Balong',
            ],

            // Guru Agama Katolik
            [
                'name' => 'Maria Goretti, S.Pd, M.Pd',
                'nip' => '197809252005032001',
                'subject' => 'Pendidikan Agama Katolik',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Agama Katolik',
                'phone' => '081234567036',
                'address' => 'Jl. Kapel No. 7, Balong',
            ],

            // Guru Penjaskes
            [
                'name' => 'Drs. Bambang Sutrisno, M.Pd',
                'nip' => '196804101993031001',
                'subject' => 'Pendidikan Jasmani',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Jasmani',
                'phone' => '081234567037',
                'address' => 'Jl. Stadion No. 2, Balong',
            ],
            [
                'name' => 'Rina Oktavia, S.Pd',
                'nip' => '198502142010032001',
                'subject' => 'Pendidikan Jasmani',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Jasmani',
                'phone' => '081234567038',
                'address' => 'Jl. Lapangan No. 8, Balong',
            ],

            // Guru Seni Budaya
            [
                'name' => 'Dra. Sari Indah Lestari, M.Sn',
                'nip' => '197107201998032001',
                'subject' => 'Seni Budaya',
                'position' => 'Guru Senior',
                'education' => 'S2 Seni Rupa',
                'phone' => '081234567039',
                'address' => 'Jl. Seni No. 4, Balong',
            ],
            [
                'name' => 'Dedi Mulyadi, S.Pd',
                'nip' => '198710152012041001',
                'subject' => 'Seni Budaya',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Seni Musik',
                'phone' => '081234567040',
                'address' => 'Jl. Musik No. 6, Balong',
            ],

            // Guru TIK/Informatika
            [
                'name' => 'Andi Wijaya, S.Kom, M.Pd',
                'nip' => '198403122009041001',
                'subject' => 'Informatika',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Teknologi Informasi',
                'phone' => '081234567041',
                'address' => 'Jl. Komputer No. 10, Balong',
            ],
            [
                'name' => 'Rini Susanti, S.Pd',
                'nip' => '199204182017032001',
                'subject' => 'Informatika',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Teknologi Informasi',
                'phone' => '081234567042',
                'address' => 'Jl. Digital No. 12, Balong',
            ],

            // Guru Prakarya
            [
                'name' => 'Drs. Sutopo Handoyo',
                'nip' => '196909151995031001',
                'subject' => 'Prakarya',
                'position' => 'Guru Senior',
                'education' => 'S1 Pendidikan Teknik',
                'phone' => '081234567043',
                'address' => 'Jl. Karya No. 15, Balong',
            ],
            [
                'name' => 'Lina Marlina, S.Pd',
                'nip' => '198908252014032001',
                'subject' => 'Prakarya',
                'position' => 'Guru',
                'education' => 'S1 Pendidikan Kesejahteraan Keluarga',
                'phone' => '081234567044',
                'address' => 'Jl. Kreasi No. 18, Balong',
            ],

            // Guru BK
            [
                'name' => 'Dra. Wiwik Suryani, M.Pd',
                'nip' => '197304182000032001',
                'subject' => 'Bimbingan Konseling',
                'position' => 'Guru BK Senior',
                'education' => 'S2 Bimbingan Konseling',
                'phone' => '081234567045',
                'address' => 'Jl. Konseling No. 3, Balong',
            ],
            [
                'name' => 'Eko Susilo, S.Pd',
                'nip' => '198601102011041001',
                'subject' => 'Bimbingan Konseling',
                'position' => 'Guru BK',
                'education' => 'S1 Bimbingan Konseling',
                'phone' => '081234567046',
                'address' => 'Jl. Bimbingan No. 7, Balong',
            ],

            // Pustakawan
            [
                'name' => 'Dra. Tri Wahyuni',
                'nip' => '197508122001032001',
                'subject' => 'Perpustakaan',
                'position' => 'Pustakawan',
                'education' => 'S1 Ilmu Perpustakaan',
                'phone' => '081234567047',
                'address' => 'Jl. Buku No. 9, Balong',
            ],

            // Laboran
            [
                'name' => 'Agus Setiawan, S.Si',
                'nip' => '198205152007041001',
                'subject' => 'Laboratorium',
                'position' => 'Laboran',
                'education' => 'S1 Kimia',
                'phone' => '081234567048',
                'address' => 'Jl. Lab No. 11, Balong',
            ],

            // Teknisi
            [
                'name' => 'Rudi Kurniawan, S.T',
                'nip' => '198712202012041001',
                'subject' => 'Teknisi',
                'position' => 'Teknisi IT',
                'education' => 'S1 Teknik Informatika',
                'phone' => '081234567049',
                'address' => 'Jl. Teknologi No. 13, Balong',
            ],

            // Tenaga Administrasi
            [
                'name' => 'Siti Aminah, S.Pd',
                'nip' => '198903152014032001',
                'subject' => 'Administrasi',
                'position' => 'Tenaga Administrasi',
                'education' => 'S1 Administrasi Pendidikan',
                'phone' => '081234567050',
                'address' => 'Jl. Admin No. 17, Balong',
            ],
        ];

        foreach ($teachers as $index => $teacherData) {
            try {
                // Create user account for teacher
                $email = $this->generateEmail($teacherData['name']);
                $nip = $this->generateSequentialNip($teacherData['nip'], $index);
                
                $this->command->info("Creating teacher " . ($index + 1) . "/50: {$teacherData['name']} (NIP: {$nip})");
                
                $user = User::create([
                    'name' => $teacherData['name'],
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]);

                // Assign teacher role
                $user->assignRole($teacherRole);

                // Create teacher record
                Teacher::create([
                    'name' => $teacherData['name'],
                    'nip' => $nip,
                    'email' => $email,
                    'phone' => $teacherData['phone'],
                    'address' => $teacherData['address'],
                    'subject' => $teacherData['subject'],
                    'position' => $teacherData['position'],
                    'education' => $teacherData['education'],
                    'status' => 'active',
                    'user_id' => $user->id,
                ]);
                
            } catch (\Exception $e) {
                $this->command->error("Failed to create teacher {$teacherData['name']}: " . $e->getMessage());
                continue;
            }
        }

        $this->command->info('50 teachers created successfully!');
    }

    /**
     * Generate email from teacher name
     */
    private function generateEmail($name)
    {
        // Remove titles and degrees
        $cleanName = preg_replace('/\b(Dr\.|Drs\.|Dra\.|H\.|Hj\.|S\.Pd|M\.Pd|M\.Si|M\.Sn|M\.Th|M\.Pd\.I|S\.Pd\.I|S\.Kom|S\.Si|S\.T)\b/i', '', $name);
        $cleanName = trim(preg_replace('/\s+/', ' ', $cleanName));
        
        // Convert to lowercase and replace spaces with dots
        $baseEmail = strtolower(str_replace([' ', ','], ['.', ''], $cleanName));
        
        // Remove multiple dots
        $baseEmail = preg_replace('/\.+/', '.', $baseEmail);
        
        // Remove leading/trailing dots
        $baseEmail = trim($baseEmail, '.');
        
        // Check for existing email and add number if needed
        $email = $baseEmail . '@teacher.sman1balong.sch.id';
        $counter = 1;
        
        while (User::where('email', $email)->exists()) {
            $email = $baseEmail . $counter . '@teacher.sman1balong.sch.id';
            $counter++;
        }
        
        return $email;
    }

    /**
     * Generate completely unique NIP
     */
    private function generateSequentialNip($baseNip, $index)
    {
        // Simple approach: use base year and sequential numbering
        $baseYear = '2024'; // Current year
        $baseMonth = '01';  // January
        $baseDay = '01';    // 1st
        
        // Create sequential number with 11 digits (total 18 digits)
        $sequentialNumber = str_pad($index + 1, 11, '0', STR_PAD_LEFT);
        
        $nip = $baseYear . $baseMonth . $baseDay . $sequentialNumber;
        
        // Double check for uniqueness (should not be needed with this approach)
        $counter = 1;
        $originalNip = $nip;
        while (Teacher::where('nip', $nip)->exists()) {
            $newSequential = str_pad(($index + 1) * 1000 + $counter, 11, '0', STR_PAD_LEFT);
            $nip = $baseYear . $baseMonth . $baseDay . $newSequential;
            $counter++;
            
            // Safety break
            if ($counter > 1000) {
                $nip = $baseYear . $baseMonth . $baseDay . time() . str_pad($index, 3, '0', STR_PAD_LEFT);
                break;
            }
        }
        
        return $nip;
    }
}