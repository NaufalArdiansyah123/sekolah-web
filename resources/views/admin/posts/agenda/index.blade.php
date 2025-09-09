@extends('layouts.admin')

@section('title', 'Tambah Agenda')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .agenda-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .agenda-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        overflow: hidden;
    }

    .agenda-header {
        background: linear-gradient(45deg, #2c3e50, #3498db);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .agenda-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
    }

    .agenda-header h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
    }

    .agenda-header p {
        font-size: 1.1em;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    .agenda-content {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 30px;
        padding: 30px;
    }

    .form-section {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 1em;
    }

    .form-control {
        width: 100%;
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 1em;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-control:focus {
        outline: none;
        border-color: #3498db;
        background: white;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.2);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .btn {
        padding: 15px 30px;
        border: none;
        border-radius: 10px;
        font-size: 1.1em;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background: linear-gradient(45deg, #3498db, #2980b9);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: linear-gradient(45deg, #95a5a6, #7f8c8d);
        color: white;
        margin-left: 15px;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(149, 165, 166, 0.3);
        color: white;
        text-decoration: none;
    }

    .sidebar {
        background: white;
        border-radius: 15px;
        padding: 25px;
        height: fit-content;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .agenda-list {
        margin-top: 20px;
    }

    .agenda-item {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        border-left: 4px solid #3498db;
        transition: all 0.3s ease;
    }

    .agenda-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .agenda-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .agenda-date {
        font-size: 0.9em;
        color: #7f8c8d;
    }

    .alert {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: linear-gradient(45deg, #2ecc71, #27ae60);
        color: white;
        border: none;
    }

    .alert-danger {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
        border: none;
    }

    .category-badge {
        display: inline-block;
        padding: 4px 12px;
        background: #3498db;
        color: white;
        border-radius: 20px;
        font-size: 0.8em;
        margin-top: 5px;
    }

    .priority-high { background: #e74c3c; }
    .priority-medium { background: #f39c12; }
    .priority-low { background: #2ecc71; }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .agenda-content {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .agenda-header h1 {
            font-size: 2em;
        }
    }
</style>
@endpush

@section('content')
<div class="agenda-container">
    <div class="agenda-wrapper">
        <div class="agenda-header">
            <h1>📅 Tambah Agenda Sekolah</h1>
            <p>Kelola agenda dan kegiatan sekolah dengan mudah</p>
        </div>

        <div class="agenda-content">
            <div class="form-section">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        ❌ {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.agenda.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="judul">Judul Agenda *</label>
                        <input type="text" 
                               id="judul" 
                               name="judul" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               placeholder="Masukkan judul agenda" 
                               value="{{ old('judul') }}" 
                               required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" 
                                  name="deskripsi" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  placeholder="Masukkan deskripsi agenda">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tanggal">Tanggal *</label>
                            <input type="date" 
                                   id="tanggal" 
                                   name="tanggal" 
                                   class="form-control @error('tanggal') is-invalid @enderror" 
                                   value="{{ old('tanggal', date('Y-m-d')) }}" 
                                   required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="waktu">Waktu</label>
                            <input type="time" 
                                   id="waktu" 
                                   name="waktu" 
                                   class="form-control @error('waktu') is-invalid @enderror" 
                                   value="{{ old('waktu') }}">
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select id="kategori" 
                                    name="kategori" 
                                    class="form-control @error('kategori') is-invalid @enderror">
                                <option value="">Pilih Kategori</option>
                                <option value="akademik" {{ old('kategori') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="ekstrakurikuler" {{ old('kategori') == 'ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler</option>
                                <option value="administrasi" {{ old('kategori') == 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                                <option value="acara" {{ old('kategori') == 'acara' ? 'selected' : '' }}>Acara Sekolah</option>
                                <option value="rapat" {{ old('kategori') == 'rapat' ? 'selected' : '' }}>Rapat</option>
                                <option value="ujian" {{ old('kategori') == 'ujian' ? 'selected' : '' }}>Ujian</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prioritas">Prioritas</label>
                            <select id="prioritas" 
                                    name="prioritas" 
                                    class="form-control @error('prioritas') is-invalid @enderror">
                                <option value="low" {{ old('prioritas') == 'low' ? 'selected' : '' }}>Rendah</option>
                                <option value="medium" {{ old('prioritas', 'medium') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                <option value="high" {{ old('prioritas') == 'high' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                            @error('prioritas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" 
                               id="lokasi" 
                               name="lokasi" 
                               class="form-control @error('lokasi') is-invalid @enderror" 
                               placeholder="Masukkan lokasi kegiatan" 
                               value="{{ old('lokasi') }}">
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="penanggung_jawab">Penanggung Jawab</label>
                        <input type="text" 
                               id="penanggung_jawab" 
                               name="penanggung_jawab" 
                               class="form-control @error('penanggung_jawab') is-invalid @enderror" 
                               placeholder="Nama penanggung jawab" 
                               value="{{ old('penanggung_jawab') }}">
                        @error('penanggung_jawab')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="text-align: center; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary">💾 Simpan Agenda</button>
                        <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">📋 Lihat Agenda</a>
                    </div>
                </form>
            </div>

            <div class="sidebar">
                <h3 style="color: #2c3e50; margin-bottom: 20px;">📋 Agenda Terbaru</h3>
                <div class="agenda-list">
                    @forelse($latestAgendas ?? [] as $agenda)
                        <div class="agenda-item">
                            <div class="agenda-title">{{ $agenda->judul }}</div>
                            <div class="agenda-date">
                                📅 {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}
                                @if($agenda->waktu)
                                    🕐 {{ \Carbon\Carbon::parse($agenda->waktu)->format('H:i') }}
                                @endif
                            </div>
                            @if($agenda->kategori)
                                <span class="category-badge priority-{{ $agenda->prioritas }}">
                                    {{ ucfirst($agenda->kategori) }}
                                </span>
                            @endif
                            @if($agenda->lokasi)
                                <div style="font-size: 0.9em; color: #7f8c8d; margin-top: 5px;">
                                    📍 {{ $agenda->lokasi }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <p style="color: #7f8c8d; text-align: center;">Belum ada agenda</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.agenda-wrapper');
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            container.style.transition = 'all 0.5s ease';
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, 100);
    });

    // Auto-hide success message
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 300);
            }, 3000);
        }
    });
</script>
@endpush