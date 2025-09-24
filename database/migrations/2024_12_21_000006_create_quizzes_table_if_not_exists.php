<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Migration ini akan membuat tabel quizzes jika belum ada,
     * untuk mengatasi masalah dependency order.
     */
    public function up(): void
    {
        // Create quizzes table if it doesn't exist
        if (!Schema::hasTable('quizzes')) {
            Schema::create('quizzes', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('subject');
                $table->unsignedBigInteger('teacher_id');
                $table->datetime('start_time');
                $table->datetime('end_time');
                $table->integer('duration_minutes');
                $table->integer('max_attempts')->default(1);
                $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
                $table->text('instructions')->nullable();
                $table->boolean('show_results')->default(true);
                $table->boolean('randomize_questions')->default(false);
                $table->timestamps();
                $table->softDeletes();

                // Add foreign key if users table exists
                if (Schema::hasTable('users')) {
                    $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
                }
                
                // Add indexes for better performance
                $table->index(['status', 'start_time', 'end_time']);
                $table->index(['teacher_id', 'subject']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table in down() to avoid conflicts
        // The table will be handled by the main create_quizzes_table migration
    }
};