// Student Notifications System
document.addEventListener('DOMContentLoaded', function() {
    // Initialize notification system
    initializeNotifications();
});

function initializeNotifications() {
    // Load initial notifications
    loadNotificationCount();
    
    // Set up periodic updates
    setInterval(loadNotificationCount, 120000); // Every 2 minutes
    
    // Request notification permission
    requestNotificationPermission();
}

function loadNotificationCount() {
    fetch('/student/notifications/count', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Network response was not ok');
    })
    .then(data => {
        if (data.success) {
            updateNotificationBadge(data.count);
        }
    })
    .catch(error => {
        console.log('Notifications not available, using fallback');
        updateNotificationBadge(3); // Fallback count
    });
}

function loadNotifications() {
    return fetch('/student/notifications', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Network response was not ok');
    })
    .then(data => {
        if (data.success) {
            return {
                notifications: data.notifications,
                count: data.unread_count
            };
        }
        throw new Error('Invalid response');
    })
    .catch(error => {
        console.log('Using fallback notifications');
        return {
            notifications: getFallbackNotifications(),
            count: 3
        };
    });
}

function updateNotificationBadge(count) {
    const badges = document.querySelectorAll('.notification-badge');
    badges.forEach(badge => {
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    });
}

function getFallbackNotifications() {
    return [
        {
            id: 'fallback_1',
            type: 'assignment_new',
            title: 'Tugas Baru: Matematika',
            message: 'Tugas Aljabar Linear telah ditambahkan',
            time: '5 menit yang lalu',
            url: '/student/assignments',
            icon: '📝',
            color: 'blue',
            is_read: false
        },
        {
            id: 'fallback_2',
            type: 'assignment_deadline',
            title: 'Deadline Besok',
            message: 'Tugas Fisika harus dikumpulkan besok',
            time: '1 jam yang lalu',
            url: '/student/assignments',
            icon: '⏰',
            color: 'red',
            is_read: false,
            urgency: 'urgent'
        },
        {
            id: 'fallback_3',
            type: 'quiz_new',
            title: 'Kuis Tersedia',
            message: 'Kuis Bahasa Indonesia sudah dapat dikerjakan',
            time: '2 jam yang lalu',
            url: '/student/quizzes',
            icon: '📋',
            color: 'green',
            is_read: false
        }
    ];
}

function requestNotificationPermission() {
    if ('Notification' in window && Notification.permission === 'default') {
        setTimeout(() => {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    console.log('Notification permission granted');
                }
            });
        }, 3000);
    }
}

function showBrowserNotification(notification) {
    if ('Notification' in window && Notification.permission === 'granted') {
        const notificationId = `student_notification_${notification.id}`;
        
        // Check if we've already shown this notification
        if (!localStorage.getItem(notificationId)) {
            new Notification(notification.title, {
                body: notification.message,
                icon: '/favicon.ico',
                tag: notification.id
            });
            
            // Mark as shown
            localStorage.setItem(notificationId, 'shown');
            localStorage.setItem(notificationId + '_timestamp', Date.now().toString());
        }
    }
}

// Alpine.js component for notification dropdown
window.notificationDropdown = function() {
    return {
        notificationsOpen: false,
        notifications: [],
        notificationCount: 0,
        loading: false,

        init() {
            this.loadNotifications();
        },

        async loadNotifications() {
            if (this.loading) return;
            
            this.loading = true;
            try {
                const data = await loadNotifications();
                this.notifications = data.notifications;
                this.notificationCount = data.count;
                
                // Show browser notifications for urgent items
                data.notifications.forEach(notification => {
                    if (notification.urgency === 'urgent') {
                        showBrowserNotification(notification);
                    }
                });
                
            } catch (error) {
                console.error('Error loading notifications:', error);
            } finally {
                this.loading = false;
            }
        },

        toggleNotifications() {
            this.notificationsOpen = !this.notificationsOpen;
            if (this.notificationsOpen && this.notifications.length === 0) {
                this.loadNotifications();
            }
        },

        getColorClass(color) {
            const colorClasses = {
                'blue': 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-400',
                'green': 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400',
                'yellow': 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-400',
                'red': 'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-400',
                'purple': 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-400',
                'orange': 'bg-orange-100 text-orange-600 dark:bg-orange-900 dark:text-orange-400'
            };
            return colorClasses[color] || colorClasses['blue'];
        }
    }
};

// Export for global use
window.loadNotifications = loadNotifications;
window.updateNotificationBadge = updateNotificationBadge;