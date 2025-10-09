@extends('layouts.admin')

@section('title', 'Upload Photos')

@push('styles')
<style>
    :root {
        --primary-color: #3b82f6;
        --primary-dark: #2563eb;
        --secondary-color: #8b5cf6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #06b6d4;
        
        /* Light theme */
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        
        /* Upload area */
        --upload-border: #e2e8f0;
        --upload-bg: #f8fafc;
        --upload-hover-border: #3b82f6;
        --upload-hover-bg: rgba(59, 130, 246, 0.05);
        --upload-dragover-bg: rgba(59, 130, 246, 0.1);
        
        /* Alert colors */
        --alert-success-bg: rgba(16, 185, 129, 0.1);
        --alert-success-color: #059669;
        --alert-success-border: rgba(16, 185, 129, 0.2);
        --alert-danger-bg: rgba(239, 68, 68, 0.1);
        --alert-danger-color: #dc2626;
        --alert-danger-border: rgba(239, 68, 68, 0.2);
    }

    .dark {
        --bg-primary: #1e293b;
        --bg-secondary: #334155;
        --bg-tertiary: #475569;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --border-color: #475569;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.3);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.4), 0 1px 2px -1px rgb(0 0 0 / 0.4);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.4), 0 2px 4px -2px rgb(0 0 0 / 0.4);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.4), 0 4px 6px -4px rgb(0 0 0 / 0.4);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.4), 0 8px 10px -6px rgb(0 0 0 / 0.4);
        
        /* Upload area for dark mode */
        --upload-border: #475569;
        --upload-bg: #334155;
        --upload-hover-border: #3b82f6;
        --upload-hover-bg: rgba(59, 130, 246, 0.1);
        --upload-dragover-bg: rgba(59, 130, 246, 0.2);
        
        /* Alert colors for dark mode */
        --alert-success-bg: rgba(16, 185, 129, 0.2);
        --alert-success-color: #6ee7b7;
        --alert-success-border: rgba(16, 185, 129, 0.3);
        --alert-danger-bg: rgba(239, 68, 68, 0.2);
        --alert-danger-color: #fca5a5;
        --alert-danger-border: rgba(239, 68, 68, 0.3);
    }

    .upload-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        background: var(--bg-primary);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
        margin: 0;
    }

    .btn-secondary-custom {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    .upload-form {
        background: var(--bg-primary);
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        max-width: 800px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

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

    .form-control, .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 0.75rem;
        background: var(--bg-secondary);
        color: var(--text-primary);
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background: var(--bg-primary);
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    .file-upload-area {
        border: 3px dashed var(--upload-border);
        border-radius: 1rem;
        padding: 3rem 2rem;
        text-align: center;
        background: var(--upload-bg);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .file-upload-area:hover {
        border-color: var(--upload-hover-border);
        background: var(--upload-hover-bg);
    }

    .file-upload-area.dragover {
        border-color: var(--upload-hover-border);
        background: var(--upload-dragover-bg);
        transform: scale(1.02);
    }

    .upload-icon {
        width: 4rem;
        height: 4rem;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: white;
    }

    .upload-text {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .upload-subtext {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
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

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        border: none;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
    }

    .btn-primary-custom:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
        padding: 1.5rem;
        background: var(--bg-secondary);
        border-radius: 0.75rem;
        border: 1px solid var(--border-color);
    }

    .preview-item {
        position: relative;
        border-radius: 0.75rem;
        overflow: hidden;
        background: var(--bg-primary);
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
    }

    .preview-item:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-lg);
    }

    .preview-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .preview-remove {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .preview-remove:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .preview-name {
        padding: 0.75rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-align: center;
        word-break: break-all;
        background: var(--bg-secondary);
    }

    .progress-container {
        display: none;
        margin-top: 1.5rem;
    }

    .progress {
        height: 0.5rem;
        border-radius: 0.25rem;
        background: var(--bg-tertiary);
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .progress-bar {
        background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
        height: 100%;
        border-radius: 0.25rem;
        transition: width 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background: linear-gradient(
            to right,
            transparent 0%,
            rgba(255, 255, 255, 0.3) 50%,
            transparent 100%
        );
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .progress-text {
        text-align: center;
        font-size: 0.875rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }

    .alert {
        border-radius: 0.75rem;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: var(--alert-success-bg);
        color: var(--alert-success-color);
        border: 1px solid var(--alert-success-border);
    }

    .alert-danger {
        background: var(--alert-danger-bg);
        color: var(--alert-danger-color);
        border: 1px solid var(--alert-danger-border);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .upload-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
            text-align: center;
        }

        .page-title {
            font-size: 1.5rem;
            justify-content: center;
        }

        .upload-form {
            padding: 1.5rem;
        }

        .file-upload-area {
            padding: 2rem 1rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .preview-container {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }

    @media (max-width: 480px) {
        .upload-form {
            padding: 1rem;
        }

        .preview-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Animation */
    .upload-form {
        opacity: 0;
        transform: translateY(20px);
        animation: slideUp 0.6s ease forwards;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* File type icons */
    .file-type-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .file-type-image { color: var(--success-color); }
    .file-type-video { color: var(--warning-color); }
    .file-type-document { color: var(--info-color); }
</style>
@endpush

@section('content')
<div class="upload-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-cloud-upload-alt"></i>
                    Upload Photos
                </h1>
                <p class="page-subtitle">
                    Add new photos to your gallery collection
                </p>
            </div>
            <a href="{{ route('admin.gallery.index') }}" class="btn-secondary-custom">
                <i class="fas fa-arrow-left"></i>
                Back to Gallery
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Upload Form -->
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="upload-form" id="uploadForm">
        @csrf
        
        <!-- Album Information Section -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i>
                Album Information
            </h2>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title" class="form-label">Album Title *</label>
                        <input type="text" 
                               class="form-control" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               required 
                               placeholder="Enter album title">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category" class="form-label">Category *</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="school_events" {{ old('category') == 'school_events' ? 'selected' : '' }}>School Events</option>
                            <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Academic</option>
                            <option value="extracurricular" {{ old('category') == 'extracurricular' ? 'selected' : '' }}>Extracurricular</option>
                            <option value="achievements" {{ old('category') == 'achievements' ? 'selected' : '' }}>Prestasi</option>
                            <option value="facilities" {{ old('category') == 'facilities' ? 'selected' : '' }}>Fasilitas</option>
                            <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>General</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" 
                          id="description" 
                          name="description" 
                          rows="3" 
                          placeholder="Enter album description (optional)">{{ old('description') }}</textarea>
            </div>
        </div>

        <!-- File Upload Section -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-images"></i>
                Photos Upload
            </h2>
            
            <div class="file-upload-area" id="fileUploadArea">
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">Drop photos here or click to browse</div>
                <div class="upload-subtext">
                    Supports: JPEG, PNG, JPG, GIF, WebP<br>
                    Maximum file size: 10MB each<br>
                    You can upload multiple files at once
                </div>
                <input type="file" 
                       class="file-input" 
                       id="photos" 
                       name="photos[]" 
                       multiple 
                       accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                       required>
            </div>
            
            <!-- Progress Bar -->
            <div class="progress-container" id="progressContainer">
                <div class="progress">
                    <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                </div>
                <div class="progress-text" id="progressText">
                    Uploading...
                </div>
            </div>
        </div>

        <!-- Preview Container -->
        <div class="preview-container" id="previewContainer" style="display: none;"></div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn-primary-custom" id="submitBtn">
                <i class="fas fa-upload"></i>
                Upload Photos
            </button>
            <a href="{{ route('admin.gallery.index') }}" class="btn-secondary-custom">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('photos');
    const fileUploadArea = document.getElementById('fileUploadArea');
    const previewContainer = document.getElementById('previewContainer');
    const submitBtn = document.getElementById('submitBtn');
    const uploadForm = document.getElementById('uploadForm');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    let selectedFiles = [];
    let isDragging = false;

    // File input change event
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    // Drag and drop events
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (!isDragging) {
            isDragging = true;
            fileUploadArea.classList.add('dragover');
        }
    });

    fileUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        // Only remove dragover if we're leaving the upload area completely
        if (!fileUploadArea.contains(e.relatedTarget)) {
            isDragging = false;
            fileUploadArea.classList.remove('dragover');
        }
    });

    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        isDragging = false;
        fileUploadArea.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });

    function handleFiles(files) {
        const validFiles = [];
        const maxSize = 10 * 1024 * 1024; // 10MB
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        
        Array.from(files).forEach(file => {
            if (!allowedTypes.includes(file.type)) {
                showAlert(`File "${file.name}" is not a supported image format.`, 'danger');
                return;
            }
            
            if (file.size > maxSize) {
                showAlert(`File "${file.name}" is too large. Maximum size is 10MB.`, 'danger');
                return;
            }
            
            validFiles.push(file);
        });
        
        if (validFiles.length > 0) {
            selectedFiles = [...selectedFiles, ...validFiles];
            updateFileInput();
            showPreviews();
        }
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    function showPreviews() {
        previewContainer.innerHTML = '';
        
        if (selectedFiles.length === 0) {
            previewContainer.style.display = 'none';
            updateSubmitButton();
            return;
        }

        previewContainer.style.display = 'grid';

        selectedFiles.forEach((file, index) => {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            previewItem.style.opacity = '0';
            previewItem.style.transform = 'scale(0.8)';

            const img = document.createElement('img');
            img.className = 'preview-image';
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);

            const removeBtn = document.createElement('button');
            removeBtn.className = 'preview-remove';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.type = 'button';
            removeBtn.onclick = () => removeFile(index);

            const fileName = document.createElement('div');
            fileName.className = 'preview-name';
            fileName.textContent = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;

            previewItem.appendChild(img);
            previewItem.appendChild(removeBtn);
            previewItem.appendChild(fileName);
            previewContainer.appendChild(previewItem);

            // Animate in
            setTimeout(() => {
                previewItem.style.transition = 'all 0.3s ease';
                previewItem.style.opacity = '1';
                previewItem.style.transform = 'scale(1)';
            }, index * 50);
        });

        updateSubmitButton();
    }

    function removeFile(index) {
        const previewItem = previewContainer.children[index];
        previewItem.style.transition = 'all 0.3s ease';
        previewItem.style.opacity = '0';
        previewItem.style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            selectedFiles.splice(index, 1);
            updateFileInput();
            showPreviews();
        }, 300);
    }

    function updateSubmitButton() {
        const fileCount = selectedFiles.length;
        if (fileCount === 0) {
            submitBtn.innerHTML = '<i class="fas fa-upload"></i> Upload Photos';
        } else {
            submitBtn.innerHTML = `<i class="fas fa-upload"></i> Upload ${fileCount} Photo${fileCount > 1 ? 's' : ''}`;
        }
    }

    // Form submission with progress
    uploadForm.addEventListener('submit', function(e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            showAlert('Please select at least one photo to upload.', 'danger');
            return;
        }

        // Show progress
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        progressContainer.style.display = 'block';

        // Simulate progress (since we can't track real progress with standard form submission)
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 90) progress = 90;
            progressBar.style.width = progress + '%';
            progressText.textContent = `Uploading... ${Math.round(progress)}%`;
        }, 200);

        // Clear interval after form submission
        setTimeout(() => {
            clearInterval(progressInterval);
            progressBar.style.width = '100%';
            progressText.textContent = 'Processing...';
        }, 3000);
    });

    // Utility function to show alerts
    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
            ${message}
        `;
        
        const form = document.querySelector('.upload-form');
        form.insertBefore(alertDiv, form.firstChild);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            alertDiv.style.transition = 'all 0.3s ease';
            alertDiv.style.opacity = '0';
            alertDiv.style.transform = 'translateY(-20px)';
            setTimeout(() => alertDiv.remove(), 300);
        }, 5000);
    }

    // Enhanced file validation
    function validateFile(file) {
        const errors = [];
        
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            errors.push('Invalid file type. Only JPEG, PNG, JPG, GIF, and WebP are allowed.');
        }
        
        // Check file size
        const maxSize = 10 * 1024 * 1024; // 10MB
        if (file.size > maxSize) {
            errors.push('File size too large. Maximum size is 10MB.');
        }
        
        // Check image dimensions (optional)
        return new Promise((resolve) => {
            if (errors.length > 0) {
                resolve({ valid: false, errors });
                return;
            }
            
            const img = new Image();
            img.onload = function() {
                // Optional: Check minimum dimensions
                const minWidth = 100;
                const minHeight = 100;
                
                if (this.width < minWidth || this.height < minHeight) {
                    errors.push(`Image too small. Minimum size is ${minWidth}x${minHeight} pixels.`);
                }
                
                resolve({ valid: errors.length === 0, errors, width: this.width, height: this.height });
            };
            
            img.onerror = function() {
                errors.push('Invalid image file.');
                resolve({ valid: false, errors });
            };
            
            img.src = URL.createObjectURL(file);
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + U to focus upload area
        if ((e.ctrlKey || e.metaKey) && e.key === 'u') {
            e.preventDefault();
            fileInput.click();
        }
        
        // Escape to clear selection
        if (e.key === 'Escape' && selectedFiles.length > 0) {
            if (confirm('Clear all selected files?')) {
                selectedFiles = [];
                updateFileInput();
                showPreviews();
            }
        }
    });

    // Auto-save form data to localStorage
    const formInputs = uploadForm.querySelectorAll('input[type="text"], textarea, select');
    formInputs.forEach(input => {
        // Load saved data
        const savedValue = localStorage.getItem(`gallery_upload_${input.name}`);
        if (savedValue && !input.value) {
            input.value = savedValue;
        }
        
        // Save on change
        input.addEventListener('input', function() {
            localStorage.setItem(`gallery_upload_${input.name}`, this.value);
        });
    });

    // Clear saved data on successful submission
    uploadForm.addEventListener('submit', function() {
        formInputs.forEach(input => {
            localStorage.removeItem(`gallery_upload_${input.name}`);
        });
    });
});
</script>
@endpush