@extends('layouts.public')

@section('title', 'Download Center')

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
        url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
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
    
    .slide-in-bottom {
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Animation Active States */
    .fade-in-up.animate,
    .fade-in-left.animate,
    .fade-in-right.animate,
    .slide-in-bottom.animate {
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
    
    .stats-icon-wrapper {
        position: relative;
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
    
    .stats-bar {
        height: 3px;
        width: 60px;
        margin: 15px auto 0;
        border-radius: 2px;
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-bar {
        width: 100px;
        opacity: 1;
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

    /* Enhanced Download Cards */
    .download-card {
        background: white;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
    }
    
    .download-card::before {
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
    
    .download-card:hover::before {
        opacity: 1;
    }
    
    .download-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }

    /* File Icon Enhancements */
    .file-icon-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--light-gray), #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .file-icon-large::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .download-card:hover .file-icon-large::before {
        opacity: 1;
    }

    .download-card:hover .file-icon-large {
        transform: scale(1.1) rotate(5deg);
    }

    /* Enhanced Buttons */
    .btn-enhanced {
        border-radius: 12px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: none;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
    }
    
    .btn-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn-enhanced:hover::before {
        left: 100%;
    }
    
    .btn-enhanced:hover {
        transform: translateY(-2px);
    }
    
    .btn-primary-enhanced {
        background: var(--gradient-primary);
        border: none;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
        color: white;
    }
    
    .btn-primary-enhanced:hover {
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
        color: white;
    }

    /* Section Headings */
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

    /* Enhanced Form Elements */
    .form-control-enhanced {
        border: 2px solid rgba(49, 130, 206, 0.1);
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
    }

    .form-control-enhanced:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        background: white;
    }

    /* Category Badges */
    .category-badge {
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

    /* Download Info */
    .download-info {
        background: rgba(49, 130, 206, 0.05);
        border-radius: 12px;
        padding: 15px;
        margin: 15px 0;
        border-left: 4px solid var(--secondary-color);
    }

    .download-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: var(--dark-gray);
    }

    .download-info-item:last-child {
        margin-bottom: 0;
    }

    .download-info-item i {
        width: 20px;
        color: var(--secondary-color);
        margin-right: 8px;
    }

    /* Empty State Enhancement */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        position: relative;
        overflow: hidden;
    }

    .empty-state::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(49, 130, 206, 0.05) 0%, transparent 70%);
        opacity: 0.5;
    }

    .empty-state-icon {
        font-size: 5rem;
        color: var(--light-gray);
        margin-bottom: 2rem;
        opacity: 0.6;
    }

    /* Staggered animation delays */
    .fade-in-up:nth-child(1) { animation-delay: 0.1s; }
    .fade-in-up:nth-child(2) { animation-delay: 0.2s; }
    .fade-in-up:nth-child(3) { animation-delay: 0.3s; }
    .fade-in-up:nth-child(4) { animation-delay: 0.4s; }
    .fade-in-up:nth-child(5) { animation-delay: 0.5s; }
    .fade-in-up:nth-child(6) { animation-delay: 0.6s; }
    
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
        
        .stats-label {
            font-size: 0.75rem;
        }
        
        .stats-card .card-body {
            padding: 2rem 1rem;
        }
        
        .filter-section {
            margin: -30px 15px 30px;
            border-radius: 15px;
        }
        
        .download-card {
            margin-bottom: 20px;
        }
    }
    
    @media (max-width: 576px) {
        .stats-number {
            font-size: 2rem !important;
        }
        
        .hero-section h1 {
            font-size: 2rem;
        }
        
        .section-heading {
            font-size: 2rem;
        }
    }

    /* Loading Animation */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Pagination Enhancement */
    .pagination {
        justify-content: center;
        margin-top: 3rem;
    }

    .page-link {
        border: none;
        border-radius: 10px;
        margin: 0 4px;
        padding: 12px 16px;
        color: var(--secondary-color);
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: var(--secondary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(49, 130, 206, 0.3);
    }

    .page-item.active .page-link {
        background: var(--gradient-primary);
        border-color: var(--secondary-color);
        box-shadow: 0 6px 20px rgba(49, 130, 206, 0.3);
    }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Download Center</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">
                    Akses berbagai materi pembelajaran, formulir, panduan, foto, video dan dokumen penting lainnya 
                    untuk mendukung kegiatan akademik dan administrasi sekolah.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-download hero-icon scale-in" style="animation-delay: 0.4s;"></i>
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
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-file-alt fa-3x text-primary stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-primary mb-2" data-target="{{ $downloads->total() }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">TOTAL FILE</p>
                        <div class="stats-bar bg-primary"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-download fa-3x text-success stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-success mb-2" data-target="{{ $downloads->sum('download_count') }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">TOTAL DOWNLOAD</p>
                        <div class="stats-bar bg-success"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-folder fa-3x text-warning stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-warning mb-2" data-target="{{ $downloads->groupBy('category')->count() }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">KATEGORI</p>
                        <div class="stats-bar bg-warning"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.6s;">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-hdd fa-3x text-info stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-info mb-2" data-target="{{ number_format($downloads->sum('file_size') / 1024 / 1024, 0) }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">TOTAL SIZE (MB)</p>
                        <div class="stats-bar bg-info"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Filter Section -->
<section class="py-5">
    <div class="container">
        <div class="filter-section p-4 fade-in-up">
            <h3 class="text-center mb-4">
                <i class="fas fa-filter me-2 text-primary"></i>Filter & Pencarian
            </h3>
            <form method="GET" action="{{ route('downloads.index') }}" class="filter-form">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-search me-2 text-primary"></i>Pencarian
                        </label>
                        <div class="position-relative">
                            <input type="text" 
                                   name="search" 
                                   class="form-control form-control-enhanced" 
                                   placeholder="Cari file, deskripsi..."
                                   value="{{ request('search') }}">
                            <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tags me-2 text-success"></i>Kategori
                        </label>
                        <select name="category" class="form-select form-control-enhanced">
                            <option value="">Semua Kategori</option>
                            <option value="materi" {{ request('category') == 'materi' ? 'selected' : '' }}>📚 Materi Pembelajaran</option>
                            <option value="foto" {{ request('category') == 'foto' ? 'selected' : '' }}>📸 Foto & Galeri</option>
                            <option value="video" {{ request('category') == 'video' ? 'selected' : '' }}>🎥 Video</option>
                            <option value="dokumen" {{ request('category') == 'dokumen' ? 'selected' : '' }}>📄 Dokumen</option>
                            <option value="formulir" {{ request('category') == 'formulir' ? 'selected' : '' }}>📋 Formulir</option>
                            <option value="panduan" {{ request('category') == 'panduan' ? 'selected' : '' }}>📖 Panduan</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-sort me-2 text-warning"></i>Urutkan
                        </label>
                        <select name="sort" class="form-select form-control-enhanced">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="downloads" {{ request('sort') == 'downloads' ? 'selected' : '' }}>Paling Populer</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-enhanced btn-enhanced w-100">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Downloads Grid -->
<section class="py-5 bg-light">
    <div class="container">
        @if($downloads->count() > 0)
            <div class="row g-4">
                @foreach($downloads as $index => $download)
                <div class="col-lg-4 col-md-6">
                    <div class="download-card h-100 fade-in-up" style="animation-delay: {{ ($index % 6) * 0.1 }}s;">
                        <!-- File Header -->
                        <div class="card-header bg-transparent border-0 p-4 text-center">
                            <div class="file-icon-large mx-auto mb-3">
                                @php
                                    $extension = pathinfo($download->file_name, PATHINFO_EXTENSION);
                                    $iconClass = match(strtolower($extension)) {
                                        'pdf' => 'fas fa-file-pdf text-danger',
                                        'doc', 'docx' => 'fas fa-file-word text-primary',
                                        'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                        'ppt', 'pptx' => 'fas fa-file-powerpoint text-warning',
                                        'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image text-purple',
                                        'mp4', 'avi', 'mov' => 'fas fa-file-video text-danger',
                                        'mp3', 'wav' => 'fas fa-file-audio text-success',
                                        'zip', 'rar' => 'fas fa-file-archive text-warning',
                                        default => 'fas fa-file text-secondary'
                                    };
                                @endphp
                                <i class="{{ $iconClass }}"></i>
                            </div>
                            <span class="category-badge">
                                @switch($download->category)
                                    @case('materi')
                                        📚 Materi
                                        @break
                                    @case('foto')
                                        📸 Foto
                                        @break
                                    @case('video')
                                        🎥 Video
                                        @break
                                    @case('dokumen')
                                        📄 Dokumen
                                        @break
                                    @case('formulir')
                                        📋 Formulir
                                        @break
                                    @case('panduan')
                                        📖 Panduan
                                        @break
                                    @default
                                        {{ ucfirst($download->category) }}
                                @endswitch
                            </span>
                        </div>

                        <!-- File Content -->
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold text-dark mb-3">
                                {{ $download->title }}
                            </h5>
                            
                            @if($download->description)
                            <p class="card-text text-muted mb-3">
                                {{ Str::limit($download->description, 120) }}
                            </p>
                            @endif

                            <!-- File Info -->
                            <div class="download-info">
                                <div class="download-info-item">
                                    <i class="fas fa-file-alt"></i>
                                    <span class="text-truncate">{{ $download->file_name }}</span>
                                </div>
                                <div class="download-info-item">
                                    <i class="fas fa-hdd"></i>
                                    <span>{{ $download->formatted_file_size }}</span>
                                </div>
                                <div class="download-info-item">
                                    <i class="fas fa-download"></i>
                                    <span data-download-id="{{ $download->id }}" class="download-count">{{ $download->download_count }} downloads</span>
                                </div>
                                <div class="download-info-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $download->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Download Button -->
                        <div class="card-footer bg-transparent border-0 p-4">
                            <a href="{{ Storage::url($download->file_path) }}" 
                               class="btn btn-primary-enhanced btn-enhanced w-100"
                               target="_blank"
                               onclick="incrementDownloadCount({{ $download->id }})">
                                <i class="fas fa-download me-2"></i>
                                Download File
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Enhanced Pagination -->
            @if($downloads->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $downloads->appends(request()->query())->links() }}
            </div>
            @endif
        @else
            <!-- Enhanced Empty State -->
            <div class="empty-state fade-in-up">
                <div class="empty-state-icon">
                    <i class="fas fa-download"></i>
                </div>
                <h3 class="fw-bold text-dark mb-3">Tidak ada file ditemukan</h3>
                <p class="text-muted mb-4">
                    Maaf, tidak ada file yang sesuai dengan kriteria pencarian Anda. 
                    Coba ubah filter atau kata kunci pencarian.
                </p>
                <a href="{{ route('downloads.index') }}" class="btn btn-primary-enhanced btn-enhanced">
                    <i class="fas fa-refresh me-2"></i>Reset Filter
                </a>
            </div>
        @endif
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .fade-in, .scale-in, .slide-in-bottom');
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

    // Auto-submit filter form on change
    const filterInputs = document.querySelectorAll('select[name="category"], select[name="sort"]');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Add loading state
            const submitBtn = document.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="loading-spinner me-2"></span>Loading...';
            submitBtn.disabled = true;
            
            this.form.submit();
        });
    });

    // Search input with debounce
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const submitBtn = document.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loading-spinner me-2"></span>Searching...';
                submitBtn.disabled = true;
                
                this.form.submit();
            }, 800);
        });
    }

    // Enhanced card hover effects
    const cards = document.querySelectorAll('.download-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '';
        });
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

    // Add loading animation to download buttons
    document.querySelectorAll('.btn-primary-enhanced').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.href && !this.href.includes('#')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="loading-spinner me-2"></span>Downloading...';
                this.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.pointerEvents = '';
                }, 2000);
            }
        });
    });

    console.log('Enhanced download page animations loaded successfully!');
});

function incrementDownloadCount(downloadId) {
    // Send AJAX request to increment download count
    fetch(`/downloads/${downloadId}/increment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the download count display
            const countElement = document.querySelector(`[data-download-id="${downloadId}"] .download-count`);
            if (countElement) {
                countElement.textContent = data.download_count + ' downloads';
                
                // Add visual feedback
                countElement.style.color = '#10b981';
                countElement.style.fontWeight = 'bold';
                setTimeout(() => {
                    countElement.style.color = '';
                    countElement.style.fontWeight = '';
                }, 1000);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endsection