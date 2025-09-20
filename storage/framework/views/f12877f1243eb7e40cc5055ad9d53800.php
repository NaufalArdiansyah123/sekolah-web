<?php $__env->startSection('title', 'Tambah Siswa'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .create-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .form-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        max-width: 1000px;
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .form-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }
    
    .form-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .form-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }
    
    .btn-close-custom {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        z-index: 3;
    }
    
    .btn-close-custom:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: scale(1.1);
        color: white;
    }
    
    .btn-close-custom:active {
        transform: scale(0.95);
    }
    
    .form-body {
        padding: 2rem;
    }
    
    .form-section {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #4f46e5;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .required {
        color: #ef4444;
    }
    
    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        background: white;
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .photo-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #f9fafb;
        cursor: pointer;
    }
    
    .photo-upload-area:hover {
        border-color: #4f46e5;
        background: #f0f9ff;
    }
    
    .photo-upload-area.dragover {
        border-color: #4f46e5;
        background: #eff6ff;
        transform: scale(1.02);
    }
    
    .photo-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin: 1rem auto;
    }
    
    .user-account-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 2px solid #0ea5e9;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 1rem;
    }
    
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .custom-checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid #4f46e5;
        border-radius: 4px;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .custom-checkbox input {
        opacity: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .custom-checkbox input:checked + .checkmark {
        background: #4f46e5;
        border-color: #4f46e5;
    }
    
    .custom-checkbox input:checked + .checkmark::after {
        content: '✓';
        color: white;
        font-size: 12px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    .form-actions {
        background: #f9fafb;
        padding: 1.5rem 2rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }
    
    .btn-custom {
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        color: white;
    }
    
    .btn-secondary-custom {
        background: #6b7280;
        color: white;
    }
    
    .btn-secondary-custom:hover {
        background: #4b5563;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-outline-custom {
        background: transparent;
        border: 2px solid #6b7280;
        color: #6b7280;
    }
    
    .btn-outline-custom:hover {
        background: #6b7280;
        color: white;
    }
    
    .btn-close-left {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: 2px solid #ef4444;
        position: relative;
        overflow: hidden;
    }
    
    .btn-close-left::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .btn-close-left:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        border-color: #dc2626;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
    }
    
    .btn-close-left:hover::before {
        opacity: 1;
    }
    
    .btn-close-left:active {
        transform: translateY(0);
    }
    
    .alert-custom {
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .alert-danger-custom {
        background: #fef2f2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }
    
    .alert-success-custom {
        background: #f0fdf4;
        color: #166534;
        border-left: 4px solid #22c55e;
    }
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f4f6;
        border-top: 4px solid #4f46e5;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .floating-actions {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 1000;
    }
    
    .floating-actions-mobile {
        position: fixed;
        bottom: 1rem;
        left: 1rem;
        right: 1rem;
        display: none;
        flex-direction: row;
        gap: 0.5rem;
        z-index: 1000;
        justify-content: space-between;
    }
    
    .floating-btn {
        min-width: 64px;
        height: 64px;
        border-radius: 16px;
        border: none;
        color: white;
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        position: relative;
        overflow: hidden;
        padding: 0 1rem;
        gap: 0.5rem;
        font-weight: 600;
        white-space: nowrap;
    }
    
    .floating-btn-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .floating-btn-text {
        font-size: 0.875rem;
        display: none;
    }
    
    .floating-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .floating-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        color: white;
        min-width: 140px;
    }
    
    .floating-btn:hover .floating-btn-text {
        display: block;
    }
    
    .floating-btn:hover::before {
        opacity: 1;
    }
    
    .floating-btn:active {
        transform: translateY(-1px) scale(1.02);
    }
    
    .floating-btn-primary {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
    }
    
    .floating-btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
    }
    
    .floating-btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .floating-btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    
    @media (max-width: 768px) {
        .form-wrapper {
            margin: 0 1rem;
        }
        
        .form-body {
            padding: 1rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn-custom {
            width: 100%;
            justify-content: center;
        }
        
        .form-header {
            text-align: left;
        }
        
        .form-header h1 {
            font-size: 2rem;
        }
        
        .floating-actions {
            display: none;
        }
        
        .floating-actions-mobile {
            display: flex;
        }
        
        .floating-btn {
            flex: 1;
            min-width: auto;
            height: 48px;
            font-size: 1rem;
        }
        
        .floating-btn-icon {
            font-size: 1.25rem;
        }
        
        .floating-btn:hover {
            min-width: auto;
        }
        
    .floating-btn-text {
        display: block;
        font-size: 0.75rem;
    }
    
    /* Validation Styles */
    .input-wrapper {
        position: relative;
    }
    
    .validation-icon {
        position: absolute;
        right: 35px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        z-index: 5;
    }
    
    .validation-message {
        font-size: 0.75rem;
        margin-top: 0.25rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .validation-message.success {
        color: #166534;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
    }
    
    .validation-message.error {
        color: #991b1b;
        background: #fef2f2;
        border: 1px solid #fecaca;
    }
    
    .validation-message.loading {
        color: #1d4ed8;
        background: #dbeafe;
        border: 1px solid #bfdbfe;
    }
    
    .validation-icon.success {
        color: #16a34a;
    }
    
    .validation-icon.error {
        color: #dc2626;
    }
    
    .validation-icon.loading {
        color: #2563eb;
    }
    
    .form-control.is-valid {
        border-color: #16a34a;
        box-shadow: 0 0 0 0.2rem rgba(22, 163, 74, 0.25);
    }
    
    .form-control.is-invalid {
        border-color: #dc2626;
        box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
    }
    
    .spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
}</style>
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="create-container">
    <div class="form-wrapper">
        <!-- Form Header -->
        <div class="form-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1><i class="fas fa-user-plus me-3"></i>Tambah Siswa Baru</h1>
                    <p>Lengkapi formulir di bawah untuk menambahkan data siswa baru</p>
                </div>
                <button type="button" class="btn-close-custom" onclick="closeForm()" title="Tutup Form">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Form Body -->
        <div class="form-body">
            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="alert-custom alert-danger-custom">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.students.store')); ?>" enctype="multipart/form-data" id="studentForm">
                <?php echo csrf_field(); ?>
                
                <!-- Personal Information Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        Data Pribadi
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Nama Lengkap <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nis" class="form-label">
                                    NIS <span class="required">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" class="form-control <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="nis" name="nis" value="<?php echo e(old('nis')); ?>" 
                                           placeholder="Contoh: 2024100001" 
                                           pattern="[0-9]+" 
                                           minlength="6" 
                                           maxlength="20" 
                                           required>
                                    <div class="validation-icon" id="nisValidationIcon" style="display: none;"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            id="generateNisBtn" 
                                            style="position: absolute; right: 5px; top: 5px; z-index: 10; font-size: 0.7rem; padding: 0.25rem 0.5rem;"
                                            title="Generate NIS otomatis">
                                        <i class="fas fa-magic"></i>
                                    </button>
                                </div>
                                <div id="nisValidationMessage" class="validation-message" style="display: none;"></div>
                                <?php $__errorArgs = ['nis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Format: Tahun(4) + Kelas(2) + Urutan(3). Contoh: 2024100001</small>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nisn" class="form-label">NISN</label>
                                <div class="input-wrapper">
                                    <input type="text" class="form-control <?php $__errorArgs = ['nisn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="nisn" name="nisn" value="<?php echo e(old('nisn')); ?>" 
                                           placeholder="10 digit angka" 
                                           pattern="[0-9]{10}" 
                                           minlength="10" 
                                           maxlength="10">
                                    <div class="validation-icon" id="nisnValidationIcon" style="display: none;"></div>
                                </div>
                                <div id="nisnValidationMessage" class="validation-message" style="display: none;"></div>
                                <?php $__errorArgs = ['nisn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">NISN harus 10 digit angka (opsional)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="email" name="email" value="<?php echo e(old('email')); ?>">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="phone" name="phone" value="<?php echo e(old('phone')); ?>">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="class" class="form-label">
                                    Kelas <span class="required">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="class" name="class" required>
                                    <option value="">Pilih Kelas</option>
                                    <?php $__currentLoopData = $classOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade => $classes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <optgroup label="Kelas <?php echo e($grade); ?>">
                                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $parsed = \App\Helpers\ClassHelper::parseClass($class);
                                                    $majorName = \App\Helpers\ClassHelper::getMajors()[$parsed['major']] ?? $parsed['major'];
                                                ?>
                                                <option value="<?php echo e($class); ?>" <?php echo e(old('class') == $class ? 'selected' : ''); ?>>
                                                    <?php echo e($class); ?> - <?php echo e($majorName); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </optgroup>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_date" class="form-label">
                                    Tanggal Lahir <span class="required">*</span>
                                </label>
                                <input type="date" class="form-control <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="birth_date" name="birth_date" value="<?php echo e(old('birth_date')); ?>" required>
                                <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_place" class="form-label">
                                    Tempat Lahir <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['birth_place'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="birth_place" name="birth_place" value="<?php echo e(old('birth_place')); ?>" required>
                                <?php $__errorArgs = ['birth_place'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    Jenis Kelamin <span class="required">*</span>
                                </label>
                                <div class="d-flex gap-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" 
                                               <?php echo e(old('gender') == 'male' ? 'checked' : ''); ?> required>
                                        <label class="form-check-label" for="male">
                                            <i class="fas fa-mars me-1"></i>Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" 
                                               <?php echo e(old('gender') == 'female' ? 'checked' : ''); ?> required>
                                        <label class="form-check-label" for="female">
                                            <i class="fas fa-venus me-1"></i>Perempuan
                                        </label>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="religion" class="form-label">
                                    Agama <span class="required">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['religion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="religion" name="religion" required>
                                    <option value="">Pilih Agama</option>
                                    <?php $__currentLoopData = config('school.student.religions', ['Islam' => 'Islam', 'Kristen' => 'Kristen', 'Katolik' => 'Katolik', 'Hindu' => 'Hindu', 'Buddha' => 'Buddha', 'Konghucu' => 'Konghucu']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" <?php echo e(old('religion') == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['religion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status" class="form-label">
                                    Status <span class="required">*</span>
                                </label>
                                <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Aktif</option>
                                    <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Tidak Aktif</option>
                                    <option value="graduated" <?php echo e(old('status') == 'graduated' ? 'selected' : ''); ?>>Lulus</option>
                                </select>
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="address" name="address" rows="3" 
                                  placeholder="Masukkan alamat lengkap..."><?php echo e(old('address')); ?></textarea>
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Parent Information Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        Data Orang Tua/Wali
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_name" class="form-label">
                                    Nama Orang Tua/Wali <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['parent_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="parent_name" name="parent_name" value="<?php echo e(old('parent_name')); ?>" required>
                                <?php $__errorArgs = ['parent_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_phone" class="form-label">Telepon Orang Tua/Wali</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['parent_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="parent_phone" name="parent_phone" value="<?php echo e(old('parent_phone')); ?>">
                                <?php $__errorArgs = ['parent_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photo Upload Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        Foto Siswa
                    </h3>
                    
                    <div class="photo-upload-area" onclick="document.getElementById('photo').click()">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h5>Klik untuk upload foto atau drag & drop</h5>
                        <p class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                        <input type="file" class="d-none <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="photo" name="photo" accept="image/*">
                    </div>
                    
                    <div id="photoPreview" class="text-center" style="display: none;">
                        <img id="previewImage" src="" alt="Preview" class="photo-preview">
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removePhoto()">
                            <i class="fas fa-trash"></i> Hapus Foto
                        </button>
                    </div>
                    
                    <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback d-block">
                            <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- QR Code & User Account Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        QR Code Absensi & Akun Pengguna (Opsional)
                    </h3>
                    
                    <!-- QR Code Auto-Generate Option -->
                    <div class="checkbox-wrapper mb-3">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="auto_generate_qr" name="auto_generate_qr" value="1" checked>
                            <div class="checkmark"></div>
                        </div>
                        <label for="auto_generate_qr" class="form-label mb-0">
                            <i class="fas fa-qrcode text-primary me-2"></i>
                            Otomatis buat QR Code absensi untuk siswa ini
                        </label>
                    </div>
                    
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>
                            <strong>QR Code Absensi:</strong> Jika dicentang, sistem akan otomatis membuat QR Code untuk absensi siswa. 
                            QR Code dapat digunakan untuk scan absensi harian dan dapat di-download dari halaman manajemen QR.
                        </small>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- User Account Option -->
                    <div class="checkbox-wrapper">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="create_user_account" name="create_user_account" value="1">
                            <div class="checkmark"></div>
                        </div>
                        <label for="create_user_account" class="form-label mb-0">
                            <i class="fas fa-key text-warning me-2"></i>
                            Buat akun pengguna untuk siswa ini
                        </label>
                    </div>
                    
                    <div id="userAccountFields" style="display: none;">
                        <div class="user-account-card">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">
                                            Password <span class="required">*</span>
                                        </label>
                                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="password" name="password" minlength="8">
                                        <small class="text-muted">Minimal 8 karakter</small>
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">
                                            Konfirmasi Password <span class="required">*</span>
                                        </label>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" minlength="8">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>
                                    Jika akun pengguna dibuat, siswa dapat login menggunakan email dan password yang diberikan.
                                    Email harus diisi jika ingin membuat akun pengguna.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.students.index')); ?>" class="btn-custom btn-outline-custom" title="Kembali ke Daftar Siswa">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
                <button type="button" class="btn-custom btn-close-left" onclick="closeForm()" title="❌ Tutup Form (Esc)">
                    <i class="fas fa-times-circle"></i>Tutup
                </button>
            </div>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn-custom btn-secondary-custom" onclick="resetForm()" title="Reset Form">
                    <i class="fas fa-undo"></i>Reset
                </button>
                <button type="submit" form="studentForm" class="btn-custom btn-primary-custom" title="Simpan Data Siswa">
                    <i class="fas fa-save"></i>Simpan Data Siswa
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<!-- Floating Action Buttons - Desktop -->
<div class="floating-actions">
    <button type="submit" form="studentForm" class="floating-btn floating-btn-success" title="💾 Simpan Data Siswa (Ctrl+S)">
        <i class="fas fa-save floating-btn-icon"></i>
        <span class="floating-btn-text">Simpan</span>
    </button>
    <a href="<?php echo e(route('admin.students.index')); ?>" class="floating-btn floating-btn-primary" title="📋 Kembali ke Daftar Siswa">
        <i class="fas fa-list floating-btn-icon"></i>
        <span class="floating-btn-text">Daftar</span>
    </a>
    <button type="button" onclick="resetForm()" class="floating-btn floating-btn-secondary" title="🔄 Reset Form (Ctrl+R)">
        <i class="fas fa-undo floating-btn-icon"></i>
        <span class="floating-btn-text">Reset</span>
    </button>
    <button type="button" onclick="closeForm()" class="floating-btn floating-btn-danger" title="❌ Tutup Form (Esc)">
        <i class="fas fa-times floating-btn-icon"></i>
        <span class="floating-btn-text">Tutup</span>
    </button>
</div>

<!-- Floating Action Buttons - Mobile -->
<div class="floating-actions-mobile">
    <button type="button" onclick="closeForm()" class="floating-btn floating-btn-danger" title="Tutup Form">
        <i class="fas fa-times floating-btn-icon"></i>
        <span class="floating-btn-text">Tutup</span>
    </button>
    <button type="button" onclick="resetForm()" class="floating-btn floating-btn-secondary" title="Reset Form">
        <i class="fas fa-undo floating-btn-icon"></i>
        <span class="floating-btn-text">Reset</span>
    </button>
    <a href="<?php echo e(route('admin.students.index')); ?>" class="floating-btn floating-btn-primary" title="Daftar Siswa">
        <i class="fas fa-list floating-btn-icon"></i>
        <span class="floating-btn-text">Daftar</span>
    </a>
    <button type="submit" form="studentForm" class="floating-btn floating-btn-success" title="Simpan Data">
        <i class="fas fa-save floating-btn-icon"></i>
        <span class="floating-btn-text">Simpan</span>
    </button>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Photo upload handling
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('photoPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Remove photo
function removePhoto() {
    document.getElementById('photo').value = '';
    document.getElementById('photoPreview').style.display = 'none';
}

// Drag and drop functionality
const uploadArea = document.querySelector('.photo-upload-area');

uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('photo').files = files;
        document.getElementById('photo').dispatchEvent(new Event('change'));
    }
});

// User account toggle
document.getElementById('create_user_account').addEventListener('change', function() {
    const userAccountFields = document.getElementById('userAccountFields');
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_confirmation');
    
    if (this.checked) {
        userAccountFields.style.display = 'block';
        emailField.required = true;
        passwordField.required = true;
        passwordConfirmField.required = true;
        
        // Add visual indicator that email is required
        const emailLabel = document.querySelector('label[for="email"]');
        if (emailLabel && !emailLabel.querySelector('.required')) {
            emailLabel.innerHTML += ' <span class="required">*</span>';
        }
        
        // Show info message
        showNotification('Email wajib diisi untuk membuat akun pengguna!', 'info');
    } else {
        userAccountFields.style.display = 'none';
        emailField.required = false;
        passwordField.required = false;
        passwordConfirmField.required = false;
        passwordField.value = '';
        passwordConfirmField.value = '';
        
        // Remove required indicator from email
        const emailLabel = document.querySelector('label[for="email"]');
        const requiredSpan = emailLabel?.querySelector('.required');
        if (requiredSpan) {
            requiredSpan.remove();
        }
    }
});

// NIS Validation
let nisTimeout;
const nisInput = document.getElementById('nis');
const nisIcon = document.getElementById('nisValidationIcon');
const nisMessage = document.getElementById('nisValidationMessage');

nisInput.addEventListener('input', function() {
    clearTimeout(nisTimeout);
    const nis = this.value.trim();
    
    if (nis.length === 0) {
        hideValidation('nis');
        return;
    }
    
    // Show loading state
    showValidation('nis', 'loading', 'Memeriksa NIS...', '<i class="fas fa-spinner spinner"></i>');
    
    nisTimeout = setTimeout(() => {
        validateNis(nis);
    }, 500);
});

// NISN Validation
let nisnTimeout;
const nisnInput = document.getElementById('nisn');
const nisnIcon = document.getElementById('nisnValidationIcon');
const nisnMessage = document.getElementById('nisnValidationMessage');

nisnInput.addEventListener('input', function() {
    clearTimeout(nisnTimeout);
    const nisn = this.value.trim();
    
    if (nisn.length === 0) {
        hideValidation('nisn');
        return;
    }
    
    // Show loading state
    showValidation('nisn', 'loading', 'Memeriksa NISN...', '<i class="fas fa-spinner spinner"></i>');
    
    nisnTimeout = setTimeout(() => {
        validateNisn(nisn);
    }, 500);
});

// Generate NIS button
document.getElementById('generateNisBtn').addEventListener('click', function() {
    const classSelect = document.getElementById('class');
    const selectedClass = classSelect.value;
    
    if (!selectedClass) {
        alert('Pilih kelas terlebih dahulu untuk generate NIS.');
        classSelect.focus();
        return;
    }
    
    // Show loading
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner spinner"></i>';
    
    fetch(`<?php echo e(route('admin.students.generate-nis')); ?>?class=${selectedClass}`)
        .then(response => response.json())
        .then(data => {
            if (data.suggested_nis) {
                nisInput.value = data.suggested_nis;
                validateNis(data.suggested_nis);
                showNotification('success', 'NIS berhasil di-generate!', data.pattern);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Gagal generate NIS', 'Silakan coba lagi.');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-magic"></i>';
        });
});

function validateNis(nis) {
    fetch(`<?php echo e(route('admin.students.check-nis')); ?>?nis=${nis}`)
        .then(response => response.json())
        .then(data => {
            if (data.available) {
                showValidation('nis', 'success', data.message, '<i class="fas fa-check-circle"></i>');
                nisInput.classList.remove('is-invalid');
                nisInput.classList.add('is-valid');
            } else {
                showValidation('nis', 'error', data.message, '<i class="fas fa-times-circle"></i>');
                nisInput.classList.remove('is-valid');
                nisInput.classList.add('is-invalid');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showValidation('nis', 'error', 'Gagal memeriksa NIS', '<i class="fas fa-exclamation-triangle"></i>');
        });
}

function validateNisn(nisn) {
    fetch(`<?php echo e(route('admin.students.check-nisn')); ?>?nisn=${nisn}`)
        .then(response => response.json())
        .then(data => {
            if (data.available) {
                showValidation('nisn', 'success', data.message, '<i class="fas fa-check-circle"></i>');
                nisnInput.classList.remove('is-invalid');
                nisnInput.classList.add('is-valid');
            } else {
                showValidation('nisn', 'error', data.message, '<i class="fas fa-times-circle"></i>');
                nisnInput.classList.remove('is-valid');
                nisnInput.classList.add('is-invalid');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showValidation('nisn', 'error', 'Gagal memeriksa NISN', '<i class="fas fa-exclamation-triangle"></i>');
        });
}

function showValidation(field, type, message, icon) {
    const iconElement = document.getElementById(field + 'ValidationIcon');
    const messageElement = document.getElementById(field + 'ValidationMessage');
    
    iconElement.innerHTML = icon;
    iconElement.className = `validation-icon ${type}`;
    iconElement.style.display = 'block';
    
    messageElement.innerHTML = `${icon} ${message}`;
    messageElement.className = `validation-message ${type}`;
    messageElement.style.display = 'block';
}

function hideValidation(field) {
    const iconElement = document.getElementById(field + 'ValidationIcon');
    const messageElement = document.getElementById(field + 'ValidationMessage');
    const inputElement = document.getElementById(field);
    
    iconElement.style.display = 'none';
    messageElement.style.display = 'none';
    inputElement.classList.remove('is-valid', 'is-invalid');
}

// Auto-generate NIS based on class and year
document.getElementById('class').addEventListener('change', function() {
    const nisField = document.getElementById('nis');
    if (!nisField.value && this.value) {
        // Auto-generate when class is selected and NIS is empty
        document.getElementById('generateNisBtn').click();
    }
});

// Form validation
document.getElementById('studentForm').addEventListener('submit', function(e) {
    const createUserAccount = document.getElementById('create_user_account').checked;
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirmation').value;
    
    if (createUserAccount) {
        if (!email) {
            e.preventDefault();
            showNotification('Email harus diisi jika ingin membuat akun pengguna!', 'error');
            document.getElementById('email').focus();
            document.getElementById('email').classList.add('is-invalid');
            return;
        }
        
        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            showNotification('Format email tidak valid!', 'error');
            document.getElementById('email').focus();
            document.getElementById('email').classList.add('is-invalid');
            return;
        }
        
        if (!password) {
            e.preventDefault();
            showNotification('Password harus diisi jika ingin membuat akun pengguna!', 'error');
            document.getElementById('password').focus();
            document.getElementById('password').classList.add('is-invalid');
            return;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            showNotification('Password minimal 8 karakter!', 'error');
            document.getElementById('password').focus();
            document.getElementById('password').classList.add('is-invalid');
            return;
        }
        
        if (password !== passwordConfirm) {
            e.preventDefault();
            showNotification('Konfirmasi password tidak sesuai!', 'error');
            document.getElementById('password_confirmation').focus();
            document.getElementById('password_confirmation').classList.add('is-invalid');
            return;
        }
    }
    
    // Show loading overlay
    document.getElementById('loadingOverlay').style.display = 'flex';
    
    // Show success message
    showNotification('Menyimpan data siswa...', 'info');
});

// Close form function
function closeForm() {
    const form = document.getElementById('studentForm');
    const hasData = checkFormHasData();
    
    // Add visual feedback
    const closeButtons = document.querySelectorAll('[onclick="closeForm()"]');
    closeButtons.forEach(btn => {
        btn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            btn.style.transform = '';
        }, 150);
    });
    
    if (hasData) {
        // Custom confirmation dialog with better styling
        const confirmClose = confirm(
            '⚠️ PERINGATAN!\n\n' +
            'Anda memiliki data yang belum disimpan.\n' +
            'Semua data yang telah diisi akan hilang.\n\n' +
            'Apakah Anda yakin ingin menutup form?'
        );
        
        if (confirmClose) {
            // Show closing animation
            showNotification('Menutup form...', 'info');
            
            // Clear auto-saved data
            clearAutoSavedData();
            
            // Redirect with slight delay for better UX
            setTimeout(() => {
                window.location.href = '<?php echo e(route('admin.students.index')); ?>';
            }, 500);
        } else {
            showNotification('Form tetap terbuka', 'info');
        }
    } else {
        // No data, close immediately
        showNotification('Menutup form...', 'success');
        clearAutoSavedData();
        
        setTimeout(() => {
            window.location.href = '<?php echo e(route('admin.students.index')); ?>';
        }, 300);
    }
}

// Check if form has data
function checkFormHasData() {
    const form = document.getElementById('studentForm');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    for (let input of inputs) {
        if (input.type === 'checkbox' || input.type === 'radio') {
            if (input.checked) return true;
        } else if (input.value.trim() !== '') {
            return true;
        }
    }
    return false;
}

// Reset form
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
        document.getElementById('studentForm').reset();
        document.getElementById('photoPreview').style.display = 'none';
        document.getElementById('userAccountFields').style.display = 'none';
        document.getElementById('create_user_account').checked = false;
        
        // Show success message
        showNotification('Form berhasil direset!', 'success');
    }
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    const alertClass = type === 'error' ? 'danger' : type;
    notification.className = `alert alert-${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px; max-width: 400px;';
    
    const iconClass = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-triangle' : 
                     type === 'warning' ? 'exclamation-circle' : 'info-circle';
    
    notification.innerHTML = `
        <i class="fas fa-${iconClass} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds for errors, 3 seconds for others
    const timeout = type === 'error' ? 5000 : 3000;
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, timeout);
}

// Real-time validation
document.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('blur', function() {
        if (this.hasAttribute('required') && !this.value.trim()) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    field.addEventListener('input', function() {
        if (this.classList.contains('is-invalid') && this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });
});

// Password confirmation validation
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const passwordConfirm = this.value;
    
    if (passwordConfirm && password !== passwordConfirm) {
        this.classList.add('is-invalid');
        showValidation('password_confirmation', 'error', 'Password tidak sesuai', '<i class="fas fa-times-circle"></i>');
    } else if (passwordConfirm && password === passwordConfirm) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
        hideValidation('password_confirmation');
    } else {
        this.classList.remove('is-invalid', 'is-valid');
        hideValidation('password_confirmation');
    }
});

// Password strength validation
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const passwordConfirm = document.getElementById('password_confirmation').value;
    
    if (password.length > 0 && password.length < 8) {
        this.classList.add('is-invalid');
    } else if (password.length >= 8) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-invalid', 'is-valid');
    }
    
    // Re-validate confirmation if it has value
    if (passwordConfirm) {
        document.getElementById('password_confirmation').dispatchEvent(new Event('input'));
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + S to save
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        document.getElementById('studentForm').dispatchEvent(new Event('submit'));
        return;
    }
    
    // Escape to close
    if (e.key === 'Escape') {
        e.preventDefault();
        closeForm();
        return;
    }
    
    // Ctrl + R to reset
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        resetForm();
        return;
    }
});

// Prevent accidental page leave
window.addEventListener('beforeunload', function(e) {
    if (checkFormHasData()) {
        e.preventDefault();
        e.returnValue = 'Anda memiliki data yang belum disimpan. Yakin ingin meninggalkan halaman?';
        return e.returnValue;
    }
});

// Auto-save to localStorage (optional)
function autoSaveForm() {
    const formData = new FormData(document.getElementById('studentForm'));
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    localStorage.setItem('studentFormDraft', JSON.stringify(data));
}

// Load auto-saved data
function loadAutoSavedData() {
    const savedData = localStorage.getItem('studentFormDraft');
    if (savedData) {
        const data = JSON.parse(savedData);
        
        if (Object.keys(data).length > 0) {
            if (confirm('Ditemukan data form yang tersimpan sebelumnya. Apakah Anda ingin memulihkannya?')) {
                for (let [key, value] of Object.entries(data)) {
                    const field = document.querySelector(`[name="${key}"]`);
                    if (field) {
                        if (field.type === 'checkbox' || field.type === 'radio') {
                            field.checked = value === 'on' || value === field.value;
                        } else {
                            field.value = value;
                        }
                    }
                }
                showNotification('Data form berhasil dipulihkan!', 'success');
            }
        }
    }
}

// Clear auto-saved data when form is submitted successfully
function clearAutoSavedData() {
    localStorage.removeItem('studentFormDraft');
}

// Initialize close button functionality
function initializeCloseButtons() {
    // Add click handlers to all close buttons
    const closeButtons = document.querySelectorAll('[onclick="closeForm()"]');
    closeButtons.forEach(button => {
        // Add visual feedback on click
        button.addEventListener('click', function(e) {
            // Add ripple effect
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
        
        // Add hover effect
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
}

// Add ripple animation CSS
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(rippleStyle);

// Smooth animations on load
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.form-section');
    
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(() => {
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Initialize close buttons
    initializeCloseButtons();
    
    // Load auto-saved data
    loadAutoSavedData();
    
    // Auto-save every 30 seconds
    setInterval(autoSaveForm, 30000);
    
    // Show keyboard shortcuts info with close button highlight
    showNotification('Tips: Gunakan Ctrl+S untuk simpan, Esc untuk tutup, Ctrl+R untuk reset. Tombol merah untuk tutup form!', 'info');
    
    // Highlight close buttons briefly
    setTimeout(() => {
        const closeButtons = document.querySelectorAll('[onclick="closeForm()"]');
        closeButtons.forEach(btn => {
            btn.style.animation = 'pulse 1s ease-in-out 2';
        });
    }, 2000);
});

// Add pulse animation
const pulseStyle = document.createElement('style');
pulseStyle.textContent = `
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
`;
document.head.appendChild(pulseStyle);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/students/create.blade.php ENDPATH**/ ?>