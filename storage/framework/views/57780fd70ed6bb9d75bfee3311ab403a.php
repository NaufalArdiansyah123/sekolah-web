<?php $__env->startSection('title', 'Manajemen Nilai'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Enhanced Grades Management Styles */
    .grades-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .page-header {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(5, 150, 105, 0.2);
        margin-bottom: 2rem;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .header-left {
        flex: 1;
        min-width: 300px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.75rem 0;
        color: white;
    }

    .page-subtitle {
        opacity: 0.95;
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .header-stats {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
    }

    .header-stat {
        text-align: center;
    }

    .header-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .header-stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-primary);
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px var(--shadow-color);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 16px 16px 0 0;
    }

    .stat-card.total::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .stat-card.semester::before { background: linear-gradient(90deg, #059669, #10b981); }
    .stat-card.average::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .stat-card.subjects::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px var(--shadow-color);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .stat-card.total .stat-icon { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #3b82f6; }
    .stat-card.semester .stat-icon { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #059669; }
    .stat-card.average .stat-icon { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #f59e0b; }
    .stat-card.subjects .stat-icon { background: linear-gradient(135deg, #e9d5ff, #ddd6fe); color: #8b5cf6; }

    .dark .stat-card.total .stat-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; }
    .dark .stat-card.semester .stat-icon { background: linear-gradient(135deg, #059669, #10b981); color: white; }
    .dark .stat-card.average .stat-icon { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .dark .stat-card.subjects .stat-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }



    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.3s ease;
    }

    .stat-change {
        font-size: 0.75rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .stat-change.positive { color: #059669; }
    .stat-change.negative { color: #dc2626; }
    .stat-change.neutral { color: var(--text-secondary); }

    .filters-section {
        background: var(--bg-primary);
        padding: 2rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px var(--shadow-color);
        position: relative;
    }

    .filters-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .filters-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quick-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .grades-table-container {
        background: var(--bg-primary);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .table-header {
        background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));
        padding: 2rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .table-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .table-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .bulk-actions {
        background: var(--bg-secondary);
        padding: 1rem 2rem;
        border-bottom: 1px solid var(--border-color);
        display: none;
        align-items: center;
        gap: 1rem;
    }

    .bulk-actions.show {
        display: flex;
    }

    .selected-count {
        font-weight: 600;
        color: var(--text-primary);
    }

    .grades-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .grades-table th,
    .grades-table td {
        padding: 1.25rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .grades-table th {
        background: var(--bg-secondary);
        font-weight: 700;
        color: var(--text-primary);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .grades-table td {
        color: var(--text-primary);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .grades-table tbody tr {
        transition: background-color 0.2s ease;
        cursor: pointer;
    }

    .grades-table tbody tr:hover {
        background: var(--bg-secondary);
    }

    .grades-table tbody tr.selected {
        background: rgba(59, 130, 246, 0.1);
        border-left: 4px solid #3b82f6;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.875rem;
    }

    .student-details {
        flex: 1;
    }

    .student-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .student-class {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .score-display {
        text-align: center;
    }

    .score-main {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .score-max {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .score-percentage {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
    }

    .grade-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .grade-badge.excellent { 
        background: linear-gradient(135deg, #dcfce7, #bbf7d0); 
        color: #166534; 
        border: 2px solid #22c55e;
    }
    .grade-badge.good { 
        background: linear-gradient(135deg, #dbeafe, #bfdbfe); 
        color: #1e40af; 
        border: 2px solid #3b82f6;
    }
    .grade-badge.average { 
        background: linear-gradient(135deg, #fef3c7, #fde68a); 
        color: #92400e; 
        border: 2px solid #f59e0b;
    }
    .grade-badge.poor { 
        background: linear-gradient(135deg, #fee2e2, #fecaca); 
        color: #991b1b; 
        border: 2px solid #ef4444;
    }

    .type-badge {
        display: inline-block;
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid;
    }

    .type-badge.assignment { 
        background: rgba(59, 130, 246, 0.1); 
        color: #1e40af; 
        border-color: rgba(59, 130, 246, 0.3);
    }
    .type-badge.quiz { 
        background: rgba(16, 185, 129, 0.1); 
        color: #047857; 
        border-color: rgba(16, 185, 129, 0.3);
    }
    .type-badge.exam { 
        background: rgba(245, 158, 11, 0.1); 
        color: #92400e; 
        border-color: rgba(245, 158, 11, 0.3);
    }
    .type-badge.manual { 
        background: rgba(139, 92, 246, 0.1); 
        color: #6b21a8; 
        border-color: rgba(139, 92, 246, 0.3);
    }

    .date-display {
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    .date-main {
        font-weight: 600;
        color: var(--text-primary);
    }

    .date-time {
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #047857, #059669);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 8px var(--shadow-color);
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        text-decoration: none;
        box-shadow: 0 2px 8px var(--shadow-color);
    }

    .btn-success {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #047857, #059669);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }

    .btn-xs {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }

    .btn-group {
        display: flex;
        gap: 0.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkbox-wrapper input[type="checkbox"] {
        width: 18px;
        height: 18px;
        border-radius: 4px;
        border: 2px solid var(--border-color);
        background: var(--bg-primary);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .checkbox-wrapper input[type="checkbox"]:checked {
        background: #3b82f6;
        border-color: #3b82f6;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        opacity: 0.5;
        color: var(--text-secondary);
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .empty-description {
        font-size: 1rem;
        margin-bottom: 2rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 300px;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: var(--text-secondary);
    }

    .pagination-wrapper {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-color);
        background: var(--bg-secondary);
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top: 4px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        box-shadow: 0 8px 25px var(--shadow-color);
        z-index: 9999;
        transform: translateX(400px);
        transition: transform 0.3s ease;
    }

    .toast.show {
        transform: translateX(0);
    }

    .toast.success {
        border-left: 4px solid #059669;
    }

    .toast.error {
        border-left: 4px solid #ef4444;
    }

    .toast.warning {
        border-left: 4px solid #f59e0b;
    }

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
        --success-color: #059669;
        --warning-color: #f59e0b;
        --error-color: #ef4444;
        --info-color: #3b82f6;
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

    /* Responsive Design */
    @media (max-width: 1024px) {
        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .header-actions {
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .table-header {
            flex-direction: column;
            gap: 1rem;
        }

        .table-actions {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .grades-container {
            padding: 1rem;
        }

        .page-header {
            padding: 2rem 1.5rem;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .header-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filters-section {
            padding: 1.5rem;
        }

        .grades-table {
            font-size: 0.8rem;
        }

        .grades-table th,
        .grades-table td {
            padding: 0.75rem 0.5rem;
        }

        .student-info {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        .search-box {
            max-width: 100%;
        }
    }

    @media (max-width: 480px) {
        .page-header {
            padding: 1.5rem 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .filters-section {
            padding: 1rem;
        }

        .table-header {
            padding: 1rem;
        }

        .grades-table th,
        .grades-table td {
            padding: 0.5rem 0.25rem;
            font-size: 0.75rem;
        }

        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }
    }

    /* Print Styles */
    @media print {
        .grades-container {
            background: white;
            padding: 0;
        }

        .page-header {
            background: white !important;
            color: black !important;
            box-shadow: none;
        }

        .filters-section,
        .table-actions,
        .action-buttons,
        .pagination-wrapper {
            display: none !important;
        }

        .grades-table {
            border: 1px solid #000;
        }

        .grades-table th,
        .grades-table td {
            border: 1px solid #000;
            color: black !important;
        }
    }

    /* Simple fade animation */
    .fade-in {
        opacity: 1;
        transition: opacity 0.3s ease;
    }
</style>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<!-- Toast Notifications -->
<div class="toast" id="toast">
    <div class="toast-content"></div>
</div>

<div class="grades-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">📊 Manajemen Nilai</h1>
                <p class="page-subtitle">Kelola dan pantau nilai siswa dengan mudah dan efisien</p>
                <div class="header-stats">
                    <div class="header-stat">
                        <div class="header-stat-value"><?php echo e($stats['total_grades']); ?></div>
                        <div class="header-stat-label">Total Nilai</div>
                    </div>
                    <div class="header-stat">
                        <div class="header-stat-value"><?php echo e(number_format($stats['average_score'], 1)); ?></div>
                        <div class="header-stat-label">Rata-rata</div>
                    </div>
                    <div class="header-stat">
                        <div class="header-stat-value"><?php echo e($stats['subjects_count']); ?></div>
                        <div class="header-stat-label">Mata Pelajaran</div>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="<?php echo e(route('teacher.grades.create')); ?>" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Nilai
                </a>
                <button onclick="exportToExcel()" class="btn btn-success">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </a>
                <button onclick="showImportModal()" class="btn btn-warning">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                    Import Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($stats['total_grades']); ?></div>
            <div class="stat-label">Total Nilai</div>
        </div>
        <div class="stat-card semester">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 112 0v1m-2 0h4m-4 0a2 2 0 00-2 2v10a2 2 0 002 2h4a2 2 0 002-2V9a2 2 0 00-2-2m-4 0V7"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($stats['this_semester']); ?></div>
            <div class="stat-label">Semester Ini</div>
        </div>
        <div class="stat-card average">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e(number_format($stats['average_score'], 1)); ?></div>
            <div class="stat-label">Rata-rata Nilai</div>
        </div>
        <div class="stat-card subjects">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="stat-value"><?php echo e($stats['subjects_count']); ?></div>
            <div class="stat-label">Mata Pelajaran</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <div class="filters-header">
            <h3 class="filters-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                </svg>
                Filter & Pencarian
            </h3>
            <div class="quick-actions">
                <button onclick="clearAllFilters()" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear All
                </button>
                <button onclick="saveCurrentFilter()" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    Save Filter
                </button>
            </div>
        </div>
        
        <form method="GET" id="filterForm" class="flex flex-wrap gap-4 items-end">
            <div class="search-box">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       class="search-input" placeholder="Cari nama siswa..." 
                       oninput="debounceSearch(this.value)">
            </div>
            
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mata Pelajaran</label>
                <select name="subject" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="this.form.submit()">
                    <option value="">🎯 Semua Mata Pelajaran</option>
                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjectOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($subjectOption); ?>" <?php echo e($subject == $subjectOption ? 'selected' : ''); ?>>
                            📚 <?php echo e($subjectOption); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="flex-1 min-w-32">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                <select name="class" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="this.form.submit()">
                    <option value="">🏫 Semua Kelas</option>
                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($classOption); ?>" <?php echo e($class == $classOption ? 'selected' : ''); ?>>
                            🎓 Kelas <?php echo e($classOption); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="flex-1 min-w-32">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Semester</label>
                <select name="semester" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="this.form.submit()">
                    <option value="1" <?php echo e($semester == 1 ? 'selected' : ''); ?>>📅 Semester 1</option>
                    <option value="2" <?php echo e($semester == 2 ? 'selected' : ''); ?>>📅 Semester 2</option>
                </select>
            </div>
            
            <div class="flex-1 min-w-24">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Ajaran</label>
                <input type="number" name="year" value="<?php echo e($year); ?>" min="2020" max="2030" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                       onchange="this.form.submit()">
            </div>
            
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Filter
            </button>
            <a href="<?php echo e(route('teacher.grades.index')); ?>" class="btn btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset
            </a>
        </form>
    </div>

    <!-- Grades Table -->
    <div class="grades-table-container">
        <div class="table-header">
            <h3 class="table-title">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Daftar Nilai Siswa
            </h3>
            <div class="table-actions">
                <button onclick="selectAll()" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pilih Semua
                </button>
                <button onclick="printTable()" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
                <a href="<?php echo e(route('teacher.grades.report')); ?>" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Laporan
                </a>
                <a href="<?php echo e(route('teacher.grades.recap')); ?>" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Rekap
                </a>
            </div>
        </div>
        
        <!-- Bulk Actions -->
        <div class="bulk-actions" id="bulkActions">
            <span class="selected-count">0 item dipilih</span>
            <button onclick="bulkDelete()" class="btn btn-danger btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Terpilih
            </button>
            <button onclick="bulkExport()" class="btn btn-success btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Terpilih
            </button>
        </div>

        <?php if($grades->count() > 0): ?>
            <table class="grades-table" id="gradesTable">
                <thead>
                    <tr>
                        <th>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                            </div>
                        </th>
                        <th>👤 Siswa</th>
                        <th>📚 Mata Pelajaran</th>
                        <th>📝 Jenis</th>
                        <th>📊 Nilai</th>
                        <th>🏆 Grade</th>
                        <th>📅 Tanggal</th>
                        <th>⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-grade-id="<?php echo e($grade->id); ?>" onclick="toggleRowSelection(this, event)">
                            <td>
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" class="row-checkbox" value="<?php echo e($grade->id); ?>" onchange="updateBulkActions()">
                                </div>
                            </td>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">
                                        <?php echo e(strtoupper(substr($grade->student->name, 0, 2))); ?>

                                    </div>
                                    <div class="student-details">
                                        <div class="student-name"><?php echo e($grade->student->name); ?></div>
                                        <div class="student-class">Kelas <?php echo e($grade->student->class ?? 'N/A'); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="font-semibold text-blue-600 dark:text-blue-400">
                                    <?php echo e($grade->subject); ?>

                                </span>
                            </td>
                            <td>
                                <span class="type-badge <?php echo e($grade->type); ?>">
                                    <?php echo e(ucfirst($grade->type)); ?>

                                </span>
                            </td>
                            <td>
                                <div class="score-display">
                                    <div class="score-main"><?php echo e($grade->score); ?></div>
                                    <div class="score-max">/ <?php echo e($grade->max_score); ?></div>
                                    <div class="score-percentage"><?php echo e(number_format($grade->percentage, 1)); ?>%</div>
                                </div>
                            </td>
                            <td>
                                <?php
                                    $percentage = $grade->percentage;
                                    $badgeClass = 'poor';
                                    if ($percentage >= 90) $badgeClass = 'excellent';
                                    elseif ($percentage >= 80) $badgeClass = 'good';
                                    elseif ($percentage >= 70) $badgeClass = 'average';
                                ?>
                                <span class="grade-badge <?php echo e($badgeClass); ?>" title="<?php echo e(number_format($percentage, 1)); ?>%">
                                    <?php echo e($grade->letter_grade); ?>

                                </span>
                            </td>
                            <td>
                                <div class="date-display">
                                    <div class="date-main"><?php echo e($grade->created_at->format('d M Y')); ?></div>
                                    <div class="date-time"><?php echo e($grade->created_at->format('H:i')); ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('teacher.grades.show', $grade->id)); ?>" 
                                       class="btn btn-secondary btn-xs" 
                                       title="Lihat Detail"
                                       onclick="event.stopPropagation()">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="<?php echo e(route('teacher.grades.edit', $grade->id)); ?>" 
                                       class="btn btn-warning btn-xs" 
                                       title="Edit Nilai"
                                       onclick="event.stopPropagation()">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <button onclick="deleteGrade(<?php echo e($grade->id); ?>, event)" 
                                            class="btn btn-danger btn-xs" 
                                            title="Hapus Nilai">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if($grades->hasPages()): ?>
                <div class="pagination-wrapper">
                    <div class="flex items-center justify-between w-full">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            Menampilkan <?php echo e($grades->firstItem()); ?> - <?php echo e($grades->lastItem()); ?> dari <?php echo e($grades->total()); ?> data
                        </div>
                        <div>
                            <?php echo e($grades->appends(request()->query())->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="empty-title">📊 Belum Ada Data Nilai</h3>
                <p class="empty-description">
                    Sepertinya belum ada nilai yang diinputkan untuk filter yang dipilih. 
                    Mulai tambahkan nilai untuk siswa Anda atau ubah filter pencarian.
                </p>
                <div class="flex gap-3 justify-center">
                    <a href="<?php echo e(route('teacher.grades.create')); ?>" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Nilai Pertama
                    </a>
                    <button onclick="clearAllFilters()" class="btn btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset Filter
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Import Data Nilai</h3>
                <button onclick="hideImportModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form id="importForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih File Excel (.xlsx, .xls)
                    </label>
                    <input type="file" name="excel_file" accept=".xlsx,.xls" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <p class="text-xs text-gray-500 mt-1">
                        Format: Nama Siswa | Mata Pelajaran | Jenis | Nilai | Nilai Maksimal
                    </p>
                </div>
                
                <div class="mb-4">
                    <a href="#" onclick="downloadTemplate()" class="text-blue-600 hover:text-blue-800 text-sm">
                        📥 Download Template Excel
                    </a>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="hideImportModal()" class="flex-1 btn btn-secondary">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 btn btn-primary">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Global variables
let selectedRows = [];
let searchTimeout;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    updateBulkActions();
});

// Search functionality
function debounceSearch(value) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        if (value.length >= 3 || value.length === 0) {
            document.getElementById('filterForm').submit();
        }
    }, 500);
}

// Row selection
function toggleRowSelection(row, event) {
    if (event.target.type === 'checkbox' || event.target.closest('button') || event.target.closest('a')) {
        return;
    }
    
    const checkbox = row.querySelector('.row-checkbox');
    checkbox.checked = !checkbox.checked;
    updateBulkActions();
}

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    rowCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    
    updateBulkActions();
}

function selectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    selectAllCheckbox.checked = true;
    toggleSelectAll();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = bulkActions.querySelector('.selected-count');
    
    if (checkedBoxes.length > 0) {
        bulkActions.classList.add('show');
        selectedCount.textContent = `${checkedBoxes.length} item dipilih`;
    } else {
        bulkActions.classList.remove('show');
    }
    
    // Update select all checkbox
    const allCheckboxes = document.querySelectorAll('.row-checkbox');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    selectAllCheckbox.checked = checkedBoxes.length === allCheckboxes.length && allCheckboxes.length > 0;
}

// Export functionality
function exportToExcel() {
    showLoading();
    
    // Get current filters
    const params = new URLSearchParams(window.location.search);
    params.append('export', 'excel');
    
    // Create download link
    const link = document.createElement('a');
    link.href = `<?php echo e(route('teacher.grades.index')); ?>?${params.toString()}`;
    link.download = `nilai-siswa-${new Date().toISOString().split('T')[0]}.xlsx`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    hideLoading();
    showToast('Data berhasil diekspor ke Excel!', 'success');
}

function bulkExport() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        showToast('Pilih data yang ingin diekspor!', 'warning');
        return;
    }
    
    showLoading();
    
    // Create form for bulk export
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo e(route("teacher.grades.index")); ?>';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '<?php echo e(csrf_token()); ?>';
    form.appendChild(csrfToken);
    
    const exportField = document.createElement('input');
    exportField.type = 'hidden';
    exportField.name = 'export';
    exportField.value = 'selected';
    form.appendChild(exportField);
    
    ids.forEach(id => {
        const idField = document.createElement('input');
        idField.type = 'hidden';
        idField.name = 'ids[]';
        idField.value = id;
        form.appendChild(idField);
    });
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    hideLoading();
    showToast(`${ids.length} data berhasil diekspor!`, 'success');
}

// Import functionality
function showImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
    document.getElementById('importModal').classList.add('flex');
}

function hideImportModal() {
    document.getElementById('importModal').classList.add('hidden');
    document.getElementById('importModal').classList.remove('flex');
}

function downloadTemplate() {
    const link = document.createElement('a');
    link.href = '<?php echo e(route("teacher.grades.index")); ?>?download=template';
    link.download = 'template-import-nilai.xlsx';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showToast('Template berhasil didownload!', 'success');
}

// Handle import form submission
document.getElementById('importForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const fileInput = this.querySelector('input[type="file"]');
    
    if (!fileInput.files[0]) {
        showToast('Pilih file Excel terlebih dahulu!', 'warning');
        return;
    }
    
    showLoading();
    
    fetch('<?php echo e(route("teacher.grades.index")); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        hideImportModal();
        
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        hideLoading();
        hideImportModal();
        showToast('Terjadi kesalahan saat mengimpor data!', 'error');
        console.error('Import error:', error);
    });
});

// Delete functionality
function deleteGrade(id, event) {
    event.stopPropagation();
    
    if (!confirm('Apakah Anda yakin ingin menghapus nilai ini?')) {
        return;
    }
    
    showLoading();
    
    fetch(`<?php echo e(route('teacher.grades.index')); ?>/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        
        if (data.success) {
            showToast('Nilai berhasil dihapus!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast('Gagal menghapus nilai!', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showToast('Terjadi kesalahan!', 'error');
        console.error('Delete error:', error);
    });
}

function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        showToast('Pilih data yang ingin dihapus!', 'warning');
        return;
    }
    
    if (!confirm(`Apakah Anda yakin ingin menghapus ${ids.length} nilai yang dipilih?`)) {
        return;
    }
    
    showLoading();
    
    fetch('<?php echo e(route("teacher.grades.index")); ?>', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        
        if (data.success) {
            showToast(`${ids.length} nilai berhasil dihapus!`, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast('Gagal menghapus nilai!', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showToast('Terjadi kesalahan!', 'error');
        console.error('Bulk delete error:', error);
    });
}

// Utility functions
function clearAllFilters() {
    window.location.href = '<?php echo e(route("teacher.grades.index")); ?>';
}

function saveCurrentFilter() {
    const params = new URLSearchParams(window.location.search);
    localStorage.setItem('savedGradeFilter', params.toString());
    showToast('Filter berhasil disimpan!', 'success');
}

function printTable() {
    window.print();
}

function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}

function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastContent = toast.querySelector('.toast-content');
    
    toastContent.textContent = message;
    toast.className = `toast ${type} show`;
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teacher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/teacher/grades/index.blade.php ENDPATH**/ ?>