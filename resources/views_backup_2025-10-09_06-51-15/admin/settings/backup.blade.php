@extends('layouts.admin')

@section('title', 'Backup Management')

@section('content')
<style>
/* Backup Management Styles - Dark Mode Compatible */
.backup-page {
    min-height: 100vh;
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    padding: 2rem;
    transition: all 0.3s ease;
}

/* Hero Header */
.backup-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 24px;
    padding: 3rem;
    margin-bottom: 3rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.backup-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: rgba(255, 255, 255, 0.1);
    transform: rotate(-15deg);
}

.hero-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 2rem;
}

.hero-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.hero-text h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem 0;
}

.hero-text p {
    font-size: 1.125rem;
    opacity: 0.9;
    margin: 0 0 1rem 0;
}

.hero-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    opacity: 0.8;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-item a {
    color: white;
    text-decoration: none;
}

.breadcrumb-separator {
    opacity: 0.6;
}

/* Alert Messages */
.alert-container {
    margin-bottom: 2rem;
}

.alert {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.alert-success {
    background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
    color: #0369a1;
    border-left: 4px solid #4facfe;
}

.alert-error {
    background: linear-gradient(135deg, rgba(250, 112, 154, 0.1) 0%, rgba(254, 225, 64, 0.1) 100%);
    color: #dc2626;
    border-left: 4px solid #fa709a;
}

.alert-info {
    background: linear-gradient(135deg, rgba(168, 237, 234, 0.1) 0%, rgba(254, 214, 227, 0.1) 100%);
    color: #0891b2;
    border-left: 4px solid #a8edea;
}

/* Backup Actions Section */
.backup-actions {
    background-color: var(--bg-primary);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 25px 50px -12px var(--shadow-color);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-color);
}

.section-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.section-title {
    flex: 1;
}

.section-title h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.25rem 0;
}

.section-title p {
    color: var(--text-secondary);
    margin: 0;
}

/* Backup Cards Grid */
.backup-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.backup-card {
    background-color: var(--bg-primary);
    border-radius: 20px;
    border: 2px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
    box-shadow: 0 4px 6px -1px var(--shadow-color);
}

.backup-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    transition: all 0.3s ease;
}

.backup-card.primary::before {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.backup-card.success::before {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
}

.backup-card.warning::before {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
}

.backup-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 25px 50px -12px var(--shadow-color);
    border-color: var(--primary-color);
}

.backup-card:hover::before {
    height: 6px;
}

.card-body {
    padding: 2rem;
    text-align: center;
}

.card-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    transition: all 0.3s ease;
}

.backup-card.primary .card-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.backup-card.success .card-icon {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
}

.backup-card.warning .card-icon {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
}

.backup-card:hover .card-icon {
    transform: scale(1.1);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.card-description {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.backup-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 0.875rem;
    min-width: 160px;
    justify-content: center;
}

.backup-btn.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.backup-btn.success {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: white;
}

.backup-btn.warning {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    color: white;
}

.backup-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    color: white;
    text-decoration: none;
}

.backup-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Backup Info */
.backup-info {
    background: linear-gradient(135deg, rgba(168, 237, 234, 0.1) 0%, rgba(254, 214, 227, 0.1) 100%);
    border: 1px solid rgba(168, 237, 234, 0.3);
    border-radius: 16px;
    padding: 1.5rem;
    margin-top: 2rem;
}

.backup-info h6 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #0891b2;
    font-weight: 600;
    margin-bottom: 1rem;
}

.backup-info ul {
    margin: 0;
    padding-left: 1.5rem;
    color: var(--text-secondary);
}

.backup-info li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.backup-info code {
    background: rgba(0, 0, 0, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.875rem;
    color: var(--text-primary);
}

/* Existing Backups Section */
.backups-list {
    background-color: var(--bg-primary);
    border-radius: 24px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    box-shadow: 0 25px 50px -12px var(--shadow-color);
}

.list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.refresh-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.refresh-btn:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    text-decoration: none;
    transform: translateY(-1px);
}

/* Table Styles */
.table-container {
    background-color: var(--bg-primary);
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.backup-table {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
}

.backup-table th,
.backup-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.backup-table th {
    background-color: var(--bg-secondary);
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.backup-table td {
    color: var(--text-secondary);
}

.backup-table tbody tr:hover {
    background-color: var(--bg-tertiary);
}

.backup-table tbody tr:last-child td {
    border-bottom: none;
}

/* Badge Styles */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.badge.primary {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    border: 1px solid rgba(102, 126, 234, 0.2);
}

.badge.success {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.badge.warning {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.badge.secondary {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
    border: 1px solid rgba(107, 114, 128, 0.2);
}

/* Action Buttons */
.action-group {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    background: var(--bg-secondary);
    color: var(--text-secondary);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.action-btn:hover {
    color: var(--text-primary);
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px var(--shadow-color);
}

.action-btn.download:hover {
    background: rgba(79, 172, 254, 0.1);
    border-color: #4facfe;
    color: #4facfe;
}

.action-btn.delete:hover {
    background: rgba(239, 68, 68, 0.1);
    border-color: #ef4444;
    color: #ef4444;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-icon {
    font-size: 4rem;
    color: var(--text-tertiary);
    margin-bottom: 1.5rem;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-description {
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Modal Styles */
.modal-content {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px var(--shadow-color);
}

.modal-header {
    background-color: var(--bg-secondary);
    border-bottom: 1px solid var(--border-color);
    border-radius: 16px 16px 0 0;
    padding: 1.5rem;
}

.modal-title {
    color: var(--text-primary);
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-body {
    padding: 2rem;
    color: var(--text-primary);
}

.modal-footer {
    background-color: var(--bg-secondary);
    border-top: 1px solid var(--border-color);
    border-radius: 0 0 16px 16px;
    padding: 1.5rem;
}

.btn-close {
    background: none;
    border: none;
    color: var(--text-secondary);
    opacity: 0.7;
}

.btn-close:hover {
    opacity: 1;
    color: var(--text-primary);
}

/* Progress Bar */
.progress {
    height: 8px;
    background-color: var(--bg-tertiary);
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-bar-animated {
    animation: progress-bar-stripes 1s linear infinite;
}

@keyframes progress-bar-stripes {
    0% { background-position: 1rem 0; }
    100% { background-position: 0 0; }
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 0.875rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-secondary {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
    color: white;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: white;
}

.btn-secondary:hover {
    background: var(--bg-secondary);
    color: var(--text-primary);
}

/* Responsive Design */
@media (max-width: 768px) {
    .backup-page {
        padding: 1rem;
    }
    
    .backup-hero {
        padding: 2rem;
    }
    
    .hero-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .hero-text h1 {
        font-size: 2rem;
    }
    
    .backup-grid {
        grid-template-columns: 1fr;
    }
    
    .list-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .backup-table th,
    .backup-table td {
        padding: 0.75rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .action-group {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .backup-hero {
        padding: 1.5rem;
    }
    
    .hero-text h1 {
        font-size: 1.75rem;
    }
    
    .backup-actions,
    .backups-list {
        padding: 1.5rem;
    }
    
    .backup-table th,
    .backup-table td {
        padding: 0.5rem;
        font-size: 0.8rem;
    }
}

/* Loading States */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.spinner {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border-color);
    border-top: 2px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div class="backup-page">
    <!-- Hero Header -->
    <div class="backup-hero">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fas fa-database"></i>
            </div>
            <div class="hero-text">
                <h1>Backup Management</h1>
                <p>Create, manage, and restore system backups with comprehensive data protection</p>
                <div class="hero-breadcrumb">
                    <span class="breadcrumb-item">
                        <i class="fas fa-home"></i>
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </span>
                    <span class="breadcrumb-separator">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                    <span class="breadcrumb-item">
                        <a href="{{ route('admin.settings.index') }}">Settings</a>
                    </span>
                    <span class="breadcrumb-separator">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                    <span class="breadcrumb-item active">Backup</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-container">
            <div class="alert alert-success">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-content">
                    <h4>Success!</h4>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-container">
            <div class="alert alert-error">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="alert-content">
                    <h4>Error!</h4>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(isset($isWritable) && !$isWritable)
        <div class="alert-container">
            <div class="alert alert-error">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-content">
                    <h4>Warning: Backup Directory Not Writable</h4>
                    <p>The backup directory <code>{{ $backupPathDisplay ?? $backupPath }}</code> is not writable. Please check directory permissions or contact your system administrator.</p>
                </div>
            </div>
        </div>
    @endif

    @if(isset($pathExists) && !$pathExists)
        <div class="alert-container">
            <div class="alert alert-error">
                <div class="alert-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="alert-content">
                    <h4>Warning: Backup Directory Not Found</h4>
                    <p>The backup directory <code>{{ $backupPathDisplay ?? $backupPath }}</code> does not exist. It will be created automatically when you create your first backup.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Backup Actions Section -->
    <div class="backup-actions">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="section-title">
                <h2>Create New Backup</h2>
                <p>Choose the type of backup you want to create for your system</p>
            </div>
        </div>

        <div class="backup-grid">
            <!-- Full Backup -->
            <div class="backup-card primary">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="fas fa-archive"></i>
                    </div>
                    <h3 class="card-title">Full Backup</h3>
                    <p class="card-description">
                        Complete system backup including database, application files, and configurations
                    </p>
                    <button type="button" class="backup-btn primary btn-backup" data-type="full">
                        <i class="fas fa-download"></i>
                        Create Full Backup
                    </button>
                </div>
            </div>

            <!-- Database Backup -->
            <div class="backup-card success">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="card-title">Database Backup</h3>
                    <p class="card-description">
                        Export database structure and data as SQL dump for easy restoration
                    </p>
                    <button type="button" class="backup-btn success btn-backup" data-type="database">
                        <i class="fas fa-download"></i>
                        Create DB Backup
                    </button>
                </div>
            </div>

            <!-- Files Backup -->
            <div class="backup-card warning">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <h3 class="card-title">Files Backup</h3>
                    <p class="card-description">
                        Backup application source code, configurations, and uploaded files
                    </p>
                    <button type="button" class="backup-btn warning btn-backup" data-type="files">
                        <i class="fas fa-download"></i>
                        Create Files Backup
                    </button>
                </div>
            </div>
        </div>

        <!-- Backup Information -->
        <div class="backup-info">
            <h6>
                <i class="fas fa-info-circle"></i>
                Backup Information
            </h6>
            <ul>
                <li>
                    <strong>Backup Location:</strong> 
                    <code>{{ $backupPathDisplay ?? $backupPath }}</code>
                    @if(isset($isWritable) && !$isWritable)
                        <span class="badge warning ms-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            Not Writable
                        </span>
                    @elseif(isset($isWritable) && $isWritable)
                        <span class="badge success ms-2">
                            <i class="fas fa-check"></i>
                            Writable
                        </span>
                    @endif
                </li>
                @if(isset($diskSpace))
                <li><strong>Available Space:</strong> {{ $diskSpace }}</li>
                @endif
                <li><strong>Full Backup:</strong> Includes database + project files (app, config, database, resources, routes)</li>
                <li><strong>Database Backup:</strong> MySQL dump with complete structure and data</li>
                <li><strong>Files Backup:</strong> Application source code excluding vendor, node_modules, and cache files</li>
                <li><strong>File Format:</strong> All backups are compressed as ZIP archives for easy storage and transfer</li>
                <li><strong>Storage Location:</strong> Backups are saved to your Documents folder for easy access and management</li>
            </ul>
        </div>
    </div>

    <!-- Existing Backups Section -->
    <div class="backups-list">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="section-title">
                <h2>Existing Backups</h2>
                <p>Manage and download your previously created backup files</p>
            </div>
        </div>

        <div class="list-header">
            <div class="list-info">
                <span class="text-muted">{{ count($backups) }} backup(s) found</span>
            </div>
            <a href="javascript:void(0)" class="refresh-btn" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i>
                Refresh
            </a>
        </div>

        @if(count($backups) > 0)
            <div class="table-container">
                <table class="backup-table" id="backupsTable">
                    <thead>
                        <tr>
                            <th>
                                <i class="fas fa-file-archive me-2"></i>
                                Backup Name
                            </th>
                            <th>
                                <i class="fas fa-tag me-2"></i>
                                Type
                            </th>
                            <th>
                                <i class="fas fa-weight-hanging me-2"></i>
                                Size
                            </th>
                            <th>
                                <i class="fas fa-calendar me-2"></i>
                                Date Created
                            </th>
                            <th>
                                <i class="fas fa-cogs me-2"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backups as $backup)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-archive text-primary me-2"></i>
                                        <span class="fw-medium">{{ $backup['name'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($backup['type'] === 'Full Backup')
                                        <span class="badge primary">{{ $backup['type'] }}</span>
                                    @elseif($backup['type'] === 'Database Only')
                                        <span class="badge success">{{ $backup['type'] }}</span>
                                    @elseif($backup['type'] === 'Files Only')
                                        <span class="badge warning">{{ $backup['type'] }}</span>
                                    @else
                                        <span class="badge secondary">{{ $backup['type'] }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-medium">{{ $backup['size'] }}</span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $backup['date'] }}</span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('admin.backup.download', $backup['name']) }}" 
                                           class="action-btn download" 
                                           title="Download Backup"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button type="button" 
                                                class="action-btn delete btn-delete-backup" 
                                                data-filename="{{ $backup['name'] }}"
                                                title="Delete Backup"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="empty-title">No Backups Found</h3>
                <p class="empty-description">
                    You haven't created any backups yet. Use the options above to create your first backup and ensure your data is protected.
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-cog fa-spin me-2"></i>
                    Creating Backup...
                </h5>
            </div>
            <div class="modal-body text-center">
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-animated" 
                         role="progressbar" 
                         style="width: 100%">
                    </div>
                </div>
                <p class="text-muted mb-2">Please wait while we create your backup...</p>
                <small class="text-muted">This may take a few minutes depending on the size of your data.</small>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to delete this backup?</p>
                <div class="alert alert-info">
                    <strong>File:</strong> <span id="deleteFileName"></span>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This action cannot be undone!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash me-2"></i>
                    Delete Backup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('scripts')
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('Backup page loaded');
    
    // Check if required libraries are loaded
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded');
        return;
    }
    
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert2 is not loaded');
        // Fallback to basic alerts
        window.Swal = {
            fire: function(options) {
                if (typeof options === 'object') {
                    alert(options.title + '\n' + (options.text || options.html || ''));
                } else {
                    alert(options);
                }
                return Promise.resolve();
            }
        };
    }
    
    // Initialize tooltips
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Initialize DataTable if table exists
    if ($('#backupsTable').length > 0) {
        try {
            $('#backupsTable').DataTable({
                "order": [[ 3, "desc" ]], // Sort by date descending
                "pageLength": 10,
                "responsive": true,
                "language": {
                    "search": "Search backups:",
                    "lengthMenu": "Show _MENU_ backups per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ backups",
                    "infoEmpty": "No backups available",
                    "infoFiltered": "(filtered from _MAX_ total backups)",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });
            console.log('DataTable initialized');
        } catch (e) {
            console.error('DataTable initialization failed:', e);
        }
    }

    // Backup creation
    $('.btn-backup').click(function(e) {
        e.preventDefault();
        console.log('Backup button clicked');
        
        const type = $(this).data('type');
        const button = $(this);
        
        console.log('Backup type:', type);
        
        // Check CSRF token
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'CSRF token not found. Please refresh the page.'
            });
            return;
        }
        
        // Show confirmation
        Swal.fire({
            title: 'Create Backup?',
            text: `Are you sure you want to create a ${type} backup?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Create Backup',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                createBackup(type, button, csrfToken);
            }
        });
    });

    function createBackup(type, button, csrfToken) {
        // Show progress modal
        const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
        progressModal.show();
        
        // Disable button
        button.prop('disabled', true);
        button.addClass('loading');
        
        console.log('Making AJAX request to:', `/admin/backup/create-${type}`);
        
        // Make AJAX request
        $.ajax({
            url: `/admin/backup/create-${type}`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            timeout: 300000, // 5 minutes timeout
            beforeSend: function() {
                console.log('AJAX request started');
            },
            success: function(response) {
                console.log('AJAX success:', response);
                progressModal.hide();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Backup Created Successfully!',
                        html: `
                            <div class="text-start">
                                <p class="mb-3">${response.message}</p>
                                <div class="alert alert-info">
                                    <strong>File:</strong> ${response.backup_name}<br>
                                    <strong>Size:</strong> ${response.size}
                                </div>
                            </div>
                        `,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#667eea'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Backup Failed',
                        text: response.message || 'Unknown error occurred',
                        confirmButtonColor: '#ef4444'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', xhr, status, error);
                progressModal.hide();
                
                let errorMessage = 'An error occurred while creating backup.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        const errorData = JSON.parse(xhr.responseText);
                        errorMessage = errorData.message || errorMessage;
                    } catch (e) {
                        errorMessage = `Server error (${xhr.status}): ${xhr.statusText}`;
                    }
                } else if (status === 'timeout') {
                    errorMessage = 'Request timeout. The backup process may still be running.';
                } else {
                    errorMessage = `Network error: ${error}`;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Backup Failed',
                    text: errorMessage,
                    confirmButtonColor: '#ef4444'
                });
            },
            complete: function() {
                console.log('AJAX request completed');
                button.prop('disabled', false);
                button.removeClass('loading');
            }
        });
    }

    // Delete backup
    $('.btn-delete-backup').click(function(e) {
        e.preventDefault();
        const filename = $(this).data('filename');
        $('#deleteFileName').text(filename);
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
        
        $('#confirmDelete').off('click').on('click', function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                url: '/admin/backup/delete',
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    filename: filename
                }),
                success: function(response) {
                    deleteModal.hide();
                    
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false,
                            confirmButtonColor: '#10b981'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Delete Failed',
                            text: response.message,
                            confirmButtonColor: '#ef4444'
                        });
                    }
                },
                error: function(xhr) {
                    deleteModal.hide();
                    
                    let errorMessage = 'An error occurred while deleting the backup.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete Failed',
                        text: errorMessage,
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        });
    });
    
    // Test button functionality
    console.log('Found backup buttons:', $('.btn-backup').length);
    console.log('CSRF token:', $('meta[name="csrf-token"]').attr('content'));
});
</script>
@endpush