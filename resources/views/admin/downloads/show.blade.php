@extends('layouts.admin')

@section('title', 'Detail Download')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Download</h1>
        <div>
            <a href="{{ route('admin.downloads.edit', $id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.downloads.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Info -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Download</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <div class="download-icon-large">
                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h4 class="mb-2">Sample Download Title</h4>
                            <p class="text-muted mb-3">Sample description for this download item. This would contain detailed information about the file content and purpose.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-2">
                                        <strong>Kategori:</strong> Materi Pembelajaran
                                    </div>
                                    <div class="info-item mb-2">
                                        <strong>Status:</strong> 
                                        <span class="badge bg-success">Aktif</span>
                                    </div>
                                    <div class="info-item mb-2">
                                        <strong>Featured:</strong> 
                                        <span class="badge bg-warning">Ya</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-2">
                                        <strong>Ukuran File:</strong> 2.5 MB
                                    </div>
                                    <div class="info-item mb-2">
                                        <strong>Format:</strong> PDF
                                    </div>
                                    <div class="info-item mb-2">
                                        <strong>Diupload:</strong> {{ now()->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <strong>Tags:</strong>
                                <span class="badge bg-secondary me-1">matematika</span>
                                <span class="badge bg-secondary me-1">kelas 10</span>
                                <span class="badge bg-secondary me-1">semester 1</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Preview -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Preview File</h6>
                </div>
                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="fas fa-eye fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Preview Tidak Tersedia</h5>
                        <p class="text-muted">Preview file akan ditampilkan di sini untuk format yang didukung.</p>
                        <button class="btn btn-primary">
                            <i class="fas fa-download me-2"></i>Download File
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Download</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h2 class="text-primary">245</h2>
                        <p class="text-muted mb-0">Total Download</p>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="text-success">12</h5>
                                <small class="text-muted">Hari Ini</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="text-info">89</h5>
                            <small class="text-muted">Bulan Ini</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Information -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi File</h6>
                </div>
                <div class="card-body">
                    <div class="info-item mb-2">
                        <strong>Nama File:</strong><br>
                        <small class="text-muted">sample-document.pdf</small>
                    </div>
                    <div class="info-item mb-2">
                        <strong>MIME Type:</strong><br>
                        <small class="text-muted">application/pdf</small>
                    </div>
                    <div class="info-item mb-2">
                        <strong>Hash (MD5):</strong><br>
                        <small class="text-muted font-monospace">d41d8cd98f00b204e9800998ecf8427e</small>
                    </div>
                    <div class="info-item mb-2">
                        <strong>Path:</strong><br>
                        <small class="text-muted">/storage/downloads/sample-document.pdf</small>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success">
                            <i class="fas fa-download me-2"></i>Download File
                        </button>
                        <button class="btn btn-info">
                            <i class="fas fa-link me-2"></i>Salin Link
                        </button>
                        <button class="btn btn-warning">
                            <i class="fas fa-star me-2"></i>Toggle Featured
                        </button>
                        <hr>
                        <button class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Hapus Download
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item mb-3">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">File didownload</h6>
                                <small class="text-muted">2 jam yang lalu</small>
                            </div>
                        </div>
                        <div class="timeline-item mb-3">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">File diedit</h6>
                                <small class="text-muted">1 hari yang lalu</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">File diupload</h6>
                                <small class="text-muted">3 hari yang lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.download-icon-large {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    border-radius: 10px;
}

.info-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item {
    position: relative;
}

.timeline-marker {
    position: absolute;
    left: -16px;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.timeline-content h6 {
    font-size: 0.9rem;
    margin-bottom: 2px;
}
</style>

<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus download ini? Tindakan ini tidak dapat dibatalkan.')) {
        // In real implementation, this would submit a delete form
        alert('Fitur hapus akan diimplementasi dengan form submission');
    }
}

// Copy link functionality
document.querySelector('.btn-info').addEventListener('click', function() {
    const link = window.location.origin + '/downloads/{{ $id }}';
    navigator.clipboard.writeText(link).then(function() {
        alert('Link berhasil disalin ke clipboard!');
    });
});
</script>
@endsection