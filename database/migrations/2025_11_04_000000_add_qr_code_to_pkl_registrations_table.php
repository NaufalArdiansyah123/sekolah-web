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
        Schema::table('pkl_registrations', function (Blueprint $table) {
            $table->string('qr_code')->nullable()->unique()->after('catatan');
            $table->string('qr_image_path')->nullable()->after('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pkl_registrations', function (Blueprint $table) {
            $table->dropColumn(['qr_code', 'qr_image_path']);
        });
    }
};
