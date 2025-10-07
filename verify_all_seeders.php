<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

use Illuminate\Support\Facades\DB;

echo "🔍 Verifying All Seeders and Database State...\n";
echo "==============================================\n\n";

// Define all expected tables and their descriptions
$tables = [
    'roles' => [
        'name' => 'Roles',
        'seeder' => 'RoleSeeder',
        'expected_min' => 3
    ],
    'users' => [
        'name' => 'Users',
        'seeder' => 'UserSeeder',
        'expected_min' => 3
    ],
    'students' => [
        'name' => 'Students',
        'seeder' => 'StudentSeeder',
        'expected_min' => 10
    ],
    'teachers' => [
        'name' => 'Teachers',
        'seeder' => 'TeacherSeeder',
        'expected_min' => 5
    ],
    'blog_posts' => [
        'name' => 'Blog Posts',
        'seeder' => 'BlogPostSeeder',
        'expected_min' => 3
    ],
    'announcements' => [
        'name' => 'Announcements',
        'seeder' => 'AnnouncementSeeder',
        'expected_min' => 3
    ],
    'extracurricular_registrations' => [
        'name' => 'Extracurricular Registrations',
        'seeder' => 'ExtracurricularRegistrationSeeder',
        'expected_min' => 5
    ],
    'contacts' => [
        'name' => 'Contacts',
        'seeder' => 'ContactSeeder',
        'expected_min' => 5
    ],
    'study_programs' => [
        'name' => 'Study Programs',
        'seeder' => 'StudyProgramSeeder',
        'expected_min' => 3
    ]
];

$results = [];
$totalTables = count($tables);
$successfulTables = 0;

echo "📊 Database Table Verification:\n";
echo "-------------------------------\n";

foreach ($tables as $tableName => $info) {
    echo "📋 Checking {$info['name']} ({$tableName})...\n";
    
    try {
        if (DB::getSchemaBuilder()->hasTable($tableName)) {
            $count = DB::table($tableName)->count();
            
            if ($count >= $info['expected_min']) {
                echo "✅ {$info['name']}: $count records (Expected: {$info['expected_min']}+)\n";
                $results[$tableName] = ['status' => 'success', 'count' => $count];
                $successfulTables++;
            } else {
                echo "⚠️  {$info['name']}: $count records (Expected: {$info['expected_min']}+) - LOW COUNT\n";
                $results[$tableName] = ['status' => 'warning', 'count' => $count];
            }
        } else {
            echo "❌ {$info['name']}: Table does not exist\n";
            $results[$tableName] = ['status' => 'missing', 'count' => 0];
        }
        
    } catch (Exception $e) {
        echo "❌ {$info['name']}: Error - " . $e->getMessage() . "\n";
        $results[$tableName] = ['status' => 'error', 'count' => 0];
    }
}

echo "\n📈 Summary Statistics:\n";
echo "---------------------\n";
echo "✅ Successful tables: $successfulTables/$totalTables\n";

$warningCount = count(array_filter($results, fn($r) => $r['status'] === 'warning'));
$missingCount = count(array_filter($results, fn($r) => $r['status'] === 'missing'));
$errorCount = count(array_filter($results, fn($r) => $r['status'] === 'error'));

echo "⚠️  Warning tables: $warningCount\n";
echo "❌ Missing tables: $missingCount\n";
echo "🔥 Error tables: $errorCount\n";

// Show detailed breakdown
echo "\n📋 Detailed Breakdown:\n";
echo "----------------------\n";

$totalRecords = 0;
foreach ($results as $table => $result) {
    $icon = match($result['status']) {
        'success' => '✅',
        'warning' => '⚠️ ',
        'missing' => '❌',
        'error' => '🔥'
    };
    
    echo "$icon {$tables[$table]['name']}: {$result['count']} records\n";
    $totalRecords += $result['count'];
}

echo "\n📊 Total Records: $totalRecords\n";

// Check specific data quality
echo "\n🔍 Data Quality Checks:\n";
echo "-----------------------\n";

try {
    // Check admin users
    if (DB::getSchemaBuilder()->hasTable('users') && DB::getSchemaBuilder()->hasTable('model_has_roles')) {
        $adminCount = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'admin')
            ->count();
            
        echo "👑 Admin users: $adminCount\n";
    }
    
    // Check active study programs
    if (DB::getSchemaBuilder()->hasTable('study_programs')) {
        $activePrograms = DB::table('study_programs')->where('is_active', true)->count();
        $featuredPrograms = DB::table('study_programs')->where('is_featured', true)->count();
        
        echo "📚 Active study programs: $activePrograms\n";
        echo "⭐ Featured study programs: $featuredPrograms\n";
    }
    
    // Check pending registrations
    if (DB::getSchemaBuilder()->hasTable('extracurricular_registrations')) {
        $pendingRegs = DB::table('extracurricular_registrations')->where('status', 'pending')->count();
        $approvedRegs = DB::table('extracurricular_registrations')->where('status', 'approved')->count();
        
        echo "📝 Pending extracurricular registrations: $pendingRegs\n";
        echo "✅ Approved extracurricular registrations: $approvedRegs\n";
    }
    
    // Check unread contacts
    if (DB::getSchemaBuilder()->hasTable('contacts')) {
        $unreadContacts = DB::table('contacts')->where('status', 'unread')->count();
        echo "📧 Unread contacts: $unreadContacts\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error in data quality checks: " . $e->getMessage() . "\n";
}

// Final assessment
echo "\n🎯 Final Assessment:\n";
echo "-------------------\n";

if ($successfulTables === $totalTables && $warningCount === 0) {
    echo "🎉 EXCELLENT! All seeders completed successfully!\n";
    echo "   ✅ All tables have sufficient data\n";
    echo "   ✅ Database is ready for production use\n";
} elseif ($successfulTables >= ($totalTables * 0.8)) {
    echo "✅ GOOD! Most seeders completed successfully!\n";
    echo "   ⚠️  Some tables may need attention\n";
    echo "   📝 System is functional but could be improved\n";
} else {
    echo "⚠️  NEEDS ATTENTION! Several seeders failed or incomplete!\n";
    echo "   ❌ Multiple tables missing or have insufficient data\n";
    echo "   🔧 Manual intervention may be required\n";
}

echo "\n🌐 Access URLs:\n";
echo "   - Admin Panel: /admin/dashboard\n";
echo "   - Study Programs: /admin/study-programs\n";
echo "   - Extracurricular Registrations: /admin/extracurriculars/registrations.page\n";
echo "   - Public Study Programs: /study-programs\n";

echo "\n✨ Verification completed!\n";