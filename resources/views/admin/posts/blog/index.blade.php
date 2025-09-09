@extends('layouts.admin')

@section('title', 'Manajemen Blog/Berita')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="header-title"><i class="fas fa-newspaper me-2"></i>Manajemen Blog & Berita</h1>
            <p class="header-subtitle">Kelola semua artikel dan berita dengan mudah dan efisien</p>
            <a href="{{ route('admin.posts.blog.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Buat Artikel Baru</a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h2 class="filter-title"><i class="fas fa-filter me-2"></i>Filter & Pencarian</h2>
        <div class="filter-grid">
            <div class="filter-group">
                <label class="filter-label">Pencarian</label>
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--gray);"></i>
                    <input type="text" class="filter-input" placeholder="Cari judul atau konten..." style="padding-left: 40px;">
                </div>
            </div>
            <div class="filter-group">
                <label class="filter-label">Status Publikasi</label>
                <select class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="published">📢 Published</option>
                    <option value="draft">📝 Draft</option>
                    <option value="archived">📁 Archived</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Kategori</label>
                <select class="filter-input">
                    <option value="">Semua Kategori</option>
                    <option value="berita">📰 Berita</option>
                    <option value="pengumuman">📣 Pengumuman</option>
                    <option value="kegiatan">🎯 Kegiatan</option>
                    <option value="prestasi">🏆 Prestasi</option>
                </select>
            </div>
            <div class="filter-group">
                <button class="btn btn-filter"><i class="fas fa-search me-2"></i>Terapkan Filter</button>
            </div>
        </div>
    </div>

    <!-- Blog Grid -->
    <div class="blog-grid">
        @if($blogs->count() > 0)
            @foreach($blogs as $blog)
            <div class="blog-card">
                <div class="card-image">
                    @if($blog->featured_image)
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}">
                    @else
                    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                        <i class="fas fa-image"></i>
                    </div>
                    @endif
                    <div class="card-badges">
                        <span class="card-badge badge-category">{{ $blog->category }}</span>
                        <span class="card-badge {{ $blog->status == 'published' ? 'badge-status' : 'badge-draft' }}">{{ $blog->status == 'published' ? 'Published' : 'Draft' }}</span>
                    </div>
                </div>
                <div class="card-content">
                    <h3 class="card-title">{{ $blog->title }}</h3>
                    <p class="card-description">{{ Str::limit($blog->content, 150) }}</p>
                    <div class="card-meta">
                        <div><i class="fas fa-user-circle me-2"></i>{{ $blog->author }}</div>
                        <div><i class="fas fa-calendar me-2"></i>{{ $blog->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('admin.posts.blog.edit', $blog->id) }}" class="action-btn btn-edit"><i class="fas fa-edit"></i></a>
                      
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-newspaper empty-icon"></i>
                <h3 class="empty-title">Belum ada artikel</h3>
                <p class="empty-description">Mulai dengan membuat artikel pertama Anda</p>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i>Buat Artikel Baru</a>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($blogs->count() > 0)
    <div class="pagination">
        {{ $blogs->links() }}
    </div>
    @endif
</div>

<style>
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --secondary: #7209b7;
        --success: #06d6a0;
        --danger: #ef476f;
        --warning: #ffd166;
        --info: #118ab2;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --light-gray: #e9ecef;
        --border-radius: 12px;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    /* Header Styles */
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border-radius: var(--border-radius);
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: var(--shadow);
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
        text-align: center;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .header-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 25px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-primary {
        background: white;
        color: var(--primary);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: var(--shadow);
    }

    .filter-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .filter-group {
        margin-bottom: 15px;
    }

    .filter-label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        color: var(--dark);
    }

    .filter-input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--light-gray);
        border-radius: 10px;
        font-size: 1rem;
        transition: var(--transition);
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .btn-filter {
        background: var(--success);
        color: white;
        justify-content: center;
        width: 100%;
        margin-top: 28px;
    }

    .btn-filter:hover {
        background: #05c28f;
        transform: translateY(-2px);
    }

    /* Blog Grid */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .blog-card {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .card-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .blog-card:hover .card-image img {
        transform: scale(1.05);
    }

    .card-badges {
        position: absolute;
        top: 15px;
        left: 15px;
        display: flex;
        gap: 8px;
    }

    .card-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
    }

    .badge-category {
        background: var(--primary);
    }

    .badge-status {
        background: var(--success);
    }

    .badge-draft {
        background: var(--warning);
        color: var(--dark);
    }

    .badge-archived {
        background: var(--gray);
    }

    .card-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--dark);
        line-height: 1.4;
    }

    .card-description {
        color: var(--gray);
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        font-size: 0.9rem;
        color: var(--gray);
    }

    .card-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: var(--transition);
        cursor: pointer;
        text-decoration: none;
    }

    .btn-edit {
        background: var(--primary);
    }

    .btn-view {
        background: var(--info);
    }

    .btn-delete {
        background: var(--danger);
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        grid-column: 1 / -1;
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--light-gray);
        margin-bottom: 20px;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .empty-description {
        color: var(--gray);
        margin-bottom: 30px;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .pagination nav {
        display: flex;
        gap: 5px;
    }

    .pagination .page-item {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: white;
        color: var(--dark);
        font-weight: 600;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .pagination .page-item.active,
    .pagination .page-item:hover {
        background: var(--primary);
        color: white;
    }

    .pagination .page-link {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: inherit;
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .blog-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .header-title {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .blog-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    // Script untuk halaman index
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Halaman Index Blog");
        
        // Filter functionality
        const filterBtn = document.querySelector('.btn-filter');
        if (filterBtn) {
            filterBtn.addEventListener('click', function() {
                // Implement filter logic here
                alert('Filter akan diterapkan');
            });
        }
    });
</script>
@endsection