import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    
    // Mobile-optimized build settings
    build: {
        // Reduce chunk size for mobile
        chunkSizeWarningLimit: 500,
        
        rollupOptions: {
            output: {
                // Split vendor chunks for better caching
                manualChunks: {
                    vendor: ['alpinejs', 'axios'],
                    utils: ['./resources/js/bootstrap.js']
                },
                
                // Optimize asset names for caching
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split('.');
                    const ext = info[info.length - 1];
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(ext)) {
                        return `assets/images/[name]-[hash][extname]`;
                    }
                    if (/css/i.test(ext)) {
                        return `assets/css/[name]-[hash][extname]`;
                    }
                    return `assets/[name]-[hash][extname]`;
                }
            }
        },
        
        // Enable CSS code splitting
        cssCodeSplit: true,
        
        // Optimize for mobile
        target: ['es2015', 'chrome58', 'firefox57', 'safari11'],
        
        // Enable minification
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true
            }
        }
    },
    
    // Development server settings
    server: {
        host: '0.0.0.0', // Allow mobile device access
        port: 5173,
        strictPort: true,
        
        // CORS settings for mobile testing
        cors: {
            origin: true,
            credentials: true
        }
    },
    
    // CSS preprocessing
    css: {
        postcss: {
            plugins: [
                require('autoprefixer')({
                    overrideBrowserslist: [
                        '> 1%',
                        'last 2 versions',
                        'iOS >= 10',
                        'Android >= 5'
                    ]
                }),
                
                // Optimize CSS for mobile
                require('cssnano')({
                    preset: ['default', {
                        discardComments: {
                            removeAll: true,
                        },
                        normalizeWhitespace: true,
                        minifySelectors: true
                    }]
                })
            ]
        },
        
        // Enable CSS modules if needed
        modules: false,
        
        // Preprocess options
        preprocessorOptions: {
            scss: {
                additionalData: `
                    // Mobile-first mixins
                    @mixin mobile-only {
                        @media (max-width: 767px) {
                            @content;
                        }
                    }
                    
                    @mixin tablet-up {
                        @media (min-width: 768px) {
                            @content;
                        }
                    }
                    
                    @mixin desktop-up {
                        @media (min-width: 1024px) {
                            @content;
                        }
                    }
                `
            }
        }
    },
    
    // Optimize dependencies
    optimizeDeps: {
        include: [
            'alpinejs',
            'axios',
            '@alpinejs/focus',
            '@alpinejs/collapse'
        ],
        
        // Force optimization for mobile
        force: true
    },
    
    // Define global constants
    define: {
        __IS_MOBILE__: JSON.stringify(process.env.NODE_ENV === 'production'),
        __VERSION__: JSON.stringify(process.env.npm_package_version || '1.0.0')
    },
    
    // Preview settings for mobile testing
    preview: {
        host: '0.0.0.0',
        port: 4173,
        strictPort: true,
        
        // Add headers for mobile compatibility
        headers: {
            'Cache-Control': 'public, max-age=31536000',
            'X-Content-Type-Options': 'nosniff',
            'X-Frame-Options': 'DENY',
            'X-XSS-Protection': '1; mode=block'
        }
    }
});