<?php $__env->startSection('title', 'Slideshow Management'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .slideshow-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: var(--bg-primary);
        backdrop-filter: blur(15px);
        padding: 1.5rem 2rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .page-title {
        color: var(--text-primary);
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        transition: color 0.3s ease;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin: 0;
        transition: color 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Statistics Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 14px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        box-shadow: 0 2px 12px var(--shadow-color);
    }

    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .dark .stat-icon {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        transition: color 0.3s ease;
    }

    .stat-title {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    /* Filters */
    .filters-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        transition: color 0.3s ease;
    }

    .filter-input {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .filter-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .btn-filter {
        background: #10b981;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .btn-reset {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reset:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Table */
    .table-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .table thead th {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        font-weight: 600;
        padding: 1rem;
        border: none;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s ease;
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: var(--bg-secondary);
        transform: scale(1.001);
    }

    .slideshow-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .slideshow-description {
        color: var(--text-secondary);
        font-size: 0.8rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-active { 
        background: rgba(16, 185, 129, 0.1); 
        color: #059669; 
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .badge-inactive { 
        background: rgba(239, 68, 68, 0.1); 
        color: #dc2626; 
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .order-badge {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .action-dropdown {
        position: relative;
    }

    .dropdown-toggle {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dropdown-toggle:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
    }

    .dropdown-menu {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 8px 25px var(--shadow-color);
        overflow: hidden;
        position: absolute;
        right: 0;
        top: 100%;
        min-width: 150px;
        z-index: 10;
        display: none;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        color: var(--text-primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: var(--bg-secondary);
        color: var(--text-primary);
    }

    .dropdown-item.text-danger {
        color: #dc2626;
    }

    .dropdown-item.text-danger:hover {
        background: rgba(239, 68, 68, 0.05);
        color: #dc2626;
    }

    .dropdown-divider {
        height: 1px;
        background: var(--border-color);
        margin: 0;
        border: none;
    }

    /* Image preview */
    .slideshow-image {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .slideshow-image:hover {
        transform: scale(1.05);
    }

    .image-placeholder {
        width: 80px;
        height: 60px;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-tertiary);
        transition: all 0.3s ease;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
        background: var(--bg-primary);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--bg-secondary);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--text-tertiary);
        transition: all 0.3s ease;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .empty-message {
        margin-bottom: 2rem;
        line-height: 1.6;
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert-dismissible .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        opacity: 0.6;
        cursor: pointer;
        color: inherit;
    }

    .alert-dismissible .btn-close:hover {
        opacity: 1;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        padding: 2rem;
        background: var(--bg-primary);
        border-top: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    /* Modal */
    .modal-overlay {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .dark .modal-overlay {
        background: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .slideshow-container {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            padding: 1.25rem;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-row {
            grid-template-columns: 1fr;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            min-width: 800px;
        }
    }

    /* Animation */
    .table-container {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="slideshow-container">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Slideshow Management</h1>
            <p class="page-subtitle">Manage homepage slideshow content</p>
        </div>
        <a href="<?php echo e(route('admin.posts.slideshow.create')); ?>" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Slideshow
        </a>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($slideshows->total()); ?></div>
            <div class="stat-title">Total Slideshows</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($slideshows->where('status', 'active')->count()); ?></div>
            <div class="stat-title">Active</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($slideshows->where('status', 'inactive')->count()); ?></div>
            <div class="stat-title">Inactive</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($slideshows->where('created_at', '>=', now()->subDays(7))->count()); ?></div>
            <div class="stat-title">This Week</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" action="<?php echo e(route('admin.posts.slideshow')); ?>">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Search</label>
                    <input type="text" 
                           name="search" 
                           value="<?php echo e(request('search')); ?>" 
                           placeholder="Search slideshows..." 
                           class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Order</label>
                    <select name="order" class="filter-input">
                        <option value="">Default Order</option>
                        <option value="asc" <?php echo e(request('order') == 'asc' ? 'selected' : ''); ?>>Order: Low to High</option>
                        <option value="desc" <?php echo e(request('order') == 'desc' ? 'selected' : ''); ?>>Order: High to Low</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" class="btn-filter">Filter</button>
                        <a href="<?php echo e(route('admin.posts.slideshow')); ?>" class="btn-reset">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Table -->
    <div class="table-container">
        <?php if($slideshows->count() > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 35%">Slideshow</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 10%">Order</th>
                        <th style="width: 15%">Created</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $slideshows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slideshow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($slideshows->firstItem() + $index); ?></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <?php if($slideshow->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $slideshow->image)); ?>" 
                                         alt="<?php echo e($slideshow->title); ?>" 
                                         class="slideshow-image"
                                         onclick="showImageModal('<?php echo e(asset('storage/' . $slideshow->image)); ?>', '<?php echo e($slideshow->title); ?>')"
                                         style="cursor: pointer;">
                                <?php else: ?>
                                    <div class="image-placeholder">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="slideshow-title"><?php echo e(Str::limit($slideshow->title, 40)); ?></div>
                                    <?php if($slideshow->description): ?>
                                        <div class="slideshow-description"><?php echo e(Str::limit($slideshow->description, 60)); ?></div>
                                    <?php else: ?>
                                        <div class="slideshow-description" style="font-style: italic;">No description</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($slideshow->status); ?>">
                                <?php echo e(ucfirst($slideshow->status)); ?>

                            </span>
                        </td>
                        <td>
                            <span class="order-badge"><?php echo e($slideshow->order ?? 0); ?></span>
                        </td>
                        <td>
                            <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                <?php echo e($slideshow->created_at->format('M d, Y')); ?>

                            </div>
                            <div style="font-size: 0.75rem; color: var(--text-tertiary);">
                                <?php echo e($slideshow->created_at->format('H:i')); ?>

                            </div>
                        </td>
                        <td>
                            <div class="action-dropdown">
                                <button type="button" class="dropdown-toggle" onclick="toggleDropdown(<?php echo e($slideshow->id); ?>)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                </button>
                                <div class="dropdown-menu" id="dropdown-<?php echo e($slideshow->id); ?>">
                                    <?php if($slideshow->image): ?>
                                        <button class="dropdown-item" onclick="showImageModal('<?php echo e(asset('storage/' . $slideshow->image)); ?>', '<?php echo e($slideshow->title); ?>')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Preview
                                        </button>
                                    <?php endif; ?>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.posts.slideshow.edit', $slideshow->id)); ?>">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <hr class="dropdown-divider">
                                    <form action="<?php echo e(route('admin.posts.slideshow.destroy', $slideshow->id)); ?>" 
                                          method="POST" class="delete-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dropdown-item text-danger">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php if($slideshows->hasPages()): ?>
                <div class="pagination-container">
                    <?php echo e($slideshows->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Slideshows Found</h3>
                <p class="empty-message">
                    <?php if(request()->hasAny(['search', 'status', 'order'])): ?>
                        No slideshows match your current filters. Try adjusting your search criteria.
                    <?php else: ?>
                        Start creating slideshows to showcase content on your homepage.
                    <?php endif; ?>
                </p>
                <?php if(!request()->hasAny(['search', 'status', 'order'])): ?>
                    <a href="<?php echo e(route('admin.posts.slideshow.create')); ?>" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create First Slideshow
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('admin.posts.slideshow')); ?>" class="btn-reset">
                        Clear Filters
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 modal-overlay overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md modal-content">
        <div class="mt-3">
            <div class="flex items-center justify-between pb-3">
                <h3 class="text-lg font-medium" id="modalTitle">Preview Image</h3>
                <button type="button" onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="text-center">
                <img id="modalImage" class="max-w-full h-auto rounded-lg shadow-md" src="" alt="">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this slideshow? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.action-dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
});

// Dropdown functions
function toggleDropdown(id) {
    const dropdown = document.getElementById('dropdown-' + id);
    const isShown = dropdown.classList.contains('show');
    
    // Close all dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
        menu.classList.remove('show');
    });
    
    // Toggle current dropdown
    if (!isShown) {
        dropdown.classList.add('show');
    }
}

// Image Modal Functions
function showImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const imageModal = document.getElementById('imageModal');
    if (event.target === imageModal) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/posts/slideshow/index.blade.php ENDPATH**/ ?>