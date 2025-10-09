@extends('layouts.admin')

@section('title', 'Detail Siswa - ' . $student->name)

@push('styles')
<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --secondary-color: #8b5cf6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --light-bg: #f8fafc;
        --white: #ffffff;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    .dark {
        --light-bg: #1f2937;
        --white: #374151;
        --gray-50: #374151;
        --gray-100: #4b5563;
        --gray-200: #6b7280;
        --gray-300: #9ca3af;
        --gray-400: #d1d5db;
        --gray-500: #e5e7eb;
        --gray-600: #f3f4f6;
        --gray-700: #f9fafb;
        --gray-800: #ffffff;
        --gray-900: #ffffff;
    }

    .page-container {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .detail-container {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        margin: 0 auto;
        max-width: 1400px;
    }

    .detail-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .detail-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .detail-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .detail-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }

    .header-actions {
        position: relative;
        z-index: 3;
        margin-top: 1.5rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-header {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
    }

    .profile-section {
        background: var(--gray-50);
        padding: 2rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .student-photo {
        width: 200px;
        height: 200px;
        border-radius: 20px;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
    }

    .student-photo:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-xl);
    }

    .student-initials {
        width: 200px;
        height: 200px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 800;
        border: 4px solid white;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
    }

    .student-initials:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-xl);
    }

    .status-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 3px solid white;
        box-shadow: var(--shadow);
    }

    .status-active {
        background: linear-gradient(135deg, var(--success-color), #059669);
        color: white;
    }

    .status-inactive {
        background: linear-gradient(135deg, var(--warning-color), #d97706);
        color: white;
    }

    .status-graduated {
        background: linear-gradient(135deg, var(--gray-500), var(--gray-600));
        color: white;
    }

    .student-name {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
        margin-top: 1rem;
    }

    .student-class {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .student-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        margin-top: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    .meta-icon {
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .age-badge {
        background: #eff6ff;
        color: #1e40af;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    .dark .age-badge {
        background: #1e3a8a;
        color: #bfdbfe;
    }

    .content-section {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--gray-200);
        transition: all 0.2s ease;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item:hover {
        background: var(--gray-50);
        margin: 0 -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 8px;
    }

    .info-label {
        font-weight: 600;
        color: var(--gray-600);
        min-width: 140px;
        font-size: 0.875rem;
    }

    .info-value {
        color: var(--gray-800);
        font-weight: 500;
        flex: 1;
    }

    .info-value.empty {
        color: var(--gray-400);
        font-style: italic;
    }

    .contact-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .contact-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .qr-section {
        background: var(--white);
        border: 2px solid var(--gray-200);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .qr-section:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .qr-code-container {
        background: white;
        padding: 1rem;
        border-radius: 12px;
        display: inline-block;
        box-shadow: var(--shadow);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .qr-code-container:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-lg);
    }

    .qr-code-image {
        max-width: 200px;
        height: auto;
        border-radius: 8px;
    }

    .qr-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .btn-qr {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .btn-qr-download {
        background: var(--success-color);
        color: white;
    }

    .btn-qr-download:hover {
        background: #059669;
        color: white;
        transform: translateY(-2px);
    }

    .btn-qr-regenerate {
        background: var(--warning-color);
        color: white;
    }

    .btn-qr-regenerate:hover {
        background: #d97706;
        color: white;
        transform: translateY(-2px);
    }

    .btn-qr-manage {
        background: var(--info-color);
        color: white;
    }

    .btn-qr-manage:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-2px);
    }

    .qr-info {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
        font-size: 0.875rem;
        color: #1e40af;
    }

    .dark .qr-info {
        background: #1e3a8a;
        border-color: #3730a3;
        color: #bfdbfe;
    }

    .no-qr-message {
        background: #fef3c7;
        border: 1px solid #fde68a;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        color: #92400e;
    }

    .dark .no-qr-message {
        background: #78350f;
        border-color: #92400e;
        color: #fde68a;
    }

    .btn-generate-qr {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-generate-qr:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--secondary-color));
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
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
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .floating-btn:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-xl);
        color: white;
    }

    .floating-btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    .floating-btn-success {
        background: linear-gradient(135deg, var(--success-color), #059669);
    }

    .floating-btn-warning {
        background: linear-gradient(135deg, var(--warning-color), #d97706);
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
        }

        .profile-section {
            text-align: center;
        }

        .student-photo,
        .student-initials {
            width: 150px;
            height: 150px;
        }

        .student-initials {
            font-size: 3rem;
        }

        .student-name {
            font-size: 2rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .info-label {
            min-width: auto;
        }

        .qr-code-image {
            max-width: 150px;
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

    .fade-in:nth-child(1) { animation-delay: 0.1s; }
    .fade-in:nth-child(2) { animation-delay: 0.2s; }
    .fade-in:nth-child(3) { animation-delay: 0.3s; }
    .fade-in:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="detail-container">
        <!-- Detail Header -->
        <div class="detail-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="detail-title">
                        <i class="fas fa-user-graduate me-3"></i>Detail Siswa
                    </h1>
                    <p class="detail-subtitle">
                        Informasi lengkap data siswa dan QR Code absensi
                    </p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.students.index') }}" class="btn-header">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn-header">
                        <i class="fas fa-edit"></i> Edit Data
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="profile-section">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <div class="position-relative d-inline-block">
                        @if($student->photo)
                            <img src="{{ $student->photo_url ?? asset('images/default-avatar.png') }}" alt="{{ $student->name }}" class="student-photo">
                        @else
                            <div class="student-initials">
                                {{ $student->initials ?? strtoupper(substr($student->name, 0, 2)) }}
                            </div>
                        @endif
                        
                        <div class="status-badge status-{{ $student->status }}">
                            {{ $student->status_label ?? ucfirst($student->status) }}
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <h2 class="student-name">{{ $student->name }}</h2>
                    @if($student->class)
                        <div class="student-class">
                            <i class="fas fa-graduation-cap me-2"></i>{{ $student->class->name ?? $student->class }}
                        </div>
                    @else
                        <div class="student-class" style="background: var(--gray-400);">
                            <i class="fas fa-exclamation-triangle me-2"></i>Belum ada kelas
                        </div>
                    @endif
                    
                    <div class="student-meta">
                        <div class="meta-item">
                            <i class="fas fa-id-card meta-icon"></i>
                            <strong>NIS:</strong> {{ $student->nis }}
                        </div>
                        @if($student->nisn)
                            <div class="meta-item">
                                <i class="fas fa-id-badge meta-icon"></i>
                                <strong>NISN:</strong> {{ $student->nisn }}
                            </div>
                        @endif
                        <div class="meta-item">
                            <i class="fas fa-calendar meta-icon"></i>
                            <strong>Umur:</strong> 
                            <span class="age-badge">
                                @if($student->birth_date)
                                    {{ $student->age ?? \Carbon\Carbon::parse($student->birth_date)->age }} tahun
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-{{ $student->gender === 'male' ? 'mars' : 'venus' }} meta-icon"></i>
                            {{ $student->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <div class="info-grid">
                <!-- Personal Information -->
                <div class="info-card fade-in">
                    <h3 class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        Data Pribadi
                    </h3>
                    
                    <div class="info-item">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ $student->name }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Tempat Lahir</div>
                        <div class="info-value">{{ $student->birth_place }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Tanggal Lahir</div>
                        <div class="info-value">
                            @if($student->birth_date)
                                {{ \Carbon\Carbon::parse($student->birth_date)->format('d F Y') }}
                                <span class="age-badge">
                                    {{ $student->age ?? \Carbon\Carbon::parse($student->birth_date)->age }} tahun
                                </span>
                            @else
                                <span class="empty">Tidak ada data</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Jenis Kelamin</div>
                        <div class="info-value">
                            <i class="fas fa-{{ $student->gender === 'male' ? 'mars' : 'venus' }} text-primary me-2"></i>
                            {{ $student->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Agama</div>
                        <div class="info-value {{ !$student->religion ? 'empty' : '' }}">
                            @if($student->religion)
                                <i class="fas fa-pray text-primary me-2"></i>{{ $student->religion }}
                            @else
                                Tidak ada data
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Alamat</div>
                        <div class="info-value {{ !$student->address ? 'empty' : '' }}">
                            {{ $student->address ?: 'Tidak ada data' }}
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="info-card fade-in">
                    <h3 class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        Kontak
                    </h3>
                    
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            @if($student->email)
                                <a href="mailto:{{ $student->email }}" class="contact-link">
                                    <i class="fas fa-envelope me-1"></i>{{ $student->email }}
                                </a>
                            @else
                                <span class="empty">Tidak ada data</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Telepon</div>
                        <div class="info-value">
                            @if($student->phone)
                                <a href="tel:{{ $student->phone }}" class="contact-link">
                                    <i class="fas fa-phone me-1"></i>{{ $student->phone }}
                                </a>
                            @else
                                <span class="empty">Tidak ada data</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Nama Orang Tua</div>
                        <div class="info-value">{{ $student->parent_name }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Telepon Orang Tua</div>
                        <div class="info-value">
                            @if($student->parent_phone)
                                <a href="tel:{{ $student->parent_phone }}" class="contact-link">
                                    <i class="fas fa-phone me-1"></i>{{ $student->parent_phone }}
                                </a>
                            @else
                                <span class="empty">Tidak ada data</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="info-card fade-in">
                    <h3 class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        Data Akademik
                    </h3>
                    
                    <div class="info-item">
                        <div class="info-label">NIS</div>
                        <div class="info-value">
                            <code style="background: var(--gray-100); padding: 0.25rem 0.5rem; border-radius: 4px; font-weight: 600; color: var(--gray-800);">{{ $student->nis }}</code>
                        </div>
                    </div>
                    
                    @if($student->nisn)
                        <div class="info-item">
                            <div class="info-label">NISN</div>
                            <div class="info-value">
                                <code style="background: var(--gray-100); padding: 0.25rem 0.5rem; border-radius: 4px; font-weight: 600; color: var(--gray-800);">{{ $student->nisn }}</code>
                            </div>
                        </div>
                    @endif
                    
                    <div class="info-item">
                        <div class="info-label">Kelas</div>
                        <div class="info-value">
                            @if($student->class)
                                <span class="student-class" style="margin: 0; padding: 0.25rem 1rem; font-size: 0.875rem;">
                                    <i class="fas fa-graduation-cap me-1"></i>{{ $student->class->name ?? $student->class }}
                                </span>
                            @else
                                <span class="empty">Belum ada kelas</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $student->status }}" style="position: static; margin: 0; border: none; box-shadow: none;">
                                {{ $student->status_label ?? ucfirst($student->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Terdaftar</div>
                        <div class="info-value">
                            <i class="fas fa-calendar-plus text-primary me-1"></i>
                            {{ $student->created_at ? \Carbon\Carbon::parse($student->created_at)->format('d F Y') : 'N/A' }}
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Terakhir Update</div>
                        <div class="info-value">
                            <i class="fas fa-clock text-primary me-1"></i>
                            {{ $student->updated_at ? \Carbon\Carbon::parse($student->updated_at)->format('d F Y H:i') : 'N/A' }}
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="info-card fade-in">
                    <h3 class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        QR Code Absensi
                    </h3>
                    
                    @if(isset($student->qrAttendance) && $student->qrAttendance)
                        <div class="qr-section">
                            <div class="qr-code-container">
                                @if($student->qrAttendance->qr_image_path && file_exists(storage_path('app/public/' . $student->qrAttendance->qr_image_path)))
                                    <img src="{{ asset('storage/' . $student->qrAttendance->qr_image_path) }}" 
                                         alt="QR Code {{ $student->name }}" 
                                         class="qr-code-image">
                                @else
                                    <div style="width: 200px; height: 200px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--gray-500);">
                                        <div class="text-center">
                                            <i class="fas fa-qrcode fa-3x mb-2"></i>
                                            <div>QR Code</div>
                                            <div style="font-size: 0.75rem;">{{ $student->qrAttendance->qr_code }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <strong>Kode QR:</strong> 
                                <code style="background: var(--gray-100); padding: 0.25rem 0.5rem; border-radius: 4px; font-weight: 600; color: var(--gray-800);">
                                    {{ $student->qrAttendance->qr_code }}
                                </code>
                            </div>
                            
                            <div class="qr-actions">
                                @if($student->qrAttendance->qr_image_path && file_exists(storage_path('app/public/' . $student->qrAttendance->qr_image_path)))
                                    <a href="{{ asset('storage/' . $student->qrAttendance->qr_image_path) }}" 
                                       download="QR_{{ $student->name }}_{{ $student->nis }}.png" 
                                       class="btn-qr btn-qr-download">
                                        <i class="fas fa-download"></i> Download QR
                                    </a>
                                @endif
                                
                                <button type="button" class="btn-qr btn-qr-regenerate" onclick="regenerateQR({{ $student->id }})">
                                    <i class="fas fa-sync-alt"></i> Regenerate
                                </button>
                                
                                <a href="{{ route('admin.qr-attendance.index', ['search' => $student->nis]) }}" 
                                   class="btn-qr btn-qr-manage" target="_blank">
                                    <i class="fas fa-cog"></i> Kelola QR
                                </a>
                            </div>
                            
                            <div class="qr-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Informasi QR Code:</strong><br>
                                QR Code ini digunakan untuk absensi siswa. Siswa dapat memindai QR Code ini untuk melakukan absensi harian.
                                @if($student->qrAttendance->created_at)
                                    Dibuat pada: {{ \Carbon\Carbon::parse($student->qrAttendance->created_at)->format('d F Y H:i') }}
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="no-qr-message">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <h5>QR Code Belum Dibuat</h5>
                            <p class="mb-3">Siswa ini belum memiliki QR Code untuk absensi. Buat QR Code sekarang untuk memungkinkan siswa melakukan absensi.</p>
                            
                            <button type="button" class="btn-generate-qr" onclick="generateQR({{ $student->id }})">
                                <i class="fas fa-qrcode"></i> Buat QR Code
                            </button>
                            
                            <div class="mt-3">
                                <small class="text-muted">
                                    Atau buat QR Code melalui halaman 
                                    <a href="{{ route('admin.qr-attendance.index') }}" target="_blank" class="contact-link">
                                        Manajemen QR Attendance
                                    </a>
                                </small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Buttons -->
<div class="floating-actions">
    <a href="{{ route('admin.students.edit', $student) }}" class="floating-btn floating-btn-primary" title="Edit Data Siswa">
        <i class="fas fa-edit"></i>
    </a>
    @if(isset($student->qrAttendance) && $student->qrAttendance)
        <button type="button" onclick="regenerateQR({{ $student->id }})" class="floating-btn floating-btn-warning" title="Regenerate QR Code">
            <i class="fas fa-sync-alt"></i>
        </button>
    @else
        <button type="button" onclick="generateQR({{ $student->id }})" class="floating-btn floating-btn-success" title="Generate QR Code">
            <i class="fas fa-qrcode"></i>
        </button>
    @endif
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Memuat...</span>
                </div>
                <div id="loadingText">Memproses QR Code...</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function generateQR(studentId) {
    if (confirm('Apakah Anda yakin ingin membuat QR Code untuk siswa ini?')) {
        showLoading('Membuat QR Code...');
        
        fetch(`/admin/qr-attendance/generate/${studentId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.success) {
                showNotification('QR Code berhasil dibuat!', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Gagal membuat QR Code', 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat membuat QR Code', 'error');
        });
    }
}

function regenerateQR(studentId) {
    if (confirm('Apakah Anda yakin ingin membuat ulang QR Code? QR Code lama akan diganti dengan yang baru.')) {
        showLoading('Membuat ulang QR Code...');
        
        fetch(`/admin/qr-attendance/regenerate/${studentId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.success) {
                showNotification('QR Code berhasil dibuat ulang!', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Gagal membuat ulang QR Code', 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat membuat ulang QR Code', 'error');
        });
    }
}

function showLoading(text = 'Memproses...') {
    document.getElementById('loadingText').textContent = text;
    const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
    modal.show();
}

function hideLoading() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
    if (modal) {
        modal.hide();
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    const alertClass = type === 'error' ? 'danger' : type;
    notification.className = `alert alert-${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px; max-width: 400px;';
    
    const iconClass = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-triangle' : 
                     type === 'warning' ? 'exclamation-circle' : 'info-circle';
    
    notification.innerHTML = `
        <i class="fas fa-${iconClass} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    const timeout = type === 'error' ? 5000 : 3000;
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, timeout);
}

// Smooth scroll to top when page loads
document.addEventListener('DOMContentLoaded', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>
@endpush