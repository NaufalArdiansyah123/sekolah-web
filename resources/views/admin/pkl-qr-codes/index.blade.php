@extends('layouts.admin')

@section('title', 'PKL QR Codes')

@section('content')
    <style>
        /* Minimal Monochrome Styling */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f7f7f7;
            --bg-tertiary: #efefef;
            --text-primary: #111111;
            --text-secondary: #555555;
            --border-color: #dddddd;
            --accent-color: #222222;
        }

        .dark {
            --bg-primary: #1e293b;
            --bg-secondary: #0f172a;
            --bg-tertiary: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: #334155;
        }

        .qr-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .qr-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
            transition: all 0.2s;
            color: var(--text-primary);
        }

        .qr-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .qr-header {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .qr-student-name {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .qr-company-name {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .qr-content {
            padding: 1.5rem;
            text-align: center;
        }

        .qr-code-image {
            width: 200px;
            height: 200px;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            object-fit: contain;
        }

        .qr-info {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .qr-info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.25rem 0;
            font-size: 0.875rem;
        }

        .qr-info-label {
            font-weight: 500;
            color: var(--text-secondary);
        }

        .qr-info-value {
            color: var(--text-primary);
            font-family: monospace;
        }

        .qr-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid var(--accent-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            filter: brightness(1.1);
        }

        .btn-secondary {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background-color: var(--border-color);
        }

        .search-container {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(34, 34, 34, 0.1);
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-approved {
            background-color: #dcfce7;
            color: #166534;
        }

        .dark .status-approved {
            background-color: #14532d;
            color: #bbf7d0;
        }
    </style>

    <div class="container mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold" style="color: var(--text-primary)">
                        <i class="fas fa-qrcode mr-3"></i>PKL QR Codes
                    </h1>
                    <p class="text-sm mt-1" style="color: var(--text-secondary)">
                        Manage QR codes for approved PKL registrations
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.pkl-registrations.index') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Back to PKL Registrations
                    </a>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="search-container">
            <form method="GET" action="{{ route('admin.pkl-qr-codes.index') }}" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by student name, email, or company name..." class="search-input">
                </div>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.pkl-qr-codes.index') }}" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Results Count -->
        <div class="mb-4">
            <p class="text-sm" style="color: var(--text-secondary)">
                Showing {{ $pklQrCodes->count() }} of {{ $pklQrCodes->total() }} QR codes
                @if(request('search'))
                    for "{{ request('search') }}"
                @endif
            </p>
        </div>

        <!-- QR Codes Grid -->
        @if($pklQrCodes->count() > 0)
            <div class="qr-grid">
                @foreach($pklQrCodes as $registration)
                    <div class="qr-card">
                        <div class="qr-header">
                            <div class="qr-student-name">
                                {{ $registration->student->name }}
                            </div>
                            <div class="qr-company-name">
                                {{ $registration->tempatPkl->nama_tempat }}
                            </div>
                        </div>

                        <div class="qr-content">
                            <!-- QR Code Image -->
                            <div class="mb-4">
                                <img src="{{ $registration->qr_image_url }}" alt="QR Code for {{ $registration->student->name }}"
                                    class="qr-code-image">
                            </div>

                            <!-- Status Badge -->
                            <div class="mb-4">
                                <span class="status-badge status-approved">
                                    <i class="fas fa-check-circle mr-1"></i>Approved
                                </span>
                            </div>

                            <!-- QR Info -->
                            <div class="qr-info">
                                <div class="qr-info-item">
                                    <span class="qr-info-label">QR Code:</span>
                                    <span class="qr-info-value">{{ Str::limit($registration->qr_code, 20) }}</span>
                                </div>
                                <div class="qr-info-item">
                                    <span class="qr-info-label">Generated:</span>
                                    <span class="qr-info-value">{{ $registration->updated_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="qr-actions">
                                <a href="{{ route('admin.pkl-registrations.view-qr', $registration) }}" class="btn-primary"
                                    title="View QR Code">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.pkl-registrations.download-qr', $registration) }}" class="btn-secondary"
                                    title="Download QR Code">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="{{ route('admin.pkl-registrations.show', $registration) }}" class="btn-secondary"
                                    title="View Details">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $pklQrCodes->appends(request()->query())->links() }}
            </div>
        @else
            <div class="no-results">
                <i class="fas fa-qrcode fa-4x mb-4" style="color: var(--text-secondary); opacity: 0.5;"></i>
                <h3 class="text-xl font-semibold mb-2" style="color: var(--text-primary)">No QR Codes Found</h3>
                <p style="color: var(--text-secondary)">
                    @if(request('search'))
                        No QR codes found matching your search criteria.
                    @else
                        No approved PKL registrations with QR codes found.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('admin.pkl-qr-codes.index') }}" class="btn-primary mt-4">
                        <i class="fas fa-times mr-2"></i>Clear Search
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection