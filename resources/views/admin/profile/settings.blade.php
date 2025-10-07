@extends('layouts.admin')

@section('title', 'Profile Settings')

@section('content')

<style>
/* Settings Page Styles - Dark Mode Compatible */
.settings-container {
    max-width: 1000px;
    margin: 0 auto;
}

.settings-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.settings-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -30%;
    width: 80%;
    height: 200%;
    background: rgba(255, 255, 255, 0.08);
    transform: rotate(-12deg);
    border-radius: 20px;
}

.settings-header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.settings-icon {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.settings-info h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.settings-info p {
    opacity: 0.9;
    font-size: 1rem;
}

.settings-tabs {
    display: flex;
    background: var(--bg-primary);
    border-radius: 12px;
    padding: 0.5rem;
    margin-bottom: 2rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    overflow-x: auto;
}

.settings-tab {
    flex: 1;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    color: var(--text-secondary);
    font-weight: 500;
    white-space: nowrap;
    min-width: 120px;
}

.settings-tab:hover {
    background: var(--bg-secondary);
    color: var(--text-primary);
}

.settings-tab.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
}

.settings-content {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.settings-section {
    display: none;
}

.settings-section.active {
    display: block;
}

.settings-group {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
}

.settings-group:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.settings-group-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.settings-group-icon {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
}

.settings-group-desc {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
}

.settings-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    margin-bottom: 1rem;
    transition: all 0.2s ease;
}

.settings-item:hover {
    background: var(--bg-tertiary);
}

.settings-item-info {
    flex: 1;
}

.settings-item-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.settings-item-desc {
    color: var(--text-secondary);
    font-size: 0.75rem;
}

.settings-toggle {
    position: relative;
    width: 48px;
    height: 24px;
    background: #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.settings-toggle.active {
    background: #667eea;
}

.settings-toggle::after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    transition: transform 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.settings-toggle.active::after {
    transform: translateX(24px);
}

.settings-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    font-size: 0.875rem;
}

.settings-btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.settings-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.settings-btn-secondary {
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.settings-btn-secondary:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    text-decoration: none;
}

.settings-btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.settings-btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: white;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .settings-header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .settings-tabs {
        flex-direction: column;
    }
    
    .settings-tab {
        flex: none;
    }
    
    .settings-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>

<div class="settings-container">
    <!-- Settings Header -->
    <div class="settings-header">
        <div class="settings-header-content">
            <div class="settings-icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="settings-info">
                <h1>Profile Settings</h1>
                <p>Manage your account preferences and privacy settings</p>
            </div>
        </div>
    </div>

    <!-- Settings Tabs -->
    <div class="settings-tabs">
        <div class="settings-tab active" onclick="showTab('general')">
            <i class="fas fa-user me-2"></i>
            General
        </div>
        <div class="settings-tab" onclick="showTab('security')">
            <i class="fas fa-shield-alt me-2"></i>
            Security
        </div>
        <div class="settings-tab" onclick="showTab('notifications')">
            <i class="fas fa-bell me-2"></i>
            Notifications
        </div>
        <div class="settings-tab" onclick="showTab('privacy')">
            <i class="fas fa-lock me-2"></i>
            Privacy
        </div>
        <div class="settings-tab" onclick="showTab('advanced')">
            <i class="fas fa-cogs me-2"></i>
            Advanced
        </div>
    </div>

    <!-- Settings Content -->
    <div class="settings-content">
        <!-- General Settings -->
        <div id="general" class="settings-section active">
            <div class="settings-group">
                <div class="settings-group-title">
                    <div class="settings-group-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    Profile Information
                </div>
                <div class="settings-group-desc">
                    Update your basic profile information and preferences
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Profile Visibility</div>
                        <div class="settings-item-desc">Make your profile visible to other users</div>
                    </div>
                    <div class="settings-toggle active" onclick="toggleSetting(this)"></div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Show Online Status</div>
                        <div class="settings-item-desc">Let others see when you're online</div>
                    </div>
                    <div class="settings-toggle" onclick="toggleSetting(this)"></div>
                </div>
            </div>

            <div class="settings-group">
                <div class="settings-group-title">
                    <div class="settings-group-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    Appearance
                </div>
                <div class="settings-group-desc">
                    Customize how the interface looks and feels
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Dark Mode</div>
                        <div class="settings-item-desc">Use dark theme for better viewing in low light</div>
                    </div>
                    <div class="settings-toggle" onclick="toggleDarkMode(this)"></div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Compact Mode</div>
                        <div class="settings-item-desc">Show more content in less space</div>
                    </div>
                    <div class="settings-toggle" onclick="toggleSetting(this)"></div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div id="security" class="settings-section">
            <div class="settings-group">
                <div class="settings-group-title">
                    <div class="settings-group-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    Account Security
                </div>
                <div class="settings-group-desc">
                    Manage your account security and authentication methods
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Two-Factor Authentication</div>
                        <div class="settings-item-desc">Add an extra layer of security to your account</div>
                    </div>
                    <button class="settings-btn settings-btn-primary" onclick="setup2FA()">
                        <i class="fas fa-mobile-alt"></i>
                        Setup
                    </button>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Login Alerts</div>
                        <div class="settings-item-desc">Get notified of new login attempts</div>
                    </div>
                    <div class="settings-toggle active" onclick="toggleSetting(this)"></div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Session Management</div>
                        <div class="settings-item-desc">View and manage your active sessions</div>
                    </div>
                    <button class="settings-btn settings-btn-secondary" onclick="manageSessions()">
                        <i class="fas fa-list"></i>
                        Manage
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications Settings -->
        <div id="notifications" class="settings-section">
            <div class="settings-group">
                <div class="settings-group-title">
                    <div class="settings-group-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    Email Notifications
                </div>
                <div class="settings-group-desc">
                    Choose what email notifications you want to receive
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">System Updates</div>
                        <div class="settings-item-desc">Important system announcements and updates</div>
                    </div>
                    <div class="settings-toggle active" onclick="toggleSetting(this)"></div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Security Alerts</div>
                        <div class="settings-item-desc">Login attempts and security-related notifications</div>
                    </div>
                    <div class="settings-toggle active" onclick="toggleSetting(this)"></div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Weekly Reports</div>
                        <div class="settings-item-desc">Weekly summary of system activity</div>
                    </div>
                    <div class="settings-toggle" onclick="toggleSetting(this)"></div>
                </div>
            </div>

            <div class="settings-group">
                <div class="settings-group-title">
                    <div class="settings-group-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    Push Notifications
                </div>
                <div class="settings-group-desc">
                    Manage browser and mobile push notifications
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Browser Notifications</div>
                        <div class="settings-item-desc">Show notifications in your browser</div>
                    </div>
                    <div class="settings-toggle" onclick="toggleBrowserNotifications(this)"></div>
                </div>
            </div>
        </div>

        <!-- Privacy Settings -->
        <div id="privacy" class="settings-section">
            <div class="settings-group">
                <div class="settings-group-title">
                    <div class="settings-group-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    Data Privacy
                </div>
                <div class="settings-group-desc">
                    Control how your data is used and shared
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Analytics</div>
                        <div class="settings-item-desc">Help improve the system by sharing usage data</div>
                    </div>
                    <div class="settings-toggle active" onclick="toggleSetting(this)"></div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Activity Logging</div>
                        <div class="settings-item-desc">Keep a log of your account activity</div>
                    </div>
                    <div class="settings-toggle active" onclick="toggleSetting(this)"></div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Data Export</div>
                        <div class="settings-item-desc">Download a copy of your data</div>
                    </div>
                    <button class="settings-btn settings-btn-secondary" onclick="exportData()">
                        <i class="fas fa-download"></i>
                        Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Advanced Settings -->
        <div id="advanced" class="settings-section">
            <div class="settings-group">
                <div class="settings-group-title">
                    <div class="settings-group-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    Advanced Options
                </div>
                <div class="settings-group-desc">
                    Advanced settings for power users
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Developer Mode</div>
                        <div class="settings-item-desc">Enable advanced debugging features</div>
                    </div>
                    <div class="settings-toggle" onclick="toggleSetting(this)"></div>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Beta Features</div>
                        <div class="settings-item-desc">Try new features before they're released</div>
                    </div>
                    <div class="settings-toggle" onclick="toggleSetting(this)"></div>
                </div>
            </div>

            <div class="settings-group">
                <div class="settings-group-title">
                    <div class="settings-group-icon">
                        <i class="fas fa-trash"></i>
                    </div>
                    Danger Zone
                </div>
                <div class="settings-group-desc">
                    Irreversible actions that affect your account
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Reset All Settings</div>
                        <div class="settings-item-desc">Reset all preferences to default values</div>
                    </div>
                    <button class="settings-btn settings-btn-danger" onclick="resetSettings()">
                        <i class="fas fa-undo"></i>
                        Reset
                    </button>
                </div>
                
                <div class="settings-item">
                    <div class="settings-item-info">
                        <div class="settings-item-title">Clear All Data</div>
                        <div class="settings-item-desc">Permanently delete all your data</div>
                    </div>
                    <button class="settings-btn settings-btn-danger" onclick="clearAllData()">
                        <i class="fas fa-trash"></i>
                        Clear Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Tab switching
function showTab(tabName) {
    // Hide all sections
    document.querySelectorAll('.settings-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.settings-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Show selected section
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked tab
    event.target.classList.add('active');
}

// Toggle settings
function toggleSetting(element) {
    element.classList.toggle('active');
    
    // Here you would typically save the setting to the server
    console.log('Setting toggled:', element.classList.contains('active'));
}

// Toggle dark mode
function toggleDarkMode(element) {
    element.classList.toggle('active');
    
    // Use the existing dark mode toggle function from the admin layout
    if (typeof window.adminApp !== 'undefined') {
        window.adminApp().toggleDarkMode();
    }
}

// Toggle browser notifications
function toggleBrowserNotifications(element) {
    if (!element.classList.contains('active')) {
        // Request permission
        if ('Notification' in window) {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    element.classList.add('active');
                    new Notification('Notifications enabled!', {
                        body: 'You will now receive browser notifications.',
                        icon: '/favicon.ico'
                    });
                }
            });
        }
    } else {
        element.classList.remove('active');
    }
}

// Setup 2FA
function setup2FA() {
    alert('Two-Factor Authentication setup would be implemented here.');
}

// Manage sessions
function manageSessions() {
    alert('Session management interface would be implemented here.');
}

// Export data
function exportData() {
    fetch('{{ route("admin.profile.download-data") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Create and download JSON file
                const blob = new Blob([JSON.stringify(data.data, null, 2)], {
                    type: 'application/json'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `profile-data-${new Date().toISOString().split('T')[0]}.json`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                
                alert('Your data has been exported successfully!');
            } else {
                alert('Failed to export data: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while exporting data.');
        });
}

// Reset settings
function resetSettings() {
    if (confirm('Are you sure you want to reset all settings to default? This action cannot be undone.')) {
        // Reset all toggles to default state
        document.querySelectorAll('.settings-toggle').forEach(toggle => {
            toggle.classList.remove('active');
        });
        
        alert('All settings have been reset to default values.');
    }
}

// Clear all data
function clearAllData() {
    if (confirm('⚠️ WARNING: This will permanently delete ALL your data. This action cannot be undone. Are you absolutely sure?')) {
        if (confirm('This is your final warning. Type "DELETE" to confirm:') && prompt('Type DELETE to confirm:') === 'DELETE') {
            alert('Data clearing functionality would be implemented here with proper safeguards.');
        }
    }
}

// Initialize settings based on current state
document.addEventListener('DOMContentLoaded', function() {
    // Set dark mode toggle based on current theme
    const isDark = document.documentElement.classList.contains('dark');
    const darkModeToggle = document.querySelector('[onclick="toggleDarkMode(this)"]');
    if (isDark && darkModeToggle) {
        darkModeToggle.classList.add('active');
    }
});
</script>
@endpush