@extends('layouts.public')

@section('title', 'Academic Programs')

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
    
    /* Enhanced Hero Section matching profile page */
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        );
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
    
    /* Enhanced Stats Section matching profile page */
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
        transition: all 0.3s ease;
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

    /* Enhanced Cards matching profile page style */
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
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.1);
        font-weight: 600;
        padding: 20px;
    }
    
    .card-body {
        padding: 25px;
    }

    /* Enhanced Search Section */
    .search-section {
        background: white;
        padding: 80px 0;
        box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.05);
        position: relative;
        z-index: 10;
    }

    .search-container {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
    }

    .search-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .search-subtitle {
        font-size: 1.125rem;
        color: var(--dark-gray);
        margin-bottom: 3rem;
        opacity: 0.8;
    }

    .search-form {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: end;
    }

    .search-group {
        flex: 1;
        min-width: 200px;
        text-align: left;
    }

    .search-label {
        display: block;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .search-input {
        width: 100%;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--secondary-color);
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        transform: translateY(-2px);
    }

    .search-button {
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
        min-width: 150px;
    }

    .search-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
    }

    /* Enhanced Program Cards */
    .programs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .program-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .program-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    .program-card.featured {
        border: 3px solid #ffc107;
        position: relative;
    }

    .program-card.featured::after {
        content: '⭐ Featured Program';
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ffc107, #f59e0b);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        z-index: 2;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .program-image {
        height: 200px;
        background: var(--gradient-primary);
        position: relative;
        overflow: hidden;
    }

    .program-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .program-card:hover .program-image img {
        transform: scale(1.1);
    }

    .program-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: white;
        font-size: 3rem;
        background: var(--gradient-primary);
    }

    .program-content {
        padding: 2rem;
    }

    .program-badges {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .program-badge {
        padding: 0.375rem 0.875rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid;
    }

    .badge-d3 { 
        background: rgba(139, 92, 246, 0.15); 
        color: #7c3aed; 
        border-color: rgba(139, 92, 246, 0.3); 
    }
    .badge-s1 { 
        background: rgba(59, 130, 246, 0.15); 
        color: #2563eb; 
        border-color: rgba(59, 130, 246, 0.3); 
    }
    .badge-s2 { 
        background: rgba(16, 185, 129, 0.15); 
        color: #059669; 
        border-color: rgba(16, 185, 129, 0.3); 
    }
    .badge-s3 { 
        background: rgba(245, 158, 11, 0.15); 
        color: #d97706; 
        border-color: rgba(245, 158, 11, 0.3); 
    }

    .accreditation-badge {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border-color: rgba(16, 185, 129, 0.3);
    }

    .program-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .program-code {
        font-size: 0.875rem;
        color: var(--dark-gray);
        margin-bottom: 1rem;
        font-weight: 600;
        opacity: 0.7;
    }

    .program-description {
        color: var(--dark-gray);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        opacity: 0.8;
    }

    .program-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .program-detail {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: var(--light-gray);
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .program-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .program-detail-icon {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--secondary-color);
        flex-shrink: 0;
    }

    .program-detail-text {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary-color);
    }

    /* Enhanced Footer */
    .program-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.5rem;
        border-top: 2px solid #e2e8f0;
        margin-top: auto;
    }

    .program-faculty {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--dark-gray);
        font-weight: 600;
    }

    .program-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
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

    .program-link {
        background: var(--gradient-primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .program-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        color: white;
        text-decoration: none;
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
    }

    .download-btn {
        background: white;
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
        padding: 0.75rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
    }

    .download-btn:hover {
        background: var(--secondary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }

    /* Results Info */
    .results-info {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0,0,0,0.05);
        text-align: center;
    }

    .results-count {
        font-size: 2rem;
        font-weight: 900;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .results-text {
        color: var(--dark-gray);
        font-size: 1.125rem;
        opacity: 0.8;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        color: var(--dark-gray);
    }

    .empty-icon {
        width: 5rem;
        height: 5rem;
        background: var(--light-gray);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: var(--secondary-color);
        border: 2px solid #e2e8f0;
        font-size: 2rem;
    }

    .empty-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .empty-message {
        font-size: 1.125rem;
        margin-bottom: 2rem;
        line-height: 1.6;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        opacity: 0.8;
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
        
        .stats-number {
            font-size: 2.5rem !important;
        }
        
        .stats-label {
            font-size: 0.75rem;
        }
        
        .stats-card .card-body {
            padding: 2rem 1rem;
        }

        .search-form {
            flex-direction: column;
            align-items: stretch;
        }

        .search-group {
            min-width: auto;
        }

        .programs-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .program-details {
            grid-template-columns: 1fr;
        }

        .program-footer {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .program-actions {
            justify-content: center;
        }
    }
    
    @media (max-width: 576px) {
        .stats-number {
            font-size: 2rem !important;
        }
        
        .hero-section h1 {
            font-size: 2rem;
        }

        .program-content {
            padding: 1.5rem;
        }
    }

    /* Counter Animation Keyframes */
    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stats-number.counting {
        animation: countUp 0.6s ease-out;
    }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Academic Programs</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">
                    Discover our comprehensive range of academic programs designed to prepare you for success in your chosen field. 
                    From diploma to doctoral degrees, we offer world-class education across multiple disciplines.
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-graduation-cap hero-icon scale-in" style="animation-delay: 0.4s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Quick Stats with Counting Animation -->
<section class="stats-section">
    <div class="container">
        <div class="section-title">
            <h2 class="section-heading fade-in-up">Program Statistics</h2>
            <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">Comprehensive academic offerings for your educational journey</p>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-graduation-cap fa-3x text-primary stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-primary mb-2" data-target="{{ $totalPrograms ?? 25 }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">TOTAL PROGRAMS</p>
                        <div class="stats-bar bg-primary"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-star fa-3x text-warning stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-warning mb-2" data-target="{{ $featuredPrograms ?? 8 }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">FEATURED PROGRAMS</p>
                        <div class="stats-bar bg-warning"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-users fa-3x text-success stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-success mb-2" data-target="{{ $activePrograms ?? 20 }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">ACTIVE PROGRAMS</p>
                        <div class="stats-bar bg-success"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.6s;">
                    <div class="card-body p-4">
                        <div class="stats-icon-wrapper mb-3">
                            <i class="fas fa-award fa-3x text-info stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-info mb-2" data-target="{{ $degreeTypes ?? 4 }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">DEGREE TYPES</p>
                        <div class="stats-bar bg-info"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Search Section -->
<section class="search-section">
    <div class="container">
        <div class="search-container">
            <h2 class="search-title fade-in-up">Find Your Perfect Program</h2>
            <p class="search-subtitle fade-in-up" style="animation-delay: 0.2s;">
                Use our advanced search to discover programs that match your interests, career goals, and academic background.
            </p>
            
            <form method="GET" action="{{ route('study-programs.index') }}" class="search-form fade-in-up" style="animation-delay: 0.4s;">
                <div class="search-group">
                    <label class="search-label">
                        <i class="fas fa-search me-2"></i>Search Programs
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Enter program name, field of study, or keywords..." 
                           class="search-input">
                </div>
                
                <div class="search-group">
                    <label class="search-label">
                        <i class="fas fa-graduation-cap me-2"></i>Degree Level
                    </label>
                    <select name="degree" class="search-input">
                        <option value="">All Degree Levels</option>
                        <option value="D3" {{ request('degree') == 'D3' ? 'selected' : '' }}>D3 - Diploma Program</option>
                        <option value="S1" {{ request('degree') == 'S1' ? 'selected' : '' }}>S1 - Bachelor's Degree</option>
                        <option value="S2" {{ request('degree') == 'S2' ? 'selected' : '' }}>S2 - Master's Degree</option>
                        <option value="S3" {{ request('degree') == 'S3' ? 'selected' : '' }}>S3 - Doctoral Degree</option>
                    </select>
                </div>
                
                <div class="search-group">
                    <label class="search-label">
                        <i class="fas fa-building me-2"></i>Faculty
                    </label>
                    <select name="faculty" class="search-input">
                        <option value="">All Faculties</option>
                        @if(isset($faculties))
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty }}" {{ request('faculty') == $faculty ? 'selected' : '' }}>
                                    {{ $faculty }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="search-group">
                    <button type="submit" class="search-button">
                        <i class="fas fa-search me-2"></i>
                        Search Programs
                    </button>
                </div>
            </form>
            
            @if(request()->hasAny(['search', 'degree', 'faculty']))
                <div class="mt-3 text-center fade-in-up" style="animation-delay: 0.6s;">
                    <a href="{{ route('study-programs.index') }}" class="btn btn-outline-secondary btn-enhanced">
                        <i class="fas fa-times me-2"></i>Clear All Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Programs Section -->
<section class="py-5 bg-light">
    <div class="container">
        @if(isset($programs) && $programs->count() > 0)
            <!-- Results Info -->
            @if(request()->hasAny(['search', 'degree', 'faculty']))
                <div class="results-info fade-in-up">
                    <div class="results-count">{{ $programs->total() }}</div>
                    <div class="results-text">
                        program(s) found matching your search criteria
                    </div>
                </div>
            @endif

            <!-- Featured Programs -->
            @if(isset($featuredPrograms) && $featuredPrograms > 0 && !request()->hasAny(['search', 'degree', 'faculty']))
                <div class="mb-5">
                    <h2 class="section-heading fade-in-up">
                        <i class="fas fa-star text-warning me-3"></i>Featured Programs
                    </h2>
                    <p class="text-muted text-center fade-in-up" style="animation-delay: 0.2s;">
                        Our most popular and highly-rated academic programs, chosen for their excellence in education and career outcomes.
                    </p>
                    
                    <div class="programs-grid">
                        @foreach($programs->where('is_featured', true) as $program)
                            <div class="program-card featured fade-in-up" style="animation-delay: {{ $loop->index * 0.2 }}s;">
                                <!-- Program Image -->
                                <div class="program-image">
                                    @if($program->program_image)
                                        <img src="{{ asset($program->program_image) }}" alt="{{ $program->program_name }}">
                                    @else
                                        <div class="program-image-placeholder">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Program Content -->
                                <div class="program-content">
                                    <!-- Badges -->
                                    <div class="program-badges">
                                        @if($program->degree_level)
                                            <span class="program-badge badge-{{ strtolower($program->degree_level) }}">
                                                {{ $program->degree_level }}
                                            </span>
                                        @endif
                                        @if($program->accreditation)
                                            <span class="program-badge accreditation-badge">
                                                Accredited {{ $program->accreditation }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Title and Code -->
                                    <h3 class="program-title">{{ $program->program_name }}</h3>
                                    @if($program->program_code)
                                        <div class="program-code">Program Code: {{ $program->program_code }}</div>
                                    @endif

                                    <!-- Description -->
                                    @if($program->description)
                                        <p class="program-description">{{ Str::limit($program->description, 150) }}</p>
                                    @endif

                                    <!-- Program Details -->
                                    <div class="program-details">
                                        @if($program->duration_years)
                                            <div class="program-detail">
                                                <i class="fas fa-clock program-detail-icon"></i>
                                                <span class="program-detail-text">{{ $program->duration_years }} {{ $program->duration_years == 1 ? 'Year' : 'Years' }}</span>
                                            </div>
                                        @endif

                                        @if($program->total_credits)
                                            <div class="program-detail">
                                                <i class="fas fa-certificate program-detail-icon"></i>
                                                <span class="program-detail-text">{{ $program->total_credits }} Credits</span>
                                            </div>
                                        @endif

                                        @if($program->capacity)
                                            <div class="program-detail">
                                                <i class="fas fa-users program-detail-icon"></i>
                                                <span class="program-detail-text">{{ number_format($program->capacity) }} Students</span>
                                            </div>
                                        @endif

                                        @if($program->tuition_fee)
                                            <div class="program-detail">
                                                <i class="fas fa-money-bill-wave program-detail-icon"></i>
                                                <span class="program-detail-text">Rp {{ number_format($program->tuition_fee) }}/semester</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Footer -->
                                    <div class="program-footer">
                                        @if($program->faculty)
                                            <div class="program-faculty">
                                                <i class="fas fa-university"></i>
                                                <span>{{ $program->faculty }}</span>
                                            </div>
                                        @else
                                            <div></div>
                                        @endif
                                        
                                        <div class="program-actions">
                                            <a href="{{ route('study-programs.show', $program) }}" class="program-link">
                                                <i class="fas fa-info-circle"></i>
                                                <span>Learn More</span>
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                            
                                            @if($program->brochure_file)
                                                <a href="{{ asset($program->brochure_file) }}" target="_blank" class="download-btn" title="Download Brochure">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- All Programs -->
            <div class="mb-5">
                <h2 class="section-heading fade-in-up">
                    @if(request()->hasAny(['search', 'degree', 'faculty']))
                        Search Results
                    @else
                        All Academic Programs
                    @endif
                </h2>
                <p class="text-muted text-center fade-in-up" style="animation-delay: 0.2s;">
                    @if(request()->hasAny(['search', 'degree', 'faculty']))
                        Programs matching your search criteria and preferences
                    @else
                        Explore our comprehensive range of academic programs designed to prepare you for success in your chosen field
                    @endif
                </p>
            </div>

            <div class="programs-grid">
                @foreach($programs as $program)
                    @if(!$program->is_featured || request()->hasAny(['search', 'degree', 'faculty']))
                        <div class="program-card fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                            <!-- Program Image -->
                            <div class="program-image">
                                @if($program->program_image)
                                    <img src="{{ asset($program->program_image) }}" alt="{{ $program->program_name }}">
                                @else
                                    <div class="program-image-placeholder">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Program Content -->
                            <div class="program-content">
                                <!-- Badges -->
                                <div class="program-badges">
                                    @if($program->degree_level)
                                        <span class="program-badge badge-{{ strtolower($program->degree_level) }}">
                                            {{ $program->degree_level }}
                                        </span>
                                    @endif
                                    @if($program->accreditation)
                                        <span class="program-badge accreditation-badge">
                                            Accredited {{ $program->accreditation }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Title and Code -->
                                <h3 class="program-title">{{ $program->program_name }}</h3>
                                @if($program->program_code)
                                    <div class="program-code">Program Code: {{ $program->program_code }}</div>
                                @endif

                                <!-- Description -->
                                @if($program->description)
                                    <p class="program-description">{{ Str::limit($program->description, 150) }}</p>
                                @endif

                                <!-- Program Details -->
                                <div class="program-details">
                                    @if($program->duration_years)
                                        <div class="program-detail">
                                            <i class="fas fa-clock program-detail-icon"></i>
                                            <span class="program-detail-text">{{ $program->duration_years }} {{ $program->duration_years == 1 ? 'Year' : 'Years' }}</span>
                                        </div>
                                    @endif

                                    @if($program->total_credits)
                                        <div class="program-detail">
                                            <i class="fas fa-certificate program-detail-icon"></i>
                                            <span class="program-detail-text">{{ $program->total_credits }} Credits</span>
                                        </div>
                                    @endif

                                    @if($program->capacity)
                                        <div class="program-detail">
                                            <i class="fas fa-users program-detail-icon"></i>
                                            <span class="program-detail-text">{{ number_format($program->capacity) }} Students</span>
                                        </div>
                                    @endif

                                    @if($program->tuition_fee)
                                        <div class="program-detail">
                                            <i class="fas fa-money-bill-wave program-detail-icon"></i>
                                            <span class="program-detail-text">Rp {{ number_format($program->tuition_fee) }}/semester</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Footer -->
                                <div class="program-footer">
                                    @if($program->faculty)
                                        <div class="program-faculty">
                                            <i class="fas fa-university"></i>
                                            <span>{{ $program->faculty }}</span>
                                        </div>
                                    @else
                                        <div></div>
                                    @endif
                                    
                                    <div class="program-actions">
                                        <a href="{{ route('study-programs.show', $program) }}" class="program-link">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Learn More</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                        
                                        @if($program->brochure_file)
                                            <a href="{{ asset($program->brochure_file) }}" target="_blank" class="download-btn" title="Download Brochure">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            @if($programs->hasPages())
                <div class="d-flex justify-content-center mt-5 fade-in-up">
                    {{ $programs->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Enhanced Empty State -->
            <div class="empty-state fade-in-up">
                <div class="empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="empty-title">No Programs Found</h3>
                <p class="empty-message">
                    @if(request()->hasAny(['search', 'degree', 'faculty']))
                        We couldn't find any programs matching your search criteria. Try adjusting your filters or search terms to discover more programs that might interest you.
                    @else
                        There are currently no active study programs available. Please check back later for updates on our academic offerings.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'degree', 'faculty']))
                    <a href="{{ route('study-programs.index') }}" class="btn btn-primary-enhanced btn-enhanced">
                        <i class="fas fa-eye me-2"></i>View All Programs
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Counter Animation Function (matching profile page)
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        element.classList.add('counting');
        
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
    
    // Stats counter animation with intersection observer
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
    
    // Enhanced search form animation
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            const submitButton = this.querySelector('.search-button');
            if (submitButton) {
                const originalContent = submitButton.innerHTML;
                submitButton.innerHTML = `
                    <div class="spinner-border spinner-border-sm me-2" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Searching...
                `;
                submitButton.disabled = true;
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitButton.innerHTML = originalContent;
                    submitButton.disabled = false;
                }, 5000);
            }
        });
    }

    // Enhanced card hover effects
    const programCards = document.querySelectorAll('.program-card');
    programCards.forEach((card, index) => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (!href || href === '#' || href.length <= 1) {
                return;
            }
            
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Auto-focus search input
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput && !searchInput.value) {
        setTimeout(() => {
            searchInput.focus();
        }, 1000);
    }

    // Enhanced keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.matches('.search-input')) {
            e.target.closest('form').submit();
        }
        
        // ESC to clear search
        if (e.key === 'Escape' && e.target.matches('.search-input')) {
            e.target.value = '';
        }
    });

    // Add loading animation to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.href && !this.href.includes('#')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 3000);
            }
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
    
    // Page load animation sequence
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 100);
    
    console.log('Enhanced academic programs page animations loaded successfully!');
});
</script>
@endsection