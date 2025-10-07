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
        // Check if extracurriculars table exists, if not create it first
        if (!Schema::hasTable('extracurriculars')) {
            Schema::create('extracurriculars', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('coach')->nullable();
                $table->string('schedule')->nullable();
                $table->string('location')->nullable();
                $table->integer('max_participants')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->string('image')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();
                
                // Add foreign key if users table exists
                if (Schema::hasTable('users')) {
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                }
                
                // Add indexes
                $table->index('status');
                $table->index('name');
            });
        } else {
            // Table exists, fix status values
            try {
                // Update existing data to use correct status values
                $updated1 = DB::table('extracurriculars')
                    ->where('status', 'aktif')
                    ->update(['status' => 'active']);
                    
                $updated2 = DB::table('extracurriculars')
                    ->where('status', 'tidak_aktif')
                    ->update(['status' => 'inactive']);
                    
                if ($updated1 > 0 || $updated2 > 0) {
                    \Log::info("Fixed extracurricular status values: {$updated1} + {$updated2} records updated");
                }
            } catch (\Exception $e) {
                \Log::warning("Could not fix extracurricular status values: " . $e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('extracurriculars')) {
            try {
                // Revert back to old status values
                DB::table('extracurriculars')
                    ->where('status', 'active')
                    ->update(['status' => 'aktif']);
                    
                DB::table('extracurriculars')
                    ->where('status', 'inactive')
                    ->update(['status' => 'tidak_aktif']);
            } catch (\Exception $e) {
                \Log::warning("Could not revert extracurricular status values: " . $e->getMessage());
            }
        }
    }
};