@extends('layouts.public')

@section('title', $facility->name . ' - School Facilities')

@section('content')
<style>
    /* CSS Variables */
    :root {
        --primary-color: #3b82f6;
        --primary-hover: #2563eb;
        --secondary-color: #64748b;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --bg-light: #f8fafc;
        --bg-white: #ffffff;
        --text-dark: #1e293b;
        --text-gray: #64748b;
        --text-light: #94a3b8;
        --border-color: #e2e8f0;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Base Styles */
    .facility-detail-page {
        background: var(--bg-light);
        min-height: 100vh;
    }

    /* Breadcrumb */
    .breadcrumb-section {
        background: var(--bg-white);
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-gray);
    }

    .breadcrumb a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb a:hover {
        color: var(--primary-hover);
    }

    .breadcrumb-separator {
        color: var(--text-light);
    }

    /* Hero Section */
    .facility-hero {
        background: var(--bg-white);
        padding: 3rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .hero-content {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 3rem;
        align-items: start;
    }

    .hero-main {
        display: flex;
        flex-direction: column;
    }

    .facility-category {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: var(--primary-color);
        color: white;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
        width: fit-content;
    }

    .facility-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .facility-description {
        font-size: 1.125rem;
        color: var(--text-gray);
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .facility-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background: var(--bg-light);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .meta-icon {
        width: 2rem;
        height: 2rem;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .meta-content {
        display: flex;
        flex-direction: column;
    }

    .meta-label {
        font-size: 0.75rem;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .meta-value {
        font-weight: 600;
        color: var(--text-dark);
    }

    /* Sidebar */
    .facility-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .sidebar-card {
        background: var(--bg-white);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
    }

    .sidebar-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--primary-color);
        color: white;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        justify-content: center;
    }

    .back-btn:hover {
        background: var(--primary-hover);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .featured-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, var(--warning-color), #f97316);
        color: white;
        border-radius: 12px;
        font-weight: 500;
        text-align: center;
        justify-content: center;
    }

    /* Main Content */
    .main-content {
        padding: 3rem 0;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 3rem;
    }

    .content-main {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .content-section {
        background: var(--bg-white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
    }

    .section-header {
        background: var(--bg-light);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-body {
        padding: 1.5rem;
    }

    /* Image Section */
    .facility-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
    }

    .no-image {
        width: 100%;
        height: 400px;
        background: var(--bg-light);
        border-radius: 12px;
        border: 2px dashed var(--border-color);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
    }

    .no-image svg {
        width: 4rem;
        height: 4rem;
        margin-bottom: 1rem;
    }

    /* Features Section */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: var(--bg-light);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        background: var(--bg-white);
        box-shadow: var(--shadow);
        transform: translateY(-2px);
    }

    .feature-icon {
        width: 2rem;
        height: 2rem;
        background: var(--success-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .feature-text {
        font-weight: 500;
        color: var(--text-dark);
    }

    /* Related Facilities */
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .related-card {
        background: var(--bg-white);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        text-decoration: none;
        color: inherit;
    }

    .related-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .related-no-image {
        width: 100%;
        height: 150px;
        background: var(--bg-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
    }

    .related-content {
        padding: 1rem;
    }

    .related-category {
        font-size: 0.75rem;
        color: var(--primary-color);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .related-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .related-description {
        font-size: 0.875rem;
        color: var(--text-gray);
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .facility-title {
            font-size: 2rem;
        }

        .facility-meta {
            grid-template-columns: 1fr;
        }

        .content-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }

        .related-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .facility-hero {
            padding: 2rem 0;
        }

        .facility-title {
            font-size: 1.75rem;
        }

        .facility-description {
            font-size: 1rem;
        }

        .section-body {
            padding: 1rem;
        }

        .meta-item {
            padding: 0.75rem;
        }
    }

    /* Animation */
    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="facility-detail-page">
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('public.facilities.index') }}">Fasilitas</a>
                <span class="breadcrumb-separator">/</span>
                <span>{{ $facility->name }}</span>
            </nav>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="facility-hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-main">
                    <div class="facility-category">{{ $facility->category_label }}</div>
                    <h1 class="facility-title">{{ $facility->name }}</h1>
                    <p class="facility-description">{{ $facility->description }}</p>
                    
                    <div class="facility-meta">
                        @if($facility->location)
                            <div class="meta-item">
                                <div class="meta-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div class="meta-content">
                                    <div class="meta-label">Lokasi</div>
                                    <div class="meta-value">{{ $facility->location }}</div>
                                </div>
                            </div>
                        @endif

                        @if($facility->capacity)
                            <div class="meta-item">
                                <div class="meta-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div class="meta-content">
                                    <div class="meta-label">Kapasitas</div>
                                    <div class="meta-value">{{ number_format($facility->capacity) }} people</div>
                                </div>
                            </div>
                        @endif

                        <div class="meta-item">
                            <div class="meta-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Status</div>
                                <div class="meta-value">{{ ucfirst($facility->status) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="facility-sidebar">
                    <div class="sidebar-card">
                        <a href="{{ route('public.facilities.index') }}" class="back-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Facilities
                        </a>
                    </div>

                    @if($facility->is_featured)
                        <div class="sidebar-card">
                            <div class="featured-badge">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                Featured Facility
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="main-content">
        <div class="container">
            <div class="content-grid">
                <div class="content-main">
                    <!-- Facility Image -->
                    <div class="content-section fade-in">
                        <div class="section-header">
                            <h2 class="section-title">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Facility Gallery
                            </h2>
                        </div>
                        <div class="section-body">
                            @if($facility->image)
                                <img src="{{ $facility->image_url }}" alt="{{ $facility->name }}" class="facility-image">
                            @else
                                <div class="no-image">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>No image available</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Features & Amenities -->
                    @if($facility->features && count($facility->features) > 0)
                        <div class="content-section fade-in">
                            <div class="section-header">
                                <h2 class="section-title">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Features & Amenities
                                </h2>
                            </div>
                            <div class="section-body">
                                <div class="features-grid">
                                    @foreach($facility->features as $feature)
                                        @if(!empty(trim($feature)))
                                            <div class="feature-item">
                                                <div class="feature-icon">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <span class="feature-text">{{ $feature }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Related Facilities -->
                    @if($relatedFacilities->count() > 0)
                        <div class="content-section fade-in">
                            <div class="section-header">
                                <h2 class="section-title">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                                    </svg>
                                    Related {{ $facility->category_label }} Facilities
                                </h2>
                            </div>
                            <div class="section-body">
                                <div class="related-grid">
                                    @foreach($relatedFacilities as $related)
                                        <a href="{{ route('public.facilities.show', $related) }}" class="related-card">
                                            @if($related->image)
                                                <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="related-image">
                                            @else
                                                <div class="related-no-image">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="related-content">
                                                <div class="related-category">{{ $related->category_label }}</div>
                                                <h3 class="related-title">{{ $related->name }}</h3>
                                                <p class="related-description">{{ Str::limit($related->description, 80) }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="facility-sidebar">
                    <!-- Quick Info -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-title">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Quick Information
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: var(--bg-light); border-radius: 8px;">
                                <span style="color: var(--text-gray); font-size: 0.875rem;">Kategori</span>
                                <span style="font-weight: 600; color: var(--text-dark);">{{ $facility->category_label }}</span>
                            </div>
                            
                            @if($facility->location)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: var(--bg-light); border-radius: 8px;">
                                    <span style="color: var(--text-gray); font-size: 0.875rem;">Lokasi</span>
                                    <span style="font-weight: 600; color: var(--text-dark);">{{ $facility->location }}</span>
                                </div>
                            @endif
                            
                            @if($facility->capacity)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: var(--bg-light); border-radius: 8px;">
                                    <span style="color: var(--text-gray); font-size: 0.875rem;">Kapasitas</span>
                                    <span style="font-weight: 600; color: var(--text-dark);">{{ number_format($facility->capacity) }}</span>
                                </div>
                            @endif
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: var(--bg-light); border-radius: 8px;">
                                <span style="color: var(--text-gray); font-size: 0.875rem;">Status</span>
                                <span style="font-weight: 600; color: var(--success-color);">{{ ucfirst($facility->status) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="sidebar-card">
                        <h3 class="sidebar-title">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Need More Information?
                        </h3>
                        <p style="color: var(--text-gray); margin-bottom: 1rem; font-size: 0.875rem; line-height: 1.5;">
                            Contact our administration office for more details about this facility or to schedule a visit.
                        </p>
                        <a href="{{ route('contact') }}" class="back-btn" style="background: var(--success-color);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add scroll effect to content sections
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = '0.1s';
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.content-section').forEach(section => {
        observer.observe(section);
    });

    // Smooth scroll for anchor links
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
});
</script>
@endsection