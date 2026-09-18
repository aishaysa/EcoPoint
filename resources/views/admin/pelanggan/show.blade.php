@extends('layouts.admin')

@section('title', 'Detail Pelanggan')
@section('page_title', 'Detail Pelanggan')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px; font-weight:700; color:#1f2937; margin:0;">Detail Pelanggan</h1>
            <p style="font-size:14px; color:#6b7280; margin:4px 0 0 0;">Informasi lengkap dan riwayat setoran pelanggan</p>
        </div>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}" 
               style="display:inline-flex; align-items:center; padding:10px 20px; background:#16a34a; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none; transition:all 0.2s;">
                <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.pelanggan.index') }}" 
               style="display:inline-flex; align-items:center; padding:10px 20px; background:#fff; color:#374151; border:2px solid #d1d5db; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none; transition:all 0.2s;">
                <svg style="width:16px; height:16px; margin-right:6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div style="background:#f0fdf4; border:2px solid #bbf7d0; border-radius:8px; padding:14px 16px; margin-bottom:16px; display:flex; align-items:center; gap:10px;">
            <svg style="width:20px; height:20px; color:#15803d; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p style="font-size:14px; font-weight:600; color:#15803d; margin:0;">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fef2f2; border:2px solid #fecaca; border-radius:8px; padding:14px 16px; margin-bottom:16px; display:flex; align-items:center; gap:10px;">
            <svg style="width:20px; height:20px; color:#b91c1c; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <p style="font-size:14px; font-weight:600; color:#b91c1c; margin:0;">{{ session('error') }}</p>
        </div>
    @endif

    {{-- PROFILE CARD --}}
    <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden; margin-bottom:20px;">

        <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <svg style="width:20px; height:20px; color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Informasi Pelanggan</h3>
            </div>
            <span style="font-size:11px; font-weight:600; color:#6b7280; background:#e5e7eb; padding:4px 10px; border-radius:6px;">
                ID: #{{ $pelanggan->id }}
            </span>
        </div>

        <div style="padding:20px; display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">

            {{-- Nama --}}
            <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                    <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Nama</p>
                </div>
                <p style="font-size:15px; font-weight:700; color:#1f2937; margin:0;">{{ $pelanggan->nama ?? '-' }}</p>
            </div>

            {{-- No HP --}}
            <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                    <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">No HP</p>
                </div>
                @if($pelanggan->no_hp)
                    <a href="tel:{{ $pelanggan->no_hp }}" style="font-size:15px; font-weight:700; color:#16a34a; margin:0; text-decoration:none;">{{ $pelanggan->no_hp }}</a>
                @else
                    <p style="font-size:15px; font-weight:500; color:#9ca3af; margin:0; font-style:italic;">Belum diisi</p>
                @endif
            </div>

            {{-- Email --}}
            <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                    <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Email</p>
                </div>
                @if($pelanggan->email)
                    <p style="font-size:14px; font-weight:600; color:#1f2937; margin:0; word-break:break-word;">{{ $pelanggan->email }}</p>
                @else
                    <p style="font-size:15px; font-weight:500; color:#9ca3af; margin:0; font-style:italic;">Belum diisi</p>
                @endif
            </div>

            {{-- Bergabung --}}
            <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                    <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Bergabung</p>
                </div>
                <p style="font-size:14px; font-weight:600; color:#1f2937; margin:0;">
                    {{ $pelanggan->created_at ? $pelanggan->created_at->format('d M Y') : '-' }}
                </p>
            </div>

            {{-- Alamat --}}
            <div style="padding:14px 16px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb; grid-column:1 / -1;">
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                    <svg style="width:14px; height:14px; color:#6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p style="font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Alamat</p>
                </div>
                @if($pelanggan->alamat)
                    <p style="font-size:14px; font-weight:500; color:#1f2937; margin:0; line-height:1.6;">{{ $pelanggan->alamat }}</p>
                @else
                    <p style="font-size:14px; font-weight:500; color:#9ca3af; margin:0; font-style:italic;">Alamat belum diisi</p>
                @endif
            </div>

        </div>
    </div>

    {{-- STATS --}}
    @php
        $totalSetoran = $transaksis->count();
        $totalBerat = 0;
        foreach ($transaksis as $t) $totalBerat += (float) ($t->berat_aktual ?? $t->berat ?? 0);
    @endphp

    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-bottom:20px;">

        <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; padding:18px; text-align:center; position:relative; overflow:hidden;">
            <div style="position:absolute; top:0; left:0; width:4px; height:100%; background:#3b82f6;"></div>
            <p style="font-size:28px; font-weight:800; color:#1f2937; margin:0; line-height:1.2;">{{ $totalSetoran }}</p>
            <p style="font-size:12px; color:#6b7280; margin:4px 0 0 0; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">Total Setoran</p>
        </div>

        <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; padding:18px; text-align:center; position:relative; overflow:hidden;">
            <div style="position:absolute; top:0; left:0; width:4px; height:100%; background:#eab308;"></div>
            <p style="font-size:28px; font-weight:800; color:#1f2937; margin:0; line-height:1.2;">{{ number_format($totalBerat, 1) }} <span style="font-size:16px;">kg</span></p>
            <p style="font-size:12px; color:#6b7280; margin:4px 0 0 0; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">Total Berat</p>
        </div>

        <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; padding:18px; text-align:center; position:relative; overflow:hidden;">
            <div style="position:absolute; top:0; left:0; width:4px; height:100%; background:#16a34a;"></div>
            <p style="font-size:28px; font-weight:800; color:#16a34a; margin:0; line-height:1.2;">{{ number_format($pelanggan->poin ?? 0) }}</p>
            <p style="font-size:12px; color:#6b7280; margin:4px 0 0 0; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">Poin</p>
        </div>

    </div>

    {{-- HISTORY --}}
    <div style="background:#fff; border-radius:8px; border:2px solid #e5e7eb; overflow:hidden;">

        <div style="padding:12px 20px; background:#f9fafb; border-bottom:2px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <svg style="width:18px; height:18px; color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <h3 style="font-size:13px; font-weight:700; color:#1f2937; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Riwayat Setoran</h3>
            </div>
            <span style="font-size:11px; font-weight:600; color:#6b7280; background:#e5e7eb; padding:4px 10px; border-radius:6px;">
                {{ $transaksis->count() }} transaksi
            </span>
        </div>

        @if($transaksis->count())
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13px; min-width:900px;">
                    <thead>
                        <tr style="background:#f9fafb;">
                            <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">ID</th>
                            <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Tanggal</th>
                            <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Jenis Sampah</th>
                            <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Berat</th>
                            <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Metode</th>
                            <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb;">Status</th>
                            <th style="padding:12px 16px; text-align:left; font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e5e7eb; min-width:240px;">Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $transaksi)
                            @php
                                $berat = (float) ($transaksi->berat ?? 0);
                                $jenis = 'Sampah';
                                if (isset($transaksi->jenisSampahs) && $transaksi->jenisSampahs->count()) {
                                    $jenis = $transaksi->jenisSampahs->pluck('nama')->filter()->implode(', ') ?: 'Sampah';
                                }

                                $statusMap = [
                                    'pending'   => ['label' => 'Menunggu', 'bg' => '#fef3c7', 'color' => '#92400e'],
                                    'approved'  => ['label' => 'Disetujui', 'bg' => '#dbeafe', 'color' => '#1d4ed8'],
                                    'completed' => ['label' => 'Selesai',   'bg' => '#dcfce7', 'color' => '#15803d'],
                                    'selesai'   => ['label' => 'Selesai',   'bg' => '#dcfce7', 'color' => '#15803d'],
                                    'rejected'  => ['label' => 'Ditolak',   'bg' => '#fee2e2', 'color' => '#b91c1c'],
                                    'ditolak'   => ['label' => 'Ditolak',   'bg' => '#fee2e2', 'color' => '#b91c1c'],
                                ];
                                $st = $statusMap[$transaksi->status] ?? ['label' => ucfirst($transaksi->status), 'bg' => '#f1f5f9', 'color' => '#475569'];
                            @endphp
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td style="padding:12px 16px;">
                                    <span style="display:inline-block; padding:3px 10px; background:#e5e7eb; border-radius:12px; font-weight:700; font-size:12px; color:#334155;">
                                        #{{ $transaksi->id }}
                                    </span>
                                </td>
                                <td style="padding:12px 16px; color:#4b5563;">
                                    {{ $transaksi->created_at ? $transaksi->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td style="padding:12px 16px; color:#1f2937; font-weight:500;">{{ $jenis }}</td>
                                <td style="padding:12px 16px;">
                                    <strong style="color:#16a34a;">{{ number_format($berat, 1) }}</strong>
                                    <span style="color:#6b7280;">kg</span>
                                </td>
                                <td style="padding:12px 16px; color:#4b5563; text-transform:capitalize;">{{ $transaksi->metode ?? '-' }}</td>
                                <td style="padding:12px 16px;">
                                    <span style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; background:{{ $st['bg'] }}; color:{{ $st['color'] }};">
                                        {{ $st['label'] }}
                                    </span>
                                </td>
                                <td style="padding:12px 16px;">
                                    @if(in_array($transaksi->status, ['pending', 'menunggu']))
                                        <div style="display:flex; align-items:center; gap:6px; flex-wrap:nowrap;">
                                            {{-- Form Approve --}}
                                            <form action="{{ route('admin.transaksi.approve', $transaksi->id) }}"
                                                  method="POST"
                                                  style="display:inline-flex; align-items:center; gap:4px;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number"
                                                       name="berat_akhir"
                                                       step="0.01"
                                                       min="0.01"
                                                       max="9999"
                                                       value="{{ number_format($berat, 2, '.', '') }}"
                                                       style="width:70px; padding:4px 8px; font-size:12px; border:2px solid #d1d5db; border-radius:6px; height:30px; box-sizing:border-box;"
                                                       required>
                                                <button type="submit"
                                                        onclick="return confirm('Setujui transaksi ini?')"
                                                        style="padding:5px 12px; font-size:11px; font-weight:700; background:#16a34a; color:#fff; border:none; border-radius:6px; cursor:pointer; height:30px; display:inline-flex; align-items:center; gap:4px;">
                                                    <svg style="width:12px; height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Setujui
                                                </button>
                                            </form>

                                            {{-- Form Reject --}}
                                            <form action="{{ route('admin.transaksi.reject', $transaksi->id) }}"
                                                  method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        onclick="return confirm('Yakin ingin menolak transaksi ini?')"
                                                        style="padding:5px 12px; font-size:11px; font-weight:700; background:#dc2626; color:#fff; border:none; border-radius:6px; cursor:pointer; height:30px; display:inline-flex; align-items:center; gap:4px;">
                                                    <svg style="width:12px; height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span style="display:inline-flex; align-items:center; gap:6px; padding:5px 14px; background:#f1f5f9; color:#64748b; border-radius:20px; font-size:12px; font-weight:600; height:30px; box-sizing:border-box;">
                                            <svg style="width:12px; height:12px; color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Telah diproses
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="padding:60px 20px; text-align:center;">
                <svg style="width:56px; height:56px; margin:0 auto 12px; color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p style="font-size:15px; font-weight:600; color:#6b7280; margin:0;">Belum ada setoran</p>
                <p style="font-size:13px; color:#9ca3af; margin:4px 0 0 0;">Riwayat setoran pelanggan akan muncul di sini</p>
            </div>
        @endif

    </div>

</div>
@endsection