@extends('layouts.public')

@section('title', $studyProgram->program_name . ' - Program Detail')

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
    
    /* Enhanced Hero Section matching programs.blade.php */
    .hero-detail-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        );
        color: white;
        padding: 80px 0 60px;
        min-height: 60vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero-detail-section::before {
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
    
    .hero-detail-section .container {
        position: relative;
        z-index: 2;
    }
    
    .breadcrumb-custom {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 12px 20px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .breadcrumb-custom a {
        color: white;
        text-decoration: none;
        opacity: 0.8;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .breadcrumb-custom a:hover {
        opacity: 1;
        transform: translateX(-2px);
    }
    
    .breadcrumb-custom span {
        opacity: 0.5;
    }
    
    .hero-detail-title {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.5);
    }
    
    .hero-detail-badges {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .hero-badge {
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .hero-meta {
        display: flex;
        gap: 30px;
        margin-top: 30px;
        flex-wrap: wrap;
    }
    
    .hero-meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1rem;
    }
    
    .hero-meta-item i {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Animation Styles matching programs.blade.php */
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
    
    .fade-in-up.animate,
    .fade-in-left.animate,
    .fade-in-right.animate {
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

    /* Content Section */
    .content-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    }

    /* Enhanced Cards matching programs.blade.php */
    .detail-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .detail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    .card-title-custom {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .card-icon {
        width: 50px;
        height: 50px;
        background: var(--gradient-primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* Program Image matching programs.blade.php style */
    .program-detail-image {
        width: 100%;
        height: 400px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        margin-bottom: 30px;
        position: relative;
    }
    
    .program-detail-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .program-detail-image:hover img {
        transform: scale(1.05);
    }
    
    .program-detail-image-placeholder {
        width: 100%;
        height: 100%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 5rem;
    }

    /* Info Grid matching programs.blade.php */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .info-item {
        background: var(--light-gray);
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .info-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 0;
        background: var(--secondary-color);
        transition: height 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        background: white;
    }
    
    .info-item:hover::before {
        height: 100%;
    }
    
    .info-label {
        font-size: 0.875rem;
        color: var(--dark-gray);
        margin-bottom: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.7;
    }
    
    .info-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .info-value i {
        color: var(--secondary-color);
        font-size: 1.5rem;
    }

    /* Description */
    .description-content {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--dark-gray);
        margin-bottom: 20px;
    }
    
    .description-content p {
        margin-bottom: 15px;
    }

    /* List Styles matching programs.blade.php */
    .custom-list {
        list-style: none;
        padding: 0;
    }
    
    .custom-list li {
        padding: 15px 20px;
        margin-bottom: 10px;
        background: var(--light-gray);
        border-radius: 12px;
        border-left: 4px solid var(--secondary-color);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .custom-list li:hover {
        background: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
    }
    
    .custom-list li i {
        color: var(--secondary-color);
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    /* Action Buttons matching programs.blade.php */
    .btn-enhanced {
        border-radius: 12px;
        font-weight: 600;
        padding: 15px 30px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 0.875rem;
        border: none;
    }
    
    .btn-enhanced:hover {
        transform: translateY(-2px);
    }
    
    .btn-primary-enhanced {
        background: var(--gradient-primary);
        border: none;
        color: white;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }
    
    .btn-primary-enhanced:hover {
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
        color: white;
    }
    
    .btn-outline-enhanced {
        background: white;
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
    }
    
    .btn-outline-enhanced:hover {
        background: var(--secondary-color);
        color: white;
        border-color: var(--secondary-color);
    }
    
    .btn-success-enhanced {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        color: white;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }
    
    .btn-success-enhanced:hover {
        box-shadow: 0 12px 35px rgba(16, 185, 129, 0.4);
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
    }

    /* Sticky Sidebar */
    .sticky-sidebar {
        position: sticky;
        top: 100px;
    }

    /* Stats Mini Cards matching programs.blade.php */
    .stats-mini-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }
    
    .stats-mini-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .stats-mini-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .stats-mini-card:hover::before {
        transform: scaleX(1);
    }
    
    .stats-mini-icon {
        width: 60px;
        height: 60px;
        background: var(--gradient-primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin: 0 auto 15px;
        position: relative;
        overflow: hidden;
    }
    
    .stats-mini-icon::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease;
    }
    
    .stats-mini-card:hover .stats-mini-icon::before {
        width: 100%;
        height: 100%;
    }
    
    .stats-mini-value {
        font-size: 2rem;
        font-weight: 900;
        color: var(--primary-color);
        margin-bottom: 5px;
    }
    
    .stats-mini-label {
        font-size: 0.875rem;
        color: var(--dark-gray);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Related Programs matching programs.blade.php */
    .related-program-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    
    .related-program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .related-program-image {
        height: 150px;
        background: var(--gradient-primary);
        position: relative;
        overflow: hidden;
    }
    
    .related-program-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .related-program-card:hover .related-program-image img {
        transform: scale(1.1);
    }
    
    .related-program-content {
        padding: 20px;
    }
    
    .related-program-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 10px;
        line-height: 1.3;
    }
    
    .related-program-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    /* Subject Items */
    .subject-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(5, 150, 105, 0.02));
        border: 1px solid rgba(16, 185, 129, 0.1);
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .subject-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
        border-color: rgba(16, 185, 129, 0.2);
    }
    
    .subject-number {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.125rem;
        flex-shrink: 0;
    }
    
    .subject-content {
        flex: 1;
    }
    
    .subject-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--primary-color);
        margin: 0;
        line-height: 1.3;
    }

    /* Vision & Mission Cards */
    .vision-mission-card {
        background: linear-gradient(135deg, rgba(49, 130, 206, 0.05), rgba(66, 153, 225, 0.02));
        border: 1px solid rgba(49, 130, 206, 0.1);
        border-radius: 12px;
        padding: 25px;
        height: 100%;
        transition: all 0.3s ease;
    }
    
    .vision-mission-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.15);
        border-color: rgba(49, 130, 206, 0.2);
    }
    
    .vm-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .vm-content {
        font-size: 1rem;
        line-height: 1.6;
        color: var(--dark-gray);
        margin: 0;
    }

    /* Specializations Grid */
    .specializations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .specialization-card {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.05), rgba(245, 158, 11, 0.02));
        border: 1px solid rgba(251, 191, 36, 0.1);
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .specialization-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(251, 191, 36, 0.15);
        border-color: rgba(251, 191, 36, 0.2);
    }
    
    .specialization-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin: 0 auto 15px;
    }
    
    .specialization-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--primary-color);
        margin: 0;
        line-height: 1.3;
    }

    /* Facilities List */
    .facilities-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
    }
    
    .facility-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 20px;
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.05), rgba(21, 128, 61, 0.02));
        border: 1px solid rgba(34, 197, 94, 0.1);
        border-radius: 10px;
        transition: all 0.3s ease;
        font-size: 1rem;
        font-weight: 500;
        color: var(--primary-color);
    }
    
    .facility-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.1);
        border-color: rgba(34, 197, 94, 0.2);
    }
    
    .facility-item i {
        font-size: 1.25rem;
        color: #10b981;
        flex-shrink: 0;
    }

    /* Section Heading matching programs.blade.php */
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

    /* Badge Styles matching programs.blade.php */
    .badge-d3 { 
        background: rgba(139, 92, 246, 0.15); 
        color: #7c3aed; 
        border: 1px solid rgba(139, 92, 246, 0.3); 
    }
    .badge-s1 { 
        background: rgba(59, 130, 246, 0.15); 
        color: #2563eb; 
        border: 1px solid rgba(59, 130, 246, 0.3); 
    }
    .badge-s2 { 
        background: rgba(16, 185, 129, 0.15); 
        color: #059669; 
        border: 1px solid rgba(16, 185, 129, 0.3); 
    }
    .badge-s3 { 
        background: rgba(245, 158, 11, 0.15); 
        color: #d97706; 
        border: 1px solid rgba(245, 158, 11, 0.3); 
    }

    /* Back to Top Button */
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--gradient-primary);
        color: white;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.4);
        z-index: 1000;
        transition: all 0.3s ease;
        border: none;
    }
    
    .back-to-top:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.5);
    }
    
    .back-to-top.show {
        display: flex;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-detail-title {
            font-size: 2rem;
        }
        
        .hero-meta {
            flex-direction: column;
            gap: 15px;
        }
        
        .program-detail-image {
            height: 250px;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .sticky-sidebar {
            position: relative;
            top: 0;
        }
        
        .specializations-grid {
            grid-template-columns: 1fr;
        }
        
        .facilities-list {
            grid-template-columns: 1fr;
        }
        
        .subject-item {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        .vision-mission-card {
            margin-bottom: 20px;
        }
        
        .card-title-custom {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero-detail-title {
            font-size: 1.75rem;
        }
        
        .detail-card {
            padding: 20px;
        }
        
        .btn-enhanced {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Hero Detail Section -->
<section class="hero-detail-section">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-custom fade-in-up">
            <a href="{{ route('home') }}">
                <i class="fas fa-home"></i> Home
            </a>
            <span>/</span>
            <a href="{{ route('study-programs.index') }}">Programs</a>
            <span>/</span>
            <span>{{ $studyProgram->program_name }}</span>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-12">
                <!-- Badges -->
                <div class="hero-detail-badges fade-in-left">
                    @if($studyProgram->degree_level)
                        <span class="hero-badge">
                            <i class="fas fa-graduation-cap"></i>{{ $studyProgram->degree_level }}
                        </span>
                    @endif
                    @if($studyProgram->accreditation)
                        <span class="hero-badge">
                            <i class="fas fa-certificate"></i>Accredited {{ $studyProgram->accreditation }}
                        </span>
                    @endif
                    @if($studyProgram->is_featured)
                        <span class="hero-badge" style="background: rgba(255, 193, 7, 0.3);">
                            <i class="fas fa-star"></i>Featured Program
                        </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="hero-detail-title fade-in-left" style="animation-delay: 0.2s;">
                    {{ $studyProgram->program_name }}
                </h1>

                <!-- Meta Information -->
                <div class="hero-meta fade-in-left" style="animation-delay: 0.4s;">
                    @if($studyProgram->faculty)
                        <div class="hero-meta-item">
                            <i class="fas fa-university"></i>
                            <span>{{ $studyProgram->faculty }}</span>
                        </div>
                    @endif
                    
                    @if($studyProgram->program_code)
                        <div class="hero-meta-item">
                            <i class="fas fa-code"></i>
                            <span>{{ $studyProgram->program_code }}</span>
                        </div>
                    @endif
                    
                    @if($studyProgram->duration_years)
                        <div class="hero-meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ $studyProgram->duration_years }} {{ $studyProgram->duration_years == 1 ? 'Year' : 'Years' }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="content-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Program Image -->
                <div class="program-detail-image fade-in-up">
                    @if($studyProgram->program_image)
                        <img src="{{ asset($studyProgram->program_image) }}" alt="{{ $studyProgram->program_name }}">
                    @else
                        <div class="program-detail-image-placeholder">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    @endif
                </div>

                <!-- Program Overview -->
                <div class="detail-card fade-in-up" style="animation-delay: 0.2s;">
                    <h2 class="card-title-custom">
                        <span class="card-icon">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        Program Overview
                    </h2>
                    
                    @if($studyProgram->description)
                        <div class="description-content">
                            {!! nl2br(e($studyProgram->description)) !!}
                        </div>
                    @else
                        <p class="text-muted">Program description will be available soon.</p>
                    @endif
                    
                    <!-- Vision & Mission -->
                    @if($studyProgram->vision || $studyProgram->mission)
                        <div class="row mt-4">
                            @if($studyProgram->vision)
                                <div class="col-md-6">
                                    <div class="vision-mission-card">
                                        <h4 class="vm-title">
                                            <i class="fas fa-eye text-primary"></i>Vision
                                        </h4>
                                        <p class="vm-content">{{ $studyProgram->vision }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($studyProgram->mission)
                                <div class="col-md-6">
                                    <div class="vision-mission-card">
                                        <h4 class="vm-title">
                                            <i class="fas fa-bullseye text-success"></i>Mission
                                        </h4>
                                        <p class="vm-content">{{ $studyProgram->mission }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Key Information -->
                <div class="detail-card fade-in-up" style="animation-delay: 0.4s;">
                    <h2 class="card-title-custom">
                        <span class="card-icon">
                            <i class="fas fa-chart-line"></i>
                        </span>
                        Key Information
                    </h2>
                    
                    <div class="info-grid">
                        @if($studyProgram->duration_years)
                            <div class="info-item">
                                <div class="info-label">Duration</div>
                                <div class="info-value">
                                    <i class="fas fa-clock"></i>
                                    {{ $studyProgram->duration_years }} {{ $studyProgram->duration_years == 1 ? 'Year' : 'Years' }}
                                </div>
                            </div>
                        @endif

                        @if($studyProgram->total_credits)
                            <div class="info-item">
                                <div class="info-label">Total Credits</div>
                                <div class="info-value">
                                    <i class="fas fa-certificate"></i>
                                    {{ $studyProgram->total_credits }} SKS
                                </div>
                            </div>
                        @endif

                        @if($studyProgram->capacity)
                            <div class="info-item">
                                <div class="info-label">Capacity</div>
                                <div class="info-value">
                                    <i class="fas fa-users"></i>
                                    {{ number_format($studyProgram->capacity) }} Students
                                </div>
                            </div>
                        @endif

                        @if($studyProgram->tuition_fee)
                            <div class="info-item">
                                <div class="info-label">Tuition Fee</div>
                                <div class="info-value">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Rp {{ number_format($studyProgram->tuition_fee) }}/semester
                                </div>
                            </div>
                        @endif
                        
                        @if($studyProgram->degree_title)
                            <div class="info-item">
                                <div class="info-label">Degree Title</div>
                                <div class="info-value">
                                    <i class="fas fa-award"></i>
                                    {{ $studyProgram->degree_title }}
                                </div>
                            </div>
                        @endif
                        
                        @if($studyProgram->accreditation)
                            <div class="info-item">
                                <div class="info-label">Accreditation</div>
                                <div class="info-value">
                                    <i class="fas fa-certificate"></i>
                                    Grade {{ $studyProgram->accreditation }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Admission Requirements -->
                @if($studyProgram->admission_requirements)
                    <div class="detail-card fade-in-up" style="animation-delay: 0.6s;">
                        <h2 class="card-title-custom">
                            <span class="card-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </span>
                            Admission Requirements
                        </h2>
                        
                        <div class="description-content">
                            {!! nl2br(e($studyProgram->admission_requirements)) !!}
                        </div>
                    </div>
                @endif

                <!-- Career Prospects -->
                @if($studyProgram->career_prospects)
                    <div class="detail-card fade-in-up" style="animation-delay: 0.8s;">
                        <h2 class="card-title-custom">
                            <span class="card-icon">
                                <i class="fas fa-briefcase"></i>
                            </span>
                            Career Prospects
                        </h2>
                        
                        <div class="description-content">
                            {!! nl2br(e($studyProgram->career_prospects)) !!}
                        </div>
                    </div>
                @endif

                <!-- Core Subjects -->
                @php
                    $coreSubjects = $studyProgram->core_subjects;
                    if (is_string($coreSubjects)) {
                        $coreSubjects = json_decode($coreSubjects, true);
                    }
                    $coreSubjects = is_array($coreSubjects) ? $coreSubjects : [];
                @endphp
                
                @if(!empty($coreSubjects))
                    <div class="detail-card fade-in-up" style="animation-delay: 1s;">
                        <h2 class="card-title-custom">
                            <span class="card-icon">
                                <i class="fas fa-book-open"></i>
                            </span>
                            Core Subjects
                        </h2>
                        
                        <div class="row">
                            @foreach($coreSubjects as $index => $subject)
                                @php
                                    $subjectText = is_array($subject) ? (isset($subject['name']) ? $subject['name'] : json_encode($subject)) : (string)$subject;
                                @endphp
                                <div class="col-md-6 mb-3">
                                    <div class="subject-item">
                                        <div class="subject-number">{{ $index + 1 }}</div>
                                        <div class="subject-content">
                                            <h5 class="subject-title">{{ e($subjectText) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Specializations -->
                @php
                    $specializations = $studyProgram->specializations;
                    if (is_string($specializations)) {
                        $specializations = json_decode($specializations, true);
                    }
                    $specializations = is_array($specializations) ? $specializations : [];
                @endphp
                
                @if(!empty($specializations))
                    <div class="detail-card fade-in-up" style="animation-delay: 1.2s;">
                        <h2 class="card-title-custom">
                            <span class="card-icon">
                                <i class="fas fa-star"></i>
                            </span>
                            Specializations
                        </h2>
                        
                        <div class="specializations-grid">
                            @foreach($specializations as $specialization)
                                @php
                                    $specializationText = is_array($specialization) ? (isset($specialization['name']) ? $specialization['name'] : json_encode($specialization)) : (string)$specialization;
                                @endphp
                                <div class="specialization-card">
                                    <div class="specialization-icon">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <h5 class="specialization-title">{{ e($specializationText) }}</h5>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Facilities -->
                @php
                    $facilities = $studyProgram->facilities;
                    if (is_string($facilities)) {
                        $facilities = json_decode($facilities, true);
                    }
                    $facilities = is_array($facilities) ? $facilities : [];
                @endphp
                
                @if(!empty($facilities))
                    <div class="detail-card fade-in-up" style="animation-delay: 1.4s;">
                        <h2 class="card-title-custom">
                            <span class="card-icon">
                                <i class="fas fa-building"></i>
                            </span>
                            Facilities & Infrastructure
                        </h2>
                        
                        <div class="facilities-list">
                            @foreach($facilities as $facility)
                                @php
                                    $facilityText = is_array($facility) ? (isset($facility['name']) ? $facility['name'] : json_encode($facility)) : (string)$facility;
                                @endphp
                                <div class="facility-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ e($facilityText) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-sidebar">
                    <!-- Quick Stats -->
                    <div class="detail-card fade-in-right">
                        <h3 class="card-title-custom" style="font-size: 1.25rem;">
                            <span class="card-icon" style="width: 40px; height: 40px; font-size: 1.125rem;">
                                <i class="fas fa-chart-bar"></i>
                            </span>
                            Quick Stats
                        </h3>
                        
                        <div class="row g-3">
                            @if($studyProgram->duration_years)
                                <div class="col-6">
                                    <div class="stats-mini-card">
                                        <div class="stats-mini-icon">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                        <div class="stats-mini-value">{{ $studyProgram->duration_years }}</div>
                                        <div class="stats-mini-label">Years</div>
                                    </div>
                                </div>
                            @endif

                            @if($studyProgram->total_credits)
                                <div class="col-6">
                                    <div class="stats-mini-card">
                                        <div class="stats-mini-icon">
                                            <i class="fas fa-certificate"></i>
                                        </div>
                                        <div class="stats-mini-value">{{ $studyProgram->total_credits }}</div>
                                        <div class="stats-mini-label">Credits</div>
                                    </div>
                                </div>
                            @endif
                            
                            @php
                                $coreSubjectsData = $studyProgram->core_subjects;
                                if (is_string($coreSubjectsData)) {
                                    $coreSubjectsData = json_decode($coreSubjectsData, true);
                                }
                                $coreSubjectsCount = is_array($coreSubjectsData) ? count($coreSubjectsData) : 0;
                                
                                $specializationsData = $studyProgram->specializations;
                                if (is_string($specializationsData)) {
                                    $specializationsData = json_decode($specializationsData, true);
                                }
                                $specializationsCount = is_array($specializationsData) ? count($specializationsData) : 0;
                                
                                $facilitiesData = $studyProgram->facilities;
                                if (is_string($facilitiesData)) {
                                    $facilitiesData = json_decode($facilitiesData, true);
                                }
                                $facilitiesCount = is_array($facilitiesData) ? count($facilitiesData) : 0;
                            @endphp
                            
                            @if($coreSubjectsCount > 0)
                                <div class="col-6">
                                    <div class="stats-mini-card">
                                        <div class="stats-mini-icon">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <div class="stats-mini-value">{{ $coreSubjectsCount }}</div>
                                        <div class="stats-mini-label">Core Subjects</div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($specializationsCount > 0)
                                <div class="col-6">
                                    <div class="stats-mini-card">
                                        <div class="stats-mini-icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="stats-mini-value">{{ $specializationsCount }}</div>
                                        <div class="stats-mini-label">Specializations</div>
                                    </div>
                                </div>
                            @endif

                            @if($studyProgram->capacity)
                                <div class="col-12">
                                    <div class="stats-mini-card">
                                        <div class="stats-mini-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="stats-mini-value">{{ number_format($studyProgram->capacity) }}</div>
                                        <div class="stats-mini-label">Student Capacity</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="detail-card fade-in-right" style="animation-delay: 0.2s;">
                        <h3 class="card-title-custom" style="font-size: 1.25rem;">
                            <span class="card-icon" style="width: 40px; height: 40px; font-size: 1.125rem;">
                                <i class="fas fa-rocket"></i>
                            </span>
                            Take Action
                        </h3>
                        
                        <div class="d-grid gap-3">
                            <a href="#" class="btn btn-success-enhanced btn-enhanced">
                                <i class="fas fa-user-plus"></i>
                                Apply Now
                            </a>
                            
                            @if($studyProgram->brochure_file)
                                <a href="{{ asset($studyProgram->brochure_file) }}" target="_blank" class="btn btn-primary-enhanced btn-enhanced">
                                    <i class="fas fa-download"></i>
                                    Download Brochure
                                </a>
                            @endif
                            
                            <a href="#" class="btn btn-outline-enhanced btn-enhanced">
                                <i class="fas fa-envelope"></i>
                                Contact Us
                            </a>
                            
                            <a href="{{ route('study-programs.index') }}" class="btn btn-outline-enhanced btn-enhanced">
                                <i class="fas fa-arrow-left"></i>
                                Back to Programs
                            </a>
                        </div>
                    </div>

                    <!-- Share Program -->
                    <div class="detail-card fade-in-right" style="animation-delay: 0.4s;">
                        <h3 class="card-title-custom" style="font-size: 1.25rem;">
                            <span class="card-icon" style="width: 40px; height: 40px; font-size: 1.125rem;">
                                <i class="fas fa-share-alt"></i>
                            </span>
                            Share Program
                        </h3>
                        
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="#" class="btn btn-outline-primary btn-sm share-btn" data-platform="facebook" style="border-radius: 10px; padding: 10px 15px;" title="Share on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm share-btn" data-platform="twitter" style="border-radius: 10px; padding: 10px 15px;" title="Share on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm share-btn" data-platform="whatsapp" style="border-radius: 10px; padding: 10px 15px;" title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm share-btn" data-platform="linkedin" style="border-radius: 10px; padding: 10px 15px;" title="Share on LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <button type="button" class="btn btn-outline-secondary btn-sm copy-link-btn" style="border-radius: 10px; padding: 10px 15px;" title="Copy Link">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Related Programs -->
                    @if(isset($relatedPrograms) && $relatedPrograms->count() > 0)
                        <div class="detail-card fade-in-right" style="animation-delay: 0.6s;">
                            <h3 class="card-title-custom" style="font-size: 1.25rem;">
                                <span class="card-icon" style="width: 40px; height: 40px; font-size: 1.125rem;">
                                    <i class="fas fa-list"></i>
                                </span>
                                Related Programs
                            </h3>
                            
                            @foreach($relatedPrograms as $related)
                                <div class="related-program-card">
                                    <div class="related-program-image">
                                        @if($related->program_image)
                                            <img src="{{ asset($related->program_image) }}" alt="{{ $related->program_name }}">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <i class="fas fa-graduation-cap text-white" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="related-program-content">
                                        @if($related->degree_level)
                                            <span class="related-program-badge badge-{{ strtolower($related->degree_level) }}">
                                                {{ $related->degree_level }}
                                            </span>
                                        @endif
                                        <h4 class="related-program-title">{{ $related->program_name }}</h4>
                                        <a href="{{ route('study-programs.show', $related) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px; font-size: 0.875rem;">
                                            <i class="fas fa-arrow-right me-1"></i>View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Contact Information -->
                    <div class="detail-card fade-in-right" style="animation-delay: 0.8s;">
                        <h3 class="card-title-custom" style="font-size: 1.25rem;">
                            <span class="card-icon" style="width: 40px; height: 40px; font-size: 1.125rem;">
                                <i class="fas fa-phone"></i>
                            </span>
                            Need Help?
                        </h3>
                        
                        <div class="custom-list">
                            <li>
                                <i class="fas fa-envelope"></i>
                                <div>
                                    <small class="d-block text-muted">Email</small>
                                    <strong>admission@university.edu</strong>
                                </div>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <div>
                                    <small class="d-block text-muted">Phone</small>
                                    <strong>+62 21 1234 5678</strong>
                                </div>
                            </li>
                            <li>
                                <i class="fas fa-clock"></i>
                                <div>
                                    <small class="d-block text-muted">Office Hours</small>
                                    <strong>Mon-Fri, 9AM - 5PM</strong>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop">
    <i class="fas fa-arrow-up"></i>
</button>

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
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .fade-in, .scale-in');
    animatedElements.forEach(element => {
        observer.observe(element);
    });

    // Copy Link Functionality
    const copyLinkBtn = document.querySelector('.copy-link-btn');
    if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', function() {
            const currentUrl = window.location.href;
            
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(currentUrl).then(() => {
                    showCopyNotification(this);
                }).catch(err => {
                    console.error('Failed to copy:', err);
                    fallbackCopyTextToClipboard(currentUrl, this);
                });
            } else {
                fallbackCopyTextToClipboard(currentUrl, this);
            }
        });
    }

    function fallbackCopyTextToClipboard(text, button) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showCopyNotification(button);
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }
        
        document.body.removeChild(textArea);
    }

    function showCopyNotification(button) {
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-secondary');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    }

    // Share functionality
    const shareButtons = document.querySelectorAll('.share-btn');
    shareButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.querySelector('.hero-detail-title').textContent);
            const platform = this.dataset.platform;
            
            let shareUrl = '';
            if (platform === 'facebook') {
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            } else if (platform === 'twitter') {
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
            } else if (platform === 'whatsapp') {
                shareUrl = `https://wa.me/?text=${title}%20${url}`;
            } else if (platform === 'linkedin') {
                shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
            }
            
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
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

    // Add loading animation to action buttons
    const actionButtons = document.querySelectorAll('.btn-success-enhanced, .btn-primary-enhanced');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.href && !this.href.includes('#') && !this.target) {
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                }, 3000);
            }
        });
    });

    // Parallax effect for hero section
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero-detail-section');
        if (hero && scrolled < window.innerHeight) {
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

    // Enhanced hover effects for cards
    const detailCards = document.querySelectorAll('.detail-card, .related-program-card');
    detailCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // Add animation to info items on hover
    const infoItems = document.querySelectorAll('.info-item');
    infoItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1.2) rotate(5deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });

    // Back to top button functionality
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });

    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Sticky sidebar behavior
    const sidebar = document.querySelector('.sticky-sidebar');
    if (sidebar) {
        const updateStickyPosition = () => {
            const scrollTop = window.pageYOffset;
            const viewportHeight = window.innerHeight;
            const sidebarHeight = sidebar.offsetHeight;
            
            if (sidebarHeight > viewportHeight) {
                sidebar.style.position = 'relative';
                sidebar.style.top = '0';
            }
        };
        
        window.addEventListener('resize', updateStickyPosition);
        updateStickyPosition();
    }

    // Image lazy loading with fade-in effect
    const programImage = document.querySelector('.program-detail-image img');
    if (programImage) {
        programImage.addEventListener('load', function() {
            this.style.opacity = '0';
            setTimeout(() => {
                this.style.transition = 'opacity 0.5s ease';
                this.style.opacity = '1';
            }, 100);
        });
    }

    // Enhanced card interactions
    const statsCards = document.querySelectorAll('.stats-mini-card');
    statsCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.stats-mini-icon i');
            if (icon) {
                icon.style.transform = 'scale(1.2) rotate(10deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.stats-mini-icon i');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });

    // Subject item animations
    const subjectItems = document.querySelectorAll('.subject-item');
    subjectItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        
        item.addEventListener('mouseenter', function() {
            const number = this.querySelector('.subject-number');
            if (number) {
                number.style.transform = 'scale(1.1) rotate(5deg)';
                number.style.transition = 'transform 0.3s ease';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const number = this.querySelector('.subject-number');
            if (number) {
                number.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });

    // Specialization card animations
    const specializationCards = document.querySelectorAll('.specialization-card');
    specializationCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.specialization-icon i');
            if (icon) {
                icon.style.transform = 'rotateY(180deg)';
                icon.style.transition = 'transform 0.5s ease';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.specialization-icon i');
            if (icon) {
                icon.style.transform = 'rotateY(0deg)';
            }
        });
    });

    // Facility item animations
    const facilityItems = document.querySelectorAll('.facility-item');
    facilityItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.05}s`;
        
        item.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1.3)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1)';
            }
        });
    });

    // Vision & Mission card interactions
    const vmCards = document.querySelectorAll('.vision-mission-card');
    vmCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.vm-title i');
            if (icon) {
                icon.style.transform = 'scale(1.2)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.vm-title i');
            if (icon) {
                icon.style.transform = 'scale(1)';
            }
        });
    });

    // Related program card interactions
    const relatedCards = document.querySelectorAll('.related-program-card');
    relatedCards.forEach(card => {
        const image = card.querySelector('.related-program-image img');
        if (image) {
            card.addEventListener('mouseenter', function() {
                image.style.transform = 'scale(1.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                image.style.transform = 'scale(1)';
            });
        }
    });

    // Contact list item animations
    const contactItems = document.querySelectorAll('.custom-list li');
    contactItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        
        item.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1.2) rotate(10deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });

    // Page load animation sequence
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 100);

    // Breadcrumb animation
    const breadcrumb = document.querySelector('.breadcrumb-custom');
    if (breadcrumb) {
        const links = breadcrumb.querySelectorAll('a');
        links.forEach((link, index) => {
            link.style.opacity = '0';
            link.style.transform = 'translateX(-10px)';
            setTimeout(() => {
                link.style.transition = 'all 0.3s ease';
                link.style.opacity = '0.8';
                link.style.transform = 'translateX(0)';
            }, index * 100);
        });
    }

    // Hero badges animation
    const heroBadges = document.querySelectorAll('.hero-badge');
    heroBadges.forEach((badge, index) => {
        badge.style.opacity = '0';
        badge.style.transform = 'scale(0.8)';
        setTimeout(() => {
            badge.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            badge.style.opacity = '1';
            badge.style.transform = 'scale(1)';
        }, 300 + (index * 100));
    });

    // Info grid items staggered animation
    const infoItemsList = document.querySelectorAll('.info-item');
    infoItemsList.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        setTimeout(() => {
            item.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, 500 + (index * 100));
    });

    // Scroll progress indicator (optional enhancement)
    const createScrollProgress = () => {
        const progressBar = document.createElement('div');
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #3182ce, #4299e1);
            z-index: 9999;
            transition: width 0.1s ease;
        `;
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', () => {
            const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (window.pageYOffset / windowHeight) * 100;
            progressBar.style.width = scrolled + '%';
        });
    };
    
    createScrollProgress();

    // Keyboard navigation enhancement
    document.addEventListener('keydown', function(e) {
        // Alt + B: Back to programs
        if (e.altKey && e.key === 'b') {
            e.preventDefault();
            const backBtn = document.querySelector('a[href*="study-programs.index"]');
            if (backBtn) backBtn.click();
        }
        
        // Alt + A: Apply now
        if (e.altKey && e.key === 'a') {
            e.preventDefault();
            const applyBtn = document.querySelector('.btn-success-enhanced');
            if (applyBtn) applyBtn.click();
        }
        
        // Alt + D: Download brochure
        if (e.altKey && e.key === 'd') {
            e.preventDefault();
            const downloadBtn = document.querySelector('a[href*="brochure"]');
            if (downloadBtn) downloadBtn.click();
        }
    });

    // Print functionality
    const addPrintButton = () => {
        const actionCard = document.querySelector('.detail-card .d-grid');
        if (actionCard) {
            const printBtn = document.createElement('button');
            printBtn.className = 'btn btn-outline-enhanced btn-enhanced';
            printBtn.innerHTML = '<i class="fas fa-print"></i> Print Details';
            printBtn.addEventListener('click', () => window.print());
            actionCard.appendChild(printBtn);
        }
    };
    
    // Uncomment to add print button
    // addPrintButton();

    // Enhanced error handling for images
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const placeholder = this.parentElement.querySelector('.program-detail-image-placeholder');
            if (placeholder) {
                placeholder.style.display = 'flex';
            }
        });
    });

    // Analytics tracking (placeholder - integrate with your analytics)
    const trackEvent = (category, action, label) => {
        console.log(`Analytics: ${category} - ${action} - ${label}`);
        // Add your analytics code here (Google Analytics, etc.)
    };

    // Track button clicks
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const btnText = this.textContent.trim();
            trackEvent('Button', 'Click', btnText);
        });
    });

    // Track share actions
    shareButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            trackEvent('Social', 'Share', this.dataset.platform);
        });
    });

    // Accessibility enhancements
    const enhanceAccessibility = () => {
        // Add skip to content link
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.textContent = 'Skip to main content';
        skipLink.style.cssText = `
            position: absolute;
            top: -40px;
            left: 0;
            background: #3182ce;
            color: white;
            padding: 8px;
            text-decoration: none;
            z-index: 10000;
        `;
        skipLink.addEventListener('focus', function() {
            this.style.top = '0';
        });
        skipLink.addEventListener('blur', function() {
            this.style.top = '-40px';
        });
        document.body.insertBefore(skipLink, document.body.firstChild);

        // Add aria-labels to icon-only buttons
        const iconButtons = document.querySelectorAll('button:not([aria-label])');
        iconButtons.forEach(btn => {
            const icon = btn.querySelector('i');
            if (icon && !btn.textContent.trim()) {
                btn.setAttribute('aria-label', btn.title || 'Button');
            }
        });
    };
    
    enhanceAccessibility();

    // Performance monitoring
    if (window.performance && window.performance.timing) {
        window.addEventListener('load', function() {
            const loadTime = window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart;
            console.log(`Page loaded in ${loadTime}ms`);
        });
    }

    console.log('Enhanced program detail page loaded successfully!');
    console.log('Keyboard shortcuts: Alt+B (Back), Alt+A (Apply), Alt+D (Download)');
});
</script>

@endsection