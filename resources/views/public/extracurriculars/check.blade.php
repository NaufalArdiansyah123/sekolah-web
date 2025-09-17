@extends('layouts.public')

@section('title', 'Cek Status Pendaftaran - Ekstrakurikuler - SMA Negeri 99')

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
    .check-hero {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        color: white;
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .check-hero::before {
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
        text-align: center;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
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

    /* Enhanced Results Section */
    .results-section {
        padding: 80px 0;
        background: var(--light-gray);
    }

    .results-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .search-info {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 3rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        text-align: center;
    }

    .search-nis {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .search-count {
        color: var(--dark-gray);
        font-size: 0.9rem;
    }

    /* Registration Cards */
    .registration-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .registration-card::before {
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

    .registration-card:hover::before {
        opacity: 1;
    }

    .registration-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        position: relative;
        z-index: 2;
    }

    .extracurricular-info {
        flex: 1;
    }

    .extracurricular-name {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .extracurricular-coach {
        color: var(--secondary-color);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .status-pending {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
    }

    .status-approved {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .status-rejected {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .card-body {
        position: relative;
        z-index: 2;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        background: var(--light-gray);
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .info-label {
        font-size: 0.8rem;
        color: var(--dark-gray);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.9rem;
    }

    .registration-dates {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: rgba(49, 130, 206, 0.05);
        border-radius: 12px;
        border: 1px solid rgba(49, 130, 206, 0.1);
        margin-bottom: 1.5rem;
    }

    .date-item {
        text-align: center;
        flex: 1;
    }

    .date-label {
        font-size: 0.8rem;
        color: var(--dark-gray);
        margin-bottom: 0.25rem;
    }

    .date-value {
        font-weight: 600;
        color: var(--secondary-color);
        font-size: 0.9rem;
    }

    .reason-section {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .reason-title {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .reason-text {
        color: var(--dark-gray);
        line-height: 1.6;
        background: var(--light-gray);
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid var(--secondary-color);
    }

    .notes-section {
        margin-top: 1rem;
        padding: 1rem;
        background: #fef2f2;
        border-radius: 8px;
        border-left: 4px solid #ef4444;
    }

    .notes-title {
        font-weight: 600;
        color: #dc2626;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .notes-text {
        color: #7f1d1d;
        line-height: 1.6;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: var(--dark-gray);
        transition: all 0.3s ease;
    }

    .empty-state:hover .empty-icon {
        transform: scale(1.05);
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }

    .empty-description {
        color: var(--dark-gray);
        margin-bottom: 2rem;
        line-height: 1.6;
        font-size: 1.1rem;
    }

    .btn-back {
        background: var(--gradient-primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(49, 130, 206, 0.4);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .check-hero {
            padding: 60px 0;
        }

        .hero-title {
            font-size: 2rem;
        }

        .card-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .registration-dates {
            flex-direction: column;
            gap: 1rem;
        }

        .registration-card {
            padding: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.5rem;
        }
        
        .results-section {
            padding: 60px 0;
        }
    }
</style>

<!-- Enhanced Hero Section -->
<section class="check-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title fade-in-up">Status Pendaftaran Ekstrakurikuler</h1>
            <p class="hero-subtitle fade-in-up" style="animation-delay: 0.2s;">
                Hasil pencarian untuk NIS: <strong>{{ request('student_nis') }}</strong>
            </p>
        </div>
    </div>
</section>

<!-- Enhanced Results Section -->
<section class="results-section">
    <div class="container">
        <div class="results-container">
            <!-- Search Info -->
            <div class="search-info fade-in-up">
                <div class="search-nis">NIS: {{ request('student_nis') }}</div>
                <div class="search-count">
                    @if($registrations->count() > 0)
                        Ditemukan {{ $registrations->count() }} pendaftaran ekstrakurikuler
                    @else
                        Tidak ditemukan pendaftaran ekstrakurikuler
                    @endif
                </div>
            </div>

            @if($registrations->count() > 0)
                <!-- Registration Results -->
                @foreach($registrations as $index => $registration)
                    <div class="registration-card fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="card-header">
                            <div class="extracurricular-info">
                                <h3 class="extracurricular-name">{{ $registration->extracurricular->name }}</h3>
                                <p class="extracurricular-coach">
                                    <i class="fas fa-user-tie me-2"></i>
                                    Pembina: {{ $registration->extracurricular->coach }}
                                </p>
                            </div>
                            <div class="status-badge status-{{ $registration->status }}">
                                @if($registration->status === 'pending')
                                    <i class="fas fa-clock me-2"></i>Menunggu
                                @elseif($registration->status === 'approved')
                                    <i class="fas fa-check-circle me-2"></i>Diterima
                                @else
                                    <i class="fas fa-times-circle me-2"></i>Ditolak
                                @endif
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Student Info Grid -->
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Nama Siswa</div>
                                    <div class="info-value">{{ $registration->student_name }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Kelas</div>
                                    <div class="info-value">{{ $registration->student_class }} {{ $registration->student_major }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Email</div>
                                    <div class="info-value">{{ $registration->email }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Telepon</div>
                                    <div class="info-value">{{ $registration->phone }}</div>
                                </div>
                            </div>

                            <!-- Registration Dates -->
                            <div class="registration-dates">
                                <div class="date-item">
                                    <div class="date-label">Tanggal Daftar</div>
                                    <div class="date-value">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ $registration->registered_at->format('d M Y') }}
                                    </div>
                                </div>
                                @if($registration->approved_at)
                                    <div class="date-item">
                                        <div class="date-label">
                                            {{ $registration->status === 'approved' ? 'Tanggal Diterima' : 'Tanggal Ditolak' }}
                                        </div>
                                        <div class="date-value">
                                            <i class="fas fa-calendar-check me-2"></i>
                                            {{ $registration->approved_at->format('d M Y') }}
                                        </div>
                                    </div>
                                @endif
                                @if($registration->approvedBy)
                                    <div class="date-item">
                                        <div class="date-label">Diproses Oleh</div>
                                        <div class="date-value">
                                            <i class="fas fa-user me-2"></i>
                                            {{ $registration->approvedBy->name }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Reason Section -->
                            <div class="reason-section">
                                <h4 class="reason-title">
                                    <i class="fas fa-heart"></i>
                                    Alasan Bergabung
                                </h4>
                                <div class="reason-text">
                                    {{ $registration->reason }}
                                </div>
                            </div>

                            <!-- Experience Section -->
                            @if($registration->experience)
                                <div class="reason-section">
                                    <h4 class="reason-title">
                                        <i class="fas fa-star"></i>
                                        Pengalaman Terkait
                                    </h4>
                                    <div class="reason-text">
                                        {{ $registration->experience }}
                                    </div>
                                </div>
                            @endif

                            <!-- Notes Section (for rejected applications) -->
                            @if($registration->status === 'rejected' && $registration->notes)
                                <div class="notes-section">
                                    <h4 class="notes-title">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Catatan Penolakan
                                    </h4>
                                    <div class="notes-text">
                                        {{ $registration->notes }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="empty-state fade-in-up">
                    <div class="empty-icon">
                        <i class="fas fa-search fa-3x"></i>
                    </div>
                    <h3 class="empty-title">Tidak Ada Pendaftaran Ditemukan</h3>
                    <p class="empty-description">
                        Tidak ditemukan pendaftaran ekstrakurikuler untuk NIS <strong>{{ request('student_nis') }}</strong>.<br>
                        Pastikan NIS yang dimasukkan sudah benar atau belum pernah mendaftar ekstrakurikuler.
                    </p>
                    <a href="{{ route('public.extracurriculars.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Daftar Ekstrakurikuler
                    </a>
                </div>
            @endif

            <!-- Back Button -->
            @if($registrations->count() > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('public.extracurriculars.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Daftar Ekstrakurikuler
                    </a>
                </div>
            @endif
        </div>
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

    // Enhanced card hover effects
    const registrationCards = document.querySelectorAll('.registration-card');
    registrationCards.forEach((card, index) => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02)';
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.zIndex = '1';
        });

        // Add staggered animation delay
        card.style.animationDelay = `${index * 0.1}s`;
    });

    // Enhanced info item hover effects
    const infoItems = document.querySelectorAll('.info-item');
    infoItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    console.log('Enhanced check registration page animations loaded successfully!');
});
</script>
@endsection