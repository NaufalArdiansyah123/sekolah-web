<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    // ========== PUBLIC METHODS (untuk halaman publik) ==========
    
    /**
     * Halaman publik untuk daftar announcements
     */
    public function publicIndex(Request $request)
    {
        // Query menggunakan Post Model untuk konsistensi
        $query = Post::where('type', 'announcement')->where('status', 'published')->latest();
        
        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('content', 'LIKE', '%' . $request->search . '%');
            });
        }
        
        // Filter berdasarkan kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        // Filter berdasarkan bulan
        if ($request->filled('month')) {
            $date = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('created_at', $date->year)
                  ->whereMonth('created_at', $date->month);
        }
        
        // Pagination
        $announcements = $query->paginate(10);
        
        // Announcements terpopuler berdasarkan views
        $popularAnnouncements = Post::where('type', 'announcement')
                                   ->where('status', 'published')
                                   ->orderBy('views_count', 'desc')
                                   ->limit(5)
                                   ->get();
        
        // Hitung jumlah announcements per kategori
        $kategoriCounts = Post::where('type', 'announcement')
                             ->where('status', 'published')
                             ->selectRaw('category, COUNT(*) as count')
                             ->groupBy('category')
                             ->pluck('count', 'category')
                             ->toArray();
        
        // Bulan-bulan yang tersedia untuk arsip
        $availableMonths = Post::where('type', 'announcement')
                              ->where('status', 'published')
                              ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
                              ->distinct()
                              ->orderBy('year', 'desc')
                              ->orderBy('month', 'desc')
                              ->get()
                              ->map(function ($item) {
                                  return [
                                      'value' => $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT),
                                      'text' => Carbon::createFromDate($item->year, $item->month, 1)->format('F Y')
                                  ];
                              });
        
        return view('public.announcements.index', compact(
            'announcements',
            'popularAnnouncements', 
            'kategoriCounts',
            'availableMonths'
        ));
    }
    
    /**
     * Halaman publik untuk detail announcement
     */
    public function publicShow($id)
    {
        $announcement = Post::where('type', 'announcement')->where('status', 'published')->findOrFail($id);
        
        // Increment views
        $announcement->increment('views_count');
        
        // Get related announcements from same category
        $relatedAnnouncements = Post::where('type', 'announcement')
                                   ->where('status', 'published')
                                   ->where('id', '!=', $id)
                                   ->where('category', $announcement->category)
                                   ->latest()
                                   ->limit(5)
                                   ->get();
        
        // If not enough related announcements, get more from other categories
        if ($relatedAnnouncements->count() < 5) {
            $additionalAnnouncements = Post::where('type', 'announcement')
                                          ->where('status', 'published')
                                          ->where('id', '!=', $id)
                                          ->whereNotIn('id', $relatedAnnouncements->pluck('id'))
                                          ->latest()
                                          ->limit(5 - $relatedAnnouncements->count())
                                          ->get();
            $relatedAnnouncements = $relatedAnnouncements->merge($additionalAnnouncements);
        }
        
        return view('public.announcements.show', compact('announcement', 'relatedAnnouncements'));
    }

    // ========== ADMIN METHODS (yang sudah ada, sedikit diperbaiki) ==========
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Use Announcement model for admin page
        $query = Announcement::query();
        
        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('isi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('penulis', 'LIKE', '%' . $request->search . '%');
            });
        }
        
        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan prioritas
        if ($request->filled('priority')) {
            $query->where('prioritas', $request->priority);
        }
        
        $announcements = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts.announcement.index', compact('announcements'));
    }

    public function announcements()
    {
        // Method ini tetap ada untuk backward compatibility
        $announcements = Post::where('type', 'announcement')
                            ->where('status', 'published')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('public.announcements.index', compact('announcements'));
    }
    
    public function create()
    {
        return view('admin.posts.announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'kategori' => 'required|in:akademik,kegiatan,administrasi,umum',
            'prioritas' => 'required|in:low,normal,high,urgent',
            'penulis' => 'required|string|max:100',
            'status' => 'required|in:draft,published,archived'
        ]);

        // Map English priority values to Indonesian values for database
        $mappedPriority = Announcement::mapPriorityToIndonesian($request->prioritas);

        // Create announcement using Announcement model
        Announcement::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul . '-' . time()),
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'prioritas' => $mappedPriority, // Use mapped Indonesian value
            'penulis' => $request->penulis,
            'status' => $request->status,
            'views' => 0,
            'tanggal_publikasi' => $request->status === 'published' ? now() : null,
            'gambar' => null,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Increment views untuk admin juga (optional, bisa dihilangkan)
        $announcement->increment('views');

        return view('admin.posts.announcement.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('admin.posts.announcement.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'kategori' => 'required|in:akademik,kegiatan,administrasi,umum',
            'prioritas' => 'required|in:low,normal,high,urgent',
            'penulis' => 'required|string|max:100',
            'status' => 'required|in:draft,published,archived',
            'tanggal_publikasi' => 'nullable|date',
            'gambar' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120' // 5MB max
        ]);

        // Map English priority values to Indonesian values for database
        $mappedPriority = Announcement::mapPriorityToIndonesian($request->prioritas);

        $announcement = Announcement::findOrFail($id);
        $imagePath = $announcement->gambar; // Keep existing image by default
        
        // Handle file upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if it exists and is stored locally
            if ($announcement->gambar && str_starts_with($announcement->gambar, 'storage/')) {
                $oldPath = str_replace('storage/', '', $announcement->gambar);
                Storage::disk('public')->delete($oldPath);
            }
            
            $file = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('announcements', $filename, 'public');
            $imagePath = 'storage/' . $imagePath;
        }
        // Handle URL input
        elseif ($request->filled('gambar')) {
            // Validate URL length
            if (strlen($request->gambar) > 255) {
                return back()->withErrors(['gambar' => 'Image URL must not exceed 255 characters.'])->withInput();
            }
            
            // Validate if it's a proper URL
            if (!filter_var($request->gambar, FILTER_VALIDATE_URL)) {
                return back()->withErrors(['gambar' => 'Please enter a valid image URL.'])->withInput();
            }
            
            // Delete old local image if switching to URL
            if ($announcement->gambar && str_starts_with($announcement->gambar, 'storage/')) {
                $oldPath = str_replace('storage/', '', $announcement->gambar);
                Storage::disk('public')->delete($oldPath);
            }
            
            $imagePath = $request->gambar;
        }
        // Handle base64 data (from drag & drop)
        elseif ($request->filled('gambar') && str_starts_with($request->gambar, 'data:image/')) {
            try {
                // Delete old image if it exists and is stored locally
                if ($announcement->gambar && str_starts_with($announcement->gambar, 'storage/')) {
                    $oldPath = str_replace('storage/', '', $announcement->gambar);
                    Storage::disk('public')->delete($oldPath);
                }
                
                // Extract base64 data
                $imageData = $request->gambar;
                $image = str_replace('data:image/', '', $imageData);
                $image = explode(';base64,', $image);
                $imageType = $image[0];
                $imageData = base64_decode($image[1]);
                
                // Generate filename
                $filename = time() . '_' . Str::random(10) . '.' . $imageType;
                $path = 'announcements/' . $filename;
                
                // Store file
                Storage::disk('public')->put($path, $imageData);
                $imagePath = 'storage/' . $path;
            } catch (\Exception $e) {
                return back()->withErrors(['gambar' => 'Failed to process uploaded image.'])->withInput();
            }
        }

        $announcement->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul . '-' . time()),
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'prioritas' => $mappedPriority, // Use mapped Indonesian value
            'penulis' => $request->penulis,
            'status' => $request->status,
            'tanggal_publikasi' => $request->status === 'published' ? ($request->tanggal_publikasi ?: now()) : null,
            'gambar' => $imagePath,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus!');
    }

    /**
     * Toggle status of announcement
     */
    public function toggleStatus($id)
    {
        $announcement = Announcement::findOrFail($id);

        $newStatus = $announcement->status === 'published' ? 'draft' : 'published';
        $announcement->update([
            'status' => $newStatus,
            'tanggal_publikasi' => $newStatus === 'published' ? now() : null
        ]);

        return response()->json(['success' => true, 'status' => $newStatus]);
    }
}