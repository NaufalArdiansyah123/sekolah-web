@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard-enhanced.css') }}">
@endpush

@section('content')
<style>
    /* Enhanced Dashboard Styles with Modern Animations */
    
    /* Global Dashboard Animations */
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
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    @keyframes shimmer {
        0% {
            background-position: -200px 0;
        }
        100% {
            background-position: calc(200px + 100%) 0;
        }
    }
    
    /* Enhanced Dashboard Styles */
    .dashboard-container {
        background: var(--bg-secondary);
        min-height: calc(100vh - 200px);
        transition: all 0.3s ease;
        padding: 1.5rem;
    }
    
    /* Welcome Section */
    .welcome-section {
        background: linear-gradient(135deg, var(--bg-primary) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.8s ease-out;
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(147, 51, 234, 0.1) 0%, transparent 50%);
    }
    
    .dark .welcome-section {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    
    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(50%, -50%);
        animation: pulse 4s ease-in-out infinite;
    }
    
    .welcome-section::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(147, 51, 234, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-50%, 50%);
        animation: pulse 4s ease-in-out infinite 2s;
    }
    
    .welcome-content {
        position: relative;
        z-index: 2;
    }
    
    .welcome-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--text-primary), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }
    
    .welcome-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    
    .welcome-time {
        display: inline-flex;
        align-items: center;
        background: rgba(59, 130, 246, 0.1);
        color: var(--accent-color);
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    /* Stats Cards - 4 Cards in a Row */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    /* Responsive breakpoints for stats grid */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .stat-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        min-height: 140px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        animation: fadeInUp 0.6s ease-out;
        backdrop-filter: blur(10px);
    }
    
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.1),
            transparent
        );
        transition: left 0.5s ease;
    }
    
    .dark .stat-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        border-color: var(--accent-color);
    }
    
    .stat-card:hover::after {
        left: 100%;
    }
    
    .dark .stat-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-color), #8b5cf6);
        border-radius: 16px 16px 0 0;
    }
    
    /* Different colors for each card */
    .stat-card:nth-child(1)::before {
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    }
    
    .stat-card:nth-child(2)::before {
        background: linear-gradient(90deg, #10b981, #059669);
    }
    
    .stat-card:nth-child(3)::before {
        background: linear-gradient(90deg, #8b5cf6, #7c3aed);
    }
    
    .stat-card:nth-child(4)::before {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }
    
    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.3) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }
    
    .stat-card:hover .stat-icon::before {
        transform: translateX(100%);
    }
    
    .stat-card:hover .stat-icon {
        transform: scale(1.15) rotate(10deg);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1;
        background: linear-gradient(135deg, var(--text-primary), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover .stat-value {
        transform: scale(1.05);
    }
    
    .stat-label {
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }
    
    .stat-change {
        display: flex;
        align-items: center;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .stat-change.positive {
        color: #10b981;
    }
    
    .stat-change.negative {
        color: #ef4444;
    }
    
    /* Chart Cards */
    .chart-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    @media (max-width: 1024px) {
        .chart-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .chart-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        animation: fadeInUp 0.8s ease-out;
        position: relative;
        overflow: hidden;
    }
    
    .chart-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent-color), #8b5cf6, #ec4899);
        border-radius: 16px 16px 0 0;
    }
    
    .dark .chart-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .chart-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }
    
    .dark .chart-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .chart-header {
        display: flex;
        align-items: center;
        justify-content: between;
        margin-bottom: 1.5rem;
    }
    
    .chart-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .chart-subtitle {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    /* Activity Feed */
    .activity-item {
        display: flex;
        align-items: flex-start;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-item:hover {
        background: rgba(59, 130, 246, 0.05);
        border-radius: 8px;
        margin: 0 -0.5rem;
        padding: 1rem 0.5rem;
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
    }
    
    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .activity-content {
        flex: 1;
        min-width: 0;
    }
    
    .activity-title {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    
    .activity-description {
        color: var(--text-secondary);
        font-size: 0.75rem;
        line-height: 1.4;
    }
    
    .activity-time {
        color: var(--text-tertiary);
        font-size: 0.75rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
    
    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .quick-action {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        position: relative;
        overflow: hidden;
        animation: slideInRight 0.6s ease-out;
        backdrop-filter: blur(10px);
    }
    
    .quick-action::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .quick-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .quick-action:hover::before {
        left: 100%;
    }
    
    .quick-action:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 12px 35px rgba(59, 130, 246, 0.2);
        border-color: var(--accent-color);
        text-decoration: none;
    }
    
    .quick-action:hover::after {
        opacity: 1;
    }
    
    .quick-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        transition: all 0.3s ease;
    }
    
    .quick-action:hover .quick-action-icon {
        transform: scale(1.1);
    }
    
    .quick-action-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    
    .quick-action-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    /* Loading Animation */
    .loading-shimmer {
        background: linear-gradient(
            90deg,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.2) 20%,
            rgba(255, 255, 255, 0.5) 60%,
            rgba(255, 255, 255, 0)
        );
        background-size: 200px 100%;
        background-repeat: no-repeat;
        animation: shimmer 2s infinite;
    }
    
    /* Floating Elements */
    .floating {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    /* Gradient Text */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Enhanced Hover Effects */
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    /* Staggered Animation */
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 480px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="welcome-subtitle">
                Kelola sistem administrasi SMA Negeri 1 Balong dengan mudah dan efisien
            </p>
            <div class="welcome-time">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ now()->format('l, d F Y - H:i') }}
            </div>
        </div>
    </div>

    <!-- Statistics Cards - 4 Cards in a Row -->
    <div class="stats-grid">
        <!-- Card 1: Total Siswa -->
        <div class="stat-card card-hover-effect glass-effect">
            <div class="stat-header">
                <div class="stat-icon bg-blue-100 icon-bounce">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                @if($stats['total_students'] > 100)
                    <div class="notification-badge">!</div>
                @endif
            </div>
            <div class="stat-value text-gradient">{{ number_format($stats['total_students']) }}</div>
            <div class="stat-label">Total Siswa</div>
            <div class="stat-change positive">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $stats['active_students'] }} siswa aktif
            </div>
            <div class="progress-modern mt-3" style="--progress-width: 85%;"></div>
        </div>

        <!-- Card 2: Total Guru -->
        <div class="stat-card card-hover-effect glass-effect">
            <div class="stat-header">
                <div class="stat-icon bg-green-100 icon-pulse">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value text-gradient">{{ number_format($stats['total_teachers']) }}</div>
            <div class="stat-label">Total Guru & Staff</div>
            <div class="stat-change positive">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $stats['active_teachers'] }} guru aktif
            </div>
            <div class="progress-modern mt-3" style="--progress-width: 92%;"></div>
        </div>

        <!-- Card 3: Total Artikel -->
        <div class="stat-card card-hover-effect glass-effect">
            <div class="stat-header">
                <div class="stat-icon bg-purple-100 icon-rotate">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                @if($stats['total_posts'] > 50)
                    <div class="notification-badge">{{ $stats['total_posts'] }}</div>
                @endif
            </div>
            <div class="stat-value text-gradient">{{ number_format($stats['total_posts']) }}</div>
            <div class="stat-label">Artikel & Berita</div>
            <div class="stat-change positive">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $stats['published_posts'] }} dipublikasi
            </div>
            <div class="progress-modern mt-3" style="--progress-width: 68%;"></div>
        </div>

        <!-- Card 4: Prestasi Siswa -->
        <div class="stat-card card-hover-effect glass-effect">
            <div class="stat-header">
                <div class="stat-icon bg-yellow-100 icon-bounce">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <div class="notification-badge">🏆</div>
            </div>
            <div class="stat-value text-gradient">42</div>
            <div class="stat-label">Prestasi Siswa</div>
            <div class="stat-change positive">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                +5 prestasi baru
            </div>
            <div class="progress-modern mt-3" style="--progress-width: 95%;"></div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('admin.posts.blog') }}" class="quick-action card-hover-effect glass-effect tooltip-modern" data-tooltip="Buat konten baru">
            <div class="quick-action-icon bg-blue-100 gradient-bg-1">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
            </div>
            <div class="quick-action-title text-gradient">Tulis Artikel</div>
            <div class="quick-action-description">Buat artikel atau berita baru</div>
        </a>

        <a href="{{ route('admin.students.index') }}" class="quick-action card-hover-effect glass-effect tooltip-modern" data-tooltip="Manajemen siswa">
            <div class="quick-action-icon bg-green-100 gradient-bg-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="quick-action-title text-gradient">Kelola Siswa</div>
            <div class="quick-action-description">Tambah atau edit data siswa</div>
        </a>

        <a href="{{ route('admin.gallery.upload') }}" class="quick-action card-hover-effect glass-effect tooltip-modern" data-tooltip="Upload media">
            <div class="quick-action-icon bg-purple-100 gradient-bg-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="quick-action-title text-gradient">Upload Foto</div>
            <div class="quick-action-description">Tambah foto ke galeri</div>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="quick-action card-hover-effect glass-effect tooltip-modern" data-tooltip="Konfigurasi sistem">
            <div class="quick-action-icon bg-gray-100 gradient-bg-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="quick-action-title text-gradient">Pengaturan</div>
            <div class="quick-action-description">Konfigurasi sistem</div>
        </a>
    </div>

    <!-- Charts and Activity -->
    <div class="chart-grid">
        <!-- Upcoming Events Card -->
        <div class="chart-card card-hover-effect glass-effect shadow-medium">
            <x-upcoming-events-card :limit="5" :showHeader="true" />
        </div>

        <!-- Recent Activity -->
        <div class="chart-card card-hover-effect glass-effect shadow-medium custom-scrollbar">
            <div class="chart-header">
                <h3 class="chart-title text-gradient">Aktivitas Terbaru</h3>
            </div>
            <div class="space-y-1">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="activity-item">
                            <div class="activity-icon 
                                @if($notification->action == 'create') bg-green-100
                                @elseif($notification->action == 'update') bg-yellow-100
                                @elseif($notification->action == 'delete') bg-red-100
                                @elseif($notification->action == 'upload') bg-blue-100
                                @else bg-gray-100
                                @endif">
                                <i class="{{ $notification->icon }} text-sm"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $notification->title }}</div>
                                <div class="activity-description">{{ Str::limit($notification->message, 50) }}</div>
                            </div>
                            <div class="activity-time">{{ $notification->time_ago }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="activity-item">
                        <div class="activity-icon bg-blue-100">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Sistem siap digunakan</div>
                            <div class="activity-description">Dashboard admin telah berhasil dimuat</div>
                        </div>
                        <div class="activity-time">sekarang</div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon bg-green-100">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Mulai kelola data</div>
                            <div class="activity-description">Tambah siswa, guru, atau konten baru</div>
                        </div>
                        <div class="activity-time">-</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Additional Dashboard Section -->
    <div class="chart-grid">
        <!-- Website Analytics Chart -->
        <div class="chart-card card-hover-effect glass-effect shadow-medium">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title text-gradient">Aktivitas Website</h3>
                    <p class="chart-subtitle">Statistik pengunjung 30 hari terakhir</p>
                </div>
            </div>
            <div class="h-64 flex items-center justify-center bg-gray-50 dark:bg-gray-800 rounded-lg">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-gray-500">Chart akan ditampilkan di sini</p>
                    <p class="text-sm text-gray-400">Integrasi dengan analytics</p>
                </div>
            </div>
        </div>

        <!-- Quick Calendar Access -->
        <div class="chart-card card-hover-effect glass-effect shadow-medium">
            <div class="chart-header">
                <h3 class="chart-title text-gradient">Kalender Akademik</h3>
                <p class="chart-subtitle">Akses cepat ke kalender</p>
            </div>
            <div class="text-center py-8">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Kelola Event Akademik</h4>
                <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Tambah, edit, dan kelola jadwal kegiatan sekolah</p>
                <div class="space-y-2">
                    <a href="{{ route('admin.calendar.index') }}" class="btn-modern gradient-bg-1 text-white inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Buka Kalender
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<button class="fab tooltip-modern" data-tooltip="Bantuan" onclick="showHelp()">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
</button>

<script>
        // Enhanced Dashboard Interactivity
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading shimmer effect
        const cards = document.querySelectorAll('.stat-card, .chart-card, .quick-action');
        cards.forEach(card => {
            card.classList.add('loading-shimmer');
            setTimeout(() => {
                card.classList.remove('loading-shimmer');
            }, 1000);
        });
        
        // Add dynamic time update
        const timeElement = document.querySelector('.welcome-time');
        if (timeElement) {
            setInterval(() => {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                const timeString = now.toLocaleDateString('id-ID', options);
                timeElement.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ${timeString}
                `;
            }, 60000); // Update every minute
        }
        
        // Add floating animation to icons
        const icons = document.querySelectorAll('.stat-icon, .quick-action-icon');
        icons.forEach((icon, index) => {
            setTimeout(() => {
                icon.classList.add('floating');
            }, index * 200);
        });
        
        // Add staggered animation to cards
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            card.classList.add(`stagger-${index + 1}`);
        });
        
        // Enhanced hover effects
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Add ripple effect to quick actions
        const quickActions = document.querySelectorAll('.quick-action');
        quickActions.forEach(action => {
            action.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Add CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(59, 130, 246, 0.3);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                pointer-events: none;
            }
            
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
        // Enhanced stats animation with easing
        const statValues = document.querySelectorAll('.stat-value');
        statValues.forEach((stat, index) => {
            const finalValue = parseInt(stat.textContent.replace(/,/g, ''));
            let currentValue = 0;
            const increment = finalValue / 50;
            
            // Delay animation for each card
            setTimeout(() => {
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        stat.textContent = finalValue.toLocaleString();
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(currentValue).toLocaleString();
                    }
                }, 30);
            }, index * 200);
        });

        // Enhanced entrance animation with bounce effect
        const allCards = document.querySelectorAll('.stat-card, .quick-action, .chart-card');
        allCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px) scale(0.9)';
            card.style.transition = 'all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1)';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0) scale(1)';
            }, index * 150);
        });
        
        // Add parallax effect to welcome section
        const welcomeSection = document.querySelector('.welcome-section');
        if (welcomeSection) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.5;
                welcomeSection.style.transform = `translateY(${rate}px)`;
            });
        }
        
        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
        
        // Add intersection observer for animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.1 });
        
        allCards.forEach(card => {
            observer.observe(card);
        });
    });
    
    // Add theme transition effects
    window.addEventListener('theme-changed', function(e) {
        const cards = document.querySelectorAll('.stat-card, .chart-card, .quick-action, .welcome-section');
        cards.forEach(card => {
            card.style.transition = 'all 0.3s ease';
        });
    });
    
    // Add performance monitoring
    if ('performance' in window) {
        window.addEventListener('load', function() {
            setTimeout(() => {
                const perfData = performance.getEntriesByType('navigation')[0];
                console.log('Dashboard loaded in:', perfData.loadEventEnd - perfData.loadEventStart, 'ms');
            }, 0);
        });
    }
    
    // Help function for FAB
    function showHelp() {
        const helpModal = `
            <div class="modal fade" id="helpModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header gradient-bg-1 text-white">
                            <h5 class="modal-title">Bantuan Dashboard</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Fitur Dashboard:</h6>
                            <ul>
                                <li><strong>Statistik Real-time:</strong> Data siswa, guru, dan konten terupdate</li>
                                <li><strong>Quick Actions:</strong> Akses cepat ke fitur utama</li>
                                <li><strong>Aktivitas Terbaru:</strong> Monitor aktivitas sistem</li>
                                <li><strong>Kalender:</strong> Kelola jadwal akademik</li>
                            </ul>
                            <h6 class="mt-3">Tips:</h6>
                            <ul>
                                <li>Hover pada kartu untuk melihat animasi</li>
                                <li>Gunakan dark mode untuk pengalaman yang lebih nyaman</li>
                                <li>Semua data diperbarui secara real-time</li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        if (!document.getElementById('helpModal')) {
            document.body.insertAdjacentHTML('beforeend', helpModal);
        }
        
        const modal = new bootstrap.Modal(document.getElementById('helpModal'));
        modal.show();
    }
    
    // Add weather widget (optional)
    function addWeatherWidget() {
        const weatherContainer = document.querySelector('.welcome-section .welcome-content');
        if (weatherContainer) {
            const weatherWidget = document.createElement('div');
            weatherWidget.className = 'weather-widget mt-3';
            weatherWidget.innerHTML = `
                <div class="d-flex align-items-center text-sm text-muted">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                    <span>Ponorogo, Indonesia • 28°C • Cerah</span>
                </div>
            `;
            weatherContainer.appendChild(weatherWidget);
        }
    }
    
    // Initialize weather widget
    setTimeout(addWeatherWidget, 2000);
</script>
@endsection

@push('scripts')
<script>
    // Additional dashboard enhancements
    document.addEventListener('DOMContentLoaded', function() {
        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case '1':
                        e.preventDefault();
                        window.location.href = '{{ route("admin.posts.blog") }}';
                        break;
                    case '2':
                        e.preventDefault();
                        window.location.href = '{{ route("admin.students.index") }}';
                        break;
                    case '3':
                        e.preventDefault();
                        window.location.href = '{{ route("admin.gallery.upload") }}';
                        break;
                    case '4':
                        e.preventDefault();
                        window.location.href = '{{ route("admin.settings.index") }}';
                        break;
                }
            }
        });
        
        // Add notification for keyboard shortcuts
        const shortcutNotification = document.createElement('div');
        shortcutNotification.className = 'position-fixed bottom-0 start-0 m-3 p-2 bg-dark text-white rounded text-sm opacity-75';
        shortcutNotification.innerHTML = 'Tip: Gunakan Ctrl+1-4 untuk quick actions';
        shortcutNotification.style.fontSize = '0.75rem';
        shortcutNotification.style.zIndex = '1000';
        document.body.appendChild(shortcutNotification);
        
        // Hide notification after 5 seconds
        setTimeout(() => {
            shortcutNotification.style.opacity = '0';
            setTimeout(() => {
                shortcutNotification.remove();
            }, 300);
        }, 5000);
    });
</script>
@endpush