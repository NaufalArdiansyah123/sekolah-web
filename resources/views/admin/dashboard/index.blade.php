{{-- resources/views/admin/dashboard/index.blade.php - Pure Bootstrap Dashboard --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    /* Custom Bootstrap Dashboard Styles */
    :root {
        --bs-primary-rgb: 13, 110, 253;
        --bs-success-rgb: 25, 135, 84;
        --bs-info-rgb: 13, 202, 240;
        --bs-warning-rgb: 255, 193, 7;
        --bs-danger-rgb: 220, 53, 69;
        --bs-purple: #6f42c1;
        --bs-purple-rgb: 111, 66, 193;
        --bs-orange: #fd7e14;
        --bs-orange-rgb: 253, 126, 20;
        --bs-teal: #20c997;
        --bs-teal-rgb: 32, 201, 151;
    }

    /* Dashboard Header */
    .dashboard-header {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-purple));
        color: white;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .dashboard-header .content {
        position: relative;
        z-index: 2;
    }

    /* Stats Cards */
    .stats-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stats-card:hover {
        transform: translateY(-0.25rem);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .stats-card .card-body {
        padding: 1.5rem;
    }

    .stats-icon {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stats-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stats-trend {
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    /* Color variants for stats cards */
    .stats-card.primary .stats-icon {
        background: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
    }

    .stats-card.success .stats-icon {
        background: rgba(var(--bs-success-rgb), 0.1);
        color: var(--bs-success);
    }

    .stats-card.info .stats-icon {
        background: rgba(var(--bs-info-rgb), 0.1);
        color: var(--bs-info);
    }

    .stats-card.warning .stats-icon {
        background: rgba(var(--bs-warning-rgb), 0.1);
        color: var(--bs-warning);
    }

    .stats-card.purple .stats-icon {
        background: rgba(var(--bs-purple-rgb), 0.1);
        color: var(--bs-purple);
    }

    .stats-card.orange .stats-icon {
        background: rgba(var(--bs-orange-rgb), 0.1);
        color: var(--bs-orange);
    }

    /* Activity Cards */
    .activity-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        height: 100%;
    }

    .activity-card .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        padding: 1.25rem 1.5rem;
        border-radius: 1rem 1rem 0 0;
    }

    .activity-card .card-body {
        padding: 1.5rem;
    }

    .activity-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .activity-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    /* Quick Actions */
    .quick-action {
        border: 2px solid #e9ecef;
        border-radius: 1rem;
        padding: 1.5rem;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        display: block;
        text-align: center;
    }

    .quick-action:hover {
        border-color: var(--bs-primary);
        background: rgba(var(--bs-primary-rgb), 0.05);
        color: inherit;
        text-decoration: none;
        transform: translateY(-0.125rem);
    }

    .quick-action-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin: 0 auto 1rem;
    }

    .quick-action-title {
        font-size: 0.875rem;
        font-weight: 600;
        margin: 0;
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dashboard-header {
            text-align: center;
        }
        
        .stats-number {
            font-size: 1.75rem;
        }
        
        .quick-action {
            padding: 1rem;
        }
        
        .quick-action-icon {
            width: 2.5rem;
            height: 2.5rem;
        }
    }

    /* Animation for loading stats */
    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(1rem);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stats-number {
        animation: countUp 0.6s ease-out;
    }

    /* Dark mode support */
    [data-bs-theme="dark"] .stats-card {
        background: var(--bs-dark);
        border: 1px solid rgba(255, 255, 255, 0.125);
    }

    [data-bs-theme="dark"] .activity-card {
        background: var(--bs-dark);
        border: 1px solid rgba(255, 255, 255, 0.125);
    }

    [data-bs-theme="dark"] .quick-action {
        border-color: rgba(255, 255, 255, 0.125);
        background: var(--bs-dark);
    }

    [data-bs-theme="dark"] .quick-action:hover {
        border-color: var(--bs-primary);
        background: rgba(var(--bs-primary-rgb), 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="dashboard-header p-4 mb-4">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2">
                        <i class="fas fa-tachometer-alt me-3"></i>Dashboard Admin
                    </h1>
                    <p class="mb-0 opacity-75">
                        Selamat datang di panel administrasi. Kelola seluruh sistem sekolah dari sini.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="text-white-50">
                        <small>
                            <i class="fas fa-calendar me-1"></i>
                            {{ now()->format('l, d F Y') }}
                        </small>
                        <br>
                        <small>
                            <i class="fas fa-clock me-1"></i>
                            <span id="current-time">{{ now()->format('H:i:s') }}</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Posts -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card primary">
                <div class="card-body">
                    <div class="stats-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stats-number text-primary">{{ $stats['total_posts'] ?? 0 }}</div>
                    <div class="stats-label">Total Konten</div>
                    <div class="stats-trend text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <small>+12% dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card success">
                <div class="card-body">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number text-success">{{ $stats['total_users'] ?? 0 }}</div>
                    <div class="stats-label">Total Users</div>
                    <div class="stats-trend text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <small>+8% dari bulan lalu</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card purple">
                <div class="card-body">
                    <div class="stats-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stats-number" style="color: var(--bs-purple);">{{ $stats['total_students'] ?? 0 }}</div>
                    <div class="stats-label">Total Siswa</div>
                    <div class="stats-trend text-info">
                        <i class="fas fa-arrow-right me-1"></i>
                        <small>Stabil</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Teachers -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card orange">
                <div class="card-body">
                    <div class="stats-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stats-number" style="color: var(--bs-orange);">{{ $stats['total_teachers'] ?? 0 }}</div>
                    <div class="stats-label">Total Guru</div>
                    <div class="stats-trend text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <small>+2 guru baru</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity and Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Recent Posts -->
        <div class="col-lg-6">
            <div class="card activity-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-newspaper me-2 text-primary"></i>
                        Konten Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_posts']) && $stats['recent_posts']->count() > 0)
                        @foreach($stats['recent_posts'] as $post)
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="activity-icon bg-primary bg-opacity-10 text-primary me-3">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ Str::limit($post->title, 40) }}</h6>
                                        <small class="text-muted">
                                            {{ ucfirst($post->type) }} • {{ $post->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge {{ $post->status === 'active' || $post->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $post->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada konten terbaru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-6">
            <div class="card activity-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus me-2 text-success"></i>
                        User Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_users']) && $stats['recent_users']->count() > 0)
                        @foreach($stats['recent_users'] as $user)
                            <div class="activity-item">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="rounded-circle" 
                                                 width="40" height="40">
                                        @else
                                            <div class="activity-icon bg-success bg-opacity-10 text-success">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                        <small class="text-muted">
                                            {{ $user->email }} • {{ $user->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $user->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada user baru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card activity-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Create Slideshow -->
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.posts.slideshow.create') }}" class="quick-action">
                                <div class="quick-action-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-images"></i>
                                </div>
                                <h6 class="quick-action-title">Buat Slideshow</h6>
                            </a>
                        </div>

                        <!-- Write Blog -->
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.posts.blog.create') }}" class="quick-action">
                                <div class="quick-action-icon bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-pen-fancy"></i>
                                </div>
                                <h6 class="quick-action-title">Tulis Blog</h6>
                            </a>
                        </div>

                        <!-- Add Student -->
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.students.create') }}" class="quick-action">
                                <div class="quick-action-icon bg-opacity-10 text-purple" style="background: rgba(var(--bs-purple-rgb), 0.1); color: var(--bs-purple);">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <h6 class="quick-action-title">Tambah Siswa</h6>
                            </a>
                        </div>

                        <!-- Add User -->
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.users.create') }}" class="quick-action">
                                <div class="quick-action-icon bg-opacity-10" style="background: rgba(var(--bs-orange-rgb), 0.1); color: var(--bs-orange);">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <h6 class="quick-action-title">Tambah User</h6>
                            </a>
                        </div>

                        <!-- Manage QR Attendance -->
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.qr-attendance.index') }}" class="quick-action">
                                <div class="quick-action-icon bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <h6 class="quick-action-title">QR Absensi</h6>
                            </a>
                        </div>

                        <!-- School Settings -->
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.school-info.index') }}" class="quick-action">
                                <div class="quick-action-icon bg-warning bg-opacity-10 text-warning">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <h6 class="quick-action-title">Pengaturan</h6>
                            </a>
                        </div>

                        <!-- View Reports -->
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="quick-action" onclick="alert('Fitur laporan akan segera hadir!')">
                                <div class="quick-action-icon bg-danger bg-opacity-10 text-danger">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h6 class="quick-action-title">Laporan</h6>
                            </a>
                        </div>

                        <!-- Backup Data -->
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="quick-action" onclick="alert('Fitur backup akan segera hadir!')">
                                <div class="quick-action-icon bg-secondary bg-opacity-10 text-secondary">
                                    <i class="fas fa-download"></i>
                                </div>
                                <h6 class="quick-action-title">Backup Data</h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card activity-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-server me-2 text-info"></i>
                        Status Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Server Status</span>
                        <span class="badge bg-success">Online</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Database</span>
                        <span class="badge bg-success">Connected</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Storage</span>
                        <span class="badge bg-warning">75% Used</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Last Backup</span>
                        <small class="text-muted">2 hours ago</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card activity-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2 text-primary"></i>
                        Aktivitas Mingguan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="weeklyActivityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID');
        document.getElementById('current-time').textContent = timeString;
    }
    
    // Update time every second
    setInterval(updateTime, 1000);
    
    // Initialize weekly activity chart
    const ctx = document.getElementById('weeklyActivityChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Login Users',
                    data: [12, 19, 15, 25, 22, 18, 8],
                    borderColor: 'rgb(13, 110, 253)',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4
                }, {
                    label: 'New Content',
                    data: [2, 3, 1, 5, 4, 2, 1],
                    borderColor: 'rgb(25, 135, 84)',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    // Add hover effects to stats cards
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-0.5rem)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Animate numbers on page load
    const statsNumbers = document.querySelectorAll('.stats-number');
    statsNumbers.forEach(number => {
        const finalValue = parseInt(number.textContent);
        let currentValue = 0;
        const increment = finalValue / 50;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            number.textContent = Math.floor(currentValue);
        }, 30);
    });
});
</script>
@endpush