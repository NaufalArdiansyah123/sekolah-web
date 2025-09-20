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
            // Check and add rejection fields if they don't exist
            if (!Schema::hasColumn('users', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('users', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejection_reason');
            }
            
            if (!Schema::hasColumn('users', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable()->after('rejected_at');
            }
            
            if (!Schema::hasColumn('users', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('rejected_by');
            }
            
            if (!Schema::hasColumn('users', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            }
        });
        
        // Add foreign key constraints if they don't exist
        $this->addForeignKeyIfNotExists('users', 'rejected_by', 'users', 'id');
        $this->addForeignKeyIfNotExists('users', 'approved_by', 'users', 'id');
        
        // Update status enum to include rejected if not already included
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'inactive', 'pending', 'rejected') DEFAULT 'pending'");
        } catch (Exception $e) {
            // Status enum might already be correct, ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys first
            try {
                $table->dropForeign(['rejected_by']);
            } catch (Exception $e) {
                // Foreign key might not exist, ignore
            }
            
            try {
                $table->dropForeign(['approved_by']);
            } catch (Exception $e) {
                // Foreign key might not exist, ignore
            }
            
            // Drop columns if they exist
            $columnsToCheck = ['rejection_reason', 'rejected_at', 'rejected_by', 'approved_at', 'approved_by'];
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