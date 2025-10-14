@extends('layouts.guru-piket')

@section('title', 'QR Scanner Absensi Guru')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">QR Scanner Absensi Guru</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-info" onclick="refreshStats()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
            <button type="button" class="btn btn-warning" onclick="showManualEntry()">
                <i class="fas fa-edit"></i> Absensi Manual
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Guru
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalTeachers">{{ $stats['total_teachers'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Hadir Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="presentToday">{{ $stats['present_today'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Terlambat Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="lateToday">{{ $stats['late_today'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Tidak Hadir
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="absentToday">{{ $stats['absent_today'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- QR Scanner Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-qrcode"></i> QR Scanner
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div id="qr-reader" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
                        <div id="qr-reader-results" class="mt-3"></div>
                    </div>
                    
                    <div class="text-center">
                        <button id="start-scan-btn" class="btn btn-success btn-lg">
                            <i class="fas fa-camera"></i> Mulai Scan
                        </button>
                        <button id="stop-scan-btn" class="btn btn-danger btn-lg" style="display: none;">
                            <i class="fas fa-stop"></i> Stop Scan
                        </button>
                    </div>

                    <!-- Manual QR Input -->
                    <div class="mt-4">
                        <div class="form-group">
                            <label for="manual-qr">Atau masukkan kode QR secara manual:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="manual-qr" 
                                       placeholder="Masukkan kode QR...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="processManualQr()">
                                        <i class="fas fa-check"></i> Proses
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Scans Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history"></i> Scan Terbaru Hari Ini
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="refreshRecentScans()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="recent-scans-container">
                        @forelse($recentScans as $scan)
                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                {{ $scan->teacher->initials }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold">{{ $scan->teacher->name }}</div>
                                <small class="text-muted">{{ $scan->teacher->nip }} - {{ $scan->teacher->position }}</small>
                            </div>
                            <div class="text-right">
                                <span class="badge {{ $scan->status_badge_class }}">{{ $scan->status_label }}</span>
                                <br>
                                <small class="text-muted">{{ $scan->formatted_scan_time }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Belum ada scan hari ini</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scan Result Modal -->
<div class="modal fade" id="scanResultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hasil Scan QR Code</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="scan-result-content">
                    <!-- Scan result will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Manual Entry Modal -->
<div class="modal fade" id="manualEntryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Absensi Manual</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="manualEntryForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="teacher_id">Pilih Guru</label>
                        <select class="form-control" id="teacher_id" name="teacher_id" required>
                            <option value="">-- Pilih Guru --</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status Absensi</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="hadir">Hadir</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes">Catatan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Absensi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- QR Code Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
let html5QrcodeScanner = null;
let isScanning = false;

$(document).ready(function() {
    // Initialize QR Scanner
    initializeQrScanner();
    
    // Auto refresh recent scans every 30 seconds
    setInterval(refreshRecentScans, 30000);
});

function initializeQrScanner() {
    html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", 
        { 
            fps: 10, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        },
        false
    );
}

$('#start-scan-btn').on('click', function() {
    if (!isScanning) {
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        isScanning = true;
        $('#start-scan-btn').hide();
        $('#stop-scan-btn').show();
    }
});

$('#stop-scan-btn').on('click', function() {
    if (isScanning) {
        html5QrcodeScanner.clear();
        isScanning = false;
        $('#stop-scan-btn').hide();
        $('#start-scan-btn').show();
    }
});

function onScanSuccess(decodedText, decodedResult) {
    // Stop scanning
    html5QrcodeScanner.clear();
    isScanning = false;
    $('#stop-scan-btn').hide();
    $('#start-scan-btn').show();
    
    // Process the scanned QR code
    processQrCode(decodedText);
}

function onScanFailure(error) {
    // Handle scan failure (optional)
    console.log(`QR Code scan error: ${error}`);
}

function processQrCode(qrCode) {
    $.ajax({
        url: '/guru-piket/qr-scanner/scan',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            qr_code: qrCode
        },
        success: function(response) {
            showScanResult(response);
            if (response.success) {
                refreshStats();
                refreshRecentScans();
            }
        },
        error: function(xhr) {
            showScanResult({
                success: false,
                message: 'Terjadi kesalahan saat memproses QR Code',
                type: 'error'
            });
        }
    });
}

function processManualQr() {
    const qrCode = $('#manual-qr').val().trim();
    if (!qrCode) {
        showAlert('warning', 'Masukkan kode QR terlebih dahulu');
        return;
    }
    
    processQrCode(qrCode);
    $('#manual-qr').val('');
}

function showScanResult(response) {
    let content = '';
    let iconClass = '';
    let titleClass = '';
    
    if (response.success) {
        iconClass = 'fas fa-check-circle fa-3x text-success';
        titleClass = 'text-success';
        content = `
            <div class="mb-3">
                <i class="${iconClass}"></i>
                <h4 class="${titleClass} mt-2">Berhasil!</h4>
            </div>
            <div class="mb-3">
                <h5>${response.teacher.name}</h5>
                <p class="text-muted mb-1">NIP: ${response.teacher.nip}</p>
                <p class="text-muted mb-1">Jabatan: ${response.teacher.position}</p>
            </div>
            <div class="mb-3">
                <span class="badge ${response.teacher.status_class} badge-lg">
                    ${response.teacher.status}
                </span>
                <br>
                <small class="text-muted">Waktu: ${response.teacher.scan_time}</small>
            </div>
            <p class="text-success">${response.message}</p>
        `;
    } else {
        if (response.type === 'warning') {
            iconClass = 'fas fa-exclamation-triangle fa-3x text-warning';
            titleClass = 'text-warning';
        } else {
            iconClass = 'fas fa-times-circle fa-3x text-danger';
            titleClass = 'text-danger';
        }
        
        content = `
            <div class="mb-3">
                <i class="${iconClass}"></i>
                <h4 class="${titleClass} mt-2">
                    ${response.type === 'warning' ? 'Peringatan!' : 'Gagal!'}
                </h4>
            </div>
        `;
        
        if (response.teacher) {
            content += `
                <div class="mb-3">
                    <h5>${response.teacher.name}</h5>
                    <p class="text-muted mb-1">NIP: ${response.teacher.nip}</p>
                    <p class="text-muted mb-1">Jabatan: ${response.teacher.position}</p>
                    <p class="text-muted mb-1">Status: ${response.teacher.existing_status}</p>
                    <p class="text-muted">Waktu Scan: ${response.teacher.scan_time}</p>
                </div>
            `;
        }
        
        content += `<p class="${titleClass}">${response.message}</p>`;
    }
    
    $('#scan-result-content').html(content);
    $('#scanResultModal').modal('show');
}

function showManualEntry() {
    // Load teachers for manual entry
    $.ajax({
        url: '/guru-piket/qr-scanner/teachers',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                let options = '<option value="">-- Pilih Guru --</option>';
                response.teachers.forEach(function(teacher) {
                    options += `<option value="${teacher.id}">${teacher.name} (${teacher.nip}) - ${teacher.position}</option>`;
                });
                $('#teacher_id').html(options);
                $('#manualEntryModal').modal('show');
            } else {
                showAlert('error', 'Gagal memuat data guru');
            }
        },
        error: function(xhr) {
            showAlert('error', 'Terjadi kesalahan saat memuat data guru');
        }
    });
}

$('#manualEntryForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        _token: '{{ csrf_token() }}',
        teacher_id: $('#teacher_id').val(),
        status: $('#status').val(),
        notes: $('#notes').val()
    };
    
    $.ajax({
        url: '/guru-piket/qr-scanner/manual-entry',
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#manualEntryModal').modal('hide');
            showScanResult(response);
            if (response.success) {
                refreshStats();
                refreshRecentScans();
                $('#manualEntryForm')[0].reset();
            }
        },
        error: function(xhr) {
            showAlert('error', 'Terjadi kesalahan saat menyimpan absensi manual');
        }
    });
});

function refreshStats() {
    // Refresh statistics (you can implement this to fetch updated stats)
    location.reload();
}

function refreshRecentScans() {
    $.ajax({
        url: '/guru-piket/qr-scanner/today-attendance',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                let html = '';
                if (response.attendances.length > 0) {
                    response.attendances.forEach(function(attendance) {
                        html += `
                            <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    ${attendance.teacher_name.split(' ').map(n => n[0]).join('').substring(0, 2)}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold">${attendance.teacher_name}</div>
                                    <small class="text-muted">${attendance.teacher_nip} - ${attendance.teacher_position}</small>
                                </div>
                                <div class="text-right">
                                    <span class="badge ${attendance.status_class}">${attendance.status}</span>
                                    <br>
                                    <small class="text-muted">${attendance.scan_time}</small>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = `
                        <div class="text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Belum ada scan hari ini</p>
                        </div>
                    `;
                }
                $('#recent-scans-container').html(html);
            }
        },
        error: function(xhr) {
            console.log('Failed to refresh recent scans');
        }
    });
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 'alert-danger';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    $('.container-fluid').prepend(alertHtml);
    
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 5000);
}

// Handle manual QR input with Enter key
$('#manual-qr').on('keypress', function(e) {
    if (e.which === 13) {
        processManualQr();
    }
});
</script>
@endpush

@push('styles')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
}

.badge-lg {
    font-size: 1em;
    padding: 0.5em 1em;
}

#qr-reader {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 20px;
}

#qr-reader video {
    border-radius: 8px;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
</style>
@endpush