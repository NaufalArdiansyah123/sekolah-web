@extends('layouts.admin')

@section('title', 'PKL Registrations')

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

        .table-row:hover {
            background-color: var(--bg-tertiary);
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
    </style>

    <div class="qr-container">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                        PKL Registrations
                    </h1>
                    <p class="text-sm mt-1" style="color: var(--text-secondary)">
                        Kelola pendaftaran PKL siswa
                    </p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="qr-card mb-6">
            <div class="qr-header">
                <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                    <i class="fas fa-filter mr-2"></i>Filter Data Pendaftaran
                </h3>
            </div>
            <div class="p-4">
                <form method="GET" action="{{ route('admin.pkl-registrations.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium mb-2"
                                style="color: var(--text-secondary)">Status</label>
                            <select name="status" class="form-input">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Cari Siswa
                                atau Tempat PKL</label>
                            <input type="text" name="search" class="form-input" placeholder="Nama siswa atau tempat PKL"
                                value="{{ request('search') }}">
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-search mr-2"></i>Cari
                            </button>
                            <a href="{{ route('admin.pkl-registrations.index') }}" class="btn-secondary">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Registrations Table -->
        <div class="qr-card">
            <div class="qr-header">
                <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                    <i class="fas fa-table mr-2"></i>Data Pendaftaran PKL
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-color)">
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">SISWA
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">TEMPAT
                                PKL</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">STATUS
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">TANGGAL
                                MULAI</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">TANGGAL
                                SELESAI</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">APPLIED
                                AT</th>
                            <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">AKSI
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pklRegistrations as $registration)
                            <tr class="table-row" style="border-bottom: 1px solid var(--border-color)">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <div class="text-sm font-medium" style="color: var(--text-primary)">
                                                {{ $registration->student->name }}
                                            </div>
                                            <div class="text-xs" style="color: var(--text-secondary)">
                                                {{ $registration->student->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium" style="color: var(--text-primary)">
                                        {{ $registration->tempatPkl->nama_tempat }}
                                    </div>
                                    <div class="text-xs" style="color: var(--text-secondary)">
                                        {{ $registration->tempatPkl->alamat }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($registration->status == 'pending')
                                        <span class="status-badge"
                                            style="background-color: var(--bg-tertiary); color: var(--text-primary)">Pending</span>
                                    @elseif($registration->status == 'approved')
                                        <span class="status-badge" style="background-color: #d4edda; color: #155724">Approved</span>
                                    @elseif($registration->status == 'rejected')
                                        <span class="status-badge" style="background-color: #f8d7da; color: #721c24">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">
                                    {{ $registration->tanggal_mulai ? \Carbon\Carbon::parse($registration->tanggal_mulai)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">
                                    {{ $registration->tanggal_selesai ? \Carbon\Carbon::parse($registration->tanggal_selesai)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">
                                    {{ $registration->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.pkl-registrations.show', $registration) }}"
                                            class="btn-secondary !py-1 !px-2" title="View">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                        @if($registration->isPending())
                                            <form method="POST"
                                                action="{{ route('admin.pkl-registrations.approve', $registration) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-primary !py-1 !px-2" title="Approve"
                                                    onclick="return confirm('Are you sure you want to approve this registration?')">
                                                    <i class="fas fa-check text-xs"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn-danger !py-1 !px-2"
                                                onclick="openRejectModal({{ $registration->id }}, '{{ route('admin.pkl-registrations.reject', $registration) }}')"
                                                title="Reject">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>


                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <i class="fas fa-users text-3xl mb-3"
                                        style="color: var(--text-secondary); opacity: 0.5"></i>
                                    <p class="text-sm" style="color: var(--text-secondary)">Tidak ada data pendaftaran PKL</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pklRegistrations->hasPages())
                <div class="p-4 border-t" style="border-color: var(--border-color)">
                    {{ $pklRegistrations->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
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
