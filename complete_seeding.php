<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

use Illuminate\Support\Facades\DB;

echo "🎯 Completing Database Seeding Process...\n";
echo "=========================================\n\n";

// Step 1: Run the missing ContactSeeder
echo "📋 Step 1: Running Missing ContactSeeder\n";
echo "----------------------------------------\n";

try {
    echo "🌱 Running ContactSeeder...\n";
    
    $exitCode = $kernel->call('db:seed', [
        '--class' => 'ContactSeeder',
        '--force' => true
    ]);
    
    if ($exitCode === 0) {
        echo "✅ ContactSeeder completed successfully!\n";
        
        if (DB::getSchemaBuilder()->hasTable('contacts')) {
            $contactCount = DB::table('contacts')->count();
            echo "   📊 Total contacts created: $contactCount\n";
        }
    } else {
        echo "❌ ContactSeeder failed!\n";
    }
    
} catch (Exception $e) {
    echo "❌ ContactSeeder error: " . $e->getMessage() . "\n";
}

echo "\n";

// Step 2: Verify all seeders
echo "📋 Step 2: Comprehensive Verification\n";
echo "-------------------------------------\n";

$seeders = [
    'RoleSeeder' => ['table' => 'roles', 'min_expected' => 3],
    'UserSeeder' => ['table' => 'users', 'min_expected' => 3],
    'StudentSeeder' => ['table' => 'students', 'min_expected' => 10],
    'TeacherSeeder' => ['table' => 'teachers', 'min_expected' => 5],
    'BlogPostSeeder' => ['table' => 'blog_posts', 'min_expected' => 3],
    'AnnouncementSeeder' => ['table' => 'announcements', 'min_expected' => 3],
    'ExtracurricularRegistrationSeeder' => ['table' => 'extracurricular_registrations', 'min_expected' => 5],
    'ContactSeeder' => ['table' => 'contacts', 'min_expected' => 5],
    'StudyProgramSeeder' => ['table' => 'study_programs', 'min_expected' => 3]
];

$allSuccess = true;
$totalRecords = 0;

foreach ($seeders as $seederName => $config) {
    $tableName = $config['table'];
    $minExpected = $config['min_expected'];
    
    try {
        if (DB::getSchemaBuilder()->hasTable($tableName)) {
            $count = DB::table($tableName)->count();
            
            if ($count >= $minExpected) {
                echo "✅ $seederName: $count records (Expected: $minExpected+)\n";
                $totalRecords += $count;
            } else {
                echo "⚠️  $seederName: $count records (Expected: $minExpected+) - INSUFFICIENT\n";
                $allSuccess = false;
            }
        } else {
            echo "❌ $seederName: Table '$tableName' does not exist\n";
            $allSuccess = false;
        }
        
    } catch (Exception $e) {
        echo "❌ $seederName: Error - " . $e->getMessage() . "\n";
        $allSuccess = false;
    }
}

echo "\n📊 Summary:\n";
echo "   - Total records across all tables: $totalRecords\n";

// Step 3: System health check
echo "\n📋 Step 3: System Health Check\n";
echo "------------------------------\n";

try {
    // Check admin users
    $adminUsers = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('roles.name', 'admin')
        ->count();
        
    echo "👑 Admin users: $adminUsers\n";
    
    // Check study programs
    if (DB::getSchemaBuilder()->hasTable('study_programs')) {
        $activePrograms = DB::table('study_programs')->where('is_active', true)->count();
        $totalPrograms = DB::table('study_programs')->count();
        echo "📚 Study programs: $activePrograms active / $totalPrograms total\n";
    }
    
    // Check extracurricular registrations
    if (DB::getSchemaBuilder()->hasTable('extracurricular_registrations')) {
        $pendingRegs = DB::table('extracurricular_registrations')->where('status', 'pending')->count();
        $approvedRegs = DB::table('extracurricular_registrations')->where('status', 'approved')->count();
        echo "📝 Extracurricular registrations: $approvedRegs approved, $pendingRegs pending\n";
    }
    
    // Check contacts
    if (DB::getSchemaBuilder()->hasTable('contacts')) {
        $unreadContacts = DB::table('contacts')->where('status', 'unread')->count();
        $totalContacts = DB::table('contacts')->count();
        echo "📧 Contacts: $unreadContacts unread / $totalContacts total\n";
    }
    
} catch (Exception $e) {
    echo "❌ Health check error: " . $e->getMessage() . "\n";
}

// Final status
echo "\n🎯 Final Status:\n";
echo "===============\n";

if ($allSuccess) {
    echo "🎉 SUCCESS! All seeders completed successfully!\n";
    echo "\n✅ Database is fully populated and ready for use!\n";
    echo "\n🌐 You can now access:\n";
    echo "   - Admin Dashboard: /admin/dashboard\n";
    echo "   - Study Programs Admin: /admin/study-programs\n";
    echo "   - Study Programs Public: /study-programs\n";
    echo "   - Extracurricular Registrations: /admin/extracurriculars/registrations.page\n";
    
    echo "\n📋 Sample Data Available:\n";
    echo "   ✅ User accounts (admin, teacher, student)\n";
    echo "   ✅ Student and teacher profiles\n";
    echo "   ✅ Blog posts and announcements\n";
    echo "   ✅ Extracurricular registrations\n";
    echo "   ✅ Contact messages\n";
    echo "   ✅ Study programs with sample data\n";
    
} else {
    echo "⚠️  PARTIAL SUCCESS! Some issues detected.\n";
    echo "\n📝 Recommendations:\n";
    echo "   1. Check the errors above\n";
    echo "   2. Run individual seeders if needed\n";
    echo "   3. Verify database table structures\n";
    echo "   4. Check Laravel logs for detailed errors\n";
}

echo "\n✨ Seeding process completed!\n";