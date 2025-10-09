<!-- Enhanced Modern Teacher Navbar -->
<style>
    /* Reset any conflicting styles */
    .teacher-navbar * {
        box-sizing: border-box;
    }
    /* Modern Teacher Navbar Styles */
    .teacher-navbar {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(229, 231, 235, 0.3);
        box-shadow: 
            0 1px 3px rgba(0, 0, 0, 0.05),
            0 20px 25px -5px rgba(0, 0, 0, 0.02),
            0 10px 10px -5px rgba(0, 0, 0, 0.02);
        position: sticky;
        top: 0;
        z-index: 40;
        height: 4.5rem;
        transition: all 0.3s ease;
    }
    
    .dark .teacher-navbar {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border-bottom-color: rgba(55, 65, 81, 0.3);
        box-shadow: 
            0 1px 3px rgba(0, 0, 0, 0.3),
            0 20px 25px -5px rgba(0, 0, 0, 0.4),
            0 10px 10px -5px rgba(0, 0, 0, 0.3);
    }
    
    .navbar-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0 1.5rem;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .navbar-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex: 1;
    }
    
    .mobile-menu-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 12px;
        background: rgba(5, 150, 105, 0.1);
        border: 1px solid rgba(5, 150, 105, 0.2);
        color: #059669;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .mobile-menu-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .mobile-menu-btn:hover::before {
        left: 100%;
    }
    
    .mobile-menu-btn:hover {
        background: rgba(5, 150, 105, 0.15);
        border-color: rgba(5, 150, 105, 0.3);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
    }
    
    .dark .mobile-menu-btn {
        background: rgba(16, 185, 129, 0.1);
        border-color: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }
    
    @media (max-width: 768px) {
        .mobile-menu-btn {
            display: flex;
        }
    }
    
    .page-title-section {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }
    
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #111827, #059669);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        letter-spacing: -0.025em;
    }
    
    .dark .page-title {
        background: linear-gradient(135deg, #ffffff, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .page-breadcrumb {
        display: none;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .dark .page-breadcrumb {
        color: #9ca3af;
    }
    
    @media (min-width: 1024px) {
        .page-breadcrumb {
            display: flex;
        }
    }
    
    .breadcrumb-separator {
        width: 1rem;
        height: 1rem;
        color: #d1d5db;
    }
    
    .dark .breadcrumb-separator {
        color: #6b7280;
    }
    
    .navbar-center {
        display: none;
        align-items: center;
        gap: 1rem;
        flex: 1;
        justify-content: center;
        max-width: 24rem;
    }
    
    @media (min-width: 1024px) {
        .navbar-center {
            display: flex;
        }
    }
    
    .search-container {
        position: relative;
        width: 100%;
        max-width: 20rem;
    }
    
    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        font-size: 0.875rem;
        color: #111827;
        transition: all 0.3s ease;
        outline: none;
    }
    
    .search-input::placeholder {
        color: #9ca3af;
    }
    
    .search-input:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .dark .search-input {
        background: rgba(31, 41, 55, 0.8);
        border-color: #374151;
        color: #ffffff;
    }
    
    .dark .search-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        background: rgba(31, 41, 55, 0.95);
    }
    
    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 1.25rem;
        height: 1.25rem;
        color: #9ca3af;
        pointer-events: none;
    }
    
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .navbar-action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(229, 231, 235, 0.5);
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }
    
    .navbar-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .navbar-action-btn:hover::before {
        left: 100%;
    }
    
    .navbar-action-btn:hover {
        background: rgba(5, 150, 105, 0.1);
        border-color: rgba(5, 150, 105, 0.2);
        color: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
    }
    
    .dark .navbar-action-btn {
        background: rgba(31, 41, 55, 0.8);
        border-color: rgba(55, 65, 81, 0.5);
        color: #9ca3af;
    }
    
    .dark .navbar-action-btn:hover {
        background: rgba(16, 185, 129, 0.1);
        border-color: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }
    
    .notification-btn {
        position: relative;
    }
    
    .notification-badge {
        position: absolute;
        top: -0.25rem;
        right: -0.25rem;
        width: 1.25rem;
        height: 1.25rem;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.625rem;
        font-weight: 700;
        color: white;
        border: 2px solid #ffffff;
        animation: pulse 2s infinite;
    }
    
    .dark .notification-badge {
        border-color: #1f2937;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    .user-dropdown {
        position: relative;
    }
    
    .user-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(229, 231, 235, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }
    
    .user-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .user-btn:hover::before {
        left: 100%;
    }
    
    .user-btn:hover {
        background: rgba(5, 150, 105, 0.1);
        border-color: rgba(5, 150, 105, 0.2);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
    }
    
    .dark .user-btn {
        background: rgba(31, 41, 55, 0.8);
        border-color: rgba(55, 65, 81, 0.5);
    }
    
    .dark .user-btn:hover {
        background: rgba(16, 185, 129, 0.1);
        border-color: rgba(16, 185, 129, 0.2);
    }
    
    .user-avatar {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid rgba(5, 150, 105, 0.2);
        transition: all 0.3s ease;
    }
    
    .user-btn:hover .user-avatar {
        border-color: rgba(5, 150, 105, 0.4);
        transform: scale(1.05);
    }
    
    .user-info {
        display: none;
        flex-direction: column;
        align-items: flex-start;
        min-width: 0;
    }
    
    @media (min-width: 768px) {
        .user-info {
            display: flex;
        }
    }
    
    .user-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 8rem;
    }
    
    .dark .user-name {
        color: #ffffff;
    }
    
    .user-role {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
    }
    
    .dark .user-role {
        color: #9ca3af;
    }
    
    .user-chevron {
        width: 1rem;
        height: 1rem;
        color: #9ca3af;
        transition: transform 0.3s ease;
        display: none;
    }
    
    @media (min-width: 768px) {
        .user-chevron {
            display: block;
        }
    }
    
    .user-btn.active .user-chevron {
        transform: rotate(180deg);
    }
    
    .user-menu {
        position: absolute;
        top: calc(100% + 0.5rem);
        right: 0;
        width: 16rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(229, 231, 235, 0.3);
        border-radius: 16px;
        box-shadow: 
            0 20px 25px -5px rgba(0, 0, 0, 0.1),
            0 10px 10px -5px rgba(0, 0, 0, 0.04);
        padding: 0.5rem;
        z-index: 50;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }
    
    .user-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .dark .user-menu {
        background: rgba(31, 41, 55, 0.95);
        border-color: rgba(55, 65, 81, 0.3);
        box-shadow: 
            0 20px 25px -5px rgba(0, 0, 0, 0.4),
            0 10px 10px -5px rgba(0, 0, 0, 0.2);
    }
    
    .user-menu-header {
        padding: 1rem;
        border-bottom: 1px solid rgba(229, 231, 235, 0.3);
        margin-bottom: 0.5rem;
    }
    
    .dark .user-menu-header {
        border-bottom-color: rgba(55, 65, 81, 0.3);
    }
    
    .user-menu-name {
        font-weight: 600;
        color: #111827;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    
    .dark .user-menu-name {
        color: #ffffff;
    }
    
    .user-menu-email {
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .dark .user-menu-email {
        color: #9ca3af;
    }
    
    .user-menu-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        color: #374151;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .user-menu-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .user-menu-item:hover::before {
        left: 100%;
    }
    
    .user-menu-item:hover {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        text-decoration: none;
        transform: translateX(5px);
    }
    
    .dark .user-menu-item {
        color: #d1d5db;
    }
    
    .dark .user-menu-item:hover {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .user-menu-icon {
        width: 1.25rem;
        height: 1.25rem;
        flex-shrink: 0;
    }
    
    .user-menu-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        margin: 0.5rem 0;
    }
    
    .dark .user-menu-divider {
        background: linear-gradient(90deg, transparent, #374151, transparent);
    }
    
    .logout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        background: none;
        border: none;
        color: #ef4444;
        text-align: left;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .logout-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .logout-btn:hover::before {
        left: 100%;
    }
    
    .logout-btn:hover {
        background: rgba(239, 68, 68, 0.1);
        transform: translateX(5px);
    }
    
    /* Quick Actions */
    .quick-actions {
        display: none;
        align-items: center;
        gap: 0.5rem;
    }
    
    @media (min-width: 1280px) {
        .quick-actions {
            display: flex;
        }
    }
    
    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        background: rgba(5, 150, 105, 0.1);
        border: 1px solid rgba(5, 150, 105, 0.2);
        color: #059669;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .quick-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .quick-action-btn:hover::before {
        left: 100%;
    }
    
    .quick-action-btn:hover {
        background: rgba(5, 150, 105, 0.15);
        border-color: rgba(5, 150, 105, 0.3);
        text-decoration: none;
        color: #047857;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
    }
    
    .dark .quick-action-btn {
        background: rgba(16, 185, 129, 0.1);
        border-color: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }
    
    .dark .quick-action-btn:hover {
        background: rgba(16, 185, 129, 0.15);
        border-color: rgba(16, 185, 129, 0.3);
        color: #34d399;
    }
    
    /* Icon Styles */
    .icon {
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 640px) {
        .navbar-container {
            padding: 0 1rem;
        }
        
        .page-title {
            font-size: 1.25rem;
        }
        
        .navbar-right {
            gap: 0.5rem;
        }
        
        .user-btn {
            padding: 0.375rem;
        }
        
        .user-avatar {
            width: 2rem;
            height: 2rem;
        }
    }
</style>

<header class="teacher-navbar">
    <div class="navbar-container">
        <!-- Left Section -->
        <div class="navbar-left">
            <!-- Mobile Menu Button -->
            <button onclick="toggleSidebar()" class="mobile-menu-btn" title="Toggle Menu">
                <svg class="icon" width="20" height="20" viewBox="0 0 24 24">
                    <path d="M3 12h18M3 6h18M3 18h18"/>
                </svg>
            </button>

            <!-- Page Title Section -->
            <div class="page-title-section">
                <h1 class="page-title">
                    {{ $pageTitle ?? 'Teacher Dashboard' }}
                </h1>
                
                <div class="page-breadcrumb">
                    <svg class="breadcrumb-separator" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>
                        @if(is_array($breadcrumb ?? null))
                            @if(count($breadcrumb) > 0)
                                {{ end($breadcrumb)['title'] ?? 'Dashboard' }}
                            @else
                                Dashboard
                            @endif
                        @else
                            {{ $breadcrumb ?? 'Dashboard' }}
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Center Section - Search -->
        

        <!-- Right Section -->
        <div class="navbar-right">
            <!-- Quick Actions -->
            

            <!-- Dark Mode Toggle -->
            <button onclick="toggleDarkMode()" class="navbar-action-btn" title="Toggle Dark Mode">
                <svg id="sun-icon" class="icon" width="20" height="20" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="5"/>
                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                </svg>
                <svg id="moon-icon" class="icon" width="20" height="20" viewBox="0 0 24 24" style="display: none;">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>

            <!-- Notifications -->
            

            <!-- User Dropdown -->
            <div class="user-dropdown">
                <button onclick="toggleUserMenu()" class="user-btn" id="user-menu-btn">
                    <img class="user-avatar" 
                         src="{{ auth()->user()->avatar_url }}" 
                         alt="{{ auth()->user()->name }}"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=059669&background=D1FAE5&size=36'">
                    
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">Guru</div>
                    </div>
                    
                    <svg class="user-chevron icon" width="16" height="16" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>
                
                <!-- User Menu Dropdown -->
                <div id="user-menu" class="user-menu">
                    <div class="user-menu-header">
                        <div class="user-menu-name">{{ auth()->user()->name }}</div>
                        <div class="user-menu-email">{{ auth()->user()->email }}</div>
                    </div>
                    
                    <a href="{{ route('teacher.profile') }}" class="user-menu-item">
                        <svg class="user-menu-icon icon" width="20" height="20" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span>Profile Settings</span>
                    </a>
                    
                    <a href="#" class="user-menu-item">
                        <svg class="user-menu-icon icon" width="20" height="20" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>
                        </svg>
                        <span>Preferences</span>
                    </a>
                    
                    <a href="{{ route('home') }}" class="user-menu-item">
                        <svg class="user-menu-icon icon" width="20" height="20" viewBox="0 0 24 24">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <polyline points="9,22 9,12 15,12 15,22"/>
                        </svg>
                        <span>Back to Home</span>
                    </a>
                    
                    <div class="user-menu-divider"></div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <svg class="user-menu-icon icon" width="20" height="20" viewBox="0 0 24 24">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                                <polyline points="16,17 21,12 16,7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Enhanced JavaScript -->
<script>
    // Global variables
    let sidebarOpen = false;
    let darkMode = localStorage.getItem('darkMode') === 'true';
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize dark mode
        if (darkMode) {
            document.documentElement.classList.add('dark');
            document.getElementById('sun-icon').style.display = 'none';
            document.getElementById('moon-icon').style.display = 'block';
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-dropdown')) {
                const userMenu = document.getElementById('user-menu');
                const userBtn = document.getElementById('user-menu-btn');
                userMenu.classList.remove('show');
                userBtn.classList.remove('active');
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
        
        // Initialize search functionality
        initializeSearch();
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
        const userBtn = document.getElementById('user-menu-btn');
        
        userMenu.classList.toggle('show');
        userBtn.classList.toggle('active');
    }
    
    // Toggle notifications (placeholder)
    function toggleNotifications() {
        // Placeholder for notifications functionality
        console.log('Notifications clicked');
        // You can implement notification dropdown here
    }
    
    // Initialize search functionality
    function initializeSearch() {
        const searchInput = document.getElementById('global-search');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.trim();
                if (query.length > 2) {
                    // Implement search functionality here
                    console.log('Searching for:', query);
                    // You can add AJAX search here
                }
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = e.target.value.trim();
                    if (query) {
                        // Implement search redirect here
                        console.log('Search submitted:', query);
                    }
                }
            });
        }
    }
    
    // Make functions globally available
    window.toggleSidebar = toggleSidebar;
    window.toggleDarkMode = toggleDarkMode;
    window.toggleUserMenu = toggleUserMenu;
    window.toggleNotifications = toggleNotifications;
</script>