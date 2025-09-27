@extends('layouts.public')

@section('content')
<style>
    .program-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.2);
        transition: all 0.3s ease;
    }
    
    .card:hover .program-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .program-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .program-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .program-card .card-body {
        padding: 2rem;
    }
    
    .program-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #2d3748;
    }
    
    .program-subtitle {
        font-size: 1rem;
        color: #718096;
        margin-bottom: 1rem;
        font-weight: 500;
    }
    
    .program-description {
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .skill-list {
        list-style: none;
        padding: 0;
        margin-bottom: 2rem;
    }
    
    .skill-list li {
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
    }
    
    .skill-list li:last-child {
        border-bottom: none;
    }
    
    .skill-list i {
        margin-right: 0.75rem;
        width: 16px;
    }
    

    
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
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
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 3rem;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Program Keahlian</h1>
                <p class="lead mb-4">SMK PGRI 2 PONOROGO menawarkan 9 program keahlian unggulan di bidang teknologi dan industri yang dirancang untuk mempersiapkan tenaga kerja profesional dan siap kerja.</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-tools" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Program Keahlian Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="section-title">Program Keahlian Unggulan</h2>
                <p class="text-muted">9 Program keahlian yang dirancang khusus untuk menghasilkan lulusan yang kompeten dan siap bersaing di dunia industri</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- TAB - Teknik Alat Berat -->
            <div class="col-md-6 col-lg-4">
                <div class="card program-card h-100">
                    <div class="card-body text-center">
                        <div class="program-icon text-warning">
                            <i class="fas fa-tractor"></i>
                        </div>
                        <h4 class="program-title">Teknik Alat Berat</h4>
                        <p class="program-subtitle">(TAB)</p>
                        <p class="program-description">Program keahlian yang mempelajari perawatan, perbaikan, dan pengoperasian alat-alat berat untuk konstruksi dan pertambangan.</p>
                        <ul class="skill-list text-start">
                            <li><i class="fas fa-wrench text-warning"></i> Maintenance Alat Berat</li>
                            <li><i class="fas fa-cogs text-warning"></i> Sistem Hidrolik</li>
                            <li><i class="fas fa-tools text-warning"></i> Engine Heavy Equipment</li>
                            <li><i class="fas fa-hard-hat text-warning"></i> Safety Procedures</li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- TKR - Teknik Kendaraan Ringan -->
            <div class="col-md-6 col-lg-4">
                <div class="card program-card h-100">
                    <div class="card-body text-center">
                        <div class="program-icon text-primary">
                            <i class="fas fa-car"></i>
                        </div>
                        <h4 class="program-title">Teknik Kendaraan Ringan</h4>
                        <p class="program-subtitle">(TKR)</p>
                        <p class="program-description">Program keahlian yang fokus pada perawatan, perbaikan, dan modifikasi kendaraan bermotor roda empat.</p>
                        <ul class="skill-list text-start">
                            <li><i class="fas fa-car-battery text-primary"></i> Sistem Kelistrikan Mobil</li>
                            <li><i class="fas fa-oil-can text-primary"></i> Engine Management</li>
                            <li><i class="fas fa-car-side text-primary"></i> Sistem Suspensi</li>
                            <li><i class="fas fa-tachometer-alt text-primary"></i> Diagnostic Tools</li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- TSM - Teknik Sepeda Motor -->
            <div class="col-md-6 col-lg-4">
                <div class="card program-card h-100">
                    <div class="card-body text-center">
                        <div class="program-icon text-danger">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <h4 class="program-title">Teknik Sepeda Motor</h4>
                        <p class="program-subtitle">(TSM)</p>
                        <p class="program-description">Program keahlian yang mempelajari perawatan, perbaikan, dan modifikasi sepeda motor dengan teknologi terkini.</p>
                        <ul class="skill-list text-start">
                            <li><i class="fas fa-motorcycle text-danger"></i> Engine 2 & 4 Stroke</li>
                            <li><i class="fas fa-bolt text-danger"></i> Sistem Injeksi</li>
                            <li><i class="fas fa-cog text-danger"></i> Transmisi CVT</li>
                            <li><i class="fas fa-microchip text-danger"></i> ECU Programming</li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- TBKR - Teknik Body Kendaraan Ringan -->
            <div class="col-md-6 col-lg-4">
                <div class="card program-card h-100">
                    <div class="card-body text-center">
                        <div class="program-icon text-info">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h4 class="program-title">Teknik Body Kendaraan Ringan</h4>
                        <p class="program-subtitle">(TBKR)</p>
                        <p class="program-description">Program keahlian yang fokus pada perbaikan body kendaraan, pengecatan, dan restorasi kendaraan.</p>
                        <ul class="skill-list text-start">
                            <li><i class="fas fa-hammer text-info"></i> Body Repair</li>
                            <li><i class="fas fa-spray-can text-info"></i> Automotive Painting</li>
                            <li><i class="fas fa-cut text-info"></i> Panel Beating</li>
                            <li><i class="fas fa-palette text-info"></i> Color Matching</li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- TPM - Teknik Pemesinan -->
            <div class="col-md-6 col-lg-4">
                <div class="card program-card h-100">
                    <div class="card-body text-center">
                        <div class="program-icon text-secondary">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h4 class="program-title">Teknik Pemesinan</h4>
                        <p class="program-subtitle">(TPM)</p>
                        <p class="program-description">Program keahlian yang mempelajari pengoperasian mesin-mesin produksi dan pembuatan komponen presisi.</p>
                        <ul class="skill-list text-start">
                            <li><i class="fas fa-cogs text-secondary"></i> CNC Programming</li>
                            <li><i class="fas fa-ruler-combined text-secondary"></i> Precision Machining</li>
                            <li><i class="fas fa-drafting-compass text-secondary"></i> Technical Drawing</li>
                            <li><i class="fas fa-cube text-secondary"></i> CAD/CAM</li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- TPL - Teknik Pengelasan -->
            <div class="col-md-6 col-lg-4">
                <div class="card program-card h-100">
                    <div class="card-body text-center">
                        <div class="program-icon text-dark">
                            <i class="fas fa-fire"></i>
                        </div>
                        <h4 class="program-title">Teknik Pengelasan</h4>
                        <p class="program-subtitle">(TPL)</p>
                        <p class="program-description">Program keahlian yang mempelajari berbagai teknik pengelasan untuk konstruksi dan fabrikasi logam.</p>
                        <ul class="skill-list text-start">
                            <li><i class="fas fa-fire text-dark"></i> SMAW Welding</li>
                            <li><i class="fas fa-bolt text-dark"></i> GTAW/TIG Welding</li>
                            <li><i class="fas fa-wind text-dark"></i> GMAW/MIG Welding</li>
                            <li><i class="fas fa-shield-alt text-dark"></i> Welding Safety</li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- TKJ - Teknik Komputer dan Jaringan -->
            <div class="col-md-6 col-lg-4">
                <div class="card program-card h-100">
                    <div class="card-body text-center">
                        <div class="program-icon text-success">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <h4 class="program-title">Teknik Komputer dan Jaringan</h4>
                        <p class="program-subtitle">(TKJ)</p>
                        <p class="program-description">Program keahlian yang mempelajari instalasi, konfigurasi, dan maintenance sistem komputer dan jaringan.</p>
                        <ul class="skill-list text-start">
                            <li><i class="fas fa-server text-success"></i> Network Administration</li>
                            <li><i class="fas fa-shield-alt text-success"></i> Cyber Security</li>
                            <li><i class="fas fa-desktop text-success"></i> Hardware Maintenance</li>
                            <li><i class="fas fa-wifi text-success"></i> Wireless Technology</li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- RPL - Rekayasa Perangkat Lunak -->
            <div class="col-md-6 col-lg-4">
                <div class="card program-card h-100">
                    <div class="card-body text-center">
                        <div class="program-icon text-primary">
                            <i class="fas fa-code"></i>
                        </div>
                        <h4 class="program-title">Rekayasa Perangkat Lunak</h4>
                        <p class="program-subtitle">(RPL)</p>
                        <p class="program-description">Program keahlian yang mempelajari pengembangan aplikasi, website, dan sistem informasi dengan teknologi modern.</p>
                        <ul class="skill-list text-start">
                            <li><i class="fas fa-code text-primary"></i> Web Development</li>
                            <li><i class="fas fa-mobile-alt text-primary"></i> Mobile App Development</li>
                            <li><i class="fas fa-database text-primary"></i> Database Management</li>
                            <li><i class="fas fa-cloud text-primary"></i> Cloud Computing</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- DKV - Desain Komunikasi Visual -->
            <div class="col-md-6 col-lg-4">
                <div class="card program-card h-100">
                    <div class="card-body text-center">
                        <div class="program-icon text-purple" style="color: #6f42c1;">
                            <i class="fas fa-camera"></i>
                        </div>
                        <h4 class="program-title">Desain Komunikasi Visual</h4>
                        <p class="program-subtitle">(DKV)</p>
                        <p class="program-description">Program keahlian yang mempelajari desain grafis, multimedia, dan komunikasi visual untuk berbagai media.</p>
                        <ul class="skill-list text-start">
                            <li><i class="fas fa-paint-brush" style="color: #6f42c1;"></i> Graphic Design</li>
                            <li><i class="fas fa-video" style="color: #6f42c1;"></i> Video Editing</li>
                            <li><i class="fas fa-camera" style="color: #6f42c1;"></i> Photography</li>
                            <li><i class="fas fa-cube" style="color: #6f42c1;"></i> 3D Modeling</li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas Pendukung -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="section-title">Fasilitas Pendukung</h2>
                <p class="text-muted">Fasilitas lengkap dan modern untuk mendukung proses pembelajaran praktik semua program keahlian</p>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow h-100 program-card">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-wrench fa-3x text-warning mb-3"></i>
                        <h5>Workshop Otomotif & Alat Berat</h5>
                        <p>Workshop lengkap dengan peralatan modern untuk praktik TKR, TSM, TBKR, dan TAB.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card shadow h-100 program-card">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-desktop fa-3x text-success mb-3"></i>
                        <h5>Lab Komputer</h5>
                        <p>Laboratorium komputer dengan spesifikasi tinggi untuk TKJ, RPL, dan DKV.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card shadow h-100 program-card">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-industry fa-3x text-secondary mb-3"></i>
                        <h5>Workshop CNC & Manufaktur</h5>
                        <p>Workshop dengan mesin CNC, peralatan presisi untuk TPM, dan area pengelasan untuk TPL.</p>
                    </div>
                </div>
            </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row align-items-center text-white">
            <div class="col-lg-8">
                <h3 class="fw-bold">Siap Menjadi Teknisi Profesional?</h3>
                <p class="lead mb-0">Bergabunglah dengan SMK PGRI 2 PONOROGO dan wujudkan impian kariermu di bidang teknologi dan industri!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('student.register.form') }}" class="btn btn-light btn-lg btn-program">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>
@endsection