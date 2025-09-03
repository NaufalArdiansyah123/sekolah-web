<?php
// resources/views/admin/gallery/upload.blade.php
?>
@extends('layouts.admin.app')

@section('title', 'Upload Gallery Photos')

@section('content')
<style>
    :root {
        --primary-blue: #3b82f6;
        --light-blue: #dbeafe;
        --blue-50: #eff6ff;
        --blue-100: #dbeafe;
        --blue-200: #bfdbfe;
        --blue-600: #2563eb;
        --blue-700: #1d4ed8;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-400: #9ca3af;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --success: #10b981;
        --error: #ef4444;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .upload-container {
        background: linear-gradient(135deg, var(--blue-50) 0%, var(--blue-100) 100%);
        min-height: 100vh;
        padding: 2rem;
    }

    .upload-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--blue-100);
        max-width: 800px;
        margin: 0 auto;
    }

    .upload-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .upload-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 0.5rem;
        letter-spacing: -0.025em;
    }

    .upload-subtitle {
        color: var(--gray-600);
        font-size: 1rem;
        font-weight: 400;
    }

    .drop-zone {
        border: 2px dashed var(--blue-200);
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        background: var(--blue-50);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .drop-zone::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.6s ease;
    }

    .drop-zone:hover::before {
        left: 100%;
    }

    .drop-zone:hover {
        border-color: var(--primary-blue);
        background: var(--light-blue);
        transform: translateY(-2px);
    }

    .drop-zone.dragover {
        border-color: var(--primary-blue);
        background: var(--light-blue);
        transform: scale(1.02);
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 1rem;
        background: var(--primary-blue);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .drop-zone:hover .upload-icon {
        transform: scale(1.1) rotate(3deg);
    }

    .upload-text {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .file-input {
        display: none;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }

    .btn-primary {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary:hover:not(:disabled)::before {
        left: 100%;
    }

    .btn-primary:hover:not(:disabled) {
        background: var(--blue-700);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-secondary {
        background: var(--gray-100);
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        background: var(--gray-200);
        transform: translateY(-1px);
        text-decoration: none;
        color: var(--gray-600);
    }

    .preview-container {
        margin-top: 2rem;
        display: none;
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        background: white;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
    }

    .preview-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .preview-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .preview-info {
        padding: 0.75rem;
    }

    .preview-name {
        font-weight: 500;
        color: var(--gray-700);
        font-size: 0.75rem;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .preview-size {
        color: var(--gray-400);
        font-size: 0.7rem;
    }

    .remove-btn {
        position: absolute;
        top: 6px;
        right: 6px;
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
        transition: all 0.3s ease;
    }

    .remove-btn:hover {
        background: var(--error);
        transform: scale(1.1);
    }

    .progress-bar {
        width: 100%;
        height: 4px;
        background: var(--gray-200);
        border-radius: 2px;
        overflow: hidden;
        margin-top: 1rem;
        display: none;
    }

    .progress-fill {
        height: 100%;
        background: var(--primary-blue);
        border-radius: 2px;
        transition: width 0.3s ease;
        width: 0%;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .loading-spinner {
        display: none;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .flex {
        display: flex;
    }

    .justify-between {
        justify-content: space-between;
    }

    .items-center {
        align-items: center;
    }

    .w-4 { width: 1rem; }
    .h-4 { height: 1rem; }
    .w-5 { width: 1.25rem; }
    .h-5 { height: 1.25rem; }
    .w-6 { width: 1.5rem; }
    .h-6 { height: 1.5rem; }
    .w-8 { width: 2rem; }
    .h-8 { height: 2rem; }
    .inline { display: inline; }
    .mr-2 { margin-right: 0.5rem; }
    .mt-6 { margin-top: 1.5rem; }

    @media (max-width: 768px) {
        .upload-container {
            padding: 1rem;
        }
        
        .upload-card {
            padding: 1.5rem;
        }
        
        .upload-title {
            font-size: 1.75rem;
        }
        
        .preview-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }

        .flex {
            flex-direction: column-reverse;
            gap: 0.75rem;
        }

        .btn-primary, .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="upload-container">
    <div class="upload-card">
        <!-- Header -->
        <div class="upload-header">
            <h1 class="upload-title">Upload Gallery Photos</h1>
            <p class="upload-subtitle">Share beautiful moments with elegant photo uploads</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <!-- Upload Form -->
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            
            <!-- Drag & Drop Zone -->
            <div class="drop-zone" id="dropZone">
                <div class="upload-icon">
                    <svg class="w-6 h-6" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="upload-text">Drag & drop photos here</p>
                <p class="upload-hint">or click to browse files</p>
                <input type="file" id="fileInput" name="photos[]" multiple accept="image/*" class="file-input">
            </div>

            <!-- Photo Information Form -->
            <div id="photoInfoSection" style="display: none;">
                <div class="form-group">
                    <label for="title" class="form-label">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Album Title
                    </label>
                    <input type="text" id="title" name="title" class="form-input" placeholder="Enter album title..." value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Description
                    </label>
                    <textarea id="description" name="description" class="form-input form-textarea" placeholder="Describe your photos...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Category
                    </label>
                    <select id="category" name="category" class="form-input" required>
                        <option value="">Select Category</option>
                        <option value="school_events" {{ old('category') == 'school_events' ? 'selected' : '' }}>School Events</option>
                        <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Academic Activities</option>
                        <option value="extracurricular" {{ old('category') == 'extracurricular' ? 'selected' : '' }}>Extracurricular</option>
                        <option value="achievements" {{ old('category') == 'achievements' ? 'selected' : '' }}>Achievements</option>
                        <option value="facilities" {{ old('category') == 'facilities' ? 'selected' : '' }}>School Facilities</option>
                        <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>General</option>
                    </select>
                </div>
            </div>

            <!-- Preview Container -->
            <div class="preview-container" id="previewContainer">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--gray-700); margin-bottom: 1rem;">Selected Photos</h3>
                <div class="preview-grid" id="previewGrid"></div>
            </div>

            <!-- Progress Bar -->
            <div class="progress-bar" id="progressBar">
                <div class="progress-fill" id="progressFill"></div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('admin.gallery.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Gallery
                </a>
                
                <button type="submit" class="btn-primary" id="uploadBtn">
                    <span class="loading-spinner" id="loadingSpinner"></span>
                    <svg class="w-4 h-4" id="uploadIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <span id="uploadText">Upload Photos</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewGrid = document.getElementById('previewGrid');
    const photoInfoSection = document.getElementById('photoInfoSection');
    const uploadForm = document.getElementById('uploadForm');
    const uploadBtn = document.getElementById('uploadBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const uploadIcon = document.getElementById('uploadIcon');
    const uploadText = document.getElementById('uploadText');
    const progressBar = document.getElementById('progressBar');
    const progressFill = document.getElementById('progressFill');

    let selectedFiles = [];

    // Click to browse
    dropZone.addEventListener('click', () => fileInput.click());

    // Drag and drop events
    dropZone.addEventListener('dragover', handleDragOver);
    dropZone.addEventListener('dragleave', handleDragLeave);
    dropZone.addEventListener('drop', handleDrop);
    
    // File input change
    fileInput.addEventListener('change', handleFileSelect);

    function handleDragOver(e) {
        e.preventDefault();
        dropZone.classList.add('dragover');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');
    }

    function handleDrop(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        const files = Array.from(e.dataTransfer.files);
        processFiles(files);
    }

    function handleFileSelect(e) {
        const files = Array.from(e.target.files);
        processFiles(files);
    }

    function processFiles(files) {
        const imageFiles = files.filter(file => file.type.startsWith('image/'));
        
        if (imageFiles.length === 0) {
            alert('Please select only image files.');
            return;
        }

        selectedFiles = [...selectedFiles, ...imageFiles];
        updatePreview();
        
        if (selectedFiles.length > 0) {
            photoInfoSection.style.display = 'block';
            previewContainer.style.display = 'block';
        }
    }

    function updatePreview() {
        previewGrid.innerHTML = '';
        
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="preview-image">
                    <div class="preview-info">
                        <div class="preview-name">${file.name}</div>
                        <div class="preview-size">${formatFileSize(file.size)}</div>
                    </div>
                    <button type="button" class="remove-btn" onclick="removeFile(${index})">
                        <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                `;
                previewGrid.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
    }

    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updatePreview();
        
        if (selectedFiles.length === 0) {
            photoInfoSection.style.display = 'none';
            previewContainer.style.display = 'none';
        }
        
        // Update file input
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    };

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Form submission with progress - REAL LARAVEL INTEGRATION
    uploadForm.addEventListener('submit', function(e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            alert('Please select at least one photo to upload.');
            return;
        }

        // Show loading state
        uploadBtn.disabled = true;
        loadingSpinner.style.display = 'inline-block';
        uploadIcon.style.display = 'none';
        uploadText.textContent = 'Uploading...';
        progressBar.style.display = 'block';

        // Simulate progress for better UX
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 10;
            if (progress > 85) progress = 85;
            progressFill.style.width = progress + '%';
        }, 300);

        // The form will submit normally to Laravel backend
        // Clean up progress bar after a delay to show completion
        setTimeout(() => {
            clearInterval(interval);
            progressFill.style.width = '100%';
        }, 1000);
    });

    // Update file input when files are selected
    fileInput.addEventListener('change', function() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        this.files = dt.files;
    });
});
</script>
@endsection