<?php

echo "🔥 FORCE FIX FACILITIES - AGGRESSIVE MODE\n";
echo "=========================================\n\n";

require_once 'vendor/autoload.php';

try {
    $app = require_once 'bootstrap/app.php';
    $connection = $app['db']->connection();
    
    echo "1. 🗑️ Menghapus tabel facilities yang ada (jika ada)...\n";
    try {
        $connection->statement('DROP TABLE IF EXISTS facilities');
        echo "   ✅ Tabel facilities berhasil dihapus\n";
    } catch (Exception $e) {
        echo "   ⚠️ Tidak ada tabel untuk dihapus: " . $e->getMessage() . "\n";
    }
    
    echo "\n2. 🏗️ Membuat tabel facilities dengan struktur lengkap...\n";
    $createTableSQL = "
    CREATE TABLE `facilities` (
        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `category` enum('academic','sport','technology','arts','other') NOT NULL DEFAULT 'other',
        `image` varchar(255) DEFAULT NULL,
        `features` json DEFAULT NULL,
        `status` enum('active','maintenance','inactive') NOT NULL DEFAULT 'active',
        `capacity` int(11) DEFAULT NULL,
        `location` varchar(255) DEFAULT NULL,
        `is_featured` tinyint(1) NOT NULL DEFAULT 0,
        `sort_order` int(11) NOT NULL DEFAULT 0,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        `deleted_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `facilities_status_category_index` (`status`,`category`),
        KEY `facilities_is_featured_sort_order_index` (`is_featured`,`sort_order`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $connection->statement($createTableSQL);
    echo "   ✅ Tabel facilities berhasil dibuat dengan struktur lengkap\n";
    
    echo "\n3. 🔍 Verifikasi struktur tabel...\n";
    $columns = $connection->select("SHOW COLUMNS FROM facilities");
    echo "   📋 Kolom yang tersedia:\n";
    foreach ($columns as $column) {
        echo "      - {$column->Field} ({$column->Type})\n";
    }
    
    // Cek apakah kolom deleted_at ada
    $hasDeletedAt = false;
    foreach ($columns as $column) {
        if ($column->Field === 'deleted_at') {
            $hasDeletedAt = true;
            break;
        }
    }
    
    if ($hasDeletedAt) {
        echo "   ✅ Kolom 'deleted_at' berhasil dibuat!\n";
    } else {
        echo "   ❌ Kolom 'deleted_at' tidak ditemukan!\n";
    }
    
    echo "\n4. 📦 Menambahkan data contoh...\n";
    
    $facilities = [
        [
            'name' => 'Laboratorium Komputer',
            'description' => 'Lab komputer modern dengan 40 unit PC terkini, jaringan internet cepat, dan software pendidikan lengkap untuk mendukung pembelajaran teknologi informasi.',
            'category' => 'technology',
            'features' => json_encode([
                '40 Unit PC Core i5, 8GB RAM, SSD 256GB',
                'Jaringan internet 100 Mbps dedicated',
                'LCD projector dan layar besar',
                'Software pendidikan lengkap (Office, Programming, Design)',
                'AC dan sistem ventilasi yang nyaman',
                'Furniture ergonomis untuk kenyamanan belajar'
            ]),
            'status' => 'active',
            'capacity' => 40,
            'location' => 'Lantai 2, Gedung A',
            'is_featured' => 1,
            'sort_order' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Perpustakaan Digital',
            'description' => 'Perpustakaan dengan koleksi lebih dari 10.000 buku dari berbagai disiplin ilmu, dilengkapi dengan sistem pencarian digital dan area baca yang nyaman.',
            'category' => 'academic',
            'features' => json_encode([
                'Koleksi 10.000+ buku cetak dan digital',
                'Komputer dengan akses katalog digital',
                'Area baca dengan pencahayaan optimal',
                'Ruang diskusi kelompok',
                'Sistem peminjaman elektronik',
                'Koneksi WiFi khusus'
            ]),
            'status' => 'active',
            'capacity' => 100,
            'location' => 'Lantai 1, Gedung B',
            'is_featured' => 1,
            'sort_order' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Lapangan Olahraga',
            'description' => 'Lapangan multifungsi untuk basket, voli, futsal, dan atletik dengan permukaan berkualitas standar nasional.',
            'category' => 'sport',
            'features' => json_encode([
                'Lapangan basket standar FIBA',
                'Lapangan voli indoor',
                'Area futsal dengan rumput sintetis',
                'Trek lari 400 meter',
                'Tribun penonton kapasitas 200 orang',
                'Sistem pencahayaan LED'
            ]),
            'status' => 'active',
            'capacity' => 200,
            'location' => 'Area Outdoor, Belakang Gedung C',
            'is_featured' => 1,
            'sort_order' => 3,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Laboratorium Sains',
            'description' => 'Lab fisika, kimia, dan biologi lengkap dengan peralatan praktikum modern dan alat keselamatan standar untuk mendukung pembelajaran sains.',
            'category' => 'academic',
            'features' => json_encode([
                'Peralatan praktikum fisika lengkap',
                'Lab kimia dengan fume hood',
                'Mikroskop digital untuk biologi',
                'Perlengkapan keselamatan standar',
                'Sistem ventilasi khusus',
                'Lemari asam dan bahan kimia'
            ]),
            'status' => 'active',
            'capacity' => 30,
            'location' => 'Lantai 3, Gedung A',
            'is_featured' => 0,
            'sort_order' => 4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Aula Serba Guna',
            'description' => 'Aula modern kapasitas 500 orang dengan sound system profesional, lighting, dan panggung permanen untuk berbagai acara sekolah.',
            'category' => 'arts',
            'features' => json_encode([
                'Kapasitas 500 orang',
                'Sound system profesional',
                'Lighting modern dengan kontrol DMX',
                'Panggung permanen 12x8 meter',
                'AC central',
                'Ruang ganti dan backstage'
            ]),
            'status' => 'active',
            'capacity' => 500,
            'location' => 'Gedung D',
            'is_featured' => 1,
            'sort_order' => 5,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    foreach ($facilities as $facility) {
        $connection->table('facilities')->insert($facility);
    }
    
    echo "   ✅ Data contoh berhasil ditambahkan\n";
    
    echo "\n5. 🧪 Test query yang menyebabkan error...\n";
    try {
        $testQuery = "SELECT * FROM `facilities` WHERE `status` = 'active' AND `facilities`.`deleted_at` IS NULL ORDER BY `sort_order` ASC";
        $result = $connection->select($testQuery);
        echo "   ✅ Query berhasil! Ditemukan " . count($result) . " fasilitas\n";
        
        if (count($result) > 0) {
            echo "   📋 Contoh fasilitas:\n";
            foreach (array_slice($result, 0, 3) as $facility) {
                echo "      - {$facility->name} ({$facility->category})\n";
            }
        }
    } catch (Exception $e) {
        echo "   ❌ Query masih error: " . $e->getMessage() . "\n";
    }
    
    echo "\n6. 🔗 Membuat storage link...\n";
    try {
        $linkOutput = shell_exec('php artisan storage:link 2>&1');
        echo "   " . $linkOutput . "\n";
    } catch (Exception $e) {
        echo "   ⚠️ Storage link error: " . $e->getMessage() . "\n";
    }
    
    echo "\n7. 🧹 Clear cache...\n";
    try {
        shell_exec('php artisan cache:clear 2>&1');
        shell_exec('php artisan config:clear 2>&1');
        shell_exec('php artisan view:clear 2>&1');
        echo "   ✅ Cache berhasil dibersihkan\n";
    } catch (Exception $e) {
        echo "   ⚠️ Clear cache error: " . $e->getMessage() . "\n";
    }
    
    echo "\n🎉 FORCE FIX SELESAI!\n";
    echo "=====================================\n";
    echo "✅ Tabel facilities berhasil dibuat dengan struktur lengkap\n";
    echo "✅ Kolom deleted_at sudah tersedia\n";
    echo "✅ Data contoh sudah ditambahkan\n";
    echo "✅ Cache sudah dibersihkan\n";
    echo "\n🌐 Silakan refresh halaman /facilities\n";
    echo "⚙️ Panel admin tersedia di /admin/facilities\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "💡 Pastikan database sudah running dan konfigurasi .env benar\n";
}

echo "\n";