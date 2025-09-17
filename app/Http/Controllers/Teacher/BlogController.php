<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BlogPost::with('user')->latest();

        // Apply filters
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $blogs = $query->paginate(10);

        return view('teacher.posts.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.posts.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'content' => 'required|string',
            'category' => 'nullable|string|in:berita,pengumuman,kegiatan,prestasi',
            'status' => 'nullable|string|in:draft,published,archived',
            'meta_description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'nullable|string|max:255'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['featured_image'] = $request->file('image')->store('blog-images', 'public');
        }

        // Set default values
        $validated['category'] = $validated['category'] ?? 'berita';
        $validated['status'] = $validated['status'] ?? 'published';
        $validated['user_id'] = auth()->id();
        
        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        BlogPost::create($validated);

        return redirect()->route('teacher.posts.blog.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blog)
    {
        return view('teacher.posts.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blog)
    {
        return view('teacher.posts.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,' . $blog->id,
            'content' => 'required|string',
            'category' => 'nullable|string|in:berita,pengumuman,kegiatan,prestasi',
            'status' => 'nullable|string|in:draft,published,archived',
            'meta_description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'nullable|string|max:255'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('image')->store('blog-images', 'public');
        }

        // Set published_at if status changed to published
        if ($validated['status'] === 'published' && $blog->status !== 'published') {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('teacher.posts.blog.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blog)
    {
        // Delete featured image if exists
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('teacher.posts.blog.index')->with('success', 'Berita berhasil dihapus!');
    }
}