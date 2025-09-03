<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// database/migrations/2024_01_01_000005_create_achievements_table.php
return new class extends Migration
{
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('achievement_date');
            $table->enum('level', ['school', 'district', 'city', 'province', 'national', 'international']);
            $table->string('rank')->nullable();
            $table->string('certificate')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('achievements');
    }
};
