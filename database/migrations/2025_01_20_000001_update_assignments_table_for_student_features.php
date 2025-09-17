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
        Schema::table('assignments', function (Blueprint $table) {
            // Add attachment fields if they don't exist
            if (!Schema::hasColumn('assignments', 'attachment_path')) {
                $table->string('attachment_path')->nullable()->after('instructions');
            }
            if (!Schema::hasColumn('assignments', 'attachment_name')) {
                $table->string('attachment_name')->nullable()->after('attachment_path');
            }
            
            // Update status enum to match our needs
            $table->enum('status', ['draft', 'published', 'active', 'completed', 'closed'])->default('draft')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            if (Schema::hasColumn('assignments', 'attachment_path')) {
                $table->dropColumn('attachment_path');
            }
            if (Schema::hasColumn('assignments', 'attachment_name')) {
                $table->dropColumn('attachment_name');
            }
            
            // Revert status enum
            $table->enum('status', ['draft', 'active', 'completed'])->default('draft')->change();
        });
    }
};