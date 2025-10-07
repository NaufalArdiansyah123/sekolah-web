<?php

/**
 * Clear Laravel Caches Script
 * This will clear all Laravel caches to fix controller loading issues
 */

echo "🧹 CLEARING LARAVEL CACHES\n";
echo "==========================\n\n";

// Commands to run
$commands = [
    'php artisan config:clear' => 'Clear configuration cache',
    'php artisan route:clear' => 'Clear route cache', 
    'php artisan cache:clear' => 'Clear application cache',
    'php artisan view:clear' => 'Clear view cache',
    'composer dump-autoload' => 'Regenerate autoloader'
];

foreach ($commands as $command => $description) {
    echo "🔄 $description...\n";
    echo "   Running: $command\n";
    
    $output = [];
    $returnCode = 0;
    exec($command . ' 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "   ✅ Success\n";
    } else {
        echo "   ⚠️ Warning: " . implode("\n", $output) . "\n";
    }
    echo "\n";
}

echo "🎉 CACHE CLEARING COMPLETED!\n";
echo "Now try accessing the facilities page again.\n";