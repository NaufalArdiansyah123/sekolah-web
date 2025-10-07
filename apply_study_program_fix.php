<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "🔧 Applying StudyProgram Fix...\n";
echo "===============================\n\n";

try {
    // Step 1: Clear all caches
    echo "📋 Step 1: Clearing Caches\n";
    echo "---------------------------\n";
    
    echo "🧹 Clearing config cache...\n";
    $kernel->call('config:clear');
    echo "✅ Config cache cleared!\n";
    
    echo "🧹 Clearing route cache...\n";
    $kernel->call('route:clear');
    echo "✅ Route cache cleared!\n";
    
    echo "🧹 Clearing view cache...\n";
    $kernel->call('view:clear');
    echo "✅ View cache cleared!\n";
    
    echo "🧹 Clearing application cache...\n";
    $kernel->call('cache:clear');
    echo "✅ Application cache cleared!\n";
    
    echo "\n";
    
    // Step 2: Test the fix
    echo "📋 Step 2: Testing Fix\n";
    echo "----------------------\n";
    
    // Include the test script
    include 'test_study_program_fix.php';
    
} catch (Exception $e) {
    echo "❌ Error applying fix: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n🎉 StudyProgram fix applied successfully!\n";
echo "\n📝 What was fixed:\n";
echo "   ❌ OLD: StudyProgram::active()->getAvailableFaculties()\n";
echo "   ✅ NEW: StudyProgram::getAvailableFaculties()\n";
echo "\n💡 Explanation:\n";
echo "   - getAvailableFaculties() is a static method\n";
echo "   - It should be called directly on the model class\n";
echo "   - Not on a query builder instance\n";
echo "   - The method now filters for active programs internally\n";

echo "\n✨ Fix completed!\n";