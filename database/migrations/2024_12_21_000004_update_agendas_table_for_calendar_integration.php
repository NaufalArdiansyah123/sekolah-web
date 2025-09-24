<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if agendas table exists, if not create it first
        if (!Schema::hasTable('agendas')) {
            Schema::create('agendas', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->text('content')->nullable();
                $table->datetime('event_date')->nullable();
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->date('tanggal');
                $table->time('waktu')->nullable();
                $table->string('kategori')->nullable();
                $table->enum('prioritas', ['low', 'medium', 'high'])->default('medium');
                $table->string('lokasi')->nullable();
                $table->string('penanggung_jawab')->nullable();
                $table->enum('status', ['draft', 'published', 'archived'])->default('published');
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('calendar_event_id')->nullable();
                $table->timestamps();
                
                // Add foreign keys if referenced tables exist
                if (Schema::hasTable('users')) {
                    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                }
                if (Schema::hasTable('calendar_events')) {
                    $table->foreign('calendar_event_id')->references('id')->on('calendar_events')->onDelete('set null');
                }
                
                // Add indexes
                $table->index('event_date');
                $table->index('status');
                $table->index('tanggal');
                $table->index('prioritas');
            });
        } else {
            // Table exists, just add missing columns
            Schema::table('agendas', function (Blueprint $table) {
                // Add new columns for calendar integration if they don't exist
                if (!Schema::hasColumn('agendas', 'title')) {
                    $table->string('title')->nullable()->after('id');
                }
                if (!Schema::hasColumn('agendas', 'content')) {
                    $table->text('content')->nullable()->after('title');
                }
                if (!Schema::hasColumn('agendas', 'event_date')) {
                    $table->datetime('event_date')->nullable()->after('content');
                }
                if (!Schema::hasColumn('agendas', 'status')) {
                    $table->enum('status', ['draft', 'published', 'archived'])->default('published')->after('penanggung_jawab');
                }
                if (!Schema::hasColumn('agendas', 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('status');
                }
                if (!Schema::hasColumn('agendas', 'calendar_event_id')) {
                    $table->unsignedBigInteger('calendar_event_id')->nullable()->after('created_by');
                }
            });
            
            // Add foreign keys if they don't exist and referenced tables exist
            $this->addForeignKeyIfNotExists('agendas', 'created_by', 'users', 'id');
            $this->addForeignKeyIfNotExists('agendas', 'calendar_event_id', 'calendar_events', 'id');
            
            // Add indexes if they don't exist
            $this->addIndexIfNotExists('agendas', ['event_date'], 'agendas_event_date_index');
            $this->addIndexIfNotExists('agendas', ['status'], 'agendas_status_index');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('agendas')) {
            Schema::table('agendas', function (Blueprint $table) {
                // Drop foreign keys if they exist
                $this->dropForeignKeyIfExists('agendas', 'agendas_created_by_foreign');
                $this->dropForeignKeyIfExists('agendas', 'agendas_calendar_event_id_foreign');
                
                // Drop indexes if they exist
                $this->dropIndexIfExists('agendas', 'agendas_event_date_index');
                $this->dropIndexIfExists('agendas', 'agendas_status_index');
                
                // Drop columns if they exist
                $columns = ['title', 'content', 'event_date', 'status', 'created_by', 'calendar_event_id'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('agendas', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
    
    /**
     * Add foreign key if it doesn't exist
     */
    private function addForeignKeyIfNotExists(string $table, string $column, string $referencedTable, string $referencedColumn): void
    {
        if (!Schema::hasTable($referencedTable)) {
            return; // Referenced table doesn't exist
        }
        
        try {
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = '{$table}' 
                AND COLUMN_NAME = '{$column}' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            
            if (empty($foreignKeys)) {
                Schema::table($table, function (Blueprint $table) use ($column, $referencedTable, $referencedColumn) {
                    $table->foreign($column)->references($referencedColumn)->on($referencedTable)->onDelete('set null');
                });
            }
        } catch (\Exception $e) {
            // Foreign key creation failed, but continue
        }
    }
    
    /**
     * Add index if it doesn't exist
     */
    private function addIndexIfNotExists(string $table, array $columns, string $indexName): void
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM {$table}");
            $existingIndexes = collect($indexes)->pluck('Key_name')->toArray();
            
            if (!in_array($indexName, $existingIndexes)) {
                Schema::table($table, function (Blueprint $table) use ($columns, $indexName) {
                    $table->index($columns, $indexName);
                });
            }
        } catch (\Exception $e) {
            // Index creation failed, but continue
        }
    }
    
    /**
     * Drop foreign key if it exists
     */
    private function dropForeignKeyIfExists(string $table, string $foreignKeyName): void
    {
        try {
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = '{$table}' 
                AND CONSTRAINT_NAME = '{$foreignKeyName}'
            ");
            
            if (!empty($foreignKeys)) {
                Schema::table($table, function (Blueprint $table) use ($foreignKeyName) {
                    $table->dropForeign($foreignKeyName);
                });
            }
        } catch (\Exception $e) {
            // Foreign key drop failed, but continue
        }
    }
    
    /**
     * Drop index if it exists
     */
    private function dropIndexIfExists(string $table, string $indexName): void
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM {$table}");
            $existingIndexes = collect($indexes)->pluck('Key_name')->toArray();
            
            if (in_array($indexName, $existingIndexes)) {
                Schema::table($table, function (Blueprint $table) use ($indexName) {
                    $table->dropIndex($indexName);
                });
            }
        } catch (\Exception $e) {
            // Index drop failed, but continue
        }
    }
};