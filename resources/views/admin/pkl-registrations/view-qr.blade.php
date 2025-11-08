@extends('layouts.admin')

@section('title', 'View QR Code - PKL Registration')

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

        .qr-viewer {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 1.5rem;
        }

        .qr-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            color: var(--text-primary);
            max-width: 600px;
            margin: 0 auto;
        }

        .qr-header {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            text-align: center;
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

        .qr-code-container {
            padding: 2rem;
            text-align: center;
        }

        .qr-code-image {
            max-width: 100%;
            height: auto;
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .qr-info {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .qr-info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .qr-info-item:last-child {
            border-bottom: none;
        }

        .qr-info-label {
            font-weight: 500;
            color: var(--text-secondary);
        }

        .qr-info-value {
            color: var(--text-primary);
            font-family: monospace;
            font-size: 0.875rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>

    <div class="qr-viewer">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                        QR Code Viewer
                    </h1>
                    <p class="text-sm mt-1" style="color: var(--text-secondary)">
                        QR Code untuk PKL Registration - {{ $pklRegistration->student->name }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.pkl-registrations.show', $pklRegistration) }}" class="btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Details
                    </a>
                </div>
            </div>
        </div>

        <!-- QR Code Display -->
        <div class="qr-card">
            <div class="qr-header">
                <h3 class="text-lg font-semibold" style="color: var(--text-primary)">
                    <i class="fas fa-qrcode mr-2"></i>PKL QR Code
                </h3>
            </div>

            <div class="qr-code-container">
                <!-- QR Code Image -->
                <div class="mb-6">
                    <img src="{{ $pklRegistration->qr_image_url }}" alt="QR Code" class="qr-code-image">
                </div>

                <!-- QR Code Information -->
                <div class="qr-info">
                    <div class="qr-info-item">
                        <span class="qr-info-label">Student:</span>
                        <span class="qr-info-value">{{ $pklRegistration->student->name }}</span>
                    </div>
                    <div class="qr-info-item">
                        <span class="qr-info-label">Tempat PKL:</span>
                        <span class="qr-info-value">{{ $pklRegistration->tempatPkl->nama_tempat }}</span>
                    </div>
                    <div class="qr-info-item">
                        <span class="qr-info-label">QR Code:</span>
                        <span class="qr-info-value">{{ $pklRegistration->qr_code }}</span>
                    </div>
                    <div class="qr-info-item">
                        <span class="qr-info-label">Status:</span>
                        <span class="qr-info-value">{{ ucfirst($pklRegistration->status) }}</span>
                    </div>
                    <div class="qr-info-item">
                        <span class="qr-info-label">Generated:</span>
                        <span class="qr-info-value">{{ $pklRegistration->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('admin.pkl-registrations.download-qr', $pklRegistration) }}" class="btn-primary">
                        <i class="fas fa-download mr-2"></i>Download QR Code
                    </a>
                    <form method="POST" action="{{ route('admin.pkl-registrations.regenerate-qr', $pklRegistration) }}"
                        class="d-inline">
                        @csrf
                        <button type="submit" class="btn-secondary"
                            onclick="return confirm('Are you sure you want to regenerate the QR code?')">
                            <i class="fas fa-refresh mr-2"></i>Regenerate
                        </button>
                    </form>
                    <button onclick="window.print()" class="btn-secondary">
                        <i class="fas fa-print mr-2"></i>Print
                    </button>
                </div>
            </div>
        </div>

        <!-- Print Styles -->
        <style media="print">
            .qr-viewer {
                background-color: white !important;
                padding: 0 !important;
            }

            .qr-card {
                border: none !important;
                box-shadow: none !important;
            }

            .qr-header {
                background-color: white !important;
                border-bottom: 2px solid black !important;
            }

            .action-buttons {
                display: none !important;
            }

            .qr-code-image {
                max-width: 300px !important;
                border: 2px solid black !important;
            }
        </style>
    </div>
@endsection