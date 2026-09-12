@extends('layouts.admin')

@section('title', 'Semua Transaksi')
@section('page_title', 'Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- ========================================================== --}}
    {{-- HEADER + JAM LIVE                                          --}}
    {{-- ========================================================== --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                @if($filter == 'setoran')
                    Data Setoran
                @elseif($filter == 'withdraw')
                    Data Withdraw
                @else
                    Semua Transaksi
                @endif
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Daftar transaksi
                @if($filter == 'setoran') setoran sampah @elseif($filter == 'withdraw') penarikan saldo @endif
                pelanggan
            </p>
        </div>

        {{-- JAM LIVE --}}
        <div class="flex items-center gap-3 bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Waktu Sekarang</p>
                <p id="live-clock" class="text-lg font-bold text-gray-800 font-mono tabular-nums">--:--:-- --</p>
                <p id="live-date" class="text-xs text-gray-500">Memuat...</p>
            </div>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- FILTER & LIVE SEARCH                                       --}}
    {{-- ========================================================== --}}
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-4">
        <form method="GET" action="{{ route('admin.transaksi.index') }}" id="filterForm">
            <input type="hidden" name="filter" value="{{ $filter }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                {{-- LIVE SEARCH --}}
                <div class="sm:col-span-2 lg:col-span-1">
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        🔍 Cari Data
                        <span id="search-loading" class="hidden text-green-600 ml-1">●</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               id="search-input"
                               value="{{ request('search') }}"
                               placeholder="Nama, status, jenis, metode..."
                               autocomplete="off"
                               class="w-full pl-9 pr-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Cari: nama, status, jenis, metode</p>
                </div>

                {{-- TANGGAL --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal</label>
                    <select name="tanggal" id="filter-tanggal"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2">
                        <option value="">Semua Tanggal</option>
                        @for($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}" {{ request('tanggal') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- BULAN --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
                    <select name="bulan" id="filter-bulan"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2">
                        <option value="">Semua Bulan</option>
                        @php
                            $bulanList = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        @endphp
                        @foreach($bulanList as $num => $nama)
                            <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- TAHUN --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
                    <select name="tahun" id="filter-tahun"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2">
                        <option value="">Semua Tahun</option>
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Filter Aktif + Reset --}}
            @if(request('search') || request('tanggal') || request('bulan') || request('tahun'))
                <div class="mt-3 pt-3 border-t border-gray-100 flex flex-wrap gap-2 items-center justify-between">
                    <div class="flex flex-wrap gap-2 items-center text-xs">
                        <span class="text-gray-500">Filter aktif:</span>
                        @if(request('search'))
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">🔍 "{{ request('search') }}"</span>
                        @endif
                        @if(request('tanggal'))
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700">📅 Tanggal: {{ request('tanggal') }}</span>
                        @endif
                        @if(request('bulan'))
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">🗓️ Bulan: {{ $bulanList[request('bulan')] ?? request('bulan') }}</span>
                        @endif
                        @if(request('tahun'))
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">📆 Tahun: {{ request('tahun') }}</span>
                        @endif
                    </div>
                    <a href="{{ route('admin.transaksi.index') }}?filter={{ $filter }}" 
                       class="inline-flex items-center gap-1 text-xs text-red-600 hover:text-red-700 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset Filter
                    </a>
                </div>
            @endif
        </form>
    </div>

    {{-- ========================================================== --}}
    {{-- PAGINATION ATAS                                            --}}
    {{-- ========================================================== --}}
    <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-3 rounded-lg shadow-sm border border-gray-200">
        <div class="text-sm text-gray-500">
            Menampilkan <span class="font-semibold text-gray-800">{{ $allTransactions->firstItem() ?? 0 }}</span> 
            - <span class="font-semibold text-gray-800">{{ $allTransactions->lastItem() ?? 0 }}</span> 
            dari <span class="font-semibold text-gray-800">{{ $allTransactions->total() }}</span> data
        </div>

        <nav class="flex items-center gap-1">
            @if ($allTransactions->onFirstPage())
                <span class="px-3 py-1.5 border border-gray-200 rounded-md text-sm bg-gray-50 text-gray-400 cursor-not-allowed">‹ Sebelumnya</span>
            @else
                <a href="{{ $allTransactions->appends(request()->query())->previousPageUrl() }}" 
                   class="px-3 py-1.5 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50 transition">
                    ‹ Sebelumnya
                </a>
            @endif

            @foreach ($allTransactions->appends(request()->query())->links()->elements[0] ?? [] as $page => $url)
                @if ($page == $allTransactions->currentPage())
                    <span class="px-3 py-1.5 border border-green-600 rounded-md text-sm font-medium bg-green-600 text-white">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" 
                       class="px-3 py-1.5 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50 transition">{{ $page }}</a>
                @endif
            @endforeach

            @if (!count($allTransactions->appends(request()->query())->links()->elements[0] ?? []))
                <span class="px-3 py-1.5 border border-green-600 rounded-md text-sm font-medium bg-green-600 text-white">1</span>
            @endif

            @if ($allTransactions->hasMorePages())
                <a href="{{ $allTransactions->appends(request()->query())->nextPageUrl() }}" 
                   class="px-3 py-1.5 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50 transition">
                    Selanjutnya ›
                </a>
            @else
                <span class="px-3 py-1.5 border border-gray-200 rounded-md text-sm bg-gray-50 text-gray-400 cursor-not-allowed">Selanjutnya ›</span>
            @endif
        </nav>
    </div>

    {{-- ========================================================== --}}
    {{-- TABEL TRANSAKSI                                            --}}
    {{-- ========================================================== --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TANGGAL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PELANGGAN</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JENIS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BERAT (KG)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TOTAL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($allTransactions as $key => $trx)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $allTransactions->firstItem() + $key }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $trx->user_name ?? '—' }}</td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($trx->type == 'withdraw')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Withdraw
                            </span>
                            <br>
                            <span class="text-xs text-gray-500">{{ strtoupper($trx->payment_method ?? '—') }}</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z M8 8h8v2H8V8z M8 12h8v2H8v-2z M8 16h4v2H8v-2z"/>
                                </svg>
                                Setoran
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        @if($trx->type == 'setoran')
                            {{ number_format($trx->berat, 2) }}
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($trx->type == 'withdraw')
                            <span class="text-red-600">- Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                        @else
                            Rp {{ number_format($trx->total ?? 0, 0, ',', '.') }}
                        @endif
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'success' => 'bg-green-100 text-green-800',
                                'failed' => 'bg-red-100 text-red-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                'menunggu' => 'bg-yellow-100 text-yellow-800',
                                'completed' => 'bg-green-100 text-green-800',
                            ];
                            $color = $statusColors[$trx->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </td>

                    {{-- ================================================ --}}
                    {{-- KOLOM AKSI                                        --}}
                    {{-- ================================================ --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-1.5">

                        {{-- ============ SETORAN ============ --}}
                        @if($trx->type == 'setoran')

                            {{-- Approve kalau pending --}}
                            @if(in_array($trx->status, ['pending', 'menunggu']))
                                <form action="{{ route('admin.transaksi.approve', $trx->id) }}" method="POST" id="approve-form-{{ $trx->id }}" style="display:inline-block;">
                                    @csrf
                                    <button type="button" 
                                            class="confirm-btn inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 rounded-md text-xs font-medium transition"
                                            data-form-id="approve-form-{{ $trx->id }}"
                                            data-message="Setujui setoran ini? Poin akan otomatis ditambahkan."
                                            data-title="Konfirmasi Persetujuan">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Approve
                                    </button>
                                </form>
                            @else
                                {{-- Edit, Detail, Hapus kalau sudah diproses --}}
                                <a href="{{ route('admin.transaksi.edit', $trx->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-md text-xs font-medium transition">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <a href="{{ route('admin.transaksi.show', ['id' => $trx->id, 'type' => 'setoran']) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-md text-xs font-medium transition">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                                <button type="button" 
                                        class="delete-btn inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-md text-xs font-medium transition"
                                        data-id="{{ $trx->id }}"
                                        data-nama="Transaksi #{{ $trx->id }}"
                                        data-form-id="delete-form-{{ $trx->id }}">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                                <form action="{{ route('admin.transaksi.destroy', $trx->id) }}" method="POST" id="delete-form-{{ $trx->id }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif

                        {{-- ============ WITHDRAW ============ --}}
                        @elseif($trx->type == 'withdraw')

                            {{-- ✅ CUMA TOMBOL DETAIL — tidak ada Kirim/Tolak --}}
                            <a href="{{ route('admin.transaksi.withdraw-detail', $trx->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-md text-xs font-medium transition">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>

                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-lg font-medium">Belum ada transaksi</p>
                        <p class="text-sm">
                            @if(request('search') || request('tanggal') || request('bulan') || request('tahun'))
                                Tidak ada transaksi yang cocok dengan filter
                            @else
                                Belum ada transaksi yang tercatat
                            @endif
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ========================================================== --}}
    {{-- PAGINATION BAWAH                                            --}}
    {{-- ========================================================== --}}
    <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-3 rounded-lg shadow-sm border border-gray-200">
        <div class="text-sm text-gray-500">
            Menampilkan <span class="font-semibold text-gray-800">{{ $allTransactions->firstItem() ?? 0 }}</span> 
            - <span class="font-semibold text-gray-800">{{ $allTransactions->lastItem() ?? 0 }}</span> 
            dari <span class="font-semibold text-gray-800">{{ $allTransactions->total() }}</span> data
        </div>

        <nav class="flex items-center gap-1">
            @if ($allTransactions->onFirstPage())
                <span class="px-3 py-1.5 border border-gray-200 rounded-md text-sm bg-gray-50 text-gray-400 cursor-not-allowed">‹ Sebelumnya</span>
            @else
                <a href="{{ $allTransactions->appends(request()->query())->previousPageUrl() }}" 
                   class="px-3 py-1.5 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50 transition">
                    ‹ Sebelumnya
                </a>
            @endif

            @foreach ($allTransactions->appends(request()->query())->links()->elements[0] ?? [] as $page => $url)
                @if ($page == $allTransactions->currentPage())
                    <span class="px-3 py-1.5 border border-green-600 rounded-md text-sm font-medium bg-green-600 text-white">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" 
                       class="px-3 py-1.5 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50 transition">{{ $page }}</a>
                @endif
            @endforeach

            @if (!count($allTransactions->appends(request()->query())->links()->elements[0] ?? []))
                <span class="px-3 py-1.5 border border-green-600 rounded-md text-sm font-medium bg-green-600 text-white">1</span>
            @endif

            @if ($allTransactions->hasMorePages())
                <a href="{{ $allTransactions->appends(request()->query())->nextPageUrl() }}" 
                   class="px-3 py-1.5 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50 transition">
                    Selanjutnya ›
                </a>
            @else
                <span class="px-3 py-1.5 border border-gray-200 rounded-md text-sm bg-gray-50 text-gray-400 cursor-not-allowed">Selanjutnya ›</span>
            @endif
        </nav>
    </div>
</div>

{{-- ======================== TOAST ======================== --}}
@if(session('success'))
<div id="toast-success" class="fixed top-6 right-6 z-50 max-w-sm w-full transform transition-all duration-700 ease-out translate-x-0 opacity-100">
    <div class="bg-white rounded-2xl shadow-2xl border border-green-100 overflow-hidden relative">
        <div id="toastProgress-success" class="h-1 bg-gradient-to-r from-green-400 to-green-600 transition-all duration-[4000ms] ease-linear" style="width: 100%"></div>
        <div class="p-5 flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="flex-1 pt-0.5">
                <p class="text-sm font-semibold text-gray-800">Berhasil!</p>
                <p class="text-sm text-gray-600 leading-relaxed">{{ session('success') }}</p>
            </div>
            <button onclick="closeToast('toast-success')" class="flex-shrink-0 mt-1 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div id="toast-error" class="fixed top-6 right-6 z-50 max-w-sm w-full transform transition-all duration-700 ease-out translate-x-0 opacity-100">
    <div class="bg-white rounded-2xl shadow-2xl border border-red-100 overflow-hidden relative">
        <div id="toastProgress-error" class="h-1 bg-gradient-to-r from-red-400 to-red-600 transition-all duration-[4000ms] ease-linear" style="width: 100%"></div>
        <div class="p-5 flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1 pt-0.5">
                <p class="text-sm font-semibold text-gray-800">Gagal!</p>
                <p class="text-sm text-gray-600 leading-relaxed">{{ session('error') }}</p>
            </div>
            <button onclick="closeToast('toast-error')" class="flex-shrink-0 mt-1 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
</div>
@endif

<div id="cancelToastContainer"></div>

{{-- ===== MODAL KONFIRMASI APPROVE SETORAN ===== --}}
<div id="confirmModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
    <div id="confirmModalContent" class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0 p-6">
        <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full mb-4" id="confirmIcon">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-center text-gray-800 mb-2" id="confirmTitle">Konfirmasi</h3>
        <p class="text-sm text-center text-gray-600 mb-6" id="confirmMessage">Apakah Anda yakin?</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button id="confirmCancelBtn" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Batal</button>
            <button id="confirmOkBtn" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

{{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0 p-6">
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-center text-gray-800 mb-2">Hapus Transaksi?</h3>
        <p class="text-sm text-center text-gray-600 mb-6">
            Apakah Anda yakin ingin menghapus <span id="modalNama" class="font-semibold text-gray-800"></span>?
            Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button id="modalCancelBtn" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">Batal</button>
            <button id="modalConfirmBtn" class="px-6 py-2.5 bg-white border-2 border-red-600 text-red-600 hover:bg-red-50 rounded-lg text-sm font-medium transition">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    // ============================================================
    // JAM LIVE
    // ============================================================
    (function() {
        const clockEl = document.getElementById('live-clock');
        const dateEl = document.getElementById('live-date');
        if (!clockEl || !dateEl) return;

        const hariList = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            const hoursStr = String(hours).padStart(2, '0');

            clockEl.textContent = `${hoursStr}:${minutes}:${seconds} ${ampm}`;
            dateEl.textContent = `${hariList[now.getDay()]}, ${now.getDate()} ${bulanList[now.getMonth()]} ${now.getFullYear()}`;
        }

        updateClock();
        setInterval(updateClock, 1000);
    })();

    // ============================================================
    // LIVE SEARCH - Debounce 400ms
    // ============================================================
    (function() {
        const searchInput = document.getElementById('search-input');
        const filterForm = document.getElementById('filterForm');
        const loadingDot = document.getElementById('search-loading');
        if (!searchInput || !filterForm) return;

        let debounceTimer = null;
        const originalValue = searchInput.value;

        searchInput.addEventListener('input', function() {
            const value = this.value.trim();
            if (loadingDot) loadingDot.classList.remove('hidden');
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                if (value !== originalValue) filterForm.submit();
                if (loadingDot) loadingDot.classList.add('hidden');
            }, 400);
        });

        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(debounceTimer);
                filterForm.submit();
            }
        });

        if (searchInput.value) {
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        }
    })();

    // ============================================================
    // AUTO SUBMIT DROPDOWN FILTER
    // ============================================================
    (function() {
        const filterForm = document.getElementById('filterForm');
        if (!filterForm) return;
        ['filter-tanggal', 'filter-bulan', 'filter-tahun'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('change', () => filterForm.submit());
        });
    })();

    // ============================================================
    // TOAST
    // ============================================================
    function closeToast(id) {
        const toast = document.getElementById(id);
        if (toast) {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(function() { toast.remove(); }, 700);
        }
    }

    @if(session('success'))
    (function() {
        let p = 100;
        const interval = setInterval(function() {
            p -= 0.25;
            const bar = document.getElementById('toastProgress-success');
            if (bar) bar.style.width = Math.max(p, 0) + '%';
            if (p <= 0) { clearInterval(interval); closeToast('toast-success'); }
        }, 10);
    })();
    @endif

    @if(session('error'))
    (function() {
        let p = 100;
        const interval = setInterval(function() {
            p -= 0.25;
            const bar = document.getElementById('toastProgress-error');
            if (bar) bar.style.width = Math.max(p, 0) + '%';
            if (p <= 0) { clearInterval(interval); closeToast('toast-error'); }
        }, 10);
    })();
    @endif

    function showCancelToast(message) {
        const container = document.getElementById('cancelToastContainer');
        container.innerHTML = '';
        const toast = document.createElement('div');
        toast.className = 'fixed top-6 right-6 z-50 max-w-sm w-full transform transition-all duration-700 ease-out translate-x-0 opacity-100';
        toast.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl border border-yellow-100 overflow-hidden relative">
                <div class="p-5 flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1 pt-0.5">
                        <p class="text-sm font-semibold text-gray-800">Dibatalkan</p>
                        <p class="text-sm text-gray-600 leading-relaxed">${message}</p>
                    </div>
                    <button onclick="this.closest('.fixed').remove()" class="flex-shrink-0 mt-1 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            const el = container.firstChild;
            if (el) {
                el.classList.remove('translate-x-0', 'opacity-100');
                el.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => el.remove(), 700);
            }
        }, 2500);
    }

    // ============================================================
    // MODAL KONFIRMASI APPROVE SETORAN
    // ============================================================
    (function() {
        const modal = document.getElementById('confirmModal');
        const modalContent = document.getElementById('confirmModalContent');
        const confirmTitle = document.getElementById('confirmTitle');
        const confirmMessage = document.getElementById('confirmMessage');
        const confirmIcon = document.getElementById('confirmIcon');
        const cancelBtn = document.getElementById('confirmCancelBtn');
        const okBtn = document.getElementById('confirmOkBtn');
        let currentFormId = null;

        function showConfirmModal(title, message, formId, iconColor) {
            confirmTitle.textContent = title;
            confirmMessage.textContent = message;
            currentFormId = formId;

            const iconMap = { green: 'bg-green-100', red: 'bg-red-100', yellow: 'bg-yellow-100', blue: 'bg-blue-100' };
            const textMap = { green: 'text-green-600', red: 'text-red-600', yellow: 'text-yellow-600', blue: 'text-blue-600' };
            const bgMap = {
                green: 'bg-green-600 hover:bg-green-700',
                red: 'bg-red-600 hover:bg-red-700',
                yellow: 'bg-yellow-600 hover:bg-yellow-700',
                blue: 'bg-blue-600 hover:bg-blue-700'
            };

            const color = iconColor || 'blue';
            confirmIcon.className = `flex items-center justify-center w-16 h-16 mx-auto rounded-full mb-4 ${iconMap[color]}`;
            confirmIcon.querySelector('svg').className = `w-8 h-8 ${textMap[color]}`;
            okBtn.className = `px-6 py-2.5 ${bgMap[color]} text-white rounded-lg text-sm font-medium transition`;

            okBtn.textContent = color === 'green' ? 'Ya, Setujui' : 'Ya, Lanjutkan';

            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            });
        }

        function hideConfirmModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); currentFormId = null; }, 300);
        }

        document.querySelectorAll('.confirm-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const formId = this.dataset.formId;
                const message = this.dataset.message;
                const title = this.dataset.title || 'Konfirmasi';
                let color = 'blue';
                if (this.classList.contains('bg-green-100')) color = 'green';
                else if (this.classList.contains('bg-red-100')) color = 'red';
                else if (this.classList.contains('bg-yellow-100')) color = 'yellow';
                showConfirmModal(title, message, formId, color);
            });
        });

        cancelBtn.addEventListener('click', function() {
            hideConfirmModal();
            showCancelToast('Tindakan dibatalkan');
        });

        okBtn.addEventListener('click', function() {
            if (currentFormId) {
                const form = document.getElementById(currentFormId);
                if (form) form.submit();
            }
            hideConfirmModal();
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideConfirmModal();
                showCancelToast('Tindakan dibatalkan');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                hideConfirmModal();
                showCancelToast('Tindakan dibatalkan');
            }
        });
    })();

    // ============================================================
    // MODAL KONFIRMASI HAPUS
    // ============================================================
    (function() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        const modalNama = document.getElementById('modalNama');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        let currentFormId = null;

        function showModal(nama, formId) {
            modalNama.textContent = nama;
            currentFormId = formId;
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            });
        }

        function hideModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); currentFormId = null; }, 300);
        }

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const nama = this.dataset.nama;
                const formId = this.dataset.formId;
                if (formId) showModal(nama, formId);
            });
        });

        cancelBtn.addEventListener('click', function() {
            const nama = modalNama.textContent;
            hideModal();
            showCancelToast('Penghapusan ' + nama + ' dibatalkan');
        });

        confirmBtn.addEventListener('click', function() {
            if (currentFormId) {
                const form = document.getElementById(currentFormId);
                if (form) form.submit();
            }
            hideModal();
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                const nama = modalNama.textContent;
                hideModal();
                showCancelToast('Penghapusan ' + nama + ' dibatalkan');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                const nama = modalNama.textContent;
                hideModal();
                showCancelToast('Penghapusan ' + nama + ' dibatalkan');
            }
        });
    })();
</script>

<style>
    #toast-success, #toast-error, #cancelToastContainer .fixed {
        transition: transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
    }
    .translate-x-full { transform: translateX(calc(100% + 2rem)); }
    .opacity-0 { opacity: 0; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
    #toastProgress-success, #toastProgress-error { transition: width 10ms linear; }
    #confirmModalContent, #deleteModalContent {
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
    }
    #confirmModal:not(.hidden), #deleteModal:not(.hidden) {
        background-color: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
    }
    .tabular-nums { font-variant-numeric: tabular-nums; }
    #search-loading { animation: pulse 1s infinite; }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
</style>
@endsection