<?php
// resources/views/layouts/guru-piket/sidebar.blade.php - Guru Piket Sidebar
?>
<style>
    /* Enhanced Sidebar Styles for Guru Piket */
    .guru-piket-sidebar-nav {
        background: #ffffff;
        border-right: 1px solid #e5e7eb;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        width: 280px;
        height: 100vh;
        position: fixed !important;
        left: 0;
        top: 0;
        z-index: 1000;
        overflow: hidden;
    }
    
    .dark .guru-piket-sidebar-nav {
        background: #1f2937;
        border-right: 1px solid #374151;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    
    /* Glassmorphism effect */
    .guru-piket-sidebar-nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(30, 64, 175, 0.1) 0%, transparent 50%);
        z-index: 1;
        pointer-events: none;
    }
    
    .guru-piket-sidebar-content {
        position: relative;
        z-index: 2;
    }
    
    /* Enhanced Logo Section */
    .guru-piket-sidebar-logo {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
        padding: 1.5rem 1rem;
        transition: all 0.3s ease;
    }
    
    .dark .guru-piket-sidebar-logo {
        background: #111827;
        border-bottom: 1px solid #374151;
        color: #f9fafb;
    }
    
    .guru-piket-logo-container {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-radius: 16px;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
    }
    
    .dark .guru-piket-logo-container {
        background: #374151;
        border: 1px solid #4b5563;
    }
    
    .guru-piket-logo-container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .guru-piket-logo-container:hover::before {
        opacity: 1;
    }
    
    .guru-piket-logo-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        background: #f3f4f6;
    }
    
    .dark .guru-piket-logo-container:hover {
        background: #4b5563;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .guru-piket-logo-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: #1f2937;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .dark .guru-piket-logo-icon {
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
    }
    
    .dark .guru-piket-logo-icon svg {
        color: #1f2937;
    }
    
    .guru-piket-logo-container:hover .guru-piket-logo-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }
    
    .guru-piket-logo-text {
        font-weight: 700;
        font-size: 1.2rem;
        color: #1f2937;
        letter-spacing: 0.5px;
    }
    
    .dark .guru-piket-logo-text {
        color: #ffffff;
    }
    
    .guru-piket-logo-subtitle {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
        margin-top: 2px;
    }
    
    .dark .guru-piket-logo-subtitle {
        color: #9ca3af;
    }
    
    /* Enhanced Navigation Items */
    .guru-piket-nav-section {
        padding: 1.5rem 1rem;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        flex: 1;
        height: calc(100vh - 200px);
    }
    
    .guru-piket-nav-section::-webkit-scrollbar {
        width: 6px;
    }
    
    .guru-piket-nav-section::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .guru-piket-nav-section::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }
    
    .guru-piket-sidebar-nav-item {
        color: #6b7280;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        margin-bottom: 0.5rem;
        border-radius: 12px;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 12px 16px;
    }
    
    .dark .guru-piket-sidebar-nav-item {
        color: #9ca3af;
    }
    
    .guru-piket-sidebar-nav-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .guru-piket-sidebar-nav-item:hover::before {
        left: 100%;
    }
    
    .guru-piket-sidebar-nav-item:hover {
        color: #1f2937;
        background: #f3f4f6;
        transform: translateX(5px);
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .dark .guru-piket-sidebar-nav-item:hover {
        color: #ffffff;
        background: #374151;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    .guru-piket-sidebar-nav-item.active {
        color: #ffffff;
        background: #1f2937;
        border-left: 4px solid #1f2937;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .dark .guru-piket-sidebar-nav-item.active {
        color: #1f2937;
        background: #ffffff;
        border-left: 4px solid #ffffff;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }
    
    .guru-piket-nav-icon {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    
    .guru-piket-sidebar-nav-item:hover .guru-piket-nav-icon {
        transform: scale(1.1);
        color: white;
    }
    
    /* Section Dividers */
    .guru-piket-nav-section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        margin: 1.5rem 0;
        position: relative;
    }
    
    .guru-piket-nav-section-divider::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 6px;
        height: 6px;
        background: #f59e0b;
        border-radius: 50%;
        opacity: 0.8;
    }
    
    .guru-piket-nav-section-title {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 1rem;
        padding: 0 1rem;
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .guru-piket-nav-section-title::before {
        content: '';
        width: 4px;
        height: 4px;
        background: #f59e0b;
        border-radius: 50%;
        margin-right: 8px;
    }
    
    /* Enhanced User Section */
    .guru-piket-user-section {
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    
    .guru-piket-user-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        text-decoration: none !important;
        color: inherit;
    }
    
    .guru-piket-user-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .guru-piket-user-card:hover::before {
        opacity: 1;
    }
    
    .guru-piket-user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.15);
        background: rgba(255, 255, 255, 0.2);
        text-decoration: none !important;
        color: inherit;
    }
    
    .guru-piket-user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        margin-right: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .guru-piket-user-card:hover .guru-piket-user-avatar {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
    }
    
    .guru-piket-user-info {
        flex: 1;
        min-width: 0;
    }
    
    .guru-piket-user-name {
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .guru-piket-user-role {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.75rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .guru-piket-user-status {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        margin-left: 8px;
        animation: pulse 2s infinite;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.1); }
    }
    
    /* Mobile Close Button */
    .guru-piket-mobile-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: rgba(255, 255, 255, 0.8);
        z-index: 10;
        backdrop-filter: blur(10px);
    }
    
    .guru-piket-mobile-close-btn:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .guru-piket-sidebar-nav {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .guru-piket-sidebar-nav.show {
            transform: translateX(0);
        }
        
        .guru-piket-sidebar-logo {
            padding-right: 4rem; /* Space for close button */
        }
        
        .guru-piket-nav-section {
            padding-bottom: 2rem;
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
        
        .guru-piket-mobile-close-btn {
            display: flex; /* Show only on mobile */
        }
    }
    
    /* Desktop Design */
    @media (min-width: 769px) {
        .guru-piket-mobile-close-btn {
            display: none !important;
        }
        
        .guru-piket-sidebar-nav {
            transform: translateX(0) !important;
            display: flex !important;
        }
    }
</style>

<!-- Enhanced Guru Piket Sidebar -->
<div id="guru-piket-sidebar" class="guru-piket-sidebar-nav guru-piket-sidebar-content">
    
    <!-- Enhanced Logo Section -->
    <div class="guru-piket-sidebar-logo">
        <div class="guru-piket-logo-container">
            <div class="guru-piket-logo-icon">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="guru-piket-logo-text">Guru Piket</div>
                <div class="guru-piket-logo-subtitle">SMA Negeri 1</div>
            </div>
        </div>
        
        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="guru-piket-mobile-close-btn">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Enhanced Navigation -->
    <div class="guru-piket-nav-section">
        <!-- Dashboard -->
        <a href="{{ route('guru-piket.dashboard') }}" 
           class="guru-piket-sidebar-nav-item {{ request()->routeIs('guru-piket.dashboard') ? 'active' : '' }}">
            <svg class="guru-piket-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Section Divider -->
        <div class="guru-piket-nav-section-divider"></div>
        <div class="guru-piket-nav-section-title">
            <span>Manajemen Absensi</span>
        </div>

        <!-- QR Scanner Absensi -->
        <a href="{{ route('guru-piket.attendance.qr-scanner') }}" 
           class="guru-piket-sidebar-nav-item {{ request()->routeIs('guru-piket.attendance.qr-scanner') ? 'active' : '' }}">
            <svg class="guru-piket-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5m0 0v5m0 0h5m0 0v5m0 0H9m0 0v5" />
            </svg>
            <span>QR Scanner</span>
        </a>

        <!-- Absensi Siswa -->
        <a href="{{ route('guru-piket.attendance.students') }}" 
           class="guru-piket-sidebar-nav-item {{ request()->routeIs('guru-piket.attendance.students*') ? 'active' : '' }}">
            <svg class="guru-piket-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
            <span>Absensi Siswa</span>
        </a>

        <!-- Absensi Guru -->
        <a href="{{ route('guru-piket.attendance.teachers') }}" 
           class="guru-piket-sidebar-nav-item {{ request()->routeIs('guru-piket.attendance.teachers*') ? 'active' : '' }}">
            <svg class="guru-piket-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>Absensi Guru</span>
        </a>

        <!-- Section Divider -->
        <div class="guru-piket-nav-section-divider"></div>
        <div class="guru-piket-nav-section-title">
            <span>Laporan & Analisis</span>
        </div>

        <!-- Laporan Harian -->
        <a href="{{ route('guru-piket.reports.daily') }}" 
           class="guru-piket-sidebar-nav-item {{ request()->routeIs('guru-piket.reports.daily') ? 'active' : '' }}">
            <svg class="guru-piket-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span>Laporan Harian</span>
        </a>

        <!-- Laporan Bulanan -->
        <a href="{{ route('guru-piket.reports.monthly') }}" 
           class="guru-piket-sidebar-nav-item {{ request()->routeIs('guru-piket.reports.monthly') ? 'active' : '' }}">
            <svg class="guru-piket-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>Laporan Bulanan</span>
        </a>

        <!-- Export Data -->
        <a href="{{ route('guru-piket.reports.export') }}" 
           class="guru-piket-sidebar-nav-item {{ request()->routeIs('guru-piket.reports.export') ? 'active' : '' }}">
            <svg class="guru-piket-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Export Data</span>
        </a>

        <!-- Section Divider -->
        <div class="guru-piket-nav-section-divider"></div>
        <div class="guru-piket-nav-section-title">
            <span>Pengaturan</span>
        </div>

        <!-- Profil -->
        <a href="{{ route('guru-piket.profile') }}" 
           class="guru-piket-sidebar-nav-item {{ request()->routeIs('guru-piket.profile') ? 'active' : '' }}">
            <svg class="guru-piket-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profil Saya</span>
        </a>
    </div>

    <!-- Enhanced User Section -->
    <div class="guru-piket-user-section">
        <a href="{{ route('guru-piket.profile') }}" class="guru-piket-user-card">
            <img class="guru-piket-user-avatar" 
                 src="{{ auth()->user()->avatar_url }}" 
                 alt="{{ auth()->user()->name }}"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=f59e0b&background=fef3c7&size=44'">
            <div class="guru-piket-user-info">
                <div class="guru-piket-user-name">{{ auth()->user()->name }}</div>
                <div class="guru-piket-user-role">Guru Piket</div>
            </div>
            <div class="guru-piket-user-status"></div>
        </a>
    </div>
</div>