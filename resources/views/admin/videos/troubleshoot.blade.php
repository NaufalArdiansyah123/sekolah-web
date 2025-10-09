@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Video Upload Troubleshoot</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Informasi konfigurasi dan troubleshooting upload video</p>
        </div>
        <a href="{{ route('admin.videos.index') }}" 
           class="btn btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- PHP Configuration -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">PHP Configuration</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Upload Max Filesize</h3>
                <p class="text-lg font-mono">{{ ini_get('upload_max_filesize') }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Post Max Size</h3>
                <p class="text-lg font-mono">{{ ini_get('post_max_size') }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Max Execution Time</h3>
                <p class="text-lg font-mono">{{ ini_get('max_execution_time') }} seconds</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Memory Limit</h3>
                <p class="text-lg font-mono">{{ ini_get('memory_limit') }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Max Input Time</h3>
                <p class="text-lg font-mono">{{ ini_get('max_input_time') }} seconds</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">File Uploads</h3>
                <p class="text-lg font-mono">{{ ini_get('file_uploads') ? 'Enabled' : 'Disabled' }}</p>
            </div>
        </div>
    </div>

    <!-- Storage Information -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Storage Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Storage Path</h3>
                <p class="text-sm font-mono break-all">{{ storage_path('app/public/videos') }}</p>
                <p class="text-sm mt-1">
                    @if(is_dir(storage_path('app/public/videos')))
                        <span class="text-green-600">✓ Directory exists</span>
                    @else
                        <span class="text-red-600">✗ Directory not found</span>
                    @endif
                </p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Thumbnails Path</h3>
                <p class="text-sm font-mono break-all">{{ storage_path('app/public/videos/thumbnails') }}</p>
                <p class="text-sm mt-1">
                    @if(is_dir(storage_path('app/public/videos/thumbnails')))
                        <span class="text-green-600">✓ Directory exists</span>
                    @else
                        <span class="text-red-600">✗ Directory not found</span>
                    @endif
                </p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Storage Writable</h3>
                <p class="text-sm mt-1">
                    @if(is_writable(storage_path('app/public')))
                        <span class="text-green-600">✓ Writable</span>
                    @else
                        <span class="text-red-600">✗ Not writable</span>
                    @endif
                </p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Disk Space</h3>
                <p class="text-sm">
                    Free: {{ number_format(disk_free_space(storage_path('app/public')) / 1048576, 2) }} MB
                </p>
            </div>
        </div>
    </div>

    <!-- Validation Rules -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Current Validation Rules</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Max File Size</h3>
                <p class="text-lg">200 MB</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Allowed Video Formats</h3>
                <p class="text-sm">MP4, AVI, MOV, WMV, FLV, WebM, MKV, 3GP</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Thumbnail Max Size</h3>
                <p class="text-lg">2 MB</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                <h3 class="font-medium">Thumbnail Formats</h3>
                <p class="text-sm">JPEG, PNG, JPG, GIF, WebP</p>
            </div>
        </div>
    </div>

    <!-- Common Issues & Solutions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Common Issues & Solutions</h2>
        <div class="space-y-4">
            <div class="border-l-4 border-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 p-4">
                <h3 class="font-medium text-yellow-800 dark:text-yellow-200">File Too Large Error</h3>
                <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                    Increase <code>upload_max_filesize</code> and <code>post_max_size</code> in php.ini or .htaccess
                </p>
            </div>
            
            <div class="border-l-4 border-red-400 bg-red-50 dark:bg-red-900/20 p-4">
                <h3 class="font-medium text-red-800 dark:text-red-200">Upload Timeout</h3>
                <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                    Increase <code>max_execution_time</code> and <code>max_input_time</code> in PHP configuration
                </p>
            </div>
            
            <div class="border-l-4 border-blue-400 bg-blue-50 dark:bg-blue-900/20 p-4">
                <h3 class="font-medium text-blue-800 dark:text-blue-200">Permission Denied</h3>
                <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                    Check storage directory permissions: <code>chmod 755 storage/app/public/videos</code>
                </p>
            </div>
            
            <div class="border-l-4 border-green-400 bg-green-50 dark:bg-green-900/20 p-4">
                <h3 class="font-medium text-green-800 dark:text-green-200">Storage Link Missing</h3>
                <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                    Run: <code>php artisan storage:link</code> to create symbolic link
                </p>
            </div>
        </div>
    </div>

    <!-- Test Upload -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Test Small Upload</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-4">Test with a small video file to verify basic functionality</p>
        
        <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-2">Test Video (Max 10MB)</label>
                <input type="file" name="video_file" accept="video/*" class="form-input" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Judul</label>
                <input type="text" name="title" value="Test Upload" class="form-input" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Kategori</label>
                <select name="category" class="form-input" required>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Status</label>
                <select name="status" class="form-input" required>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Test Upload</button>
        </form>
    </div>

    <!-- Recent Logs -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Recent Upload Logs</h2>
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Check Laravel logs at: <code>storage/logs/laravel.log</code>
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                Look for entries with "Video upload" to debug upload issues.
            </p>
        </div>
    </div>
</div>

<style>
.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: white;
    color: #374151;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}
</style>
@endsection