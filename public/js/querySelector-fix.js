// Global querySelector Fix for Empty Hash Links
(function() {
    'use strict';
    
    console.log('🔧 querySelector Fix Loading...');
    
    // Override querySelector to handle empty hash selectors
    const originalQuerySelector = Document.prototype.querySelector;
    const originalQuerySelectorAll = Document.prototype.querySelectorAll;
    
    Document.prototype.querySelector = function(selector) {
        // Check for invalid selectors
        if (!selector || selector === '#' || selector === '' || selector.trim() === '') {
            console.warn('⚠️ Invalid selector detected:', selector);
            return null;
        }
        
        try {
            return originalQuerySelector.call(this, selector);
        } catch (error) {
            console.warn('⚠️ querySelector error with selector:', selector, error);
            return null;
        }
    };
    
    Document.prototype.querySelectorAll = function(selector) {
        // Check for invalid selectors
        if (!selector || selector === '#' || selector === '' || selector.trim() === '') {
            console.warn('⚠️ Invalid selector detected:', selector);
            return [];
        }
        
        try {
            return originalQuerySelectorAll.call(this, selector);
        } catch (error) {
            console.warn('⚠️ querySelectorAll error with selector:', selector, error);
            return [];
        }
    };
    
    // Fix for anchor links with empty href
    function fixAnchorLinks() {
        document.addEventListener('click', function(e) {
            const target = e.target.closest('a[href^="#"]');
            if (target) {
                const href = target.getAttribute('href');
                
                // Prevent default for empty or invalid hash links
                if (!href || href === '#' || href.length <= 1) {
                    e.preventDefault();
                    console.log('🔗 Prevented navigation to empty hash link');
                    return false;
                }
            }
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fixAnchorLinks);
    } else {
        fixAnchorLinks();
    }
    
    console.log('✅ querySelector Fix Ready');
    
})();