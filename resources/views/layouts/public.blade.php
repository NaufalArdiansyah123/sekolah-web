<!DOCTYPE html>
<html lang="id" class="loading">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <meta name="description" content="Website resmi sekolah">
    <title>SMK PGRI 2 PONOROGO</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        /* Enhanced Loading Animation Styles */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 25%, #3182ce 50%, #4299e1 75%, #63b3ed 100%);
            background-size: 400% 400%;
            animation: gradientShift 4s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        
        .page-loader::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulseOverlay 3s ease-in-out infinite;
        }
        
        .page-loader.fade-out {
            opacity: 0;
            transform: scale(1.1);
            pointer-events: none;
        }
        
        .loader-content {
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
            animation: contentFadeIn 1s ease-out;
        }
        
        .loader-logo {
            font-size: 4rem !important;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            animation: logoFloat 3s ease-in-out infinite;
            filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.5));
        }
        
        .loader-logo i {
            font-size: 4rem !important;
            width: auto !important;
            height: auto !important;
        }
        
        .loader-logo::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120%;
            height: 120%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: ringPulse 2s ease-in-out infinite;
        }
        
        .loader-logo::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 150%;
            height: 150%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: ringPulse 2s ease-in-out infinite 0.5s;
        }
        
        .loader-text {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 2rem;
            letter-spacing: 2px;
            animation: textGlow 2s ease-in-out infinite;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        
        .loader-progress {
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            margin: 0 auto 1.5rem;
            overflow: hidden;
            position: relative;
        }
        
        .loader-progress-bar {
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, #63b3ed, #4299e1, #3182ce);
            border-radius: 2px;
            animation: progressLoad 2.5s ease-out forwards;
            position: relative;
        }
        
        .loader-progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: progressShine 1.5s ease-in-out infinite;
        }
        
        .loader-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 1rem;
        }
        
        .loader-dot {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            animation: dotBounce 1.4s ease-in-out infinite;
        }
        
        .loader-dot:nth-child(1) { animation-delay: 0s; }
        .loader-dot:nth-child(2) { animation-delay: 0.2s; }
        .loader-dot:nth-child(3) { animation-delay: 0.4s; }
        
        /* Floating particles */
        .loader-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particleFloat 6s linear infinite;
        }
        
        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 0.5s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 1.5s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 2.5s; }
        
        /* Enhanced Keyframes */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes pulseOverlay {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.1; transform: scale(1.05); }
        }
        
        @keyframes contentFadeIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-10px) rotate(5deg); }
            50% { transform: translateY(0) rotate(0deg); }
            75% { transform: translateY(-5px) rotate(-5deg); }
        }
        
        @keyframes ringPulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
            50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.5; }
        }
        
        @keyframes textGlow {
            0%, 100% { text-shadow: 0 0 10px rgba(255, 255, 255, 0.5); }
            50% { text-shadow: 0 0 20px rgba(255, 255, 255, 0.8), 0 0 30px rgba(99, 179, 237, 0.5); }
        }
        
        @keyframes progressLoad {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        
        @keyframes progressShine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        
        @keyframes dotBounce {
            0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
            40% { transform: scale(1.2); opacity: 1; }
        }
        
        @keyframes particleFloat {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }
        
        /* Prevent scrolling during loading */
        html.loading,
        body.loading {
            overflow: hidden !important;
            height: 100% !important;
        }
        
        html.loading body {
            position: fixed !important;
            width: 100% !important;
        }
        
        /* Scroll Animation Styles */
        .scroll-animate {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scroll-animate.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        .scroll-animate-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scroll-animate-left.animate {
            opacity: 1;
            transform: translateX(0);
        }
        
        .scroll-animate-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scroll-animate-right.animate {
            opacity: 1;
            transform: translateX(0);
        }
        
        .scroll-animate-scale {
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scroll-animate-scale.animate {
            opacity: 1;
            transform: scale(1);
        }
        
        .scroll-animate-fade {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scroll-animate-fade.animate {
            opacity: 1;
        }
        
        /* Staggered animations */
        .scroll-animate-stagger {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scroll-animate-stagger.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        .scroll-animate-stagger:nth-child(1) { transition-delay: 0.1s; }
        .scroll-animate-stagger:nth-child(2) { transition-delay: 0.2s; }
        .scroll-animate-stagger:nth-child(3) { transition-delay: 0.3s; }
        .scroll-animate-stagger:nth-child(4) { transition-delay: 0.4s; }
        .scroll-animate-stagger:nth-child(5) { transition-delay: 0.5s; }
        .scroll-animate-stagger:nth-child(6) { transition-delay: 0.6s; }
        
        /* Card hover enhancements for scroll animations */
        .card.scroll-animate {
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease;
        }
        
        .card.scroll-animate:hover {
            transform: translateY(-8px) scale(1.02);
        }
        
        /* Section animations */
        section {
            position: relative;
        }
        
        .section-animate {
            opacity: 0;
            transform: translateY(60px);
            transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .section-animate.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Mobile optimizations for scroll animations */
        @media (max-width: 768px) {
            .scroll-animate,
            .scroll-animate-left,
            .scroll-animate-right,
            .scroll-animate-scale,
            .section-animate {
                transition-duration: 0.6s;
            }
            
            .scroll-animate {
                transform: translateY(30px);
            }
            
            .scroll-animate-left {
                transform: translateX(-30px);
            }
            
            .scroll-animate-right {
                transform: translateX(30px);
            }
            
            .section-animate {
                transform: translateY(40px);
            }
        }
        
        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .scroll-animate,
            .scroll-animate-left,
            .scroll-animate-right,
            .scroll-animate-scale,
            .scroll-animate-fade,
            .scroll-animate-stagger,
            .section-animate {
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
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
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
        }

        /* Navbar scrolled state */
        .navbar.scrolled {
            background: rgba(26, 32, 44, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            height: 70px;
        }

        .navbar.scrolled .brand-icon img {
            height: 40px;
        }

        .navbar.scrolled .brand-main {
            font-size: 1.1rem;
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
            background: transparent;
            border-radius: 0;
            padding: 0;
            margin-right: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-brand .brand-icon img {
            height: 50px;
            width: auto;
            object-fit: contain;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-brand:hover .brand-icon {
            transform: scale(1.05);
            box-shadow: none;
        }

        .navbar-brand:hover .brand-icon img {
            transform: scale(1.05);
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

        /* ENHANCED Dropdown Menu - Perfect Functionality */
        .dropdown-menu {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            padding: 12px;
            margin-top: 8px;
            min-width: 220px;
            z-index: 1060 !important;
            /* Clean positioning */
            transform: translateY(10px) !important;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
        }

        /* Enhanced hover for desktop */
        @media (min-width: 992px) {
            .navbar-nav .dropdown:hover .dropdown-menu {
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                transform: translateY(0) !important;
            }
            
            .navbar-nav .dropdown .dropdown-menu {
                display: block !important;
            }
        }

        /* Bootstrap show class for mobile/click */
        .dropdown-menu.show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            z-index: 1060 !important;
        }

        /* Force dropdown visibility when show class is present */
        .dropdown .dropdown-menu.show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
        }
        
        /* Ensure dropdown is always visible when show class is present */
        .dropdown-menu.show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
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

        /* Enhanced Mobile Toggler */
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
            position: relative;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.3);
            outline: none;
        }

        .navbar-toggler:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        
        /* Force collapsed state */
        .navbar-toggler.collapsed {
            border: none;
        }
        
        .navbar-toggler.collapsed .navbar-toggler-icon {
            background-color: white;
        }
        
        .navbar-toggler.collapsed .navbar-toggler-icon::before {
            transform: rotate(0deg);
            top: -7px;
        }
        
        .navbar-toggler.collapsed .navbar-toggler-icon::after {
            transform: rotate(0deg);
            top: 7px;
        }

        /* Simple Hamburger Icon */
        .navbar-toggler-icon {
            background-image: none;
            width: 22px;
            height: 2px;
            position: relative;
            background-color: white;
            display: block;
            transition: all 0.3s ease;
        }

        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: '';
            position: absolute;
            width: 22px;
            height: 2px;
            background-color: white;
            left: 0;
            transition: all 0.3s ease;
        }

        .navbar-toggler-icon::before {
            top: -7px;
        }

        .navbar-toggler-icon::after {
            top: 7px;
        }

        /* X animation - Enhanced */
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            background-color: transparent !important;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
            transform: rotate(45deg) !important;
            top: 0 !important;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
            transform: rotate(-45deg) !important;
            top: 0 !important;
        }
        
        /* Not collapsed state */
        .navbar-toggler:not(.collapsed) .navbar-toggler-icon {
            background-color: transparent !important;
        }

        .navbar-toggler:not(.collapsed) .navbar-toggler-icon::before {
            transform: rotate(45deg) !important;
            top: 0 !important;
        }

        .navbar-toggler:not(.collapsed) .navbar-toggler-icon::after {
            transform: rotate(-45deg) !important;
            top: 0 !important;
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

        /* Student Account Registration Button */
        .nav-item .register-btn {
            background: linear-gradient(135deg, #10b981, #34d399);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            color: white !important;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }

        .nav-item .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(16, 185, 129, 0.4);
            color: white !important;
            text-decoration: none;
        }

        /* ENHANCED Mobile Styles */
        @media (max-width: 991.98px) {
            .navbar {
                padding: 0.5rem 0;
                height: auto;
                min-height: 70px;
            }

            .navbar-collapse {
                background: rgba(26, 32, 44, 0.98);
                backdrop-filter: blur(20px);
                border-radius: 16px;
                margin-top: 16px;
                padding: 20px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
                max-height: 80vh;
                overflow-y: auto;
            }

            .navbar-nav {
                gap: 4px;
            }

            .navbar-nav .nav-link {
                padding: 14px 18px !important;
                border-radius: 12px;
                min-height: 48px;
                display: flex;
                align-items: center;
                font-size: 0.95rem;
                font-weight: 500;
                transition: all 0.2s ease;
            }

            .navbar-nav .nav-link:hover {
                background: rgba(255, 255, 255, 0.1);
                transform: translateX(4px);
            }

            .navbar-nav .nav-link.active {
                background: linear-gradient(135deg, var(--secondary-color), #4299e1);
                color: white !important;
            }

            /* ENHANCED Mobile dropdown */
            .dropdown-menu {
                background: rgba(255, 255, 255, 0.98) !important;
                margin: 8px 0 !important;
                position: static !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
                transform: none !important;
                opacity: 1 !important;
                visibility: visible !important;
                border-radius: 12px !important;
                padding: 8px !important;
                display: none !important;
                top: auto !important;
                left: auto !important;
                width: 100% !important;
                border: 1px solid rgba(0, 0, 0, 0.1) !important;
                max-height: 300px;
                overflow-y: auto;
                z-index: 1060 !important;
            }

            .dropdown-menu.show {
                display: block !important;
                animation: slideDown 0.3s ease-out;
                opacity: 1 !important;
                visibility: visible !important;
            }
            
            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .dropdown-item {
                padding: 12px 16px !important;
                min-height: 44px !important;
                display: flex !important;
                align-items: center !important;
                border-radius: 8px !important;
                margin-bottom: 2px !important;
                font-size: 0.9rem;
                transition: all 0.2s ease;
            }

            .dropdown-item:hover {
                background: rgba(49, 130, 206, 0.1) !important;
                transform: translateX(4px);
            }

            .dropdown-item i {
                width: 24px;
                font-size: 0.9rem;
            }

            .navbar-brand .brand-sub {
                display: none;
            }

            .navbar-brand .brand-icon img {
                height: 40px;
            }

            .navbar-brand .brand-main {
                font-size: 1rem;
            }

            /* Mobile user menu improvements */
            .user-dropdown .dropdown-toggle {
                background: rgba(255, 255, 255, 0.15);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 12px;
                padding: 12px 16px;
                width: 100%;
                justify-content: space-between;
            }

            /* Mobile action buttons */
            .login-btn, .register-btn {
                border-radius: 12px !important;
                padding: 12px 20px !important;
                margin: 4px 0 !important;
                text-align: center;
                justify-content: center;
                min-height: 48px;
                font-weight: 600;
            }

            .register-btn {
                background: linear-gradient(135deg, #10b981, #34d399) !important;
            }

            .login-btn {
                background: linear-gradient(135deg, var(--secondary-color), #4299e1) !important;
            }
        }

        /* Content Styles for Demo */
        .demo-content {
            padding: 40px 0;
            min-height: 80vh;
        }

        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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

            .navbar {
                padding: 0.5rem 0;
            }

            .navbar-toggler {
                width: 40px;
                height: 40px;
                padding: 6px;
            }

            .navbar-toggler-icon {
                width: 18px;
            }

            .navbar-toggler-icon::before,
            .navbar-toggler-icon::after {
                width: 18px;
            }

            .navbar-brand .brand-icon img {
                height: 35px;
            }

            .navbar-brand .brand-main {
                font-size: 0.9rem;
            }

            .navbar-collapse {
                padding: 16px;
                margin-top: 12px;
            }

            .navbar-nav .nav-link {
                padding: 12px 16px !important;
                font-size: 0.9rem;
            }

            .dropdown-item {
                padding: 10px 14px !important;
                font-size: 0.85rem;
            }
        }

        /* Extra small devices */
        @media (max-width: 575.98px) {
            .navbar-brand .brand-main {
                font-size: 0.85rem;
            }

            .navbar-brand .brand-icon img {
                height: 32px;
            }

            .navbar-collapse {
                padding: 12px;
            }

            .navbar-nav .nav-link {
                padding: 10px 14px !important;
                font-size: 0.85rem;
            }

            .dropdown-item {
                padding: 8px 12px !important;
                font-size: 0.8rem;
            }
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
    </style>
</head>

<body class="loading">
    <!-- Enhanced Page Loader -->
    <div class="page-loader" id="pageLoader">
        <!-- Floating Particles -->
        <div class="loader-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        
        <!-- Main Content -->
        <div class="loader-content">
            <div class="loader-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="loader-text">SMK PGRI 2 PONOROGO</div>
            <div class="loader-progress">
                <div class="loader-progress-bar"></div>
            </div>
            <div class="loader-dots">
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
                <div class="loader-dot"></div>
            </div>
        </div>
    </div>

    <!-- Enhanced Modern Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <!-- Enhanced Brand -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="brand-icon">
                    <img src="{{ asset('images/logo-sterida.png') }}" alt="Logo SMK PGRI 2 PONOROGO" onerror="this.style.display='none'">
                </div>
                <div class="brand-text">
                    <span class="brand-main">SMK PGRI 2 PONOROGO</span>
                    <span class="brand-sub d-none d-lg-block">Terbukti Lebih Maju</span>
                </div>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-2 d-lg-none"></i>Beranda
                        </a>
                    </li>

                    <!-- Profil Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('about.*') ? 'active' : '' }}" href="javascript:void(0)"
                            id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="academicDropdown" role="button"
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
                            <li><a class="dropdown-item" href="{{ route('public.extracurriculars.index') }}">
                                    <i class="fas fa-users me-3"></i>Ekstrakurikuler
                                </a></li>
                        </ul>
                    </li>

                    <!-- Informasi Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('news.*') || request()->routeIs('announcements.*') || request()->routeIs('agenda.*') ? 'active' : '' }}" href="javascript:void(0)" id="infoDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-newspaper me-2 d-lg-none"></i>Informasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('blog.index') }}">
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

                    <!-- Media Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('gallery.*') || request()->routeIs('public.videos.*') ? 'active' : '' }}" href="javascript:void(0)" id="mediaDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-photo-video me-2 d-lg-none"></i>Media
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('gallery.index') }}">
                                    <i class="fas fa-images me-3"></i>Galeri Foto
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('public.videos.index') }}">
                                    <i class="fas fa-video me-3"></i>Video Dokumentasi
                                </a></li>
                        </ul>
                    </li>

                    <!-- Lainnya Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('facilities.*') || request()->routeIs('achievements.*') || request()->routeIs('public.teachers.*') ? 'active' : '' }}" href="javascript:void(0)" id="moreDropdown" role="button"
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
                            <li><a class="dropdown-item" href="{{ route('public.teachers.index') }}">
                                    <i class="fas fa-chalkboard-teacher me-3"></i>Guru & Staff
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('contact') }}">
                                    <i class="fas fa-envelope me-3"></i>Kontak
                                </a></li>
                        </ul>
                    </li>

                    <!-- Desktop only links -->
                    <li class="nav-item d-none d-xl-block">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-2"></i>Kontak
                        </a>
                    </li>
                    <li class="nav-item d-none d-xl-block">
                        <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">
                            <i class="fas fa-newspaper me-2"></i>Berita
                        </a>
                    </li>
                </ul>

                <!-- User Menu -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown user-dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="userDropdown" role="button"
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
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
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
                        <!-- Student Account Registration Button -->
                        @php
                            $allowRegistration = \App\Models\Setting::get('allow_registration', '1');
                        @endphp
                        @if($allowRegistration === '1')
                        <li class="nav-item me-2">
                            <a class="nav-link register-btn" href="{{ route('student.register.form') }}">
                                <i class="fas fa-user-plus me-2"></i>Daftar Akun
                            </a>
                        </li>
                        @endif

                        <!-- Login Button -->
                        <li class="nav-item">
                            <a class="nav-link login-btn" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk
                            </a>
                        </li>
                    @endauth
                </ul>

                

                <!-- Alternative: Login/Register buttons -->
                <!--
                    <li class="nav-item me-2">
                        <a class="nav-link register-btn" href="#register">
                            <i class="fas fa-user-plus me-2"></i>Daftar Siswa
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link login-btn" href="#login">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </a>
                    </li>
                    -->

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
                    <h5><i class="fas fa-graduation-cap me-2"></i>SMK PGRI 2 PONOROGO</h5>
                    <p class="mb-3">Excellence in Education - Membentuk generasi yang berkarakter dan berprestasi untuk
                        masa depan Indonesia yang gemilang.</p>
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
                        <li class="mb-2"><a href="#profile" class="text-white-50 text-decoration-none">Profil
                                Sekolah</a></li>
                        <li class="mb-2"><a href="#facilities" class="text-white-50 text-decoration-none">Fasilitas</a>
                        </li>
                        <li class="mb-2"><a href="#achievements" class="text-white-50 text-decoration-none">Prestasi</a>
                        </li>
                        <li class="mb-2"><a href="#extra" class="text-white-50 text-decoration-none">Ekstrakurikuler</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6 class="fw-bold mb-3">Akademik</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#programs" class="text-white-50 text-decoration-none">Program
                                Studi</a></li>
                        <li class="mb-2"><a href="#calendar" class="text-white-50 text-decoration-none">Kalender</a>
                        </li>
                        <li class="mb-2"><a href="#gallery" class="text-white-50 text-decoration-none">Galeri</a></li>
                        <li class="mb-2"><a href="#videos" class="text-white-50 text-decoration-none">Video</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-3">Kontak Kami</h6>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <small>Jl. Pendidikan No. 123<br>Ponorogo, Jawa Timur 63411</small>
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <small>(0352) 123-4567</small>
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-envelope me-2"></i>
                        <small>info@smkpgri2ponorogo.sch.id</small>
                    </p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 2rem 0 1rem 0;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 SMK PGRI 2 PONOROGO. All rights reserved.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- Enhanced Loading Animation Script -->
    <script>
        // Enhanced loading animation control
        window.addEventListener('load', function() {
            // Wait for progress bar animation to complete
            setTimeout(function() {
                // Remove loading classes
                document.documentElement.classList.remove('loading');
                document.body.classList.remove('loading');
                
                // Hide loader with enhanced fade
                const pageLoader = document.getElementById('pageLoader');
                if (pageLoader) {
                    pageLoader.classList.add('fade-out');
                    
                    // Remove from DOM after fade animation
                    setTimeout(function() {
                        if (pageLoader.parentNode) {
                            pageLoader.parentNode.removeChild(pageLoader);
                        }
                    }, 800);
                }
            }, 2500); // Show loading for 2.5 seconds to see full animation
        });
        
        // Scroll Animation System
        function initScrollAnimations() {
            // Create intersection observer for scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const scrollObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                        // Don't unobserve to allow re-animation if needed
                    }
                });
            }, observerOptions);
            
            // Auto-apply scroll animations to common elements
            autoApplyScrollAnimations(scrollObserver);
            
            // Observe existing elements with scroll animation classes
            const existingAnimatedElements = document.querySelectorAll([
                '.scroll-animate',
                '.scroll-animate-left', 
                '.scroll-animate-right',
                '.scroll-animate-scale',
                '.scroll-animate-fade',
                '.scroll-animate-stagger',
                '.section-animate'
            ].join(', '));
            
            existingAnimatedElements.forEach(el => {
                scrollObserver.observe(el);
            });
        }
        
        function autoApplyScrollAnimations(observer) {
            // Apply animations to sections
            const sections = document.querySelectorAll('section');
            sections.forEach((section, index) => {
                if (!section.classList.contains('scroll-animate') && 
                    !section.classList.contains('section-animate')) {
                    section.classList.add('section-animate');
                    observer.observe(section);
                }
            });
            
            // Apply animations to cards with stagger effect
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                if (!card.classList.contains('scroll-animate')) {
                    if (index % 3 === 0) {
                        card.classList.add('scroll-animate-left');
                    } else if (index % 3 === 1) {
                        card.classList.add('scroll-animate');
                    } else {
                        card.classList.add('scroll-animate-right');
                    }
                    observer.observe(card);
                }
            });
            
            // Apply animations to headings
            const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
            headings.forEach((heading, index) => {
                if (!heading.classList.contains('scroll-animate')) {
                    heading.classList.add('scroll-animate-fade');
                    observer.observe(heading);
                }
            });
            
            // Apply animations to paragraphs
            const paragraphs = document.querySelectorAll('p');
            paragraphs.forEach((p, index) => {
                if (!p.classList.contains('scroll-animate') && 
                    p.textContent.trim().length > 50) { // Only animate longer paragraphs
                    p.classList.add('scroll-animate');
                    observer.observe(p);
                }
            });
            
            // Apply animations to images
            const images = document.querySelectorAll('img');
            images.forEach((img, index) => {
                if (!img.classList.contains('scroll-animate')) {
                    img.classList.add('scroll-animate-scale');
                    observer.observe(img);
                }
            });
            
            // Apply animations to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach((btn, index) => {
                if (!btn.classList.contains('scroll-animate')) {
                    btn.classList.add('scroll-animate');
                    observer.observe(btn);
                }
            });
            
            // Apply staggered animations to list items
            const listContainers = document.querySelectorAll('ul, ol');
            listContainers.forEach(container => {
                const listItems = container.querySelectorAll('li');
                if (listItems.length > 1) {
                    listItems.forEach((item, index) => {
                        if (!item.classList.contains('scroll-animate')) {
                            item.classList.add('scroll-animate-stagger');
                            observer.observe(item);
                        }
                    });
                }
            });
            
            // Apply animations to form elements
            const formGroups = document.querySelectorAll('.form-group, .mb-3, .form-floating');
            formGroups.forEach((group, index) => {
                if (!group.classList.contains('scroll-animate')) {
                    group.classList.add('scroll-animate');
                    observer.observe(group);
                }
            });
            
            // Apply animations to alert/notification elements
            const alerts = document.querySelectorAll('.alert, .notification, .toast');
            alerts.forEach((alert, index) => {
                if (!alert.classList.contains('scroll-animate')) {
                    alert.classList.add('scroll-animate-fade');
                    observer.observe(alert);
                }
            });
            
            // Apply animations to table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                if (!row.classList.contains('scroll-animate')) {
                    row.classList.add('scroll-animate-stagger');
                    observer.observe(row);
                }
            });
        }
        
        // Function to manually add scroll animation to elements
        function addScrollAnimation(element, animationType = 'scroll-animate') {
            if (element && !element.classList.contains(animationType)) {
                element.classList.add(animationType);
                
                // Create observer for this element
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate');
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });
                
                observer.observe(element);
            }
        }
        
        // Function to trigger animations on dynamically loaded content
        function refreshScrollAnimations() {
            initScrollAnimations();
        }
        
        // Expose functions globally for use in other scripts
        window.addScrollAnimation = addScrollAnimation;
        window.refreshScrollAnimations = refreshScrollAnimations;
        
        // Initialize scroll animations after loading
        initScrollAnimations();
        
        // Emergency fallback - ensure page loads
        setTimeout(function() {
            document.documentElement.classList.remove('loading');
            document.body.classList.remove('loading');
            
            const pageLoader = document.getElementById('pageLoader');
            if (pageLoader && pageLoader.parentNode) {
                pageLoader.parentNode.removeChild(pageLoader);
            }
        }, 4000); // Maximum 4 seconds
        
        // Add some interactive feedback
        document.addEventListener('DOMContentLoaded', function() {
            const pageLoader = document.getElementById('pageLoader');
            if (pageLoader) {
                // Add click to skip (optional)
                pageLoader.addEventListener('click', function() {
                    document.documentElement.classList.remove('loading');
                    document.body.classList.remove('loading');
                    pageLoader.classList.add('fade-out');
                    
                    setTimeout(function() {
                        if (pageLoader.parentNode) {
                            pageLoader.parentNode.removeChild(pageLoader);
                        }
                    }, 800);
                });
            }
        });
    </script>

    <!-- SAFE and WORKING Navbar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM loaded, initializing navbar...');
            
            try {
                // Safe element selection with null checks
                const navbar = document.querySelector('.navbar');
                const navbarCollapse = document.querySelector('#navbarNav');
                const navbarToggler = document.querySelector('.navbar-toggler');
                
                console.log('Elements found:', {
                    navbar: !!navbar,
                    navbarCollapse: !!navbarCollapse,
                    navbarToggler: !!navbarToggler
                });
                
                if (!navbar || !navbarCollapse || !navbarToggler) {
                    console.error('Required navbar elements not found!');
                    return;
                }
                
                let isDesktop = window.innerWidth >= 992;

                // Navbar scroll effect
                if (navbar) {
                    window.addEventListener('scroll', function () {
                        if (window.scrollY > 50) {
                            navbar.classList.add('scrolled');
                        } else {
                            navbar.classList.remove('scrolled');
                        }
                    });
                }

                // Simple function to close all dropdowns
                function closeAllDropdowns() {
                    try {
                        const openMenus = document.querySelectorAll('.dropdown-menu.show');
                        const toggles = document.querySelectorAll('.dropdown-toggle');
                        
                        openMenus.forEach(menu => {
                            menu.classList.remove('show');
                        });
                        
                        toggles.forEach(toggle => {
                            toggle.setAttribute('aria-expanded', 'false');
                        });
                    } catch (error) {
                        console.warn('Error closing dropdowns:', error);
                    }
                }

                // SAFE dropdown handling with enhanced error protection
                function setupDropdowns() {
                    try {
                        const dropdowns = document.querySelectorAll('.dropdown');
                        console.log('Setting up', dropdowns.length, 'dropdowns');

                        dropdowns.forEach((dropdown, index) => {
                            const toggle = dropdown.querySelector('.dropdown-toggle');
                            const menu = dropdown.querySelector('.dropdown-menu');
                            
                            if (!toggle || !menu) {
                                console.warn('Dropdown missing elements at index', index);
                                return;
                            }

                            // Ensure Bootstrap data attributes are present
                            toggle.setAttribute('data-bs-toggle', 'dropdown');
                            toggle.setAttribute('aria-expanded', 'false');
                            
                            // Fix href if it's just '#'
                            if (toggle.getAttribute('href') === '#') {
                                toggle.setAttribute('href', 'javascript:void(0)');
                            }

                            // Enhanced click handler with better error handling
                            toggle.addEventListener('click', function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                
                                console.log('Dropdown clicked:', this);
                                
                                try {
                                    const isOpen = menu.classList.contains('show');
                                    
                                    // Close all dropdowns first
                                    if (typeof closeAllDropdowns === 'function') {
                                        closeAllDropdowns();
                                    }
                                    
                                    // Toggle current dropdown
                                    if (!isOpen) {
                                        menu.classList.add('show');
                                        toggle.setAttribute('aria-expanded', 'true');
                                        console.log('Dropdown opened');
                                    } else {
                                        console.log('Dropdown was already open, now closed');
                                    }
                                } catch (error) {
                                    console.error('Error in dropdown toggle:', error);
                                }
                            });

                            // Desktop hover behavior
                            if (isDesktop) {
                                let hoverTimeout;
                                
                                dropdown.addEventListener('mouseenter', function () {
                                    clearTimeout(hoverTimeout);
                                    menu.classList.add('show');
                                    toggle.setAttribute('aria-expanded', 'true');
                                });

                                dropdown.addEventListener('mouseleave', function () {
                                    hoverTimeout = setTimeout(() => {
                                        menu.classList.remove('show');
                                        toggle.setAttribute('aria-expanded', 'false');
                                    }, 200);
                                });
                            }

                            // Prevent menu from closing when clicking inside
                            menu.addEventListener('click', function(e) {
                                e.stopPropagation();
                            });
                        });
                    } catch (error) {
                        console.error('Error setting up dropdowns:', error);
                    }
                }

                // Initialize dropdowns
                setupDropdowns();
                
                // Verify dropdown setup
                const dropdownCount = document.querySelectorAll('.dropdown').length;
                const menuCount = document.querySelectorAll('.dropdown-menu').length;
                
                // Verify Bootstrap and ensure all attributes
                setTimeout(() => {
                    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
                    
                    dropdownToggles.forEach((toggle, index) => {
                        const hasDataToggle = toggle.hasAttribute('data-bs-toggle');
                        
                        if (!hasDataToggle) {
                            toggle.setAttribute('data-bs-toggle', 'dropdown');
                        }
                    });
                    
                    // Ensure mobile toggle has correct attributes
                    if (navbarToggler) {
                        navbarToggler.setAttribute('data-bs-toggle', 'collapse');
                        navbarToggler.setAttribute('data-bs-target', '#navbarNav');
                        navbarToggler.setAttribute('aria-controls', 'navbarNav');
                        
                        // Mobile toggle attributes verified
                    }
                    
                    // All systems ready
                }, 500);

                // Close dropdowns when clicking outside
                document.addEventListener('click', function (e) {
                    if (!e.target.closest('.dropdown')) {
                        closeAllDropdowns();
                    }
                });

                // Close dropdown when clicking dropdown items
                document.addEventListener('click', function(e) {
                    const dropdownItem = e.target.closest('.dropdown-item');
                    if (dropdownItem) {
                        // Allow the link to work first, then close dropdown
                        setTimeout(() => {
                            closeAllDropdowns();
                            
                            // Close mobile menu if open
                            if (!isDesktop && navbarCollapse && navbarCollapse.classList.contains('show')) {
                                navbarCollapse.classList.remove('show');
                                if (navbarToggler) {
                                    navbarToggler.classList.add('collapsed');
                                    navbarToggler.setAttribute('aria-expanded', 'false');
                                }
                            }
                        }, 150);
                    }
                });

                // Handle escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeAllDropdowns();
                    }
                });

                // Close mobile menu when clicking regular nav links
                const navLinks = document.querySelectorAll('.navbar-nav .nav-link:not(.dropdown-toggle)');
                navLinks.forEach(link => {
                    link.addEventListener('click', function () {
                        if (!isDesktop && navbarCollapse && navbarCollapse.classList.contains('show')) {
                            setTimeout(() => {
                                navbarCollapse.classList.remove('show');
                                if (navbarToggler) {
                                    navbarToggler.classList.add('collapsed');
                                    navbarToggler.setAttribute('aria-expanded', 'false');
                                }
                            }, 100);
                        }
                    });
                });

                // Handle window resize
                let resizeTimeout;
                window.addEventListener('resize', function () {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                        const newIsDesktop = window.innerWidth >= 992;
                        
                        if (newIsDesktop !== isDesktop) {
                            isDesktop = newIsDesktop;
                            closeAllDropdowns();
                            
                            // Close mobile menu when switching to desktop
                            if (isDesktop && navbarCollapse && navbarCollapse.classList.contains('show')) {
                                navbarCollapse.classList.remove('show');
                                if (navbarToggler) {
                                    navbarToggler.classList.add('collapsed');
                                    navbarToggler.setAttribute('aria-expanded', 'false');
                                }
                            }
                            
                            // Re-setup dropdowns
                            setupDropdowns();
                        }
                    }, 300);
                });

                // SIMPLE and SAFE mobile menu toggle
                console.log('Setting up mobile toggle...');
                
                navbarToggler.addEventListener('click', function(e) {
                    console.log('Mobile toggle clicked!');
                    e.preventDefault();
                    e.stopPropagation();
                    
                    try {
                        // Close all dropdowns first
                        if (typeof closeAllDropdowns === 'function') {
                            closeAllDropdowns();
                        }
                        
                        // Simple toggle logic
                        const isOpen = navbarCollapse.classList.contains('show');
                        console.log('Menu is currently:', isOpen ? 'open' : 'closed');
                        
                        if (isOpen) {
                            // Close menu
                            navbarCollapse.classList.remove('show');
                            navbarToggler.classList.add('collapsed');
                            navbarToggler.setAttribute('aria-expanded', 'false');
                            console.log('Menu closed');
                        } else {
                            // Open menu
                            navbarCollapse.classList.add('show');
                            navbarToggler.classList.remove('collapsed');
                            navbarToggler.setAttribute('aria-expanded', 'true');
                            console.log('Menu opened');
                        }
                    } catch (error) {
                        console.error('Error in mobile toggle:', error);
                    }
                });

                // Simple menu close on outside click
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.navbar')) {
                        if (navbarCollapse.classList.contains('show')) {
                            navbarCollapse.classList.remove('show');
                            navbarToggler.classList.add('collapsed');
                            navbarToggler.setAttribute('aria-expanded', 'false');
                        }
                    }
                });

                // Touch handling for mobile
                if ('ontouchstart' in window) {
                    document.addEventListener('touchstart', function(e) {
                        if (!e.target.closest('.dropdown') && !e.target.closest('.navbar-toggler')) {
                            closeAllDropdowns();
                        }
                    });
                }

                // Active link highlighting
                function updateActiveLinks() {
                    try {
                        const currentPath = window.location.pathname;
                        const navLinks = document.querySelectorAll('.nav-link');

                        navLinks.forEach(link => {
                            const href = link.getAttribute('href');
                            if (href && (href === currentPath || (currentPath === '/' && href.includes('home')))) {
                                link.classList.add('active');
                            } else {
                                link.classList.remove('active');
                            }
                        });
                    } catch (error) {
                        // Silently fail
                    }
                }

                updateActiveLinks();

                // Safe smooth scrolling for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        const targetId = this.getAttribute('href');
                        
                        // Validate selector before using
                        if (targetId && targetId !== '#' && targetId.length > 1) {
                            try {
                                // Additional validation for valid CSS selector
                                if (targetId.match(/^#[a-zA-Z][a-zA-Z0-9_-]*$/)) {
                                    const target = document.querySelector(targetId);
                                    if (target) {
                                        e.preventDefault();
                                        target.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'start'
                                        });
                                        
                                        // Close mobile menu
                                        if (!isDesktop && navbarCollapse && navbarCollapse.classList.contains('show')) {
                                            setTimeout(() => {
                                                navbarCollapse.classList.remove('show');
                                                if (navbarToggler) {
                                                    navbarToggler.classList.add('collapsed');
                                                    navbarToggler.setAttribute('aria-expanded', 'false');
                                                }
                                            }, 100);
                                        }
                                    }
                                } else {
                                    console.warn('Invalid selector:', targetId);
                                }
                            } catch (error) {
                                console.warn('Error with selector:', targetId, error);
                            }
                        }
                    });
                });

                // Simple functionality test
                // Simple test
                setTimeout(() => {
                    console.log('Navbar initialization complete');
                    console.log('Mobile toggle ready for use');
                }, 1000);

            } catch (error) {
                console.error('Navbar initialization error:', error);
            }
        });
    </script>
</body>

</html>