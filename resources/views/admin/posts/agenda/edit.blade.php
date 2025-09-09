@extends('layouts.admin')

@section('title', 'Edit Agenda')

@push('styles')
<style>
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
        background: linear-gradient(45deg, #f39c12, #e67e22);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
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

    .form-section {
        padding: 30px;
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
        border-color: #f39c12;
        background: white;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(243, 156, 18, 0.2);
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

    .btn-warning {
        background: linear-gradient(45deg, #f39c12, #e67e22);
        color: white;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(243, 156, 18, 0.3);
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

    .btn-info {
        background: linear-gradient(45deg, #3498db, #2980b9);
        color: white;
        margin-right: 15px;
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
        color: white;
        text-decoration: none;
    }

    .alert {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: none;
    }

    .alert-success {
        background: linear-gradient(45deg, #2ecc71, #27ae60);
        color: white;
    }

    .alert-danger {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
    }

    .alert-warning {
        background: linear-gradient(45deg, #f39c12, #e67e22);
        color: white;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 5px;
    }

    .info-box {
        background: #e3f2fd;
        border: 1px solid #2196f3;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 25px;
    }

    .info-box h4 {
        color: #1976d2;
        margin-bottom: 10px;
    }

    .info-box p {
        color: #1565c0;
        margin: 0;
        font-size: 0.95em;
    }

    .status-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .status-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        border: 2px solid #e9ecef;
    }

    .status-card.current {
        border-color: #f39c12;
        background: #fff8e1;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .agenda-header h1 {
            font-size: 2em;
        }

        .form-section {
            padding: 20px;
        }

        .status-info {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="agenda-container">
    <div class="agenda-wrapper">
        <div class="agenda-header">
            <h1>✏️ Edit Agenda</h1>
            <p>Perbarui informasi agenda kegiatan</p>
        </div>

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

            {{-- Info Box --}}
            <div class="info-box">
                <h4>📋 Informasi Agenda</h4>
                <p>Anda sedang mengedit agenda: <strong>{{ $agenda->title }}</strong></p>
                <p>Dibuat pada: {{ $agenda->created_at->format('d M Y, H:i') }}</p>
            </div>

            {{-- Status Info --}}
            @php
                $eventDate = \Carbon\Carbon::parse($agenda->event_date);
                $now = \Carbon\Carbon::now();
                
                if ($eventDate->isToday()) {
                    $status = 'ongoing';
                    $statusText = 'Berlangsung Hari Ini';
                    $statusColor = '#2ecc71';
                } elseif ($eventDate->isFuture()) {
                    $status = 'upcoming';
                    $statusText = 'Akan Datang';
                    $statusColor = '#3498db';
                } else {
                    $status = 'completed';
                    $statusText = 'Telah Selesai';
                    $statusColor = '#95a5a6';
                }
            @endphp

            <div class="status-info">
                <div class="status-card current">
                    <strong>Status Saat Ini</strong>
                    <div style="color: {{ $statusColor }}; font-weight: bold; margin-top: 5px;">
                        {{ $statusText }}
                    </div>
                </div>
                <div class="status-card">
                    <strong>Tanggal Kegiatan</strong>
                    <div style="margin-top: 5px;">
                        {{ $eventDate->format('d M Y') }}
                    </div>
                </div>
                <div class="status-card">
                    <strong>Waktu Tersisa</strong>
                    <div style="margin-top: 5px;">
                        {{ $eventDate->diffForHumans() }}
                    </div>
                </div>
            </div>

            @if($status === 'completed')
                <div class="alert alert-warning">
                    ⚠️ Perhatian: Agenda ini sudah selesai. Pastikan perubahan yang Anda buat sudah benar.
                </div>
            @endif

            <form action="{{ route('admin.posts.agenda.update', $agenda->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title">Judul Agenda *</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           placeholder="Masukkan judul agenda" 
                           value="{{ old('title', $agenda->title) }}" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Deskripsi Agenda *</label>
                    <textarea id="content" 
                              name="content" 
                              class="form-control @error('content') is-invalid @enderror" 
                              placeholder="Masukkan deskripsi lengkap agenda"
                              required>{{ old('content', $agenda->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="event_date">Tanggal Kegiatan *</label>
                        <input type="date" 
                               id="event_date" 
                               name="event_date" 
                               class="form-control @error('event_date') is-invalid @enderror" 
                               value="{{ old('event_date', $agenda->event_date) }}" 
                               required>
                        @error('event_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="event_time">Waktu Kegiatan</label>
                        <input type="time" 
                               id="event_time" 
                               name="event_time" 
                               class="form-control @error('event_time') is-invalid @enderror" 
                               value="{{ old('event_time', $agenda->event_time) }}">
                        @error('event_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="location">Lokasi Kegiatan</label>
                    <input type="text" 
                           id="location" 
                           name="location" 
                           class="form-control @error('location') is-invalid @enderror" 
                           placeholder="Masukkan lokasi kegiatan" 
                           value="{{ old('location', $agenda->location) }}">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="organizer">Penyelenggara</label>
                    <input type="text" 
                           id="organizer" 
                           name="organizer" 
                           class="form-control @error('organizer') is-invalid @enderror" 
                           placeholder="Nama penyelenggara/penanggung jawab" 
                           value="{{ old('organizer', $agenda->organizer) }}">
                    @error('organizer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hidden field untuk type -->
                <input type="hidden" name="type" value="agenda">

                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ route('admin.posts.agenda.show', $agenda->id) }}" class="btn btn-info">👁️ Lihat Detail</a>
                    <button type="submit" class="btn btn-warning">💾 Update Agenda</button>
                    <a href="{{ route('admin.posts.agenda.index') }}" class="btn btn-secondary">📋 Kembali</a>
                </div>
            </form>
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

    // Konfirmasi perubahan tanggal jika agenda sudah lewat
    document.getElementById('event_date').addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        const originalDate = new Date('{{ $agenda->event_date }}');
        
        if (selectedDate < today && originalDate >= today) {
            if (!confirm('Anda mengubah tanggal agenda menjadi tanggal yang sudah lewat. Apakah Anda yakin?')) {
                this.value = '{{ $agenda->event_date }}';
            }
        }
    });
</script>
@endpush