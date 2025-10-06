<?php

/**
 * Quick Fix Script for Student Registration Data
 * 
 * This script will ensure ALL student users have complete data
 * for class, parent information, and other required fields.
 * 
 * Usage: php fix-student-data.php
 */

// Include Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the application
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🚀 STUDENT DATA FIX SCRIPT\n";
echo "==========================\n\n";

echo "This script will:\n";
echo "✅ Find all users with student role\n";
echo "✅ Fill missing class data\n";
echo "✅ Fill missing parent information\n";
echo "✅ Fill missing NIS, birth place, religion, etc.\n";
echo "✅ Ensure all data is complete for student registration page\n\n";

echo "🔄 Starting process...\n\n";

try {
    // Run the seeder
    $seeder = new Database\Seeders\CompleteStudentDataSeeder();
    $seeder->run();
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "🎉 STUDENT DATA FIX COMPLETED!\n";
    echo str_repeat("=", 50) . "\n\n";
    
    echo "✅ What was fixed:\n";
    echo "   - All student users now have class information\n";
    echo "   - All student users now have parent information\n";
    echo "   - All student users now have complete profile data\n";
    echo "   - Student registration page will show all columns correctly\n\n";
    
    echo "🎯 Next steps:\n";
    echo "   1. Go to Admin Panel > Student Registrations\n";
    echo "   2. Check that Class and Parent Name columns now show data\n";
    echo "   3. Test filtering, searching, and bulk actions\n\n";
    
    echo "📧 Sample student emails to check:\n";
    echo "   - ahmad.rizki@student.test\n";
    echo "   - siti.nurhaliza@student.test\n";
    echo "   - student@sman99.sch.id (original demo account)\n\n";
    
    echo "🔑 All accounts use password: 'password'\n\n";
    
} catch (Exception $e) {
    echo "❌ Error running fix script: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}