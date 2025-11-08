@extends('layouts.admin')

@section('title', 'Tambah Jadwal Guru')

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

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background-color: var(--bg-primary);
    border-radius: 0.5rem;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.conflict-item {
    background-color: var(--bg-tertiary);
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 0.5rem;
    border-left: 4px solid #ef4444;
}
</style>

<div class="qr-container">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                    Tambah Jadwal Guru
                </h1>
                <p class="text-sm mt-1" style="color: var(--text-secondary)">
                    Buat jadwal mengajar baru untuk guru
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
                <i class="fas fa-plus-circle mr-2"></i>Form Tambah Jadwal
            </h3>
        </div>

        <form action="{{ route('admin.teacher-schedules.store') }}" method="POST" class="needs-validation" novalidate id="scheduleForm">
            @csrf
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
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
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
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
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
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
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
                                @if($currentAcademicYear)
                                    <option value="{{ $currentAcademicYear->id }}" selected>
                                        {{ $currentAcademicYear->year }} (Aktif)
                                    </option>
                                @endif
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
                                <option value="monday" {{ old('day_of_week') == 'monday' ? 'selected' : '' }}>Senin</option>
                                <option value="tuesday" {{ old('day_of_week') == 'tuesday' ? 'selected' : '' }}>Selasa</option>
                                <option value="wednesday" {{ old('day_of_week') == 'wednesday' ? 'selected' : '' }}>Rabu</option>
                                <option value="thursday" {{ old('day_of_week') == 'thursday' ? 'selected' : '' }}>Kamis</option>
                                <option value="friday" {{ old('day_of_week') == 'friday' ? 'selected' : '' }}>Jumat</option>
                                <option value="saturday" {{ old('day_of_week') == 'saturday' ? 'selected' : '' }}>Sabtu</option>
                                <option value="sunday" {{ old('day_of_week') == 'sunday' ? 'selected' : '' }}>Minggu</option>
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
                                   value="{{ old('start_time') }}" required>
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
                                   value="{{ old('end_time') }}" required>
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
                               value="{{ old('room') }}" placeholder="Contoh: Ruang 101">
                        @error('room')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div>
                    <h4 class="section-header">
                        <i class="fas fa-sticky-note"></i>Catatan Tambahan
                    </h4>
                    <div>
                        <label for="notes" class="form-label">
                            <i class="fas fa-comment mr-1"></i>Catatan
                        </label>
                        <textarea name="notes" id="notes" class="form-input @error('notes') border-red-500 @enderror"
                                  rows="3" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t" style="border-color: var(--border-color)">
                <div class="flex justify-between">
                    <a href="{{ route('admin.teacher-schedules.index') }}" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-save mr-2"></i>Simpan Jadwal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Conflict Modal -->
<div id="conflictModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-lg font-semibold" style="color: var(--text-primary); margin: 0;">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Jadwal Bertabrakan
            </h3>
            <button id="closeModal" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
        <div class="modal-body">
            <p class="mb-4" style="color: var(--text-secondary)">
                Jadwal yang Anda buat bertabrakan dengan jadwal lain untuk guru yang sama. Berikut adalah jadwal yang bertabrakan:
            </p>
            <div id="conflictList"></div>
            <p class="mt-4 text-sm" style="color: var(--text-secondary)">
                <strong>Apa yang ingin Anda lakukan?</strong>
            </p>
        </div>
        <div class="modal-footer">
            <button id="cancelSchedule" class="btn-secondary">
                <i class="fas fa-times mr-2"></i>Batal & Ubah Jadwal
            </button>
            <button id="forceSave" class="btn-primary">
                <i class="fas fa-save mr-2"></i>Simpan Sekarang Juga
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let conflictData = null;

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

    // Handle form submission
    $('#scheduleForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();

        submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...').prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;

                if (response && response.conflicts) {
                    conflictData = response.conflicts;
                    showConflictModal(response.conflicts);
                } else {
                    // Handle other validation errors
                    if (response && response.errors) {
                        let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                        Object.values(response.errors).forEach(error => {
                            errorHtml += `<li>${error[0]}</li>`;
                        });
                        errorHtml += '</ul></div>';
                        // You might want to show this in a specific error container
                        console.error('Validation errors:', response.errors);
                    }
                }
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Show conflict modal
    function showConflictModal(conflicts) {
        const conflictList = $('#conflictList');
        conflictList.empty();

        conflicts.forEach(conflict => {
            conflictList.append(`
                <div class="conflict-item">
                    <div class="flex justify-between items-start">
                        <div>
                            <strong style="color: var(--text-primary)">${conflict.subject}</strong>
                            <div style="color: var(--text-secondary); font-size: 0.875rem;">
                                Kelas: ${conflict.class}<br>
                                Waktu: ${conflict.time_range}<br>
                                Ruangan: ${conflict.room}
                            </div>
                        </div>
                    </div>
                </div>
            `);
        });

        $('#conflictModal').fadeIn();
    }

    // Close modal
    $('#closeModal, #cancelSchedule').on('click', function() {
        $('#conflictModal').fadeOut();
        conflictData = null;
    });

    // Force save schedule
    $('#forceSave').on('click', function() {
        if (confirm('Apakah Anda yakin ingin menyimpan jadwal ini meskipun bertabrakan?')) {
            // Submit form with force flag
            const formData = new FormData($('#scheduleForm')[0]);
            formData.append('force_save', '1');

            $.ajax({
                url: $('#scheduleForm').attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {
                    console.error('Error saving schedule:', xhr.responseText);
                }
            });
        }
    });

    // Close modal when clicking outside
    $('#conflictModal').on('click', function(e) {
        if (e.target === this) {
            $(this).fadeOut();
            conflictData = null;
        }
    });
});
</script>
@endsection
