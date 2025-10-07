/**
 * Real-time Assignment Updates
 * Handles real-time communication between teacher and student for assignment grading
 */

class AssignmentRealtime {
    constructor() {
        this.checkInterval = 30000; // Check every 30 seconds
        this.intervalId = null;
        this.isStudent = document.body.classList.contains('student-page');
        this.isTeacher = document.body.classList.contains('teacher-page');
        this.init();
    }

    init() {
        if (this.isStudent) {
            this.initStudentUpdates();
        } else if (this.isTeacher) {
            this.initTeacherUpdates();
        }
    }

    /**
     * Initialize real-time updates for student pages
     */
    initStudentUpdates() {
        // Check for assignment detail page
        const assignmentId = this.getAssignmentIdFromUrl();
        if (assignmentId) {
            this.startGradingStatusCheck(assignmentId);
        }

        // Check for assignment list page
        if (window.location.pathname.includes('/student/assignments') && !assignmentId) {
            this.startAssignmentListUpdates();
        }
    }

    /**
     * Initialize real-time updates for teacher pages
     */
    initTeacherUpdates() {
        // Check for submissions page
        const assignmentId = this.getAssignmentIdFromUrl();
        if (assignmentId && window.location.pathname.includes('/submissions')) {
            this.startSubmissionProgressUpdates(assignmentId);
        }
    }

    /**
     * Start checking grading status for students
     */
    startGradingStatusCheck(assignmentId) {
        this.intervalId = setInterval(() => {
            this.checkGradingStatus(assignmentId);
        }, this.checkInterval);

        // Initial check
        this.checkGradingStatus(assignmentId);
    }

    /**
     * Start checking assignment list updates for students
     */
    startAssignmentListUpdates() {
        this.intervalId = setInterval(() => {
            this.updateAssignmentList();
        }, this.checkInterval);
    }

    /**
     * Start checking submission progress for teachers
     */
    startSubmissionProgressUpdates(assignmentId) {
        this.intervalId = setInterval(() => {
            this.updateSubmissionProgress(assignmentId);
        }, this.checkInterval);
    }

    /**
     * Check if assignment has been graded
     */
    async checkGradingStatus(assignmentId) {
        try {
            const response = await fetch(`/student/assignments/${assignmentId}/status`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.updateGradingStatus(data);
            }
        } catch (error) {
            console.log('Error checking grading status:', error);
        }
    }

    /**
     * Update assignment list with new submissions
     */
    async updateAssignmentList() {
        try {
            const response = await fetch(window.location.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const html = await response.text();
                this.updateAssignmentCards(html);
            }
        } catch (error) {
            console.log('Error updating assignment list:', error);
        }
    }

    /**
     * Update submission progress for teachers
     */
    async updateSubmissionProgress(assignmentId) {
        try {
            const response = await fetch(`/teacher/assignments/${assignmentId}/submissions/progress`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.updateProgressBar(data);
            }
        } catch (error) {
            console.log('Error updating submission progress:', error);
        }
    }

    /**
     * Update grading status on student page
     */
    updateGradingStatus(data) {
        if (data.graded && !document.querySelector('.graded-indicator')) {
            // Assignment has been graded, reload page to show results
            this.showGradedNotification(data);
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        }
    }

    /**
     * Update assignment cards with new status
     */
    updateAssignmentCards(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newCards = doc.querySelectorAll('.assignment-card');
        const currentCards = document.querySelectorAll('.assignment-card');

        newCards.forEach((newCard, index) => {
            if (currentCards[index]) {
                const newStatus = newCard.querySelector('.assignment-status');
                const currentStatus = currentCards[index].querySelector('.assignment-status');
                
                if (newStatus && currentStatus && newStatus.textContent !== currentStatus.textContent) {
                    // Status has changed, update with animation
                    this.animateStatusChange(currentStatus, newStatus.textContent, newStatus.className);
                }
            }
        });
    }

    /**
     * Update progress bar for teachers
     */
    updateProgressBar(data) {
        const progressBar = document.querySelector('.progress-bar');
        const progressText = document.querySelector('.progress-percentage');
        const statsElements = document.querySelectorAll('.stat-value');

        if (progressBar) {
            progressBar.style.width = data.progress_percentage + '%';
        }

        if (progressText) {
            progressText.textContent = data.progress_percentage + '%';
        }

        // Update statistics
        if (statsElements.length >= 4) {
            statsElements[1].textContent = data.graded; // Graded count
            statsElements[2].textContent = data.ungraded; // Ungraded count
            statsElements[3].textContent = data.average_score.toFixed(1); // Average score
        }

        // Show notification if progress changed significantly
        const currentProgress = parseInt(progressBar.style.width) || 0;
        if (data.progress_percentage > currentProgress + 10) {
            this.showProgressNotification(data.progress_percentage);
        }
    }

    /**
     * Show notification when assignment is graded
     */
    showGradedNotification(data) {
        const notification = this.createNotification(
            'success',
            '🎉 Tugas Anda Telah Dinilai!',
            `Nilai: ${data.score}/${data.max_score} (${data.percentage}%)`
        );
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    /**
     * Show progress notification for teachers
     */
    showProgressNotification(percentage) {
        const notification = this.createNotification(
            'info',
            '📊 Progress Update',
            `${percentage}% tugas telah dinilai`
        );
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    /**
     * Animate status change
     */
    animateStatusChange(element, newText, newClass) {
        element.style.transform = 'scale(1.1)';
        element.style.transition = 'all 0.3s ease';
        
        setTimeout(() => {
            element.textContent = newText;
            element.className = newClass;
            element.style.transform = 'scale(1)';
        }, 150);
    }

    /**
     * Create notification element
     */
    createNotification(type, title, message) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg border-l-4 ${
            type === 'success' ? 'border-green-500' : 'border-blue-500'
        } transform transition-all duration-300 translate-x-full`;
        
        notification.innerHTML = `
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">${title}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                            class="ml-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        return notification;
    }

    /**
     * Get assignment ID from current URL
     */
    getAssignmentIdFromUrl() {
        const pathParts = window.location.pathname.split('/');
        const assignmentIndex = pathParts.indexOf('assignments');
        
        if (assignmentIndex !== -1 && pathParts[assignmentIndex + 1]) {
            return pathParts[assignmentIndex + 1];
        }
        
        return null;
    }

    /**
     * Stop real-time updates
     */
    stop() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
    }

    /**
     * Restart real-time updates
     */
    restart() {
        this.stop();
        this.init();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.assignmentRealtime = new AssignmentRealtime();
});

// Clean up when page is unloaded
window.addEventListener('beforeunload', function() {
    if (window.assignmentRealtime) {
        window.assignmentRealtime.stop();
    }
});

// Expose for manual control
window.AssignmentRealtime = AssignmentRealtime;