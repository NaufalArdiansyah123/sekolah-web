@extends('layouts.admin')

@section('title', 'PKL Registration Details')

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

        .dark {
            --bg-primary: #1e293b;
            --bg-secondary: #0f172a;
            --bg-tertiary: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: #334155;
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
        }

        .btn-primary:hover {
            filter: brightness(1.1);
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
        }

        .btn-secondary:hover {
            background-color: var(--border-color);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #dc3545;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            filter: brightness(1.1);
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

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid var(--border-color);
        }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background-color: var(--bg-primary);
            border-radius: 0.75rem;
            max-width: 28rem;
            width: 90%;
            border: 1px solid var(--border-color);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 500;
            color: var(--text-secondary);
        }

        .detail-value {
            color: var(--text-primary);
        }
    </style>

    <div class="qr-container">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                        PKL Registration Details
                    </h1>
                    <p class="text-sm mt-1" style="color: var(--text-secondary)">
                        Detail pendaftaran PKL siswa
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.pkl-registrations.index') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Student Information -->
        <div class="qr-card mb-6">
            <div class="qr-header">
                <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                    <i class="fas fa-user mr-2"></i>Student Information
                </h3>
            </div>
            <div class="p-6">
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value">{{ $pklRegistration->student->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $pklRegistration->student->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">NIS:</span>
                    <span class="detail-value">{{ $pklRegistration->student->nis ?? 'Not set' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">NISN:</span>
                    <span class="detail-value">{{ $pklRegistration->student->nisn ?? 'Not set' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Class:</span>
                    <span class="detail-value">{{ $pklRegistration->student->class->name ?? 'Not assigned' }}</span>
                </div>
            </div>
        </div>

        <!-- Tempat PKL Information -->
        <div class="qr-card mb-6">
            <div class="qr-header">
                <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                    <i class="fas fa-building mr-2"></i>Tempat PKL Information
                </h3>
            </div>
            <div class="p-6">
                <div class="detail-row">
                    <span class="detail-label">Nama Tempat:</span>
                    <span class="detail-value">{{ $pklRegistration->tempatPkl->nama_tempat }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Alamat:</span>
                    <span class="detail-value">{{ $pklRegistration->tempatPkl->alamat }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kota:</span>
                    <span class="detail-value">{{ $pklRegistration->tempatPkl->kota ?? 'Not specified' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pembimbing Lapangan:</span>
                    <span
                        class="detail-value">{{ $pklRegistration->tempatPkl->pembimbing_lapangan ?? 'Not specified' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kuota:</span>
                    <span class="detail-value">{{ $pklRegistration->tempatPkl->kuota }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kuota Tersedia:</span>
                    <span class="detail-value">{{ $pklRegistration->tempatPkl->kuota_tersedia }}</span>
                </div>
            </div>
        </div>

        <!-- Registration Details -->
        <div class="qr-card mb-6">
            <div class="qr-header">
                <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                    <i class="fas fa-clipboard-list mr-2"></i>Registration Details
                </h3>
            </div>
            <div class="p-6">
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        @if($pklRegistration->status == 'pending')
                            <span class="status-badge"
                                style="background-color: var(--bg-tertiary); color: var(--text-primary)">Pending</span>
                        @elseif($pklRegistration->status == 'approved')
                            <span class="status-badge" style="background-color: #d4edda; color: #155724">Approved</span>
                        @elseif($pklRegistration->status == 'rejected')
                            <span class="status-badge" style="background-color: #f8d7da; color: #721c24">Rejected</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Mulai:</span>
                    <span
                        class="detail-value">{{ $pklRegistration->tanggal_mulai ? \Carbon\Carbon::parse($pklRegistration->tanggal_mulai)->format('d M Y') : '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Selesai:</span>
                    <span
                        class="detail-value">{{ $pklRegistration->tanggal_selesai ? \Carbon\Carbon::parse($pklRegistration->tanggal_selesai)->format('d M Y') : '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Applied At:</span>
                    <span class="detail-value">{{ $pklRegistration->created_at->format('d M Y H:i') }}</span>
                </div>
                @if($pklRegistration->approved_at)
                    <div class="detail-row">
                        <span class="detail-label">Approved At:</span>
                        <span class="detail-value">{{ $pklRegistration->approved_at->format('d M Y H:i') }}</span>
                    </div>
                @endif
                @if($pklRegistration->rejected_at)
                    <div class="detail-row">
                        <span class="detail-label">Rejected At:</span>
                        <span class="detail-value">{{ $pklRegistration->rejected_at->format('d M Y H:i') }}</span>
                    </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Alasan:</span>
                    <span class="detail-value">{{ $pklRegistration->alasan }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Catatan:</span>
                    <span class="detail-value">{{ $pklRegistration->catatan ?? '-' }}</span>
                </div>
                @if($pklRegistration->notes)
                    <div class="detail-row">
                        <span class="detail-label">Admin Notes:</span>
                        <span class="detail-value">{{ $pklRegistration->notes }}</span>
                    </div>
                @endif

                <!-- QR Code Section -->
                @if($pklRegistration->status == 'approved')
                    <div class="mt-4 pt-4 border-t" style="border-color: var(--border-color)">
                        <h6 class="text-sm font-semibold mb-3" style="color: var(--text-primary)">QR Code:</h6>
                        @if($pklRegistration->qr_image_path)
                            <div class="flex items-center gap-3 mb-3">
                                <img src="{{ $pklRegistration->qr_image_url }}" alt="QR Code" class="w-32 h-32 border"
                                    style="border-color: var(--border-color)">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('admin.pkl-registrations.view-qr', $pklRegistration) }}" target="_blank"
                                        class="btn-primary">
                                        <i class="fas fa-eye mr-2"></i>View QR Code
                                    </a>
                                    <a href="{{ route('admin.pkl-registrations.download-qr', $pklRegistration) }}"
                                        class="btn-secondary">
                                        <i class="fas fa-download mr-2"></i>Download QR Code
                                    </a>
                                    <form method="POST"
                                        action="{{ route('admin.pkl-registrations.regenerate-qr', $pklRegistration) }}"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-secondary"
                                            onclick="return confirm('Are you sure you want to regenerate the QR code?')">
                                            <i class="fas fa-refresh mr-2"></i>Regenerate QR Code
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-xs" style="color: var(--text-secondary)">
                                QR Code: {{ $pklRegistration->qr_code }}
                            </div>
                        @else
                            <form method="POST" action="{{ route('admin.pkl-registrations.generate-qr', $pklRegistration) }}"
                                class="d-inline">
                                @csrf
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-qrcode mr-2"></i>Generate QR Code
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                <!-- Document Links -->
                @if($pklRegistration->surat_pengantar)
                    <div class="mt-4 pt-4 border-t" style="border-color: var(--border-color)">
                        <h6 class="text-sm font-semibold mb-3" style="color: var(--text-primary)">Documents:</h6>
                        <a href="{{ route('admin.pkl-registrations.view-document', $pklRegistration) }}" target="_blank"
                            class="btn-primary">
                            <i class="fas fa-file-pdf mr-2"></i>Lihat Surat Pengantar
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        @if($pklRegistration->isPending())
            <div class="qr-card">
                <div class="qr-header">
                    <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                        <i class="fas fa-cogs mr-2"></i>Actions
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('admin.pkl-registrations.approve', $pklRegistration) }}"
                            class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-primary"
                                onclick="return confirm('Are you sure you want to approve this registration?')">
                                <i class="fas fa-check mr-2"></i>Approve Registration
                            </button>
                        </form>
                        <button type="button" class="btn-danger"
                            onclick="openRejectModal({{ $pklRegistration->id }}, '{{ route('admin.pkl-registrations.reject', $pklRegistration) }}')">
                            <i class="fas fa-times mr-2"></i>Reject Registration
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize tooltips if needed
            $('[data-toggle="tooltip"]').tooltip();
        });

        function openRejectModal(id, url) {
            // Create modal HTML
            const modalHtml = `
                                <div class="modal-overlay show" id="rejectModal${id}">
                                    <div class="modal-content">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <h3 class="text-lg font-semibold" style="color: var(--text-primary)">Reject PKL Registration</h3>
                                                <button onclick="closeRejectModal(${id})" class="text-gray-400 hover:text-gray-600">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <form method="POST" action="${url}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Rejection Notes</label>
                                                    <textarea name="notes" class="form-input" rows="3" placeholder="Enter reason for rejection..." required></textarea>
                                                </div>
                                                <div class="flex justify-end gap-3">
                                                    <button type="button" onclick="closeRejectModal(${id})" class="btn-secondary">Cancel</button>
                                                    <button type="submit" class="btn-danger">Reject Registration</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            `;

            // Append modal to body
            $('body').append(modalHtml);
        }

        function closeRejectModal(id) {
            $(`#rejectModal${id}`).remove();
        }
    </script>
@endpush