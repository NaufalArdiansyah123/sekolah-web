<?php $__env->startSection('title', $video->title); ?>

<?php $__env->startSection('content'); ?>
<style>
    :root {
        --primary-color: #1a202c;
        --secondary-color: #3182ce;
        --accent-color: #4299e1;
        --light-gray: #f7fafc;
        --dark-gray: #718096;
        --glass-bg: rgba(26, 32, 44, 0.95);
        --gradient-primary: linear-gradient(135deg, #1a202c, #3182ce);
        --gradient-light: linear-gradient(135deg, rgba(49, 130, 206, 0.1), rgba(66, 153, 225, 0.05));
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        color: #333;
        line-height: 1.6;
    }
    
    /* Video Player Section */
    .video-player-section {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        padding: 2rem 0;
    }
    
    .video-player-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        position: relative;
    }
    
    .video-player {
        width: 100%;
        height: 500px;
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
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
    
    .video-controls {
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    
    .video-title-section {
        margin-bottom: 1rem;
    }
    
    .video-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }
    
    .video-meta-info {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: var(--dark-gray);
    }
    
    .video-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .video-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .video-badge {
        padding: 0.4rem 1rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-category {
        background: rgba(49, 130, 206, 0.1);
        color: var(--secondary-color);
    }
    
    .badge-featured {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .video-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn-video-action {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }
    
    .btn-download {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }
    
    .btn-download:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        text-decoration: none;
    }
    
    .btn-share {
        background: #f8fafc;
        color: var(--primary-color);
        border: 2px solid #e2e8f0;
    }
    
    .btn-share:hover {
        background: #f1f5f9;
        color: var(--primary-color);
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    /* Video Info Section */
    .video-info-section {
        padding: 3rem 0;
    }
    
    .info-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 2rem;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }
    
    .info-card h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .video-description {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #4a5568;
        margin-bottom: 1.5rem;
    }
    
    .video-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .stat-item {
        text-align: center;
        padding: 1rem;
        background: rgba(49, 130, 206, 0.05);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .stat-item:hover {
        background: rgba(49, 130, 206, 0.1);
        transform: translateY(-2px);
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: var(--dark-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    
    /* Related Videos Section */
    .related-videos-section {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        padding: 3rem 0;
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        position: relative;
    }
    
    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        border-radius: 2px;
    }
    
    .related-video-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        height: 100%;
    }
    
    .related-video-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    .related-video-thumbnail {
        position: relative;
        width: 100%;
        height: 180px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .related-video-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .related-video-card:hover .related-video-thumbnail img {
        transform: scale(1.1);
    }
    
    .related-video-placeholder {
        color: white;
        text-align: center;
        padding: 1rem;
    }
    
    .related-video-info {
        padding: 1.5rem;
    }
    
    .related-video-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .related-video-meta {
        font-size: 0.85rem;
        color: var(--dark-gray);
        margin-bottom: 1rem;
    }
    
    .related-video-link {
        color: var(--secondary-color);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .related-video-link:hover {
        color: var(--accent-color);
        text-decoration: none;
    }
    
    /* Breadcrumb */
    .breadcrumb-section {
        background: white;
        padding: 1rem 0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
    }
    
    .breadcrumb-item a {
        color: var(--secondary-color);
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        color: var(--accent-color);
    }
    
    .breadcrumb-item.active {
        color: var(--dark-gray);
    }
    
    /* Animation Classes */
    .fade-in-up {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-left {
        opacity: 0;
        transform: translateX(-40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-right {
        opacity: 0;
        transform: translateX(40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .scale-in {
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-up.animate,
    .fade-in-left.animate,
    .fade-in-right.animate {
        opacity: 1;
        transform: translate(0, 0);
    }
    
    .scale-in.animate {
        opacity: 1;
        transform: scale(1);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .video-player {
            height: 300px;
        }
        
        .video-title {
            font-size: 1.5rem;
        }
        
        .video-actions {
            flex-direction: column;
        }
        
        .btn-video-action {
            justify-content: center;
        }
        
        .video-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .section-title h2 {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 576px) {
        .video-stats-grid {
            grid-template-columns: 1fr;
        }
        
        .related-video-thumbnail {
            height: 150px;
        }
    }
</style>

<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('public.videos.index')); ?>">Video</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e($video->title); ?></li>
            </ol>
        </nav>
    </div>
</section>

<!-- Video Player Section -->
<section class="video-player-section">
    <div class="container">
        <div class="video-player-container fade-in-up">
            <div class="video-player">
                <?php if($video->filename && file_exists(storage_path('app/public/videos/' . $video->filename))): ?>
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
                        <h3><?php echo e($video->title); ?></h3>
                        <p>Video Player akan ditampilkan di sini</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="video-controls">
                <div class="video-title-section">
                    <h1 class="video-title"><?php echo e($video->title); ?></h1>
                    
                    <div class="video-meta-info">
                        <div class="video-meta-item">
                            <i class="fas fa-calendar text-primary"></i>
                            <span><?php echo e($video->created_at->format('d M Y')); ?></span>
                        </div>
                        <div class="video-meta-item">
                            <i class="fas fa-eye text-success"></i>
                            <span><?php echo e(number_format($video->views)); ?> views</span>
                        </div>
                        <div class="video-meta-item">
                            <i class="fas fa-download text-warning"></i>
                            <span><?php echo e(number_format($video->downloads)); ?> downloads</span>
                        </div>
                        <div class="video-meta-item">
                            <i class="fas fa-hdd text-info"></i>
                            <span><?php echo e($video->formatted_file_size); ?></span>
                        </div>
                        <?php if($video->formatted_duration): ?>
                            <div class="video-meta-item">
                                <i class="fas fa-clock text-secondary"></i>
                                <span><?php echo e($video->formatted_duration); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="video-badges">
                        <span class="video-badge badge-category"><?php echo e($categories[$video->category] ?? $video->category); ?></span>
                        <?php if($video->is_featured): ?>
                            <span class="video-badge badge-featured">Video Unggulan</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="video-actions">
                    <a href="<?php echo e(route('public.videos.download', $video)); ?>" class="btn-video-action btn-download">
                        <i class="fas fa-download"></i>
                        Download Video
                    </a>
                    <button class="btn-video-action btn-share" onclick="shareVideo()">
                        <i class="fas fa-share-alt"></i>
                        Bagikan
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Info Section -->
<section class="video-info-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php if($video->description): ?>
                    <div class="info-card fade-in-left">
                        <h3><i class="fas fa-info-circle text-primary"></i> Deskripsi Video</h3>
                        <div class="video-description">
                            <?php echo nl2br(e($video->description)); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="col-lg-4">
                <div class="info-card fade-in-right">
                    <h3><i class="fas fa-chart-bar text-success"></i> Statistik Video</h3>
                    <div class="video-stats-grid">
                        <div class="stat-item">
                            <div class="stat-value"><?php echo e(number_format($video->views)); ?></div>
                            <div class="stat-label">Views</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?php echo e(number_format($video->downloads)); ?></div>
                            <div class="stat-label">Downloads</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?php echo e($video->formatted_file_size); ?></div>
                            <div class="stat-label">Ukuran File</div>
                        </div>
                        <?php if($video->formatted_duration): ?>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo e($video->formatted_duration); ?></div>
                                <div class="stat-label">Durasi</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="info-card fade-in-right" style="animation-delay: 0.2s;">
                    <h3><i class="fas fa-info text-info"></i> Informasi Video</h3>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <strong>Kategori:</strong>
                            <span class="badge bg-primary rounded-pill"><?php echo e($categories[$video->category] ?? $video->category); ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <strong>Format:</strong>
                            <span><?php echo e(strtoupper(pathinfo($video->filename, PATHINFO_EXTENSION))); ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <strong>Diupload:</strong>
                            <span><?php echo e($video->created_at->format('d M Y')); ?></span>
                        </div>
                        <?php if($video->uploader): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <strong>Oleh:</strong>
                                <span><?php echo e($video->uploader->name); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Videos Section -->
<?php if($relatedVideos->count() > 0): ?>
<section class="related-videos-section">
    <div class="container">
        <div class="section-title">
            <h2 class="fade-in-up">Video Terkait</h2>
            <p class="text-muted fade-in-up" style="animation-delay: 0.2s;">
                Video lainnya dalam kategori <?php echo e($categories[$video->category] ?? $video->category); ?>

            </p>
        </div>
        
        <div class="row g-4">
            <?php $__currentLoopData = $relatedVideos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $relatedVideo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="related-video-card fade-in-up" style="animation-delay: <?php echo e($index * 0.2); ?>s;">
                        <div class="related-video-thumbnail">
                            <?php if($relatedVideo->thumbnail_url): ?>
                                <img src="<?php echo e($relatedVideo->thumbnail_url); ?>" alt="<?php echo e($relatedVideo->title); ?>">
                            <?php else: ?>
                                <div class="related-video-placeholder">
                                    <i class="fas fa-video fa-2x mb-2"></i>
                                    <span class="fw-bold"><?php echo e(strtoupper($relatedVideo->category)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="related-video-info">
                            <h4 class="related-video-title"><?php echo e($relatedVideo->title); ?></h4>
                            <div class="related-video-meta">
                                <i class="fas fa-eye me-1"></i> <?php echo e(number_format($relatedVideo->views)); ?> views •
                                <i class="fas fa-calendar me-1"></i> <?php echo e($relatedVideo->created_at->format('d M Y')); ?>

                            </div>
                            <a href="<?php echo e(route('public.videos.show', $relatedVideo)); ?>" class="related-video-link">
                                <i class="fas fa-play me-1"></i> Tonton Video
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?php echo e(route('public.videos.index')); ?>" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-video me-2"></i>
                Lihat Semua Video
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Enhanced Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .scale-in');
    animatedElements.forEach(element => {
        observer.observe(element);
    });
    
    // Enhanced card hover effects
    const cards = document.querySelectorAll('.info-card, .related-video-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = this.style.transform + ' scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = this.style.transform.replace(' scale(1.02)', '');
        });
    });
    
    // Video play tracking
    const videoElement = document.querySelector('video');
    if (videoElement) {
        let hasPlayed = false;
        videoElement.addEventListener('play', function() {
            if (!hasPlayed) {
                hasPlayed = true;
                // Increment view count
                fetch('<?php echo e(route("public.videos.show", $video)); ?>/increment-view', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Content-Type': 'application/json',
                    },
                }).catch(error => console.log('Error incrementing view:', error));
            }
        });
    }
    
    // Download button click tracking
    document.querySelector('.btn-download')?.addEventListener('click', function() {
        // Add loading state
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Downloading...';
        
        setTimeout(() => {
            this.innerHTML = originalText;
        }, 3000);
    });
    
    console.log('Video detail page loaded successfully!');
});

// Share video function
function shareVideo() {
    if (navigator.share) {
        navigator.share({
            title: '<?php echo e($video->title); ?>',
            text: 'Tonton video ini: <?php echo e($video->title); ?>',
            url: window.location.href
        }).then(() => {
            console.log('Video shared successfully');
        }).catch((error) => {
            console.log('Error sharing video:', error);
            fallbackShare();
        });
    } else {
        fallbackShare();
    }
}

function fallbackShare() {
    // Fallback share options
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('<?php echo e($video->title); ?>');
    
    const shareOptions = [
        {
            name: 'WhatsApp',
            url: `https://wa.me/?text=${title}%20${url}`,
            icon: 'fab fa-whatsapp',
            color: '#25D366'
        },
        {
            name: 'Facebook',
            url: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
            icon: 'fab fa-facebook',
            color: '#1877F2'
        },
        {
            name: 'Twitter',
            url: `https://twitter.com/intent/tweet?text=${title}&url=${url}`,
            icon: 'fab fa-twitter',
            color: '#1DA1F2'
        },
        {
            name: 'Copy Link',
            action: 'copy',
            icon: 'fas fa-copy',
            color: '#6c757d'
        }
    ];
    
    let shareHtml = '<div class="share-options">';
    shareOptions.forEach(option => {
        if (option.action === 'copy') {
            shareHtml += `
                <button onclick="copyToClipboard('${window.location.href}')" 
                        class="btn btn-outline-secondary btn-sm me-2 mb-2">
                    <i class="${option.icon} me-1"></i> ${option.name}
                </button>
            `;
        } else {
            shareHtml += `
                <a href="${option.url}" target="_blank" 
                   class="btn btn-outline-secondary btn-sm me-2 mb-2">
                    <i class="${option.icon} me-1"></i> ${option.name}
                </a>
            `;
        }
    });
    shareHtml += '</div>';
    
    // Show modal or alert with share options
    const shareModal = document.createElement('div');
    shareModal.innerHTML = `
        <div class="modal fade" id="shareModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bagikan Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ${shareHtml}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(shareModal);
    const modal = new bootstrap.Modal(document.getElementById('shareModal'));
    modal.show();
    
    // Remove modal after hiding
    document.getElementById('shareModal').addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(shareModal);
    });
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Link berhasil disalin!');
    }).catch(() => {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Link berhasil disalin!');
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/public/videos/show.blade.php ENDPATH**/ ?>