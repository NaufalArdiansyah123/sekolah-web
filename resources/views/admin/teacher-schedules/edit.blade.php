@extends('layouts.admin')

@section('title', 'Edit Jadwal Guru')

@section('content')
<style>
/* Minimal Monochrome Styling */
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f7f7f7;
    --bg-tertiary: #efefef;
    --text-primary: #111111;
    --text-secondary: #555555;
    --border-color: #dddddd;
    --accent-color: #222222;
}

.qr-container {
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    min-height: 100vh;
    padding: 1.5rem;
}

.qr-card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    color: var(--text-primary);
}

.qr-header {
    background-color: var(--bg-tertiary);
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.btn-primary {
    background-color: var(--accent-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: 1px solid var(--accent-color);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-primary:hover {
    filter: brightness(1.1);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background-color: var(--bg-tertiary);
    color: var(--text-primary);
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: 1px solid var(--border-color);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-secondary:hover {
    background-color: var(--border-color);
    color: var(--text-primary);
    text-decoration: none;
}

.form-input {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    width: 100%;
}

.form-input:focus {
    outline: none;
    border-color: #999;
}

.form-label {
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.section-header {
    color: var(--accent-color);
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-header i {
    color: var(--accent-color);
}

.custom-control-label {
    font-weight: 500;
    color: var(--text-primary);
}
</style>

<div class="qr-container">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                    Edit Jadwal Guru
                </h1>
                <p class="text-sm mt-1" style="color: var(--text-secondary)">
                    Ubah jadwal mengajar guru
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.teacher-schedules.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="qr-card">
        <div class="qr-header">
            <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                <i class="fas fa-edit mr-2"></i>Form Edit Jadwal
            </h3>
        </div>

        <form action="{{ route('admin.teacher-schedules.update', $teacherSchedule) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
                <!-- Informasi Dasar -->
                <div>
                    <h4 class="section-header">
                        <i class="fas fa-info-circle"></i>Informasi Dasar
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Teacher Selection -->
                        <div>
                            <label for="teacher_id" class="form-label">
                                <i class="fas fa-user-tie mr-1"></i>Guru <span class="text-red-500">*</span>
                            </label>
                            <select name="teacher_id" id="teacher_id" class="form-input @error('teacher_id') border-red-500 @enderror" required>
                                <option value="">Pilih Guru</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $teacherSchedule->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }} ({{ $teacher->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Class Selection -->
                        <div>
                            <label for="class_id" class="form-label">
                                <i class="fas fa-school mr-1"></i>Kelas <span class="text-red-500">*</span>
                            </label>
                            <select name="class_id" id="class_id" class="form-input @error('class_id') border-red-500 @enderror" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $teacherSchedule->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Akademik -->
                <div>
                    <h4 class="section-header">
                        <i class="fas fa-book-open"></i>Informasi Akademik
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Subject Selection -->
                        <div>
                            <label for="subject_id" class="form-label">
                                <i class="fas fa-book mr-1"></i>Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <select name="subject_id" id="subject_id" class="form-input @error('subject_id') border-red-500 @enderror" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $teacherSchedule->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Academic Year Selection -->
                        <div>
                            <label for="academic_year_id" class="form-label">
                                <i class="fas fa-calendar-alt mr-1"></i>Tahun Akademik <span class="text-red-500">*</span>
                            </label>
                            <select name="academic_year_id" id="academic_year_id" class="form-input @error('academic_year_id') border-red-500 @enderror" required>
                                <option value="">Pilih Tahun Akademik</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ old('academic_year_id', $teacherSchedule->academic_year_id) == $year->id ? 'selected' : '' }}>
                                        {{ $year->year }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academic_year_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Jadwal dan Lokasi -->
                <div>
                    <h4 class="section-header">
                        <i class="fas fa-clock"></i>Jadwal dan Lokasi
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <!-- Day of Week -->
                        <div>
                            <label for="day_of_week" class="form-label">
                                <i class="fas fa-calendar-day mr-1"></i>Hari <span class="text-red-500">*</span>
                            </label>
                            <select name="day_of_week" id="day_of_week" class="form-input @error('day_of_week') border-red-500 @enderror" required>
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
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="form-label">
                                <i class="fas fa-hourglass-start mr-1"></i>Waktu Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="start_time" id="start_time" class="form-input @error('start_time') border-red-500 @enderror"
                                   value="{{ old('start_time', $teacherSchedule->start_time ? $teacherSchedule->start_time->format('H:i') : '') }}" required>
                            @error('start_time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="form-label">
                                <i class="fas fa-hourglass-end mr-1"></i>Waktu Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="end_time" id="end_time" class="form-input @error('end_time') border-red-500 @enderror"
                                   value="{{ old('end_time', $teacherSchedule->end_time ? $teacherSchedule->end_time->format('H:i') : '') }}" required>
                            @error('end_time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Room -->
                    <div>
                        <label for="room" class="form-label">
                            <i class="fas fa-map-marker-alt mr-1"></i>Ruangan
                        </label>
                        <input type="text" name="room" id="room" class="form-input @error('room') border-red-500 @enderror"
                               value="{{ old('room', $teacherSchedule->room) }}" placeholder="Contoh: Ruang 101">
                        @error('room')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status dan Catatan -->
                <div>
                    <h4 class="section-header">
                        <i class="fas fa-cogs"></i>Status dan Catatan
                    </h4>
                    <div class="space-y-4">
                        <!-- Active Status -->
                        <div>
                            <div class="flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="mr-2" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $teacherSchedule->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="custom-control-label">
                                    Jadwal Aktif
                                </label>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="form-label">
                                <i class="fas fa-comment mr-1"></i>Catatan
                            </label>
                            <textarea name="notes" id="notes" class="form-input @error('notes') border-red-500 @enderror"
                                rows="3" placeholder="Catatan tambahan (opsional)">{{ old('notes', $teacherSchedule->notes) }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t" style="border-color: var(--border-color)">
                <div class="flex justify-between">
                    <a href="{{ route('admin.teacher-schedules.index') }}" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Jadwal
                    </button>
                </div>
            </div>
        </form>
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
                $('#end_time').addClass('border-red-500');
                if (!$('#end_time').next('.text-red-500').length) {
                    $('#end_time').after('<p class="text-red-500 text-xs mt-1">Waktu selesai harus setelah waktu mulai.</p>');
                }
            } else {
                $('#end_time').removeClass('border-red-500');
                $('#end_time').next('.text-red-500').remove();
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
