@extends('layouts.app')

@section('title', 'Galeri Foto - SMA Negeri 1 Balong')

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

    .gallery-hero {
        background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
        color: white;
        padding: 4rem 0 2rem;
        margin-bottom: 3rem;
    }

    .hero-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        line-height: 1.6;
    }

    .gallery-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem 4rem;
    }

    .category-filters {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        background: white;
        border: 2px solid var(--gray-100);
        color: var(--gray-800);
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: var(--secondary-blue);
        border-color: var(--secondary-blue);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        text-decoration: none;
    }

    .albums-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .album-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: 1px solid var(--gray-100);
    }

    .album-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .album-thumbnail {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .album-card:hover .album-thumbnail {
        transform: scale(1.05);
    }

    .album-content {
        padding: 1.5rem;
    }

    .album-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .album-description {
        color: #6b7280;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .album-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .category-badge {
        background: var(--gray-100);
        color: var(--gray-800);
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .category-school_events { background: #fef2f2; color: #dc2626; }
    .category-academic { background: #eff6ff; color: #2563eb; }
    .category-extracurricular { background: #f0fdf4; color: #16a34a; }
    .category-achievements { background: #fffbeb; color: #d97706; }
    .category-facilities { background: #f5f3ff; color: #7c3aed; }
    .category-general { background: #f9fafb; color: #374151; }

    .photo-count {
        color: #6b7280;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .album-date {
        color: #9ca3af;
        font-size: 0.85rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--gray-50);
        border-radius: 16px;
        border: 2px dashed var(--gray-100);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: var(--gray-100);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #6b7280;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.2rem;
        }
        
        .albums-grid {
            grid-template-columns: 1fr;
        }
        
        .category-filters {
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="gallery-hero">
    <div class="hero-content">
        <h1 class="hero-title">Galeri Foto</h1>
        <p class="hero-subtitle">Dokumentasi kegiatan dan momen berharga di SMA Negeri 1 Balong</p>
    </div>
</div>

<div class="gallery-container">
    @if(count($albums) > 0)
        <!-- Category Filters -->
        <div class="category-filters">
            <button class="filter-btn active" onclick="filterAlbums('all')">Semua Album</button>
            @php
                $categories = array_unique(array_column($albums, 'category'));
                $categoryLabels = [
                    'school_events' => 'Kegiatan Sekolah',
                    'academic' => 'Akademik',
                    'extracurricular' => 'Ekstrakurikuler',
                    'achievements' => 'Prestasi',
                    'facilities' => 'Fasilitas',
                    'general' => 'Umum'
                ];
            @endphp
            @foreach($categories as $category)
                <button class="filter-btn" onclick="filterAlbums('{{ $category }}')">
                    {{ $categoryLabels[$category] ?? ucfirst(str_replace('_', ' ', $category)) }}
                </button>
            @endforeach
        </div>

        <!-- Albums Grid -->
        <div class="albums-grid" id="albumsGrid">
            @foreach($albums as $album)
                <div class="album-card" data-category="{{ $album['category'] }}" onclick="window.location.href='{{ url('/gallery/photos/' . $album['slug']) }}'">
                    @if(isset($album['photos'][0]))
                        <img src="{{ asset('storage/' . $album['photos'][0]['thumbnail_path']) }}" 
                             alt="{{ $album['title'] }}" 
                             class="album-thumbnail"
                             loading="lazy"
                             onerror="this.src='{{ asset('images/placeholder-gallery.jpg') }}'">
                    @else
                        <div class="album-thumbnail" style="background: linear-gradient(135deg, #e5e7eb, #d1d5db); display: flex; align-items: center; justify-content: center;">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="album-content">
                        <h3 class="album-title">{{ $album['title'] }}</h3>
                        
                        @if(!empty($album['description']))
                            <p class="album-description">{{ $album['description'] }}</p>
                        @endif
                        
                        <div class="album-meta">
                            <span class="category-badge category-{{ $album['category'] }}">
                                {{ $categoryLabels[$album['category']] ?? ucfirst(str_replace('_', ' ', $album['category'])) }}
                            </span>
                            
                            <div class="photo-count">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $album['photo_count'] ?? count($album['photos'] ?? []) }} Foto
                            </div>
                        </div>
                        
                        <div class="album-date">
                            {{ isset($album['created_at']) ? \Carbon\Carbon::parse($album['created_at'])->locale('id')->isoFormat('D MMMM Y') : 'Tanggal tidak tersedia' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="empty-title">Belum Ada Album Foto</h2>
            <p class="empty-text">Galeri foto sedang dalam persiapan. Silakan kembali lagi nanti!</p>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    window.filterAlbums = function(category) {
        const cards = document.querySelectorAll('.album-card');
        const buttons = document.querySelectorAll('.filter-btn');
        
        // Update active button
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        // Filter cards with animation
        cards.forEach((card, index) => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'block';
                setTimeout(() => {
                    card.style.animation = 'fadeInUp 0.6s ease forwards';
                }, index * 100);
            } else {
                card.style.display = 'none';
            }
        });
    };

    // Add staggered animation to album cards
    const albumCards = document.querySelectorAll('.album-card');
    albumCards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.8s ease forwards ${index * 0.1}s`;
        card.style.opacity = '0';
    });

    // Add fadeInUp animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
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