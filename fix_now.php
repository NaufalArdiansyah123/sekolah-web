<!DOCTYPE html>
<html>
<head>
    <title>Fix Facilities</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f0f0f0; }
        .box { background: white; padding: 20px; border-radius: 8px; max-width: 500px; margin: 0 auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        button { background: #007cba; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 18px; width: 100%; }
        button:hover { background: #005a87; }
        .result { margin-top: 20px; padding: 15px; background: #e8f5e8; border-radius: 5px; }
        .link { display: inline-block; margin-top: 15px; background: #4caf50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="box">
        <h1>🔧 Fix Facilities Error</h1>
        
        <?php if (isset($_POST['fix'])): ?>
            <div class="result">
                <?php
                try {
                    require_once 'vendor/autoload.php';
                    $app = require_once 'bootstrap/app.php';
                    $db = $app['db']->connection();
                    
                    echo "1. Menghapus tabel lama...<br>";
                    $db->statement('DROP TABLE IF EXISTS facilities');
                    echo "<span class='success'>✅ OK</span><br><br>";
                    
                    echo "2. Membuat tabel baru...<br>";
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
                    echo "<span class='success'>✅ Tabel berhasil dibuat</span><br><br>";
                    
                    echo "3. Menambah data contoh...<br>";
                    $db->statement("INSERT INTO facilities (name, description, category, status, capacity, location, is_featured, sort_order) VALUES 
                        ('Laboratorium Komputer', 'Lab komputer modern dengan 40 unit PC terkini', 'technology', 'active', 40, 'Lantai 2, Gedung A', 1, 1),
                        ('Perpustakaan Digital', 'Perpustakaan dengan koleksi 10.000+ buku', 'academic', 'active', 100, 'Lantai 1, Gedung B', 1, 2),
                        ('Lapangan Olahraga', 'Lapangan multifungsi untuk berbagai olahraga', 'sport', 'active', 200, 'Area Outdoor', 1, 3),
                        ('Laboratorium Sains', 'Lab fisika, kimia, dan biologi lengkap', 'academic', 'active', 30, 'Lantai 3, Gedung A', 0, 4),
                        ('Aula Serba Guna', 'Aula modern kapasitas 500 orang', 'arts', 'active', 500, 'Gedung D', 1, 5)");
                    echo "<span class='success'>✅ 5 fasilitas berhasil ditambahkan</span><br><br>";
                    
                    echo "4. Test query...<br>";
                    $result = $db->select("SELECT COUNT(*) as count FROM facilities WHERE status = 'active' AND deleted_at IS NULL");
                    echo "<span class='success'>✅ Ditemukan " . $result[0]->count . " fasilitas aktif</span><br><br>";
                    
                    echo "<h2 class='success'>🎉 PERBAIKAN SELESAI!</h2>";
                    echo "<p>Error sudah diperbaiki. Silakan buka halaman facilities:</p>";
                    echo "<a href='/facilities' target='_blank' class='link'>Buka Halaman Facilities</a>";
                    
                } catch (Exception $e) {
                    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
                    echo "<p>Pastikan XAMPP MySQL sudah running!</p>";
                }
                ?>
            </div>
        <?php else: ?>
            <p>Klik tombol di bawah untuk memperbaiki error facilities:</p>
            <form method="post">
                <button type="submit" name="fix">🔧 PERBAIKI SEKARANG</button>
            </form>
            <p><small>Script ini akan membuat ulang tabel facilities dengan struktur yang benar.</small></p>
        <?php endif; ?>
    </div>
</body>
</html>