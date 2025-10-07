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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('category', ['academic', 'sport', 'technology', 'arts', 'other'])->default('other');
            $table->string('image')->nullable();
            $table->json('features')->nullable(); // Array fitur-fitur fasilitas
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->integer('capacity')->nullable(); // Kapasitas fasilitas
            $table->string('location')->nullable(); // Lokasi fasilitas
            $table->boolean('is_featured')->default(false); // Apakah fasilitas unggulan
            $table->integer('sort_order')->default(0); // Urutan tampil
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['status', 'category']);
            $table->index(['is_featured', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
