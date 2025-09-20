<?php $__env->startSection('title', 'Detail Siswa'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Dark Mode Variables for Student Detail */
    :root {
        /* Light Mode Colors */
        --student-bg-gradient-light: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --student-card-bg-light: rgba(255, 255, 255, 0.95);
        --student-header-gradient-light: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        --student-profile-bg-light: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        --student-card-white-light: #ffffff;
        --student-text-primary-light: #1f2937;
        --student-text-secondary-light: #6b7280;
        --student-text-muted-light: #9ca3af;
        --student-border-light: #e5e7eb;
        --student-shadow-light: rgba(0, 0, 0, 0.1);
        --student-shadow-hover-light: rgba(0, 0, 0, 0.15);
        
        /* Dark Mode Colors */
        --student-bg-gradient-dark: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        --student-card-bg-dark: rgba(30, 41, 59, 0.95);
        --student-header-gradient-dark: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
        --student-profile-bg-dark: linear-gradient(135deg, #374151 0%, #4b5563 100%);
        --student-card-white-dark: #1f2937;
        --student-text-primary-dark: #f8fafc;
        --student-text-secondary-dark: #d1d5db;
        --student-text-muted-dark: #9ca3af;
        --student-border-dark: #374151;
        --student-shadow-dark: rgba(0, 0, 0, 0.3);
        --student-shadow-hover-dark: rgba(0, 0, 0, 0.4);
        
        /* Current Theme (Default: Light) */
        --student-bg-gradient: var(--student-bg-gradient-light);
        --student-card-bg: var(--student-card-bg-light);
        --student-header-gradient: var(--student-header-gradient-light);
        --student-profile-bg: var(--student-profile-bg-light);
        --student-card-white: var(--student-card-white-light);
        --student-text-primary: var(--student-text-primary-light);
        --student-text-secondary: var(--student-text-secondary-light);
        --student-text-muted: var(--student-text-muted-light);
        --student-border: var(--student-border-light);
        --student-shadow: var(--student-shadow-light);
        --student-shadow-hover: var(--student-shadow-hover-light);
    }
    
    /* Dark mode overrides */
    .dark {
        --student-bg-gradient: var(--student-bg-gradient-dark);
        --student-card-bg: var(--student-card-bg-dark);
        --student-header-gradient: var(--student-header-gradient-dark);
        --student-profile-bg: var(--student-profile-bg-dark);
        --student-card-white: var(--student-card-white-dark);
        --student-text-primary: var(--student-text-primary-dark);
        --student-text-secondary: var(--student-text-secondary-dark);
        --student-text-muted: var(--student-text-muted-dark);
        --student-border: var(--student-border-dark);
        --student-shadow: var(--student-shadow-dark);
        --student-shadow-hover: var(--student-shadow-hover-dark);
    }
    
    .student-detail-container {
        background: var(--student-bg-gradient);
        min-height: 100vh;
        padding: 2rem 0;
        transition: background 0.3s ease;
    }
    
    .detail-wrapper {
        background: var(--student-card-bg);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px var(--student-shadow);
        margin: 0 auto;
        max-width: 1200px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .detail-header {
        background: var(--student-header-gradient);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: background 0.3s ease;
    }
    
    .detail-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }
    
    .detail-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .detail-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }
    
    .action-buttons {
        position: relative;
        z-index: 3;
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .btn-custom {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-edit {
        background: rgba(255, 255, 255, 0.9);
        color: #4f46e5;
    }
    
    .btn-edit:hover {
        background: white;
        color: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .btn-theme {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        cursor: pointer;
    }
    
    .btn-theme:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, 0.5);
    }
    
    .detail-body {
        padding: 0;
    }
    
    .profile-section {
        background: var(--student-profile-bg);
        padding: 2rem;
        border-bottom: 1px solid var(--student-border);
        transition: all 0.3s ease;
    }
    
    .profile-photo {
        position: relative;
        display: inline-block;
    }
    
    .student-photo {
        width: 200px;
        height: 200px;
        border-radius: 20px;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .student-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 40px var(--student-shadow-hover);
    }
    
    .student-initials {
        width: 200px;
        height: 200px;
        border-radius: 20px;
        background: var(--student-header-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 800;
        border: 4px solid white;
        box-shadow: 0 15px 35px var(--student-shadow);
        transition: all 0.3s ease;
    }
    
    .student-initials:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 40px var(--student-shadow-hover);
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
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .status-active {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .status-inactive {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    
    .status-graduated {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }
    
    .student-name {
        font-size: 2rem;
        font-weight: 800;
        color: var(--student-text-primary);
        margin-bottom: 0.5rem;
        margin-top: 1rem;
        transition: color 0.3s ease;
    }
    
    .student-class {
        display: inline-block;
        background: var(--student-header-gradient);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        transition: background 0.3s ease;
    }
    
    .info-sections {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        padding: 2rem;
    }
    
    .info-card {
        background: var(--student-card-white);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px var(--student-shadow);
        border-left: 4px solid #4f46e5;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px var(--student-shadow-hover);
    }
    
    .info-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--student-text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }
    
    .info-card-icon {
        width: 32px;
        height: 32px;
        background: var(--student-header-gradient);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        transition: background 0.3s ease;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--student-border);
        transition: all 0.2s ease;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-item:hover {
        background: var(--student-profile-bg);
        margin: 0 -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 8px;
    }
    
    .info-label {
        font-weight: 600;
        color: var(--student-text-secondary);
        min-width: 140px;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.3s ease;
    }
    
    .info-value {
        color: var(--student-text-primary);
        font-weight: 500;
        flex: 1;
        transition: color 0.3s ease;
    }
    
    .info-value.empty {
        color: var(--student-text-muted);
        font-style: italic;
    }
    
    .contact-link {
        color: #4f46e5;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .contact-link:hover {
        color: #7c3aed;
        text-decoration: underline;
    }
    
    .age-badge {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        color: #0369a1;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }
    
    .gender-icon {
        margin-right: 0.5rem;
        color: #4f46e5;
    }
    
    @media (max-width: 768px) {
        .detail-wrapper {
            margin: 0 1rem;
        }
        
        .detail-header {
            padding: 1.5rem;
            text-align: center;
        }
        
        .detail-header h1 {
            font-size: 2rem;
        }
        
        .action-buttons {
            justify-content: center;
            flex-wrap: wrap;
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
            font-size: 1.5rem;
        }
        
        .info-sections {
            grid-template-columns: 1fr;
            padding: 1rem;
        }
        
        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .info-label {
            min-width: auto;
        }
    }
    
    /* Animation untuk loading */
    .info-card {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }
    
    .info-card:nth-child(1) { animation-delay: 0.1s; }
    .info-card:nth-child(2) { animation-delay: 0.2s; }
    .info-card:nth-child(3) { animation-delay: 0.3s; }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="student-detail-container" x-data="studentDetail()">
    <div class="detail-wrapper">
        <!-- Header Section -->
        <div class="detail-header">
            <h1><i class="fas fa-user-graduate me-3"></i>Detail Siswa</h1>
            <p>Informasi lengkap data siswa</p>
            
            <div class="action-buttons">
                <a href="<?php echo e(route('admin.students.index')); ?>" class="btn-custom btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="<?php echo e(route('admin.students.edit', $student)); ?>" class="btn-custom btn-edit">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
                <button @click="$dispatch('toggle-dark-mode')" class="btn-custom btn-theme" title="Toggle Dark/Light Mode">
                    <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                    <span x-text="darkMode ? 'Light' : 'Dark'"></span>
                </button>
            </div>
        </div>

        <div class="detail-body">
            <!-- Profile Section -->
            <div class="profile-section">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                        <div class="profile-photo">
                            <?php if($student->photo): ?>
                                <img src="<?php echo e($student->photo_url); ?>" alt="<?php echo e($student->name); ?>" class="student-photo">
                            <?php else: ?>
                                <div class="student-initials">
                                    <?php echo e($student->initials); ?>

                                </div>
                            <?php endif; ?>
                            
                            <div class="status-badge status-<?php echo e($student->status); ?>">
                                <?php echo e($student->status_label); ?>

                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <h2 class="student-name"><?php echo e($student->name); ?></h2>
                        <div class="student-class">
                            <i class="fas fa-graduation-cap me-2"></i><?php echo e($student->class); ?>

                        </div>
                        <div class="d-flex flex-wrap gap-3 mt-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-id-card text-primary me-2"></i>
                                <strong>NIS:</strong> <span class="ms-1"><?php echo e($student->nis); ?></span>
                            </div>
                            <?php if($student->nisn): ?>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-id-badge text-primary me-2"></i>
                                    <strong>NISN:</strong> <span class="ms-1"><?php echo e($student->nisn); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar text-primary me-2"></i>
                                <strong>Umur:</strong> 
                                <span class="age-badge"><?php echo e($student->age ?? 'N/A'); ?> tahun</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Sections -->
            <div class="info-sections">
                <!-- Personal Information -->
                <div class="info-card">
                    <h3 class="info-card-title">
                        <div class="info-card-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        Data Pribadi
                    </h3>
                    
                    <div class="info-item">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value"><?php echo e($student->name); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Tempat Lahir</div>
                        <div class="info-value"><?php echo e($student->birth_place); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Tanggal Lahir</div>
                        <div class="info-value">
                            <?php echo e($student->birth_date->format('d F Y')); ?>

                            <span class="age-badge"><?php echo e($student->age ?? 'N/A'); ?> tahun</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Jenis Kelamin</div>
                        <div class="info-value">
                            <i class="fas fa-<?php echo e($student->gender === 'male' ? 'mars' : 'venus'); ?> gender-icon"></i>
                            <?php echo e($student->gender === 'male' ? 'Laki-laki' : 'Perempuan'); ?>

                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Agama</div>
                        <div class="info-value <?php echo e(!$student->religion ? 'empty' : ''); ?>">
                            <?php if($student->religion): ?>
                                <i class="fas fa-pray text-primary me-2"></i><?php echo e($student->religion); ?>

                            <?php else: ?>
                                Tidak ada data
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Alamat</div>
                        <div class="info-value <?php echo e(!$student->address ? 'empty' : ''); ?>">
                            <?php echo e($student->address ?: 'Tidak ada data'); ?>

                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="info-card">
                    <h3 class="info-card-title">
                        <div class="info-card-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        Kontak
                    </h3>
                    
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            <?php if($student->email): ?>
                                <a href="mailto:<?php echo e($student->email); ?>" class="contact-link">
                                    <i class="fas fa-envelope me-1"></i><?php echo e($student->email); ?>

                                </a>
                            <?php else: ?>
                                <span class="empty">Tidak ada data</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Telepon</div>
                        <div class="info-value">
                            <?php if($student->phone): ?>
                                <a href="tel:<?php echo e($student->phone); ?>" class="contact-link">
                                    <i class="fas fa-phone me-1"></i><?php echo e($student->phone); ?>

                                </a>
                            <?php else: ?>
                                <span class="empty">Tidak ada data</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Nama Orang Tua</div>
                        <div class="info-value"><?php echo e($student->parent_name); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Telepon Orang Tua</div>
                        <div class="info-value">
                            <?php if($student->parent_phone): ?>
                                <a href="tel:<?php echo e($student->parent_phone); ?>" class="contact-link">
                                    <i class="fas fa-phone me-1"></i><?php echo e($student->parent_phone); ?>

                                </a>
                            <?php else: ?>
                                <span class="empty">Tidak ada data</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="info-card">
                    <h3 class="info-card-title">
                        <div class="info-card-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        Data Akademik
                    </h3>
                    
                    <div class="info-item">
                        <div class="info-label">NIS</div>
                        <div class="info-value">
                            <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px; font-weight: 600;"><?php echo e($student->nis); ?></code>
                        </div>
                    </div>
                    
                    <?php if($student->nisn): ?>
                        <div class="info-item">
                            <div class="info-label">NISN</div>
                            <div class="info-value">
                                <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px; font-weight: 600;"><?php echo e($student->nisn); ?></code>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="info-item">
                        <div class="info-label">Kelas</div>
                        <div class="info-value">
                            <span class="student-class" style="margin: 0; padding: 0.25rem 1rem; font-size: 0.875rem;">
                                <i class="fas fa-graduation-cap me-1"></i><?php echo e($student->class); ?>

                            </span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge status-<?php echo e($student->status); ?>" style="position: static; margin: 0; border: none; box-shadow: none;">
                                <?php echo e($student->status_label); ?>

                            </span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Terdaftar</div>
                        <div class="info-value">
                            <i class="fas fa-calendar-plus text-primary me-1"></i>
                            <?php echo e($student->created_at->format('d F Y')); ?>

                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Terakhir Update</div>
                        <div class="info-value">
                            <i class="fas fa-clock text-primary me-1"></i>
                            <?php echo e($student->updated_at->format('d F Y H:i')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Listen for dark mode toggle
    document.addEventListener('alpine:init', () => {
        Alpine.data('studentDetail', () => ({
            darkMode: localStorage.getItem('darkMode') === 'true' || false,
            
            init() {
                // Listen for theme toggle from header button
                this.$watch('darkMode', (value) => {
                    localStorage.setItem('darkMode', value);
                    this.applyTheme();
                });
                
                // Listen for global theme changes
                window.addEventListener('theme-changed', (e) => {
                    this.darkMode = e.detail.darkMode;
                });
                
                // Listen for toggle dark mode dispatch
                this.$el.addEventListener('toggle-dark-mode', () => {
                    this.toggleDarkMode();
                });
                
                this.applyTheme();
            },
            
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                
                // Dispatch to parent admin app
                window.dispatchEvent(new CustomEvent('theme-changed', { 
                    detail: { darkMode: this.darkMode } 
                }));
            },
            
            applyTheme() {
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }));
    });
    
    // Smooth scroll to top when page loads
    document.addEventListener('DOMContentLoaded', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Add loading animation to cards
        const cards = document.querySelectorAll('.info-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/students/show.blade.php ENDPATH**/ ?>