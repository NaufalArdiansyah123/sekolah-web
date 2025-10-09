@extends('layouts.admin')

@section('title', 'Gallery Management')

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
        
        /* Button colors */
        --btn-view-bg: rgba(59, 130, 246, 0.1);
        --btn-view-border: rgba(59, 130, 246, 0.2);
        --btn-view-hover-bg: rgba(59, 130, 246, 0.2);
        --btn-delete-bg: rgba(239, 68, 68, 0.1);
        --btn-delete-border: rgba(239, 68, 68, 0.2);
        --btn-delete-hover-bg: rgba(239, 68, 68, 0.2);
        --btn-delete-hover-color: #dc2626;
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
        
        /* Button colors for dark mode */
        --btn-view-bg: rgba(59, 130, 246, 0.2);
        --btn-view-border: rgba(59, 130, 246, 0.3);
        --btn-view-hover-bg: rgba(59, 130, 246, 0.3);
        --btn-delete-bg: rgba(239, 68, 68, 0.2);
        --btn-delete-border: rgba(239, 68, 68, 0.3);
        --btn-delete-hover-bg: rgba(239, 68, 68, 0.3);
        --btn-delete-hover-color: #fca5a5;
    }

    .gallery-container {
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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-primary);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .stat-icon.primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
    }

    .stat-icon.success {
        background: linear-gradient(135deg, var(--success-color), #059669);
        color: white;
    }

    .stat-icon.warning {
        background: linear-gradient(135deg, var(--warning-color), #d97706);
        color: white;
    }

    .stat-icon.info {
        background: linear-gradient(135deg, var(--info-color), #0891b2);
        color: white;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-weight: 500;
        font-size: 0.875rem;
    }

    .albums-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .album-card {
        background: var(--bg-primary);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
    }

    .album-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .album-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .album-card:hover .album-image {
        transform: scale(1.05);
    }

    .album-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 3rem;
    }

    .album-content {
        padding: 1.5rem;
    }

    .album-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .album-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
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
        font-size: 0.75rem;
        color: var(--text-muted);
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

    .album-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-view {
        background: var(--btn-view-bg);
        color: var(--primary-color);
        border: 1px solid var(--btn-view-border);
    }

    .btn-view:hover {
        background: var(--btn-view-hover-bg);
        color: var(--primary-color);
        text-decoration: none;
        transform: translateY(-1px);
    }

    .dark .btn-view:hover {
        color: #93c5fd;
    }

    .btn-delete {
        background: var(--btn-delete-bg);
        color: var(--danger-color);
        border: 1px solid var(--btn-delete-border);
    }

    .btn-delete:hover {
        background: var(--btn-delete-hover-bg);
        color: var(--btn-delete-hover-color);
        transform: translateY(-1px);
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .gallery-container {
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

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .albums-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .album-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-card {
            padding: 1rem;
        }

        .album-content {
            padding: 1rem;
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

    /* Loading skeleton */
    .skeleton {
        background: linear-gradient(90deg, var(--bg-tertiary) 25%, var(--bg-secondary) 50%, var(--bg-tertiary) 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endpush

@section('content')
<div class="gallery-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-images"></i>
                    Gallery Management
                </h1>
                <p class="page-subtitle">
                    Manage your photo albums and gallery content with ease
                </p>
            </div>
            <a href="{{ route('admin.gallery.upload') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i>
                Upload Photos
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card fade-in">
            <div class="stat-icon primary">
                <i class="fas fa-folder"></i>
            </div>
            <div class="stat-value">{{ count($photos) }}</div>
            <div class="stat-label">Total Albums</div>
        </div>

        <div class="stat-card fade-in">
            <div class="stat-icon success">
                <i class="fas fa-images"></i>
            </div>
            <div class="stat-value">{{ array_sum(array_column($photos, 'photo_count')) }}</div>
            <div class="stat-label">Total Photos</div>
        </div>

        <div class="stat-card fade-in">
            <div class="stat-icon warning">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-value">{{ count(array_unique(array_column($photos, 'category'))) }}</div>
            <div class="stat-label">Categories</div>
        </div>

        <div class="stat-card fade-in">
            <div class="stat-icon info">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-value">{{ number_format(array_sum(array_column($photos, 'views', 0))) }}</div>
            <div class="stat-label">Total Views</div>
        </div>
    </div>

    <!-- Albums Grid -->
    @if(count($photos) > 0)
        <div class="albums-grid">
            @foreach($photos as $album)
                <div class="album-card fade-in">
                    @if(isset($album['photos'][0]))
                        <img src="{{ asset('storage/' . $album['photos'][0]['thumbnail_path']) }}" 
                             alt="{{ $album['title'] }}" 
                             class="album-image"
                             onerror="this.parentElement.innerHTML='<div class=\'album-placeholder\'><i class=\'fas fa-image\'></i></div>'">
                    @else
                        <div class="album-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                    
                    <div class="album-content">
                        <h3 class="album-title">{{ $album['title'] }}</h3>
                        
                        @if($album['description'])
                            <p class="album-description">{{ $album['description'] }}</p>
                        @endif
                        
                        <div class="album-meta">
                            <span class="category-badge category-{{ $album['category'] }}">
                                {{ ucfirst(str_replace('_', ' ', $album['category'])) }}
                            </span>
                            <span>{{ $album['photo_count'] }} photos</span>
                        </div>
                        
                        <div class="album-meta">
                            <span>{{ \Carbon\Carbon::parse($album['created_at'])->format('M d, Y') }}</span>
                            <span>by {{ $album['created_by'] }}</span>
                        </div>
                        
                        <div class="album-actions">
                            <a href="{{ route('gallery.show', $album['slug']) }}" 
                               target="_blank"
                               class="btn-action btn-view">
                                <i class="fas fa-eye"></i>
                                View Public
                            </a>
                            
                            <form action="{{ route('admin.gallery.destroy', $album['id']) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirmDelete('{{ $album['title'] }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">
                                    <i class="fas fa-trash"></i>
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
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-images"></i>
            </div>
            <h3 class="empty-title">No Photo Albums Yet</h3>
            <p class="empty-description">
                Start building your gallery by uploading your first photo album. 
                Share your school's memorable moments with the community.
            </p>
            <a href="{{ route('admin.gallery.upload') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i>
                Upload Your First Album
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth animations on scroll
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

    // Enhanced hover effects
    document.querySelectorAll('.album-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Ripple effect for buttons
    document.querySelectorAll('.btn-primary-custom, .btn-action').forEach(button => {
        button.addEventListener('click', function(e) {
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
                animation: ripple 0.6s ease-out;
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
            }, 600);
        });
    });

    // Add ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});

// Confirm delete function
function confirmDelete(albumTitle) {
    return confirm(`Are you sure you want to delete the album "${albumTitle}"? This action cannot be undone and will remove all photos in this album.`);
}

// Loading state management
function showLoading() {
    document.querySelectorAll('.album-card').forEach(card => {
        card.classList.add('skeleton');
    });
}

function hideLoading() {
    document.querySelectorAll('.album-card').forEach(card => {
        card.classList.remove('skeleton');
    });
}

// Auto-refresh functionality (optional)
let autoRefreshInterval;

function startAutoRefresh() {
    autoRefreshInterval = setInterval(() => {
        // Check for new albums or updates
        fetch(window.location.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Update content if needed
            console.log('Gallery refreshed');
        })
        .catch(error => {
            console.error('Auto-refresh failed:', error);
        });
    }, 30000); // Refresh every 30 seconds
}

function stopAutoRefresh() {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
    }
}

// Start auto-refresh when page is visible
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        stopAutoRefresh();
    } else {
        startAutoRefresh();
    }
});

// Initialize auto-refresh
startAutoRefresh();
</script>
@endpush