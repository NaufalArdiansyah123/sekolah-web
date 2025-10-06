@extends('layouts.public')

@section('title', 'Prestasi Sekolah')
@section('meta_description', 'Berbagai prestasi membanggakan yang telah diraih oleh siswa-siswi SMK PGRI 2 Ponorogo dalam berbagai bidang kompetisi dan lomba')

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
    html.loading .achievements-hero,
    html.loading .achievements-content {
        display: none !important;
    }

    /* Hero Section */
    .achievements-hero {
        background: var(--gradient-primary);
        color: white;
        padding: 120px 0 80px;
        position: relative;
        overflow: hidden;
    }

    .achievements-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff08" points="0,1000 1000,0 1000,1000"/></svg>');
        background-size: cover;
    }

    .achievements-hero::after {
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

    .hero-content {
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(251, 191, 36, 0.2);
        color: var(--accent-color);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(251, 191, 36, 0.3);
        backdrop-filter: blur(10px);
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 800;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #ffffff, #e2e8f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.1;
    }

    .hero-subtitle {
        font-size: clamp(1rem, 2vw, 1.25rem);
        opacity: 0.9;
        margin-bottom: 3rem;
        line-height: 1.6;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 900;
        color: var(--accent-color);
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    /* Main Content */
    .achievements-content {
        padding: 100px 0;
        background: linear-gradient(135deg, var(--light-gray) 0%, #e2e8f0 100%);
        min-height: 100vh;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 1rem;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: var(--gradient-gold);
        border-radius: 2px;
    }

    .section-subtitle {
        font-size: 1.125rem;
        color: var(--dark-gray);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 3rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 2rem;
    }

    .filter-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
    }

    .filter-icon {
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

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }

    .filter-group {
        position: relative;
    }

    .filter-group label {
        display: block;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        transform: translateY(-1px);
    }

    .filter-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .filter-btn {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }

    .reset-btn {
        background: #6b7280;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
    }

    .reset-btn:hover {
        background: #4b5563;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Achievement Cards */
    .achievements-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2rem;
    }

    .achievement-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .achievement-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .card-image {
        height: 220px;
        background: var(--gradient-primary);
        position: relative;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .achievement-card:hover .card-image img {
        transform: scale(1.1);
    }

    .image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: white;
        font-size: 4rem;
        position: relative;
    }

    .image-placeholder::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at center, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    }

    .card-content {
        padding: 2rem;
    }

    .card-badges {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .badge-level {
        background: rgba(59, 130, 246, 0.1);
        color: #1d4ed8;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .badge-category {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .badge-featured {
        background: rgba(251, 191, 36, 0.1);
        color: #d97706;
        border: 1px solid rgba(251, 191, 36, 0.2);
    }

    .card-title {
        font-size: 1.375rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-description {
        color: var(--dark-gray);
        margin-bottom: 1.5rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .card-year {
        font-weight: 700;
        color: var(--secondary-color);
        font-size: 1rem;
    }

    .card-organizer {
        font-size: 0.875rem;
        color: var(--dark-gray);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .view-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--gradient-primary);
        color: white;
        text-decoration: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        justify-content: center;
        font-size: 0.95rem;
    }

    .view-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--dark-gray);
        background: white;
        border-radius: 24px;
        box-shadow: var(--shadow-lg);
    }

    .empty-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
        color: var(--secondary-color);
    }

    .empty-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }

    .empty-text {
        margin-bottom: 2rem;
        font-size: 1.125rem;
        line-height: 1.6;
    }

    .empty-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--gradient-primary);
        color: white;
        text-decoration: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .empty-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 4rem;
    }

    .pagination {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .pagination .page-link {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        background: white;
    }

    .pagination .page-link:hover {
        border-color: var(--secondary-color);
        background: var(--secondary-color);
        color: white;
        transform: translateY(-2px);
    }

    .pagination .page-item.active .page-link {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
        color: white;
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
    @media (max-width: 768px) {
        .achievements-hero {
            padding: 80px 0 60px;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .achievements-content {
            padding: 60px 0;
        }

        .achievements-grid {
            grid-template-columns: 1fr;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-direction: column;
        }

        .card-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .filter-section {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .hero-stats {
            grid-template-columns: 1fr;
        }

        .card-content {
            padding: 1.5rem;
        }

        .section-title {
            font-size: 2rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="achievements-hero">
    <div class="container hero-container">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-trophy"></i>
                Hall of Fame
            </div>
            <h1 class="hero-title">Prestasi Sekolah</h1>
            <p class="hero-subtitle">
                Berbagai pencapaian membanggakan yang telah diraih oleh siswa-siswi SMK PGRI 2 Ponorogo 
                dalam berbagai bidang kompetisi dan lomba tingkat lokal, nasional, hingga internasional
            </p>
            
            <div class="hero-stats">
                <div class="stat-card scroll-animate">
                    <div class="stat-number" data-target="{{ $statistics['total'] ?? 0 }}">{{ $statistics['total'] ?? 0 }}</div>
                    <div class="stat-label">Total Prestasi</div>
                </div>
                <div class="stat-card scroll-animate">
                    <div class="stat-number" data-target="{{ $statistics['featured'] ?? 0 }}">{{ $statistics['featured'] ?? 0 }}</div>
                    <div class="stat-label">Prestasi Unggulan</div>
                </div>
                <div class="stat-card scroll-animate">
                    <div class="stat-number" data-target="{{ $statistics['by_level']['national'] ?? 0 }}">{{ $statistics['by_level']['national'] ?? 0 }}</div>
                    <div class="stat-label">Tingkat Nasional</div>
                </div>
                <div class="stat-card scroll-animate">
                    <div class="stat-number" data-target="{{ $statistics['by_level']['international'] ?? 0 }}">{{ $statistics['by_level']['international'] ?? 0 }}</div>
                    <div class="stat-label">Tingkat Internasional</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="achievements-content">
    <div class="container">
        <div class="section-header scroll-animate">
            <h2 class="section-title">Galeri Prestasi</h2>
            <p class="section-subtitle">
                Temukan berbagai prestasi yang telah diraih sekolah dalam berbagai bidang dan tingkat kompetisi
            </p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section scroll-animate">
            <div class="filter-header">
                <div class="filter-icon">
                    <i class="fas fa-filter"></i>
                </div>
                <h3>Filter Prestasi</h3>
            </div>
            
            <form method="GET" action="{{ route('public.achievements') }}">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="search">
                            <i class="fas fa-search"></i> Pencarian
                        </label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                               placeholder="Cari prestasi..." class="filter-input">
                    </div>
                    <div class="filter-group">
                        <label for="category">
                            <i class="fas fa-tags"></i> Kategori
                        </label>
                        <select id="category" name="category" class="filter-input">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $key => $value)
                                <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="level">
                            <i class="fas fa-medal"></i> Tingkat
                        </label>
                        <select id="level" name="level" class="filter-input">
                            <option value="">Semua Tingkat</option>
                            @foreach($levels as $key => $value)
                                <option value="{{ $key }}" {{ request('level') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="year">
                            <i class="fas fa-calendar"></i> Tahun
                        </label>
                        <select id="year" name="year" class="filter-input">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-search"></i> Terapkan Filter
                    </button>
                    @if(request()->hasAny(['search', 'category', 'level', 'year']))
                        <a href="{{ route('public.achievements.index') }}" class="reset-btn">
                            <i class="fas fa-times"></i> Reset Filter
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Achievements Grid -->
        @if($achievements->count() > 0)
            <div class="achievements-grid">
                @foreach($achievements as $achievement)
                <div class="achievement-card scroll-animate">
                    <div class="card-image">
                        @if($achievement->image)
                            <img src="{{ asset($achievement->image) }}" alt="{{ $achievement->title }}" loading="lazy">
                        @else
                            <div class="image-placeholder">
                                <i class="{{ $achievement->category_icon ?? 'fas fa-trophy' }}"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-content">
                        <div class="card-badges">
                            <span class="badge badge-level">
                                <i class="fas fa-medal"></i>
                                {{ $achievement->level_formatted }}
                            </span>
                            <span class="badge badge-category">
                                <i class="fas fa-tag"></i>
                                {{ $achievement->category_formatted }}
                            </span>
                            @if($achievement->is_featured)
                                <span class="badge badge-featured">
                                    <i class="fas fa-star"></i>
                                    Unggulan
                                </span>
                            @endif
                        </div>
                        <h3 class="card-title">{{ $achievement->title }}</h3>
                        <p class="card-description">{{ Str::limit($achievement->description, 150) }}</p>
                        <div class="card-meta">
                            <span class="card-year">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $achievement->year }}
                            </span>
                            <span class="card-organizer">
                                <i class="fas fa-building"></i>
                                {{ Str::limit($achievement->organizer ?? 'Penyelenggara', 20) }}
                            </span>
                        </div>
                        <a href="{{ route('public.achievements.show', $achievement) }}" class="view-btn">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($achievements->hasPages())
            <div class="pagination-wrapper scroll-animate">
                {{ $achievements->appends(request()->query())->links() }}
            </div>
            @endif
        @else
            <div class="empty-state scroll-animate">
                <div class="empty-icon">
                    @if(request()->hasAny(['search', 'category', 'level', 'year']))
                        <i class="fas fa-search"></i>
                    @else
                        <i class="fas fa-trophy"></i>
                    @endif
                </div>
                <h3 class="empty-title">
                    @if(request()->hasAny(['search', 'category', 'level', 'year']))
                        Tidak Ada Prestasi Ditemukan
                    @else
                        Belum Ada Prestasi
                    @endif
                </h3>
                <p class="empty-text">
                    @if(request()->hasAny(['search', 'category', 'level', 'year']))
                        Tidak ada prestasi yang sesuai dengan filter yang dipilih. Coba ubah kriteria pencarian atau reset filter untuk melihat semua prestasi.
                    @else
                        Belum ada prestasi yang ditambahkan ke dalam sistem. Prestasi akan ditampilkan di sini setelah ditambahkan oleh administrator.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'category', 'level', 'year']))
                <a href="{{ route('public.achievements.index') }}" class="empty-action">
                    <i class="fas fa-times"></i> Reset Filter
                </a>
                @endif
            </div>
        @endif
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

    // Counter Animation for Stats
    function animateCounter(element, target, duration = 2000) {
        if (element.dataset.animated === 'true') return;
        element.dataset.animated = 'true';
        
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 16);
    }

    // Trigger counter animation when stats are visible
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = entry.target.querySelectorAll('.stat-number');
                statNumbers.forEach(numberElement => {
                    const target = parseInt(numberElement.dataset.target);
                    if (target && !numberElement.dataset.animated) {
                        setTimeout(() => {
                            animateCounter(numberElement, target);
                        }, 200);
                    }
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });

    const heroStats = document.querySelector('.hero-stats');
    if (heroStats) {
        statsObserver.observe(heroStats);
    }

    // Enhanced card hover effects
    const cards = document.querySelectorAll('.achievement-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // Filter form enhancements
    const filterInputs = document.querySelectorAll('.filter-input');
    filterInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });

    // Smooth scroll for pagination
    const paginationLinks = document.querySelectorAll('.pagination .page-link');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.href && !this.href.includes('#')) {
                const achievementsContent = document.querySelector('.achievements-content');
                if (achievementsContent) {
                    setTimeout(() => {
                        achievementsContent.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    }, 100);
                }
            }
        });
    });

    // Loading animation for buttons
    const buttons = document.querySelectorAll('.view-btn, .filter-btn, .empty-action');
    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.href && !this.href.includes('#')) {
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                
                setTimeout(() => {
                    this.innerHTML = originalContent;
                }, 2000);
            }
        });
    });

    // Auto-submit filter on select change (optional)
    const selectFilters = document.querySelectorAll('select.filter-input');
    selectFilters.forEach(select => {
        select.addEventListener('change', function() {
            // Uncomment the line below to enable auto-submit
            // this.closest('form').submit();
        });
    });
});
</script>
@endsection