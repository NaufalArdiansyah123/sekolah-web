@extends('layouts.admin')

@section('title', 'Edit Download')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Download</h1>
        <div>
            <a href="{{ route('admin.downloads.show', $id) }}" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i>Lihat Detail
            </a>
            <a href="{{ route('admin.downloads.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Informasi Download</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.downloads.update', $id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Judul Download <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', 'Sample Download Title') }}" 
                                   placeholder="Masukkan judul download" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Masukkan deskripsi download">{{ old('description', 'Sample description for this download item. This would contain detailed information about the file content and purpose.') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category') is-invalid @enderror" 
                                            id="category" name="category" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="materi" {{ old('category', 'materi') == 'materi' ? 'selected' : '' }}>Materi Pembelajaran</option>
                                        <option value="dokumentasi" {{ old('category') == 'dokumentasi' ? 'selected' : '' }}>Dokumentasi Kegiatan</option>
                                        <option value="resmi" {{ old('category') == 'resmi' ? 'selected' : '' }}>Dokumen Resmi</option>
                                        <option value="ebook" {{ old('category') == 'ebook' ? 'selected' : '' }}>E-Book & Jurnal</option>
                                        <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>Software & Tools</option>
                                        <option value="template" {{ old('category') == 'template' ? 'selected' : '' }}>Template & Format</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="file" class="form-label">Ganti File (Opsional)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file">
                            <div class="form-text">
                                Biarkan kosong jika tidak ingin mengganti file. 
                                Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR, JPG, PNG, MP4. 
                                Maksimal ukuran file: 50MB
                            </div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current File Info -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>File Saat Ini</h6>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                <div>
                                    <strong>sample-document.pdf</strong><br>
                                    <small class="text-muted">2.5 MB • Diupload {{ now()->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                                   {{ old('featured', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                Jadikan download unggulan
                            </label>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags" 
                                   value="{{ old('tags', 'matematika, kelas 10, semester 1') }}" 
                                   placeholder="Pisahkan dengan koma (contoh: matematika, kelas 10, semester 1)">
                            <div class="form-text">Tags membantu dalam pencarian dan kategorisasi</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.downloads.show', $id) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Saat Ini</h6>
                </div>
                <div class="card-body text-center">
                    <h3 class="text-primary">245</h3>
                    <p class="text-muted mb-3">Total Download</p>
                    
                    <div class="row">
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

            <!-- Edit Guidelines -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Panduan Edit</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-info"><i class="fas fa-lightbulb me-2"></i>Tips Edit</h6>
                        <ul class="list-unstyled small">
                            <li>• Pastikan judul deskriptif dan mudah dipahami</li>
                            <li>• Gunakan deskripsi yang informatif</li>
                            <li>• Pilih kategori yang sesuai</li>
                            <li>• Tambahkan tags untuk memudahkan pencarian</li>
                            <li>• Aktifkan featured untuk download penting</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning small">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Mengganti file akan menghapus file lama. 
                        Pastikan file baru sudah benar sebelum menyimpan.
                    </div>
                </div>
            </div>

            <!-- Version History -->
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Perubahan</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item mb-3">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">File dibuat</h6>
                                <small class="text-muted">3 hari yang lalu</small>
                            </div>
                        </div>
                        <div class="timeline-item mb-3">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Deskripsi diperbarui</h6>
                                <small class="text-muted">2 hari yang lalu</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Status featured diaktifkan</h6>
                                <small class="text-muted">1 hari yang lalu</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
document.addEventListener('DOMContentLoaded', function() {
    // File upload preview
    const fileInput = document.getElementById('file');
    const fileInfo = document.createElement('div');
    fileInfo.className = 'mt-2 small text-muted';
    fileInput.parentNode.appendChild(fileInfo);

    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const size = (file.size / 1024 / 1024).toFixed(2);
            fileInfo.innerHTML = `
                <div class="alert alert-success">
                    <i class="fas fa-file me-2"></i>
                    <strong>File baru:</strong> ${file.name} (${size} MB)
                </div>
            `;
        } else {
            fileInfo.innerHTML = '';
        }
    });

    // Confirm file replacement
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const fileInput = document.getElementById('file');
        if (fileInput.files && fileInput.files[0]) {
            if (!confirm('Anda akan mengganti file yang ada. File lama akan dihapus. Lanjutkan?')) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection