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
        Schema::create('attendance_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('guru_piket_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('submission_date');
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->string('subject')->nullable();
            $table->time('session_time')->nullable();
            $table->integer('total_students')->default(0);
            $table->integer('present_count')->default(0);
            $table->integer('late_count')->default(0);
            $table->integer('absent_count')->default(0);
            $table->json('attendance_data')->nullable(); // Detailed attendance data
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Indexes
            $table->index(['teacher_id', 'submission_date']);
            $table->index(['guru_piket_id', 'status']);
            $table->index(['status', 'submission_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_submissions');
    }
};