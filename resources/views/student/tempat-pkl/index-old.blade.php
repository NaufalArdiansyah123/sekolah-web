@extends('layouts.student')

@section('title', 'Tempat PKL')

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

        .pkl-container {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 1.5rem;
        }

        .pkl-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            color: var(--text-primary);
        }

        .pkl-header {
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

        .btn-success {
            background-color: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #28a745;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-disabled {
            background-color: var(--bg-tertiary);
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: not-allowed;
            opacity: 0.6;
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
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }



        .pkl-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .pkl-item {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
            transition: all 0.2s;
        }

        .pkl-item:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .pkl-image {
            height: 180px;
            overflow: hidden;
            background-color: var(--bg-tertiary);
        }

        .pkl-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-content {
            background-color: var(--bg-primary);
            border-radius: 0.5rem;
            max-width: 42rem;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: between;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }
    </style>

    <div class="pkl-container">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    @if(isset($existingRegistration))
                        <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                            Status Pendaftaran PKL
                        </h1>
                        <p class="text-sm mt-1" style="color: var(--text-secondary)">
                            Lihat status pendaftaran PKL Anda dan pantau perkembangan pengajuan
                        </p>
                    @else
                        <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                            Tempat PKL
                        </h1>
                        <p class="text-sm mt-1" style="color: var(--text-secondary)">
                            Jelajahi pilihan tempat praktik kerja lapangan
                        </p>
                    @endif
                </div>
                @if(!isset($existingRegistration))
                    <div class="flex gap-4">
                        <div class="text-center">
                            <div class="text-xl font-bold" style="color: var(--text-primary)">
                                {{ \App\Models\TempatPkl::count() }}
                            </div>
                            <div class="text-xs" style="color: var(--text-secondary)">Tempat PKL</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold" style="color: var(--text-primary)">
                                {{ \App\Models\TempatPkl::get()->filter(function($item) { return $item->kuota_tersedia > 0; })->count() }}
                            </div>
                            <div class="text-xs" style="color: var(--text-secondary)">Kuota Tersedia</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if(isset($existingRegistration) && $existingRegistration->isRejected())
            <!-- Rejection Page -->
            <div class="pkl-card mb-6" style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%)">
                <div class="p-12 text-center">
                    <!-- Icon -->
                    <div class="mb-6">
                        <i class="fas fa-exclamation-circle text-6xl" style="color: #dc3545"></i>
                    </div>

                    <!-- Title -->
                    <h2 class="text-3xl font-bold mb-3" style="color: #721c24">
                        Pendaftaran Anda Ditolak
                    </h2>

                    <!-- Rejection Reason -->
                    <div class="bg-white rounded-lg p-6 mb-6 max-w-2xl mx-auto">
                        <p class="text-sm font-semibold mb-2" style="color: var(--text-secondary)">
                            <i class="fas fa-quote-left mr-2"></i>Alasan Penolakan:
                        </p>
                        <p class="text-lg" style="color: #721c24">
                            <strong>{{ $existingRegistration->alasan ?? 'Tidak ada alasan yang diberikan' }}</strong>
                        </p>
                    </div>

                    <!-- Admin Notes (if any) -->
                    @if($existingRegistration->notes)
                        <div class="bg-white rounded-lg p-6 mb-6 max-w-2xl mx-auto">
                            <p class="text-sm font-semibold mb-2" style="color: var(--text-secondary)">
                                <i class="fas fa-sticky-note mr-2"></i>Catatan Admin:
                            </p>
                            <p style="color: var(--text-primary)">
                                {{ $existingRegistration->notes }}
                            </p>
                        </div>
                    @endif

                    <!-- Action Button -->
                    <div class="mt-8">
                        <p class="text-sm mb-4" style="color: #721c24">
                            Silakan perbaiki data Anda dan ajukan ulang pendaftaran PKL.
                        </p>
                        <a href="{{ route('student.tempat-pkl.index') }}?reset=true"
                            class="inline-flex items-center gap-2 px-8 py-3 rounded-lg font-medium text-white transition"
                            style="background-color: #dc3545; hover:background-color: #c82333;">
                            <i class="fas fa-redo"></i>
                            <span>Ajukan Ulang Pendaftaran</span>
                        </a>
                    </div>

                    <!-- Dashboard Link -->
                    <div class="mt-6">
                        <a href="{{ route('student.dashboard') }}"
                            class="text-sm" style="color: #721c24">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        @elseif(isset($existingRegistration))
            <!-- Status Pendaftaran Section -->
            <div class="pkl-card mb-6">
                <div class="pkl-header">
                    <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                        <i class="fas fa-clipboard-check mr-2"></i>Status Pendaftaran PKL
                    </h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Status Card -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-semibold" style="color: var(--text-secondary)">Status:</span>
                                @if($existingRegistration->isPending())
                                    <span class="status-badge" style="background-color: #fff3cd; color: #856404">
                                        <i class="fas fa-clock"></i>
                                        Menunggu Persetujuan
                                    </span>
                                @elseif($existingRegistration->isApproved())
                                    <span class="status-badge" style="background-color: #d4edda; color: #155724">
                                        <i class="fas fa-check-circle"></i>
                                        Disetujui
                                    </span>
                                @elseif($existingRegistration->isRejected())
                                    <span class="status-badge" style="background-color: #f8d7da; color: #721c24">
                                        <i class="fas fa-times-circle"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-building mt-1" style="color: var(--text-secondary)"></i>
                                    <div>
                                        <p class="text-sm font-semibold" style="color: var(--text-secondary)">Tempat PKL</p>
                                        <p class="font-medium" style="color: var(--text-primary)">{{ $existingRegistration->tempatPkl->nama_tempat }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <i class="fas fa-calendar mt-1" style="color: var(--text-secondary)"></i>
                                    <div>
                                        <p class="text-sm font-semibold" style="color: var(--text-secondary)">Periode PKL</p>
                                        <p style="color: var(--text-primary)">
                                            {{ \Carbon\Carbon::parse($existingRegistration->tanggal_mulai)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($existingRegistration->tanggal_selesai)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>

                                @if($existingRegistration->approved_at)
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-check mt-1" style="color: #28a745"></i>
                                        <div>
                                            <p class="text-sm font-semibold" style="color: var(--text-secondary)">Disetujui Pada</p>
                                            <p style="color: var(--text-primary)">{{ \Carbon\Carbon::parse($existingRegistration->approved_at)->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($existingRegistration->rejected_at)
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-times mt-1" style="color: #dc3545"></i>
                                        <div>
                                            <p class="text-sm font-semibold" style="color: var(--text-secondary)">Ditolak Pada</p>
                                            <p style="color: var(--text-primary)">{{ \Carbon\Carbon::parse($existingRegistration->rejected_at)->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Details Card -->
                        <div class="space-y-4">
                            @if($existingRegistration->alasan)
                                <div>
                                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary)">
                                        <i class="fas fa-comment-dots mr-2"></i>Alasan
                                    </label>
                                    <p class="text-sm p-3 rounded" style="color: var(--text-primary); background-color: var(--bg-tertiary)">
                                        {{ $existingRegistration->alasan }}
                                    </p>
                                </div>
                            @endif

                            @if($existingRegistration->notes)
                                <div>
                                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary)">
                                        <i class="fas fa-sticky-note mr-2"></i>Catatan Admin
                                    </label>
                                    <p class="text-sm p-3 rounded" style="color: var(--text-primary); background-color: var(--bg-tertiary)">
                                        {{ $existingRegistration->notes }}
                                    </p>
                                </div>
                            @endif

                            @if($existingRegistration->surat_pengantar)
                                <div>
                                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary)">
                                        <i class="fas fa-file-pdf mr-2"></i>Surat Pengantar
                                    </label>
                                    <a href="{{ asset('storage/' . $existingRegistration->surat_pengantar) }}"
                                        target="_blank"
                                        class="btn-primary inline-flex items-center gap-2">
                                        <i class="fas fa-download"></i>
                                        <span>Lihat Surat</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($existingRegistration->isRejected())
                        <div class="mt-6 pt-6" style="border-top: 1px solid var(--border-color)">
                            <div class="p-4 rounded" style="background-color: #fff3cd; border: 1px solid #ffc107">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-exclamation-triangle mt-0.5" style="color: #856404"></i>
                                    <div>
                                        <h4 class="text-lg font-semibold mb-2" style="color: #856404">Pendaftaran Ditolak</h4>
                                        <p class="text-sm mb-4" style="color: #856404">
                                            Pendaftaran PKL Anda telah ditolak. Anda dapat mengajukan ulang dengan data yang telah diperbaiki.
                                        </p>
                                        <a href="{{ route('student.tempat-pkl.index') }}?reset=true"
                                            class="btn-primary inline-flex items-center gap-2">
                                            <i class="fas fa-redo"></i>
                                            <span>Ajukan Ulang</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($existingRegistration->isPending() || $existingRegistration->isApproved())
                        <div class="mt-6 pt-6" style="border-top: 1px solid var(--border-color)">
                            <div class="p-4 rounded text-center" style="background-color: var(--bg-tertiary); border: 1px solid var(--border-color)">
                                <i class="fas fa-info-circle text-3xl mb-3" style="color: var(--text-secondary)"></i>
                                <h4 class="text-lg font-semibold mb-2" style="color: var(--text-primary)">
                                    @if($existingRegistration->isPending())
                                        Menunggu Konfirmasi
                                    @else
                                        Pendaftaran Disetujui
                                    @endif
                                </h4>
                                <p class="text-sm" style="color: var(--text-secondary)">
                                    @if($existingRegistration->isPending())
                                        Pendaftaran PKL Anda sedang dalam proses review. Harap menunggu konfirmasi dari admin.
                                    @else
                                        Selamat! Pendaftaran PKL Anda telah disetujui. Silakan hubungi tempat PKL untuk informasi lebih lanjut.
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if(!isset($existingRegistration) || ($existingRegistration && $existingRegistration->isRejected() && request()->has('reset')))
            <!-- Search Section -->
            <div class="pkl-card mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('student.tempat-pkl.index') }}">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-1">
                                <input type="text" name="search"
                                    class="form-input"
                                    placeholder="Cari nama perusahaan, alamat, atau pembimbing..." value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-search mr-2"></i>
                                <span>Cari</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Grid -->
            <div class="pkl-grid">
                @forelse($tempatPkls as $tempatPkl)
                    <div class="pkl-item">
                        <!-- Image -->
                        @if($tempatPkl->gambar)
                            <div class="pkl-image">
                                <img src="{{ asset($tempatPkl->gambar) }}"
                                    alt="{{ $tempatPkl->nama_tempat }}"
                                    onerror="this.parentElement.innerHTML='<div class=\'pkl-image flex items-center justify-center\'><i class=\'fas fa-building text-5xl\' style=\'color: var(--text-secondary); opacity: 0.5\'></i></div>'">
                            </div>
                        @else
                            <div class="pkl-image flex items-center justify-center">
                                <i class="fas fa-building text-5xl" style="color: var(--text-secondary); opacity: 0.5"></i>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-4">
                            <h5 class="text-lg font-bold mb-3" style="color: var(--text-primary)">
                                {{ $tempatPkl->nama_tempat }}
                            </h5>

                            <div class="space-y-2 text-sm">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-map-marker-alt mt-1 flex-shrink-0" style="color: var(--text-secondary)"></i>
                                    <span style="color: var(--text-secondary)">
                                        {{ $tempatPkl->alamat }}
                                    </span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-user-tie mt-1 flex-shrink-0" style="color: var(--text-secondary)"></i>
                                    <span style="color: var(--text-secondary)">
                                        {{ $tempatPkl->pembimbing_lapangan }}
                                    </span>
                                </div>
                                @if($tempatPkl->kontak)
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-phone mt-1 flex-shrink-0" style="color: var(--text-secondary)"></i>
                                        <span style="color: var(--text-secondary)">
                                            {{ $tempatPkl->kontak }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-4 py-3 flex items-center justify-between gap-4" style="background-color: var(--bg-tertiary); border-top: 1px solid var(--border-color)">
                            @if($tempatPkl->kuota_tersedia > 0)
                                <span class="status-badge" style="background-color: #d4edda; color: #155724">
                                    <i class="fas fa-users"></i>
                                    {{ $tempatPkl->kuota_tersedia }} / {{ $tempatPkl->kuota }} Kuota
                                </span>
                            @else
                                <span class="status-badge" style="background-color: #f8d7da; color: #721c24">
                                    <i class="fas fa-users"></i>
                                    Penuh
                                </span>
                            @endif

                            <div class="flex gap-2">
                                <a href="{{ route('student.tempat-pkl.show', $tempatPkl) }}"
                                    class="btn-secondary">
                                    <i class="fas fa-eye mr-1"></i>
                                    <span>Detail</span>
                                </a>

                                @if($tempatPkl->kuota_tersedia > 0)
                                    <button onclick="openDaftarModal({{ $tempatPkl->id }}, '{{ addslashes($tempatPkl->nama_tempat) }}')"
                                        class="btn-success">
                                        <i class="fas fa-paper-plane mr-1"></i>
                                        <span>Daftar</span>
                                    </button>
                                @else
                                    <button disabled class="btn-disabled">
                                        <i class="fas fa-ban mr-1"></i>
                                        <span>Penuh</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="pkl-card p-12 text-center">
                            <i class="fas fa-search text-5xl mb-4" style="color: var(--text-secondary); opacity: 0.5"></i>
                            <h4 class="text-xl font-bold mb-3" style="color: var(--text-primary)">Tidak Ada Hasil</h4>
                            <p class="text-sm mb-6" style="color: var(--text-secondary)">
                                Maaf, tidak ada tempat PKL yang sesuai dengan pencarian Anda
                            </p>
                            @if(request('search'))
                                <a href="{{ route('student.tempat-pkl.index') }}" class="btn-secondary">
                                    <i class="fas fa-redo mr-2"></i>
                                    <span>Reset Pencarian</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($tempatPkls->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $tempatPkls->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Unified Notification Modal -->
    <div id="notificationModal" class="modal-overlay" style="display: none;">
        <div class="modal-content" style="max-width: 24rem; padding: 2rem; text-align: center;">
            <!-- Icon Container -->
            <div id="notificationIcon" class="mb-4" style="font-size: 3rem; height: 3rem; line-height: 3rem;"></div>
            
            <!-- Title -->
            <h2 id="notificationTitle" class="text-xl font-bold mb-2" style="color: var(--text-primary);"></h2>
            
            <!-- Message -->
            <p id="notificationMessage" class="mb-6" style="color: var(--text-secondary); line-height: 1.6;"></p>
            
            <!-- Close Button -->
            <button onclick="closeNotificationModal()" id="notificationButton" class="btn-primary" style="width: 100%; padding: 0.75rem;">
                Tutup
            </button>
        </div>
    </div>

    <!-- Modal Pendaftaran PKL -->
    <div id="daftarModal" class="hidden modal-overlay" style="display: none;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="flex items-center gap-3 flex-1">
                    <i class="fas fa-file-signature text-xl" style="color: var(--text-primary)"></i>
                    <div>
                        <h3 class="text-lg font-bold" style="color: var(--text-primary)">Pendaftaran PKL</h3>
                        <p class="text-xs" style="color: var(--text-secondary)">Lengkapi formulir di bawah ini</p>
                    </div>
                </div>
                <button type="button" onclick="closeDaftarModal()" class="btn-secondary p-2" style="min-width: 2.5rem;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('student.pengajuan-pkl.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body space-y-4">
                    <!-- Tempat PKL Info -->
                    <div class="p-4 rounded" style="background-color: var(--bg-tertiary); border: 1px solid var(--border-color)">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-building" style="color: var(--text-secondary)"></i>
                            <label class="text-sm font-semibold" style="color: var(--text-secondary)">Tempat PKL yang Dipilih</label>
                        </div>
                        <p id="selectedTempatName" class="text-lg font-bold" style="color: var(--text-primary)"></p>
                        <input type="hidden" name="tempat_pkl_id" id="tempatPklId">
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary)">
                            <i class="fas fa-calendar-start mr-2" style="color: var(--text-secondary)"></i>Tanggal Mulai PKL
                            <span style="color: #dc3545">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" required min="{{ date('Y-m-d') }}"
                            value="{{ old('tanggal_mulai') }}" class="form-input">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary)">
                            <i class="fas fa-calendar-check mr-2" style="color: var(--text-secondary)"></i>Tanggal Selesai PKL
                            <span style="color: #dc3545">*</span>
                        </label>
                        <input type="date" name="tanggal_selesai" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            value="{{ old('tanggal_selesai') }}" class="form-input">
                    </div>

                    <!-- Alasan -->
                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary)">
                            <i class="fas fa-comment-dots mr-2" style="color: var(--text-secondary)"></i>Alasan Memilih Tempat PKL Ini
                            <span style="color: #dc3545">*</span>
                        </label>
                        <textarea name="alasan" rows="4" required minlength="50" maxlength="1000"
                            placeholder="Jelaskan alasan Anda memilih tempat PKL ini (minimal 50 karakter)..."
                            class="form-input resize-none">{{ old('alasan') }}</textarea>
                        <p class="mt-1 text-xs" style="color: var(--text-secondary)">
                            <i class="fas fa-info-circle mr-1"></i>Minimal 50 karakter, maksimal 1000 karakter
                        </p>
                    </div>

                    <!-- Surat Pengantar -->
                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary)">
                            <i class="fas fa-file-upload mr-2" style="color: var(--text-secondary)"></i>Surat Pengantar (PDF)
                            <span style="color: #dc3545">*</span>
                        </label>
                        <input type="file" name="surat_pengantar" accept=".pdf" required onchange="updateFileName(this)"
                            class="form-input">
                        <p class="mt-2 text-xs" style="color: var(--text-secondary)">
                            <i class="fas fa-info-circle mr-1"></i>Format: PDF, Maksimal 2MB
                        </p>
                    </div>

                    <!-- Catatan Tambahan -->
                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary)">
                            <i class="fas fa-sticky-note mr-2" style="color: var(--text-secondary)"></i>Catatan Tambahan (Opsional)
                        </label>
                        <textarea name="catatan" rows="3" maxlength="500"
                            placeholder="Tambahkan catatan atau informasi tambahan jika diperlukan..."
                            class="form-input resize-none">{{ old('catatan') }}</textarea>
                        <p class="mt-1 text-xs" style="color: var(--text-secondary)">
                            <i class="fas fa-info-circle mr-1"></i>Maksimal 500 karakter
                        </p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" onclick="closeDaftarModal()" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>
                        <span>Batal</span>
                    </button>
                    <button type="submit" class="btn-success">
                        <i class="fas fa-paper-plane mr-2"></i>
                        <span>Kirim Pendaftaran</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDaftarModal(tempatPklId, namaTempat) {
            const modal = document.getElementById('daftarModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.getElementById('tempatPklId').value = tempatPklId;
            document.getElementById('selectedTempatName').textContent = namaTempat;
            document.body.style.overflow = 'hidden';
        }

        function closeDaftarModal() {
            const modal = document.getElementById('daftarModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function openSuccessModal(message) {
            showNotification('success', 'Berhasil!', message);
        }

        function closeSuccessModal() {
            closeNotificationModal();
        }

        function openErrorModal(message) {
            showNotification('error', 'Gagal!', message);
        }

        function closeErrorModal() {
            closeNotificationModal();
        }

        function showNotification(type, title, message) {
            const modal = document.getElementById('notificationModal');
            const iconEl = document.getElementById('notificationIcon');
            const titleEl = document.getElementById('notificationTitle');
            const messageEl = document.getElementById('notificationMessage');
            const buttonEl = document.getElementById('notificationButton');

            titleEl.textContent = title;
            messageEl.textContent = message;

            if (type === 'success') {
                iconEl.innerHTML = '<i class="fas fa-check-circle" style="color: #10b981;"></i>';
                buttonEl.style.backgroundColor = '#10b981';
                buttonEl.style.borderColor = '#10b981';
            } else if (type === 'error') {
                iconEl.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #ef4444;"></i>';
                buttonEl.style.backgroundColor = '#ef4444';
                buttonEl.style.borderColor = '#ef4444';
            } else {
                iconEl.innerHTML = '<i class="fas fa-info-circle" style="color: #3b82f6;"></i>';
                buttonEl.style.backgroundColor = '#3b82f6';
                buttonEl.style.borderColor = '#3b82f6';
            }

            modal.style.display = 'flex';
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeNotificationModal() {
            const modal = document.getElementById('notificationModal');
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Show modals on page load if there are success or error messages
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                openSuccessModal('{{ session('success') }}');
            @endif

            @if(session('error'))
                openErrorModal('{{ session('error') }}');
            @endif
        });

        function updateFileName(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileSize = file.size / 1024 / 1024; // Convert to MB

                if (fileSize > 2) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB');
                    input.value = '';
                    return;
                }

                console.log('File selected:', file.name);
            }
        }

        // Close modal when clicking outside
        document.getElementById('daftarModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeDaftarModal();
            }
        });

        document.getElementById('notificationModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeNotificationModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDaftarModal();
                closeNotificationModal();
            }
        });

        // Update tanggal_selesai min date when tanggal_mulai changes
        document.querySelector('input[name="tanggal_mulai"]')?.addEventListener('change', function () {
            const tanggalSelesai = document.querySelector('input[name="tanggal_selesai"]');
            if (this.value) {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                tanggalSelesai.min = nextDay.toISOString().split('T')[0];
            }
        });
    </script>
@endsection