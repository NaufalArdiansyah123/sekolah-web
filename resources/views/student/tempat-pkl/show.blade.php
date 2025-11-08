@extends('layouts.student')

@section('title', 'Detail Tempat PKL')

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

        .detail-container {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 1.5rem;
        }

        .detail-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            color: var(--text-primary);
        }

        .detail-header {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            border: 1px solid var(--accent-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            filter: brightness(1.1);
        }

        .info-item {
            display: flex;
            align-items: start;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 3rem;
            height: 3rem;
            background-color: var(--bg-tertiary);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid var(--border-color);
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            text-transform: uppercase;
        }

        .image-container {
            height: 24rem;
            overflow: hidden;
            background-color: var(--bg-tertiary);
            border-radius: 0.5rem;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placeholder-image {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
    </style>

    <div class="detail-container">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                        Detail Tempat PKL
                    </h1>
                    <p class="text-sm mt-1" style="color: var(--text-secondary)">
                        Informasi lengkap tentang tempat praktik kerja lapangan
                    </p>
                </div>
                <a href="{{ route('student.tempat-pkl.index') }}" class="btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm" style="color: var(--text-secondary)">
                <a href="{{ route('student.dashboard') }}" class="hover:underline" style="color: var(--text-secondary)">
                    <i class="fas fa-home mr-1"></i>Dashboard
                </a>
                <span>›</span>
                <a href="{{ route('student.tempat-pkl.index') }}" class="hover:underline"
                    style="color: var(--text-secondary)">
                    <i class="fas fa-building mr-1"></i>Tempat PKL
                </a>
                <span>›</span>
                <span style="color: var(--text-primary); font-weight: 500">Detail</span>
            </nav>
        </div>

        <!-- Detail Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Information Card -->
            <div class="detail-card">
                <div class="detail-header">
                    <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Tempat PKL
                    </h3>
                </div>

                <div>
                    <!-- Nama Tempat -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-building" style="color: var(--text-secondary)"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Nama Tempat</div>
                            <div class="info-value">{{ $tempatPkl->nama_tempat }}</div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt" style="color: var(--text-secondary)"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Alamat</div>
                            <div class="info-value">{{ $tempatPkl->alamat }}</div>
                        </div>
                    </div>

                    <!-- Pembimbing Lapangan -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-user-tie" style="color: var(--text-secondary)"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Pembimbing Lapangan</div>
                            <div class="info-value">{{ $tempatPkl->pembimbing_lapangan }}</div>
                        </div>
                    </div>

                    <!-- Kuota -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-users" style="color: var(--text-secondary)"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Kuota Tersedia</div>
                            <div>
                                @if($tempatPkl->kuota_tersedia > 0)
                                    <span class="status-badge" style="background-color: #d4edda; color: #155724">
                                        <i class="fas fa-check-circle"></i>
                                        {{ $tempatPkl->kuota_tersedia }} / {{ $tempatPkl->kuota }} Tersedia
                                    </span>
                                @else
                                    <span class="status-badge" style="background-color: #f8d7da; color: #721c24">
                                        <i class="fas fa-times-circle"></i>
                                        Penuh
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($tempatPkl->deskripsi)
                        <!-- Deskripsi -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-file-alt" style="color: var(--text-secondary)"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Deskripsi</div>
                                <div class="info-value">{{ $tempatPkl->deskripsi }}</div>
                            </div>
                        </div>
                    @endif

                    @if($tempatPkl->kontak)
                        <!-- Kontak -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-phone" style="color: var(--text-secondary)"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Kontak</div>
                                <div class="info-value">{{ $tempatPkl->kontak }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Image Card -->
            <div class="detail-card">
                <div class="detail-header">
                    <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                        <i class="fas fa-image mr-2"></i>Gambar Tempat
                    </h3>
                </div>

                <div class="p-6">
                    @if($tempatPkl->gambar)
                        <div class="image-container">
                            <img src="{{ asset($tempatPkl->gambar) }}" alt="{{ $tempatPkl->nama_tempat }}"
                                onerror="this.parentElement.innerHTML='<div class=\'placeholder-image\'><i class=\'fas fa-building text-6xl\' style=\'color: var(--text-secondary); opacity: 0.5\'></i><h6 class=\'text-lg font-bold\' style=\'color: var(--text-primary)\'>Gambar Tidak Tersedia</h6><p class=\'text-sm\' style=\'color: var(--text-secondary)\'>Gagal memuat gambar</p></div>'">
                        </div>
                    @else
                        <div class="image-container">
                            <div class="placeholder-image">
                                <i class="fas fa-building text-6xl" style="color: var(--text-secondary); opacity: 0.5"></i>
                                <h6 class="text-lg font-bold" style="color: var(--text-primary)">Tidak Ada Gambar</h6>
                                <p class="text-sm" style="color: var(--text-secondary)">Gambar tempat PKL belum tersedia</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Approved Students Card -->
            <div class="detail-card">
                <div class="detail-header">
                    <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                        <i class="fas fa-users mr-2"></i>Siswa Yang Disetujui
                        ({{ $tempatPkl->approvedRegistrations->count() }})
                    </h3>
                </div>

                <div class="p-6">
                    @if($tempatPkl->approvedRegistrations->count() > 0)
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                                <thead>
                                    <tr style="background: var(--bg-tertiary); border-bottom: 2px solid var(--border-color);">
                                        <th
                                            style="padding: 0.75rem; text-align: left; font-weight: 600; color: var(--text-primary);">
                                            No</th>
                                        <th
                                            style="padding: 0.75rem; text-align: left; font-weight: 600; color: var(--text-primary);">
                                            NIS</th>
                                        <th
                                            style="padding: 0.75rem; text-align: left; font-weight: 600; color: var(--text-primary);">
                                            Nama Siswa</th>
                                        <th
                                            style="padding: 0.75rem; text-align: left; font-weight: 600; color: var(--text-primary);">
                                            Kelas</th>
                                        <th
                                            style="padding: 0.75rem; text-align: center; font-weight: 600; color: var(--text-primary);">
                                            Tanggal Mulai</th>
                                        <th
                                            style="padding: 0.75rem; text-align: center; font-weight: 600; color: var(--text-primary);">
                                            Tanggal Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tempatPkl->approvedRegistrations as $index => $registration)
                                        <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.3s ease;"
                                            onmouseover="this.style.background='var(--bg-tertiary)'"
                                            onmouseout="this.style.background='transparent'">
                                            <td style="padding: 0.75rem; color: var(--text-primary);">{{ $index + 1 }}</td>
                                            <td style="padding: 0.75rem; color: var(--text-primary); font-weight: 500;">
                                                {{ $registration->student->nis ?? '-' }}</td>
                                            <td style="padding: 0.75rem; color: var(--text-primary); font-weight: 500;">
                                                {{ $registration->student->name }}</td>
                                            <td style="padding: 0.75rem; color: var(--text-primary);">
                                                {{ $registration->student->studentData?->class->name ?? '-' }}</td>
                                            <td style="padding: 0.75rem; text-align: center; color: var(--text-primary);">
                                                {{ \Carbon\Carbon::parse($registration->tanggal_mulai)->format('d M Y') }}</td>
                                            <td style="padding: 0.75rem; text-align: center; color: var(--text-primary);">
                                                {{ \Carbon\Carbon::parse($registration->tanggal_selesai)->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                            <i class="fas fa-inbox"
                                style="font-size: 2rem; opacity: 0.5; display: block; margin-bottom: 0.5rem;"></i>
                            <p style="margin: 0;">Belum ada siswa yang disetujui untuk tempat PKL ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('student.tempat-pkl.index') }}" class="btn-primary">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Daftar Tempat PKL</span>
            </a>
        </div>
    </div>
@endsection