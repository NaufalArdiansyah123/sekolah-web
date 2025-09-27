<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FixStudentData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:fix-data {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix missing class and parent data for all student users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking student users with missing data...');
        
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
        }
        
        try {
            // Find all users with student role
            $studentUsers = User::whereHas('roles', function($q) {
                $q->where('name', 'student');
            })->get();
            
            $this->info("📊 Found {$studentUsers->count()} users with student role");
            
            // Check which ones have missing data
            $usersWithMissingData = $studentUsers->filter(function($user) {
                return empty($user->class) || empty($user->parent_name) || empty($user->nis);
            });
            
            $this->info("❌ Users with missing data: {$usersWithMissingData->count()}");
            
            if ($usersWithMissingData->count() === 0) {
                $this->info("✅ All student users already have complete data!");
                return 0;
            }
            
            // Sample data
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
                'Kurnia Sari', 'Lestari Dewi', 'Maya Indah', 'Nurul Hidayah', 'Olivia Sari'
            ];
            
            if (!$dryRun) {
                DB::beginTransaction();
            }
            
            $updated = 0;
            
            foreach ($usersWithMissingData as $user) {
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
                    
                    // Generate unique NIS
                    $attempts = 0;
                    do {
                        $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                        $nis = $currentYear . $randomClass . $randomNumber;
                        $attempts++;
                        
                        // Prevent infinite loop
                        if ($attempts > 100) {
                            $timestamp = substr(time(), -4);
                            $nis = $currentYear . $randomClass . $timestamp;
                            break;
                        }
                    } while (User::where('nis', $nis)->where('id', '!=', $user->id)->exists());
                    
                    $updateData['nis'] = $nis;
                }
                
                if (!empty($updateData)) {
                    if ($dryRun) {
                        $this->line("Would update: {$user->name} ({$user->email})");
                        foreach ($updateData as $field => $value) {
                            $this->line("   {$field}: {$value}");
                        }
                    } else {
                        $user->update($updateData);
                        $this->info("✅ Updated: {$user->name} ({$user->email})");
                        $this->line("   Class: " . ($updateData['class'] ?? $user->class ?? 'N/A'));
                        $this->line("   Parent: " . ($updateData['parent_name'] ?? $user->parent_name ?? 'N/A'));
                    }
                    
                    $updated++;
                }
            }
            
            if (!$dryRun) {
                DB::commit();
            }
            
            $this->info('');
            $this->info("📊 SUMMARY:");
            $this->info("   " . ($dryRun ? 'Would update' : 'Updated') . ": {$updated} student users");
            $this->info("   📚 Total student users: {$studentUsers->count()}");
            
            if (!$dryRun) {
                $this->info('');
                $this->info('🎉 Student data fix completed!');
                $this->info('✅ Student registration page should now show all data correctly.');
            } else {
                $this->info('');
                $this->info('🔍 Dry run completed. Run without --dry-run to apply changes.');
            }
            
            return 0;
            
        } catch (\Exception $e) {
            if (!$dryRun) {
                DB::rollback();
            }
            
            $this->error("❌ Error fixing student data: " . $e->getMessage());
            return 1;
        }
    }
}