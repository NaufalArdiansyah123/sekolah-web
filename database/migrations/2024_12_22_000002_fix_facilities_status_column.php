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
        // Check if facilities table exists
        if (!Schema::hasTable('facilities')) {
            return;
        }

        // Get current column information
        $columns = Schema::getColumnListing('facilities');
        
        if (in_array('status', $columns)) {
            // Check current column type
            $columnType = DB::select("SHOW COLUMNS FROM facilities WHERE Field = 'status'")[0] ?? null;
            
            if ($columnType) {
                echo "Current status column type: " . $columnType->Type . "\n";
                
                // If it's not the correct ENUM, fix it
                if (!str_contains($columnType->Type, 'active') || !str_contains($columnType->Type, 'maintenance')) {
                    Schema::table('facilities', function (Blueprint $table) {
                        // Drop and recreate the status column with correct ENUM values
                        $table->dropColumn('status');
                    });
                    
                    Schema::table('facilities', function (Blueprint $table) {
                        $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active')->after('features');
                    });
                    
                    echo "Fixed status column with correct ENUM values\n";
                }
            }
        } else {
            // Add status column if it doesn't exist
            Schema::table('facilities', function (Blueprint $table) {
                $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active')->after('features');
            });
            
            echo "Added status column with ENUM values\n";
        }
        
        // Update any existing records with invalid status values
        DB::table('facilities')
            ->whereNotIn('status', ['active', 'maintenance', 'inactive'])
            ->update(['status' => 'active']);
            
        echo "Updated invalid status values to 'active'\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is for fixing data, no need to reverse
    }
};