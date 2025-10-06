<?php

/**
 * Quick script to run StudentRegistrationSeeder
 * 
 * This script will create sample student registration data
 * for testing the student registration management features.
 * 
 * Usage: php run-student-registration-seeder.php
 */

// Include Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the application
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🌱 Running StudentRegistrationSeeder...\n\n";

try {
    // Run the seeder
    $seeder = new Database\Seeders\StudentRegistrationSeeder();
    $seeder->run();
    
    echo "\n✅ StudentRegistrationSeeder completed successfully!\n";
    echo "\n📋 What was created:\n";
    echo "   - 10 student users with complete registration data\n";
    echo "   - Mix of pending, active, and rejected statuses\n";
    echo "   - Complete parent information and class data\n";
    echo "   - Ready for testing student registration management\n";
    echo "\n🔑 All accounts use password: 'password'\n";
    echo "\n🎯 You can now test the student registration features!\n";
    
} catch (Exception $e) {
    echo "❌ Error running seeder: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}