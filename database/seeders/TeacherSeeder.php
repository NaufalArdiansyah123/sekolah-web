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
        // Clear existing teacher data to prevent duplicates (except demo teacher)
        $this->command->info('Clearing existing teacher data...');
        
        // Get all existing teachers except demo teacher
        $existingTeachers = Teacher::whereHas('user', function($query) {
            $query->where('email', '!=', 'teacher@sman99.sch.id');
        })->get();
        
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

        // Check if demo teacher exists and create Teacher record if needed
        $demoUser = User::where('email', 'teacher@sman99.sch.id')->first();
        if ($demoUser && !Teacher::where('user_id', $demoUser->id)->exists()) {
            Teacher::create([
                'name' => 'Teacher Demo',
                'nip' => '196501011990031001',
                'email' => 'teacher@sman99.sch.id',
                'phone' => '081234567001',
                'address' => 'Jl. Demo No. 1, Ponorogo',
                'subject' => 'Matematika',
                'position' => 'Guru Demo',
                'education' => 'S1 Pendidikan Matematika',
                'status' => 'active',
                'user_id' => $demoUser->id,
            ]);
            $this->command->info('Demo teacher record created.');
        }

        // Data guru dengan mata pelajaran dan posisi yang realistis (14 guru tambahan)
        $teachers = [
            // Kepala Sekolah
            [
                'name' => 'Dr. Ahmad Suryanto, M.Pd',
                'nip' => '196501011990031002',
                'subject' => 'Matematika',
                'position' => 'Kepala Sekolah',
                'education' => 'S3 Pendidikan Matematika',
                'phone' => '081234567002',
                'address' => 'Jl. Raya Ponorogo No. 1, Ponorogo',
            ],
            
            // Wakil Kepala Sekolah
            [
                'name' => 'Dra. Siti Nurhalimah, M.Pd',
                'nip' => '196803151991032003',
                'subject' => 'Bahasa Indonesia',
                'position' => 'Wakil Kepala Sekolah Kurikulum',
                'education' => 'S2 Pendidikan Bahasa Indonesia',
                'phone' => '081234567003',
                'address' => 'Jl. Mawar No. 15, Ponorogo',
            ],
            
            // Guru Matematika
            [
                'name' => 'Drs. Hendra Kusuma, M.Pd',
                'nip' => '196812151994031004',
                'subject' => 'Matematika',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Matematika',
                'phone' => '081234567004',
                'address' => 'Jl. Dahlia No. 20, Ponorogo',
            ],
            
            // Guru Bahasa Indonesia
            [
                'name' => 'Sri Wahyuni, S.Pd, M.Pd',
                'nip' => '197506081998032005',
                'subject' => 'Bahasa Indonesia',
                'position' => 'Guru',
                'education' => 'S2 Pendidikan Bahasa Indonesia',
                'phone' => '081234567005',
                'address' => 'Jl. Kenanga No. 5, Ponorogo',
            ],
            
            // Guru Bahasa Inggris
            [
                'name' => 'Dra. Maria Ulfa, M.Pd',
                'nip' => '197101151996032006',
                'subject' => 'Bahasa Inggris',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Bahasa Inggris',
                'phone' => '081234567006',
                'address' => 'Jl. Teratai No. 9, Ponorogo',
            ],
            
            // Guru Fisika
            [
                'name' => 'Drs. Sutrisno, M.Si',
                'nip' => '196606101991031007',
                'subject' => 'Fisika',
                'position' => 'Guru Senior',
                'education' => 'S2 Fisika',
                'phone' => '081234567007',
                'address' => 'Jl. Sakura No. 25, Ponorogo',
            ],
            
            // Guru Kimia
            [
                'name' => 'Dr. Indra Gunawan, M.Si',
                'nip' => '196804251993031008',
                'subject' => 'Kimia',
                'position' => 'Guru Senior',
                'education' => 'S3 Kimia',
                'phone' => '081234567008',
                'address' => 'Jl. Lavender No. 6, Ponorogo',
            ],
            
            // Guru Biologi
            [
                'name' => 'Dra. Lestari Wulandari, M.Pd',
                'nip' => '197203201997032009',
                'subject' => 'Biologi',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Biologi',
                'phone' => '081234567009',
                'address' => 'Jl. Peony No. 10, Ponorogo',
            ],
            
            // Guru Sejarah
            [
                'name' => 'Drs. Sugiarto, M.Pd',
                'nip' => '196511301990031010',
                'subject' => 'Sejarah',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Sejarah',
                'phone' => '081234567010',
                'address' => 'Jl. Violet No. 23, Ponorogo',
            ],
            
            // Guru Geografi
            [
                'name' => 'Dra. Kartini Sari, M.Pd',
                'nip' => '197405161999032011',
                'subject' => 'Geografi',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Geografi',
                'phone' => '081234567011',
                'address' => 'Jl. Magnolia No. 15, Ponorogo',
            ],
            
            // Guru Ekonomi
            [
                'name' => 'Drs. Hadi Purnomo, M.Pd',
                'nip' => '196807141994031012',
                'subject' => 'Ekonomi',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Ekonomi',
                'phone' => '081234567012',
                'address' => 'Jl. Poppy No. 18, Ponorogo',
            ],
            
            // Guru PKn
            [
                'name' => 'Drs. Joko Susilo, M.Pd',
                'nip' => '196912201996031013',
                'subject' => 'PKn',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Kewarganegaraan',
                'phone' => '081234567013',
                'address' => 'Jl. Begonia No. 9, Ponorogo',
            ],
            
            // Guru Agama Islam
            [
                'name' => 'Drs. H. Abdullah Malik, M.Pd.I',
                'nip' => '196503121991031014',
                'subject' => 'Pendidikan Agama Islam',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Agama Islam',
                'phone' => '081234567014',
                'address' => 'Jl. Masjid No. 1, Ponorogo',
            ],
            
            // Guru Penjaskes
            [
                'name' => 'Drs. Bambang Sutrisno, M.Pd',
                'nip' => '196804101993031015',
                'subject' => 'Pendidikan Jasmani',
                'position' => 'Guru Senior',
                'education' => 'S2 Pendidikan Jasmani',
                'phone' => '081234567015',
                'address' => 'Jl. Stadion No. 2, Ponorogo',
            ],
        ];

        foreach ($teachers as $index => $teacherData) {
            try {
                // Create user account for teacher
                $email = $this->generateEmail($teacherData['name']);
                
                $this->command->info("Creating teacher " . ($index + 2) . "/15: {$teacherData['name']} (NIP: {$teacherData['nip']})");
                
                $user = User::create([
                    'name' => $teacherData['name'],
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'status' => 'active',
                ]);

                // Assign teacher role
                $user->assignRole($teacherRole);

                // Create teacher record
                Teacher::create([
                    'name' => $teacherData['name'],
                    'nip' => $teacherData['nip'],
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

        $this->command->info('15 teachers created successfully (including demo teacher)!');
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
        $email = $baseEmail . '@teacher.sman99.sch.id';
        $counter = 1;
        
        while (User::where('email', $email)->exists()) {
            $email = $baseEmail . $counter . '@teacher.sman99.sch.id';
            $counter++;
        }
        
        return $email;
    }
}