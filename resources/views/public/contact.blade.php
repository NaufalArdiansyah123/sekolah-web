@extends('layouts.public')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - SMK PGRI 2 PONOROGO</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-gray: #f8f9fa;
            --dark-gray: #6c757d;
            --success-color: #27ae60;
            --warning-color: #f39c12;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Animated Background Elements */
        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-decoration::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(52, 152, 219, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: 10%;
            right: 10%;
            animation: float 6s ease-in-out infinite;
        }

        .bg-decoration::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(44, 62, 80, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            bottom: 20%;
            left: 5%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Hero Section with Parallax Effect */
        .hero {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            text-align: center;
            padding: 120px 20px 80px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="0,0 1000,0 1000,100 0,30"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease-out;
        }

        .hero p {
            font-size: 1.3rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
            font-weight: 300;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Contact Section */
        .contact-section {
            padding: 100px 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            color: var(--primary-color);
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .section-title p {
            color: var(--dark-gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            margin-bottom: 80px;
        }

        /* Contact Info Cards */
        .contact-info h3 {
            color: var(--primary-color);
            margin-bottom: 40px;
            font-size: 2.2rem;
            font-weight: 600;
            text-align: center;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            padding: 35px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(52, 152, 219, 0.1);
            position: relative;
            overflow: hidden;
        }

        .contact-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
        }

        .contact-item:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        .contact-icon {
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 25px;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
            transition: all 0.3s ease;
        }

        .contact-item:hover .contact-icon {
            transform: rotate(5deg) scale(1.1);
            box-shadow: 0 12px 30px rgba(52, 152, 219, 0.4);
        }

        .contact-details h4 {
            color: var(--primary-color);
            margin-bottom: 12px;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .contact-details p {
            color: #555;
            line-height: 1.7;
            font-size: 1rem;
        }

        /* WhatsApp Section */
        .whatsapp-section {
            background: white;
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .whatsapp-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #25D366, #128C7E);
        }

        .whatsapp-section h3 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
            position: relative;
        }

        .whatsapp-section h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #25D366;
            border-radius: 2px;
        }

        .whatsapp-buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .whatsapp-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            padding: 20px 30px;
            border-radius: 60px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.3);
            position: relative;
            overflow: hidden;
        }

        .whatsapp-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .whatsapp-btn:hover::before {
            left: 100%;
        }

        .whatsapp-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(37, 211, 102, 0.4);
            color: white;
        }

        .whatsapp-btn i {
            margin-right: 12px;
            font-size: 1.3rem;
        }

        /* Map Section */
        .map-section {
            background: white;
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            text-align: center;
            margin-top: 40px;
            position: relative;
            overflow: hidden;
        }

        .map-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
        }

        .map-section h3 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 600;
            position: relative;
        }

        .map-section h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--secondary-color);
            border-radius: 2px;
        }

        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }

        .map-container:hover {
            transform: scale(1.02);
        }

        .map-container iframe {
            width: 100%;
            height: 350px;
            border: none;
        }

        /* Quick Contact Cards */
        .quick-contact {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 60px;
        }

        .quick-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .quick-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
        }

        .quick-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        .quick-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            color: white;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
            transition: all 0.3s ease;
        }

        .quick-card:hover .quick-icon {
            transform: rotate(10deg) scale(1.1);
        }

        .quick-card h4 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.4rem;
        }

        .quick-card p {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Social Media Links */
        .social-section {
            background: white;
            padding: 60px 40px;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            margin-top: 40px;
            text-align: center;
            position: relative;
        }

        .social-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--accent-color), #c0392b);
        }

        .social-section h3 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 600;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .social-link {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            color: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.5rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
        }

        .social-link:hover {
            transform: translateY(-8px) rotate(5deg);
            box-shadow: 0 15px 35px rgba(52, 152, 219, 0.4);
            color: white;
        }

        .social-link.facebook:hover { background: linear-gradient(135deg, #3b5998, #2d4373); }
        .social-link.instagram:hover { background: linear-gradient(135deg, #e4405f, #833ab4); }
        .social-link.youtube:hover { background: linear-gradient(135deg, #ff0000, #cc0000); }
        .social-link.twitter:hover { background: linear-gradient(135deg, #1da1f2, #0d8bd9); }

        /* Enhanced Animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .animate-on-scroll.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Contact Form Enhancement */
        .contact-form {
            background: white;
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            margin-top: 40px;
        }

        .form-floating .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .form-floating .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .btn-send {
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
        }

        .btn-send:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(52, 152, 219, 0.4);
            background: linear-gradient(135deg, #2980b9, var(--secondary-color));
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, #34495e 100%);
            color: white;
            padding: 60px 0 30px 0;
            margin-top: 100px;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-text {
            opacity: 0.9;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 30px;
            font-size: 0.9rem;
            opacity: 0.7;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .section-title h2 {
                font-size: 2.2rem;
            }

            .contact-item {
                padding: 25px;
            }

            .contact-icon {
                width: 50px;
                height: 50px;
            }

            .whatsapp-section,
            .map-section {
                padding: 30px;
            }

            .social-links {
                gap: 15px;
            }

            .social-link {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 80px 15px 60px;
            }

            .contact-section {
                padding: 60px 15px;
            }

            .whatsapp-btn {
                padding: 18px 25px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-decoration"></div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="fade-in-up">Hubungi Kami</h1>
            <p class="fade-in-up">Kami siap membantu Anda untuk informasi seputar SMK PGRI 2 PONOROGO.<br> Jangan ragu untuk menghubungi kami melalui berbagai cara di bawah ini.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="section-title fade-in-up">
            <h2>Informasi Kontak</h2>
            <p>Berbagai cara untuk menghubungi SMK PGRI 2 PONOROGO</p>
        </div>

        <div class="contact-grid">
            <!-- Contact Information -->
            <div class="contact-info fade-in-left">
                <h3>Detail Kontak</h3>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Alamat Sekolah</h4>
                        <p>Jl. Raya Ponorogo - Madiun, Kertosari, Kec. Babadan, Kabupaten Ponorogo, Jawa Timur 63491</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Email</h4>
                        <p>info@smkpgri2ponorogo.sch.id<br>admin@smkpgri2ponorogo.sch.id</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Telepon</h4>
                        <p>(0352) 123456<br>Fax: (0352) 123457</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <h4>Jam Operasional</h4>
                        <p>Senin - Kamis: 06.45 - 14.00 WIB<br>Jumat: 06.45 - 11.00 WIB<br>Sabtu: 06.45 - 10.00 WIB</p>
                    </div>
                </div>
            </div>

            <!-- WhatsApp & Additional Info -->
            <div class="fade-in-right">
                <!-- WhatsApp Contact -->
                <div class="whatsapp-section">
                    <h3>Kontak WhatsApp</h3>
                    <div class="whatsapp-buttons">
                        <a href="https://wa.me/6285755216048?text=Halo,%20saya%20ingin%20bertanya%20tentang%20SMK%20PGRI%202%20PONOROGO" 
                           target="_blank" 
                           class="whatsapp-btn">
                            <i class="fab fa-whatsapp"></i>
                            Admin Sekolah (+62 857-5521-6048)
                        </a>
                        
                        <a href="https://wa.me/628987654321?text=Halo,%20saya%20ingin%20bertanya%20tentang%20pendaftaran%20siswa%20baru" 
                           target="_blank" 
                           class="whatsapp-btn">
                            <i class="fab fa-whatsapp"></i>
                            Pendaftaran Siswa (+62 898-7654-321)
                        </a>
                        
                        <a href="https://wa.me/6285123456789?text=Halo,%20saya%20ingin%20bertanya%20tentang%20program%20akademik" 
                           target="_blank" 
                           class="whatsapp-btn">
                            <i class="fab fa-whatsapp"></i>
                            Bagian Akademik (+62 851-2345-6789)
                        </a>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="social-section">
                    <h3>Media Sosial</h3>
                    <div class="social-links">
                        <a href="#" class="social-link facebook" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link instagram" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link youtube" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-link twitter" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="map-section">
                    <h3>Lokasi Sekolah</h3>
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d23687.597645473674!2d111.46019656855499!3d-7.8538656188164016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e799f86913d49b1%3A0x2eb724e320c5ce2c!2sSMK%20PGRI%202%20Ponorogo!5e0!3m2!1sen!2sid!4v1758501868621!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <p style="margin-top: 20px; color: #666; font-style: italic;">
                        Klik peta untuk melihat lokasi lebih detail di Google Maps
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Contact Cards -->
        <div class="quick-contact">
            <div class="quick-card fade-in-up">
                <div class="quick-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h4>Penerimaan Siswa</h4>
                <p>Informasi lengkap tentang penerimaan siswa baru, syarat pendaftaran, dan jadwal seleksi.</p>
            </div>

            <div class="quick-card fade-in-up">
                <div class="quick-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h4>Program Akademik</h4>
                <p>Kurikulum, ekstrakurikuler, dan berbagai program unggulan yang tersedia di sekolah kami.</p>
            </div>

            <div class="quick-card fade-in-up">
                <div class="quick-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4>Kerjasama</h4>
                <p>Peluang kerjasama dengan institusi lain, program magang, dan kemitraan strategis.</p>
            </div>
        </div>
    </section>
  

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Scroll Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Smooth scroll for anchor links
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

        // WhatsApp button hover effect
        document.querySelectorAll('.whatsapp-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.05)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Contact form validation and animation
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simple form validation
                const inputs = this.querySelectorAll('.form-control');
                let isValid = true;
                
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.style.borderColor = '#e74c3c';
                        isValid = false;
                    } else {
                        input.style.borderColor = '#27ae60';
                    }
                });
                
                if (isValid) {
                    // Show success message
                    const submitBtn = this.querySelector('.btn-send');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-check"></i> Pesan Terkirim!';
                    submitBtn.style.background = 'linear-gradient(135deg, #27ae60, #229954)';
                    
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.style.background = 'linear-gradient(135deg, var(--secondary-color), #2980b9)';
                        this.reset();
                    }, 3000);
                }
            });
        }

        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero');
            const speed = scrolled * 0.5;
            
            if (parallax) {
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });

        // Add loading animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>
