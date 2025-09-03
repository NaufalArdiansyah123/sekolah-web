<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
            $albumSlug = Str::slug($request->title) . '-' . time(); // Tambahkan timestamp untuk uniqueness
            $albumPath = "gallery/{$albumSlug}";

            // Create album directory if it doesn't exist
            if (!Storage::disk('public')->exists($albumPath)) {
                Storage::disk('public')->makeDirectory($albumPath, 0755, true);
            }

            // Create thumbnails directory
            $thumbPath = $albumPath . '/thumbs';
            if (!Storage::disk('public')->exists($thumbPath)) {
                Storage::disk('public')->makeDirectory($thumbPath, 0755, true);
            }

            foreach ($request->file('photos') as $index => $photo) {
                try {
                    $originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $photo->getClientOriginalExtension();
                    $filename = Str::slug($originalName) . '_' . time() . '_' . $index . '.' . $extension;
                    
                    // Store original image
                    $imagePath = $photo->storeAs($albumPath, $filename, 'public');
                    
                    if (!$imagePath) {
                        throw new \Exception("Failed to store image: {$photo->getClientOriginalName()}");
                    }

                    // Create thumbnail
                    $thumbnailPath = $thumbPath . '/' . $filename;
                    $this->createThumbnail($photo, $thumbnailPath);

                    // COMMENT OUT DATABASE SAVE - Hanya gunakan JSON storage
                    // Jika Anda ingin menggunakan database, pastikan model Photo sudah dibuat
                    /*
                    if (class_exists('\App\Models\Photo')) {
                        \App\Models\Photo::create([
                            'file_path'   => $imagePath,
                            'title'       => $request->title,
                            'description' => $request->description,
                            'category'    => $request->category,
                            'album_slug'  => $albumSlug,
                        ]);
                    }
                    */

                    $uploadedPhotos[] = [
                        'filename'       => $filename,
                        'original_name'  => $photo->getClientOriginalName(),
                        'path'           => $imagePath,
                        'thumbnail_path' => $thumbnailPath,
                        'size'           => $photo->getSize(),
                        'mime_type'      => $photo->getMimeType(),
                        'uploaded_at'    => now()->toISOString(),
                    ];

                } catch (\Exception $e) {
                    Log::error("Failed to process photo {$index}: " . $e->getMessage());
                    // Continue with other photos instead of failing completely
                    continue;
                }
            }

            if (empty($uploadedPhotos)) {
                throw new \Exception("No photos were successfully uploaded.");
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
                'created_by' => auth()->user()->name ?? 'Unknown',
                'photo_count' => count($uploadedPhotos)
            ];

            $this->saveAlbumData($albumData);

            return redirect()->route('admin.gallery.index')
                ->with('success', 'Photos uploaded successfully! ' . count($uploadedPhotos) . ' photos added to gallery.');

        } catch (\Exception $e) {
            Log::error('Gallery upload error: ' . $e->getMessage());
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
            Log::error('Gallery delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Delete failed: ' . $e->getMessage()]);
        }
    }

    private function createThumbnail($photo, $thumbnailPath)
    {
        try {
            // Ensure the storage directory exists
            $fullPath = storage_path('app/public/' . $thumbnailPath);
            $thumbDir = dirname($fullPath);
            
            if (!file_exists($thumbDir)) {
                mkdir($thumbDir, 0755, true);
            }

            // Try to use Intervention Image if available
            if (class_exists('\Intervention\Image\Facades\Image')) {
                $image = \Intervention\Image\Facades\Image::make($photo->getRealPath());
                $image->fit(300, 300, function ($constraint) {
                    $constraint->upsize();
                });
                $image->save($fullPath, 85);
            } else {
                // Fallback: use GD library or just copy file
                $this->createThumbnailWithGD($photo, $fullPath);
            }

        } catch (\Exception $e) {
            Log::error("Thumbnail creation failed for {$thumbnailPath}: " . $e->getMessage());
            
            // Final fallback: just copy the original file as thumbnail
            try {
                $photo->storeAs(dirname($thumbnailPath), basename($thumbnailPath), 'public');
            } catch (\Exception $copyError) {
                Log::error("Even file copy failed: " . $copyError->getMessage());
            }
        }
    }

    private function createThumbnailWithGD($photo, $fullPath)
    {
        $sourceImage = null;
        $imageInfo = getimagesize($photo->getRealPath());
        
        if (!$imageInfo) {
            throw new \Exception("Invalid image file");
        }

        switch ($imageInfo[2]) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($photo->getRealPath());
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($photo->getRealPath());
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($photo->getRealPath());
                break;
            default:
                throw new \Exception("Unsupported image type");
        }

        if (!$sourceImage) {
            throw new \Exception("Could not create image resource");
        }

        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);
        $thumbSize = 300;

        // Calculate new dimensions
        if ($sourceWidth > $sourceHeight) {
            $thumbWidth = $thumbSize;
            $thumbHeight = ($sourceHeight / $sourceWidth) * $thumbSize;
        } else {
            $thumbHeight = $thumbSize;
            $thumbWidth = ($sourceWidth / $sourceHeight) * $thumbSize;
        }

        $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
        
        // Preserve transparency for PNG and GIF
        if ($imageInfo[2] == IMAGETYPE_PNG || $imageInfo[2] == IMAGETYPE_GIF) {
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);
            $transparent = imagecolorallocatealpha($thumbImage, 255, 255, 255, 127);
            imagefilledrectangle($thumbImage, 0, 0, $thumbWidth, $thumbHeight, $transparent);
        }

        imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $sourceWidth, $sourceHeight);

        // Save thumbnail
        switch ($imageInfo[2]) {
            case IMAGETYPE_JPEG:
                imagejpeg($thumbImage, $fullPath, 85);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumbImage, $fullPath);
                break;
            case IMAGETYPE_GIF:
                imagegif($thumbImage, $fullPath);
                break;
        }

        imagedestroy($sourceImage);
        imagedestroy($thumbImage);
    }

    private function saveAlbumData($albumData)
    {
        try {
            $albumsFile = storage_path('app/gallery_albums.json');
            $albums = [];

            if (file_exists($albumsFile)) {
                $content = file_get_contents($albumsFile);
                $albums = json_decode($content, true) ?: [];
            }

            $albums[] = $albumData;
            
            $result = file_put_contents($albumsFile, json_encode($albums, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            if ($result === false) {
                throw new \Exception("Failed to write album data to file");
            }

        } catch (\Exception $e) {
            Log::error("Failed to save album data: " . $e->getMessage());
            throw $e;
        }
    }

    private function saveAllAlbumsData($albums)
    {
        try {
            $albumsFile = storage_path('app/gallery_albums.json');
            $result = file_put_contents($albumsFile, json_encode($albums, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            if ($result === false) {
                throw new \Exception("Failed to write albums data to file");
            }

        } catch (\Exception $e) {
            Log::error("Failed to save albums data: " . $e->getMessage());
            throw $e;
        }
    }

    private function getGalleryPhotos()
    {
        try {
            $albumsFile = storage_path('app/gallery_albums.json');
            
            if (!file_exists($albumsFile)) {
                return [];
            }

            $content = file_get_contents($albumsFile);
            if ($content === false) {
                Log::error("Could not read gallery albums file");
                return [];
            }

            $albums = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("JSON decode error: " . json_last_error_msg());
                return [];
            }

            $albums = $albums ?: [];
            
            // Sort by created_at desc
            usort($albums, function($a, $b) {
                $timeA = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
                $timeB = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
                return $timeB - $timeA;
            });

            return $albums;

        } catch (\Exception $e) {
            Log::error("Error getting gallery photos: " . $e->getMessage());
            return [];
        }
    }
}