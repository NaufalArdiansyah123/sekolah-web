<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pendaftaran Ditutup - {{ config('app.name', 'SMA Negeri 1') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<style>
    :root {
        --primary-color: #059669;
        --primary-dark: #047857;
        --secondary-color: #10b981;
        --accent-color: #34d399;
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --text-tertiary: #9ca3af;
        --border-color: #e5e7eb;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --warning-color: #f59e0b;
        --error-color: #ef4444;
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

    body {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
        min-height: 100vh;
        font-family: 'Figtree', sans-serif;
    }

    .closed-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .closed-card {
        background: var(--bg-primary);
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 100%;
        max-width: 600px;
        overflow: hidden;
        position: relative;
        text-align: center;
    }

    .closed-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #f59e0b, #d97706, #b45309);
    }

    .closed-header {
        padding: 3rem 2rem 2rem;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.05), rgba(217, 119, 6, 0.05));
        border-bottom: 1px solid var(--border-color);
    }

    .closed-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .closed-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .closed-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .closed-content {
        padding: 2rem;
    }

    .closed-message {
        background: rgba(245, 158, 11, 0.1);
        border: 2px solid rgba(245, 158, 11, 0.2);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: #92400e;
        font-size: 1rem;
        line-height: 1.6;
    }

    .dark .closed-message {
        background: rgba(245, 158, 11, 0.2);
        border-color: rgba(245, 158, 11, 0.3);
        color: #fbbf24;
    }

    .info-section {
        background: var(--bg-secondary);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
    }

    .info-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        color: var(--text-secondary);
        border-bottom: 1px solid var(--border-color);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-icon {
        width: 20px;
        height: 20px;
        color: var(--primary-color);
        flex-shrink: 0;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 1rem;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #047857, #059669);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 2px solid var(--border-color);
        box-shadow: 0 4px 15px var(--shadow-color);
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        color: var(--text-primary);
        text-decoration: none;
    }

    .back-link {
        position: absolute;
        top: 2rem;
        left: 2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }

    .back-link:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        transform: translateX(-5px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .closed-container {
            padding: 1rem;
        }

        .closed-card {
            border-radius: 16px;
        }

        .closed-header {
            padding: 2rem 1rem 1.5rem;
        }

        .closed-title {
            font-size: 2rem;
        }

        .closed-content {
            padding: 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .back-link {
            position: relative;
            top: auto;
            left: auto;
            margin-bottom: 1rem;
            display: inline-flex;
            background: rgba(255, 255, 255, 0.9);
            color: var(--warning-color);
        }
    }

    /* Animation */
    .closed-card {
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<body>
    <div class="closed-container">
        <!-- Back to Home Link -->
        <a href="{{ route('home') }}" class="back-link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>

        <div class="closed-card">
            <!-- Header -->
            <div class="closed-header">
                <div class="closed-icon">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="closed-title">Pendaftaran Ditutup</h1>
                <p class="closed-subtitle">
                    Pendaftaran akun siswa saat ini sedang tidak tersedia
                </p>
            </div>

            <!-- Content -->
            <div class="closed-content">
                <div class="closed-message fade-in">
                    <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    {{ $message ?? 'Pendaftaran akun siswa saat ini sedang ditutup. Silakan hubungi administrator sekolah untuk informasi lebih lanjut.' }}
                </div>

                <div class="info-section fade-in">
                    <h3 class="info-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Penting
                    </h3>
                    <ul class="info-list">
                        <li class="info-item">
                            <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pendaftaran akun siswa sedang dalam masa penutupan
                        </li>
                        <li class="info-item">
                            <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Siswa yang sudah memiliki akun tetap dapat login
                        </li>
                        <li class="info-item">
                            <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Hubungi bagian administrasi untuk bantuan
                        </li>
                        <li class="info-item">
                            <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Pendaftaran akan dibuka kembali sesuai jadwal sekolah
                        </li>
                    </ul>
                </div>

                <div class="action-buttons fade-in">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Login (Jika Sudah Punya Akun)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add fade-in animation to elements
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.2}s`;
            });
        });
    </script>
</body>
</html>