

<?php $__env->startSection('content'); ?>
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
    .history-hero-section {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        color: white;
        padding: 100px 0;
        min-height: 50vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .history-hero-section::before {
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
    
    .history-hero-section .container {
        position: relative;
        z-index: 2;
    }
    
    .history-hero-section h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.5);
    }
    
    .history-hero-section .lead {
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
    
    /* Enhanced Timeline Section */
    .timeline-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        position: relative;
    }
    
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background-color: var(--secondary-color);
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -3px;
        border-radius: 10px;
    }
    
    .timeline-card {
        position: relative;
        width: 50%;
        margin-bottom: 50px;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .timeline-card.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    .timeline-card::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        background-color: white;
        border: 4px solid var(--secondary-color);
        border-radius: 50%;
        top: 15px;
        z-index: 1;
    }
    
    .timeline-card-left {
        left: 0;
        padding-right: 40px;
    }
    
    .timeline-card-right {
        left: 50%;
        padding-left: 40px;
    }
    
    .timeline-card-left::after {
        right: -13px;
    }
    
    .timeline-card-right::after {
        left: -13px;
    }
    
    .timeline-content {
        padding: 20px 30px;
        background-color: white;
        position: relative;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .timeline-content:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .timeline-year {
        font-weight: 800;
        font-size: 1.8rem;
        color: var(--secondary-color);
        margin-bottom: 10px;
    }
    
    .timeline-title {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 15px;
        color: var(--primary-color);
    }
    
    .timeline-desc {
        color: var(--dark-gray);
        line-height: 1.6;
    }
    
    /* Vision Mission Section */
    .vm-section {
        padding: 80px 0;
        background: white;
    }
    
    .vm-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .vm-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(49, 130, 206, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .vm-card:hover::before {
        opacity: 1;
    }
    
    .vm-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    }
    
    .vm-card i {
        margin-bottom: 25px;
        padding: 25px;
        border-radius: 50%;
        background: var(--gradient-light);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 2;
    }
    
    .vm-card:hover i {
        transform: scale(1.2) rotate(10deg);
        background: linear-gradient(135deg, rgba(49, 130, 206, 0.2), rgba(66, 153, 225, 0.1));
    }
    
    .vm-card h5 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
    }
    
    .vm-card p {
        color: var(--dark-gray);
        line-height: 1.6;
        position: relative;
        z-index: 2;
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
        .history-hero-section {
            padding: 60px 0;
            text-align: center;
        }
        
        .history-hero-section h1 {
            font-size: 2.5rem;
        }
        
        .timeline::after {
            left: 31px;
        }
        
        .timeline-card {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }
        
        .timeline-card::after {
            left: 18px;
        }
        
        .timeline-card-left, .timeline-card-right {
            left: 0;
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

<!-- Enhanced Hero Section for History Page -->
<section class="history-hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="fade-in-up">Sejarah SMK PGRI 2 PONOROGO</h1>
                <p class="lead fade-in-up">Menelusuri perjalanan panjang dan prestasi gemilang sejak berdiri tahun 1985</p>
                <div class="fade-in-up">
                    <a href="#timeline" class="btn btn-hero btn-hero-primary me-3">
                        <i class="fas fa-history me-2"></i>Jelajahi Sejarah
                    </a>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-hero btn-hero-outline">
                        <i class="fas fa-home me-2"></i>Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Timeline Section -->
<section id="timeline" class="timeline-section">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Perjalanan Sejarah</h2>
            <p>Kilasan peristiwa penting dalam perkembangan SMK PGRI 2 PONOROGO</p>
        </div>
        
        <div class="timeline">
            <!-- Timeline Item 1 -->
            <div class="timeline-card timeline-card-left">
                <div class="timeline-content">
                    <div class="timeline-year">1985</div>
                    <h3 class="timeline-title">Pendirian Sekolah</h3>
                    <p class="timeline-desc">SMK PGRI 2 PONOROGO didirikan pada tanggal 15 Juli 1985 dengan hanya 3 kelas dan 5 guru pengajar. Awalnya menempati gedung SD Negeri 2 Balong yang dipakai bergantian.</p>
                </div>
            </div>
            
            <!-- Timeline Item 2 -->
            <div class="timeline-card timeline-card-right">
                <div class="timeline-content">
                    <div class="timeline-year">1990</div>
                    <h3 class="timeline-title">Gedung Baru Pertama</h3>
                    <p class="timeline-desc">Pembangunan gedung sekolah sendiri di Jl. Raya Balong No. 123 dengan 6 ruang kelas, ruang guru, dan perpustakaan kecil. Jumlah siswa meningkat menjadi 120 orang.</p>
                </div>
            </div>
            
            <!-- Timeline Item 3 -->
            <div class="timeline-card timeline-card-left">
                <div class="timeline-content">
                    <div class="timeline-year">1995</div>
                    <h3 class="timeline-title">Akreditasi Pertama</h3>
                    <p class="timeline-desc">Meraih akreditasi B dari Badan Akreditasi Nasional untuk pertama kalinya. Program studi IPA dan IPS resmi dibuka dengan total 9 kelas.</p>
                </div>
            </div>
            
            <!-- Timeline Item 4 -->
            <div class="timeline-card timeline-card-right">
                <div class="timeline-content">
                    <div class="timeline-year">2002</div>
                    <h3 class="timeline-title">Pembangunan Laboratorium</h3>
                    <p class="timeline-desc">Dibangun laboratorium komputer dan bahasa yang modern untuk mendukung proses pembelajaran. Sekolah mulai menerapkan kurikulum berbasis kompetensi.</p>
                </div>
            </div>
            
            <!-- Timeline Item 5 -->
            <div class="timeline-card timeline-card-left">
                <div class="timeline-content">
                    <div class="timeline-year">2010</div>
                    <h3 class="timeline-title">Akreditasi A</h3>
                    <p class="timeline-desc">Meraih akreditasi A dengan nilai tertinggi se-Kabupaten. Jumlah siswa mencapai 800 orang dengan 24 rombongan belajar.</p>
                </div>
            </div>
            
            <!-- Timeline Item 6 -->
            <div class="timeline-card timeline-card-right">
                <div class="timeline-content">
                    <div class="timeline-year">2015</div>
                    <h3 class="timeline-title">Era Digitalisasi</h3>
                    <p class="timeline-desc">Penerapan sistem pembelajaran digital dengan LMS, wifi seluruh area sekolah, dan komputer di setiap kelas. Sekolah mulai dikenal sebagai sekolah unggulan berbasis teknologi.</p>
                </div>
            </div>
            
            <!-- Timeline Item 7 -->
            <div class="timeline-card timeline-card-left">
                <div class="timeline-content">
                    <div class="timeline-year">2020</div>
                    <h3 class="timeline-title">Sekolah Adiwiyata</h3>
                    <p class="timeline-desc">Meraih penghargaan Sekolah Adiwiyata Nasional berkat program lingkungan dan green campus. Pembangunan gedung serba guna dan lapangan olahraga standar nasional.</p>
                </div>
            </div>
            
            <!-- Timeline Item 8 -->
            <div class="timeline-card timeline-card-right">
                <div class="timeline-content">
                    <div class="timeline-year">2024</div>
                    <h3 class="timeline-title">Sekolah Penggerak</h3>
                    <p class="timeline-desc">Terpilih sebagai Sekolah Penggerak dalam program Merdeka Belajar. Memiliki 120 guru dan karyawan, serta 2400 siswa dengan fasilitas lengkap dan modern.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision Mission Section -->
<section class="vm-section">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Visi & Misi</h2>
            <p>Panduan dan arah pengembangan SMK PGRI 2 PONOROGO</p>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="vm-card fade-in-up">
                    <i class="fas fa-eye fa-3x text-primary"></i>
                    <h5>Visi Sekolah</h5>
                    <p>"Mewujudkan SMK PGRI 2 PONOROGO sebagai lembaga pendidikan unggulan yang menghasilkan lulusan berkarakter, berprestasi, dan mampu bersaing di era global dengan dilandasi iman dan takwa."</p>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="vm-card fade-in-up">
                    <i class="fas fa-bullseye fa-3x text-success"></i>
                    <h5>Misi Sekolah</h5>
                    <ul class="text-start text-muted">
                        <li>Menyelenggarakan pembelajaran yang berkualitas dan inovatif</li>
                        <li>Mengembangkan potensi peserta didik secara optimal</li>
                        <li>Menanamkan nilai-nilai karakter dan budi pekerti luhur</li>
                        <li>Membangun lingkungan sekolah yang nyaman dan inspiratif</li>
                        <li>Menjalin kerjasama dengan masyarakat dan dunia usaha/industri</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="<?php echo e(route('about.profile')); ?>" class="btn btn-primary-enhanced btn-enhanced">
                <i class="fas fa-info-circle me-2"></i>Profil Lengkap Sekolah
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Timeline animation
    const timelineCards = document.querySelectorAll('.timeline-card');
    
    const timelineObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.3,
        rootMargin: '0px 0px -100px 0px'
    });
    
    timelineCards.forEach(card => {
        timelineObserver.observe(card);
    });
    
    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            // Skip if href is just '#' or empty
            if (!href || href === '#' || href.length <= 1) {
                return;
            }
            
            e.preventDefault();
            const target = document.querySelector(href);
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
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/public/about/sejarah.blade.php ENDPATH**/ ?>