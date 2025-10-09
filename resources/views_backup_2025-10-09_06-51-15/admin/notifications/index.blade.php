@extends('layouts.admin')

@section('title', 'Notifikasi')

@push('styles')
<style>
    /* Remove default container padding and margins */
    .main-content {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .container {
        padding: 0 !important;
        margin: 0 !important;
        max-width: none !important;
    }
    
    .content-card {
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    /* Dark Mode Variables for Notifications */
    :root {
        /* Light Mode */
        --notif-bg-gradient-light: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --notif-card-bg-light: rgba(255, 255, 255, 0.98);
        --notif-header-gradient-light: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        --notif-item-bg-light: #ffffff;
        --notif-filter-bg-light: #f8fafc;
        --notif-text-primary-light: #1f2937;
        --notif-text-secondary-light: #6b7280;
        --notif-text-muted-light: #9ca3af;
        --notif-border-light: #e5e7eb;
        --notif-shadow-light: rgba(0, 0, 0, 0.1);
        --notif-shadow-hover-light: rgba(0, 0, 0, 0.15);
        
        /* Dark Mode */
        --notif-bg-gradient-dark: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        --notif-card-bg-dark: rgba(30, 41, 59, 0.98);
        --notif-header-gradient-dark: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
        --notif-item-bg-dark: #374151;
        --notif-filter-bg-dark: #4b5563;
        --notif-text-primary-dark: #f9fafb;
        --notif-text-secondary-dark: #d1d5db;
        --notif-text-muted-dark: #9ca3af;
        --notif-border-dark: #4b5563;
        --notif-shadow-dark: rgba(0, 0, 0, 0.3);
        --notif-shadow-hover-dark: rgba(0, 0, 0, 0.4);
    }

    .notifications-container {
        background: var(--notif-bg-gradient-light);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        margin: 0;
        padding: 0;
    }

    .dark .notifications-container {
        background: var(--notif-bg-gradient-dark);
    }

    .notifications-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }
    
    .content-wrapper {
        background: var(--notif-card-bg-light);
        backdrop-filter: blur(20px);
        box-shadow: var(--notif-shadow-light);
        margin: 0;
        padding: 0;
        width: 100%;
        overflow: hidden;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
        min-height: 100vh;
    }

    .dark .content-wrapper {
        background: var(--notif-card-bg-dark);
        box-shadow: var(--notif-shadow-dark);
    }
    
    .header-section {
        background: var(--notif-header-gradient-light);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dark .header-section {
        background: var(--notif-header-gradient-dark);
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .header-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-title i {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.75rem;
        border-radius: 16px;
        font-size: 1.5rem;
    }

    .header-subtitle {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
        font-weight: 400;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
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
    }

    .btn-header.btn-danger {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.3);
    }

    .btn-header.btn-danger:hover {
        background: rgba(239, 68, 68, 0.3);
        border-color: rgba(239, 68, 68, 0.5);
    }

    .main-content-inner {
        padding: 2rem;
        background: var(--notif-card-bg-light);
        transition: background 0.3s ease;
        max-width: 1400px;
        margin: 0 auto;
    }

    .dark .main-content-inner {
        background: var(--notif-card-bg-dark);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--notif-item-bg-light);
        padding: 1.5rem;
        border-radius: 16px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid var(--notif-border-light);
        box-shadow: 0 4px 12px var(--notif-shadow-light);
    }

    .dark .stat-card {
        background: var(--notif-item-bg-dark);
        border-color: var(--notif-border-dark);
        box-shadow: 0 4px 12px var(--notif-shadow-dark);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px var(--notif-shadow-hover-light);
    }

    .dark .stat-card:hover {
        box-shadow: 0 8px 25px var(--notif-shadow-hover-dark);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--notif-text-primary-light);
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .dark .stat-number {
        color: var(--notif-text-primary-dark);
    }

    .stat-label {
        color: var(--notif-text-secondary-light);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        transition: color 0.3s ease;
    }

    .dark .stat-label {
        color: var(--notif-text-secondary-dark);
    }

    .filter-section {
        background: var(--notif-filter-bg-light);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        border: 1px solid var(--notif-border-light);
        transition: all 0.3s ease;
    }

    .dark .filter-section {
        background: var(--notif-filter-bg-dark);
        border-color: var(--notif-border-dark);
    }

    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    
    .filter-tab {
        padding: 1rem 1.5rem;
        border: 2px solid var(--notif-border-light);
        border-radius: 12px;
        background: var(--notif-item-bg-light);
        color: var(--notif-text-secondary-light);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .dark .filter-tab {
        border-color: var(--notif-border-dark);
        background: var(--notif-item-bg-dark);
        color: var(--notif-text-secondary-dark);
    }

    .filter-tab::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s;
    }

    .filter-tab:hover::before {
        left: 100%;
    }
    
    .filter-tab.active,
    .filter-tab:hover {
        border-color: #4f46e5;
        color: #4f46e5;
        background: #f0f9ff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.15);
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
        background: var(--notif-border-light);
        color: var(--notif-text-secondary-light);
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .dark .filter-tab .badge {
        background: var(--notif-border-dark);
        color: var(--notif-text-secondary-dark);
    }
    
    .filter-tab.active .badge {
        background: #4f46e5;
        color: white;
    }

    .dark .filter-tab.active .badge {
        background: #60a5fa;
        color: #1e293b;
    }

    .advanced-filters {
        background: var(--notif-item-bg-light);
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid var(--notif-border-light);
        transition: all 0.3s ease;
    }

    .dark .advanced-filters {
        background: var(--notif-item-bg-dark);
        border-color: var(--notif-border-dark);
    }

    .form-control, .form-select {
        border: 2px solid var(--notif-border-light);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: var(--notif-item-bg-light);
        color: var(--notif-text-primary-light);
    }

    .dark .form-control, .dark .form-select {
        border-color: var(--notif-border-dark);
        background: var(--notif-item-bg-dark);
        color: var(--notif-text-primary-dark);
    }

    .form-control:focus, .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .dark .form-select option {
        background: var(--notif-item-bg-dark);
        color: var(--notif-text-primary-dark);
    }

    .form-label {
        color: var(--notif-text-primary-light);
        font-weight: 600;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .dark .form-label {
        color: var(--notif-text-primary-dark);
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }
    
    .notification-item {
        background: var(--notif-item-bg-light);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 12px var(--notif-shadow-light);
        border-left: 4px solid var(--notif-border-light);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--notif-border-light);
    }

    .dark .notification-item {
        background: var(--notif-item-bg-dark);
        box-shadow: 0 4px 12px var(--notif-shadow-dark);
        border-left-color: var(--notif-border-dark);
        border-color: var(--notif-border-dark);
    }

    .notification-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #4f46e5, #7c3aed);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .notification-item:hover::before {
        transform: scaleY(1);
    }
    
    .notification-item.unread {
        border-left-color: #4f46e5;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.1);
    }

    .dark .notification-item.unread {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(124, 58, 237, 0.05) 100%);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.2);
    }

    .notification-item.unread::after {
        content: '';
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 12px;
        height: 12px;
        background: #ef4444;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .notification-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px var(--notif-shadow-hover-light);
        border-left-color: #4f46e5;
    }

    .dark .notification-item:hover {
        box-shadow: 0 12px 30px var(--notif-shadow-hover-dark);
    }
    
    .notification-content {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
    }
    
    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .notification-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.3), transparent);
        border-radius: 50%;
    }
    
    .notification-icon.success {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
    }

    .dark .notification-icon.success {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2));
        color: #4ade80;
    }
    
    .notification-icon.warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .dark .notification-icon.warning {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2));
        color: #fbbf24;
    }
    
    .notification-icon.danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #dc2626;
    }

    .dark .notification-icon.danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2));
        color: #f87171;
    }
    
    .notification-icon.info {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1d4ed8;
    }

    .dark .notification-icon.info {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(59, 130, 246, 0.2));
        color: #60a5fa;
    }
    
    .notification-details {
        flex: 1;
        min-width: 0;
    }
    
    .notification-title {
        font-weight: 700;
        color: var(--notif-text-primary-light);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .dark .notification-title {
        color: var(--notif-text-primary-dark);
    }
    
    .notification-message {
        color: var(--notif-text-secondary-light);
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        line-height: 1.5;
        transition: color 0.3s ease;
    }

    .dark .notification-message {
        color: var(--notif-text-secondary-dark);
    }
    
    .notification-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: var(--notif-text-muted-light);
        gap: 1rem;
        transition: color 0.3s ease;
    }

    .dark .notification-meta {
        color: var(--notif-text-muted-dark);
    }

    .notification-user {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }

    .notification-user::before {
        content: '👤';
        font-size: 0.75rem;
    }

    .notification-time {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .notification-time::before {
        content: '🕒';
        font-size: 0.75rem;
    }
    
    .notification-actions {
        display: flex;
        gap: 0.75rem;
        margin-left: auto;
        flex-shrink: 0;
    }
    
    .btn-notification {
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-mark-read {
        background: var(--notif-border-light);
        color: var(--notif-text-secondary-light);
        transition: all 0.3s ease;
    }

    .dark .btn-mark-read {
        background: var(--notif-border-dark);
        color: var(--notif-text-secondary-dark);
    }
    
    .btn-mark-read:hover {
        background: #10b981;
        color: white;
        transform: scale(1.1);
    }
    
    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .dark .btn-delete {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        color: white;
        transform: scale(1.1);
    }

    .dark .btn-delete:hover {
        background: #ef4444;
        color: white;
    }
    
    .no-notifications {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--notif-text-secondary-light);
        transition: color 0.3s ease;
    }

    .dark .no-notifications {
        color: var(--notif-text-secondary-dark);
    }
    
    .no-notifications i {
        font-size: 5rem;
        margin-bottom: 2rem;
        opacity: 0.3;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .no-notifications h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--notif-text-primary-light);
        transition: color 0.3s ease;
    }

    .dark .no-notifications h3 {
        color: var(--notif-text-primary-dark);
    }

    .no-notifications p {
        font-size: 1.1rem;
        max-width: 400px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Loading Animation */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .dark .loading-overlay {
        background: rgba(30, 41, 59, 0.9);
    }

    .loading-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid var(--notif-border-light);
        border-top: 4px solid #4f46e5;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .dark .loading-spinner {
        border-color: var(--notif-border-dark);
        border-top-color: #60a5fa;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Pagination Styling */
    .pagination {
        justify-content: center;
        margin-top: 2rem;
    }

    .page-link {
        border: 2px solid var(--notif-border-light);
        color: var(--notif-text-secondary-light);
        padding: 0.75rem 1rem;
        margin: 0 0.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: var(--notif-item-bg-light);
    }

    .dark .page-link {
        border-color: var(--notif-border-dark);
        color: var(--notif-text-secondary-dark);
        background: var(--notif-item-bg-dark);
    }

    .page-link:hover {
        border-color: #4f46e5;
        color: #4f46e5;
        background: var(--notif-filter-bg-light);
    }

    .dark .page-link:hover {
        border-color: #60a5fa;
        color: #60a5fa;
        background: var(--notif-filter-bg-dark);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-color: #4f46e5;
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-section {
            padding: 1.5rem 1rem;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }

        .header-title {
            font-size: 2rem;
        }

        .header-actions {
            justify-content: center;
        }

        .main-content-inner {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .filter-tabs {
            flex-direction: column;
        }

        .filter-tab {
            justify-content: center;
        }

        .notification-content {
            gap: 1rem;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .notification-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .notification-actions {
            margin-left: 0;
            margin-top: 1rem;
        }
    }

    /* Animation for new notifications */
    .notification-item.new {
        animation: slideInRight 0.5s ease-out;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Toast notification styling for dark mode */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .dark .alert-danger {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .dark .alert-success {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        border-color: rgba(34, 197, 94, 0.3);
    }
</style>
@endpush

@section('content')
<div class="notifications-container">
    <div class="content-wrapper">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-content">
                <div>
                    <h1 class="header-title">
                        <i class="fas fa-bell"></i>
                        Manajer Notifikasi
                    </h1>
                    <p class="header-subtitle">
                        Pantau semua aktivitas sistem - {{ $stats['total'] }} total, {{ $stats['unread'] }} belum dibaca
                    </p>
                </div>
                <div class="header-actions">
                    <button class="btn-header" onclick="markAllAsRead()">
                        <i class="fas fa-check-double"></i>
                        Tandai Semua Dibaca
                    </button>
                    <button class="btn-header btn-danger" onclick="clearOldNotifications()">
                        <i class="fas fa-trash"></i>
                        Bersihkan Lama
                    </button>
                </div>
            </div>
        </div>

        <div class="main-content-inner">
            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Notifikasi</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['unread'] }}</div>
                    <div class="stat-label">Belum Dibaca</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['today'] }}</div>
                    <div class="stat-label">Hari Ini</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $stats['this_week'] }}</div>
                    <div class="stat-label">Minggu Ini</div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <!-- Filter Tabs -->
                <div class="filter-tabs">
                    <a href="{{ route('admin.notifications.index') }}" 
                       class="filter-tab {{ !request('type') ? 'active' : '' }}">
                        <i class="fas fa-list"></i>
                        Semua 
                        <span class="badge">{{ $stats['total'] }}</span>
                    </a>
                    @foreach($categories as $type => $label)
                        <a href="{{ route('admin.notifications.index', ['type' => $type]) }}" 
                           class="filter-tab {{ request('type') == $type ? 'active' : '' }}">
                            <i class="fas fa-{{ $type == 'student' ? 'user-graduate' : ($type == 'teacher' ? 'chalkboard-teacher' : ($type == 'gallery' ? 'images' : ($type == 'video' ? 'video' : 'bell'))) }}"></i>
                            {{ $label }} 
                            @if(isset($categoryStats[$type]))
                                <span class="badge">{{ $categoryStats[$type] }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
                
                <!-- Advanced Filters -->
                <div class="advanced-filters">
                    <form method="GET" action="{{ route('admin.notifications.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Kategori</label>
                            <select name="type" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $type => $label)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pencarian</label>
                            <input type="text" name="search" class="form-control" placeholder="Cari notifikasi..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="notifications-list">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}" 
                             data-id="{{ $notification->id }}">
                            <div class="notification-content">
                                <div class="notification-icon {{ $notification->color_class }}">
                                    <i class="{{ $notification->icon }}"></i>
                                </div>
                                <div class="notification-details">
                                    <div class="notification-title">{{ $notification->title }}</div>
                                    <div class="notification-message">{{ $notification->message }}</div>
                                    <div class="notification-meta">
                                        <span class="notification-user">{{ $notification->user->name }}</span>
                                        <span class="notification-time">{{ $notification->time_ago }}</span>
                                    </div>
                                </div>
                                <div class="notification-actions">
                                    @if(!$notification->is_read)
                                        <button class="btn-notification btn-mark-read" 
                                                onclick="markAsRead({{ $notification->id }})"
                                                title="Tandai sebagai dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <button class="btn-notification btn-delete" 
                                            onclick="deleteNotification({{ $notification->id }})"
                                            title="Hapus notifikasi">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="no-notifications">
                        <i class="fas fa-bell-slash"></i>
                        <h3>Belum Ada Notifikasi</h3>
                        <p>Notifikasi akan muncul ketika ada aktivitas di sistem. Semua aktivitas penting akan tercatat di sini untuk memudahkan monitoring.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>
@endsection

@push('scripts')
<script>
// Show loading overlay
function showLoading() {
    document.getElementById('loadingOverlay').classList.add('show');
}

// Hide loading overlay
function hideLoading() {
    document.getElementById('loadingOverlay').classList.remove('show');
}

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed`;
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

function markAsRead(notificationId) {
    showLoading();
    
    fetch(`/admin/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            const item = document.querySelector(`[data-id="${notificationId}"]`);
            item.classList.remove('unread');
            item.classList.add('read');
            const markReadBtn = item.querySelector('.btn-mark-read');
            if (markReadBtn) {
                markReadBtn.remove();
            }
            showToast('Notifikasi ditandai sebagai dibaca');
        } else {
            showToast('Gagal menandai notifikasi', 'danger');
        }
    })
    .catch(error => {
        hideLoading();
        showToast('Terjadi kesalahan', 'danger');
        console.error('Error:', error);
    });
}

function markAllAsRead() {
    if (!confirm('Tandai semua notifikasi sebagai dibaca?')) return;
    
    showLoading();
    
    fetch('/admin/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showToast('Semua notifikasi ditandai sebagai dibaca');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showToast('Gagal menandai semua notifikasi', 'danger');
        }
    })
    .catch(error => {
        hideLoading();
        showToast('Terjadi kesalahan', 'danger');
        console.error('Error:', error);
    });
}

function deleteNotification(notificationId) {
    if (!confirm('Hapus notifikasi ini?')) return;
    
    showLoading();
    
    fetch(`/admin/notifications/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            const item = document.querySelector(`[data-id="${notificationId}"]`);
            item.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => {
                item.remove();
            }, 300);
            showToast('Notifikasi berhasil dihapus');
        } else {
            showToast('Gagal menghapus notifikasi', 'danger');
        }
    })
    .catch(error => {
        hideLoading();
        showToast('Terjadi kesalahan', 'danger');
        console.error('Error:', error);
    });
}

function clearOldNotifications() {
    if (!confirm('Hapus semua notifikasi yang lebih dari 30 hari? Tindakan ini tidak dapat dibatalkan.')) return;
    
    showLoading();
    
    fetch('/admin/notifications/clear-old', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showToast(`${data.deleted_count} notifikasi lama telah dihapus`);
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            showToast('Gagal menghapus notifikasi lama', 'danger');
        }
    })
    .catch(error => {
        hideLoading();
        showToast('Terjadi kesalahan', 'danger');
        console.error('Error:', error);
    });
}

// Add slide out animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }
`;
document.head.appendChild(style);

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats cards
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

    // Animate notification items
    const notificationItems = document.querySelectorAll('.notification-item');
    notificationItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        item.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, index * 50);
    });

    // Animate filter tabs
    const filterTabs = document.querySelectorAll('.filter-tab');
    filterTabs.forEach((tab, index) => {
        tab.style.opacity = '0';
        tab.style.transform = 'translateY(-10px)';
        tab.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        
        setTimeout(() => {
            tab.style.opacity = '1';
            tab.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>
@endpush