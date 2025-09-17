<?php $__env->startSection('title', 'Berita Terbaru'); ?>

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
    
    /* Enhanced Hero Section matching home page */
    .hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        color: white;
        padding: 100px 0;
        min-height: 70vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(49, 130, 206, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(66, 153, 225, 0.3) 0%, transparent 50%);
        z-index: 1;
    }

    @keyframes float {
        0% { transform: translateX(-50px) translateY(-50px); }
        100% { transform: translateX(50px) translateY(50px); }
    }

    .blog-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .blog-card img {
        transition: transform 0.3s ease;
        height: 200px;
        object-fit: cover;
    }

    .blog-card:hover img {
        transform: scale(1.05);
    }

    .featured-card {
        background: linear-gradient(45deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 20px;
        overflow: hidden;
    }

    .featured-card img {
        height: 250px;
    }

    .badge-custom {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .sidebar-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .category-item {
        transition: all 0.3s ease;
        border-radius: 10px;
        padding: 1rem;
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .category-item:hover {
        background: var(--primary-color) !important;
        color: white !important;
        transform: translateX(5px);
    }

    .popular-item {
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        border-left: 4px solid var(--accent-color);
    }

    .popular-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }

    .pagination-custom .page-link {
        border-radius: 10px;
        margin: 0 2px;
        border: none;
        color: var(--primary-color);
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .pagination-custom .page-item.active .page-link {
        background: var(--primary-color);
        border-color: var(--primary-color);
        transform: scale(1.1);
    }

    .pagination-custom .page-link:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .btn-gradient {
        background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
        border: none;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .loading {
        display: none;
        text-align: center;
        padding: 2rem;
    }

    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--primary-color);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Blog Berita SMA Negeri 1 Balong</h1>
                <p class="lead mb-4">Informasi terkini seputar kegiatan, prestasi, dan perkembangan sekolah dalam format blog yang mudah dibaca.</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-dark fs-6">📰 Berita Terbaru</span>
                    <span class="badge bg-light text-dark fs-6">🏆 Prestasi</span>
                    <span class="badge bg-light text-dark fs-6">📚 Akademik</span>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-newspaper" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Blog Content -->
            <div class="col-lg-8">
                <!-- Search and Filter -->
                <div class="sidebar-card mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3"><i class="fas fa-search me-2 text-primary"></i>Cari Berita</h5>
                        <form method="GET" action="<?php echo e(route('news.index')); ?>">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="search" 
                                           placeholder="Kata kunci..." value="<?php echo e(request('search')); ?>">
                                </div>
                                <div class="col-md-4">
                                    <select name="category" class="form-select">
                                        <option value="">Semua Kategori</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>>
                                                <?php echo e(ucfirst($category)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p>Memuat berita...</p>
                </div>

                <!-- Blog Posts Container -->
                <div id="blog-container" class="fade-in">
                    <?php if($blogs->count() > 0): ?>
                        <!-- Featured Post (First Post) -->
                        <?php if($blogs->isNotEmpty()): ?>
                            <?php $featured = $blogs->first(); ?>
                            <article class="featured-card shadow mb-5 blog-card">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        <?php if($featured->featured_image): ?>
                                            <img src="<?php echo e(asset('storage/' . $featured->featured_image)); ?>" class="img-fluid h-100" alt="<?php echo e($featured->title); ?>">
                                        <?php else: ?>
                                            <img src="https://picsum.photos/400/250?random=1" class="img-fluid h-100" alt="Featured News">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body p-4">
                                            <span class="badge badge-custom bg-primary mb-3">✨ Utama</span>
                                            <h3 class="card-title fw-bold mb-3"><?php echo e($featured->title); ?></h3>
                                            <p class="card-text text-muted"><?php echo e(Str::limit(strip_tags($featured->content), 200)); ?></p>
                                            <div class="d-flex justify-content-between align-items-center mt-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i> 
                                                        <?php echo e($featured->published_at ? $featured->published_at->format('d M Y') : $featured->created_at->format('d M Y')); ?>

                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-user me-1"></i> 
                                                        <?php echo e($featured->author ?? $featured->user->name ?? 'Admin'); ?>

                                                    </small>
                                                </div>
                                                <a href="<?php echo e(route('news.detail', $featured->id)); ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endif; ?>

                        <!-- Blog Posts Grid -->
                        <div class="row g-4" id="posts-grid">
                            <?php $__currentLoopData = $blogs->skip(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <article class="blog-card shadow h-100">
                                        <?php if($blog->featured_image): ?>
                                            <img src="<?php echo e(asset('storage/' . $blog->featured_image)); ?>" class="card-img-top" alt="<?php echo e($blog->title); ?>">
                                        <?php else: ?>
                                            <img src="https://picsum.photos/300/200?random=<?php echo e($loop->index + 2); ?>" class="card-img-top" alt="<?php echo e($blog->title); ?>">
                                        <?php endif; ?>
                                        <div class="card-body p-4">
                                            <?php
                                                $categoryBadges = [
                                                    'berita' => '<span class="badge badge-custom bg-info mb-3">📰 Berita</span>',
                                                    'pengumuman' => '<span class="badge badge-custom bg-warning text-dark mb-3">📢 Pengumuman</span>',
                                                    'kegiatan' => '<span class="badge badge-custom bg-success mb-3">🎯 Kegiatan</span>',
                                                    'prestasi' => '<span class="badge badge-custom bg-danger mb-3">🏆 Prestasi</span>'
                                                ];
                                            ?>
                                            <?php echo $categoryBadges[$blog->category] ?? '<span class="badge badge-custom bg-secondary mb-3">📰 Berita</span>'; ?>

                                            <h5 class="card-title fw-bold mb-3"><?php echo e($blog->title); ?></h5>
                                            <p class="card-text text-muted"><?php echo e(Str::limit(strip_tags($blog->content), 120)); ?></p>
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <div>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-calendar me-1"></i> 
                                                        <?php echo e($blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y')); ?>

                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-user me-1"></i> 
                                                        <?php echo e($blog->author ?? $blog->user->name ?? 'Admin'); ?>

                                                    </small>
                                                </div>
                                                <a href="<?php echo e(route('news.detail', $blog->id)); ?>" class="btn btn-outline-primary btn-sm">Baca</a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Blog pagination" class="mt-5">
                            <?php echo e($blogs->links()); ?>

                        </nav>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-newspaper text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-muted">Belum Ada Berita</h4>
                            <p class="text-muted">
                                <?php if(request('search') || request('category')): ?>
                                    Tidak ada berita yang sesuai dengan pencarian Anda.
                                <?php else: ?>
                                    Belum ada berita yang dipublikasikan.
                                <?php endif; ?>
                            </p>
                            <?php if(request('search') || request('category')): ?>
                                <a href="<?php echo e(route('news.index')); ?>" class="btn btn-primary">Lihat Semua Berita</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories -->
                <?php if($categories->count() > 0): ?>
                    <div class="sidebar-card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Kategori Berita</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column" id="categories">
                                <a href="<?php echo e(route('news.index')); ?>" class="category-item bg-light text-dark <?php echo e(!request('category') ? 'bg-primary text-white' : ''); ?>">
                                    <span>Semua Berita</span>
                                    <span class="badge bg-primary"><?php echo e($blogs->total()); ?></span>
                                </a>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('news.index', ['category' => $category])); ?>" class="category-item bg-light text-dark <?php echo e(request('category') == $category ? 'bg-primary text-white' : ''); ?>">
                                        <span><?php echo e(ucfirst($category)); ?></span>
                                        <span class="badge bg-primary"><?php echo e(\App\Models\BlogPost::published()->where('category', $category)->count()); ?></span>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Latest Posts -->
                <?php if($latestBlogs->count() > 0): ?>
                    <div class="sidebar-card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Postingan Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div id="latest-posts">
                                <?php $__currentLoopData = $latestBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $latest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="popular-item">
                                        <h6 class="mb-2">
                                            <a href="<?php echo e(route('news.detail', $latest->id)); ?>" class="text-decoration-none text-dark">
                                                <?php echo e(Str::limit($latest->title, 60)); ?>

                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i> 
                                            <?php echo e($latest->published_at ? $latest->published_at->format('d M Y') : $latest->created_at->format('d M Y')); ?>

                                        </small>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Archive -->
                <div class="sidebar-card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-archive me-2"></i>Arsip Blog</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">Fitur arsip akan segera tersedia untuk memudahkan pencarian berita berdasarkan tanggal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/public/news/index.blade.php ENDPATH**/ ?>