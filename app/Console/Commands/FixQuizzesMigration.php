<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Schema, DB, Artisan};

class FixQuizzesMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:quizzes-migration 
                            {--force : Force fix even if table exists}
                            {--reset : Reset and recreate quizzes table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the quizzes table migration dependency issue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing Quizzes Migration Issue...');
        $this->info('===================================');
        
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
            $this->info('🎉 Quizzes migration fix completed successfully!');
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
        if (!Schema::hasTable('quizzes')) {
            $this->info('📋 Creating quizzes table...');
            
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

                // Add foreign key if users table exists
                if (Schema::hasTable('users')) {
                    $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
                }
                
                // Add indexes
                $table->index(['status', 'start_time', 'end_time']);
                $table->index(['teacher_id', 'subject']);
                $table->index('class');
            });
            
            $this->info('✅ Quizzes table created successfully!');
        } else {
            $this->info('✅ Quizzes table already exists');
            
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
        if (Schema::hasTable('quizzes')) {
            if ($this->confirm('⚠️  This will drop and recreate the quizzes table. Continue?', false)) {
                $this->info('🗑️  Dropping existing quizzes table...');
                Schema::dropIfExists('quizzes');
                $this->info('✅ Quizzes table dropped');
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
        Schema::table('quizzes', function ($table) {
            if (!Schema::hasColumn('quizzes', 'class')) {
                $table->string('class')->nullable()->after('subject');
                $this->info('  ✅ Added class column');
            }
        });
        
        // Add index if it doesn't exist
        try {
            $indexes = DB::select("SHOW INDEX FROM quizzes");
            $indexNames = collect($indexes)->pluck('Key_name')->toArray();
            
            if (!in_array('quizzes_class_index', $indexNames)) {
                DB::statement("CREATE INDEX quizzes_class_index ON quizzes (class)");
                $this->info('  ✅ Added class index');
            }
        } catch (\Exception $e) {
            $this->warn('  ⚠️  Could not add class index: ' . $e->getMessage());
        }
    }
    
    /**
     * Mark migration as completed
     */
    private function markMigrationCompleted(): void
    {
        $migrations = [
            '2024_12_21_000006_create_quizzes_table_if_not_exists',
            '2024_12_21_000007_add_class_field_to_quizzes_table'
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
        if (Schema::hasTable('quizzes')) {
            $this->info('  ✅ Quizzes table exists');
        } else {
            $this->error('  ❌ Quizzes table missing');
            return;
        }
        
        // Check required columns
        $requiredColumns = ['id', 'title', 'description', 'subject', 'teacher_id', 'start_time', 'end_time', 'duration_minutes', 'max_attempts', 'status'];
        foreach ($requiredColumns as $column) {
            if (Schema::hasColumn('quizzes', $column)) {
                $this->info("  ✅ Column '{$column}' exists");
            } else {
                $this->warn("  ⚠️  Column '{$column}' missing");
            }
        }
        
        // Check class column specifically
        if (Schema::hasColumn('quizzes', 'class')) {
            $this->info("  ✅ Class column exists");
        } else {
            $this->warn("  ⚠️  Class column missing");
        }
        
        // Check indexes
        try {
            $indexes = DB::select("SHOW INDEX FROM quizzes");
            $indexNames = collect($indexes)->pluck('Key_name')->unique()->filter()->toArray();
            $this->info("  📋 Indexes: " . implode(', ', $indexNames));
        } catch (\Exception $e) {
            $this->warn("  ⚠️  Could not check indexes: " . $e->getMessage());
        }
        
        // Check data
        $quizzesCount = DB::table('quizzes')->count();
        $this->info("  📊 Quizzes count: {$quizzesCount}");
        
        // Check migration status
        $completedMigrations = DB::table('migrations')
            ->whereIn('migration', [
                '2024_12_21_000006_create_quizzes_table_if_not_exists',
                '2024_12_21_000007_add_class_field_to_quizzes_table'
            ])
            ->count();
        
        $this->info("  ✅ Completed migrations: {$completedMigrations}/2");
    }
}