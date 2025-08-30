@extends('layouts.public')

@section('content')
<style>
    :root {
        --primary-color: #1a202c;
        --secondary-color: #3182ce;
        --accent-color: #4299e1;
        --light-gray: #f7fafc;
        --dark-gray: #718096;
        --glass-bg: rgba(26, 32, 44, 0.95);
        --gradient-primary: linear-gradient(135deg, #1a202c, #3182ce);
        --gradient-light: linear-gradient(135deg, rgba(49, 130, 206, 0.1), rgba(66, 153, 225, 0.05));
    }
    
    /* Enhanced Hero Section with Background Image */
    .agenda-hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        color: white;
        padding: 100px 0;
        min-height: 50vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .agenda-hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(49, 130, 206, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(66, 153, 225, 0.3) 0%, transparent 50%);
        z-index: 1;
    }
    
    .agenda-hero-section .container {
        position: relative;
        z-index: 2;
    }
    
    .agenda-hero-section h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.5);
    }
    
    .agenda-hero-section .lead {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        font-weight: 400;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    /* Enhanced Buttons */
    .btn-hero {
        padding: 15px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        border: none;
        backdrop-filter: blur(10px);
    }
    
    .btn-hero-primary {
        background: rgba(255,255,255,0.95);
        color: var(--primary-color);
    }
    
    .btn-hero-primary:hover {
        background: white;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        color: var(--primary-color);
    }
    
    /* Agenda Section */
    .agenda-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        position: relative;
    }
    
    .agenda-filter {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 40px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .agenda-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 30px;
        height: 100%;
    }
    
    .agenda-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    .agenda-date {
        background: var(--gradient-primary);
        color: white;
        padding: 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .agenda-date::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .agenda-card:hover .agenda-date::before {
        opacity: 1;
    }
    
    .agenda-day {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 5px;
    }
    
    .agenda-month {
        font-size: 1.2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }
    
    .agenda-year {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    .agenda-content {
        padding: 25px;
    }
    
    .agenda-time {
        display: inline-block;
        background: var(--gradient-light);
        color: var(--secondary-color);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 15px;
    }
    
    .agenda-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
        line-height: 1.3;
    }
    
    .agenda-desc {
        color: var(--dark-gray);
        line-height: 1.6;
        margin-bottom: 20px;
    }
    
    .agenda-location {
        display: flex;
        align-items: center;
        color: var(--dark-gray);
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
    
    .agenda-location i {
        margin-right: 8px;
        color: var(--secondary-color);
    }
    
    .agenda-status {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-upcoming {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .status-ongoing {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    .status-completed {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    
    /* Calendar Section */
    .calendar-section {
        padding: 80px 0;
        background: white;
    }
    
    .calendar-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .calendar-header {
        background: var(--gradient-primary);
        color: white;
        padding: 20px;
        text-align: center;
    }
    
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background: #f1f5f9;
    }
    
    .calendar-day-header {
        background: #e2e8f0;
        padding: 15px 5px;
        text-align: center;
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .calendar-day {
        background: white;
        padding: 15px 5px;
        text-align: center;
        min-height: 100px;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .calendar-day:hover {
        background: #f7fafc;
    }
    
    .day-number {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .has-event {
        position: relative;
    }
    
    .has-event::after {
        content: '';
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        width: 6px;
        height: 6px;
        background: var(--secondary-color);
        border-radius: 50%;
    }
    
    .current-day {
        background: var(--gradient-light);
        color: var(--secondary-color);
        font-weight: 700;
    }
    
    .event-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 5px;
    }
    
    /* Pagination */
    .agenda-pagination {
        margin-top: 50px;
    }
    
    .page-link {
        border-radius: 10px;
        margin: 0 5px;
        border: none;
        color: var(--primary-color);
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .page-item.active .page-link {
        background: var(--gradient-primary);
        border: none;
    }
    
    .page-link:hover {
        background: #e2e8f0;
        color: var(--primary-color);
    }
    
    /* Enhanced Buttons */
    .btn-enhanced {
        border-radius: 12px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: none;
        letter-spacing: 0.3px;
    }
    
    .btn-enhanced:hover {
        transform: translateY(-2px);
    }
    
    .btn-primary-enhanced {
        background: var(--gradient-primary);
        border: none;
        box-shadow: 0 8px 25px rgba(49, 130, 206, 0.3);
    }
    
    .btn-primary-enhanced:hover {
        box-shadow: 0 12px 35px rgba(49, 130, 206, 0.4);
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .agenda-hero-section {
            padding: 60px 0;
            text-align: center;
        }
        
        .agenda-hero-section h1 {
            font-size: 2.5rem;
        }
        
        .calendar-day {
            min-height: 80px;
            padding: 10px 2px;
            font-size: 0.9rem;
        }
        
        .agenda-filter .row > div {
            margin-bottom: 15px;
        }
    }
    
    /* Animation Classes */
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease forwards;
    }
    
    .fade-in-up:nth-child(2) { animation-delay: 0.2s; }
    .fade-in-up:nth-child(3) { animation-delay: 0.4s; }
    .fade-in-up:nth-child(4) { animation-delay: 0.6s; }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- Enhanced Hero Section for Agenda Page -->
<section class="agenda-hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="fade-in-up">Agenda & Kegiatan Sekolah</h1>
                <p class="lead fade-in-up">Jadwal lengkap kegiatan, acara, dan event di SMA Negeri 1 Balong</p>
                <div class="fade-in-up">
                    <a href="#agenda" class="btn btn-hero btn-hero-primary me-3">
                        <i class="fas fa-calendar me-2"></i>Lihat Agenda
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-hero btn-hero-outline">
                        <i class="fas fa-home me-2"></i>Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Agenda Filter Section -->
<section class="agenda-section" id="agenda">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Agenda Terbaru</h2>
            <p>Jadwal kegiatan dan acara SMA Negeri 1 Balong</p>
        </div>
        
        <div class="agenda-filter fade-in-up">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="monthFilter" class="form-label">Bulan</label>
                    <select class="form-select" id="monthFilter">
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="categoryFilter" class="form-label">Kategori</label>
                    <select class="form-select" id="categoryFilter">
                        <option value="">Semua Kategori</option>
                        <option value="academic">Akademik</option>
                        <option value="sport">Olahraga</option>
                        <option value="art">Seni & Budaya</option>
                        <option value="ceremony">Upacara</option>
                        <option value="meeting">Rapat</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="statusFilter" class="form-label">Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="upcoming">Akan Datang</option>
                        <option value="ongoing">Sedang Berlangsung</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Agenda Item 1 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                <div class="agenda-card">
                    <div class="agenda-date">
                        <div class="agenda-day">25</div>
                        <div class="agenda-month">Oktober</div>
                        <div class="agenda-year">2024</div>
                    </div>
                    <div class="agenda-content">
                        <span class="agenda-time"><i class="fas fa-clock me-1"></i> 08:00 - 10:00 WIB</span>
                        <span class="agenda-status status-upcoming">Akan Datang</span>
                        <h3 class="agenda-title">Peringatan Hari Sumpah Pemuda</h3>
                        <p class="agenda-desc">Upacara bendera dan pentas seni dalam rangka memperingati Hari Sumpah Pemuda.</p>
                        <div class="agenda-location">
                            <i class="fas fa-map-marker-alt"></i> Lapangan Upacara SMA Negeri 1 Balong
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-enhanced w-100">
                            <i class="fas fa-info-circle me-2"></i>Detail Kegiatan
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Agenda Item 2 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                <div class="agenda-card">
                    <div class="agenda-date">
                        <div class="agenda-day">28</div>
                        <div class="agenda-month">Oktober</div>
                        <div class="agenda-year">2024</div>
                    </div>
                    <div class="agenda-content">
                        <span class="agenda-time"><i class="fas fa-clock me-1"></i> 13:00 - 15:00 WIB</span>
                        <span class="agenda-status status-upcoming">Akan Datang</span>
                        <h3 class="agenda-title">Rapat Komite Sekolah</h3>
                        <p class="agenda-desc">Rapat evaluasi triwulan dan perencanaan kegiatan sekolah periode mendatang.</p>
                        <div class="agenda-location">
                            <i class="fas fa-map-marker-alt"></i> Ruang Meeting Lt. 2
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-enhanced w-100">
                            <i class="fas fa-info-circle me-2"></i>Detail Kegiatan
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Agenda Item 3 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                <div class="agenda-card">
                    <div class="agenda-date">
                        <div class="agenda-day">31</div>
                        <div class="agenda-month">Oktober</div>
                        <div class="agenda-year">2024</div>
                    </div>
                    <div class="agenda-content">
                        <span class="agenda-time"><i class="fas fa-clock me-1"></i> 09:00 - 16:00 WIB</span>
                        <span class="agenda-status status-upcoming">Akan Datang</span>
                        <h3 class="agenda-title">Workshop Teknologi Pendidikan</h3>
                        <p class="agenda-desc">Pelatihan pemanfaatan teknologi dalam pembelajaran untuk guru-guru.</p>
                        <div class="agenda-location">
                            <i class="fas fa-map-marker-alt"></i> Laboratorium Komputer
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-enhanced w-100">
                            <i class="fas fa-info-circle me-2"></i>Detail Kegiatan
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Agenda Item 4 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                <div class="agenda-card">
                    <div class="agenda-date">
                        <div class="agenda-day">05</div>
                        <div class="agenda-month">November</div>
                        <div class="agenda-year">2024</div>
                    </div>
                    <div class="agenda-content">
                        <span class="agenda-time"><i class="fas fa-clock me-1"></i> 08:00 - 14:00 WIB</span>
                        <span class="agenda-status status-upcoming">Akan Datang</span>
                        <h3 class="agenda-title">Festival Seni dan Budaya</h3>
                        <p class="agenda-desc">Pagelaran seni dan budaya nusantara yang menampilkan bakat siswa.</p>
                        <div class="agenda-location">
                            <i class="fas fa-map-marker-alt"></i> Aula Serba Guna
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-enhanced w-100">
                            <i class="fas fa-info-circle me-2"></i>Detail Kegiatan
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Agenda Item 5 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                <div class="agenda-card">
                    <div class="agenda-date">
                        <div class="agenda-day">01</div>
                        <div class="agenda-month">November</div>
                        <div class="agenda-year">2024</div>
                    </div>
                    <div class="agenda-content">
                        <span class="agenda-time"><i class="fas fa-clock me-1"></i> 07:30 - 13:30 WIB</span>
                        <span class="agenda-status status-ongoing">Berlangsung</span>
                        <h3 class="agenda-title">Ujian Tengah Semester</h3>
                        <p class="agenda-desc">Pelaksanaan UTS untuk semua kelas dan mata pelajaran.</p>
                        <div class="agenda-location">
                            <i class="fas fa-map-marker-alt"></i> Ruang Kelas Masing-masing
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-enhanced w-100">
                            <i class="fas fa-info-circle me-2"></i>Detail Kegiatan
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Agenda Item 6 -->
            <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                <div class="agenda-card">
                    <div class="agenda-date">
                        <div class="agenda-day">15</div>
                        <div class="agenda-month">Oktober</div>
                        <div class="agenda-year">2024</div>
                    </div>
                    <div class="agenda-content">
                        <span class="agenda-time"><i class="fas fa-clock me-1"></i> 08:00 - 12:00 WIB</span>
                        <span class="agenda-status status-completed">Selesai</span>
                        <h3 class="agenda-title">Lomba Pramuka Tingkat Kabupaten</h3>
                        <p class="agenda-desc">Perwakilan siswa mengikuti lomba pramuka di tingkat kabupaten.</p>
                        <div class="agenda-location">
                            <i class="fas fa-map-marker-alt"></i> Bumi Perkemahan Kabupaten
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-enhanced w-100">
                            <i class="fas fa-info-circle me-2"></i>Detail Kegiatan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <nav class="agenda-pagination fade-in-up">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</section>

<!-- Calendar Section -->
<section class="calendar-section">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Kalender Akademik</h2>
            <p>Kalender kegiatan akademik SMA Negeri 1 Balong Tahun 2024/2025</p>
        </div>
        
        <div class="calendar-container fade-in-up">
            <div class="calendar-header">
                <h3 class="mb-0">Oktober 2024</h3>
            </div>
            <div class="calendar-grid">
                <div class="calendar-day-header">Senin</div>
                <div class="calendar-day-header">Selasa</div>
                <div class="calendar-day-header">Rabu</div>
                <div class="calendar-day-header">Kamis</div>
                <div class="calendar-day-header">Jumat</div>
                <div class="calendar-day-header">Sabtu</div>
                <div class="calendar-day-header">Minggu</div>
                
                <!-- Empty days for October 2024 (starts on Tuesday) -->
                <div class="calendar-day"></div>
                
                <!-- October 1 -->
                <div class="calendar-day">
                    <span class="day-number">1</span>
                </div>
                
                <!-- October 2 -->
                <div class="calendar-day">
                    <span class="day-number">2</span>
                </div>
                
                <!-- October 3 -->
                <div class="calendar-day">
                    <span class="day-number">3</span>
                </div>
                
                <!-- October 4 -->
                <div class="calendar-day">
                    <span class="day-number">4</span>
                </div>
                
                <!-- October 5 -->
                <div class="calendar-day">
                    <span class="day-number">5</span>
                </div>
                
                <!-- October 6 -->
                <div class="calendar-day">
                    <span class="day-number">6</span>
                </div>
                
                <!-- Continue with the rest of October... -->
                <!-- For brevity, I'll show a few sample days with events -->
                
                <!-- October 15 (has event) -->
                <div class="calendar-day has-event">
                    <span class="day-number">15</span>
                </div>
                
                <!-- More days... -->
                
                <!-- October 25 (has event) -->
                <div class="calendar-day has-event current-day">
                    <span class="day-number">25</span>
                </div>
                
                <!-- More days... -->
                
                <!-- October 31 (has event) -->
                <div class="calendar-day has-event">
                    <span class="day-number">31</span>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="#" class="btn btn-primary-enhanced btn-enhanced">
                <i class="fas fa-download me-2"></i>Download Kalender Lengkap
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const monthFilter = document.getElementById('monthFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    const agendaCards = document.querySelectorAll('.agenda-card');
    
    function filterAgenda() {
        const monthValue = monthFilter.value;
        const categoryValue = categoryFilter.value;
        const statusValue = statusFilter.value;
        
        agendaCards.forEach(card => {
            let show = true;
            
            // In a real application, you would check data attributes on the card
            // For this example, we're just demonstrating the UI
            
            if (show) {
                card.parentElement.style.display = 'block';
            } else {
                card.parentElement.style.display = 'none';
            }
        });
    }
    
    monthFilter.addEventListener('change', filterAgenda);
    categoryFilter.addEventListener('change', filterAgenda);
    statusFilter.addEventListener('change', filterAgenda);
    
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading animation to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.href && !this.href.includes('#')) {
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' + this.textContent.trim();
            }
        });
    });
    
    // Initialize calendar with current day
    const today = new Date();
    if (today.getDate() === 25 && today.getMonth() === 9) { // October is month 9 (0-indexed)
        // Current day is already marked in the HTML
    }
});
</script>
@endsection