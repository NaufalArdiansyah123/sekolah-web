@extends('layouts.public')

@section('title', $blog->title)

@section('content')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    color: #374151;
    line-height: 1.75;
}

.prose p {
    margin-bottom: 1.25em;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #111827;
    font-weight: 600;
    margin-top: 2em;
    margin-bottom: 1em;
}

.prose h1 { font-size: 2.25em; }
.prose h2 { font-size: 1.875em; }
.prose h3 { font-size: 1.5em; }
.prose h4 { font-size: 1.25em; }

.prose ul, .prose ol {
    margin-top: 1.25em;
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}

.prose li {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}

.prose blockquote {
    font-style: italic;
    border-left: 4px solid #e5e7eb;
    padding-left: 1em;
    margin: 1.6em 0;
    color: #6b7280;
}
</style>

<div class="container mx-auto px-4 py-8">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Featured Image -->
                @if($blog->featured_image)
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                         alt="{{ $blog->title }}" 
                         class="w-100" style="height: 400px; object-fit: cover;">
                @endif

                <div class="p-4">
                    <!-- Category and Date -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        @php
                            $categoryBadges = [
                                'berita' => '<span class="badge bg-info">📰 Berita</span>',
                                'pengumuman' => '<span class="badge bg-warning text-dark">📢 Pengumuman</span>',
                                'kegiatan' => '<span class="badge bg-success">🎯 Kegiatan</span>',
                                'prestasi' => '<span class="badge bg-danger">🏆 Prestasi</span>'
                            ];
                        @endphp
                        {!! $categoryBadges[$blog->category] ?? '<span class="badge bg-secondary">📰 Berita</span>' !!}
                        
                        <div class="d-flex align-items-center text-muted small">
                            <i class="fas fa-calendar me-2"></i>
                            {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                        </div>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="fas fa-user me-2"></i>
                            {{ $blog->author ?? $blog->user->name ?? 'Admin' }}
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="display-5 fw-bold text-dark mb-4">
                        {{ $blog->title }}
                    </h1>

                    <!-- Content -->
                    <div class="prose">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    <!-- Keywords/Tags -->
                    @if($blog->keywords)
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="fw-bold text-dark mb-3">Tags:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $blog->keywords) as $keyword)
                                    <span class="badge bg-light text-dark">
                                        #{{ trim($keyword) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold text-dark mb-3">Bagikan:</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank"
                               class="btn btn-primary btn-sm">
                                <i class="fab fa-facebook-f me-2"></i>
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                               target="_blank"
                               class="btn btn-info btn-sm">
                                <i class="fab fa-twitter me-2"></i>
                                Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . url()->current()) }}" 
                               target="_blank"
                               class="btn btn-success btn-sm">
                                <i class="fab fa-whatsapp me-2"></i>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Related Posts -->
            @if($relatedBlogs->count() > 0)
                <div class="mt-5">
                    <h2 class="h4 fw-bold text-dark mb-4">Berita Terkait</h2>
                    <div class="row g-4">
                        @foreach($relatedBlogs as $related)
                            <div class="col-md-6">
                                <article class="card h-100 shadow-sm">
                                    @if($related->featured_image)
                                        <img src="{{ asset('storage/' . $related->featured_image) }}" 
                                             alt="{{ $related->title }}" 
                                             class="card-img-top" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="card-body">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            @php
                                                $categoryBadges = [
                                                    'berita' => '<span class="badge bg-info">📰 Berita</span>',
                                                    'pengumuman' => '<span class="badge bg-warning text-dark">📢 Pengumuman</span>',
                                                    'kegiatan' => '<span class="badge bg-success">🎯 Kegiatan</span>',
                                                    'prestasi' => '<span class="badge bg-danger">🏆 Prestasi</span>'
                                                ];
                                            @endphp
                                            {!! $categoryBadges[$related->category] ?? '<span class="badge bg-secondary">📰 Berita</span>' !!}
                                            <span class="text-muted small">
                                                {{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                        
                                        <h5 class="card-title fw-bold line-clamp-2 mb-3">
                                            <a href="{{ route('news.detail', $related->id) }}" class="text-decoration-none text-dark">{{ $related->title }}</a>
                                        </h5>
                                        
                                        <p class="card-text text-muted line-clamp-2 mb-3">{{ Str::limit(strip_tags($related->content), 120) }}</p>
                                        
                                        <a href="{{ route('news.detail', $related->id) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            Baca Selengkapnya →
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Back to News -->
            <div class="card mb-4">
                <div class="card-body">
                    <a href="{{ route('news.index') }}" 
                       class="btn btn-outline-primary w-100">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Berita
                    </a>
                </div>
            </div>

            <!-- Latest Posts -->
            @if($relatedBlogs->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Berita Lainnya</h5>
                    </div>
                    <div class="card-body">
                        @foreach($relatedBlogs->take(3) as $latest)
                            <div class="d-flex gap-3 mb-3">
                                @if($latest->featured_image)
                                    <img src="{{ asset('storage/' . $latest->featured_image) }}" 
                                         alt="{{ $latest->title }}" 
                                         class="rounded" style="width: 60px; height: 60px; object-fit: cover; flex-shrink: 0;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; flex-shrink: 0;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1 min-width-0">
                                    <h6 class="fw-bold small line-clamp-2 mb-1">
                                        <a href="{{ route('news.detail', $latest->id) }}" class="text-decoration-none text-dark">
                                            {{ $latest->title }}
                                        </a>
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        {{ $latest->published_at ? $latest->published_at->format('d M Y') : $latest->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Contact Info -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Hubungi Kami</h5>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-phone text-primary me-3"></i>
                            <span>(024) 123-4567</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <span>info@sekolah.com</span>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                            <span>Jl. Pendidikan No. 123, Kota Balong</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection