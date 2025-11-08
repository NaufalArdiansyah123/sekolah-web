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
        Schema::table('students', function (Blueprint $table) {
            $table->enum('pkl_status', ['tidak_pkl', 'sedang_pkl', 'selesai_pkl'])->default('tidak_pkl')->after('phone');
            $table->unsignedBigInteger('active_pkl_registration_id')->nullable()->after('pkl_status');

            // Add foreign key constraint
            $table->foreign('active_pkl_registration_id')
                ->references('id')
                ->on('pkl_registrations')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['active_pkl_registration_id']);
            $table->dropColumn(['pkl_status', 'active_pkl_registration_id']);
        });
    }
};
