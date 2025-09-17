@if($registrations->count() > 0)
    <div class="mb-3">
        <h6 class="text-primary dark:text-blue-400">
            <i class="fas fa-users me-2"></i>Pendaftaran untuk {{ $extracurricular->name }}
        </h6>
        <p class="text-muted dark:text-gray-400 small">
            Pembina: {{ $extracurricular->coach }} | 
            Total Pending: {{ $registrations->count() }}
        </p>
    </div>

    <div class="table-responsive">
        <table class="table table-hover dark:table-dark">
            <thead class="dark:bg-gray-700">
                <tr>
                    <th class="dark:text-gray-200">Siswa</th>
                    <th class="dark:text-gray-200">Kelas</th>
                    <th class="dark:text-gray-200">Kontak</th>
                    <th class="dark:text-gray-200">Tanggal Daftar</th>
                    <th class="dark:text-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $registration)
                    <tr class="dark:bg-gray-800 dark:border-gray-700">
                        <td class="dark:text-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">
                                    {{ strtoupper(substr($registration->student_name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $registration->student_name }}</div>
                                    <div class="text-muted small dark:text-gray-400">NIS: {{ $registration->student_nis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="dark:text-gray-200">
                            <span class="badge bg-primary dark:bg-blue-600">{{ $registration->student_class }}</span>
                            <span class="badge bg-secondary dark:bg-gray-600">{{ $registration->student_major }}</span>
                        </td>
                        <td class="dark:text-gray-200">
                            <div class="small">
                                <div><i class="fas fa-envelope me-1"></i> {{ Str::limit($registration->email, 25) }}</div>
                                <div><i class="fas fa-phone me-1"></i> {{ $registration->phone }}</div>
                            </div>
                        </td>
                        <td class="dark:text-gray-200">
                            <div class="small">
                                {{ $registration->registered_at->format('d M Y') }}
                                <div class="text-muted dark:text-gray-400">{{ $registration->registered_at->format('H:i') }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-info dark:btn-outline-blue-400" 
                                        onclick="showRegistrationDetail({{ $registration->id }})" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success dark:btn-outline-green-400" 
                                        onclick="approveRegistration({{ $registration->id }})" title="Setujui">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger dark:btn-outline-red-400" 
                                        onclick="rejectRegistration({{ $registration->id }})" title="Tolak">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted dark:text-gray-400">
                {{ $registrations->count() }} pendaftaran menunggu persetujuan
            </div>
            <div>
                <button class="btn btn-success btn-sm me-2" onclick="bulkApproveExtracurricular({{ $extracurricular->id }})">
                    <i class="fas fa-check-double me-1"></i>Setujui Semua
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="exportRegistrations({{ $extracurricular->id }})">
                    <i class="fas fa-download me-1"></i>Export
                </button>
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-check-circle fa-3x text-muted dark:text-gray-600 mb-3"></i>
        <h5 class="text-muted dark:text-gray-400">Tidak Ada Pendaftaran Pending</h5>
        <p class="text-muted dark:text-gray-500">
            Semua pendaftaran untuk <strong>{{ $extracurricular->name }}</strong> sudah diproses.
        </p>
        <a href="{{ route('admin.extracurriculars.show', $extracurricular) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-eye me-1"></i>Lihat Detail Ekstrakurikuler
        </a>
    </div>
@endif

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.dark .btn-outline-info {
    color: #60A5FA;
    border-color: #3B82F6;
}

.dark .btn-outline-success {
    color: #34D399;
    border-color: #10B981;
}

.dark .btn-outline-danger {
    color: #F87171;
    border-color: #EF4444;
}

.dark .btn-outline-secondary {
    color: #9CA3AF;
    border-color: #6B7280;
}
</style>

<script>
function bulkApproveExtracurricular(extracurricularId) {
    if (confirm('Apakah Anda yakin ingin menyetujui SEMUA pendaftaran untuk ekstrakurikuler ini?')) {
        // Implementation for bulk approve specific extracurricular
        alert('Fitur bulk approve akan segera tersedia!');
    }
}

function exportRegistrations(extracurricularId) {
    // Implementation for export
    window.location.href = `/admin/extracurriculars/${extracurricularId}/registrations/export`;
}
</script>