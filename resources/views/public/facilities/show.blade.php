@extends('layouts.public')

@section('title', $facility->name . ' - Fasilitas Sekolah')

@section('content')
<link rel="stylesheet" href="{{ asset('css/public-template.css') }}">
<style>
    /* Page-specific styles for Facility Detail */
    
    .facility-hero {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        );
        min-height: 60vh;
        position: relative;
        overflow: hidden;
    }
    
    .facility-hero::before {
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
    
    .facility-hero .container {
        position: relative;
        z-index: 2;
    }
    
    .facility-detail-section {
        padding: 80px 0;
        background: #f8f9fa;
    }
    
    .facility-image-container {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        margin-bottom: 30px;
    }
    
    .facility-image-container img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
    
    .facility-status-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        backdrop-filter: blur(10px);
    }
    
    .status-active {
        background: rgba(40, 167, 69, 0.9);
        color: white;
    }
    
    .status-maintenance {
        background: rgba(255, 193, 7, 0.9);
        color: #212529;
    }
    
    .status-inactive {
        background: rgba(220, 53, 69, 0.9);
        color: white;
    }
    
    .facility-info-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .facility-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 20px;
        line-height: 1.2;
    }
    
    .facility-category {
        display: inline-block;
        background: var(--gradient-primary);
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
    
    .facility-description {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--dark-gray);
        margin-bottom: 30px;
    }
    
    .info-table {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .info-table table {
        margin-bottom: 0;
    }
    
    .info-table td {
        padding: 12px 0;
        border: none;
        vertical-align: top;
    }
    
    .info-table .info-label {
        font-weight: 600;
        color: var(--primary-color);
        width: 120px;
    }
    
    .features-section {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    
    .feature-item:last-child {
        border-bottom: none;
    }
    
    .feature-icon {
        width: 40px;
        height: 40px;
        background: var(--gradient-light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: var(--primary-color);
    }
    
    .feature-text {
        flex: 1;
        font-weight: 500;
        color: var(--dark-gray);
    }
    
    .related-facilities {
        padding: 80px 0;
        background: white;
    }
    
    .related-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        height: 100%;
    }
    
    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        text-decoration: none;
        color: inherit;
    }
    
    .related-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .related-card-body {
        padding: 20px;
    }
    
    .related-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    
    .related-card-desc {
        color: var(--dark-gray);
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    .breadcrumb-custom {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 10px 20px;
        margin-bottom: 20px;
    }
    
    .breadcrumb-custom a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
    }
    
    .breadcrumb-custom a:hover {
        color: white;
    }
    
    .breadcrumb-custom .active {
        color: white;
    }
    
    .action-buttons {
        margin-top: 30px;
    }
    
    .btn-enhanced {
        border-radius: 12px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: none;
        letter-spacing: 0.3px;
    }
    
    .btn-enhanced:hover {
        transform: translateY(-2px);
    }
    
    .btn-primary-enhanced {
        background: var(--gradient-primary);
        border: none;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }
    
    .btn-primary-enhanced:hover {
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
    }
    
    .btn-outline-enhanced {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
    }
    
    .btn-outline-enhanced:hover {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }
    
    /* Animation Classes */
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease forwards;
    }
    
    .fade-in-up:nth-child(2) { animation-delay: 0.2s; }
    .fade-in-up:nth-child(3) { animation-delay: 0.4s; }
    .fade-in-up:nth-child(4) { animation-delay: 0.6s; }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .facility-hero {
            min-height: 50vh;
            text-align: center;
        }
        
        .facility-title {
            font-size: 2rem;
        }
        
        .facility-image-container img {
            height: 250px;
        }
        
        .info-table .info-label {
            width: 100px;
            font-size: 0.9rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="facility-hero d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-custom">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('facilities.index') }}">Fasilitas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $facility->name }}</li>
                    </ol>
                </nav>
                
                <h1 class="facility-title text-white fade-in-up">{{ $facility->name }}</h1>
                <p class="lead text-white-50 fade-in-up">{{ $facility->category_label }} • {{ $facility->location ?: 'Lokasi tidak ditentukan' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Facility Detail Section -->
<section class="facility-detail-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Facility Image -->
                <div class="facility-image-container fade-in-up">
                    <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}">
                    <div class="facility-status-badge status-{{ $facility->status }}">
                        @if($facility->status === 'active')
                            <i class="fas fa-check-circle me-1"></i> Tersedia
                        @elseif($facility->status === 'maintenance')
                            <i class="fas fa-tools me-1"></i> Maintenance
                        @else
                            <i class="fas fa-times-circle me-1"></i> Tidak Tersedia
                        @endif
                    </div>
                </div>
                
                <!-- Facility Info -->
                <div class="facility-info-card fade-in-up">
                    <span class="facility-category">{{ $facility->category_label }}</span>
                    <h2 class="h4 mb-3">Tentang Fasilitas</h2>
                    <p class="facility-description">{{ $facility->description }}</p>
                    
                    @if($facility->status === 'active')
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary-enhanced btn-enhanced me-3">
                                <i class="fas fa-calendar-plus me-2"></i>Ajukan Penggunaan
                            </button>
                            <a href="{{ route('facilities.index') }}" class="btn btn-outline-enhanced btn-enhanced">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                        </div>
                    @else
                        <div class="action-buttons">
                            <a href="{{ route('facilities.index') }}" class="btn btn-outline-enhanced btn-enhanced">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Features Section -->
                @if($facility->features && count($facility->features) > 0)
                    <div class="features-section fade-in-up">
                        <h3 class="h5 mb-4">
                            <i class="fas fa-star text-warning me-2"></i>Fitur-fitur Fasilitas
                        </h3>
                        <div class="row">
                            @foreach($facility->features as $feature)
                                <div class="col-md-6">
                                    <div class="feature-item">
                                        <div class="feature-icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="feature-text">{{ $feature }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="col-lg-4">
                <!-- Facility Information -->
                <div class="facility-info-card fade-in-up">
                    <h3 class="h5 mb-4">
                        <i class="fas fa-info-circle text-primary me-2"></i>Informasi Fasilitas
                    </h3>
                    
                    <div class="info-table">
                        <table class="table table-borderless">
                            <tr>
                                <td class="info-label">Kategori:</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $facility->category_label }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="info-label">Status:</td>
                                <td>
                                    <span class="badge bg-{{ $facility->status === 'active' ? 'success' : ($facility->status === 'maintenance' ? 'warning' : 'danger') }}">
                                        @if($facility->status === 'active')
                                            <i class="fas fa-check-circle me-1"></i> Tersedia
                                        @elseif($facility->status === 'maintenance')
                                            <i class="fas fa-tools me-1"></i> Maintenance
                                        @else
                                            <i class="fas fa-times-circle me-1"></i> Tidak Tersedia
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            @if($facility->capacity)
                                <tr>
                                    <td class="info-label">Kapasitas:</td>
                                    <td>
                                        <i class="fas fa-users text-muted me-1"></i>
                                        {{ $facility->capacity }} orang
                                    </td>
                                </tr>
                            @endif
                            @if($facility->location)
                                <tr>
                                    <td class="info-label">Lokasi:</td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                        {{ $facility->location }}
                                    </td>
                                </tr>
                            @endif
                            @if($facility->is_featured)
                                <tr>
                                    <td class="info-label">Unggulan:</td>
                                    <td>
                                        <span class="badge bg-warning">
                                            <i class="fas fa-star me-1"></i> Fasilitas Unggulan
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="facility-info-card fade-in-up">
                    <h3 class="h5 mb-4">
                        <i class="fas fa-phone text-primary me-2"></i>Informasi Kontak
                    </h3>
                    <p class="mb-3">
                        <i class="fas fa-envelope text-muted me-2"></i>
                        <a href="mailto:info@smkpgri2ponorogo.sch.id">info@smkpgri2ponorogo.sch.id</a>
                    </p>
                    <p class="mb-3">
                        <i class="fas fa-phone text-muted me-2"></i>
                        <a href="tel:+62351234567">(0351) 234-567</a>
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-clock text-muted me-2"></i>
                        Senin - Jumat: 07:00 - 16:00
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Facilities Section -->
@if($relatedFacilities->count() > 0)
    <section class="related-facilities">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Fasilitas Terkait</h2>
                <p>Fasilitas lain dalam kategori {{ $facility->category_label }}</p>
            </div>
            
            <div class="row">
                @foreach($relatedFacilities as $related)
                    <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                        <a href="{{ route('facilities.show', $related) }}" class="related-card d-block">
                            <img src="{{ $related->image_url }}" alt="{{ $related->name }}">
                            <div class="related-card-body">
                                <h5 class="related-card-title">{{ $related->name }}</h5>
                                <p class="related-card-desc">{{ Str::limit($related->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $related->location ?: 'Lokasi tidak ditentukan' }}</small>
                                    <span class="badge bg-{{ $related->status === 'active' ? 'success' : ($related->status === 'maintenance' ? 'warning' : 'danger') }}">
                                        {{ $related->status === 'active' ? 'Tersedia' : ($related->status === 'maintenance' ? 'Maintenance' : 'Tidak Tersedia') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('facilities.index') }}" class="btn btn-primary-enhanced btn-enhanced">
                    <i class="fas fa-building me-2"></i>Lihat Semua Fasilitas
                </a>
            </div>
        </div>
    </section>
@endif

<!-- JavaScript untuk Animasi -->
<script src="{{ asset('js/public-template.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation on scroll
        const animatedElements = document.querySelectorAll('.fade-in-up');
        
        function checkScroll() {
            animatedElements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (elementPosition < screenPosition) {
                    element.style.animationPlayState = 'running';
                }
            });
        }
        
        // Initial check
        checkScroll();
        
        // Check on scroll
        window.addEventListener('scroll', checkScroll);
    });
</script>

@endsection