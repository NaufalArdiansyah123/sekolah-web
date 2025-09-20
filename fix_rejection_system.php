<?php
/**
 * Script untuk memperbaiki sistem rejection student registration
 * Jalankan dengan: php fix_rejection_system.php
 */

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

echo "🔧 Memperbaiki sistem rejection student registration...\n\n";

// 1. Jalankan migration
echo "1. Menjalankan migration untuk field rejection...\n";
try {
    Artisan::call('migrate', ['--force' => true]);
    echo "   ✅ Migration berhasil dijalankan\n";
} catch (Exception $e) {
    echo "   ❌ Error migration: " . $e->getMessage() . "\n";
}

// 2. Periksa struktur tabel users
echo "\n2. Memeriksa struktur tabel users...\n";
$columns = Schema::getColumnListing('users');
$requiredColumns = ['rejection_reason', 'rejected_at', 'rejected_by', 'approved_at', 'approved_by', 'status'];

foreach ($requiredColumns as $column) {
    if (in_array($column, $columns)) {
        echo "   ✅ Column '$column' ada\n";
    } else {
        echo "   ❌ Column '$column' tidak ada\n";
    }
}

// 3. Periksa enum status
echo "\n3. Memeriksa enum status...\n";
try {
    $result = DB::select("SHOW COLUMNS FROM users LIKE 'status'");
    if (!empty($result)) {
        $enumValues = $result[0]->Type;
        echo "   Status enum: $enumValues\n";
        
        if (strpos($enumValues, 'rejected') !== false) {
            echo "   ✅ Status 'rejected' tersedia\n";
        } else {
            echo "   ❌ Status 'rejected' tidak tersedia\n";
            echo "   🔧 Menambahkan status 'rejected'...\n";
            DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'inactive', 'pending', 'rejected') DEFAULT 'pending'");
            echo "   ✅ Status 'rejected' berhasil ditambahkan\n";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error checking status enum: " . $e->getMessage() . "\n";
}

// 4. Test data untuk memastikan sistem berfungsi
echo "\n4. Testing sistem rejection...\n";
try {
    // Cari user dengan status pending
    $pendingUser = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('roles.name', 'student')
        ->where('users.status', 'pending')
        ->select('users.*')
        ->first();
    
    if ($pendingUser) {
        echo "   ✅ Ditemukan user pending untuk testing: {$pendingUser->name} (ID: {$pendingUser->id})\n";
        
        // Test update rejection
        $testUpdate = DB::table('users')
            ->where('id', $pendingUser->id)
            ->update([
                'status' => 'rejected',
                'rejection_reason' => 'Test rejection reason',
                'rejected_at' => now(),
                'rejected_by' => 1
            ]);
        
        if ($testUpdate) {
            echo "   ✅ Test update rejection berhasil\n";
            
            // Rollback test
            DB::table('users')
                ->where('id', $pendingUser->id)
                ->update([
                    'status' => 'pending',
                    'rejection_reason' => null,
                    'rejected_at' => null,
                    'rejected_by' => null
                ]);
            echo "   ✅ Test data di-rollback\n";
        } else {
            echo "   ❌ Test update rejection gagal\n";
        }
    } else {
        echo "   ⚠️  Tidak ada user pending untuk testing\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error testing: " . $e->getMessage() . "\n";
}

// 5. Periksa route
echo "\n5. Memeriksa route rejection...\n";
try {
    $routes = Artisan::call('route:list', ['--name' => 'admin.student-registrations.reject']);
    echo "   ✅ Route rejection tersedia\n";
} catch (Exception $e) {
    echo "   ❌ Error checking routes: " . $e->getMessage() . "\n";
}

// 6. Clear cache
echo "\n6. Membersihkan cache...\n";
try {
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    echo "   ✅ Cache berhasil dibersihkan\n";
} catch (Exception $e) {
    echo "   ❌ Error clearing cache: " . $e->getMessage() . "\n";
}

echo "\n🎉 Perbaikan sistem rejection selesai!\n";
echo "\n📋 Langkah selanjutnya:\n";
echo "1. Buka halaman admin student registrations\n";
echo "2. Coba tolak salah satu pendaftaran\n";
echo "3. Periksa console browser untuk debug info\n";
echo "4. Periksa log Laravel di storage/logs/laravel.log\n";
echo "\n💡 Jika masih error, periksa:\n";
echo "- CSRF token di browser\n";
echo "- JavaScript console untuk error\n";
echo "- Network tab untuk response detail\n";
echo "- Laravel log untuk error server\n";
?>