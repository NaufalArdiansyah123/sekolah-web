<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CalendarEvent;
use App\Models\User;
use Carbon\Carbon;

class CalendarEventSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get admin user or create one
        $admin = User::whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->first();

        if (!$admin) {
            // If no admin found, use the first user
            $admin = User::first();
        }

        if (!$admin) {
            $this->command->warn('No users found. Please create users first.');
            return;
        }

        $events = [
            [
                'title' => 'Tahun Ajaran Baru 2025/2026',
                'description' => 'Dimulainya tahun ajaran baru untuk periode 2025/2026',
                'start_date' => Carbon::create(2024, 7, 15),
                'end_date' => Carbon::create(2024, 7, 15),
                'start_time' => '07:00',
                'end_time' => '12:00',
                'category' => 'akademik',
                'color' => '#3182ce',
                'location' => 'SMK PGRI 2 PONOROGO',
                'is_all_day' => false,
                'created_by' => $admin->id
            ],
            [
                'title' => 'Ujian Tengah Semester Ganjil',
                'description' => 'Pelaksanaan Ujian Tengah Semester untuk semester ganjil tahun ajaran 2025/2026',
                'start_date' => Carbon::create(2024, 10, 7),
                'end_date' => Carbon::create(2024, 10, 14),
                'category' => 'ujian',
                'color' => '#dc2626',
                'location' => 'Ruang Kelas',
                'is_all_day' => true,
                'created_by' => $admin->id
            ],
            [
                'title' => 'Libur Semester Ganjil',
                'description' => 'Libur semester ganjil tahun ajaran 2025/2026',
                'start_date' => Carbon::create(2024, 12, 23),
                'end_date' => Carbon::create(2025, 1, 8),
                'category' => 'libur',
                'color' => '#7c3aed',
                'is_all_day' => true,
                'created_by' => $admin->id
            ],
            [
                'title' => 'Hari Kemerdekaan RI',
                'description' => 'Peringatan Hari Kemerdekaan Republik Indonesia ke-79',
                'start_date' => Carbon::create(2024, 8, 17),
                'end_date' => Carbon::create(2024, 8, 17),
                'start_time' => '07:00',
                'end_time' => '11:00',
                'category' => 'hari-besar',
                'color' => '#059669',
                'location' => 'Lapangan Sekolah',
                'is_all_day' => false,
                'created_by' => $admin->id
            ],
            [
                'title' => 'Rapat Koordinasi Guru',
                'description' => 'Rapat koordinasi bulanan untuk semua guru dan staff',
                'start_date' => Carbon::create(2024, 9, 5),
                'end_date' => Carbon::create(2024, 9, 5),
                'start_time' => '13:00',
                'end_time' => '15:00',
                'category' => 'rapat',
                'color' => '#db2777',
                'location' => 'Ruang Guru',
                'is_all_day' => false,
                'created_by' => $admin->id
            ],
            [
                'title' => 'Penerimaan Peserta Didik Baru',
                'description' => 'Periode pendaftaran dan seleksi peserta didik baru tahun ajaran 2025/2026',
                'start_date' => Carbon::create(2025, 6, 1),
                'end_date' => Carbon::create(2025, 6, 30),
                'category' => 'akademik',
                'color' => '#3182ce',
                'location' => 'Kantor Tata Usaha',
                'is_all_day' => true,
                'created_by' => $admin->id
            ],
            [
                'title' => 'Festival Seni dan Budaya',
                'description' => 'Festival tahunan seni dan budaya sekolah dengan berbagai pertunjukan dan pameran',
                'start_date' => Carbon::create(2024, 11, 15),
                'end_date' => Carbon::create(2024, 11, 17),
                'category' => 'kegiatan',
                'color' => '#d97706',
                'location' => 'Aula Sekolah',
                'is_all_day' => true,
                'created_by' => $admin->id
            ],
            [
                'title' => 'Kompetisi Robotika',
                'description' => 'Kompetisi robotika tingkat sekolah untuk ekstrakurikuler robotika',
                'start_date' => Carbon::create(2024, 10, 25),
                'end_date' => Carbon::create(2024, 10, 25),
                'start_time' => '08:00',
                'end_time' => '16:00',
                'category' => 'ekstrakurikuler',
                'color' => '#0891b2',
                'location' => 'Lab Komputer',
                'is_all_day' => false,
                'created_by' => $admin->id
            ],
            [
                'title' => 'Ujian Akhir Semester Ganjil',
                'description' => 'Pelaksanaan Ujian Akhir Semester untuk semester ganjil',
                'start_date' => Carbon::create(2024, 12, 2),
                'end_date' => Carbon::create(2024, 12, 14),
                'category' => 'ujian',
                'color' => '#dc2626',
                'location' => 'Ruang Kelas',
                'is_all_day' => true,
                'created_by' => $admin->id
            ],
            [
                'title' => 'Pelatihan Guru Digital',
                'description' => 'Workshop pelatihan penggunaan teknologi digital dalam pembelajaran',
                'start_date' => Carbon::create(2024, 9, 20),
                'end_date' => Carbon::create(2024, 9, 21),
                'start_time' => '08:00',
                'end_time' => '16:00',
                'category' => 'rapat',
                'color' => '#db2777',
                'location' => 'Lab Komputer',
                'is_all_day' => false,
                'created_by' => $admin->id
            ]
        ];

        foreach ($events as $eventData) {
            CalendarEvent::create($eventData);
        }

        $this->command->info('Calendar events seeded successfully!');
    }
}