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
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->integer('question_number');
            $table->text('question');
            $table->enum('type', ['multiple_choice', 'essay', 'short_answer', 'true_false']);
            $table->json('options')->nullable(); // for multiple choice questions
            $table->string('correct_answer')->nullable(); // for objective questions
            $table->integer('points');
            $table->timestamps();
            
            $table->index(['assessment_id', 'question_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_questions');
    }
};