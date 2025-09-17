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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject');
            $table->string('class');
            $table->enum('type', ['exam', 'quiz', 'test', 'practical', 'assignment']);
            $table->datetime('date');
            $table->integer('duration'); // in minutes
            $table->integer('max_score');
            $table->enum('status', ['draft', 'scheduled', 'active', 'completed'])->default('draft');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // teacher who created
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['subject', 'class']);
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};