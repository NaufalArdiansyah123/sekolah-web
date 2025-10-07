<?php

/**
 * XAMPP Status Checker
 * Quick script to check if XAMPP MySQL is running
 */

echo "🔍 CHECKING XAMPP MYSQL STATUS\n";
echo "==============================\n\n";

// Check if we can connect to MySQL on default XAMPP port
$hosts = ['127.0.0.1', 'localhost'];
$port = 3306;
$username = 'root';
$password = '';

$mysqlRunning = false;

foreach ($hosts as $host) {
    echo "Testing connection to $host:$port...\n";
    
    try {
        $dsn = "mysql:host=$host;port=$port";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "✅ MySQL is running on $host:$port\n";
        $mysqlRunning = true;
        
        // Get MySQL version
        $stmt = $pdo->query('SELECT VERSION() as version');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "📋 MySQL Version: " . $result['version'] . "\n";
        
        // Check if our database exists
        $database = 'sekolah-web6';
        $stmt = $pdo->query("SHOW DATABASES LIKE '$database'");
        $dbExists = $stmt->fetch();
        
        if ($dbExists) {
            echo "✅ Database '$database' exists\n";
        } else {
            echo "❌ Database '$database' does not exist\n";
            echo "💡 Create it with: CREATE DATABASE `$database`;\n";
        }
        
        break;
        
    } catch (PDOException $e) {
        echo "❌ Connection failed: " . $e->getMessage() . "\n";
    }
}

if (!$mysqlRunning) {
    echo "\n🚨 MYSQL IS NOT RUNNING!\n";
    echo "🔧 SOLUTIONS:\n";
    echo "1. Open XAMPP Control Panel\n";
    echo "2. Click 'Start' button next to MySQL\n";
    echo "3. Wait for status to show 'Running'\n";
    echo "4. Run this script again\n\n";
    
    echo "📍 XAMPP Control Panel locations:\n";
    echo "Windows: C:\\xampp\\xampp-control.exe\n";
    echo "Or search 'XAMPP Control Panel' in Start menu\n";
} else {
    echo "\n✅ MYSQL IS RUNNING CORRECTLY!\n";
    echo "🎯 Next steps:\n";
    echo "1. Run: php quick_db_fix.php\n";
    echo "2. Try creating a facility again\n";
}

echo "\n" . str_repeat("=", 40) . "\n";
echo "XAMPP STATUS CHECK COMPLETE\n";
echo str_repeat("=", 40) . "\n";