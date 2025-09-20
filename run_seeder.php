<?php

// Script untuk menjalankan seeder dengan aman
echo "🚀 Starting Database Seeding Process...\n\n";

// Check if we're in the right directory
if (!file_exists('artisan')) {
    echo "❌ Error: artisan file not found. Please run this script from the Laravel root directory.\n";
    exit(1);
}

// Function to run artisan command
function runArtisan($command) {
    echo "📋 Running: php artisan $command\n";
    $output = [];
    $returnCode = 0;
    exec("php artisan $command 2>&1", $output, $returnCode);
    
    foreach ($output as $line) {
        echo "   $line\n";
    }
    
    if ($returnCode !== 0) {
        echo "❌ Command failed with return code: $returnCode\n";
        return false;
    }
    
    echo "✅ Command completed successfully\n\n";
    return true;
}

// Step 1: Clear cache
echo "🧹 Step 1: Clearing application cache...\n";
runArtisan("cache:clear");
runArtisan("config:clear");
runArtisan("route:clear");

// Step 2: Run migrations (if needed)
echo "🗄️  Step 2: Checking database migrations...\n";
runArtisan("migrate:status");

// Step 3: Run seeders one by one
echo "🌱 Step 3: Running seeders...\n";

$seeders = [
    'UserSeeder',
    'TeacherSeeder', 
    'ExtracurricularSeeder',
    'ExtracurricularRegistrationSeeder'
];

foreach ($seeders as $seeder) {
    echo "🌱 Running $seeder...\n";
    if (!runArtisan("db:seed --class=$seeder")) {
        echo "❌ Failed to run $seeder. Stopping process.\n";
        exit(1);
    }
}

echo "🎉 All seeders completed successfully!\n\n";

// Step 4: Show statistics
echo "📊 Database Statistics:\n";
runArtisan("tinker --execute=\"
echo 'Users: ' . App\\Models\\User::count() . PHP_EOL;
echo 'Teachers: ' . App\\Models\\Teacher::count() . PHP_EOL;
echo 'Extracurriculars: ' . App\\Models\\Extracurricular::count() . PHP_EOL;
echo 'Registrations: ' . App\\Models\\ExtracurricularRegistration::count() . PHP_EOL;
echo 'Pending Registrations: ' . App\\Models\\ExtracurricularRegistration::where(\\\"status\\\", \\\"pending\\\")->count() . PHP_EOL;
echo 'Approved Registrations: ' . App\\Models\\ExtracurricularRegistration::where(\\\"status\\\", \\\"approved\\\")->count() . PHP_EOL;
echo 'Rejected Registrations: ' . App\\Models\\ExtracurricularRegistration::where(\\\"status\\\", \\\"rejected\\\")->count() . PHP_EOL;
\"");

echo "\n✨ Database seeding completed successfully!\n";
echo "🌐 You can now test the application at: http://localhost/admin/extracurriculars\n";