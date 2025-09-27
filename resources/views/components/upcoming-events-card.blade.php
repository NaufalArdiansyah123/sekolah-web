@props(['limit' => 5, 'showHeader' => true, 'cardClass' => ''])

@php
    use App\Models\CalendarEvent;
    use Carbon\Carbon;
    
    // Get upcoming events
    $upcomingEvents = collect();
    
    try {
        if (Schema::hasTable('calendar_events')) {
            $upcomingEvents = CalendarEvent::where('start_date', '>=', now())
                ->where('status', 'active')
                ->orderBy('start_date', 'asc')
                ->limit($limit)
                ->get();
        }
    } catch (Exception $e) {
        // Handle any database errors silently
    }
@endphp

<style>
    /* CSS Variables for Dark Mode */
    :root {
        --event-bg-primary: #ffffff;
        --event-bg-secondary: #f8fafc;
        --event-text-primary: #1e293b;
        --event-text-secondary: #64748b;
        --event-text-tertiary: #94a3b8;
        --event-border-color: #e2e8f0;
        --event-shadow-color: rgba(0, 0, 0, 0.1);
        --event-hover-bg: #f1f5f9;
    }

    .dark {
        --event-bg-primary: #1e293b;
        --event-bg-secondary: #0f172a;
        --event-text-primary: #f1f5f9;
        --event-text-secondary: #cbd5e1;
        --event-text-tertiary: #94a3b8;
        --event-border-color: #334155;
        --event-shadow-color: rgba(0, 0, 0, 0.3);
        --event-hover-bg: #334155;
    }

    .upcoming-events-card {
        background: var(--event-bg-primary);
        border: 1px solid var(--event-border-color);
        border-radius: 16px;
        box-shadow: 0 4px 6px var(--event-shadow-color);
        transition: all 0.3s ease;
    }

    .upcoming-events-card:hover {
        box-shadow: 0 8px 25px var(--event-shadow-color);
        transform: translateY(-2px);
    }

    .event-header {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
        padding: 1.5rem;
        border-radius: 16px 16px 0 0;
        position: relative;
        overflow: hidden;
    }

    .event-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.2"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        pointer-events: none;
    }

    .event-header-content {
        position: relative;
        z-index: 2;
    }

    .event-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .event-subtitle {
        opacity: 0.9;
        margin-top: 0.25rem;
        font-size: 0.875rem;
    }

    .event-content {
        padding: 1.5rem;
    }

    .event-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        border-radius: 12px;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        margin-bottom: 0.75rem;
    }

    .event-item:last-child {
        margin-bottom: 0;
    }

    .event-item:hover {
        background: var(--event-hover-bg);
        border-color: var(--event-border-color);
        transform: translateX(4px);
    }

    .event-date-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 4rem;
        height: 4rem;
        border-radius: 12px;
        font-weight: 700;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .event-date-day {
        font-size: 1.25rem;
        line-height: 1;
        margin-bottom: 0.125rem;
    }

    .event-date-month {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        opacity: 0.8;
    }

    .event-info {
        flex: 1;
        min-width: 0;
    }

    .event-name {
        font-weight: 600;
        color: var(--event-text-primary);
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .event-details {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .event-detail-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8rem;
        color: var(--event-text-secondary);
    }

    .event-detail-icon {
        width: 0.875rem;
        height: 0.875rem;
        opacity: 0.7;
    }

    .event-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .event-description {
        color: var(--event-text-tertiary);
        font-size: 0.8rem;
        line-height: 1.4;
        margin-top: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--event-text-tertiary);
    }

    .empty-state-icon {
        width: 4rem;
        height: 4rem;
        margin: 0 auto 1rem;
        opacity: 0.5;
        color: var(--event-text-tertiary);
    }

    .empty-state-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--event-text-secondary);
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .view-all-link {
        display: block;
        text-align: center;
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--event-border-color);
        color: var(--event-text-secondary);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        border-radius: 0 0 16px 16px;
    }

    .view-all-link:hover {
        background: var(--event-hover-bg);
        color: var(--event-text-primary);
        text-decoration: none;
    }

    /* Event type colors */
    .event-type-event {
        background: rgba(59, 130, 246, 0.1);
        color: #1d4ed8;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .event-type-agenda {
        background: rgba(16, 185, 129, 0.1);
        color: #047857;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .event-type-meeting {
        background: rgba(139, 92, 246, 0.1);
        color: #6d28d9;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }

    .event-type-holiday {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .event-type-exam {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Date badge colors based on urgency */
    .date-today {
        background: linear-gradient(135deg, #10b981, #047857);
        color: white;
        animation: pulse-today 2s infinite;
    }

    .date-tomorrow {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .date-this-week {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .date-later {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }

    @keyframes pulse-today {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
        }
    }

    /* Responsive */
    @media (max-width: 640px) {
        .event-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .event-date-badge {
            align-self: flex-start;
            min-width: 3.5rem;
            height: 3.5rem;
        }

        .event-details {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<div class="upcoming-events-card {{ $cardClass }}">
    @if($showHeader)
        <div class="event-header">
            <div class="event-header-content">
                <h3 class="event-title">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Event Terbaru
                </h3>
                <p class="event-subtitle">{{ $upcomingEvents->count() }} event akan datang</p>
            </div>
        </div>
    @endif

    <div class="event-content">
        @if($upcomingEvents->count() > 0)
            @foreach($upcomingEvents as $event)
                @php
                    $startDate = $event->start_date;
                    $today = Carbon::today();
                    $tomorrow = Carbon::tomorrow();
                    $endOfWeek = Carbon::today()->endOfWeek();
                    
                    // Determine date badge class
                    $dateClass = 'date-later';
                    if ($startDate->isToday()) {
                        $dateClass = 'date-today';
                    } elseif ($startDate->isTomorrow()) {
                        $dateClass = 'date-tomorrow';
                    } elseif ($startDate->between($today, $endOfWeek)) {
                        $dateClass = 'date-this-week';
                    }
                    
                    // Event type icons
                    $typeIcons = [
                        'event' => '🎯',
                        'agenda' => '📋',
                        'meeting' => '🤝',
                        'holiday' => '🏖️',
                        'exam' => '📝'
                    ];
                    
                    $typeIcon = $typeIcons[$event->type] ?? '📅';
                    
                    // Event type labels
                    $typeLabels = [
                        'event' => 'Event',
                        'agenda' => 'Agenda',
                        'meeting' => 'Rapat',
                        'holiday' => 'Libur',
                        'exam' => 'Ujian'
                    ];
                    
                    $typeLabel = $typeLabels[$event->type] ?? 'Event';
                @endphp
                
                <div class="event-item">
                    <div class="event-date-badge {{ $dateClass }}">
                        <div class="event-date-day">{{ $startDate->format('d') }}</div>
                        <div class="event-date-month">{{ $startDate->format('M') }}</div>
                    </div>
                    
                    <div class="event-info">
                        <div class="event-name">{{ $typeIcon }} {{ $event->title }}</div>
                        
                        <div class="event-details">
                            <div class="event-detail-item">
                                <svg class="event-detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                @if($event->is_all_day)
                                    Sepanjang hari
                                @else
                                    {{ $event->start_time ? Carbon::parse($event->start_time)->format('H:i') : 'Sepanjang hari' }}
                                    @if($event->end_time && $event->end_time !== $event->start_time)
                                        - {{ Carbon::parse($event->end_time)->format('H:i') }}
                                    @endif
                                @endif
                            </div>
                            
                            @if($event->location)
                                <div class="event-detail-item">
                                    <svg class="event-detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ Str::limit($event->location, 20) }}
                                </div>
                            @endif
                            
                            <div class="event-type-badge event-type-{{ $event->type }}">
                                {{ $typeLabel }}
                            </div>
                        </div>
                        
                        @if($event->description)
                            <div class="event-description">
                                {{ $event->description }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <div class="empty-state-title">Tidak Ada Event</div>
                <div class="empty-state-text">
                    Belum ada event yang dijadwalkan untuk periode mendatang. 
                    <br>Tambahkan event baru di kalender akademik.
                </div>
            </div>
        @endif
    </div>
    
    @if($upcomingEvents->count() > 0)
        <a href="{{ route('admin.calendar.index') }}" class="view-all-link">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Lihat Semua Event di Kalender
        </a>
    @endif
</div>