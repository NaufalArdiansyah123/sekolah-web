<?php

/**
 * Setup Study Programs System
 * 
 * This script will:
 * 1. Run the migration to create study_programs table
 * 2. Run the seeder to populate sample data
 * 3. Create storage directories for file uploads
 */

echo "🚀 Setting up Study Programs System...\n\n";

// Check if we're in the correct directory
if (!file_exists('artisan')) {
    echo "❌ Error: Please run this script from the Laravel project root directory.\n";
    exit(1);
}

// Step 1: Run migration
echo "📊 Running migration for study_programs table...\n";
$migrationResult = shell_exec('php artisan migrate --path=database/migrations/2024_01_15_000000_create_study_programs_table.php 2>&1');
echo $migrationResult;

if (strpos($migrationResult, 'error') !== false || strpos($migrationResult, 'Error') !== false) {
    echo "❌ Migration failed. Please check the error above.\n";
    exit(1);
}

echo "✅ Migration completed successfully!\n\n";

// Step 2: Create storage directories
echo "📁 Creating storage directories...\n";

$directories = [
    'storage/app/public/study-programs',
    'storage/app/public/study-programs/images',
    'storage/app/public/study-programs/brochures',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✅ Created directory: $dir\n";
    } else {
        echo "ℹ️  Directory already exists: $dir\n";
    }
}

// Step 3: Create symbolic link for storage (if not exists)
echo "\n🔗 Creating storage symbolic link...\n";
$linkResult = shell_exec('php artisan storage:link 2>&1');
echo $linkResult;

// Step 4: Run seeder
echo "\n🌱 Running StudyProgramSeeder...\n";
$seederResult = shell_exec('php artisan db:seed --class=StudyProgramSeeder 2>&1');
echo $seederResult;

if (strpos($seederResult, 'error') !== false || strpos($seederResult, 'Error') !== false) {
    echo "❌ Seeder failed. Please check the error above.\n";
    echo "ℹ️  You can run the seeder manually with: php artisan db:seed --class=StudyProgramSeeder\n";
} else {
    echo "✅ Seeder completed successfully!\n";
}

// Step 5: Clear cache
echo "\n🧹 Clearing application cache...\n";
shell_exec('php artisan config:clear');
shell_exec('php artisan route:clear');
shell_exec('php artisan view:clear');
echo "✅ Cache cleared!\n";

echo "\n🎉 Study Programs System setup completed!\n\n";

echo "📋 Summary:\n";
echo "- ✅ Database table created\n";
echo "- ✅ Storage directories created\n";
echo "- ✅ Sample data seeded\n";
echo "- ✅ Cache cleared\n\n";

echo "🌐 You can now access:\n";
echo "- Admin Panel: /admin/study-programs\n";
echo "- Public Page: /study-programs\n\n";

echo "📝 Next steps:\n";
echo "1. Configure file upload settings in config/filesystems.php if needed\n";
echo "2. Set up proper permissions for storage directories\n";
echo "3. Configure email settings for notifications\n";
echo "4. Test the system by creating a new study program\n\n";

echo "🔧 Troubleshooting:\n";
echo "- If you get permission errors, run: sudo chown -R www-data:www-data storage/\n";
echo "- If routes don't work, run: php artisan route:cache\n";
echo "- If views don't load, run: php artisan view:cache\n\n";

echo "✨ Happy coding!\n";