<?php
// resources/views/layouts/admin/sidebar.blade.php
?>
<div class="flex">
    <!-- Sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64">
            <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto bg-primary-800">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-4">
                    <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
                    <span class="ml-2 text-white font-semibold">Admin Panel</span>
                </div>

                <!-- Navigation -->
                <nav class="mt-8 flex-1 px-2 space-y-1">
                    @php
                    $menus = [
                        [
                            'title' => 'Dashboard',
                            'route' => 'admin.dashboard',
                            'icon' => 'home',
                            'permission' => null
                        ],
                        [
                            'title' => 'Content Management',
                            'icon' => 'document-text',
                            'permission' => 'posts.read',
                            'children' => [
                                ['title' => 'Slideshow', 'route' => 'admin.posts.slideshow'],
                                ['title' => 'Agenda', 'route' => 'admin.posts.agenda'],
                                ['title' => 'Pengumuman', 'route' => 'admin.posts.announcement'],
                                ['title' => 'Editorial & Blog', 'route' => 'admin.posts.blog'],
                                ['title' => 'Quotes', 'route' => 'admin.posts.quote'],
                            ]
                        ],
                        [
                            'title' => 'Academic',
                            'icon' => 'academic-cap',
                            'permission' => 'academic.manage',
                            'children' => [
                                ['title' => 'Fasilitas', 'route' => 'admin.facilities.index'],
                                ['title' => 'Ekstrakurikuler', 'route' => 'admin.extracurriculars.index'],
                                ['title' => 'Prestasi', 'route' => 'admin.achievements.index'],
                                ['title' => 'Guru & Staff', 'route' => 'admin.teachers.index'],
                                ['title' => 'Siswa', 'route' => 'admin.students.index'],
                            ]
                        ],
                        [
                            'title' => 'Media & Files',
                            'icon' => 'folder',
                            'permission' => 'posts.create',
                            'children' => [
                                ['title' => 'Downloads', 'route' => 'admin.downloads.index'],
                                ['title' => 'Gallery', 'route' => 'admin.gallery.index'],
                            ]
                        ],
                        [
                            'title' => 'Learning',
                            'icon' => 'book-open',
                            'permission' => 'materials.manage',
                            'children' => [
                                ['title' => 'Materials', 'route' => 'admin.materials.index'],
                                ['title' => 'Assignments', 'route' => 'admin.assignments.index'],
                            ]
                        ],
                        [
                            'title' => 'System',
                            'icon' => 'cog',
                            'permission' => 'system.admin',
                            'children' => [
                                ['title' => 'Users', 'route' => 'admin.users.index'],
                                ['title' => 'Roles & Permissions', 'route' => 'admin.roles.index'],
                            ]
                        ]
                    ];
                    @endphp

                    @foreach($menus as $menu)
                        @if(!isset($menu['permission']) || auth()->user()->can($menu['permission']))
                            <div x-data="{ open: {{ request()->routeIs(isset($menu['children']) ? collect($menu['children'])->pluck('route')->map(fn($r) => $r.'*')->implode(',') : $menu['route'].'*') ? 'true' : 'false' }} }">
                                @if(isset($menu['children']))
                                    <!-- Parent Menu with Children -->
                                    <button @click="open = !open" class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-md text-primary-100 hover:text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                        <span class="flex-1 text-left">{{ $menu['title'] }}</span>
                                        <svg :class="{'rotate-90': open}" class="ml-2 h-4 w-4 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Children Menu -->
                                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="ml-6 space-y-1">
                                        @foreach($menu['children'] as $child)
                                            <a href="{{ route($child['route']) }}" class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs($child['route'].'*') ? 'text-white bg-primary-700' : 'text-primary-100 hover:text-white hover:bg-primary-700' }}">
                                                {{ $child['title'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Single Menu Item -->
                                    <a href="{{ route($menu['route']) }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs($menu['route'].'*') ? 'text-white bg-primary-700' : 'text-primary-100 hover:text-white hover:bg-primary-700' }}">
                                        @include('components.icons.' . $menu['icon'], ['class' => 'mr-3 h-5 w-5 text-primary-300'])
                                        {{ $menu['title'] }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 md:hidden" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>
    </div>

    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" class="fixed inset-y-0 left-0 z-50 w-64 bg-primary-800 md:hidden" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
        <!-- Mobile sidebar content (same as desktop) -->
        <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
            <div class="flex items-center justify-between flex-shrink-0 px-4">
                <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
                <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Navigation items (same as desktop) -->
        </div>
    </div>
</div>