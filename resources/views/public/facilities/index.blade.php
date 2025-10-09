@extends('layouts.public')

@section('title', 'Fasilitas Sekolah')

@section('content')
<link rel="stylesheet" href="{{ asset('css/public-template.css') }}">
<style>
    /* Page-specific styles for Facilities */
    
    .hero-section {
        background-image: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        min-height: 50vh;
    }
    
    .facilities-hero-section::before {
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
    
    .facilities-hero-section .container {
        position: relative;
        z-index: 2;
    }
    
    .facilities-hero-section h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.5);
    }
    
    .facilities-hero-section .lead {
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
    
    /* Facilities Section */
    .facilities-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        position: relative;
    }
    
    .facility-filter {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 40px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .facility-category-btn {
        border: none;
        background: var(--gradient-light);
        color: var(--primary-color);
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 5px;
    }
    
    .facility-category-btn:hover,
    .facility-category-btn.active {
        background: var(--gradient-primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(49, 130, 206, 0.3);
    }
    
    .facility-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 30px;
        height: 100%;
        position: relative;
    }
    
    .facility-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    .facility-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    
    .facility-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .facility-card:hover .facility-image img {
        transform: scale(1.1);
    }
    
    .facility-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.7));
        z-index: 1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .facility-card:hover .facility-image::before {
        opacity: 1;
    }
    
    .no-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        border: 2px dashed #e5e7eb;
    }
    
    .no-image svg {
        width: 3rem;
        height: 3rem;
        margin-bottom: 0.5rem;
    }
    
    .facility-content {
        padding: 25px;
    }
    
    .facility-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
        line-height: 1.3;
    }
    
    .facility-desc {
        color: var(--dark-gray);
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .facility-features {
        margin-bottom: 20px;
    }
    
    .facility-feature {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        color: var(--dark-gray);
        font-size: 0.9rem;
    }
    
    .facility-feature i {
        margin-right: 8px;
        color: var(--secondary-color);
        width: 16px;
    }
    
    .facility-status {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
    }
    
    .status-active {
        background: rgba(40, 167, 69, 0.9);
        color: white;
    }
    
    .status-maintenance {
        background: rgba(255, 193, 7, 0.9);
        color: white;
    }
    
    .status-inactive {
        background: rgba(220, 53, 69, 0.9);
        color: white;
    }
    
    .featured-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 193, 7, 0.9);
        color: white;
        padding: 8px;
        border-radius: 50%;
        z-index: 2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    .featured-badge svg {
        width: 16px;
        height: 16px;
    }
    
    .facility-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        font-size: 0.85rem;
        color: var(--dark-gray);
        flex-wrap: wrap;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .meta-item svg {
        width: 14px;
        height: 14px;
        color: var(--secondary-color);
    }
    
    .feature-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 15px;
    }
    
    .feature-tag {
        background: rgba(49, 130, 206, 0.1);
        color: var(--primary-color);
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    /* Facilities Gallery Section */
    .gallery-section {
        padding: 80px 0;
        background: white;
    }
    
    .gallery-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .gallery-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 20px;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
        transform: translateY(20px);
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
        transform: translateY(0);
    }
    
    .gallery-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .gallery-desc {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    /* Stats Section */
    .facilities-stats {
        padding: 80px 0;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: var(--secondary-color);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    
    .stat-label {
        color: var(--dark-gray);
        font-weight: 600;
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
    
    /* Modal Styles */
    .facility-modal .modal-content {
        border-radius: 16px;
        overflow: hidden;
        border: none;
    }
    
    .facility-modal .modal-header {
        background: var(--gradient-primary);
        color: white;
        border: none;
    }
    
    .facility-modal .modal-body {
        padding: 25px;
    }
    
    .facility-modal .modal-footer {
        border: none;
        background: #f8f9fa;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--dark-gray);
    }
    
    .empty-state svg {
        width: 80px;
        height: 80px;
        margin-bottom: 20px;
        color: #cbd5e0;
    }
    
    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--primary-color);
    }
    
    .empty-state p {
        font-size: 1rem;
        line-height: 1.6;
        max-width: 400px;
        margin: 0 auto;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .facilities-hero-section {
            padding: 60px 0;
            text-align: center;
        }
        
        .facilities-hero-section h1 {
            font-size: 2.5rem;
        }
        
        .facility-filter .btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .facility-category-btn {
            margin-bottom: 10px;
            flex: 1 0 auto;
            text-align: center;
        }
        
        .facility-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
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

<!-- Enhanced Hero Section for Facilities Page -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="fade-in-up">Fasilitas Sekolah</h1>
                <p class="lead fade-in-up">Infrastruktur modern dan lengkap untuk mendukung proses belajar mengajar yang optimal</p>
                <div class="fade-in-up">
                    <a href="#facilities" class="btn btn-hero btn-hero-primary me-3">
                        <i class="fas fa-building me-2"></i>Jelajahi Fasilitas
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-hero btn-hero-outline">
                        <i class="fas fa-home me-2"></i>Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Filter Section -->
<section class="facilities-section" id="facilities">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Fasilitas Unggulan</h2>
            <p>Berbagai sarana dan prasarana penunjang pendidikan di SMK PGRI 2 PONOROGO</p>
        </div>
        
        <div class="facility-filter fade-in-up">
            <div class="text-center mb-4">
                <h5 class="mb-3">Filter Berdasarkan Kategori:</h5>
                <div class="btn-group" role="group" aria-label="Facility categories">
                    <button type="button" class="facility-category-btn active" data-filter="all">Semua</button>
                    @if(isset($categories) && count($categories) > 0)
                        @foreach($categories as $key => $label)
                            <button type="button" class="facility-category-btn" data-filter="{{ $key }}">{{ $label }}</button>
                        @endforeach
                    @else
                        <button type="button" class="facility-category-btn" data-filter="academic">Akademik</button>
                        <button type="button" class="facility-category-btn" data-filter="sport">Olahraga</button>
                        <button type="button" class="facility-category-btn" data-filter="technology">Teknologi</button>
                        <button type="button" class="facility-category-btn" data-filter="arts">Seni & Budaya</button>
                        <button type="button" class="facility-category-btn" data-filter="other">Lainnya</button>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="row">
            @forelse($facilities as $facility)
                <!-- Dynamic Facility Item -->
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up" data-category="{{ $facility->category }}">
                    <div class="facility-card">
                        @if($facility->is_featured)
                            <div class="featured-badge">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="facility-image">
                            @if($facility->image)
                                <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}">
                            @else
                                <div class="no-image">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Tidak ada gambar</span>
                                </div>
                            @endif
                            <span class="facility-status status-{{ $facility->status }}">
                                @if($facility->status == 'active')
                                    Tersedia
                                @elseif($facility->status == 'maintenance')
                                    Maintenance
                                @else
                                    Tidak Aktif
                                @endif
                            </span>
                        </div>
                        
                        <div class="facility-content">
                            <h3 class="facility-title">{{ $facility->name }}</h3>
                            <p class="facility-desc">{{ Str::limit($facility->description, 120) }}</p>
                            
                            @if($facility->location || $facility->capacity)
                                <div class="facility-meta">
                                    @if($facility->location)
                                        <div class="meta-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $facility->location }}
                                        </div>
                                    @endif
                                    @if($facility->capacity)
                                        <div class="meta-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ number_format($facility->capacity) }} orang
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            @if($facility->features && count($facility->features) > 0)
                                <div class="feature-tags">
                                    @foreach(array_slice($facility->features, 0, 3) as $feature)
                                        @if(!empty(trim($feature)))
                                            <span class="feature-tag">{{ $feature }}</span>
                                        @endif
                                    @endforeach
                                    @if(count($facility->features) > 3)
                                        <span class="feature-tag">+{{ count($facility->features) - 3 }} lainnya</span>
                                    @endif
                                </div>
                            @endif
                            
                            <button type="button" class="btn btn-primary-enhanced btn-enhanced w-100" 
                                    data-bs-toggle="modal" data-bs-target="#facilityModal{{ $facility->id }}">
                                <i class="fas fa-info-circle me-2"></i>Detail Fasilitas
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-12">
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                        </svg>
                        <h3>Belum Ada Fasilitas</h3>
                        <p>Saat ini belum ada fasilitas yang tersedia. Silakan kembali lagi nanti untuk melihat update terbaru.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Facilities Stats Section -->
<section class="facilities-stats">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Fasilitas dalam Angka</h2>
            <p>Statistik lengkap sarana dan prasarana SMK PGRI 2 PONOROGO</p>
        </div>
        
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-number">{{ $stats['total_facilities'] ?? 0 }}</div>
                    <div class="stat-label">Total Fasilitas</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <div class="stat-number">{{ $stats['academic_facilities'] ?? 0 }}</div>
                    <div class="stat-label">Fasilitas Akademik</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-running"></i>
                    </div>
                    <div class="stat-number">{{ $stats['sport_facilities'] ?? 0 }}</div>
                    <div class="stat-label">Fasilitas Olahraga</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 mb-4 fade-in-up">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="stat-number">{{ $stats['technology_facilities'] ?? 0 }}</div>
                    <div class="stat-label">Fasilitas Teknologi</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dynamic Facility Modals -->
@if(isset($facilities) && $facilities->count() > 0)
    @foreach($facilities as $facility)
        <div class="modal fade facility-modal" id="facilityModal{{ $facility->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $facility->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($facility->image)
                            <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" class="img-fluid rounded mb-4">
                        @endif
                        
                        <h5>Deskripsi Fasilitas</h5>
                        <p>{{ $facility->description }}</p>
                        
                        @if($facility->location || $facility->capacity)
                            <h5>Informasi Fasilitas</h5>
                            <ul>
                                @if($facility->location)
                                    <li><strong>Lokasi:</strong> {{ $facility->location }}</li>
                                @endif
                                @if($facility->capacity)
                                    <li><strong>Kapasitas:</strong> {{ number_format($facility->capacity) }} orang</li>
                                @endif
                                <li><strong>Status:</strong> 
                                    @if($facility->status == 'active')
                                        <span class="badge bg-success">Tersedia</span>
                                    @elseif($facility->status == 'maintenance')
                                        <span class="badge bg-warning">Pemeliharaan</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </li>
                            </ul>
                        @endif
                        
                        @if($facility->features && count($facility->features) > 0)
                            <h5>Fasilitas Pendukung</h5>
                            <ul>
                                @foreach($facility->features as $feature)
                                    @if(!empty(trim($feature)))
                                        <li>{{ $feature }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        @if(isset($facility) && $facility->status == 'active')
                            <button type="button" class="btn btn-primary-enhanced">Ajukan Penggunaan</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<!-- JavaScript untuk Filter dan Animasi -->
<script src="{{ asset('js/public-template.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterButtons = document.querySelectorAll('.facility-category-btn');
        const facilityItems = document.querySelectorAll('[data-category]');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                
                facilityItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Animation on scroll
        const animatedElements = document.querySelectorAll('.fade-in-up');
        
        function checkScroll() {
            animatedElements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (elementPosition < screenPosition) {
                    element.style.animationPlayState = 'running';
                }
            });
        }
        
        // Initial check
        checkScroll();
        
        // Check on scroll
        window.addEventListener('scroll', checkScroll);
    });
</script>

@endsection