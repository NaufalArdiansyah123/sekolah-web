@extends('layouts.admin')

@section('title', 'Edit Slideshow')

@push('styles')
<style>
    /* CSS Variables for Dark Mode */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-tertiary: #94a3b8;
        --border-color: #e2e8f0;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --accent-color: #3b82f6;
        --accent-hover: #2563eb;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    .dark {
        --bg-primary: #1e293b;
        --bg-secondary: #0f172a;
        --bg-tertiary: #334155;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-tertiary: #94a3b8;
        --border-color: #334155;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    /* Base Styles */
    .slideshow-edit-page {
        /* Remove background and padding since layout handles it */
    }

    .slideshow-container {
        max-width: 48rem;
        margin: 0 auto;
    }

    /* Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .back-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .back-button:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateX(-2px);
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .page-subtitle {
        color: var(--text-secondary);
        margin: 0.25rem 0 0 0;
        font-size: 1rem;
    }

    /* Form Container */
    .form-container {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px var(--shadow-color);
        margin-top: 1.5rem;
    }

    .form-content {
        padding: 2rem;
    }

    .form-actions {
        background: var(--bg-tertiary);
        border-top: 1px solid var(--border-color);
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Form Fields */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .required {
        color: var(--danger-color);
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.875rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.15s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-input.error {
        border-color: var(--danger-color);
    }

    .form-input.error:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-help {
        margin-top: 0.25rem;
        font-size: 0.75rem;
        color: var(--text-tertiary);
    }

    .form-error {
        margin-top: 0.25rem;
        font-size: 0.75rem;
        color: var(--danger-color);
    }

    /* Current Image Display */
    .current-image-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .current-image-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .current-image-title {
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .current-image-content {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .current-image {
        width: 12rem;
        height: 8rem;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 8px var(--shadow-color);
    }

    .current-image-info {
        flex: 1;
    }

    .current-image-details {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        line-height: 1.5;
    }

    .current-image-note {
        color: var(--text-tertiary);
        font-size: 0.75rem;
        font-style: italic;
    }

    /* File Upload */
    .upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        background: var(--bg-secondary);
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .upload-area:hover {
        border-color: var(--accent-color);
        background: rgba(59, 130, 246, 0.05);
    }

    .upload-area.dragover {
        border-color: var(--accent-color);
        background: rgba(59, 130, 246, 0.1);
    }

    .upload-icon {
        width: 3rem;
        height: 3rem;
        color: var(--text-tertiary);
        margin: 0 auto 1rem;
    }

    .upload-text {
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .upload-link {
        color: var(--accent-color);
        font-weight: 500;
        text-decoration: none;
    }

    .upload-link:hover {
        color: var(--accent-hover);
        text-decoration: underline;
    }

    .upload-hint {
        font-size: 0.75rem;
        color: var(--text-tertiary);
        margin-top: 0.5rem;
    }

    /* Image Preview */
    .image-preview {
        margin-top: 1rem;
    }
    
    .image-preview.hidden {
        display: none;
    }

    .preview-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .preview-title {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .preview-tabs {
        display: flex;
        gap: 0.5rem;
    }

    .preview-tab {
        padding: 0.5rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background: var(--bg-primary);
        color: var(--text-secondary);
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .preview-tab.active {
        background: var(--accent-color);
        color: white;
        border-color: var(--accent-color);
    }

    .preview-tab:hover:not(.active) {
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }

    .preview-content {
        display: none;
    }

    .preview-content.active {
        display: block;
    }

    /* Basic Preview */
    .basic-preview {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .preview-image {
        width: 12rem;
        height: 8rem;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 8px var(--shadow-color);
    }

    .preview-info {
        flex: 1;
    }

    .preview-details {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .preview-specs {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }

    .spec-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
    }

    .spec-item:last-child {
        margin-bottom: 0;
    }

    .spec-label {
        color: var(--text-tertiary);
        font-weight: 500;
    }

    .spec-value {
        color: var(--text-primary);
        font-weight: 600;
    }

    /* Slideshow Preview */
    .slideshow-preview {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        aspect-ratio: 16/9;
        max-width: 100%;
    }

    .slideshow-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slideshow-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
        color: white;
        padding: 2rem 1.5rem 1.5rem;
    }

    .slideshow-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .slideshow-description {
        font-size: 1rem;
        opacity: 0.9;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        line-height: 1.4;
    }

    .slideshow-indicators {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        display: flex;
        gap: 0.5rem;
    }

    .indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
    }

    .indicator.active {
        background: white;
    }

    .slideshow-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .slideshow-nav:hover {
        background: rgba(0, 0, 0, 0.7);
    }

    .slideshow-nav.prev {
        left: 1rem;
    }

    .slideshow-nav.next {
        right: 1rem;
    }

    /* Mobile Preview */
    .mobile-preview {
        max-width: 375px;
        margin: 0 auto;
        background: #000;
        border-radius: 20px;
        padding: 0.5rem;
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .mobile-screen {
        background: var(--bg-primary);
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 375/667;
    }

    .mobile-slideshow {
        width: 100%;
        height: 200px;
        position: relative;
        overflow: hidden;
    }

    .mobile-slideshow-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mobile-content {
        padding: 1rem;
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .mobile-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .mobile-description {
        font-size: 0.875rem;
        color: var(--text-secondary);
        line-height: 1.4;
    }

    /* Metadata Section */
    .metadata-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .metadata-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .metadata-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .metadata-label {
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .metadata-value {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.15s ease;
    }

    .btn-primary {
        background: var(--accent-color);
        color: white;
    }

    .btn-primary:hover:not(:disabled) {
        background: var(--accent-hover);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-primary:disabled {
        background: var(--text-tertiary);
        cursor: not-allowed;
        transform: none;
    }

    .btn-secondary {
        background: var(--bg-primary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        text-decoration: none;
    }

    .btn-danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .btn-danger:hover {
        background: rgba(239, 68, 68, 0.2);
        color: var(--danger-color);
        text-decoration: none;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
    }

    /* Alerts */
    .alert {
        border-radius: 8px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
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

    .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .alert-info {
        background: rgba(59, 130, 246, 0.1);
        color: #1d4ed8;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .alert-list {
        margin: 0.5rem 0 0 1rem;
        list-style: disc;
    }

    .alert-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        opacity: 0.7;
        padding: 0;
        margin-left: auto;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* Loading Spinner */
    .spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .slideshow-container {
            max-width: none;
        }

        .form-content {
            padding: 1.5rem;
        }

        .form-actions {
            padding: 1rem 1.5rem;
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .basic-preview {
            flex-direction: column;
        }

        .preview-image {
            width: 100%;
            height: 12rem;
        }

        .current-image-content {
            flex-direction: column;
        }

        .current-image {
            width: 100%;
            height: 12rem;
        }

        .preview-tabs {
            flex-wrap: wrap;
        }

        .slideshow-title {
            font-size: 1.25rem;
        }

        .slideshow-description {
            font-size: 0.875rem;
        }

        .metadata-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Hidden class */
    .hidden {
        display: none !important;
    }
</style>
@endpush

@section('content')
<div class="slideshow-edit-page">
    <div class="slideshow-container">
        <!-- Header -->
        <div class="page-header">
            <div class="header-content">
                <a href="{{ route('admin.posts.slideshow') }}" class="back-button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="page-title">Edit Slideshow</h1>
                    <p class="page-subtitle">Update slideshow for the homepage</p>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('error'))
            <div class="alert alert-danger">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="alert-content">{{ session('error') }}</div>
                <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="alert-content">
                    <div class="alert-title">Please fix the following errors:</div>
                    <ul class="alert-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Form -->
        <div class="form-container">
            <form action="{{ route('admin.posts.slideshow.update', $slideshow->id) }}" method="POST" enctype="multipart/form-data" id="slideshowForm">
                @csrf
                @method('PUT')
                
                <div class="form-content">
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Title <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $slideshow->title) }}"
                               class="form-input @error('title') error @enderror"
                               placeholder="Enter slideshow title"
                               required>
                        @error('title')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-input form-textarea @error('description') error @enderror"
                                  placeholder="Enter slideshow description (optional)">{{ old('description', $slideshow->description) }}</textarea>
                        @error('description')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    @if($slideshow->image)
                        <div class="form-group">
                            <label class="form-label">Current Image</label>
                            <div class="current-image-section">
                                <div class="current-image-header">
                                    <svg class="w-5 h-5" style="color: var(--success-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="current-image-title">Current slideshow image</span>
                                </div>
                                <div class="current-image-content">
                                    <img src="{{ asset('storage/' . $slideshow->image) }}" 
                                         alt="{{ $slideshow->title }}" 
                                         class="current-image">
                                    <div class="current-image-info">
                                        <div class="current-image-details">
                                            <strong>File:</strong> {{ basename($slideshow->image) }}<br>
                                            <strong>Status:</strong> Active slideshow image
                                        </div>
                                        <div class="current-image-note">
                                            Upload a new image below to replace this one
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Image Upload -->
                    <div class="form-group">
                        <label for="image" class="form-label">
                            {{ $slideshow->image ? 'New Slideshow Image' : 'Slideshow Image' }}
                            @if(!$slideshow->image) <span class="required">*</span> @endif
                        </label>
                        <div id="upload-area" class="upload-area">
                            <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <div class="upload-text">
                                <label for="image" class="upload-link">{{ $slideshow->image ? 'Choose new file' : 'Choose file' }}</label>
                                or drag and drop
                            </div>
                            <div class="upload-hint">PNG, JPG, JPEG, GIF up to 10MB</div>
                            <div class="upload-hint">Recommended: 1920x1080px</div>
                            <input id="image" name="image" type="file" class="hidden" accept="image/jpeg,image/png,image/jpg,image/gif" {{ !$slideshow->image ? 'required' : '' }}>
                        </div>
                        
                        <!-- Enhanced Image Preview -->
                        <div id="image-preview" class="image-preview hidden">
                            <div class="preview-section">
                                <div class="preview-header">
                                    <div class="preview-title">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        New Image Preview
                                    </div>
                                    <div class="preview-tabs">
                                        <button type="button" class="preview-tab active" data-tab="basic">Basic</button>
                                        <button type="button" class="preview-tab" data-tab="slideshow">Slideshow</button>
                                        <button type="button" class="preview-tab" data-tab="mobile">Mobile</button>
                                    </div>
                                </div>

                                <!-- Basic Preview Tab -->
                                <div id="basic-preview" class="preview-content active">
                                    <div class="basic-preview">
                                        <img id="preview-img" class="preview-image" src="" alt="Preview">
                                        <div class="preview-info">
                                            <div id="file-info" class="preview-details"></div>
                                            
                                            <div class="preview-specs">
                                                <div class="spec-item">
                                                    <span class="spec-label">File Name:</span>
                                                    <span class="spec-value" id="spec-filename">-</span>
                                                </div>
                                                <div class="spec-item">
                                                    <span class="spec-label">File Size:</span>
                                                    <span class="spec-value" id="spec-filesize">-</span>
                                                </div>
                                                <div class="spec-item">
                                                    <span class="spec-label">Dimensions:</span>
                                                    <span class="spec-value" id="spec-dimensions">-</span>
                                                </div>
                                                <div class="spec-item">
                                                    <span class="spec-label">Aspect Ratio:</span>
                                                    <span class="spec-value" id="spec-ratio">-</span>
                                                </div>
                                            </div>
                                            
                                            <button type="button" id="remove-image" class="btn btn-danger btn-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Remove New Image
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Slideshow Preview Tab -->
                                <div id="slideshow-preview" class="preview-content">
                                    <div class="slideshow-preview">
                                        <img id="slideshow-img" class="slideshow-image" src="" alt="Slideshow Preview">
                                        <div class="slideshow-overlay">
                                            <div class="slideshow-title" id="slideshow-title-preview">{{ $slideshow->title }}</div>
                                            <div class="slideshow-description" id="slideshow-desc-preview">{{ $slideshow->description ?: 'This is how your updated slideshow will appear on the homepage.' }}</div>
                                        </div>
                                        <div class="slideshow-indicators">
                                            <div class="indicator"></div>
                                            <div class="indicator active"></div>
                                            <div class="indicator"></div>
                                        </div>
                                        <button class="slideshow-nav prev">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </button>
                                        <button class="slideshow-nav next">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Mobile Preview Tab -->
                                <div id="mobile-preview" class="preview-content">
                                    <div class="mobile-preview">
                                        <div class="mobile-screen">
                                            <div class="mobile-slideshow">
                                                <img id="mobile-img" class="mobile-slideshow-image" src="" alt="Mobile Preview">
                                            </div>
                                            <div class="mobile-content">
                                                <div class="mobile-title" id="mobile-title-preview">{{ $slideshow->title }}</div>
                                                <div class="mobile-description" id="mobile-desc-preview">{{ $slideshow->description ?: 'This is how your updated slideshow will look on mobile devices.' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @error('image')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status" class="form-label">
                            Status <span class="required">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                class="form-input @error('status') error @enderror"
                                required>
                            <option value="">Select status</option>
                            <option value="active" {{ old('status', $slideshow->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $slideshow->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <div class="form-help">Active slideshows will be displayed on the homepage</div>
                        @error('status')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div class="form-group">
                        <label for="order" class="form-label">Display Order</label>
                        <input type="number" 
                               name="order" 
                               id="order" 
                               value="{{ old('order', $slideshow->order ?? 0) }}"
                               class="form-input @error('order') error @enderror"
                               placeholder="0"
                               min="0"
                               max="999">
                        <div class="form-help">Lower numbers appear first (0 = highest priority)</div>
                        @error('order')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Metadata -->
                    <div class="metadata-section">
                        <div class="metadata-grid">
                            <div class="metadata-item">
                                <div class="metadata-label">Created</div>
                                <div class="metadata-value">{{ $slideshow->created_at->format('M d, Y H:i') }}</div>
                            </div>
                            <div class="metadata-item">
                                <div class="metadata-label">Last Updated</div>
                                <div class="metadata-value">{{ $slideshow->updated_at->format('M d, Y H:i') }}</div>
                            </div>
                            @if($slideshow->user_id)
                                <div class="metadata-item">
                                    <div class="metadata-label">Created By</div>
                                    <div class="metadata-value">User ID: {{ $slideshow->user_id }}</div>
                                </div>
                            @endif
                            <div class="metadata-item">
                                <div class="metadata-label">Current Status</div>
                                <div class="metadata-value">
                                    <span style="color: {{ $slideshow->status === 'active' ? 'var(--success-color)' : 'var(--text-tertiary)' }};">
                                        {{ ucfirst($slideshow->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <div style="font-size: 0.875rem; color: var(--text-secondary);">
                        <span class="required">*</span> Required fields
                    </div>
                    <div style="display: flex; gap: 0.75rem;">
                        <a href="{{ route('admin.posts.slideshow') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" id="submit-btn" class="btn btn-primary">
                            <span id="submit-text">Update Slideshow</span>
                            <span id="loading-spinner" class="spinner hidden"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Initializing slideshow edit page');
    
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const slideshowImg = document.getElementById('slideshow-img');
    const mobileImg = document.getElementById('mobile-img');
    const removeButton = document.getElementById('remove-image');
    const fileInfo = document.getElementById('file-info');
    const uploadArea = document.getElementById('upload-area');
    const form = document.getElementById('slideshowForm');
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const loadingSpinner = document.getElementById('loading-spinner');
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    
    // Debug: Check if elements are found
    console.log('Elements found:');
    console.log('imageInput:', imageInput);
    console.log('imagePreview:', imagePreview);
    console.log('previewImg:', previewImg);
    console.log('uploadArea:', uploadArea);
    
    // Preview tab elements
    const previewTabs = document.querySelectorAll('.preview-tab');
    const previewContents = document.querySelectorAll('.preview-content');
    
    // Spec elements
    const specFilename = document.getElementById('spec-filename');
    const specFilesize = document.getElementById('spec-filesize');
    const specDimensions = document.getElementById('spec-dimensions');
    const specRatio = document.getElementById('spec-ratio');
    
    // Preview text elements
    const slideshowTitlePreview = document.getElementById('slideshow-title-preview');
    const slideshowDescPreview = document.getElementById('slideshow-desc-preview');
    const mobileTitlePreview = document.getElementById('mobile-title-preview');
    const mobileDescPreview = document.getElementById('mobile-desc-preview');

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });

    uploadArea.addEventListener('drop', handleDrop, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        uploadArea.classList.add('dragover');
    }

    function unhighlight() {
        uploadArea.classList.remove('dragover');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            imageInput.files = files;
            handleImageSelect(files[0]);
        }
    }

    // File input change handler
    imageInput.addEventListener('change', function(e) {
        console.log('File input changed');
        const file = e.target.files[0];
        if (file) {
            console.log('File selected:', file.name);
            handleImageSelect(file);
        }
    });

    function handleImageSelect(file) {
        console.log('handleImageSelect called with:', file);
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            console.log('Invalid file type:', file.type);
            showAlert('Unsupported file type. Please use JPG, JPEG, PNG, or GIF.', 'danger');
            resetImageInput();
            return;
        }

        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            console.log('File too large:', file.size);
            showAlert('File size too large. Maximum 10MB allowed.', 'danger');
            resetImageInput();
            return;
        }

        console.log('File validation passed');
        
        // Display file info
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        fileInfo.textContent = `New image: ${file.name} (${fileSize} MB)`;
        
        // Update specs
        specFilename.textContent = file.name;
        specFilesize.textContent = `${fileSize} MB`;

        console.log('Starting FileReader');
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log('FileReader loaded successfully');
            const imageSrc = e.target.result;
            
            // Update all preview images
            previewImg.src = imageSrc;
            slideshowImg.src = imageSrc;
            mobileImg.src = imageSrc;
            
            console.log('Images updated, showing preview');
            // Show preview
            imagePreview.classList.remove('hidden');
            console.log('Preview should now be visible');
            
            // Check image dimensions
            const img = new Image();
            img.onload = function() {
                console.log('Image dimensions loaded:', this.width, 'x', this.height);
                const width = this.width;
                const height = this.height;
                const aspectRatio = (width / height).toFixed(2);
                
                // Update specs
                specDimensions.textContent = `${width}x${height}px`;
                specRatio.textContent = `${aspectRatio}:1`;
                
                // Show quality warning if needed
                if (width < 800 || height < 600) {
                    showAlert('Image resolution is too low. Minimum 800x600px recommended for best quality.', 'warning');
                }
                
                // Update file info with dimensions
                fileInfo.innerHTML = `New image: ${file.name} (${fileSize} MB)<br>
                    <span style="font-size: 0.8rem; color: var(--text-tertiary);">Ready to replace current image • ${width}x${height}px</span>`;
            };
            img.src = imageSrc;
        };
        
        reader.onerror = function(e) {
            console.error('FileReader error:', e);
            showAlert('Error reading file. Please try again.', 'danger');
        };
        
        reader.readAsDataURL(file);
    }

    function resetImageInput() {
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        previewImg.src = '';
        slideshowImg.src = '';
        mobileImg.src = '';
        fileInfo.textContent = '';
        
        // Reset specs
        specFilename.textContent = '-';
        specFilesize.textContent = '-';
        specDimensions.textContent = '-';
        specRatio.textContent = '-';
    }

    removeButton.addEventListener('click', function() {
        resetImageInput();
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.disabled = true;
        submitText.textContent = 'Updating...';
        loadingSpinner.classList.remove('hidden');
        
        // Basic validation
        const title = titleInput.value.trim();
        const status = document.getElementById('status').value;

        if (!title) {
            e.preventDefault();
            showAlert('Slideshow title is required.', 'danger');
            resetSubmitButton();
            return;
        }

        if (!status) {
            e.preventDefault();
            showAlert('Slideshow status is required.', 'danger');
            resetSubmitButton();
            return;
        }

        // If validation passes, form will submit normally
    });

    function resetSubmitButton() {
        submitBtn.disabled = false;
        submitText.textContent = 'Update Slideshow';
        loadingSpinner.classList.add('hidden');
    }

    function showAlert(message, type = 'info') {
        // Remove existing dynamic alerts
        const existingAlerts = document.querySelectorAll('.dynamic-alert');
        existingAlerts.forEach(alert => alert.remove());

        const alertDiv = document.createElement('div');
        alertDiv.className = `dynamic-alert alert alert-${type}`;
        
        const iconPaths = {
            danger: 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
            success: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        };

        alertDiv.innerHTML = `
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPaths[type]}"/>
            </svg>
            <div class="alert-content">${message}</div>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;

        const header = document.querySelector('.page-header');
        header.parentNode.insertBefore(alertDiv, header.nextSibling);

        // Auto remove after 5 seconds for non-error alerts
        if (type !== 'danger') {
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    }

    // Preview tab functionality
    previewTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Update active tab
            previewTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Update active content
            previewContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === targetTab + '-preview') {
                    content.classList.add('active');
                }
            });
        });
    });
    
    // Update preview text when title/description changes
    function updatePreviewText() {
        const title = titleInput.value.trim() || '{{ $slideshow->title }}';
        const description = descriptionInput.value.trim() || '{{ $slideshow->description ?: "This is how your updated slideshow will appear on the homepage." }}';
        
        slideshowTitlePreview.textContent = title;
        slideshowDescPreview.textContent = description;
        mobileTitlePreview.textContent = title;
        mobileDescPreview.textContent = description;
    }
    
    // Listen for title and description changes
    titleInput.addEventListener('input', updatePreviewText);
    descriptionInput.addEventListener('input', updatePreviewText);
    
    // Auto-focus title field
    titleInput.focus();

    // Auto-hide existing alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert:not(.dynamic-alert)').forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        });
    }, 5000);
});
</script>
@endpush