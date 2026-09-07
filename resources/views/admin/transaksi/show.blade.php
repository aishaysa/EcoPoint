@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page_title', 'Detail Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Transaksi #{{ $data->id }}
        </h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.transaksi.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            @if($type == 'setoran')
                <a href="{{ route('admin.transaksi.edit', $data->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Informasi Umum --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Informasi Transaksi</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">ID</dt>
                            <dd class="text-sm text-gray-900 font-medium">#{{ $data->id }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Tanggal</dt>
                            <dd class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($data->tanggal ?? $data->created_at)->format('d M Y, H:i') }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Tipe</dt>
                            <dd class="text-sm">
                                @if($type == 'withdraw')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Withdraw
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Setoran
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Status</dt>
                            <dd class="text-sm">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'success' => 'bg-green-100 text-green-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $color = $statusColors[$data->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Informasi Pelanggan --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Pelanggan</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Nama</dt>
                            <dd class="text-sm text-gray-900 font-medium">{{ $data->user->name ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Email</dt>
                            <dd class="text-sm text-gray-900">{{ $data->user->email ?? '—' }}</dd>
                        </div>
                        @if(isset($data->user->pelanggan) && $data->user->pelanggan)
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">No. HP</dt>
                            <dd class="text-sm text-gray-900">{{ $data->user->pelanggan->no_hp ?? '—' }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- Detail Khusus --}}
            <hr class="my-6 border-gray-200">

            @if($type == 'setoran')
                {{-- Detail Setoran --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Detail Setoran</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Metode</dt>
                            <dd class="text-sm text-gray-900">{{ ucfirst($data->metode ?? '—') }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Berat Aktual</dt>
                            <dd class="text-sm text-gray-900">{{ number_format($data->berat_aktual ?? 0, 2) }} kg</dd>
                        </div>
                        @if(isset($data->alamat_jemput))
                        <div class="flex justify-between border-b border-gray-100 py-1.5 col-span-2">
                            <dt class="text-sm font-medium text-gray-600">Alamat Jemput</dt>
                            <dd class="text-sm text-gray-900">{{ $data->alamat_jemput ?? '—' }}</dd>
                        </div>
                        @endif
                        @if(isset($data->titik_kumpul))
                        <div class="flex justify-between border-b border-gray-100 py-1.5 col-span-2">
                            <dt class="text-sm font-medium text-gray-600">Titik Kumpul</dt>
                            <dd class="text-sm text-gray-900">{{ $data->titik_kumpul->nama ?? '—' }}</dd>
                        </div>
                        @endif
                        @if(isset($data->jenisSampahs) && $data->jenisSampahs->count())
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-600 mb-2">Jenis Sampah</dt>
                            <dd>
                                <ul class="list-disc list-inside text-sm text-gray-900">
                                    @foreach($data->jenisSampahs as $js)
                                        <li>{{ $js->nama }} ({{ number_format($js->pivot->berat_aktual ?? 0, 2) }} kg)</li>
                                    @endforeach
                                </ul>
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            @else
                {{-- Detail Withdraw --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Detail Penarikan</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Poin</dt>
                            <dd class="text-sm text-gray-900">{{ number_format($data->points ?? 0) }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Jumlah</dt>
                            <dd class="text-sm font-semibold text-red-600">- Rp {{ number_format($data->amount ?? 0, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Metode</dt>
                            <dd class="text-sm text-gray-900">{{ strtoupper($data->payment_method ?? '—') }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">No. Tujuan</dt>
                            <dd class="text-sm text-gray-900">{{ $data->account_number ?? '—' }}</dd>
                        </div>
                        @if($data->bank_name)
                        <div class="flex justify-between border-b border-gray-100 py-1.5">
                            <dt class="text-sm font-medium text-gray-600">Bank</dt>
                            <dd class="text-sm text-gray-900">{{ $data->bank_name }}</dd>
                        </div>
                        @endif
                        @if($data->admin_note)
                        <div class="flex justify-between border-b border-gray-100 py-1.5 col-span-2">
                            <dt class="text-sm font-medium text-gray-600">Catatan Admin</dt>
                            <dd class="text-sm text-gray-900">{{ $data->admin_note }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex flex-wrap gap-3">
                @if($type == 'withdraw' && $data->status == 'pending')
                    <form action="{{ route('admin.withdraw.approve', $data->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition shadow"
                                onclick="return confirm('Kirim uang ke e-wallet user?')">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Kirim Uang
                        </button>
                    </form>
                    <form action="{{ route('admin.withdraw.reject', $data->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition shadow"
                                onclick="return confirm('Tolak penarikan ini?')">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tolak
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection