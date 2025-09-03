<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website resmi sekolah">
    <title>Home - SMA Negeri 1</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #3182ce;
            --accent-color: #e53e3e;
            --light-gray: #f8f9fa;
            --dark-gray: #6c757d;
            --glass-bg: rgba(26, 32, 44, 0.95);
            --nav-height: 80px;
        }
        
        /* Base Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            padding-top: var(--nav-height);
        }
        
        /* Enhanced Modern Navbar with Glassmorphism */
        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 0;
            height: var(--nav-height);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Navbar scrolled state */
        .navbar.scrolled {
            background: rgba(26, 32, 44, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            height: 70px;
        }
        
        .navbar .container-fluid {
            height: 100%;
            align-items: center;
        }
        
        /* Enhanced Brand with Logo Animation */
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: white !important;
            display: flex;
            align-items: center;
            padding: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }
        
        .navbar-brand .brand-icon {
            background: linear-gradient(135deg, var(--secondary-color), #4299e1);
            border-radius: 12px;
            padding: 8px;
            margin-right: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3);
        }
        
        .navbar-brand:hover .brand-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(49, 130, 206, 0.4);
        }
        
        .navbar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .navbar-brand .brand-main {
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        .navbar-brand .brand-sub {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 400;
        }
        
        /* Modern Navigation Links */
        .navbar-nav {
            gap: 0.5rem;
        }
        
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 12px 16px !important;
            border-radius: 10px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            text-decoration: none;
            overflow: hidden;
        }
        
        /* Hover effect dengan gradient background */
        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(49, 130, 206, 0.2), rgba(66, 153, 225, 0.1));
            opacity: 0;
            transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 10px;
        }
        
        .navbar-nav .nav-link:hover::before {
            opacity: 1;
        }
        
        .navbar-nav .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }
        
        /* Active state dengan glow effect */
        .navbar-nav .nav-link.active {
            background: linear-gradient(135deg, var(--secondary-color), #4299e1);
            color: white !important;
            box-shadow: 0 4px 15px rgba(49, 130, 206, 0.4);
        }
        
        .navbar-nav .nav-link.active::before {
            opacity: 0;
        }
        
        /* Modern Dropdown Menu */
        .dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 12px;
            margin-top: 8px;
            min-width: 220px;
            transform: translateY(-10px) scale(0.95);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .dropdown:hover .dropdown-menu,
        .dropdown-menu.show {
            transform: translateY(0) scale(1);
            opacity: 1;
            visibility: visible;
        }
        
        /* Dropdown Items dengan Modern Design */
        .dropdown-item {
            color: var(--primary-color);
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 4px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .dropdown-item i {
            width: 20px;
            color: var(--secondary-color);
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(49, 130, 206, 0.1), rgba(66, 153, 225, 0.05));
            color: var(--secondary-color);
            transform: translateX(4px);
        }
        
        .dropdown-item:hover i {
            color: var(--secondary-color);
            transform: scale(1.1);
        }
        
        .dropdown-divider {
            margin: 8px 0;
            border-color: rgba(0, 0, 0, 0.1);
        }
        
        /* Enhanced Mobile Toggler - FIXED */
        .navbar-toggler {
            border: none;
            padding: 8px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.3);
            outline: none;
        }
        
        .navbar-toggler:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        
        /* Custom Hamburger Animation - FIXED */
        .navbar-toggler-icon {
            background-image: none;
            width: 24px;
            height: 2px;
            position: relative;
            transition: all 0.3s ease;
            background-color: white;
            display: block;
        }
        
        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 2px;
            background-color: white;
            left: 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .navbar-toggler-icon::before {
            top: -8px;
        }
        
        .navbar-toggler-icon::after {
            top: 8px;
        }
        
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            background-color: transparent;
        }
        
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
            transform: rotate(45deg);
            top: 0;
        }
        
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
            transform: rotate(-45deg);
            top: 0;
        }
        
        /* User Dropdown Enhancement */
        .user-dropdown .dropdown-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 8px 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .user-dropdown .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }
        
        .user-dropdown .dropdown-toggle::after {
            margin-left: 8px;
        }
        
        /* Login Button Enhancement */
        .nav-item .login-btn {
            background: linear-gradient(135deg, var(--secondary-color), #4299e1);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-item .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(49, 130, 206, 0.4);
        }
        
        /* Mobile Styles Enhancement */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(26, 32, 44, 0.98);
                backdrop-filter: blur(20px);
                border-radius: 16px;
                margin-top: 16px;
                padding: 20px;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .navbar-nav {
                gap: 8px;
            }
            
            .navbar-nav .nav-link {
                padding: 16px 20px !important;
                border-radius: 12px;
            }
            
            .dropdown-menu {
                background: rgba(255, 255, 255, 0.98);
                margin: 8px 0;
                position: static;
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            }
            
            .navbar-brand .brand-sub {
                display: none;
            }
        }
        
        /* Tablet Styles */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
        }
        
        /* Desktop Styles */
        @media (min-width: 992px) {
            .navbar-nav .nav-link {
                margin: 0 4px;
            }
        }
        
        /* Search Bar (if needed) */
        .navbar-search {
            position: relative;
            margin: 0 16px;
        }
        
        .navbar-search input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 8px 40px 8px 16px;
            color: white;
            width: 250px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .navbar-search input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .navbar-search input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            border-color: var(--secondary-color);
            width: 300px;
        }
        
        .navbar-search .search-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            padding: 4px;
        }
        
        /* Animation for page load */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .navbar {
            animation: slideDown 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Rest of existing styles... */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 40px 0;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        
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
        
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0 1rem 0;
            margin-top: 3rem;
        }
        
        /* Mobile optimizations */
        @media (max-width: 767.98px) {
            body {
                padding-top: 70px;
            }
            
            .hero-section {
                padding: 30px 0;
                text-align: center;
            }
            
            .hero-section h1 {
                font-size: 1.8rem !important;
                margin-bottom: 1rem;
            }
            
            /* Additional mobile fixes */
            .navbar-toggler {
                width: 40px;
                height: 40px;
            }
            
            .navbar-toggler-icon {
                width: 20px;
            }
            
            .navbar-toggler-icon::before,
            .navbar-toggler-icon::after {
                width: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Enhanced Modern Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid px-4">
            <!-- Enhanced Brand -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-main">SMA Negeri 99</span>
                    <span class="brand-sub d-none d-lg-block">Excellence in Education</span>
                </div>
            </a>
            
            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">
                            <i class="fas fa-home me-2 d-lg-none"></i>Beranda
                        </a>
                    </li>
                    
                    <!-- Profil Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-info-circle me-2 d-lg-none"></i>Profil
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('about.profile') }}">
                                <i class="fas fa-school me-3"></i>Profil Sekolah
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('about.vision') }}">
                                <i class="fas fa-eye me-3"></i>Visi & Misi
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('about.sejarah') }}">
                                <i class="fas fa-graduation-cap me-3"></i>Sejarah Sekolah
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Akademik Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="academicDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-book me-2 d-lg-none"></i>Akademik
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('public.academic.programs') }}">
                                <i class="fas fa-graduation-cap me-3"></i>Program Studi
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('academic.calendar') }}">
                                <i class="fas fa-calendar-alt me-3"></i>Kalender Akademik
                            </a></li>
                            
                        </ul>
                    </li>
                    
                    <!-- Informasi Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-newspaper me-2 d-lg-none"></i>Informasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('news.index') }}">
                                <i class="fas fa-newspaper me-3"></i>Berita
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('announcements.index') }}">
                                <i class="fas fa-bullhorn me-3"></i>Pengumuman
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('agenda.index') }}">
                                <i class="fas fa-calendar-check me-3"></i>Agenda
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Lainnya Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-th me-2 d-lg-none"></i>Lainnya
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('facilities.index') }}">
                                <i class="fas fa-building me-3"></i>Fasilitas
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('achievements.index') }}">
                                <i class="fas fa-trophy me-3"></i>Prestasi
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('extracurriculars.index') }}">
                                <i class="fas fa-users me-3"></i>Ekstrakurikuler
                            </a></li>
                            <li><hr class="dropdown-divider"></li>

                            <li><a class="dropdown-item" href="{{ route('gallery.photos.index') }}">
                            <i class="fas fa-images me-3"></i>Galeri
                            </a></li>

                                
                            <li><a class="dropdown-item" href="{{ route('downloads.index') }}">
                                <i class="fas fa-download me-3"></i>Download
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Desktop only links -->
                    <li class="nav-item d-none d-xl-block">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-2"></i>Kontak
                        </a>
                    </li>
                    <li class="nav-item d-none d-xl-block">
                        <a class="nav-link" href="{{ route('news.index') }}">
                            <i class="fas fa-newspaper me-2"></i>Berita
                        </a>
                    </li>
                   
                </ul>
                
                
                <!-- User Menu -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown user-dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i>
                                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                                <span class="d-inline d-md-none">Profile</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-cog me-3"></i>Pengaturan
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-3"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                       
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
                        <li class="mb-2"><a href="{{ route('gallery.photos.index') }}" class="text-white-50 text-decoration-none">Galeri</a></li>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            const navLinks = document.querySelectorAll('.nav-link');
            
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Smooth dropdown animations for desktop
            const dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(dropdown => {
                if (window.innerWidth >= 992) {
                    dropdown.addEventListener('mouseenter', function() {
                        const menu = this.querySelector('.dropdown-menu');
                        menu.classList.add('show');
                    });
                    
                    dropdown.addEventListener('mouseleave', function() {
                        const menu = this.querySelector('.dropdown-menu');
                        menu.classList.remove('show');
                    });
                }
            });
            
            // Active link highlighting
            const currentPath = window.location.pathname;
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Search functionality (if implemented)
            const searchInput = document.querySelector('.navbar-search input');
            if (searchInput) {
                searchInput.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                searchInput.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
                
                // Search submit functionality
                const searchBtn = document.querySelector('.search-btn');
                if (searchBtn) {
                    searchBtn.addEventListener('click', function() {
                        const query = searchInput.value.trim();
                        if (query) {
                            // Implement search functionality here
                            window.location.href = `/search?q=${encodeURIComponent(query)}`;
                        }
                    });
                }
                
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const query = this.value.trim();
                        if (query) {
                            window.location.href = `/search?q=${encodeURIComponent(query)}`;
                        }
                    }
                });
            }
            
            // Mobile menu improvements
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            navbarToggler.addEventListener('click', function() {
                // Add smooth transition for mobile menu
                setTimeout(() => {
                    if (navbarCollapse.classList.contains('show')) {
                        navbarCollapse.style.maxHeight = navbarCollapse.scrollHeight + 'px';
                    }
                }, 10);
            });
            
            // Close mobile menu when clicking on links
            const mobileNavLinks = document.querySelectorAll('.navbar-nav .nav-link:not(.dropdown-toggle)');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        navbarCollapse.classList.remove('show');
                        navbarToggler.classList.add('collapsed');
                        navbarToggler.setAttribute('aria-expanded', 'false');
                    }
                });
            });
            
            // Smooth scroll for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
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
            
            // Add loading states for navigation
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.href && !this.href.includes('#') && !this.classList.contains('dropdown-toggle')) {
                        this.style.opacity = '0.6';
                        this.style.pointerEvents = 'none';
                        
                        // Reset after 3 seconds (fallback)
                        setTimeout(() => {
                            this.style.opacity = '';
                            this.style.pointerEvents = '';
                        }, 3000);
                    }
                });
            });
            
            // Keyboard navigation improvements
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    // Close all open dropdowns
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                        menu.classList.remove('show');
                    });
                    
                    // Close mobile menu
                    if (navbarCollapse.classList.contains('show')) {
                        navbarCollapse.classList.remove('show');
                        navbarToggler.classList.add('collapsed');
                        navbarToggler.setAttribute('aria-expanded', 'false');
                    }
                }
            });
            
            // Preload important pages for better performance
            const importantLinks = [
                '{{ route("home") }}',
                '{{ route("about.profile") }}',
                '{{ route("news.index") }}'
            ];
            
            // Add preload links to head
            importantLinks.forEach(href => {
                const link = document.createElement('link');
                link.rel = 'prefetch';
                link.href = href;
                document.head.appendChild(link);
            });
            
            // Add visual feedback for user interactions
            document.querySelectorAll('.nav-link, .dropdown-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = this.style.transform || '';
                });
                
                item.addEventListener('mouseleave', function() {
                    // Reset transform if no other transforms are applied
                    if (!this.classList.contains('active')) {
                        this.style.transform = '';
                    }
                });
            });
        });
    </script>
</body>
</html>