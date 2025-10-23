@extends('layouts.admin')

@section('title', 'Jadwal Guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>Jadwal Guru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.teacher-schedules.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Jadwal
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="teacherFilter">
                                <option value="">Semua Guru</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="classFilter">
                                <option value="">Semua Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="dayFilter">
                                <option value="">Semua Hari</option>
                                <option value="monday" {{ request('day_of_week') == 'monday' ? 'selected' : '' }}>Senin</option>
                                <option value="tuesday" {{ request('day_of_week') == 'tuesday' ? 'selected' : '' }}>Selasa</option>
                                <option value="wednesday" {{ request('day_of_week') == 'wednesday' ? 'selected' : '' }}>Rabu</option>
                                <option value="thursday" {{ request('day_of_week') == 'thursday' ? 'selected' : '' }}>Kamis</option>
                                <option value="friday" {{ request('day_of_week') == 'friday' ? 'selected' : '' }}>Jumat</option>
                                <option value="saturday" {{ request('day_of_week') == 'saturday' ? 'selected' : '' }}>Sabtu</option>
                                <option value="sunday" {{ request('day_of_week') == 'sunday' ? 'selected' : '' }}>Minggu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="academicYearFilter">
                                <option value="">Semua Tahun Akademik</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Guru</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>Ruangan</th>
                                    <th>Tahun Akademik</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->teacher->name }}</td>
                                        <td>{{ $schedule->class->name }}</td>
                                        <td>{{ $schedule->subject->name }}</td>
                                        <td>{{ $schedule->day_name }}</td>
                                        <td>{{ $schedule->time_range }}</td>
                                        <td>{{ $schedule->room ?? '-' }}</td>
                                        <td>{{ $schedule->academicYear->year }}</td>
                                        <td>
                                            <span class="badge {{ $schedule->is_active ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.teacher-schedules.show', $schedule) }}"
                                                   class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.teacher-schedules.edit', $schedule) }}"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.teacher-schedules.destroy', $schedule) }}"
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.teacher-schedules.toggle-status', $schedule) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $schedule->is_active ? 'btn-secondary' : 'btn-success' }}">
                                                        <i class="fas fa-{{ $schedule->is_active ? 'times' : 'check' }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <div class="empty-state">
                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                <h5>Tidak ada jadwal guru</h5>
                                                <p>Belum ada jadwal yang dibuat. Klik tombol "Tambah Jadwal" untuk membuat jadwal baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $schedules->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Filter functionality
    $('#teacherFilter, #classFilter, #dayFilter, #academicYearFilter').change(function() {
        const params = new URLSearchParams(window.location.search);

        // Update or remove parameters
        const teacherId = $('#teacherFilter').val();
        const classId = $('#classFilter').val();
        const day = $('#dayFilter').val();
        const academicYearId = $('#academicYearFilter').val();

        if (teacherId) params.set('teacher_id', teacherId); else params.delete('teacher_id');
        if (classId) params.set('class_id', classId); else params.delete('class_id');
        if (day) params.set('day_of_week', day); else params.delete('day_of_week');
        if (academicYearId) params.set('academic_year_id', academicYearId); else params.delete('academic_year_id');

        // Reset page
        params.delete('page');

        // Redirect with new filters
        window.location.href = '?' + params.toString();
    });
});
</script>
@endsection
