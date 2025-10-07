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
        Schema::table('quizzes', function (Blueprint $table) {
            // Add class_id column
            $table->foreignId('class_id')->nullable()->after('subject')->constrained('classes')->onDelete('set null');
            
            // Drop the old class column if it exists
            if (Schema::hasColumn('quizzes', 'class')) {
                $table->dropIndex(['class']);
                $table->dropColumn('class');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
            
            // Add back the old class column
            $table->string('class')->nullable()->after('subject');
            $table->index('class');
        });
    }
};