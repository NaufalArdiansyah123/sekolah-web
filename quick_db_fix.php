<?php
echo "🔧 QUICK DATABASE FIX\n";
echo "====================\n\n";

// Clear Laravel caches
echo "1️⃣ Clearing caches...\n";
exec('php artisan config:clear 2>&1');
exec('php artisan cache:clear 2>&1');
echo "✅ Caches cleared\n";

// Test database connection
echo "\n2️⃣ Testing database...\n";
$host = '127.0.0.1';
$port = '3306';
$database = 'sekolah-web6';
$username = 'root';
$password = '';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database";
    $pdo = new PDO($dsn, $username, $password);
    echo "✅ Database connection successful\n";
    
    // Check facilities table
    $stmt = $pdo->query("SHOW TABLES LIKE 'facilities'");
    if ($stmt->fetch()) {
        echo "✅ Facilities table exists\n";
        
        // Check status column
        $stmt = $pdo->query("DESCRIBE facilities");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $statusExists = false;
        foreach ($columns as $column) {
            if ($column['Field'] === 'status') {
                $statusExists = true;
                echo "✅ Status column: " . $column['Type'] . "\n";
                break;
            }
        }
        
        if (!$statusExists) {
            echo "❌ Status column missing, adding...\n";
            $pdo->exec("ALTER TABLE facilities ADD COLUMN status ENUM('active', 'maintenance', 'inactive') DEFAULT 'active'");
            echo "✅ Status column added\n";
        }
    } else {
        echo "❌ Facilities table missing\n";
        echo "💡 Run: php artisan migrate\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    echo "💡 Make sure XAMPP MySQL is running\n";
}

echo "\n🎉 Quick fix completed!\n";