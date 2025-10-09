@extends('layouts.teacher')

@section('title', 'Detail Artikel - ' . $blog->title)

@push('styles')
<style>
    /* Enhanced Blog Detail Styles */
    .blog-detail-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        margin: 0;
        padding: 0;
    }

    .blog-detail-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    .content-wrapper {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        margin: 0;
        padding: 0;
        width: 100%;
        overflow: hidden;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
        min-height: 100vh;
    }

    .dark .content-wrapper {
        background: rgba(30, 41, 59, 0.98);
    }

    .header-section {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dark .header-section {
        background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .header-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .header-content {
        position: relative;
        z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
    }

    .breadcrumb-nav {
        margin-bottom: 1.5rem;
        opacity: 0.9;
    }

    .breadcrumb-nav a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-nav a:hover {
        color: white;
        text-decoration: underline;
    }

    .article-header {
        text-align: center;
    }

    .article-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .article-meta {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
        opacity: 0.9;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }

    .meta-item i {
        width: 20px;
        text-align: center;
    }

    .article-badges {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .article-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .badge-berita { background: rgba(59, 130, 246, 0.2); }
    .badge-pengumuman { background: rgba(16, 185, 129, 0.2); }
    .badge-kegiatan { background: rgba(245, 158, 11, 0.2); }
    .badge-prestasi { background: rgba(139, 92, 246, 0.2); }

    .badge-published { background: rgba(16, 185, 129, 0.2); }
    .badge-draft { background: rgba(107, 114, 128, 0.2); }
    .badge-archived { background: rgba(75, 85, 99, 0.2); }

    /* Dark mode badges */
    .dark .badge-berita { background: rgba(59, 130, 246, 0.3); color: #60a5fa; }
    .dark .badge-pengumuman { background: rgba(16, 185, 129, 0.3); color: #34d399; }
    .dark .badge-kegiatan { background: rgba(245, 158, 11, 0.3); color: #fbbf24; }
    .dark .badge-prestasi { background: rgba(139, 92, 246, 0.3); color: #a78bfa; }

    .dark .badge-published { background: rgba(16, 185, 129, 0.3); color: #34d399; }
    .dark .badge-draft { background: rgba(107, 114, 128, 0.3); color: #9ca3af; }
    .dark .badge-archived { background: rgba(75, 85, 99, 0.3); color: #9ca3af; }

    .main-content {
        padding: 3rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .article-content {
        background: var(--bg-primary, white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color, #e5e7eb);
        transition: all 0.3s ease;
    }

    .dark .article-content {
        background: var(--bg-primary);
        border-color: var(--border-color);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .featured-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        display: block;
    }

    .image-placeholder {
        width: 100%;
        height: 400px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 4rem;
    }

    .content-body {
        padding: 3rem;
    }

    .content-text {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-primary, #374151);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .dark .content-text {
        color: var(--text-primary);
    }

    .content-text h1, .content-text h2, .content-text h3,
    .content-text h4, .content-text h5, .content-text h6 {
        color: var(--text-primary, #1f2937);
        font-weight: 700;
        margin: 2rem 0 1rem 0;
        line-height: 1.3;
        transition: all 0.3s ease;
    }

    .dark .content-text h1, .dark .content-text h2, .dark .content-text h3,
    .dark .content-text h4, .dark .content-text h5, .dark .content-text h6 {
        color: var(--text-primary);
    }

    .content-text p {
        margin-bottom: 1.5rem;
    }

    .content-text ul, .content-text ol {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }

    .content-text li {
        margin-bottom: 0.5rem;
    }

    .content-text blockquote {
        border-left: 4px solid #4f46e5;
        padding: 1rem 2rem;
        margin: 2rem 0;
        background: var(--bg-secondary, #f8fafc);
        border-radius: 0 12px 12px 0;
        font-style: italic;
        transition: all 0.3s ease;
    }

    .dark .content-text blockquote {
        background: var(--bg-secondary);
        border-color: #60a5fa;
    }

    .content-text img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2rem 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .article-footer {
        padding: 2rem 3rem;
        background: var(--bg-secondary, #f8fafc);
        border-top: 1px solid var(--border-color, #e5e7eb);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .dark .article-footer {
        background: var(--bg-secondary);
        border-color: var(--border-color);
    }

    .article-tags {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .tag {
        padding: 0.25rem 0.75rem;
        background: var(--bg-tertiary, #e5e7eb);
        color: var(--text-primary, #374151);
        border-radius: 15px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .dark .tag {
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }

    .tag:hover {
        background: #4f46e5;
        color: white;
        transform: translateY(-2px);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    /* SEO Info Section */
    .seo-info {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .dark .seo-info {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .seo-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #0369a1;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dark .seo-title {
        color: #60a5fa;
    }

    .seo-item {
        margin-bottom: 1rem;
    }

    .seo-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .dark .seo-label {
        color: #f9fafb;
    }

    .seo-value {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .dark .seo-value {
        color: #d1d5db;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-section {
            padding: 1.5rem 1rem;
        }

        .article-title {
            font-size: 2rem;
        }

        .article-meta {
            flex-direction: column;
            gap: 1rem;
        }

        .main-content {
            padding: 2rem 1rem;
        }

        .content-body {
            padding: 2rem 1.5rem;
        }

        .article-footer {
            padding: 1.5rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .action-buttons {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animation */
    .article-content {
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="blog-detail-container">
    <div class="content-wrapper">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-content">
                <!-- Breadcrumb -->
                <nav class="breadcrumb-nav">
                    <a href="{{ route('teacher.dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('teacher.posts.blog.index') }}">
                        <i class="fas fa-newspaper"></i> Blog Management
                    </a>
                    <span class="mx-2">/</span>
                    <span>Detail Artikel</span>
                </nav>

                <!-- Article Header -->
                <div class="article-header">
                    <h1 class="article-title">{{ $blog->title }}</h1>
                    
                    <div class="article-meta">
                        <div class="meta-item">
                            <i class="fas fa-user"></i>
                            <span>{{ $blog->author ?? $blog->user->name ?? 'Teacher' }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ $blog->created_at->format('H:i') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-eye"></i>
                            <span>{{ rand(50, 500) }} views</span>
                        </div>
                    </div>

                    <div class="article-badges">
                        <span class="article-badge badge-{{ $blog->category ?? 'berita' }}">
                            {{ ucfirst($blog->category ?? 'berita') }}
                        </span>
                        <span class="article-badge badge-{{ $blog->status ?? 'published' }}">
                            {{ ucfirst($blog->status ?? 'published') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="article-content">
                <!-- Featured Image -->
                @if($blog->featured_image)
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                         alt="{{ $blog->title }}" 
                         class="featured-image">
                @else
                    <div class="image-placeholder">
                        <i class="fas fa-newspaper"></i>
                    </div>
                @endif

                <!-- Content Body -->
                <div class="content-body">
                    @if($blog->meta_description)
                        <div class="content-excerpt">
                            <p style="font-size: 1.25rem; font-weight: 500; color: #6b7280; margin-bottom: 2rem; font-style: italic; border-left: 4px solid #4f46e5; padding-left: 1rem;">
                                {{ $blog->meta_description }}
                            </p>
                        </div>
                    @endif

                    <div class="content-text">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    <!-- SEO Information -->
                    @if($blog->keywords || $blog->meta_description)
                        <div class="seo-info">
                            <h3 class="seo-title">
                                <i class="fas fa-search"></i>
                                SEO Information
                            </h3>
                            
                            @if($blog->meta_description)
                                <div class="seo-item">
                                    <div class="seo-label">Meta Description:</div>
                                    <div class="seo-value">{{ $blog->meta_description }}</div>
                                </div>
                            @endif
                            
                            @if($blog->keywords)
                                <div class="seo-item">
                                    <div class="seo-label">Keywords:</div>
                                    <div class="seo-value">{{ $blog->keywords }}</div>
                                </div>
                            @endif
                            
                            <div class="seo-item">
                                <div class="seo-label">Slug:</div>
                                <div class="seo-value">{{ $blog->slug }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Article Footer -->
                <div class="article-footer">
                    <div class="article-tags">
                        @if($blog->keywords)
                            @foreach(explode(',', $blog->keywords) as $keyword)
                                <span class="tag">#{{ trim($keyword) }}</span>
                            @endforeach
                        @else
                            <span class="tag">#{{ $blog->category ?? 'berita' }}</span>
                            <span class="tag">#sekolah</span>
                            <span class="tag">#pendidikan</span>
                        @endif
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('teacher.posts.blog.index') }}" class="btn-action btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke List
                        </a>
                        
                        @if($blog->status == 'published' || $blog->status == 'draft')
                            <a href="{{ route('teacher.posts.blog.edit', $blog->slug ?: $blog->id) }}" class="btn-action btn-primary">
                                <i class="fas fa-edit"></i>
                                Edit Artikel
                            </a>
                        @endif

                        <form action="{{ route('teacher.posts.blog.destroy', $blog->slug ?: $blog->id) }}" 
                              method="POST" 
                              style="display: inline;" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-danger">
                                <i class="fas fa-trash"></i>
                                Hapus Artikel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
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

    // Add copy functionality to code blocks
    document.querySelectorAll('pre, code').forEach(block => {
        if (block.textContent.length > 20) {
            block.style.position = 'relative';
            block.style.cursor = 'pointer';
            block.title = 'Click to copy';
            
            block.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent).then(() => {
                    // Show temporary feedback
                    const feedback = document.createElement('div');
                    feedback.textContent = 'Copied!';
                    feedback.style.cssText = `
                        position: absolute;
                        top: 10px;
                        right: 10px;
                        background: #10b981;
                        color: white;
                        padding: 5px 10px;
                        border-radius: 5px;
                        font-size: 12px;
                        z-index: 1000;
                    `;
                    this.appendChild(feedback);
                    
                    setTimeout(() => {
                        if (feedback.parentNode) {
                            feedback.remove();
                        }
                    }, 2000);
                });
            });
        }
    });

    // Enhanced image viewing
    document.querySelectorAll('.content-text img').forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function() {
            // Create modal for image viewing
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                cursor: pointer;
            `;
            
            const modalImg = document.createElement('img');
            modalImg.src = this.src;
            modalImg.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
                border-radius: 12px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            `;
            
            modal.appendChild(modalImg);
            document.body.appendChild(modal);
            
            modal.addEventListener('click', () => {
                document.body.removeChild(modal);
            });
        });
    });

    // Add reading progress indicator
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, #4f46e5, #7c3aed);
        z-index: 10000;
        transition: width 0.3s ease;
    `;
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + '%';
    });

    // Animate elements on scroll
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

    // Observe elements for animation
    document.querySelectorAll('.content-text p, .content-text h1, .content-text h2, .content-text h3, .seo-info').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
</script>
@endpush