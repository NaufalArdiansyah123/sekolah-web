<?php
// PERBAIKAN LANGSUNG FACILITIES
echo "MEMPERBAIKI FACILITIES...\n\n";

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$db = $app['db']->connection();

// 1. Drop tabel lama
echo "1. Menghapus tabel lama...\n";
try {
    $db->statement('DROP TABLE IF EXISTS facilities');
    echo "OK\n";
} catch (Exception $e) {
    echo "Skip\n";
}

// 2. Buat tabel baru
echo "2. Membuat tabel baru...\n";
$sql = "CREATE TABLE facilities (
    id bigint PRIMARY KEY AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description text NOT NULL,
    category enum('academic','sport','technology','arts','other') DEFAULT 'other',
    image varchar(255),
    features json,
    status enum('active','maintenance','inactive') DEFAULT 'active',
    capacity int,
    location varchar(255),
    is_featured boolean DEFAULT false,
    sort_order int DEFAULT 0,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    deleted_at timestamp NULL
)";
$db->statement($sql);
echo "OK\n";

// 3. Insert data
echo "3. Menambah data...\n";
$data = [
    ['Laboratorium Komputer', 'Lab komputer modern', 'technology', 'active', 40, 'Lantai 2', 1, 1],
    ['Perpustakaan', 'Perpustakaan digital', 'academic', 'active', 100, 'Lantai 1', 1, 2],
    ['Lapangan Olahraga', 'Lapangan multifungsi', 'sport', 'active', 200, 'Outdoor', 1, 3],
    ['Lab Sains', 'Laboratorium sains', 'academic', 'active', 30, 'Lantai 3', 0, 4],
    ['Aula', 'Aula serba guna', 'arts', 'active', 500, 'Gedung D', 1, 5]
];

foreach ($data as $row) {
    $db->insert("INSERT INTO facilities (name, description, category, status, capacity, location, is_featured, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())", $row);
}
echo "OK\n";

// 4. Test query
echo "4. Test query...\n";
$result = $db->select("SELECT * FROM facilities WHERE status = 'active' AND deleted_at IS NULL ORDER BY sort_order ASC");
echo "Ditemukan " . count($result) . " fasilitas\n";

echo "\nSELESAI! Refresh halaman /facilities\n";
?>