<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <title>{{ $title ?? 'Admin' }} - {{ config('app.name') }}</title>

    <!-- Preload Critical Resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <!-- Critical CSS Inline - Always loads first -->
    <style>
        /* Critical Mobile-First CSS */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #1f2937;
            background-color: #f8fafc;
        }

        /* Mobile-first layout */
        .admin-layout {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
        }

        .admin-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .admin-content {
            flex: 1;
            padding: 1rem;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            transition: left 0.3s ease;
            z-index: 60;
            overflow-y: auto;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 55;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile menu button */
        .mobile-menu-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
        }

        /* Cards and components */
        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border: 1px solid transparent;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        /* Stats grid - mobile responsive */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Table responsive */
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .table th {
            background: #f9fafb;
            font-weight: 600;
            color: #374151;
        }

        /* Form elements */
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            line-height: 1.5;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Loading state */
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            color: #6b7280;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #e5e7eb;
            border-top: 2px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Desktop adjustments */
        @media (min-width: 768px) {
            .admin-layout {
                flex-direction: row;
            }

            .sidebar {
                position: relative;
                left: 0;
                width: 280px;
                flex-shrink: 0;
            }

            .admin-content {
                flex: 1;
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: none;
            }

            .sidebar-overlay {
                display: none;
            }
        }

        /* Dark mode support */
        .dark {
            color-scheme: dark;
        }

        .dark body {
            background-color: #111827;
            color: #f9fafb;
        }

        .dark .card,
        .dark .stat-card,
        .dark .sidebar,
        .dark .admin-header {
            background: #1f2937;
            border-color: #374151;
        }

        .dark .table th {
            background: #374151;
            color: #f9fafb;
        }

        /* Utility classes */
        .hidden { display: none !important; }
        .block { display: block !important; }
        .flex { display: flex !important; }
        .grid { display: grid !important; }
        .text-center { text-align: center !important; }
        .text-left { text-align: left !important; }
        .text-right { text-align: right !important; }
        .mb-1 { margin-bottom: 0.25rem !important; }
        .mb-2 { margin-bottom: 0.5rem !important; }
        .mb-4 { margin-bottom: 1rem !important; }
        .mt-4 { margin-top: 1rem !important; }
        .p-4 { padding: 1rem !important; }
        .px-4 { padding-left: 1rem !important; padding-right: 1rem !important; }
        .py-2 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
    </style>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome - Essential icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">

    <!-- Alpine.js - Core functionality -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite Assets - Load after critical CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional styles from pages -->
    @stack('styles')
</head>
<body class="admin-layout" x-data="adminApp()">
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" 
         x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Sidebar -->
    <nav class="sidebar" :class="{ 'open': sidebarOpen }" x-data="{ sidebarOpen: false }">
        @include('layouts.admin.sidebar')
    </nav>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="admin-header">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <button class="mobile-menu-btn md:hidden" @click="sidebarOpen = !sidebarOpen">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="ml-4 text-lg font-semibold">{{ $title ?? 'Dashboard' }}</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Dark mode toggle -->
                    <button @click="toggleDarkMode()" class="btn btn-primary">
                        <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                    </button>
                    
                    <!-- User menu -->
                    <div class="flex items-center">
                        <span class="text-sm">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="admin-content">
            <!-- Alerts -->
            @if(session('success'))
                <div class="card" style="background: #dcfce7; border-color: #16a34a; color: #166534; margin-bottom: 1rem;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="card" style="background: #fee2e2; border-color: #dc2626; color: #991b1b; margin-bottom: 1rem;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="card" style="background: #fee2e2; border-color: #dc2626; color: #991b1b; margin-bottom: 1rem;">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Content -->
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    @stack('scripts')

    <script>
        // Alpine.js admin app
        function adminApp() {
            return {
                sidebarOpen: false,
                darkMode: localStorage.getItem('darkMode') === 'true' || false,
                
                init() {
                    this.applyTheme();
                    
                    // Auto-close sidebar on desktop
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 768) {
                            this.sidebarOpen = false;
                        }
                    });
                },
                
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('darkMode', this.darkMode);
                    this.applyTheme();
                },
                
                applyTheme() {
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }
        }

        // Mobile detection and fallback
        (function() {
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (isMobile) {
                document.body.classList.add('mobile-device');
                
                // Add mobile-specific optimizations
                const viewport = document.querySelector('meta[name="viewport"]');
                if (viewport) {
                    viewport.setAttribute('content', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no');
                }
                
                // Disable hover effects on mobile
                const style = document.createElement('style');
                style.textContent = `
                    @media (hover: none) {
                        .card:hover,
                        .btn:hover,
                        .stat-card:hover {
                            transform: none !important;
                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
                        }
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Fallback for failed asset loading
            let assetsLoaded = false;
            
            setTimeout(() => {
                if (!assetsLoaded) {
                    console.warn('Assets loading slowly, applying fallback styles');
                    document.body.classList.add('fallback-mode');
                }
            }, 3000);
            
            // Check if Vite assets loaded
            window.addEventListener('load', () => {
                assetsLoaded = true;
            });
        })();

        // Global functions
        window.showToast = function(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            } text-white`;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 3000);
        };

        window.confirmDelete = function(message = 'Are you sure?') {
            return confirm(message);
        };
    </script>
</body>
</html>