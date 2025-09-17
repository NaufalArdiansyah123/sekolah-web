<?php $__env->startSection('content'); ?>
    <style>
        /* Enhanced Admin Styles */
        .admin-container {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        i,
        svg {
            width: 18px;
            height: 18px;
            font-size: 16px;
            vertical-align: middle;
        }

        .dark .admin-container {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #10b981, #f59e0b, #ef4444);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .filter-section {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .agenda-table {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .table {
            margin: 0;
            background: transparent;
        }

        .table th {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            font-weight: 600;
            padding: 1rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: var(--bg-secondary);
        }

        .agenda-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .agenda-date {
            font-size: 0.875rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .agenda-location {
            font-size: 0.875rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-draft {
            background: rgba(156, 163, 175, 0.1);
            color: #6b7280;
        }

        .status-published {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-archived {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .btn {
            padding: 0.5rem 1rem;
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

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }

        .page-link {
            border: none;
            border-radius: 8px;
            margin: 0 0.25rem;
            padding: 0.5rem 0.75rem;
            color: var(--text-primary);
            background: var(--bg-secondary);
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-1px);
        }

        .page-item.active .page-link {
            background: var(--accent-color);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-container {
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Agenda Kegiatan</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola agenda dan kegiatan sekolah</p>
            </div>
            <a href="<?php echo e(route('admin.posts.agenda.create')); ?>" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Agenda
            </a>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1);">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div class="stat-number"><?php echo e($agendas->total()); ?></div>
                <div class="stat-label">Total Agenda</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1);">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-number"><?php echo e($agendas->where('status', 'published')->count()); ?></div>
                <div class="stat-label">Agenda Dipublikasi</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1);">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="stat-number"><?php echo e($agendas->where('event_date', '>=', now())->count()); ?></div>
                <div class="stat-label">Agenda Mendatang</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(139, 92, 246, 0.1);">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="stat-number"><?php echo e($agendas->whereNotNull('location')->count()); ?></div>
                <div class="stat-label">Dengan Lokasi</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filter Agenda</h3>
            <form method="GET" action="<?php echo e(route('admin.posts.agenda')); ?>">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">Cari Agenda</label>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                            placeholder="Cari judul atau lokasi..." class="form-input">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="">Semua Status</option>
                            <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                            <option value="published" <?php echo e(request('status') == 'published' ? 'selected' : ''); ?>>Dipublikasi</option>
                            <option value="archived" <?php echo e(request('status') == 'archived' ? 'selected' : ''); ?>>Diarsipkan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Periode</label>
                        <select name="period" class="form-input">
                            <option value="">Semua Periode</option>
                            <option value="upcoming" <?php echo e(request('period') == 'upcoming' ? 'selected' : ''); ?>>Mendatang
                            </option>
                            <option value="past" <?php echo e(request('period') == 'past' ? 'selected' : ''); ?>>Sudah Lewat</option>
                            <option value="today" <?php echo e(request('period') == 'today' ? 'selected' : ''); ?>>Hari Ini</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Agenda Table -->
        <div class="agenda-table">
            <?php if($agendas->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Agenda</th>
                                <th>Tanggal & Waktu</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="agenda-title"><?php echo e($agenda->title); ?></div>
                                        <?php if($agenda->content): ?>
                                            <div class="text-sm text-gray-500 mt-1">
                                                <?php echo e(Str::limit(strip_tags($agenda->content), 100)); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="agenda-date">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <?php echo e($agenda->event_date ? $agenda->event_date->format('d M Y') : '-'); ?>

                                        </div>
                                        <?php if($agenda->event_date): ?>
                                            <div class="text-xs text-gray-400 mt-1">
                                                <?php echo e($agenda->event_date->format('H:i')); ?> WIB
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($agenda->location): ?>
                                            <div class="agenda-location">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <?php echo e($agenda->location); ?>

                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo e($agenda->status); ?>">
                                            <?php if($agenda->status == 'draft'): ?>
                                                Draft
                                            <?php elseif($agenda->status == 'published'): ?>
                                                Dipublikasi
                                            <?php elseif($agenda->status == 'archived'): ?>
                                                Diarsipkan
                                            <?php else: ?>
                                                <?php echo e(ucfirst($agenda->status)); ?>

                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <?php echo e($agenda->created_at->format('d M Y')); ?>

                                        </div>
                                        <div class="text-xs text-gray-400">
                                            <?php echo e($agenda->user->name ?? 'Admin'); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('admin.posts.agenda.show', $agenda->id)); ?>"
                                                class="btn btn-sm btn-secondary">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Lihat
                                            </a>
                                            <a href="<?php echo e(route('admin.posts.agenda.edit', $agenda->id)); ?>"
                                                class="btn btn-sm btn-warning">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="<?php echo e(route('admin.posts.agenda.destroy', $agenda->id)); ?>"
                                                class="inline"
                                                onsubmit="return confirmDelete('Apakah Anda yakin ingin menghapus agenda ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <svg class="empty-state-icon mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum ada agenda</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Mulai dengan menambahkan agenda kegiatan sekolah</p>
                    <a href="<?php echo e(route('admin.posts.agenda.create')); ?>" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Agenda Pertama
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if($agendas->hasPages()): ?>
            <div class="d-flex justify-content-center">
                <?php echo e($agendas->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <script>
        function confirmDelete(message) {
            return confirm(message);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/posts/agenda/index.blade.php ENDPATH**/ ?>