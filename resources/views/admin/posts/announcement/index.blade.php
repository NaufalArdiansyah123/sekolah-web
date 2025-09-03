@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Daftar Pengumuman</h1>
                <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pengumuman
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 25%">Judul</th>
                                    <th style="width: 12%">Kategori</th>
                                    <th style="width: 10%">Prioritas</th>
                                    <th style="width: 12%">Penulis</th>
                                    <th style="width: 10%">Status</th>
                                    <th style="width: 8%">Views</th>
                                    <th style="width: 13%">Tanggal Publikasi</th>
                                    <th style="width: 5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $index => $announcement)
                                <tr>
                                    <td>{{ $announcements->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($announcement->judul, 50) }}</div>
                                        @if($announcement->gambar)
                                            <small class="text-muted"><i class="fas fa-image"></i> Ada gambar</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($announcement->kategori) }}</span>
                                    </td>
                                    <td>
                                        @if($announcement->prioritas === 'tinggi')
                                            <span class="badge bg-danger">Tinggi</span>
                                        @elseif($announcement->prioritas === 'sedang')
                                            <span class="badge bg-warning">Sedang</span>
                                        @else
                                            <span class="badge bg-success">Rendah</span>
                                        @endif
                                    </td>
                                    <td>{{ $announcement->penulis }}</td>
                                    <td>
                                        @if($announcement->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @elseif($announcement->status === 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @else
                                            <span class="badge bg-dark">Archived</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $announcement->views ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <small>{{ date('d/m/Y H:i', strtotime($announcement->tanggal_publikasi)) }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    data-bs-toggle="dropdown">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.announcements.show', $announcement->id) }}">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.announcements.edit', $announcement->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item toggle-status" 
                                                            data-id="{{ $announcement->id }}" 
                                                            data-current-status="{{ $announcement->status }}">
                                                        <i class="fas fa-toggle-on"></i> 
                                                        {{ $announcement->status === 'published' ? 'Set Draft' : 'Publish' }}
                                                    </button>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" 
                                                          method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Belum ada pengumuman</p>
                                            <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Tambah Pengumuman Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($announcements->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $announcements->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
    }
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .btn-group .dropdown-toggle::after {
        margin-left: 0.5em;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Yakin ingin menghapus pengumuman ini?')) {
                e.preventDefault();
            }
        });
    });

    // Toggle status
    document.querySelectorAll('.toggle-status').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const currentStatus = this.dataset.currentStatus;
            
            if (confirm(`Yakin ingin mengubah status menjadi ${currentStatus === 'published' ? 'draft' : 'published'}?`)) {
                fetch(`/admin/announcements/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Gagal mengubah status: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan: ' + error);
                });
            }
        });
    });
});
</script>
@endpush