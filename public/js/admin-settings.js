/**
 * Admin Settings Page JavaScript Functions
 * Handles tab navigation, file previews, color pickers, and other settings functionality
 */

class AdminSettingsManager {
    constructor() {
        this.currentTab = 'school';
        this.init();
    }

    init() {
        this.initTabNavigation();
        this.initFilePreview();
        this.initColorPickers();
        this.initFormValidation();
        this.initQuickActions();
        this.initModals();
        
        console.log('🎛️ Admin Settings Manager initialized!');
    }

    // Tab Navigation
    initTabNavigation() {
        const tabs = document.querySelectorAll('.nav-tab');
        const panels = document.querySelectorAll('.tab-panel');
        const slider = document.querySelector('.nav-slider');

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and panels
                tabs.forEach(t => t.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));

                // Add active class to clicked tab and corresponding panel
                tab.classList.add('active');
                const tabName = tab.getAttribute('data-tab');
                const panel = document.getElementById(`${tabName}-panel`);
                if (panel) {
                    panel.classList.add('active');
                }

                // Move slider
                if (slider) {
                    slider.style.transform = `translateX(${index * 100}%)`;
                }

                this.currentTab = tabName;
                
                // Trigger custom event
                document.dispatchEvent(new CustomEvent('tabChanged', {
                    detail: { tab: tabName, index: index }
                }));
            });
        });
    }

    // File Preview Functions
    initFilePreview() {
        // Logo preview
        const logoInput = document.getElementById('school_logo');
        if (logoInput) {
            logoInput.addEventListener('change', (e) => {
                this.previewFile(e.target, 'logo');
            });
        }

        // Favicon preview
        const faviconInput = document.getElementById('school_favicon');
        if (faviconInput) {
            faviconInput.addEventListener('change', (e) => {
                this.previewFile(e.target, 'favicon');
            });
        }
    }

    previewFile(input, type) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                window.adminNotifications?.error('File Error', 'Please select a valid image file');
                input.value = '';
                return;
            }

            // Validate file size (2MB for logo, 1MB for favicon)
            const maxSize = type === 'logo' ? 2 * 1024 * 1024 : 1 * 1024 * 1024;
            if (file.size > maxSize) {
                const maxSizeMB = maxSize / (1024 * 1024);
                window.adminNotifications?.error('File Error', `File size must be less than ${maxSizeMB}MB`);
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = type === 'logo' ? 
                    document.getElementById('currentLogo') : 
                    document.getElementById('currentFavicon');
                
                const placeholder = type === 'logo' ? 
                    document.getElementById('noLogoPlaceholder') : 
                    document.getElementById('noFaviconPlaceholder');

                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                if (placeholder) {
                    placeholder.style.display = 'none';
                }

                // Show success notification
                window.adminNotifications?.success('Preview Ready', `${type} preview updated successfully`);
            };
            reader.readAsDataURL(file);
        }
    }

    // Color Picker Functions
    initColorPickers() {
        const colorInputs = document.querySelectorAll('.color-picker');
        const textInputs = document.querySelectorAll('.color-text-input');

        colorInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                this.updateColorPreview(e.target.id, e.target.value);
                this.updateNavbarPreview();
            });
        });

        textInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                this.updateColorPicker(e.target.id.replace('_text', ''), e.target.value);
                this.updateNavbarPreview();
            });
        });

        // Initialize color previews
        this.updateAllColorPreviews();
        this.updateNavbarPreview();
    }

    updateColorPreview(fieldId, color) {
        const preview = document.getElementById(`${fieldId}_preview`);
        const textInput = document.getElementById(`${fieldId}_text`);
        const colorInput = document.getElementById(fieldId);

        if (preview) {
            preview.style.backgroundColor = color;
        }
        if (textInput) {
            textInput.value = color;
        }
        if (colorInput) {
            colorInput.value = color;
        }
    }

    updateColorPicker(fieldId, color) {
        if (this.isValidColor(color)) {
            this.updateColorPreview(fieldId, color);
        } else {
            window.adminNotifications?.warning('Invalid Color', 'Please enter a valid hex color code');
        }
    }

    updateAllColorPreviews() {
        const colorFields = ['navbar_bg_color', 'navbar_text_color', 'navbar_hover_color', 'navbar_active_color'];
        colorFields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                this.updateColorPreview(field, input.value);
            }
        });
    }

    updateNavbarPreview() {
        const preview = document.querySelector('.preview-navbar');
        if (!preview) return;

        const bgColor = document.getElementById('navbar_bg_color')?.value || '#1a202c';
        const textColor = document.getElementById('navbar_text_color')?.value || '#ffffff';
        const hoverColor = document.getElementById('navbar_hover_color')?.value || '#3182ce';
        const activeColor = document.getElementById('navbar_active_color')?.value || '#4299e1';

        // Apply colors to preview
        preview.style.backgroundColor = bgColor;
        preview.style.color = textColor;

        // Update links
        const links = preview.querySelectorAll('.preview-link');
        links.forEach(link => {
            link.style.color = textColor;
            
            link.addEventListener('mouseenter', () => {
                link.style.color = hoverColor;
            });
            
            link.addEventListener('mouseleave', () => {
                if (!link.classList.contains('active')) {
                    link.style.color = textColor;
                }
            });
        });

        // Update active link
        const activeLink = preview.querySelector('.preview-link.active');
        if (activeLink) {
            activeLink.style.color = activeColor;
        }
    }

    isValidColor(color) {
        return /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(color);
    }

    // Preset Color Functions
    applyPresetColors(theme) {
        const presets = {
            dark: {
                navbar_bg_color: '#1a202c',
                navbar_text_color: '#ffffff',
                navbar_hover_color: '#4a5568',
                navbar_active_color: '#63b3ed'
            },
            blue: {
                navbar_bg_color: '#2b6cb0',
                navbar_text_color: '#ffffff',
                navbar_hover_color: '#3182ce',
                navbar_active_color: '#63b3ed'
            },
            green: {
                navbar_bg_color: '#276749',
                navbar_text_color: '#ffffff',
                navbar_hover_color: '#38a169',
                navbar_active_color: '#68d391'
            }
        };

        const preset = presets[theme];
        if (preset) {
            Object.keys(preset).forEach(key => {
                this.updateColorPreview(key, preset[key]);
            });
            this.updateNavbarPreview();
            window.adminNotifications?.success('Theme Applied', `${theme.charAt(0).toUpperCase() + theme.slice(1)} theme applied successfully`);
        }
    }

    resetNavbarColors() {
        this.applyPresetColors('dark');
        window.adminNotifications?.info('Colors Reset', 'Navbar colors reset to default');
    }

    // Form Validation
    initFormValidation() {
        const form = document.getElementById('settingsForm');
        if (!form) return;

        // Add custom validation
        form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
                window.adminNotifications?.error('Validation Error', 'Please fix the errors before submitting');
            }
        });
    }

    validateForm() {
        let isValid = true;
        const requiredFields = document.querySelectorAll('input[required], select[required]');

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                isValid = false;
            } else {
                field.classList.remove('error');
            }
        });

        return isValid;
    }

    // Quick Actions
    initQuickActions() {
        // Clear Cache
        window.clearCache = () => {
            window.adminNotifications?.info('Processing', 'Clearing cache...');
            
            fetch('/admin/settings/clear-cache', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())\n            .then(data => {\n                if (data.success) {\n                    window.adminNotifications?.success('Success', data.message);\n                } else {\n                    window.adminNotifications?.error('Error', data.message);\n                }\n            })\n            .catch(error => {\n                window.adminNotifications?.error('Error', 'Failed to clear cache');\n            });\n        };\n\n        // Optimize System\n        window.optimizeSystem = () => {\n            window.adminNotifications?.info('Processing', 'Optimizing system...');\n            \n            fetch('/admin/settings/optimize', {\n                method: 'POST',\n                headers: {\n                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content'),\n                    'Content-Type': 'application/json'\n                }\n            })\n            .then(response => response.json())\n            .then(data => {\n                if (data.success) {\n                    window.adminNotifications?.success('Success', data.message);\n                } else {\n                    window.adminNotifications?.error('Error', data.message);\n                }\n            })\n            .catch(error => {\n                window.adminNotifications?.error('Error', 'Failed to optimize system');\n            });\n        };\n    }\n\n    // Modal Functions\n    initModals() {\n        window.testEmail = () => {\n            const modal = document.getElementById('testEmailModal');\n            if (modal) {\n                modal.style.display = 'flex';\n                document.body.style.overflow = 'hidden';\n            }\n        };\n\n        window.closeModal = (modalId) => {\n            const modal = document.getElementById(modalId);\n            if (modal) {\n                modal.style.display = 'none';\n                document.body.style.overflow = 'auto';\n            }\n        };\n\n        window.sendTestEmail = () => {\n            const email = document.getElementById('testEmailAddress')?.value;\n            const template = document.getElementById('testEmailTemplate')?.value;\n\n            if (!email) {\n                window.adminNotifications?.error('Validation Error', 'Please enter an email address');\n                return;\n            }\n\n            window.adminNotifications?.info('Sending', 'Sending test email...');\n\n            fetch('/admin/settings/test-email', {\n                method: 'POST',\n                headers: {\n                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content'),\n                    'Content-Type': 'application/json'\n                },\n                body: JSON.stringify({ email, template })\n            })\n            .then(response => response.json())\n            .then(data => {\n                if (data.success) {\n                    window.adminNotifications?.success('Email Sent', data.message);\n                    window.closeModal('testEmailModal');\n                } else {\n                    window.adminNotifications?.error('Email Failed', data.message);\n                }\n            })\n            .catch(error => {\n                window.adminNotifications?.error('Error', 'Failed to send test email');\n            });\n        };\n    }\n\n    // Utility Functions\n    resetForm() {\n        if (confirm('Are you sure you want to reset all settings to default values?')) {\n            window.adminNotifications?.info('Processing', 'Resetting form to defaults...');\n            \n            fetch('/admin/settings/reset', {\n                method: 'POST',\n                headers: {\n                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content'),\n                    'Content-Type': 'application/json'\n                }\n            })\n            .then(response => response.json())\n            .then(data => {\n                if (data.success) {\n                    window.adminNotifications?.success('Reset Complete', data.message);\n                    setTimeout(() => {\n                        window.location.reload();\n                    }, 1500);\n                } else {\n                    window.adminNotifications?.error('Reset Failed', data.message);\n                }\n            })\n            .catch(error => {\n                window.adminNotifications?.error('Error', 'Failed to reset settings');\n            });\n        }\n    }\n\n    previewChanges() {\n        window.adminNotifications?.info('Preview', 'Changes will be visible after saving');\n    }\n}\n\n// Global functions for backward compatibility\nwindow.previewLogo = function(input) {\n    window.adminSettings?.previewFile(input, 'logo');\n};\n\nwindow.previewFavicon = function(input) {\n    window.adminSettings?.previewFile(input, 'favicon');\n};\n\nwindow.updateColorPreview = function(fieldId, color) {\n    window.adminSettings?.updateColorPreview(fieldId, color);\n};\n\nwindow.updateColorPicker = function(fieldId, color) {\n    window.adminSettings?.updateColorPicker(fieldId, color);\n};\n\nwindow.applyPresetColors = function(theme) {\n    window.adminSettings?.applyPresetColors(theme);\n};\n\nwindow.resetNavbarColors = function() {\n    window.adminSettings?.resetNavbarColors();\n};\n\nwindow.resetForm = function() {\n    window.adminSettings?.resetForm();\n};\n\nwindow.previewChanges = function() {\n    window.adminSettings?.previewChanges();\n};\n\n// Initialize when DOM is ready\ndocument.addEventListener('DOMContentLoaded', function() {\n    // Initialize settings manager\n    window.adminSettings = new AdminSettingsManager();\n    \n    console.log('⚙️ Admin settings functionality loaded!');\n});\n\n// Export for use in other scripts\nif (typeof module !== 'undefined' && module.exports) {\n    module.exports = { AdminSettingsManager };\n}"
  }
]
</invoke>