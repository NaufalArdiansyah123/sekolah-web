<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek struktur tabel yang ada
        $columns = Schema::getColumnListing('achievements');
        
        Schema::table('achievements', function (Blueprint $table) use ($columns) {
            // Tambah kolom yang hilang jika belum ada
            if (!in_array('category', $columns)) {
                $table->string('category')->nullable()->after('description');
            }
            if (!in_array('level', $columns)) {
                $table->string('level')->nullable()->after('category');
            }
            if (!in_array('year', $columns)) {
                $table->integer('year')->nullable()->after('level');
            }
            if (!in_array('organizer', $columns)) {
                $table->string('organizer')->nullable()->after('achievement_date');
            }
            if (!in_array('participant', $columns)) {
                $table->string('participant')->nullable()->after('organizer');
            }
            if (!in_array('position', $columns)) {
                $table->string('position')->nullable()->after('participant');
            }
            if (!in_array('image', $columns)) {
                $table->string('image')->nullable()->after('position');
            }
            if (!in_array('additional_info', $columns)) {
                $table->text('additional_info')->nullable()->after('image');
            }
            if (!in_array('is_featured', $columns)) {
                $table->boolean('is_featured')->default(false)->after('additional_info');
            }
            if (!in_array('is_active', $columns)) {
                $table->boolean('is_active')->default(true)->after('is_featured');
            }
            if (!in_array('meta_title', $columns)) {
                $table->string('meta_title')->nullable()->after('is_active');
            }
            if (!in_array('meta_description', $columns)) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!in_array('sort_order', $columns)) {
                $table->integer('sort_order')->default(0)->after('meta_description');
            }
            if (!in_array('deleted_at', $columns)) {
                $table->softDeletes()->after('updated_at');
            }
        });
        
        // Tambah indexes untuk performa yang lebih baik
        try {
            Schema::table('achievements', function (Blueprint $table) {
                $table->index(['is_active', 'is_featured']);
                $table->index(['category', 'level']);
                $table->index(['year', 'achievement_date']);
                $table->index('sort_order');
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
            // Hapus kolom yang ditambahkan (hati-hati dengan data yang ada)
            $columns = Schema::getColumnListing('achievements');
            
            $columnsToRemove = [
                'category', 'level', 'year', 'organizer', 'participant', 
                'position', 'image', 'additional_info', 'is_featured', 
                'is_active', 'meta_title', 'meta_description', 'sort_order', 
                'deleted_at'
            ];
            
            foreach ($columnsToRemove as $column) {
                if (in_array($column, $columns)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};