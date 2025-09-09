{{-- resources/views/admin/posts/slideshow/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Slideshow')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="{{ route('admin.posts.slideshow') }}" 
                   class="mr-4 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Slideshow</h1>
                    <p class="text-gray-600 mt-2">Buat slideshow baru untuk homepage</p>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Ada beberapa kesalahan:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.posts.slideshow.store') }}" method="POST" enctype="multipart/form-data" id="slideshowForm">
                @csrf
                
                <div class="px-6 py-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Slideshow <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('title') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Masukkan judul slideshow"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('description') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                  placeholder="Masukkan deskripsi slideshow (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Slideshow <span class="text-red-500">*</span>
                        </label>
                        <div id="drop-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200 cursor-pointer">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition-colors duration-200">
                                        <span>Upload gambar</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg,image/gif" required>
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG, GIF maksimal 10MB</p>
                                <p class="text-xs text-gray-400">Resolusi yang disarankan: 1920x1080px</p>
                            </div>
                        </div>
                        
                        <!-- Preview Image -->
                        <div id="image-preview" class="mt-4 hidden">
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <div class="flex items-start space-x-4">
                                    <img id="preview" class="h-32 w-48 object-cover rounded-lg border shadow-sm" src="" alt="Preview">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Preview Gambar</h4>
                                        <p id="file-info" class="text-sm text-gray-600 mb-3"></p>
                                        <button type="button" id="remove-image" class="inline-flex items-center px-3 py-1 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus gambar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('status') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                required>
                            <option value="">Pilih status</option>
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Slideshow dengan status aktif akan ditampilkan di homepage</p>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Field -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan Tampil
                        </label>
                        <input type="number" 
                               name="order" 
                               id="order" 
                               value="{{ old('order', 0) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('order') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="0"
                               min="0"
                               max="999">
                        <p class="mt-1 text-xs text-gray-500">Angka lebih kecil akan tampil lebih dulu (0 = prioritas tertinggi)</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center rounded-b-lg">
                    <div class="text-sm text-gray-500">
                        <span class="text-red-500">*</span> Wajib diisi
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.posts.slideshow') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            Batal
                        </a>
                        <button type="submit" 
                                id="submit-btn"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:bg-blue-400 disabled:cursor-not-allowed transition-colors duration-200 font-medium">
                            <span id="submit-text">Simpan Slideshow</span>
                            <svg id="loading-spinner" class="hidden animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const preview = document.getElementById('preview');
    const removeButton = document.getElementById('remove-image');
    const fileInfo = document.getElementById('file-info');
    const dropArea = document.getElementById('drop-area');
    const form = document.getElementById('slideshowForm');
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const loadingSpinner = document.getElementById('loading-spinner');

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    dropArea.addEventListener('drop', handleDrop, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        dropArea.classList.add('border-blue-400', 'bg-blue-50');
    }

    function unhighlight() {
        dropArea.classList.remove('border-blue-400', 'bg-blue-50');
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
        const file = e.target.files[0];
        if (file) {
            handleImageSelect(file);
        }
    });

    function handleImageSelect(file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            showAlert('Tipe file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.', 'error');
            resetImageInput();
            return;
        }

        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            showAlert('Ukuran file terlalu besar. Maksimal 10MB.', 'error');
            resetImageInput();
            return;
        }

        // Display file info
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        fileInfo.textContent = `${file.name} (${fileSize} MB)`;

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            imagePreview.classList.remove('hidden');
            
            // Check image dimensions
            const img = new Image();
            img.onload = function() {
                const width = this.width;
                const height = this.height;
                const aspectRatio = (width / height).toFixed(2);
                
                if (width < 800 || height < 600) {
                    showAlert('Resolusi gambar terlalu kecil. Minimal 800x600px untuk kualitas terbaik.', 'warning');
                }
                
                fileInfo.innerHTML = `${file.name} (${fileSize} MB)<br>
                    <span class="text-xs text-gray-400">Dimensi: ${width}x${height}px</span>`;
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function resetImageInput() {
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        preview.src = '';
        fileInfo.textContent = '';
    }

    removeButton.addEventListener('click', function() {
        resetImageInput();
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.disabled = true;
        submitText.textContent = 'Menyimpan...';
        loadingSpinner.classList.remove('hidden');
        
        // Basic validation
        const title = document.getElementById('title').value.trim();
        const image = imageInput.files[0];
        const status = document.getElementById('status').value;

        if (!title) {
            e.preventDefault();
            showAlert('Judul slideshow wajib diisi.', 'error');
            resetSubmitButton();
            return;
        }

        if (!image) {
            e.preventDefault();
            showAlert('Gambar slideshow wajib diupload.', 'error');
            resetSubmitButton();
            return;
        }

        if (!status) {
            e.preventDefault();
            showAlert('Status slideshow wajib dipilih.', 'error');
            resetSubmitButton();
            return;
        }

        // If validation passes, form will submit normally
    });

    function resetSubmitButton() {
        submitBtn.disabled = false;
        submitText.textContent = 'Simpan Slideshow';
        loadingSpinner.classList.add('hidden');
    }

    function showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.dynamic-alert');
        existingAlerts.forEach(alert => alert.remove());

        const alertColors = {
            error: 'bg-red-50 border-red-200 text-red-700',
            warning: 'bg-yellow-50 border-yellow-200 text-yellow-700',
            success: 'bg-green-50 border-green-200 text-green-700',
            info: 'bg-blue-50 border-blue-200 text-blue-700'
        };

        const alertIcons = {
            error: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />',
            warning: '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />',
            success: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />',
            info: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />'
        };

        const alertDiv = document.createElement('div');
        alertDiv.className = `dynamic-alert mb-6 border rounded-lg p-4 ${alertColors[type]}`;
        alertDiv.innerHTML = `
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        ${alertIcons[type]}
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">${message}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex rounded-md p-1.5 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;

        const header = document.querySelector('.mb-8');
        header.parentNode.insertBefore(alertDiv, header.nextSibling);

        // Auto remove after 5 seconds for non-error alerts
        if (type !== 'error') {
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    }

    // Auto-focus title field
    document.getElementById('title').focus();
});
</script>
@endsection