<?php

echo "🔧 Memperbaiki Migration Facilities\n";
echo "===================================\n\n";

// Set working directory
chdir(__DIR__);

// Cek apakah tabel facilities sudah ada
echo "1. Mengecek status tabel facilities...\n";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $connection = $app['db']->connection();
    
    // Cek apakah tabel ada
    $tables = $connection->getDoctrineSchemaManager()->listTableNames();
    
    if (in_array('facilities', $tables)) {
        echo "   ⚠️ Tabel facilities sudah ada, akan di-drop dan dibuat ulang\n";
        
        // Drop tabel yang ada
        echo "2. Menghapus tabel facilities yang lama...\n";
        $connection->statement('DROP TABLE IF EXISTS facilities');
        echo "   ✅ Tabel lama berhasil dihapus\n";
    } else {
        echo "   ✅ Tabel facilities belum ada\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Error saat cek database: " . $e->getMessage() . "\n";
}

// Jalankan migration fresh untuk facilities
echo "\n3. Menjalankan migration facilities...\n";
$output = shell_exec('php artisan migrate --path=database/migrations/2025_08_29_075151_create_facilities_table.php --force 2>&1');
echo $output . "\n";

// Cek hasil migration
echo "4. Verifikasi tabel facilities...\n";
try {
    $tables = $connection->getDoctrineSchemaManager()->listTableNames();
    
    if (in_array('facilities', $tables)) {
        echo "   ✅ Tabel facilities berhasil dibuat\n";
        
        // Cek kolom
        $columns = $connection->getDoctrineSchemaManager()->listTableColumns('facilities');
        $columnNames = array_keys($columns);
        
        $requiredColumns = ['id', 'name', 'description', 'category', 'status', 'deleted_at'];
        $missingColumns = array_diff($requiredColumns, $columnNames);
        
        if (empty($missingColumns)) {
            echo "   ✅ Semua kolom yang diperlukan ada\n";
            echo "   📋 Kolom: " . implode(', ', $columnNames) . "\n";
        } else {
            echo "   ❌ Kolom yang hilang: " . implode(', ', $missingColumns) . "\n";
        }
    } else {
        echo "   ❌ Tabel facilities tidak ditemukan\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Error saat verifikasi: " . $e->getMessage() . "\n";
}

// Jalankan storage link
echo "\n5. Membuat storage link...\n";
$link = shell_exec('php artisan storage:link 2>&1');
echo $link . "\n";

// Jalankan seeder
echo "6. Menjalankan seeder...\n";
$seeder = shell_exec('php artisan db:seed --class=FacilitySeeder 2>&1');
echo $seeder . "\n";

// Final check
echo "7. Pengecekan akhir...\n";
try {
    $count = $connection->table('facilities')->count();
    echo "   📊 Jumlah fasilitas: $count\n";
    
    if ($count > 0) {
        echo "   ✅ Data fasilitas berhasil ditambahkan!\n";
        
        // Tampilkan beberapa data
        $facilities = $connection->table('facilities')->limit(3)->get();
        echo "   📋 Contoh fasilitas:\n";
        foreach ($facilities as $facility) {
            echo "      - {$facility->name} ({$facility->category})\n";
        }
    }
    
} catch (Exception $e) {
    echo "   ❌ Error saat cek data: " . $e->getMessage() . "\n";
}

echo "\n🎉 Setup selesai!\n";
echo "Silakan refresh halaman /facilities\n";