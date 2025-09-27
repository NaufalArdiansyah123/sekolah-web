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
        // Only create the table if it doesn't exist to avoid conflicts
        if (!Schema::hasTable('security_violations')) {
            Schema::create('security_violations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('violator_student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('qr_owner_student_id')->constrained('students')->onDelete('cascade');
            $table->string('qr_code'); // QR code yang digunakan
            $table->enum('violation_type', ['wrong_qr_owner', 'invalid_qr', 'duplicate_scan', 'other'])->default('wrong_qr_owner');
            $table->timestamp('violation_time'); // Waktu pelanggaran
            $table->date('violation_date'); // Tanggal pelanggaran
            $table->string('location')->nullable(); // Lokasi scan
            $table->string('ip_address')->nullable(); // IP address
            $table->text('user_agent')->nullable(); // Browser/device info
            $table->json('violation_details')->nullable(); // Detail pelanggaran dalam JSON
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'dismissed'])->default('pending');
            $table->text('admin_notes')->nullable(); // Catatan admin
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            $table->index(['violator_student_id', 'violation_date']);
            $table->index(['qr_owner_student_id', 'violation_date']);
            $table->index(['violation_type', 'status']);
            $table->index(['violation_date', 'severity']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_violations');
    }
};