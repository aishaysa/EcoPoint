@extends('layouts.user')

@section('title', 'Setoran Saya')
@section('page_title', 'Setoran Saya')

@section('content')

<style>
    /* ===============================
       GLOBAL
    ================================ */
    .setoran-page {
        background: #f8fafc;
        min-height: 100vh;
    }

    .setoran-page svg {
        width: 18px !important;
        height: 18px !important;
        max-width: 18px !important;
        max-height: 18px !important;
    }

    /* ===============================
       CONTAINER
    ================================ */
    .setoran-container {
        max-width: 1180px;
        margin: 0 auto;
        padding: 30px 24px 45px;
    }

    /* ===============================
       HEADER
    ================================ */
    .setoran-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 20px;
    }

    .setoran-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .title-icon {
        width: 48px !important;
        height: 48px !important;
        max-width: 48px !important;
        max-height: 48px !important;
        color: #059669;
    }

    .setoran-title h1 {
        margin: 0;
        color: #0f172a;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.03em;
    }

    .setoran-title p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .btn-setor {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #0d9488;
        color: #fff !important;
        text-decoration: none !important;
        padding: 11px 20px;
        border-radius: 11px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: .2s ease;
        box-shadow: 0 4px 12px rgba(13, 148, 136, .18);
        white-space: nowrap;
    }

    .btn-setor:hover {
        background: #0f766e;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(13, 148, 136, .25);
    }

    /* ===============================
       STATISTICS
    ================================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 34px;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        border-radius: 17px;
        padding: 23px 25px;
        min-height: 128px;
        border: 1px solid transparent;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-card.green {
        background: #e2f2ef;
        border-color: #d6ebe7;
    }

    .stat-card.blue {
        background: #e3edff;
        border-color: #d8e5fc;
    }

    .stat-card.yellow {
        background: #fff8df;
        border-color: #f7edc6;
    }

    .stat-icon {
        width: 52px !important;
        height: 52px !important;
        max-width: 52px !important;
        max-height: 52px !important;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: rgba(255,255,255,.55);
    }

    .green .stat-icon {
        color: #059669;
    }

    .blue .stat-icon {
        color: #2563eb;
    }

    .yellow .stat-icon {
        color: #eab308;
    }

    .stat-icon svg {
        width: 25px !important;
        height: 25px !important;
        max-width: 25px !important;
        max-height: 25px !important;
    }

    .stat-text {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        color: #0f172a;
        letter-spacing: -0.04em;
    }

    .green .stat-value {
        color: #12945f;
    }

    .blue .stat-value {
        color: #1769e0;
    }

    .yellow .stat-value {
        color: #f3ad00;
    }

    .stat-label {
        color: #64748b;
        font-size: 0.88rem;
        font-weight: 500;
    }

    /* ===============================
       TRANSACTION GRID
    ================================ */
    .transaction-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }

    /* ===============================
       TRANSACTION CARD
    ================================ */
    .transaction-card {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 340px;
        box-shadow: 0 2px 7px rgba(15, 23, 42, .04);
        transition: .22s ease;
    }

    .transaction-card:hover {
        transform: translateY(-4px);
        border-color: #d7e4df;
        box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
    }

    /* ===============================
       CARD TOP
    ================================ */
    .transaction-top {
        padding: 18px 20px 16px;
        border-bottom: 1px solid #eef2f5;
    }

    .transaction-meta {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .transaction-date {
        color: #475569;
        font-size: .79rem;
        font-weight: 600;
        line-height: 1.4;
    }

    .weight-badge {
        background: #178b58;
        color: #fff;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: .72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .transaction-name {
        margin: 10px 0 0;
        color: #111827;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.4;
    }

    /* ===============================
       CARD BODY
    ================================ */
    .transaction-body {
        padding: 17px 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .detail-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .detail-row {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
    }

    .detail-row .icon {
        width: 18px !important;
        height: 18px !important;
        max-width: 18px !important;
        max-height: 18px !important;
        flex-shrink: 0;
        color: #149b63;
    }

    .detail-text {
        color: #64748b;
        font-size: .83rem;
        line-height: 1.4;
        min-width: 0;
    }

    .detail-text strong {
        color: #334155;
        font-weight: 600;
    }

    .address-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* ===============================
       STATUS
    ================================ */
    .status-badge {
        display: inline-flex;
        align-items: center;
        width: fit-content;
        margin-top: 14px;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: .7rem;
        font-weight: 700;
        line-height: 1;
    }

    .status-pending {
        background: #e5e7eb;
        color: #6b7280;
    }

    .status-approved {
        background: #dbeafe;
        color: #2563eb;
    }

    .status-completed {
        background: #dcfce7;
        color: #15803d;
    }

    .status-rejected {
        background: #fee2e2;
        color: #dc2626;
    }

    /* ===============================
       POINT
    ================================ */
    .point-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 10px;
        color: #047857;
        background: #ecfdf5;
        border: 1px solid #d1fae5;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: .7rem;
        font-weight: 700;
        width: fit-content;
    }

    .point-badge svg {
        width: 14px !important;
        height: 14px !important;
        max-width: 14px !important;
        max-height: 14px !important;
    }

    /* ===============================
       CARD FOOTER
    ================================ */
    .transaction-footer {
        border-top: 1px solid #e8edf2;
        min-height: 39px;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .transaction-id {
        color: #64748b;
        font-size: .76rem;
    }

    .transaction-detail {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #078b58 !important;
        text-decoration: none !important;
        font-size: .8rem;
        font-weight: 700;
        transition: .2s ease;
    }

    .transaction-detail:hover {
        color: #056c45 !important;
        gap: 8px;
    }

    .transaction-detail svg {
        width: 16px !important;
        height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
    }

    /* ===============================
       EMPTY
    ================================ */
    .empty-state {
        background: #fff;
        border: 1px solid #e8edf2;
        border-radius: 16px;
        padding: 55px 20px;
        text-align: center;
        box-shadow: 0 2px 7px rgba(15, 23, 42, .03);
    }

    .empty-icon {
        width: 66px;
        height: 66px;
        margin: 0 auto 15px;
        border-radius: 18px;
        background: #ecfdf5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon svg {
        width: 30px !important;
        height: 30px !important;
        max-width: 30px !important;
        max-height: 30px !important;
    }

    .empty-title {
        margin: 0;
        color: #1e293b;
        font-size: 1rem;
        font-weight: 700;
    }

    .empty-text {
        margin: 6px 0 16px;
        color: #94a3b8;
        font-size: .86rem;
    }

    .empty-link {
        color: #059669;
        text-decoration: none;
        font-size: .85rem;
        font-weight: 700;
    }

    .empty-link:hover {
        text-decoration: underline;
    }

    /* ===============================
       PAGINATION
    ================================ */
    .pagination-wrapper {
        margin-top: 28px;
        display: flex;
        justify-content: center;
    }

    /* ===============================
       RESPONSIVE
    ================================ */
    @media (max-width: 1024px) {
        .transaction-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .setoran-container {
            padding: 22px 16px 35px;
        }

        .setoran-header {
            align-items: flex-start;
        }

        .setoran-title h1 {
            font-size: 1.6rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .transaction-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 520px) {
        .setoran-header {
            flex-direction: column;
        }

        .btn-setor {
            width: 100%;
        }

        .setoran-title {
            gap: 10px;
        }

        .title-icon {
            width: 40px !important;
            height: 40px !important;
            max-width: 40px !important;
            max-height: 40px !important;
        }

        .setoran-title h1 {
            font-size: 1.4rem;
        }

        .stat-card {
            padding: 19px;
        }
    }
</style>


<div class="setoran-page">
    <div class="setoran-container">

        {{-- ================= HEADER ================= --}}
        <div class="setoran-header">

            <div class="setoran-title">
                <svg class="title-icon"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M7 20h10a2 2 0 002-2V8l-5-5H7a2 2 0 00-2 2v13a2 2 0 002 2z"/>
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M14 3v5h5"/>
                </svg>

                <div>
                    <h1>Setoran Saya</h1>
                    <p>Riwayat setoran sampah Anda di EcoPoint</p>
                </div>
            </div>

            <a href="{{ route('user.transaksi.create') }}" class="btn-setor">
                <svg fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2.5"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Setor Baru
            </a>

        </div>


        {{-- ================= STATISTIK ================= --}}
        <div class="stats-grid">

            {{-- TOTAL SETORAN --}}
            <div class="stat-card green">
                <div class="stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1a2 2 0 01-2 2M5 8v11a2 2 0 002 2h10a2 2 0 002-2V8"/>
                    </svg>
                </div>
                <div class="stat-text">
                    <span class="stat-value">{{ $totalSetoran ?? 0 }}</span>
                    <span class="stat-label">Total Setoran</span>
                </div>
            </div>

            {{-- TOTAL BERAT --}}
            <div class="stat-card blue">
                <div class="stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5 5 0 006 0M6 7l3 9m0-9l6-2m6 2l3-1m-3 1l-3 9a5 5 0 006 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                    </svg>
                </div>
                <div class="stat-text">
                    <span class="stat-value">{{ number_format($totalBerat ?? 0, 1) }} kg</span>
                    <span class="stat-label">Total Berat Sampah</span>
                </div>
            </div>

            {{-- TOTAL POIN --}}
            <div class="stat-card yellow">
                <div class="stat-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18m0-18c-2.2 0-4 1.34-4 3s1.8 3 4 3 4 1.34 4 3-1.8 3-4 3-4-1.34-4-3m4-9c2.2 0 4 1.34 4 3"/>
                    </svg>
                </div>
                <div class="stat-text">
                    <span class="stat-value">{{ number_format($totalPoin ?? 0) }}</span>
                    <span class="stat-label">Poin Anda</span>
                </div>
            </div>

        </div>


        {{-- ================= DAFTAR TRANSAKSI ================= --}}
        @if($transaksis->isEmpty())

            <div class="empty-state">
                <div class="empty-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <p class="empty-title">Belum ada setoran</p>
                <p class="empty-text">Anda belum memiliki riwayat setoran sampah.</p>
                <a href="{{ route('user.transaksi.create') }}" class="empty-link">Mulai setor sekarang →</a>
            </div>

        @else

            <div class="transaction-grid">

                @foreach($transaksis as $t)

                    @php
                        // =============================================
                        // STATUS MAP (BAHASA INDONESIA + INGGRIS)
                        // =============================================
                        $statusMap = [
                            'pending'   => ['label' => 'Menunggu',   'class' => 'status-pending'],
                            'approved'  => ['label' => 'Disetujui',  'class' => 'status-approved'],
                            'disetujui' => ['label' => 'Disetujui',  'class' => 'status-approved'],
                            'completed' => ['label' => 'Selesai',    'class' => 'status-completed'],
                            'rejected'  => ['label' => 'Ditolak',    'class' => 'status-rejected'],
                            'ditolak'   => ['label' => 'Ditolak',    'class' => 'status-rejected'],
                        ];
                        $status = $statusMap[$t->status ?? 'pending'] ?? $statusMap['pending'];

                        // =============================================
                        // TOTAL BERAT (dari relasi)
                        // =============================================
                        $totalBerat = $t->jenisSampahs->sum(function ($sampah) {
                            return (float) ($sampah->pivot->berat ?? 0);
                        });
                        if ($totalBerat == 0) {
                            $totalBerat = $t->berat ?? 0;
                        }

                        // =============================================
                        // NAMA SAMPAH
                        // =============================================
                        $namaSampah = $t->jenisSampahs->pluck('nama')->filter()->implode(', ');
                        if (empty($namaSampah) && $t->jenisSampah) {
                            $namaSampah = $t->jenisSampah->nama;
                        }
                        $namaSampah = $namaSampah ?: 'Sampah';

                        // =============================================
                        // JUMLAH JENIS
                        // =============================================
                        $jumlahJenis = $t->jenisSampahs->count();

                        // =============================================
                        // POIN
                        // =============================================
                        $poin = $t->poin_didapat ?? 0;
                        if ($poin == 0 && $t->status === 'completed') {
                            $poin = floor($totalBerat * 10);
                        }

                        // =============================================
                        // KONTAK (dari transaksi atau pelanggan)
                        // =============================================
                        $kontak = $t->no_hp ?? $t->pelanggan->no_hp ?? '-';

                        // =============================================
                        // ALAMAT JEMPUT (jika ada)
                        // =============================================
                        $alamat = $t->alamat_jemput ?? $t->alamat ?? null;
                    @endphp

                    <div class="transaction-card">

                        {{-- TOP --}}
                        <div class="transaction-top">
                            <div class="transaction-meta">
                                <div class="transaction-date">
                                    {{ $t->created_at->translatedFormat('d M Y, H:i') }}
                                </div>
                                <span class="weight-badge">
                                    {{ number_format($totalBerat, 1) }} kg
                                </span>
                            </div>
                            <div class="transaction-name">{{ $namaSampah }}</div>
                        </div>

                        {{-- BODY --}}
                        <div class="transaction-body">
                            <div class="detail-list">

                                {{-- Berat --}}
                                <div class="detail-row">
                                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 2h12l2 5H4l2-5zm-2 5h16l-2 15H6L4 7z"/>
                                    </svg>
                                    <div class="detail-text">
                                        <strong>Berat</strong> {{ number_format($totalBerat, 2) }} kg
                                    </div>
                                </div>

                                {{-- Kontak --}}
                                <div class="detail-row">
                                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <div class="detail-text">
                                        <strong>Kontak</strong> {{ $kontak }}
                                    </div>
                                </div>

                                {{-- Alamat --}}
                                @if($alamat)
                                <div class="detail-row">
                                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 21a2 2 0 01-2.828 0l-4.243-4.343a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <div class="detail-text address-text" title="{{ $alamat }}">
                                        <strong>Alamat</strong> {{ $alamat }}
                                    </div>
                                </div>
                                @endif

                                {{-- Jumlah jenis --}}
                                <div class="detail-row">
                                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                    <div class="detail-text">
                                        {{ $jumlahJenis }} jenis sampah
                                    </div>
                                </div>

                            </div>

                            {{-- Status --}}
                            <span class="status-badge {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>

                            {{-- Poin --}}
                            @if($poin > 0)
                                <div class="point-badge">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13a4 4 0 100-8 4 4 0 000 8z"/>
                                    </svg>
                                    +{{ number_format($poin) }} poin
                                </div>
                            @endif

                        </div>

                        {{-- FOOTER --}}
                        <div class="transaction-footer">
                            <span class="transaction-id">ID: #{{ $t->id }}</span>
                            <a href="{{ route('user.transaksi.detail', $t->id) }}" class="transaction-detail">
                                Detail
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                    </div>

                @endforeach

            </div>

            {{-- Pagination --}}
            @if($transaksis->hasPages())
                <div class="pagination-wrapper">
                    {{ $transaksis->links() }}
                </div>
            @endif

        @endif

    </div>
</div>

{{-- Toast Notification --}}
@if(session('success'))
<div id="toast" class="fixed top-6 right-6 z-50 max-w-sm w-full transform transition-all duration-700 ease-out translate-x-0 opacity-100">
    <div class="bg-white rounded-2xl shadow-2xl border border-green-100 overflow-hidden relative">
        <div id="toastProgress" class="h-1 bg-gradient-to-r from-green-400 to-green-600 transition-all duration-[4000ms] ease-linear" style="width: 100%"></div>
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
            <button onclick="closeToast()" class="flex-shrink-0 mt-1 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
<script>
    let progressWidth = 100;
    const progressInterval = setInterval(function() {
        progressWidth -= 0.25;
        const progressBar = document.getElementById('toastProgress');
        if (progressBar) progressBar.style.width = Math.max(progressWidth, 0) + '%';
        if (progressWidth <= 0) {
            clearInterval(progressInterval);
            closeToast();
        }
    }, 10);
    function closeToast() {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 700);
        }
        clearInterval(progressInterval);
    }
</script>
@endif

@endsection