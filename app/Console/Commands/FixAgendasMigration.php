<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Schema, DB, Artisan};

class FixAgendasMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:agendas-migration 
                            {--force : Force fix even if table exists}
                            {--reset : Reset and recreate agendas table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the agendas table migration dependency issue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing Agendas Migration Issue...');
        $this->info('====================================');
        
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
            
            // Step 3: Verify fix
            $this->verifyFix();
            
            $this->info('');
            $this->info('🎉 Agendas migration fix completed successfully!');
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
        if (!Schema::hasTable('agendas')) {
            $this->info('📋 Creating agendas table...');
            
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
                
                // Add indexes
                $table->index('tanggal');
                $table->index('prioritas');
                $table->index('kategori');
            });
            
            $this->info('✅ Agendas table created successfully!');
        } else {
            $this->info('✅ Agendas table already exists');
            
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
        if (Schema::hasTable('agendas')) {
            if ($this->confirm('⚠️  This will drop and recreate the agendas table. Continue?', false)) {
                $this->info('🗑️  Dropping existing agendas table...');
                Schema::dropIfExists('agendas');
                $this->info('✅ Agendas table dropped');
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
        $columnsToAdd = [
            'title' => ['type' => 'string', 'nullable' => true, 'after' => 'id'],
            'content' => ['type' => 'text', 'nullable' => true, 'after' => 'title'],
            'event_date' => ['type' => 'datetime', 'nullable' => true, 'after' => 'content'],
            'status' => ['type' => 'enum', 'values' => ['draft', 'published', 'archived'], 'default' => 'published', 'after' => 'penanggung_jawab'],
            'created_by' => ['type' => 'unsignedBigInteger', 'nullable' => true, 'after' => 'status'],
            'calendar_event_id' => ['type' => 'unsignedBigInteger', 'nullable' => true, 'after' => 'created_by'],
        ];
        
        Schema::table('agendas', function ($table) use ($columnsToAdd) {
            foreach ($columnsToAdd as $column => $config) {
                if (!Schema::hasColumn('agendas', $column)) {
                    switch ($config['type']) {
                        case 'string':
                            $col = $table->string($column);
                            break;
                        case 'text':
                            $col = $table->text($column);
                            break;
                        case 'datetime':
                            $col = $table->datetime($column);
                            break;
                        case 'enum':
                            $col = $table->enum($column, $config['values']);
                            if (isset($config['default'])) {
                                $col->default($config['default']);
                            }
                            break;
                        case 'unsignedBigInteger':
                            $col = $table->unsignedBigInteger($column);
                            break;
                        default:
                            continue 2;
                    }
                    
                    if ($config['nullable'] ?? false) {
                        $col->nullable();
                    }
                    
                    if (isset($config['after'])) {
                        $col->after($config['after']);
                    }
                    
                    $this->info("  ✅ Added {$column} column");
                }
            }
        });
        
        // Add foreign keys if referenced tables exist
        $this->addForeignKeys();
        
        // Add indexes
        $this->addIndexes();
    }
    
    /**
     * Add foreign keys
     */
    private function addForeignKeys(): void
    {
        try {
            if (Schema::hasTable('users') && Schema::hasColumn('agendas', 'created_by')) {
                Schema::table('agendas', function ($table) {
                    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                });
                $this->info('  ✅ Added created_by foreign key');
            }
        } catch (\Exception $e) {
            $this->warn('  ⚠️  Could not add created_by foreign key: ' . $e->getMessage());
        }
        
        try {
            if (Schema::hasTable('calendar_events') && Schema::hasColumn('agendas', 'calendar_event_id')) {
                Schema::table('agendas', function ($table) {
                    $table->foreign('calendar_event_id')->references('id')->on('calendar_events')->onDelete('set null');
                });
                $this->info('  ✅ Added calendar_event_id foreign key');
            }
        } catch (\Exception $e) {
            $this->warn('  ⚠️  Could not add calendar_event_id foreign key: ' . $e->getMessage());
        }
    }
    
    /**
     * Add indexes
     */
    private function addIndexes(): void
    {
        $indexes = [
            'event_date' => 'agendas_event_date_index',
            'status' => 'agendas_status_index'
        ];
        
        foreach ($indexes as $column => $indexName) {
            try {
                if (Schema::hasColumn('agendas', $column)) {
                    $existingIndexes = DB::select("SHOW INDEX FROM agendas");
                    $indexNames = collect($existingIndexes)->pluck('Key_name')->toArray();
                    
                    if (!in_array($indexName, $indexNames)) {
                        DB::statement("CREATE INDEX {$indexName} ON agendas ({$column})");
                        $this->info("  ✅ Added {$column} index");
                    }
                }
            } catch (\Exception $e) {
                $this->warn("  ⚠️  Could not add {$column} index: " . $e->getMessage());
            }
        }
    }
    
    /**
     * Mark migration as completed
     */
    private function markMigrationCompleted(): void
    {
        $migrations = [
            '2024_12_21_000003_create_agendas_table_if_not_exists',
            '2024_12_21_000004_update_agendas_table_for_calendar_integration'
        ];
        
        $maxBatch = DB::table('migrations')->max('batch') ?? 0;
        
        foreach ($migrations as $migration) {
            $exists = DB::table('migrations')->where('migration', $migration)->exists();
            
            if (!$exists) {
                DB::table('migrations')->insert([
                    'migration' => $migration,
                    'batch' => $maxBatch + 1
                ]);
                $this->info("✅ Marked migration as completed: {$migration}");
            } else {
                $this->info("✅ Migration already marked as completed: {$migration}");
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
        
        // Check table exists
        if (Schema::hasTable('agendas')) {
            $this->info('  ✅ Agendas table exists');
        } else {
            $this->error('  ❌ Agendas table missing');
            return;
        }
        
        // Check required columns
        $requiredColumns = ['id', 'judul', 'deskripsi', 'tanggal', 'waktu', 'kategori', 'prioritas', 'lokasi', 'penanggung_jawab'];
        foreach ($requiredColumns as $column) {
            if (Schema::hasColumn('agendas', $column)) {
                $this->info("  ✅ Column '{$column}' exists");
            } else {
                $this->warn("  ⚠️  Column '{$column}' missing");
            }
        }
        
        // Check optional columns
        $optionalColumns = ['title', 'content', 'event_date', 'status', 'created_by', 'calendar_event_id'];
        foreach ($optionalColumns as $column) {
            if (Schema::hasColumn('agendas', $column)) {
                $this->info("  ✅ Optional column '{$column}' exists");
            } else {
                $this->warn("  ⚠️  Optional column '{$column}' missing");
            }
        }
        
        // Check data
        $agendasCount = DB::table('agendas')->count();
        $this->info("  📊 Agendas count: {$agendasCount}");
        
        // Check migration status
        $completedMigrations = DB::table('migrations')
            ->whereIn('migration', [
                '2024_12_21_000003_create_agendas_table_if_not_exists',
                '2024_12_21_000004_update_agendas_table_for_calendar_integration'
            ])
            ->count();
        
        $this->info("  ✅ Completed migrations: {$completedMigrations}/2");
    }
}