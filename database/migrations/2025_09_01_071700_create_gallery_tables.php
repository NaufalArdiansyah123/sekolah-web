<?php
// database/migrations/2025_09_01_000000_create_gallery_tables.php
// Run: php artisan make:migration create_gallery_tables

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
        // Create gallery_albums table
        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->enum('category', [
                'school_events',
                'academic', 
                'extracurricular',
                'achievements',
                'facilities',
                'general'
            ]);
            $table->string('cover_photo')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('photo_count')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['category', 'is_published']);
            $table->index(['is_featured', 'created_at']);
        });

        // Create gallery_photos table
        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('album_id');
            $table->string('filename');
            $table->string('original_name');
            $table->string('path');
            $table->string('thumbnail_path');
            $table->unsignedBigInteger('file_size');
            $table->string('mime_type');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->text('alt_text')->nullable();
            $table->text('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('album_id')->references('id')->on('gallery_albums')->onDelete('cascade');
            $table->index(['album_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_photos');
        Schema::dropIfExists('gallery_albums');
    }
};