@extends('layouts.admin')

@section('title', 'Tambah Download Baru')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Download Baru</h1>
        <a href="{{ route('admin.downloads.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Download</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Judul Download <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Masukkan judul download" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Masukkan deskripsi download">{{ old('description') }}</textarea>
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
                                        <option value="materi" {{ old('category') == 'materi' ? 'selected' : '' }}>Materi Pembelajaran</option>
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
                            <label for="file" class="form-label">File Upload <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file" required>
                            <div class="form-text">
                                Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR, JPG, PNG, MP4. 
                                Maksimal ukuran file: 50MB
                            </div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                                   {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                Jadikan download unggulan
                            </label>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags" 
                                   value="{{ old('tags') }}" 
                                   placeholder="Pisahkan dengan koma (contoh: matematika, kelas 10, semester 1)">
                            <div class="form-text">Tags membantu dalam pencarian dan kategorisasi</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.downloads.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Download
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Upload Guidelines -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Panduan Upload</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-success"><i class="fas fa-check-circle me-2"></i>Format yang Didukung</h6>
                        <ul class="list-unstyled small">
                            <li><i class="fas fa-file-pdf text-danger me-2"></i>PDF</li>
                            <li><i class="fas fa-file-word text-primary me-2"></i>DOC, DOCX</li>
                            <li><i class="fas fa-file-excel text-success me-2"></i>XLS, XLSX</li>
                            <li><i class="fas fa-file-powerpoint text-warning me-2"></i>PPT, PPTX</li>
                            <li><i class="fas fa-file-archive text-secondary me-2"></i>ZIP, RAR</li>
                            <li><i class="fas fa-image text-info me-2"></i>JPG, PNG</li>
                            <li><i class="fas fa-video text-dark me-2"></i>MP4</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-info"><i class="fas fa-info-circle me-2"></i>Tips Upload</h6>
                        <ul class="list-unstyled small">
                            <li>• Gunakan nama file yang deskriptif</li>
                            <li>• Pastikan file tidak rusak</li>
                            <li>• Kompres file besar jika perlu</li>
                            <li>• Periksa konten sebelum upload</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning small">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> File yang diupload akan tersedia untuk umum. 
                        Pastikan tidak mengandung informasi sensitif.
                    </div>
                </div>
            </div>

            <!-- Category Info -->
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Kategori</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="mb-2">
                            <strong>Materi Pembelajaran:</strong> Silabus, RPP, modul, soal latihan
                        </div>
                        <div class="mb-2">
                            <strong>Dokumentasi:</strong> Foto kegiatan, video, album
                        </div>
                        <div class="mb-2">
                            <strong>Dokumen Resmi:</strong> Formulir, surat edaran, peraturan
                        </div>
                        <div class="mb-2">
                            <strong>E-Book:</strong> Buku digital, jurnal, referensi
                        </div>
                        <div class="mb-2">
                            <strong>Software:</strong> Aplikasi, tools, plugin
                        </div>
                        <div class="mb-0">
                            <strong>Template:</strong> Format surat, desain, layout
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                <i class="fas fa-file me-2"></i>
                <strong>${file.name}</strong> (${size} MB)
            `;
        } else {
            fileInfo.innerHTML = '';
        }
    });

    // Auto-generate title from filename
    fileInput.addEventListener('change', function() {
        const titleInput = document.getElementById('title');
        if (this.files && this.files[0] && !titleInput.value) {
            const filename = this.files[0].name;
            const nameWithoutExt = filename.substring(0, filename.lastIndexOf('.')) || filename;
            titleInput.value = nameWithoutExt.replace(/[-_]/g, ' ');
        }
    });
});
</script>
@endsection