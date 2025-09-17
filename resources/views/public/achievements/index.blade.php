@extends('layouts.public')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi - SMK PGRI 2 PONOROGO</title>
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
            --success-color: #38a169;
            --warning-color: #d69e2e;
        }
        
        /* Enhanced Hero Section */
        .achievement-hero-section {
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
        
        .achievement-hero-section::before {
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
        
        .achievement-hero-section .container {
            position: relative;
            z-index: 2;
        }
        
        .achievement-hero-section h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0,0,0,0.5);
        }
        
        .achievement-hero-section .lead {
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
        
        /* Achievement Tabs */
        .achievement-tabs {
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
        
        .achievement-tabs .nav-link {
            padding: 15px 25px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            color: var(--dark-gray);
        }
        
        .achievement-tabs .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 8px 20px rgba(49, 130, 206, 0.3);
        }
        
        /* Achievement Section */
        .achievement-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
        
        .achievement-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 30px;
            height: 100%;
        }
        
        .achievement-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .achievement-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        
        .achievement-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .achievement-card:hover .achievement-image img {
            transform: scale(1.1);
        }
        
        .achievement-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--success-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .achievement-content {
            padding: 25px;
        }
        
        .achievement-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .achievement-desc {
            color: var(--dark-gray);
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .achievement-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        
        .achievement-category {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: var(--gradient-light);
            color: var(--primary-color);
        }
        
        .achievement-date {
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        /* Stats Section */
        .achievement-stats {
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
        
        /* Timeline Section */
        .timeline-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
        
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            width: 4px;
            height: 100%;
            background: var(--secondary-color);
            transform: translateX(-50%);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 50px;
            width: 100%;
        }
        
        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: auto;
            margin-right: 0;
            text-align: right;
        }
        
        .timeline-item:nth-child(even) .timeline-content {
            margin-left: 0;
            margin-right: auto;
            text-align: left;
        }
        
        .timeline-dot {
            position: absolute;
            top: 20px;
            left: 50%;
            width: 20px;
            height: 20px;
            background: var(--secondary-color);
            border-radius: 50%;
            transform: translateX(-50%);
            z-index: 2;
        }
        
        .timeline-content {
            width: 45%;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .timeline-year {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }
        
        .timeline-title {
            font-weight: 600;
            margin-bottom: 10px;
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
            .achievement-hero-section {
                padding: 60px 0;
                text-align: center;
            }
            
            .achievement-hero-section h1 {
                font-size: 2.5rem;
            }
            
            .achievement-tabs {
                margin-top: -20px;
            }
            
            .achievement-tabs .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            
            .timeline::before {
                left: 20px;
            }
            
            .timeline-dot {
                left: 20px;
            }
            
            .timeline-content {
                width: 85%;
                margin-left: 60px !important;
                text-align: left !important;
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
    <!-- Enhanced Hero Section for Achievements Page -->
    <section class="achievement-hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fade-in-up">Prestasi Siswa & Sekolah</h1>
                    <p class="lead fade-in-up">Kebanggaan dan penghargaan yang diraih oleh siswa dan SMK PGRI 2 PONOROGO</p>
                    <div class="fade-in-up">
                        <a href="#achievements" class="btn btn-hero btn-hero-primary me-3">
                            <i class="fas fa-trophy me-2"></i>Lihat Prestasi
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-hero btn-hero-outline">
                            <i class="fas fa-home me-2"></i>Kembali ke Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievement Tabs -->
    <div class="container">
        <div class="achievement-tabs fade-in-up">
            <ul class="nav nav-pills justify-content-center" id="achievementTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="student-tab" data-bs-toggle="pill" data-bs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="true">
                        <i class="fas fa-user-graduate me-2"></i>Prestasi Siswa
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="school-tab" data-bs-toggle="pill" data-bs-target="#school" type="button" role="tab" aria-controls="school" aria-selected="false">
                        <i class="fas fa-school me-2"></i>Prestasi Sekolah
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="timeline-tab" data-bs-toggle="pill" data-bs-target="#timeline" type="button" role="tab" aria-controls="timeline" aria-selected="false">
                        <i class="fas fa-history me-2"></i>Linimasa Prestasi
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Achievement Content Section -->
    <section class="achievement-section" id="achievements">
        <div class="container">
            <div class="tab-content" id="achievementTabsContent">
                <!-- Student Achievements Tab -->
                <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">
                    <div class="section-title text-center mb-5">
                        <h2>Prestasi Siswa</h2>
                        <p>Penghargaan dan prestasi yang diraih oleh siswa-siswi SMK PGRI 2 PONOROGO</p>
                    </div>
                    
                    <div class="row">
                        <!-- Student Achievement 1 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="achievement-card">
                                <div class="achievement-image">
                                    <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Juara Olimpiade Matematika">
                                    <span class="achievement-badge">Juara 1</span>
                                </div>
                                <div class="achievement-content">
                                    <h3 class="achievement-title">Juara 1 Olimpiade Matematika Tingkat Nasional</h3>
                                    <p class="achievement-desc">Siswa kami, Ahmad Rizki, berhasil meraih juara 1 dalam Olimpiade Matematika Tingkat Nasional yang diadakan di Jakarta.</p>
                                    <div class="achievement-meta">
                                        <span class="achievement-category">Akademik</span>
                                        <span class="achievement-date"><i class="far fa-calendar me-1"></i>15 Okt 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Student Achievement 2 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="achievement-card">
                                <div class="achievement-image">
                                    <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Juara Basket">
                                    <span class="achievement-badge">Juara 1</span>
                                </div>
                                <div class="achievement-content">
                                    <h3 class="achievement-title">Juara 1 Turnamen Basket Pelajar Se-Provinsi</h3>
                                    <p class="achievement-desc">Tim basket SMK PGRI 2 PONOROGO berhasil menjadi juara 1 setelah mengalahkan tim dari SMA Negeri 2 Kota dalam final yang menegangkan.</p>
                                    <div class="achievement-meta">
                                        <span class="achievement-category">Olahraga</span>
                                        <span class="achievement-date"><i class="far fa-calendar me-1"></i>5 Nov 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Student Achievement 3 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="achievement-card">
                                <div class="achievement-image">
                                    <img src="https://images.unsplash.com/photo-1516527653392-602455dd9cf3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2032&q=80" alt="Juara Debat Bahasa Inggris">
                                    <span class="achievement-badge">Juara 1</span>
                                </div>
                                <div class="achievement-content">
                                    <h3 class="achievement-title">Juara 1 Debat Bahasa Inggris Tingkat Regional</h3>
                                    <p class="achievement-desc">Tim debat bahasa Inggris SMK PGRI 2 PONOROGO berhasil meraih juara 1 dalam kompetisi debat regional yang diikuti oleh 50 sekolah.</p>
                                    <div class="achievement-meta">
                                        <span class="achievement-category">Bahasa</span>
                                        <span class="achievement-date"><i class="far fa-calendar me-1"></i>22 Sep 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Student Achievement 4 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="achievement-card">
                                <div class="achievement-image">
                                    <img src="https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Juara Robotik">
                                    <span class="achievement-badge">Juara 2</span>
                                </div>
                                <div class="achievement-content">
                                    <h3 class="achievement-title">Juara 2 Kompetisi Robotik Nasional</h3>
                                    <p class="achievement-desc">Tim robotik SMK PGRI 2 PONOROGO berhasil meraih juara 2 dalam Kompetisi Robotik Nasional dengan inovasi robot pemilah sampah.</p>
                                    <div class="achievement-meta">
                                        <span class="achievement-category">Teknologi</span>
                                        <span class="achievement-date"><i class="far fa-calendar me-1"></i>30 Agu 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Student Achievement 5 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="achievement-card">
                                <div class="achievement-image">
                                    <img src="https://images.unsplash.com/photo-1544809293-94c271c2fe9f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2072&q=80" alt="Juara Menulis Cerpen">
                                    <span class="achievement-badge">Juara 1</span>
                                </div>
                                <div class="achievement-content">
                                    <h3 class="achievement-title">Juara 1 Lomba Menulis Cerpen Tingkat Nasional</h3>
                                    <p class="achievement-desc">Siswi kami, Siti Nurhaliza, berhasil meraih juara 1 lomba menulis cerpen dengan karya "Pelangi di Balik Rintikan Hujan".</p>
                                    <div class="achievement-meta">
                                        <span class="achievement-category">Sastra</span>
                                        <span class="achievement-date"><i class="far fa-calendar me-1"></i>12 Jul 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Student Achievement 6 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="achievement-card">
                                <div class="achievement-image">
                                    <img src="https://images.unsplash.com/photo-1598890779134-39164593315a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Juara Paduan Suara">
                                    <span class="achievement-badge">Juara 3</span>
                                </div>
                                <div class="achievement-content">
                                    <h3 class="achievement-title">Juara 3 Festival Paduan Suara Pelajar</h3>
                                    <p class="achievement-desc">Paduan suara SMK PGRI 2 PONOROGO berhasil meraih juara 3 dalam Festival Paduan Suara Pelajar Se-Indonesia.</p>
                                    <div class="achievement-meta">
                                        <span class="achievement-category">Seni</span>
                                        <span class="achievement-date"><i class="far fa-calendar me-1"></i>18 Jun 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- School Achievements Tab -->
                <div class="tab-pane fade" id="school" role="tabpanel" aria-labelledby="school-tab">
                    <div class="section-title text-center mb-5">
                        <h2>Prestasi Sekolah</h2>
                        <p>Penghargaan dan pengakuan yang diraih oleh SMK PGRI 2 PONOROGO</p>
                    </div>
                    
                    <div class="row">
                        <!-- School Achievement 1 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="achievement-card">
                                <div class="achievement-image">
                                    <img src="https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80" alt="Sekolah Adiwiyata">
                                    <span class="achievement-badge">Nasional</span>
                                </div>
                                <div class="achievement-content">
                                    <h3 class="achievement-title">Sekolah Adiwiyata Nasional 2024</h3>
                                    <p class="achievement-desc">SMK PGRI 2 PONOROGO meraih penghargaan Sekolah Adiwiyata Nasional atas komitmennya dalam program lingkungan hidup.</p>
                                    <div class="achievement-meta">
                                        <span class="achievement-category">Lingkungan</span>
                                        <span class="achievement-date"><i class="far fa-calendar me-1"></i>5 Des 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- School Achievement 2 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="achievement-card">
                                <div class="achievement-image">
                                    <img src="https://images.unsplash.com/photo-1581093458799-108156e8197b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80" alt="Sekolah Berbudaya Mutu">
                                    <span class="achievement-badge">Provinsi</span>
                                </div>
                                <div class="achievement-content">
                                    <h3 class="achievement-title">Sekolah Berbudaya Mutu Tingkat Provinsi</h3>
                                    <p class="achievement-desc">Penghargaan diberikan kepada SMK PGRI 2 PONOROGO sebagai sekolah dengan budaya mutu terbaik se-provinsi.</p>
                                    <div class="achievement-meta">
                                        <span class="achievement-category">Kualitas</span>
                                        <span class="achievement-date"><i class="far fa-calendar me-1"></i>20 Nov 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- School Achievement 3 -->
                        <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                            <div class="achievement-card">
                                <div class="achievement-image">
                                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Sekolah Digital">
                                    <span class="achievement-badge">Nasional</span>
                                </div>
                                <div class="achievement-content">
                                    <h3 class="achievement-title">Sekolah Digital Terbaik 2024</h3>
                                    <p class="achievement-desc">SMK PGRI 2 PONOROGO terpilih sebagai sekolah dengan implementasi teknologi digital terbaik se-Indonesia.</p>
                                    <div class="achievement-meta">
                                        <span class="achievement-category">Teknologi</span>
                                        <span class="achievement-date"><i class="far fa-calendar me-1"></i>10 Okt 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Achievement Timeline Tab -->
                <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                    <div class="section-title text-center mb-5">
                        <h2>Linimasa Prestasi</h2>
                        <p>Perjalanan prestasi SMK PGRI 2 PONOROGO dari tahun ke tahun</p>
                    </div>
                    
                    <div class="timeline">
                        <!-- Timeline Item 1 -->
                        <div class="timeline-item fade-in-up">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-year">2024</div>
                                <h4 class="timeline-title">Juara 1 Olimpiade Matematika Nasional</h4>
                                <p>Siswa kami meraih juara 1 Olimpiade Matematika Tingkat Nasional</p>
                            </div>
                        </div>
                        
                        <!-- Timeline Item 2 -->
                        <div class="timeline-item fade-in-up">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-year">2023</div>
                                <h4 class="timeline-title">Sekolah Adiwiyata Mandiri</h4>
                                <p>Mendapatkan penghargaan Sekolah Adiwiyata Mandiri dari Kementerian Lingkungan Hidup</p>
                            </div>
                        </div>
                        
                        <!-- Timeline Item 3 -->
                        <div class="timeline-item fade-in-up">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-year">2022</div>
                                <h4 class="timeline-title">Akreditasi A</h4>
                                <p>Memperoleh peringkat Akreditasi A dari Badan Akreditasi Nasional</p>
                            </div>
                        </div>
                        
                        <!-- Timeline Item 4 -->
                        <div class="timeline-item fade-in-up">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-year">2021</div>
                                <h4 class="timeline-title">Juara 1 Debat Bahasa Inggris</h4>
                                <p>Tim debat bahasa Inggris meraih juara 1 tingkat provinsi</p>
                            </div>
                        </div>
                        
                        <!-- Timeline Item 5 -->
                        <div class="timeline-item fade-in-up">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-year">2020</div>
                                <h4 class="timeline-title">Sekolah Penggerak</h4>
                                <p>Terpilih sebagai Sekolah Penggerak dalam program Merdeka Belajar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievement Stats Section -->
    <section class="achievement-stats">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Prestasi dalam Angka</h2>
                <p>Statistik pencapaian siswa dan sekolah</p>
            </div>
            
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-number">156</div>
                        <div class="stat-label">Prestasi Nasional</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div class="stat-number">342</div>
                        <div class="stat-label">Prestasi Regional</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <div class="stat-number">28</div>
                        <div class="stat-label">Penghargaan Sekolah</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Siswa Berprestasi</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const achievementTabs = document.querySelectorAll('#achievementTabs .nav-link');
            
            achievementTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    achievementTabs.forEach(t => t.classList.remove('active'));
                    
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