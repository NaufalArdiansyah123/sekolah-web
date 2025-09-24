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
        Schema::table('calendar_events', function (Blueprint $table) {
            if (!Schema::hasColumn('calendar_events', 'start_time')) {
                $table->time('start_time')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('calendar_events', 'end_time')) {
                $table->time('end_time')->nullable()->after('end_date');
            }
            if (!Schema::hasColumn('calendar_events', 'is_all_day')) {
                $table->boolean('is_all_day')->default(false)->after('end_time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            if (Schema::hasColumn('calendar_events', 'start_time')) {
                $table->dropColumn('start_time');
            }
            if (Schema::hasColumn('calendar_events', 'end_time')) {
                $table->dropColumn('end_time');
            }
            if (Schema::hasColumn('calendar_events', 'is_all_day')) {
                $table->dropColumn('is_all_day');
            }
        });
    }
};