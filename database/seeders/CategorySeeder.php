<?php
// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Akademik',
                'slug' => 'akademik',
                'description' => 'Kategori untuk konten akademik',
                'color' => '#3B82F6',
                'icon' => 'academic-cap'
            ],
            [
                'name' => 'Kegiatan Sekolah',
                'slug' => 'kegiatan-sekolah',
                'description' => 'Kategori untuk kegiatan dan acara sekolah',
                'color' => '#10B981',
                'icon' => 'calendar'
            ],
            [
                'name' => 'Prestasi',
                'slug' => 'prestasi',
                'description' => 'Kategori untuk prestasi siswa dan sekolah',
                'color' => '#F59E0B',
                'icon' => 'trophy'
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Kategori untuk pengumuman penting',
                'color' => '#EF4444',
                'icon' => 'megaphone'
            ],
            [
                'name' => 'Berita',
                'slug' => 'berita',
                'description' => 'Kategori untuk berita sekolah',
                'color' => '#8B5CF6',
                'icon' => 'newspaper'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}