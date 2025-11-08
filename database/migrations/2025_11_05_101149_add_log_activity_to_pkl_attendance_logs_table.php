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
        Schema::table('pkl_attendance_logs', function (Blueprint $table) {
            $table->text('log_activity')->nullable()->after('status')->comment('Catatan aktivitas PKL hari ini');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pkl_attendance_logs', function (Blueprint $table) {
            $table->dropColumn('log_activity');
        });
    }
};
