<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Extracurricular;
use Illuminate\Support\Facades\DB;

class ExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data safely
        $existingCount = Extracurricular::count();
        if ($existingCount > 0) {
            $this->command->info("Found {$existingCount} existing extracurriculars. Clearing existing data to create fresh seed data.");
            
            // Disable foreign key checks temporarily
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Clear related tables first
            DB::table('extracurricular_registrations')->delete();
            DB::table('broadcast_messages')->where('extracurricular_id', '!=', null)->delete();
            
            // Now clear extracurriculars
            DB::table('extracurriculars')->delete();
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->command->info('Existing extracurriculars and related data cleared.');
        }

        $extracurriculars = [
            [
                'name' => 'Pramuka',
                'description' => 'Kegiatan kepramukaan untuk mengembangkan karakter dan kepemimpinan siswa.',
                'coach' => 'Budi Santoso, S.Pd',
                'schedule' => 'Setiap Jumat, 14:00 - 16:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Basket',
                'description' => 'Ekstrakurikuler olahraga basket untuk mengembangkan kemampuan fisik dan kerjasama tim.',
                'coach' => 'Ahmad Wijaya, S.Pd',
                'schedule' => 'Senin & Rabu, 15:30 - 17:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Futsal',
                'description' => 'Ekstrakurikuler futsal untuk melatih keterampilan sepak bola dan sportivitas.',
                'coach' => 'Dedi Kurniawan, S.Pd',
                'schedule' => 'Selasa & Kamis, 15:30 - 17:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paduan Suara',
                'description' => 'Kegiatan seni musik vokal untuk mengembangkan bakat bernyanyi siswa.',
                'coach' => 'Sari Melati, S.Pd',
                'schedule' => 'Rabu, 14:00 - 16:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tari Tradisional',
                'description' => 'Ekstrakurikuler tari untuk melestarikan budaya dan seni tari tradisional Indonesia.',
                'coach' => 'Dewi Anggraini, S.Pd',
                'schedule' => 'Kamis, 14:00 - 16:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'English Club',
                'description' => 'Klub bahasa Inggris untuk meningkatkan kemampuan berbahasa Inggris siswa.',
                'coach' => 'Maya Putri, S.Pd',
                'schedule' => 'Jumat, 13:00 - 15:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Robotika',
                'description' => 'Ekstrakurikuler teknologi untuk mengembangkan kemampuan programming dan robotika.',
                'coach' => 'Eko Prasetyo, S.Kom',
                'schedule' => 'Sabtu, 08:00 - 11:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PMR (Palang Merah Remaja)',
                'description' => 'Kegiatan kepalangmerahan untuk mengembangkan jiwa sosial dan kemampuan pertolongan pertama.',
                'coach' => 'Dr. Fitri Handayani',
                'schedule' => 'Sabtu, 13:00 - 15:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jurnalistik',
                'description' => 'Ekstrakurikuler jurnalistik untuk mengembangkan kemampuan menulis dan jurnalistik siswa.',
                'coach' => 'Rina Sari, S.Pd',
                'schedule' => 'Selasa, 14:00 - 16:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Karate',
                'description' => 'Ekstrakurikuler bela diri karate untuk melatih disiplin dan kemampuan bela diri.',
                'coach' => 'Sensei Agus Nugroho',
                'schedule' => 'Senin & Kamis, 16:00 - 18:00',
                'status' => 'active',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        try {
            DB::table('extracurriculars')->insert($extracurriculars);
            $insertedCount = count($extracurriculars);
            $this->command->info("{$insertedCount} extracurriculars created successfully!");
        } catch (\Exception $e) {
            $this->command->error('Error inserting extracurriculars: ' . $e->getMessage());
        }

        $totalExtracurriculars = Extracurricular::count();
        $this->command->info("Total extracurriculars in database: {$totalExtracurriculars}");
    }
}