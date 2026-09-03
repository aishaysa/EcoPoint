@extends('layouts.user')

@section('title', 'Detail Setoran')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2"><i class="fas fa-info-circle text-success me-2"></i> Detail Setoran</h1>
        <div>
            {{-- PERBAIKAN: Hapus backslash di route ini --}}
            <a href="{{ route('user.setoran') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>

            {{-- Hanya tampilkan tombol batalkan jika statusnya menunggu --}}
            @if($setoran->status == 'menunggu')
                <form action="{{ route('user.setoran.cancel', $setoran->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan setoran ini?')">
                        <i class="fas fa-times me-1"></i> Batalkan
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title fw-bold">Informasi Pengirim</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="120" class="text-secondary">Nama</td>
                            <td>: {{ $setoran->nama_pengirim }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary">No. HP</td>
                            <td>: {{ $setoran->no_hp }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary">Metode</td>
                            <td>: {{ $setoran->metode == 'jemput' ? 'Dijemput Petugas' : 'Di antar ke titik kumpul' }}</td>
                        </tr>
                        <tr>
                            <td class="text-secondary">Status</td>
                            <td>: 
                                <span class="badge bg-{{ $setoran->status == 'selesai' ? 'success' : ($setoran->status == 'proses' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($setoran->status ?? 'Menunggu') }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5 class="card-title fw-bold">Detail Sampah</h5>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis Sampah</th>
                                <th class="text-center">Berat (kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($setoran->jenisSampahs as $js)
                            <tr>
                                <td>{{ $js->nama }}</td>
                                <td class="text-center">{{ $js->pivot->berat }}</td>
                            </tr>
                            @endforeach
                            <tr class="fw-bold bg-light">
                                <td>Total Berat</td>
                                <td class="text-center">{{ $setoran->jenisSampahs->sum('pivot.berat') }} kg</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>
            <div class="row mt-3">
                <div class="col-12">
                    <h5 class="card-title fw-bold">Alamat Penjemputan</h5>
                    <p class="text-secondary mb-0">{{ $setoran->alamat_jemput }}</p>
                    <small class="text-muted">Koordinat: {{ $setoran->latitude }}, {{ $setoran->longitude }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection