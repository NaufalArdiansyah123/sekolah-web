<?php

/**
 * Script untuk menjalankan Blog Seeder
 * Jalankan dengan: php seed-blog.php
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Bootstrap Laravel application
$app = Application::configure(basePath: __DIR__)
    ->withRouting(
        web: __DIR__.'/routes/web.php',
        commands: __DIR__.'/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "🚀 Starting Blog Seeder...\n";

try {
    // Check if blog_posts table exists
    if (!Schema::hasTable('blog_posts')) {
        echo "❌ Table blog_posts does not exist. Please run migrations first.\n";
        echo "Run: php artisan migrate\n";
        exit(1);
    }

    // Check if users table has data
    if (App\Models\User::count() === 0) {
        echo "📝 No users found. Creating default user...\n";
        App\Models\User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sman1balong.sch.id',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        echo "✅ Default user created.\n";
    }

    // Clear existing blog posts
    echo "🗑️ Clearing existing blog posts...\n";
    DB::table('blog_posts')->truncate();

    // Run blog post seeder
    echo "📝 Creating blog posts...\n";
    $seeder = new Database\Seeders\BlogPostSeeder();
    $seeder->run();

    echo "✅ Blog seeding completed successfully!\n";
    echo "📊 You can now visit:\n";
    echo "   - /blog (Blog index page)\n";
    echo "   - /news (News index page - same as blog)\n";
    echo "   - /admin/posts/blog (Admin blog management)\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}