@extends('layouts.public')

@section('title', 'Berita & Blog')

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
        color: #333;
        line-height: 1.6;
    }
    
    /* Enhanced Hero Section */
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        color: white;
        padding: 100px 0;
        min-height: 70vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(49, 130, 206, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(66, 153, 225, 0.3) 0%, transparent 50%);
        z-index: 1;
    }
    
    .hero-section .container {
        position: relative;
        z-index: 2;
    }
    
    .hero-section h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.5);
    }
    
    .hero-section .lead {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        font-weight: 400;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .hero-icon {
        font-size: 8rem;
        opacity: 0.8;
        background: linear-gradient(135deg, rgba(255,255,255,0.6), rgba(255,255,255,0.2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: float 6s ease-in-out infinite;
        text-shadow: 0 0 20px rgba(255,255,255,0.3);
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Enhanced Animation Styles */
    .fade-in-up {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-left {
        opacity: 0;
        transform: translateX(-40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-right {
        opacity: 0;
        transform: translateX(40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .scale-in {
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Animation Active States */
    .fade-in-up.animate,
    .fade-in-left.animate,
    .fade-in-right.animate {
        opacity: 1;
        transform: translate(0, 0);
    }
    
    .scale-in.animate {
        opacity: 1;
        transform: scale(1);
    }

    /* Enhanced Filter Section */
    .filter-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
        margin: -50px auto 50px;
        z-index: 10;
    }

    /* Enhanced Blog Cards */
    .blog-card {
        background: white;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        height: 100%;
    }
    
    .blog-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(49, 130, 206, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .blog-card:hover::before {
        opacity: 1;
    }
    
    .blog-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }

    .blog-image {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.4s ease;
    }

    .blog-card:hover .blog-image img {
        transform: scale(1.1);
    }

    .blog-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3);
    }

    .blog-content {
        padding: 25px;
        position: relative;
        z-index: 2;
    }

    .blog-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--primary-color);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog-excerpt {
        color: var(--dark-gray);
        margin-bottom: 20px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        color: var(--dark-gray);
        margin-bottom: 20px;
    }

    .blog-author {
        display: flex;
        align-items: center;
    }

    .blog-author i {
        margin-right: 8px;
        color: var(--secondary-color);
    }

    .blog-date {
        display: flex;
        align-items: center;
    }

    .blog-date i {
        margin-right: 8px;
        color: var(--secondary-color);
    }

    .read-more-btn {
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }

    .read-more-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        color: white;
        text-decoration: none;
    }

    /* Sidebar Styles */
    .sidebar-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .sidebar-card-header {
        background: var(--gradient-primary);
        color: white;
        padding: 20px;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .sidebar-card-body {
        padding: 20px;
    }

    .sidebar-blog-item {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .sidebar-blog-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .sidebar-blog-item:hover {
        transform: translateX(5px);
    }

    .sidebar-blog-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        overflow: hidden;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .sidebar-blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sidebar-blog-content h6 {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 5px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .sidebar-blog-content small {
        color: var(--dark-gray);
        font-size: 0.8rem;
    }

    /* Category Filter */
    .category-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }

    .category-btn {
        background: white;
        border: 2px solid var(--light-gray);
        border-radius: 25px;
        padding: 8px 20px;
        color: var(--dark-gray);
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .category-btn:hover,
    .category-btn.active {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    }

    .empty-state-icon {
        font-size: 5rem;
        color: var(--light-gray);
        margin-bottom: 2rem;
        opacity: 0.6;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-section {
            padding: 60px 0;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 2.5rem;
        }
        
        .hero-icon {
            font-size: 6rem;
            margin-top: 30px;
        }
        
        .filter-section {
            margin: -30px 15px 30px;
            border-radius: 15px;
        }
        
        .blog-card {
            margin-bottom: 20px;
        }

        .category-filter {
            justify-content: center;
        }
    }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Berita & Blog Sekolah</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">
                    Ikuti perkembangan terbaru, kegiatan, prestasi, dan informasi penting 
                    dari SMA Negeri 1 Balong melalui berita dan artikel terkini.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-newspaper hero-icon scale-in" style="animation-delay: 0.4s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-5">
    <div class="container">
        <div class="filter-section p-4 fade-in-up">
            <div class="row">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('blog.index') }}" class="d-flex gap-3">
                        <div class="flex-grow-1">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Cari berita atau artikel..."
                                   value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="text-muted">{{ $blogs->total() }} artikel ditemukan</span>
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="category-filter fade-in-up" style="animation-delay: 0.2s;">
            <a href="{{ route('blog.index') }}" 
               class="category-btn {{ !request('category') ? 'active' : '' }}">
                Semua
            </a>
            @foreach($categories as $category)
            <a href="{{ route('blog.index', ['category' => $category]) }}" 
               class="category-btn {{ request('category') == $category ? 'active' : '' }}">
                @switch($category)
                    @case('berita')
                        📰 Berita
                        @break
                    @case('pengumuman')
                        📢 Pengumuman
                        @break
                    @case('kegiatan')
                        🎯 Kegiatan
                        @break
                    @case('prestasi')
                        🏆 Prestasi
                        @break
                    @default
                        {{ ucfirst($category) }}
                @endswitch
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($blogs->count() > 0)
                    <div class="row">
                        @foreach($blogs as $index => $blog)
                        <div class="col-md-6 mb-4">
                            <article class="blog-card fade-in-up" style="animation-delay: {{ ($index % 6) * 0.1 }}s;">
                                <div class="blog-image">
                                    @if($blog->featured_image)
                                        <img src="{{ Storage::url($blog->featured_image) }}" 
                                             alt="{{ $blog->title }}"
                                             loading="lazy">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                            <i class="fas fa-newspaper fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    @if($blog->category)
                                    <div class="blog-category">
                                        @switch($blog->category)
                                            @case('berita')
                                                📰 Berita
                                                @break
                                            @case('pengumuman')
                                                📢 Pengumuman
                                                @break
                                            @case('kegiatan')
                                                🎯 Kegiatan
                                                @break
                                            @case('prestasi')
                                                🏆 Prestasi
                                                @break
                                            @default
                                                {{ ucfirst($blog->category) }}
                                        @endswitch
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="blog-content">
                                    <h3 class="blog-title">
                                        <a href="{{ route('public.blog.show', $blog->id) }}" 
                                           class="text-decoration-none text-dark">
                                            {{ $blog->title }}
                                        </a>
                                    </h3>
                                    
                                    <div class="blog-meta">
                                        <div class="blog-author">
                                            <i class="fas fa-user"></i>
                                            {{ $blog->author ?? $blog->user->name }}
                                        </div>
                                        <div class="blog-date">
                                            <i class="fas fa-calendar"></i>
                                            {{ $blog->published_at->format('d M Y') }}
                                        </div>
                                    </div>
                                    
                                    <p class="blog-excerpt">
                                        {{ Str::limit(strip_tags($blog->content), 150) }}
                                    </p>
                                    
                                    <a href="{{ route('public.blog.show', $blog->id) }}" 
                                       class="read-more-btn">
                                        Baca Selengkapnya
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($blogs->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $blogs->appends(request()->query())->links() }}
                    </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="empty-state fade-in-up">
                        <div class="empty-state-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-3">Tidak ada artikel ditemukan</h3>
                        <p class="text-muted mb-4">
                            Maaf, tidak ada artikel yang sesuai dengan kriteria pencarian Anda.
                        </p>
                        <a href="{{ route('blog.index') }}" class="btn btn-primary">
                            <i class="fas fa-refresh me-2"></i>Lihat Semua Artikel
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Latest Posts -->
                <div class="sidebar-card fade-in-right">
                    <div class="sidebar-card-header">
                        <i class="fas fa-clock me-2"></i>Artikel Terbaru
                    </div>
                    <div class="sidebar-card-body">
                        @foreach($latestBlogs as $latestBlog)
                        <div class="sidebar-blog-item">
                            <div class="sidebar-blog-image">
                                @if($latestBlog->featured_image)
                                    <img src="{{ Storage::url($latestBlog->featured_image) }}" 
                                         alt="{{ $latestBlog->title }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="sidebar-blog-content">
                                <h6>
                                    <a href="{{ route('public.blog.show', $latestBlog->id) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $latestBlog->title }}
                                    </a>
                                </h6>
                                <small>{{ $latestBlog->published_at->format('d M Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Popular Posts -->
                <div class="sidebar-card fade-in-right" style="animation-delay: 0.2s;">
                    <div class="sidebar-card-header">
                        <i class="fas fa-fire me-2"></i>Artikel Populer
                    </div>
                    <div class="sidebar-card-body">
                        @foreach($popularBlogs as $popularBlog)
                        <div class="sidebar-blog-item">
                            <div class="sidebar-blog-image">
                                @if($popularBlog->featured_image)
                                    <img src="{{ Storage::url($popularBlog->featured_image) }}" 
                                         alt="{{ $popularBlog->title }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="sidebar-blog-content">
                                <h6>
                                    <a href="{{ route('public.blog.show', $popularBlog->id) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $popularBlog->title }}
                                    </a>
                                </h6>
                                <small>{{ $popularBlog->published_at->format('d M Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .scale-in');
    animatedElements.forEach(element => {
        observer.observe(element);
    });

    // Auto-submit search form on enter
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    }

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    console.log('Blog index page loaded successfully!');
});
</script>
@endsection