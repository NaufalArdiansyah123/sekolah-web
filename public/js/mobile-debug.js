// Mobile Debug Tool for Dashboard Issues
// Add this script to help debug mobile styling issues

(function() {
    'use strict';
    
    // Mobile detection
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    const isTablet = /iPad|Android(?=.*\bMobile\b)/i.test(navigator.userAgent);
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
    const isAndroid = /Android/.test(navigator.userAgent);
    
    // Debug info object
    const debugInfo = {
        userAgent: navigator.userAgent,
        isMobile: isMobile,
        isTablet: isTablet,
        isIOS: isIOS,
        isAndroid: isAndroid,
        viewport: {
            width: window.innerWidth,
            height: window.innerHeight,
            devicePixelRatio: window.devicePixelRatio || 1
        },
        screen: {
            width: screen.width,
            height: screen.height,
            availWidth: screen.availWidth,
            availHeight: screen.availHeight
        },
        connection: navigator.connection || navigator.mozConnection || navigator.webkitConnection,
        timestamp: new Date().toISOString()
    };
    
    // Check if assets are loaded
    function checkAssetsLoaded() {
        const checks = {
            viteCSS: false,
            viteJS: false,
            bootstrap: false,
            fontAwesome: false,
            alpine: false
        };
        
        // Check for Vite CSS
        const viteCSSLinks = document.querySelectorAll('link[href*="/build/assets/"]');
        checks.viteCSS = viteCSSLinks.length > 0;
        
        // Check for Vite JS
        const viteJSScripts = document.querySelectorAll('script[src*="/build/assets/"]');
        checks.viteJS = viteJSScripts.length > 0;
        
        // Check for Bootstrap
        checks.bootstrap = typeof bootstrap !== 'undefined' || document.querySelector('link[href*="bootstrap"]') !== null;
        
        // Check for Font Awesome
        checks.fontAwesome = document.querySelector('link[href*="font-awesome"]') !== null;
        
        // Check for Alpine.js
        checks.alpine = typeof Alpine !== 'undefined';
        
        return checks;
    }
    
    // Check CSS rules
    function checkCSSRules() {
        const testElement = document.createElement('div');
        testElement.style.cssText = 'display: flex; grid-template-columns: 1fr; transform: translateX(0);';
        document.body.appendChild(testElement);
        
        const computedStyle = window.getComputedStyle(testElement);
        const cssSupport = {
            flexbox: computedStyle.display === 'flex',
            grid: computedStyle.gridTemplateColumns === '1fr',
            transforms: computedStyle.transform !== 'none'
        };
        
        document.body.removeChild(testElement);
        return cssSupport;
    }
    
    // Network speed test
    function testNetworkSpeed() {
        const startTime = performance.now();
        const image = new Image();
        
        return new Promise((resolve) => {
            image.onload = function() {
                const endTime = performance.now();
                const duration = endTime - startTime;
                const speed = duration < 100 ? 'fast' : duration < 500 ? 'medium' : 'slow';
                resolve({ duration, speed });
            };
            
            image.onerror = function() {
                resolve({ duration: -1, speed: 'error' });
            };
            
            // Use a small test image
            image.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        });
    }
    
    // Create debug panel
    function createDebugPanel() {
        if (document.getElementById('mobile-debug-panel')) return;
        
        const panel = document.createElement('div');
        panel.id = 'mobile-debug-panel';
        panel.style.cssText = `
            position: fixed;
            top: 10px;
            right: 10px;
            width: 300px;
            max-height: 80vh;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 12px;
            z-index: 9999;
            overflow-y: auto;
            transform: translateX(320px);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        `;
        
        const toggle = document.createElement('button');
        toggle.textContent = '🐛';
        toggle.style.cssText = `
            position: fixed;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 16px;
            cursor: pointer;
            z-index: 10000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        `;
        
        let isOpen = false;
        toggle.addEventListener('click', () => {
            isOpen = !isOpen;
            panel.style.transform = isOpen ? 'translateX(0)' : 'translateX(320px)';
            toggle.style.right = isOpen ? '320px' : '10px';
        });
        
        document.body.appendChild(panel);
        document.body.appendChild(toggle);
        
        return panel;
    }
    
    // Update debug info
    async function updateDebugInfo() {
        const panel = createDebugPanel();
        const assetChecks = checkAssetsLoaded();
        const cssSupport = checkCSSRules();
        const networkTest = await testNetworkSpeed();
        
        const html = `
            <h3 style="margin: 0 0 10px 0; color: #ff6b6b;">📱 Mobile Debug Info</h3>
            
            <div style="margin-bottom: 15px;">
                <h4 style="margin: 0 0 5px 0; color: #4ecdc4;">Device Info</h4>
                <div>Mobile: ${debugInfo.isMobile ? '✅' : '❌'}</div>
                <div>Tablet: ${debugInfo.isTablet ? '✅' : '❌'}</div>
                <div>iOS: ${debugInfo.isIOS ? '✅' : '❌'}</div>
                <div>Android: ${debugInfo.isAndroid ? '✅' : '❌'}</div>
                <div>Viewport: ${debugInfo.viewport.width}x${debugInfo.viewport.height}</div>
                <div>DPR: ${debugInfo.viewport.devicePixelRatio}</div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <h4 style="margin: 0 0 5px 0; color: #4ecdc4;">Assets Status</h4>
                <div>Vite CSS: ${assetChecks.viteCSS ? '✅' : '❌'}</div>
                <div>Vite JS: ${assetChecks.viteJS ? '✅' : '❌'}</div>
                <div>Bootstrap: ${assetChecks.bootstrap ? '✅' : '❌'}</div>
                <div>Font Awesome: ${assetChecks.fontAwesome ? '✅' : '❌'}</div>
                <div>Alpine.js: ${assetChecks.alpine ? '✅' : '❌'}</div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <h4 style="margin: 0 0 5px 0; color: #4ecdc4;">CSS Support</h4>
                <div>Flexbox: ${cssSupport.flexbox ? '✅' : '❌'}</div>
                <div>Grid: ${cssSupport.grid ? '✅' : '❌'}</div>
                <div>Transforms: ${cssSupport.transforms ? '✅' : '❌'}</div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <h4 style="margin: 0 0 5px 0; color: #4ecdc4;">Network</h4>
                <div>Speed: ${networkTest.speed} (${networkTest.duration}ms)</div>
                ${debugInfo.connection ? `<div>Type: ${debugInfo.connection.effectiveType || 'unknown'}</div>` : ''}
            </div>
            
            <div style="margin-bottom: 15px;">
                <h4 style="margin: 0 0 5px 0; color: #4ecdc4;">Quick Fixes</h4>
                <button onclick="window.mobileDebug.reloadAssets()" style="display: block; width: 100%; margin: 5px 0; padding: 5px; background: #4ecdc4; color: black; border: none; border-radius: 4px; cursor: pointer;">Reload Assets</button>
                <button onclick="window.mobileDebug.clearCache()" style="display: block; width: 100%; margin: 5px 0; padding: 5px; background: #ff6b6b; color: white; border: none; border-radius: 4px; cursor: pointer;">Clear Cache</button>
                <button onclick="window.mobileDebug.applyFallback()" style="display: block; width: 100%; margin: 5px 0; padding: 5px; background: #ffa726; color: black; border: none; border-radius: 4px; cursor: pointer;">Apply Fallback CSS</button>
                <button onclick="window.mobileDebug.exportLog()" style="display: block; width: 100%; margin: 5px 0; padding: 5px; background: #66bb6a; color: black; border: none; border-radius: 4px; cursor: pointer;">Export Debug Log</button>
            </div>
            
            <div style="font-size: 10px; color: #888; margin-top: 10px;">
                Updated: ${new Date().toLocaleTimeString()}
            </div>
        `;
        
        panel.innerHTML = html;
    }
    
    // Mobile debug utilities
    window.mobileDebug = {
        reloadAssets: function() {
            // Reload CSS assets
            const cssLinks = document.querySelectorAll('link[rel="stylesheet"]');
            cssLinks.forEach(link => {
                const newLink = link.cloneNode();
                newLink.href = link.href + (link.href.includes('?') ? '&' : '?') + 'v=' + Date.now();
                link.parentNode.insertBefore(newLink, link.nextSibling);
                link.remove();
            });
            
            // Show success message
            this.showMessage('Assets reloaded!', 'success');
        },
        
        clearCache: function() {
            if ('caches' in window) {
                caches.keys().then(names => {
                    names.forEach(name => {
                        caches.delete(name);
                    });
                });
            }
            
            // Clear localStorage
            localStorage.clear();
            sessionStorage.clear();
            
            this.showMessage('Cache cleared! Please refresh the page.', 'info');
        },
        
        applyFallback: function() {
            // Apply fallback CSS
            const fallbackCSS = `
                <style id="mobile-fallback-css">
                    body { font-family: -apple-system, BlinkMacSystemFont, sans-serif !important; }
                    .container { max-width: 100% !important; padding: 15px !important; }
                    .card { background: white !important; border: 1px solid #ddd !important; border-radius: 8px !important; padding: 15px !important; margin-bottom: 15px !important; }
                    .btn { padding: 10px 15px !important; background: #007bff !important; color: white !important; border: none !important; border-radius: 4px !important; }
                    .table-responsive { overflow-x: auto !important; }
                    .sidebar { display: none !important; }
                    .main-content { margin-left: 0 !important; width: 100% !important; }
                    @media (max-width: 768px) {
                        .col-md-3, .col-md-4, .col-md-6, .col-md-8, .col-md-9, .col-md-12 { width: 100% !important; }
                    }
                </style>
            `;
            
            // Remove existing fallback
            const existing = document.getElementById('mobile-fallback-css');
            if (existing) existing.remove();
            
            // Add new fallback
            document.head.insertAdjacentHTML('beforeend', fallbackCSS);
            
            this.showMessage('Fallback CSS applied!', 'success');
        },
        
        exportLog: function() {
            const logData = {
                debugInfo: debugInfo,
                assetChecks: checkAssetsLoaded(),
                cssSupport: checkCSSRules(),
                timestamp: new Date().toISOString(),
                url: window.location.href,
                errors: window.mobileDebug.errors || []
            };
            
            const blob = new Blob([JSON.stringify(logData, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `mobile-debug-${Date.now()}.json`;
            a.click();
            URL.revokeObjectURL(url);
            
            this.showMessage('Debug log exported!', 'success');
        },
        
        showMessage: function(message, type = 'info') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 60px;
                right: 10px;
                background: ${type === 'success' ? '#4caf50' : type === 'error' ? '#f44336' : '#2196f3'};
                color: white;
                padding: 10px 15px;
                border-radius: 4px;
                z-index: 10001;
                font-family: sans-serif;
                font-size: 14px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
                transform: translateX(100%);
                transition: transform 0.3s ease;
            `;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        },
        
        errors: []
    };
    
    // Capture JavaScript errors
    window.addEventListener('error', function(e) {
        window.mobileDebug.errors.push({
            message: e.message,
            filename: e.filename,
            lineno: e.lineno,
            colno: e.colno,
            timestamp: new Date().toISOString()
        });
    });
    
    // Initialize debug panel on mobile devices
    if (isMobile || window.location.search.includes('debug=mobile')) {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(updateDebugInfo, 1000);
            
            // Auto-refresh debug info every 30 seconds
            setInterval(updateDebugInfo, 30000);
        });
    }
    
    // Console logging for debugging
    console.log('🐛 Mobile Debug Tool Loaded');
    console.log('📱 Device Info:', debugInfo);
    console.log('🔧 Use window.mobileDebug for utilities');
    
})();