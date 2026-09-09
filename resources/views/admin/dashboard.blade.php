@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, Admin!</p>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- 1. Total Pengguna --}}
        <a href="{{ route('admin.pelanggan.index') }}" 
           class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all duration-200 block group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalPelanggan) }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg text-blue-600 group-hover:bg-blue-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </a>

{{-- 2. Titik Kumpul --}}
<a href="{{ route('admin.titik-kumpul.index') }}" 
   class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-orange-200 transition-all duration-200 block group">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">Titik Kumpul</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalTitikKumpul ?? 0) }}</p>
        </div>
        <div class="p-3 bg-orange-100 rounded-lg text-orange-600 group-hover:bg-orange-200 transition">
            {{-- Icon Map Pin (Lokasi) --}}
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
    </div>
</a>
        {{-- 3. Transaksi --}}
        <a href="{{ route('admin.transaksi.index') }}" 
           class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-200 transition-all duration-200 block group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Transaksi</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalTransaksi) }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg text-purple-600 group-hover:bg-purple-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
            </div>
        </a>

        {{-- 4. Total Payout (sudah ada filter withdraw) --}}
        <a href="{{ route('admin.transaksi.index', ['filter' => 'withdraw']) }}" 
           class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-yellow-200 transition-all duration-200 block group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Payout</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalPayout ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg text-yellow-600 group-hover:bg-yellow-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </a>
    </div>

    {{-- Tabel Aktivitas Terbaru --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($aktivitasTerbaru as $aktivitas)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $aktivitas->user }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $aktivitas->aksi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $aktivitas->tanggal }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                            <p>Belum ada aktivitas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection