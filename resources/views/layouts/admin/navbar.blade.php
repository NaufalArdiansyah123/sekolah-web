<?php
// resources/views/layouts/admin/navbar.blade.php - Simple Working Version
?>
<header class="w-full">
    <div class="relative z-10 flex-shrink-0 h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm flex">
        <div class="flex-1 flex justify-between px-4 sm:px-6">
            <!-- Left Side -->
            <div class="flex items-center space-x-4">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = true" 
                        class="border-r border-gray-200 dark:border-gray-700 px-4 text-gray-500 dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 md:hidden">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <!-- Page Title -->
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $pageTitle ?? 'Dashboard' }}
                </h1>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <button @click="toggleDarkMode()" 
                        class="bg-gray-100 dark:bg-gray-700 p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        title="Toggle Dark Mode">
                    <svg x-show="!darkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                    </svg>
                    <svg x-show="darkMode" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                    </svg>
                </button>

                <!-- Notifications -->
                <div class="relative" x-data="{ notificationOpen: false, unreadCount: {{ $unreadCount ?? 0 }} }">
                    <button @click="notificationOpen = !notificationOpen; loadNotifications()" 
                            class="notification-bell bg-white dark:bg-gray-800 p-2 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 relative transition-all duration-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span x-show="unreadCount > 0" 
                              x-text="unreadCount > 99 ? '99+' : unreadCount"
                              class="notification-count-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold notification-badge"></span>
                    </button>
                    
                    <!-- Enhanced Notifications dropdown -->
                    <div x-show="notificationOpen" 
                         @click.away="notificationOpen = false" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-1" 
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" 
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-1" 
                         class="absolute right-0 mt-3 w-96 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden"
                         style="display: none;">
                        
                        <!-- Enhanced Header -->
                        <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifikasi</h3>
                                    <span x-show="unreadCount > 0" 
                                          x-text="unreadCount"
                                          class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200"></span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <button @click="markAllAsRead()" 
                                            class="text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200"
                                            title="Tandai semua sebagai dibaca">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <a href="{{ route('admin.notifications.index') }}" 
                                       class="text-xs font-medium text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 transition-colors duration-200"
                                       title="Lihat semua notifikasi">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Enhanced Notifications List -->
                        <div class="max-h-80 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-transparent" id="notifications-list">
                            <div class="notifications-loading">
                                <div class="loading-spinner"></div>
                                <span class="text-sm">Memuat notifikasi...</span>
                            </div>
                        </div>
                        
                        <!-- Enhanced Footer -->
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('admin.notifications.index') }}" 
                               class="flex items-center justify-center space-x-2 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
                                <span>Lihat Semua Notifikasi</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User dropdown -->
                <div class="relative" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" 
                            class="max-w-xs bg-white dark:bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <img class="h-8 w-8 rounded-full" 
                             src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF' }}" 
                             alt="{{ auth()->user()->name }}">
                        <span class="hidden md:block ml-3 text-gray-700 dark:text-gray-300 text-sm font-medium">{{ auth()->user()->name }}</span>
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
                        <a href="{{ route('admin.profile') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Your Profile
                        </a>
                        <a href="{{ route('admin.settings') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Settings
                        </a>
                        <a href="{{ route('home') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Home
                        </a>
                        <div class="border-t border-gray-100 dark:border-gray-700"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
// Notification functions
function loadNotifications() {
    fetch('/admin/notifications/recent')
        .then(response => response.json())
        .then(data => {
            document.getElementById('notifications-list').innerHTML = data.html;
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            document.getElementById('notifications-list').innerHTML = 
                '<div class="p-4 text-center text-red-500">Gagal memuat notifikasi</div>';
        });
}

function markAllAsRead() {
    fetch('/admin/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update unread count
            const countElement = document.querySelector('[x-data] span[x-text]');
            if (countElement) {
                countElement.style.display = 'none';
            }
            // Reload notifications
            loadNotifications();
        }
    })
    .catch(error => console.error('Error marking notifications as read:', error));
}

function markNotificationAsRead(notificationId) {
    fetch(`/admin/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the notification item
            const item = document.querySelector(`[data-id="${notificationId}"]`);
            if (item) {
                item.classList.remove('unread');
                item.classList.add('read');
            }
            // Update unread count
            updateUnreadCount();
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}

function updateUnreadCount() {
    fetch('/admin/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const countElement = document.querySelector('[x-data] span[x-text]');
            if (countElement) {
                if (data.count > 0) {
                    countElement.textContent = data.count > 99 ? '99+' : data.count;
                    countElement.style.display = 'flex';
                } else {
                    countElement.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error updating unread count:', error));
}

// Auto-refresh notifications every 30 seconds
setInterval(updateUnreadCount, 30000);

document.addEventListener('alpine:init', () => {
    // Simple dropdown handling
    document.addEventListener('click', function(e) {
        // Close all dropdowns when clicking outside
        if (!e.target.closest('[x-data]')) {
            // Reset all dropdown states
            Alpine.store('dropdowns', {
                userOpen: false,
                notificationOpen: false
            });
        }
    });
});
</script>