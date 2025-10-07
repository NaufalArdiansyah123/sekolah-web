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
        Schema::create('study_programs', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('program_name');
            $table->string('program_code')->nullable();
            $table->text('description')->nullable();
            $table->enum('degree_level', ['D3', 'S1', 'S2', 'S3']);
            $table->string('faculty')->nullable();
            
            // Vision & Mission
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            
            // Career & Admission
            $table->text('career_prospects')->nullable();
            $table->text('admission_requirements')->nullable();
            
            // Academic Details
            $table->integer('duration_years')->nullable();
            $table->integer('total_credits')->nullable();
            $table->string('degree_title')->nullable();
            $table->enum('accreditation', ['A', 'B', 'C'])->nullable();
            
            // Admission & Costs
            $table->integer('capacity')->nullable();
            $table->decimal('tuition_fee', 15, 2)->nullable();
            
            // JSON Data
            $table->json('core_subjects')->nullable();
            $table->json('specializations')->nullable();
            $table->json('facilities')->nullable();
            
            // Media Files
            $table->string('program_image')->nullable();
            $table->string('brochure_file')->nullable();
            
            // Settings
            $table->boolean('is_active')->default(false);
            $table->boolean('is_featured')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'is_featured']);
            $table->index('degree_level');
            $table->index('faculty');
            $table->index('program_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_programs');
    }
};