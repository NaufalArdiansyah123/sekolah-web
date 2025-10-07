-- Script SQL untuk menambahkan kolom yang hilang pada tabel facilities

-- Tambahkan kolom sort_order jika belum ada
ALTER TABLE facilities ADD COLUMN IF NOT EXISTS `sort_order` int(11) NOT NULL DEFAULT 0;

-- Tambahkan kolom is_featured jika belum ada  
ALTER TABLE facilities ADD COLUMN IF NOT EXISTS `is_featured` tinyint(1) NOT NULL DEFAULT 0;

-- Tambahkan kolom capacity jika belum ada
ALTER TABLE facilities ADD COLUMN IF NOT EXISTS `capacity` int(11) DEFAULT NULL;

-- Tambahkan kolom location jika belum ada
ALTER TABLE facilities ADD COLUMN IF NOT EXISTS `location` varchar(255) DEFAULT NULL;

-- Tambahkan kolom features jika belum ada
ALTER TABLE facilities ADD COLUMN IF NOT EXISTS `features` json DEFAULT NULL;

-- Tambahkan kolom image jika belum ada
ALTER TABLE facilities ADD COLUMN IF NOT EXISTS `image` varchar(255) DEFAULT NULL;

-- Update sort_order untuk data yang ada
UPDATE facilities SET sort_order = id WHERE sort_order = 0 OR sort_order IS NULL;

-- Tambahkan index jika belum ada
ALTER TABLE facilities ADD INDEX IF NOT EXISTS `facilities_status_category_index` (`status`,`category`);
ALTER TABLE facilities ADD INDEX IF NOT EXISTS `facilities_is_featured_sort_order_index` (`is_featured`,`sort_order`);

-- Verifikasi struktur tabel
SHOW COLUMNS FROM facilities;

-- Test query yang error
SELECT * FROM `facilities` WHERE `status` = 'active' AND `facilities`.`deleted_at` IS NULL ORDER BY `sort_order` ASC LIMIT 5;