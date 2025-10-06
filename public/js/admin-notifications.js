/**
 * Enhanced Notification System for Admin Panel
 * Provides toast notifications, progress bars, and auto-dismiss functionality
 */

class AdminNotificationManager {
    constructor() {
        this.container = null;
        this.defaultDuration = 5000;
        this.init();
    }

    init() {
        // Create toast container if it doesn't exist
        this.container = document.getElementById('toastContainer');
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = 'toastContainer';
            this.container.className = 'toast-container';
            document.body.appendChild(this.container);
        }

        // Initialize auto-dismiss for existing alerts
        this.initAlertAutoDismiss();
        
        // Check for session messages and show toast
        this.checkSessionMessages();
        
        console.log('🎉 Admin Notification Manager initialized!');
    }

    initAlertAutoDismiss() {
        const alerts = document.querySelectorAll('.alert-container');
        alerts.forEach(alert => {
            const progressBar = alert.querySelector('.progress-bar');
            if (progressBar) {
                this.startProgressBar(progressBar, this.defaultDuration, () => {
                    this.dismissAlert(alert.id);
                });
            }
        });
    }

    checkSessionMessages() {
        // Check if there are session messages and convert them to toasts
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        const warningAlert = document.getElementById('warningAlert');
        const infoAlert = document.getElementById('infoAlert');
        
        if (successAlert) {
            const message = successAlert.querySelector('.alert-message').textContent;
            setTimeout(() => {
                this.showToast('success', 'Berhasil!', message, 7000);
            }, 500);
        }
        
        if (errorAlert) {
            const message = errorAlert.querySelector('.alert-message').textContent;
            setTimeout(() => {
                this.showToast('error', 'Error!', message, 8000);
            }, 500);
        }
        
        if (warningAlert) {
            const message = warningAlert.querySelector('.alert-message').textContent;
            setTimeout(() => {
                this.showToast('warning', 'Peringatan!', message, 6000);
            }, 500);
        }
        
        if (infoAlert) {
            const message = infoAlert.querySelector('.alert-message').textContent;
            setTimeout(() => {
                this.showToast('info', 'Informasi', message, 5000);
            }, 500);
        }
    }

    showToast(type, title, message, duration = null) {
        if (!duration) duration = this.defaultDuration;
        
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        const iconMap = {
            success: 'fas fa-check',
            error: 'fas fa-times',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="${iconMap[type]}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="window.adminNotifications.removeToast(this.parentElement)">
                <i class="fas fa-times"></i>
            </button>
            <div class="toast-progress"></div>
        `;
        
        this.container.appendChild(toast);
        
        // Trigger show animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        // Start progress bar
        const progressBar = toast.querySelector('.toast-progress');
        this.startProgressBar(progressBar, duration, () => {
            this.removeToast(toast);
        });
        
        // Add click to dismiss
        toast.addEventListener('click', (e) => {
            if (!e.target.closest('.toast-close')) {
                this.removeToast(toast);
            }
        });
        
        return toast;
    }

    startProgressBar(progressBar, duration, callback) {
        if (!progressBar) return;
        
        let width = 100;
        const interval = 50;
        const decrement = (100 / duration) * interval;
        
        progressBar.style.width = width + '%';
        
        const timer = setInterval(() => {
            width -= decrement;
            if (width <= 0) {
                clearInterval(timer);
                if (callback) callback();
            } else {
                progressBar.style.width = width + '%';
            }
        }, interval);
        
        // Store timer reference for manual dismissal
        progressBar._timer = timer;
        
        // Pause on hover
        if (progressBar.closest('.toast')) {
            const toast = progressBar.closest('.toast');
            toast.addEventListener('mouseenter', () => {
                clearInterval(timer);
            });
            
            toast.addEventListener('mouseleave', () => {
                this.startProgressBar(progressBar, width * (duration / 100), callback);
            });
        }
    }

    removeToast(toast) {
        if (!toast) return;
        
        // Clear timer if exists
        const progressBar = toast.querySelector('.toast-progress');
        if (progressBar && progressBar._timer) {
            clearInterval(progressBar._timer);
        }
        
        toast.classList.add('hide');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.parentElement.removeChild(toast);
            }
        }, 300);
    }

    dismissAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.style.transform = 'translateY(-100%)';
            alert.style.opacity = '0';
            setTimeout(() => {
                if (alert.parentElement) {
                    alert.parentElement.removeChild(alert);
                }
            }, 300);
        }
    }

    // Quick methods for different notification types
    success(title, message, duration) {
        return this.showToast('success', title, message, duration);
    }

    error(title, message, duration) {
        return this.showToast('error', title, message, duration);
    }

    warning(title, message, duration) {
        return this.showToast('warning', title, message, duration);
    }

    info(title, message, duration) {
        return this.showToast('info', title, message, duration);
    }

    // Settings-specific notifications
    settingsUpdated(updatedFields = []) {
        let message = 'Pengaturan berhasil diperbarui!';
        if (updatedFields.length > 0) {
            message += ` (${updatedFields.join(', ')})`;
        }
        return this.success('Berhasil!', message, 7000);
    }

    fileUploaded(fileName) {
        return this.success('Upload Berhasil!', `File ${fileName} berhasil diupload`, 5000);
    }

    validationError(message) {
        return this.error('Validasi Error!', message, 6000);
    }

    systemError(message) {
        return this.error('System Error!', message || 'Terjadi kesalahan sistem', 8000);
    }

    processing(message = 'Memproses...') {
        return this.info('Processing', message, 10000);
    }

    // Clear all notifications
    clearAll() {
        const toasts = this.container.querySelectorAll('.toast');
        toasts.forEach(toast => this.removeToast(toast));
    }
}

// Form Enhancement Class
class AdminFormEnhancer {
    constructor(notificationManager) {
        this.notifications = notificationManager;
        this.init();
    }

    init() {
        this.enhanceFormSubmission();
        this.enableRealTimeValidation();
        this.setupAutoSave();
    }

    enhanceFormSubmission() {
        const form = document.getElementById('settingsForm');
        const saveButton = document.getElementById('saveButton');
        
        if (!form || !saveButton) return;
        
        form.addEventListener('submit', (e) => {
            // Show loading state
            saveButton.classList.add('btn-loading');
            saveButton.disabled = true;
            
            // Show processing notification
            this.notifications.processing('Menyimpan pengaturan, mohon tunggu...');
            
            // Store original form data for comparison
            const formData = new FormData(form);
            const changedFields = [];
            
            // Detect which fields have changed
            for (let [key, value] of formData.entries()) {
                if (key !== '_token' && key !== '_method' && value) {
                    changedFields.push(this.formatFieldName(key));
                }
            }
            
            // Store changed fields in session storage for post-redirect display
            if (changedFields.length > 0) {
                sessionStorage.setItem('changedFields', JSON.stringify(changedFields));
            }
        });
    }

    enableRealTimeValidation() {
        const form = document.getElementById('settingsForm');
        if (!form) return;
        
        const inputs = form.querySelectorAll('input[required], select[required]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                if (input.hasAttribute('required') && input.value.trim() === '') {
                    input.classList.add('error');
                    this.notifications.warning('Validasi', `Field ${this.formatFieldName(input.name)} tidak boleh kosong`, 3000);
                } else {
                    input.classList.remove('error');
                }
            });
            
            input.addEventListener('input', () => {
                if (input.classList.contains('error') && input.value.trim() !== '') {
                    input.classList.remove('error');
                }
            });
        });
    }

    setupAutoSave() {
        // Optional auto-save functionality
        const form = document.getElementById('settingsForm');
        if (!form) return;
        
        let autoSaveTimeout;
        const inputs = form.querySelectorAll('input:not([type=\"file\"]), select, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                clearTimeout(autoSaveTimeout);
                
                // Show auto-save indicator
                this.notifications.info('Auto-save', 'Perubahan akan disimpan otomatis dalam 3 detik...', 3000);
                
                autoSaveTimeout = setTimeout(() => {
                    console.log('Auto-save triggered for:', input.name);
                    // Implement auto-save logic here if needed
                }, 3000);
            });
        });
    }

    formatFieldName(fieldName) {
        return fieldName.replace(/_/g, ' ')
                       .replace(/\b\w/g, l => l.toUpperCase());
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize notification system
    window.adminNotifications = new AdminNotificationManager();
    
    // Initialize form enhancer
    window.adminFormEnhancer = new AdminFormEnhancer(window.adminNotifications);
    
    // Global function for dismissing alerts (backward compatibility)
    window.dismissAlert = function(alertId) {
        window.adminNotifications.dismissAlert(alertId);
    };
    
    // Check for post-redirect success messages
    const changedFields = sessionStorage.getItem('changedFields');
    if (changedFields) {
        const fields = JSON.parse(changedFields);
        setTimeout(() => {
            window.adminNotifications.settingsUpdated(fields);
        }, 1000);
        sessionStorage.removeItem('changedFields');
    }
    
    console.log('🚀 Admin notification system fully loaded!');
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { AdminNotificationManager, AdminFormEnhancer };
}