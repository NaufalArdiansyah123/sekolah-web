@extends('layouts.public')

@section('title', 'Visi & Misi')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Akademik - SMK PGRI 2 PONOROGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
            ),
            url('https://images.unsplash.com/photo-1606686374399-3dcb04c2c3c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
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
        
        /* Animation Styles */
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
        
        /* Enhanced Cards */
        .card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .card::before {
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
        
        .card:hover::before {
            transform: scaleX(1);
        }
        
        /* Filter Section */
        .filter-section {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            padding: 40px 0;
        }
        
        .filter-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
        }
        
        .form-select, .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .form-select:focus, .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(49, 130, 206, 0.25);
        }
        
        /* Event Items */
        .event-item {
            transition: all 0.3s ease;
            border-radius: 12px;
            margin-bottom: 15px;
            position: relative;
        }
        
        .event-item:hover {
            background: rgba(49, 130, 206, 0.05);
            transform: translateX(10px);
        }
        
        .date-badge {
            border-radius: 12px;
            padding: 12px 16px;
            min-width: 70px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .event-item:hover .date-badge {
            transform: scale(1.05);
        }
        
        /* Calendar Table */
        .calendar-table td {
            vertical-align: middle;
            height: 60px;
            position: relative;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .calendar-table td:hover {
            background: rgba(49, 130, 206, 0.1) !important;
            transform: scale(1.05);
            border-radius: 8px;
        }
        
        .calendar-table .event-day {
            font-weight: bold;
            border-radius: 8px;
            position: relative;
        }
        
        .calendar-table .event-day::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: white;
        }
        
        /* Category Cards */
        .category-card {
            transition: all 0.4s ease;
            border-radius: 20px;
            overflow: hidden;
        }
        
        .category-card:hover {
            transform: translateY(-10px) scale(1.02);
        }
        
        .category-icon {
            transition: all 0.3s ease;
        }
        
        .category-card:hover .category-icon {
            transform: scale(1.1) rotateY(360deg);
        }
        
        /* Month Buttons */
        .month-btn {
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .month-btn.active {
            background: var(--gradient-primary) !important;
            border-color: transparent;
            color: white;
        }
        
        .month-btn:hover {
            transform: translateY(-2px);
        }
        
        /* Legend */
        .legend-item {
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 8px;
        }
        
        .legend-item:hover {
            background: rgba(0,0,0,0.05);
            transform: translateX(5px);
        }
        
        /* CTA Section */
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
        
        /* Hidden class for filtering */
        .hidden {
            display: none !important;
        }
        
        .filter-active {
            animation: filterIn 0.5s ease-out;
        }
        
        @keyframes filterIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        }
    </style>
</head>
<body>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Kalender Akademik</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">Jadwal lengkap kegiatan akademik dan non-akademik SMK PGRI 2 PONOROGO tahun ajaran 2024/2025. Rencanakan kegiatan Anda dengan tepat.</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-calendar-alt hero-icon scale-in" style="animation-delay: 0.4s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Filter Section -->
<section class="filter-section">
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card filter-card shadow fade-in-up">
                    <div class="card-body p-4">
                        <h5 class="text-center mb-4 fw-bold">Filter Kalender</h5>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Semester:</label>
                                <select class="form-select" id="semesterFilter">
                                    <option value="all">Semua Semester</option>
                                    <option value="ganjil" selected>Semester Ganjil</option>
                                    <option value="genap">Semester Genap</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Kategori:</label>
                                <select class="form-select" id="categoryFilter">
                                    <option value="all">Semua Kategori</option>
                                    <option value="akademik">Akademik</option>
                                    <option value="ujian">Ujian</option>
                                    <option value="libur">Libur</option>
                                    <option value="kegiatan">Kegiatan</option>
                                    <option value="hari-besar">Hari Besar</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Bulan:</label>
                                <select class="form-select" id="monthFilter">
                                    <option value="all">Semua Bulan</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary-enhanced btn-enhanced w-100" id="resetFilter">
                                    <i class="fas fa-refresh me-2"></i>Reset Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Calendar Grid Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Semester Ganjil -->
            <div class="col-lg-6 mb-5" id="ganjilSemester">
                <div class="card shadow h-100 fade-in-left">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Semester Ganjil 2024/2025</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Juli 2024 -->
                        <div class="mb-4" data-month="07">
                            <h6 class="text-primary fw-bold mb-3">Juli 2024</h6>
                            <div class="event-item p-3" data-category="akademik" data-semester="ganjil" data-month="07">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-primary text-white text-center me-3">
                                        <div class="fw-bold">15</div>
                                        <small>Jul</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Awal Tahun Ajaran</h6>
                                        <p class="text-muted small mb-0">Hari pertama masuk sekolah tahun ajaran baru</p>
                                        <span class="badge bg-primary mt-2">Akademik</span>
                                    </div>
                                </div>
                            </div>
                            <div class="event-item p-3" data-category="kegiatan" data-semester="ganjil" data-month="07">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-info text-white text-center me-3">
                                        <div class="fw-bold">22-24</div>
                                        <small>Jul</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Masa Pengenalan Lingkungan Sekolah</h6>
                                        <p class="text-muted small mb-0">MPLS untuk siswa kelas X</p>
                                        <span class="badge bg-info mt-2">Kegiatan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agustus 2024 -->
                        <div class="mb-4" data-month="08">
                            <h6 class="text-primary fw-bold mb-3">Agustus 2024</h6>
                            <div class="event-item p-3" data-category="hari-besar" data-semester="ganjil" data-month="08">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-success text-white text-center me-3">
                                        <div class="fw-bold">17</div>
                                        <small>Agu</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Peringatan HUT RI</h6>
                                        <p class="text-muted small mb-0">Upacara dan lomba kemerdekaan</p>
                                        <span class="badge bg-success mt-2">Hari Besar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="event-item p-3" data-category="kegiatan" data-semester="ganjil" data-month="08">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-warning text-white text-center me-3">
                                        <div class="fw-bold">25</div>
                                        <small>Agu</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Rapat Komite Sekolah</h6>
                                        <p class="text-muted small mb-0">Rapat koordinasi dengan orang tua siswa</p>
                                        <span class="badge bg-warning mt-2">Kegiatan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- September 2024 -->
                        <div class="mb-4" data-month="09">
                            <h6 class="text-primary fw-bold mb-3">September 2024</h6>
                            <div class="event-item p-3" data-category="ujian" data-semester="ganjil" data-month="09">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-danger text-white text-center me-3">
                                        <div class="fw-bold">15-22</div>
                                        <small>Sep</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Penilaian Tengah Semester</h6>
                                        <p class="text-muted small mb-0">Ujian tengah semester ganjil</p>
                                        <span class="badge bg-danger mt-2">Ujian</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Oktober 2024 -->
                        <div class="mb-4" data-month="10">
                            <h6 class="text-primary fw-bold mb-3">Oktober 2024</h6>
                            <div class="event-item p-3" data-category="hari-besar" data-semester="ganjil" data-month="10">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-success text-white text-center me-3">
                                        <div class="fw-bold">28</div>
                                        <small>Okt</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Hari Sumpah Pemuda</h6>
                                        <p class="text-muted small mb-0">Upacara dan kegiatan kepemudaan</p>
                                        <span class="badge bg-success mt-2">Hari Besar</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- November 2024 -->
                        <div class="mb-4" data-month="11">
                            <h6 class="text-primary fw-bold mb-3">November 2024</h6>
                            <div class="event-item p-3" data-category="ujian" data-semester="ganjil" data-month="11">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-danger text-white text-center me-3">
                                        <div class="fw-bold">1-8</div>
                                        <small>Nov</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Ujian Tengah Semester</h6>
                                        <p class="text-muted small mb-0">UTS Semester Ganjil</p>
                                        <span class="badge bg-danger mt-2">Ujian</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Desember 2024 -->
                        <div class="mb-4" data-month="12">
                            <h6 class="text-primary fw-bold mb-3">Desember 2024</h6>
                            <div class="event-item p-3" data-category="ujian" data-semester="ganjil" data-month="12">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-danger text-white text-center me-3">
                                        <div class="fw-bold">5-15</div>
                                        <small>Des</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Ujian Akhir Semester</h6>
                                        <p class="text-muted small mb-0">UAS Semester Ganjil</p>
                                        <span class="badge bg-danger mt-2">Ujian</span>
                                    </div>
                                </div>
                            </div>
                            <div class="event-item p-3" data-category="libur" data-semester="ganjil" data-month="12">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-secondary text-white text-center me-3">
                                        <div class="fw-bold">18-31</div>
                                        <small>Des</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Libur Semester</h6>
                                        <p class="text-muted small mb-0">Libur akhir semester ganjil</p>
                                        <span class="badge bg-secondary mt-2">Libur</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Semester Genap -->
            <div class="col-lg-6 mb-5" id="genapSemester">
                <div class="card shadow h-100 fade-in-right">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Semester Genap 2024/2025</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Januari 2025 -->
                        <div class="mb-4" data-month="01">
                            <h6 class="text-success fw-bold mb-3">Januari 2025</h6>
                            <div class="event-item p-3" data-category="akademik" data-semester="genap" data-month="01">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-primary text-white text-center me-3">
                                        <div class="fw-bold">8</div>
                                        <small>Jan</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Awal Semester Genap</h6>
                                        <p class="text-muted small mb-0">Hari pertama masuk semester genap</p>
                                        <span class="badge bg-primary mt-2">Akademik</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Februari 2025 -->
                        <div class="mb-4" data-month="02">
                            <h6 class="text-success fw-bold mb-3">Februari 2025</h6>
                            <div class="event-item p-3" data-category="hari-besar" data-semester="genap" data-month="02">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-info text-white text-center me-3">
                                        <div class="fw-bold">14</div>
                                        <small>Feb</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Hari Kasih Sayang</h6>
                                        <p class="text-muted small mb-0">Kegiatan sosial dan bakti sosial</p>
                                        <span class="badge bg-info mt-2">Hari Besar</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Maret 2025 -->
                        <div class="mb-4" data-month="03">
                            <h6 class="text-success fw-bold mb-3">Maret 2025</h6>
                            <div class="event-item p-3" data-category="ujian" data-semester="genap" data-month="03">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-danger text-white text-center me-3">
                                        <div class="fw-bold">10-17</div>
                                        <small>Mar</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Penilaian Tengah Semester</h6>
                                        <p class="text-muted small mb-0">Ujian tengah semester genap</p>
                                        <span class="badge bg-danger mt-2">Ujian</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- April 2025 -->
                        <div class="mb-4" data-month="04">
                            <h6 class="text-success fw-bold mb-3">April 2025</h6>
                            <div class="event-item p-3" data-category="hari-besar" data-semester="genap" data-month="04">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-warning text-white text-center me-3">
                                        <div class="fw-bold">21</div>
                                        <small>Apr</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Hari Kartini</h6>
                                        <p class="text-muted small mb-0">Peringatan hari kartini dan lomba busana</p>
                                        <span class="badge bg-warning mt-2">Hari Besar</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mei 2025 -->
                        <div class="mb-4" data-month="05">
                            <h6 class="text-success fw-bold mb-3">Mei 2025</h6>
                            <div class="event-item p-3" data-category="ujian" data-semester="genap" data-month="05">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-danger text-white text-center me-3">
                                        <div class="fw-bold">5-12</div>
                                        <small>Mei</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Ujian Akhir Semester</h6>
                                        <p class="text-muted small mb-0">Ujian akhir semester genap</p>
                                        <span class="badge bg-danger mt-2">Ujian</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Juni 2025 -->
                        <div class="mb-4" data-month="06">
                            <h6 class="text-success fw-bold mb-3">Juni 2025</h6>
                            <div class="event-item p-3" data-category="libur" data-semester="genap" data-month="06">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-secondary text-white text-center me-3">
                                        <div class="fw-bold">15-30</div>
                                        <small>Jun</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Libur Kenaikan Kelas</h6>
                                        <p class="text-muted small mb-0">Libur akhir tahun ajaran</p>
                                        <span class="badge bg-secondary mt-2">Libur</span>
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

<!-- Enhanced Category Statistics -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="section-heading fade-in-up">Kategori Kegiatan</h2>
                <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Berbagai jenis kegiatan yang diselenggarakan selama tahun ajaran</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow text-center h-100 category-card fade-in-up" style="animation-delay: 0.1s;">
                    <div class="card-body p-4">
                        <i class="fas fa-book-open fa-3x text-primary mb-3 category-icon"></i>
                        <h5>Kegiatan Akademik</h5>
                        <p class="text-muted">Ujian, penilaian, dan kegiatan pembelajaran</p>
                        <span class="badge bg-primary fs-6">3 Kegiatan</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card shadow text-center h-100 category-card fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <i class="fas fa-clipboard-list fa-3x text-danger mb-3 category-icon"></i>
                        <h5>Ujian</h5>
                        <p class="text-muted">PTS, UTS, dan UAS semua semester</p>
                        <span class="badge bg-danger fs-6">5 Ujian</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card shadow text-center h-100 category-card fade-in-up" style="animation-delay: 0.3s;">
                    <div class="card-body p-4">
                        <i class="fas fa-flag fa-3x text-success mb-3 category-icon"></i>
                        <h5>Hari Besar</h5>
                        <p class="text-muted">Peringatan hari besar nasional</p>
                        <span class="badge bg-success fs-6">4 Peringatan</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card shadow text-center h-100 category-card fade-in-up" style="animation-delay: 0.4s;">
                    <div class="card-body p-4">
                        <i class="fas fa-umbrella-beach fa-3x text-secondary mb-3 category-icon"></i>
                        <h5>Libur Sekolah</h5>
                        <p class="text-muted">Periode libur dan cuti bersama</p>
                        <span class="badge bg-secondary fs-6">3 Periode</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Monthly Calendar View -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-heading fade-in-up">Kalender Bulanan</h2>
                <div class="btn-group flex-wrap" role="group" id="monthButtons">
                    <button type="button" class="btn btn-outline-primary month-btn active" data-month="10">Oktober 2024</button>
                    <button type="button" class="btn btn-outline-primary month-btn" data-month="11">November 2024</button>
                    <button type="button" class="btn btn-outline-primary month-btn" data-month="12">Desember 2024</button>
                    <button type="button" class="btn btn-outline-primary month-btn" data-month="01">Januari 2025</button>
                    <button type="button" class="btn btn-outline-primary month-btn" data-month="02">Februari 2025</button>
                    <button type="button" class="btn btn-outline-primary month-btn" data-month="03">Maret 2025</button>
                </div>
            </div>
        </div>

        <div class="card shadow fade-in-up" id="calendarView">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0" id="currentMonthTitle">Oktober 2024</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 calendar-table">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3 fw-bold">Minggu</th>
                                <th class="text-center py-3 fw-bold">Senin</th>
                                <th class="text-center py-3 fw-bold">Selasa</th>
                                <th class="text-center py-3 fw-bold">Rabu</th>
                                <th class="text-center py-3 fw-bold">Kamis</th>
                                <th class="text-center py-3 fw-bold">Jumat</th>
                                <th class="text-center py-3 fw-bold">Sabtu</th>
                            </tr>
                        </thead>
                        <tbody id="calendarBody">
                            <!-- Calendar body will be generated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Upcoming Events -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3 class="section-heading text-start fade-in-left"><i class="fas fa-clock me-2"></i>Kegiatan Mendatang</h3>
                
                <div id="upcomingEvents">
                    <!-- Events will be populated by JavaScript -->
                </div>

                <div class="text-center mt-4 fade-in-up">
                    <button class="btn btn-primary-enhanced btn-enhanced" id="loadMoreEvents">
                        <i class="fas fa-plus me-2"></i>Lihat Lebih Banyak
                    </button>
                </div>
            </div>

            <!-- Enhanced Sidebar -->
            <div class="col-md-4">
                <!-- Legend -->
                <div class="card shadow mb-4 fade-in-right">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Keterangan</h5>
                    </div>
                    <div class="card-body">
                        <div class="legend-item mb-2">
                            <span class="badge bg-primary me-2">●</span> Kegiatan Akademik
                        </div>
                        <div class="legend-item mb-2">
                            <span class="badge bg-success me-2">●</span> Hari Besar
                        </div>
                        <div class="legend-item mb-2">
                            <span class="badge bg-warning me-2">●</span> Kegiatan Sekolah
                        </div>
                        <div class="legend-item mb-2">
                            <span class="badge bg-info me-2">●</span> Kegiatan Khusus
                        </div>
                        <div class="legend-item mb-2">
                            <span class="badge bg-danger me-2">●</span> Ujian/Penilaian
                        </div>
                        <div class="legend-item mb-0">
                            <span class="badge bg-secondary me-2">●</span> Libur
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow mb-4 fade-in-right" style="animation-delay: 0.2s;">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-download me-2"></i>Download</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-pdf me-2"></i>Kalender PDF
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-calendar-plus me-2"></i>Google Calendar
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-file-excel me-2"></i>Export Excel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card shadow fade-in-right" style="animation-delay: 0.4s;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Tahun Ajaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center g-3">
                            <div class="col-6">
                                <h4 class="text-primary mb-0 fw-bold">180</h4>
                                <small class="text-muted">Hari Efektif</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success mb-0 fw-bold">36</h4>
                                <small class="text-muted">Minggu Efektif</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning mb-0 fw-bold">15</h4>
                                <small class="text-muted">Total Kegiatan</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-info mb-0 fw-bold">5</h4>
                                <small class="text-muted">Periode Ujian</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="text-white mb-3 fade-in-left">Butuh Informasi Lebih Lanjut?</h3>
                <p class="text-white mb-0 fade-in-left" style="animation-delay: 0.2s;">Hubungi kami untuk mendapatkan informasi lengkap tentang kalender akademik dan kegiatan sekolah</p>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <a href="#" class="btn btn-light btn-lg px-4 py-2 btn-enhanced scale-in" style="animation-delay: 0.4s;">
                    <i class="fas fa-phone me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Sample events data with enhanced structure
    const eventsData = [
        // Semester Ganjil Events
        { date: '2024-07-15', title: 'Awal Tahun Ajaran', description: 'Hari pertama masuk sekolah tahun ajaran baru', category: 'akademik', semester: 'ganjil', month: '07', badgeColor: 'primary' },
        { date: '2024-07-22', title: 'MPLS Dimulai', description: 'Masa Pengenalan Lingkungan Sekolah untuk siswa kelas X', category: 'kegiatan', semester: 'ganjil', month: '07', badgeColor: 'info' },
        { date: '2024-08-17', title: 'HUT RI ke-79', description: 'Upacara bendera dan lomba kemerdekaan', category: 'hari-besar', semester: 'ganjil', month: '08', badgeColor: 'success' },
        { date: '2024-08-25', title: 'Rapat Komite Sekolah', description: 'Rapat koordinasi dengan orang tua siswa', category: 'kegiatan', semester: 'ganjil', month: '08', badgeColor: 'warning' },
        { date: '2024-09-15', title: 'PTS Dimulai', description: 'Penilaian Tengah Semester ganjil', category: 'ujian', semester: 'ganjil', month: '09', badgeColor: 'danger' },
        { date: '2024-10-28', title: 'Hari Sumpah Pemuda', description: 'Upacara dan kegiatan kepemudaan', category: 'hari-besar', semester: 'ganjil', month: '10', badgeColor: 'success' },
        { date: '2024-11-01', title: 'UTS Dimulai', description: 'Ujian Tengah Semester ganjil', category: 'ujian', semester: 'ganjil', month: '11', badgeColor: 'danger' },
        { date: '2024-12-05', title: 'UAS Dimulai', description: 'Ujian Akhir Semester ganjil', category: 'ujian', semester: 'ganjil', month: '12', badgeColor: 'danger' },
        { date: '2024-12-18', title: 'Libur Semester', description: 'Libur akhir semester ganjil', category: 'libur', semester: 'ganjil', month: '12', badgeColor: 'secondary' },
        
        // Semester Genap Events
        { date: '2025-01-08', title: 'Awal Semester Genap', description: 'Hari pertama masuk semester genap', category: 'akademik', semester: 'genap', month: '01', badgeColor: 'primary' },
        { date: '2025-02-14', title: 'Hari Kasih Sayang', description: 'Kegiatan sosial dan bakti sosial', category: 'hari-besar', semester: 'genap', month: '02', badgeColor: 'info' },
        { date: '2025-03-10', title: 'PTS Genap', description: 'Penilaian Tengah Semester genap', category: 'ujian', semester: 'genap', month: '03', badgeColor: 'danger' },
        { date: '2025-04-21', title: 'Hari Kartini', description: 'Peringatan hari kartini dan lomba busana', category: 'hari-besar', semester: 'genap', month: '04', badgeColor: 'warning' },
        { date: '2025-05-05', title: 'UAS Genap', description: 'Ujian akhir semester genap', category: 'ujian', semester: 'genap', month: '05', badgeColor: 'danger' },
        { date: '2025-06-15', title: 'Libur Kenaikan Kelas', description: 'Libur akhir tahun ajaran', category: 'libur', semester: 'genap', month: '06', badgeColor: 'secondary' }
    ];
    
    // Calendar data for different months
    const calendarData = {
        '10': { // Oktober 2024
            title: 'Oktober 2024',
            events: [
                { date: 28, title: 'Sumpah Pemuda', color: 'bg-warning' },
                { date: 31, title: 'Workshop', color: 'bg-info' }
            ],
            days: [
                [29, 30, 1, 2, 3, 4, 5],
                [6, 7, 8, 9, 10, 11, 12],
                [13, 14, 15, 16, 17, 18, 19],
                [20, 21, 22, 23, 24, 25, 26],
                [27, 28, 29, 30, 31, 1, 2]
            ]
        },
        '11': { // November 2024
            title: 'November 2024',
            events: [
                { date: 1, title: 'UTS Dimulai', color: 'bg-danger' },
                { date: 8, title: 'UTS Selesai', color: 'bg-danger' }
            ],
            days: [
                [27, 28, 29, 30, 31, 1, 2],
                [3, 4, 5, 6, 7, 8, 9],
                [10, 11, 12, 13, 14, 15, 16],
                [17, 18, 19, 20, 21, 22, 23],
                [24, 25, 26, 27, 28, 29, 30]
            ]
        },
        '12': { // Desember 2024
            title: 'Desember 2024',
            events: [
                { date: 5, title: 'UAS Dimulai', color: 'bg-danger' },
                { date: 18, title: 'Libur', color: 'bg-secondary' }
            ],
            days: [
                [1, 2, 3, 4, 5, 6, 7],
                [8, 9, 10, 11, 12, 13, 14],
                [15, 16, 17, 18, 19, 20, 21],
                [22, 23, 24, 25, 26, 27, 28],
                [29, 30, 31, 1, 2, 3, 4]
            ]
        },
        '01': { // Januari 2025
            title: 'Januari 2025',
            events: [
                { date: 8, title: 'Semester Genap', color: 'bg-primary' }
            ],
            days: [
                [29, 30, 31, 1, 2, 3, 4],
                [5, 6, 7, 8, 9, 10, 11],
                [12, 13, 14, 15, 16, 17, 18],
                [19, 20, 21, 22, 23, 24, 25],
                [26, 27, 28, 29, 30, 31, 1]
            ]
        },
        '02': { // Februari 2025
            title: 'Februari 2025',
            events: [
                { date: 14, title: 'Kasih Sayang', color: 'bg-info' }
            ],
            days: [
                [26, 27, 28, 29, 30, 31, 1],
                [2, 3, 4, 5, 6, 7, 8],
                [9, 10, 11, 12, 13, 14, 15],
                [16, 17, 18, 19, 20, 21, 22],
                [23, 24, 25, 26, 27, 28, 1]
            ]
        },
        '03': { // Maret 2025
            title: 'Maret 2025',
            events: [
                { date: 10, title: 'PTS Genap', color: 'bg-danger' }
            ],
            days: [
                [23, 24, 25, 26, 27, 28, 1],
                [2, 3, 4, 5, 6, 7, 8],
                [9, 10, 11, 12, 13, 14, 15],
                [16, 17, 18, 19, 20, 21, 22],
                [23, 24, 25, 26, 27, 28, 29]
            ]
        }
    };

    // Enhanced Animation Observer
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
    
    // Filter functionality
    const semesterFilter = document.getElementById('semesterFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const monthFilter = document.getElementById('monthFilter');
    const resetFilter = document.getElementById('resetFilter');
    
    function applyFilters() {
        const selectedSemester = semesterFilter.value;
        const selectedCategory = categoryFilter.value;
        const selectedMonth = monthFilter.value;
        
        // Filter semester columns
        const ganjilSemester = document.getElementById('ganjilSemester');
        const genapSemester = document.getElementById('genapSemester');
        
        if (selectedSemester === 'ganjil') {
            ganjilSemester.style.display = 'block';
            genapSemester.style.display = 'none';
        } else if (selectedSemester === 'genap') {
            ganjilSemester.style.display = 'none';
            genapSemester.style.display = 'block';
        } else {
            ganjilSemester.style.display = 'block';
            genapSemester.style.display = 'block';
        }
        
        // Filter events
        const eventItems = document.querySelectorAll('.event-item');
        eventItems.forEach(item => {
            const itemSemester = item.dataset.semester;
            const itemCategory = item.dataset.category;
            const itemMonth = item.dataset.month;
            
            let showItem = true;
            
            if (selectedSemester !== 'all' && selectedSemester !== itemSemester) {
                showItem = false;
            }
            
            if (selectedCategory !== 'all' && selectedCategory !== itemCategory) {
                showItem = false;
            }
            
            if (selectedMonth !== 'all' && selectedMonth !== itemMonth) {
                showItem = false;
            }
            
            if (showItem) {
                item.classList.remove('hidden');
                item.classList.add('filter-active');
            } else {
                item.classList.add('hidden');
                item.classList.remove('filter-active');
            }
        });
        
        // Filter month sections
        const monthSections = document.querySelectorAll('[data-month]');
        monthSections.forEach(section => {
            if (selectedMonth === 'all' || section.dataset.month === selectedMonth) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    }
    
    // Initialize filter functionality
    semesterFilter.addEventListener('change', applyFilters);
    categoryFilter.addEventListener('change', applyFilters);
    monthFilter.addEventListener('change', applyFilters);
    
    resetFilter.addEventListener('click', function() {
        semesterFilter.value = 'all';
        categoryFilter.value = 'all';
        monthFilter.value = 'all';
        applyFilters();
    });
    
    // Calendar functionality
    function renderCalendar(month) {
        const calendarBody = document.getElementById('calendarBody');
        const monthData = calendarData[month];
        
        document.getElementById('currentMonthTitle').textContent = monthData.title;
        calendarBody.innerHTML = '';
        
        monthData.days.forEach(week => {
            const row = document.createElement('tr');
            
            week.forEach(day => {
                const cell = document.createElement('td');
                cell.className = 'text-center';
                
                if (day < 10) {
                    cell.classList.add('text-muted');
                }
                
                cell.textContent = day;
                
                // Add event indicators
                monthData.events.forEach(event => {
                    if (event.date === day) {
                        cell.classList.add('event-day', event.color, 'text-white');
                        cell.setAttribute('data-bs-toggle', 'tooltip');
                        cell.setAttribute('title', event.title);
                    }
                });
                
                row.appendChild(cell);
            });
            
            calendarBody.appendChild(row);
        });
        
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Month buttons functionality
    const monthButtons = document.querySelectorAll('.month-btn');
    monthButtons.forEach(button => {
        button.addEventListener('click', function() {
            monthButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            renderCalendar(this.dataset.month);
        });
    });
    
    // Initialize upcoming events
    function renderUpcomingEvents() {
        const upcomingEventsContainer = document.getElementById('upcomingEvents');
        
        // Sort events by date
        const sortedEvents = [...eventsData].sort((a, b) => new Date(a.date) - new Date(b.date));
        
        // Get current date
        const currentDate = new Date();
        
        // Filter upcoming events (next 30 days)
        const upcomingEvents = sortedEvents.filter(event => {
            const eventDate = new Date(event.date);
            const diffTime = Math.abs(eventDate - currentDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays <= 30 && eventDate >= currentDate;
        });
        
        // Render events
        upcomingEventsContainer.innerHTML = '';
        
        if (upcomingEvents.length === 0) {
            upcomingEventsContainer.innerHTML = '<div class="alert alert-info">Tidak ada kegiatan dalam 30 hari ke depan</div>';
            return;
        }
        
        upcomingEvents.forEach(event => {
            const eventDate = new Date(event.date);
            const formattedDate = eventDate.toLocaleDateString('id-ID', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            const eventElement = document.createElement('div');
            eventElement.className = 'card shadow-sm mb-3';
            eventElement.innerHTML = `
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-${event.badgeColor} text-white p-3 rounded me-3">
                            <h5 class="mb-0">${eventDate.getDate()}</h5>
                            <small>${eventDate.toLocaleDateString('id-ID', { month: 'short' })}</small>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">${event.title}</h6>
                            <p class="text-muted small mb-0">${formattedDate}</p>
                            <span class="badge bg-${event.badgeColor} mt-1">${event.category}</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-plus me-2"></i>Tambah ke kalender</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-share-alt me-2"></i>Bagikan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            `;
            
            upcomingEventsContainer.appendChild(eventElement);
        });
    }
    
    // Load more events functionality
    document.getElementById('loadMoreEvents').addEventListener('click', function() {
        // This would typically load more events from a server
        // For demonstration, we'll just show an alert
        alert('Fitur "Lihat Lebih Banyak" akan memuat lebih banyak kegiatan dari database.');
    });
    
    // Initialize the page
    renderCalendar('10'); // Default to October 2024
    renderUpcomingEvents();
    applyFilters(); // Apply initial filters
});
</script>
</body>
</html>