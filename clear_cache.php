<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "🧹 Clearing Application Cache...\n\n";

try {
    // Clear config cache
    echo "📋 Clearing config cache...\n";
    $kernel->call('config:clear');
    echo "✅ Config cache cleared!\n\n";
    
    // Clear route cache
    echo "📋 Clearing route cache...\n";
    $kernel->call('route:clear');
    echo "✅ Route cache cleared!\n\n";
    
    // Clear view cache
    echo "📋 Clearing view cache...\n";
    $kernel->call('view:clear');
    echo "✅ View cache cleared!\n\n";
    
    // Create storage link
    echo "📋 Creating storage link...\n";
    $kernel->call('storage:link');
    echo "✅ Storage link created!\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "✨ Cache clearing completed!\n";