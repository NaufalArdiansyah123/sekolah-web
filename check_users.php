<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 Checking Users Table...\n\n";

try {
    // Check if users table exists
    $users = DB::table('users')->select('id', 'name', 'email')->get();
    
    if ($users->count() > 0) {
        echo "📋 Available Users:\n";
        foreach ($users as $user) {
            echo "   ID: {$user->id} - {$user->name} ({$user->email})\n";
        }
        
        echo "\n✅ Total users: " . $users->count() . "\n";
        
        // Get admin users
        $adminUsers = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'admin')
            ->select('users.id', 'users.name', 'users.email')
            ->get();
            
        if ($adminUsers->count() > 0) {
            echo "\n👑 Admin Users:\n";
            foreach ($adminUsers as $admin) {
                echo "   ID: {$admin->id} - {$admin->name} ({$admin->email})\n";
            }
        } else {
            echo "\n⚠️  No admin users found!\n";
        }
        
    } else {
        echo "❌ No users found in database!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n✨ Done!\n";