@extends('layouts.admin')

@section('title', 'Upload Photos')

@section('content')
<style>
    .upload-container {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 50%, #ffffff 100%);
        min-height: 100vh;
        padding: 1.5rem;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        padding: 1.5rem 2rem;
        border-radius: 16px;
        border: 1px solid rgba(14, 165, 233, 0.1);
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
    }

    .page-title {
        color: #0c4a6e;
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0;
    }

    .btn-secondary {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .btn-secondary:hover {
        background: rgba(107, 114, 128, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 114, 128, 0.2);
        color: #374151;
        text-decoration: none;
    }

    .upload-form {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid rgba(14, 165, 233, 0.1);
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #0c4a6e;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border: 2px solid rgba(14, 165, 233, 0.1);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
    }

    .form-control:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        background: white;
    }

    .form-select {
        border: 2px solid rgba(14, 165, 233, 0.1);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
    }

    .form-select:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        background: white;
    }

    .file-upload-area {
        border: 3px dashed rgba(14, 165, 233, 0.3);
        border-radius: 16px;
        padding: 3rem 2rem;
        text-align: center;
        background: rgba(14, 165, 233, 0.02);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .file-upload-area:hover {
        border-color: #0ea5e9;
        background: rgba(14, 165, 233, 0.05);
    }

    .file-upload-area.dragover {
        border-color: #0ea5e9;
        background: rgba(14, 165, 233, 0.1);
        transform: scale(1.02);
    }

    .upload-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #dbeafe, #bae6fd);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .upload-text {
        color: #0c4a6e;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .upload-subtext {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 1rem;
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

    .btn-primary {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        font-size: 1rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
        padding: 1.5rem;
        background: rgba(14, 165, 233, 0.02);
        border-radius: 12px;
        border: 1px solid rgba(14, 165, 233, 0.1);
    }

    .preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        background: white;
        box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1);
        transition: transform 0.3s ease;
    }

    .preview-item:hover {
        transform: scale(1.05);
    }

    .preview-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .preview-remove {
        position: absolute;
        top: 4px;
        right: 4px;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .preview-remove:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .preview-name {
        padding: 0.5rem;
        font-size: 0.75rem;
        color: #64748b;
        text-align: center;
        word-break: break-all;
    }

    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .progress-container {
        display: none;
        margin-top: 1rem;
    }

    .progress {
        height: 8px;
        border-radius: 4px;
        background: rgba(14, 165, 233, 0.1);
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, #0ea5e9, #0284c7);
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(14, 165, 233, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .upload-container {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            padding: 1.25rem;
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
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        }
    }

    /* Animation */
    .upload-form {
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

<div class="upload-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Upload Photos</h1>
            <p class="page-subtitle">Add new photos to your gallery collection</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="btn-secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Gallery
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <svg class="w-5 h-5" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <svg class="w-5 h-5" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <strong>Please fix the following errors:</strong>
            <ul style="margin: 0.5rem 0 0 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Upload Form -->
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="upload-form" id="uploadForm">
        @csrf
        
        <!-- Album Information -->
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

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" 
                      id="description" 
                      name="description" 
                      rows="3" 
                      placeholder="Enter album description (optional)">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="category" class="form-label">Category *</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="school_events" {{ old('category') == 'school_events' ? 'selected' : '' }}>School Events</option>
                <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Academic</option>
                <option value="extracurricular" {{ old('category') == 'extracurricular' ? 'selected' : '' }}>Extracurricular</option>
                <option value="achievements" {{ old('category') == 'achievements' ? 'selected' : '' }}>Achievements</option>
                <option value="facilities" {{ old('category') == 'facilities' ? 'selected' : '' }}>Facilities</option>
                <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>General</option>
            </select>
        </div>

        <!-- File Upload Area -->
        <div class="form-group">
            <label class="form-label">Photos *</label>
            <div class="file-upload-area" id="fileUploadArea">
                <div class="upload-icon">
                    <svg class="w-8 h-8" style="color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="upload-text">Drop photos here or click to browse</div>
                <div class="upload-subtext">
                    Supports: JPEG, PNG, JPG, GIF, WebP (Max: 10MB each)
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
                <div style="text-align: center; margin-top: 0.5rem; font-size: 0.9rem; color: #64748b;" id="progressText">
                    Uploading...
                </div>
            </div>
        </div>

        <!-- Preview Container -->
        <div class="preview-container" id="previewContainer" style="display: none;"></div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn-primary" id="submitBtn">
                <svg class="w-5 h-5" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Upload Photos
            </button>
            <a href="{{ route('admin.gallery.index') }}" class="btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

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

    // File input change event
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    // Drag and drop events
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        fileUploadArea.classList.add('dragover');
    });

    fileUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');
    });

    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });

    function handleFiles(files) {
        selectedFiles = Array.from(files);
        updateFileInput();
        showPreviews();
    }

    function updateFileInput() {
        // Create a new DataTransfer object to update the file input
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    function showPreviews() {
        previewContainer.innerHTML = '';
        
        if (selectedFiles.length === 0) {
            previewContainer.style.display = 'none';
            return;
        }

        previewContainer.style.display = 'grid';

        selectedFiles.forEach((file, index) => {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';

            const img = document.createElement('img');
            img.className = 'preview-image';
            img.src = URL.createObjectURL(file);

            const removeBtn = document.createElement('button');
            removeBtn.className = 'preview-remove';
            removeBtn.innerHTML = '×';
            removeBtn.type = 'button';
            removeBtn.onclick = () => removeFile(index);

            const fileName = document.createElement('div');
            fileName.className = 'preview-name';
            fileName.textContent = file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name;

            previewItem.appendChild(img);
            previewItem.appendChild(removeBtn);
            previewItem.appendChild(fileName);
            previewContainer.appendChild(previewItem);
        });

        // Update submit button text
        submitBtn.innerHTML = `
            <svg class="w-5 h-5" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            Upload ${selectedFiles.length} Photo${selectedFiles.length > 1 ? 's' : ''}
        `;
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        updateFileInput();
        showPreviews();
    }

    // Form submission with progress
    uploadForm.addEventListener('submit', function(e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            alert('Please select at least one photo to upload.');
            return;
        }

        // Show progress
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="w-5 h-5 animate-spin" style="display: inline; margin-right: 0.5rem;" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Uploading...
        `;
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

    // Add CSS for spinner animation
    const style = document.createElement('style');
    style.textContent = `
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection