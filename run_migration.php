<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "🚀 Running Study Programs Migration...\n\n";

try {
    // Run migration
    $exitCode = $kernel->call('migrate', [
        '--path' => 'database/migrations/2024_01_15_000000_create_study_programs_table.php',
        '--force' => true
    ]);
    
    if ($exitCode === 0) {
        echo "✅ Migration completed successfully!\n";
    } else {
        echo "❌ Migration failed with exit code: $exitCode\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error running migration: " . $e->getMessage() . "\n";
}

echo "\n✨ Done!\n";