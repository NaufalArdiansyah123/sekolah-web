<?php

/**
 * URGENT FIX: Facilities Status Column Data Truncation
 * This script will immediately fix the status column issue
 */

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🚨 URGENT FIX: Facilities Status Column\n";
echo "=====================================\n\n";

try {
    // Step 1: Check current database structure
    echo "1️⃣ Checking current status column structure...\n";
    
    $columnInfo = DB::select("SHOW COLUMNS FROM facilities WHERE Field = 'status'");
    
    if (empty($columnInfo)) {
        echo "❌ Status column does not exist!\n";
        echo "Adding status column...\n";
        
        DB::statement("ALTER TABLE facilities ADD COLUMN status ENUM('active', 'maintenance', 'inactive') DEFAULT 'active'");
        echo "✅ Status column added successfully!\n";
    } else {
        $column = $columnInfo[0];
        echo "📋 Current status column: {$column->Type}\n";
        
        // Check if it's the problematic type
        if (!str_contains(strtolower($column->Type), 'enum') || 
            !str_contains(strtolower($column->Type), 'active')) {
            
            echo "⚠️  Status column has incorrect type! Fixing now...\n\n";
            
            // Step 2: Backup existing data
            echo "2️⃣ Backing up existing data...\n";
            $existingFacilities = DB::select("SELECT id, name, status FROM facilities");
            echo "📦 Found " . count($existingFacilities) . " existing facilities\n";
            
            // Step 3: Fix the column
            echo "\n3️⃣ Fixing status column...\n";
            
            // Drop the problematic column
            DB::statement("ALTER TABLE facilities DROP COLUMN status");
            echo "🗑️ Dropped old status column\n";
            
            // Add correct ENUM column
            DB::statement("ALTER TABLE facilities ADD COLUMN status ENUM('active', 'maintenance', 'inactive') DEFAULT 'active'");
            echo "✅ Added new status column with correct ENUM type\n";
            
            // Step 4: Restore data with validation
            echo "\n4️⃣ Restoring data with validation...\n";
            foreach ($existingFacilities as $facility) {
                $status = 'active'; // Default to active for all existing facilities
                
                // If the old status was valid, keep it
                if (in_array(strtolower($facility->status ?? ''), ['active', 'maintenance', 'inactive'])) {
                    $status = strtolower($facility->status);
                }
                
                DB::table('facilities')
                    ->where('id', $facility->id)
                    ->update(['status' => $status]);
                    
                echo "✅ Restored facility: {$facility->name} (status: {$status})\n";
            }
            
        } else {
            echo "✅ Status column appears to be correct\n";
        }
    }
    
    // Step 5: Test the fix
    echo "\n5️⃣ Testing the fix...\n";
    
    $testData = [
        'name' => 'TEST_FACILITY_' . time(),
        'description' => 'Test facility for status column fix',
        'category' => 'other',
        'status' => 'active',
        'created_at' => now(),
        'updated_at' => now()
    ];
    
    try {
        $testId = DB::table('facilities')->insertGetId($testData);
        echo "✅ Test insert successful! ID: {$testId}\n";
        
        // Test all status values
        DB::table('facilities')->where('id', $testId)->update(['status' => 'maintenance']);
        echo "✅ Status update to 'maintenance' successful\n";
        
        DB::table('facilities')->where('id', $testId)->update(['status' => 'inactive']);
        echo "✅ Status update to 'inactive' successful\n";
        
        DB::table('facilities')->where('id', $testId)->update(['status' => 'active']);
        echo "✅ Status update to 'active' successful\n";
        
        // Clean up test data
        DB::table('facilities')->where('id', $testId)->delete();
        echo "🧹 Test data cleaned up\n";
        
    } catch (Exception $e) {
        echo "❌ Test failed: " . $e->getMessage() . "\n";
        throw $e;
    }
    
    // Step 6: Final verification
    echo "\n6️⃣ Final verification...\n";
    
    $finalColumnInfo = DB::select("SHOW COLUMNS FROM facilities WHERE Field = 'status'");
    if (!empty($finalColumnInfo)) {
        $finalColumn = $finalColumnInfo[0];
        echo "✅ Final status column type: {$finalColumn->Type}\n";
        echo "✅ Final status column default: {$finalColumn->Default}\n";
    }
    
    // Count facilities by status
    $statusCounts = DB::select("
        SELECT status, COUNT(*) as count 
        FROM facilities 
        GROUP BY status
    ");
    
    echo "\n📊 Current facilities by status:\n";
    foreach ($statusCounts as $statusCount) {
        echo "   - {$statusCount->status}: {$statusCount->count} facilities\n";
    }
    
    echo "\n🎉 SUCCESS! Status column has been fixed!\n";
    echo "✅ You can now add facilities without any errors.\n";
    echo "✅ All status values (active, maintenance, inactive) are working.\n";
    echo "✅ The data truncation error should be resolved.\n\n";
    
    echo "🚀 Try adding a facility now - it should work perfectly!\n";
    
} catch (Exception $e) {
    echo "\n❌ CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo "📍 Error occurred at: " . $e->getFile() . ":" . $e->getLine() . "\n";
    
    // Try to show current table structure for debugging
    try {
        echo "\n🔍 Current table structure:\n";
        $tableInfo = DB::select("DESCRIBE facilities");
        foreach ($tableInfo as $column) {
            echo "   {$column->Field}: {$column->Type} (Default: {$column->Default})\n";
        }
    } catch (Exception $debugE) {
        echo "Could not retrieve table structure: " . $debugE->getMessage() . "\n";
    }
    
    exit(1);
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "✅ FACILITIES STATUS COLUMN FIX COMPLETED!\n";
echo str_repeat("=", 50) . "\n";