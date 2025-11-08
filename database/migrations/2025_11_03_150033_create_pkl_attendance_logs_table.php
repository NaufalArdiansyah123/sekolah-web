<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pkl_attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pkl_registration_id');
            $table->unsignedBigInteger('student_id');
            $table->string('qr_code');
            $table->date('scan_date');
            $table->time('scan_time');
            $table->string('location')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('pkl_registration_id')->references('id')->on('pkl_registrations')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['pkl_registration_id', 'scan_date']);
            $table->index(['student_id', 'scan_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkl_attendance_logs');
    }
};
