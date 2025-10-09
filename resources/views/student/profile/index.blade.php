@extends('layouts.student')

@section('title', 'Student Profile')

@section('content')

<style>
/* Student Profile Page Styles - Dark Mode Compatible */
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
}

.profile-header {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.profile-header::before {
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

.profile-header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 2rem;
}

.profile-avatar-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 20px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.05);
}

.profile-info {
    flex: 1;
}

.profile-name {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.profile-role {
    font-size: 1.125rem;
    opacity: 0.9;
    margin-bottom: 1rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: inline-block;
    backdrop-filter: blur(10px);
}

.profile-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
}

.profile-stat {
    text-align: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.profile-stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.profile-stat-label {
    font-size: 0.875rem;
    opacity: 0.8;
}

.profile-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.profile-card {
    background-color: var(--bg-primary);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.profile-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.profile-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.profile-card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.profile-form-group {
    margin-bottom: 1.5rem;
}

.profile-form-label {
    display: block;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.profile-form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    font-size: 0.875rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease, color 0.3s ease;
    background: var(--bg-primary);
    color: var(--text-primary);
}

.profile-form-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.profile-form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    font-size: 0.875rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease, color 0.3s ease;
    background: var(--bg-primary);
    color: var(--text-primary);
    resize: vertical;
    min-height: 100px;
}

.profile-form-textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.profile-btn {
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
    justify-content: center;
}

.profile-btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.profile-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    color: white;
    text-decoration: none;
}

.profile-btn-secondary {
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.profile-btn-secondary:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    text-decoration: none;
}

.profile-btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.profile-btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: white;
    text-decoration: none;
}

.profile-activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    background: var(--bg-secondary);
    margin-bottom: 1rem;
    transition: all 0.2s ease;
}

.profile-activity-item:hover {
    background: var(--bg-tertiary);
    transform: translateX(5px);
}

.profile-activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
}

.profile-activity-icon.login {
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
}

.profile-activity-icon.update {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
}

.profile-activity-icon.security {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
}

.profile-activity-icon.assignment {
    background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
}

.profile-activity-icon.quiz {
    background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
}

.profile-activity-icon.attendance {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
}

.profile-activity-content {
    flex: 1;
}

.profile-activity-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.profile-activity-time {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.profile-security-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-radius: 12px;
    background: var(--bg-secondary);
    margin-bottom: 1rem;
    transition: all 0.2s ease;
}

.profile-security-item:hover {
    background: var(--bg-tertiary);
}

.profile-security-info {
    flex: 1;
}

.profile-security-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.profile-security-desc {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.profile-security-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.profile-security-status.enabled {
    color: #10b981;
}

.profile-security-status.disabled {
    color: #ef4444;
}

.profile-security-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

.profile-security-indicator.enabled {
    background: #10b981;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
}

.profile-security-indicator.disabled {
    background: #ef4444;
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-header-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .profile-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .profile-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .profile-name {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .profile-header {
        padding: 1.5rem;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
    }
    
    .profile-stats {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-header-content">
            <div class="profile-avatar-section">
                <img src="{{ auth()->user()->avatar_url }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="profile-avatar"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=3B82F6&background=EBF4FF&size=120'">
                <button type="button" class="profile-btn profile-btn-secondary" onclick="changeAvatar()">
                    <i class="fas fa-camera"></i>
                    Change Photo
                </button>
            </div>
            
            <div class="profile-info">
                <h1 class="profile-name">{{ auth()->user()->name }}</h1>
                <div class="profile-role">
                    <i class="fas fa-graduation-cap"></i>
                    Student
                </div>
                <p style="opacity: 0.9; margin-bottom: 1rem;">
                    {{ auth()->user()->email }}
                </p>
                
                <div class="profile-stats">
                    <div class="profile-stat">
                        <div class="profile-stat-value">{{ auth()->user()->nis ?? 'N/A' }}</div>
                        <div class="profile-stat-label">Student ID</div>
                    </div>
                    <div class="profile-stat">
                        <div class="profile-stat-value">{{ auth()->user()->class ?? 'N/A' }}</div>
                        <div class="profile-stat-label">Kelas</div>
                    </div>
                    <div class="profile-stat">
                        <div class="profile-stat-value">{{ \Carbon\Carbon::parse(auth()->user()->created_at)->diffInDays() }}</div>
                        <div class="profile-stat-label">Days Active</div>
                    </div>
                    <div class="profile-stat">
                        <div class="profile-stat-value">{{ auth()->user()->last_login_at ? \Carbon\Carbon::parse(auth()->user()->last_login_at)->format('M d') : 'Today' }}</div>
                        <div class="profile-stat-label">Last Login</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="profile-content">
        <!-- Personal Information -->
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="profile-card-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h2 class="profile-card-title">Personal Information</h2>
            </div>
            
            <form action="{{ route('student.profile.update') }}" method="POST" id="profileForm">
                @csrf
                @method('PUT')
                
                <div class="profile-form-group">
                    <label class="profile-form-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" class="profile-form-input" required>
                </div>
                
                <div class="profile-form-group">
                    <label class="profile-form-label">Alamat Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="profile-form-input" required>
                </div>
                
                <div class="profile-form-group">
                    <label class="profile-form-label">Nomor Telepon</label>
                    <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="profile-form-input" placeholder="+62 xxx-xxxx-xxxx">
                </div>
                
                <div class="profile-form-group">
                    <label class="profile-form-label">Bio</label>
                    <textarea name="bio" class="profile-form-textarea" placeholder="Ceritakan tentang diri Anda...">{{ auth()->user()->bio ?? '' }}</textarea>
                </div>
                
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="profile-btn profile-btn-primary">
                        <i class="fas fa-save"></i>
                        Save Changes
                    </button>
                    <button type="reset" class="profile-btn profile-btn-secondary">
                        <i class="fas fa-undo"></i>
                        Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Settings -->
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="profile-card-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2 class="profile-card-title">Security Settings</h2>
            </div>
            
            <div class="profile-security-item">
                <div class="profile-security-info">
                    <div class="profile-security-title">Kata Sandi</div>
                    <div class="profile-security-desc">Last changed {{ auth()->user()->password_changed_at ? \Carbon\Carbon::parse(auth()->user()->password_changed_at)->diffForHumans() : 'never' }}</div>
                </div>
                <button type="button" class="profile-btn profile-btn-secondary" onclick="changePassword()">
                    <i class="fas fa-key"></i>
                    Change
                </button>
            </div>
            
            <div class="profile-security-item">
                <div class="profile-security-info">
                    <div class="profile-security-title">Two-Factor Authentication</div>
                    <div class="profile-security-desc">Add an extra layer of security to your account</div>
                </div>
                <div class="profile-security-status disabled">
                    <div class="profile-security-indicator disabled"></div>
                    Disabled
                </div>
            </div>
            
            <div class="profile-security-item">
                <div class="profile-security-info">
                    <div class="profile-security-title">Login Notifications</div>
                    <div class="profile-security-desc">Get notified when someone logs into your account</div>
                </div>
                <div class="profile-security-status enabled">
                    <div class="profile-security-indicator enabled"></div>
                    Enabled
                </div>
            </div>
            
            <div style="margin-top: 1.5rem;">
                <button type="button" class="profile-btn profile-btn-danger" onclick="confirmLogoutAllDevices()">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout All Devices
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="profile-card">
        <div class="profile-card-header">
            <div class="profile-card-icon">
                <i class="fas fa-history"></i>
            </div>
            <h2 class="profile-card-title">Recent Activity</h2>
        </div>
        
        <div id="activityContainer">
            <div class="profile-activity-item">
                <div class="profile-activity-icon login">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <div class="profile-activity-content">
                    <div class="profile-activity-title">Logged in from Chrome on Windows</div>
                    <div class="profile-activity-time">{{ now()->format('M d, Y \a\t H:i') }}</div>
                </div>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <button type="button" class="profile-btn profile-btn-secondary" onclick="loadActivity()">
                <i class="fas fa-history"></i>
                Load Recent Activity
            </button>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-key me-2"></i>
                    Change Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('student.profile.password') }}" method="POST" id="passwordForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="profile-form-group">
                        <label class="profile-form-label">Current Password</label>
                        <input type="password" name="current_password" class="profile-form-input" required>
                    </div>
                    
                    <div class="profile-form-group">
                        <label class="profile-form-label">New Password</label>
                        <input type="password" name="password" class="profile-form-input" required minlength="8">
                    </div>
                    
                    <div class="profile-form-group">
                        <label class="profile-form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="profile-form-input" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="profile-btn profile-btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                    <button type="submit" class="profile-btn profile-btn-primary">
                        <i class="fas fa-save"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Change Avatar Function
function changeAvatar() {
    Swal.fire({
        title: 'Change Profile Photo',
        text: 'Choose how you want to update your profile photo',
        icon: 'question',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonColor: '#3b82f6',
        denyButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-upload"></i> Upload Photo',
        denyButtonText: '<i class="fas fa-user-circle"></i> Use Avatar',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create file input
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    uploadAvatar(file);
                }
            };
            input.click();
        } else if (result.isDenied) {
            // Use generated avatar
            generateAvatar();
        }
    });
}

// Upload Avatar Function
function uploadAvatar(file) {
    const formData = new FormData();
    formData.append('avatar', file);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    
    Swal.fire({
        title: 'Uploading...',
        text: 'Please wait while we upload your photo',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('{{ route("student.profile.avatar") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Photo Updated!',
                text: 'Your profile photo has been updated successfully.',
                confirmButtonColor: '#3b82f6'
            }).then(() => {
                // Update all avatar instances using helper function
                if (typeof updateAllAvatars === 'function') {
                    updateAllAvatars(data.avatar_url);
                } else {
                    // Fallback if helper not loaded
                    document.querySelector('.profile-avatar').src = data.avatar_url;
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Upload Failed',
                text: data.message || 'Failed to upload photo',
                confirmButtonColor: '#ef4444'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Upload Failed',
            text: 'An error occurred while uploading your photo',
            confirmButtonColor: '#ef4444'
        });
    });
}

// Generate Avatar Function
function generateAvatar() {
    const name = '{{ auth()->user()->name }}';
    const colors = ['3B82F6', '1D4ED8', '60A5FA', '93C5FD', 'DBEAFE'];
    const randomColor = colors[Math.floor(Math.random() * colors.length)];
    const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&color=${randomColor}&background=EBF4FF&size=120`;
    
    // Update all avatar instances using helper function
    if (typeof updateAllAvatars === 'function') {
        updateAllAvatars(avatarUrl);
    } else {
        // Fallback if helper not loaded
        document.querySelector('.profile-avatar').src = avatarUrl;
    }
    
    Swal.fire({
        icon: 'success',
        title: 'Avatar Updated!',
        text: 'Your profile avatar has been updated.',
        confirmButtonColor: '#3b82f6'
    });
}

// Change Password Function
function changePassword() {
    const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
    modal.show();
}

// Logout All Devices Function
function confirmLogoutAllDevices() {
    Swal.fire({
        title: 'Logout All Devices?',
        text: 'This will log you out from all devices except this one. You will need to log in again on other devices.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Logout All',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            logoutAllDevices();
        }
    });
}

// Logout All Devices Function
function logoutAllDevices() {
    Swal.fire({
        title: 'Logging out...',
        text: 'Please wait while we logout all devices',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('{{ route("student.profile.logout-devices") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'All devices have been logged out successfully.',
                confirmButtonColor: '#3b82f6'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: data.message || 'Failed to logout all devices',
                confirmButtonColor: '#ef4444'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while logging out devices',
            confirmButtonColor: '#ef4444'
        });
    });
}

// Load Activity Function
function loadActivity() {
    fetch('{{ route("student.profile.activity") }}')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const container = document.getElementById('activityContainer');
            container.innerHTML = '';
            
            if (data.activities.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-500">No recent activity found.</p>';
                return;
            }
            
            data.activities.forEach(activity => {
                const activityItem = document.createElement('div');
                activityItem.className = 'profile-activity-item';
                activityItem.innerHTML = `
                    <div class="profile-activity-icon ${activity.type}">
                        <i class="${activity.icon}"></i>
                    </div>
                    <div class="profile-activity-content">
                        <div class="profile-activity-title">${activity.description}</div>
                        <div class="profile-activity-time">${activity.timestamp}</div>
                    </div>
                `;
                container.appendChild(activityItem);
            });
        }
    })
    .catch(error => {
        console.error('Error loading activity:', error);
    });
}

// Form Submissions
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    Swal.fire({
        title: 'Updating...',
        text: 'Please wait while we update your profile',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: 'Your profile has been updated successfully.',
                confirmButtonColor: '#3b82f6'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: data.message || 'Failed to update profile',
                confirmButtonColor: '#ef4444'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Update Failed',
            text: 'An error occurred while updating your profile',
            confirmButtonColor: '#ef4444'
        });
    });
});

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    Swal.fire({
        title: 'Updating Password...',
        text: 'Please wait while we update your password',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
            modal.hide();
            
            Swal.fire({
                icon: 'success',
                title: 'Password Updated!',
                text: 'Your password has been updated successfully.',
                confirmButtonColor: '#3b82f6'
            });
            
            // Reset form
            this.reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: data.message || 'Failed to update password',
                confirmButtonColor: '#ef4444'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Update Failed',
            text: 'An error occurred while updating your password',
            confirmButtonColor: '#ef4444'
        });
    });
});

// Load activity on page load
document.addEventListener('DOMContentLoaded', function() {
    loadActivity();
});
</script>
@endpush