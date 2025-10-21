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
        Schema::table('teacher_attendance_logs', function (Blueprint $table) {
            $table->time('check_out_time')->nullable()->after('scan_time');
            $table->index(['attendance_date', 'check_out_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_attendance_logs', function (Blueprint $table) {
            $table->dropIndex(['attendance_date', 'check_out_time']);
            $table->dropColumn('check_out_time');
        });
    }
};
