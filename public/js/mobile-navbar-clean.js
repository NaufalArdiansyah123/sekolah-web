// Clean Mobile Navbar Fix - Minimal Approach
(function() {
    'use strict';
    
    console.log('📱 Clean Mobile Navbar Fix Loading...');
    
    function initCleanMobileNavbar() {
        // Only run on mobile devices
        if (window.innerWidth >= 992) {
            return;
        }
        
        console.log('📱 Initializing clean mobile navbar...');
        
        // Simple dropdown fix for mobile
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        
        dropdownToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const dropdown = this.closest('.dropdown');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    
                    if (menu) {
                        // Close other dropdowns
                        document.querySelectorAll('.dropdown-menu.show').forEach(function(otherMenu) {
                            if (otherMenu !== menu) {
                                otherMenu.classList.remove('show');
                            }
                        });
                        
                        // Toggle current dropdown
                        menu.classList.toggle('show');
                        
                        console.log('📱 Dropdown toggled');
                    }
                }
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 992 && !e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                    menu.classList.remove('show');
                });
            }
        });
        
        console.log('✅ Clean mobile navbar initialized');
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCleanMobileNavbar);
    } else {
        initCleanMobileNavbar();
    }
    
    console.log('📱 Clean Mobile Navbar Fix Ready');
    
})();