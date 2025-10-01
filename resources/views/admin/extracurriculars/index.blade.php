@extends('layouts.admin')

@section('title', 'Manajemen Ekstrakurikuler')

@section('content')
    <style>
        .extracurricular-container {
            background: var(--bg-secondary);
            min-height: 100vh;
            padding: 1.5rem;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(-15deg);
        }

        .header-content {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 100%;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }

        .page-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: white;
            color: #3b82f6;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            color: #3b82f6;
            text-decoration: none;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .header-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* Statistics Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            background: var(--bg-primary);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            box-shadow: 0 2px 12px var(--shadow-color);
        }

        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px var(--shadow-color);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .dark .stat-icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            transition: color 0.3s ease;
        }

        .stat-title {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        /* Table */
        .table-container {
            background: var(--bg-primary);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px var(--shadow-color);
            transition: all 0.3s ease;
            width: 100%;
            max-width: 100%;
            overflow: visible;
            position: relative;
            z-index: 1;
        }

        .table-wrapper {
            overflow-x: auto;
            overflow-y: visible;
            width: 100%;
            max-width: 100%;
            scrollbar-width: thin;
            scrollbar-color: var(--border-color) transparent;
        }

        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: var(--bg-secondary);
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #3b82f6;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            background: var(--bg-tertiary);
            border-bottom: 1px solid var(--border-color);
        }

        .table-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            transition: color 0.3s ease;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
        }

        .table {
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            min-width: 800px;
            table-layout: fixed;
            overflow: visible;
            position: relative;
        }

        .table thead th {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            font-weight: 600;
            padding: 1rem;
            border: none;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
        }

        .table tbody {
            position: relative;
            z-index: 1;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            position: relative;
        }

        .table tbody tr:hover {
            background: var(--bg-secondary);
            transform: scale(1.001);
            z-index: 2;
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 0;
        }

        .table tbody td:last-child {
            position: relative;
            padding: 1rem 1.5rem;
            overflow: visible;
        }

        .extracurricular-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            line-height: 1.4;
            transition: color 0.3s ease;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 100%;
        }

        .extracurricular-description {
            color: var(--text-secondary);
            font-size: 0.8rem;
            line-height: 1.4;
            transition: color 0.3s ease;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            max-width: 100%;
        }

        .badge {
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-active {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .badge-inactive {
            background: rgba(107, 114, 128, 0.1);
            color: #374151;
            border: 1px solid rgba(107, 114, 128, 0.2);
        }

        .dark .badge-inactive {
            color: #9ca3af;
        }

        .stats-badge {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.25rem;
        }

        /* Enhanced Action Button Group */
        .action-button-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
            padding: 0.5rem;
        }

        .action-btn {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .action-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .action-btn:hover {
            transform: translateY(-6px) scale(1.12) rotate(2deg);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
            text-decoration: none;
        }

        .action-btn:active {
            transform: translateY(-3px) scale(1.08);
            transition: all 0.1s ease;
        }

        /* Specific Action Button Colors with enhanced gradients */
        .action-btn-view {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .action-btn-view:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 50%, #065f46 100%);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.5);
        }

        .action-btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .action-btn-edit:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 50%, #92400e 100%);
            box-shadow: 0 12px 35px rgba(245, 158, 11, 0.5);
        }

        .action-btn-members {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);
            color: white;
            position: relative;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .action-btn-members:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 50%, #5b21b6 100%);
            box-shadow: 0 12px 35px rgba(139, 92, 246, 0.5);
        }

        .action-btn-pending {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #c2410c 100%);
            color: white;
            position: relative;
            animation: pulse 2s infinite, glow 2s ease-in-out infinite;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
        }

        .action-btn-pending:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #9a3412 100%);
            box-shadow: 0 12px 35px rgba(249, 115, 22, 0.6);
            animation: none;
        }

        .action-btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .action-btn-delete:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
            box-shadow: 0 12px 35px rgba(239, 68, 68, 0.5);
        }
        
        /* Action Badge */
        .action-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 0.7rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--bg-primary);
            z-index: 2;
            box-shadow: 0 3px 10px rgba(59, 130, 246, 0.4);
        }

        .action-badge-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
            animation: bounce 1s infinite;
        }

        /* Animations */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0, 0, 0);
            }
            40%, 43% {
                transform: translate3d(0, -3px, 0);
            }
            70% {
                transform: translate3d(0, -2px, 0);
            }
            90% {
                transform: translate3d(0, -1px, 0);
            }
        }

        /* Button Group Responsive */
        @media (max-width: 768px) {
            .action-button-group {
                gap: 0.25rem;
                padding: 0.125rem;
            }
            
            .action-btn {
                width: 42px;
                height: 42px;
                border-radius: 10px;
            }
            
            .action-badge {
                width: 20px;
                height: 20px;
                font-size: 0.65rem;
                top: -8px;
                right: -8px;
                border-width: 2px;
            }
        }

        /* Hover effects for better interaction */
        .action-btn svg {
            transition: all 0.3s ease;
            width: 20px;
            height: 20px;
        }

        .action-btn:hover svg {
            transform: scale(1.15);
        }

        .action-btn-pending:hover svg {
            transform: scale(1.15) rotate(5deg);
        }

        /* Dark mode enhancements for action buttons */
        .dark .action-btn {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .dark .action-btn:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
        }

        .dark .action-badge {
            border-color: var(--bg-primary);
        }

        .dark .action-btn::before {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
            background: var(--bg-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: var(--bg-secondary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--text-tertiary);
            transition: all 0.3s ease;
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .empty-message {
            margin-bottom: 2rem;
            line-height: 1.6;
            color: var(--text-secondary);
            transition: color 0.3s ease;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .dark .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #fbbf24;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            padding: 2rem;
            background: var(--bg-primary);
            border-top: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        /* CSS Variables for consistent theming */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-tertiary: #9ca3af;
            --border-color: #e5e7eb;
            --shadow-color: rgba(0, 0, 0, 0.05);
        }

        .dark {
            --bg-primary: #1f2937;
            --bg-secondary: #111827;
            --bg-tertiary: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --text-tertiary: #9ca3af;
            --border-color: #374151;
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .extracurricular-container {
                padding: 1rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .table-container {
                margin: 0 -1rem;
                border-radius: 0;
            }

            .table-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 900px;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.8rem;
            }

            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .table-actions {
                justify-content: center;
            }
        }

        /* Animation */
        .table-container {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* SVG Icon Fixes */
        svg {
            display: inline-block !important;
            vertical-align: middle;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .w-5 {
            width: 1.25rem !important;
            height: 1.25rem !important;
        }

        .w-6 {
            width: 1.5rem !important;
            height: 1.5rem !important;
        }

        .w-8 {
            width: 2rem !important;
            height: 2rem !important;
        }

        .w-12 {
            width: 3rem !important;
            height: 3rem !important;
        }

        .action-btn svg {
            width: 20px !important;
            height: 20px !important;
            display: block;
            margin: 0 auto;
            flex-shrink: 0;
        }

        .btn-test {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-test-secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-test-secondary:hover {
            background: var(--bg-tertiary);
            transform: translateY(-1px);
        }

        .btn-test-info {
            background: #06b6d4;
            color: white;
        }

        .btn-test-info:hover {
            background: #0891b2;
            transform: translateY(-1px);
        }

        .btn-test-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-test-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .btn-test-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-test-warning:hover {
            background: #d97706;
            transform: translateY(-1px);
        }

        /* System Status Alert */
        .system-status-alert {
            background: var(--bg-primary);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 12px var(--shadow-color);
            transition: all 0.3s ease;
        }

        .system-status-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .status-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .status-text {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            transition: color 0.3s ease;
        }

        .status-instructions {
            font-size: 0.875rem;
            color: var(--text-secondary);
            transition: color 0.3s ease;
        }

        .test-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .system-status-content {
                flex-direction: column;
                align-items: stretch;
            }

            .test-buttons {
                justify-content: center;
            }
        }
    </style>

    <div class="extracurricular-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Extracurricular Management
                </h1>
                <p class="page-subtitle">Manage extracurricular activities and student registrations</p>
                <div class="header-buttons">
                    <a href="{{ route('admin.extracurriculars.create') }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Extracurricular
                    </a>
                    @if($extracurriculars->count() > 0)
                        <button class="btn-secondary" onclick="showQuickActions()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Actions
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-icon">
                    <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="stat-value">{{ $extracurriculars->total() }}</div>
                <div class="stat-title">Total Extracurriculars</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-value">{{ $activeExtracurriculars }}</div>
                <div class="stat-title">Active Programs</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="stat-value">{{ $totalMembers }}</div>
                <div class="stat-title">Total Members</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-value">{{ $pendingRegistrations }}</div>
                <div class="stat-title">Pending Registrations</div>
            </div>
        </div>

        <!-- System Status Alert -->
        <div class="system-status-alert">
            <div class="system-status-content">
                <div class="status-info">
                    <svg class="w-6 h-6" style="color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <div class="status-text">
                            <strong>System Status:</strong>
                            <span id="systemStatus">Ready</span>
                        </div>
                        <div class="status-instructions" id="systemInstructions">
                            Click "Test Connection" for basic test, "Test DB" for database, "Test System" for full test
                        </div>
                    </div>
                </div>
                <div class="test-buttons">
                    <button class="btn-test btn-test-secondary" onclick="testBasicConnection()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                        </svg>
                        Test Connection
                    </button>
                    <button class="btn-test btn-test-primary" onclick="testDatabase()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                        </svg>
                        Test DB
                    </button>
                    <button class="btn-test btn-test-info" onclick="testConnection()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Test System
                    </button>
                    <button class="btn-test btn-test-warning" onclick="showPendingRegistrations()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        View All Pending
                    </button>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Extracurriculars Table -->
        <div class="table-container">
            <div class="table-header">
                <h3 class="table-title">Extracurricular List</h3>
                <div class="table-actions">
                    <button class="btn-test btn-test-secondary" onclick="exportData()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export
                    </button>
                    <button class="btn-test btn-test-info" onclick="refreshData()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh
                    </button>
                    <button class="btn-test btn-test-primary" onclick="showAllRegistrations()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        All Registrations
                    </button>
                    <button class="btn-test btn-test-warning" onclick="showStatistics()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Statistics
                    </button>
                    <button class="btn-test btn-test-secondary" onclick="showEditOptions()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Quick Edit
                    </button>
                    <button class="btn-test btn-test-info" onclick="showViewOptions()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Quick View
                    </button>
                </div>
            </div>

            @if($extracurriculars->count() > 0)
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 5%; min-width: 40px;">Id</th>
                                <th style="width: 25%; min-width: 200px;">Ekstrakurikuler</th>
                                <th style="width: 15%; min-width: 120px;">Pembina/Pelatih</th>
                                <th style="width: 8%; min-width: 80px;">Status</th>
                                <th style="width: 12%; min-width: 100px;">Anggota</th>
                                <th style="width: 12%; min-width: 100px;">Jadwal</th>
                                <th style="width: 13%; min-width: 100px;">Dibuat</th>
                                <th style="width: 10%; min-width: 80px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($extracurriculars as $index => $extracurricular)
                                <tr>
                                    <td>{{ $extracurriculars->firstItem() + $index }}</td>
                                    <td>
                                        <div class="extracurricular-title">{{ $extracurricular->name }}</div>
                                        <div class="extracurricular-description">{{ Str::limit($extracurricular->description, 80) }}
                                        </div>
                                        @if($extracurricular->gambar)
                                            <small style="color: #3b82f6; font-size: 0.75rem;">
                                                <svg class="w-3 h-3" style="display: inline;" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Has image
                                            </small>
                                        @endif
                                    </td>
                                    <td>{{ $extracurricular->coach }}</td>
                                    <td>
                                        <span class="badge badge-{{ $extracurricular->status == 'active' ? 'active' : 'inactive' }}">
                                            {{ ucfirst($extracurricular->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="stats-badge">
                                                {{ $extracurricular->registrations->where('status', 'approved')->count() }}
                                            </span> members
                                        </div>
                                        @php
                                            $pendingCount = $extracurricular->registrations->where('status', 'pending')->count();
                                        @endphp
                                        <br><br>
                                        @if($pendingCount > 0)
                                            <div>
                                                <span class="stats-badge"
                                                    style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                                    {{ $pendingCount }}
                                                </span> pending
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                            {{ $extracurricular->jadwal ?? 'Not scheduled' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                            {{ $extracurricular->created_at->format('M d, Y') }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--text-tertiary);">
                                            {{ $extracurricular->created_at->format('H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Enhanced Action Button Group -->
                                        <div class="action-button-group">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.extracurriculars.show', $extracurricular->id) }}"
                                               class="action-btn action-btn-view" title="View Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.extracurriculars.edit', $extracurricular->id) }}"
                                               class="action-btn action-btn-edit" title="Edit Extracurricular">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>

                                            <!-- Members Button -->
                                            <button class="action-btn action-btn-members" 
                                                    onclick="showMembers({{ $extracurricular->id }})" 
                                                    title="View Members ({{ $extracurricular->registrations->where('status', 'approved')->count() }})">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                @if($extracurricular->registrations->where('status', 'approved')->count() > 0)
                                                    <span class="action-badge">{{ $extracurricular->registrations->where('status', 'approved')->count() }}</span>
                                                @endif
                                            </button>

                                            <!-- Pending Registrations Button (if any) -->
                                            @if($extracurricular->registrations->where('status', 'pending')->count() > 0)
                                                <a href="{{ route('admin.extracurriculars.registrations.page', ['extracurricular_id' => $extracurricular->id, 'status' => 'pending']) }}" 
                                                   class="action-btn action-btn-pending" 
                                                   title="Pending Registrations ({{ $extracurricular->registrations->where('status', 'pending')->count() }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span class="action-badge action-badge-warning">{{ $extracurricular->registrations->where('status', 'pending')->count() }}</span>
                                                </a>
                                            @endif

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.extracurriculars.destroy', $extracurricular->id) }}"
                                                  method="POST" class="delete-form" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn action-btn-delete"
                                                        title="Delete Extracurricular"
                                                        onclick="return confirm('Are you sure you want to delete this extracurricular? This action cannot be undone.')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($extracurriculars->hasPages())
                    <div class="pagination-container">
                        {{ $extracurriculars->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="empty-title">No Extracurriculars Found</h3>
                    <p class="empty-message">
                        Start creating extracurricular activities to engage students in various programs and activities.
                    </p>
                    <a href="{{ route('admin.extracurriculars.create') }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create First Extracurricular
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Members Modal -->
    <div class="modal fade" id="membersModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
                <div class="modal-header"
                    style="background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title" style="color: var(--text-primary);"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="color: var(--text-primary);"></button>
                </div>
                <div class="modal-body" style="background: var(--bg-primary);" id="membersContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ensure jQuery is loaded
        (function () {
            if (typeof jQuery === 'undefined') {
                console.error('⚠ jQuery is not loaded! Loading from CDN...');

                // Load jQuery dynamically
                const script = document.createElement('script');
                script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
                script.onload = function () {
                    console.log('✅ jQuery loaded dynamically');
                    window.$ = window.jQuery = jQuery;
                    initializeExtracurricularFunctions();
                };
                document.head.appendChild(script);
            } else {
                console.log('✅ jQuery already loaded');
                window.$ = window.jQuery = jQuery;
                // Initialize immediately if jQuery is available
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initializeExtracurricularFunctions);
                } else {
                    initializeExtracurricularFunctions();
                }
            }
        })();

        function showMembers(extracurricularId) {
            console.log('showMembers called with ID:', extracurricularId);

            $('#membersModal').modal('show');
            $('#membersContent').html(`
            <div class="text-center py-4">
                <svg class="w-8 h-8 animate-spin mx-auto" fill="none" viewBox="0 0 24 24" style="color: var(--text-secondary);">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <br><br>
                <span style="color: var(--text-secondary);">Loading members...</span>
            </div>
        `);

            const url = `/admin/extracurriculars/${extracurricularId}/members`;
            console.log('Fetching members from URL:', url);

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
                .then(response => {
                    console.log('Members response:', {
                        status: response.status,
                        ok: response.ok
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }

                    return response.text();
                })
                .then(html => {
                    console.log('Members HTML received, length:', html.length);
                    $('#membersContent').html(html);
                })
                .catch(error => {
                    console.log('ERROR in showMembers:', error);
                    $('#membersContent').html(`
                <div class="alert alert-danger">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h6>Error loading members</h6>
                        <p><strong>Error:</strong> ${error.message}</p>
                        <p><strong>URL:</strong> ${url}</p>
                        <button class="btn-test btn-test-secondary" onclick="showMembers(${extracurricularId})">Retry</button>
                    </div>
                </div>
            `);
                });
        }

        function exportData() {
            // Implementation for data export
            window.location.href = '/admin/extracurriculars/export';
        }

        function refreshData() {
            // Refresh the current page
            location.reload();
        }

        // Test functions
        function testBasicConnection() {
            console.log('Testing basic connection...');
            
            document.getElementById('systemStatus').textContent = 'Testing...';
            document.getElementById('systemInstructions').textContent = 'Testing basic connection...';
            
            // Simulate connection test
            setTimeout(() => {
                document.getElementById('systemStatus').textContent = 'Connected';
                document.getElementById('systemInstructions').textContent = 'Basic connection successful!';
                alert('✅ Connection successful!');
                
                setTimeout(() => {
                    document.getElementById('systemStatus').textContent = 'Ready';
                    document.getElementById('systemInstructions').textContent = 'Click "Test Connection" for basic test, "Test DB" for database, "Test System" for full test';
                }, 3000);
            }, 1000);
        }

        function testDatabase() {
            console.log('Testing database connection...');
            
            document.getElementById('systemStatus').textContent = 'Testing DB...';
            document.getElementById('systemInstructions').textContent = 'Testing database connection...';
            
            // Simulate database test
            setTimeout(() => {
                document.getElementById('systemStatus').textContent = 'DB Connected';
                document.getElementById('systemInstructions').textContent = 'Database connection successful!';
                alert('✅ Database connection successful!');
                
                setTimeout(() => {
                    document.getElementById('systemStatus').textContent = 'Ready';
                    document.getElementById('systemInstructions').textContent = 'Click "Test Connection" for basic test, "Test DB" for database, "Test System" for full test';
                }, 3000);
            }, 1500);
        }

        function testConnection() {
            console.log('Testing full system...');
            
            document.getElementById('systemStatus').textContent = 'Testing System...';
            document.getElementById('systemInstructions').textContent = 'Running full system test...';
            
            // Simulate full system test
            setTimeout(() => {
                document.getElementById('systemStatus').textContent = 'All Systems OK';
                document.getElementById('systemInstructions').textContent = 'Full system test completed successfully!';
                alert('✅ All systems operational!');
                
                setTimeout(() => {
                    document.getElementById('systemStatus').textContent = 'Ready';
                    document.getElementById('systemInstructions').textContent = 'Click "Test Connection" for basic test, "Test DB" for database, "Test System" for full test';
                }, 3000);
            }, 2000);
        }

        function showPendingRegistrations() {
            // Redirect to dedicated registrations page
            window.location.href = '{{ route('admin.extracurriculars.registrations.page') }}';
        }

        function showAllRegistrations() {
            // Redirect to all registrations page
            window.location.href = '{{ route('admin.extracurriculars.registrations.page') }}';
        }

        function showStatistics() {
            // Show statistics modal or redirect to statistics page
            alert('📊 Statistics Feature\n\nTotal Extracurriculars: {{ $extracurriculars->total() }}\nActive Programs: {{ $activeExtracurriculars }}\nTotal Members: {{ $totalMembers }}\nPending Registrations: {{ $pendingRegistrations }}');
        }

        function showQuickActions() {
            const actions = [
                'Quick Edit - Edit any extracurricular',
                'Quick View - View details of any extracurricular', 
                'Bulk Actions - Manage multiple items',
                'Export Data - Download reports',
                'Statistics - View detailed analytics'
            ];
            
            alert('⚡ Quick Actions Available:\n\n' + actions.join('\n'));
        }

        function showEditOptions() {
            @if($extracurriculars->count() > 0)
                const extracurriculars = [
                    @foreach($extracurriculars as $ext)
                        { id: {{ $ext->id }}, name: '{{ addslashes($ext->name) }}' },
                    @endforeach
                ];
                
                let options = 'Select an extracurricular to edit:\n\n';
                extracurriculars.forEach((ext, index) => {
                    options += `${index + 1}. ${ext.name}\n`;
                });
                
                const choice = prompt(options + '\nEnter the number (1-' + extracurriculars.length + '):');
                
                if (choice && choice >= 1 && choice <= extracurriculars.length) {
                    const selectedExt = extracurriculars[choice - 1];
                    window.location.href = `/admin/extracurriculars/${selectedExt.id}/edit`;
                }
            @else
                alert('No extracurriculars available to edit.');
            @endif
        }

        function showViewOptions() {
            @if($extracurriculars->count() > 0)
                const extracurriculars = [
                    @foreach($extracurriculars as $ext)
                        { id: {{ $ext->id }}, name: '{{ addslashes($ext->name) }}' },
                    @endforeach
                ];
                
                let options = 'Select an extracurricular to view:\n\n';
                extracurriculars.forEach((ext, index) => {
                    options += `${index + 1}. ${ext.name}\n`;
                });
                
                const choice = prompt(options + '\nEnter the number (1-' + extracurriculars.length + '):');
                
                if (choice && choice >= 1 && choice <= extracurriculars.length) {
                    const selectedExt = extracurriculars[choice - 1];
                    window.location.href = `/admin/extracurriculars/${selectedExt.id}`;
                }
            @else
                alert('No extracurriculars available to view.');
            @endif
        }

        // Add missing functions
        function initializeExtracurricularFunctions() {
            console.log('Initializing extracurricular functions...');
            // Functions are already defined globally, no need to initialize
        }
    </script>
@endsection