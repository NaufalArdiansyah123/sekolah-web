@extends('layouts.admin')

@section('title', 'PKL Attendance Logs')

@section('content')
    <style>
        /* Minimal Monochrome Styling */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f7f7f7;
            --bg-tertiary: #efefef;
            --text-primary: #111111;
            --text-secondary: #555555;
            --border-color: #dddddd;
            --accent-color: #222222;
        }

        .dark {
            --bg-primary: #1e293b;
            --bg-secondary: #0f172a;
            --bg-tertiary: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: #334155;
        }

        .qr-container {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 1.5rem;
        }

        .qr-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            color: var(--text-primary);
        }

        .qr-header {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid var(--accent-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            filter: brightness(1.1);
        }

        .btn-secondary {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: var(--border-color);
        }

        .form-input {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            width: 100%;
        }

        .form-input:focus {
            outline: none;
            border-color: #999;
        }

        .table-row:hover {
            background-color: var(--bg-tertiary);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid var(--border-color);
        }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background-color: var(--bg-primary);
            border-radius: 0.75rem;
            max-width: 28rem;
            width: 90%;
            border: 1px solid var(--border-color);
        }
    </style>

    <div class="qr-container">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                        PKL Attendance Logs
                    </h1>
                    <p class="text-sm mt-1" style="color: var(--text-secondary)">
                        Kelola log absensi PKL siswa
                    </p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="qr-card mb-6">
            <div class="qr-header">
                <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                    <i class="fas fa-filter mr-2"></i>Filter Data Log Absensi
                </h3>
            </div>
            <div class="p-4">
                <form method="GET" action="{{ route('admin.pkl-attendance.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-xs font-medium mb-2"
                                style="color: var(--text-secondary)">Tempat PKL</label>
                            <select name="tempat_pkl" class="form-input">
                                <option value="">Semua Tempat PKL</option>
                                @foreach($tempatPkls as $tempat)
                                    <option value="{{ $tempat->id }}" {{ request('tempat_pkl') == $tempat->id ? 'selected' : '' }}>
                                        {{ $tempat->nama_tempat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Cari Siswa</label>
                            <input type="text" name="search" class="form-input" placeholder="Nama siswa"
                                value="{{ request('search') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Tanggal Mulai</label>
                            <input type="date" name="date_from" class="form-input"
                                value="{{ request('date_from') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Tanggal Akhir</label>
                            <input type="date" name="date_to" class="form-input"
                                value="{{ request('date_to') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Status</label>
                            <select name="status" class="form-input">
                                <option value="">Semua Status</option>
                                @foreach($statusOptions as $key => $label)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex items-end gap-2 mt-4">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                        <a href="{{ route('admin.pkl-attendance.index') }}" class="btn-secondary">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Attendance Logs Table -->
        <div class="qr-card">
            <div class="qr-header">
                <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                    <i class="fas fa-table mr-2"></i>Data Log Absensi PKL
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color)">
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">SISWA</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">TEMPAT PKL</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">TANGGAL SCAN</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">WAKTU SCAN</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">STATUS</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">IP ADDRESS</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pklAttendanceLogs as $log)
                            <tr class="table-row" style="border-bottom: 1px solid var(--border-color)">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="text-sm font-medium" style="color: var(--text-primary)">
                                                {{ $log->student->name }}
                                            </div>
                                            <div class="text-xs" style="color: var(--text-secondary)">
                                                {{ $log->student->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium" style="color: var(--text-primary)">
                                        {{ $log->pklRegistration->tempatPkl->nama_tempat }}
                                    </div>
                                    <div class="text-xs" style="color: var(--text-secondary)">
                                        {{ $log->pklRegistration->tempatPkl->alamat }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">
                                    {{ $log->getFormattedScanDateAttribute() }}
                                </td>
                                <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">
                                    {{ $log->getFormattedScanTimeAttribute() }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="status-badge {{ $log->status == 'hadir' ? 'bg-green-100 text-green-800' : ($log->status == 'izin' ? 'bg-yellow-100 text-yellow-800' : ($log->status == 'sakit' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">
                                    {{ $log->getIpAddressDisplayAttribute() }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <button type="button" class="btn-secondary !py-1 !px-2" title="View Details"
                                            onclick="showLogDetails({{ $log->id }}, '{{ $log->student->name }}', '{{ $log->pklRegistration->tempatPkl->nama_tempat }}', '{{ $log->getFormattedScanDateAttribute() }}', '{{ $log->getFormattedScanTimeAttribute() }}', '{{ $log->status }}', '{{ $log->getLocationDisplayAttribute() }}', '{{ $log->getIpAddressDisplayAttribute() }}', '{{ $log->user_agent }}')">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <button type="button" class="btn-primary !py-1 !px-2" title="Edit Status"
                                            onclick="editLogStatus({{ $log->id }}, '{{ $log->status }}')">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <i class="fas fa-clock text-3xl mb-3"
                                        style="color: var(--text-secondary); opacity: 0.5"></i>
                                    <p class="text-sm" style="color: var(--text-secondary)">Tidak ada data log absensi PKL</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pklAttendanceLogs->hasPages())
                <div class="p-4 border-t" style="border-color: var(--border-color)">
                    {{ $pklAttendanceLogs->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Log Details Modal -->
    <div class="modal-overlay" id="logDetailsModal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary)">Detail Log Absensi</h3>
                    <button onclick="closeLogDetailsModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">Siswa</label>
                        <p class="text-sm" style="color: var(--text-primary)" id="modal-student"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">Tempat PKL</label>
                        <p class="text-sm" style="color: var(--text-primary)" id="modal-tempat"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">Tanggal Scan</label>
                            <p class="text-sm" style="color: var(--text-primary)" id="modal-date"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">Waktu Scan</label>
                            <p class="text-sm" style="color: var(--text-primary)" id="modal-time"></p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">Status</label>
                        <p class="text-sm" style="color: var(--text-primary)" id="modal-status"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">Lokasi</label>
                        <p class="text-sm" style="color: var(--text-primary)" id="modal-location"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">IP Address</label>
                        <p class="text-sm" style="color: var(--text-primary)" id="modal-ip"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">User Agent</label>
                        <p class="text-xs" style="color: var(--text-secondary)" id="modal-user-agent"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Status Modal -->
    <div class="modal-overlay" id="editStatusModal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary)">Edit Status Absensi</h3>
                    <button onclick="closeEditStatusModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="editStatusForm">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="edit-log-id" name="log_id">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">Siswa</label>
                            <p class="text-sm" style="color: var(--text-primary)" id="edit-modal-student"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" style="color: var(--text-secondary)">Tempat PKL</label>
                            <p class="text-sm" style="color: var(--text-primary)" id="edit-modal-tempat"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Status Absensi</label>
                            <select name="status" id="edit-status" class="form-input" required>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                                <option value="alpha">Alpha</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeEditStatusModal()" class="btn-secondary">
                            Batal
                        </button>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize tooltips if needed
            $('[data-toggle="tooltip"]').tooltip();
        });

        function showLogDetails(id, student, tempat, date, time, status, location, ip, userAgent) {
            $('#modal-student').text(student);
            $('#modal-tempat').text(tempat);
            $('#modal-date').text(date);
            $('#modal-time').text(time);
            $('#modal-status').text(status.charAt(0).toUpperCase() + status.slice(1));
            $('#modal-location').text(location);
            $('#modal-ip').text(ip);
            $('#modal-user-agent').text(userAgent);
            $('#logDetailsModal').addClass('show');
        }

        function closeLogDetailsModal() {
            $('#logDetailsModal').removeClass('show');
        }

        function editLogStatus(id, currentStatus) {
            // Fetch log details via AJAX to populate the modal
            $.ajax({
                url: '{{ route("admin.pkl-attendance.show", ":id") }}'.replace(':id', id),
                type: 'GET',
                success: function(data) {
                    $('#edit-log-id').val(data.id);
                    $('#edit-modal-student').text(data.student ? data.student.name : 'N/A');
                    $('#edit-modal-tempat').text(data.pklRegistration && data.pklRegistration.tempatPkl ? data.pklRegistration.tempatPkl.nama_tempat : 'N/A');
                    $('#edit-status').val(data.status);
                    $('#editStatusModal').addClass('show');
                },
                error: function() {
                    alert('Error loading log details');
                }
            });
        }

        function closeEditStatusModal() {
            $('#editStatusModal').removeClass('show');
        }

        $('#editStatusForm').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '{{ route("admin.pkl-attendance.update", ":id") }}'.replace(':id', $('#edit-log-id').val()),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-HTTP-Method-Override': 'PATCH'
                },
                success: function(response) {
                    if (response.success) {
                        $('#editStatusModal').removeClass('show');
                        location.reload();
                    } else {
                        alert('Error updating status');
                    }
                },
                error: function() {
                    alert('Error updating status');
                }
            });
        });
    </script>
@endpush
