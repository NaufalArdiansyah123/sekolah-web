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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            
            // Basic post information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            
            // Post classification  
            $table->enum('type', ['blog', 'agenda', 'quote', 'announcement'])->default('blog');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('category', 100)->nullable();
            $table->json('tags')->nullable();
            
            // Author information
            $table->string('author')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Publishing information
            $table->timestamp('published_at')->nullable();
            
            // Media
            $table->string('featured_image')->nullable();
            $table->string('image_alt')->nullable();
            
            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('keywords')->nullable();
            
            // Analytics
            $table->unsignedInteger('views_count')->default(0);
            
            // Agenda specific fields
            $table->timestamp('event_date')->nullable();
            $table->string('location')->nullable();
            
            // Legacy fields (keep for compatibility)
            $table->text('schedule')->nullable(); // Keep existing field
            $table->string('image')->nullable(); // Keep existing field
            
            // Announcement specific fields
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->timestamp('expires_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['type', 'status']);
            $table->index(['published_at']);
            $table->index(['category']);
            $table->index(['user_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};