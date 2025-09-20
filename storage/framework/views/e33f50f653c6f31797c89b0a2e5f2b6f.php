<?php $__env->startSection('content'); ?>
<style>
    /* Enhanced Upload Form Styles */
    .upload-container {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .dark .upload-container {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    /* Checkbox Styles */
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .checkbox-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--border-color);
        border-radius: 4px;
        background: var(--bg-primary);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .checkbox-input:checked {
        background: var(--accent-color);
        border-color: var(--accent-color);
    }
    
    .checkbox-label {
        color: var(--text-primary);
        font-weight: 500;
        cursor: pointer;
    }
    
    /* Button Styles */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .btn-primary {
        background: var(--accent-color);
        color: white;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }
    
    .btn-secondary:hover {
        background: var(--bg-secondary);
        transform: translateY(-1px);
    }
    
    /* Current Video Info */
    .current-video-info {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .video-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-weight: 600;
        color: var(--text-primary);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .upload-container {
            padding: 1.5rem;
        }
        
        .video-info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Video</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Edit informasi video dokumentasi</p>
        </div>
        <a href="<?php echo e(route('admin.videos.index')); ?>" 
           class="btn btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Current Video Info -->
    <div class="current-video-info">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            Informasi Video Saat Ini
        </h3>
        
        <div class="video-info-grid">
            <div class="info-item">
                <span class="info-label">Nama File</span>
                <span class="info-value"><?php echo e($video->original_name); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Ukuran File</span>
                <span class="info-value"><?php echo e($video->formatted_file_size); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Format</span>
                <span class="info-value"><?php echo e(strtoupper(pathinfo($video->filename, PATHINFO_EXTENSION))); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Views</span>
                <span class="info-value"><?php echo e(number_format($video->views)); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Downloads</span>
                <span class="info-value"><?php echo e(number_format($video->downloads)); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Diupload</span>
                <span class="info-value"><?php echo e($video->created_at->format('d M Y H:i')); ?></span>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="upload-container">
        <form method="POST" action="<?php echo e(route('admin.videos.update', $video)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- Video Title -->
            <div class="form-group">
                <label for="title" class="form-label">Judul Video *</label>
                <input type="text" 
                       name="title" 
                       id="title"
                       class="form-input"
                       value="<?php echo e(old('title', $video->title)); ?>"
                       placeholder="Masukkan judul video"
                       required>
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" 
                          id="description"
                          class="form-input form-textarea"
                          placeholder="Masukkan deskripsi video (opsional)"><?php echo e(old('description', $video->description)); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Category and Status Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div class="form-group">
                    <label for="category" class="form-label">Kategori *</label>
                    <select name="category" 
                            id="category"
                            class="form-input form-select"
                            required>
                        <option value="">Pilih Kategori</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php echo e(old('category', $video->category) == $key ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select name="status" 
                            id="status"
                            class="form-input form-select"
                            required>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php echo e(old('status', $video->status) == $key ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Thumbnail Upload -->
            <div class="form-group">
                <label for="thumbnail" class="form-label">Update Thumbnail (Opsional)</label>
                <input type="file" 
                       name="thumbnail" 
                       id="thumbnail"
                       class="form-input"
                       accept="image/*">
                <p class="text-sm text-gray-500 mt-1">Upload gambar thumbnail baru untuk video (JPEG, PNG, JPG, GIF - Max: 2MB)</p>
                <?php if($video->thumbnail_url): ?>
                    <div class="mt-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Thumbnail saat ini:</p>
                        <img src="<?php echo e($video->thumbnail_url); ?>" alt="Current thumbnail" class="w-32 h-20 object-cover rounded-lg mt-1">
                    </div>
                <?php endif; ?>
                <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Featured Checkbox -->
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" 
                           name="is_featured" 
                           id="is_featured"
                           class="checkbox-input"
                           value="1"
                           <?php echo e(old('is_featured', $video->is_featured) ? 'checked' : ''); ?>>
                    <label for="is_featured" class="checkbox-label">
                        Tampilkan sebagai video unggulan
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">Video unggulan akan ditampilkan di halaman utama</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" 
                        class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Video
                </button>
                
                <a href="<?php echo e(route('admin.videos.index')); ?>" 
                   class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/videos/edit.blade.php ENDPATH**/ ?>