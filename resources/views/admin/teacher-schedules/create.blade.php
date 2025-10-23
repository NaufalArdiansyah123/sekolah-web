@extends('layouts.admin')

@section('title', 'Tambah Jadwal Guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="content-card shadow-sm">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus-circle mr-2"></i>Tambah Jadwal Guru
                    </h3>
                    <a href="{{ route('admin.teacher-schedules.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>

                <form action="{{ route('admin.teacher-schedules.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="card-body">
                        <!-- Informasi Dasar -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-info-circle mr-2"></i>Informasi Dasar
                            </h5>
                            <div class="row">
                                <!-- Teacher Selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="teacher_id" class="form-label fw-bold">
                                            <i class="fas fa-user-tie text-primary mr-1"></i>Guru <span class="text-danger">*</span>
                                        </label>
                                        <select name="teacher_id" id="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror" required>
                                            <option value="">Pilih Guru</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->name }} ({{ $teacher->nip }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('teacher_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Class Selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="class_id" class="form-label fw-bold">
                                            <i class="fas fa-school text-primary mr-1"></i>Kelas <span class="text-danger">*</span>
                                        </label>
                                        <select name="class_id" id="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('class_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Akademik -->
                        <div class="mb-4">
                            <h5 class="text-success mb-3">
                                <i class="fas fa-book-open text-success mr-2"></i>Informasi Akademik
                            </h5>
                            <div class="row">
                                <!-- Subject Selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject_id" class="form-label fw-bold">
                                            <i class="fas fa-book text-success mr-1"></i>Mata Pelajaran <span class="text-danger">*</span>
                                        </label>
                                        <select name="subject_id" id="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                                            <option value="">Pilih Mata Pelajaran</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('subject_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Academic Year Selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="academic_year_id" class="form-label fw-bold">
                                            <i class="fas fa-calendar-alt text-success mr-1"></i>Tahun Akademik <span class="text-danger">*</span>
                                        </label>
                                        <select name="academic_year_id" id="academic_year_id" class="form-select @error('academic_year_id') is-invalid @enderror" required>
                                            <option value="">Pilih Tahun Akademik</option>
                                            @if($currentAcademicYear)
                                                <option value="{{ $currentAcademicYear->id }}" selected>
                                                    {{ $currentAcademicYear->year }} (Aktif)
                                                </option>
                                            @endif
                                        </select>
                                        @error('academic_year_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jadwal dan Lokasi -->
                        <div class="mb-4">
                            <h5 class="text-warning mb-3">
                                <i class="fas fa-clock text-warning mr-2"></i>Jadwal dan Lokasi
                            </h5>
                            <div class="row">
                                <!-- Day of Week -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="day_of_week" class="form-label fw-bold">
                                            <i class="fas fa-calendar-day text-warning mr-1"></i>Hari <span class="text-danger">*</span>
                                        </label>
                                        <select name="day_of_week" id="day_of_week" class="form-select @error('day_of_week') is-invalid @enderror" required>
                                            <option value="">Pilih Hari</option>
                                            <option value="monday" {{ old('day_of_week') == 'monday' ? 'selected' : '' }}>Senin</option>
                                            <option value="tuesday" {{ old('day_of_week') == 'tuesday' ? 'selected' : '' }}>Selasa</option>
                                            <option value="wednesday" {{ old('day_of_week') == 'wednesday' ? 'selected' : '' }}>Rabu</option>
                                            <option value="thursday" {{ old('day_of_week') == 'thursday' ? 'selected' : '' }}>Kamis</option>
                                            <option value="friday" {{ old('day_of_week') == 'friday' ? 'selected' : '' }}>Jumat</option>
                                            <option value="saturday" {{ old('day_of_week') == 'saturday' ? 'selected' : '' }}>Sabtu</option>
                                            <option value="sunday" {{ old('day_of_week') == 'sunday' ? 'selected' : '' }}>Minggu</option>
                                        </select>
                                        @error('day_of_week')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Start Time -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_time" class="form-label fw-bold">
                                            <i class="fas fa-hourglass-start text-warning mr-1"></i>Waktu Mulai <span class="text-danger">*</span>
                                        </label>
                                        <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                               value="{{ old('start_time') }}" required>
                                        @error('start_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- End Time -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="end_time" class="form-label fw-bold">
                                            <i class="fas fa-hourglass-end text-warning mr-1"></i>Waktu Selesai <span class="text-danger">*</span>
                                        </label>
                                        <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                               value="{{ old('end_time') }}" required>
                                        @error('end_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Room -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="room" class="form-label fw-bold">
                                            <i class="fas fa-map-marker-alt text-warning mr-1"></i>Ruangan
                                        </label>
                                        <input type="text" name="room" id="room" class="form-control @error('room') is-invalid @enderror"
                                               value="{{ old('room') }}" placeholder="Contoh: Ruang 101">
                                        @error('room')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Tambahan -->
                        <div class="mb-4">
                            <h5 class="text-info mb-3">
                                <i class="fas fa-sticky-note text-info mr-2"></i>Catatan Tambahan
                            </h5>
                            <div class="form-group">
                                <label for="notes" class="form-label fw-bold">
                                    <i class="fas fa-comment text-info mr-1"></i>Catatan
                                </label>
                                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror"
                                          rows="3" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('admin.teacher-schedules.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times mr-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Validate end time is after start time
    $('#start_time, #end_time').change(function() {
        const startTime = $('#start_time').val();
        const endTime = $('#end_time').val();

        if (startTime && endTime) {
            if (startTime >= endTime) {
                $('#end_time').addClass('is-invalid');
                $('#end_time').after('<div class="invalid-feedback">Waktu selesai harus setelah waktu mulai.</div>');
            } else {
                $('#end_time').removeClass('is-invalid');
                $('#end_time').next('.invalid-feedback').remove();
            }
        }
    });

    // Check for conflicts when teacher or day changes
    $('#teacher_id, #day_of_week, #start_time, #end_time').change(function() {
        const teacherId = $('#teacher_id').val();
        const dayOfWeek = $('#day_of_week').val();
        const startTime = $('#start_time').val();
        const endTime = $('#end_time').val();

        if (teacherId && dayOfWeek && startTime && endTime) {
            // You can add AJAX validation here to check for conflicts
            console.log('Checking for conflicts...');
        }
    });
});
</script>
@endsection
