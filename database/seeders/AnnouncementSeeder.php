<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'judul' => 'Ujian Tengah Semester Genap 2024/2025',
                'isi' => '<p>Pelaksanaan Ujian Tengah Semester (UTS) untuk semester genap tahun ajaran 2024/2025 akan dimulai pada minggu depan sesuai dengan jadwal yang telah ditentukan.</p>

<h3>Jadwal UTS:</h3>
<ul>
<li>Senin, 27 Januari 2025: Matematika dan Bahasa Indonesia</li>
<li>Selasa, 28 Januari 2025: Bahasa Inggris dan IPA</li>
<li>Rabu, 29 Januari 2025: IPS dan Seni Budaya</li>
<li>Kamis, 30 Januari 2025: Pendidikan Agama dan PKn</li>
<li>Jumat, 31 Januari 2025: Penjaskes dan Prakarya</li>
</ul>

<h3>Ketentuan Ujian:</h3>
<ul>
<li>Siswa wajib hadir 15 menit sebelum ujian dimulai</li>
<li>Membawa alat tulis lengkap dan kartu peserta ujian</li>
<li>Tidak diperbolehkan membawa HP atau alat komunikasi lainnya</li>
<li>Berpakaian seragam sekolah lengkap dan rapi</li>
</ul>

<p>Bagi siswa yang berhalangan hadir karena sakit harus menyertakan surat keterangan dokter untuk dapat mengikuti ujian susulan.</p>',
                'kategori' => 'akademik',
                'prioritas' => 'tinggi',
                'penulis' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                'status' => 'published',
                'views' => 245,
                'tanggal_publikasi' => Carbon::now()->subDays(3),
            ],
            [
                'judul' => 'Pendaftaran Ekstrakurikuler Semester Genap',
                'isi' => '<p>Pendaftaran kegiatan ekstrakurikuler untuk semester genap tahun ajaran 2024/2025 telah dibuka. Semua siswa diharapkan untuk mendaftar minimal satu kegiatan ekstrakurikuler.</p>

<h3>Ekstrakurikuler yang Tersedia:</h3>
<ul>
<li>Pramuka (wajib untuk kelas X)</li>
<li>PMR (Palang Merah Remaja)</li>
<li>Basket dan Futsal</li>
<li>Badminton dan Voli</li>
<li>Seni Tari dan Musik</li>
<li>Teater dan Sastra</li>
<li>Robotika dan Coding</li>
<li>Jurnalistik dan Fotografi</li>
<li>English Club</li>
<li>Pecinta Alam</li>
</ul>

<h3>Cara Pendaftaran:</h3>
<p>Pendaftaran dapat dilakukan secara online melalui website sekolah atau datang langsung ke ruang OSIS. Pendaftaran dibuka hingga tanggal 31 Januari 2025.</p>

<p>Kegiatan ekstrakurikuler akan dimulai pada minggu pertama Februari 2025. Jadwal lengkap akan diumumkan setelah pendaftaran ditutup.</p>',
                'kategori' => 'kegiatan',
                'prioritas' => 'sedang',
                'penulis' => 'Pembina OSIS',
                'status' => 'published',
                'views' => 189,
                'tanggal_publikasi' => Carbon::now()->subDays(5),
            ],
            [
                'judul' => 'Libur Semester dan Tahun Baru 2025',
                'isi' => '<p>Dalam rangka menyambut tahun baru 2025 dan memberikan waktu istirahat kepada siswa setelah menyelesaikan ujian semester, sekolah akan mengadakan libur semester.</p>

<h3>Jadwal Libur:</h3>
<ul>
<li>Libur Tahun Baru: 1 Januari 2025</li>
<li>Libur Semester: 25 Desember 2024 - 8 Januari 2025</li>
<li>Masuk sekolah kembali: 9 Januari 2025</li>
</ul>

<h3>Kegiatan Selama Libur:</h3>
<p>Meskipun libur, beberapa kegiatan tetap berjalan:</p>
<ul>
<li>Bimbingan belajar untuk kelas XII (opsional)</li>
<li>Pelatihan olimpiade sains</li>
<li>Kegiatan ekstrakurikuler tertentu</li>
</ul>

<h3>Tugas Liburan:</h3>
<p>Guru mata pelajaran akan memberikan tugas liburan yang harus dikumpulkan pada hari pertama masuk sekolah. Siswa diharapkan menggunakan waktu libur dengan baik untuk belajar dan beristirahat.</p>

<p>Selamat berlibur dan selamat tahun baru 2025!</p>',
                'kategori' => 'umum',
                'prioritas' => 'tinggi',
                'penulis' => 'Kepala Sekolah',
                'status' => 'published',
                'views' => 567,
                'tanggal_publikasi' => Carbon::now()->subWeek(),
            ],
            [
                'judul' => 'Pembayaran SPP Semester Genap 2025',
                'isi' => '<p>Pemberitahuan kepada seluruh orang tua/wali siswa mengenai pembayaran SPP (Sumbangan Pembinaan Pendidikan) untuk semester genap tahun ajaran 2024/2025.</p>

<h3>Rincian Pembayaran:</h3>
<ul>
<li>SPP Bulanan: Rp 150.000 per bulan</li>
<li>Biaya Kegiatan: Rp 50.000 per semester</li>
<li>Biaya Praktikum: Rp 75.000 per semester</li>
<li>Total per bulan: Rp 175.000</li>
</ul>

<h3>Cara Pembayaran:</h3>
<ul>
<li>Transfer ke rekening sekolah: BNI 1234567890</li>
<li>Pembayaran langsung di kantor tata usaha</li>
<li>Melalui aplikasi mobile banking dengan kode sekolah</li>
</ul>

<h3>Batas Waktu:</h3>
<p>Pembayaran SPP paling lambat tanggal 10 setiap bulannya. Keterlambatan pembayaran akan dikenakan denda sebesar Rp 10.000 per hari.</p>

<p>Bagi keluarga yang mengalami kesulitan ekonomi, dapat mengajukan keringanan biaya dengan melampirkan surat keterangan tidak mampu dari kelurahan.</p>',
                'kategori' => 'administrasi',
                'prioritas' => 'tinggi',
                'penulis' => 'Kepala Tata Usaha',
                'status' => 'published',
                'views' => 423,
                'tanggal_publikasi' => Carbon::now()->subDays(8),
            ],
            [
                'judul' => 'Sosialisasi Protokol Kesehatan di Sekolah',
                'isi' => '<p>Dalam upaya menjaga kesehatan dan keselamatan seluruh warga sekolah, kami mengingatkan kembali protokol kesehatan yang harus dipatuhi oleh semua pihak.</p>

<h3>Protokol Kesehatan:</h3>
<ul>
<li>Wajib menggunakan masker selama berada di lingkungan sekolah</li>
<li>Mencuci tangan dengan sabun atau menggunakan hand sanitizer</li>
<li>Menjaga jarak minimal 1 meter dengan orang lain</li>
<li>Tidak berkerumun di area sekolah</li>
<li>Mengukur suhu tubuh sebelum memasuki sekolah</li>
</ul>

<h3>Fasilitas yang Disediakan:</h3>
<ul>
<li>Tempat cuci tangan di setiap sudut sekolah</li>
<li>Hand sanitizer di setiap kelas dan ruangan</li>
<li>Thermal gun untuk mengukur suhu</li>
<li>Masker cadangan untuk yang lupa membawa</li>
</ul>

<h3>Sanksi:</h3>
<p>Siswa yang melanggar protokol kesehatan akan diberikan teguran dan pembinaan. Pelanggaran berulang dapat dikenakan sanksi sesuai dengan tata tertib sekolah.</p>

<p>Mari bersama-sama menjaga kesehatan dan menciptakan lingkungan sekolah yang aman dan nyaman untuk belajar.</p>',
                'kategori' => 'umum',
                'prioritas' => 'sedang',
                'penulis' => 'Tim Satgas COVID-19 Sekolah',
                'status' => 'published',
                'views' => 156,
                'tanggal_publikasi' => Carbon::now()->subDays(12),
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }

        $this->command->info('Announcements seeded successfully!');
    }
}