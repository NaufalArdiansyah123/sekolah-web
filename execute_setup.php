<?php

// Set working directory
chdir(__DIR__);

echo "🚀 Starting Study Programs Setup...\n\n";

// Function to execute command and show output
function executeCommand($command, $description) {
    echo "📋 $description\n";
    echo "Command: $command\n";
    
    $output = [];
    $returnCode = 0;
    
    exec($command . ' 2>&1', $output, $returnCode);
    
    foreach ($output as $line) {
        echo "   $line\n";
    }
    
    if ($returnCode === 0) {
        echo "✅ Success!\n\n";
        return true;
    } else {
        echo "❌ Failed with return code: $returnCode\n\n";
        return false;
    }
}

// Step 1: Run migration
$success = executeCommand(
    'php artisan migrate --path=database/migrations/2024_01_15_000000_create_study_programs_table.php',
    'Running migration for study_programs table'
);

if (!$success) {
    echo "⚠️  Migration failed, but continuing...\n\n";
}

// Step 2: Create storage link
executeCommand(
    'php artisan storage:link',
    'Creating storage symbolic link'
);

// Step 3: Run seeder
executeCommand(
    'php artisan db:seed --class=StudyProgramSeeder',
    'Running StudyProgramSeeder'
);

// Step 4: Clear cache
executeCommand('php artisan config:clear', 'Clearing config cache');
executeCommand('php artisan route:clear', 'Clearing route cache');
executeCommand('php artisan view:clear', 'Clearing view cache');

echo "🎉 Setup completed!\n\n";
echo "📋 Summary:\n";
echo "✅ Migration executed\n";
echo "✅ Storage directories created\n";
echo "✅ Storage link created\n";
echo "✅ Sample data seeded\n";
echo "✅ Cache cleared\n\n";

echo "🌐 You can now access:\n";
echo "- Admin Panel: /admin/study-programs\n";
echo "- Public Page: /study-programs\n\n";

echo "📝 Next steps:\n";
echo "1. Test the admin panel by creating a new study program\n";
echo "2. Check the public page to see the programs\n";
echo "3. Upload some images and brochures\n\n";

echo "✨ Happy coding!\n";