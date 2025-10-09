@extends('layouts.public')

@section('title', 'Agenda Kegiatan')

@section('content')
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
        url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2032&q=80') center/cover no-repeat;
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
    
    .hero-section .container {
        position: relative;
        z-index: 2;
    }
    
    .hero-section h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.5);
    }
    
    .hero-section .lead {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        font-weight: 400;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .hero-icon {
        font-size: 8rem;
        opacity: 0.8;
        background: linear-gradient(135deg, rgba(255,255,255,0.6), rgba(255,255,255,0.2));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: float 6s ease-in-out infinite;
        text-shadow: 0 0 20px rgba(255,255,255,0.3);
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Enhanced Animation Styles */
    .fade-in-up {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-left {
        opacity: 0;
        transform: translateX(-40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-right {
        opacity: 0;
        transform: translateX(40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in {
        opacity: 0;
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .scale-in {
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Animation Active States */
    .fade-in-up.animate,
    .fade-in-left.animate,
    .fade-in-right.animate {
        opacity: 1;
        transform: translate(0, 0);
    }
    
    .fade-in.animate {
        opacity: 1;
    }
    
    .scale-in.animate {
        opacity: 1;
        transform: scale(1);
    }
    
    /* Enhanced Stats Section matching profile page */
    .stats-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        position: relative;
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .stats-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd, #20c997, #ffc107, #0dcaf0);
        transform: scaleX(0);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .stats-card:hover::before {
        transform: scaleX(1);
    }
    
    .stats-icon {
        transition: all 0.3s ease;
    }
    
    .stats-card:hover .stats-icon {
        transform: scale(1.1) rotateY(360deg);
    }
    
    .stats-number {
        font-family: 'Arial', monospace;
        font-weight: 900 !important;
        letter-spacing: -2px;
        line-height: 1;
        transition: all 0.3s ease;
    }
    
    .stats-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    /* Enhanced Filter Section */
    .filter-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        padding: 2rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    
    .filter-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(13, 110, 253, 0.05) 0%, transparent 70%),
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .filter-section:hover::before {
        opacity: 1;
    }
    
    .filter-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
    }
    
    .filter-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        border-radius: 2px;
    }
    
    .form-control-enhanced {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }
    
    .form-control-enhanced:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.1);
        background: white;
        transform: translateY(-2px);
    }
    
    .btn-filter {
        background: var(--gradient-primary);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
        cursor: pointer;
        position: relative;
        z-index: 10;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        z-index: 10;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }
    
    /* Active Filters Styling */
    .badge {
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .bg-primary {
        background-color: var(--secondary-color) !important;
    }
    
    .bg-success {
        background-color: #10b981 !important;
    }
    
    .bg-info {
        background-color: #0ea5e9 !important;
    }
    
    .bg-warning {
        background-color: #f59e0b !important;
    }

    /* Enhanced Agenda Cards */
    .agenda-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        margin-bottom: 2rem;
    }
    
    .agenda-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(49, 130, 206, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1;
    }
    
    .agenda-card:hover::before {
        opacity: 1;
    }
    
    .agenda-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }
    
    .agenda-date-badge {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        background: var(--gradient-primary);
        color: white;
        padding: 1rem;
        border-radius: 12px;
        text-align: center;
        min-width: 80px;
        z-index: 2;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }
    
    .agenda-day {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    
    .agenda-month {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.9;
    }
    
    .agenda-content {
        padding: 2rem;
        padding-left: 7rem;
        position: relative;
        z-index: 2;
    }
    
    .agenda-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
        line-height: 1.3;
        transition: color 0.3s ease;
    }
    
    .agenda-card:hover .agenda-title {
        color: var(--secondary-color);
    }
    
    .agenda-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: var(--dark-gray);
    }
    
    .agenda-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .agenda-description {
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .agenda-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .btn-agenda {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }
    
    .btn-primary-agenda {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }
    
    .btn-primary-agenda:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.4);
        text-decoration: none;
    }
    
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-upcoming {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .status-today {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .status-past {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
    }

    /* Section Headings */
    .section-heading {
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
        text-align: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .section-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        border-radius: 2px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--dark-gray);
    }
    
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }
    
    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }
    
    .empty-state p {
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 3rem;
    }
    
    .page-link {
        border: none;
        border-radius: 10px;
        margin: 0 0.25rem;
        padding: 0.75rem 1rem;
        color: var(--secondary-color);
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .page-link:hover {
        background: var(--secondary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }
    
    .page-item.active .page-link {
        background: var(--gradient-primary);
        border-color: var(--secondary-color);
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-section {
            padding: 60px 0;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 2.5rem;
        }
        
        .hero-icon {
            font-size: 6rem;
            margin-top: 30px;
        }
        
        .stats-number {
            font-size: 2.5rem !important;
        }
        
        .agenda-content {
            padding: 1.5rem;
            padding-top: 5rem;
        }
        
        .agenda-date-badge {
            top: 1rem;
            left: 1rem;
            min-width: 70px;
            padding: 0.75rem;
        }
        
        .agenda-day {
            font-size: 1.25rem;
        }
        
        .agenda-title {
            font-size: 1.25rem;
        }
        
        .agenda-actions {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-section {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .stats-number {
            font-size: 2rem !important;
        }
        
        .hero-section h1 {
            font-size: 2rem;
        }
        
        .agenda-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<!-- Enhanced Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fade-in-left">Agenda Kegiatan</h1>
                <p class="lead fade-in-left" style="animation-delay: 0.2s;">
                    Ikuti berbagai kegiatan dan acara menarik di SMA Negeri 1 Balong - 
                    Jangan lewatkan momen-momen penting dalam kalender sekolah
                </p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-calendar-alt hero-icon scale-in" style="animation-delay: 0.4s;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Quick Stats -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-calendar-check fa-3x text-primary stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-primary mb-2" data-target="{{ $totalAgenda }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">TOTAL AGENDA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-clock fa-3x text-warning stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-warning mb-2" data-target="{{ $upcomingAgenda }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">AGENDA MENDATANG</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.4s;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-calendar-day fa-3x text-success stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-success mb-2" data-target="{{ $todayAgenda }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">AGENDA HARI INI</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="stats-card card h-100 shadow-sm fade-in-up" style="animation-delay: 0.6s;">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt fa-3x text-info stats-icon"></i>
                        </div>
                        <h2 class="stats-number display-4 fw-bold text-info mb-2" data-target="{{ $agendaWithLocation }}">0</h2>
                        <p class="stats-label text-muted mb-0 fw-medium">DENGAN LOKASI</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <!-- Enhanced Filter Section -->
        <div class="filter-section fade-in-up">
            <h3 class="filter-title">Cari Agenda</h3>

            <form method="GET" action="{{ route('agenda.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold text-muted">Kata Kunci</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari agenda..."
                               class="form-control form-control-enhanced">
                    </div>
                    
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label fw-semibold text-muted">Periode</label>
                        <select name="period" class="form-control form-control-enhanced" onchange="handlePeriodChange()">
                            <option value="">Semua Periode</option>
                            <option value="upcoming" {{ request('period') == 'upcoming' ? 'selected' : '' }}>Mendatang</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="past" {{ request('period') == 'past' ? 'selected' : '' }}>Sudah Lewat</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label fw-semibold text-muted">Bulan</label>
                        <select name="month" class="form-control form-control-enhanced">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->locale('id')->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label fw-semibold text-muted">Tahun</label>
                        <select name="year" class="form-control form-control-enhanced">
                            <option value="">Semua Tahun</option>
                            @for($year = date('Y') + 1; $year >= date('Y') - 2; $year--)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-lg-3 col-md-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-filter flex-fill">
                                <i class="fas fa-search me-2"></i>
                                Cari
                            </button>
                            <button type="button" onclick="clearFilters()" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                Reset
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Active Filters Display -->
                @if(request()->hasAny(['search', 'period', 'month', 'year']))
                    <div class="mt-3">
                        <small class="text-muted">Filter aktif:</small>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @if(request('search'))
                                <span class="badge bg-primary">Pencarian: "{{ request('search') }}"</span>
                            @endif
                            @if(request('period'))
                                <span class="badge bg-success">Periode: {{ ucfirst(str_replace('_', ' ', request('period'))) }}</span>
                            @endif
                            @if(request('month'))
                                <span class="badge bg-info">Bulan: {{ \Carbon\Carbon::create()->month(request('month'))->locale('id')->format('F') }}</span>
                            @endif
                            @if(request('year'))
                                <span class="badge bg-warning">Tahun: {{ request('year') }}</span>
                            @endif
                        </div>
                    </div>
                @endif
            </form>
        </div>

        <!-- Sort Options -->
        @if($agendas->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0">Ditemukan {{ $agendas->total() }} agenda</h4>
                    <small class="text-muted">Menampilkan {{ $agendas->firstItem() }}-{{ $agendas->lastItem() }} dari {{ $agendas->total() }} agenda</small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <label class="form-label mb-0 fw-semibold text-muted">Urutkan:</label>
                    <select name="sort" class="form-control form-control-enhanced" style="width: auto;" onchange="handleSortChange(this.value)">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Tanggal (Terdekat)</option>
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Tanggal (Terjauh)</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                    </select>
                </div>
            </div>
        @endif
        
        <!-- Agenda List -->
        @if($agendas->count() > 0)
            <div class="row">
                <div class="col-12">
                    @foreach($agendas as $index => $agenda)
                        <div class="agenda-card fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                            <!-- Date Badge -->
                            <div class="agenda-date-badge">
                                <div class="agenda-day">{{ $agenda->event_date ? $agenda->event_date->format('d') : '?' }}</div>
                                <div class="agenda-month">{{ $agenda->event_date ? $agenda->event_date->format('M') : 'TBD' }}</div>
                            </div>
                            
                            <!-- Content -->
                            <div class="agenda-content">
                                <h3 class="agenda-title">{{ $agenda->title }}</h3>
                                
                                <div class="agenda-meta">
                                    @if($agenda->event_date)
                                        <div class="agenda-meta-item">
                                            <i class="fas fa-clock text-primary"></i>
                                            <span>{{ $agenda->event_date->format('H:i') }} WIB</span>
                                        </div>
                                        <div class="agenda-meta-item">
                                            <i class="fas fa-calendar text-success"></i>
                                            <span>{{ $agenda->event_date->format('l, d F Y') }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($agenda->location)
                                        <div class="agenda-meta-item">
                                            <i class="fas fa-map-marker-alt text-danger"></i>
                                            <span>{{ $agenda->location }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                @if($agenda->content)
                                    <div class="agenda-description">
                                        {!! Str::limit(strip_tags($agenda->content), 200) !!}
                                    </div>
                                @endif
                                
                                <div class="agenda-actions">
                                    <a href="{{ route('agenda.show', $agenda->id) }}" class="btn-agenda btn-primary-agenda">
                                        <i class="fas fa-eye"></i>
                                        Lihat Detail
                                    </a>
                                    
                                    @if($agenda->event_date)
                                        @if($agenda->event_date->isToday())
                                            <span class="status-badge status-today">Hari Ini</span>
                                        @elseif($agenda->event_date->isFuture())
                                            <span class="status-badge status-upcoming">Mendatang</span>
                                        @else
                                            <span class="status-badge status-past">Sudah Lewat</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Enhanced Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $agendas->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Enhanced Empty State -->
            <div class="empty-state fade-in-up">
                <i class="fas fa-calendar-times empty-state-icon"></i>
                <h3>Tidak ada agenda ditemukan</h3>
                <p>Belum ada agenda yang sesuai dengan kriteria pencarian Anda.</p>
                <a href="{{ route('agenda.index') }}" class="btn btn-filter">
                    <i class="fas fa-refresh me-2"></i>
                    Lihat Semua Agenda
                </a>
            </div>
        @endif
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Counter Animation Function (matching profile page)
    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        element.classList.add('counting');
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            
            const displayValue = Math.floor(current).toLocaleString();
            element.textContent = displayValue;
        }, 16);
    }
    
    // Enhanced Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .fade-in, .scale-in');
    animatedElements.forEach(element => {
        observer.observe(element);
    });
    
    // Stats counter animation with intersection observer
    const statsObserverOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statsNumbers = entry.target.querySelectorAll('.stats-number');
                
                statsNumbers.forEach((numberElement, index) => {
                    const target = parseInt(numberElement.dataset.target);
                    
                    setTimeout(() => {
                        animateCounter(numberElement, target, 2000);
                    }, index * 200);
                });
                
                statsObserver.unobserve(entry.target);
            }
        });
    }, statsObserverOptions);
    
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }
    
    // Enhanced card hover effects
    const agendaCards = document.querySelectorAll('.agenda-card');
    agendaCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
    
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Page load animation sequence
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 100);
    
    console.log('Enhanced agenda page animations loaded successfully!');
    

    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        console.log('Filter form found:', filterForm);
        console.log('Form action:', filterForm.action);
        console.log('Form method:', filterForm.method);
        
        // Add submit event listener
        filterForm.addEventListener('submit', function(e) {
            console.log('Form submitted!');
            console.log('Form data:', new FormData(this));
            
            // Log all form values
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
        });
        
        // Add click event listener to submit button
        const submitButton = filterForm.querySelector('button[type="submit"]');
        if (submitButton) {
            console.log('Submit button found:', submitButton);
            submitButton.addEventListener('click', function(e) {
                console.log('Submit button clicked!');
                // Form will submit automatically
            });
        } else {
            console.error('Submit button not found!');
        }
    } else {
        console.error('Filter form not found!');
    }
    
    // Test button functionality
    const testButtons = document.querySelectorAll('.btn-filter, .btn-secondary');
    testButtons.forEach((button, index) => {
        console.log(`Button ${index + 1}:`, button);
        console.log(`Button ${index + 1} type:`, button.type);
        console.log(`Button ${index + 1} onclick:`, button.onclick);
        
        button.addEventListener('click', function(e) {
            console.log(`Button ${index + 1} clicked!`, this);
        });
    });
});

// Filter Functions
function handlePeriodChange() {
    const periodSelect = document.querySelector('select[name="period"]');
    const monthSelect = document.querySelector('select[name="month"]');
    const yearSelect = document.querySelector('select[name="year"]');
    
    // If specific period is selected, clear month and year filters
    if (['today', 'this_week', 'this_month'].includes(periodSelect.value)) {
        monthSelect.value = '';
        yearSelect.value = '';
    }
}

function clearFilters() {
    // Clear all form inputs
    document.querySelector('input[name="search"]').value = '';
    document.querySelector('select[name="period"]').value = '';
    document.querySelector('select[name="month"]').value = '';
    document.querySelector('select[name="year"]').value = '';
    
    // Submit form to reload without filters
    document.getElementById('filterForm').submit();
}

// Auto-submit on filter change (optional)
function enableAutoFilter() {
    const filterInputs = document.querySelectorAll('#filterForm select, #filterForm input[name="search"]');
    
    filterInputs.forEach(input => {
        if (input.type === 'text') {
            // Debounce text input
            let timeout;
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 1000);
            });
        } else {
            // Immediate submit for selects
            input.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        }
    });
}

// Uncomment to enable auto-filter
// enableAutoFilter();

// Sort function
function handleSortChange(sortValue) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortValue);
    window.location.href = url.toString();
}

// Manual form submit function
function submitFilterForm() {
    console.log('Manual form submit called');
    const form = document.getElementById('filterForm');
    if (form) {
        console.log('Submitting form manually');
        form.submit();
    } else {
        console.error('Form not found for manual submit');
    }
}


function testButtonClick() {
    console.log('Test button click function called');
    alert('Button is working!');
}
</script>
@endsection