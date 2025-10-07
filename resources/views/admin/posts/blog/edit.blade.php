@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="container-fluid">
    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <div class="form-header-content">
                <div class="form-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h1 class="form-title">Edit Artikel</h1>
                    <p class="form-subtitle">Perbarui konten artikel "{{ Str::limit($blog->title, 50) }}"</p>
                </div>
            </div>
        </div>

        <form class="form-body" action="{{ route('admin.posts.blog.update', $blog->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Informasi Dasar -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h2>
                    <p class="section-subtitle">Perbarui informasi dasar artikel Anda</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-heading me-2"></i>Judul Artikel <span class="required">*</span></label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Masukkan judul yang menarik dan deskriptif" required value="{{ old('title', $blog->title) }}">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <p class="form-help">Gunakan judul yang jelas dan menarik perhatian pembaca</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-link me-2"></i>Slug URL</label>
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="url-friendly-slug" value="{{ old('slug', $blog->slug) }}">
                    @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <p class="form-help">URL ramah SEO (akan dibuat otomatis dari judul jika kosong)</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-tags me-2"></i>Kategori</label>
                        <select class="form-control" name="category">
                            <option value="berita" {{ old('category', $blog->category) == 'berita' ? 'selected' : '' }}>📰 Berita</option>
                            <option value="pengumuman" {{ old('category', $blog->category) == 'pengumuman' ? 'selected' : '' }}>📣 Pengumuman</option>
                            <option value="kegiatan" {{ old('category', $blog->category) == 'kegiatan' ? 'selected' : '' }}>🎯 Kegiatan</option>
                            <option value="prestasi" {{ old('category', $blog->category) == 'prestasi' ? 'selected' : '' }}>🏆 Prestasi</option>
                        </select>
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-eye me-2"></i>Status Publikasi</label>
                        <select class="form-control" name="status">
                            <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>✅ Published</option>
                            <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                            <option value="archived" {{ old('status', $blog->status) == 'archived' ? 'selected' : '' }}>📁 Archived</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-user-edit me-2"></i>Penulis</label>
                        <input type="text" class="form-control" name="author" placeholder="Nama penulis" value="{{ old('author', $blog->author) }}">
                        @error('author')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Konten Artikel -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-edit me-2"></i>Konten Artikel</h2>
                    <p class="section-subtitle">Perbarui konten artikel yang menarik dan informatif</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-file-alt me-2"></i>Isi Artikel <span class="required">*</span></label>
                    <div class="editor-container">
                        <textarea class="form-control" name="content" rows="10" placeholder="Tulis konten artikel di sini..." required>{{ old('content', $blog->content) }}</textarea>
                    </div>
                    @error('content')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <p class="form-help">Gunakan editor untuk memformat teks dengan baik</p>
                </div>
            </div>

            <!-- SEO & Meta -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-search me-2"></i>SEO & Meta Information</h2>
                    <p class="section-subtitle">Perbarui optimasi untuk mesin pencari dan social media</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-align-left me-2"></i>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="4" placeholder="Deskripsi singkat untuk mesin pencari (maksimal 160 karakter)">{{ old('meta_description', $blog->meta_description) }}</textarea>
                        @error('meta_description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <p class="form-help">Deskripsi ini akan muncul di hasil pencarian Google</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-hashtag me-2"></i>Keywords</label>
                        <input type="text" class="form-control" name="keywords" placeholder="keyword1, keyword2, keyword3" value="{{ old('keywords', $blog->keywords) }}">
                        @error('keywords')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <p class="form-help">Pisahkan kata kunci dengan koma</p>
                    </div>
                </div>
            </div>

            <!-- Gambar Unggulan -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-image me-2"></i>Gambar Unggulan</h2>
                    <p class="section-subtitle">Perbarui atau ganti gambar utama untuk artikel Anda</p>
                </div>

                @if($blog->featured_image)
                    <div class="current-image-section">
                        <label class="form-label">
                            <i class="fas fa-image me-2"></i>Gambar Saat Ini
                        </label>
                        <div class="current-image-container">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" class="current-image" alt="Current Image">
                            <div class="image-overlay-info">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-camera me-2"></i>{{ $blog->featured_image ? 'Ganti Gambar' : 'Pilih Gambar' }}</label>
                    <div class="upload-area">
                        <div class="upload-content">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <h3 class="upload-title">Klik atau drag & drop gambar di sini</h3>
                            <p class="upload-subtitle">PNG, JPG, JPEG hingga 2MB</p>
                            <input type="file" class="upload-input" name="image" accept="image/*">
                        </div>
                    </div>
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="image-preview">
                        <img src="#" alt="Preview" class="preview-image">
                        <button type="button" class="remove-image"><i class="fas fa-times"></i></button>
                    </div>
                    @if($blog->featured_image)
                        <p class="form-help">Biarkan kosong jika tidak ingin mengubah gambar</p>
                    @endif
                </div>
            </div>

            <!-- Article Info -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-info-circle me-2"></i>Informasi Artikel</h2>
                    <p class="section-subtitle">Detail dan statistik artikel</p>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">ID Artikel</div>
                        <div class="info-value">#{{ $blog->id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Slug</div>
                        <div class="info-value">{{ $blog->slug }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Dibuat</div>
                        <div class="info-value">{{ $blog->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Terakhir Diupdate</div>
                        <div class="info-value">{{ $blog->updated_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.posts.blog') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <div class="action-buttons">
                    <button type="submit" name="draft" value="1" class="btn btn-draft"><i class="fas fa-save me-2"></i>Simpan Draft</button>
                    <button type="submit" name="publish" value="1" class="btn btn-publish"><i class="fas fa-check-circle me-2"></i>Update Artikel</button>
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
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
        border-left: 4px solid #3b82f6;
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
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Current Image Section */
    .current-image-section {
        margin-bottom: 2rem;
    }

    .current-image-container {
        position: relative;
        display: inline-block;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px var(--shadow-color);
        border: 1px solid var(--border-color);
    }

    .current-image {
        max-width: 300px;
        height: auto;
        display: block;
    }

    .image-overlay-info {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 35px;
        height: 35px;
        background: rgba(0,0,0,0.7);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
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
        border-color: #3b82f6;
        background: var(--bg-tertiary);
    }

    .upload-icon {
        font-size: 3rem;
        color: #3b82f6;
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

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .info-item {
        padding: 15px;
        background: var(--bg-primary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .info-label {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 5px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .info-value {
        font-weight: 600;
        color: var(--text-primary);
        transition: color 0.3s ease;
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

    .dark .info-item {
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

        .info-grid {
            grid-template-columns: 1fr;
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

        // Auto-generate slug from title (only if slug is empty or auto-generated)
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
@endsection