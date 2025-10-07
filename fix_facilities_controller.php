<?php

/**
 * Fix Facilities Controller Issues
 * This script will check and fix controller-related issues
 */

echo "🔧 FIXING FACILITIES CONTROLLER ISSUES\n";
echo "======================================\n\n";

// Step 1: Check if controller file exists
echo "1️⃣ Checking controller file...\n";
$controllerPath = 'app/Http/Controllers/Admin/FacilityController.php';

if (file_exists($controllerPath)) {
    echo "✅ Controller file exists: $controllerPath\n";
    
    // Check file size
    $fileSize = filesize($controllerPath);
    echo "📋 File size: " . number_format($fileSize) . " bytes\n";
    
    // Check if file is readable
    if (is_readable($controllerPath)) {
        echo "✅ Controller file is readable\n";
    } else {
        echo "❌ Controller file is not readable\n";
        echo "💡 Fix: chmod 644 $controllerPath\n";
    }
} else {
    echo "❌ Controller file does not exist: $controllerPath\n";
    echo "💡 The controller needs to be created\n";
}

// Step 2: Check namespace and class structure
echo "\n2️⃣ Checking controller content...\n";
if (file_exists($controllerPath)) {
    $content = file_get_contents($controllerPath);
    
    // Check namespace
    if (strpos($content, 'namespace App\\Http\\Controllers\\Admin;') !== false) {
        echo "✅ Correct namespace found\n";
    } else {
        echo "❌ Incorrect or missing namespace\n";
    }
    
    // Check class declaration
    if (strpos($content, 'class FacilityController extends Controller') !== false) {
        echo "✅ Correct class declaration found\n";
    } else {
        echo "❌ Incorrect or missing class declaration\n";
    }
    
    // Check if it's a routes file (common mistake)
    if (strpos($content, 'Route::') !== false) {
        echo "❌ Controller file contains routes - this is wrong!\n";
        echo "💡 The controller file was overwritten with routes content\n";
        echo "🔧 Need to recreate the controller\n";
    }
}

// Step 3: Check if model exists
echo "\n3️⃣ Checking Facility model...\n";
$modelPath = 'app/Models/Facility.php';

if (file_exists($modelPath)) {
    echo "✅ Facility model exists\n";
    
    $modelContent = file_get_contents($modelPath);
    if (strpos($modelContent, 'class Facility extends Model') !== false) {
        echo "✅ Model class structure is correct\n";
    } else {
        echo "❌ Model class structure is incorrect\n";
    }
} else {
    echo "❌ Facility model does not exist\n";
}

// Step 4: Check routes
echo "\n4️⃣ Checking routes...\n";
$routesPath = 'routes/web.php';

if (file_exists($routesPath)) {
    $routesContent = file_get_contents($routesPath);
    
    if (strpos($routesContent, 'FacilityController') !== false) {
        echo "✅ Facility routes found in web.php\n";
    } else {
        echo "❌ Facility routes not found in web.php\n";
    }
    
    // Check for correct controller reference
    if (strpos($routesContent, 'App\\Http\\Controllers\\Admin\\FacilityController') !== false) {
        echo "✅ Correct controller reference in routes\n";
    } else {
        echo "⚠️ Controller reference might be incorrect in routes\n";
    }
}

// Step 5: Check autoloader
echo "\n5️⃣ Checking autoloader...\n";
if (file_exists('vendor/autoload.php')) {
    echo "✅ Composer autoloader exists\n";
    
    // Check if we can load the class
    try {
        require_once 'vendor/autoload.php';
        
        if (class_exists('App\\Http\\Controllers\\Admin\\FacilityController')) {
            echo "✅ FacilityController class can be loaded\n";
        } else {
            echo "❌ FacilityController class cannot be loaded\n";
            echo "💡 Try: composer dump-autoload\n";
        }
    } catch (Exception $e) {
        echo "❌ Error loading class: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ Composer autoloader not found\n";
    echo "💡 Run: composer install\n";
}

// Step 6: Provide solutions
echo "\n6️⃣ SOLUTIONS:\n";
echo "=============\n";

if (!file_exists($controllerPath) || strpos(file_get_contents($controllerPath), 'Route::') !== false) {
    echo "🔧 SOLUTION 1: Recreate the controller\n";
    echo "   The controller file is missing or corrupted\n";
    echo "   Run: php artisan make:controller Admin/FacilityController --resource\n";
    echo "   Then copy the correct controller code\n\n";
}

echo "🔧 SOLUTION 2: Clear caches\n";
echo "   php artisan config:clear\n";
echo "   php artisan route:clear\n";
echo "   php artisan cache:clear\n";
echo "   composer dump-autoload\n\n";

echo "🔧 SOLUTION 3: Check file permissions\n";
echo "   chmod 644 app/Http/Controllers/Admin/FacilityController.php\n";
echo "   chmod -R 755 app/Http/Controllers/\n\n";

echo "🔧 SOLUTION 4: Verify routes\n";
echo "   Make sure routes in web.php reference the correct controller\n";
echo "   Use: App\\Http\\Controllers\\Admin\\FacilityController::class\n\n";

// Step 7: Quick fix commands
echo "7️⃣ QUICK FIX COMMANDS:\n";
echo "======================\n";
echo "# Clear all caches\n";
echo "php artisan config:clear && php artisan route:clear && php artisan cache:clear\n\n";
echo "# Dump autoloader\n";
echo "composer dump-autoload\n\n";
echo "# Check if controller exists after fix\n";
echo "php artisan route:list | grep facilities\n\n";

echo "✅ DIAGNOSIS COMPLETE!\n";
echo "Run the suggested solutions to fix the controller issue.\n";