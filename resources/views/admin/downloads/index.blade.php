@extends('layouts.admin')

@section('title', 'Manajemen Download')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="header-title">
                <i class="fas fa-download me-3"></i>Manajemen Download
            </h1>
            <p class="header-subtitle">Kelola file download untuk materi, foto, video dan dokumen lainnya</p>
            <a href="{{ route('admin.downloads.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Upload File Baru
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-blue-500">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $downloads->total() }}</h3>
                <p class="stat-label">Total File</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-green-500">
                <i class="fas fa-download"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $downloads->sum('download_count') }}</h3>
                <p class="stat-label">Total Download</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-purple-500">
                <i class="fas fa-folder"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $downloads->groupBy('category')->count() }}</h3>
                <p class="stat-label">Kategori</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-orange-500">
                <i class="fas fa-hdd"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ number_format($downloads->sum('file_size') / 1024 / 1024, 1) }} MB</h3>
                <p class="stat-label">Total Size</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h2 class="filter-title">
            <i class="fas fa-filter me-2"></i>Filter & Pencarian
        </h2>
        <form method="GET" action="{{ route('admin.downloads.index') }}" class="filter-form">
            <div class="filter-grid">
                <div class="filter-group">
                    <label class="filter-label">Pencarian</label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="filter-input" 
                               placeholder=\"Cari nama file atau deskripsi...\" 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Kategori</label>
                    <select name="category" class="filter-input">
                        <option value="">Semua Kategori</option>
                        <option value="materi" {{ request('category') == 'materi' ? 'selected' : '' }}>📚 Materi Pembelajaran</option>
                        <option value="foto" {{ request('category') == 'foto' ? 'selected' : '' }}>📸 Foto & Galeri</option>
                        <option value="video" {{ request('category') == 'video' ? 'selected' : '' }}>🎥 Video</option>
                        <option value="dokumen" {{ request('category') == 'dokumen' ? 'selected' : '' }}>📄 Dokumen</option>
                        <option value="formulir" {{ request('category') == 'formulir' ? 'selected' : '' }}>📋 Formulir</option>
                        <option value="panduan" {{ request('category') == 'panduan' ? 'selected' : '' }}>📖 Panduan</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>✅ Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>❌ Tidak Aktif</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Urutkan</label>
                    <select name="sort" class="filter-input">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="downloads" {{ request('sort') == 'downloads' ? 'selected' : '' }}>Paling Banyak Didownload</option>
                        <option value="size" {{ request('sort') == 'size' ? 'selected' : '' }}>Ukuran File</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-filter">
                        <i class="fas fa-search me-2"></i>Terapkan Filter
                    </button>
                    <a href="{{ route('admin.downloads.index') }}" class="btn btn-reset">
                        <i class="fas fa-undo me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Downloads Grid -->
    <div class="downloads-section">
        @if($downloads->count() > 0)
            <div class="downloads-grid">
                @foreach($downloads as $download)
                <div class="download-card" data-category="{{ $download->category }}">
                    <div class="card-header">
                        <div class="file-icon">
                            @php
                                $extension = pathinfo($download->file_name, PATHINFO_EXTENSION);
                                $iconClass = match(strtolower($extension)) {
                                    'pdf' => 'fas fa-file-pdf text-red-500',
                                    'doc', 'docx' => 'fas fa-file-word text-blue-500',
                                    'xls', 'xlsx' => 'fas fa-file-excel text-green-500',
                                    'ppt', 'pptx' => 'fas fa-file-powerpoint text-orange-500',
                                    'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image text-purple-500',
                                    'mp4', 'avi', 'mov' => 'fas fa-file-video text-red-600',
                                    'mp3', 'wav' => 'fas fa-file-audio text-green-600',
                                    'zip', 'rar' => 'fas fa-file-archive text-yellow-600',
                                    default => 'fas fa-file text-gray-500'
                                };
                            @endphp
                            <i class="{{ $iconClass }}"></i>
                        </div>
                        <div class="card-badges">
                            <span class="badge badge-category">{{ ucfirst($download->category) }}</span>
                            <span class="badge {{ $download->status == 'active' ? 'badge-active' : 'badge-inactive' }}">
                                {{ $download->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title">{{ $download->title }}</h3>
                        <p class="card-description">{{ Str::limit($download->description, 100) }}</p>
                        
                        <div class="file-info">
                            <div class="info-item">
                                <i class="fas fa-file-alt"></i>
                                <span>{{ $download->file_name }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-hdd"></i>
                                <span>{{ $download->formatted_file_size }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-download"></i>
                                <span>{{ $download->download_count }} downloads</span>
                            </div>
                        </div>
                        
                        <div class="card-meta">
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                <span>{{ $download->user->name }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $download->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <a href="{{ Storage::url($download->file_path) }}" 
                           class="action-btn btn-download" 
                           target="_blank"
                           title="Download File">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{ route('admin.downloads.show', $download) }}" 
                           class="action-btn btn-view"
                           title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.downloads.edit', $download) }}" 
                           class="action-btn btn-edit"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.downloads.destroy', $download) }}" 
                              method="POST" 
                              class="inline-block"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="action-btn btn-delete"
                                    title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-download"></i>
                </div>
                <h3 class="empty-title">Belum ada file download</h3>
                <p class="empty-description">Mulai dengan mengupload file pertama untuk dibagikan</p>
                <a href="{{ route('admin.downloads.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Upload File Pertama
                </a>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($downloads->hasPages())
    <div class="pagination-wrapper">
        {{ $downloads->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #7c3aed;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --light: #f8fafc;
        --dark: #1f2937;
        --gray: #6b7280;
        --light-gray: #e5e7eb;
        --border-radius: 12px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s ease;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-subtitle {
        font-size: 1.125rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.25rem;
    }

    .stat-content h3 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .stat-content p {
        color: var(--gray);
        margin: 0;
        font-size: 0.875rem;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
    }

    .filter-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--dark);
        display: flex;
        align-items: center;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--dark);
        font-size: 0.875rem;
    }

    .filter-input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--light-gray);
        border-radius: 8px;
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
    }

    .search-input-wrapper .filter-input {
        padding-left: 2.5rem;
    }

    .filter-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-filter {
        background: var(--success);
        color: white;
    }

    .btn-filter:hover {
        background: #059669;
    }

    .btn-reset {
        background: var(--gray);
        color: white;
    }

    .btn-reset:hover {
        background: #4b5563;
    }

    /* Downloads Grid */
    .downloads-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .download-card {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .download-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .file-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: var(--shadow);
    }

    .card-badges {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: center;
    }

    .badge-category {
        background: var(--primary);
        color: white;
    }

    .badge-active {
        background: var(--success);
        color: white;
    }

    .badge-inactive {
        background: var(--danger);
        color: white;
    }

    .card-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--dark);
        line-height: 1.4;
    }

    .card-description {
        color: var(--gray);
        margin-bottom: 1rem;
        flex-grow: 1;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .file-info {
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        color: var(--gray);
    }

    .info-item i {
        width: 1rem;
        margin-right: 0.5rem;
        color: var(--primary);
    }

    .card-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--light-gray);
    }

    .meta-item {
        display: flex;
        align-items: center;
        font-size: 0.75rem;
        color: var(--gray);
    }

    .meta-item i {
        margin-right: 0.25rem;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
        padding: 0 1.5rem 1.5rem;
    }

    .action-btn {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: var(--transition);
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    .btn-download {
        background: var(--success);
    }

    .btn-view {
        background: var(--info);
    }

    .btn-edit {
        background: var(--warning);
    }

    .btn-delete {
        background: var(--danger);
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--light-gray);
        margin-bottom: 1.5rem;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .empty-description {
        color: var(--gray);
        margin-bottom: 2rem;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-title {
            font-size: 2rem;
        }
        
        .downloads-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-actions {
            grid-column: 1 / -1;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit filter form on change
    const filterInputs = document.querySelectorAll('.filter-input');
    filterInputs.forEach(input => {
        if (input.type !== 'text') {
            input.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });

    // Search input with debounce
    const searchInput = document.querySelector('input[name=\"search\"]');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    }
});
</script>
@endsection