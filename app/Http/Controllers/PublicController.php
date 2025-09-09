<?php
// app/Http/Controllers/PublicController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow; // Tambahkan ini untuk menggunakan model Slideshow
use App\Models\Download;
use App\Models\BlogPost;
use App\Models\Video;

class PublicController extends Controller
{
  public function index()
{
    $slideshows = Slideshow::all(); // ambil semua data dari tabel slideshow
    return view('home', compact('slideshows'));
}
    public function home()
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
    
    return view('public.home', [
        'title' => 'Beranda',
        'description' => 'Website resmi SMA Negeri 1 - Excellence in Education',
        'slideshows' => $slideshows, // Kirim data slideshow ke view
        'latestBlogs' => $latestBlogs // Kirim data blog terbaru
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

    public function news()
    {
        return view('public.news.index', [
            'title' => 'Berita Terkini'
        ]);
    }

    public function newsDetail($slug)
    {
        return view('public.news.show', [
            'title' => 'Detail Berita'
        ]);
    }

    public function announcements()
    {
        return view('public.announcements.index', [
            'title' => 'Pengumuman'
        ]);
    }

    public function agenda()
    {
        return view('public.agenda.index', [
            'title' => 'Agenda Kegiatan'
        ]);
    }

    public function galleryPhotos()
    {
        return view('public.gallery.photos', [
            'title' => 'Galeri Foto'
        ]);
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
    
    public function galleryIndex()
    {
        return view('public.videos.index', [
            'title' => 'Galeri Video dan Video'
        ]);
    }

    public function downloads(Request $request)
    {
        $query = Download::where('status', 'active');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'name':
                $query->orderBy('title');
                break;
            case 'downloads':
                $query->orderBy('download_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $downloads = $query->paginate(12);
        
        return view('public.downloads', [
            'title' => 'Download Center',
            'downloads' => $downloads
        ]);
    }

    public function contact()
    {
        return view('public.contact', [
            'title' => 'Kontak Kami'
        ]);
    }

    public function incrementDownload(Download $download)
    {
        $download->incrementDownloadCount();
        
        return response()->json([
            'success' => true,
            'download_count' => $download->download_count
        ]);
    }
}