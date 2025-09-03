<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $announcements = [
            [
                'judul' => 'Pengumuman Jadwal Ujian Tengah Semester Ganjil 2024/2025',
                'isi' => 'Kepada seluruh siswa SMA Negeri 1 Balong, dengan ini diinformasikan bahwa Ujian Tengah Semester (UTS) Ganjil tahun pelajaran 2024/2025 akan dilaksanakan pada tanggal 1-8 November 2024. Siswa diharapkan mempersiapkan diri dengan baik dan mengikuti seluruh rangkaian ujian sesuai jadwal yang telah ditentukan. Untuk informasi lebih detail mengenai jadwal ujian per mata pelajaran, silakan lihat pengumuman yang telah ditempel di papan pengumuman sekolah atau website resmi sekolah.',
                'kategori' => 'akademik',
                'prioritas' => 'tinggi',
                'penulis' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                'status' => 'published',
                'views' => 125,
                'tanggal_publikasi' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'judul' => 'Peringatan Hari Sumpah Pemuda ke-96',
                'isi' => 'Dalam rangka memperingati Hari Sumpah Pemuda ke-96, SMA Negeri 1 Balong akan mengadakan serangkaian kegiatan mulai tanggal 25-28 Oktober 2024. Kegiatan meliputi upacara bendera, lomba kreativitas siswa, dan pertunjukan seni budaya. Seluruh siswa wajib mengikuti kegiatan ini sebagai bentuk penghargaan terhadap jasa para pemuda Indonesia. Panitia pelaksana telah menyiapkan berbagai lomba menarik seperti lomba pidato, lomba poster, dan pertunjukan tari tradisional.',
                'kategori' => 'kegiatan',
                'prioritas' => 'sedang',
                'penulis' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
                'status' => 'published',
                'views' => 89,
                'tanggal_publikasi' => Carbon::now()->subDays(3),
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'judul' => 'Pembayaran SPP Bulan November 2024',
                'isi' => 'Kepada orang tua/wali siswa, pembayaran SPP bulan November 2024 dapat dilakukan mulai tanggal 1 November 2024 melalui bank yang telah ditunjuk atau sistem pembayaran online. Batas akhir pembayaran adalah tanggal 15 November 2024. Bank yang bekerjasama dengan sekolah antara lain BRI, BNI, dan Mandiri. Untuk pembayaran online dapat melalui aplikasi mobile banking atau internet banking. Terima kasih atas perhatian dan kerjasamanya.',
                'kategori' => 'administrasi',
                'prioritas' => 'sedang',
                'penulis' => 'Bagian Tata Usaha',
                'status' => 'published',
                'views' => 76,
                'tanggal_publikasi' => Carbon::now()->subDays(4),
                'created_at' => Carbon::now()->subDays(4),
            ],
            [
                'judul' => 'Workshop Teknologi Pendidikan untuk Guru',
                'isi' => 'Akan dilaksanakan workshop teknologi pendidikan untuk seluruh guru SMA Negeri 1 Balong pada tanggal 31 Oktober 2024 pukul 08.00-15.00 WIB di Aula sekolah. Workshop ini bertujuan untuk meningkatkan kemampuan guru dalam menggunakan teknologi untuk mendukung proses pembelajaran. Materi yang akan dibahas meliputi penggunaan platform e-learning, aplikasi pembelajaran interaktif, dan teknik multimedia dalam pembelajaran. Narasumber dari Universitas Pendidikan Indonesia.',
                'kategori' => 'akademik',
                'prioritas' => 'sedang',
                'penulis' => 'Kepala Sekolah',
                'status' => 'published',
                'views' => 43,
                'tanggal_publikasi' => Carbon::now()->subDays(5),
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'judul' => 'Penerimaan Siswa Baru Tahun Ajaran 2025/2026',
                'isi' => 'Informasi penerimaan siswa baru untuk tahun ajaran 2025/2026 akan segera diumumkan. Pendaftaran dibuka mulai bulan Januari 2025. Persyaratan dan prosedur pendaftaran dapat dilihat di website resmi sekolah.',
                'kategori' => 'administrasi',
                'prioritas' => 'tinggi',
                'penulis' => 'Panitia PSB',
                'status' => 'published',
                'views' => 234,
                'tanggal_publikasi' => Carbon::now()->subDays(10),
                'created_at' => Carbon::now()->subDays(10),
            ]
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}