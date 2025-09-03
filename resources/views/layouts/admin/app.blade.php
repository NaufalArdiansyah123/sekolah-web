<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        {{-- Navbar / Sidebar admin --}}
        <header>
            <h2>Admin Panel</h2>
        </header>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
