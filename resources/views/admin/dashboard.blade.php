@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- ========================================================== --}}
    {{-- WELCOME HEADER                                             --}}
    {{-- ========================================================== --}}
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}! 
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Ringkasan aktivitas EcoPoint hari ini
            </p>
        </div>
        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span id="live-date" class="text-sm text-gray-600 font-medium">Memuat...</span>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- STATISTIK CARDS                                            --}}
    {{-- ========================================================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- 1. Total Pengguna --}}
        <a href="{{ route('admin.pelanggan.index') }}" 
           class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-blue-300 hover:-translate-y-0.5 transition-all duration-200 block group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($totalPelanggan ?? 0) }}</p>
                    <p class="text-xs text-blue-600 mt-1 group-hover:underline">Lihat detail →</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg text-blue-600 group-hover:bg-blue-200 group-hover:scale-110 transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </a>

        {{-- 2. Titik Kumpul --}}
        <a href="{{ route('admin.titik-kumpul.index') }}" 
           class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-orange-300 hover:-translate-y-0.5 transition-all duration-200 block group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Titik Kumpul</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($totalTitikKumpul ?? 0) }}</p>
                    <p class="text-xs text-orange-600 mt-1 group-hover:underline">Lihat detail →</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg text-orange-600 group-hover:bg-orange-200 group-hover:scale-110 transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        </a>

        {{-- 3. Transaksi --}}
        <a href="{{ route('admin.transaksi.index') }}" 
           class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-purple-300 hover:-translate-y-0.5 transition-all duration-200 block group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($totalTransaksi ?? 0) }}</p>
                    <p class="text-xs text-purple-600 mt-1 group-hover:underline">Lihat detail →</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg text-purple-600 group-hover:bg-purple-200 group-hover:scale-110 transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
            </div>
        </a>

        {{-- 4. Total Payout --}}
        <a href="{{ route('admin.transaksi.index', ['filter' => 'withdraw']) }}" 
           class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-yellow-300 hover:-translate-y-0.5 transition-all duration-200 block group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Payout</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($totalPayout ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-yellow-600 mt-1 group-hover:underline">Lihat detail →</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg text-yellow-600 group-hover:bg-yellow-200 group-hover:scale-110 transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </a>
    </div>

    {{-- ========================================================== --}}
    {{-- AKTIVITAS TERBARU                                          --}}
    {{-- ========================================================== --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header Tabel --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-9 h-9 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Aktivitas Terbaru</h3>
                    <p class="text-xs text-gray-500">5 aktivitas terakhir dari semua pengguna</p>
                </div>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($aktivitasTerbaru as $key => $aktivitas)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $key + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                    <span class="text-xs font-semibold text-green-700">
                                        {{ strtoupper(substr($aktivitas->user ?? 'A', 0, 1)) }}
                                    </span>
                                </div>
                                <span class="text-sm font-medium text-gray-800">{{ $aktivitas->user ?? 'Anonim' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $aktivitas->aksi ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $aktivitas->tanggal ?? '—' }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <svg class="w-14 h-14 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-base font-medium text-gray-500">Belum ada aktivitas</p>
                            <p class="text-sm text-gray-400 mt-1">Aktivitas pengguna akan muncul di sini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // ============================================================
    // JAM TANGGAL LIVE
    // ============================================================
    (function() {
        const dateEl = document.getElementById('live-date');
        if (!dateEl) return;

        const hariList = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        function updateDate() {
            const now = new Date();
            dateEl.textContent = `${hariList[now.getDay()]}, ${now.getDate()} ${bulanList[now.getMonth()]} ${now.getFullYear()}`;
        }

        updateDate();
        // Update tiap menit aja (biar hemat resource)
        setInterval(updateDate, 60000);
    })();
</script>
@endsection