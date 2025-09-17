@extends('layouts.public')

@section('title', 'Photo Gallery')

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

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        i,
        svg {
            width: 18px;
            height: 18px;
            font-size: 16px;
            vertical-align: middle;
        }

        /* Enhanced Hero Section matching profile page */
        .gallery-hero {
            background: linear-gradient(135deg,
                    rgba(30, 64, 175, 0.9) 0%,
                    rgba(59, 130, 246, 0.8) 50%,
                    rgba(30, 64, 175, 0.9) 100%),
                url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
            color: white;
            padding: 100px 0 60px;
            position: relative;
            overflow: hidden;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }

        .gallery-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(96, 165, 250, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.4;
            z-index: 1;
        }

        .hero-content {
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1rem;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            opacity: 0.95;
            line-height: 1.6;
            margin-bottom: 2.5rem;
            font-weight: 400;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .hero-stat {
            text-align: center;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .hero-stat:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .hero-stat-number {
            font-size: 2rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
        }

        .hero-stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Enhanced Search Bar */
        .hero-search {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }

        .hero-search input {
            width: 100%;
            padding: 1rem 3.5rem 1rem 1.5rem;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .hero-search input::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        .hero-search input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
        }

        .search-icon,
        .clear-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .search-icon {
            left: 1.2rem;
            pointer-events: none;
        }

        .clear-icon {
            right: 1.2rem;
            opacity: 0;
            visibility: hidden;
        }

        .clear-icon.show {
            opacity: 1;
            visibility: visible;
        }

        .clear-icon:hover {
            color: white;
            transform: translateY(-50%) scale(1.1);
        }

        /* Gallery Container */
        .gallery-container {
            max-width: 1400px;
            margin: -30px auto 0;
            padding: 0 1rem 4rem;
            position: relative;
            z-index: 10;
        }

        /* Enhanced Filter Section */
        .filter-section {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 2.5rem;
            margin-bottom: 3rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .filter-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .filter-controls {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        /* Search Container */
        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            min-width: 280px;
        }
        
        .search-container:focus-within {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }
        
        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: none;
            outline: none;
            font-size: 14px;
            background: transparent;
        }
        
        .search-input::placeholder {
            color: #9ca3af;
        }
        
        .search-btn,
        .clear-search-btn {
            padding: 12px;
            border: none;
            background: transparent;
            cursor: pointer;
            color: #6b7280;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .search-btn:hover,
        .clear-search-btn:hover {
            color: var(--secondary-color);
            background: rgba(49, 130, 206, 0.1);
        }
        
        .clear-search-btn {
            border-left: 1px solid #e2e8f0;
        }

        .view-toggle {
            display: flex;
            background: #f1f5f9;
            border-radius: 15px;
            padding: 6px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .view-btn {
            padding: 10px 14px;
            border: none;
            background: transparent;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #64748b;
        }

        .view-btn.active {
            background: white;
            color: var(--primary-blue);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }

        .sort-dropdown {
            position: relative;
        }

        .sort-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 12px 20px;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--gray-700);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .sort-btn:hover {
            border-color: var(--secondary-blue);
            color: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
        }

        .sort-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 15px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            min-width: 220px;
            z-index: 100;
            display: none;
            margin-top: 10px;
            overflow: hidden;
        }

        .sort-menu.show {
            display: block;
            animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sort-option {
            padding: 14px 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .sort-option:hover {
            background: #f8fafc;
            padding-left: 25px;
        }

        .sort-option.active {
            background: var(--secondary-blue);
            color: white;
        }

        .sort-option.active:hover {
            background: var(--primary-blue);
            padding-left: 20px;
        }

        /* Enhanced Category Filters */
        .category-filters {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: white;
            border: 2px solid #e2e8f0;
            color: var(--gray-700);
            padding: 14px 28px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
            transition: left 0.6s ease;
        }

        .filter-btn:hover::before {
            left: 100%;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--gradient-primary);
            border-color: var(--secondary-blue);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
            text-decoration: none;
        }

        .filter-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 700;
            min-width: 25px;
            text-align: center;
        }

        .filter-btn.active .filter-count {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Results Info */
        .results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding: 1.5rem 0;
            border-bottom: 2px solid #e2e8f0;
        }

        .results-count {
            font-weight: 600;
            color: var(--gray-700);
            font-size: 1.1rem;
        }

        .results-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .clear-filters {
            color: var(--secondary-blue);
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .clear-filters:hover {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Enhanced Albums Grid */
        .albums-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .albums-grid.grid-view {
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        }

        .albums-grid.list-view {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .album-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.05);
            opacity: 1;
            transform: translateY(0);
            position: relative;
        }
        
        /* Only apply animation if JavaScript is enabled */
        .js-enabled .album-card {
            opacity: 0;
            transform: translateY(30px);
        }

        .album-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .album-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .album-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .album-card:hover::before {
            transform: scaleX(1);
        }

        .albums-grid.list-view .album-card {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .albums-grid.list-view .album-card:hover {
            transform: translateX(12px);
        }

        .album-thumbnail {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 1 !important;
            visibility: visible !important;
            display: block !important;
        }

        .albums-grid.list-view .album-thumbnail {
            width: 220px;
            height: 170px;
            flex-shrink: 0;
        }

        .album-card:hover .album-thumbnail {
            transform: scale(1.08);
        }

        .album-content {
            padding: 1.75rem;
            flex: 1;
        }

        .album-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1rem;
            line-height: 1.3;
            transition: color 0.3s ease;
        }

        .album-card:hover .album-title {
            color: #3182ce;
        }

        .album-description {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            font-size: 0.95rem;
        }

        .album-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .category-badge {
            background: #f1f5f9;
            color: #475569;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .album-card:hover .category-badge {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Category-specific colors */
        .category-school_events {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #dc2626;
        }

        .category-academic {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #2563eb;
        }

        .category-extracurricular {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            color: #16a34a;
        }

        .category-achievements {
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            color: #d97706;
        }

        .category-facilities {
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
            color: #7c3aed;
        }

        .category-general {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            color: #475569;
        }

        .photo-count,
        .album-date {
            color: #6b7280;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .album-date {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        /* Loading State */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e2e8f0;
            border-top: 4px solid var(--secondary-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem 3rem;
            background: white;
            border-radius: 20px;
            border: 2px dashed #cbd5e1;
            margin-top: 2rem;
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .empty-text {
            color: #6b7280;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* Animation keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .hero-stats {
                gap: 1.5rem;
            }

            .hero-stat {
                padding: 1rem;
                min-width: 100px;
            }

            .hero-stat-number {
                font-size: 1.5rem;
            }

            .albums-grid,
            .albums-grid.grid-view {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .albums-grid.list-view .album-card {
                flex-direction: column;
            }

            .albums-grid.list-view .album-thumbnail {
                width: 100%;
                height: 220px;
            }

            .category-filters {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .filter-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .filter-controls {
                justify-content: center;
            }

            .results-info {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
                text-align: center;
            }

            .filter-section {
                padding: 2rem;
            }

            .gallery-container {
                margin-top: -20px;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }

            .filter-btn {
                padding: 12px 20px;
                font-size: 0.9rem;
            }

            .album-content {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="gallery-hero">
        <div class="hero-content">
            <h1 class="hero-title">Galeri Foto</h1>
            <p class="hero-subtitle">Dokumentasi kegiatan dan momen berharga di SMA Negeri 1 Balong</p>



            <!-- Hero Stats -->
            @if(isset($albums) && count($albums) > 0)
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ count($albums) }}</div>
                        <div class="hero-stat-label">Total Album</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number" id="totalPhotos">
                            {{ array_sum(array_column($albums, 'photo_count')) ?: array_sum(array_map(function ($album) {
                return count($album['photos'] ?? []); }, $albums)) }}
                        </div>
                        <div class="hero-stat-label">Total Foto</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ count(array_unique(array_column($albums, 'category'))) }}</div>
                        <div class="hero-stat-label">Kategori</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="gallery-container">
        @if(isset($albums) && count($albums) > 0)
            <!-- Enhanced Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <h2 class="filter-title">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z" />
                        </svg>
                        Filter & Tampilan
                    </h2>
                    <div class="filter-controls">
                        <!-- View Toggle -->
                        <div class="view-toggle">
                            <button class="view-btn active" data-view="grid" title="Grid View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </button>
                            <button class="view-btn" data-view="list" title="List View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </button>
                        </div>

                        <!-- Sort Dropdown -->
                        <div class="sort-dropdown">
                            <button class="sort-btn" id="sortBtn">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                </svg>
                                <span id="sortLabel">Terbaru</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="sort-menu" id="sortMenu">
                                <div class="sort-option active" data-sort="newest">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Terbaru
                                </div>
                                <div class="sort-option" data-sort="oldest">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Terlama
                                </div>
                                <div class="sort-option" data-sort="name-asc">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Nama A-Z
                                </div>
                                <div class="sort-option" data-sort="name-desc">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Nama Z-A
                                </div>
                                <div class="sort-option" data-sort="photos-desc">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Foto Terbanyak
                                </div>
                                <div class="sort-option" data-sort="photos-asc">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Foto Tersedikit
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Category Filters -->
                <div class="category-filters">
                    <button class="filter-btn active" data-category="all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Semua Album
                        <span class="filter-count">{{ count($albums) }}</span>
                    </button>
                    @php
                        $categories = array_unique(array_column($albums, 'category'));
                        $categoryLabels = [
                            'school_events' => 'Kegiatan Sekolah',
                            'academic' => 'Akademik',
                            'extracurricular' => 'Ekstrakurikuler',
                            'achievements' => 'Prestasi',
                            'facilities' => 'Fasilitas',
                            'general' => 'Umum'
                        ];
                        $categoryIcons = [
                            'school_events' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                            'academic' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                            'extracurricular' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                            'achievements' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                            'facilities' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                            'general' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
                        ];
                    @endphp
                    @foreach($categories as $category)
                        @php
                            $count = count(array_filter($albums, function ($album) use ($category) {
                                return $album['category'] === $category;
                            }));
                        @endphp
                        <button class="filter-btn" data-category="{{ $category }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $categoryIcons[$category] ?? 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' }}" />
                            </svg>
                            {{ $categoryLabels[$category] ?? ucfirst(str_replace('_', ' ', $category)) }}
                            <span class="filter-count">{{ $count }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Results Info -->
            <div class="results-info">
                <div class="results-count">
                    Menampilkan <span id="visibleCount">{{ count($albums) }}</span> dari <span
                        id="totalCount">{{ count($albums) }}</span> album
                </div>
                <div class="results-actions">
                    <a href="#" class="clear-filters" id="clearFilters" style="display: none;">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Hapus Filter
                    </a>
                </div>
            </div>

            <!-- Enhanced Albums Grid -->
            <div class="albums-grid grid-view" id="albumsGrid">
                @foreach($albums as $album)
                    <div class="album-card" data-category="{{ $album['category'] }}" data-title="{{ strtolower($album['title']) }}"
                        data-description="{{ strtolower($album['description'] ?? '') }}"
                        data-date="{{ $album['created_at'] ?? '' }}"
                        data-photos="{{ $album['photo_count'] ?? count($album['photos'] ?? []) }}"
                        onclick="window.location.href='{{ route('gallery.show', $album['slug']) }}'">
                        @if(isset($album['photos'][0]))
                            <img src="{{ asset('storage/' . $album['photos'][0]['thumbnail_path']) }}" alt="{{ $album['title'] }}"
                                class="album-thumbnail" loading="lazy"
                                onerror="this.src='{{ asset('images/placeholder-gallery.jpg') }}'">
                        @else
                            <div class="album-thumbnail"
                                style="background: linear-gradient(135deg, #e5e7eb, #d1d5db); display: flex; align-items: center; justify-content: center;">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        <div class="album-content">
                            <h3 class="album-title">{{ $album['title'] }}</h3>

                            @if(!empty($album['description']))
                                <p class="album-description">{{ Str::limit($album['description'], 120) }}</p>
                            @endif

                            <div class="album-meta">
                                <span class="category-badge category-{{ $album['category'] }}">
                                    {{ $categoryLabels[$album['category']] ?? ucfirst(str_replace('_', ' ', $album['category'])) }}
                                </span>

                                <div class="photo-count">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $album['photo_count'] ?? count($album['photos'] ?? []) }} Foto
                                </div>
                            </div>

                            <div class="album-date">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ isset($album['created_at']) ? \Carbon\Carbon::parse($album['created_at'])->locale('id')->isoFormat('D MMMM Y') : 'Tanggal tidak tersedia' }}
                            </div>
                            
                            <!-- View Album Button -->
                            <div class="album-actions" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                                <span style="display: inline-flex; align-items: center; gap: 0.5rem; color: #3182ce; font-weight: 600; font-size: 0.9rem;">
                                    Lihat Album
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="empty-title">Belum Ada Album Foto</h2>
                <p class="empty-text">Galeri foto sedang dalam persiapan. Silakan kembali lagi nanti untuk melihat dokumentasi
                    kegiatan sekolah yang menarik!</p>
            </div>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Add js-enabled class to enable animations
    document.body.classList.add('js-enabled');
    
    // Initialize variables
    let currentCategory = 'all';
    let currentSort = 'newest';
    let currentView = 'grid';
    let searchQuery = '';
            const albumsGrid = document.getElementById('albumsGrid');
            const albumCards = document.querySelectorAll('.album-card');
            const filterButtons = document.querySelectorAll('.filter-btn');
            const viewButtons = document.querySelectorAll('.view-btn');
            const sortBtn = document.getElementById('sortBtn');
            const sortMenu = document.getElementById('sortMenu');
    const sortLabel = document.getElementById('sortLabel');
    const sortOptions = document.querySelectorAll('.sort-option');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const clearFilters = document.getElementById('clearFilters');
    const visibleCount = document.getElementById('visibleCount');
    const totalCount = document.getElementById('totalCount');
    const loadingOverlay = document.getElementById('loadingOverlay');

            // Initialize animations with staggered delays
            function initializeAnimations() {
                albumCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('show');
                    }, index * 100);
                });
            }

            // Enhanced filter functionality
            function filterAlbums() {
                showLoading();

                setTimeout(() => {
                    let visibleCards = 0;

                    albumCards.forEach((card, index) => {
                        const cardCategory = card.dataset.category;
                        const cardTitle = card.dataset.title;
                        const cardDescription = card.dataset.description;

                // Category filter
                const categoryMatch = currentCategory === 'all' || cardCategory === currentCategory;
                
                // Search filter
                const searchMatch = searchQuery === '' || 
                    cardTitle.includes(searchQuery.toLowerCase()) || 
                    cardDescription.includes(searchQuery.toLowerCase());
                
                if (categoryMatch && searchMatch) {
                    card.style.display = 'block';
                    card.classList.remove('show');
                    setTimeout(() => {
                        card.classList.add('show');
                    }, index * 50);
                    visibleCards++;
                } else {
                    card.classList.remove('show');
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 200);
                }
                    });

                    // Update visible count with animation
                    const countElement = document.getElementById('visibleCount');
                    animateNumber(countElement, visibleCards);

            // Show/hide clear filters button
            const hasActiveFilters = currentCategory !== 'all' || searchQuery !== '';
            clearFilters.style.display = hasActiveFilters ? 'block' : 'none';

                    // Update hero stats if visible
                    updateHeroStats();

                    hideLoading();
                }, 300);
            }

            // Enhanced sort functionality
            function sortAlbums() {
                showLoading();

                setTimeout(() => {
                    const cardsArray = Array.from(albumCards);

                    cardsArray.sort((a, b) => {
                        switch (currentSort) {
                            case 'newest':
                                return new Date(b.dataset.date) - new Date(a.dataset.date);
                            case 'oldest':
                                return new Date(a.dataset.date) - new Date(b.dataset.date);
                            case 'name-asc':
                                return a.dataset.title.localeCompare(b.dataset.title);
                            case 'name-desc':
                                return b.dataset.title.localeCompare(a.dataset.title);
                            case 'photos-desc':
                                return parseInt(b.dataset.photos) - parseInt(a.dataset.photos);
                            case 'photos-asc':
                                return parseInt(a.dataset.photos) - parseInt(b.dataset.photos);
                            default:
                                return 0;
                        }
                    });

                    // Remove all cards from grid with animation
                    cardsArray.forEach(card => {
                        card.classList.remove('show');
                    });

                    setTimeout(() => {
                        // Re-append cards in sorted order
                        cardsArray.forEach(card => {
                            albumsGrid.appendChild(card);
                        });

                        // Re-animate visible cards with staggered timing
                        cardsArray.forEach((card, index) => {
                            if (card.style.display !== 'none') {
                                setTimeout(() => {
                                    card.classList.add('show');
                                }, index * 60);
                            }
                        });

                        hideLoading();
                    }, 250);
                }, 200);
            }

            // Enhanced view toggle functionality
            function toggleView(view) {
                currentView = view;

                // Update button states with smooth transitions
                viewButtons.forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.view === view);
                });

                // Update grid class with transition
                albumsGrid.className = `albums-grid ${view}-view`;

                // Re-animate cards with new layout
                albumCards.forEach((card, index) => {
                    card.classList.remove('show');
                    setTimeout(() => {
                        if (card.style.display !== 'none') {
                            card.classList.add('show');
                        }
                    }, index * 40);
                });
            }

            // Animate numbers
            function animateNumber(element, target) {
                const start = parseInt(element.textContent);
                const duration = 800;
                const startTime = performance.now();

                function update(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const current = Math.round(start + (target - start) * easeOutQuart(progress));

                    element.textContent = current;

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    }
                }

                requestAnimationFrame(update);
            }

            // Easing function for smooth animation
            function easeOutQuart(t) {
                return 1 - (--t) * t * t * t;
            }

            // Update hero statistics
            function updateHeroStats() {
                const visibleCards = Array.from(albumCards).filter(card => card.style.display !== 'none');
                const totalPhotosElement = document.getElementById('totalPhotos');

                if (totalPhotosElement) {
                    const totalPhotos = visibleCards.reduce((sum, card) => {
                        return sum + parseInt(card.dataset.photos);
                    }, 0);
                    animateNumber(totalPhotosElement, totalPhotos);
                }
            }

            // Enhanced loading functions
            function showLoading() {
                loadingOverlay.classList.add('show');
                document.body.style.pointerEvents = 'none';
                loadingOverlay.style.pointerEvents = 'auto';
            }

            function hideLoading() {
                loadingOverlay.classList.remove('show');
                document.body.style.pointerEvents = 'auto';
            }

            // Event listeners with enhanced interactions

            // Category filter buttons
            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    if (this.dataset.category === currentCategory) return;

                    currentCategory = this.dataset.category;

                    // Update button states with smooth transitions
                    filterButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.style.transform = '';
                    });
                    this.classList.add('active');

                    filterAlbums();
                });

                // Add hover effects
                button.addEventListener('mouseenter', function () {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateY(-2px)';
                    }
                });

                button.addEventListener('mouseleave', function () {
                    if (!this.classList.contains('active')) {
                        this.style.transform = '';
                    }
                });
            });

            // View toggle buttons
            viewButtons.forEach(button => {
                button.addEventListener('click', function () {
                    if (this.dataset.view === currentView) return;
                    toggleView(this.dataset.view);
                });
            });

            // Sort dropdown with enhanced animations
            sortBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                sortMenu.classList.toggle('show');

                // Add rotation to dropdown arrow
                const arrow = this.querySelector('svg:last-child');
                arrow.style.transform = sortMenu.classList.contains('show') ? 'rotate(180deg)' : '';
            });

            // Sort options
            sortOptions.forEach(option => {
                option.addEventListener('click', function () {
                    if (this.dataset.sort === currentSort) {
                        sortMenu.classList.remove('show');
                        return;
                    }

                    currentSort = this.dataset.sort;

                    // Update active state
                    sortOptions.forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');

                    // Update label with smooth transition
                    sortLabel.style.opacity = '0';
                    setTimeout(() => {
                        sortLabel.textContent = this.textContent.trim();
                        sortLabel.style.opacity = '1';
                    }, 150);

                    // Hide menu
                    sortMenu.classList.remove('show');
                    sortBtn.querySelector('svg:last-child').style.transform = '';

                    sortAlbums();
                });
            });

            // Enhanced search functionality
            let searchTimeout;
            searchInput.addEventListener('input', function () {
                const value = this.value.trim();
                searchQuery = value;

                // Show/hide clear button with smooth transition
                if (value) {
                    clearSearch.classList.add('show');
                } else {
                    clearSearch.classList.remove('show');
                }

                // Debounced search with visual feedback
                clearTimeout(searchTimeout);
                this.style.borderColor = 'rgba(255, 255, 255, 0.5)';

                searchTimeout = setTimeout(() => {
                    this.style.borderColor = '';
                    filterAlbums();
                }, 400);
            });

            // Clear search with animation
            clearSearch.addEventListener('click', function () {
                searchInput.value = '';
                searchQuery = '';
                this.classList.remove('show');

                // Add click animation
                this.style.transform = 'translateY(-50%) scale(0.9)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-50%)';
                }, 150);

                filterAlbums();
                searchInput.focus();
            });

            // Search functionality
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                const value = this.value.trim();
                searchQuery = value;
                
                // Show/hide clear button
                if (value) {
                    clearSearchBtn.style.display = 'block';
                } else {
                    clearSearchBtn.style.display = 'none';
                }
                
                // Debounced search
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    filterAlbums();
                }, 300);
            });
            
            // Search button click - prevent form submission
            searchBtn.addEventListener('click', function(e) {
                e.preventDefault();
                filterAlbums();
            });
            
            // Clear search button
            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchQuery = '';
                this.style.display = 'none';
                filterAlbums();
                searchInput.focus();
            });
            
            // Search on Enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    filterAlbums();
                }
            });

            // Clear all filters
            clearFilters.addEventListener('click', function (e) {
                e.preventDefault();

        // Reset all filters with animation
        currentCategory = 'all';
        searchQuery = '';
        searchInput.value = '';
        clearSearchBtn.style.display = 'none';

                // Reset button states
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.transform = '';
                });
                filterButtons[0].classList.add('active');

                // Add feedback animation
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);

                filterAlbums();
            });

            // Close sort menu when clicking outside
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.sort-dropdown')) {
                    sortMenu.classList.remove('show');
                    sortBtn.querySelector('svg:last-child').style.transform = '';
                }
            });

            // Enhanced keyboard shortcuts
            document.addEventListener('keydown', function (e) {
                // Ctrl/Cmd + F to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    searchInput.focus();
                    searchInput.select();
                }
        
                // Escape to clear search or close dropdown
                if (e.key === 'Escape') {
                    if (searchInput === document.activeElement) {
                        searchInput.blur();
                        if (searchQuery) {
                            clearSearchBtn.click();
                        }
                    } else if (sortMenu.classList.contains('show')) {
                        sortMenu.classList.remove('show');
                        sortBtn.querySelector('svg:last-child').style.transform = '';
                    }
                }

                // Number keys for quick category switching (1-6)
                if (e.key >= '1' && e.key <= '6' && !e.ctrlKey && !e.metaKey && !e.altKey) {
                    const index = parseInt(e.key) - 1;
                    if (filterButtons[index] && !searchInput.matches(':focus')) {
                        filterButtons[index].click();
                    }
                }

                // Arrow keys for view switching
                if ((e.key === 'ArrowLeft' || e.key === 'ArrowRight') && e.shiftKey && !searchInput.matches(':focus')) {
                    e.preventDefault();
                    const currentIndex = Array.from(viewButtons).findIndex(btn => btn.classList.contains('active'));
                    const nextIndex = e.key === 'ArrowRight' ? (currentIndex + 1) % 2 : (currentIndex - 1 + 2) % 2;
                    viewButtons[nextIndex].click();
                }
            });

            // Enhanced card interactions
            albumCards.forEach(card => {
                // Add ripple effect on click
                card.addEventListener('click', function (e) {
                    const ripple = document.createElement('div');
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    ripple.style.cssText = `
                    position: absolute;
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                    background: rgba(59, 130, 246, 0.3);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    left: ${x - 10}px;
                    top: ${y - 10}px;
                    pointer-events: none;
                `;

                    this.style.position = 'relative';
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });

                // Enhanced hover effects
                card.addEventListener('mouseenter', function () {
                    const thumbnail = this.querySelector('.album-thumbnail');
                    if (thumbnail) {
                        thumbnail.style.filter = 'brightness(1.1) saturate(1.1)';
                    }
                });

                card.addEventListener('mouseleave', function () {
                    const thumbnail = this.querySelector('.album-thumbnail');
                    if (thumbnail) {
                        thumbnail.style.filter = '';
                    }
                });
            });

            // Smooth scroll to top functionality
            let scrollButton = null;

            function createScrollButton() {
                scrollButton = document.createElement('button');
                scrollButton.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
            `;
                scrollButton.style.cssText = `
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, #1e40af, #3b82f6);
                color: white;
                border: none;
                border-radius: 50%;
                cursor: pointer;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            `;

                scrollButton.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });

                scrollButton.addEventListener('mouseenter', () => {
                    scrollButton.style.transform = 'translateY(-5px) scale(1.1)';
                    scrollButton.style.boxShadow = '0 15px 35px rgba(59, 130, 246, 0.6)';
                });

                scrollButton.addEventListener('mouseleave', () => {
                    scrollButton.style.transform = '';
                    scrollButton.style.boxShadow = '0 8px 25px rgba(59, 130, 246, 0.4)';
                });

                document.body.appendChild(scrollButton);
            }

            // Show/hide scroll button
            window.addEventListener('scroll', () => {
                if (!scrollButton) createScrollButton();

                if (window.pageYOffset > 300) {
                    scrollButton.style.opacity = '1';
                    scrollButton.style.visibility = 'visible';
                } else {
                    scrollButton.style.opacity = '0';
                    scrollButton.style.visibility = 'hidden';
                }
            });

            // Parallax effect for hero section
            let ticking = false;

            function updateParallax() {
                const scrolled = window.pageYOffset;
                const hero = document.querySelector('.gallery-hero');

                if (hero && scrolled < window.innerHeight) {
                    hero.style.transform = `translateY(${scrolled * 0.5}px)`;

                    // Fade out hero content on scroll
                    const heroContent = hero.querySelector('.hero-content');
                    const opacity = Math.max(0, 1 - scrolled / (window.innerHeight * 0.7));
                    heroContent.style.opacity = opacity;
                }

                ticking = false;
            }

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            });

            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }

            .album-card {
                overflow: hidden;
            }
        `;
            document.head.appendChild(style);

            // Initialize page
            setTimeout(() => {
                initializeAnimations();

                // Set total count
                if (totalCount) {
                    totalCount.textContent = albumCards.length;
                }

                // Add entrance animation to filter section
                const filterSection = document.querySelector('.filter-section');
                if (filterSection) {
                    filterSection.style.opacity = '0';
                    filterSection.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        filterSection.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                        filterSection.style.opacity = '1';
                        filterSection.style.transform = 'translateY(0)';
                    }, 500);
                }

                // Initialize page load tracking
                document.body.classList.add('page-loaded');

                console.log('Enhanced gallery with advanced interactions loaded successfully!');
            }, 100);

            // Performance optimization: Lazy loading for images
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            // Observe all album thumbnails for lazy loading
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });

            // Add loading states for better UX
            filterButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const icon = this.querySelector('svg');
                    if (icon) {
                        icon.style.animation = 'spin 0.5s linear';
                        setTimeout(() => {
                            icon.style.animation = '';
                        }, 500);
                    }
                });
            });

            // Enhanced accessibility
            albumCards.forEach((card, index) => {
                card.setAttribute('tabindex', '0');
                card.setAttribute('role', 'button');
                card.setAttribute('aria-label', `Lihat album ${card.querySelector('.album-title')?.textContent}`);

                card.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });

            // Add focus styles for better accessibility
            const focusStyle = document.createElement('style');
            focusStyle.textContent = `
            .album-card:focus {
                outline: 3px solid rgba(59, 130, 246, 0.5);
                outline-offset: 2px;
            }

            .filter-btn:focus,
            .view-btn:focus,
            .sort-btn:focus {
                outline: 2px solid rgba(59, 130, 246, 0.5);
                outline-offset: 2px;
            }
        `;
            document.head.appendChild(focusStyle);
        });
    </script>
@endsection