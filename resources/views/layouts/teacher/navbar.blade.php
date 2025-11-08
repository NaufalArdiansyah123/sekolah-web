<nav class="teacher-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Left: Logo & Title -->
            <div class="flex items-center gap-3">
                <a href="{{ route('teacher.dashboard') }}"
                    class="flex items-center gap-2 font-extrabold text-xl text-green-800 dark:text-green-300 tracking-tight drop-shadow-sm transform transition-transform duration-200 hover:scale-105">
                    <span
                        class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-gradient-to-tr from-green-400 to-green-600 shadow-lg mr-1 ring-2 ring-green-200 dark:ring-green-700">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7l9-4 9 4M4 10v10a1 1 0 001 1h3m10-11v11a1 1 0 01-1 1h-3m-6 0h6" />
                        </svg>
                    </span>
                    <span>Sekolah Web</span>
                </a>
                <span class="ml-4 text-lg font-semibold text-gray-700 dark:text-gray-200 hidden sm:block">
                    {{ $pageTitle ?? 'Teacher' }}
                </span>
            </div>

            <!-- Center: Navigation Links (optional, add more as needed) -->
            <div class="hidden md:flex gap-6">
                <a href="{{ route('teacher.dashboard') }}"
                    class="text-gray-700 dark:text-gray-200 hover:text-green-700 dark:hover:text-green-300 font-semibold transition-all duration-150 px-3 py-1.5 rounded-lg hover:shadow-md hover:bg-green-50/60 dark:hover:bg-green-900/40">Dashboard</a>
                <a href="{{ route('teacher.attendance.index') }}"
                    class="text-gray-700 dark:text-gray-200 hover:text-green-700 dark:hover:text-green-300 font-semibold transition-all duration-150 px-3 py-1.5 rounded-lg hover:shadow-md hover:bg-green-50/60 dark:hover:bg-green-900/40">Absensi</a>
                <a href="{{ route('teacher.students.index') }}"
                    class="text-gray-700 dark:text-gray-200 hover:text-green-700 dark:hover:text-green-300 font-semibold transition-all duration-150 px-3 py-1.5 rounded-lg hover:shadow-md hover:bg-green-50/60 dark:hover:bg-green-900/40">Siswa</a>
                <a href="{{ route('teacher.grades.index') }}"
                    class="text-gray-700 dark:text-gray-200 hover:text-green-700 dark:hover:text-green-300 font-semibold transition-all duration-150 px-3 py-1.5 rounded-lg hover:shadow-md hover:bg-green-50/60 dark:hover:bg-green-900/40">Nilai</a>
            </div>

            <!-- Right: User Dropdown -->
            <div class="flex items-center gap-3">
                <div class="hidden md:block h-8 w-px bg-gray-200 dark:bg-gray-700 mx-2 rounded-full"></div>
                <!-- Dark mode toggle -->
                <button
                    onclick="document.documentElement.classList.toggle('dark');localStorage.setItem('darkMode',document.documentElement.classList.contains('dark'))"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v1m0 16v1m8.66-13.66l-.71.71M4.05 19.95l-.71.71M21 12h-1M4 12H3m16.24 4.24l-.71-.71M6.34 6.34l-.71-.71M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <!-- User dropdown -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" :class="open ? 'ring-2 ring-green-400 dark:ring-green-600' : ''"
                        class="flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition-all">
                        <img class="w-8 h-8 rounded-full object-cover border border-green-200 dark:border-green-700 transition-all"
                            :class="open ? 'ring-2 ring-green-400 dark:ring-green-600' : ''"
                            src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=059669&background=D1FAE5&size=36'">
                        <span
                            class="hidden sm:block text-sm font-medium text-gray-800 dark:text-gray-100 max-w-[8rem] truncate">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-800">
                            <div class="font-semibold text-gray-800 dark:text-gray-100 text-sm">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</div>
                        </div>
                        <a href="{{ route('teacher.profile') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">Profil</a>
                        <a href="{{ route('home') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">Ke
                            Beranda</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>