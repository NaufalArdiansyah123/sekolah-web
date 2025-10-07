<?php

/**
 * IMMEDIATE STATUS COLUMN FIX
 * This script will fix the status column issue right now
 */

echo "🚨 FIXING STATUS COLUMN IMMEDIATELY\n";
echo "===================================\n\n";

// Database configuration from .env
$host = '127.0.0.1';
$port = '3306';
$database = 'sekolah-web6';
$username = 'root';
$password = '';

try {
    // Step 1: Connect to database
    echo "1️⃣ Connecting to database...\n";
    $dsn = "mysql:host=$host;port=$port;dbname=$database";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to database successfully\n";

    // Step 2: Check current status column
    echo "\n2️⃣ Checking current status column...\n";
    $stmt = $pdo->query("SHOW COLUMNS FROM facilities WHERE Field = 'status'");
    $statusColumn = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($statusColumn) {
        echo "📋 Current status column: {$statusColumn['Type']}\n";
        echo "📋 Default value: {$statusColumn['Default']}\n";
    } else {
        echo "❌ Status column does not exist!\n";
    }

    // Step 3: Backup existing data
    echo "\n3️⃣ Backing up existing facilities...\n";
    $stmt = $pdo->query("SELECT id, name, status FROM facilities");
    $existingFacilities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "📦 Found " . count($existingFacilities) . " existing facilities\n";

    // Step 4: Fix the status column
    echo "\n4️⃣ Fixing status column...\n";
    
    // Drop existing status column if it exists
    if ($statusColumn) {
        $pdo->exec("ALTER TABLE facilities DROP COLUMN status");
        echo "🗑️ Dropped old status column\n";
    }
    
    // Add correct ENUM status column
    $pdo->exec("ALTER TABLE facilities ADD COLUMN status ENUM('active', 'maintenance', 'inactive') DEFAULT 'active' AFTER category");
    echo "✅ Added new status column with correct ENUM type\n";

    // Step 5: Restore data with valid status
    echo "\n5️⃣ Restoring facility data...\n";
    foreach ($existingFacilities as $facility) {
        $validStatus = 'active'; // Default all to active
        
        // If old status was valid, preserve it
        if (in_array(strtolower($facility['status'] ?? ''), ['active', 'maintenance', 'inactive'])) {
            $validStatus = strtolower($facility['status']);
        }
        
        $stmt = $pdo->prepare("UPDATE facilities SET status = ? WHERE id = ?");
        $stmt->execute([$validStatus, $facility['id']]);
        
        echo "✅ Restored: {$facility['name']} (status: $validStatus)\n";
    }

    // Step 6: Verify the fix
    echo "\n6️⃣ Verifying the fix...\n";
    
    // Check new column structure
    $stmt = $pdo->query("SHOW COLUMNS FROM facilities WHERE Field = 'status'");
    $newStatusColumn = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ New status column: {$newStatusColumn['Type']}\n";
    echo "✅ New default value: {$newStatusColumn['Default']}\n";

    // Test insert
    $testData = [
        'name' => 'TEST_STATUS_FIX_' . time(),
        'description' => 'Test facility for status column fix verification',
        'category' => 'other',
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $stmt = $pdo->prepare("INSERT INTO facilities (name, description, category, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(array_values($testData));
    $testId = $pdo->lastInsertId();
    
    echo "✅ Test insert successful! ID: $testId\n";

    // Test all status values
    $statusValues = ['active', 'maintenance', 'inactive'];
    foreach ($statusValues as $status) {
        $stmt = $pdo->prepare("UPDATE facilities SET status = ? WHERE id = ?");
        $stmt->execute([$status, $testId]);
        echo "✅ Status '$status' update successful\n";
    }

    // Clean up test data
    $pdo->exec("DELETE FROM facilities WHERE id = $testId");
    echo "🧹 Test data cleaned up\n";

    // Step 7: Show final status
    echo "\n7️⃣ Final verification...\n";
    $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM facilities GROUP BY status");
    $statusCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "📊 Facilities by status:\n";
    foreach ($statusCounts as $statusCount) {
        echo "   - {$statusCount['status']}: {$statusCount['count']} facilities\n";
    }

    echo "\n🎉 STATUS COLUMN FIX COMPLETED SUCCESSFULLY!\n";
    echo "✅ Status column now has correct ENUM type\n";
    echo "✅ All existing data preserved with valid status\n";
    echo "✅ All status values (active, maintenance, inactive) working\n";
    echo "✅ You can now create facilities without errors!\n";

} catch (PDOException $e) {
    echo "❌ DATABASE ERROR: " . $e->getMessage() . "\n";
    
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "\n🔧 SOLUTION: Check database credentials\n";
        echo "- Username: $username\n";
        echo "- Password: " . (empty($password) ? '(empty)' : '***') . "\n";
        echo "- Database: $database\n";
    } elseif (strpos($e->getMessage(), 'Connection refused') !== false) {
        echo "\n🔧 SOLUTION: Start XAMPP MySQL service\n";
        echo "1. Open XAMPP Control Panel\n";
        echo "2. Click 'Start' next to MySQL\n";
        echo "3. Wait for 'Running' status\n";
    } elseif (strpos($e->getMessage(), 'Unknown database') !== false) {
        echo "\n🔧 SOLUTION: Create database\n";
        echo "1. Open phpMyAdmin (http://localhost/phpmyadmin)\n";
        echo "2. Create database: $database\n";
        echo "3. Run this script again\n";
    }
    
    exit(1);
} catch (Exception $e) {
    echo "❌ GENERAL ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🚀 TRY CREATING A FACILITY NOW - IT WILL WORK!\n";
echo str_repeat("=", 50) . "\n";