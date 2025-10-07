@extends('layouts.public')

@section('title', 'Video Dokumentasi')

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
    
    /* Enhanced Hero Section matching profile page */
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1574267432553-4b4628081c31?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2031&q=80') center/cover no-repeat;
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
    
    .fade-in {
        opacity: 0;
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
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
    
    .fade-in.animate {
        opacity: 1;
    }
    
    .scale-in.animate {
        opacity: 1;
        transform: scale(1);
    }
    
    /* Enhanced Stats Section matching profile page */
    .stats-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        position: relative;
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .stats-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd, #20c997, #ffc107, #0dcaf0);
        transform: scaleX(0);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .stats-card:hover::before {
        transform: scaleX(1);
    }
    
    .stats-icon {
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotateY(360deg);
    }
    
    .stats-number {
        font-family: 'Arial', monospace;
        font-weight: 900 !important;
        letter-spacing: -2px;
        line-height: 1;
        transition: all 0.3s ease;
    }
    
    .stats-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    /* Enhanced Filter Section */
    .filter-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        padding: 2rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    
    .filter-section::before {
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
    
    .filter-section:hover::before {
        opacity: 1;
    }
    
    .filter-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
    }
    
    .filter-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        border-radius: 2px;
    }
    
    .form-control-enhanced {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }
    
    .form-control-enhanced:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.1);
        background: white;
        transform: translateY(-2px);
    }
    
    .btn-filter {
        background: var(--gradient-primary);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
    }

    /* Enhanced Video Cards */
    .video-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
    }
    
    .video-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(49, 130, 206, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1;
    }
    
    .video-card:hover::before {
        opacity: 1;
    }
    
    .video-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }
    
    .video-thumbnail {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .video-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .video-card:hover .video-thumbnail img {
        transform: scale(1.1);
    }
    
    .video-play-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 2;
    }
    
    .video-card:hover .video-play-overlay {
        opacity: 1;
    }
    
    .play-button {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .play-button:hover {
        background: white;
        transform: scale(1.1);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
    }
    
    .video-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        padding: 2rem;
        position: relative;
        z-index: 2;
    }
    
    .video-info {
        padding: 1.5rem;
        position: relative;
        z-index: 2;
    }
    
    .video-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.3s ease;
    }
    
    .video-card:hover .video-title {
        color: var(--secondary-color);
    }
    
    .video-description {
        color: var(--dark-gray);
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .video-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .video-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .badge-category {
        background: rgba(49, 130, 206, 0.1);
        color: var(--secondary-color);
    }
    
    .badge-featured {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .video-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: var(--dark-gray);
        margin-bottom: 1rem;
        padding: 0.5rem 0;
        border-top: 1px solid #f1f5f9;
    }
    
    .video-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-video {
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary-video {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }
    
    .btn-primary-video:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.4);
        text-decoration: none;
    }
    
    .btn-secondary-video {
        background: #f8fafc;
        color: var(--primary-color);
        border: 1px solid #e2e8f0;
    }
    
    .btn-secondary-video:hover {
        background: #f1f5f9;
        color: var(--primary-color);
        transform: translateY(-2px);
        text-decoration: none;
    }

    /* Featured Section */
    .featured-section {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        padding: 80px 0;
        position: relative;
    }
    
    .section-heading {
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .section-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        border-radius: 2px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--dark-gray);
    }
    
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }
    
    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }
    
    .empty-state p {
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 3rem;
    }
    
    .page-link {
        border: none;
        border-radius: 10px;
        margin: 0 0.25rem;
        padding: 0.75rem 1rem;
        color: var(--secondary-color);
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .page-link:hover {
        background: var(--secondary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }
    
    .page-item.active .page-link {
        background: var(--gradient-primary);
        border-color: var(--secondary-color);
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
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
        
        .stats-number {
            font-size: 2.5rem !important;
        }
        
        .video-actions {
            flex-direction: column;
        }
        
        .btn-video {
            justify-content: center;
        }
        
        .filter-section {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .stats-number {
            font-size: 2rem !important;
        }
        
        .hero-section h1 {
            font-size: 2rem;
        }
        
        .video-thumbnail {
            height: 180px;
        }
    }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Video Dokumentasi</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">
                    Koleksi video kegiatan dan dokumentasi SMA Negeri 1 Balong - 
                    Saksikan momen-momen berharga dalam perjalanan pendidikan kami
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-video hero-icon scale-in" style="animation-delay: 0.4s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Quick Stats -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-video fa-3x text-primary stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-primary mb-2" data-target="{{ $stats['total_videos'] }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">TOTAL VIDEO</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-eye fa-3x text-success stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-success mb-2" data-target="{{ $stats['total_views'] }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">TOTAL VIEWS</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-download fa-3x text-warning stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-warning mb-2" data-target="{{ $stats['total_downloads'] }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">TOTAL DOWNLOADS</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.6s;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-tags fa-3x text-info stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-info mb-2" data-target="{{ $stats['categories_count'] }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">KATEGORI</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Videos Section -->
@if($featuredVideos->count() > 0)
<section class="featured-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-heading fade-in-up">Video Unggulan</h2>
            <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">
                Video pilihan yang menampilkan momen-momen terbaik sekolah
            </p>
        </div>
        
        <div class="row g-4">
            @foreach($featuredVideos as $index => $video)
                <div class="col-lg-4 col-md-6">
                    <div class="video-card fade-in-up" style="animation-delay: {{ $index * 0.2 }}s;">
                        <div class="video-thumbnail">
                            @if($video->thumbnail_url)
                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}">
                            @else
                                <div class="video-placeholder">
                                    <i class="fas fa-video fa-3x mb-3"></i>
                                    <span class="fw-bold">{{ strtoupper($video->category) }}</span>
                                </div>
                            @endif
                            <div class="video-play-overlay">
                                <div class="play-button">
                                    <i class="fas fa-play fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="video-info">
                            <h3 class="video-title">{{ $video->title }}</h3>
                            
                            @if($video->description)
                                <p class="video-description">{{ $video->description }}</p>
                            @endif
                            
                            <div class="video-meta">
                                <span class="video-badge badge-category">{{ $categories[$video->category] }}</span>
                                <span class="video-badge badge-featured">Unggulan</span>
                            </div>
                            
                            <div class="video-stats">
                                <span><i class="fas fa-eye me-1"></i> {{ number_format($video->views) }}</span>
                                <span><i class="fas fa-download me-1"></i> {{ number_format($video->downloads) }}</span>
                                <span><i class="fas fa-hdd me-1"></i> {{ $video->formatted_file_size }}</span>
                            </div>
                            
                            <div class="video-actions">
                                <a href="{{ route('public.videos.show', $video) }}" class="btn-video btn-primary-video">
                                    <i class="fas fa-play"></i>
                                    Tonton
                                </a>
                                <a href="{{ route('public.videos.download', $video) }}" class="btn-video btn-secondary-video">
                                    <i class="fas fa-download"></i>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <!-- Enhanced Filter Section -->
        <div class="filter-section fade-in-up">
            <h3 class="filter-title">Cari Video</h3>
            <form method="GET" action="{{ route('public.videos.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Kata Kunci</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Masukkan kata kunci..."
                               class="form-control form-control-enhanced">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Kategori</label>
                        <select name="category" class="form-control form-control-enhanced">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-filter w-100">
                            <i class="fas fa-search me-2"></i>
                            Cari Video
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Videos Grid -->
        @if($videos->count() > 0)
            <div class="row g-4">
                @foreach($videos as $index => $video)
                    <div class="col-lg-4 col-md-6">
                        <div class="video-card fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                            <div class="video-thumbnail">
                                @if($video->thumbnail_url)
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}">
                                @else
                                    <div class="video-placeholder">
                                        <i class="fas fa-video fa-3x mb-3"></i>
                                        <span class="fw-bold">{{ strtoupper($video->category) }}</span>
                                    </div>
                                @endif
                                <div class="video-play-overlay">
                                    <div class="play-button">
                                        <i class="fas fa-play fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="video-info">
                                <h3 class="video-title">{{ $video->title }}</h3>
                                
                                @if($video->description)
                                    <p class="video-description">{{ $video->description }}</p>
                                @endif
                                
                                <div class="video-meta">
                                    <span class="video-badge badge-category">{{ $categories[$video->category] }}</span>
                                    @if($video->is_featured)
                                        <span class="video-badge badge-featured">Unggulan</span>
                                    @endif
                                </div>
                                
                                <div class="video-stats">
                                    <span><i class="fas fa-eye me-1"></i> {{ number_format($video->views) }}</span>
                                    <span><i class="fas fa-download me-1"></i> {{ number_format($video->downloads) }}</span>
                                    <span><i class="fas fa-hdd me-1"></i> {{ $video->formatted_file_size }}</span>
                                </div>
                                
                                <div class="video-actions">
                                    <a href="{{ route('public.videos.show', $video) }}" class="btn-video btn-primary-video">
                                        <i class="fas fa-play"></i>
                                        Tonton
                                    </a>
                                    <a href="{{ route('public.videos.download', $video) }}" class="btn-video btn-secondary-video">
                                        <i class="fas fa-download"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Enhanced Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $videos->links() }}
            </div>
        @else
            <!-- Enhanced Empty State -->
            <div class="empty-state fade-in-up">
                <i class="fas fa-video empty-state-icon"></i>
                <h3>Tidak ada video ditemukan</h3>
                <p>Coba ubah filter pencarian atau kembali lagi nanti untuk video terbaru.</p>
                <a href="{{ route('public.videos.index') }}" class="btn btn-filter">
                    <i class="fas fa-refresh me-2"></i>
                    Reset Filter
                </a>
            </div>
        @endif
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Counter Animation Function (matching profile page)
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        element.classList.add('counting');
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            
            const displayValue = Math.floor(current).toLocaleString();
            element.textContent = displayValue;
        }, 16);
    }
    
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
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .fade-in, .scale-in');
    animatedElements.forEach(element => {
        observer.observe(element);
    });
    
    // Stats counter animation with intersection observer
    const statsObserverOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statsNumbers = entry.target.querySelectorAll('.stats-number');
                
                statsNumbers.forEach((numberElement, index) => {
                    const target = parseInt(numberElement.dataset.target);
                    
                    setTimeout(() => {
                        animateCounter(numberElement, target, 2000);
                    }, index * 200);
                });
                
                statsObserver.unobserve(entry.target);
            }
        });
    }, statsObserverOptions);
    
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }
    
    // Enhanced card hover effects
    const videoCards = document.querySelectorAll('.video-card');
    videoCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
    
    // Video play button click handler
    document.querySelectorAll('.play-button, .video-play-overlay').forEach(element => {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const videoCard = this.closest('.video-card');
            const watchLink = videoCard.querySelector('.btn-primary-video');
            if (watchLink) {
                window.location.href = watchLink.href;
            }
        });
    });
    
    // Enhanced form interactions
    const formControls = document.querySelectorAll('.form-control-enhanced');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        control.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
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
    
    // Add loading animation to buttons
    document.querySelectorAll('.btn-video').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.href && !this.href.includes('#')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 3000);
            }
        });
    });
    
    // Page load animation sequence
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 100);
    
    console.log('Enhanced video page animations loaded successfully!');
});
</script>
@endsection