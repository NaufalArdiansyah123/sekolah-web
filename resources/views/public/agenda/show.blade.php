@extends('layouts.public')

@section('title', $agenda->title)

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

        /* Agenda Detail Section */
        .agenda-detail-section {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            padding: 2rem 0;
        }

        .agenda-detail-container {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            position: relative;
        }

        .agenda-header {
            background: var(--gradient-primary);
            color: white;
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .agenda-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            z-index: 1;
        }

        .agenda-header .container {
            position: relative;
            z-index: 2;
        }

        .agenda-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .agenda-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .meta-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .meta-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .meta-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .meta-label {
            font-size: 0.875rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .agenda-content-section {
            padding: 3rem 2rem;
        }

        .agenda-content {
            color: #4a5568;
            line-height: 1.8;
            font-size: 1.1rem;
            max-width: none;
        }

        .agenda-content h1,
        .agenda-content h2,
        .agenda-content h3,
        .agenda-content h4,
        .agenda-content h5,
        .agenda-content h6 {
            color: var(--primary-color);
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .agenda-content h1 {
            font-size: 2rem;
        }

        .agenda-content h2 {
            font-size: 1.75rem;
        }

        .agenda-content h3 {
            font-size: 1.5rem;
        }

        .agenda-content h4 {
            font-size: 1.25rem;
        }

        .agenda-content p {
            margin-bottom: 1.5rem;
        }

        .agenda-content ul,
        .agenda-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .agenda-content li {
            margin-bottom: 0.75rem;
        }

        .agenda-content blockquote {
            border-left: 4px solid var(--accent-color);
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: var(--dark-gray);
            background: rgba(49, 130, 206, 0.05);
            padding: 1.5rem;
            border-radius: 8px;
        }

        .agenda-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 2rem 0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .status-upcoming {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-today {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .status-past {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
            border: 1px solid rgba(107, 114, 128, 0.2);
        }

        /* Action Buttons */
        .agenda-actions {
            background: var(--light-gray);
            padding: 2rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-agenda-action {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-primary-action {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
        }

        .btn-primary-action:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
            text-decoration: none;
        }

        .btn-secondary-action {
            background: white;
            color: var(--primary-color);
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary-action:hover {
            background: #f8fafc;
            color: var(--primary-color);
            transform: translateY(-2px);
            text-decoration: none;
        }

        /* Related Agenda Section */
        .related-agenda-section {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            padding: 3rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            position: relative;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
            border-radius: 2px;
        }

        .related-agenda-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            height: 100%;
        }

        .related-agenda-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .related-agenda-date {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
        }

        .related-agenda-content {
            padding: 1.5rem;
        }

        .related-agenda-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-agenda-meta {
            font-size: 0.85rem;
            color: var(--dark-gray);
            margin-bottom: 1rem;
        }

        .related-agenda-link {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .related-agenda-link:hover {
            color: var(--accent-color);
            text-decoration: none;
        }

        /* Breadcrumb */
        .breadcrumb-section {
            background: white;
            padding: 1rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--secondary-color);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--accent-color);
        }

        .breadcrumb-item.active {
            color: var(--dark-gray);
        }

        /* Animation Classes */
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
            .agenda-title {
                font-size: 2rem;
            }

            .agenda-meta-grid {
                grid-template-columns: 1fr;
            }

            .agenda-header {
                padding: 2rem 1.5rem;
            }

            .agenda-content-section {
                padding: 2rem 1.5rem;
            }

            .agenda-actions {
                flex-direction: column;
                padding: 1.5rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .agenda-title {
                font-size: 1.75rem;
            }

            .agenda-content {
                font-size: 1rem;
            }
        }
    </style>

    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $agenda->title }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Agenda Detail Section -->
    <section class="agenda-detail-section">
        <div class="container">
            <div class="agenda-detail-container fade-in-up">
                <!-- Header -->
                <div class="agenda-header">
                    <div class="container">
                        <h1 class="agenda-title">{{ $agenda->title }}</h1>

                        <!-- Status Badge -->
                        @if($agenda->event_date)
                            @if($agenda->event_date->isToday())
                                <span class="status-badge status-today">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Agenda Hari Ini
                                </span>
                            @elseif($agenda->event_date->isFuture())
                                <span class="status-badge status-upcoming">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Agenda Mendatang
                                </span>
                            @else
                                <span class="status-badge status-past">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Agenda Sudah Lewat
                                </span>
                            @endif
                        @endif

                        <!-- Meta Information -->
                        <div class="agenda-meta-grid">
                            @if($agenda->event_date)
                                <div class="meta-card">
                                    <div class="meta-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="meta-label">Tanggal & Waktu</div>
                                    <div class="meta-value">
                                        {{ $agenda->event_date->format('l, d F Y') }}<br>
                                        <small>{{ $agenda->event_date->format('H:i') }} WIB</small>
                                    </div>
                                </div>
                            @endif

                            @if($agenda->location)
                                <div class="meta-card">
                                    <div class="meta-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="meta-label">Lokasi</div>
                                    <div class="meta-value">{{ $agenda->location }}</div>
                                </div>
                            @endif

                            @if($agenda->event_date)
                                <div class="meta-card">
                                    <div class="meta-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="meta-label">Countdown</div>
                                    <div class="meta-value">
                                        @if($agenda->event_date->isPast())
                                            {{ $agenda->event_date->diffForHumans() }}
                                        @else
                                            {{ $agenda->event_date->diffForHumans() }}
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="meta-card">
                                <div class="meta-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="meta-label">Diposting Oleh</div>
                                <div class="meta-value">{{ $agenda->user->name ?? 'Admin' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="agenda-content-section">
                    <div class="agenda-content">
                        {!! $agenda->content !!}
                    </div>
                </div>

                <!-- Actions -->
                <div class="agenda-actions">
                    <a href="{{ route('agenda.index') }}" class="btn-agenda-action btn-secondary-action">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Agenda
                    </a>

                    <button onclick="shareAgenda()" class="btn-agenda-action btn-primary-action">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                            </path>
                        </svg>
                        Bagikan Agenda
                    </button>

                    @if($agenda->event_date && $agenda->event_date->isFuture())
                        <button onclick="addToCalendar()" class="btn-agenda-action btn-secondary-action">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Tambah ke Kalender
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Related Agenda Section -->
    @if($relatedAgendas->count() > 0)
        <section class="related-agenda-section">
            <div class="container">
                <div class="section-title">
                    <h2 class="fade-in-up">Agenda Terkait</h2>
                    <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">
                        Agenda lainnya yang mungkin menarik untuk Anda
                    </p>
                </div>

                <div class="row g-4">
                    @foreach($relatedAgendas as $index => $relatedAgenda)
                        <div class="col-lg-4 col-md-6">
                            <div class="related-agenda-card fade-in-up" style="animation-delay: {{ $index * 0.2 }}s;">
                                <div class="related-agenda-date">
                                    {{ $relatedAgenda->event_date ? $relatedAgenda->event_date->format('d M Y') : 'TBD' }}
                                </div>

                                <div class="related-agenda-content">
                                    <h4 class="related-agenda-title">{{ $relatedAgenda->title }}</h4>
                                    <div class="related-agenda-meta">
                                        @if($relatedAgenda->event_date)
                                            <i class="fas fa-clock me-1"></i> {{ $relatedAgenda->event_date->format('H:i') }} WIB
                                        @endif
                                        @if($relatedAgenda->location)
                                            • <i class="fas fa-map-marker-alt me-1"></i> {{ $relatedAgenda->location }}
                                        @endif
                                    </div>
                                    <a href="{{ route('agenda.show', $relatedAgenda->id) }}" class="related-agenda-link">
                                        <i class="fas fa-arrow-right me-1"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('agenda.index') }}" class="btn-agenda-action btn-primary-action">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Lihat Semua Agenda
                    </a>
                </div>
            </div>
        </section>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .scale-in');
            animatedElements.forEach(element => {
                observer.observe(element);
            });

            // Enhanced card hover effects
            const cards = document.querySelectorAll('.related-agenda-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-8px)';
                });

                card.addEventListener('mouseleave', function () {
                    this.style.transform = '';
                });
            });

            console.log('Agenda detail page loaded successfully!');
        });

        // Share agenda function
        function shareAgenda() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $agenda->title }}',
                    text: 'Lihat agenda ini: {{ $agenda->title }}',
                    url: window.location.href
                }).then(() => {
                    console.log('Agenda shared successfully');
                }).catch((error) => {
                    console.log('Error sharing agenda:', error);
                    fallbackShare();
                });
            } else {
                fallbackShare();
            }
        }

        function fallbackShare() {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent('{{ $agenda->title }}');

            const shareOptions = [
                {
                    name: 'WhatsApp',
                    url: `https://wa.me/?text=${title}%20${url}`,
                    icon: 'fab fa-whatsapp',
                    color: '#25D366'
                },
                {
                    name: 'Facebook',
                    url: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
                    icon: 'fab fa-facebook',
                    color: '#1877F2'
                },
                {
                    name: 'Twitter',
                    url: `https://twitter.com/intent/tweet?text=${title}&url=${url}`,
                    icon: 'fab fa-twitter',
                    color: '#1DA1F2'
                },
                {
                    name: 'Copy Link',
                    action: 'copy',
                    icon: 'fas fa-copy',
                    color: '#6c757d'
                }
            ];

            let shareHtml = '<div class="share-options">';
            shareOptions.forEach(option => {
                if (option.action === 'copy') {
                    shareHtml += `
                    <button onclick="copyToClipboard('${window.location.href}')" 
                            class="btn btn-outline-secondary btn-sm me-2 mb-2">
                        <i class="${option.icon} me-1"></i> ${option.name}
                    </button>
                `;
                } else {
                    shareHtml += `
                    <a href="${option.url}" target="_blank" 
                       class="btn btn-outline-secondary btn-sm me-2 mb-2">
                        <i class="${option.icon} me-1"></i> ${option.name}
                    </a>
                `;
                }
            });
            shareHtml += '</div>';

            alert('Pilih platform untuk berbagi:\n\n' + shareOptions.map(opt => opt.name).join(', '));
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Link berhasil disalin!');
            }).catch(() => {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Link berhasil disalin!');
            });
        }

        function addToCalendar() {
            @if($agenda->event_date)
                const startDate = new Date('{{ $agenda->event_date->format('Y-m-d\TH:i:s') }}');
                const endDate = new Date(startDate.getTime() + (2 * 60 * 60 * 1000)); // 2 hours later

                const formatDate = (date) => {
                    return date.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
                };

                const title = encodeURIComponent('{{ $agenda->title }}');
                const description = encodeURIComponent('{{ strip_tags($agenda->content) }}');
                const location = encodeURIComponent('{{ $agenda->location ?? '' }}');

                const googleCalendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${title}&dates=${formatDate(startDate)}/${formatDate(endDate)}&details=${description}&location=${location}`;

                window.open(googleCalendarUrl, '_blank');
            @endif
    }
    </script>
@endsection