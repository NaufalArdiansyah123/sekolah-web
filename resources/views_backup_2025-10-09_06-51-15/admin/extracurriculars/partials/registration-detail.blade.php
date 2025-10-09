<style>
.detail-container {
    padding: 0;
}

.detail-header {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 1.5rem;
    margin: -1rem -1rem 1.5rem -1rem;
    border-radius: 0;
}

.detail-header h5 {
    margin: 0 0 0.5rem 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.detail-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.875rem;
}

.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.detail-section {
    background: var(--bg-secondary);
    padding: 1.25rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.detail-section h6 {
    margin: 0 0 1rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-section h6 svg {
    width: 20px;
    height: 20px;
    color: #3b82f6;
}

.detail-item {
    margin-bottom: 0.75rem;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
}

.detail-value {
    font-size: 0.875rem;
    color: var(--text-primary);
    font-weight: 500;
}

.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-badge.approved {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.status-badge.rejected {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.full-width {
    grid-column: 1 / -1;
}

.reason-section {
    background: var(--bg-tertiary);
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
}

.reason-text {
    font-style: italic;
    color: var(--text-secondary);
    line-height: 1.5;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.btn-action {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    border: none;
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    text-decoration: none;
}

.btn-approve {
    background: #10b981;
    color: white;
}

.btn-approve:hover {
    background: #059669;
    color: white;
}

.btn-reject {
    background: #ef4444;
    color: white;
}

.btn-reject:hover {
    background: #dc2626;
    color: white;
}

.btn-secondary {
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
}

/* CSS Variables */
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --bg-tertiary: #f1f5f9;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --border-color: #e5e7eb;
}

.dark {
    --bg-primary: #1f2937;
    --bg-secondary: #111827;
    --bg-tertiary: #374151;
    --text-primary: #f9fafb;
    --text-secondary: #d1d5db;
    --border-color: #374151;
}

/* Responsive */
@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-action {
        justify-content: center;
    }
}
</style>

<div class="detail-container">
    <div class="detail-header">
        <h5>{{ $registration->student_name }}</h5>
        <p>Pendaftaran untuk {{ $registration->extracurricular->name }}</p>
    </div>

    <div class="detail-grid">
        <!-- Student Information -->
        <div class="detail-section">
            <h6>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Siswa
            </h6>
            
            <div class="detail-item">
                <div class="detail-label">Nama Lengkap</div>
                <div class="detail-value">{{ $registration->student_name }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">NIS</div>
                <div class="detail-value">{{ $registration->student_nis }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Kelas</div>
                <div class="detail-value">{{ $registration->student_class }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Jurusan</div>
                <div class="detail-value">{{ $registration->student_major }}</div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="detail-section">
            <h6>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Kontak
            </h6>
            
            <div class="detail-item">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $registration->email }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">No. Telepon</div>
                <div class="detail-value">{{ $registration->phone }}</div>
            </div>
        </div>

        <!-- Extracurricular Information -->
        <div class="detail-section">
            <h6>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Ekstrakurikuler
            </h6>
            
            <div class="detail-item">
                <div class="detail-label">Nama Ekstrakurikuler</div>
                <div class="detail-value">{{ $registration->extracurricular->name }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Pembina/Pelatih</div>
                <div class="detail-value">{{ $registration->extracurricular->coach }}</div>
            </div>
            
            @if($registration->extracurricular->schedule)
                <div class="detail-item">
                    <div class="detail-label">Jadwal</div>
                    <div class="detail-value">{{ $registration->extracurricular->schedule }}</div>
                </div>
            @endif
        </div>

        <!-- Registration Status -->
        <div class="detail-section">
            <h6>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Status Pendaftaran
            </h6>
            
            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="status-badge {{ $registration->status }}">
                        @if($registration->status === 'pending')
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Menunggu
                        @elseif($registration->status === 'approved')
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Disetujui
                        @elseif($registration->status === 'rejected')
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Ditolak
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Tanggal Daftar</div>
                <div class="detail-value">{{ $registration->created_at->format('d M Y H:i') }}</div>
            </div>
            
            @if($registration->approved_at)
                <div class="detail-item">
                    <div class="detail-label">Tanggal {{ $registration->status === 'approved' ? 'Disetujui' : 'Ditolak' }}</div>
                    <div class="detail-value">{{ $registration->approved_at->format('d M Y H:i') }}</div>
                </div>
            @endif
            
            @if($registration->approvedBy)
                <div class="detail-item">
                    <div class="detail-label">Diproses Oleh</div>
                    <div class="detail-value">{{ $registration->approvedBy->name }}</div>
                </div>
            @endif
        </div>

        <!-- Reason for Joining -->
        @if($registration->reason)
            <div class="detail-section full-width">
                <h6>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Alasan Bergabung
                </h6>
                
                <div class="reason-section">
                    <div class="reason-text">{{ $registration->reason }}</div>
                </div>
            </div>
        @endif

        <!-- Experience -->
        @if($registration->experience)
            <div class="detail-section full-width">
                <h6>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    Pengalaman Sebelumnya
                </h6>
                
                <div class="reason-section">
                    <div class="reason-text">{{ $registration->experience }}</div>
                </div>
            </div>
        @endif

        <!-- Notes (if rejected) -->
        @if($registration->notes && $registration->status === 'rejected')
            <div class="detail-section full-width">
                <h6>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    Catatan Penolakan
                </h6>
                
                <div class="reason-section" style="border-left-color: #ef4444;">
                    <div class="reason-text">{{ $registration->notes }}</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Action Buttons -->
    @if($registration->status === 'pending')
        <div class="action-buttons">
            <button class="btn-action btn-approve" onclick="approveFromDetail({{ $registration->id }})">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Setujui Pendaftaran
            </button>
            <button class="btn-action btn-reject" onclick="rejectFromDetail({{ $registration->id }})">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tolak Pendaftaran
            </button>
        </div>
    @endif
</div>

<script>
function approveFromDetail(registrationId) {
    if (confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        fetch(`/admin/extracurriculars/registration/${registrationId}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal and reload page
                const modal = bootstrap.Modal.getInstance(document.getElementById('registrationDetailModal'));
                modal.hide();
                
                // Show success message and reload
                alert(data.message);
                setTimeout(() => location.reload(), 500);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error approving registration:', error);
            alert('Gagal menyetujui pendaftaran: ' + error.message);
        });
    }
}

function rejectFromDetail(registrationId) {
    const reason = prompt('Alasan penolakan (opsional):');
    if (reason !== null) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        fetch(`/admin/extracurriculars/registration/${registrationId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ notes: reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal and reload page
                const modal = bootstrap.Modal.getInstance(document.getElementById('registrationDetailModal'));
                modal.hide();
                
                // Show success message and reload
                alert(data.message);
                setTimeout(() => location.reload(), 500);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error rejecting registration:', error);
            alert('Gagal menolak pendaftaran: ' + error.message);
        });
    }
}
</script>