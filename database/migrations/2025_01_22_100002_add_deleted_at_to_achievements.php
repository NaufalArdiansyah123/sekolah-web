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
        Schema::table('achievements', function (Blueprint $table) {
            // Tambah kolom deleted_at untuk soft deletes
            if (!Schema::hasColumn('achievements', 'deleted_at')) {
                $table->softDeletes()->after('updated_at');
            }
        });
        
        // Tambah indexes untuk performa yang lebih baik
        try {
            Schema::table('achievements', function (Blueprint $table) {
                $table->index(['is_active', 'is_featured'], 'idx_achievements_status');
                $table->index(['category', 'level'], 'idx_achievements_category_level');
                $table->index(['year', 'achievement_date'], 'idx_achievements_year_date');
                $table->index('sort_order', 'idx_achievements_sort');
            });
        } catch (Exception $e) {
            // Index mungkin sudah ada, abaikan error
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            if (Schema::hasColumn('achievements', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            
            // Drop indexes
            try {
                $table->dropIndex('idx_achievements_status');
                $table->dropIndex('idx_achievements_category_level');
                $table->dropIndex('idx_achievements_year_date');
                $table->dropIndex('idx_achievements_sort');
            } catch (Exception $e) {
                // Index mungkin tidak ada, abaikan error
            }
        });
    }
};