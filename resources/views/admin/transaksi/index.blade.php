@extends('layouts.admin')

@section('title', 'Semua Transaksi')
@section('page_title', ' Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- HEADER & FILTER TABS --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Semua Transaksi</h1>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.transaksi.index') }}?filter=all" 
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition duration-200 
                      {{ $filter == 'all' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Semua
            </a>
            <a href="{{ route('admin.transaksi.index') }}?filter=setoran" 
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition duration-200 
                      {{ $filter == 'setoran' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                Setoran
            </a>
            <a href="{{ route('admin.transaksi.index') }}?filter=withdraw" 
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition duration-200 
                      {{ $filter == 'withdraw' ? 'bg-yellow-600 text-white' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}">
                Withdraw
            </a>
        </div>
    </div>

    {{-- TABEL TRANSAKSI --}}
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
                    {{-- Nomor urut yang menyesuaikan halaman --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $allTransactions->firstItem() + $key }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $trx->user->name ?? '—' }}</td>

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
                            ];
                            $color = $statusColors[$trx->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </td>

                    {{-- ====== KOLOM AKSI ====== --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-1.5">
                        {{-- APPROVE SETORAN --}}
                        @if($trx->type == 'setoran' && in_array($trx->status, ['pending', 'menunggu']))
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
                        @endif

                        {{-- WITHDRAW PENDING --}}
                        @if($trx->type == 'withdraw' && $trx->status == 'pending')
                            <form action="{{ route('admin.withdraw.approve', $trx->id) }}" method="POST" id="kirim-form-{{ $trx->id }}" style="display:inline-block;">
                                @csrf
                                <button type="button" 
                                        class="confirm-btn inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 rounded-md text-xs font-medium transition"
                                        data-form-id="kirim-form-{{ $trx->id }}"
                                        data-message="Kirim uang ke e-wallet user?"
                                        data-title="Konfirmasi Kirim">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Kirim
                                </button>
                            </form>
                            <form action="{{ route('admin.withdraw.reject', $trx->id) }}" method="POST" id="tolak-form-{{ $trx->id }}" style="display:inline-block;">
                                @csrf
                                <button type="button" 
                                        class="confirm-btn inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-md text-xs font-medium transition"
                                        data-form-id="tolak-form-{{ $trx->id }}"
                                        data-message="Tolak penarikan ini?"
                                        data-title="Konfirmasi Penolakan">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Tolak
                                </button>
                            </form>
                        @endif

                        {{-- SETORAN LAINNYA (edit, detail, hapus) --}}
                        @if($trx->type == 'setoran' && !in_array($trx->status, ['pending', 'menunggu']))
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
                            <form action="{{ route('admin.transaksi.destroy', $trx->id) }}" 
                                  method="POST" 
                                  id="delete-form-{{ $trx->id }}" 
                                  class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif

                        {{-- WITHDRAW SUDAH DIPROSES --}}
                        @if($trx->type == 'withdraw' && $trx->status != 'pending')
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-lg">Belum ada transaksi</p>
                        <p class="text-sm">Belum ada transaksi yang tercatat.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ======================== CUSTOM PAGINATION ======================== --}}
    @if ($allTransactions->hasPages())
    <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        {{-- Info Jumlah Data --}}
        <div class="text-sm text-gray-500">
            Menampilkan <span class="font-semibold text-gray-800">{{ $allTransactions->firstItem() ?? 0 }}</span> 
            - <span class="font-semibold text-gray-800">{{ $allTransactions->lastItem() ?? 0 }}</span> 
            dari <span class="font-semibold text-gray-800">{{ $allTransactions->total() }}</span> data
        </div>

        {{-- Tombol Navigasi --}}
        <nav class="flex items-center gap-1">
            {{-- Tombol Previous --}}
            @if ($allTransactions->onFirstPage())
                <span class="px-3 py-1.5 border border-gray-200 rounded-md text-sm font-medium bg-gray-50 text-gray-400 cursor-not-allowed">
                    Sebelumnya
                </span>
            @else
                {{-- appends(request()->query()) BERFUNGSI AGAR FILTER TETAP AKTIF SAAT PINDAH HALAMAN --}}
                <a href="{{ $allTransactions->appends(request()->query())->previousPageUrl() }}" 
                   class="px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium bg-white text-gray-700 hover:bg-gray-50 transition duration-150">
                    Sebelumnya
                </a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($allTransactions->appends(request()->query())->links()->elements[0] ?? [] as $page => $url)
                @if ($page == $allTransactions->currentPage())
                    <span class="px-3 py-1.5 border border-green-600 rounded-md text-sm font-medium bg-green-600 text-white">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" 
                       class="px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium bg-white text-gray-700 hover:bg-gray-50 transition duration-150">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($allTransactions->hasMorePages())
                <a href="{{ $allTransactions->appends(request()->query())->nextPageUrl() }}" 
                   class="px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium bg-white text-gray-700 hover:bg-gray-50 transition duration-150">
                    Selanjutnya
                </a>
            @else
                <span class="px-3 py-1.5 border border-gray-200 rounded-md text-sm font-medium bg-gray-50 text-gray-400 cursor-not-allowed">
                    Selanjutnya
                </span>
            @endif
        </nav>
    </div>
    @endif
</div>

{{-- ======================== TOAST NOTIFICATIONS ======================== --}}

{{-- Toast Sukses --}}
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
            <button onclick="closeToast('toast-success')" class="flex-shrink-0 mt-1 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif

{{-- Toast Error --}}
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
            <button onclick="closeToast('toast-error')" class="flex-shrink-0 mt-1 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif

{{-- Toast Info --}}
@if(session('info'))
<div id="toast-info" class="fixed top-6 right-6 z-50 max-w-sm w-full transform transition-all duration-700 ease-out translate-x-0 opacity-100">
    <div class="bg-white rounded-2xl shadow-2xl border border-blue-100 overflow-hidden relative">
        <div id="toastProgress-info" class="h-1 bg-gradient-to-r from-blue-400 to-blue-600 transition-all duration-[4000ms] ease-linear" style="width: 100%"></div>
        <div class="p-5 flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1 pt-0.5">
                <p class="text-sm font-semibold text-gray-800">Informasi</p>
                <p class="text-sm text-gray-600 leading-relaxed">{{ session('info') }}</p>
            </div>
            <button onclick="closeToast('toast-info')" class="flex-shrink-0 mt-1 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif

{{-- Toast Batal --}}
<div id="cancelToastContainer"></div>

{{-- ===== MODAL KONFIRMASI UNIVERSAL ===== --}}
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
            <button id="confirmCancelBtn" 
                    class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                Batal
            </button>
            <button id="confirmOkBtn" 
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Ya, Lanjutkan
            </button>
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
    // TOAST NOTIFICATIONS
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
        let progressWidth = 100;
        const interval = setInterval(function() {
            progressWidth -= 0.25;
            const bar = document.getElementById('toastProgress-success');
            if (bar) {
                bar.style.width = Math.max(progressWidth, 0) + '%';
            }
            if (progressWidth <= 0) {
                clearInterval(interval);
                closeToast('toast-success');
            }
        }, 10);
    })();
    @endif

    @if(session('error'))
    (function() {
        let progressWidth = 100;
        const interval = setInterval(function() {
            progressWidth -= 0.25;
            const bar = document.getElementById('toastProgress-error');
            if (bar) {
                bar.style.width = Math.max(progressWidth, 0) + '%';
            }
            if (progressWidth <= 0) {
                clearInterval(interval);
                closeToast('toast-error');
            }
        }, 10);
    })();
    @endif

    @if(session('info'))
    (function() {
        let progressWidth = 100;
        const interval = setInterval(function() {
            progressWidth -= 0.25;
            const bar = document.getElementById('toastProgress-info');
            if (bar) {
                bar.style.width = Math.max(progressWidth, 0) + '%';
            }
            if (progressWidth <= 0) {
                clearInterval(interval);
                closeToast('toast-info');
            }
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
                    <button onclick="this.closest('.fixed').remove()" class="flex-shrink-0 mt-1 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
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
    // MODAL KONFIRMASI UNIVERSAL (untuk Approve, Kirim, Tolak)
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

            // Warna ikon
            const iconMap = {
                green: 'bg-green-100',
                red: 'bg-red-100',
                yellow: 'bg-yellow-100',
                blue: 'bg-blue-100'
            };
            const textMap = {
                green: 'text-green-600',
                red: 'text-red-600',
                yellow: 'text-yellow-600',
                blue: 'text-blue-600'
            };
            const bgMap = {
                green: 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
                red: 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
                yellow: 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500',
                blue: 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'
            };

            const color = iconColor || 'blue';
            confirmIcon.className = `flex items-center justify-center w-16 h-16 mx-auto rounded-full mb-4 ${iconMap[color]}`;
            confirmIcon.querySelector('svg').className = `w-8 h-8 ${textMap[color]}`;
            okBtn.className = `px-6 py-2.5 ${bgMap[color]} text-white rounded-lg text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2`;

            // Ubah teks tombol OK sesuai konteks
            if (color === 'green') okBtn.textContent = 'Ya, Setujui';
            else if (color === 'red') okBtn.textContent = 'Ya, Tolak';
            else if (color === 'yellow') okBtn.textContent = 'Ya, Lanjutkan';
            else okBtn.textContent = 'Ya, Lanjutkan';

            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            });
        }

        function hideConfirmModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                currentFormId = null;
            }, 300);
        }

        // Event listener untuk tombol dengan class confirm-btn
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
                if (form) {
                    form.submit();
                }
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
    #toast-success, #toast-error, #toast-info, #cancelToastContainer .fixed {
        transition: transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
    }
    .translate-x-full {
        transform: translateX(calc(100% + 2rem));
    }
    .opacity-0 { opacity: 0; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
    #toastProgress-success, #toastProgress-error, #toastProgress-info {
        transition: width 10ms linear;
    }
    #confirmModalContent, #deleteModalContent {
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
    }
    #confirmModal:not(.hidden), #deleteModal:not(.hidden) {
        background-color: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
    }
</style>
@endsection