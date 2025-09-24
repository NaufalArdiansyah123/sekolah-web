<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Migration ini akan membuat tabel extracurriculars jika belum ada,
     * untuk mengatasi masalah dependency order.
     */
    public function up(): void
    {
        // Create extracurriculars table if it doesn't exist
        if (!Schema::hasTable('extracurriculars')) {
            Schema::create('extracurriculars', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('coach')->nullable();
                $table->string('schedule')->nullable();
                $table->string('location')->nullable();
                $table->integer('max_participants')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->string('image')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();
                
                // Add foreign key if users table exists
                if (Schema::hasTable('users')) {
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                }
                
                // Add indexes for better performance
                $table->index('status');
                $table->index('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table in down() to avoid conflicts
        // The table will be handled by the main create_extracurriculars_table migration
    }
};