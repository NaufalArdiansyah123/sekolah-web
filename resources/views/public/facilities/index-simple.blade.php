@extends('layouts.public')

@section('title', 'Fasilitas Sekolah')

@section('content')
<style>
/* FORCE STYLING WITH INLINE CSS - BLUE THEME */
.facilities-hero-custom {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
    color: white !important;
    padding: 80px 0 60px !important;
    text-align: center !important;
    position: relative !important;
    overflow: hidden !important;
}

.facilities-hero-custom::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>') repeat !important;
    z-index: 1 !important;
}

.facilities-hero-custom .container {
    position: relative !important;
    z-index: 2 !important;
}

.hero-title-custom {
    font-size: 3rem !important;
    font-weight: 800 !important;
    margin-bottom: 1rem !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3) !important;
    color: white !important;
}

.hero-subtitle-custom {
    font-size: 1.2rem !important;
    opacity: 0.95 !important;
    max-width: 700px !important;
    margin: 0 auto 3rem !important;
    line-height: 1.6 !important;
    color: white !important;
}

.stats-row-custom {
    display: grid !important;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)) !important;
    gap: 2rem !important;
    max-width: 800px !important;
    margin: 0 auto !important;
}

.stat-item-custom {
    text-align: center !important;
    padding: 1rem !important;
    background: rgba(255, 255, 255, 0.1) !important;
    border-radius: 12px !important;
    backdrop-filter: blur(10px) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
}

.stat-number-custom {
    font-size: 2.5rem !important;
    font-weight: 800 !important;
    display: block !important;
    margin-bottom: 0.5rem !important;
    color: white !important;
}

.stat-label-custom {
    font-size: 0.9rem !important;
    opacity: 0.9 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    font-weight: 500 !important;
    color: white !important;
}

.filter-section-custom {
    background: white !important;
    padding: 2rem 0 !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 100 !important;
}

.filter-container-custom {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 1.5rem !important;
}

.filter-buttons-custom {
    display: flex !important;
    justify-content: center !important;
    gap: 0.75rem !important;
    flex-wrap: wrap !important;
}

.filter-btn-custom {
    padding: 0.75rem 1.5rem !important;
    border: 2px solid #e5e7eb !important;
    background: white !important;
    color: #6b7280 !important;
    border-radius: 50px !important;
    font-weight: 600 !important;
    font-size: 0.9rem !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
    white-space: nowrap !important;
}

.filter-btn-custom:hover {
    background: #f3f4f6 !important;
    border-color: #d1d5db !important;
    transform: translateY(-1px) !important;
    color: #6b7280 !important;
    text-decoration: none !important;
}

.filter-btn-custom.active {
    background: #1e40af !important;
    color: white !important;
    border-color: #1e40af !important;
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3) !important;
}

.facilities-section-custom {
    padding: 4rem 0 !important;
    background: #f8fafc !important;
    min-height: 60vh !important;
}

.section-title-custom {
    text-align: center !important;
    margin-bottom: 3rem !important;
}

.section-title-custom h2 {
    font-size: 2.5rem !important;
    font-weight: 700 !important;
    color: #1f2937 !important;
    margin-bottom: 1rem !important;
}

.section-title-custom p {
    font-size: 1.1rem !important;
    color: #6b7280 !important;
    max-width: 600px !important;
    margin: 0 auto !important;
}

.facilities-grid-custom {
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)) !important;
    gap: 2rem !important;
    margin-top: 2rem !important;
}

.facility-card-custom {
    background: white !important;
    border-radius: 16px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    height: fit-content !important;
}

.facility-card-custom:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
}

.facility-image-custom {
    height: 220px !important;
    position: relative !important;
    overflow: hidden !important;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%) !important;
}

.facility-image-custom img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.5s ease !important;
    display: block !important;
}

.facility-image-custom img.loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%) !important;
    background-size: 200% 100% !important;
    animation: imageLoading 1.5s infinite !important;
}

@keyframes imageLoading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.facility-card-custom:hover .facility-image-custom img {
    transform: scale(1.05) !important;
}

.facility-placeholder-custom {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: white !important;
    font-size: 3rem !important;
    flex-direction: column !important;
    gap: 1rem !important;
}

.facility-placeholder-custom i {
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)) !important;
}

.facility-placeholder-custom .placeholder-text {
    font-size: 1rem !important;
    font-weight: 600 !important;
    text-align: center !important;
    opacity: 0.9 !important;
}

.facility-status-custom {
    position: absolute !important;
    top: 1rem !important;
    right: 1rem !important;
    padding: 0.5rem 1rem !important;
    border-radius: 20px !important;
    font-size: 0.75rem !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    backdrop-filter: blur(10px) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
}

.status-active-custom {
    background: rgba(34, 197, 94, 0.9) !important;
    color: white !important;
}

.status-maintenance-custom {
    background: rgba(251, 146, 60, 0.9) !important;
    color: white !important;
}

.status-inactive-custom {
    background: rgba(156, 163, 175, 0.9) !important;
    color: white !important;
}

.facility-content-custom {
    padding: 2rem !important;
}

.facility-title-custom {
    font-size: 1.4rem !important;
    font-weight: 700 !important;
    color: #1f2937 !important;
    margin-bottom: 1rem !important;
    line-height: 1.3 !important;
}

.facility-description-custom {
    color: #6b7280 !important;
    line-height: 1.6 !important;
    margin-bottom: 1.5rem !important;
    font-size: 0.95rem !important;
}

.facility-meta-custom {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-bottom: 1.5rem !important;
    flex-wrap: wrap !important;
    gap: 0.5rem !important;
}

.facility-category-custom {
    background: rgba(30, 64, 175, 0.1) !important;
    color: #1e40af !important;
    padding: 0.5rem 1rem !important;
    border-radius: 20px !important;
    font-size: 0.8rem !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.facility-capacity-custom {
    color: #6b7280 !important;
    font-size: 0.9rem !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.25rem !important;
}

.btn-detail-custom {
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
    padding: 0.75rem 1.5rem !important;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
    color: white !important;
    border-radius: 12px !important;
    text-decoration: none !important;
    font-weight: 600 !important;
    font-size: 0.9rem !important;
    transition: all 0.3s ease !important;
    width: 100% !important;
    justify-content: center !important;
}

.btn-detail-custom:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%) !important;
    color: white !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 20px rgba(30, 64, 175, 0.3) !important;
    text-decoration: none !important;
}

.empty-state-custom {
    text-align: center !important;
    padding: 4rem 2rem !important;
    color: #9ca3af !important;
    grid-column: 1 / -1 !important;
}

.empty-icon-custom {
    font-size: 4rem !important;
    margin-bottom: 1.5rem !important;
    color: #d1d5db !important;
}

.empty-title-custom {
    font-size: 1.5rem !important;
    font-weight: 600 !important;
    margin-bottom: 1rem !important;
    color: #6b7280 !important;
}

.empty-description-custom {
    font-size: 1rem !important;
    max-width: 500px !important;
    margin: 0 auto !important;
    line-height: 1.6 !important;
}

@media (max-width: 768px) {
    .hero-title-custom {
        font-size: 2.5rem !important;
    }
    
    .stats-row-custom {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1rem !important;
    }
    
    .stat-number-custom {
        font-size: 2rem !important;
    }
    
    .facilities-grid-custom {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    .filter-buttons-custom {
        flex-direction: column !important;
        align-items: center !important;
        gap: 0.5rem !important;
    }
    
    .filter-btn-custom {
        width: 250px !important;
        justify-content: center !important;
    }
}

@media (max-width: 480px) {
    .hero-title-custom {
        font-size: 2rem !important;
    }
    
    .stats-row-custom {
        grid-template-columns: 1fr !important;
    }
    
    .facilities-hero-custom {
        padding: 60px 0 40px !important;
    }
    
    .facilities-section-custom {
        padding: 3rem 0 !important;
    }
    
    .facility-content-custom {
        padding: 1.5rem !important;
    }
}
</style>

<!-- Hero Section -->
<section class="facilities-hero-custom">
    <div class="container">
        <h1 class="hero-title-custom">Fasilitas Sekolah</h1>
        <p class="hero-subtitle-custom">
            Jelajahi berbagai fasilitas modern dan lengkap yang mendukung proses pembelajaran di SMK PGRI 2 PONOROGO
        </p>
        
        <div class="stats-row-custom">
            <div class="stat-item-custom">
                <span class="stat-number-custom">{{ $stats['total_facilities'] }}</span>
                <span class="stat-label-custom">Total Fasilitas</span>
            </div>
            <div class="stat-item-custom">
                <span class="stat-number-custom">{{ $stats['academic_facilities'] }}</span>
                <span class="stat-label-custom">Fasilitas Akademik</span>
            </div>
            <div class="stat-item-custom">
                <span class="stat-number-custom">{{ $stats['technology_facilities'] }}</span>
                <span class="stat-label-custom">Fasilitas Teknologi</span>
            </div>
            <div class="stat-item-custom">
                <span class="stat-number-custom">{{ $stats['sport_facilities'] }}</span>
                <span class="stat-label-custom">Fasilitas Olahraga</span>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="filter-section-custom">
    <div class="container">
        <div class="filter-container-custom">
            <!-- Category Filters -->
            <div class="filter-buttons-custom">
                <button class="filter-btn-custom active" data-category="all">
                    <i class="fas fa-th-large"></i>Semua
                </button>
                @foreach($categories as $key => $label)
                    <button class="filter-btn-custom" data-category="{{ $key }}">
                        <i class="fas fa-{{ $key === 'academic' ? 'graduation-cap' : ($key === 'sport' ? 'running' : ($key === 'technology' ? 'laptop' : ($key === 'arts' ? 'palette' : 'building'))) }}"></i>
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="facilities-section-custom">
    <div class="container">
        <div class="section-title-custom">
            <h2>Fasilitas Unggulan</h2>
            <p>Berbagai sarana dan prasarana modern yang mendukung kegiatan pembelajaran dan pengembangan siswa</p>
        </div>
        
        <!-- Facilities Grid -->
        <div class="facilities-grid-custom" id="facilitiesGrid">
            @forelse($facilities as $facility)
                <div class="facility-card-custom" data-category="{{ $facility->category }}">
                    <div class="facility-image-custom">
                        @if($facility->image)
                            <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" loading="lazy" 
                                 onload="this.classList.remove('loading'); this.style.display='block';"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                 class="loading">
                            <div class="facility-placeholder-custom" style="display: none;">
                                <i class="fas fa-building"></i>
                                <div class="placeholder-text">Gambar tidak tersedia</div>
                            </div>
                        @else
                            <div class="facility-placeholder-custom">
                                <i class="fas fa-building"></i>
                                <div class="placeholder-text">{{ $facility->name }}</div>
                            </div>
                        @endif
                        
                        <div class="facility-status-custom status-{{ $facility->status }}-custom">
                            {{ $facility->status === 'active' ? 'Tersedia' : ($facility->status === 'maintenance' ? 'Maintenance' : 'Tidak Tersedia') }}
                        </div>
                    </div>
                    
                    <div class="facility-content-custom">
                        <h3 class="facility-title-custom">{{ $facility->name }}</h3>
                        <p class="facility-description-custom">{{ Str::limit($facility->description, 120) }}</p>
                        
                        <div class="facility-meta-custom">
                            <span class="facility-category-custom">{{ $facility->category_label }}</span>
                            @if($facility->capacity)
                                <div class="facility-capacity-custom">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $facility->capacity }} orang</span>
                                </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('facilities.show', $facility) }}" class="btn-detail-custom">
                            <i class="fas fa-info-circle"></i>
                            <span>Lihat Detail</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state-custom">
                    <div class="empty-icon-custom">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="empty-title-custom">Belum Ada Fasilitas</h3>
                    <p class="empty-description-custom">
                        Fasilitas sekolah akan segera ditambahkan. Silakan kembali lagi nanti untuk melihat update terbaru.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn-custom');
    const facilityCards = document.querySelectorAll('.facility-card-custom');
    
    let currentCategory = 'all';
    
    // Filter by category
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            currentCategory = this.getAttribute('data-category');
            filterFacilities();
        });
    });
    
    // Filter facilities
    function filterFacilities() {
        let visibleCount = 0;
        
        facilityCards.forEach(card => {
            const category = card.getAttribute('data-category');
            
            const matchesCategory = currentCategory === 'all' || category === currentCategory;
            
            if (matchesCategory) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
    }
});
</script>
@endsection