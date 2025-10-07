@extends('layouts.admin')

@section('title', 'Data Guru & Tenaga Kependidikan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data GTK</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                            <i class="fas fa-plus"></i> Tambah GTK
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        @foreach($teachers as $teacher)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    @if($teacher->getFirstMedia('profile'))
                                        <img src="{{ $teacher->getFirstMediaUrl('profile', 'thumb') }}" 
                                             class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                             style="width: 80px; height: 80px;">
                                            <i class="fas fa-user text-white fa-2x"></i>
                                        </div>
                                    @endif
                                    
                                    <h5 class="card-title">{{ $teacher->name }}</h5>
                                    <p class="text-muted">{{ $teacher->position }}</p>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-graduation-cap"></i> {{ $teacher->specialization }}
                                        </small>
                                    </div>
                                    
                                    @if($teacher->subjects->count() > 0)
                                    <div class="mb-2">
                                        @foreach($teacher->subjects->take(3) as $subject)
                                            <span class="badge badge-info">{{ $subject->name }}</span>
                                        @endforeach
                                        @if($teacher->subjects->count() > 3)
                                            <span class="badge badge-light">+{{ $teacher->subjects->count() - 3 }}</span>
                                        @endif
                                    </div>
                                    @endif
                                    
                                    <div class="btn-group w-100" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="viewTeacher({{ $teacher->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                onclick="editTeacher({{ $teacher->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="deleteTeacher({{ $teacher->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    {{ $teachers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addTeacherForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Guru/Tenaga Kependidikan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employee_id">NIP/NIK *</label>
                                <input type="text" name="employee_id" id="employee_id" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Lengkap *</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Telepon</label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea name="address" id="address" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="position">Jabatan *</label>
                                <select name="position" id="position" class="form-control" required>
                                    <option value="">Pilih Jabatan</option>
                                    <option value="Kepala Sekolah">Kepala Sekolah</option>
                                    <option value="Wakil Kepala Sekolah">Wakil Kepala Sekolah</option>
                                    <option value="Guru Kelas">Guru Kelas</option>
                                    <option value="Guru Mata Pelajaran">Guru Mata Pelajaran</option>
                                    <option value="Guru BK">Guru BK</option>
                                    <option value="Staff TU">Staff TU</option>
                                    <option value="Staff Perpustakaan">Staff Perpustakaan</option>
                                    <option value="Staff Kebersihan">Staff Kebersihan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="specialization">Bidang Keahlian</label>
                                <input type="text" name="specialization" id="specialization" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="education_level">Pendidikan Terakhir</label>
                                <select name="education_level" id="education_level" class="form-control">
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="S3">S3</option>
                                    <option value="S2">S2</option>
                                    <option value="S1">S1</option>
                                    <option value="D4">D4</option>
                                    <option value="D3">D3</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience_years">Pengalaman (tahun)</label>
                                <input type="number" name="experience_years" id="experience_years" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="join_date">Tanggal Bergabung</label>
                                <input type="date" name="join_date" id="join_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bio">Biografi Singkat</label>
                        <textarea name="bio" id="bio" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="photo">Foto Profil</label>
                        <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                        <small class="text-muted">Max: 2MB. Format: JPG, PNG</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#addTeacherForm').on('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    
    $.ajax({
        url: '{{ route("admin.teachers.store") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#addTeacherModal').modal('hide');
            location.reload();
        },
        error: function(xhr) {
            alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
        }
    });
});

function viewTeacher(id) {
    // Implementation for viewing teacher details
    window.open(`/admin/teachers/${id}`, '_blank');
}

function editTeacher(id) {
    // Implementation for editing teacher
    window.location.href = `/admin/teachers/${id}/edit`;
}

function deleteTeacher(id) {
    if(confirm('Yakin ingin menghapus data ini?')) {
        $.ajax({
            url: `/admin/teachers/${id}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                location.reload();
            }
        });
    }
}
</script>
@endpush