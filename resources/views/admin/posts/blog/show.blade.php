@extends('layouts.admin')

@section('title', 'Detail Artikel')

@section('content')
<style>
    .blog-show-container {
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
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.2);
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .header-main {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .header-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0.5rem 0 0 0;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-header {
        background: white;
        color: #8b5cf6;
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
    }

    .btn-header:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #8b5cf6;
        text-decoration: none;
    }

    .btn-header.btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-header.btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
    }

    /* Content Layout */
    .content-layout {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
    }

    /* Main Article */
    .article-main {
        background: var(--bg-primary);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px var(--shadow-color);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .article-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    /* Article Header */
    .article-header {
        padding: 2rem;
        border-bottom: 1px solid var(--border-color);
    }

    .article-badges {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-berita { background: rgba(59, 130, 246, 0.9); color: white; }
    .badge-pengumuman { background: rgba(16, 185, 129, 0.9); color: white; }
    .badge-kegiatan { background: rgba(245, 158, 11, 0.9); color: white; }
    .badge-prestasi { background: rgba(139, 92, 246, 0.9); color: white; }

    .badge-published { background: rgba(16, 185, 129, 0.9); color: white; }
    .badge-draft { background: rgba(107, 114, 128, 0.9); color: white; }
    .badge-archived { background: rgba(75, 85, 99, 0.9); color: white; }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .article-title {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .article-excerpt {
        font-size: 1.125rem;
        color: var(--text-secondary);
        line-height: 1.6;
        margin: 0;
    }

    /* Featured Image */
    .featured-image {
        position: relative;
        overflow: hidden;
        height: 400px;
    }

    .featured-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .article-main:hover .featured-image img {
        transform: scale(1.02);
    }

    /* Article Content */
    .article-content {
        padding: 2rem;
    }

    .content-text {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-primary);
    }

    .content-text p {
        margin-bottom: 1.2rem;
    }

    /* Article Footer */
    .article-footer {
        padding: 2rem;
        border-top: 1px solid var(--border-color);
        background: var(--bg-secondary);
    }

    .keywords-section {
        margin-bottom: 2rem;
    }

    .keywords-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
    }

    .keywords-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .keyword-tag {
        background: rgba(139, 92, 246, 0.9);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .keyword-tag:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }

    .article-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .btn-action.btn-edit {
        background: #6366f1;
        color: white;
    }

    .btn-action.btn-view {
        background: #10b981;
        color: white;
    }

    .btn-action.btn-delete {
        background: #ef4444;
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        text-decoration: none;
        color: white;
    }

    /* Sidebar */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .sidebar-card {
        background: var(--bg-primary);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px var(--shadow-color);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .sidebar-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .card-header {
        padding: 1.5rem;
        background: var(--bg-secondary);
        border-bottom: 1px solid var(--border-color);
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-primary);
        display: flex;
        align-items: center;
    }

    .card-content {
        padding: 1.5rem;
    }

    /* Statistics */
    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .stat-item:last-child {
        border-bottom: none;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .stat-value {
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Info Items */
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .info-value {
        font-weight: 600;
        color: var(--text-primary);
    }

    /* SEO Items */
    .seo-item {
        margin-bottom: 1.5rem;
    }

    .seo-item:last-child {
        margin-bottom: 0;
    }

    .seo-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .seo-value {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 0.25rem;
    }

    .seo-count {
        color: var(--text-tertiary);
        font-size: 0.75rem;
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--text-primary);
    }

    .quick-action-btn:hover {
        background: var(--bg-tertiary);
        transform: translateY(-2px);
        color: var(--text-primary);
        text-decoration: none;
    }

    .quick-action-btn.btn-danger {
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.2);
    }

    .quick-action-btn.btn-danger:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .quick-action-btn i {
        font-size: 1.25rem;
    }

    .quick-action-btn span {
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .content-layout {
            grid-template-columns: 1fr;
        }

        .sidebar {
            order: -1;
        }
    }

    @media (max-width: 768px) {
        .blog-show-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1.5rem;
            text-align: center;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .article-title {
            font-size: 2rem;
        }

        .article-header,
        .article-content,
        .article-footer {
            padding: 1.5rem;
        }

        .article-meta {
            flex-direction: column;
            gap: 0.75rem;
        }

        .article-actions {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }
    }

    /* Dark mode specific adjustments */
    .dark .article-footer {
        background: var(--bg-tertiary);
    }

    .dark .card-header {
        background: var(--bg-tertiary);
    }

    .dark .quick-action-btn {
        background: var(--bg-tertiary);
    }

    .dark .quick-action-btn:hover {
        background: var(--border-color);
    }
</style>

<div class="blog-show-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-main">
                <div class="header-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="header-text">
                    <h1 class="page-title">Detail Artikel</h1>
                    <p class="page-subtitle">Lihat detail lengkap artikel dan kelola publikasi</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.posts.blog') }}" class="btn-header btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('admin.posts.blog.edit', $blog->slug) }}" class="btn-header">
                    <i class="fas fa-edit me-2"></i>Edit Artikel
                </a>
            </div>
        </div>
    </div>

    <div class="content-layout">
        <!-- Main Article -->
        <div class="article-main">
            <!-- Article Header -->
            <div class="article-header">
                <div class="article-badges">
                    <span class="badge badge-{{ $blog->category ?? 'berita' }}">
                        @switch($blog->category ?? 'berita')
                            @case('berita')
                                📰 Berita
                                @break
                            @case('pengumuman')
                                📢 Pengumuman
                                @break
                            @case('kegiatan')
                                🎯 Kegiatan
                                @break
                            @case('prestasi')
                                🏆 Prestasi
                                @break
                            @default
                                📰 Berita
                        @endswitch
                    </span>
                    <span class="badge badge-{{ $blog->status ?? 'published' }}">
                        @switch($blog->status ?? 'published')
                            @case('published')
                                ✅ Published
                                @break
                            @case('draft')
                                📝 Draft
                                @break
                            @case('archived')
                                📁 Archived
                                @break
                            @default
                                ✅ Published
                        @endswitch
                    </span>
                </div>
                
                <div class="article-meta">
                    <div class="meta-item">
                        <i class="fas fa-user"></i>
                        <span>{{ $blog->author ?? $blog->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $blog->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($blog->published_at)
                        <div class="meta-item">
                            <i class="fas fa-globe"></i>
                            <span>Published: {{ $blog->published_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
                
                <h1 class="article-title">{{ $blog->title }}</h1>
                
                @if($blog->meta_description)
                    <p class="article-excerpt">{{ $blog->meta_description }}</p>
                @endif
            </div>

            <!-- Featured Image -->
            @if($blog->featured_image)
                <div class="featured-image">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                         alt="{{ $blog->title }}">
                </div>
            @endif

            <!-- Article Content -->
            <div class="article-content">
                <div class="content-text">
                    {!! nl2br(e($blog->content)) !!}
                </div>
            </div>

            <!-- Article Footer -->
            <div class="article-footer">
                @if($blog->keywords)
                    <div class="keywords-section">
                        <h4 class="keywords-title">
                            <i class="fas fa-hashtag me-2"></i>Keywords
                        </h4>
                        <div class="keywords-list">
                            @foreach(explode(',', $blog->keywords) as $keyword)
                                <span class="keyword-tag">{{ trim($keyword) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="article-actions">
                    <a href="{{ route('admin.posts.blog.edit', $blog->slug) }}" class="btn-action btn-edit">
                        <i class="fas fa-edit me-2"></i>Edit Artikel
                    </a>
                    @if($blog->status === 'published')
                        <a href="#" class="btn-action btn-view" onclick="openPublicView()">
                            <i class="fas fa-external-link-alt me-2"></i>Lihat di Website
                        </a>
                    @endif
                    <button class="btn-action btn-delete" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i>Hapus Artikel
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Article Statistics -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Artikel
                    </h3>
                </div>
                <div class="card-content">
                    <div class="stat-item">
                        <div class="stat-label">Views</div>
                        <div class="stat-value">{{ $blog->views_count ?? 0 }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Word Count</div>
                        <div class="stat-value">{{ str_word_count(strip_tags($blog->content)) }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Reading Time</div>
                        <div class="stat-value">{{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min</div>
                    </div>
                </div>
            </div>

            <!-- Article Information -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Informasi Artikel
                    </h3>
                </div>
                <div class="card-content">
                    <div class="info-item">
                        <div class="info-label">ID</div>
                        <div class="info-value">#{{ $blog->id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Slug</div>
                        <div class="info-value">{{ $blog->slug }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="badge badge-{{ $blog->status ?? 'published' }}">
                                {{ ucfirst($blog->status ?? 'published') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Kategori</div>
                        <div class="info-value">
                            <span class="badge badge-{{ $blog->category ?? 'berita' }}">
                                {{ ucfirst($blog->category ?? 'berita') }}
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Dibuat</div>
                        <div class="info-value">{{ $blog->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Diupdate</div>
                        <div class="info-value">{{ $blog->updated_at->format('d M Y, H:i') }}</div>
                    </div>
                    @if($blog->published_at)
                        <div class="info-item">
                            <div class="info-label">Dipublikasi</div>
                            <div class="info-value">{{ $blog->published_at->format('d M Y, H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEO Information -->
            @if($blog->meta_description || $blog->keywords)
                <div class="sidebar-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-search me-2"></i>SEO Information
                        </h3>
                    </div>
                    <div class="card-content">
                        @if($blog->meta_description)
                            <div class="seo-item">
                                <div class="seo-label">Meta Description</div>
                                <div class="seo-value">{{ $blog->meta_description }}</div>
                                <div class="seo-count">{{ strlen($blog->meta_description) }}/160 characters</div>
                            </div>
                        @endif
                        @if($blog->keywords)
                            <div class="seo-item">
                                <div class="seo-label">Keywords</div>
                                <div class="seo-value">{{ $blog->keywords }}</div>
                                <div class="seo-count">{{ count(explode(',', $blog->keywords)) }} keywords</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h3>
                </div>
                <div class="card-content">
                    <div class="quick-actions">
                        <button class="quick-action-btn" onclick="duplicateArticle()">
                            <i class="fas fa-copy"></i>
                            <span>Duplicate</span>
                        </button>
                        @if($blog->status === 'draft')
                            <button class="quick-action-btn" onclick="publishArticle()">
                                <i class="fas fa-paper-plane"></i>
                                <span>Publish</span>
                            </button>
                        @elseif($blog->status === 'published')
                            <button class="quick-action-btn" onclick="unpublishArticle()">
                                <i class="fas fa-eye-slash"></i>
                                <span>Unpublish</span>
                            </button>
                        @endif
                        <button class="quick-action-btn" onclick="archiveArticle()">
                            <i class="fas fa-archive"></i>
                            <span>Archive</span>
                        </button>
                        <button class="quick-action-btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash"></i>
                            <span>Hapus</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" action="{{ route('admin.posts.blog.destroy', $blog->slug) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // Quick actions
    function duplicateArticle() {
        if (confirm('Apakah Anda ingin menduplikasi artikel ini?')) {
            alert('Fitur duplikasi akan segera tersedia');
        }
    }

    function publishArticle() {
        if (confirm('Apakah Anda ingin mempublikasikan artikel ini?')) {
            alert('Fitur publikasi akan segera tersedia');
        }
    }

    function unpublishArticle() {
        if (confirm('Apakah Anda ingin membatalkan publikasi artikel ini?')) {
            alert('Fitur batal publikasi akan segera tersedia');
        }
    }

    function archiveArticle() {
        if (confirm('Apakah Anda ingin mengarsipkan artikel ini?')) {
            alert('Fitur arsip akan segera tersedia');
        }
    }

    function openPublicView() {
        window.open('#', '_blank');
    }

    function confirmDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.')) {
            document.getElementById('deleteForm').submit();
        }
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + E to edit
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            window.location.href = '{{ route("admin.posts.blog.edit", $blog->slug) }}';
        }
        
        // Ctrl/Cmd + Backspace to go back
        if ((e.ctrlKey || e.metaKey) && e.key === 'Backspace') {
            e.preventDefault();
            window.location.href = '{{ route("admin.posts.blog") }}';
        }
    });
</script>
@endsection