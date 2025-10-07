<?php

echo "🖼️ FIXING IMAGES NOW - SIMPLE & FAST\n";
echo "====================================\n\n";

// Step 1: Create directories
echo "1️⃣ Creating directories...\n";
$dirs = ['public/storage', 'public/storage/facilities'];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✅ Created: $dir\n";
    } else {
        echo "✅ Exists: $dir\n";
    }
}

// Step 2: Copy images
echo "\n2️⃣ Copying images...\n";
if (is_dir('storage/app/public/facilities')) {
    $files = glob('storage/app/public/facilities/*');
    $copied = 0;
    
    foreach ($files as $file) {
        if (is_file($file)) {
            $name = basename($file);
            $dest = "public/storage/facilities/$name";
            if (copy($file, $dest)) {
                $copied++;
                echo "✅ $name\n";
            }
        }
    }
    echo "📊 Copied $copied files\n";
} else {
    echo "⚠️ No source images found\n";
}

// Step 3: Run Laravel storage link
echo "\n3️⃣ Creating storage link...\n";
exec('php artisan storage:link 2>&1', $output, $code);
if ($code === 0) {
    echo "✅ Storage link created\n";
} else {
    echo "⚠️ Storage link: " . implode(' ', $output) . "\n";
}

// Step 4: Clear caches
echo "\n4️⃣ Clearing caches...\n";
exec('php artisan cache:clear 2>&1');
exec('php artisan view:clear 2>&1');
echo "✅ Caches cleared\n";

// Step 5: Test
echo "\n5️⃣ Testing...\n";
$testFiles = glob('public/storage/facilities/*');
echo "📊 Available images: " . count($testFiles) . "\n";

if (count($testFiles) > 0) {
    echo "\n🔗 Test URLs:\n";
    foreach (array_slice($testFiles, 0, 3) as $file) {
        $name = basename($file);
        echo "   http://localhost:8000/storage/facilities/$name\n";
    }
}

echo "\n🎉 DONE! Visit /facilities to see results\n";