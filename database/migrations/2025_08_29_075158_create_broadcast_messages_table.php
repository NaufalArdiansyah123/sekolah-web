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
        Schema::create('broadcast_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extracurricular_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Admin who sent the broadcast
            $table->string('subject');
            $table->text('content');
            $table->boolean('send_email')->default(false);
            $table->boolean('post_public')->default(false);
            $table->boolean('send_sms')->default(false);
            $table->enum('schedule_type', ['now', 'later'])->default('now');
            $table->datetime('scheduled_at')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->datetime('sent_at')->nullable();
            $table->integer('recipients_count')->default(0);
            $table->integer('emails_sent')->default(0);
            $table->integer('sms_sent')->default(0);
            $table->json('delivery_log')->nullable(); // Store delivery details
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index(['extracurricular_id', 'status']);
            $table->index(['scheduled_at', 'status']);
            $table->index(['post_public', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broadcast_messages');
    }
};