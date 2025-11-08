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
            $table->timestamp('check_out_time')->nullable()->after('longitude');
            $table->string('check_out_location')->nullable()->after('check_out_time');
            $table->decimal('check_out_latitude', 10, 8)->nullable()->after('check_out_location');
            $table->decimal('check_out_longitude', 11, 8)->nullable()->after('check_out_latitude');
            $table->decimal('check_out_accuracy', 6, 2)->nullable()->after('check_out_longitude');
            $table->text('check_out_user_agent')->nullable()->after('check_out_accuracy');
            $table->string('check_out_ip_address')->nullable()->after('check_out_user_agent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pkl_attendance_logs', function (Blueprint $table) {
            $table->dropColumn([
                'check_out_time',
                'check_out_location',
                'check_out_latitude',
                'check_out_longitude',
                'check_out_accuracy',
                'check_out_user_agent',
                'check_out_ip_address'
            ]);
        });
    }
};
