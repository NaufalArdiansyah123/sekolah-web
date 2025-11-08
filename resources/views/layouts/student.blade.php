<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ sidebarOpen: false, darkMode: localStorage.getItem('darkMode') === 'true' || false }" 
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Student' }} - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {}
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Enhanced Styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Dark Mode Variables */
        :root {
            --bg-primary-light: #ffffff;
            --bg-secondary-light: #f8fafc;
            --bg-tertiary-light: #f1f5f9;
            --text-primary-light: #1f2937;
            --text-secondary-light: #6b7280;
            --text-tertiary-light: #9ca3af;
            --border-light: #e5e7eb;
            --shadow-light: rgba(0, 0, 0, 0.1);
            --accent-light: #10b981;

            --bg-primary-dark: #1f2937;
            --bg-secondary-dark: #111827;
            --bg-tertiary-dark: #374151;
            --text-primary-dark: #f9fafb;
            --text-secondary-dark: #d1d5db;
            --text-tertiary-dark: #9ca3af;
            --border-dark: #374151;
            --shadow-dark: rgba(0, 0, 0, 0.3);
            --accent-dark: #34d399;

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

        body {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: var(--bg-primary);
            border-right: 1px solid var(--border-color);
            transition: transform 0.3s ease-in-out;
        }

        /* Mobile Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 50;
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
        }

        /* Desktop Sidebar */
        @media (min-width: 769px) {
            .sidebar {
                position: relative;
                transform: translateX(0);
            }
        }

        /* Mobile Overlay */
        .mobile-sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
        }

        .dark .mobile-sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Prevent scroll when sidebar open */
        body.sidebar-open {
            overflow: hidden;
        }

        @media (min-width: 769px) {
            body.sidebar-open {
                overflow: auto;
            }
        }

        /* Scrollbar */
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

<body class="font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-cloak
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300" 
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 md:hidden mobile-sidebar-overlay">
        </div>

        <!-- Sidebar -->
        <div class="sidebar w-64 flex-shrink-0 md:flex md:flex-col overflow-y-auto"
             :class="{ 'show': sidebarOpen }"
             x-cloak>
            @include('layouts.student.sidebar')
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            <!-- Top Navigation -->
            @include('layouts.student.navbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="container mx-auto px-4 sm:px-6 py-8">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(isset($breadcrumb))
                        <nav class="mb-4 text-sm">
                            <ol class="list-none p-0 inline-flex">
                                @foreach($breadcrumb as $index => $item)
                                    <li class="flex items-center">
                                        @if($loop->last)
                                            <span class="text-gray-500">{{ $item['label'] }}</span>
                                        @else
                                            <a href="{{ $item['url'] }}" class="text-blue-600 hover:text-blue-800">{{ $item['label'] }}</a>
                                            <svg class="w-3 h-3 mx-3" fill="currentColor" viewBox="0 0 12 12">
                                                <path d="M4.5 3L7.5 6L4.5 9"></path>
                                            </svg>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </nav>
                    @endif

                    @if(isset($header))
                        <div class="mb-8">
                            {{ $header }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    @stack('scripts')

    <script>
        // Watch for sidebar changes
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebarWatcher', () => ({
                init() {
                    this.$watch('sidebarOpen', (value) => {
                        if (value && window.innerWidth < 768) {
                            document.body.classList.add('sidebar-open');
                        } else {
                            document.body.classList.remove('sidebar-open');
                        }
                    });
                }
            }));
        });

        // Listen for close sidebar event from sidebar component
        window.addEventListener('close-sidebar', function() {
            // This will be handled by Alpine automatically
        });

        // Toast function
        window.showToast = function(type, title, message) {
            const toast = document.createElement('div');
            toast.className = 'max-w-sm w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 dark:ring-white dark:ring-opacity-10 mb-2';
            
            const colors = {
                success: 'text-green-400',
                error: 'text-red-400',
                warning: 'text-yellow-400',
                info: 'text-blue-400'
            };
            
            toast.innerHTML = `
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 ${colors[type] || colors.info}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${title}</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">${message}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button onclick="this.closest('.max-w-sm').remove()" class="rounded-md inline-flex text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('toast-container').appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 5000);
        };

        // Show Laravel flash messages
        @if(session('success'))
            showToast('success', 'Berhasil!', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showToast('error', 'Error!', '{{ session('error') }}');
        @endif

        // Initialize theme
        (function() {
            const savedTheme = localStorage.getItem('darkMode');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const shouldUseDarkMode = savedTheme === 'true' || (savedTheme === null && systemPrefersDark);

            if (shouldUseDarkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            localStorage.setItem('darkMode', shouldUseDarkMode.toString());
        })();
    </script>
</body>
</html>