@extends('layouts.admin')

@section('title', 'Manajemen QR Code Guru')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen QR Code Guru</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-success" onclick="generateBulkQr()">
                <i class="fas fa-qrcode"></i> Generate QR Massal
            </button>
            <a href="{{ route('admin.qr-teacher.logs') }}" class="btn btn-info">
                <i class="fas fa-list"></i> Log Absensi
            </a>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_teachers'] }}</div>
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
                                Guru dengan QR Code
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['teachers_with_qr'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-qrcode fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Absensi Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['today_attendance'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
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
                                Hadir Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['present_today'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.qr-teacher.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nama, NIP, atau Email">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('admin.qr-teacher.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Teachers Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Guru</h6>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" onclick="selectAll()">
                    <i class="fas fa-check-square"></i> Pilih Semua
                </button>
                <button type="button" class="btn btn-sm btn-secondary" onclick="deselectAll()">
                    <i class="fas fa-square"></i> Batal Pilih
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="teachersTable">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                            </th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Status QR</th>
                            <th>Absensi Hari Ini</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                        <tr>
                            <td>
                                <input type="checkbox" class="teacher-checkbox" value="{{ $teacher->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                        {{ $teacher->initials }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $teacher->name }}</div>
                                        <small class="text-muted">{{ $teacher->subject }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $teacher->nip }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->position }}</td>
                            <td>
                                @if($teacher->qrTeacherAttendance)
                                    <span class="badge badge-success">
                                        <i class="fas fa-qrcode"></i> Ada QR
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Belum Ada QR
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $todayAttendance = $teacher->todayAttendance();
                                @endphp
                                @if($todayAttendance)
                                    <span class="badge {{ $todayAttendance->status_badge_class }}">
                                        {{ $todayAttendance->status_label }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $todayAttendance->formatted_scan_time }}</small>
                                @else
                                    <span class="badge badge-secondary">Belum Absen</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($teacher->qrTeacherAttendance)
                                        <button type="button" class="btn btn-sm btn-info" 
                                                onclick="viewQr({{ $teacher->id }})" 
                                                title="Lihat QR Code">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" 
                                                onclick="regenerateQr({{ $teacher->id }})" 
                                                title="Generate Ulang QR">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="deleteQr({{ $teacher->id }})" 
                                                title="Hapus QR Code">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-success" 
                                                onclick="generateQr({{ $teacher->id }})" 
                                                title="Generate QR Code">
                                            <i class="fas fa-qrcode"></i> Generate QR
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data guru</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $teachers->links() }}
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">QR Code Guru</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="qrContent">
                    <!-- QR content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a href="#" id="downloadQrBtn" class="btn btn-primary" target="_blank">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function generateQr(teacherId) {
    if (!confirm('Generate QR Code untuk guru ini?')) return;
    
    $.ajax({
        url: `/admin/qr-teacher/${teacherId}/generate`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                location.reload();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(xhr) {
            showAlert('error', 'Terjadi kesalahan saat generate QR Code');
        }
    });
}

function regenerateQr(teacherId) {
    if (!confirm('Generate ulang QR Code untuk guru ini? QR Code lama akan dihapus.')) return;
    
    $.ajax({
        url: `/admin/qr-teacher/${teacherId}/regenerate`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                location.reload();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(xhr) {
            showAlert('error', 'Terjadi kesalahan saat regenerate QR Code');
        }
    });
}

function deleteQr(teacherId) {
    if (!confirm('Hapus QR Code untuk guru ini?')) return;
    
    $.ajax({
        url: `/admin/qr-teacher/${teacherId}/delete`,
        method: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                location.reload();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(xhr) {
            showAlert('error', 'Terjadi kesalahan saat menghapus QR Code');
        }
    });
}

function viewQr(teacherId) {
    $.ajax({
        url: `/admin/qr-teacher/${teacherId}/view`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const qrContent = `
                    <div class="mb-3">
                        <h6>${response.teacher.name}</h6>
                        <p class="text-muted mb-2">NIP: ${response.teacher.nip}</p>
                        <p class="text-muted mb-3">Jabatan: ${response.teacher.position}</p>
                    </div>
                    <div class="mb-3">
                        <img src="${response.qr_image_url}" alt="QR Code" class="img-fluid" style="max-width: 300px;">
                    </div>
                    <div class="text-muted">
                        <small>QR Code: ${response.qr_code}</small>
                    </div>
                `;
                
                $('#qrContent').html(qrContent);
                $('#downloadQrBtn').attr('href', response.download_url);
                $('#qrModal').modal('show');
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(xhr) {
            showAlert('error', 'Terjadi kesalahan saat memuat QR Code');
        }
    });
}

function generateBulkQr() {
    const selectedTeachers = $('.teacher-checkbox:checked').map(function() {
        return this.value;
    }).get();
    
    if (selectedTeachers.length === 0) {
        showAlert('warning', 'Pilih minimal satu guru untuk generate QR Code');
        return;
    }
    
    if (!confirm(`Generate QR Code untuk ${selectedTeachers.length} guru yang dipilih?`)) return;
    
    $.ajax({
        url: '/admin/qr-teacher/generate-bulk',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            teacher_ids: selectedTeachers
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                location.reload();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(xhr) {
            showAlert('error', 'Terjadi kesalahan saat generate QR Code massal');
        }
    });
}

function selectAll() {
    $('.teacher-checkbox').prop('checked', true);
    $('#selectAllCheckbox').prop('checked', true);
}

function deselectAll() {
    $('.teacher-checkbox').prop('checked', false);
    $('#selectAllCheckbox').prop('checked', false);
}

function toggleSelectAll() {
    const isChecked = $('#selectAllCheckbox').is(':checked');
    $('.teacher-checkbox').prop('checked', isChecked);
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
</script>
@endpush

@push('styles')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endpush