/**
 * Avatar Helper Functions
 * Utility functions for managing user avatars across the application
 */

/**
 * Update all avatar instances on the page
 * @param {string} newAvatarUrl - The new avatar URL
 */
function updateAllAvatars(newAvatarUrl) {
    console.log('Updating all avatars with URL:', newAvatarUrl);
    
    // Update profile page avatar
    const profileAvatar = document.querySelector('.profile-avatar');
    if (profileAvatar) {
        profileAvatar.src = newAvatarUrl;
        console.log('Updated profile avatar');
    }
    
    // Update navbar avatar - try multiple selectors
    const navbarSelectors = [
        'header img.rounded-full',
        '.navbar img.rounded-full',
        'nav img.rounded-full',
        '.top-nav img.rounded-full',
        '[data-navbar-avatar]'
    ];
    
    navbarSelectors.forEach(selector => {
        const navbarAvatar = document.querySelector(selector);
        if (navbarAvatar) {
            navbarAvatar.src = newAvatarUrl;
            console.log('Updated navbar avatar with selector:', selector);
        }
    });
    
    // Update sidebar avatar - try multiple selectors
    const sidebarSelectors = [
        '.user-avatar',
        '.sidebar .user-avatar',
        '.sidebar-nav .user-avatar',
        '[data-sidebar-avatar]',
        '.user-card img',
        '.user-section img'
    ];
    
    sidebarSelectors.forEach(selector => {
        const sidebarAvatar = document.querySelector(selector);
        if (sidebarAvatar) {
            sidebarAvatar.src = newAvatarUrl;
            console.log('Updated sidebar avatar with selector:', selector);
        }
    });
    
    // Update any other avatar instances
    const allAvatars = document.querySelectorAll('[data-user-avatar]');
    allAvatars.forEach(avatar => {
        avatar.src = newAvatarUrl;
        console.log('Updated data-user-avatar element');
    });
    
    // Force refresh of all img elements that might be user avatars
    const allImages = document.querySelectorAll('img');
    allImages.forEach(img => {
        if (img.alt && (img.alt.toLowerCase().includes('avatar') || img.alt.toLowerCase().includes('user'))) {
            img.src = newAvatarUrl;
            console.log('Updated avatar by alt text:', img.alt);
        }
    });
    
    console.log('Avatar update completed');
}

/**
 * Generate a fallback avatar URL
 * @param {string} name - User's name
 * @param {number} size - Avatar size in pixels
 * @param {string} color - Hex color without #
 * @returns {string} Generated avatar URL
 */
function generateFallbackAvatar(name, size = 120, color = '7F9CF5') {
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&color=${color}&background=EBF4FF&size=${size}`;
}

/**
 * Handle avatar load errors
 * @param {HTMLImageElement} img - The image element that failed to load
 * @param {string} userName - User's name for fallback
 * @param {number} size - Avatar size
 */
function handleAvatarError(img, userName, size = 120) {
    img.src = generateFallbackAvatar(userName, size);
    img.onerror = null; // Prevent infinite loop
}

/**
 * Preload avatar to check if it exists
 * @param {string} avatarUrl - Avatar URL to check
 * @param {Function} onSuccess - Callback if avatar loads successfully
 * @param {Function} onError - Callback if avatar fails to load
 */
function preloadAvatar(avatarUrl, onSuccess, onError) {
    const img = new Image();
    img.onload = () => onSuccess(avatarUrl);
    img.onerror = () => onError();
    img.src = avatarUrl;
}

/**
 * Initialize avatar error handling for all avatars on the page
 */
function initializeAvatarErrorHandling() {
    const avatars = document.querySelectorAll('img[alt*="avatar"], .profile-avatar, .user-avatar, header img.rounded-full');
    
    avatars.forEach(avatar => {
        if (!avatar.hasAttribute('data-error-handled')) {
            const userName = avatar.alt || 'User';
            const size = avatar.classList.contains('profile-avatar') ? 120 : 
                        avatar.classList.contains('user-avatar') ? 44 : 32;
            
            avatar.addEventListener('error', () => {
                handleAvatarError(avatar, userName, size);
            });
            
            avatar.setAttribute('data-error-handled', 'true');
        }
    });
}

/**
 * Initialize MutationObserver safely
 */
function initializeMutationObserver() {
    // Check if document.body exists and is a valid Node
    if (document.body && document.body instanceof Node) {
        try {
            const observer = new MutationObserver(() => {
                initializeAvatarErrorHandling();
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
            
            console.log('MutationObserver initialized successfully');
        } catch (error) {
            console.warn('Failed to initialize MutationObserver:', error);
        }
    } else {
        console.warn('document.body not available for MutationObserver');
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeAvatarErrorHandling();
    initializeMutationObserver();
    console.log('Avatar helper initialized');
});

// Fallback initialization if DOMContentLoaded already fired
if (document.readyState === 'loading') {
    // DOM is still loading, wait for DOMContentLoaded
} else {
    // DOM is already loaded
    initializeAvatarErrorHandling();
    initializeMutationObserver();
    console.log('Avatar helper initialized (fallback)');
}

// Add a delayed update function for cases where elements load later
function delayedAvatarUpdate(newAvatarUrl, maxAttempts = 5, delay = 500) {
    let attempts = 0;
    
    function attemptUpdate() {
        attempts++;
        console.log(`Delayed avatar update attempt ${attempts}`);
        
        updateAllAvatars(newAvatarUrl);
        
        // Check if sidebar avatar was updated
        const sidebarAvatar = document.querySelector('.user-avatar');
        if (!sidebarAvatar && attempts < maxAttempts) {
            console.log('Sidebar avatar not found, retrying in', delay, 'ms');
            setTimeout(attemptUpdate, delay);
        } else if (sidebarAvatar) {
            console.log('Sidebar avatar found and updated successfully');
        } else {
            console.warn('Failed to find sidebar avatar after', maxAttempts, 'attempts');
        }
    }
    
    attemptUpdate();
}

// Export functions for global use
window.updateAllAvatars = updateAllAvatars;
window.generateFallbackAvatar = generateFallbackAvatar;
window.handleAvatarError = handleAvatarError;
window.preloadAvatar = preloadAvatar;
window.delayedAvatarUpdate = delayedAvatarUpdate;

// Debug function to check current avatar elements
window.debugAvatars = function() {
    console.log('=== Avatar Debug Info ===');
    console.log('Profile avatar:', document.querySelector('.profile-avatar'));
    console.log('Navbar avatar:', document.querySelector('header img.rounded-full'));
    console.log('Sidebar avatar:', document.querySelector('.user-avatar'));
    console.log('All user-avatar elements:', document.querySelectorAll('.user-avatar'));
    console.log('All data-user-avatar elements:', document.querySelectorAll('[data-user-avatar]'));
    console.log('========================');
};