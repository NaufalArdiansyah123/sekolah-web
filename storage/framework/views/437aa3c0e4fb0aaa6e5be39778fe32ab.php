<?php $__env->startSection('content'); ?>
<style>
    /* Enhanced Detail Styles */
    .detail-container {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }
    
    .dark .detail-container {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .agenda-header {
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .agenda-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    
    .agenda-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
    }
    
    .meta-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }
    
    .meta-content h4 {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
    }
    
    .meta-content p {
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .status-inactive {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .agenda-content {
        color: var(--text-primary);
        line-height: 1.7;
        font-size: 1rem;
    }
    
    .agenda-content h1,
    .agenda-content h2,
    .agenda-content h3,
    .agenda-content h4,
    .agenda-content h5,
    .agenda-content h6 {
        color: var(--text-primary);
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    
    .agenda-content p {
        margin-bottom: 1rem;
    }
    
    .agenda-content ul,
    .agenda-content ol {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }
    
    .agenda-content li {
        margin-bottom: 0.5rem;
    }
    
    .agenda-content blockquote {
        border-left: 4px solid var(--accent-color);
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: var(--text-secondary);
    }
    
    .agenda-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .btn-primary {
        background: var(--accent-color);
        color: white;
    }
    
    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }
    
    .btn-secondary:hover {
        background: var(--bg-secondary);
        transform: translateY(-1px);
    }
    
    .btn-success {
        background: #10b981;
        color: white;
    }
    
    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
    }
    
    .btn-warning {
        background: #f59e0b;
        color: white;
    }
    
    .btn-warning:hover {
        background: #d97706;
        transform: translateY(-1px);
    }
    
    .btn-danger {
        background: #ef4444;
        color: white;
    }
    
    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    .info-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    .info-value {
        font-weight: 600;
        color: var(--text-primary);
        text-align: right;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .detail-container {
            padding: 1.5rem;
        }
        
        .agenda-title {
            font-size: 1.5rem;
        }
        
        .agenda-meta {
            grid-template-columns: 1fr;
        }
        
        .agenda-actions {
            flex-direction: column;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Agenda</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Informasi lengkap agenda kegiatan</p>
        </div>
        <a href="<?php echo e(route('admin.posts.agenda')); ?>" 
           class="btn btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Agenda Detail -->
    <div class="detail-container">
        <!-- Header -->
        <div class="agenda-header">
            <h2 class="agenda-title"><?php echo e($agenda->title); ?></h2>
            
            <!-- Meta Information -->
            <div class="agenda-meta">
                <div class="meta-item">
                    <div class="meta-icon" style="background: #3b82f6;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="meta-content">
                        <h4>Tanggal & Waktu</h4>
                        <p><?php echo e($agenda->event_date ? $agenda->event_date->format('l, d F Y') : 'Tidak ada tanggal'); ?></p>
                        <?php if($agenda->event_date): ?>
                            <p class="text-sm text-gray-500"><?php echo e($agenda->event_date->format('H:i')); ?> WIB</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if($agenda->location): ?>
                    <div class="meta-item">
                        <div class="meta-icon" style="background: #10b981;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="meta-content">
                            <h4>Lokasi</h4>
                            <p><?php echo e($agenda->location); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="meta-item">
                    <div class="meta-icon" style="background: #f59e0b;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="meta-content">
                        <h4>Status</h4>
                        <span class="status-badge status-<?php echo e($agenda->status); ?>">
                            <?php if($agenda->status == 'active'): ?>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Aktif
                            <?php else: ?>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Tidak Aktif
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="agenda-content">
            <?php echo $agenda->content; ?>

        </div>

        <!-- Actions -->
        <div class="agenda-actions">
            <a href="<?php echo e(route('admin.posts.agenda.edit', $agenda->id)); ?>" 
               class="btn btn-warning">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Agenda
            </a>
            
            <?php if($agenda->status == 'active'): ?>
                <a href="<?php echo e(route('agenda.show', $agenda->id)); ?>" 
                   class="btn btn-success" 
                   target="_blank">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Lihat di Public
                </a>
            <?php endif; ?>
            
            <form method="POST" 
                  action="<?php echo e(route('admin.posts.agenda.destroy', $agenda->id)); ?>" 
                  class="inline"
                  onsubmit="return confirmDelete('Apakah Anda yakin ingin menghapus agenda ini? Tindakan ini tidak dapat dibatalkan.')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Agenda
                </button>
            </form>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="info-section">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Informasi Tambahan
        </h3>
        
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">ID Agenda</span>
                <span class="info-value">#<?php echo e($agenda->id); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Dibuat Oleh</span>
                <span class="info-value"><?php echo e($agenda->user->name ?? 'Admin'); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Dibuat</span>
                <span class="info-value"><?php echo e($agenda->created_at->format('d M Y H:i')); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Terakhir Diupdate</span>
                <span class="info-value"><?php echo e($agenda->updated_at->format('d M Y H:i')); ?></span>
            </div>
            <?php if($agenda->event_date): ?>
                <div class="info-item">
                    <span class="info-label">Status Waktu</span>
                    <span class="info-value">
                        <?php if($agenda->event_date->isPast()): ?>
                            <span class="text-red-600">Sudah Lewat</span>
                        <?php elseif($agenda->event_date->isToday()): ?>
                            <span class="text-green-600">Hari Ini</span>
                        <?php else: ?>
                            <span class="text-blue-600">Mendatang</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Countdown</span>
                    <span class="info-value">
                        <?php if($agenda->event_date->isPast()): ?>
                            <?php echo e($agenda->event_date->diffForHumans()); ?>

                        <?php else: ?>
                            <?php echo e($agenda->event_date->diffForHumans()); ?>

                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function confirmDelete(message) {
    return confirm(message);
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/posts/agenda/show.blade.php ENDPATH**/ ?>