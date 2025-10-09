@extends('layouts.teacher')

@section('title', 'View Announcement')

@section('content')
<style>
    .announcement-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
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
        flex: 1;
    }

    .header-actions {
        position: relative;
        z-index: 2;
        display: flex;
        gap: 0.5rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-primary {
        background: white;
        color: #059669;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #059669;
        text-decoration: none;
    }

    /* Dark mode button adjustments */
    .dark .btn-primary {
        background: rgba(255, 255, 255, 0.9);
        color: #059669;
    }

    .dark .btn-primary:hover {
        background: white;
        color: #059669;
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.1);
    }

    .dark .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dark .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .announcement-card {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .announcement-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .meta-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .meta-value {
        font-size: 0.875rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    .announcement-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .announcement-content {
        font-size: 1rem;
        line-height: 1.7;
        color: var(--text-primary);
        margin-bottom: 2rem;
    }

    .announcement-content p {
        margin-bottom: 1rem;
    }

    .announcement-content p:last-child {
        margin-bottom: 0;
    }

    .announcement-image {
        margin: 2rem 0;
        text-align: center;
    }

    .announcement-image img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 20px var(--shadow-color);
    }

    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-block;
    }

    .badge-akademik { background: rgba(59, 130, 246, 0.1); color: #1d4ed8; border: 1px solid rgba(59, 130, 246, 0.2); }
    .badge-kegiatan { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-administrasi { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-umum { background: rgba(107, 114, 128, 0.1); color: #374151; border: 1px solid rgba(107, 114, 128, 0.2); }

    .badge-low { background: rgba(107, 114, 128, 0.1); color: #374151; border: 1px solid rgba(107, 114, 128, 0.2); }
    .badge-normal { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-high { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-urgent { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); }

    .badge-published { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-draft { background: rgba(107, 114, 128, 0.1); color: #374151; border: 1px solid rgba(107, 114, 128, 0.2); }
    .badge-archived { background: rgba(75, 85, 99, 0.1); color: #1f2937; border: 1px solid rgba(75, 85, 99, 0.2); }

    /* Dark mode badge adjustments */
    .dark .badge-akademik { background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
    .dark .badge-kegiatan { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .dark .badge-administrasi { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
    .dark .badge-umum { background: rgba(107, 114, 128, 0.2); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3); }

    .dark .badge-low { background: rgba(107, 114, 128, 0.2); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3); }
    .dark .badge-normal { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .dark .badge-high { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
    .dark .badge-urgent { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }

    .dark .badge-published { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .dark .badge-draft { background: rgba(107, 114, 128, 0.2); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.3); }
    .dark .badge-archived { background: rgba(75, 85, 99, 0.2); color: #9ca3af; border: 1px solid rgba(75, 85, 99, 0.3); }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .announcement-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .announcement-card {
            padding: 1.5rem;
        }

        .announcement-title {
            font-size: 1.5rem;
        }

        .announcement-meta {
            grid-template-columns: 1fr;
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Animation */
    .announcement-card {
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
</style>

<div class="announcement-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Announcement
            </h1>
            <p class="page-subtitle">{{ $announcement->title }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('teacher.posts.announcement') }}" class="btn btn-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
            <a href="{{ route('teacher.posts.announcement.edit', $announcement->id) }}" class="btn btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $announcement->views_count ?? 0 }}</div>
            <div class="stat-label">Views</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $announcement->created_at->diffForHumans() }}</div>
            <div class="stat-label">Created</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <div class="stat-value">{{ $announcement->updated_at->diffForHumans() }}</div>
            <div class="stat-label">Updated</div>
        </div>

        @if($announcement->published_at)
        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $announcement->published_at->format('M d') }}</div>
            <div class="stat-label">Dipublikasikan</div>
        </div>
        @endif
    </div>

    <!-- Announcement Content -->
    <div class="announcement-card">
        <!-- Meta Information -->
        <div class="announcement-meta">
            <div class="meta-item">
                <div class="meta-label">Kategori</div>
                <div class="meta-value">
                    <span class="badge badge-{{ $announcement->category }}">
                        {{ ucfirst($announcement->category) }}
                    </span>
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Priority</div>
                <div class="meta-value">
                    <span class="badge badge-{{ $announcement->priority }}">
                        {{ ucfirst($announcement->priority) }}
                    </span>
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Status</div>
                <div class="meta-value">
                    <span class="badge badge-{{ $announcement->status }}">
                        {{ ucfirst($announcement->status) }}
                    </span>
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-label">Author</div>
                <div class="meta-value">{{ $announcement->author }}</div>
            </div>

            @if($announcement->published_at)
            <div class="meta-item">
                <div class="meta-label">Publication Date</div>
                <div class="meta-value">{{ $announcement->published_at->format('F d, Y \a\t H:i') }}</div>
            </div>
            @endif

            @if($announcement->expires_at)
            <div class="meta-item">
                <div class="meta-label">Expires At</div>
                <div class="meta-value">{{ $announcement->expires_at->format('F d, Y \a\t H:i') }}</div>
            </div>
            @endif
        </div>

        <!-- Title -->
        <h1 class="announcement-title">{{ $announcement->title }}</h1>

        <!-- Featured Image -->
        @if($announcement->featured_image)
        <div class="announcement-image">
            <img src="{{ asset('storage/' . $announcement->featured_image) }}" 
                 alt="{{ $announcement->title }}"
                 loading="lazy">
        </div>
        @endif

        <!-- Content -->
        <div class="announcement-content">
            {!! nl2br(e($announcement->content)) !!}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add view tracking (optional)
    // You can implement view tracking here if needed
    
    // Smooth scroll for any internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add copy link functionality
    const copyButton = document.createElement('button');
    copyButton.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
        </svg>
        Copy Link
    `;
    copyButton.className = 'btn btn-secondary';
    copyButton.style.marginLeft = '0.5rem';
    
    copyButton.addEventListener('click', function() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            const originalText = copyButton.innerHTML;
            copyButton.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Copied!
            `;
            setTimeout(function() {
                copyButton.innerHTML = originalText;
            }, 2000);
        });
    });
    
    // Add copy button to header actions
    const headerActions = document.querySelector('.header-actions');
    if (headerActions) {
        headerActions.appendChild(copyButton);
    }
});
</script>
@endsection