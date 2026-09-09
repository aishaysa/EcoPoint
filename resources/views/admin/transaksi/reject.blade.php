@extends('layouts.admin')

@section('title', 'Konfirmasi Penolakan Transaksi')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">Konfirmasi Penolakan Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-danger">
                <strong>Perhatian!</strong> Apakah Anda yakin ingin menolak transaksi ini? Poin tidak akan ditambahkan ke user.
            </div>

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Kode Transaksi</th>
                    <td>{{ $transaksi->kode ?? $transaksi->id }}</td>
                </tr>
                <tr>
                    <th>Nama User</th>
                    <td>{{ $transaksi->user->name ?? 'User tidak ditemukan' }}</td>
                </tr>
                <tr>
                    <th>Total Poin</th>
                    <td>{{ $transaksi->points ?? $transaksi->total_poin }}</td>
                </tr>
            </table>

            <!-- Form ini POST ke route reject -->
            <form action="{{ route('transaksi.reject', $transaksi->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="alasan">Alasan Penolakan (Opsional)</label>
                    <textarea name="alasan" id="alasan" class="form-control" rows="3" placeholder="Tuliskan alasan penolakan..."></textarea>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Ya, Tolak Transaksi
                    </button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal / Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection