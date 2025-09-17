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
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // student, teacher, media, etc
            $table->string('action'); // create, update, delete, upload
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // additional data
            $table->unsignedBigInteger('user_id'); // who did the action
            $table->unsignedBigInteger('target_id')->nullable(); // ID of affected record
            $table->string('target_type')->nullable(); // model class name
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['type', 'action']);
            $table->index(['is_read', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};