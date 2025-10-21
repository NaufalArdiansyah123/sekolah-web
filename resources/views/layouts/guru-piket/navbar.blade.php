<!-- Navbar -->
<nav class="navbar">
    <!-- Left Section -->
    <div class="navbar-left">
        <!-- Mobile Menu Button -->
        <button onclick="toggleSidebar()" class="mobile-menu-btn">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Page Title -->
        <h1 class="page-title">
            <svg class="page-title-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            {{ $pageTitle ?? 'Dashboard Guru Piket' }}
        </h1>

        <!-- Breadcrumb -->
        @if(isset($breadcrumb) && !empty($breadcrumb))
        <nav class="breadcrumb">
            <span>Dashboard</span>
            @if(is_array($breadcrumb))
                @foreach($breadcrumb as $item)
                    <span class="breadcrumb-separator">/</span>
                    <span>{{ $item }}</span>
                @endforeach
            @else
                <span class="breadcrumb-separator">/</span>
                <span>{{ $breadcrumb }}</span>
            @endif
        </nav>
        @endif
    </div>

    <!-- Right Section -->
    <div class="navbar-right">
        <!-- Quick Stats -->
        <div class="quick-stats">
            <div class="quick-stat">
                <svg class="quick-stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <div class="quick-stat-content">
                    <span class="quick-stat-value" id="today-present">-</span>
                    <span class="quick-stat-label">Hadir</span>
                </div>
            </div>

            <div class="quick-stat">
                <svg class="quick-stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="quick-stat-content">
                    <span class="quick-stat-value" id="today-pending">-</span>
                    <span class="quick-stat-label">Pending</span>
                </div>
            </div>
        </div>

        <!-- Theme Toggle -->
        <button onclick="toggleDarkMode()" class="action-btn" title="Toggle Dark Mode">
            <svg id="sun-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: block;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <svg id="moon-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>

        <!-- User Dropdown -->
        <div class="user-dropdown" id="userDropdown">
            <button class="user-btn" onclick="toggleUserDropdown()">
                <img class="user-avatar"
                     src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=64748b&background=f1f5f9&size=32' }}"
                     alt="{{ auth()->user()->name }}">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Guru Piket</div>
                </div>
                <svg class="user-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu" id="dropdownMenu">
                <!-- Header -->
                <div class="dropdown-header">
                    <div class="dropdown-user-info">
                        <img class="dropdown-avatar"
                             src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=64748b&background=f1f5f9&size=48' }}"
                             alt="{{ auth()->user()->name }}">
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-name">{{ auth()->user()->name }}</div>
                            <div class="dropdown-user-email">{{ auth()->user()->email }}</div>
                            <div class="dropdown-user-role">Guru Piket</div>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="dropdown-body">
                    <a href="{{ route('guru-piket.dashboard') }}" class="dropdown-item">
                        <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="#" class="dropdown-item">
                        <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profil Saya
                    </a>

                    <a href="#" class="dropdown-item">
                        <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Pengaturan
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="dropdown-item danger w-full text-left">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
/* Navbar Styles */
.navbar {
    position: fixed;
    top: 0;
    left: 280px;
    right: 0;
    height: 70px;
    background: white;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    z-index: 40;
    transition: left 0.3s ease;
}

.dark .navbar {
    background: #1f2937;
    border-bottom-color: #374151;
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.mobile-menu-btn {
    display: none;
    padding: 0.5rem;
    border-radius: 0.5rem;
    border: none;
    background: transparent;
    color: #64748b;
    cursor: pointer;
}

.mobile-menu-btn:hover {
    background: #f1f5f9;
}

.dark .mobile-menu-btn {
    color: #94a3b8;
}

.dark .mobile-menu-btn:hover {
    background: #374151;
}

.page-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.dark .page-title {
    color: #f1f5f9;
}

.page-title-icon {
    width: 1.5rem;
    height: 1.5rem;
    color: #64748b;
}

.dark .page-title-icon {
    color: #94a3b8;
}

.breadcrumb {
    display: none;
    font-size: 0.875rem;
    color: #64748b;
}

.dark .breadcrumb {
    color: #94a3b8;
}

.breadcrumb-separator {
    margin: 0 0.5rem;
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Quick Stats */
.quick-stats {
    display: flex;
    gap: 1rem;
}

.quick-stat {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 1rem;
    background: #f8fafc;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
}

.dark .quick-stat {
    background: #374151;
    border-color: #4b5563;
}

.quick-stat-icon {
    width: 1.25rem;
    height: 1.25rem;
    color: #64748b;
}

.dark .quick-stat-icon {
    color: #94a3b8;
}

.quick-stat-content {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.quick-stat-value {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
}

.dark .quick-stat-value {
    color: #f1f5f9;
}

.quick-stat-label {
    font-size: 0.75rem;
    color: #64748b;
}

.dark .quick-stat-label {
    color: #94a3b8;
}

/* Action Button */
.action-btn {
    padding: 0.5rem;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    background: white;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-btn:hover {
    background: #f8fafc;
    color: #475569;
}

.dark .action-btn {
    background: #374151;
    border-color: #4b5563;
    color: #94a3b8;
}

.dark .action-btn:hover {
    background: #4b5563;
    color: #e2e8f0;
}

/* User Dropdown */
.user-dropdown {
    position: relative;
}

.user-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.375rem 0.75rem 0.375rem 0.375rem;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    background: white;
    cursor: pointer;
}

.user-btn:hover {
    background: #f8fafc;
}

.dark .user-btn {
    background: #374151;
    border-color: #4b5563;
}

.dark .user-btn:hover {
    background: #4b5563;
}

.user-avatar {
    width: 2rem;
    height: 2rem;
    border-radius: 0.375rem;
    object-fit: cover;
}

.user-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    min-width: 0;
}

.user-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
}

.dark .user-name {
    color: #f1f5f9;
}

.user-role {
    font-size: 0.75rem;
    color: #64748b;
}

.dark .user-role {
    color: #94a3b8;
}

.user-chevron {
    width: 1rem;
    height: 1rem;
    color: #64748b;
    transition: transform 0.2s ease;
}

.dark .user-chevron {
    color: #94a3b8;
}

.user-dropdown.open .user-chevron {
    transform: rotate(180deg);
}

/* Dropdown Menu */
.dropdown-menu {
    position: absolute;
    top: calc(100% + 0.5rem);
    right: 0;
    width: 280px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
}

.dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dark .dropdown-menu {
    background: #1f2937;
    border-color: #374151;
}

.dropdown-header {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.dark .dropdown-header {
    border-bottom-color: #374151;
}

.dropdown-user-info {
    display: flex;
    gap: 0.75rem;
}

.dropdown-avatar {
    width: 3rem;
    height: 3rem;
    border-radius: 0.5rem;
    object-fit: cover;
}

.dropdown-user-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    min-width: 0;
}

.dropdown-user-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1e293b;
}

.dark .dropdown-user-name {
    color: #f1f5f9;
}

.dropdown-user-email {
    font-size: 0.75rem;
    color: #64748b;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.dark .dropdown-user-email {
    color: #94a3b8;
}

.dropdown-user-role {
    font-size: 0.75rem;
    color: #64748b;
}

.dark .dropdown-user-role {
    color: #94a3b8;
}

.dropdown-body {
    padding: 0.5rem;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    color: #475569;
    text-decoration: none;
    cursor: pointer;
    border: none;
    background: transparent;
}

.dropdown-item:hover {
    background: #f8fafc;
    color: #1e293b;
}

.dark .dropdown-item {
    color: #cbd5e1;
}

.dark .dropdown-item:hover {
    background: #374151;
    color: #f1f5f9;
}

.dropdown-item.danger {
    color: #dc2626;
}

.dropdown-item.danger:hover {
    background: #fee2e2;
    color: #991b1b;
}

.dark .dropdown-item.danger {
    color: #f87171;
}

.dark .dropdown-item.danger:hover {
    background: #7f1d1d;
    color: #fca5a5;
}

.dropdown-item-icon {
    width: 1.25rem;
    height: 1.25rem;
}

.dropdown-divider {
    height: 1px;
    background: #e2e8f0;
    margin: 0.5rem 0;
}

.dark .dropdown-divider {
    background: #374151;
}

/* Responsive */
@media (max-width: 1024px) {
    .quick-stats {
        display: none;
    }
    
    .breadcrumb {
        display: none;
    }
}

@media (max-width: 768px) {
    .navbar {
        left: 0;
        padding: 0 1rem;
    }
    
    .mobile-menu-btn {
        display: flex;
    }
    
    .page-title {
        font-size: 1rem;
    }
    
    .user-info {
        display: none;
    }
}
</style>

@push('scripts')
<script>
// User Dropdown Functions
function toggleUserDropdown() {
    const dropdown = document.getElementById('userDropdown');
    const menu = document.getElementById('dropdownMenu');
    
    dropdown.classList.toggle('open');
    menu.classList.toggle('show');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    const menu = document.getElementById('dropdownMenu');
    
    if (!dropdown.contains(event.target)) {
        dropdown.classList.remove('open');
        menu.classList.remove('show');
    }
});

// Dark Mode Toggle
function toggleDarkMode() {
    const html = document.documentElement;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    
    html.classList.toggle('dark');
    
    if (html.classList.contains('dark')) {
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'block';
        localStorage.setItem('darkMode', 'true');
    } else {
        sunIcon.style.display = 'block';
        moonIcon.style.display = 'none';
        localStorage.setItem('darkMode', 'false');
    }
}

// Initialize dark mode from localStorage
document.addEventListener('DOMContentLoaded', function() {
    const darkMode = localStorage.getItem('darkMode') === 'true';
    const html = document.documentElement;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    
    if (darkMode) {
        html.classList.add('dark');
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'block';
    }
    
    // Update quick stats
    updateQuickStats();
});

// Update Quick Stats
function updateQuickStats() {
    const presentCount = document.getElementById('today-present');
    const pendingCount = document.getElementById('today-pending');
    
    const confirmedToday = @json($statistics['confirmed_today'] ?? 0);
    const pending = @json($statistics['pending'] ?? 0);
    
    if (presentCount) presentCount.textContent = confirmedToday;
    if (pendingCount) pendingCount.textContent = pending;
}

// Auto-update stats every 30 seconds
setInterval(updateQuickStats, 30000);
</script>
@endpush