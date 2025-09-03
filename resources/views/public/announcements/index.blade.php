
@extends('layouts.public')

@section('title', 'Profil Sekolah')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - SMA Negeri 1 Balong</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            margin: 0;
            padding: 0;
        }

        /* Header Section */
        .header-section {
            background: var(--gradient-primary);
            color: white;
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }
        
        .header-section::before {
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
        
        .header-section .container {
            position: relative;
            z-index: 2;
        }
        
        .header-section h1 {
            font-size: 3rem;
            font-weight: 800;
            text-shadow: 0 4px 8px rgba(0,0,0,0.2);
            margin-bottom: 1rem;
        }
        
        .header-section .lead {
            font-size: 1.2rem;
            opacity: 0.95;
            font-weight: 400;
        }

        .breadcrumb-nav {
            background: rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 10px 20px;
            backdrop-filter: blur(10px);
            display: inline-flex;
            margin-top: 20px;
        }

        .breadcrumb-nav a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb-nav a:hover {
            color: white;
        }

        .breadcrumb-nav span {
            color: rgba(255,255,255,0.6);
            margin: 0 10px;
        }

        /* Filter and Search Section */
        .filter-section {
            background: white;
            padding: 40px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            position: relative;
            z-index: 10;
        }

        .search-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            border: 2px solid rgba(49, 130, 206, 0.1);
            padding: 12px 20px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .search-box:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 8px 30px rgba(49, 130, 206, 0.2);
            transform: translateY(-2px);
        }

        .filter-btn {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 15px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
        }

        .filter-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
            background: linear-gradient(135deg, #2d3748, #2b6cb0);
            color: white;
        }

        .filter-tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .filter-tab {
            padding: 8px 20px;
            background: rgba(49, 130, 206, 0.1);
            border: none;
            border-radius: 25px;
            color: var(--secondary-color);
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-tab.active,
        .filter-tab:hover {
            background: var(--gradient-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(49, 130, 206, 0.3);
        }

        /* Announcement Cards */
        .announcements-section {
            padding: 60px 0;
        }

        .announcement-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 30px;
            position: relative;
        }

        .announcement-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .announcement-card:hover::before {
            transform: scaleX(1);
        }

        .announcement-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.15);
        }

        .announcement-header {
            padding: 25px 30px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .announcement-category {
            background: var(--gradient-primary);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .announcement-date {
            color: var(--dark-gray);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .announcement-body {
            padding: 20px 30px 30px;
        }

        .announcement-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .announcement-content {
            color: var(--dark-gray);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .announcement-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .announcement-author {
            display: flex;
            align-items: center;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .announcement-author i {
            margin-right: 8px;
            color: var(--secondary-color);
        }

        .announcement-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-read {
            background: rgba(49, 130, 206, 0.1);
            color: var(--secondary-color);
        }

        .btn-read:hover {
            background: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-share {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .btn-share:hover {
            background: #10b981;
            color: white;
            transform: translateY(-2px);
        }

        /* Priority Badges */
        .priority-high {
            background: linear-gradient(135deg, #dc2626, #ef4444) !important;
        }

        .priority-medium {
            background: linear-gradient(135deg, #d97706, #f59e0b) !important;
        }

        .priority-normal {
            background: linear-gradient(135deg, #059669, #10b981) !important;
        }

        /* Sidebar */
        .sidebar-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        }

        .sidebar-card .card-header {
            padding: 20px;
            font-weight: 600;
            border: none;
            position: relative;
        }

        .sidebar-card .card-body {
            padding: 25px;
        }

        /* Pagination */
        .pagination-wrapper {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-top: 30px;
            text-align: center;
        }

        .pagination .page-link {
            border: none;
            padding: 12px 18px;
            margin: 0 5px;
            border-radius: 10px;
            color: var(--secondary-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background: var(--gradient-primary);
            box-shadow: 0 5px 15px rgba(49, 130, 206, 0.3);
        }

        .pagination .page-link:hover {
            background: rgba(49, 130, 206, 0.1);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-section {
                padding: 60px 0 40px;
                text-align: center;
            }
            
            .header-section h1 {
                font-size: 2.5rem;
            }
            
            .filter-tabs {
                justify-content: center;
            }
            
            .announcement-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .announcement-meta {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        /* Animation Classes */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .announcement-card:nth-child(1) { animation-delay: 0.1s; }
        .announcement-card:nth-child(2) { animation-delay: 0.2s; }
        .announcement-card:nth-child(3) { animation-delay: 0.3s; }
        .announcement-card:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Header Section -->
    <section class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1><i class="fas fa-bullhorn me-3"></i>Pengumuman</h1>
                    <p class="lead">Informasi penting dan terkini untuk seluruh civitas akademika SMA Negeri 1 Balong</p>
                    <nav class="breadcrumb-nav">
                        <a href="#"><i class="fas fa-home me-2"></i>Beranda</a>
                        <span>/</span>
                        <span>Pengumuman</span>
                    </nav>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-megaphone" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

   <!-- Filter Section -->
<section class="filter-section">
    <div class="container">
        <form method="GET" action="{{ route('announcements.index') }}" id="filterForm">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control search-box" name="search" 
                               placeholder="Cari announcements..." id="searchInput" 
                               value="{{ request('search') }}">
                        <button class="btn filter-btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="filter-tabs">
                        <button type="button" class="filter-tab {{ request('category', 'all') == 'all' ? 'active' : '' }}" 
                                onclick="setCategory('all')">
                            <i class="fas fa-list me-2"></i>Semua
                        </button>
                        <button type="button" class="filter-tab {{ request('category') == 'akademik' ? 'active' : '' }}" 
                                onclick="setCategory('akademik')">
                            <i class="fas fa-graduation-cap me-2"></i>Akademik
                        </button>
                        <button type="button" class="filter-tab {{ request('category') == 'kegiatan' ? 'active' : '' }}" 
                                onclick="setCategory('kegiatan')">
                            <i class="fas fa-calendar-alt me-2"></i>Kegiatan
                        </button>
                        <button type="button" class="filter-tab {{ request('category') == 'administrasi' ? 'active' : '' }}" 
                                onclick="setCategory('administrasi')">
                            <i class="fas fa-file-alt me-2"></i>Administrasi
                        </button>
                    </div>
                    <input type="hidden" name="category" id="categoryInput" value="{{ request('category', 'all') }}">
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Announcements Section -->
<section class="announcements-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($announcements->count() > 0)
                    @foreach($announcements as $index => $announcement)
                        <div class="announcement-card fade-in-up" data-category="{{ $announcement->kategori }}">
                            <div class="announcement-header">
                                <span class="announcement-category {{ $announcement->prioritas == 'tinggi' ? 'priority-high' : ($announcement->prioritas == 'sedang' ? 'priority-medium' : 'priority-normal') }}">
                                    {{ ucfirst($announcement->prioritas == 'tinggi' ? 'Penting' : ($announcement->prioritas == 'sedang' ? ucfirst($announcement->kategori) : 'Normal')) }}
                                </span>
                                <div class="announcement-date">
                                    <i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($announcement->created_at)->format('d F Y') }}
                                </div>
                            </div>
                            <div class="announcement-body">
                                <h3 class="announcement-title">{{ $announcement->judul }}</h3>
                                <div class="announcement-content">
                                    {{ Str::limit(strip_tags($announcement->isi), 200) }}
                                </div>
                                <div class="announcement-meta">
                                    <div class="announcement-author">
                                        <i class="fas fa-user"></i>
                                        {{ $announcement->penulis ?? 'Administrator' }}
                                    </div>
                                    <div class="announcement-actions">
                                        <a href="{{ route('announcements.show', $announcement->id) }}" class="btn-action btn-read">
                                            <i class="fas fa-eye"></i>Baca Selengkapnya
                                        </a>
                                        <a href="#" class="btn-action btn-share" 
                                           data-title="{{ $announcement->judul }}" 
                                           data-url="{{ route('announcements.show', $announcement->id) }}">
                                            <i class="fas fa-share"></i>Bagikan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $announcements->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Tidak ada announcements yang ditemukan.
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Announcements Terpopuler -->
                <div class="sidebar-card">
                    <div class="card-header" style="background: var(--gradient-primary); color: white;">
                        <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Announcements Terpopuler</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($popularAnnouncements as $popular)
                                <a href="{{ route('announcements.show', $popular->id) }}" 
                                   class="list-group-item list-group-item-action border-0 px-0">
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($popular->created_at)->format('d F Y') }}</small>
                                    <h6 class="mb-1">{{ Str::limit($popular->judul, 50) }}</h6>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Kategori Announcements -->
                <div class="sidebar-card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Kategori</h5>
                    </div>
                    <div class="card-body">
                        @foreach($kategoriCounts as $kategori => $count)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a href="{{ route('announcements.index', ['category' => $kategori]) }}" 
                                   class="text-decoration-none">
                                    <span>{{ ucfirst($kategori) }}</span>
                                </a>
                                <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Arsip Announcements -->
                <div class="sidebar-card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-archive me-2"></i>Arsip</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select mb-3" onchange="filterByMonth(this.value)">
                            <option value="">Pilih Bulan</option>
                            @foreach($availableMonths as $month)
                                <option value="{{ $month['value'] }}" 
                                        {{ request('month') == $month['value'] ? 'selected' : '' }}>
                                    {{ $month['text'] }}
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-list me-2"></i>Lihat Semua
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="sidebar-card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-link me-2"></i>Quick Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ url('/') }}" class="btn btn-outline-primary">
                                <i class="fas fa-home me-2"></i>Beranda
                            </a>
                            <a href="{{ url('/berita') }}" class="btn btn-outline-success">
                                <i class="fas fa-newspaper me-2"></i>Berita
                            </a>
                            <a href="{{ url('/agenda') }}" class="btn btn-outline-info">
                                <i class="fas fa-calendar me-2"></i>Agenda
                            </a>
                            <a href="{{ url('/download') }}" class="btn btn-outline-warning">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    @endsection

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const announcementCards = document.querySelectorAll('.announcement-card');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                announcementCards.forEach(card => {
                    const title = card.querySelector('.announcement-title').textContent.toLowerCase();
                    const content = card.querySelector('.announcement-content').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || content.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Filter functionality
            const filterTabs = document.querySelectorAll('.filter-tab');
            
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    filterTabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    const category = this.dataset.category;
                    
                    announcementCards.forEach(card => {
                        if (category === 'all' || card.dataset.category === category) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationDelay = entry.target.dataset.delay || '0s';
                        entry.target.classList.add('fade-in-up');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            // Observe elements for animation
            document.querySelectorAll('.announcement-card').forEach((el, index) => {
                el.dataset.delay = (index * 0.1) + 's';
                observer.observe(el);
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

            // Share functionality
            document.querySelectorAll('.btn-share').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const card = this.closest('.announcement-card');
                    const title = card.querySelector('.announcement-title').textContent;
                    const url = window.location.href;
                    
                    if (navigator.share) {
                        navigator.share({
                            title: title,
                            text: 'Pengumuman dari SMA Negeri 1 Balong',
                            url: url
                        });
                    } else {
                        // Fallback untuk browser yang tidak support Web Share API
                        const shareText = `${title} - ${url}`;
                        navigator.clipboard.writeText(shareText).then(() => {
                            // Show temporary notification
                            const originalText = this.innerHTML;
                            this.innerHTML = '<i class="fas fa-check"></i>Tersalin';
                            this.style.background = '#10b981';
                            this.style.color = 'white';
                            
                            setTimeout(() => {
                                this.innerHTML = originalText;
                                this.style.background = '';
                                this.style.color = '';
                            }, 2000);
                        });
                    }
                });
            });
            
            // Pengumuman
                        function setCategory(category) {
                document.getElementById('categoryInput').value = category;
                document.getElementById('filterForm').submit();
            }

            function filterByMonth(month) {
                const form = document.getElementById('filterForm');
                const monthInput = document.createElement('input');
                monthInput.type = 'hidden';
                monthInput.name = 'month';
                monthInput.value = month;
                form.appendChild(monthInput);
                form.submit();
            }

            // Update share functionality
            document.querySelectorAll('.btn-share').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const title = this.dataset.title;
                    const url = this.dataset.url;
                    
                    if (navigator.share) {
                        navigator.share({
                            title: title,
                            text: 'Announcements dari SMA Negeri 1 Balong',
                            url: url
                        });
                    } else {
                        // Fallback untuk browser yang tidak support Web Share API
                        const shareText = `${title} - ${window.location.origin}${url}`;
                        navigator.clipboard.writeText(shareText).then(() => {
                            // Show temporary notification
                            const originalText = this.innerHTML;
                            this.innerHTML = '<i class="fas fa-check"></i>Tersalin';
                            this.style.background = '#10b981';
                            this.style.color = 'white';
                            
                            setTimeout(() => {
                                this.innerHTML = originalText;
                                this.style.background = '';
                                this.style.color = '';
                            }, 2000);
                        });
                    }
                });
            });

            // Add hover effects to cards
            document.querySelectorAll('.announcement-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Archive functionality
            document.querySelector('select.form-select').addEventListener('change', function() {
                const selectedMonth = this.value;
                // Here you would typically filter announcements by month
                console.log('Filtering by month:', selectedMonth);
            });

            // Add loading animation to read more buttons
            document.querySelectorAll('.btn-read').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Memuat...';
                    
                    // Simulate loading
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        // Here you would typically navigate to the full article
                    }, 1000);
                });
            });

            // Responsive search behavior
            function handleResize() {
                if (window.innerWidth <= 768) {
                    searchInput.placeholder = "Cari...";
                } else {
                    searchInput.placeholder = "Cari pengumuman...";
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Call once on load

            // Auto-hide notifications after some time
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });

        // Add some dynamic content loading simulation
        function loadMoreAnnouncements() {
            // This would typically make an AJAX request
            console.log('Loading more announcements...');
        }

        // Scroll to top functionality
        window.addEventListener('scroll', function() {
            const scrollButton = document.getElementById('scrollToTop');
            if (!scrollButton) {
                // Create scroll to top button dynamically
                const btn = document.createElement('button');
                btn.id = 'scrollToTop';
                btn.innerHTML = '<i class="fas fa-chevron-up"></i>';
                btn.style.cssText = `
                    position: fixed;
                    bottom: 30px;
                    right: 30px;
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    background: var(--gradient-primary);
                    color: white;
                    border: none;
                    cursor: pointer;
                    z-index: 1000;
                    transition: all 0.3s ease;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                    display: none;
                `;
                
                btn.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
                
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                    this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.3)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
                });
                
                document.body.appendChild(btn);
            }
            
            const scrollButton = document.getElementById('scrollToTop');
            if (window.pageYOffset > 300) {
                scrollButton.style.display = 'block';
            } else {
                scrollButton.style.display = 'none';
            }
        });
    </script>
</body>
</html>