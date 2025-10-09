@extends('layouts.admin')

@section('title', 'View Contact - ' . $contact->title)

@push('styles')
<style>
    /* CSS Variables for Dark Mode */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-tertiary: #94a3b8;
        --border-color: #e2e8f0;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --accent-color: #8b5cf6;
        --accent-hover: #7c3aed;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    .dark {
        --bg-primary: #1e293b;
        --bg-secondary: #0f172a;
        --bg-tertiary: #334155;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-tertiary: #94a3b8;
        --border-color: #334155;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    /* Base Styles */
    .show-contact-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .header-actions {
        position: relative;
        z-index: 2;
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.15s ease;
    }

    .btn-back {
        background: white;
        color: var(--accent-color);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: var(--accent-color);
        text-decoration: none;
    }

    .btn-edit {
        background: rgba(245, 158, 11, 0.9);
        color: white;
    }

    .btn-edit:hover {
        background: #d97706;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-public {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }

    .btn-public:hover {
        background: #059669;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.9);
        color: white;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    /* Content Cards */
    .content-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        animation: slideUp 0.5s ease-out;
    }

    .content-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .card-header {
        background: var(--bg-tertiary);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .card-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: color 0.3s ease;
    }

    .card-body {
        padding: 2rem;
        background: var(--bg-primary);
        transition: all 0.3s ease;
    }

    /* Contact Information */
    .contact-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-color);
        border-color: var(--accent-color);
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .info-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        background: var(--accent-color);
    }

    .info-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .info-content {
        color: var(--text-secondary);
        line-height: 1.6;
        word-break: break-word;
    }

    .info-content a {
        color: var(--accent-color);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .info-content a:hover {
        color: var(--accent-hover);
        text-decoration: underline;
    }

    /* Social Media */
    .social-media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .social-item {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .social-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-color);
    }

    .social-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        margin: 0 auto 0.75rem;
        transition: all 0.3s ease;
    }

    .social-icon.facebook { background: #3b5998; }
    .social-icon.instagram { background: linear-gradient(135deg, #e4405f, #833ab4); }
    .social-icon.twitter { background: #1da1f2; }
    .social-icon.youtube { background: #ff0000; }
    .social-icon.linkedin { background: #0077b5; }
    .social-icon.whatsapp { background: #25d366; }
    .social-icon.telegram { background: #0088cc; }

    .social-item:hover .social-icon {
        transform: scale(1.1);
    }

    .social-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .social-link {
        color: var(--accent-color);
        text-decoration: none;
        font-size: 0.75rem;
        word-break: break-all;
    }

    .social-link:hover {
        color: var(--accent-hover);
        text-decoration: underline;
    }

    /* Map Section */
    .map-container {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px var(--shadow-color);
        margin-bottom: 1rem;
    }

    .map-container iframe {
        width: 100%;
        height: 300px;
        border: none;
    }

    /* Sidebar */
    .sidebar-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .sidebar-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .sidebar-info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .info-value {
        font-weight: 600;
        color: var(--text-primary);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: capitalize;
    }

    .badge-active { 
        background: rgba(16, 185, 129, 0.1); 
        color: #059669; 
    }
    
    .badge-inactive { 
        background: rgba(107, 114, 128, 0.1); 
        color: #6b7280; 
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-secondary);
    }

    .empty-state svg {
        width: 4rem;
        height: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .show-contact-page {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .content-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .contact-info-grid {
            grid-template-columns: 1fr;
        }

        .social-media-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
    }

    /* Animation */
    @keyframes slideUp {
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
@endpush

@section('content')
<div class="show-contact-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">{{ $contact->title }}</h1>
            <p class="page-subtitle">Contact Information Details</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.contacts.index') }}" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
            </a>
            <a href="{{ route('admin.contacts.edit', $contact) }}" class="btn btn-edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit
            </a>
            @if($contact->is_active)
                <a href="{{ route('contact') }}" target="_blank" class="btn btn-public">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View Public
                </a>
            @endif
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this contact?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="content-grid">
        <!-- Main Content -->
        <div>
            <!-- Basic Information -->
            <div class="content-card">
                <div class="card-header">
                    <h2>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Contact Information
                    </h2>
                </div>
                <div class="card-body">
                    @if($contact->description)
                        <div style="background: var(--bg-secondary); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border-left: 4px solid var(--accent-color);">
                            <p style="margin: 0; color: var(--text-primary); line-height: 1.6;">{{ $contact->description }}</p>
                        </div>
                    @endif

                    <div class="contact-info-grid">
                        @if($contact->address)
                            <div class="info-item">
                                <div class="info-header">
                                    <div class="info-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <h4 class="info-title">Alamat</h4>
                                </div>
                                <div class="info-content">{{ $contact->address }}</div>
                            </div>
                        @endif

                        @if($contact->phone)
                            <div class="info-item">
                                <div class="info-header">
                                    <div class="info-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <h4 class="info-title">Telepon</h4>
                                </div>
                                <div class="info-content">
                                    <a href="tel:{{ $contact->phone }}">{{ $contact->formatted_phone ?? $contact->phone }}</a>
                                </div>
                            </div>
                        @endif

                        @if($contact->email)
                            <div class="info-item">
                                <div class="info-header">
                                    <div class="info-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h4 class="info-title">Email</h4>
                                </div>
                                <div class="info-content">
                                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                </div>
                            </div>
                        @endif

                        @if($contact->website)
                            <div class="info-item">
                                <div class="info-header">
                                    <div class="info-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"/>
                                        </svg>
                                    </div>
                                    <h4 class="info-title">Website</h4>
                                </div>
                                <div class="info-content">
                                    <a href="{{ $contact->website }}" target="_blank">{{ $contact->website }}</a>
                                </div>
                            </div>
                        @endif

                        @if($contact->office_hours)
                            <div class="info-item">
                                <div class="info-header">
                                    <div class="info-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h4 class="info-title">Office Hours</h4>
                                </div>
                                <div class="info-content">{{ $contact->office_hours }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            @if($contact->social_media && count(array_filter($contact->social_media)) > 0)
                <div class="content-card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V1a1 1 0 011-1h2a1 1 0 011 1v3z"/>
                            </svg>
                            Social Media
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="social-media-grid">
                            @foreach($contact->social_media as $platform => $url)
                                @if($url)
                                    <div class="social-item">
                                        <div class="social-icon {{ $platform }}">
                                            @switch($platform)
                                                @case('facebook')
                                                    <i class="fab fa-facebook-f"></i>
                                                    @break
                                                @case('instagram')
                                                    <i class="fab fa-instagram"></i>
                                                    @break
                                                @case('twitter')
                                                    <i class="fab fa-twitter"></i>
                                                    @break
                                                @case('youtube')
                                                    <i class="fab fa-youtube"></i>
                                                    @break
                                                @case('linkedin')
                                                    <i class="fab fa-linkedin"></i>
                                                    @break
                                                @case('whatsapp')
                                                    <i class="fab fa-whatsapp"></i>
                                                    @break
                                                @case('telegram')
                                                    <i class="fab fa-telegram"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-link"></i>
                                            @endswitch
                                        </div>
                                        <div class="social-title">{{ ucfirst($platform) }}</div>
                                        <a href="{{ $url }}" target="_blank" class="social-link">{{ $url }}</a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Map -->
            @if($contact->map_embed)
                <div class="content-card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            Location Map
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="map-container">
                            @if(strpos($contact->map_embed, '<iframe') !== false)
                                {!! $contact->map_embed !!}
                            @else
                                <iframe src="{{ $contact->map_embed }}" 
                                        width="100%" 
                                        height="300" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            @endif
                        </div>
                        <p style="margin-top: 1rem; color: var(--text-secondary); font-size: 0.875rem; text-align: center;">
                            Click on the map to view location details in Google Maps
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Information -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h2>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Information
                    </h2>
                </div>
                <div class="card-body">
                    <div class="sidebar-info-item">
                        <span class="info-label">Status</span>
                        <span class="badge badge-{{ $contact->is_active ? 'active' : 'inactive' }}">
                            {{ $contact->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="sidebar-info-item">
                        <span class="info-label">Sort Order</span>
                        <span class="info-value">{{ $contact->sort_order ?? 0 }}</span>
                    </div>
                    <div class="sidebar-info-item">
                        <span class="info-label">Created</span>
                        <span class="info-value">{{ $contact->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="sidebar-info-item">
                        <span class="info-label">Terakhir Diperbarui</span>
                        <span class="info-value">{{ $contact->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                    @if($contact->social_media)
                        <div class="sidebar-info-item">
                            <span class="info-label">Social Media</span>
                            <span class="info-value">{{ count(array_filter($contact->social_media)) }} platforms</span>
                        </div>
                    @endif
                    <div class="sidebar-info-item">
                        <span class="info-label">Has Map</span>
                        <span class="info-value">{{ $contact->map_embed ? 'Yes' : 'No' }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h2>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Quick Actions
                    </h2>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @if($contact->is_active)
                            <form action="{{ route('admin.contacts.deactivate', $contact) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="width: 100%; background: rgba(107, 114, 128, 0.1); color: #6b7280; justify-content: center;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                                    </svg>
                                    Deactivate
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.contacts.activate', $contact) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="width: 100%; background: rgba(16, 185, 129, 0.1); color: #059669; justify-content: center;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Activate
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.contacts.edit', $contact) }}" class="btn" style="width: 100%; background: rgba(245, 158, 11, 0.1); color: #d97706; justify-content: center; text-decoration: none;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Contact
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection