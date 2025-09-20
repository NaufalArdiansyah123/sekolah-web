<?php $__env->startSection('title', 'Ekstrakurikuler - SMA Negeri 99'); ?>

<?php $__env->startSection('content'); ?>
<style>
    :root {
        --primary-color: #1e293b;
        --secondary-color: #3b82f6;
        --accent-color: #06b6d4;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --light-gray: #f8fafc;
        --medium-gray: #e2e8f0;
        --dark-gray: #64748b;
        --text-dark: #0f172a;
        --glass-bg: rgba(30, 41, 59, 0.95);
        --gradient-primary: linear-gradient(135deg, #1e293b 0%, #3b82f6 50%, #06b6d4 100%);
        --gradient-secondary: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(6, 182, 212, 0.05) 100%);
        --shadow-soft: 0 4px 25px rgba(0, 0, 0, 0.08);
        --shadow-medium: 0 8px 40px rgba(0, 0, 0, 0.12);
        --shadow-strong: 0 20px 60px rgba(0, 0, 0, 0.15);
    }
    
    * {
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-dark);
        line-height: 1.7;
        background: var(--light-gray);
        overflow-x: hidden;
    }
    
    /* Enhanced Hero Section */
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
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
    
    @keyframes backgroundShift {
        0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.8; }
        33% { transform: scale(1.1) rotate(1deg); opacity: 0.6; }
        66% { transform: scale(0.95) rotate(-1deg); opacity: 0.9; }
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
        font-size: 9rem;
        opacity: 0.9;
        background: linear-gradient(135deg, rgba(255,255,255,0.8), rgba(255,255,255,0.4));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: heroIconFloat 8s ease-in-out infinite;
        text-shadow: 0 0 30px rgba(255,255,255,0.4);
        filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));
    }
    
    @keyframes heroIconFloat {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        25% { transform: translateY(-15px) rotate(2deg); }
        50% { transform: translateY(-25px) rotate(0deg); }
        75% { transform: translateY(-15px) rotate(-2deg); }
    }

    /* Enhanced Animation Styles */
    .fade-in-up {
        opacity: 0;
        transform: translateY(50px);
        transition: all 1s cubic-bezier(0.23, 1, 0.320, 1);
    }
    
    .fade-in-left {
        opacity: 0;
        transform: translateX(-50px);
        transition: all 1s cubic-bezier(0.23, 1, 0.320, 1);
    }
    
    .fade-in-right {
        opacity: 0;
        transform: translateX(50px);
        transition: all 1s cubic-bezier(0.23, 1, 0.320, 1);
    }
    
    .scale-in {
        opacity: 0;
        transform: scale(0.7);
        transition: all 1s cubic-bezier(0.23, 1, 0.320, 1);
    }
    
    /* Animation Active States */
    .fade-in-up.animate,
    .fade-in-left.animate,
    .fade-in-right.animate {
        opacity: 1;
        transform: translate(0, 0);
    }
    
    .scale-in.animate {
        opacity: 1;
        transform: scale(1);
    }

    /* Enhanced Stats Section */
    .stats-section {
        padding: 100px 0;
        background: 
            linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
        position: relative;
    }
    
    .stats-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(6, 182, 212, 0.05) 0%, transparent 50%);
        z-index: 1;
    }
    
    .stats-section .container {
        position: relative;
        z-index: 2;
    }
    
    .stats-card {
        background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
        border-radius: 24px;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.320, 1);
        border: 1px solid rgba(226, 232, 240, 0.6);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-soft);
        backdrop-filter: blur(20px);
        height: 100%;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, 
            var(--secondary-color) 0%, 
            var(--accent-color) 25%, 
            var(--success-color) 50%, 
            var(--warning-color) 75%, 
            var(--secondary-color) 100%
        );
        transform: scaleX(0);
        transition: transform 0.6s cubic-bezier(0.23, 1, 0.320, 1);
        transform-origin: left;
    }
    
    .stats-card:hover::before {
        transform: scaleX(1);
    }
    
    .stats-card:hover {
        transform: translateY(-15px) scale(1.03);
        box-shadow: var(--shadow-strong);
        border-color: rgba(59, 130, 246, 0.2);
    }
    
    .stats-card .card-body {
        padding: 2.5rem 2rem;
    }
    
    .stats-card i {
        margin-bottom: 1.5rem;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
    }
    
    .stats-card h2 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Enhanced Section Styling */
    .extracurriculars-section {
        padding: 100px 0;
        background: var(--light-gray);
        position: relative;
    }
    
    .extracurriculars-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(ellipse at 30% 40%, rgba(59, 130, 246, 0.03) 0%, transparent 70%),
            radial-gradient(ellipse at 70% 60%, rgba(6, 182, 212, 0.03) 0%, transparent 70%);
        z-index: 1;
    }
    
    .extracurriculars-section .container {
        position: relative;
        z-index: 2;
    }

    .section-title {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-heading {
        font-size: 3.2rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 1.5rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 6px;
        background: var(--gradient-primary);
        border-radius: 3px;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .section-subtitle {
        font-size: 1.2rem;
        color: var(--dark-gray);
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.7;
        font-weight: 400;
    }

    /* Enhanced Extracurricular Cards */
    .extracurriculars-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 2.5rem;
        margin-bottom: 4rem;
    }

    .extracurricular-card {
        background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
        border-radius: 28px;
        overflow: hidden;
        transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(226, 232, 240, 0.8);
        backdrop-filter: blur(20px);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
        transform-origin: center;
    }

    .extracurricular-card::before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 300%;
        height: 300%;
        background: 
            radial-gradient(circle, 
                rgba(59, 130, 246, 0.05) 0%, 
                rgba(6, 182, 212, 0.03) 30%, 
                transparent 70%
            );
        opacity: 0;
        transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
        z-index: 1;
    }

    .extracurricular-card:hover::before {
        opacity: 1;
        top: -50%;
        left: -50%;
    }

    .extracurricular-card:hover {
        transform: translateY(-20px) scale(1.02) rotateX(5deg);
        box-shadow: 
            var(--shadow-strong),
            0 0 0 1px rgba(59, 130, 246, 0.1),
            0 0 50px rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .card-image {
        height: 220px;
        background: var(--gradient-primary);
        position: relative;
        overflow: hidden;
    }

    .card-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            135deg, 
            rgba(0,0,0,0.1) 0%, 
            rgba(0,0,0,0.05) 50%, 
            rgba(255,255,255,0.1) 100%
        );
        z-index: 2;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
        filter: brightness(1.1) saturate(1.2);
    }

    .extracurricular-card:hover .card-image img {
        transform: scale(1.15);
    }

    .card-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: rgba(255, 255, 255, 0.9);
        font-size: 4rem;
        font-weight: 600;
        text-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .card-content {
        padding: 2.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        position: relative;
        z-index: 3;
        background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
    }

    .card-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 0.8rem;
        transition: all 0.3s ease;
        line-height: 1.3;
    }

    .card-coach {
        color: var(--secondary-color);
        font-size: 1rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-description {
        color: var(--dark-gray);
        line-height: 1.7;
        margin-bottom: 2rem;
        flex-grow: 1;
        font-size: 1rem;
    }

    .card-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, 
            rgba(59, 130, 246, 0.06) 0%, 
            rgba(6, 182, 212, 0.04) 100%
        );
        border-radius: 18px;
        border: 1px solid rgba(59, 130, 246, 0.1);
        backdrop-filter: blur(10px);
    }

    .stat-item {
        text-align: center;
        padding: 0.5rem;
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--secondary-color);
        display: block;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--dark-gray);
        margin-top: 0.5rem;
        font-weight: 500;
    }

    .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .btn-view, .btn-register {
        padding: 1rem 1.5rem;
        border-radius: 16px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn-view {
        background: linear-gradient(135deg, 
            rgba(59, 130, 246, 0.1) 0%, 
            rgba(6, 182, 212, 0.08) 100%
        );
        color: var(--secondary-color);
        border: 2px solid rgba(59, 130, 246, 0.2);
    }

    .btn-view:hover {
        background: linear-gradient(135deg, 
            rgba(59, 130, 246, 0.2) 0%, 
            rgba(6, 182, 212, 0.15) 100%
        );
        color: var(--secondary-color);
        text-decoration: none;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
    }

    .btn-register {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        border: 2px solid transparent;
    }

    .btn-register:hover {
        background: linear-gradient(135deg, #1e40af 0%, #0e7490 100%);
        color: white;
        text-decoration: none;
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4);
    }

    /* Check Registration Section */
    .check-registration {
        background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
        padding: 3rem;
        border-radius: 28px;
        box-shadow: var(--shadow-medium);
        margin-bottom: 4rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
        position: relative;
        overflow: hidden;
    }

    .check-registration::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--gradient-primary);
        z-index: 1;
    }

    .check-registration h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .check-form {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 1.5rem;
        align-items: end;
    }

    .form-group {
        flex: 1;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.75rem;
        display: block;
        font-size: 1rem;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.5rem;
        border: 2px solid var(--medium-gray);
        border-radius: 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }

    .form-input:focus {
        border-color: var(--secondary-color);
        box-shadow: 
            inset 0 2px 4px rgba(0,0,0,0.02),
            0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    .btn-check {
        background: var(--gradient-primary);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        white-space: nowrap;
    }

    .btn-check:hover {
        background: linear-gradient(135deg, #1e40af 0%, #0e7490 100%);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4);
    }

    /* Enhanced Registration CTA Section */
    .registration-cta-section {
        margin-top: 5rem;
    }

    .registration-cta-card {
        background: var(--gradient-primary);
        border-radius: 32px;
        padding: 4rem 3rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-strong);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .registration-cta-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: 
            radial-gradient(circle, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 40%, 
                transparent 70%
            );
        animation: ctaFloat 12s ease-in-out infinite;
        z-index: 1;
    }

    @keyframes ctaFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(-20px, -30px) scale(1.1); }
        66% { transform: translate(20px, -20px) scale(0.9); }
    }

    .cta-content, .cta-actions {
        position: relative;
        z-index: 2;
    }

    .cta-title {
        font-size: 2.4rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.7), 0 0 20px rgba(0,0,0,0.5);
        color: #ffffff;
        line-height: 1.2;
    }

    .cta-description {
        font-size: 1.2rem;
        margin-bottom: 2.5rem;
        opacity: 1;
        line-height: 1.7;
        text-shadow: 1px 1px 6px rgba(0,0,0,0.6);
        color: #f1f5f9;
        max-width: 600px;
    }

    .cta-features {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        font-size: 1.05rem;
        font-weight: 500;
        color: #f1f5f9;
        gap: 0.75rem;
    }

    .feature-item i {
        font-size: 1.2rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    .stat-circle {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.25) 0%, 
            rgba(255, 255, 255, 0.1) 100%
        );
        border: 3px solid rgba(255, 255, 255, 0.4);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        backdrop-filter: blur(20px);
        transition: all 0.4s ease;
        box-shadow: 
            0 10px 30px rgba(0,0,0,0.2),
            inset 0 1px 0 rgba(255,255,255,0.3);
    }

    .stat-circle:hover {
        transform: scale(1.08) rotateZ(5deg);
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.35) 0%, 
            rgba(255, 255, 255, 0.2) 100%
        );
        box-shadow: 
            0 15px 40px rgba(0,0,0,0.3),
            inset 0 1px 0 rgba(255,255,255,0.4);
    }

    .stat-circle .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        color: #ffffff;
        text-shadow: 0 2px 8px rgba(0,0,0,0.5);
    }

    .stat-circle .stat-text {
        font-size: 0.9rem;
        text-align: center;
        margin-top: 0.5rem;
        opacity: 0.95;
        color: #f1f5f9;
        text-shadow: 0 1px 4px rgba(0,0,0,0.5);
    }

    .btn-cta-primary, .btn-cta-secondary {
        display: block;
        width: 100%;
        padding: 1.25rem 2rem;
        border-radius: 18px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 1rem;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
        border: 2px solid transparent;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .btn-cta-primary {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.95) 0%, 
            rgba(255, 255, 255, 0.9) 100%
        );
        color: var(--primary-color);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(20px);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .btn-cta-primary:hover {
        background: #ffffff;
        color: var(--primary-color);
        text-decoration: none;
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
    }

    .btn-cta-secondary {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.15) 0%, 
            rgba(255, 255, 255, 0.1) 100%
        );
        color: white;
        border-color: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(20px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-cta-secondary:hover {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.25) 0%, 
            rgba(255, 255, 255, 0.2) 100%
        );
        color: white;
        text-decoration: none;
        transform: translateY(-3px);
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Footer Styling - Ensuring proper contrast */
    footer {
        background: var(--primary-color) !important;
        color: #f1f5f9 !important;
        border-top: 4px solid var(--secondary-color);
        margin-top: 0;
        position: relative;
        overflow: hidden;
    }

    footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(ellipse at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 60%),
            radial-gradient(ellipse at 80% 50%, rgba(6, 182, 212, 0.1) 0%, transparent 60%);
        z-index: 1;
    }

    footer .container {
        position: relative;
        z-index: 2;
    }

    footer h5 {
        color: #ffffff !important;
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 1.2rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    footer p, footer li, footer a {
        color: #cbd5e1 !important;
        transition: color 0.3s ease;
    }

    footer a:hover {
        color: #ffffff !important;
        text-decoration: none;
        transform: translateX(5px);
        transition: all 0.3s ease;
    }

    footer .text-muted {
        color: #94a3b8 !important;
        border-top: 1px solid rgba(203, 213, 225, 0.2);
        padding-top: 2rem;
        margin-top: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .hero-section {
            padding: 80px 0 60px;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 3rem;
        }
        
        .hero-icon {
            font-size: 7rem;
            margin-top: 2rem;
        }

        .extracurriculars-grid {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .section-heading {
            font-size: 2.5rem;
        }

        .check-form {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .registration-cta-card {
            padding: 3rem 2rem;
            text-align: center;
        }

        .cta-title {
            font-size: 2rem;
        }

        .stats-section, .extracurriculars-section {
            padding: 80px 0;
        }
    }

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2.5rem;
        }
        
        .hero-section .lead {
            font-size: 1.2rem;
        }

        .hero-icon {
            font-size: 6rem;
        }
        
        .extracurriculars-grid {
            grid-template-columns: 1fr;
        }
        
        .section-heading {
            font-size: 2.2rem;
        }

        .card-actions {
            grid-template-columns: 1fr;
        }

        .card-stats {
            grid-template-columns: repeat(3, 1fr);
            padding: 1rem;
        }

        .check-registration {
            padding: 2rem;
        }

        .cta-features {
            margin-bottom: 2rem;
        }

        .feature-item {
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .hero-section {
            padding: 60px 0 40px;
        }

        .hero-section h1 {
            font-size: 2.2rem;
        }
        
        .extracurriculars-section, .stats-section {
            padding: 60px 0;
        }
        
        .card-content {
            padding: 2rem 1.5rem;
        }

        .section-heading {
            font-size: 2rem;
        }

        .stats-card .card-body {
            padding: 2rem 1.5rem;
        }

        .registration-cta-card {
            padding: 2rem 1.5rem;
        }

        .cta-title {
            font-size: 1.8rem;
        }

        .cta-description {
            font-size: 1.1rem;
        }

        .check-registration h3 {
            font-size: 1.5rem;
        }
    }

    /* Staggered animation delays */
    .fade-in-up:nth-child(1) { animation-delay: 0.1s; }
    .fade-in-up:nth-child(2) { animation-delay: 0.2s; }
    .fade-in-up:nth-child(3) { animation-delay: 0.3s; }
    .fade-in-up:nth-child(4) { animation-delay: 0.4s; }
    .fade-in-up:nth-child(5) { animation-delay: 0.5s; }
    .fade-in-up:nth-child(6) { animation-delay: 0.6s; }

    /* Loading animation */
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .loading-shimmer {
        position: relative;
        overflow: hidden;
    }

    .loading-shimmer::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(255, 255, 255, 0.4) 50%,
            transparent 100%
        );
        animation: shimmer 2s infinite;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--light-gray);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--gradient-primary);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #1e40af 0%, #0e7490 100%);
    }

    /* Add ID to extracurriculars grid for smooth scrolling */
    .extracurriculars-grid {
        scroll-margin-top: 120px;
    }

    /* Enhanced empty state */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
        border-radius: 24px;
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .empty-state i {
        color: var(--dark-gray);
        margin-bottom: 2rem;
        opacity: 0.7;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
    }

    .empty-state h3 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: var(--dark-gray);
        font-size: 1.1rem;
        max-width: 400px;
        margin: 0 auto;
    }

    /* Enhanced pagination */
    .pagination {
        margin-top: 3rem;
    }

    .pagination .page-link {
        border: 2px solid var(--medium-gray);
        color: var(--primary-color);
        padding: 0.75rem 1rem;
        margin: 0 0.25rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        background: white;
    }

    .pagination .page-link:hover {
        background: var(--gradient-primary);
        border-color: var(--secondary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: var(--gradient-primary);
        border-color: var(--secondary-color);
        color: white;
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Ekstrakurikuler SMA Negeri 99</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;"> Kembangkan bakat dan minatmu melalui berbagai kegiatan ekstrakurikuler yang menarik dan bermanfaat. 
                    Bergabunglah dengan komunitas siswa yang berprestasi dan berkarakter!</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-users hero-icon scale-in" style="animation-delay: 0.4s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Quick Stats -->
<section class="stats-section">
    <div class="container">
        <div class="section-title">
            <h2 class="section-heading fade-in-up">Statistik Ekstrakurikuler</h2>
            <p class="section-subtitle fade-in-up" style="animation-delay: 0.2s;">
                Data terkini mengenai kegiatan ekstrakurikuler di SMA Negeri 99
            </p>
        </div>
        <div class="row text-center g-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-list fa-3x text-primary"></i>
                        </div>
                        <h2 class="display-4 fw-bold mb-2"><?php echo e($extracurriculars->total()); ?></h2>
                        <p class="text-muted mb-0 fw-medium">TOTAL EKSTRAKURIKULER</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-user-plus fa-3x text-success"></i>
                        </div>
                        <h2 class="display-4 fw-bold mb-2"><?php echo e($extracurriculars->sum('registrations_count')); ?></h2>
                        <p class="text-muted mb-0 fw-medium">TOTAL PENDAFTAR</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-check-circle fa-3x text-info"></i>
                        </div>
                        <h2 class="display-4 fw-bold mb-2"><?php echo e($extracurriculars->sum('approved_registrations_count')); ?></h2>
                        <p class="text-muted mb-0 fw-medium">SISWA DITERIMA</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.6s;">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-clock fa-3x text-warning"></i>
                        </div>
                        <h2 class="display-4 fw-bold mb-2"><?php echo e($extracurriculars->sum('pending_registrations_count')); ?></h2>
                        <p class="text-muted mb-0 fw-medium">MENUNGGU PERSETUJUAN</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Check Registration Section -->
<section class="extracurriculars-section">
    <div class="container">
        <div class="check-registration fade-in-up">
            <h3 class="mb-3">
                <i class="fas fa-search me-2"></i>
                Cek Status Pendaftaran
            </h3>
            <p class="text-muted mb-3">Masukkan NIS untuk melihat status pendaftaran ekstrakurikuler Anda</p>
            <form action="<?php echo e(route('public.extracurriculars.check')); ?>" method="GET" class="check-form">
                <div class="form-group">
                    <label class="form-label">Nomor Induk Siswa (NIS)</label>
                    <input type="text" name="student_nis" class="form-input" placeholder="Masukkan NIS Anda" required>
                </div>
                <button type="submit" class="btn-check">
                    <i class="fas fa-search me-2"></i>
                    Cek Status
                </button>
            </form>
        </div>

        <div class="section-title">
            <h2 class="section-heading fade-in-up">Daftar Ekstrakurikuler</h2>
            <p class="section-subtitle fade-in-up" style="animation-delay: 0.2s;">
                Pilih ekstrakurikuler yang sesuai dengan minat dan bakatmu
            </p>
        </div>

        <div class="extracurriculars-grid" id="extracurriculars-list">
            <?php if($extracurriculars->count() > 0): ?>
                <?php $__currentLoopData = $extracurriculars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $extracurricular): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="extracurricular-card fade-in-up" style="animation-delay: <?php echo e(($index % 6) * 0.1); ?>s;">
                    <div class="card-image">
                        <?php if($extracurricular->image): ?>
                            <img src="<?php echo e(asset('storage/' . $extracurricular->image)); ?>" 
                                 alt="<?php echo e($extracurricular->name); ?>">
                        <?php else: ?>
                            <div class="card-image-placeholder">
                                <i class="fas fa-users"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title"><?php echo e($extracurricular->name); ?></h3>
                        <p class="card-coach">
                            <i class="fas fa-user-tie"></i>
                            Pembina: <?php echo e($extracurricular->coach); ?>

                        </p>
                        
                        <p class="card-description">
                            <?php echo e(Str::limit($extracurricular->description, 120)); ?>

                        </p>

                        <div class="card-stats">
                            <div class="stat-item">
                                <span class="stat-number"><?php echo e($extracurricular->registrations_count); ?></span>
                                <div class="stat-label">Total Pendaftar</div>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number"><?php echo e($extracurricular->approved_registrations_count); ?></span>
                                <div class="stat-label">Diterima</div>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number"><?php echo e($extracurricular->pending_registrations_count); ?></span>
                                <div class="stat-label">Menunggu</div>
                            </div>
                        </div>

                        <div class="card-actions">
                            <a href="<?php echo e(route('public.extracurriculars.show', $extracurricular)); ?>" class="btn-view">
                                <i class="fas fa-eye"></i>
                                Detail
                            </a>
                            <?php if($extracurricular->status === 'active'): ?>
                                <a href="<?php echo e(route('public.extracurriculars.register', $extracurricular)); ?>" class="btn-register">
                                    <i class="fas fa-user-plus"></i>
                                    Daftar
                                </a>
                            <?php else: ?>
                                <span class="btn-register" style="opacity: 0.6; cursor: not-allowed;">
                                    <i class="fas fa-lock"></i>
                                    Tutup
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <!-- Enhanced Empty State -->
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-users fa-5x mb-4"></i>
                        <h3>Belum Ada Ekstrakurikuler</h3>
                        <p>Saat ini belum ada ekstrakurikuler yang tersedia. Silakan cek kembali nanti.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Enhanced Pagination -->
        <?php if($extracurriculars->hasPages()): ?>
            <div class="d-flex justify-content-center">
                <?php echo e($extracurriculars->links()); ?>

            </div>
        <?php endif; ?>

        <!-- Enhanced Registration Call-to-Action Section -->
        <div class="registration-cta-section fade-in-up">
            <div class="registration-cta-card">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="cta-content">
                            <h3 class="cta-title">
                                <i class="fas fa-rocket me-3"></i>
                                Siap Bergabung dengan Ekstrakurikuler?
                            </h3>
                            <p class="cta-description">
                                Jangan lewatkan kesempatan untuk mengembangkan bakat dan minatmu! 
                                Daftar sekarang dan jadilah bagian dari komunitas siswa berprestasi di SMA Negeri 99.
                            </p>
                            <div class="cta-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Pendaftaran mudah dan cepat</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Bimbingan dari pembina berpengalaman</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Kesempatan mengikuti kompetisi</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Pengembangan soft skills dan karakter</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="cta-actions">
                            <div class="cta-stats mb-4">
                                <div class="stat-circle">
                                    <div class="stat-number"><?php echo e($extracurriculars->where('status', 'active')->count()); ?></div>
                                    <div class="stat-text">Ekstrakurikuler Aktif</div>
                                </div>
                            </div>
                            <a href="#extracurriculars-list" class="btn-cta-primary">
                                <i class="fas fa-user-plus me-2"></i>
                                Pilih & Daftar Sekarang
                            </a>
                            <a href="<?php echo e(route('public.extracurriculars.check')); ?>" class="btn-cta-secondary">
                                <i class="fas fa-search me-2"></i>
                                Cek Status Pendaftaran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Intersection Observer for animations
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -80px 0px'
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
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .scale-in');
    animatedElements.forEach(element => {
        observer.observe(element);
    });

    // Enhanced card hover effects with 3D transforms
    const extracurricularCards = document.querySelectorAll('.extracurricular-card');
    extracurricularCards.forEach((card, index) => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-25px) scale(1.03) perspective(1000px) rotateX(10deg)';
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1) perspective(1000px) rotateX(0deg)';
            this.style.zIndex = '1';
        });

        // Add staggered animation delay
        card.style.animationDelay = `${(index % 6) * 0.15}s`;
    });

    // Enhanced stats animation with counter effect
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-18px) scale(1.06)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });

        // Add counter animation
        const numberElement = card.querySelector('h2');
        if (numberElement) {
            const targetNumber = parseInt(numberElement.textContent);
            let currentNumber = 0;
            const increment = targetNumber / 50;
            
            const counter = setInterval(() => {
                currentNumber += increment;
                if (currentNumber >= targetNumber) {
                    currentNumber = targetNumber;
                    clearInterval(counter);
                }
                numberElement.textContent = Math.floor(currentNumber);
            }, 50);
        }
    });

    // Enhanced form interactions
    const formInputs = document.querySelectorAll('.form-input');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });

    // Smooth scroll for CTA buttons
    const ctaButtons = document.querySelectorAll('a[href^="#"]');
    ctaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Enhanced parallax effect for hero section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const heroSection = document.querySelector('.hero-section');
        const rate = scrolled * -0.5;
        
        if (heroSection) {
            heroSection.style.transform = `translateY(${rate}px)`;
        }
    });

    // Add loading animation to cards
    extracurricularCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animate');
        }, index * 100);
    });

    console.log('Enhanced extracurriculars page loaded with premium animations!');
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/public/extracurriculars/index.blade.php ENDPATH**/ ?>