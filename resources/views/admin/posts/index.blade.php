@extends('layouts.admin')

@section('title', 'Manajemen Post')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Post</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Post
                        </a>
                    </div>
                </div>
                
                <!-- Filter Form -->
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-3">
                        <div class="col-md-3">
                            <select name="type" class="form-control">
                                <option value="">Semua Tipe</option>
                                <option value="slideshow" {{ request('type') == 'slideshow' ? 'selected' : '' }}>Slideshow</option>
                                <option value="agenda" {{ request('type') == 'agenda' ? 'selected' : '' }}>Agenda</option>
                                <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="editorial" {{ request('type') == 'editorial' ? 'selected' : '' }}>Editorial</option>
                                <option value="blog" {{ request('type') == 'blog' ? 'selected' : '' }}>Blog</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draf</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari judul..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary">Filter</button>
                        </div>
                    </form>

                    <!-- Posts Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Thumbnail</th>
                                    <th>Judul</th>
                                    <th>Tipe</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Penulis</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                <tr>
                                    <td>
                                        @if($post->getFirstMedia('featured'))
                                            <img src="{{ $post->getFirstMediaUrl('featured', 'thumb') }}" 
                                                 class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 40px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $post->title }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($post->excerpt, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst($post->type) }}</span>
                                    </td>
                                    <td>
                                        @if($post->category)
                                            <span class="badge badge-secondary">{{ $post->category->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($post->status)
                                            @case('published')
                                                <span class="badge badge-success">Dipublikasikan</span>
                                                @break
                                            @case('draft')
                                                <span class="badge badge-warning">Draf</span>
                                                @break
                                            @case('archived')
                                                <span class="badge badge-dark">Archived</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $post->author->name }}</td>
                                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-info" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data post.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection