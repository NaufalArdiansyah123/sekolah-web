<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "🚀 Complete Study Programs Setup\n";
echo "================================\n\n";

$steps = [
    'migration' => false,
    'storage' => false,
    'seeder' => false,
    'cache' => false
];

// Step 1: Check and run migration
echo "📊 Step 1: Database Migration\n";
echo "-----------------------------\n";

try {
    if (!Schema::hasTable('study_programs')) {
        echo "Running migration...\n";
        $exitCode = $kernel->call('migrate', [
            '--path' => 'database/migrations/2024_01_15_000000_create_study_programs_table.php',
            '--force' => true
        ]);
        
        if ($exitCode === 0) {
            echo "✅ Migration completed successfully!\n";
            $steps['migration'] = true;
        } else {
            echo "❌ Migration failed!\n";
        }
    } else {
        echo "✅ Table already exists!\n";
        $steps['migration'] = true;
    }
} catch (Exception $e) {
    echo "❌ Migration error: " . $e->getMessage() . "\n";
}

echo "\n";

// Step 2: Create storage directories
echo "📁 Step 2: Storage Directories\n";
echo "------------------------------\n";

$directories = [
    'storage/app/public/study-programs',
    'storage/app/public/study-programs/images',
    'storage/app/public/study-programs/brochures'
];

$allCreated = true;
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "✅ Created: $dir\n";
        } else {
            echo "❌ Failed to create: $dir\n";
            $allCreated = false;
        }
    } else {
        echo "✅ Exists: $dir\n";
    }
}

$steps['storage'] = $allCreated;
echo "\n";

// Step 3: Create storage link
echo "🔗 Step 3: Storage Link\n";
echo "-----------------------\n";

try {
    $kernel->call('storage:link');
    echo "✅ Storage link created!\n";
} catch (Exception $e) {
    echo "⚠️  Storage link: " . $e->getMessage() . "\n";
}

echo "\n";

// Step 4: Run seeder
echo "🌱 Step 4: Sample Data\n";
echo "----------------------\n";

try {
    $currentCount = 0;
    if (Schema::hasTable('study_programs')) {
        $currentCount = DB::table('study_programs')->count();
    }
    
    if ($currentCount == 0) {
        echo "Running seeder...\n";
        $exitCode = $kernel->call('db:seed', [
            '--class' => 'StudyProgramSeeder',
            '--force' => true
        ]);
        
        if ($exitCode === 0) {
            $newCount = DB::table('study_programs')->count();
            echo "✅ Seeder completed! Added $newCount programs.\n";
            $steps['seeder'] = true;
        } else {
            echo "❌ Seeder failed!\n";
        }
    } else {
        echo "✅ Sample data already exists ($currentCount programs)!\n";
        $steps['seeder'] = true;
    }
} catch (Exception $e) {
    echo "❌ Seeder error: " . $e->getMessage() . "\n";
}

echo "\n";

// Step 5: Clear cache
echo "🧹 Step 5: Clear Cache\n";
echo "----------------------\n";

try {
    $kernel->call('config:clear');
    echo "✅ Config cache cleared!\n";
    
    $kernel->call('route:clear');
    echo "✅ Route cache cleared!\n";
    
    $kernel->call('view:clear');
    echo "✅ View cache cleared!\n";
    
    $steps['cache'] = true;
} catch (Exception $e) {
    echo "❌ Cache error: " . $e->getMessage() . "\n";
}

echo "\n";

// Final status
echo "🎯 Setup Summary\n";
echo "================\n";

$allSuccess = true;
foreach ($steps as $step => $success) {
    $status = $success ? "✅" : "❌";
    $stepName = ucfirst(str_replace('_', ' ', $step));
    echo "$status $stepName\n";
    if (!$success) $allSuccess = false;
}

echo "\n";

if ($allSuccess) {
    echo "🎉 Setup completed successfully!\n\n";
    
    // Show sample data
    if (Schema::hasTable('study_programs')) {
        $programs = DB::table('study_programs')->select('program_name', 'degree_level', 'is_active')->limit(3)->get();
        echo "📋 Sample Programs:\n";
        foreach ($programs as $program) {
            $status = $program->is_active ? 'Active' : 'Inactive';
            echo "   - {$program->program_name} ({$program->degree_level}) - $status\n";
        }
        echo "\n";
    }
    
    echo "🌐 Access URLs:\n";
    echo "   - Admin Panel: /admin/study-programs\n";
    echo "   - Public Page: /study-programs\n\n";
    
    echo "📝 Next Steps:\n";
    echo "   1. Test the admin panel by creating a new study program\n";
    echo "   2. Upload some images and brochures\n";
    echo "   3. Check the public page to see the programs\n";
    echo "   4. Configure any additional settings as needed\n\n";
    
    echo "✨ Happy coding!\n";
} else {
    echo "⚠️  Setup completed with some issues. Please check the errors above.\n";
}

echo "\n";