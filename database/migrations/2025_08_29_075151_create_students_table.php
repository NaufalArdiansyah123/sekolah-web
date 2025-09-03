<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// database/migrations/2024_01_01_000007_create_students_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nis')->unique();
            $table->string('nisn')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('class');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['male', 'female']);
            $table->string('parent_name');
            $table->string('parent_phone')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive', 'graduated'])->default('active');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};