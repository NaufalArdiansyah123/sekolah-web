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
        // Check if deleted_at column doesn't exist before adding it
        if (!Schema::hasColumn('facilities', 'deleted_at')) {
            Schema::table('facilities', function (Blueprint $table) {
                $table->softDeletes(); // ini otomatis buat kolom deleted_at
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if deleted_at column exists before dropping it
        if (Schema::hasColumn('facilities', 'deleted_at')) {
            Schema::table('facilities', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
