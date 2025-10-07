<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

use Illuminate\Support\Facades\DB;

echo "🔧 Fixing Seeder Issues...\n";
echo "==========================\n\n";

try {
    // Step 1: Check current state
    echo "📋 Checking current database state...\n";
    
    $userCount = DB::table('users')->count();
    echo "   - Users: $userCount\n";
    
    $extracurricularCount = DB::table('extracurriculars')->count();
    echo "   - Extracurriculars: $extracurricularCount\n";
    
    $registrationCount = DB::table('extracurricular_registrations')->count();
    echo "   - Registrations: $registrationCount\n";
    
    // Step 2: Check for admin users
    echo "\n👑 Checking admin users...\n";
    
    $adminUsers = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('roles.name', 'admin')
        ->select('users.id', 'users.name', 'users.email')
        ->get();
        
    if ($adminUsers->count() > 0) {
        echo "✅ Found admin users:\n";
        foreach ($adminUsers as $admin) {
            echo "   - ID: {$admin->id} - {$admin->name} ({$admin->email})\n";
        }
    } else {
        echo "❌ No admin users found!\n";
        
        // Get any user
        $anyUser = DB::table('users')->first();
        if ($anyUser) {
            echo "   Using fallback user: ID {$anyUser->id} - {$anyUser->name}\n";
        } else {
            echo "   No users found at all!\n";
            
            // Run UserSeeder
            echo "\n🌱 Running UserSeeder...\n";
            $exitCode = $kernel->call('db:seed', [
                '--class' => 'UserSeeder',
                '--force' => true
            ]);
            
            if ($exitCode === 0) {
                echo "✅ UserSeeder completed!\n";
            } else {
                echo "❌ UserSeeder failed!\n";
                exit(1);
            }
        }
    }
    
    // Step 3: Clear problematic registrations
    echo "\n🧹 Clearing existing extracurricular registrations...\n";
    DB::table('extracurricular_registrations')->delete();
    echo "✅ Cleared existing registrations!\n";
    
    // Step 4: Run the fixed seeder
    echo "\n🌱 Running fixed ExtracurricularRegistrationSeeder...\n";
    $exitCode = $kernel->call('db:seed', [
        '--class' => 'ExtracurricularRegistrationSeeder',
        '--force' => true
    ]);
    
    if ($exitCode === 0) {
        echo "✅ ExtracurricularRegistrationSeeder completed successfully!\n";
        
        // Show results
        $newRegistrationCount = DB::table('extracurricular_registrations')->count();
        echo "\n📊 Results:\n";
        echo "   - Total registrations created: $newRegistrationCount\n";
        
        $approvedCount = DB::table('extracurricular_registrations')->where('status', 'approved')->count();
        $pendingCount = DB::table('extracurricular_registrations')->where('status', 'pending')->count();
        
        echo "   - Approved: $approvedCount\n";
        echo "   - Pending: $pendingCount\n";
        
        // Show sample data
        $sampleRegistrations = DB::table('extracurricular_registrations')
            ->join('extracurriculars', 'extracurricular_registrations.extracurricular_id', '=', 'extracurriculars.id')
            ->select('extracurricular_registrations.student_name', 'extracurriculars.name as extracurricular_name', 'extracurricular_registrations.status')
            ->limit(5)
            ->get();
            
        echo "\n📋 Sample registrations:\n";
        foreach ($sampleRegistrations as $reg) {
            echo "   - {$reg->student_name} -> {$reg->extracurricular_name} ({$reg->status})\n";
        }
        
    } else {
        echo "❌ ExtracurricularRegistrationSeeder still failed!\n";
        exit(1);
    }
    
    // Step 5: Continue with other seeders if needed
    echo "\n🌱 Running remaining seeders...\n";
    
    $remainingSeeders = [
        'StudyProgramSeeder' => 'Study Programs'
    ];
    
    foreach ($remainingSeeders as $seederClass => $description) {
        echo "📋 Running $description ($seederClass)...\n";
        
        try {
            $exitCode = $kernel->call('db:seed', [
                '--class' => $seederClass,
                '--force' => true
            ]);
            
            if ($exitCode === 0) {
                echo "✅ $seederClass completed!\n";
            } else {
                echo "❌ $seederClass failed!\n";
            }
            
        } catch (Exception $e) {
            echo "❌ $seederClass error: " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Critical error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n🎉 Seeder issues fixed!\n";
echo "\n📝 Next steps:\n";
echo "   1. Check admin panel: /admin/extracurriculars/registrations.page\n";
echo "   2. Check study programs: /admin/study-programs\n";
echo "   3. Test the complete system\n";

echo "\n✨ Done!\n";