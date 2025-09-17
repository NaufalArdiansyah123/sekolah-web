@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')

@section('content')

@php
    $pageTitle = 'Teacher Dashboard';
@endphp
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Light Mode Colors */
            --bg-primary-light: #ffffff;
            --bg-secondary-light: #f8fafc;
            --bg-tertiary-light: #f1f5f9;
            --text-primary-light: #1e293b;
            --text-secondary-light: #64748b;
            --text-tertiary-light: #94a3b8;
            --border-color-light: #e2e8f0;
            --shadow-color-light: rgba(0, 0, 0, 0.05);
            
            /* Dark Mode Colors */
            --bg-primary-dark: #1f2937;
            --bg-secondary-dark: #111827;
            --bg-tertiary-dark: #374151;
            --text-primary-dark: #f9fafb;
            --text-secondary-dark: #d1d5db;
            --text-tertiary-dark: #9ca3af;
            --border-color-dark: #374151;
            --shadow-color-dark: rgba(0, 0, 0, 0.3);
            
            /* Theme Colors (same for both modes) */
            --accent-color: #059669;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --success-color: #10b981;
            --info-color: #06b6d4;
            
            /* Current Theme (Default: Light) */
            --bg-primary: var(--bg-primary-light);
            --bg-secondary: var(--bg-secondary-light);
            --bg-tertiary: var(--bg-tertiary-light);
            --text-primary: var(--text-primary-light);
            --text-secondary: var(--text-secondary-light);
            --text-tertiary: var(--text-tertiary-light);
            --border-color: var(--border-color-light);
            --shadow-color: var(--shadow-color-light);
        }
        
        /* Dark Mode Theme */
        .dark {
            --bg-primary: var(--bg-primary-dark);
            --bg-secondary: var(--bg-secondary-dark);
            --bg-tertiary: var(--bg-tertiary-dark);
            --text-primary: var(--text-primary-dark);
            --text-secondary: var(--text-secondary-dark);
            --text-tertiary: var(--text-tertiary-dark);
            --border-color: var(--border-color-dark);
            --shadow-color: var(--shadow-color-dark);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-secondary);
            color: var(--text-primary);
            line-height: 1.6;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .teacher-dashboard {
            padding: 1rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Welcome Hero Section - Improved */
        .welcome-hero {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        /* Dark mode welcome section */
        .dark .welcome-hero {
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
        }

        .welcome-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 2;
        }

        .welcome-text {
            flex: 1;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .welcome-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        .welcome-stats {
            display: flex;
            gap: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .welcome-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-welcome {
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: transparent;
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-welcome:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Statistics Grid - Improved Responsive */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-primary);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px var(--shadow-color);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow-color);
        }
        
        /* Dark mode stat card hover */
        .dark .stat-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
        }

        .stat-primary .stat-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .stat-success .stat-icon { background: linear-gradient(135deg, #059669, #047857); }
        .stat-warning .stat-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .stat-info .stat-icon { background: linear-gradient(135deg, #06b6d4, #0891b2); }

        .stat-content {
            flex: 1;
            min-width: 0;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0.25rem 0;
        }

        .stat-sublabel {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Main Dashboard Grid - Improved Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
            align-items: start;
        }

        .dashboard-left {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .dashboard-right {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Card Base Styling */
        .dashboard-card {
            background: var(--bg-primary);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px var(--shadow-color);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            box-shadow: 0 8px 25px var(--shadow-color);
        }
        
        /* Dark mode dashboard card hover */
        .dark .dashboard-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-secondary);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Activities Card */
        .activity-timeline {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: var(--bg-tertiary);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
            min-width: 0;
        }

        .activity-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .activity-time {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin: 0;
        }

        /* Extracurriculars Card */
        .extracurricular-grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .extracurricular-item {
            background: var(--bg-secondary);
            border-radius: 8px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .extracurricular-item:hover {
            background: var(--bg-tertiary);
        }

        .extracurricular-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }

        .extracurricular-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--accent-color), #34d399);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .extracurricular-info {
            flex: 1;
            min-width: 0;
        }

        .extracurricular-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .extracurricular-desc {
            font-size: 0.75rem;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .extracurricular-stats {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.75rem;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .extracurricular-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Registrations Card */
        .registration-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .registration-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .registration-item:hover {
            background: var(--bg-tertiary);
        }

        .registration-avatar {
            position: relative;
            flex-shrink: 0;
        }

        .avatar-img {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
        }

        .registration-info {
            flex: 1;
            min-width: 0;
        }

        .registration-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.125rem;
        }

        .registration-email,
        .registration-extracurricular {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin: 0;
        }

        .registration-actions {
            display: flex;
            gap: 0.25rem;
            flex-shrink: 0;
        }

        /* Quick Actions */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .quick-action-btn {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: var(--text-primary);
        }

        .quick-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--shadow-color);
            background: var(--bg-tertiary);
        }
        
        /* Dark mode quick action button hover */
        .dark .quick-action-btn:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }

        .quick-action-btn.primary .action-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .quick-action-btn.success .action-icon { background: linear-gradient(135deg, #059669, #047857); }
        .quick-action-btn.info .action-icon { background: linear-gradient(135deg, #06b6d4, #0891b2); }
        .quick-action-btn.warning .action-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }

        .action-text {
            text-align: center;
        }

        .action-title {
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.125rem;
        }

        .action-subtitle {
            font-size: 0.7rem;
            color: var(--text-secondary);
        }

        /* Agenda Timeline */
        .agenda-timeline {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .agenda-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .agenda-item:hover {
            background: var(--bg-tertiary);
        }

        .agenda-date {
            background: linear-gradient(135deg, var(--accent-color), #34d399);
            color: white;
            border-radius: 8px;
            padding: 0.5rem;
            text-align: center;
            min-width: 48px;
            flex-shrink: 0;
        }

        .date-day {
            font-size: 1rem;
            font-weight: 700;
            line-height: 1;
        }

        .date-month {
            font-size: 0.6rem;
            text-transform: uppercase;
            opacity: 0.9;
            margin-top: 0.125rem;
        }

        .agenda-content {
            flex: 1;
            min-width: 0;
        }

        .agenda-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .agenda-details p {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin: 0 0 0.125rem 0;
        }

        /* Announcements */
        .announcement-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .announcement-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .announcement-item:hover {
            background: var(--bg-tertiary);
        }

        .announcement-icon {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .announcement-content {
            flex: 1;
            min-width: 0;
        }

        .announcement-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .announcement-excerpt {
            font-size: 0.75rem;
            color: var(--text-secondary);
            line-height: 1.4;
            margin-bottom: 0.25rem;
        }

        .announcement-meta {
            display: flex;
            gap: 0.75rem;
            font-size: 0.7rem;
            color: var(--text-secondary);
        }

        /* Buttons */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: 1px solid transparent;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        .btn-primary {
            background: var(--accent-color);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #047857;
        }
        
        /* Dark mode button adjustments */
        .dark .btn-primary {
            background: var(--accent-color);
            color: white;
        }
        
        .dark .btn-primary:hover {
            background: #10b981;
        }

        .btn-outline-primary {
            border-color: var(--accent-color);
            color: var(--accent-color);
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--accent-color);
            color: white;
        }
        
        /* Dark mode outline button */
        .dark .btn-outline-primary {
            border-color: var(--accent-color);
            color: var(--accent-color);
        }
        
        .dark .btn-outline-primary:hover {
            background: var(--accent-color);
            color: white;
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-info {
            background: var(--info-color);
            color: white;
        }

        .btn-outline-secondary {
            border-color: var(--border-color);
            color: var(--text-secondary);
            background: transparent;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }
        
        /* Dark mode outline secondary button */
        .dark .btn-outline-secondary {
            border-color: var(--border-color);
            color: var(--text-secondary);
        }
        
        .dark .btn-outline-secondary:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }

        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .bg-primary { background: var(--accent-color); color: white; }
        .bg-warning { background: var(--warning-color); color: white; }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
        }

        .empty-icon {
            font-size: 2.5rem;
            color: var(--text-tertiary);
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .dashboard-right {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .teacher-dashboard {
                padding: 0.75rem;
            }

            .welcome-hero {
                padding: 1.5rem;
            }

            .welcome-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .welcome-title {
                font-size: 1.5rem;
                justify-content: center;
            }

            .welcome-stats {
                justify-content: center;
            }

            .welcome-actions {
                justify-content: center;
                flex-wrap: wrap;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .stat-card {
                padding: 1.25rem;
            }

            .stat-number {
                font-size: 1.75rem;
            }

            .dashboard-grid {
                gap: 1rem;
            }

            .card-body,
            .card-header {
                padding: 1rem;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .teacher-dashboard {
                padding: 0.5rem;
            }

            .welcome-hero {
                padding: 1rem;
            }

            .welcome-title {
                font-size: 1.25rem;
            }

            .welcome-stats {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn-welcome {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }

            .stat-card {
                padding: 1rem;
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }

            .stat-content {
                order: 2;
            }

            .stat-icon {
                order: 1;
                margin: 0 auto;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .card-body,
            .card-header {
                padding: 0.75rem;
            }

            .activity-item,
            .registration-item,
            .agenda-item,
            .announcement-item {
                padding: 0.75rem;
                gap: 0.5rem;
            }

            .extracurricular-item {
                padding: 0.75rem;
            }

            .quick-action-btn {
                padding: 0.75rem;
            }

            .action-icon {
                width: 36px;
                height: 36px;
            }

            .registration-actions {
                flex-direction: column;
                gap: 0.125rem;
            }
        }

        @media (max-width: 360px) {
            .welcome-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-welcome {
                width: 100%;
            }

            .stat-card {
                padding: 0.75rem;
            }

            .extracurricular-header {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }

            .registration-item {
                flex-direction: column;
                text-align: center;
            }

            .registration-actions {
                flex-direction: row;
                justify-content: center;
            }
        }

        /* Animation Classes */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .gap-1 { gap: 0.25rem; }
        .gap-2 { gap: 0.5rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .me-1 { margin-right: 0.25rem; }
        .me-2 { margin-right: 0.5rem; }
    </style>
</head>
<body>
    <div class="teacher-dashboard">
        <!-- Enhanced Welcome Section -->
        <div class="welcome-hero" data-aos="fade-down">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1 class="welcome-title">
                        <span>👋</span>
                        Selamat Datang, Pak Ahmad!
                    </h1>
                    <p class="welcome-subtitle">
                        <i class="fas fa-calendar-day me-2"></i>
                        Senin, 15 September 2025
                    </p>
                    <div class="welcome-stats">
                        <span class="stat-item">
                            <i class="fas fa-clock me-1"></i>
                            08:45 WIB
                        </span>
                        <span class="stat-item">
                            <i class="fas fa-sun me-1"></i>
                            Pagi
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card stat-primary" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">24</div>
                    <div class="stat-label">Total Post</div>
                    <div class="stat-sublabel">18 dipublikasikan</div>
                </div>
            </div>

            <div class="stat-card stat-success" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">156</div>
                    <div class="stat-label">Anggota Ekskul</div>
                    <div class="stat-sublabel">Yang dikelola</div>
                </div>
            </div>

            <div class="stat-card stat-warning" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Pendaftaran Pending</div>
                    <div class="stat-sublabel">Menunggu persetujuan</div>
                </div>
            </div>

            <div class="stat-card stat-info" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Ekstrakurikuler</div>
                    <div class="stat-sublabel">Yang dikelola</div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Left Column -->
            <div class="dashboard-left">
                <!-- Recent Activities -->
                <div class="dashboard-card" data-aos="fade-right">
                    <div class="card-header">
                        <div class="header-content">
                            <h5 class="card-title">
                                <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                            </h5>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-sync me-1"></i>Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="activity-timeline">
                            <div class="activity-item">
                                <div class="activity-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Membuat post baru: "Tips Belajar Efektif"</div>
                                    <div class="activity-time">
                                        <i class="fas fa-clock me-1"></i>
                                        2 jam yang lalu
                                    </div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Menambahkan agenda: "Rapat Koordinasi"</div>
                                    <div class="activity-time">
                                        <i class="fas fa-clock me-1"></i>
                                        1 hari yang lalu
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Extracurriculars Management -->
                <div class="dashboard-card" data-aos="fade-right" data-aos-delay="200">
                    <div class="card-header">
                        <div class="header-content">
                            <h5 class="card-title">
                                <i class="fas fa-users me-2"></i>Ekstrakurikuler yang Dikelola
                            </h5>
                            <span class="badge bg-primary">3</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="extracurricular-grid">
                            <div class="extracurricular-item">
                                <div class="extracurricular-header">
                                    <div class="extracurricular-icon">
                                        <i class="fas fa-basketball-ball"></i>
                                    </div>
                                    <div class="extracurricular-info">
                                        <div class="extracurricular-name">Basketball</div>
                                        <div class="extracurricular-desc">Olahraga bola basket untuk meningkatkan kebugaran</div>
                                    </div>
                                </div>
                                <div class="extracurricular-stats">
                                    <div class="stat-item">
                                        <i class="fas fa-users me-1"></i>
                                        <span>45 anggota</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-clock me-1"></i>
                                        <span>3 pending</span>
                                    </div>
                                </div>
                                <div class="extracurricular-actions">
                                    <button class="btn btn-sm btn-primary">
                                        <i class="fas fa-cog me-1"></i>Kelola
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </button>
                                </div>
                            </div>
                            <div class="extracurricular-item">
                                <div class="extracurricular-header">
                                    <div class="extracurricular-icon">
                                        <i class="fas fa-music"></i>
                                    </div>
                                    <div class="extracurricular-info">
                                        <div class="extracurricular-name">Paduan Suara</div>
                                        <div class="extracurricular-desc">Kegiatan seni musik vokal dan koor</div>
                                    </div>
                                </div>
                                <div class="extracurricular-stats">
                                    <div class="stat-item">
                                        <i class="fas fa-users me-1"></i>
                                        <span>32 anggota</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-clock me-1"></i>
                                        <span>2 pending</span>
                                    </div>
                                </div>
                                <div class="extracurricular-actions">
                                    <button class="btn btn-sm btn-primary">
                                        <i class="fas fa-cog me-1"></i>Kelola
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </button>
                                </div>
                            </div>
                            <div class="extracurricular-item">
                                <div class="extracurricular-header">
                                    <div class="extracurricular-icon">
                                        <i class="fas fa-robot"></i>
                                    </div>
                                    <div class="extracurricular-info">
                                        <div class="extracurricular-name">Robotika</div>
                                        <div class="extracurricular-desc">Pembelajaran teknologi dan programming</div>
                                    </div>
                                </div>
                                <div class="extracurricular-stats">
                                    <div class="stat-item">
                                        <i class="fas fa-users me-1"></i>
                                        <span>28 anggota</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-clock me-1"></i>
                                        <span>3 pending</span>
                                    </div>
                                </div>
                                <div class="extracurricular-actions">
                                    <button class="btn btn-sm btn-primary">
                                        <i class="fas fa-cog me-1"></i>Kelola
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Registrations -->
                <div class="dashboard-card" data-aos="fade-right" data-aos-delay="400">
                    <div class="card-header">
                        <div class="header-content">
                            <h5 class="card-title">
                                <i class="fas fa-user-clock me-2"></i>Pendaftaran Menunggu Persetujuan
                            </h5>
                            <span class="badge bg-warning">8</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="registration-list">
                            <div class="registration-item">
                                <div class="registration-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Ahmad+Rizki&color=059669&background=D1FAE5" 
                                         alt="Ahmad Rizki" 
                                         class="avatar-img">
                                </div>
                                <div class="registration-info">
                                    <div class="registration-name">Ahmad Rizki</div>
                                    <div class="registration-email">ahmad.rizki@student.sch.id</div>
                                    <div class="registration-extracurricular">
                                        <i class="fas fa-tag me-1"></i>Basketball
                                    </div>
                                </div>
                                <div class="registration-actions">
                                    <button class="btn btn-sm btn-success" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="registration-item">
                                <div class="registration-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Siti+Nurhaliza&color=059669&background=D1FAE5" 
                                         alt="Siti Nurhaliza" 
                                         class="avatar-img">
                                </div>
                                <div class="registration-info">
                                    <div class="registration-name">Siti Nurhaliza</div>
                                    <div class="registration-email">siti.nurhaliza@student.sch.id</div>
                                    <div class="registration-extracurricular">
                                        <i class="fas fa-tag me-1"></i>Paduan Suara
                                    </div>
                                </div>
                                <div class="registration-actions">
                                    <button class="btn btn-sm btn-success" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="registration-item">
                                <div class="registration-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&color=059669&background=D1FAE5" 
                                         alt="Budi Santoso" 
                                         class="avatar-img">
                                </div>
                                <div class="registration-info">
                                    <div class="registration-name">Budi Santoso</div>
                                    <div class="registration-email">budi.santoso@student.sch.id</div>
                                    <div class="registration-extracurricular">
                                        <i class="fas fa-tag me-1"></i>Robotika
                                    </div>
                                </div>
                                <div class="registration-actions">
                                    <button class="btn btn-sm btn-success" title="Setujui">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-center" style="margin-top: 1rem;">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Lihat 5 lainnya
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="dashboard-right">
                <!-- Quick Actions -->
                <div class="dashboard-card" data-aos="fade-left">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-bolt me-2"></i>Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions-grid">
                            <button class="quick-action-btn primary">
                                <div class="action-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="action-text">
                                    <div class="action-title">Buat Post</div>
                                    <div class="action-subtitle">Berita & artikel</div>
                                </div>
                            </button>
                            
                            <button class="quick-action-btn success">
                                <div class="action-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="action-text">
                                    <div class="action-title">Tambah Agenda</div>
                                    <div class="action-subtitle">Jadwal kegiatan</div>
                                </div>
                            </button>
                            
                            <button class="quick-action-btn info">
                                <div class="action-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="action-text">
                                    <div class="action-title">Kelola Ekskul</div>
                                    <div class="action-subtitle">Anggota & aktivitas</div>
                                </div>
                            </button>
                            
                            <button class="quick-action-btn warning">
                                <div class="action-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <div class="action-text">
                                    <div class="action-title">Statistik</div>
                                    <div class="action-subtitle">Laporan & analisis</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Agenda -->
                <div class="dashboard-card" data-aos="fade-left" data-aos-delay="200">
                    <div class="card-header">
                        <div class="header-content">
                            <h5 class="card-title">
                                <i class="fas fa-calendar me-2"></i>Agenda Mendatang
                            </h5>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus me-1"></i>Tambah
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="agenda-timeline">
                            <div class="agenda-item">
                                <div class="agenda-date">
                                    <div class="date-day">16</div>
                                    <div class="date-month">Sep</div>
                                </div>
                                <div class="agenda-content">
                                    <div class="agenda-title">Rapat Koordinasi Guru</div>
                                    <div class="agenda-details">
                                        <p class="agenda-time">
                                            <i class="fas fa-clock me-1"></i>
                                            09:00 - 11:00
                                        </p>
                                        <p class="agenda-location">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Ruang Guru
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="agenda-item">
                                <div class="agenda-date">
                                    <div class="date-day">18</div>
                                    <div class="date-month">Sep</div>
                                </div>
                                <div class="agenda-content">
                                    <div class="agenda-title">Ujian Tengah Semester</div>
                                    <div class="agenda-details">
                                        <p class="agenda-time">
                                            <i class="fas fa-clock me-1"></i>
                                            07:30 - 09:30
                                        </p>
                                        <p class="agenda-location">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Kelas X-1
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="agenda-item">
                                <div class="agenda-date">
                                    <div class="date-day">22</div>
                                    <div class="date-month">Sep</div>
                                </div>
                                <div class="agenda-content">
                                    <div class="agenda-title">Workshop Digital</div>
                                    <div class="agenda-details">
                                        <p class="agenda-time">
                                            <i class="fas fa-clock me-1"></i>
                                            13:00 - 16:00
                                        </p>
                                        <p class="agenda-location">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            Lab Komputer
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Announcements -->
                <div class="dashboard-card" data-aos="fade-left" data-aos-delay="400">
                    <div class="card-header">
                        <div class="header-content">
                            <h5 class="card-title">
                                <i class="fas fa-bullhorn me-2"></i>Pengumuman Terbaru
                            </h5>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>Semua
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="announcement-list">
                            <div class="announcement-item">
                                <div class="announcement-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="announcement-content">
                                    <div class="announcement-title">Libur Nasional Hari Kemerdekaan</div>
                                    <div class="announcement-excerpt">
                                        Sekolah diliburkan pada tanggal 17 Agustus dalam rangka memperingati Hari Kemerdekaan RI ke-78.
                                    </div>
                                    <div class="announcement-meta">
                                        <span class="announcement-date">
                                            <i class="fas fa-clock me-1"></i>
                                            2 hari yang lalu
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="announcement-item">
                                <div class="announcement-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="announcement-content">
                                    <div class="announcement-title">Perubahan Jadwal Ujian</div>
                                    <div class="announcement-excerpt">
                                        Ujian Tengah Semester untuk kelas X dimajukan menjadi tanggal 25 Agustus 2023.
                                    </div>
                                    <div class="announcement-meta">
                                        <span class="announcement-date">
                                            <i class="fas fa-clock me-1"></i>
                                            5 hari yang lalu
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });

        // Interactive functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Quick action buttons
            const quickActionBtns = document.querySelectorAll('.quick-action-btn');
            quickActionBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const actionTitle = this.querySelector('.action-title').textContent;
                    console.log('Quick action clicked:', actionTitle);
                    // Add your navigation logic here
                });
            });

            // Registration action buttons
            const registrationBtns = document.querySelectorAll('.registration-actions .btn');
            registrationBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const action = this.getAttribute('title');
                    const name = this.closest('.registration-item').querySelector('.registration-name').textContent;
                    
                    if (action === 'Setujui') {
                        if (confirm(`Setujui pendaftaran ${name}?`)) {
                            console.log('Approved:', name);
                            // Add approval logic here
                        }
                    } else if (action === 'Tolak') {
                        if (confirm(`Tolak pendaftaran ${name}?`)) {
                            console.log('Rejected:', name);
                            // Add rejection logic here
                        }
                    }
                });
            });

            // Extracurricular management buttons
            const extracurricularBtns = document.querySelectorAll('.extracurricular-actions .btn');
            extracurricularBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const action = this.textContent.trim();
                    const name = this.closest('.extracurricular-item').querySelector('.extracurricular-name').textContent;
                    console.log('Extracurricular action:', action, 'for:', name);
                    // Add navigation logic here
                });
            });

            // Activity, agenda, and announcement item clicks
            document.querySelectorAll('.activity-item, .agenda-item, .announcement-item').forEach(item => {
                item.style.cursor = 'pointer';
                item.addEventListener('click', function() {
                    const title = this.querySelector('.activity-title, .agenda-title, .announcement-title').textContent;
                    console.log('Item clicked:', title);
                    // Add navigation logic here
                });
            });
        });
    </script>

@endsection