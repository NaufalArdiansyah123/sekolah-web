<?php

echo "Membuat tabel facilities...\n";

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$db = $app['db']->connection();

// Drop dan buat ulang tabel
$db->statement('DROP TABLE IF EXISTS facilities');

$sql = "CREATE TABLE facilities (
    id bigint PRIMARY KEY AUTO_INCREMENT,
    name varchar(255) NOT NULL DEFAULT '',
    description text NOT NULL,
    category varchar(50) DEFAULT 'other',
    image varchar(255) DEFAULT NULL,
    features text DEFAULT NULL,
    status varchar(20) DEFAULT 'active',
    capacity int DEFAULT NULL,
    location varchar(255) DEFAULT NULL,
    is_featured tinyint(1) DEFAULT 0,
    sort_order int DEFAULT 0,
    created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at timestamp NULL DEFAULT NULL
)";

$db->statement($sql);

// Insert data contoh
$data = [
    "INSERT INTO facilities (name, description, category, status, capacity, location, is_featured, sort_order) VALUES 
    ('Laboratorium Komputer', 'Lab komputer modern', 'technology', 'active', 40, 'Lantai 2', 1, 1),
    ('Perpustakaan', 'Perpustakaan digital', 'academic', 'active', 100, 'Lantai 1', 1, 2),
    ('Lapangan Olahraga', 'Lapangan multifungsi', 'sport', 'active', 200, 'Outdoor', 1, 3)"
];

foreach ($data as $sql) {
    $db->statement($sql);
}

echo "Selesai! Refresh halaman /facilities\n";
?>