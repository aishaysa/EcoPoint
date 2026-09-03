@extends('layouts.user')

@section('title', 'Detail Setoran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Setoran</h1>
        <a href="{{ route('user.setoran') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">ID Setoran</p>
                <p class="font-semibold text-gray-800">#{{ $transaksi->id }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal</p>
                <p class="font-semibold text-gray-800">{{ $transaksi->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama Pengirim</p>
                <p class="font-semibold text-gray-800">{{ $transaksi->nama_pengirim }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">No. HP</p>
                <p class="font-semibold text-gray-800">{{ $transaksi->no_hp }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Alamat Jemput</p>
                <p class="font-semibold text-gray-800">{{ $transaksi->alamat_jemput }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Latitude</p>
                <p class="font-semibold text-gray-800">{{ $transaksi->latitude ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Longitude</p>
                <p class="font-semibold text-gray-800">{{ $transaksi->longitude ?? '-' }}</p>
            </div>
        </div>

        <hr class="my-6">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">Daftar Jenis Sampah</h2>
        @if($transaksi->jenisSampahs->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Jenis Sampah</th>
                            <th class="px-4 py-2 text-right">Berat (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->jenisSampahs as $jenis)
                            <tr class="border-b border-gray-100">
                                <td class="px-4 py-2">{{ $jenis->nama }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($jenis->pivot->berat, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold">
                        <tr>
                            <td class="px-4 py-2">Total</td>
                            <td class="px-4 py-2 text-right">{{ number_format($transaksi->jenisSampahs->sum('pivot.berat'), 2) }} kg</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <p class="text-gray-500">Tidak ada jenis sampah yang dicatat.</p>
        @endif
    </div>
</div>
@endsection