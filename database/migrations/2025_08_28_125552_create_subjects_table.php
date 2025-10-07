<?php
// database/migrations/2024_01_01_000003_create_subjects_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Matematika, Bahasa Indonesia
            $table->string('code')->unique(); // MAT, BIN
            $table->text('description')->nullable();
            $table->integer('credit_hours')->default(2); // SKS/jam per minggu
            $table->enum('type', ['core', 'elective', 'extracurricular'])->default('core');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};