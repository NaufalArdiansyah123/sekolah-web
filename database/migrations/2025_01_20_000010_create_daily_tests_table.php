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
        Schema::create('daily_tests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('subject');
            $table->string('class'); // Target class (7, 8, 9)
            $table->unsignedBigInteger('teacher_id');
            $table->datetime('scheduled_at')->nullable(); // When the test is scheduled
            $table->integer('duration'); // Duration in minutes
            $table->enum('status', ['draft', 'published', 'completed'])->default('draft');
            $table->text('instructions')->nullable();
            $table->boolean('show_results')->default(true);
            $table->boolean('randomize_questions')->default(false);
            $table->integer('max_attempts')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['status', 'scheduled_at']);
            $table->index(['teacher_id', 'subject', 'class']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_tests');
    }
};