@if($members->count() > 0)
    <!-- Enhanced Action Bar -->
    <div class="action-bar mb-4">
        <div class="action-stats">
            <div class="stat-item">
                <div class="stat-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $members->count() }}</div>
                    <div class="stat-label">Active Members</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon coach-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $extracurricular->coach }}</div>
                    <div class="stat-label">Coach/Supervisor</div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Action Buttons -->
        <div class="action-buttons">
            <button class="action-btn export-btn" onclick="exportMembers({{ $extracurricular->id }})" title="Export Member List">
                <div class="btn-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="btn-content">
                    <div class="btn-title">Ekspor</div>
                    <div class="btn-subtitle">Member List</div>
                </div>
            </button>
            
            <button class="action-btn broadcast-btn" onclick="sendBroadcast({{ $extracurricular->id }})" title="Send Broadcast Message">
                <div class="btn-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <div class="btn-content">
                    <div class="btn-title">Broadcast</div>
                    <div class="btn-subtitle">Send Message</div>
                </div>
            </button>
            
            <button class="action-btn certificate-btn" onclick="generateCertificate({{ $extracurricular->id }})" title="Generate Certificates">
                <div class="btn-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="btn-content">
                    <div class="btn-title">Certificate</div>
                    <div class="btn-subtitle">Generate</div>
                </div>
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover dark:table-dark">
            <thead class="dark:bg-gray-700">
                <tr>
                    <th class="dark:text-gray-200">Siswa</th>
                    <th class="dark:text-gray-200">Kelas</th>
                    <th class="dark:text-gray-200">Kontak</th>
                    <th class="dark:text-gray-200">Bergabung</th>
                    <th class="dark:text-gray-200">Status</th>
                    <th class="dark:text-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr class="dark:bg-gray-800 dark:border-gray-700">
                        <td class="dark:text-gray-200">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">
                                    {{ strtoupper(substr($member->student_name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $member->student_name }}</div>
                                    <div class="text-muted small dark:text-gray-400">NIS: {{ $member->student_nis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="dark:text-gray-200">
                            <span class="badge bg-primary dark:bg-blue-600">{{ $member->student_class }}</span>
                            <span class="badge bg-secondary dark:bg-gray-600">{{ $member->student_major }}</span>
                        </td>
                        <td class="dark:text-gray-200">
                            <div class="small">
                                <div><i class="fas fa-envelope me-1"></i> {{ Str::limit($member->email, 25) }}</div>
                                <div><i class="fas fa-phone me-1"></i> {{ $member->phone }}</div>
                            </div>
                        </td>
                        <td class="dark:text-gray-200">
                            <div class="small">
                                {{ $member->approved_at ? $member->approved_at->format('d M Y') : 'N/A' }}
                                @if($member->approved_at)
                                    <div class="text-muted dark:text-gray-400">{{ $member->approved_at->format('H:i') }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-success dark:bg-green-600">
                                <i class="fas fa-check-circle me-1"></i>Aktif
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-info dark:btn-outline-blue-400" 
                                        onclick="showRegistrationDetail({{ $member->id }})" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-primary dark:btn-outline-blue-400" 
                                        onclick="contactMember({{ $member->id }})" title="Kontak">
                                    <i class="fas fa-envelope"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning dark:btn-outline-yellow-400" 
                                        onclick="removeFromExtracurricular({{ $member->id }})" title="Keluarkan">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Summary Footer -->
    <div class="members-summary">
        <div class="summary-content">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $members->count() }} active members in {{ $extracurricular->name }}</span>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-users fa-3x text-muted dark:text-gray-600 mb-3"></i>
        <h5 class="text-muted dark:text-gray-400">Belum Ada Anggota</h5>
        <p class="text-muted dark:text-gray-500">
            <strong>{{ $extracurricular->name }}</strong> belum memiliki anggota aktif.
        </p>
        <div class="mt-3">
            @if($extracurricular->status === 'active')
                <p class="text-success dark:text-green-400 small">
                    <i class="fas fa-info-circle me-1"></i>
                    Ekstrakurikuler ini aktif dan menerima pendaftaran baru.
                </p>
            @else
                <p class="text-warning dark:text-yellow-400 small">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Ekstrakurikuler ini tidak aktif. Aktifkan untuk menerima pendaftaran.
                </p>
                <a href="{{ route('admin.extracurriculars.edit', $extracurricular) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i>Aktifkan Ekstrakurikuler
                </a>
            @endif
        </div>
    </div>
@endif

<style>
/* Enhanced Action Bar Styles */
.action-bar {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    position: relative;
    overflow: hidden;
}

.action-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
}

.action-stats {
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
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.stat-icon.coach-icon {
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

.action-buttons {
    display: flex;
    gap: 1rem;
}

.action-btn {
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

.action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.5s ease;
}

.action-btn:hover::before {
    left: 100%;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border-color: transparent;
}

.export-btn:hover {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.broadcast-btn:hover {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
}

.certificate-btn:hover {
    background: linear-gradient(135deg, #f59e0b, #d97706);
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

.export-btn .btn-icon {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.broadcast-btn .btn-icon {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.certificate-btn .btn-icon {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.action-btn:hover .btn-icon {
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

.action-btn:hover .btn-title,
.action-btn:hover .btn-subtitle {
    color: white;
}

/* Members Summary */
.members-summary {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    border: 1px solid #e2e8f0;
    margin-top: 1.5rem;
}

.summary-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
}

.summary-content svg {
    color: #10b981;
}

/* Avatar Circle */
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

/* Dark Mode Support */
.dark .action-bar {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    border-color: #374151;
}

.dark .stat-number {
    color: #f9fafb;
}

.dark .stat-label {
    color: #d1d5db;
}

.dark .action-btn {
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

.dark .members-summary {
    background: #374151;
    border-color: #4b5563;
}

.dark .summary-content {
    color: #d1d5db;
}

/* Responsive Design */
@media (max-width: 768px) {
    .action-bar {
        flex-direction: column;
        gap: 1.5rem;
        padding: 1.25rem;
    }
    
    .action-stats {
        justify-content: center;
        gap: 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        width: 100%;
        gap: 0.75rem;
    }
    
    .action-btn {
        justify-content: center;
        min-width: auto;
        width: 100%;
    }
    
    .stat-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
}

@media (max-width: 480px) {
    .action-stats {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<script>
function contactMember(memberId) {
    if (confirm('Open email client to contact this member?')) {
        alert('Email client will be opened (feature coming soon)');
    }
}

function exportMembers(extracurricularId) {
    const exportBtn = document.querySelector('.export-btn');
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
        window.location.href = `/admin/extracurriculars/${extracurricularId}/members/export`;
    }, 1500);
}

function sendBroadcast(extracurricularId) {
    alert('Broadcast feature will be available soon!');
}

function generateCertificate(extracurricularId) {
    alert('Certificate generation feature will be available soon!');
}

function showRegistrationDetail(registrationId) {
    alert('Registration detail feature will be available soon!');
}

function removeFromExtracurricular(registrationId) {
    if (confirm('Are you sure you want to remove this member from the extracurricular?')) {
        alert('Remove member feature will be available soon!');
    }
}

// Add CSS for animations
if (!document.querySelector('#members-animations')) {
    const style = document.createElement('style');
    style.id = 'members-animations';
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