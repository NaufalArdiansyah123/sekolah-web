@extends('layouts.admin')

@section('title', 'Pendaftaran Akun Siswa')

@section('content')
<style>
    /* Enhanced Student Account Registration Styles with Dark Mode Support */
    .registration-container {
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
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.2);
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
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-header {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        backdrop-filter: blur(10px);
    }

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
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
        position: relative;
        overflow: hidden;
    }

    .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 14px 14px 0 0;
    }

    .stat-item.total::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .stat-item.pending::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .stat-item.approved::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-item.rejected::before { background: linear-gradient(90deg, #ef4444, #dc2626); }

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

    /* Filter Section */
    .filter-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px var(--shadow-color);
    }

    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 1rem 1.5rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        background: var(--bg-primary);
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .filter-tab::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.1), transparent);
        transition: left 0.5s;
    }

    .filter-tab:hover::before {
        left: 100%;
    }

    .filter-tab.active,
    .filter-tab:hover {
        border-color: #4f46e5;
        color: #4f46e5;
        background: rgba(79, 70, 229, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.15);
        text-decoration: none;
    }

    .dark .filter-tab.active,
    .dark .filter-tab:hover {
        background: rgba(79, 70, 229, 0.2);
        color: #60a5fa;
        border-color: #60a5fa;
    }

    .filter-tab .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        background: var(--bg-secondary);
        color: var(--text-secondary);
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .filter-tab.active .badge {
        background: #4f46e5;
        color: white;
    }

    .dark .filter-tab.active .badge {
        background: #60a5fa;
        color: #1e293b;
    }

    /* Form Controls */
    .form-control, .form-select {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    /* Table Container */
    .table-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-wrapper {
        overflow-x: auto;
        width: 100%;
        max-width: 100%;
    }

    .table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        min-width: 800px;
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
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: var(--bg-secondary);
        transform: scale(1.001);
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-badge.pending {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.rejected {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.375rem;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .btn-action {
        position: relative;
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        overflow: visible;
        backdrop-filter: blur(10px);
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        opacity: 0;
        transition: all 0.3s ease;
        transform: scale(0.8);
    }

    .btn-action:hover::before {
        opacity: 1;
        transform: scale(1);
    }

    .btn-action:hover {
        transform: translateY(-2px) scale(1.05);
        text-decoration: none;
    }

    .btn-action:active {
        transform: translateY(0) scale(0.98);
        transition: all 0.1s ease;
    }

    .btn-action svg {
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
        transition: all 0.3s ease;
    }

    .btn-action:hover svg {
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    /* View Button */
    .btn-view {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 50%, #0e7490 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(6, 182, 212, 0.25);
    }

    .btn-view:hover {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #155e75 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.35);
    }

    /* Approve Button */
    .btn-approve {
        background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(16, 185, 129, 0.25);
    }

    .btn-approve:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 50%, #065f46 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
    }

    /* Reject Button */
    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(239, 68, 68, 0.25);
    }

    .btn-reject:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
    }

    /* User Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .user-avatar:hover {
        transform: scale(1.1);
        border-color: #4f46e5;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
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
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-message {
        margin-bottom: 2rem;
        line-height: 1.6;
        color: var(--text-secondary);
    }

    /* Button Styles */
    .btn-primary {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: #3730a3;
        transform: translateY(-1px);
        text-decoration: none;
        color: white;
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
        text-decoration: none;
        color: var(--text-primary);
    }

    /* CSS Variables */
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
        .registration-container {
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

        .filter-tabs {
            flex-direction: column;
        }

        .table-container {
            margin: 0 -1rem;
            border-radius: 0;
        }

        .table {
            min-width: 900px;
        }

        .table thead th,
        .table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn-action {
            min-width: 28px;
            height: 28px;
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

    /* Enhanced Modal Styles */
    .modal-content {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .dark .modal-content {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    }

    .modal-header {
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }

    .modal-title {
        color: var(--text-primary);
    }

    .modal-body {
        color: var(--text-primary);
    }

    .modal-footer {
        border-top: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }

    .btn-close {
        filter: var(--bs-btn-close-white-filter, none);
    }

    .dark .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    /* Enhanced Rejection Modal Styles */
    .rejection-modal {
        border: none;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
        animation: modalSlideIn 0.3s ease-out;
    }

    .dark .rejection-modal {
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .rejection-header {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-bottom: 1px solid rgba(239, 68, 68, 0.2);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
    }

    .dark .rejection-header {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
        border-bottom-color: rgba(239, 68, 68, 0.3);
    }

    .rejection-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        flex-shrink: 0;
    }

    .rejection-title-section {
        flex: 1;
    }

    .rejection-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #dc2626;
        transition: color 0.3s ease;
    }

    .dark .rejection-title {
        color: #f87171;
    }

    .rejection-subtitle {
        margin: 0.25rem 0 0 0;
        font-size: 0.875rem;
        color: #7f1d1d;
        opacity: 0.8;
        transition: color 0.3s ease;
    }

    .dark .rejection-subtitle {
        color: #fca5a5;
    }

    .btn-close-custom {
        width: 32px;
        height: 32px;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc2626;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .btn-close-custom:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.3);
        transform: scale(1.05);
    }

    .dark .btn-close-custom {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.3);
        color: #f87171;
    }

    .rejection-body {
        padding: 2rem;
        background: var(--bg-primary);
    }

    .student-info-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .student-info-card:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
    }

    .student-info-avatar {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .student-info-details h6 {
        margin: 0;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
    }

    .student-info-details p {
        margin: 0.25rem 0 0 0;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .rejection-form-group {
        margin-bottom: 1.5rem;
    }

    .rejection-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
        transition: color 0.3s ease;
    }

    .rejection-textarea {
        border: 2px solid var(--border-color);
        border-radius: 10px;
        padding: 1rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.875rem;
        line-height: 1.6;
        resize: vertical;
        min-height: 120px;
        transition: all 0.3s ease;
    }

    .rejection-textarea:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.15);
        background: var(--bg-primary);
        color: var(--text-primary);
        outline: none;
    }

    .rejection-help-text {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .rejection-templates {
        margin-bottom: 1rem;
    }

    .template-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 0.75rem;
    }

    .template-btn {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 0.875rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .template-btn:hover {
        background: #fef2f2;
        border-color: rgba(239, 68, 68, 0.3);
        color: #dc2626;
        transform: translateY(-1px);
    }

    .dark .template-btn:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
    }

    .rejection-footer {
        background: var(--bg-tertiary);
        border-top: 1px solid var(--border-color);
        padding: 1.5rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-cancel {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .btn-cancel:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
        color: var(--text-primary);
    }

    .btn-reject-confirm {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }

    .btn-reject-confirm:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
    }

    .btn-reject-confirm:active {
        transform: translateY(0);
    }

    /* Responsive Modal */
    @media (max-width: 768px) {
        .rejection-header {
            padding: 1rem;
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .rejection-body {
            padding: 1.5rem;
        }

        .template-buttons {
            flex-direction: column;
        }

        .template-btn {
            justify-content: center;
        }

        .rejection-footer {
            padding: 1rem;
            flex-direction: column;
        }

        .btn-cancel,
        .btn-reject-confirm {
            justify-content: center;
        }
    }
</style>

<div class="registration-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                Pendaftaran Akun Siswa
            </h1>
            <p class="page-subtitle">
                Kelola dan konfirmasi pendaftaran akun siswa - {{ $stats['total'] ?? 0 }} total, {{ $stats['pending'] ?? 0 }} menunggu konfirmasi
            </p>
            <div class="header-actions">
                <a href="{{ route('admin.student-registrations.export', request()->query()) }}" class="btn-header">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Data
                </a>
                <button class="btn-header" onclick="bulkApprove()" id="bulkApproveBtn" style="display: none;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Setujui Terpilih (<span id="selectedCount">0</span>)
                </button>
                <button class="btn-header" onclick="bulkReject()" id="bulkRejectBtn" style="display: none; background: rgba(239, 68, 68, 0.2); border-color: rgba(239, 68, 68, 0.3); color: #dc2626;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tolak Terpilih (<span id="selectedCountReject">0</span>)
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item total">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-title">Total Pendaftaran</div>
        </div>

        <div class="stat-item pending">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
            <div class="stat-title">Menunggu Konfirmasi</div>
        </div>

        <div class="stat-item approved">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['approved'] ?? 0 }}</div>
            <div class="stat-title">Disetujui</div>
        </div>

        <div class="stat-item rejected">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['rejected'] ?? 0 }}</div>
            <div class="stat-title">Ditolak</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-container">
        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="{{ route('admin.student-registrations.index') }}" 
               class="filter-tab {{ !request('status') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Semua 
                <span class="badge">{{ $stats['total'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.student-registrations.index', ['status' => 'pending']) }}" 
               class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Menunggu Konfirmasi
                <span class="badge">{{ $stats['pending'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.student-registrations.index', ['status' => 'active']) }}" 
               class="filter-tab {{ request('status') == 'active' ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Disetujui
                <span class="badge">{{ $stats['approved'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.student-registrations.index', ['status' => 'rejected']) }}" 
               class="filter-tab {{ request('status') == 'rejected' ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Ditolak
                <span class="badge">{{ $stats['rejected'] ?? 0 }}</span>
            </a>
        </div>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.student-registrations.index') }}" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari berdasarkan nama, email, NIS, atau kelas..." 
                       value="{{ request('search') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn-primary w-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Registrations Table -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                Daftar Pendaftaran
                <span class="badge" style="background: #4f46e5; color: white; padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.75rem; margin-left: 0.5rem;">{{ $registrations->total() ?? 0 }}</span>
            </h3>
        </div>

        @if($registrations->count() > 0)
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                            </th>
                            <th style="width: 25%;">Siswa</th>
                            <th style="width: 20%;">Kontak</th>
                            <th style="width: 10%;">Kelas</th>
                            <th style="width: 15%;">Orang Tua</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%;">Tanggal Daftar</th>
                            <th style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                            <tr>
                                <td>
                                    <input type="checkbox" class="registration-checkbox" value="{{ $registration->id }}" 
                                           {{ $registration->status !== 'pending' ? 'disabled' : '' }}>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $registration->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($registration->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                             alt="{{ $registration->name }}" 
                                             class="user-avatar me-3">
                                        <div>
                                            <div style="font-weight: 600; color: var(--text-primary);">{{ $registration->name }}</div>
                                            @if($registration->nis)
                                            <small style="color: var(--text-secondary);">NIS: {{ $registration->nis }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="color: var(--text-primary);">{{ $registration->email }}</div>
                                    @if($registration->phone)
                                        <small style="color: var(--text-secondary);">{{ $registration->phone }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($registration->class)
                                    <span class="badge" style="background: #4f46e5; color: white; padding: 0.375rem 0.75rem; border-radius: 8px; font-size: 0.75rem;">{{ $registration->class }}</span>
                                    @else
                                    <span style="color: var(--text-secondary);">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($registration->parent_name)
                                    <div style="color: var(--text-primary);">{{ $registration->parent_name }}</div>
                                    @if($registration->parent_phone)
                                    <small style="color: var(--text-secondary);">{{ $registration->parent_phone }}</small>
                                    @endif
                                    @else
                                    <span style="color: var(--text-secondary);">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge {{ $registration->status }}">
                                        @if($registration->status == 'pending')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Menunggu
                                        @elseif($registration->status == 'active')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Disetujui
                                        @elseif($registration->status == 'rejected')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Ditolak
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 0.8rem; color: var(--text-primary);">{{ $registration->created_at->format('d/m/Y') }}</div>
                                    <small style="color: var(--text-secondary);">{{ $registration->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-view" 
                                                onclick="viewRegistration({{ $registration->id }})"
                                                title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        @if($registration->status == 'pending')
                                            <button class="btn-action btn-approve" 
                                                    onclick="approveRegistration({{ $registration->id }})"
                                                    title="Setujui">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                            <button class="btn-action btn-reject" 
                                                    onclick="rejectRegistration({{ $registration->id }})"
                                                    title="Tolak">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($registrations->hasPages())
                <div class="d-flex justify-content-between align-items-center p-3" style="border-top: 1px solid var(--border-color);">
                    <div style="color: var(--text-secondary);">
                        Showing {{ $registrations->firstItem() }}-{{ $registrations->lastItem() }} of {{ $registrations->total() }} registrations
                    </div>
                    {{ $registrations->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <h3 class="empty-title">Belum Ada Pendaftaran</h3>
                <p class="empty-message">
                    @if(request()->hasAny(['search', 'status']))
                        Tidak ada pendaftaran yang sesuai dengan filter yang dipilih.
                    @else
                        Pendaftaran akun siswa akan muncul di sini ketika ada yang mendaftar.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.student-registrations.index') }}" class="btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset Filter
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Enhanced Rejection Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rejection-modal">
            <div class="modal-header rejection-header">
                <div class="rejection-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="rejection-title-section">
                    <h5 class="modal-title rejection-title">Tolak Pendaftaran Akun Siswa</h5>
                    <p class="rejection-subtitle">Berikan alasan yang jelas untuk penolakan ini</p>
                </div>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body rejection-body">
                <form id="rejectionForm">
                    <div class="student-info-card" id="rejectionStudentInfo">
                        <!-- Student info will be populated here -->
                    </div>
                    
                    <div class="rejection-form-group">
                        <label for="rejectionReason" class="rejection-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Alasan Penolakan
                        </label>
                        <textarea class="form-control rejection-textarea" 
                                  id="rejectionReason" 
                                  name="rejection_reason" 
                                  rows="5" 
                                  required 
                                  placeholder="Jelaskan alasan penolakan pendaftaran ini secara detail...">
                        </textarea>
                        <div class="rejection-help-text">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Alasan ini akan dikirim ke email siswa sebagai notifikasi penolakan
                        </div>
                    </div>
                    
                    <div class="rejection-templates">
                        <label class="rejection-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Template Alasan (Opsional)
                        </label>
                        <div class="template-buttons">
                            <button type="button" class="template-btn" onclick="useTemplate('data')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Data Tidak Valid
                            </button>
                            <button type="button" class="template-btn" onclick="useTemplate('verifikasi')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Gagal Verifikasi
                            </button>
                            <button type="button" class="template-btn" onclick="useTemplate('sistem')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Masalah Sistem
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer rejection-footer">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </button>
                <button type="button" class="btn-reject-confirm" onclick="submitRejection()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    Tolak Pendaftaran
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pendaftaran Akun Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Bulk Rejection Modal -->
<div class="modal fade" id="bulkRejectionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rejection-modal">
            <div class="modal-header rejection-header">
                <div class="rejection-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="rejection-title-section">
                    <h5 class="modal-title rejection-title">Tolak Pendaftaran Akun Massal</h5>
                    <p class="rejection-subtitle">Berikan alasan yang jelas untuk penolakan ini</p>
                </div>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body rejection-body">
                <form id="bulkRejectionForm">
                    <div class="alert alert-warning" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); color: #d97706; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                        <div class="d-flex align-items-center">
                            <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <strong>Peringatan:</strong> Anda akan menolak <span id="bulkRejectCount">0</span> pendaftaran sekaligus.
                        </div>
                    </div>
                    
                    <div class="rejection-form-group">
                        <label for="bulkRejectionReason" class="rejection-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Alasan Penolakan
                        </label>
                        <textarea class="form-control rejection-textarea" 
                                  id="bulkRejectionReason" 
                                  name="rejection_reason" 
                                  rows="5" 
                                  required 
                                  placeholder="Jelaskan alasan penolakan untuk semua pendaftaran yang dipilih...">
                        </textarea>
                        <div class="rejection-help-text">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Alasan ini akan dikirim ke email semua siswa yang ditolak
                        </div>
                    </div>
                    
                    <div class="rejection-templates">
                        <label class="rejection-label">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Template Alasan (Opsional)
                        </label>
                        <div class="template-buttons">
                            <button type="button" class="template-btn" onclick="useBulkTemplate('data')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Data Tidak Valid
                            </button>
                            <button type="button" class="template-btn" onclick="useBulkTemplate('verifikasi')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Gagal Verifikasi
                            </button>
                            <button type="button" class="template-btn" onclick="useBulkTemplate('sistem')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Masalah Sistem
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer rejection-footer">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </button>
                <button type="button" class="btn-reject-confirm" onclick="submitBulkRejection()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    Tolak Semua Pendaftaran
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentRegistrationId = null;

// Toggle select all checkboxes
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.registration-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActionButtons();
}

// Get selected registration IDs
function getSelectedIds() {
    const checkboxes = document.querySelectorAll('.registration-checkbox:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

// Get selected pending registration IDs
function getSelectedPendingIds() {
    const checkboxes = document.querySelectorAll('.registration-checkbox:checked');
    const selectedIds = [];
    
    checkboxes.forEach(checkbox => {
        const row = checkbox.closest('tr');
        const statusBadge = row.querySelector('.status-badge');
        if (statusBadge && statusBadge.classList.contains('pending')) {
            selectedIds.push(checkbox.value);
        }
    });
    
    return selectedIds;
}

// Update bulk action buttons visibility
function updateBulkActionButtons() {
    const selectedIds = getSelectedIds();
    const selectedPendingIds = getSelectedPendingIds();
    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
    const bulkRejectBtn = document.getElementById('bulkRejectBtn');
    const selectedCount = document.getElementById('selectedCount');
    const selectedCountReject = document.getElementById('selectedCountReject');
    
    if (selectedPendingIds.length > 0) {
        bulkApproveBtn.style.display = 'inline-flex';
        bulkRejectBtn.style.display = 'inline-flex';
        selectedCount.textContent = selectedPendingIds.length;
        selectedCountReject.textContent = selectedPendingIds.length;
    } else {
        bulkApproveBtn.style.display = 'none';
        bulkRejectBtn.style.display = 'none';
    }
}

// Add event listeners to checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.registration-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionButtons);
    });
});

// View registration detail
function viewRegistration(id) {
    fetch(`/admin/student-registrations/${id}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('detailContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Gagal memuat detail pendaftaran');
        });
}

// Approve registration
function approveRegistration(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini?')) return;
    
    fetch(`/admin/student-registrations/${id}/approve`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Terjadi kesalahan saat memproses permintaan');
    });
}

// Reject registration
function rejectRegistration(id) {
    currentRegistrationId = id;
    document.getElementById('rejectionReason').value = '';
    
    // Find the student data from the table
    const row = document.querySelector(`input[value="${id}"]`).closest('tr');
    const studentNameDiv = row.querySelector('.user-avatar').nextElementSibling.querySelector('div');
    const studentName = studentNameDiv ? studentNameDiv.textContent.trim() : 'Unknown Student';
    
    // Try to find email from the contact column
    const contactColumn = row.children[2]; // Contact column is the 3rd column (index 2)
    const emailDiv = contactColumn ? contactColumn.querySelector('div') : null;
    const studentEmail = emailDiv ? emailDiv.textContent.trim() : 'No email';
    
    const studentAvatar = row.querySelector('.user-avatar').src;
    
    // Populate student info in modal
    const studentInfoCard = document.getElementById('rejectionStudentInfo');
    studentInfoCard.innerHTML = `
        <img src="${studentAvatar}" alt="${studentName}" class="student-info-avatar">
        <div class="student-info-details">
            <h6>${studentName}</h6>
            <p>${studentEmail}</p>
        </div>
    `;
    
    new bootstrap.Modal(document.getElementById('rejectionModal')).show();
}

// This function is now defined above with enhanced features

// Bulk approve
function bulkApprove() {
    const selectedIds = getSelectedPendingIds();
    
    if (selectedIds.length === 0) {
        showToast('warning', 'Pilih minimal satu pendaftaran dengan status pending untuk disetujui');
        return;
    }
    
    if (!confirm(`Apakah Anda yakin ingin menyetujui ${selectedIds.length} pendaftaran yang dipilih?`)) return;
    
    // Show loading state
    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
    const originalText = bulkApproveBtn.innerHTML;
    bulkApproveBtn.innerHTML = `
        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Memproses...
    `;
    bulkApproveBtn.disabled = true;
    
    fetch('/admin/student-registrations/bulk-action', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            action: 'approve',
            ids: selectedIds
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Terjadi kesalahan saat memproses permintaan: ' + error.message);
    })
    .finally(() => {
        // Restore button state
        bulkApproveBtn.innerHTML = originalText;
        bulkApproveBtn.disabled = false;
    });
}

// Bulk reject
function bulkReject() {
    const selectedIds = getSelectedPendingIds();
    
    if (selectedIds.length === 0) {
        showToast('warning', 'Pilih minimal satu pendaftaran dengan status pending untuk ditolak');
        return;
    }
    
    // Update count in modal
    document.getElementById('bulkRejectCount').textContent = selectedIds.length;
    document.getElementById('bulkRejectionReason').value = '';
    
    // Show modal
    new bootstrap.Modal(document.getElementById('bulkRejectionModal')).show();
}

// Show toast notification
function showToast(type, message) {
    const toast = document.createElement('div');
    let alertClass = 'alert-danger';
    let iconPath = 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
    
    if (type === 'success') {
        alertClass = 'alert-success';
        iconPath = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
    } else if (type === 'warning') {
        alertClass = 'alert-warning';
        iconPath = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z';
    }
    
    toast.className = `alert ${alertClass} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px; animation: slideInRight 0.3s ease-out;';
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"/>
            </svg>
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

// Submit bulk rejection
function submitBulkRejection() {
    const reason = document.getElementById('bulkRejectionReason').value.trim();
    const selectedIds = getSelectedPendingIds();
    
    if (!reason) {
        // Show error animation
        const textarea = document.getElementById('bulkRejectionReason');
        textarea.style.borderColor = '#ef4444';
        textarea.style.animation = 'shake 0.5s ease-in-out';
        
        setTimeout(() => {
            textarea.style.animation = '';
        }, 500);
        
        showToast('error', 'Alasan penolakan harus diisi');
        return;
    }
    
    if (reason.length < 10) {
        showToast('error', 'Alasan penolakan terlalu singkat. Minimal 10 karakter.');
        return;
    }
    
    if (selectedIds.length === 0) {
        showToast('error', 'Tidak ada pendaftaran yang dapat ditolak.');
        return;
    }
    
    // Show loading state
    const submitBtn = document.querySelector('#bulkRejectionModal .btn-reject-confirm');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Memproses...
    `;
    submitBtn.disabled = true;
    
    fetch('/admin/student-registrations/bulk-reject', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            ids: selectedIds,
            rejection_reason: reason
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            bootstrap.Modal.getInstance(document.getElementById('bulkRejectionModal')).hide();
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message || 'Terjadi kesalahan saat menolak pendaftaran');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        
        if (error.message.includes('422')) {
            showToast('error', 'Data yang dikirim tidak valid. Pastikan alasan penolakan sudah diisi dengan benar.');
        } else if (error.message.includes('419')) {
            showToast('error', 'Sesi telah berakhir. Silakan refresh halaman dan coba lagi.');
        } else if (error.message.includes('500')) {
            showToast('error', 'Terjadi kesalahan server. Silakan coba lagi atau hubungi administrator.');
        } else {
            showToast('error', 'Terjadi kesalahan saat memproses permintaan: ' + error.message);
        }
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Template functions for rejection reasons
function useTemplate(type) {
    const textarea = document.getElementById('rejectionReason');
    let template = '';
    
    switch(type) {
        case 'data':
            template = 'Mohon maaf, akun Anda tidak dapat diaktifkan karena terdapat masalah pada data yang dimasukkan:\n\n• Data pribadi tidak valid atau tidak sesuai\n• Email yang digunakan sudah terdaftar di sistem\n• NIS/NISN tidak ditemukan dalam database siswa\n• Informasi yang diberikan tidak lengkap\n\nSilakan periksa kembali data Anda dan daftar ulang dengan informasi yang benar.';
            break;
        case 'verifikasi':
            template = 'Mohon maaf, akun Anda tidak dapat diverifikasi karena:\n\n• Data yang dimasukkan tidak dapat diverifikasi dengan database sekolah\n• Informasi kontak tidak dapat dikonfirmasi\n• Terdapat ketidaksesuaian data dengan catatan sekolah\n\nSilakan hubungi bagian administrasi sekolah untuk verifikasi data Anda.';
            break;
        case 'sistem':
            template = 'Mohon maaf, terjadi masalah teknis dalam pemrosesan akun Anda:\n\n• Sistem mengalami gangguan saat memproses data\n• Terdapat duplikasi data dalam sistem\n• Error validasi otomatis\n\nSilakan coba mendaftar ulang atau hubungi administrator sistem untuk bantuan lebih lanjut.';
            break;
    }
    
    textarea.value = template;
    textarea.focus();
    
    // Add animation effect
    textarea.style.transform = 'scale(1.02)';
    setTimeout(() => {
        textarea.style.transform = 'scale(1)';
    }, 200);
}

// Template functions for bulk rejection reasons
function useBulkTemplate(type) {
    const textarea = document.getElementById('bulkRejectionReason');
    let template = '';
    
    switch(type) {
        case 'data':
            template = 'Mohon maaf, pendaftaran Anda tidak dapat diaktifkan karena terdapat masalah pada data yang dimasukkan:\n\n• Data pribadi tidak valid atau tidak sesuai\n• Email yang digunakan sudah terdaftar di sistem\n• NIS/NISN tidak ditemukan dalam database siswa\n• Informasi yang diberikan tidak lengkap\n\nSilakan periksa kembali data Anda dan daftar ulang dengan informasi yang benar.';
            break;
        case 'verifikasi':
            template = 'Mohon maaf, pendaftaran Anda tidak dapat diverifikasi karena:\n\n• Data yang dimasukkan tidak dapat diverifikasi dengan database sekolah\n• Informasi kontak tidak dapat dikonfirmasi\n• Terdapat ketidaksesuaian data dengan catatan sekolah\n\nSilakan hubungi bagian administrasi sekolah untuk verifikasi data Anda.';
            break;
        case 'sistem':
            template = 'Mohon maaf, terjadi masalah teknis dalam pemrosesan pendaftaran Anda:\n\n• Sistem mengalami gangguan saat memproses data\n• Terdapat duplikasi data dalam sistem\n• Error validasi otomatis\n\nSilakan coba mendaftar ulang atau hubungi administrator sistem untuk bantuan lebih lanjut.';
            break;
    }
    
    textarea.value = template;
    textarea.focus();
    
    // Add animation effect
    textarea.style.transform = 'scale(1.02)';
    setTimeout(() => {
        textarea.style.transform = 'scale(1)';
    }, 200);
}

// Enhanced submit rejection with validation
function submitRejection() {
    const reason = document.getElementById('rejectionReason').value.trim();
    
    if (!reason) {
        // Show error animation
        const textarea = document.getElementById('rejectionReason');
        textarea.style.borderColor = '#ef4444';
        textarea.style.animation = 'shake 0.5s ease-in-out';
        
        setTimeout(() => {
            textarea.style.animation = '';
        }, 500);
        
        showToast('error', 'Alasan penolakan harus diisi');
        return;
    }
    
    if (reason.length < 10) {
        showToast('error', 'Alasan penolakan terlalu singkat. Minimal 10 karakter.');
        return;
    }
    
    // Show loading state
    const submitBtn = document.querySelector('.btn-reject-confirm');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Memproses...
    `;
    submitBtn.disabled = true;
    

    console.log('Submitting rejection for ID:', currentRegistrationId);
    console.log('Rejection reason:', reason);
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').content);
    
    fetch(`/admin/student-registrations/${currentRegistrationId}/reject`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            rejection_reason: reason
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            showToast('success', data.message);
            bootstrap.Modal.getInstance(document.getElementById('rejectionModal')).hide();
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message || 'Terjadi kesalahan saat menolak pendaftaran');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        
        // Try to get more detailed error information
        if (error.message.includes('422')) {
            showToast('error', 'Data yang dikirim tidak valid. Pastikan alasan penolakan sudah diisi dengan benar.');
        } else if (error.message.includes('419')) {
            showToast('error', 'Sesi telah berakhir. Silakan refresh halaman dan coba lagi.');
        } else if (error.message.includes('500')) {
            showToast('error', 'Terjadi kesalahan server. Silakan coba lagi atau hubungi administrator.');
        } else {
            showToast('error', 'Terjadi kesalahan saat memproses permintaan: ' + error.message);
        }
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats cards
    const statCards = document.querySelectorAll('.stat-item');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Add event listeners to checkboxes
    const checkboxes = document.querySelectorAll('.registration-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionButtons);
    });
    
    // Add shake animation for validation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection