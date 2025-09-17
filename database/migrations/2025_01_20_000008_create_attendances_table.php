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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->date('date');
            $table->enum('status', ['present', 'late', 'absent', 'sick', 'permission'])->default('absent');
            $table->time('check_in_time')->nullable();
            $table->text('notes')->nullable();
            $table->string('attachment')->nullable(); // For sick/permission attachments
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('attendance_sessions')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['student_id', 'date']);
            $table->index(['date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};