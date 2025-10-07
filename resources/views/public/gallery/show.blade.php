@extends('layouts.public')

@section('title', $album['title'] . ' - Gallery')

@section('content')
<style>
    :root {
        --primary-color: #1a202c;
        --secondary-color: #3182ce;
        --accent-color: #4299e1;
        --light-gray: #f7fafc;
        --dark-gray: #718096;
        --glass-bg: rgba(26, 32, 44, 0.95);
        --gradient-primary: linear-gradient(135deg, #1a202c, #3182ce);
        --gradient-light: linear-gradient(135deg, rgba(49, 130, 206, 0.1), rgba(66, 153, 225, 0.05));
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

     i,
        svg {
            width: 18px;
            height: 18px;
            font-size: 16px;
            vertical-align: middle;
        }


    /* Album Header */
    .album-header {
        background: linear-gradient(135deg,
                rgba(30, 64, 175, 0.9) 0%,
                rgba(59, 130, 246, 0.8) 50%,
                rgba(30, 64, 175, 0.9) 100%),
            url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        color: white;
        padding: 80px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .album-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    .album-header-content {
        position: relative;
        z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .breadcrumb a {
        color: white;
        text-decoration: none;
        transition: opacity 0.3s ease;
    }

    .breadcrumb a:hover {
        opacity: 0.8;
    }

    .album-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .album-description {
        font-size: 1.2rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        opacity: 0.95;
        max-width: 800px;
    }

    .album-meta {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Gallery Container */
    .gallery-container {
        max-width: 1400px;
        margin: -30px auto 0;
        padding: 0 1rem 4rem;
        position: relative;
        z-index: 10;
    }

    /* Gallery Controls */
    .gallery-controls {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .controls-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .controls-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .view-controls {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .view-toggle {
        display: flex;
        background: #f1f5f9;
        border-radius: 12px;
        padding: 4px;
    }

    .view-btn {
        padding: 8px 12px;
        border: none;
        background: transparent;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #64748b;
    }

    .view-btn.active {
        background: white;
        color: var(--secondary-color);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .download-btn {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    }

    /* Photo Grid */
    .photos-grid {
        display: grid;
        gap: 1.5rem;
        transition: all 0.4s ease;
    }

    .photos-grid.grid-view {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }

    .photos-grid.masonry-view {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-auto-rows: 10px;
    }

    .photos-grid.list-view {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    /* Photo Card */
    .photo-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        opacity: 0;
        transform: translateY(20px);
    }

    .photo-card.show {
        opacity: 1;
        transform: translateY(0);
    }

    .photo-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .photo-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .photos-grid.masonry-view .photo-image {
        height: auto;
        min-height: 200px;
        max-height: 400px;
    }

    .photos-grid.list-view .photo-card {
        display: flex;
        align-items: center;
    }

    .photos-grid.list-view .photo-image {
        width: 200px;
        height: 150px;
        flex-shrink: 0;
    }

    .photo-card:hover .photo-image {
        transform: scale(1.05);
    }

    .photo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
    }

    .photo-card:hover .photo-overlay {
        opacity: 1;
    }

    .photo-info {
        color: white;
        width: 100%;
    }

    .photo-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .photo-meta {
        font-size: 0.85rem;
        opacity: 0.9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Lightbox */
    .lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .lightbox.active {
        display: flex;
    }

    .lightbox-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .lightbox-nav:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-50%) scale(1.1);
    }

    .lightbox-prev {
        left: -80px;
    }

    .lightbox-next {
        right: -80px;
    }

    .lightbox-close {
        position: absolute;
        top: -60px;
        right: 0;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }

    .lightbox-info {
        position: absolute;
        bottom: -80px;
        left: 0;
        right: 0;
        text-align: center;
        color: white;
        background: rgba(0, 0, 0, 0.5);
        padding: 1rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    /* Loading State */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .loading-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #e2e8f0;
        border-top: 4px solid var(--secondary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        border: 2px dashed #cbd5e1;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .album-title {
            font-size: 2rem;
        }

        .album-meta {
            flex-direction: column;
            gap: 1rem;
        }

        .controls-header {
            flex-direction: column;
            align-items: stretch;
        }

        .view-controls {
            justify-content: center;
        }

        .photos-grid.grid-view {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .photos-grid.list-view .photo-card {
            flex-direction: column;
        }

        .photos-grid.list-view .photo-image {
            width: 100%;
            height: 200px;
        }

        .lightbox-nav {
            width: 40px;
            height: 40px;
        }

        .lightbox-prev {
            left: 10px;
        }

        .lightbox-next {
            right: 10px;
        }
    }

    @media (max-width: 576px) {
        .gallery-controls {
            padding: 1.5rem;
        }

        .photos-grid.grid-view {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Album Header -->
<div class="album-header">
    <div class="album-header-content">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('gallery.index') }}">Gallery</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span>{{ $album['title'] }}</span>
        </nav>

        <!-- Album Info -->
        <h1 class="album-title">{{ $album['title'] }}</h1>
        
        @if(!empty($album['description']))
            <p class="album-description">{{ $album['description'] }}</p>
        @endif

        <!-- Album Meta -->
        <div class="album-meta">
            <div class="meta-item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ count($album['photos'] ?? []) }} Foto</span>
            </div>
            
            <div class="meta-item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ isset($album['created_at']) ? \Carbon\Carbon::parse($album['created_at'])->locale('id')->isoFormat('D MMMM Y') : 'Tanggal tidak tersedia' }}</span>
            </div>
            
            @if(isset($album['category']))
                <div class="meta-item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>{{ ucfirst(str_replace('_', ' ', $album['category'])) }}</span>
                </div>
            @endif
            
            @if(isset($album['created_by']))
                <div class="meta-item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>{{ $album['created_by'] }}</span>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="gallery-container">
    @if(isset($album['photos']) && count($album['photos']) > 0)
        <!-- Gallery Controls -->
        <div class="gallery-controls">
            <div class="controls-header">
                <h2 class="controls-title">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Foto Album
                </h2>
                
                <div class="view-controls">
                    <!-- View Toggle -->
                    <div class="view-toggle">
                        <button class="view-btn active" data-view="grid" title="Grid View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </button>
                        <button class="view-btn" data-view="masonry" title="Masonry View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </button>
                        <button class="view-btn" data-view="list" title="List View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Download Button -->
                    <a href="{{ route('gallery.download', $album['slug']) }}" class="download-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Album
                    </a>
                </div>
            </div>
        </div>

        <!-- Photos Grid -->
        <div class="photos-grid grid-view" id="photosGrid">
            @foreach($album['photos'] as $index => $photo)
                <div class="photo-card" data-index="{{ $index }}">
                    <img src="{{ asset('storage/' . $photo['path']) }}" 
                         alt="{{ $photo['original_name'] ?? 'Photo ' . ($index + 1) }}" 
                         class="photo-image"
                         loading="lazy">
                    
                    <div class="photo-overlay">
                        <div class="photo-info">
                            <div class="photo-title">{{ $photo['original_name'] ?? 'Photo ' . ($index + 1) }}</div>
                            <div class="photo-meta">
                                <span>{{ isset($photo['size']) ? number_format($photo['size'] / 1024, 1) . ' KB' : '' }}</span>
                                <span>{{ isset($photo['uploaded_at']) ? \Carbon\Carbon::parse($photo['uploaded_at'])->locale('id')->diffForHumans() : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Album Kosong</h3>
            <p class="text-gray-600">Album ini belum memiliki foto. Silakan kembali lagi nanti.</p>
            <a href="{{ route('gallery.index') }}" 
               class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Kembali ke Gallery
            </a>
        </div>
    @endif
</div>

<!-- Lightbox -->
<div class="lightbox" id="lightbox">
    <div class="lightbox-content">
        <img src="" alt="" class="lightbox-image" id="lightboxImage">
        
        <button class="lightbox-nav lightbox-prev" id="lightboxPrev">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <button class="lightbox-nav lightbox-next" id="lightboxNext">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        
        <button class="lightbox-close" id="lightboxClose">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="lightbox-info" id="lightboxInfo">
            <div class="font-semibold" id="lightboxTitle"></div>
            <div class="text-sm opacity-75" id="lightboxMeta"></div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photosGrid = document.getElementById('photosGrid');
    const photoCards = document.querySelectorAll('.photo-card');
    const viewButtons = document.querySelectorAll('.view-btn');
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxTitle = document.getElementById('lightboxTitle');
    const lightboxMeta = document.getElementById('lightboxMeta');
    const lightboxPrev = document.getElementById('lightboxPrev');
    const lightboxNext = document.getElementById('lightboxNext');
    const lightboxClose = document.getElementById('lightboxClose');
    
    let currentPhotoIndex = 0;
    const photos = @json($album['photos'] ?? []);
    
    // Initialize animations
    function initializeAnimations() {
        photoCards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('show');
            }, index * 100);
        });
    }
    
    // View toggle functionality
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.dataset.view;
            
            // Update button states
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update grid class
            photosGrid.className = `photos-grid ${view}-view`;
            
            // Re-animate cards
            photoCards.forEach((card, index) => {
                card.classList.remove('show');
                setTimeout(() => {
                    card.classList.add('show');
                }, index * 50);
            });
        });
    });
    
    // Lightbox functionality
    photoCards.forEach((card, index) => {
        card.addEventListener('click', function() {
            openLightbox(index);
        });
    });
    
    function openLightbox(index) {
        currentPhotoIndex = index;
        updateLightboxContent();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    function updateLightboxContent() {
        const photo = photos[currentPhotoIndex];
        if (photo) {
            lightboxImage.src = '{{ asset("storage/") }}/' + photo.path;
            lightboxImage.alt = photo.original_name || 'Photo ' + (currentPhotoIndex + 1);
            lightboxTitle.textContent = photo.original_name || 'Photo ' + (currentPhotoIndex + 1);
            
            let metaText = '';
            if (photo.size) {
                metaText += (photo.size / 1024).toFixed(1) + ' KB';
            }
            if (photo.uploaded_at) {
                if (metaText) metaText += ' • ';
                metaText += new Date(photo.uploaded_at).toLocaleDateString('id-ID');
            }
            lightboxMeta.textContent = metaText;
        }
    }
    
    function nextPhoto() {
        currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
        updateLightboxContent();
    }
    
    function prevPhoto() {
        currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
        updateLightboxContent();
    }
    
    // Lightbox event listeners
    lightboxClose.addEventListener('click', closeLightbox);
    lightboxNext.addEventListener('click', nextPhoto);
    lightboxPrev.addEventListener('click', prevPhoto);
    
    // Close lightbox when clicking outside
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (lightbox.classList.contains('active')) {
            switch(e.key) {
                case 'Escape':
                    closeLightbox();
                    break;
                case 'ArrowLeft':
                    prevPhoto();
                    break;
                case 'ArrowRight':
                    nextPhoto();
                    break;
            }
        }
    });
    
    // Initialize page
    setTimeout(initializeAnimations, 100);
    
    // Masonry layout for masonry view
    function initMasonry() {
        if (photosGrid.classList.contains('masonry-view')) {
            const cards = Array.from(photoCards);
            cards.forEach(card => {
                const img = card.querySelector('.photo-image');
                if (img.complete) {
                    setMasonryHeight(card, img);
                } else {
                    img.addEventListener('load', () => setMasonryHeight(card, img));
                }
            });
        }
    }
    
    function setMasonryHeight(card, img) {
        const aspectRatio = img.naturalHeight / img.naturalWidth;
        const cardWidth = card.offsetWidth;
        const imageHeight = cardWidth * aspectRatio;
        const gridRowEnd = Math.ceil((imageHeight + 20) / 10);
        card.style.gridRowEnd = `span ${gridRowEnd}`;
    }
    
    // Re-initialize masonry when view changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                if (photosGrid.classList.contains('masonry-view')) {
                    setTimeout(initMasonry, 100);
                }
            }
        });
    });
    
    observer.observe(photosGrid, { attributes: true });
});
</script>
@endsection