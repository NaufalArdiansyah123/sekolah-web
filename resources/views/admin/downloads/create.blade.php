@extends('layouts.admin')

@section('title', 'Upload File Download')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="header-title">
                <i class="fas fa-cloud-upload-alt me-3"></i>Upload File Download
            </h1>
            <p class="header-subtitle">Upload file baru untuk dibagikan kepada pengunjung website</p>
            <a href="{{ route('admin.downloads.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="form-container">
        <form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf
            
            <!-- File Upload Section -->
            <div class="upload-section">
                <h2 class="section-title">
                    <i class="fas fa-file-upload me-2"></i>File Upload
                </h2>
                
                <div class="file-upload-area" id="fileUploadArea">
                    <div class="upload-placeholder" id="uploadPlaceholder">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <h3>Drag & Drop file di sini</h3>
                        <p>atau <span class="upload-link">klik untuk memilih file</span></p>
                        <p class="upload-info">Maksimal 10MB • PDF, DOC, XLS, PPT, JPG, PNG, MP4, ZIP</p>
                    </div>
                    
                    <input type="file" name="file" id="fileInput" class="file-input" required>
                    
                    <div class="file-preview" id="filePreview" style="display: none;">
                        <div class="preview-content">
                            <div class="file-icon" id="previewIcon">
                                <i class="fas fa-file"></i>
                            </div>
                            <div class="file-details">
                                <h4 id="fileName">Nama File</h4>
                                <p id="fileSize">Ukuran File</p>
                                <div class="upload-progress">
                                    <div class="progress-bar" id="progressBar"></div>
                                </div>
                            </div>
                            <button type="button" class="remove-file" id="removeFile">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                @error('file')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Form Fields -->
            <div class="form-grid">
                <!-- Basic Information -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                    </h2>
                    
                    <div class="form-group">
                        <label for="title" class="form-label">Judul File *</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-input @error('title') error @enderror" 
                               value="{{ old('title') }}" 
                               placeholder="Masukkan judul file yang deskriptif"
                               required>
                        @error('title')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-textarea @error('description') error @enderror" 
                                  rows="4" 
                                  placeholder="Berikan deskripsi singkat tentang file ini...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Category & Settings -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-cog me-2"></i>Kategori & Pengaturan
                    </h2>
                    
                    <div class="form-group">
                        <label for="category" class="form-label">Kategori *</label>
                        <select name="category" 
                                id="category" 
                                class="form-select @error('category') error @enderror" 
                                required>
                            <option value="">Pilih Kategori</option>
                            <option value="materi" {{ old('category') == 'materi' ? 'selected' : '' }}>
                                📚 Materi Pembelajaran
                            </option>
                            <option value="foto" {{ old('category') == 'foto' ? 'selected' : '' }}>
                                📸 Foto & Galeri
                            </option>
                            <option value="video" {{ old('category') == 'video' ? 'selected' : '' }}>
                                🎥 Video
                            </option>
                            <option value="dokumen" {{ old('category') == 'dokumen' ? 'selected' : '' }}>
                                📄 Dokumen
                            </option>
                            <option value="formulir" {{ old('category') == 'formulir' ? 'selected' : '' }}>
                                📋 Formulir
                            </option>
                            <option value="panduan" {{ old('category') == 'panduan' ? 'selected' : '' }}>
                                📖 Panduan
                            </option>
                        </select>
                        @error('category')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status Publikasi *</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" 
                                       name="status" 
                                       value="active" 
                                       {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                                <span class="radio-custom"></span>
                                <div class="radio-content">
                                    <strong>Aktif</strong>
                                    <p>File dapat didownload oleh pengunjung</p>
                                </div>
                            </label>
                            <label class="radio-option">
                                <input type="radio" 
                                       name="status" 
                                       value="inactive" 
                                       {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                <span class="radio-custom"></span>
                                <div class="radio-content">
                                    <strong>Tidak Aktif</strong>
                                    <p>File disimpan sebagai draft</p>
                                </div>
                            </label>
                        </div>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Upload File
                </button>
                <a href="{{ route('admin.downloads.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #6b7280;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --light: #f8fafc;
        --dark: #1f2937;
        --gray: #6b7280;
        --light-gray: #e5e7eb;
        --border-radius: 12px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, #7c3aed 100%);
        color: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-subtitle {
        font-size: 1.125rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    /* Form Container */
    .form-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .upload-form {
        padding: 2rem;
    }

    /* File Upload Section */
    .upload-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--dark);
        display: flex;
        align-items: center;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-gray);
    }

    .file-upload-area {
        position: relative;
        border: 2px dashed var(--light-gray);
        border-radius: var(--border-radius);
        padding: 2rem;
        text-align: center;
        transition: var(--transition);
        background: var(--light);
    }

    .file-upload-area:hover,
    .file-upload-area.dragover {
        border-color: var(--primary);
        background: rgba(79, 70, 229, 0.05);
    }

    .upload-icon {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .upload-placeholder h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .upload-placeholder p {
        color: var(--gray);
        margin-bottom: 0.5rem;
    }

    .upload-link {
        color: var(--primary);
        font-weight: 600;
        cursor: pointer;
    }

    .upload-info {
        font-size: 0.875rem;
        color: var(--gray);
    }

    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    /* File Preview */
    .file-preview {
        background: white;
        border: 2px solid var(--success);
        border-radius: var(--border-radius);
        padding: 1.5rem;
    }

    .preview-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .file-details {
        flex-grow: 1;
    }

    .file-details h4 {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--dark);
    }

    .file-details p {
        color: var(--gray);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .upload-progress {
        width: 100%;
        height: 4px;
        background: var(--light-gray);
        border-radius: 2px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: var(--success);
        width: 100%;
        transition: width 0.3s ease;
    }

    .remove-file {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: var(--danger);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .remove-file:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .form-section {
        background: var(--light);
        border-radius: var(--border-radius);
        padding: 1.5rem;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .form-input,
    .form-textarea,
    .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--light-gray);
        border-radius: 8px;
        font-size: 1rem;
        transition: var(--transition);
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-input.error,
    .form-textarea.error,
    .form-select.error {
        border-color: var(--danger);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Radio Group */
    .radio-group {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .radio-option {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        border: 2px solid var(--light-gray);
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
    }

    .radio-option:hover {
        border-color: var(--primary);
        background: rgba(79, 70, 229, 0.05);
    }

    .radio-option input[type="radio"] {
        display: none;
    }

    .radio-custom {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--light-gray);
        border-radius: 50%;
        position: relative;
        transition: var(--transition);
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .radio-option input[type="radio"]:checked + .radio-custom {
        border-color: var(--primary);
        background: var(--primary);
    }

    .radio-option input[type="radio"]:checked + .radio-custom::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 0.5rem;
        height: 0.5rem;
        background: white;
        border-radius: 50%;
    }

    .radio-content strong {
        display: block;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .radio-content p {
        color: var(--gray);
        font-size: 0.875rem;
        margin: 0;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.125rem;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--secondary);
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        padding-top: 2rem;
        border-top: 2px solid var(--light-gray);
    }

    /* Error Messages */
    .error-message {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-title {
            font-size: 2rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .upload-form {
            padding: 1rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('fileInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const filePreview = document.getElementById('filePreview');
    const removeFileBtn = document.getElementById('removeFile');
    const titleInput = document.getElementById('title');

    // File upload handling
    fileUploadArea.addEventListener('click', () => fileInput.click());
    
    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('dragover');
    });
    
    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('dragover');
    });
    
    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect(files[0]);
        }
    });
    
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });
    
    removeFileBtn.addEventListener('click', () => {
        fileInput.value = '';
        showUploadPlaceholder();
    });

    function handleFileSelect(file) {
        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('File terlalu besar. Maksimal 10MB.');
            return;
        }

        // Auto-fill title if empty
        if (!titleInput.value) {
            const fileName = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
            titleInput.value = fileName;
        }

        showFilePreview(file);
    }

    function showFilePreview(file) {
        uploadPlaceholder.style.display = 'none';
        filePreview.style.display = 'block';

        // Update file details
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatFileSize(file.size);

        // Update file icon based on extension
        const extension = file.name.split('.').pop().toLowerCase();
        const iconElement = document.querySelector('#previewIcon i');
        
        const iconClass = getFileIcon(extension);
        iconElement.className = iconClass;
    }

    function showUploadPlaceholder() {
        uploadPlaceholder.style.display = 'block';
        filePreview.style.display = 'none';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function getFileIcon(extension) {
        const iconMap = {
            'pdf': 'fas fa-file-pdf text-red-500',
            'doc': 'fas fa-file-word text-blue-500',
            'docx': 'fas fa-file-word text-blue-500',
            'xls': 'fas fa-file-excel text-green-500',
            'xlsx': 'fas fa-file-excel text-green-500',
            'ppt': 'fas fa-file-powerpoint text-orange-500',
            'pptx': 'fas fa-file-powerpoint text-orange-500',
            'jpg': 'fas fa-file-image text-purple-500',
            'jpeg': 'fas fa-file-image text-purple-500',
            'png': 'fas fa-file-image text-purple-500',
            'gif': 'fas fa-file-image text-purple-500',
            'mp4': 'fas fa-file-video text-red-600',
            'avi': 'fas fa-file-video text-red-600',
            'mov': 'fas fa-file-video text-red-600',
            'mp3': 'fas fa-file-audio text-green-600',
            'wav': 'fas fa-file-audio text-green-600',
            'zip': 'fas fa-file-archive text-yellow-600',
            'rar': 'fas fa-file-archive text-yellow-600'
        };
        
        return iconMap[extension] || 'fas fa-file text-gray-500';
    }

    // Form validation
    const form = document.querySelector('.upload-form');
    form.addEventListener('submit', function(e) {
        const fileInput = document.getElementById('fileInput');
        if (!fileInput.files.length) {
            e.preventDefault();
            alert('Silakan pilih file untuk diupload.');
            return false;
        }
    });
});
</script>
@endsection