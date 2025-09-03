<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = $this->getGalleryAlbums();
        return view('public.gallery.index', compact('albums'));
    }

    public function photos($slug)
    {
        $albums = $this->getGalleryAlbums();
        $album = collect($albums)->firstWhere('slug', $slug);
        
        if (!$album) {
            abort(404, 'Album not found');
        }

        return view('public.gallery.photos', compact('album'));
    }

    public function downloadAlbum($slug)
    {
        $albums = $this->getGalleryAlbums();
        $album = collect($albums)->firstWhere('slug', $slug);
        
        if (!$album) {
            abort(404, 'Album not found');
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
                    $zip->addFile($filePath, $photo['original_name']);
                }
            }

            $zip->close();

            return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Download failed: ' . $e->getMessage());
        }
    }

    private function getGalleryAlbums()
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

        return $albums;
    }
}