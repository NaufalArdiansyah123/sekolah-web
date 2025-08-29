@extends('layouts.public')

@section('title', 'Profil Sekolah')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4"> Profile SMA Negeri 1 Balong</h1>
                <p class="lead mb-4">Excellence in Education - Membentuk generasi yang berkarakter, berprestasi, dan siap menghadapi masa depan.</p>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-school" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<!-- <section class="py-5">
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
</section> -->

<!-- About Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="text-center mb-4">Tentang Kami</h2>
                <p class="lead">SMA Negeri 1 Balong adalah institusi pendidikan menengah atas yang telah berkiprah dalam dunia pendidikan selama lebih dari 30 tahun. Kami berkomitmen untuk memberikan pendidikan terbaik guna membentuk generasi penerus bangsa yang unggul dan berkarakter.</p>
                
                <h4 class="mt-5">Sejarah Singkat</h4>
                <p>Didirikan pada tahun 1990, SMA Negeri 1 Balong awalnya hanya memiliki 5 ruang kelas dengan 150 siswa. Seiring dengan perkembangan zaman dan meningkatnya kepercayaan masyarakat, kini kami telah berkembang menjadi sekolah dengan fasilitas lengkap dan jumlah siswa lebih dari 1.200 orang.</p>
                
                <h4 class="mt-5">Fasilitas Sekolah</h4>
                <ul>
                    <li>Ruang kelas ber-AC dan dilengkapi proyektor</li>
                    <li>Laboratorium IPA (Fisika, Kimia, Biologi)</li>
                    <li>Laboratorium Komputer</li>
                    <li>Perpustakaan dengan koleksi lebih dari 10.000 buku</li>
                    <li>Lapangan olahraga (sepak bola, basket, voli)</li>
                    <li>Ruang kesenian dan musik</li>
                    <li>Kantin sehat</li>
                    <li>Mushola</li>
                </ul>
                
                <h4 class="mt-5">Prestasi</h4>
                <p>Selama tiga dekade, SMA Negeri 1 Balong telah meraih berbagai prestasi baik di tingkat regional maupun nasional, termasuk:</p>
                <ul>
                    <li>Juara 1 Olimpiade Sains Nasional 2022</li>
                    <li>Sekolah Adiwiyata tingkat provinsi 2021</li>
                    <li>Juara umum lomba debat bahasa Inggris tingkat kota</li>
                    <li>Berbagai prestasi dalam bidang olahraga dan seni</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection