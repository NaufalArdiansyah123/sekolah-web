@extends('layouts.public')

@section('title', 'Guru & Staff - SMA Negeri 99')

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

    /* Enhanced Stats Section */
    .stats-section {
        padding: 80px 0;
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
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }
    
    .stats-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
    }
    
    .stats-card::before {
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
    
    .stats-card:hover::before {
        transform: scaleX(1);
    }

    /* Enhanced Filters Section */
    .filters-section {
        background: white;
        padding: 2rem 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 80px;
        z-index: 10;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }

    .filters-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .filter-input {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: white;
        color: var(--primary-color);
    }

    .filter-input:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        outline: none;
    }

    .btn-filter {
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(49, 130, 206, 0.4);
    }

    .btn-reset {
        background: #6b7280;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reset:hover {
        background: #4b5563;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Enhanced Organizational Chart Section */
    .org-chart-section {
        padding: 80px 0;
        background: var(--light-gray);
    }

    .section-title {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-heading {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        position: relative;
        padding-bottom: 1rem;
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

    .section-subtitle {
        font-size: 1.1rem;
        color: var(--dark-gray);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Organizational Chart Styles */
    .org-chart {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Principal Level */
    .principal-level {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    /* Vice Principal Level */
    .vice-principal-level {
        display: flex;
        justify-content: center;
        gap: 2rem;
        width: 100%;
        flex-wrap: wrap;
    }

    /* Department Heads Level */
    .department-heads-level {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        width: 100%;
        max-width: 1200px;
    }

    /* Teachers Level */
    .teachers-level {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        width: 100%;
    }

    /* Staff Level */
    .staff-level {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        width: 100%;
    }

    /* Enhanced Teacher Cards */
    .teacher-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .teacher-card::before {
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

    .teacher-card:hover::before {
        opacity: 1;
    }

    .teacher-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }

    /* Professional styling for different levels */
    .teacher-card.principal {
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        color: white;
        transform: scale(1.1);
        border: 3px solid #3b82f6;
        box-shadow: 0 20px 60px rgba(30, 58, 138, 0.3);
    }

    .teacher-card.principal:hover {
        transform: scale(1.15) translateY(-10px);
        box-shadow: 0 30px 80px rgba(30, 58, 138, 0.4);
    }

    .teacher-card.vice-principal {
        background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
        color: white;
        transform: scale(1.05);
        border: 2px solid #6b7280;
        box-shadow: 0 15px 50px rgba(55, 65, 81, 0.3);
    }

    .teacher-card.vice-principal:hover {
        transform: scale(1.08) translateY(-10px);
        box-shadow: 0 25px 70px rgba(55, 65, 81, 0.4);
    }

    .teacher-card.department-head {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
        border: 2px solid #34d399;
        box-shadow: 0 12px 40px rgba(5, 150, 105, 0.3);
    }

    .teacher-card.department-head:hover {
        transform: translateY(-12px) scale(1.03);
        box-shadow: 0 20px 60px rgba(5, 150, 105, 0.4);
    }

    .teacher-card.teacher {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        color: #1f2937;
        border: 2px solid #e5e7eb;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .teacher-card.teacher:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        border-color: #3b82f6;
    }

    .teacher-card.staff {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #374151;
        border: 1px solid #d1d5db;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
    }

    .teacher-card.staff:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        border-color: #6b7280;
    }

    .card-header {
        padding: 2rem;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .teacher-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .teacher-card:hover .teacher-photo {
        transform: scale(1.05);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
    }

    .photo-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-weight: 600;
        font-size: 2.5rem;
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
    
    /* Special placeholder styling for light cards */
    .teacher-card.teacher .photo-placeholder {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        border: 4px solid #e5e7eb;
    }
    
    .teacher-card.staff .photo-placeholder {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
        border: 4px solid #d1d5db;
    }

    .teacher-card:hover .photo-placeholder {
        transform: scale(1.05);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
    }

    .teacher-name {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .teacher-position {
        font-size: 1rem;
        margin-bottom: 1rem;
        font-weight: 600;
        transition: color 0.3s ease;
        opacity: 0.9;
    }

    .card-body {
        padding: 2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        position: relative;
        z-index: 2;
    }

    .teacher-info {
        margin-bottom: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        padding: 0.5rem;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
    }

    .info-item:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(4px);
    }
    
    /* Special info item styling for light cards */
    .teacher-card.teacher .info-item {
        background: rgba(59, 130, 246, 0.05);
    }
    
    .teacher-card.teacher .info-item:hover {
        background: rgba(59, 130, 246, 0.1);
    }
    
    .teacher-card.staff .info-item {
        background: rgba(107, 114, 128, 0.05);
    }
    
    .teacher-card.staff .info-item:hover {
        background: rgba(107, 114, 128, 0.1);
    }

    .info-icon {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        opacity: 0.8;
    }

    .subject-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .subject-tag {
        background: rgba(255, 255, 255, 0.2);
        color: inherit;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }

    .subject-tag:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
    
    /* Special subject tag styling for light cards */
    .teacher-card.teacher .subject-tag {
        background: rgba(59, 130, 246, 0.1);
        color: #1d4ed8;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .teacher-card.teacher .subject-tag:hover {
        background: rgba(59, 130, 246, 0.2);
    }
    
    .teacher-card.staff .subject-tag {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }
    
    .teacher-card.staff .subject-tag:hover {
        background: rgba(107, 114, 128, 0.2);
    }

    .card-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        margin-top: auto;
        position: relative;
        z-index: 2;
    }
    
    /* Special footer styling for light cards */
    .teacher-card.teacher .card-footer {
        border-top: 1px solid rgba(229, 231, 235, 0.5);
    }
    
    .teacher-card.staff .card-footer {
        border-top: 1px solid rgba(209, 213, 219, 0.5);
    }

    .btn-view-profile {
        width: 100%;
        background: rgba(255, 255, 255, 0.2);
        color: inherit;
        padding: 0.75rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .btn-view-profile:hover {
        background: rgba(255, 255, 255, 0.3);
        color: inherit;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }
    
    /* Special button styling for light cards */
    .teacher-card.teacher .btn-view-profile {
        background: #3b82f6;
        color: white;
        border: 1px solid #3b82f6;
    }
    
    .teacher-card.teacher .btn-view-profile:hover {
        background: #1d4ed8;
        color: white;
        border: 1px solid #1d4ed8;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
    }
    
    .teacher-card.staff .btn-view-profile {
        background: #6b7280;
        color: white;
        border: 1px solid #6b7280;
    }
    
    .teacher-card.staff .btn-view-profile:hover {
        background: #4b5563;
        color: white;
        border: 1px solid #4b5563;
        box-shadow: 0 6px 20px rgba(107, 114, 128, 0.3);
    }

    /* Level Headers */
    .level-header {
        text-align: center;
        margin-bottom: 2rem;
        width: 100%;
    }

    .level-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        position: relative;
        display: inline-block;
        padding-bottom: 0.5rem;
    }

    .level-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        border-radius: 2px;
    }

    .level-description {
        color: var(--dark-gray);
        font-size: 1rem;
        max-width: 500px;
        margin: 0 auto;
    }

    /* Enhanced Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        grid-column: 1 / -1;
        transition: all 0.3s ease;
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: var(--dark-gray);
        transition: all 0.3s ease;
    }

    .empty-state:hover .empty-icon {
        transform: scale(1.05);
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }

    .empty-description {
        color: var(--dark-gray);
        margin-bottom: 2rem;
        line-height: 1.6;
        font-size: 1.1rem;
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

        .filters-container {
            grid-template-columns: 1fr;
        }

        .org-chart {
            gap: 2rem;
        }

        .vice-principal-level {
            flex-direction: column;
            align-items: center;
        }

        .department-heads-level {
            grid-template-columns: 1fr;
        }

        .teachers-level {
            grid-template-columns: 1fr;
        }

        .staff-level {
            grid-template-columns: 1fr;
        }

        .section-heading {
            font-size: 2rem;
        }

        .teacher-card.principal,
        .teacher-card.vice-principal {
            transform: scale(1);
        }

        .teacher-card.principal:hover,
        .teacher-card.vice-principal:hover {
            transform: scale(1.02) translateY(-10px);
        }

        .level-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .hero-section h1 {
            font-size: 2rem;
        }
        
        .org-chart-section {
            padding: 60px 0;
        }
        
        .card-header,
        .card-body,
        .card-footer {
            padding: 1.5rem;
        }

        .teacher-photo,
        .photo-placeholder {
            width: 100px;
            height: 100px;
        }

        .teacher-name {
            font-size: 1.1rem;
        }

        .teacher-position {
            font-size: 0.9rem;
        }
    }

    /* Staggered animation delays */
    .fade-in-up:nth-child(1) { animation-delay: 0.1s; }
    .fade-in-up:nth-child(2) { animation-delay: 0.2s; }
    .fade-in-up:nth-child(3) { animation-delay: 0.3s; }
    .fade-in-up:nth-child(4) { animation-delay: 0.4s; }
    .fade-in-up:nth-child(5) { animation-delay: 0.5s; }
    .fade-in-up:nth-child(6) { animation-delay: 0.6s; }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Struktur Organisasi Sekolah</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">
                    Mengenal lebih dekat dengan struktur kepemimpinan dan tim pendidik 
                    yang berdedikasi dalam memberikan pendidikan terbaik untuk siswa-siswi kami.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-sitemap hero-icon scale-in" style="animation-delay: 0.4s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Quick Stats -->
<section class="stats-section">
    <div class="container">
        <div class="section-title">
            <h2 class="section-heading fade-in-up">Tim Pendidik Profesional</h2>
            <p class="section-subtitle fade-in-up" style="animation-delay: 0.2s;">
                Tenaga pendidik dan kependidikan yang berkualitas dan berpengalaman
            </p>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-primary"></i>
                        </div>
                        <h2 class="display-4 fw-bold text-primary mb-2">{{ $teachers->count() }}</h2>
                        <p class="text-muted mb-0 fw-medium">TOTAL GURU & STAFF</p>
                        <div class="stats-bar bg-primary"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-chalkboard-teacher fa-3x text-success"></i>
                        </div>
                        <h2 class="display-4 fw-bold text-success mb-2">{{ $teachers->count() }}</h2>
                        <p class="text-muted mb-0 fw-medium">GURU AKTIF</p>
                        <div class="stats-bar bg-success"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-graduation-cap fa-3x text-warning"></i>
                        </div>
                        <h2 class="display-4 fw-bold text-warning mb-2">{{ $subjects->count() }}</h2>
                        <p class="text-muted mb-0 fw-medium">MATA PELAJARAN</p>
                        <div class="stats-bar bg-warning"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.6s;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-award fa-3x text-info"></i>
                        </div>
                        <h2 class="display-4 fw-bold text-info mb-2">{{ $positions->count() }}</h2>
                        <p class="text-muted mb-0 fw-medium">POSISI JABATAN</p>
                        <div class="stats-bar bg-info"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Filters Section -->
<section class="filters-section">
    <div class="container">
        <form method="GET" action="{{ route('public.teachers.index') }}">
            <div class="filters-container">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-search me-2"></i>Pencarian
                    </label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama guru atau mata pelajaran..." 
                           class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-book me-2"></i>Mata Pelajaran
                    </label>
                    <select name="subject" class="filter-input">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ request('subject') == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-user-tie me-2"></i>Posisi Jabatan
                    </label>
                    <select name="position" class="filter-input">
                        <option value="">Semua Posisi</option>
                        @foreach($positions as $position)
                            <option value="{{ $position }}" {{ request('position') == $position ? 'selected' : '' }}>
                                {{ $position }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        <a href="{{ route('public.teachers.index') }}" class="btn-reset">
                            <i class="fas fa-undo me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Enhanced Organizational Chart Section -->
<section class="org-chart-section">
    <div class="container">
        <div class="section-title">
            <h2 class="section-heading fade-in-up">Struktur Organisasi</h2>
            <p class="section-subtitle fade-in-up" style="animation-delay: 0.2s;">
                Hierarki kepemimpinan dan struktur organisasi sekolah yang terorganisir dengan baik
            </p>
        </div>

        <div class="org-chart">
            @php
                // Group teachers by position hierarchy - Fixed filters
                $principal = $teachers->filter(function($teacher) {
                    return stripos($teacher->position, 'Kepala Sekolah') !== false;
                })->first();
                
                $vicePrincipals = $teachers->filter(function($teacher) {
                    return stripos($teacher->position, 'Wakil Kepala') !== false;
                });
                
                $departmentHeads = $teachers->filter(function($teacher) {
                    $pos = strtolower($teacher->position);
                    return (stripos($teacher->position, 'Kepala') !== false && 
                            stripos($teacher->position, 'Kepala Sekolah') === false && 
                            stripos($teacher->position, 'Wakil Kepala') === false);
                });
                
                $regularTeachers = $teachers->filter(function($teacher) {
                    return (stripos($teacher->position, 'Guru') !== false && 
                            stripos($teacher->position, 'Kepala') === false && 
                            stripos($teacher->position, 'Wakil') === false);
                });
                
                // Separate different types of teachers
                $guruSenior = $teachers->filter(function($teacher) {
                    return (stripos($teacher->position, 'Guru Senior') !== false);
                });
                
                $guruKelas = $teachers->filter(function($teacher) {
                    return (stripos($teacher->position, 'Guru Kelas') !== false);
                });
                
                $guruMataPelajaran = $teachers->filter(function($teacher) {
                    return (stripos($teacher->position, 'Guru Mata Pelajaran') !== false);
                });
                
                $guruBengkel = $teachers->filter(function($teacher) {
                    return (stripos($teacher->position, 'Guru Bengkel') !== false);
                });
                
                $guruBK = $teachers->filter(function($teacher) {
                    return (stripos($teacher->position, 'Guru BK') !== false);
                });
                
                $guruLainnya = $teachers->filter(function($teacher) {
                    return (stripos($teacher->position, 'Guru') !== false && 
                            stripos($teacher->position, 'Kepala') === false && 
                            stripos($teacher->position, 'Wakil') === false &&
                            stripos($teacher->position, 'Guru Senior') === false &&
                            stripos($teacher->position, 'Guru Kelas') === false &&
                            stripos($teacher->position, 'Guru Mata Pelajaran') === false &&
                            stripos($teacher->position, 'Guru Bengkel') === false &&
                            stripos($teacher->position, 'Guru BK') === false);
                });
                
                $staff = $teachers->filter(function($teacher) {
                    return (stripos($teacher->position, 'Kepala') === false && 
                            stripos($teacher->position, 'Guru') === false && 
                            stripos($teacher->position, 'Wakil') === false);
                });
                
                // All filters are now working correctly
            @endphp

            <!-- Principal Level -->
            @if($principal)
            <div class="principal-level fade-in-up">
                <div class="level-header">
                    <h3 class="level-title">Kepala Sekolah</h3>
                    <p class="level-description">Pemimpin tertinggi yang bertanggung jawab atas seluruh kegiatan sekolah</p>
                </div>
                <div class="teacher-card principal">
                    <div class="card-header">
                        @if($principal->photo)
                            <img src="{{ asset('storage/' . $principal->photo) }}" 
                                 alt="{{ $principal->name }}" 
                                 class="teacher-photo">
                        @else
                            <div class="photo-placeholder">
                                {{ $principal->initials }}
                            </div>
                        @endif
                        <h3 class="teacher-name">{{ $principal->name }}</h3>
                        <p class="teacher-position">{{ $principal->position }}</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="teacher-info">
                            @if($principal->education)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                    <span>{{ $principal->education }}</span>
                                </div>
                            @endif

                            @if($principal->nip)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span>NIP: {{ $principal->nip }}</span>
                                </div>
                            @endif
                            
                            @if($principal->phone)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $principal->phone }}</span>
                                </div>
                            @endif
                        </div>

                        @if($principal->subject)
                        <div class="subject-tags">
                            @foreach(explode(',', $principal->subject) as $subject)
                                <span class="subject-tag">{{ trim($subject) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('public.teachers.show', $principal->id) }}" class="btn-view-profile">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Vice Principal Level -->
            @if($vicePrincipals->count() > 0)
            <div class="vice-principal-level fade-in-up" style="animation-delay: 0.2s;">
                <div class="level-header">
                    <h3 class="level-title">Wakil Kepala Sekolah</h3>
                    <p class="level-description">Membantu kepala sekolah dalam menjalankan tugas dan tanggung jawab</p>
                </div>
                @foreach($vicePrincipals as $index => $vp)
                <div class="teacher-card vice-principal" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                    <div class="card-header">
                        @if($vp->photo)
                            <img src="{{ asset('storage/' . $vp->photo) }}" 
                                 alt="{{ $vp->name }}" 
                                 class="teacher-photo">
                        @else
                            <div class="photo-placeholder">
                                {{ $vp->initials }}
                            </div>
                        @endif
                        <h3 class="teacher-name">{{ $vp->name }}</h3>
                        <p class="teacher-position">{{ $vp->position }}</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="teacher-info">
                            @if($vp->education)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                    <span>{{ $vp->education }}</span>
                                </div>
                            @endif

                            @if($vp->nip)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span>NIP: {{ $vp->nip }}</span>
                                </div>
                            @endif
                            
                            @if($vp->phone)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $vp->phone }}</span>
                                </div>
                            @endif
                        </div>

                        @if($vp->subject)
                        <div class="subject-tags">
                            @foreach(explode(',', $vp->subject) as $subject)
                                <span class="subject-tag">{{ trim($subject) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('public.teachers.show', $vp->id) }}" class="btn-view-profile">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Department Heads Level -->
            @if($departmentHeads->count() > 0)
            <div class="department-heads-level fade-in-up" style="animation-delay: 0.4s;">
                <div class="level-header">
                    <h3 class="level-title">Kepala Bagian & Koordinator</h3>
                    <p class="level-description">Memimpin dan mengkoordinasikan berbagai bidang dan program sekolah</p>
                </div>
                @foreach($departmentHeads as $index => $head)
                <div class="teacher-card department-head" style="animation-delay: {{ 0.5 + ($index * 0.1) }}s;">
                    <div class="card-header">
                        @if($head->photo)
                            <img src="{{ asset('storage/' . $head->photo) }}" 
                                 alt="{{ $head->name }}" 
                                 class="teacher-photo">
                        @else
                            <div class="photo-placeholder">
                                {{ $head->initials }}
                            </div>
                        @endif
                        <h3 class="teacher-name">{{ $head->name }}</h3>
                        <p class="teacher-position">{{ $head->position }}</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="teacher-info">
                            @if($head->education)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                    <span>{{ $head->education }}</span>
                                </div>
                            @endif

                            @if($head->nip)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span>NIP: {{ $head->nip }}</span>
                                </div>
                            @endif
                            
                            @if($head->phone)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $head->phone }}</span>
                                </div>
                            @endif
                        </div>

                        @if($head->subject)
                        <div class="subject-tags">
                            @foreach(explode(',', $head->subject) as $subject)
                                <span class="subject-tag">{{ trim($subject) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('public.teachers.show', $head->id) }}" class="btn-view-profile">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Teachers Level -->
            @if($regularTeachers->count() > 0)
            <div class="teachers-level fade-in-up" style="animation-delay: 0.6s;">
                <div class="level-header">
                    <h3 class="level-title">Guru Mata Pelajaran</h3>
                    <p class="level-description">Tim pengajar yang berdedikasi dalam memberikan pendidikan berkualitas</p>
                </div>
                @foreach($regularTeachers as $index => $teacher)
                <div class="teacher-card teacher" style="animation-delay: {{ 0.7 + ($index * 0.05) }}s;">
                    <div class="card-header">
                        @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                 alt="{{ $teacher->name }}" 
                                 class="teacher-photo">
                        @else
                            <div class="photo-placeholder">
                                {{ $teacher->initials }}
                            </div>
                        @endif
                        <h3 class="teacher-name">{{ $teacher->name }}</h3>
                        <p class="teacher-position">{{ $teacher->position }}</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="teacher-info">
                            @if($teacher->education)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                    <span>{{ $teacher->education }}</span>
                                </div>
                            @endif

                            @if($teacher->nip)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span>NIP: {{ $teacher->nip }}</span>
                                </div>
                            @endif
                            
                            @if($teacher->phone)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $teacher->phone }}</span>
                                </div>
                            @endif
                        </div>

                        @if($teacher->subject)
                        <div class="subject-tags">
                            @foreach(explode(',', $teacher->subject) as $subject)
                                <span class="subject-tag">{{ trim($subject) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('public.teachers.show', $teacher->id) }}" class="btn-view-profile">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Guru Bengkel Level -->
            @if($guruBengkel->count() > 0)
            <div class="teachers-level fade-in-up" style="animation-delay: 0.7s;">
                <div class="level-header">
                    <h3 class="level-title">Guru Bengkel</h3>
                    <p class="level-description">Guru yang mengajar praktik dan keterampilan di bengkel</p>
                </div>
                @foreach($guruBengkel as $index => $teacher)
                <div class="teacher-card teacher" style="animation-delay: {{ 0.8 + ($index * 0.05) }}s;">
                    <div class="card-header">
                        @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                 alt="{{ $teacher->name }}" 
                                 class="teacher-photo">
                        @else
                            <div class="photo-placeholder">
                                {{ $teacher->initials }}
                            </div>
                        @endif
                        <h3 class="teacher-name">{{ $teacher->name }}</h3>
                        <p class="teacher-position">{{ $teacher->position }}</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="teacher-info">
                            @if($teacher->education)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                    <span>{{ $teacher->education }}</span>
                                </div>
                            @endif

                            @if($teacher->nip)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span>NIP: {{ $teacher->nip }}</span>
                                </div>
                            @endif
                            
                            @if($teacher->phone)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $teacher->phone }}</span>
                                </div>
                            @endif
                        </div>

                        @if($teacher->subject)
                        <div class="subject-tags">
                            @foreach(explode(',', $teacher->subject) as $subject)
                                <span class="subject-tag">{{ trim($subject) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('public.teachers.show', $teacher->id) }}" class="btn-view-profile">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Guru BK Level -->
            @if($guruBK->count() > 0)
            <div class="teachers-level fade-in-up" style="animation-delay: 0.8s;">
                <div class="level-header">
                    <h3 class="level-title">Guru Bimbingan Konseling</h3>
                    <p class="level-description">Guru yang memberikan bimbingan dan konseling kepada siswa</p>
                </div>
                @foreach($guruBK as $index => $teacher)
                <div class="teacher-card teacher" style="animation-delay: {{ 0.9 + ($index * 0.05) }}s;">
                    <div class="card-header">
                        @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                 alt="{{ $teacher->name }}" 
                                 class="teacher-photo">
                        @else
                            <div class="photo-placeholder">
                                {{ $teacher->initials }}
                            </div>
                        @endif
                        <h3 class="teacher-name">{{ $teacher->name }}</h3>
                        <p class="teacher-position">{{ $teacher->position }}</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="teacher-info">
                            @if($teacher->education)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                    <span>{{ $teacher->education }}</span>
                                </div>
                            @endif

                            @if($teacher->nip)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span>NIP: {{ $teacher->nip }}</span>
                                </div>
                            @endif
                            
                            @if($teacher->phone)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $teacher->phone }}</span>
                                </div>
                            @endif
                        </div>

                        @if($teacher->subject)
                        <div class="subject-tags">
                            @foreach(explode(',', $teacher->subject) as $subject)
                                <span class="subject-tag">{{ trim($subject) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('public.teachers.show', $teacher->id) }}" class="btn-view-profile">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Guru Lainnya Level -->
            @if($guruLainnya->count() > 0)
            <div class="teachers-level fade-in-up" style="animation-delay: 0.9s;">
                <div class="level-header">
                    <h3 class="level-title">Guru Lainnya</h3>
                    <p class="level-description">Guru dengan posisi khusus dan spesialisasi tertentu</p>
                </div>
                @foreach($guruLainnya as $index => $teacher)
                <div class="teacher-card teacher" style="animation-delay: {{ 1.0 + ($index * 0.05) }}s;">
                    <div class="card-header">
                        @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" 
                                 alt="{{ $teacher->name }}" 
                                 class="teacher-photo">
                        @else
                            <div class="photo-placeholder">
                                {{ $teacher->initials }}
                            </div>
                        @endif
                        <h3 class="teacher-name">{{ $teacher->name }}</h3>
                        <p class="teacher-position">{{ $teacher->position }}</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="teacher-info">
                            @if($teacher->education)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                    <span>{{ $teacher->education }}</span>
                                </div>
                            @endif

                            @if($teacher->nip)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span>NIP: {{ $teacher->nip }}</span>
                                </div>
                            @endif
                            
                            @if($teacher->phone)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $teacher->phone }}</span>
                                </div>
                            @endif
                        </div>

                        @if($teacher->subject)
                        <div class="subject-tags">
                            @foreach(explode(',', $teacher->subject) as $subject)
                                <span class="subject-tag">{{ trim($subject) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('public.teachers.show', $teacher->id) }}" class="btn-view-profile">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Staff Level -->
            @if($staff->count() > 0)
            <div class="staff-level fade-in-up" style="animation-delay: 0.8s;">
                <div class="level-header">
                    <h3 class="level-title">Tenaga Kependidikan</h3>
                    <p class="level-description">Tim pendukung yang membantu kelancaran operasional sekolah</p>
                </div>
                @foreach($staff as $index => $staffMember)
                <div class="teacher-card staff" style="animation-delay: {{ 0.9 + ($index * 0.05) }}s;">
                    <div class="card-header">
                        @if($staffMember->photo)
                            <img src="{{ asset('storage/' . $staffMember->photo) }}" 
                                 alt="{{ $staffMember->name }}" 
                                 class="teacher-photo">
                        @else
                            <div class="photo-placeholder">
                                {{ $staffMember->initials }}
                            </div>
                        @endif
                        <h3 class="teacher-name">{{ $staffMember->name }}</h3>
                        <p class="teacher-position">{{ $staffMember->position }}</p>
                    </div>
                    
                    <div class="card-body">
                        <div class="teacher-info">
                            @if($staffMember->education)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    </svg>
                                    <span>{{ $staffMember->education }}</span>
                                </div>
                            @endif

                            @if($staffMember->nip)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span>NIP: {{ $staffMember->nip }}</span>
                                </div>
                            @endif
                            
                            @if($staffMember->phone)
                                <div class="info-item">
                                    <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $staffMember->phone }}</span>
                                </div>
                            @endif
                        </div>

                        @if($staffMember->subject)
                        <div class="subject-tags">
                            @foreach(explode(',', $staffMember->subject) as $subject)
                                <span class="subject-tag">{{ trim($subject) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('public.teachers.show', $staffMember->id) }}" class="btn-view-profile">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Empty State -->
            @if($teachers->count() == 0)
            <div class="empty-state fade-in-up">
                <div class="empty-icon">
                    <i class="fas fa-user-friends fa-3x"></i>
                </div>
                <h3 class="empty-title">Tidak Ada Data Guru</h3>
                <p class="empty-description">
                    @if(request()->hasAny(['search', 'subject', 'position']))
                        Tidak ada guru yang sesuai dengan kriteria pencarian Anda. Silakan coba dengan kata kunci yang berbeda.
                    @else
                        Saat ini belum ada data guru yang tersedia.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'subject', 'position']))
                    <a href="{{ route('public.teachers.index') }}" class="btn-reset">
                        <i class="fas fa-undo me-2"></i>Hapus Filter
                    </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    const teacherCards = document.querySelectorAll('.teacher-card');
    teacherCards.forEach((card, index) => {
        card.addEventListener('mouseenter', function() {
            if (this.classList.contains('principal')) {
                this.style.transform = 'scale(1.15) translateY(-15px)';
            } else if (this.classList.contains('vice-principal')) {
                this.style.transform = 'scale(1.08) translateY(-15px)';
            } else if (this.classList.contains('department-head')) {
                this.style.transform = 'translateY(-15px) scale(1.05)';
            } else {
                this.style.transform = 'translateY(-15px) scale(1.03)';
            }
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            if (this.classList.contains('principal')) {
                this.style.transform = 'scale(1.1)';
            } else if (this.classList.contains('vice-principal')) {
                this.style.transform = 'scale(1.05)';
            } else {
                this.style.transform = 'translateY(0) scale(1)';
            }
            this.style.zIndex = '1';
        });
    });

    // Enhanced filter form interactions
    const filterInputs = document.querySelectorAll('.filter-input');
    filterInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.boxShadow = '0 0 0 3px rgba(49, 130, 206, 0.1)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
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

    // Add loading animation to buttons
    document.querySelectorAll('.btn-view-profile').forEach(btn => {
        btn.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat...';
            this.style.pointerEvents = 'none';
            
            setTimeout(() => {
                this.innerHTML = originalText;
                this.style.pointerEvents = 'auto';
            }, 1000);
        });
    });

    // Parallax effect for hero section
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero-section');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
        ticking = false;
    }
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    });

    // Enhanced stats animation
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.btn-filter, .btn-reset, .btn-view-profile').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
                z-index: 10;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                if (ripple.parentNode) {
                    ripple.remove();
                }
            }, 600);
        });
    });

    // Add ripple animation style
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(3);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    console.log('Enhanced organizational chart loaded successfully!');
});
</script>
@endsection