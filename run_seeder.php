<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "🌱 Running Study Programs Seeder...\n\n";

try {
    // Run seeder
    $exitCode = $kernel->call('db:seed', [
        '--class' => 'StudyProgramSeeder',
        '--force' => true
    ]);
    
    if ($exitCode === 0) {
        echo "✅ Seeder completed successfully!\n";
    } else {
        echo "❌ Seeder failed with exit code: $exitCode\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error running seeder: " . $e->getMessage() . "\n";
}

echo "\n✨ Done!\n";