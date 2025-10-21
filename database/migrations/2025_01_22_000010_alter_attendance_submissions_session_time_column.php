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
        Schema::table('attendance_submissions', function (Blueprint $table) {
            // Change session_time from TIME to STRING to accommodate time ranges like "07:00-08:30"
            $table->string('session_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_submissions', function (Blueprint $table) {
            // Revert back to TIME column
            $table->time('session_time')->nullable()->change();
        });
    }
};