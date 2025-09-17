<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        // Query menggunakan Eloquent Model untuk konsistensi
        $query = Announcement::where('status', 'published')->latest();
        
        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('isi', 'LIKE', '%' . $request->search . '%');
            });
        }
        
        // Filter berdasarkan kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('kategori', $request->category);
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
        $popularAnnouncements = Announcement::where('status', 'published')
                                           ->orderBy('views', 'desc')
                                           ->limit(5)
                                           ->get();
        
        // Hitung jumlah announcements per kategori
        $kategoriCounts = Announcement::where('status', 'published')
                                    ->selectRaw('kategori, COUNT(*) as count')
                                    ->groupBy('kategori')
                                    ->pluck('count', 'kategori')
                                    ->toArray();
        
        // Bulan-bulan yang tersedia untuk arsip
        $availableMonths = Announcement::where('status', 'published')
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
        $announcement = Announcement::where('status', 'published')->findOrFail($id);
        
        // Increment views
        $announcement->increment('views');
        
        // Get related announcements from same category
        $relatedAnnouncements = Announcement::where('status', 'published')
                                           ->where('id', '!=', $id)
                                           ->where('kategori', $announcement->kategori)
                                           ->latest()
                                           ->limit(5)
                                           ->get();
        
        // If not enough related announcements, get more from other categories
        if ($relatedAnnouncements->count() < 5) {
            $additionalAnnouncements = Announcement::where('status', 'published')
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
        // Menggunakan Eloquent untuk konsistensi dengan filtering
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
        $announcements = Announcement::where('status', 'published')
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
            'kategori' => 'required|in:akademik,kegiatan,administrasi',
            'prioritas' => 'required|in:normal,sedang,tinggi',
            'penulis' => 'required|string|max:100',
            'status' => 'required|in:draft,published,archived',
            'tanggal_publikasi' => 'nullable|date',
            'gambar' => 'nullable|string|max:255'
        ]);

        // Menggunakan Eloquent Model untuk auto-generate slug
        Announcement::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'prioritas' => $request->prioritas,
            'penulis' => $request->penulis,
            'status' => $request->status,
            'views' => 0,
            'tanggal_publikasi' => $request->tanggal_publikasi ?: now(),
            'gambar' => $request->gambar,
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
            'kategori' => 'required|in:akademik,kegiatan,administrasi',
            'prioritas' => 'required|in:normal,sedang,tinggi',
            'penulis' => 'required|string|max:100',
            'status' => 'required|in:draft,published,archived',
            'tanggal_publikasi' => 'nullable|date',
            'gambar' => 'nullable|string|max:255'
        ]);

        $announcement = Announcement::findOrFail($id);

        $announcement->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'kategori' => $request->kategori,
            'prioritas' => $request->prioritas,
            'penulis' => $request->penulis,
            'status' => $request->status,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'gambar' => $request->gambar,
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
        $announcement->update(['status' => $newStatus]);

        return response()->json(['success' => true, 'status' => $newStatus]);
    }
}