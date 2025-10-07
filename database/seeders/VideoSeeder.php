<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Str;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get admin user or create one
        $admin = User::where('email', 'admin@example.com')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        $videos = [
            [
                'title' => 'Upacara Bendera Hari Senin',
                'description' => 'Dokumentasi upacara bendera rutin setiap hari Senin di halaman sekolah. Menampilkan kedisiplinan dan semangat nasionalisme siswa-siswi SMA Negeri 1 Balong.',
                'category' => 'kegiatan',
                'is_featured' => true,
                'views' => 1250,
                'downloads' => 45,
            ],
            [
                'title' => 'Lomba Sains Nasional 2024',
                'description' => 'Persiapan dan pelaksanaan Lomba Sains Nasional tingkat provinsi. Tim siswa SMA Negeri 1 Balong berhasil meraih juara dalam berbagai kategori.',
                'category' => 'prestasi',
                'is_featured' => true,
                'views' => 2100,
                'downloads' => 78,
            ],
            [
                'title' => 'Pembelajaran Interaktif Matematika',
                'description' => 'Video pembelajaran matematika dengan metode interaktif menggunakan teknologi digital. Menampilkan inovasi guru dalam menyampaikan materi.',
                'category' => 'pembelajaran',
                'is_featured' => false,
                'views' => 890,
                'downloads' => 156,
            ],
            [
                'title' => 'Festival Seni dan Budaya',
                'description' => 'Penampilan spektakuler siswa dalam festival seni dan budaya tahunan. Menampilkan berbagai tarian tradisional dan modern.',
                'category' => 'kegiatan',
                'is_featured' => true,
                'views' => 3200,
                'downloads' => 92,
            ],
            [
                'title' => 'Dokumentasi Fasilitas Sekolah',
                'description' => 'Tour virtual fasilitas lengkap SMA Negeri 1 Balong meliputi laboratorium, perpustakaan, ruang kelas, dan fasilitas olahraga.',
                'category' => 'dokumentasi',
                'is_featured' => false,
                'views' => 1580,
                'downloads' => 67,
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Robotika',
                'description' => 'Aktivitas siswa dalam ekstrakurikuler robotika. Menampilkan proses pembuatan robot dan kompetisi antar tim.',
                'category' => 'kegiatan',
                'is_featured' => false,
                'views' => 750,
                'downloads' => 34,
            ],
            [
                'title' => 'Wisuda Kelas XII Tahun 2024',
                'description' => 'Momen bersejarah wisuda siswa kelas XII tahun ajaran 2023/2024. Dokumentasi lengkap dari persiapan hingga acara puncak.',
                'category' => 'dokumentasi',
                'is_featured' => true,
                'views' => 4500,
                'downloads' => 234,
            ],
            [
                'title' => 'Olimpiade Matematika Tingkat Kota',
                'description' => 'Perjuangan siswa SMA Negeri 1 Balong dalam Olimpiade Matematika tingkat kota. Berhasil meraih medali emas.',
                'category' => 'prestasi',
                'is_featured' => false,
                'views' => 1100,
                'downloads' => 56,
            ],
            [
                'title' => 'Praktikum Kimia Kelas XI',
                'description' => 'Kegiatan praktikum kimia siswa kelas XI di laboratorium. Menampilkan eksperimen menarik dan pembelajaran hands-on.',
                'category' => 'pembelajaran',
                'is_featured' => false,
                'views' => 680,
                'downloads' => 89,
            ],
            [
                'title' => 'Bakti Sosial di Panti Asuhan',
                'description' => 'Kegiatan bakti sosial siswa dan guru di panti asuhan setempat. Menunjukkan kepedulian sosial warga sekolah.',
                'category' => 'kegiatan',
                'is_featured' => false,
                'views' => 920,
                'downloads' => 41,
            ],
            [
                'title' => 'Pelatihan Public Speaking',
                'description' => 'Workshop public speaking untuk siswa kelas X dan XI. Meningkatkan kemampuan komunikasi dan kepercayaan diri.',
                'category' => 'pembelajaran',
                'is_featured' => false,
                'views' => 540,
                'downloads' => 73,
            ],
            [
                'title' => 'Turnamen Futsal Antar Kelas',
                'description' => 'Kompetisi futsal seru antar kelas dalam rangka memperingati HUT sekolah. Menampilkan sportivitas dan kekompakan.',
                'category' => 'kegiatan',
                'is_featured' => false,
                'views' => 1800,
                'downloads' => 28,
            ],
        ];

        foreach ($videos as $videoData) {
            // Generate dummy file data
            $filename = Str::uuid() . '.mp4';
            $fileSize = rand(50000000, 200000000); // 50MB - 200MB
            $duration = rand(120, 1800); // 2 minutes - 30 minutes

            Video::create([
                'title' => $videoData['title'],
                'description' => $videoData['description'],
                'filename' => $filename,
                'original_name' => Str::slug($videoData['title']) . '.mp4',
                'mime_type' => 'video/mp4',
                'file_size' => $fileSize,
                'duration' => $duration,
                'thumbnail' => null, // Will be generated later
                'category' => $videoData['category'],
                'status' => 'active',
                'is_featured' => $videoData['is_featured'],
                'views' => $videoData['views'],
                'downloads' => $videoData['downloads'],
                'metadata' => [
                    'resolution' => '1920x1080',
                    'fps' => 30,
                    'bitrate' => '2000kbps',
                    'codec' => 'H.264',
                ],
                'uploaded_by' => $admin->id,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);
        }

        $this->command->info('Video seeder completed successfully!');
        $this->command->info('Created ' . count($videos) . ' sample videos');
        $this->command->info('Note: Actual video files are not created, only database records');
    }
}