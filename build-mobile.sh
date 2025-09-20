#!/bin/bash

# Mobile-Optimized Build Script for Laravel Vite
echo "🚀 Building assets for mobile optimization..."

# Clear previous builds
echo "🧹 Cleaning previous builds..."
rm -rf public/build
rm -rf node_modules/.vite

# Install dependencies if needed
if [ ! -d "node_modules" ]; then
    echo "📦 Installing dependencies..."
    npm install
fi

# Build with mobile optimization
echo "🔨 Building assets with mobile optimization..."
npm run build

# Copy mobile-specific files
echo "📱 Copying mobile-specific files..."
cp resources/css/mobile-fix.css public/css/mobile-fix.css
cp resources/js/mobile-debug.js public/js/mobile-debug.js

# Generate service worker for better mobile caching
echo "⚙️ Generating service worker..."
cat > public/sw.js << 'EOF'
const CACHE_NAME = 'sekolah-web-v1';
const urlsToCache = [
  '/',
  '/css/mobile-fix.css',
  '/js/mobile-debug.js',
  '/build/assets/app.css',
  '/build/assets/app.js'
];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        if (response) {
          return response;
        }
        return fetch(event.request);
      }
    )
  );
});
EOF

# Create mobile manifest
echo "📋 Creating mobile manifest..."
cat > public/manifest.json << 'EOF'
{
  "name": "Sekolah Web Admin",
  "short_name": "Admin",
  "description": "School Management System",
  "start_url": "/admin/dashboard",
  "display": "standalone",
  "background_color": "#ffffff",
  "theme_color": "#3b82f6",
  "icons": [
    {
      "src": "/images/icon-192.png",
      "sizes": "192x192",
      "type": "image/png"
    },
    {
      "src": "/images/icon-512.png",
      "sizes": "512x512",
      "type": "image/png"
    }
  ]
}
EOF

# Optimize images if imagemin is available
if command -v imagemin &> /dev/null; then
    echo "🖼️ Optimizing images..."
    find public/images -name "*.jpg" -o -name "*.png" -o -name "*.jpeg" | xargs imagemin --out-dir=public/images/optimized/
fi

# Generate .htaccess for better mobile performance
echo "⚡ Creating .htaccess for performance..."
cat > public/.htaccess << 'EOF'
# Mobile Performance Optimizations
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
</IfModule>

<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Mobile-specific headers
<IfModule mod_headers.c>
    Header set X-UA-Compatible "IE=edge"
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    
    # Cache control for mobile
    <FilesMatch "\.(css|js|png|jpg|jpeg|gif|svg|woff|woff2)$">
        Header set Cache-Control "public, max-age=31536000"
    </FilesMatch>
</IfModule>

# Redirect to HTTPS (uncomment for production)
# RewriteEngine On
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
EOF

echo "✅ Mobile build completed!"
echo ""
echo "📱 Mobile optimizations applied:"
echo "   - Assets built and optimized"
echo "   - Mobile-specific CSS and JS copied"
echo "   - Service worker generated"
echo "   - Mobile manifest created"
echo "   - Performance headers configured"
echo ""
echo "🔧 To test mobile:"
echo "   1. Open Chrome DevTools"
echo "   2. Toggle device toolbar (Ctrl+Shift+M)"
echo "   3. Select a mobile device"
echo "   4. Refresh the page"
echo ""
echo "🐛 For debugging, add ?debug=mobile to URL"