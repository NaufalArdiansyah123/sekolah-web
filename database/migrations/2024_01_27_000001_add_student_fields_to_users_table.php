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
        Schema::table('users', function (Blueprint $table) {
            // Student specific fields
            $table->string('nis')->nullable()->unique()->after('email'); // Nomor Induk Siswa
            $table->string('birth_place')->nullable()->after('birth_date'); // Tempat lahir
            $table->string('religion')->nullable()->after('gender'); // Agama
            $table->string('class')->nullable()->after('religion'); // Kelas
            
            // Parent/Guardian information
            $table->string('parent_name')->nullable()->after('class'); // Nama orang tua/wali
            $table->string('parent_phone')->nullable()->after('parent_name'); // Telepon orang tua
            $table->string('parent_email')->nullable()->after('parent_phone'); // Email orang tua
            
            // Academic information
            $table->date('enrollment_date')->nullable()->after('parent_email'); // Tanggal masuk
            $table->string('student_id')->nullable()->after('enrollment_date'); // ID siswa internal
            
            // Update status enum to include pending
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nis',
                'birth_place',
                'religion',
                'class',
                'parent_name',
                'parent_phone',
                'parent_email',
                'enrollment_date',
                'student_id'
            ]);
            
            // Revert status enum
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }
};