<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;
use Carbon\Carbon;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $adminUser = User::role('admin')->first();
        $userId = $adminUser ? $adminUser->id : 1;

        $blogPosts = [
            [
                'title' => 'Penerimaan Siswa Baru Tahun Ajaran 2025/2026',
                'content' => '<p>Pendaftaran siswa baru untuk tahun ajaran 2025/2026 telah resmi dibuka. Sistem pendaftaran menggunakan platform online yang lebih mudah dan terintegrasi untuk kemudahan calon siswa dan orang tua.</p>

<h3>Persyaratan Pendaftaran:</h3>
<ul>
<li>Ijazah SMP/MTs atau surat keterangan lulus</li>
<li>Kartu Keluarga dan Akta Kelahiran</li>
<li>Pas foto terbaru ukuran 3x4 (3 lembar)</li>
<li>Surat keterangan sehat dari dokter</li>
</ul>

<h3>Jadwal Pendaftaran:</h3>
<p>Pendaftaran dibuka mulai tanggal 15 Januari 2025 hingga 28 Februari 2025. Pengumuman hasil seleksi akan diumumkan pada tanggal 15 Maret 2025.</p>

<p>Untuk informasi lebih lanjut, silakan hubungi panitia PPDB di nomor telepon (0281) 123456 atau datang langsung ke sekolah.</p>',
                'category' => 'berita',
                'status' => 'published',
                'meta_description' => 'Informasi lengkap tentang penerimaan siswa baru SMA Negeri 1 Balong tahun ajaran 2025/2026',
                'keywords' => 'PPDB, penerimaan siswa baru, SMA Negeri 1 Balong, pendaftaran online',
                'author' => 'Admin Sekolah',
                'published_at' => Carbon::now()->subDays(2),
                'user_id' => $userId,
            ],
            [
                'title' => 'Juara Umum Olimpiade Sains Tingkat Kabupaten',
                'content' => '<p>Tim olimpiade SMA Negeri 1 Balong berhasil meraih prestasi membanggakan dengan menjadi juara umum dalam kompetisi Olimpiade Sains Nasional (OSN) tingkat kabupaten yang diselenggarakan pada bulan Desember 2024.</p>

<h3>Prestasi yang Diraih:</h3>
<ul>
<li>Medali Emas Matematika - Ahmad Rizki (Kelas XI IPA 1)</li>
<li>Medali Emas Fisika - Sari Dewi (Kelas XI IPA 2)</li>
<li>Medali Perak Kimia - Budi Santoso (Kelas XI IPA 1)</li>
<li>Medali Perak Biologi - Rina Sari (Kelas XI IPA 3)</li>
<li>Medali Perunggu Astronomi - Dedi Kurniawan (Kelas XI IPA 2)</li>
</ul>

<p>Prestasi ini merupakan hasil kerja keras siswa-siswa berprestasi yang telah mengikuti pembinaan intensif selama 6 bulan terakhir. Tim akan mewakili kabupaten dalam kompetisi OSN tingkat provinsi pada bulan Maret 2025.</p>

<p>Kepala sekolah menyampaikan apresiasi tinggi kepada para siswa dan guru pembimbing yang telah berdedikasi dalam meraih prestasi ini.</p>',
                'category' => 'prestasi',
                'status' => 'published',
                'meta_description' => 'SMA Negeri 1 Balong meraih juara umum Olimpiade Sains Nasional tingkat kabupaten dengan berbagai medali emas',
                'keywords' => 'OSN, olimpiade sains, prestasi, juara umum, medali emas',
                'author' => 'Tim Redaksi',
                'published_at' => Carbon::now()->subDays(5),
                'user_id' => $userId,
            ],
            [
                'title' => 'Launching Platform E-Learning Terbaru',
                'content' => '<p>SMA Negeri 1 Balong dengan bangga memperkenalkan platform e-learning terbaru yang telah dikembangkan khusus untuk mendukung proses pembelajaran digital yang lebih efektif dan interaktif.</p>

<h3>Fitur-Fitur Unggulan:</h3>
<ul>
<li>Dashboard pembelajaran yang user-friendly</li>
<li>Sistem manajemen tugas dan ujian online</li>
<li>Video conference terintegrasi untuk pembelajaran jarak jauh</li>
<li>Forum diskusi untuk interaksi siswa dan guru</li>
<li>Perpustakaan digital dengan ribuan e-book</li>
<li>Sistem penilaian otomatis dan laporan progress</li>
</ul>

<h3>Pelatihan Penggunaan:</h3>
<p>Sekolah akan mengadakan pelatihan penggunaan platform untuk semua guru dan siswa pada minggu pertama Januari 2025. Pelatihan akan dilaksanakan secara bertahap sesuai dengan jadwal yang telah ditentukan.</p>

<p>Platform ini diharapkan dapat meningkatkan kualitas pembelajaran dan mempersiapkan siswa menghadapi era digital yang semakin berkembang.</p>',
                'category' => 'kegiatan',
                'status' => 'published',
                'meta_description' => 'SMA Negeri 1 Balong meluncurkan platform e-learning terbaru dengan fitur-fitur canggih untuk pembelajaran digital',
                'keywords' => 'e-learning, platform digital, pembelajaran online, teknologi pendidikan',
                'author' => 'Tim IT Sekolah',
                'published_at' => Carbon::now()->subWeek(),
                'user_id' => $userId,
            ],
            [
                'title' => 'Kegiatan Bakti Sosial Siswa SMA Negeri 1 Balong',
                'content' => '<p>Dalam rangka menumbuhkan rasa kepedulian sosial, siswa-siswi SMA Negeri 1 Balong mengadakan kegiatan bakti sosial di Desa Sukamaju pada hari Sabtu, 21 Desember 2024.</p>

<h3>Kegiatan yang Dilaksanakan:</h3>
<ul>
<li>Pembagian sembako kepada keluarga kurang mampu</li>
<li>Gotong royong membersihkan lingkungan desa</li>
<li>Pengajaran gratis untuk anak-anak usia sekolah</li>
<li>Pemeriksaan kesehatan gratis oleh tim medis</li>
<li>Perbaikan fasilitas umum seperti jembatan dan jalan</li>
</ul>

<p>Kegiatan ini diikuti oleh 150 siswa dari berbagai kelas dan didampingi oleh 20 guru. Antusiasme warga desa sangat tinggi dan mereka menyambut baik kehadiran siswa-siswi SMA Negeri 1 Balong.</p>

<p>Kepala Desa Sukamaju menyampaikan terima kasih atas kepedulian sekolah dan berharap kegiatan serupa dapat dilaksanakan secara rutin.</p>',
                'category' => 'kegiatan',
                'status' => 'published',
                'meta_description' => 'Siswa SMA Negeri 1 Balong mengadakan bakti sosial di Desa Sukamaju dengan berbagai kegiatan positif',
                'keywords' => 'bakti sosial, kepedulian sosial, kegiatan siswa, pengabdian masyarakat',
                'author' => 'OSIS SMA Negeri 1 Balong',
                'published_at' => Carbon::now()->subDays(10),
                'user_id' => $userId,
            ],
            [
                'title' => 'Workshop Kewirausahaan untuk Siswa Kelas XII',
                'content' => '<p>SMA Negeri 1 Balong mengadakan workshop kewirausahaan khusus untuk siswa kelas XII sebagai bekal mereka dalam menghadapi dunia kerja dan mempersiapkan masa depan yang lebih baik.</p>

<h3>Materi Workshop:</h3>
<ul>
<li>Dasar-dasar kewirausahaan dan mindset entrepreneur</li>
<li>Cara mengidentifikasi peluang bisnis</li>
<li>Strategi pemasaran digital dan media sosial</li>
<li>Manajemen keuangan untuk usaha kecil</li>
<li>Presentasi business plan dan pitching</li>
</ul>

<h3>Narasumber:</h3>
<p>Workshop ini menghadirkan narasumber dari praktisi bisnis sukses dan dosen ekonomi dari universitas ternama. Mereka berbagi pengalaman dan tips praktis dalam memulai usaha.</p>

<p>Diharapkan setelah mengikuti workshop ini, siswa memiliki bekal pengetahuan dan keterampilan untuk menjadi entrepreneur muda yang sukses atau setidaknya memiliki jiwa kewirausahaan dalam karir mereka nantinya.</p>',
                'category' => 'kegiatan',
                'status' => 'published',
                'meta_description' => 'Workshop kewirausahaan untuk siswa kelas XII SMA Negeri 1 Balong dengan narasumber praktisi bisnis',
                'keywords' => 'workshop, kewirausahaan, entrepreneur, siswa kelas XII, business plan',
                'author' => 'Guru BK',
                'published_at' => Carbon::now()->subDays(15),
                'user_id' => $userId,
            ],
        ];

        foreach ($blogPosts as $post) {
            BlogPost::create($post);
        }

        $this->command->info('Blog posts seeded successfully!');
    }
}