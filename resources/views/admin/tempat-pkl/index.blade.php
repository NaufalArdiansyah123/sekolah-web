@extends('layouts.admin')

@section('title', 'Manajemen Tempat PKL')

<style>
    /* Clean White Theme Styling */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #ffffff;
        --bg-tertiary: #ffffff;
        --text-primary: #000000;
        --text-secondary: #000000;
        --border-color: #cccccc;
        --accent-color: #000000;
    }

    .tp-container {
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        min-height: 100vh;
        padding: 1.5rem;
    }

    .tp-card {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        color: var(--text-primary);
    }

    .tp-header {
        background-color: var(--bg-tertiary);
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .btn-primary {
        background-color: #000000 !important;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: 1px solid #000000 !important;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        filter: brightness(1.1);
    }

    .btn-secondary {
        background-color: var(--bg-tertiary);
        color: var(--text-primary);
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: 1px solid var(--border-color);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background-color: var(--border-color);
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: 1px solid #dc3545;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-danger:hover {
        filter: brightness(1.1);
    }

    .form-input {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        width: 100%;
    }

    .form-input:focus {
        outline: none;
        border-color: #999;
    }

    .table-row:hover {
        background-color: var(--bg-tertiary);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        border: 1px solid var(--border-color);
    }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 50;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-content {
        background-color: var(--bg-primary);
        border-radius: 0.75rem;
        max-width: 28rem;
        width: 90%;
        border: 1px solid var(--border-color);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        padding: 2rem;
        background: var(--bg-tertiary);
    }

    .stat-card {
        background: var(--bg-primary);
        border-radius: 0.5rem;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .floating-add-btn {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 64px;
        height: 64px;
        background: #000000 !important;
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        z-index: 1000;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .floating-add-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        color: white;
    }

    .quota-badge {
        background: var(--accent-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-view {
        background: #f0f0f0;
        color: var(--text-primary);
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-view:hover {
        background: var(--border-color);
        transform: scale(1.1);
    }

    .btn-edit {
        background: #f0f0f0;
        color: var(--text-primary);
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-edit:hover {
        background: var(--border-color);
        transform: scale(1.1);
    }

    .btn-delete {
        background: #dc3545;
        color: white;
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-delete:hover {
        filter: brightness(1.1);
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .tp-container {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            padding: 1rem;
            gap: 1rem;
        }
    }
</style>

@section('content')
    <div class="tp-container">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                        Manajemen Tempat PKL
                    </h1>
                    <p class="text-sm mt-1" style="color: var(--text-secondary)">
                        Kelola tempat praktik kerja lapangan (PKL) siswa
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.tempat-pkl.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Tambah Tempat PKL
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $tempatPkls->count() }}</div>
                <div class="stat-label">Total Tempat PKL</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $tempatPkls->sum('kuota') }}</div>
                <div class="stat-label">Total Kuota</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $tempatPkls->where('kontak', '!=', null)->count() }}</div>
                <div class="stat-label">Dengan Kontak</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $tempatPkls->where('pembimbing_lapangan', '!=', null)->count() }}</div>
                <div class="stat-label">Dengan Pembimbing</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="tp-card mb-6">
            <div class="tp-header">
                <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                    <i class="fas fa-filter mr-2"></i>Filter & Pencarian
                </h3>
            </div>
            <div class="p-4">
                <form method="GET" action="{{ route('admin.tempat-pkl.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium mb-2"
                                style="color: var(--text-secondary)">Pencarian</label>
                            <input type="text" name="search" class="form-input"
                                placeholder="Cari nama tempat, alamat, kontak..." value="{{ request('search') }}">
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-search mr-2"></i>Cari
                            </button>
                            <a href="{{ route('admin.tempat-pkl.index') }}" class="btn-secondary">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>

                @if(request()->has('search'))
                    <div class="mt-4">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        <span style="color: var(--text-secondary)">
                            Filter aktif - Menampilkan {{ $tempatPkls->count() }} tempat PKL
                        </span>
                        <a href="{{ route('admin.tempat-pkl.index') }}" class="ml-2" style="color: var(--accent-color)">
                            <i class="fas fa-times"></i> Hapus Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tempat PKL Table -->
        @if($tempatPkls->count() > 0)
            <div class="tp-card">
                <div class="tp-header">
                    <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                        <i class="fas fa-table mr-2"></i>Daftar Tempat PKL
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border-color)">
                                <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">NAMA
                                    TEMPAT & ALAMAT</th>
                                <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">KOTA
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">KONTAK
                                    & PEMBIMBING</th>
                                <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">KUOTA
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">AKSI
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tempatPkls as $tempatPkl)
                                <tr class="table-row" style="border-bottom: 1px solid var(--border-color)">
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium" style="color: var(--text-primary)">
                                            {{ $tempatPkl->nama_tempat }}
                                        </div>
                                        <div class="text-xs" style="color: var(--text-secondary)">
                                            {{ $tempatPkl->alamat }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="status-badge"
                                            style="background-color: var(--bg-tertiary); color: var(--text-primary)">
                                            {{ $tempatPkl->kota ?? 'Belum ditentukan' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm" style="color: var(--text-primary)">
                                            @if($tempatPkl->kontak)
                                                <div class="flex items-center gap-2 mb-1">
                                                    <i class="fas fa-phone text-xs"></i>
                                                    <a href="tel:{{ $tempatPkl->kontak }}" style="color: var(--accent-color)">
                                                        {{ $tempatPkl->kontak }}
                                                    </a>
                                                </div>
                                            @endif
                                            @if($tempatPkl->pembimbing_lapangan)
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user-tie text-xs"></i>
                                                    {{ $tempatPkl->pembimbing_lapangan }}
                                                </div>
                                            @endif
                                            @if(!$tempatPkl->kontak && !$tempatPkl->pembimbing_lapangan)
                                                <span style="color: var(--text-secondary)">Belum ada informasi kontak</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="quota-badge">
                                            <i class="fas fa-users"></i>
                                            {{ $tempatPkl->kuota_tersedia }} / {{ $tempatPkl->kuota }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.tempat-pkl.show', $tempatPkl) }}" class="btn-view"
                                                title="Lihat Detail">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                            <a href="{{ route('admin.tempat-pkl.edit', $tempatPkl) }}" class="btn-edit"
                                                title="Edit">
                                                <i class="fas fa-edit text-xs"></i>
                                            </a>
                                            <button type="button" class="btn-delete" onclick="deleteTempatPkl({{ $tempatPkl->id }})"
                                                title="Hapus">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($tempatPkls->hasPages())
                    <div class="p-4 border-t" style="border-color: var(--border-color)">
                        {{ $tempatPkls->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="tp-card">
                <div class="text-center py-12">
                    <i class="fas fa-building text-3xl mb-3" style="color: var(--text-secondary); opacity: 0.5"></i>
                    <p class="text-sm" style="color: var(--text-secondary)">Belum Ada Data Tempat PKL</p>
                    <p class="text-xs mb-4" style="color: var(--text-secondary)">Mulai tambahkan data tempat PKL untuk mengelola
                        praktik kerja lapangan siswa.</p>
                    <a href="{{ route('admin.tempat-pkl.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Tambah Tempat PKL Pertama
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Floating Add Button -->
    <a href="{{ route('admin.tempat-pkl.create') }}" class="floating-add-btn" title="Tambah Tempat PKL Baru">
        <i class="fas fa-plus"></i>
    </a>

    <!-- Forms -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        function deleteTempatPkl(tempatPklId) {
            if (confirm('Apakah Anda yakin ingin menghapus tempat PKL ini? Data yang dihapus tidak dapat dikembalikan.')) {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/tempat-pkl/${tempatPklId}`;
                form.submit();
            }
        }
    </script>
@endpush