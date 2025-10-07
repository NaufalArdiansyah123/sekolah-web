@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-forms-enhanced.css') }}">
<style>
/* Additional styles for file upload */
.file-upload-enhanced {
    position: relative;
    border: 2px dashed var(--form-gray-300);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    background: var(--form-gray-50);
    cursor: pointer;
    color: var(--form-gray-600);
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.file-upload-enhanced:hover {
    border-color: var(--form-primary-color);
    background: #f0f9ff;
    color: var(--form-primary-color);
    transform: scale(1.02);
}

.file-upload-enhanced.dragover {
    border-color: var(--form-primary-color);
    background: #eff6ff;
    transform: scale(1.02);
    box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
}

.file-upload-enhanced input[type="file"] {
    display: none;
}

.file-preview-enhanced {
    transition: all 0.3s ease;
    border: 3px solid var(--form-white);
    box-shadow: var(--form-shadow-lg);
}

.file-preview-enhanced:hover {
    transform: scale(1.05);
    box-shadow: var(--form-shadow-xl);
}

.btn-enhanced.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    border-radius: 8px;
}

/* Upload animation */
@keyframes uploadPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.file-upload-enhanced.uploading {
    animation: uploadPulse 1s infinite;
}
</style>
@endpush

@section('content')
<div class="page-container" style="background: linear-gradient(135deg, var(--form-primary-color) 0%, var(--form-secondary-color) 100%); min-height: 100vh; padding: 2rem 0;">
    <div class="form-container-enhanced">
        <!-- Enhanced Form Header -->
        <div class="form-header-enhanced">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="form-title-enhanced">
                        <i class="fas fa-building me-3"></i>Tambah Fasilitas Baru
                    </h1>
                    <p class="form-subtitle-enhanced">
                        Lengkapi informasi fasilitas sekolah yang akan ditambahkan
                    </p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.facilities.index') }}" class="btn-enhanced btn-outline-enhanced" style="background: rgba(255, 255, 255, 0.2); border: 2px solid rgba(255, 255, 255, 0.3); color: white;">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="form-body" style="padding: 2rem;">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert-enhanced alert-danger-enhanced">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <!-- Main Form Section -->
                    <div class="form-section-enhanced fade-in-enhanced">
                        <h3 class="section-title-enhanced">
                            <div class="section-icon-enhanced">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            Informasi Dasar Fasilitas
                        </h3>
                        <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" id="facilityForm" data-auto-save="30000">
                            @csrf
                            
                            <!-- Nama Fasilitas -->
                            <div class="form-group-enhanced">
                                <label for="name" class="form-label-enhanced">Nama Fasilitas <span class="required">*</span></label>
                                <input type="text" class="form-control-enhanced @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Contoh: Laboratorium Komputer" 
                                       required data-max-length="100">
                                @error('name')
                                    <div class="invalid-feedback-enhanced"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group-enhanced">
                                <label for="description" class="form-label-enhanced">Deskripsi <span class="required">*</span></label>
                                <textarea class="form-textarea-enhanced @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" 
                                          placeholder="Jelaskan fasilitas ini secara detail..." 
                                          required data-max-length="500">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback-enhanced"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                                <div class="form-text-enhanced"><i class="fas fa-info-circle"></i> Deskripsi yang baik akan membantu pengunjung memahami fasilitas</div>
                            </div>

                            <!-- Kategori dan Status -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-enhanced">
                                        <label for="category" class="form-label-enhanced">Kategori <span class="required">*</span></label>
                                        <select class="form-select-enhanced @error('category') is-invalid @enderror" 
                                                id="category" name="category" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $key => $label)
                                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback-enhanced"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-enhanced">
                                        <label for="status" class="form-label-enhanced">Status <span class="required">*</span></label>
                                        <select class="form-select-enhanced @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                            @foreach($statuses as $key => $label)
                                                <option value="{{ $key }}" {{ old('status', 'active') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="form-text-enhanced"><i class="fas fa-info-circle"></i> Fasilitas dengan status 'Aktif' akan muncul di halaman publik</div>
                                        @error('status')
                                            <div class="invalid-feedback-enhanced"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>



                    </div>
                    
                    <!-- Media Section -->
                    <div class="form-section-enhanced fade-in-enhanced">
                        <h3 class="section-title-enhanced">
                            <div class="section-icon-enhanced">
                                <i class="fas fa-image"></i>
                            </div>
                            Media & Gambar
                        </h3>
                        
                        <!-- Gambar -->
                        <div class="form-group-enhanced">
                            <label for="image" class="form-label-enhanced">Gambar Fasilitas</label>
                            
                            <!-- File Upload Area -->
                            <div class="file-upload-enhanced" data-max-size="2048" id="uploadArea">
                                <input type="file" id="image" name="image" 
                                       accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,.jpg,.jpeg,.png,.gif,.webp" 
                                       class="@error('image') is-invalid @enderror" 
                                       style="display: none;">
                                <div class="text-center" id="uploadText">
                                    <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: var(--form-gray-400);"></i>
                                    <h6>Klik atau seret gambar ke sini</h6>
                                    <p class="text-muted mb-0">Format: JPG, JPEG, PNG, GIF, WEBP. Maksimal 2MB</p>
                                </div>
                            </div>
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <div class="text-center">
                                    <img id="previewImg" src="" alt="Preview" class="file-preview-enhanced" 
                                         style="max-width: 300px; max-height: 200px; border-radius: 12px; box-shadow: var(--form-shadow-lg);">
                                    <div class="mt-2">
                                        <button type="button" class="btn-enhanced btn-danger-enhanced btn-sm" onclick="removeImage()">
                                            <i class="fas fa-trash"></i> Hapus Gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            @error('image')
                                <div class="invalid-feedback-enhanced"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                            <div class="form-text-enhanced"><i class="fas fa-info-circle"></i> Gambar akan membantu pengunjung mengenali fasilitas</div>
                            
                            <!-- Debug Info (only in development) -->
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-info" onclick="testFileInput()">
                                    <i class="fas fa-bug"></i> Test Upload
                                </button>
                                <small class="text-muted ms-2">Klik untuk test fungsi upload</small>
                            </div>
                        </div>

                    </div>
                        </form>

                </div>

                <div class="col-lg-4">
                    <!-- Help Card -->
                    <div class="form-section-enhanced fade-in-enhanced">
                        <h3 class="section-title-enhanced">
                            <div class="section-icon-enhanced">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            Panduan
                        </h3>
                        <div class="alert-enhanced alert-info-enhanced">
                            <i class="fas fa-lightbulb"></i>
                            <div>
                                <h6>Tips Menambah Fasilitas:</h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Gunakan nama yang jelas dan mudah dipahami
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Deskripsi sebaiknya menjelaskan fungsi dan keunggulan fasilitas
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Pilih kategori yang sesuai untuk memudahkan pencarian
                                    </li>
                                    <li class="mb-0">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Upload gambar berkualitas baik untuk menarik perhatian
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div class="form-section-enhanced fade-in-enhanced">
                        <h3 class="section-title-enhanced">
                            <div class="section-icon-enhanced">
                                <i class="fas fa-eye"></i>
                            </div>
                            Preview
                        </h3>
                        <div id="facility-preview">
                            <div class="text-center text-muted">
                                <i class="fas fa-building fa-3x mb-3"></i>
                                <p>Preview akan muncul saat Anda mengisi form</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Form Actions -->
        <div class="form-actions-enhanced">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.facilities.index') }}" class="btn-enhanced btn-outline-enhanced">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
                <button type="button" class="btn-enhanced btn-secondary-enhanced" onclick="resetForm()">
                    <i class="fas fa-undo"></i>Reset
                </button>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" form="facilityForm" class="btn-enhanced btn-primary-enhanced" name="action" value="save">
                    <i class="fas fa-plus"></i>Tambah Fasilitas
                </button>
                <button type="submit" form="facilityForm" class="btn-enhanced btn-success-enhanced" name="action" value="save_and_new">
                    <i class="fas fa-plus-circle"></i>Tambah & Buat Baru
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin-forms-enhanced.js') }}"></script>
<script>
$(document).ready(function() {
    // Image upload handling
    const imageInput = document.getElementById('image');
    const uploadArea = document.getElementById('uploadArea');
    const uploadText = document.getElementById('uploadText');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    // Click handler for upload area
    uploadArea.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        imageInput.click();
    });
    
    // File input change event (only one handler)
    imageInput.addEventListener('change', function(e) {
        const file = this.files[0];
        if (file) {
            console.log('File selected:', {
                name: file.name,
                type: file.type,
                size: file.size,
                lastModified: file.lastModified
            });
            
            // Validate file size (2MB = 2048KB)
            if (file.size > 2048 * 1024) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                showAlert('error', `Ukuran file terlalu besar (${sizeMB}MB). Maksimal 2MB.`);
                this.value = '';
                return;
            }
            
            // Validate file type - check both MIME type and file extension
            const allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            const fileName = file.name.toLowerCase();
            const allowedExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp'];
            const hasValidExtension = allowedExtensions.some(ext => fileName.endsWith(ext));
            const hasValidMimeType = allowedMimeTypes.includes(file.type);
            
            console.log('File validation:', {
                fileName: fileName,
                mimeType: file.type,
                hasValidExtension: hasValidExtension,
                hasValidMimeType: hasValidMimeType
            });
            
            // More lenient validation - accept if either MIME type OR extension is valid
            if (!hasValidMimeType && !hasValidExtension) {
                showAlert('error', `Format file tidak didukung.<br>File: <strong>${file.name}</strong><br>Tipe: <strong>${file.type || 'Tidak terdeteksi'}</strong><br><br>Format yang didukung: JPG, JPEG, PNG, GIF, WEBP`);
                this.value = '';
                return;
            }
            
            // Show warning if MIME type is not detected but extension is valid
            if (!hasValidMimeType && hasValidExtension) {
                showAlert('warning', `Tipe file tidak terdeteksi oleh browser, tapi ekstensi valid. Melanjutkan upload...`);
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
                uploadText.style.display = 'none';
                updatePreview();
                showAlert('success', 'Gambar berhasil dipilih!');
            };
            reader.readAsDataURL(file);
        } else {
            removeImage();
        }
    });
    
    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            // Trigger change event manually
            const event = new Event('change', { bubbles: true });
            imageInput.dispatchEvent(event);
        }
    });

    // Form change listeners for preview
    $('#name, #description, #category, #status').on('input change', updatePreview);

    // Initial preview update
    updatePreview();
});



function updatePreview() {
    const name = $('#name').val() || 'Nama Fasilitas';
    const description = $('#description').val() || 'Deskripsi fasilitas akan muncul di sini...';
    const category = $('#category option:selected').text() || 'Kategori';
    const status = $('#status option:selected').text() || 'Status';
    const imageSrc = $('#previewImg').attr('src');

    let preview = `
        <div class="facility-preview-card">
            ${imageSrc ? `<img src="${imageSrc}" class="img-fluid rounded mb-3" style="max-height: 150px; width: 100%; object-fit: cover;">` : ''}
            <h6 class="fw-bold">${name}</h6>
            <p class="text-muted small">${description.substring(0, 100)}${description.length > 100 ? '...' : ''}</p>
            <div class="d-flex flex-wrap gap-1 mb-2">
                <span class="badge bg-secondary">${category}</span>
                <span class="badge bg-${status === 'Aktif' ? 'success' : status === 'Maintenance' ? 'warning' : 'danger'}">${status}</span>
            </div>
        </div>
    `;

    $('#facility-preview').html(preview);
}

// Form validation
$('#facilityForm').submit(function(e) {
    let isValid = true;
    
    // Check required fields
    const requiredFields = ['name', 'description', 'category', 'status'];
    requiredFields.forEach(function(field) {
        const value = $(`#${field}`).val();
        if (!value || value.trim() === '') {
            isValid = false;
            $(`#${field}`).addClass('is-invalid');
        } else {
            $(`#${field}`).removeClass('is-invalid');
        }
    });

    if (!isValid) {
        e.preventDefault();
        showAlert('error', 'Mohon lengkapi semua field yang wajib diisi.');
        return false;
    }
    
    // Show loading message based on action
    const action = $(document.activeElement).val();
    if (action === 'save_and_new') {
        showAlert('info', 'Menambahkan fasilitas dan menyiapkan form baru...');
    } else {
        showAlert('info', 'Menambahkan fasilitas ke halaman publik...');
    }
});

function showAlert(type, message) {
    // Use the enhanced notification system
    if (window.AdminFormsEnhanced) {
        const instance = new window.AdminFormsEnhanced();
        instance.showNotification(type, message);
    } else {
        // Fallback notification
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 
                          type === 'warning' ? 'alert-warning' : 'alert-info';
        
        const alert = document.createElement('div');
        alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px; max-width: 400px;';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" onclick="this.parentNode.remove()"></button>
        `;
        
        document.body.appendChild(alert);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
}

// Reset form function
// Remove image function
function removeImage() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('uploadText').style.display = 'block';
    document.getElementById('previewImg').src = '';
    updatePreview();
    showAlert('info', 'Gambar dihapus.');
}

// Test file input function
function testFileInput() {
    const fileInput = document.getElementById('image');
    const uploadArea = document.getElementById('uploadArea');
    
    console.log('=== FILE INPUT TEST ===');
    console.log('File input element:', fileInput);
    console.log('Upload area element:', uploadArea);
    console.log('Accept attribute:', fileInput.accept);
    console.log('Multiple attribute:', fileInput.multiple);
    console.log('Current files:', fileInput.files);
    console.log('Event listeners attached:', {
        uploadAreaClick: uploadArea.onclick !== null,
        fileInputChange: fileInput.onchange !== null
    });
    
    // Test if file input is accessible
    try {
        fileInput.click();
        showAlert('info', 'File dialog opened successfully. Check console for debug info.');
    } catch (error) {
        console.error('Error clicking file input:', error);
        showAlert('error', 'Error opening file dialog: ' + error.message);
    }
}

function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
        document.getElementById('facilityForm').reset();
        removeImage();
        document.querySelectorAll('.is-valid, .is-invalid').forEach(field => {
            field.classList.remove('is-valid', 'is-invalid');
        });
        document.querySelectorAll('.invalid-feedback-enhanced, .valid-feedback-enhanced').forEach(feedback => {
            feedback.remove();
        });
        
        showAlert('success', 'Form berhasil direset!');
    }
}
});
</script>
@endpush