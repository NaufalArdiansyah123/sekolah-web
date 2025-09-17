@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="container-fluid px-4" data-aos="fade-up">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb modern-breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.posts.blog') }}">
                    <i class="fas fa-newspaper me-1"></i>Blog Management
                </a>
            </li>
            <li class="breadcrumb-item active">Edit Artikel</li>
        </ol>
    </nav>
    
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="create-form-container">
                <div class="form-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="header-text">
                            <h2 class="header-title">Edit Artikel</h2>
                            <p class="header-subtitle">Perbarui konten artikel "{{ Str::limit($blog->title, 50) }}"</p>
                        </div>
                    </div>
                </div>
                
                <div class="form-body">
                    <form action="{{ route('admin.posts.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Form Section 1: Basic Info -->
                        <div class="form-section" data-aos="fade-up" data-aos-delay="100">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                </h5>
                                <p class="section-subtitle">Perbarui informasi dasar artikel Anda</p>
                            </div>
                            
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-heading me-2"></i>
                                    Judul Artikel <span class="required">*</span>
                                </label>
                                <input type="text" name="title" id="title" class="form-input-modern" 
                                       placeholder="Masukkan judul yang menarik dan deskriptif" 
                                       value="{{ old('title', $blog->title) }}" required>
                                <div class="input-helper">Gunakan judul yang jelas dan menarik perhatian pembaca</div>
                                <div class="invalid-feedback">Judul tidak boleh kosong.</div>
                            </div>

                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-link me-2"></i>Slug URL
                                </label>
                                <input type="text" name="slug" id="slug" class="form-input-modern" 
                                       placeholder="url-friendly-slug" value="{{ old('slug', $blog->slug) }}">
                                <div class="input-helper">URL ramah SEO (akan dibuat otomatis dari judul jika kosong)</div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-tags me-2"></i>Kategori
                                        </label>
                                        <select name="category" class="form-select-modern">
                                            <option value="berita" {{ old('category', $blog->category) == 'berita' ? 'selected' : '' }}>📰 Berita</option>
                                            <option value="pengumuman" {{ old('category', $blog->category) == 'pengumuman' ? 'selected' : '' }}>📢 Pengumuman</option>
                                            <option value="kegiatan" {{ old('category', $blog->category) == 'kegiatan' ? 'selected' : '' }}>🎯 Kegiatan</option>
                                            <option value="prestasi" {{ old('category', $blog->category) == 'prestasi' ? 'selected' : '' }}>🏆 Prestasi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-eye me-2"></i>Status Publikasi
                                        </label>
                                        <select name="status" class="form-select-modern">
                                            <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>✅ Published</option>
                                            <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                                            <option value="archived" {{ old('status', $blog->status) == 'archived' ? 'selected' : '' }}>📁 Archived</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-user-edit me-2"></i>Penulis
                                        </label>
                                        <input type="text" name="author" class="form-input-modern" 
                                               placeholder="Nama penulis" value="{{ old('author', $blog->author) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Section 2: Content -->
                        <div class="form-section" data-aos="fade-up" data-aos-delay="200">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-edit me-2"></i>Konten Artikel
                                </h5>
                                <p class="section-subtitle">Perbarui konten artikel yang menarik dan informatif</p>
                            </div>
                            
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-file-alt me-2"></i>
                                    Isi Artikel <span class="required">*</span>
                                </label>
                                <div class="editor-container">
                                    <textarea name="content" id="editor" class="form-textarea-modern" 
                                              placeholder="Tulis konten artikel di sini..." required>{{ old('content', $blog->content) }}</textarea>
                                </div>
                                <div class="input-helper">Gunakan editor untuk memformat teks dengan baik</div>
                            </div>
                        </div>

                        <!-- Form Section 3: SEO & Meta -->
                        <div class="form-section" data-aos="fade-up" data-aos-delay="300">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-search me-2"></i>SEO & Meta Information
                                </h5>
                                <p class="section-subtitle">Perbarui optimasi untuk mesin pencari dan social media</p>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-align-left me-2"></i>Meta Description
                                        </label>
                                        <textarea name="meta_description" class="form-textarea-modern" rows="4" 
                                                  placeholder="Deskripsi singkat untuk mesin pencari (maksimal 160 karakter)">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                        <div class="input-helper">Deskripsi ini akan muncul di hasil pencarian Google</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fas fa-hashtag me-2"></i>Keywords
                                        </label>
                                        <input type="text" name="keywords" class="form-input-modern" 
                                               placeholder="keyword1, keyword2, keyword3" value="{{ old('keywords', $blog->keywords) }}">
                                        <div class="input-helper">Pisahkan kata kunci dengan koma</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Section 4: Media -->
                        <div class="form-section" data-aos="fade-up" data-aos-delay="400">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-image me-2"></i>Gambar Unggulan
                                </h5>
                                <p class="section-subtitle">Perbarui atau ganti gambar utama untuk artikel Anda</p>
                            </div>
                            
                            @if($blog->featured_image)
                                <div class="current-image-section">
                                    <label class="form-label-modern">
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
                            
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-camera me-2"></i>{{ $blog->featured_image ? 'Ganti Gambar' : 'Pilih Gambar' }}
                                </label>
                                <div class="upload-area" id="uploadArea">
                                    <div class="upload-content">
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <h6 class="upload-title">Klik atau drag & drop gambar di sini</h6>
                                        <p class="upload-subtitle">PNG, JPG, JPEG hingga 2MB</p>
                                        <input type="file" name="image" id="imageInput" class="upload-input" accept="image/*">
                                    </div>
                                </div>
                                <div class="image-preview" id="imagePreview" style="display: none;">
                                    <img id="previewImage" src="#" alt="Preview" class="preview-img">
                                    <button type="button" class="remove-image" id="removeImage">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @if($blog->featured_image)
                                    <div class="input-helper">Biarkan kosong jika tidak ingin mengubah gambar</div>
                                @endif
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions" data-aos="fade-up" data-aos-delay="500">
                            <div class="actions-container">
                                <a href="{{ route('admin.posts.blog') }}" class="btn-modern-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <div class="primary-actions">
                                    <button type="button" class="btn-modern-draft" onclick="saveDraft()">
                                        <i class="fas fa-save me-2"></i>Simpan Draft
                                    </button>
                                    <button type="submit" class="btn-modern-primary">
                                        <i class="fas fa-check-circle me-2"></i>Update Artikel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Current Image Section */
.current-image-section {
    margin-bottom: 2rem;
}

.current-image-container {
    position: relative;
    display: inline-block;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--card-shadow);
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

/* Modern Breadcrumb */
.modern-breadcrumb {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    margin-bottom: 2rem;
}

.modern-breadcrumb .breadcrumb-item a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.modern-breadcrumb .breadcrumb-item.active {
    color: #6c757d;
    font-weight: 600;
}

/* Create Form Container */
.create-form-container {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    overflow: hidden;
}

/* Form Header */
.form-header {
    background: var(--primary-gradient);
    color: white;
    padding: 2rem;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.header-title {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
}

.header-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

/* Form Body */
.form-body {
    padding: 2rem;
}

/* Form Sections */
.form-section {
    margin-bottom: 3rem;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: var(--border-radius);
    border-left: 4px solid #667eea;
}

.section-header {
    margin-bottom: 2rem;
}

.section-title {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.section-subtitle {
    color: #6c757d;
    margin: 0;
}

/* Modern Form Elements */
.form-group-modern {
    margin-bottom: 2rem;
}

.form-label-modern {
    display: block;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.8rem;
    font-size: 1rem;
}

.required {
    color: #e53e3e;
}

.form-input-modern, .form-select-modern, .form-textarea-modern {
    width: 100%;
    padding: 1rem 1.2rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-input-modern:focus, .form-select-modern:focus, .form-textarea-modern:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.form-textarea-modern {
    resize: vertical;
    min-height: 120px;
}

.input-helper {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* Editor Container */
.editor-container {
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.editor-container:focus-within {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Upload Area */
.upload-area {
    border: 2px dashed #cbd5e0;
    border-radius: 12px;
    padding: 3rem 2rem;
    text-align: center;
    background: #f7fafc;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.upload-area:hover {
    border-color: #667eea;
    background: #edf2f7;
}

.upload-area.dragover {
    border-color: #667eea;
    background: #e6fffa;
    transform: scale(1.02);
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

.upload-icon {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.upload-title {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.upload-subtitle {
    color: #6c757d;
    margin: 0;
}

/* Image Preview */
.image-preview {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    max-width: 400px;
    margin: 0 auto;
}

.preview-img {
    width: 100%;
    height: auto;
    display: block;
}

.remove-image {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 35px;
    height: 35px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.remove-image:hover {
    background: #dc3545;
    transform: scale(1.1);
}

/* Form Actions */
.form-actions {
    margin-top: 3rem;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: var(--border-radius);
}

.actions-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.primary-actions {
    display: flex;
    gap: 1rem;
}

.btn-modern-secondary {
    padding: 12px 24px;
    background: #6c757d;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-modern-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
    color: white;
}

.btn-modern-draft {
    padding: 12px 24px;
    background: var(--dark-gradient);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-modern-draft:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(44, 62, 80, 0.4);
}

.btn-modern-primary {
    padding: 12px 30px;
    background: var(--primary-gradient);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .form-body {
        padding: 1rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .actions-container {
        flex-direction: column;
    }
    
    .primary-actions {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'link', 'blockQuote', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'insertTable', 'imageUpload', '|',
                    'undo', 'redo'
                ]
            },
            placeholder: 'Mulai menulis artikel Anda di sini...',
            image: {
                toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']
            }
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // Modern Upload Area
    const uploadArea = document.getElementById('uploadArea');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const removeImage = document.getElementById('removeImage');

    // Upload area interactions
    uploadArea.addEventListener('click', () => imageInput.click());
    
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            handleImagePreview(files[0]);
        }
    });

    // Image preview
    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            handleImagePreview(file);
        }
    });

    function handleImagePreview(file) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                uploadArea.style.display = 'none';
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    // Remove image
    removeImage.addEventListener('click', function() {
        imageInput.value = '';
        uploadArea.style.display = 'block';
        imagePreview.style.display = 'none';
        previewImage.src = '#';
    });

    // Save as draft function
    function saveDraft() {
        const statusSelect = document.querySelector('select[name="status"]');
        statusSelect.value = 'draft';
        document.querySelector('form').submit();
    }

    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Auto-save functionality (optional)
    let autoSaveTimer;
    function autoSave() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            // Auto-save logic here
            console.log('Auto-saving...');
        }, 30000); // Save every 30 seconds
    }

    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

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

    // Trigger auto-save on content change
    document.addEventListener('input', autoSave);
</script>
@endpush