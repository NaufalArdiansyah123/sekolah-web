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
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->integer('score')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('grade', 2)->nullable();
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->integer('duration_taken')->nullable(); // in minutes
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'submitted'])->default('not_started');
            $table->json('answers')->nullable(); // student answers
            $table->timestamps();
            
            $table->unique(['assessment_id', 'student_id']);
            $table->index(['student_id', 'status']);
            $table->index('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};