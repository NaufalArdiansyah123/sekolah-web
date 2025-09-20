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
        Schema::create('daily_test_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daily_test_id');
            $table->unsignedBigInteger('student_id');
            $table->datetime('started_at');
            $table->datetime('completed_at')->nullable();
            $table->decimal('score', 5, 2)->nullable(); // Score out of 100
            $table->integer('total_questions');
            $table->integer('correct_answers')->default(0);
            $table->json('answers')->nullable(); // Store all answers
            $table->enum('status', ['in_progress', 'completed', 'abandoned'])->default('in_progress');
            $table->text('notes')->nullable(); // Teacher notes
            $table->timestamps();

            $table->foreign('daily_test_id')->references('id')->on('daily_tests')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['daily_test_id', 'student_id']);
            $table->index(['student_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_test_attempts');
    }
};