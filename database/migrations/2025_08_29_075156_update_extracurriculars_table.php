<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('extracurriculars', function (Blueprint $table) {
            // Add missing columns
            if (!Schema::hasColumn('extracurriculars', 'coach')) {
                $table->string('coach')->nullable()->after('description');
            }
            if (!Schema::hasColumn('extracurriculars', 'schedule')) {
                $table->text('schedule')->nullable()->after('coach');
            }
            if (!Schema::hasColumn('extracurriculars', 'image')) {
                $table->string('image')->nullable()->after('schedule');
            }
            if (!Schema::hasColumn('extracurriculars', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->after('image');
            }
            
            // Drop old column if exists
            if (Schema::hasColumn('extracurriculars', 'teacher_in_charge')) {
                $table->dropColumn('teacher_in_charge');
            }
        });
    }

    public function down()
    {
        Schema::table('extracurriculars', function (Blueprint $table) {
            $table->string('teacher_in_charge')->nullable();
            $table->dropColumn(['coach', 'schedule', 'image', 'user_id']);
        });
    }
};