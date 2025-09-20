
<div class="student-detail-container">
    <style>
        .student-detail-container {
            max-height: 70vh;
            overflow-y: auto;
            padding: 0.5rem;
        }
        
        .detail-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-secondary));
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .student-avatar {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            margin-right: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            object-fit: cover;
            border: 3px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .dark .student-avatar {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .student-info h3 {
            margin: 0 0 0.5rem 0;
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        
        .student-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            background: var(--bg-primary);
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .meta-item:hover {
            background: var(--bg-secondary);
            transform: translateY(-1px);
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.3s ease;
        }
        
        .status-badge.pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        
        .status-badge.active {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .status-badge.rejected {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        .detail-sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        @media (max-width: 768px) {
            .detail-sections {
                grid-template-columns: 1fr;
            }
            
            .detail-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .student-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
        
        .detail-section {
            background: var(--bg-primary);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px var(--shadow-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .detail-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            border-radius: 12px 12px 0 0;
        }

        .detail-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px var(--shadow-color);
        }
        
        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s ease;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.875rem 0;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: var(--bg-secondary);
            margin: 0 -1rem;
            padding-left: 1rem;
            padding-right: 1rem;
            border-radius: 8px;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 500;
            color: var(--text-secondary);
            min-width: 120px;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }
        
        .detail-value {
            color: var(--text-primary);
            font-weight: 500;
            text-align: right;
            flex: 1;
            transition: color 0.3s ease;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }
        
        .btn-action {
            padding: 0.875rem 1.75rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-action:hover::before {
            left: 100%;
        }
        
        .btn-approve {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }
        
        .btn-approve:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
            color: white;
            text-decoration: none;
        }
        
        .btn-reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }
        
        .btn-reject:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
            color: white;
            text-decoration: none;
        }
        
        .rejection-reason {
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            padding: 1.25rem;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }

        .rejection-reason:hover {
            background: rgba(239, 68, 68, 0.08);
            transform: translateY(-1px);
        }
        
        .rejection-reason h6 {
            color: #dc2626;
            margin-bottom: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s ease;
        }
        
        .rejection-reason p {
            color: #7f1d1d;
            margin: 0;
            font-size: 0.875rem;
            line-height: 1.6;
            transition: color 0.3s ease;
        }

        .dark .rejection-reason {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .dark .rejection-reason h6 {
            color: #f87171;
        }

        .dark .rejection-reason p {
            color: #fca5a5;
        }

        /* Icon colors for sections */
        .icon-blue { color: #3b82f6; }
        .icon-green { color: #10b981; }
        .icon-purple { color: #8b5cf6; }
        .icon-orange { color: #f59e0b; }

        /* CSS Variables */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-tertiary: #9ca3af;
            --border-color: #e5e7eb;
            --shadow-color: rgba(0, 0, 0, 0.05);
        }

        .dark {
            --bg-primary: #1f2937;
            --bg-secondary: #111827;
            --bg-tertiary: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --text-tertiary: #9ca3af;
            --border-color: #374151;
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        /* Animation */
        .detail-section {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom scrollbar */
        .student-detail-container::-webkit-scrollbar {
            width: 6px;
        }

        .student-detail-container::-webkit-scrollbar-track {
            background: var(--bg-secondary);
            border-radius: 3px;
        }

        .student-detail-container::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 3px;
        }

        .student-detail-container::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }
    </style>

    <!-- Student Header -->
    <div class="detail-header">
        <img src="<?php echo e($registration->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($registration->name).'&color=7F9CF5&background=EBF4FF'); ?>" 
             alt="<?php echo e($registration->name); ?>" 
             class="student-avatar">
        <div class="student-info flex-1">
            <h3><?php echo e($registration->name); ?></h3>
            <div class="student-meta">
                <?php if(isset($registration->nis)): ?>
                <div class="meta-item">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    <span>NIS: <?php echo e($registration->nis); ?></span>
                </div>
                <?php endif; ?>
                <div class="meta-item">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span><?php echo e($registration->email); ?></span>
                </div>
                <?php if(isset($registration->class)): ?>
                <div class="meta-item">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    <span>Kelas <?php echo e($registration->class); ?></span>
                </div>
                <?php endif; ?>
                <div class="meta-item">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-2 13a2 2 0 002 2h6a2 2 0 002-2L16 7"/>
                    </svg>
                    <span>Daftar: <?php echo e($registration->created_at->format('d/m/Y H:i')); ?></span>
                </div>
            </div>
            <div>
                <span class="status-badge <?php echo e($registration->status); ?>">
                    <?php if($registration->status == 'pending'): ?>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Menunggu Konfirmasi
                    <?php elseif($registration->status == 'active'): ?>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Disetujui
                    <?php elseif($registration->status == 'rejected'): ?>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Ditolak
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Detail Sections -->
    <div class="detail-sections">
        <!-- Data Pribadi -->
        <div class="detail-section">
            <h4 class="section-title">
                <svg class="w-5 h-5 icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Data Pribadi
            </h4>
            <div class="detail-item">
                <span class="detail-label">Nama Lengkap</span>
                <span class="detail-value"><?php echo e($registration->name); ?></span>
            </div>
            <?php if(isset($registration->nis)): ?>
            <div class="detail-item">
                <span class="detail-label">NIS</span>
                <span class="detail-value"><?php echo e($registration->nis); ?></span>
            </div>
            <?php endif; ?>
            <?php if(isset($registration->gender)): ?>
            <div class="detail-item">
                <span class="detail-label">Jenis Kelamin</span>
                <span class="detail-value"><?php echo e($registration->gender == 'male' ? 'Laki-laki' : 'Perempuan'); ?></span>
            </div>
            <?php endif; ?>
            <?php if(isset($registration->birth_place)): ?>
            <div class="detail-item">
                <span class="detail-label">Tempat Lahir</span>
                <span class="detail-value"><?php echo e($registration->birth_place); ?></span>
            </div>
            <?php endif; ?>
            <?php if(isset($registration->birth_date)): ?>
            <div class="detail-item">
                <span class="detail-label">Tanggal Lahir</span>
                <span class="detail-value"><?php echo e(\Carbon\Carbon::parse($registration->birth_date)->format('d/m/Y')); ?></span>
            </div>
            <?php endif; ?>
            <?php if(isset($registration->religion)): ?>
            <div class="detail-item">
                <span class="detail-label">Agama</span>
                <span class="detail-value"><?php echo e($registration->religion); ?></span>
            </div>
            <?php endif; ?>
            <?php if(isset($registration->address)): ?>
            <div class="detail-item">
                <span class="detail-label">Alamat</span>
                <span class="detail-value"><?php echo e($registration->address); ?></span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Data Kontak -->
        <div class="detail-section">
            <h4 class="section-title">
                <svg class="w-5 h-5 icon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Data Kontak
            </h4>
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value"><?php echo e($registration->email); ?></span>
            </div>
            <?php if(isset($registration->phone)): ?>
            <div class="detail-item">
                <span class="detail-label">No. Telepon</span>
                <span class="detail-value"><?php echo e($registration->phone); ?></span>
            </div>
            <?php endif; ?>
            <?php if(isset($registration->class)): ?>
            <div class="detail-item">
                <span class="detail-label">Kelas</span>
                <span class="detail-value"><?php echo e($registration->class); ?></span>
            </div>
            <?php endif; ?>
            <?php if(isset($registration->enrollment_date)): ?>
            <div class="detail-item">
                <span class="detail-label">Tanggal Masuk</span>
                <span class="detail-value"><?php echo e(\Carbon\Carbon::parse($registration->enrollment_date)->format('d/m/Y')); ?></span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Data Orang Tua -->
        <div class="detail-section">
            <h4 class="section-title">
                <svg class="w-5 h-5 icon-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Data Orang Tua
            </h4>
            <?php if(isset($registration->parent_name)): ?>
            <div class="detail-item">
                <span class="detail-label">Nama Orang Tua</span>
                <span class="detail-value"><?php echo e($registration->parent_name); ?></span>
            </div>
            <?php endif; ?>
            <?php if(isset($registration->parent_phone)): ?>
            <div class="detail-item">
                <span class="detail-label">No. Telepon</span>
                <span class="detail-value"><?php echo e($registration->parent_phone); ?></span>
            </div>
            <?php endif; ?>
            <?php if(isset($registration->parent_email)): ?>
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value"><?php echo e($registration->parent_email); ?></span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Status Pendaftaran -->
        <div class="detail-section">
            <h4 class="section-title">
                <svg class="w-5 h-5 icon-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Status Pendaftaran
            </h4>
            <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    <span class="status-badge <?php echo e($registration->status); ?>">
                        <?php if($registration->status == 'pending'): ?>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Menunggu Konfirmasi
                        <?php elseif($registration->status == 'active'): ?>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Disetujui
                        <?php elseif($registration->status == 'rejected'): ?>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Ditolak
                        <?php endif; ?>
                    </span>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Tanggal Daftar</span>
                <span class="detail-value"><?php echo e($registration->created_at->format('d/m/Y H:i:s')); ?></span>
            </div>
            <?php if(isset($registration->approved_at) && $registration->approved_at): ?>
                <div class="detail-item">
                    <span class="detail-label">Tanggal Disetujui</span>
                    <span class="detail-value"><?php echo e($registration->approved_at->format('d/m/Y H:i:s')); ?></span>
                </div>
            <?php endif; ?>
            <?php if(isset($registration->rejected_at) && $registration->rejected_at): ?>
                <div class="detail-item">
                    <span class="detail-label">Tanggal Ditolak</span>
                    <span class="detail-value"><?php echo e($registration->rejected_at->format('d/m/Y H:i:s')); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Rejection Reason (if rejected) -->
    <?php if($registration->status == 'rejected' && isset($registration->rejection_reason) && $registration->rejection_reason): ?>
        <div class="rejection-reason">
            <h6>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                Alasan Penolakan
            </h6>
            <p><?php echo e($registration->rejection_reason); ?></p>
        </div>
    <?php endif; ?>

    <!-- Action Buttons (only for pending status) -->
    <?php if($registration->status == 'pending'): ?>
        <div class="action-buttons">
            <button class="btn-action btn-approve" onclick="approveFromDetail(<?php echo e($registration->id); ?>)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Setujui Pendaftaran
            </button>
            <button class="btn-action btn-reject" onclick="rejectFromDetail(<?php echo e($registration->id); ?>)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tolak Pendaftaran
            </button>
        </div>
    <?php endif; ?>
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

// Initialize animations
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.detail-section');
    sections.forEach((section, index) => {
        section.style.animationDelay = `${index * 0.1}s`;
    });
});
</script><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/student-registrations/show.blade.php ENDPATH**/ ?>