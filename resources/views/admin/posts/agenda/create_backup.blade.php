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
    
    /* Rich Text Editor Styles */
    .editor-container {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        background: var(--bg-primary);
    }
    
    .editor-toolbar {
        background: var(--bg-secondary);
        border-bottom: 1px solid var(--border-color);
        padding: 0.5rem;
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
    }
    
    .editor-btn {
        padding: 0.375rem 0.5rem;
        border: none;
        background: transparent;
        color: var(--text-primary);
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }
    
    .editor-btn:hover {
        background: var(--bg-tertiary);
    }
    
    .editor-btn.active {
        background: var(--accent-color);
        color: white;
    }
    
    .editor-content {
        min-height: 200px;
        padding: 1rem;
        outline: none;
        color: var(--text-primary);
        line-height: 1.6;
    }
    
    .editor-content:focus {
        background: var(--bg-primary);
    }
    
    /* Preview Section */
    .preview-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .preview-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
    }
    
    .preview-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }
    
    .preview-content {
        color: var(--text-primary);
        line-height: 1.6;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 1.5rem;
        }
        
        .datetime-grid {
            grid-template-columns: 1fr;
        }
        
        .editor-toolbar {
            padding: 0.375rem;
        }
        
        .editor-btn {
            padding: 0.25rem 0.375rem;
            font-size: 0.75rem;
        }
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
                       class="form-input"
                       value="{{ old('title') }}"
                       placeholder="Masukkan judul agenda"
                       required>
                <div class="form-help">Judul agenda yang akan ditampilkan di halaman public</div>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                           class="form-input"
                           value="{{ old('event_date') }}"
                           required>
                    <select name="timezone" class="form-input form-select">
                        <option value="WIB">WIB</option>
                        <option value="WITA">WITA</option>
                        <option value="WIT">WIT</option>
                    </select>
                </div>
                <div class="form-help">Pilih tanggal dan waktu pelaksanaan kegiatan</div>
                @error('event_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div class="form-group">
                <label for="location" class="form-label">Lokasi Kegiatan</label>
                <input type="text" 
                       name="location" 
                       id="location"
                       class="form-input"
                       value="{{ old('location') }}"
                       placeholder="Contoh: Aula Sekolah, Lapangan Upacara, dll">
                <div class="form-help">Lokasi pelaksanaan kegiatan (opsional)</div>
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="form-group">
                <label for="content" class="form-label">
                    Deskripsi Agenda <span class="required">*</span>
                </label>
                <div class="editor-container">
                    <div class="editor-toolbar">
                        <button type="button" class="editor-btn" onclick="formatText('bold')">
                            <strong>B</strong>
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('italic')">
                            <em>I</em>
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('underline')">
                            <u>U</u>
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('insertUnorderedList')">
                            • List
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('insertOrderedList')">
                            1. List
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('justifyLeft')">
                            ←
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('justifyCenter')">
                            ↔
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('justifyRight')">
                            →
                        </button>
                    </div>
                    <div class="editor-content" 
                         contenteditable="true" 
                         id="contentEditor"
                         data-placeholder="Masukkan deskripsi lengkap agenda kegiatan...">
                        {!! old('content') !!}
                    </div>
                </div>
                <textarea name="content" id="content" style="display: none;" required>{{ old('content') }}</textarea>
                <div class="form-help">Deskripsi lengkap tentang agenda kegiatan</div>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status" class="form-label">
                    Status <span class="required">*</span>
                </label>
                <select name="status" id="status" class="form-input form-select" required>
                    <option value="">Pilih Status</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
                <div class="form-help">Status publikasi agenda</div>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Agenda
                </button>
                
                <button type="button" onclick="showPreview()" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Preview
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

    <!-- Preview Section -->
    <div id="previewSection" class="preview-section" style="display: none;">
        <h3 class="preview-title">Preview Agenda</h3>
        <div class="preview-meta">
            <span id="previewDate"></span>
            <span id="previewLocation"></span>
            <span id="previewStatus"></span>
        </div>
        <div class="preview-content" id="previewContent"></div>
    </div>
</div>

<script>
// Rich Text Editor Functions
function formatText(command) {
    document.execCommand(command, false, null);
    updateContent();
}

function updateContent() {
    const editor = document.getElementById('contentEditor');
    const textarea = document.getElementById('content');
    textarea.value = editor.innerHTML;
}

// Update content when editor changes
document.getElementById('contentEditor').addEventListener('input', updateContent);

// Preview Function
function showPreview() {
    const title = document.getElementById('title').value;
    const eventDate = document.getElementById('event_date').value;
    const location = document.getElementById('location').value;
    const content = document.getElementById('contentEditor').innerHTML;
    const status = document.getElementById('status').value;
    
    if (!title || !eventDate || !content) {
        alert('Mohon lengkapi data agenda terlebih dahulu');
        return;
    }
    
    // Update preview
    document.querySelector('.preview-title').textContent = title;
    
    // Format date
    if (eventDate) {
        const date = new Date(eventDate);
        document.getElementById('previewDate').textContent = date.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }) + ' WIB';
    }
    
    document.getElementById('previewLocation').textContent = location ? `📍 ${location}` : '';
    const statusText = {
        'draft': 'Draft',
        'published': 'Dipublikasi',
        'archived': 'Diarsipkan'
    };
    document.getElementById('previewStatus').textContent = status ? `Status: ${statusText[status] || status}` : '';
    document.getElementById('previewContent').innerHTML = content;
    
    // Show preview
    document.getElementById('previewSection').style.display = 'block';
    document.getElementById('previewSection').scrollIntoView({ behavior: 'smooth' });
}

// Form validation
document.getElementById('agendaForm').addEventListener('submit', function(e) {
    updateContent();
    
    const title = document.getElementById('title').value;
    const eventDate = document.getElementById('event_date').value;
    const content = document.getElementById('content').value;
    const status = document.getElementById('status').value;
    
    if (!title || !eventDate || !content || !status) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi');
        return false;
    }
});

// Auto-save draft (optional)
let autoSaveTimer;
function autoSave() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
        updateContent();
        const formData = new FormData(document.getElementById('agendaForm'));
        localStorage.setItem('agenda_draft', JSON.stringify(Object.fromEntries(formData)));
        console.log('Draft saved');
    }, 2000);
}

// Load draft on page load
window.addEventListener('load', function() {
    const draft = localStorage.getItem('agenda_draft');
    if (draft) {
        const data = JSON.parse(draft);
        if (data.title) document.getElementById('title').value = data.title;
        if (data.event_date) document.getElementById('event_date').value = data.event_date;
        if (data.location) document.getElementById('location').value = data.location;
        if (data.content) document.getElementById('contentEditor').innerHTML = data.content;
        if (data.status) document.getElementById('status').value = data.status;
    }
});

// Add auto-save listeners
document.getElementById('title').addEventListener('input', autoSave);
document.getElementById('event_date').addEventListener('change', autoSave);
document.getElementById('location').addEventListener('input', autoSave);
document.getElementById('contentEditor').addEventListener('input', autoSave);
document.getElementById('status').addEventListener('change', autoSave);

// Clear draft on successful submit
document.getElementById('agendaForm').addEventListener('submit', function() {
    localStorage.removeItem('agenda_draft');
});
</script>
@endsection