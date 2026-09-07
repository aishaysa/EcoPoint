
@section('title', 'Riwayat Setoran')

@section('content')
<div>
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; margin-bottom:20px;">
        <h2 style="font-size:28px; font-weight:800; margin:0;">
            <i class="fas fa-history" style="color:#2e7d5a;"></i> Riwayat Setoran
        </h2>
        <a href="{{ route('user.transaksi.create') }}" class="btn-primary btn-success">
            <i class="fas fa-plus"></i> Setor Baru
        </a>
    </div>

    <!-- Statistik -->
    <div class="stat-box">
        <div class="stat-item">
            <div class="number">{{ $totalSetoran }}</div>
            <div class="label">Total Setoran</div>
        </div>
        <div class="stat-item">
            <div class="number">{{ number_format($totalBerat, 2) }} kg</div>
            <div class="label">Total Berat</div>
        </div>
        <div class="stat-item">
            <div class="number">{{ number_format($totalPoin) }}</div>
            <div class="label">Total Poin</div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card" style="padding:20px;">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Metode</th>
                        <th>Berat (kg)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $trx)
                        <tr>
                            <td>#{{ $trx->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                            <td>{{ ucfirst($trx->metode) }}</td>
                            <td>{{ number_format($trx->berat, 2) }}</td>
                            <td>
                                <span class="badge-status badge-{{ $trx->status }}">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('user.transaksiDetail', $trx->id) }}" class="btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('user.cetakTransaksi', $trx->id) }}" class="btn-primary btn-sm btn-outline" style="margin-top:4px; display:inline-block;">
                                    <i class="fas fa-print"></i> Cetak
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px 0; color:#2d5a43;">
                                <i class="fas fa-box-open" style="font-size:40px; display:block; margin-bottom:8px;"></i>
                                Belum ada setoran. Yuk, mulai setor sekarang!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($transaksis->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection