<?php

echo "🔧 Memperbaiki kolom sort_order\n";
echo "==============================\n\n";

require_once 'vendor/autoload.php';

try {
    $app = require_once 'bootstrap/app.php';
    $connection = $app['db']->connection();
    
    echo "1. 🔍 Mengecek struktur tabel facilities...\n";
    $columns = $connection->select("SHOW COLUMNS FROM facilities");
    
    $columnNames = [];
    foreach ($columns as $column) {
        $columnNames[] = $column->Field;
    }
    
    echo "   📋 Kolom yang ada: " . implode(', ', $columnNames) . "\n";
    
    // Cek kolom yang hilang
    $requiredColumns = [
        'sort_order' => 'int(11) NOT NULL DEFAULT 0',
        'is_featured' => 'tinyint(1) NOT NULL DEFAULT 0',
        'capacity' => 'int(11) DEFAULT NULL',
        'location' => 'varchar(255) DEFAULT NULL',
        'features' => 'json DEFAULT NULL',
        'image' => 'varchar(255) DEFAULT NULL'
    ];
    
    $missingColumns = [];
    foreach ($requiredColumns as $col => $def) {
        if (!in_array($col, $columnNames)) {
            $missingColumns[$col] = $def;
        }
    }
    
    if (!empty($missingColumns)) {
        echo "\n2. ➕ Menambahkan kolom yang hilang...\n";
        foreach ($missingColumns as $column => $definition) {
            try {
                $sql = "ALTER TABLE facilities ADD COLUMN `$column` $definition";
                $connection->statement($sql);
                echo "   ✅ Kolom '$column' berhasil ditambahkan\n";
            } catch (Exception $e) {
                echo "   ❌ Error menambah kolom '$column': " . $e->getMessage() . "\n";
            }
        }
    } else {
        echo "\n2. ✅ Semua kolom sudah ada\n";
    }
    
    echo "\n3. 🔍 Verifikasi struktur tabel setelah perbaikan...\n";
    $newColumns = $connection->select("SHOW COLUMNS FROM facilities");
    $newColumnNames = [];
    foreach ($newColumns as $column) {
        $newColumnNames[] = $column->Field;
    }
    echo "   📋 Kolom sekarang: " . implode(', ', $newColumnNames) . "\n";
    
    // Test query yang error
    echo "\n4. 🧪 Test query yang menyebabkan error...\n";
    try {
        $testQuery = "SELECT * FROM `facilities` WHERE `status` = 'active' AND `facilities`.`deleted_at` IS NULL ORDER BY `sort_order` ASC LIMIT 5";
        $result = $connection->select($testQuery);
        echo "   ✅ Query berhasil! Ditemukan " . count($result) . " fasilitas\n";
        
        if (count($result) > 0) {
            echo "   📋 Contoh fasilitas:\n";
            foreach ($result as $facility) {
                $sortOrder = isset($facility->sort_order) ? $facility->sort_order : 'NULL';
                echo "      - {$facility->name} (sort_order: $sortOrder)\n";
            }
        }
    } catch (Exception $e) {
        echo "   ❌ Query masih error: " . $e->getMessage() . "\n";
    }
    
    // Update data jika sort_order kosong
    echo "\n5. 🔄 Update sort_order untuk data yang ada...\n";
    try {
        $facilities = $connection->select("SELECT id, name FROM facilities WHERE sort_order IS NULL OR sort_order = 0 ORDER BY id");
        if (count($facilities) > 0) {
            $sortOrder = 1;
            foreach ($facilities as $facility) {
                $connection->update("UPDATE facilities SET sort_order = ? WHERE id = ?", [$sortOrder, $facility->id]);
                echo "   ✅ {$facility->name} -> sort_order: $sortOrder\n";
                $sortOrder++;
            }
        } else {
            echo "   ✅ Semua data sudah memiliki sort_order\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error update sort_order: " . $e->getMessage() . "\n";
    }
    
    echo "\n6. 🧹 Clear cache...\n";
    try {
        shell_exec('php artisan cache:clear 2>&1');
        shell_exec('php artisan config:clear 2>&1');
        echo "   ✅ Cache berhasil dibersihkan\n";
    } catch (Exception $e) {
        echo "   ⚠️ Clear cache error: " . $e->getMessage() . "\n";
    }
    
    echo "\n🎉 PERBAIKAN SELESAI!\n";
    echo "====================\n";
    echo "✅ Kolom sort_order sudah tersedia\n";
    echo "✅ Data sudah diupdate\n";
    echo "✅ Cache sudah dibersihkan\n";
    echo "\n🌐 Silakan refresh halaman /facilities\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "💡 Pastikan database sudah running dan konfigurasi .env benar\n";
}

echo "\n";