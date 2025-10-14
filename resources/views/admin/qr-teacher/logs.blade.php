@extends('layouts.admin')

@section('title', 'Log Absensi Guru')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Log Absensi Guru</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.qr-teacher.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="button" class="btn btn-success" onclick="exportLogs()">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Log Absensi</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.qr-teacher.logs') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date" 
                                   value="{{ request('date', today()->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="teacher">Guru</label>
                            <select class="form-control" id="teacher" name="teacher">
                                <option value="">Semua Guru</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ request('teacher') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }} ({{ $teacher->nip }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.qr-teacher.logs') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Logs Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Log Absensi 
                @if(request('date'))
                    - {{ \Carbon\Carbon::parse(request('date'))->format('d/m/Y') }}
                @else
                    - Hari Ini
                @endif
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="logsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Guru</th>
                            <th>NIP</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Waktu Scan</th>
                            <th>Tanggal</th>
                            <th>Discan Oleh</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $log)
                        <tr>
                            <td>{{ $logs->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                        {{ $log->teacher->initials }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $log->teacher->name }}</div>
                                        <small class="text-muted">{{ $log->teacher->subject }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $log->teacher->nip }}</td>
                            <td>{{ $log->teacher->position }}</td>
                            <td>
                                <span class="badge {{ $log->status_badge_class }}">
                                    {{ $log->status_label }}
                                </span>
                            </td>
                            <td>{{ $log->formatted_scan_time }}</td>
                            <td>{{ $log->formatted_attendance_date }}</td>
                            <td>{{ $log->scanned_by }}</td>
                            <td>
                                @if($log->notes)
                                    <span class="text-muted">{{ $log->notes }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" 
                                        onclick="editStatus({{ $log->id }})" 
                                        title="Edit Status">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada log absensi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Status Absensi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editStatusForm">
                <div class="modal-body">
                    <input type="hidden" id="logId">
                    
                    <div class="form-group">
                        <label for="editStatus">Status</label>
                        <select class="form-control" id="editStatus" name="status" required>
                            <option value="hadir">Hadir</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="editNotes">Catatan</label>
                        <textarea class="form-control" id="editNotes" name="notes" rows="3" 
                                  placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editStatus(logId) {
    // Get current log data
    const row = $(`button[onclick="editStatus(${logId})"]`).closest('tr');
    const currentStatus = row.find('.badge').text().trim().toLowerCase();
    const currentNotes = row.find('td:nth-child(9)').text().trim();
    
    // Set form values
    $('#logId').val(logId);
    $('#editStatus').val(getStatusValue(currentStatus));
    $('#editNotes').val(currentNotes === '-' ? '' : currentNotes);
    
    // Show modal
    $('#editStatusModal').modal('show');
}

function getStatusValue(statusLabel) {
    const statusMap = {
        'hadir': 'hadir',
        'terlambat': 'terlambat',
        'izin': 'izin',
        'sakit': 'sakit',
        'alpha': 'alpha'
    };
    return statusMap[statusLabel] || 'hadir';
}

$('#editStatusForm').on('submit', function(e) {
    e.preventDefault();
    
    const logId = $('#logId').val();
    const formData = {
        _token: '{{ csrf_token() }}',
        status: $('#editStatus').val(),
        notes: $('#editNotes').val()
    };
    
    $.ajax({
        url: `/guru-piket/qr-scanner/update-status/${logId}`,
        method: 'PUT',
        data: formData,
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                $('#editStatusModal').modal('hide');
                location.reload();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(xhr) {
            showAlert('error', 'Terjadi kesalahan saat memperbarui status');
        }
    });
});

function exportLogs() {
    const params = new URLSearchParams();
    
    // Get current filter values
    const date = $('#date').val();
    const status = $('#status').val();
    const teacher = $('#teacher').val();
    
    if (date) params.append('date', date);
    if (status) params.append('status', status);
    if (teacher) params.append('teacher', teacher);
    
    // Create download URL
    const exportUrl = '/admin/qr-teacher/export-logs?' + params.toString();
    
    // Open in new tab for download
    window.open(exportUrl, '_blank');
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

// Auto-submit form when date changes
$('#date').on('change', function() {
    $('#filterForm').submit();
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

.badge {
    font-size: 0.75em;
}

.table td {
    vertical-align: middle;
}
</style>
@endpush