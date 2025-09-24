@extends('layouts.public')

@section('title', 'Kalender Akademik')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        padding: 4rem 0;
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
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>') no-repeat bottom;
        background-size: cover;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }
    
    .hero-icon {
        font-size: 5rem;
        opacity: 0.8;
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .stats-section {
        background: #f8fafc;
        padding: 3rem 0;
        margin-top: -2rem;
        position: relative;
        z-index: 3;
    }
    
    .stat-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
    }
    
    .stat-icon {
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: white;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6b7280;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .calendar-section {
        padding: 4rem 0;
        background: white;
    }
    
    .calendar-container {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }
    
    .calendar-header {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .calendar-body {
        padding: 2rem;
    }
    
    .sidebar-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .sidebar-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
    }
    
    .sidebar-card .card-header {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: white;
        padding: 1.5rem;
        border: none;
    }
    
    .sidebar-card .card-body {
        padding: 1.5rem;
    }
    
    .card-title {
        font-size: 1.125rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-enhanced {
        border-radius: 0.75rem;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }
    
    .btn-enhanced:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    .btn-primary-enhanced {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: white;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
    
    .btn-primary-enhanced:hover {
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        color: white;
    }
    
    .btn-outline-enhanced {
        background: transparent;
        color: #3b82f6;
        border: 2px solid #3b82f6;
    }
    
    .btn-outline-enhanced:hover {
        background: #3b82f6;
        color: white;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }
    
    .legend-item:hover {
        background: #f8fafc;
        transform: translateX(5px);
    }
    
    .legend-color {
        width: 1rem;
        height: 1rem;
        border-radius: 0.25rem;
        margin-right: 0.75rem;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        border: 2px solid white;
    }
    
    .legend-text {
        font-weight: 500;
        color: #1f2937;
    }
    
    .upcoming-event {
        padding: 1rem;
        border-left: 4px solid #3b82f6;
        background: #f8fafc;
        border-radius: 0 0.5rem 0.5rem 0;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
    }
    
    .upcoming-event:hover {
        background: #e0f2fe;
        transform: translateX(5px);
    }
    
    .upcoming-event-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }
    
    .upcoming-event-date {
        font-size: 0.8rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .info-item {
        text-align: center;
        padding: 1rem;
        border-radius: 0.5rem;
        background: #f8fafc;
        margin-bottom: 1rem;
    }
    
    .info-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .info-value {
        font-size: 0.9rem;
        color: #6b7280;
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
    
    /* FullCalendar Overrides */
    .fc {
        font-family: inherit;
    }
    
    .fc-toolbar {
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        flex-wrap: wrap;
    }
    
    .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
    }
    
    .fc-button {
        background: #3b82f6 !important;
        border: none !important;
        border-radius: 0.5rem !important;
        font-weight: 600 !important;
        padding: 0.5rem 1rem !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
    }
    
    .fc-button:hover {
        background: #1e40af !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1) !important;
    }
    
    .fc-button:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3) !important;
    }
    
    .fc-event {
        border-radius: 0.375rem !important;
        border: none !important;
        font-weight: 600 !important;
        font-size: 0.875rem !important;
        padding: 0.25rem 0.5rem !important;
        margin: 0.125rem 0 !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
    }
    
    .fc-event:hover {
        transform: scale(1.02) !important;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1) !important;
    }
    
    .fc-day-today {
        background-color: rgba(59, 130, 246, 0.1) !important;
    }
    
    .fc-day-today .fc-daygrid-day-number {
        background: #3b82f6;
        color: white;
        border-radius: 50%;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin: 0.25rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .hero-icon {
            font-size: 3rem;
        }
        
        .stats-section {
            padding: 2rem 0;
        }
        
        .calendar-section {
            padding: 2rem 0;
        }
        
        .fc-toolbar {
            flex-direction: column;
            gap: 1rem;
        }
        
        .fc-toolbar-title {
            font-size: 1.25rem;
        }
        
        .fc-button {
            font-size: 0.875rem !important;
            padding: 0.5rem 0.75rem !important;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-content">
                    <h1 class="hero-title">Kalender Akademik</h1>
                    <p class="hero-subtitle">Jadwal lengkap kegiatan akademik dan agenda sekolah tahun ajaran 2024/2025</p>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-calendar-alt hero-icon"></i>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
@if(isset($stats))
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #3b82f6;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-number text-primary">{{ $stats['total_events'] }}</div>
                    <div class="stat-label">Total Event</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #10b981;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number text-success">{{ $stats['upcoming_events'] }}</div>
                    <div class="stat-label">Akan Datang</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #f59e0b;">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-number text-warning">{{ $stats['this_month_events'] }}</div>
                    <div class="stat-label">Bulan Ini</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #06b6d4;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-number text-info">{{ $stats['today_events'] }}</div>
                    <div class="stat-label">Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Calendar Section -->
<section class="calendar-section">
    <div class="container">
        <div class="row">
            <!-- Main Calendar -->
            <div class="col-lg-9 mb-4">
                <div class="calendar-container">
                    <div class="calendar-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Kalender Kegiatan Akademik
                        </h3>
                        <p class="mb-0 mt-2 opacity-75">Klik pada event untuk melihat detail lengkap</p>
                    </div>
                    <div class="calendar-body">
                        <div id="calendar" style="min-height: 600px;"></div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                <!-- Admin Panel -->
                @auth
                    @if(auth()->user()->hasRole(['admin', 'teacher', 'superadministrator', 'super_admin']))
                        <div class="sidebar-card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-cog"></i>
                                    Panel Admin
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-3">
                                    <a href="{{ route('admin.calendar.index') }}" class="btn btn-primary-enhanced">
                                        <i class="fas fa-cogs"></i>
                                        Kelola Kalender
                                    </a>
                                    <a href="{{ route('admin.posts.agenda') }}" class="btn btn-outline-enhanced">
                                        <i class="fas fa-list"></i>
                                        Kelola Agenda
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

                <!-- Legend -->
                <div class="sidebar-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Keterangan Warna
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #3b82f6;"></div>
                            <span class="legend-text">Event Umum</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #10b981;"></div>
                            <span class="legend-text">Agenda Sekolah</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #f59e0b;"></div>
                            <span class="legend-text">Rapat</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #ef4444;"></div>
                            <span class="legend-text">Libur</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #8b5cf6;"></div>
                            <span class="legend-text">Ujian</span>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                @if(isset($upcomingEvents) && count($upcomingEvents) > 0)
                <div class="sidebar-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-clock"></i>
                            Event Mendatang
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($upcomingEvents as $event)
                        <div class="upcoming-event">
                            <div class="upcoming-event-title">{{ $event['title'] }}</div>
                            <div class="upcoming-event-date">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($event['start'])->format('d M Y') }}
                            </div>
                            @if(isset($event['location']) && $event['location'])
                            <div class="upcoming-event-date">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $event['location'] }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quick Info -->
                <div class="sidebar-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-info"></i>
                            Informasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <div class="info-title">Hari Ini</div>
                            <div class="info-value" id="currentDate"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-title">Waktu</div>
                            <div class="info-value" id="currentTime"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-title">Tahun Ajaran</div>
                            <div class="info-value">2024/2025</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1e40af, #3b82f6); color: white;">
                <h5 class="modal-title" id="eventDetailModalLabel">
                    <i class="fas fa-info-circle"></i>
                    Detail Kegiatan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="eventDetailContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('Calendar page loaded');
    
    let calendar;
    const eventsData = @json($events ?? []);
    
    console.log('Events data:', eventsData);
    console.log('Events count:', eventsData.length);
    
    // Initialize calendar
    initializeCalendar();
    
    // Update current date and time
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    function initializeCalendar() {
        const calendarEl = document.getElementById('calendar');
        
        if (!calendarEl) {
            console.error('Calendar element not found');
            return;
        }
        
        try {
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    list: 'Daftar'
                },
                height: 'auto',
                events: eventsData,
                eventClick: function(info) {
                    showEventDetail(info.event);
                },
                eventDidMount: function(info) {
                    // Add tooltip
                    info.el.setAttribute('title', info.event.title);
                    
                    // Add custom styling based on type
                    const type = info.event.extendedProps.type;
                    if (type) {
                        info.el.classList.add('event-' + type);
                    }
                },
                loading: function(bool) {
                    if (bool) {
                        document.body.style.cursor = 'wait';
                    } else {
                        document.body.style.cursor = 'default';
                    }
                },
                eventSourceFailure: function(errorObj) {
                    console.error('Calendar event source failure:', errorObj);
                }
            });
            
            calendar.render();
            
            // Check if calendar rendered successfully
            setTimeout(() => {
                const fcView = calendarEl.querySelector('.fc-view');
                if (fcView) {
                    console.log('Calendar rendered successfully');
                } else {
                    console.error('Calendar failed to render');
                    calendarEl.innerHTML = '<div class="alert alert-warning text-center"><i class="fas fa-exclamation-triangle"></i> Kalender gagal dimuat. Silakan refresh halaman.</div>';
                }
            }, 1000);
            
        } catch (error) {
            console.error('Error initializing calendar:', error);
            calendarEl.innerHTML = '<div class="alert alert-danger text-center"><i class="fas fa-exclamation-circle"></i> Error: ' + error.message + '</div>';
        }
    }
    
    function updateDateTime() {
        const now = new Date();
        const dateOptions = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        
        const currentDateEl = document.getElementById('currentDate');
        const currentTimeEl = document.getElementById('currentTime');
        
        if (currentDateEl) {
            currentDateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);
        }
        
        if (currentTimeEl) {
            currentTimeEl.textContent = now.toLocaleTimeString('id-ID');
        }
    }
    
    function showEventDetail(event) {
        const content = `
            <div class="event-detail">
                <div class="row mb-4">
                    <div class="col-12">
                        <h4 class="text-primary mb-3">${event.title}</h4>
                        ${event.extendedProps.description ? `<p class="text-muted mb-3">${event.extendedProps.description}</p>` : ''}
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-tag text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Kategori</small>
                                <span class="badge px-3 py-2" style="background-color: ${event.backgroundColor || event.color}">
                                    ${getTypeName(event.extendedProps.type)}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-calendar text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Tanggal</small>
                                <strong>${formatDate(event.start)}</strong>
                                ${event.end && event.end !== event.start ? 
                                    `<br><small class="text-muted">sampai ${formatDate(event.end)}</small>` : ''}
                            </div>
                        </div>
                    </div>
                    
                    ${event.extendedProps.location ? `
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Lokasi</small>
                                    <strong>${event.extendedProps.location}</strong>
                                </div>
                            </div>
                        </div>
                    ` : ''}
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-source text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Sumber</small>
                                <strong>${getSourceName(event.extendedProps.source)}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('eventDetailContent').innerHTML = content;
        
        const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
        modal.show();
    }
    
    function getTypeName(type) {
        const types = {
            'event': 'Event Umum',
            'agenda': 'Agenda Sekolah',
            'meeting': 'Rapat',
            'holiday': 'Libur',
            'exam': 'Ujian'
        };
        return types[type] || type || 'Event';
    }
    
    function getSourceName(source) {
        const sources = {
            'calendar': 'Kalender Admin',
            'agenda': 'Agenda Sekolah',
            'post': 'Post Agenda'
        };
        return sources[source] || source || 'Sistem';
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
});
</script>
@endsection