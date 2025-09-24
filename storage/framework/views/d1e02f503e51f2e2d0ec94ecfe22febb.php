
<style>
/* Notification Dropdown Styles */
.notifications-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    color: #6b7280;
}

.loading-spinner {
    width: 24px;
    height: 24px;
    border: 2px solid #e5e7eb;
    border-top: 2px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 0.5rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.notification-item {
    border-bottom: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

.dark .notification-item {
    border-bottom-color: #374151;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item:hover {
    background-color: #f9fafb;
}

.dark .notification-item:hover {
    background-color: #374151;
}

.notification-item.unread {
    background-color: #eff6ff;
    border-left: 4px solid #3b82f6;
}

.dark .notification-item.unread {
    background-color: rgba(59, 130, 246, 0.1);
}

.notification-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-weight: 600;
    font-size: 14px;
    color: #111827;
    margin-bottom: 4px;
    line-height: 1.4;
}

.dark .notification-title {
    color: #f9fafb;
}

.notification-message {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 8px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.dark .notification-message {
    color: #9ca3af;
}

.notification-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 11px;
    color: #9ca3af;
}

.dark .notification-meta {
    color: #6b7280;
}

.notification-actions {
    display: flex;
    gap: 4px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.notification-item:hover .notification-actions {
    opacity: 1;
}

.notification-action-btn {
    width: 24px;
    height: 24px;
    border-radius: 4px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 12px;
}

.notification-action-btn:hover {
    transform: scale(1.1);
}

.btn-mark-read {
    background-color: #f3f4f6;
    color: #6b7280;
}

.btn-mark-read:hover {
    background-color: #10b981;
    color: white;
}

.btn-delete {
    background-color: #fef2f2;
    color: #dc2626;
}

.btn-delete:hover {
    background-color: #dc2626;
    color: white;
}

.dark .btn-mark-read {
    background-color: #374151;
    color: #9ca3af;
}

.dark .btn-delete {
    background-color: rgba(220, 38, 38, 0.1);
    color: #f87171;
}

.no-notifications {
    padding: 2rem;
    text-align: center;
    color: #6b7280;
}

.dark .no-notifications {
    color: #9ca3af;
}

.no-notifications-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 1rem;
    color: #d1d5db;
}

.dark .no-notifications-icon {
    color: #6b7280;
}
</style>

<?php if($notifications && $notifications->count() > 0): ?>
    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="notification-item <?php echo e($notification->is_read ? 'read' : 'unread'); ?>" 
             data-id="<?php echo e($notification->id); ?>">
            
            <div class="flex items-start p-3 gap-3">
                <!-- Icon -->
                <div class="notification-icon
                    <?php if($notification->type == 'student'): ?> bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400
                    <?php elseif($notification->type == 'teacher'): ?> bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400
                    <?php elseif($notification->type == 'gallery' || $notification->type == 'media'): ?> bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400
                    <?php elseif($notification->type == 'video'): ?> bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400
                    <?php else: ?> bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400
                    <?php endif; ?>">
                    
                    <?php if($notification->type == 'student'): ?>
                        <i class="fas fa-user-graduate"></i>
                    <?php elseif($notification->type == 'teacher'): ?>
                        <i class="fas fa-chalkboard-teacher"></i>
                    <?php elseif($notification->type == 'gallery' || $notification->type == 'media'): ?>
                        <i class="fas fa-images"></i>
                    <?php elseif($notification->type == 'video'): ?>
                        <i class="fas fa-video"></i>
                    <?php else: ?>
                        <i class="fas fa-bell"></i>
                    <?php endif; ?>
                    
                    <?php if(!$notification->is_read): ?>
                        <div class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></div>
                    <?php endif; ?>
                </div>
                
                <!-- Content -->
                <div class="notification-content">
                    <div class="notification-title">
                        <?php echo e($notification->title); ?>

                    </div>
                    <div class="notification-message">
                        <?php echo e(Str::limit($notification->message, 80)); ?>

                    </div>
                    <div class="notification-meta">
                        <span><?php echo e($notification->user->name ?? 'System'); ?></span>
                        <span><?php echo e($notification->created_at->diffForHumans()); ?></span>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="notification-actions">
                    <?php if(!$notification->is_read): ?>
                        <button onclick="markNotificationAsRead(<?php echo e($notification->id); ?>)" 
                                class="notification-action-btn btn-mark-read"
                                title="Tandai sebagai dibaca">
                            <i class="fas fa-check"></i>
                        </button>
                    <?php endif; ?>
                    <button onclick="deleteNotification(<?php echo e($notification->id); ?>)" 
                            class="notification-action-btn btn-delete"
                            title="Hapus notifikasi">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <div class="no-notifications">
        <div class="no-notifications-icon">
            <i class="fas fa-bell-slash"></i>
        </div>
        <p class="font-medium">Tidak ada notifikasi</p>
        <p class="text-xs mt-1">Semua notifikasi akan muncul di sini</p>
    </div>
<?php endif; ?>

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
                    updateUnreadCount();
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
                item.style.backgroundColor = '';
                item.style.borderLeft = '';
                
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
</script><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/partials/notifications-fixed.blade.php ENDPATH**/ ?>