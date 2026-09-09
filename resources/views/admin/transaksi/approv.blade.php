@extends('layouts.admin')

@section('title', 'Konfirmasi Persetujuan Transaksi')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Konfirmasi Persetujuan Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                <strong>Perhatian!</strong> Apakah Anda yakin ingin menyetujui transaksi ini? Tindakan ini tidak dapat dibatalkan.
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
                <tr>
                    <th>Status Saat Ini</th>
                    <td>{{ ucfirst($transaksi->status) }}</td>
                </tr>
            </table>

            <div class="mt-4">
                <!-- Form ini POST ke route approve -->
                <form action="{{ route('transaksi.approve', $transaksi->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Ya, Setujui Transaksi
                    </button>
                </form>

                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal / Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection