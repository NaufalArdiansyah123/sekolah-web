<?php
// resources/views/admin/gallery/index.blade.php
?>
@extends('layouts.admin.app')

@section('title', 'Gallery Management')

@section('content')
<style>
    .gallery-container {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 50%, #ffffff 100%);
        min-height: 100vh;
        padding: 1.5rem;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        padding: 1.5rem 2rem;
        border-radius: 16px;
        border: 1px solid rgba(14, 165, 233, 0.1);
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
    }

    .page-title {
        color: #0c4a6e;
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(14, 165, 233, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Statistics Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 14px;
        border: 1px solid rgba(14, 165, 233, 0.1);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(14, 165, 233, 0.15);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #dbeafe, #bae6fd);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0c4a6e;
        margin-bottom: 0.25rem;
    }

    .stat-title {
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Albums Grid */
    .albums-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .album-item {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(14, 165, 233, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 2px 12px rgba(14, 165, 233, 0.05);
    }

    .album-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.15);
    }

    .album-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .album-item:hover .album-image {
        transform: scale(1.03);
    }

    .album-placeholder {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .album-body {
        padding: 1.25rem;
    }

    .album-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0c4a6e;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .album-desc {
        color: #64748b;
        font-size: 0.85rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .album-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        font-size: 0.75rem;
        color: #64748b;
    }

    .category-tag {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 500;
        background: rgba(14, 165, 233, 0.1);
        color: #0c4a6e;
        border: 1px solid rgba(14, 165, 233, 0.15);
    }

    /* Category specific colors */
    .category-school_events { background: rgba(239, 68, 68, 0.1); color: #dc2626; border-color: rgba(239, 68, 68, 0.2); }
    .category-academic { background: rgba(14, 165, 233, 0.1); color: #0284c7; border-color: rgba(14, 165, 233, 0.2); }
    .category-extracurricular { background: rgba(16, 185, 129, 0.1); color: #059669; border-color: rgba(16, 185, 129, 0.2); }
    .category-achievements { background: rgba(245, 158, 11, 0.1); color: #d97706; border-color: rgba(245, 158, 11, 0.2); }
    .category-facilities { background: rgba(139, 92, 246, 0.1); color: #7c3aed; border-color: rgba(139, 92, 246, 0.2); }
    .category-general { background: rgba(107, 114, 128, 0.1); color: #374151; border-color: rgba(107, 114, 128, 0.2); }

    .album-controls {
        display: flex;
        gap: 0.5rem;
    }

    .control-btn {
        padding: 0.6rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        letter-spacing: 0.01em;
    }

    .btn-remove {
        background: rgba(248, 113, 113, 0.1);
        color: #ef4444;
        border: 1px solid rgba(248, 113, 113, 0.2);
    }

    .btn-remove:hover {
        background: rgba(248, 113, 113, 0.2);
        transform: translateY(-1px);
        box-shadow: 0 3px 12px rgba(248, 113, 113, 0.25);
    }

    /* Empty State */
    .no-content {
        text-align: center;
        padding: 3rem 2rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        border: 1px solid rgba(14, 165, 233, 0.1);
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #dbeafe, #bae6fd);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
    }

    .empty-heading {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0c4a6e;
        margin-bottom: 0.5rem;
    }

    .empty-message {
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .gallery-container {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            padding: 1.25rem;
        }

        .albums-container {
            grid-template-columns: 1fr;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Smooth Animations */
    .album-item {
        animation: slideUp 0.5s ease-out;
    }

    .album-item:nth-child(2n) {
        animation-delay: 0.1s;
    }

    .album-item:nth-child(3n) {
        animation-delay: 0.2s;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="gallery-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gallery Management</h1>
            <p class="page-subtitle">Manage your photo albums and gallery content</p>
        </div>
        <a href="{{ route('admin.gallery.upload') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Upload Photos
        </a>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 7a2 2 0 002-2h10a2 2 0 002 2v2M5 7V5a2 2 0 012-2h6a2 2 0 012 2v2"/>
                </svg>
            </div>
            <div class="stat-value">{{ count($photos) }}</div>
            <div class="stat-title">Total Albums</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-value">{{ array_sum(array_column($photos, 'photo_count')) }}</div>
            <div class="stat-title">Total Photos</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div class="stat-value">{{ count(array_unique(array_column($photos, 'category'))) }}</div>
            <div class="stat-title">Categories</div>
        </div>
    </div>

    <!-- Albums Grid -->
    @if(count($photos) > 0)
        <div class="albums-container">
            @foreach($photos as $album)
                <div class="album-item">
                    @if(isset($album['photos'][0]))
                        <img src="{{ asset('storage/' . $album['photos'][0]['thumbnail_path']) }}" 
                             alt="{{ $album['title'] }}" 
                             class="album-image"
                             onerror="this.src='{{ asset('images/placeholder-image.png') }}'">
                    @else
                        <div class="album-placeholder">
                            <svg class="w-16 h-16" style="color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="album-body">
                        <h3 class="album-name">{{ $album['title'] }}</h3>
                        
                        @if($album['description'])
                            <p class="album-desc">{{ $album['description'] }}</p>
                        @endif
                        
                        <div class="album-info">
                            <span class="category-tag category-{{ $album['category'] }}">
                                {{ ucfirst(str_replace('_', ' ', $album['category'])) }}
                            </span>
                            <span>{{ $album['photo_count'] }} photos</span>
                        </div>
                        
                        <div class="album-info">
                            <span>{{ \Carbon\Carbon::parse($album['created_at'])->format('M d, Y') }}</span>
                            <span>by {{ $album['created_by'] }}</span>
                        </div>
                        
                        <div class="album-controls">
                            <a href="{{ route('gallery.photos', $album['slug']) }}" 
                               target="_blank"
                               class="control-btn btn-view-public">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View Public
                            </a>
                            
                            <form action="{{ route('admin.gallery.destroy', $album['id']) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('Are you sure you want to delete this album? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="control-btn btn-remove">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="no-content">
            <div class="empty-icon">
                <svg class="w-10 h-10" style="color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="empty-heading">No Photo Albums Yet</h3>
            <p class="empty-message">Start building your gallery by uploading your first photo album</p>
            <a href="{{ route('admin.gallery.upload') }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Upload Your First Album
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth hover animations
    const albumCards = document.querySelectorAll('.album-item');
    albumCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-6px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Button click effects
    const buttons = document.querySelectorAll('.control-btn, .btn-primary');
    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Create ripple effect
            const ripple = document.createElement('div');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 50%;
                transform: scale(0);
                animation: buttonRipple 0.5s ease-out;
                pointer-events: none;
                z-index: 10;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                if (ripple.parentNode) {
                    ripple.remove();
                }
            }, 500);
        });
    });

    // Add ripple animation style
    const style = document.createElement('style');
    style.textContent = `
        @keyframes buttonRipple {
            to {
                transform: scale(3);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection