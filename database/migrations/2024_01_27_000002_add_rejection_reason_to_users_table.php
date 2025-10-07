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
            // Check if rejection_reason column doesn't exist before adding
            if (!Schema::hasColumn('users', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('student_id');
            }
            
            // Update status enum to include rejected
            $table->enum('status', ['active', 'inactive', 'pending', 'rejected'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop if this migration added it (check if it exists and was added by this migration)
            if (Schema::hasColumn('users', 'rejection_reason')) {
                // Don't drop if it was added by the earlier migration
                // This migration only updates status enum
            }
            
            // Revert status enum
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending')->change();
        });
    }
};