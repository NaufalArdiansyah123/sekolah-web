@extends('layouts.teacher')

@section('title', 'Learning Materials Management')

@section('content')
<style>
    .materials-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
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
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .header-info {
        flex: 1;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-shrink: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
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

    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Statistics Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 14px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        box-shadow: 0 2px 12px var(--shadow-color);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #6ee7b7, #10b981);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: white;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-title {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Filters */
    .filters-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px var(--shadow-color);
    }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .filter-input {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .filter-input:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }

    .btn-filter {
        background: #10b981;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    /* Materials Grid */
    .materials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .material-card {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .material-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .material-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #059669, #10b981);
    }

    .material-header {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .material-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        font-size: 1.25rem;
    }

    .icon-document { background: linear-gradient(135deg, #ef4444, #f87171); }
    .icon-video { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    .icon-presentation { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .icon-exercise { background: linear-gradient(135deg, #10b981, #34d399); }
    .icon-audio { background: linear-gradient(135deg, #06b6d4, #67e8f9); }

    .material-info {
        flex: 1;
        min-width: 0;
    }

    .material-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .material-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .material-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .material-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .detail-label {
        font-size: 0.7rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 500;
    }

    .detail-value {
        font-size: 0.875rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    .material-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }

    .status-published {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-draft {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .material-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        border: none;
        font-size: 0.875rem;
    }

    .btn-edit { background: #f59e0b; }
    .btn-delete { background: #ef4444; }

    .action-btn:hover {
        transform: scale(1.1);
        color: white;
        text-decoration: none;
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
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .empty-description {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .materials-container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-row {
            grid-template-columns: 1fr;
        }

        .materials-grid {
            grid-template-columns: 1fr;
        }

        .material-details {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .material-card {
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

<div class="materials-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Learning Materials
                </h1>
                <p class="page-subtitle">Manage and organize educational content for your students</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary" onclick="bulkUpload()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Bulk Upload
                </button>
                <a href="{{ route('teacher.learning.materials.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Material
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $materials->count() }}</div>
            <div class="stat-title">Total Materials</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $materials->where('type', 'video')->count() }}</div>
            <div class="stat-title">Video Materials</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $materials->sum('downloads') }}</div>
            <div class="stat-title">Total Downloads</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $materials->where('status', 'published')->count() }}</div>
            <div class="stat-title">Dipublikasikan</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" action="{{ route('teacher.learning.materials.index') }}">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Search Materials</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari berdasarkan judul atau deskripsi..." 
                           class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Mata Pelajaran</label>
                    <select name="subject" class="filter-input">
                        <option value="">All Subjects</option>
                        <option value="Matematika" {{ request('subject') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="Fisika" {{ request('subject') == 'Fisika' ? 'selected' : '' }}>Fisika</option>
                        <option value="Biologi" {{ request('subject') == 'Biologi' ? 'selected' : '' }}>Biologi</option>
                        <option value="Bahasa Indonesia" {{ request('subject') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Jenis</label>
                    <select name="type" class="filter-input">
                        <option value="">All Types</option>
                        <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Document</option>
                        <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                        <option value="presentation" {{ request('type') == 'presentation' ? 'selected' : '' }}>Presentation</option>
                        <option value="exercise" {{ request('type') == 'exercise' ? 'selected' : '' }}>Exercise</option>
                        <option value="audio" {{ request('type') == 'audio' ? 'selected' : '' }}>Audio</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <button type="submit" class="btn-filter">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Materials Grid -->
    @if($materials->count() > 0)
        <div class="materials-grid">
            @foreach($materials as $material)
            <div class="material-card">
                <div class="material-header">
                    <div class="material-icon icon-{{ $material->type }}">
                        @if($material->type == 'document')
                            📄
                        @elseif($material->type == 'video')
                            🎥
                        @elseif($material->type == 'presentation')
                            📊
                        @elseif($material->type == 'exercise')
                            📝
                        @elseif($material->type == 'audio')
                            🎵
                        @endif
                    </div>
                    <div class="material-info">
                        <div class="material-title">{{ $material->title }}</div>
                        <div class="material-meta">
                            <span>{{ $material->subject }}</span>
                            <span>•</span>
                            <span>{{ \Carbon\Carbon::parse($material->created_at)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="material-description">
                    {{ $material->description }}
                </div>

                <div class="material-details">
                    <div class="detail-item">
                        <div class="detail-label">File Name</div>
                        <div class="detail-value">{{ $material->file_name }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Ukuran File</div>
                        <div class="detail-value">{{ $material->formatted_file_size }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Unduhan</div>
                        <div class="detail-value">{{ $material->downloads }} times</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Terakhir Diperbarui</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($material->updated_at)->format('d M Y') }}</div>
                    </div>
                </div>

                <div class="material-status status-{{ $material->status }}">
                    @if($material->status == 'published')
                        🟢 Published
                    @else
                        ⚫ Draft
                    @endif
                </div>

                <div class="material-actions">
                    <a href="{{ route('teacher.learning.materials.edit', $material->id) }}" class="action-btn btn-edit" title="Edit Material">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <button class="action-btn btn-delete" title="Delete Material" onclick="deleteMaterial({{ $material->id }})">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="empty-title">No Learning Materials Found</h3>
            <p class="empty-description">
                @if(request()->hasAny(['search', 'subject', 'type']))
                    No materials match your current filters. Try adjusting your search criteria.
                @else
                    No learning materials have been uploaded yet. Start by adding your first material.
                @endif
            </p>
            @if(!request()->hasAny(['search', 'subject', 'type']))
            <a href="{{ route('teacher.learning.materials.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add First Material
            </a>
            @endif
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk upload functionality
    window.bulkUpload = function() {
        alert('Bulk upload functionality would be implemented here');
    };

    // Delete material functionality
    window.deleteMaterial = function(materialId) {
        if (confirm('Are you sure you want to delete this material? This action cannot be undone.')) {
            alert('Delete material functionality would be implemented here');
        }
    };

    // Card hover effects
    const materialCards = document.querySelectorAll('.material-card');
    materialCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
@endsection