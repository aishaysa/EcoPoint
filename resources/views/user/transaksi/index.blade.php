{{-- resources/views/user/home.blade.php --}}
@extends('layouts.user')

@section('title', 'Dashboard')
@section('page_title', 'Setoran Saya')

@push('styles')
<style>
    .stat-card {
        @apply bg-white rounded-xl shadow-md p-4 text-center border border-gray-100;
    }
    .stat-number {
        @apply text-2xl font-bold text-green-700;
    }
    .stat-label {
        @apply text-xs font-medium text-gray-500 uppercase tracking-wider;
    }
    .transaction-card {
        @apply bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition;
    }
    .status-badge {
        @apply inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold;
    }
    .status-badge.pending {
        @apply bg-yellow-100 text-yellow-800;
    }
    .status-badge.approved {
        @apply bg-blue-100 text-blue-800;
    }
    .status-badge.completed {
        @apply bg-green-100 text-green-800;
    }
    .status-badge.rejected {
        @apply bg-red-100 text-red-800;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    {{-- Statistik --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="stat-card">
            <div class="stat-number">{{ $transaksi->count() }}</div>
            <div class="stat-label">Total Setoran</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($transaksi->sum('berat'), 1) }} kg</div>
            <div class="stat-label">Total Berat Sampah</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($pelanggan->poin ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Poin Anda</div>
        </div>
    </div>

    {{-- Daftar Setoran --}}
    @if($transaksi->isEmpty())
        <div class="text-center py-12 bg-white rounded-xl shadow-sm">
            <i class="fas fa-box-open text-5xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">Belum ada setoran. Yuk, mulai setor sampah!</p>
            <a href="{{ route('user.transaksi.create') }}" class="inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-plus"></i> Setor Sekarang
            </a>
        </div>
    @else
        @foreach($transaksi as $item)
        <div class="transaction-card mb-4">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-sm text-gray-500">{{ $item->created_at->format('d M Y, H:i') }}</div>
                    <div class="font-semibold text-gray-800">{{ $item->pelanggan->nama ?? 'User' }}</div>
                    <div class="text-sm text-gray-600">{{ number_format($item->berat, 1) }} kg</div>
                    <div class="text-sm font-medium">{{ $item->jenisSampah->nama ?? $item->jenis_sampah ?? '-' }}</div>
                    @if($item->alamat_jemput)
                        <div class="text-xs text-gray-500"><i class="fas fa-map-marker-alt"></i> {{ $item->alamat_jemput }}</div>
                    @endif
                </div>
                <div class="text-right">
                    <span class="status-badge {{ $item->status }}">{{ ucfirst($item->status) }}</span>
                    <div class="mt-2">
                        <a href="{{ route('user.transaksi.detail', $item->id) }}" class="text-sm text-green-600 hover:underline">
                            Detail <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-xs text-gray-400 mt-2">ID: #{{ $item->id }}</div>
        </div>
        @endforeach
    @endif

</div>
@endsection