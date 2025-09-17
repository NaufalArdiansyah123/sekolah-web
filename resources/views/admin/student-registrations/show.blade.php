{{-- Detail Pendaftaran Siswa --}}
<div class="student-detail-container">
    <style>
        .student-detail-container {
            max-height: 70vh;
            overflow-y: auto;
        }
        
        .detail-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        
        .dark .detail-header {
            background: linear-gradient(135deg, #374151, #4b5563);
            border-color: #4b5563;
        }
        
        .student-avatar {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            margin-right: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .student-info h3 {
            margin: 0 0 0.5rem 0;
            color: #1f2937;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .dark .student-info h3 {
            color: #f9fafb;
        }
        
        .student-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .dark .meta-item {
            color: #9ca3af;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .dark .status-badge.pending {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }
        
        .status-badge.active {
            background: #dcfce7;
            color: #166534;
        }
        
        .dark .status-badge.active {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }
        
        .status-badge.rejected {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .dark .status-badge.rejected {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }
        
        .detail-sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        @media (max-width: 768px) {
            .detail-sections {
                grid-template-columns: 1fr;
            }
        }
        
        .detail-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .dark .detail-section {
            background: #374151;
            border-color: #4b5563;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .dark .section-title {
            color: #f9fafb;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .dark .detail-item {
            border-color: #4b5563;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 500;
            color: #6b7280;
            min-width: 120px;
            font-size: 0.875rem;
        }
        
        .dark .detail-label {
            color: #9ca3af;
        }
        
        .detail-value {
            color: #1f2937;
            font-weight: 500;
            text-align: right;
            flex: 1;
        }
        
        .dark .detail-value {
            color: #f9fafb;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .dark .action-buttons {
            border-color: #4b5563;
        }
        
        .btn-action {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-approve {
            background: #10b981;
            color: white;
        }
        
        .btn-approve:hover {
            background: #059669;
            transform: translateY(-2px);
        }
        
        .btn-reject {
            background: #ef4444;
            color: white;
        }
        
        .btn-reject:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }
        
        .rejection-reason {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .dark .rejection-reason {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
        }
        
        .rejection-reason h6 {
            color: #dc2626;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .dark .rejection-reason h6 {
            color: #f87171;
        }
        
        .rejection-reason p {
            color: #7f1d1d;
            margin: 0;
            font-size: 0.875rem;
        }
        
        .dark .rejection-reason p {
            color: #fca5a5;
        }
    </style>

    <!-- Student Header -->
    <div class="detail-header">
        <img src="{{ $registration->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($registration->name).'&color=7F9CF5&background=EBF4FF' }}" 
             alt="{{ $registration->name }}" 
             class="student-avatar">
        <div class="student-info flex-1">
            <h3>{{ $registration->name }}</h3>
            <div class="student-meta">
                @if(isset($registration->nis))
                <div class="meta-item">
                    <i class="fas fa-id-card"></i>
                    <span>NIS: {{ $registration->nis }}</span>
                </div>
                @endif
                <div class="meta-item">
                    <i class="fas fa-envelope"></i>
                    <span>{{ $registration->email }}</span>
                </div>
                @if(isset($registration->class))
                <div class="meta-item">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Kelas {{ $registration->class }}</span>
                </div>
                @endif
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    <span>Daftar: {{ $registration->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            <div class="mt-2">
                <span class="status-badge {{ $registration->status }}">
                    @if($registration->status == 'pending')
                        <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                    @elseif($registration->status == 'active')
                        <i class="fas fa-check me-1"></i>Disetujui
                    @elseif($registration->status == 'rejected')
                        <i class="fas fa-times me-1"></i>Ditolak
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Detail Sections -->
    <div class="detail-sections">
        <!-- Data Pribadi -->
        <div class="detail-section">
            <h4 class="section-title">
                <i class="fas fa-user text-blue-500"></i>
                Data Pribadi
            </h4>
            <div class="detail-item">
                <span class="detail-label">Nama Lengkap</span>
                <span class="detail-value">{{ $registration->name }}</span>
            </div>
            @if(isset($registration->nis))
            <div class="detail-item">
                <span class="detail-label">NIS</span>
                <span class="detail-value">{{ $registration->nis }}</span>
            </div>
            @endif
            @if(isset($registration->gender))
            <div class="detail-item">
                <span class="detail-label">Jenis Kelamin</span>
                <span class="detail-value">{{ $registration->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            @endif
            @if(isset($registration->birth_place))
            <div class="detail-item">
                <span class="detail-label">Tempat Lahir</span>
                <span class="detail-value">{{ $registration->birth_place }}</span>
            </div>
            @endif
            @if(isset($registration->birth_date))
            <div class="detail-item">
                <span class="detail-label">Tanggal Lahir</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($registration->birth_date)->format('d/m/Y') }}</span>
            </div>
            @endif
            <div class="detail-item">
                <span class="detail-label">Agama</span>
                <span class="detail-value">{{ $registration->religion }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Alamat</span>
                <span class="detail-value">{{ $registration->address }}</span>
            </div>
        </div>

        <!-- Data Kontak -->
        <div class="detail-section">
            <h4 class="section-title">
                <i class="fas fa-phone text-green-500"></i>
                Data Kontak
            </h4>
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $registration->email }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">No. Telepon</span>
                <span class="detail-value">{{ $registration->phone ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Kelas</span>
                <span class="detail-value">{{ $registration->class }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Tanggal Masuk</span>
                <span class="detail-value">{{ $registration->enrollment_date ? \Carbon\Carbon::parse($registration->enrollment_date)->format('d/m/Y') : '-' }}</span>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="detail-section">
            <h4 class="section-title">
                <i class="fas fa-users text-purple-500"></i>
                Data Orang Tua
            </h4>
            <div class="detail-item">
                <span class="detail-label">Nama Orang Tua</span>
                <span class="detail-value">{{ $registration->parent_name }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">No. Telepon</span>
                <span class="detail-value">{{ $registration->parent_phone }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $registration->parent_email ?? '-' }}</span>
            </div>
        </div>

        <!-- Status Pendaftaran -->
        <div class="detail-section">
            <h4 class="section-title">
                <i class="fas fa-clipboard-check text-orange-500"></i>
                Status Pendaftaran
            </h4>
            <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    <span class="status-badge {{ $registration->status }}">
                        @if($registration->status == 'pending')
                            Menunggu Konfirmasi
                        @elseif($registration->status == 'active')
                            Disetujui
                        @elseif($registration->status == 'rejected')
                            Ditolak
                        @endif
                    </span>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Tanggal Daftar</span>
                <span class="detail-value">{{ $registration->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            @if($registration->approved_at)
                <div class="detail-item">
                    <span class="detail-label">Tanggal Disetujui</span>
                    <span class="detail-value">{{ $registration->approved_at->format('d/m/Y H:i:s') }}</span>
                </div>
            @endif
            @if($registration->rejected_at)
                <div class="detail-item">
                    <span class="detail-label">Tanggal Ditolak</span>
                    <span class="detail-value">{{ $registration->rejected_at->format('d/m/Y H:i:s') }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Rejection Reason (if rejected) -->
    @if($registration->status == 'rejected' && $registration->rejection_reason)
        <div class="rejection-reason">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Alasan Penolakan</h6>
            <p>{{ $registration->rejection_reason }}</p>
        </div>
    @endif

    <!-- Action Buttons (only for pending status) -->
    @if($registration->status == 'pending')
        <div class="action-buttons">
            <button class="btn-action btn-approve" onclick="approveFromDetail({{ $registration->id }})">
                <i class="fas fa-check"></i>
                Setujui Pendaftaran
            </button>
            <button class="btn-action btn-reject" onclick="rejectFromDetail({{ $registration->id }})">
                <i class="fas fa-times"></i>
                Tolak Pendaftaran
            </button>
        </div>
    @endif
</div>

<script>
function approveFromDetail(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini?')) return;
    
    fetch(`/admin/student-registrations/${id}/approve`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Terjadi kesalahan saat memproses permintaan');
    });
}

function rejectFromDetail(id) {
    bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();
    setTimeout(() => {
        rejectRegistration(id);
    }, 300);
}
</script>