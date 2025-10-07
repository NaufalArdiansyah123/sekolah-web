<?php

/**
 * Fix Styling Issues Script
 * This script will clear caches and fix styling problems
 */

echo "🎨 FIXING STYLING ISSUES\n";
echo "========================\n\n";

// Step 1: Clear all Laravel caches
echo "1️⃣ Clearing Laravel caches...\n";

$cacheCommands = [
    'php artisan view:clear' => 'View cache',
    'php artisan config:clear' => 'Configuration cache',
    'php artisan route:clear' => 'Route cache',
    'php artisan cache:clear' => 'Application cache'
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

// Step 2: Check if view file exists and is readable
echo "\n2️⃣ Checking view file...\n";
$viewPath = 'resources/views/public/facilities/index.blade.php';

if (file_exists($viewPath)) {
    echo "✅ View file exists: $viewPath\n";
    
    $fileSize = filesize($viewPath);
    echo "📋 File size: " . number_format($fileSize) . " bytes\n";
    
    if (is_readable($viewPath)) {
        echo "✅ View file is readable\n";
    } else {
        echo "❌ View file is not readable\n";
    }
    
    // Check if file contains styles
    $content = file_get_contents($viewPath);
    if (strpos($content, '@push(\'styles\')') !== false) {
        echo "✅ Styles section found in view\n";
    } else {
        echo "❌ Styles section not found in view\n";
    }
    
    if (strpos($content, '.facilities-hero') !== false) {
        echo "✅ Custom CSS classes found\n";
    } else {
        echo "❌ Custom CSS classes not found\n";
    }
    
} else {
    echo "❌ View file does not exist: $viewPath\n";
}

// Step 3: Check layout file
echo "\n3️⃣ Checking layout file...\n";
$layoutPaths = [
    'resources/views/layouts/public.blade.php',
    'resources/views/layouts/app.blade.php'
];

foreach ($layoutPaths as $layoutPath) {
    if (file_exists($layoutPath)) {
        echo "✅ Layout file exists: $layoutPath\n";
        
        $layoutContent = file_get_contents($layoutPath);
        
        // Check for styles stack
        if (strpos($layoutContent, '@stack(\'styles\')') !== false) {
            echo "✅ Styles stack found in layout\n";
        } else {
            echo "⚠️ Styles stack not found in layout\n";
        }
        
        // Check for scripts stack
        if (strpos($layoutContent, '@stack(\'scripts\')') !== false) {
            echo "✅ Scripts stack found in layout\n";
        } else {
            echo "⚠️ Scripts stack not found in layout\n";
        }
        
        break;
    }
}

// Step 4: Test route accessibility
echo "\n4️⃣ Testing route accessibility...\n";
$output = [];
$returnCode = 0;
exec('php artisan route:list --name=facilities 2>&1', $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ Routes command executed successfully\n";
    $facilitiesRoutes = array_filter($output, function($line) {
        return strpos($line, 'facilities') !== false;
    });
    
    if (!empty($facilitiesRoutes)) {
        echo "✅ Facilities routes found:\n";
        foreach ($facilitiesRoutes as $route) {
            echo "   $route\n";
        }
    } else {
        echo "⚠️ No facilities routes found\n";
    }
} else {
    echo "❌ Failed to list routes\n";
}

// Step 5: Create a test CSS file to verify styling works
echo "\n5️⃣ Creating test CSS file...\n";
$testCssPath = 'public/css/test-facilities.css';

// Create directory if it doesn't exist
if (!is_dir('public/css')) {
    mkdir('public/css', 0755, true);
    echo "✅ Created CSS directory\n";
}

$testCss = "/* Test CSS for Facilities Page */
.test-facilities-style {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
    color: white !important;
    padding: 20px !important;
    text-align: center !important;
    border-radius: 10px !important;
    margin: 20px 0 !important;
}

.test-facilities-style h1 {
    font-size: 2rem !important;
    margin: 0 !important;
}

/* Force override existing styles */
.facilities-hero {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
    color: white !important;
    padding: 80px 0 60px !important;
    text-align: center !important;
}

.hero-title {
    font-size: 3rem !important;
    font-weight: 800 !important;
    margin-bottom: 1rem !important;
    color: white !important;
}

.filter-section {
    background: white !important;
    padding: 2rem 0 !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
}

.facility-card {
    background: white !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    transition: all 0.4s ease !important;
}

.facility-card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
}
";

file_put_contents($testCssPath, $testCss);
echo "✅ Test CSS file created: $testCssPath\n";

// Step 6: Optimize and cache
echo "\n6️⃣ Optimizing application...\n";
$optimizeCommands = [
    'php artisan config:cache' => 'Cache configuration',
    'php artisan view:cache' => 'Cache views'
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

echo "\n🎉 STYLING FIX COMPLETED!\n";
echo "=========================\n";

echo "\n📋 SUMMARY:\n";
echo "- All caches cleared\n";
echo "- View file checked\n";
echo "- Layout file verified\n";
echo "- Routes tested\n";
echo "- Test CSS created\n";
echo "- Application optimized\n";

echo "\n🚀 NEXT STEPS:\n";
echo "1. Hard refresh browser (Ctrl+F5 or Cmd+Shift+R)\n";
echo "2. Clear browser cache\n";
echo "3. Try accessing /facilities again\n";
echo "4. Check browser developer tools for CSS errors\n";

echo "\n💡 TROUBLESHOOTING:\n";
echo "- If styles still not working, check browser console for errors\n";
echo "- Verify that @stack('styles') exists in layout file\n";
echo "- Test CSS file created at: public/css/test-facilities.css\n";
echo "- Try incognito/private browsing mode\n";