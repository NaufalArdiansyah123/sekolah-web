<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BlogPost;
use Illuminate\Support\Str;

class FixBlogSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:fix-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix empty or null slugs for blog posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing blog post slugs...');

        // Find blog posts with empty or null slugs
        $postsWithoutSlugs = BlogPost::whereNull('slug')
            ->orWhere('slug', '')
            ->get();

        if ($postsWithoutSlugs->isEmpty()) {
            $this->info('No blog posts found with empty slugs.');
            return;
        }

        $this->info("Found {$postsWithoutSlugs->count()} blog posts with empty slugs.");

        $bar = $this->output->createProgressBar($postsWithoutSlugs->count());
        $bar->start();

        foreach ($postsWithoutSlugs as $post) {
            // Generate unique slug
            $slug = $this->generateUniqueSlug($post->title);
            
            // Update the post
            $post->update(['slug' => $slug]);
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All blog post slugs have been fixed!');
    }

    /**
     * Generate a unique slug for the given title
     */
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (BlogPost::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}