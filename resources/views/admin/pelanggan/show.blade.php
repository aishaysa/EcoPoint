@extends('layouts.admin')

@section('title', 'Detail Pelanggan')

@section('content')

<style>
    .detail-page {
        width: 100%;
        padding: 28px 30px 45px;
        background: #f7f9fc;
        min-height: calc(100vh - 70px);
    }
    .detail-container {
        max-width: 1100px;
        margin: 0 auto;
    }
    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 22px;
    }
    .detail-title {
        margin: 0;
        font-size: 1.65rem;
        font-weight: 700;
        color: #172033;
        letter-spacing: -.02em;
    }
    .detail-subtitle {
        margin: 5px 0 0;
        color: #718096;
        font-size: .82rem;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 14px;
        border-radius: 9px;
        border: 1px solid #dfe5eb;
        background: #fff;
        color: #475467;
        text-decoration: none;
        font-size: .78rem;
        font-weight: 600;
        transition: .2s;
    }
    .btn-back:hover {
        color: #059669;
        border-color: #a9dbc5;
        background: #f8fffb;
    }
    .profile-card {
        background: #fff;
        border: 1px solid #e6ebef;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(15,23,42,.04);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .profile-card-header {
        padding: 17px 20px;
        border-bottom: 1px solid #edf1f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }
    .profile-heading {
        display: flex;
        align-items: center;
        gap: 11px;
    }
    .profile-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #e8f7f0;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .profile-heading h2 {
        margin: 0;
        font-size: .95rem;
        font-weight: 700;
        color: #1f2937;
    }
    .profile-heading p {
        margin: 2px 0 0;
        font-size: .7rem;
        color: #98a2b3;
    }
    .profile-card-body {
        padding: 22px 20px;
    }
    .profile-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px;
    }
    .info-card {
        border: 1px solid #edf1f4;
        border-radius: 11px;
        background: #fbfcfd;
        padding: 14px;
    }
    .info-label {
        display: block;
        margin-bottom: 5px;
        color: #98a2b3;
        font-size: .67rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .03em;
    }
    .info-value {
        color: #263343;
        font-size: .82rem;
        font-weight: 600;
        word-break: break-word;
    }
    .info-value.muted {
        color: #98a2b3;
        font-weight: 500;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 17px;
        margin-bottom: 22px;
    }
    .stat-card {
        background: #fff;
        border: 1px solid #e6ebef;
        border-radius: 14px;
        padding: 17px 19px;
        display: flex;
        align-items: center;
        gap: 13px;
        box-shadow: 0 3px 12px rgba(15,23,42,.035);
    }
    .stat-icon {
        width: 43px;
        height: 43px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 17px;
    }
    .stat-green .stat-icon {
        background: #e8f8f1;
        color: #059669;
    }
    .stat-blue .stat-icon {
        background: #eaf1ff;
        color: #2563eb;
    }
    .stat-yellow .stat-icon {
        background: #fff8df;
        color: #d89b00;
    }
    .stat-number {
        display: block;
        color: #1f2937;
        font-size: 1.3rem;
        line-height: 1.1;
        font-weight: 800;
    }
    .stat-label {
        display: block;
        margin-top: 3px;
        color: #7b8798;
        font-size: .7rem;
    }
    .history-card {
        background: #fff;
        border: 1px solid #e6ebef;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(15,23,42,.04);
        overflow: hidden;
    }
    .history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 17px 20px;
        border-bottom: 1px solid #edf1f4;
    }
    .history-header h2 {
        margin: 0;
        color: #1f2937;
        font-size: .95rem;
        font-weight: 700;
    }
    .history-header span {
        color: #98a2b3;
        font-size: .7rem;
    }
    .table-wrap {
        overflow-x: auto;
    }
    .history-table {
        width: 100%;
        border-collapse: collapse;
    }
    .history-table thead th {
        padding: 11px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e8edf1;
        color: #718096;
        font-size: .66rem;
        font-weight: 700;
        text-align: left;
        white-space: nowrap;
    }
    .history-table tbody td {
        padding: 13px 18px;
        border-bottom: 1px solid #edf1f4;
        color: #475467;
        font-size: .74rem;
        vertical-align: middle;
    }
    .history-table tbody tr:last-child td {
        border-bottom: 0;
    }
    .history-table tbody tr:hover {
        background: #fbfdfc;
    }
    .id-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 7px;
        background: #f1f5f9;
        color: #475467;
        font-size: .67rem;
        font-weight: 700;
    }
    .status {
        display: inline-flex;
        align-items: center;
        padding: 4px 9px;
        border-radius: 7px;
        font-size: .64rem;
        font-weight: 700;
    }
    .status.pending {
        background: #f1f3f5;
        color: #667085;
    }
    .status.approved {
        background: #e7f0ff;
        color: #2563eb;
    }
    .status.completed {
        background: #dcfce7;
        color: #15803d;
    }
    .status.rejected {
        background: #fee2e2;
        color: #dc2626;
    }
    .empty-state {
        padding: 45px 20px;
        text-align: center;
    }
    .empty-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 12px;
        border-radius: 13px;
        background: #f2f4f7;
        color: #98a2b3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }
    .empty-state h3 {
        margin: 0;
        color: #344054;
        font-size: .88rem;
    }
    .empty-state p {
        margin: 5px 0 0;
        color: #98a2b3;
        font-size: .7rem;
    }
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        font-size: .82rem;
    }
    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    @media (max-width: 900px) {
        .profile-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 700px) {
        .detail-page {
            padding: 20px 14px 35px;
        }
        .detail-header {
            align-items: flex-start;
            flex-direction: column;
        }
        .btn-back {
            width: 100%;
            justify-content: center;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 520px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="detail-page">

    <div class="detail-container">

        {{-- HEADER --}}
        <div class="detail-header">
            <div>
                <h1 class="detail-title">Detail Pelanggan</h1>
                <p class="detail-subtitle">Informasi pelanggan dan riwayat aktivitas setoran</p>
            </div>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn-back">← Kembali</a>
        </div>

        {{-- ALERT MESSAGES --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- PROFILE --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="profile-heading">
                    <div class="profile-icon"><i class="fas fa-user"></i></div>
                    <div>
                        <h2>Informasi Pelanggan</h2>
                        <p>Data pelanggan EcoPoint</p>
                    </div>
                </div>
            </div>
            <div class="profile-card-body">
                <div class="profile-grid">
                    <div class="info-card">
                        <span class="info-label">Nama</span>
                        <div class="info-value">{{ $pelanggan->nama ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <span class="info-label">No HP</span>
                        <div class="info-value">{{ $pelanggan->no_hp ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <span class="info-label">Email</span>
                        <div class="info-value">{{ $pelanggan->email ?? '-' }}</div>
                    </div>
                    <div class="info-card">
                        <span class="info-label">Bergabung</span>
                        <div class="info-value">
                            {{ $pelanggan->created_at ? $pelanggan->created_at->format('d M Y') : '-' }}
                        </div>
                    </div>
                    <div class="info-card" style="grid-column: span 2;">
                        <span class="info-label">Alamat</span>
                        <div class="info-value {{ empty($pelanggan->alamat) ? 'muted' : '' }}">
                            {{ $pelanggan->alamat ?: 'Alamat belum diisi' }}
                        </div>
                    </div>
                    <div class="info-card">
                        <span class="info-label">Poin</span>
                        <div class="info-value">{{ number_format($pelanggan->poin ?? 0) }}</div>
                    </div>
                    <div class="info-card">
                        <span class="info-label">ID Pelanggan</span>
                        <div class="info-value">#{{ $pelanggan->id }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        @php
            $totalSetoran = $transaksis->count();
            $totalBerat = 0;
            foreach ($transaksis as $transaksi) {
                $totalBerat += (float) ($transaksi->berat ?? 0);
            }
        @endphp

        <div class="stats-grid">
            <div class="stat-card stat-green">
                <div class="stat-icon"><i class="fas fa-recycle"></i></div>
                <div>
                    <span class="stat-number">{{ $totalSetoran }}</span>
                    <span class="stat-label">Total Setoran</span>
                </div>
            </div>
            <div class="stat-card stat-blue">
                <div class="stat-icon"><i class="fas fa-weight-hanging"></i></div>
                <div>
                    <span class="stat-number">{{ number_format($totalBerat, 1) }} kg</span>
                    <span class="stat-label">Total Berat</span>
                </div>
            </div>
            <div class="stat-card stat-yellow">
                <div class="stat-icon"><i class="fas fa-star"></i></div>
                <div>
                    <span class="stat-number">{{ number_format($pelanggan->poin ?? 0) }}</span>
                    <span class="stat-label">Poin</span>
                </div>
            </div>
        </div>

        {{-- RIWAYAT --}}
        <div class="history-card">

            <div class="history-header">
                <h2>Riwayat Setoran</h2>
                <span>{{ $transaksis->count() }} transaksi</span>
            </div>

            @if($transaksis->count())

                <div class="table-wrap">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>TANGGAL</th>
                                <th>JENIS SAMPAH</th>
                                <th>BERAT</th>
                                <th>METODE</th>
                                <th>STATUS</th>
                                <th>APPROVAL</th>
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
                                    $status = $statusMap[$transaksi->status] ?? ['label' => ucfirst($transaksi->status), 'class' => 'pending'];
                                @endphp

                                <tr>
                                    <td><span class="id-badge">#{{ $transaksi->id }}</span></td>
                                    <td>{{ $transaksi->created_at ? $transaksi->created_at->format('d M Y, H:i') : '-' }}</td>
                                    <td>{{ $jenis }}</td>
                                    <td><strong>{{ number_format($berat, 1) }}</strong> kg</td>
                                    <td>{{ ucfirst($transaksi->metode ?? '-') }}</td>
                                    <td><span class="status {{ $status['class'] }}">{{ $status['label'] }}</span></td>

                                    {{-- KOLOM APPROVAL --}}
                                    <td>
                                        @if($transaksi->status === 'pending')
                                            <form action="{{ route('admin.transaksi.approve', $transaksi->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PATCH')

                                                <div style="display:flex; flex-wrap:wrap; gap:6px; align-items:center;">
                                                    <input type="number" 
                                                           name="berat_akhir" 
                                                           step="0.01" 
                                                           value="{{ number_format($berat, 2) }}" 
                                                           class="form-control" 
                                                           style="width:80px; padding:4px 6px; font-size:0.75rem; border-radius:6px; border:1px solid #d1d9e0;"
                                                           required>

                                                    <button type="submit" name="status" value="disetujui" 
                                                            class="btn btn-success btn-sm" 
                                                            style="padding:4px 10px; font-size:0.7rem; background:#059669; color:#fff; border:none; border-radius:6px; cursor:pointer;">
                                                        Setujui
                                                    </button>

                                                    <button type="submit" name="status" value="ditolak" 
                                                            class="btn btn-danger btn-sm" 
                                                            style="padding:4px 10px; font-size:0.7rem; background:#dc2626; color:#fff; border:none; border-radius:6px; cursor:pointer;">
                                                        Tolak
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <span style="font-size:0.7rem; color:#98a2b3;">Telah diproses</span>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else

                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                    <h3>Belum ada setoran</h3>
                    <p>Pelanggan ini belum memiliki riwayat setoran.</p>
                </div>

            @endif

        </div>

    </div>

</div>

@endsection