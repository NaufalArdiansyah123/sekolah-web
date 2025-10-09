@extends('layouts.admin')

@section('title', 'Tambah Post')

@push('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.2/tinymce.min.js"></script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Post Baru</h3>
                </div>
                
                <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Main Content -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Judul *</label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                           value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="excerpt">Ringkasan</label>
                                    <textarea name="excerpt" id="excerpt" class="form-control" rows="3">{{ old('excerpt') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="content">Konten *</label>
                                    <textarea name="content" id="content" class="form-control tinymce" rows="15">{{ old('content') }}</textarea>
                                    @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Dynamic Meta Fields -->
                                <div id="meta-fields"></div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type">Tipe Post *</label>
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="slideshow" {{ old('type') == 'slideshow' ? 'selected' : '' }}>Slideshow</option>
                                        <option value="agenda" {{ old('type') == 'agenda' ? 'selected' : '' }}>Agenda</option>
                                        <option value="announcement" {{ old('type') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                                        <option value="editorial" {{ old('type') == 'editorial' ? 'selected' : '' }}>Editorial</option>
                                        <option value="blog" {{ old('type') == 'blog' ? 'selected' : '' }}>Blog Guru</option>
                                        <option value="quotes" {{ old('type') == 'quotes' ? 'selected' : '' }}>Quotes</option>
                                        <option value="facility" {{ old('type') == 'facility' ? 'selected' : '' }}>Fasilitas</option>
                                        <option value="extracurricular" {{ old('type') == 'extracurricular' ? 'selected' : '' }}>Ekstrakurikuler</option>
                                        <option value="achievement" {{ old('type') == 'achievement' ? 'selected' : '' }}>Prestasi</option>
                                        <option value="staff" {{ old('type') == 'staff' ? 'selected' : '' }}>Staff/Guru</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="category_id">Kategori</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="featured_image">Featured Image</label>
                                    <input type="file" name="featured_image" id="featured_image" 
                                           class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                                    @error('featured_image')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Max: 2MB. Format: JPG, PNG</small>
                                </div>

                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <select name="tags[]" id="tags" class="form-control" multiple>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Ctrl+Click untuk pilih multiple</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// TinyMCE initialization
tinymce.init({
    selector: '.tinymce',
    height: 400,
    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
    toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
    file_picker_types: 'image',
    file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        
        input.onchange = function () {
            var file = this.files[0];
            var reader = new FileReader();
            
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
                
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
        };
        
        input.click();
    }
});

// Dynamic meta fields based on post type
document.getElementById('type').addEventListener('change', function() {
    const metaFields = document.getElementById('meta-fields');
    const type = this.value;
    
    let html = '';
    
    switch(type) {
        case 'agenda':
            html = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_date">Tanggal Event</label>
                            <input type="date" name="event_date" id="event_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_time">Waktu Event</label>
                            <input type="time" name="event_time" id="event_time" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location">Lokasi</label>
                            <input type="text" name="location" id="location" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="organizer">Penyelenggara</label>
                            <input type="text" name="organizer" id="organizer" class="form-control">
                        </div>
                    </div>
                </div>
            `;
            break;
            
        case 'announcement':
            html = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="priority">Prioritas</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="normal">Normal</option>
                                <option value="high">Tinggi</option>
                                <option value="urgent">Mendesak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="expires_at">Berlaku Sampai</label>
                            <input type="datetime-local" name="expires_at" id="expires_at" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="send_notification" id="send_notification" class="form-check-input" value="1">
                        <label class="form-check-label" for="send_notification">
                            Kirim notifikasi ke seluruh user
                        </label>
                    </div>
                </div>
            `;
            break;
            
        case 'quotes':
            html = `
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="quote_author">Penulis Quote</label>
                            <input type="text" name="quote_author" id="quote_author" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="display_duration">Tampil (hari)</label>
                            <input type="number" name="display_duration" id="display_duration" class="form-control" value="7" min="1">
                        </div>
                    </div>
                </div>
            `;
            break;
    }
    
    metaFields.innerHTML = html;
});
</script>
@endpush