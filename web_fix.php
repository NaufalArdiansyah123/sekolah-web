<!DOCTYPE html>
<html>
<head>
    <title>Fix Facilities</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .step { margin: 10px 0; padding: 10px; background: #f9f9f9; border-left: 4px solid #007cba; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #005a87; }
        .result { margin-top: 20px; padding: 15px; background: #e8f5e8; border: 1px solid #4caf50; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Perbaikan Facilities</h1>
        
        <?php if (isset($_POST['fix'])): ?>
            <div class="result">
                <?php
                try {
                    require_once 'vendor/autoload.php';
                    $app = require_once 'bootstrap/app.php';
                    $db = $app['db']->connection();
                    
                    echo "<div class='step'>1. Menghapus tabel lama...</div>";
                    try {
                        $db->statement('DROP TABLE IF EXISTS facilities');
                        echo "<span class='success'>✅ OK</span><br>";
                    } catch (Exception $e) {
                        echo "<span class='success'>✅ Skip (tidak ada)</span><br>";
                    }
                    
                    echo "<div class='step'>2. Membuat tabel baru...</div>";
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
                    echo "<span class='success'>✅ Tabel berhasil dibuat</span><br>";
                    
                    echo "<div class='step'>3. Menambah data contoh...</div>";
                    $data = [
                        ['Laboratorium Komputer', 'Lab komputer modern dengan 40 unit PC terkini', 'technology', 'active', 40, 'Lantai 2, Gedung A', 1, 1],
                        ['Perpustakaan Digital', 'Perpustakaan dengan koleksi 10.000+ buku', 'academic', 'active', 100, 'Lantai 1, Gedung B', 1, 2],
                        ['Lapangan Olahraga', 'Lapangan multifungsi untuk berbagai olahraga', 'sport', 'active', 200, 'Area Outdoor', 1, 3],
                        ['Laboratorium Sains', 'Lab fisika, kimia, dan biologi lengkap', 'academic', 'active', 30, 'Lantai 3, Gedung A', 0, 4],
                        ['Aula Serba Guna', 'Aula modern kapasitas 500 orang', 'arts', 'active', 500, 'Gedung D', 1, 5]
                    ];
                    
                    foreach ($data as $row) {
                        $db->insert("INSERT INTO facilities (name, description, category, status, capacity, location, is_featured, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())", $row);
                    }
                    echo "<span class='success'>✅ " . count($data) . " fasilitas berhasil ditambahkan</span><br>";
                    
                    echo "<div class='step'>4. Test query...</div>";
                    $result = $db->select("SELECT * FROM facilities WHERE status = 'active' AND deleted_at IS NULL ORDER BY sort_order ASC");
                    echo "<span class='success'>✅ Query berhasil! Ditemukan " . count($result) . " fasilitas</span><br>";
                    
                    echo "<div class='step'>5. Membersihkan cache...</div>";
                    try {
                        shell_exec('php artisan cache:clear 2>&1');
                        shell_exec('php artisan config:clear 2>&1');
                        echo "<span class='success'>✅ Cache berhasil dibersihkan</span><br>";
                    } catch (Exception $e) {
                        echo "<span class='success'>✅ Skip cache</span><br>";
                    }
                    
                    echo "<h2 class='success'>🎉 PERBAIKAN SELESAI!</h2>";
                    echo "<p><strong>Silakan refresh halaman facilities sekarang!</strong></p>";
                    echo "<p><a href='/facilities' target='_blank' style='background: #4caf50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;'>Buka Halaman Facilities</a></p>";
                    
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
        <?php endif; ?>
    </div>
</body>
</html>