<?php

/**
 * Script to fix facilities database issues
 * Run this script to add missing columns to facilities table
 */

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

echo "🔧 Fixing Facilities Database Issues...\n\n";

try {
    // Check if facilities table exists
    if (!Schema::hasTable('facilities')) {
        echo "❌ Facilities table does not exist!\n";
        echo "Please run: php artisan migrate\n";
        exit(1);
    }
    
    echo "✅ Facilities table exists\n";
    
    // Get current columns
    $columns = Schema::getColumnListing('facilities');
    echo "📋 Current columns: " . implode(', ', $columns) . "\n\n";
    
    // Define required columns with their types
    $requiredColumns = [
        'sort_order' => 'integer',
        'is_featured' => 'boolean', 
        'capacity' => 'integer',
        'location' => 'string',
        'features' => 'json'
    ];
    
    $missingColumns = [];
    $addedColumns = [];
    
    // Check which columns are missing
    foreach ($requiredColumns as $column => $type) {
        if (!in_array($column, $columns)) {
            $missingColumns[] = $column;
        }
    }
    
    if (empty($missingColumns)) {
        echo "✅ All required columns exist!\n";
    } else {
        echo "⚠️  Missing columns: " . implode(', ', $missingColumns) . "\n";
        echo "🔨 Adding missing columns...\n\n";
        
        // Add missing columns
        Schema::table('facilities', function (Blueprint $table) use ($missingColumns, &$addedColumns) {
            foreach ($missingColumns as $column) {
                switch ($column) {
                    case 'sort_order':
                        $table->integer('sort_order')->default(0);
                        $addedColumns[] = 'sort_order (integer, default: 0)';
                        break;
                        
                    case 'is_featured':
                        $table->boolean('is_featured')->default(false);
                        $addedColumns[] = 'is_featured (boolean, default: false)';
                        break;
                        
                    case 'capacity':
                        $table->integer('capacity')->nullable();
                        $addedColumns[] = 'capacity (integer, nullable)';
                        break;
                        
                    case 'location':
                        $table->string('location')->nullable();
                        $addedColumns[] = 'location (string, nullable)';
                        break;
                        
                    case 'features':
                        $table->json('features')->nullable();
                        $addedColumns[] = 'features (json, nullable)';
                        break;
                }
            }
        });
        
        echo "✅ Successfully added columns:\n";
        foreach ($addedColumns as $column) {
            echo "   - $column\n";
        }
    }
    
    // Update existing facilities with default sort_order if needed
    if (in_array('sort_order', $missingColumns)) {
        echo "\n🔄 Setting default sort_order for existing facilities...\n";
        
        $facilities = DB::table('facilities')->whereNull('sort_order')->orWhere('sort_order', 0)->get();
        
        foreach ($facilities as $index => $facility) {
            DB::table('facilities')
                ->where('id', $facility->id)
                ->update(['sort_order' => $index + 1]);
        }
        
        echo "✅ Updated sort_order for " . count($facilities) . " facilities\n";
    }
    
    // Verify the fix
    echo "\n🔍 Verifying fix...\n";
    
    try {
        $maxSortOrder = DB::table('facilities')->max('sort_order');
        echo "✅ sort_order column working! Max value: " . ($maxSortOrder ?? 0) . "\n";
    } catch (Exception $e) {
        echo "❌ sort_order column still has issues: " . $e->getMessage() . "\n";
    }
    
    // Test facility creation
    echo "\n🧪 Testing facility creation...\n";
    
    try {
        $testData = [
            'name' => 'Test Facility - ' . date('Y-m-d H:i:s'),
            'description' => 'Test facility for database fix verification',
            'category' => 'other',
            'status' => 'active',
            'sort_order' => ($maxSortOrder ?? 0) + 1,
            'is_featured' => false,
            'created_at' => now(),
            'updated_at' => now()
        ];
        
        $facilityId = DB::table('facilities')->insertGetId($testData);
        
        echo "✅ Test facility created successfully! ID: $facilityId\n";
        
        // Clean up test facility
        DB::table('facilities')->where('id', $facilityId)->delete();
        echo "✅ Test facility cleaned up\n";
        
    } catch (Exception $e) {
        echo "❌ Test facility creation failed: " . $e->getMessage() . "\n";
    }
    
    echo "\n🎉 Database fix completed successfully!\n";
    echo "You can now add facilities without errors.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}