@extends('layouts.admin')

@section('title', 'Edit Facility')

@section('content')
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
    .facility-edit-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
    }

    /* Header Section */
    .page-header {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px var(--shadow-color);
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
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

    .btn-primary:hover {
        background: var(--accent-hover);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
    }

    .btn-success {
        background: var(--success-color);
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-warning {
        background: var(--warning-color);
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Form Section */
    .form-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px var(--shadow-color);
    }

    .form-header {
        background: var(--bg-tertiary);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-body {
        padding: 2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .required {
        color: var(--danger-color);
    }

    .form-input {
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.75rem;
        font-size: 0.875rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: border-color 0.15s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-help {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
    }

    /* Current Image Display */
    .current-image {
        margin-bottom: 1rem;
    }

    .current-image img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        object-fit: cover;
    }

    .current-image-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        display: block;
    }

    /* File Upload */
    .file-upload {
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.15s ease;
        cursor: pointer;
        position: relative;
    }

    .file-upload:hover {
        border-color: var(--accent-color);
        background: rgba(59, 130, 246, 0.05);
    }

    .file-upload.dragover {
        border-color: var(--accent-color);
        background: rgba(59, 130, 246, 0.1);
    }

    .file-upload input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-icon {
        width: 3rem;
        height: 3rem;
        background: var(--bg-tertiary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--text-secondary);
    }

    .upload-text {
        color: var(--text-primary);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    /* Image Preview */
    .image-preview {
        margin-top: 1rem;
        text-align: center;
    }

    .preview-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        object-fit: cover;
    }

    .remove-image {
        margin-top: 0.5rem;
        background: var(--danger-color);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.75rem;
        cursor: pointer;
    }

    /* Features List */
    .features-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .feature-item {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .feature-input {
        flex: 1;
    }

    .remove-feature {
        background: var(--danger-color);
        color: white;
        border: none;
        padding: 0.5rem;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .add-feature {
        background: var(--success-color);
        color: white;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Form Actions */
    .form-actions {
        background: var(--bg-tertiary);
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    /* Alerts */
    .alert {
        border-radius: 8px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
        margin-left: auto;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* Error States */
    .form-input.error {
        border-color: var(--danger-color);
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .error-message {
        color: var(--danger-color);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .facility-edit-page {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
            padding: 1.5rem;
        }
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

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
</style>

<div class="facility-edit-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-top">
            <div>
                <h1 class="page-title">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Facility
                </h1>
                <p class="page-subtitle">Update facility information and settings</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.facilities.show', $facility) }}" class="btn btn-warning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View Facility
                </a>
                <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Facilities
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if($errors->any())
        <div class="alert alert-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 0.5rem 0 0 0; padding-left: 1rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    <!-- Form Section -->
    <div class="form-section">
        <div class="form-header">
            <h2 class="form-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                </svg>
                Update Facility Information
            </h2>
        </div>

        <form action="{{ route('admin.facilities.update', $facility) }}" method="POST" enctype="multipart/form-data" id="facilityForm">
            @csrf
            @method('PUT')
            
            <div class="form-body">
                <div class="form-grid">
                    <!-- Facility Name -->
                    <div class="form-group">
                        <label class="form-label">
                            Facility Name <span class="required">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $facility->name) }}" class="form-input {{ $errors->has('name') ? 'error' : '' }}" placeholder="Enter facility name" required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Enter a clear and descriptive name for the facility</div>
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label class="form-label">
                            Category <span class="required">*</span>
                        </label>
                        <select name="category" class="form-input {{ $errors->has('category') ? 'error' : '' }}" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category', $facility->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Choose the most appropriate category</div>
                    </div>

                    <!-- Location -->
                    <div class="form-group">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location', $facility->location) }}" class="form-input {{ $errors->has('location') ? 'error' : '' }}" placeholder="e.g., Building A, Floor 2">
                        @error('location')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Specify the location within the school</div>
                    </div>

                    <!-- Capacity -->
                    <div class="form-group">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $facility->capacity) }}" class="form-input {{ $errors->has('capacity') ? 'error' : '' }}" placeholder="e.g., 50" min="1">
                        @error('capacity')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Maximum number of people the facility can accommodate</div>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label class="form-label">
                            Status <span class="required">*</span>
                        </label>
                        <select name="status" class="form-input {{ $errors->has('status') ? 'error' : '' }}" required>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $facility->status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Current operational status of the facility</div>
                    </div>

                    <!-- Is Featured -->
                    <div class="form-group">
                        <label class="form-label">Featured Facility</label>
                        <select name="is_featured" class="form-input">
                            <option value="0" {{ old('is_featured', $facility->is_featured ? '1' : '0') == '0' ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('is_featured', $facility->is_featured ? '1' : '0') == '1' ? 'selected' : '' }}>Yes</option>
                        </select>
                        <div class="form-help">Featured facilities will be highlighted on the public page</div>
                    </div>

                    <!-- Description -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            Description <span class="required">*</span>
                        </label>
                        <textarea name="description" class="form-input form-textarea {{ $errors->has('description') ? 'error' : '' }}" placeholder="Describe the facility, its purpose, and key features..." required>{{ old('description', $facility->description) }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Provide a detailed description of the facility</div>
                    </div>

                    <!-- Features -->
                    <div class="form-group full-width">
                        <label class="form-label">Fitur</label>
                        <div class="features-list" id="featuresList">
                            @php
                                $features = old('features', $facility->features ?: []);
                                if (empty($features)) {
                                    $features = [''];
                                }
                            @endphp
                            @foreach($features as $index => $feature)
                                <div class="feature-item">
                                    <input type="text" name="features[]" value="{{ $feature }}" class="form-input feature-input" placeholder="Enter a feature">
                                    <button type="button" class="remove-feature" onclick="removeFeature(this)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="add-feature" onclick="addFeature()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Feature
                        </button>
                        <div class="form-help">List the key features and amenities of this facility</div>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-group full-width">
                        <label class="form-label">Facility Image</label>
                        
                        @if($facility->image)
                            <div class="current-image">
                                <span class="current-image-label">Current Image:</span>
                                <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}">
                            </div>
                        @endif
                        
                        <div class="file-upload" id="fileUpload">
                            <input type="file" name="image" accept="image/*" id="imageInput" onchange="previewImage(this)">
                            <div class="upload-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="upload-text">{{ $facility->image ? 'Click to replace image' : 'Click to upload or drag and drop' }}</div>
                            <div class="upload-hint">PNG, JPG, GIF up to 2MB</div>
                        </div>
                        @error('image')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div id="imagePreview" class="image-preview" style="display: none;">
                            <img id="previewImg" class="preview-image" src="" alt="Preview">
                            <br>
                            <button type="button" class="remove-image" onclick="removeImage()">Remove New Image</button>
                        </div>
                        <div class="form-help">{{ $facility->image ? 'Upload a new image to replace the current one' : 'Upload a high-quality image that represents the facility' }}</div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Facility
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload drag and drop
    const fileUpload = document.getElementById('fileUpload');
    const fileInput = document.getElementById('imageInput');

    fileUpload.addEventListener('dragover', function(e) {
        e.preventDefault();
        fileUpload.classList.add('dragover');
    });

    fileUpload.addEventListener('dragleave', function(e) {
        e.preventDefault();
        fileUpload.classList.remove('dragover');
    });

    fileUpload.addEventListener('drop', function(e) {
        e.preventDefault();
        fileUpload.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            previewImage(fileInput);
        }
    });
});

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const fileInput = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    
    fileInput.value = '';
    preview.style.display = 'none';
}

function addFeature() {
    const featuresList = document.getElementById('featuresList');
    const featureItem = document.createElement('div');
    featureItem.className = 'feature-item';
    featureItem.innerHTML = `
        <input type="text" name="features[]" class="form-input feature-input" placeholder="Enter a feature">
        <button type="button" class="remove-feature" onclick="removeFeature(this)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    featuresList.appendChild(featureItem);
}

function removeFeature(button) {
    const featuresList = document.getElementById('featuresList');
    if (featuresList.children.length > 1) {
        button.parentElement.remove();
    }
}

// Form submission handling
document.getElementById('facilityForm').addEventListener('submit', function(e) {
    const submitButton = document.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner"></span> Updating...';
    
    // Re-enable after 10 seconds as fallback
    setTimeout(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }, 10000);
});
</script>
@endsection