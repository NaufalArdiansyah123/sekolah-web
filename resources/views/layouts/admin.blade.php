<?php
// resources/views/layouts/admin.blade.php
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin' }} - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        <!-- Sidebar -->
        @include('layouts.admin.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            @include('layouts.admin.navbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <!-- Alerts -->
                    @include('components.alerts')

                    <!-- Breadcrumb -->
                    @if(isset($breadcrumb))
                        @include('components.breadcrumb', ['items' => $breadcrumb])
                    @endif

                    <!-- Page Header -->
                    @if(isset($header))
                        <div class="mb-8">
                            {{ $header }}
                        </div>
                    @endif

                    <!-- Main Content -->
                     
                   @yield('content')

                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>