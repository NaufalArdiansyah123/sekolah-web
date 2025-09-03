@extends('layouts.public')

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
    
    /* Enhanced Hero Section with Background Image */
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2032&q=80') center/cover no-repeat;
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
        font-size: 10rem;
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
    
    /* Alternative Background Images - You can uncomment one of these */
    /*
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2064&q=80') center/cover no-repeat;
    }
    */
    
    /*
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
    }
    */
    
    /*
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80') center/cover no-repeat;
    }
    */
    
    /* Enhanced Buttons */
    .btn-hero {
        padding: 15px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        border: none;
        backdrop-filter: blur(10px);
    }
    
    .btn-hero-primary {
        background: rgba(255,255,255,0.95);
        color: var(--primary-color);
    }
    
    .btn-hero-primary:hover {
        background: white;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        color: var(--primary-color);
    }
    
    .btn-hero-outline {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.8);
    }
    
    .btn-hero-outline:hover {
        background: rgba(255,255,255,0.2);
        border-color: white;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(255,255,255,0.2);
    }
    
    /* Enhanced Stats Cards with Counting Animation */
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
        box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
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
    
    /* Counter Animation Keyframes */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .stats-number.counting {
        animation: countUp 0.6s ease-out;
    }
    
    /* Enhanced Featured Content */
    .featured-section {
        padding: 80px 0;
        background: white;
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    
    .section-title p {
        color: var(--dark-gray);
        font-size: 1.1rem;
    }
    
    .news-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    .news-image {
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .news-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.8s ease;
    }
    
    .news-card:hover .news-image::before {
        transform: translateX(100%);
    }
    
    .news-image i {
        font-size: 3rem;
        color: white;
        z-index: 2;
        position: relative;
    }
    
    .sidebar-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .sidebar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
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
    
    /* Enhanced Features Section */
    .features-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        position: relative;
    }
    
    .feature-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .feature-card::before {
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
    
    .feature-card:hover::before {
        opacity: 1;
    }
    
    .feature-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }
    
    .feature-card i {
        margin-bottom: 25px;
        padding: 25px;
        border-radius: 50%;
        background: var(--gradient-light);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 2;
    }
    
    .feature-card:hover i {
        transform: scale(1.2) rotate(10deg);
        background: linear-gradient(135deg, rgba(49, 130, 206, 0.2), rgba(66, 153, 225, 0.1));
    }
    
    .feature-card h5 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
    }
    
    .feature-card p {
        color: var(--dark-gray);
        line-height: 1.6;
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
        
        .stats-card {
            margin-bottom: 30px;
        }
        
        .btn-hero {
            width: 100%;
            margin-bottom: 15px;
        }
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
</style>

<!-- Enhanced Hero Section with School Activity Background -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="fade-in-up">Selamat Datang di SMA Negeri 1 Balong</h1>
                <p class="lead fade-in-up">Excellence in Education - Membentuk generasi yang berkarakter, berprestasi, dan siap menghadapi masa depan.</p>
                <div class="fade-in-up">
                    <a href="{{ route('about.profile') }}" class="btn btn-hero btn-hero-primary me-3">
                        <i class="fas fa-info-circle me-2"></i>Tentang Kami
                    </a>
                    <a href="{{ route('news.index') }}" class="btn btn-hero btn-hero-outline">
                        <i class="fas fa-newspaper me-2"></i>Berita Terkini
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-school hero-icon"></i>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Quick Stats with Counting Animation -->
<section class="stats-section">
    <div class="container">
        <div class="section-title">
            <h2>SMA Negeri 1 Balong</h2>
            <p>Pencapaian dan prestasi yang membanggakan</p>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-users fa-3x text-primary stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-primary mb-2" data-target="2400">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">JUMLAH SISWA 2019</p>
                        <div class="stats-bar bg-primary"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-chalkboard-teacher fa-3x text-success stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-success mb-2" data-target="120">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">JUMLAH GURU</p>
                        <div class="stats-bar bg-success"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-user-tie fa-3x text-warning stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-warning mb-2" data-target="40">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">JUMLAH KARYAWAN</p>
                        <div class="stats-bar bg-warning"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-handshake fa-3x text-info stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-info mb-2" data-target="110">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">KERJA SAMA INDUSTRI</p>
                        <div class="stats-bar bg-info"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Featured Content -->
<section class="featured-section">
    <div class="container">
        <div class="row">
            <!-- Berita Terbaru -->
            <div class="col-md-8 mb-4">
                <div class="section-title text-start">
                    <h2><i class="fas fa-newspaper me-3"></i>Berita Terbaru</h2>
                    <p>Informasi terkini seputar kegiatan dan prestasi sekolah</p>
                </div>
                
                <div class="news-card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="news-image bg-primary">
                                <i class="fas fa-image"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold">Penerimaan Siswa Baru 2024/2025</h5>
                                <p class="card-text">Pendaftaran siswa baru telah dibuka dengan sistem online. Daftar sekarang untuk bergabung dengan keluarga besar SMA Negeri 1.</p>
                                <p class="card-text"><small class="text-muted">2 jam yang lalu</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="news-card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="news-image bg-success">
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold">Juara 1 Olimpiade Matematika Tingkat Provinsi</h5>
                                <p class="card-text">Siswa SMA Negeri 1 berhasil meraih juara 1 dalam kompetisi olimpiade matematika tingkat provinsi.</p>
                                <p class="card-text"><small class="text-muted">1 hari yang lalu</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('news.index') }}" class="btn btn-primary-enhanced btn-enhanced">
                    <i class="fas fa-arrow-right me-2"></i>Lihat Semua Berita
                </a>
            </div>

            <!-- Enhanced Sidebar -->
            <div class="col-md-4">
                <!-- Pengumuman -->
                <div class="sidebar-card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Pengumuman</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3 p-3 bg-light rounded">
                                <strong>Libur Semester</strong><br>
                                <small class="text-muted">Libur semester dimulai tanggal 15 Desember 2024</small>
                            </li>
                            <li class="mb-3 p-3 bg-light rounded">
                                <strong>Ujian Tengah Semester</strong><br>
                                <small class="text-muted">UTS akan dilaksanakan tanggal 1-8 November 2024</small>
                            </li>
                            <li class="p-3 bg-light rounded">
                                <strong>Rapat Orang Tua</strong><br>
                                <small class="text-muted">Rapat komite sekolah, Sabtu 28 Oktober 2024</small>
                            </li>
                        </ul>
                        <a href="{{ route('announcements.index') }}" class="btn btn-outline-warning btn-enhanced mt-3">
                            <i class="fas fa-eye me-2"></i>Lihat Semua
                        </a>
                    </div>
                </div>

                <!-- Agenda -->
                <div class="sidebar-card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Agenda</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3 p-3 bg-light rounded">
                                <strong>25 Oktober 2024</strong><br>
                                <small>Peringatan Hari Sumpah Pemuda</small>
                            </li>
                            <li class="mb-3 p-3 bg-light rounded">
                                <strong>31 Oktober 2024</strong><br>
                                <small>Workshop Teknologi Pendidikan</small>
                            </li>
                            <li class="p-3 bg-light rounded">
                                <strong>5 November 2024</strong><br>
                                <small>Festival Seni dan Budaya</small>
                            </li>
                        </ul>
                        <a href="{{ route('agenda.index') }}" class="btn btn-outline-info btn-enhanced mt-3">
                            <i class="fas fa-calendar-check me-2"></i>Lihat Agenda
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="sidebar-card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-link me-2"></i>Quick Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('downloads.index') }}" class="btn btn-outline-secondary btn-enhanced">
                                <i class="fas fa-download me-2"></i>Download
                            </a>

                           <a href="{{ route('gallery.photos.index') }}" class="btn btn-outline-secondary btn-enhanced">
    <i class="fas fa-images me-2"></i>Galeri
</a>




                            </a>
                            <a href="{{ route('extracurriculars.index') }}" class="btn btn-outline-secondary btn-enhanced">
                                <i class="fas fa-users me-2"></i>Ekstrakurikuler
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-primary-enhanced btn-enhanced">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-title">
            <h2>Fitur Unggulan</h2>
            <p>Teknologi dan inovasi untuk pendidikan yang lebih baik</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card fade-in-up">
                    <i class="fas fa-laptop-code fa-3x text-primary"></i>
                    <h5>Learning Management System</h5>
                    <p>Platform pembelajaran digital dengan materi online, tugas, dan ujian CBT untuk pengalaman belajar yang modern dan interaktif.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card fade-in-up">
                    <i class="fas fa-qrcode fa-3x text-success"></i>
                    <h5>Absensi QR Code</h5>
                    <p>Sistem absensi modern menggunakan QR Code untuk efisiensi dan akurasi data kehadiran siswa dan guru.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card fade-in-up">
                    <i class="fas fa-chart-bar fa-3x text-info"></i>
                    <h5>Analitik Akademik</h5>
                    <p>Dashboard analitik komprehensif untuk monitoring progress akademik siswa secara real-time dengan visualisasi data yang menarik.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter Animation Function
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
            
            // Format number with comma separator for thousands
            const displayValue = Math.floor(current).toLocaleString();
            element.textContent = displayValue;
        }, 16);
    }
    
    // Intersection Observer for stats counter animation
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
                    
                    // Stagger the animation start times
                    setTimeout(() => {
                        animateCounter(numberElement, target, 2000);
                    }, index * 200);
                });
                
                // Only animate once
                statsObserver.unobserve(entry.target);
            }
        });
    }, statsObserverOptions);
    
    // Start observing the stats section
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }
    
    // Intersection Observer for other animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
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
    document.querySelectorAll('.feature-card').forEach((el, index) => {
        el.dataset.delay = (index * 0.2) + 's';
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
    
    // Add loading animation to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.href && !this.href.includes('#')) {
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' + this.textContent.trim();
            }
        });
    });
    
    // Add hover effects for stats cards
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Reset animation on page refresh/reload
    window.addEventListener('beforeunload', function() {
        const statsNumbers = document.querySelectorAll('.stats-number');
        statsNumbers.forEach(numberElement => {
            numberElement.textContent = '0';
            numberElement.classList.remove('counting');
        });
    });
});
</script>
@endsection