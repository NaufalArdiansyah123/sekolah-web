@extends('layouts.public')

@section('title', 'Pengumuman Sekolah')

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
    
    /* Enhanced Hero Section matching other pages */
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3') center/cover no-repeat;
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
        background: 
            radial-gradient(circle at 20% 50%, rgba(49, 130, 206, 0.05) 0%, transparent 70%);
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
        cursor: pointer;
        position: relative;
        z-index: 10;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
        color: white;
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        z-index: 10;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    /* Enhanced Announcement Cards */
    .announcement-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        margin-bottom: 2rem;
    }
    
    .announcement-card::before {
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
    
    .announcement-card:hover::before {
        opacity: 1;
    }
    
    .announcement-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }
    
    .announcement-image {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .announcement-card:hover .announcement-image {
        transform: scale(1.05);
    }
    
    .announcement-content {
        padding: 2rem;
        position: relative;
        z-index: 2;
    }
    
    .priority-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 3;
    }
    
    .priority-urgent {
        background: rgba(239, 68, 68, 0.9);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }
    
    .priority-high {
        background: rgba(245, 158, 11, 0.9);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    
    .priority-normal {
        background: rgba(16, 185, 129, 0.9);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .priority-low {
        background: rgba(107, 114, 128, 0.9);
        color: white;
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
    }
    
    .category-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        background: rgba(49, 130, 206, 0.1);
        color: var(--secondary-color);
        margin-bottom: 1rem;
    }
    
    .announcement-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        line-height: 1.3;
        transition: color 0.3s ease;
    }
    
    .announcement-card:hover .announcement-title {
        color: var(--secondary-color);
    }
    
    .announcement-excerpt {
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .announcement-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        color: var(--dark-gray);
    }
    
    .announcement-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-announcement {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }
    
    .btn-primary-announcement {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }
    
    .btn-primary-announcement:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.4);
        text-decoration: none;
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
        
        .announcement-content {
            padding: 1.5rem;
        }
        
        .announcement-title {
            font-size: 1.25rem;
        }
        
        .announcement-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .filter-section {
            padding: 1.5rem;
        }
    }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Pengumuman Sekolah</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">
                    Informasi terbaru dan penting dari SMA Negeri 1 - 
                    Tetap update dengan pengumuman resmi sekolah
                </p>
                <div class="d-flex gap-3 fade-in-left" style="animation-delay: 0.4s;">
                    <span class="badge bg-light text-dark fs-6">📢 Pengumuman</span>
                    <span class="badge bg-light text-dark fs-6">🚨 Urgent</span>
                    <span class="badge bg-light text-dark fs-6">📅 Terbaru</span>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-bullhorn hero-icon scale-in" style="animation-delay: 0.6s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <!-- Enhanced Filter Section -->
        <div class="filter-section fade-in-up">
            <h3 class="filter-title">Cari Pengumuman</h3>

            <form method="GET" action="{{ route('announcements.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold text-muted">Kata Kunci</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari pengumuman..."
                               class="form-control form-control-enhanced">
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold text-muted">Kategori</label>
                        <select name="category" class="form-control form-control-enhanced">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold text-muted">Prioritas</label>
                        <select name="priority" class="form-control form-control-enhanced">
                            <option value="">Semua Prioritas</option>
                            @foreach($priorities as $priority)
                                <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                                    {{ ucfirst($priority) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-lg-3 col-md-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-filter flex-fill">
                                <i class="fas fa-search me-2"></i>
                                Cari
                            </button>
                            @if(request()->hasAny(['search', 'category', 'priority']))
                                <a href="{{ route('announcements.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Active Filters Display -->
                @if(request()->hasAny(['search', 'category', 'priority']))
                    <div class="mt-3">
                        <small class="text-muted">Filter aktif:</small>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @if(request('search'))
                                <span class="badge bg-primary">Pencarian: "{{ request('search') }}"</span>
                            @endif
                            @if(request('category'))
                                <span class="badge bg-success">Kategori: {{ ucfirst(request('category')) }}</span>
                            @endif
                            @if(request('priority'))
                                <span class="badge bg-info">Prioritas: {{ ucfirst(request('priority')) }}</span>
                            @endif
                        </div>
                    </div>
                @endif
            </form>
        </div>

        <!-- Results Info -->
        @if($announcements->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0">Ditemukan {{ $announcements->total() }} pengumuman</h4>
                    <small class="text-muted">Menampilkan {{ $announcements->firstItem() }}-{{ $announcements->lastItem() }} dari {{ $announcements->total() }} pengumuman</small>
                </div>
            </div>
        @endif
        
        <!-- Announcements Grid -->
        @if($announcements->count() > 0)
            <div class="row">
                @foreach($announcements as $index => $announcement)
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="announcement-card fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                            @if($announcement->featured_image)
                                <img src="{{ asset('storage/' . $announcement->featured_image) }}" 
                                     alt="{{ $announcement->title }}" 
                                     class="announcement-image w-100">
                            @endif
                            
                            <!-- Priority Badge -->
                            <div class="priority-badge priority-{{ $announcement->priority ?? 'normal' }}">
                                @if($announcement->priority === 'urgent') 🚨 Urgent
                                @elseif($announcement->priority === 'high') ⚠️ Tinggi
                                @elseif($announcement->priority === 'normal') ✅ Normal
                                @else 📝 Rendah
                                @endif
                            </div>
                            
                            <div class="announcement-content">
                                <!-- Category Badge -->
                                <span class="category-badge">
                                    📂 {{ ucfirst($announcement->category) }}
                                </span>
                                
                                <!-- Title -->
                                <h3 class="announcement-title">{{ $announcement->title }}</h3>
                                
                                <!-- Content Preview -->
                                <p class="announcement-excerpt">
                                    {{ Str::limit(strip_tags($announcement->content), 120) }}
                                </p>
                                
                                <!-- Meta Information -->
                                <div class="announcement-meta">
                                    <div class="announcement-meta-item">
                                        <i class="fas fa-user text-primary"></i>
                                        <span>{{ $announcement->author }}</span>
                                        @if($announcement->user)
                                            <small class="text-muted">
                                                ({{ $announcement->user->hasRole('admin') ? 'Admin' : 'Guru' }})
                                            </small>
                                        @endif
                                    </div>
                                    <div class="announcement-meta-item">
                                        <i class="fas fa-calendar text-success"></i>
                                        <span>{{ $announcement->published_at ? $announcement->published_at->format('d M Y, H:i') : $announcement->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div class="announcement-meta-item">
                                        <i class="fas fa-eye text-info"></i>
                                        <span>{{ $announcement->views_count ?? 0 }} views</span>
                                    </div>
                                </div>
                                
                                <!-- Read More Button -->
                                <a href="{{ route('announcements.show', $announcement->id) }}" 
                                   class="btn-announcement btn-primary-announcement">
                                    <i class="fas fa-eye"></i>
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Enhanced Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $announcements->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Enhanced Empty State -->
            <div class="empty-state fade-in-up">
                <i class="fas fa-bullhorn empty-state-icon"></i>
                <h3>Tidak ada pengumuman ditemukan</h3>
                <p>
                    @if(request()->hasAny(['search', 'category', 'priority']))
                        Tidak ada pengumuman yang sesuai dengan filter yang dipilih.
                    @else
                        Belum ada pengumuman yang dipublikasikan saat ini.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'category', 'priority']))
                    <a href="{{ route('announcements.index') }}" class="btn btn-filter">
                        <i class="fas fa-refresh me-2"></i>
                        Lihat Semua Pengumuman
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
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
    
    // Enhanced card hover effects
    const announcementCards = document.querySelectorAll('.announcement-card');
    announcementCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
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
    
    // Page load animation sequence
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 100);
    
    console.log('Enhanced announcements page animations loaded successfully!');
});
</script>
@endsection