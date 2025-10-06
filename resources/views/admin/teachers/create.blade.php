@extends('layouts.admin')

@section('title', 'Add New Teacher')

@section('content')
<style>
    .create-container {
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
        background: var(--bg-primary);
        backdrop-filter: blur(15px);
        padding: 1.5rem 2rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .page-title {
        color: var(--text-primary);
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        transition: color 0.3s ease;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin: 0;
        transition: color 0.3s ease;
    }

    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px var(--shadow-color);
        color: var(--text-primary);
        text-decoration: none;
    }

    .form-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        max-width: 800px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .form-label.required::after {
        content: ' *';
        color: #ef4444;
    }

    .form-control {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        width: 100%;
    }

    .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
        background: var(--bg-primary);
    }

    .form-select {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        width: 100%;
    }

    .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
        background: var(--bg-primary);
    }

    .textarea {
        min-height: 100px;
        resize: vertical;
    }

    .file-upload-area {
        border: 3px dashed var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .file-upload-area:hover {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
    }

    .file-upload-area.dragover {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
        transform: scale(1.02);
    }

    .upload-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: #10b981;
    }

    .dark .upload-icon {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .upload-text {
        color: var(--text-primary);
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .upload-subtext {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1rem;
        transition: color 0.3s ease;
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

    .preview-container {
        margin-top: 1rem;
        display: none;
    }

    .preview-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid var(--border-color);
        margin: 0 auto;
        display: block;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
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

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .form-control.is-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .create-container {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            padding: 1.25rem;
        }

        .form-container {
            padding: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
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

<div class="create-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Add New Teacher</h1>
            <p class="page-subtitle">Create a new teacher profile</p>
        </div>
        <a href="{{ route('admin.teachers.index') }}" class="btn-secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Teachers
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data" class="form-container" id="teacherForm">
        @csrf
        
        <!-- Personal Information -->
        <div class="form-section">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Personal Information
            </h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="form-label required">Full Name</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           placeholder="Enter full name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nip" class="form-label">NIP (Employee ID)</label>
                    <input type="text" 
                           class="form-control @error('nip') is-invalid @enderror" 
                           id="nip" 
                           name="nip" 
                           value="{{ old('nip') }}" 
                           placeholder="Enter NIP">
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email" class="form-label required">Email Address</label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="Enter email address">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           placeholder="Enter phone number">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control textarea @error('address') is-invalid @enderror" 
                          id="address" 
                          name="address" 
                          placeholder="Enter complete address">{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Professional Information -->
        <div class="form-section">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                </svg>
                Professional Information
            </h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="position" class="form-label required">Position</label>
                    <select class="form-select @error('position') is-invalid @enderror" 
                            id="position" 
                            name="position" 
                            required>
                        <option value="">Select Position</option>
                        @php
                            // Check if Kepala Sekolah already exists
                            $hasKepalaSekolah = \App\Models\Teacher::where('position', 'Kepala Sekolah')
                                                                  ->where('status', 'active')
                                                                  ->exists();
                            
                            // Check if Wakil Kepala Sekolah already exists
                            $hasWakilKepalaSekolah = \App\Models\Teacher::where('position', 'Wakil Kepala Sekolah')
                                                                       ->where('status', 'active')
                                                                       ->exists();
                        @endphp
                        
                        @if(!$hasKepalaSekolah)
                            <option value="Kepala Sekolah" {{ old('position') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        @endif
                        
                        @if(!$hasWakilKepalaSekolah)
                            <option value="Wakil Kepala Sekolah" {{ old('position') == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala Sekolah</option>
                        @endif
                        
                        <option value="Guru Mata Pelajaran" {{ old('position') == 'Guru Mata Pelajaran' ? 'selected' : '' }}>Guru Mata Pelajaran</option>
                        <option value="Guru Bengkel" {{ old('position') == 'Guru Bengkel' ? 'selected' : '' }}>Guru Bengkel</option>
                        <option value="Guru BK" {{ old('position') == 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
                    </select>
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    @if($hasKepalaSekolah && $hasWakilKepalaSekolah)
                        <small class="text-warning mt-2 d-block">
                            <i class="fas fa-info-circle"></i> Kepala Sekolah dan Wakil Kepala Sekolah sudah ada. Hanya dapat memilih posisi guru.
                        </small>
                    @elseif($hasKepalaSekolah)
                        <small class="text-warning mt-2 d-block">
                            <i class="fas fa-info-circle"></i> Kepala Sekolah sudah ada. Posisi tidak tersedia.
                        </small>
                    @elseif($hasWakilKepalaSekolah)
                        <small class="text-warning mt-2 d-block">
                            <i class="fas fa-info-circle"></i> Wakil Kepala Sekolah sudah ada. Posisi tidak tersedia.
                        </small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="status" class="form-label required">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" 
                            name="status" 
                            required>
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="subject" class="form-label required">Subject(s) Taught</label>
                <input type="text" 
                       class="form-control @error('subject') is-invalid @enderror" 
                       id="subject" 
                       name="subject" 
                       value="{{ old('subject') }}" 
                       required 
                       placeholder="e.g., Mathematics, Physics, Chemistry (separate with commas)">
                <small style="color: var(--text-tertiary); font-size: 0.8rem; margin-top: 0.25rem; display: block;">
                    Separate multiple subjects with commas
                </small>
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="education" class="form-label">Education Background</label>
                <input type="text" 
                       class="form-control @error('education') is-invalid @enderror" 
                       id="education" 
                       name="education" 
                       value="{{ old('education') }}" 
                       placeholder="e.g., S1 Pendidikan Matematika, Universitas ABC">
                @error('education')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Photo Upload -->
        <div class="form-section">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Profile Photo
            </h2>
            
            <div class="form-group">
                <label class="form-label">Photo</label>
                <div class="file-upload-area" id="fileUploadArea">
                    <div class="upload-icon">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="upload-text">Drop photo here or click to browse</div>
                    <div class="upload-subtext">
                        Supports: JPEG, PNG, JPG, GIF (Max: 1MB)
                    </div>
                    <input type="file" 
                           class="file-input @error('photo') is-invalid @enderror" 
                           id="photo" 
                           name="photo" 
                           accept="image/jpeg,image/png,image/jpg,image/gif">
                </div>
                
                <div class="preview-container" id="previewContainer">
                    <img id="previewImage" class="preview-image" src="" alt="Preview">
                </div>
                
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn-primary" id="submitBtn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Create Teacher
            </button>
            <a href="{{ route('admin.teachers.index') }}" class="btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('photo');
    const fileUploadArea = document.getElementById('fileUploadArea');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const submitBtn = document.getElementById('submitBtn');
    const teacherForm = document.getElementById('teacherForm');

    // File input change event
    fileInput.addEventListener('change', function(e) {
        handleFile(e.target.files[0]);
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
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            // Update file input
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            handleFile(file);
        }
    });

    function handleFile(file) {
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    // Form submission with loading state
    teacherForm.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Creating...
        `;
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