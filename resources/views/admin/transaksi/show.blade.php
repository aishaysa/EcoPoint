@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page_title', 'Detail Transaksi')

@section('content')
@php
    // Cek semua kolom berat yang mungkin ada
    $beratTampil = 0;
    foreach (['berat_aktual', 'berat', 'total_berat'] as $k) {
        $val = $data->{$k} ?? 0;
        if ($val > 0) {
            $beratTampil = $val;
            break;
        }
    }
    // Fallback: hitung dari pivot jenis sampah
    if ($beratTampil == 0 && isset($data->jenisSampahs) && $data->jenisSampahs->count()) {
        $beratTampil = $data->jenisSampahs->sum(function ($js) {
            return $js->pivot->berat_aktual ?? $js->pivot->berat ?? 0;
        });
    }

    // Status config
    $statusConfig = [
        'pending'    => ['bg' => '#fef3c7', 'color' => '#92400e', 'dot' => '#d97706', 'label' => 'Menunggu'],
        'processing' => ['bg' => '#dcfce7', 'color' => '#15803d', 'dot' => '#16a34a', 'label' => 'Diproses'],
        'success'    => ['bg' => '#dcfce7', 'color' => '#15803d', 'dot' => '#16a34a', 'label' => 'Berhasil'],
        'completed'  => ['bg' => '#dcfce7', 'color' => '#15803d', 'dot' => '#16a34a', 'label' => 'Selesai'],
        'approved'   => ['bg' => '#dcfce7', 'color' => '#15803d', 'dot' => '#16a34a', 'label' => 'Disetujui'],
        'failed'     => ['bg' => '#fee2e2', 'color' => '#b91c1c', 'dot' => '#dc2626', 'label' => 'Gagal'],
        'rejected'   => ['bg' => '#fee2e2', 'color' => '#b91c1c', 'dot' => '#dc2626', 'label' => 'Ditolak'],
    ];
    $st = $statusConfig[$data->status] ?? ['bg' => '#f1f5f9', 'color' => '#475569', 'dot' => '#64748b', 'label' => ucfirst($data->status)];
@endphp

<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1f2937; margin:0;">Detail Transaksi</h1>
            <p style="font-size:14px; color:#6b7280; margin:4px 0 0 0;">
                #{{ $data->id }} • {{ \Carbon\Carbon::parse($data->tanggal ?? $data->created_at)->format('d M Y, H:i') }} WIB
            </p>
        </div>
        <div style="display:flex; gap:8px; flex-wrap:wrap;">
            <span style="display:inline-flex; align-items:center; gap:8px; padding:8px 16px; border-radius:20px; font-size:13px; font-weight:700; background:{{ $st['bg'] }}; color:{{ $st['color'] }}; border:2px solid {{ $st['color'] }}30;">
                <span style="width:8px; height:8px; border-radius:50%; background:{{ $st['dot'] }};"></span>
                {{ $st['label'] }}
            </span>
            @if($type == 'setoran')
                <a href="{{ route('admin.transaksi.edit', $data->id) }}" 
                   style="display:inline-flex; align-items:center; padding:10px 20px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                    <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            @endif
            <a href="{{ route('admin.transaksi.index') }}" 
               style="display:inline-flex; align-items:center; padding:10px 20px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- LAYOUT GRID --}}
    <div style="display:grid; grid-template-columns:1fr; gap:20px;">

        {{-- HERO CARD --}}
        @if($type == 'withdraw')
            <div style="position:relative; overflow:hidden; border-radius:12px; background:linear-gradient(135deg, #16a34a, #15803d); padding:28px; color:#fff;">
                <div style="position:absolute; top:-60px; right:-60px; width:200px; height:200px; background:rgba(255,255,255,0.08); border-radius:50%;"></div>
                <div style="position:absolute; bottom:-60px; left:-40px; width:160px; height:160px; background:rgba(255,255,255,0.06); border-radius:50%;"></div>
                <div style="position:relative;">
                    <p style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:#bbf7d0; font-weight:700; margin:0 0 8px 0;">Jumlah Penukaran</p>
                    <p style="font-size:38px; font-weight:800; letter-spacing:-1px; margin:0 0 8px 0; line-height:1.1;">
                        Rp {{ number_format($data->amount ?? 0, 0, ',', '.') }}
                    </p>
                    <p style="font-size:14px; color:#dcfce7; margin:0;">
                        Ditukar dengan <strong>{{ number_format($data->points ?? 0) }} poin</strong>
                    </p>
                </div>
            </div>
        @else
            <div style="position:relative; overflow:hidden; border-radius:12px; background:linear-gradient(135deg, #16a34a, #15803d); padding:28px; color:#fff;">
                <div style="position:absolute; top:-60px; right:-60px; width:200px; height:200px; background:rgba(255,255,255,0.08); border-radius:50%;"></div>
                <div style="position:absolute; bottom:-60px; left:-40px; width:160px; height:160px; background:rgba(255,255,255,0.06); border-radius:50%;"></div>
                <div style="position:relative;">
                    <p style="font-size:11px; text-transform:uppercase; letter-spacing:1px; color:#bbf7d0; font-weight:700; margin:0 0 8px 0;">Total Berat Setoran</p>
                    <p style="font-size:38px; font-weight:800; letter-spacing:-1px; margin:0 0 8px 0; line-height:1.1;">
                        {{ number_format($beratTampil, 2) }} <span style="font-size:20px; font-weight:600;">kg</span>
                    </p>
                    <p style="font-size:14px; color:#dcfce7; margin:0;">
                        Status: <strong>{{ $st['label'] }}</strong>
                    </p>
                </div>
            </div>
        @endif

        {{-- LAYOUT 2 KOLOM --}}
        <div style="display:grid; grid-template-columns:1fr; gap:20px;" class="lg:grid-cols-3">

            {{-- KOLOM KIRI --}}
            <div style="grid-column:span 1;" class="lg:col-span-2">

                {{-- INFO PELANGGAN --}}
                <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden; margin-bottom:20px;">
                    <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb; display:flex; align-items:center; gap:10px;">
                        <svg style="width:18px; height:18px; color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Informasi Pelanggan</h3>
                    </div>

                    <div style="padding:20px; display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                        <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                            <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 6px 0;">Nama</p>
                            <p style="font-size:15px; font-weight:700; color:#1f2937; margin:0;">{{ $data->user->name ?? '—' }}</p>
                        </div>
                        <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                            <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 6px 0;">Email</p>
                            <p style="font-size:14px; font-weight:600; color:#1f2937; margin:0; word-break:break-word;">{{ $data->user->email ?? '—' }}</p>
                        </div>
                        @if(isset($data->user->pelanggan) && $data->user->pelanggan)
                            <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                                <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 6px 0;">No HP</p>
                                @if($data->user->pelanggan->no_hp)
                                    <a href="tel:{{ $data->user->pelanggan->no_hp }}" style="font-size:15px; font-weight:700; color:#16a34a; text-decoration:none;">{{ $data->user->pelanggan->no_hp }}</a>
                                @else
                                    <p style="font-size:14px; color:#9ca3af; margin:0; font-style:italic;">-</p>
                                @endif
                            </div>
                            <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                                <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 6px 0;">Alamat</p>
                                <p style="font-size:14px; font-weight:500; color:#1f2937; margin:0; line-height:1.5;">{{ $data->user->pelanggan->alamat ?? '-' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- DETAIL SETORAN --}}
                @if($type == 'setoran')
                    <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden;">
                        <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb; display:flex; align-items:center; gap:10px;">
                            <svg style="width:18px; height:18px; color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Detail Setoran</h3>
                        </div>

                        <div style="padding:20px;">
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                                <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 6px 0;">Metode</p>
                                    <p style="font-size:15px; font-weight:700; color:#1f2937; margin:0; text-transform:capitalize;">{{ $data->metode ?? '—' }}</p>
                                </div>
                                <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 6px 0;">Berat</p>
                                    <p style="font-size:15px; font-weight:700; color:#16a34a; margin:0;">{{ number_format($beratTampil, 2) }} kg</p>
                                </div>
                            </div>

                            @if(isset($data->alamat_jemput) && $data->alamat_jemput)
                                <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb; margin-bottom:16px;">
                                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 6px 0;">Alamat Jemput</p>
                                    <p style="font-size:14px; font-weight:500; color:#1f2937; margin:0; line-height:1.5;">{{ $data->alamat_jemput }}</p>
                                </div>
                            @endif

                            @if(isset($data->titik_kumpul) && $data->titik_kumpul)
                                <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb; margin-bottom:16px;">
                                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 6px 0;">Titik Kumpul</p>
                                    <p style="font-size:14px; font-weight:700; color:#1f2937; margin:0;">{{ $data->titik_kumpul->nama ?? '—' }}</p>
                                </div>
                            @endif

                            @if(isset($data->jenisSampahs) && $data->jenisSampahs->count())
                                <div>
                                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 12px 0;">Jenis Sampah</p>
                                    <div style="display:flex; flex-direction:column; gap:8px;">
                                        @foreach($data->jenisSampahs as $js)
                                            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; background:#f0fdf4; border:2px solid #bbf7d0; border-radius:8px;">
                                                <div style="display:flex; align-items:center; gap:10px;">
                                                    <div style="width:32px; height:32px; border-radius:8px; background:#16a34a; display:flex; align-items:center; justify-content:center;">
                                                        <svg style="width:16px; height:16px; color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                        </svg>
                                                    </div>
                                                    <span style="font-size:14px; font-weight:700; color:#15803d;">{{ $js->nama }}</span>
                                                </div>
                                                <span style="font-size:14px; font-weight:700; color:#15803d;">
                                                    {{ number_format($js->pivot->berat_aktual ?? $js->pivot->berat ?? 0, 2) }} kg
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- REKENING WITHDRAW --}}
                    <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden; margin-bottom:20px;">
                        <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb; display:flex; align-items:center; gap:10px;">
                            <svg style="width:18px; height:18px; color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Rekening Tujuan Transfer</h3>
                        </div>

                        <div style="padding:20px;">
                            @if($data->payment_method == 'bank')
                                <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #f1f5f9;">
                                    <span style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700;">Bank</span>
                                    <span style="font-size:14px; font-weight:700; color:#1f2937;">{{ strtoupper($data->bank_name ?? '-') }}</span>
                                </div>
                            @endif

                            <div style="margin:16px 0;">
                                <p style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700; margin:0 0 8px 0;">
                                    Nomor {{ $data->payment_method == 'bank' ? 'Rekening' : strtoupper($data->payment_method ?? '') }}
                                </p>
                                <div style="padding:16px; background:#f0fdf4; border:2px dashed #86efac; border-radius:8px; text-align:center;">
                                    <p style="font-size:22px; font-family:monospace; font-weight:800; color:#1f2937; margin:0; letter-spacing:2px;">
                                        {{ $data->account_number ?? '—' }}
                                    </p>
                                </div>
                            </div>

                            <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #f1f5f9; margin-bottom:16px;">
                                <span style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700;">Atas Nama</span>
                                <span style="font-size:14px; font-weight:700; color:#1f2937;">{{ $data->account_name ?? $data->user->name ?? '—' }}</span>
                            </div>

                            <button type="button" 
                                    onclick="copyAccountNumber('{{ $data->account_number }}')"
                                    style="width:100%; display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:14px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; cursor:pointer;">
                                <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Copy Nomor Rekening
                            </button>
                        </div>

                        <div style="padding:12px 20px; background:#f0fdf4; border-top:2px solid #bbf7d0;">
                            <p style="font-size:12px; color:#15803d; margin:0; line-height:1.6;">
                                <strong>💡 Info:</strong> Poin user sudah otomatis dipotong. Silakan transfer ke rekening di atas secara manual.
                            </p>
                        </div>
                    </div>

                    @if($data->admin_note)
                        <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; padding:16px 20px;">
                            <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 8px 0;">Catatan Admin</p>
                            <p style="font-size:14px; color:#1f2937; margin:0; font-style:italic; line-height:1.6;">"{{ $data->admin_note }}"</p>
                        </div>
                    @endif
                @endif

            </div>

            {{-- KOLOM KANAN --}}
            <div class="lg:col-span-1">

                {{-- RINGKASAN --}}
                <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden; margin-bottom:20px;">
                    <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                        <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Ringkasan</h3>
                    </div>
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 20px; border-bottom:1px solid #f1f5f9;">
                            <span style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700;">ID Transaksi</span>
                            <span style="font-size:14px; font-weight:700; color:#1f2937; font-family:monospace;">#{{ $data->id }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 20px; border-bottom:1px solid #f1f5f9;">
                            <span style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700;">Tipe</span>
                            <span style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; background:{{ $type == 'withdraw' ? '#fef3c7' : '#dcfce7' }}; color:{{ $type == 'withdraw' ? '#92400e' : '#15803d' }};">
                                {{ ucfirst($type) }}
                            </span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 20px; border-bottom:1px solid #f1f5f9;">
                            <span style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700;">Tanggal</span>
                            <span style="font-size:14px; font-weight:600; color:#1f2937;">
                                {{ \Carbon\Carbon::parse($data->tanggal ?? $data->created_at)->format('d M Y') }}
                            </span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 20px;">
                            <span style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700;">Jam</span>
                            <span style="font-size:14px; font-weight:600; color:#1f2937;">
                                {{ \Carbon\Carbon::parse($data->tanggal ?? $data->created_at)->format('H:i') }} WIB
                            </span>
                        </div>
                    </div>
                </div>

                {{-- TIMELINE --}}
                <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden;">
                    <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                        <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Timeline</h3>
                    </div>
                    <div style="padding:20px; position:relative;">

                        <div style="position:absolute; left:29px; top:32px; bottom:32px; width:2px; background:#e5e7eb;"></div>

                        {{-- Dibuat --}}
                        <div style="display:flex; gap:16px; margin-bottom:24px; position:relative;">
                            <div style="width:16px; height:16px; border-radius:50%; background:#16a34a; border:4px solid #dcfce7; flex-shrink:0; margin-top:4px; z-index:1;"></div>
                            <div>
                                <p style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700; margin:0 0 2px 0;">Dibuat</p>
                                <p style="font-size:14px; font-weight:700; color:#1f2937; margin:0;">
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}
                                </p>
                                <p style="font-size:12px; color:#6b7280; margin:2px 0 0 0;">
                                    {{ \Carbon\Carbon::parse($data->created_at)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>

                        {{-- Diproses --}}
                        @if(isset($data->processed_at) && $data->processed_at)
                            <div style="display:flex; gap:16px; margin-bottom:24px; position:relative;">
                                <div style="width:16px; height:16px; border-radius:50%; background:#16a34a; border:4px solid #dcfce7; flex-shrink:0; margin-top:4px; z-index:1;"></div>
                                <div>
                                    <p style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700; margin:0 0 2px 0;">Diproses</p>
                                    <p style="font-size:14px; font-weight:700; color:#1f2937; margin:0;">
                                        {{ \Carbon\Carbon::parse($data->processed_at)->format('d M Y') }}
                                    </p>
                                    <p style="font-size:12px; color:#6b7280; margin:2px 0 0 0;">
                                        {{ \Carbon\Carbon::parse($data->processed_at)->format('H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Diperbarui --}}
                        <div style="display:flex; gap:16px; position:relative;">
                            <div style="width:16px; height:16px; border-radius:50%; background:#94a3b8; border:4px solid #f1f5f9; flex-shrink:0; margin-top:4px; z-index:1;"></div>
                            <div>
                                <p style="font-size:11px; color:#6b7280; text-transform:uppercase; font-weight:700; margin:0 0 2px 0;">Diperbarui</p>
                                <p style="font-size:14px; font-weight:700; color:#1f2937; margin:0;">
                                    {{ \Carbon\Carbon::parse($data->updated_at)->format('d M Y') }}
                                </p>
                                <p style="font-size:12px; color:#6b7280; margin:2px 0 0 0;">
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

{{-- COPY TOAST --}}
<div id="copyToast" style="position:fixed; bottom:24px; left:50%; transform:translateX(-50%) translateY(96px); opacity:0; pointer-events:none; z-index:9999; transition:all 0.3s ease;">
    <div style="background:#1f2937; color:#fff; padding:12px 20px; border-radius:999px; box-shadow:0 20px 25px -5px rgba(0,0,0,0.3); display:flex; align-items:center; gap:8px;">
        <svg id="copyToastIcon" style="width:16px; height:16px; color:#4ade80;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <span id="copyToastText" style="font-size:14px; font-weight:600;">Berhasil di-copy!</span>
    </div>
</div>

<style>
    @media (min-width: 1024px) {
        .lg\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
        .lg\:col-span-2 {
            grid-column: span 2 / span 2 !important;
        }
        .lg\:col-span-1 {
            grid-column: span 1 / span 1 !important;
        }
    }
</style>

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
    const icon = document.getElementById('copyToastIcon');
    text.textContent = message;
    if (success) {
        icon.style.color = '#4ade80';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>';
    } else {
        icon.style.color = '#f87171';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>';
    }
    toast.style.transform = 'translateX(-50%) translateY(0)';
    toast.style.opacity = '1';
    clearTimeout(window.copyToastTimer);
    window.copyToastTimer = setTimeout(() => {
        toast.style.transform = 'translateX(-50%) translateY(96px)';
        toast.style.opacity = '0';
    }, 2000);
}
</script>
@endsection