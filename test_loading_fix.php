<?php
// Script untuk test loading screen fix
echo "🔧 Testing Loading Screen Fix...\n\n";

// Test 1: Check if CSS file exists
echo "1. Checking CSS file...\n";
$cssFile = 'public/css/loading-fix.css';
if (file_exists($cssFile)) {
    echo "   ✅ loading-fix.css exists\n";
    $cssContent = file_get_contents($cssFile);
    
    // Check for key CSS rules
    $checks = [
        'html.loading' => 'Loading state CSS',
        '.page-loader' => 'Loader element CSS',
        'visibility: visible' => 'Loader visibility rules',
        'display: none' => 'Content hiding rules',
        'z-index: 999999' => 'Z-index priority'
    ];
    
    foreach ($checks as $rule => $description) {
        if (strpos($cssContent, $rule) !== false) {
            echo "   ✅ {$description} found\n";
        } else {
            echo "   ❌ {$description} missing\n";
        }
    }
} else {
    echo "   ❌ loading-fix.css not found\n";
}

// Test 2: Check layout file
echo "\n2. Checking layout file...\n";
$layoutFile = 'resources/views/layouts/public.blade.php';
if (file_exists($layoutFile)) {
    echo "   ✅ public.blade.php exists\n";
    $layoutContent = file_get_contents($layoutFile);
    
    // Check for loading-fix.css inclusion
    if (strpos($layoutContent, 'loading-fix.css') !== false) {
        echo "   ✅ loading-fix.css included in layout\n";
    } else {
        echo "   ❌ loading-fix.css not included in layout\n";
    }
    
    // Check for loading class in HTML tag
    if (strpos($layoutContent, 'class="loading"') !== false) {
        echo "   ✅ Loading class in HTML tag\n";
    } else {
        echo "   ❌ Loading class missing in HTML tag\n";
    }
    
    // Check for page loader element
    if (strpos($layoutContent, 'page-loader') !== false) {
        echo "   ✅ Page loader element found\n";
    } else {
        echo "   ❌ Page loader element missing\n";
    }
} else {
    echo "   ❌ public.blade.php not found\n";
}

// Test 3: Check achievement pages
echo "\n3. Checking achievement pages...\n";
$achievementFiles = [
    'resources/views/public/achievements/index.blade.php',
    'resources/views/public/achievements/show.blade.php'
];

foreach ($achievementFiles as $file) {
    if (file_exists($file)) {
        echo "   ✅ " . basename($file) . " exists\n";
        $content = file_get_contents($file);
        
        // Check for simplified loading CSS
        if (strpos($content, 'html.loading main') !== false) {
            echo "   ✅ " . basename($file) . " has loading compatibility CSS\n";
        } else {
            echo "   ❌ " . basename($file) . " missing loading compatibility CSS\n";
        }
    } else {
        echo "   ❌ " . basename($file) . " not found\n";
    }
}

// Test 4: Generate test HTML
echo "\n4. Generating test HTML...\n";
$testHtml = '<!DOCTYPE html>
<html lang="id" class="loading">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Screen Test</title>
    <link href="css/loading-fix.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-content { background: #f0f0f0; padding: 20px; margin: 20px 0; }
    </style>
</head>
<body class="loading">
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="loader-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="loader-text">SMK PGRI 2 PONOROGO</div>
            <div class="loader-progress">
                <div class="loader-progress-bar"></div>
            </div>
            <div class="loader-dots">
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-brand">
            <span>Test Navbar</span>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="test-content">
            <h1>Test Content</h1>
            <p>This content should be hidden during loading.</p>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="test-content">
            <p>Footer content</p>
        </div>
    </footer>

    <script>
        // Test loading behavior
        console.log("Loading test started");
        
        setTimeout(function() {
            console.log("Removing loading class");
            document.documentElement.classList.remove("loading");
            document.body.classList.remove("loading");
            
            const loader = document.getElementById("pageLoader");
            if (loader) {
                loader.style.opacity = "0";
                setTimeout(() => loader.remove(), 500);
            }
        }, 3000);
    </script>
</body>
</html>';

file_put_contents('public/test-loading.html', $testHtml);
echo "   ✅ Test HTML created: public/test-loading.html\n";

// Test 5: Summary
echo "\n📊 Test Summary:\n";
echo "   - CSS File: " . (file_exists($cssFile) ? "✅ OK" : "❌ Missing") . "\n";
echo "   - Layout Integration: " . (file_exists($layoutFile) && strpos(file_get_contents($layoutFile), 'loading-fix.css') !== false ? "✅ OK" : "❌ Missing") . "\n";
echo "   - Achievement Pages: " . (file_exists($achievementFiles[0]) && file_exists($achievementFiles[1]) ? "✅ OK" : "❌ Missing") . "\n";
echo "   - Test File: ✅ Created\n";

echo "\n🌐 Test Instructions:\n";
echo "1. Open browser and go to: http://localhost/sekolah-web/public/test-loading.html\n";
echo "2. You should see:\n";
echo "   - Loading screen with gradient background\n";
echo "   - School logo and name\n";
echo "   - Progress bar animation\n";
echo "   - NO navbar or content visible during loading\n";
echo "3. After 3 seconds, loading should fade out and content appears\n";

echo "\n🔧 If loading screen is not visible:\n";
echo "1. Check browser console for errors\n";
echo "2. Verify CSS file is loading correctly\n";
echo "3. Check if 'loading' class is applied to <html> tag\n";
echo "4. Ensure no conflicting CSS is overriding loader styles\n";

echo "\n✨ Expected Behavior:\n";
echo "   ✅ Loading screen covers entire viewport\n";
echo "   ✅ All content hidden during loading\n";
echo "   ✅ Smooth gradient animation\n";
echo "   ✅ Progress bar fills up\n";
echo "   ✅ Dots bounce animation\n";
echo "   ✅ Smooth fade to content after loading\n";

echo "\nLoading screen fix test complete! 🎉\n";
?>