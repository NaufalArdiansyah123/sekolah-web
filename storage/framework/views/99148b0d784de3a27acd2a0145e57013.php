<?php $__env->startSection('title', 'Reset User Password'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .reset-password-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(245, 158, 11, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .header-actions {
        position: relative;
        z-index: 2;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Main Content */
    .main-content {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
        align-items: start;
    }

    .form-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
    }

    .form-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .user-info-card {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        text-align: center;
        position: sticky;
        top: 2rem;
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        object-fit: cover;
        border: 3px solid var(--border-color);
        margin-bottom: 1rem;
    }

    .user-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .user-email {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .user-role {
        margin-bottom: 1.5rem;
    }

    .role-badge {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .role-super-admin { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); }
    .role-admin { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .role-teacher { background: rgba(59, 130, 246, 0.1); color: #2563eb; border: 1px solid rgba(59, 130, 246, 0.2); }
    .role-student { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .role-none { background: rgba(107, 114, 128, 0.1); color: #6b7280; border: 1px solid rgba(107, 114, 128, 0.2); }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.875rem;
    }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
        font-size: 0.875rem;
        width: 100%;
    }

    .form-control:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.25);
        background: var(--bg-primary);
        color: var(--text-primary);
        outline: none;
    }

    .form-control:disabled {
        background: var(--bg-secondary);
        color: var(--text-secondary);
        cursor: not-allowed;
    }

    .form-text {
        color: var(--text-secondary);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .alert-info {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    /* Password Options */
    .password-options {
        display: grid;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .password-option {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--bg-secondary);
    }

    .password-option:hover {
        border-color: #f59e0b;
        background: var(--bg-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);
    }

    .password-option.selected {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.05);
    }

    .option-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .option-radio {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid var(--border-color);
        position: relative;
        transition: all 0.3s ease;
    }

    .password-option.selected .option-radio {
        border-color: #f59e0b;
        background: #f59e0b;
    }

    .password-option.selected .option-radio::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }

    .option-title {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
    }

    .option-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
    }

    /* Action Buttons */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
        text-decoration: none;
        color: var(--text-primary);
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
        transform: translateY(-1px);
        text-decoration: none;
        color: white;
    }

    .btn-warning:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
    }

    /* CSS Variables */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --text-tertiary: #9ca3af;
        --border-color: #e5e7eb;
        --shadow-color: rgba(0, 0, 0, 0.05);
    }

    .dark {
        --bg-primary: #1f2937;
        --bg-secondary: #111827;
        --bg-tertiary: #374151;
        --text-primary: #f9fafb;
        --text-secondary: #d1d5db;
        --text-tertiary: #9ca3af;
        --border-color: #374151;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .reset-password-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .main-content {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .form-container {
            padding: 1.5rem;
        }
    }

    /* Animation */
    .form-container {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="reset-password-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"/>
                </svg>
                Reset User Password
            </h1>
            <p class="page-subtitle">Reset password for user: <?php echo e($user->name); ?></p>
        </div>
        <div class="header-actions">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Users
            </a>
        </div>
    </div>

    <div class="main-content">
        <!-- Reset Password Form -->
        <div class="form-container">
            <div class="form-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Password Reset Options
            </div>

            <div class="alert alert-warning">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <div>
                    <strong>Warning:</strong> This action will immediately change the user's password. The user will need to use the new password to login.
                </div>
            </div>

            <form action="<?php echo e(route('admin.users.reset-password.store', $user)); ?>" method="POST" id="resetPasswordForm">
                <?php echo csrf_field(); ?>
                
                <div class="password-options">
                    <div class="password-option selected" onclick="selectOption('default')" data-option="default">
                        <div class="option-header">
                            <div class="option-radio"></div>
                            <div class="option-title">Default Password</div>
                        </div>
                        <div class="option-description">
                            Reset to default password: <strong>password123</strong><br>
                            User should change this password after first login.
                        </div>
                    </div>

                    <div class="password-option" onclick="selectOption('custom')" data-option="custom">
                        <div class="option-header">
                            <div class="option-radio"></div>
                            <div class="option-title">Custom Password</div>
                        </div>
                        <div class="option-description">
                            Set a custom password for the user.
                        </div>
                    </div>

                    <div class="password-option" onclick="selectOption('generate')" data-option="generate">
                        <div class="option-header">
                            <div class="option-radio"></div>
                            <div class="option-title">Generate Random Password</div>
                        </div>
                        <div class="option-description">
                            Generate a secure random password automatically.
                        </div>
                    </div>
                </div>

                <input type="hidden" name="reset_type" id="resetType" value="default">

                <div class="form-group" id="customPasswordGroup" style="display: none;">
                    <label for="custom_password" class="form-label">Custom Password</label>
                    <input type="password" 
                           class="form-control" 
                           id="custom_password" 
                           name="custom_password" 
                           placeholder="Enter custom password"
                           minlength="8">
                    <div class="form-text">Password must be at least 8 characters long</div>
                </div>

                <div class="alert alert-info">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <strong>Note:</strong> The user will be notified of the password change and should be advised to change their password after logging in.
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-warning" id="submitBtn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"/>
                        </svg>
                        Reset Password
                    </button>
                </div>
            </form>
        </div>

        <!-- User Info Sidebar -->
        <div class="user-info-card">
            <img src="<?php echo e($user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF'); ?>" 
                 alt="<?php echo e($user->name); ?>" 
                 class="user-avatar-large">
            
            <div class="user-name"><?php echo e($user->name); ?></div>
            <div class="user-email"><?php echo e($user->email); ?></div>
            
            <div class="user-role">
                <?php if($user->roles->count() > 0): ?>
                    <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="role-badge role-<?php echo e(str_replace('_', '-', $role->name)); ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $role->name))); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <span class="role-badge role-none">No Role</span>
                <?php endif; ?>
            </div>

            <div style="text-align: left; font-size: 0.875rem; color: var(--text-secondary);">
                <div style="margin-bottom: 0.5rem;">
                    <strong>Joined:</strong> <?php echo e($user->created_at->format('M d, Y')); ?>

                </div>
                <div style="margin-bottom: 0.5rem;">
                    <strong>Status:</strong> 
                    <span style="color: <?php echo e($user->email_verified_at ? '#059669' : '#6b7280'); ?>;">
                        <?php echo e($user->email_verified_at ? 'Active' : 'Inactive'); ?>

                    </span>
                </div>
                <div>
                    <strong>Last Updated:</strong> <?php echo e($user->updated_at->diffForHumans()); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectOption(type) {
    // Remove selected class from all options
    document.querySelectorAll('.password-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    // Add selected class to clicked option
    document.querySelector(`[data-option="${type}"]`).classList.add('selected');
    
    // Update hidden input
    document.getElementById('resetType').value = type;
    
    // Show/hide custom password field
    const customGroup = document.getElementById('customPasswordGroup');
    const customInput = document.getElementById('custom_password');
    
    if (type === 'custom') {
        customGroup.style.display = 'block';
        customInput.required = true;
    } else {
        customGroup.style.display = 'none';
        customInput.required = false;
        customInput.value = '';
    }
}

// Form validation
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    const resetType = document.getElementById('resetType').value;
    const customPassword = document.getElementById('custom_password').value;
    
    if (resetType === 'custom' && customPassword.length < 8) {
        e.preventDefault();
        alert('Custom password must be at least 8 characters long');
        return false;
    }
    
    // Confirm action
    if (!confirm('Are you sure you want to reset this user\'s password? This action cannot be undone.')) {
        e.preventDefault();
        return false;
    }
    
    // Disable submit button to prevent double submission
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('submitBtn').innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Resetting...
    `;
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/users/reset-password.blade.php ENDPATH**/ ?>