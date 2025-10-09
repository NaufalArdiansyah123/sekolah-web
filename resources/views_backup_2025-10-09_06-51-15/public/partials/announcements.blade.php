@php
    use App\Models\Announcement;
    $announcements = Announcement::published()
                                ->latest('created_at')
                                ->take(5)
                                ->get();
@endphp

@if($announcements->count() > 0)
<section class="announcements-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">
                <svg class="w-8 h-8 me-3" style="display: inline; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                Latest Announcements
            </h2>
            <p class="section-subtitle">Stay updated with the latest news from our extracurricular activities</p>
        </div>

        <div class="announcements-grid">
            @foreach($announcements as $announcement)
            <div class="announcement-card">
                <div class="announcement-header">
                    <div class="announcement-meta">
                        <div class="category-badge">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ ucfirst($announcement->kategori) }}
                        </div>
                        <div class="announcement-date">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $announcement->tanggal_publikasi ? $announcement->tanggal_publikasi->format('M d, Y') : $announcement->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    <div class="announcement-status">
                        <span class="status-badge priority-{{ $announcement->prioritas }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                            {{ ucfirst($announcement->prioritas) }}
                        </span>
                    </div>
                </div>

                <div class="announcement-content">
                    <h3 class="announcement-title">{{ $announcement->judul }}</h3>
                    <div class="announcement-text">
                        {!! Str::limit(strip_tags($announcement->isi), 150) !!}
                    </div>
                </div>

                <div class="announcement-footer">
                    <div class="announcement-author">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        By {{ $announcement->penulis }}
                    </div>
                    <div class="announcement-views">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $announcement->views }} views
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($announcements->count() >= 5)
        <div class="text-center mt-4">
            <a href="{{ route('announcements.index') }}" class="btn btn-outline-primary">
                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                View All Announcements
            </a>
        </div>
        @endif
    </div>
</section>

<style>
.announcements-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
    overflow: hidden;
}

.announcements-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
}

.section-header {
    position: relative;
    z-index: 2;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.section-subtitle {
    font-size: 1.125rem;
    color: #6b7280;
    max-width: 600px;
    margin: 0 auto;
}

.announcements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.announcement-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.announcement-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #1d4ed8);
}

.announcement-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.announcement-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    gap: 1rem;
}

.announcement-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.category-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    width: fit-content;
}

.announcement-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
}

.announcement-status {
    flex-shrink: 0;
}

.status-badge {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    padding: 0.375rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.announcement-content {
    margin-bottom: 1.5rem;
}

.announcement-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.announcement-text {
    color: #4b5563;
    line-height: 1.6;
    font-size: 0.95rem;
}

.announcement-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
    gap: 1rem;
}

.announcement-author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
}

.announcement-views {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
}

/* Priority Badge Styles */
.status-badge.priority-tinggi {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.status-badge.priority-sedang {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.status-badge.priority-rendah {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.btn-outline-primary {
    background: transparent;
    color: #3b82f6;
    border: 2px solid #3b82f6;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    text-decoration: none;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .announcements-section {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    }
    
    .section-title {
        color: #f9fafb;
    }
    
    .section-subtitle {
        color: #d1d5db;
    }
    
    .announcement-card {
        background: #374151;
        border-color: #4b5563;
    }
    
    .announcement-title {
        color: #f9fafb;
    }
    
    .announcement-text {
        color: #d1d5db;
    }
    
    .announcement-date,
    .announcement-author,
    .announcement-views {
        color: #9ca3af;
    }
    
    .announcement-footer {
        border-color: #4b5563;
    }
}

/* Responsive design */
@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .announcements-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .announcement-card {
        padding: 1.5rem;
    }
    
    .announcement-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .announcement-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
}
</style>
@endif