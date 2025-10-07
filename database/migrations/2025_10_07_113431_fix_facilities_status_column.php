<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('facilities', function (Blueprint $table) {
            // Ubah kolom status menjadi ENUM dengan nilai active dan inactive
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }

    public function down()
    {
        Schema::table('facilities', function (Blueprint $table) {
            // Kembalikan ke struktur lama jika rollback
            $table->enum('status', ['draft', 'published'])->default('draft')->change();
        });
    }
};