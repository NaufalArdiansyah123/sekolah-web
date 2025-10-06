<?php

/**
 * Script to update existing student users with missing class and parent data
 * 
 * This script will find all users with student role that have empty
 * class or parent_name fields and populate them with sample data.
 * 
 * Usage: php update-student-data.php
 */

// Include Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the application
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "🔍 Checking student users with missing data...\n\n";

try {
    // Find all users with student role
    $studentUsers = User::whereHas('roles', function($q) {
        $q->where('name', 'student');
    })->get();
    
    echo "📊 Found {$studentUsers->count()} users with student role\n";
    
    // Check which ones have missing data
    $usersWithMissingClass = $studentUsers->filter(function($user) {
        return empty($user->class);
    });
    
    $usersWithMissingParent = $studentUsers->filter(function($user) {
        return empty($user->parent_name);
    });
    
    echo "❌ Users missing class data: {$usersWithMissingClass->count()}\n";
    echo "❌ Users missing parent data: {$usersWithMissingParent->count()}\n\n";
    
    if ($usersWithMissingClass->count() === 0 && $usersWithMissingParent->count() === 0) {
        echo "✅ All student users already have complete data!\n";
        exit(0);
    }
    
    // Sample data for updating
    $classes = [
        'X TKJ 1', 'X TKJ 2', 'X TKJ 3',
        'X RPL 1', 'X RPL 2', 'X RPL 3',
        'X DKV 1', 'X DKV 2',
        'XI TKJ 1', 'XI TKJ 2', 'XI TKJ 3',
        'XI RPL 1', 'XI RPL 2', 'XI RPL 3',
        'XI DKV 1', 'XI DKV 2',
        'XII TKJ 1', 'XII TKJ 2', 'XII TKJ 3',
        'XII RPL 1', 'XII RPL 2', 'XII RPL 3',
        'XII DKV 1', 'XII DKV 2'
    ];
    
    $parentNames = [
        'Ahmad Suryanto', 'Budi Santoso', 'Candra Wijaya', 'Dedi Kurniawan', 'Eko Prasetyo',
        'Fajar Rahman', 'Gunawan Saputra', 'Hendra Kusuma', 'Indra Permana', 'Joko Susilo',
        'Kurnia Sari', 'Lestari Dewi', 'Maya Indah', 'Nurul Hidayah', 'Olivia Sari',
        'Putri Maharani', 'Qori Amelia', 'Ratna Sari', 'Siti Aminah', 'Tuti Handayani',
        'Umi Kalsum', 'Vina Panduwinata', 'Wulan Guritno', 'Yuni Shara', 'Zaskia Gotik'
    ];
    
    $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];
    $birthPlaces = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar', 'Palembang', 'Denpasar', 'Balikpapan'];
    
    echo "🔄 Starting to update users with missing data...\n\n";
    
    DB::beginTransaction();
    
    $updated = 0;
    
    // Get all student users that need updating
    $usersToUpdate = $studentUsers->filter(function($user) {
        return empty($user->class) || empty($user->parent_name) || empty($user->nis) || empty($user->birth_place) || empty($user->religion);
    });
    
    foreach ($usersToUpdate as $user) {
        $updateData = [];
        
        // Add class if missing
        if (empty($user->class)) {
            $updateData['class'] = $classes[array_rand($classes)];
        }
        
        // Add parent data if missing
        if (empty($user->parent_name)) {
            $parentName = $parentNames[array_rand($parentNames)];
            $updateData['parent_name'] = $parentName;
            $updateData['parent_phone'] = '08' . rand(1000000000, 9999999999);
            $updateData['parent_email'] = strtolower(str_replace(' ', '.', $parentName)) . '@gmail.com';
        }
        
        // Add NIS if missing
        if (empty($user->nis)) {
            $currentYear = date('Y');
            $randomClass = rand(10, 12);
            $randomNumber = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $updateData['nis'] = $currentYear . $randomClass . $randomNumber;
        }
        
        // Add birth place if missing
        if (empty($user->birth_place)) {
            $updateData['birth_place'] = $birthPlaces[array_rand($birthPlaces)];
        }
        
        // Add religion if missing
        if (empty($user->religion)) {
            $updateData['religion'] = $religions[array_rand($religions)];
        }
        
        // Add birth date if missing
        if (empty($user->birth_date)) {
            $age = rand(15, 18);
            $birthYear = date('Y') - $age;
            $updateData['birth_date'] = $birthYear . '-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
        }
        
        // Add phone if missing
        if (empty($user->phone)) {
            $updateData['phone'] = '08' . rand(1000000000, 9999999999);
        }
        
        // Add address if missing
        if (empty($user->address)) {
            $streets = ['Jl. Merdeka', 'Jl. Sudirman', 'Jl. Diponegoro', 'Jl. Ahmad Yani', 'Jl. Gatot Subroto'];
            $updateData['address'] = $streets[array_rand($streets)] . ' No. ' . rand(1, 200) . ', ' . $birthPlaces[array_rand($birthPlaces)];
        }
        
        // Add gender if missing
        if (empty($user->gender)) {
            $updateData['gender'] = rand(0, 1) ? 'male' : 'female';
        }
        
        if (!empty($updateData)) {
            $user->update($updateData);
            
            echo "✅ Updated: {$user->name} ({$user->email})\n";
            echo "   Class: " . ($updateData['class'] ?? $user->class ?? 'N/A') . "\n";
            echo "   Parent: " . ($updateData['parent_name'] ?? $user->parent_name ?? 'N/A') . "\n";
            echo "   NIS: " . ($updateData['nis'] ?? $user->nis ?? 'N/A') . "\n\n";
            
            $updated++;
        }
    }
    
    DB::commit();
    
    echo "📊 SUMMARY:\n";
    echo "   ✅ Updated: {$updated} student users\n";
    echo "   📚 Total student users: {$studentUsers->count()}\n\n";
    
    // Verify the updates
    echo "🔍 Verifying updates...\n";
    
    $studentsAfterUpdate = User::whereHas('roles', function($q) {
        $q->where('name', 'student');
    })->get();
    
    $stillMissingClass = $studentsAfterUpdate->filter(function($user) {
        return empty($user->class);
    })->count();
    
    $stillMissingParent = $studentsAfterUpdate->filter(function($user) {
        return empty($user->parent_name);
    })->count();
    
    echo "   📚 Users still missing class: {$stillMissingClass}\n";
    echo "   👨‍👩‍👧‍👦 Users still missing parent: {$stillMissingParent}\n\n";
    
    if ($stillMissingClass === 0 && $stillMissingParent === 0) {
        echo "🎉 All student users now have complete data!\n";
        echo "✅ You can now check the student registrations page - all columns should show data.\n";
    } else {
        echo "⚠️  Some users still have missing data. You may need to check manually.\n";
    }
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error updating student data: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}