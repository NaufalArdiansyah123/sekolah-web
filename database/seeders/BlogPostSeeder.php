<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // Get admin user or create one
        $admin = User::where('email', 'admin@sekolah.com')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@sekolah.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        $blogPosts = [
            [
                'title' => 'SMA Negeri 1 Balong Raih Juara Umum Olimpiade Sains Nasional 2024',
                'content' => 'Prestasi membanggakan kembali ditorehkan oleh siswa-siswi SMA Negeri 1 Balong dengan meraih juara umum dalam Olimpiade Sains Nasional (OSN) 2024. Tim yang terdiri dari 15 siswa terbaik berhasil meraih 5 medali emas, 3 medali perak, dan 2 medali perunggu dalam berbagai bidang sains.

Pencapaian ini merupakan hasil kerja keras siswa-siswi yang telah mempersiapkan diri selama berbulan-bulan dengan bimbingan intensif dari para guru pembina. Bidang yang berhasil meraih medali emas antara lain Matematika, Fisika, Kimia, Biologi, dan Informatika.

Kepala Sekolah SMA Negeri 1 Balong, Drs. Ahmad Suryanto, M.Pd., menyampaikan rasa bangga dan apresiasi tinggi kepada seluruh siswa yang telah mengharumkan nama sekolah. "Prestasi ini membuktikan bahwa kualitas pendidikan di SMA Negeri 1 Balong terus meningkat dan mampu bersaing di tingkat nasional," ujarnya.

Para siswa peraih medali akan mendapatkan pembinaan lebih lanjut untuk persiapan kompetisi internasional. Sekolah juga berkomitmen untuk terus meningkatkan fasilitas laboratorium dan program pembinaan olimpiade sains.',
                'category' => 'prestasi',
                'status' => 'published',
                'meta_description' => 'SMA Negeri 1 Balong meraih juara umum OSN 2024 dengan 5 emas, 3 perak, dan 2 perunggu',
                'keywords' => 'olimpiade sains, prestasi, medali emas, SMA Negeri 1 Balong, OSN 2024',
                'author' => 'Tim Redaksi',
                'published_at' => now()->subDays(2),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2024/2025 Resmi Dibuka',
                'content' => 'SMA Negeri 1 Balong dengan bangga mengumumkan pembukaan Penerimaan Peserta Didik Baru (PPDB) untuk tahun ajaran 2024/2025. Pendaftaran akan dilaksanakan secara online melalui sistem PPDB Provinsi mulai tanggal 15 Juni hingga 25 Juni 2024.

Tahun ini, SMA Negeri 1 Balong menyediakan 360 kursi untuk siswa baru yang terbagi dalam 12 kelas dengan rincian 8 kelas IPA dan 4 kelas IPS. Seleksi akan dilakukan berdasarkan nilai rapor semester 1-5 SMP dengan bobot 50%, prestasi akademik dan non-akademik 30%, serta hasil tes wawancara 20%.

Persyaratan pendaftaran meliputi:
1. Lulusan SMP/MTs tahun 2024
2. Nilai rata-rata rapor minimal 8.0
3. Tidak buta warna untuk jurusan IPA
4. Sehat jasmani dan rohani
5. Berkelakuan baik

Calon siswa dapat mengakses informasi lengkap dan melakukan pendaftaran melalui website resmi sekolah atau datang langsung ke sekretariat PPDB yang beroperasi setiap hari kerja pukul 08.00-15.00 WIB.

Untuk informasi lebih lanjut, hubungi panitia PPDB di nomor telepon (024) 123-4567 atau email ppdb@sman1balong.sch.id.',
                'category' => 'pengumuman',
                'status' => 'published',
                'meta_description' => 'PPDB SMA Negeri 1 Balong 2024/2025 dibuka 15-25 Juni dengan 360 kursi tersedia',
                'keywords' => 'PPDB, penerimaan siswa baru, SMA Negeri 1 Balong, pendaftaran online',
                'author' => 'Panitia PPDB',
                'published_at' => now()->subDays(5),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Workshop Digital Marketing untuk Siswa Kelas XII',
                'content' => 'Dalam rangka mempersiapkan siswa menghadapi era digital dan dunia kerja yang semakin kompetitif, SMA Negeri 1 Balong mengadakan workshop Digital Marketing untuk siswa kelas XII. Kegiatan ini berlangsung selama 3 hari, mulai tanggal 20-22 Maret 2024 di aula sekolah.

Workshop ini menghadirkan narasumber profesional dari industri digital marketing, yaitu Bapak Rizki Pratama, S.Kom., M.M., yang merupakan Digital Marketing Manager di salah satu perusahaan teknologi terkemuka di Indonesia. Materi yang disampaikan meliputi:

1. Pengenalan Digital Marketing dan Tren Terkini
2. Social Media Marketing Strategy
3. Content Creation dan Copywriting
4. Search Engine Optimization (SEO) Dasar
5. Analisis Data dan Metrics
6. Praktik Membuat Campaign Digital

Sebanyak 120 siswa kelas XII mengikuti workshop ini dengan antusias. Mereka tidak hanya mendapatkan teori, tetapi juga praktik langsung membuat konten digital dan merancang strategi pemasaran untuk produk simulasi.

"Workshop ini sangat bermanfaat untuk membuka wawasan siswa tentang peluang karir di bidang digital. Kami berharap siswa dapat mengaplikasikan ilmu yang didapat untuk mengembangkan jiwa entrepreneurship," kata Ibu Sari Dewi, S.Pd., selaku koordinator kegiatan.

Di akhir workshop, siswa terbaik akan mendapatkan sertifikat dan kesempatan magang di perusahaan mitra.',
                'category' => 'kegiatan',
                'status' => 'published',
                'meta_description' => 'Workshop Digital Marketing 3 hari untuk siswa kelas XII SMA Negeri 1 Balong',
                'keywords' => 'workshop, digital marketing, siswa kelas XII, pelatihan, entrepreneurship',
                'author' => 'Sari Dewi',
                'published_at' => now()->subDays(7),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Tim Basket Putra Juara Turnamen Antarsekolah Se-Kota',
                'content' => 'Tim basket putra SMA Negeri 1 Balong berhasil meraih juara 1 dalam Turnamen Basket Antarsekolah Se-Kota yang diselenggarakan oleh Dinas Pendidikan Kota. Turnamen yang berlangsung selama 2 minggu ini diikuti oleh 16 sekolah menengah atas se-kota.

Perjalanan tim menuju gelar juara tidaklah mudah. Mereka harus mengalahkan beberapa sekolah unggulan yang juga memiliki tim basket yang kuat. Di babak final, tim SMA Negeri 1 Balong berhasil mengalahkan SMA Negeri 3 dengan skor 78-65 dalam pertandingan yang berlangsung sengit.

Kapten tim, Muhammad Fadil (kelas XI IPA 2), menyampaikan rasa syukur dan bangga atas pencapaian ini. "Ini adalah hasil kerja keras seluruh tim dan dukungan dari sekolah. Kami berlatih setiap hari setelah jam pelajaran selesai," ungkapnya.

Pelatih tim, Bapak Agus Santoso, S.Pd., juga mengapresiasi dedikasi para pemain. "Mereka menunjukkan sportivitas dan semangat juang yang luar biasa. Prestasi ini memotivasi kami untuk terus berlatih dan meraih prestasi yang lebih tinggi."

Sebagai juara, tim akan mewakili kota dalam turnamen tingkat provinsi yang akan diselenggarakan bulan depan. Sekolah memberikan dukungan penuh dengan menyediakan fasilitas latihan yang lebih baik dan program pembinaan intensif.',
                'category' => 'prestasi',
                'status' => 'published',
                'meta_description' => 'Tim basket putra SMA Negeri 1 Balong juara turnamen antarsekolah se-kota',
                'keywords' => 'basket, juara, turnamen, olahraga, prestasi sekolah',
                'author' => 'Agus Santoso',
                'published_at' => now()->subDays(10),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Peringatan Hari Kemerdekaan RI ke-79 dengan Berbagai Lomba Menarik',
                'content' => 'Dalam rangka memperingati Hari Kemerdekaan Republik Indonesia ke-79, SMA Negeri 1 Balong menggelar berbagai kegiatan dan lomba yang meriah. Perayaan berlangsung selama 3 hari, mulai tanggal 15-17 Agustus 2024, dengan tema "Bersatu Membangun Negeri".

Rangkaian kegiatan dimulai dengan upacara bendera pada tanggal 17 Agustus yang diikuti oleh seluruh warga sekolah. Upacara dipimpin oleh Kepala Sekolah sebagai inspektur upacara, dengan pembawa acara dari siswa OSIS.

Berbagai lomba tradisional dan modern diselenggarakan untuk memeriahkan perayaan:

**Lomba Tradisional:**
- Balap karung
- Panjat pinang
- Tarik tambang
- Lomba makan kerupuk
- Balap kelereng dengan sendok

**Lomba Modern:**
- Futsal antar kelas
- Voli antar guru dan siswa
- Lomba fotografi dengan tema kemerdekaan
- Lomba video pendek TikTok
- Quiz online tentang sejarah Indonesia

Antusiasme warga sekolah sangat tinggi. Setiap kelas mengirimkan perwakilan untuk mengikuti berbagai lomba. Suasana kekeluargaan dan kebersamaan sangat terasa selama kegiatan berlangsung.

Pemenang lomba mendapatkan piala, sertifikat, dan hadiah menarik. Lomba futsal dimenangkan oleh kelas XII IPA 1, sementara lomba fotografi dimenangkan oleh Andi Pratama dari kelas XI IPS 2.

"Kegiatan ini bertujuan untuk menumbuhkan rasa cinta tanah air dan mempererat tali persaudaraan antar warga sekolah," kata Bapak Drs. Ahmad Suryanto, M.Pd., Kepala SMA Negeri 1 Balong.',
                'category' => 'kegiatan',
                'status' => 'published',
                'meta_description' => 'Peringatan HUT RI ke-79 di SMA Negeri 1 Balong dengan lomba tradisional dan modern',
                'keywords' => 'kemerdekaan, HUT RI, lomba, upacara, kegiatan sekolah',
                'author' => 'Tim Redaksi',
                'published_at' => now()->subDays(15),
                'user_id' => $admin->id,
            ],
        ];

        foreach ($blogPosts as $post) {
            BlogPost::create($post);
        }
    }
}