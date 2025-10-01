<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts
     */
    public function index(Request $request)
    {
        // Try BlogPost first, then fallback to Post model with type='blog'
        $blogPostCount = BlogPost::published()->count();
        
        if ($blogPostCount > 0) {
            // Use BlogPost model
            $query = BlogPost::with('user')
                ->published()
                ->latest('published_at');

            // Apply filters
            if ($request->filled('search')) {
                $query->search($request->search);
            }

            if ($request->filled('category')) {
                $query->byCategory($request->category);
            }

            $blogs = $query->paginate(9);
            
            // Get categories for filter
            $categories = BlogPost::published()
                ->select('category')
                ->distinct()
                ->pluck('category')
                ->filter()
                ->sort();

            // Get latest blogs for sidebar
            $latestBlogs = BlogPost::published()
                ->latest('published_at')
                ->take(5)
                ->get();

            // Get popular blogs
            $popularBlogs = BlogPost::published()
                ->latest('published_at')
                ->take(5)
                ->get();
        } else {
            // Fallback to Post model with type='blog'
            $query = \App\Models\Post::with('user')
                ->where('type', 'blog')
                ->where('status', 'published')
                ->latest('published_at');

            // Apply filters
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('title', 'like', "%{$request->search}%")
                      ->orWhere('content', 'like', "%{$request->search}%");
                });
            }

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            $blogs = $query->paginate(9);
            
            // Get categories for filter
            $categories = \App\Models\Post::where('type', 'blog')
                ->where('status', 'published')
                ->select('category')
                ->distinct()
                ->pluck('category')
                ->filter()
                ->sort();

            // Get latest blogs for sidebar
            $latestBlogs = \App\Models\Post::where('type', 'blog')
                ->where('status', 'published')
                ->latest('published_at')
                ->take(5)
                ->get();

            // Get popular blogs
            $popularBlogs = \App\Models\Post::where('type', 'blog')
                ->where('status', 'published')
                ->latest('published_at')
                ->take(5)
                ->get();
        }

        return view('public.blog.index', compact('blogs', 'categories', 'latestBlogs', 'popularBlogs'));
    }

    /**
     * Display the specified blog post
     */
    public function show($id)
    {
        // Try BlogPost first, then fallback to Post model
        try {
            $blog = BlogPost::with('user')
                ->published()
                ->findOrFail($id);
            
            // Get related blogs (same category)
            $relatedBlogs = BlogPost::published()
                ->where('category', $blog->category)
                ->where('id', '!=', $blog->id)
                ->latest('published_at')
                ->take(4)
                ->get();

            // Get latest blogs for sidebar
            $latestBlogs = BlogPost::published()
                ->latest('published_at')
                ->take(5)
                ->get();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Fallback to Post model
            $blog = \App\Models\Post::with('user')
                ->where('type', 'blog')
                ->where('status', 'published')
                ->findOrFail($id);
            
            // Get related blogs (same category)
            $relatedBlogs = \App\Models\Post::where('type', 'blog')
                ->where('status', 'published')
                ->where('category', $blog->category)
                ->where('id', '!=', $blog->id)
                ->latest('published_at')
                ->take(4)
                ->get();

            // Get latest blogs for sidebar
            $latestBlogs = \App\Models\Post::where('type', 'blog')
                ->where('status', 'published')
                ->latest('published_at')
                ->take(5)
                ->get();
        }

        return view('public.blog.show', compact('blog', 'relatedBlogs', 'latestBlogs'));
    }

    /**
     * Get latest blogs for homepage
     */
    public function getLatestForHome($limit = 6)
    {
        return BlogPost::with('user')
            ->published()
            ->latest('published_at')
            ->take($limit)
            ->get();
    }
}