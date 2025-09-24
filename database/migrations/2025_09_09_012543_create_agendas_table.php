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
        // Only create the table if it doesn't exist to avoid conflicts
        if (!Schema::hasTable('agendas')) {
            Schema::create('agendas', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->date('tanggal');
                $table->time('waktu')->nullable();
                $table->string('kategori')->nullable();
                $table->enum('prioritas', ['low', 'medium', 'high'])->default('medium');
                $table->string('lokasi')->nullable();
                $table->string('penanggung_jawab')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};