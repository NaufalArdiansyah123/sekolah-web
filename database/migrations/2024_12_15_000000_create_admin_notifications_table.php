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
        if (!Schema::hasTable('admin_notifications')) {
            Schema::create('admin_notifications', function (Blueprint $table) {
                $table->id();
                $table->string('type')->index(); // student, teacher, media, etc.
                $table->string('action')->index(); // create, update, delete, upload, etc.
                $table->string('title');
                $table->text('message')->nullable();
                $table->json('data')->nullable(); // Additional data
                $table->unsignedBigInteger('user_id')->nullable(); // Who performed the action
                $table->unsignedBigInteger('target_id')->nullable(); // Target entity ID
                $table->string('target_type')->nullable(); // Target entity type (polymorphic)
                $table->boolean('is_read')->default(false)->index();
                $table->timestamps();
                
                // Foreign key constraints
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                
                // Indexes for better performance
                $table->index(['type', 'action']);
                $table->index(['is_read', 'created_at']);
                $table->index(['target_type', 'target_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};