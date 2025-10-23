@extends('layouts.admin')

@section('title', 'Detail Jadwal Guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>Detail Jadwal Guru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.teacher-schedules.edit', $teacherSchedule) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.teacher-schedules.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Teacher Information -->
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-user-tie mr-2"></i>Informasi Guru
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-4">Nama:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->teacher->name }}</dd>

                                        <dt class="col-sm-4">NIP:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->teacher->nip }}</dd>

                                        <dt class="col-sm-4">Email:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->teacher->email }}</dd>

                                        <dt class="col-sm-4">Telepon:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->teacher->phone ?? '-' }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Information -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-calendar-check mr-2"></i>Informasi Jadwal
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-4">Kelas:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->class->name }}</dd>

                                        <dt class="col-sm-4">Mata Pelajaran:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->subject->name }}</dd>

                                        <dt class="col-sm-4">Hari:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->day_name }}</dd>

                                        <dt class="col-sm-4">Waktu:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->time_range }}</dd>

                                        <dt class="col-sm-4">Ruangan:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->room ?? '-' }}</dd>

                                        <dt class="col-sm-4">Tahun Akademik:</dt>
                                        <dd class="col-sm-8">{{ $teacherSchedule->academicYear->year }}</dd>

                                        <dt class="col-sm-4">Status:</dt>
                                        <dd class="col-sm-8">
                                            <span class="badge {{ $teacherSchedule->is_active ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $teacherSchedule->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    @if($teacherSchedule->notes)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-sticky-note mr-2"></i>Catatan
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $teacherSchedule->notes }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Additional Information -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle mr-2"></i>Informasi Tambahan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-3">Dibuat:</dt>
                                        <dd class="col-sm-9">{{ $teacherSchedule->created_at->format('d M Y H:i') }}</dd>

                                        <dt class="col-sm-3">Terakhir Diupdate:</dt>
                                        <dd class="col-sm-9">{{ $teacherSchedule->updated_at->format('d M Y H:i') }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.teacher-schedules.edit', $teacherSchedule) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Jadwal
                        </a>
                        <form action="{{ route('admin.teacher-schedules.toggle-status', $teacherSchedule) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn {{ $teacherSchedule->is_active ? 'btn-secondary' : 'btn-success' }}">
                                <i class="fas fa-{{ $teacherSchedule->is_active ? 'times' : 'check' }}"></i>
                                {{ $teacherSchedule->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.teacher-schedules.destroy', $teacherSchedule) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('admin.teacher-schedules.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
