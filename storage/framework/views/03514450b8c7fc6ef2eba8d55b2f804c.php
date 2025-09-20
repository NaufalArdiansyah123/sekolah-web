<?php $__env->startSection('content'); ?>
<?php
    use Illuminate\Support\Facades\Storage;
?>
<style>
    /* Enhanced Video Detail Styles */
    .video-detail-container {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }
    
    .dark .video-detail-container {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .video-player {
        width: 100%;
        height: 400px;
        background: #000;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 2rem;
    }
    
    .video-placeholder {
        text-align: center;
        color: white;
        padding: 2rem;
    }
    
    .video-placeholder i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.7;
    }
    
    .video-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .info-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .info-card h3 {
        font-size: 0.875rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .info-card .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .video-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
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
    
    .video-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }
    
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-category {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }
    
    .badge-status-active {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .badge-status-inactive {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .badge-featured {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .video-actions {
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
    
    .btn-danger {
        background: #ef4444;
        color: white;
    }
    
    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .video-detail-container {
            padding: 1.5rem;
        }
        
        .video-player {
            height: 250px;
        }
        
        .video-info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .video-meta {
            grid-template-columns: 1fr;
        }
        
        .video-actions {
            flex-direction: column;
        }
    }
</style>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Video</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Informasi lengkap video dokumentasi</p>
        </div>
        <a href="<?php echo e(route('admin.videos.index')); ?>" 
           class="btn btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Video Detail -->
    <div class="video-detail-container">
        <!-- Video Player -->
        <div class="video-player">
            <?php if($video->filename && Storage::disk('public')->exists('videos/' . $video->filename)): ?>
                <video controls style="width: 100%; height: 100%; object-fit: contain;" preload="metadata"
                       <?php if($video->thumbnail_url): ?> poster="<?php echo e($video->thumbnail_url); ?>" <?php endif; ?>>
                    <source src="<?php echo e(asset('storage/videos/' . $video->filename)); ?>" type="<?php echo e($video->mime_type); ?>">
                    <p>Your browser does not support the video tag.</p>
                </video>
            <?php elseif($video->thumbnail_url): ?>
                <div style="position: relative; width: 100%; height: 100%;">
                    <img src="<?php echo e($video->thumbnail_url); ?>" alt="<?php echo e($video->title); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-align: center;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                        <p>Video file not found</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="video-placeholder">
                    <i class="fas fa-video"></i>
                    <h3 class="text-xl font-semibold"><?php echo e($video->title); ?></h3>
                    <p>Video Player</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Video Title -->
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4"><?php echo e($video->title); ?></h2>

        <!-- Video Badges -->
        <div class="video-badges">
            <span class="badge badge-category"><?php echo e($categories[$video->category] ?? $video->category); ?></span>
            <span class="badge badge-status-<?php echo e($video->status); ?>"><?php echo e($statuses[$video->status] ?? $video->status); ?></span>
            <?php if($video->is_featured): ?>
                <span class="badge badge-featured">Featured</span>
            <?php endif; ?>
        </div>

        <!-- Video Statistics -->
        <div class="video-info-grid">
            <div class="info-card">
                <h3>Views</h3>
                <div class="value"><?php echo e(number_format($video->views)); ?></div>
            </div>

            <div class="info-card">
                <h3>File Size</h3>
                <div class="value"><?php echo e($video->formatted_file_size); ?></div>
            </div>
            <?php if($video->formatted_duration): ?>
                <div class="info-card">
                    <h3>Duration</h3>
                    <div class="value"><?php echo e($video->formatted_duration); ?></div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Video Metadata -->
        <div class="video-meta">
            <div class="meta-item">
                <div class="meta-icon" style="background: #3b82f6;">
                    <i class="fas fa-file"></i>
                </div>
                <div class="meta-content">
                    <h4>Original Name</h4>
                    <p><?php echo e($video->original_name); ?></p>
                </div>
            </div>
            
            <div class="meta-item">
                <div class="meta-icon" style="background: #10b981;">
                    <i class="fas fa-code"></i>
                </div>
                <div class="meta-content">
                    <h4>MIME Type</h4>
                    <p><?php echo e($video->mime_type); ?></p>
                </div>
            </div>
            
            <div class="meta-item">
                <div class="meta-icon" style="background: #f59e0b;">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="meta-content">
                    <h4>Upload Date</h4>
                    <p><?php echo e($video->created_at->format('d M Y H:i')); ?></p>
                </div>
            </div>
            
            <?php if($video->uploader): ?>
                <div class="meta-item">
                    <div class="meta-icon" style="background: #8b5cf6;">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="meta-content">
                        <h4>Uploaded By</h4>
                        <p><?php echo e($video->uploader->name); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Video Description -->
        <?php if($video->description): ?>
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Deskripsi</h3>
                <div class="prose prose-sm max-w-none text-gray-700 dark:text-gray-300">
                    <?php echo nl2br(e($video->description)); ?>

                </div>
            </div>
        <?php endif; ?>

        <!-- Video Actions -->
        <div class="video-actions">
            <a href="<?php echo e(route('admin.videos.edit', $video)); ?>" 
               class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Video
            </a>
            

            <form method="POST" 
                  action="<?php echo e(route('admin.videos.toggle-featured', $video)); ?>" 
                  class="inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-secondary">
                    <?php if($video->is_featured): ?>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                        Remove Featured
                    <?php else: ?>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        Set Featured
                    <?php endif; ?>
                </button>
            </form>
            
            <form method="POST" 
                  action="<?php echo e(route('admin.videos.destroy', $video)); ?>" 
                  class="inline"
                  onsubmit="return confirmDelete('Apakah Anda yakin ingin menghapus video ini?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Video
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(message) {
    return confirm(message);
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/videos/show.blade.php ENDPATH**/ ?>