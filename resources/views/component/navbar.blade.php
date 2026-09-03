<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoint Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Atau pakai CDN Tailwind --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <style>
        /* Warna hijau kustom */
        .bg-eco { background-color: #2d6a4f; }
        .bg-eco-light { background-color: #d8eddf; }
        .text-eco { color: #2d6a4f; }
        .border-eco { border-color: #2d6a4f; }
        .hover-bg-eco:hover { background-color: #1b4332; }
        .hover-text-eco:hover { color: #1b4332; }
        .active-eco { background-color: #d8eddf; color: #1b4332; }
        .ring-eco:focus { --tw-ring-color: #2d6a4f; }
    </style>
</head>
<body class="bg-gray-50">

<div id="app" class="flex h-screen overflow-hidden">

    {{-- ========================================================== --}}
    {{-- SIDEBAR HIJAU (dengan toggle)                              --}}
    {{-- ========================================================== --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-40 w-64 bg-eco text-white shadow-xl transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="h-full flex flex-col">

            {{-- BRANDING + TOMBOL TUTUP (mobile) --}}
            <div class="h-16 flex items-center justify-between px-4 border-b border-green-800 bg-eco shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-xl font-bold text-white hover:text-green-200 transition-colors">
                    <span>EcoPoint</span>
                </a>
                <button id="closeSidebar" class="md:hidden text-white hover:text-green-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- MENU --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>

                {{-- Data Pelanggan --}}
                <a href="{{ route('admin.pelanggan.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('pelanggan.*') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Data Pelanggan
                </a>

                {{-- Sampah & Harga --}}
                <a href="{{ route('admin.jenis-sampah.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.jenis-sampah*') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Sampah & Harga
                </a>

                {{-- Transaksi --}}
                <a href="{{ route('admin.transaksi.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.transaksi*') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Transaksi
                </a>

                <div class="border-t border-green-700 my-4"></div>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('admin.logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-red-300 rounded-lg hover:bg-red-700 hover:text-white transition-colors">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    {{-- OVERLAY untuk mobile --}}
    <div id="overlay"
         class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"
         onclick="toggleSidebar()">
    </div>

    {{-- ========================================================== --}}
    {{-- CONTENT UTAMA                                             --}}
    {{-- ========================================================== --}}
    <div class="flex-1 flex flex-col overflow-hidden md:ml-64">

        {{-- ========== HEADER (dari kode yang kamu kasih) ========== --}}
        <header class="bg-white shadow-sm sticky top-0 z-20 h-16 flex items-center justify-between px-4 md:px-6">
            {{-- Left: Hamburger Button (Mobile Only) --}}
            <button id="hamburger" class="p-2 rounded-md text-gray-600 hover:text-eco hover:bg-green-50 focus:outline-none md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Center: Page Title (Opsional) --}}
            <div class="hidden md:flex items-center">
                <h2 class="text-lg font-semibold text-gray-800">Dashboard Admin</h2>
            </div>

            {{-- Right: Admin Profile --}}
            <div class="flex items-center space-x-4 ml-auto relative">
                {{-- Notification Bell --}}
                <button class="text-gray-500 hover:text-eco focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                {{-- Profile Dropdown Trigger --}}
                <div class="relative">
                    <button id="profileBtn" class="flex items-center space-x-2 focus:outline-none">
                        <img class="h-8 w-8 rounded-full object-cover border-2 border-eco" 
                             src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=2d6a4f&color=fff" 
                             alt="Admin Avatar">
                        <span class="hidden sm:inline-block text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <svg class="hidden sm:inline-block w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-eco">Profil Saya</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-eco">Pengaturan</a>
                        <div class="border-t border-gray-200 my-1"></div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- KONTEN HALAMAN --}}
        <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>

{{-- ========================================================== --}}
{{-- JAVASCRIPT TOGGLE SIDEBAR & DROPDOWN                     --}}
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

    // Saat resize ke desktop, reset sidebar
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

    // ---- PROFILE DROPDOWN TOGGLE ----
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    profileBtn?.addEventListener('click', function(e) {
        e.stopPropagation();
        profileDropdown.classList.toggle('hidden');
    });

    // Klik di luar dropdown untuk menutup
    document.addEventListener('click', function(e) {
        if (!profileBtn?.contains(e.target) && !profileDropdown?.contains(e.target)) {
            profileDropdown?.classList.add('hidden');
        }
    });
</script>

</body>
</html>