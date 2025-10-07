/**
 * Enhanced Admin Forms JavaScript
 * Provides interactive functionality for admin forms
 */

class AdminFormsEnhanced {
    constructor() {
        this.init();
    }

    init() {
        this.setupFormValidation();
        this.setupFileUploads();
        this.setupFormAnimations();
        this.setupFormHelpers();
        this.setupFormProgress();
        this.setupAutoSave();
        this.setupFormSubmission();
    }

    /**
     * Setup real-time form validation
     */
    setupFormValidation() {
        // Real-time validation for all form controls
        document.querySelectorAll('.form-control-enhanced, .form-select-enhanced, .form-textarea-enhanced').forEach(field => {
            // Validation on blur
            field.addEventListener('blur', (e) => {
                this.validateField(e.target);
            });

            // Clear validation on input
            field.addEventListener('input', (e) => {
                if (e.target.classList.contains('is-invalid')) {
                    this.clearFieldValidation(e.target);
                }
            });

            // Real-time validation for specific field types
            if (field.type === 'email') {
                field.addEventListener('input', (e) => {
                    this.validateEmail(e.target);
                });
            }

            if (field.type === 'url') {
                field.addEventListener('input', (e) => {
                    this.validateUrl(e.target);
                });
            }

            if (field.type === 'tel') {
                field.addEventListener('input', (e) => {
                    this.validatePhone(e.target);
                });
            }
        });

        // Password confirmation validation
        document.querySelectorAll('input[name="password_confirmation"]').forEach(field => {
            field.addEventListener('input', (e) => {
                this.validatePasswordConfirmation(e.target);
            });
        });

        // Form submission validation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                    this.showFormErrors(form);
                }
            });
        });
    }

    /**
     * Validate individual field
     */
    validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        const fieldType = field.type;
        const minLength = field.getAttribute('minlength');
        const maxLength = field.getAttribute('maxlength');
        const pattern = field.getAttribute('pattern');

        // Clear previous validation
        this.clearFieldValidation(field);

        // Required field validation
        if (isRequired && !value) {
            this.setFieldInvalid(field, 'Field ini wajib diisi');
            return false;
        }

        // Skip further validation if field is empty and not required
        if (!value && !isRequired) {
            return true;
        }

        // Length validation
        if (minLength && value.length < parseInt(minLength)) {
            this.setFieldInvalid(field, `Minimal ${minLength} karakter`);
            return false;
        }

        if (maxLength && value.length > parseInt(maxLength)) {
            this.setFieldInvalid(field, `Maksimal ${maxLength} karakter`);
            return false;
        }

        // Pattern validation
        if (pattern && !new RegExp(pattern).test(value)) {
            this.setFieldInvalid(field, 'Format tidak valid');
            return false;
        }

        // Type-specific validation
        switch (fieldType) {
            case 'email':
                return this.validateEmail(field);
            case 'url':
                return this.validateUrl(field);
            case 'tel':
                return this.validatePhone(field);
            case 'number':
                return this.validateNumber(field);
        }

        this.setFieldValid(field);
        return true;
    }

    /**
     * Email validation
     */
    validateEmail(field) {
        const email = field.value.trim();
        if (!email) return true;

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            this.setFieldInvalid(field, 'Format email tidak valid');
            return false;
        }

        this.setFieldValid(field, 'Email valid');
        return true;
    }

    /**
     * URL validation
     */
    validateUrl(field) {
        const url = field.value.trim();
        if (!url) return true;

        try {
            new URL(url);
            this.setFieldValid(field, 'URL valid');
            return true;
        } catch {
            this.setFieldInvalid(field, 'Format URL tidak valid');
            return false;
        }
    }

    /**
     * Phone validation
     */
    validatePhone(field) {
        const phone = field.value.trim();
        if (!phone) return true;

        const phoneRegex = /^[\+]?[0-9\-\(\)\s]+$/;
        if (!phoneRegex.test(phone)) {
            this.setFieldInvalid(field, 'Format nomor telepon tidak valid');
            return false;
        }

        this.setFieldValid(field, 'Nomor telepon valid');
        return true;
    }

    /**
     * Number validation
     */
    validateNumber(field) {
        const value = field.value.trim();
        if (!value) return true;

        const min = field.getAttribute('min');
        const max = field.getAttribute('max');
        const step = field.getAttribute('step');
        const numValue = parseFloat(value);

        if (isNaN(numValue)) {
            this.setFieldInvalid(field, 'Harus berupa angka');
            return false;
        }

        if (min && numValue < parseFloat(min)) {
            this.setFieldInvalid(field, `Minimal ${min}`);
            return false;
        }

        if (max && numValue > parseFloat(max)) {
            this.setFieldInvalid(field, `Maksimal ${max}`);
            return false;
        }

        if (step && (numValue % parseFloat(step)) !== 0) {
            this.setFieldInvalid(field, `Harus kelipatan ${step}`);
            return false;
        }

        this.setFieldValid(field);
        return true;
    }

    /**
     * Password confirmation validation
     */
    validatePasswordConfirmation(field) {
        const password = document.querySelector('input[name="password"]');
        if (!password) return true;

        const passwordValue = password.value;
        const confirmValue = field.value;

        if (confirmValue && passwordValue !== confirmValue) {
            this.setFieldInvalid(field, 'Password tidak sama');
            return false;
        }

        if (confirmValue && passwordValue === confirmValue) {
            this.setFieldValid(field, 'Password cocok');
            return true;
        }

        this.clearFieldValidation(field);
        return true;
    }

    /**
     * Set field as invalid
     */
    setFieldInvalid(field, message) {
        field.classList.remove('is-valid');
        field.classList.add('is-invalid');

        // Remove existing feedback
        const existingFeedback = field.parentNode.querySelector('.invalid-feedback-enhanced');
        if (existingFeedback) {
            existingFeedback.remove();
        }

        // Add new feedback
        const feedback = document.createElement('div');
        feedback.className = 'invalid-feedback-enhanced';
        feedback.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
        field.parentNode.appendChild(feedback);
    }

    /**
     * Set field as valid
     */
    setFieldValid(field, message = '') {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');

        // Remove existing feedback
        const existingFeedback = field.parentNode.querySelector('.invalid-feedback-enhanced, .valid-feedback-enhanced');
        if (existingFeedback) {
            existingFeedback.remove();
        }

        // Add valid feedback if message provided
        if (message) {
            const feedback = document.createElement('div');
            feedback.className = 'valid-feedback-enhanced';
            feedback.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
            field.parentNode.appendChild(feedback);
        }
    }

    /**
     * Clear field validation
     */
    clearFieldValidation(field) {
        field.classList.remove('is-invalid', 'is-valid');
        const feedback = field.parentNode.querySelector('.invalid-feedback-enhanced, .valid-feedback-enhanced');
        if (feedback) {
            feedback.remove();
        }
    }

    /**
     * Validate entire form
     */
    validateForm(form) {
        let isValid = true;
        const fields = form.querySelectorAll('.form-control-enhanced, .form-select-enhanced, .form-textarea-enhanced');

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    /**
     * Show form errors summary
     */
    showFormErrors(form) {
        const invalidFields = form.querySelectorAll('.is-invalid');
        if (invalidFields.length > 0) {
            // Scroll to first invalid field
            invalidFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            invalidFields[0].focus();

            // Show notification
            this.showNotification('error', `Terdapat ${invalidFields.length} field yang perlu diperbaiki`);
        }
    }

    /**
     * Setup file upload functionality
     */
    setupFileUploads() {
        document.querySelectorAll('.file-upload-enhanced').forEach(uploadArea => {
            const input = uploadArea.querySelector('input[type="file"]');
            if (!input) return;

            // Click to upload
            uploadArea.addEventListener('click', () => {
                input.click();
            });

            // Drag and drop
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    input.files = files;
                    this.handleFileUpload(input);
                }
            });

            // File input change
            input.addEventListener('change', () => {
                this.handleFileUpload(input);
            });
        });
    }

    /**
     * Handle file upload
     */
    handleFileUpload(input) {
        const file = input.files[0];
        if (!file) return;

        // Validate file
        if (!this.validateFile(file, input)) {
            input.value = '';
            return;
        }

        // Show preview for images
        if (file.type.startsWith('image/')) {
            this.showImagePreview(file, input);
        }

        // Show file info
        this.showFileInfo(file, input);
    }

    /**
     * Validate uploaded file
     */
    validateFile(file, input) {
        const maxSize = input.getAttribute('data-max-size') || 2048; // KB
        const allowedTypes = input.getAttribute('accept') || '';

        // Size validation
        if (file.size > maxSize * 1024) {
            this.showNotification('error', `Ukuran file maksimal ${maxSize}KB`);
            return false;
        }

        // Type validation
        if (allowedTypes && !allowedTypes.split(',').some(type => file.type.includes(type.trim()))) {
            this.showNotification('error', 'Tipe file tidak diizinkan');
            return false;
        }

        return true;
    }

    /**
     * Show image preview
     */
    showImagePreview(file, input) {
        const reader = new FileReader();
        reader.onload = (e) => {
            let preview = input.parentNode.querySelector('.file-preview-enhanced');
            if (!preview) {
                preview = document.createElement('img');
                preview.className = 'file-preview-enhanced';
                input.parentNode.appendChild(preview);
            }
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    /**
     * Show file info
     */
    showFileInfo(file, input) {
        let info = input.parentNode.querySelector('.file-info');
        if (!info) {
            info = document.createElement('div');
            info.className = 'file-info form-text-enhanced';
            input.parentNode.appendChild(info);
        }

        const size = (file.size / 1024).toFixed(1);
        info.innerHTML = `<i class="fas fa-file"></i> ${file.name} (${size}KB)`;
    }

    /**
     * Setup form animations
     */
    setupFormAnimations() {
        // Animate form sections on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-enhanced');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.form-section-enhanced').forEach(section => {
            observer.observe(section);
        });

        // Animate form controls on focus
        document.querySelectorAll('.form-control-enhanced, .form-select-enhanced, .form-textarea-enhanced').forEach(field => {
            field.addEventListener('focus', () => {
                field.parentNode.classList.add('focused');
            });

            field.addEventListener('blur', () => {
                field.parentNode.classList.remove('focused');
            });
        });
    }

    /**
     * Setup form helpers
     */
    setupFormHelpers() {
        // Auto-resize textareas
        document.querySelectorAll('.form-textarea-enhanced').forEach(textarea => {
            textarea.addEventListener('input', () => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });
        });

        // Character counter
        document.querySelectorAll('[data-max-length]').forEach(field => {
            const maxLength = parseInt(field.getAttribute('data-max-length'));
            const counter = document.createElement('div');
            counter.className = 'character-counter form-text-enhanced';
            field.parentNode.appendChild(counter);

            const updateCounter = () => {
                const remaining = maxLength - field.value.length;
                counter.textContent = `${field.value.length}/${maxLength} karakter`;
                counter.style.color = remaining < 10 ? 'var(--form-danger-color)' : 'var(--form-gray-500)';
            };

            field.addEventListener('input', updateCounter);
            updateCounter();
        });

        // Auto-format phone numbers
        document.querySelectorAll('input[type="tel"]').forEach(field => {
            field.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('0')) {
                    value = value.replace(/^0/, '62');
                }
                if (value.startsWith('62')) {
                    value = value.replace(/^62/, '+62 ');
                    if (value.length > 4) {
                        value = value.slice(0, 4) + value.slice(4).replace(/(\d{3})(\d{4})(\d{4})/, '$1-$2-$3');
                    }
                }
                e.target.value = value;
            });
        });
    }

    /**
     * Setup form progress indicator
     */
    setupFormProgress() {
        const progressContainer = document.querySelector('.form-progress-enhanced');
        if (!progressContainer) return;

        const steps = progressContainer.querySelectorAll('.form-step-enhanced');
        const sections = document.querySelectorAll('.form-section-enhanced');

        if (steps.length !== sections.length) return;

        // Update progress based on scroll position
        window.addEventListener('scroll', () => {
            const scrollPosition = window.scrollY + window.innerHeight / 2;

            sections.forEach((section, index) => {
                const sectionTop = section.offsetTop;
                const sectionBottom = sectionTop + section.offsetHeight;

                if (scrollPosition >= sectionTop && scrollPosition <= sectionBottom) {
                    // Update active step
                    steps.forEach(step => step.classList.remove('active'));
                    steps[index].classList.add('active');

                    // Mark previous steps as completed
                    steps.forEach((step, stepIndex) => {
                        if (stepIndex < index) {
                            step.classList.add('completed');
                        } else if (stepIndex > index) {
                            step.classList.remove('completed');
                        }
                    });
                }
            });
        });
    }

    /**
     * Setup auto-save functionality
     */
    setupAutoSave() {
        const forms = document.querySelectorAll('[data-auto-save]');
        
        forms.forEach(form => {
            const saveInterval = parseInt(form.getAttribute('data-auto-save')) || 30000; // 30 seconds default
            const formId = form.id || 'form_' + Date.now();
            
            let saveTimeout;
            
            // Save form data to localStorage
            const saveFormData = () => {
                const formData = new FormData(form);
                const data = {};
                
                for (let [key, value] of formData.entries()) {
                    data[key] = value;
                }
                
                localStorage.setItem(`autosave_${formId}`, JSON.stringify({
                    data: data,
                    timestamp: Date.now()
                }));
                
                this.showNotification('info', 'Draft tersimpan otomatis', 2000);
            };
            
            // Load saved data
            const loadFormData = () => {
                const saved = localStorage.getItem(`autosave_${formId}`);
                if (!saved) return;
                
                try {
                    const { data, timestamp } = JSON.parse(saved);
                    const age = Date.now() - timestamp;
                    
                    // Only load if less than 24 hours old
                    if (age < 24 * 60 * 60 * 1000) {
                        Object.keys(data).forEach(key => {
                            const field = form.querySelector(`[name="${key}"]`);
                            if (field && !field.value) {
                                field.value = data[key];
                            }
                        });
                        
                        this.showNotification('success', 'Draft dimuat dari penyimpanan otomatis');
                    }
                } catch (e) {
                    console.error('Error loading auto-saved data:', e);
                }
            };
            
            // Setup auto-save on form changes
            form.addEventListener('input', () => {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(saveFormData, saveInterval);
            });
            
            // Clear auto-save on successful submit
            form.addEventListener('submit', () => {
                localStorage.removeItem(`autosave_${formId}`);
            });
            
            // Load saved data on page load
            loadFormData();
        });
    }

    /**
     * Setup enhanced form submission
     */
    setupFormSubmission() {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    // Add loading state
                    submitBtn.classList.add('form-loading');
                    submitBtn.disabled = true;
                    
                    const originalText = submitBtn.textContent;
                    submitBtn.textContent = 'Menyimpan...';
                    
                    // Reset after 10 seconds (fallback)
                    setTimeout(() => {
                        submitBtn.classList.remove('form-loading');
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }, 10000);
                }
            });
        });
    }

    /**
     * Show notification
     */
    showNotification(type, message, duration = 5000) {
        // Remove existing notifications
        document.querySelectorAll('.notification-enhanced').forEach(n => n.remove());

        const notification = document.createElement('div');
        notification.className = `notification-enhanced alert-${type}-enhanced`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            min-width: 300px;
            max-width: 400px;
            padding: 1rem 1.5rem;
            border-radius: var(--form-border-radius);
            box-shadow: var(--form-shadow-lg);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideInRight 0.3s ease;
        `;

        const iconClass = type === 'success' ? 'check-circle' :
                         type === 'error' ? 'exclamation-triangle' :
                         type === 'warning' ? 'exclamation-circle' : 'info-circle';

        notification.innerHTML = `
            <i class="fas fa-${iconClass}"></i>
            <span>${message}</span>
            <button type="button" onclick="this.parentNode.remove()" style="
                background: none;
                border: none;
                color: inherit;
                font-size: 1.2rem;
                cursor: pointer;
                margin-left: auto;
                opacity: 0.7;
            ">×</button>
        `;

        document.body.appendChild(notification);

        // Auto remove
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }
        }, duration);
    }

    /**
     * Utility method to get form data as object
     */
    getFormData(form) {
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (data[key]) {
                // Handle multiple values (like checkboxes)
                if (Array.isArray(data[key])) {
                    data[key].push(value);
                } else {
                    data[key] = [data[key], value];
                }
            } else {
                data[key] = value;
            }
        }
        
        return data;
    }

    /**
     * Utility method to populate form with data
     */
    populateForm(form, data) {
        Object.keys(data).forEach(key => {
            const field = form.querySelector(`[name="${key}"]`);
            if (field) {
                if (field.type === 'checkbox' || field.type === 'radio') {
                    field.checked = field.value === data[key];
                } else {
                    field.value = data[key];
                }
            }
        });
    }
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .focused {
        transform: scale(1.02);
        transition: transform 0.2s ease;
    }
`;
document.head.appendChild(style);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new AdminFormsEnhanced();
});

// Export for manual initialization
window.AdminFormsEnhanced = AdminFormsEnhanced;