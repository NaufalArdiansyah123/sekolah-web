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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('filename');
            $table->string('original_name');
            $table->string('mime_type');
            $table->bigInteger('file_size'); // in bytes
            $table->integer('duration')->nullable(); // in seconds
            $table->string('thumbnail')->nullable();
            $table->enum('category', ['dokumentasi', 'kegiatan', 'pembelajaran', 'prestasi', 'lainnya'])->default('dokumentasi');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->json('metadata')->nullable(); // for additional video info
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'category']);
            $table->index(['is_featured', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};