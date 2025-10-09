@props([
    'title' => 'Form',
    'subtitle' => '',
    'icon' => 'fas fa-edit',
    'headerColor' => 'blue', // blue, green, purple, orange, red
    'backUrl' => '#',
    'showBack' => true
])

@php
    $headerColors = [
        'blue' => 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
        'green' => 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
        'purple' => 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)',
        'orange' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
        'red' => 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
        'indigo' => 'linear-gradient(135deg, #6366f1 0%, #4f46e5 100%)',
    ];
    $gradientColor = $headerColors[$headerColor] ?? $headerColors['blue'];
@endphp

<div class="admin-form-container">
    <!-- Form Header -->
    <div class="admin-form-header" style="background: {{ $gradientColor }};">
        <div class="admin-form-header-content">
            <div class="admin-form-icon">
                <i class="{{ $icon }}"></i>
            </div>
            <div class="admin-form-header-text">
                <h1 class="admin-form-title">{{ $title }}</h1>
                @if($subtitle)
                    <p class="admin-form-subtitle">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
        @if($showBack)
            <a href="{{ $backUrl }}" class="admin-btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        @endif
    </div>

    <!-- Form Body -->
    <div class="admin-form-body">
        {{ $slot }}
    </div>
</div>

<style>
    /* Admin Form Container Styles - Dark Mode Compatible */
    .admin-form-container {
        background: var(--bg-primary);
        border-radius: 16px;
        box-shadow: 0 10px 30px var(--shadow-color);
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .admin-form-header {
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .admin-form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .admin-form-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex: 1;
    }

    .admin-form-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
    }

    .admin-form-header-text {
        flex: 1;
    }

    .admin-form-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        margin: 0;
    }

    .admin-form-subtitle {
        opacity: 0.9;
        margin: 0.5rem 0 0 0;
        font-size: 1.1rem;
    }

    .admin-btn-back {
        position: relative;
        z-index: 2;
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
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .admin-btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .admin-form-body {
        padding: 2rem;
        background: var(--bg-primary);
        transition: all 0.3s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .admin-form-header {
            flex-direction: column;
            gap: 1.5rem;
            text-align: center;
        }

        .admin-form-header-content {
            flex-direction: column;
            text-align: center;
        }

        .admin-form-body {
            padding: 1.5rem;
        }

        .admin-form-title {
            font-size: 1.5rem;
        }
    }
</style>