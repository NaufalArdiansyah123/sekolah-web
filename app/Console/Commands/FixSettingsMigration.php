<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Schema, DB, Artisan};

class FixSettingsMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:settings-migration 
                            {--force : Force fix even if table exists}
                            {--reset : Reset and recreate settings table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the settings table migration dependency issue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing Settings Migration Issue...');
        $this->info('=====================================');
        
        $force = $this->option('force');
        $reset = $this->option('reset');
        
        try {
            // Step 1: Handle table creation
            if ($reset) {
                $this->handleReset();
            } else {
                $this->handleTableCreation($force);
            }
            
            // Step 2: Mark migration as completed
            $this->markMigrationCompleted();
            
            // Step 3: Insert default settings
            $this->insertDefaultSettings();
            
            // Step 4: Verify fix
            $this->verifyFix();
            
            $this->info('');
            $this->info('🎉 Settings migration fix completed successfully!');
            $this->info('📊 You can now run: php artisan migrate');
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            $this->error("📋 Run with --force or --reset for more aggressive fixing");
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Handle table creation
     */
    private function handleTableCreation(bool $force): void
    {
        if (!Schema::hasTable('settings')) {
            $this->info('📋 Creating settings table...');
            
            Schema::create('settings', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('string');
                $table->string('group')->default('general');
                $table->text('description')->nullable();
                $table->timestamps();
                
                // Add indexes
                $table->index(['group', 'key']);
                $table->index('type');
            });
            
            $this->info('✅ Settings table created successfully!');
        } else {
            $this->info('✅ Settings table already exists');
            
            if ($force) {
                $this->info('🔄 Force mode: Checking and adding missing columns...');
                $this->addMissingColumns();
            }
        }
    }
    
    /**
     * Handle reset option
     */
    private function handleReset(): void
    {
        if (Schema::hasTable('settings')) {
            if ($this->confirm('⚠️  This will drop and recreate the settings table. Continue?', false)) {
                $this->info('🗑️  Dropping existing settings table...');
                Schema::dropIfExists('settings');
                $this->info('✅ Settings table dropped');
            } else {
                $this->info('Operation cancelled');
                return;
            }
        }
        
        $this->handleTableCreation(false);
    }
    
    /**
     * Add missing columns to existing table
     */
    private function addMissingColumns(): void
    {
        Schema::table('settings', function ($table) {
            if (!Schema::hasColumn('settings', 'type')) {
                $table->string('type')->default('string')->after('value');
                $this->info('  ✅ Added type column');
            }
            
            if (!Schema::hasColumn('settings', 'group')) {
                $table->string('group')->default('general')->after('type');
                $this->info('  ✅ Added group column');
            }
            
            if (!Schema::hasColumn('settings', 'description')) {
                $table->text('description')->nullable()->after('group');
                $this->info('  ✅ Added description column');
            }
        });
        
        // Add indexes if they don't exist
        try {
            Schema::table('settings', function ($table) {
                $table->index(['group', 'key']);
            });
            $this->info('  ✅ Added group+key index');
        } catch (\Exception $e) {
            $this->warn('  ⚠️  Group+key index might already exist');
        }
        
        try {
            Schema::table('settings', function ($table) {
                $table->index('type');
            });
            $this->info('  ✅ Added type index');
        } catch (\Exception $e) {
            $this->warn('  ⚠️  Type index might already exist');
        }
    }
    
    /**
     * Mark migration as completed
     */
    private function markMigrationCompleted(): void
    {
        $migrationName = '2024_12_21_000003_update_settings_table_for_school';
        $exists = DB::table('migrations')->where('migration', $migrationName)->exists();
        
        if (!$exists) {
            DB::table('migrations')->insert([
                'migration' => $migrationName,
                'batch' => DB::table('migrations')->max('batch') + 1
            ]);
            $this->info("✅ Marked migration as completed: {$migrationName}");
        } else {
            $this->info('✅ Migration already marked as completed');
        }
    }
    
    /**
     * Insert default settings
     */
    private function insertDefaultSettings(): void
    {
        $settingsCount = DB::table('settings')->count();
        
        if ($settingsCount === 0) {
            $this->info('📝 Inserting default settings...');
            
            $defaultSettings = [
                // School Information
                ['key' => 'school_name', 'value' => 'SMA Negeri 1 Balong', 'type' => 'string', 'group' => 'school', 'description' => 'Nama resmi sekolah'],
                ['key' => 'school_address', 'value' => 'Jl. Pendidikan No. 1, Balong', 'type' => 'string', 'group' => 'school', 'description' => 'Alamat lengkap sekolah'],
                ['key' => 'school_phone', 'value' => '(0274) 123456', 'type' => 'string', 'group' => 'school', 'description' => 'Nomor telepon sekolah'],
                ['key' => 'school_email', 'value' => 'info@sman1balong.sch.id', 'type' => 'email', 'group' => 'school', 'description' => 'Email resmi sekolah'],
                ['key' => 'school_website', 'value' => 'https://sman1balong.sch.id', 'type' => 'url', 'group' => 'school', 'description' => 'Website resmi sekolah'],
                ['key' => 'principal_name', 'value' => 'Drs. Ahmad Suryanto, M.Pd', 'type' => 'string', 'group' => 'school', 'description' => 'Nama kepala sekolah'],
                
                // Academic Settings
                ['key' => 'academic_year', 'value' => '2024/2025', 'type' => 'string', 'group' => 'academic', 'description' => 'Tahun ajaran aktif'],
                ['key' => 'semester', 'value' => '1', 'type' => 'integer', 'group' => 'academic', 'description' => 'Semester aktif (1 atau 2)'],
                ['key' => 'school_timezone', 'value' => 'Asia/Jakarta', 'type' => 'string', 'group' => 'academic', 'description' => 'Zona waktu sekolah'],
                
                // System Settings
                ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'system', 'description' => 'Mode pemeliharaan sistem'],
                ['key' => 'allow_registration', 'value' => '1', 'type' => 'boolean', 'group' => 'system', 'description' => 'Izinkan pendaftaran user baru'],
                ['key' => 'max_upload_size', 'value' => '10', 'type' => 'integer', 'group' => 'system', 'description' => 'Ukuran maksimal upload (MB)'],
            ];
            
            foreach ($defaultSettings as $setting) {
                DB::table('settings')->updateOrInsert(
                    ['key' => $setting['key']],
                    $setting + ['created_at' => now(), 'updated_at' => now()]
                );
            }
            
            $this->info("✅ Inserted {" . count($defaultSettings) . "} default settings");
        } else {
            $this->info("✅ Settings already exist ({$settingsCount} records)");
        }
    }
    
    /**
     * Verify the fix
     */
    private function verifyFix(): void
    {
        $this->info('');
        $this->info('🔍 Verifying fix...');
        
        // Check table exists
        if (Schema::hasTable('settings')) {
            $this->info('  ✅ Settings table exists');
        } else {
            $this->error('  ❌ Settings table missing');
            return;
        }
        
        // Check columns
        $requiredColumns = ['id', 'key', 'value', 'type', 'group', 'description', 'created_at', 'updated_at'];
        foreach ($requiredColumns as $column) {
            if (Schema::hasColumn('settings', $column)) {
                $this->info("  ✅ Column '{$column}' exists");
            } else {
                $this->warn("  ⚠️  Column '{$column}' missing");
            }
        }
        
        // Check data
        $settingsCount = DB::table('settings')->count();
        $this->info("  📊 Settings count: {$settingsCount}");
        
        // Check migration status
        $migrationExists = DB::table('migrations')
            ->where('migration', '2024_12_21_000003_update_settings_table_for_school')
            ->exists();
        
        if ($migrationExists) {
            $this->info('  ✅ Migration marked as completed');
        } else {
            $this->warn('  ⚠️  Migration not marked as completed');
        }
    }
}