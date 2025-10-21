@extends('layouts.teacher')

@section('title', 'QR Code Absensi Saya')

@push('styles')
<style>
/***** Dark mode compatibility for teacher QR display *****/
html.dark body .card { background-color: #111827; color: #e5e7eb; border-color: #1f2937; }
html.dark body .card-header { border-color: transparent; }
html.dark body .text-dark { color: #e5e7eb !important; }
html.dark body .text-muted, html.dark body .small.text-muted { color: #9ca3af !important; }
html.dark body .alert-warning { background-color: rgba(251, 191, 36, .15); color: #fcd34d; border-color: rgba(251, 191, 36, .25); }
html.dark body .alert-danger { background-color: rgba(239, 68, 68, .15); color: #fca5a5; border-color: rgba(239, 68, 68, .25); }
html.dark body .badge.bg-success-subtle { background-color: rgba(16, 185, 129, .15) !important; color: #34d399 !important; }
html.dark body .badge.bg-warning-subtle { background-color: rgba(245, 158, 11, .15) !important; color: #fbbf24 !important; }
html.dark body .badge.bg-primary-subtle { background-color: rgba(59, 130, 246, .15) !important; color: #93c5fd !important; }
html.dark body .badge.bg-danger-subtle { background-color: rgba(239, 68, 68, .15) !important; color: #fca5a5 !important; }
html.dark body .border-bottom { border-bottom-color: #1f2937 !important; }
html.dark body .modal-content { background-color: #0b1220; color: #e5e7eb; }

/* Local helpers */
.action-list .btn { width: 100%; text-align: left; display:flex; align-items:center; justify-content:space-between; }
.action-list .btn .left { display:flex; align-items:center; gap:.6rem; }
.section-title { font-weight: 700; margin-bottom:.5rem; }
.gradient-blue { background: linear-gradient(90deg,#3b82f6,#7c3aed); }
.gradient-green { background: linear-gradient(90deg,#10b981,#059669); }
.gradient-indigo { background: linear-gradient(90deg,#6366f1,#3b82f6); }
.qr-box { background:#fff; border:4px solid #bfdbfe; border-radius: .75rem; display:inline-block; padding:1.25rem; }
html.dark .qr-box { background:#111827; border-color:#1f2937; }
</style>
@endpush

@push('meta')
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="teacher-id" content="{{ $teacher->id }}">
<meta name="user-id" content="{{ auth()->id() }}">
<meta name="cache-buster" content="{{ time() }}">
@endpush

@section('content')
<div class="container-fluid px-3 px-sm-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-sm-between mb-4">
        <div class="mb-3 mb-sm-0">
            <h1 class="h3 fw-bold text-dark d-flex align-items-center">
                <div class="bg-gradient" style="background: linear-gradient(90deg,#3b82f6,#7c3aed); padding:.7rem; border-radius: .75rem; margin-right:.75rem;">
                    <i class="fas fa-qrcode text-white"></i>
                </div>
                QR Code Absensi Saya
            </h1>
            <div class="text-muted mt-2">Tunjukkan QR Code ini kepada petugas/guru piket untuk absensi</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('teacher.attendance.index') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-clipboard-check me-2"></i>Kelola Absensi
            </a>
        </div>
    </div>

    <div class="row g-4 row-cols-1 row-cols-md-2">
        <!-- Left: QR Panel -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header border-0 gradient-blue">
                    <h2 class="h6 text-white m-0 d-flex align-items-center"><i class="fas fa-qrcode me-2"></i>QR Code Absensi Anda</h2>
                </div>
                <div class="card-body text-center">
                    @if($qrAttendance && $qrAttendance->qr_image_url)
                        <div class="qr-box mb-3">
                            <img src="{{ $qrAttendance->qr_image_url }}" alt="QR Code {{ $teacher->name }}" class="img-fluid" style="width: 256px; height:256px; object-fit:contain;">
                        </div>
                        <div class="p-3 rounded-3 mb-3" style="background: linear-gradient(90deg, rgba(59,130,246,.08), rgba(124,58,237,.08));">
                            <div class="fw-bold text-dark">{{ $teacher->name }}</div>
                            <div class="small text-muted">NIP: {{ $teacher->nip ?? '-' }} • {{ $teacher->position ?? '-' }}</div>
                        </div>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <button type="button" class="btn btn-primary" data-action="open-modal" data-target="#qrCodeModal"><i class="fas fa-expand me-2"></i>Perbesar</button>
                            <a href="{{ route('teacher.qr.download') }}" class="btn btn-success"><i class="fas fa-download me-2"></i>Download</a>
                            <button type="button" class="btn btn-secondary" onclick="copyQrCode('{{ $qrAttendance->qr_code }}')"><i class="fas fa-copy me-2"></i>Salin Kode</button>
                        </div>
                        <div class="alert alert-warning mt-3 mb-0" role="alert">
                            <div class="d-flex">
                                <i class="fas fa-lightbulb me-2 mt-1"></i>
                                <div>
                                    <div class="fw-semibold">Petunjuk:</div>
                                    <ul class="mb-0 small">
                                        <li>Tunjukkan QR Code ini saat absensi</li>
                                        <li>Pastikan QR Code terlihat jelas</li>
                                        <li>Jangan berbagi QR Code dengan orang lain</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                QR Code Anda belum tersedia. Silakan hubungi administrator.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Data & Actions -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-0 gradient-green">
                    <h3 class="h6 text-white m-0">Ringkasan Hari Ini</h3>
                </div>
                <div class="card-body">
                    @if($todayAttendance)
                        @php
                            $icon = match($todayAttendance->status) {
                                'hadir' => 'fa-check-circle text-success',
                                'terlambat' => 'fa-clock text-warning',
                                'izin' => 'fa-user-clock text-primary',
                                'sakit' => 'fa-notes-medical text-purple',
                                default => 'fa-times-circle text-danger'
                            };
                            $badge = match($todayAttendance->status) {
                                'hadir' => 'bg-success-subtle text-success-emphasis',
                                'terlambat' => 'bg-warning-subtle text-warning-emphasis',
                                'izin' => 'bg-primary-subtle text-primary-emphasis',
                                'sakit' => 'bg-purple-subtle text-purple-emphasis',
                                default => 'bg-danger-subtle text-danger-emphasis'
                            };
                        @endphp
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas {{ $icon }} fs-2"></i>
                            <div>
                                <div class="fw-bold">{{ $todayAttendance->status_text }}</div>
                                <div class="small text-muted"><i class="fas fa-clock me-1"></i>{{ $todayAttendance->scan_time->format('H:i:s') }} • <i class="fas fa-user-check mx-1"></i>{{ $todayAttendance->scanned_by ?? 'Guru Piket' }}</div>
                            </div>
                            <span class="badge {{ $badge }} ms-auto px-3 py-2 fw-medium">Hari ini</span>
                        </div>
                    @else
                        <div class="text-muted">
                            <i class="fas fa-clock me-2"></i>Belum ada catatan absensi hari ini.
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header border-0 gradient-indigo d-flex align-items-center justify-content-between">
                    <h3 class="h6 text-white m-0">Aksi & Data</h3>
                </div>
                <div class="card-body action-list">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" data-action="open-modal" data-target="#historyModal">
                            <span class="left"><i class="fas fa-history"></i> Riwayat Absensi</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn btn-outline-success" data-action="open-modal" data-target="#monthlyStatsModal">
                            <span class="left"><i class="fas fa-chart-line"></i> Statistik Bulanan</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn btn-outline-secondary" data-action="open-modal" data-target="#infoModal">
                            <span class="left"><i class="fas fa-info-circle"></i> Panduan & Info</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Modal -->
<div id="qrCodeModal" class="modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header gradient-blue">
        <h5 class="modal-title text-white">QR Code Absensi</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        @if($qrAttendance && $qrAttendance->qr_image_url)
            <img src="{{ $qrAttendance->qr_image_url }}" alt="QR Code {{ $teacher->name }}" class="img-fluid mb-3" style="width: 320px; height:320px; object-fit:contain;">
            <div class="fw-bold">{{ $teacher->name }}</div>
            <div class="small text-muted">{{ $teacher->nip ?? '-' }} • {{ $teacher->position ?? '-' }}</div>
        @endif
      </div>
      <div class="modal-footer">
        <a href="{{ route('teacher.qr.download') }}" class="btn btn-primary"><i class="fas fa-download me-2"></i>Download</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- History Modal -->
<div id="historyModal" class="modal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header gradient-indigo">
        <h5 class="modal-title text-white"><i class="fas fa-history me-2"></i>Riwayat Absensi</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @forelse(($recentAttendance ?? collect()) as $attendance)
            @php
                $badge = match($attendance->status) {
                    'hadir' => 'bg-success-subtle text-success-emphasis',
                    'terlambat' => 'bg-warning-subtle text-warning-emphasis',
                    'izin' => 'bg-primary-subtle text-primary-emphasis',
                    'sakit' => 'bg-purple-subtle text-purple-emphasis',
                    default => 'bg-danger-subtle text-danger-emphasis'
                };
            @endphp
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                    <div class="small fw-semibold">{{ $attendance->attendance_date->format('d/m/Y') }}</div>
                    <span class="badge {{ $badge }} px-2 py-1 small">{{ $attendance->status_text }}</span>
                </div>
                <div class="small text-muted">{{ $attendance->scan_time->format('H:i') }}</div>
            </div>
        @empty
            <div class="text-center text-muted py-3">Belum ada data absensi</div>
        @endforelse
      </div>
      <div class="modal-footer">
        <a href="{{ route('teacher.attendance.index') }}" class="btn btn-primary">Kelola Absensi</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Monthly Stats Modal -->
<div id="monthlyStatsModal" class="modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header gradient-green">
        <h5 class="modal-title text-white"><i class="fas fa-chart-line me-2"></i>Statistik Bulanan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @php
          $m = $monthlyStats ?? ['hadir'=>0,'terlambat'=>0,'izin'=>0,'sakit'=>0,'alpha'=>0];
        @endphp
        <div class="row g-3">
          <div class="col-6">
            <div class="p-3 rounded-3 text-center" style="background:rgba(16,185,129,.1)">
              <div class="fw-bold fs-4 text-success">{{ $m['hadir'] ?? 0 }}</div>
              <div class="small text-muted">Hadir</div>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 rounded-3 text-center" style="background:rgba(245,158,11,.1)">
              <div class="fw-bold fs-4 text-warning">{{ $m['terlambat'] ?? 0 }}</div>
              <div class="small text-muted">Terlambat</div>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 rounded-3 text-center" style="background:rgba(59,130,246,.1)">
              <div class="fw-bold fs-4 text-primary">{{ ($m['izin'] ?? 0) + ($m['sakit'] ?? 0) }}</div>
              <div class="small text-muted">Izin/Sakit</div>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 rounded-3 text-center" style="background:rgba(239,68,68,.1)">
              <div class="fw-bold fs-4 text-danger">{{ $m['alpha'] ?? 0 }}</div>
              <div class="small text-muted">Alpha</div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Info Modal -->
<div id="infoModal" class="modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header gradient-indigo">
        <h5 class="modal-title text-white"><i class="fas fa-info-circle me-2"></i>Panduan & Info</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="small text-muted mb-0">
          <li>QR ditampilkan untuk dipindai oleh petugas/guru piket.</li>
          <li>Pastikan layar terang dan QR tidak buram.</li>
          <li>Jaga kerahasiaan kode QR Anda.</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Handle open-modal buttons
document.addEventListener('click', function(e){
  const btn = e.target.closest('[data-action="open-modal"]');
  if(!btn) return;
  const target = btn.getAttribute('data-target');
  if(!target) return;
  const el = document.querySelector(target);
  if(!el) return;
  const modal = new bootstrap.Modal(el);
  modal.show();
});

function copyQrCode(qr){
  if(navigator.clipboard && window.isSecureContext){
    navigator.clipboard.writeText(qr).then(()=>{
      Swal.fire({ icon:'success', title:'Berhasil!', text:'Kode QR disalin', timer:1800, showConfirmButton:false, toast:true, position:'top-end' });
    }).catch(()=>fallbackCopy(qr));
  }else fallbackCopy(qr);
}
function fallbackCopy(qr){
  const ta=document.createElement('textarea');
  ta.value=qr; ta.style.position='fixed'; ta.style.left='-9999px';
  document.body.appendChild(ta); ta.focus(); ta.select();
  const ok=document.execCommand('copy'); document.body.removeChild(ta);
  Swal.fire({ icon: ok?'success':'info', title: ok?'Berhasil!':'Salin Manual', text: ok?'Kode QR disalin':'Silakan salin kode secara manual.' , timer: ok?1600:undefined, showConfirmButton: !ok });
}
</script>
@endpush