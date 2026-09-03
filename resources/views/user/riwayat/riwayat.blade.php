@extends('layouts.user')

@section('title', 'Riwayat Penukaran Poin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2"><i class="fas fa-exchange-alt text-success me-2"></i> Riwayat Penukaran Poin</h1>
        <a href="{{ route('user.transaksi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tukar Poin
        </a>
    </div>

    {{-- Total poin & total uang --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card bg-success bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="display-4 fw-bold text-success">{{ auth()->user()->pelanggan->poin ?? 0 }}</div>
                    <div class="text-secondary">Total Poin Anda</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-primary bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="display-4 fw-bold text-primary">Rp {{ number_format($transaksis->sum('nominal') ?? 0, 0, ',', '.') }}</div>
                    <div class="text-secondary">Total Uang Diterima</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel riwayat --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-list me-2"></i> Daftar Penukaran</div>
        <div class="card-body">
            @if($transaksis->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Poin Ditukar</th>
                                <th>Nominal (Rp)</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $item)
                                <tr>
                                    <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                    <td>{{ $item->poin_ditukar }}</td>
                                    <td>{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status == 'sukses' ? 'success' : ($item->status == 'proses' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($item->status ?? 'Menunggu') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.riwayat.detail', $item->id) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    {{ $transaksis->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-coins fa-3x text-secondary mb-3 d-block"></i>
                    <p class="text-secondary">Belum ada riwayat penukaran.</p>
                    <a href="{{ route('user.transaksi.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-1"></i> Tukar Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection