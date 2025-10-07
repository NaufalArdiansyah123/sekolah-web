@extends('layouts.public')

@section('title', 'Fasilitas Sekolah')

@push('styles')
<!-- External CSS for better performance and cache -->
<link rel="stylesheet" href="{{ asset('css/facilities-public.css') }}?v={{ time() }}">

<style>
/* Additional inline styles for immediate effect */
.facilities-hero {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
    color: white !important;
    padding: 80px 0 60px !important;
    text-align: center !important;
}

.hero-title {
    font-size: 3rem !important;
    font-weight: 800 !important;
    color: white !important;
    margin-bottom: 1rem !important;
}

.filter-section {
    background: white !important;
    padding: 2rem 0 !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
}

.facility-card {
    background: white !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    transition: all 0.4s ease !important;
}

.facility-card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
}

.btn-detail {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
    color: white !important;
    padding: 0.75rem 1.5rem !important;
    border-radius: 12px !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    gap: 0.5rem !important;
}

.btn-detail:hover {
    color: white !important;
    text-decoration: none !important;
    transform: translateY(-2px) !important;
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="facilities-hero">
    <div class="container">
        <h1 class="hero-title">Fasilitas Sekolah</h1>
        <p class="hero-subtitle">
            Jelajahi berbagai fasilitas modern dan lengkap yang mendukung proses pembelajaran di SMK PGRI 2 PONOROGO
        </p>
        
        <div class="stats-row">
            <div class="stat-item">
                <span class="stat-number">{{ $stats['total_facilities'] }}</span>
                <span class="stat-label">Total Fasilitas</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $stats['academic_facilities'] }}</span>
                <span class="stat-label">Fasilitas Akademik</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $stats['technology_facilities'] }}</span>
                <span class="stat-label">Fasilitas Teknologi</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $stats['sport_facilities'] }}</span>
                <span class="stat-label">Fasilitas Olahraga</span>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="filter-section">
    <div class="container">
        <div class="filter-container">
            <!-- Category Filters -->
            <div class="filter-buttons">
                <button class="filter-btn active" data-category="all">
                    <i class="fas fa-th-large"></i>Semua
                </button>
                @foreach($categories as $key => $label)
                    <button class="filter-btn" data-category="{{ $key }}">
                        <i class="fas fa-{{ $key === 'academic' ? 'graduation-cap' : ($key === 'sport' ? 'running' : ($key === 'technology' ? 'laptop' : ($key === 'arts' ? 'palette' : 'building'))) }}"></i>
                        {{ $label }}
                    </button>
                @endforeach
            </div>
            
            <!-- Search Box -->
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Cari fasilitas..." id="searchInput">
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="facilities-section">
    <div class="container">
        <div class="section-title">
            <h2>Fasilitas Unggulan</h2>
            <p>Berbagai sarana dan prasarana modern yang mendukung kegiatan pembelajaran dan pengembangan siswa</p>
        </div>
        
        <!-- Facilities Grid -->
        <div class="facilities-grid" id="facilitiesGrid">
            @forelse($facilities as $facility)
                <div class="facility-card fade-in" data-category="{{ $facility->category }}">
                    <div class="facility-image">
                        @if($facility->image)
                            <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" loading="lazy">
                        @else
                            <div class="facility-placeholder">
                                <i class="fas fa-building"></i>
                            </div>
                        @endif
                        
                        <div class="facility-status status-{{ $facility->status }}">
                            {{ $facility->status === 'active' ? 'Tersedia' : ($facility->status === 'maintenance' ? 'Maintenance' : 'Tidak Tersedia') }}
                        </div>
                    </div>
                    
                    <div class="facility-content">
                        <h3 class="facility-title">{{ $facility->name }}</h3>
                        <p class="facility-description">{{ Str::limit($facility->description, 120) }}</p>
                        
                        <div class="facility-meta">
                            <span class="facility-category">{{ $facility->category_label }}</span>
                            @if($facility->capacity)
                                <div class="facility-capacity">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $facility->capacity }} orang</span>
                                </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('facilities.show', $facility) }}" class="btn-detail">
                            <i class="fas fa-info-circle"></i>
                            <span>Lihat Detail</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Fasilitas</h3>
                    <p class="empty-description">
                        Fasilitas sekolah akan segera ditambahkan. Silakan kembali lagi nanti untuk melihat update terbaru.
                    </p>
                </div>
            @endforelse
        </div>
        
        <!-- Empty Search State -->
        <div id="emptySearchState" class="empty-state" style="display: none;">
            <div class="empty-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="empty-title">Tidak Ada Hasil</h3>
            <p class="empty-description">
                Tidak ditemukan fasilitas yang sesuai dengan pencarian Anda. Coba gunakan kata kunci yang berbeda.
            </p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');
    const facilitiesGrid = document.getElementById('facilitiesGrid');
    const emptySearchState = document.getElementById('emptySearchState');
    const facilityCards = document.querySelectorAll('.facility-card');
    
    let currentCategory = 'all';
    let currentSearch = '';
    
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
    
    // Search functionality
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentSearch = this.value.toLowerCase();
            filterFacilities();
        }, 300);
    });
    
    // Filter facilities
    function filterFacilities() {
        let visibleCount = 0;
        
        facilityCards.forEach(card => {
            const category = card.getAttribute('data-category');
            const title = card.querySelector('.facility-title').textContent.toLowerCase();
            const description = card.querySelector('.facility-description').textContent.toLowerCase();
            
            const matchesCategory = currentCategory === 'all' || category === currentCategory;
            const matchesSearch = currentSearch === '' || 
                                title.includes(currentSearch) || 
                                description.includes(currentSearch);
            
            if (matchesCategory && matchesSearch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show empty state if no results
        if (visibleCount === 0 && (currentSearch !== '' || currentCategory !== 'all')) {
            emptySearchState.style.display = 'block';
            facilitiesGrid.style.display = 'none';
        } else {
            emptySearchState.style.display = 'none';
            facilitiesGrid.style.display = 'grid';
        }
    }
});
</script>
@endpush