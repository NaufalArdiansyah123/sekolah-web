-- Script SQL untuk membuat tabel facilities
-- Jalankan di phpMyAdmin atau MySQL client

-- Hapus tabel jika ada
DROP TABLE IF EXISTS `facilities`;

-- Buat tabel facilities dengan struktur lengkap
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

-- Insert data contoh
INSERT INTO `facilities` (`name`, `description`, `category`, `features`, `status`, `capacity`, `location`, `is_featured`, `sort_order`, `created_at`, `updated_at`) VALUES
('Laboratorium Komputer', 'Lab komputer modern dengan 40 unit PC terkini, jaringan internet cepat, dan software pendidikan lengkap untuk mendukung pembelajaran teknologi informasi.', 'technology', '["40 Unit PC Core i5, 8GB RAM, SSD 256GB", "Jaringan internet 100 Mbps dedicated", "LCD projector dan layar besar", "Software pendidikan lengkap (Office, Programming, Design)", "AC dan sistem ventilasi yang nyaman", "Furniture ergonomis untuk kenyamanan belajar"]', 'active', 40, 'Lantai 2, Gedung A', 1, 1, NOW(), NOW()),
('Perpustakaan Digital', 'Perpustakaan dengan koleksi lebih dari 10.000 buku dari berbagai disiplin ilmu, dilengkapi dengan sistem pencarian digital dan area baca yang nyaman.', 'academic', '["Koleksi 10.000+ buku cetak dan digital", "Komputer dengan akses katalog digital", "Area baca dengan pencahayaan optimal", "Ruang diskusi kelompok", "Sistem peminjaman elektronik", "Koneksi WiFi khusus"]', 'active', 100, 'Lantai 1, Gedung B', 1, 2, NOW(), NOW()),
('Lapangan Olahraga', 'Lapangan multifungsi untuk basket, voli, futsal, dan atletik dengan permukaan berkualitas standar nasional.', 'sport', '["Lapangan basket standar FIBA", "Lapangan voli indoor", "Area futsal dengan rumput sintetis", "Trek lari 400 meter", "Tribun penonton kapasitas 200 orang", "Sistem pencahayaan LED"]', 'active', 200, 'Area Outdoor, Belakang Gedung C', 1, 3, NOW(), NOW()),
('Laboratorium Sains', 'Lab fisika, kimia, dan biologi lengkap dengan peralatan praktikum modern dan alat keselamatan standar untuk mendukung pembelajaran sains.', 'academic', '["Peralatan praktikum fisika lengkap", "Lab kimia dengan fume hood", "Mikroskop digital untuk biologi", "Perlengkapan keselamatan standar", "Sistem ventilasi khusus", "Lemari asam dan bahan kimia"]', 'active', 30, 'Lantai 3, Gedung A', 0, 4, NOW(), NOW()),
('Aula Serba Guna', 'Aula modern kapasitas 500 orang dengan sound system profesional, lighting, dan panggung permanen untuk berbagai acara sekolah.', 'arts', '["Kapasitas 500 orang", "Sound system profesional", "Lighting modern dengan kontrol DMX", "Panggung permanen 12x8 meter", "AC central", "Ruang ganti dan backstage"]', 'active', 500, 'Gedung D', 1, 5, NOW(), NOW());

-- Verifikasi tabel berhasil dibuat
SELECT 'Tabel facilities berhasil dibuat!' as status;
SELECT COUNT(*) as total_facilities FROM facilities;
SELECT name, category, status FROM facilities LIMIT 5;