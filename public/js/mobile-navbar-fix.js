// Simple Mobile Navbar Dropdown Fix
(function() {
    'use strict';
    
    // Check if mobile device
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth < 992;
    
    console.log('📱 Mobile Navbar Fix Loaded - Is Mobile:', isMobile);
    
    function initMobileDropdowns() {
        if (!isMobile && window.innerWidth >= 992) {
            console.log('🖥️ Desktop detected, skipping mobile fixes');
            return;
        }
        
        console.log('📱 Initializing mobile dropdown fixes...');
        
        // Remove hover effects on mobile
        const style = document.createElement('style');
        style.id = 'mobile-dropdown-fix';
        style.textContent = `
            @media (max-width: 991.98px) {
                .dropdown:hover .dropdown-menu {
                    opacity: 0 !important;
                    visibility: hidden !important;
                    pointer-events: none !important;
                    transform: none !important;
                }
                
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
        const existingStyle = document.getElementById('mobile-dropdown-fix');
        if (existingStyle) {
            existingStyle.remove();
        }
        
        document.head.appendChild(style);
        
        // Add click handlers for dropdown toggles
        document.querySelectorAll('.dropdown-toggle').forEach((toggle, index) => {
            // Remove existing listeners
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);
            
            newToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log(`📱 Dropdown ${index + 1} clicked`);
                
                const dropdown = this.closest('.dropdown');
                const menu = dropdown.querySelector('.dropdown-menu');
                
                if (menu) {
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-menu.show').forEach(otherMenu => {
                        if (otherMenu !== menu) {
                            otherMenu.classList.remove('show');
                            console.log('📱 Closed other dropdown');
                        }
                    });
                    
                    // Toggle current dropdown
                    const isShowing = menu.classList.contains('show');
                    menu.classList.toggle('show');
                    
                    // Update aria-expanded
                    this.setAttribute('aria-expanded', !isShowing);
                    
                    console.log(`📱 Dropdown ${isShowing ? 'closed' : 'opened'}`);
                } else {
                    console.log('❌ No dropdown menu found');
                }
            });
            
            // Add touch support
            newToggle.addEventListener('touchstart', function(e) {
                console.log('👆 Touch start on dropdown');
                // Add visual feedback
                this.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
            }, { passive: true });
            
            newToggle.addEventListener('touchend', function(e) {
                console.log('👆 Touch end on dropdown');
                // Remove visual feedback
                setTimeout(() => {
                    this.style.backgroundColor = '';
                }, 150);
            }, { passive: true });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                const openMenus = document.querySelectorAll('.dropdown-menu.show');
                if (openMenus.length > 0) {
                    console.log('📱 Closing dropdowns - clicked outside');
                    openMenus.forEach(menu => {
                        menu.classList.remove('show');
                        const toggle = menu.closest('.dropdown').querySelector('.dropdown-toggle');
                        if (toggle) {
                            toggle.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            }
        });
        
        console.log('✅ Mobile dropdown fixes applied');
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileDropdowns);
    } else {
        initMobileDropdowns();
    }
    
    // Re-initialize on window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            console.log('📱 Window resized, re-initializing dropdowns');
            initMobileDropdowns();
        }, 250);
    });
    
    // Expose function globally for debugging
    window.fixMobileDropdowns = initMobileDropdowns;
    
    console.log('📱 Mobile Navbar Fix Ready - Use window.fixMobileDropdowns() to manually trigger');
    
})();