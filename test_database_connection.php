<?php

/**
 * Database Connection Test & Fix Script
 * This script will test database connection and fix common issues
 */

echo "🔍 TESTING DATABASE CONNECTION\n";
echo "==============================\n\n";

// Test 1: Check if .env file exists and is readable
echo "1️⃣ Checking .env file...\n";
if (!file_exists('.env')) {
    echo "❌ .env file not found!\n";
    echo "💡 Solution: Copy .env.example to .env\n";
    exit(1);
}

if (!is_readable('.env')) {
    echo "❌ .env file is not readable!\n";
    echo "💡 Solution: Check file permissions\n";
    exit(1);
}

echo "✅ .env file exists and is readable\n";

// Test 2: Parse .env file manually
echo "\n2️⃣ Reading database configuration...\n";
$envContent = file_get_contents('.env');
$envLines = explode("\n", $envContent);
$dbConfig = [];

foreach ($envLines as $line) {
    if (strpos($line, 'DB_') === 0) {
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]);
            $dbConfig[$key] = $value;
        }
    }
}

echo "📋 Database Configuration:\n";
foreach ($dbConfig as $key => $value) {
    if ($key === 'DB_PASSWORD') {
        echo "   $key: " . (empty($value) ? '(empty)' : '***hidden***') . "\n";
    } else {
        echo "   $key: $value\n";
    }
}

// Test 3: Test MySQL connection directly
echo "\n3️⃣ Testing MySQL connection...\n";

$host = $dbConfig['DB_HOST'] ?? '127.0.0.1';
$port = $dbConfig['DB_PORT'] ?? '3306';
$database = $dbConfig['DB_DATABASE'] ?? '';
$username = $dbConfig['DB_USERNAME'] ?? 'root';
$password = $dbConfig['DB_PASSWORD'] ?? '';

try {
    $dsn = "mysql:host=$host;port=$port";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ MySQL server connection successful\n";
    
    // Test 4: Check if database exists
    echo "\n4️⃣ Checking if database exists...\n";
    $stmt = $pdo->query("SHOW DATABASES LIKE '$database'");
    $dbExists = $stmt->fetch();
    
    if ($dbExists) {
        echo "✅ Database '$database' exists\n";
        
        // Connect to specific database
        $dsn = "mysql:host=$host;port=$port;dbname=$database";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "✅ Connected to database '$database'\n";
        
        // Test 5: Check if facilities table exists
        echo "\n5️⃣ Checking facilities table...\n";
        $stmt = $pdo->query("SHOW TABLES LIKE 'facilities'");
        $tableExists = $stmt->fetch();
        
        if ($tableExists) {
            echo "✅ Facilities table exists\n";
            
            // Test 6: Check table structure
            echo "\n6️⃣ Checking table structure...\n";
            $stmt = $pdo->query("DESCRIBE facilities");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "📋 Facilities table columns:\n";
            $statusColumnExists = false;
            foreach ($columns as $column) {
                echo "   - {$column['Field']}: {$column['Type']} (Default: {$column['Default']})\n";
                if ($column['Field'] === 'status') {
                    $statusColumnExists = true;
                    $statusColumnType = $column['Type'];
                }
            }
            
            if ($statusColumnExists) {
                echo "\n7️⃣ Checking status column...\n";
                echo "✅ Status column exists: $statusColumnType\n";
                
                // Check if status column has correct ENUM values
                if (strpos(strtolower($statusColumnType), 'enum') !== false) {
                    if (strpos(strtolower($statusColumnType), 'active') !== false) {
                        echo "✅ Status column has 'active' value\n";
                    } else {
                        echo "❌ Status column missing 'active' value\n";
                        echo "🔧 Need to fix status column ENUM values\n";
                    }
                } else {
                    echo "❌ Status column is not ENUM type: $statusColumnType\n";
                    echo "🔧 Need to convert status column to ENUM\n";
                }
            } else {
                echo "❌ Status column does not exist\n";
                echo "🔧 Need to add status column\n";
            }
            
        } else {
            echo "❌ Facilities table does not exist\n";
            echo "🔧 Need to run migrations\n";
        }
        
    } else {
        echo "❌ Database '$database' does not exist\n";
        echo "🔧 Creating database...\n";
        
        try {
            $pdo->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "✅ Database '$database' created successfully\n";
            echo "💡 Now run: php artisan migrate\n";
        } catch (PDOException $e) {
            echo "❌ Failed to create database: " . $e->getMessage() . "\n";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ MySQL connection failed: " . $e->getMessage() . "\n";
    
    // Common solutions
    echo "\n🔧 COMMON SOLUTIONS:\n";
    echo "1. Make sure XAMPP/MySQL is running\n";
    echo "2. Check if MySQL service is started\n";
    echo "3. Verify database credentials in .env\n";
    echo "4. Check if port 3306 is available\n";
    echo "5. Try connecting with different host (localhost instead of 127.0.0.1)\n";
    
    exit(1);
}

// Test 8: Test Laravel database connection
echo "\n8️⃣ Testing Laravel database connection...\n";

try {
    // Load Laravel application
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Test Laravel DB connection
    $connection = \Illuminate\Support\Facades\DB::connection();
    $pdo = $connection->getPdo();
    
    if ($pdo) {
        echo "✅ Laravel database connection successful\n";
        
        // Test query
        $result = \Illuminate\Support\Facades\DB::select('SELECT 1 as test');
        if ($result) {
            echo "✅ Laravel database query test successful\n";
        }
        
        // Test facilities table through Laravel
        try {
            $facilitiesCount = \Illuminate\Support\Facades\DB::table('facilities')->count();
            echo "✅ Facilities table accessible through Laravel (count: $facilitiesCount)\n";
        } catch (Exception $e) {
            echo "❌ Cannot access facilities table through Laravel: " . $e->getMessage() . "\n";
        }
        
    } else {
        echo "❌ Laravel database connection failed\n";
    }
    
} catch (Exception $e) {
    echo "❌ Laravel application error: " . $e->getMessage() . "\n";
    echo "💡 Try: php artisan config:clear\n";
    echo "💡 Try: php artisan cache:clear\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🎯 DIAGNOSIS COMPLETE\n";
echo str_repeat("=", 50) . "\n";

echo "\n📋 NEXT STEPS:\n";
echo "1. If MySQL connection failed: Start XAMPP/MySQL service\n";
echo "2. If database doesn't exist: Run the script again (it will create it)\n";
echo "3. If facilities table doesn't exist: Run 'php artisan migrate'\n";
echo "4. If status column is wrong: Run 'php fix_status_column_now.php'\n";
echo "5. If Laravel connection failed: Run 'php artisan config:clear'\n";

echo "\n🚀 Quick fix commands:\n";
echo "php artisan config:clear\n";
echo "php artisan cache:clear\n";
echo "php artisan migrate\n";
echo "php fix_status_column_now.php\n";