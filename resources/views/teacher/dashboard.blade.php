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

        .stat-primary .stat-icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .stat-success .stat-icon {
            background: linear-gradient(135deg, #059669, #047857);
        }

        .stat-warning .stat-icon {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .stat-info .stat-icon {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

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

        /* Main Menu Cards Hover Effects */
        .main-menu-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px !important;
            border: 1px solid var(--border-color);
            background: var(--bg-primary);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .main-menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .main-menu-card:hover::before {
            left: 100%;
        }

        .main-menu-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .dark .main-menu-card {
            background: var(--bg-primary);
            border-color: var(--border-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .dark .main-menu-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .main-menu-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .main-menu-icon::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s ease;
        }

        .main-menu-card:hover .main-menu-icon::after {
            width: 100px;
            height: 100px;
        }

        .main-menu-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .main-menu-subtitle {
            font-size: 0.8rem;
            color: var(--text-secondary);
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .main-menu-card:hover .main-menu-subtitle {
            opacity: 1;
            color: var(--text-primary);
        }

        /* Content Management Section */
        .content-management-section {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .content-management-title {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-btn {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.75rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .content-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .content-btn:hover::before {
            left: 100%;
        }

        .content-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .dark .content-btn:hover {
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .content-btn i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .content-btn:hover i {
            transform: scale(1.1);
        }

        .content-btn span {
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* Enhanced Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            background: var(--bg-secondary);
            border-radius: 16px;
            border: 2px dashed var(--border-color);
            transition: all 0.3s ease;
        }

        .empty-state:hover {
            border-color: #3b82f6;
            background: var(--bg-primary);
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .dark .empty-icon {
            background: linear-gradient(135deg, #374151, #4b5563);
        }

        .empty-state:hover .empty-icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            transform: scale(1.1);
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .empty-state .btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .empty-state .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
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

        .quick-action-btn.primary .action-icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .quick-action-btn.success .action-icon {
            background: linear-gradient(135deg, #059669, #047857);
        }

        .quick-action-btn.info .action-icon {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        .quick-action-btn.warning .action-icon {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

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

        .bg-primary {
            background: var(--accent-color);
            color: white;
        }

        .bg-warning {
            background: var(--warning-color);
            color: white;
        }

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

            .quick-actions-grid[style*="repeat(3, 1fr)"] {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            /* Main menu cards responsive */
            .row.g-4 .col-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .main-menu-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .main-menu-title {
                font-size: 0.9rem;
            }

            .main-menu-subtitle {
                font-size: 0.75rem;
            }

            .content-management-section {
                padding: 1rem;
            }

            .content-btn {
                padding: 0.5rem;
            }

            .content-btn i {
                font-size: 1rem;
            }

            .content-btn span {
                font-size: 0.7rem;
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

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .gap-1 {
            gap: 0.25rem;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .me-1 {
            margin-right: 0.25rem;
        }

        .me-2 {
            margin-right: 0.5rem;
        }
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
                            Selamat Datang, {{ auth()->user()->name }}! 👋
                        </h1>
                        <p class="welcome-subtitle">
                            <i class="fas fa-calendar-day me-2"></i>
                            {{ now()->format('l, d F Y - H:i') }}
                        </p>
                       
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
                        <div class="stat-number">{{ $stats['total_posts'] ?? 0 }}</div>
                        <div class="stat-label">Total Post</div>
                        <div class="stat-sublabel">{{ $stats['published_posts'] ?? 0 }} dipublikasikan</div>
                    </div>
                </div>

                <div class="stat-card stat-success" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['total_students'] ?? 0 }}</div>
                        <div class="stat-label">Total Siswa</div>
                        <div class="stat-sublabel">Di sekolah</div>
                    </div>
                </div>

                <div class="stat-card stat-warning" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $recentActivities ? $recentActivities->count() : 0 }}</div>
                        <div class="stat-label">Aktivitas Terbaru</div>
                        <div class="stat-sublabel">Dalam 30 hari</div>
                    </div>
                </div>

                <div class="stat-card stat-info" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['extracurriculars_managed'] ?? 0 }}</div>
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
                                @if($recentActivities && $recentActivities->count() > 0)
                                    @foreach($recentActivities as $activity)
                                        <div class="activity-item">
                                            <div class="activity-icon"
                                                style="background: linear-gradient(135deg, {{ $activity['color'] }}, {{ $activity['color'] }}dd);">
                                                <i class="{{ $activity['icon'] }}"></i>
                                            </div>
                                            <div class="activity-content">
                                                <div class="activity-title">{{ $activity['title'] }}</div>
                                                <div class="activity-time">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $activity['date']->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-history"></i>
                                        </div>
                                        <div class="empty-title">Belum Ada Aktivitas</div>
                                        <div class="empty-text">Mulai membuat konten untuk melihat aktivitas terbaru Anda di
                                            sini.</div>
                                        <div class="mt-3">
                                            <a href="{{ route('teacher.posts.blog.create') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-1"></i>Buat Post Pertama
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Learning Materials Management -->
                    <div class="dashboard-card" data-aos="fade-right" data-aos-delay="200">
                        <div class="card-header">
                            <div class="header-content">
                                <h5 class="card-title">
                                    <i class="fas fa-book-open me-2"></i>Materi Pembelajaran
                                </h5>
                                <a href="{{ route('teacher.learning.materials.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus me-1"></i>Tambah
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="extracurricular-grid">
                                @if($learningMaterials && $learningMaterials->count() > 0)
                                    @foreach($learningMaterials as $material)
                                        <div class="extracurricular-item">
                                            <div class="extracurricular-header">
                                                <div class="extracurricular-icon">
                                                    @if($material['type'] == 'pdf')
                                                        <i class="fas fa-file-pdf"></i>
                                                    @elseif($material['type'] == 'video')
                                                        <i class="fas fa-video"></i>
                                                    @elseif($material['type'] == 'powerpoint')
                                                        <i class="fas fa-file-powerpoint"></i>
                                                    @else
                                                        <i class="fas fa-file-alt"></i>
                                                    @endif
                                                </div>
                                                <div class="extracurricular-info">
                                                    <div class="extracurricular-name">{{ $material['title'] }}</div>
                                                    <div class="extracurricular-desc">{{ $material['description'] }}</div>
                                                </div>
                                            </div>
                                            <div class="extracurricular-stats">
                                                <div class="stat-item">
                                                    @if($material['type'] == 'video')
                                                        <i class="fas fa-play me-1"></i>
                                                        <span>{{ $material['downloads'] }} views</span>
                                                    @else
                                                        <i class="fas fa-download me-1"></i>
                                                        <span>{{ $material['downloads'] }} unduhan</span>
                                                    @endif
                                                </div>
                                                <div class="stat-item">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    <span>{{ $material['created_at']->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <div class="extracurricular-actions">
                                                <a href="{{ route('teacher.learning.materials.index') }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                <a href="{{ route('teacher.learning.materials.index') }}"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-book-open"></i>
                                        </div>
                                        <div class="empty-title">Belum Ada Materi</div>
                                        <div class="empty-text">Mulai membuat materi pembelajaran untuk siswa.</div>
                                        <div class="mt-3">
                                            <a href="{{ route('teacher.learning.materials.create') }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-1"></i>Buat Materi Pertama
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="text-center" style="margin-top: 1rem;">
                                <a href="{{ route('teacher.learning.materials.index') }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Lihat Semua Materi
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Assignments to Grade -->
                    <div class="dashboard-card" data-aos="fade-right" data-aos-delay="400">
                        <div class="card-header">
                            <div class="header-content">
                                <h5 class="card-title">
                                    <i class="fas fa-clipboard-check me-2"></i>Tugas yang Perlu Dinilai
                                </h5>
                                <span
                                    class="badge bg-warning">{{ $assignmentsToGrade ? $assignmentsToGrade->count() : 0 }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="registration-list">
                                @if($assignmentsToGrade && $assignmentsToGrade->count() > 0)
                                    @foreach($assignmentsToGrade as $assignment)
                                        <div class="registration-item">
                                            <div class="registration-avatar">
                                                <div class="avatar-img d-flex align-items-center justify-content-center"
                                                    style="background: linear-gradient(135deg, {{ $assignment['color'] }}, {{ $assignment['color'] }}dd); color: white; font-weight: bold;">
                                                    {{ $assignment['initials'] }}
                                                </div>
                                            </div>
                                            <div class="registration-info">
                                                <div class="registration-name">{{ $assignment['student_name'] }}</div>
                                                <div class="registration-email">Tugas: {{ $assignment['assignment_title'] }}</div>
                                                <div class="registration-extracurricular">
                                                    <i class="fas fa-clock me-1"></i>Dikumpulkan
                                                    {{ $assignment['submitted_at']->diffForHumans() }}
                                                </div>
                                            </div>
                                            <div class="registration-actions">
                                                <a href="{{ route('teacher.assignments.show', $assignment['assignment_id']) }}"
                                                    class="btn btn-sm btn-primary" title="Nilai">
                                                    <i class="fas fa-star"></i>
                                                </a>
                                                <a href="{{ route('teacher.assignments.show', $assignment['assignment_id']) }}"
                                                    class="btn btn-sm btn-outline-secondary" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-clipboard-check"></i>
                                        </div>
                                        <div class="empty-title">Tidak Ada Tugas untuk Dinilai</div>
                                        <div class="empty-text">Semua tugas sudah dinilai atau belum ada tugas yang dikumpulkan.
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('teacher.assignments.create') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-1"></i>Buat Tugas Baru
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="text-center" style="margin-top: 1rem;">
                                <a href="{{ route('teacher.assignments.index') }}"
                                    class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-eye me-1"></i>Lihat Semua Tugas
                                </a>
                                <a href="{{ route('teacher.grades.index') }}" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-chart-line me-1"></i>Rekap Nilai
                                </a>
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
                            <div class="quick-actions-grid" style="grid-template-columns: repeat(3, 1fr); gap: 0.75rem;">
                                <a href="{{ route('teacher.posts.blog.create') }}" class="quick-action-btn primary">
                                    <div class="action-icon">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <div class="action-text">
                                        <div class="action-title">Buat Post</div>
                                        <div class="action-subtitle">Berita & artikel</div>
                                    </div>
                                </a>

                                <a href="{{ route('teacher.learning.materials.create') }}" class="quick-action-btn success">
                                    <div class="action-icon">
                                        <i class="fas fa-book-plus"></i>
                                    </div>
                                    <div class="action-text">
                                        <div class="action-title">Buat Materi</div>
                                        <div class="action-subtitle">Materi pembelajaran</div>
                                    </div>
                                </a>

                                <a href="{{ route('teacher.assignments.create') }}" class="quick-action-btn info">
                                    <div class="action-icon">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div class="action-text">
                                        <div class="action-title">Buat Tugas</div>
                                        <div class="action-subtitle">Assignment baru</div>
                                    </div>
                                </a>

                                <a href="{{ route('teacher.students.index') }}" class="quick-action-btn warning">
                                    <div class="action-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="action-text">
                                        <div class="action-title">Kelola Siswa</div>
                                        <div class="action-subtitle">Data & informasi</div>
                                    </div>
                                </a>

                                <a href="{{ route('teacher.grades.index') }}" class="quick-action-btn primary">
                                    <div class="action-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="action-text">
                                        <div class="action-title">Nilai Siswa</div>
                                        <div class="action-subtitle">Laporan & analisis</div>
                                    </div>
                                </a>

                                <a href="{{ route('teacher.attendance.index') }}" class="quick-action-btn success">
                                    <div class="action-icon">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <div class="action-text">
                                        <div class="action-title">Absensi</div>
                                        <div class="action-subtitle">Kehadiran siswa</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Main Menu Cards -->
                    <div class="dashboard-card" data-aos="fade-left" data-aos-delay="100">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-th-large me-2"></i>Menu Utama
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Learning Management -->
                                <div class="col-6">
                                    <a href="{{ route('teacher.learning.materials.index') }}"
                                        class="main-menu-card text-decoration-none d-block h-100">
                                        <div class="card-body text-center p-4">
                                            <div class="main-menu-icon mx-auto"
                                                style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                                                <i class="fas fa-book-open"></i>
                                            </div>
                                            <h6 class="main-menu-title">Materi Pembelajaran</h6>
                                            <div class="main-menu-subtitle">Kelola materi & bahan ajar untuk siswa</div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Assignments -->
                                <div class="col-6">
                                    <a href="{{ route('teacher.assignments.index') }}"
                                        class="main-menu-card text-decoration-none d-block h-100">
                                        <div class="card-body text-center p-4">
                                            <div class="main-menu-icon mx-auto"
                                                style="background: linear-gradient(135deg, #059669, #047857);">
                                                <i class="fas fa-tasks"></i>
                                            </div>
                                            <h6 class="main-menu-title">Tugas & Assignment</h6>
                                            <div class="main-menu-subtitle">Buat & kelola tugas siswa</div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Quizzes -->
                                <div class="col-6">
                                    <a href="{{ route('teacher.quizzes.index') }}"
                                        class="main-menu-card text-decoration-none d-block h-100">
                                        <div class="card-body text-center p-4">
                                            <div class="main-menu-icon mx-auto"
                                                style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                                <i class="fas fa-question-circle"></i>
                                            </div>
                                            <h6 class="main-menu-title">Kuis & Ujian</h6>
                                            <div class="main-menu-subtitle">Buat kuis online interaktif</div>
                                        </div>
                                    </a>
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

            // Refresh activities function
            function refreshActivities() {
                const refreshBtn = document.querySelector('button[onclick="refreshActivities()"]');
                const originalText = refreshBtn.innerHTML;

                // Show loading state
                refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memuat...';
                refreshBtn.disabled = true;

                // Simulate refresh (in real app, this would be an AJAX call)
                setTimeout(() => {
                    // Restore button
                    refreshBtn.innerHTML = originalText;
                    refreshBtn.disabled = false;

                    // Show success message
                    showToast('success', 'Aktivitas berhasil diperbarui!');
                }, 1500);
            }

            // Show toast notification
            function showToast(type, message) {
                const toast = document.createElement('div');
                toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
                toast.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px; animation: slideInRight 0.3s ease-out;';
                toast.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                            <span>${message}</span>
                            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
                        </div>
                    `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 5000);
            }

            // Interactive functionality
            document.addEventListener('DOMContentLoaded', function () {
                // Quick action buttons
                const quickActionBtns = document.querySelectorAll('.quick-action-btn');
                quickActionBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const actionTitle = this.querySelector('.action-title').textContent;
                        console.log('Quick action clicked:', actionTitle);
                        // Add your navigation logic here
                    });
                });

                // Assignment action buttons
                const assignmentBtns = document.querySelectorAll('.registration-actions .btn');
                assignmentBtns.forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        const action = this.getAttribute('title');
                        const name = this.closest('.registration-item').querySelector('.registration-name').textContent;

                        if (action === 'Nilai') {
                            console.log('Grading assignment for:', name);
                            // Add grading logic here
                        } else if (action === 'Lihat') {
                            console.log('Viewing assignment for:', name);
                            // Add view logic here
                        }
                    });
                });

                // Learning material management buttons
                const materialBtns = document.querySelectorAll('.extracurricular-actions .btn');
                materialBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const action = this.textContent.trim();
                        const name = this.closest('.extracurricular-item').querySelector('.extracurricular-name').textContent;
                        console.log('Material action:', action, 'for:', name);
                        // Add navigation logic here
                    });
                });

                // Activity, agenda, and announcement item clicks
                document.querySelectorAll('.activity-item, .agenda-item, .announcement-item').forEach(item => {
                    item.style.cursor = 'pointer';
                    item.addEventListener('click', function () {
                        const title = this.querySelector('.activity-title, .agenda-title, .announcement-title').textContent;
                        console.log('Item clicked:', title);
                        // Add navigation logic here
                    });
                });
            });
        </script>

@endsection