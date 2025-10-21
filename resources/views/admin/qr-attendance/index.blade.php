@extends('layouts.admin')

@section('title', 'Manajemen Absensi QR Code')

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

.stat-card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    padding: 1rem;
}

.stat-icon {
    background-color: var(--bg-tertiary);
    padding: 0.75rem;
    border-radius: 0.5rem;
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
                    Manajemen Absensi QR Code
                </h1>
                <p class="text-sm mt-1" style="color: var(--text-secondary)">
                    Kelola QR Code dan monitor absensi siswa
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="generateBulkQr()" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>Generate QR Massal
                </button>
                <a href="{{ route('admin.qr-attendance.logs') }}" class="btn-secondary">
                    <i class="fas fa-list mr-2"></i>Log Absensi
                </a>
                <a href="{{ route('admin.qr-attendance.statistics') }}" class="btn-secondary">
                    <i class="fas fa-chart-bar mr-2"></i>Statistik
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium" style="color: var(--text-secondary)">Total Siswa</p>
                        <p class="text-xl font-bold mt-1" style="color: var(--text-primary)">{{ $stats['total_students'] }}</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users" style="color: var(--text-secondary)"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium" style="color: var(--text-secondary)">Siswa dengan QR</p>
                        <p class="text-xl font-bold mt-1" style="color: var(--text-primary)">{{ $stats['students_with_qr'] }}</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-qrcode" style="color: var(--text-secondary)"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium" style="color: var(--text-secondary)">Absensi Hari Ini</p>
                        <p class="text-xl font-bold mt-1" style="color: var(--text-primary)">{{ $stats['today_attendance'] }}</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check" style="color: var(--text-secondary)"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium" style="color: var(--text-secondary)">Hadir Hari Ini</p>
                        <p class="text-xl font-bold mt-1" style="color: var(--text-primary)">{{ $stats['present_today'] }}</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-user-check" style="color: var(--text-secondary)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="qr-card mb-6">
        <div class="qr-header">
            <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                <i class="fas fa-filter mr-2"></i>Filter Data Siswa
            </h3>
        </div>
        <div class="p-4">
            <form method="GET" action="{{ route('admin.qr-attendance.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Kelas</label>
                        <select name="class" class="form-input">
                            <option value="">Semua Kelas</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Cari Siswa</label>
                        <input type="text" name="search" class="form-input" placeholder="Nama, NIS, atau NISN" value="{{ request('search') }}">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                        <a href="{{ route('admin.qr-attendance.index') }}" class="btn-secondary">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <div class="qr-card">
        <div class="qr-header flex items-center justify-between">
            <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                <i class="fas fa-table mr-2"></i>Data Siswa
            </h3>
            <div class="flex items-center">
                <input type="checkbox" id="selectAll" class="mr-2">
                <label for="selectAll" class="text-xs font-medium" style="color: var(--text-primary)">Pilih Semua</label>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color)">
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">
                            <input type="checkbox" id="selectAllHeader">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">SISWA</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">KELAS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">QR CODE</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">ABSENSI HARI INI</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr class="table-row" style="border-bottom: 1px solid var(--border-color)">
                            <td class="px-4 py-3">
                                <input type="checkbox" class="student-checkbox" value="{{ $student->id }}">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($student->photo_url)
                                        <img src="{{ $student->photo_url }}" alt="{{ $student->name }}" class="w-10 h-10 rounded-full border" style="border-color: var(--border-color)">
                                    @else
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background-color: var(--accent-color)">
                                            {{ $student->initials }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium" style="color: var(--text-primary)">{{ $student->name }}</div>
                                        <div class="text-xs" style="color: var(--text-secondary)">{{ $student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">{{ $student->nis }}</td>
                            <td class="px-4 py-3">
                                <span class="status-badge" style="background-color: var(--bg-tertiary); color: var(--text-primary)">
                                    {{ $student->class ? $student->class->name : 'Belum Ditentukan' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($student->qrAttendance)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-qrcode text-sm" style="color: var(--text-secondary)"></i>
                                        <span class="text-sm font-medium" style="color: var(--text-primary)">Ada</span>
                                        <button type="button" onclick="viewQrCode({{ $student->id }})" class="btn-secondary !py-1 !px-2">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-times text-sm" style="color: var(--text-secondary)"></i>
                                        <span class="text-sm" style="color: var(--text-secondary)">Belum Ada</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($student->attendanceLogs->isNotEmpty())
                                    @php $todayLog = $student->attendanceLogs->first(); @endphp
                                    <div>
                                        <span class="status-badge" style="background-color: var(--bg-tertiary); color: var(--text-primary)">
                                            {{ $todayLog->status_text }}
                                        </span>
                                        <div class="text-xs mt-1" style="color: var(--text-secondary)">{{ $todayLog->scan_time->format('H:i') }}</div>
                                    </div>
                                @else
                                    <span class="text-sm" style="color: var(--text-secondary)">Belum Absen</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    @if($student->qrAttendance)
                                        <button type="button" onclick="regenerateQr({{ $student->id }})" class="btn-secondary !py-1 !px-2" title="Generate Ulang">
                                            <i class="fas fa-redo text-xs"></i>
                                        </button>
                                        <a href="{{ route('admin.qr-attendance.download', $student) }}" class="btn-secondary !py-1 !px-2" title="Download">
                                            <i class="fas fa-download text-xs"></i>
                                        </a>
                                    @else
                                        <button type="button" onclick="generateQr({{ $student->id }})" class="btn-primary !py-1 !px-2" title="Generate QR">
                                            <i class="fas fa-qrcode text-xs"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <i class="fas fa-users text-3xl mb-3" style="color: var(--text-secondary); opacity: 0.5"></i>
                                <p class="text-sm" style="color: var(--text-secondary)">Tidak ada data siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($students->hasPages())
            <div class="p-4 border-t" style="border-color: var(--border-color)">
                {{ $students->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- QR Code Modal -->
<div id="qrCodeModal" class="modal-overlay" onclick="closeModal('qrCodeModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="qr-header flex justify-between items-center">
            <h3 class="text-sm font-semibold" style="color: var(--text-primary)">QR Code Siswa</h3>
            <button onclick="closeModal('qrCodeModal')" style="color: var(--text-secondary)">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <div id="qrCodeContent" class="text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2" style="border-color: var(--accent-color)"></div>
                <p class="text-sm mt-3" style="color: var(--text-secondary)">Memuat...</p>
            </div>
        </div>
        <div class="p-4 border-t flex gap-2" style="border-color: var(--border-color)">
            <button onclick="closeModal('qrCodeModal')" class="btn-secondary flex-1">Tutup</button>
            <button type="button" id="downloadQrBtn" class="btn-primary flex-1">
                <i class="fas fa-download mr-2"></i>Download
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = this.checked);
});
document.getElementById('selectAllHeader').addEventListener('change', function() {
    document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = this.checked);
});

function generateQr(studentId) {
    if (confirm('Generate QR Code untuk siswa ini?')) {
        fetch(`/admin/qr-attendance/generate/${studentId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success ? 'Berhasil! ' + data.message : 'Error! ' + data.message);
            if (data.success) location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error! Terjadi kesalahan sistem');
        });
    }
}

function regenerateQr(studentId) {
    if (confirm('Generate ulang QR Code? QR Code lama akan tidak berlaku.')) {
        fetch(`/admin/qr-attendance/regenerate/${studentId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success ? 'Berhasil! ' + data.message : 'Error! ' + data.message);
            if (data.success) location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error! Terjadi kesalahan sistem');
        });
    }
}

function generateBulkQr() {
    const selectedStudents = Array.from(document.querySelectorAll('.student-checkbox:checked')).map(cb => cb.value);
    
    if (selectedStudents.length === 0) {
        alert('Pilih minimal satu siswa');
        return;
    }
    
    if (confirm(`Generate QR Code untuk ${selectedStudents.length} siswa yang dipilih?`)) {
        fetch('/admin/qr-attendance/generate-bulk', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ student_ids: selectedStudents })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success ? 'Berhasil! ' + data.message : 'Error! ' + data.message);
            if (data.success) location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error! Terjadi kesalahan sistem');
        });
    }
}

function viewQrCode(studentId) {
    const modal = document.getElementById('qrCodeModal');
    modal.classList.add('show');
    
    document.getElementById('qrCodeContent').innerHTML = `
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2" style="border-color: var(--accent-color)"></div>
        <p class="text-sm mt-3" style="color: var(--text-secondary)">Memuat...</p>
    `;
    
    fetch(`/admin/qr-attendance/view/${studentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('qrCodeContent').innerHTML = `
                    <img src="${data.qr_image_url}" alt="QR Code" class="max-w-xs mx-auto mb-4 rounded border" style="border-color: var(--border-color)">
                    <h4 class="text-lg font-bold mb-2" style="color: var(--text-primary)">${data.student.name}</h4>
                    <p class="text-sm" style="color: var(--text-secondary)">NIS: ${data.student.nis} | Kelas: ${data.student.class}</p>
                `;
                document.getElementById('downloadQrBtn').onclick = () => window.open(data.download_url, '_blank');
            } else {
                document.getElementById('qrCodeContent').innerHTML = `<p class="text-sm" style="color: var(--text-secondary)">${data.message}</p>`;
            }
        })
        .catch(error => {
            document.getElementById('qrCodeContent').innerHTML = `<p class="text-sm" style="color: var(--text-secondary)">Terjadi kesalahan</p>`;
        });
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}
</script>
@endpush