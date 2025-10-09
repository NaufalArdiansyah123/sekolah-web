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
        // Add missing columns to facilities table
        Schema::table('facilities', function (Blueprint $table) {
            if (!Schema::hasColumn('facilities', 'name')) {
                $table->string('name')->after('id');
            }
            
            if (!Schema::hasColumn('facilities', 'description')) {
                $table->text('description')->after('name');
            }
            
            if (!Schema::hasColumn('facilities', 'category')) {
                $table->enum('category', ['academic', 'sport', 'technology', 'arts', 'other'])->default('other')->after('description');
            }
            
            if (!Schema::hasColumn('facilities', 'image')) {
                $table->string('image')->nullable()->after('category');
            }
            
            if (!Schema::hasColumn('facilities', 'features')) {
                $table->json('features')->nullable()->after('image');
            }
            
            if (!Schema::hasColumn('facilities', 'capacity')) {
                $table->integer('capacity')->nullable();
            }
            
            if (!Schema::hasColumn('facilities', 'location')) {
                $table->string('location')->nullable();
            }
            
            if (!Schema::hasColumn('facilities', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            
            if (!Schema::hasColumn('facilities', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
        });
        
        // Add indexes safely
        $this->addIndexesSafely();
    }

    /**
     * Add indexes safely without checking if they exist
     */
    private function addIndexesSafely()
    {
        try {
            \DB::statement('CREATE INDEX IF NOT EXISTS facilities_status_category_index ON facilities (status, category)');
        } catch (\Exception $e) {
            // Index might already exist or status column doesn't exist yet
        }
        
        try {
            \DB::statement('CREATE INDEX IF NOT EXISTS facilities_is_featured_status_index ON facilities (is_featured, status)');
        } catch (\Exception $e) {
            // Index might already exist
        }
        
        try {
            \DB::statement('CREATE INDEX IF NOT EXISTS facilities_sort_order_index ON facilities (sort_order)');
        } catch (\Exception $e) {
            // Index might already exist
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $columnsToCheck = [
                'name', 'description', 'category', 'image', 'features', 
                'capacity', 'location', 'is_featured', 'sort_order'
            ];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('facilities', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};