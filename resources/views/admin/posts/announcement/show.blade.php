@extends('layouts.admin')

@section('title', 'Announcement Details')

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
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(245, 158, 11, 0.2);
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
        gap: 0.75rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .btn-header {
        background: white;
        color: #f59e0b;
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
        cursor: pointer;
    }

    .btn-header:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #f59e0b;
        text-decoration: none;
    }

    .btn-header.btn-edit {
        background: #10b981;
        color: white;
    }

    .btn-header.btn-edit:hover {
        background: #059669;
        color: white;
    }

    /* Main Content Card */
    .announcement-card {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .card-header-custom {
        background: var(--bg-tertiary);
        padding: 2rem;
        border-bottom: 1px solid var(--border-color);
        position: relative;
    }

    .announcement-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 1rem 0;
        line-height: 1.3;
        transition: color 0.3s ease;
    }

    .status-badge-container {
        position: absolute;
        top: 2rem;
        right: 2rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-published { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-draft { background: rgba(107, 114, 128, 0.1); color: #374151; border: 1px solid rgba(107, 114, 128, 0.2); }
    .status-archived { background: rgba(75, 85, 99, 0.1); color: #1f2937; border: 1px solid rgba(75, 85, 99, 0.2); }

    .card-body-custom {
        padding: 2rem;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        background: var(--bg-secondary);
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-color);
    }

    .info-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: color 0.3s ease;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-primary);
        transition: color 0.3s ease;
    }

    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-akademik { background: rgba(59, 130, 246, 0.1); color: #1d4ed8; border: 1px solid rgba(59, 130, 246, 0.2); }
    .badge-kegiatan { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-administrasi { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-umum { background: rgba(107, 114, 128, 0.1); color: #374151; border: 1px solid rgba(107, 114, 128, 0.2); }

    .badge-urgent { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); }
    .badge-high { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-normal { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .badge-low { background: rgba(107, 114, 128, 0.1); color: #374151; border: 1px solid rgba(107, 114, 128, 0.2); }

    .views-badge {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Image Section */
    .image-section {
        margin-bottom: 2rem;
    }

    .announcement-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 15px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .announcement-image:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    /* Content Section */
    .content-section {
        background: var(--bg-secondary);
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
    }

    .content-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .content-body {
        color: var(--text-primary);
        line-height: 1.7;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    .content-body p {
        margin-bottom: 1rem;
    }

    .content-body p:last-child {
        margin-bottom: 0;
    }

    /* Metadata Section */
    .metadata-section {
        background: var(--bg-secondary);
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
    }

    .metadata-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .metadata-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
        transition: color 0.3s ease;
    }

    .metadata-item svg {
        color: var(--text-tertiary);
        transition: color 0.3s ease;
    }

    .code-snippet {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        font-size: 0.875rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    /* Action Buttons */
    .action-section {
        background: var(--bg-primary);
        padding: 2rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        text-align: center;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        min-width: 140px;
        justify-content: center;
    }

    .btn-edit-action {
        background: #10b981;
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-edit-action:hover {
        background: #059669;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        text-decoration: none;
    }

    .btn-toggle {
        background: #3b82f6;
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-toggle:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .btn-delete {
        background: #ef4444;
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
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

    .alert-dismissible .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        opacity: 0.6;
        cursor: pointer;
        color: inherit;
    }

    .alert-dismissible .btn-close:hover {
        opacity: 1;
    }

    /* Loading State */
    .loading-spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .announcement-container {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            padding: 1.5rem;
        }

        .header-actions {
            justify-content: center;
        }

        .page-title {
            font-size: 1.5rem;
            justify-content: center;
        }

        .card-header-custom {
            padding: 1.5rem;
        }

        .status-badge-container {
            position: static;
            margin-top: 1rem;
            text-align: center;
        }

        .card-body-custom {
            padding: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-action {
            width: 100%;
            max-width: 300px;
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
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Announcement Details
            </h1>
            <p class="page-subtitle">View and manage announcement information</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn-header btn-edit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="btn-header">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    <!-- Main Content Card -->
    <div class="announcement-card">
        <!-- Card Header -->
        <div class="card-header-custom">
            <h2 class="announcement-title">{{ $announcement->title }}</h2>
            <div class="status-badge-container">
                <span class="status-badge status-{{ $announcement->status }}">
                    {{ ucfirst($announcement->status) }}
                </span>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body-custom">
            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Kategori</div>
                    <div class="info-value">
                        <span class="badge badge-{{ $announcement->category }}">
                            {{ ucfirst($announcement->category) }}
                        </span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Priority</div>
                    <div class="info-value">
                        <span class="badge badge-{{ $announcement->priority }}">
                            @if($announcement->priority === 'urgent') 🚨 Urgent
                            @elseif($announcement->priority === 'high') ⚠️ High
                            @elseif($announcement->priority === 'normal') ✅ Normal
                            @else 📝 Low
                            @endif
                        </span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Author</div>
                    <div class="info-value">
                        {{ $announcement->author }}
                        @if($announcement->user)
                            <br><small class="text-muted">({{ $announcement->user->name }})</small>
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Views</div>
                    <div class="info-value">
                        <span class="views-badge">{{ $announcement->views_count ?? 0 }} views</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Published Date</div>
                    <div class="info-value">
                        {{ $announcement->published_at ? $announcement->published_at->format('M d, Y H:i') : 'Not published' }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">Slug</div>
                    <div class="info-value">
                        <code class="code-snippet">{{ $announcement->slug }}</code>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            @if($announcement->image)
                <div class="image-section">
                    <div class="content-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Featured Image
                    </div>
                    <img src="{{ $announcement->image }}" 
                         alt="{{ $announcement->title }}" 
                         class="announcement-image">
                </div>
            @endif

            <!-- Content Section -->
            <div class="content-section">
                <div class="content-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Announcement Content
                </div>
                <div class="content-body">
                    {!! nl2br(e($announcement->content)) !!}
                </div>
            </div>

            <!-- Metadata Section -->
            <div class="metadata-section">
                <div class="content-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Metadata
                </div>
                <div class="metadata-grid">
                    <div class="metadata-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Created: {{ $announcement->created_at->format('M d, Y H:i') }}
                    </div>
                    <div class="metadata-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Updated: {{ $announcement->updated_at->format('M d, Y H:i') }}
                    </div>
                    <div class="metadata-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        ID: #{{ $announcement->id }}
                    </div>
                    @if($announcement->expires_at)
                        <div class="metadata-item">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Expires: {{ $announcement->expires_at->format('M d, Y H:i') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <div class="action-buttons">
            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn-action btn-edit-action">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit Announcement
            </a>

            <button class="btn-action btn-toggle toggle-status" 
                    data-id="{{ $announcement->id }}" 
                    data-current-status="{{ $announcement->status }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                </svg>
                {{ $announcement->status === 'published' ? 'Set as Draft' : 'Publish' }}
            </button>

            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" 
                  method="POST" class="delete-form" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action btn-delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete Announcement
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to delete this announcement? This action cannot be undone.')) {
            e.preventDefault();
        }
    });

    // Toggle status
    document.querySelector('.toggle-status')?.addEventListener('click', function() {
        const id = this.dataset.id;
        const currentStatus = this.dataset.currentStatus;
        const newStatus = currentStatus === 'published' ? 'draft' : 'published';
        
        if (confirm(`Are you sure you want to change status to ${newStatus}?`)) {
            // Show loading state
            const originalContent = this.innerHTML;
            this.innerHTML = `
                <div class="loading-spinner"></div>
                Updating...
            `;
            this.disabled = true;

            fetch(`/admin/announcements/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update status: ' + (data.message || 'Unknown error'));
                    this.innerHTML = originalContent;
                    this.disabled = false;
                }
            })
            .catch(error => {
                alert('An error occurred: ' + error);
                this.innerHTML = originalContent;
                this.disabled = false;
            });
        }
    });

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });

    console.log('Announcement details page loaded successfully!');
});
</script>
@endsection