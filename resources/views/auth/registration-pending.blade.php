@extends('layouts.public')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center min-vh-100 align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0" style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-5 text-center">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px; background: linear-gradient(135deg, #10b981, #34d399); border-radius: 50%; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-clock text-white" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>

                    <!-- Title -->
                    <h2 class="fw-bold mb-3" style="color: #1a202c;">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Pendaftaran Berhasil!
                    </h2>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success border-0 mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #d4edda, #c3e6cb);">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Information Card -->
                    <div class="card border-0 mb-4" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 15px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: #495057;">
                                <i class="fas fa-hourglass-half text-warning me-2"></i>
                                Status Pendaftaran
                            </h5>
                            <p class="mb-3" style="color: #6c757d; line-height: 1.6;">
                                Akun Anda telah berhasil didaftarkan dan sedang menunggu konfirmasi dari administrator sekolah. 
                                Proses verifikasi biasanya memakan waktu <strong>1-2 hari kerja</strong>.
                            </p>
                            
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <div class="p-3" style="background: rgba(16, 185, 129, 0.1); border-radius: 10px;">
                                        <i class="fas fa-user-plus text-success mb-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="fw-bold mb-1">Pendaftaran</h6>
                                        <small class="text-success">✓ Selesai</small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3" style="background: rgba(255, 193, 7, 0.1); border-radius: 10px;">
                                        <i class="fas fa-search text-warning mb-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="fw-bold mb-1">Verifikasi</h6>
                                        <small class="text-warning">⏳ Dalam Proses</small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3" style="background: rgba(108, 117, 125, 0.1); border-radius: 10px;">
                                        <i class="fas fa-key text-muted mb-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="fw-bold mb-1">Aktivasi</h6>
                                        <small class="text-muted">⏸️ Menunggu</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- What's Next Section -->
                    <div class="card border-0 mb-4" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb); border-radius: 15px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3" style="color: #1976d2;">
                                <i class="fas fa-lightbulb text-primary me-2"></i>
                                Apa Selanjutnya?
                            </h5>
                            <div class="text-start">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-envelope text-primary me-3" style="margin-top: 2px;"></i>
                                    </div>
                                    <div>
                                        <strong>Cek Email Anda</strong><br>
                                        <small class="text-muted">Kami akan mengirim notifikasi email ketika akun Anda telah dikonfirmasi.</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-phone text-primary me-3" style="margin-top: 2px;"></i>
                                    </div>
                                    <div>
                                        <strong>Hubungi Sekolah</strong><br>
                                        <small class="text-muted">Jika ada pertanyaan, hubungi (024) 123-4567 atau email info@sman1.sch.id</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-clock text-primary me-3" style="margin-top: 2px;"></i>
                                    </div>
                                    <div>
                                        <strong>Tunggu Konfirmasi</strong><br>
                                        <small class="text-muted">Setelah dikonfirmasi, Anda dapat login menggunakan email dan password yang telah didaftarkan.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg px-4" style="border-radius: 25px;">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Beranda
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-primary btn-lg px-4" style="border-radius: 25px; background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
                            <i class="fas fa-phone me-2"></i>
                            Hubungi Kami
                        </a>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-4 pt-3" style="border-top: 1px solid #dee2e6;">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Data Anda aman dan akan diproses sesuai dengan kebijakan privasi sekolah.
                        </small>
                    </div>
                </div>
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
</style>
@endsection