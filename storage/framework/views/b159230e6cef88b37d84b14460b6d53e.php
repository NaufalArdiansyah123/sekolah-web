<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center min-vh-100 align-items-center" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-5">
                    <!-- Header Section -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 100px; height: 100px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 50%; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);">
                            <i class="fas fa-exclamation-triangle text-white" style="font-size: 2.5rem;"></i>
                        </div>
                        <h2 class="fw-bold mb-3" style="color: #1a202c;">
                            <i class="fas fa-times-circle text-danger me-2"></i>
                            Pendaftaran Ditolak
                        </h2>
                        <p class="text-muted mb-0">
                            Mohon maaf, pendaftaran Anda tidak dapat kami proses saat ini
                        </p>
                    </div>

                    <!-- Student Info -->
                    <div class="card border-0 mb-4" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 15px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: #495057;">
                                <i class="fas fa-user text-primary me-2"></i>
                                Informasi Pendaftar
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
                                        <div class="fw-bold"><?php echo e($user->name); ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-muted">Email</label>
                                        <div class="fw-bold"><?php echo e($user->email); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <?php if($user->nis): ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-muted">NIS</label>
                                        <div class="fw-bold"><?php echo e($user->nis); ?></div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-muted">Tanggal Pendaftaran</label>
                                        <div class="fw-bold"><?php echo e($user->created_at->format('d F Y, H:i')); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rejection Reason -->
                    <div class="card border-0 mb-4" style="background: linear-gradient(135deg, #fef2f2, #fee2e2); border-radius: 15px; border-left: 4px solid #ef4444;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: #dc2626;">
                                <i class="fas fa-info-circle text-danger me-2"></i>
                                Alasan Penolakan
                            </h5>
                            <div class="rejection-reason" style="line-height: 1.8; color: #7f1d1d;">
                                <?php if($user->rejection_reason): ?>
                                    <?php echo nl2br(e($user->rejection_reason)); ?>

                                <?php else: ?>
                                    <em>Alasan penolakan tidak tersedia. Silakan hubungi admin untuk informasi lebih lanjut.</em>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($user->rejected_at): ?>
                            <div class="mt-3 pt-3" style="border-top: 1px solid rgba(239, 68, 68, 0.2);">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Ditolak pada: <?php echo e($user->rejected_at->format('d F Y, H:i')); ?>

                                </small>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Options Section -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 h-100" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb); border-radius: 15px;">
                                <div class="card-body p-4 text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-redo-alt text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2" style="color: #1976d2;">Ajukan Banding</h6>
                                    <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                        Jika Anda merasa ada kesalahan atau ingin memberikan informasi tambahan
                                    </p>
                                    <a href="<?php echo e(route('auth.rejection.appeal', ['user' => $user->id])); ?>" 
                                       class="btn btn-primary btn-sm px-4" 
                                       style="border-radius: 25px;">
                                        <i class="fas fa-paper-plane me-1"></i>
                                        Ajukan Banding
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 h-100" style="background: linear-gradient(135deg, #f3e5f5, #e1bee7); border-radius: 15px;">
                                <div class="card-body p-4 text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-phone text-purple" style="font-size: 2rem; color: #7b1fa2;"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2" style="color: #7b1fa2;">Hubungi Kami</h6>
                                    <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                        Butuh penjelasan lebih lanjut? Tim kami siap membantu Anda
                                    </p>
                                    <button class="btn btn-sm px-4" 
                                            style="background: #7b1fa2; color: white; border-radius: 25px; border: none;"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#contactModal">
                                        <i class="fas fa-envelope me-1"></i>
                                        Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information Section -->
                    <div class="card border-0 mb-4" style="background: linear-gradient(135deg, #fff3e0, #ffe0b2); border-radius: 15px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: #f57c00;">
                                <i class="fas fa-lightbulb text-warning me-2"></i>
                                Informasi Penting
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-clock text-warning me-3" style="margin-top: 2px;"></i>
                                        </div>
                                        <div>
                                            <strong>Periode Banding</strong><br>
                                            <small class="text-muted">Anda dapat mengajukan banding dalam 30 hari setelah penolakan</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-file-alt text-warning me-3" style="margin-top: 2px;"></i>
                                        </div>
                                        <div>
                                            <strong>Dokumen Tambahan</strong><br>
                                            <small class="text-muted">Siapkan dokumen pendukung untuk memperkuat banding Anda</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-calendar-check text-warning me-3" style="margin-top: 2px;"></i>
                                        </div>
                                        <div>
                                            <strong>Waktu Proses</strong><br>
                                            <small class="text-muted">Banding akan diproses dalam 3-5 hari kerja</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-envelope text-warning me-3" style="margin-top: 2px;"></i>
                                        </div>
                                        <div>
                                            <strong>Notifikasi</strong><br>
                                            <small class="text-muted">Hasil akan dikirim melalui email yang terdaftar</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary btn-lg px-4" style="border-radius: 25px;">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary btn-lg px-4" style="border-radius: 25px;">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Halaman Login
                        </a>
                    </div>

                    <!-- Footer Info -->
                    <div class="mt-4 pt-3 text-center" style="border-top: 1px solid #dee2e6;">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Keputusan ini dibuat berdasarkan evaluasi menyeluruh terhadap dokumen dan persyaratan yang telah ditetapkan.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #7b1fa2, #9c27b0); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title">
                    <i class="fas fa-envelope me-2"></i>
                    Hubungi Tim Pendaftaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo e(route('auth.rejection.contact')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($user->name); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo e($user->email); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subjek</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Pertanyaan tentang penolakan pendaftaran" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Tuliskan pertanyaan atau komentar Anda..." required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 25px;">
                            <i class="fas fa-paper-plane me-2"></i>
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .min-vh-100 {
        min-height: 100vh;
    }
    
    .card {
        animation: slideUp 0.6s ease-out;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .card-body .card {
        transition: all 0.3s ease;
    }
    
    .card-body .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .rejection-reason {
        background: rgba(255, 255, 255, 0.7);
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/auth/rejection-explanation.blade.php ENDPATH**/ ?>