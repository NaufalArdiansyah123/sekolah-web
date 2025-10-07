@extends('layouts.public')

@section('title', 'Download - SMA Negeri 1 Balong')

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
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2128&q=80') center/cover no-repeat;
        color: white;
        padding: 100px 0;
        min-height: 60vh;
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
    
    .fade-in {
        opacity: 0;
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
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
    
    .fade-in.animate {
        opacity: 1;
    }
    
    .scale-in.animate {
        opacity: 1;
        transform: scale(1);
    }

    /* Enhanced Stats Section */
    .stats-section {
        padding: 60px 0;
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
    
    .stats-number {
        font-family: 'Arial', monospace;
        font-weight: 900 !important;
        letter-spacing: -2px;
        line-height: 1;
        transition: all 0.3s ease;
    }

    /* Enhanced Cards */
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
    
    /* Download Category Cards */
    .download-category-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 20px;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        position: relative;
        cursor: pointer;
    }
    
    .download-category-card::before {
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
    
    .download-category-card:hover::before {
        opacity: 1;
    }
    
    .download-category-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }

    /* Download Item Cards */
    .download-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 12px;
        background: white;
        border: 1px solid #e2e8f0;
        padding: 20px;
        margin-bottom: 15px;
        position: relative;
    }
    
    .download-item:hover {
        transform: translateX(10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-color: var(--secondary-color);
    }
    
    .download-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(to bottom, var(--secondary-color), var(--accent-color));
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }
    
    .download-item:hover::before {
        transform: scaleY(1);
    }

    .download-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .download-item:hover .download-icon {
        transform: scale(1.1) rotateY(360deg);
    }

    /* File Type Colors */
    .file-pdf { background: linear-gradient(135deg, #dc3545, #c82333); }
    .file-doc { background: linear-gradient(135deg, #007bff, #0056b3); }
    .file-img { background: linear-gradient(135deg, #28a745, #1e7e34); }
    .file-video { background: linear-gradient(135deg, #fd7e14, #e55a00); }
    .file-zip { background: linear-gradient(135deg, #6f42c1, #5a32a3); }

    /* Search and Filter */
    .search-filter-section {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }

    .search-input {
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
    }

    .filter-btn {
        border-radius: 25px;
        padding: 8px 20px;
        border: 2px solid #e2e8f0;
        background: white;
        transition: all 0.3s ease;
        margin: 5px;
    }

    .filter-btn.active,
    .filter-btn:hover {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
        color: white;
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
    
    .btn-download {
        background: linear-gradient(135deg, #28a745, #1e7e34);
        border: none;
        color: white;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }
    
    .btn-download:hover {
        box-shadow: 0 12px 35px rgba(40, 167, 69, 0.4);
        background: linear-gradient(135deg, #218838, #1c7430);
        color: white;
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

    /* Recent Downloads */
    .recent-downloads {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 16px;
        padding: 25px;
    }

    /* Download Progress */
    .download-progress {
        display: none;
        margin-top: 10px;
    }

    .progress {
        height: 6px;
        border-radius: 3px;
        background-color: #e9ecef;
    }

    .progress-bar {
        background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        border-radius: 3px;
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
        
        .download-item {
            padding: 15px;
        }
        
        .stats-number {
            font-size: 2.5rem !important;
        }
    }
    
    @media (max-width: 576px) {
        .hero-section h1 {
            font-size: 2rem;
        }
        
        .stats-number {
            font-size: 2rem !important;
        }
    }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Download Center</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">Akses berbagai materi pembelajaran, dokumentasi kegiatan, dan file penting lainnya dari SMA Negeri 1 Balong</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-download hero-icon scale-in" style="animation-delay: 0.4s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-sm-6">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                        <h3 class="stats-number display-5 fw-bold text-danger" data-target="245">0</h3>
                        <p class="text-muted mb-0 fw-medium">Dokumen PDF</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <i class="fas fa-images fa-3x text-success mb-3"></i>
                        <h3 class="stats-number display-5 fw-bold text-success" data-target="1250">0</h3>
                        <p class="text-muted mb-0 fw-medium">Foto & Gambar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                    <div class="card-body p-4">
                        <i class="fas fa-video fa-3x text-warning mb-3"></i>
                        <h3 class="stats-number display-5 fw-bold text-warning" data-target="89">0</h3>
                        <p class="text-muted mb-0 fw-medium">Video Kegiatan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.6s;">
                    <div class="card-body p-4">
                        <i class="fas fa-download fa-3x text-info mb-3"></i>
                        <h3 class="stats-number display-5 fw-bold text-info" data-target="15420">0</h3>
                        <p class="text-muted mb-0 fw-medium">Total Download</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-5">
    <div class="container">
        <div class="search-filter-section fade-in-up">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <div class="input-group">
                        <input type="text" class="form-control search-input" placeholder="Cari file atau materi..." id="searchInput">
                        <button class="btn btn-primary btn-enhanced" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <button class="filter-btn active" data-filter="all">Semua</button>
                        <button class="filter-btn" data-filter="pdf">PDF</button>
                        <button class="filter-btn" data-filter="image">Gambar</button>
                        <button class="filter-btn" data-filter="video">Video</button>
                        <button class="filter-btn" data-filter="document">Dokumen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Download Categories -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-heading fade-in-up">Kategori Download</h2>
        
        <div class="row g-4">
            <!-- Materi Pembelajaran -->
            <div class="col-lg-4 col-md-6">
                <div class="download-category-card fade-in-up" onclick="toggleCategory('materi')">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-book-open fa-4x text-primary mb-3"></i>
                        <h4>Materi Pembelajaran</h4>
                        <p class="text-muted">Silabus, RPP, dan bahan ajar untuk berbagai mata pelajaran</p>
                        <span class="badge bg-primary fs-6">45 File</span>
                    </div>
                </div>
            </div>

            <!-- Dokumentasi Kegiatan -->
            <div class="col-lg-4 col-md-6">
                <div class="download-category-card fade-in-up" style="animation-delay: 0.2s;" onclick="toggleCategory('dokumentasi')">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-camera fa-4x text-success mb-3"></i>
                        <h4>Dokumentasi Kegiatan</h4>
                        <p class="text-muted">Foto dan video kegiatan sekolah, event, dan prestasi</p>
                        <span class="badge bg-success fs-6">230 File</span>
                    </div>
                </div>
            </div>

            <!-- Dokumen Resmi -->
            <div class="col-lg-4 col-md-6">
                <div class="download-category-card fade-in-up" style="animation-delay: 0.4s;" onclick="toggleCategory('resmi')">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-file-contract fa-4x text-warning mb-3"></i>
                        <h4>Dokumen Resmi</h4>
                        <p class="text-muted">Formulir, surat edaran, dan dokumen administrasi</p>
                        <span class="badge bg-warning fs-6">28 File</span>
                    </div>
                </div>
            </div>

            <!-- E-Book & Jurnal -->
            <div class="col-lg-4 col-md-6">
                <div class="download-category-card fade-in-up" style="animation-delay: 0.6s;" onclick="toggleCategory('ebook')">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-book fa-4x text-info mb-3"></i>
                        <h4>E-Book & Jurnal</h4>
                        <p class="text-muted">Koleksi buku digital dan jurnal pendidikan</p>
                        <span class="badge bg-info fs-6">67 File</span>
                    </div>
                </div>
            </div>

            <!-- Software & Tools -->
            <div class="col-lg-4 col-md-6">
                <div class="download-category-card fade-in-up" style="animation-delay: 0.8s;" onclick="toggleCategory('software')">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-laptop-code fa-4x text-purple mb-3" style="color: #6f42c1 !important;"></i>
                        <h4>Software & Tools</h4>
                        <p class="text-muted">Aplikasi pembelajaran dan tools pendukung</p>
                        <span class="badge bg-secondary fs-6">12 File</span>
                    </div>
                </div>
            </div>

            <!-- Template & Format -->
            <div class="col-lg-4 col-md-6">
                <div class="download-category-card fade-in-up" style="animation-delay: 1.0s;" onclick="toggleCategory('template')">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-file-alt fa-4x text-danger mb-3"></i>
                        <h4>Template & Format</h4>
                        <p class="text-muted">Template surat, format laporan, dan desain</p>
                        <span class="badge bg-danger fs-6">34 File</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Download Lists (Hidden by default) -->
<section class="py-5" id="downloadLists" style="display: none;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0" id="categoryTitle">Kategori Download</h4>
                        <button class="btn btn-light btn-sm" onclick="toggleCategory('')">
                            <i class="fas fa-times"></i> Tutup
                        </button>
                    </div>
                    <div class="card-body p-4" id="downloadItems">
                        <!-- Download items will be populated here -->
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Recent Downloads -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Download Terbaru</h5>
                    </div>
                    <div class="card-body recent-downloads">
                        <div class="d-flex align-items-center mb-3">
                            <div class="download-icon file-pdf me-3">
                                <i class="fas fa-file-pdf text-white"></i>
                            </div>
                            <div class="flex-fill">
                                <h6 class="mb-1">Silabus Matematika 2024</h6>
                                <small class="text-muted">2 jam yang lalu</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="download-icon file-img me-3">
                                <i class="fas fa-image text-white"></i>
                            </div>
                            <div class="flex-fill">
                                <h6 class="mb-1">Foto Wisuda 2024</h6>
                                <small class="text-muted">5 jam yang lalu</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="download-icon file-video me-3">
                                <i class="fas fa-video text-white"></i>
                            </div>
                            <div class="flex-fill">
                                <h6 class="mb-1">Video Penerimaan Siswa</h6>
                                <small class="text-muted">1 hari yang lalu</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Download Tips -->
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips Download</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pastikan koneksi internet stabil</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gunakan browser terbaru</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Periksa ruang penyimpanan</li>
                            <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Scan file dengan antivirus</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-heading fade-in-up">Pertanyaan Umum</h2>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 shadow-sm fade-in-up">
                        <h3 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Bagaimana cara mendownload file?
                            </button>
                        </h3>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Pilih kategori yang diinginkan, klik file yang akan didownload, kemudian klik tombol download. File akan tersimpan di folder download komputer Anda.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Apakah semua file gratis?
                            </button>
                        </h3>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya, semua file yang tersedia di download center ini gratis untuk siswa, guru, dan masyarakat umum yang membutuhkan.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                File rusak atau tidak bisa dibuka?
                            </button>
                        </h3>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Jika mengalami masalah dengan file, silakan hubungi admin melalui email atau WhatsApp. Kami akan segera memperbaiki atau mengganti file yang bermasalah.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm fade-in-up" style="animation-delay: 0.6s;">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                Bagaimana cara request file tertentu?
                            </button>
                        </h3>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda dapat mengirim permintaan file melalui form kontak atau langsung menghubungi admin. Kami akan berusaha menyediakan file yang dibutuhkan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Sample download data
    const downloadData = {
        materi: {
            title: 'Materi Pembelajaran',
            icon: 'fas fa-book-open',
            color: 'primary',
            items: [
                {
                    name: 'Silabus Matematika Kelas X 2024',
                    type: 'pdf',
                    size: '2.3 MB',
                    date: '15 Agt 2024',
                    downloads: 245,
                    description: 'Silabus lengkap mata pelajaran Matematika untuk kelas X semester 1 dan 2'
                },
                {
                    name: 'RPP Fisika Kelas XI - Gelombang',
                    type: 'doc',
                    size: '1.8 MB',
                    date: '12 Agt 2024',
                    downloads: 156,
                    description: 'Rencana Pelaksanaan Pembelajaran materi gelombang untuk kelas XI'
                },
                {
                    name: 'Modul Bahasa Indonesia - Teks Eksposisi',
                    type: 'pdf',
                    size: '4.1 MB',
                    date: '10 Agt 2024',
                    downloads: 189,
                    description: 'Modul pembelajaran teks eksposisi dengan contoh dan latihan soal'
                },
                {
                    name: 'Soal Latihan UN Kimia 2024',
                    type: 'pdf',
                    size: '1.5 MB',
                    date: '08 Agt 2024',
                    downloads: 312,
                    description: 'Kumpulan soal latihan untuk persiapan ujian nasional kimia'
                },
                {
                    name: 'Materi Sejarah - Kemerdekaan Indonesia',
                    type: 'pdf',
                    size: '3.7 MB',
                    date: '05 Agt 2024',
                    downloads: 198,
                    description: 'Materi lengkap tentang perjuangan kemerdekaan Indonesia'
                }
            ]
        },
        dokumentasi: {
            title: 'Dokumentasi Kegiatan',
            icon: 'fas fa-camera',
            color: 'success',
            items: [
                {
                    name: 'Foto Upacara Kemerdekaan 2024',
                    type: 'zip',
                    size: '45.2 MB',
                    date: '17 Agt 2024',
                    downloads: 89,
                    description: 'Dokumentasi lengkap upacara kemerdekaan RI ke-79'
                },
                {
                    name: 'Video Pentas Seni Sekolah',
                    type: 'video',
                    size: '125.8 MB',
                    date: '15 Agt 2024',
                    downloads: 67,
                    description: 'Video pentas seni dalam rangka HUT kemerdekaan'
                },
                {
                    name: 'Album Wisuda Kelas XII 2024',
                    type: 'zip',
                    size: '78.9 MB',
                    date: '20 Jul 2024',
                    downloads: 234,
                    description: 'Koleksi foto wisuda dan pelepasan siswa kelas XII'
                },
                {
                    name: 'Dokumentasi Lomba Sains 2024',
                    type: 'zip',
                    size: '23.4 MB',
                    date: '12 Jul 2024',
                    downloads: 145,
                    description: 'Foto kegiatan olimpiade sains tingkat sekolah'
                }
            ]
        },
        resmi: {
            title: 'Dokumen Resmi',
            icon: 'fas fa-file-contract',
            color: 'warning',
            items: [
                {
                    name: 'Formulir Pendaftaran Siswa Baru 2025',
                    type: 'pdf',
                    size: '890 KB',
                    date: '20 Agt 2024',
                    downloads: 456,
                    description: 'Formulir pendaftaran untuk calon siswa tahun ajaran 2025/2026'
                },
                {
                    name: 'Surat Edaran - Protokol Kesehatan',
                    type: 'pdf',
                    size: '1.2 MB',
                    date: '18 Agt 2024',
                    downloads: 178,
                    description: 'Panduan protokol kesehatan di lingkungan sekolah'
                },
                {
                    name: 'Kalender Akademik 2025/2026',
                    type: 'pdf',
                    size: '2.1 MB',
                    date: '15 Agt 2024',
                    downloads: 567,
                    description: 'Jadwal lengkap kegiatan akademik tahun ajaran 2025/2026'
                },
                {
                    name: 'Peraturan Tata Tertib Sekolah',
                    type: 'pdf',
                    size: '1.8 MB',
                    date: '10 Agt 2024',
                    downloads: 289,
                    description: 'Peraturan dan tata tertib untuk siswa SMA Negeri 1 Balong'
                }
            ]
        },
        ebook: {
            title: 'E-Book & Jurnal',
            icon: 'fas fa-book',
            color: 'info',
            items: [
                {
                    name: 'E-Book Matematika Dasar SMA',
                    type: 'pdf',
                    size: '15.7 MB',
                    date: '22 Agt 2024',
                    downloads: 234,
                    description: 'Buku digital matematika dasar untuk siswa SMA'
                },
                {
                    name: 'Jurnal Penelitian Pendidikan Vol. 12',
                    type: 'pdf',
                    size: '8.9 MB',
                    date: '20 Agt 2024',
                    downloads: 67,
                    description: 'Jurnal ilmiah tentang inovasi dalam pendidikan'
                },
                {
                    name: 'Kamus Bahasa Indonesia Digital',
                    type: 'pdf',
                    size: '25.4 MB',
                    date: '18 Agt 2024',
                    downloads: 345,
                    description: 'Kamus bahasa Indonesia lengkap dalam format digital'
                }
            ]
        },
        software: {
            title: 'Software & Tools',
            icon: 'fas fa-laptop-code',
            color: 'secondary',
            items: [
                {
                    name: 'Aplikasi Simulasi Fisika',
                    type: 'zip',
                    size: '125.6 MB',
                    date: '25 Agt 2024',
                    downloads: 89,
                    description: 'Software simulasi eksperimen fisika untuk pembelajaran'
                },
                {
                    name: 'Template PowerPoint Presentasi',
                    type: 'zip',
                    size: '34.2 MB',
                    date: '23 Agt 2024',
                    downloads: 156,
                    description: 'Koleksi template PowerPoint untuk presentasi siswa'
                },
                {
                    name: 'Font Pack untuk Desain',
                    type: 'zip',
                    size: '67.8 MB',
                    date: '20 Agt 2024',
                    downloads: 123,
                    description: 'Paket font untuk keperluan desain grafis dan presentasi'
                }
            ]
        },
        template: {
            title: 'Template & Format',
            icon: 'fas fa-file-alt',
            color: 'danger',
            items: [
                {
                    name: 'Template Surat Resmi Sekolah',
                    type: 'doc',
                    size: '456 KB',
                    date: '26 Agt 2024',
                    downloads: 234,
                    description: 'Template surat resmi dengan kop sekolah'
                },
                {
                    name: 'Format Laporan Praktikum IPA',
                    type: 'doc',
                    size: '678 KB',
                    date: '24 Agt 2024',
                    downloads: 189,
                    description: 'Format standar laporan praktikum mata pelajaran IPA'
                },
                {
                    name: 'Template Proposal Kegiatan',
                    type: 'doc',
                    size: '890 KB',
                    date: '22 Agt 2024',
                    downloads: 145,
                    description: 'Template proposal untuk kegiatan ekstrakurikuler'
                },
                {
                    name: 'Desain Banner Kegiatan Sekolah',
                    type: 'zip',
                    size: '23.4 MB',
                    date: '20 Agt 2024',
                    downloads: 167,
                    description: 'Template desain banner untuk berbagai kegiatan sekolah'
                }
            ]
        }
    };

    // Counter Animation Function
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
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
    
    // Intersection Observer for animations
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
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .fade-in, .scale-in');
    animatedElements.forEach(element => {
        observer.observe(element);
    });
    
    // Stats counter animation
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

    // Toggle category function
    window.toggleCategory = function(category) {
        const downloadLists = document.getElementById('downloadLists');
        const categoryTitle = document.getElementById('categoryTitle');
        const downloadItems = document.getElementById('downloadItems');
        
        if (!category) {
            downloadLists.style.display = 'none';
            return;
        }
        
        const data = downloadData[category];
        if (!data) return;
        
        categoryTitle.innerHTML = `<i class="${data.icon} me-2"></i>${data.title}`;
        
        let itemsHTML = '';
        data.items.forEach((item, index) => {
            const fileTypeClass = getFileTypeClass(item.type);
            const fileIcon = getFileIcon(item.type);
            
            itemsHTML += `
                <div class="download-item fade-in-up" style="animation-delay: ${index * 0.1}s;">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="download-icon ${fileTypeClass}">
                                <i class="${fileIcon} text-white"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="mb-1">${item.name}</h6>
                            <p class="text-muted mb-2 small">${item.description}</p>
                            <div class="d-flex gap-3 text-muted small">
                                <span><i class="fas fa-calendar me-1"></i>${item.date}</span>
                                <span><i class="fas fa-hdd me-1"></i>${item.size}</span>
                                <span><i class="fas fa-download me-1"></i>${item.downloads} downloads</span>
                            </div>
                            <div class="download-progress" id="progress-${index}">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted">Downloading...</small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-download btn-enhanced" onclick="downloadFile('${item.name}', ${index})">
                                <i class="fas fa-download me-2"></i>Download
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        
        downloadItems.innerHTML = itemsHTML;
        downloadLists.style.display = 'block';
        downloadLists.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Re-observe new elements for animation
        const newElements = downloadLists.querySelectorAll('.fade-in-up');
        newElements.forEach(element => {
            observer.observe(element);
        });
    };

    // File type helper functions
    function getFileTypeClass(type) {
        const typeClasses = {
            'pdf': 'file-pdf',
            'doc': 'file-doc',
            'image': 'file-img',
            'video': 'file-video',
            'zip': 'file-zip'
        };
        return typeClasses[type] || 'file-pdf';
    }

    function getFileIcon(type) {
        const typeIcons = {
            'pdf': 'fas fa-file-pdf',
            'doc': 'fas fa-file-word',
            'image': 'fas fa-image',
            'video': 'fas fa-video',
            'zip': 'fas fa-file-archive'
        };
        return typeIcons[type] || 'fas fa-file';
    }

    // Download file function
    window.downloadFile = function(fileName, index) {
        const button = event.target.closest('button');
        const progressDiv = document.getElementById(`progress-${index}`);
        const progressBar = progressDiv.querySelector('.progress-bar');
        
        // Show progress
        progressDiv.style.display = 'block';
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Downloading...';
        
        // Simulate download progress
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 100) {
                progress = 100;
                clearInterval(interval);
                
                // Complete download
                setTimeout(() => {
                    progressDiv.style.display = 'none';
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-check me-2"></i>Downloaded';
                    button.classList.remove('btn-download');
                    button.classList.add('btn', 'btn-success');
                    
                    // Show success message
                    showNotification(`${fileName} berhasil didownload!`, 'success');
                    
                    // Reset after 3 seconds
                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-download me-2"></i>Download';
                        button.classList.remove('btn-success');
                        button.classList.add('btn-download');
                    }, 3000);
                }, 500);
            }
            
            progressBar.style.width = Math.min(progress, 100) + '%';
        }, 200);
    };

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        // Implementation would filter download items based on search term
        console.log('Searching for:', searchTerm);
    });

    // Filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            console.log('Filtering by:', filter);
            // Implementation would filter items based on file type
        });
    });

    // Notification function
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    console.log('Download center loaded successfully!');
});
</script>
@endsection