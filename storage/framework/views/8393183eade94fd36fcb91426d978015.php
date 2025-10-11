<?php
// resources/views/layouts/admin.blade.php - Enhanced with Mobile Fix & Dark Mode
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ?? 'Admin'); ?> - <?php echo e(school_name()); ?></title>
    
    <!-- Dynamic Favicon -->
    <?php
        $schoolFavicon = school_setting('school_favicon');
    ?>
    <?php if($schoolFavicon && !str_contains($schoolFavicon, 'tmp')): ?>
        <link rel="icon" type="image/x-icon" href="<?php echo e(asset('storage/' . $schoolFavicon)); ?>">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('storage/' . $schoolFavicon)); ?>">
        <link rel="apple-touch-icon" href="<?php echo e(asset('storage/' . $schoolFavicon)); ?>">
    <?php else: ?>
        <!-- Default favicon fallback -->
        <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <?php endif; ?>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- jQuery (Required for Bootstrap and our modals) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUa6c+ggO+RRhqP/wjMbSU7Ik7FkMBHkgrhTEsN4koC5+ZOfhuCkPfuH9ARA" crossorigin="anonymous">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Avatar Helper Script -->
    <script src="<?php echo e(asset('js/avatar-helper.js')); ?>"></script>
    
    <!-- Enhanced Styles for Dark Mode & Mobile -->
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
        
        /* Sidebar */
        .sidebar {
            background-color: var(--bg-primary);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        /* Mobile sidebar overlay */
        .mobile-sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        .dark .mobile-sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.7);
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
        
        /* Mobile improvements */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased main-content" x-data="adminApp()" @toggle-sidebar.window="sidebarOpen = !sidebarOpen">
    <div class="flex h-screen">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             class="fixed inset-0 z-40 md:hidden mobile-sidebar-overlay" 
             x-transition:enter="transition-opacity ease-linear duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false">
        </div>

        <!-- Sidebar -->
        <?php echo $__env->make('layouts.admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <?php echo $__env->make('layouts.admin.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto main-content">
                <div class="container mx-auto px-6 py-8">
                    <!-- Alerts -->
                    <?php echo $__env->make('components.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <!-- Breadcrumb -->
                    <?php if(isset($breadcrumb)): ?>
                        <?php echo $__env->make('components.breadcrumb', ['items' => $breadcrumb], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                    <!-- Page Header -->
                    <?php if(isset($header)): ?>
                        <div class="mb-8">
                            <?php echo e($header); ?>

                        </div>
                    <?php endif; ?>

                    <!-- Main Content -->
                    <div class="content-card rounded-lg p-6">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toast-container" 
         class="fixed top-4 right-4 z-50 space-y-2"
         x-data="{ toasts: [] }"
         <?php echo $__env->yieldSection(); ?>-toast.window="toasts.push($event.detail); setTimeout(() => toasts.shift(), 5000)">
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
                            <svg x-show="toast.type === 'warning'" class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <svg x-show="toast.type === 'info'" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium" :class="darkMode ? 'text-gray-100' : 'text-gray-900'" x-text="toast.title"></p>
                            <p class="mt-1 text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-500'" x-text="toast.message"></p>
                            <!-- Enhanced details for notifications -->
                            <div x-show="toast.enhanced && toast.details" class="mt-2 text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-400'">
                                <div x-show="toast.details.time" class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span x-text="toast.details.time"></span>
                                </div>
                                <div x-show="toast.details.status" class="flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Status: </span><span x-text="toast.details.status"></span>
                                </div>
                                <div x-show="toast.details.facilities_count !== undefined" class="flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                                    </svg>
                                    <span x-text="toast.details.facilities_count + ' fasilitas'"></span>
                                </div>
                            </div>
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

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        // Alpine.js admin app data
        function adminApp() {
            return {
                darkMode: localStorage.getItem('darkMode') === 'true' || false,
                sidebarOpen: false,
                
                init() {
                    this.applyTheme();
                    
                    // Initialize sidebar state based on screen size
                    this.checkScreenSize();
                    
                    // Listen for window resize
                    window.addEventListener('resize', () => {
                        this.checkScreenSize();
                    });
                    
                    // Listen for theme changes
                    this.$watch('darkMode', (value) => {
                        localStorage.setItem('darkMode', value);
                        this.applyTheme();
                    });
                },
                
                checkScreenSize() {
                    if (window.innerWidth >= 768) {
                        this.sidebarOpen = true;
                    } else {
                        this.sidebarOpen = false;
                    }
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

        // Enhanced toast notification with details
        window.showEnhancedToast = function(type, title, message, details = {}) {
            const toast = {
                id: Date.now(),
                type: type,
                title: title,
                message: message,
                details: details,
                enhanced: true
            };
            
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: toast
            }));
        };

        // Show notification from AJAX response
        window.showNotificationFromResponse = function(response) {
            if (response.notification) {
                const notif = response.notification;
                showEnhancedToast(
                    notif.type,
                    notif.title,
                    notif.message || '',
                    notif.details || {}
                );
            } else if (response.message) {
                showToast('success', 'Berhasil!', response.message);
            }
        };

        // Show Laravel flash messages as toasts
        <?php if(session('success')): ?>
            showToast('success', 'Berhasil!', '<?php echo e(session('success')); ?>');
        <?php endif; ?>

        <?php if(session('error')): ?>
            showToast('error', 'Error!', '<?php echo e(session('error')); ?>');
        <?php endif; ?>

        <?php if(session('warning')): ?>
            showToast('warning', 'Peringatan!', '<?php echo e(session('warning')); ?>');
        <?php endif; ?>

        <?php if(session('info')): ?>
            showToast('info', 'Informasi!', '<?php echo e(session('info')); ?>');
        <?php endif; ?>

        // Enhanced notification system
        <?php if(session('notification')): ?>
            <?php $notification = session('notification'); ?>
            showEnhancedToast(
                '<?php echo e($notification['type']); ?>',
                '<?php echo e($notification['title']); ?>',
                '<?php echo e($notification['message'] ?? ''); ?>',
                <?php echo json_encode($notification['details'] ?? [], 15, 512) ?>
            );
        <?php endif; ?>

        // Confirmation dialogs
        window.confirmDelete = function(message = 'Apakah Anda yakin ingin menghapus item ini?') {
            return confirm(message);
        };

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
</html><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/layouts/admin.blade.php ENDPATH**/ ?>