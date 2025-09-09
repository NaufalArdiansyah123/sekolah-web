<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing blog posts
        DB::table('blog_posts')->truncate();

        // Get first user or create one
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin Sekolah',
                'email' => 'admin@sman1balong.sch.id',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        $blogPosts = [
            [
                'title' => 'Prestasi Gemilang Siswa SMA Negeri 1 Balong di Olimpiade Sains Nasional 2024',
                'content' => 'SMA Negeri 1 Balong kembali menorehkan prestasi membanggakan di ajang Olimpiade Sains Nasional (OSN) 2024. Tim siswa kami berhasil meraih medali emas untuk bidang Matematika dan medali perak untuk bidang Fisika.

Prestasi ini merupakan hasil kerja keras siswa-siswa terbaik kami yang telah mempersiapkan diri selama berbulan-bulan. Mereka mengikuti pembinaan intensif dari guru-guru berpengalaman dan mengikuti berbagai simulasi ujian.

"Kami sangat bangga dengan pencapaian siswa-siswa kami. Ini membuktikan bahwa kualitas pendidikan di SMA Negeri 1 Balong terus meningkat," ujar Kepala Sekolah, Singgih Wibowo A Se.MM.

Para siswa yang meraih prestasi ini adalah:
- Ahmad Rizki Pratama (Kelas XI IPA 1) - Medali Emas Matematika
- Siti Nurhaliza (Kelas XI IPA 2) - Medali Perak Fisika
- Muhammad Fadli (Kelas XI IPA 1) - Medali Perunggu Kimia

Prestasi ini diharapkan dapat memotivasi siswa-siswa lainnya untuk terus berprestasi dan mengharumkan nama sekolah di tingkat nasional maupun internasional.',
                'category' => 'prestasi',
                'status' => 'published',
                'meta_description' => 'SMA Negeri 1 Balong meraih prestasi gemilang di Olimpiade Sains Nasional 2024 dengan medali emas dan perak.',
                'keywords' => 'olimpiade sains, prestasi siswa, medali emas, matematika, fisika',
                'author' => 'Tim Redaksi',
                'published_at' => Carbon::now()->subDays(2),
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kegiatan Bakti Sosial SMA Negeri 1 Balong untuk Korban Bencana Alam',
                'content' => 'Dalam rangka menumbuhkan rasa empati dan kepedulian sosial, SMA Negeri 1 Balong mengadakan kegiatan bakti sosial untuk membantu korban bencana alam yang terjadi di wilayah sekitar.

Kegiatan ini melibatkan seluruh warga sekolah, mulai dari siswa, guru, hingga karyawan. Bantuan yang dikumpulkan berupa sembako, pakaian layak pakai, dan uang tunai.

"Kegiatan ini bertujuan untuk mengajarkan siswa tentang pentingnya berbagi dan membantu sesama yang sedang kesulitan," kata Wakil Kepala Sekolah Bidang Kesiswaan, Budi Santoso, M.Pd.

Total bantuan yang berhasil dikumpulkan mencapai:
- 500 paket sembako
- 1000 potong pakaian layak pakai
- Rp 25.000.000 uang tunai
- Peralatan sekolah untuk anak-anak korban bencana

Penyerahan bantuan dilakukan langsung ke lokasi bencana dengan melibatkan perwakilan siswa dari setiap kelas. Kegiatan ini mendapat apresiasi tinggi dari masyarakat setempat.',
                'category' => 'kegiatan',
                'status' => 'published',
                'meta_description' => 'SMA Negeri 1 Balong mengadakan bakti sosial untuk korban bencana alam dengan mengumpulkan bantuan sembako dan pakaian.',
                'keywords' => 'bakti sosial, bencana alam, bantuan, empati, kepedulian sosial',
                'author' => 'Humas Sekolah',
                'published_at' => Carbon::now()->subDays(5),
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pengumuman Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2024/2025',
                'content' => 'SMA Negeri 1 Balong dengan ini mengumumkan pembukaan pendaftaran Penerimaan Peserta Didik Baru (PPDB) untuk Tahun Ajaran 2024/2025.

JADWAL PENDAFTARAN:
- Pendaftaran Online: 15 Juni - 25 Juni 2024
- Verifikasi Berkas: 26 Juni - 28 Juni 2024
- Pengumuman Hasil: 30 Juni 2024
- Daftar Ulang: 1 Juli - 5 Juli 2024

PERSYARATAN UMUM:
1. Lulusan SMP/MTs atau sederajat
2. Usia maksimal 21 tahun pada 1 Juli 2024
3. Sehat jasmani dan rohani
4. Berkelakuan baik

DOKUMEN YANG DIPERLUKAN:
- Ijazah SMP/MTs atau Surat Keterangan Lulus
- Kartu Keluarga
- Akta Kelahiran
- Pas foto terbaru ukuran 3x4 (3 lembar)
- Surat keterangan sehat dari dokter

Informasi lebih lanjut dapat diperoleh melalui website sekolah atau menghubungi panitia PPDB.',
                'category' => 'pengumuman',
                'status' => 'published',
                'meta_description' => 'Pengumuman PPDB SMA Negeri 1 Balong tahun ajaran 2024/2025 dengan berbagai jalur pendaftaran.',
                'keywords' => 'PPDB, pendaftaran, siswa baru, tahun ajaran 2024/2025, zonasi, prestasi',
                'author' => 'Panitia PPDB',
                'published_at' => Carbon::now()->subDays(7),
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Festival Seni dan Budaya SMA Negeri 1 Balong Meriah dan Penuh Kreativitas',
                'content' => 'SMA Negeri 1 Balong sukses menyelenggarakan Festival Seni dan Budaya yang berlangsung selama tiga hari di aula sekolah. Acara ini menampilkan berbagai pertunjukan seni dari siswa-siswa berbakat.

Festival ini menampilkan beragam pertunjukan, antara lain:
- Tari tradisional dari berbagai daerah
- Musik modern dan tradisional
- Drama dan teater
- Pameran karya seni rupa
- Fashion show dengan tema budaya Indonesia

"Festival ini bertujuan untuk melestarikan budaya Indonesia sekaligus memberikan wadah bagi siswa untuk mengekspresikan kreativitas mereka," ungkap Dr. Siti Nurhaliza, S.Pd, Wakil Kepala Sekolah Bidang Kurikulum.

Puncak acara ditutup dengan penampilan kolaborasi antara siswa dan guru dalam sebuah pertunjukan musik yang memukau. Festival ini mendapat apresiasi tinggi dari orang tua siswa dan masyarakat sekitar.',
                'category' => 'kegiatan',
                'status' => 'published',
                'meta_description' => 'Festival Seni dan Budaya SMA Negeri 1 Balong menampilkan berbagai pertunjukan kreatif siswa.',
                'keywords' => 'festival seni, budaya, tari tradisional, musik, drama, kreativitas siswa',
                'author' => 'Tim Dokumentasi',
                'published_at' => Carbon::now()->subDays(10),
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kunjungan Industri Siswa Jurusan IPA ke Pusat Penelitian LIPI',
                'content' => 'Siswa-siswa jurusan IPA SMA Negeri 1 Balong melakukan kunjungan industri ke Pusat Penelitian Lembaga Ilmu Pengetahuan Indonesia (LIPI) dalam rangka memperluas wawasan tentang dunia penelitian dan sains.

Kunjungan ini diikuti oleh 60 siswa kelas XI dan XII IPA didampingi oleh 5 guru pembimbing. Para siswa berkesempatan melihat langsung berbagai laboratorium penelitian dan berinteraksi dengan para peneliti.

Kegiatan yang dilakukan selama kunjungan:
- Tur laboratorium fisika dan kimia
- Presentasi tentang penelitian terkini
- Workshop praktikum sederhana
- Diskusi dengan para peneliti muda
- Pengenalan peralatan penelitian canggih

"Kunjungan ini sangat bermanfaat untuk membuka wawasan siswa tentang dunia penelitian. Banyak siswa yang tertarik untuk melanjutkan studi di bidang sains," kata Dra. Retno Wulandari, guru Fisika yang memimpin rombongan.',
                'category' => 'kegiatan',
                'status' => 'published',
                'meta_description' => 'Siswa IPA SMA Negeri 1 Balong berkunjung ke LIPI untuk memperluas wawasan tentang dunia penelitian.',
                'keywords' => 'kunjungan industri, LIPI, penelitian, sains, laboratorium, siswa IPA',
                'author' => 'Guru Pembimbing',
                'published_at' => Carbon::now()->subDays(14),
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Implementasi Kurikulum Merdeka di SMA Negeri 1 Balong Berjalan Sukses',
                'content' => 'SMA Negeri 1 Balong telah berhasil mengimplementasikan Kurikulum Merdeka dengan baik. Perubahan ini membawa dampak positif bagi proses pembelajaran dan pengembangan karakter siswa.

Kurikulum Merdeka memberikan keleluasaan kepada siswa untuk memilih mata pelajaran sesuai dengan minat dan bakat mereka. Hal ini membuat pembelajaran menjadi lebih bermakna dan menyenangkan.

Perubahan yang terlihat sejak implementasi:
- Siswa lebih aktif dalam pembelajaran
- Peningkatan kreativitas dan inovasi
- Pembelajaran berbasis proyek yang menarik
- Kolaborasi antar mata pelajaran
- Pengembangan soft skills yang optimal

"Kurikulum Merdeka memberikan ruang yang lebih luas bagi guru untuk berinovasi dalam pembelajaran. Siswa juga lebih termotivasi karena bisa belajar sesuai passion mereka," ungkap Kepala Sekolah.',
                'category' => 'berita',
                'status' => 'published',
                'meta_description' => 'SMA Negeri 1 Balong sukses mengimplementasikan Kurikulum Merdeka dengan dampak positif bagi pembelajaran.',
                'keywords' => 'kurikulum merdeka, implementasi, pembelajaran, inovasi, kreativitas siswa',
                'author' => 'Tim Kurikulum',
                'published_at' => Carbon::now()->subDays(18),
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Program Beasiswa Prestasi untuk Siswa Berprestasi SMA Negeri 1 Balong',
                'content' => 'SMA Negeri 1 Balong meluncurkan program beasiswa prestasi untuk mendukung siswa-siswa berprestasi yang memiliki keterbatasan ekonomi. Program ini merupakan bentuk komitmen sekolah dalam memberikan pendidikan berkualitas untuk semua.

Program beasiswa ini mencakup:
- Pembebasan biaya sekolah
- Bantuan seragam dan perlengkapan sekolah
- Uang saku bulanan
- Bimbingan belajar gratis
- Akses ke semua fasilitas sekolah

Kriteria penerima beasiswa:
1. Prestasi akademik minimal rata-rata 8.5
2. Kondisi ekonomi keluarga kurang mampu
3. Aktif dalam kegiatan ekstrakurikuler
4. Berkelakuan baik
5. Komitmen untuk mempertahankan prestasi

"Program ini diharapkan dapat memotivasi siswa untuk terus berprestasi sekaligus membantu mereka yang memiliki keterbatasan ekonomi," kata Wakil Kepala Sekolah Bidang Kesiswaan.',
                'category' => 'pengumuman',
                'status' => 'published',
                'meta_description' => 'SMA Negeri 1 Balong meluncurkan program beasiswa prestasi untuk siswa berprestasi dengan keterbatasan ekonomi.',
                'keywords' => 'beasiswa prestasi, siswa berprestasi, bantuan pendidikan, ekonomi kurang mampu',
                'author' => 'Bagian Kesiswaan',
                'published_at' => Carbon::now()->subDays(21),
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Peringatan Hari Pendidikan Nasional dengan Berbagai Kegiatan Menarik',
                'content' => 'SMA Negeri 1 Balong memperingati Hari Pendidikan Nasional dengan mengadakan berbagai kegiatan menarik yang melibatkan seluruh warga sekolah. Tema peringatan tahun ini adalah "Pendidikan Berkualitas untuk Masa Depan Gemilang".

Rangkaian kegiatan yang dilaksanakan:
- Upacara bendera dengan pembacaan teks proklamasi
- Lomba karya tulis ilmiah siswa
- Pameran inovasi pembelajaran
- Seminar pendidikan dengan narasumber ahli
- Pentas seni dan budaya
- Bazar makanan tradisional

Dalam sambutannya, Kepala Sekolah menekankan pentingnya pendidikan dalam membangun karakter bangsa. "Pendidikan bukan hanya tentang transfer ilmu, tetapi juga pembentukan karakter dan moral generasi muda," ujarnya.

Acara puncak adalah penganugerahan penghargaan kepada guru dan siswa berprestasi. Beberapa guru menerima penghargaan sebagai guru teladan, sementara siswa berprestasi mendapat apresiasi atas pencapaian mereka.',
                'category' => 'kegiatan',
                'status' => 'published',
                'meta_description' => 'SMA Negeri 1 Balong memperingati Hari Pendidikan Nasional dengan berbagai kegiatan menarik.',
                'keywords' => 'hari pendidikan nasional, hardiknas, upacara, lomba, seminar pendidikan',
                'author' => 'Panitia Hardiknas',
                'published_at' => Carbon::now()->subDays(25),
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        try {
            foreach ($blogPosts as $post) {
                BlogPost::create($post);
                $this->command->info("Created blog post: {$post['title']}");
            }

            $this->command->info('✅ Blog posts seeded successfully! Total: ' . count($blogPosts) . ' posts created.');
        } catch (\Exception $e) {
            $this->command->error('❌ Error seeding blog posts: ' . $e->getMessage());
            throw $e;
        }
    }
}