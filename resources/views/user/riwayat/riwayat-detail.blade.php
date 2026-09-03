@extends('layouts.user')

@section('title', 'Detail Transaksi #' . $transaksi->id)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2"><i class="fas fa-info-circle text-success me-2"></i> Detail Transaksi</h1>
        <a href="{{ route('user.riwayat') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">
            <i class="fas fa-exchange-alt me-2"></i> Informasi Penukaran
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><th width="150">ID Transaksi</th><td>#{{ $transaksi->id }}</td></tr>
                        <tr><th>Tanggal</th><td>{{ $transaksi->created_at->format('d M Y, H:i') }}</td></tr>
                        <tr><th>Poin Ditukar</th><td>{{ $transaksi->poin_ditukar }}</td></tr>
                        <tr><th>Nominal</th><td>Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr><th width="150">Status</th>
                            <td>
                                <span class="badge bg-{{ $transaksi->status == 'sukses' ? 'success' : ($transaksi->status == 'proses' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($transaksi->status ?? 'Menunggu') }}
                                </span>
                            </td>
                        </tr>
                        @if($transaksi->status == 'sukses')
                        <tr><th>Tanggal Sukses</th><td>{{ $transaksi->updated_at->format('d M Y, H:i') }}</td></tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($transaksi->status == 'sukses')
        <div class="alert alert-success mt-4">
            <i class="fas fa-check-circle me-2"></i> Transaksi ini telah berhasil. Dana sudah ditransfer ke rekening Anda.
        </div>
    @endif
</div>
@endsection