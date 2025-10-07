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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('assignment_id')->nullable();
            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->string('subject');
            $table->enum('type', ['assignment', 'quiz', 'exam', 'project', 'participation'])->default('assignment');
            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2)->default(100);
            $table->integer('semester')->default(1);
            $table->year('year');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('set null');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('set null');
            $table->index(['student_id', 'semester', 'year']);
            $table->index(['subject', 'semester', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};