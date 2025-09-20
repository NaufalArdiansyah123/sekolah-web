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
        Schema::create('extracurricular_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extracurricular_id')->constrained()->onDelete('cascade');
            $table->string('student_name');
            $table->string('student_class');
            $table->string('student_major');
            $table->string('student_nis')->unique();
            $table->string('email');
            $table->string('phone');
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->text('address');
            $table->text('reason');
            $table->text('experience')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['extracurricular_id', 'status']);
            $table->index('student_nis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_registrations');
    }
};