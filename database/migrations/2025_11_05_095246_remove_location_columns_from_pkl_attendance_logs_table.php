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
            // Drop check-in location columns
            $table->dropColumn([
                'location',
                'latitude',
                'longitude',
            ]);

            // Drop check-out location columns
            $table->dropColumn([
                'check_out_location',
                'check_out_latitude',
                'check_out_longitude',
                'check_out_accuracy',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pkl_attendance_logs', function (Blueprint $table) {
            // Restore check-in location columns
            $table->string('location')->nullable()->after('scan_time');
            $table->decimal('latitude', 10, 8)->nullable()->after('location');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');

            // Restore check-out location columns
            $table->string('check_out_location')->nullable()->after('check_out_time');
            $table->decimal('check_out_latitude', 10, 8)->nullable()->after('check_out_location');
            $table->decimal('check_out_longitude', 11, 8)->nullable()->after('check_out_latitude');
            $table->decimal('check_out_accuracy', 6, 2)->nullable()->after('check_out_longitude');
        });
    }
};
