<?php

/**
 * Fix Controller Loading Issues
 * This script will fix autoloading and cache issues
 */

echo "🔧 FIXING CONTROLLER LOADING ISSUES\n";
echo "===================================\n\n";

// Step 1: Clear all Laravel caches
echo "1️⃣ Clearing Laravel caches...\n";

$cacheCommands = [
    'php artisan config:clear' => 'Configuration cache',
    'php artisan route:clear' => 'Route cache',
    'php artisan cache:clear' => 'Application cache',
    'php artisan view:clear' => 'View cache',
    'php artisan event:clear' => 'Event cache'
];

foreach ($cacheCommands as $command => $description) {
    echo "   Clearing $description...\n";
    $output = [];
    $returnCode = 0;
    exec($command . ' 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "   ✅ Success\n";
    } else {
        echo "   ⚠️ Warning: " . implode("\n", $output) . "\n";
    }
}

// Step 2: Regenerate autoloader
echo "\n2️⃣ Regenerating autoloader...\n";
$output = [];
$returnCode = 0;
exec('composer dump-autoload 2>&1', $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ Autoloader regenerated successfully\n";
} else {
    echo "❌ Failed to regenerate autoloader: " . implode("\n", $output) . "\n";
}

// Step 3: Check if controller can be loaded
echo "\n3️⃣ Testing controller loading...\n";

try {
    // Try to load Laravel
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        
        // Try to load the application
        if (file_exists('bootstrap/app.php')) {
            $app = require_once 'bootstrap/app.php';
            
            // Check if controller class exists
            if (class_exists('App\\Http\\Controllers\\Admin\\FacilityController')) {
                echo "✅ FacilityController class can be loaded\n";
                
                // Try to instantiate the controller
                $controller = new App\Http\Controllers\Admin\FacilityController();
                echo "✅ FacilityController can be instantiated\n";
                
                // Check if methods exist
                $methods = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];
                foreach ($methods as $method) {
                    if (method_exists($controller, $method)) {
                        echo "✅ Method $method exists\n";
                    } else {
                        echo "❌ Method $method missing\n";
                    }
                }
                
            } else {
                echo "❌ FacilityController class cannot be loaded\n";
            }
        } else {
            echo "❌ Laravel bootstrap file not found\n";
        }
    } else {
        echo "❌ Composer autoloader not found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error testing controller: " . $e->getMessage() . "\n";
}

// Step 4: Check routes
echo "\n4️⃣ Checking routes...\n";
$output = [];
$returnCode = 0;
exec('php artisan route:list --name=facilities 2>&1', $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ Routes command executed successfully\n";
    if (!empty($output)) {
        echo "📋 Facilities routes found:\n";
        foreach ($output as $line) {
            if (strpos($line, 'facilities') !== false) {
                echo "   $line\n";
            }
        }
    } else {
        echo "⚠️ No facilities routes found\n";
    }
} else {
    echo "❌ Failed to list routes: " . implode("\n", $output) . "\n";
}

// Step 5: Check file permissions
echo "\n5️⃣ Checking file permissions...\n";

$files = [
    'app/Http/Controllers/Admin/FacilityController.php',
    'app/Models/Facility.php',
    'routes/web.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = fileperms($file);
        $readable = is_readable($file) ? 'readable' : 'not readable';
        echo "✅ $file: $readable\n";
    } else {
        echo "❌ $file: not found\n";
    }
}

// Step 6: Optimize application
echo "\n6️⃣ Optimizing application...\n";

$optimizeCommands = [
    'php artisan config:cache' => 'Cache configuration',
    'php artisan route:cache' => 'Cache routes'
];

foreach ($optimizeCommands as $command => $description) {
    echo "   $description...\n";
    $output = [];
    $returnCode = 0;
    exec($command . ' 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "   ✅ Success\n";
    } else {
        echo "   ⚠️ Warning: " . implode("\n", $output) . "\n";
    }
}

echo "\n🎉 CONTROLLER LOADING FIX COMPLETED!\n";
echo "====================================\n";

echo "\n📋 SUMMARY:\n";
echo "- All caches cleared\n";
echo "- Autoloader regenerated\n";
echo "- Controller loading tested\n";
echo "- Routes checked\n";
echo "- Application optimized\n";

echo "\n🚀 NEXT STEPS:\n";
echo "1. Try accessing the facilities page again\n";
echo "2. If still not working, restart your web server\n";
echo "3. Check Laravel logs: storage/logs/laravel.log\n";

echo "\n💡 QUICK TEST:\n";
echo "Visit: /admin/facilities\n";
echo "If it works, the controller loading is fixed!\n";