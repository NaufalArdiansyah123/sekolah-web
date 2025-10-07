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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject');
            $table->string('class');
            $table->enum('type', ['homework', 'project', 'essay', 'quiz', 'presentation']);
            $table->text('description');
            $table->text('instructions')->nullable();
            $table->datetime('due_date');
            $table->integer('max_score');
            $table->enum('status', ['draft', 'active', 'completed'])->default('draft');
            $table->integer('submissions_count')->default(0);
            $table->integer('total_students')->default(0);
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['status', 'created_at']);
            $table->index(['subject', 'class']);
            $table->index(['type', 'status']);
            $table->index(['due_date', 'status']);
            $table->index('teacher_id');

            // Foreign keys
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};