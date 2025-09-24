@extends('layouts.admin')

@section('title', 'Security Violations')
@section('page-title', 'Security Violations Management')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['total'] ?? 0 }}</h4>
                            <p class="mb-0">Total Violations</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['pending'] ?? 0 }}</h4>
                            <p class="mb-0">Pending Review</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['today'] ?? 0 }}</h4>
                            <p class="mb-0">Today's Violations</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['this_week'] ?? 0 }}</h4>
                            <p class="mb-0">This Week</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-week fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Filters & Actions</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.security-violations.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="dismissed" {{ request('status') == 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="severity" class="form-label">Severity</label>
                    <select class="form-select" id="severity" name="severity">
                        <option value="">All Severity</option>
                        <option value="low" {{ request('severity') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('severity') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('severity') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Student name or NIS" value="{{ request('search') }}">
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.security-violations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                    <a href="{{ route('admin.security-violations.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                    <a href="{{ route('admin.security-violations.statistics') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar"></i> Statistics
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Violations Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Security Violations</h5>
            <div>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">
                    <i class="fas fa-check-square"></i> Select All
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                    <i class="fas fa-square"></i> Deselect All
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($violations->count() > 0)
                <form id="bulkActionForm" method="POST" action="{{ route('admin.security-violations.bulk-action') }}">
                    @csrf
                    
                    <!-- Bulk Actions -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <select class="form-select" name="action" required>
                                    <option value="">Select Action</option>
                                    <option value="review">Mark as Reviewed</option>
                                    <option value="resolve">Mark as Resolved</option>
                                    <option value="dismiss">Dismiss</option>
                                    <option value="delete">Delete</option>
                                </select>
                                <button type="submit" class="btn btn-primary" onclick="return confirmBulkAction()">
                                    <i class="fas fa-play"></i> Execute
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="admin_notes" placeholder="Admin notes (optional)">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleAll(this)">
                                    </th>
                                    <th>ID</th>
                                    <th>Date/Time</th>
                                    <th>Violator</th>
                                    <th>QR Owner</th>
                                    <th>Type</th>
                                    <th>Severity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($violations as $violation)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="violation_ids[]" value="{{ $violation->id }}" class="violation-checkbox">
                                    </td>
                                    <td>
                                        <strong>#{{ $violation->id }}</strong>
                                    </td>
                                    <td>
                                        <div>{{ $violation->violation_date->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $violation->violation_time->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        @if($violation->violatorStudent)
                                            <div><strong>{{ $violation->violatorStudent->name }}</strong></div>
                                            <small class="text-muted">NIS: {{ $violation->violatorStudent->nis }}</small><br>
                                            <small class="text-muted">{{ $violation->violatorStudent->class }}</small>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($violation->qrOwnerStudent)
                                            <div><strong>{{ $violation->qrOwnerStudent->name }}</strong></div>
                                            <small class="text-muted">NIS: {{ $violation->qrOwnerStudent->nis }}</small><br>
                                            <small class="text-muted">{{ $violation->qrOwnerStudent->class }}</small>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $violation->violation_type_text ?? 'QR Misuse' }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $severityColors = [
                                                'low' => 'success',
                                                'medium' => 'warning',
                                                'high' => 'danger',
                                                'critical' => 'dark'
                                            ];
                                            $color = $severityColors[$violation->severity] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ ucfirst($violation->severity) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'reviewed' => 'info',
                                                'resolved' => 'success',
                                                'dismissed' => 'secondary'
                                            ];
                                            $color = $statusColors[$violation->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ ucfirst($violation->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.security-violations.show', $violation->id) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($violation->status === 'pending')
                                                <button type="button" class="btn btn-sm btn-outline-success" onclick="quickReview({{ $violation->id }})" title="Quick Review">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing {{ $violations->firstItem() }} to {{ $violations->lastItem() }} of {{ $violations->total() }} results
                    </div>
                    <div>
                        {{ $violations->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shield-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No security violations found</h5>
                    <p class="text-muted">No violations match your current filters.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Review Modal -->
<div class="modal fade" id="quickReviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quick Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickReviewForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reviewStatus" class="form-label">Status</label>
                        <select class="form-select" id="reviewStatus" name="status" required>
                            <option value="reviewed">Reviewed</option>
                            <option value="resolved">Resolved</option>
                            <option value="dismissed">Dismissed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reviewNotes" class="form-label">Admin Notes</label>
                        <textarea class="form-control" id="reviewNotes" name="admin_notes" rows="3" placeholder="Optional notes about this violation..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleAll(source) {
    const checkboxes = document.querySelectorAll('.violation-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = source.checked;
    });
}

function selectAll() {
    const checkboxes = document.querySelectorAll('.violation-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    document.getElementById('selectAllCheckbox').checked = true;
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('.violation-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAllCheckbox').checked = false;
}

function confirmBulkAction() {
    const checkedBoxes = document.querySelectorAll('.violation-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Please select at least one violation.');
        return false;
    }
    
    const action = document.querySelector('select[name="action"]').value;
    if (!action) {
        alert('Please select an action.');
        return false;
    }
    
    return confirm(`Are you sure you want to ${action} ${checkedBoxes.length} violation(s)?`);
}

function quickReview(violationId) {
    const form = document.getElementById('quickReviewForm');
    form.action = `{{ route('admin.security-violations.review', '') }}/${violationId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('quickReviewModal'));
    modal.show();
}

// Auto-refresh every 30 seconds for pending violations
setInterval(function() {
    if (window.location.search.includes('status=pending') || !window.location.search.includes('status=')) {
        // Only refresh if we're viewing pending violations or all violations
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.set('_refresh', Date.now());
        
        fetch(currentUrl.toString())
            .then(response => response.text())
            .then(html => {
                // Update only the violations count in the statistics cards
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update pending count
                const pendingCard = document.querySelector('.bg-warning .card-body h4');
                const newPendingCard = doc.querySelector('.bg-warning .card-body h4');
                if (pendingCard && newPendingCard) {
                    pendingCard.textContent = newPendingCard.textContent;
                }
                
                // Update today count
                const todayCard = document.querySelector('.bg-danger .card-body h4');
                const newTodayCard = doc.querySelector('.bg-danger .card-body h4');
                if (todayCard && newTodayCard) {
                    todayCard.textContent = newTodayCard.textContent;
                }
            })
            .catch(error => console.log('Auto-refresh failed:', error));
    }
}, 30000);
</script>
@endpush