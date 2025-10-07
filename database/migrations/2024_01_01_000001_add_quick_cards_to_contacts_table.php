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
        if (Schema::hasTable('contacts') && !Schema::hasColumn('contacts', 'quick_cards')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->json('quick_cards')->nullable()->after('social_media');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('quick_cards');
        });
    }
};