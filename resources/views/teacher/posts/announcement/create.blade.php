@extends('layouts.teacher')

@section('title', 'Create Announcement')

@section('content')
<style>
    .announcement-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
        position: relative;
        overflow: hidden;
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
        text-align: center;
        width: 100%;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .form-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .form-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
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
        transition: color 0.3s ease;
    }

    .form-label .required {
        color: #dc2626;
        margin-left: 0.25rem;
    }

    .form-control {
        width: 100%;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        resize: vertical;
    }

    .form-control:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .invalid-feedback {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: block;
    }

    .form-select {
        width: 100%;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
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

    .form-select.is-invalid {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    /* Dark mode form adjustments */
    .dark .form-control,
    .dark .form-select {
        background: var(--bg-secondary);
        border-color: var(--border-color);
        color: var(--text-primary);
    }

    .dark .form-control:focus,
    .dark .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .dark .form-control.is-invalid,
    .dark .form-select.is-invalid {
        border-color: #f87171;
        box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.1);
    }

    .dark .invalid-feedback {
        color: #f87171;
    }

    .textarea-large {
        min-height: 200px;
        font-family: inherit;
        line-height: 1.6;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
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
        transform: translateY(-1px);
    }

    .btn-success {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.2);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3);
    }

    /* Dark mode button adjustments */
    .dark .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .dark .btn-secondary:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border-color: var(--border-color);
    }

    .dark .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .dark .btn-success:hover {
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }

    .form-help {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
        transition: color 0.3s ease;
    }

    .priority-info {
        background: var(--bg-secondary);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
        border: 1px solid var(--border-color);
    }

    .priority-info h6 {
        color: var(--text-primary);
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .priority-info ul {
        margin: 0;
        padding-left: 1rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .priority-info li {
        margin-bottom: 0.25rem;
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
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

    /* Dark mode alert adjustments */
    .dark .alert-danger {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .announcement-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .form-container {
            padding: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
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
</style>

<div class="announcement-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create New Announcement
            </h1>
            <p class="page-subtitle">Share important information with the school community</p>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 0.5rem 0 0 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="form-container">
        <form action="{{ route('teacher.posts.announcement.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-row">
                <!-- Left Column -->
                <div>
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Title<span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" 
                               required
                               placeholder="Enter announcement title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Choose a clear and descriptive title for your announcement</div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="form-label">
                            Content<span class="required">*</span>
                        </label>
                        <textarea name="content" 
                                  id="content" 
                                  class="form-control textarea-large @error('content') is-invalid @enderror" 
                                  required
                                  placeholder="Write your announcement content here...">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Provide detailed information about your announcement</div>
                    </div>

                    <div class="form-group">
                        <label for="featured_image" class="form-label">
                            Featured Image
                        </label>
                        <input type="file" 
                               name="featured_image" 
                               id="featured_image" 
                               class="form-control @error('featured_image') is-invalid @enderror"
                               accept="image/*">
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Upload an image to make your announcement more engaging (optional)</div>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <div class="form-group">
                        <label for="category" class="form-label">
                            Category<span class="required">*</span>
                        </label>
                        <select name="category" 
                                id="category" 
                                class="form-select @error('category') is-invalid @enderror" 
                                required>
                            <option value="">Select Category</option>
                            <option value="akademik" {{ old('category') === 'akademik' ? 'selected' : '' }}>Academic</option>
                            <option value="kegiatan" {{ old('category') === 'kegiatan' ? 'selected' : '' }}>Activities</option>
                            <option value="administrasi" {{ old('category') === 'administrasi' ? 'selected' : '' }}>Administration</option>
                            <option value="umum" {{ old('category') === 'umum' ? 'selected' : '' }}>General</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="priority" class="form-label">
                            Priority<span class="required">*</span>
                        </label>
                        <select name="priority" 
                                id="priority" 
                                class="form-select @error('priority') is-invalid @enderror" 
                                required>
                            <option value="">Select Priority</option>
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="normal" {{ old('priority', 'normal') === 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <div class="priority-info">
                            <h6>Priority Guidelines:</h6>
                            <ul>
                                <li><strong>Low:</strong> General information, non-urgent updates</li>
                                <li><strong>Normal:</strong> Regular school announcements</li>
                                <li><strong>High:</strong> Important deadlines, events</li>
                                <li><strong>Urgent:</strong> Emergency notices, immediate action required</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="author" class="form-label">
                            Author<span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="author" 
                               id="author" 
                               class="form-control @error('author') is-invalid @enderror" 
                               value="{{ old('author', auth()->user()->name ?? '') }}" 
                               required>
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">
                            Status<span class="required">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                class="form-select @error('status') is-invalid @enderror" 
                                required>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Draft: Save for later editing | Published: Make visible to everyone</div>
                    </div>

                    <div class="form-group">
                        <label for="published_at" class="form-label">
                            Publication Date
                        </label>
                        <input type="datetime-local" 
                               name="published_at" 
                               id="published_at" 
                               class="form-control @error('published_at') is-invalid @enderror" 
                               value="{{ old('published_at', now()->format('Y-m-d\\TH:i')) }}">
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">When should this announcement be published?</div>
                    </div>

                    <div class="form-group">
                        <label for="expires_at" class="form-label">
                            Expiration Date
                        </label>
                        <input type="datetime-local" 
                               name="expires_at" 
                               id="expires_at" 
                               class="form-control @error('expires_at') is-invalid @enderror" 
                               value="{{ old('expires_at') }}">
                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Optional: When should this announcement be automatically hidden?</div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('teacher.posts.announcement') }}" class="btn btn-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Announcements
                </a>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" name="action" value="draft" class="btn btn-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Save as Draft
                    </button>
                    <button type="submit" name="action" value="publish" class="btn btn-success">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Publish Announcement
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-adjust textarea height
    const textarea = document.getElementById('content');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.max(200, this.scrollHeight) + 'px';
        });
    }

    // Form submission handling
    const form = document.querySelector('form');
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        const clickedButton = e.submitter;
        if (clickedButton) {
            const action = clickedButton.getAttribute('name') === 'action' ? clickedButton.value : 'publish';
            
            // Update status field based on action
            const statusField = document.getElementById('status');
            if (action === 'draft') {
                statusField.value = 'draft';
            } else if (action === 'publish') {
                statusField.value = 'published';
            }
            
            // Show loading state
            submitButtons.forEach(btn => {
                btn.disabled = true;
                if (btn === clickedButton) {
                    const originalText = btn.innerHTML;
                    btn.innerHTML = `
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        ${action === 'draft' ? 'Saving...' : 'Publishing...'}
                    `;
                }
            });
        }
    });

    // Priority change handler
    const prioritySelect = document.getElementById('priority');
    prioritySelect.addEventListener('change', function() {
        const priorityInfo = document.querySelector('.priority-info');
        if (this.value) {
            priorityInfo.style.display = 'block';
        }
    });

    // File input preview
    const fileInput = document.getElementById('featured_image');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Remove existing preview
                const existingPreview = document.querySelector('.image-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }

                // Create new preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.style.cssText = `
                        margin-top: 0.5rem;
                        border: 1px solid var(--border-color);
                        border-radius: 8px;
                        padding: 0.5rem;
                        background: var(--bg-secondary);
                        transition: all 0.3s ease;
                    `;
                    preview.innerHTML = `
                        <img src="${e.target.result}" 
                             style="max-width: 100%; height: auto; border-radius: 4px; max-height: 200px;" 
                             alt="Preview">
                        <div style="margin-top: 0.5rem; font-size: 0.75rem; color: var(--text-secondary);">
                            ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)
                        </div>
                    `;
                    fileInput.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    }

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