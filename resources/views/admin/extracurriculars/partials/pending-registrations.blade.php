@if($registrations->count() > 0)
    <!-- Enhanced Action Bar for Pending Registrations -->
    <div class="pending-action-bar mb-4">
        <div class="pending-stats">
            <div class="stat-item">
                <div class="stat-icon pending-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $registrations->count() }}</div>
                    <div class="stat-label">Pending Registrations</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon activity-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $registrations->groupBy('extracurricular_id')->count() }}</div>
                    <div class="stat-label">Extracurriculars</div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Action Buttons -->
        <div class="pending-buttons">
            <button class="pending-btn approve-all-btn" onclick="bulkApproveAll()" title="Approve All Registrations">
                <div class="btn-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="btn-content">
                    <div class="btn-title">Approve All</div>
                    <div class="btn-subtitle">{{ $registrations->count() }} pending</div>
                </div>
            </button>
            
            <button class="pending-btn export-pending-btn" onclick="exportPendingRegistrations()" title="Export Pending List">
                <div class="btn-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="btn-content">
                    <div class="btn-title">Export</div>
                    <div class="btn-subtitle">Pending List</div>
                </div>
            </button>
            
            <button class="pending-btn notify-btn" onclick="notifyPendingStudents()" title="Notify Students">
                <div class="btn-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM16 3H4v2h12V3zM4 7h12v2H4V7zM4 11h12v2H4v-2z"/>
                    </svg>
                </div>
                <div class="btn-content">
                    <div class="btn-title">Notify</div>
                    <div class="btn-subtitle">Send Updates</div>
                </div>
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover dark:table-dark">
            <thead class="dark:bg-gray-700">
                <tr>
                    <th class="dark:text-gray-200">Siswa</th>
                    <th class="dark:text-gray-200">Ekstrakurikuler</th>
                    <th class="dark:text-gray-200">Kelas</th>
                    <th class="dark:text-gray-200">Kontak</th>
                    <th class="dark:text-gray-200">Tanggal Daftar</th>
                    <th class="dark:text-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $registration)
                    <tr class="dark:bg-gray-800 dark:border-gray-700 registration-row" data-registration-id="{{ $registration->id }}">
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
                            <div class="d-flex align-items-center">
                                @if($registration->extracurricular->image)
                                    <img src="{{ asset('storage/' . $registration->extracurricular->image) }}" 
                                         class="extracurricular-image me-2" width="32" height="32">
                                @else
                                    <div class="extracurricular-placeholder me-2">
                                        <i class="fas fa-users"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold small">{{ $registration->extracurricular->name }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $registration->extracurricular->coach }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="dark:text-gray-200">
                            <span class="badge bg-primary dark:bg-blue-600">{{ $registration->student_class }}</span>
                            <span class="badge bg-secondary dark:bg-gray-600">{{ $registration->student_major }}</span>
                        </td>
                        <td class="dark:text-gray-200">
                            <div class="small">
                                <div><i class="fas fa-envelope me-1"></i> {{ Str::limit($registration->email, 20) }}</div>
                                <div><i class="fas fa-phone me-1"></i> {{ $registration->phone }}</div>
                            </div>
                        </td>
                        <td class="dark:text-gray-200">
                            <div class="small">
                                {{ $registration->registered_at->format('d M Y') }}
                                <div class="text-muted dark:text-gray-400">{{ $registration->registered_at->format('H:i') }}</div>
                                <div class="registration-time-badge">
                                    {{ $registration->registered_at->diffForHumans() }}
                                </div>
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
                                <button class="reg-action-btn reg-btn-approve approve-btn" 
                                        onclick="approveRegistration({{ $registration->id }})" title="Approve Registration">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                                <button class="reg-action-btn reg-btn-reject reject-btn" 
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
    
    <!-- Enhanced Summary Footer -->
    <div class="pending-summary">
        <div class="summary-content">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $registrations->count() }} registrations awaiting approval from {{ $registrations->groupBy('extracurricular_id')->count() }} extracurriculars</span>
        </div>
        <div class="summary-actions">
            <button class="btn btn-sm btn-outline-primary" onclick="refreshPendingList()">
                <i class="fas fa-sync-alt me-1"></i>Refresh
            </button>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <div class="empty-state-icon">
            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h5 class="text-muted dark:text-gray-400 mt-3">Tidak Ada Pendaftaran Pending</h5>
        <p class="text-muted dark:text-gray-500">
            Semua pendaftaran sudah diproses. Bagus sekali!
        </p>
        <div class="mt-3">
            <button class="btn btn-outline-primary btn-sm" onclick="refreshPendingList()">
                <i class="fas fa-sync-alt me-1"></i>Refresh List
            </button>
        </div>
    </div>
@endif

<style>
/* Enhanced Pending Action Bar Styles */
.pending-action-bar {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #f59e0b;
    box-shadow: 0 4px 20px rgba(245, 158, 11, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    position: relative;
    overflow: hidden;
}

.pending-action-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #f59e0b, #d97706, #b45309);
}

.pending-stats {
    display: flex;
    gap: 2rem;
    flex: 1;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.stat-icon.pending-icon {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
}

.stat-icon.activity-icon {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

.pending-buttons {
    display: flex;
    gap: 1rem;
}

.pending-btn {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
    min-width: 140px;
}

.pending-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.5s ease;
}

.pending-btn:hover::before {
    left: 100%;
}

.pending-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border-color: transparent;
}

.approve-all-btn:hover {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.export-pending-btn:hover {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
}

.notify-btn:hover {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
}

.btn-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.approve-all-btn .btn-icon {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.export-pending-btn .btn-icon {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.notify-btn .btn-icon {
    background: rgba(139, 92, 246, 0.1);
    color: #8b5cf6;
}

.pending-btn:hover .btn-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    transform: scale(1.1);
}

.btn-content {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.btn-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1f2937;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.btn-subtitle {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 500;
}

.pending-btn:hover .btn-title,
.pending-btn:hover .btn-subtitle {
    color: white;
}

/* Enhanced Table Styles */
.registration-row {
    transition: all 0.3s ease;
}

.registration-row:hover {
    background: rgba(245, 158, 11, 0.05) !important;
    transform: translateX(2px);
}

.extracurricular-image {
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #e5e7eb;
}

.extracurricular-placeholder {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
}

.registration-time-badge {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
    padding: 0.125rem 0.5rem;
    border-radius: 12px;
    font-size: 0.6rem;
    font-weight: 600;
    margin-top: 0.25rem;
    display: inline-block;
}

.approve-btn:hover {
    background: #10b981 !important;
    border-color: #10b981 !important;
    color: white !important;
    transform: scale(1.05);
}

.reject-btn:hover {
    background: #ef4444 !important;
    border-color: #ef4444 !important;
    color: white !important;
    transform: scale(1.05);
}

/* Enhanced Summary Footer */
.pending-summary {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    border: 1px solid #f59e0b;
    margin-top: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.summary-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #92400e;
    font-size: 0.875rem;
    font-weight: 500;
}

.summary-content svg {
    color: #d97706;
}

.summary-actions {
    display: flex;
    gap: 0.5rem;
}

/* Empty State */
.empty-state-icon {
    color: #10b981;
    margin-bottom: 1rem;
}

/* Avatar Circle */
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

/* Dark Mode Support */
.dark .pending-action-bar {
    background: linear-gradient(135deg, #451a03 0%, #78350f 100%);
    border-color: #92400e;
}

.dark .stat-number {
    color: #fbbf24;
}

.dark .stat-label {
    color: #fcd34d;
}

.dark .pending-btn {
    background: #374151;
    border-color: #4b5563;
    color: #f9fafb;
}

.dark .btn-title {
    color: #f9fafb;
}

.dark .btn-subtitle {
    color: #d1d5db;
}

.dark .pending-summary {
    background: linear-gradient(135deg, #451a03, #78350f);
    border-color: #92400e;
}

.dark .summary-content {
    color: #fcd34d;
}

.dark .registration-time-badge {
    background: rgba(251, 191, 36, 0.2);
    color: #fbbf24;
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

/* Responsive Design */
@media (max-width: 768px) {
    .pending-action-bar {
        flex-direction: column;
        gap: 1.5rem;
        padding: 1.25rem;
    }
    
    .pending-stats {
        justify-content: center;
        gap: 1.5rem;
    }
    
    .pending-buttons {
        flex-direction: column;
        width: 100%;
        gap: 0.75rem;
    }
    
    .pending-btn {
        justify-content: center;
        min-width: auto;
        width: 100%;
    }
    
    .stat-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .pending-summary {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .pending-stats {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<script>
function bulkApproveAll() {
    if (confirm('Apakah Anda yakin ingin menyetujui SEMUA pendaftaran yang pending?')) {
        const approveBtn = document.querySelector('.approve-all-btn');
        const originalContent = approveBtn.innerHTML;
        
        approveBtn.innerHTML = `
            <div class="btn-icon">
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <div class="btn-content">
                <div class="btn-title">Processing...</div>
                <div class="btn-subtitle">Please wait</div>
            </div>
        `;
        
        setTimeout(() => {
            approveBtn.innerHTML = originalContent;
            alert('Bulk approve feature will be available soon!');
        }, 2000);
    }
}

function exportPendingRegistrations() {
    const exportBtn = document.querySelector('.export-pending-btn');
    const originalContent = exportBtn.innerHTML;
    
    exportBtn.innerHTML = `
        <div class="btn-icon">
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <div class="btn-content">
            <div class="btn-title">Exporting...</div>
            <div class="btn-subtitle">Please wait</div>
        </div>
    `;
    
    setTimeout(() => {
        exportBtn.innerHTML = originalContent;
        window.location.href = '/admin/extracurriculars/pending-registrations/export';
    }, 1500);
}

function notifyPendingStudents() {
    const notifyBtn = document.querySelector('.notify-btn');
    const originalContent = notifyBtn.innerHTML;
    
    notifyBtn.innerHTML = `
        <div class="btn-icon">
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <div class="btn-content">
            <div class="btn-title">Sending...</div>
            <div class="btn-subtitle">Please wait</div>
        </div>
    `;
    
    setTimeout(() => {
        notifyBtn.innerHTML = originalContent;
        alert('Notification feature will be available soon!');
    }, 2000);
}

function approveRegistration(registrationId) {
    if (confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini?')) {
        const row = document.querySelector(`[data-registration-id="${registrationId}"]`);
        const approveBtn = row.querySelector('.approve-btn');
        
        approveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        approveBtn.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            row.style.background = 'rgba(16, 185, 129, 0.1)';
            row.style.transform = 'translateX(10px)';
            
            setTimeout(() => {
                row.style.opacity = '0';
                setTimeout(() => {
                    row.remove();
                    updatePendingCount();
                }, 300);
            }, 1000);
        }, 1000);
    }
}

function rejectRegistration(registrationId) {
    const reason = prompt('Alasan penolakan (opsional):');
    if (reason !== null) {
        const row = document.querySelector(`[data-registration-id="${registrationId}"]`);
        const rejectBtn = row.querySelector('.reject-btn');
        
        rejectBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        rejectBtn.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            row.style.background = 'rgba(239, 68, 68, 0.1)';
            row.style.transform = 'translateX(-10px)';
            
            setTimeout(() => {
                row.style.opacity = '0';
                setTimeout(() => {
                    row.remove();
                    updatePendingCount();
                }, 300);
            }, 1000);
        }, 1000);
    }
}

function showRegistrationDetail(registrationId) {
    alert('Registration detail feature will be available soon!');
}

function refreshPendingList() {
    const refreshBtn = event.target;
    const originalContent = refreshBtn.innerHTML;
    
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    setTimeout(() => {
        refreshBtn.innerHTML = originalContent;
        refreshBtn.disabled = false;
        location.reload();
    }, 1500);
}

function updatePendingCount() {
    const remainingRows = document.querySelectorAll('.registration-row').length;
    const statNumber = document.querySelector('.pending-icon').parentElement.querySelector('.stat-number');
    const summaryText = document.querySelector('.summary-content span');
    
    if (remainingRows === 0) {
        // Show empty state
        document.querySelector('.table-responsive').style.display = 'none';
        document.querySelector('.pending-action-bar').style.display = 'none';
        document.querySelector('.pending-summary').style.display = 'none';
        
        const emptyState = `
            <div class="text-center py-5">
                <div class="empty-state-icon">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h5 class="text-muted dark:text-gray-400 mt-3">Tidak Ada Pendaftaran Pending</h5>
                <p class="text-muted dark:text-gray-500">
                    Semua pendaftaran sudah diproses. Bagus sekali!
                </p>
                <div class="mt-3">
                    <button class="btn btn-outline-primary btn-sm" onclick="refreshPendingList()">
                        <i class="fas fa-sync-alt me-1"></i>Refresh List
                    </button>
                </div>
            </div>
        `;
        
        document.querySelector('.table-responsive').parentElement.innerHTML = emptyState;
    } else {
        statNumber.textContent = remainingRows;
        summaryText.textContent = `${remainingRows} registrations awaiting approval`;
    }
}

// Add CSS for animations
if (!document.querySelector('#pending-animations')) {
    const style = document.createElement('style');
    style.id = 'pending-animations';
    style.textContent = `
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
}
</script>