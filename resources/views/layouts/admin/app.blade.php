{{-- resources/views/layouts/admin/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Dark Mode Variables */
        :root {
            /* Light Mode */
            --bg-primary-light: #ffffff;
            --bg-secondary-light: #f8fafc;
            --bg-tertiary-light: #f1f5f9;
            --text-primary-light: #1f2937;
            --text-secondary-light: #6b7280;
            --text-tertiary-light: #9ca3af;
            --border-light: #e5e7eb;
            --shadow-light: rgba(0, 0, 0, 0.1);
            --accent-light: #3b82f6;
            
            /* Dark Mode */
            --bg-primary-dark: #1f2937;
            --bg-secondary-dark: #111827;
            --bg-tertiary-dark: #374151;
            --text-primary-dark: #f9fafb;
            --text-secondary-dark: #d1d5db;
            --text-tertiary-dark: #9ca3af;
            --border-dark: #374151;
            --shadow-dark: rgba(0, 0, 0, 0.3);
            --accent-dark: #60a5fa;
            
            /* Current Theme (Default: Light) */
            --bg-primary: var(--bg-primary-light);
            --bg-secondary: var(--bg-secondary-light);
            --bg-tertiary: var(--bg-tertiary-light);
            --text-primary: var(--text-primary-light);
            --text-secondary: var(--text-secondary-light);
            --text-tertiary: var(--text-tertiary-light);
            --border-color: var(--border-light);
            --shadow-color: var(--shadow-light);
            --accent-color: var(--accent-light);
        }
        
        /* Dark mode class */
        .dark {
            --bg-primary: var(--bg-primary-dark);
            --bg-secondary: var(--bg-secondary-dark);
            --bg-tertiary: var(--bg-tertiary-dark);
            --text-primary: var(--text-primary-dark);
            --text-secondary: var(--text-secondary-dark);
            --text-tertiary: var(--text-tertiary-dark);
            --border-color: var(--border-dark);
            --shadow-color: var(--shadow-dark);
            --accent-color: var(--accent-dark);
        }
        
        /* Apply theme variables */
        body {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        /* Main content area */
        .main-content {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Navigation bar */
        .top-nav {
            background-color: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px var(--shadow-color);
            transition: all 0.3s ease;
        }
        
        /* Cards and containers */
        .content-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px var(--shadow-color);
            transition: all 0.3s ease;
        }
        
        /* Buttons */
        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-secondary {
            background-color: var(--bg-tertiary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        /* Form elements */
        .form-input {
            background-color: var(--bg-primary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .form-input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Tables */
        .table {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }
        
        .table th {
            background-color: var(--bg-tertiary);
            border-bottom: 1px solid var(--border-color);
        }
        
        .table td {
            border-bottom: 1px solid var(--border-color);
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .slide-down {
            animation: slideDown 0.3s ease-in-out;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Mobile sidebar fix */
        .mobile-sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        .dark .mobile-sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.7);
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0 !important;
            }
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-tertiary);
        }
    </style>
    
    @stack('styles')
</head>

<body class="font-sans antialiased" x-data="adminApp()" @theme-changed.window="handleThemeChange($event.detail)">
    <div class="min-h-screen main-content">
        <!-- Include Sidebar -->
        @include('layouts.admin.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 md:ml-64 main-content">
            <!-- Top Navigation -->
            <nav class="top-nav" x-data="{ userMenuOpen: false }">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Mobile menu button -->
                        <div class="flex items-center md:hidden">
                            <button @click="$dispatch('toggle-sidebar')" 
                                    class="inline-flex items-center justify-center p-2 rounded-md transition-colors duration-200"
                                    :class="darkMode ? 'text-gray-300 hover:text-white hover:bg-gray-700' : 'text-gray-400 hover:text-gray-500 hover:bg-gray-100'"
                                    style="color: var(--text-secondary);">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>

                        <!-- Page Title -->
                        <div class="flex items-center">
                            <h1 class="text-xl font-semibold md:hidden" style="color: var(--text-primary);">
                                @yield('title', 'Admin Panel')
                            </h1>
                        </div>

                        <!-- Right side navigation -->
                        <div class="flex items-center space-x-3">
                            <!-- Enhanced Dark Mode Toggle -->
                            <div class="relative">
                                <button @click="toggleDarkMode()" 
                                        class="flex items-center space-x-2 px-3 py-2 rounded-lg border transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                        :class="darkMode ? 'bg-gray-800 border-gray-600 text-yellow-400 hover:bg-gray-700' : 'bg-white border-gray-300 text-gray-600 hover:bg-gray-50'"
                                        title="Toggle Dark Mode">
                                    <!-- Light Mode Icon -->
                                    <svg x-show="!darkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                                    </svg>
                                    <!-- Dark Mode Icon -->
                                    <svg x-show="darkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                                    </svg>
                                    <!-- Text Label (Hidden on mobile) -->
                                    <span class="hidden sm:block text-sm font-medium" x-text="darkMode ? 'Dark' : 'Light'"></span>
                                </button>
                                
                                <!-- Tooltip -->
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 pointer-events-none transition-opacity duration-200 group-hover:opacity-100">
                                    <span x-text="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"></span>
                                </div>
                            </div>

                            <!-- Notifications -->
                            <button class="p-2 rounded-lg transition-colors duration-200"
                                    :class="darkMode ? 'text-gray-300 hover:text-white hover:bg-gray-700' : 'text-gray-400 hover:text-gray-500 hover:bg-gray-100'"
                                    title="Notifications">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-3.405-3.405A9.954 9.954 0 0118 9a9 9 0 10-9 9c1.74 0 3.35-.476 4.757-1.305L17 20l-2-3z"></path>
                                </svg>
                            </button>

                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="flex items-center space-x-3 p-2 rounded-lg transition-colors duration-200"
                                        :class="darkMode ? 'hover:bg-gray-700' : 'hover:bg-gray-100'">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                         :class="darkMode ? 'bg-blue-600' : 'bg-blue-600'">
                                        <span class="text-white text-sm font-medium">
                                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <p class="text-sm font-medium" style="color: var(--text-primary);">{{ auth()->user()->name ?? 'Administrator' }}</p>
                                        <p class="text-xs" style="color: var(--text-secondary);">{{ auth()->user()->email ?? '' }}</p>
                                    </div>
                                    <svg class="w-4 h-4" style="color: var(--text-secondary);" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>

                                <!-- User Dropdown Menu -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                                     :class="darkMode ? 'bg-gray-800' : 'bg-white'">
                                    <div class="py-1">
                                        <a href="{{ route('admin.profile') }}" 
                                           class="flex items-center px-4 py-2 text-sm transition-colors duration-200"
                                           :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Profile
                                        </a>
                                        <a href="{{ route('admin.settings') }}" 
                                           class="flex items-center px-4 py-2 text-sm transition-colors duration-200"
                                           :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Settings
                                        </a>
                                        <div class="border-t" :class="darkMode ? 'border-gray-700' : 'border-gray-100'"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="flex items-center w-full px-4 py-2 text-sm transition-colors duration-200"
                                                    :class="darkMode ? 'text-red-400 hover:bg-gray-700 hover:text-red-300' : 'text-red-600 hover:bg-red-50'">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="flex-1 p-6">
                <div class="content-card rounded-lg p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toast-container" 
         class="fixed top-4 right-4 z-50 space-y-2"
         x-data="{ toasts: [] }"
         @show-toast.window="toasts.push($event.detail); setTimeout(() => toasts.shift(), 5000)">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-full"
                 class="max-w-sm w-full shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
                 :class="darkMode ? 'bg-gray-800' : 'bg-white'">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg x-show="toast.type === 'success'" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <svg x-show="toast.type === 'error'" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium" :class="darkMode ? 'text-gray-100' : 'text-gray-900'" x-text="toast.title"></p>
                            <p class="mt-1 text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-500'" x-text="toast.message"></p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="toasts.splice(toasts.indexOf(toast), 1)"
                                    class="rounded-md inline-flex transition-colors duration-200"
                                    :class="darkMode ? 'text-gray-400 hover:text-gray-300' : 'text-gray-400 hover:text-gray-500'">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    @stack('scripts')

    <script>
        // Alpine.js admin app data
        function adminApp() {
            return {
                darkMode: localStorage.getItem('darkMode') === 'true' || false,
                
                init() {
                    this.applyTheme();
                    
                    // Listen for theme changes from sidebar
                    this.$watch('darkMode', (value) => {
                        localStorage.setItem('darkMode', value);
                        this.applyTheme();
                    });
                },
                
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    
                    // Dispatch event for other components
                    window.dispatchEvent(new CustomEvent('theme-changed', { 
                        detail: { darkMode: this.darkMode } 
                    }));
                },
                
                applyTheme() {
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                },
                
                handleThemeChange(detail) {
                    this.darkMode = detail.darkMode;
                }
            }
        }

        // Global admin functions
        window.showToast = function(type, title, message) {
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: {
                    id: Date.now(),
                    type: type,
                    title: title,
                    message: message
                }
            }));
        };

        // Show Laravel flash messages as toasts
        @if(session('success'))
            showToast('success', 'Berhasil!', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showToast('error', 'Error!', '{{ session('error') }}');
        @endif

        // Confirmation dialogs
        window.confirmDelete = function(message = 'Apakah Anda yakin ingin menghapus item ini?') {
            return confirm(message);
        };

        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });

        // Initialize theme on page load
        (function() {
            const savedTheme = localStorage.getItem('darkMode');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedTheme === 'true' || (savedTheme === null && systemPrefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</body>
</html>