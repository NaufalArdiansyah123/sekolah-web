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
            // is_all_day already exists in main migration, skip adding it
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
            // Don't drop is_all_day as it's part of main migration
        });
    }
};