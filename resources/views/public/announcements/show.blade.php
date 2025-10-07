@extends('layouts.public')

@section('title', $announcement->judul)

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

        i,
        svg {
            width: 18px;
            height: 18px;
            font-size: 16px;
            vertical-align: middle;
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

        /* Breadcrumb */
        .breadcrumb-section {
            background: var(--light-gray);
            padding: 2rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
            font-size: 0.875rem;
        }

        .breadcrumb-item a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-color);
        }

        .breadcrumb-item.active {
            color: var(--dark-gray);
        }

        /* Main Content */
        .announcement-detail {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .announcement-header {
            position: relative;
            padding: 3rem 2rem 2rem;
            background: var(--gradient-light);
        }

        .priority-badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-size: 0.875rem;
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
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .announcement-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            padding: 1.5rem 0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 2rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            color: var(--dark-gray);
        }

        .meta-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .author-avatar {
            background: var(--gradient-primary);
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .featured-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .announcement-content {
            padding: 2rem;
            font-size: 1.1rem;
            line-height: 1.8;
            color: #2d3748;
        }

        .announcement-content p {
            margin-bottom: 1.5rem;
        }

        .announcement-content strong {
            color: var(--primary-color);
            font-weight: 600;
        }

        .content-text {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .content-text h1, .content-text h2, .content-text h3, .content-text h4, .content-text h5, .content-text h6 {
            color: var(--primary-color);
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .content-text ul, .content-text ol {
            margin: 1rem 0;
            padding-left: 2rem;
        }

        .content-text li {
            margin-bottom: 0.5rem;
        }

        .content-text blockquote {
            border-left: 4px solid var(--secondary-color);
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            background: var(--light-gray);
            padding: 1rem;
            border-radius: 0 8px 8px 0;
        }

        /* Share Section */
        .share-section {
            background: var(--light-gray);
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
        }

        .share-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .share-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .share-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .share-facebook {
            background: #1877f2;
            color: white;
        }

        .share-twitter {
            background: #1da1f2;
            color: white;
        }

        .share-whatsapp {
            background: #25d366;
            color: white;
        }

        .share-copy {
            background: #6c757d;
            color: white;
        }

        .share-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            color: white;
            text-decoration: none;
        }

        /* Sidebar */
        .sidebar-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .sidebar-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-header .badge {
            font-size: 0.75rem;
        }

        .sidebar-content {
            padding: 1.5rem;
        }

        .related-item {
            padding: 1.25rem 0;
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .related-item:last-child {
            border-bottom: none;
        }

        .related-item:hover {
            background: var(--light-gray);
            margin: 0 -1.5rem;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            border-radius: 10px;
            transform: translateX(5px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }

        .related-item:active {
            transform: translateX(3px);
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .related-item:hover::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: var(--secondary-color);
            border-radius: 2px;
        }

        .related-title {
            font-weight: 600;
            color: var(--primary-color);
            text-decoration: none;
            display: block;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            font-size: 0.95rem;
        }

        .related-title:hover {
            color: var(--secondary-color);
            text-decoration: none;
        }

        .related-meta {
            font-size: 0.75rem;
            color: var(--dark-gray);
            line-height: 1.5;
        }

        .related-meta .text-primary {
            font-weight: 500;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .related-item .priority-indicator {
            position: absolute;
            top: 1rem;
            right: 0;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .priority-tinggi {
            background: #ef4444;
        }

        .priority-sedang {
            background: #10b981;
        }

        .priority-rendah {
            background: #6b7280;
        }

        .back-btn {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
            border: none;
            cursor: pointer;
            width: 100%;
            justify-content: center;
        }

        .back-btn:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(49, 130, 206, 0.4);
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .announcement-title {
                font-size: 2rem;
            }

            .announcement-header {
                padding: 2rem 1.5rem 1.5rem;
            }

            .announcement-content {
                padding: 1.5rem;
            }

            .announcement-meta {
                flex-direction: column;
                gap: 1rem;
            }

            .share-buttons {
                flex-direction: column;
            }

            .share-btn {
                justify-content: center;
            }

            .featured-image {
                height: 250px;
            }
        }
    </style>

    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Pengumuman</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($announcement->judul, 50) }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <article class="announcement-detail fade-in-up">
                        <!-- Header -->
                        <div class="announcement-header">
                            <!-- Priority Badge -->
                            <div class="priority-badge priority-{{ $announcement->english_priority ?? 'normal' }}">
                                @if($announcement->prioritas === 'tinggi') ⚠️ Prioritas Tinggi
                                @elseif($announcement->prioritas === 'sedang') ✅ Normal
                                @else 📝 Prioritas Rendah
                                @endif
                            </div>

                            <!-- Category Badge -->
                            <span class="category-badge">
                                📂 {{ ucfirst($announcement->kategori) }}
                            </span>

                            <!-- Title -->
                            <h1 class="announcement-title">{{ $announcement->judul }}</h1>

                            <!-- Meta Information -->
                            <div class="announcement-meta">
                                <div class="meta-item">
                                    <div class="meta-icon author-avatar">
                                        {{ substr($announcement->penulis ?? 'Admin', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $announcement->penulis ?? 'Administrator' }}</div>
                                        <div class="text-muted">
                                            @if($announcement->user)
                                                {{ $announcement->user->hasRole('admin') ? 'Administrator' : 'Guru' }}
                                            @else
                                                Penulis
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="meta-item">
                                    <div class="meta-icon bg-success text-white">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Dipublikasikan</div>
                                        <div>
                                            {{ $announcement->tanggal_publikasi ? $announcement->tanggal_publikasi->format('d F Y, H:i') : $announcement->created_at->format('d F Y, H:i') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="meta-item">
                                    <div class="meta-icon bg-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Views</div>
                                        <div>{{ $announcement->views_count ?? 0 }} kali dilihat</div>
                                    </div>
                                </div>

                                @if($announcement->expires_at)
                                    <div class="meta-item">
                                        <div class="meta-icon bg-warning text-white">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Berlaku hingga</div>
                                            <div>{{ $announcement->expires_at->format('d F Y, H:i') }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="announcement-content">
                            <!-- Featured Image -->
                            @if($announcement->gambar)
                                <img src="{{ asset('storage/' . $announcement->gambar) }}"
                                    alt="{{ $announcement->judul }}" class="featured-image">
                            @endif

                            <!-- Content -->
                            <div class="content-text">
                                {!! nl2br($announcement->isi) !!}
                            </div>
                        </div>

                        <!-- Share Section -->
                        <div class="share-section">
                            <h3 class="share-title">Bagikan Pengumuman Ini:</h3>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                    target="_blank" class="share-btn share-facebook">
                                    <i class="fab fa-facebook-f"></i>
                                    Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($announcement->judul) }}"
                                    target="_blank" class="share-btn share-twitter">
                                    <i class="fab fa-twitter"></i>
                                    Twitter
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($announcement->judul . ' - ' . request()->fullUrl()) }}"
                                    target="_blank" class="share-btn share-whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                    WhatsApp
                                </a>
                                <button onclick="copyToClipboard()" class="share-btn share-copy">
                                    <i class="fas fa-link"></i>
                                    Copy Link
                                </button>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Related Announcements -->
                    <div class="sidebar-card fade-in-right">
                        <div class="sidebar-header">
                            <i class="fas fa-bullhorn me-2"></i>
                            Pengumuman Terkait
                            @if($relatedAnnouncements->count() > 0)
                                <span class="badge bg-light text-dark ms-2">{{ $relatedAnnouncements->count() }}</span>
                            @endif
                        </div>
                        <div class="sidebar-content">
                            @if($relatedAnnouncements->count() > 0)
                                @foreach($relatedAnnouncements as $related)
                                    <div class="related-item" onclick="window.location.href='{{ route('announcements.show', $related->id) }}'">
                                        <div class="priority-indicator priority-{{ $related->prioritas }}"></div>
                                        <a href="{{ route('announcements.show', $related->id) }}" class="related-title">
                                            {{ Str::limit($related->judul, 80) }}
                                        </a>
                                        <div class="related-meta">
                                            <div class="mb-1">
                                                <i class="fas fa-user me-1"></i>
                                                {{ $related->penulis ?? 'Admin' }} •
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $related->tanggal_publikasi ? $related->tanggal_publikasi->format('d M Y') : $related->created_at->format('d M Y') }}
                                            </div>
                                            <div>
                                                <i class="fas fa-tag me-1"></i>
                                                <span class="text-primary">{{ ucfirst($related->kategori) }}</span> •
                                                <i class="fas fa-eye me-1"></i>
                                                {{ $related->views ?? 0 }} views •
                                                <i class="fas fa-flag me-1"></i>
                                                <span class="text-{{ $related->prioritas === 'tinggi' ? 'danger' : ($related->prioritas === 'sedang' ? 'success' : 'secondary') }}">
                                                    {{ ucfirst($related->prioritas) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <!-- View All Related Button -->
                                <div class="mt-3 pt-3 border-top">
                                    <a href="{{ route('announcements.index', ['category' => $announcement->kategori]) }}" 
                                       class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-list me-1"></i>
                                        Lihat Semua Pengumuman {{ ucfirst($announcement->kategori) }}
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-info-circle text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-3">Belum ada pengumuman terkait lainnya.</p>
                                    <a href="{{ route('announcements.index') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-list me-1"></i>
                                        Lihat Semua Pengumuman
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Back to Announcements -->
                    <div class="sidebar-card fade-in-right" style="animation-delay: 0.2s;">
                        <div class="sidebar-content">
                            <a href="{{ route('announcements.index') }}" class="back-btn">
                                <i class="fas fa-arrow-left"></i>
                                Kembali ke Semua Pengumuman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Enhanced Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function (entries) {
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

            // Enhanced related announcements clickability
            document.querySelectorAll('.related-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    // Prevent double navigation if clicking on the link directly
                    if (e.target.tagName === 'A') {
                        return;
                    }
                    
                    const link = this.querySelector('.related-title');
                    if (link) {
                        window.location.href = link.href;
                    }
                });
                
                // Add visual feedback
                item.addEventListener('mouseenter', function() {
                    this.style.cursor = 'pointer';
                });
            });

            console.log('Enhanced announcement detail page loaded successfully!');
        });

        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(function () {
                // Show success message
                const button = event.target.closest('.share-btn');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
                button.style.background = '#10b981';

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.style.background = '#6c757d';
                }, 2000);
            }, function (err) {
                console.error('Could not copy text: ', err);
                // Fallback for older browsers
                const textArea = document.createElement("textarea");
                textArea.value = window.location.href;
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    const button = event.target.closest('.share-btn');
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
                    button.style.background = '#10b981';

                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.style.background = '#6c757d';
                    }, 2000);
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textArea);
            });
        }
    </script>
@endsection