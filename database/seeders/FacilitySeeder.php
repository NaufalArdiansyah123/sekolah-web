<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Laboratorium Komputer',
                'description' => 'Lab komputer modern dengan 40 unit PC terkini, jaringan internet cepat, dan software pendidikan lengkap untuk mendukung pembelajaran teknologi informasi.',
                'category' => 'technology',
                'features' => [
                    '40 Unit PC Core i5, 8GB RAM, SSD 256GB',
                    'Jaringan internet 100 Mbps dedicated',
                    'LCD projector dan layar besar',
                    'Software pendidikan lengkap (Office, Programming, Design)',
                    'AC dan sistem ventilasi yang nyaman',
                    'Furniture ergonomis untuk kenyamanan belajar'
                ],
                'status' => 'active',
                'capacity' => 40,
                'location' => 'Lantai 2, Gedung A',
                'is_featured' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Perpustakaan Digital',
                'description' => 'Perpustakaan dengan koleksi lebih dari 10.000 buku dari berbagai disiplin ilmu, dilengkapi dengan sistem pencarian digital dan area baca yang nyaman.',
                'category' => 'academic',
                'features' => [
                    'Koleksi 10.000+ buku cetak dan digital',
                    'Komputer dengan akses katalog digital',
                    'Area baca dengan pencahayaan optimal',
                    'Ruang diskusi kelompok',
                    'Sistem peminjaman elektronik',
                    'Koneksi WiFi khusus'
                ],
                'status' => 'active',
                'capacity' => 100,
                'location' => 'Lantai 1, Gedung B',
                'is_featured' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Lapangan Olahraga',
                'description' => 'Lapangan multifungsi untuk basket, voli, futsal, dan atletik dengan permukaan berkualitas standar nasional.',
                'category' => 'sport',
                'features' => [
                    'Lapangan basket standar FIBA',
                    'Lapangan voli indoor',
                    'Area futsal dengan rumput sintetis',
                    'Trek lari 400 meter',
                    'Tribun penonton kapasitas 200 orang',
                    'Sistem pencahayaan LED'
                ],
                'status' => 'active',
                'capacity' => 200,
                'location' => 'Area Outdoor, Belakang Gedung C',
                'is_featured' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Laboratorium Sains',
                'description' => 'Lab fisika, kimia, dan biologi lengkap dengan peralatan praktikum modern dan alat keselamatan standar untuk mendukung pembelajaran sains.',
                'category' => 'academic',
                'features' => [
                    'Peralatan praktikum fisika lengkap',
                    'Lab kimia dengan fume hood',
                    'Mikroskop digital untuk biologi',
                    'Perlengkapan keselamatan standar',
                    'Sistem ventilasi khusus',
                    'Lemari asam dan bahan kimia'
                ],
                'status' => 'active',
                'capacity' => 30,
                'location' => 'Lantai 3, Gedung A',
                'is_featured' => false,
                'sort_order' => 4
            ],
            [
                'name' => 'Aula Serba Guna',
                'description' => 'Aula modern kapasitas 500 orang dengan sound system profesional, lighting, dan panggung permanen untuk berbagai acara sekolah.',
                'category' => 'arts',
                'features' => [
                    'Kapasitas 500 orang',
                    'Sound system profesional',
                    'Lighting modern dengan kontrol DMX',
                    'Panggung permanen 12x8 meter',
                    'AC central',
                    'Ruang ganti dan backstage'
                ],
                'status' => 'active',
                'capacity' => 500,
                'location' => 'Gedung D',
                'is_featured' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Kantin Sehat',
                'description' => 'Kantin dengan konsep sehat, menyajikan makanan bergizi, higienis, dan harga terjangkau untuk siswa dan staff sekolah.',
                'category' => 'other',
                'features' => [
                    'Menu makanan sehat dan bergizi',
                    'Standar kebersihan tinggi',
                    'Harga terjangkau untuk siswa',
                    'Area makan indoor dan outdoor',
                    'Sistem pembayaran cashless',
                    'Menu vegetarian tersedia'
                ],
                'status' => 'active',
                'capacity' => 150,
                'location' => 'Lantai 1, Gedung C',
                'is_featured' => false,
                'sort_order' => 6
            ],
            [
                'name' => 'Studio Musik',
                'description' => 'Studio musik lengkap dengan berbagai alat musik dan sistem recording untuk mendukung pembelajaran seni musik dan ekstrakurikuler band.',
                'category' => 'arts',
                'features' => [
                    'Piano akustik dan digital',
                    'Drum set lengkap',
                    'Gitar akustik dan elektrik',
                    'Bass elektrik',
                    'Sistem recording digital',
                    'Kedap suara'
                ],
                'status' => 'active',
                'capacity' => 20,
                'location' => 'Lantai 2, Gedung D',
                'is_featured' => false,
                'sort_order' => 7
            ],
            [
                'name' => 'Laboratorium Bahasa',
                'description' => 'Lab bahasa modern dengan sistem audio digital untuk pembelajaran bahasa Indonesia, Inggris, dan bahasa asing lainnya.',
                'category' => 'academic',
                'features' => [
                    'Sistem audio digital 32 channel',
                    'Headset individual untuk setiap siswa',
                    'Software pembelajaran bahasa',
                    'Proyektor dan layar besar',
                    'Booth recording untuk speaking practice',
                    'AC dan pencahayaan optimal'
                ],
                'status' => 'active',
                'capacity' => 32,
                'location' => 'Lantai 2, Gedung B',
                'is_featured' => false,
                'sort_order' => 8
            ],
            [
                'name' => 'Mushola',
                'description' => 'Tempat ibadah yang nyaman dan bersih untuk seluruh warga sekolah dengan fasilitas wudhu yang memadai.',
                'category' => 'other',
                'features' => [
                    'Ruang sholat pria dan wanita terpisah',
                    'Tempat wudhu dengan air bersih',
                    'Sajadah dan mukena tersedia',
                    'AC dan ventilasi yang baik',
                    'Perpustakaan mini islami',
                    'Jadwal sholat digital'
                ],
                'status' => 'active',
                'capacity' => 80,
                'location' => 'Lantai 1, Gedung E',
                'is_featured' => false,
                'sort_order' => 9
            ],
            [
                'name' => 'Ruang UKS',
                'description' => 'Unit Kesehatan Sekolah dengan fasilitas medis dasar dan tenaga kesehatan untuk memberikan pertolongan pertama kepada siswa.',
                'category' => 'other',
                'features' => [
                    'Tempat tidur untuk istirahat',
                    'Kotak P3K lengkap',
                    'Timbangan dan pengukur tinggi',
                    'Tensimeter dan termometer',
                    'Obat-obatan dasar',
                    'Tenaga kesehatan berpengalaman'
                ],
                'status' => 'active',
                'capacity' => 10,
                'location' => 'Lantai 1, Gedung A',
                'is_featured' => false,
                'sort_order' => 10
            ]
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}