<?php $__env->startSection('title', 'Announcement Management'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .announcement-container {
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
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        text-align: center;
        width: 100%;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .btn-primary {
        background: white;
        color: #059669;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #059669;
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
        background: linear-gradient(135deg, #6ee7b7, #10b981);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .dark .stat-icon {
        background: linear-gradient(135deg, #059669, #10b981);
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
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
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
        overflow: visible;
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

    .announcement-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .announcement-excerpt {
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

    .badge-akademik { background: rgba(59, 130, 246, 0.1); color: #1d4ed8; border: 1px solid rgba(59, 130, 246, 0.2); }
    .badge-kegiatan { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-administrasi { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }

    .badge-tinggi { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); }
    .badge-sedang { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-normal { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }

    .badge-published { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-draft { background: rgba(107, 114, 128, 0.1); color: #374151; border: 1px solid rgba(107, 114, 128, 0.2); }
    .badge-archived { background: rgba(75, 85, 99, 0.1); color: #1f2937; border: 1px solid rgba(75, 85, 99, 0.2); }

    .views-badge {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
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
        z-index: 9999;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .announcement-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
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
    /* Fix dropdown z-index issues */
    .table tbody tr {
        position: relative;
        z-index: 1;
    }

    .table tbody tr:hover {
        z-index: 2;
    }

    .action-dropdown {
        position: relative;
        z-index: 3;
    }

    .dropdown-menu {
        position: absolute !important;
        z-index: 99999 !important;
        top: 100%;
        right: 0;
        left: auto;
        margin-top: 0.25rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.1) !important;
        border: 2px solid var(--border-color) !important;
        background: var(--bg-primary) !important;
        display: none;
    }

    .dropdown-menu.show {
        display: block !important;
        animation: dropdownFadeIn 0.15s ease-out;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="announcement-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                Announcement Management
            </h1>
            <p class="page-subtitle">Manage school announcements and notifications</p>
            <a href="<?php echo e(route('teacher.posts.announcement.create')); ?>" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Announcement
            </a>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($announcements->total()); ?></div>
            <div class="stat-title">Total Announcements</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($announcements->where('status', 'published')->count()); ?></div>
            <div class="stat-title">Published</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($announcements->where('status', 'draft')->count()); ?></div>
            <div class="stat-title">Drafts</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($announcements->sum('views_count') ?? 0); ?></div>
            <div class="stat-title">Total Views</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" action="<?php echo e(route('teacher.posts.announcement')); ?>">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Search</label>
                    <input type="text" 
                           name="search" 
                           value="<?php echo e(request('search')); ?>" 
                           placeholder="Search announcements..." 
                           class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Category</label>
                    <select name="category" class="filter-input">
                        <option value="">All Categories</option>
                        <option value="akademik" <?php echo e(request('category') == 'akademik' ? 'selected' : ''); ?>>Academic</option>
                        <option value="kegiatan" <?php echo e(request('category') == 'kegiatan' ? 'selected' : ''); ?>>Activities</option>
                        <option value="administrasi" <?php echo e(request('category') == 'administrasi' ? 'selected' : ''); ?>>Administration</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="published" <?php echo e(request('status') == 'published' ? 'selected' : ''); ?>>Published</option>
                        <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                        <option value="archived" <?php echo e(request('status') == 'archived' ? 'selected' : ''); ?>>Archived</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Priority</label>
                    <select name="priority" class="filter-input">
                        <option value="">All Priorities</option>
                        <option value="tinggi" <?php echo e(request('priority') == 'tinggi' ? 'selected' : ''); ?>>High</option>
                        <option value="sedang" <?php echo e(request('priority') == 'sedang' ? 'selected' : ''); ?>>Medium</option>
                        <option value="normal" <?php echo e(request('priority') == 'normal' ? 'selected' : ''); ?>>Normal</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" class="btn-filter">Filter</button>
                        <a href="<?php echo e(route('teacher.posts.announcement')); ?>" class="btn-reset">Reset</a>
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
        <?php if($announcements->count() > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 30%">Title & Content</th>
                        <th style="width: 12%">Category</th>
                        <th style="width: 10%">Priority</th>
                        <th style="width: 12%">Author</th>
                        <th style="width: 8%">Status</th>
                        <th style="width: 8%">Views</th>
                        <th style="width: 10%">Date</th>
                        <th style="width: 5%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($announcements->firstItem() + $index); ?></td>
                        <td>
                            <div class="announcement-title"><?php echo e(Str::limit($announcement->title, 40)); ?></div>
                            <div class="announcement-excerpt"><?php echo e(Str::limit(strip_tags($announcement->content), 60)); ?></div>
                            <?php if($announcement->featured_image): ?>
                                <small style="color: #059669; font-size: 0.75rem;">
                                    <svg class="w-3 h-3" style="display: inline;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Has image
                                </small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($announcement->category); ?>">
                                <?php echo e(ucfirst($announcement->category)); ?>

                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($announcement->priority); ?>">
                                <?php echo e(ucfirst($announcement->priority)); ?>

                            </span>
                        </td>
                        <td><?php echo e($announcement->author); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($announcement->status); ?>">
                                <?php echo e(ucfirst($announcement->status)); ?>

                            </span>
                        </td>
                        <td>
                            <span class="views-badge"><?php echo e($announcement->views_count ?? 0); ?></span>
                        </td>
                        <td>
                            <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                <?php echo e($announcement->published_at ? $announcement->published_at->format('M d, Y') : $announcement->created_at->format('M d, Y')); ?>

                            </div>
                            <div style="font-size: 0.75rem; color: var(--text-tertiary);">
                                <?php echo e($announcement->published_at ? $announcement->published_at->format('H:i') : $announcement->created_at->format('H:i')); ?>

                            </div>
                        </td>
                        <td>
                             <div class="action-dropdown">
                                <button type="button" class="dropdown-toggle" onclick="toggleDropdown(<?php echo e($announcement->id); ?>)" style="background: #e5e7eb; border: 1px solid #d1d5db; padding: 8px; border-radius: 6px;">
                                    ⋮
                                </button>
                                <div class="dropdown-menu" id="dropdown-<?php echo e($announcement->id); ?>" style="background: white; border: 2px solid #000; min-width: 150px; padding: 8px;">
                                    <a class="dropdown-item" href="<?php echo e(route('teacher.posts.announcement.show', $announcement->id)); ?>" style="display: block; padding: 8px; color: #000; text-decoration: none;">
                                        👁️ View
                                    </a>
                                    <a class="dropdown-item" href="<?php echo e(route('teacher.posts.announcement.edit', $announcement->id)); ?>" style="display: block; padding: 8px; color: #000; text-decoration: none;">
                                        ✏️ Edit
                                    </a>
                                    <hr class="dropdown-divider" style="margin: 8px 0; border: 1px solid #ccc;">
                                    <form action="<?php echo e(route('teacher.posts.announcement.destroy', $announcement->id)); ?>" 
                                          method="POST" class="delete-form" style="margin: 0;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dropdown-item text-danger" style="display: block; width: 100%; padding: 8px; background: none; border: none; text-align: left; color: #dc2626;">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <?php if($announcements->hasPages()): ?>
                <div class="pagination-container">
                    <?php echo e($announcements->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Announcements Found</h3>
                <p class="empty-message">
                    <?php if(request()->hasAny(['search', 'category', 'status', 'priority'])): ?>
                        No announcements match your current filters. Try adjusting your search criteria.
                    <?php else: ?>
                        Start creating announcements to keep your school community informed.
                    <?php endif; ?>
                </p>
                <?php if(!request()->hasAny(['search', 'category', 'status', 'priority'])): ?>
                    <a href="<?php echo e(route('teacher.posts.announcement.create')); ?>" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create First Announcement
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('teacher.posts.announcement')); ?>" class="btn-reset">
                        Clear Filters
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this announcement? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Toggle status
    document.querySelectorAll('.toggle-status').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const currentStatus = this.dataset.currentStatus;
            const newStatus = currentStatus === 'published' ? 'draft' : 'published';
            
            if (confirm(`Are you sure you want to change status to ${newStatus}?`)) {
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = `
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Updating...
                `;
                this.disabled = true;

                fetch(`/teacher/announcements/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update status: ' + (data.message || 'Unknown error'));
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    alert('An error occurred: ' + error);
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
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

    // Add CSS for spinner animation
    const style = document.createElement('style');
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
});

// Dropdown functions
function toggleDropdown(id) {
    console.log('Toggle dropdown called for ID:', id);
    const dropdown = document.getElementById('dropdown-' + id);
    const button = dropdown ? dropdown.previousElementSibling : null;
    
    if (!dropdown) {
        console.error('Dropdown not found for ID:', id);
        return;
    }
    
    if (!button) {
        console.error('Button not found for dropdown ID:', id);
        return;
    }
    
    const isShown = dropdown.classList.contains('show');
    console.log('Dropdown is currently shown:', isShown);
    
    // Close all dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
        menu.classList.remove('show');
        menu.style.display = 'none';
    });
    
    // Toggle current dropdown
    if (!isShown) {
        console.log('Showing dropdown');
        
        // Reset position styles
        dropdown.style.position = 'absolute';
        dropdown.style.top = '100%';
        dropdown.style.right = '0';
        dropdown.style.left = 'auto';
        dropdown.style.display = 'block';
        dropdown.classList.add('show');
        
        console.log('Dropdown should now be visible');
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teacher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/teacher/posts/announcement/index.blade.php ENDPATH**/ ?>