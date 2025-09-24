<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo $__env->yieldContent('title', 'SuperAdmin Dashboard'); ?> - <?php echo e(config('app.name', 'Sekolah Web')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Additional Styles -->
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-red-600 to-red-800 dark:from-red-800 dark:to-red-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" 
             x-data="{ open: false }" 
             x-bind:class="{ 'translate-x-0': open, '-translate-x-full': !open }">
            
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-red-700 dark:bg-red-900">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-crown text-red-600 text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold text-white">SuperAdmin</h1>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8 px-4">
                <div class="space-y-2">
                    <!-- Dashboard -->
                    <a href="<?php echo e(route('superadmin.dashboard')); ?>" 
                       class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors duration-200 <?php echo e(request()->routeIs('superadmin.dashboard') ? 'bg-red-700 dark:bg-red-800' : ''); ?>">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- User Management -->
                    <div x-data="{ open: <?php echo e(request()->routeIs('superadmin.users.*') ? 'true' : 'false'); ?> }">
                        <button @click="open = !open" 
                                class="flex items-center justify-between w-full px-4 py-3 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors duration-200">
                            <div class="flex items-center">
                                <i class="fas fa-users mr-3"></i>
                                <span>Manajemen User</span>
                            </div>
                            <i class="fas fa-chevron-down transform transition-transform duration-200" x-bind:class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-transition class="ml-6 mt-2 space-y-1">
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-list mr-2"></i>Semua User
                            </a>
                            <a href="<?php echo e(route('superadmin.users.roles')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-user-tag mr-2"></i>Role & Permission
                            </a>
                            <a href="<?php echo e(route('superadmin.users.analytics')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-chart-bar mr-2"></i>Analytics User
                            </a>
                        </div>
                    </div>
                    
                    <!-- Academic Management -->
                    <div x-data="{ open: <?php echo e(request()->routeIs('superadmin.academic.*') ? 'true' : 'false'); ?> }">
                        <button @click="open = !open" 
                                class="flex items-center justify-between w-full px-4 py-3 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors duration-200">
                            <div class="flex items-center">
                                <i class="fas fa-graduation-cap mr-3"></i>
                                <span>Akademik</span>
                            </div>
                            <i class="fas fa-chevron-down transform transition-transform duration-200" x-bind:class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-transition class="ml-6 mt-2 space-y-1">
                            <a href="<?php echo e(route('admin.students.index')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-user-graduate mr-2"></i>Data Siswa
                            </a>
                            <a href="<?php echo e(route('teacher.dashboard')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>Data Guru
                            </a>
                            <a href="<?php echo e(route('superadmin.academic.classes')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-school mr-2"></i>Kelas
                            </a>
                        </div>
                    </div>
                    
                    <!-- Security -->
                    <div x-data="{ open: <?php echo e(request()->routeIs('superadmin.security.*') ? 'true' : 'false'); ?> }">
                        <button @click="open = !open" 
                                class="flex items-center justify-between w-full px-4 py-3 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors duration-200">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt mr-3"></i>
                                <span>Keamanan</span>
                            </div>
                            <i class="fas fa-chevron-down transform transition-transform duration-200" x-bind:class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-transition class="ml-6 mt-2 space-y-1">
                            <a href="<?php echo e(route('admin.security-violations.index')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Pelanggaran QR
                            </a>
                            <a href="<?php echo e(route('superadmin.security.logs')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-file-alt mr-2"></i>Log Keamanan
                            </a>
                            <a href="<?php echo e(route('superadmin.security.monitoring')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-eye mr-2"></i>Monitoring
                            </a>
                        </div>
                    </div>
                    
                    <!-- System -->
                    <div x-data="{ open: <?php echo e(request()->routeIs('superadmin.system.*') ? 'true' : 'false'); ?> }">
                        <button @click="open = !open" 
                                class="flex items-center justify-between w-full px-4 py-3 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors duration-200">
                            <div class="flex items-center">
                                <i class="fas fa-cogs mr-3"></i>
                                <span>Sistem</span>
                            </div>
                            <i class="fas fa-chevron-down transform transition-transform duration-200" x-bind:class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-transition class="ml-6 mt-2 space-y-1">
                            <a href="<?php echo e(route('superadmin.system.settings')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-sliders-h mr-2"></i>Pengaturan
                            </a>
                            <a href="<?php echo e(route('superadmin.system.database')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-database mr-2"></i>Database
                            </a>
                            <a href="<?php echo e(route('superadmin.system.maintenance')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-tools mr-2"></i>Maintenance
                            </a>
                            <a href="<?php echo e(route('superadmin.system.logs')); ?>" class="block px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                                <i class="fas fa-file-code mr-2"></i>System Logs
                            </a>
                        </div>
                    </div>
                    
                    <!-- Quick Access to Other Dashboards -->
                    <div class="border-t border-red-500 pt-4 mt-4">
                        <p class="text-red-200 text-xs uppercase tracking-wider px-4 mb-2">Quick Access</p>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                            <i class="fas fa-user-tie mr-3"></i>
                            <span>Admin Dashboard</span>
                        </a>
                        <a href="<?php echo e(route('teacher.dashboard')); ?>" class="flex items-center px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                            <i class="fas fa-chalkboard-teacher mr-3"></i>
                            <span>Teacher Dashboard</span>
                        </a>
                        <a href="<?php echo e(route('student.dashboard')); ?>" class="flex items-center px-4 py-2 text-red-100 hover:text-white hover:bg-red-700 dark:hover:bg-red-800 rounded transition-colors duration-200">
                            <i class="fas fa-user-graduate mr-3"></i>
                            <span>Student Dashboard</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile menu button -->
                    <button @click="open = !open" class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Page Title -->
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            <?php echo $__env->yieldContent('page-title', 'SuperAdmin Dashboard'); ?>
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <?php echo $__env->yieldContent('page-description', 'Kontrol penuh sistem sekolah'); ?>
                        </p>
                    </div>
                    
                    <!-- Right side -->
                    <div class="flex items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                                class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-moon" x-show="!darkMode"></i>
                            <i class="fas fa-sun" x-show="darkMode"></i>
                        </button>
                        
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 relative">
                                <i class="fas fa-bell"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition 
                                 class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifikasi</h3>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-600">
                                        <p class="text-sm text-gray-900 dark:text-white">Pelanggaran QR Code baru terdeteksi</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">2 menit yang lalu</p>
                                    </div>
                                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-600">
                                        <p class="text-sm text-gray-900 dark:text-white">User baru mendaftar</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">5 menit yang lalu</p>
                                    </div>
                                </div>
                                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="#" class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Lihat semua notifikasi</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-crown text-white text-sm"></i>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e(auth()->user()->name); ?></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Super Administrator</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition 
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                <div class="py-2">
                                    <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-user mr-2"></i>Profile
                                    </a>
                                    <a href="<?php echo e(route('superadmin.system.settings')); ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-cogs mr-2"></i>Settings
                                    </a>
                                    <div class="border-t border-gray-100 dark:border-gray-600 my-1"></div>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-6 bg-gray-50 dark:bg-gray-900">
                <?php if(session('success')): ?>
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span><?php echo e(session('success')); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if(session('error')): ?>
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span><?php echo e(session('error')); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/layouts/superadmin.blade.php ENDPATH**/ ?>