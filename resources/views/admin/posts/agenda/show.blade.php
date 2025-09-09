@extends('layouts.admin')

@section('title', 'Detail Agenda')

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
        background: linear-gradient(45deg, #2c3e50, #3498db);
        color: white;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .agenda-header h1 {
        font-size: 2.5em;
        margin: 0;
    }

    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 10px;
        font-size: 1em;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        margin-left: 10px;
    }

    .btn-secondary {
        background: linear-gradient(45deg, #95a5a6, #7f8c8d);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(45deg, #f39c12, #e67e22);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        color: white;
        text-decoration: none;
    }

    .agenda-content {
        padding: 30px;
    }

    .detail-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .detail-header {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 20px;
        align-items: start;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #ecf0f1;
    }

    .agenda-title {
        font-size: 2em;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.9em;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status-upcoming { background: #3498db; color: white; }
    .status-ongoing { background: #2ecc71; color: white; }
    .status-completed { background: #95a5a6; color: white; }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    .detail-item {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border-left: 4px solid #3498db;
    }

    .detail-label {
        font-size: 0.9em;
        font-weight: 600;
        color: #7f8c8d;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .detail-value {
        font-size: 1.1em;
        color: #2c3e50;
        font-weight: 500;
    }

    .content-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .content-section h3 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 1.4em;
    }

    .content-text {
        color: #34495e;
        line-height: 1.8;
        font-size: 1.1em;
    }

    .meta-info {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .meta-info h4 {
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .meta-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #ecf0f1;
    }

    .meta-item:last-child {
        border-bottom: none;
    }

    .meta-label {
        font-weight: 600;
        color: #7f8c8d;
    }

    .meta-value {
        color: #2c3e50;
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

    .countdown-timer {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 1.2em;
    }

    @media (max-width: 768px) {
        .agenda-header {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .agenda-header h1 {
            font-size: 2em;
        }

        .detail-header {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .agenda-content {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="agenda-container">
    <div class="agenda-wrapper">
        <div class="agenda-header">
            <h1>📋 Detail Agenda</h1>
            <div>
                <a href="{{ route('admin.posts.agenda.index') }}" class="btn btn-secondary">
                    ↩️ Kembali
                </a>
                <a href="{{ route('admin.posts.agenda.edit', $agenda->id) }}" class="btn btn-warning">
                    ✏️ Edit
                </a>
                <form action="{{ route('admin.posts.agenda.destroy', $agenda->id) }}" 
                      method="POST" 
                      style="display: inline-block;"
                      onsubmit="return confirm('Yakin ingin menghapus agenda ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        🗑️ Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="agenda-content">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Countdown Timer (jika agenda belum berlangsung) --}}
            @php
                $eventDate = \Carbon\Carbon::parse($agenda->event_date);
                $now = \Carbon\Carbon::now();
                
                if ($eventDate->isToday()) {
                    $status = 'ongoing';
                    $statusText = 'Berlangsung Hari Ini';
                } elseif ($eventDate->isFuture()) {
                    $status = 'upcoming';
                    $statusText = 'Akan Datang';
                    $diffInDays = $now->diffInDays($eventDate);
                } else {
                    $status = 'completed';
                    $statusText = 'Telah Selesai';
                }
            @endphp

            @if($status === 'upcoming')
                <div class="countdown-timer">
                    ⏰ Agenda akan dimulai dalam {{ $diffInDays }} hari
                </div>
            @elseif($status === 'ongoing')
                <div class="countdown-timer" style="background: linear-gradient(45deg, #2ecc71, #27ae60);">
                    🔴 Agenda sedang berlangsung hari ini!
                </div>
            @endif

            <div class="detail-card">
                <div class="detail-header">
                    <h2 class="agenda-title">{{ $agenda->title }}</h2>
                    <span class="status-badge status-{{ $status }}">
                        {{ $statusText }}
                    </span>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">📅 Tanggal Kegiatan</div>
                        <div class="detail-value">
                            {{ $eventDate->format('l, d F Y') }}
                            @if($agenda->event_time)
                                <br><small>🕐 {{ \Carbon\Carbon::parse($agenda->event_time)->format('H:i') }} WIB</small>
                            @endif
                        </div>
                    </div>

                    @if($agenda->location)
                        <div class="detail-item">
                            <div class="detail-label">📍 Lokasi</div>
                            <div class="detail-value">{{ $agenda->location }}</div>
                        </div>
                    @endif

                    @if($agenda->organizer)
                        <div class="detail-item">
                            <div class="detail-label">👤 Penyelenggara</div>
                            <div class="detail-value">{{ $agenda->organizer }}</div>
                        </div>
                    @endif

                    <div class="detail-item">
                        <div class="detail-label">📊 Status</div>
                        <div class="detail-value">
                            <span class="status-badge status-{{ $status }}" style="font-size: 0.8em;">
                                {{ $statusText }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($agenda->content)
                    <div class="content-section">
                        <h3>📝 Deskripsi Kegiatan</h3>
                        <div class="content-text">
                            {!! nl2br(e($agenda->content)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <div class="meta-info">
                <h4>ℹ️ Informasi Tambahan</h4>
                <div class="meta-item">
                    <span class="meta-label">Dibuat pada:</span>
                    <span class="meta-value">{{ $agenda->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Terakhir diperbarui:</span>
                    <span class="meta-value">{{ $agenda->updated_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">ID Agenda:</span>
                    <span class="meta-value">#{{ $agenda->id }}</span>
                </div>
                @if($eventDate->isFuture())
                    <div class="meta-item">
                        <span class="meta-label">Waktu tersisa:</span>
                        <span class="meta-value">{{ $eventDate->diffForHumans() }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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

    // Real-time countdown untuk agenda yang akan datang
    @if($status === 'upcoming')
    function updateCountdown() {
        const eventDate = new Date('{{ $eventDate->toISOString() }}');
        const now = new Date();
        const diff = eventDate - now;
        
        if (diff > 0) {
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            
            const countdownElement = document.querySelector('.countdown-timer');
            if (countdownElement) {
                countdownElement.innerHTML = `⏰ Agenda akan dimulai dalam ${days} hari, ${hours} jam, ${minutes} menit`;
            }
        }
    }
    
    // Update setiap menit
    setInterval(updateCountdown, 60000);
    updateCountdown();
    @endif
</script>
@endpush