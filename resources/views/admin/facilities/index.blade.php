@extends('layouts.admin')

@section('title', 'Manajemen Fasilitas')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-building me-2"></i>Manajemen Fasilitas
        </h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Fasilitas
            </a>
            <a href="{{ route('facilities.index') }}" target="_blank" class="btn btn-outline-info">
                <i class="fas fa-eye me-2"></i>Lihat Halaman Publik
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.facilities.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Pencarian</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nama, deskripsi, lokasi...">
                </div>
                <div class="col-md-2">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="sort_by" class="form-label">Urutkan</label>
                    <select class="form-select" id="sort_by" name="sort_by">
                        <option value="sort_order" {{ request('sort_by') == 'sort_order' ? 'selected' : '' }}>Urutan</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
                        <option value="category" {{ request('sort_by') == 'category' ? 'selected' : '' }}>Kategori</option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="sort_order" class="form-label">Arah</label>
                    <select class="form-select" id="sort_order" name="sort_order">
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="card shadow mb-4" id="bulk-actions" style="display: none;">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">
                    <span id="selected-count">0</span> item dipilih
                </span>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-success" onclick="bulkAction('activate')">
                        <i class="fas fa-check"></i> Aktifkan
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" onclick="bulkAction('deactivate')">
                        <i class="fas fa-pause"></i> Nonaktifkan
                    </button>
                    <button type="button" class="btn btn-sm btn-info" onclick="bulkAction('feature')">
                        <i class="fas fa-star"></i> Jadikan Unggulan
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-info" onclick="bulkAction('unfeature')">
                        <i class="far fa-star"></i> Hapus Unggulan
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="bulkAction('delete')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Facilities Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Fasilitas ({{ $facilities->total() }} total)
            </h6>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="select-all">
                <label class="form-check-label" for="select-all">
                    Pilih Semua
                </label>
            </div>
        </div>
        <div class="card-body">
            @if($facilities->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="30px">
                                    <input type="checkbox" id="select-all-header">
                                </th>
                                <th width="80px">Gambar</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Kapasitas</th>
                                <th>Lokasi</th>
                                <th>Unggulan</th>
                                <th>Urutan</th>
                                <th width="150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($facilities as $facility)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="facility-checkbox" value="{{ $facility->id }}">
                                    </td>
                                    <td>
                                        @if($facility->image)
                                            <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" 
                                                 class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $facility->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($facility->description, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $facility->category_label }}</span>
                                    </td>
                                    <td>
                                        {!! $facility->status_badge !!}
                                    </td>
                                    <td>
                                        {{ $facility->capacity ? $facility->capacity . ' orang' : '-' }}
                                    </td>
                                    <td>{{ $facility->location ?: '-' }}</td>
                                    <td>
                                        @if($facility->is_featured)
                                            <i class="fas fa-star text-warning" title="Unggulan"></i>
                                        @else
                                            <i class="far fa-star text-muted" title="Bukan Unggulan"></i>
                                        @endif
                                    </td>
                                    <td>{{ $facility->sort_order }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.facilities.show', $facility) }}" 
                                               class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.facilities.edit', $facility) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="deleteFacility({{ $facility->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group mt-1" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="toggleStatus({{ $facility->id }})" title="Toggle Status">
                                                <i class="fas fa-toggle-{{ $facility->status === 'active' ? 'on' : 'off' }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" 
                                                    onclick="toggleFeatured({{ $facility->id }})" title="Toggle Unggulan">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $facilities->firstItem() }} - {{ $facilities->lastItem() }} 
                        dari {{ $facilities->total() }} hasil
                    </div>
                    {{ $facilities->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada fasilitas</h5>
                    <p class="text-muted">Klik tombol "Tambah Fasilitas" untuk menambah fasilitas baru.</p>
                    <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Fasilitas
                    </a>
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
                <p>Apakah Anda yakin ingin menghapus fasilitas ini?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
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
    // Select all functionality
    $('#select-all, #select-all-header').change(function() {
        const isChecked = $(this).is(':checked');
        $('.facility-checkbox').prop('checked', isChecked);
        $('#select-all, #select-all-header').prop('checked', isChecked);
        updateBulkActions();
    });

    // Individual checkbox change
    $('.facility-checkbox').change(function() {
        updateBulkActions();
        
        const totalCheckboxes = $('.facility-checkbox').length;
        const checkedCheckboxes = $('.facility-checkbox:checked').length;
        
        $('#select-all, #select-all-header').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    function updateBulkActions() {
        const checkedCount = $('.facility-checkbox:checked').length;
        $('#selected-count').text(checkedCount);
        
        if (checkedCount > 0) {
            $('#bulk-actions').show();
        } else {
            $('#bulk-actions').hide();
        }
    }
});

function deleteFacility(id) {
    $('#deleteForm').attr('action', `/admin/facilities/${id}`);
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

function bulkAction(action) {
    const selectedIds = $('.facility-checkbox:checked').map(function() {
        return $(this).val();
    }).get();

    if (selectedIds.length === 0) {
        showAlert('warning', 'Pilih minimal satu fasilitas.');
        return;
    }

    let confirmMessage = '';
    switch (action) {
        case 'delete':
            confirmMessage = 'Apakah Anda yakin ingin menghapus fasilitas yang dipilih?';
            break;
        case 'activate':
            confirmMessage = 'Apakah Anda yakin ingin mengaktifkan fasilitas yang dipilih?';
            break;
        case 'deactivate':
            confirmMessage = 'Apakah Anda yakin ingin menonaktifkan fasilitas yang dipilih?';
            break;
        case 'feature':
            confirmMessage = 'Apakah Anda yakin ingin menjadikan fasilitas yang dipilih sebagai unggulan?';
            break;
        case 'unfeature':
            confirmMessage = 'Apakah Anda yakin ingin menghapus fasilitas yang dipilih dari unggulan?';
            break;
    }

    if (confirm(confirmMessage)) {
        $.post('{{ route("admin.facilities.bulk-action") }}', {
            _token: '{{ csrf_token() }}',
            action: action,
            ids: selectedIds
        })
        .done(function(response) {
            if (response.success) {
                showAlert('success', response.message);
                location.reload();
            }
        })
        .fail(function() {
            showAlert('error', 'Terjadi kesalahan saat melakukan aksi bulk.');
        });
    }
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