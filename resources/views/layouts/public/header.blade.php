<?php
// resources/views/layouts/public/header.blade.php
?>
<header class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <!-- Top Bar -->
    <div class="bg-primary-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-2 text-sm">
                <div class="flex items-center space-x-4">
                    <span>📞 (024) 123-4567</span>
                    <span>✉️ info@sekolah.com</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:text-primary-200">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-primary-200">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-primary-200">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <img class="h-12 w-auto" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
                <div class="ml-3">
                    <h1 class="text-xl font-bold text-gray-900">SMA Negeri 1</h1>
                    <p class="text-sm text-gray-600">Excellence in Education</p>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex space-x-8">
                @php
                $publicMenus = [
                    ['title' => 'Beranda', 'route' => 'home'],
                    [
                        'title' => 'Tentang', 
                        'children' => [
                            ['title' => 'Profil Sekolah', 'route' => 'about.profile'],
                            ['title' => 'Visi Misi', 'route' => 'about.vision'],
                            ['title' => 'Fasilitas', 'route' => 'facilities.index'],
                            ['title' => 'Prestasi', 'route' => 'achievements.index'],
                        ]
                    ],
                    [
                        'title' => 'Akademik',
                        'children' => [
                            ['title' => 'Program Studi', 'route' => 'academic.programs'],
                            ['title' => 'Ekstrakurikuler', 'route' => 'extracurriculars.index'],
                            ['title' => 'Kalender Akademik', 'route' => 'academic.calendar'],
                        ]
                    ],
                    [
                        'title' => 'Informasi',
                        'children' => [
                            ['title' => 'Berita', 'route' => 'news.index'],
                            ['title' => 'Pengumuman', 'route' => 'announcements.index'],
                            ['title' => 'Agenda', 'route' => 'agenda.index'],
                        ]
                    ],
                    [
                        'title' => 'Media',
                        'children' => [
                            ['title' => 'Galeri Foto', 'route' => 'gallery.photos'],
                            ['title' => 'Galeri Video', 'route' => 'gallery.videos'],
                            ['title' => 'Download', 'route' => 'downloads.index'],
                        ]
                    ],
                    ['title' => 'Kontak', 'route' => 'contact'],
                ];
                @endphp

                @foreach($publicMenus as $menu)
                    @if(isset($menu['children']))
                        <div class="relative group">
                            <button class="text-gray-900 hover:text-primary-600 px-3 py-2 text-sm font-medium flex items-center">
                                {{ $menu['title'] }}
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                @foreach($menu['children'] as $child)
                                    <a href="{{ route($child['route']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">
                                        {{ $child['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route($menu['route']) }}" class="text-gray-900 hover:text-primary-600 px-3 py-2 text-sm font-medium {{ request()->routeIs($menu['route']) ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                            {{ $menu['title'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <!-- Mobile menu button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="lg:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t">
                @foreach($publicMenus as $menu)
                    @if(isset($menu['children']))
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 text-base font-medium text-gray-900 hover:text-primary-600 hover:bg-gray-50">
                                {{ $menu['title'] }}
                                <svg :class="{'rotate-180': open}" class="h-4 w-4 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition class="pl-6 space-y-1">
                                @foreach($menu['children'] as $child)
                                    <a href="{{ route($child['route']) }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-gray-50">
                                        {{ $child['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route($menu['route']) }}" class="block px-3 py-2 text-base font-medium text-gray-900 hover:text-primary-600 hover:bg-gray-50">
                            {{ $menu['title'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</header>