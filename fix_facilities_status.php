<?php

/**
 * Script to fix facilities status column issues
 * Run this script to fix status column data truncation error
 */

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

echo "🔧 Fixing Facilities Status Column Issues...\n\n";

try {
    // Check if facilities table exists
    if (!Schema::hasTable('facilities')) {
        echo "❌ Facilities table does not exist!\n";
        echo "Please run: php artisan migrate\n";
        exit(1);
    }
    
    echo "✅ Facilities table exists\n";
    
    // Check current status column structure
    echo "🔍 Checking status column structure...\n";
    
    $columnInfo = DB::select("SHOW COLUMNS FROM facilities WHERE Field = 'status'");
    
    if (empty($columnInfo)) {
        echo "❌ Status column does not exist!\n";
        
        // Add status column
        Schema::table('facilities', function (Blueprint $table) {
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
        });
        
        echo "✅ Added status column with ENUM values\n";
    } else {
        $column = $columnInfo[0];
        echo "📋 Current status column info:\n";
        echo "   Type: {$column->Type}\n";
        echo "   Null: {$column->Null}\n";
        echo "   Default: {$column->Default}\n\n";
        
        // Check if it's the correct ENUM type
        if (!str_contains($column->Type, 'active') || !str_contains($column->Type, 'maintenance')) {
            echo "⚠️  Status column has incorrect type. Fixing...\n";
            
            // Backup existing data
            $existingData = DB::table('facilities')->select('id', 'status')->get();
            echo "📦 Backed up " . count($existingData) . " records\n";
            
            // Drop and recreate status column
            try {
                Schema::table('facilities', function (Blueprint $table) {
                    $table->dropColumn('status');
                });
                
                Schema::table('facilities', function (Blueprint $table) {
                    $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
                });
                
                echo "✅ Recreated status column with correct ENUM type\n";
                
                // Restore data with validation
                foreach ($existingData as $record) {
                    $status = $record->status;
                    
                    // Validate and fix status values
                    if (!in_array($status, ['active', 'maintenance', 'inactive'])) {
                        $status = 'active'; // Default to active for invalid values
                        echo "⚠️  Fixed invalid status for record ID {$record->id}: '{$record->status}' → 'active'\n";
                    }
                    
                    DB::table('facilities')
                        ->where('id', $record->id)
                        ->update(['status' => $status]);
                }
                
                echo "✅ Restored and validated " . count($existingData) . " records\n";
                
            } catch (Exception $e) {
                echo "❌ Error fixing status column: " . $e->getMessage() . "\n";
                exit(1);
            }
        } else {
            echo "✅ Status column has correct ENUM type\n";
        }
    }
    
    // Validate all existing status values
    echo "\n🔍 Validating existing status values...\n";
    
    $invalidRecords = DB::table('facilities')
        ->whereNotIn('status', ['active', 'maintenance', 'inactive'])
        ->get();
    
    if (count($invalidRecords) > 0) {
        echo "⚠️  Found " . count($invalidRecords) . " records with invalid status values\n";
        
        foreach ($invalidRecords as $record) {
            echo "   - ID {$record->id}: '{$record->status}' → 'active'\n";
        }
        
        // Fix invalid status values
        DB::table('facilities')
            ->whereNotIn('status', ['active', 'maintenance', 'inactive'])
            ->update(['status' => 'active']);
            
        echo "✅ Fixed all invalid status values\n";
    } else {
        echo "✅ All status values are valid\n";
    }
    
    // Test facility creation
    echo "\n🧪 Testing facility creation with status...\n";
    
    try {
        $testData = [
            'name' => 'Test Facility Status - ' . date('Y-m-d H:i:s'),
            'description' => 'Test facility for status column verification',
            'category' => 'other',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ];
        
        $facilityId = DB::table('facilities')->insertGetId($testData);
        
        echo "✅ Test facility created successfully! ID: $facilityId\n";
        
        // Test status update
        DB::table('facilities')->where('id', $facilityId)->update(['status' => 'maintenance']);
        echo "✅ Status update test successful\n";
        
        DB::table('facilities')->where('id', $facilityId)->update(['status' => 'inactive']);
        echo "✅ Status update test successful\n";
        
        DB::table('facilities')->where('id', $facilityId)->update(['status' => 'active']);
        echo "✅ Status update test successful\n";
        
        // Clean up test facility
        DB::table('facilities')->where('id', $facilityId)->delete();
        echo "✅ Test facility cleaned up\n";
        
    } catch (Exception $e) {
        echo "❌ Test facility creation failed: " . $e->getMessage() . "\n";
        
        // Check if it's a data truncation error
        if (str_contains($e->getMessage(), 'Data truncated')) {
            echo "🔍 This appears to be a data truncation error.\n";
            echo "The status column might still have incorrect type or constraints.\n";
            
            // Show current column info again
            $columnInfo = DB::select("SHOW COLUMNS FROM facilities WHERE Field = 'status'");
            if (!empty($columnInfo)) {
                $column = $columnInfo[0];
                echo "Current status column: {$column->Type}\n";
            }
        }
    }
    
    // Final verification
    echo "\n🔍 Final verification...\n";
    
    $columnInfo = DB::select("SHOW COLUMNS FROM facilities WHERE Field = 'status'");
    if (!empty($columnInfo)) {
        $column = $columnInfo[0];
        echo "✅ Status column type: {$column->Type}\n";
        echo "✅ Status column default: {$column->Default}\n";
        
        if (str_contains($column->Type, 'active') && str_contains($column->Type, 'maintenance') && str_contains($column->Type, 'inactive')) {
            echo "✅ Status column is correctly configured!\n";
        } else {
            echo "⚠️  Status column may still have issues\n";
        }
    }
    
    echo "\n🎉 Status column fix completed!\n";
    echo "You can now add facilities without status truncation errors.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}