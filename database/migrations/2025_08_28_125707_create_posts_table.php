<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->enum('type', [
                'slideshow', 'agenda', 'announcement', 
                'editorial', 'blog', 'quotes', 'facility',
                'extracurricular', 'achievement', 'staff'
            ]);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('meta_data')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['type', 'status']);
            $table->index(['published_at', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};