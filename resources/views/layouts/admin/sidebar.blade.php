<?php
// resources/views/layouts/admin/sidebar.blade.php
?>
<style>
    :root {
        --primary-color: #1a202c;
        --secondary-color: #3182ce;
        --accent-color: #4299e1;
        --sidebar-bg: linear-gradient(180deg, #1a202c 0%, #2d3748 100%);
        --sidebar-hover: rgba(66, 153, 225, 0.1);
        --sidebar-active: rgba(66, 153, 225, 0.2);
        --glass-effect: rgba(255, 255, 255, 0.05);
    }
    
    /* Enhanced Sidebar Styling */
    .sidebar-enhanced {
        background: var(--sidebar-bg);
        backdrop-filter: blur(20px);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .sidebar-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(66, 153, 225, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
        z-index: 1;
        pointer-events: none;
    }
    
    .sidebar-content {
        position: relative;
        z-index: 2;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
    
    /* Enhanced Logo Section */
    .logo-section {
        padding: 1.5rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
    }
    
    .logo-container {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-radius: 12px;
        background: var(--glass-effect);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .logo-container:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .logo-image {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        transition: all 0.3s ease;
    }
    
    .logo-container:hover .logo-image {
        transform: rotate(10deg) scale(1.1);
    }
    
    .logo-text {
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
    }
    
    /* Enhanced Navigation */
    .nav-section {
        flex: 1;
        padding: 1.5rem 1rem;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
    }
    
    .nav-section::-webkit-scrollbar {
        width: 6px;
    }
    
    .nav-section::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .nav-section::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }
    
    .nav-section::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .nav-item {
        margin-bottom: 0.5rem;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 0.875rem 1rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        border-radius: 12px;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;
    }
    
    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .nav-link:hover::before {
        left: 100%;
    }
    
    .nav-link:hover {
        color: white;
        background: var(--sidebar-hover);
        transform: translateX(5px);
        border-color: rgba(255, 255, 255, 0.1);
    }
    
    .nav-link.active {
        color: white;
        background: var(--sidebar-active);
        border-color: rgba(66, 153, 225, 0.3);
        box-shadow: 0 4px 15px rgba(66, 153, 225, 0.2);
    }
    
    .nav-link.active::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #3b82f6, #8b5cf6);
        border-radius: 0 2px 2px 0;
    }
    
    .nav-icon {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    
    .nav-link:hover .nav-icon {
        transform: scale(1.1);
    }
    
    /* Enhanced Dropdown Menus */
    .nav-dropdown-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 0.875rem 1rem;
        color: rgba(255, 255, 255, 0.8);
        background: none;
        border: none;
        border-radius: 12px;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;
        cursor: pointer;
    }
    
    .nav-dropdown-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .nav-dropdown-btn:hover::before {
        left: 100%;
    }
    
    .nav-dropdown-btn:hover {
        color: white;
        background: var(--sidebar-hover);
        transform: translateX(5px);
        border-color: rgba(255, 255, 255, 0.1);
    }
    
    .nav-dropdown-btn.open {
        color: white;
        background: var(--sidebar-active);
        border-color: rgba(66, 153, 225, 0.2);
    }
    
    .nav-dropdown-icon {
        transition: transform 0.3s ease;
        margin-left: 8px;
    }
    
    .nav-dropdown-btn.open .nav-dropdown-icon {
        transform: rotate(90deg);
    }
    
    .nav-dropdown-content {
        margin-left: 2rem;
        margin-top: 0.5rem;
        border-left: 2px solid rgba(255, 255, 255, 0.1);
        padding-left: 1rem;
    }
    
    .nav-dropdown-item {
        display: block;
        padding: 0.625rem 1rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .nav-dropdown-item:hover {
        color: white;
        background: rgba(255, 255, 255, 0.08);
        transform: translateX(5px);
    }
    
    .nav-dropdown-item.active {
        color: #60a5fa;
        background: rgba(96, 165, 250, 0.1);
        border-left: 3px solid #60a5fa;
        padding-left: 13px;
    }
    
    /* Enhanced User Profile Section */
    .user-profile-section {
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.03);
    }
    
    .user-profile-card {
        display: flex;
        align-items: center;
        padding: 0.875rem;
        border-radius: 12px;
        background: var(--glass-effect);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
    }
    
    .user-profile-card:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    .user-avatar-large {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-weight: 700;
        color: white;
        transition: all 0.3s ease;
    }
    
    .user-profile-card:hover .user-avatar-large {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }
    
    .user-info {
        flex: 1;
        min-width: 0;
    }
    
    .user-name {
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .user-role {
        color: rgba(255, 255, 255, 0.6);
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
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Mobile Enhancements */
    .mobile-sidebar {
        background: var(--sidebar-bg);
        backdrop-filter: blur(20px);
    }
    
    .mobile-sidebar-overlay {
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }
    
    /* Section Dividers */
    .nav-section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        margin: 1.5rem 0;
    }
    
    .nav-section-title {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1rem;
        padding: 0 1rem;
    }
    
    /* Notification Badge */
    .nav-badge {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: auto;
        min-width: 18px;
        text-align: center;
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% { transform: translateY(0); }
        40%, 43% { transform: translateY(-8px); }
        70% { transform: translateY(-4px); }
        90% { transform: translateY(-2px); }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .sidebar-enhanced {
            width: 280px;
        }
        
        .nav-link {
            padding: 1rem;
        }
        
        .nav-dropdown-btn {
            padding: 1rem;
        }
    }
</style>

<div class="flex" x-data="{ sidebarOpen: false }">
    <!-- Enhanced Sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64">
            <div class="sidebar-enhanced">
                <div class="sidebar-content">
                    <!-- Enhanced Logo Section -->
                    <div class="logo-section">
                        <div class="logo-container">
                            <div class="logo-image">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <span class="logo-text">Admin Panel</span>
                        </div>
                    </div>

                    <!-- Enhanced Navigation -->
                    <div class="nav-section">
                        @php
                        $menus = [
                            [
                                'title' => 'Dashboard',
                                'route' => 'admin.dashboard',
                                'icon' => 'home',
                                'permission' => null,
                                'badge' => null
                            ],
                            [
                                'section' => 'CONTENT'
                            ],
                            [
                                'title' => 'Content Management',
                                'icon' => 'document-text',
                                'permission' => 'posts.read',
                                'children' => [
                                    ['title' => 'Slideshow', 'route' => 'admin.posts.slideshow'],
                                    ['title' => 'Agenda', 'route' => 'admin.posts.agenda'],
                                    ['title' => 'Pengumuman', 'route' => 'admin.posts.announcement'],
                                    ['title' => 'Berita & Blog', 'route' => 'admin.posts.blog'],
                                ]
                            ],
                            [
                                'title' => 'Media & Files',
                                'icon' => 'folder',
                                'permission' => 'posts.create',
                                'children' => [
                                    ['title' => 'Downloads', 'route' => 'admin.downloads.index'],
                                    ['title' => 'Gallery', 'route' => 'admin.gallery.index'],
                                ]
                            ],
                            [
                                'section' => 'ACADEMIC'
                            ],
                            [
                                'title' => 'Academic',
                                'icon' => 'academic-cap',
                                'permission' => 'academic.manage',
                                'children' => [
                                    ['title' => 'Ekstrakurikuler', 'route' => 'admin.extracurriculars.index'],
                                    ['title' => 'Prestasi', 'route' => 'admin.achievements.index'],
                                    ['title' => 'Guru & Staff', 'route' => 'admin.teachers.index'],
                                    ['title' => 'Siswa', 'route' => 'admin.students.index'],
                                ]
                            ],
                            [
                                'section' => 'SYSTEM'
                            ],
                            [
                                'title' => 'System',
                                'icon' => 'cog',
                                'permission' => 'system.admin',
                                'children' => [
                                    ['title' => 'Users', 'route' => 'admin.users.index'],
                                    ['title' => 'Roles & Permissions', 'route' => 'admin.roles.index'],
                                    ['title' => 'System Settings', 'route' => 'admin.settings'],
                                    ['title' => 'Profile', 'route' => 'admin.profile'],
                                ]
                            ]
                        ];
                        @endphp

                        @foreach($menus as $menu)
                            @if(isset($menu['section']))
                                <!-- Section Divider -->
                                <div class="nav-section-divider"></div>
                                <div class="nav-section-title">{{ $menu['section'] }}</div>
                            @elseif(!isset($menu['permission']) || auth()->user()->can($menu['permission']))
                                <div class="nav-item" x-data="{ open: {{ request()->routeIs(isset($menu['children']) ? collect($menu['children'])->pluck('route')->map(fn($r) => $r.'*')->implode(',') : $menu['route'].'*') ? 'true' : 'false' }} }">
                                    @if(isset($menu['children']))
                                        <!-- Parent Menu with Children -->
                                        <button @click="open = !open" class="nav-dropdown-btn" :class="{ 'open': open }">
                                            <div class="flex items-center">
                                                @php
                                                    $iconName = $menu['icon'];
                                                    $iconSvg = match($iconName) {
                                                        'document-text' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>',
                                                        'academic-cap' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14v6.5"></path>',
                                                        'folder' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>',
                                                        'book-open' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>',
                                                        'cog' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
                                                        'home' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
                                                        default => '<circle cx="12" cy="12" r="10"></circle>'
                                                    };
                                                @endphp
                                                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    {!! $iconSvg !!}
                                                </svg>
                                                <span>{{ $menu['title'] }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                @if(isset($menu['badge']))
                                                    <span class="nav-badge">{{ $menu['badge'] }}</span>
                                                @endif
                                                <svg class="nav-dropdown-icon w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </button>
                                        
                                        <!-- Enhanced Children Menu -->
                                        <div x-show="open" 
                                             x-transition:enter="transition ease-out duration-200" 
                                             x-transition:enter-start="opacity-0 transform -translate-y-2" 
                                             x-transition:enter-end="opacity-100 transform translate-y-0" 
                                             x-transition:leave="transition ease-in duration-150" 
                                             x-transition:leave-start="opacity-100 transform translate-y-0" 
                                             x-transition:leave-end="opacity-0 transform -translate-y-2" 
                                             class="nav-dropdown-content">
                                            @foreach($menu['children'] as $child)
                                                <a href="{{ route($child['route']) }}" 
                                                   class="nav-dropdown-item {{ request()->routeIs($child['route'].'*') ? 'active' : '' }}">
                                                    {{ $child['title'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- Enhanced Single Menu Item -->
                                        <a href="{{ route($menu['route']) }}" 
                                           class="nav-link {{ request()->routeIs($menu['route'].'*') ? 'active' : '' }}">
                                            @php
                                                $iconName = $menu['icon'];
                                                $iconSvg = match($iconName) {
                                                    'home' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
                                                    default => '<circle cx="12" cy="12" r="10"></circle>'
                                                };
                                            @endphp
                                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                {!! $iconSvg !!}
                                            </svg>
                                            <span>{{ $menu['title'] }}</span>
                                            @if(isset($menu['badge']))
                                                <span class="nav-badge">{{ $menu['badge'] }}</span>
                                            @endif
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Enhanced User Profile Section -->
                    <div class="user-profile-section">
                        <div class="user-profile-card" @click="$dispatch('open-modal', 'user-profile')">
                            <div class="user-avatar-large">
                                {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 2)) }}
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                                <div class="user-role">{{ auth()->user()->role ?? 'Super Admin' }}</div>
                            </div>
                            <div class="user-status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Mobile sidebar overlay -->
    <div x-show="sidebarOpen" 
         class="fixed inset-0 z-40 md:hidden" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0">
        <div class="mobile-sidebar-overlay fixed inset-0" @click="sidebarOpen = false"></div>
    </div>

    <!-- Enhanced Mobile sidebar -->
    <div x-show="sidebarOpen" 
         class="fixed inset-y-0 left-0 z-50 w-64 mobile-sidebar md:hidden" 
         x-transition:enter="transition ease-in-out duration-300 transform" 
         x-transition:enter-start="-translate-x-full" 
         x-transition:enter-end="translate-x-0" 
         x-transition:leave="transition ease-in-out duration-300 transform" 
         x-transition:leave-start="translate-x-0" 
         x-transition:leave-end="-translate-x-full">
        
        <div class="sidebar-content">
            <!-- Mobile Logo Section with Close Button -->
            <div class="logo-section">
                <div class="flex items-center justify-between">
                    <div class="logo-container flex-1">
                        <div class="logo-image">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="logo-text">Admin Panel</span>
                    </div>
                    <button @click="sidebarOpen = false" 
                            class="ml-4 flex items-center justify-center h-10 w-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-20 hover:bg-white hover:bg-opacity-10 transition-all duration-200">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation (same structure as desktop) -->
            <div class="nav-section">
                @foreach($menus as $menu)
                    @if(isset($menu['section']))
                        <!-- Section Divider -->
                        <div class="nav-section-divider"></div>
                        <div class="nav-section-title">{{ $menu['section'] }}</div>
                    @elseif(!isset($menu['permission']) || auth()->user()->can($menu['permission']))
                        <div class="nav-item" x-data="{ open: {{ request()->routeIs(isset($menu['children']) ? collect($menu['children'])->pluck('route')->map(fn($r) => $r.'*')->implode(',') : $menu['route'].'*') ? 'true' : 'false' }} }">
                            @if(isset($menu['children']))
                                <!-- Parent Menu with Children -->
                                <button @click="open = !open" class="nav-dropdown-btn" :class="{ 'open': open }">
                                    <div class="flex items-center">
                                        @php
                                            $iconName = $menu['icon'];
                                            $iconSvg = match($iconName) {
                                                'document-text' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>',
                                                'academic-cap' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14v6.5"></path>',
                                                'folder' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>',
                                                'book-open' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>',
                                                'cog' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
                                                'home' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
                                                default => '<circle cx="12" cy="12" r="10"></circle>'
                                            };
                                        @endphp
                                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $iconSvg !!}
                                        </svg>
                                        <span>{{ $menu['title'] }}</span>
                                        @if(isset($menu['badge']))
                                            <span class="nav-badge">{{ $menu['badge'] }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center">
                                        @if(isset($menu['badge']))
                                            <span class="nav-badge">{{ $menu['badge'] }}</span>
                                        @endif
                                        <svg class="nav-dropdown-icon w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </button>
                                
                                <!-- Enhanced Children Menu -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200" 
                                     x-transition:enter-start="opacity-0 transform -translate-y-2" 
                                     x-transition:enter-end="opacity-100 transform translate-y-0" 
                                     x-transition:leave="transition ease-in duration-150" 
                                     x-transition:leave-start="opacity-100 transform translate-y-0" 
                                     x-transition:leave-end="opacity-0 transform -translate-y-2" 
                                     class="nav-dropdown-content">
                                    @foreach($menu['children'] as $child)
                                        <a href="{{ route($child['route']) }}" 
                                           class="nav-dropdown-item {{ request()->routeIs($child['route'].'*') ? 'active' : '' }}"
                                           @click="sidebarOpen = false">
                                            {{ $child['title'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <!-- Enhanced Single Menu Item -->
                                <a href="{{ route($menu['route']) }}" 
                                   class="nav-link {{ request()->routeIs($menu['route'].'*') ? 'active' : '' }}"
                                   @click="sidebarOpen = false">
                                    @php
                                        $iconName = $menu['icon'];
                                        $iconSvg = match($iconName) {
                                            'home' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
                                            default => '<circle cx="12" cy="12" r="10"></circle>'
                                        };
                                    @endphp
                                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $iconSvg !!}
                                    </svg>
                                    <span>{{ $menu['title'] }}</span>
                                    @if(isset($menu['badge']))
                                        <span class="nav-badge">{{ $menu['badge'] }}</span>
                                    @endif
                                </a>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Mobile User Profile Section -->
            <div class="user-profile-section">
                <div class="user-profile-card" @click="$dispatch('open-modal', 'user-profile')">
                    <div class="user-avatar-large">
                        {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 2)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                        <div class="user-role">{{ auth()->user()->role ?? 'Super Admin' }}</div>
                    </div>
                    <div class="user-status"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced sidebar interactions
            const navLinks = document.querySelectorAll('.nav-link, .nav-dropdown-btn');
            
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.style.background = 'rgba(66, 153, 225, 0.15)';
                    }
                });
                
                link.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active') && !this.classList.contains('open')) {
                        this.style.background = '';
                    }
                });
            });
            
            // Add ripple effect to sidebar links
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Create ripple effect
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
                        background: rgba(255, 255, 255, 0.2);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: sidebarRipple 0.6s ease-out;
                        pointer-events: none;
                        z-index: 1;
                    `;
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            
            // Add ripple animation CSS for sidebar
            const sidebarStyle = document.createElement('style');
            sidebarStyle.textContent = `
                @keyframes sidebarRipple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
                
                .nav-link, .nav-dropdown-btn {
                    position: relative;
                    overflow: hidden;
                }
            `;
            document.head.appendChild(sidebarStyle);
            
            // Auto-close mobile sidebar when clicking on a link
            const mobileNavLinks = document.querySelectorAll('.mobile-sidebar .nav-link, .mobile-sidebar .nav-dropdown-item');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Close mobile sidebar after a short delay
                    setTimeout(() => {
                        window.dispatchEvent(new CustomEvent('close-mobile-sidebar'));
                    }, 200);
                });
            });
            
            // Enhanced user profile interactions
            const userProfileCard = document.querySelector('.user-profile-card');
            if (userProfileCard) {
                userProfileCard.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px) scale(1.02)';
                    this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.2)';
                });
                
                userProfileCard.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '';
                });
            }
            
            // Smooth scroll for sidebar navigation
            const sidebarNav = document.querySelector('.nav-section');
            if (sidebarNav) {
                let isScrolling = false;
                
                sidebarNav.addEventListener('wheel', function(e) {
                    if (!isScrolling) {
                        isScrolling = true;
                        this.style.scrollBehavior = 'smooth';
                        
                        setTimeout(() => {
                            isScrolling = false;
                            this.style.scrollBehavior = 'auto';
                        }, 100);
                    }
                });
            }
            
            // Add active state animation
            const activeLinks = document.querySelectorAll('.nav-link.active, .nav-dropdown-item.active');
            activeLinks.forEach(link => {
                link.style.animation = 'slideInFromLeft 0.3s ease-out';
            });
            
            // Add slide-in animation CSS
            const activeStyle = document.createElement('style');
            activeStyle.textContent = `
                @keyframes slideInFromLeft {
                    from {
                        transform: translateX(-10px);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
            `;
            document.head.appendChild(activeStyle);
        });
        
        // Listen for custom events
        window.addEventListener('close-mobile-sidebar', function() {
            // This would be handled by Alpine.js
            // Just here for completeness
        });
    </script>
</div>