<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Migration ini akan membuat tabel settings jika belum ada,
     * untuk mengatasi masalah dependency order.
     */
    public function up(): void
    {
        // Create settings table if it doesn't exist
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('string');
                $table->string('group')->default('general');
                $table->text('description')->nullable();
                $table->timestamps();
                
                // Add indexes for better performance
                $table->index(['group', 'key'], 'settings_group_key_index');
                $table->index('type', 'settings_type_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table in down() to avoid conflicts
        // The table will be handled by the main create_settings_table migration
    }
};