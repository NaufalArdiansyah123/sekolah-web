<?php
// resources/views/layouts/teacher.blade.php - Enhanced for Mobile Compatibility
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Teacher' }} - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- jQuery (Required for Bootstrap and our modals) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUa6c+ggO+RRhqP/wjMbSU7Ik7FkgrhTEsN4koC5+ZOfhuCkPfuH9ARA" crossorigin="anonymous">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Enhanced Styles for Mobile Compatibility -->
    <style>
        /* Mobile-first responsive design */
        * {
            box-sizing: border-box;
        }
        
        /* Light Mode Colors */
        body {
            background-color: #f8fafc;
            color: #1f2937;
            transition: background-color 0.3s ease, color 0.3s ease;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }
        
        /* Dark Mode Colors */
        .dark body {
            background-color: #111827;
            color: #f9fafb;
        }
        
        /* Main Layout */
        .teacher-layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        
        /* Mobile Sidebar Overlay */
        .mobile-sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 40;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: none;
        }
        
        .mobile-sidebar-overlay.show {
            display: block;
        }
        
        .dark .mobile-sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.7);
        }
        
        /* Main Content Wrapper */
        .main-content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            margin-left: 0;
            transition: margin-left 0.3s ease;
            position: relative;
            z-index: 20;
        }
        
        @media (min-width: 769px) {
            .main-content-wrapper {
                margin-left: 16rem;
                width: calc(100% - 16rem);
            }
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            overflow-x: hidden;
            overflow-y: auto;
            background-color: #f8fafc;
            color: #1f2937;
            position: relative;
            z-index: 25;
            transition: all 0.3s ease;
        }
        
        .dark .main-content {
            background-color: #111827;
            color: #f9fafb;
        }
        
        /* Content Container */
        .content-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        @media (min-width: 640px) {
            .content-container {
                padding: 2rem;
            }
        }
        
        /* Cards and containers */
        .content-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .dark .content-card {
            background-color: #1f2937;
            border-color: #374151;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        /* Buttons */
        .btn-primary {
            background-color: #059669;
            border-color: #059669;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background-color: #047857;
            border-color: #047857;
        }
        
        .btn-secondary {
            background-color: #f1f5f9;
            border-color: #e5e7eb;
            color: #1f2937;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .dark .btn-secondary {
            background-color: #374151;
            border-color: #374151;
            color: #f9fafb;
        }
        
        .btn-secondary:hover {
            background-color: #e2e8f0;
        }
        
        .dark .btn-secondary:hover {
            background-color: #4b5563;
        }
        
        /* Form elements */
        .form-input {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            color: #1f2937;
            padding: 0.5rem 0.75rem;
            width: 100%;
            transition: all 0.2s ease;
        }
        
        .dark .form-input {
            background-color: #1f2937;
            border-color: #374151;
            color: #f9fafb;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }
        
        /* Tables */
        .table {
            background-color: #ffffff;
            color: #1f2937;
            width: 100%;
            border-collapse: collapse;
        }
        
        .dark .table {
            background-color: #1f2937;
            color: #f9fafb;
        }
        
        .table th {
            background-color: #f1f5f9;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem;
            text-align: left;
            font-weight: 600;
        }
        
        .dark .table th {
            background-color: #374151;
            border-bottom-color: #374151;
        }
        
        .table td {
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem;
        }
        
        .dark .table td {
            border-bottom-color: #374151;
        }
        
        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        
        .dark .alert-success {
            background-color: rgba(5, 150, 105, 0.1);
            border-color: rgba(5, 150, 105, 0.2);
            color: #10b981;
        }
        
        .alert-error {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        .dark .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        
        .dark ::-webkit-scrollbar-track {
            background: #111827;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 4px;
        }
        
        .dark ::-webkit-scrollbar-thumb {
            background: #374151;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }
        
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 50;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .toast {
            max-width: 24rem;
            width: 100%;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .dark .toast {
            background-color: #1f2937;
            border-color: #374151;
        }
        
        .toast.show {
            transform: translateX(0);
        }
        
        .toast-success {
            border-left: 4px solid #10b981;
        }
        
        .toast-error {
            border-left: 4px solid #ef4444;
        }
        
        .toast-icon {
            flex-shrink: 0;
            width: 1.5rem;
            height: 1.5rem;
        }
        
        .toast-content {
            flex: 1;
            min-width: 0;
        }
        
        .toast-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }
        
        .dark .toast-title {
            color: #f9fafb;
        }
        
        .toast-message {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .dark .toast-message {
            color: #d1d5db;
        }
        
        .toast-close {
            flex-shrink: 0;
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0;
            width: 1.25rem;
            height: 1.25rem;
        }
        
        .dark .toast-close {
            color: #6b7280;
        }
        
        .toast-close:hover {
            color: #6b7280;
        }
        
        .dark .toast-close:hover {
            color: #9ca3af;
        }
        
        /* Mobile improvements */
        @media (max-width: 768px) {
            .main-content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .content-container {
                padding: 1rem;
            }
            
            .toast-container {
                left: 1rem;
                right: 1rem;
            }
            
            .toast {
                max-width: none;
            }
        }
        
        /* Utility classes */
        .hidden {
            display: none !important;
        }
        
        .flex {
            display: flex;
        }
        
        .flex-1 {
            flex: 1;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .gap-4 {
            gap: 1rem;
        }
        
        .mb-4 {
            margin-bottom: 1rem;
        }
        
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        
        .mb-8 {
            margin-bottom: 2rem;
        }
        
        .p-4 {
            padding: 1rem;
        }
        
        .p-6 {
            padding: 1.5rem;
        }
        
        .rounded {
            border-radius: 0.375rem;
        }
        
        .rounded-lg {
            border-radius: 0.5rem;
        }
        
        .shadow {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="teacher-layout">
        <!-- Mobile Sidebar Overlay -->
        <div id="mobile-overlay" class="mobile-sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- Sidebar -->
        @include('layouts.teacher.sidebar')

        <!-- Main Content Wrapper -->
        <div class="main-content-wrapper">
            <!-- Top Navigation -->
            @include('layouts.teacher.navbar')

            <!-- Page Content -->
            <main class="main-content">
                <div class="content-container">
                    <!-- Alerts -->
                    @include('components.alerts')

                    <!-- Breadcrumb -->
                    @if(isset($breadcrumb))
                        @include('components.breadcrumb', ['items' => $breadcrumb])
                    @endif

                    <!-- Page Header -->
                    @if(isset($header))
                        <div class="mb-8">
                            {{ $header }}
                        </div>
                    @endif

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toast-container" class="toast-container"></div>

    @stack('scripts')

    <!-- Enhanced JavaScript for Mobile Compatibility -->
    <script>
        // Global variables
        let darkMode = localStorage.getItem('darkMode') === 'true';
        let sidebarOpen = false;
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Apply initial theme
            applyTheme();
            
            // Initialize sidebar state
            if (window.innerWidth >= 769) {
                sidebarOpen = true;
                updateSidebarVisibility();
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 769) {
                    sidebarOpen = true;
                    updateSidebarVisibility();
                } else {
                    sidebarOpen = false;
                    updateSidebarVisibility();
                }
            });
            
            // Show Laravel flash messages as toasts
            @if(session('success'))
                showToast('success', 'Berhasil!', '{{ session('success') }}');
            @endif

            @if(session('error'))
                showToast('error', 'Error!', '{{ session('error') }}');
            @endif
        });
        
        // Theme functions
        function applyTheme() {
            if (darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        
        function toggleDarkMode() {
            darkMode = !darkMode;
            localStorage.setItem('darkMode', darkMode);
            applyTheme();
            
            // Update navbar icons if they exist
            if (typeof window.toggleDarkMode === 'function') {
                // This will be called from navbar.blade.php
            }
        }
        
        // Sidebar functions
        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            updateSidebarVisibility();
        }
        
        function closeSidebar() {
            sidebarOpen = false;
            updateSidebarVisibility();
        }
        
        function updateSidebarVisibility() {
            const sidebar = document.getElementById('teacher-sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            if (sidebar) {
                if (sidebarOpen || window.innerWidth >= 769) {
                    sidebar.style.display = 'flex';
                    sidebar.classList.remove('hidden');
                } else {
                    sidebar.style.display = 'none';
                    sidebar.classList.add('hidden');
                }
            }
            
            if (overlay) {
                if (sidebarOpen && window.innerWidth < 769) {
                    overlay.classList.add('show');
                } else {
                    overlay.classList.remove('show');
                }
            }
        }
        
        // Toast notification functions
        function showToast(type, title, message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const toastId = 'toast-' + Date.now();
            
            toast.id = toastId;
            toast.className = `toast toast-${type}`;
            
            const iconHtml = type === 'success' 
                ? '<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #10b981;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                : '<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #ef4444;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            
            toast.innerHTML = `
                ${iconHtml}
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="removeToast('${toastId}')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            
            container.appendChild(toast);
            
            // Show toast with animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                removeToast(toastId);
            }, 5000);
        }
        
        function removeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }
        
        // Confirmation dialogs
        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus item ini?') {
            return confirm(message);
        }
        
        // Make functions globally available
        window.toggleSidebar = toggleSidebar;
        window.closeSidebar = closeSidebar;
        window.toggleDarkMode = toggleDarkMode;
        window.showToast = showToast;
        window.removeToast = removeToast;
        window.confirmDelete = confirmDelete;
        window.sidebarOpen = sidebarOpen;
        window.darkMode = darkMode;
    </script>
</body>
</html>