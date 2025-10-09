@extends('layouts.admin')

@section('title', 'Facility Details')

@section('content')
<style>
    /* CSS Variables for Dark Mode */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-tertiary: #94a3b8;
        --border-color: #e2e8f0;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --accent-color: #3b82f6;
        --accent-hover: #2563eb;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    .dark {
        --bg-primary: #1e293b;
        --bg-secondary: #0f172a;
        --bg-tertiary: #334155;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-tertiary: #94a3b8;
        --border-color: #334155;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    /* Base Styles */
    .facility-show-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
    }

    /* Header Section */
    .page-header {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px var(--shadow-color);
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.15s ease;
    }

    .btn-primary {
        background: var(--accent-color);
        color: white;
    }

    .btn-primary:hover {
        background: var(--accent-hover);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
    }

    .btn-warning {
        background: var(--warning-color);
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-danger {
        background: var(--danger-color);
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Main Content */
    .main-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Sidebar */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Content Sections */
    .content-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px var(--shadow-color);
    }

    .section-header {
        background: var(--bg-tertiary);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-body {
        padding: 1.5rem;
    }

    /* Facility Image */
    .facility-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .no-image {
        width: 100%;
        height: 300px;
        background: var(--bg-tertiary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-tertiary);
    }

    .no-image svg {
        width: 4rem;
        height: 4rem;
        margin-bottom: 1rem;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    /* Description */
    .description {
        line-height: 1.6;
        color: var(--text-primary);
    }

    /* Features List */
    .features-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .feature-item:last-child {
        border-bottom: none;
    }

    .feature-icon {
        width: 1rem;
        height: 1rem;
        color: var(--success-color);
    }

    .feature-text {
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: capitalize;
    }

    .badge-active { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .badge-inactive { background: rgba(107, 114, 128, 0.1); color: #6b7280; }
    .badge-maintenance { background: rgba(245, 158, 11, 0.1); color: #d97706; }
    .badge-academic { background: rgba(59, 130, 246, 0.1); color: #1d4ed8; }
    .badge-sport { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .badge-technology { background: rgba(139, 92, 246, 0.1); color: #7c3aed; }
    .badge-arts { background: rgba(236, 72, 153, 0.1); color: #be185d; }
    .badge-other { background: rgba(107, 114, 128, 0.1); color: #6b7280; }

    .badge-featured {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Stats */
    .stat-item {
        text-align: center;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
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
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Alerts */
    .alert {
        border-radius: 8px;
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

    .alert-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
        margin-left: auto;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .facility-show-page {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .content-grid {
            grid-template-columns: 1fr;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            flex-wrap: wrap;
        }
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="facility-show-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-top">
            <div>
                <h1 class="page-title">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ $facility->name }}
                </h1>
                <p class="page-subtitle">Facility details and information</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn btn-warning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Facility
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteFacility()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
                <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Facilities
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Facility Image -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Facility Image
                    </h2>
                </div>
                <div class="section-body">
                    @if($facility->image)
                        <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" class="facility-image">
                    @else
                        <div class="no-image">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>No image available</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Description
                    </h2>
                </div>
                <div class="section-body">
                    <div class="description">
                        {{ $facility->description }}
                    </div>
                </div>
            </div>

            <!-- Features -->
            @if($facility->features && count($facility->features) > 0)
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Features & Amenities
                        </h2>
                    </div>
                    <div class="section-body">
                        <div class="features-list">
                            @foreach($facility->features as $feature)
                                @if(!empty(trim($feature)))
                                    <div class="feature-item">
                                        <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="feature-text">{{ $feature }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Basic Information -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Basic Information
                    </h2>
                </div>
                <div class="section-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Kategori</span>
                            <span class="info-value">
                                <span class="badge badge-{{ $facility->category }}">
                                    {{ $facility->category_label }}
                                </span>
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                <span class="badge badge-{{ $facility->status }}">
                                    {{ ucfirst($facility->status) }}
                                </span>
                            </span>
                        </div>

                        @if($facility->location)
                            <div class="info-item">
                                <span class="info-label">Lokasi</span>
                                <span class="info-value">{{ $facility->location }}</span>
                            </div>
                        @endif

                        @if($facility->capacity)
                            <div class="info-item">
                                <span class="info-label">Kapasitas</span>
                                <span class="info-value">{{ number_format($facility->capacity) }} people</span>
                            </div>
                        @endif

                        @if($facility->is_featured)
                            <div class="info-item">
                                <span class="info-label">Featured</span>
                                <span class="info-value">
                                    <span class="badge badge-featured">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                        Featured
                                    </span>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Timestamps
                    </h2>
                </div>
                <div class="section-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Created</span>
                            <span class="info-value">{{ $facility->created_at->format('M d, Y') }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Terakhir Diperbarui</span>
                            <span class="info-value">{{ $facility->updated_at->format('M d, Y') }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Time Ago</span>
                            <span class="info-value">{{ $facility->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Quick Actions
                    </h2>
                </div>
                <div class="section-body">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @if($facility->status !== 'active')
                            <button type="button" class="btn btn-primary" onclick="toggleStatus('active')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Activate Facility
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary" onclick="toggleStatus('inactive')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Deactivate Facility
                            </button>
                        @endif

                        @if(!$facility->is_featured)
                            <button type="button" class="btn btn-warning" onclick="toggleFeatured(true)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                Make Featured
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary" onclick="toggleFeatured(false)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                Remove Featured
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleStatus(status) {
    const action = status === 'active' ? 'activate' : 'deactivate';
    if (confirm(`${action.charAt(0).toUpperCase() + action.slice(1)} this facility?`)) {
        fetch(`/admin/facilities/{{ $facility->id }}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update facility status');
            }
        })
        .catch(error => {
            alert('An error occurred');
        });
    }
}

function toggleFeatured(featured) {
    const action = featured ? 'feature' : 'unfeature';
    if (confirm(`${action.charAt(0).toUpperCase() + action.slice(1)} this facility?`)) {
        fetch(`/admin/facilities/{{ $facility->id }}/toggle-featured`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update featured status');
            }
        })
        .catch(error => {
            alert('An error occurred');
        });
    }
}

function deleteFacility() {
    if (confirm('Are you sure you want to delete "{{ $facility->name }}"? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/facilities/{{ $facility->id }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection