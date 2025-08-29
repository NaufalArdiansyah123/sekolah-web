@extends('layouts.public')

@section('title', 'Profil Sekolah')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Profil SMA Negeri 1 Balong</h1>
                <p class="lead mb-4">Excellence in Education - Membentuk generasi yang berkarakter, berprestasi, dan siap menghadapi masa depan dengan dedikasi lebih dari 30 tahun.</p>
            </div>
            <div class="col-lg-4 text-center">
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
                        <i class="fas fa-calendar-alt fa-3x text-info mb-3"></i>
                        <h4>30+</h4>
                        <p class="text-muted">Tahun Pengalaman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tentang Kami</h4>
                    </div>
                    <div class="card-body p-4">
                        <p class="lead mb-4">SMA Negeri 1 Balong adalah institusi pendidikan menengah atas yang telah berkiprah dalam dunia pendidikan selama lebih dari 30 tahun.</p>
                        <p>Kami berkomitmen untuk memberikan pendidikan terbaik guna membentuk generasi penerus bangsa yang unggul dan berkarakter. Dengan motto "Excellence in Education", kami terus berinovasi dalam memberikan layanan pendidikan yang berkualitas.</p>
                        <div class="mt-4">
                            <h6 class="text-primary">Nilai-Nilai Inti:</h6>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <div class="text-center">
                                        <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                                        <h6>Integritas</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <i class="fas fa-star fa-2x text-warning mb-2"></i>
                                        <h6>Keunggulan</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-5">
                <div class="card shadow h-100">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-history me-2"></i>Sejarah Singkat</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold text-primary">1990</h6>
                                    <p class="mb-2">Pendirian sekolah dengan 5 ruang kelas dan 150 siswa pertama</p>
                                </div>
                            </div>
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold text-success">2000</h6>
                                    <p class="mb-2">Pembangunan laboratorium IPA dan perpustakaan modern</p>
                                </div>
                            </div>
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold text-warning">2010</h6>
                                    <p class="mb-2">Terakreditasi A dan mulai program digitalisasi</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="fw-bold text-info">2020-Sekarang</h6>
                                    <p class="mb-0">Era pembelajaran hybrid dan inovasi teknologi pendidikan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="mb-3">Fasilitas Sekolah</h2>
                <p class="text-muted">Fasilitas lengkap dan modern untuk mendukung kegiatan pembelajaran yang optimal</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-chalkboard fa-3x text-primary mb-3"></i>
                        <h5>36 Ruang Kelas</h5>
                        <p class="text-muted">Ruang kelas ber-AC dilengkapi proyektor dan sound system</p>
                        <ul class="list-unstyled text-start">
                            <li><i class="fas fa-check text-success me-2"></i> Proyektor HD</li>
                            <li><i class="fas fa-check text-success me-2"></i> AC & WiFi</li>
                            <li><i class="fas fa-check text-success me-2"></i> Kursi ergonomis</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-flask fa-3x text-success mb-3"></i>
                        <h5>Laboratorium IPA</h5>
                        <p class="text-muted">Lab Fisika, Kimia, dan Biologi dengan peralatan modern</p>
                        <ul class="list-unstyled text-start">
                            <li><i class="fas fa-check text-success me-2"></i> Mikroskop digital</li>
                            <li><i class="fas fa-check text-success me-2"></i> Alat praktikum lengkap</li>
                            <li><i class="fas fa-check text-success me-2"></i> Ruang persiapan</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-desktop fa-3x text-info mb-3"></i>
                        <h5>Lab Komputer</h5>
                        <p class="text-muted">2 laboratorium komputer dengan 40 unit PC modern</p>
                        <ul class="list-unstyled text-start">
                            <li><i class="fas fa-check text-success me-2"></i> Spek gaming</li>
                            <li><i class="fas fa-check text-success me-2"></i> Software terbaru</li>
                            <li><i class="fas fa-check text-success me-2"></i> Internet fiber</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-book fa-3x text-warning mb-3"></i>
                        <h5>Perpustakaan</h5>
                        <p class="text-muted">Koleksi 10,000+ buku dengan ruang baca nyaman</p>
                        <ul class="list-unstyled text-start">
                            <li><i class="fas fa-check text-success me-2"></i> E-book access</li>
                            <li><i class="fas fa-check text-success me-2"></i> Ruang diskusi</li>
                            <li><i class="fas fa-check text-success me-2"></i> Katalog digital</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-running fa-3x text-danger mb-3"></i>
                        <h5>Fasilitas Olahraga</h5>
                        <p class="text-muted">Lapangan multi fungsi dan hall olahraga indoor</p>
                        <ul class="list-unstyled text-start">
                            <li><i class="fas fa-check text-success me-2"></i> Lapangan basket</li>
                            <li><i class="fas fa-check text-success me-2"></i> Lapangan voli</li>
                            <li><i class="fas fa-check text-success me-2"></i> Track lari</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-music fa-3x text-purple mb-3"></i>
                        <h5>Studio Seni</h5>
                        <p class="text-muted">Ruang musik, tari, dan seni rupa untuk pengembangan bakat</p>
                        <ul class="list-unstyled text-start">
                            <li><i class="fas fa-check text-success me-2"></i> Piano & keyboard</li>
                            <li><i class="fas fa-check text-success me-2"></i> Sound system</li>
                            <li><i class="fas fa-check text-success me-2"></i> Panggung mini</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Achievements Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h3 class="mb-4"><i class="fas fa-trophy me-2"></i>Prestasi Terbaru</h3>
                
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="achievement-badge bg-warning text-white p-3 rounded-circle">
                                    <i class="fas fa-medal fa-2x"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-1">Juara 1 Olimpiade Sains Nasional 2024</h5>
                                <p class="text-muted mb-1">Bidang Matematika - Tingkat Nasional</p>
                                <small><i class="fas fa-calendar me-1"></i> Agustus 2024</small>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="badge bg-warning fs-6">Nasional</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="achievement-badge bg-success text-white p-3 rounded-circle">
                                    <i class="fas fa-leaf fa-2x"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-1">Sekolah Adiwiyata Tingkat Provinsi</h5>
                                <p class="text-muted mb-1">Penghargaan sekolah berwawasan lingkungan</p>
                                <small><i class="fas fa-calendar me-1"></i> Juni 2024</small>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="badge bg-success fs-6">Provinsi</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="achievement-badge bg-info text-white p-3 rounded-circle">
                                    <i class="fas fa-comments fa-2x"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-1">Juara Umum Debat Bahasa Inggris</h5>
                                <p class="text-muted mb-1">English Debate Competition 2024</p>
                                <small><i class="fas fa-calendar me-1"></i> Juli 2024</small>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="badge bg-info fs-6">Kota</span>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i>Lihat Semua Prestasi
                </a>
            </div>

            <!-- School Info Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-building me-2"></i>Informasi Sekolah</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item mb-3">
                            <div class="d-flex">
                                <i class="fas fa-calendar-plus fa-lg text-primary me-3 mt-1"></i>
                                <div>
                                    <strong>Tahun Berdiri</strong><br>
                                    <span class="text-muted">1990 (34 tahun)</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-item mb-3">
                            <div class="d-flex">
                                <i class="fas fa-award fa-lg text-success me-3 mt-1"></i>
                                <div>
                                    <strong>Akreditasi</strong><br>
                                    <span class="text-muted">A (Unggul)</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-item mb-3">
                            <div class="d-flex">
                                <i class="fas fa-user-tie fa-lg text-warning me-3 mt-1"></i>
                                <div>
                                    <strong>Kepala Sekolah</strong><br>
                                    <span class="text-muted">Drs. Ahmad Sudrajat, M.Pd</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-item mb-3">
                            <div class="d-flex">
                                <i class="fas fa-graduation-cap fa-lg text-info me-3 mt-1"></i>
                                <div>
                                    <strong>Program Studi</strong><br>
                                    <span class="text-muted">IPA, IPS, Bahasa & Budaya</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="d-flex">
                                <i class="fas fa-map-marker-alt fa-lg text-danger me-3 mt-1"></i>
                                <div>
                                    <strong>Alamat</strong><br>
                                    <span class="text-muted">Jl. Pendidikan No. 123, Balong</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Kontak</h5>
                    </div>
                    <div class="card-body">
                        <div class="contact-item mb-3">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <strong>Telepon:</strong><br>
                            <span class="ms-4">(021) 4567890</span>
                        </div>
                        <div class="contact-item mb-3">
                            <i class="fas fa-envelope text-success me-2"></i>
                            <strong>Email:</strong><br>
                            <span class="ms-4">info@sman1balong.sch.id</span>
                        </div>
                        <div class="contact-item mb-3">
                            <i class="fas fa-globe text-info me-2"></i>
                            <strong>Website:</strong><br>
                            <span class="ms-4">www.sman1balong.sch.id</span>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="text-primary"><i class="fab fa-facebook-f fa-lg"></i></a>
                                <a href="#" class="text-info"><i class="fab fa-instagram fa-lg"></i></a>
                                <a href="#" class="text-primary"><i class="fab fa-twitter fa-lg"></i></a>
                                <a href="#" class="text-danger"><i class="fab fa-youtube fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="mb-3">Pimpinan Sekolah</h2>
                <p class="text-muted">Tim kepemimpinan yang berpengalaman dalam mengelola institusi pendidikan</p>
            </div>
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-md-4">
                <div class="card shadow text-center h-100">
                    <div class="card-body p-4">
                        <div class="leadership-avatar bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        <h5>Singgih Wibowo A Se.MM</h5>
                        <p class="text-primary">Kepala Sekolah</p>
                        <p class="text-muted small">Pengalaman 25 tahun di bidang pendidikan</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow text-center h-100">
                    <div class="card-body p-4">
                        <div class="leadership-avatar bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        <h5>Dr. Siti Nurhaliza, S.Pd</h5>
                        <p class="text-success">Wakil Kepala Sekolah</p>
                        <p class="text-muted small">Bidang Kurikulum dan Pembelajaran</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow text-center h-100">
                    <div class="card-body p-4">
                        <div class="leadership-avatar bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        <h5>M. Rizky Pratama, S.Pd</h5>
                        <p class="text-warning">Wakil Kepala Sekolah</p>
                        <p class="text-muted small">Bidang Kesiswaan dan Ekstrakurikuler</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3>Ingin Bergabung dengan Keluarga Besar Kami?</h3>
                <p class="lead mb-0">Daftarkan putra-putri Anda di SMA Negeri 1 Balong dan rasakan pengalaman pendidikan terbaik</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('public.academic.programs') }}" class="btn btn-light btn-lg me-2">Program Studi</a>
                <a href="#" class="btn btn-outline-light btn-lg">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
.hero-section {
    background: linear-gradient(135deg, #0d6efd 0%, #004d9e 100%);
    color: white;
    padding: 4rem 0;
}

.card {
    transition: transform 0.3s;
    border: none;
    border-radius: 10px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #0d6efd, #20c997);
}

.timeline-item {
    position: relative;
}

.timeline-marker {
    position: absolute;
    left: -16px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid white;
}

.achievement-badge {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-item {
    padding: 10px 0;
    border-bottom: 1px solid #f8f9fa;
}

.info-item:last-child {
    border-bottom: none;
}

.contact-item {
    padding: 8px 0;
}

.text-purple {
    color: #6f42c1 !important;
}
</style>