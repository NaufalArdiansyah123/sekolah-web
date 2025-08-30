@extends('layouts.public')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstrakurikuler - SMA Negeri 1 Balong</title>
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
            --sports-color: #38a169;
            --arts-color: #d69e2e;
            --academic-color: #3182ce;
            --technology-color: #805ad5;
        }
        
        /* Enhanced Hero Section */
        .extracurricular-hero-section {
            background: linear-gradient(
                135deg, 
                rgba(26, 32, 44, 0.8) 0%, 
                rgba(49, 130, 206, 0.7) 50%, 
                rgba(26, 32, 44, 0.8) 100%
            ),
            url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
            color: white;
            padding: 100px 0;
            min-height: 50vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .extracurricular-hero-section::before {
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
        
        .extracurricular-hero-section .container {
            position: relative;
            z-index: 2;
        }
        
        .extracurricular-hero-section h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0,0,0,0.5);
        }
        
        .extracurricular-hero-section .lead {
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
        
        /* Extracurricular Tabs */
        .extracurricular-tabs {
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
        
        .extracurricular-tabs .nav-link {
            padding: 15px 25px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            color: var(--dark-gray);
        }
        
        .extracurricular-tabs .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 8px 20px rgba(49, 130, 206, 0.3);
        }
        
        /* Extracurricular Section */
        .extracurricular-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
        
        .extracurricular-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 30px;
            height: 100%;
        }
        
        .extracurricular-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .extracurricular-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        
        .extracurricular-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .extracurricular-card:hover .extracurricular-image img {
            transform: scale(1.1);
        }
        
        .extracurricular-category {
            position: absolute;
            top: 15px;
            right: 15px;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .category-sports {
            background: var(--sports-color);
        }
        
        .category-arts {
            background: var(--arts-color);
        }
        
        .category-academic {
            background: var(--academic-color);
        }
        
        .category-technology {
            background: var(--technology-color);
        }
        
        .extracurricular-content {
            padding: 25px;
        }
        
        .extracurricular-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .extracurricular-desc {
            color: var(--dark-gray);
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .extracurricular-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        
        .extracurricular-schedule {
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        .extracurricular-coach {
            display: flex;
            align-items: center;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        .coach-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        
        /* Stats Section */
        .extracurricular-stats {
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
        
        /* Registration Section */
        .registration-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
        
        .registration-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            text-align: center;
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
            .extracurricular-hero-section {
                padding: 60px 0;
                text-align: center;
            }
            
            .extracurricular-hero-section h1 {
                font-size: 2.5rem;
            }
            
            .extracurricular-tabs {
                margin-top: -20px;
            }
            
            .extracurricular-tabs .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
                margin-bottom: 10px;
            }
            
            .extracurricular-meta {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .extracurricular-coach {
                margin-top: 10px;
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
    <!-- Enhanced Hero Section for Extracurricular Page -->
    <section class="extracurricular-hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fade-in-up">Ekstrakurikuler</h1>
                    <p class="lead fade-in-up">Wadah pengembangan bakat, minat, dan kreativitas siswa di luar kegiatan akademik</p>
                    <div class="fade-in-up">
                        <a href="#extracurricular" class="btn btn-hero btn-hero-primary me-3">
                            <i class="fas fa-users me-2"></i>Jelajahi Ekstrakurikuler
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-hero btn-hero-outline">
                            <i class="fas fa-home me-2"></i>Kembali ke Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Extracurricular Tabs -->
    <div class="container">
        <div class="extracurricular-tabs fade-in-up">
            <ul class="nav nav-pills justify-content-center flex-wrap" id="extracurricularTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                        <i class="fas fa-star me-2"></i>Semua
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sports-tab" data-bs-toggle="pill" data-bs-target="#sports" type="button" role="tab" aria-controls="sports" aria-selected="false">
                        <i class="fas fa-running me-2"></i>Olahraga
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="arts-tab" data-bs-toggle="pill" data-bs-target="#arts" type="button" role="tab" aria-controls="arts" aria-selected="false">
                        <i class="fas fa-paint-brush me-2"></i>Seni & Budaya
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="academic-tab" data-bs-toggle="pill" data-bs-target="#academic" type="button" role="tab" aria-controls="academic" aria-selected="false">
                        <i class="fas fa-book me-2"></i>Akademik
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="technology-tab" data-bs-toggle="pill" data-bs-target="#technology" type="button" role="tab" aria-controls="technology" aria-selected="false">
                        <i class="fas fa-laptop-code me-2"></i>Teknologi
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Extracurricular Content Section -->
    <section class="extracurricular-section" id="extracurricular">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Pilihan Ekstrakurikuler</h2>
                <p>Berbagai kegiatan ekstrakurikuler untuk mengembangkan potensi siswa</p>
            </div>
            
            <div class="tab-content" id="extracurricularTabsContent">
                <!-- All Extracurricular Tab -->
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <div class="row">
                        <!-- Basketball -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2090&q=80" alt="Basketball">
                                    <span class="extracurricular-category category-sports">Olahraga</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Basketball</h3>
                                    <p class="extracurricular-desc">Ekstrakurikuler basketball melatih keterampilan dribbling, shooting, dan kerjasama tim. Cocok untuk siswa yang menyukai olahraga tim.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Senin & Kamis, 15:00-17:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Budi Santoso</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Robotics -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Robotics">
                                    <span class="extracurricular-category category-technology">Teknologi</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Robotics</h3>
                                    <p class="extracurricular-desc">Belajar merancang, membangun, dan memprogram robot. Mengasah kemampuan logika, pemrograman, dan engineering.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Selasa & Jumat, 14:00-16:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Dr. Ahmad Rizki</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dance -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1547153760-18fc86324498?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" alt="Dance">
                                    <span class="extracurricular-category category-arts">Seni & Budaya</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Tari Tradisional</h3>
                                    <p class="extracurricular-desc">Mempelajari dan melestarikan tarian tradisional Indonesia. Mengembangkan rasa seni, budaya, dan kreativitas.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Rabu & Sabtu, 15:00-17:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Siti Rahayu</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Debate -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Debate">
                                    <span class="extracurricular-category category-academic">Akademik</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Debat Bahasa Inggris</h3>
                                    <p class="extracurricular-desc">Meningkatkan kemampuan berbahasa Inggris, public speaking, dan critical thinking melalui kegiatan debat.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Senin & Kamis, 14:00-16:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: John Smith</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Music -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Music">
                                    <span class="extracurricular-category category-arts">Seni & Budaya</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Paduan Suara</h3>
                                    <p class="extracurricular-desc">Mengembangkan bakat menyanyi, harmonisasi, dan musikalitas. Cocok untuk siswa yang mencintai musik vokal.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Selasa & Jumat, 15:00-17:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1516557070064-1281ce41de9b?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Maria Dewi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Science Club -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Science Club">
                                    <span class="extracurricular-category category-academic">Akademik</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Klub Sains</h3>
                                    <p class="extracurricular-desc">Eksperimen sains, proyek penelitian, dan persiapan olimpiade sains. Untuk siswa yang tertarik dengan dunia sains.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Rabu & Sabtu, 14:00-16:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Dr. Lisa Andriani</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sports Tab -->
                <div class="tab-pane fade" id="sports" role="tabpanel" aria-labelledby="sports-tab">
                    <div class="row">
                        <!-- Basketball -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2090&q=80" alt="Basketball">
                                    <span class="extracurricular-category category-sports">Olahraga</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Basketball</h3>
                                    <p class="extracurricular-desc">Ekstrakurikuler basketball melatih keterampilan dribbling, shooting, dan kerjasama tim. Cocok untuk siswa yang menyukai olahraga tim.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Senin & Kamis, 15:00-17:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Budi Santoso</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Football -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" alt="Football">
                                    <span class="extracurricular-category category-sports">Olahraga</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Sepak Bola</h3>
                                    <p class="extracurricular-desc">Mengembangkan teknik dasar sepak bola, strategi permainan, dan kerjasama tim. Untuk siswa yang bercita-cita menjadi atlet sepak bola.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Selasa & Jumat, 15:00-17:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Rudi Hartono</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Badminton -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1596638787647-904d822d751e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Badminton">
                                    <span class="extracurricular-category category-sports">Olahraga</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Bulu Tangkis</h3>
                                    <p class="extracurricular-desc">Melatih teknik dasar bulu tangkis, strategi permainan, dan meningkatkan kebugaran fisik. Cocok untuk semua tingkat kemampuan.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Rabu & Sabtu, 15:00-17:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1564564321837-a57b7070ac4f?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Susi Susanti</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Arts Tab -->
                <div class="tab-pane fade" id="arts" role="tabpanel" aria-labelledby="arts-tab">
                    <div class="row">
                        <!-- Dance -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1547153760-18fc86324498?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80" alt="Dance">
                                    <span class="extracurricular-category category-arts">Seni & Budaya</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Tari Tradisional</h3>
                                    <p class="extracurricular-desc">Mempelajari dan melestarikan tarian tradisional Indonesia. Mengembangkan rasa seni, budaya, dan kreativitas.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Rabu & Sabtu, 15:00-17:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Siti Rahayu</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Music -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Music">
                                    <span class="extracurricular-category category-arts">Seni & Budaya</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Paduan Suara</h3>
                                    <p class="extracurricular-desc">Mengembangkan bakat menyanyi, harmonisasi, dan musikalitas. Cocok untuk siswa yang mencintai musik vokal.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Selasa & Jumat, 15:00-17:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1516557070064-1281ce41de9b?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Maria Dewi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Theater -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1543536448-d209d2d13a1c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Theater">
                                    <span class="extracurricular-category category-arts">Seni & Budaya</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Teater</h3>
                                    <p class="extracurricular-desc">Mengembangkan kemampuan akting, public speaking, dan ekspresi diri melalui seni peran. Cocok untuk siswa kreatif.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Senin & Kamis, 15:00-17:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Rano Karno</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Academic Tab -->
                <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                    <div class="row">
                        <!-- Debate -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Debate">
                                    <span class="extracurricular-category category-academic">Akademik</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Debat Bahasa Inggris</h3>
                                    <p class="extracurricular-desc">Meningkatkan kemampuan berbahasa Inggris, public speaking, dan critical thinking melalui kegiatan debat.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Senin & Kamis, 14:00-16:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: John Smith</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Science Club -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Science Club">
                                    <span class="extracurricular-category category-academic">Akademik</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Klub Sains</h3>
                                    <p class="extracurricular-desc">Eksperimen sains, proyek penelitian, dan persiapan olimpiade sains. Untuk siswa yang tertarik dengan dunia sains.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Rabu & Sabtu, 14:00-16:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Dr. Lisa Andriani</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Journalism -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Journalism">
                                    <span class="extracurricular-category category-academic">Akademik</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Jurnalistik</h3>
                                    <p class="extracurricular-desc">Mengasah kemampuan menulis, wawancara, dan peliputan berita. Menerbitkan majalah sekolah dan mengelola media sosial.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Selasa & Jumat, 14:00-16:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Dian Sastrowardoyo</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Technology Tab -->
                <div class="tab-pane fade" id="technology" role="tabpanel" aria-labelledby="technology-tab">
                    <div class="row">
                        <!-- Robotics -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Robotics">
                                    <span class="extracurricular-category category-technology">Teknologi</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Robotics</h3>
                                    <p class="extracurricular-desc">Belajar merancang, membangun, dan memprogram robot. Mengasah kemampuan logika, pemrograman, dan engineering.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Selasa & Jumat, 14:00-16:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Dr. Ahmad Rizki</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Programming -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Programming">
                                    <span class="extracurricular-category category-technology">Teknologi</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Pemrograman</h3>
                                    <p class="extracurricular-desc">Mempelajari dasar-dasar pemrograman, pengembangan web, dan aplikasi mobile. Cocok untuk siswa yang tertarik dengan coding.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Senin & Kamis, 14:00-16:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Andi Wijaya</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Digital Design -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="extracurricular-card">
                                <div class="extracurricular-image">
                                    <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2064&q=80" alt="Digital Design">
                                    <span class="extracurricular-category category-technology">Teknologi</span>
                                </div>
                                <div class="extracurricular-content">
                                    <h3 class="extracurricular-title">Desain Digital</h3>
                                    <p class="extracurricular-desc">Mempelajari desain grafis, editing foto, dan pembuatan konten visual. Mengembangkan kreativitas dan kemampuan teknis.</p>
                                    <div class="extracurricular-meta">
                                        <div class="extracurricular-schedule">
                                            <i class="far fa-calendar-alt me-1"></i>Rabu & Sabtu, 14:00-16:00
                                        </div>
                                        <div class="extracurricular-coach">
                                            <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="Coach" class="coach-avatar">
                                            <span>Pelatih: Maya Indrasari</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Extracurricular Stats Section -->
    <section class="extracurricular-stats">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Ekstrakurikuler dalam Angka</h2>
                <p>Statistik partisipasi dan pencapaian kegiatan ekstrakurikuler</p>
            </div>
            
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">85%</div>
                        <div class="stat-label">Siswa Berpartisipasi</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-number">42</div>
                        <div class="stat-label">Prestasi Nasional</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-number">18</div>
                        <div class="stat-label">Pelatih Berpengalaman</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-number">12</div>
                        <div class="stat-label">Jam/Minggu</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Section -->
    <section class="registration-section">
        <div class="container">
            <div class="registration-card fade-in-up">
                <h2 class="mb-4">Tertarik Bergabung?</h2>
                <p class="mb-4">Daftarkan diri Anda sekarang untuk mengikuti salah satu ekstrakurikuler yang tersedia. Pengembangan bakat dan minat menunggu Anda!</p>
                
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const extracurricularTabs = document.querySelectorAll('#extracurricularTabs .nav-link');
            
            extracurricularTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    extracurricularTabs.forEach(t => t.classList.remove('active'));
                    
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
        });
    </script>
</body>
</html>