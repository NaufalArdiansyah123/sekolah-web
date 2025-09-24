<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Migration ini akan membuat tabel agendas jika belum ada,
     * untuk mengatasi masalah dependency order.
     */
    public function up(): void
    {
        // Create agendas table if it doesn't exist
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
                
                // Add indexes for better performance
                $table->index('tanggal');
                $table->index('prioritas');
                $table->index('kategori');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table in down() to avoid conflicts
        // The table will be handled by the main create_agendas_table migration
    }
};