@extends('layouts.admin')

@section('title', 'Security Violation Details')
@section('page-title', 'Security Violation #' . $securityViolation->id)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <!-- Violation Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                        Violation Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Violation ID:</strong></td>
                                    <td>#{{ $securityViolation->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td>{{ $securityViolation->violation_date->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Time:</strong></td>
                                    <td>{{ $securityViolation->violation_time->format('H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td>
                                        <span class="badge bg-info">{{ $securityViolation->violation_type_text ?? 'QR Code Misuse' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Severity:</strong></td>
                                    <td>
                                        @php
                                            $severityColors = [
                                                'low' => 'success',
                                                'medium' => 'warning',
                                                'high' => 'danger',
                                                'critical' => 'dark'
                                            ];
                                            $color = $severityColors[$securityViolation->severity] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ ucfirst($securityViolation->severity) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'reviewed' => 'info',
                                                'resolved' => 'success',
                                                'dismissed' => 'secondary'
                                            ];
                                            $color = $statusColors[$securityViolation->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ ucfirst($securityViolation->status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Location:</strong></td>
                                    <td>{{ $securityViolation->location ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>IP Address:</strong></td>
                                    <td>
                                        <code>{{ $securityViolation->ip_address ?? 'N/A' }}</code>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>User Agent:</strong></td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($securityViolation->user_agent ?? 'N/A', 50) }}</small>
                                    </td>
                                </tr>
                                @if($securityViolation->reviewed_at)
                                <tr>
                                    <td><strong>Reviewed At:</strong></td>
                                    <td>{{ $securityViolation->reviewed_at->format('d F Y H:i:s') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Violator Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user text-danger"></i>
                        Violator Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($securityViolation->violatorStudent)
                        <div class="row">
                            <div class="col-md-3">
                                @if($securityViolation->violatorStudent->photo_url)
                                    <img src="{{ $securityViolation->violatorStudent->photo_url }}" 
                                         alt="{{ $securityViolation->violatorStudent->name }}" 
                                         class="img-fluid rounded">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <i class="fas fa-user fa-3x text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{ $securityViolation->violatorStudent->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIS:</strong></td>
                                        <td>{{ $securityViolation->violatorStudent->nis }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Class:</strong></td>
                                        <td>{{ $securityViolation->violatorStudent->class }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $securityViolation->violatorStudent->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td>{{ $securityViolation->violatorStudent->phone ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Violator information not available
                        </div>
                    @endif
                </div>
            </div>

            <!-- QR Code Owner Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-qrcode text-primary"></i>
                        QR Code Owner Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($securityViolation->qrOwnerStudent)
                        <div class="row">
                            <div class="col-md-3">
                                @if($securityViolation->qrOwnerStudent->photo_url)
                                    <img src="{{ $securityViolation->qrOwnerStudent->photo_url }}" 
                                         alt="{{ $securityViolation->qrOwnerStudent->name }}" 
                                         class="img-fluid rounded">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <i class="fas fa-user fa-3x text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{ $securityViolation->qrOwnerStudent->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>NIS:</strong></td>
                                        <td>{{ $securityViolation->qrOwnerStudent->nis }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Class:</strong></td>
                                        <td>{{ $securityViolation->qrOwnerStudent->class }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $securityViolation->qrOwnerStudent->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td>{{ $securityViolation->qrOwnerStudent->phone ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            QR Code owner information not available
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Details -->
            @if($securityViolation->additional_data)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i>
                        Additional Details
                    </h5>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>{{ json_encode(json_decode($securityViolation->additional_data), JSON_PRETTY_PRINT) }}</code></pre>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body">
                    @if($securityViolation->status === 'pending')
                        <form method="POST" action="{{ route('admin.security-violations.review', $securityViolation->id) }}" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label for="status" class="form-label">Update Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="reviewed">Mark as Reviewed</option>
                                    <option value="resolved">Mark as Resolved</option>
                                    <option value="dismissed">Dismiss</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Admin Notes</label>
                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" placeholder="Add your notes about this violation...">{{ $securityViolation->admin_notes }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-check"></i> Update Status
                            </button>
                        </form>
                    @endif

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.security-violations.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        
                        @if($securityViolation->violatorStudent)
                        <a href="{{ route('admin.students.show', $securityViolation->violatorStudent->id) }}" class="btn btn-outline-info">
                            <i class="fas fa-user"></i> View Violator Profile
                        </a>
                        @endif
                        
                        @if($securityViolation->qrOwnerStudent)
                        <a href="{{ route('admin.students.show', $securityViolation->qrOwnerStudent->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-qrcode"></i> View QR Owner Profile
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Review History -->
            @if($securityViolation->reviewed_at)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history"></i>
                        Review History
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Violation Reported</h6>
                                <p class="text-muted mb-0">{{ $securityViolation->violation_time->format('d F Y H:i:s') }}</p>
                            </div>
                        </div>
                        
                        @if($securityViolation->reviewed_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Reviewed by {{ $securityViolation->reviewedBy->name ?? 'Admin' }}</h6>
                                <p class="text-muted mb-0">{{ $securityViolation->reviewed_at->format('d F Y H:i:s') }}</p>
                                @if($securityViolation->admin_notes)
                                    <p class="mt-2 mb-0"><strong>Notes:</strong> {{ $securityViolation->admin_notes }}</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Admin Notes -->
            @if($securityViolation->admin_notes)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sticky-note"></i>
                        Admin Notes
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $securityViolation->admin_notes }}</p>
                    @if($securityViolation->reviewedBy)
                        <hr>
                        <small class="text-muted">
                            <i class="fas fa-user"></i> {{ $securityViolation->reviewedBy->name }}
                            <i class="fas fa-clock ml-2"></i> {{ $securityViolation->reviewed_at->format('d F Y H:i:s') }}
                        </small>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}
</style>
@endpush