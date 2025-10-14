<?php
/**
 * Script untuk memperbaiki masalah migration attendance_submissions
 * Jalankan dengan: php fix_migration.php
 */

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "🔧 Memperbaiki masalah migration attendance_submissions...\n\n";
    
    // Cek apakah tabel attendance_submissions ada
    if (Schema::hasTable('attendance_submissions')) {
        echo "✅ Tabel attendance_submissions ditemukan\n";
        
        // Drop tabel yang sudah ada
        echo "🗑️  Menghapus tabel attendance_submissions yang sudah ada...\n";
        Schema::dropIfExists('attendance_submissions');
        echo "✅ Tabel attendance_submissions berhasil dihapus\n";
    } else {
        echo "ℹ️  Tabel attendance_submissions tidak ditemukan\n";
    }
    
    // Hapus record migration dari tabel migrations jika ada
    $migrationName = '2024_11_28_000001_create_attendance_submissions_table';
    $deleted = DB::table('migrations')->where('migration', $migrationName)->delete();
    
    if ($deleted > 0) {
        echo "🗑️  Record migration '$migrationName' dihapus dari tabel migrations\n";
    } else {
        echo "ℹ️  Record migration '$migrationName' tidak ditemukan di tabel migrations\n";
    }
    
    echo "\n✅ Perbaikan selesai!\n";
    echo "🚀 Sekarang jalankan: php artisan migrate\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📋 Trace: " . $e->getTraceAsString() . "\n";
}