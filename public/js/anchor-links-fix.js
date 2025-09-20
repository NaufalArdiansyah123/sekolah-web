// Global Anchor Links Fix for All Pages
(function() {
    'use strict';
    
    console.log('🔗 Anchor Links Fix Loading...');
    
    function fixAnchorLinks() {
        // Find all anchor links that start with #
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        console.log('🔗 Found', anchorLinks.length, 'anchor links');
        
        anchorLinks.forEach(function(anchor, index) {
            // Remove existing event listeners by cloning
            const newAnchor = anchor.cloneNode(true);
            if (anchor.parentNode) {
                anchor.parentNode.replaceChild(newAnchor, anchor);
            }
            
            // Add safe click handler
            newAnchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Skip if href is just '#' or empty or invalid
                if (!href || href === '#' || href.length <= 1) {
                    console.log('🔗 Skipping invalid anchor link:', href);
                    e.preventDefault();
                    return false;
                }\n                \n                // Check if target exists\n                let target;\n                try {\n                    target = document.querySelector(href);\n                } catch (error) {\n                    console.warn('🔗 Invalid selector:', href, error);\n                    e.preventDefault();\n                    return false;\n                }\n                \n                if (target) {\n                    e.preventDefault();\n                    target.scrollIntoView({\n                        behavior: 'smooth',\n                        block: 'start'\n                    });\n                    console.log('🔗 Smooth scroll to:', href);\n                } else {\n                    console.log('🔗 Target not found for:', href);\n                    e.preventDefault();\n                    return false;\n                }\n            });\n        });\n        \n        console.log('✅ Anchor links fixed successfully');\n    }\n    \n    // Initialize when DOM is ready\n    function init() {\n        if (document.readyState === 'loading') {\n            document.addEventListener('DOMContentLoaded', fixAnchorLinks);\n        } else {\n            fixAnchorLinks();\n        }\n        \n        // Re-fix when new content is added dynamically\n        const observer = new MutationObserver(function(mutations) {\n            let shouldRefix = false;\n            mutations.forEach(function(mutation) {\n                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {\n                    mutation.addedNodes.forEach(function(node) {\n                        if (node.nodeType === 1) { // Element node\n                            const hasAnchorLinks = node.querySelectorAll && node.querySelectorAll('a[href^=\"#\"]').length > 0;\n                            if (hasAnchorLinks) {\n                                shouldRefix = true;\n                            }\n                        }\n                    });\n                }\n            });\n            \n            if (shouldRefix) {\n                console.log('🔗 New anchor links detected, re-fixing...');\n                setTimeout(fixAnchorLinks, 100);\n            }\n        });\n        \n        observer.observe(document.body, {\n            childList: true,\n            subtree: true\n        });\n    }\n    \n    init();\n    \n    // Expose function globally\n    window.fixAnchorLinks = fixAnchorLinks;\n    \n    console.log('🔗 Anchor Links Fix Ready');\n    \n})();"