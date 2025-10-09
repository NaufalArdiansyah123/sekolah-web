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
                            <div class="registration-action-group">
                                <button class="reg-action-btn reg-btn-view" 
                                        onclick="showRegistrationDetail({{ $registration->id }})" title="View Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                <button class="reg-action-btn reg-btn-approve" 
                                        onclick="approveRegistration({{ $registration->id }})" title="Approve Registration">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                                <button class="reg-action-btn reg-btn-reject" 
                                        onclick="rejectRegistration({{ $registration->id }})" title="Reject Registration">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
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

/* Registration Action Button Group */
.registration-action-group {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    justify-content: center;
}

.reg-action-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: 1px solid var(--border-color);
    background: var(--bg-primary);
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.reg-action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: currentColor;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.reg-action-btn:hover {
    transform: translateY(-1px) scale(1.05);
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);
}

.reg-action-btn:hover::before {
    opacity: 0.1;
}

.reg-action-btn:active {
    transform: translateY(0) scale(1.02);
}

/* Specific Registration Button Colors */
.reg-btn-view {
    color: #06b6d4;
    border-color: rgba(6, 182, 212, 0.2);
}

.reg-btn-view:hover {
    background: #06b6d4;
    color: white;
    border-color: #06b6d4;
    box-shadow: 0 3px 12px rgba(6, 182, 212, 0.3);
}

.reg-btn-approve {
    color: #10b981;
    border-color: rgba(16, 185, 129, 0.2);
}

.reg-btn-approve:hover {
    background: #10b981;
    color: white;
    border-color: #10b981;
    box-shadow: 0 3px 12px rgba(16, 185, 129, 0.3);
}

.reg-btn-reject {
    color: #ef4444;
    border-color: rgba(239, 68, 68, 0.2);
}

.reg-btn-reject:hover {
    background: #ef4444;
    color: white;
    border-color: #ef4444;
    box-shadow: 0 3px 12px rgba(239, 68, 68, 0.3);
}

/* Dark mode for registration buttons */
.dark .reg-action-btn {
    background: var(--bg-secondary);
    border-color: var(--border-color);
}

.dark .reg-action-btn:hover {
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.3);
}

/* Mobile responsive */
@media (max-width: 768px) {
    .registration-action-group {
        gap: 0.125rem;
    }
    
    .reg-action-btn {
        width: 28px;
        height: 28px;
    }
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