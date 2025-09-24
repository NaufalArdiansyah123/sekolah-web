@extends('layouts.admin')

@section('title', 'Manajemen Download')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Download</h1>
        <a href="{{ route('admin.downloads.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Download
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Downloads</div>
                            <h3 class="stat-number">{{ $downloads->total() }}</h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-download fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Unduhan</div>
                            <h3 class="stat-number">{{ $downloads->sum('download_count') }}</h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kategori</div>
                            <h3 class="stat-number">{{ $downloads->groupBy('category')->count() }}</h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Size</div>
                            <h3 class="stat-number">{{ number_format($downloads->sum('file_size') / 1024 / 1024, 1) }} MB</h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hdd fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.downloads.index') }}" class="filter-form">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Cari Download</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama file atau deskripsi...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">Semua Kategori</option>
                                <option value="materi" {{ request('category') == 'materi' ? 'selected' : '' }}>Materi Pembelajaran</option>
                                <option value="dokumentasi" {{ request('category') == 'dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                                <option value="resmi" {{ request('category') == 'resmi' ? 'selected' : '' }}>Dokumen Resmi</option>
                                <option value="ebook" {{ request('category') == 'ebook' ? 'selected' : '' }}>E-Book</option>
                                <option value="software" {{ request('category') == 'software' ? 'selected' : '' }}>Software</option>
                                <option value="template" {{ request('category') == 'template' ? 'selected' : '' }}>Template</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sort">Urutkan</label>
                            <select class="form-control" id="sort" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="downloads" {{ request('sort') == 'downloads' ? 'selected' : '' }}>Paling Banyak Didownload</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.downloads.index') }}" class="btn btn-reset">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Downloads Grid -->
    <div class="downloads-section">
        @if($downloads->count() > 0)
            <div class="downloads-grid">
                @foreach($downloads as $download)
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="download-icon">
                                        @switch($download->file_type ?? 'pdf')
                                            @case('pdf')
                                                <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                                @break
                                            @case('doc')
                                            @case('docx')
                                                <i class="fas fa-file-word fa-3x text-primary"></i>
                                                @break
                                            @case('xls')
                                            @case('xlsx')
                                                <i class="fas fa-file-excel fa-3x text-success"></i>
                                                @break
                                            @case('ppt')
                                            @case('pptx')
                                                <i class="fas fa-file-powerpoint fa-3x text-warning"></i>
                                                @break
                                            @case('zip')
                                            @case('rar')
                                                <i class="fas fa-file-archive fa-3x text-secondary"></i>
                                                @break
                                            @case('jpg')
                                            @case('jpeg')
                                            @case('png')
                                            @case('gif')
                                                <i class="fas fa-image fa-3x text-info"></i>
                                                @break
                                            @case('mp4')
                                            @case('avi')
                                            @case('mov')
                                                <i class="fas fa-video fa-3x text-dark"></i>
                                                @break
                                            @default
                                                <i class="fas fa-file fa-3x text-muted"></i>
                                        @endswitch
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="card-title mb-1">{{ $download->title ?? 'Sample Download' }}</h5>
                                    <p class="card-text text-muted mb-2">{{ $download->description ?? 'Sample description for download item' }}</p>
                                    <div class="d-flex gap-3 text-sm text-muted">
                                        <span><i class="fas fa-folder me-1"></i>{{ $download->category ?? 'Materi' }}</span>
                                        <span><i class="fas fa-calendar me-1"></i>{{ $download->created_at ?? now()->format('d M Y') }}</span>
                                        <span><i class="fas fa-hdd me-1"></i>{{ $download->file_size ?? '2.5 MB' }}</span>
                                        <span>{{ $download->download_count ?? 0 }} downloads</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('admin.downloads.show', $download) }}" 
                                                   class="dropdown-item">
                                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.downloads.edit', $download) }}" 
                                                   class="dropdown-item">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.downloads.destroy', $download) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus download ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-download fa-5x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada download</h4>
                <p class="text-muted mb-4">Mulai dengan menambahkan file download pertama Anda.</p>
                <a href="{{ route('admin.downloads.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Download
                </a>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($downloads->hasPages())
        <div class="d-flex justify-content-center">
            {{ $downloads->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<style>
.downloads-grid {
    display: grid;
    gap: 1rem;
}

.download-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-reset {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
}

.btn-reset:hover {
    background-color: #5a6268;
    border-color: #545b62;
    color: white;
}

.filter-form .form-group {
    margin-bottom: 1rem;
}

.filter-form label {
    font-weight: 600;
    margin-bottom: 0.5rem;
}
</style>
@endsection