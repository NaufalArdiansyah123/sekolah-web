@extends('layouts.admin')

@section('content')
<style>
    /* Enhanced Form Styles */
    .form-container {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .dark .form-container {
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
        min-height: 120px;
    }
    
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    .datetime-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1rem;
    }
    
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
    
    .btn-primary:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
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
    
    .form-help {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
    }
    
    .required {
        color: #ef4444;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 1.5rem;
        }
        
        .datetime-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .success-message {
        color: #10b981;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
</style>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tambah Agenda</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Buat agenda kegiatan sekolah baru</p>
        </div>
        <a href="{{ route('admin.posts.agenda') }}" 
           class="btn btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada form:</h3>
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
    <div class="form-container">
        <form method="POST" action="{{ route('admin.posts.agenda.store') }}" id="agendaForm">
            @csrf
            
            <!-- Title -->
            <div class="form-group">
                <label for="title" class="form-label">
                    Judul Agenda <span class="required">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       id="title"
                       class="form-input @error('title') border-red-500 @enderror"
                       value="{{ old('title') }}"
                       placeholder="Masukkan judul agenda"
                       required>
                <div class="form-help">Judul agenda yang akan ditampilkan di halaman public</div>
                @error('title')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date and Time -->
            <div class="form-group">
                <label for="event_date" class="form-label">
                    Tanggal & Waktu Kegiatan <span class="required">*</span>
                </label>
                <div class="datetime-grid">
                    <input type="datetime-local" 
                           name="event_date" 
                           id="event_date"
                           class="form-input @error('event_date') border-red-500 @enderror"
                           value="{{ old('event_date') }}"
                           required>
                    <select name="timezone" class="form-input form-select">
                        <option value="WIB" {{ old('timezone') == 'WIB' ? 'selected' : '' }}>WIB</option>
                        <option value="WITA" {{ old('timezone') == 'WITA' ? 'selected' : '' }}>WITA</option>
                        <option value="WIT" {{ old('timezone') == 'WIT' ? 'selected' : '' }}>WIT</option>
                    </select>
                </div>
                <div class="form-help">Pilih tanggal dan waktu pelaksanaan kegiatan</div>
                @error('event_date')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div class="form-group">
                <label for="location" class="form-label">Lokasi Kegiatan</label>
                <input type="text" 
                       name="location" 
                       id="location"
                       class="form-input @error('location') border-red-500 @enderror"
                       value="{{ old('location') }}"
                       placeholder="Contoh: Aula Sekolah, Lapangan Upacara, dll">
                <div class="form-help">Lokasi pelaksanaan kegiatan (opsional)</div>
                @error('location')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="form-group">
                <label for="content" class="form-label">
                    Deskripsi Agenda <span class="required">*</span>
                </label>
                <textarea name="content" 
                          id="content" 
                          class="form-input form-textarea @error('content') border-red-500 @enderror"
                          placeholder="Masukkan deskripsi lengkap agenda kegiatan..."
                          required>{{ old('content') }}</textarea>
                <div class="form-help">Deskripsi lengkap tentang agenda kegiatan</div>
                @error('content')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status" class="form-label">
                    Status <span class="required">*</span>
                </label>
                <select name="status" id="status" class="form-input form-select @error('status') border-red-500 @enderror" required>
                    <option value="">Pilih Status</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draf</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
                <div class="form-help">Status publikasi agenda</div>
                @error('status')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Agenda
                </button>
                
                <a href="{{ route('admin.posts.agenda') }}" class="btn btn-secondary">
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
    console.log('DOM loaded, initializing form...');
    
    const form = document.getElementById('agendaForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (!form) {
        console.error('Form not found!');
        return;
    }
    
    // Form submission handler
    form.addEventListener('submit', function(e) {
        console.log('Form submit event triggered');
        
        // Get form data
        const formData = new FormData(form);
        const title = formData.get('title')?.trim();
        const eventDate = formData.get('event_date');
        const content = formData.get('content')?.trim();
        const status = formData.get('status');
        
        console.log('Form data:', {
            title: title,
            eventDate: eventDate,
            content: content,
            status: status
        });
        
        // Basic validation
        if (!title) {
            e.preventDefault();
            alert('Mohon isi judul agenda');
            document.getElementById('title').focus();
            return false;
        }
        
        if (!eventDate) {
            e.preventDefault();
            alert('Mohon pilih tanggal kegiatan');
            document.getElementById('event_date').focus();
            return false;
        }
        
        if (!content) {
            e.preventDefault();
            alert('Mohon isi deskripsi agenda');
            document.getElementById('content').focus();
            return false;
        }
        
        if (!status) {
            e.preventDefault();
            alert('Mohon pilih status agenda');
            document.getElementById('status').focus();
            return false;
        }
        
        console.log('Validation passed, submitting form...');
        
        // Show loading state
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
        }
        
        return true;
    });
    
    // Auto-save draft functionality
    let autoSaveTimer;
    function autoSave() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            const formData = new FormData(form);
            const draftData = {};
            for (let [key, value] of formData.entries()) {
                draftData[key] = value;
            }
            localStorage.setItem('agenda_draft', JSON.stringify(draftData));
            console.log('Draft saved to localStorage');
        }, 2000);
    }
    
    // Load draft on page load
    const savedDraft = localStorage.getItem('agenda_draft');
    if (savedDraft) {
        try {
            const draftData = JSON.parse(savedDraft);
            console.log('Loading draft data:', draftData);
            
            if (draftData.title) document.getElementById('title').value = draftData.title;
            if (draftData.event_date) document.getElementById('event_date').value = draftData.event_date;
            if (draftData.location) document.getElementById('location').value = draftData.location;
            if (draftData.content) document.getElementById('content').value = draftData.content;
            if (draftData.status) document.getElementById('status').value = draftData.status;
        } catch (e) {
            console.error('Error loading draft:', e);
        }
    }
    
    // Add auto-save listeners
    ['title', 'event_date', 'location', 'content', 'status'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', autoSave);
            field.addEventListener('change', autoSave);
        }
    });
    
    // Clear draft on successful submit
    form.addEventListener('submit', function() {
        localStorage.removeItem('agenda_draft');
    });
    
    console.log('Form initialization complete');
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
</script>
@endsection