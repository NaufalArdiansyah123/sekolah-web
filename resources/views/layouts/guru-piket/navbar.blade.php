<?php
// resources/views/layouts/guru-piket/navbar.blade.php - Guru Piket Navbar
?>
<style>
    /* Enhanced Navbar Styles for Guru Piket */
    .guru-piket-navbar {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-bottom: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: between;
        position: relative;
        z-index: 999;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        height: 70px;
        flex-shrink: 0;
    }
    
    .dark .guru-piket-navbar {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        border-bottom: 1px solid #374151;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }
    
    .guru-piket-navbar-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 100%;
    }
    
    .guru-piket-navbar-left {
        display: flex;
        align-items: center;
        flex: 1;
    }
    
    .guru-piket-navbar-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    /* Mobile Menu Button */
    .guru-piket-mobile-menu-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 1rem;
    }
    
    .dark .guru-piket-mobile-menu-btn {
        background: #374151;
        border: 1px solid #4b5563;
    }
    
    .guru-piket-mobile-menu-btn:hover {
        background: #e2e8f0;
        transform: scale(1.05);
    }
    
    .dark .guru-piket-mobile-menu-btn:hover {
        background: #4b5563;
    }
    
    /* Page Title */
    .guru-piket-page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .dark .guru-piket-page-title {
        color: #f1f5f9;
    }
    
    .guru-piket-page-title-icon {
        width: 24px;
        height: 24px;
        margin-right: 0.75rem;
        color: #3b82f6;
    }
    
    /* Breadcrumb */
    .guru-piket-breadcrumb {
        display: flex;
        align-items: center;
        margin-left: 1rem;
        font-size: 0.875rem;
        color: #64748b;
    }
    
    .dark .guru-piket-breadcrumb {
        color: #94a3b8;
    }
    
    .guru-piket-breadcrumb-separator {
        margin: 0 0.5rem;
        color: #cbd5e1;
    }
    
    /* Action Buttons */
    .guru-piket-action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #64748b;
        text-decoration: none;
    }
    
    .dark .guru-piket-action-btn {
        background: #374151;
        border: 1px solid #4b5563;
        color: #9ca3af;
    }
    
    .guru-piket-action-btn:hover {
        background: #e2e8f0;
        color: #3b82f6;
        transform: scale(1.05);
        text-decoration: none;
    }
    
    .dark .guru-piket-action-btn:hover {
        background: #4b5563;
        color: #60a5fa;
    }
    
    /* Theme Toggle */
    .guru-piket-theme-toggle {
        position: relative;
        overflow: hidden;
    }
    
    .guru-piket-theme-toggle svg {
        transition: all 0.3s ease;
    }
    
    /* Notifications */
    .guru-piket-notification-btn {
        position: relative;
    }
    
    .guru-piket-notification-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 18px;
        height: 18px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
        animation: pulse 2s infinite;
    }
    
    .dark .guru-piket-notification-badge {
        border: 2px solid #1f2937;
    }
    
    /* User Dropdown */
    .guru-piket-user-dropdown {
        position: relative;
        display: inline-block;
    }
    
    .guru-piket-user-btn {
        display: flex;
        align-items: center;
        padding: 0.5rem;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }
    
    .dark .guru-piket-user-btn {
        background: #374151;
        border: 1px solid #4b5563;
    }
    
    .guru-piket-user-btn:hover {
        background: #e2e8f0;
        transform: scale(1.02);
        text-decoration: none;
        color: inherit;
    }
    
    .dark .guru-piket-user-btn:hover {
        background: #4b5563;
    }
    
    .guru-piket-user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        margin-right: 0.75rem;
    }
    
    .guru-piket-user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-right: 0.5rem;
    }
    
    .guru-piket-user-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.2;
    }
    
    .dark .guru-piket-user-name {
        color: #f1f5f9;
    }
    
    .guru-piket-user-role {
        font-size: 0.75rem;
        color: #64748b;
        line-height: 1.2;
    }
    
    .dark .guru-piket-user-role {
        color: #94a3b8;
    }
    
    .guru-piket-user-chevron {
        width: 16px;
        height: 16px;
        color: #64748b;
        transition: transform 0.3s ease;
    }
    
    .dark .guru-piket-user-chevron {
        color: #94a3b8;
    }
    
    /* Quick Stats */
    .guru-piket-quick-stats {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-right: 1rem;
    }
    
    .guru-piket-quick-stat {
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
    }
    
    .dark .guru-piket-quick-stat {
        background: #374151;
        border: 1px solid #4b5563;
    }
    
    .guru-piket-quick-stat-icon {
        width: 16px;
        height: 16px;
        margin-right: 0.5rem;
        color: #3b82f6;
    }
    
    .guru-piket-quick-stat-value {
        font-weight: 600;
        color: #1e293b;
        margin-right: 0.25rem;
    }
    
    .dark .guru-piket-quick-stat-value {
        color: #f1f5f9;
    }
    
    .guru-piket-quick-stat-label {
        color: #64748b;
        font-size: 0.75rem;
    }
    
    .dark .guru-piket-quick-stat-label {
        color: #94a3b8;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .guru-piket-mobile-menu-btn {
            display: flex;
        }
        
        .guru-piket-breadcrumb {
            display: none;
        }
        
        .guru-piket-quick-stats {
            display: none;
        }
        
        .guru-piket-user-info {
            display: none;
        }
        
        .guru-piket-user-avatar {
            margin-right: 0;
        }
    }
    
    @media (max-width: 640px) {
        .guru-piket-navbar {
            padding: 0.75rem 1rem;
        }
        
        .guru-piket-page-title {
            font-size: 1.25rem;
        }
        
        .guru-piket-navbar-right {
            gap: 0.5rem;
        }
    }
</style>

<!-- Enhanced Guru Piket Navbar -->
<nav class="guru-piket-navbar">
    <div class="guru-piket-navbar-content">
        <!-- Left Section -->
        <div class="guru-piket-navbar-left">
            <!-- Mobile Menu Button -->
            <button onclick="toggleSidebar()" class="guru-piket-mobile-menu-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
            <!-- Page Title -->
            <h1 class="guru-piket-page-title">
                <svg class="guru-piket-page-title-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                {{ $pageTitle ?? 'Dashboard Guru Piket' }}
            </h1>
            
            <!-- Breadcrumb -->
            @if(isset($breadcrumb) && !empty($breadcrumb))
            <nav class="guru-piket-breadcrumb">
                <span>Dashboard</span>
                @if(is_array($breadcrumb))
                    @foreach($breadcrumb as $item)
                        <span class="guru-piket-breadcrumb-separator">/</span>
                        <span>{{ $item }}</span>
                    @endforeach
                @else
                    <span class="guru-piket-breadcrumb-separator">/</span>
                    <span>{{ $breadcrumb }}</span>
                @endif
            </nav>
            @endif
        </div>
        
        <!-- Right Section -->
        <div class="guru-piket-navbar-right">
            <!-- Quick Stats -->
            <div class="guru-piket-quick-stats">
                <div class="guru-piket-quick-stat">
                    <svg class="guru-piket-quick-stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <span class="guru-piket-quick-stat-value" id="today-present-count">-</span>
                    <span class="guru-piket-quick-stat-label">Hadir</span>
                </div>
                
                <div class="guru-piket-quick-stat">
                    <svg class="guru-piket-quick-stat-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="guru-piket-quick-stat-value" id="today-late-count">-</span>
                    <span class="guru-piket-quick-stat-label">Terlambat</span>
                </div>
            </div>
            
            <!-- Theme Toggle -->
            <button onclick="toggleDarkMode()" class="guru-piket-action-btn guru-piket-theme-toggle" title="Toggle Dark Mode">
                <svg id="sun-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: block;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg id="moon-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
            
            <!-- Notifications -->
            <button class="guru-piket-action-btn guru-piket-notification-btn" title="Notifications">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-6H4v6zM16 3h5v5h-5V3zM4 3h6v6H4V3z" />
                </svg>
                <span class="guru-piket-notification-badge" id="notification-count" style="display: none;">0</span>
            </button>
            
            <!-- QR Scanner Quick Access -->
            <a href="{{ route('guru-piket.attendance.qr-scanner') }}" class="guru-piket-action-btn" title="QR Scanner">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5m0 0v5m0 0h5m0 0v5m0 0H9m0 0v5" />
                </svg>
            </a>
            
            <!-- User Dropdown -->
            <div class="guru-piket-user-dropdown">
                <a href="{{ route('guru-piket.profile') }}" class="guru-piket-user-btn">
                    <img class="guru-piket-user-avatar" 
                         src="{{ auth()->user()->avatar_url }}" 
                         alt="{{ auth()->user()->name }}"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=f59e0b&background=fef3c7&size=32'">
                    <div class="guru-piket-user-info">
                        <div class="guru-piket-user-name">{{ auth()->user()->name }}</div>
                        <div class="guru-piket-user-role">Guru Piket</div>
                    </div>
                    <svg class="guru-piket-user-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
// Update quick stats in real-time
function updateQuickStats() {
    // This would be connected to real-time data
    // For now, we'll use placeholder values
    const presentCount = document.getElementById('today-present-count');
    const lateCount = document.getElementById('today-late-count');
    
    if (presentCount) presentCount.textContent = '{{ $todayAttendance['hadir'] ?? 0 }}';
    if (lateCount) lateCount.textContent = '{{ $todayAttendance['terlambat'] ?? 0 }}';
}

// Initialize quick stats on page load
document.addEventListener('DOMContentLoaded', function() {
    updateQuickStats();
    
    // Update stats every 30 seconds
    setInterval(updateQuickStats, 30000);
});
</script>