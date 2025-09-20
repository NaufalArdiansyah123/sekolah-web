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
        Schema::create('daily_test_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attempt_id');
            $table->unsignedBigInteger('question_id');
            $table->text('answer'); // Student's answer
            $table->boolean('is_correct')->nullable(); // For multiple choice
            $table->decimal('points_earned', 5, 2)->default(0);
            $table->text('teacher_feedback')->nullable(); // For essay questions
            $table->timestamps();

            $table->foreign('attempt_id')->references('id')->on('daily_test_attempts')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('daily_test_questions')->onDelete('cascade');
            $table->index(['attempt_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_test_answers');
    }
};