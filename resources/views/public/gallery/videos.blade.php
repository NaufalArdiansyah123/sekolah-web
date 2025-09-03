@extends('layouts.public')

@section('title', 'Video Gallery')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Video - SMA Negeri 1 Balong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        /* Enhanced Hero Section */
        .video-hero-section {
            background: linear-gradient(
                135deg, 
                rgba(26, 32, 44, 0.8) 0%, 
                rgba(49, 130, 206, 0.7) 50%, 
                rgba(26, 32, 44, 0.8) 100%
            ),
            url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
            color: white;
            padding: 100px 0;
            min-height: 50vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .video-hero-section::before {
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
        
        .video-hero-section .container {
            position: relative;
            z-index: 2;
        }
        
        .video-hero-section h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0,0,0,0.5);
        }
        
        .video-hero-section .lead {
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
        
        /* Video Tabs */
        .video-tabs {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin: -40px auto 40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            z-index: 10;
            max-width: 90%;
        }
        
        .video-tabs .nav-link {
            padding: 15px 25px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            color: var(--dark-gray);
        }
        
        .video-tabs .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 8px 20px rgba(49, 130, 206, 0.3);
        }
        
        /* Video Gallery Section */
        .video-gallery-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
        
        .video-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 30px;
            height: 100%;
        }
        
        .video-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .video-thumbnail {
            height: 200px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }
        
        .video-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .video-card:hover .video-thumbnail img {
            transform: scale(1.1);
        }
        
        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .play-button i {
            color: var(--secondary-color);
            font-size: 20px;
            margin-left: 4px;
        }
        
        .video-thumbnail:hover .play-button {
            background: rgba(255, 255, 255, 1);
            transform: translate(-50%, -50%) scale(1.1);
        }
        
        .video-category {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--secondary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .video-content {
            padding: 25px;
        }
        
        .video-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .video-desc {
            color: var(--dark-gray);
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .video-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        
        .video-date {
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        .video-duration {
            display: flex;
            align-items: center;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        /* Video Modal */
        .video-modal .modal-content {
            border-radius: 16px;
            overflow: hidden;
            border: none;
        }
        
        .video-modal .modal-header {
            background: var(--gradient-primary);
            color: white;
            border: none;
        }
        
        .video-modal .modal-body {
            padding: 0;
            background: #000;
        }
        
        .video-modal iframe {
            width: 100%;
            height: 400px;
            border: none;
        }
        
        .video-modal .modal-footer {
            border: none;
            background: #f8f9fa;
        }
        
        /* Stats Section */
        .video-stats {
            padding: 80px 0;
            background: white;
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
        
        /* Featured Video Section */
        .featured-video-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
        
        .featured-video-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }
        
        .featured-video-player {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
        }
        
        .featured-video-player iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .featured-video-content {
            padding: 25px;
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
            .video-hero-section {
                padding: 60px 0;
                text-align: center;
            }
            
            .video-hero-section h1 {
                font-size: 2.5rem;
            }
            
            .video-tabs {
                margin-top: -20px;
            }
            
            .video-tabs .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
                margin-bottom: 10px;
            }
            
            .video-modal iframe {
                height: 250px;
            }
            
            .featured-video-content {
                padding: 20px;
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
</head>
<body>
    <!-- Enhanced Hero Section for Video Gallery Page -->
    <section class="video-hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fade-in-up">Gallery Video</h1>
                    <p class="lead fade-in-up">Rekaman kegiatan sekolah, fasilitas, dan momen berharga di SMA Negeri 1 Balong</p>
                    <div class="fade-in-up">
                        <a href="#videos" class="btn btn-hero btn-hero-primary me-3">
                            <i class="fas fa-play-circle me-2"></i>Tonton Video
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-hero btn-hero-outline">
                            <i class="fas fa-home me-2"></i>Kembali ke Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Tabs -->
    <div class="container">
        <div class="video-tabs fade-in-up">
            <ul class="nav nav-pills justify-content-center flex-wrap" id="videoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                        <i class="fas fa-star me-2"></i>Semua Video
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="activities-tab" data-bs-toggle="pill" data-bs-target="#activities" type="button" role="tab" aria-controls="activities" aria-selected="false">
                        <i class="fas fa-users me-2"></i>Kegiatan Sekolah
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="facilities-tab" data-bs-toggle="pill" data-bs-target="#facilities" type="button" role="tab" aria-controls="facilities" aria-selected="false">
                        <i class="fas fa-building me-2"></i>Fasilitas Sekolah
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="achievements-tab" data-bs-toggle="pill" data-bs-target="#achievements" type="button" role="tab" aria-controls="achievements" aria-selected="false">
                        <i class="fas fa-trophy me-2"></i>Prestasi
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Featured Video Section -->
    <section class="featured-video-section">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Video Utama</h2>
                <p>Video pilihan yang menampilkan kegiatan terbaik di SMA Negeri 1 Balong</p>
            </div>
            
            <div class="featured-video-card fade-in-up">
                <div class="featured-video-player">
                    <iframe src="https://www.youtube.com/embed/LLCnYACjqnA" title="Video Profil SMA Negeri 1 Balong" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="featured-video-content">
                    <h3>Profil SMA Negeri 1 Balong</h3>
                    <p>Video profil lengkap yang memperkenalkan SMA Negeri 1 Balong, termasuk visi misi, fasilitas, kegiatan, dan prestasi yang telah diraih.</p>
                    <div class="video-meta">
                        <span class="video-date"><i class="far fa-calendar me-1"></i>15 Oktober 2024</span>
                        <span class="video-duration"><i class="far fa-clock me-1"></i>5:32</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Gallery Section -->
    <section class="video-gallery-section" id="videos">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Koleksi Video</h2>
                <p>Kumpulan video dokumentasi kegiatan dan fasilitas sekolah</p>
            </div>
            
            <div class="tab-content" id="videoTabsContent">
                <!-- All Videos Tab -->
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <div class="row">
                        <!-- Video 1 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal1">
                                    <img src="https://img.youtube.com/vi/LLCnYACjqnA/maxresdefault.jpg" alt="Wisuda Angkatan 2024">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Kegiatan</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Wisuda Angkatan 2024</h3>
                                    <p class="video-desc">Momen spesial wisuda angkatan 2024 SMA Negeri 1 Balong yang dihadiri oleh orang tua, guru, dan tamu undangan.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>20 Juni 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>8:15</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video 2 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal2">
                                    <img src="https://img.youtube.com/vi/LXb3EKWsInQ/maxresdefault.jpg" alt="Tur Fasilitas Sekolah">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Fasilitas</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Tur Fasilitas Sekolah</h3>
                                    <p class="video-desc">Tur lengkap fasilitas SMA Negeri 1 Balong termasuk laboratorium, perpustakaan, lapangan olahraga, dan ruang kelas.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>5 Mei 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>6:42</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video 3 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal3">
                                    <img src="https://img.youtube.com/vi/6pxRHBw-k8M/maxresdefault.jpg" alt="Olimpiade Sains Nasional">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Prestasi</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Olimpiade Sains Nasional</h3>
                                    <p class="video-desc">Perjalanan tim olimpiade sains SMA Negeri 1 Balong menuju kompetisi nasional dan meraih medali emas.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>12 April 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>10:28</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video 4 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal4">
                                    <img src="https://img.youtube.com/vi/ym7RR2Lkizs/maxresdefault.jpg" alt="Pentas Seni Tahun 2024">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Seni</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Pentas Seni Tahun 2024</h3>
                                    <p class="video-desc">Penampilan spektakuler siswa-siswi SMA Negeri 1 Balong dalam pentas seni tahunan dengan berbagai pertunjukan.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>28 Maret 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>15:10</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video 5 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal5">
                                    <img src="https://img.youtube.com/vi/VB4CCHHYOqY/maxresdefault.jpg" alt="Workshop Robotik">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Edukasi</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Workshop Robotik</h3>
                                    <p class="video-desc">Sesi workshop robotik yang diadakan untuk siswa yang tertarik dengan teknologi и pemrograman.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>15 Februari 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>7:53</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video 6 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal6">
                                    <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Turnamen Basket Antar Kelas">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Olahraga</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Turnamen Basket Antar Kelas</h3>
                                    <p class="video-desc">Semangat kompetisi dalam turnamen basket antar kelas yang memperebutkan piala bergilir kepala sekolah.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>5 Januari 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>9:27</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Activities Tab -->
                <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-tab">
                    <div class="row">
                        <!-- Video 1 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal1">
                                    <img src="https://img.youtube.com/vi/LLCnYACjqnA/maxresdefault.jpg" alt="Wisuda Angkatan 2024">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Kegiatan</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Wisuda Angkatan 2024</h3>
                                    <p class="video-desc">Momen spesial wisuda angkatan 2024 SMA Negeri 1 Balong yang dihadiri oleh orang tua, guru, dan tamu undangan.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>20 Juni 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>8:15</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video 4 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal4">
                                    <img src="https://img.youtube.com/vi/ym7RR2Lkizs/maxresdefault.jpg" alt="Pentas Seni Tahun 2024">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Seni</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Pentas Seni Tahun 2024</h3>
                                    <p class="video-desc">Penampilan spektakuler siswa-siswi SMA Negeri 1 Balong dalam pentas seni tahunan dengan berbagai pertunjukan.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>28 Maret 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>15:10</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video 6 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal6">
                                    <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="Turnamen Basket Antar Kelas">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Olahraga</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Turnamen Basket Antar Kelas</h3>
                                    <p class="video-desc">Semangat kompetisi dalam turnamen basket antar kelas yang memperebutkan piala bergilir kepala sekolah.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>5 Januari 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>9:27</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Facilities Tab -->
                <div class="tab-pane fade" id="facilities" role="tabpanel" aria-labelledby="facilities-tab">
                    <div class="row">
                        <!-- Video 2 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal2">
                                    <img src="https://img.youtube.com/vi/LXb3EKWsInQ/maxresdefault.jpg" alt="Tur Fasilitas Sekolah">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Fasilitas</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Tur Fasilitas Sekolah</h3>
                                    <p class="video-desc">Tur lengkap fasilitas SMA Negeri 1 Balong termasuk laboratorium, perpustakaan, lapangan olahraga, dan ruang kelas.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>5 Mei 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>6:42</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Achievements Tab -->
                <div class="tab-pane fade" id="achievements" role="tabpanel" aria-labelledby="achievements-tab">
                    <div class="row">
                        <!-- Video 3 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="video-card">
                                <div class="video-thumbnail" data-bs-toggle="modal" data-bs-target="#videoModal3">
                                    <img src="https://img.youtube.com/vi/6pxRHBw-k8M/maxresdefault.jpg" alt="Olimpiade Sains Nasional">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="video-category">Prestasi</span>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title">Olimpiade Sains Nasional</h3>
                                    <p class="video-desc">Perjalanan tim olimpiade sains SMA Negeri 1 Balong menuju kompetisi nasional dan meraih medali emas.</p>
                                    <div class="video-meta">
                                        <span class="video-date"><i class="far fa-calendar me-1"></i>12 April 2024</span>
                                        <span class="video-duration"><i class="far fa-clock me-1"></i>10:28</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary-enhanced btn-enhanced">
                    <i class="fas fa-video me-2"></i>Lihat Lebih Banyak Video
                </a>
            </div>
        </div>
    </section>

    <!-- Video Stats Section -->
    <section class="video-stats">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Video dalam Angka</h2>
                <p>Statistik koleksi video dokumentasi sekolah</p>
            </div>
            
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-film"></i>
                        </div>
                        <div class="stat-number">156</div>
                        <div class="stat-label">Total Video</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-number">24.5K</div>
                        <div class="stat-label">Total Dilihat</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="stat-number">2021</div>
                        <div class="stat-label">Tahun Terlama</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-number">38</div>
                        <div class="stat-label">Jam Durasi</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Modals -->
    <div class="modal fade video-modal" id="videoModal1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Wisuda Angkatan 2024</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe src="https://www.youtube.com/embed/LLCnYACjqnA" title="Wisuda Angkatan 2024" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="https://www.youtube.com/watch?v=LLCnYACjqnA" target="_blank" class="btn btn-primary-enhanced">
                        <i class="fab fa-youtube me-2"></i>Buka di YouTube
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade video-modal" id="videoModal2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tur Fasilitas Sekolah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe src="https://www.youtube.com/embed/LXb3EKWsInQ" title="Tur Fasilitas Sekolah" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" target="_blank" class="btn btn-primary-enhanced">
                        <i class="fab fa-youtube me-2"></i>Buka di YouTube
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add more modals for other videos following the same pattern -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const videoTabs = document.querySelectorAll('#videoTabs .nav-link');
            
            videoTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    videoTabs.forEach(t => t.classList.remove('active'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
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
            
            // Pause video when modal is closed
            const videoModals = document.querySelectorAll('.video-modal');
            videoModals.forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function () {
                    const iframe = this.querySelector('iframe');
                    iframe.src = iframe.src; // Reset the iframe source to stop video playback
                });
            });
        });
    </script>
</body>
</html>