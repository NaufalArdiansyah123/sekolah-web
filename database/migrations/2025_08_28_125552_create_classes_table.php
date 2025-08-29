<?php
// database/migrations/2024_01_01_000002_create_classes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // X IPA 1, XI IPS 2
            $table->string('code')->unique(); // XA1, XIB2
            $table->enum('level', ['10', '11', '12']); // Grade level
            $table->enum('program', ['IPA', 'IPS', 'Bahasa'])->nullable();
            $table->integer('capacity')->default(30);
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('homeroom_teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};