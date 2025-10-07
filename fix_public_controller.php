<?php

/**
 * Fix Public Facility Controller Issues
 * This script will fix the public controller loading issues
 */

echo "🔧 FIXING PUBLIC FACILITY CONTROLLER\n";
echo "====================================\n\n";

// Step 1: Clear all caches
echo "1️⃣ Clearing all Laravel caches...\n";

$cacheCommands = [
    'php artisan config:clear' => 'Configuration cache',
    'php artisan route:clear' => 'Route cache',
    'php artisan cache:clear' => 'Application cache',
    'php artisan view:clear' => 'View cache'
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

// Step 3: Check controller files
echo "\n3️⃣ Checking controller files...\n";

$controllers = [
    'app/Http/Controllers/Admin/FacilityController.php' => 'Admin Controller',
    'app/Http/Controllers/Public/FacilityController.php' => 'Public Controller'
];

foreach ($controllers as $path => $name) {
    if (file_exists($path)) {
        echo "✅ $name exists\n";
        
        $content = file_get_contents($path);
        
        // Check if it's a proper PHP controller
        if (strpos($content, '<?php') === 0 && strpos($content, 'class') !== false) {
            echo "✅ $name has correct PHP structure\n";
        } else {
            echo "❌ $name has incorrect structure\n";
        }
        
        // Check namespace
        if (strpos($content, 'namespace App\\Http\\Controllers') !== false) {
            echo "✅ $name has correct namespace\n";
        } else {
            echo "❌ $name has incorrect namespace\n";
        }
        
    } else {
        echo "❌ $name does not exist\n";
    }
}

// Step 4: Check model
echo "\n4️⃣ Checking Facility model...\n";
if (file_exists('app/Models/Facility.php')) {
    echo "✅ Facility model exists\n";
    
    $modelContent = file_get_contents('app/Models/Facility.php');
    if (strpos($modelContent, 'class Facility extends Model') !== false) {
        echo "✅ Model structure is correct\n";
    } else {
        echo "❌ Model structure is incorrect\n";
    }
} else {
    echo "❌ Facility model does not exist\n";
}

// Step 5: Test controller loading
echo "\n5️⃣ Testing controller loading...\n";

try {
    // Load Laravel
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        
        // Test Admin Controller
        if (class_exists('App\\Http\\Controllers\\Admin\\FacilityController')) {
            echo "✅ Admin FacilityController can be loaded\n";
        } else {
            echo "❌ Admin FacilityController cannot be loaded\n";
        }
        
        // Test Public Controller
        if (class_exists('App\\Http\\Controllers\\Public\\FacilityController')) {
            echo "✅ Public FacilityController can be loaded\n";
        } else {
            echo "❌ Public FacilityController cannot be loaded\n";
        }
        
        // Test Model
        if (class_exists('App\\Models\\Facility')) {
            echo "✅ Facility model can be loaded\n";
        } else {
            echo "❌ Facility model cannot be loaded\n";
        }
        
    } else {
        echo "❌ Composer autoloader not found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error testing controllers: " . $e->getMessage() . "\n";
}

// Step 6: Check routes
echo "\n6️⃣ Checking routes...\n";
$output = [];
$returnCode = 0;
exec('php artisan route:list --name=facilities 2>&1', $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ Routes command executed successfully\n";
    if (!empty($output)) {
        echo "📋 Facilities routes:\n";
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

// Step 7: Cache routes for optimization
echo "\n7️⃣ Caching routes for optimization...\n";
$output = [];
$returnCode = 0;
exec('php artisan route:cache 2>&1', $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ Routes cached successfully\n";
} else {
    echo "⚠️ Route caching warning: " . implode("\n", $output) . "\n";
}

echo "\n🎉 PUBLIC CONTROLLER FIX COMPLETED!\n";
echo "===================================\n";

echo "\n📋 SUMMARY:\n";
echo "- All caches cleared\n";
echo "- Autoloader regenerated\n";
echo "- Controller files checked\n";
echo "- Controller loading tested\n";
echo "- Routes verified\n";
echo "- Application optimized\n";

echo "\n🚀 NEXT STEPS:\n";
echo "1. Try accessing /facilities again\n";
echo "2. If still not working, restart web server\n";
echo "3. Check Laravel logs: storage/logs/laravel.log\n";

echo "\n💡 TEST URLS:\n";
echo "- Public Facilities: http://localhost:8000/facilities\n";
echo "- Admin Facilities: http://localhost:8000/admin/facilities\n";