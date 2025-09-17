@extends('layouts.public')

@section('title', 'Fasilitas Sekolah')

@section('content')
<link rel="stylesheet" href="{{ asset('css/public-template.css') }}">
<style>
    /* Page-specific styles for Facilities */
    
    .hero-section {
        background-image: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        min-height: 50vh;
    }
    
    .facilities-hero-section::before {
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
    
    .facilities-hero-section .container {
        position: relative;
        z-index: 2;
    }
    
    .facilities-hero-section h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.5);
    }
    
    .facilities-hero-section .lead {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        font-weight: 400;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
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
    
    /* Facilities Section */
    .facilities-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        position: relative;
    }
    
    .facility-filter {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 40px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .facility-category-btn {
        border: none;
        background: var(--gradient-light);
        color: var(--primary-color);
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 5px;
    }
    
    .facility-category-btn:hover,
    .facility-category-btn.active {
        background: var(--gradient-primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(49, 130, 206, 0.3);
    }
    
    .facility-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 30px;
        height: 100%;
    }
    
    .facility-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    .facility-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    
    .facility-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .facility-card:hover .facility-image img {
        transform: scale(1.1);
    }
    
    .facility-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.7));
        z-index: 1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .facility-card:hover .facility-image::before {
        opacity: 1;
    }
    
    .facility-content {
        padding: 25px;
    }
    
    .facility-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
        line-height: 1.3;
    }
    
    .facility-desc {
        color: var(--dark-gray);
        line-height: 1.6;
        margin-bottom: 20px;
    }
    
    .facility-features {
        margin-bottom: 20px;
    }
    
    .facility-feature {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        color: var(--dark-gray);
        font-size: 0.9rem;
    }
    
    .facility-feature i {
        margin-right: 8px;
        color: var(--secondary-color);
        width: 16px;
    }
    
    .facility-status {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-available {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .status-maintenance {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    /* Facilities Gallery Section */
    .gallery-section {
        padding: 80px 0;
        background: white;
    }
    
    .gallery-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .gallery-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 20px;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
        transform: translateY(20px);
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
        transform: translateY(0);
    }
    
    .gallery-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .gallery-desc {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    /* Stats Section */
    .facilities-stats {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: var(--secondary-color);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    
    .stat-label {
        color: var(--dark-gray);
        font-weight: 600;
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
    
    /* Modal Styles */
    .facility-modal .modal-content {
        border-radius: 16px;
        overflow: hidden;
        border: none;
    }
    
    .facility-modal .modal-header {
        background: var(--gradient-primary);
        color: white;
        border: none;
    }
    
    .facility-modal .modal-body {
        padding: 25px;
    }
    
    .facility-modal .modal-footer {
        border: none;
        background: #f8f9fa;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .facilities-hero-section {
            padding: 60px 0;
            text-align: center;
        }
        
        .facilities-hero-section h1 {
            font-size: 2.5rem;
        }
        
        .facility-filter .btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .facility-category-btn {
            margin-bottom: 10px;
            flex: 1 0 auto;
            text-align: center;
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

<!-- Enhanced Hero Section for Facilities Page -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="fade-in-up">Fasilitas Sekolah</h1>
                <p class="lead fade-in-up">Infrastruktur modern dan lengkap untuk mendukung proses belajar mengajar yang optimal</p>
                <div class="fade-in-up">
                    <a href="#facilities" class="btn btn-hero btn-hero-primary me-3">
                        <i class="fas fa-building me-2"></i>Jelajahi Fasilitas
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-hero btn-hero-outline">
                        <i class="fas fa-home me-2"></i>Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Filter Section -->
<section class="facilities-section" id="facilities">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Fasilitas Unggulan</h2>
            <p>Berbagai sarana dan prasarana penunjang pendidikan di SMA Negeri 1 Balong</p>
        </div>
        
        <div class="facility-filter fade-in-up">
            <div class="text-center mb-4">
                <h5 class="mb-3">Filter Berdasarkan Kategori:</h5>
                <div class="btn-group" role="group" aria-label="Facility categories">
                    <button type="button" class="facility-category-btn active" data-filter="all">Semua</button>
                    <button type="button" class="facility-category-btn" data-filter="academic">Akademik</button>
                    <button type="button" class="facility-category-btn" data-filter="sport">Olahraga</button>
                    <button type="button" class="facility-category-btn" data-filter="technology">Teknologi</button>
                    <button type="button" class="facility-category-btn" data-filter="arts">Seni & Budaya</button>
                    <button type="button" class="facility-category-btn" data-filter="other">Lainnya</button>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Facility Item 1 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up" data-category="technology">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1592424002053-21f369ad7fdb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80" alt="Laboratorium Komputer">
                        <span class="facility-status status-available">Tersedia</span>
                    </div>
                    <div class="facility-content">
                        <h3 class="facility-title">Laboratorium Komputer</h3>
                        <p class="facility-desc">Lab komputer modern dengan 40 unit PC terkini, jaringan internet cepat, dan software pendidikan lengkap.</p>
                        <div class="facility-features">
                            <div class="facility-feature">
                                <i class="fas fa-desktop"></i> 40 Unit PC Terbaru
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-wifi"></i> Internet High-Speed
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-projector"></i> LCD Projector
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary-enhanced btn-enhanced w-100" data-bs-toggle="modal" data-bs-target="#facilityModal1">
                            <i class="fas fa-info-circle me-2"></i>Detail Fasilitas
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Facility Item 2 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up" data-category="academic">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=2028&q=80" alt="Perpustakaan">
                        <span class="facility-status status-available">Tersedia</span>
                    </div>
                    <div class="facility-content">
                        <h3 class="facility-title">Perpustakaan Digital</h3>
                        <p class="facility-desc">Perpustakaan dengan koleksi lebih dari 10.000 buku, area baca nyaman, dan sistem peminjaman digital.</p>
                        <div class="facility-features">
                            <div class="facility-feature">
                                <i class="fas fa-book"></i> 10.000+ Koleksi Buku
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-laptop"></i> Komputer Pencarian
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-couch"></i> Area Baca Nyaman
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary-enhanced btn-enhanced w-100" data-bs-toggle="modal" data-bs-target="#facilityModal2">
                            <i class="fas fa-info-circle me-2"></i>Detail Fasilitas
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Facility Item 3 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up" data-category="sport">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Lapangan Olahraga">
                        <span class="facility-status status-available">Tersedia</span>
                    </div>
                    <div class="facility-content">
                        <h3 class="facility-title">Lapangan Olahraga</h3>
                        <p class="facility-desc">Lapangan multifungsi untuk basket, voli, futsal, dan atletik dengan permukaan berkualitas standar nasional.</p>
                        <div class="facility-features">
                            <div class="facility-feature">
                                <i class="fas fa-basketball-ball"></i> Lapangan Basket
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-volleyball-ball"></i> Lapangan Voli
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-running"></i> Trek Lari
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary-enhanced btn-enhanced w-100" data-bs-toggle="modal" data-bs-target="#facilityModal3">
                            <i class="fas fa-info-circle me-2"></i>Detail Fasilitas
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Facility Item 4 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up" data-category="academic">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1581093458799-108156e8197b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80" alt="Laboratorium Sains">
                        <span class="facility-status status-available">Tersedia</span>
                    </div>
                    <div class="facility-content">
                        <h3 class="facility-title">Laboratorium Sains</h3>
                        <p class="facility-desc">Lab fisika, kimia, dan biologi lengkap dengan peralatan praktikum modern dan alat keselamatan standar.</p>
                        <div class="facility-features">
                            <div class="facility-feature">
                                <i class="fas fa-flask"></i> Peralatan Lengkap
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-microscope"></i> Mikroskop Digital
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-first-aid"></i> Perlengkapan Keselamatan
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary-enhanced btn-enhanced w-100" data-bs-toggle="modal" data-bs-target="#facilityModal4">
                            <i class="fas fa-info-circle me-2"></i>Detail Fasilitas
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Facility Item 5 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up" data-category="arts">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?ixlib=rb-4.0.3&auto=format&fit=crop&w=2120&q=80" alt="Aula Serba Guna">
                        <span class="facility-status status-available">Tersedia</span>
                    </div>
                    <div class="facility-content">
                        <h3 class="facility-title">Aula Serba Guna</h3>
                        <p class="facility-desc">Aula modern kapasitas 500 orang dengan sound system profesional, lighting, dan panggung permanen.</p>
                        <div class="facility-features">
                            <div class="facility-feature">
                                <i class="fas fa-users"></i> Kapasitas 500 Orang
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-microphone"></i> Sound System Profesional
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-lightbulb"></i> Lighting Modern
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary-enhanced btn-enhanced w-100" data-bs-toggle="modal" data-bs-target="#facilityModal5">
                            <i class="fas fa-info-circle me-2"></i>Detail Fasilitas
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Facility Item 6 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up" data-category="other">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://images.unsplash.com/photo-1614854262318-831574f15f1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2060&q=80" alt="Kantin Sehat">
                        <span class="facility-status status-available">Tersedia</span>
                    </div>
                    <div class="facility-content">
                        <h3 class="facility-title">Kantin Sehat</h3>
                        <p class="facility-desc">Kantin dengan konsep sehat, menyajikan makanan bergizi, higienis, dan harga terjangkau untuk siswa.</p>
                        <div class="facility-features">
                            <div class="facility-feature">
                                <i class="fas fa-utensils"></i> Makanan Sehat
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-hand-holding-water"></i> Higienis Terjamin
                            </div>
                            <div class="facility-feature">
                                <i class="fas fa-tags"></i> Harga Terjangkau
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary-enhanced btn-enhanced w-100" data-bs-toggle="modal" data-bs-target="#facilityModal6">
                            <i class="fas fa-info-circle me-2"></i>Detail Fasilitas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Stats Section -->
<section class="facilities-stats">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Fasilitas dalam Angka</h2>
            <p>Statistik lengkap sarana dan prasarana SMA Negeri 1 Balong</p>
        </div>
        
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-number">24</div>
                    <div class="stat-label">Ruang Kelas</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <div class="stat-number">5</div>
                    <div class="stat-label">Laboratorium</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-number">10.000+</div>
                    <div class="stat-label">Koleksi Buku</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Area WiFi</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Gallery Section -->
<section class="gallery-section">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Galeri Fasilitas</h2>
            <p>Dokumentasi visual berbagai fasilitas yang tersedia</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Ruang Kelas">
                    <div class="gallery-overlay">
                        <h5 class="gallery-title">Ruang Kelas Modern</h5>
                        <p class="gallery-desc">Dilengkapi AC dan LCD projector</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" alt="Lab Bahasa">
                    <div class="gallery-overlay">
                        <h5 class="gallery-title">Laboratorium Bahasa</h5>
                        <p class="gallery-desc">Peralatan audio modern</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Perpustakaan">
                    <div class="gallery-overlay">
                        <h5 class="gallery-title">Perpustakaan</h5>
                        <p class="gallery-desc">Koleksi buku terlengkap</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1596466596120-2a8e4b5d1a51?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Lapangan Basket">
                    <div class="gallery-overlay">
                        <h5 class="gallery-title">Lapangan Basket</h5>
                        <p class="gallery-desc">Standar kompetisi</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2094&q=80" alt="Mushola">
                    <div class="gallery-overlay">
                        <h5 class="gallery-title">Mushola</h5>
                        <p class="gallery-desc">Tempat ibadah yang nyaman</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1599458254073-8b34c03ba924?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Lab Kimia">
                    <div class="gallery-overlay">
                        <h5 class="gallery-title">Lab Kimia</h5>
                        <p class="gallery-desc">Peralatan praktikum lengkap</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" alt="Ruang Guru">
                    <div class="gallery-overlay">
                        <h5 class="gallery-title">Ruang Guru</h5>
                        <p class="gallery-desc">Tempat kerja yang nyaman</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Studio Musik">
                    <div class="gallery-overlay">
                        <h5 class="gallery-title">Studio Musik</h5>
                        <p class="gallery-desc">Alat musik lengkap</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('gallery.index') }}" class="btn btn-primary-enhanced btn-enhanced">
                <i class="fas fa-images me-2"></i>Lihat Galeri Lengkap
            </a>
        </div>
    </div>
</section>

<!-- Facility Modals -->
<div class="modal fade facility-modal" id="facilityModal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Laboratorium Komputer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1592424002053-21f369ad7fdb?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80" alt="Laboratorium Komputer" class="img-fluid rounded mb-4">
                <h5>Deskripsi Fasilitas</h5>
                <p>Laboratorium komputer kami dilengkapi dengan 40 unit PC terkini dengan spesifikasi tinggi yang mampu mendukung berbagai software pendidikan dan programming. Setiap komputer terhubung dengan jaringan internet high-speed dengan kecepatan 100 Mbps.</p>
                
                <h5>Fasilitas Pendukung</h5>
                <ul>
                    <li>40 Unit PC Core i5, 8GB RAM, SSD 256GB</li>
                    <li>Jaringan internet 100 Mbps dedicated</li>
                    <li>LCD projector dan layar besar</li>
                    <li>Software
                                            <li>Software pendidikan lengkap (Office, Programming, Design)</li>
                    <li>AC dan sistem ventilasi yang nyaman</li>
                    <li>Furniture ergonomis untuk kenyamanan belajar</li>
                </ul>
                
                <h5>Kegiatan yang Didukung</h5>
                <ul>
                    <li>Pelajaran TIK dan Komputer</li>
                    <li>Ekstrakurikuler Programming</li>
                    <li>Pelatihan Desain Grafis</li>
                    <li>Ujian Berbasis Komputer</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary-enhanced">Ajukan Penggunaan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade facility-modal" id="facilityModal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perpustakaan Digital</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=2028&q=80" alt="Perpustakaan" class="img-fluid rounded mb-4">
                <h5>Deskripsi Fasilitas</h5>
                <p>Perpustakaan digital kami memiliki koleksi lebih dari 10.000 buku dari berbagai disiplin ilmu. Dilengkapi dengan sistem pencarian digital, area baca yang nyaman, dan ruang diskusi kelompok.</p>
                
                <h5>Fasilitas Pendukung</h5>
                <ul>
                    <li>Koleksi 10.000+ buku cetak dan digital</li>
                    <li>Komputer dengan akses katalog digital</li>
                    <li>Area baca dengan pencahayaan optimal</li>
                    <li>Ruang diskusi kelompok</li>
                    <li>Sistem peminjaman elektronik</li>
                    <li>Koneksi WiFi khusus</li>
                </ul>
                
                <h5>Koleksi Khusus</h5>
                <ul>
                    <li>Buku pelajaran semua mata pelajaran</li>
                    <li>Buku referensi ujian dan perguruan tinggi</li>
                    <li>Karya sastra Indonesia dan dunia</li>
                    <li>Buku pengembangan diri</li>
                    <li>Majalah dan jurnal pendidikan</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary-enhanced">Ajukan Penggunaan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal lainnya akan mengikuti struktur yang sama -->

</div>

<!-- JavaScript untuk Filter dan Animasi -->
<script src="{{ asset('js/public-template.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterButtons = document.querySelectorAll('.facility-category-btn');
        const facilityItems = document.querySelectorAll('[data-category]');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                
                facilityItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
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