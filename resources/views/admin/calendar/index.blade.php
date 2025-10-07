@extends('layouts.admin')

@section('title', 'Kalender Akademik')

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <style>
        /* CSS Variables for Theme Support */
        :root {
            --calendar-bg: #ffffff;
            --calendar-text: #1f2937;
            --calendar-border: rgba(255, 255, 255, 0.1);
            --calendar-day-bg: rgba(255, 255, 255, 0.8);
            --calendar-day-border: rgba(148, 163, 184, 0.3);
            --calendar-day-number: #475569;
            --calendar-header-bg: linear-gradient(135deg, #1e293b, #334155);
            --calendar-view-bg: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            --calendar-weekend-bg: linear-gradient(135deg, rgba(239, 68, 68, 0.05), rgba(220, 38, 38, 0.05));
            --calendar-weekend-text: #dc2626;
            --calendar-scrollbar-track: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            --calendar-scrollbar-thumb: linear-gradient(135deg, #3b82f6, #8b5cf6);
            --calendar-scrollbar-border: #f1f5f9;
        }

        .dark {
            --calendar-bg: #1f2937;
            --calendar-text: #f9fafb;
            --calendar-border: #374151;
            --calendar-day-bg: rgba(31, 41, 55, 0.8);
            --calendar-day-border: #374151;
            --calendar-day-number: #d1d5db;
            --calendar-header-bg: linear-gradient(135deg, #0f172a, #1e293b);
            --calendar-view-bg: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            --calendar-weekend-bg: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            --calendar-weekend-text: #fca5a5;
            --calendar-scrollbar-track: linear-gradient(135deg, #374151, #4b5563);
            --calendar-scrollbar-thumb: linear-gradient(135deg, #3b82f6, #8b5cf6);
            --calendar-scrollbar-border: #374151;
        }

        /* Enhanced FullCalendar Styling */
        .fc {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: var(--calendar-bg);
            color: var(--calendar-text);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid var(--calendar-border);
            transition: all 0.3s ease;
        }

        /* Calendar Header */
        .fc-header-toolbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem 2.5rem;
            margin: 0 !important;
            border-radius: 0;
            position: relative;
            overflow: hidden;
        }

        .fc-header-toolbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="90" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .fc-toolbar-title {
            color: white !important;
            font-size: 2rem !important;
            font-weight: 800 !important;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 2;
        }

        .fc-button {
            background: rgba(255, 255, 255, 0.15) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            border-radius: 1rem !important;
            font-weight: 600 !important;
            padding: 0.875rem 1.5rem !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            backdrop-filter: blur(20px) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
            position: relative;
            z-index: 2;
        }

        .fc-button:hover {
            background: rgba(255, 255, 255, 0.25) !important;
            transform: translateY(-3px) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2) !important;
        }

        .fc-button:focus {
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.3) !important;
        }

        .fc-button-active {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: scale(0.95) !important;
        }

        /* Calendar Body */
        .fc-view-harness {
            background: var(--calendar-view-bg);
            border-radius: 0 0 1.5rem 1.5rem;
            position: relative;
            transition: all 0.3s ease;
        }

        /* Day Grid */
        .fc-daygrid {
            background: transparent;
        }

        .fc-col-header {
            background: var(--calendar-header-bg);
            border-bottom: 3px solid #3b82f6;
            position: relative;
            transition: all 0.3s ease;
        }

        .fc-col-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899, #f59e0b, #10b981, #3b82f6);
            background-size: 200% 100%;
            animation: rainbow 3s linear infinite;
        }

        @keyframes rainbow {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 200% 50%;
            }
        }

        .fc-col-header-cell {
            padding: 1.25rem 0.75rem;
            font-weight: 800;
            color: white;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .fc-daygrid-day {
            border: 1px solid var(--calendar-day-border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            min-height: 140px;
            background: var(--calendar-day-bg);
            backdrop-filter: blur(10px);
        }

        .fc-daygrid-day:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
            transform: scale(1.02);
            z-index: 10;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
            border-color: #3b82f6;
        }

        .fc-daygrid-day-number {
            padding: 1rem;
            font-weight: 700;
            color: var(--calendar-day-number);
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Today Styling */
        .fc-day-today {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2)) !important;
            border: 2px solid #3b82f6 !important;
            position: relative;
            overflow: hidden;
        }

        .fc-day-today::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(59, 130, 246, 0.1) 50%, transparent 70%);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .fc-day-today .fc-daygrid-day-number {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border-radius: 50%;
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            margin: 0.75rem;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            animation: pulse 2s infinite;
            position: relative;
            z-index: 2;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            }

            50% {
                transform: scale(1.1);
                box-shadow: 0 12px 35px rgba(59, 130, 246, 0.6);
            }
        }

        /* Weekend Styling */
        .fc-day-sat,
        .fc-day-sun {
            background: var(--calendar-weekend-bg);
            position: relative;
        }

        .fc-day-sat::after,
        .fc-day-sun::after {
            content: '🌅';
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            font-size: 1.2rem;
            opacity: 0.3;
        }

        .fc-day-sat .fc-daygrid-day-number,
        .fc-day-sun .fc-daygrid-day-number {
            color: var(--calendar-weekend-text);
            font-weight: 800;
        }

        /* Event Styling */
        .fc-event {
            border: none !important;
            border-radius: 1rem !important;
            padding: 0.75rem 1rem !important;
            margin: 0.375rem !important;
            font-weight: 700 !important;
            font-size: 0.85rem !important;
            cursor: pointer !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
            backdrop-filter: blur(10px) !important;
            position: relative !important;
            overflow: hidden !important;
            border-left: 4px solid rgba(255, 255, 255, 0.5) !important;
        }

        .fc-event::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.3) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.8s ease;
        }

        .fc-event:hover::before {
            transform: translateX(100%);
        }

        .fc-event:hover {
            transform: translateY(-4px) scale(1.08) !important;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25) !important;
            z-index: 100 !important;
        }

        .fc-event-title {
            font-weight: 800 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }

        /* Enhanced Event Types with Gradients */
        .fc-event[style*="#3b82f6"] {
            background: linear-gradient(135deg, #3b82f6, #1e40af) !important;
            border-left-color: #1e3a8a !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3) !important;
        }

        .fc-event[style*="#10b981"] {
            background: linear-gradient(135deg, #10b981, #047857) !important;
            border-left-color: #064e3b !important;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3) !important;
        }

        .fc-event[style*="#ef4444"] {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            border-left-color: #991b1b !important;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3) !important;
        }

        .fc-event[style*="#f59e0b"] {
            background: linear-gradient(135deg, #f59e0b, #d97706) !important;
            border-left-color: #92400e !important;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3) !important;
        }

        .fc-event[style*="#8b5cf6"] {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed) !important;
            border-left-color: #5b21b6 !important;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3) !important;
        }

        .fc-event[style*="#ec4899"] {
            background: linear-gradient(135deg, #ec4899, #db2777) !important;
            border-left-color: #be185d !important;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3) !important;
        }

        /* More Events Link */
        .fc-more-link {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            color: white !important;
            border-radius: 0.75rem !important;
            padding: 0.5rem 1rem !important;
            font-weight: 700 !important;
            font-size: 0.8rem !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3) !important;
            border: none !important;
        }

        .fc-more-link:hover {
            transform: scale(1.1) !important;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4) !important;
        }

        /* Calendar Enhancement */
        .calendar-enhanced {
            position: relative;
            overflow: hidden;
        }

        .calendar-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899, #f59e0b, #10b981);
            background-size: 200% 100%;
            animation: rainbow-border 3s linear infinite;
            z-index: 1000;
        }

        @keyframes rainbow-border {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 200% 50%;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .fc-header-toolbar {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
                padding: 1.5rem;
            }

            .fc-toolbar-title {
                font-size: 1.75rem !important;
            }

            .fc-button {
                padding: 0.75rem 1.25rem !important;
                font-size: 0.9rem !important;
            }

            .fc-daygrid-day {
                min-height: 100px;
            }

            .fc-event {
                font-size: 0.75rem !important;
                padding: 0.5rem 0.75rem !important;
                margin: 0.25rem !important;
            }

            .fc-day-today .fc-daygrid-day-number {
                width: 2.5rem;
                height: 2.5rem;
                margin: 0.5rem;
            }
        }

        /* Dark Mode Support - Now handled by CSS Variables above */

        /* Custom Scrollbar */
        .fc-scroller::-webkit-scrollbar {
            width: 12px;
        }

        .fc-scroller::-webkit-scrollbar-track {
            background: var(--calendar-scrollbar-track);
            border-radius: 6px;
        }

        .fc-scroller::-webkit-scrollbar-thumb {
            background: var(--calendar-scrollbar-thumb);
            border-radius: 6px;
            border: 2px solid var(--calendar-scrollbar-border);
            transition: all 0.3s ease;
        }

        .fc-scroller::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #1d4ed8, #7c3aed);
        }

        /* Event Tooltip */
        .fc-event[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.95);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 1000;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            animation: tooltip-fade 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .fc-event[title]:hover::before {
            content: '';
            position: absolute;
            bottom: 110%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: rgba(0, 0, 0, 0.95);
            z-index: 1000;
        }

        @keyframes tooltip-fade {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900">
        <div class="container mx-auto px-6 py-8">
            <!-- Error Messages -->
            @if(isset($table_missing) && $table_missing)
                <div
                    class="bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 border border-yellow-200 dark:border-yellow-800 rounded-2xl p-6 mb-8 shadow-lg">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-r from-yellow-400 to-amber-500 p-4 rounded-xl mr-4 shadow-lg">
                            <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-yellow-900 dark:text-yellow-100 mb-2">Database Belum Siap</h3>
                            <p class="text-yellow-700 dark:text-yellow-300 mb-4">Tabel kalender belum dibuat. Silakan jalankan
                                migration terlebih dahulu:</p>
                            <div
                                class="bg-yellow-100 dark:bg-yellow-900/50 rounded-lg p-4 border border-yellow-200 dark:border-yellow-700">
                                <code class="text-yellow-800 dark:text-yellow-200 text-sm font-mono">php artisan migrate</code>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($error))
                <div
                    class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6 mb-8 shadow-lg">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-r from-red-500 to-rose-600 p-4 rounded-xl mr-4 shadow-lg">
                            <i class="fas fa-exclamation-circle text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-red-900 dark:text-red-100 mb-2">Terjadi Kesalahan</h3>
                            <p class="text-red-700 dark:text-red-300 mb-2">{{ $error }}</p>
                            <p class="text-red-600 dark:text-red-400 text-sm">Silakan periksa log Laravel untuk detail lebih
                                lanjut.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Enhanced Page Header -->
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 px-8 py-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="mb-6 lg:mb-0">
                            <div class="flex items-center mb-4">
                                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl mr-4 shadow-lg">
                                    <i class="fas fa-calendar-alt text-white text-3xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-4xl font-bold text-white mb-2">Kalender Akademik</h1>
                                    <p class="text-blue-100 text-lg">Kelola jadwal dan acara sekolah dengan sinkronisasi
                                        agenda otomatis</p>
                                </div>
                            </div>

                            <!-- Quick Stats in Header -->
                            @if(isset($stats))
                                <div class="flex flex-wrap gap-4 mt-4">
                                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                                        <div class="text-white/80 text-sm">Total Events</div>
                                        <div class="text-white text-xl font-bold">{{ $stats['total_events'] ?? 0 }}</div>
                                    </div>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                                        <div class="text-white/80 text-sm">Akan Datang</div>
                                        <div class="text-white text-xl font-bold">{{ $stats['upcoming_events'] ?? 0 }}</div>
                                    </div>
                                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                                        <div class="text-white/80 text-sm">Bulan Ini</div>
                                        <div class="text-white text-xl font-bold">{{ $stats['this_month_events'] ?? 0 }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="button" onclick="syncFromAgenda()"
                                class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 border border-white/20">
                                <i class="fas fa-sync mr-3 group-hover:rotate-180 transition-transform duration-500"></i>
                                <span class="font-semibold">Sync Agenda</span>
                            </button>
                            <button type="button" onclick="showAddEventModal()"
                                class="group bg-white hover:bg-gray-50 text-blue-600 px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-semibold">
                                <i class="fas fa-plus mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                                <span>Tambah Event</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Statistics Cards -->
            @if(isset($stats))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div
                        class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <div
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="text-right">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Events</h3>
                                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_events'] ?? 0 }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">Semua event</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <div
                                    class="bg-gradient-to-r from-green-500 to-emerald-600 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <i class="fas fa-clock text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="text-right">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Akan Datang</h3>
                                <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                                    {{ $stats['upcoming_events'] ?? 0 }}</p>
                                <p class="text-xs text-gray-400 mt-1">Event mendatang</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <div
                                    class="bg-gradient-to-r from-yellow-500 to-amber-600 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <i class="fas fa-history text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="text-right">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Selesai</h3>
                                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                                    {{ $stats['past_events'] ?? 0 }}</p>
                                <p class="text-xs text-gray-400 mt-1">Event selesai</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="group bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <div
                                    class="bg-gradient-to-r from-purple-500 to-indigo-600 p-4 rounded-2xl shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                    <i class="fas fa-calendar-day text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="text-right">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Bulan Ini</h3>
                                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                                    {{ $stats['this_month_events'] ?? 0 }}</p>
                                <p class="text-xs text-gray-400 mt-1">Event bulan ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Enhanced Calendar Container -->
            <div
                class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
                <!-- Calendar Body -->
                <div class="p-8">
                    <div id="calendar" class="min-h-[800px] calendar-enhanced">
                        <div class="flex items-center justify-center h-96">
                            <div class="text-center">
                                <div class="relative">
                                    <div
                                        class="animate-spin rounded-full h-20 w-20 border-4 border-blue-200 border-t-blue-600 mx-auto mb-6">
                                    </div>
                                    <div class="absolute inset-0 rounded-full bg-blue-100 opacity-20 animate-pulse"></div>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-300 mb-2">Memuat Kalender</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-lg">Sedang mengambil data events...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Enhanced Add Event Modal -->
    <div id="addEventModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-gray-200 dark:border-gray-700">
            <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 px-8 py-6 rounded-t-3xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-white">Tambah Event Baru</h3>
                        <p class="text-blue-100 mt-1">Buat event atau agenda baru untuk kalender akademik</p>
                    </div>
                    <button onclick="closeModal()"
                        class="text-white hover:text-gray-200 transition-colors p-2 hover:bg-white/10 rounded-xl">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>
            <form id="addEventForm" class="p-8">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Judul
                                Event</label>
                            <input type="text" name="title" required
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 text-lg"
                                placeholder="Masukkan judul event...">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tipe
                                Event</label>
                            <select name="type" required
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="event">🎯 Event Umum</option>
                                <option value="agenda">📋 Agenda (akan ditambahkan ke halaman agenda)</option>
                                <option value="meeting">🤝 Rapat</option>
                                <option value="holiday">🏖️ Libur</option>
                                <option value="exam">📝 Ujian</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Warna
                                Event</label>
                            <div class="flex space-x-3">
                                <button type="button"
                                    class="color-btn w-10 h-10 rounded-xl bg-blue-500 ring-4 ring-blue-200 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#3b82f6"></button>
                                <button type="button"
                                    class="color-btn w-10 h-10 rounded-xl bg-green-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#10b981"></button>
                                <button type="button"
                                    class="color-btn w-10 h-10 rounded-xl bg-red-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#ef4444"></button>
                                <button type="button"
                                    class="color-btn w-10 h-10 rounded-xl bg-yellow-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#f59e0b"></button>
                                <button type="button"
                                    class="color-btn w-10 h-10 rounded-xl bg-purple-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#8b5cf6"></button>
                                <button type="button"
                                    class="color-btn w-10 h-10 rounded-xl bg-pink-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#ec4899"></button>
                            </div>
                            <input type="hidden" name="color" value="#3b82f6">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tanggal
                                Mulai</label>
                            <input type="date" name="start_date" required
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tanggal
                                Selesai</label>
                            <input type="date" name="end_date"
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        </div>
                    </div>

                    <!-- Time Fields -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Waktu
                                Mulai</label>
                            <input type="time" name="start_time" id="start_time"
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <small class="text-gray-500 dark:text-gray-400 mt-1 block">Kosongkan jika acara sepanjang
                                hari</small>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Waktu
                                Selesai</label>
                            <input type="time" name="end_time" id="end_time"
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <small class="text-gray-500 dark:text-gray-400 mt-1 block">Kosongkan jika acara sepanjang
                                hari</small>
                        </div>
                    </div>

                    <!-- All Day Checkbox -->
                    <div class="flex items-center bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                        <input type="checkbox" id="is_all_day" name="is_all_day" value="1"
                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="is_all_day" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="fas fa-clock mr-2"></i>Acara sepanjang hari
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Lokasi</label>
                        <input type="text" name="location"
                            class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            placeholder="Masukkan lokasi event...">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Deskripsi</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200 resize-none"
                            placeholder="Masukkan deskripsi event..."></textarea>
                    </div>
                </div>

                <div class="flex gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>Simpan Event
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Enhanced Edit Event Modal -->
    <div id="editEventModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-gray-200 dark:border-gray-700">
            <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-8 py-6 rounded-t-3xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-white">Edit Event</h3>
                        <p class="text-green-100 mt-1">Perbarui informasi event atau agenda</p>
                    </div>
                    <button onclick="closeEditModal()"
                        class="text-white hover:text-gray-200 transition-colors p-2 hover:bg-white/10 rounded-xl">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>
            <form id="editEventForm" class="p-8">
                <input type="hidden" name="event_id">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Judul
                                Event</label>
                            <input type="text" name="title" required
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 text-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tipe
                                Event</label>
                            <select name="type" required
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="event">🎯 Event Umum</option>
                                <option value="agenda">📋 Agenda (akan ditambahkan ke halaman agenda)</option>
                                <option value="meeting">🤝 Rapat</option>
                                <option value="holiday">🏖️ Libur</option>
                                <option value="exam">📝 Ujian</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Warna
                                Event</label>
                            <div class="flex space-x-3">
                                <button type="button"
                                    class="edit-color-btn w-10 h-10 rounded-xl bg-blue-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#3b82f6"></button>
                                <button type="button"
                                    class="edit-color-btn w-10 h-10 rounded-xl bg-green-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#10b981"></button>
                                <button type="button"
                                    class="edit-color-btn w-10 h-10 rounded-xl bg-red-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#ef4444"></button>
                                <button type="button"
                                    class="edit-color-btn w-10 h-10 rounded-xl bg-yellow-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#f59e0b"></button>
                                <button type="button"
                                    class="edit-color-btn w-10 h-10 rounded-xl bg-purple-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#8b5cf6"></button>
                                <button type="button"
                                    class="edit-color-btn w-10 h-10 rounded-xl bg-pink-500 shadow-lg hover:scale-110 transition-transform duration-200"
                                    data-color="#ec4899"></button>
                            </div>
                            <input type="hidden" name="color" value="#3b82f6">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tanggal
                                Mulai</label>
                            <input type="date" name="start_date" required
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tanggal
                                Selesai</label>
                            <input type="date" name="end_date"
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                        </div>
                    </div>

                    <!-- Time Fields -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Waktu
                                Mulai</label>
                            <input type="time" name="start_time" id="edit_start_time"
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <small class="text-gray-500 dark:text-gray-400 mt-1 block">Kosongkan jika acara sepanjang
                                hari</small>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Waktu
                                Selesai</label>
                            <input type="time" name="end_time" id="edit_end_time"
                                class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <small class="text-gray-500 dark:text-gray-400 mt-1 block">Kosongkan jika acara sepanjang
                                hari</small>
                        </div>
                    </div>

                    <!-- All Day Checkbox -->
                    <div class="flex items-center bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                        <input type="checkbox" id="edit_is_all_day" name="is_all_day" value="1"
                            class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="edit_is_all_day" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            <i class="fas fa-clock mr-2"></i>Acara sepanjang hari
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Lokasi</label>
                        <input type="text" name="location"
                            class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Deskripsi</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-4 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition-all duration-200 resize-none"></textarea>
                    </div>
                </div>

                <div class="flex gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" onclick="deleteEvent()"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-4 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        let calendar;
        let currentEventId = null;

        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            // Check if there are errors or table missing
            @if(isset($table_missing) && $table_missing)
                calendarEl.innerHTML = '<div class="text-center py-20"><div class="bg-yellow-100 dark:bg-yellow-900 p-8 rounded-2xl w-32 h-32 mx-auto mb-6 flex items-center justify-center shadow-lg"><i class="fas fa-database text-yellow-600 dark:text-yellow-400 text-4xl"></i></div><h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Database Belum Siap</h3><p class="text-gray-500 dark:text-gray-400 text-lg">Silakan jalankan migration untuk membuat tabel kalender</p></div>';
                return;
            @endif

            @if(isset($error))
                calendarEl.innerHTML = '<div class="text-center py-20"><div class="bg-red-100 dark:bg-red-900 p-8 rounded-2xl w-32 h-32 mx-auto mb-6 flex items-center justify-center shadow-lg"><i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-4xl"></i></div><h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Terjadi Kesalahan</h3><p class="text-gray-500 dark:text-gray-400 text-lg">{{ $error }}</p></div>';
                return;
            @endif

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
                    events: {
                        url: '{{ route("admin.calendar.events") }}',
                        failure: function () {
                            console.error('Failed to load calendar events');
                            showMessage('error', 'Gagal memuat events kalender');
                        }
                    },
                    eventClick: function (info) {
                        const eventId = info.event.extendedProps.event_id;
                        showEditEventModal(eventId);
                    },
                    loading: function (bool) {
                        if (bool) {
                            calendarEl.style.opacity = '0.7';
                        } else {
                            calendarEl.style.opacity = '1';
                        }
                    },
                    eventDidMount: function (info) {
                        // Add enhanced tooltip and styling
                        info.el.title = info.event.extendedProps.description || info.event.title;

                        // Add type icon
                        const typeIcons = {
                            'event': '🎯',
                            'agenda': '📋',
                            'meeting': '🤝',
                            'holiday': '🏖️',
                            'exam': '📝'
                        };

                        const type = info.event.extendedProps.type || 'event';
                        const icon = typeIcons[type] || '📅';

                        const titleEl = info.el.querySelector('.fc-event-title');
                        if (titleEl) {
                            titleEl.innerHTML = `${icon} ${titleEl.innerHTML}`;
                        }
                    }
                });

                calendar.render();

            } catch (error) {
                console.error('Calendar initialization error:', error);
                calendarEl.innerHTML = '<div class="text-center py-20"><div class="bg-red-100 dark:bg-red-900 p-8 rounded-2xl w-32 h-32 mx-auto mb-6 flex items-center justify-center shadow-lg"><i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-4xl"></i></div><h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Gagal Memuat Kalender</h3><p class="text-gray-500 dark:text-gray-400 text-lg">Silakan refresh halaman atau hubungi administrator</p></div>';
            }

            // All day checkbox functionality
            const allDayCheckbox = document.getElementById('is_all_day');
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');

            if (allDayCheckbox && startTimeInput && endTimeInput) {
                allDayCheckbox.addEventListener('change', function () {
                    if (this.checked) {
                        startTimeInput.disabled = true;
                        endTimeInput.disabled = true;
                        startTimeInput.value = '';
                        endTimeInput.value = '';
                        startTimeInput.parentElement.style.opacity = '0.5';
                        endTimeInput.parentElement.style.opacity = '0.5';
                    } else {
                        startTimeInput.disabled = false;
                        endTimeInput.disabled = false;
                        startTimeInput.parentElement.style.opacity = '1';
                        endTimeInput.parentElement.style.opacity = '1';
                    }
                });
            }

            // Edit form all day checkbox
            const editAllDayCheckbox = document.getElementById('edit_is_all_day');
            const editStartTimeInput = document.getElementById('edit_start_time');
            const editEndTimeInput = document.getElementById('edit_end_time');

            if (editAllDayCheckbox && editStartTimeInput && editEndTimeInput) {
                editAllDayCheckbox.addEventListener('change', function () {
                    if (this.checked) {
                        editStartTimeInput.disabled = true;
                        editEndTimeInput.disabled = true;
                        editStartTimeInput.value = '';
                        editEndTimeInput.value = '';
                        editStartTimeInput.parentElement.style.opacity = '0.5';
                        editEndTimeInput.parentElement.style.opacity = '0.5';
                    } else {
                        editStartTimeInput.disabled = false;
                        editEndTimeInput.disabled = false;
                        editStartTimeInput.parentElement.style.opacity = '1';
                        editEndTimeInput.parentElement.style.opacity = '1';
                    }
                });
            }
        });

        // Enhanced color picker functionality
        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.color-btn').forEach(b => {
                    b.classList.remove('ring-4', 'ring-blue-200', 'scale-110');
                });
                this.classList.add('ring-4', 'ring-blue-200', 'scale-110');
                document.querySelector('#addEventForm input[name="color"]').value = this.dataset.color;
            });
        });

        document.querySelectorAll('.edit-color-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.edit-color-btn').forEach(b => {
                    b.classList.remove('ring-4', 'ring-green-200', 'scale-110');
                });
                this.classList.add('ring-4', 'ring-green-200', 'scale-110');
                document.querySelector('#editEventForm input[name="color"]').value = this.dataset.color;
            });
        });

        function showAddEventModal() {
            document.getElementById('addEventModal').classList.remove('hidden');
            document.getElementById('addEventModal').classList.add('flex');
            // Set default date to today
            document.querySelector('#addEventForm input[name="start_date"]').value = new Date().toISOString().split('T')[0];
        }

        function closeModal() {
            document.getElementById('addEventModal').classList.add('hidden');
            document.getElementById('addEventModal').classList.remove('flex');
            document.getElementById('addEventForm').reset();
            // Reset color selection
            document.querySelectorAll('.color-btn').forEach(b => {
                b.classList.remove('ring-4', 'ring-blue-200', 'scale-110');
            });
            document.querySelector('.color-btn[data-color="#3b82f6"]').classList.add('ring-4', 'ring-blue-200', 'scale-110');
            // Reset time inputs
            const startTime = document.getElementById('start_time');
            const endTime = document.getElementById('end_time');
            if (startTime && endTime) {
                startTime.disabled = false;
                endTime.disabled = false;
                startTime.parentElement.style.opacity = '1';
                endTime.parentElement.style.opacity = '1';
            }
        }

        function showEditEventModal(eventId) {
            currentEventId = eventId;

            fetch(`{{ route("admin.calendar.events.show", '') }}/${eventId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const form = document.getElementById('editEventForm');
                        form.querySelector('input[name="event_id"]').value = data.event.id;
                        form.querySelector('input[name="title"]').value = data.event.title;
                        form.querySelector('select[name="type"]').value = data.event.type;
                        form.querySelector('input[name="start_date"]').value = data.event.start_date;
                        form.querySelector('input[name="end_date"]').value = data.event.end_date || '';
                        form.querySelector('input[name="start_time"]').value = data.event.start_time || '';
                        form.querySelector('input[name="end_time"]').value = data.event.end_time || '';
                        form.querySelector('input[name="location"]').value = data.event.location || '';
                        form.querySelector('textarea[name="description"]').value = data.event.description || '';
                        form.querySelector('input[name="color"]').value = data.event.color;

                        // Set all day checkbox
                        const isAllDay = data.event.is_all_day || (!data.event.start_time && !data.event.end_time);
                        form.querySelector('input[name="is_all_day"]').checked = isAllDay;

                        // Enable/disable time inputs based on all day
                        const editStartTime = form.querySelector('input[name="start_time"]');
                        const editEndTime = form.querySelector('input[name="end_time"]');
                        editStartTime.disabled = isAllDay;
                        editEndTime.disabled = isAllDay;
                        editStartTime.parentElement.style.opacity = isAllDay ? '0.5' : '1';
                        editEndTime.parentElement.style.opacity = isAllDay ? '0.5' : '1';

                        // Set color selection
                        document.querySelectorAll('.edit-color-btn').forEach(btn => {
                            btn.classList.remove('ring-4', 'ring-green-200', 'scale-110');
                            if (btn.dataset.color === data.event.color) {
                                btn.classList.add('ring-4', 'ring-green-200', 'scale-110');
                            }
                        });

                        document.getElementById('editEventModal').classList.remove('hidden');
                        document.getElementById('editEventModal').classList.add('flex');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('error', 'Gagal memuat data event');
                });
        }

        function closeEditModal() {
            document.getElementById('editEventModal').classList.add('hidden');
            document.getElementById('editEventModal').classList.remove('flex');
            currentEventId = null;
        }

        function deleteEvent() {
            if (!currentEventId) return;

            if (confirm('Apakah Anda yakin ingin menghapus event ini?')) {
                fetch(`{{ route("admin.calendar.events.delete", '') }}/${currentEventId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            closeEditModal();
                            calendar.refetchEvents();
                            showMessage('success', data.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showMessage('error', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('error', 'Terjadi kesalahan saat menghapus event');
                    });
            }
        }

        function syncFromAgenda() {
            if (confirm('Sinkronisasi agenda ke kalender? Ini akan menambahkan agenda yang belum ada di kalender.')) {
                const syncBtn = event.target;
                const originalText = syncBtn.innerHTML;
                syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Sinkronisasi...';
                syncBtn.disabled = true;

                fetch('{{ route("admin.calendar.sync-agenda") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            calendar.refetchEvents();
                            showMessage('success', data.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showMessage('error', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('error', 'Terjadi kesalahan saat sinkronisasi');
                    })
                    .finally(() => {
                        syncBtn.innerHTML = originalText;
                        syncBtn.disabled = false;
                    });
            }
        }

        function showMessage(type, message) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 transform translate-x-full transition-transform duration-300`;

            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            notification.innerHTML = `
            <div class="p-4">
                <div class="flex items-center">
                    <div class="${bgColor} p-2 rounded-lg mr-3">
                        <i class="fas ${icon} text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900 dark:text-white">${type === 'success' ? 'Berhasil' : 'Error'}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);

            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, 5000);
        }

        // Form submission for add event
        document.getElementById('addEventForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            submitBtn.disabled = true;

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            fetch('{{ route("admin.calendar.events.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeModal();
                        calendar.refetchEvents();
                        showMessage('success', data.message);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showMessage('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('error', 'Terjadi kesalahan saat menyimpan event');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Form submission for edit event
        document.getElementById('editEventForm').addEventListener('submit', function (e) {
            e.preventDefault();

            if (!currentEventId) return;

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengupdate...';
            submitBtn.disabled = true;

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            fetch(`{{ route("admin.calendar.events.update", '') }}/${currentEventId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeEditModal();
                        calendar.refetchEvents();
                        showMessage('success', data.message);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showMessage('error', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('error', 'Terjadi kesalahan saat mengupdate event');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });
    </script>
@endpush