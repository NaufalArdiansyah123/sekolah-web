<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of videos for public
     */
    public function index(Request $request)
    {
        $query = Video::active()->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $videos = $query->paginate(12);
        $featuredVideos = Video::active()->featured()->latest()->take(6)->get();
        $categories = Video::getCategoryOptions();

        // Get video statistics
        $stats = [
            'total_videos' => Video::active()->count(),
            'total_views' => Video::active()->sum('views'),
            'total_downloads' => Video::active()->sum('downloads'),
            'categories_count' => Video::active()->distinct('category')->count(),
        ];

        return view('public.videos.index', compact('videos', 'featuredVideos', 'categories', 'stats'));
    }

    /**
     * Display the specified video
     */
    public function show(Video $video)
    {
        // Check if video is active
        if ($video->status !== 'active') {
            abort(404);
        }

        // Increment view count
        $video->incrementViews();

        // Get related videos
        $relatedVideos = Video::active()
            ->where('category', $video->category)
            ->where('id', '!=', $video->id)
            ->latest()
            ->take(6)
            ->get();

        return view('public.videos.show', compact('video', 'relatedVideos'));
    }

    /**
     * Download video file
     */
    public function download(Video $video)
    {
        // Check if video is active
        if ($video->status !== 'active') {
            abort(404);
        }

        $video->incrementDownloads();
        
        $filePath = storage_path('app/public/videos/' . $video->filename);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath, $video->original_name);
    }

    /**
     * Stream video file
     */
    public function stream(Video $video)
    {
        // Check if video is active
        if ($video->status !== 'active') {
            abort(404);
        }

        $filePath = storage_path('app/public/videos/' . $video->filename);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file($filePath, [
            'Content-Type' => $video->mime_type,
            'Content-Disposition' => 'inline; filename="' . $video->original_name . '"',
        ]);
    }

    /**
     * Get videos by category
     */
    public function category(Request $request, $category)
    {
        // Validate category
        if (!array_key_exists($category, Video::getCategoryOptions())) {
            abort(404);
        }

        $query = Video::active()->where('category', $category)->latest();

        // Search within category
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $videos = $query->paginate(12);
        $categoryName = Video::getCategoryOptions()[$category];
        $categories = Video::getCategoryOptions();

        return view('public.videos.category', compact('videos', 'category', 'categoryName', 'categories'));
    }

    /**
     * Search videos
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $query = $request->q;
        
        $videos = Video::active()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(12);

        $categories = Video::getCategoryOptions();

        return view('public.videos.search', compact('videos', 'query', 'categories'));
    }
}