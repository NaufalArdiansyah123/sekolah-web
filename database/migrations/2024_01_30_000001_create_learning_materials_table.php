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
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject');
            $table->string('class');
            $table->enum('type', ['document', 'video', 'presentation', 'exercise', 'audio']);
            $table->text('description')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type');
            $table->bigInteger('file_size'); // in bytes
            $table->integer('downloads')->default(0);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['status', 'created_at']);
            $table->index(['subject', 'class']);
            $table->index(['type', 'status']);
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
        Schema::dropIfExists('learning_materials');
    }
};