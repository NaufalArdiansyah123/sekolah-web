@extends('layouts.public')

@section('title', $history ? $history->meta_title ?? $history->title : 'Sejarah Sekolah')
@section('meta_description', $history ? $history->meta_description ?? 'Sejarah dan perjalanan sekolah kami' : 'Sejarah dan perjalanan sekolah kami')

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
    
    /* Enhanced Hero Section matching profile page */
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
    
    /* Enhanced Stats Section matching profile page */
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

    /* Enhanced Cards matching profile page style */
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

    /* Milestone and Achievement Cards */
    .milestone-card, .achievement-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 20px;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        position: relative;
        margin-bottom: 2rem;
    }
    
    .milestone-card::before, .achievement-card::before {
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
    
    .milestone-card:hover::before, .achievement-card:hover::before {
        opacity: 1;
    }
    
    .milestone-card:hover, .achievement-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }

    .milestone-icon, .achievement-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 1rem;
        transition: all 0.3s ease;
    }

    .milestone-card:hover .milestone-icon,
    .achievement-card:hover .achievement-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .achievement-badges {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        flex-wrap: wrap;
    }

    .achievement-badge-small {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .achievement-badge-small.level {
        background: rgba(37, 99, 235, 0.1);
        color: var(--secondary-color);
    }

    .achievement-badge-small.category {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    /* Color classes */
    .bg-primary-custom { background: var(--secondary-color) !important; }
    .bg-success-custom { background: #10b981 !important; }
    .bg-warning-custom { background: #f59e0b !important; }
    .bg-danger-custom { background: #ef4444 !important; }
    .bg-info-custom { background: #06b6d4 !important; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--dark-gray);
    }

    .empty-icon {
        width: 4rem;
        height: 4rem;
        background: var(--light-gray);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--dark-gray);
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .empty-message {
        color: var(--dark-gray);
        line-height: 1.6;
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

@if($history)
    <!-- Enhanced Hero Section -->
    @php
        $heroImageUrl = '';
        if ($history->hero_image) {
            // Handle different path formats
            if (str_starts_with($history->hero_image, 'storage/')) {
                $heroImageUrl = asset($history->hero_image);
            } elseif (str_starts_with($history->hero_image, 'http')) {
                $heroImageUrl = $history->hero_image;
            } else {
                $heroImageUrl = asset('storage/' . $history->hero_image);
            }
        }
    @endphp

    <section class="hero-section {{ $history->hero_image ? 'with-image' : '' }}" 
             @if($history->hero_image) 
             style="--hero-image: url('{{ $heroImageUrl }}'); 
                    background-image: linear-gradient(135deg, rgba(26, 32, 44, 0.8) 0%, rgba(49, 130, 206, 0.7) 50%, rgba(26, 32, 44, 0.8) 100%), url('{{ $heroImageUrl }}') !important;
                    background-size: cover !important;
                    background-position: center !important;
                    background-repeat: no-repeat !important;" 
             @endif>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fade-in-left">{{ $history->hero_title ?? $history->title }}</h1>
                    <p class="lead fade-in-left" style="animation-delay: 0.2s;">{{ $history->hero_subtitle ?? 'Perjalanan panjang dalam membangun pendidikan berkualitas dan membentuk generasi yang berkarakter.' }}</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-history hero-icon scale-in" style="animation-delay: 0.4s;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Quick Stats -->
    @if($history->timeline_events || $history->milestones || $history->achievements)
        <section class="stats-section">
            <div class="container">
                <div class="section-title">
                    <h2 class="section-heading fade-in-up">Sejarah dalam Angka</h2>
                    <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Pencapaian dan perjalanan yang membanggakan</p>
                </div>
                <div class="row text-center g-4">
                    @if($history->timeline_events && count($history->timeline_events) > 0)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="stats-card card h-100 shadow-sm fade-in-up">
                                <div class="card-body p-4">
                                    <div class="stats-icon-wrapper mb-3">
                                        <i class="fas fa-calendar-alt fa-3x text-primary stats-icon"></i>
                                    </div>
                                    <h2 class="stats-number display-4 fw-bold text-primary mb-2" data-target="{{ count($history->timeline_events) }}">0</h2>
                                    <p class="stats-label text-muted mb-0 fw-medium">PERISTIWA BERSEJARAH</p>
                                    <div class="stats-bar bg-primary"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($history->milestones && count($history->milestones) > 0)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                                <div class="card-body p-4">
                                    <div class="stats-icon-wrapper mb-3">
                                        <i class="fas fa-star fa-3x text-success stats-icon"></i>
                                    </div>
                                    <h2 class="stats-number display-4 fw-bold text-success mb-2" data-target="{{ count($history->milestones) }}">0</h2>
                                    <p class="stats-label text-muted mb-0 fw-medium">TONGGAK SEJARAH</p>
                                    <div class="stats-bar bg-success"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($history->achievements && count($history->achievements) > 0)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                                <div class="card-body p-4">
                                    <div class="stats-icon-wrapper mb-3">
                                        <i class="fas fa-trophy fa-3x text-warning stats-icon"></i>
                                    </div>
                                    <h2 class="stats-number display-4 fw-bold text-warning mb-2" data-target="{{ count($history->achievements) }}">0</h2>
                                    <p class="stats-label text-muted mb-0 fw-medium">PRESTASI BERSEJARAH</p>
                                    <div class="stats-bar bg-warning"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- History Content -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-5">
                    <div class="card shadow h-100 fade-in-up">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-book-open me-2"></i>{{ $history->title }}</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="history-text" style="font-size: 1.1rem; line-height: 1.8; white-space: pre-wrap;">{{ $history->content }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Events -->
    @if($history->timeline_events && count($history->timeline_events) > 0)
        <section class="py-5">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-8 mx-auto text-center">
                        <h2 class="mb-3 section-heading fade-in-up">Timeline Perjalanan</h2>
                        <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Peristiwa-peristiwa penting dalam sejarah sekolah</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="timeline">
                            @foreach($history->timeline_events_formatted as $index => $event)
                                <div class="timeline-item fade-in-up" style="animation-delay: {{ ($index + 1) * 0.2 }}s;">
                                    <div class="timeline-marker bg-{{ $event['color'] ?? 'primary' }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold text-{{ $event['color'] ?? 'primary' }}">
                                            {{ $event['year'] }} - {{ $event['title'] }}
                                        </h6>
                                        @if($event['type'])
                                            <span class="badge bg-{{ $event['color'] ?? 'primary' }} mb-2">{{ ucfirst($event['type']) }}</span>
                                        @endif
                                        @if($event['description'])
                                            <p class="mb-2">{{ $event['description'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Milestones Section -->
    @if($history->milestones && count($history->milestones) > 0)
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-8 mx-auto text-center">
                        <h2 class="mb-3 section-heading fade-in-up">Tonggak Sejarah</h2>
                        <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Pencapaian-pencapaian penting dalam perjalanan sekolah</p>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($history->milestones_formatted as $index => $milestone)
                        <div class="col-md-6 col-lg-4">
                            <div class="milestone-card card shadow h-100 fade-in-up" style="animation-delay: {{ ($index + 1) * 0.2 }}s;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="milestone-icon bg-{{ $milestone['color'] ?? 'primary' }}-custom">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{ $milestone['title'] }}</h5>
                                            <small class="text-muted">{{ $milestone['year'] }}</small>
                                        </div>
                                    </div>
                                    @if($milestone['description'])
                                        <p class="text-muted">{{ $milestone['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Achievements Section -->
    @if($history->achievements && count($history->achievements) > 0)
        <section class="py-5">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-8 mx-auto text-center">
                        <h2 class="mb-3 section-heading fade-in-up">Prestasi Bersejarah</h2>
                        <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Pencapaian membanggakan yang telah diraih sekolah</p>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($history->achievements_formatted as $index => $achievement)
                        <div class="col-md-6 col-lg-4">
                            <div class="achievement-card card shadow h-100 fade-in-up" style="animation-delay: {{ ($index + 1) * 0.2 }}s;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="achievement-icon bg-{{ $achievement['color'] ?? 'primary' }}-custom">
                                            <i class="fas fa-trophy"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="achievement-badges">
                                                <span class="achievement-badge-small level">{{ $achievement['level'] }}</span>
                                                <span class="achievement-badge-small category">{{ $achievement['category'] }}</span>
                                            </div>
                                            <h5 class="mb-1">{{ $achievement['title'] }}</h5>
                                            <small class="text-muted">{{ $achievement['year'] }}</small>
                                        </div>
                                    </div>
                                    @if($achievement['description'])
                                        <p class="text-muted">{{ $achievement['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@else
    <!-- No History Available -->
    <section class="py-5">
        <div class="container">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-history fa-2x"></i>
                </div>
                <h2 class="empty-title">Sejarah Belum Tersedia</h2>
                <p class="empty-message">
                    Informasi sejarah sekolah sedang dalam proses penyusunan.<br>
                    Silakan kunjungi halaman ini lagi nanti.
                </p>
            </div>
        </div>
    </section>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Counter Animation Function (matching profile page)
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
    
    // Add stagger effect to timeline items
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.2}s`;
    });
    
    // Page load animation sequence
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 100);
    
    console.log('Enhanced history page animations loaded successfully!');
});
</script>
@endsection