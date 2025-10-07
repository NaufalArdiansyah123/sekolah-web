<?php

/**
 * Force Styling Active Script
 * This script will ensure styling is properly loaded
 */

echo "🎨 FORCING STYLING TO BE ACTIVE\n";
echo "===============================\n\n";

// Step 1: Clear all caches
echo "1️⃣ Clearing all caches...\n";
exec('php artisan view:clear 2>&1', $output1);
exec('php artisan config:clear 2>&1', $output2);
exec('php artisan route:clear 2>&1', $output3);
exec('php artisan cache:clear 2>&1', $output4);
echo "✅ All caches cleared\n";

// Step 2: Check CSS file
echo "\n2️⃣ Checking CSS file...\n";
$cssPath = 'public/css/facilities-public.css';
if (file_exists($cssPath)) {
    echo "✅ CSS file exists: $cssPath\n";
    echo "📋 File size: " . number_format(filesize($cssPath)) . " bytes\n";
} else {
    echo "❌ CSS file missing: $cssPath\n";
}

// Step 3: Create test HTML file
echo "\n3️⃣ Creating test HTML file...\n";
$testHtml = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facilities Styling Test</title>
    <link rel="stylesheet" href="css/facilities-public.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { margin: 0; padding: 20px; font-family: Arial, sans-serif; }
        .test-container { max-width: 1200px; margin: 0 auto; }
        .test-notice { background: #e3f2fd; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="test-notice">
            <h2>🎨 Facilities Styling Test Page</h2>
            <p>This page tests if the facilities styling is working correctly.</p>
            <p><strong>URL:</strong> <a href="/facilities">/facilities</a></p>
        </div>

        <!-- Test Hero Section -->
        <section class="facilities-hero">
            <div class="container">
                <h1 class="hero-title">Test Fasilitas Sekolah</h1>
                <p class="hero-subtitle">
                    Jika styling bekerja, section ini akan memiliki background gradient purple/indigo
                </p>
                
                <div class="stats-row">
                    <div class="stat-item">
                        <span class="stat-number">10</span>
                        <span class="stat-label">Total Fasilitas</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Fasilitas Akademik</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Test Filter Section -->
        <section class="filter-section">
            <div class="container">
                <div class="filter-container">
                    <div class="filter-buttons">
                        <button class="filter-btn active">
                            <i class="fas fa-th-large"></i>Semua
                        </button>
                        <button class="filter-btn">
                            <i class="fas fa-graduation-cap"></i>Akademik
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Test Facility Card -->
        <section class="facilities-section">
            <div class="container">
                <div class="facilities-grid">
                    <div class="facility-card">
                        <div class="facility-image">
                            <div class="facility-placeholder">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="facility-status status-active">
                                Tersedia
                            </div>
                        </div>
                        
                        <div class="facility-content">
                            <h3 class="facility-title">Test Fasilitas</h3>
                            <p class="facility-description">Ini adalah test card untuk memastikan styling bekerja dengan baik.</p>
                            
                            <div class="facility-meta">
                                <span class="facility-category">Akademik</span>
                                <div class="facility-capacity">
                                    <i class="fas fa-users"></i>
                                    <span>50 orang</span>
                                </div>
                            </div>
                            
                            <a href="#" class="btn-detail">
                                <i class="fas fa-info-circle"></i>
                                <span>Lihat Detail</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="test-notice" style="margin-top: 40px;">
            <h3>✅ Styling Check Results:</h3>
            <ul>
                <li>Hero section should have purple/indigo gradient background</li>
                <li>Filter buttons should be rounded with hover effects</li>
                <li>Facility card should have rounded corners and shadow</li>
                <li>Detail button should be purple gradient</li>
            </ul>
            <p><strong>If styling looks correct here, go to <a href="/facilities">/facilities</a> and hard refresh (Ctrl+F5)</strong></p>
        </div>
    </div>
</body>
</html>';

file_put_contents('public/test-facilities-styling.html', $testHtml);
echo "✅ Test HTML created: public/test-facilities-styling.html\n";

// Step 4: Create .htaccess for CSS
echo "\n4️⃣ Creating .htaccess for CSS caching...\n";
$htaccess = '# CSS Cache Control
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType text/css "access plus 1 hour"
</IfModule>

<IfModule mod_headers.c>
    <FilesMatch "\.(css)$">
        Header set Cache-Control "public, max-age=3600"
    </FilesMatch>
</IfModule>';

file_put_contents('public/css/.htaccess', $htaccess);
echo "✅ CSS .htaccess created\n";

// Step 5: Regenerate autoloader
echo "\n5️⃣ Regenerating autoloader...\n";
exec('composer dump-autoload 2>&1', $output5);
echo "✅ Autoloader regenerated\n";

// Step 6: Cache for optimization
echo "\n6️⃣ Caching for optimization...\n";
exec('php artisan config:cache 2>&1', $output6);
exec('php artisan view:cache 2>&1', $output7);
echo "✅ Application optimized\n";

echo "\n🎉 STYLING FORCE ACTIVATION COMPLETED!\n";
echo "=====================================\n";

echo "\n📋 NEXT STEPS:\n";
echo "1. Test styling: http://localhost:8000/test-facilities-styling.html\n";
echo "2. If test looks good, go to: http://localhost:8000/facilities\n";
echo "3. Hard refresh browser: Ctrl+F5 (Windows) or Cmd+Shift+R (Mac)\n";
echo "4. Clear browser cache if needed\n";

echo "\n💡 TROUBLESHOOTING:\n";
echo "- Try incognito/private browsing mode\n";
echo "- Check browser developer tools for CSS errors\n";
echo "- Verify CSS file loads: http://localhost:8000/css/facilities-public.css\n";
echo "- Check Laravel logs: storage/logs/laravel.log\n";

echo "\n🚀 STYLING SHOULD NOW BE ACTIVE!\n";