@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Kalender Akademik</h1>
                <p class="lead mb-4">Jadwal lengkap kegiatan akademik dan non-akademik SMA Negeri 1 Balong tahun ajaran 2024/2025.</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-calendar-alt" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="form-label">Semester:</label>
                                <select class="form-select">
                                    <option value="all">Semua Semester</option>
                                    <option value="ganjil" selected>Semester Ganjil</option>
                                    <option value="genap">Semester Genap</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kategori:</label>
                                <select class="form-select">
                                    <option value="all">Semua Kategori</option>
                                    <option value="akademik">Akademik</option>
                                    <option value="ujian">Ujian</option>
                                    <option value="libur">Libur</option>
                                    <option value="kegiatan">Kegiatan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bulan:</label>
                                <select class="form-select">
                                    <option value="all">Semua Bulan</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calendar Grid Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Semester Ganjil -->
            <div class="col-lg-6 mb-5">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Semester Ganjil 2024/2025</h4>
                    </div>
                    <div class="card-body">
                        <!-- Juli 2024 -->
                        <div class="mb-4">
                            <h6 class="text-primary fw-bold mb-3">Juli 2024</h6>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-primary text-white text-center me-3">
                                        <div class="fw-bold">15</div>
                                        <small>Jul</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Awal Tahun Ajaran</h6>
                                        <p class="text-muted small mb-0">Hari pertama masuk sekolah tahun ajaran baru</p>
                                    </div>
                                </div>
                            </div>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-info text-white text-center me-3">
                                        <div class="fw-bold">22-24</div>
                                        <small>Jul</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Masa Pengenalan Lingkungan Sekolah</h6>
                                        <p class="text-muted small mb-0">MPLS untuk siswa kelas X</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Agustus 2024 -->
                        <div class="mb-4">
                            <h6 class="text-primary fw-bold mb-3">Agustus 2024</h6>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-success text-white text-center me-3">
                                        <div class="fw-bold">17</div>
                                        <small>Agu</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Peringatan HUT RI</h6>
                                        <p class="text-muted small mb-0">Upacara dan lomba kemerdekaan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-warning text-white text-center me-3">
                                        <div class="fw-bold">25</div>
                                        <small>Agu</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Rapat Komite Sekolah</h6>
                                        <p class="text-muted small mb-0">Rapat koordinasi dengan orang tua siswa</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- September 2024 -->
                        <div class="mb-4">
                            <h6 class="text-primary fw-bold mb-3">September 2024</h6>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-danger text-white text-center me-3">
                                        <div class="fw-bold">15-22</div>
                                        <small>Sep</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Penilaian Tengah Semester</h6>
                                        <p class="text-muted small mb-0">Ujian tengah semester ganjil</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Oktober 2024 -->
                        <div class="mb-4">
                            <h6 class="text-primary fw-bold mb-3">Oktober 2024</h6>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-success text-white text-center me-3">
                                        <div class="fw-bold">28</div>
                                        <small>Okt</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Hari Sumpah Pemuda</h6>
                                        <p class="text-muted small mb-0">Upacara dan kegiatan kepemudaan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Semester Genap -->
            <div class="col-lg-6 mb-5">
                <div class="card shadow h-100">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Semester Genap 2024/2025</h4>
                    </div>
                    <div class="card-body">
                        <!-- Januari 2025 -->
                        <div class="mb-4">
                            <h6 class="text-success fw-bold mb-3">Januari 2025</h6>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-primary text-white text-center me-3">
                                        <div class="fw-bold">8</div>
                                        <small>Jan</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Awal Semester Genap</h6>
                                        <p class="text-muted small mb-0">Hari pertama masuk semester genap</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Februari 2025 -->
                        <div class="mb-4">
                            <h6 class="text-success fw-bold mb-3">Februari 2025</h6>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-info text-white text-center me-3">
                                        <div class="fw-bold">14</div>
                                        <small>Feb</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Hari Kasih Sayang</h6>
                                        <p class="text-muted small mb-0">Kegiatan sosial dan bakti sosial</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Maret 2025 -->
                        <div class="mb-4">
                            <h6 class="text-success fw-bold mb-3">Maret 2025</h6>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-danger text-white text-center me-3">
                                        <div class="fw-bold">10-17</div>
                                        <small>Mar</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Penilaian Tengah Semester</h6>
                                        <p class="text-muted small mb-0">Ujian tengah semester genap</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- April 2025 -->
                        <div class="mb-4">
                            <h6 class="text-success fw-bold mb-3">April 2025</h6>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-warning text-white text-center me-3">
                                        <div class="fw-bold">21</div>
                                        <small>Apr</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Hari Kartini</h6>
                                        <p class="text-muted small mb-0">Peringatan hari kartini dan lomba busana</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mei 2025 -->
                        <div class="mb-4">
                            <h6 class="text-success fw-bold mb-3">Mei 2025</h6>
                            <div class="event-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="date-badge bg-danger text-white text-center me-3">
                                        <div class="fw-bold">5-12</div>
                                        <small>Mei</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Ujian Akhir Semester</h6>
                                        <p class="text-muted small mb-0">Ujian akhir semester genap</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Event Categories -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="mb-3">Kategori Kegiatan</h2>
                <p class="text-muted">Berbagai jenis kegiatan yang diselenggarakan selama tahun ajaran</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-book-open fa-3x text-primary mb-3"></i>
                        <h5>Kegiatan Akademik</h5>
                        <p class="text-muted">Ujian, penilaian, dan kegiatan pembelajaran</p>
                        <span class="badge bg-primary">15 Kegiatan</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card shadow text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-users fa-3x text-success mb-3"></i>
                        <h5>Ekstrakurikuler</h5>
                        <p class="text-muted">Lomba, kompetisi, dan kegiatan siswa</p>
                        <span class="badge bg-success">8 Kegiatan</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card shadow text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-flag fa-3x text-warning mb-3"></i>
                        <h5>Hari Besar</h5>
                        <p class="text-muted">Peringatan hari besar nasional</p>
                        <span class="badge bg-warning">6 Kegiatan</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card shadow text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-umbrella-beach fa-3x text-info mb-3"></i>
                        <h5>Libur Sekolah</h5>
                        <p class="text-muted">Periode libur dan cuti bersama</p>
                        <span class="badge bg-info">4 Periode</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Monthly Calendar -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="mb-3">Kalender Bulanan</h2>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active">Oktober 2024</button>
                    <button type="button" class="btn btn-outline-primary">November 2024</button>
                    <button type="button" class="btn btn-outline-primary">Desember 2024</button>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Oktober 2024</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3">Minggu</th>
                                <th class="text-center py-3">Senin</th>
                                <th class="text-center py-3">Selasa</th>
                                <th class="text-center py-3">Rabu</th>
                                <th class="text-center py-3">Kamis</th>
                                <th class="text-center py-3">Jumat</th>
                                <th class="text-center py-3">Sabtu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center py-4 text-muted">29</td>
                                <td class="text-center py-4 text-muted">30</td>
                                <td class="text-center py-4">1</td>
                                <td class="text-center py-4">2</td>
                                <td class="text-center py-4">3</td>
                                <td class="text-center py-4">4</td>
                                <td class="text-center py-4">5</td>
                            </tr>
                            <tr>
                                <td class="text-center py-4">6</td>
                                <td class="text-center py-4">7</td>
                                <td class="text-center py-4">8</td>
                                <td class="text-center py-4">9</td>
                                <td class="text-center py-4">10</td>
                                <td class="text-center py-4">11</td>
                                <td class="text-center py-4">12</td>
                            </tr>
                            <tr>
                                <td class="text-center py-4">13</td>
                                <td class="text-center py-4">14</td>
                                <td class="text-center py-4">15</td>
                                <td class="text-center py-4">16</td>
                                <td class="text-center py-4">17</td>
                                <td class="text-center py-4">18</td>
                                <td class="text-center py-4">19</td>
                            </tr>
                            <tr>
                                <td class="text-center py-4">20</td>
                                <td class="text-center py-4">21</td>
                                <td class="text-center py-4">22</td>
                                <td class="text-center py-4">23</td>
                                <td class="text-center py-4">24</td>
                                <td class="text-center py-4">25</td>
                                <td class="text-center py-4">26</td>
                            </tr>
                            <tr>
                                <td class="text-center py-4">27</td>
                                <td class="text-center py-4 bg-warning">
                                    <div class="fw-bold">28</div>
                                    <small class="text-dark">Sumpah Pemuda</small>
                                </td>
                                <td class="text-center py-4">29</td>
                                <td class="text-center py-4">30</td>
                                <td class="text-center py-4 bg-info">
                                    <div class="fw-bold text-white">31</div>
                                    <small class="text-white">Workshop</small>
                                </td>
                                <td class="text-center py-4 text-muted">1</td>
                                <td class="text-center py-4 text-muted">2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Events -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3 class="mb-4"><i class="fas fa-clock me-2"></i>Kegiatan Mendatang</h3>
                
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="date-display bg-primary text-white p-3 rounded">
                                    <div class="h4 mb-0">28</div>
                                    <small>Oktober</small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-1">Peringatan Hari Sumpah Pemuda</h5>
                                <p class="text-muted mb-1">Upacara bendera dan lomba kegiatan kepemudaan</p>
                                <small><i class="fas fa-clock me-1"></i> 07:00 - 12:00 WIB</small>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="badge bg-warning">Hari Besar</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="date-display bg-info text-white p-3 rounded">
                                    <div class="h4 mb-0">31</div>
                                    <small>Oktober</small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-1">Workshop Teknologi Pendidikan</h5>
                                <p class="text-muted mb-1">Pelatihan teknologi pembelajaran untuk guru dan siswa</p>
                                <small><i class="fas fa-clock me-1"></i> 08:00 - 16:00 WIB</small>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="badge bg-info">Workshop</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <div class="date-display bg-success text-white p-3 rounded">
                                    <div class="h4 mb-0">5</div>
                                    <small>November</small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-1">Festival Seni dan Budaya</h5>
                                <p class="text-muted mb-1">Pentas seni siswa dan pameran karya budaya</p>
                                <small><i class="fas fa-clock me-1"></i> 13:00 - 21:00 WIB</small>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="badge bg-success">Kegiatan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Legend -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Keterangan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-primary me-2">■</span> Kegiatan Akademik
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-success me-2">■</span> Ekstrakurikuler
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-warning me-2">■</span> Hari Besar
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-info me-2">■</span> Workshop/Seminar
                        </div>
                        <div class="mb-2">
                            <span class="badge bg-danger me-2">■</span> Ujian/Penilaian
                        </div>
                        <div class="mb-0">
                            <span class="badge bg-secondary me-2">■</span> Libur
                        </div>
                    </div>
                </div>

                <!-- Download -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-download me-2"></i>Download</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-pdf me-2"></i>Kalender Akademik PDF
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-calendar-plus me-2"></i>Import ke Google Calendar
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-file-excel me-2"></i>Export Excel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <h4 class="text-primary mb-0">180</h4>
                                <small>Hari Efektif</small>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-success mb-0">36</h4>
                                <small>Minggu Efektif</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning mb-0">15</h4>
                                <small>Hari Libur</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-info mb-0">8</h4>
                                <small>Ujian/UTS</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Important Dates -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-5">Tanggal Penting</h3>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Ujian & Penilaian</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item mb-3">
                                <div class="row">
                                    <div class="col-3">
                                        <span class="badge bg-danger">15-22 Sep</span>
                                    </div>
                                    <div class="col-9">
                                        <strong>PTS Semester Ganjil</strong><br>
                                        <small class="text-muted">Penilaian Tengah Semester</small>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item mb-3">
                                <div class="row">
                                    <div class="col-3">
                                        <span class="badge bg-danger">1-8 Nov</span>
                                    </div>
                                    <div class="col-9">
                                        <strong>UTS Semester Ganjil</strong><br>
                                        <small class="text-muted">Ujian Tengah Semester</small>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item mb-3">
                                <div class="row">
                                    <div class="col-3">
                                        <span class="badge bg-danger">5-15 Des</span>
                                    </div>
                                    <div class="col-9">
                                        <strong>UAS Semester Ganjil</strong><br>
                                        <small class="text-muted">Ujian Akhir Semester</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-umbrella-beach me-2"></i>Libur & Cuti</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item mb-3">
                                <div class="row">
                                    <div class="col-3">
                                        <span class="badge bg-secondary">17 Agu</span>
                                    </div>
                                    <div class="col-9">
                                        <strong>Hari Kemerdekaan</strong><br>
                                        <small class="text-muted">Libur Nasional</small>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item mb-3">
                                <div class="row">
                                    <div class="col-3">
                                        <span class="badge bg-secondary">16 Des</span>
                                    </div>
                                    <div class="col-9">
                                        <strong>Maulid Nabi</strong><br>
                                        <small class="text-muted">Libur Keagamaan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item mb-3">
                                <div class="row">
                                    <div class="col-3">
                                        <span class="badge bg-secondary">18 Des - 7 Jan</span>
                                    </div>
                                    <div class="col-9">
                                        <strong>Libur Semester</strong><br>
                                        <small class="text-muted">Libur Akhir Semester</small>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                <h3>Butuh Informasi Lebih Lanjut?</h3>
                <p class="lead mb-0">Hubungi kami untuk mendapatkan informasi lengkap tentang kalender akademik</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg">Hubungi Kami <i class="fas fa-arrow-right ms-2"></i></a>
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

.program-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.event-item {
    border-left: 3px solid #e9ecef;
    padding-left: 1rem;
}

.date-badge {
    border-radius: 8px;
    padding: 8px 12px;
    min-width: 60px;
}

.date-display {
    border-radius: 10px;
}

.timeline-item {
    position: relative;
}

.table td {
    vertical-align: middle;
    height: 80px;
}
</style>