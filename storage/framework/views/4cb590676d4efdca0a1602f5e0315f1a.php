<?php
// resources/views/layouts/teacher/sidebar.blade.php - Teacher Limited Access Sidebar
?>
<style>
    /* Enhanced Sidebar Styles (Same as Admin but with Teacher Green Theme) */
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
    
    /* Glassmorphism effect with green theme */
    .sidebar-nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(5, 150, 105, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
        z-index: 1;
        pointer-events: none;
    }
    
    .dark .sidebar-nav::before {
        background: 
            radial-gradient(circle at 20% 20%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(52, 211, 153, 0.1) 0%, transparent 50%);
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
        background: radial-gradient(circle, rgba(5, 150, 105, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .logo-container:hover::before {
        opacity: 1;
    }
    
    .logo-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.15);
        background: rgba(5, 150, 105, 0.1);
    }
    
    .logo-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #059669, #10b981);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }
    
    .logo-container:hover .logo-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
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
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .sidebar-nav-item:hover::before {
        left: 100%;
    }
    
    .sidebar-nav-item:hover {
        color: var(--text-primary);
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.1), rgba(16, 185, 129, 0.05));
        transform: translateX(5px);
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.1);
    }
    
    .sidebar-nav-item.active {
        color: #059669;
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.15), rgba(16, 185, 129, 0.1));
        border-left: 4px solid #059669;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.2);
    }
    
    .dark .sidebar-nav-item.active {
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .nav-icon {
        width: 16px;
        height: 16px;
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
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .nav-dropdown-btn:hover::before {
        left: 100%;
    }
    
    .nav-dropdown-btn:hover {
        color: var(--text-primary);
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.1), rgba(16, 185, 129, 0.05));
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.1);
    }
    
    .nav-dropdown-btn.active {
        color: var(--text-primary);
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.15), rgba(16, 185, 129, 0.1));
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.2);
    }
    
    .dropdown-icon {
        width: 14px;
        height: 14px;
        transition: transform 0.3s ease;
        margin-left: auto;
        flex-shrink: 0;
    }
    
    .nav-dropdown-btn.active .dropdown-icon {
        transform: rotate(90deg);
    }
    
    .rotate-90 {
        transform: rotate(90deg);
    }
    
    .nav-dropdown-content {
        margin-left: 2rem;
        margin-top: 0.5rem;
        border-left: 2px solid rgba(5, 150, 105, 0.2);
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
        background: linear-gradient(180deg, #059669, #10b981);
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
        background: rgba(5, 150, 105, 0.1);
        transform: translateX(5px);
        text-decoration: none;
    }
    
    .nav-dropdown-item.active {
        color: #059669;
        background: rgba(5, 150, 105, 0.15);
        border-left: 3px solid #059669;
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
        background: radial-gradient(circle, rgba(5, 150, 105, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .user-card:hover::before {
        opacity: 1;
    }
    
    .user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.15);
        background: rgba(5, 150, 105, 0.1);
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
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3);
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
    
    /* Desktop Sidebar Positioning */
    @media (min-width: 769px) {
        .sidebar-nav {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 16rem; /* w-64 = 256px = 16rem */
            z-index: 10; /* Lower z-index so content can be above */
        }
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

<!-- Enhanced Teacher Sidebar -->
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
                <div class="logo-text">Teacher Panel</div>
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
        <a href="<?php echo e(route('teacher.dashboard')); ?>" 
           class="sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('teacher.dashboard') ? 'active' : ''); ?>"
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

            <!-- Posts & Content -->
            <div class="nav-dropdown" x-data="{ open: <?php echo e(request()->routeIs('teacher.posts.*') ? 'true' : 'false'); ?> }">
                <button @click="open = !open" 
                        class="nav-dropdown-btn flex items-center px-4 py-3 text-sm font-medium rounded-lg w-full <?php echo e(request()->routeIs('teacher.posts.*') ? 'active' : ''); ?>"
                        :class="{ 'active': open }">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <span>Posts & Content</span>
                    <svg class="dropdown-icon" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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
                <a href="<?php echo e(route('teacher.posts.announcement')); ?>" 
                   class="nav-dropdown-item <?php echo e(request()->routeIs('teacher.posts.announcement*') ? 'active' : ''); ?>"
                   @click="sidebarOpen = false">
                    📢 Pengumuman
                </a>
                <a href="<?php echo e(route('teacher.posts.blog.index')); ?>" 
                   class="nav-dropdown-item <?php echo e(request()->routeIs('teacher.posts.blog*') ? 'active' : ''); ?>"
                   @click="sidebarOpen = false">
                    📰 Berita & Blog
                </a>
            </div>
            </div>

            <!-- Learning Management -->
            <div class="nav-dropdown" x-data="{ open: <?php echo e(request()->routeIs('teacher.learning.*') ? 'true' : 'false'); ?> }">
                <button @click="open = !open" 
                        class="nav-dropdown-btn flex items-center px-4 py-3 text-sm font-medium rounded-lg w-full <?php echo e(request()->routeIs('teacher.learning.*') ? 'active' : ''); ?>"
                        :class="{ 'active': open }">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Learning Management</span>
                    <svg class="dropdown-icon" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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
                <a href="<?php echo e(route('teacher.learning.materials.index')); ?>" 
                   class="nav-dropdown-item <?php echo e(request()->routeIs('teacher.learning.materials*') ? 'active' : ''); ?>"
                   @click="sidebarOpen = false">
                    📚 Materi Pembelajaran
                </a>
                <a href="<?php echo e(route('teacher.learning.assignments.index')); ?>" 
                   class="nav-dropdown-item <?php echo e(request()->routeIs('teacher.learning.assignments*') ? 'active' : ''); ?>"
                   @click="sidebarOpen = false">
                    📝 Tugas & Latihan
                </a>
            </div>
            </div>

            <!-- Assessment & Grading -->
            <div class="nav-dropdown" x-data="{ open: <?php echo e(request()->routeIs('teacher.assessment.*') ? 'true' : 'false'); ?> }">
                <button @click="open = !open" 
                        class="nav-dropdown-btn flex items-center px-4 py-3 text-sm font-medium rounded-lg w-full <?php echo e(request()->routeIs('teacher.assessment.*') ? 'active' : ''); ?>"
                        :class="{ 'active': open }">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span>Assessment & Grading</span>
                    <svg class="dropdown-icon" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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
                <a href="<?php echo e(route('teacher.assessment.index')); ?>" 
                   class="nav-dropdown-item <?php echo e(request()->routeIs('teacher.assessment.index') || request()->routeIs('teacher.assessment.show') || request()->routeIs('teacher.assessment.edit') || request()->routeIs('teacher.assessment.create') ? 'active' : ''); ?>"
                   @click="sidebarOpen = false">
                    🎯 Ujian & Kuis
                </a>
                <a href="<?php echo e(route('teacher.assessment.grades')); ?>" 
                   class="nav-dropdown-item <?php echo e(request()->routeIs('teacher.assessment.grades') ? 'active' : ''); ?>"
                   @click="sidebarOpen = false">
                    📊 Nilai & Rapor
                </a>
                <a href="<?php echo e(route('teacher.assessment.reports')); ?>" 
                   class="nav-dropdown-item <?php echo e(request()->routeIs('teacher.assessment.reports') ? 'active' : ''); ?>"
                   @click="sidebarOpen = false">
                    📈 Laporan & Analisis
                </a>
            </div>
            </div>

        <!-- Section Divider -->
        <div class="nav-section-divider"></div>
        <div class="nav-section-title">
            <span>Academic Management</span>
        </div>

       

        <!-- Students (View Only) -->
        <a href="<?php echo e(route('teacher.students.index')); ?>" 
           class="sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('teacher.students.*') ? 'active' : ''); ?>"
           @click="sidebarOpen = false">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
            <span>Data Siswa</span>
        </a>

        <!-- Section Divider -->
        <div class="nav-section-divider"></div>
        <div class="nav-section-title">
            <span>Presensi</span>
        </div>

        <!-- Learning Materials -->
        <a href="<?php echo e(route('teacher.attendance.index')); ?>" 
           class="sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('teacher.materials.*') ? 'active' : ''); ?>"
           @click="sidebarOpen = false">
            <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span>Absen Siswa</span>
        </a>
    </div>

    <!-- Enhanced User Section -->
    <div class="user-section">
        <div class="user-card">
            <img class="user-avatar" 
                 src="<?php echo e(auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=059669&background=D1FAE5'); ?>" 
                 alt="<?php echo e(auth()->user()->name); ?>">
            <div class="user-info">
                <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
                <div class="user-role">Teacher</div>
            </div>
            <div class="user-status"></div>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/layouts/teacher/sidebar.blade.php ENDPATH**/ ?>