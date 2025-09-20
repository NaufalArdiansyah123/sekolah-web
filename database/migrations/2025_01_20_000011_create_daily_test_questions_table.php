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
        Schema::create('daily_test_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daily_test_id');
            $table->text('question');
            $table->enum('type', ['multiple_choice', 'essay'])->default('multiple_choice');
            $table->json('options')->nullable(); // For multiple choice questions
            $table->string('correct_answer')->nullable(); // For multiple choice questions
            $table->integer('points')->default(10);
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('daily_test_id')->references('id')->on('daily_tests')->onDelete('cascade');
            $table->index(['daily_test_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_test_questions');
    }
};