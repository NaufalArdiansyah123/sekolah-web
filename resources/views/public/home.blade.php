@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Selamat Datang di SMA Negeri 1 Balong</h1>
                <p class="lead mb-4">Excellence in Education - Membentuk generasi yang berkarakter, berprestasi, dan siap menghadapi masa depan.</p>
                <a href="{{ route('about.profile') }}" class="btn btn-light btn-lg me-3">
                    <i class="fas fa-info-circle me-2"></i>Tentang Kami
                </a>
                <a href="{{ route('news.index') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-newspaper me-2"></i>Berita Terkini
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-school" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h4>1,200+</h4>
                        <p class="text-muted">Siswa Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <i class="fas fa-chalkboard-teacher fa-3x text-success mb-3"></i>
                        <h4>80+</h4>
                        <p class="text-muted">Tenaga Pengajar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                        <h4>150+</h4>
                        <p class="text-muted">Prestasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <i class="fas fa-building fa-3x text-info mb-3"></i>
                        <h4>25+</h4>
                        <p class="text-muted">Fasilitas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Content -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Berita Terbaru -->
            <div class="col-md-8 mb-4">
                <h3 class="mb-4"><i class="fas fa-newspaper me-2"></i>Berita Terbaru</h3>
                
                <div class="card shadow mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="bg-primary d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-image fa-3x text-white"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Penerimaan Siswa Baru 2024/2025</h5>
                                <p class="card-text">Pendaftaran siswa baru telah dibuka dengan sistem online. Daftar sekarang untuk bergabung dengan keluarga besar SMA Negeri 1.</p>
                                <p class="card-text"><small class="text-muted">2 jam yang lalu</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="bg-success d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-trophy fa-3x text-white"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Juara 1 Olimpiade Matematika Tingkat Provinsi</h5>
                                <p class="card-text">Siswa SMA Negeri 1 berhasil meraih juara 1 dalam kompetisi olimpiade matematika tingkat provinsi.</p>
                                <p class="card-text"><small class="text-muted">1 hari yang lalu</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('news.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i>Lihat Semua Berita
                </a>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Pengumuman -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Pengumuman</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <strong>Libur Semester</strong><br>
                                <small class="text-muted">Libur semester dimulai tanggal 15 Desember 2024</small>
                            </li>
                            <li class="mb-3">
                                <strong>Ujian Tengah Semester</strong><br>
                                <small class="text-muted">UTS akan dilaksanakan tanggal 1-8 November 2024</small>
                            </li>
                            <li>
                                <strong>Rapat Orang Tua</strong><br>
                                <small class="text-muted">Rapat komite sekolah, Sabtu 28 Oktober 2024</small>
                            </li>
                        </ul>
                        <a href="{{ route('announcements.index') }}" class="btn btn-sm btn-outline-warning mt-3">
                            Lihat Semua
                        </a>
                    </div>
                </div>

                <!-- Agenda -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Agenda</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <strong>25 Oktober 2024</strong><br>
                                <small>Peringatan Hari Sumpah Pemuda</small>
                            </li>
                            <li class="mb-3">
                                <strong>31 Oktober 2024</strong><br>
                                <small>Workshop Teknologi Pendidikan</small>
                            </li>
                            <li>
                                <strong>5 November 2024</strong><br>
                                <small>Festival Seni dan Budaya</small>
                            </li>
                        </ul>
                        <a href="{{ route('agenda.index') }}" class="btn btn-sm btn-outline-info mt-3">
                            Lihat Agenda
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-link me-2"></i>Quick Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('downloads.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                            <a href="{{ route('gallery.photos') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-images me-2"></i>Galeri
                            </a>
                            <a href="{{ route('extracurriculars.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-users me-2"></i>Ekstrakurikuler
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <h3 class="text-center mb-5">Fitur Unggulan</h3>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-laptop-code fa-3x text-primary mb-3"></i>
                        <h5>Learning Management System</h5>
                        <p>Platform pembelajaran digital dengan materi online, tugas, dan ujian CBT.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-qrcode fa-3x text-success mb-3"></i>
                        <h5>Absensi QR Code</h5>
                        <p>Sistem absensi modern menggunakan QR Code untuk efisiensi dan akurasi data.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                        <h5>Analitik Akademik</h5>
                        <p>Dashboard analitik untuk monitoring progress akademik siswa secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection