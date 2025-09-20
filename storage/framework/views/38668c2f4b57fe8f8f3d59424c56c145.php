<?php $__env->startSection('title', 'Create Announcement'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .announcement-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
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
        text-align: center;
        width: 100%;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .btn-back {
        background: white;
        color: #f59e0b;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #f59e0b;
        text-decoration: none;
    }

    /* Form Container */
    .form-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        animation: slideUp 0.5s ease-out;
    }

    .form-header {
        background: var(--bg-tertiary);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .form-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: color 0.3s ease;
    }

    .form-body {
        padding: 2rem;
        background: var(--bg-primary);
        transition: all 0.3s ease;
    }

    /* Form Groups */
    .form-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 0;
    }

    .form-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .form-label .required {
        color: #ef4444;
        font-size: 0.75rem;
    }

    .form-input {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        resize: vertical;
    }

    .form-input:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        outline: none;
    }

    .form-input.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-select {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        outline: none;
    }

    .form-select.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-textarea.content {
        min-height: 200px;
    }

    /* Error Messages */
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Help Text */
    .form-help {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
        transition: color 0.3s ease;
    }

    /* File Upload Styles */
    .file-upload-container {
        margin-top: 0.75rem;
    }

    .file-upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .file-upload-area:hover {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.05);
        transform: translateY(-2px);
    }

    .file-upload-area.dragover {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.1);
        transform: scale(1.02);
    }

    .upload-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .upload-icon {
        width: 3rem;
        height: 3rem;
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }

    .file-upload-area:hover .upload-icon {
        color: #f59e0b;
    }

    .upload-text {
        text-align: center;
    }

    .upload-main {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-primary);
        margin: 0 0 0.5rem 0;
        transition: color 0.3s ease;
    }

    .upload-link {
        color: #f59e0b;
        font-weight: 600;
        cursor: pointer;
        text-decoration: underline;
    }

    .upload-sub {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin: 0;
        transition: color 0.3s ease;
    }

    .upload-progress {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: var(--bg-tertiary);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #f59e0b, #d97706);
        border-radius: 4px;
        transition: width 0.3s ease;
        width: 0%;
    }

    .progress-text {
        font-size: 0.875rem;
        color: var(--text-primary);
        margin: 0;
        transition: color 0.3s ease;
    }

    /* URL Input Section */
    .url-input-section {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .input-toggle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .toggle-text {
        font-size: 0.875rem;
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }

    .toggle-btn {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-btn:hover {
        background: #f59e0b;
        color: white;
        border-color: #f59e0b;
    }

    .url-input-container {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .url-input-container .form-input {
        flex: 1;
    }

    .btn-url-load {
        background: #10b981;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-url-load:hover {
        background: #059669;
    }

    /* Image Preview */
    .image-preview-container {
        margin-top: 1rem;
        display: none;
    }

    .image-preview-wrapper {
        position: relative;
        display: inline-block;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px var(--shadow-color);
    }

    .image-preview {
        max-width: 100%;
        max-height: 250px;
        display: block;
        border-radius: 12px;
    }

    .image-actions {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        display: flex;
        gap: 0.5rem;
    }

    .btn-remove-image {
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        backdrop-filter: blur(10px);
    }

    .btn-remove-image:hover {
        background: rgba(220, 38, 38, 0.9);
        transform: scale(1.05);
    }

    .image-info {
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: var(--bg-secondary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        font-size: 0.75rem;
        color: var(--text-secondary);
        transition: all 0.3s ease;
    }

    /* Priority and Status Badges */
    .priority-preview, .status-preview {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.5rem;
    }

    .priority-urgent { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); }
    .priority-high { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .priority-normal { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .priority-low { background: rgba(107, 114, 128, 0.1); color: #374151; border: 1px solid rgba(107, 114, 128, 0.2); }

    .status-published { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-draft { background: rgba(107, 114, 128, 0.1); color: #374151; border: 1px solid rgba(107, 114, 128, 0.2); }
    .status-archived { background: rgba(75, 85, 99, 0.1); color: #1f2937; border: 1px solid rgba(75, 85, 99, 0.2); }

    /* Form Actions */
    .form-actions {
        background: var(--bg-tertiary);
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert-dismissible .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        opacity: 0.6;
        cursor: pointer;
        color: inherit;
    }

    .alert-dismissible .btn-close:hover {
        opacity: 1;
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .announcement-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .form-actions > * {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animation */
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

    /* Character Counter */
    .char-counter {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-align: right;
        margin-top: 0.25rem;
        transition: color 0.3s ease;
    }

    .char-counter.warning {
        color: #f59e0b;
    }

    .char-counter.danger {
        color: #ef4444;
    }
</style>

<div class="announcement-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create New Announcement
            </h1>
            <p class="page-subtitle">Create and publish announcements for your school community</p>
            <a href="<?php echo e(route('admin.announcements.index')); ?>" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Announcements
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 0.5rem 0 0 1rem; list-style: disc;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <h2>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                Announcement Details
            </h2>
        </div>

        <form action="<?php echo e(route('admin.announcements.store')); ?>" method="POST" id="announcementForm" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="form-body">
                <div class="form-row">
                    <!-- Left Column - Main Content -->
                    <div class="form-section">
                        <div class="form-group">
                            <label for="judul" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Title
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   id="judul" 
                                   class="form-input <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('judul')); ?>" 
                                   required
                                   maxlength="200"
                                   placeholder="Enter announcement title...">
                            <div class="char-counter" id="titleCounter">0/200</div>
                            <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="isi" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Content
                                <span class="required">*</span>
                            </label>
                            <textarea name="isi" 
                                      id="isi" 
                                      class="form-input form-textarea content <?php $__errorArgs = ['isi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      required
                                      placeholder="Write your announcement content here..."><?php echo e(old('isi')); ?></textarea>
                            <div class="char-counter" id="contentCounter">0 characters</div>
                            <?php $__errorArgs = ['isi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="gambar" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Featured Image
                            </label>
                            
                            <!-- File Upload Area -->
                            <div class="file-upload-container">
                                <div class="file-upload-area" id="fileUploadArea">
                                    <div class="upload-content" id="uploadContent">
                                        <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <div class="upload-text">
                                            <p class="upload-main">Drop your image here or <span class="upload-link">browse files</span></p>
                                            <p class="upload-sub">Supports: JPG, PNG, GIF, WebP (Max: 5MB)</p>
                                        </div>
                                    </div>
                                    <div class="upload-progress" id="uploadProgress" style="display: none;">
                                        <div class="progress-bar">
                                            <div class="progress-fill" id="progressFill"></div>
                                        </div>
                                        <p class="progress-text" id="progressText">Uploading... 0%</p>
                                    </div>
                                </div>
                                
                                <input type="file" 
                                       id="fileInput" 
                                       name="featured_image" 
                                       accept="image/*" 
                                       style="display: none;">
                                
                                <!-- Hidden input for storing image path -->
                                <input type="hidden" 
                                       name="gambar" 
                                       id="gambar" 
                                       value="<?php echo e(old('gambar')); ?>">
                            </div>
                            
                            <!-- URL Input Alternative -->
                            <div class="url-input-section">
                                <div class="input-toggle">
                                    <span class="toggle-text">Or use image URL:</span>
                                    <button type="button" class="toggle-btn" id="urlToggle">Enter URL</button>
                                </div>
                                <div class="url-input-container" id="urlInputContainer" style="display: none;">
                                    <input type="url" 
                                           id="imageUrl" 
                                           class="form-input" 
                                           placeholder="https://example.com/image.jpg">
                                    <button type="button" class="btn-url-load" id="loadUrlBtn">Load Image</button>
                                </div>
                            </div>
                            
                            <!-- Image Preview -->
                            <div class="image-preview-container" id="imagePreviewContainer" style="display: none;">
                                <div class="image-preview-wrapper">
                                    <img id="imagePreview" class="image-preview" alt="Image preview">
                                    <div class="image-actions">
                                        <button type="button" class="btn-remove-image" id="removeImageBtn">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                <div class="image-info" id="imageInfo"></div>
                            </div>
                            
                            <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Right Column - Settings -->
                    <div class="form-section">
                        <div class="form-group">
                            <label for="kategori" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Category
                                <span class="required">*</span>
                            </label>
                            <select name="kategori" id="kategori" class="form-select <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Select Category</option>
                                <option value="akademik" <?php echo e(old('kategori') === 'akademik' ? 'selected' : ''); ?>>Academic</option>
                                <option value="kegiatan" <?php echo e(old('kategori') === 'kegiatan' ? 'selected' : ''); ?>>Activities</option>
                                <option value="administrasi" <?php echo e(old('kategori') === 'administrasi' ? 'selected' : ''); ?>>Administration</option>
                                <option value="umum" <?php echo e(old('kategori') === 'umum' ? 'selected' : ''); ?>>General</option>
                            </select>
                            <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="prioritas" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                                Priority
                                <span class="required">*</span>
                            </label>
                            <select name="prioritas" id="prioritas" class="form-select <?php $__errorArgs = ['prioritas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Select Priority</option>
                                <option value="low" <?php echo e(old('prioritas') === 'low' ? 'selected' : ''); ?>>Low</option>
                                <option value="normal" <?php echo e(old('prioritas', 'normal') === 'normal' ? 'selected' : ''); ?>>Normal</option>
                                <option value="high" <?php echo e(old('prioritas') === 'high' ? 'selected' : ''); ?>>High</option>
                                <option value="urgent" <?php echo e(old('prioritas') === 'urgent' ? 'selected' : ''); ?>>Urgent</option>
                            </select>
                            <div class="priority-preview" id="priorityPreview" style="display: none;"></div>
                            <?php $__errorArgs = ['prioritas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="penulis" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Author
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="penulis" 
                                   id="penulis" 
                                   class="form-input <?php $__errorArgs = ['penulis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('penulis', auth()->user()->name ?? '')); ?>" 
                                   required
                                   placeholder="Author name">
                            <?php $__errorArgs = ['penulis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status
                                <span class="required">*</span>
                            </label>
                            <select name="status" id="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="draft" <?php echo e(old('status', 'draft') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                                <option value="published" <?php echo e(old('status') === 'published' ? 'selected' : ''); ?>>Published</option>
                                <option value="archived" <?php echo e(old('status') === 'archived' ? 'selected' : ''); ?>>Archived</option>
                            </select>
                            <div class="status-preview" id="statusPreview" style="display: none;"></div>
                            <div class="form-help">Draft: Save without publishing, Published: Make visible to everyone</div>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_publikasi" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Publication Date
                            </label>
                            <input type="datetime-local" 
                                   name="tanggal_publikasi" 
                                   id="tanggal_publikasi" 
                                   class="form-input <?php $__errorArgs = ['tanggal_publikasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('tanggal_publikasi', now()->format('Y-m-d\TH:i'))); ?>">
                            <div class="form-help">When should this announcement be published?</div>
                            <?php $__errorArgs = ['tanggal_publikasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?php echo e(route('admin.announcements.index')); ?>" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counters
    const titleInput = document.getElementById('judul');
    const titleCounter = document.getElementById('titleCounter');
    const contentInput = document.getElementById('isi');
    const contentCounter = document.getElementById('contentCounter');

    function updateTitleCounter() {
        const length = titleInput.value.length;
        const maxLength = 200;
        titleCounter.textContent = `${length}/${maxLength}`;
        
        if (length > maxLength * 0.9) {
            titleCounter.classList.add('danger');
            titleCounter.classList.remove('warning');
        } else if (length > maxLength * 0.7) {
            titleCounter.classList.add('warning');
            titleCounter.classList.remove('danger');
        } else {
            titleCounter.classList.remove('warning', 'danger');
        }
    }

    function updateContentCounter() {
        const length = contentInput.value.length;
        contentCounter.textContent = `${length} characters`;
    }

    titleInput.addEventListener('input', updateTitleCounter);
    contentInput.addEventListener('input', updateContentCounter);

    // Initialize counters
    updateTitleCounter();
    updateContentCounter();

    // File Upload Functionality
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('fileInput');
    const uploadContent = document.getElementById('uploadContent');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressFill = document.getElementById('progressFill');
    const progressText = document.getElementById('progressText');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const imageInfo = document.getElementById('imageInfo');
    const removeImageBtn = document.getElementById('removeImageBtn');
    const gambarInput = document.getElementById('gambar');
    
    // URL Input Functionality
    const urlToggle = document.getElementById('urlToggle');
    const urlInputContainer = document.getElementById('urlInputContainer');
    const imageUrl = document.getElementById('imageUrl');
    const loadUrlBtn = document.getElementById('loadUrlBtn');

    // File upload click handler
    fileUploadArea.addEventListener('click', function() {
        fileInput.click();
    });

    // Drag and drop handlers
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    fileUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileUpload(files[0]);
        }
    });

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileUpload(e.target.files[0]);
        }
    });

    // Handle file upload
    function handleFileUpload(file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, PNG, GIF, WebP)');
            return;
        }

        // Validate file size (5MB)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('File size must be less than 5MB');
            return;
        }

        // Show upload progress
        uploadContent.style.display = 'none';
        uploadProgress.style.display = 'flex';

        // Simulate upload progress (replace with actual upload logic)
        simulateUpload(file);
    }

    // Simulate file upload (replace with actual upload to server)
    function simulateUpload(file) {
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                
                // Upload complete - show preview
                setTimeout(() => {
                    showImagePreview(file);
                    resetUploadArea();
                }, 500);
            }
            
            progressFill.style.width = progress + '%';
            progressText.textContent = `Uploading... ${Math.round(progress)}%`;
        }, 100);
    }

    // Show image preview
    function showImagePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreviewContainer.style.display = 'block';
            
            // Don't set base64 data in hidden input to avoid 255 char limit
            // The file will be handled by the file input instead
            gambarInput.value = ''; // Clear any URL value
            
            // Show file info
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            imageInfo.innerHTML = `
                <strong>File:</strong> ${file.name}<br>
                <strong>Size:</strong> ${fileSize} MB<br>
                <strong>Type:</strong> ${file.type}<br>
                <strong>Source:</strong> File Upload
            `;
        };
        reader.readAsDataURL(file);
    }

    // Reset upload area
    function resetUploadArea() {
        uploadContent.style.display = 'flex';
        uploadProgress.style.display = 'none';
        progressFill.style.width = '0%';
        progressText.textContent = 'Uploading... 0%';
    }

    // Remove image handler
    removeImageBtn.addEventListener('click', function() {
        imagePreviewContainer.style.display = 'none';
        gambarInput.value = '';
        fileInput.value = '';
        imageUrl.value = '';
    });

    // URL Toggle handler
    urlToggle.addEventListener('click', function() {
        const isVisible = urlInputContainer.style.display !== 'none';
        urlInputContainer.style.display = isVisible ? 'none' : 'block';
        this.textContent = isVisible ? 'Enter URL' : 'Hide URL';
    });

    // Load URL handler
    loadUrlBtn.addEventListener('click', function() {
        const url = imageUrl.value.trim();
        if (!url) {
            alert('Please enter a valid image URL');
            return;
        }

        // Show loading state
        this.disabled = true;
        this.textContent = 'Loading...';

        // Test if URL is valid image
        const img = new Image();
        img.onload = function() {
            imagePreview.src = url;
            imagePreviewContainer.style.display = 'block';
            gambarInput.value = url;
            
            // Show URL info
            imageInfo.innerHTML = `
                <strong>Source:</strong> External URL<br>
                <strong>URL:</strong> ${url}
            `;
            
            loadUrlBtn.disabled = false;
            loadUrlBtn.textContent = 'Load Image';
        };
        
        img.onerror = function() {
            alert('Failed to load image from URL. Please check the URL and try again.');
            loadUrlBtn.disabled = false;
            loadUrlBtn.textContent = 'Load Image';
        };
        
        img.src = url;
    });

    // Initialize with existing image if any
    if (gambarInput.value) {
        imagePreview.src = gambarInput.value;
        imagePreviewContainer.style.display = 'block';
        imageInfo.innerHTML = `
            <strong>Source:</strong> Existing image<br>
            <strong>URL:</strong> ${gambarInput.value}
        `;
    }

    // Priority preview
    const prioritySelect = document.getElementById('prioritas');
    const priorityPreview = document.getElementById('priorityPreview');

    function updatePriorityPreview() {
        const value = prioritySelect.value;
        if (value) {
            priorityPreview.className = `priority-preview priority-${value}`;
            priorityPreview.textContent = value.charAt(0).toUpperCase() + value.slice(1);
            priorityPreview.style.display = 'inline-block';
        } else {
            priorityPreview.style.display = 'none';
        }
    }

    prioritySelect.addEventListener('change', updatePriorityPreview);
    updatePriorityPreview();

    // Status preview
    const statusSelect = document.getElementById('status');
    const statusPreview = document.getElementById('statusPreview');

    function updateStatusPreview() {
        const value = statusSelect.value;
        if (value) {
            statusPreview.className = `status-preview status-${value}`;
            statusPreview.textContent = value.charAt(0).toUpperCase() + value.slice(1);
            statusPreview.style.display = 'inline-block';
        } else {
            statusPreview.style.display = 'none';
        }
    }

    statusSelect.addEventListener('change', updateStatusPreview);
    updateStatusPreview();

    // Form submission
    const form = document.getElementById('announcementForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="spinner"></div>
            Creating...
        `;
        
        // Add loading class to form
        form.classList.add('loading');
    });

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });

    // Form validation enhancement
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Prevent form submission if there are validation errors
    form.addEventListener('submit', function(e) {
        let hasErrors = false;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                hasErrors = true;
            }
        });

        if (hasErrors) {
            e.preventDefault();
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Create Announcement
            `;
            form.classList.remove('loading');
            
            // Show error message
            window.showToast && window.showToast('error', 'Validation Error', 'Please fill in all required fields.');
        }
    });

    // Auto-save draft functionality (optional)
    let autoSaveTimeout;
    const autoSaveFields = [titleInput, contentInput];
    
    function autoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            const formData = new FormData(form);
            formData.set('status', 'draft');
            
            // Only auto-save if title and content have some content
            if (titleInput.value.trim() && contentInput.value.trim()) {
                console.log('Auto-saving draft...'); // For debugging
                // Implement auto-save API call here if needed
            }
        }, 3000); // Auto-save after 3 seconds of inactivity
    }

    autoSaveFields.forEach(field => {
        field.addEventListener('input', autoSave);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/posts/announcement/create.blade.php ENDPATH**/ ?>