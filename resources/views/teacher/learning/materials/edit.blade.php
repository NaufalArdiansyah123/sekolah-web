@extends('layouts.teacher')

@section('title', 'Edit Learning Material')

@section('content')
<style>
    .materials-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .header-info {
        flex: 1;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .breadcrumb a {
        color: white;
        text-decoration: none;
        transition: opacity 0.3s ease;
    }

    .breadcrumb a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-shrink: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Form Container */
    .form-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 2px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label.required::after {
        content: '*';
        color: #ef4444;
        font-weight: 700;
    }

    .form-input {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        resize: vertical;
    }

    .form-input:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    .form-input::placeholder {
        color: var(--text-tertiary);
    }

    .form-select {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* Current File Display */
    .current-file {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        margin-bottom: 1rem;
    }

    .current-file-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .current-file-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .current-file-info {
        flex: 1;
    }

    .current-file-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .current-file-meta {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .current-file-actions {
        display: flex;
        gap: 0.5rem;
    }

    .file-action-btn {
        padding: 0.5rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        color: white;
        font-size: 0.875rem;
    }

    .btn-view {
        background: #059669;
    }

    .btn-view:hover {
        background: #047857;
        transform: scale(1.05);
    }

    /* File Upload */
    .file-upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        background: var(--bg-secondary);
    }

    .file-upload-area:hover {
        border-color: #059669;
        background: rgba(5, 150, 105, 0.05);
    }

    .file-upload-area.dragover {
        border-color: #059669;
        background: rgba(5, 150, 105, 0.1);
        transform: scale(1.02);
    }

    .file-upload-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.5rem;
    }

    .file-upload-text {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .file-upload-hint {
        color: var(--text-secondary);
        font-size: 0.875rem;
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

    .file-preview {
        margin-top: 1rem;
        padding: 1rem;
        background: var(--bg-primary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        display: none;
    }

    .file-preview.show {
        display: block;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .file-details {
        flex: 1;
    }

    .file-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .file-size {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .file-remove {
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-remove:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    /* Material Type Selection */
    .type-selection {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }

    .type-option {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--bg-primary);
    }

    .type-option:hover {
        border-color: #059669;
        transform: translateY(-2px);
    }

    .type-option.selected {
        border-color: #059669;
        background: rgba(5, 150, 105, 0.1);
    }

    .type-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .type-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .type-input {
        display: none;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
        margin-top: 2rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-outline {
        background: transparent;
        color: var(--text-primary);
        border: 2px solid var(--border-color);
    }

    .btn-outline:hover {
        background: var(--bg-secondary);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .materials-container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .form-container {
            padding: 1.5rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .type-selection {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-actions {
            flex-direction: column;
        }

        .current-file-header {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .type-selection {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .form-container {
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

    /* Validation Styles */
    .form-input.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .error-message {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .success-message {
        color: #059669;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
</style>

<div class="materials-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <div class="breadcrumb">
                    <a href="{{ route('teacher.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('teacher.learning.materials.index') }}">Learning Materials</a>
                    <span>/</span>
                    <span>Edit Material</span>
                </div>
                <h1 class="page-title">
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Learning Material
                </h1>
                <p class="page-subtitle">Update and modify educational content for your students</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('teacher.learning.materials.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Materials
                </a>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ route('teacher.learning.materials.update', $material->id) }}" method="POST" enctype="multipart/form-data" id="materialForm">
        @csrf
        @method('PUT')
        
        <div class="form-container">
            <!-- Basic Information Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Basic Information
                </h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Material Title</label>
                        <input type="text" 
                               name="title" 
                               class="form-input" 
                               placeholder="Enter material title..."
                               value="{{ old('title', $material->title) }}"
                               required>
                        @error('title')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Subject</label>
                        <select name="subject" class="form-select" required>
                            <option value="">Select Subject</option>
                            <option value="Matematika" {{ old('subject', $material->subject) == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                            <option value="Fisika" {{ old('subject', $material->subject) == 'Fisika' ? 'selected' : '' }}>Fisika</option>
                            <option value="Biologi" {{ old('subject', $material->subject) == 'Biologi' ? 'selected' : '' }}>Biologi</option>
                            <option value="Kimia" {{ old('subject', $material->subject) == 'Kimia' ? 'selected' : '' }}>Kimia</option>
                            <option value="Bahasa Indonesia" {{ old('subject', $material->subject) == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            <option value="Bahasa Inggris" {{ old('subject', $material->subject) == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="Sejarah" {{ old('subject', $material->subject) == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                            <option value="Geografi" {{ old('subject', $material->subject) == 'Geografi' ? 'selected' : '' }}>Geografi</option>
                            <option value="Ekonomi" {{ old('subject', $material->subject) == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                            <option value="Sosiologi" {{ old('subject', $material->subject) == 'Sosiologi' ? 'selected' : '' }}>Sosiologi</option>
                        </select>
                        @error('subject')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Class</label>
                        <select name="class" class="form-select" required>
                            <option value="">Select Class</option>
                            <option value="X IPA 1" {{ old('class', $material->class) == 'X IPA 1' ? 'selected' : '' }}>X IPA 1</option>
                            <option value="X IPA 2" {{ old('class', $material->class) == 'X IPA 2' ? 'selected' : '' }}>X IPA 2</option>
                            <option value="X IPS 1" {{ old('class', $material->class) == 'X IPS 1' ? 'selected' : '' }}>X IPS 1</option>
                            <option value="X IPS 2" {{ old('class', $material->class) == 'X IPS 2' ? 'selected' : '' }}>X IPS 2</option>
                            <option value="XI IPA 1" {{ old('class', $material->class) == 'XI IPA 1' ? 'selected' : '' }}>XI IPA 1</option>
                            <option value="XI IPA 2" {{ old('class', $material->class) == 'XI IPA 2' ? 'selected' : '' }}>XI IPA 2</option>
                            <option value="XI IPS 1" {{ old('class', $material->class) == 'XI IPS 1' ? 'selected' : '' }}>XI IPS 1</option>
                            <option value="XI IPS 2" {{ old('class', $material->class) == 'XI IPS 2' ? 'selected' : '' }}>XI IPS 2</option>
                            <option value="XII IPA 1" {{ old('class', $material->class) == 'XII IPA 1' ? 'selected' : '' }}>XII IPA 1</option>
                            <option value="XII IPA 2" {{ old('class', $material->class) == 'XII IPA 2' ? 'selected' : '' }}>XII IPA 2</option>
                            <option value="XII IPS 1" {{ old('class', $material->class) == 'XII IPS 1' ? 'selected' : '' }}>XII IPS 1</option>
                            <option value="XII IPS 2" {{ old('class', $material->class) == 'XII IPS 2' ? 'selected' : '' }}>XII IPS 2</option>
                        </select>
                        @error('class')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ old('status', $material->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $material->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Description</label>
                        <textarea name="description" 
                                  class="form-input form-textarea" 
                                  placeholder="Enter material description..."
                                  rows="4">{{ old('description', $material->description) }}</textarea>
                        @error('description')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Material Type Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M13 13h4a2 2 0 012 2v4a2 2 0 01-2 2h-4m-6-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v4a2 2 0 01-2 2h-4z"/>
                    </svg>
                    Material Type
                </h2>
                
                <div class="type-selection">
                    <label class="type-option" for="type-document">
                        <input type="radio" name="type" value="document" class="type-input" id="type-document" {{ old('type', $material->type) == 'document' ? 'checked' : '' }}>
                        <div class="type-icon">📄</div>
                        <div class="type-label">Document</div>
                    </label>
                    
                    <label class="type-option" for="type-video">
                        <input type="radio" name="type" value="video" class="type-input" id="type-video" {{ old('type', $material->type) == 'video' ? 'checked' : '' }}>
                        <div class="type-icon">🎥</div>
                        <div class="type-label">Video</div>
                    </label>
                    
                    <label class="type-option" for="type-presentation">
                        <input type="radio" name="type" value="presentation" class="type-input" id="type-presentation" {{ old('type', $material->type) == 'presentation' ? 'checked' : '' }}>
                        <div class="type-icon">📊</div>
                        <div class="type-label">Presentation</div>
                    </label>
                    
                    <label class="type-option" for="type-exercise">
                        <input type="radio" name="type" value="exercise" class="type-input" id="type-exercise" {{ old('type', $material->type) == 'exercise' ? 'checked' : '' }}>
                        <div class="type-icon">📝</div>
                        <div class="type-label">Exercise</div>
                    </label>
                    
                    <label class="type-option" for="type-audio">
                        <input type="radio" name="type" value="audio" class="type-input" id="type-audio" {{ old('type', $material->type) == 'audio' ? 'checked' : '' }}>
                        <div class="type-icon">🎵</div>
                        <div class="type-label">Audio</div>
                    </label>
                </div>
                @error('type')
                    <div class="error-message">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Current File Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Current File
                </h2>
                
                <div class="current-file">
                    <div class="current-file-header">
                        <div class="current-file-icon">
                            {{ $material->type_icon }}
                        </div>
                        <div class="current-file-info">
                            <div class="current-file-name">{{ $material->original_name }}</div>
                            <div class="current-file-meta">
                                {{ $material->formatted_file_size }} • 
                                Uploaded {{ $material->created_at->format('d M Y, H:i') }} • 
                                Downloaded {{ $material->downloads }} times
                            </div>
                        </div>
                        <div class="current-file-actions">
                            @if($material->file_url)
                                <a href="{{ $material->file_url }}" target="_blank" class="file-action-btn btn-view" title="View File">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Upload Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Replace File (Optional)
                </h2>
                
                <div class="file-upload-area" id="fileUploadArea">
                    <div class="file-upload-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div class="file-upload-text">Click to upload or drag and drop</div>
                    <div class="file-upload-hint">PDF, DOC, DOCX, PPT, PPTX, MP4, MP3 (Max: 50MB) - Leave empty to keep current file</div>
                    <input type="file" name="file" class="file-input" id="fileInput" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.mp3,.avi,.mov,.wmv,.wav,.m4a">
                </div>
                
                <div class="file-preview" id="filePreview">
                    <div class="file-info">
                        <div class="file-icon" id="fileIcon">📄</div>
                        <div class="file-details">
                            <div class="file-name" id="fileName"></div>
                            <div class="file-size" id="fileSize"></div>
                        </div>
                        <button type="button" class="file-remove" id="fileRemove">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                @error('file')
                    <div class="error-message">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('teacher.learning.materials.index') }}" class="btn btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Update Material
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Material type selection
    const typeOptions = document.querySelectorAll('.type-option');
    const typeInputs = document.querySelectorAll('.type-input');
    
    typeInputs.forEach(input => {
        input.addEventListener('change', function() {
            typeOptions.forEach(option => option.classList.remove('selected'));
            if (this.checked) {
                this.closest('.type-option').classList.add('selected');
            }
        });
    });
    
    // Set initial selection
    const checkedInput = document.querySelector('.type-input:checked');
    if (checkedInput) {
        checkedInput.closest('.type-option').classList.add('selected');
    }

    // File upload functionality
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileIcon = document.getElementById('fileIcon');
    const fileRemove = document.getElementById('fileRemove');

    // File type icons
    const fileIcons = {
        'pdf': '📄',
        'doc': '📝',
        'docx': '📝',
        'ppt': '📊',
        'pptx': '📊',
        'mp4': '🎥',
        'avi': '🎥',
        'mov': '🎥',
        'wmv': '🎥',
        'mp3': '🎵',
        'wav': '🎵',
        'm4a': '🎵'
    };

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Handle file selection
    function handleFileSelect(file) {
        if (file) {
            const extension = file.name.split('.').pop().toLowerCase();
            const icon = fileIcons[extension] || '📄';
            
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileIcon.textContent = icon;
            
            filePreview.classList.add('show');
            fileUploadArea.style.display = 'none';
        }
    }

    // File input change
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            handleFileSelect(this.files[0]);
        }
    });

    // File remove
    fileRemove.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.remove('show');
        fileUploadArea.style.display = 'block';
    });

    // Drag and drop functionality
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    fileUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(files[0]);
        }
    });

    // Form validation
    const form = document.getElementById('materialForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                isValid = false;
            } else {
                field.classList.remove('error');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Updating...
        `;
    });

    // Real-time validation
    const inputs = form.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('error') && this.value.trim()) {
                this.classList.remove('error');
            }
        });
    });
});
</script>
@endsection