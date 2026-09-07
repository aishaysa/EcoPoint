<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-xl transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
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

            {{-- 1. DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>

            {{-- 2. DATA PELANGGAN --}}
            <a href="{{ route('admin.pelanggan.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('pelanggan.*') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Data Pelanggan
            </a>

            {{-- 3. JENIS SAMPAH & HARGA --}}
            <a href="{{ route('admin.jenis-sampah.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('jenis-sampah.*') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Sampah & Harga
            </a>

            {{-- 4. TRANSAKSI --}}
            <a href="{{ route('admin.transaksi.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('transaksi.*') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                Transaksi
            </a>

            <a href="{{ route('admin.withdraw') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('withdraw.*') ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                Paket Penukaran
            </a>

            

            <div class="border-t border-gray-200 my-4"></div>

            {{-- LOGOUT --}}
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