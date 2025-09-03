@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Edit Pengumuman</h1>
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                    <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" 
                                           value="{{ old('judul', $announcement->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="isi" class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                                    <textarea name="isi" id="isi" class="form-control @error('isi') is-invalid @enderror" 
                                              rows="10" required>{{ old('isi', $announcement->isi) }}</textarea>
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label">URL Gambar</label>
                                    <input type="url" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" 
                                           value="{{ old('gambar', $announcement->gambar) }}" placeholder="https://example.com/image.jpg">
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($announcement->gambar)
                                        <div class="mt-2">
                                            <small class="text-muted">Gambar saat ini:</small><br>
                                            <img src="{{ $announcement->gambar }}" alt="Current image" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="akademik" {{ old('kategori', $announcement->kategori) === 'akademik' ? 'selected' : '' }}>Akademik</option>
                                        <option value="kegiatan" {{ old('kategori', $announcement->kategori) === 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                        <option value="administrasi" {{ old('kategori', $announcement->kategori) === 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                                        <option value="umum" {{ old('kategori', $announcement->kategori) === 'umum' ? 'selected' : '' }}>Umum</option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="prioritas" class="form-label">Prioritas <span class="text-danger">*</span></label>
                                    <select name="prioritas" id="prioritas" class="form-select @error('prioritas') is-invalid @enderror" required>
                                        <option value="">Pilih Prioritas</option>
                                        <option value="rendah" {{ old('prioritas', $announcement->prioritas) === 'rendah' ? 'selected' : '' }}>Rendah</option>
                                        <option value="sedang" {{ old('prioritas', $announcement->prioritas) === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="tinggi" {{ old('prioritas', $announcement->prioritas) === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    </select>
                                    @error('prioritas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                                    <input type="text" name="penulis" id="penulis" class="form-control @error('penulis') is-invalid @enderror" 
                                           value="{{ old('penulis', $announcement->penulis) }}" required>
                                    @error('penulis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="draft" {{ old('status', $announcement->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $announcement->status) === 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="archived" {{ old('status', $announcement->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                                    <input type="datetime-local" name="tanggal_publikasi" id="tanggal_publikasi" 
                                           class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                                           value="{{ old('tanggal_publikasi', $announcement->tanggal_publikasi ? date('Y-m-d\TH:i', strtotime($announcement->tanggal_publikasi)) : '') }}">
                                    @error('tanggal_publikasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Info Tambahan</label>
                                    <div class="small text-muted">
                                        <div>Views: {{ $announcement->views ?? 0 }}</div>
                                        <div>Slug: {{ $announcement->slug }}</div>
                                        <div>Dibuat: {{ $announcement->created_at }}</div>
                                        <div>Diupdate: {{ $announcement->updated_at }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Kembali</a>
                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Pengumuman
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 600;
    }
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .img-thumbnail {
        border-radius: 0.375rem;
    }
</style>
@endpush