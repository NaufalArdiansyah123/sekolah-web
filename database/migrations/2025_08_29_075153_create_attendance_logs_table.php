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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('qr_code'); // QR code yang di-scan
            $table->enum('status', ['hadir', 'terlambat', 'izin', 'sakit', 'alpha'])->default('hadir');
            $table->timestamp('scan_time'); // Waktu scan QR code
            $table->date('attendance_date'); // Tanggal absensi
            $table->string('location')->nullable(); // Lokasi scan (opsional)
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
            
            $table->index(['student_id', 'attendance_date']);
            $table->index(['qr_code', 'scan_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};