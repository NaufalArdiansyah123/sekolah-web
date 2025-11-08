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
            $table->date('tanggal_mulai')->nullable()->after('tempat_pkl_id');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
            $table->text('alasan')->nullable()->after('tanggal_selesai');
            $table->string('surat_pengantar')->nullable()->after('alasan');
            $table->text('catatan')->nullable()->after('surat_pengantar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pkl_registrations', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai', 'alasan', 'surat_pengantar', 'catatan']);
        });
    }
};
