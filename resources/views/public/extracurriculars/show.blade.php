@extends('layouts.public')

@section('title', $extracurricular->name . ' - Ekstrakurikuler - SMA Negeri 99')

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
    
    /* Enhanced Hero Section */
    .extracurricular-hero {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        color: white;
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .extracurricular-hero::before {
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

    .breadcrumb {
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    .breadcrumb a {
        color: white;
        text-decoration: none;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .breadcrumb a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .breadcrumb-separator {
        margin: 0 0.5rem;
        opacity: 0.6;
    }

    .hero-extracurricular-info {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .hero-image {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .hero-image-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 2.5rem;
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .hero-details h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .hero-coach {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .back-button {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
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
    
    .scale-in.animate {
        opacity: 1;
        transform: scale(1);
    }

    /* Enhanced Detail Section */
    .detail-section {
        padding: 80px 0;
        background: var(--light-gray);
    }

    .detail-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 3rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Enhanced Main Content */
    .detail-main {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .detail-main:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }

    .main-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .description-content {
        color: var(--dark-gray);
        line-height: 1.8;
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    .schedule-info {
        background: rgba(49, 130, 206, 0.05);
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid rgba(49, 130, 206, 0.1);
        margin-bottom: 2rem;
    }

    .schedule-title {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .schedule-text {
        color: var(--dark-gray);
        line-height: 1.6;
    }

    /* Enhanced Sidebar */
    .detail-sidebar {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        height: fit-content;
        position: sticky;
        top: 2rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .detail-sidebar:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }

    .sidebar-section {
        margin-bottom: 2rem;
    }

    .sidebar-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--light-gray);
        padding: 1rem;
        border-radius: 12px;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--secondary-color);
        display: block;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--dark-gray);
        margin-top: 0.25rem;
    }

    .register-button {
        width: 100%;
        background: var(--gradient-primary);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
        border: none;
        font-size: 1rem;
    }

    .register-button:hover {
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(49, 130, 206, 0.4);
    }

    .register-button:disabled {
        background: #6b7280;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Recent Registrations */
    .recent-registrations {
        margin-top: 2rem;
    }

    .registration-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: var(--light-gray);
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }

    .registration-item:hover {
        background: rgba(49, 130, 206, 0.05);
        transform: translateX(4px);
    }

    .registration-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .registration-info {
        flex: 1;
    }

    .registration-name {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .registration-class {
        font-size: 0.8rem;
        color: var(--dark-gray);
    }

    /* Related Extracurriculars */
    .related-section {
        margin-top: 3rem;
        padding-top: 3rem;
        border-top: 2px solid #e5e7eb;
    }

    .related-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
        padding-bottom: 1rem;
    }

    .related-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--gradient-primary);
        border-radius: 2px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .related-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        position: relative;
        overflow: hidden;
    }

    .related-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(49, 130, 206, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .related-card:hover::before {
        opacity: 1;
    }

    .related-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: inherit;
        border-color: rgba(49, 130, 206, 0.2);
    }

    .related-image {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1rem;
        border: 3px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .related-card:hover .related-image {
        transform: scale(1.1);
        border-color: var(--secondary-color);
    }

    .related-image-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-weight: 600;
        font-size: 1.5rem;
        border: 3px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .related-card:hover .related-image-placeholder {
        transform: scale(1.1);
        border-color: var(--secondary-color);
    }

    .related-name {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .related-coach {
        color: var(--dark-gray);
        font-size: 0.875rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .extracurricular-hero {
            padding: 60px 0;
        }

        .hero-extracurricular-info {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .hero-details h1 {
            font-size: 2rem;
        }

        .detail-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .detail-sidebar {
            position: static;
            order: 2;
        }

        .detail-main {
            order: 1;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .related-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .main-title {
            font-size: 1.5rem;
        }
        
        .back-button {
            position: static;
            margin-top: 1rem;
            width: 100%;
            justify-content: center;
        }
        
        .hero-content .d-flex {
            flex-direction: column;
            align-items: center;
        }
    }

    /* Animation delays */
    .fade-in-up:nth-child(1) { animation-delay: 0.1s; }
    .fade-in-up:nth-child(2) { animation-delay: 0.2s; }
    .fade-in-up:nth-child(3) { animation-delay: 0.3s; }
    .fade-in-up:nth-child(4) { animation-delay: 0.4s; }
</style>

<!-- Enhanced Hero Section -->
<section class="extracurricular-hero">
    <div class="container">
        <div class="hero-content">
            <!-- Breadcrumb -->
            <nav class="breadcrumb fade-in-up">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('public.extracurriculars.index') }}">Ekstrakurikuler</a>
                <span class="breadcrumb-separator">/</span>
                <span>{{ $extracurricular->name }}</span>
            </nav>

            <div class="d-flex justify-content-between align-items-start">
                <div class="hero-extracurricular-info fade-in-left">
                    @if($extracurricular->image)
                        <img src="{{ asset('storage/' . $extracurricular->image) }}" 
                             alt="{{ $extracurricular->name }}" 
                             class="hero-image">
                    @else
                        <div class="hero-image-placeholder">
                            <i class="fas fa-users"></i>
                        </div>
                    @endif
                    <div class="hero-details">
                        <h1>{{ $extracurricular->name }}</h1>
                        <p class="hero-coach">
                            <i class="fas fa-user-tie me-2"></i>
                            Pembina: {{ $extracurricular->coach }}
                        </p>
                        @if($extracurricular->schedule)
                            <p style="opacity: 0.8; font-size: 0.9rem;">
                                <i class="fas fa-clock me-2"></i>
                                {{ $extracurricular->schedule }}
                            </p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('public.extracurriculars.index') }}" class="back-button fade-in-right">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Detail Section -->
<section class="detail-section">
    <div class="container">
        <div class="detail-container">
            <!-- Enhanced Main Content -->
            <div class="detail-main fade-in-left">
                <h2 class="main-title">
                    <i class="fas fa-info-circle"></i>
                    Tentang {{ $extracurricular->name }}
                </h2>

                <div class="description-content">
                    {!! nl2br(e($extracurricular->description)) !!}
                </div>

                @if($extracurricular->schedule)
                    <div class="schedule-info">
                        <h3 class="schedule-title">
                            <i class="fas fa-calendar-alt"></i>
                            Jadwal Kegiatan
                        </h3>
                        <div class="schedule-text">
                            {!! nl2br(e($extracurricular->schedule)) !!}
                        </div>
                    </div>
                @endif

                <!-- Recent Registrations -->
                @if($extracurricular->registrations->count() > 0)
                    <div class="recent-registrations">
                        <h3 class="sidebar-title">
                            <i class="fas fa-users"></i>
                            Pendaftar Terbaru
                        </h3>
                        @foreach($extracurricular->registrations->take(5) as $registration)
                            <div class="registration-item">
                                <div class="registration-avatar">
                                    {{ strtoupper(substr($registration->student_name, 0, 2)) }}
                                </div>
                                <div class="registration-info">
                                    <div class="registration-name">{{ $registration->student_name }}</div>
                                    <div class="registration-class">{{ $registration->student_class }} {{ $registration->student_major }}</div>
                                </div>
                                <span class="badge bg-{{ $registration->status === 'approved' ? 'success' : ($registration->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ $registration->status === 'approved' ? 'Diterima' : ($registration->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Enhanced Sidebar -->
            <div class="detail-sidebar fade-in-right">
                <!-- Statistics -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-chart-bar"></i>
                        Statistik
                    </h3>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <span class="stat-number">{{ $extracurricular->registration_count }}</span>
                            <div class="stat-label">Total Pendaftar</div>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">{{ $extracurricular->approved_count }}</span>
                            <div class="stat-label">Diterima</div>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">{{ $extracurricular->pending_count }}</span>
                            <div class="stat-label">Menunggu</div>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">{{ $extracurricular->status === 'active' ? 'Aktif' : 'Tutup' }}</span>
                            <div class="stat-label">Status</div>
                        </div>
                    </div>
                </div>

                <!-- Registration Button -->
                <div class="sidebar-section">
                    @if($extracurricular->status === 'active')
                        <a href="{{ route('public.extracurriculars.register', $extracurricular) }}" class="register-button">
                            <i class="fas fa-user-plus"></i>
                            Daftar Sekarang
                        </a>
                    @else
                        <button class="register-button" disabled>
                            <i class="fas fa-lock"></i>
                            Pendaftaran Ditutup
                        </button>
                    @endif
                </div>

                <!-- Contact Info -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-user-tie"></i>
                        Informasi Pembina
                    </h3>
                    <div class="registration-item">
                        <div class="registration-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="registration-info">
                            <div class="registration-name">{{ $extracurricular->coach }}</div>
                            <div class="registration-class">Pembina Ekstrakurikuler</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Related Extracurriculars -->
        @if($relatedExtracurriculars->count() > 0)
            <div class="related-section">
                <h3 class="related-title fade-in-up">Ekstrakurikuler Lainnya</h3>
                <div class="related-grid">
                    @foreach($relatedExtracurriculars as $index => $related)
                        <a href="{{ route('public.extracurriculars.show', $related) }}" 
                           class="related-card fade-in-up" 
                           style="animation-delay: {{ $index * 0.1 }}s;">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" 
                                     alt="{{ $related->name }}" 
                                     class="related-image">
                            @else
                                <div class="related-image-placeholder">
                                    <i class="fas fa-users"></i>
                                </div>
                            @endif
                            <h4 class="related-name">{{ $related->name }}</h4>
                            <p class="related-coach">{{ $related->coach }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

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

    // Enhanced stat card hover effects
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Enhanced related card hover effects
    const relatedCards = document.querySelectorAll('.related-card');
    relatedCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-12px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    console.log('Enhanced extracurricular detail page animations loaded successfully!');
});
</script>
@endsection