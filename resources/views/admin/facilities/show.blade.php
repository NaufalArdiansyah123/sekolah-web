@extends('layouts.admin')

@section('title', 'Detail Fasilitas')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-building me-2"></i>Detail Fasilitas: {{ $facility->name }}
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Content -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Fasilitas</h6>
                    <div class="d-flex gap-2">
                        {!! $facility->status_badge !!}
                        @if($facility->is_featured)
                            <span class="badge bg-warning">
                                <i class="fas fa-star"></i> Unggulan
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Image -->
                    @if($facility->image)
                        <div class="mb-4">
                            <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" 
                                 class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Basic Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold">{{ $facility->name }}</h5>
                            <p class="text-muted mb-3">{{ $facility->description }}</p>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Kategori:</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $facility->category_label }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>{!! $facility->status_badge !!}</td>
                                </tr>
                                @if($facility->capacity)
                                    <tr>
                                        <td><strong>Kapasitas:</strong></td>
                                        <td>
                                            <i class="fas fa-users text-muted me-1"></i>
                                            {{ $facility->capacity }} orang
                                        </td>
                                    </tr>
                                @endif
                                @if($facility->location)
                                    <tr>
                                        <td><strong>Lokasi:</strong></td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                            {{ $facility->location }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><strong>Urutan:</strong></td>
                                    <td>{{ $facility->sort_order }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Features -->
                    @if($facility->features && count($facility->features) > 0)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-list-ul me-2"></i>Fitur-fitur
                            </h6>
                            <div class="row">
                                @foreach($facility->features as $feature)
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            <span>{{ $feature }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="border-top pt-3">
                        <div class="row text-muted small">
                            <div class="col-md-6">
                                <i class="fas fa-calendar-plus me-1"></i>
                                Dibuat: {{ $facility->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="col-md-6">
                                <i class="fas fa-calendar-edit me-1"></i>
                                Diperbarui: {{ $facility->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-eye me-2"></i>Preview Halaman Publik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="facility-card" style="max-width: 400px;">
                        @if($facility->image)
                            <div class="facility-image mb-3">
                                <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" 
                                     class="img-fluid rounded" style="height: 200px; width: 100%; object-fit: cover;">
                            </div>
                        @endif
                        <div class="facility-content">
                            <h5 class="facility-title text-primary">{{ $facility->name }}</h5>
                            <p class="facility-desc text-muted">{{ Str::limit($facility->description, 100) }}</p>
                            
                            @if($facility->features && count($facility->features) > 0)
                                <div class="facility-features mb-3">
                                    @foreach(array_slice($facility->features, 0, 3) as $feature)
                                        <div class="facility-feature d-flex align-items-center mb-1">
                                            <i class="fas fa-check text-success me-2" style="width: 16px;"></i>
                                            <small>{{ $feature }}</small>
                                        </div>
                                    @endforeach
                                    @if(count($facility->features) > 3)
                                        <small class="text-muted">+{{ count($facility->features) - 3 }} fitur lainnya</small>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="facility-status status-{{ $facility->status }}">
                                    {{ $facility->status === 'active' ? 'Tersedia' : ($facility->status === 'maintenance' ? 'Maintenance' : 'Tidak Tersedia') }}
                                </span>
                                @if($facility->is_featured)
                                    <i class="fas fa-star text-warning" title="Unggulan"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cog me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Fasilitas
                        </a>
                        <button type="button" class="btn btn-outline-primary" onclick="toggleStatus({{ $facility->id }})">
                            <i class="fas fa-toggle-{{ $facility->status === 'active' ? 'on' : 'off' }} me-2"></i>
                            {{ $facility->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="toggleFeatured({{ $facility->id }})">
                            <i class="fas fa-star me-2"></i>
                            {{ $facility->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}
                        </button>
                        <hr>
                        <a href="{{ route('facilities.index') }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-external-link-alt me-2"></i>Lihat di Halaman Publik
                        </a>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteFacility({{ $facility->id }})">
                            <i class="fas fa-trash me-2"></i>Hapus Fasilitas
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-chart-bar me-2"></i>Statistik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary">{{ $facility->sort_order }}</h4>
                                <small class="text-muted">Urutan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ count($facility->features ?? []) }}</h4>
                            <small class="text-muted">Fitur</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Facilities -->
            @php
                $relatedFacilities = \App\Models\Facility::where('category', $facility->category)
                    ->where('id', '!=', $facility->id)
                    ->where('status', 'active')
                    ->orderBy('sort_order')
                    ->take(3)
                    ->get();
            @endphp

            @if($relatedFacilities->count() > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fas fa-layer-group me-2"></i>Fasilitas Terkait
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($relatedFacilities as $related)
                            <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                @if($related->image)
                                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}" 
                                         class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-building text-muted"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="{{ route('admin.facilities.show', $related) }}" class="text-decoration-none">
                                            {{ $related->name }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">{{ Str::limit($related->description, 50) }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
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

@push('styles')
<style>
.facility-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-maintenance {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.status-inactive {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}
</style>
@endpush

@push('scripts')
<script>
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

function toggleFeatured(id) {
    $.post(`/admin/facilities/${id}/toggle-featured`, {
        _token: '{{ csrf_token() }}'
    })
    .done(function(response) {
        if (response.success) {
            showAlert('success', response.message);
            location.reload();
        }
    })
    .fail(function() {
        showAlert('error', 'Terjadi kesalahan saat mengubah status unggulan.');
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