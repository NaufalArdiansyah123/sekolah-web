<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Schema, DB, Artisan};

class FixDuplicateIndexMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:duplicate-index 
                            {--reset : Reset migration status}
                            {--clean : Clean up duplicate indexes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix duplicate index issue in settings migration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing Duplicate Index Migration Issue...');
        $this->info('==========================================');
        
        $reset = $this->option('reset');
        $clean = $this->option('clean');
        
        try {
            if ($reset) {
                $this->resetMigrationStatus();
            }
            
            if ($clean) {
                $this->cleanDuplicateIndexes();
            }
            
            $this->fixMigrationIssue();
            $this->verifyFix();
            
            $this->info('');
            $this->info('🎉 Duplicate index fix completed successfully!');
            $this->info('📊 You can now run: php artisan migrate');
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Reset migration status
     */
    private function resetMigrationStatus(): void
    {
        $this->info('🔄 Resetting migration status...');
        
        $migrations = [
            '2024_12_21_000002_create_settings_table_if_not_exists',
            '2024_12_21_000003_update_settings_table_for_school'
        ];
        
        foreach ($migrations as $migration) {
            DB::table('migrations')->where('migration', $migration)->delete();
            $this->info("  ✅ Reset: {$migration}");
        }
    }
    
    /**
     * Clean duplicate indexes
     */
    private function cleanDuplicateIndexes(): void
    {
        $this->info('🧹 Cleaning duplicate indexes...');
        
        if (!Schema::hasTable('settings')) {
            $this->warn('  ⚠️  Settings table not found, skipping index cleanup');
            return;
        }
        
        try {
            // Get existing indexes
            $indexes = DB::select("SHOW INDEX FROM settings");
            $indexNames = collect($indexes)->pluck('Key_name')->unique()->toArray();
            
            $this->info("  📋 Found indexes: " . implode(', ', $indexNames));
            
            // Drop problematic indexes if they exist
            $problematicIndexes = [
                'settings_group_key_index',
                'settings_type_index'
            ];
            
            foreach ($problematicIndexes as $indexName) {
                if (in_array($indexName, $indexNames)) {
                    try {
                        DB::statement("DROP INDEX {$indexName} ON settings");
                        $this->info("  ✅ Dropped index: {$indexName}");
                    } catch (\Exception $e) {
                        $this->warn("  ⚠️  Could not drop index {$indexName}: " . $e->getMessage());
                    }
                }
            }
            
        } catch (\Exception $e) {
            $this->warn("  ⚠️  Index cleanup failed: " . $e->getMessage());
        }
    }
    
    /**
     * Fix the main migration issue
     */
    private function fixMigrationIssue(): void
    {
        $this->info('🔧 Fixing migration issue...');
        
        // Ensure settings table exists with correct structure
        if (!Schema::hasTable('settings')) {
            $this->info('  📋 Creating settings table...');
            
            Schema::create('settings', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('string');
                $table->string('group')->default('general');
                $table->text('description')->nullable();
                $table->timestamps();
            });
            
            $this->info('  ✅ Settings table created');
        } else {
            $this->info('  ✅ Settings table already exists');
            
            // Add missing columns
            $this->addMissingColumns();
        }
        
        // Add indexes safely
        $this->addIndexesSafely();
        
        // Insert default settings
        $this->insertDefaultSettings();
        
        // Mark migrations as completed
        $this->markMigrationsCompleted();
    }
    
    /**
     * Add missing columns
     */
    private function addMissingColumns(): void
    {
        $columns = [
            'type' => 'string',
            'group' => 'string', 
            'description' => 'text'
        ];
        
        foreach ($columns as $column => $type) {
            if (!Schema::hasColumn('settings', $column)) {
                Schema::table('settings', function ($table) use ($column, $type) {
                    if ($type === 'text') {
                        $table->text($column)->nullable();
                    } else {
                        $table->string($column)->default($column === 'type' ? 'string' : 'general');
                    }
                });
                $this->info("  ✅ Added column: {$column}");
            }
        }
    }
    
    /**
     * Add indexes safely
     */
    private function addIndexesSafely(): void
    {
        $this->info('  🔗 Adding indexes safely...');
        
        try {
            $indexes = DB::select("SHOW INDEX FROM settings");
            $existingIndexes = collect($indexes)->pluck('Key_name')->toArray();
            
            // Add group+key index
            if (!in_array('settings_group_key_index', $existingIndexes)) {
                DB::statement("CREATE INDEX settings_group_key_index ON settings (`group`, `key`)");
                $this->info("    ✅ Added group+key index");
            } else {
                $this->info("    ✅ Group+key index already exists");
            }
            
            // Add type index
            if (!in_array('settings_type_index', $existingIndexes)) {
                DB::statement("CREATE INDEX settings_type_index ON settings (`type`)");
                $this->info("    ✅ Added type index");
            } else {
                $this->info("    ✅ Type index already exists");
            }
            
        } catch (\Exception $e) {
            $this->warn("    ⚠️  Index creation warning: " . $e->getMessage());
        }
    }
    
    /**
     * Insert default settings
     */
    private function insertDefaultSettings(): void
    {
        $count = DB::table('settings')->count();
        
        if ($count === 0) {
            $this->info('  📝 Inserting default settings...');
            
            $defaultSettings = [
                ['key' => 'school_name', 'value' => 'SMA Negeri 1 Balong', 'type' => 'string', 'group' => 'school', 'description' => 'Nama resmi sekolah'],
                ['key' => 'academic_year', 'value' => '2024/2025', 'type' => 'string', 'group' => 'academic', 'description' => 'Tahun ajaran aktif'],
                ['key' => 'semester', 'value' => '1', 'type' => 'integer', 'group' => 'academic', 'description' => 'Semester aktif'],
                ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'system', 'description' => 'Mode pemeliharaan'],
            ];
            
            foreach ($defaultSettings as $setting) {
                DB::table('settings')->insert($setting + ['created_at' => now(), 'updated_at' => now()]);
            }
            
            $this->info("    ✅ Inserted " . count($defaultSettings) . " default settings");
        } else {
            $this->info("  ✅ Settings already exist ({$count} records)");
        }
    }
    
    /**
     * Mark migrations as completed
     */
    private function markMigrationsCompleted(): void
    {
        $migrations = [
            '2024_12_21_000002_create_settings_table_if_not_exists',
            '2024_12_21_000003_update_settings_table_for_school'
        ];
        
        $maxBatch = DB::table('migrations')->max('batch') ?? 0;
        
        foreach ($migrations as $migration) {
            $exists = DB::table('migrations')->where('migration', $migration)->exists();
            
            if (!$exists) {
                DB::table('migrations')->insert([
                    'migration' => $migration,
                    'batch' => $maxBatch + 1
                ]);
                $this->info("  ✅ Marked as completed: {$migration}");
            }
        }
    }
    
    /**
     * Verify the fix
     */
    private function verifyFix(): void
    {
        $this->info('');
        $this->info('🔍 Verifying fix...');
        
        // Check table
        if (Schema::hasTable('settings')) {
            $this->info('  ✅ Settings table exists');
        } else {
            $this->error('  ❌ Settings table missing');
            return;
        }
        
        // Check columns
        $requiredColumns = ['id', 'key', 'value', 'type', 'group', 'description'];
        foreach ($requiredColumns as $column) {
            if (Schema::hasColumn('settings', $column)) {
                $this->info("  ✅ Column '{$column}' exists");
            } else {
                $this->warn("  ⚠️  Column '{$column}' missing");
            }
        }
        
        // Check indexes
        try {
            $indexes = DB::select("SHOW INDEX FROM settings");
            $indexNames = collect($indexes)->pluck('Key_name')->unique()->filter()->toArray();
            $this->info("  📋 Indexes: " . implode(', ', $indexNames));
        } catch (\Exception $e) {
            $this->warn("  ⚠️  Could not check indexes: " . $e->getMessage());
        }
        
        // Check data
        $count = DB::table('settings')->count();
        $this->info("  📊 Settings count: {$count}");
        
        // Check migrations
        $completedMigrations = DB::table('migrations')
            ->whereIn('migration', [
                '2024_12_21_000002_create_settings_table_if_not_exists',
                '2024_12_21_000003_update_settings_table_for_school'
            ])
            ->count();
        
        $this->info("  ✅ Completed migrations: {$completedMigrations}/2");
    }
}