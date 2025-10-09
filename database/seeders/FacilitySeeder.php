<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Perpustakaan Digital',
                'description' => 'Perpustakaan modern dengan koleksi buku digital dan fisik yang lengkap. Dilengkapi dengan ruang baca yang nyaman, akses internet gratis, dan sistem pencarian buku yang canggih.',
                'category' => 'academic',
                'features' => [
                    'Koleksi buku digital 10,000+ judul',
                    'Ruang baca ber-AC',
                    'WiFi gratis',
                    'Sistem pencarian online',
                    'Area diskusi kelompok',
                    'Komputer akses publik'
                ],
                'status' => 'active',
                'capacity' => 150,
                'location' => 'Gedung A, Lantai 2',
                'is_featured' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Laboratorium Komputer',
                'description' => 'Laboratorium komputer dengan perangkat terbaru untuk mendukung pembelajaran teknologi informasi dan komunikasi. Dilengkapi dengan software pembelajaran terkini.',
                'category' => 'technology',
                'features' => [
                    '40 unit komputer terbaru',
                    'Software pembelajaran lengkap',
                    'Proyektor dan layar besar',
                    'AC dan pencahayaan optimal',
                    'Koneksi internet high-speed',
                    'Printer dan scanner'
                ],
                'status' => 'active',
                'capacity' => 40,
                'location' => 'Gedung B, Lantai 1',
                'is_featured' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Lapangan Basket',
                'description' => 'Lapangan basket outdoor dengan standar internasional. Dilengkapi dengan ring basket yang dapat disesuaikan tingginya dan tribun penonton.',
                'category' => 'sport',
                'features' => [
                    'Lapangan standar FIBA',
                    'Ring basket adjustable',
                    'Tribun penonton 200 orang',
                    'Lampu penerangan malam',
                    'Lantai anti-slip',
                    'Ruang ganti pemain'
                ],
                'status' => 'active',
                'capacity' => 200,
                'location' => 'Area Olahraga',
                'is_featured' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Studio Musik',
                'description' => 'Studio musik dengan peralatan lengkap untuk pembelajaran dan latihan musik. Dilengkapi dengan berbagai alat musik dan sistem recording profesional.',
                'category' => 'arts',
                'features' => [
                    'Piano akustik dan digital',
                    'Drum set lengkap',
                    'Gitar akustik dan elektrik',
                    'Sistem sound profesional',
                    'Recording equipment',
                    'Kedap suara'
                ],
                'status' => 'active',
                'capacity' => 25,
                'location' => 'Gedung C, Lantai 1',
                'is_featured' => false,
                'sort_order' => 4
            ],
            [
                'name' => 'Laboratorium Sains',
                'description' => 'Laboratorium sains lengkap untuk praktikum fisika, kimia, dan biologi. Dilengkapi dengan peralatan eksperimen modern dan sistem keamanan yang baik.',
                'category' => 'academic',
                'features' => [
                    'Peralatan eksperimen lengkap',
                    'Mikroskop digital',
                    'Lemari asam dan safety shower',
                    'Meja praktikum anti-korosi',
                    'Sistem ventilasi khusus',
                    'Alat pemadam kebakaran'
                ],
                'status' => 'active',
                'capacity' => 30,
                'location' => 'Gedung A, Lantai 3',
                'is_featured' => false,
                'sort_order' => 5
            ],
            [
                'name' => 'Aula Serbaguna',
                'description' => 'Aula besar yang dapat digunakan untuk berbagai acara seperti seminar, pertunjukan, upacara, dan kegiatan sekolah lainnya.',
                'category' => 'other',
                'features' => [
                    'Kapasitas 500 orang',
                    'Panggung dengan backdrop',
                    'Sistem sound dan lighting',
                    'AC central',
                    'Proyektor dan layar besar',
                    'Ruang backstage'
                ],
                'status' => 'active',
                'capacity' => 500,
                'location' => 'Gedung Utama',
                'is_featured' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'Kantin Sekolah',
                'description' => 'Kantin sekolah yang bersih dan nyaman dengan berbagai pilihan makanan sehat dan bergizi untuk siswa dan staff.',
                'category' => 'other',
                'features' => [
                    'Menu makanan sehat',
                    'Area makan ber-AC',
                    'Dapur bersih dan higienis',
                    'Harga terjangkau',
                    'Cashless payment',
                    'Area cuci tangan'
                ],
                'status' => 'active',
                'capacity' => 100,
                'location' => 'Gedung D',
                'is_featured' => false,
                'sort_order' => 7
            ],
            [
                'name' => 'Lapangan Futsal',
                'description' => 'Lapangan futsal indoor dengan rumput sintetis berkualitas tinggi. Dilengkapi dengan sistem pencahayaan dan ventilasi yang baik.',
                'category' => 'sport',
                'features' => [
                    'Rumput sintetis premium',
                    'Gawang standar FIFA',
                    'Lampu LED terang',
                    'Sistem ventilasi optimal',
                    'Tribun penonton',
                    'Ruang ganti dan shower'
                ],
                'status' => 'maintenance',
                'capacity' => 150,
                'location' => 'Gedung Olahraga',
                'is_featured' => false,
                'sort_order' => 8
            ],
            [
                'name' => 'Ruang Multimedia',
                'description' => 'Ruang multimedia untuk pembelajaran audio visual dengan peralatan presentasi modern dan koneksi internet high-speed.',
                'category' => 'technology',
                'features' => [
                    'Proyektor 4K',
                    'Layar motorized',
                    'Sistem audio surround',
                    'Komputer presentasi',
                    'WiFi dedicated',
                    'Kursi ergonomis'
                ],
                'status' => 'active',
                'capacity' => 50,
                'location' => 'Gedung B, Lantai 2',
                'is_featured' => false,
                'sort_order' => 9
            ],
            [
                'name' => 'Taman Sekolah',
                'description' => 'Taman hijau yang asri di tengah sekolah untuk area istirahat dan pembelajaran outdoor. Dilengkapi dengan gazebo dan bangku taman.',
                'category' => 'other',
                'features' => [
                    'Tanaman hias beragam',
                    'Gazebo untuk istirahat',
                    'Bangku taman',
                    'Jalur jogging mini',
                    'Area bermain',
                    'Sistem irigasi otomatis'
                ],
                'status' => 'active',
                'capacity' => 80,
                'location' => 'Area Tengah Sekolah',
                'is_featured' => false,
                'sort_order' => 10
            ]
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}