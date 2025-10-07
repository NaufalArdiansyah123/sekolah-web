<?php

echo "🚀 Starting Study Programs Setup...\n\n";

// Step 1: Run migration
echo "📊 Running migration...\n";
$output = shell_exec('php artisan migrate --path=database/migrations/2024_01_15_000000_create_study_programs_table.php 2>&1');
echo $output;

// Step 2: Create storage link
echo "\n🔗 Creating storage link...\n";
$linkOutput = shell_exec('php artisan storage:link 2>&1');
echo $linkOutput;

// Step 3: Run seeder
echo "\n🌱 Running seeder...\n";
$seederOutput = shell_exec('php artisan db:seed --class=StudyProgramSeeder 2>&1');
echo $seederOutput;

// Step 4: Clear cache
echo "\n🧹 Clearing cache...\n";
shell_exec('php artisan config:clear');
shell_exec('php artisan route:clear');
shell_exec('php artisan view:clear');
echo "✅ Cache cleared!\n";

echo "\n🎉 Setup completed!\n";
echo "You can now access:\n";
echo "- Admin: /admin/study-programs\n";
echo "- Public: /study-programs\n";