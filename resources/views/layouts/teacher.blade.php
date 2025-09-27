<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Teacher' }} - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">

    <!-- jQuery (Required for Bootstrap and our modals) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUa6c+ggO+RRhqP/wjMbSU7Ik7FkgrhTEsN4koC5+ZOfhuCkPfuH9ARA" crossorigin="anonymous">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Teacher Layout CSS -->
    <link rel="stylesheet" href="{{ asset('css/teacher-layout.css') }}">
    
    @stack('styles')
</head>
<body class="teacher-body">
    <div class="teacher-layout">
        <!-- Mobile Sidebar Overlay -->
        <div id="mobile-overlay" class="mobile-sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        @include('layouts.teacher.sidebar')

        <!-- Main Content Wrapper -->
        <div class="main-content-wrapper">
            <!-- Top Navigation -->
            @include('layouts.teacher.navbar', [
                'pageTitle' => $pageTitle ?? $title ?? 'Teacher Dashboard',
                'breadcrumb' => $breadcrumb ?? 'Dashboard'
            ])

            <!-- Page Content -->
            <main class="main-content">
                <div class="content-container">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success fade-in">
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
                        <div class="alert alert-error fade-in">
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
                        <div class="alert alert-warning fade-in">
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
                        <div class="alert alert-info fade-in">
                            <svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <div class="font-semibold">Informasi</div>
                                <div>{{ session('info') }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Page Header -->
                    @if(isset($header))
                        <div class="page-header slide-up">
                            {{ $header }}
                        </div>
                    @endif

                    <!-- Main Content -->
                    <div class="fade-in">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Notifications Container -->
    <div id="toast-container" class="toast-container"></div>

    @stack('scripts')

    <!-- Enhanced JavaScript -->
    <script>
        // Global variables
        let darkMode = localStorage.getItem('darkMode') === 'true';
        let sidebarOpen = false;
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Apply initial theme
            applyTheme();
            
            // Initialize sidebar state
            handleResize();
            
            // Handle window resize
            window.addEventListener('resize', handleResize);
            
            // Show Laravel flash messages as toasts
            @if(session('success'))
                setTimeout(() => showToast('success', 'Berhasil!', '{{ session('success') }}'), 500);
            @endif

            @if(session('error'))
                setTimeout(() => showToast('error', 'Error!', '{{ session('error') }}'), 500);
            @endif

            @if(session('warning'))
                setTimeout(() => showToast('warning', 'Peringatan!', '{{ session('warning') }}'), 500);
            @endif

            @if(session('info'))
                setTimeout(() => showToast('info', 'Informasi', '{{ session('info') }}'), 500);
            @endif
            
            // Initialize animations
            initializeAnimations();
        });
        
        // Theme functions
        function applyTheme() {
            if (darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        
        function toggleDarkMode() {
            darkMode = !darkMode;
            localStorage.setItem('darkMode', darkMode);
            applyTheme();
            
            // Update navbar icons
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            
            if (sunIcon && moonIcon) {
                if (darkMode) {
                    sunIcon.style.display = 'none';
                    moonIcon.style.display = 'block';
                } else {
                    sunIcon.style.display = 'block';
                    moonIcon.style.display = 'none';
                }
            }
        }
        
        // Sidebar functions
        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            updateSidebarVisibility();
        }
        
        function closeSidebar() {
            sidebarOpen = false;
            updateSidebarVisibility();
        }
        
        function handleResize() {
            if (window.innerWidth >= 769) {
                sidebarOpen = true;
                updateSidebarVisibility();
            } else {
                sidebarOpen = false;
                updateSidebarVisibility();
            }
        }
        
        function updateSidebarVisibility() {
            const sidebar = document.getElementById('teacher-sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            if (sidebar) {
                if (window.innerWidth >= 769) {
                    sidebar.style.display = 'flex';
                    sidebar.classList.remove('hidden');
                    sidebar.classList.remove('show');
                } else {
                    if (sidebarOpen) {
                        sidebar.style.display = 'flex';
                        sidebar.classList.remove('hidden');
                        sidebar.classList.add('show');
                    } else {
                        sidebar.classList.remove('show');
                        setTimeout(() => {
                            if (!sidebarOpen) {
                                sidebar.style.display = 'none';
                                sidebar.classList.add('hidden');
                            }
                        }, 300);
                    }
                }
            }
            
            if (overlay) {
                if (sidebarOpen && window.innerWidth < 769) {
                    overlay.classList.add('show');
                } else {
                    overlay.classList.remove('show');
                }
            }
        }
        
        // Toast notification functions
        function showToast(type, title, message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const toastId = 'toast-' + Date.now();
            
            toast.id = toastId;
            toast.className = `toast toast-${type}`;
            
            const icons = {
                success: '<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #10b981;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                error: '<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #ef4444;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                warning: '<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #f59e0b;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
                info: '<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #3b82f6;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            };
            
            toast.innerHTML = `
                ${icons[type] || icons.info}
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="removeToast('${toastId}')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            
            container.appendChild(toast);
            
            // Show toast with animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                removeToast(toastId);
            }, 5000);
        }
        
        function removeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('show');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 400);
            }
        }
        
        // Animation functions
        function initializeAnimations() {
            // Intersection Observer for animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            // Observe elements for animation
            document.querySelectorAll('.content-card, .table-container').forEach(el => {
                observer.observe(el);
            });
        }
        
        // Utility functions
        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus item ini?') {
            return confirm(message);
        }
        
        function showLoading(element) {
            if (element) {
                element.classList.add('loading');
            }
        }
        
        function hideLoading(element) {
            if (element) {
                element.classList.remove('loading');
            }
        }
        
        // Make functions globally available
        window.toggleSidebar = toggleSidebar;
        window.closeSidebar = closeSidebar;
        window.toggleDarkMode = toggleDarkMode;
        window.showToast = showToast;
        window.removeToast = removeToast;
        window.confirmDelete = confirmDelete;
        window.showLoading = showLoading;
        window.hideLoading = hideLoading;
        window.sidebarOpen = sidebarOpen;
        window.darkMode = darkMode;
    </script>
</body>
</html>