@extends('layouts.public')

@section('title', 'Berita Terbaru')

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

        /* Enhanced Hero Section matching home page */
        .hero-section {
            background: linear-gradient(135deg,
                    rgba(26, 32, 44, 0.8) 0%,
                    rgba(49, 130, 206, 0.7) 50%,
                    rgba(26, 32, 44, 0.8) 100%),
                url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
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

        .hero-content {
            position: relative;
            z-index: 2;
        }

        @keyframes float {
            0% {
                transform: translateX(-50px) translateY(-50px);
            }

            100% {
                transform: translateX(50px) translateY(50px);
            }
        }

        .news-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .news-card img {
            transition: transform 0.3s ease;
            height: 200px;
            object-fit: cover;
        }

        .news-card:hover img {
            transform: scale(1.05);
        }

        .featured-card {
            background: linear-gradient(45deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            overflow: hidden;
        }

        .featured-card img {
            height: 300px;
        }

        .badge-custom {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .sidebar-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .category-item {
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 1rem;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .category-item:hover {
            background: var(--primary-color) !important;
            color: white !important;
            transform: translateX(5px);
        }

        .popular-item {
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            border-left: 4px solid var(--accent-color);
        }

        .popular-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }

        .pagination-custom .page-link {
            border-radius: 10px;
            margin: 0 2px;
            border: none;
            color: var(--primary-color);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .pagination-custom .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: scale(1.1);
        }

        .pagination-custom .page-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-gradient {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        } */

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .priority-badge {
            font-size: 0.7rem;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .priority-tinggi {
            background: linear-gradient(45deg, #dc3545, #e74c3c);
            color: white;
        }

        .priority-sedang {
            background: linear-gradient(45deg, #ffc107, #f39c12);
            color: #333;
        }

        .priority-rendah {
            background: linear-gradient(45deg, #28a745, #2ecc71);
            color: white;
        }

        .news-meta {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .news-meta i {
            margin-right: 0.5rem;
            color: var(--secondary-color);
        }

        .news-excerpt {
            color: #6c757d;
            line-height: 1.6;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1 class="display-4 fw-bold mb-4 fade-in-left">Berita & Pengumuman SMK PGRI 2 PONOROGO</h1>
                        <p class="lead mb-4 fade-in-left">Informasi terkini seputar kegiatan, pengumuman penting, dan perkembangan sekolah yang perlu Anda ketahui.</p>
                        <div class="d-flex gap-3 fade-in-left flex-wrap">
                            <span class="badge bg-light text-dark fs-6">📢 Pengumuman Penting</span>
                            <span class="badge bg-light text-dark fs-6">🏆 Prestasi</span>
                            <span class="badge bg-light text-dark fs-6">📚 Akademik</span>
                            <span class="badge bg-light text-dark fs-6">🎯 Kegiatan</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-bullhorn scale-in" style="font-size: 8rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- News Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main News Content -->
                <div class="col-lg-8">
                    <!-- Search and Filter -->
                    <div class="sidebar-card mb-4 fade-in-up">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3"><i class="fas fa-search me-2 text-primary"></i>Cari Berita & Pengumuman</h5>
                            <form method="GET" action="{{ route('news.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="search" placeholder="Kata kunci..."
                                            value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="category" class="form-select">
                                            <option value="">Semua Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                    {{ ucfirst($category) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="priority" class="form-select">
                                            <option value="">Semua Prioritas</option>
                                            @foreach($priorities as $priority)
                                                <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                                                    {{ ucfirst($priority) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                   
                    <!-- News Posts Container -->
                    <div id="news-container" class="fade-in">
                        @if($announcements->count() > 0)
                            <!-- Featured Post (First Post) -->
                            @if($announcements->isNotEmpty())
                                @php $featured = $announcements->first(); @endphp
                                <article class="featured-card shadow mb-5 news-card fade-in-left">
                                    <div class="row g-0">
                                        <div class="col-md-5">
                                            @if($featured->gambar)
                                                <img src="{{ asset('storage/' . $featured->gambar) }}" class="img-fluid h-100"
                                                    alt="{{ $featured->judul }}">
                                            @else
                                                <img src="https://picsum.photos/400/300?random=1" class="img-fluid h-100"
                                                    alt="Featured News">
                                            @endif
                                        </div>
                                        <div class="col-md-7">
                                            <div class="card-body p-4">
                                                <div class="d-flex gap-2 mb-3">
                                                    <span class="badge badge-custom bg-primary">✨ Utama</span>
                                                    <span class="priority-badge priority-{{ $featured->prioritas ?? 'sedang' }}">
                                                        {{ ucfirst($featured->prioritas ?? 'sedang') }}
                                                    </span>
                                                </div>
                                                <h3 class="card-title fw-bold mb-3">{{ $featured->judul }}</h3>
                                                <p class="card-text news-excerpt">
                                                    {{ Str::limit(strip_tags($featured->isi), 200) }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-4">
                                                    <div class="news-meta">
                                                        <div class="mb-1">
                                                            <i class="fas fa-calendar"></i>
                                                            {{ $featured->tanggal_publikasi ? $featured->tanggal_publikasi->format('d M Y') : $featured->created_at->format('d M Y') }}
                                                        </div>
                                                        <div class="mb-1">
                                                            <i class="fas fa-user"></i>
                                                            {{ $featured->penulis ?? 'Admin' }}
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-folder"></i>
                                                            {{ ucfirst($featured->kategori) }}
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('announcements.show', $featured->slug ?? $featured->id) }}"
                                                        class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endif

                            <!-- News Posts Grid -->
                            <div class="row g-4" id="posts-grid">
                                @foreach($announcements->skip(1) as $announcement)
                                    <div class="col-md-6">
                                        <article class="news-card shadow h-100 fade-in-up">
                                            @if($announcement->gambar)
                                                <img src="{{ asset('storage/' . $announcement->gambar) }}" class="card-img-top"
                                                    alt="{{ $announcement->judul }}">
                                            @else
                                                <img src="https://picsum.photos/300/200?random={{ $loop->index + 2 }}"
                                                    class="card-img-top" alt="{{ $announcement->judul }}">
                                            @endif
                                            <div class="card-body p-4 d-flex flex-column">
                                                <div class="d-flex gap-2 mb-3">
                                                    @php
                                                        $categoryBadges = [
                                                            'akademik' => '<span class="badge badge-custom bg-info mb-0">📚 Akademik</span>',
                                                            'kegiatan' => '<span class="badge badge-custom bg-success mb-0">🎯 Kegiatan</span>',
                                                            'administrasi' => '<span class="badge badge-custom bg-warning text-dark mb-0">📋 Administrasi</span>',
                                                            'umum' => '<span class="badge badge-custom bg-secondary mb-0">📢 Umum</span>'
                                                        ];
                                                    @endphp
                                                    {!! $categoryBadges[$announcement->kategori] ?? '<span class="badge badge-custom bg-secondary mb-0">📢 Umum</span>' !!}
                                                    <span class="priority-badge priority-{{ $announcement->prioritas ?? 'sedang' }}">
                                                        {{ ucfirst($announcement->prioritas ?? 'sedang') }}
                                                    </span>
                                                </div>
                                                <h5 class="card-title fw-bold mb-3">{{ $announcement->judul }}</h5>
                                                <p class="card-text news-excerpt flex-grow-1">
                                                    {{ Str::limit(strip_tags($announcement->isi), 120) }}
                                                </p>
                                                <div class="mt-auto">
                                                    <div class="news-meta mb-3">
                                                        <div class="mb-1">
                                                            <i class="fas fa-calendar"></i>
                                                            {{ $announcement->tanggal_publikasi ? $announcement->tanggal_publikasi->format('d M Y') : $announcement->created_at->format('d M Y') }}
                                                        </div>
                                                        <div class="mb-1">
                                                            <i class="fas fa-user"></i>
                                                            {{ $announcement->penulis ?? 'Admin' }}
                                                        </div>
                                                        <div>
                                                            <i class="fas fa-eye"></i>
                                                            {{ $announcement->views ?? 0 }} views
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('announcements.show', $announcement->slug ?? $announcement->id) }}"
                                                        class="btn btn-outline-primary btn-sm w-100">Baca Selengkapnya</a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <nav aria-label="News pagination" class="mt-5">
                                {{ $announcements->appends(request()->query())->links() }}
                            </nav>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-bullhorn text-muted" style="font-size: 4rem;"></i>
                                <h4 class="mt-3 text-muted">Belum Ada Berita</h4>
                                <p class="text-muted">
                                    @if(request('search') || request('category') || request('priority'))
                                        Tidak ada berita yang sesuai dengan pencarian Anda.
                                    @else
                                        Belum ada berita yang dipublikasikan.
                                    @endif
                                </p>
                                @if(request('search') || request('category') || request('priority'))
                                    <a href="{{ route('news.index') }}" class="btn btn-primary">Lihat Semua Berita</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Statistics -->
                    <div class="stats-card fade-in-right">
                        <div class="stats-number">{{ $announcements->total() }}</div>
                        <div class="stats-label">Total Berita & Pengumuman</div>
                    </div>

                    <!-- Categories -->
                    @if($categories->count() > 0)
                        <div class="sidebar-card mb-4 fade-in-right">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Kategori</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column" id="categories">
                                    <a href="{{ route('news.index') }}"
                                        class="category-item bg-light text-dark {{ !request('category') ? 'bg-primary text-white' : '' }}">
                                        <span>Semua Kategori</span>
                                        <span class="badge bg-primary">{{ $announcements->total() }}</span>
                                    </a>
                                    @foreach($categories as $category)
                                        <a href="{{ route('news.index', ['category' => $category]) }}"
                                            class="category-item bg-light text-dark {{ request('category') == $category ? 'bg-primary text-white' : '' }}">
                                            <span>{{ ucfirst($category) }}</span>
                                            <span class="badge bg-primary">{{ \App\Models\Announcement::published()->where('kategori', $category)->count() }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Priorities -->
                    @if($priorities->count() > 0)
                        <div class="sidebar-card mb-4 fade-in-right">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Prioritas</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column">
                                    @foreach($priorities as $priority)
                                        <a href="{{ route('news.index', ['priority' => $priority]) }}"
                                            class="category-item bg-light text-dark {{ request('priority') == $priority ? 'bg-warning text-dark' : '' }}">
                                            <span>{{ ucfirst($priority) }}</span>
                                            <span class="badge bg-warning text-dark">{{ \App\Models\Announcement::published()->where('prioritas', $priority)->count() }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Latest Posts -->
                    @if($latestAnnouncements->count() > 0)
                        <div class="sidebar-card mb-4 fade-in-right">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <div id="latest-posts">
                                    @foreach($latestAnnouncements as $latest)
                                        <div class="popular-item">
                                            <h6 class="mb-2">
                                                <a href="{{ route('announcements.show', $latest->slug ?? $latest->id) }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ Str::limit($latest->judul, 60) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $latest->tanggal_publikasi ? $latest->tanggal_publikasi->format('d M Y') : $latest->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Archive -->
                    <div class="sidebar-card fade-in-right">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-archive me-2"></i>Arsip</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0">Fitur arsip akan segera tersedia untuk memudahkan pencarian berita
                                berdasarkan tanggal publikasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection