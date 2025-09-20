<?php
// app/Http/Controllers/PublicController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow; // Tambahkan ini untuk menggunakan model Slideshow

use App\Models\BlogPost;
use App\Models\Video;
use App\Models\Post;

class PublicController extends Controller
{
  public function index()
{
    $slideshows = Slideshow::where('status', 'active')
                          ->orderBy('order', 'asc')
                          ->get();
    
    // Get latest blog posts for homepage
    $latestBlogs = BlogPost::with('user')
                          ->published()
                          ->latest('published_at')
                          ->take(6)
                          ->get();
    
    // Get upcoming agendas for homepage
    $upcomingAgendas = Post::where('type', 'agenda')
                          ->where('status', 'published')
                          ->where('event_date', '>=', now())
                          ->orderBy('event_date', 'asc')
                          ->take(3)
                          ->get();
    
    return view('public.home', [
        'title' => 'Beranda',
        'description' => 'Website resmi SMA Negeri 1 - Excellence in Education',
        'slideshows' => $slideshows,
        'latestBlogs' => $latestBlogs,
        'upcomingAgendas' => $upcomingAgendas
    ]);
}


    public function aboutProfile()
    {
        return view('public.about.profile', [
            'title' => 'Profil Sekolah'
        ]);
    }

    public function aboutVision()
    {
        return view('public.about.vision', [
            'title' => 'Visi & Misi'
        ]);
    }
    
    public function sejarah()
    {
        return view('public.about.sejarah', [
            'title' => 'Sejarah Sekolah'
        ]);
    }

    public function facilities()
    {
        return view('public.facilities.index', [
            'title' => 'Fasilitas Sekolah'
        ]);
    }

    public function achievements()
    {
        return view('public.achievements.index', [
            'title' => 'Prestasi Sekolah'
        ]);
    }

    public function extracurriculars()
    {
        return view('public.extracurriculars.index', [
            'title' => 'Ekstrakurikuler'
        ]);
    }

    public function academicPrograms()
    {
        return view('public.academic.programs', [
            'title' => 'Program Studi'
        ]);
    }

    public function academicCalendar()
    {
        return view('public.academic.calendar', [
            'title' => 'Kalender Akademik'
        ]);
    }

    public function news(Request $request)
    {
        $query = BlogPost::with('user')
                         ->published()
                         ->latest('published_at');

        // Search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $blogs = $query->paginate(12);
        
        // Get categories for filter
        $categories = BlogPost::published()
                             ->distinct()
                             ->pluck('category')
                             ->filter()
                             ->sort();

        // Get latest blogs for sidebar
        $latestBlogs = BlogPost::published()
                              ->latest('published_at')
                              ->take(5)
                              ->get();

        return view('public.news.index', [
            'title' => 'Berita Terkini',
            'blogs' => $blogs,
            'categories' => $categories,
            'latestBlogs' => $latestBlogs
        ]);
    }

    public function newsDetail($id)
    {
        $blog = BlogPost::with('user')
                       ->published()
                       ->findOrFail($id);
        
        // Load the user relationship
        $blog->load('user');
        
        // Get related blogs
        $relatedBlogs = BlogPost::published()
                               ->where('id', '!=', $blog->id)
                               ->where('category', $blog->category)
                               ->latest('published_at')
                               ->take(4)
                               ->get();
        
        // If not enough related blogs, get more from other categories
        if ($relatedBlogs->count() < 4) {
            $additionalBlogs = BlogPost::published()
                                      ->where('id', '!=', $blog->id)
                                      ->whereNotIn('id', $relatedBlogs->pluck('id'))
                                      ->latest('published_at')
                                      ->take(4 - $relatedBlogs->count())
                                      ->get();
            $relatedBlogs = $relatedBlogs->merge($additionalBlogs);
        }

        return view('public.news.show', [
            'title' => $blog->title,
            'blog' => $blog,
            'relatedBlogs' => $relatedBlogs
        ]);
    }

    public function agenda(Request $request)
    {
        $query = Post::where('type', 'agenda')
                    ->where('status', 'published')
                    ->latest('event_date');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Period filter
        if ($request->filled('period')) {
            switch ($request->period) {
                case 'upcoming':
                    $query->where('event_date', '>', now());
                    break;
                case 'today':
                    $query->whereDate('event_date', today());
                    break;
                case 'this_week':
                    $query->whereBetween('event_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('event_date', now()->month)
                          ->whereYear('event_date', now()->year);
                    break;
                case 'past':
                    $query->where('event_date', '<', now());
                    break;
            }
        }

        // Month filter (only if period is not set to specific time ranges)
        if ($request->filled('month') && !in_array($request->period, ['today', 'this_week', 'this_month'])) {
            $query->whereMonth('event_date', $request->month);
        }
        
        // Year filter
        if ($request->filled('year') && !in_array($request->period, ['today', 'this_week', 'this_month'])) {
            $query->whereYear('event_date', $request->year);
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'date_asc':
                $query->orderBy('event_date', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('event_date', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default: // latest
                $query->latest('event_date');
        }
        
        $agendas = $query->paginate(10);
        
        // Statistics
        $totalAgenda = Post::where('type', 'agenda')->where('status', 'published')->count();
        $upcomingAgenda = Post::where('type', 'agenda')->where('status', 'published')->where('event_date', '>', now())->count();
        $todayAgenda = Post::where('type', 'agenda')->where('status', 'published')->whereDate('event_date', today())->count();
        $agendaWithLocation = Post::where('type', 'agenda')->where('status', 'published')->whereNotNull('location')->count();

        return view('public.agenda.index', [
            'title' => 'Agenda Kegiatan',
            'agendas' => $agendas,
            'totalAgenda' => $totalAgenda,
            'upcomingAgenda' => $upcomingAgenda,
            'todayAgenda' => $todayAgenda,
            'agendaWithLocation' => $agendaWithLocation
        ]);
    }
    
    public function agendaDetail($id)
    {
        $agenda = Post::where('type', 'agenda')
                     ->where('status', 'published')
                     ->findOrFail($id);
        
        // Get related agendas
        $relatedAgendas = Post::where('type', 'agenda')
                             ->where('status', 'published')
                             ->where('id', '!=', $id)
                             ->latest('event_date')
                             ->take(3)
                             ->get();
        
        return view('public.agenda.show', [
            'title' => $agenda->title,
            'agenda' => $agenda,
            'relatedAgendas' => $relatedAgendas
        ]);
    }

    public function galleryPhotos()
    {
        // Redirect to main gallery index
        return redirect()->route('gallery.index');
    }

    public function galleryVideos()
    {
        return view('public.gallery.videos', [
            'title' => 'Galeri Video'
        ]);
    }
    
    public function videos(Request $request)
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

        return view('public.videos.index', [
            'title' => 'Video Dokumentasi',
            'videos' => $videos,
            'featuredVideos' => $featuredVideos,
            'categories' => $categories,
            'stats' => $stats
        ]);
    }
    
    public function videoDetail($id)
    {
        $video = Video::active()->findOrFail($id);
        
        // Increment view count
        $video->increment('views');
        
        // Get related videos
        $relatedVideos = Video::active()
                             ->where('id', '!=', $id)
                             ->where('category', $video->category)
                             ->latest()
                             ->take(6)
                             ->get();
        
        // If not enough related videos, get more from other categories
        if ($relatedVideos->count() < 6) {
            $additionalVideos = Video::active()
                                   ->where('id', '!=', $id)
                                   ->whereNotIn('id', $relatedVideos->pluck('id'))
                                   ->latest()
                                   ->take(6 - $relatedVideos->count())
                                   ->get();
            $relatedVideos = $relatedVideos->merge($additionalVideos);
        }
        
        return view('public.videos.show', [
            'title' => $video->title,
            'video' => $video,
            'relatedVideos' => $relatedVideos
        ]);
    }
    
    public function incrementVideoView($id)
    {
        $video = Video::active()->findOrFail($id);
        $video->increment('views');
        
        return response()->json(['success' => true, 'views' => $video->views]);
    }
    
    public function videoDownload($id)
    {
        $video = Video::active()->findOrFail($id);
        
        // Increment download count
        $video->increment('downloads');
        
        // Check if video file exists
        if (!$video->filename || !file_exists(storage_path('app/public/videos/' . $video->filename))) {
            abort(404, 'Video file not found');
        }
        
        $filePath = storage_path('app/public/videos/' . $video->filename);
        $fileName = $video->original_name ?: ($video->title . '.' . pathinfo($video->filename, PATHINFO_EXTENSION));
        
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }
    
    public function galleryIndex()
    {
        return redirect()->route('gallery.index');
    }



    public function contact()
    {
        return view('public.contact');
    }

    public function announcements(Request $request)
    {
        $query = Post::where('type', 'announcement')
                    ->where('status', 'published')
                    ->with('user')
                    ->latest('published_at');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $announcements = $query->paginate(12);
        
        // Get categories for filter
        $categories = Post::where('type', 'announcement')
                         ->where('status', 'published')
                         ->distinct()
                         ->pluck('category')
                         ->filter()
                         ->sort();

        // Get priorities for filter
        $priorities = Post::where('type', 'announcement')
                         ->where('status', 'published')
                         ->distinct()
                         ->pluck('priority')
                         ->filter()
                         ->sort();
        
        return view('public.announcements.index', [
            'title' => 'Pengumuman Sekolah',
            'announcements' => $announcements,
            'categories' => $categories,
            'priorities' => $priorities
        ]);
    }

    public function announcementDetail($id)
    {
        $announcement = Post::where('type', 'announcement')
                           ->where('status', 'published')
                           ->with('user')
                           ->findOrFail($id);
        
        // Increment view count
        $announcement->increment('views_count');
        
        // Get related announcements
        $relatedAnnouncements = Post::where('type', 'announcement')
                                   ->where('status', 'published')
                                   ->where('id', '!=', $id)
                                   ->where('category', $announcement->category)
                                   ->latest('published_at')
                                   ->take(4)
                                   ->get();
        
        // If not enough related announcements, get more from other categories
        if ($relatedAnnouncements->count() < 4) {
            $additionalAnnouncements = Post::where('type', 'announcement')
                                          ->where('status', 'published')
                                          ->where('id', '!=', $id)
                                          ->whereNotIn('id', $relatedAnnouncements->pluck('id'))
                                          ->latest('published_at')
                                          ->take(4 - $relatedAnnouncements->count())
                                          ->get();
            $relatedAnnouncements = $relatedAnnouncements->merge($additionalAnnouncements);
        }
        
        return view('public.announcements.show', [
            'title' => $announcement->title,
            'announcement' => $announcement,
            'relatedAnnouncements' => $relatedAnnouncements
        ]);
    }

    public function submitContact(Request $request)
    {
        // Handle contact form submission
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Here you would typically save to database or send email
        // For now, just return success
        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }


}