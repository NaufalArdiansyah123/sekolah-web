<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Schema, DB, Artisan};

class FixAllMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:all-migrations 
                            {--reset : Reset all problematic migrations}
                            {--force : Force fix even if tables exist}
                            {--dry-run : Show what would be done without executing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix all migration dependency issues (settings, agendas, extracurriculars)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing All Migration Issues...');
        $this->info('==================================');
        
        $dryRun = $this->option('dry-run');
        $reset = $this->option('reset');
        $force = $this->option('force');
        
        if ($dryRun) {
            $this->info('🔍 DRY RUN MODE - No changes will be made');
            $this->info('');
        }
        
        try {
            // Step 1: Fix Settings Migration
            $this->fixSettingsMigration($dryRun, $reset, $force);
            
            // Step 2: Fix Agendas Migration
            $this->fixAgendasMigration($dryRun, $reset, $force);
            
            // Step 3: Fix Extracurriculars Migration
            $this->fixExtracurricularsMigration($dryRun, $reset, $force);
            
            // Step 4: Fix Quizzes Migration
            $this->fixQuizzesMigration($dryRun, $reset, $force);
            
            // Step 5: Verify all fixes
            if (!$dryRun) {
                $this->verifyAllFixes();
            }
            
            $this->info('');
            $this->info('🎉 All migration fixes completed successfully!');
            if (!$dryRun) {
                $this->info('📊 You can now run: php artisan migrate');
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Fix settings migration
     */
    private function fixSettingsMigration(bool $dryRun, bool $reset, bool $force): void
    {
        $this->info('🔧 1. Fixing Settings Migration...');
        
        if ($dryRun) {
            $this->info('   Would create settings table if not exists');
            $this->info('   Would mark migration as completed');
            return;
        }
        
        if (!Schema::hasTable('settings')) {
            $this->info('   📋 Creating settings table...');
            
            Schema::create('settings', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('string');
                $table->string('group')->default('general');
                $table->text('description')->nullable();
                $table->timestamps();
                
                $table->index(['group', 'key'], 'settings_group_key_index');
                $table->index('type', 'settings_type_index');
            });
            
            $this->info('   ✅ Settings table created');
        } else {
            $this->info('   ✅ Settings table already exists');
        }
        
        // Mark migrations as completed
        $this->markMigrationCompleted('2024_12_21_000002_create_settings_table_if_not_exists');
        $this->markMigrationCompleted('2024_12_21_000003_update_settings_table_for_school');
        
        // Insert default settings if empty
        if (DB::table('settings')->count() === 0) {
            $this->insertDefaultSettings();
        }
    }
    
    /**
     * Fix agendas migration
     */
    private function fixAgendasMigration(bool $dryRun, bool $reset, bool $force): void
    {
        $this->info('🔧 2. Fixing Agendas Migration...');
        
        if ($dryRun) {
            $this->info('   Would create agendas table if not exists');
            $this->info('   Would mark migration as completed');
            return;
        }
        
        if (!Schema::hasTable('agendas')) {
            $this->info('   📋 Creating agendas table...');
            
            Schema::create('agendas', function ($table) {
                $table->id();
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->date('tanggal');
                $table->time('waktu')->nullable();
                $table->string('kategori')->nullable();
                $table->enum('prioritas', ['low', 'medium', 'high'])->default('medium');
                $table->string('lokasi')->nullable();
                $table->string('penanggung_jawab')->nullable();
                $table->timestamps();
                
                $table->index('tanggal');
                $table->index('prioritas');
            });
            
            $this->info('   ✅ Agendas table created');
        } else {
            $this->info('   ✅ Agendas table already exists');
        }
        
        // Mark migrations as completed
        $this->markMigrationCompleted('2024_12_21_000003_create_agendas_table_if_not_exists');
        $this->markMigrationCompleted('2024_12_21_000004_update_agendas_table_for_calendar_integration');
    }
    
    /**
     * Fix extracurriculars migration
     */
    private function fixExtracurricularsMigration(bool $dryRun, bool $reset, bool $force): void
    {
        $this->info('🔧 3. Fixing Extracurriculars Migration...');
        
        if ($dryRun) {
            $this->info('   Would create extracurriculars table if not exists');
            $this->info('   Would mark migration as completed');
            return;
        }
        
        if (!Schema::hasTable('extracurriculars')) {
            $this->info('   📋 Creating extracurriculars table...');
            
            Schema::create('extracurriculars', function ($table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('coach')->nullable();
                $table->string('schedule')->nullable();
                $table->string('location')->nullable();
                $table->integer('max_participants')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->string('image')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();
                
                if (Schema::hasTable('users')) {
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                }
                
                $table->index('status');
                $table->index('name');
            });
            
            $this->info('   ✅ Extracurriculars table created');
        } else {
            $this->info('   ✅ Extracurriculars table already exists');
            
            // Fix status values if needed
            $this->fixExtracurricularStatusValues();
        }
        
        // Mark migration as completed
        $this->markMigrationCompleted('2024_12_21_000006_fix_extracurricular_status_values');
    }
    
    /**
     * Fix quizzes migration
     */
    private function fixQuizzesMigration(bool $dryRun, bool $reset, bool $force): void
    {
        $this->info('🔧 4. Fixing Quizzes Migration...');
        
        if ($dryRun) {
            $this->info('   Would create quizzes table if not exists');
            $this->info('   Would add class column');
            $this->info('   Would mark migration as completed');
            return;
        }
        
        if (!Schema::hasTable('quizzes')) {
            $this->info('   📋 Creating quizzes table...');
            
            Schema::create('quizzes', function ($table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('subject');
                $table->string('class')->nullable(); // Add class field directly
                $table->unsignedBigInteger('teacher_id');
                $table->datetime('start_time');
                $table->datetime('end_time');
                $table->integer('duration_minutes');
                $table->integer('max_attempts')->default(1);
                $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
                $table->text('instructions')->nullable();
                $table->boolean('show_results')->default(true);
                $table->boolean('randomize_questions')->default(false);
                $table->timestamps();
                $table->softDeletes();

                if (Schema::hasTable('users')) {
                    $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
                }
                
                $table->index(['status', 'start_time', 'end_time']);
                $table->index(['teacher_id', 'subject']);
                $table->index('class');
            });
            
            $this->info('   ✅ Quizzes table created with class field');
        } else {
            $this->info('   ✅ Quizzes table already exists');
            
            // Add class column if it doesn't exist
            if (!Schema::hasColumn('quizzes', 'class')) {
                Schema::table('quizzes', function ($table) {
                    $table->string('class')->nullable()->after('subject');
                    $table->index('class');
                });
                $this->info('   ✅ Added class column to quizzes table');
            } else {
                $this->info('   ✅ Class column already exists in quizzes table');
            }
        }
        
        // Mark migrations as completed
        $this->markMigrationCompleted('2024_12_21_000006_create_quizzes_table_if_not_exists');
        $this->markMigrationCompleted('2024_12_21_000007_add_class_field_to_quizzes_table');
    }
    
    /**
     * Fix extracurricular status values
     */
    private function fixExtracurricularStatusValues(): void
    {
        try {
            $updated1 = DB::table('extracurriculars')
                ->where('status', 'aktif')
                ->update(['status' => 'active']);
                
            $updated2 = DB::table('extracurriculars')
                ->where('status', 'tidak_aktif')
                ->update(['status' => 'inactive']);
                
            if ($updated1 > 0 || $updated2 > 0) {
                $this->info("   ✅ Fixed status values ({$updated1} + {$updated2} records updated)");
            }
        } catch (\Exception $e) {
            $this->warn("   ⚠️  Could not fix status values: " . $e->getMessage());
        }
    }
    
    /**
     * Insert default settings
     */
    private function insertDefaultSettings(): void
    {
        $this->info('   📝 Inserting default settings...');
        
        $defaultSettings = [
            ['key' => 'school_name', 'value' => 'SMA Negeri 1 Balong', 'type' => 'string', 'group' => 'school', 'description' => 'Nama resmi sekolah'],
            ['key' => 'school_address', 'value' => 'Jl. Pendidikan No. 1, Balong', 'type' => 'string', 'group' => 'school', 'description' => 'Alamat lengkap sekolah'],
            ['key' => 'academic_year', 'value' => '2024/2025', 'type' => 'string', 'group' => 'academic', 'description' => 'Tahun ajaran aktif'],
            ['key' => 'semester', 'value' => '1', 'type' => 'integer', 'group' => 'academic', 'description' => 'Semester aktif'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'system', 'description' => 'Mode pemeliharaan sistem'],
        ];
        
        foreach ($defaultSettings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting + ['created_at' => now(), 'updated_at' => now()]
            );
        }
        
        $this->info('   ✅ Default settings inserted');
    }
    
    /**
     * Mark migration as completed
     */
    private function markMigrationCompleted(string $migration): void
    {
        $exists = DB::table('migrations')->where('migration', $migration)->exists();
        
        if (!$exists) {
            DB::table('migrations')->insert([
                'migration' => $migration,
                'batch' => DB::table('migrations')->max('batch') + 1
            ]);
            $this->info("   ✅ Marked as completed: {$migration}");
        }
    }
    
    /**
     * Verify all fixes
     */
    private function verifyAllFixes(): void
    {
        $this->info('');
        $this->info('🔍 Verifying all fixes...');
        
        // Check tables
        $tables = ['settings', 'agendas', 'extracurriculars', 'quizzes'];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                $this->info("  ✅ Table '{$table}' exists ({$count} records)");
            } else {
                $this->warn("  ⚠️  Table '{$table}' missing");
            }
        }
        
        // Check migrations
        $problematicMigrations = [
            '2024_12_21_000002_create_settings_table_if_not_exists',
            '2024_12_21_000003_update_settings_table_for_school',
            '2024_12_21_000003_create_agendas_table_if_not_exists',
            '2024_12_21_000004_update_agendas_table_for_calendar_integration',
            '2024_12_21_000005_create_extracurriculars_table_if_not_exists',
            '2024_12_21_000006_fix_extracurricular_status_values',
            '2024_12_21_000006_create_quizzes_table_if_not_exists',
            '2024_12_21_000007_add_class_field_to_quizzes_table'
        ];
        
        $completedCount = DB::table('migrations')
            ->whereIn('migration', $problematicMigrations)
            ->count();
            
        $this->info("  ✅ Completed migrations: {$completedCount}/" . count($problematicMigrations));
        
        // Check for remaining issues
        try {
            $this->info('  🔍 Testing migration readiness...');
            
            // Test settings table operations
            if (Schema::hasTable('settings')) {
                DB::table('settings')->where('key', 'test')->delete();
                $this->info('    ✅ Settings table operations work');
            }
            
            // Test agendas table operations
            if (Schema::hasTable('agendas')) {
                DB::table('agendas')->where('judul', 'test')->delete();
                $this->info('    ✅ Agendas table operations work');
            }
            
            // Test extracurriculars table operations
            if (Schema::hasTable('extracurriculars')) {
                DB::table('extracurriculars')->where('name', 'test')->delete();
                $this->info('    ✅ Extracurriculars table operations work');
            }
            
            // Test quizzes table operations
            if (Schema::hasTable('quizzes')) {
                DB::table('quizzes')->where('title', 'test')->delete();
                $this->info('    ✅ Quizzes table operations work');
            }
            
        } catch (\Exception $e) {
            $this->warn("    ⚠️  Some operations may still have issues: " . $e->getMessage());
        }
    }
}