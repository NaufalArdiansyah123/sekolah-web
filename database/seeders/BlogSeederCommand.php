<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class BlogSeederCommand extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting Blog Seeder...');
        
        // Check if blog_posts table exists
        if (!\Schema::hasTable('blog_posts')) {
            $this->command->error('❌ Table blog_posts does not exist. Please run migrations first.');
            $this->command->info('Run: php artisan migrate');
            return;
        }

        // Check if users table has data
        if (\App\Models\User::count() === 0) {
            $this->command->info('📝 No users found. Creating default user...');
            \App\Models\User::create([
                'name' => 'Admin Sekolah',
                'email' => 'admin@sman1balong.sch.id',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Run blog post seeder
        $this->call(BlogPostSeeder::class);
        
        $this->command->info('✅ Blog seeding completed successfully!');
        $this->command->info('📊 You can now visit:');
        $this->command->info('   - /blog (Blog index page)');
        $this->command->info('   - /news (News index page - same as blog)');
        $this->command->info('   - /admin/posts/blog (Admin blog management)');
    }
}