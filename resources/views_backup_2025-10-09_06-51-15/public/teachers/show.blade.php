@extends('layouts.public')

@section('title', $teacher->name . ' - Profil Guru - SMA Negeri 99')

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
    .teacher-profile-hero {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        color: white;
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .teacher-profile-hero::before {
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

    .hero-teacher-info {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .hero-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .hero-photo-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
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

    .hero-position {
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

    /* Enhanced Profile Section */
    .profile-section {
        padding: 80px 0;
        background: var(--light-gray);
    }

    .profile-container {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 3rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Enhanced Sidebar */
    .profile-sidebar {
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

    .profile-sidebar:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }

    .profile-photo-container {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e5e7eb;
        margin-bottom: 1rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .profile-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
    }

    .profile-photo-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-weight: 600;
        font-size: 3rem;
        border: 4px solid #e5e7eb;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .profile-photo-placeholder:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .profile-position {
        color: var(--secondary-color);
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    /* Enhanced Contact Info */
    .contact-info {
        margin-bottom: 2rem;
    }

    .section-title {
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

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: var(--light-gray);
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .contact-item:hover {
        background: rgba(49, 130, 206, 0.05);
        transform: translateX(4px);
        border-color: rgba(49, 130, 206, 0.2);
    }

    .contact-icon {
        width: 16px;
        height: 16px;
        color: var(--secondary-color);
        flex-shrink: 0;
    }

    .contact-text {
        color: var(--dark-gray);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Enhanced Subjects Section */
    .subjects-section {
        margin-bottom: 2rem;
    }

    .subject-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .subject-tag {
        background: rgba(49, 130, 206, 0.1);
        color: var(--secondary-color);
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid rgba(49, 130, 206, 0.2);
        transition: all 0.3s ease;
    }

    .subject-tag:hover {
        background: rgba(49, 130, 206, 0.2);
        transform: translateY(-2px);
    }

    /* Enhanced Main Content */
    .profile-main {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .profile-main:hover {
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

    /* Enhanced Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .info-card {
        background: var(--light-gray);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .info-card:hover::before {
        transform: scaleX(1);
    }

    .info-card:hover {
        background: white;
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: rgba(49, 130, 206, 0.2);
    }

    .info-card-title {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card-content {
        color: var(--dark-gray);
        line-height: 1.6;
        font-weight: 500;
    }

    /* Enhanced Related Teachers */
    .related-teachers {
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

    .related-photo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1rem;
        border: 3px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .related-card:hover .related-photo {
        transform: scale(1.1);
        border-color: var(--secondary-color);
    }

    .related-photo-placeholder {
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

    .related-card:hover .related-photo-placeholder {
        transform: scale(1.1);
        border-color: var(--secondary-color);
    }

    .related-name {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .related-position {
        color: var(--dark-gray);
        font-size: 0.875rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .teacher-profile-hero {
            padding: 60px 0;
        }

        .hero-teacher-info {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .hero-details h1 {
            font-size: 2rem;
        }

        .profile-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .profile-sidebar {
            position: static;
            order: 2; /* Move sidebar below main content on mobile */
        }

        .profile-main {
            order: 1; /* Show main content first on mobile */
        }

        .info-grid {
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
<section class="teacher-profile-hero">
    <div class="container">
        <div class="hero-content">
            <!-- Breadcrumb -->
            <nav class="breadcrumb fade-in-up">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('public.teachers.index') }}">Guru & Staff</a>
                <span class="breadcrumb-separator">/</span>
                <span>{{ $teacher->name }}</span>
            </nav>

            <div class="d-flex justify-content-between align-items-start">
                <div class="hero-teacher-info fade-in-left">
                    @if($teacher->photo)
                        <img src="{{ asset('storage/' . $teacher->photo) }}" 
                             alt="{{ $teacher->name }}" 
                             class="hero-photo">
                    @else
                        <div class="hero-photo-placeholder">
                            {{ $teacher->initials }}
                        </div>
                    @endif
                    <div class="hero-details">
                        <h1>{{ $teacher->name }}</h1>
                        <p class="hero-position">{{ $teacher->position }}</p>
                        @if($teacher->nip)
                            <p style="opacity: 0.8; font-size: 0.9rem;">NIP: {{ $teacher->nip }}</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('public.teachers.index') }}" class="back-button fade-in-right">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Guru
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Profile Section -->
<section class="profile-section">
    <div class="container">
        <div class="profile-container">
            <!-- Enhanced Sidebar -->
            <div class="profile-sidebar fade-in-left">
                <div class="profile-photo-container">
                    @if($teacher->photo)
                        <img src="{{ asset('storage/' . $teacher->photo) }}" 
                             alt="{{ $teacher->name }}" 
                             class="profile-photo">
                    @else
                        <div class="profile-photo-placeholder">
                            {{ $teacher->initials }}
                        </div>
                    @endif
                    <h2 class="profile-name">{{ $teacher->name }}</h2>
                    <p class="profile-position">{{ $teacher->position }}</p>
                </div>

                <!-- Enhanced Contact Information -->
                <div class="contact-info">
                    <h3 class="section-title">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Informasi Kontak
                    </h3>
                    
                    @if($teacher->email)
                        <div class="contact-item">
                            <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="contact-text">{{ $teacher->email }}</span>
                        </div>
                    @endif

                    @if($teacher->phone)
                        <div class="contact-item">
                            <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="contact-text">{{ $teacher->phone }}</span>
                        </div>
                    @endif

                    @if($teacher->nip)
                        <div class="contact-item">
                            <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            <span class="contact-text">NIP: {{ $teacher->nip }}</span>
                        </div>
                    @endif

                    @if($teacher->address)
                        <div class="contact-item">
                            <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="contact-text">{{ $teacher->address }}</span>
                        </div>
                    @endif
                </div>

                <!-- Enhanced Subjects Taught -->
                <div class="subjects-section">
                    <h3 class="section-title">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Mata Pelajaran
                    </h3>
                    <div class="subject-tags">
                        @foreach(explode(',', $teacher->subject) as $subject)
                            <span class="subject-tag">{{ trim($subject) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Enhanced Main Content -->
            <div class="profile-main fade-in-right">
                <h2 class="main-title">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil Lengkap
                </h2>

                <div class="info-grid">
                    @if($teacher->education)
                        <div class="info-card fade-in-up">
                            <h3 class="info-card-title">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                </svg>
                                Latar Belakang Pendidikan
                            </h3>
                            <p class="info-card-content">{{ $teacher->education }}</p>
                        </div>
                    @endif

                    <div class="info-card fade-in-up" style="animation-delay: 0.2s;">
                        <h3 class="info-card-title">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                            </svg>
                            Posisi Jabatan
                        </h3>
                        <p class="info-card-content">{{ $teacher->position }}</p>
                    </div>

                    <div class="info-card fade-in-up" style="animation-delay: 0.4s;">
                        <h3 class="info-card-title">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Status Kepegawaian
                        </h3>
                        <p class="info-card-content">
                            <span style="color: #10b981; font-weight: 600;">{{ ucfirst($teacher->status) }}</span>
                        </p>
                    </div>

                    <div class="info-card fade-in-up" style="animation-delay: 0.6s;">
                        <h3 class="info-card-title">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Bidang Keahlian
                        </h3>
                        <p class="info-card-content">{{ $teacher->subject }}</p>
                    </div>
                </div>

                <!-- Enhanced Related Teachers -->
                @if($relatedTeachers->count() > 0)
                    <div class="related-teachers">
                        <h3 class="related-title fade-in-up">Guru Lain dengan Bidang Serupa</h3>
                        <div class="related-grid">
                            @foreach($relatedTeachers as $index => $relatedTeacher)
                                <a href="{{ route('public.teachers.show', $relatedTeacher->id) }}" 
                                   class="related-card fade-in-up" 
                                   style="animation-delay: {{ $index * 0.1 }}s;">
                                    @if($relatedTeacher->photo)
                                        <img src="{{ asset('storage/' . $relatedTeacher->photo) }}" 
                                             alt="{{ $relatedTeacher->name }}" 
                                             class="related-photo">
                                    @else
                                        <div class="related-photo-placeholder">
                                            {{ $relatedTeacher->initials }}
                                        </div>
                                    @endif
                                    <h4 class="related-name">{{ $relatedTeacher->name }}</h4>
                                    <p class="related-position">{{ $relatedTeacher->position }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
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

    // Enhanced contact item hover effects
    const contactItems = document.querySelectorAll('.contact-item');
    contactItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0) scale(1)';
        });
    });

    // Enhanced info card hover effects
    const infoCards = document.querySelectorAll('.info-card');
    infoCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
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

    // Enhanced subject tag interactions
    const subjectTags = document.querySelectorAll('.subject-tag');
    subjectTags.forEach(tag => {
        tag.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.05)';
        });
        
        tag.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Parallax effect for hero section
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.teacher-profile-hero');
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

    // Enhanced sidebar sticky behavior
    const sidebar = document.querySelector('.profile-sidebar');
    const main = document.querySelector('.profile-main');
    
    if (sidebar && main) {
        window.addEventListener('scroll', function() {
            const sidebarRect = sidebar.getBoundingClientRect();
            const mainRect = main.getBoundingClientRect();
            
            if (sidebarRect.top <= 100) {
                sidebar.style.transform = 'translateY(0) scale(0.98)';
            } else {
                sidebar.style.transform = 'translateY(0) scale(1)';
            }
        });
    }

    // Add loading animation to related teacher links
    relatedCards.forEach(card => {
        card.addEventListener('click', function() {
            const originalContent = this.innerHTML;
            this.style.opacity = '0.6';
            this.style.pointerEvents = 'none';
            
            setTimeout(() => {
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
            }, 1000);
        });
    });

    // Enhanced photo hover effects
    const photos = document.querySelectorAll('.profile-photo, .profile-photo-placeholder, .hero-photo, .hero-photo-placeholder');
    photos.forEach(photo => {
        photo.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1) rotate(2deg)';
        });
        
        photo.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    });

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
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

    console.log('Enhanced teacher profile page animations loaded successfully!');
});
</script>
@endsection