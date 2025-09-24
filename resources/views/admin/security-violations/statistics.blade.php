@extends('layouts.admin')

@section('title', 'Security Violations Statistics')
@section('page-title', 'Security Violations Statistics')

@section('content')
<div class="container-fluid">
    <!-- Date Range Filter -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Date Range Filter</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.security-violations.statistics') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ $dateFrom }}">
                </div>
                <div class="col-md-4">
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ $dateTo }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Apply Filter
                        </button>
                        <a href="{{ route('admin.security-violations.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_violations'] ?? 0 }}</h4>
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
                            <h4 class="mb-0">{{ $stats['by_status']['pending'] ?? 0 }}</h4>
                            <p class="mb-0">Pending</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['by_status']['resolved'] ?? 0 }}</h4>
                            <p class="mb-0">Resolved</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check fa-2x"></i>
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
                            <h4 class="mb-0">{{ ($stats['by_severity']['high'] ?? 0) + ($stats['by_severity']['critical'] ?? 0) }}</h4>
                            <p class="mb-0">High/Critical</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-fire fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Status Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie"></i>
                        Status Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Severity Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie"></i>
                        Severity Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="severityChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Daily Trend -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line"></i>
                        Daily Violations Trend
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="trendChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Violators -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users"></i>
                        Top Violators
                    </h5>
                </div>
                <div class="card-body">
                    @if($stats['top_violators']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Student</th>
                                        <th>NIS</th>
                                        <th>Class</th>
                                        <th>Violations</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['top_violators'] as $index => $violator)
                                    <tr>
                                        <td>
                                            @if($index === 0)
                                                <i class="fas fa-trophy text-warning"></i> #1
                                            @elseif($index === 1)
                                                <i class="fas fa-medal text-secondary"></i> #2
                                            @elseif($index === 2)
                                                <i class="fas fa-award text-warning"></i> #3
                                            @else
                                                #{{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($violator->violatorStudent)
                                                <strong>{{ $violator->violatorStudent->name }}</strong>
                                            @else
                                                <span class="text-muted">Unknown Student</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $violator->violatorStudent->nis ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $violator->violatorStudent->class ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">{{ $violator->violation_count }}</span>
                                        </td>
                                        <td>
                                            @if($violator->violatorStudent)
                                                <a href="{{ route('admin.students.show', $violator->violatorStudent->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View Profile
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No violations found</h5>
                            <p class="text-muted">No violations in the selected date range.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Status Distribution Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = @json($stats['by_status']);
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).map(key => key.charAt(0).toUpperCase() + key.slice(1)),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: [
                '#ffc107', // pending - warning
                '#17a2b8', // reviewed - info
                '#28a745', // resolved - success
                '#6c757d'  // dismissed - secondary
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Severity Distribution Chart
const severityCtx = document.getElementById('severityChart').getContext('2d');
const severityData = @json($stats['by_severity']);
new Chart(severityCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(severityData).map(key => key.charAt(0).toUpperCase() + key.slice(1)),
        datasets: [{
            data: Object.values(severityData),
            backgroundColor: [
                '#28a745', // low - success
                '#ffc107', // medium - warning
                '#dc3545', // high - danger
                '#343a40'  // critical - dark
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Daily Trend Chart
const trendCtx = document.getElementById('trendChart').getContext('2d');
const trendData = @json($stats['daily_trend']);
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: trendData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
        }),
        datasets: [{
            label: 'Violations',
            data: trendData.map(item => item.count),
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endpush