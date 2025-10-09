@extends('layouts.admin')

@section('title', 'Manajemen Siswa')

@push('styles')
<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --secondary-color: #8b5cf6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --light-bg: #f8fafc;
        --white: #ffffff;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    .dark {
        --light-bg: #1f2937;
        --white: #374151;
        --gray-50: #374151;
        --gray-100: #4b5563;
        --gray-200: #6b7280;
        --gray-300: #9ca3af;
        --gray-400: #d1d5db;
        --gray-500: #e5e7eb;
        --gray-600: #f3f4f6;
        --gray-700: #f9fafb;
        --gray-800: #ffffff;
        --gray-900: #ffffff;
    }

    .page-container {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .main-card {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        margin: 0 auto;
        max-width: 1400px;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }

    .header-actions {
        position: relative;
        z-index: 3;
        margin-top: 1.5rem;
    }

    .btn-primary-custom {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-custom:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        padding: 2rem;
        background: var(--gray-50);
    }

    .stat-card {
        background: var(--white);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        opacity: 0.1;
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--gray-600);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .content-section {
        padding: 2rem;
    }

    .filters-card {
        background: var(--white);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        border: 1px solid var(--gray-200);
    }

    .filters-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    .form-control, .form-select {
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--white);
        color: var(--gray-800);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    .btn-filter {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-search {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
    }

    .btn-search:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--secondary-color));
        color: white;
        transform: translateY(-2px);
    }

    .btn-reset {
        background: var(--gray-100);
        color: var(--gray-700);
        border: 2px solid var(--gray-200);
    }

    .btn-reset:hover {
        background: var(--gray-200);
        color: var(--gray-800);
        transform: translateY(-2px);
    }

    .table-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid var(--gray-200);
    }

    .table-header {
        background: var(--gray-50);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    .table-info {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .students-table {
        width: 100%;
        border-collapse: collapse;
    }

    .students-table thead {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
    }

    .students-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .students-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--gray-200);
        vertical-align: middle;
        color: var(--gray-800);
    }

    .students-table tbody tr {
        transition: all 0.2s ease;
    }

    .students-table tbody tr:hover {
        background: var(--gray-50);
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--gray-200);
    }

    .student-initials {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 700;
    }

    .student-name {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.25rem;
    }

    .student-email {
        color: var(--gray-600);
        font-size: 0.75rem;
    }

    .class-badge {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
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
        background: var(--gray-200);
        color: var(--gray-700);
    }

    .dark .status-active {
        background: #14532d;
        color: #bbf7d0;
    }

    .dark .status-inactive {
        background: #78350f;
        color: #fde68a;
    }

    .dark .status-graduated {
        background: var(--gray-600);
        color: var(--gray-300);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all 0.2s ease;
        text-decoration: none;
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

    .dark .btn-view {
        background: #1e3a8a;
        color: #bfdbfe;
    }

    .dark .btn-edit {
        background: #92400e;
        color: #fde68a;
    }

    .dark .btn-delete {
        background: #991b1b;
        color: #fecaca;
    }

    .floating-add-btn {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 1.5rem;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
        z-index: 1000;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .floating-add-btn:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-xl);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-600);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .bulk-actions {
        background: #eff6ff;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        display: none;
        align-items: center;
        gap: 1rem;
    }

    .bulk-actions.show {
        display: flex;
    }

    .dark .bulk-actions {
        background: #1e3a8a;
    }

    .filter-stats {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.875rem;
    }

    .dark .filter-stats {
        background: #1e3a8a;
        border-color: #3730a3;
    }

    .clear-filters {
        color: var(--danger-color);
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

    .dark .clear-filters:hover {
        background: #991b1b;
        color: #fecaca;
    }

    @media (max-width: 768px) {
        .page-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
            text-align: center;
        }

        .page-title {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            padding: 1rem;
            gap: 1rem;
        }

        .content-section {
            padding: 1rem;
        }

        .table-card {
            overflow-x: auto;
        }

        .students-table {
            min-width: 800px;
        }
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    .fade-in:nth-child(1) { animation-delay: 0.1s; }
    .fade-in:nth-child(2) { animation-delay: 0.2s; }
    .fade-in:nth-child(3) { animation-delay: 0.3s; }
    .fade-in:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="main-card">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="page-title">
                        <i class="fas fa-graduation-cap me-3"></i>Manajemen Siswa
                    </h1>
                    <p class="page-subtitle">
                        Kelola data siswa dengan mudah dan efisien
                    </p>
                </div>
                <div class="header-actions">
                    <button type="button" onclick="exportStudents()" class="btn-primary-custom me-2">
                        <i class="fas fa-download"></i>
                        Export CSV
                    </button>
                    <a href="{{ route('admin.students.create') }}" class="btn-primary-custom">
                        <i class="fas fa-plus"></i>
                        Tambah Siswa
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card fade-in">
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-number">{{ $stats['grade_10'] }}</div>
                <div class="stat-label">Kelas 10</div>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-number">{{ $stats['grade_11'] }}</div>
                <div class="stat-label">Kelas 11</div>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-number">{{ $stats['grade_12'] }}</div>
                <div class="stat-label">Kelas 12</div>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-number">{{ $stats['tkj'] }}</div>
                <div class="stat-label">TKJ</div>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-number">{{ $stats['rpl'] }}</div>
                <div class="stat-label">RPL</div>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-number">{{ $stats['dkv'] }}</div>
                <div class="stat-label">DKV</div>
            </div>
            <div class="stat-card fade-in">
                <div class="stat-number">{{ $stats['active'] }}</div>
                <div class="stat-label">Aktif</div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <!-- Filters -->
            <div class="filters-card fade-in">
                <h3 class="filters-title">
                    <div class="filter-icon">
                        <i class="fas fa-filter"></i>
                    </div>
                    Filter & Pencarian
                </h3>
                
                <form method="GET" class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Tingkat</label>
                        <select name="grade" class="form-select">
                            <option value="">Semua Tingkat</option>
                            <option value="10" {{ request('grade') == '10' ? 'selected' : '' }}>Kelas 10</option>
                            <option value="11" {{ request('grade') == '11' ? 'selected' : '' }}>Kelas 11</option>
                            <option value="12" {{ request('grade') == '12' ? 'selected' : '' }}>Kelas 12</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">Jurusan</label>
                        <select name="major" class="form-select">
                            <option value="">Semua Jurusan</option>
                            <option value="TKJ" {{ request('major') == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                            <option value="RPL" {{ request('major') == 'RPL' ? 'selected' : '' }}>RPL</option>
                            <option value="DKV" {{ request('major') == 'DKV' ? 'selected' : '' }}>DKV</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">Kelas</label>
                        <select name="class" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach($allClasses as $classOption)
                                <option value="{{ $classOption->id }}" {{ request('class') == $classOption->id ? 'selected' : '' }}>
                                    {{ $classOption->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="graduated" {{ request('status') == 'graduated' ? 'selected' : '' }}>Lulus</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Pencarian</label>
                        <div class="d-flex gap-2">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari nama, NIS, NISN, email..." 
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn-filter btn-search">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.students.index') }}" class="btn-filter btn-reset">
                                <i class="fas fa-undo"></i>
                            </a>
                        </div>
                    </div>
                </form>
                
                @if(request()->hasAny(['grade', 'major', 'class', 'status', 'search']))
                    <div class="filter-stats">
                        <i class="fas fa-info-circle text-primary"></i>
                        <span>
                            Filter aktif - Menampilkan {{ $students->total() }} dari {{ $stats['total'] }} siswa
                        </span>
                        <a href="{{ route('admin.students.index') }}" class="clear-filters">
                            <i class="fas fa-times"></i> Hapus Filter
                        </a>
                    </div>
                @endif
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Students Table -->
            @if($students->count() > 0)
                <div class="table-card fade-in">
                    <div class="table-header">
                        <div>
                            <h5 class="table-title">Daftar Siswa</h5>
                            <div class="table-info">
                                {{ $students->total() }} siswa ditemukan
                            </div>
                        </div>
                        <div>
                            <button type="button" onclick="exportStudents()" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download me-1"></i>Export CSV
                            </button>
                        </div>
                    </div>

                    <div class="bulk-actions" id="bulkActions">
                        <span id="selectedCount">0</span> siswa dipilih
                        <div class="ms-auto d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-success" onclick="bulkAction('activate')">
                                <i class="fas fa-user-check"></i> Aktifkan
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

                    <table class="students-table">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th width="60">Foto</th>
                                <th>Nama & Email</th>
                                <th width="100">NIS</th>
                                <th width="100">NISN</th>
                                <th width="120">Kelas</th>
                                <th width="100">Status</th>
                                <th width="120">Telepon</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input student-checkbox" 
                                               value="{{ $student->id }}">
                                    </td>
                                    <td>
                                        @if($student->photo)
                                            <img src="{{ $student->photo_url }}" alt="{{ $student->name }}" class="student-avatar">
                                        @else
                                            <div class="student-initials">{{ $student->initials }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="student-name">{{ $student->name }}</div>
                                        @if($student->email)
                                            <div class="student-email">{{ $student->email }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <code>{{ $student->nis }}</code>
                                    </td>
                                    <td>
                                        @if($student->nisn)
                                            <code>{{ $student->nisn }}</code>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($student->class)
                                            <span class="class-badge">{{ $student->class->name }}</span>
                                        @else
                                            <span class="text-muted">Belum ada kelas</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $student->status }}">
                                            {{ $student->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($student->phone)
                                            <a href="tel:{{ $student->phone }}" class="text-decoration-none">
                                                {{ $student->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.students.show', $student) }}" 
                                               class="btn-action btn-view" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.students.edit', $student) }}" 
                                               class="btn-action btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn-action btn-delete" 
                                                    onclick="deleteStudent({{ $student->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($students->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $students->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="table-card fade-in">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3>Belum Ada Data Siswa</h3>
                        <p>Mulai tambahkan data siswa untuk mengelola informasi mereka.</p>
                        <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Tambah Siswa Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Floating Add Button -->
<a href="{{ route('admin.students.create') }}" class="floating-add-btn" title="Tambah Siswa Baru">
    <i class="fas fa-plus"></i>
</a>

<!-- Forms -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="bulkActionForm" method="POST" action="{{ route('admin.students.bulk-action') }}" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkActionType">
    <input type="hidden" name="student_ids" id="bulkStudentIds">
</form>
@endsection

@push('scripts')
<script>
function exportStudents() {
    // Get current filters from URL
    const params = new URLSearchParams(window.location.search);
    
    // Show loading notification
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Exporting...',
            text: 'Sedang menyiapkan file CSV data siswa',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
    
    // Test route accessibility first
    const testUrl = '{{ route("admin.students.test-export") }}';
    
    fetch(testUrl, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Route test failed: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Route test successful:', data);
        
        // Proceed with actual export
        const downloadUrl = '{{ route("admin.students.export") }}?' + params.toString();
        
        // Use fetch to handle errors better
        fetch(downloadUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Export failed: ' + response.status + ' ' + response.statusText);
            }
            return response.blob();
        })
        .then(blob => {
            // Create download link
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            
            // Generate filename based on current filters
            let filename = 'data-siswa';
            
            const grade = params.get('grade');
            if (grade) {
                filename += '-kelas-' + grade;
            }
            
            const major = params.get('major');
            if (major) {
                filename += '-' + major.toLowerCase();
            }
            
            const status = params.get('status');
            if (status) {
                filename += '-' + status;
            }
            
            filename += '-' + new Date().toISOString().split('T')[0] + '.csv';
            link.download = filename;
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Clean up
            window.URL.revokeObjectURL(url);
            
            // Show success message
            if (typeof Swal !== 'undefined') {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Export Berhasil!',
                    text: 'File CSV data siswa telah didownload',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert('File CSV data siswa berhasil didownload!');
            }
        })
        .catch(error => {
            console.error('Export error:', error);
            
            if (typeof Swal !== 'undefined') {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Export Gagal!',
                    text: 'Terjadi kesalahan: ' + error.message,
                    confirmButtonText: 'OK'
                });
            } else {
                alert('Export gagal: ' + error.message);
            }
        });
    })
    .catch(error => {
        console.error('Route test error:', error);
        
        if (typeof Swal !== 'undefined') {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Route Error!',
                text: 'Route export tidak dapat diakses: ' + error.message,
                confirmButtonText: 'OK'
            });
        } else {
            alert('Route error: ' + error.message);
        }
    });
}

function deleteStudent(studentId) {
    if (confirm('Apakah Anda yakin ingin menghapus siswa ini? Data yang dihapus tidak dapat dikembalikan.')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/students/${studentId}`;
        form.submit();
    }
}

function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
    
    if (checkedBoxes.length === 0) {
        alert('Pilih minimal satu siswa untuk melakukan aksi ini.');
        return;
    }

    let confirmMessage = '';
    switch(action) {
        case 'delete':
            confirmMessage = `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} siswa yang dipilih?`;
            break;
        case 'activate':
            confirmMessage = `Apakah Anda yakin ingin mengaktifkan ${checkedBoxes.length} siswa yang dipilih?`;
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

// Bulk selection functionality
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
    }

    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAll();
            updateBulkActions();
        });
    });

    function updateSelectAll() {
        if (selectAllCheckbox) {
            const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
            const totalCount = studentCheckboxes.length;
            
            selectAllCheckbox.checked = checkedCount === totalCount;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
        }
    }

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (bulkActions && selectedCount) {
            if (count > 0) {
                bulkActions.classList.add('show');
                selectedCount.textContent = count;
            } else {
                bulkActions.classList.remove('show');
            }
        }
    }
});
</script>
@endpush