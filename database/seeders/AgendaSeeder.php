<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user or create one
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $agendas = [
            [
                'title' => 'Upacara Bendera Hari Senin',
                'content' => '<p>Upacara bendera rutin setiap hari Senin untuk seluruh siswa dan guru. Upacara dimulai tepat pukul 07.00 WIB di lapangan sekolah.</p><p><strong>Ketentuan:</strong></p><ul><li>Seluruh siswa wajib hadir</li><li>Menggunakan seragam lengkap</li><li>Membawa topi sekolah</li><li>Datang 15 menit sebelum upacara dimulai</li></ul>',
                'event_date' => Carbon::now()->next(Carbon::MONDAY)->setTime(7, 0),
                'location' => 'Lapangan Sekolah',
                'status' => 'active',
            ],
            [
                'title' => 'Rapat Orang Tua Siswa Kelas XII',
                'content' => '<p>Rapat koordinasi antara pihak sekolah dengan orang tua siswa kelas XII membahas persiapan ujian nasional dan kelulusan.</p><p><strong>Agenda Rapat:</strong></p><ol><li>Pembukaan dan sambutan kepala sekolah</li><li>Penjelasan jadwal ujian nasional</li><li>Persiapan siswa menghadapi ujian</li><li>Rencana kegiatan kelulusan</li><li>Tanya jawab</li></ol>',
                'event_date' => Carbon::now()->addDays(5)->setTime(9, 0),
                'location' => 'Aula Sekolah',
                'status' => 'active',
            ],
            [
                'title' => 'Lomba Karya Tulis Ilmiah',
                'content' => '<p>Kompetisi karya tulis ilmiah tingkat sekolah untuk siswa kelas X dan XI. Tema tahun ini adalah "Teknologi Ramah Lingkungan untuk Masa Depan".</p><p><strong>Ketentuan Lomba:</strong></p><ul><li>Peserta maksimal 3 orang per tim</li><li>Karya tulis maksimal 15 halaman</li><li>Format sesuai panduan yang telah dibagikan</li><li>Deadline pengumpulan: 2 minggu setelah pengumuman</li></ul>',
                'event_date' => Carbon::now()->addDays(10)->setTime(8, 0),
                'location' => 'Perpustakaan Sekolah',
                'status' => 'active',
            ],
            [
                'title' => 'Pelatihan Komputer untuk Guru',
                'content' => '<p>Program pelatihan penggunaan teknologi dalam pembelajaran untuk seluruh guru dan staf pengajar.</p><p><strong>Materi Pelatihan:</strong></p><ul><li>Penggunaan platform pembelajaran online</li><li>Membuat konten digital interaktif</li><li>Evaluasi pembelajaran berbasis teknologi</li><li>Tips dan trik mengajar di era digital</li></ul>',
                'event_date' => Carbon::now()->addDays(7)->setTime(13, 30),
                'location' => 'Lab Komputer',
                'status' => 'active',
            ],
            [
                'title' => 'Kegiatan Bakti Sosial',
                'content' => '<p>Kegiatan bakti sosial bersama masyarakat sekitar sekolah dalam rangka memperingati hari kemerdekaan Indonesia.</p><p><strong>Kegiatan meliputi:</strong></p><ul><li>Gotong royong membersihkan lingkungan</li><li>Pembagian sembako untuk warga kurang mampu</li><li>Pemeriksaan kesehatan gratis</li><li>Lomba-lomba untuk anak-anak</li></ul>',
                'event_date' => Carbon::now()->addDays(15)->setTime(8, 0),
                'location' => 'Desa Sekitar Sekolah',
                'status' => 'active',
            ],
            [
                'title' => 'Seminar Motivasi Belajar',
                'content' => '<p>Seminar motivasi belajar dengan menghadirkan pembicara inspiratif untuk meningkatkan semangat belajar siswa.</p><p><strong>Pembicara:</strong></p><ul><li>Dr. Ahmad Wijaya - Psikolog Pendidikan</li><li>Sarah Putri - Motivator Muda</li><li>Prof. Budi Santoso - Ahli Pendidikan</li></ul>',
                'event_date' => Carbon::now()->addDays(20)->setTime(9, 0),
                'location' => 'Aula Sekolah',
                'status' => 'active',
            ],
            [
                'title' => 'Ujian Tengah Semester',
                'content' => '<p>Pelaksanaan Ujian Tengah Semester (UTS) untuk seluruh siswa kelas X, XI, dan XII.</p><p><strong>Jadwal Ujian:</strong></p><ul><li>Senin-Rabu: Kelas X</li><li>Kamis-Sabtu: Kelas XI</li><li>Minggu depan: Kelas XII</li></ul><p><strong>Ketentuan:</strong></p><ul><li>Siswa hadir 30 menit sebelum ujian</li><li>Membawa alat tulis lengkap</li><li>Tidak diperbolehkan membawa HP</li></ul>',
                'event_date' => Carbon::now()->addDays(25)->setTime(7, 30),
                'location' => 'Ruang Kelas Masing-masing',
                'status' => 'active',
            ],
            [
                'title' => 'Festival Seni dan Budaya',
                'content' => '<p>Festival tahunan untuk menampilkan kreativitas siswa dalam bidang seni dan budaya Indonesia.</p><p><strong>Kategori Lomba:</strong></p><ul><li>Tari tradisional</li><li>Musik daerah</li><li>Puisi dan pantun</li><li>Lukis dan kaligrafi</li><li>Drama dan teater</li></ul>',
                'event_date' => Carbon::now()->addDays(30)->setTime(8, 0),
                'location' => 'Aula dan Lapangan Sekolah',
                'status' => 'active',
            ],
        ];

        foreach ($agendas as $agendaData) {
            Post::create([
                'title' => $agendaData['title'],
                'slug' => \Str::slug($agendaData['title']),
                'content' => $agendaData['content'],
                'type' => 'agenda',
                'event_date' => $agendaData['event_date'],
                'location' => $agendaData['location'],
                'status' => $agendaData['status'],
                'user_id' => $user->id,
                'published_at' => now(),
            ]);
        }
    }
}