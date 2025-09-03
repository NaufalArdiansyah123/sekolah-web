<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = $this->getGalleryPhotos();
        return view('admin.gallery.index', compact('photos'));
    }

    public function upload()
    {
        return view('admin.gallery.upload');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'category' => 'required|string|in:school_events,academic,extracurricular,achievements,facilities,general',
        'photos' => 'required|array|min:1',
        'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240' // 10MB max
    ]);

    try {
        $uploadedPhotos = [];
        $albumSlug = Str::slug($request->title);
        $albumPath = "gallery/{$albumSlug}";

        // Create album directory if it doesn't exist
        if (!Storage::disk('public')->exists($albumPath)) {
            Storage::disk('public')->makeDirectory($albumPath);
        }

        foreach ($request->file('photos') as $index => $photo) {
            $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();
            $filename = Str::slug($originalName) . '_' . time() . '_' . $index . '.' . $extension;
            
            // Store original image
            $imagePath = $photo->storeAs($albumPath, $filename, 'public');
            
            // Create thumbnail
            $thumbnailPath = $albumPath . '/thumbs/' . $filename;
            $this->createThumbnail($photo, $thumbnailPath);

            // Simpan ke database (model Photo harus ada)
            \App\Models\Photo::create([
                'file_path'   => $imagePath,
                'title'       => $request->title,
                'description' => $request->description,
            ]);

            $uploadedPhotos[] = [
                'filename'       => $filename,
                'original_name'  => $photo->getClientOriginalName(),
                'path'           => $imagePath,
                'thumbnail_path' => $thumbnailPath,
                'size'           => $photo->getSize(),
                'mime_type'      => $photo->getMimeType(),
            ];
        }

        // Store album data in JSON file
        $albumData = [
            'id' => Str::uuid()->toString(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'slug' => $albumSlug,
            'photos' => $uploadedPhotos,
            'created_at' => now()->toISOString(),
            'created_by' => auth()->user()->name,
            'photo_count' => count($uploadedPhotos)
        ];

        $this->saveAlbumData($albumData);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Photos uploaded successfully! ' . count($uploadedPhotos) . ' photos added to gallery.');

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Upload failed: ' . $e->getMessage()]);
    }
}


    public function destroy($albumId)
    {
        try {
            $albums = $this->getGalleryPhotos();
            $albumIndex = array_search($albumId, array_column($albums, 'id'));
            
            if ($albumIndex === false) {
                return back()->withErrors(['error' => 'Album not found.']);
            }

            $album = $albums[$albumIndex];
            
            // Delete physical files
            Storage::disk('public')->deleteDirectory("gallery/{$album['slug']}");
            
            // Remove from albums data
            unset($albums[$albumIndex]);
            $this->saveAllAlbumsData(array_values($albums));

            return redirect()->route('admin.gallery.index')
                ->with('success', 'Album deleted successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Delete failed: ' . $e->getMessage()]);
        }
    }

    private function createThumbnail($photo, $thumbnailPath)
    {
        try {
            // Create thumbs directory if it doesn't exist
            $thumbDir = dirname(storage_path('app/public/' . $thumbnailPath));
            if (!file_exists($thumbDir)) {
                mkdir($thumbDir, 0755, true);
            }

            // Create thumbnail using Intervention Image (if available) or basic resize
            if (class_exists('\Intervention\Image\Facades\Image')) {
                $image = Image::make($photo->getRealPath());
                $image->fit(300, 300, function ($constraint) {
                    $constraint->upsize();
                });
                $image->save(storage_path('app/public/' . $thumbnailPath), 85);
            } else {
                // Fallback: just copy the original file
                $photo->storeAs(dirname($thumbnailPath), basename($thumbnailPath), 'public');
            }
        } catch (\Exception $e) {
            // If thumbnail creation fails, use original image
            $photo->storeAs(dirname($thumbnailPath), basename($thumbnailPath), 'public');
        }
    }

    private function saveAlbumData($albumData)
    {
        $albumsFile = storage_path('app/gallery_albums.json');
        $albums = [];

        if (file_exists($albumsFile)) {
            $albums = json_decode(file_get_contents($albumsFile), true) ?: [];
        }

        $albums[] = $albumData;
        file_put_contents($albumsFile, json_encode($albums, JSON_PRETTY_PRINT));
    }

    private function saveAllAlbumsData($albums)
    {
        $albumsFile = storage_path('app/gallery_albums.json');
        file_put_contents($albumsFile, json_encode($albums, JSON_PRETTY_PRINT));
    }

    private function getGalleryPhotos()
    {
        $albumsFile = storage_path('app/gallery_albums.json');
        
        if (!file_exists($albumsFile)) {
            return [];
        }

        $albums = json_decode(file_get_contents($albumsFile), true) ?: [];
        
        // Sort by created_at desc
        usort($albums, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });





        //baru

        

        return $albums;
    }
}