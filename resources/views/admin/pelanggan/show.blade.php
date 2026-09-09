@extends('layouts.admin')

@section('title', 'Detail Pelanggan')

@section('content')

<style>
    .detail-page {
        padding: 20px 24px 40px;
        background: #f4f6f9;
        min-height: calc(100vh - 70px);
    }
    .detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h1 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .page-header .sub {
        color: #64748b;
        font-size: 0.85rem;
    }
    .btn-back {
        background: #fff;
        border: 1px solid #d1d9e0;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.8rem;
        color: #1e293b;
        text-decoration: none;
        transition: 0.15s;
    }
    .btn-back:hover {
        background: #f1f5f9;
        border-color: #b0c0cd;
    }

    /* Alert */
    .alert {
        padding: 10px 16px;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 0.85rem;
        border: 1px solid transparent;
    }
    .alert-success {
        background: #dcfce7;
        border-color: #bbf7d0;
        color: #166534;
    }
    .alert-danger {
        background: #fee2e2;
        border-color: #fecaca;
        color: #991b1b;
    }

    /* Profile card */
    .profile-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
        overflow: hidden;
    }
    .profile-card .card-header {
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
        color: #0f172a;
    }
    .profile-card .card-body {
        padding: 16px 18px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
    }
    .profile-card .info-item {
        font-size: 0.8rem;
    }
    .profile-card .info-item .label {
        display: block;
        font-size: 0.65rem;
        text-transform: uppercase;
        color: #94a3b8;
        font-weight: 600;
        letter-spacing: 0.03em;
    }
    .profile-card .info-item .value {
        font-weight: 500;
        color: #0f172a;
        word-break: break-word;
    }
    .profile-card .info-item .value.muted {
        color: #94a3b8;
        font-weight: 400;
    }

    /* Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }
    .stat-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 14px 18px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        text-align: center;
    }
    .stat-box .number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .stat-box .label {
        font-size: 0.7rem;
        color: #64748b;
        display: block;
        margin-top: 2px;
    }

    /* History table */
    .history-card {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .history-card .card-header {
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .history-card .card-header h3 {
        font-size: 0.95rem;
        font-weight: 600;
        margin: 0;
        color: #0f172a;
    }
    .history-card .card-header span {
        font-size: 0.75rem;
        background: #e2e8f0;
        padding: 2px 10px;
        border-radius: 20px;
        color: #475569;
    }
    .table-wrap {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8rem;
    }
    thead th {
        padding: 10px 14px;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #475569;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }
    tbody td {
        padding: 10px 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    tbody tr:last-child td {
        border-bottom: none;
    }
    tbody tr:hover {
        background: #f8fafc;
    }

    .id-badge {
        display: inline-block;
        padding: 2px 8px;
        background: #e2e8f0;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.7rem;
        color: #334155;
    }

    /* Status */
    .status {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .status.pending { background: #f1f5f9; color: #475569; }
    .status.approved { background: #dbeafe; color: #1d4ed8; }
    .status.completed { background: #dcfce7; color: #15803d; }
    .status.rejected { background: #fee2e2; color: #b91c1c; }

    /* ===== KOLOM APPROVAL - RAPI & SIMETRIS ===== */
    .approval-cell {
        min-width: 240px;
        max-width: 240px;
    }
    .approval-wrapper {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
        min-height: 32px;  /* biar semua baris sama tingginya */
    }
    .weight-input {
        width: 70px;
        padding: 3px 6px;
        font-size: 0.7rem;
        border: 1px solid #d1d9e0;
        border-radius: 4px;
        height: 28px;
        flex-shrink: 0;
    }
    .btn-approve, .btn-reject {
        padding: 4px 10px;
        font-size: 0.65rem;
        font-weight: 600;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        height: 28px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-approve {
        background: #16a34a;
        color: #fff;
    }
    .btn-approve:hover {
        background: #15803d;
    }
    .btn-reject {
        background: #dc2626;
        color: #fff;
    }
    .btn-reject:hover {
        background: #b91c1c;
    }

    /* Badge untuk yang sudah diproses — ditempatkan di wrapper agar sejajar */
    .badge-processed {
        font-size: 0.7rem;
        color: #64748b;
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
        white-space: nowrap;
        height: 28px;
        line-height: 28px;
        padding: 0 14px;
        box-sizing: border-box;
    }

    /* placeholder kosong untuk menjaga simetri (tidak digunakan, tapi biar aman) */
    .empty-placeholder {
        display: inline-block;
        width: 100%;
        height: 28px;
    }

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #94a3b8;
    }
    .empty-state i {
        font-size: 2rem;
        display: block;
        margin-bottom: 8px;
    }

    @media (max-width: 768px) {
        .detail-page { padding: 12px; }
        .stats-row { grid-template-columns: 1fr; }
        .profile-card .card-body { grid-template-columns: 1fr; }
        .approval-cell { min-width: 160px; max-width: none; }
        .approval-wrapper { flex-wrap: wrap; gap: 4px; }
        .weight-input { width: 100%; }
        .btn-approve, .btn-reject { flex: 1; justify-content: center; }
    }
</style>

<div class="detail-page">

    <div class="detail-container">

        {{-- HEADER --}}
        <div class="page-header">
            <div>
                <h1>Detail Pelanggan</h1>
                <div class="sub">Informasi dan riwayat setoran</div>
            </div>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn-back">← Kembali</a>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- PROFILE --}}
        <div class="profile-card">
            <div class="card-header"><i class="fas fa-user-circle"></i> Informasi Pelanggan</div>
            <div class="card-body">
                <div class="info-item">
                    <span class="label">Nama</span>
                    <span class="value">{{ $pelanggan->nama ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">No HP</span>
                    <span class="value">{{ $pelanggan->no_hp ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Email</span>
                    <span class="value">{{ $pelanggan->email ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Bergabung</span>
                    <span class="value">{{ $pelanggan->created_at ? $pelanggan->created_at->format('d M Y') : '-' }}</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="label">Alamat</span>
                    <span class="value {{ empty($pelanggan->alamat) ? 'muted' : '' }}">{{ $pelanggan->alamat ?: 'Alamat belum diisi' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Poin</span>
                    <span class="value">{{ number_format($pelanggan->poin ?? 0) }}</span>
                </div>
                <div class="info-item">
                    <span class="label">ID Pelanggan</span>
                    <span class="value">#{{ $pelanggan->id }}</span>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        @php
            $totalSetoran = $transaksis->count();
            $totalBerat = 0;
            foreach ($transaksis as $t) $totalBerat += (float) ($t->berat ?? 0);
        @endphp
        <div class="stats-row">
            <div class="stat-box">
                <div class="number">{{ $totalSetoran }}</div>
                <span class="label">Total Setoran</span>
            </div>
            <div class="stat-box">
                <div class="number">{{ number_format($totalBerat, 1) }} kg</div>
                <span class="label">Total Berat</span>
            </div>
            <div class="stat-box">
                <div class="number">{{ number_format($pelanggan->poin ?? 0) }}</div>
                <span class="label">Poin</span>
            </div>
        </div>

        {{-- HISTORY --}}
        <div class="history-card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Riwayat Setoran</h3>
                <span>{{ $transaksis->count() }} transaksi</span>
            </div>

            @if($transaksis->count())
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Jenis Sampah</th>
                                <th>Berat</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th class="approval-cell">Approval</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $transaksi)
                                @php
                                    $berat = (float) ($transaksi->berat ?? 0);
                                    $jenis = isset($transaksi->jenisSampahs)
                                        ? $transaksi->jenisSampahs->pluck('nama')->filter()->implode(', ')
                                        : 'Sampah';
                                    $jenis = $jenis ?: 'Sampah';

                                    $statusMap = [
                                        'pending'    => ['label' => 'Menunggu', 'class' => 'pending'],
                                        'approved'   => ['label' => 'Disetujui', 'class' => 'approved'],
                                        'completed'  => ['label' => 'Selesai',   'class' => 'completed'],
                                        'rejected'   => ['label' => 'Ditolak',   'class' => 'rejected'],
                                    ];
                                    $st = $statusMap[$transaksi->status] ?? ['label' => ucfirst($transaksi->status), 'class' => 'pending'];
                                @endphp
                                <tr>
                                    <td><span class="id-badge">#{{ $transaksi->id }}</span></td>
                                    <td>{{ $transaksi->created_at ? $transaksi->created_at->format('d M Y, H:i') : '-' }}</td>
                                    <td>{{ $jenis }}</td>
                                    <td><strong>{{ number_format($berat, 1) }}</strong> kg</td>
                                    <td>{{ ucfirst($transaksi->metode ?? '-') }}</td>
                                    <td><span class="status {{ $st['class'] }}">{{ $st['label'] }}</span></td>
                                    <td class="approval-cell">
                                        <div class="approval-wrapper">
                                            @if($transaksi->status === 'pending')
                                                {{-- FORM APPROVE --}}
                                                <form action="{{ route('admin.transaksi.approve', $transaksi->id) }}"
                                                      method="POST"
                                                      style="display:inline-flex; align-items:center; gap:4px; flex-wrap:nowrap;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number"
                                                           name="berat_akhir"
                                                           step="0.01"
                                                           value="{{ number_format($berat, 2) }}"
                                                           class="weight-input"
                                                           required>
                                                    <button type="submit" class="btn-approve">
                                                        <i class="fas fa-check"></i> Setujui
                                                    </button>
                                                </form>

                                                {{-- FORM REJECT --}}
                                                <form action="{{ route('admin.transaksi.reject', $transaksi->id) }}"
                                                      method="POST"
                                                      style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn-reject"
                                                            onclick="return confirm('Yakin ingin menolak transaksi ini?')">
                                                        <i class="fas fa-times"></i> Tolak
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Untuk status selain pending, tampilkan badge dengan tinggi sama --}}
                                                <span class="badge-processed">
                                                    <i class="fas fa-check-circle" style="color:#16a34a;"></i> Telah diproses
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada setoran</p>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection