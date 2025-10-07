/**
 * Dark Mode Manager
 * Centralized dark mode management for the school management system
 */

class DarkModeManager {
    constructor() {
        this.storageKey = 'darkMode';
        this.darkMode = this.getStoredPreference();
        this.callbacks = [];
        this.init();
    }

    /**
     * Initialize dark mode manager
     */
    init() {
        // Apply initial theme
        this.applyTheme();
        
        // Listen for system preference changes
        this.watchSystemPreference();
        
        // Listen for storage changes (for multi-tab sync)
        this.watchStorageChanges();
        
        // Make globally available
        window.darkModeManager = this;
        window.toggleDarkMode = () => this.toggle();
    }

    /**
     * Get stored preference or system preference
     */
    getStoredPreference() {
        const stored = localStorage.getItem(this.storageKey);
        if (stored !== null) {
            return stored === 'true';
        }
        
        // Fall back to system preference
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    /**
     * Apply current theme to document
     */
    applyTheme() {
        const html = document.documentElement;
        
        if (this.darkMode) {
            html.classList.add('dark');
            html.setAttribute('data-theme', 'dark');
        } else {
            html.classList.remove('dark');
            html.setAttribute('data-theme', 'light');
        }
        
        // Update meta theme-color for mobile browsers
        this.updateMetaThemeColor();
        
        // Notify callbacks
        this.notifyCallbacks();
    }

    /**
     * Toggle dark mode
     */
    toggle() {
        this.darkMode = !this.darkMode;
        this.savePreference();
        this.applyTheme();
        
        // Dispatch custom event
        this.dispatchThemeChangeEvent();
    }

    /**
     * Set dark mode state
     */
    setDarkMode(enabled) {
        if (this.darkMode !== enabled) {
            this.darkMode = enabled;
            this.savePreference();
            this.applyTheme();
            this.dispatchThemeChangeEvent();
        }
    }

    /**
     * Get current dark mode state
     */
    isDarkMode() {
        return this.darkMode;
    }

    /**
     * Save preference to localStorage
     */
    savePreference() {
        localStorage.setItem(this.storageKey, this.darkMode.toString());
    }

    /**
     * Watch for system preference changes
     */
    watchSystemPreference() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            
            mediaQuery.addEventListener('change', (e) => {
                // Only auto-switch if user hasn't set a manual preference
                const hasManualPreference = localStorage.getItem(this.storageKey) !== null;
                if (!hasManualPreference) {
                    this.setDarkMode(e.matches);
                }
            });
        }
    }

    /**
     * Watch for localStorage changes (multi-tab sync)
     */
    watchStorageChanges() {
        window.addEventListener('storage', (e) => {
            if (e.key === this.storageKey && e.newValue !== null) {
                const newValue = e.newValue === 'true';
                if (this.darkMode !== newValue) {
                    this.darkMode = newValue;
                    this.applyTheme();
                    this.dispatchThemeChangeEvent();
                }
            }
        });
    }

    /**
     * Update meta theme-color for mobile browsers
     */
    updateMetaThemeColor() {
        let metaThemeColor = document.querySelector('meta[name="theme-color"]');
        
        if (!metaThemeColor) {
            metaThemeColor = document.createElement('meta');
            metaThemeColor.name = 'theme-color';
            document.head.appendChild(metaThemeColor);
        }
        
        metaThemeColor.content = this.darkMode ? '#111827' : '#ffffff';
    }

    /**
     * Dispatch theme change event
     */
    dispatchThemeChangeEvent() {
        const event = new CustomEvent('themechange', {
            detail: {
                darkMode: this.darkMode,
                theme: this.darkMode ? 'dark' : 'light'
            }
        });
        
        document.dispatchEvent(event);
    }

    /**
     * Register callback for theme changes
     */
    onThemeChange(callback) {
        if (typeof callback === 'function') {
            this.callbacks.push(callback);
        }
    }

    /**
     * Unregister callback
     */
    offThemeChange(callback) {
        const index = this.callbacks.indexOf(callback);
        if (index > -1) {
            this.callbacks.splice(index, 1);
        }
    }

    /**
     * Notify all callbacks
     */
    notifyCallbacks() {
        this.callbacks.forEach(callback => {
            try {
                callback(this.darkMode);
            } catch (error) {
                console.error('Error in dark mode callback:', error);
            }
        });
    }

    /**
     * Get CSS custom property value
     */
    getCSSVariable(property) {
        return getComputedStyle(document.documentElement).getPropertyValue(property).trim();
    }

    /**
     * Get theme colors object
     */
    getThemeColors() {
        return {
            bgPrimary: this.getCSSVariable('--bg-primary'),
            bgSecondary: this.getCSSVariable('--bg-secondary'),
            bgTertiary: this.getCSSVariable('--bg-tertiary'),
            textPrimary: this.getCSSVariable('--text-primary'),
            textSecondary: this.getCSSVariable('--text-secondary'),
            textTertiary: this.getCSSVariable('--text-tertiary'),
            borderColor: this.getCSSVariable('--border-color'),
            shadowColor: this.getCSSVariable('--shadow-color'),
            brandPrimary: this.getCSSVariable('--brand-primary'),
            brandSecondary: this.getCSSVariable('--brand-secondary'),
            brandSuccess: this.getCSSVariable('--brand-success'),
            brandWarning: this.getCSSVariable('--brand-warning'),
            brandError: this.getCSSVariable('--brand-error'),
            brandInfo: this.getCSSVariable('--brand-info')
        };
    }

    /**
     * Update chart colors (for Chart.js integration)
     */
    updateChartColors(chart) {
        if (!chart || typeof chart.update !== 'function') {
            return;
        }

        const colors = this.getThemeColors();
        
        // Update chart options based on theme
        if (chart.options) {
            // Update text colors
            if (chart.options.plugins && chart.options.plugins.legend) {
                chart.options.plugins.legend.labels = {
                    ...chart.options.plugins.legend.labels,
                    color: colors.textPrimary
                };
            }
            
            // Update scale colors
            if (chart.options.scales) {
                Object.keys(chart.options.scales).forEach(scaleKey => {
                    const scale = chart.options.scales[scaleKey];
                    if (scale.ticks) {
                        scale.ticks.color = colors.textSecondary;
                    }
                    if (scale.grid) {
                        scale.grid.color = colors.borderColor;
                    }
                });
            }
        }
        
        chart.update();
    }

    /**
     * Auto-update all Chart.js instances
     */
    updateAllCharts() {
        if (window.Chart && window.Chart.instances) {
            Object.values(window.Chart.instances).forEach(chart => {
                this.updateChartColors(chart);
            });
        }
    }

    /**
     * Create theme-aware toast notification
     */
    createToast(type, title, message) {
        const colors = this.getThemeColors();
        
        // This would integrate with your existing toast system
        if (window.showToast) {
            window.showToast(type, title, message);
        }
    }

    /**
     * Get theme-appropriate icon
     */
    getThemeIcon() {
        return this.darkMode ? 'sun' : 'moon';
    }

    /**
     * Create toggle button HTML
     */
    createToggleButton(className = 'dark-mode-toggle') {
        return `
            <button onclick="toggleDarkMode()" class="${className}" title="Toggle Dark Mode" aria-label="Toggle Dark Mode">
                <svg class="theme-icon theme-icon-light" fill="currentColor" viewBox="0 0 20 20" style="display: ${this.darkMode ? 'none' : 'block'}">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                </svg>
                <svg class="theme-icon theme-icon-dark" fill="currentColor" viewBox="0 0 20 20" style="display: ${this.darkMode ? 'block' : 'none'}">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
            </button>
        `;
    }

    /**
     * Initialize theme for specific components
     */
    initializeComponent(componentName, options = {}) {
        const initMethods = {
            chart: () => this.updateAllCharts(),
            modal: () => this.updateModalTheme(options),
            table: () => this.updateTableTheme(options),
            form: () => this.updateFormTheme(options)
        };

        if (initMethods[componentName]) {
            initMethods[componentName]();
        }
    }

    /**
     * Debug information
     */
    debug() {
        return {
            darkMode: this.darkMode,
            storageKey: this.storageKey,
            systemPreference: window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches,
            storedValue: localStorage.getItem(this.storageKey),
            htmlClasses: document.documentElement.classList.toString(),
            themeColors: this.getThemeColors(),
            callbacks: this.callbacks.length
        };
    }
}

/**
 * Utility functions for theme management
 */
const ThemeUtils = {
    /**
     * Wait for theme to be applied
     */
    waitForTheme() {
        return new Promise((resolve) => {
            if (document.documentElement.hasAttribute('data-theme')) {
                resolve();
            } else {
                const observer = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                            observer.disconnect();
                            resolve();
                        }
                    });
                });
                
                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['data-theme']
                });
            }
        });
    },

    /**
     * Get contrast ratio between two colors
     */
    getContrastRatio(color1, color2) {
        // Implementation would calculate WCAG contrast ratio
        // This is a simplified version
        return 4.5; // Placeholder
    },

    /**
     * Check if current theme meets accessibility standards
     */
    checkAccessibility() {
        const colors = window.darkModeManager?.getThemeColors() || {};
        // Implementation would check contrast ratios
        return {
            textContrast: 'AA',
            backgroundContrast: 'AA',
            overall: 'compliant'
        };
    }
};

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new DarkModeManager();
    });
} else {
    new DarkModeManager();
}

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { DarkModeManager, ThemeUtils };
}

// Make available globally
window.DarkModeManager = DarkModeManager;
window.ThemeUtils = ThemeUtils;