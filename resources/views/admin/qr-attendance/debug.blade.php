@extends('layouts.admin')

@section('title', 'Debug QR Generation')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold mb-6">Debug QR Code Generation</h1>
    
    <!-- Environment Check -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Environment Check</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-medium mb-2">PHP Extensions</h3>
                <ul class="space-y-1 text-sm">
                    <li class="flex items-center">
                        <span class="w-3 h-3 rounded-full mr-2 {{ extension_loaded('gd') ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        GD Extension: {{ extension_loaded('gd') ? 'Loaded' : 'Not Loaded' }}
                    </li>
                    <li class="flex items-center">
                        <span class="w-3 h-3 rounded-full mr-2 {{ extension_loaded('imagick') ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        ImageMagick: {{ extension_loaded('imagick') ? 'Loaded' : 'Not Loaded' }}
                    </li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-medium mb-2">Storage Permissions</h3>
                <ul class="space-y-1 text-sm">
                    <li class="flex items-center">
                        <span class="w-3 h-3 rounded-full mr-2 {{ is_writable(storage_path('app/public')) ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        Storage Writable: {{ is_writable(storage_path('app/public')) ? 'Yes' : 'No' }}
                    </li>
                    <li class="flex items-center">
                        <span class="w-3 h-3 rounded-full mr-2 {{ file_exists(storage_path('app/public/qr-codes')) ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                        QR Directory: {{ file_exists(storage_path('app/public/qr-codes')) ? 'Exists' : 'Not Exists' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Routes Check -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Routes Check</h2>
        
        <div class="space-y-2 text-sm">
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 {{ Route::has('admin.qr-attendance.generate') ? 'bg-green-500' : 'bg-red-500' }}"></span>
                Generate Route: {{ Route::has('admin.qr-attendance.generate') ? 'Exists' : 'Missing' }}
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 {{ Route::has('admin.qr-attendance.view') ? 'bg-green-500' : 'bg-red-500' }}"></span>
                View Route: {{ Route::has('admin.qr-attendance.view') ? 'Exists' : 'Missing' }}
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full mr-2 {{ Route::has('admin.qr-attendance.regenerate') ? 'bg-green-500' : 'bg-red-500' }}"></span>
                Regenerate Route: {{ Route::has('admin.qr-attendance.regenerate') ? 'Exists' : 'Missing' }}
            </div>
        </div>
    </div>
    
    <!-- Test Students -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Test QR Generation</h2>
        
        @php
            $testStudents = \App\Models\Student::whereDoesntHave('qrAttendance')->take(3)->get();
        @endphp
        
        @if($testStudents->count() > 0)
            <div class="space-y-4">
                @foreach($testStudents as $student)
                    <div class="border rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium">{{ $student->name }}</h3>
                                <p class="text-sm text-gray-600">NIS: {{ $student->nis }} | Kelas: {{ $student->class }}</p>
                            </div>
                            <div class="space-x-2">
                                <button onclick="testGenerateQr({{ $student->id }})" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                    Test Generate
                                </button>
                            </div>
                        </div>
                        <div id="result-{{ $student->id }}" class="mt-2 hidden"></div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Semua siswa sudah memiliki QR Code atau tidak ada data siswa.</p>
        @endif
    </div>
    
    <!-- JavaScript Test -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">JavaScript Test</h2>
        
        <div class="space-y-4">
            <button onclick="testCsrfToken()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                Test CSRF Token
            </button>
            
            <button onclick="testFetchApi()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                Test Fetch API
            </button>
            
            <button onclick="testSweetAlert()" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg">
                Test SweetAlert
            </button>
        </div>
        
        <div id="js-test-results" class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg hidden">
            <h3 class="font-medium mb-2">Test Results:</h3>
            <pre id="js-test-output" class="text-sm"></pre>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function showTestResult(elementId, success, message, data = null) {
    const element = document.getElementById(elementId);
    element.classList.remove('hidden');
    element.innerHTML = `
        <div class="p-3 rounded-lg ${success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
            <div class="flex items-center">
                <i class="fas fa-${success ? 'check-circle' : 'exclamation-triangle'} mr-2"></i>
                <span class="font-medium">${success ? 'Success' : 'Error'}</span>
            </div>
            <p class="mt-1 text-sm">${message}</p>
            ${data ? `<pre class="mt-2 text-xs bg-white bg-opacity-50 p-2 rounded">${JSON.stringify(data, null, 2)}</pre>` : ''}
        </div>
    `;
}

function testCsrfToken() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const results = document.getElementById('js-test-results');
    const output = document.getElementById('js-test-output');
    
    results.classList.remove('hidden');
    
    if (csrfToken) {
        output.textContent = `CSRF Token Found: ${csrfToken.getAttribute('content').substring(0, 20)}...`;
    } else {
        output.textContent = 'CSRF Token NOT FOUND!';
    }
}

function testFetchApi() {
    const results = document.getElementById('js-test-results');
    const output = document.getElementById('js-test-output');
    
    results.classList.remove('hidden');
    output.textContent = 'Testing Fetch API...';
    
    fetch('/admin/qr-attendance/', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        },
    })
    .then(response => {
        output.textContent = `Fetch API Test: ${response.status} ${response.statusText}`;
    })
    .catch(error => {
        output.textContent = `Fetch API Error: ${error.message}`;
    });
}

function testSweetAlert() {
    Swal.fire({
        title: 'SweetAlert Test',
        text: 'SweetAlert is working correctly!',
        icon: 'success',
        confirmButtonText: 'Great!'
    });
}

function testGenerateQr(studentId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (!csrfToken) {
        showTestResult(`result-${studentId}`, false, 'CSRF token not found');
        return;
    }
    
    showTestResult(`result-${studentId}`, true, 'Testing... Please wait');
    
    fetch(`/admin/qr-attendance/generate/${studentId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', [...response.headers.entries()]);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        showTestResult(`result-${studentId}`, data.success, data.message, data);
    })
    .catch(error => {
        console.error('Error:', error);
        showTestResult(`result-${studentId}`, false, error.message, { error: error.toString() });
    });
}

// Log environment info
console.log('Debug Page Loaded');
console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
console.log('Current URL:', window.location.href);
console.log('User Agent:', navigator.userAgent);
</script>
@endpush