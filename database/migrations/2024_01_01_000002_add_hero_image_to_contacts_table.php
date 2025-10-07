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
        if (Schema::hasTable('contacts') && !Schema::hasColumn('contacts', 'hero_image')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('hero_image')->nullable()->after('quick_cards');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('contacts', 'hero_image')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('hero_image');
            });
        }
    }
};