@props([
    'backUrl' => '#',
    'showBack' => true,
    'submitText' => 'Simpan',
    'submitIcon' => 'fas fa-save',
    'submitColor' => 'primary', // primary, success, warning, danger
    'showDraft' => false,
    'draftText' => 'Simpan Draft',
    'extraActions' => []
])

@php
    $submitColors = [
        'primary' => 'admin-btn-primary',
        'success' => 'admin-btn-success',
        'warning' => 'admin-btn-warning',
        'danger' => 'admin-btn-danger',
    ];
    $submitClass = $submitColors[$submitColor] ?? $submitColors['primary'];
@endphp

<div class="admin-form-actions">
    <div class="admin-actions-left">
        @if($showBack)
            <a href="{{ $backUrl }}" class="admin-btn admin-btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        @endif
    </div>
    
    <div class="admin-actions-right">
        @foreach($extraActions as $action)
            <button type="{{ $action['type'] ?? 'button' }}" 
                    class="admin-btn {{ $action['class'] ?? 'admin-btn-secondary' }}"
                    @if(isset($action['onclick'])) onclick="{{ $action['onclick'] }}" @endif
                    {{ $action['attributes'] ?? '' }}>
                @if(isset($action['icon']))
                    <i class="{{ $action['icon'] }} me-2"></i>
                @endif
                {{ $action['text'] }}
            </button>
        @endforeach
        
        @if($showDraft)
            <button type="submit" name="draft" value="1" class="admin-btn admin-btn-draft">
                <i class="fas fa-save me-2"></i>{{ $draftText }}
            </button>
        @endif
        
        <button type="submit" class="admin-btn {{ $submitClass }}">
            <i class="{{ $submitIcon }} me-2"></i>{{ $submitText }}
        </button>
    </div>
</div>

<style>
    /* Admin Form Actions Styles - Dark Mode Compatible */
    .admin-form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2rem;
        background: var(--bg-secondary);
        border-top: 1px solid var(--border-color);
        margin: 2rem -2rem -2rem -2rem;
        transition: all 0.3s ease;
    }

    .admin-actions-left,
    .admin-actions-right {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .admin-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        gap: 0.5rem;
    }

    .admin-btn:hover {
        text-decoration: none;
        transform: translateY(-1px);
    }

    .admin-btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .admin-btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .admin-btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .admin-btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .admin-btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .admin-btn-warning:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: white;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .admin-btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .admin-btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .admin-btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .admin-btn-secondary:hover {
        background: var(--border-color);
        color: var(--text-primary);
    }

    .admin-btn-draft {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }

    .admin-btn-draft:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        color: white;
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
    }

    /* Loading state */
    .admin-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .admin-btn.loading {
        position: relative;
        color: transparent;
    }

    .admin-btn.loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .admin-form-actions {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .admin-actions-left,
        .admin-actions-right {
            width: 100%;
            justify-content: center;
        }

        .admin-actions-left {
            order: 2;
        }

        .admin-actions-right {
            order: 1;
        }
    }

    @media (max-width: 576px) {
        .admin-actions-left,
        .admin-actions-right {
            flex-direction: column;
        }

        .admin-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading state to form submission
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtns = this.querySelectorAll('.admin-btn[type="submit"]');
                submitBtns.forEach(btn => {
                    btn.classList.add('loading');
                    btn.disabled = true;
                });
            });
        });

        // Confirmation for dangerous actions
        const dangerBtns = document.querySelectorAll('.admin-btn-danger');
        dangerBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Apakah Anda yakin ingin melakukan tindakan ini?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>