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
        Schema::table('school_profiles', function (Blueprint $table) {
            // Add CTA (Call to Action) fields if they don't exist
            if (!Schema::hasColumn('school_profiles', 'cta_title')) {
                $table->string('cta_title')->nullable()->after('meta_data');
            }
            if (!Schema::hasColumn('school_profiles', 'cta_description')) {
                $table->text('cta_description')->nullable()->after('cta_title');
            }
            if (!Schema::hasColumn('school_profiles', 'cta_button_text')) {
                $table->string('cta_button_text')->nullable()->after('cta_description');
            }
            if (!Schema::hasColumn('school_profiles', 'cta_button_url')) {
                $table->string('cta_button_url')->nullable()->after('cta_button_text');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_profiles', function (Blueprint $table) {
            $table->dropColumn(['cta_title', 'cta_description', 'cta_button_text', 'cta_button_url']);
        });
    }
};