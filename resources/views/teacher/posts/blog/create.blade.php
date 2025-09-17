@extends('layouts.teacher')

@section('title', 'Tambah Blog Baru')

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
                    <h1 class="form-title">Buat Artikel Baru</h1>
                    <p class="form-subtitle">Tulis dan publikasikan artikel yang menarik untuk pembaca</p>
                </div>
            </div>
        </div>

        <form class="form-body" action="{{ route('teacher.posts.blog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Informasi Dasar -->
            <div class="form-section">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h2>
                    <p class="section-subtitle">Masukkan informasi dasar artikel Anda</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-heading me-2"></i>Judul Artikel <span class="required">*</span></label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Masukkan judul yang menarik dan deskriptif" required value="{{ old('title') }}">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <p class="form-help">Gunakan judul yang jelas dan menarik perhatian pembaca</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-link me-2"></i>Slug URL</label>
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="url-friendly-slug" value="{{ old('slug') }}">
                    @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <p class="form-help">URL ramah SEO (akan dibuat otomatis dari judul jika kosong)</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-tags me-2"></i>Kategori</label>
                        <select class="form-control" name="category">
                            <option value="berita" {{ old('category') == 'berita' ? 'selected' : '' }}>📰 Berita</option>
                            <option value="pengumuman" {{ old('category') == 'pengumuman' ? 'selected' : '' }}>📣 Pengumuman</option>
                            <option value="kegiatan" {{ old('category') == 'kegiatan' ? 'selected' : '' }}>🎯 Kegiatan</option>
                            <option value="prestasi" {{ old('category') == 'prestasi' ? 'selected' : '' }}>🏆 Prestasi</option>
                        </select>
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-eye me-2"></i>Status Publikasi</label>
                        <select class="form-control" name="status">
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>✅ Published</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-user-edit me-2"></i>Penulis</label>
                        <input type="text" class="form-control" name="author" placeholder="Nama penulis" value="{{ old('author', Auth::user()->name) }}">
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
                    <p class="section-subtitle">Tulis konten artikel yang menarik dan informatif</p>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-file-alt me-2"></i>Isi Artikel <span class="required">*</span></label>
                    <div class="editor-container">
                        <textarea class="form-control" name="content" rows="10" placeholder="Tulis konten artikel di sini..." required>{{ old('content') }}</textarea>
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
                    <p class="section-subtitle">Optimasi untuk mesin pencari dan social media</p>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-align-left me-2"></i>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="4" placeholder="Deskripsi singkat untuk mesin pencari (maksimal 160 karakter)">{{ old('meta_description') }}</textarea>
                        @error('meta_description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <p class="form-help">Deskripsi ini akan muncul di hasil pencarian Google</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-hashtag me-2"></i>Keywords</label>
                        <input type="text" class="form-control" name="keywords" placeholder="keyword1, keyword2, keyword3" value="{{ old('keywords') }}">
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
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="image-preview">
                        <img src="#" alt="Preview" class="preview-image">
                        <button type="button" class="remove-image"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
              
                <div class="action-buttons">
                    <button type="submit" name="draft" value="1" class="btn btn-draft"><i class="fas fa-save me-2"></i>Simpan Draft</button>
                    <button type="submit" name="publish" value="1" class="btn btn-publish"><i class="fas fa-paper-plane me-2"></i>Publikasikan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --primary: #059669;
        --primary-dark: #047857;
        --secondary: #10b981;
        --success: #06d6a0;
        --danger: #ef476f;
        --warning: #ffd166;
        --info: #118ab2;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --light-gray: #e9ecef;
        --border-radius: 12px;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    /* Form Styles */
    .form-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
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
    }

    .form-section {
        margin-bottom: 40px;
        padding: 25px;
        background: #f8f9fa;
        border-radius: var(--border-radius);
        border-left: 4px solid var(--primary);
    }

    .section-header {
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-subtitle {
        color: var(--gray);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .required {
        color: var(--danger);
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid var(--light-gray);
        border-radius: 10px;
        font-size: 1rem;
        transition: var(--transition);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }

    .form-help {
        font-size: 0.85rem;
        color: var(--gray);
        margin-top: 8px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .editor-container {
        border: 2px solid var(--light-gray);
        border-radius: 10px;
        overflow: hidden;
        transition: var(--transition);
    }

    .editor-container:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }

    /* Upload Area */
    .upload-area {
        border: 2px dashed var(--light-gray);
        border-radius: 10px;
        padding: 40px 20px;
        text-align: center;
        background: #fafbfc;
        transition: var(--transition);
        cursor: pointer;
        position: relative;
    }

    .upload-area:hover {
        border-color: var(--primary);
        background: #f0fdf4;
    }

    .upload-icon {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .upload-title {
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--dark);
    }

    .upload-subtitle {
        color: var(--gray);
        margin-bottom: 15px;
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
        box-shadow: var(--shadow);
    }

    .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 36px;
        height: 36px;
        background: var(--danger);
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
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
        background: #f8f9fa;
        border-top: 1px solid var(--light-gray);
    }

    .btn-back {
        background: var(--gray);
        color: white;
    }

    .btn-back:hover {
        background: #5a6268;
        color: white;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
    }

    .btn-draft {
        background: var(--dark);
        color: white;
    }

    .btn-draft:hover {
        background: #343a40;
        color: white;
    }

    .btn-publish {
        background: var(--success);
        color: white;
    }

    .btn-publish:hover {
        background: #05c28f;
        color: white;
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
    }

    @media (max-width: 576px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .text-danger {
        color: var(--danger);
        font-size: 0.85rem;
        margin-top: 5px;
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
    });
</script>
@endsection