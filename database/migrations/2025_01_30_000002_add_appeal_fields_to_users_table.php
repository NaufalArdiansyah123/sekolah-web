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
        Schema::table('users', function (Blueprint $table) {
            // Add appeal fields for rejected users
            if (!Schema::hasColumn('users', 'appeal_reason')) {
                $table->text('appeal_reason')->nullable()->after('rejection_reason');
            }
            
            if (!Schema::hasColumn('users', 'appeal_submitted_at')) {
                $table->timestamp('appeal_submitted_at')->nullable()->after('appeal_reason');
            }
            
            if (!Schema::hasColumn('users', 'additional_documents')) {
                $table->text('additional_documents')->nullable()->after('appeal_submitted_at');
            }
            
            if (!Schema::hasColumn('users', 'appeal_reviewed_at')) {
                $table->timestamp('appeal_reviewed_at')->nullable()->after('additional_documents');
            }
            
            if (!Schema::hasColumn('users', 'appeal_reviewed_by')) {
                $table->unsignedBigInteger('appeal_reviewed_by')->nullable()->after('appeal_reviewed_at');
            }
        });
        
        // Add foreign key constraint for appeal_reviewed_by
        $this->addForeignKeyIfNotExists('users', 'appeal_reviewed_by', 'users', 'id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key first
            try {
                $table->dropForeign(['appeal_reviewed_by']);
            } catch (Exception $e) {
                // Foreign key might not exist, ignore
            }
            
            // Drop appeal columns if they exist
            $columnsToCheck = ['appeal_reason', 'appeal_submitted_at', 'additional_documents', 'appeal_reviewed_at', 'appeal_reviewed_by'];
            $columnsToDrop = [];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
    
    /**
     * Add foreign key constraint if it doesn't exist
     */
    private function addForeignKeyIfNotExists($table, $column, $referencedTable, $referencedColumn)
    {
        try {
            // Check if foreign key already exists
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME 
                 FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_SCHEMA = DATABASE() 
                 AND TABLE_NAME = ? 
                 AND COLUMN_NAME = ? 
                 AND REFERENCED_TABLE_NAME IS NOT NULL",
                [$table, $column]
            );
            
            if (empty($foreignKeys) && Schema::hasColumn($table, $column)) {
                Schema::table($table, function (Blueprint $tableBlueprint) use ($column, $referencedTable, $referencedColumn) {
                    $tableBlueprint->foreign($column)->references($referencedColumn)->on($referencedTable)->onDelete('set null');
                });
            }
        } catch (\Exception $e) {
            // Foreign key might already exist or other error, ignore
        }
    }
};