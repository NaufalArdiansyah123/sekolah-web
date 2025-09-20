<?php $__env->startSection('title', 'Edit User'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .user-edit-container {
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

    /* Form Container */
    .form-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
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

    /* Form Controls */
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

    .form-label .required {
        color: #dc2626;
        margin-left: 0.25rem;
    }

    .form-control, .form-select {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
        font-size: 0.875rem;
        width: 100%;
    }

    .form-control:focus, .form-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.25);
        background: var(--bg-primary);
        color: var(--text-primary);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #dc2626;
    }

    .invalid-feedback {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .form-text {
        color: var(--text-secondary);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    /* Input Group */
    .input-group {
        display: flex;
        align-items: stretch;
    }

    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: none;
    }

    .input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
        color: var(--text-secondary);
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .input-group .btn:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }

    /* Role Selection */
    .role-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .role-card {
        background: var(--bg-secondary);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .role-card:hover {
        border-color: #f59e0b;
        background: var(--bg-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);
    }

    .role-card.selected {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.05);
    }

    .role-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .role-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .role-super-admin { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
    .role-admin { background: rgba(245, 158, 11, 0.1); color: #d97706; }
    .role-teacher { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
    .role-student { background: rgba(16, 185, 129, 0.1); color: #059669; }

    .role-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-primary);
        color: var(--text-secondary);
    }

    .role-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
    }

    /* Info Sidebar */
    .info-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        height: fit-content;
        position: sticky;
        top: 2rem;
        margin-bottom: 1.5rem;
    }

    .info-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        object-fit: cover;
        border: 3px solid var(--border-color);
        margin-bottom: 1rem;
    }

    .user-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .user-info-item:last-child {
        border-bottom: none;
    }

    .user-info-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .user-info-value {
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-inactive {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .quick-action-btn {
        padding: 0.75rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        justify-content: center;
    }

    .quick-action-btn:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
        text-decoration: none;
        color: var(--text-primary);
    }

    .quick-action-warning {
        border-color: #f59e0b;
        color: #d97706;
    }

    .quick-action-warning:hover {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .quick-action-success {
        border-color: #059669;
        color: #059669;
    }

    .quick-action-success:hover {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .quick-action-info {
        border-color: #3b82f6;
        color: #2563eb;
    }

    .quick-action-info:hover {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
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

    .btn-primary {
        background: #f59e0b;
        color: white;
    }

    .btn-primary:hover {
        background: #d97706;
        transform: translateY(-1px);
        text-decoration: none;
        color: white;
    }

    .btn-primary:disabled {
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
        .user-edit-container {
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

        .form-container {
            padding: 1.5rem;
        }

        .role-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
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

<div class="user-edit-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit User
            </h1>
            <p class="page-subtitle">Update user information: <?php echo e($user->name); ?></p>
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

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form -->
            <div class="form-container">
                <div class="form-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Update User Information
                </div>

                <form action="<?php echo e(route('admin.users.update', $user)); ?>" method="POST" id="editUserForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Full Name
                                    <span class="required">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?php echo e(old('name', $user->name)); ?>" 
                                       placeholder="Enter full name"
                                       required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    Email Address
                                    <span class="required">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo e(old('email', $user->email)); ?>" 
                                       placeholder="Enter email address"
                                       required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter new password">
                                    <button class="btn" type="button" id="togglePassword">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">Leave empty if you don't want to change password</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Confirm new password">
                                    <button class="btn" type="button" id="togglePasswordConfirm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="form-text" id="passwordMatch"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            User Role
                            <span class="required">*</span>
                        </label>
                        <input type="hidden" name="role" id="selectedRole" value="<?php echo e(old('role', $user->roles->first()?->name)); ?>">
                        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback" style="display: block;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        
                        <div class="role-grid">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="role-card <?php echo e(old('role', $user->roles->first()?->name) == $role->name ? 'selected' : ''); ?>" 
                                     data-role="<?php echo e($role->name); ?>" 
                                     onclick="selectRole('<?php echo e($role->name); ?>')">
                                    <div class="role-header">
                                        <span class="role-badge role-<?php echo e(str_replace('_', '-', $role->name)); ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $role->name))); ?>

                                        </span>
                                        <div class="role-icon">
                                            <?php if($role->name === 'super_admin'): ?>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                </svg>
                                            <?php elseif($role->name === 'admin'): ?>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                            <?php elseif($role->name === 'teacher'): ?>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                                </svg>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="role-description">
                                        <?php if($role->name === 'super_admin'): ?>
                                            Full system access with ability to manage all data and users.
                                        <?php elseif($role->name === 'admin'): ?>
                                            Can manage content, media, and academic data. Cannot manage users.
                                        <?php elseif($role->name === 'teacher'): ?>
                                            Can manage learning content and student data under supervision.
                                        <?php else: ?>
                                            Can access learning materials and register for extracurricular activities.
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- User Info -->
            <div class="info-container">
                <div class="info-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Current User Info
                </div>
                
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <img src="<?php echo e($user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF'); ?>" 
                         alt="<?php echo e($user->name); ?>" 
                         class="user-avatar-large">
                </div>
                
                <div class="user-info-item">
                    <span class="user-info-label">Name</span>
                    <span class="user-info-value"><?php echo e($user->name); ?></span>
                </div>
                
                <div class="user-info-item">
                    <span class="user-info-label">Email</span>
                    <span class="user-info-value"><?php echo e($user->email); ?></span>
                </div>
                
                <div class="user-info-item">
                    <span class="user-info-label">Status</span>
                    <span class="status-badge <?php echo e($user->email_verified_at ? 'status-active' : 'status-inactive'); ?>">
                        <?php echo e($user->email_verified_at ? 'Active' : 'Inactive'); ?>

                    </span>
                </div>
                
                <div class="user-info-item">
                    <span class="user-info-label">Joined</span>
                    <span class="user-info-value"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                </div>
                
                <div class="user-info-item">
                    <span class="user-info-label">Current Role</span>
                    <span class="user-info-value">
                        <?php if($user->roles->count() > 0): ?>
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="role-badge role-<?php echo e(str_replace('_', '-', $role->name)); ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $role->name))); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <span class="role-badge role-none">No Role</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="info-container">
                <div class="info-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Quick Actions
                </div>
                
                <div class="quick-actions">
                    <button class="quick-action-btn quick-action-warning reset-password-btn" 
                            data-user-id="<?php echo e($user->id); ?>"
                            data-user-name="<?php echo e($user->name); ?>">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Reset Password
                    </button>
                    
                    <?php if($user->id !== auth()->id()): ?>
                        <button class="quick-action-btn <?php echo e($user->email_verified_at ? 'quick-action-warning' : 'quick-action-success'); ?> toggle-status-btn"
                                data-user-id="<?php echo e($user->id); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <?php if($user->email_verified_at): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18 12M6 6l12 12"/>
                                <?php else: ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                <?php endif; ?>
                            </svg>
                            <?php echo e($user->email_verified_at ? 'Deactivate User' : 'Activate User'); ?>

                        </button>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="quick-action-btn quick-action-info">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Ensure jQuery is loaded
(function() {
    if (typeof jQuery === 'undefined') {
        console.error('⚠ jQuery is not loaded! Loading from CDN...');
        
        const script = document.createElement('script');
        script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
        script.onload = function() {
            console.log('✅ jQuery loaded dynamically');
            window.$ = window.jQuery = jQuery;
            initializeEditUserFunctions();
        };
        document.head.appendChild(script);
    } else {
        console.log('✅ jQuery already loaded');
        window.$ = window.jQuery = jQuery;
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeEditUserFunctions);
        } else {
            initializeEditUserFunctions();
        }
    }
})();

function initializeEditUserFunctions() {
    console.log('Initializing edit user functions...');
    
    // Toggle password visibility
    $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const icon = $(this).find('svg');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.html(`
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
            `);
        } else {
            passwordField.attr('type', 'password');
            icon.html(`
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `);
        }
    });
    
    $('#togglePasswordConfirm').click(function() {
        const passwordField = $('#password_confirmation');
        const icon = $(this).find('svg');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.html(`
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
            `);
        } else {
            passwordField.attr('type', 'password');
            icon.html(`
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `);
        }
    });
    
    // Password confirmation check
    $('#password_confirmation').on('input', function() {
        const password = $('#password').val();
        const confirmation = $(this).val();
        const matchText = $('#passwordMatch');
        
        if (confirmation.length > 0 && password.length > 0) {
            if (password === confirmation) {
                matchText.text('✓ Passwords match').css('color', '#059669');
            } else {
                matchText.text('✗ Passwords do not match').css('color', '#dc2626');
            }
        } else {
            matchText.text('');
        }
    });
    
    // Reset password
    let currentUserId = null;
    
    $('.reset-password-btn').click(function() {
        currentUserId = $(this).data('user-id');
        const userName = $(this).data('user-name');
        
        $('#resetUserName').text(userName);
        $('#resetPasswordModal').modal('show');
    });
    
    $('#confirmResetPassword').click(function() {
        if (!currentUserId) return;
        
        $.ajax({
            url: `/admin/users/${currentUserId}/reset-password`,
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                if (response.success) {
                    $('#resetPasswordModal').modal('hide');
                    alert('Password reset successfully!');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert('Error: ' + (response.message || 'An error occurred'));
            }
        });
    });
    
    // Toggle status
    $('.toggle-status-btn').click(function() {
        const userId = $(this).data('user-id');
        const button = $(this);
        
        $.ajax({
            url: `/admin/users/${userId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                if (response.success) {
                    alert('User status updated successfully!');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert('Error: ' + (response.message || 'An error occurred'));
            }
        });
    });
    
    // Form validation
    $('#editUserForm').submit(function(e) {
        const password = $('#password').val();
        const passwordConfirm = $('#password_confirmation').val();
        const role = $('#selectedRole').val();
        
        if (!role) {
            e.preventDefault();
            alert('Please select a user role');
            return false;
        }
        
        if (password && password !== passwordConfirm) {
            e.preventDefault();
            alert('Password and confirmation password do not match');
            return false;
        }
        
        if (password && password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters');
            return false;
        }
        
        // Disable submit button to prevent double submission
        $('#submitBtn').prop('disabled', true).text('Updating...');
    });
}

function selectRole(roleName) {
    // Remove selected class from all cards
    document.querySelectorAll('.role-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selected class to clicked card
    const selectedCard = document.querySelector(`[data-role="${roleName}"]`);
    if (selectedCard) {
        selectedCard.classList.add('selected');
    }
    
    // Set hidden input value
    document.getElementById('selectedRole').value = roleName;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>