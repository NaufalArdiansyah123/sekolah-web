@extends('layouts.admin')

@section('content')
<style>
    /* Enhanced Upload Form Styles */
    .upload-container {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .dark .upload-container {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    /* File Upload Styles */
    .file-upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: var(--bg-secondary);
        position: relative;
        overflow: hidden;
    }
    
    .file-upload-area:hover {
        border-color: var(--accent-color);
        background: rgba(59, 130, 246, 0.05);
    }
    
    .file-upload-area.dragover {
        border-color: var(--accent-color);
        background: rgba(59, 130, 246, 0.1);
        transform: scale(1.02);
    }
    
    .file-upload-input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    
    .file-upload-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1rem;
        color: var(--text-secondary);
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
    
    .file-preview {
        margin-top: 1rem;
        padding: 1rem;
        background: var(--bg-tertiary);
        border-radius: 8px;
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
        width: 48px;
        height: 48px;
        background: var(--accent-color);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .file-details h4 {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    
    .file-details p {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    /* Checkbox Styles */
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .checkbox-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--border-color);
        border-radius: 4px;
        background: var(--bg-primary);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .checkbox-input:checked {
        background: var(--accent-color);
        border-color: var(--accent-color);
    }
    
    .checkbox-label {
        color: var(--text-primary);
        font-weight: 500;
        cursor: pointer;
    }
    
    /* Button Styles */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .btn-primary {
        background: var(--accent-color);
        color: white;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }
    
    .btn-secondary:hover {
        background: var(--bg-secondary);
        transform: translateY(-1px);
    }
    
    /* Progress Bar */
    .upload-progress {
        margin-top: 1rem;
        display: none;
    }
    
    .upload-progress.show {
        display: block;
    }
    
    .progress-bar {
        width: 100%;
        height: 8px;
        background: var(--bg-tertiary);
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--accent-color), #10b981);
        border-radius: 4px;
        transition: width 0.3s ease;
        width: 0%;
    }
    
    .progress-text {
        text-align: center;
        margin-top: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .upload-container {
            padding: 1.5rem;
        }
        
        .file-upload-area {
            padding: 2rem 1rem;
        }
    }
</style>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Upload Video</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Upload video dokumentasi atau kegiatan sekolah</p>
        </div>
        <a href="{{ route('admin.videos.index') }}" 
           class="btn btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Upload Form -->
    <div class="upload-container">
        <form method="POST" action="{{ route('admin.videos.store') }}" enctype="multipart/form-data" id="uploadForm">
            @csrf
            
            <!-- Video File Upload -->
            <div class="form-group">
                <label class="form-label">Video File *</label>
                <div class="file-upload-area" id="fileUploadArea">
                    <input type="file" 
                           name="video_file" 
                           id="videoFile"
                           class="file-upload-input"
                           accept="video/*"
                           required>
                    
                    <div class="file-upload-content">
                        <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <div class="file-upload-text">Klik untuk memilih video atau drag & drop</div>
                        <div class="file-upload-hint">
                            Mendukung MP4, AVI, MOV, WMV, FLV, WebM, MKV, 3GP<br>
                            <strong>Max: {{ ini_get('upload_max_filesize') }} per file, {{ ini_get('post_max_size') }} total</strong>
                        </div>
                    </div>
                </div>
                
                <!-- File Preview -->
                <div class="file-preview" id="filePreview">
                    <div class="file-info">
                        <div class="file-icon">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                            </svg>
                        </div>
                        <div class="file-details">
                            <h4 id="fileName"></h4>
                            <p id="fileSize"></p>
                        </div>
                    </div>
                </div>
                
                <!-- Upload Progress -->
                <div class="upload-progress" id="uploadProgress">
                    <div class="progress-bar">
                        <div class="progress-fill" id="progressFill"></div>
                    </div>
                    <div class="progress-text" id="progressText">Uploading... 0%</div>
                </div>
                
                @error('video_file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Video Title -->
            <div class="form-group">
                <label for="title" class="form-label">Judul Video *</label>
                <input type="text" 
                       name="title" 
                       id="title"
                       class="form-input"
                       value="{{ old('title') }}"
                       placeholder="Masukkan judul video"
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" 
                          id="description"
                          class="form-input form-textarea"
                          placeholder="Masukkan deskripsi video (opsional)">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category and Status Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div class="form-group">
                    <label for="category" class="form-label">Kategori *</label>
                    <select name="category" 
                            id="category"
                            class="form-input form-select"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select name="status" 
                            id="status"
                            class="form-input form-select"
                            required>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ old('status', 'active') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>



            <!-- Featured Checkbox -->
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" 
                           name="is_featured" 
                           id="is_featured"
                           class="checkbox-input"
                           value="1"
                           {{ old('is_featured') ? 'checked' : '' }}>
                    <label for="is_featured" class="checkbox-label">
                        Tampilkan sebagai video unggulan
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">Video unggulan akan ditampilkan di halaman utama</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" 
                        class="btn btn-primary"
                        id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Upload Video
                </button>
                
                <a href="{{ route('admin.videos.index') }}" 
                   class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileUploadArea = document.getElementById('fileUploadArea');
    const videoFileInput = document.getElementById('videoFile');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const uploadForm = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressFill = document.getElementById('progressFill');
    const progressText = document.getElementById('progressText');

    // File upload area interactions
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
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            videoFileInput.files = files;
            handleFileSelect(files[0]);
        }
    });

    videoFileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });

    function handleFileSelect(file) {
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        filePreview.classList.add('show');
        
        // Auto-fill title if empty
        const titleInput = document.getElementById('title');
        if (!titleInput.value) {
            const nameWithoutExt = file.name.replace(/\.[^/.]+$/, "");
            titleInput.value = nameWithoutExt;
        }
    }

    function formatFileSize(bytes) {
        const units = ['B', 'KB', 'MB', 'GB'];
        let size = bytes;
        let unitIndex = 0;
        
        while (size >= 1024 && unitIndex < units.length - 1) {
            size /= 1024;
            unitIndex++;
        }
        
        return `${size.toFixed(2)} ${units[unitIndex]}`;
    }

    // Form submission with progress simulation
    uploadForm.addEventListener('submit', function(e) {
        if (videoFileInput.files.length > 0) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Uploading...
            `;
            
            uploadProgress.classList.add('show');
            
            // Simulate upload progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 90) progress = 90;
                
                progressFill.style.width = progress + '%';
                progressText.textContent = `Uploading... ${Math.round(progress)}%`;
                
                if (progress >= 90) {
                    clearInterval(interval);
                    progressText.textContent = 'Processing video...';
                }
            }, 200);
        }
    });
});
</script>
@endsection