<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class GalleryController extends Controller
{
    /**
     * Display gallery index page with all albums
     */
    public function index()
    {
        $albums = $this->getGalleryAlbums();
        return view('public.gallery.index', compact('albums'));
    }

    /**
     * Display specific album photos
     */
    public function photos($slug)
    {
        $albums = $this->getGalleryAlbums();
        $album = collect($albums)->firstWhere('slug', $slug);
        
        if (!$album) {
            abort(404, 'Album tidak ditemukan');
        }

        return view('public.gallery.photos', compact('album'));
    }

    /**
     * Show specific album details
     */
    public function show($slug)
    {
        $albums = $this->getGalleryAlbums();
        $album = collect($albums)->firstWhere('slug', $slug);
        
        if (!$album) {
            abort(404, 'Album tidak ditemukan');
        }

        return view('public.gallery.show', compact('album'));
    }

    /**
     * Download album as ZIP file
     */
    public function downloadAlbum($slug)
    {
        $albums = $this->getGalleryAlbums();
        $album = collect($albums)->firstWhere('slug', $slug);
        
        if (!$album) {
            abort(404, 'Album tidak ditemukan');
        }

        try {
            $zipFileName = $album['slug'] . '_photos.zip';
            $zipPath = storage_path('app/temp/' . $zipFileName);
            
            // Create temp directory if it doesn't exist
            if (!file_exists(dirname($zipPath))) {
                mkdir(dirname($zipPath), 0755, true);
            }

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
                throw new \Exception('Could not create zip file');
            }

            foreach ($album['photos'] as $photo) {
                $filePath = storage_path('app/public/' . $photo['path']);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $photo['original_name'] ?? basename($photo['path']));
                }
            }

            $zip->close();

            return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Download gagal: ' . $e->getMessage());
        }
    }

    /**
     * Upload photo to gallery
     */
    public function upload(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'album_slug' => 'required|string',
            'caption' => 'nullable|string|max:255'
        ]);

        try {
            $path = $request->file('foto')->store('gallery', 'public');
            
            // Add photo to album
            $this->addPhotoToAlbum($request->album_slug, [
                'path' => $path,
                'caption' => $request->caption,
                'original_name' => $request->file('foto')->getClientOriginalName(),
                'uploaded_at' => now()->toISOString()
            ]);

            return back()->with('success', 'Foto berhasil diupload');
        } catch (\Exception $e) {
            return back()->with('error', 'Upload gagal: ' . $e->getMessage());
        }
    }

    /**
     * Get all gallery albums from JSON file
     */
    public function getGalleryAlbums()
    {
        $albumsFile = storage_path('app/gallery_albums.json');
        
        if (!file_exists($albumsFile)) {
            return [];
        }

        $albums = json_decode(file_get_contents($albumsFile), true) ?: [];
        
        // Sort by created_at desc
        usort($albums, function($a, $b) {
            return strtotime($b['created_at'] ?? '2023-01-01') - strtotime($a['created_at'] ?? '2023-01-01');
        });

        return $albums;
    }

    /**
     * Create new album
     */
    public function createAlbum(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $albums = $this->getGalleryAlbums();
        
        $slug = \Str::slug($request->title);
        
        // Ensure unique slug
        $originalSlug = $slug;
        $counter = 1;
        while (collect($albums)->firstWhere('slug', $slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        $newAlbum = [
            'id' => uniqid(),
            'slug' => $slug,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'cover_image' => $coverImagePath,
            'photos' => [],
            'photo_count' => 0,
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString()
        ];

        $albums[] = $newAlbum;
        
        $this->saveGalleryAlbums($albums);

        return back()->with('success', 'Album berhasil dibuat');
    }

    /**
     * Add photo to specific album
     */
    private function addPhotoToAlbum($albumSlug, $photoData)
    {
        $albums = $this->getGalleryAlbums();
        
        foreach ($albums as &$album) {
            if ($album['slug'] === $albumSlug) {
                $album['photos'][] = $photoData;
                $album['photo_count'] = count($album['photos']);
                $album['updated_at'] = now()->toISOString();
                break;
            }
        }
        
        $this->saveGalleryAlbums($albums);
    }

    /**
     * Save albums to JSON file
     */
    private function saveGalleryAlbums($albums)
    {
        $albumsFile = storage_path('app/gallery_albums.json');
        file_put_contents($albumsFile, json_encode($albums, JSON_PRETTY_PRINT));
    }

    /**
     * Get gallery statistics
     */
    public function getGalleryStats()
    {
        $albums = $this->getGalleryAlbums();
        
        $totalPhotos = 0;
        $categories = [];
        
        foreach ($albums as $album) {
            $totalPhotos += $album['photo_count'] ?? 0;
            $categories[] = $album['category'] ?? 'general';
        }
        
        return [
            'total_albums' => count($albums),
            'total_photos' => $totalPhotos,
            'categories' => array_unique($categories),
            'latest_album' => $albums[0] ?? null
        ];
    }

    /**
     * Search albums and photos
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category', '');
        
        $albums = $this->getGalleryAlbums();
        
        if ($query) {
            $albums = array_filter($albums, function($album) use ($query) {
                return stripos($album['title'], $query) !== false || 
                       stripos($album['description'] ?? '', $query) !== false;
            });
        }
        
        if ($category) {
            $albums = array_filter($albums, function($album) use ($category) {
                return ($album['category'] ?? 'general') === $category;
            });
        }
        
        return view('public.gallery.search', compact('albums', 'query', 'category'));
    }
}