<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoint Admin - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100">

<div id="app" class="flex h-screen overflow-hidden">

    {{-- ========================================================== --}}
    {{-- SIDEBAR (Responsive: slide in/out di mobile, tetap di desktop) --}}
    {{-- ========================================================== --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0">
        <div class="h-full flex flex-col">

            {{-- BRANDING + TOMBOL TUTUP (mobile) --}}
            <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200 bg-white shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-xl font-bold text-green-600 hover:text-green-700 transition-colors">
                    <span>EcoPoint</span>
                </a>
                <button id="closeSidebar" class="md:hidden text-gray-500 hover:text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- MENU --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>

                {{-- Data Pelanggan --}}
                <a href="{{ route('admin.pelanggan.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('pelanggan.*') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Data Pelanggan
                </a>

                {{-- Jenis Sampah & Harga --}}
                <a href="{{ route('admin.jenis-sampah.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('jenis-sampah.*') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Sampah & Harga
                </a>

                {{-- Transaksi --}}
                <a href="{{ route('admin.transaksi.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('transaksi.*') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Transaksi
                </a>

                {{-- ===== TITIK KUMPUL (BARU) ===== --}}
                <a href="{{ route('admin.titik-kumpul.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('titik-kumpul.*') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Titik Kumpul
                </a>

                <a href="{{ route('admin.exchange-packages.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.exchange-packages*') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0h-4m4 0h-4m4 0H8m12 0H8"/>
                    </svg>
                    Paket Penukaran
                </a>

                <div class="border-t border-gray-200 my-4"></div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('admin.logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    {{-- OVERLAY (hanya muncul di mobile saat sidebar terbuka) --}}
    <div id="overlay"
         class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden transition-opacity duration-300 md:hidden"
         onclick="toggleSidebar()">
    </div>

    {{-- ========================================================== --}}
    {{-- CONTENT UTAMA --}}
    {{-- ========================================================== --}}
    <div class="flex-1 flex flex-col overflow-hidden md:ml-64">

        {{-- HEADER --}}
        <header class="bg-white shadow-sm border-b-2 border-green-200 sticky top-0 z-20 h-16 flex items-center justify-between px-4 md:px-6">
            {{-- Tombol hamburger (mobile) --}}
            <button id="hamburger" class="p-2 rounded-md text-gray-600 hover:text-green-600 hover:bg-green-50 focus:outline-none md:hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page Title --}}
            <div class="hidden md:flex items-center">
                <h2 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard Admin')</h2>
            </div>

            {{-- Profil --}}
            <div class="flex items-center space-x-4 ml-auto relative">
                {{-- Notifikasi --}}
                <button class="p-2 rounded-full text-gray-500 hover:text-green-600 hover:bg-green-50 focus:outline-none transition-colors">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                {{-- Dropdown profil --}}
                <div class="relative">
                    <button id="profileBtn" class="flex items-center space-x-2 focus:outline-none group">
                        <img class="h-9 w-9 rounded-full object-cover border-2 border-green-600 group-hover:border-green-700 transition-colors" 
                             src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=2d6a4f&color=fff" 
                             alt="Admin Avatar">
                        <span class="hidden sm:inline-block text-sm font-medium text-gray-700 group-hover:text-green-600 transition-colors">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <svg class="hidden sm:inline-block w-4 h-4 text-gray-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">Profil Saya</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">Pengaturan</a>
                        <div class="border-t border-gray-200 my-1"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>

{{-- ========================================================== --}}
{{-- JAVASCRIPT UNTUK TOGGLE SIDEBAR & DROPDOWN --}}
{{-- ========================================================== --}}
<script>
    // ---- SIDEBAR TOGGLE ----
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    document.getElementById('hamburger')?.addEventListener('click', toggleSidebar);
    document.getElementById('closeSidebar')?.addEventListener('click', toggleSidebar);
    document.getElementById('overlay')?.addEventListener('click', toggleSidebar);

    // Reset sidebar di desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
            }
            overlay.classList.add('hidden');
        }
    });

    // ---- PROFILE DROPDOWN ----
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    profileBtn?.addEventListener('click', function(e) {
        e.stopPropagation();
        profileDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function(e) {
        if (!profileBtn?.contains(e.target) && !profileDropdown?.contains(e.target)) {
            profileDropdown?.classList.add('hidden');
        }
    });
</script>

@stack('scripts')
</body>
</html>