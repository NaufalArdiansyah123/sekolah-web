<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

use Illuminate\Support\Facades\DB;

echo "🌱 Running All Seeders in Correct Order...\n";
echo "==========================================\n\n";

$seeders = [
    'RoleSeeder' => 'Creating roles',
    'UserSeeder' => 'Creating users',
    'StudentSeeder' => 'Creating students',
    'TeacherSeeder' => 'Creating teachers',
    'BlogPostSeeder' => 'Creating blog posts',
    'AnnouncementSeeder' => 'Creating announcements',
    'ExtracurricularRegistrationSeeder' => 'Creating extracurricular registrations',
    'ContactSeeder' => 'Creating contacts',
    'StudyProgramSeeder' => 'Creating study programs'
];

$results = [];

foreach ($seeders as $seederClass => $description) {
    echo "📋 $description ($seederClass)...\n";
    
    try {
        $exitCode = $kernel->call('db:seed', [
            '--class' => $seederClass,
            '--force' => true
        ]);
        
        if ($exitCode === 0) {
            echo "✅ $seederClass completed successfully!\n";
            $results[$seederClass] = 'success';
        } else {
            echo "❌ $seederClass failed!\n";
            $results[$seederClass] = 'failed';
        }
        
    } catch (Exception $e) {
        echo "❌ $seederClass error: " . $e->getMessage() . "\n";
        $results[$seederClass] = 'error';
    }
    
    echo "\n";
}

// Summary
echo "📊 Seeding Summary\n";
echo "==================\n";

$successCount = 0;
$failedCount = 0;

foreach ($results as $seeder => $status) {
    $icon = $status === 'success' ? '✅' : '❌';
    echo "$icon $seeder: " . strtoupper($status) . "\n";
    
    if ($status === 'success') {
        $successCount++;
    } else {
        $failedCount++;
    }
}

echo "\n📈 Statistics:\n";
echo "   - Successful: $successCount\n";
echo "   - Failed: $failedCount\n";
echo "   - Total: " . count($results) . "\n";

if ($failedCount === 0) {
    echo "\n🎉 All seeders completed successfully!\n";
    
    // Show database statistics
    echo "\n📊 Database Statistics:\n";
    
    $tables = [
        'users' => 'Users',
        'students' => 'Students', 
        'teachers' => 'Teachers',
        'blog_posts' => 'Blog Posts',
        'announcements' => 'Announcements',
        'extracurricular_registrations' => 'Extracurricular Registrations',
        'contacts' => 'Contacts',
        'study_programs' => 'Study Programs'
    ];
    
    foreach ($tables as $table => $label) {
        try {
            $count = DB::table($table)->count();
            echo "   - $label: $count\n";
        } catch (Exception $e) {
            echo "   - $label: N/A (table not found)\n";
        }
    }
    
} else {
    echo "\n⚠️  Some seeders failed. Please check the errors above.\n";
}

echo "\n✨ Done!\n";