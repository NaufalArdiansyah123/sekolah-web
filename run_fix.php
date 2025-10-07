<?php

echo "<h1>🔧 PERBAIKAN FACILITIES</h1>";
echo "<hr>";

// Set working directory
chdir(__DIR__);

echo "<h3>1. Menjalankan perbaikan...</h3>";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $connection = $app['db']->connection();
    
    echo "<p>✅ Koneksi database berhasil</p>";
    
    // Cek tabel facilities
    echo "<h3>2. Mengecek tabel facilities...</h3>";
    $tables = $connection->select("SHOW TABLES LIKE 'facilities'");
    
    if (empty($tables)) {
        echo "<p>❌ Tabel facilities tidak ada. Membuat tabel...</p>";
        
        $createSQL = "
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
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        
        $connection->statement($createSQL);
        echo "<p>✅ Tabel facilities berhasil dibuat</p>";
    } else {
        echo "<p>✅ Tabel facilities sudah ada</p>";
    }
    
    // Cek kolom
    echo "<h3>3. Mengecek kolom...</h3>";
    $columns = $connection->select("SHOW COLUMNS FROM facilities");
    $columnNames = [];
    foreach ($columns as $col) {
        $columnNames[] = $col->Field;
    }
    
    echo "<p>Kolom yang ada: " . implode(', ', $columnNames) . "</p>";
    
    // Tambah kolom yang hilang
    $requiredColumns = [
        'sort_order' => 'int(11) NOT NULL DEFAULT 0',
        'is_featured' => 'tinyint(1) NOT NULL DEFAULT 0',
        'capacity' => 'int(11) DEFAULT NULL',
        'location' => 'varchar(255) DEFAULT NULL',
        'features' => 'json DEFAULT NULL',
        'image' => 'varchar(255) DEFAULT NULL',
        'deleted_at' => 'timestamp NULL DEFAULT NULL'
    ];
    
    foreach ($requiredColumns as $col => $def) {
        if (!in_array($col, $columnNames)) {
            try {
                $connection->statement("ALTER TABLE facilities ADD COLUMN `$col` $def");
                echo "<p>✅ Kolom '$col' berhasil ditambahkan</p>";
            } catch (Exception $e) {
                echo "<p>⚠️ Kolom '$col': " . $e->getMessage() . "</p>";
            }
        }
    }
    
    // Tambah data contoh
    echo "<h3>4. Menambah data contoh...</h3>";
    $count = $connection->selectOne("SELECT COUNT(*) as count FROM facilities")->count;
    
    if ($count == 0) {
        $facilities = [
            ['Laboratorium Komputer', 'Lab komputer modern dengan PC terkini', 'technology', 'active', 40, 'Lantai 2, Gedung A', 1, 1],
            ['Perpustakaan Digital', 'Perpustakaan dengan koleksi 10.000+ buku', 'academic', 'active', 100, 'Lantai 1, Gedung B', 1, 2],
            ['Lapangan Olahraga', 'Lapangan multifungsi untuk berbagai olahraga', 'sport', 'active', 200, 'Area Outdoor', 1, 3],
            ['Laboratorium Sains', 'Lab fisika, kimia, dan biologi lengkap', 'academic', 'active', 30, 'Lantai 3, Gedung A', 0, 4],
            ['Aula Serba Guna', 'Aula modern kapasitas 500 orang', 'arts', 'active', 500, 'Gedung D', 1, 5]
        ];
        
        foreach ($facilities as $facility) {
            $connection->insert(
                "INSERT INTO facilities (name, description, category, status, capacity, location, is_featured, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
                $facility
            );
        }
        echo "<p>✅ Data contoh berhasil ditambahkan</p>";
    } else {
        echo "<p>✅ Data sudah ada ($count fasilitas)</p>";
    }
    
    // Test query
    echo "<h3>5. Test query...</h3>";
    try {
        $result = $connection->select("SELECT * FROM facilities WHERE status = 'active' AND deleted_at IS NULL ORDER BY sort_order ASC LIMIT 3");
        echo "<p>✅ Query berhasil! Ditemukan " . count($result) . " fasilitas</p>";
        
        foreach ($result as $facility) {
            echo "<p>- {$facility->name} (sort_order: {$facility->sort_order})</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Query error: " . $e->getMessage() . "</p>";
    }
    
    echo "<h2>🎉 PERBAIKAN SELESAI!</h2>";
    echo "<p><strong>Silakan refresh halaman /facilities sekarang!</strong></p>";
    echo "<p><a href='/facilities' target='_blank'>Klik di sini untuk buka halaman facilities</a></p>";
    
} catch (Exception $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Pastikan XAMPP MySQL sudah running!</p>";
}

?>