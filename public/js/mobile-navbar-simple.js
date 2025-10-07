// Simple Mobile Navbar Fix - Error Free Version
(function() {
    'use strict';
    
    console.log('📱 Simple Mobile Navbar Fix Loading...');
    
    // Wait for DOM to be ready
    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }
    
    function isMobileDevice() {
        return window.innerWidth < 992 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
    
    function fixMobileDropdowns() {
        if (!isMobileDevice()) {
            console.log('🖥️ Desktop detected, skipping mobile fixes');
            return;
        }
        
        console.log('📱 Applying mobile dropdown fixes...');
        
        try {
            // Add mobile-specific CSS
            const style = document.createElement('style');
            style.id = 'mobile-navbar-fix';
            style.textContent = `
                @media (max-width: 991.98px) {
                    .dropdown-menu {
                        position: static !important;
                        display: none !important;
                        opacity: 1 !important;
                        visibility: visible !important;
                        pointer-events: auto !important;
                        transform: none !important;
                        margin: 8px 0 !important;
                        background: rgba(255, 255, 255, 0.98) !important;
                        border-radius: 12px !important;
                        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1) !important;
                    }
                    
                    .dropdown-menu.show {
                        display: block !important;
                    }
                    
                    .dropdown-toggle {
                        cursor: pointer !important;
                        -webkit-tap-highlight-color: rgba(0,0,0,0.1) !important;
                        touch-action: manipulation !important;
                    }
                    
                    .dropdown-item {
                        padding: 12px 16px !important;
                        min-height: 44px !important;
                        display: flex !important;
                        align-items: center !important;
                        touch-action: manipulation !important;
                    }
                }
            `;
            
            // Remove existing style if present
            const existingStyle = document.getElementById('mobile-navbar-fix');
            if (existingStyle) {
                existingStyle.remove();
            }
            
            document.head.appendChild(style);
            
            // Fix dropdown toggles
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            console.log('📱 Found ' + dropdownToggles.length + ' dropdown toggles');
            
            dropdownToggles.forEach(function(toggle, index) {
                // Remove existing event listeners by cloning
                const newToggle = toggle.cloneNode(true);
                if (toggle.parentNode) {
                    toggle.parentNode.replaceChild(newToggle, toggle);
                }
                
                // Add click handler
                newToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('📱 Dropdown clicked:', index + 1);
                    
                    const dropdown = this.closest('.dropdown');
                    if (!dropdown) {
                        console.log('❌ No dropdown parent found');
                        return;
                    }
                    
                    const menu = dropdown.querySelector('.dropdown-menu');
                    if (!menu) {
                        console.log('❌ No dropdown menu found');
                        return;
                    }
                    
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-menu.show').forEach(function(otherMenu) {
                        if (otherMenu !== menu) {
                            otherMenu.classList.remove('show');
                        }
                    });
                    
                    // Toggle current dropdown
                    const isShowing = menu.classList.contains('show');
                    menu.classList.toggle('show');
                    
                    // Update aria-expanded
                    this.setAttribute('aria-expanded', !isShowing);
                    
                    console.log('📱 Dropdown', isShowing ? 'closed' : 'opened');
                });
                
                // Add touch feedback
                newToggle.addEventListener('touchstart', function() {
                    this.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
                }, { passive: true });
                
                newToggle.addEventListener('touchend', function() {
                    const self = this;
                    setTimeout(function() {
                        self.style.backgroundColor = '';
                    }, 150);
                }, { passive: true });
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    const openMenus = document.querySelectorAll('.dropdown-menu.show');
                    if (openMenus.length > 0) {
                        console.log('📱 Closing dropdowns - clicked outside');
                        openMenus.forEach(function(menu) {
                            menu.classList.remove('show');
                            const dropdown = menu.closest('.dropdown');
                            if (dropdown) {
                                const toggle = dropdown.querySelector('.dropdown-toggle');
                                if (toggle) {
                                    toggle.setAttribute('aria-expanded', 'false');
                                }
                            }
                        });
                    }
                }
            });
            
            console.log('✅ Mobile dropdown fixes applied successfully');
            
        } catch (error) {
            console.error('❌ Error applying mobile fixes:', error);
        }
    }
    
    // Initialize
    ready(function() {
        setTimeout(fixMobileDropdowns, 500);
    });
    
    // Re-apply on window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (isMobileDevice()) {
                console.log('📱 Window resized, re-applying mobile fixes');
                fixMobileDropdowns();
            }
        }, 250);
    });
    
    // Expose function globally
    window.fixMobileNavbar = fixMobileDropdowns;
    
    console.log('📱 Simple Mobile Navbar Fix Ready');
    
})();