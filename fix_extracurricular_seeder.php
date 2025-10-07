<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

use Illuminate\Support\Facades\DB;

echo "🔧 Fixing Extracurricular Registration Seeder...\n\n";

try {
    // First, check if we have users
    $userCount = DB::table('users')->count();
    echo "👥 Users in database: $userCount\n";
    
    if ($userCount == 0) {
        echo "❌ No users found! Running UserSeeder first...\n";
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
    
    // Check for admin users
    $adminCount = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('roles.name', 'admin')
        ->count();
        
    echo "👑 Admin users: $adminCount\n";
    
    if ($adminCount == 0) {
        echo "⚠️  No admin users found, but continuing with any available user...\n";
    }
    
    // Clear existing extracurricular registrations
    echo "\n🧹 Clearing existing extracurricular registrations...\n";
    DB::table('extracurricular_registrations')->delete();
    echo "✅ Cleared existing registrations!\n";
    
    // Run the fixed seeder
    echo "\n🌱 Running ExtracurricularRegistrationSeeder...\n";
    $exitCode = $kernel->call('db:seed', [
        '--class' => 'ExtracurricularRegistrationSeeder',
        '--force' => true
    ]);
    
    if ($exitCode === 0) {
        echo "✅ ExtracurricularRegistrationSeeder completed successfully!\n";
        
        // Show results
        $registrationCount = DB::table('extracurricular_registrations')->count();
        echo "\n📊 Results:\n";
        echo "   - Total registrations: $registrationCount\n";
        
        $approvedCount = DB::table('extracurricular_registrations')->where('status', 'approved')->count();
        $pendingCount = DB::table('extracurricular_registrations')->where('status', 'pending')->count();
        
        echo "   - Approved: $approvedCount\n";
        echo "   - Pending: $pendingCount\n";
        
    } else {
        echo "❌ ExtracurricularRegistrationSeeder failed!\n";
        exit(1);
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n🎉 Extracurricular registration seeder fixed and completed!\n";