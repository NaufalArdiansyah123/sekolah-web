<?php

// Script untuk memperbaiki masalah session
echo "🔧 Fixing session issues...\n";

// Clear all caches
echo "1. Clearing config cache...\n";
exec('php artisan config:clear');

echo "2. Clearing route cache...\n";
exec('php artisan route:clear');

echo "3. Clearing view cache...\n";
exec('php artisan view:clear');

echo "4. Clearing application cache...\n";
exec('php artisan cache:clear');

// Clear session files
echo "5. Clearing session files...\n";
$sessionPath = __DIR__ . '/storage/framework/sessions';
$files = glob($sessionPath . '/*');
foreach($files as $file) {
    if(is_file($file) && basename($file) !== '.gitignore') {
        unlink($file);
        echo "   Deleted: " . basename($file) . "\n";
    }
}

// Set proper permissions
echo "6. Setting proper permissions...\n";
chmod($sessionPath, 0755);
echo "   Session directory permissions set to 755\n";

// Cache config
echo "7. Caching configuration...\n";
exec('php artisan config:cache');

echo "\n✅ Session fix completed!\n";
echo "📝 Please test the modal functionality now.\n";
echo "🔄 If still not working, restart your web server.\n";

?>