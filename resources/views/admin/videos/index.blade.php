@extends('layouts.admin')

@section('content')
<style>
    /* Enhanced Video Management Styles */
    .video-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .dark .video-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .video-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--accent-color);
    }
    
    .dark .video-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .video-thumbnail {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .video-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .video-play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s ease;
    }
    
    .video-card:hover .video-play-icon {
        background: rgba(59, 130, 246, 0.9);
        transform: translate(-50%, -50%) scale(1.1);
    }
    
    .video-info {
        padding: 1.5rem;
    }
    
    .video-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .video-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .video-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .video-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-category {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }
    
    .badge-status-active {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .badge-status-inactive {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .badge-featured {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .video-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }
    
    .video-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary {
        background: var(--accent-color);
        color: white;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }
    
    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }
    
    .btn-secondary:hover {
        background: var(--bg-secondary);
        transform: translateY(-1px);
    }
    
    .btn-danger {
        background: #ef4444;
        color: white;
    }
    
    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    /* Filter Section */
    .filter-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .dark .filter-section {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--accent-color);
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .video-actions {
            flex-direction: column;
        }
        
        .btn-action {
            justify-content: center;
        }
    }
</style>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Video Management</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola video dokumentasi dan kegiatan sekolah</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" 
           class="btn-action btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Upload Video
        </a>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $videos->total() }}</div>
            <div class="stat-label">Total Videos</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $videos->where('status', 'active')->count() }}</div>
            <div class="stat-label">Active Videos</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $videos->where('is_featured', true)->count() }}</div>
            <div class="stat-label">Featured Videos</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($videos->sum('views')) }}</div>
            <div class="stat-label">Total Views</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari video..."
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                <select name="category" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">All Status</option>
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full btn-action btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Videos Grid -->
    @if($videos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videos as $video)
                <div class="video-card">
                    <!-- Thumbnail -->
                    <div class="video-thumbnail">
                        @if($video->thumbnail_url)
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}">
                        @else
                            <div class="flex flex-col items-center text-white">
                                <svg class="w-16 h-16 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                </svg>
                                <span class="text-sm">{{ strtoupper($video->category) }}</span>
                            </div>
                        @endif
                        <div class="video-play-icon">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Video Info -->
                    <div class="video-info">
                        <h3 class="video-title">{{ $video->title }}</h3>
                        
                        @if($video->description)
                            <p class="video-description">{{ $video->description }}</p>
                        @endif

                        <!-- Meta Info -->
                        <div class="video-meta">
                            <span class="video-badge badge-category">{{ $categories[$video->category] }}</span>
                            <span class="video-badge badge-status-{{ $video->status }}">{{ $statuses[$video->status] }}</span>
                            @if($video->is_featured)
                                <span class="video-badge badge-featured">Featured</span>
                            @endif
                        </div>

                        <!-- Stats -->
                        <div class="video-stats">
                            <span>👁️ {{ number_format($video->views) }} views</span>

                            <span>📁 {{ $video->formatted_file_size }}</span>
                        </div>

                        <!-- Actions -->
                        <div class="video-actions">
                            <a href="{{ route('admin.videos.show', $video) }}" 
                               class="btn-action btn-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                            
                            <a href="{{ route('admin.videos.edit', $video) }}" 
                               class="btn-action btn-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            
                            <form method="POST" 
                                  action="{{ route('admin.videos.destroy', $video) }}" 
                                  class="inline"
                                  onsubmit="return confirmDelete('Apakah Anda yakin ingin menghapus video ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-danger">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $videos->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Belum ada video</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Mulai dengan mengupload video pertama Anda.</p>
            <div class="mt-6">
                <a href="{{ route('admin.videos.create') }}" 
                   class="btn-action btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Upload Video Pertama
                </a>
            </div>
        </div>
    @endif
</div>
@endsection