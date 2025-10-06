@extends('layouts.public')

@section('title', 'Profil Sekolah')

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
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        );
        color: white;
        padding: 100px 0;
        min-height: 70vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section.with-image {
        background-image: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        var(--hero-image);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    
    /* Fallback for browsers that don't support CSS custom properties */
    .hero-section.with-image[style*="--hero-image"] {
        background-image: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        var(--hero-image);
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
    
    /* Enhanced Stats Section matching home page */
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

    /* Enhanced Cards matching home page style */
    .card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
        padding: 20px;
    }
    
    .card-body {
        padding: 25px;
    }
    
    /* Enhanced Timeline */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, var(--secondary-color), var(--accent-color));
        border-radius: 2px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 40px;
        padding-left: 40px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -32px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
    
    .timeline-item:hover .timeline-marker {
        transform: scale(1.2);
    }
    
    /* Enhanced Achievements */
    .achievement-badge {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .achievement-badge:hover {
        transform: scale(1.1) rotate(5deg);
    }
    
    /* Info Items */
    .info-item {
        padding: 15px 0;
        border-bottom: 1px solid #f8f9fa;
        transition: all 0.3s ease;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-item:hover {
        background: rgba(49, 130, 206, 0.05);
        padding-left: 10px;
        border-radius: 8px;
    }
    
    .contact-item {
        padding: 12px 0;
        transition: all 0.3s ease;
    }
    
    .contact-item:hover {
        background: rgba(49, 130, 206, 0.05);
        padding-left: 10px;
        border-radius: 8px;
    }
    
    /* Enhanced Leadership */
    .leadership-avatar {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .leadership-avatar:hover {
        transform: scale(1.1);
    }
    
    /* Enhanced CTA Section */
    .cta-section {
        background: var(--gradient-primary);
        color: white;
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
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
    
    .cta-section .container {
        position: relative;
        z-index: 2;
    }
    
    /* Enhanced Buttons */
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
    
    /* Counter Animation Keyframes */
    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stats-number.counting {
        animation: countUp 0.6s ease-out;
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

    /* Enhanced facility cards */
    .facility-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 20px;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        position: relative;
    }
    
    .facility-card::before {
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
    
    .facility-card:hover::before {
        opacity: 1;
    }
    
    .facility-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
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
        
        .timeline {
            padding-left: 20px;
        }
        
        .timeline::before {
            left: 8px;
        }
        
        .timeline-marker {
            left: -24px;
            width: 16px;
            height: 16px;
        }
        
        .timeline-item {
            padding-left: 30px;
        }
    }
    
    @media (max-width: 576px) {
        .stats-number {
            font-size: 2rem !important;
        }
        
        .hero-section h1 {
            font-size: 2rem;
        }
    }
</style>

<!-- Enhanced Hero Section -->
@php
    $heroImageUrl = '';
    if ($profile->hero_image) {
        // Handle different path formats
        if (str_starts_with($profile->hero_image, 'storage/')) {
            $heroImageUrl = asset($profile->hero_image);
        } elseif (str_starts_with($profile->hero_image, 'http')) {
            $heroImageUrl = $profile->hero_image;
        } else {
            $heroImageUrl = asset('storage/' . $profile->hero_image);
        }
    }
@endphp

<!-- Debug: Hero Image Path: {{ $profile->hero_image ?? 'No hero image' }} -->
<!-- Debug: Generated URL: {{ $heroImageUrl }} -->
<section class="hero-section {{ $profile->hero_image ? 'with-image' : '' }}" 
         @if($profile->hero_image) 
         style="--hero-image: url('{{ $heroImageUrl }}'); 
                background-image: linear-gradient(135deg, rgba(26, 32, 44, 0.8) 0%, rgba(49, 130, 206, 0.7) 50%, rgba(26, 32, 44, 0.8) 100%), url('{{ $heroImageUrl }}') !important;
                background-size: cover !important;
                background-position: center !important;
                background-repeat: no-repeat !important;" 
         @endif>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Profil {{ $profile->school_name }}</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">{{ $profile->school_motto ?? 'Excellence in Education' }} - {{ $profile->about_description ?? 'Membentuk generasi yang berkarakter, berprestasi, dan siap menghadapi masa depan.' }}</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-school hero-icon scale-in" style="animation-delay: 0.4s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Quick Stats with Counting Animation -->
<section class="stats-section">
    <div class="container">
        <div class="section-title">
            <h2 class="section-heading fade-in-up">{{ $profile->school_name }}</h2>
            <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Pencapaian dan prestasi yang membanggakan</p>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-users fa-3x text-primary stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-primary mb-2" data-target="{{ $profile->student_count ?? 2400 }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">JUMLAH SISWA</p>
                        <div class="stats-bar bg-primary"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-chalkboard-teacher fa-3x text-success stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-success mb-2" data-target="{{ $profile->teacher_count ?? 120 }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">JUMLAH GURU</p>
                        <div class="stats-bar bg-success"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-user-tie fa-3x text-warning stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-warning mb-2" data-target="{{ $profile->staff_count ?? 40 }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">JUMLAH STAFF</p>
                        <div class="stats-bar bg-warning"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.6s;">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-handshake fa-3x text-info stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-info mb-2" data-target="{{ $profile->industry_partnerships ?? 110 }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">KERJA SAMA INDUSTRI</p>
                        <div class="stats-bar bg-info"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5">
                <div class="card shadow h-100 fade-in-left">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tentang Kami</h4>
                    </div>
                    <div class="card-body p-4">
                        <p class="lead mb-4">{{ $profile->about_description ?? 'SMK PGRI 2 PONOROGO adalah institusi pendidikan menengah atas yang telah berkiprah dalam dunia pendidikan selama lebih dari 30 tahun.' }}</p>
                        @if($profile->vision)
                            <p><strong>Visi:</strong> {{ $profile->vision }}</p>
                        @endif
                        @if($profile->mission)
                            <p><strong>Misi:</strong> {{ $profile->mission }}</p>
                        @endif
                        <div class="mt-4">
                            <h6 class="text-primary">Nilai-Nilai Inti:</h6>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <div class="text-center scale-in" style="animation-delay: 0.2s;">
                                        <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                                        <h6>Integritas</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center scale-in" style="animation-delay: 0.4s;">
                                        <i class="fas fa-star fa-2x text-warning mb-2"></i>
                                        <h6>Keunggulan</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-5">
                <div class="card shadow h-100 fade-in-right">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-history me-2"></i>Sejarah Singkat</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            @if(count($profile->history_timeline) > 0)
                                @foreach($profile->history_timeline as $index => $historyItem)
                                    <div class="timeline-item mb-4 fade-in-up" style="animation-delay: {{ ($index + 1) * 0.2 }}s;">
                                        <div class="timeline-marker bg-{{ $historyItem['type'] === 'milestone' ? 'primary' : ($historyItem['type'] === 'achievement' ? 'success' : ($historyItem['type'] === 'expansion' ? 'warning' : ($historyItem['type'] === 'recognition' ? 'info' : 'secondary'))) }}"></div>
                                        <div class="timeline-content">
                                            <h6 class="fw-bold text-{{ $historyItem['type'] === 'milestone' ? 'primary' : ($historyItem['type'] === 'achievement' ? 'success' : ($historyItem['type'] === 'expansion' ? 'warning' : ($historyItem['type'] === 'recognition' ? 'info' : 'secondary'))) }}">
                                                {{ $historyItem['year'] ?? '' }} - {{ $historyItem['title'] ?? 'Historical Event' }}
                                            </h6>
                                            <p class="mb-2">{{ $historyItem['description'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @if($profile->established_year)
                                    <div class="timeline-item mb-4 fade-in-up" style="animation-delay: 0.1s;">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="fw-bold text-primary">{{ $profile->established_year }}</h6>
                                            <p class="mb-2">Tahun pendirian sekolah ({{ date('Y') - $profile->established_year }} tahun yang lalu)</p>
                                        </div>
                                    </div>
                                @endif
                                @if($profile->accreditation)
                                    <div class="timeline-item mb-4 fade-in-up" style="animation-delay: 0.3s;">
                                        <div class="timeline-marker bg-warning"></div>
                                        <div class="timeline-content">
                                            <h6 class="fw-bold text-warning">Akreditasi {{ $profile->accreditation }}</h6>
                                            <p class="mb-2">Terakreditasi {{ $profile->accreditation }} dan terus berkembang</p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="timeline-item fade-in-up" style="animation-delay: 0.7s;">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold text-info">{{ date('Y') }} - Sekarang</h6>
                                    <p class="mb-0">Era pembelajaran modern dan inovasi teknologi pendidikan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="mb-3 section-heading fade-in-up">Fasilitas Sekolah</h2>
                <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Fasilitas lengkap dan modern untuk mendukung kegiatan pembelajaran yang optimal</p>
            </div>
        </div>

        <div class="row g-4">
            @if($profile->facilities && count($profile->facilities) > 0)
                @foreach($profile->facilities_with_icons as $index => $facility)
                    <div class="col-md-4">
                        <div class="card shadow h-100 facility-card fade-in-up" style="animation-delay: {{ ($index + 1) * 0.2 }}s;">
                            <div class="card-body text-center p-4">
                                <i class="{{ $facility['icon'] }} fa-3x text-{{ $facility['color'] }} mb-3"></i>
                                <h5>{{ $facility['name'] }}</h5>
                                <p class="text-muted">{{ $facility['description'] }}</p>
                                @if(count($facility['features']) > 0)
                                    <ul class="list-unstyled text-start">
                                        @foreach($facility['features'] as $feature)
                                            <li><i class="fas fa-check text-success me-2"></i> {{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Default facilities if none are set -->
                <div class="col-md-4">
                    <div class="card shadow h-100 facility-card fade-in-up" style="animation-delay: 0.2s;">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-music fa-3x text-purple mb-3" style="color: #6f42c1 !important;"></i>
                            <h5>Studio Seni</h5>
                            <p class="text-muted">Ruang musik, tari, dan seni rupa untuk pengembangan bakat</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i> Piano & keyboard</li>
                                <li><i class="fas fa-check text-success me-2"></i> Sound system</li>
                                <li><i class="fas fa-check text-success me-2"></i> Panggung mini</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow h-100 facility-card fade-in-up" style="animation-delay: 0.4s;">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-microscope fa-3x text-primary mb-3"></i>
                            <h5>Laboratorium IPA</h5>
                            <p class="text-muted">Laboratorium lengkap untuk praktikum fisika, kimia, dan biologi</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i> Mikroskop digital</li>
                                <li><i class="fas fa-check text-success me-2"></i> Alat praktikum lengkap</li>
                                <li><i class="fas fa-check text-success me-2"></i> Ruang ber-AC</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow h-100 facility-card fade-in-up" style="animation-delay: 0.6s;">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-book fa-3x text-success mb-3"></i>
                            <h5>Perpustakaan Digital</h5>
                            <p class="text-muted">Perpustakaan modern dengan koleksi buku dan e-book</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i> 10,000+ buku fisik</li>
                                <li><i class="fas fa-check text-success me-2"></i> E-library access</li>
                                <li><i class="fas fa-check text-success me-2"></i> Ruang baca nyaman</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Achievements Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h3 class="mb-4 section-heading fade-in-left text-start"><i class="fas fa-trophy me-2"></i>Prestasi Terbaru</h3>

                @if($achievements && $achievements->count() > 0)
                    @foreach($achievements as $index => $achievement)
                        <div class="card shadow mb-3 fade-in-left" style="animation-delay: {{ ($index + 1) * 0.2 }}s;">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center">
                                        <div class="achievement-badge bg-{{ $achievement->level_badge_color }} text-white scale-in" style="animation-delay: {{ ($index + 2) * 0.2 }}s;">
                                            <i class="{{ $achievement->category_icon }} fa-2x"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="mb-1">{{ $achievement->title }}</h5>
                                        <p class="text-muted mb-1">{{ $achievement->description }}</p>
                                        @if($achievement->participant)
                                            <p class="text-muted mb-1"><strong>Peserta:</strong> {{ $achievement->participant }}</p>
                                        @endif
                                        @if($achievement->organizer)
                                            <p class="text-muted mb-1"><strong>Penyelenggara:</strong> {{ $achievement->organizer }}</p>
                                        @endif
                                        <small><i class="fas fa-calendar me-1"></i> 
                                            @if($achievement->achievement_date)
                                                {{ $achievement->achievement_date->format('d F Y') }}
                                            @else
                                                {{ $achievement->year }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <span class="badge bg-{{ $achievement->level_badge_color }} fs-6 mb-2">{{ $achievement->level_formatted }}</span>
                                        @if($achievement->position)
                                            <br><span class="badge bg-{{ $achievement->position_badge_color }} fs-6">{{ $achievement->position_formatted }}</span>
                                        @endif
                                        <br><small class="text-muted">{{ $achievement->category_formatted }}</small>
                                    </div>
                                </div>
                                @if($achievement->image)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <img src="{{ asset('storage/' . $achievement->image) }}" 
                                                 alt="{{ $achievement->title }}" 
                                                 class="img-fluid rounded" 
                                                 style="max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Default achievements if none are set -->
                    <div class="card shadow mb-3 fade-in-left" style="animation-delay: 0.2s;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <div class="achievement-badge bg-warning text-white scale-in" style="animation-delay: 0.4s;">
                                        <i class="fas fa-medal fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mb-1">Juara 1 Olimpiade Sains Nasional 2024</h5>
                                    <p class="text-muted mb-1">Bidang Matematika - Tingkat Nasional</p>
                                    <small><i class="fas fa-calendar me-1"></i> Agustus 2024</small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <span class="badge bg-warning fs-6">Nasional</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-3 fade-in-left" style="animation-delay: 0.4s;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <div class="achievement-badge bg-success text-white scale-in" style="animation-delay: 0.6s;">
                                        <i class="fas fa-leaf fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mb-1">Sekolah Adiwiyata Tingkat Provinsi</h5>
                                    <p class="text-muted mb-1">Penghargaan sekolah berwawasan lingkungan</p>
                                    <small><i class="fas fa-calendar me-1"></i> Juni 2024</small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <span class="badge bg-success fs-6">Provinsi</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-3 fade-in-left" style="animation-delay: 0.6s;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <div class="achievement-badge bg-info text-white scale-in" style="animation-delay: 0.8s;">
                                        <i class="fas fa-comments fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mb-1">Juara Umum Debat Bahasa Inggris</h5>
                                    <p class="text-muted mb-1">English Debate Competition 2024</p>
                                    <small><i class="fas fa-calendar me-1"></i> Juli 2024</small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <span class="badge bg-info fs-6">Kota</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <a href="{{ route('public.achievements') }}" class="btn btn-primary-enhanced btn-enhanced fade-in-left" style="animation-delay: 0.8s;">
                    <i class="fas fa-arrow-right me-2"></i>Lihat Semua Prestasi
                </a>
            </div>

            <!-- School Info Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow mb-4 fade-in-right">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-building me-2"></i>Informasi Sekolah</h5>
                    </div>
                    <div class="card-body">
                        @if($profile->established_year)
                            <div class="info-item mb-3 fade-in-up" style="animation-delay: 0.2s;">
                                <div class="d-flex">
                                    <i class="fas fa-calendar-plus fa-lg text-primary me-3 mt-1"></i>
                                    <div>
                                        <strong>Tahun Berdiri</strong><br>
                                        <span class="text-muted">{{ $profile->established_year_formatted }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($profile->accreditation)
                            <div class="info-item mb-3 fade-in-up" style="animation-delay: 0.4s;">
                                <div class="d-flex">
                                    <i class="fas fa-award fa-lg text-success me-3 mt-1"></i>
                                    <div>
                                        <strong>Akreditasi</strong><br>
                                        <span class="text-muted">{{ $profile->accreditation }} ({{ $profile->accreditation === 'A' ? 'Unggul' : ($profile->accreditation === 'B' ? 'Baik' : 'Cukup') }})</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($principal)
                            <div class="info-item mb-3 fade-in-up" style="animation-delay: 0.6s;">
                                <div class="d-flex">
                                    <i class="fas fa-user-tie fa-lg text-warning me-3 mt-1"></i>
                                    <div>
                                        <strong>Kepala Sekolah</strong><br>
                                        <span class="text-muted">{{ $principal->name }}</span>
                                        @if($principal->education)
                                            <br><small class="text-muted">{{ $principal->education }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif($profile->principal_name)
                            <div class="info-item mb-3 fade-in-up" style="animation-delay: 0.6s;">
                                <div class="d-flex">
                                    <i class="fas fa-user-tie fa-lg text-warning me-3 mt-1"></i>
                                    <div>
                                        <strong>Kepala Sekolah</strong><br>
                                        <span class="text-muted">{{ $profile->principal_name }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($profile->programs && count($profile->programs) > 0)
                            <div class="info-item mb-3 fade-in-up" style="animation-delay: 0.8s;">
                                <div class="d-flex">
                                    <i class="fas fa-graduation-cap fa-lg text-info me-3 mt-1"></i>
                                    <div>
                                        <strong>Program Studi</strong><br>
                                        <span class="text-muted">{{ implode(', ', $profile->programs) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($profile->address)
                            <div class="info-item fade-in-up" style="animation-delay: 1.0s;">
                                <div class="d-flex">
                                    <i class="fas fa-map-marker-alt fa-lg text-danger me-3 mt-1"></i>
                                    <div>
                                        <strong>Alamat</strong><br>
                                        <span class="text-muted">{{ $profile->address }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="card shadow fade-in-right" style="animation-delay: 0.2s;">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Kontak</h5>
                    </div>
                    <div class="card-body">
                        @if($profile->phone)
                            <div class="contact-item mb-3 fade-in-up" style="animation-delay: 0.4s;">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <strong>Telepon:</strong><br>
                                <span class="ms-4">{{ $profile->phone }}</span>
                            </div>
                        @endif
                        
                        @if($profile->email)
                            <div class="contact-item mb-3 fade-in-up" style="animation-delay: 0.6s;">
                                <i class="fas fa-envelope text-success me-2"></i>
                                <strong>Email:</strong><br>
                                <span class="ms-4">{{ $profile->email }}</span>
                            </div>
                        @endif
                        
                        @if($profile->website)
                            <div class="contact-item mb-3 fade-in-up" style="animation-delay: 0.8s;">
                                <i class="fas fa-globe text-info me-2"></i>
                                <strong>Website:</strong><br>
                                <span class="ms-4">{{ $profile->website }}</span>
                            </div>
                        @endif
                        
                        @if($profile->social_media_links && count($profile->social_media_links) > 0)
                            <div class="mt-4">
                                <div class="d-flex justify-content-center gap-3 fade-in-up" style="animation-delay: 1.0s;">
                                    @foreach($profile->social_media_links as $platform => $social)
                                        <a href="{{ $social['url'] }}" target="_blank" class="text-primary scale-in" style="animation-delay: {{ 1.2 + ($loop->index * 0.2) }}s;">
                                            <i class="{{ $social['icon'] }} fa-lg"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Section -->
<section class="py-5">
    <div class="container">
        @if($principal)
            <div class="row mb-5">
                <div class="col-md-8 mx-auto text-center">
                    <h2 class="mb-3 section-heading fade-in-up">Kepala Sekolah</h2>
                    <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Pemimpin yang berpengalaman dalam mengelola institusi pendidikan</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow text-center h-100 fade-in-up">
                        <div class="card-body p-4">
                            @if($principal->photo)
                                <img src="{{ asset('storage/' . $principal->photo) }}" alt="{{ $principal->name }}" 
                                     class="leadership-avatar rounded-circle mx-auto mb-3 scale-in" 
                                     style="animation-delay: 0.2s; width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="leadership-avatar bg-primary text-white rounded-circle mx-auto mb-3 scale-in"
                                    style="animation-delay: 0.2s; width: 150px; height: 150px; display: flex; align-items: center; justify-content: center;">
                                    @if($principal->initials)
                                        <span style="font-size: 3rem; font-weight: bold;">{{ $principal->initials }}</span>
                                    @else
                                        <i class="fas fa-user fa-3x"></i>
                                    @endif
                                </div>
                            @endif
                            <h4 class="mb-2">{{ $principal->name }}</h4>
                            <p class="text-primary fw-bold mb-3">{{ $principal->position }}</p>
                            
                            <!-- Principal Information -->
                            <div class="row mt-4">
                                @if($principal->education)
                                    <div class="col-12 mb-3">
                                        <div class="info-item text-start">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-graduation-cap fa-lg text-primary me-3"></i>
                                                <div>
                                                    <strong>Pendidikan</strong><br>
                                                    <span class="text-muted">{{ $principal->education }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($principal->nip)
                                    <div class="col-12 mb-3">
                                        <div class="info-item text-start">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-id-card fa-lg text-success me-3"></i>
                                                <div>
                                                    <strong>NIP</strong><br>
                                                    <span class="text-muted">{{ $principal->nip }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($principal->phone)
                                    <div class="col-12 mb-3">
                                        <div class="info-item text-start">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-phone fa-lg text-info me-3"></i>
                                                <div>
                                                    <strong>Telepon</strong><br>
                                                    <span class="text-muted">{{ $principal->phone }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($principal->subject)
                                    <div class="col-12 mb-3">
                                        <div class="info-item text-start">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-book fa-lg text-warning me-3"></i>
                                                <div>
                                                    <strong>Bidang Keahlian</strong><br>
                                                    <span class="text-muted">{{ $principal->subject }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('public.teachers.show', $principal->id) }}" class="btn btn-primary btn-enhanced">
                                    <i class="fas fa-user me-2"></i>Lihat Profil Lengkap
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($profile->principal_name)
            <!-- Fallback to profile data if no principal in database -->
            <div class="row mb-5">
                <div class="col-md-8 mx-auto text-center">
                    <h2 class="mb-3 section-heading fade-in-up">Kepala Sekolah</h2>
                    <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Pemimpin yang berpengalaman dalam mengelola institusi pendidikan</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow text-center h-100 fade-in-up">
                        <div class="card-body p-4">
                            @if($profile->principal_photo)
                                <img src="{{ asset($profile->principal_photo) }}" alt="{{ $profile->principal_name }}" 
                                     class="leadership-avatar rounded-circle mx-auto mb-3 scale-in" 
                                     style="animation-delay: 0.2s; width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="leadership-avatar bg-primary text-white rounded-circle mx-auto mb-3 scale-in"
                                    style="animation-delay: 0.2s; width: 120px; height: 120px;">
                                    <i class="fas fa-user fa-3x"></i>
                                </div>
                            @endif
                            <h4 class="mb-2">{{ $profile->principal_name }}</h4>
                            <p class="text-primary fw-bold mb-3">Kepala Sekolah</p>
                            <p class="text-muted small">{{ $profile->school_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Call to Action -->
<!-- <section class="cta-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-center text-lg-start">
                <h3 class="text-white mb-3 fade-in-left">{{ $profile->cta_title ?? 'Tertarik untuk bergabung dengan ' . $profile->school_name . '?' }}</h3>
                <p class="text-white mb-4 fade-in-left" style="animation-delay: 0.2s;">{{ $profile->cta_description ?? 'Daftarkan diri Anda sekarang dan jadilah bagian dari keluarga besar ' . $profile->school_name }}</p>
            </div>
            <div class="col-lg-4 text-center">
                <a href="{{ $profile->cta_button_url ?? '#' }}" class="btn btn-light btn-lg px-4 py-2 btn-enhanced scale-in" style="animation-delay: 0.4s;">
                    <i class="fas fa-user-plus me-2"></i>{{ $profile->cta_button_text ?? 'Daftar Sekarang' }}
                </a>
            </div>
        </div>
    </div>
</section> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Counter Animation Function (matching home page)
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
    
    // Enhanced card hover effects
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (!this.style.transform.includes('scale')) {
                this.style.transform = this.style.transform + ' scale(1.02)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = this.style.transform.replace(' scale(1.02)', '');
        });
    });
    
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            // Skip if href is just '#' or empty
            if (!href || href === '#' || href.length <= 1) {
                return;
            }
            
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading animation to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.href && !this.href.includes('#')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 3000);
            }
        });
    });
    
    // Parallax effect for hero section
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero-section');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
        ticking = false;
    }
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    });
    
    // Add stagger effect to timeline items
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.2}s`;
    });
    
    // Page load animation sequence
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 100);
    
    console.log('Enhanced profile page animations loaded successfully!');
});
</script>
@endsection