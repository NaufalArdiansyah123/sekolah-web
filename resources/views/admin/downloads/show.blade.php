@extends('layouts.admin')

@section('title', 'Detail File Download')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="header-title">
                <i class="fas fa-file-alt me-3"></i>Detail File Download
            </h1>
            <p class="header-subtitle">Informasi lengkap tentang file download</p>
            <div class="header-actions">
                <a href="{{ route('admin.downloads.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
                <a href="{{ route('admin.downloads.edit', $download) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit File
                </a>
            </div>
        </div>
    </div>

    <div class="detail-container">
        <!-- File Preview Section -->
        <div class="file-preview-section">
            <div class="file-preview-card">
                <div class="file-icon-large">
                    @php
                        $extension = pathinfo($download->file_name, PATHINFO_EXTENSION);
                        $iconClass = match(strtolower($extension)) {
                            'pdf' => 'fas fa-file-pdf text-red-500',
                            'doc', 'docx' => 'fas fa-file-word text-blue-500',
                            'xls', 'xlsx' => 'fas fa-file-excel text-green-500',
                            'ppt', 'pptx' => 'fas fa-file-powerpoint text-orange-500',
                            'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image text-purple-500',
                            'mp4', 'avi', 'mov' => 'fas fa-file-video text-red-600',
                            'mp3', 'wav' => 'fas fa-file-audio text-green-600',
                            'zip', 'rar' => 'fas fa-file-archive text-yellow-600',
                            default => 'fas fa-file text-gray-500'
                        };
                    @endphp
                    <i class="{{ $iconClass }}"></i>
                </div>
                
                <div class="file-info">
                    <h2 class="file-title">{{ $download->title }}</h2>
                    <p class="file-name">{{ $download->file_name }}</p>
                    
                    <div class="file-badges">
                        <span class="badge badge-category">{{ ucfirst($download->category) }}</span>
                        <span class="badge {{ $download->status == 'active' ? 'badge-active' : 'badge-inactive' }}">
                            {{ $download->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
                
                <div class="file-actions">
                    <a href="{{ Storage::url($download->file_path) }}" 
                       class="btn btn-primary btn-lg" 
                       target="_blank"
                       onclick="incrementDownloadCount({{ $download->id }})">
                        <i class="fas fa-download me-2"></i>Download File
                    </a>
                    
                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'pdf']))
                    <a href="{{ Storage::url($download->file_path) }}" 
                       class="btn btn-info btn-lg" 
                       target="_blank">
                        <i class="fas fa-eye me-2"></i>Preview
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="details-grid">
            <!-- File Information -->
            <div class="detail-card">
                <h3 class="card-title">
                    <i class="fas fa-info-circle me-2"></i>Informasi File
                </h3>
                <div class="detail-list">
                    <div class="detail-item">
                        <span class="detail-label">Nama File:</span>
                        <span class="detail-value">{{ $download->file_name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Ukuran File:</span>
                        <span class="detail-value">{{ $download->formatted_file_size }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tipe File:</span>
                        <span class="detail-value">{{ strtoupper($extension) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Kategori:</span>
                        <span class="detail-value">
                            @switch($download->category)
                                @case('materi')
                                    📚 Materi Pembelajaran
                                    @break
                                @case('foto')
                                    📸 Foto & Galeri
                                    @break
                                @case('video')
                                    🎥 Video
                                    @break
                                @case('dokumen')
                                    📄 Dokumen
                                    @break
                                @case('formulir')
                                    📋 Formulir
                                    @break
                                @case('panduan')
                                    📖 Panduan
                                    @break
                                @default
                                    {{ ucfirst($download->category) }}
                            @endswitch
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value">
                            <span class="status-badge {{ $download->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                {{ $download->status == 'active' ? '✅ Aktif' : '❌ Tidak Aktif' }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="detail-card">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar me-2"></i>Statistik Download
                </h3>
                <div class="stats-container">
                    <div class="stat-box">
                        <div class="stat-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number" id="downloadCount">{{ $download->download_count }}</span>
                            <span class="stat-label">Total Download</span>
                        </div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $download->created_at->format('d') }}</span>
                            <span class="stat-label">{{ $download->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $download->created_at->diffForHumans() }}</span>
                            <span class="stat-label">Diupload</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="detail-card full-width">
                <h3 class="card-title">
                    <i class="fas fa-align-left me-2"></i>Deskripsi
                </h3>
                <div class="description-content">
                    @if($download->description)
                        <p>{{ $download->description }}</p>
                    @else
                        <p class="no-description">Tidak ada deskripsi untuk file ini.</p>
                    @endif
                </div>
            </div>

            <!-- Upload Information -->
            <div class="detail-card">
                <h3 class="card-title">
                    <i class="fas fa-user me-2"></i>Informasi Upload
                </h3>
                <div class="detail-list">
                    <div class="detail-item">
                        <span class="detail-label">Diupload oleh:</span>
                        <span class="detail-value">
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($download->user->name, 0, 2)) }}
                                </div>
                                <span>{{ $download->user->name }}</span>
                            </div>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tanggal Upload:</span>
                        <span class="detail-value">{{ $download->created_at->format('d F Y, H:i') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Terakhir Diupdate:</span>
                        <span class="detail-value">{{ $download->updated_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- File Actions -->
            <div class="detail-card">
                <h3 class="card-title">
                    <i class="fas fa-cogs me-2"></i>Aksi File
                </h3>
                <div class="action-buttons">
                    <a href="{{ route('admin.downloads.edit', $download) }}" 
                       class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit File
                    </a>
                    
                    <button type="button" 
                            class="btn btn-info"
                            onclick="copyDownloadLink()">
                        <i class="fas fa-link me-2"></i>Copy Link
                    </button>
                    
                    <form action="{{ route('admin.downloads.destroy', $download) }}" 
                          method="POST" 
                          class="inline-block"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus File
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #6b7280;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --light: #f8fafc;
        --dark: #1f2937;
        --gray: #6b7280;
        --light-gray: #e5e7eb;
        --border-radius: 12px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, var(--info) 0%, #1e40af 100%);
        color: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-subtitle {
        font-size: 1.125rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    /* Detail Container */
    .detail-container {
        display: grid;
        gap: 2rem;
    }

    /* File Preview Section */
    .file-preview-section {
        margin-bottom: 2rem;
    }

    .file-preview-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 2rem;
        text-align: center;
    }

    .file-icon-large {
        width: 6rem;
        height: 6rem;
        border-radius: 50%;
        background: var(--light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        box-shadow: var(--shadow);
        flex-shrink: 0;
    }

    .file-info {
        flex-grow: 1;
        text-align: left;
    }

    .file-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .file-name {
        color: var(--gray);
        margin-bottom: 1rem;
        font-size: 1.125rem;
    }

    .file-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .badge-category {
        background: var(--primary);
        color: white;
    }

    .badge-active {
        background: var(--success);
        color: white;
    }

    .badge-inactive {
        background: var(--danger);
        color: white;
    }

    .file-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        flex-shrink: 0;
    }

    /* Details Grid */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .detail-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .detail-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .detail-card.full-width {
        grid-column: 1 / -1;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--dark);
        display: flex;
        align-items: center;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-gray);
    }

    /* Detail List */
    .detail-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--light-gray);
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: var(--gray);
        flex-shrink: 0;
        margin-right: 1rem;
    }

    .detail-value {
        color: var(--dark);
        text-align: right;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .status-inactive {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .user-avatar {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Statistics */
    .stats-container {
        display: grid;
        gap: 1rem;
    }

    .stat-box {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--light);
        border-radius: 8px;
        border: 2px solid var(--light-gray);
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-content {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--gray);
    }

    /* Description */
    .description-content {
        line-height: 1.6;
        color: var(--dark);
    }

    .no-description {
        color: var(--gray);
        font-style: italic;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-lg {
        padding: 1rem 2rem;
        font-size: 1.125rem;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--secondary);
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-warning {
        background: var(--warning);
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
    }

    .btn-info {
        background: var(--info);
        color: white;
    }

    .btn-info:hover {
        background: #2563eb;
    }

    .btn-danger {
        background: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-title {
            font-size: 2rem;
        }
        
        .file-preview-card {
            flex-direction: column;
            text-align: center;
        }
        
        .file-info {
            text-align: center;
        }
        
        .file-actions {
            width: 100%;
        }
        
        .details-grid {
            grid-template-columns: 1fr;
        }
        
        .detail-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .detail-value {
            text-align: left;
        }
        
        .header-actions {
            flex-direction: column;
        }
    }
</style>

<script>
function incrementDownloadCount(downloadId) {
    // Send AJAX request to increment download count
    fetch(`/admin/downloads/${downloadId}/increment-download`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the download count display
            document.getElementById('downloadCount').textContent = data.download_count;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function copyDownloadLink() {
    const downloadUrl = "{{ Storage::url($download->file_path) }}";
    const fullUrl = window.location.origin + downloadUrl;
    
    navigator.clipboard.writeText(fullUrl).then(function() {
        // Show success message
        showToast('success', 'Berhasil!', 'Link download telah disalin ke clipboard');
    }, function(err) {
        console.error('Could not copy text: ', err);
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = fullUrl;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast('success', 'Berhasil!', 'Link download telah disalin ke clipboard');
    });
}

// Toast notification function (if not already defined)
function showToast(type, title, message) {
    // This should match your existing toast implementation
    if (window.showToast) {
        window.showToast(type, title, message);
    } else {
        alert(title + ': ' + message);
    }
}
</script>
@endsection