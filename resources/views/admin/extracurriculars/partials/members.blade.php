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
                    <div class="btn-title">Export</div>
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
                                {{ $member->approved_at->format('d M Y') }}
                                <div class="text-muted dark:text-gray-400">{{ $member->approved_at->format('H:i') }}</div>
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

.dark .btn-outline-info {
    color: #60A5FA;
    border-color: #3B82F6;
}

.dark .btn-outline-primary {
    color: #60A5FA;
    border-color: #3B82F6;
}

.dark .btn-outline-warning {
    color: #FBBF24;
    border-color: #F59E0B;
}

.dark .btn-outline-secondary {
    color: #9CA3AF;
    border-color: #6B7280;
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

/* Enhanced Broadcast Modal Styles */
.broadcast-modal {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
}

.broadcast-header {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    padding: 2rem;
    border: none;
    position: relative;
    overflow: hidden;
}

.broadcast-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(30px, -30px);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    z-index: 2;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.header-text .modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    color: white;
}

.modal-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.btn-close-custom {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 12px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all 0.3s ease;
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
}

.btn-close-custom:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.broadcast-body {
    padding: 2rem;
    background: #f8fafc;
}

.broadcast-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.info-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

.info-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.info-icon.delivery-icon {
    background: linear-gradient(135deg, #10b981, #059669);
}

.info-content {
    flex: 1;
}

.info-title {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.info-value {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
}

.broadcast-form {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.form-section {
    margin-bottom: 2rem;
}

.form-section:last-child {
    margin-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e2e8f0;
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.enhanced-input,
.enhanced-textarea {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.enhanced-input:focus,
.enhanced-textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: white;
    outline: none;
}

.input-helper {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.5rem;
    font-style: italic;
}

.char-counter {
    text-align: right;
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.5rem;
}

.delivery-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.option-card {
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.option-card:hover {
    border-color: #3b82f6;
    background: #f0f9ff;
}

.option-card.active {
    border-color: #3b82f6;
    background: #f0f9ff;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);
}

.option-icon {
    width: 40px;
    height: 40px;
    background: #e5e7eb;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    transition: all 0.3s ease;
}

.option-card.active .option-icon {
    background: #3b82f6;
    color: white;
}

.option-content {
    flex: 1;
}

.option-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.option-desc {
    font-size: 0.8rem;
    color: #6b7280;
}

.option-toggle input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: #3b82f6;
}

.schedule-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.schedule-option {
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
}

.schedule-option:hover {
    border-color: #3b82f6;
    background: #f0f9ff;
}

.schedule-option.active {
    border-color: #3b82f6;
    background: #f0f9ff;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);
}

.schedule-option input[type="radio"] {
    display: none;
}

.schedule-option label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    margin: 0;
    cursor: pointer;
}

.schedule-icon {
    width: 36px;
    height: 36px;
    background: #e5e7eb;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    transition: all 0.3s ease;
}

.schedule-option.active .schedule-icon {
    background: #3b82f6;
    color: white;
}

.schedule-text {
    flex: 1;
}

.schedule-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.schedule-desc {
    font-size: 0.8rem;
    color: #6b7280;
}

.schedule-datetime {
    background: #f0f9ff;
    border: 2px solid #3b82f6;
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.datetime-inputs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.input-group {
    display: flex;
    flex-direction: column;
}

.input-group label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.input-group input {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.input-group input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.broadcast-footer {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-secondary-custom {
    background: #6b7280;
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.btn-secondary-custom:hover {
    background: #4b5563;
    transform: translateY(-1px);
    color: white;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    color: white;
}

.btn-primary-custom:disabled {
    background: #9ca3af;
    transform: none;
    box-shadow: none;
    cursor: not-allowed;
}

/* Dark mode support for broadcast modal */
.dark .broadcast-modal {
    background: #1f2937;
}

.dark .broadcast-body {
    background: #111827;
}

.dark .info-card {
    background: #374151;
    border-color: #4b5563;
}

.dark .info-title {
    color: #d1d5db;
}

.dark .info-value {
    color: #f9fafb;
}

.dark .broadcast-form {
    background: #374151;
}

.dark .section-header {
    color: #f9fafb;
    border-color: #4b5563;
}

.dark .form-label {
    color: #d1d5db;
}

.dark .enhanced-input,
.dark .enhanced-textarea {
    background: #1f2937;
    border-color: #4b5563;
    color: #f9fafb;
}

.dark .enhanced-input:focus,
.dark .enhanced-textarea:focus {
    background: #1f2937;
    border-color: #3b82f6;
}

.dark .option-card {
    background: #1f2937;
    border-color: #4b5563;
}

.dark .option-card:hover,
.dark .option-card.active {
    background: #1e3a8a;
    border-color: #3b82f6;
}

.dark .option-title {
    color: #f9fafb;
}

.dark .option-desc {
    color: #d1d5db;
}

.dark .schedule-option {
    background: #1f2937;
    border-color: #4b5563;
}

.dark .schedule-option:hover,
.dark .schedule-option.active {
    background: #1e3a8a;
    border-color: #3b82f6;
}

.dark .schedule-title {
    color: #f9fafb;
}

.dark .schedule-desc {
    color: #d1d5db;
}

.dark .schedule-datetime {
    background: #1e3a8a;
}

.dark .input-group label {
    color: #d1d5db;
}

.dark .input-group input {
    background: #1f2937;
    border-color: #4b5563;
    color: #f9fafb;
}

.dark .broadcast-footer {
    background: #111827;
    border-color: #374151;
}

/* Responsive design for broadcast modal */
@media (max-width: 768px) {
    .broadcast-header {
        padding: 1.5rem;
    }
    
    .header-content {
        gap: 1rem;
    }
    
    .header-icon {
        width: 48px;
        height: 48px;
    }
    
    .header-text .modal-title {
        font-size: 1.25rem;
    }
    
    .broadcast-body {
        padding: 1.5rem;
    }
    
    .broadcast-form {
        padding: 1.5rem;
    }
    
    .broadcast-info {
        grid-template-columns: 1fr;
    }
    
    .delivery-options {
        grid-template-columns: 1fr;
    }
    
    .schedule-options {
        grid-template-columns: 1fr;
    }
    
    .datetime-inputs {
        grid-template-columns: 1fr;
    }
    
    .broadcast-footer {
        flex-direction: column;
        gap: 1rem;
        padding: 1.5rem;
    }
    
    .btn-secondary-custom,
    .btn-primary-custom {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
function contactMember(memberId) {
    // Implementation for contacting member
    if (confirm('Open email client to contact this member?')) {
        // You can implement email functionality here
        alert('Email client will be opened (feature coming soon)');
    }
}

function exportMembers(extracurricularId) {
    // Show loading state
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
    
    // Simulate export process
    setTimeout(() => {
        exportBtn.innerHTML = originalContent;
        // Redirect to export URL
        window.location.href = `/admin/extracurriculars/${extracurricularId}/members/export`;
    }, 1500);
}

function sendBroadcast(extracurricularId) {
    // Create enhanced broadcast modal
    const modalHtml = `
        <div class="modal fade" id="broadcastModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content broadcast-modal">
                    <div class="modal-header broadcast-header">
                        <div class="header-content">
                            <div class="header-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                            </div>
                            <div class="header-text">
                                <h5 class="modal-title">Send Broadcast Message</h5>
                                <p class="modal-subtitle">Communicate with all extracurricular members</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body broadcast-body">
                        <div class="broadcast-info">
                            <div class="info-card">
                                <div class="info-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div class="info-content">
                                    <div class="info-title">Recipients</div>
                                    <div class="info-value" id="recipientCount">Loading...</div>
                                </div>
                            </div>
                            <div class="info-card">
                                <div class="info-icon delivery-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="info-content">
                                    <div class="info-title">Delivery Method</div>
                                    <div class="info-value">Email & Public Notice</div>
                                </div>
                            </div>
                        </div>
                        
                        <form id="broadcastForm" class="broadcast-form">
                            <div class="form-section">
                                <div class="section-header">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    <span>Message Details</span>
                                </div>
                                
                                <div class="form-group">
                                    <label for="messageSubject" class="form-label">
                                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        Subject
                                    </label>
                                    <input type="text" class="form-control enhanced-input" id="messageSubject" placeholder="Enter a compelling subject line..." required>
                                    <div class="input-helper">This will be the title of your announcement</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="messageContent" class="form-label">
                                        <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Message Content
                                    </label>
                                    <textarea class="form-control enhanced-textarea" id="messageContent" rows="6" placeholder="Write your message here...\n\nTip: Be clear and concise. This message will be sent to all members and posted publicly." required></textarea>
                                    <div class="char-counter">
                                        <span id="charCount">0</span> characters
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <div class="section-header">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                    </svg>
                                    <span>Delivery Options</span>
                                </div>
                                
                                <div class="delivery-options">
                                    <div class="option-card active" data-option="email">
                                        <div class="option-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="option-content">
                                            <div class="option-title">Email Notification</div>
                                            <div class="option-desc">Send to all member emails</div>
                                        </div>
                                        <div class="option-toggle">
                                            <input type="checkbox" id="sendEmail" checked>
                                        </div>
                                    </div>
                                    
                                    <div class="option-card active" data-option="public">
                                        <div class="option-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM16 3H4v2h12V3zM4 7h12v2H4V7zM4 11h12v2H4v-2z"/>
                                            </svg>
                                        </div>
                                        <div class="option-content">
                                            <div class="option-title">Public Announcement</div>
                                            <div class="option-desc">Post on public website</div>
                                        </div>
                                        <div class="option-toggle">
                                            <input type="checkbox" id="postPublic" checked>
                                        </div>
                                    </div>
                                    
                                    <div class="option-card" data-option="sms">
                                        <div class="option-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="option-content">
                                            <div class="option-title">SMS Notification</div>
                                            <div class="option-desc">Send text messages (premium)</div>
                                        </div>
                                        <div class="option-toggle">
                                            <input type="checkbox" id="sendSMS">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <div class="section-header">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Schedule Options</span>
                                </div>
                                
                                <div class="schedule-options">
                                    <div class="schedule-option active" data-schedule="now">
                                        <input type="radio" name="scheduleType" value="now" id="scheduleNow" checked>
                                        <label for="scheduleNow">
                                            <div class="schedule-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </div>
                                            <div class="schedule-text">
                                                <div class="schedule-title">Send Now</div>
                                                <div class="schedule-desc">Immediate delivery</div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="schedule-option" data-schedule="later">
                                        <input type="radio" name="scheduleType" value="later" id="scheduleLater">
                                        <label for="scheduleLater">
                                            <div class="schedule-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="schedule-text">
                                                <div class="schedule-title">Schedule Later</div>
                                                <div class="schedule-desc">Set specific time</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="schedule-datetime" id="scheduleDateTime" style="display: none;">
                                    <div class="datetime-inputs">
                                        <div class="input-group">
                                            <label for="scheduleDate">Date</label>
                                            <input type="date" class="form-control" id="scheduleDate">
                                        </div>
                                        <div class="input-group">
                                            <label for="scheduleTime">Time</label>
                                            <input type="time" class="form-control" id="scheduleTime">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer broadcast-footer">
                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary-custom" onclick="sendBroadcastMessage(${extracurricularId})">
                            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            <span id="sendButtonText">Send Broadcast</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('broadcastModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Initialize modal functionality
    initializeBroadcastModal(extracurricularId);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('broadcastModal'));
    modal.show();
}

function initializeBroadcastModal(extracurricularId) {
    // Load recipient count
    fetch(`/admin/extracurriculars/${extracurricularId}/members/count`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('recipientCount').textContent = `${data.count} active members`;
        })
        .catch(() => {
            document.getElementById('recipientCount').textContent = 'Loading failed';
        });
    
    // Character counter for message content
    const messageContent = document.getElementById('messageContent');
    const charCount = document.getElementById('charCount');
    
    messageContent.addEventListener('input', function() {
        charCount.textContent = this.value.length;
        
        // Update color based on length
        if (this.value.length > 500) {
            charCount.style.color = '#f59e0b';
        } else if (this.value.length > 800) {
            charCount.style.color = '#dc2626';
        } else {
            charCount.style.color = '#6b7280';
        }
    });
    
    // Delivery option toggles
    document.querySelectorAll('.option-card').forEach(card => {
        card.addEventListener('click', function() {
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                this.classList.add('active');
            } else {
                this.classList.remove('active');
            }
        });
    });
    
    // Schedule option toggles
    document.querySelectorAll('.schedule-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove active from all options
            document.querySelectorAll('.schedule-option').forEach(opt => {
                opt.classList.remove('active');
            });
            
            // Add active to clicked option
            this.classList.add('active');
            
            // Show/hide datetime inputs
            const scheduleDateTime = document.getElementById('scheduleDateTime');
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            if (radio.value === 'later') {
                scheduleDateTime.style.display = 'block';
                // Set default date to tomorrow
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                document.getElementById('scheduleDate').value = tomorrow.toISOString().split('T')[0];
                document.getElementById('scheduleTime').value = '09:00';
            } else {
                scheduleDateTime.style.display = 'none';
            }
        });
    });
    
    // Update send button text based on schedule
    document.querySelectorAll('input[name="scheduleType"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const sendButtonText = document.getElementById('sendButtonText');
            if (this.value === 'later') {
                sendButtonText.textContent = 'Schedule Broadcast';
            } else {
                sendButtonText.textContent = 'Send Broadcast';
            }
        });
    });
}

function sendBroadcastMessage(extracurricularId) {
    const subject = document.getElementById('messageSubject').value;
    const content = document.getElementById('messageContent').value;
    const sendEmail = document.getElementById('sendEmail').checked;
    const postPublic = document.getElementById('postPublic').checked;
    const sendSMS = document.getElementById('sendSMS').checked;
    const scheduleType = document.querySelector('input[name="scheduleType"]:checked').value;
    
    let scheduleDate = null;
    let scheduleTime = null;
    
    if (scheduleType === 'later') {
        scheduleDate = document.getElementById('scheduleDate').value;
        scheduleTime = document.getElementById('scheduleTime').value;
        
        if (!scheduleDate || !scheduleTime) {
            alert('Please select date and time for scheduled broadcast.');
            return;
        }
    }
    
    if (!subject || !content) {
        alert('Please fill in all required fields.');
        return;
    }
    
    if (!sendEmail && !postPublic && !sendSMS) {
        alert('Please select at least one delivery method.');
        return;
    }
    
    // Show loading state
    const sendBtn = event.target;
    const originalContent = sendBtn.innerHTML;
    sendBtn.innerHTML = `
        <svg class="w-4 h-4 me-2 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        ${scheduleType === 'later' ? 'Scheduling...' : 'Sending...'}
    `;
    sendBtn.disabled = true;
    
    // Prepare broadcast data
    const broadcastData = {
        extracurricular_id: extracurricularId,
        subject: subject,
        content: content,
        send_email: sendEmail,
        post_public: postPublic,
        send_sms: sendSMS,
        schedule_type: scheduleType,
        schedule_date: scheduleDate,
        schedule_time: scheduleTime
    };
    
    // Send broadcast request
    fetch('/admin/extracurriculars/broadcast', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(broadcastData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success message
            const successMessage = scheduleType === 'later' 
                ? `Broadcast scheduled successfully for ${scheduleDate} at ${scheduleTime}!`
                : 'Broadcast sent successfully!';
            
            if (postPublic) {
                alert(successMessage + '\n\nThe announcement has been posted on the public website and will be visible to all visitors.');
            } else {
                alert(successMessage);
            }
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('broadcastModal')).hide();
            
            // Optionally refresh the page to show updated data
            if (data.refresh) {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        } else {
            throw new Error(data.message || 'Failed to send broadcast');
        }
    })
    .catch(error => {
        console.error('Broadcast error:', error);
        alert('Error sending broadcast: ' + error.message);
    })
    .finally(() => {
        // Restore button
        sendBtn.innerHTML = originalContent;
        sendBtn.disabled = false;
    });
}

function generateCertificate(extracurricularId) {
    // Create certificate modal
    const modalHtml = `
        <div class="modal fade" id="certificateModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                            Generate Certificates
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success">
                            <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Generate participation certificates for all active members.
                        </div>
                        <form id="certificateForm">
                            <div class="mb-3">
                                <label for="certificateTitle" class="form-label">Certificate Title</label>
                                <input type="text" class="form-control" id="certificateTitle" value="Certificate of Participation" required>
                            </div>
                            <div class="mb-3">
                                <label for="certificateDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="certificateDescription" rows="3" placeholder="This is to certify that the above named student has successfully participated in..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="certificateDate" class="form-label">Issue Date</label>
                                <input type="date" class="form-control" id="certificateDate" value="${new Date().toISOString().split('T')[0]}" required>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeGrades" checked>
                                    <label class="form-check-label" for="includeGrades">
                                        Include student grades on certificate
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="digitalSignature" checked>
                                    <label class="form-check-label" for="digitalSignature">
                                        Include digital signature
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-warning" onclick="generateCertificates(${extracurricularId})">
                            <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Generate Certificates
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('certificateModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('certificateModal'));
    modal.show();
}

function generateCertificates(extracurricularId) {
    const title = document.getElementById('certificateTitle').value;
    const description = document.getElementById('certificateDescription').value;
    const date = document.getElementById('certificateDate').value;
    const includeGrades = document.getElementById('includeGrades').checked;
    const digitalSignature = document.getElementById('digitalSignature').checked;
    
    if (!title || !date) {
        alert('Please fill in all required fields.');
        return;
    }
    
    // Show loading state
    const generateBtn = event.target;
    const originalContent = generateBtn.innerHTML;
    generateBtn.innerHTML = `
        <svg class="w-4 h-4 me-1 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Generating...
    `;
    generateBtn.disabled = true;
    
    // Simulate generation (replace with actual API call)
    setTimeout(() => {
        alert('Certificates generated successfully! Download will start shortly.');
        bootstrap.Modal.getInstance(document.getElementById('certificateModal')).hide();
        generateBtn.innerHTML = originalContent;
        generateBtn.disabled = false;
        
        // Redirect to certificate generation URL
        window.location.href = `/admin/extracurriculars/${extracurricularId}/certificates/generate?title=${encodeURIComponent(title)}&date=${date}&grades=${includeGrades}&signature=${digitalSignature}`;
    }, 3000);
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