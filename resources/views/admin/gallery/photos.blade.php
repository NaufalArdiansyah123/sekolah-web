@extends('layouts.admin')

@section('title', 'Album Photos - ' . $album['title'])

@push('styles')
<style>
    :root {
        --primary-color: #3b82f6;
        --primary-dark: #2563eb;
        --secondary-color: #8b5cf6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #06b6d4;
        
        /* Light theme */
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        
        /* Action buttons */
        --btn-view-bg: rgba(59, 130, 246, 0.9);
        --btn-download-bg: rgba(16, 185, 129, 0.9);
        --btn-delete-bg: rgba(239, 68, 68, 0.9);
        
        /* Modal */
        --modal-bg: rgba(0, 0, 0, 0.9);
        --modal-nav-bg: rgba(0, 0, 0, 0.5);
        --modal-nav-hover-bg: rgba(0, 0, 0, 0.8);
    }

    .dark {
        --bg-primary: #1e293b;
        --bg-secondary: #334155;
        --bg-tertiary: #475569;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --border-color: #475569;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.3);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.4), 0 1px 2px -1px rgb(0 0 0 / 0.4);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.4), 0 2px 4px -2px rgb(0 0 0 / 0.4);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.4), 0 4px 6px -4px rgb(0 0 0 / 0.4);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.4), 0 8px 10px -6px rgb(0 0 0 / 0.4);
        
        /* Action buttons for dark mode */
        --btn-view-bg: rgba(59, 130, 246, 0.8);
        --btn-download-bg: rgba(16, 185, 129, 0.8);
        --btn-delete-bg: rgba(239, 68, 68, 0.8);
        
        /* Modal for dark mode */
        --modal-bg: rgba(0, 0, 0, 0.95);
        --modal-nav-bg: rgba(0, 0, 0, 0.7);
        --modal-nav-hover-bg: rgba(0, 0, 0, 0.9);
    }

    .photos-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        background: var(--bg-primary);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
        margin: 0;
    }

    .album-info {
        background: var(--bg-primary);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .album-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .meta-icon {
        width: 1.5rem;
        height: 1.5rem;
        background: var(--bg-tertiary);
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
    }

    .category-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .category-school_events {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .category-academic {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
    }

    .category-extracurricular {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .category-achievements {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .category-facilities {
        background: rgba(139, 92, 246, 0.1);
        color: #7c3aed;
    }

    .category-general {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
    }

    .dark .category-school_events {
        background: rgba(239, 68, 68, 0.2);
        color: #fca5a5;
    }

    .dark .category-academic {
        background: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
    }

    .dark .category-extracurricular {
        background: rgba(16, 185, 129, 0.2);
        color: #6ee7b7;
    }

    .dark .category-achievements {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
    }

    .dark .category-facilities {
        background: rgba(139, 92, 246, 0.2);
        color: #c4b5fd;
    }

    .dark .category-general {
        background: rgba(107, 114, 128, 0.2);
        color: #d1d5db;
    }

    .toolbar {
        background: var(--bg-primary);
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .view-controls {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .view-btn {
        padding: 0.5rem;
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
        color: var(--text-secondary);
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
    }

    .view-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .view-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .search-box {
        position: relative;
        max-width: 300px;
        flex: 1;
    }

    .search-input {
        width: 100%;
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        background: var(--bg-secondary);
        color: var(--text-primary);
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .photos-grid {
        display: grid;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .photos-grid.grid-view {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }

    .photos-grid.masonry-view {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-auto-rows: 10px;
    }

    .photos-grid.list-view {
        grid-template-columns: 1fr;
    }

    .photo-item {
        background: var(--bg-primary);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        cursor: pointer;
    }

    .photo-item:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .photo-item.masonry-view {
        grid-row-end: span var(--row-span);
    }

    .photo-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .photo-item.masonry-view .photo-image {
        height: auto;
        aspect-ratio: auto;
    }

    .photo-item.list-view .photo-image {
        width: 150px;
        height: 100px;
        flex-shrink: 0;
    }

    .photo-item:hover .photo-image {
        transform: scale(1.05);
    }

    .photo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 1rem;
    }

    .photo-item:hover .photo-overlay {
        opacity: 1;
    }

    .photo-info {
        color: white;
        width: 100%;
    }

    .photo-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .photo-size {
        font-size: 0.75rem;
        opacity: 0.8;
    }

    .photo-actions {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: flex;
        gap: 0.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .photo-item:hover .photo-actions {
        opacity: 1;
    }

    .action-btn {
        width: 2rem;
        height: 2rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: var(--btn-view-bg);
        color: white;
    }

    .btn-download {
        background: var(--btn-download-bg);
        color: white;
    }

    .btn-delete {
        background: var(--btn-delete-bg);
        color: white;
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    .photo-item.list-view {
        display: flex;
        align-items: center;
        padding: 1rem;
        gap: 1rem;
    }

    .photo-item.list-view .photo-overlay {
        display: none;
    }

    .photo-item.list-view .photo-actions {
        position: static;
        opacity: 1;
        margin-left: auto;
    }

    .photo-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .photo-title {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
    }

    .photo-meta {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--bg-primary);
        border-radius: 1rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
    }

    .empty-icon {
        width: 5rem;
        height: 5rem;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-secondary));
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--text-muted);
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-description {
        color: var(--text-secondary);
        margin-bottom: 2rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
        color: white;
        text-decoration: none;
    }

    .btn-secondary-custom {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .photo-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--modal-bg);
        z-index: 9999;
        padding: 2rem;
    }

    .modal-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .modal-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 0.5rem;
    }

    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--modal-nav-bg);
        color: white;
        border: none;
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: var(--modal-nav-hover-bg);
        transform: scale(1.1);
    }

    .modal-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: var(--modal-nav-bg);
        color: white;
        border: none;
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-nav:hover {
        background: var(--modal-nav-hover-bg);
        transform: translateY(-50%) scale(1.1);
    }

    .modal-prev {
        left: 1rem;
    }

    .modal-next {
        right: 1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .photos-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
            text-align: center;
        }

        .page-title {
            font-size: 1.5rem;
            justify-content: center;
        }

        .toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .view-controls {
            justify-content: center;
        }

        .photos-grid.grid-view {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .photos-grid.masonry-view {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .photo-item.list-view {
            flex-direction: column;
            text-align: center;
        }

        .photo-item.list-view .photo-image {
            width: 100%;
            height: 150px;
        }
    }

    @media (max-width: 480px) {
        .photos-grid.grid-view,
        .photos-grid.masonry-view {
            grid-template-columns: 1fr;
        }

        .album-meta {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    .fade-in:nth-child(1) { animation-delay: 0.1s; }
    .fade-in:nth-child(2) { animation-delay: 0.2s; }
    .fade-in:nth-child(3) { animation-delay: 0.3s; }
    .fade-in:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="photos-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-images"></i>
                    {{ $album['title'] }}
                </h1>
                <p class="page-subtitle">
                    Manage photos in this album
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('gallery.show', $album['slug']) }}" target="_blank" class="btn-secondary-custom">
                    <i class="fas fa-external-link-alt"></i>
                    View Public
                </a>
                <a href="{{ route('admin.gallery.index') }}" class="btn-secondary-custom">
                    <i class="fas fa-arrow-left"></i>
                    Back to Gallery
                </a>
            </div>
        </div>
    </div>

    <!-- Album Info -->
    <div class="album-info fade-in">
        <div class="album-meta">
            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <span class="category-badge category-{{ $album['category'] }}">
                    {{ ucfirst(str_replace('_', ' ', $album['category'])) }}
                </span>
            </div>
            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-images"></i>
                </div>
                <span>{{ count($album['photos']) }} photos</span>
            </div>
            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <span>{{ \Carbon\Carbon::parse($album['created_at'])->format('M d, Y') }}</span>
            </div>
            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-user"></i>
                </div>
                <span>by {{ $album['created_by'] }}</span>
            </div>
        </div>
        @if($album['description'])
            <p style="color: var(--text-secondary); margin: 0;">{{ $album['description'] }}</p>
        @endif
    </div>

    <!-- Toolbar -->
    <div class="toolbar fade-in">
        <div class="view-controls">
            <span style="color: var(--text-secondary); font-size: 0.875rem; margin-right: 0.5rem;">View:</span>
            <button class="view-btn active" data-view="grid" title="Grid View">
                <i class="fas fa-th"></i>
            </button>
            <button class="view-btn" data-view="masonry" title="Masonry View">
                <i class="fas fa-th-large"></i>
            </button>
            <button class="view-btn" data-view="list" title="List View">
                <i class="fas fa-list"></i>
            </button>
        </div>
        
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Search photos..." id="searchInput">
        </div>
    </div>

    <!-- Photos Grid -->
    @if(count($album['photos']) > 0)
        <div class="photos-grid grid-view" id="photosGrid">
            @foreach($album['photos'] as $index => $photo)
                <div class="photo-item fade-in" data-photo-name="{{ strtolower($photo['original_name']) }}">
                    <img src="{{ asset('storage/' . $photo['thumbnail_path']) }}" 
                         alt="{{ $photo['original_name'] }}" 
                         class="photo-image"
                         data-full-src="{{ asset('storage/' . $photo['file_path']) }}"
                         onclick="openPhotoModal({{ $index }})">
                    
                    <div class="photo-overlay">
                        <div class="photo-info">
                            <div class="photo-name">{{ $photo['original_name'] }}</div>
                            <div class="photo-size">{{ formatFileSize($photo['file_size']) }}</div>
                        </div>
                    </div>
                    
                    <div class="photo-actions">
                        <button class="action-btn btn-view" onclick="openPhotoModal({{ $index }})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <a href="{{ asset('storage/' . $photo['file_path']) }}" 
                           download="{{ $photo['original_name'] }}"
                           class="action-btn btn-download" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="action-btn btn-delete" 
                                onclick="deletePhoto('{{ $photo['id'] }}', '{{ $photo['original_name'] }}')" 
                                title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <!-- List view content -->
                    <div class="photo-details" style="display: none;">
                        <div class="photo-title">{{ $photo['original_name'] }}</div>
                        <div class="photo-meta">
                            Size: {{ formatFileSize($photo['file_size']) }} • 
                            Uploaded: {{ \Carbon\Carbon::parse($photo['created_at'])->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-images"></i>
            </div>
            <h3 class="empty-title">No Photos in This Album</h3>
            <p class="empty-description">
                This album doesn't contain any photos yet. Upload some photos to get started.
            </p>
            <a href="{{ route('admin.gallery.upload') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i>
                Upload Photos
            </a>
        </div>
    @endif
</div>

<!-- Photo Modal -->
<div class="photo-modal" id="photoModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closePhotoModal()">
            <i class="fas fa-times"></i>
        </button>
        <button class="modal-nav modal-prev" onclick="prevPhoto()">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="modal-nav modal-next" onclick="nextPhoto()">
            <i class="fas fa-chevron-right"></i>
        </button>
        <img class="modal-image" id="modalImage" src="" alt="">
    </div>
</div>
@endsection

@push('scripts')
<script>
// Photo data for modal navigation
const photos = @json($album['photos']);
let currentPhotoIndex = 0;

document.addEventListener('DOMContentLoaded', function() {
    // View switching
    const viewButtons = document.querySelectorAll('.view-btn');
    const photosGrid = document.getElementById('photosGrid');
    const photoItems = document.querySelectorAll('.photo-item');

    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            
            // Update active button
            viewButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update grid class
            photosGrid.className = `photos-grid ${view}-view`;
            
            // Update photo items
            photoItems.forEach(item => {
                item.className = `photo-item ${view}-view fade-in`;
                
                // Show/hide details for list view
                const details = item.querySelector('.photo-details');
                if (view === 'list') {
                    details.style.display = 'flex';
                } else {
                    details.style.display = 'none';
                }
            });
            
            // Handle masonry layout
            if (view === 'masonry') {
                handleMasonryLayout();
            }
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        photoItems.forEach(item => {
            const photoName = item.dataset.photoName;
            if (photoName.includes(searchTerm)) {
                item.style.display = 'block';
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 50);
            } else {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300);
            }
        });
    });

    // Initialize masonry layout
    handleMasonryLayout();
    
    // Handle window resize for masonry
    window.addEventListener('resize', handleMasonryLayout);
});

function handleMasonryLayout() {
    const grid = document.getElementById('photosGrid');
    if (!grid.classList.contains('masonry-view')) return;
    
    const items = grid.querySelectorAll('.photo-item');
    items.forEach(item => {
        const img = item.querySelector('.photo-image');
        if (img.complete) {
            setMasonryHeight(item, img);
        } else {
            img.onload = () => setMasonryHeight(item, img);
        }
    });
}

function setMasonryHeight(item, img) {
    const aspectRatio = img.naturalHeight / img.naturalWidth;
    const rowHeight = 10; // CSS grid-auto-rows value
    const rowSpan = Math.ceil((250 * aspectRatio + 10) / rowHeight);
    item.style.setProperty('--row-span', rowSpan);
}

// Photo modal functions
function openPhotoModal(index) {
    currentPhotoIndex = index;
    const modal = document.getElementById('photoModal');
    const modalImage = document.getElementById('modalImage');
    
    modalImage.src = photos[index].file_path.startsWith('http') 
        ? photos[index].file_path 
        : `{{ asset('storage') }}/${photos[index].file_path}`;
    modalImage.alt = photos[index].original_name;
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Add keyboard event listener
    document.addEventListener('keydown', handleModalKeydown);
}

function closePhotoModal() {
    const modal = document.getElementById('photoModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
    
    // Remove keyboard event listener
    document.removeEventListener('keydown', handleModalKeydown);
}

function prevPhoto() {
    currentPhotoIndex = currentPhotoIndex > 0 ? currentPhotoIndex - 1 : photos.length - 1;
    updateModalImage();
}

function nextPhoto() {
    currentPhotoIndex = currentPhotoIndex < photos.length - 1 ? currentPhotoIndex + 1 : 0;
    updateModalImage();
}

function updateModalImage() {
    const modalImage = document.getElementById('modalImage');
    modalImage.style.opacity = '0';
    
    setTimeout(() => {
        modalImage.src = photos[currentPhotoIndex].file_path.startsWith('http') 
            ? photos[currentPhotoIndex].file_path 
            : `{{ asset('storage') }}/${photos[currentPhotoIndex].file_path}`;
        modalImage.alt = photos[currentPhotoIndex].original_name;
        modalImage.style.opacity = '1';
    }, 150);
}

function handleModalKeydown(e) {
    switch(e.key) {
        case 'Escape':
            closePhotoModal();
            break;
        case 'ArrowLeft':
            prevPhoto();
            break;
        case 'ArrowRight':
            nextPhoto();
            break;
    }
}

// Delete photo function
function deletePhoto(photoId, photoName) {
    if (confirm(`Are you sure you want to delete "${photoName}"? This action cannot be undone.`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/gallery/photos/${photoId}`;
        form.style.display = 'none';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Utility function to format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Click outside modal to close
document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePhotoModal();
    }
});

// Smooth scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all fade-in elements
document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
});

// Enhanced hover effects for photo items
document.querySelectorAll('.photo-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        if (!this.classList.contains('list-view')) {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        }
    });
    
    item.addEventListener('mouseleave', function() {
        if (!this.classList.contains('list-view')) {
            this.style.transform = 'translateY(0) scale(1)';
        }
    });
});
</script>

@php
function formatFileSize($bytes) {
    if ($bytes == 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}
@endphp
@endpush