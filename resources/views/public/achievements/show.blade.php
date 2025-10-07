@extends('layouts.public')

@section('title', $achievement->title)
@section('meta_description', Str::limit(strip_tags($achievement->description), 160))

@section('content')
<style>
    :root {
        --primary-color: #1a202c;
        --secondary-color: #3182ce;
        --accent-color: #fbbf24;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --info-color: #06b6d4;
        --light-gray: #f8fafc;
        --dark-gray: #64748b;
        --gradient-primary: linear-gradient(135deg, #1a202c 0%, #2d3748 50%, #3182ce 100%);
        --gradient-gold: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Loading Screen Compatibility */
    html.loading main,
    html.loading footer,
    html.loading .navbar,
    html.loading nav:not(.page-loader),
    html.loading section:not(.page-loader),
    html.loading .achievement-hero,
    html.loading .achievement-content {
        display: none !important;
    }

    /* Hero Section */
    .achievement-hero {
        background: var(--gradient-primary);
        color: white;
        padding: 120px 0 80px;
        position: relative;
        overflow: hidden;
    }

    .achievement-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff08" points="0,1000 1000,0 1000,1000"/></svg>');
        background-size: cover;
    }

    .achievement-hero::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 80%, rgba(251, 191, 36, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(49, 130, 206, 0.1) 0%, transparent 50%);
    }

    .hero-container {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-nav {
        margin-bottom: 2rem;
    }

    .breadcrumb {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        padding: 12px 24px;
        margin: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: white;
    }

    .breadcrumb-item.active {
        color: var(--accent-color);
        font-weight: 600;
    }

    .breadcrumb-divider {
        color: rgba(255, 255, 255, 0.5);
        margin: 0 8px;
    }

    .hero-content {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 4rem;
        align-items: center;
    }

    .hero-text {
        max-width: 600px;
    }

    .hero-badges {
        display: flex;
        gap: 12px;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .badge-level {
        background: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
    }

    .badge-category {
        background: rgba(16, 185, 129, 0.2);
        color: #6ee7b7;
    }

    .badge-featured {
        background: rgba(251, 191, 36, 0.2);
        color: var(--accent-color);
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #ffffff, #e2e8f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.1;
    }

    .hero-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .meta-item {
        text-align: center;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .meta-icon {
        font-size: 1.5rem;
        color: var(--accent-color);
        margin-bottom: 0.5rem;
    }

    .meta-label {
        font-size: 0.75rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .meta-value {
        font-weight: 700;
        font-size: 1rem;
    }

    .hero-image {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        aspect-ratio: 4/3;
    }

    .hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 4rem;
    }

    /* Main Content */
    .achievement-content {
        padding: 100px 0;
        background: linear-gradient(135deg, var(--light-gray) 0%, #e2e8f0 100%);
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 4rem;
    }

    .main-content {
        background: white;
        border-radius: 24px;
        padding: 3rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .content-section {
        margin-bottom: 3rem;
    }

    .content-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        background: var(--gradient-primary);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .description-content {
        font-size: 1.125rem;
        line-height: 1.8;
        color: #374151;
    }

    .description-content p {
        margin-bottom: 1.5rem;
    }

    .description-content p:last-child {
        margin-bottom: 0;
    }

    .achievement-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .detail-card {
        background: var(--light-gray);
        padding: 1.5rem;
        border-radius: 16px;
        text-align: center;
        border: 1px solid #e5e7eb;
    }

    .detail-icon {
        font-size: 2rem;
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }

    .detail-label {
        font-size: 0.875rem;
        color: var(--dark-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .detail-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Sidebar */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .sidebar-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sidebar-icon {
        width: 32px;
        height: 32px;
        background: var(--gradient-gold);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .share-buttons {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .share-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .share-btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .share-facebook {
        background: #1877f2;
        color: white;
    }

    .share-facebook:hover {
        background: #166fe5;
        color: white;
    }

    .share-twitter {
        background: #1da1f2;
        color: white;
    }

    .share-twitter:hover {
        background: #1a91da;
        color: white;
    }

    .share-whatsapp {
        background: #25d366;
        color: white;
    }

    .share-whatsapp:hover {
        background: #22c55e;
        color: white;
    }

    .share-copy {
        background: #6b7280;
        color: white;
    }

    .share-copy:hover {
        background: #4b5563;
        color: white;
    }

    .related-achievements {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .related-item {
        display: flex;
        gap: 12px;
        padding: 1rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .related-item:last-child {
        border-bottom: none;
    }

    .related-image {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
    }

    .related-content {
        flex: 1;
    }

    .related-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }

    .related-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .related-title a:hover {
        color: var(--secondary-color);
    }

    .related-meta {
        font-size: 0.75rem;
        color: var(--dark-gray);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-primary {
        background: var(--gradient-primary);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-outline {
        background: transparent;
        color: var(--primary-color);
        border-color: #e5e7eb;
    }

    .btn-outline:hover {
        background: var(--primary-color);
        color: white;
        text-decoration: none;
    }

    /* Scroll Animations */
    .scroll-animate {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .scroll-animate.animate {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .hero-content {
            grid-template-columns: 1fr;
            gap: 2rem;
            text-align: center;
        }

        .hero-text {
            max-width: none;
        }
    }

    @media (max-width: 768px) {
        .achievement-hero {
            padding: 80px 0 60px;
        }

        .achievement-content {
            padding: 60px 0;
        }

        .main-content,
        .sidebar-card {
            padding: 2rem;
        }

        .hero-meta {
            grid-template-columns: repeat(2, 1fr);
        }

        .achievement-details {
            grid-template-columns: 1fr;
        }

        .share-buttons {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .hero-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 480px) {
        .main-content,
        .sidebar-card {
            padding: 1.5rem;
        }

        .hero-meta {
            grid-template-columns: 1fr;
        }

        .breadcrumb {
            padding: 8px 16px;
            font-size: 0.875rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="achievement-hero">
    <div class="container hero-container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                </li>
                <span class="breadcrumb-divider">/</span>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.achievements') }}">
                        <i class="fas fa-trophy"></i>
                        Prestasi
                    </a>
                </li>
                <span class="breadcrumb-divider">/</span>
                <li class="breadcrumb-item active">
                    {{ Str::limit($achievement->title, 30) }}
                </li>
            </ol>
        </nav>

        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badges">
                    <span class="hero-badge badge-level">
                        <i class="fas fa-medal"></i>
                        {{ $achievement->level_formatted }}
                    </span>
                    <span class="hero-badge badge-category">
                        <i class="fas fa-tag"></i>
                        {{ $achievement->category_formatted }}
                    </span>
                    @if($achievement->is_featured)
                        <span class="hero-badge badge-featured">
                            <i class="fas fa-star"></i>
                            Unggulan
                        </span>
                    @endif
                </div>

                <h1 class="hero-title">{{ $achievement->title }}</h1>

                <div class="hero-meta">
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="meta-label">Tahun</div>
                        <div class="meta-value">{{ $achievement->year }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="meta-label">Penyelenggara</div>
                        <div class="meta-value">{{ Str::limit($achievement->organizer ?? 'N/A', 15) }}</div>
                    </div>
                    @if($achievement->participants)
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="meta-label">Peserta</div>
                        <div class="meta-value">{{ $achievement->participants }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="hero-image">
                @if($achievement->image)
                    <img src="{{ asset($achievement->image) }}" alt="{{ $achievement->title }}" loading="lazy">
                @else
                    <div class="image-placeholder">
                        <i class="{{ $achievement->category_icon ?? 'fas fa-trophy' }}"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="achievement-content">
    <div class="container">
        <div class="content-grid">
            <!-- Main Content -->
            <div class="main-content scroll-animate">
                <!-- Description -->
                <div class="content-section">
                    <h2 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        Deskripsi Prestasi
                    </h2>
                    <div class="description-content">
                        {!! nl2br(e($achievement->description)) !!}
                    </div>
                </div>

                <!-- Achievement Details -->
                @if($achievement->organizer || $achievement->location || $achievement->date || $achievement->participants)
                <div class="content-section">
                    <h2 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-list-ul"></i>
                        </div>
                        Detail Prestasi
                    </h2>
                    <div class="achievement-details">
                        @if($achievement->organizer)
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="detail-label">Penyelenggara</div>
                            <div class="detail-value">{{ $achievement->organizer }}</div>
                        </div>
                        @endif

                        @if($achievement->location)
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-label">Lokasi</div>
                            <div class="detail-value">{{ $achievement->location }}</div>
                        </div>
                        @endif

                        @if($achievement->date)
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="detail-label">Tanggal</div>
                            <div class="detail-value">{{ $achievement->date->format('d M Y') }}</div>
                        </div>
                        @endif

                        @if($achievement->participants)
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="detail-label">Peserta</div>
                            <div class="detail-value">{{ $achievement->participants }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('public.achievements') }}" class="action-btn btn-primary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Daftar
                    </a>
                    <button onclick="window.print()" class="action-btn btn-outline">
                        <i class="fas fa-print"></i>
                        Cetak Halaman
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Share -->
                <div class="sidebar-card scroll-animate">
                    <h3 class="sidebar-title">
                        <div class="sidebar-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        Bagikan Prestasi
                    </h3>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                           target="_blank" class="share-btn share-facebook">
                            <i class="fab fa-facebook-f"></i>
                            Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($achievement->title) }}" 
                           target="_blank" class="share-btn share-twitter">
                            <i class="fab fa-twitter"></i>
                            Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($achievement->title . ' - ' . request()->fullUrl()) }}" 
                           target="_blank" class="share-btn share-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            WhatsApp
                        </a>
                        <button onclick="copyToClipboard('{{ request()->fullUrl() }}')" class="share-btn share-copy">
                            <i class="fas fa-copy"></i>
                            Salin Link
                        </button>
                    </div>
                </div>

                <!-- Related Achievements -->
                @if($relatedAchievements && $relatedAchievements->count() > 0)
                <div class="sidebar-card scroll-animate">
                    <h3 class="sidebar-title">
                        <div class="sidebar-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        Prestasi Terkait
                    </h3>
                    <ul class="related-achievements">
                        @foreach($relatedAchievements as $related)
                        <li class="related-item">
                            <div class="related-image">
                                @if($related->image)
                                    <img src="{{ asset($related->image) }}" alt="{{ $related->title }}">
                                @else
                                    <i class="{{ $related->category_icon ?? 'fas fa-trophy' }}"></i>
                                @endif
                            </div>
                            <div class="related-content">
                                <h4 class="related-title">
                                    <a href="{{ route('public.achievements.show', $related) }}">
                                        {{ Str::limit($related->title, 50) }}
                                    </a>
                                </h4>
                                <div class="related-meta">
                                    <span>{{ $related->year }}</span>
                                    <span>•</span>
                                    <span>{{ $related->level_formatted }}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Quick Stats -->
                <!-- <div class="sidebar-card scroll-animate">
                    <h3 class="sidebar-title">
                        <div class="sidebar-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        Statistik Prestasi
                    </h3>
                    <div class="achievement-details">
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="detail-label">Total Prestasi</div>
                            <div class="detail-value">{{ $totalAchievements ?? 0 }}</div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-icon">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div class="detail-label">Kategori Ini</div>
                            <div class="detail-value">{{ $categoryCount ?? 0 }}</div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll Animation Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all scroll-animate elements
    document.querySelectorAll('.scroll-animate').forEach(el => {
        observer.observe(el);
    });

    // Copy to clipboard function
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            const btn = event.target.closest('.share-copy');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
            btn.style.background = '#10b981';
            
            setTimeout(() => {
                btn.innerHTML = originalContent;
                btn.style.background = '#6b7280';
            }, 2000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            
            const btn = event.target.closest('.share-copy');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
            btn.style.background = '#10b981';
            
            setTimeout(() => {
                btn.innerHTML = originalContent;
                btn.style.background = '#6b7280';
            }, 2000);
        });
    };

    // Enhanced button interactions
    const buttons = document.querySelectorAll('.action-btn, .share-btn');
    buttons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Smooth scroll for related achievements
    const relatedLinks = document.querySelectorAll('.related-title a');
    relatedLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading state
            const originalContent = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            
            setTimeout(() => {
                this.innerHTML = originalContent;
            }, 2000);
        });
    });

    // Print page styling
    window.addEventListener('beforeprint', function() {
        document.body.classList.add('printing');
    });

    window.addEventListener('afterprint', function() {
        document.body.classList.remove('printing');
    });

    // Add print styles
    const printStyles = `
        @media print {
            .sidebar, .action-buttons, .breadcrumb-nav {
                display: none !important;
            }
            .content-grid {
                grid-template-columns: 1fr !important;
            }
            .achievement-hero {
                padding: 2rem 0 !important;
                background: white !important;
                color: black !important;
            }
            .hero-title {
                color: black !important;
                -webkit-text-fill-color: black !important;
            }
            .main-content {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
            }
        }
    `;
    
    const styleSheet = document.createElement('style');
    styleSheet.textContent = printStyles;
    document.head.appendChild(styleSheet);

    // Image lazy loading enhancement
    const images = document.querySelectorAll('img[loading="lazy"]');
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }
});
</script>
@endsection