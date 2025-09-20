// Simple Mobile Debug Tool
(function() {
    'use strict';
    
    // Mobile detection
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    const isTablet = /iPad|Android(?=.*\\bMobile\\b)/i.test(navigator.userAgent);
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
    const isAndroid = /Android/.test(navigator.userAgent);
    
    console.log('🐛 Mobile Debug Tool Loaded');
    console.log('📱 Device Info:', {
        isMobile: isMobile,
        isTablet: isTablet,
        isIOS: isIOS,
        isAndroid: isAndroid,
        viewport: {
            width: window.innerWidth,
            height: window.innerHeight
        }
    });
    
    // Simple debug utilities
    window.mobileDebug = {
        showMessage: function(message, type) {
            console.log('📱 ' + type.toUpperCase() + ':', message);
            
            // Create simple toast
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#4caf50' : type === 'error' ? '#f44336' : '#2196f3'};
                color: white;
                padding: 10px 15px;
                border-radius: 4px;
                z-index: 10001;
                font-family: sans-serif;
                font-size: 14px;
                max-width: 300px;
            `;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            setTimeout(function() {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 3000);
        },
        
        testDropdowns: function() {
            console.log('🧪 Testing dropdown functionality...');
            
            const dropdowns = document.querySelectorAll('.dropdown-toggle');
            console.log('Found ' + dropdowns.length + ' dropdown toggles');
            
            const menus = document.querySelectorAll('.dropdown-menu');
            console.log('Found ' + menus.length + ' dropdown menus');
            
            this.showMessage('Found ' + dropdowns.length + ' dropdowns', 'info');
        },
        
        fixDropdowns: function() {
            console.log('🔧 Manually fixing dropdowns...');
            
            if (window.fixMobileNavbar) {
                window.fixMobileNavbar();
                this.showMessage('Mobile navbar fix applied!', 'success');
            } else {
                this.showMessage('Mobile navbar fix not available', 'error');
            }
        }
    };
    
    // Auto-fix on mobile
    if (isMobile) {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                if (window.mobileDebug && window.mobileDebug.fixDropdowns) {
                    window.mobileDebug.fixDropdowns();
                }
            }, 1000);
        });
    }
    
    console.log('🔧 Use window.mobileDebug for utilities');
    
})();