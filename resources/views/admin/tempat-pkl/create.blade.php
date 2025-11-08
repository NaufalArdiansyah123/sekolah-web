@extends('layouts.admin')

@section('title', 'Tambah Tempat PKL')

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

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

        .form-container {
            background: var(--bg-primary);
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 0 auto;
            max-width: 1200px;
            border: 1px solid var(--border-color);
        }

        .form-header {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            padding: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .form-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .form-subtitle {
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

        .form-body {
            padding: 2rem;
        }

        .form-section {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .form-section:hover {
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.875rem;
        }

        .required {
            color: #dc3545;
            margin-left: 0.25rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: var(--bg-primary);
            color: var(--text-primary);
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #000000;
            outline: none;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
            background: #fef2f2;
        }

        .form-control.is-valid,
        .form-select.is-valid {
            border-color: #28a745;
            background: #f0fdf4;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            font-weight: 500;
        }

        .form-text {
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .form-actions {
            background: var(--bg-tertiary);
            padding: 2rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .btn-form {
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

        .btn-primary-form {
            background: #000000;
            color: white;
        }

        .btn-primary-form:hover {
            background: #333;
            color: white;
        }

        .btn-secondary-form {
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }

        .btn-secondary-form:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }

        .btn-outline-form {
            background: transparent;
            color: var(--text-primary);
        }

        .btn-outline-form:hover {
            background: var(--border-color);
            color: var(--text-primary);
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

        .floating-btn-success {
            background: #000000;
        }

        .floating-btn-secondary {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .alert-custom {
            border-radius: 0.5rem;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-danger-custom {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #dc3545;
        }

        .alert-success-custom {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #28a745;
        }

        .alert-info-custom {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border-left: 4px solid var(--accent-color);
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

@section('content')
    <div class="page-container">
        <div class="form-container">
            <!-- Form Header -->
            <div class="form-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="form-title">
                            <i class="fas fa-building me-3"></i>Tambah Tempat PKL Baru
                        </h1>
                        <p class="form-subtitle">
                            Lengkapi formulir di bawah untuk menambahkan tempat PKL baru
                        </p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('admin.tempat-pkl.index') }}" class="btn-header">
                            <i class="fas fa-arrow-left"></i> Kembali
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

                <form method="POST" action="{{ route('admin.tempat-pkl.store') }}" id="tempatPklForm"
                    enctype="multipart/form-data">
                    @csrf

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
                                        id="nama_tempat" name="nama_tempat" value="{{ old('nama_tempat') }}"
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
                                        id="kuota" name="kuota" value="{{ old('kuota', 1) }}" min="1" max="100" required>
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
                                        required>{{ old('alamat') }}</textarea>
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
                                            <option value="Jakarta Pusat" {{ old('kota') == 'Jakarta Pusat' ? 'selected' : '' }}>Jakarta Pusat</option>
                                            <option value="Jakarta Utara" {{ old('kota') == 'Jakarta Utara' ? 'selected' : '' }}>Jakarta Utara</option>
                                            <option value="Jakarta Barat" {{ old('kota') == 'Jakarta Barat' ? 'selected' : '' }}>Jakarta Barat</option>
                                            <option value="Jakarta Selatan" {{ old('kota') == 'Jakarta Selatan' ? 'selected' : '' }}>Jakarta Selatan</option>
                                            <option value="Jakarta Timur" {{ old('kota') == 'Jakarta Timur' ? 'selected' : '' }}>Jakarta Timur</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Jawa Barat">
                                            <option value="Bandung" {{ old('kota') == 'Bandung' ? 'selected' : '' }}>Bandung
                                            </option>
                                            <option value="Bogor" {{ old('kota') == 'Bogor' ? 'selected' : '' }}>Bogor
                                            </option>
                                            <option value="Bekasi" {{ old('kota') == 'Bekasi' ? 'selected' : '' }}>Bekasi
                                            </option>
                                            <option value="Depok" {{ old('kota') == 'Depok' ? 'selected' : '' }}>Depok
                                            </option>
                                            <option value="Cirebon" {{ old('kota') == 'Cirebon' ? 'selected' : '' }}>Cirebon
                                            </option>
                                            <option value="Tasikmalaya" {{ old('kota') == 'Tasikmalaya' ? 'selected' : '' }}>
                                                Tasikmalaya</option>
                                            <option value="Cimahi" {{ old('kota') == 'Cimahi' ? 'selected' : '' }}>Cimahi
                                            </option>
                                            <option value="Sukabumi" {{ old('kota') == 'Sukabumi' ? 'selected' : '' }}>
                                                Sukabumi</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Jawa Tengah">
                                            <option value="Semarang" {{ old('kota') == 'Semarang' ? 'selected' : '' }}>
                                                Semarang</option>
                                            <option value="Surakarta" {{ old('kota') == 'Surakarta' ? 'selected' : '' }}>
                                                Surakarta</option>
                                            <option value="Yogyakarta" {{ old('kota') == 'Yogyakarta' ? 'selected' : '' }}>
                                                Yogyakarta</option>
                                            <option value="Magelang" {{ old('kota') == 'Magelang' ? 'selected' : '' }}>
                                                Magelang</option>
                                            <option value="Pekalongan" {{ old('kota') == 'Pekalongan' ? 'selected' : '' }}>
                                                Pekalongan</option>
                                            <option value="Tegal" {{ old('kota') == 'Tegal' ? 'selected' : '' }}>Tegal
                                            </option>
                                            <option value="Salatiga" {{ old('kota') == 'Salatiga' ? 'selected' : '' }}>
                                                Salatiga</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Jawa Timur">
                                            <option value="Surabaya" {{ old('kota') == 'Surabaya' ? 'selected' : '' }}>
                                                Surabaya</option>
                                            <option value="Malang" {{ old('kota') == 'Malang' ? 'selected' : '' }}>Malang
                                            </option>
                                            <option value="Kediri" {{ old('kota') == 'Kediri' ? 'selected' : '' }}>Kediri
                                            </option>
                                            <option value="Blitar" {{ old('kota') == 'Blitar' ? 'selected' : '' }}>Blitar
                                            </option>
                                            <option value="Madiun" {{ old('kota') == 'Madiun' ? 'selected' : '' }}>Madiun
                                            </option>
                                            <option value="Mojokerto" {{ old('kota') == 'Mojokerto' ? 'selected' : '' }}>
                                                Mojokerto</option>
                                            <option value="Pasuruan" {{ old('kota') == 'Pasuruan' ? 'selected' : '' }}>
                                                Pasuruan</option>
                                            <option value="Probolinggo" {{ old('kota') == 'Probolinggo' ? 'selected' : '' }}>
                                                Probolinggo</option>
                                            <option value="Batu" {{ old('kota') == 'Batu' ? 'selected' : '' }}>Batu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Banten">
                                            <option value="Tangerang" {{ old('kota') == 'Tangerang' ? 'selected' : '' }}>
                                                Tangerang</option>
                                            <option value="Tangerang Selatan" {{ old('kota') == 'Tangerang Selatan' ? 'selected' : '' }}>Tangerang Selatan</option>
                                            <option value="Serang" {{ old('kota') == 'Serang' ? 'selected' : '' }}>Serang
                                            </option>
                                            <option value="Cilegon" {{ old('kota') == 'Cilegon' ? 'selected' : '' }}>Cilegon
                                            </option>
                                        </optgroup>
                                        <optgroup label="Provinsi Bali">
                                            <option value="Denpasar" {{ old('kota') == 'Denpasar' ? 'selected' : '' }}>
                                                Denpasar</option>
                                            <option value="Badung" {{ old('kota') == 'Badung' ? 'selected' : '' }}>Badung
                                            </option>
                                            <option value="Gianyar" {{ old('kota') == 'Gianyar' ? 'selected' : '' }}>Gianyar
                                            </option>
                                            <option value="Tabanan" {{ old('kota') == 'Tabanan' ? 'selected' : '' }}>Tabanan
                                            </option>
                                            <option value="Jembrana" {{ old('kota') == 'Jembrana' ? 'selected' : '' }}>
                                                Jembrana</option>
                                            <option value="Karangasem" {{ old('kota') == 'Karangasem' ? 'selected' : '' }}>
                                                Karangasem</option>
                                            <option value="Bangli" {{ old('kota') == 'Bangli' ? 'selected' : '' }}>Bangli
                                            </option>
                                            <option value="Klungkung" {{ old('kota') == 'Klungkung' ? 'selected' : '' }}>
                                                Klungkung</option>
                                            <option value="Buleleng" {{ old('kota') == 'Buleleng' ? 'selected' : '' }}>
                                                Buleleng</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sumatera Utara">
                                            <option value="Medan" {{ old('kota') == 'Medan' ? 'selected' : '' }}>Medan
                                            </option>
                                            <option value="Binjai" {{ old('kota') == 'Binjai' ? 'selected' : '' }}>Binjai
                                            </option>
                                            <option value="Tebing Tinggi" {{ old('kota') == 'Tebing Tinggi' ? 'selected' : '' }}>Tebing Tinggi</option>
                                            <option value="Pematangsiantar" {{ old('kota') == 'Pematangsiantar' ? 'selected' : '' }}>Pematangsiantar</option>
                                            <option value="Tanjungbalai" {{ old('kota') == 'Tanjungbalai' ? 'selected' : '' }}>Tanjungbalai</option>
                                            <option value="Sibolga" {{ old('kota') == 'Sibolga' ? 'selected' : '' }}>Sibolga
                                            </option>
                                            <option value="Padangsidempuan" {{ old('kota') == 'Padangsidempuan' ? 'selected' : '' }}>Padangsidempuan</option>
                                            <option value="Gunungsitoli" {{ old('kota') == 'Gunungsitoli' ? 'selected' : '' }}>Gunungsitoli</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sumatera Barat">
                                            <option value="Padang" {{ old('kota') == 'Padang' ? 'selected' : '' }}>Padang
                                            </option>
                                            <option value="Bukittinggi" {{ old('kota') == 'Bukittinggi' ? 'selected' : '' }}>
                                                Bukittinggi</option>
                                            <option value="Payakumbuh" {{ old('kota') == 'Payakumbuh' ? 'selected' : '' }}>
                                                Payakumbuh</option>
                                            <option value="Pariaman" {{ old('kota') == 'Pariaman' ? 'selected' : '' }}>
                                                Pariaman</option>
                                            <option value="Padangpanjang" {{ old('kota') == 'Padangpanjang' ? 'selected' : '' }}>Padangpanjang</option>
                                            <option value="Solok" {{ old('kota') == 'Solok' ? 'selected' : '' }}>Solok
                                            </option>
                                            <option value="Sawahlunto" {{ old('kota') == 'Sawahlunto' ? 'selected' : '' }}>
                                                Sawahlunto</option>
                                            <option value="Padang Pariaman" {{ old('kota') == 'Padang Pariaman' ? 'selected' : '' }}>Padang Pariaman</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Riau">
                                            <option value="Pekanbaru" {{ old('kota') == 'Pekanbaru' ? 'selected' : '' }}>
                                                Pekanbaru</option>
                                            <option value="Dumai" {{ old('kota') == 'Dumai' ? 'selected' : '' }}>Dumai
                                            </option>
                                            <option value="Duri" {{ old('kota') == 'Duri' ? 'selected' : '' }}>Duri</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sumatera Selatan">
                                            <option value="Palembang" {{ old('kota') == 'Palembang' ? 'selected' : '' }}>
                                                Palembang</option>
                                            <option value="Prabumulih" {{ old('kota') == 'Prabumulih' ? 'selected' : '' }}>
                                                Prabumulih</option>
                                            <option value="Pagar Alam" {{ old('kota') == 'Pagar Alam' ? 'selected' : '' }}>
                                                Pagar Alam</option>
                                            <option value="Lubuklinggau" {{ old('kota') == 'Lubuklinggau' ? 'selected' : '' }}>Lubuklinggau</option>
                                            <option value="Muara Enim" {{ old('kota') == 'Muara Enim' ? 'selected' : '' }}>
                                                Muara Enim</option>
                                            <option value="Lahat" {{ old('kota') == 'Lahat' ? 'selected' : '' }}>Lahat
                                            </option>
                                            <option value="Banyuasin" {{ old('kota') == 'Banyuasin' ? 'selected' : '' }}>
                                                Banyuasin</option>
                                            <option value="Ogan Komering Ilir" {{ old('kota') == 'Ogan Komering Ilir' ? 'selected' : '' }}>Ogan Komering Ilir</option>
                                            <option value="Ogan Komering Ulu" {{ old('kota') == 'Ogan Komering Ulu' ? 'selected' : '' }}>Ogan Komering Ulu</option>
                                            <option value="Musi Rawas" {{ old('kota') == 'Musi Rawas' ? 'selected' : '' }}>
                                                Musi Rawas</option>
                                            <option value="Musi Banyuasin" {{ old('kota') == 'Musi Banyuasin' ? 'selected' : '' }}>Musi Banyuasin</option>
                                            <option value="Bangka Belitung" {{ old('kota') == 'Bangka Belitung' ? 'selected' : '' }}>Bangka Belitung</option>
                                            <option value="Bangka" {{ old('kota') == 'Bangka' ? 'selected' : '' }}>Bangka
                                            </option>
                                            <option value="Belitung" {{ old('kota') == 'Belitung' ? 'selected' : '' }}>
                                                Belitung</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Lampung">
                                            <option value="Bandar Lampung" {{ old('kota') == 'Bandar Lampung' ? 'selected' : '' }}>Bandar Lampung</option>
                                            <option value="Metro" {{ old('kota') == 'Metro' ? 'selected' : '' }}>Metro
                                            </option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Timur">
                                            <option value="Samarinda" {{ old('kota') == 'Samarinda' ? 'selected' : '' }}>
                                                Samarinda</option>
                                            <option value="Balikpapan" {{ old('kota') == 'Balikpapan' ? 'selected' : '' }}>
                                                Balikpapan</option>
                                            <option value="Bontang" {{ old('kota') == 'Bontang' ? 'selected' : '' }}>Bontang
                                            </option>
                                            <option value="Tarakan" {{ old('kota') == 'Tarakan' ? 'selected' : '' }}>Tarakan
                                            </option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Selatan">
                                            <option value="Banjarmasin" {{ old('kota') == 'Banjarmasin' ? 'selected' : '' }}>
                                                Banjarmasin</option>
                                            <option value="Banjarbaru" {{ old('kota') == 'Banjarbaru' ? 'selected' : '' }}>
                                                Banjarbaru</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Selatan">
                                            <option value="Makassar" {{ old('kota') == 'Makassar' ? 'selected' : '' }}>
                                                Makassar</option>
                                            <option value="Parepare" {{ old('kota') == 'Parepare' ? 'selected' : '' }}>
                                                Parepare</option>
                                            <option value="Palopo" {{ old('kota') == 'Palopo' ? 'selected' : '' }}>Palopo
                                            </option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Utara">
                                            <option value="Manado" {{ old('kota') == 'Manado' ? 'selected' : '' }}>Manado
                                            </option>
                                            <option value="Bitung" {{ old('kota') == 'Bitung' ? 'selected' : '' }}>Bitung
                                            </option>
                                            <option value="Tomohon" {{ old('kota') == 'Tomohon' ? 'selected' : '' }}>Tomohon
                                            </option>
                                            <option value="Kotamobagu" {{ old('kota') == 'Kotamobagu' ? 'selected' : '' }}>
                                                Kotamobagu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua">
                                            <option value="Jayapura" {{ old('kota') == 'Jayapura' ? 'selected' : '' }}>
                                                Jayapura</option>
                                            <option value="Sorong" {{ old('kota') == 'Sorong' ? 'selected' : '' }}>Sorong
                                            </option>
                                            <option value="Timika" {{ old('kota') == 'Timika' ? 'selected' : '' }}>Timika
                                            </option>
                                            <option value="Biak" {{ old('kota') == 'Biak' ? 'selected' : '' }}>Biak</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Nusa Tenggara Timur">
                                            <option value="Kupang" {{ old('kota') == 'Kupang' ? 'selected' : '' }}>Kupang
                                            </option>
                                            <option value="Maumere" {{ old('kota') == 'Maumere' ? 'selected' : '' }}>Maumere
                                            </option>
                                            <option value="Ende" {{ old('kota') == 'Ende' ? 'selected' : '' }}>Ende</option>
                                            <option value="Waingapu" {{ old('kota') == 'Waingapu' ? 'selected' : '' }}>
                                                Waingapu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Nusa Tenggara Barat">
                                            <option value="Mataram" {{ old('kota') == 'Mataram' ? 'selected' : '' }}>Mataram
                                            </option>
                                            <option value="Bima" {{ old('kota') == 'Bima' ? 'selected' : '' }}>Bima</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Aceh">
                                            <option value="Banda Aceh" {{ old('kota') == 'Banda Aceh' ? 'selected' : '' }}>
                                                Banda Aceh</option>
                                            <option value="Lhokseumawe" {{ old('kota') == 'Lhokseumawe' ? 'selected' : '' }}>
                                                Lhokseumawe</option>
                                            <option value="Langsa" {{ old('kota') == 'Langsa' ? 'selected' : '' }}>Langsa
                                            </option>
                                            <option value="Sabang" {{ old('kota') == 'Sabang' ? 'selected' : '' }}>Sabang
                                            </option>
                                        </optgroup>
                                        <optgroup label="Provinsi Maluku">
                                            <option value="Ambon" {{ old('kota') == 'Ambon' ? 'selected' : '' }}>Ambon
                                            </option>
                                            <option value="Tual" {{ old('kota') == 'Tual' ? 'selected' : '' }}>Tual</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Maluku Utara">
                                            <option value="Ternate" {{ old('kota') == 'Ternate' ? 'selected' : '' }}>Ternate
                                            </option>
                                            <option value="Tidore Kepulauan" {{ old('kota') == 'Tidore Kepulauan' ? 'selected' : '' }}>Tidore Kepulauan</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Bengkulu">
                                            <option value="Bengkulu" {{ old('kota') == 'Bengkulu' ? 'selected' : '' }}>
                                                Bengkulu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Jambi">
                                            <option value="Jambi" {{ old('kota') == 'Jambi' ? 'selected' : '' }}>Jambi
                                            </option>
                                            <option value="Sungai Penuh" {{ old('kota') == 'Sungai Penuh' ? 'selected' : '' }}>Sungai Penuh</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kepulauan Riau">
                                            <option value="Batam" {{ old('kota') == 'Batam' ? 'selected' : '' }}>Batam
                                            </option>
                                            <option value="Tanjungpinang" {{ old('kota') == 'Tanjungpinang' ? 'selected' : '' }}>Tanjungpinang</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Barat">
                                            <option value="Pontianak" {{ old('kota') == 'Pontianak' ? 'selected' : '' }}>
                                                Pontianak</option>
                                            <option value="Singkawang" {{ old('kota') == 'Singkawang' ? 'selected' : '' }}>
                                                Singkawang</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Tengah">
                                            <option value="Palangka Raya" {{ old('kota') == 'Palangka Raya' ? 'selected' : '' }}>Palangka Raya</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Kalimantan Utara">
                                            <option value="Tanjung Selor" {{ old('kota') == 'Tanjung Selor' ? 'selected' : '' }}>Tanjung Selor</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Tengah">
                                            <option value="Palu" {{ old('kota') == 'Palu' ? 'selected' : '' }}>Palu</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Tenggara">
                                            <option value="Kendari" {{ old('kota') == 'Kendari' ? 'selected' : '' }}>Kendari
                                            </option>
                                            <option value="Baubau" {{ old('kota') == 'Baubau' ? 'selected' : '' }}>Baubau
                                            </option>
                                        </optgroup>
                                        <optgroup label="Provinsi Sulawesi Barat">
                                            <option value="Mamuju" {{ old('kota') == 'Mamuju' ? 'selected' : '' }}>Mamuju
                                            </option>
                                        </optgroup>
                                        <optgroup label="Provinsi Gorontalo">
                                            <option value="Gorontalo" {{ old('kota') == 'Gorontalo' ? 'selected' : '' }}>
                                                Gorontalo</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Barat">
                                            <option value="Manokwari" {{ old('kota') == 'Manokwari' ? 'selected' : '' }}>
                                                Manokwari</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Tengah">
                                            <option value="Nabire" {{ old('kota') == 'Nabire' ? 'selected' : '' }}>Nabire
                                            </option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Pegunungan">
                                            <option value="Jayawijaya" {{ old('kota') == 'Jayawijaya' ? 'selected' : '' }}>
                                                Jayawijaya</option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Selatan">
                                            <option value="Merauke" {{ old('kota') == 'Merauke' ? 'selected' : '' }}>Merauke
                                            </option>
                                        </optgroup>
                                        <optgroup label="Provinsi Papua Barat Daya">
                                            <option value="Sorong" {{ old('kota') == 'Sorong' ? 'selected' : '' }}>Sorong
                                            </option>
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
                                        id="latitude" name="latitude" value="{{ old('latitude') }}" readonly>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                        id="longitude" name="longitude" value="{{ old('longitude') }}" readonly>
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
                                        id="kontak" name="kontak" value="{{ old('kontak') }}"
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
                                        value="{{ old('pembimbing_lapangan') }}"
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
                    <button type="button" class="btn-form btn-secondary-form" onclick="resetForm()">
                        <i class="fas fa-undo"></i>Reset
                    </button>
                </div>

                <button type="submit" form="tempatPklForm" class="btn-form btn-primary-form">
                    <i class="fas fa-save"></i>Simpan Tempat PKL
                </button>
            </div>
        </div>
    </div>

    <!-- Floating Action Buttons -->
    <div class="floating-actions">
        <button type="submit" form="tempatPklForm" class="floating-btn floating-btn-success" title="Simpan Tempat PKL">
            <i class="fas fa-save"></i>
        </button>
        <a href="{{ route('admin.tempat-pkl.index') }}" class="floating-btn floating-btn-primary" title="Kembali ke Daftar">
            <i class="fas fa-list"></i>
        </a>
        <button type="button" onclick="resetForm()" class="floating-btn floating-btn-secondary" title="Reset Form">
            <i class="fas fa-undo"></i>
        </button>
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

            showNotification('Menyimpan data tempat PKL...', 'info');
        });

        // Reset form
        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
                document.getElementById('tempatPklForm').reset();
                showNotification('Form berhasil direset!', 'success');
            }
        }

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
            // Default location (Jakarta, Indonesia)
            const defaultLocation = [-6.2088, 106.8456];

            map = L.map('map').setView(defaultLocation, 12);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add click listener to place marker
            map.on('click', function (e) {
                placeMarker(e.latlng);
            });

            // Try to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const userLocation = [position.coords.latitude, position.coords.longitude];
                    map.setView(userLocation, 12);
                });
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