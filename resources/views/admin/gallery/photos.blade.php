@extends('layouts.app')

@section('title', $album['title'] . ' - Galeri Foto - SMA Negeri 1 Balong')

@push('styles')
<style>
    :root {
        --primary-blue: #1e40af;
        --secondary-blue: #3b82f6;
        --accent-blue: #60a5fa;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }

    .photo-gallery-hero {
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: white;
        padding: 3rem 0 2rem;
        margin-bottom: 3rem;
    }

    .hero-content {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 1rem;
        text-align: center;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-description {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .hero-meta {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        backdrop-filter: blur(10px);
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .gallery-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem 4rem;
    }

    .gallery-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .photo-count {
        font-weight: 600;
        color: var(--gray-800);
    }

    .view-toggle {
        display: flex;
        background: var(--gray-100);
        border-radius: 8px;
        padding: 0.25rem;
    }

    .toggle-btn {
        padding: 0.5rem 1rem;
        background: transparent;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        color: var(--gray-800);
        transition: all 0.3s ease;
    }

    .toggle-btn.active {
        background: var(--secondary-blue);
        color: white;
    }

    .photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        transition: all 0.3s ease;
    }

    .photos-grid.masonry {
        column-count: 4;
        column-gap: 1.5rem;
        grid-template-columns: none;
    }

    .photo-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        break-inside: avoid;
        margin-bottom: 1.5rem;
    }

    .photos-grid.masonry .photo-item {
        margin-bottom: 1.5rem;
    }

    .photo-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .photo-image {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
    }

    .photos-grid:not(.masonry) .photo-image {
        height: 220px;
        object-fit: cover;
    }

    .photo-item:hover .photo-image {
        transform: scale(1.05);
    }

    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 1000;
        backdrop-filter: blur(10px);
    }

    .lightbox.active {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .lightbox-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .lightbox-image {
        width: 100%;
        height: auto;
        max-height: 70vh;
        object-fit: contain;
        display: block;
    }

    .lightbox-info {
        padding: 1.5rem;
        background: white;
    }

    .lightbox-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .lightbox-meta {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .lightbox-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .lightbox-close:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: scale(1.1);
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .lightbox-nav:hover {
        background: rgba(0, 0, 0, 0.9);
        transform: translateY(-50%) scale(1.1);
    }

    .lightbox-prev { left: 1rem; }
    .lightbox-next { right: 1rem; }

    .download-all {
        background: var(--secondary-blue);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .download-all:hover {
        background: var(--primary-blue);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    @media (max-width: 1200px) {
        .photos-grid.masonry {
            column-count: 3;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-meta {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .gallery-controls {
            flex-direction: column;
            gap: 1rem;
        }
        
        .photos-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
        
        .photos-grid.masonry {
            column-count: 2;
        }
    }

    @media (max-width: 480px) {
        .photos-grid.masonry {
            column-count: 1;
        }
    }
</style>
@endpush

@section('content')
<div class="photo-gallery-hero">
    <div class="hero-content">
        <a href="{{ url('/gallery') }}" class="back-button">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Galeri
        </a>
        
        <h1 class="hero-title">{{ $album['title'] }}</h1>
        
        @if(!empty($album['description']))
            <p class="hero-description">{{ $album['description'] }}</p>
        @endif
        
        <div class="hero-meta">
            <div class="meta-item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ count($album['photos']) }} Foto
            </div>
            
            <div class="meta-item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m4 0V7a2 2 0 00-2-2H6a2 2 0 00-2 2v0M8 7v8a2 2 0 002 2h4a2 2 0 002-2V7M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"/>
                </svg>
                {{ isset($album['created_at']) ? \Carbon\Carbon::parse($album['created_at'])->locale('id')->isoFormat('D MMMM Y') : 'Tanggal tidak tersedia' }}
            </div>
            
            @php
                $categoryLabels = [
                    'school_events' => 'Kegiatan Sekolah',
                    'academic' => 'Akademik',
                    'extracurricular' => 'Ekstrakurikuler',
                    'achievements' => 'Prestasi',
                    'facilities' => 'Fasilitas',
                    'general' => 'Umum'
                ];
            @endphp
            
            <div class="meta-item">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                {{ $categoryLabels[$album['category']] ?? ucfirst(str_replace('_', ' ', $album['category'])) }}
            </div>
        </div>
    </div>
</div>

<div class="gallery-container">
    @if(count($album['photos']) > 0)
        <!-- Gallery Controls -->
        <div class="gallery-controls">
            <div class="photo-count">
                Menampilkan {{ count($album['photos']) }} foto
            </div>
            
            <div style="display: flex; gap: 1rem; align-items: center;">
                <div class="view-toggle">
                    <button class="toggle-btn active" id="gridBtn" onclick="toggleView('grid')">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Grid
                    </button>
                    <button class="toggle-btn" id="masonryBtn" onclick="toggleView('masonry')">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                        </svg>
                        Masonry
                    </button>
                </div>
                
                <a href="#" class="download-all" id="downloadAll">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 0a8 8 0 1100-16 8 8 0 010 16z"/>
                    </svg>
                    Download Semua
                </a>
            </div>
        </div>

        <!-- Photos Grid -->
        <div class="photos-grid" id="photosGrid">
            @foreach($album['photos'] as $index => $photo)
                <div class="photo-item" onclick="openLightbox({{ $index }})">
                    <img src="{{ asset('storage/' . $photo['path']) }}" 
                         alt="{{ $photo['original_name'] }}"
                         class="photo-image"
                         loading="lazy"
                         onerror="this.src='{{ asset('images/placeholder-gallery.jpg') }}'">
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; background: var(--gray-50); border-radius: 16px;">
            <div style="width: 80px; height: 80px; margin: 0 auto 1.5rem; background: var(--gray-100); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800); margin-bottom: 0.5rem;">Album Kosong</h2>
            <p style="color: #6b7280;">Belum ada foto yang tersedia di album ini.</p>
        </div>
    @endif
</div>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <button class="lightbox-close" onclick="closeLightbox()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <button class="lightbox-nav lightbox-prev" onclick="previousPhoto()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <button class="lightbox-nav lightbox-next" onclick="nextPhoto()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        
        <img id="lightboxImage" class="lightbox-image" src="" alt="">
        
        <div class="lightbox-info">
            <div class="lightbox-title" id="lightboxTitle"></div>
            <div class="lightbox-meta" id="lightboxMeta"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photos = @json($album['photos']);
    let currentPhotoIndex = 0;

    // View toggle functionality
    window.toggleView = function(view) {
        const photosGrid = document.getElementById('photosGrid');
        const gridBtn = document.getElementById('gridBtn');
        const masonryBtn = document.getElementById('masonryBtn');
        
        if (view === 'masonry') {
            photosGrid.classList.add('masonry');
            gridBtn.classList.remove('active');
            masonryBtn.classList.add('active');
        } else {
            photosGrid.classList.remove('masonry');
            masonryBtn.classList.remove('active');
            gridBtn.classList.add('active');
        }
    };

    // Lightbox functionality
    window.openLightbox = function(index) {
        currentPhotoIndex = index;
        updateLightboxContent();
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.closeLightbox = function(event) {
        if (event && event.target !== event.currentTarget) return;
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = 'auto';
    };

    window.nextPhoto = function() {
        currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
        updateLightboxContent();
    };

    window.previousPhoto = function() {
        currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
        updateLightboxContent();
    };

    function updateLightboxContent() {
        const photo = photos[currentPhotoIndex];
        document.getElementById('lightboxImage').src = '{{ asset("storage") }}/' + photo.path;
        document.getElementById('lightboxTitle').textContent = photo.original_name;
        document.getElementById('lightboxMeta').textContent = `${formatFileSize(photo.size)} • ${photo.mime_type}`;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('lightbox').classList.contains('active')) {
            switch(e.key) {
                case 'Escape':
                    closeLightbox();
                    break;
                case 'ArrowLeft':
                    previousPhoto();
                    break;
                case 'ArrowRight':
                    nextPhoto();
                    break;
            }
        }
    });

    // Download all functionality
    document.getElementById('downloadAll')?.addEventListener('click', function(e) {
        e.preventDefault();
        
        if (photos.length === 0) {
            alert('Tidak ada foto untuk diunduh');
            return;
        }
        
        // Download each photo
        photos.forEach((photo, index) => {
            setTimeout(() => {
                const link = document.createElement('a');
                link.href = '{{ asset("storage") }}/' + photo.path;
                link.download = photo.original_name;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }, index * 200);
        });
        
        alert(`Mulai mengunduh ${photos.length} foto. Silakan periksa folder unduhan Anda.`);
    });

    // Add staggered animation to photo items
    const photoItems = document.querySelectorAll('.photo-item');
    photoItems.forEach((item, index) => {
        item.style.animation = `fadeInUp 0.6s ease forwards ${index * 0.05}s`;
        item.style.opacity = '0';
    });

    // Add fadeInUp animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection