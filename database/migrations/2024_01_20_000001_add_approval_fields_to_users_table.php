<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check and add approval fields only if they don't exist
            if (!Schema::hasColumn('users', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            }
            if (!Schema::hasColumn('users', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('approved_by');
            }
            if (!Schema::hasColumn('users', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable()->after('rejected_at');
            }
            if (!Schema::hasColumn('users', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('rejected_by');
            }
        });
        
        // Add foreign key constraints separately to avoid conflicts
        Schema::table('users', function (Blueprint $table) {
            // Check if foreign keys don't already exist
            if (Schema::hasColumn('users', 'approved_by')) {
                try {
                    $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
                } catch (Exception $e) {
                    // Foreign key might already exist, ignore
                }
            }
            if (Schema::hasColumn('users', 'rejected_by')) {
                try {
                    $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
                } catch (Exception $e) {
                    // Foreign key might already exist, ignore
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys first if they exist
            try {
                $table->dropForeign(['approved_by']);
            } catch (Exception $e) {
                // Foreign key might not exist, ignore
            }
            try {
                $table->dropForeign(['rejected_by']);
            } catch (Exception $e) {
                // Foreign key might not exist, ignore
            }
            
            // Drop columns only if they exist
            $columnsToCheck = ['approved_at', 'approved_by', 'rejected_at', 'rejected_by', 'rejection_reason'];
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
};