<?php
// resources/views/layouts/teacher/navbar.blade.php - Enhanced Teacher Navbar for Mobile
?>

<!-- Enhanced CSS for Mobile Compatibility -->
<style>
    /* Mobile-first responsive navbar styles */
    .teacher-navbar {
        width: 100%;
        position: relative;
        z-index: 30;
        flex-shrink: 0;
        height: 4rem;
        background-color: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        display: flex;
    }
    
    .dark .teacher-navbar {
        background-color: #1f2937;
        border-bottom-color: #374151;
    }
    
    .navbar-container {
        flex: 1;
        display: flex;
        justify-content: space-between;
        padding: 0 1rem;
        align-items: center;
    }
    
    @media (min-width: 640px) {
        .navbar-container {
            padding: 0 1.5rem;
        }
    }
    
    .navbar-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .mobile-menu-btn {
        border-right: 1px solid #e5e7eb;
        padding-right: 1rem;
        color: #6b7280;
        outline: none;
        border: none;
        background: none;
        cursor: pointer;
        display: block;
    }
    
    .dark .mobile-menu-btn {
        border-right-color: #374151;
        color: #9ca3af;
    }
    
    .mobile-menu-btn:focus {
        outline: 2px solid #10b981;
        outline-offset: -2px;
    }
    
    @media (min-width: 768px) {
        .mobile-menu-btn {
            display: none;
        }
    }
    
    .page-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .dark .page-title {
        color: #ffffff;
    }
    
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .dark-mode-btn {
        background-color: #f3f4f6;
        padding: 0.5rem;
        border-radius: 0.5rem;
        color: #6b7280;
        border: none;
        cursor: pointer;
        outline: none;
        transition: all 0.2s;
    }
    
    .dark .dark-mode-btn {
        background-color: #374151;
        color: #9ca3af;
    }
    
    .dark-mode-btn:hover {
        color: #374151;
    }
    
    .dark .dark-mode-btn:hover {
        color: #e5e7eb;
    }
    
    .dark-mode-btn:focus {
        outline: 2px solid #10b981;
    }
    
    .notification-btn {
        background-color: #ffffff;
        padding: 0.25rem;
        border-radius: 9999px;
        color: #9ca3af;
        border: none;
        cursor: pointer;
        outline: none;
        position: relative;
        transition: all 0.2s;
    }
    
    .dark .notification-btn {
        background-color: #1f2937;
    }
    
    .notification-btn:hover {
        color: #6b7280;
    }
    
    .notification-btn:focus {
        outline: 2px solid #10b981;
        outline-offset: 2px;
    }
    
    .notification-badge {
        position: absolute;
        top: 0;
        right: 0;
        display: block;
        height: 0.5rem;
        width: 0.5rem;
        border-radius: 9999px;
        background-color: #10b981;
    }
    
    .user-dropdown {
        position: relative;
    }
    
    .user-btn {
        max-width: 12rem;
        background-color: #ffffff;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        outline: none;
        transition: all 0.2s;
    }
    
    .dark .user-btn {
        background-color: #1f2937;
    }
    
    .user-btn:focus {
        outline: 2px solid #10b981;
        outline-offset: 2px;
    }
    
    .user-avatar {
        height: 2rem;
        width: 2rem;
        border-radius: 9999px;
    }
    
    .user-name {
        display: none;
        margin-left: 0.75rem;
        color: #374151;
        font-weight: 500;
    }
    
    .dark .user-name {
        color: #d1d5db;
    }
    
    @media (min-width: 768px) {
        .user-name {
            display: block;
        }
    }
    
    .user-chevron {
        display: none;
        margin-left: 0.5rem;
        height: 1rem;
        width: 1rem;
        color: #9ca3af;
    }
    
    @media (min-width: 768px) {
        .user-chevron {
            display: block;
        }
    }
    
    .user-menu {
        position: absolute;
        right: 0;
        margin-top: 0.5rem;
        width: 12rem;
        background-color: #ffffff;
        border-radius: 0.375rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        padding: 0.25rem 0;
        border: 1px solid #e5e7eb;
        z-index: 9999;
        display: none;
    }
    
    .dark .user-menu {
        background-color: #1f2937;
        border-color: #374151;
    }
    
    .user-menu.show {
        display: block;
    }
    
    .user-menu-item {
        display: block;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .dark .user-menu-item {
        color: #d1d5db;
    }
    
    .user-menu-item:hover {
        background-color: #f3f4f6;
        text-decoration: none;
    }
    
    .dark .user-menu-item:hover {
        background-color: #374151;
    }
    
    .user-menu-divider {
        border-top: 1px solid #f3f4f6;
        margin: 0.25rem 0;
    }
    
    .dark .user-menu-divider {
        border-top-color: #374151;
    }
    
    .logout-btn {
        display: block;
        width: 100%;
        text-align: left;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: #374151;
        background: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .dark .logout-btn {
        color: #d1d5db;
    }
    
    .logout-btn:hover {
        background-color: #f3f4f6;
    }
    
    .dark .logout-btn:hover {
        background-color: #374151;
    }
    
    /* Icon styles */
    .icon {
        height: 1.5rem;
        width: 1.5rem;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    
    .icon-sm {
        height: 1.25rem;
        width: 1.25rem;
    }
    
    .icon-xs {
        height: 1rem;
        width: 1rem;
    }
</style>

<header class="teacher-navbar">
    <div class="navbar-container">
        <!-- Left Side -->
        <div class="navbar-left">
            <!-- Mobile menu button -->
            <button onclick="toggleSidebar()" class="mobile-menu-btn">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>

            <!-- Page Title -->
            <h1 class="page-title">
                {{ $pageTitle ?? 'Teacher Dashboard' }}
            </h1>
        </div>

        <!-- Right Side -->
        <div class="navbar-right">
            <!-- Dark Mode Toggle -->
            <button onclick="toggleDarkMode()" class="dark-mode-btn" title="Toggle Dark Mode">
                <svg id="sun-icon" class="icon-sm" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                </svg>
                <svg id="moon-icon" class="icon-sm" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                </svg>
            </button>

            <!-- Notifications -->
            <div class="relative">
                <button class="notification-btn">
                    <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="notification-badge"></span>
                </button>
            </div>

            <!-- User dropdown -->
            <div class="user-dropdown">
                <button onclick="toggleUserMenu()" class="user-btn">
                    <img class="user-avatar" 
                         src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=059669&background=D1FAE5' }}" 
                         alt="{{ auth()->user()->name }}">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <svg class="user-chevron" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
                
                <!-- User dropdown menu -->
                <div id="user-menu" class="user-menu">
                    <a href="{{ route('profile.edit') }}" class="user-menu-item">
                        <i class="fas fa-user-cog" style="margin-right: 0.5rem;"></i>Your Profile
                    </a>
                    <a href="#" class="user-menu-item">
                        <i class="fas fa-cog" style="margin-right: 0.5rem;"></i>Settings
                    </a>
                    <a href="{{ route('home') }}" class="user-menu-item">
                        <i class="fas fa-home" style="margin-right: 0.5rem;"></i>Home
                    </a>
                    <div class="user-menu-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt" style="margin-right: 0.5rem;"></i>Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Enhanced JavaScript for Mobile Compatibility -->
<script>
    // Global variables
    let sidebarOpen = false;
    let darkMode = localStorage.getItem('darkMode') === 'true';
    
    // Initialize dark mode
    document.addEventListener('DOMContentLoaded', function() {
        if (darkMode) {
            document.documentElement.classList.add('dark');
            document.getElementById('sun-icon').style.display = 'none';
            document.getElementById('moon-icon').style.display = 'block';
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-dropdown')) {
                document.getElementById('user-menu').classList.remove('show');
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebarOpen = true;
                updateSidebarVisibility();
            } else {
                sidebarOpen = false;
                updateSidebarVisibility();
            }
        });
        
        // Initial sidebar state
        if (window.innerWidth >= 768) {
            sidebarOpen = true;
        }
        updateSidebarVisibility();
    });
    
    // Toggle sidebar function
    function toggleSidebar() {
        sidebarOpen = !sidebarOpen;
        updateSidebarVisibility();
    }
    
    // Update sidebar visibility
    function updateSidebarVisibility() {
        const sidebar = document.querySelector('.sidebar-nav');
        if (sidebar) {
            if (sidebarOpen || window.innerWidth >= 768) {
                sidebar.style.display = 'flex';
                sidebar.classList.remove('hidden');
            } else {
                sidebar.style.display = 'none';
                sidebar.classList.add('hidden');
            }
        }
    }
    
    // Toggle dark mode function
    function toggleDarkMode() {
        darkMode = !darkMode;
        localStorage.setItem('darkMode', darkMode);
        
        if (darkMode) {
            document.documentElement.classList.add('dark');
            document.getElementById('sun-icon').style.display = 'none';
            document.getElementById('moon-icon').style.display = 'block';
        } else {
            document.documentElement.classList.remove('dark');
            document.getElementById('sun-icon').style.display = 'block';
            document.getElementById('moon-icon').style.display = 'none';
        }
    }
    
    // Toggle user menu function
    function toggleUserMenu() {
        const userMenu = document.getElementById('user-menu');
        userMenu.classList.toggle('show');
    }
    
    // Make functions globally available
    window.toggleSidebar = toggleSidebar;
    window.toggleDarkMode = toggleDarkMode;
    window.toggleUserMenu = toggleUserMenu;
</script>