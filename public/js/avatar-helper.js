/**
 * Avatar Helper Functions
 * Utility functions for managing user avatars across the application
 */

/**
 * Update all avatar instances on the page
 * @param {string} newAvatarUrl - The new avatar URL
 */
function updateAllAvatars(newAvatarUrl) {
    // Update profile page avatar
    const profileAvatar = document.querySelector('.profile-avatar');
    if (profileAvatar) {
        profileAvatar.src = newAvatarUrl;
    }
    
    // Update navbar avatar
    const navbarAvatar = document.querySelector('header img.rounded-full');
    if (navbarAvatar) {
        navbarAvatar.src = newAvatarUrl;
    }
    
    // Update sidebar avatar
    const sidebarAvatar = document.querySelector('.user-avatar');
    if (sidebarAvatar) {
        sidebarAvatar.src = newAvatarUrl;
    }
    
    // Update any other avatar instances
    const allAvatars = document.querySelectorAll('[data-user-avatar]');
    allAvatars.forEach(avatar => {
        avatar.src = newAvatarUrl;
    });
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

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeAvatarErrorHandling);

// Re-initialize when new content is added dynamically
const observer = new MutationObserver(() => {
    initializeAvatarErrorHandling();
});

observer.observe(document.body, {
    childList: true,
    subtree: true
});

// Export functions for global use
window.updateAllAvatars = updateAllAvatars;
window.generateFallbackAvatar = generateFallbackAvatar;
window.handleAvatarError = handleAvatarError;
window.preloadAvatar = preloadAvatar;