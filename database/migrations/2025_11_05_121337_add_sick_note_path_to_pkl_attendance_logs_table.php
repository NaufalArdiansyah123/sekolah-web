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
            $table->string('sick_note_path')->nullable()->after('log_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pkl_attendance_logs', function (Blueprint $table) {
            $table->dropColumn('sick_note_path');
        });
    }
};
