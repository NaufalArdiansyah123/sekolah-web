<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Information - Debug Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .debug-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }
        .role-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        .role-super_admin { background: #dc3545; color: white; }
        .role-admin { background: #fd7e14; color: white; }
        .role-teacher { background: #198754; color: white; }
        .role-student { background: #0d6efd; color: white; }
        .role-none { background: #6c757d; color: white; }
        
        .user-card {
            transition: all 0.3s ease;
        }
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .btn-debug {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-debug:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .loading {
            display: none;
        }
        
        .json-output {
            background: #2d3748;
            color: #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .search-box {
            background: white;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .search-box:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>
</head>
<body>
    <div class="debug-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0"><i class="fas fa-user-shield me-3"></i>Role Information Debug Panel</h1>
                    <p class="mb-0 opacity-75">Check user roles and permissions in the system</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <a href="{{ route('home') }}" class="btn btn-outline-light">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Current User Info -->
        @auth
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user me-2"></i>Your Current Role Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{ auth()->user()->name }}</h5>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <div class="mb-3">
                            @if(auth()->user()->roles->count() > 0)
                                @foreach(auth()->user()->roles as $role)
                                    <span class="role-badge role-{{ $role->name }}">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                                @endforeach
                            @else
                                <span class="role-badge role-none">No Role</span>
                            @endif
                        </div>
                        <button class="btn btn-debug" onclick="loadCurrentUserRoles()">
                            <i class="fas fa-sync me-1"></i>Get Detailed Info
                        </button>
                    </div>
                    <div class="col-md-6">
                        <div id="current-user-info" class="json-output" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            You are not logged in. <a href="{{ route('login') }}">Login</a> to see your role information.
        </div>
        @endauth

        <!-- Check Specific User -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-search me-2"></i>Check Specific User Role
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">User Email</label>
                            <input type="email" class="form-control search-box" id="userEmail" placeholder="Enter user email...">
                        </div>
                        <button class="btn btn-debug" onclick="checkUserRole()">
                            <i class="fas fa-search me-1"></i>Check Role
                        </button>
                        <div class="loading mt-2">
                            <i class="fas fa-spinner fa-spin me-1"></i>Checking...
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="user-role-result" class="json-output" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Users -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-2"></i>All Users & Their Roles</span>
                <button class="btn btn-sm btn-light" onclick="loadAllUsers()">
                    <i class="fas fa-refresh me-1"></i>Refresh
                </button>
            </div>
            <div class="card-body">
                <div id="all-users-container">
                    <div class="text-center">
                        <button class="btn btn-debug" onclick="loadAllUsers()">
                            <i class="fas fa-users me-1"></i>Load All Users
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Quick Actions
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-success w-100" onclick="createTeacher()">
                            <i class="fas fa-chalkboard-teacher me-1"></i>Create Teacher
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="/debug/connection" class="btn btn-info w-100" target="_blank">
                            <i class="fas fa-plug me-1"></i>Test Connection
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="/debug/database" class="btn btn-warning w-100" target="_blank">
                            <i class="fas fa-database me-1"></i>Test Database
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        @auth
                        <a href="/debug/test-redirect" class="btn btn-secondary w-100" target="_blank">
                            <i class="fas fa-route me-1"></i>Test Redirect
                        </a>
                        @else
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="fas fa-route me-1"></i>Test Redirect (Login Required)
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- API Endpoints -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-code me-2"></i>Available API Endpoints
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Endpoint</th>
                                <th>Method</th>
                                <th>Description</th>
                                <th>Auth Required</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>/debug/create-teacher</code></td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>Create test teacher user</td>
                                <td><span class="badge bg-secondary">No</span></td>
                            </tr>
                            <tr>
                                <td><code>/debug/user-roles</code></td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>Get current user's roles</td>
                                <td><span class="badge bg-warning">Yes</span></td>
                            </tr>
                            <tr>
                                <td><code>/debug/all-users-roles</code></td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>Get all users with roles</td>
                                <td><span class="badge bg-secondary">No</span></td>
                            </tr>
                            <tr>
                                <td><code>/debug/check-user-role?email=user@example.com</code></td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>Check specific user role</td>
                                <td><span class="badge bg-secondary">No</span></td>
                            </tr>
                            <tr>
                                <td><code>/debug/test-redirect</code></td>
                                <td><span class="badge bg-success">GET</span></td>
                                <td>Test redirect logic</td>
                                <td><span class="badge bg-warning">Yes</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadCurrentUserRoles() {
            $.get('/debug/user-roles')
                .done(function(data) {
                    $('#current-user-info').html('<pre>' + JSON.stringify(data, null, 2) + '</pre>').show();
                })
                .fail(function(xhr) {
                    $('#current-user-info').html('<div class="text-danger">Error: ' + xhr.responseJSON?.error + '</div>').show();
                });
        }

        function checkUserRole() {
            const email = $('#userEmail').val();
            if (!email) {
                alert('Please enter an email address');
                return;
            }

            $('.loading').show();
            $.get('/debug/check-user-role?email=' + encodeURIComponent(email))
                .done(function(data) {
                    $('#user-role-result').html('<pre>' + JSON.stringify(data, null, 2) + '</pre>').show();
                })
                .fail(function(xhr) {
                    $('#user-role-result').html('<div class="text-danger">Error: ' + (xhr.responseJSON?.error || 'Request failed') + '</div>').show();
                })
                .always(function() {
                    $('.loading').hide();
                });
        }

        function loadAllUsers() {
            $('#all-users-container').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
            
            $.get('/debug/all-users-roles')
                .done(function(data) {
                    if (data.success) {
                        let html = '<div class="row">';
                        data.users.forEach(function(user) {
                            const roleClass = user.roles.length > 0 ? 'role-' + user.roles[0] : 'role-none';
                            const roleName = user.roles.length > 0 ? user.roles.join(', ').replace(/_/g, ' ') : 'No Role';
                            
                            html += `
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card user-card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">${user.name}</h6>
                                            <p class="card-text text-muted small">${user.email}</p>
                                            <span class="role-badge ${roleClass}">${roleName}</span>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>${user.created_at}
                                                    ${user.email_verified ? '<i class="fas fa-check-circle text-success ms-2"></i>' : '<i class="fas fa-times-circle text-danger ms-2"></i>'}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        html += '</div>';
                        html += `<div class="mt-3 text-center"><small class="text-muted">Total: ${data.total_users} users</small></div>`;
                        $('#all-users-container').html(html);
                    } else {
                        $('#all-users-container').html('<div class="alert alert-danger">Error: ' + data.error + '</div>');
                    }
                })
                .fail(function(xhr) {
                    $('#all-users-container').html('<div class="alert alert-danger">Error loading users: ' + (xhr.responseJSON?.error || 'Request failed') + '</div>');
                });
        }

        function createTeacher() {
            $.get('/debug/create-teacher')
                .done(function(data) {
                    if (data.success) {
                        alert('Teacher created successfully!\nEmail: ' + data.login_info.email + '\nPassword: ' + data.login_info.password);
                        loadAllUsers(); // Refresh user list
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .fail(function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.error || 'Request failed'));
                });
        }

        // Enter key support for email search
        $('#userEmail').keypress(function(e) {
            if (e.which == 13) {
                checkUserRole();
            }
        });
    </script>
</body>
</html>