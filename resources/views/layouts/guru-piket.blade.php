<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Guru Piket' }} - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Base Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }
        
        .dark body {
            background: #0f172a;
            color: #e2e8f0;
        }
        
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            transition: margin-left 0.3s ease;
        }
        
        .content-container {
            padding: 2rem;
        }
        
        /* Alert Styles */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: slideIn 0.3s ease;
        }
        
        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        
        .dark .alert-success {
            background: #14532d;
            color: #86efac;
            border-color: #166534;
        }
        
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .dark .alert-error {
            background: #7f1d1d;
            color: #fca5a5;
            border-color: #991b1b;
        }
        
        .alert-warning {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        
        .dark .alert-warning {
            background: #78350f;
            color: #fde047;
            border-color: #92400e;
        }
        
        .alert-info {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        
        .dark .alert-info {
            background: #1e3a8a;
            color: #93c5fd;
            border-color: #1e40af;
        }
        
        .toast-icon {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }
        
        .alert > div {
            flex: 1;
        }
        
        .font-semibold {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
            
            .content-container {
                padding: 1rem;
            }
        }
        
        /* Utility Classes */
        .space-y-8 > * + * { margin-top: 2rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        
        .flex { display: flex; }
        .flex-1 { flex: 1 1 0%; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-2xl { border-radius: 1rem; }
        
        .p-6 { padding: 1.5rem; }
        .p-8 { padding: 2rem; }
        
        .text-white { color: #ffffff; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .font-bold { font-weight: 700; }
        .mb-2 { margin-bottom: 0.5rem; }
        
        .w-full { width: 100%; }
        .text-left { text-align: left; }
        
        @media (min-width: 768px) {
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .md\:block { display: block; }
        }
        
        @media (min-width: 1024px) {
            .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .lg\:col-span-2 { grid-column: span 2 / span 2; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Include Sidebar Component -->
    @include('layouts.guru-piket.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Include Navbar Component -->
        @include('layouts.guru-piket.navbar', [
            'pageTitle' => $pageTitle ?? $title ?? 'Dashboard Guru Piket',
            'breadcrumb' => $breadcrumb ?? null,
            'statistics' => $statistics ?? ['confirmed_today' => 0, 'pending' => 0]
        ])

        <!-- Page Content -->
        <main>
            <div class="content-container">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <div class="font-semibold">Berhasil!</div>
                            <div>{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <div class="font-semibold">Error!</div>
                            <div>{{ session('error') }}</div>
                        </div>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning">
                        <svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div>
                            <div class="font-semibold">Peringatan!</div>
                            <div>{{ session('warning') }}</div>
                        </div>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info">
                        <svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <div class="font-semibold">Informasi</div>
                            <div>{{ session('info') }}</div>
                        </div>
                    </div>
                @endif

                <!-- Main Content -->
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')

    <!-- Global JavaScript -->
    <script>
        // Make functions globally available
        window.toggleSidebar = function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
        };
        
        window.closeSidebar = function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        };
        
        window.toggleDarkMode = function() {
            const html = document.documentElement;
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            
            html.classList.toggle('dark');
            
            if (html.classList.contains('dark')) {
                if (sunIcon) sunIcon.style.display = 'none';
                if (moonIcon) moonIcon.style.display = 'block';
                localStorage.setItem('darkMode', 'true');
            } else {
                if (sunIcon) sunIcon.style.display = 'block';
                if (moonIcon) moonIcon.style.display = 'none';
                localStorage.setItem('darkMode', 'false');
            }
        };
        
        window.toggleUserDropdown = function() {
            const dropdown = document.getElementById('userDropdown');
            const menu = document.getElementById('dropdownMenu');
            
            if (dropdown && menu) {
                dropdown.classList.toggle('open');
                menu.classList.toggle('show');
            }
        };
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Apply dark mode from localStorage
            const darkMode = localStorage.getItem('darkMode') === 'true';
            const html = document.documentElement;
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            
            if (darkMode) {
                html.classList.add('dark');
                if (sunIcon) sunIcon.style.display = 'none';
                if (moonIcon) moonIcon.style.display = 'block';
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebarOverlay');
                    if (sidebar) sidebar.classList.remove('show');
                    if (overlay) overlay.classList.remove('show');
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('userDropdown');
                const menu = document.getElementById('dropdownMenu');
                
                if (dropdown && menu && !dropdown.contains(event.target)) {
                    dropdown.classList.remove('open');
                    menu.classList.remove('show');
                }
            });
            
            // Close sidebar when clicking on nav items on mobile
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        window.closeSidebar();
                    }
                });
            });
        });
    </script>
</body>
</html>