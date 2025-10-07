<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if contacts table exists
        if (!DB::getSchemaBuilder()->hasTable('contacts')) {
            $this->command->info('Contacts table does not exist. Skipping ContactSeeder.');
            return;
        }

        // Clear existing contacts
        DB::table('contacts')->truncate();

        // Sample contact data
        $contacts = [
            [
                'name' => 'Ahmad Rizki Pratama',
                'email' => 'ahmad.rizki@gmail.com',
                'phone' => '081234567890',
                'subject' => 'Informasi Pendaftaran Siswa Baru',
                'message' => 'Selamat pagi, saya ingin menanyakan tentang prosedur pendaftaran siswa baru untuk tahun ajaran 2024/2025. Apakah masih ada kuota untuk jurusan Teknik Komputer dan Jaringan? Terima kasih.',
                'status' => 'unread',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@gmail.com',
                'phone' => '081234567891',
                'subject' => 'Pertanyaan tentang Ekstrakurikuler',
                'message' => 'Halo, saya adalah orang tua dari siswa kelas X. Saya ingin mengetahui ekstrakurikuler apa saja yang tersedia di sekolah dan bagaimana cara mendaftarkannya. Mohon informasinya.',
                'status' => 'read',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(2),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'phone' => '081234567892',
                'subject' => 'Kerjasama Industri',
                'message' => 'Selamat siang, saya dari PT. Teknologi Maju. Kami tertarik untuk menjalin kerjasama dengan sekolah dalam hal magang siswa dan penyerapan lulusan. Bisakah kami berdiskusi lebih lanjut?',
                'status' => 'replied',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(6),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@gmail.com',
                'phone' => '081234567893',
                'subject' => 'Informasi Beasiswa',
                'message' => 'Saya ingin menanyakan apakah sekolah menyediakan program beasiswa untuk siswa berprestasi atau kurang mampu? Jika ada, bagaimana prosedur pendaftarannya?',
                'status' => 'unread',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi.wijaya@gmail.com',
                'phone' => '081234567894',
                'subject' => 'Fasilitas Laboratorium',
                'message' => 'Sebagai calon siswa, saya ingin mengetahui fasilitas laboratorium yang tersedia di sekolah, khususnya untuk jurusan Rekayasa Perangkat Lunak. Apakah ada lab khusus programming?',
                'status' => 'read',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(3),
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari@gmail.com',
                'phone' => '081234567895',
                'subject' => 'Jadwal Kunjungan Sekolah',
                'message' => 'Saya adalah orang tua calon siswa. Apakah sekolah mengadakan open house atau kunjungan untuk melihat fasilitas sekolah? Jika ada, kapan jadwalnya?',
                'status' => 'unread',
                'created_at' => now()->subHours(6),
                'updated_at' => now()->subHours(6),
            ],
            [
                'name' => 'Rizky Firmansyah',
                'email' => 'rizky.firmansyah@gmail.com',
                'phone' => '081234567896',
                'subject' => 'Program Sertifikasi',
                'message' => 'Halo, saya ingin tahu apakah sekolah memiliki program sertifikasi industri untuk siswa? Seperti sertifikasi Cisco, Microsoft, atau Adobe?',
                'status' => 'replied',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(7),
            ],
            [
                'name' => 'Indah Permata',
                'email' => 'indah.permata@gmail.com',
                'phone' => '081234567897',
                'subject' => 'Biaya Pendidikan',
                'message' => 'Selamat pagi, saya ingin menanyakan tentang rincian biaya pendidikan untuk tahun ajaran mendatang. Apakah ada sistem cicilan untuk pembayaran?',
                'status' => 'read',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar.nugroho@gmail.com',
                'phone' => '081234567898',
                'subject' => 'Alumni Network',
                'message' => 'Saya adalah alumni tahun 2020. Apakah sekolah memiliki program alumni network atau kegiatan reuni? Saya ingin tetap terhubung dengan sekolah.',
                'status' => 'replied',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(9),
            ],
            [
                'name' => 'Putri Maharani',
                'email' => 'putri.maharani@gmail.com',
                'phone' => '081234567899',
                'subject' => 'Prestasi Sekolah',
                'message' => 'Saya ingin mengetahui prestasi-prestasi yang telah diraih sekolah dalam beberapa tahun terakhir, baik akademik maupun non-akademik. Terima kasih.',
                'status' => 'unread',
                'created_at' => now()->subHours(12),
                'updated_at' => now()->subHours(12),
            ],
        ];

        // Insert contact data
        foreach ($contacts as $contact) {
            DB::table('contacts')->insert($contact);
        }

        $this->command->info('Contact data seeded successfully!');
        $this->command->info('Created ' . count($contacts) . ' contact entries.');
    }
}