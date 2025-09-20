<?php $__env->startSection('title', 'Tambah Blog Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <div class="form-header-content">
                <div class="form-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h1 class="form-title">Buat Artikel Baru</h1>
                    <p class="form-subtitle">Tulis dan publikasikan artikel yang menarik untuk pembaca</p>
                </div>
            </div>
        </div>

        <form class="form-body" action="<?php echo e(route('admin.posts.blog.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <!-- Informasi Dasar -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h2>
                    <p class="section-subtitle">Masukkan informasi dasar artikel Anda</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-heading me-2"></i>Judul Artikel <span class="required">*</span></label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Masukkan judul yang menarik dan deskriptif" required value="<?php echo e(old('title')); ?>">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="form-help">Gunakan judul yang jelas dan menarik perhatian pembaca</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-link me-2"></i>Slug URL</label>
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="url-friendly-slug" value="<?php echo e(old('slug')); ?>">
                    <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="form-help">URL ramah SEO (akan dibuat otomatis dari judul jika kosong)</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-tags me-2"></i>Kategori</label>
                        <select class="form-control" name="category">
                            <option value="berita" <?php echo e(old('category') == 'berita' ? 'selected' : ''); ?>>📰 Berita</option>
                            <option value="pengumuman" <?php echo e(old('category') == 'pengumuman' ? 'selected' : ''); ?>>📣 Pengumuman</option>
                            <option value="kegiatan" <?php echo e(old('category') == 'kegiatan' ? 'selected' : ''); ?>>🎯 Kegiatan</option>
                            <option value="prestasi" <?php echo e(old('category') == 'prestasi' ? 'selected' : ''); ?>>🏆 Prestasi</option>
                        </select>
                        <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-eye me-2"></i>Status Publikasi</label>
                        <select class="form-control" name="status">
                            <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>✅ Published</option>
                            <option value="draft" <?php echo e(old('status') == 'draft' ? 'selected' : ''); ?>>📝 Draft</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-user-edit me-2"></i>Penulis</label>
                        <input type="text" class="form-control" name="author" placeholder="Nama penulis" value="<?php echo e(old('author', Auth::user()->name)); ?>">
                        <?php $__errorArgs = ['author'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Konten Artikel -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-edit me-2"></i>Konten Artikel</h2>
                    <p class="section-subtitle">Tulis konten artikel yang menarik dan informatif</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-file-alt me-2"></i>Isi Artikel <span class="required">*</span></label>
                    <div class="editor-container">
                        <textarea class="form-control" name="content" rows="10" placeholder="Tulis konten artikel di sini..." required><?php echo e(old('content')); ?></textarea>
                    </div>
                    <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="form-help">Gunakan editor untuk memformat teks dengan baik</p>
                </div>
            </div>

            <!-- SEO & Meta -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-search me-2"></i>SEO & Meta Information</h2>
                    <p class="section-subtitle">Optimasi untuk mesin pencari dan social media</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-align-left me-2"></i>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="4" placeholder="Deskripsi singkat untuk mesin pencari (maksimal 160 karakter)"><?php echo e(old('meta_description')); ?></textarea>
                        <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="form-help">Deskripsi ini akan muncul di hasil pencarian Google</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-hashtag me-2"></i>Keywords</label>
                        <input type="text" class="form-control" name="keywords" placeholder="keyword1, keyword2, keyword3" value="<?php echo e(old('keywords')); ?>">
                        <?php $__errorArgs = ['keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="form-help">Pisahkan kata kunci dengan koma</p>
                    </div>
                </div>
            </div>

            <!-- Gambar Unggulan -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-image me-2"></i>Gambar Unggulan</h2>
                    <p class="section-subtitle">Upload gambar utama untuk artikel Anda</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-camera me-2"></i>Pilih Gambar</label>
                    <div class="upload-area">
                        <div class="upload-content">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <h3 class="upload-title">Klik atau drag & drop gambar di sini</h3>
                            <p class="upload-subtitle">PNG, JPG, JPEG hingga 2MB</p>
                            <input type="file" class="upload-input" name="image" accept="image/*">
                        </div>
                    </div>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="image-preview">
                        <img src="#" alt="Preview" class="preview-image">
                        <button type="button" class="remove-image"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="<?php echo e(route('admin.posts.blog')); ?>" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <div class="action-buttons">
                    <button type="submit" name="draft" value="1" class="btn btn-draft"><i class="fas fa-save me-2"></i>Simpan Draft</button>
                    <button type="submit" name="publish" value="1" class="btn btn-publish"><i class="fas fa-paper-plane me-2"></i>Publikasikan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Dark Mode Compatible Styles */
    .btn {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    /* Form Styles */
    .form-container {
        background: var(--bg-primary);
        border-radius: 12px;
        box-shadow: 0 10px 30px var(--shadow-color);
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .form-header {
        background: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);
        color: white;
        padding: 25px 30px;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .form-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .form-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .form-subtitle {
        opacity: 0.9;
    }

    .form-body {
        padding: 30px;
        background: var(--bg-primary);
        transition: all 0.3s ease;
    }

    .form-section {
        margin-bottom: 40px;
        padding: 25px;
        background: var(--bg-secondary);
        border-radius: 12px;
        border-left: 4px solid #4361ee;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .section-header {
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 10px;
        transition: color 0.3s ease;
    }

    .section-subtitle {
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s ease;
    }

    .required {
        color: #ef476f;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .form-control:focus {
        outline: none;
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .form-control::placeholder {
        color: var(--text-tertiary);
    }

    .form-help {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-top: 8px;
        transition: color 0.3s ease;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .editor-container {
        border: 2px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: var(--bg-primary);
    }

    .editor-container:focus-within {
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    /* Upload Area */
    .upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 10px;
        padding: 40px 20px;
        text-align: center;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .upload-area:hover {
        border-color: #4361ee;
        background: var(--bg-tertiary);
    }

    .upload-icon {
        font-size: 3rem;
        color: #4361ee;
        margin-bottom: 15px;
    }

    .upload-title {
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--text-primary);
        transition: color 0.3s ease;
    }

    .upload-subtitle {
        color: var(--text-secondary);
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }

    .upload-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .image-preview {
        position: relative;
        max-width: 400px;
        margin-top: 20px;
        display: none;
    }

    .preview-image {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 10px 30px var(--shadow-color);
    }

    .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 36px;
        height: 36px;
        background: #ef476f;
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-image:hover {
        transform: scale(1.1);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 25px 30px;
        background: var(--bg-secondary);
        border-top: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .btn-back {
        background: var(--text-secondary);
        color: white;
    }

    .btn-back:hover {
        background: var(--text-primary);
        color: white;
        text-decoration: none;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
    }

    .btn-draft {
        background: #6c757d;
        color: white;
    }

    .btn-draft:hover {
        background: #5a6268;
        color: white;
    }

    .btn-publish {
        background: #06d6a0;
        color: white;
    }

    .btn-publish:hover {
        background: #05c28f;
        color: white;
    }

    .text-danger {
        color: #ef476f;
        font-size: 0.85rem;
        margin-top: 5px;
    }

    /* Dark mode specific adjustments */
    .dark .form-section {
        background: var(--bg-tertiary);
    }

    .dark .upload-area {
        background: var(--bg-primary);
    }

    .dark .upload-area:hover {
        background: var(--bg-secondary);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .form-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 15px;
        }
        
        .action-buttons {
            width: 100%;
            justify-content: center;
        }

        .form-body {
            padding: 20px;
        }

        .form-section {
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    // Image upload preview
    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.querySelector('.upload-input');
        const imagePreview = document.querySelector('.image-preview');
        const previewImage = document.querySelector('.preview-image');
        const removeImageBtn = document.querySelector('.remove-image');
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        // Auto-generate slug from title
        if (titleInput && slugInput) {
            titleInput.addEventListener('input', function() {
                if (!slugInput.value || slugInput.dataset.autoGenerated !== 'false') {
                    const slug = generateSlug(this.value);
                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                }
            });

            slugInput.addEventListener('input', function() {
                this.dataset.autoGenerated = 'false';
            });
        }

        function generateSlug(text) {
            return text
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                .trim('-'); // Remove leading/trailing hyphens
        }

        if (uploadInput && imagePreview && previewImage && removeImageBtn) {
            uploadInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            removeImageBtn.addEventListener('click', function() {
                uploadInput.value = '';
                imagePreview.style.display = 'none';
                previewImage.src = '#';
            });
        }

        // Listen for theme changes
        window.addEventListener('theme-changed', function(e) {
            // Update any theme-specific elements if needed
            console.log('Theme changed to:', e.detail.darkMode ? 'dark' : 'light');
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/posts/blog/create.blade.php ENDPATH**/ ?>