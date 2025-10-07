{{-- Clean Notifications Dropdown Partial --}}
@if($notifications && $notifications->count() > 0)
    @foreach($notifications as $notification)
        <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}" 
             data-id="{{ $notification->id }}">
            
            <div class="flex items-start p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 group {{ !$notification->is_read ? 'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500' : '' }}">
                
                <!-- Icon -->
                <div class="flex-shrink-0 mr-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center relative
                        @if($notification->type == 'student') bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400
                        @elseif($notification->type == 'teacher') bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400
                        @elseif($notification->type == 'gallery' || $notification->type == 'media') bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400
                        @elseif($notification->type == 'video') bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400
                        @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400
                        @endif">
                        
                        @if($notification->type == 'student')
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($notification->type == 'teacher')
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"></path>
                            </svg>
                        @elseif($notification->type == 'gallery' || $notification->type == 'media')
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($notification->type == 'video')
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                            </svg>
                        @endif
                        
                        @if(!$notification->is_read)
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white dark:border-gray-800"></div>
                        @endif
                    </div>
                </div>
                
                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">
                        {{ $notification->title }}
                    </div>
                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-2 line-clamp-2">
                        {{ Str::limit($notification->message, 80) }}
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $notification->user->name ?? 'System' }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $notification->time_ago }}
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex-shrink-0 ml-2 flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    @if(!$notification->is_read)
                        <button onclick="markNotificationAsRead({{ $notification->id }})" 
                                class="p-1 rounded text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors duration-200"
                                title="Tandai sebagai dibaca">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    @endif
                    <button onclick="deleteNotification({{ $notification->id }})" 
                            class="p-1 rounded text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                            title="Hapus notifikasi">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 102 0v3a1 1 0 11-2 0V9zm4 0a1 1 0 10-2 0v3a1 1 0 102 0V9z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="p-8 text-center">
        <div class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600">
            <svg fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
            </svg>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Tidak ada notifikasi</p>
        <p class="text-xs text-gray-400 dark:text-gray-500">Semua notifikasi akan muncul di sini</p>
    </div>
@endif

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
function deleteNotification(notificationId) {
    if (!confirm('Hapus notifikasi ini?')) return;
    
    fetch(`/admin/notifications/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.querySelector(`[data-id="${notificationId}"]`);
            if (item) {
                item.style.transition = 'all 0.3s ease';
                item.style.opacity = '0';
                item.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    item.remove();
                    loadNotifications();
                }, 300);
            }
        } else {
            alert('Gagal menghapus notifikasi');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
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
            const item = document.querySelector(`[data-id="${notificationId}"]`);
            if (item) {
                item.classList.remove('unread');
                item.classList.add('read');
                
                // Remove unread styling
                const content = item.querySelector('.flex');
                if (content) {
                    content.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'border-l-4', 'border-blue-500');
                }
                
                // Remove unread dot
                const unreadDot = item.querySelector('.bg-red-500');
                if (unreadDot) {
                    unreadDot.remove();
                }
                
                // Remove mark as read button
                const markReadBtn = item.querySelector('button[onclick*="markNotificationAsRead"]');
                if (markReadBtn) {
                    markReadBtn.remove();
                }
            }
            
            updateUnreadCount();
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}
</script>