<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoint Admin - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        .sidebar-menu-item { transition: background-color 0.2s ease, color 0.2s ease, transform 0.15s ease; }
        .sidebar-menu-item:active { transform: scale(0.98); }
        .sidebar-menu-item.active-menu { background-color: #dcfce7 !important; color: #16a34a !important; font-weight: 600; }
        .sidebar-menu-item.active-menu svg { color: #16a34a; }

        /* TITIK MERAH UNREAD - TANPA ANIMASI */
        .notif-dot-red {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #ef4444;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; transition: background 0.2s; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .custom-scrollbar { scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9; }

        .notif-item {
            position: relative;
            display: block;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .notif-item:last-child { border-bottom: none; }
        .notif-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: transparent;
            transition: 0.2s;
        }

        .notif-item.notif-setoran.unread { background: #eff6ff; }
        .notif-item.notif-setoran.unread::before { background: #3b82f6; }
        .notif-item.notif-setoran.read { background: #f8fafc; opacity: 0.8; }
        .notif-item.notif-setoran.read::before { background: #bfdbfe; }

        .notif-item.notif-withdraw.unread { background: #fffbeb; }
        .notif-item.notif-withdraw.unread::before { background: #eab308; }
        .notif-item.notif-withdraw.read { background: #f8fafc; opacity: 0.8; }
        .notif-item.notif-withdraw.read::before { background: #fde68a; }

        .notif-item:hover { background: #f1f5f9 !important; opacity: 1; }

        .notif-delete-btn {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            z-index: 10;
        }
        .notif-item:hover .notif-delete-btn { display: flex; }
        .notif-delete-btn:hover { background: #fee2e2; color: #dc2626; }

        .notif-tab {
            padding: 10px 16px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: 0.2s;
            background: none;
            border-top: none;
            border-left: none;
            border-right: none;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .notif-tab.active { color: #16a34a; border-bottom-color: #16a34a; }
        .notif-tab:hover:not(.active) { color: #334155; background: #f8fafc; }

        .notif-tab-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 18px;
            padding: 0 6px;
            font-size: 0.6rem;
            font-weight: 700;
            border-radius: 10px;
            background: #e2e8f0;
            color: #475569;
            transition: 0.2s;
        }
        .notif-tab.active .notif-tab-count {
            background: #16a34a;
            color: white;
        }
        .notif-tab[data-tab="unread"] .notif-tab-count.has-unread {
            background: #ef4444;
            color: white;
        }

        .notif-group-header {
            padding: 8px 16px;
            font-size: 0.65rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
        }

        /* LOGOUT MODAL ANIMATION */
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-100">

<div id="app" class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0">
        <div class="h-full flex flex-col">
            <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200 bg-white shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-xl font-bold text-green-600 hover:text-green-700 transition-colors">
                    <span>EcoPoint</span>
                </a>
                <button id="closeSidebar" class="md:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                @php $isDashboard = request()->routeIs('admin.dashboard'); @endphp
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item flex items-center px-4 py-3 rounded-lg {{ $isDashboard ? 'bg-green-50 text-green-600 font-semibold' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>

                @php $isPelanggan = request()->routeIs('admin.pelanggan.*') || request()->routeIs('pelanggan.*'); @endphp
                <a href="{{ route('admin.pelanggan.index') }}" class="sidebar-menu-item flex items-center px-4 py-3 rounded-lg {{ $isPelanggan ? 'bg-green-50 text-green-600 font-semibold' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Data Pelanggan
                </a>

                @php $isSampah = request()->routeIs('admin.jenis-sampah.*') || request()->routeIs('jenis-sampah.*'); @endphp
                <a href="{{ route('admin.jenis-sampah.index') }}" class="sidebar-menu-item flex items-center px-4 py-3 rounded-lg {{ $isSampah ? 'bg-green-50 text-green-600 font-semibold' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Sampah & Harga
                </a>

                @php
                    $isTransaksiActive = request()->routeIs('admin.transaksi*') || request()->routeIs('admin.withdraw*');
                    $filterAktif = request()->get('filter');
                @endphp

                <div>
                    <button type="button" onclick="toggleTransaksiDropdown(event)" class="sidebar-menu-item w-full flex items-center justify-between px-4 py-3 rounded-lg cursor-pointer {{ $isTransaksiActive ? 'bg-green-50 text-green-600 font-semibold' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            <span>Transaksi</span>
                        </div>
                        <svg id="transaksi-chevron" class="w-4 h-4 transition-transform duration-200 {{ $isTransaksiActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="transaksi-submenu" class="mt-1 ml-4 pl-4 border-l-2 border-gray-200 space-y-1 {{ $isTransaksiActive ? '' : 'hidden' }}">
                        @php $isSemua = request()->routeIs('admin.transaksi.index') && !request()->has('filter'); @endphp
                        <a href="{{ route('admin.transaksi.index') }}" class="sidebar-menu-item flex items-center px-3 py-2 rounded-lg text-sm {{ $isSemua ? 'bg-green-50 text-green-600 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">
                            <svg class="w-4 h-4 mr-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            Semua Transaksi
                        </a>

                        @php $isSetoran = $filterAktif == 'setoran'; @endphp
                        <a href="{{ route('admin.transaksi.index') }}?filter=setoran" class="sidebar-menu-item flex items-center px-3 py-2 rounded-lg text-sm {{ $isSetoran ? 'bg-green-50 text-green-600 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">
                            <svg class="w-4 h-4 mr-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z M8 8h8v2H8V8z M8 12h8v2H8v-2z M8 16h4v2H8v-2z"/></svg>
                            Setoran
                        </a>

                        @php $isWithdraw = $filterAktif == 'withdraw'; @endphp
                        <a href="{{ route('admin.transaksi.index') }}?filter=withdraw" class="sidebar-menu-item flex items-center px-3 py-2 rounded-lg text-sm {{ $isWithdraw ? 'bg-green-50 text-green-600 font-semibold' : 'text-gray-600 hover:bg-green-50 hover:text-green-600' }}">
                            <svg class="w-4 h-4 mr-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Withdraw
                        </a>
                    </div>
                </div>

                @php $isTitikKumpul = request()->routeIs('admin.titik-kumpul.*') || request()->routeIs('titik-kumpul.*'); @endphp
                <a href="{{ route('admin.titik-kumpul.index') }}" class="sidebar-menu-item flex items-center px-4 py-3 rounded-lg {{ $isTitikKumpul ? 'bg-green-50 text-green-600 font-semibold' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Titik Kumpul
                </a>

                @php $isPaket = request()->routeIs('admin.exchange-package*'); @endphp
                <a href="{{ route('admin.exchange-package.index') }}" class="sidebar-menu-item flex items-center px-4 py-3 rounded-lg {{ $isPaket ? 'bg-green-50 text-green-600 font-semibold' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0h-4m4 0h-4m4 0H8m12 0H8"/></svg>
                    Paket Penukaran
                </a>

                <div class="border-t border-gray-200 my-4"></div>

                <form method="POST" action="{{ route('admin.logout') }}" id="logoutFormSidebar" class="block">
                    @csrf
                    <button type="button" onclick="showLogoutModal()" class="sidebar-menu-item w-full flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50 font-medium">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden transition-opacity duration-300 md:hidden" onclick="toggleSidebar()"></div>

    {{-- CONTENT UTAMA --}}
    <div class="flex-1 flex flex-col overflow-hidden md:ml-64">

        <header class="bg-white shadow-sm border-b-2 border-green-200 sticky top-0 z-20 h-16 flex items-center justify-between px-4 md:px-6">
            <button id="hamburger" class="p-2 rounded-md text-gray-600 hover:text-green-600 hover:bg-green-50 focus:outline-none md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="hidden md:flex items-center">
                <h2 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard Admin')</h2>
            </div>

            <div class="flex items-center space-x-4 ml-auto relative">

                {{-- NOTIFICATION CENTER --}}
                <div class="relative" id="notificationWrapper">
                    <button id="notificationBtn" class="relative p-2 rounded-full text-gray-500 hover:text-green-600 hover:bg-green-50 focus:outline-none" aria-label="Notifikasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span id="notificationBadge" style="display:none;position:absolute;top:-2px;right:-2px;width:20px;height:20px;border-radius:50%;background-color:#ef4444;color:#ffffff;font-size:11px;font-weight:700;text-align:center;line-height:20px;z-index:100;font-family:Arial,sans-serif;padding:0;margin:0;">0</span>
                    </button>

                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">

                        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-gray-800">Notifikasi</h3>
                                <span id="totalCountBadge" class="inline-flex items-center justify-center min-w-[22px] h-[20px] px-1.5 text-[11px] font-bold rounded-full bg-gray-200 text-gray-700">0</span>
                            </div>
                            <span id="notificationCountText" class="text-xs text-gray-500 font-medium">0 baru</span>
                        </div>

                        <div class="flex border-b border-gray-100 bg-white">
                            <button class="notif-tab active" data-tab="all">
                                Semua
                                <span id="tabCountAll" class="notif-tab-count">0</span>
                            </button>
                            <button class="notif-tab" data-tab="unread">
                                Belum Dibaca
                                <span id="tabCountUnread" class="notif-tab-count">0</span>
                            </button>
                        </div>

                        <div id="notificationList" class="max-h-96 overflow-y-auto custom-scrollbar">
                            <div class="p-6 text-center text-gray-400 text-sm">Memuat...</div>
                        </div>

                        <div class="px-4 py-2 border-t border-gray-100 bg-gray-50 text-center">
                            <a href="{{ route('admin.pelanggan.index') }}" class="text-xs text-green-600 hover:text-green-700 font-medium">Lihat semua setoran →</a>
                        </div>
                    </div>
                </div>

                {{-- PROFIL DROPDOWN --}}
                <div class="relative" id="profileWrapper">
                    <button id="profileBtn" class="flex items-center space-x-2 focus:outline-none group p-1 rounded-full hover:bg-gray-50 transition-colors">
                        <img class="h-9 w-9 rounded-full object-cover border-2 border-green-600 group-hover:border-green-700 transition-colors" src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=2d6a4f&color=fff" alt="Admin Avatar">
                        <span class="hidden sm:inline-block text-sm font-medium text-gray-700 group-hover:text-green-600 transition-colors">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <svg id="profileChevron" class="hidden sm:inline-block w-4 h-4 text-gray-500 group-hover:text-green-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">

                        {{-- Header: User Info --}}
                        <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                            <div class="flex items-center gap-3">
                                <img class="h-11 w-11 rounded-full object-cover border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=2d6a4f&color=fff" alt="Admin Avatar">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Menu List --}}
                        <div class="py-1">
                            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-100"></div>

                        {{-- Logout (dengan popup) --}}
                        <div class="py-1">
                            <button type="button" onclick="showLogoutModal()" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>

{{-- ============================================================ --}}
{{-- MODAL LOGOUT --}}
{{-- ============================================================ --}}
<div id="logoutModal" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); align-items:center; justify-content:center; padding:16px;">
    <div id="logoutModalContent" style="background:#fff; border-radius:16px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.3); max-width:420px; width:100%; transform:scale(0.95); opacity:0; transition:all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); padding:24px; animation:modalFadeIn 0.3s ease-out;">

        {{-- Icon --}}
        <div style="width:64px; height:64px; margin:0 auto 16px; background:#fee2e2; border-radius:50%; display:flex; align-items:center; justify-content:center;">
            <svg style="width:32px; height:32px; color:#dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
        </div>

        {{-- Text --}}
        <h3 style="font-size:18px; font-weight:800; color:#1f2937; text-align:center; margin:0 0 8px 0;">Keluar dari Akun?</h3>
        <p style="font-size:14px; color:#6b7280; text-align:center; margin:0 0 24px 0; line-height:1.6;">
            Apakah Anda yakin ingin keluar dari akun <strong style="color:#1f2937;">{{ Auth::user()->name ?? 'Admin' }}</strong>?<br>
            Anda harus login kembali untuk mengakses dashboard.
        </p>

        {{-- Buttons --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <button type="button" onclick="hideLogoutModal()"
                    style="padding:12px 20px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; transition:all 0.15s;">
                Batal
            </button>
            <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                        style="width:100%; padding:12px 20px; background:#dc2626; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    // SIDEBAR TOGGLE
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
    document.getElementById('hamburger')?.addEventListener('click', toggleSidebar);
    document.getElementById('closeSidebar')?.addEventListener('click', toggleSidebar);
    document.getElementById('overlay')?.addEventListener('click', toggleSidebar);

    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            if (sidebar.classList.contains('-translate-x-full')) sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
        }
    });

    // ============================================================
    // PROFILE DROPDOWN
    // ============================================================
    (function() {
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const profileWrapper = document.getElementById('profileWrapper');
        const profileChevron = document.getElementById('profileChevron');

        if (!profileBtn || !profileDropdown) return;

        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isHidden = profileDropdown.classList.contains('hidden');
            if (isHidden) {
                profileDropdown.classList.remove('hidden');
                if (profileChevron) profileChevron.style.transform = 'rotate(180deg)';
            } else {
                profileDropdown.classList.add('hidden');
                if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
            }
        });

        document.addEventListener('click', function(e) {
            if (!profileWrapper.contains(e.target)) {
                profileDropdown.classList.add('hidden');
                if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
                if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
            }
        });
    })();

    // ============================================================
    // LOGOUT MODAL
    // ============================================================
    (function() {
        const logoutModal = document.getElementById('logoutModal');
        const logoutModalContent = document.getElementById('logoutModalContent');

        window.showLogoutModal = function() {
            // Tutup dulu dropdown profilnya
            const profileDropdown = document.getElementById('profileDropdown');
            const profileChevron = document.getElementById('profileChevron');
            if (profileDropdown) profileDropdown.classList.add('hidden');
            if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';

            // Buka modal
            logoutModal.style.display = 'flex';
            setTimeout(() => {
                logoutModalContent.style.transform = 'scale(1)';
                logoutModalContent.style.opacity = '1';
            }, 10);
        };

        window.hideLogoutModal = function() {
            logoutModalContent.style.transform = 'scale(0.95)';
            logoutModalContent.style.opacity = '0';
            setTimeout(() => {
                logoutModal.style.display = 'none';
            }, 300);
        };

        // Klik backdrop untuk tutup
        logoutModal.addEventListener('click', function(e) {
            if (e.target === logoutModal) hideLogoutModal();
        });

        // Tekan ESC untuk tutup
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && logoutModal.style.display === 'flex') {
                hideLogoutModal();
            }
        });
    })();

    // TRANSAKSI DROPDOWN
    (function() {
        const submenu = document.getElementById('transaksi-submenu');
        const chevron = document.getElementById('transaksi-chevron');
        if (!submenu || !chevron) return;
        const savedState = localStorage.getItem('transaksi-dropdown-state');
        if (savedState === 'open') {
            submenu.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else if (savedState === 'closed') {
            submenu.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    })();

    function toggleTransaksiDropdown(e) {
        if (e) { e.preventDefault(); e.stopPropagation(); }
        const submenu = document.getElementById('transaksi-submenu');
        const chevron = document.getElementById('transaksi-chevron');
        if (!submenu || !chevron) return;
        if (submenu.classList.contains('hidden')) {
            submenu.classList.remove('hidden');
            chevron.classList.add('rotate-180');
            localStorage.setItem('transaksi-dropdown-state', 'open');
        } else {
            submenu.classList.add('hidden');
            chevron.classList.remove('rotate-180');
            localStorage.setItem('transaksi-dropdown-state', 'closed');
        }
    }

    // EFEK KLIK INSTAN
    document.querySelectorAll('.sidebar-menu-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.sidebar-menu-item').forEach(el => el.classList.remove('active-menu'));
            this.classList.add('active-menu');
        });
    });

    // ============================================================
    // NOTIFIKASI CENTER
    // ============================================================
    (function() {
        const btn       = document.getElementById('notificationBtn');
        const dropdown  = document.getElementById('notificationDropdown');
        const badge     = document.getElementById('notificationBadge');
        const list      = document.getElementById('notificationList');
        const countText = document.getElementById('notificationCountText');
        const totalBadge = document.getElementById('totalCountBadge');
        const tabCountAll = document.getElementById('tabCountAll');
        const tabCountUnread = document.getElementById('tabCountUnread');
        const wrapper   = document.getElementById('notificationWrapper');
        const tabs      = document.querySelectorAll('.notif-tab');

        if (!btn || !dropdown) return;

        const NOTIF_URL       = "{{ route('admin.notifications.index') }}";
        const NOTIF_COUNT_URL = "{{ route('admin.notifications.count') }}";
        const STORAGE_KEY_READ    = 'admin_read_notifications';
        const STORAGE_KEY_DELETED = 'admin_deleted_notifications';

        let notificationsData = [];
        let readIds    = JSON.parse(localStorage.getItem(STORAGE_KEY_READ) || '[]');
        let deletedIds = JSON.parse(localStorage.getItem(STORAGE_KEY_DELETED) || '[]');
        let currentTab = 'all';

        function saveReadIds() {
            if (readIds.length > 500) readIds = readIds.slice(-500);
            localStorage.setItem(STORAGE_KEY_READ, JSON.stringify(readIds));
        }
        function saveDeletedIds() {
            if (deletedIds.length > 500) deletedIds = deletedIds.slice(-500);
            localStorage.setItem(STORAGE_KEY_DELETED, JSON.stringify(deletedIds));
        }
        function isRead(id) { return readIds.includes(id); }
        function isDeleted(id) { return deletedIds.includes(id); }
        function markAsRead(id) {
            if (!readIds.includes(id)) { readIds.push(id); saveReadIds(); }
        }
        function deleteNotif(id) {
            if (!deletedIds.includes(id)) { deletedIds.push(id); saveDeletedIds(); }
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                currentTab = this.getAttribute('data-tab');
                renderList();
            });
        });

        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                dropdown.classList.remove('hidden');
                loadNotifications();
            } else {
                dropdown.classList.add('hidden');
            }
        });

        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) dropdown.classList.add('hidden');
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') dropdown.classList.add('hidden');
        });

        function loadNotifications() {
            list.innerHTML = '<div class="p-6 text-center text-gray-400 text-sm">Memuat...</div>';
            fetch(NOTIF_URL, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                credentials: 'same-origin',
            })
            .then(res => res.json())
            .then(data => {
                notificationsData = (data.notifications || []).filter(n => !isDeleted(n.id));
                updateAllCounters();
                renderList();
            })
            .catch(err => {
                console.error('Notif error:', err);
                list.innerHTML = '<div class="p-6 text-center text-red-400 text-sm">Gagal memuat notifikasi</div>';
            });
        }

        function getUnreadCount() {
            return notificationsData.filter(n => !isRead(n.id)).length;
        }

        function updateAllCounters() {
            const total = notificationsData.length;
            const unread = getUnreadCount();

            if (unread > 0) {
                badge.textContent = unread > 99 ? '99+' : unread;
                badge.style.display = 'block';
                badge.style.backgroundColor = '#ef4444';
                badge.style.color = '#ffffff';
            } else {
                badge.style.display = 'none';
            }

            totalBadge.textContent = total > 99 ? '99+' : total;
            tabCountAll.textContent = total > 99 ? '99+' : total;
            tabCountUnread.textContent = unread > 99 ? '99+' : unread;
            if (unread > 0) {
                tabCountUnread.classList.add('has-unread');
            } else {
                tabCountUnread.classList.remove('has-unread');
            }
            countText.textContent = unread + ' baru';
        }

        function renderList() {
            let filtered = notificationsData;
            if (currentTab === 'unread') {
                filtered = notificationsData.filter(n => !isRead(n.id));
            }

            if (!filtered || filtered.length === 0) {
                list.innerHTML = `
                    <div class="p-8 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:48px;height:48px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <p class="text-sm text-gray-400">${currentTab === 'unread' ? 'Tidak ada notifikasi belum dibaca' : 'Tidak ada notifikasi'}</p>
                    </div>`;
                return;
            }

            const groups = { 'Hari Ini': [], 'Kemarin': [], 'Lebih Lama': [] };
            filtered.forEach(item => {
                const d = new Date(item.created_at);
                const now = new Date();
                const diffDays = Math.floor((now - d) / (1000 * 60 * 60 * 24));
                if (diffDays === 0) groups['Hari Ini'].push(item);
                else if (diffDays === 1) groups['Kemarin'].push(item);
                else groups['Lebih Lama'].push(item);
            });

            let html = '';
            Object.keys(groups).forEach(groupName => {
                if (groups[groupName].length === 0) return;
                html += `<div class="notif-group-header">${groupName} (${groups[groupName].length})</div>`;
                groups[groupName].forEach(item => {
                    const read = isRead(item.id);
                    const typeClass = item.type === 'withdraw' ? 'notif-withdraw' : 'notif-setoran';
                    const readClass = read ? 'read' : 'unread';
                    const icons = {
                        inbox: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
                        cash:  '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>'
                    };
                    const icon = icons[item.icon] || icons.inbox;

                    html += `
                        <a href="${item.url}" data-notif-id="${item.id}" class="notif-item ${typeClass} ${readClass}">
                            ${!read ? '<span class="notif-dot-red"></span>' : ''}
                            <button type="button" class="notif-delete-btn" data-delete-id="${item.id}" title="Hapus notifikasi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            <div class="flex gap-3 pr-8">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 ${item.type === 'withdraw' ? 'bg-yellow-100 text-yellow-600' : 'bg-blue-100 text-blue-600'} ${read ? 'opacity-60' : ''}" style="width:36px;height:36px;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;">${icon}</svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-xs font-semibold ${read ? 'text-gray-500' : 'text-gray-800'} leading-tight">${item.title}</p>
                                        <span class="text-[10px] text-gray-400 whitespace-nowrap">${item.time_ago}</span>
                                    </div>
                                    <p class="text-[11px] ${read ? 'text-gray-400' : 'text-gray-600'} mt-0.5 line-clamp-2 leading-snug">${item.message}</p>
                                </div>
                            </div>
                        </a>`;
                });
            });

            list.innerHTML = html;

            list.querySelectorAll('.notif-item').forEach(el => {
                el.addEventListener('click', function(e) {
                    if (e.target.closest('.notif-delete-btn')) return;
                    const id = this.getAttribute('data-notif-id');
                    markAsRead(id);
                    updateAllCounters();
                });
            });

            list.querySelectorAll('.notif-delete-btn').forEach(btnDel => {
                btnDel.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const id = this.getAttribute('data-delete-id');
                    deleteNotif(id);
                    notificationsData = notificationsData.filter(n => n.id !== id);
                    updateAllCounters();
                    renderList();
                });
            });
        }

        function fetchCount() {
            fetch(NOTIF_COUNT_URL, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                credentials: 'same-origin',
            })
            .then(res => res.json())
            .then(data => {
                if (data.count > 0) {
                    fetch(NOTIF_URL, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                        credentials: 'same-origin',
                    })
                    .then(r => r.json())
                    .then(d => {
                        notificationsData = (d.notifications || []).filter(n => !isDeleted(n.id));
                        updateAllCounters();
                        if (!dropdown.classList.contains('hidden')) renderList();
                    })
                    .catch(() => {});
                } else {
                    notificationsData = [];
                    updateAllCounters();
                }
            })
            .catch(() => {});
        }

        fetchCount();
        setInterval(fetchCount, 10000);
    })();
</script>

@stack('scripts')
</body>
</html>