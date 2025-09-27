@extends('layouts.admin')

@section('title', 'Backup Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-database me-2"></i>Backup Management
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
                <li class="breadcrumb-item active">Backup</li>
            </ol>
        </nav>
    </div>

    <!-- Backup Actions Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-plus-circle me-2"></i>Create New Backup
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Full Backup -->
                <div class="col-md-4 mb-3">
                    <div class="card border-left-primary h-100">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="text-primary mb-3">
                                    <i class="fas fa-archive fa-3x"></i>
                                </div>
                                <h5 class="card-title">Full Backup</h5>
                                <p class="card-text text-muted">
                                    Backup database dan semua file project
                                </p>
                                <button type="button" class="btn btn-primary btn-backup" data-type="full">
                                    <i class="fas fa-download me-2"></i>Create Full Backup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database Backup -->
                <div class="col-md-4 mb-3">
                    <div class="card border-left-success h-100">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="text-success mb-3">
                                    <i class="fas fa-database fa-3x"></i>
                                </div>
                                <h5 class="card-title">Database Backup</h5>
                                <p class="card-text text-muted">
                                    Backup database saja (SQL dump)
                                </p>
                                <button type="button" class="btn btn-success btn-backup" data-type="database">
                                    <i class="fas fa-download me-2"></i>Create DB Backup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Files Backup -->
                <div class="col-md-4 mb-3">
                    <div class="card border-left-warning h-100">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="text-warning mb-3">
                                    <i class="fas fa-folder fa-3x"></i>
                                </div>
                                <h5 class="card-title">Files Backup</h5>
                                <p class="card-text text-muted">
                                    Backup file project saja (tanpa database)
                                </p>
                                <button type="button" class="btn btn-warning btn-backup" data-type="files">
                                    <i class="fas fa-download me-2"></i>Create Files Backup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Info -->
            <div class="alert alert-info mt-3">
                <h6><i class="fas fa-info-circle me-2"></i>Backup Information:</h6>
                <ul class="mb-0">
                    <li><strong>Backup Location:</strong> <code>{{ $backupPath }}</code></li>
                    <li><strong>Full Backup:</strong> Includes database + project files (app, config, database, resources, routes, public)</li>
                    <li><strong>Database Backup:</strong> MySQL dump with structure and data</li>
                    <li><strong>Files Backup:</strong> Project source code (excludes vendor, node_modules, cache)</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Existing Backups -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-history me-2"></i>Existing Backups
            </h6>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                <i class="fas fa-sync-alt me-1"></i>Refresh
            </button>
        </div>
        <div class="card-body">
            @if(count($backups) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="backupsTable">
                        <thead>
                            <tr>
                                <th>Backup Name</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $backup)
                                <tr>
                                    <td>
                                        <i class="fas fa-file-archive text-primary me-2"></i>
                                        {{ $backup['name'] }}
                                    </td>
                                    <td>
                                        @if($backup['type'] === 'Full Backup')
                                            <span class="badge bg-primary">{{ $backup['type'] }}</span>
                                        @elseif($backup['type'] === 'Database Only')
                                            <span class="badge bg-success">{{ $backup['type'] }}</span>
                                        @elseif($backup['type'] === 'Files Only')
                                            <span class="badge bg-warning">{{ $backup['type'] }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $backup['type'] }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $backup['size'] }}</td>
                                    <td>{{ $backup['date'] }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.backup.download', $backup['name']) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger btn-delete-backup" 
                                                    data-filename="{{ $backup['name'] }}"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-muted mb-3">
                        <i class="fas fa-inbox fa-4x"></i>
                    </div>
                    <h5 class="text-muted">No Backups Found</h5>
                    <p class="text-muted">Create your first backup using the options above.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-cog fa-spin me-2"></i>Creating Backup...
                </h5>
            </div>
            <div class="modal-body text-center">
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                         role="progressbar" 
                         style="width: 100%">
                    </div>
                </div>
                <p class="text-muted mb-0">Please wait while we create your backup...</p>
                <small class="text-muted">This may take a few minutes depending on the size of your data.</small>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this backup?</p>
                <p class="text-muted mb-0">
                    <strong>File:</strong> <span id="deleteFileName"></span>
                </p>
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This action cannot be undone!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash me-2"></i>Delete Backup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('scripts')
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('Backup page loaded');
    
    // Check if required libraries are loaded
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded');
        return;
    }
    
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert2 is not loaded');
        // Fallback to basic alerts
        window.Swal = {
            fire: function(options) {
                if (typeof options === 'object') {
                    alert(options.title + '\n' + (options.text || options.html || ''));
                } else {
                    alert(options);
                }
                return Promise.resolve();
            }
        };
    }
    
    // Initialize DataTable if table exists
    if ($('#backupsTable').length > 0) {
        try {
            $('#backupsTable').DataTable({
                "order": [[ 3, "desc" ]], // Sort by date descending
                "pageLength": 10,
                "responsive": true
            });
            console.log('DataTable initialized');
        } catch (e) {
            console.error('DataTable initialization failed:', e);
        }
    }

    // Backup creation
    $('.btn-backup').click(function(e) {
        e.preventDefault();
        console.log('Backup button clicked');
        
        const type = $(this).data('type');
        const button = $(this);
        
        console.log('Backup type:', type);
        
        // Check CSRF token
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
            alert('CSRF token not found. Please refresh the page.');
            return;
        }
        
        // Show progress modal
        const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
        progressModal.show();
        
        // Disable button
        button.prop('disabled', true);
        
        console.log('Making AJAX request to:', `/admin/backup/create-${type}`);
        
        // Make AJAX request
        $.ajax({
            url: `/admin/backup/create-${type}`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            timeout: 300000, // 5 minutes timeout
            beforeSend: function() {
                console.log('AJAX request started');
            },
            success: function(response) {
                console.log('AJAX success:', response);
                progressModal.hide();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Backup Created!',
                        html: `
                            <p>${response.message}</p>
                            <div class="mt-3">
                                <strong>File:</strong> ${response.backup_name}<br>
                                <strong>Size:</strong> ${response.size}
                            </div>
                        `,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Backup Failed',
                        text: response.message || 'Unknown error occurred'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', xhr, status, error);
                progressModal.hide();
                
                let errorMessage = 'An error occurred while creating backup.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        const errorData = JSON.parse(xhr.responseText);
                        errorMessage = errorData.message || errorMessage;
                    } catch (e) {
                        errorMessage = `Server error (${xhr.status}): ${xhr.statusText}`;
                    }
                } else if (status === 'timeout') {
                    errorMessage = 'Request timeout. The backup process may still be running.';
                } else {
                    errorMessage = `Network error: ${error}`;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Backup Failed',
                    text: errorMessage,
                    footer: xhr.responseJSON && xhr.responseJSON.debug_info ? 
                           `<small>Debug: ${JSON.stringify(xhr.responseJSON.debug_info)}</small>` : ''
                });
            },
            complete: function() {
                console.log('AJAX request completed');
                button.prop('disabled', false);
            }
        });
    });

    // Delete backup
    $('.btn-delete-backup').click(function(e) {
        e.preventDefault();
        const filename = $(this).data('filename');
        $('#deleteFileName').text(filename);
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
        
        $('#confirmDelete').off('click').on('click', function() {
            $.ajax({
                url: '/admin/backup/delete',
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    filename: filename
                },
                success: function(response) {
                    deleteModal.hide();
                    
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Delete Failed',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    deleteModal.hide();
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete Failed',
                        text: 'An error occurred while deleting the backup.'
                    });
                }
            });
        });
    });
    
    // Test button functionality
    console.log('Found backup buttons:', $('.btn-backup').length);
    console.log('CSRF token:', $('meta[name="csrf-token"]').attr('content'));
});
</script>
@endpush