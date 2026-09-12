@extends('layouts.admin')

@section('title', 'Konfirmasi Logout')
@section('page_title', 'Konfirmasi Logout')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md">

        {{-- CARD KONFIRMASI --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 text-center">

            {{-- ICON --}}
            <div class="mx-auto w-20 h-20 rounded-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center mb-6 animate-pulse-slow">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>

            {{-- TITLE --}}
            <h1 class="text-2xl font-bold text-gray-800 mb-2">
                Yakin Ingin Keluar?
            </h1>

            {{-- SUBTITLE --}}
            <p class="text-sm text-gray-500 leading-relaxed mb-8">
                Anda akan keluar dari akun
                <span class="font-semibold text-gray-800">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>.
                Pastikan semua pekerjaan sudah tersimpan sebelum keluar.
            </p>

            {{-- INFO AKUN --}}
            <div class="bg-gray-50 rounded-2xl p-4 mb-8 flex items-center gap-4 text-left">
                <img class="w-12 h-12 rounded-full border-2 border-green-600"
                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name ?? 'Admin') }}&background=2d6a4f&color=fff"
                     alt="Avatar">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">
                        {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        {{ Auth::guard('admin')->user()->email ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- BUTTONS --}}
            <div class="flex flex-col sm:flex-row gap-3">
                {{-- BATAL: balik ke dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-semibold text-sm
                          bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-200 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>

                {{-- KONFIRMASI: form POST logout --}}
                <form method="POST" action="{{ route('admin.logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-semibold text-sm
                                   text-white bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800
                                   shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40
                                   transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>

        {{-- FOOTNOTE --}}
        <p class="text-center text-xs text-gray-400 mt-6">
            Sesi Anda akan diakhiri &amp; Anda akan diarahkan ke halaman login.
        </p>
    </div>
</div>

<style>
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
        50% { transform: scale(1.05); box-shadow: 0 0 0 14px rgba(220, 38, 38, 0); }
    }
    .animate-pulse-slow {
        animation: pulse-slow 2s ease-in-out infinite;
    }
</style>
@endsection