@extends('layouts.public')

@section('title', 'Visi & Misi')

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
    
    /* Enhanced Hero Section matching home page */
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.85) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.85) 100%
        ),
        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
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

    /* Enhanced Card Styling */
    .vision-mission-card {
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        position: relative;
        margin-bottom: 2rem;
    }
    
    .vision-mission-card::before {
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
    
    .vision-mission-card:hover::before {
        opacity: 1;
    }
    
    .vision-mission-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
    }
    
    .card-header-enhanced {
        padding: 25px;
        border: none;
        position: relative;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .card-header-enhanced::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
    }
    
    .card-body-enhanced {
        padding: 30px;
        position: relative;
        z-index: 2;
    }

    /* Vision Card Specific Styling */
    .vision-card {
        background: white;
        color: var(--primary-color);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .vision-quote {
        font-size: 1.4rem;
        font-weight: 300;
        line-height: 1.6;
        text-align: center;
        padding: 30px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        margin: 20px 0;
        border-left: 4px solid var(--secondary-color);
        position: relative;
        color: var(--primary-color);
    }
    
    .vision-quote::before {
        content: '"';
        position: absolute;
        top: -10px;
        left: 20px;
        font-size: 4rem;
        opacity: 0.2;
        font-family: serif;
        color: var(--secondary-color);
    }

    /* Mission Card Specific Styling */
    .mission-card {
        background: white;
        color: var(--primary-color);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .mission-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .mission-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        margin: 15px 0;
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #198754;
        transition: all 0.3s ease;
        position: relative;
        padding-left: 50px;
        color: var(--primary-color);
    }
    
    .mission-item:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        transform: translateX(10px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .mission-number {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 30px;
        height: 30px;
        background: #198754;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
    }

    /* Goals Card Specific Styling */
    .goals-card {
        background: white;
        color: var(--primary-color);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .goals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .goal-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        color: var(--primary-color);
    }
    
    .goal-item:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .goal-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        opacity: 0.8;
    }
    
    .goal-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--primary-color);
    }
    
    .goal-description {
        font-size: 0.9rem;
        opacity: 0.8;
        line-height: 1.5;
        color: var(--dark-gray);
    }

    /* Values Section */
    .values-section {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        padding: 80px 0;
    }
    
    .value-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
        height: 100%;
    }
    
    .value-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }
    
    .value-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        transition: all 0.3s ease;
    }
    
    .value-card:hover .value-icon {
        transform: scale(1.1) rotateY(360deg);
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

    /* Enhanced CTA Section */
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
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
    }

    /* Hero Buttons */
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

    /* Motto Section */
    .motto-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
        position: relative;
    }
    
    .motto-text {
        font-size: 2rem;
        font-weight: 300;
        text-align: center;
        font-style: italic;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .motto-subtitle {
        text-align: center;
        margin-top: 15px;
        opacity: 0.9;
        font-size: 1.1rem;
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
        
        .vision-quote {
            font-size: 1.2rem;
            padding: 15px;
        }
        
        .motto-text {
            font-size: 1.5rem;
        }
        
        .goals-grid {
            grid-template-columns: 1fr;
        }
        
        .btn-hero {
            width: 100%;
            margin-bottom: 15px;
        }
    }
    
    @media (max-width: 576px) {
        .hero-section h1 {
            font-size: 2rem;
        }
        
        .vision-quote {
            font-size: 1.1rem;
        }
        
        .motto-text {
            font-size: 1.3rem;
        }
    }

    /* Progressive Enhancement */
    .enhanced-number {
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        background-size: 200% 100%;
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="fade-in-up">Visi & Misi</h1>
                <p class="lead fade-in-up">Komitmen kami untuk menciptakan pendidikan berkualitas dan membentuk generasi yang berkarakter, berprestasi, dan siap menghadapi tantangan masa depan.</p>
                <div class="fade-in-up">
                    <a href="{{ route('about.profile') }}" class="btn btn-hero btn-hero-primary me-3">
                        <i class="fas fa-info-circle me-2"></i>Profil Sekolah
                    </a>
                    <a href="#vision-mission" class="btn btn-hero btn-hero-outline">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-eye hero-icon"></i>
            </div>
        </div>
    </div>
</section>

<!-- Vision, Mission & Goals Section -->
<section id="vision-mission" class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Vision Card -->
            <div class="col-lg-12 mb-4">
                <div class="vision-mission-card vision-card fade-in-up">
                    <div class="card-header-enhanced">
                        <h3 class="mb-0">
                            <i class="fas fa-eye me-3"></i>VISI
                        </h3>
                    </div>
                    <div class="card-body-enhanced">
                        <div class="vision-quote">
                            Terwujudnya sekolah yang unggul, berkarakter, dan berwawasan lingkungan dalam menghasilkan lulusan yang cerdas, kreatif, mandiri, dan berakhlak mulia
                        </div>
                        <p class="text-center mt-3 opacity-75">
                            Visi ini mencerminkan komitmen kami untuk menjadi institusi pendidikan yang tidak hanya fokus pada pencapaian akademik, 
                            tetapi juga pembentukan karakter dan kepedulian terhadap lingkungan.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Mission Card -->
            <div class="col-lg-12 mb-4">
                <div class="vision-mission-card mission-card fade-in-up">
                    <div class="card-header-enhanced">
                        <h3 class="mb-0">
                            <i class="fas fa-bullseye me-3"></i>MISI
                        </h3>
                    </div>
                    <div class="card-body-enhanced">
                        <ul class="mission-list">
                            <li class="mission-item">
                                <div class="mission-number">1</div>
                                <strong>Menyelenggarakan pendidikan berkualitas</strong> dengan mengintegrasikan kurikulum nasional dan teknologi pembelajaran modern
                            </li>
                            <li class="mission-item">
                                <div class="mission-number">2</div>
                                <strong>Mengembangkan karakter siswa</strong> melalui program pendidikan nilai-nilai keagamaan, nasionalisme, dan kepemimpinan
                            </li>
                            <li class="mission-item">
                                <div class="mission-number">3</div>
                                <strong>Memfasilitasi pengembangan bakat dan minat</strong> siswa melalui kegiatan ekstrakurikuler dan program unggulan
                            </li>
                            <li class="mission-item">
                                <div class="mission-number">4</div>
                                <strong>Membangun budaya sekolah</strong> yang kondusif, aman, nyaman, dan berwawasan lingkungan
                            </li>
                            <li class="mission-item">
                                <div class="mission-number">5</div>
                                <strong>Menjalin kemitraan strategis</strong> dengan stakeholder untuk mendukung program pendidikan dan pengembangan sekolah
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Goals Card -->
            <div class="col-lg-12 mb-4">
                <div class="vision-mission-card goals-card fade-in-up">
                    <div class="card-header-enhanced">
                        <h3 class="mb-0">
                            <i class="fas fa-target me-3"></i>TUJUAN STRATEGIS
                        </h3>
                    </div>
                    <div class="card-body-enhanced">
                        <div class="goals-grid">
                            <div class="goal-item">
                                <div class="goal-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="goal-title">Kualitas Akademik</div>
                                <div class="goal-description">
                                    Meningkatkan prestasi akademik dan daya saing lulusan di tingkat nasional
                                </div>
                            </div>
                            
                            <div class="goal-item">
                                <div class="goal-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="goal-title">Pembentukan Karakter</div>
                                <div class="goal-description">
                                    Menghasilkan lulusan yang berakhlak mulia dan berkarakter kuat
                                </div>
                            </div>
                            
                            <div class="goal-item">
                                <div class="goal-icon">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div class="goal-title">Peduli Lingkungan</div>
                                <div class="goal-description">
                                    Mewujudkan sekolah hijau dan berkelanjutan untuk masa depan
                                </div>
                            </div>
                            
                            <div class="goal-item">
                                <div class="goal-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="goal-title">Wawasan Global</div>
                                <div class="goal-description">
                                    Mempersiapkan siswa dengan kompetensi global dan daya saing internasional
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="section-heading fade-in-up">Nilai-Nilai Sekolah</h2>
                <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">
                    Nilai-nilai fundamental yang menjadi landasan dalam setiap kegiatan pendidikan di SMA Negeri 1 Balong
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card fade-in-up" style="animation-delay: 0.1s;">
                    <div class="value-icon bg-primary text-white">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5 class="fw-bold mb-3">KEADILAN</h5>
                    <p class="text-muted">Perlakuan yang adil dan merata untuk seluruh warga sekolah tanpa diskriminasi</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="value-card fade-in-up" style="animation-delay: 0.6s;">
                    <div class="value-icon bg-danger text-white">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h5 class="fw-bold mb-3">PEDULI LINGKUNGAN</h5>
                    <p class="text-muted">Kepedulian terhadap kelestarian lingkungan dan pembangunan berkelanjutan</p>
                </div>
            </div>
            <!-- <div class="col-md-4">
                <div class="value-card fade-in-up" style="animation-delay: 0.6s;">
                    <div class="value-icon bg-danger text-white">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h5 class="fw-bold mb-3">INOVASI</h5>
                    <p class="text-muted"></p>
                </div>
            </div> -->
            <div class="col-md-4">
                <div class="value-card fade-in-up" style="animation-delay: 0.4s;">
                    <div class="value-icon bg-info text-white">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h5 class="fw-bold mb-3">INOVASI</h5>
                    <p class="text-muted">Kreativitas dan pembaruan berkelanjutan dalam metode dan pendekatan pendidikan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Strategic Focus Areas -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="section-heading fade-in-up">Area Fokus Strategis</h2>
                <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">
                    Prioritas pengembangan sekolah untuk mencapai visi dan misi yang telah ditetapkan
                </p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow h-100 fade-in-left">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="value-icon bg-primary text-white me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fas fa-brain"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Peningkatan Kualitas Pembelajaran</h5>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Implementasi kurikulum merdeka</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Pembelajaran berbasis teknologi</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Pengembangan critical thinking</li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Program literasi digital</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow h-100 fade-in-right">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="value-icon bg-success text-white me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Pengembangan Karakter</h5>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Program pendidikan karakter terintegrasi</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Kegiatan keagamaan dan spiritual</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Pengembangan kepemimpinan siswa</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Program service learning</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow h-100 fade-in-left" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="value-icon bg-warning text-white me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fas fa-medal"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Prestasi & Kompetisi</h5>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Program olimpiade sains</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Kompetisi debat dan public speaking</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Festival seni dan budaya</li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i> Turnamen olahraga</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow h-100 fade-in-right" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="value-icon bg-info text-white me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fas fa-globe"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Kemitraan Global</h5>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Sister school program</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Student exchange program</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> International certification</li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i> Global competency development</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Roadmap Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="section-heading fade-in-up">Roadmap Pengembangan 2025-2030</h2>
                <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">
                    Tahapan strategis untuk mencapai visi sekolah unggulan pada tahun 2030
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="timeline" style="position: relative; padding-left: 30px;">
                    <div class="timeline-line" style="position: absolute; left: 15px; top: 0; bottom: 0; width: 3px; background: linear-gradient(to bottom, var(--secondary-color), var(--accent-color)); border-radius: 2px;"></div>
                    
                    <div class="timeline-item fade-in-up" style="position: relative; margin-bottom: 40px; padding-left: 40px; animation-delay: 0.1s;">
                        <div class="timeline-marker" style="position: absolute; left: -32px; width: 20px; height: 20px; background: #0d6efd; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"></div>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="text-primary fw-bold">2025 - Fase Konsolidasi</h6>
                                <p class="mb-2">Penguatan sistem manajemen sekolah dan standardisasi proses pembelajaran digital</p>
                                <small class="text-muted">Target: Akreditasi A+ dan sertifikasi ISO 9001</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item fade-in-up" style="position: relative; margin-bottom: 40px; padding-left: 40px; animation-delay: 0.2s;">
                        <div class="timeline-marker" style="position: absolute; left: -32px; width: 20px; height: 20px; background: #198754; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"></div>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="text-success fw-bold">2026-2027 - Fase Ekspansi</h6>
                                <p class="mb-2">Pengembangan program unggulan dan kemitraan internasional</p>
                                <small class="text-muted">Target: 3 program sister school dan 5 sertifikasi internasional</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item fade-in-up" style="position: relative; margin-bottom: 40px; padding-left: 40px; animation-delay: 0.3s;">
                        <div class="timeline-marker" style="position: absolute; left: -32px; width: 20px; height: 20px; background: #ffc107; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"></div>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="text-warning fw-bold">2028-2029 - Fase Optimalisasi</h6>
                                <p class="mb-2">Implementasi full smart school dan pengembangan pusat keunggulan</p>
                                <small class="text-muted">Target: Center of Excellence dan Smart School Certification</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item fade-in-up" style="position: relative; margin-bottom: 40px; padding-left: 40px; animation-delay: 0.4s;">
                        <div class="timeline-marker" style="position: absolute; left: -32px; width: 20px; height: 20px; background: #0dcaf0; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"></div>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6 class="text-info fw-bold">2030 - Pencapaian Visi</h6>
                                <p class="mb-2">Menjadi sekolah unggulan rujukan nasional dengan lulusan berkarakter global</p>
                                <small class="text-muted">Target: Top 10 sekolah terbaik nasional</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-center text-lg-start">
                <h3 class="text-white mb-3 fade-in-left">Bergabunglah dalam Mewujudkan Visi Bersama</h3>
                <p class="text-white mb-4 fade-in-left" style="animation-delay: 0.2s;">
                    Mari bersama-sama membangun masa depan pendidikan yang lebih baik untuk generasi penerus bangsa
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <a href="{{ route('about.profile') }}" class="btn btn-light btn-lg px-4 py-2 btn-enhanced scale-in me-3" style="animation-delay: 0.4s;">
                    <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                </a>
                <a href="https://wa.me/6285755216048?text=Halo,%20saya%20ingin%20bertanya%20tentang%20SMA%20Negeri%201%20Balong" 
                   class="btn btn-outline-light btn-lg px-4 py-2 btn-enhanced scale-in whatsapp-btn" 
                   target="_blank" 
                   style="animation-delay: 0.6s;">
                    <i class="fas fa-phone me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
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
    
    // Enhanced card hover effects
    const cards = document.querySelectorAll('.card, .value-card, .vision-mission-card');
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
    
    // Mission items hover effect
    const missionItems = document.querySelectorAll('.mission-item');
    missionItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(15px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0) scale(1)';
        });
    });
    
    // Goal items interactive effect
    const goalItems = document.querySelectorAll('.goal-item');
    goalItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.goal-icon i');
            if (icon) {
                icon.style.transform = 'scale(1.2) rotateY(180deg)';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.goal-icon i');
            if (icon) {
                icon.style.transform = 'scale(1) rotateY(0deg)';
            }
        });
    });
    
    // Add loading animation to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.href && !this.href.includes('#')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            }
        });
    });
    
    // Parallax effect for hero section
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero-section');
        if (hero && scrolled < hero.offsetHeight) {
            hero.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
        ticking = false;
    }
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    });
    
    // Enhanced number animation for roadmap years
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.15}s`;
        
        // Add interactive timeline markers
        const marker = item.querySelector('.timeline-marker');
        if (marker) {
            item.addEventListener('mouseenter', function() {
                marker.style.transform = 'scale(1.3)';
                marker.style.boxShadow = '0 8px 20px rgba(0,0,0,0.25)';
            });
            
            item.addEventListener('mouseleave', function() {
                marker.style.transform = 'scale(1)';
                marker.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            });
        }
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
    
    // Add typing effect to vision quote
    const visionQuote = document.querySelector('.vision-quote');
    if (visionQuote) {
        const originalText = visionQuote.textContent;
        visionQuote.textContent = '';
        
        const visionObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    let i = 0;
                    const typeTimer = setInterval(() => {
                        if (i < originalText.length) {
                            visionQuote.textContent += originalText.charAt(i);
                            i++;
                        } else {
                            clearInterval(typeTimer);
                        }
                    }, 30);
                    visionObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        visionObserver.observe(visionQuote);
    }
    
    // Page load animation sequence
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 100);
    
    console.log('Enhanced vision mission page loaded successfully!');
});
</script>
@endsection 