@extends('layouts.admin')

@section('content')
<style>
    /* Enhanced Dashboard Styles */
    .dashboard-container {
        background: var(--bg-secondary);
        min-height: calc(100vh - 200px);
        transition: all 0.3s ease;
        padding: 1.5rem;
    }
    
    /* Welcome Section */
    .welcome-section {
        background: linear-gradient(135deg, var(--bg-primary) 0%, rgba(59, 130, 246, 0.05) 100%);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .dark .welcome-section {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    
    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }
    
    .welcome-content {
        position: relative;
        z-index: 2;
    }
    
    .welcome-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--text-primary), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }
    
    .welcome-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    
    .welcome-time {
        display: inline-flex;
        align-items: center;
        background: rgba(59, 130, 246, 0.1);
        color: var(--accent-color);
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    /* Stats Cards - 4 Cards in a Row */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    /* Responsive breakpoints for stats grid */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .stat-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        min-height: 140px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .dark .stat-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: var(--accent-color);
    }
    
    .dark .stat-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-color), #8b5cf6);
        border-radius: 16px 16px 0 0;
    }
    
    /* Different colors for each card */
    .stat-card:nth-child(1)::before {
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    }
    
    .stat-card:nth-child(2)::before {
        background: linear-gradient(90deg, #10b981, #059669);
    }
    
    .stat-card:nth-child(3)::before {
        background: linear-gradient(90deg, #8b5cf6, #7c3aed);
    }
    
    .stat-card:nth-child(4)::before {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }
    
    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1;
    }
    
    .stat-label {
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }
    
    .stat-change {
        display: flex;
        align-items: center;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .stat-change.positive {
        color: #10b981;
    }
    
    .stat-change.negative {
        color: #ef4444;
    }
    
    /* Chart Cards */
    .chart-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    @media (max-width: 1024px) {
        .chart-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .chart-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .dark .chart-card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .chart-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .dark .chart-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .chart-header {
        display: flex;
        align-items: center;
        justify-content: between;
        margin-bottom: 1.5rem;
    }
    
    .chart-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .chart-subtitle {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    /* Activity Feed */
    .activity-item {
        display: flex;
        align-items: flex-start;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-item:hover {
        background: rgba(59, 130, 246, 0.02);
        border-radius: 8px;
        margin: 0 -0.5rem;
        padding: 1rem 0.5rem;
    }
    
    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .activity-content {
        flex: 1;
        min-width: 0;
    }
    
    .activity-title {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    
    .activity-description {
        color: var(--text-secondary);
        font-size: 0.75rem;
        line-height: 1.4;
    }
    
    .activity-time {
        color: var(--text-tertiary);
        font-size: 0.75rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
    
    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .quick-action {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    
    .quick-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .quick-action:hover::before {
        left: 100%;
    }
    
    .quick-action:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        border-color: var(--accent-color);
        text-decoration: none;
    }
    
    .quick-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        transition: all 0.3s ease;
    }
    
    .quick-action:hover .quick-action-icon {
        transform: scale(1.1);
    }
    
    .quick-action-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    
    .quick-action-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 480px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="welcome-subtitle">
                Kelola sistem administrasi SMA Negeri 1 Balong dengan mudah dan efisien
            </p>
            <div class="welcome-time">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ now()->format('l, d F Y - H:i') }}
            </div>
        </div>
    </div>

    <!-- Statistics Cards - 4 Cards in a Row -->
    <div class="stats-grid">
        <!-- Card 1: Total Siswa -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon bg-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['total_students']) }}</div>
            <div class="stat-label">Total Siswa</div>
            <div class="stat-change positive">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $stats['active_students'] }} siswa aktif
            </div>
        </div>

        <!-- Card 2: Total Guru -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['total_teachers']) }}</div>
            <div class="stat-label">Total Guru & Staff</div>
            <div class="stat-change positive">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $stats['active_teachers'] }} guru aktif
            </div>
        </div>

        <!-- Card 3: Total Artikel -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon bg-purple-100">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ number_format($stats['total_posts']) }}</div>
            <div class="stat-label">Artikel & Berita</div>
            <div class="stat-change positive">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ $stats['published_posts'] }} dipublikasi
            </div>
        </div>

        <!-- Card 4: Prestasi Siswa -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon bg-yellow-100">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-value">42</div>
            <div class="stat-label">Prestasi Siswa</div>
            <div class="stat-change positive">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                +5 prestasi baru
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('admin.posts.blog') }}" class="quick-action">
            <div class="quick-action-icon bg-blue-100">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
            </div>
            <div class="quick-action-title">Tulis Artikel</div>
            <div class="quick-action-description">Buat artikel atau berita baru</div>
        </a>

        <a href="{{ route('admin.students.index') }}" class="quick-action">
            <div class="quick-action-icon bg-green-100">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="quick-action-title">Kelola Siswa</div>
            <div class="quick-action-description">Tambah atau edit data siswa</div>
        </a>

        <a href="{{ route('admin.gallery.upload') }}" class="quick-action">
            <div class="quick-action-icon bg-purple-100">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="quick-action-title">Upload Foto</div>
            <div class="quick-action-description">Tambah foto ke galeri</div>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="quick-action">
            <div class="quick-action-icon bg-gray-100">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="quick-action-title">Pengaturan</div>
            <div class="quick-action-description">Konfigurasi sistem</div>
        </a>
    </div>

    <!-- Charts and Activity -->
    <div class="chart-grid">
        <!-- Upcoming Events Card -->
        <div class="chart-card">
            <x-upcoming-events-card :limit="5" :showHeader="true" />
        </div>

        <!-- Recent Activity -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Aktivitas Terbaru</h3>
            </div>
            <div class="space-y-1">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="activity-item">
                            <div class="activity-icon 
                                @if($notification->action == 'create') bg-green-100
                                @elseif($notification->action == 'update') bg-yellow-100
                                @elseif($notification->action == 'delete') bg-red-100
                                @elseif($notification->action == 'upload') bg-blue-100
                                @else bg-gray-100
                                @endif">
                                <i class="{{ $notification->icon }} text-sm"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $notification->title }}</div>
                                <div class="activity-description">{{ Str::limit($notification->message, 50) }}</div>
                            </div>
                            <div class="activity-time">{{ $notification->time_ago }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="activity-item">
                        <div class="activity-icon bg-blue-100">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Sistem siap digunakan</div>
                            <div class="activity-description">Dashboard admin telah berhasil dimuat</div>
                        </div>
                        <div class="activity-time">sekarang</div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon bg-green-100">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Mulai kelola data</div>
                            <div class="activity-description">Tambah siswa, guru, atau konten baru</div>
                        </div>
                        <div class="activity-time">-</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Additional Dashboard Section -->
   
</div>

<script>
    // Add some interactivity
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stats on load
        const statValues = document.querySelectorAll('.stat-value');
        statValues.forEach((stat, index) => {
            const finalValue = parseInt(stat.textContent.replace(/,/g, ''));
            let currentValue = 0;
            const increment = finalValue / 50;
            
            // Delay animation for each card
            setTimeout(() => {
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        stat.textContent = finalValue.toLocaleString();
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(currentValue).toLocaleString();
                    }
                }, 30);
            }, index * 200);
        });

        // Add entrance animation to cards
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
    });
</script>
@endsection