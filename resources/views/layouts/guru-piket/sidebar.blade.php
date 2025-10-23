<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo Section -->
    <div class="sidebar-logo">
        <div class="logo-container">
            <div class="logo-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div class="logo-text-wrapper">
                <div class="logo-text">Guru Piket</div>
                <div class="logo-subtitle">SMA Negeri 1</div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav">
        <!-- Main Menu -->
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>

            <a href="{{ route('guru-piket.dashboard') }}"
               class="nav-item {{ request()->routeIs('guru-piket.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('guru-piket.attendance.submissions') }}"
               class="nav-item {{ request()->routeIs('guru-piket.attendance.submissions*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Kelola Submission</span>
            </a>
        </div>

        <!-- Tools -->
        <div class="nav-section">
            <div class="nav-section-title">Tools</div>

            <a href="{{ route('guru-piket.qr-scanner.index') }}"
               class="nav-item {{ request()->routeIs('guru-piket.qr-scanner.index') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5m0 0v5m0 0h5m0 0v5m0 0H9m0 0v5"></path>
                </svg>
                <span>Absensi Masuk</span>
            </a>

            <a href="{{ route('guru-piket.qr-scanner.check-out') }}"
               class="nav-item {{ request()->routeIs('guru-piket.qr-scanner.check-out') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Absensi Pulang</span>
            </a>

            <a href="#" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Profil</span>
            </a>

            <a href="#" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Pengaturan</span>
            </a>
        </div>
    </div>

    <!-- User Section -->
    <div class="sidebar-user">
        <div class="user-card">
            <img class="user-avatar"
                 src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=64748b&background=f1f5f9&size=40' }}"
                 alt="{{ auth()->user()->name }}">
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Guru Piket</div>
            </div>
            <div class="user-status"></div>
        </div>
    </div>
</div>

<style>
/* Sidebar Styles */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: white;
    border-right: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
    z-index: 50;
    transition: transform 0.3s ease;
}

.dark .sidebar {
    background: #1f2937;
    border-right-color: #374151;
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 45;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.sidebar-overlay.show {
    opacity: 1;
    visibility: visible;
}

/* Logo Section */
.sidebar-logo {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.dark .sidebar-logo {
    border-bottom-color: #374151;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.logo-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: #64748b;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.dark .logo-icon {
    background: #475569;
}

.logo-icon svg {
    color: white;
}

.logo-text-wrapper {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.logo-text {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
}

.dark .logo-text {
    color: #f1f5f9;
}

.logo-subtitle {
    font-size: 0.75rem;
    color: #64748b;
}

.dark .logo-subtitle {
    color: #94a3b8;
}

/* Navigation */
.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
}

.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}

.dark .sidebar-nav::-webkit-scrollbar-thumb {
    background: #475569;
}

.nav-section {
    margin-bottom: 1.5rem;
}

.nav-section:last-child {
    margin-bottom: 0;
}

.nav-section-title {
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0 0.75rem;
    margin-bottom: 0.5rem;
}

.dark .nav-section-title {
    color: #94a3b8;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
    text-decoration: none;
    margin-bottom: 0.25rem;
    transition: all 0.15s ease;
}

.nav-item:hover {
    background: #f8fafc;
    color: #475569;
}

.dark .nav-item {
    color: #94a3b8;
}

.dark .nav-item:hover {
    background: #374151;
    color: #cbd5e1;
}

.nav-item.active {
    background: #f1f5f9;
    color: #1e293b;
    font-weight: 500;
}

.dark .nav-item.active {
    background: #374151;
    color: #f1f5f9;
}

.nav-icon {
    width: 1.25rem;
    height: 1.25rem;
    flex-shrink: 0;
}

/* User Section */
.sidebar-user {
    padding: 1rem;
    border-top: 1px solid #e5e7eb;
}

.dark .sidebar-user {
    border-top-color: #374151;
}

.user-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 0.5rem;
    position: relative;
}

.dark .user-card {
    background: #374151;
}

.user-card .user-avatar {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.5rem;
    object-fit: cover;
}

.user-card .user-info {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
    flex: 1;
    min-width: 0;
}

.user-card .user-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dark .user-card .user-name {
    color: #f1f5f9;
}

.user-card .user-role {
    font-size: 0.75rem;
    color: #64748b;
}

.dark .user-card .user-role {
    color: #94a3b8;
}

.user-status {
    width: 0.5rem;
    height: 0.5rem;
    background: #10b981;
    border-radius: 50%;
    border: 2px solid #f8fafc;
}

.dark .user-status {
    border-color: #374151;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
}
</style>

@push('scripts')
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (window.innerWidth <= 768) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    sidebar.classList.remove('show');
    overlay.classList.remove('show');
}

// Handle window resize
window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        closeSidebar();
    }
});

// Close sidebar when clicking on nav items on mobile
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            closeSidebar();
        }
    });
});
</script>
@endpush