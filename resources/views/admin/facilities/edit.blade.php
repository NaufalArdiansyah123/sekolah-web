@extends('layouts.admin')

@section('title', 'Edit Fasilitas')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Fasilitas: {{ $facility->name }}
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.facilities.show', $facility) }}" class="btn btn-info">
                <i class="fas fa-eye me-2"></i>Lihat Detail
            </a>
            <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Fasilitas</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.facilities.update', $facility) }}" method="POST" enctype="multipart/form-data" id="facilityForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Fasilitas -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Fasilitas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $facility->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $facility->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori dan Status -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" 
                                            id="category" name="category" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $key => $label)
                                            <option value="{{ $key }}" {{ old('category', $facility->category) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        @foreach($statuses as $key => $label)
                                            <option value="{{ $key }}" {{ old('status', $facility->status) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <!-- Gambar -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Fasilitas</label>
                            
                            @if($facility->image)
                                <div class="mb-3">
                                    <label class="form-label">Gambar Saat Ini:</label>
                                    <div>
                                        <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" 
                                             class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>
                            @endif
                            
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <label class="form-label">Preview Gambar Baru:</label>
                                <div>
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>
                        </div>





                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $facility->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui:</strong></td>
                            <td>{{ $facility->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>{!! $facility->status_badge !!}</td>
                        </tr>

                    </table>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-eye me-2"></i>Preview
                    </h6>
                </div>
                <div class="card-body">
                    <div id="facility-preview">
                        <!-- Preview will be updated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-cog me-2"></i>Aksi Lainnya
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" onclick="toggleStatus({{ $facility->id }})">
                            <i class="fas fa-toggle-{{ $facility->status === 'active' ? 'on' : 'off' }} me-2"></i>
                            {{ $facility->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>

                        <button type="button" class="btn btn-outline-danger" onclick="deleteFacility({{ $facility->id }})">
                            <i class="fas fa-trash me-2"></i>Hapus Fasilitas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus fasilitas <strong>{{ $facility->name }}</strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Image preview
    $('#image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').show();
                updatePreview();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
            updatePreview();
        }
    });

    // Form change listeners for preview
    $('#name, #description, #category, #status').on('input change', updatePreview);

    // Initial preview update
    updatePreview();
});



function updatePreview() {
    const name = $('#name').val() || 'Nama Fasilitas';
    const description = $('#description').val() || 'Deskripsi fasilitas akan muncul di sini...';
    const category = $('#category option:selected').text() || 'Kategori';
    const status = $('#status option:selected').text() || 'Status';
    
    // Use new image if uploaded, otherwise use existing image
    let imageSrc = $('#previewImg').attr('src');
    if (!imageSrc && '{{ $facility->image_url }}') {
        imageSrc = '{{ $facility->image_url }}';
    }

    let preview = `
        <div class="facility-preview-card">
            ${imageSrc ? `<img src="${imageSrc}" class="img-fluid rounded mb-3" style="max-height: 150px; width: 100%; object-fit: cover;">` : ''}
            <h6 class="fw-bold">${name}</h6>
            <p class="text-muted small">${description.substring(0, 100)}${description.length > 100 ? '...' : ''}</p>
            <div class="d-flex flex-wrap gap-1 mb-2">
                <span class="badge bg-secondary">${category}</span>
                <span class="badge bg-${status === 'Aktif' ? 'success' : status === 'Maintenance' ? 'warning' : 'danger'}">${status}</span>
            </div>
        </div>
    `;

    $('#facility-preview').html(preview);
}

function deleteFacility(id) {
    $('#deleteModal').modal('show');
}

function toggleStatus(id) {
    $.post(`/admin/facilities/${id}/toggle-status`, {
        _token: '{{ csrf_token() }}'
    })
    .done(function(response) {
        if (response.success) {
            showAlert('success', response.message);
            location.reload();
        }
    })
    .fail(function() {
        showAlert('error', 'Terjadi kesalahan saat mengubah status.');
    });
}



function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const alert = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('.container-fluid').prepend(alert);
    
    // Auto dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
}
</script>
@endpush