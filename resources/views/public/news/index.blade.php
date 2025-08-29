@extends('layouts.public')

@section('title', 'Berita Terbaru')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Berita Terbaru</h1>
                <p class="lead mb-4">Informasi terkini seputar kegiatan, prestasi, dan perkembangan SMA Negeri 1 Balong.</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-newspaper" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</section>

<!-- News Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main News Content -->
            <div class="col-lg-8">
                <!-- Featured News -->
                <div class="card shadow mb-5">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <img src="https://via.placeholder.com/300x200" class="img-fluid rounded-start h-100" alt="Featured News" style="object-fit: cover;">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">Utama</span>
                                <h4 class="card-title">SMA Negeri 1 Balong Raih Juara Umum Olimpiade Sains Nasional 2024</h4>
                                <p class="card-text">Prestasi membanggakan kembali ditorehkan oleh siswa-siswi SMA Negeri 1 Balong dengan meraih 5 medali emas dan 3 medali perak dalam Olimpiade Sains Nasional 2024.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><i class="fas fa-calendar me-1"></i> 15 September 2024</small>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- News Grid -->
                <div class="row g-4">
                    <!-- News Item 1 -->
                    <div class="col-md-6">
                        <div class="card shadow h-100">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="News Image">
                            <div class="card-body">
                                <span class="badge bg-success mb-2">Prestasi</span>
                                <h5 class="card-title">Tim Basket Putra Juara Turnamen Antarsekolah</h5>
                                <p class="card-text">Tim basket putra SMA Negeri 1 Balong berhasil menjadi juara dalam turnamen antarsekolah se-kota yang diselenggarakan akhir pekan lalu.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><i class="fas fa-calendar me-1"></i> 10 September 2024</small>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Baca</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- News Item 2 -->
                    <div class="col-md-6">
                        <div class="card shadow h-100">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="News Image">
                            <div class="card-body">
                                <span class="badge bg-info mb-2">Kegiatan</span>
                                <h5 class="card-title">Peringatan Hari Kemerdekaan RI ke-79 di SMA Negeri 1 Balong</h5>
                                <p class="card-text">Berbagai lomba dan kegiatan seru digelar dalam rangka memeriahkan Hari Kemerdekaan RI ke-79 di lingkungan SMA Negeri 1 Balong.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><i class="fas fa-calendar me-1"></i> 5 September 2024</small>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Baca</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- News Item 3 -->
                    <div class="col-md-6">
                        <div class="card shadow h-100">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="News Image">
                            <div class="card-body">
                                <span class="badge bg-warning mb-2">Akademik</span>
                                <h5 class="card-title">Workshop Pengembangan Kurikulum untuk Guru</h5>
                                <p class="card-text">Sebanyak 80 guru SMA Negeri 1 Balong mengikuti workshop pengembangan kurikulum untuk meningkatkan kualitas pembelajaran.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><i class="fas fa-calendar me-1"></i> 3 September 2024</small>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Baca</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- News Item 4 -->
                    <div class="col-md-6">
                        <div class="card shadow h-100">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="News Image">
                            <div class="card-body">
                                <span class="badge bg-danger mb-2">Beasiswa</span>
                                <h5 class="card-title">20 Siswa Berprestasi Terima Beasiswa Pendidikan</h5>
                                <p class="card-text">Sebanyak 20 siswa berprestasi dari keluarga kurang mampu menerima beasiswa pendidikan dari Yayasan Peduli Pendidikan Indonesia.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><i class="fas fa-calendar me-1"></i> 1 September 2024</small>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Baca</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Sebelumnya</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Selanjutnya</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Kategori Berita</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-2">
                            <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                <span>Prestasi</span>
                                <span class="badge bg-primary">12</span>
                            </a>
                            <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                <span>Kegiatan</span>
                                <span class="badge bg-primary">8</span>
                            </a>
                            <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                <span>Akademik</span>
                                <span class="badge bg-primary">5</span>
                            </a>
                            <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                <span>Beasiswa</span>
                                <span class="badge bg-primary">3</span>
                            </a>
                            <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                <span>Olahraga</span>
                                <span class="badge bg-primary">7</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Popular News -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Berita Populer</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Penerimaan Peserta Didik Baru 2024/2025 Dibuka</h6>
                                </div>
                                <small class="text-muted"><i class="fas fa-eye me-1"></i> 1,245 views</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Workshop Digital Marketing untuk Siswa Kelas XII</h6>
                                </div>
                                <small class="text-muted"><i class="fas fa-eye me-1"></i> 987 views</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Siswa SMA Negeri 1 Balong Lolos OSN Tingkat Nasional</h6>
                                </div>
                                <small class="text-muted"><i class="fas fa-eye me-1"></i> 856 views</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Pentas Seni Tahun 2024: "Kreasi Nusantara"</h6>
                                </div>
                                <small class="text-muted"><i class="fas fa-eye me-1"></i> 732 views</small>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Archive -->
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-archive me-2"></i>Arsip Berita</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select mb-3">
                            <option>Pilih Tahun</option>
                            <option selected>2024</option>
                            <option>2023</option>
                            <option>2022</option>
                        </select>
                        <select class="form-select">
                            <option>Pilih Bulan</option>
                            <option selected>September</option>
                            <option>Agustus</option>
                            <option>Juli</option>
                        </select>
                        <div class="d-grid gap-2 mt-3">
                            <button class="btn btn-outline-primary">Lihat Arsip</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3 class="mb-3">Berlangganan Newsletter</h3>
                <p class="text-muted mb-4">Dapatkan update berita dan informasi terbaru dari SMA Negeri 1 Balong langsung ke email Anda.</p>
                <form class="row g-3 justify-content-center">
                    <div class="col-md-8">
                        <input type="email" class="form-control form-control-lg" placeholder="Masukkan alamat email Anda">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Berlangganan</button>
                    </div>
                </form>
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

.badge {
    font-size: 0.7rem;
}

.list-group-item {
    border: none;
    padding: 1rem 0.5rem;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>