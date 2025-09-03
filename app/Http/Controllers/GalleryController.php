<?php
// 1. Buat file: app/Http/Controllers/GalleryController.php (Public Controller)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            abort(404, 'Album tidak ditemukan');
        }

        return view('public.gallery.photos', compact('album'));
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
            return strtotime($b['created_at'] ?? '2023-01-01') - strtotime($a['created_at'] ?? '2023-01-01');
        });

        return $albums;
    }

    public function upload(Request $request)
{
    $request->validate([
        'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $path = $request->file('foto')->store('uploads', 'public');

    return back()->with('success', 'Foto berhasil diupload ke: ' . $path);
}

}
?>