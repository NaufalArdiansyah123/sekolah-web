@extends('layouts.public')

@section('title', $blog->title)

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
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        color: #333;
        line-height: 1.6;
    }

    /* Article Header */
    .article-header {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.9) 0%, 
            rgba(49, 130, 206, 0.8) 100%
        );
        color: white;
        padding: 60px 0;
        position: relative;
        overflow: hidden;
    }

    .article-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(49, 130, 206, 0.2) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(66, 153, 225, 0.2) 0%, transparent 50%);
        z-index: 1;
    }

    .article-header .container {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-nav {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        padding: 8px 20px;
        margin-bottom: 30px;
        backdrop-filter: blur(10px);
        display: inline-block;
    }

    .breadcrumb-nav a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-nav a:hover {
        color: white;
    }

    .article-category {
        background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3);
    }

    .article-title {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 20px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        font-size: 1rem;
        opacity: 0.9;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-item i {
        color: var(--accent-color);
    }

    /* Article Content */
    .article-content {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-top: -50px;
        position: relative;
        z-index: 10;
    }

    .article-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 20px 20px 0 0;
    }

    .article-body {
        padding: 40px;
    }

    .article-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }

    .article-text h1,
    .article-text h2,
    .article-text h3,
    .article-text h4,
    .article-text h5,
    .article-text h6 {
        color: var(--primary-color);
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .article-text p {
        margin-bottom: 1.5rem;
    }

    .article-text img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2rem 0;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .article-text blockquote {
        background: rgba(49, 130, 206, 0.05);
        border-left: 4px solid var(--secondary-color);
        padding: 20px;
        margin: 2rem 0;
        border-radius: 0 12px 12px 0;
        font-style: italic;
    }

    .article-text ul,
    .article-text ol {
        padding-left: 2rem;
        margin-bottom: 1.5rem;
    }

    .article-text li {
        margin-bottom: 0.5rem;
    }

    /* Article Footer */
    .article-footer {
        background: rgba(49, 130, 206, 0.05);
        padding: 30px 40px;
        border-top: 1px solid #f0f0f0;
    }

    .article-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .tag {
        background: white;
        border: 2px solid var(--light-gray);
        border-radius: 20px;
        padding: 6px 15px;
        font-size: 0.9rem;
        color: var(--dark-gray);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .tag:hover {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
        color: white;
        text-decoration: none;
    }

    .share-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .share-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .share-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        color: white;
        text-decoration: none;
    }

    .share-facebook { background: #3b5998; }
    .share-twitter { background: #1da1f2; }
    .share-whatsapp { background: #25d366; }
    .share-linkedin { background: #0077b5; }

    /* Related Articles */
    .related-articles {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    }

    .section-heading {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-heading h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    .section-heading p {
        color: var(--dark-gray);
        font-size: 1.1rem;
    }

    .related-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        height: 100%;
    }

    .related-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    .related-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.4s ease;
    }

    .related-card:hover .related-image img {
        transform: scale(1.1);
    }

    .related-content {
        padding: 25px;
    }

    .related-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .related-title a {
        color: var(--primary-color);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .related-title a:hover {
        color: var(--secondary-color);
    }

    .related-meta {
        color: var(--dark-gray);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    /* Sidebar */
    .sidebar-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
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

    /* Animation Styles */
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .article-title {
            font-size: 2rem;
        }
        
        .article-meta {
            gap: 15px;
        }
        
        .article-body {
            padding: 30px 20px;
        }
        
        .article-footer {
            padding: 20px;
        }
        
        .share-buttons {
            justify-content: center;
            margin-top: 20px;
        }
        
        .article-tags {
            justify-content: center;
        }
    }
</style>

<!-- Article Header -->
<section class="article-header">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav fade-in-up">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('public.blog.index') }}">Blog</a>
            <span class="mx-2">/</span>
            <span>{{ Str::limit($blog->title, 30) }}</span>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                @if($blog->category)
                <div class="article-category fade-in-left">
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

                <h1 class="article-title fade-in-left" style="animation-delay: 0.2s;">
                    {{ $blog->title }}
                </h1>

                <div class="article-meta fade-in-left" style="animation-delay: 0.4s;">
                    <div class="meta-item">
                        <i class="fas fa-user"></i>
                        <span>{{ $blog->author ?? $blog->user->name }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $blog->published_at->format('d F Y') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} menit baca</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="article-content fade-in-up">
                    @if($blog->featured_image)
                    <img src="{{ Storage::url($blog->featured_image) }}" 
                         alt="{{ $blog->title }}"
                         class="article-image">
                    @endif

                    <div class="article-body">
                        <div class="article-text">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                    </div>

                    <div class="article-footer">
                        @if($blog->keywords)
                        <div class="article-tags">
                            @foreach(explode(',', $blog->keywords) as $keyword)
                            <span class="tag">#{{ trim($keyword) }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <strong class="text-muted">Bagikan artikel ini:</strong>
                            </div>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                                   target="_blank" 
                                   class="share-btn share-facebook"
                                   title="Bagikan ke Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($blog->title) }}" 
                                   target="_blank" 
                                   class="share-btn share-twitter"
                                   title="Bagikan ke Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . request()->fullUrl()) }}" 
                                   target="_blank" 
                                   class="share-btn share-whatsapp"
                                   title="Bagikan ke WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" 
                                   target="_blank" 
                                   class="share-btn share-linkedin"
                                   title="Bagikan ke LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
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

                <!-- Back to Blog -->
                <div class="sidebar-card fade-in-right" style="animation-delay: 0.2s;">
                    <div class="sidebar-card-body text-center">
                        <h5 class="mb-3">Lihat Artikel Lainnya</h5>
                        <p class="text-muted mb-4">Jelajahi lebih banyak artikel menarik dari kami</p>
                        <a href="{{ route('public.blog.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Blog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Articles -->
@if($relatedBlogs->count() > 0)
<section class="related-articles">
    <div class="container">
        <div class="section-heading fade-in-up">
            <h2>Artikel Terkait</h2>
            <p>Artikel lainnya yang mungkin menarik untuk Anda</p>
        </div>

        <div class="row">
            @foreach($relatedBlogs as $index => $relatedBlog)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="related-card fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="related-image">
                        @if($relatedBlog->featured_image)
                            <img src="{{ Storage::url($relatedBlog->featured_image) }}" 
                                 alt="{{ $relatedBlog->title }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                <i class="fas fa-newspaper fa-2x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="related-content">
                        <h5 class="related-title">
                            <a href="{{ route('public.blog.show', $relatedBlog->id) }}">
                                {{ $relatedBlog->title }}
                            </a>
                        </h5>
                        <div class="related-meta">
                            <span><i class="fas fa-calendar me-1"></i>{{ $relatedBlog->published_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

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

    // Share button analytics (optional)
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const platform = this.classList.contains('share-facebook') ? 'Facebook' :
                           this.classList.contains('share-twitter') ? 'Twitter' :
                           this.classList.contains('share-whatsapp') ? 'WhatsApp' :
                           this.classList.contains('share-linkedin') ? 'LinkedIn' : 'Unknown';
            
            console.log(`Article shared on ${platform}: {{ $blog->title }}`);
        });
    });

    console.log('Blog detail page loaded successfully!');
});
</script>
@endsection