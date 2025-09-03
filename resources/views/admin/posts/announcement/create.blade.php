@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Tambah Pengumuman</h1>
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.announcements.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                                    <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" 
                                           value="{{ old('judul') }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="isi" class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                                    <textarea name="isi" id="isi" class="form-control @error('isi') is-invalid @enderror" 
                                              rows="10" required>{{ old('isi') }}</textarea>
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label">URL Gambar</label>
                                    <input type="url" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" 
                                           value="{{ old('gambar') }}" placeholder="https://example.com/image.jpg">
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="akademik" {{ old('kategori') === 'akademik' ? 'selected' : '' }}>Akademik</option>
                                        <option value="kegiatan" {{ old('kategori') === 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                        <option value="administrasi" {{ old('kategori') === 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                                        <option value="umum" {{ old('kategori') === 'umum' ? 'selected' : '' }}>Umum</option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="prioritas" class="form-label">Prioritas <span class="text-danger">*</span></label>
                                    <select name="prioritas" id="prioritas" class="form-select @error('prioritas') is-invalid @enderror" required>
                                        <option value="">Pilih Prioritas</option>
                                        <option value="rendah" {{ old('prioritas') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                                        <option value="sedang" {{ old('prioritas') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="tinggi" {{ old('prioritas') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    </select>
                                    @error('prioritas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                                    <input type="text" name="penulis" id="penulis" class="form-control @error('penulis') is-invalid @enderror" 
                                           value="{{ old('penulis', auth()->user()->name ?? '') }}" required>
                                    @error('penulis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                                    <input type="datetime-local" name="tanggal_publikasi" id="tanggal_publikasi" 
                                           class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                                           value="{{ old('tanggal_publikasi', now()->format('Y-m-d\TH:i')) }}">
                                    @error('tanggal_publikasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Kembali</a>
                            <div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Pengumuman
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
</style>
@endpush