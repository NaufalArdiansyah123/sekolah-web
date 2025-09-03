@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Detail Pengumuman</h1>
                <div>
                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="card-title mb-0">{{ $announcement->judul }}</h3>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($announcement->status === 'published')
                                <span class="badge bg-success fs-6">Published</span>
                            @elseif($announcement->status === 'draft')
                                <span class="badge bg-secondary fs-6">Draft</span>
                            @else
                                <span class="badge bg-dark fs-6">Archived</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <strong>Kategori:</strong>
                                <span class="badge bg-info ms-2">{{ ucfirst($announcement->kategori) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <strong>Prioritas:</strong>
                                @if($announcement->prioritas === 'tinggi')
                                    <span class="badge bg-danger ms-2">Tinggi</span>
                                @elseif($announcement->prioritas === 'sedang')
                                    <span class="badge bg-warning ms-2">Sedang</span>
                                @else
                                    <span class="badge bg-success ms-2">Rendah</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-item">
                                <strong>Penulis:</strong>
                                <span class="ms-2">{{ $announcement->penulis }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <strong>Views:</strong>
                                <span class="badge bg-primary ms-2">{{ $announcement->views ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <strong>Tanggal Publikasi:</strong>
                                <span class="ms-2">{{ date('d/m/Y H:i', strtotime($announcement->tanggal_publikasi)) }}</span>
                            </div>
                        </div>
                    </div>

                    @if($announcement->gambar)
                        <div class="mb-4">
                            <strong>Gambar:</strong>
                            <div class="mt-2">
                                <img src="{{ $announcement->gambar }}" alt="{{ $announcement->judul }}" 
                                     class="img-fluid rounded shadow" style="max-height: 400px;">
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <strong>Isi Pengumuman:</strong>
                        <div class="mt-3 p-3 bg-light rounded">
                            {!! nl2br(e($announcement->isi)) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <strong>Slug:</strong>
                                <code>{{ $announcement->slug }}</code>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-6">
                            <small>
                                <i class="fas fa-calendar-plus"></i>
                                Dibuat: {{ date('d/m/Y H:i', strtotime($announcement->created_at)) }}
                            </small>
                        </div>
                        <div class="col-md-6 text-end">
                            <small>
                                <i class="fas fa-calendar-edit"></i>
                                Terakhir diupdate: {{ date('d/m/Y H:i', strtotime($announcement->updated_at)) }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 text-center">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Pengumuman
                    </a>
                    
                    <button class="btn btn-info toggle-status" 
                            data-id="{{ $announcement->id }}" 
                            data-current-status="{{ $announcement->status }}">
                        <i class="fas fa-toggle-on"></i>
                        {{ $announcement->status === 'published' ? 'Set sebagai Draft' : 'Publish Pengumuman' }}
                    </button>

                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" 
                          method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus Pengumuman
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .info-item {
        margin-bottom: 0.75rem;
        padding: 0.5rem 0;
    }
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    code {
        color: #e83e8c;
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
    }
    .bg-light {
        background-color: #f8f9fa !important;
        border: 1px solid #e9ecef;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
        if (!confirm('Yakin ingin menghapus pengumuman ini? Tindakan ini tidak dapat dibatalkan!')) {
            e.preventDefault();
        }
    });

    // Toggle status
    document.querySelector('.toggle-status')?.addEventListener('click', function() {
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
</script>
@endpush