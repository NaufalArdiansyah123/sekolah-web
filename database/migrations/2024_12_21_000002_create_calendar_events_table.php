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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->string('location')->nullable();
            $table->string('color', 7)->default('#3b82f6'); // Hex color code
            $table->enum('type', ['event', 'agenda', 'meeting', 'holiday', 'exam', 'other'])->default('event');
            $table->boolean('is_all_day')->default(true);
            $table->enum('status', ['active', 'cancelled', 'postponed'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('source_type')->nullable(); // agenda, manual, etc
            $table->unsignedBigInteger('source_id')->nullable(); // ID from source table
            $table->timestamps();

            // Indexes
            $table->index(['start_date', 'end_date']);
            $table->index(['status', 'start_date']);
            $table->index('created_by');
            $table->index('type');

            // Foreign key
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};