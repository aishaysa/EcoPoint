@extends('layouts.admin')

@section('title', 'Detail Penarikan Poin #' . $withdrawal->id)
@section('page_title', 'Detail Penarikan Dana')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.transaksi.index', ['filter' => 'withdraw']) }}" 
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
            &larr; Kembali ke Daftar Transaksi
        </a>
        <span class="px-3 py-1 text-xs font-semibold rounded-full 
            {{ $withdrawal->status === 'completed' ? 'bg-green-100 text-green-800' : 
               ($withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
            Status: {{ strtoupper($withdrawal->status) }}
        </span>
    </div>

    <div class="bg-white shadow rounded-2xl overflow-hidden border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg leading-6 font-bold text-gray-900">
                Informasi Penarikan #{{ $withdrawal->reference_id ?? $withdrawal->id }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Tanggal Pengajuan: {{ $withdrawal->created_at->format('d M Y, H:i') }} WIB
            </p>
        </div>
        <div class="px-6 py-5">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Pengguna</dt>
                    <dd class="mt-1 text-base font-semibold text-gray-900">{{ $withdrawal->user->name ?? '-' }}</dd>
                    <dd class="text-xs text-gray-500">{{ $withdrawal->user->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Poin Ditukarkan</dt>
                    <dd class="mt-1 text-base font-semibold text-emerald-600">{{ number_format($withdrawal->points) }} Poin</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                    <dd class="mt-1 text-base font-semibold uppercase text-gray-900">{{ $withdrawal->payment_method }}</dd>
                    @if($withdrawal->bank_name)
                        <dd class="text-xs text-gray-500">Bank: {{ $withdrawal->bank_name }}</dd>
                    @endif
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nominal Transfer</dt>
                    <dd class="mt-1 text-xl font-bold text-gray-900">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nomor Rekening / E-Wallet</dt>
                    <dd class="mt-1 text-base font-mono font-semibold text-gray-900">{{ $withdrawal->account_number }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Atas Nama Rekening</dt>
                    <dd class="mt-1 text-base font-semibold text-gray-900">{{ $withdrawal->account_name }}</dd>
                </div>
                @if($withdrawal->admin_note)
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Catatan Admin</dt>
                    <dd class="mt-1 text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $withdrawal->admin_note }}</dd>
                </div>
                @endif
            </dl>
        </div>

        @if($withdrawal->status === 'pending')
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
            <form action="{{ route('admin.withdraw.reject', $withdrawal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak penarikan ini? Poin akan dikembalikan ke user.');">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium transition shadow-sm">
                    Tolak Penarikan
                </button>
            </form>
            <form action="{{ route('admin.withdraw.approve', $withdrawal->id) }}" method="POST" onsubmit="return confirm('Setujui penarikan ini? Pastikan dana sudah berhasil ditransfer.');">
                @csrf
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium transition shadow-sm">
                    Setujui & Selesaikan
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection