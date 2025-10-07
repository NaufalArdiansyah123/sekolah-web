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
        Schema::table('facilities', function (Blueprint $table) {
            // Add sort_order column if it doesn't exist
            if (!Schema::hasColumn('facilities', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('status');
            }
            
            // Add is_featured column if it doesn't exist
            if (!Schema::hasColumn('facilities', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('sort_order');
            }
            
            // Add capacity column if it doesn't exist
            if (!Schema::hasColumn('facilities', 'capacity')) {
                $table->integer('capacity')->nullable()->after('is_featured');
            }
            
            // Add location column if it doesn't exist
            if (!Schema::hasColumn('facilities', 'location')) {
                $table->string('location')->nullable()->after('capacity');
            }
            
            // Add features column if it doesn't exist
            if (!Schema::hasColumn('facilities', 'features')) {
                $table->json('features')->nullable()->after('location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            // Drop columns if they exist
            $columnsToCheck = ['sort_order', 'is_featured', 'capacity', 'location', 'features'];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('facilities', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};