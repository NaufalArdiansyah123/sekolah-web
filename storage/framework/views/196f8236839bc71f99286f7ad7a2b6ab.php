<?php
// resources/views/layouts/student/navbar.blade.php - Student Navigation Bar
?>
<header class="w-full">
    <div class="relative z-10 flex-shrink-0 h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm flex">
        <div class="flex-1 flex justify-between px-4 sm:px-6">
            <!-- Left Side -->
            <div class="flex items-center space-x-4">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = true" 
                        class="border-r border-gray-200 dark:border-gray-700 px-4 text-gray-500 dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500 md:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <!-- Page Title -->
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <?php echo e($pageTitle ?? 'Student Dashboard'); ?>

                </h1>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <button @click="toggleDarkMode()" 
                        class="bg-gray-100 dark:bg-gray-700 p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200"
                        title="Toggle Dark Mode">
                    <svg x-show="!darkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                    </svg>
                    <svg x-show="darkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                    </svg>
                </button>

                <!-- Notifications -->
                <div class="relative" x-data="notificationDropdown()" x-init="init()">
                    <button @click="toggleNotifications()" 
                            class="relative bg-white dark:bg-gray-800 p-2 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-3.5-3.5a1.5 1.5 0 010-2.12l.7-.7a1 1 0 00.3-.7V8a6 6 0 10-12 0v2.58a1 1 0 00.3.7l.7.7a1.5 1.5 0 010 2.12L3 17h5m7 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <!-- Notification Badge -->
                        <span x-show="notificationCount > 0" 
                              x-text="notificationCount > 99 ? '99+' : notificationCount"
                              class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold animate-pulse"></span>
                    </button>
                    
                    <!-- Notifications Dropdown -->
                    <div x-show="notificationsOpen" 
                         @click.away="notificationsOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-96 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 z-50 max-h-96 overflow-hidden"
                         style="display: none;">
                        
                        <!-- Header -->
                        <div class="px-4 py-3 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifikasi</h3>
                                <span x-text="notificationCount" class="bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200 text-xs px-2 py-1 rounded-full"></span>
                            </div>
                        </div>
                        
                        <!-- Notifications List -->
                        <div class="max-h-80 overflow-y-auto">
                            <template x-if="notifications.length === 0">
                                <div class="px-4 py-8 text-center">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-3.5-3.5a1.5 1.5 0 010-2.12l.7-.7a1 1 0 00.3-.7V8a6 6 0 10-12 0v2.58a1 1 0 00.3.7l.7.7a1.5 1.5 0 010 2.12L3 17h5m7 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">Tidak ada notifikasi</p>
                                </div>
                            </template>
                            
                            <template x-for="notification in notifications" :key="notification.id">
                                <a :href="notification.url" 
                                   class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                    <div class="flex items-start space-x-3">
                                        <!-- Icon -->
                                        <div class="flex-shrink-0">
                                            <div :class="getColorClass(notification.color)" class="w-8 h-8 rounded-full flex items-center justify-center text-sm">
                                                <span x-text="notification.icon"></span>
                                            </div>
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification.title"></p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="notification.message"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1" x-text="notification.time"></p>
                                        </div>
                                        
                                        <!-- Urgency Indicator -->
                                        <template x-if="notification.urgency === 'urgent'">
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                                            </div>
                                        </template>
                                    </div>
                                </a>
                            </template>
                        </div>
                        
                        <!-- Footer -->
                        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="<?php echo e(route('student.assignments.index')); ?>" class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-medium">
                                Lihat Semua Tugas →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Access Menu -->
                <div class="relative" x-data="{ quickMenuOpen: false }">
                    <button @click="quickMenuOpen = !quickMenuOpen" 
                            class="bg-white dark:bg-gray-800 p-2 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 relative transition-all duration-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </button>
                    
                    <!-- Quick Access dropdown -->
                    <div x-show="quickMenuOpen" 
                         @click.away="quickMenuOpen = false" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-1" 
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" 
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-1" 
                         class="absolute right-0 mt-3 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden"
                         style="display: none;">
                        
                        <!-- Header -->
                        <div class="px-4 py-3 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Akses Cepat</h3>
                            </div>
                        </div>
                        
                        <!-- Quick Access Items -->
                        <div class="p-4 space-y-2">
                            <a href="<?php echo e(route('student.materials.index')); ?>" 
                               class="flex items-center p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors duration-200">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span class="text-emerald-700 dark:text-emerald-300 font-medium">Semua Materi</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User dropdown -->
                <div class="relative" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" 
                            class="max-w-xs bg-white dark:bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <img class="h-8 w-8 rounded-full" 
                             src="<?php echo e(auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=10B981&background=D1FAE5'); ?>" 
                             alt="<?php echo e(auth()->user()->name); ?>">
                        <span class="hidden md:block ml-3 text-gray-700 dark:text-gray-300 text-sm font-medium"><?php echo e(auth()->user()->name); ?></span>
                        <svg class="hidden md:block ml-2 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    
                    <!-- User dropdown menu -->
                    <div x-show="userOpen" 
                         @click.away="userOpen = false" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="transform opacity-0 scale-95" 
                         x-transition:enter-end="transform opacity-100 scale-100" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="transform opacity-100 scale-100" 
                         x-transition:leave-end="transform opacity-0 scale-95" 
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700"
                         style="display: none;">
                        <a href="<?php echo e(route('student.dashboard')); ?>" 
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        <a href="#" 
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile Saya
                        </a>
                        <div class="border-t border-gray-100 dark:border-gray-700"></div>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" 
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('alpine:init', () => {
    // Simple dropdown handling for student navbar
    document.addEventListener('click', function(e) {
        // Close all dropdowns when clicking outside
        if (!e.target.closest('[x-data]')) {
            // Reset all dropdown states
            Alpine.store('dropdowns', {
                userOpen: false,
                quickMenuOpen: false
            });
        }
    });
});
</script><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/layouts/student/navbar.blade.php ENDPATH**/ ?>