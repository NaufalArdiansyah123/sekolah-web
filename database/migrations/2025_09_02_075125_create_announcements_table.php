<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->enum('kategori', ['akademik', 'kegiatan', 'administrasi', 'umum'])->default('umum');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->string('penulis')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('views')->default(0);
            $table->date('tanggal_publikasi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
};