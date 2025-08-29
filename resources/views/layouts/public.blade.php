<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Website resmi sekolah' }}">
    <title>{{ $title ?? 'Home' }} - SMA Negeri 1</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-gray: #f8f9fa;
            --dark-gray: #6c757d;
        }
        
        /* Base Styles - Mobile First */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        
        /* Navigation Improvements */
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.5rem 0;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .navbar-nav .nav-link {
            padding: 0.5rem 0.8rem;
            font-weight: 500;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        /* Hero Section - Mobile Optimized */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 40px 0;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        
        /* Cards - Enhanced Mobile Design */
        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 1rem;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        /* Button Improvements */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
        }
        
        /* Stats Section */
        .stats-card {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stats-card i {
            margin-bottom: 1rem;
        }
        
        .stats-card h4 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0 1rem 0;
            margin-top: 3rem;
        }
        
        /* Mobile Specific Styles */
        @media (max-width: 767.98px) {
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .hero-section {
                padding: 30px 0;
                text-align: center;
            }
            
            .hero-section h1 {
                font-size: 1.8rem !important;
                margin-bottom: 1rem;
            }
            
            .hero-section .lead {
                font-size: 1rem;
            }
            
            .hero-section .btn {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
            
            .stats-card h4 {
                font-size: 1.5rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .footer {
                padding: 1.5rem 0;
                text-align: center;
            }
            
            /* Improve touch targets */
            .nav-link, .btn, .dropdown-item {
                min-height: 44px;
                display: flex;
                align-items: center;
            }
            
            /* Better spacing for mobile */
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            /* Mobile typography */
            h3 {
                font-size: 1.4rem;
            }
            
            h5 {
                font-size: 1.1rem;
            }
        }
        
        /* Tablet Styles */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .hero-section {
                padding: 60px 0;
            }
            
            .hero-section h1 {
                font-size: 2.5rem !important;
            }
        }
        
        /* Desktop Styles */
        @media (min-width: 992px) {
            body {
                font-size: 16px;
            }
            
            .hero-section {
                padding: 80px 0;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .stats-card {
                padding: 2rem;
            }
        }
        
        /* High DPI Displays */
        @media (min-width: 1400px) {
            .container {
                max-width: 1320px;
            }
            
            .hero-section {
                padding: 100px 0;
            }
        }
        
        /* Loading Animation */
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Accessibility improvements */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            white-space: nowrap;
            border: 0;
        }
        
        /* Focus states for keyboard navigation */
        .btn:focus, .nav-link:focus {
            outline: 2px solid var(--secondary-color);
            outline-offset: 2px;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: var(--primary-color);">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                <span class="d-none d-sm-inline">SMA Negeri 99 Balong</span>
                <span class="d-inline d-sm-none">SMAN1</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home d-lg-none me-2"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-info-circle d-lg-none me-2"></i>Profil
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                            <li><a class="dropdown-item" href="{{ route('about.profile') }}">
                                <i class="fas fa-school me-2"></i>Profil Sekolah
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('about.vision') }}">
                                <i class="fas fa-eye me-2"></i>Visi & Misi
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="academicDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-book d-lg-none me-2"></i>Akademik
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="academicDropdown">
                            <li><a class="dropdown-item" href="{{ route('public.academic.programs') }}">
                                <i class="fas fa-graduation-cap me-2"></i>Program Studi
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('academic.calendar') }}">
                                <i class="fas fa-calendar me-2"></i>Kalender Akademik
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-h me-2"></i>Lainnya
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="moreDropdown">
                            <li><a class="dropdown-item" href="{{ route('facilities.index') }}">
                                <i class="fas fa-building me-2"></i>Fasilitas
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('achievements.index') }}">
                                <i class="fas fa-trophy me-2"></i>Prestasi
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('extracurriculars.index') }}">
                                <i class="fas fa-users me-2"></i>Ekstrakurikuler
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('gallery.photos') }}">
                                <i class="fas fa-images me-2"></i>Galeri
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('downloads.index') }}">
                                <i class="fas fa-download me-2"></i>Download
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
                            Berita
                        </a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            Kontak
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>
                                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                                <span class="d-inline d-md-none">Profile</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-cog me-2"></i>Pengaturan
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h5><i class="fas fa-graduation-cap me-2"></i>SMA Negeri 1</h5>
                    <p class="mb-3">Excellence in Education - Membentuk generasi yang berkarakter dan berprestasi untuk masa depan Indonesia yang gemilang.</p>
                    <div class="social-links">
                        <a href="#" class="text-white me-3" aria-label="Facebook">
                            <i class="fab fa-facebook fa-lg"></i>
                        </a>
                        <a href="#" class="text-white me-3" aria-label="Instagram">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                        <a href="#" class="text-white me-3" aria-label="YouTube">
                            <i class="fab fa-youtube fa-lg"></i>
                        </a>
                        <a href="#" class="text-white" aria-label="Twitter">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('about.profile') }}" class="text-white-50 text-decoration-none">Profil Sekolah</a></li>
                        <li class="mb-2"><a href="{{ route('facilities.index') }}" class="text-white-50 text-decoration-none">Fasilitas</a></li>
                        <li class="mb-2"><a href="{{ route('achievements.index') }}" class="text-white-50 text-decoration-none">Prestasi</a></li>
                        <li class="mb-2"><a href="{{ route('extracurriculars.index') }}" class="text-white-50 text-decoration-none">Ekstrakurikuler</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="fw-bold mb-3">Akademik</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('public.academic.programs') }}" class="text-white-50 text-decoration-none">Program Studi</a></li>
                        <li class="mb-2"><a href="{{ route('academic.calendar') }}" class="text-white-50 text-decoration-none">Kalender</a></li>
                        <li class="mb-2"><a href="{{ route('downloads.index') }}" class="text-white-50 text-decoration-none">Download</a></li>
                        <li class="mb-2"><a href="{{ route('gallery.photos') }}" class="text-white-50 text-decoration-none">Galeri</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Kontak Kami</h6>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <small>Jl. Pendidikan No. 123<br>Semarang, Jawa Tengah 50123</small>
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <small>(024) 123-4567</small>
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-envelope me-2"></i>
                        <small>info@sman1.sch.id</small>
                    </p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 2rem 0 1rem 0;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} SMA Negeri 1. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <small>Powered by <span class="text-info">Laravel</span></small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>