@extends('layouts.admin')

@section('title', 'Edit Jadwal Guru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>Edit Jadwal Guru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.teacher-schedules.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.teacher-schedules.update', $teacherSchedule) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Teacher Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="teacher_id">Guru <span class="text-danger">*</span></label>
                                    <select name="teacher_id" id="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror" required>
                                        <option value="">Pilih Guru</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ old('teacher_id', $teacherSchedule->teacher_id) == $teacher->id ? 'selected' : '' }}>
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
                                    <label for="class_id">Kelas <span class="text-danger">*</span></label>
                                    <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id', $teacherSchedule->class_id) == $class->id ? 'selected' : '' }}>
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

                        <div class="row">
                            <!-- Subject Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject_id">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <select name="subject_id" id="subject_id" class="form-control @error('subject_id') is-invalid @enderror" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject_id', $teacherSchedule->subject_id) == $subject->id ? 'selected' : '' }}>
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
                                    <label for="academic_year_id">Tahun Akademik <span class="text-danger">*</span></label>
                                    <select name="academic_year_id" id="academic_year_id" class="form-control @error('academic_year_id') is-invalid @enderror" required>
                                        <option value="">Pilih Tahun Akademik</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ old('academic_year_id', $teacherSchedule->academic_year_id) == $year->id ? 'selected' : '' }}>
                                                {{ $year->year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('academic_year_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Day of Week -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="day_of_week">Hari <span class="text-danger">*</span></label>
                                    <select name="day_of_week" id="day_of_week" class="form-control @error('day_of_week') is-invalid @enderror" required>
                                        <option value="">Pilih Hari</option>
                                        <option value="monday" {{ old('day_of_week', $teacherSchedule->day_of_week) == 'monday' ? 'selected' : '' }}>Senin</option>
                                        <option value="tuesday" {{ old('day_of_week', $teacherSchedule->day_of_week) == 'tuesday' ? 'selected' : '' }}>Selasa</option>
                                        <option value="wednesday" {{ old('day_of_week', $teacherSchedule->day_of_week) == 'wednesday' ? 'selected' : '' }}>Rabu</option>
                                        <option value="thursday" {{ old('day_of_week', $teacherSchedule->day_of_week) == 'thursday' ? 'selected' : '' }}>Kamis</option>
                                        <option value="friday" {{ old('day_of_week', $teacherSchedule->day_of_week) == 'friday' ? 'selected' : '' }}>Jumat</option>
                                        <option value="saturday" {{ old('day_of_week', $teacherSchedule->day_of_week) == 'saturday' ? 'selected' : '' }}>Sabtu</option>
                                        <option value="sunday" {{ old('day_of_week', $teacherSchedule->day_of_week) == 'sunday' ? 'selected' : '' }}>Minggu</option>
                                    </select>
                                    @error('day_of_week')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Room -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room">Ruangan</label>
                                    <input type="text" name="room" id="room" class="form-control @error('room') is-invalid @enderror"
                                           value="{{ old('room', $teacherSchedule->room) }}" placeholder="Contoh: Ruang 101">
                                    @error('room')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Start Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_time">Waktu Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                           value="{{ old('start_time', $teacherSchedule->start_time ? $teacherSchedule->start_time->format('H:i') : '') }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- End Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_time">Waktu Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                           value="{{ old('end_time', $teacherSchedule->end_time ? $teacherSchedule->end_time->format('H:i') : '') }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Active Status -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $teacherSchedule->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Jadwal Aktif</label>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror"
                                      rows="3" placeholder="Catatan tambahan (opsional)">{{ old('notes', $teacherSchedule->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Jadwal
                        </button>
                        <a href="{{ route('admin.teacher-schedules.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
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
