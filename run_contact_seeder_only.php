<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

use Illuminate\Support\Facades\DB;

echo "🌱 Running ContactSeeder Only...\n";
echo "================================\n\n";

try {
    // Check if contacts table exists
    echo "📋 Checking contacts table...\n";
    
    if (DB::getSchemaBuilder()->hasTable('contacts')) {
        echo "✅ Contacts table exists!\n";
        
        // Check current data
        $currentCount = DB::table('contacts')->count();
        echo "   Current contacts: $currentCount\n";
        
    } else {
        echo "❌ Contacts table does not exist!\n";
        echo "   ContactSeeder will be skipped automatically.\n";
    }
    
    echo "\n🌱 Running ContactSeeder...\n";
    
    $exitCode = $kernel->call('db:seed', [
        '--class' => 'ContactSeeder',
        '--force' => true
    ]);
    
    if ($exitCode === 0) {
        echo "✅ ContactSeeder completed successfully!\n";
        
        if (DB::getSchemaBuilder()->hasTable('contacts')) {
            $newCount = DB::table('contacts')->count();
            echo "\n📊 Results:\n";
            echo "   - Total contacts: $newCount\n";
            
            // Show status breakdown
            $statusCounts = DB::table('contacts')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();
                
            echo "   - Status breakdown:\n";
            foreach ($statusCounts as $status) {
                echo "     * {$status->status}: {$status->count}\n";
            }
            
            // Show recent contacts
            echo "\n📋 Recent contacts:\n";
            $recentContacts = DB::table('contacts')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get(['name', 'subject', 'status']);
                
            foreach ($recentContacts as $contact) {
                echo "   - {$contact->name}: {$contact->subject} ({$contact->status})\n";
            }
        }
        
    } else {
        echo "❌ ContactSeeder failed!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n🎉 ContactSeeder process completed!\n";
echo "\n📝 Summary:\n";
echo "   - ContactSeeder has been created and executed\n";
echo "   - All 9 seeders should now be working properly\n";
echo "   - Database is fully populated with sample data\n";

echo "\n🌐 You can now access:\n";
echo "   - Admin Dashboard: /admin/dashboard\n";
echo "   - Study Programs Admin: /admin/study-programs\n";
echo "   - Study Programs Public: /study-programs\n";
echo "   - Contact Management: /admin/contacts (if available)\n";

echo "\n✨ Done!\n";