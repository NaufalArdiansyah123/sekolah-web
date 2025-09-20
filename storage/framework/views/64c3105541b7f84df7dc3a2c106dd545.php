<?php $__env->startSection('title', 'Manajemen Siswa'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .students-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .content-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        max-width: 1800px;
        padding: 2rem;
        width: 95%;
    }
    
    .header-section {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .header-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #4f46e5, #7c3aed);
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        color: #6b7280;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .filters-section {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(79, 70, 229, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .filters-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #4f46e5, #7c3aed, #ec4899, #f59e0b);
    }
    
    .filters-section::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(79, 70, 229, 0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    
    .filters-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }
    
    .filters-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .filters-title i {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    
    .filters-subtitle {
        color: #6b7280;
        font-size: 0.875rem;
        margin: 0;
        margin-left: auto;
        font-weight: 500;
    }
    
    .filters-form {
        position: relative;
        z-index: 2;
    }
    
    .filter-group {
        margin-bottom: 1.5rem;
    }
    
    .filter-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-label i {
        color: #4f46e5;
        font-size: 0.875rem;
    }
    
    .form-select, .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
        transform: translateY(-1px);
    }
    
    .form-select:hover, .form-control:hover {
        border-color: #9ca3af;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        transform: translateY(-1px);
    }
    
    .filter-actions {
        display: flex;
        gap: 0.75rem;
        align-items: end;
    }
    
    .btn-filter {
        height: 48px;
        min-width: 120px;
        padding: 0 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 2px solid transparent;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .btn-filter:active {
        transform: translateY(0);
    }
    
    .btn-search {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    
    .btn-search:hover {
        background: linear-gradient(135deg, #4338ca, #6d28d9);
        color: white;
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
    }
    
    .btn-reset {
        background: white;
        color: #6b7280;
        border-color: #d1d5db;
    }
    
    .btn-reset:hover {
        background: #f9fafb;
        color: #374151;
        border-color: #9ca3af;
    }
    

    
    .filter-stats {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.875rem;
    }
    
    .filter-stats i {
        color: #2563eb;
        font-size: 1rem;
    }
    
    .filter-stats-text {
        color: #1e40af;
        font-weight: 500;
    }
    
    .clear-filters {
        color: #dc2626;
        text-decoration: none;
        font-weight: 500;
        margin-left: auto;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .clear-filters:hover {
        background: #fee2e2;
        color: #b91c1c;
        text-decoration: none;
    }
    
    /* Additional Filter Enhancements */
    .filter-group {
        position: relative;
    }
    
    .filter-group::before {
        content: '';
        position: absolute;
        top: 0;
        left: -10px;
        width: 3px;
        height: 100%;
        background: linear-gradient(180deg, #4f46e5, #7c3aed);
        border-radius: 2px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .filter-group:focus-within::before {
        opacity: 1;
    }
    
    .form-select option {
        padding: 0.5rem;
        background: white;
        color: #374151;
    }
    
    .form-select option:checked {
        background: #4f46e5;
        color: white;
    }
    
    .btn-filter {
        position: relative;
        overflow: hidden;
    }
    
    .btn-filter::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: width 0.3s ease, height 0.3s ease;
        transform: translate(-50%, -50%);
        z-index: 1;
    }
    
    .btn-filter:hover::before {
        width: 100%;
        height: 100%;
    }
    
    .btn-filter i,
    .btn-filter span {
        position: relative;
        z-index: 2;
    }
    
    .filter-stats {
        animation: slideInUp 0.5s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .filters-section:hover::after {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }
    
    /* Tooltip for filter labels */
    .filter-label {
        position: relative;
        cursor: help;
    }
    
    .filter-label:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #1f2937;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        white-space: nowrap;
        z-index: 1000;
        opacity: 0;
        animation: fadeInTooltip 0.3s ease forwards;
    }
    
    @keyframes fadeInTooltip {
        to {
            opacity: 1;
        }
    }
    
    .students-table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .students-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.75rem;
    }
    
    .students-table thead {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
    }
    
    .students-table th {
        padding: 0.75rem 0.75rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border: none;
    }
    
    .students-table td {
        padding: 0.625rem 0.75rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    
    .birth-info {
        white-space: nowrap;
        min-width: 150px;
        padding: 0.25rem;
    }
    
    .birth-date {
        font-size: 0.7rem;
        font-weight: 500;
        color: #1f2937;
        line-height: 1.1;
    }
    
    .birth-place {
        font-size: 0.6rem;
        color: #6b7280;
        margin-top: 1px;
        line-height: 1.0;
        max-width: 140px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .students-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .students-table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .student-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }
    
    .student-initials {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
    }
    
    .student-name {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.125rem;
        font-size: 0.8rem;
        line-height: 1.2;
    }
    
    .student-email {
        color: #6b7280;
        font-size: 0.65rem;
        line-height: 1.1;
    }
    
    .student-class {
        display: inline-block;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        padding: 0.125rem 0.5rem;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 600;
        line-height: 1.2;
    }
    
    .status-badge {
        padding: 0.125rem 0.5rem;
        border-radius: 12px;
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        line-height: 1.2;
    }
    
    .status-active {
        background: #dcfce7;
        color: #166534;
    }
    
    .status-inactive {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-graduated {
        background: #e5e7eb;
        color: #374151;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.25rem;
    }
    
    .btn-action {
        width: 28px;
        height: 28px;
        border: none;
        border-radius: 5px;
        font-size: 0.65rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .btn-view {
        background: #dbeafe;
        color: #1d4ed8;
    }
    
    .btn-view:hover {
        background: #bfdbfe;
        color: #1e40af;
        transform: scale(1.1);
    }
    
    .btn-edit {
        background: #fef3c7;
        color: #d97706;
    }
    
    .btn-edit:hover {
        background: #fde68a;
        color: #b45309;
        transform: scale(1.1);
    }
    
    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }
    
    .btn-delete:hover {
        background: #fecaca;
        color: #b91c1c;
        transform: scale(1.1);
    }
    
    .btn-activate {
        background: #dcfce7;
        color: #166534;
    }
    
    .btn-activate:hover {
        background: #bbf7d0;
        color: #14532d;
        transform: scale(1.1);
    }
    
    .btn-deactivate {
        background: #fef3c7;
        color: #92400e;
    }
    
    .btn-deactivate:hover {
        background: #fde68a;
        color: #78350f;
        transform: scale(1.1);
    }
    
    .add-student-btn {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        border: 3px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        font-size: 1.75rem;
        box-shadow: 0 12px 35px rgba(79, 70, 229, 0.4);
        transition: all 0.3s ease;
        z-index: 1000;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        overflow: visible;
    }
    
    .add-student-btn i {
        font-size: 2rem;
        font-weight: 900;
        line-height: 1;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
        transform: translateZ(0);
    }
    
    .add-student-btn:hover i {
        transform: scale(1.1) translateZ(0);
        text-shadow: 0 3px 6px rgba(0, 0, 0, 0.4);
    }
    
    /* Fallback plus icon if FontAwesome fails */
    .add-student-btn .fa-plus::before {
        content: "+";
        font-family: Arial, sans-serif;
        font-weight: bold;
        font-size: 2.2rem;
        line-height: 1;
    }
    

    
    .add-student-btn:hover {
        transform: scale(1.15);
        box-shadow: 0 20px 50px rgba(79, 70, 229, 0.5);
        color: white;
        background: linear-gradient(135deg, #5b21b6, #4f46e5);
    }
    
    .add-student-btn:active {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
    }
    
    .add-student-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }
    
    .add-student-btn:hover::before {
        opacity: 1;
    }
    

    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .table-info {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: between;
        align-items: center;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .bulk-actions {
        display: none;
        background: #eff6ff;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        align-items: center;
        gap: 1rem;
    }
    
    .bulk-actions.show {
        display: flex;
    }
    
    .select-all-checkbox {
        margin-right: 0.5rem;
    }
    
    .student-checkbox {
        margin-right: 0.5rem;
    }
    
    @media (max-width: 1200px) {
        .filters-section {
            padding: 1.75rem;
        }
        
        .filter-actions {
            flex-wrap: wrap;
        }
        
        .students-table {
            font-size: 0.7rem;
        }
        
        .students-table th,
        .students-table td {
            padding: 0.5rem 0.5rem;
        }
        
        .birth-date {
            font-size: 0.65rem;
        }
        
        .birth-place {
            font-size: 0.55rem;
            max-width: 120px;
        }
        
        .student-name {
            font-size: 0.75rem;
        }
        
        .student-email {
            font-size: 0.6rem;
        }
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        
        .content-wrapper {
            margin: 0 1rem;
            padding: 1rem;
        }
        
        .filters-section {
            padding: 1.5rem;
        }
        
        .filters-header {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
        
        .filters-subtitle {
            margin-left: 0;
        }
        
        .filters-title {
            font-size: 1.1rem;
        }
        
        .filters-title i {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
        
        .filter-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn-filter {
            width: 100%;
            justify-content: center;
        }
        
        .filter-stats {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }
        
        .clear-filters {
            margin-left: 0;
            align-self: center;
        }
        
        .students-table-container {
            overflow-x: auto;
        }
        
        .students-table {
            min-width: 1000px;
        }
        
        .birth-info {
            min-width: 130px;
        }
        
        .birth-date {
            font-size: 0.7rem;
        }
        
        .birth-place {
            font-size: 0.6rem;
            max-width: 110px;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .stat-label {
            font-size: 0.7rem;
        }
    }
    
    @media (max-width: 576px) {
        .filters-section {
            padding: 1rem;
        }
        
        .filters-title {
            font-size: 1rem;
            gap: 0.5rem;
        }
        
        .filters-title i {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }
        
        .filter-label {
            font-size: 0.8rem;
        }
        
        .form-select, .form-control {
            padding: 0.6rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .btn-filter {
            height: 42px;
            min-width: 100px;
            padding: 0 1.25rem;
            font-size: 0.8rem;
        }
        
        .filter-stats {
            padding: 0.75rem;
            font-size: 0.8rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="students-container">
    <div class="content-wrapper">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2" style="font-size: 2.5rem; font-weight: 800;">
                        <i class="fas fa-graduation-cap me-3"></i>Manajemen Siswa
                    </h1>
                    <p class="mb-0" style="font-size: 1.1rem; opacity: 0.9;">
                        Kelola data siswa dengan mudah dan efisien
                    </p>
                </div>
                <div>
                    <a href="<?php echo e(route('admin.students.create')); ?>" class="btn btn-light btn-lg">
                        <i class="fas fa-plus me-2"></i>Tambah Siswa
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['total']); ?></div>
                <div class="stat-label">Total Siswa</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['grade_10']); ?></div>
                <div class="stat-label">Kelas 10</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['grade_11']); ?></div>
                <div class="stat-label">Kelas 11</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['grade_12']); ?></div>
                <div class="stat-label">Kelas 12</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['tkj']); ?></div>
                <div class="stat-label">TKJ</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['rpl']); ?></div>
                <div class="stat-label">RPL</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['dkv']); ?></div>
                <div class="stat-label">DKV</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['active']); ?></div>
                <div class="stat-label">Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['inactive']); ?></div>
                <div class="stat-label">Nonaktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo e($stats['graduated']); ?></div>
                <div class="stat-label">Lulus</div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <!-- Filter Header -->
            <div class="filters-header">
                <h3 class="filters-title">
                    <i class="fas fa-filter"></i>
                    Filter & Pencarian Siswa
                </h3>
                <p class="filters-subtitle">Gunakan filter untuk menemukan siswa dengan mudah</p>
            </div>
            
            <!-- Filter Form -->
            <form method="GET" class="filters-form">
                <div class="row g-3">
                    <div class="col-md-2 filter-group">
                        <label class="filter-label" data-tooltip="Pilih tingkat kelas (10, 11, atau 12)">
                            <i class="fas fa-layer-group"></i>
                            Tingkat
                        </label>
                        <select name="grade" class="form-select" id="gradeFilter">
                            <option value="">Semua Tingkat</option>
                            <option value="10" <?php echo e(request('grade') == '10' ? 'selected' : ''); ?>>Kelas 10</option>
                            <option value="11" <?php echo e(request('grade') == '11' ? 'selected' : ''); ?>>Kelas 11</option>
                            <option value="12" <?php echo e(request('grade') == '12' ? 'selected' : ''); ?>>Kelas 12</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 filter-group">
                        <label class="filter-label" data-tooltip="Pilih jurusan SMK">
                            <i class="fas fa-graduation-cap"></i>
                            Jurusan
                        </label>
                        <select name="major" class="form-select" id="majorFilter">
                            <option value="">Semua Jurusan</option>
                            <option value="TKJ" <?php echo e(request('major') == 'TKJ' ? 'selected' : ''); ?>>TKJ (Teknik Komputer Jaringan)</option>
                            <option value="RPL" <?php echo e(request('major') == 'RPL' ? 'selected' : ''); ?>>RPL (Rekayasa Perangkat Lunak)</option>
                            <option value="DKV" <?php echo e(request('major') == 'DKV' ? 'selected' : ''); ?>>DKV (Desain Komunikasi Visual)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 filter-group">
                        <label class="filter-label" data-tooltip="Pilih kelas spesifik">
                            <i class="fas fa-users"></i>
                            Kelas Spesifik
                        </label>
                        <select name="class" class="form-select" id="classFilter">
                            <option value="">Semua Kelas</option>
                            <?php $__currentLoopData = $allClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($classOption); ?>" <?php echo e(request('class') == $classOption ? 'selected' : ''); ?>>
                                    <?php echo e($classOption); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="col-md-2 filter-group">
                        <label class="filter-label" data-tooltip="Filter siswa berdasarkan status aktif, tidak aktif, atau lulus">
                            <i class="fas fa-toggle-on"></i>
                            Status Siswa
                        </label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Aktif</option>
                            <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Tidak Aktif</option>
                            <option value="graduated" <?php echo e(request('status') == 'graduated' ? 'selected' : ''); ?>>Lulus</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 filter-group">
                        <label class="filter-label" data-tooltip="Cari siswa berdasarkan nama, NIS, NISN, kelas, email, telepon, atau nama orang tua">
                            <i class="fas fa-search"></i>
                            Pencarian Global
                        </label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari nama, NIS, NISN, kelas, email, telepon, atau nama orang tua..." 
                               value="<?php echo e(request('search')); ?>">
                    </div>
                    
                    <div class="col-md-4 filter-group">
                        <label class="filter-label" data-tooltip="Gunakan tombol untuk mencari atau reset filter">
                            <i class="fas fa-cogs"></i>
                            Aksi Filter
                        </label>
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-filter btn-search" title="Terapkan Filter">
                                <i class="fas fa-search"></i>
                                <span class="d-none d-md-inline">Cari</span>
                            </button>
                            <a href="<?php echo e(route('admin.students.index')); ?>" class="btn btn-filter btn-reset" title="Reset Filter">
                                <i class="fas fa-undo"></i>
                                <span class="d-none d-md-inline">Reset</span>
                            </a>

                        </div>
                    </div>
                </div>
                
                <!-- Filter Stats -->
                <?php if(request()->hasAny(['grade', 'major', 'class', 'status', 'search'])): ?>
                    <div class="filter-stats">
                        <i class="fas fa-info-circle"></i>
                        <span class="filter-stats-text">
                            Filter aktif: 
                            <?php if(request('grade')): ?>
                                <strong>Tingkat <?php echo e(request('grade')); ?></strong>
                            <?php endif; ?>
                            <?php if(request('major')): ?>
                                <strong>Jurusan <?php echo e(request('major')); ?></strong>
                            <?php endif; ?>
                            <?php if(request('class')): ?>
                                <strong>Kelas <?php echo e(request('class')); ?></strong>
                            <?php endif; ?>
                            <?php if(request('status')): ?>
                                <strong>Status: <?php echo e(ucfirst(request('status'))); ?></strong>
                            <?php endif; ?>
                            <?php if(request('search')): ?>
                                <strong>Pencarian: "<?php echo e(request('search')); ?>"</strong>
                            <?php endif; ?>
                            - Menampilkan <?php echo e($students->total()); ?> dari <?php echo e($stats['total']); ?> siswa
                        </span>
                        <a href="<?php echo e(route('admin.students.index')); ?>" class="clear-filters">
                            <i class="fas fa-times"></i> Hapus Semua Filter
                        </a>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Success/Error Messages -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Students Table -->
        <?php if($students->count() > 0): ?>
            <div class="students-table-container">
                <!-- Table Info -->
                <div class="table-info">
                    <div>
                        <strong><?php echo e($students->total()); ?></strong> siswa ditemukan
                        <?php if(request()->hasAny(['grade', 'major', 'class', 'status', 'search'])): ?>
                            dari <strong><?php echo e($stats['total']); ?></strong> total siswa
                        <?php endif; ?>
                        <?php if(request('class')): ?>
                            <span class="text-muted">- Kelas <?php echo e(request('class')); ?></span>
                        <?php elseif(request('major') && request('grade')): ?>
                            <span class="text-muted">- <?php echo e(request('grade')); ?> <?php echo e(request('major')); ?></span>
                        <?php elseif(request('major')): ?>
                            <span class="text-muted">- Jurusan <?php echo e(request('major')); ?></span>
                        <?php elseif(request('grade')): ?>
                            <span class="text-muted">- Tingkat <?php echo e(request('grade')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        Halaman <?php echo e($students->currentPage()); ?> dari <?php echo e($students->lastPage()); ?>

                    </div>
                </div>

                <!-- Bulk Actions -->
                <div class="bulk-actions" id="bulkActions">
                    <span id="selectedCount">0</span> siswa dipilih
                    <div class="ms-auto d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-success" onclick="bulkAction('activate')" title="Aktifkan kembali siswa yang dipilih">
                            <i class="fas fa-user-check"></i> Aktifkan Kembali
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" onclick="bulkAction('deactivate')">
                            <i class="fas fa-user-times"></i> Nonaktifkan
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="bulkAction('graduate')">
                            <i class="fas fa-graduation-cap"></i> Luluskan
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="bulkAction('delete')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <table class="students-table">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" class="form-check-input select-all-checkbox" id="selectAll">
                            </th>
                            <th width="50">Foto</th>
                            <th>Nama & Email</th>
                            <th width="90">NIS</th>
                            <th width="90">NISN</th>
                            <th width="100">Kelas</th>
                            <th width="80">Agama</th>
                            <th width="80">Status</th>
                            <th width="100">Telepon</th>
                            <th width="150">Tanggal Lahir</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input student-checkbox" 
                                           value="<?php echo e($student->id); ?>" name="student_ids[]">
                                </td>
                                <td>
                                    <?php if($student->photo): ?>
                                        <img src="<?php echo e($student->photo_url); ?>" alt="<?php echo e($student->name); ?>" class="student-avatar">
                                    <?php else: ?>
                                        <div class="student-initials"><?php echo e($student->initials); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="student-name"><?php echo e($student->name); ?></div>
                                    <?php if($student->email): ?>
                                        <div class="student-email"><?php echo e($student->email); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <code><?php echo e($student->nis); ?></code>
                                </td>
                                <td>
                                    <?php if($student->nisn): ?>
                                        <code><?php echo e($student->nisn); ?></code>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="student-class"><?php echo e($student->class); ?></span>
                                </td>
                                <td>
                                    <span class="text-muted" style="font-size: 0.75rem;">
                                        <?php echo e($student->religion ?? '-'); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo e($student->status); ?>" 
                                          title="<?php if($student->status === 'inactive'): ?>Dapat diaktifkan kembali@elseif($student->status === 'graduated')Dapat diaktifkan kembali@else<?php echo e($student->status_label); ?><?php endif; ?>">
                                        <?php echo e($student->status_label); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($student->phone): ?>
                                        <a href="tel:<?php echo e($student->phone); ?>" class="text-decoration-none">
                                            <?php echo e($student->phone); ?>

                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="birth-info">
                                        <div class="birth-date">
                                            <?php echo e($student->birth_date->format('d M Y')); ?>

                                        </div>
                                        <div class="birth-place" title="<?php echo e($student->birth_place); ?>">
                                            <?php echo e($student->birth_place); ?>

                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?php echo e(route('admin.students.show', $student)); ?>" 
                                           class="btn-action btn-view" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.students.edit', $student)); ?>" 
                                           class="btn-action btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <?php if($student->status === 'inactive' || $student->status === 'graduated'): ?>
                                            <button type="button" class="btn-action btn-activate" 
                                                    onclick="activateStudent(<?php echo e($student->id); ?>)" 
                                                    title="Aktifkan Kembali">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if($student->status === 'active'): ?>
                                            <button type="button" class="btn-action btn-deactivate" 
                                                    onclick="deactivateStudent(<?php echo e($student->id); ?>)" 
                                                    title="Nonaktifkan">
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button type="button" class="btn-action btn-delete" 
                                                onclick="deleteStudent(<?php echo e($student->id); ?>)" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($students->hasPages()): ?>
                <div class="d-flex justify-content-center mt-3">
                    <?php echo e($students->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3>Belum Ada Data Siswa</h3>
                <p>Mulai tambahkan data siswa untuk mengelola informasi mereka.</p>
                <a href="<?php echo e(route('admin.students.create')); ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Siswa Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Floating Add Button -->
<a href="<?php echo e(route('admin.students.create')); ?>" class="add-student-btn" title="➕ Tambah Siswa Baru">
    <i class="fas fa-plus" aria-hidden="true"></i>
</a>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>

<!-- Bulk Action Form -->
<form id="bulkActionForm" method="POST" action="<?php echo e(route('admin.students.bulk-action')); ?>" style="display: none;">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="action" id="bulkActionType">
    <input type="hidden" name="student_ids" id="bulkStudentIds">
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function deleteStudent(studentId) {
    // Konfirmasi bertingkat untuk keamanan
    const firstConfirm = confirm(
        '⚠️ PERINGATAN PENTING! ⚠️\n\n' +
        'Anda akan menghapus siswa beserta SEMUA data terkaitnya:\n' +
        '• Data pribadi siswa\n' +
        '• Foto siswa\n' +
        '• Prestasi/achievements\n' +
        '• Registrasi ekstrakurikuler\n' +
        '• Akun pengguna (jika ada)\n' +
        '• Semua relasi data\n\n' +
        'Data yang dihapus TIDAK DAPAT DIKEMBALIKAN!\n\n' +
        'Apakah Anda yakin ingin melanjutkan?'
    );
    
    if (firstConfirm) {
        const secondConfirm = confirm(
            '🚨 KONFIRMASI TERAKHIR! 🚨\n\n' +
            'Ini adalah tindakan PERMANEN dan TIDAK DAPAT DIBATALKAN!\n' +
            'Semua data siswa akan hilang selamanya.\n\n' +
            'Ketik "HAPUS" di kotak berikutnya untuk melanjutkan.'
        );
        
        if (secondConfirm) {
            const finalConfirm = prompt(
                'Ketik "HAPUS" (tanpa tanda kutip) untuk mengkonfirmasi penghapusan:'
            );
            
            if (finalConfirm === 'HAPUS') {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/students/${studentId}`;
                form.submit();
            } else {
                alert('Penghapusan dibatalkan. Teks konfirmasi tidak sesuai.');
            }
        }
    }
}

function activateStudent(studentId) {
    if (confirm('Apakah Anda yakin ingin mengaktifkan kembali siswa ini?')) {
        const form = document.getElementById('bulkActionForm');
        document.getElementById('bulkActionType').value = 'activate';
        document.getElementById('bulkStudentIds').value = JSON.stringify([studentId]);
        form.submit();
    }
}

function deactivateStudent(studentId) {
    if (confirm('Apakah Anda yakin ingin menonaktifkan siswa ini?')) {
        const form = document.getElementById('bulkActionForm');
        document.getElementById('bulkActionType').value = 'deactivate';
        document.getElementById('bulkStudentIds').value = JSON.stringify([studentId]);
        form.submit();
    }
}

// Bulk actions functionality
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Individual checkbox functionality
    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAll();
            updateBulkActions();
        });
    });

    function updateSelectAll() {
        const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
        const totalCount = studentCheckboxes.length;
        
        selectAllCheckbox.checked = checkedCount === totalCount;
        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
    }

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
            bulkActions.classList.add('show');
            selectedCount.textContent = count;
        } else {
            bulkActions.classList.remove('show');
        }
    }
});

function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
    
    if (checkedBoxes.length === 0) {
        alert('Pilih minimal satu siswa untuk melakukan aksi ini.');
        return;
    }

    let confirmMessage = '';
    switch(action) {
        case 'delete':
            // Konfirmasi khusus untuk bulk delete
            const bulkFirstConfirm = confirm(
                `⚠️ PERINGATAN KRITIS! ⚠️\n\n` +
                `Anda akan menghapus ${checkedBoxes.length} siswa beserta SEMUA data terkait:\n` +
                `• Data pribadi ${checkedBoxes.length} siswa\n` +
                `• Semua foto siswa\n` +
                `• Semua prestasi/achievements\n` +
                `• Semua registrasi ekstrakurikuler\n` +
                `• Semua akun pengguna terkait\n` +
                `• Semua relasi data\n\n` +
                `Data yang dihapus TIDAK DAPAT DIKEMBALIKAN!\n\n` +
                `Apakah Anda yakin ingin melanjutkan?`
            );
            
            if (!bulkFirstConfirm) return;
            
            const bulkFinalConfirm = prompt(
                `Ketik "HAPUS SEMUA" untuk mengkonfirmasi penghapusan ${checkedBoxes.length} siswa:`
            );
            
            if (bulkFinalConfirm !== 'HAPUS SEMUA') {
                alert('Penghapusan dibatalkan. Teks konfirmasi tidak sesuai.');
                return;
            }
            
            confirmMessage = ''; // Skip normal confirm since we already confirmed
            break;
        case 'activate':
            confirmMessage = `Apakah Anda yakin ingin mengaktifkan kembali ${checkedBoxes.length} siswa yang dipilih?`;
            break;
        case 'deactivate':
            confirmMessage = `Apakah Anda yakin ingin menonaktifkan ${checkedBoxes.length} siswa yang dipilih?`;
            break;
        case 'graduate':
            confirmMessage = `Apakah Anda yakin ingin meluluskan ${checkedBoxes.length} siswa yang dipilih?`;
            break;
    }

    if (confirm(confirmMessage)) {
        const studentIds = Array.from(checkedBoxes).map(cb => cb.value);
        
        document.getElementById('bulkActionType').value = action;
        document.getElementById('bulkStudentIds').value = JSON.stringify(studentIds);
        document.getElementById('bulkActionForm').submit();
    }
}

    // Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate filter section
    const filtersSection = document.querySelector('.filters-section');
    if (filtersSection) {
        filtersSection.style.opacity = '0';
        filtersSection.style.transform = 'translateY(-20px)';
        filtersSection.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(() => {
            filtersSection.style.opacity = '1';
            filtersSection.style.transform = 'translateY(0)';
        }, 200);
    }
    
    // Add interactive effects to filter inputs
    const filterInputs = document.querySelectorAll('.filters-section .form-select, .filters-section .form-control');
    filterInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.2s ease';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
    
    // Add ripple effect to filter buttons
    const filterButtons = document.querySelectorAll('.btn-filter');
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Animate filter stats when they appear
    const filterStats = document.querySelector('.filter-stats');
    if (filterStats) {
        filterStats.style.opacity = '0';
        filterStats.style.transform = 'translateY(10px)';
        filterStats.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        
        setTimeout(() => {
            filterStats.style.opacity = '1';
            filterStats.style.transform = 'translateY(0)';
        }, 300);
    }
    // Animate table rows on scroll
    const rows = document.querySelectorAll('.students-table tbody tr');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                }, index * 50);
            }
        });
    });
    
    rows.forEach(row => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        row.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        observer.observe(row);
    });

    // Animate stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Initialize tooltips for birth place
    const birthPlaces = document.querySelectorAll('.birth-place');
    birthPlaces.forEach(element => {
        if (element.scrollWidth > element.clientWidth) {
            element.style.cursor = 'help';
            
            element.addEventListener('mouseenter', function() {
                const tooltip = document.createElement('div');
                tooltip.className = 'birth-place-tooltip';
                tooltip.textContent = this.textContent;
                tooltip.style.cssText = `
                    position: absolute;
                    background: #1f2937;
                    color: white;
                    padding: 0.5rem 0.75rem;
                    border-radius: 6px;
                    font-size: 0.75rem;
                    z-index: 1000;
                    white-space: nowrap;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                    pointer-events: none;
                `;
                
                document.body.appendChild(tooltip);
                
                const rect = this.getBoundingClientRect();
                tooltip.style.left = (rect.left + window.scrollX) + 'px';
                tooltip.style.top = (rect.top + window.scrollY - tooltip.offsetHeight - 5) + 'px';
                
                this.tooltip = tooltip;
            });
            
            element.addEventListener('mouseleave', function() {
                if (this.tooltip) {
                    this.tooltip.remove();
                    this.tooltip = null;
                }
            });
        }
    });
    
    // Enhanced floating button interactions
    const addButton = document.querySelector('.add-student-btn');
    if (addButton) {
        // Ensure plus icon is visible
        const icon = addButton.querySelector('i');
        if (icon) {
            // Check if FontAwesome loaded properly
            const computedStyle = window.getComputedStyle(icon, '::before');
            if (!computedStyle.content || computedStyle.content === 'none') {
                // FontAwesome not loaded, use text fallback
                icon.textContent = '+';
                icon.style.fontFamily = 'Arial, sans-serif';
                icon.style.fontSize = '2.2rem';
                icon.style.fontWeight = 'bold';
            }
        }
        // Add click ripple effect
        addButton.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
        

    }
});

// Add ripple animation CSS
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(rippleStyle);

// Smart Class Filter System
document.addEventListener('DOMContentLoaded', function() {
    const gradeFilter = document.getElementById('gradeFilter');
    const majorFilter = document.getElementById('majorFilter');
    const classFilter = document.getElementById('classFilter');
    
    // Store all class options
    const allClassOptions = Array.from(classFilter.options).slice(1); // Exclude "Semua Kelas"
    
    function updateClassFilter() {
        const selectedGrade = gradeFilter.value;
        const selectedMajor = majorFilter.value;
        
        // Clear current options except "Semua Kelas"
        classFilter.innerHTML = '<option value="">Semua Kelas</option>';
        
        // Filter and add relevant options
        allClassOptions.forEach(option => {
            const className = option.value;
            let shouldShow = true;
            
            // Filter by grade
            if (selectedGrade && !className.startsWith(selectedGrade)) {
                shouldShow = false;
            }
            
            // Filter by major
            if (selectedMajor && !className.includes(selectedMajor)) {
                shouldShow = false;
            }
            
            if (shouldShow) {
                const newOption = document.createElement('option');
                newOption.value = className;
                newOption.textContent = className;
                
                // Maintain selection if it matches current request
                if (className === '<?php echo e(request("class")); ?>') {
                    newOption.selected = true;
                }
                
                classFilter.appendChild(newOption);
            }
        });
        
        // If current selection is no longer valid, clear it
        if (classFilter.value === '' && '<?php echo e(request("class")); ?>') {
            const currentClass = '<?php echo e(request("class")); ?>';
            const isStillValid = Array.from(classFilter.options).some(opt => opt.value === currentClass);
            if (!isStillValid) {
                // Clear the class filter if the current selection is no longer valid
                const url = new URL(window.location);
                url.searchParams.delete('class');
                // Don't auto-redirect, just update the dropdown
            }
        }
    }
    
    // Update class filter when grade or major changes
    gradeFilter.addEventListener('change', updateClassFilter);
    majorFilter.addEventListener('change', updateClassFilter);
    
    // Initialize on page load
    updateClassFilter();
    
    // Add visual feedback for filter interactions
    [gradeFilter, majorFilter, classFilter].forEach(filter => {
        filter.addEventListener('change', function() {
            this.style.borderColor = '#4f46e5';
            this.style.boxShadow = '0 0 0 3px rgba(79, 70, 229, 0.1)';
            
            setTimeout(() => {
                this.style.borderColor = '';
                this.style.boxShadow = '';
            }, 1000);
        });
    });
    
    // Auto-submit form when specific class is selected
    classFilter.addEventListener('change', function() {
        if (this.value) {
            // Add a small delay for better UX
            setTimeout(() => {
                this.closest('form').submit();
            }, 300);
        }
    });
    
    // Quick filter buttons
    const quickFilters = {
        'filter-10-tkj': { grade: '10', major: 'TKJ' },
        'filter-10-rpl': { grade: '10', major: 'RPL' },
        'filter-10-dkv': { grade: '10', major: 'DKV' },
        'filter-11-tkj': { grade: '11', major: 'TKJ' },
        'filter-11-rpl': { grade: '11', major: 'RPL' },
        'filter-11-dkv': { grade: '11', major: 'DKV' },
        'filter-12-tkj': { grade: '12', major: 'TKJ' },
        'filter-12-rpl': { grade: '12', major: 'RPL' },
        'filter-12-dkv': { grade: '12', major: 'DKV' }
    };
    
    // Add quick filter functionality if buttons exist
    Object.keys(quickFilters).forEach(id => {
        const button = document.getElementById(id);
        if (button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const filter = quickFilters[id];
                gradeFilter.value = filter.grade;
                majorFilter.value = filter.major;
                updateClassFilter();
                
                // Submit form
                setTimeout(() => {
                    document.querySelector('.filters-form').submit();
                }, 100);
            });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/students/index.blade.php ENDPATH**/ ?>