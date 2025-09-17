<div class="row">
    <div class="col-md-6">
        <h6 class="text-primary dark:text-blue-400 mb-3">Informasi Siswa</h6>
        <table class="table table-borderless dark:table-dark">
            <tr>
                <td class="fw-bold dark:text-gray-200">Nama:</td>
                <td class="dark:text-gray-300">{{ $registration->student_name }}</td>
            </tr>
            <tr>
                <td class="fw-bold dark:text-gray-200">NIS:</td>
                <td class="dark:text-gray-300">{{ $registration->student_nis }}</td>
            </tr>
            <tr>
                <td class="fw-bold dark:text-gray-200">Kelas:</td>
                <td class="dark:text-gray-300">{{ $registration->student_class }} {{ $registration->student_major }}</td>
            </tr>
            <tr>
                <td class="fw-bold dark:text-gray-200">Email:</td>
                <td class="dark:text-gray-300">{{ $registration->email }}</td>
            </tr>
            <tr>
                <td class="fw-bold dark:text-gray-200">Telepon:</td>
                <td class="dark:text-gray-300">{{ $registration->phone }}</td>
            </tr>
            <tr>
                <td class="fw-bold dark:text-gray-200">Orang Tua:</td>
                <td class="dark:text-gray-300">{{ $registration->parent_name }}</td>
            </tr>
            <tr>
                <td class="fw-bold dark:text-gray-200">Telepon Orang Tua:</td>
                <td class="dark:text-gray-300">{{ $registration->parent_phone }}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h6 class="text-primary dark:text-blue-400 mb-3">Informasi Pendaftaran</h6>
        <table class="table table-borderless dark:table-dark">
            <tr>
                <td class="fw-bold dark:text-gray-200">Ekstrakurikuler:</td>
                <td class="dark:text-gray-300">{{ $registration->extracurricular->name }}</td>
            </tr>
            <tr>
                <td class="fw-bold dark:text-gray-200">Tanggal Daftar:</td>
                <td class="dark:text-gray-300">{{ $registration->registered_at->format('d M Y, H:i') }}</td>
            </tr>
            <tr>
                <td class="fw-bold dark:text-gray-200">Status:</td>
                <td>
                    @if($registration->status === 'pending')
                        <span class="badge bg-warning dark:bg-yellow-600">Menunggu</span>
                    @elseif($registration->status === 'approved')
                        <span class="badge bg-success dark:bg-green-600">Diterima</span>
                    @else
                        <span class="badge bg-danger dark:bg-red-600">Ditolak</span>
                    @endif
                </td>
            </tr>
            @if($registration->approved_at)
                <tr>
                    <td class="fw-bold dark:text-gray-200">Diproses:</td>
                    <td class="dark:text-gray-300">{{ $registration->approved_at->format('d M Y, H:i') }}</td>
                </tr>
            @endif
            @if($registration->approvedBy)
                <tr>
                    <td class="fw-bold dark:text-gray-200">Diproses oleh:</td>
                    <td class="dark:text-gray-300">{{ $registration->approvedBy->name }}</td>
                </tr>
            @endif
        </table>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h6 class="text-primary dark:text-blue-400 mb-3">Alamat</h6>
        <p class="dark:text-gray-300">{{ $registration->address }}</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h6 class="text-primary dark:text-blue-400 mb-3">Alasan Bergabung</h6>
        <div class="p-3 bg-light dark:bg-gray-700 rounded">
            <p class="mb-0 dark:text-gray-300">{{ $registration->reason }}</p>
        </div>
    </div>
</div>

@if($registration->experience)
<div class="row mt-3">
    <div class="col-12">
        <h6 class="text-primary dark:text-blue-400 mb-3">Pengalaman Terkait</h6>
        <div class="p-3 bg-light dark:bg-gray-700 rounded">
            <p class="mb-0 dark:text-gray-300">{{ $registration->experience }}</p>
        </div>
    </div>
</div>
@endif

@if($registration->notes)
<div class="row mt-3">
    <div class="col-12">
        <h6 class="text-danger dark:text-red-400 mb-3">Catatan Admin</h6>
        <div class="alert alert-warning dark:bg-yellow-800 dark:border-yellow-600">
            <p class="mb-0 dark:text-yellow-200">{{ $registration->notes }}</p>
        </div>
    </div>
</div>
@endif

@if($registration->status === 'pending')
<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-end gap-2">
            <button class="btn btn-success" onclick="approveRegistration({{ $registration->id }})">
                <i class="fas fa-check me-2"></i>Setujui
            </button>
            <button class="btn btn-danger" onclick="rejectRegistration({{ $registration->id }})">
                <i class="fas fa-times me-2"></i>Tolak
            </button>
        </div>
    </div>
</div>
@endif