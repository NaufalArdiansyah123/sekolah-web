@extends('layouts.admin')

@section('title', 'Detail Tempat PKL')

<style>
    /* Clean White Theme Styling */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #ffffff;
        --bg-tertiary: #ffffff;
        --text-primary: #000000;
        --text-secondary: #000000;
        --border-color: #cccccc;
        --accent-color: #000000;
    }

    .page-container {
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .detail-container {
        background: var(--bg-primary);
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 0 auto;
        max-width: 1200px;
        border: 1px solid var(--border-color);
    }

    .detail-header {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        padding: 2rem;
        border-bottom: 1px solid var(--border-color);
    }

    .detail-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .detail-subtitle {
        font-size: 1.1rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }

    .header-actions {
        margin-top: 1.5rem;
        display: flex;
        gap: 1rem;
    }

    .btn-header {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-header:hover {
        background: var(--border-color);
        color: var(--text-primary);
    }

    .detail-body {
        padding: 2rem;
    }

    .info-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .info-section:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        background: var(--accent-color);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        background: var(--bg-tertiary);
        border-radius: 0.5rem;
        padding: 1.5rem;
        border-left: 4px solid var(--accent-color);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .info-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1.1rem;
        color: var(--text-primary);
        font-weight: 500;
        word-break: break-word;
    }

    .info-value.empty {
        color: var(--text-secondary);
        font-style: italic;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .detail-actions {
        background: var(--bg-tertiary);
        padding: 2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .btn-detail {
        padding: 0.75rem 2rem;
        border-radius: 0.375rem;
        font-weight: 600;
        border: 1px solid var(--border-color);
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary-detail {
        background: #000000;
        color: white;
    }

    .btn-primary-detail:hover {
        background: #333;
        color: white;
    }

    .btn-secondary-detail {
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }

    .btn-secondary-detail:hover {
        background: var(--border-color);
        color: var(--text-primary);
    }

    .btn-danger-detail {
        background: #dc3545;
        color: white;
    }

    .btn-danger-detail:hover {
        background: #b02a37;
        color: white;
    }

    .floating-actions {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 1000;
    }

    .floating-btn {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: none;
        color: white;
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .floating-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        color: white;
    }

    .floating-btn-primary {
        background: #000000;
    }

    .floating-btn-warning {
        background: #000000;
    }

    .floating-btn-danger {
        background: #dc3545;
    }

    .floating-btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--accent-color);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 0.5rem;
        width: 12px;
        height: 12px;
        background: var(--accent-color);
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .timeline-content {
        background: var(--bg-tertiary);
        border-radius: 0.5rem;
        padding: 1rem;
        border-left: 4px solid var(--accent-color);
    }

    .timeline-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .timeline-meta {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    @media (max-width: 768px) {
        .page-container {
            padding: 1rem;
        }

        .detail-header {
            padding: 1.5rem;
            text-align: center;
        }

        .detail-title {
            font-size: 2rem;
        }

        .header-actions {
            justify-content: center;
            flex-wrap: wrap;
        }

        .detail-body {
            padding: 1rem;
        }

        .info-section {
            padding: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .detail-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .floating-actions {
            display: none;
        }
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    .fade-in:nth-child(1) {
        animation-delay: 0.1s;
    }

    .fade-in:nth-child(2) {
        animation-delay: 0.2s;
    }

    .fade-in:nth-child(3) {
        animation-delay: 0.3s;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@section('content')
    <div class="page-container">
        <div class="detail-container">
            <!-- Detail Header -->
            <div class="detail-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="detail-title">
                            <i class="fas fa-building me-3"></i>{{ $tempatPkl->nama_tempat }}
                        </h1>
                        <p class="detail-subtitle">
                            Detail informasi tempat PKL
                        </p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('admin.tempat-pkl.index') }}" class="btn-header">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('admin.tempat-pkl.edit', $tempatPkl) }}" class="btn-header">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            <div class="detail-body">
                <!-- Basic Information Section -->
                <div class="info-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        Informasi Dasar
                    </h3>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Nama Tempat PKL</div>
                            <div class="info-value">{{ $tempatPkl->nama_tempat }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Kota/Kabupaten</div>
                            <div class="info-value">{{ $tempatPkl->kota ?? 'Belum ditentukan' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Kuota Siswa</div>
                            <div class="info-value">{{ $tempatPkl->kuota }} siswa</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Kuota Tersedia</div>
                            <div class="info-value">{{ $tempatPkl->getKuotaTersediaAttribute() }} siswa</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="status-badge status-active">
                                <i class="fas fa-check-circle"></i>
                                Aktif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Section -->
                <div class="info-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        Informasi Alamat & Lokasi
                    </h3>

                    <div class="info-grid">
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <div class="info-label">Alamat Lengkap</div>
                            <div class="info-value">{{ $tempatPkl->alamat }}</div>
                        </div>

                        @if($tempatPkl->latitude && $tempatPkl->longitude)
                            <div class="info-item">
                                <div class="info-label">Koordinat Lokasi</div>
                                <div class="info-value">
                                    {{ $tempatPkl->latitude }}, {{ $tempatPkl->longitude }}
                                    <br>
                                    <small class="text-muted">
                                        <a href="https://www.google.com/maps?q={{ $tempatPkl->latitude }},{{ $tempatPkl->longitude }}"
                                            target="_blank" class="text-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Lihat di Google Maps
                                        </a>
                                    </small>
                                </div>
                            </div>
                        @else
                            <div class="info-item">
                                <div class="info-label">Koordinat Lokasi</div>
                                <div class="info-value empty">Belum ditentukan</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Image Information Section -->
                @if($tempatPkl->gambar)
                    <div class="info-section fade-in">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-image"></i>
                            </div>
                            Gambar Tempat PKL
                        </h3>

                        <div class="info-grid">
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <div class="info-label">Gambar</div>
                                <div class="info-value">
                                    <img src="{{ asset($tempatPkl->gambar) }}" alt="Gambar Tempat PKL" class="img-fluid rounded"
                                        style="max-width: 400px; max-height: 300px;">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Contact Information Section -->
                <div class="info-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        Informasi Kontak
                    </h3>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Nomor Telepon</div>
                            <div class="info-value {{ $tempatPkl->kontak ? '' : 'empty' }}">
                                {{ $tempatPkl->kontak ?: 'Tidak ada informasi kontak' }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Pembimbing Lapangan</div>
                            <div class="info-value {{ $tempatPkl->pembimbing_lapangan ? '' : 'empty' }}">
                                {{ $tempatPkl->pembimbing_lapangan ?: 'Tidak ada pembimbing lapangan' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approved Students Section -->
                <div class="info-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        Siswa Yang Disetujui ({{ $tempatPkl->approvedRegistrations->count() }})
                    </h3>

                    @if($tempatPkl->approvedRegistrations->count() > 0)
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background: #f3f4f6; border-bottom: 2px solid #d1d5db;">
                                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">No</th>
                                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">NIS</th>
                                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Nama
                                            Siswa</th>
                                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Email
                                        </th>
                                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Kelas
                                        </th>
                                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Tanggal
                                            Mulai</th>
                                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: #374151;">Tanggal
                                            Selesai</th>
                                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: #374151;">
                                            Approved At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tempatPkl->approvedRegistrations as $index => $registration)
                                        <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.3s ease;"
                                            onmouseover="this.style.background='#f9fafb'"
                                            onmouseout="this.style.background='transparent'">
                                            <td style="padding: 1rem; color: #374151;">{{ $index + 1 }}</td>
                                            <td style="padding: 1rem; color: #374151; font-weight: 500;">
                                                {{ $registration->student->nis ?? '-' }}</td>
                                            <td style="padding: 1rem; color: #374151; font-weight: 500;">
                                                {{ $registration->student->name }}</td>
                                            <td style="padding: 1rem; color: #374151;">{{ $registration->student->email }}</td>
                                            <td style="padding: 1rem; color: #374151;">
                                                {{ $registration->student->studentData?->class->name ?? '-' }}</td>
                                            <td style="padding: 1rem; color: #374151;">
                                                {{ \Carbon\Carbon::parse($registration->tanggal_mulai)->format('d M Y') }}</td>
                                            <td style="padding: 1rem; color: #374151;">
                                                {{ \Carbon\Carbon::parse($registration->tanggal_selesai)->format('d M Y') }}</td>
                                            <td style="padding: 1rem; text-align: center; color: #374151; font-size: 0.875rem;">
                                                <span
                                                    style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 9999px; display: inline-block;">
                                                    {{ $registration->approved_at->format('d M Y H:i') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div
                            style="text-align: center; padding: 2rem; background: #f9fafb; border-radius: 0.5rem; color: #6b7280;">
                            <i class="fas fa-inbox" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                            <p style="margin: 0; font-size: 1.1rem;">Belum ada siswa yang disetujui untuk tempat PKL ini</p>
                        </div>
                    @endif
                </div>

                <!-- Timeline Section -->
                <div class="info-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        Riwayat & Timeline
                    </h3>

                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-title">Tempat PKL Dibuat</div>
                                <div class="timeline-meta">
                                    <i class="fas fa-calendar-plus me-1"></i>
                                    {{ $tempatPkl->created_at->format('d F Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        @if($tempatPkl->created_at != $tempatPkl->updated_at)
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-title">Terakhir Diupdate</div>
                                    <div class="timeline-meta">
                                        <i class="fas fa-edit me-1"></i>
                                        {{ $tempatPkl->updated_at->format('d F Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detail Actions -->
            <div class="detail-actions">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.tempat-pkl.index') }}" class="btn-detail btn-secondary-detail">
                        <i class="fas fa-arrow-left"></i>Kembali ke Daftar
                    </a>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.tempat-pkl.edit', $tempatPkl) }}" class="btn-detail btn-primary-detail">
                        <i class="fas fa-edit"></i>Edit Tempat PKL
                    </a>
                    <button type="button" class="btn-detail btn-danger-detail" onclick="confirmDelete()">
                        <i class="fas fa-trash"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <!-- <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">
                                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus tempat PKL <strong>"{{ $tempatPkl->nama_tempat }}"</strong>?</p>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan. Semua data terkait tempat PKL ini
                                        akan hilang.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </button>
                                    <form method="POST" action="{{ route('admin.tempat-pkl.destroy', $tempatPkl) }}"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>Hapus Tempat PKL
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> -->

    <!-- Floating Action Buttons -->
    <div class="floating-actions">
        <a href="{{ route('admin.tempat-pkl.edit', $tempatPkl) }}" class="floating-btn floating-btn-warning"
            title="Edit Tempat PKL">
            <i class="fas fa-edit"></i>
        </a>
        <button type="button" onclick="confirmDelete()" class="floating-btn floating-btn-danger" title="Hapus Tempat PKL">
            <i class="fas fa-trash"></i>
        </button>
        <a href="{{ route('admin.tempat-pkl.index') }}" class="floating-btn floating-btn-secondary"
            title="Kembali ke Daftar">
            <i class="fas fa-list"></i>
        </a>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete() {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Add fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    </script>
@endpush