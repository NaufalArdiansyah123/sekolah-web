<?php

/**
 * Laravel-based Status Column Fix
 * Uses Laravel's database tools to fix the status column
 */

echo "🔧 LARAVEL STATUS COLUMN FIX\n";
echo "============================\n\n";

try {
    // Load Laravel application
    echo "1️⃣ Loading Laravel application...\n";
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "✅ Laravel application loaded\n";

    // Clear caches first
    echo "\n2️⃣ Clearing Laravel caches...\n";
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "✅ Caches cleared\n";

    // Test database connection
    echo "\n3️⃣ Testing database connection...\n";
    $connection = \Illuminate\Support\Facades\DB::connection();
    $pdo = $connection->getPdo();
    
    if ($pdo) {
        echo "✅ Laravel database connection successful\n";
    } else {
        throw new Exception("Failed to get PDO connection");
    }

    // Check if facilities table exists
    echo "\n4️⃣ Checking facilities table...\n";
    if (\Illuminate\Support\Facades\Schema::hasTable('facilities')) {
        echo "✅ Facilities table exists\n";
        
        // Get current columns
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('facilities');
        echo "📋 Table columns: " . implode(', ', $columns) . "\n";
        
        // Check if status column exists
        if (in_array('status', $columns)) {
            echo "✅ Status column exists\n";
            
            // Get column details
            $columnInfo = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM facilities WHERE Field = 'status'");
            if (!empty($columnInfo)) {
                $column = $columnInfo[0];
                echo "📋 Current status column: {$column->Type}\n";
                
                // Check if it's the correct ENUM
                if (!str_contains(strtolower($column->Type), 'enum') || 
                    !str_contains(strtolower($column->Type), 'active')) {
                    
                    echo "❌ Status column has incorrect type\n";
                    echo "🔧 Fixing status column...\n";
                    
                    // Backup existing data
                    $existingFacilities = \Illuminate\Support\Facades\DB::table('facilities')
                        ->select('id', 'name', 'status')
                        ->get();
                    
                    echo "📦 Backed up " . $existingFacilities->count() . " facilities\n";
                    
                    // Use Schema builder to fix column
                    \Illuminate\Support\Facades\Schema::table('facilities', function ($table) {
                        $table->dropColumn('status');
                    });
                    
                    \Illuminate\Support\Facades\Schema::table('facilities', function ($table) {
                        $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
                    });
                    
                    echo "✅ Status column recreated with correct ENUM type\n";
                    
                    // Restore data
                    foreach ($existingFacilities as $facility) {
                        $validStatus = 'active';
                        
                        if (in_array(strtolower($facility->status ?? ''), ['active', 'maintenance', 'inactive'])) {
                            $validStatus = strtolower($facility->status);
                        }
                        
                        \Illuminate\Support\Facades\DB::table('facilities')
                            ->where('id', $facility->id)
                            ->update(['status' => $validStatus]);
                        
                        echo "✅ Restored: {$facility->name} (status: $validStatus)\n";
                    }
                    
                } else {
                    echo "✅ Status column already has correct ENUM type\n";
                }
            }
            
        } else {
            echo "❌ Status column does not exist\n";
            echo "🔧 Adding status column...\n";
            
            \Illuminate\Support\Facades\Schema::table('facilities', function ($table) {
                $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            });
            
            echo "✅ Status column added\n";
        }
        
    } else {
        echo "❌ Facilities table does not exist\n";
        echo "🔧 Running migrations...\n";
        
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        echo "📋 Migration output:\n$output\n";
    }

    // Test facility creation
    echo "\n5️⃣ Testing facility creation...\n";
    
    $testData = [
        'name' => 'Laravel Test Facility ' . time(),
        'description' => 'Test facility created via Laravel fix script',
        'category' => 'other',
        'status' => 'active',
        'created_at' => now(),
        'updated_at' => now()
    ];
    
    $facilityId = \Illuminate\Support\Facades\DB::table('facilities')->insertGetId($testData);
    echo "✅ Test facility created successfully! ID: $facilityId\n";
    
    // Test status updates
    $statusValues = ['maintenance', 'inactive', 'active'];
    foreach ($statusValues as $status) {
        \Illuminate\Support\Facades\DB::table('facilities')
            ->where('id', $facilityId)
            ->update(['status' => $status]);
        echo "✅ Status update to '$status' successful\n";
    }
    
    // Clean up test data
    \Illuminate\Support\Facades\DB::table('facilities')->where('id', $facilityId)->delete();
    echo "🧹 Test facility cleaned up\n";

    // Final verification
    echo "\n6️⃣ Final verification...\n";
    
    $statusCounts = \Illuminate\Support\Facades\DB::table('facilities')
        ->select('status', \Illuminate\Support\Facades\DB::raw('COUNT(*) as count'))
        ->groupBy('status')
        ->get();
    
    echo "📊 Facilities by status:\n";
    foreach ($statusCounts as $statusCount) {
        echo "   - {$statusCount->status}: {$statusCount->count} facilities\n";
    }

    echo "\n🎉 LARAVEL STATUS FIX COMPLETED!\n";
    echo "✅ Status column is now working correctly\n";
    echo "✅ Laravel can create facilities without errors\n";
    echo "✅ All status values are functional\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n";
    
    // Specific error handling
    if (str_contains($e->getMessage(), 'Connection refused')) {
        echo "\n🔧 SOLUTION: Start XAMPP MySQL\n";
        echo "1. Open XAMPP Control Panel\n";
        echo "2. Start MySQL service\n";
    } elseif (str_contains($e->getMessage(), 'database') && str_contains($e->getMessage(), 'exist')) {
        echo "\n🔧 SOLUTION: Create database\n";
        echo "1. Open phpMyAdmin\n";
        echo "2. Create database 'sekolah-web6'\n";
    }
    
    exit(1);
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🚀 STATUS COLUMN IS FIXED - TRY UPLOADING NOW!\n";
echo str_repeat("=", 50) . "\n";