<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - SMA Negeri 1 Balong</title>
    
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
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
        
        


        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            text-align: center;
            padding: 80px 20px;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 300;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Contact Section */
        .contact-section {
            padding: 80px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .contact-info h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
            padding: 45px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .contact-item:hover {
            transform: translateY(-5px);
        }

        .contact-icon {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .contact-details h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .contact-details p {
            color: #666;
        }

        /* WhatsApp Buttons */
        .whatsapp-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .whatsapp-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.5rem;
            text-align: center;
        }

        .whatsapp-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .whatsapp-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
        }

        .whatsapp-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
        }

        .whatsapp-btn svg {
            margin-right: 10px;
        }

        /* Map Section */
        .map-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }

        .map-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.5rem;
            
        }

        

       /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0 1rem 0;
            margin-top: 3rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .contact-info h2 {
                font-size: 2rem;
            }
        }
    </style>
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



    <!-- Hero Section -->
    <section class="hero">
        <h1>Hubungi Kami</h1>
        <p>Kami siap membantu dan menjawab pertanyaan Anda seputar SMA Negeri 1 Balong</p>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="contact-grid">
            <!-- Contact Information -->
            <div class="contact-info">
                <h2>Informasi Kontak</h2>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <h3>Alamat Sekolah</h3>
                        <p>Jl. Pendidikan No. 123<br>Balong, Kabupaten Ponorogo<br>Jawa Timur 63462</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <h3>Email</h3>
                        <p>info@sman1balong.sch.id<br>admin@sman1balong.sch.id</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <h3>Telepon</h3>
                        <p>(0352) 123456<br>Fax: (0352) 123457</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <div class="contact-details">
                        <h3>Jam Operasional</h3>
                        <p>Senin - Jumat: 07.00 - 15.00 WIB<br>Sabtu: 07.00 - 12.00 WIB</p>
                    </div>
                </div>
            </div>

            <!-- WhatsApp & Map Section -->
            <div>
                <!-- WhatsApp Contact -->
                <div class="whatsapp-section">
                    <h3>Kontak WhatsApp</h3>
                    <div class="whatsapp-buttons">
                        <a href="https://wa.me/628123456789?text=Halo,%20saya%20ingin%20bertanya%20tentang%20SMA%20Negeri%201%20Balong" 
                           target="_blank" 
                           class="whatsapp-btn">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.893 3.488"/>
                            </svg>
                            Admin Sekolah (+62 812-3456-789)
                        </a>
                        
                        <a href="https://wa.me/628987654321?text=Halo,%20saya%20ingin%20bertanya%20tentang%20pendaftaran%20siswa%20baru" 
                           target="_blank" 
                           class="whatsapp-btn">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.893 3.488"/>
                            </svg>
                            Pendaftaran Siswa (+62 898-7654-321)
                        </a>
                        
                        <a href="https://wa.me/6285123456789?text=Halo,%20saya%20ingin%20bertanya%20tentang%20program%20akademik" 
                           target="_blank" 
                           class="whatsapp-btn">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.893 3.488"/>
                            </svg>
                            Bagian Akademik (+62 851-2345-6789)
                        </a>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="map-section" style="margin-top: 30px;">
                    <h3>Lokasi Sekolah</h3>

                     <div class="map-container">
                          <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d698.5187961715578!2d111.4149188224645!3d-7.955576481830881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e797544dcd2e443%3A0x5646c1765ea4a5ef!2sRostifa%20Fashion!5e0!3m2!1sen!2sid!4v1756515501291!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            width="100%" 
                            height="300" 
                            style="border: 0; border-radius: 10px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                    </div>


                    <p style="margin-top: 15px; color: #666;">
                        <small>* Anda dapat mengintegrasikan Google Maps atau peta lainnya di bagian ini</small>
                    </p>
                </div>
            </div>
        </div>
    </section>

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