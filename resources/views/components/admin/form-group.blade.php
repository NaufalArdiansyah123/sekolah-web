@props([
    'label' => '',
    'icon' => '',
    'required' => false,
    'help' => '',
    'error' => '',
    'type' => 'input', // input, textarea, select, file, custom
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'rows' => 4,
    'options' => [], // for select
    'accept' => '', // for file input
])

<div class="admin-form-group">
    @if($label)
        <label class="admin-form-label" for="{{ $name }}">
            @if($icon)
                <i class="{{ $icon }} me-2"></i>
            @endif
            {{ $label }}
            @if($required)
                <span class="admin-required">*</span>
            @endif
        </label>
    @endif

    @if($type === 'input')
        <input type="text" 
               class="admin-form-control @error($name) is-invalid @enderror" 
               name="{{ $name }}" 
               id="{{ $name }}"
               value="{{ old($name, $value) }}"
               placeholder="{{ $placeholder }}"
               @if($required) required @endif
               {{ $attributes }}>
    @elseif($type === 'textarea')
        <textarea class="admin-form-control @error($name) is-invalid @enderror" 
                  name="{{ $name }}" 
                  id="{{ $name }}"
                  rows="{{ $rows }}"
                  placeholder="{{ $placeholder }}"
                  @if($required) required @endif
                  {{ $attributes }}>{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select class="admin-form-control @error($name) is-invalid @enderror" 
                name="{{ $name }}" 
                id="{{ $name }}"
                @if($required) required @endif
                {{ $attributes }}>
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" 
                        @if(old($name, $value) == $optionValue) selected @endif>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    @elseif($type === 'file')
        <div class="admin-upload-area">
            <div class="admin-upload-content">
                <i class="fas fa-cloud-upload-alt admin-upload-icon"></i>
                <h3 class="admin-upload-title">Klik atau drag & drop file di sini</h3>
                <p class="admin-upload-subtitle">{{ $help ?: 'File yang didukung' }}</p>
                <input type="file" 
                       class="admin-upload-input" 
                       name="{{ $name }}" 
                       id="{{ $name }}"
                       @if($accept) accept="{{ $accept }}" @endif
                       @if($required) required @endif
                       {{ $attributes }}>
            </div>
        </div>
        <div class="admin-file-preview" style="display: none;">
            <img src="#" alt="Preview" class="admin-preview-image">
            <button type="button" class="admin-remove-file">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @else
        {{ $slot }}
    @endif

    @if($error || $errors->has($name))
        <div class="admin-form-error">
            {{ $error ?: $errors->first($name) }}
        </div>
    @endif

    @if($help && $type !== 'file')
        <p class="admin-form-help">{{ $help }}</p>
    @endif
</div>

<style>
    /* Admin Form Group Styles - Dark Mode Compatible */
    .admin-form-group {
        margin-bottom: 1.5rem;
    }

    .admin-form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
        font-size: 0.9rem;
    }

    .admin-required {
        color: #ef4444;
    }

    .admin-form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        resize: vertical;
    }

    .admin-form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .admin-form-control.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .admin-form-control::placeholder {
        color: var(--text-tertiary);
    }

    .admin-form-help {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
        margin-bottom: 0;
        transition: color 0.3s ease;
    }

    .admin-form-error {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Upload Area Styles */
    .admin-upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        padding: 2.5rem 1.5rem;
        text-align: center;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .admin-upload-area:hover {
        border-color: #3b82f6;
        background: var(--bg-tertiary);
    }

    .admin-upload-icon {
        font-size: 2.5rem;
        color: #3b82f6;
        margin-bottom: 1rem;
    }

    .admin-upload-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        transition: color 0.3s ease;
        font-size: 1rem;
    }

    .admin-upload-subtitle {
        color: var(--text-secondary);
        margin-bottom: 0;
        transition: color 0.3s ease;
        font-size: 0.875rem;
    }

    .admin-upload-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .admin-file-preview {
        position: relative;
        max-width: 300px;
        margin-top: 1rem;
    }

    .admin-preview-image {
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 15px var(--shadow-color);
    }

    .admin-remove-file {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 32px;
        height: 32px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .admin-remove-file:hover {
        transform: scale(1.1);
    }

    /* Dark mode specific adjustments */
    .dark .admin-upload-area {
        background: var(--bg-primary);
    }

    .dark .admin-upload-area:hover {
        background: var(--bg-secondary);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File upload preview functionality
        const uploadInputs = document.querySelectorAll('.admin-upload-input');
        
        uploadInputs.forEach(input => {
            const uploadArea = input.closest('.admin-upload-area');
            const preview = input.closest('.admin-form-group').querySelector('.admin-file-preview');
            const previewImage = preview?.querySelector('.admin-preview-image');
            const removeBtn = preview?.querySelector('.admin-remove-file');

            if (uploadArea && preview && previewImage && removeBtn) {
                // File input change
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });

                // Remove file
                removeBtn.addEventListener('click', function() {
                    input.value = '';
                    preview.style.display = 'none';
                    previewImage.src = '#';
                });

                // Drag and drop
                uploadArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '#3b82f6';
                });

                uploadArea.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '';
                });

                uploadArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '';
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        input.files = files;
                        input.dispatchEvent(new Event('change'));
                    }
                });
            }
        });
    });
</script>