<!-- Enhanced Modern Teacher Sidebar -->
<style>
    /* Reset any conflicting styles */
    .sidebar-nav * {
        box-sizing: border-box;
    }
    /* Modern Teacher Sidebar Styles */
    .sidebar-nav {
        width: 16rem;
        height: 100vh;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
        border-right: 1px solid rgba(229, 231, 235, 0.3);
        box-shadow: 
            0 4px 6px -1px rgba(0, 0, 0, 0.05),
            0 2px 4px -1px rgba(0, 0, 0, 0.03);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 30;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .dark .sidebar-nav {
        background: linear-gradient(180deg, #1f2937 0%, #111827 50%, #0f172a 100%);
        border-right-color: rgba(55, 65, 81, 0.3);
        box-shadow: 
            0 4px 6px -1px rgba(0, 0, 0, 0.3),
            0 2px 4px -1px rgba(0, 0, 0, 0.2);
    }
    
    /* Glassmorphism overlay */
    .sidebar-nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(5, 150, 105, 0.03) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.03) 0%, transparent 50%),
            radial-gradient(circle at 40% 60%, rgba(52, 211, 153, 0.02) 0%, transparent 50%);
        pointer-events: none;
        z-index: 1;
    }
    
    .dark .sidebar-nav::before {
        background: 
            radial-gradient(circle at 20% 20%, rgba(16, 185, 129, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(52, 211, 153, 0.06) 0%, transparent 50%),
            radial-gradient(circle at 40% 60%, rgba(34, 197, 94, 0.04) 0%, transparent 50%);
    }
    
    .sidebar-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    /* Enhanced Logo Section */
    .sidebar-logo {
        padding: 2rem 1.5rem 1.5rem;
        border-bottom: 1px solid rgba(229, 231, 235, 0.2);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        position: relative;
    }
    
    .dark .sidebar-logo {
        background: rgba(0, 0, 0, 0.2);
        border-bottom-color: rgba(55, 65, 81, 0.2);
    }
    
    .logo-container {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }
    
    .logo-container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        opacity: 0;
        transition: all 0.6s ease;
        animation: rotate 20s linear infinite;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .logo-container:hover::before {
        opacity: 1;
    }
    
    .logo-container:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(5, 150, 105, 0.2);
        background: rgba(5, 150, 105, 0.05);
        border-color: rgba(5, 150, 105, 0.3);
    }
    
    .logo-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: linear-gradient(135deg, #059669, #10b981, #34d399);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        transition: all 0.4s ease;
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .logo-icon::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transform: rotate(-45deg);
        transition: all 0.6s ease;
    }
    
    .logo-container:hover .logo-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 30px rgba(5, 150, 105, 0.4);
    }
    
    .logo-container:hover .logo-icon::before {
        transform: rotate(45deg);
    }
    
    .logo-text-container {
        flex: 1;
        min-width: 0;
    }
    
    .logo-text {
        font-weight: 800;
        font-size: 1.25rem;
        background: linear-gradient(135deg, #111827, #059669, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.025em;
        margin-bottom: 0.25rem;
        line-height: 1.2;
    }
    
    .dark .logo-text {
        background: linear-gradient(135deg, #ffffff, #10b981, #34d399);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .logo-subtitle {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        opacity: 0.8;
    }
    
    .dark .logo-subtitle {
        color: #9ca3af;
    }
    
    /* Mobile Close Button */
    .mobile-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 12px;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #ef4444;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .mobile-close-btn:hover {
        background: rgba(239, 68, 68, 0.15);
        border-color: rgba(239, 68, 68, 0.3);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }
    
    @media (max-width: 768px) {
        .mobile-close-btn {
            display: flex;
        }
        
        .sidebar-logo {
            padding-right: 4rem;
        }
    }
    
    /* Enhanced Navigation Section */
    .nav-section {
        flex: 1;
        padding: 1.5rem 1rem;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(5, 150, 105, 0.2) transparent;
    }
    
    .nav-section::-webkit-scrollbar {
        width: 6px;
    }
    
    .nav-section::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .nav-section::-webkit-scrollbar-thumb {
        background: rgba(5, 150, 105, 0.2);
        border-radius: 3px;
    }
    
    .nav-section::-webkit-scrollbar-thumb:hover {
        background: rgba(5, 150, 105, 0.3);
    }
    
    /* Section Titles */
    .nav-section-title {
        color: #6b7280;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin: 2rem 0 1rem 1rem;
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .dark .nav-section-title {
        color: #9ca3af;
    }
    
    .nav-section-title::before {
        content: '';
        width: 6px;
        height: 6px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(5, 150, 105, 0.4);
    }
    
    .nav-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, rgba(5, 150, 105, 0.2), transparent);
        margin-left: 0.5rem;
    }
    
    /* Enhanced Navigation Items */
    .sidebar-nav-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 16px;
        color: #6b7280;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;
    }
    
    .dark .sidebar-nav-item {
        color: #9ca3af;
    }
    
    .sidebar-nav-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        transition: left 0.6s ease;
    }
    
    .sidebar-nav-item:hover::before {
        left: 100%;
    }
    
    .sidebar-nav-item:hover {
        color: #059669;
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.08), rgba(16, 185, 129, 0.05));
        transform: translateX(8px);
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15);
        border-color: rgba(5, 150, 105, 0.2);
    }
    
    .dark .sidebar-nav-item:hover {
        color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(52, 211, 153, 0.08));
    }
    
    .sidebar-nav-item.active {
        color: #059669;
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.15), rgba(16, 185, 129, 0.1));
        border-color: rgba(5, 150, 105, 0.3);
        border-left: 4px solid #059669;
        font-weight: 700;
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.2);
        transform: translateX(4px);
    }
    
    .dark .sidebar-nav-item.active {
        color: #10b981;
        border-left-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(52, 211, 153, 0.12));
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }
    
    .nav-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        transition: all 0.3s ease;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    
    .sidebar-nav-item:hover .nav-icon {
        transform: scale(1.1);
        filter: drop-shadow(0 2px 4px rgba(5, 150, 105, 0.3));
    }
    
    .sidebar-nav-item.active .nav-icon {
        transform: scale(1.05);
        filter: drop-shadow(0 2px 6px rgba(5, 150, 105, 0.4));
    }
    
    /* Enhanced Dropdown Styles */
    .nav-dropdown {
        margin-bottom: 0.5rem;
    }
    
    .nav-dropdown-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        border-radius: 16px;
        background: none;
        border: 1px solid transparent;
        color: #6b7280;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        text-align: left;
    }
    
    .dark .nav-dropdown-btn {
        color: #9ca3af;
    }
    
    .nav-dropdown-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        transition: left 0.6s ease;
    }
    
    .nav-dropdown-btn:hover::before {
        left: 100%;
    }
    
    .nav-dropdown-btn:hover {
        color: #059669;
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.08), rgba(16, 185, 129, 0.05));
        transform: translateX(8px);
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15);
        border-color: rgba(5, 150, 105, 0.2);
    }
    
    .dark .nav-dropdown-btn:hover {
        color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(52, 211, 153, 0.08));
    }
    
    .nav-dropdown-btn.active {
        color: #059669;
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.12), rgba(16, 185, 129, 0.08));
        border-color: rgba(5, 150, 105, 0.2);
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15);
    }
    
    .dark .nav-dropdown-btn.active {
        color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.1));
    }
    
    .dropdown-icon {
        width: 16px;
        height: 16px;
        margin-left: auto;
        transition: transform 0.4s ease;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    
    .nav-dropdown-btn.active .dropdown-icon {
        transform: rotate(90deg);
    }
    
    .nav-dropdown-content {
        margin-left: 2.5rem;
        margin-top: 0.5rem;
        border-left: 2px solid rgba(5, 150, 105, 0.2);
        padding-left: 1rem;
        position: relative;
        max-height: 0;
        overflow: hidden;
        transition: all 0.4s ease;
    }
    
    .nav-dropdown-content.show {
        max-height: 500px;
    }
    
    .nav-dropdown-content::before {
        content: '';
        position: absolute;
        left: -2px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #059669, #10b981, #34d399);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .nav-dropdown.open .nav-dropdown-content::before {
        opacity: 1;
    }
    
    .nav-dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        margin-bottom: 0.25rem;
        border-radius: 12px;
        color: #6b7280;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .dark .nav-dropdown-item {
        color: #9ca3af;
    }
    
    .nav-dropdown-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.08), transparent);
        transition: left 0.5s ease;
    }
    
    .nav-dropdown-item:hover::before {
        left: 100%;
    }
    
    .nav-dropdown-item:hover {
        color: #059669;
        background: rgba(5, 150, 105, 0.08);
        transform: translateX(6px);
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.1);
    }
    
    .dark .nav-dropdown-item:hover {
        color: #10b981;
        background: rgba(16, 185, 129, 0.1);
    }
    
    .nav-dropdown-item.active {
        color: #059669;
        background: rgba(5, 150, 105, 0.12);
        border-left: 3px solid #059669;
        padding-left: 13px;
        font-weight: 700;
        box-shadow: 0 2px 10px rgba(5, 150, 105, 0.15);
    }
    
    .dark .nav-dropdown-item.active {
        color: #10b981;
        border-left-color: #10b981;
        background: rgba(16, 185, 129, 0.15);
    }
    
    /* Enhanced User Section */
    .user-section {
        padding: 1.5rem;
        border-top: 1px solid rgba(229, 231, 235, 0.2);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }
    
    .dark .user-section {
        background: rgba(0, 0, 0, 0.2);
        border-top-color: rgba(55, 65, 81, 0.2);
    }
    
    .user-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.4s ease;
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
        transition: opacity 0.4s ease;
    }
    
    .user-card:hover::before {
        opacity: 1;
    }
    
    .user-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(5, 150, 105, 0.2);
        background: rgba(5, 150, 105, 0.05);
        border-color: rgba(5, 150, 105, 0.3);
    }
    
    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        object-fit: cover;
        border: 3px solid rgba(5, 150, 105, 0.2);
        transition: all 0.4s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .user-card:hover .user-avatar {
        border-color: rgba(5, 150, 105, 0.4);
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
    }
    
    .user-info {
        flex: 1;
        min-width: 0;
    }
    
    .user-name {
        font-weight: 700;
        font-size: 0.875rem;
        color: #111827;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .dark .user-name {
        color: #ffffff;
    }
    
    .user-role {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .dark .user-role {
        color: #9ca3af;
    }
    
    .user-status {
        width: 10px;
        height: 10px;
        background: linear-gradient(135deg, #10b981, #34d399);
        border-radius: 50%;
        border: 2px solid #ffffff;
        animation: pulse 2s infinite;
        box-shadow: 0 0 12px rgba(16, 185, 129, 0.6);
    }
    
    .dark .user-status {
        border-color: #1f2937;
    }
    
    @keyframes pulse {
        0%, 100% { 
            opacity: 1; 
            transform: scale(1); 
        }
        50% { 
            opacity: 0.8; 
            transform: scale(1.1); 
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .sidebar-nav {
            width: 320px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .sidebar-nav.show {
            transform: translateX(0);
        }
    }
    
    /* Scrollbar Styling */
    .nav-section {
        scrollbar-width: thin;
        scrollbar-color: rgba(5, 150, 105, 0.3) transparent;
    }
    
    .nav-section::-webkit-scrollbar {
        width: 6px;
    }
    
    .nav-section::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .nav-section::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, rgba(5, 150, 105, 0.3), rgba(16, 185, 129, 0.3));
        border-radius: 3px;
    }
    
    .nav-section::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, rgba(5, 150, 105, 0.5), rgba(16, 185, 129, 0.5));
    }
</style>

<div class="sidebar-nav hidden" id="teacher-sidebar">
    <!-- Enhanced Logo Section -->
    <div class="sidebar-logo">
        <div class="logo-container">
            <div class="logo-icon">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="logo-text-container">
                <div class="logo-text">Teacher Portal</div>
                <div class="logo-subtitle">SMA Negeri 1</div>
            </div>
        </div>
        
        <!-- Mobile Close Button -->
        <button onclick="toggleSidebar()" class="mobile-close-btn">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Enhanced Navigation -->
    <div class="nav-section">
        <!-- Dashboard -->
        <a href="{{ route('teacher.dashboard') }}" 
           class="sidebar-nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Content Management Section -->
        <div class="nav-section-title">
            <span>Content Management</span>
        </div>

        <!-- Posts & Content Dropdown -->
        <div class="nav-dropdown">
            <button onclick="toggleDropdown('posts')" 
                    class="nav-dropdown-btn {{ request()->routeIs('teacher.posts.*') ? 'active' : '' }}"
                    id="posts-btn">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <span>Posts & Content</span>
                <svg class="dropdown-icon" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <div id="posts-content" class="nav-dropdown-content {{ request()->routeIs('teacher.posts.*') ? 'show' : '' }}">
                <a href="{{ route('teacher.posts.announcement') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('teacher.posts.announcement*') ? 'active' : '' }}">
                    📢 Pengumuman
                </a>
                <a href="{{ route('teacher.posts.blog.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('teacher.posts.blog*') ? 'active' : '' }}">
                    📰 Berita & Blog
                </a>
            </div>
        </div>

        <!-- Learning Management Dropdown -->
        <div class="nav-dropdown">
            <button onclick="toggleDropdown('learning')" 
                    class="nav-dropdown-btn {{ request()->routeIs('teacher.learning.*') ? 'active' : '' }}"
                    id="learning-btn">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Learning Management</span>
                <svg class="dropdown-icon" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <div id="learning-content" class="nav-dropdown-content {{ request()->routeIs('teacher.learning.*') ? 'show' : '' }}">
                <a href="{{ route('teacher.learning.materials.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('teacher.learning.materials*') ? 'active' : '' }}">
                    📚 Materi Pembelajaran
                </a>
                <a href="{{ route('teacher.learning.assignments.index') }}" 
                   class="nav-dropdown-item {{ request()->routeIs('teacher.learning.assignments*') ? 'active' : '' }}">
                    📝 Tugas & Latihan
                </a>
            </div>
        </div>

        <!-- Quizzes & Tests -->
        <a href="{{ route('teacher.quizzes.index') }}" 
           class="sidebar-nav-item {{ request()->routeIs('teacher.quizzes.*') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <span>Kuis </span>
        </a>

        <!-- Grades -->
        <a href="{{ route('teacher.grades.index') }}" 
           class="sidebar-nav-item {{ request()->routeIs('teacher.grades.*') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span>Nilai & Rapor</span>
        </a>

        <!-- Academic Management Section -->
        <div class="nav-section-title">
            <span>Academic Management</span>
        </div>

        <!-- Students -->
        <a href="{{ route('teacher.students.index') }}" 
           class="sidebar-nav-item {{ request()->routeIs('teacher.students.*') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24">
                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            <span>Data Siswa</span>
        </a>

        <!-- Attendance Section -->
        <div class="nav-section-title">
            <span>Attendance</span>
        </div>

        <!-- Attendance -->
        <a href="{{ route('teacher.attendance.index') }}" 
           class="sidebar-nav-item {{ request()->routeIs('teacher.attendance.*') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span>Absen Siswa</span>
        </a>

        <!-- Quick Actions Section -->
        <div class="nav-section-title">
            <span>Quick Actions</span>
        </div>

        <!-- Quick Create Assignment -->
        <a href="{{ route('teacher.learning.assignments.create') }}" 
           class="sidebar-nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            <span>Buat Tugas Baru</span>
        </a>

        <!-- Quick Create Material -->
        <a href="{{ route('teacher.learning.materials.create') }}" 
           class="sidebar-nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24">
                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>Tambah Materi</span>
        </a>
    </div>

    <!-- Enhanced User Section -->
    <div class="user-section">
        <div class="user-card">
            <img class="user-avatar" 
                 src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=059669&background=D1FAE5' }}" 
                 alt="{{ auth()->user()->name }}">
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Teacher</div>
            </div>
            <div class="user-status"></div>
        </div>
    </div>
</div>

<!-- Enhanced JavaScript -->
<script>
    // Dropdown management with enhanced animations
    function toggleDropdown(dropdownName) {
        const content = document.getElementById(dropdownName + '-content');
        const btn = document.getElementById(dropdownName + '-btn');
        const dropdown = btn.closest('.nav-dropdown');
        
        if (content.classList.contains('show')) {
            // Close current dropdown
            content.classList.remove('show');
            btn.classList.remove('active');
            dropdown.classList.remove('open');
        } else {
            // Close all other dropdowns first
            document.querySelectorAll('.nav-dropdown-content').forEach(el => {
                el.classList.remove('show');
            });
            document.querySelectorAll('.nav-dropdown-btn').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelectorAll('.nav-dropdown').forEach(el => {
                el.classList.remove('open');
            });
            
            // Open current dropdown
            content.classList.add('show');
            btn.classList.add('active');
            dropdown.classList.add('open');
        }
    }
    
    // Close mobile sidebar
    function closeMobileSidebar() {
        if (window.innerWidth < 768) {
            const sidebar = document.getElementById('teacher-sidebar');
            sidebar.classList.remove('show');
            sidebar.classList.add('hidden');
            window.sidebarOpen = false;
        }
    }
    
    // Enhanced sidebar toggle for mobile
    function toggleSidebar() {
        const sidebar = document.getElementById('teacher-sidebar');
        
        if (window.innerWidth < 768) {
            sidebar.classList.toggle('show');
            sidebar.classList.toggle('hidden');
        } else {
            // Desktop behavior
            if (sidebar.style.display === 'none') {
                sidebar.style.display = 'flex';
                sidebar.classList.remove('hidden');
            } else {
                sidebar.style.display = 'none';
                sidebar.classList.add('hidden');
            }
        }
    }
    
    // Initialize dropdowns and responsive behavior
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-open dropdowns if current route matches
        const activeDropdowns = document.querySelectorAll('.nav-dropdown-btn.active');
        activeDropdowns.forEach(btn => {
            const dropdownName = btn.id.replace('-btn', '');
            const content = document.getElementById(dropdownName + '-content');
            const dropdown = btn.closest('.nav-dropdown');
            if (content) {
                content.classList.add('show');
                dropdown.classList.add('open');
            }
        });
        
        // Handle responsive behavior
        function handleResize() {
            const sidebar = document.getElementById('teacher-sidebar');
            if (window.innerWidth >= 768) {
                sidebar.style.display = 'flex';
                sidebar.classList.remove('hidden');
                sidebar.classList.remove('show');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('show');
            }
        }
        
        // Initial setup
        handleResize();
        
        // Listen for resize events
        window.addEventListener('resize', handleResize);
        
        // Close sidebar when clicking nav items on mobile
        const navItems = document.querySelectorAll('.sidebar-nav-item, .nav-dropdown-item');
        navItems.forEach(item => {
            item.addEventListener('click', closeMobileSidebar);
        });
        
        // Enhanced scroll behavior
        const navSection = document.querySelector('.nav-section');
        if (navSection) {
            navSection.addEventListener('scroll', function() {
                const scrollTop = this.scrollTop;
                const scrollHeight = this.scrollHeight - this.clientHeight;
                const scrollPercent = scrollTop / scrollHeight;
                
                // Add subtle shadow effect based on scroll position
                if (scrollTop > 10) {
                    this.style.boxShadow = 'inset 0 10px 10px -10px rgba(0,0,0,0.1)';
                } else {
                    this.style.boxShadow = 'none';
                }
            });
        }
    });
    
    // Make functions globally available
    window.toggleDropdown = toggleDropdown;
    window.closeMobileSidebar = closeMobileSidebar;
    window.toggleSidebar = toggleSidebar;
</script>