@props([
    'title' => 'Section',
    'subtitle' => '',
    'icon' => 'fas fa-info-circle',
    'borderColor' => 'blue' // blue, green, purple, orange, red
])

@php
    $borderColors = [
        'blue' => '#3b82f6',
        'green' => '#10b981',
        'purple' => '#8b5cf6',
        'orange' => '#f59e0b',
        'red' => '#ef4444',
        'indigo' => '#6366f1',
    ];
    $color = $borderColors[$borderColor] ?? $borderColors['blue'];
@endphp

<div class="admin-form-section" style="border-left-color: {{ $color }};">
    <div class="admin-section-header">
        <h2 class="admin-section-title">
            <i class="{{ $icon }} me-2"></i>{{ $title }}
        </h2>
        @if($subtitle)
            <p class="admin-section-subtitle">{{ $subtitle }}</p>
        @endif
    </div>
    
    <div class="admin-section-content">
        {{ $slot }}
    </div>
</div>

<style>
    /* Admin Form Section Styles - Dark Mode Compatible */
    .admin-form-section {
        margin-bottom: 2.5rem;
        padding: 2rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        border-left: 4px solid #3b82f6;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .admin-section-header {
        margin-bottom: 2rem;
    }

    .admin-section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .admin-section-subtitle {
        color: var(--text-secondary);
        margin: 0;
        transition: color 0.3s ease;
    }

    .admin-section-content {
        /* Content styling handled by child components */
    }

    /* Dark mode specific adjustments */
    .dark .admin-form-section {
        background: var(--bg-tertiary);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .admin-form-section {
            padding: 1.5rem;
        }
    }
</style>