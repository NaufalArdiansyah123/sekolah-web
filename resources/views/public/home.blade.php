@extends('layouts.public')

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
        --gold-color: #fbbf24;
    }

    /* Enhanced Slideshow Styles with 4:3 Aspect Ratio */
    .slideshow-container {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3; /* Changed to 4:3 aspect ratio */
        max-height: 60vh; /* Increased max height for better visibility */
        min-height: 450px; /* Increased minimum height */
        overflow: hidden;
        border-radius: 0 0 50px 50px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: all 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        transform: scale(1.05);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-color: #1a202c;
    }

    .slide.active {
        opacity: 1;
        transform: scale(1);
    }

    /* Removed overlay backgrounds for transparent effect */
    .slide::before {
        display: none;
    }

    .slide::after {
        display: none;
    }

    .slide-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        z-index: 10;
        max-width: 900px;
        padding: 0 20px;
        display: none; /* Hide all slide content */
    }

    /* Bottom buttons container */
    .slideshow-bottom-buttons {
        position: absolute;
        bottom: 60px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 20px;
        z-index: 20;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-slideshow-bottom {
        padding: 12px 24px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(20px);
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 1px;
        min-width: 160px;
        justify-content: center;
    }

    .btn-slideshow-bottom::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-slideshow-bottom:hover::before {
        left: 100%;
    }

    .btn-primary-slideshow {
        background: rgba(251, 191, 36, 0.9);
        color: white;
        border: 2px solid var(--gold-color);
        box-shadow: 0 8px 32px rgba(251, 191, 36, 0.4);
    }

    .btn-primary-slideshow:hover {
        background: var(--gold-color);
        border-color: var(--gold-color);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 15px 40px rgba(251, 191, 36, 0.6);
        color: #1a202c;
        text-decoration: none;
    }

    .btn-secondary-slideshow {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid rgba(255,255,255,0.4);
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    }

    .btn-secondary-slideshow:hover {
        background: rgba(255,255,255,0.3);
        border-color: rgba(255,255,255,0.7);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        color: white;
        text-decoration: none;
    }

    .slide-subtitle {
        font-size: clamp(0.8rem, 2vw, 1rem);
        font-weight: 600;
        color: var(--gold-color);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        opacity: 0.95;
        animation: subtitlePulse 3s ease-in-out infinite;
    }

    @keyframes subtitlePulse {
        0%, 100% { opacity: 0.95; transform: translateY(0); }
        50% { opacity: 1; transform: translateY(-2px); }
    }

    .slide-content h1 {
        font-size: clamp(2.5rem, 6vw, 5rem); /* Adjusted for 4:3 ratio */
        font-weight: 900;
        line-height: 0.9;
        margin-bottom: 1.5rem;
        text-shadow: 0 8px 40px rgba(0,0,0,0.8);
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: titleGlow 4s ease-in-out infinite alternate;
        letter-spacing: -2px;
        text-transform: uppercase;
        font-family: 'Arial Black', sans-serif;
    }

    @keyframes titleGlow {
        0% { 
            text-shadow: 0 8px 40px rgba(0,0,0,0.8);
            filter: drop-shadow(0 0 20px rgba(255,255,255,0.3));
        }
        100% { 
            text-shadow: 0 8px 40px rgba(59, 130, 246, 0.4);
            filter: drop-shadow(0 0 30px rgba(255,255,255,0.5));
        }
    }

    .slide-content p {
        font-size: clamp(0.9rem, 2vw, 1.1rem); /* Adjusted for better proportion */
        font-weight: 400;
        opacity: 0.95;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        line-height: 1.6;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .slide-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }

    .btn-slide {
        padding: 12px 24px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(20px);
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-slide:hover::before {
        left: 100%;
    }

    .btn-primary-slide {
        background: rgba(251, 191, 36, 0.2);
        color: white;
        border: 2px solid var(--gold-color);
        box-shadow: 0 8px 32px rgba(251, 191, 36, 0.3);
    }

    .btn-primary-slide:hover {
        background: var(--gold-color);
        border-color: var(--gold-color);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 15px 40px rgba(251, 191, 36, 0.5);
        color: #1a202c;
        text-decoration: none;
    }

    .btn-secondary-slide {
        background: rgba(255,255,255,0.15);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    }

    .btn-secondary-slide:hover {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.6);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        color: white;
        text-decoration: none;
    }

    .slideshow-dots {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 20;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255,255,255,0.4);
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        border: 2px solid transparent;
    }

    .dot.active {
        background: var(--gold-color);
        transform: scale(1.2);
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.6);
    }

    .dot:hover {
        background: rgba(255,255,255,0.7);
        transform: scale(1.1);
    }

    .slide-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--gold-color), #fcd34d, #f59e0b);
        z-index: 20;
        transform-origin: left;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    @keyframes slideProgress {
        0% { transform: scaleX(0); }
        100% { transform: scaleX(1); }
    }
    
    /* Progress bar states */
    .slide-progress.running {
        animation: slideProgress 6s linear;
    }
    
    .slide-progress.paused {
        animation-play-state: paused;
    }

    .slide-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(251, 191, 36, 0.2);
        border: 2px solid var(--gold-color);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        z-index: 20;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .slide-nav:hover {
        background: var(--gold-color);
        border-color: var(--gold-color);
        color: #1a202c;
        transform: translateY(-50%) scale(1.1);
    }

    .slide-nav.prev {
        left: 20px;
    }

    .slide-nav.next {
        right: 20px;
    }

    .floating-element {
        position: absolute;
        z-index: 5;
        opacity: 0.1;
        animation: float 6s ease-in-out infinite;
        color: var(--gold-color);
        filter: drop-shadow(0 0 10px rgba(251, 191, 36, 0.3));
    }

    .floating-element:nth-child(1) {
        top: 15%;
        left: 10%;
        animation-delay: 0s;
    }

    .floating-element:nth-child(2) {
        top: 65%;
        right: 15%;
        animation-delay: 2s;
    }

    .floating-element:nth-child(3) {
        bottom: 25%;
        left: 20%;
        animation-delay: 4s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.1; }
        50% { transform: translateY(-15px) rotate(5deg); opacity: 0.2; }
    }

    .slide-content > * {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .slide.active .slide-content > * {
        opacity: 1;
        transform: translateY(0);
    }

    .slide.active .slide-content .slide-subtitle {
        opacity: 1;
        transform: translateY(0);
        transition-delay: 0.1s;
    }

    .slide.active .slide-content h1 {
        transition-delay: 0.3s;
    }

    .slide.active .slide-content p {
        transition-delay: 0.5s;
    }

    .slide.active .slide-content .slide-buttons {
        transition-delay: 0.7s;
    }

    .slide-decoration {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 10% 20%, rgba(251, 191, 36, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(252, 211, 77, 0.06) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(245, 158, 11, 0.04) 0%, transparent 50%);
        z-index: 3;
        animation: decorationMove 20s ease-in-out infinite;
    }

    @keyframes decorationMove {
        0%, 100% { transform: scale(1) rotate(0deg); }
        50% { transform: scale(1.05) rotate(2deg); }
    }

    /* Enhanced Stats Cards with Counting Animation */
    .stats-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        position: relative;
    }
    
    /* Mobile Debug Indicator */
    .mobile-debug {
        position: fixed;
        top: 10px;
        right: 10px;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        z-index: 9999;
        display: none;
    }
    
    @media (max-width: 768px) {
        .mobile-debug {
            display: block;
        }
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
        box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
    }
    
    .stats-card:hover .stats-number {
        animation: numberPulse 0.6s ease-in-out;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--gold-color), #fcd34d, #f59e0b, #d97706);
        transform: scaleX(0);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .stats-card:hover::before {
        transform: scaleX(1);
    }
    
    .stats-icon-wrapper {
        position: relative;
    }
    
    .stats-icon {
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotateY(360deg);
    }
    
    .stats-number {
        font-family: 'Arial', monospace;
        font-weight: 900 !important;
        letter-spacing: -2px;
        line-height: 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        display: inline-block;
    }
    
    .stats-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }
    
    .stats-bar {
        height: 3px;
        width: 60px;
        margin: 15px auto 0;
        border-radius: 2px;
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-bar {
        width: 100px;
        opacity: 1;
    }
    
    /* Enhanced Counter Animation Keyframes */
    @keyframes countUp {
        0% { 
            opacity: 0; 
            transform: translateY(20px) scale(0.8); 
        }
        50% {
            opacity: 0.7;
            transform: translateY(-5px) scale(1.05);
        }
        100% { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
        }
    }
    
    @keyframes numberPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    @keyframes numberGlow {
        0% { 
            text-shadow: 0 0 5px rgba(251, 191, 36, 0.3);
        }
        50% { 
            text-shadow: 0 0 20px rgba(251, 191, 36, 0.6), 0 0 30px rgba(251, 191, 36, 0.4);
        }
        100% { 
            text-shadow: 0 0 5px rgba(251, 191, 36, 0.3);
        }
    }
    
    .stats-number.counting {
        animation: countUp 0.8s ease-out, numberGlow 2s ease-in-out;
    }
    
    .stats-number {
        position: relative;
        display: inline-block;
    }
    
    .stats-card:hover .stats-number {
        animation: numberPulse 0.6s ease-in-out;
    }
    
    .stats-number {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .stats-number::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 120%;
        height: 120%;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        transition: transform 0.3s ease;
        z-index: -1;
        opacity: 0;
    }
    
    .stats-card:hover .stats-number::after {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
    
    /* Enhanced Featured Content */
    .featured-section {
        padding: 80px 0;
        background: white;
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
        position: relative;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--gold-color);
        border-radius: 2px;
    }
    
    .section-title p {
        color: var(--dark-gray);
        font-size: 1.1rem;
    }
    
    .news-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    .news-image {
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--gold-color), #f59e0b);
    }
    
    .news-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.8s ease;
    }
    
    .news-card:hover .news-image::before {
        transform: translateX(100%);
    }
    
    .news-image i {
        font-size: 3rem;
        color: white;
        z-index: 2;
        position: relative;
    }
    
    .sidebar-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .sidebar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .sidebar-card .card-header {
        padding: 20px;
        font-weight: 600;
        border: none;
        position: relative;
        background: linear-gradient(135deg, var(--gold-color), #f59e0b) !important;
        color: white !important;
    }
    
    .sidebar-card .card-body {
        padding: 25px;
    }
    
    /* Enhanced Features Section */
    .features-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        position: relative;
    }
    
    .feature-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .feature-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .feature-card:hover::before {
        opacity: 1;
    }
    
    .feature-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }
    
    .feature-card i {
        margin-bottom: 25px;
        padding: 25px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.1), rgba(252, 211, 77, 0.05));
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 2;
    }
    
    .feature-card:hover i {
        transform: scale(1.2) rotate(10deg);
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(252, 211, 77, 0.1));
        color: var(--gold-color);
    }
    
    .text-purple {
        color: #8b5cf6 !important;
    }
    
    .feature-card h5 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
    }
    
    .feature-card p {
        color: var(--dark-gray);
        line-height: 1.6;
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
        background: linear-gradient(135deg, var(--gold-color), #f59e0b);
        border: none;
        box-shadow: 0 8px 25px rgba(251, 191, 36, 0.3);
        color: white;
    }
    
    .btn-primary-enhanced:hover {
        box-shadow: 0 12px 35px rgba(251, 191, 36, 0.4);
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
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

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .slideshow-container {
            min-height: 400px; /* Adjusted for 4:3 ratio */
            border-radius: 0 0 30px 30px;
            aspect-ratio: 4/3; /* Maintain 4:3 ratio on mobile */
        }

        .slide-content {
            padding: 0 15px;
        }

        .slide-subtitle {
            font-size: 0.7rem;
            letter-spacing: 1px;
            margin-bottom: 0.8rem;
        }

        .slide-content h1 {
            font-size: clamp(2rem, 8vw, 3.5rem); /* Adjusted for 4:3 ratio */
            letter-spacing: -1px;
            margin-bottom: 1rem;
        }

        .slide-content p {
            font-size: clamp(0.8rem, 2.2vw, 1rem);
            margin-bottom: 1rem;
        }

        .slide-buttons {
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-top: 1rem;
        }

        .btn-slide {
            width: 250px;
            justify-content: center;
            font-size: 0.9rem;
            padding: 10px 20px;
        }

        .slide-nav {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .slide-nav.prev {
            left: 15px;
        }

        .slide-nav.next {
            right: 15px;
        }

        .slideshow-dots {
            bottom: 15px;
            gap: 10px;
        }

        .dot {
            width: 8px;
            height: 8px;
        }

        .floating-element {
            opacity: 0.05;
        }

        .stats-card {
            margin-bottom: 30px;
        }

        .section-title h2 {
            font-size: 2rem;
        }

        /* Mobile responsive for bottom buttons */
        .slideshow-bottom-buttons {
            bottom: 50px;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding: 0 20px;
        }

        .btn-slideshow-bottom {
            width: 200px;
            font-size: 0.9rem;
            padding: 10px 20px;
            min-width: auto;
        }
    }

    @media (max-width: 480px) {
        .slideshow-container {
            min-height: 350px; /* Adjusted for 4:3 ratio */
        }

        .slide-content h1 {
            font-size: clamp(1.8rem, 7vw, 3rem);
        }

        .slide-subtitle {
            font-size: 0.6rem;
        }

        .btn-slide {
            width: 220px;
            font-size: 0.85rem;
            padding: 8px 16px;
        }

        /* Extra small mobile responsive for bottom buttons */
        .slideshow-bottom-buttons {
            bottom: 40px;
            gap: 10px;
            padding: 0 15px;
        }

        .btn-slideshow-bottom {
            width: 180px;
            font-size: 0.85rem;
            padding: 8px 16px;
        }
    }
</style>

<!-- Enhanced Slideshow Section -->
<section class="slideshow-container" id="enhanced-slideshow">
    @if($slideshows->count() > 0)
        @foreach($slideshows as $index => $slide)
            <div class="slide {{ $index === 0 ? 'active' : '' }}" 
                 style="background-image: url('{{ asset('storage/' . $slide->image) }}')">
                <div class="slide-decoration"></div>
                <div class="floating-element">
                    <i class="fas fa-award fa-4x"></i>
                </div>
                <div class="floating-element">
                    <i class="fas fa-star fa-3x"></i>
                </div>
                <div class="floating-element">
                    <i class="fas fa-trophy fa-3x"></i>
                </div>
                <div class="slide-content">
                    <div class="slide-subtitle fade-in-up">{{ $slide->subtitle ?? 'DISIPLIN ADALAH KUNCI SUKSES' }}</div>
                    <h1 class="fade-in-up">{{ $slide->title ?? 'DISIPLIN' }}</h1>
                    <p class="fade-in-up">{{ $slide->description ?? 'Membangun karakter siswa yang bertanggung jawab dan berdisiplin tinggi untuk meraih prestasi terbaik dalam kehidupan' }}</p>
                    <div class="slide-buttons fade-in-up">
                        <a href="{{ route('about.profile') }}" class="btn-slide btn-primary-slide">
                            <i class="fas fa-info-circle"></i>
                            Tentang Kami
                        </a>
                        <a href="{{ route('blog.index') }}" class="btn-slide btn-secondary-slide">
                            <i class="fas fa-newspaper"></i>
                            Lihat Berita
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        {{-- Default slide if no slideshow data --}}
        <div class="slide active" 
             style="background-image: url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2032&q=80')">
            <div class="slide-decoration"></div>
            <div class="floating-element">
                <i class="fas fa-award fa-4x"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-star fa-3x"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-trophy fa-3x"></i>
            </div>
            <div class="slide-content">
                <div class="slide-subtitle fade-in-up">DISIPLIN ADALAH KUNCI SUKSES</div>
                <h1 class="fade-in-up">DISIPLIN</h1>
                <p class="fade-in-up">Membangun karakter siswa yang bertanggung jawab dan berdisiplin tinggi untuk meraih prestasi terbaik dalam kehidupan</p>
                <div class="slide-buttons fade-in-up">
                    <a href="#" class="btn-slide btn-primary-slide">
                        <i class="fas fa-info-circle"></i>
                        Tentang Kami
                    </a>
                    <a href="{{ route('blog.index') }}" class="btn-slide btn-secondary-slide">
                        <i class="fas fa-newspaper"></i>
                        Lihat Berita
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Navigation Arrows (only show if more than 1 slide) --}}
    @if($slideshows->count() > 1)
        <button class="slide-nav prev" onclick="changeSlideEnhanced(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slide-nav next" onclick="changeSlideEnhanced(1)">
            <i class="fas fa-chevron-right"></i>
        </button>

        {{-- Dots Navigation --}}
        <div class="slideshow-dots">
            @foreach($slideshows as $index => $slide)
                <span class="dot {{ $index === 0 ? 'active' : '' }}" 
                      onclick="currentSlideEnhanced({{ $index + 1 }})"></span>
            @endforeach
        </div>

        {{-- Progress Bar --}}
        <div class="slide-progress"></div>
    @endif

    {{-- Bottom Buttons --}}
    <div class="slideshow-bottom-buttons">
        <a href="{{ route('about.profile') }}" class="btn-slideshow-bottom btn-primary-slideshow">
            <i class="fas fa-info-circle"></i>
            Tentang Kami
        </a>
        <a href="{{ route('blog.index') }}" class="btn-slideshow-bottom btn-secondary-slideshow">
            <i class="fas fa-newspaper"></i>
            Berita
        </a>
    </div>
</section>

<!-- Enhanced Quick Stats with Counting Animation -->
<section class="stats-section">
    <div class="container">
        <div class="section-title">
            <h2 class="fade-in-up">{{ school_name() }}</h2>
            <p class="fade-in-up">Pencapaian dan prestasi yang membanggakan</p>
        </div>
        <div class="row text-center g-4">
            <!-- Card 1 -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-users fa-3x text-primary stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-primary mb-2" data-target="{{ $stats['total_students'] }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">JUMLAH SISWA</p>
                        <div class="stats-bar bg-primary"></div>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-chalkboard-teacher fa-3x text-success stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-success mb-2" data-target="{{ $stats['total_teachers'] }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">JUMLAH GURU</p>
                        <div class="stats-bar bg-success"></div>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-trophy fa-3x" style="color: var(--gold-color);"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold mb-2" style="color: var(--gold-color);" data-target="{{ $stats['total_achievements'] }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">PRESTASI SEKOLAH</p>
                        <div class="stats-bar" style="background-color: var(--gold-color);"></div>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-graduation-cap fa-3x text-info stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-info mb-2" data-target="{{ $stats['graduation_rate'] }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">TINGKAT KELULUSAN (%)</p>
                        <div class="stats-bar bg-info"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Featured Content -->
<section class="featured-section">
    <div class="container">
        <div class="row">
            <!-- Berita Terbaru -->
            <div class="col-md-8 mb-4">
                <div class="section-title text-start">
                    <h2 class="fade-in-left"><i class="fas fa-newspaper me-3" style="color: var(--gold-color);"></i>Berita Terbaru</h2>
                    <p class="fade-in-left">Informasi terkini seputar kegiatan dan prestasi sekolah</p>
                </div>

                @if($latestNews->count() > 0)
                    @foreach($latestNews as $news)
                        <div class="news-card fade-in-left">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    @if($news->featured_image)
                                        <div class="news-image" style="background-image: url('{{ asset('storage/' . $news->featured_image) }}'); background-size: cover; background-position: center;">
                                        </div>
                                    @else
                                        <div class="news-image">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-bold">
                                            <a href="{{ route('public.blog.show', $news->id) }}" class="text-decoration-none text-dark">
                                                {{ Str::limit($news->title, 60) }}
                                            </a>
                                        </h5>
                                        <p class="card-text">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>{{ $news->created_at->diffForHumans() }}
                                                @if($news->author)
                                                    <i class="fas fa-user ms-2 me-1"></i>{{ $news->author }}
                                                @endif
                                            </small>
                                        </p>
                                        <a href="{{ route('public.blog.show', $news->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-arrow-right me-1"></i>Baca Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- No News Available -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-newspaper fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted mb-3">Belum Ada Berita Terbaru</h5>
                        <p class="text-muted mb-4">Saat ini belum ada berita terbaru yang dipublikasikan. Silakan kembali lagi nanti untuk mendapatkan informasi terkini seputar kegiatan sekolah.</p>
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-newspaper me-2"></i>Lihat Arsip Berita
                        </a>
                    </div>
                @endif

                @if($latestNews->count() > 0)
                    <a href="{{ route('blog.index') }}" class="btn btn-primary-enhanced btn-enhanced mt-3">
                        <i class="fas fa-arrow-right me-2"></i>Lihat Semua Berita
                    </a>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="sidebar-card fade-in-right">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Pengumuman Penting</h5>
                    </div>
                    <div class="card-body">
                        @if($latestAnnouncements->count() > 0)
                            @foreach($latestAnnouncements as $index => $announcement)
                                <div class="announcement-item {{ $index < $latestAnnouncements->count() - 1 ? 'mb-3 pb-3 border-bottom' : '' }}">
                                    <h6 class="fw-bold text-primary">
                                        <a href="{{ route('announcements.show', $announcement->id) }}" class="text-decoration-none">
                                            {{ Str::limit($announcement->judul, 40) }}
                                        </a>
                                    </h6>
                                    <p class="mb-1 small">{{ Str::limit(strip_tags($announcement->isi), 80) }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $announcement->created_at->format('d M Y') }}
                                        @if($announcement->prioritas === 'tinggi')
                                            <span class="badge bg-danger ms-2">Penting</span>
                                        @endif
                                    </small>
                                </div>
                            @endforeach
                        @else
                            <!-- No Announcements Available -->
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <i class="fas fa-bullhorn fa-3x text-muted"></i>
                                </div>
                                <h6 class="text-muted mb-2">Belum Ada Pengumuman Terbaru</h6>
                                <p class="text-muted small mb-0">Saat ini belum ada pengumuman penting yang dipublikasikan. Silakan kembali lagi nanti untuk mendapatkan informasi terkini.</p>
                            </div>
                        @endif
                        
                        @if($latestAnnouncements->count() > 0)
                            <a href="{{ route('announcements.index') }}" class="btn btn-outline-warning btn-enhanced mt-3 w-100">
                                <i class="fas fa-bullhorn me-2"></i>Lihat Semua Pengumuman
                            </a>
                        @else
                            <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary btn-enhanced mt-3 w-100">
                                <i class="fas fa-bullhorn me-2"></i>Lihat Arsip Pengumuman
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="sidebar-card fade-in-right">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Agenda Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        @if($upcomingAgendas->count() > 0)
                            @foreach($upcomingAgendas as $index => $agenda)
                                <div class="agenda-item {{ $index < $upcomingAgendas->count() - 1 ? 'mb-3 pb-3 border-bottom' : '' }}">
                                    <div class="d-flex align-items-center">
                                        <div class="agenda-date me-3 text-center">
                                            <div class="fw-bold" style="color: var(--gold-color); font-size: 1.5rem;">
                                                {{ $agenda->event_date ? $agenda->event_date->format('d') : '?' }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $agenda->event_date ? $agenda->event_date->format('M') : 'TBD' }}
                                            </small>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ Str::limit($agenda->title, 30) }}</h6>
                                            <small class="text-muted">
                                                @if($agenda->event_date)
                                                    {{ $agenda->event_date->format('H:i') }} WIB
                                                @endif
                                                @if($agenda->location)
                                                    • {{ Str::limit($agenda->location, 20) }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada agenda mendatang</p>
                            </div>
                        @endif
                        <a href="{{ route('agenda.index') }}" class="btn btn-outline-info btn-enhanced mt-3">
                            <i class="fas fa-calendar-check me-2"></i>Lihat Agenda
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="sidebar-card fade-in-right">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-link me-2"></i>Quick Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('downloads.index') }}" class="btn btn-outline-secondary btn-enhanced">
                                <i class="fas fa-download me-2"></i>Download
                            </a>

                           <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary btn-enhanced">
                                <i class="fas fa-images me-2"></i>Galeri
                            </a>

                            <a href="{{ route('public.extracurriculars.index') }}" class="btn btn-outline-secondary btn-enhanced">
                                <i class="fas fa-users me-2"></i>Ekstrakurikuler
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-primary-enhanced btn-enhanced">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
// Simplified and Reliable Stats Counter Animation
(function() {
    'use strict';
    
    console.log('🚀 Initializing Home Page with Enhanced Stats Animation');
    
    // Global variables
    let animationTriggered = false;
    const totalSlides = {{ $slideshows->count() }};
    
    // 🎬 FIXED SLIDESHOW FUNCTIONALITY - Consistent 6 Second Intervals
    if (totalSlides > 1) {
        let slideIndex = 1;
        let slideInterval;
        let progressInterval;
        let isHovered = false;
        let isTransitioning = false;
        
        console.log(`🎞️ Initializing slideshow with ${totalSlides} slides`);

        function showSlideEnhanced(index) {
            if (isTransitioning) return; // Prevent overlapping transitions
            
            isTransitioning = true;
            console.log(`🔄 Switching to slide ${index}`);
            
            const slides = document.querySelectorAll('#enhanced-slideshow .slide');
            const dots = document.querySelectorAll('#enhanced-slideshow .dot');

            // Clear active states
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            // Set new active states
            if (slides[index - 1]) slides[index - 1].classList.add('active');
            if (dots[index - 1]) dots[index - 1].classList.add('active');

            // Reset and restart progress bar
            resetProgressBar();
            
            // Allow next transition after slide transition completes
            setTimeout(() => {
                isTransitioning = false;
            }, 1500); // Match CSS transition duration
        }
        
        function resetProgressBar() {
            const progressBar = document.querySelector('#enhanced-slideshow .slide-progress');
            if (progressBar) {
                // Force reset animation
                progressBar.style.animation = 'none';
                progressBar.style.transform = 'scaleX(0)';
                
                // Restart animation after a brief delay
                requestAnimationFrame(() => {
                    progressBar.style.animation = 'slideProgress 6s linear';
                });
            }
        }

        function startAutoSlideEnhanced() {
            // Clear any existing intervals
            clearInterval(slideInterval);
            clearInterval(progressInterval);
            
            console.log('▶️ Starting auto slideshow');
            
            // Start progress bar for current slide
            resetProgressBar();
            
            // Set main slideshow interval - exactly 6 seconds
            slideInterval = setInterval(function() {
                if (!isHovered && !isTransitioning) {
                    slideIndex++;
                    if (slideIndex > totalSlides) slideIndex = 1;
                    showSlideEnhanced(slideIndex);
                }
            }, 6000); // Consistent 6 second interval
        }
        
        function stopAutoSlideEnhanced() {
            console.log('⏸️ Stopping auto slideshow');
            clearInterval(slideInterval);
            clearInterval(progressInterval);
            
            // Pause progress bar
            const progressBar = document.querySelector('#enhanced-slideshow .slide-progress');
            if (progressBar) {
                progressBar.style.animationPlayState = 'paused';
            }
        }
        
        function resumeAutoSlideEnhanced() {
            console.log('▶️ Resuming auto slideshow');
            
            // Resume progress bar
            const progressBar = document.querySelector('#enhanced-slideshow .slide-progress');
            if (progressBar) {
                progressBar.style.animationPlayState = 'running';
            }
            
            // Restart the interval
            startAutoSlideEnhanced();
        }

        window.changeSlideEnhanced = function(direction) {
            if (isTransitioning) return; // Prevent rapid clicking
            
            console.log(`👆 Manual slide change: ${direction > 0 ? 'next' : 'prev'}`);
            
            stopAutoSlideEnhanced();
            
            slideIndex += direction;
            if (slideIndex > totalSlides) slideIndex = 1;
            if (slideIndex < 1) slideIndex = totalSlides;
            
            showSlideEnhanced(slideIndex);
            
            // Restart auto slideshow after manual change
            setTimeout(() => {
                if (!isHovered) {
                    startAutoSlideEnhanced();
                }
            }, 1500);
        }

        window.currentSlideEnhanced = function(index) {
            if (isTransitioning) return; // Prevent rapid clicking
            
            console.log(`🎯 Direct slide selection: ${index}`);
            
            stopAutoSlideEnhanced();
            slideIndex = index;
            showSlideEnhanced(slideIndex);
            
            // Restart auto slideshow after manual change
            setTimeout(() => {
                if (!isHovered) {
                    startAutoSlideEnhanced();
                }
            }, 1500);
        }

        // Initialize slideshow
        showSlideEnhanced(slideIndex);
        startAutoSlideEnhanced();

        // Enhanced pause/resume on hover
        const slideshowContainer = document.getElementById('enhanced-slideshow');
        if (slideshowContainer) {
            slideshowContainer.addEventListener('mouseenter', function() {
                console.log('🖱️ Mouse entered - pausing slideshow');
                isHovered = true;
                stopAutoSlideEnhanced();
            });
            
            slideshowContainer.addEventListener('mouseleave', function() {
                console.log('🖱️ Mouse left - resuming slideshow');
                isHovered = false;
                resumeAutoSlideEnhanced();
            });

            // Enhanced touch support
            let startX = 0;
            let startY = 0;
            let startTime = 0;
            
            slideshowContainer.addEventListener('touchstart', function(e) {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                startTime = Date.now();
                isHovered = true; // Treat touch as hover
                stopAutoSlideEnhanced();
            }, { passive: true });
            
            slideshowContainer.addEventListener('touchend', function(e) {
                const endX = e.changedTouches[0].clientX;
                const endY = e.changedTouches[0].clientY;
                const endTime = Date.now();
                
                const diffX = startX - endX;
                const diffY = startY - endY;
                const diffTime = endTime - startTime;
                
                // Only trigger if it's a horizontal swipe (not vertical scroll)
                if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50 && diffTime < 500) {
                    changeSlideEnhanced(diffX > 0 ? 1 : -1);
                }
                
                // Resume auto slideshow after touch
                setTimeout(() => {
                    isHovered = false;
                    if (!isTransitioning) {
                        startAutoSlideEnhanced();
                    }
                }, 2000);
            }, { passive: true });
        }

        // Keyboard navigation with debouncing
        let keyboardTimeout;
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                clearTimeout(keyboardTimeout);
                keyboardTimeout = setTimeout(() => {
                    if (e.key === 'ArrowLeft') changeSlideEnhanced(-1);
                    if (e.key === 'ArrowRight') changeSlideEnhanced(1);
                }, 100);
            }
        });
        
        // Page visibility API - pause when tab is not active
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                console.log('📱 Page hidden - pausing slideshow');
                stopAutoSlideEnhanced();
            } else {
                console.log('📱 Page visible - resuming slideshow');
                if (!isHovered) {
                    setTimeout(startAutoSlideEnhanced, 500);
                }
            }
        });
        
        // Debug functions
        window.debugSlideshow = function() {
            console.log('🔍 Slideshow Debug Info:');
            console.log('Current slide:', slideIndex);
            console.log('Total slides:', totalSlides);
            console.log('Is hovered:', isHovered);
            console.log('Is transitioning:', isTransitioning);
            console.log('Interval active:', !!slideInterval);
        };
        
        console.log('✅ Slideshow initialized successfully!');
    }
    
    // ✨ ENHANCED STATS COUNTER ANIMATION ✨
    function animateCounter(element, target, duration = 2500) {
        if (element.dataset.animated === 'true') return;
        
        element.dataset.animated = 'true';
        element.classList.add('counting');
        
        console.log(`🎯 Animating counter: ${target}`);
        
        const startTime = performance.now();
        const startValue = 0;
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Easing function (ease-out cubic)
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            const currentValue = Math.floor(startValue + (target - startValue) * easedProgress);
            
            element.textContent = currentValue;
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target;
                console.log(`✅ Counter animation completed: ${target}`);
                
                // Completion effect
                element.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                }, 300);
            }
        }
        
        requestAnimationFrame(updateCounter);
    }
    
    function triggerStatsAnimation() {
        if (animationTriggered) return;
        
        console.log('🎬 Triggering stats animation!');
        animationTriggered = true;
        
        const statsNumbers = document.querySelectorAll('.stats-number');
        
        if (statsNumbers.length === 0) {
            console.warn('⚠️ No stats numbers found!');
            return;
        }
        
        // Reset all counters
        statsNumbers.forEach(element => {
            element.textContent = '0';
            element.style.transform = 'scale(1)';
            element.classList.remove('counting');
            element.dataset.animated = 'false';
        });
        
        // Start animations with staggered delay
        statsNumbers.forEach((element, index) => {
            const target = parseInt(element.dataset.target);
            if (target && !isNaN(target)) {
                setTimeout(() => {
                    animateCounter(element, target, 2500);
                }, index * 200); // Staggered animation
            }
        });
    }
    
    // 🎯 MULTIPLE TRIGGER METHODS FOR MAXIMUM RELIABILITY
    function initStatsAnimation() {
        const statsSection = document.querySelector('.stats-section');
        const statsNumbers = document.querySelectorAll('.stats-number');
        
        if (!statsSection || statsNumbers.length === 0) {
            console.warn('⚠️ Stats elements not found, retrying...');
            setTimeout(initStatsAnimation, 500);
            return;
        }
        
        console.log(`📊 Found ${statsNumbers.length} stats counters`);
        
        // Initialize all counters to 0
        statsNumbers.forEach(element => {
            element.textContent = '0';
            element.dataset.animated = 'false';
        });
        
        // Method 1: Immediate visibility check
        function checkVisibility() {
            const rect = statsSection.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            const isVisible = rect.top < windowHeight * 0.8 && rect.bottom > 0;
            
            if (isVisible && !animationTriggered) {
                console.log('👁️ Stats section is visible, triggering animation!');
                setTimeout(triggerStatsAnimation, 200);
                return true;
            }
            return false;
        }
        
        // Check immediately
        if (checkVisibility()) return;
        
        // Method 2: Intersection Observer
        if (typeof IntersectionObserver !== 'undefined') {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !animationTriggered) {
                        console.log('🔍 Intersection Observer triggered!');
                        setTimeout(triggerStatsAnimation, 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px'
            });
            
            observer.observe(statsSection);
        }
        
        // Method 3: Scroll listener
        let scrollTimeout;
        function onScroll() {
            if (scrollTimeout) return;
            scrollTimeout = setTimeout(() => {
                if (!animationTriggered) {
                    checkVisibility();
                }
                scrollTimeout = null;
            }, 100);
        }
        
        window.addEventListener('scroll', onScroll, { passive: true });
        
        // Method 4: Click trigger for testing
        statsSection.addEventListener('click', function() {
            if (!animationTriggered) {
                console.log('🖱️ Stats section clicked, triggering animation!');
                triggerStatsAnimation();
            }
        });
        
        // Method 5: Fallback timer
        setTimeout(() => {
            if (!animationTriggered) {
                console.log('⏰ Fallback timer triggered!');
                triggerStatsAnimation();
            }
        }, 3000);
        
        // Method 6: Force trigger for mobile
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            setTimeout(() => {
                if (!animationTriggered) {
                    console.log('📱 Mobile fallback triggered!');
                    triggerStatsAnimation();
                }
            }, 2000);
        }
    }
    
    // 🎮 DEBUG FUNCTIONS (Available in console)
    window.resetStatsAnimation = function() {
        console.log('🔄 Resetting stats animation...');
        animationTriggered = false;
        const statsNumbers = document.querySelectorAll('.stats-number');
        statsNumbers.forEach(element => {
            element.textContent = '0';
            element.dataset.animated = 'false';
            element.classList.remove('counting');
            element.style.transform = 'scale(1)';
        });
        console.log('✅ Stats animation reset complete!');
    };
    
    window.forceStatsAnimation = function() {
        console.log('🚀 Force triggering stats animation...');
        animationTriggered = false;
        triggerStatsAnimation();
    };
    
    // 🎨 ENHANCED VISUAL EFFECTS
    function initVisualEffects() {
        // Enhanced hover effects for stats cards
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
                this.style.zIndex = '10';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.zIndex = '1';
            });
        });
        
        // Parallax effect for floating elements
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.floating-element');
            
            parallaxElements.forEach((element, index) => {
                const speed = 0.5 + (index * 0.2);
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });
        
        // Fade-in animations for other elements
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.feature-card, .news-card, .sidebar-card').forEach(el => {
            observer.observe(el);
        });
    }
    
    // 🚀 INITIALIZATION
    function init() {
        console.log('🎉 Home page initialization complete!');
        
        // Initialize stats animation
        initStatsAnimation();
        
        // Initialize visual effects
        initVisualEffects();
        
        // Enhanced button loading animation
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.href && !this.href.includes('#')) {
                    const originalContent = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                    setTimeout(() => {
                        this.innerHTML = originalContent;
                    }, 2000);
                }
            });
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
    }
    
    // 🎬 START EVERYTHING
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        setTimeout(init, 100);
    }
    
    // Additional safety net
    window.addEventListener('load', () => {
        setTimeout(() => {
            if (!animationTriggered) {
                console.log('🔄 Window load fallback triggered!');
                const statsSection = document.querySelector('.stats-section');
                if (statsSection) {
                    const rect = statsSection.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        triggerStatsAnimation();
                    }
                }
            }
        }, 500);
    });
    
    console.log('✨ Stats animation system ready! Use window.forceStatsAnimation() to test.');
    console.log('🎬 Slideshow debug: Use window.debugSlideshow() to check status.');
})();
</script>
@endsection