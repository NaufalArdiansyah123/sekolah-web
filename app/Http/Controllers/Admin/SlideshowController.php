<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    public function index()
    {
        $slideshows = Slideshow::latest()->paginate(10);
        return view('admin.posts.slideshow.index', compact('slideshows'));
    }

    public function create()
    {
        return view('admin.posts.slideshow.create');
    }

    public function store(Request $request)
    {
        // Debug: Log semua data yang masuk
        Log::info('Slideshow store request:', $request->all());
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer|min:0',
        ]);

        Log::info('Validation passed:', $validated);

        try {
            $imagePath = null;
            
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Simpan file ke storage/app/public/slideshows
                $imagePath = $file->storeAs('slideshows', $fileName, 'public');
                
                Log::info('Image uploaded:', ['path' => $imagePath, 'filename' => $fileName]);
            }

            // Buat record di database
            $slideshow = Slideshow::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
                'status' => $request->status ?? 'active',
                'order' => $request->order ?? 0,
                'user_id' => auth()->id(), // Tambah user_id jika ada kolom ini
            ]);

            Log::info('Slideshow created:', $slideshow->toArray());

            return redirect()
                ->route('admin.posts.slideshow')
                ->with('success', 'Slideshow berhasil ditambahkan!');
            
        } catch (\Exception $e) {
            Log::error('Error creating slideshow:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan slideshow: ' . $e->getMessage());
        }
    }

    public function edit(Slideshow $slideshow)
    {
        return view('admin.posts.slideshow.edit', compact('slideshow'));
    }

    public function update(Request $request, Slideshow $slideshow)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer|min:0',
        ]);

        try {
            $updateData = [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'order' => $request->order ?? 0,
            ];

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($slideshow->image && Storage::disk('public')->exists($slideshow->image)) {
                    Storage::disk('public')->delete($slideshow->image);
                }

                $file = $request->file('image');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('slideshows', $fileName, 'public');
                $updateData['image'] = $imagePath;
            }

            $slideshow->update($updateData);

            return redirect()
                ->route('admin.posts.slideshow')
                ->with('success', 'Slideshow berhasil diperbarui!');
            
        } catch (\Exception $e) {
            Log::error('Error updating slideshow:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui slideshow: ' . $e->getMessage());
        }
    }

    public function destroy(Slideshow $slideshow)
    {
        try {
            // Hapus file gambar jika ada
            if ($slideshow->image && Storage::disk('public')->exists($slideshow->image)) {
                Storage::disk('public')->delete($slideshow->image);
                Log::info('Image deleted:', ['path' => $slideshow->image]);
            }

            // Hapus record dari database
            $slideshow->forceDelete();
            
            Log::info('Slideshow deleted:', ['id' => $slideshow->id, 'title' => $slideshow->title]);
            
            return redirect()
                ->route('admin.posts.slideshow')
                ->with('success', 'Slideshow berhasil dihapus!');
            
        } catch (\Exception $e) {
            Log::error('Error deleting slideshow:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus slideshow: ' . $e->getMessage());
        }
    }
}