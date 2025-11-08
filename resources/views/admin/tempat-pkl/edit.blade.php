@extends('layouts.admin')

@section('title', 'Edit Tempat PKL')

@push('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --primary-color: #000000;
            --primary-dark: #333333;
            --secondary-color: #000000;
            --success-color: #000000;
            --warning-color: #000000;
            --danger-color: #dc3545;
            --info-color: #000000;
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

        .page-container {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .form-container {
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            margin: 0 auto;
            max-width: 1200px;
        }

        .form-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .form-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .form-subtitle {
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

        .form-body {
            padding: 2rem;
        }

        .form-section {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.875rem;
        }

        .required {
            color: var(--danger-color);
            margin-left: 0.25rem;
        }

        .form-control,
        .form-select {
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: var(--white);
            color: var(--gray-800);
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: var(--danger-color);
            background: #fef2f2;
        }

        .form-control.is-valid,
        .form-select.is-valid {
            border-color: var(--success-color);
            background: #f0fdf4;
        }

        .dark .form-control.is-invalid,
        .dark .form-select.is-invalid {
            background: #7f1d1d;
            color: #fecaca;
        }

        .dark .form-control.is-valid,
        .dark .form-select.is-valid {
            background: #14532d;
            color: #bbf7d0;
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            font-weight: 500;
        }

        .form-text {
            color: var(--gray-500);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .form-actions {
            background: var(--gray-50);
            padding: 2rem;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .btn-form {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary-form {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary-form:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary-color));
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary-form {
            background: var(--gray-100);
            color: var(--gray-700);
            border: 2px solid var(--gray-200);
        }

        .btn-secondary-form:hover {
            background: var(--gray-200);
            color: var(--gray-800);
            transform: translateY(-2px);
        }

        .btn-outline-form {
            background: transparent;
            border: 2px solid var(--gray-300);
            color: var(--gray-600);
        }

        .btn-outline-form:hover {
            background: var(--gray-100);
            color: var(--gray-700);
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

        .floating-btn-secondary {
            background: linear-gradient(135deg, var(--gray-500), var(--gray-600));
        }

        .alert-custom {
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow);
        }

        .alert-danger-custom {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        .alert-success-custom {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid var(--success-color);
        }

        .alert-info-custom {
            background: #eff6ff;
            color: #1e40af;
            border-left: 4px solid var(--info-color);
        }

        .dark .alert-danger-custom {
            background: #7f1d1d;
            color: #fecaca;
        }

        .dark .alert-success-custom {
            background: #14532d;
            color: #bbf7d0;
        }

        .dark .alert-info-custom {
            background: #1e3a8a;
            color: #bfdbfe;
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 1rem;
            }

            .form-header {
                padding: 1.5rem;
                text-align: center;
            }

            .form-title {
                font-size: 2rem;
            }

            .header-actions {
                justify-content: center;
                flex-wrap: wrap;
            }

            .form-body {
                padding: 1rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .form-actions {
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

        .fade-in:nth-child(4) {
            animation-delay: 0.4s;
        }

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
        <div class="form-container">
            <!-- Form Header -->
            <div class="form-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="form-title">
                            <i class="fas fa-edit me-3"></i>Edit Tempat PKL
                        </h1>
                        <p class="form-subtitle">
                            Edit informasi tempat PKL: <strong>{{ $tempatPkl->nama_tempat }}</strong>
                        </p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('admin.tempat-pkl.index') }}" class="btn-header">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('admin.tempat-pkl.show', $tempatPkl) }}" class="btn-header">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>

            <div class="form-body">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert-custom alert-danger-custom">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.tempat-pkl.update', $tempatPkl) }}" id="tempatPklForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Company Information Section -->
                    <div class="form-section fade-in">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            Informasi Tempat PKL
                        </h3>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama_tempat" class="form-label">
                                        Nama Tempat PKL <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama_tempat') is-invalid @enderror"
                                        id="nama_tempat" name="nama_tempat"
                                        value="{{ old('nama_tempat', $tempatPkl->nama_tempat) }}"
                                        placeholder="Contoh: PT. Teknologi Indonesia" required>
                                    @error('nama_tempat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kuota" class="form-label">
                                        Kuota Siswa <span class="required">*</span>
                                    </label>
                                    <input type="number" class="form-control @error('kuota') is-invalid @enderror"
                                        id="kuota" name="kuota" value="{{ old('kuota', $tempatPkl->kuota) }}" min="1"
                                        max="100" required>
                                    @error('kuota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text">Jumlah maksimal siswa yang dapat diterima</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="alamat" class="form-label">
                                        Alamat Lengkap <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                        name="alamat" rows="3" placeholder="Masukkan alamat lengkap tempat PKL..."
                                        required>{{ old('alamat', $tempatPkl->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kota" class="form-label">
                                        Kota/Kabupaten <span class="required">*</span>
                                    </label>
                                    <select class="form-select @error('kota') is-invalid @enderror" id="kota" name="kota"
                                        required>
                                        <option value="">Pilih Kota/Kabupaten</option>
                                        <optgroup label="Provinsi DKI Jakarta">
                                            <option value="Jakarta Pusat" {{ old('kota', $tempatPkl->kota) == 'Jakarta Pusat' ? 'selected' : '' }}>Jakarta Pusat</option>
                                            <option value="Jakarta Utara" {{ old('kota', $tempatPkl->kota) == 'Jakarta Utara' ? 'selected' : '' }}>Jakarta Utara</option>
                                            <option value="Jakarta Barat" {{ old('kota', $tempatPkl->kota) == 'Jakarta Barat' ? 'selected' : '' }}>Jakarta Barat</option>
                                            <option value="Jakarta Selatan" {{ old('kota', $tempatPkl->kota) == 'Jakarta Selatan' ? 'selected' : '' }}>Jakarta Selatan</option>
                                            <option value="Jakarta Timur" {{ old('kota', $tempatPkl->kota) == 'Jakarta Timur' ? 'selected' : '' }}>Jakarta Timur</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Jawa Barat">
                                            <option value="Bandung" {{ old('kota', $tempatPkl->kota) == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                                            <option value="Bogor" {{ old('kota', $tempatPkl->kota) == 'Bogor' ? 'selected' : '' }}>Bogor</option>
                                            <option value="Bekasi" {{ old('kota', $tempatPkl->kota) == 'Bekasi' ? 'selected' : '' }}>Bekasi</option>
                                            <option value="Depok" {{ old('kota', $tempatPkl->kota) == 'Depok' ? 'selected' : '' }}>Depok</option>
                                            <option value="Cirebon" {{ old('kota', $tempatPkl->kota) == 'Cirebon' ? 'selected' : '' }}>Cirebon</option>
                                            <option value="Tasikmalaya" {{ old('kota', $tempatPkl->kota) == 'Tasikmalaya' ? 'selected' : '' }}>Tasikmalaya</option>
                                            <option value="Cimahi" {{ old('kota', $tempatPkl->kota) == 'Cimahi' ? 'selected' : '' }}>Cimahi</option>
                                            <option value="Sukabumi" {{ old('kota', $tempatPkl->kota) == 'Sukabumi' ? 'selected' : '' }}>Sukabumi</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Jawa Tengah">
                                            <option value="Semarang" {{ old('kota', $tempatPkl->kota) == 'Semarang' ? 'selected' : '' }}>Semarang</option>
                                            <option value="Surakarta" {{ old('kota', $tempatPkl->kota) == 'Surakarta' ? 'selected' : '' }}>Surakarta</option>
                                            <option value="Yogyakarta" {{ old('kota', $tempatPkl->kota) == 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                                            <option value="Magelang" {{ old('kota', $tempatPkl->kota) == 'Magelang' ? 'selected' : '' }}>Magelang</option>
                                            <option value="Pekalongan" {{ old('kota', $tempatPkl->kota) == 'Pekalongan' ? 'selected' : '' }}>Pekalongan</option>
                                            <option value="Tegal" {{ old('kota', $tempatPkl->kota) == 'Tegal' ? 'selected' : '' }}>Tegal</option>
                                            <option value="Salatiga" {{ old('kota', $tempatPkl->kota) == 'Salatiga' ? 'selected' : '' }}>Salatiga</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Jawa Timur">
                                            <option value="Surabaya" {{ old('kota', $tempatPkl->kota) == 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                                            <option value="Malang" {{ old('kota', $tempatPkl->kota) == 'Malang' ? 'selected' : '' }}>Malang</option>
                                            <option value="Kediri" {{ old('kota', $tempatPkl->kota) == 'Kediri' ? 'selected' : '' }}>Kediri</option>
                                            <option value="Blitar" {{ old('kota', $tempatPkl->kota) == 'Blitar' ? 'selected' : '' }}>Blitar</option>
                                            <option value="Madiun" {{ old('kota', $tempatPkl->kota) == 'Madiun' ? 'selected' : '' }}>Madiun</option>
                                            <option value="Mojokerto" {{ old('kota', $tempatPkl->kota) == 'Mojokerto' ? 'selected' : '' }}>Mojokerto</option>
                                            <option value="Pasuruan" {{ old('kota', $tempatPkl->kota) == 'Pasuruan' ? 'selected' : '' }}>Pasuruan</option>
                                            <option value="Probolinggo" {{ old('kota', $tempatPkl->kota) == 'Probolinggo' ? 'selected' : '' }}>Probolinggo</option>
                                            <option value="Batu" {{ old('kota', $tempatPkl->kota) == 'Batu' ? 'selected' : '' }}>Batu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Banten">
                                            <option value="Tangerang" {{ old('kota', $tempatPkl->kota) == 'Tangerang' ? 'selected' : '' }}>Tangerang</option>
                                            <option value="Tangerang Selatan" {{ old('kota', $tempatPkl->kota) == 'Tangerang Selatan' ? 'selected' : '' }}>Tangerang Selatan</option>
                                            <option value="Serang" {{ old('kota', $tempatPkl->kota) == 'Serang' ? 'selected' : '' }}>Serang</option>
                                            <option value="Cilegon" {{ old('kota', $tempatPkl->kota) == 'Cilegon' ? 'selected' : '' }}>Cilegon</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Bali">
                                            <option value="Denpasar" {{ old('kota', $tempatPkl->kota) == 'Denpasar' ? 'selected' : '' }}>Denpasar</option>
                                            <option value="Badung" {{ old('kota', $tempatPkl->kota) == 'Badung' ? 'selected' : '' }}>Badung</option>
                                            <option value="Gianyar" {{ old('kota', $tempatPkl->kota) == 'Gianyar' ? 'selected' : '' }}>Gianyar</option>
                                            <option value="Tabanan" {{ old('kota', $tempatPkl->kota) == 'Tabanan' ? 'selected' : '' }}>Tabanan</option>
                                            <option value="Jembrana" {{ old('kota', $tempatPkl->kota) == 'Jembrana' ? 'selected' : '' }}>Jembrana</option>
                                            <option value="Karangasem" {{ old('kota', $tempatPkl->kota) == 'Karangasem' ? 'selected' : '' }}>Karangasem</option>
                                            <option value="Bangli" {{ old('kota', $tempatPkl->kota) == 'Bangli' ? 'selected' : '' }}>Bangli</option>
                                            <option value="Klungkung" {{ old('kota', $tempatPkl->kota) == 'Klungkung' ? 'selected' : '' }}>Klungkung</option>
                                            <option value="Buleleng" {{ old('kota', $tempatPkl->kota) == 'Buleleng' ? 'selected' : '' }}>Buleleng</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sumatera Utara">
                                            <option value="Medan" {{ old('kota', $tempatPkl->kota) == 'Medan' ? 'selected' : '' }}>Medan</option>
                                            <option value="Binjai" {{ old('kota', $tempatPkl->kota) == 'Binjai' ? 'selected' : '' }}>Binjai</option>
                                            <option value="Tebing Tinggi" {{ old('kota', $tempatPkl->kota) == 'Tebing Tinggi' ? 'selected' : '' }}>Tebing Tinggi</option>
                                            <option value="Pematangsiantar" {{ old('kota', $tempatPkl->kota) == 'Pematangsiantar' ? 'selected' : '' }}>Pematangsiantar
                                            </option>
                                            <option value="Tanjungbalai" {{ old('kota', $tempatPkl->kota) == 'Tanjungbalai' ? 'selected' : '' }}>Tanjungbalai</option>
                                            <option value="Sibolga" {{ old('kota', $tempatPkl->kota) == 'Sibolga' ? 'selected' : '' }}>Sibolga</option>
                                            <option value="Padangsidempuan" {{ old('kota', $tempatPkl->kota) == 'Padangsidempuan' ? 'selected' : '' }}>Padangsidempuan
                                            </option>
                                            <option value="Gunungsitoli" {{ old('kota', $tempatPkl->kota) == 'Gunungsitoli' ? 'selected' : '' }}>Gunungsitoli</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sumatera Barat">
                                            <option value="Padang" {{ old('kota', $tempatPkl->kota) == 'Padang' ? 'selected' : '' }}>Padang</option>
                                            <option value="Bukittinggi" {{ old('kota', $tempatPkl->kota) == 'Bukittinggi' ? 'selected' : '' }}>Bukittinggi</option>
                                            <option value="Payakumbuh" {{ old('kota', $tempatPkl->kota) == 'Payakumbuh' ? 'selected' : '' }}>Payakumbuh</option>
                                            <option value="Pariaman" {{ old('kota', $tempatPkl->kota) == 'Pariaman' ? 'selected' : '' }}>Pariaman</option>
                                            <option value="Padangpanjang" {{ old('kota', $tempatPkl->kota) == 'Padangpanjang' ? 'selected' : '' }}>Padangpanjang</option>
                                            <option value="Solok" {{ old('kota', $tempatPkl->kota) == 'Solok' ? 'selected' : '' }}>Solok</option>
                                            <option value="Sawahlunto" {{ old('kota', $tempatPkl->kota) == 'Sawahlunto' ? 'selected' : '' }}>Sawahlunto</option>
                                            <option value="Padang Pariaman" {{ old('kota', $tempatPkl->kota) == 'Padang Pariaman' ? 'selected' : '' }}>Padang Pariaman</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Riau">
                                            <option value="Pekanbaru" {{ old('kota', $tempatPkl->kota) == 'Pekanbaru' ? 'selected' : '' }}>Pekanbaru</option>
                                            <option value="Dumai" {{ old('kota', $tempatPkl->kota) == 'Dumai' ? 'selected' : '' }}>Dumai</option>
                                            <option value="Duri" {{ old('kota', $tempatPkl->kota) == 'Duri' ? 'selected' : '' }}>Duri</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sumatera Selatan">
                                            <option value="Palembang" {{ old('kota', $tempatPkl->kota) == 'Palembang' ? 'selected' : '' }}>Palembang</option>
                                            <option value="Prabumulih" {{ old('kota', $tempatPkl->kota) == 'Prabumulih' ? 'selected' : '' }}>Prabumulih</option>
                                            <option value="Pagar Alam" {{ old('kota', $tempatPkl->kota) == 'Pagar Alam' ? 'selected' : '' }}>Pagar Alam</option>
                                            <option value="Lubuklinggau" {{ old('kota', $tempatPkl->kota) == 'Lubuklinggau' ? 'selected' : '' }}>Lubuklinggau</option>
                                            <option value="Muara Enim" {{ old('kota', $tempatPkl->kota) == 'Muara Enim' ? 'selected' : '' }}>Muara Enim</option>
                                            <option value="Lahat" {{ old('kota', $tempatPkl->kota) == 'Lahat' ? 'selected' : '' }}>Lahat</option>
                                            <option value="Banyuasin" {{ old('kota', $tempatPkl->kota) == 'Banyuasin' ? 'selected' : '' }}>Banyuasin</option>
                                            <option value="Ogan Komering Ilir" {{ old('kota', $tempatPkl->kota) == 'Ogan Komering Ilir' ? 'selected' : '' }}>Ogan Komering Ilir</option>
                                            <option value="Ogan Komering Ulu" {{ old('kota', $tempatPkl->kota) == 'Ogan Komering Ulu' ? 'selected' : '' }}>Ogan Komering Ulu</option>
                                            <option value="Musi Rawas" {{ old('kota', $tempatPkl->kota) == 'Musi Rawas' ? 'selected' : '' }}>Musi Rawas</option>
                                            <option value="Musi Banyuasin" {{ old('kota', $tempatPkl->kota) == 'Musi Banyuasin' ? 'selected' : '' }}>Musi Banyuasin</option>
                                            <option value="Bangka Belitung" {{ old('kota', $tempatPkl->kota) == 'Bangka Belitung' ? 'selected' : '' }}>Bangka Belitung</option>
                                            <option value="Bangka" {{ old('kota', $tempatPkl->kota) == 'Bangka' ? 'selected' : '' }}>Bangka</option>
                                            <option value="Belitung" {{ old('kota', $tempatPkl->kota) == 'Belitung' ? 'selected' : '' }}>Belitung</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Lampung">
                                            <option value="Bandar Lampung" {{ old('kota', $tempatPkl->kota) == 'Bandar Lampung' ? 'selected' : '' }}>Bandar Lampung</option>
                                            <option value="Metro" {{ old('kota', $tempatPkl->kota) == 'Metro' ? 'selected' : '' }}>Metro</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Timur">
                                            <option value="Samarinda" {{ old('kota', $tempatPkl->kota) == 'Samarinda' ? 'selected' : '' }}>Samarinda</option>
                                            <option value="Balikpapan" {{ old('kota', $tempatPkl->kota) == 'Balikpapan' ? 'selected' : '' }}>Balikpapan</option>
                                            <option value="Bontang" {{ old('kota', $tempatPkl->kota) == 'Bontang' ? 'selected' : '' }}>Bontang</option>
                                            <option value="Tarakan" {{ old('kota', $tempatPkl->kota) == 'Tarakan' ? 'selected' : '' }}>Tarakan</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Selatan">
                                            <option value="Banjarmasin" {{ old('kota', $tempatPkl->kota) == 'Banjarmasin' ? 'selected' : '' }}>Banjarmasin</option>
                                            <option value="Banjarbaru" {{ old('kota', $tempatPkl->kota) == 'Banjarbaru' ? 'selected' : '' }}>Banjarbaru</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Selatan">
                                            <option value="Makassar" {{ old('kota', $tempatPkl->kota) == 'Makassar' ? 'selected' : '' }}>Makassar</option>
                                            <option value="Parepare" {{ old('kota', $tempatPkl->kota) == 'Parepare' ? 'selected' : '' }}>Parepare</option>
                                            <option value="Palopo" {{ old('kota', $tempatPkl->kota) == 'Palopo' ? 'selected' : '' }}>Palopo</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Utara">
                                            <option value="Manado" {{ old('kota', $tempatPkl->kota) == 'Manado' ? 'selected' : '' }}>Manado</option>
                                            <option value="Bitung" {{ old('kota', $tempatPkl->kota) == 'Bitung' ? 'selected' : '' }}>Bitung</option>
                                            <option value="Tomohon" {{ old('kota', $tempatPkl->kota) == 'Tomohon' ? 'selected' : '' }}>Tomohon</option>
                                            <option value="Kotamobagu" {{ old('kota', $tempatPkl->kota) == 'Kotamobagu' ? 'selected' : '' }}>Kotamobagu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua">
                                            <option value="Jayapura" {{ old('kota', $tempatPkl->kota) == 'Jayapura' ? 'selected' : '' }}>Jayapura</option>
                                            <option value="Sorong" {{ old('kota', $tempatPkl->kota) == 'Sorong' ? 'selected' : '' }}>Sorong</option>
                                            <option value="Timika" {{ old('kota', $tempatPkl->kota) == 'Timika' ? 'selected' : '' }}>Timika</option>
                                            <option value="Biak" {{ old('kota', $tempatPkl->kota) == 'Biak' ? 'selected' : '' }}>Biak</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Nusa Tenggara Timur">
                                            <option value="Kupang" {{ old('kota', $tempatPkl->kota) == 'Kupang' ? 'selected' : '' }}>Kupang</option>
                                            <option value="Maumere" {{ old('kota', $tempatPkl->kota) == 'Maumere' ? 'selected' : '' }}>Maumere</option>
                                            <option value="Ende" {{ old('kota', $tempatPkl->kota) == 'Ende' ? 'selected' : '' }}>Ende</option>
                                            <option value="Waingapu" {{ old('kota', $tempatPkl->kota) == 'Waingapu' ? 'selected' : '' }}>Waingapu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Nusa Tenggara Barat">
                                            <option value="Mataram" {{ old('kota', $tempatPkl->kota) == 'Mataram' ? 'selected' : '' }}>Mataram</option>
                                            <option value="Bima" {{ old('kota', $tempatPkl->kota) == 'Bima' ? 'selected' : '' }}>Bima</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Aceh">
                                            <option value="Banda Aceh" {{ old('kota', $tempatPkl->kota) == 'Banda Aceh' ? 'selected' : '' }}>Banda Aceh</option>
                                            <option value="Lhokseumawe" {{ old('kota', $tempatPkl->kota) == 'Lhokseumawe' ? 'selected' : '' }}>Lhokseumawe</option>
                                            <option value="Langsa" {{ old('kota', $tempatPkl->kota) == 'Langsa' ? 'selected' : '' }}>Langsa</option>
                                            <option value="Sabang" {{ old('kota', $tempatPkl->kota) == 'Sabang' ? 'selected' : '' }}>Sabang</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Maluku">
                                            <option value="Ambon" {{ old('kota', $tempatPkl->kota) == 'Ambon' ? 'selected' : '' }}>Ambon</option>
                                            <option value="Tual" {{ old('kota', $tempatPkl->kota) == 'Tual' ? 'selected' : '' }}>Tual</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Maluku Utara">
                                            <option value="Ternate" {{ old('kota', $tempatPkl->kota) == 'Ternate' ? 'selected' : '' }}>Ternate</option>
                                            <option value="Tidore Kepulauan" {{ old('kota', $tempatPkl->kota) == 'Tidore Kepulauan' ? 'selected' : '' }}>Tidore Kepulauan</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Bengkulu">
                                            <option value="Bengkulu" {{ old('kota', $tempatPkl->kota) == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Jambi">
                                            <option value="Jambi" {{ old('kota', $tempatPkl->kota) == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                                            <option value="Sungai Penuh" {{ old('kota', $tempatPkl->kota) == 'Sungai Penuh' ? 'selected' : '' }}>Sungai Penuh</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kepulauan Riau">
                                            <option value="Batam" {{ old('kota', $tempatPkl->kota) == 'Batam' ? 'selected' : '' }}>Batam</option>
                                            <option value="Tanjungpinang" {{ old('kota', $tempatPkl->kota) == 'Tanjungpinang' ? 'selected' : '' }}>Tanjungpinang</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Barat">
                                            <option value="Pontianak" {{ old('kota', $tempatPkl->kota) == 'Pontianak' ? 'selected' : '' }}>Pontianak</option>
                                            <option value="Singkawang" {{ old('kota', $tempatPkl->kota) == 'Singkawang' ? 'selected' : '' }}>Singkawang</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Tengah">
                                            <option value="Palangka Raya" {{ old('kota', $tempatPkl->kota) == 'Palangka Raya' ? 'selected' : '' }}>Palangka Raya</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Utara">
                                            <option value="Tanjung Selor" {{ old('kota', $tempatPkl->kota) == 'Tanjung Selor' ? 'selected' : '' }}>Tanjung Selor</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Tengah">
                                            <option value="Palu" {{ old('kota', $tempatPkl->kota) == 'Palu' ? 'selected' : '' }}>Palu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Tenggara">
                                            <option value="Kendari" {{ old('kota', $tempatPkl->kota) == 'Kendari' ? 'selected' : '' }}>Kendari</option>
                                            <option value="Baubau" {{ old('kota', $tempatPkl->kota) == 'Baubau' ? 'selected' : '' }}>Baubau</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Barat">
                                            <option value="Mamuju" {{ old('kota', $tempatPkl->kota) == 'Mamuju' ? 'selected' : '' }}>Mamuju</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Gorontalo">
                                            <option value="Gorontalo" {{ old('kota', $tempatPkl->kota) == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Barat">
                                            <option value="Manokwari" {{ old('kota', $tempatPkl->kota) == 'Manokwari' ? 'selected' : '' }}>Manokwari</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Tengah">
                                            <option value="Nabire" {{ old('kota', $tempatPkl->kota) == 'Nabire' ? 'selected' : '' }}>Nabire</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Pegunungan">
                                            <option value="Jayawijaya" {{ old('kota', $tempatPkl->kota) == 'Jayawijaya' ? 'selected' : '' }}>Jayawijaya</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Selatan">
                                            <option value="Merauke" {{ old('kota', $tempatPkl->kota) == 'Merauke' ? 'selected' : '' }}>Merauke</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Barat Daya">
                                            <option value="Sorong" {{ old('kota', $tempatPkl->kota) == 'Sorong' ? 'selected' : '' }}>Sorong</option>
                                        </optgroup>
                                    </select>
                                    @error('kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload Section -->
                    <div class="form-section fade-in">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-image"></i>
                            </div>
                            Gambar Tempat PKL
                        </h3>

                        <div class="form-group">
                            <label for="gambar" class="form-label">Upload Gambar</label>
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                                name="gambar" accept="image/*">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Upload gambar tempat PKL (format: JPG, PNG, JPEG. Maksimal 2MB)</small>
                        </div>

                        @if($tempatPkl->gambar)
                            <div class="current-image">
                                <label class="form-label">Gambar Saat Ini:</label>
                                <div class="image-preview">
                                    <img src="{{ asset($tempatPkl->gambar) }}" alt="Gambar Tempat PKL" class="img-thumbnail"
                                        style="max-width: 200px; max-height: 150px;">
                                </div>
                                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                            </div>
                        @endif

                        <div class="alert-custom alert-info-custom">
                            <i class="fas fa-info-circle"></i>
                            <small>
                                <strong>Informasi Gambar:</strong> Gambar akan ditampilkan di halaman detail tempat PKL
                                untuk memberikan gambaran visual kepada siswa. Jika tidak diupload, akan menggunakan gambar
                                default.
                            </small>
                        </div>
                    </div>

                    <!-- Location Information Section -->
                    <div class="form-section fade-in">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            Lokasi Google Maps
                        </h3>

                        <div class="form-group">
                            <label for="map" class="form-label">Pilih Lokasi di Peta</label>
                            <div id="map"
                                style="height: 400px; width: 100%; border-radius: 12px; border: 2px solid var(--gray-200);">
                            </div>
                            <small class="form-text">Klik pada peta untuk menentukan lokasi tempat PKL</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                        id="latitude" name="latitude" value="{{ old('latitude', $tempatPkl->latitude) }}"
                                        readonly>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                        id="longitude" name="longitude"
                                        value="{{ old('longitude', $tempatPkl->longitude) }}" readonly>
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert-custom alert-info-custom">
                            <i class="fas fa-info-circle"></i>
                            <small>
                                <strong>Informasi Lokasi:</strong> Lokasi akan digunakan untuk menampilkan posisi tempat PKL
                                di peta.
                                Jika tidak dipilih, lokasi akan kosong dan dapat diatur nanti.
                            </small>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="form-section fade-in">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            Informasi Kontak
                        </h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kontak" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('kontak') is-invalid @enderror"
                                        id="kontak" name="kontak" value="{{ old('kontak', $tempatPkl->kontak) }}"
                                        placeholder="Contoh: 021-12345678 atau 081234567890">
                                    @error('kontak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text">Nomor telepon kantor atau PIC (opsional)</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pembimbing_lapangan" class="form-label">Pembimbing Lapangan</label>
                                    <input type="text"
                                        class="form-control @error('pembimbing_lapangan') is-invalid @enderror"
                                        id="pembimbing_lapangan" name="pembimbing_lapangan"
                                        value="{{ old('pembimbing_lapangan', $tempatPkl->pembimbing_lapangan) }}"
                                        placeholder="Contoh: Bapak Ahmad Susanto, S.Kom">
                                    @error('pembimbing_lapangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text">Nama pembimbing atau supervisor di tempat PKL
                                        (opsional)</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert-custom alert-info-custom">
                            <i class="fas fa-info-circle"></i>
                            <small>
                                <strong>Informasi Kontak:</strong> Data kontak dan pembimbing lapangan akan membantu
                                koordinasi
                                antara sekolah dan tempat PKL. Data ini bersifat opsional namun sangat disarankan untuk
                                diisi.
                            </small>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.tempat-pkl.index') }}" class="btn-form btn-outline-form">
                        <i class="fas fa-arrow-left"></i>Kembali
                    </a>
                    <a href="{{ route('admin.tempat-pkl.show', $tempatPkl) }}" class="btn-form btn-secondary-form">
                        <i class="fas fa-eye"></i>Lihat Detail
                    </a>
                </div>

                <button type="submit" form="tempatPklForm" class="btn-form btn-primary-form">
                    <i class="fas fa-save"></i>Update Tempat PKL
                </button>
            </div>
        </div>
    </div>

    <!-- Floating Action Buttons -->
    <div class="floating-actions">
        <button type="submit" form="tempatPklForm" class="floating-btn floating-btn-success" title="Update Tempat PKL">
            <i class="fas fa-save"></i>
        </button>
        <a href="{{ route('admin.tempat-pkl.show', $tempatPkl) }}" class="floating-btn floating-btn-primary"
            title="Lihat Detail">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.tempat-pkl.index') }}" class="floating-btn floating-btn-secondary"
            title="Kembali ke Daftar">
            <i class="fas fa-list"></i>
        </a>
    </div>
@endsection

@push('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Form validation
        document.getElementById('tempatPklForm').addEventListener('submit', function (e) {
            const requiredFields = ['nama_tempat', 'alamat', 'kuota'];
            let isValid = true;

            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    element.classList.add('is-invalid');
                    isValid = false;
                } else {
                    element.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                showNotification('Mohon lengkapi semua field yang wajib diisi!', 'error');
                return;
            }

            showNotification('Mengupdate data tempat PKL...', 'info');
        });

        // Show notification
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

        // Real-time validation
        document.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('blur', function () {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });

            field.addEventListener('input', function () {
                if (this.classList.contains('is-invalid') && this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Kuota validation
        document.getElementById('kuota').addEventListener('input', function () {
            const value = parseInt(this.value);
            if (value < 1) {
                this.value = 1;
            } else if (value > 100) {
                this.value = 100;
            }
        });

        // Leaflet Map initialization
        let map;
        let marker;

        function initMap() {
            // Default location (Jakarta, Indonesia) or existing location
            const existingLat = {{ $tempatPkl->latitude ? $tempatPkl->latitude : -6.2088 }};
            const existingLng = {{ $tempatPkl->longitude ? $tempatPkl->longitude : 106.8456 }};
            const defaultLocation = [existingLat, existingLng];

            map = L.map('map').setView(defaultLocation, 12);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add click listener to place marker
            map.on('click', function (e) {
                placeMarker(e.latlng);
            });

            // If location exists, place marker
            if ({{ $tempatPkl->latitude ? 'true' : 'false' }}) {
                const existingLocation = [existingLat, existingLng];
                placeMarker(existingLocation);
            }

            // Try to get user's current location if no existing location
            if (!{{ $tempatPkl->latitude ? 'true' : 'false' }}) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const userLocation = [position.coords.latitude, position.coords.longitude];
                        map.setView(userLocation, 12);
                    });
                }
            }
        }

        function placeMarker(latlng) {
            // Remove existing marker
            if (marker) {
                map.removeLayer(marker);
            }

            // Create new marker
            marker = L.marker(latlng, { draggable: true }).addTo(map);

            // Update form fields
            document.getElementById('latitude').value = latlng.lat.toFixed(6);
            document.getElementById('longitude').value = latlng.lng.toFixed(6);

            // Add drag listener
            marker.on('dragend', function (event) {
                const position = event.target.getLatLng();
                document.getElementById('latitude').value = position.lat.toFixed(6);
                document.getElementById('longitude').value = position.lng.toFixed(6);
            });
        }

        // Initialize map when page loads
        window.addEventListener('load', initMap);
    </script>
@endpush