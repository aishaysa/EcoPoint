@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page_title', 'Detail Transaksi')

@section('content')
@php
    // ✅ Cek semua kolom berat yang mungkin ada
    $beratTampil = 0;
    foreach (['berat_aktual', 'berat', 'total_berat'] as $k) {
        $val = $data->{$k} ?? 0;
        if ($val > 0) {
            $beratTampil = $val;
            break;
        }
    }
    // ✅ Fallback: hitung dari pivot jenis sampah
    if ($beratTampil == 0 && isset($data->jenisSampahs) && $data->jenisSampahs->count()) {
        $beratTampil = $data->jenisSampahs->sum(function ($js) {
            return $js->pivot->berat_aktual ?? $js->pivot->berat ?? 0;
        });
    }
@endphp

<div class="container mx-auto px-4 py-6 max-w-5xl">

    {{-- HEADER --}}
    <div class="mb-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.transaksi.index') }}" 
               class="flex items-center justify-center w-10 h-10 rounded-full bg-white hover:bg-green-50 border border-gray-200 text-gray-600 hover:text-green-600 transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Detail Transaksi</h1>
                <p class="text-sm text-gray-500">
                    #{{ $data->id }} · 
                    {{ \Carbon\Carbon::parse($data->tanggal ?? $data->created_at)->format('d M Y, H:i') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @php
                $statusConfig = [
                    'pending'    => ['bg-amber-50',   'text-amber-700',   'border-amber-200',  'bg-amber-500'],
                    'processing' => ['bg-green-50',   'text-green-700',   'border-green-200',  'bg-green-500'],
                    'success'    => ['bg-green-50',   'text-green-700',   'border-green-200',  'bg-green-500'],
                    'completed'  => ['bg-green-50',   'text-green-700',   'border-green-200',  'bg-green-500'],
                    'approved'   => ['bg-green-50',   'text-green-700',   'border-green-200',  'bg-green-500'],
                    'failed'     => ['bg-red-50',     'text-red-700',     'border-red-200',    'bg-red-500'],
                    'rejected'   => ['bg-red-50',     'text-red-700',     'border-red-200',    'bg-red-500'],
                ];
                [$bg, $text, $border, $dot] = $statusConfig[$data->status] ?? ['bg-gray-50', 'text-gray-700', 'border-gray-200', 'bg-gray-500'];
            @endphp
            <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full text-xs font-bold border {{ $bg }} {{ $text }} {{ $border }}">
                <span class="w-2 h-2 rounded-full {{ $dot }} animate-pulse"></span>
                {{ ucfirst($data->status) }}
            </span>

            @if($type == 'setoran')
                <a href="{{ route('admin.transaksi.edit', $data->id) }}" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-full text-sm font-semibold transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- KOLOM KIRI --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- HERO CARD --}}
            @if($type == 'withdraw')
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-green-600 via-green-700 to-emerald-800 p-7 text-white shadow-lg">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-12 -mb-12"></div>
                    <div class="relative">
                        <p class="text-xs uppercase tracking-widest text-green-200 font-semibold mb-2">Jumlah Penukaran</p>
                        <p class="text-4xl font-extrabold tracking-tight mb-1">
                            Rp {{ number_format($data->amount ?? 0, 0, ',', '.') }}
                        </p>
                        <div class="flex items-center gap-2 text-green-100 text-sm">
                            <span>Ditukar dengan <strong>{{ number_format($data->points ?? 0) }} poin</strong></span>
                        </div>
                    </div>
                </div>
            @else
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-green-600 via-green-700 to-emerald-800 p-7 text-white shadow-lg">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-12 -mb-12"></div>
                    <div class="relative">
                        <p class="text-xs uppercase tracking-widest text-green-200 font-semibold mb-2">Total Berat Setoran</p>
                        <p class="text-4xl font-extrabold tracking-tight mb-1">
                            {{ number_format($beratTampil, 2) }} <span class="text-2xl font-semibold">kg</span>
                        </p>
                        <div class="flex items-center gap-2 text-green-100 text-sm">
                            <span>Status: <strong>{{ ucfirst($data->status) }}</strong></span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- INFO PELANGGAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center gap-3 p-5 border-b border-gray-100">
                    <img class="w-12 h-12 rounded-full border-2 border-green-500 shrink-0"
                         src="https://ui-avatars.com/api/?name={{ urlencode($data->user->name ?? 'User') }}&background=2d6a4f&color=fff&size=128"
                         alt="Avatar">
                    <div class="flex-1 min-w-0">
                        <p class="text-base font-bold text-gray-800 truncate">{{ $data->user->name ?? '—' }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $data->user->email ?? '—' }}</p>
                    </div>
                </div>
                @if(isset($data->user->pelanggan) && $data->user->pelanggan)
                    <div class="grid grid-cols-2 divide-x divide-gray-100">
                        <div class="p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase font-semibold mb-1">No. HP</p>
                            <p class="text-sm font-bold text-gray-800">{{ $data->user->pelanggan->no_hp ?? '—' }}</p>
                        </div>
                        <div class="p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Alamat</p>
                            <p class="text-sm font-bold text-gray-800 truncate">{{ $data->user->pelanggan->alamat ?? '—' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- DETAIL SETORAN / WITHDRAW --}}
            @if($type == 'setoran')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-1 h-4 bg-green-500 rounded-full"></span>
                            Detail Setoran
                        </h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Metode</p>
                                <p class="text-sm font-bold text-gray-800">{{ ucfirst($data->metode ?? '—') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Berat</p>
                                <p class="text-sm font-bold text-gray-800">{{ number_format($beratTampil, 2) }} kg</p>
                            </div>
                        </div>

                        @if(isset($data->alamat_jemput) && $data->alamat_jemput)
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Alamat Jemput</p>
                                <p class="text-sm font-medium text-gray-800">{{ $data->alamat_jemput }}</p>
                            </div>
                        @endif

                        @if(isset($data->titik_kumpul) && $data->titik_kumpul)
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Titik Kumpul</p>
                                <p class="text-sm font-medium text-gray-800">{{ $data->titik_kumpul->nama ?? '—' }}</p>
                            </div>
                        @endif

                        @if(isset($data->jenisSampahs) && $data->jenisSampahs->count())
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500 uppercase font-semibold mb-3">Jenis Sampah</p>
                                <div class="space-y-2">
                                    @foreach($data->jenisSampahs as $js)
                                        <div class="flex items-center justify-between p-3 bg-green-50 border border-green-100 rounded-xl">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-lg bg-green-500 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-semibold text-green-900">{{ $js->nama }}</span>
                                            </div>
                                            <span class="text-sm font-bold text-green-700">{{ number_format($js->pivot->berat_aktual ?? $js->pivot->berat ?? 0, 2) }} kg</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                {{-- REKENING --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h3 class="text-sm font-bold text-green-900 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Rekening Tujuan Transfer
                        </h3>
                    </div>

                    <div class="p-5">
                        <div class="space-y-4">
                            @if($data->payment_method == 'bank')
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-xs text-gray-500 uppercase font-semibold">Bank</span>
                                    <span class="text-sm font-bold text-gray-800">{{ strtoupper($data->bank_name ?? '-') }}</span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Nomor Rekening</p>
                                    <div class="p-3 bg-green-50 border-2 border-dashed border-green-300 rounded-xl">
                                        <p class="text-2xl font-mono font-extrabold text-gray-900 tracking-wider">{{ $data->account_number ?? '—' }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-xs text-gray-500 uppercase font-semibold">Atas Nama</span>
                                    <span class="text-sm font-semibold text-gray-800">{{ $data->account_name ?? $data->user->name ?? '—' }}</span>
                                </div>
                            @else
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Nomor {{ strtoupper($data->payment_method ?? '') }}</p>
                                    <div class="p-3 bg-green-50 border-2 border-dashed border-green-300 rounded-xl">
                                        <p class="text-2xl font-mono font-extrabold text-gray-900 tracking-wider">{{ $data->account_number ?? '—' }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-xs text-gray-500 uppercase font-semibold">Atas Nama</span>
                                    <span class="text-sm font-semibold text-gray-800">{{ $data->account_name ?? $data->user->name ?? '—' }}</span>
                                </div>
                            @endif

                            <button type="button" 
                                    onclick="copyAccountNumber('{{ $data->account_number }}')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl text-sm font-bold transition shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Copy Nomor Rekening
                            </button>
                        </div>
                    </div>

                    <div class="px-5 py-3 bg-green-50 border-t border-green-100">
                        <p class="text-xs text-green-800 leading-relaxed">
                            💡 Poin user <strong>sudah otomatis dipotong</strong>. Silakan transfer ke rekening di atas secara manual.
                        </p>
                    </div>
                </div>

                @if($data->admin_note)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Catatan Admin</p>
                        <p class="text-sm text-gray-700 italic">"{{ $data->admin_note }}"</p>
                    </div>
                @endif
            @endif
        </div>

        {{-- KOLOM KANAN --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <span class="w-1 h-4 bg-green-500 rounded-full"></span>
                        Ringkasan
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    <div class="flex justify-between items-center px-5 py-3">
                        <span class="text-xs text-gray-500 uppercase font-semibold">ID</span>
                        <span class="text-sm font-bold text-gray-800">#{{ $data->id }}</span>
                    </div>
                    <div class="flex justify-between items-center px-5 py-3">
                        <span class="text-xs text-gray-500 uppercase font-semibold">Tipe</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                            {{ $type == 'withdraw' ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($type) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center px-5 py-3">
                        <span class="text-xs text-gray-500 uppercase font-semibold">Tanggal</span>
                        <span class="text-sm font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($data->tanggal ?? $data->created_at)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center px-5 py-3">
                        <span class="text-xs text-gray-500 uppercase font-semibold">Jam</span>
                        <span class="text-sm font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($data->tanggal ?? $data->created_at)->format('H:i') }} WIB
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <span class="w-1 h-4 bg-green-500 rounded-full"></span>
                        Timeline
                    </h3>
                </div>
                <div class="p-5">
                    <div class="relative space-y-6">
                        <div class="absolute left-[7px] top-2 bottom-2 w-0.5 bg-gray-200"></div>

                        <div class="relative flex gap-4">
                            <div class="relative z-10 w-4 h-4 rounded-full bg-green-500 border-4 border-green-100 shrink-0 mt-0.5"></div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Dibuat</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>

                        @if(isset($data->processed_at) && $data->processed_at)
                            <div class="relative flex gap-4">
                                <div class="relative z-10 w-4 h-4 rounded-full bg-green-600 border-4 border-green-100 shrink-0 mt-0.5"></div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-semibold">Diproses</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($data->processed_at)->format('d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($data->processed_at)->format('H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="relative flex gap-4">
                            <div class="relative z-10 w-4 h-4 rounded-full bg-gray-400 border-4 border-gray-100 shrink-0 mt-0.5"></div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Diperbarui</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($data->updated_at)->format('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($data->updated_at)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="copyToast" class="fixed bottom-6 left-1/2 -translate-x-1/2 translate-y-24 opacity-0 pointer-events-none z-50 transition-all duration-300">
    <div class="bg-gray-900 text-white px-5 py-3 rounded-full shadow-2xl flex items-center gap-2">
        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="text-sm font-medium" id="copyToastText">Berhasil di-copy!</span>
    </div>
</div>

<script>
function copyAccountNumber(number) {
    if (!number) {
        showCopyToast('Nomor rekening tidak tersedia', false);
        return;
    }
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(number).then(function() {
            showCopyToast('Nomor ' + number + ' berhasil di-copy!');
        }).catch(function() { fallbackCopy(number); });
    } else {
        fallbackCopy(number);
    }
}

function fallbackCopy(text) {
    const tempInput = document.createElement('input');
    tempInput.value = text;
    tempInput.style.position = 'fixed';
    tempInput.style.opacity = '0';
    document.body.appendChild(tempInput);
    tempInput.select();
    try {
        document.execCommand('copy');
        showCopyToast('Nomor ' + text + ' berhasil di-copy!');
    } catch (err) {
        showCopyToast('Gagal copy. Silakan copy manual.', false);
    }
    document.body.removeChild(tempInput);
}

function showCopyToast(message, success = true) {
    const toast = document.getElementById('copyToast');
    const text = document.getElementById('copyToastText');
    text.textContent = message;
    const icon = toast.querySelector('svg');
    if (success) {
        icon.className = 'w-4 h-4 text-green-400';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>';
    } else {
        icon.className = 'w-4 h-4 text-red-400';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>';
    }
    toast.classList.remove('translate-y-24', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');
    clearTimeout(window.copyToastTimer);
    window.copyToastTimer = setTimeout(() => {
        toast.classList.add('translate-y-24', 'opacity-0');
        toast.classList.remove('translate-y-0', 'opacity-100');
    }, 2000);
}
</script>
@endsection