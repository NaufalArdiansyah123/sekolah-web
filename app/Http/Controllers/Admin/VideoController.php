<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;

class VideoController extends Controller
{
    /**
     * Display a listing of videos
     */
    public function index(Request $request)
    {
        $query = Video::with('uploader')->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('original_name', 'like', "%{$search}%");
            });
        }

        $videos = $query->paginate(12);
        $categories = Video::getCategoryOptions();
        $statuses = Video::getStatusOptions();

        return view('admin.videos.index', compact('videos', 'categories', 'statuses'));
    }

    /**
     * Show the form for creating a new video
     */
    public function create()
    {
        $categories = Video::getCategoryOptions();
        $statuses = Video::getStatusOptions();
        
        return view('admin.videos.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created video
     */
    public function store(Request $request)
    {
        // Enhanced validation with better error messages
        $request->validate([
            'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:5000',
            'category' => ['required', Rule::in(array_keys(Video::getCategoryOptions()))],
            'status' => ['required', Rule::in(array_keys(Video::getStatusOptions()))],
            'is_featured' => 'nullable|boolean',
            'video_file' => 'required|file|mimes:mp4,avi,mov,wmv,flv,webm,mkv,3gp|max:204800', // 200MB max
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'title.required' => 'Judul video wajib diisi.',
            'title.min' => 'Judul video minimal 3 karakter.',
            'title.max' => 'Judul video maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 5000 karakter.',
            'category.required' => 'Kategori video wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
            'status.required' => 'Status video wajib dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'video_file.required' => 'File video wajib diupload.',
            'video_file.file' => 'File yang diupload harus berupa file video.',
            'video_file.mimes' => 'Format video yang diizinkan: MP4, AVI, MOV, WMV, FLV, WebM, MKV, 3GP',
            'video_file.max' => 'Ukuran file video maksimal 200MB.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format thumbnail yang diizinkan: JPEG, PNG, JPG, GIF, WebP',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
        ]);

        // Check if directories exist
        $this->ensureDirectoriesExist();

        try {
            $videoFile = $request->file('video_file');
            $thumbnailFile = $request->file('thumbnail');

            // Log upload attempt
            Log::info('Video upload attempt', [
                'user_id' => auth()->id(),
                'file_name' => $videoFile->getClientOriginalName(),
                'file_size' => $videoFile->getSize(),
                'mime_type' => $videoFile->getMimeType()
            ]);

            // Additional file size check
            $maxSize = 214748364800; // 200MB in bytes
            if ($videoFile->getSize() > $maxSize) {
                throw new \Exception('File terlalu besar. Maksimal 200MB');
            }

            // Generate unique filename
            $filename = Str::uuid() . '.' . $videoFile->getClientOriginalExtension();
            
            // Store video file
            $videoPath = $videoFile->storeAs('videos', $filename, 'public');
            
            if (!$videoPath) {
                throw new \Exception('Gagal menyimpan file video ke storage');
            }
            
            // Store thumbnail if provided
            $thumbnailFilename = null;
            if ($thumbnailFile) {
                $thumbnailFilename = Str::uuid() . '.' . $thumbnailFile->getClientOriginalExtension();
                $thumbnailPath = $thumbnailFile->storeAs('videos/thumbnails', $thumbnailFilename, 'public');
                
                if (!$thumbnailPath) {
                    Log::warning('Failed to store thumbnail', ['filename' => $thumbnailFilename]);
                    $thumbnailFilename = null;
                }
            }

            // Create video record
            $video = Video::create([
                'title' => $request->title,
                'description' => $request->description,
                'filename' => $filename,
                'original_name' => $videoFile->getClientOriginalName(),
                'mime_type' => $videoFile->getMimeType(),
                'file_size' => $videoFile->getSize(),
                'thumbnail' => $thumbnailFilename,
                'category' => $request->category,
                'status' => $request->status,
                'is_featured' => $request->boolean('is_featured'),
                'uploaded_by' => auth()->id(),
            ]);

            Log::info('Video uploaded successfully', [
                'video_id' => $video->id,
                'filename' => $filename
            ]);

            // Send notification
            NotificationService::mediaUpload('video', $video->original_name, $video->file_size, [
                'video_id' => $video->id,
                'category' => $video->category,
                'file_size_mb' => round($video->file_size / 1048576, 2)
            ]);

            return redirect()->route('admin.videos.index')
                           ->with('success', 'Video berhasil diupload!');

        } catch (\Exception $e) {
            Log::error('Video upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);
            
            // Clean up any uploaded files on error
            if (isset($videoPath) && Storage::disk('public')->exists($videoPath)) {
                Storage::disk('public')->delete($videoPath);
            }
            if (isset($thumbnailPath) && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            
            return back()->withInput()
                        ->with('error', 'Gagal mengupload video: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified video
     */
    public function show(Video $video)
    {
        $video->load('uploader');
        $categories = Video::getCategoryOptions();
        $statuses = Video::getStatusOptions();
        
        return view('admin.videos.show', compact('video', 'categories', 'statuses'));
    }

    /**
     * Show the form for editing the specified video
     */
    public function edit(Video $video)
    {
        $categories = Video::getCategoryOptions();
        $statuses = Video::getStatusOptions();
        
        return view('admin.videos.edit', compact('video', 'categories', 'statuses'));
    }

    /**
     * Update the specified video
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:5000',
            'category' => ['required', Rule::in(array_keys(Video::getCategoryOptions()))],
            'status' => ['required', Rule::in(array_keys(Video::getStatusOptions()))],
            'is_featured' => 'nullable|boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'title.required' => 'Judul video wajib diisi.',
            'title.min' => 'Judul video minimal 3 karakter.',
            'title.max' => 'Judul video maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 5000 karakter.',
            'category.required' => 'Kategori video wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
            'status.required' => 'Status video wajib dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format thumbnail yang diizinkan: JPEG, PNG, JPG, GIF, WebP',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
        ]);

        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'status' => $request->status,
                'is_featured' => $request->boolean('is_featured'),
            ];

            // Handle thumbnail update
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($video->thumbnail) {
                    Storage::disk('public')->delete('videos/thumbnails/' . $video->thumbnail);
                }

                // Store new thumbnail
                $thumbnailFile = $request->file('thumbnail');
                $thumbnailFilename = Str::uuid() . '.' . $thumbnailFile->getClientOriginalExtension();
                $thumbnailFile->storeAs('videos/thumbnails', $thumbnailFilename, 'public');
                $data['thumbnail'] = $thumbnailFilename;
            }

            $video->update($data);

            return redirect()->route('admin.videos.index')
                           ->with('success', 'Video berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Gagal memperbarui video: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified video
     */
    public function destroy(Video $video)
    {
        try {
            // Delete video file
            Storage::disk('public')->delete('videos/' . $video->filename);
            
            // Delete thumbnail if exists
            if ($video->thumbnail) {
                Storage::disk('public')->delete('videos/thumbnails/' . $video->thumbnail);
            }

            $video->delete();

            return redirect()->route('admin.videos.index')
                           ->with('success', 'Video berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus video: ' . $e->getMessage());
        }
    }

    /**
     * Download video file
     */
    public function download(Video $video)
    {
        $video->incrementDownloads();
        
        $filePath = storage_path('app/public/videos/' . $video->filename);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath, $video->original_name);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Video $video)
    {
        $video->update(['is_featured' => !$video->is_featured]);
        
        $status = $video->is_featured ? 'ditampilkan' : 'disembunyikan';
        
        return back()->with('success', "Video berhasil {$status} dari featured!");
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,feature,unfeature',
            'videos' => 'required|array',
            'videos.*' => 'exists:videos,id',
        ]);

        $videos = Video::whereIn('id', $request->videos);
        $count = $videos->count();

        switch ($request->action) {
            case 'delete':
                foreach ($videos->get() as $video) {
                    Storage::disk('public')->delete('videos/' . $video->filename);
                    if ($video->thumbnail) {
                        Storage::disk('public')->delete('videos/thumbnails/' . $video->thumbnail);
                    }
                }
                $videos->delete();
                $message = "{$count} video berhasil dihapus!";
                break;

            case 'activate':
                $videos->update(['status' => 'active']);
                $message = "{$count} video berhasil diaktifkan!";
                break;

            case 'deactivate':
                $videos->update(['status' => 'inactive']);
                $message = "{$count} video berhasil dinonaktifkan!";
                break;

            case 'feature':
                $videos->update(['is_featured' => true]);
                $message = "{$count} video berhasil ditampilkan di featured!";
                break;

            case 'unfeature':
                $videos->update(['is_featured' => false]);
                $message = "{$count} video berhasil dihapus dari featured!";
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * Ensure required directories exist
     */
    private function ensureDirectoriesExist()
    {
        $disk = Storage::disk('public');
        
        if (!$disk->exists('videos')) {
            $disk->makeDirectory('videos');
        }
        
        if (!$disk->exists('videos/thumbnails')) {
            $disk->makeDirectory('videos/thumbnails');
        }
    }

    /**
     * Get upload configuration info
     */
    public function getUploadInfo()
    {
        $maxFileSize = 214748364800; // 200MB
        $phpMaxUpload = ini_get('upload_max_filesize');
        $phpMaxPost = ini_get('post_max_size');
        $phpMaxExecution = ini_get('max_execution_time');
        
        return response()->json([
            'max_file_size' => $maxFileSize,
            'max_file_size_mb' => round($maxFileSize / 1048576, 1),
            'php_upload_max_filesize' => $phpMaxUpload,
            'php_post_max_size' => $phpMaxPost,
            'php_max_execution_time' => $phpMaxExecution,
            'allowed_mimes' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv', '3gp'],
            'storage_disk' => 'public',
        ]);
    }
}