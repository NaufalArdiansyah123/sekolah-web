<?php
// resources/views/public/gallery/index.blade.php
?>
@extends('layouts.public.app')

@section('title', 'Photo Gallery')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        margin: 0;
        font-family: 'Inter', sans-serif;
    }

    .gallery-hero {
        padding: 6rem 0 4rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 900;
        color: white;
        margin-bottom: 1rem;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        letter-spacing: -0.02em;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .gallery-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem 4rem;
    }

    .category-filter {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .albums-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
    }

    .album-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .album-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.2);
    }

    .album-thumbnail {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: all 0.4s ease;
        position: relative;
    }

    .album-card:hover .album-thumbnail {
        transform: scale(1.1);
    }

    .album-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
        opacity: 0;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .album-card:hover .album-overlay {
        opacity: 1;
    }

    .overlay-text {
        color: white;
        font-size: 1.2rem;
        font-weight: 700;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .album-content {
        padding: 2rem;
    }

    .album-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .album-description {
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .album-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .category-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .category-school_events { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
    .category-academic { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
    .category-extracurricular { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .category-achievements { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .category-facilities { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }
    .category-general { background: linear-gradient(135deg, #6b7280, #374151); color: white; }

    .photo-count {
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .album-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }

    .empty-state {
        text-align: center;
        padding: 6rem 2rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 2rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .empty-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1rem;
    }

    .empty-text {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2rem;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            padding: 0 1rem;
        }
        
        .gallery-container {
            padding: 0 1rem 2rem;
        }
        
        .albums-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .category-filter {
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }
        
        .filter-btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
    }
</style>

<!-- Hero Section -->
<div class="gallery-hero">
    <div class="container mx-auto px-4">
        <h1 class="hero-title">Photo Gallery</h1>
        <p class="hero-subtitle">Discover beautiful moments captured through our lens</p>
    </div>
</div>

<!-- Gallery Container -->
<div class="gallery-container">
    @if(count($albums) > 0)
        <!-- Category Filter -->
        <div class="category-filter">
            <button class="filter-btn active" onclick="filterAlbums('all')">All Albums</button>
            @php
                $categories = array_unique(array_column($albums, 'category'));
            @endphp
            @foreach($categories as $category)
                <button class="filter-btn" onclick="filterAlbums('{{ $category }}')">
                    {{ ucfirst(str_replace('_', ' ', $category)) }}
                </button>
            @endforeach
        </div>

        <!-- Albums Grid -->
        <div class="albums-grid" id="albumsGrid">
            @foreach($albums as $album)
                <div class="album-card" data-category="{{ $album['category'] }}" onclick="window.location.href='{{ route('gallery.photos', $album['slug']) }}'">
                    <div style="position: relative;">
                        @if(isset($album['photos'][0]))
                            <img src="{{ asset('storage/' . $album['photos'][0]['thumbnail_path']) }}" 
                                 alt="{{ $album['title'] }}" 
                                 class="album-thumbnail"
                                 loading="lazy"
                                 onerror="this.src='{{ asset('images/placeholder-image.png') }}'">
                        @else
                            <div class="album-thumbnail" style="background: linear-gradient(135deg, #e2e8f0, #cbd5e1); display: flex; align-items: center; justify-content: center;">
                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="album-overlay">
                            <div class="overlay-text">View Album</div>
                        </div>
                    </div>
                    
                    <div class="album-content">
                        <h3 class="album-title">{{ $album['title'] }}</h3>
                        
                        @if($album['description'])
                            <p class="album-description">{{ $album['description'] }}</p>
                        @endif
                        
                        <div class="album-meta">
                            <span class="category-badge category-{{ $album['category'] }}">
                                {{ ucfirst(str_replace('_', ' ', $album['category'])) }}
                            </span>
                            
                            <div class="photo-count">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $album['photo_count'] }} Photos
                            </div>
                        </div>
                        
                        <div class="album-stats">
                            <span>{{ \Carbon\Carbon::parse($album['created_at'])->format('M d, Y') }}</span>
                            <span>by {{ $album['created_by'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="empty-title">No Albums Yet</h2>
            <p class="empty-text">Our photo gallery is being prepared. Check back soon for amazing photos!</p>
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
        
        // Filter cards
        cards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'block';
                card.style.animation = 'fadeInUp 0.6s ease forwards';
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

    // Enhanced hover effects
    albumCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-12px) scale(1.04)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add fadeInUp animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInFromBottom {
            from {
                opacity: 0;
                transform: translateY(100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);

    // Add parallax effect to hero
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.gallery-hero');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
    });
});
</script>
@endsection