@extends('layouts.admin')

@section('title', 'Setoran Ditolak')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Setoran Ditolak</h3>
            <div class="card-tools">
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali ke Semua Setoran
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($transaksis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Jenis Sampah</th>
                                <th>Berat (kg)</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal Ditolak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $transaksi)
                            <tr>
                                <td>#{{ $transaksi->id }}</td>
                                <td>{{ $transaksi->pelanggan->nama ?? 'Tidak diketahui' }}</td>
                                <td>{{ $transaksi->jenisSampah->nama ?? '-' }}</td>
                                <td>{{ number_format($transaksi->berat, 2) }}</td>
                                <td>{{ ucfirst($transaksi->metode ?? '-') }}</td>
                                <td>
                                    <span class="badge bg-danger">Ditolak</span>
                                </td>
                                <td>{{ $transaksi->updated_at ? $transaksi->updated_at->format('d M Y, H:i') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.pelanggan.show', $transaksi->pelanggan_id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail Pelanggan
                                    </a>
                                    <form action="{{ route('admin.transaksi.destroy', $transaksi->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus transaksi ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $transaksis->links() }}
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-4x text-muted mb-3"></i>
                    <h4>Belum ada setoran yang ditolak</h4>
                    <p class="text-muted">Semua setoran masih dalam proses atau sudah disetujui.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection