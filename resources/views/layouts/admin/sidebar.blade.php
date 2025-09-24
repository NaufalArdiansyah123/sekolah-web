<?php
// resources/views/layouts/admin/sidebar.blade.php - Enhanced Beautiful Design
?>
<style>
    /* Enhanced Sidebar Styles */
    .sidebar-nav {
        background: linear-gradient(180deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
        border-right: 1px solid var(--border-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }
    
    .dark .sidebar-nav {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    
    /* Glassmorphism effect */
    .sidebar-nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(147, 51, 234, 0.05) 0%, transparent 50%);
        z-index: 1;
        pointer-events: none;
    }
    
    .dark .sidebar-nav::before {
        background: 
            radial-gradient(circle at 20% 20%, rgba(66, 153, 225, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
    }
    
    .sidebar-content {
        position: relative;
        z-index: 2;
    }
    
    /* Enhanced Logo Section */
    .sidebar-logo {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 1.5rem 1rem;
        transition: all 0.3s ease;
    }
    
    .dark .sidebar-logo {
        background: rgba(0, 0, 0, 0.2);
    }
    
    .logo-container {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .logo-container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .logo-container:hover::before {
        opacity: 1;
    }
    
    .logo-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        background: rgba(59, 130, 246, 0.1);
    }
    
    .logo-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .logo-container:hover .logo-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }
    
    .logo-text {
        font-weight: 700;
        font-size: 1.2rem;
        background: linear-gradient(135deg, var(--text-primary), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: 0.5px;
    }
    
    .logo-subtitle {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
        margin-top: 2px;
    }
    
    /* Enhanced Navigation Items */
    .nav-section {
        padding: 1.5rem 1rem;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--border-color) transparent;
    }
    
    .nav-section::-webkit-scrollbar {
        width: 6px;
    }
    
    .nav-section::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .nav-section::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 3px;
    }
    
    .sidebar-nav-item {
        color: var(--text-secondary);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        margin-bottom: 0.5rem;
        border-radius: 12px;
        font-weight: 500;
    }
    
    .sidebar-nav-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .sidebar-nav-item:hover::before {
        left: 100%;
    }
    
    .sidebar-nav-item:hover {
        color: var(--text-primary);
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.05));
        transform: translateX(5px);
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }
    
    .sidebar-nav-item.active {
        color: #3b82f6;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(147, 51, 234, 0.1));
        border-left: 4px solid #3b82f6;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
    }
    
    .dark .sidebar-nav-item.active {
        box-shadow: 0 4px 15px rgba(66, 153, 225, 0.3);
    }
    
    .nav-icon {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    
    .sidebar-nav-item:hover .nav-icon {
        transform: scale(1.1);
        color: var(--accent-color);
    }
    
    /* Enhanced Dropdown Styles */
    .nav-dropdown {
        margin-bottom: 0.5rem;
    }
    
    .nav-dropdown-btn {
        color: var(--text-secondary);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        font-weight: 500;
        width: 100%;
        background: none;
        border: none;
        cursor: pointer;
        text-align: left;
    }
    
    .nav-dropdown-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .nav-dropdown-btn:hover::before {
        left: 100%;
    }
    
    .nav-dropdown-btn:hover {
        color: var(--text-primary);
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.05));
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }
    
    .nav-dropdown-btn.active {
        color: var(--text-primary);
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(147, 51, 234, 0.1));
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
    }
    
    .dropdown-icon {
        transition: transform 0.3s ease;
        margin-left: auto;
    }
    
    .nav-dropdown-btn.active .dropdown-icon {
        transform: rotate(90deg);
    }
    
    .nav-dropdown-content {
        margin-left: 2rem;
        margin-top: 0.5rem;
        border-left: 2px solid rgba(59, 130, 246, 0.2);
        padding-left: 1rem;
        position: relative;
    }
    
    .nav-dropdown-content::before {
        content: '';
        position: absolute;
        left: -2px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #3b82f6, #8b5cf6);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .nav-dropdown.open .nav-dropdown-content::before {
        opacity: 1;
    }
    
    .nav-dropdown-item {
        color: var(--text-secondary);
        transition: all 0.3s ease;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
        position: relative;
        padding: 0.5rem 1rem;
        display: block;
        text-decoration: none;
    }
    
    .nav-dropdown-item:hover {
        color: var(--text-primary);
        background: rgba(59, 130, 246, 0.1);
        transform: translateX(5px);
        text-decoration: none;
    }
    
    .nav-dropdown-item.active {
        color: #3b82f6;
        background: rgba(59, 130, 246, 0.15);
        border-left: 3px solid #3b82f6;
        padding-left: 13px;
        font-weight: 600;
    }
    
    /* Section Dividers */
    .nav-section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border-color), transparent);
        margin: 1.5rem 0;
        position: relative;
    }
    
    .nav-section-divider::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 6px;
        height: 6px;
        background: var(--accent-color);
        border-radius: 50%;
        opacity: 0.6;
    }
    
    .nav-section-title {
        color: var(--text-secondary);
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
    
    .nav-section-title::before {
        content: '';
        width: 4px;
        height: 4px;
        background: var(--accent-color);
        border-radius: 50%;
        margin-right: 8px;
    }
    
    /* Enhanced User Section */
    .user-section {
        padding: 1rem;
        border-top: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    
    .dark .user-section {
        background: rgba(0, 0, 0, 0.2);
    }
    
    .user-card {
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
    }
    
    .user-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .user-card:hover::before {
        opacity: 1;
    }
    
    .user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        background: rgba(59, 130, 246, 0.1);
    }
    
    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        margin-right: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .user-card:hover .user-avatar {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
    }
    
    .user-info {
        flex: 1;
        min-width: 0;
    }
    
    .user-name {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .user-role {
        color: var(--text-secondary);
        font-size: 0.75rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .user-status {
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
    
    /* Mobile Enhancements */
    .mobile-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid var(--border-color);
        display: none; /* Hidden by default */
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-secondary);
        z-index: 10;
        backdrop-filter: blur(10px);
    }
    
    .mobile-close-btn:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .sidebar-nav {
            width: 320px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 50;
        }
        
        .sidebar-logo {
            padding-right: 4rem; /* Space for close button */
        }
        
        .nav-section {
            padding-bottom: 2rem;
        }
        
        .mobile-close-btn {
            display: flex; /* Show only on mobile */
        }
    }
</style>

<!-- Enhanced Sidebar -->
<div class="sidebar-nav w-64 flex-shrink-0 md:flex md:flex-col sidebar-content"
     :class="{ 'hidden': !sidebarOpen }"
     x-show="sidebarOpen || window.innerWidth >= 768"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="transform -translate-x-full"
     x-transition:enter-end="transform translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="transform translate-x-0"
     x-transition:leave-end="transform -translate-x-full">
    
    <!-- Enhanced Logo Section -->
    <div class="sidebar-logo">
        <div class="logo-container">
            <div class="logo-icon">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="logo-text">Admin Panel</div>
                <div class="logo-subtitle">SMA Negeri 1</div>
            </div>
        </div>
        
        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="mobile-close-btn md:hidden">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Enhanced Navigation -->
    <div class="nav-section flex-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           @click="sidebarOpen = false">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Section Divider -->
        <div class="nav-section-divider"></div>
        <div class="nav-section-title">
            <span>Content Management</span>
        </div>

        <!-- Content Management -->
        <div class="nav-dropdown" x-data="{ open: {{ request()->routeIs('admin.posts.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="nav-dropdown-btn group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg w-full"
                    :class="{ 'active': open }">
                <div class="flex items-center">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Posts & Content</span>
                </div>
                <svg class="dropdown-icon h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="nav-dropdown-content">
                <a href="{{ route('admin.posts.slideshow') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.posts.slideshow*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    📸 Slideshow
                </a>
                <a href="{{ route('admin.posts.agenda') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.posts.agenda*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    📅 Agenda
                </a>
                <a href="{{ route('admin.posts.announcement') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.posts.announcement*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    📢 Pengumuman
                </a>
                <a href="{{ route('admin.posts.blog') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.posts.blog*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    📰 Berita & Blog
                </a>
            </div>
        </div>

        <!-- Media & Files -->
        <div class="nav-dropdown" x-data="{ open: {{ request()->routeIs('admin.gallery.*', 'admin.videos.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="nav-dropdown-btn group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg w-full"
                    :class="{ 'active': open }">
                <div class="flex items-center">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <span>Media & Files</span>
                </div>
                <svg class="dropdown-icon h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="nav-dropdown-content">
                <a href="{{ route('admin.gallery.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.gallery.index*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    🖼️ Photo Management
                </a>
                <a href="{{ route('admin.videos.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    🎬 Video Management
                </a>
            </div>
        </div>

        <!-- Section Divider -->
        <div class="nav-section-divider"></div>
        <div class="nav-section-title">
            <span>Academic Management</span>
        </div>

        <!-- Academic -->
        <div class="nav-dropdown" x-data="{ open: {{ request()->routeIs('admin.extracurriculars.*', 'admin.achievements.*', 'admin.teachers.*', 'admin.students.*', 'admin.calendar.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="nav-dropdown-btn group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg w-full"
                    :class="{ 'active': open }">
                <div class="flex items-center">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14v6.5" />
                    </svg>
                    <span>Academic Data</span>
                </div>
                <svg class="dropdown-icon h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="nav-dropdown-content">
                <a href="{{ route('admin.extracurriculars.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.extracurriculars.*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    🎯 Ekstrakurikuler
                </a>
                <a href="{{ route('admin.teachers.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    👨‍🏫 Guru & Staff
                </a>
                <a href="{{ route('admin.students.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    👨‍🎓 Siswa
                </a>
                <a href="{{ route('admin.calendar.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.calendar.*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    📅 Kalender Akademik
                </a>
            </div>
        </div>

        <!-- QR Attendance Management -->
        <div class="nav-dropdown" x-data="{ open: {{ request()->routeIs('admin.qr-attendance.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="nav-dropdown-btn group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg w-full"
                    :class="{ 'active': open }">
                <div class="flex items-center">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    <span>Absensi QR Code</span>
                </div>
                <svg class="dropdown-icon h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="nav-dropdown-content">
                <a href="{{ route('admin.qr-attendance.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.qr-attendance.index') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    🔲 Kelola QR Code
                </a>
                <a href="{{ route('admin.qr-attendance.logs') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.qr-attendance.logs') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    📋 Log Absensi
                    @php
                        $todayAttendanceCount = \App\Models\AttendanceLog::whereDate('attendance_date', today())->count();
                    @endphp
                    @if($todayAttendanceCount > 0)
                        <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            {{ $todayAttendanceCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.qr-attendance.statistics') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.qr-attendance.statistics') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    📊 Statistik Absensi
                </a>
            </div>
        </div>

        <!-- Section Divider -->
        <div class="nav-section-divider"></div>
        <div class="nav-section-title">
            <span>Management User</span>
        </div>

        <!-- User Management -->
        <div class="nav-dropdown" x-data="{ open: {{ request()->routeIs('admin.users.*', 'admin.student-registrations.*') ? 'true' : 'false' }} }">
            <button @click="open = !open" 
                    class="nav-dropdown-btn group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg w-full"
                    :class="{ 'active': open }">
                <div class="flex items-center">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <span>Management User</span>
                </div>
                <svg class="dropdown-icon h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="nav-dropdown-content">
                <a href="{{ route('admin.users.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    👥 Kelola User
                </a>
                <a href="{{ route('admin.student-registrations.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('admin.student-registrations.*') ? 'active' : '' }}"
                   @click="sidebarOpen = false">
                    📝 Pendaftaran Akun Siswa
                    @php
                        $pendingCount = \App\Models\User::where('status', 'pending')->whereHas('roles', function($q) {
                            $q->where('name', 'student');
                        })->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Section Divider -->
        <div class="nav-section-divider"></div>
        <div class="nav-section-title">
            <span>System</span>
        </div>

        <!-- Settings -->
        <a href="{{ route('admin.settings') }}" 
           class="sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings*') ? 'active' : '' }}"
           @click="sidebarOpen = false">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Settings</span>
        </a>
    </div>

    <!-- Enhanced User Section -->
    <div class="user-section">
        <div class="user-card">
            <img class="user-avatar" 
                 src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF' }}" 
                 alt="{{ auth()->user()->name }}">
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Super Administrator</div>
            </div>
            <div class="user-status"></div>
        </div>
    </div>
</div>