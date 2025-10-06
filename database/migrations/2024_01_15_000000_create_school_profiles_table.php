<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('school_name');
            $table->string('school_logo')->nullable();
            $table->string('school_motto')->nullable();
            $table->text('about_description')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('history')->nullable();
            
            // School Details
            $table->integer('established_year')->nullable();
            $table->string('accreditation')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('principal_photo')->nullable();
            $table->json('vice_principals')->nullable(); // Array of vice principals
            
            // Contact Information
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->json('social_media')->nullable(); // Facebook, Instagram, etc.
            
            // Statistics
            $table->integer('student_count')->default(0);
            $table->integer('teacher_count')->default(0);
            $table->integer('staff_count')->default(0);
            $table->integer('industry_partnerships')->default(0);
            
            // Content Arrays
            $table->json('facilities')->nullable(); // Array of facilities
            $table->json('achievements')->nullable(); // Array of achievements
            $table->json('programs')->nullable(); // Array of study programs
            
            // Media
            $table->string('hero_image')->nullable();
            $table->json('gallery_images')->nullable(); // Array of gallery images
            
            // Additional Info
            $table->json('contact_info')->nullable(); // Additional contact details
            
            // Call to Action Section
            $table->string('cta_title')->nullable();
            $table->text('cta_description')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->string('cta_button_url')->nullable();
            
            $table->boolean('is_active')->default(false); // Only one profile can be active
            $table->json('meta_data')->nullable(); // For additional flexible data
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('is_active');
            $table->index('school_name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('school_profiles');
    }
};