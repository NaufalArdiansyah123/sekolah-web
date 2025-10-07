<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "🔍 Checking database status...\n\n";

try {
    // Check database connection
    DB::connection()->getPdo();
    echo "✅ Database connection: OK\n";
    
    // Check if study_programs table exists
    if (Schema::hasTable('study_programs')) {
        echo "✅ study_programs table: EXISTS\n";
        
        // Count records
        $count = DB::table('study_programs')->count();
        echo "📊 Records in study_programs: $count\n";
        
        if ($count > 0) {
            echo "✅ Sample data: AVAILABLE\n";
            
            // Show some sample data
            $programs = DB::table('study_programs')->select('program_name', 'degree_level', 'is_active')->limit(3)->get();
            echo "\n📋 Sample programs:\n";
            foreach ($programs as $program) {
                $status = $program->is_active ? 'Active' : 'Inactive';
                echo "   - {$program->program_name} ({$program->degree_level}) - $status\n";
            }
        } else {
            echo "⚠️  Sample data: NOT FOUND\n";
            echo "💡 Run seeder: php artisan db:seed --class=StudyProgramSeeder\n";
        }
    } else {
        echo "❌ study_programs table: NOT EXISTS\n";
        echo "💡 Run migration: php artisan migrate --path=database/migrations/2024_01_15_000000_create_study_programs_table.php\n";
    }
    
    // Check storage directories
    echo "\n📁 Checking storage directories:\n";
    $directories = [
        'storage/app/public/study-programs',
        'storage/app/public/study-programs/images',
        'storage/app/public/study-programs/brochures'
    ];
    
    foreach ($directories as $dir) {
        if (is_dir($dir)) {
            echo "✅ $dir: EXISTS\n";
        } else {
            echo "❌ $dir: NOT EXISTS\n";
        }
    }
    
    // Check storage link
    if (is_link('public/storage')) {
        echo "✅ Storage link: EXISTS\n";
    } else {
        echo "❌ Storage link: NOT EXISTS\n";
        echo "💡 Create link: php artisan storage:link\n";
    }
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}

echo "\n🎯 System Status Summary:\n";
echo "- Database connection: " . (DB::connection()->getPdo() ? "✅" : "❌") . "\n";
echo "- study_programs table: " . (Schema::hasTable('study_programs') ? "✅" : "❌") . "\n";
echo "- Sample data: " . (Schema::hasTable('study_programs') && DB::table('study_programs')->count() > 0 ? "✅" : "❌") . "\n";
echo "- Storage directories: " . (is_dir('storage/app/public/study-programs') ? "✅" : "❌") . "\n";
echo "- Storage link: " . (is_link('public/storage') ? "✅" : "❌") . "\n";

echo "\n🌐 Access URLs:\n";
echo "- Admin: /admin/study-programs\n";
echo "- Public: /study-programs\n";

echo "\n✨ Done!\n";