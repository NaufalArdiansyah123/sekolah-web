<?php

/**
 * Fix Duplicate NIS Script
 * 
 * This script will find and fix duplicate NIS values in the users table
 * 
 * Usage: php fix-duplicate-nis.php
 */

// Include Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the application
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "🔍 FIXING DUPLICATE NIS VALUES\n";
echo "===============================\n\n";

try {
    // Find duplicate NIS values
    $duplicateNis = DB::table('users')
        ->select('nis', DB::raw('COUNT(*) as count'))
        ->whereNotNull('nis')
        ->where('nis', '!=', '')
        ->groupBy('nis')
        ->having('count', '>', 1)
        ->get();
    
    echo "📊 Found " . $duplicateNis->count() . " duplicate NIS values\n\n";
    
    if ($duplicateNis->count() === 0) {
        echo "✅ No duplicate NIS found!\n";
        
        // Now run the student data fix
        echo "\n🔄 Running student data fix...\n\n";
        $seeder = new Database\Seeders\CompleteStudentDataSeeder();
        $seeder->run();
        
        exit(0);
    }
    
    DB::beginTransaction();
    
    $fixed = 0;
    
    foreach ($duplicateNis as $duplicate) {
        echo "🔧 Fixing NIS: {$duplicate->nis} (found {$duplicate->count} times)\n";
        
        // Get all users with this NIS
        $users = User::where('nis', $duplicate->nis)->get();
        
        // Keep the first one, fix the others
        $first = true;
        foreach ($users as $user) {
            if ($first) {
                echo "   ✅ Keeping: {$user->name} (ID: {$user->id})\n";
                $first = false;
                continue;
            }
            
            // Generate new unique NIS
            $currentYear = date('Y');
            $randomClass = rand(10, 12);
            
            $attempts = 0;
            do {
                $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $newNis = $currentYear . $randomClass . $randomNumber;
                $attempts++;
                
                // Prevent infinite loop
                if ($attempts > 100) {
                    $timestamp = substr(time(), -4);
                    $newNis = $currentYear . $randomClass . $timestamp . rand(10, 99);
                    break;
                }
            } while (User::where('nis', $newNis)->exists());
            
            // Update the user
            $user->update(['nis' => $newNis]);
            
            echo "   🔄 Updated: {$user->name} (ID: {$user->id}) -> New NIS: {$newNis}\n";
            $fixed++;
        }
        
        echo "\n";
    }
    
    DB::commit();
    
    echo "📊 SUMMARY:\n";
    echo "   ✅ Fixed: {$fixed} duplicate NIS values\n";
    echo "   📚 Total duplicates resolved: " . $duplicateNis->count() . "\n\n";
    
    // Verify no more duplicates
    $remainingDuplicates = DB::table('users')
        ->select('nis', DB::raw('COUNT(*) as count'))
        ->whereNotNull('nis')
        ->where('nis', '!=', '')
        ->groupBy('nis')
        ->having('count', '>', 1)
        ->count();
    
    if ($remainingDuplicates === 0) {
        echo "🎉 All NIS duplicates have been resolved!\n\n";
        
        // Now run the student data fix
        echo "🔄 Running student data fix...\n\n";
        $seeder = new Database\Seeders\CompleteStudentDataSeeder();
        $seeder->run();
        
    } else {
        echo "⚠️  Still have {$remainingDuplicates} duplicate NIS values. Manual intervention may be needed.\n";
    }
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error fixing duplicate NIS: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}